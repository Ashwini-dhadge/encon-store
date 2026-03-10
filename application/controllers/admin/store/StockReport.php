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
        if($post['item_group_id']!='all'){
             $where['ti.item_group'] = $post['item_group_id'];
        }
       
    }
     if(isset($post['item_name_id'])){
           if($post['item_name_id']!='all'){
                $where['iid.item_id'] = $post['item_name_id'];
           }
    }
    
    // $where[" date(i.created_at) BETWEEN '".$input_from_date."' AND '".$input_to_date."'"] = NULL;
    $input_from_date=$from_date_formatted;
    $input_to_date=$to_date_formatted;
         
    $item_groups_data = $this->StockReportModel->getStockItemGroupData($where,$input_from_date,$input_to_date);
    $input_previous_date = date('Y-m-d', strtotime('-1 day', strtotime($from_date_formatted)));  
    
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
   
    $input_financial_year_id=$financial_year_id;
    if(isset($post['company_id'])){
        $input_company_id = $post['company_id'];
    }
    if(isset($post['site_id'])){
        $input_site_id = $post['site_id'];
    }
 
    $get_opening_balance=$this->StockReportModel->getOpenItemStockAll($input_company_id,$input_site_id,$input_to_date,$input_previous_date,$is_first_day_opning,$input_financial_year_id);
    // echo $input_to_date."<br>";
    $get_recevied_balance=$this->StockReportModel->getReceivedItemStockAll($input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
    //  echo $this->db->last_query()."<br>";
    $get_issue_balance=$this->StockReportModel->getIssueItemStockAll($input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
    //  echo $this->db->last_query()."<br>";
    // 
    
    // echo "<pre>";
    // // print_r($get_opening_balance);
    // print_r($get_recevied_balance);
    // print_r($get_issue_balance);
    // die;
    //   echo $this->db->last_query();die;
   // Build lookup arrays for quick access using key "item_id_item_unit_id"
// Build lookup arrays for fast access using "item_id_item_unit_id" as key
$opening_data  = [];
$received_data = [];
$issued_data   = [];

foreach ($get_opening_balance as $row) {
    $opening_data[$row['item_id'] . '_' . $row['item_unit_id']] = $row;
}

foreach ($get_recevied_balance as $row) {
    $received_data[$row['item_id'] . '_' . $row['item_unit_id']] = $row;
}

foreach ($get_issue_balance as $row) {
    $issued_data[$row['item_id'] . '_' . $row['item_unit_id']] = $row;
}

// Merge all mapped data into item groups
foreach ($item_groups_data as &$group) {
    if (!isset($group['items']) || !is_array($group['items'])) continue;

    // 🧹 Step 1: Deduplicate items using key
    $unique_items = [];
    foreach ($group['items'] as $item) {
        $key = $item['item_id'] . '_' . $item['item_unit_id'];
        $unique_items[$key] = $item; // last item wins (you may sum quantities if needed)
    }

    // 🛠 Step 2: Now process only unique items
    foreach ($unique_items as &$item) {
        $key = $item['item_id'] . '_' . $item['item_unit_id'];

        $opening  = $opening_data[$key]  ?? ['balance' => 0, 'total_amount' => 0];
        $received = $received_data[$key] ?? ['total_received' => 0, 'total_amount' => 0];
        $issued   = $issued_data[$key]   ?? ['total_issued' => 0, 'total_amount' => 0];

        $item['balance']         = (float) $opening['balance'];
        $item['opening_amount']  = (float) $opening['total_amount'];
        $item['total_received']  = (float) $received['total_received'];
        $item['received_amount'] = (float) $received['total_amount'];
        $item['total_issued']    = (float) $issued['total_issued'];
        $item['issued_amount']   = (float) $issued['total_amount'];
        $item['closing_qty']     = $item['balance'] + $item['total_received'] - $item['total_issued'];
        $item['closing_amount']  = $item['opening_amount'] + $item['received_amount'] - $item['issued_amount'];
    }
    unset($item);

    // 🔁 Replace old items with deduplicated ones
    $group['items'] = array_values($unique_items);
}
unset($group);



     
 
    // Fetch data from the model using the constructed $where array
    $data['item_detail'] = $item_groups_data;
    $data['from_date_formatted'] = $from_date_formatted;
    $data['to_date_formatted'] = $to_date_formatted;
    
    //  echo '<pre>';print_r($data);die;
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

public function generate_pdf_backup() {
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
        if($post['item_group_id']!='all'){
             $where['ti.item_group'] = $post['item_group_id'];
        }
       
    }
     if(isset($post['item_name_id'])){
           if($post['item_name_id']!='all'){
                $where['iid.item_id'] = $post['item_name_id'];
           }
    }
    
    // $where[" date(i.created_at) BETWEEN '".$input_from_date."' AND '".$input_to_date."'"] = NULL;
    $input_from_date=$from_date_formatted;
    $input_to_date=$to_date_formatted;
         
    $item_groups_data = $this->StockReportModel->getStockItemGroupData($where,$input_from_date,$input_to_date);
    $input_previous_date = date('Y-m-d', strtotime('-1 day', strtotime($from_date_formatted)));  
    
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
            
    //   echo $this->db->last_query();die;
     foreach($item_groups_data as $key_g=>$group){
         
         foreach($group['items'] as $key_i=>$item){
          
            $input_to_date=$to_date;
            $input_item_id=$item['item_id'];
            $input_item_unit_id=$item['item_unit_id'];
            if(isset($post['company_id'])){
                $input_company_id = $post['company_id'];
            }
            if(isset($post['site_id'])){
                $input_site_id = $post['site_id'];
            }
            
            $input_financial_year_id=$financial_year_id;
            //   echo $input_to_date;die;
            //balance total_amount
            $get_opening_balance=$this->StockReportModel->getOpenItemStock($input_company_id,$input_site_id,$input_to_date,$input_previous_date,$input_item_id,$input_item_unit_id,$is_first_day_opning,$input_financial_year_id);
            // echo $this->db->last_query();die;
            if(!empty($get_opening_balance['balance']) && isset($get_opening_balance['balance'])){
               
                // $item_groups_data[$key_g]['items'][$key_i]['opening_balance_query']=$this->db->last_query();
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance']=$get_opening_balance['balance'];
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance_amount']=$get_opening_balance['total_amount'];
            }else{
                // $item_groups_data[$key_g]['items'][$key_i]['opening_balance_query']=$this->db->last_query();
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance']=0;
                $item_groups_data[$key_g]['items'][$key_i]['opening_balance_amount']=0;
            }
            
            $input_from_date=$from_date_formatted;
            $input_to_date=$to_date_formatted;
         
            
            // print_r($input_from_date);die;
   			
            //total_received total_amount
            $get_recevied_balance=$this->StockReportModel->getReceivedItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
            // $rec_last_query=$this->db->last_query();;
            // $get_issue_balance=$this->StockReportModel->getIssueItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
            // print_r($get_recevied_balance);die;
            // echo $this->db->last_query();die;
            if(!empty($get_recevied_balance['total_received']) && isset($get_recevied_balance['total_received'])){
                // $item_groups_data[$key_g]['items'][$key_i]['total_recevied_query']=$rec_last_query;
                $item_groups_data[$key_g]['items'][$key_i]['total_recevied']=$get_recevied_balance['total_received'];
                $item_groups_data[$key_g]['items'][$key_i]['total_recevied_amount']=$get_recevied_balance['total_amount'];
            }else{
                //  $item_groups_data[$key_g]['items'][$key_i]['total_recevied_query']=$this->db->last_query();
                 $item_groups_data[$key_g]['items'][$key_i]['total_recevied']=0;
                 $item_groups_data[$key_g]['items'][$key_i]['total_recevied_amount']=0;
            }
            
            $get_issue_balance=$this->StockReportModel->getIssueItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id);
            // echo $this->db->last_query();die;
            //   print_r($get_issue_balance);die;
            if(!empty($get_issue_balance['total_issued']) && isset($get_issue_balance['total_issued'])){
                // $item_groups_data[$key_g]['items'][$key_i]['total_issued_query']=$this->db->last_query();
                $item_groups_data[$key_g]['items'][$key_i]['total_issued']=$get_issue_balance['total_issued'];
                $item_groups_data[$key_g]['items'][$key_i]['total_issued_amount']=$get_issue_balance['total_amount'];
            }else{
                //  $item_groups_data[$key_g]['items'][$key_i]['total_issued_query']=$this->db->last_query();
                 $item_groups_data[$key_g]['items'][$key_i]['total_issued']=0;
                 $item_groups_data[$key_g]['items'][$key_i]['total_issued_amount']=0;
            }
            
            if($item_groups_data[$key_g]['items'][$key_i]['opening_balance']==0 && $item_groups_data[$key_g]['items'][$key_i]['total_issued']==0 && $item_groups_data[$key_g]['items'][$key_i]['total_recevied']==0){
                  unset($item_groups_data[$key_g]['items'][$key_i]);
            }
            
            
         }
     }
     
 
    // Fetch data from the model using the constructed $where array
    $data['item_detail'] = $item_groups_data;
    $data['from_date_formatted'] = $from_date_formatted;
    $data['to_date_formatted'] = $to_date_formatted;
    
    //  echo '<pre>';print_r($data);die;
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
     public function deleteSiteZeroStockData1()
    {
        $site_id = 39;
        $deleted_by = userId(); // Current user ID
        $deleted_at = date('Y-m-d H:i:s');
        $deleted_reason = "As of 05-01-2026, all data starting with zero stock has been deleted from the backend.";
        
        $response = array();
         
        try {
            // 1. Soft delete material_issue records
            $this->db->update('tbl_material_issue', array(
                'deleted_by' => $deleted_by,
                'deleted_at' => $deleted_at,
                'deleted_reason' => $deleted_reason
            ), array('site_id' => $site_id));
            
            $response['material_issue_deleted'] = $this->db->affected_rows();
            
            // 2. Soft delete material_issue_items_details records with JOIN to get items from site_id 39
            $sql = "UPDATE tbl_material_issue_items_details i 
                    JOIN tbl_material_issue m ON m.id = i.issue_id 
                    SET i.deleted_by = ?, i.deleted_at = ? 
                    WHERE m.site_id = ?";
            
            $this->db->query($sql, array($deleted_by, $deleted_at, $site_id));
            $response['material_issue_items_details_deleted'] = $this->db->affected_rows();
            
            
            // 4. Soft delete items_opening_stock records
            $this->db->update('tbl_items_opening_stock', array(
                'deleted_by' => $deleted_by,
                'deleted_at' => $deleted_at
            ), array('site_id' => $site_id));
            
            $response['items_opening_stock_deleted'] = $this->db->affected_rows();
            
            // 5. Soft delete items_opening_stock_details records with JOIN to get items from site_id 39
            $sql_opening = "UPDATE tbl_items_opening_stock_details osd 
                            JOIN tbl_items_opening_stock os ON os.id = osd.opening_id 
                            SET osd.deleted_by = ?, osd.deleted_at = ? 
                            WHERE os.site_id = ?";
            
            $this->db->query($sql_opening, array($deleted_by, $deleted_at, $site_id));
            $response['items_opening_stock_details_deleted'] = $this->db->affected_rows();
           
            // 6. Soft delete GRN records
            $this->db->update('tbl_grn', array(
                'deleted_by' => $deleted_by,
                'deleted_at' => $deleted_at,
                'deleted_reason' => $deleted_reason
            ), array('site_id' => $site_id));
            
            $response['grn_deleted'] = $this->db->affected_rows();
            
            // 7. Soft delete GRN items details records with JOIN to get items from site_id 39
            $sql_grn = "UPDATE tbl_grn_items_details gid 
                        JOIN tbl_grn g ON g.id = gid.grn_id 
                        SET gid.deleted_by = ?, gid.deleted_at = ? 
                        WHERE g.site_id = ?";
            
            $this->db->query($sql_grn, array($deleted_by, $deleted_at, $site_id));
            $response['grn_items_details_deleted'] = $this->db->affected_rows();
            
            // 8. Soft delete recevied_material_issue records
            $this->db->update('tbl_recevied_material_issue', array(
                'deleted_by' => $deleted_by,
                'deleted_at' => $deleted_at,
                'deleted_reason' => $deleted_reason
            ), array('site_id' => $site_id));
            
            $response['recevied_material_issue_deleted'] = $this->db->affected_rows();
            
            // 9. Soft delete recevied_material_issue_items_details records with JOIN to get items from site_id 39
            $sql_received = "UPDATE tbl_recevied_material_issue_items_details rid 
                             JOIN tbl_recevied_material_issue r ON r.id = rid.received_id 
                             SET rid.deleted_by = ?, rid.deleted_at = ? 
                             WHERE r.site_id = ?";
            
            $this->db->query($sql_received, array($deleted_by, $deleted_at, $site_id));
            $response['recevied_material_issue_items_details_deleted'] = $this->db->affected_rows();

            
            // 10. Hard delete inventory_details records where is_deleted = 1
            $this->db->delete('tbl_items_inventory', array('site_id' => $site_id));
            $response['inventory_details_deleted'] = $this->db->affected_rows();
            
            // 11. Hard delete stock_inventory records
              $this->db->update('tbl_items_inventory_details', array(
                'is_deleted' => $deleted_by               
            ), array('site_id' => $site_id));           
            $response['stock_inventory_deleted'] = $this->db->affected_rows();
            
            $response['status'] = 'success';
            $response['message'] = 'Zero stock data deleted successfully';
                       
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        }
        
        echo json_encode($response);
    }
}