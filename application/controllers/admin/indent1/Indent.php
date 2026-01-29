<?php
/**
 * 
 */
class Indent extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'indent/IndentModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Indent';
       
      $this->load->view(ADMIN.'indent/list_indent',$data);
    }

  public function add_indent($id='') {

    $data['indentNumber'] = $this->generateIndentNumber();
    if(!empty($id)){
            $where=array();
           $indentData = $this->IndentModel->getindentData('',0,0,0,0,$id,$where);
           $data['indentData'] =  $indentData[0];

    }
    $this->load->view(ADMIN.'indent/add_indent', $data);
}

private function generateIndentNumber() {
    // Generate the indent number based on the current date and time
    $prefix = "IN-".userId('site_inital')."-".time(); // Prefix with "IN-" and current date/time in YYYYMMDDHHMMSS format
    // You can add additional formatting or logic here if needed
    return $prefix;
}

public function open_modal_indent_master()
{      

            $master_indent_id = $this->input->post('master_indent_id');
            $indent_id = $this->input->post('indent_id');
            $id = $this->input->post('id');

            if(isset($master_indent_id)){
              $master_indent_tbl=$this->CommonModel->getData('tbl_master_indent_for',array('id'=>$master_indent_id),'','','row_array'); 
              if(isset( $master_indent_tbl['db_view_modal_name'])){
                if(isset($id) && $id!=0){
                  $data=array();
                  $sub_tbl_data=$this->CommonModel->getData($master_indent_tbl['db_table_name'],array('id'=>$id),'','','row_array'); 
                //  echo $this->db->last_query();die;
                  $data=$sub_tbl_data;
                }else{
                  $data=array();
                }

                 $html = $this->load->view(ADMIN.'indent/'.$master_indent_tbl['db_view_modal_name'], $data,true);   
                 if ($html) {
                    $response['html'] = $html;
                    $response['result'] = true;
                    $response['reason'] = 'Data Found';
                  }else{
                    $response['result'] = false;
                    $response['reason'] = 'Something went to wrong!1';
                  }
              }else{
                    $response['result'] = false;
                    $response['reason'] = 'Something went to wrong!2';
              }
            }else{
                    $response['result'] = false;
                    $response['reason'] = 'Something went to wrong!3';
            }
            echo json_encode($response);
  }

     
  
        
  public function listIndentName($value = '')
 {
    if (!isset($_GET['searchTerm'])) {
        $json = [];
        $indentData = $this->IndentModel->getindentName('');
    } else {
        $search = $_GET['searchTerm'];
        $indentData = $this->IndentModel->getindentName($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($indentData as $key => $value) {
        
        $json[] = ['id' => $value['id'], 'text' => $value['indent_name']];
    }
    echo json_encode($json);
}


  public function listclientName($value = '')
 {
    if (!isset($_GET['searchTerm'])) {
        $json = [];
        $clientData = $this->IndentModel->getclientName('');
    } else {
        $search = $_GET['searchTerm'];
        $clientData = $this->IndentModel->getclientName($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($clientData as $key => $value) {
        
        $json[] = ['id' => $value['id'], 'text' => $value['company_name']];
    }
    echo json_encode($json);
}



 public function listplantName($value = '')
 {
    if (!isset($_GET['searchTerm'])) {
        $json = [];
        $plantData = $this->IndentModel->getplantName('');
    } else {
        $search = $_GET['searchTerm'];
        $plantData = $this->IndentModel->getplantName($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($plantData as $key => $value) {
        
        $json[] = ['id' => $value['id'], 'text' => $value['short_name']];
    }
    echo json_encode($json);
}

                    // 


   
    public function saveIndent(){
      $post = $this->input->post();
        if (!empty($post['date'])) {                     
              $converted_date = date('Y-m-d',strtotime($post['date']));
          }else{
             $converted_date = date('Y-m-d');
          }

        $array_indent = array(

                      'client_id' => isset($post['client_id']) ? $post['client_id'] : '',
                      'indent_no' => isset($post['indent_no']) ? $post['indent_no'] : '',
                      'date' =>$converted_date,
                      'created_by'=>userId()
                  );
        // print_r( $array_indent);die;
        if(isset($post['id'])&& !empty($post['id'])){
                unset($array_indent['created_by']);
                $array_indent['updated_at'] =date('Y-m-d H:i:s') ;
                 $array_indent['updated_by'] =userId();
                 
 
              $indent_id = $this->CommonModel->iudAction('tbl_indent',$array_indent,'update',array('id'=>$post['id']));
        }else{
              $indent_id = $this->CommonModel->iudAction('tbl_indent',$array_indent,'insert');
        }
       //echo $this->db->last_query();die;
       //  echo  $indent_id;
           if ($indent_id)
            {
                          $response['indentId'] = $indent_id;
                          $response['result'] = true;
                          $response['reason'] = 'Data Found';
             }else{
                          $response['result'] = false;
                          $response['reason'] = 'Something went to wrong!';
             }
                        echo json_encode($response);
    }   

    public function saveIndentAllModule(){
       $post = $this->input->post();

       if(isset($post['master_indent_id'])){
        $master_indent_tbl=$this->CommonModel->getData('tbl_master_indent_for',array('id'=>$post['master_indent_id']),'id,db_table_name','','row_array'); 
        if(isset( $master_indent_tbl['db_table_name'])){
            if(isset($post['id']) &&!empty($post['id'])){             
              $post['updated_by']=userId();
              $post['updated_at']=date('Y-m-d H:i:s');
              $indent_module_id=$post['id'];
              $this->CommonModel->iudAction( $master_indent_tbl['db_table_name'],$post,'update',array('id'=>$post['id']));
            }else{
              $post['created_by']=userId();
              $indent_module_id=$this->CommonModel->iudAction( $master_indent_tbl['db_table_name'],$post,'insert');
                          $data_details_data=array(
                                      'indent_id'=>$post['indent_id'],
                                      'plant_id'=>$post['plant_id'],
                                      'master_indent_id'=>$post['master_indent_id'],
                                      'ref_id'=>$indent_module_id,
                                      'created_by'=>userId(),
                                      'created_at'=>date('Y-m-d H:i:s')
                                  );
               $this->CommonModel->iudAction('tbl_indent_details',$data_details_data,'insert');
            }




             
             // $response['tbody'] =$this->getTableViewLoad($post['master_indent_id'],$indent_module_id);
              $response['result'] = true;
              $response['reason'] = 'Data Found';
        }else{
            $response['result'] = false;
            $response['reason'] = 'Indent datbase for not found';
        }
  
       }else{
            $response['result'] = false;
            $response['reason'] = 'Indent for not found';
       }
         echo json_encode($response);
    }


    public function getTableViewLoad($master_indent_id,$indent_module_id){
        $master_indent_tbl=$this->CommonModel->getData('tbl_master_indent_for',array('id'=>$master_indent_id),'','','row_array'); 
        $tbodyHtml='';
        if(isset($master_indent_tbl['db_table_name'])){
            $sub_tbl_data=$this->CommonModel->getData($master_indent_tbl['db_table_name'],array('id'=>$indent_module_id),'','','row_array'); 
            $plant_info=$this->CommonModel->getData('tbl_site',array('id'=>$sub_tbl_data['plant_id']),'','','row_array'); 
            $output='';
            foreach ($sub_tbl_data as $key => $value) {
               if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
                $output .= ucfirst(str_replace("_", " ", $key)) . ": $value\n";
            }
                
            }
            $confirm = "confirm('Are you sure you want to delete this ?')";

            $action ='<a href="javascript:void(0);" title="Edit" onclick="open_modal_indent_blade('.$master_indent_id.','.$sub_tbl_data['indent_id'].','.$indent_module_id.')" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
            $action .= '<a href="javascript:void(0);"  onclick="open_modal_indent_delete_blade('.$master_indent_id.','.$sub_tbl_data['indent_id'].','.$indent_module_id.')" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
            $qty=isset($sub_tbl_data[$master_indent_tbl['db_qty_field_name']])?$sub_tbl_data[$master_indent_tbl['db_qty_field_name']]:0;
            $tbodyHtml='<tr id="tr_indent_'.$indent_module_id.'"><th width="20px"><br>1</th><th>'.$plant_info['site_name'].'</th><th>'.$master_indent_tbl['indent_name'].'</th><th>'.$output .'</th><th>'.$qty.'</th><td>'.$action.'</td></tr>';
 
           
        }
        return $tbodyHtml;

    }

    function getIndentModuleDetailsData(){

        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
    
        $where = array();
        $where['ti.indent_id'] = $data['indent_id'];

        $count = count($this->IndentModel->getIndentModuleData($searchVal,0,0,0,0,0,$where));
        if($count){
            $result = $this->IndentModel->getIndentModuleData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
            // echo $this->db->last_query();die;
                foreach ($result as $key1 => $value1) {
                    $flag=$own_flag_access=0;
                    $row = []; 
                  
                    array_push($row, $offset + ($key1 + 1));
                    array_push($row, $value1['site_name']);
                    array_push($row, $value1['indent_name']);

                    //desc
                    $sub_tbl_data=$this->CommonModel->getData($value1['db_table_name'],array('id'=>$value1['ref_id']),'','','row_array');
                    if(!empty($sub_tbl_data)){
                      $output='';
                          foreach ($sub_tbl_data as $key => $value) {
                            if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
                              $output .= ucfirst(str_replace("_", " ", $key)) . ": $value\n";
                              }
                          }
                          $qty=isset($sub_tbl_data[$value1['db_qty_field_name']])?$sub_tbl_data[$value1['db_qty_field_name']]:0;
                   }else{
                    $output='';
                     $qty=0;
                   }
                    

                   
                    array_push($row, $output);
                    array_push($row, $qty);
                     
                    $confirm = "confirm('Are you sure you want to delete this PO?')";
                    $action ='<a href="javascript:void(0);" title="Edit" onclick="open_modal_indent_blade('.$value1['master_indent_id'].','.$value1['indent_id'].','.$value1['ref_id'].')" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                    $action .= '<a href="javascript:void(0);"  onclick="open_modal_indent_delete_blade('.$value1['master_indent_id'].','.$value1['indent_id'].','.$value1['ref_id'].')" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                                            
                     array_push($row, $action);
                     $columns[] = $row;
               }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ];
        echo json_encode($response);
    }

    function deleteModuleIndent(){
      $post = $this->input->post();

       if(isset($post['master_indent_id'])){
        $master_indent_tbl=$this->CommonModel->getData('tbl_master_indent_for',array('id'=>$post['master_indent_id']),'id,db_table_name','','row_array'); 
        if(isset( $master_indent_tbl['db_table_name'])){
          if(isset($post['id']) &&!empty($post['id'])){             
              $post['deleted_by']=userId();
              $post['deleted_at']=date('Y-m-d H:i:s');
              $indent_module_id=$post['id'];
              $this->CommonModel->iudAction( $master_indent_tbl['db_table_name'],$post,'update',array('id'=>$post['id']));
              $this->CommonModel->iudAction('tbl_indent_details',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('indent_id'=>$post['indent_id'],'ref_id'=>$post['id']));                         
             // $response['tbody'] =$this->getTableViewLoad($post['master_indent_id'],$indent_module_id);
              $response['result'] = true;
              $response['reason'] = 'Indent For Deleted ';
        
         }else{
              $response['result'] = false;
              $response['reason'] = 'Indent for not found';
         }
        }else{
            $response['result'] = false;
            $response['reason'] = 'Indent for not found';
       }
         echo json_encode($response);
    }
    }

    public function listindent()
   {

     $data = $_POST;
         $columns = [];
         $page = $data['draw'];
         $limit = $data['length'];
         $offset = $data['start'];
         $searchVal = $data['search']['value'];
         $sortColIndex = $data['order'][0]['column'];
         $sortBy = $data['order'][0]['dir'];
         $where = array();
          // print_r($data);die;
          


         $count = count($this->IndentModel->getindentData($searchVal,0,0,0,0,0,$where));
         // echo $this->db->last_query();die;
         if($count){
             $result = $this->IndentModel->getindentData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 // array_push($row, $value['company_name']);
                array_push($row, $value['client_name']);
                array_push($row, $value['indent_no']);
                array_push($row, $value['date']);
                $confirm = "confirm('Are you sure you want to delete this Service?')";

                $action = '<a href="'.base_url().'admin/indent/Indent/add_indent/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                $action .= '<a href="'.base_url().'admin/indent/Indent/viewIndentData/'.$value['id'].'" title="View" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                $action .= '<a href="'.base_url().'admin/indent/Indent/generate_pdf/'.$value['id'] .'" title="print indent" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-print" aria-hidden="true"></i></a>';

                array_push($row, $action);

                 $columns[] = $row;

             }
         }
         $response = [
             'draw' => $page,
             'data' => $columns,
             'recordsTotal' => $count,
             'recordsFiltered' => $count
         ];
         echo json_encode($response);
    
   }
   public function viewIndentData($id='', $indent_id='') {
        $indentviewData = $this->IndentModel->getindentData('', 0, 0, 0, 0, $id);
        $data['indentviewData'] = $indentviewData[0];
        $data['plant_data'] = $this->IndentModel->getSiteNameByIndentId($id); 
        $groupedIndentData = $this->IndentModel->getIndentViewData(array('ti.indent_id'=>$id),1);
     
        $indentData = [];
        foreach ($groupedIndentData as $key=>$record) {
            $indentData = $this->IndentModel->getIndentViewData(array('ti.indent_id'=>$id,'ti.plant_id'=>$record['plant_id']),0);
            $groupedIndentData[$key]['indent_details'] =  $indentData ;
        }
    
        $data['indent_specific_data'] = $groupedIndentData;
        $data['offset'] = 0; 
       
        $this->load->view(ADMIN.'indent/view_indent', $data);
    }
    public function generate_pdf($id='',$indent_id='') {
     $this->load->library('pdf');
    $post = $this->input->post();
    $where = array();
     $indentviewData = $this->IndentModel->getindentData('', 0, 0, 0, 0, $id);
    $data['indentviewData'] = $indentviewData[0];
    $data['plant_data'] = $this->IndentModel->getSiteNameByIndentId($id); 
    $groupedIndentData = $this->IndentModel->getIndentViewData(array('ti.indent_id'=>$id),1);
 
    $indentData = [];
    foreach ($groupedIndentData as $key=>$record) {
        $indentData = $this->IndentModel->getIndentViewData(array('ti.indent_id'=>$id,'ti.plant_id'=>$record['plant_id']),0);
        $groupedIndentData[$key]['indent_details'] =  $indentData ;
    }

    $data['indent_specific_data'] = $groupedIndentData;
    $data['offset'] = 0; 
    
    $htmlContent = $this->load->view(ADMIN.'indent/indentprint_report', $data, true);
  // print_r($htmlContent);die;
   
    $this->pdf->setPageOrientation('L'); // Set landscape orientation
    $this->pdf->AddPage();
    $this->pdf->SetMargins(5, 5, 5);
    $this->pdf->SetFont('helvetica', '', 12);
    $this->pdf->writeHTML($htmlContent, true, false, true, false, '');
    $this->pdf->Output('indent_report.pdf', 'I'); // 'I' for inline display
} 


   

}