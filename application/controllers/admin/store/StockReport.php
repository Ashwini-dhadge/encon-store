<?php
/**
 * 
 */
class StockReport extends CI_Controller
{
    
    function __construct()
    {
         parent::__construct();
         $this->load->model(ADMIN.'store/StockReportModel');
         $this->load->helper('file');
        $this->load->library('pdf');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'StockReport';
        $data['financial_years'] = $this->CommonModel->getData('tbl_master_financial_year',array('is_deleted'=>0),'id, to_date,from_date ,is_active');
        $this->load->view(ADMIN.'store/stock_report/add_stock_report',$data);
    
    }


   public function generate_pdf() {
    $post = $this->input->post();
    $where = array();
    
    if(isset($post) && !empty($post)){
        
    
    // Convert date strings to DateTime objects and format them
    if(isset($post['from_date'])){
        $from_date = DateTime::createFromFormat('d/m/Y', $post['from_date']);
        $from_date_formatted = $from_date->format('Y-m-d');
    }else{
        $from_date_formatted =date('Y-m-d');
    }
    
    
    if(isset($post['to_date'])){
        $to_date = DateTime::createFromFormat('d/m/Y', $post['to_date']);
        $to_date_formatted = $to_date->format('Y-m-d');
    }else{
        $to_date_formatted='';
    }
    
    // print_r($post);die;
    // Add conditions to $where array based on form inputs
    if(isset($post['company_id'])){
        $where['iid.company_id'] = $post['company_id'];
        $data['company_name'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$post['company_id']),' name ','','row_array');
    }
    $is_opening=1;
    if(isset($post['financial_year_id'])){
        $where['iid.financial_year_id'] = $post['financial_year_id'];
        $data['financial_years'] = $this->CommonModel->getData('tbl_master_financial_year',array('id'=>$post['financial_year_id']),'id, to_date,from_date ,is_active','','row_array');
        $to_date= $data['financial_years']['to_date'];
        $financial_year_id=$post['financial_year_id'];
    }else{
        $data['financial_years'] = $this->CommonModel->getData('tbl_master_financial_year',array('id'=>userId('financial_year_id')),'id, to_date,from_date ,is_active','','row_array');
        $to_date= $data['financial_years']['to_date'];
        $financial_year_id=userId('financial_year_id');
    }


    if(isset($post['site_id'])){
        $where['iid.site_id'] = $post['site_id'];
        $data['site_name'] = $this->CommonModel->getData('tbl_site',array('id'=>$post['site_id']),' site_name ','','row_array');
    }

    if(isset($post['item_group_id'])){
        $where['ti.item_group'] = $post['item_group_id'];
    }
     if(isset($post['item_name_id'])){
        $where['iid.item_id'] = $post['item_name_id'];
    }
   
     $item_groups_data = $this->StockReportModel->getStockItemGroupData($where);
    //   echo $this->db->last_query();die;
     foreach($item_groups_data as $key_g=>$group){
         
         foreach($group['items'] as $key_i=>$item){
            $input_previous_date = date('Y-m-d', strtotime('-1 day', strtotime($from_date_formatted))); 
            $input_to_date=$to_date;
            $input_item_id=$item['item_id'];
            $input_item_unit_id=$item['item_unit_id'];
            if(isset($post['company_id'])){
                $input_company_id = $post['company_id'];
            }
            if(isset($post['site_id'])){
                $input_site_id = $post['site_id'];
            }
            
           
            if(isset($from_date_formatted)){
                $get_date_from=date('d',strtotime($from_date_formatted));
                $get_month_from=date('m',strtotime($from_date_formatted));
                if(($get_date_from=='01' ||  $get_date_from==1) && ($get_month_from=='04' ||  $get_month_from==4)){
                    //$where_item['date(iid.created_at) =']=$from_date_formatted;
                   $is_first_day_opning=1;
                }else{
                     $is_first_day_opning=0;
                }
                
            }
            //balance total_amount
            $get_opening_balance=$this->StockReportModel->getOpenItemStock($input_company_id,$input_site_id,$input_to_date,$input_previous_date,$input_item_id,$input_item_unit_id,$is_first_day_opning);
            // echo $this->db->last_query();die;
            if(!empty($get_opening_balance['balance']) && isset($get_opening_balance['balance'])){
               
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance_query']=$this->db->last_query();
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance']=$get_opening_balance['balance'];
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance_amount']=$get_opening_balance['total_amount'];
            }else{
                 $item_groups_data[$key_g]['items'][$key_i]['opening_balance_query']=$this->db->last_query();
                 $item_groups_data[$key_g]['items'][$key_i]['opening_balance']=0;
                 $item_groups_data[$key_g]['items'][$key_i]['opening_balance_amount']=0;
            }
            
            


            $input_from_date=$from_date_formatted;
            $input_to_date=$to_date_formatted;
            $input_financial_year_id=$financial_year_id;
            
            // print_r($input_from_date);die;
   			
            //total_received total_amount
            $get_recevied_balance=$this->StockReportModel->getReceivedItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
            // echo $this->db->last_query();die;
            if(!empty($get_recevied_balance['total_received']) && isset($get_recevied_balance['total_received'])){
                  $item_groups_data[$key_g]['items'][$key_i]['total_recevied_query']=$this->db->last_query();
                $item_groups_data[$key_g]['items'][$key_i]['total_recevied']=$get_recevied_balance['total_received'];
                $item_groups_data[$key_g]['items'][$key_i]['total_recevied_amount']=$get_recevied_balance['total_amount'];
            }else{
                 $item_groups_data[$key_g]['items'][$key_i]['total_recevied_query']=$this->db->last_query();
                 $item_groups_data[$key_g]['items'][$key_i]['total_recevied']=0;
                 $item_groups_data[$key_g]['items'][$key_i]['total_recevied_amount']=0;
            }
            
            $get_issue_balance=$this->StockReportModel->getIssueItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
            // echo $this->db->last_query();die;
            if(!empty($get_issue_balance['total_issued']) && isset($get_issue_balance['total_issued'])){
                $item_groups_data[$key_g]['items'][$key_i]['total_issued_query']=$this->db->last_query();
                $item_groups_data[$key_g]['items'][$key_i]['total_issued']=$get_issue_balance['total_issued'];
                $item_groups_data[$key_g]['items'][$key_i]['total_issued_amount']=$get_issue_balance['total_amount'];
            }else{
                 $item_groups_data[$key_g]['items'][$key_i]['total_issued_query']=$this->db->last_query();
                 $item_groups_data[$key_g]['items'][$key_i]['total_issued']=0;
                 $item_groups_data[$key_g]['items'][$key_i]['total_issued_amount']=0;
            }
            
            
         }
     }
     
    // echo "<pre>";
    // print_r($item_groups_data);die;
    // Fetch data from the model using the constructed $where array
    $data['item_detail'] = $item_groups_data;
    $data['from_date_formatted'] = $from_date_formatted;
    $data['to_date_formatted'] = $to_date_formatted;
    
      //echo '<pre>';print_r($data);die;
    // Load the view with the retrieved data
    $htmlContent = $this->load->view(ADMIN.'store/stock_report/stock_report', $data, true);
    
    // Add your PDF generation logic
    $this->pdf->AddPage();
    $this->pdf->SetMargins(5, 5, 5);
    $this->pdf->SetFont('helvetica', '', 12);
    $this->pdf->writeHTML($htmlContent, true, false, true, false, '');
    $this->pdf->Output('stock_report.pdf', 'I'); // 'I' for inline display
    }else{
        redirect(base_url()."admin/store/StockReport");
    }
}


   
      public function listCompanyName($value='')
      {
          if(!isset($_GET['searchTerm'])){ 
              $json = [];
              $company_name=$this->StockReportModel->getCompanyName('');
          }else{
              $search = $_GET['searchTerm'];
              $company_name=$this->StockReportModel->getCompanyName($search);
          }
          
          foreach ($company_name as $key => $value) {
              if($value['id']==userId('company_id')){
                 $json[] = ['id'=>$value['id'], 'text'=>$value['name'],'selected'=> true];  
              }else{
                   $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
              }
             
          }

          echo json_encode($json);
      }
    

    public function listSite()
    {
        $search='';
        $where=array();
        $json = [];
        $search=isset($_GET['searchTerm'])?$_GET['searchTerm']:'';
        $company_id=isset($_REQUEST['company_id'])?$_REQUEST['company_id']:'';
        
        if(isset($search)){ 
             $search = $search;
        }else{
          
           $search = '';
        }

        if(isset($company_id) && !empty($company_id)){ 
             $where['company_id'] = $company_id;
        }
        $sites=$this->StockReportModel->getCompanySite($search,$where);
       
        foreach ($sites as $key => $value) {
        
                $json[] = ['id'=>$value['id'], 'text'=>$value['site_name']];
        }  
        echo json_encode($json);
    }
}