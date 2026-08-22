<?php
/**
 * 
 */
class MaterialIssue extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'store/MaterialIssueModel');
         $this->load->model(ADMIN.'CommonCustModel');
             $this->load->model(ADMIN . 'store/GRNModel');
        $this->load->model(ADMIN . 'POModel');
         
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'MaterialIssue';
       
      $this->load->view(ADMIN.'store/materialissue/list_materialissue',$data);
    }

   public function list_material_issue()
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
         
            if($data['company_id'] == 'all'){
                $where = array();
            }
            else if($data['company_id']){
                $where['mi.company_id'] = $data['company_id'];
            }
             if($data['site_id'] == 'all'){
            $where = array();
            }
            else if($data['site_id']){
                $where['mi.site_id'] = $data['site_id'];
            }

             if($data['vendor_id'] == 'all'){
            $where = array();
            }
            else if($data['vendor_id']){
                $where['mi.issue_from_vendor_id'] = $data['vendor_id'];
            }
            if(isset($data['issue_type']) && $data['issue_type'] != 'all') {
                $where['mi.issue_type'] = $data['issue_type'];
            }

            $on_date = $this->input->post('on_date');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');


            if ($on_date == 1) {
            $from_date = date('Y-m-d');
            $where['date(mi.issue_date)'] = date('Y-m-d',strtotime($from_date));
       
            }else if ($on_date == 2) {
            $from_date = date('Y-m-d', strtotime('-1 days'));
            $where['date(mi.issue_date)'] = date('Y-m-d',strtotime($from_date));
     
            }else if ($on_date == 3) {
            $from_date = date('Y-m-d', strtotime('last monday'));
            $to_date = date('Y-m-d', strtotime('next sunday'));
            $where['date(mi.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
            }else if ($on_date == 4) {
            $from_date = date('Y-m-d', strtotime('first day of this month'));
            $to_date = date('Y-m-d', strtotime('last day of this month'));
            $where['date(mi.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
       
            }else if ($on_date == 5) {
            $from_date = date('Y-m-d', strtotime('01/31'));
            $to_date = date('Y-m-d', strtotime('12/31'));
            $where['date(mi.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
         
            }else if($on_date == 6){
            $from = new DateTime($from_date);
            $to = new DateTime($to_date);
            $from_date = $from->format('Y-m-d 00:00:00');
            $to_date = $to->format('Y-m-d 23:59:59');
            $where['date(mi.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
        }
        if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
         }

       
         $count = count($this->MaterialIssueModel->getMaterialIssueData($searchVal,0,0,0,0,0,$where,$item_id));
         if($count){
               $result = $this->MaterialIssueModel->getMaterialIssueData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id);
            // echo '<pre>'; print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 
                 $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['id'].'" title="View Items">';
                 array_push($row, $offset+($key+1)." ".$html1);
                  array_push($row, $value['issue_number']);
                 array_push($row, dmyDate($value['issue_date']));
                 array_push($row, $value['company_name']);
                 array_push($row, $value['site_name']);
                
                 if($value['issue_type']==1){
                    array_push($row, "Consumption/Issue");
                 }else if($value['issue_type']==2){
                    array_push($row, "Transfer");
                 }else if($value['issue_type']==3){
                    array_push($row, "Production");
                 }else{
                    array_push($row, "-");
                 }
                 array_push($row, $value['issued_by_name']);
                 array_push($row, $value['request_by_name']);
                 array_push($row, $value['received_by_name']);
                 array_push($row, $value['department_name']);
                 array_push($row, $value['vender_name']);

                 $confirm = "confirm('Are you sure you want to delete this Material Issue?')";
                 $flag=$own_flag_access=0;
                if($value['created_by']==userId()){
                        $own_flag_access=1;
                }
                
                if((getUserAccessForModule('Store','edit')) || ($own_flag_access) || userId('role_id')==SUPERADMIN_ROLE ):
                    if(($value['issue_type']==2 && $value['is_transfer_completed']==0) || $value['issue_type']==1  || $value['issue_type']==3){
                          $action ='<a href="'.base_url().'admin/store/MaterialIssue/edit_material_issue/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;margin-left:5px" ><i class="fas fa-edit" aria-hidden="true"></i></a>';
                    }else{
                        $action='';
                    }
                  
                      
                endif; 
                
                $confirm = "confirm('Are you sure you want to delete this GRN . Its effect on item Inventory ?')";
                    if(getUserAccessForModule('Store','delete') || ($own_flag_access) || userId('role_id')==SUPERADMIN_ROLE):
                        // $action .= ' <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/store/GoodsReceiptNote/grnDelete/' . $value['grn_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                         $action .= '<a href="javascript:void(0)" data-toggle="modal" data-target="" title="delete" class="btn btn-primary waves-effect waves-light btn-sm deleteBtn"  onclick="deleteBtn('.$value['id'] .')"  data-toggle="tooltip" style="font-size:13px;color: gray !important;"><i class="fas fa-trash" aria-hidden="true"></i></a>';

                    endif;
                    
                  $action .='<a href="'.base_url().'admin/store/MaterialIssue/view_material_issue/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    
                    // $action = '<a href="'.base_url().'admin/store/MaterialIssue/add_materialissue/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
      
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
     public function issueDelete(){
       $flag=0;
       // $po_item_id=$post['po_item_id'];
        $post = $this->input->post();
        $issue_id=$post['issue_id'];
        if($issue_id ){
        
        $data = $this->CommonModel->getData('tbl_material_issue', array('id' => $issue_id), '', '', 'row_array');
        $item_data=$this->CommonModel->getData('tbl_material_issue_items_details', array('issue_id' => $issue_id,'deleted_by'=>NULL), '', '', '');
        
        // echo "<pre>";
        // print_r($grn_data);
        // print_r($grn_item_data);die;
        if(!empty($data) && !empty($item_data)){
             
                 //delete ISSUE  and GRN ITEM
                 
                $this->CommonModel->iudAction('tbl_material_issue',array('deleted_reason'=>$post['reason'],'deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$issue_id));
                // $this->CommonModel->iudAction('tbl_grn_attachment',array('deleted_at'=> date('Y-m-d H:i:s'),'deleted_by'=>userId()),'update',array('grn_id'=>$grn_id));
  
                foreach($item_data as $key=>$item){
                    $this->CommonModel->iudAction('tbl_material_issue_items_details',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$item['id']));   
                     //delete from inventory
                    updateQuickInventory($item['item_id'],$item['issue_qty_unit'],$item['issue_qty'],$data['company_id'],$data['site_id'],$data['financial_year_id'],INVENTORY_ACTION_ADD,ISSUE_TYPE,$issue_id,userId(),$item['batch_no'],$item['expired_date'],0,$item['id']);
                    
                   // echo $this->db->last_query();die;
                } 
 

                 
                $description="Material Issued deleted -".$data['issue_number']." by ".userId('name');
                $json_data_login=encode_arr($grn_data);
                //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');
        
                ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor 5:Store
                 //sub_ref_type:1 tbl_user
                $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,5,$grn_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
                updateInActionLogFile($data_action_log_array);
             
             //  $this->session->set_flashdata('success','PO Items Deleted');
               $response['result']=true;
               $response['reasons']="ISSUED Items Deleted";
        }else{
            $response['result']=false;
            $response['reasons']="Something Went Wrong";
           //  $this->session->set_flashdata('error','Something Went Wrong');
        }
       
          
        }else{
              $response['result']=false;
              $response['reasons']="Something Went Wrong";
             //   $this->session->set_flashdata('error','Something Went Wrong');
        }
         echo json_encode($response);

       //print_r($response); die;
       // redirect(base_url(ADMIN.'store/GoodsReceiptNote'));
    }

    public function list_material_issue_items_data()
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
         if($data['material_issue_id']){
            $where['mid.issue_id'] = $data['material_issue_id'];
         }
         $count = count($this->MaterialIssueModel->getMaterialIssueItemDataView($searchVal,0,0,0,0,0,$where));
        //  echo $this->db->last_query();die;
         if($count){
             $result = $this->MaterialIssueModel->getMaterialIssueItemDataView($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
            //   echo $this->db->last_query();die;
            // echo '<pre>'; print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));

                // $item_name = $this->CommonModel->getData('tbl_material_issue_items_details mid');

                 array_push($row, $value['short_name']);
                 array_push($row, $value['item_group_name']);
                  array_push($row, $value['issue_qty']);
                 array_push($row, $value['weight']);

                 
                 // if($value['issue_type']==1){
                 //    array_push($row, "Consumption/Issue");
                 // }else if($value['issue_type']==2){
                 //    array_push($row, "Transfer");
                 // }else if($value['issue_type']==3){
                 //    array_push($row, "Production");
                 // }else{
                 //    array_push($row, "-");
                 // }

                

                 array_push($row, $value['rate']);
                 if($value['amount']=='0.00' || $value['amount']=='0'){
                      array_push($row,($value['rate']*$value['issue_qty']));
                 }else{
                      array_push($row, $value['amount']);
                 }
                
                  
                 if($value['is_returnable']==1){
                    array_push($row, "Yes");
                 }else{
                    array_push($row, "No");
                 }

                 if($value['returnable_date']=="0000-00-00"){
                    array_push($row, "-");
                 }else{
                    array_push($row, dmyDate($value['returnable_date']));
                 }

                 array_push($row, $value['remark']);

              
                 $confirm = "confirm('Are you sure you want to delete this Material Issue?')";

                  // $action ='<a href="'.base_url().'admin/store/MaterialIssue/view_item_material_issue/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    
                  //   // $action = '<a href="'.base_url().'admin/store/MaterialIssue/add_materialissue/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
      
                  //   array_push($row, $action);

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


   public function view_material_issue($material_issue_id='')
    {
        $material_issue = $this->MaterialIssueModel->getMaterialIssueViewData($material_issue_id);
    //   echo  $this->db->last_query();die;
    if(isset( $material_issue[0])){
          $data = $material_issue[0];
            $data['items_material_issue'] = $this->MaterialIssueModel->getMaterialIssueItemData($material_issue_id);
            
            // print_r($data);die;
            $this->load->view(ADMIN.'store/materialissue/view_material_issue',$data);
     }else{
         $this->session->set_flashdata('error','Material issue Deleted or data mismatch');
         redirect(base_url(ADMIN.'store/MaterialIssue'));DIE;
     }
       
    }


    public function listItemGroup()
        {
                $search = '';
                $where = array();
                $json = [];
                $search = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

                if (isset($search)) {
                        $search = $search;
                } else {
                        $search = '';
                }

                $cites = $this->POModel->getItemGroupList($search, $where);
      

                foreach ($cites as $key => $value) {
                        if (isset($value['parent_group_name'])) {
                                $json[] = ['id' => $value['id'], 'text' => $value['item_group_name'] . " (" . $value['parent_group_name'] . ")"];
                        } else {
                                $json[] = ['id' => $value['id'], 'text' => $value['item_group_name']];
                        }
                }
                echo json_encode($json);
        }

    public function getItemData()
        {
                $post = $this->input->post();
                if (isset($post['item_group_id'])) {
                        $where['i.item_group'] = $post['item_group_id'];
                } else {
                        $where = array();
                }

                $items = $this->POModel->getItemList($where);
       
                $json = array();
                foreach ($items as $key => $value) {
                        $json[] = [
                                'id' => $value['id'], 'text' => $value['short_name'], 'data-short_name' => $value['short_name'], 'hsn_code' => $value['hsn_code'], 'rate' => $value['rate']
                        ];
                }

                $response['result'] = true;
                $response['data'] = $json;
                echo json_encode($response);
        }

    public function add_materialissue($_id='')
    {
            $data['title'] = 'Add Items';
            $data['item_groups_data'] = array();
            $data['stock_unit'] =array();
            $data['units']=array();
        
            $post = $this->input->post();

                
               
                if(isset($post['issue_date'])) {
                            //   print_r($post['unload_date']);
                                $formattedDate =strtotime(str_replace('/', '-', $post['issue_date']));
                                $issue_date = date('Y-m-d',$formattedDate);
                }
               
                if(isset($post['issue_type']) && ($post['issue_type']==2)){
                    if(! isset($post['issue_to_location_site_id'])){
                         $this->session->set_flashdata('error','transfer case not select  destination location!');
                            redirect(base_url(ADMIN.'store/MaterialIssue'));DIE;
                    }
                    
                }
                
                $insert_items = array(
                        'company_id' =>isset($post['company_id'])?$post['company_id']:NULL,
                        'site_id' => isset($post['site_id'])?$post['site_id']:NULL,
                        'financial_year_id' => isset($post['financial_year_id'])?$post['financial_year_id']:NULL,
                        'issue_number' => isset($post['issue_number'])?$post['issue_number']:NULL, 
                        'issue_date' => isset($issue_date)?$issue_date:NULL, 
                        'issue_time' => isset($post['issue_time'])?$post['issue_time']:NULL, 
                        'issue_type' =>isset($post['issue_type'])?$post['issue_type']:NULL, 
                        'issue_from' => isset($post['issue_from'])?$post['issue_from']:NULL, 
                        'customer_id' => isset($post['customer_id'])?$post['customer_id']:NULL, 
                        'issue_from_vendor_id' => isset($post['issue_from_vendor_id'])?$post['issue_from_vendor_id']:NULL,
                        'issue_location_site_id' => isset($post['issue_location_site_id'])?$post['issue_location_site_id']:NULL,
                        'issue_to_location_site_id' => isset($post['issue_to_location_site_id'])?$post['issue_to_location_site_id']:NULL,
                        'gate_pass_no' => isset($post['gate_pass_no'])?$post['gate_pass_no']:NULL,
                        'is_auto_make_gate' => isset($post['is_auto_make_gate'])?$post['is_auto_make_gate']:NULL,
                        'is_our_carrying_vehicle' => isset($post['is_our_carrying_vehicle'])?$post['is_our_carrying_vehicle']:NULL,
                        'carrying_vehicle_no' => isset($post['carrying_vehicle_no'])?$post['carrying_vehicle_no']:NULL,
                        'carrying_vehicle_driver' =>isset($post['carrying_vehicle_driver'])?$post['carrying_vehicle_driver']:NULL, 
                        'carrying_vehicle_reading' => isset($post['carrying_vehicle_reading'])?$post['carrying_vehicle_reading']:NULL, 
                        'is_loaded_via' => isset($post['is_loaded_via'])?$post['is_loaded_via']:NULL,
                        'loaded_party_id' => isset($post['loaded_party_id'])?$post['loaded_party_id']:NULL,
                        'transporter_id' => isset($post['transporter_id'])?$post['transporter_id']:NULL,
                        'manual_slip_no' => isset($post['manual_slip_no'])?$post['manual_slip_no']:NULL, 
                        'indend_no' => isset($post['indend_no'])?$post['indend_no']:NULL,
                        'remark' => isset($post['remark'])?$post['remark']:NULL, 
                        'rst_no' => isset($post['rst_no'])?$post['rst_no']:NULL,
                        'request_by' => isset($post['request_by'])?$post['request_by']:NULL,
                        'issued_by' => isset($post['issued_by_id'])?$post['issued_by_id']:NULL, 
                        'department_id' => isset($post['department_id'])?$post['department_id']:NULL, 
                        'received_by_id' => isset($post['received_by_id'])?$post['received_by_id']:NULL,
                        'is_print_material_issue' => isset($post['is_print_material_issue'])?$post['is_print_material_issue']:NULL,
                        'flat' => isset($post['flat'])?$post['flat']:NULL,
                        'floor' => isset($post['floor'])?$post['floor']:NULL,
                    );
                
                
                // echo '<pre>';
                //                  // print_r($_FILES);
                //                  print_r($insert_items);die;
            

                $material_issue_attachement=array();
                if(! empty($_FILES['file_name']['name'])){
                    $uploadStatus = myUpload(MATERIAL_ISSUE_FILES,'file_name',true);
                    if(isset( $uploadStatus['data']) && !empty( $uploadStatus['data'])){
                          $material_issue_attachement = $uploadStatus['data'];
                    }
                  
                }
  
   
        if ($post) {
                     if (empty($post['issue_id'])) {
                        $insert_items['created_by'] = userId();
                        if(isset($post['issue_type']) && $post['issue_type']==2){
                            // 1.Consumption/Issue 2.Transfer 3.Production 	
                            $insert_items['is_transfer_completed']=0;
                        }else{
                             $insert_items['is_transfer_completed']=NULL;
                        }
                        $insert_id = $this->CommonModel->iudAction('tbl_material_issue', $insert_items, 'insert');
                        $m_issue_id=$insert_id;
                        $company_id =isset($post['company_id'])?$post['company_id']:userId('company_id');
                        $site_id=isset($post['site_id'])?$post['site_id']:userId('site_id');
                        $financial_year_id=isset($post['financial_year_id'])?$post['financial_year_id']:userId('financial_year_id');
                                 
                    }else{


                        unset($insert_items['issue_date']);
                        unset($insert_items['issue_time']);
                         unset($insert_items['created_by']);
                        unset($insert_items['site_id']);
                        unset($insert_items['company_id']);
                        unset($insert_items['financial_year_id']);
                        $insert_items['updated_at'] = date('Y-m-d');
                        $insert_items['updated_by'] = userId();
                        $this->CommonModel->iudAction('tbl_material_issue', $insert_items, 'update', array('id' => $post['issue_id']));
                        $insert_id=$post['issue_id']; 
                        $m_issue_id=$insert_id;
                        
                        $get_grn_data = $this->CommonModel->getData('tbl_grn', array('id' => $post['id']),'company_id,site_id,financial_year_id','','row_array');
                        if(! empty($get_grn_data)){
                            $company_id=$get_grn_data['company_id'];
                            $site_id=$get_grn_data['site_id'];
                            $financial_year_id=$get_grn_data['financial_year_id'];
                        }else{
                            $company_id=userId('company_id');
                            $site_id= userId('site_id');
                            $financial_year_id=userId('financial_year_id');
                        }
                    }
                    if ($insert_id) {

                        if(!empty($material_issue_attachement)){
                            foreach($material_issue_attachement as $key=>$value)
                            { 
                                $material_issue_attachement = array(
                                     'issue_id'=> $insert_id, 
                                     'file_name' => $value['file_name']
                                    );
                            $this->CommonModel->iudAction('tbl_material_issue_attachment',$material_issue_attachement,'insert');
                            }
                        }


                        $delete_item_array=array();
                        if(isset($post['issue_id']) && !empty($post['issue_id'])){
                             $old_grn_item_data=$this->CommonModel->getData('tbl_material_issue_items_details', array('issue_id' =>$post['issue_id']), '', '', '');
                             $old_item_array=array_column($old_grn_item_data, 'item_id');
                             $new_item_array=array_column($post['material_items'], 'items_id');
                             //array difference
                             $delete_item_array= array_diff($old_item_array, $new_item_array);
                        }
                        // print_r($delete_item_array);die;
                        // echo "<pre>";print_r($post['material_items']);
                        if(!empty($post['material_items']) && count($post['material_items']) != 0){
                        foreach($post['material_items'] as $key1=>$value1)
                        {             
                            
                                        $get_issue_item_data = $this->CommonModel->getData('tbl_material_issue_items_details', array('issue_id' =>$post['issue_id'],'deleted_by' => NULL ,'item_id'=>$value1['items_id']),'','','row_array');
                                        
                                        
                                        $get_issue_item_data=array();
                                        $is_inv_add=$is_inv_minius=$update_qty=$is_new_batch='';
                                        $get_issue_item_data = $this->CommonModel->getData('tbl_material_issue_items_details', array('issue_id' =>$post['issue_id'],'deleted_by' => NULL ,'item_id'=>$value1['items_id']),'','','row_array');
                                    
                                        if(isset($post['issue_id']) && ! empty($get_issue_item_data)){
                                            
                                              $is_inv_add=$is_inv_minius=$update_qty=$is_new_batch=0;
                                              if(isset($post['issue_id']) && !empty($get_issue_item_data) && isset($get_issue_item_data['issue_qty']) && isset($get_issue_item_data['batch_no']) && isset($value1['item_unit'])){
                                                $old_issued_qty=$get_issue_item_data['issue_qty'];
                                                $new_received_qty=$value1['item_unit']; 
 
                                                //echo $new_received_qty."<br>".$old_received_qty;die;
                                                if($value1['batch_no']==$get_issue_item_data['batch_no']){
                                                    if($new_received_qty > $old_issued_qty){
                                                        $update_qty=$new_received_qty-$old_issued_qty;
                                                        //
                                                        $is_inv_minius=1;
                                                        //add update qty
                                                    }else if($new_received_qty < $old_issued_qty){
                                                        $update_qty=$old_issued_qty-$new_received_qty;
                                                        $is_inv_add=1;
                                                        //minius update qty
                                                    }
                                                    $is_new_batch=0;
                                                }else{
                                                    //new batch new qty add aginst that batcha and from old batch remove that recevied qty
                                                    $is_new_batch=1;
                                                    $is_inv_add=1;
                                                    $is_inv_minius=1;
                                                    $update_qty=$new_received_qty;
                                                    $old_batch_no=$get_issue_item_data['batch_no'];
                                                    $old_expired_date=$get_issue_item_data['expired_date'];
                                                    
                                                }
                                            }
                                            $update_batch_no=$value1['batch_no'];
                                    }
                                            $get_issue_item_data1 = $this->CommonModel->getData('tbl_items_inventory', array('item_id' =>$value1['items_id'],'item_unit_id'=>$value1['item_unit_id'],'batch_no'=>$value1['batch_no']),'expired_date','','row_array');
                                            if(isset($get_issue_item_data1['expired_date'])){
                                                $update_expired_date=$get_issue_item_data1['expired_date'];
                                            }else{
                                                $update_expired_date=NULL;
                                            }
                            if(isset($post['issue_type']) && $post['issue_type']==2){
                                $is_transfer_completed=0;
                            }else{
                                $is_transfer_completed=NULL;  
                            }   
                            
                            if($value1['amount']=='0.00' || $value1['amount']=='0'){
                                  $amount=$value1['rate']*$value1['item_unit'];
                             }else{
                                  $amount=$value1['amount'];
                             }
                 

                            $material_issue = array(
                                 'issue_id'=> $insert_id, 
                                 'item_group_id' => isset($value1['item_group_id'])?$value1['item_group_id']:NULL,
                                 'item_id' => isset($value1['items_id'])?$value1['items_id']:NULL,
                                 'req_qty' => isset($value1['req_qty'])?$value1['req_qty']:NULL,
                                 'issue_qty' => isset($value1['item_unit'])?$value1['item_unit']:NULL,
                                 'issue_qty_unit' => isset($value1['item_unit_id'])?$value1['item_unit_id']:NULL,
                                 'weight' => isset($value1['weight'])?$value1['weight']:NULL,
                                 'weight_unit' => isset($value1['weight_item_unit_id'])?$value1['weight_item_unit_id']:NULL,
                                 'rate' => isset($value1['rate'])?$value1['rate']:NULL,
                                 'amount' => isset($amount)?$amount:NULL,
                                 'is_returnable' => isset($value1['is_returnable'][0])?$value1['is_returnable'][0]:0,
                                 'returnable_date' =>(isset($value1['returnable_date']) && !empty($value1['returnable_date']))?$value1['returnable_date']:NULL,
                                 'issue_to' => isset($value1['issue_to'])?$value1['issue_to']:NULL,
                                 'part_id' => isset($value1['emp_issued_to_id'])?$value1['emp_issued_to_id']:NULL,
                                 'vehicle' => isset($value1['vehicle'])?$value1['vehicle']:NULL,
                                 'other_text' => isset($value1['other_text'])?$value1['other_text']:NULL,
                                 'remark' => isset($value1['material_issue_remark'])?$value1['material_issue_remark']:NULL,
                                 'batch_no' => isset($value1['batch_no'])?$value1['batch_no']:NULL,
                                 'expired_date' => isset($value1['expired_date'])?$value1['expired_date']:NULL,
                                 'is_transfer_completed'=> $is_transfer_completed,
                                 'created_at' => userId() ,
                                );  

                          
                             if(isset($post['issue_id'])  && ! empty($get_issue_item_data)){
                                    unset($material_issue['created_by']);
                                    $material_issue['updated_at'] = date('Y-m-d');
                                    $material_issue['updated_by'] = userId();
                                              
                                    $this->CommonModel->iudAction('tbl_material_issue_items_details',$material_issue,'update',array('item_id' => $value1['items_id'],'issue_id' =>$post['issue_id']));
                                    $sub_item_id=$this->CommonModel->getData('tbl_material_issue_items_details', array('item_id' =>  $value1['items_id'], 'issue_id' => $post['issue_id']),'id','','row_array');
                                    
                                    
                                    if(isset($post['issue_type']) && ($post['issue_type']==1 || $post['issue_type']==2 || $post['issue_type']==3) ){
                                        if( $post['issue_type']==2){
                                            $old_issue_to_location_site_id=$post['old_issue_to_location_site_id'];
                                            $issue_to_location_site_id=$post['issue_to_location_site_id'];
                                            //transfter form old 
                                               //transfer
                                            
                                            if($is_new_batch==1){
                                                //my invetroy add
                                                updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                //old remove 
                                                 $old_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['issue_to_location_site_id']),'id,company_id','','row_array');
                                                updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$old_company_ids['company_id'],$old_issue_to_location_site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$insert_id,userId(),$old_batch_no,$old_expired_date,0,$sub_item_id['id']);
                                            
                                                //new issue add 
                                                 updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],userId('company_id'),userId('site_id'),userId('financial_year_id') ,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$m_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],0,$sub_item_id['id']);
                                                 //get company id 
                                                  $destination_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['issue_to_location_site_id']),'id,company_id','','row_array');
                                                 //add to transfer company id  company id
                                                 updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],$destination_company_ids['company_id'],$post['issue_to_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ADD,ISSUE_TYPE,$m_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],0,$sub_item_id['id']);
                                            }else if($is_new_batch==0){
                                                if($is_inv_add==1){
                                                     updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                      $destination_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['issue_to_location_site_id']),'id,company_id','','row_array');
                                                     updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$destination_company_ids['company_id'],$post['issue_to_location_site_id'],$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                }
                                                
                                                if($is_inv_minius==1){
                                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                    $destination_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['issue_to_location_site_id']),'id,company_id','','row_array');
                                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$destination_company_ids['company_id'],$post['issue_to_location_site_id'],$financial_year_id,INVENTORY_ACTION_ADD,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                }
                                            }
                                        }else{
                                               if(isset($post['issue_id'])){
                                                        //if new batch add in update GRN recevird qty add from new batch and from old batch remove it
                                                        if($is_new_batch==1){
                                                            updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                            updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$insert_id,userId(),$old_batch_no,$old_expired_date,0,$sub_item_id['id']);
                                                        }else if($is_new_batch==0){
                                                            if($is_inv_add==1){
                                                                 updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                            }
                                                            
                                                            if($is_inv_minius==1){
                                                                updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date,0,$sub_item_id['id']);
                                                            }
                                                        }
                                                }
                                        }
                                    }
                                 
                             }else{
                                    $sub_item_id=$this->CommonModel->iudAction('tbl_material_issue_items_details',$material_issue,'insert');
                                 
                                    if(isset($post['issue_type']) && ($post['issue_type']==1 || $post['issue_type']==2 || $post['issue_type']==3) ){
                                        if( $post['issue_type']==2){
                                            //transfer
                                             updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],userId('company_id'),userId('site_id'),userId('financial_year_id') ,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$m_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],0,$sub_item_id);
                                             //get company id 
                                              $destination_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['issue_to_location_site_id']),'id,company_id','','row_array');
                                             //add to transfer company id  company id
                                            //  updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],$destination_company_ids['company_id'],$post['issue_to_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ADD,ISSUE_TYPE,$m_issue_id,userId(),$value1['batch_no'],$value1['expired_date']);
                                             updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],$destination_company_ids['company_id'],$post['issue_to_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ADD,ISSUE_TYPE,$m_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],IS_INVENTORY_REVERSED,$sub_item_id);
                                        }else{
                                            //
                                            // echo "items_id=".$value1['items_id']."<br>";
                                            //     echo "item_unit_id=".$value1['item_unit_id']."<br>";
                                            //         echo "qty=".$value1['item_unit']."<br>";
                                            //             echo "items_id=".$value1['items_id']."<br>";
                                                        
                                            updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],userId('company_id'),userId('site_id'),userId('financial_year_id') ,INVENTORY_ACTION_ISSUE_MINUS,ISSUE_TYPE,$m_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],0,$sub_item_id);
                                        }
                                         
                                    }
                             }
                            if(isset($post['issue_id']) && !empty($delete_item_array)){
                                    //update case if grn Item Delete From 
                                    if(count($delete_item_array) !=0){
                                        
                                            foreach ($delete_item_array as $key => $delete_item) {
                                                $get_item_data=array();
                                                $get_item_data = $this->CommonModel->getData('tbl_material_issue_items_details', array('issue_id' => $post['issue_id'], 'deleted_by' => NULL ,'item_id'=>$delete_item),'','','row_array');
                                             
                                                if(isset($post['issue_id']) && !empty($get_item_data) && isset($get_item_data['issue_qty']) && isset($get_item_data['batch_no'])){
                                                    $delete_qty=$get_item_data['issue_qty'];
                                                    $delete_batch_no=$get_item_data['batch_no'];
                                                    $delete_expired_date=$get_item_data['expired_date'];
                                                     
                                                    $insert_item_data=array();
                                                    $insert_item_data['deleted_at'] = date('Y-m-d');
                                                    $insert_item_data['deleted_by'] = userId();
                                                    
                                                    $sub_item_id=$this->CommonModel->getData('tbl_material_issue_items_details', array('item_id' => $delete_item, 'issue_id' => $post['issue_id']),'id','','row_array');
                                                    $this->CommonModel->iudAction('tbl_material_issue_items_details', $insert_item_data, 'update', array('item_id' => $delete_item,'issue_id'=>$post['issue_id']));
                                                        
                                                    updateQuickInventory($delete_item,$get_item_data['issue_qty_unit'],$delete_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,ISSUE_TYPE,$insert_id,userId(),$delete_batch_no,$delete_expired_date,0,$sub_item_id['id']);
                                                    
                                                }
                                            }
                                    }
                            }
                        }
                        }

                    $this->session->set_flashdata('success', 'Material Issue Data Added Succesfully!');
                }else{
                     $this->session->set_flashdata('error','Fail To Add Material Issue Data !');
                }

            
          
            redirect(base_url(ADMIN.'store/MaterialIssue'));
        }


            $data['user_data']= $this->CommonModel->getData('users',array('id'=>userId()),'','','row_array');  
            $data['issue_location']= $this->CommonModel->getData('tbl_site',array('id'=>userId('site_id')),'id,site_name','','row_array');
            $data['type']=1;
            $this->load->view(ADMIN.'store/materialissue/add_material_issue',$data); 
    }
    
    public function issueFromGRN($grn_id){
      
            $data['user_data']= $this->CommonModel->getData('users',array('id'=>userId()),'','','row_array');  
            $data['issue_location']= $this->CommonModel->getData('tbl_site',array('id'=>$data['user_data']['site_id']),'id,site_name','','row_array');
            $grn_data = $this->GRNModel->getGRNData('', '0', '0', '0', '0',$grn_id,'');
            $data['issue_info']=$grn_data[0];
            $data['po_info_items']= $this->GRNModel->getGRNItemDataALL(array('p.id'=>$grn_id));
            foreach($data['po_info_items'] as $key=>$info_item){
                $data['po_info_items'][$key]['available_qty'] = getQuickInventoryAmount($info_item['item_id'],$info_item['item_unit_id'],$grn_data[0]['company_id'],$grn_data[0]['site_id'],$grn_data[0]['financial_year_id'],$info_item['batch_no'],$info_item['expired_date'],0);;
                $data['po_info_items'][$key]['available_qty_query'] = $this->db->last_query();
                
            }
            $data['item_group'] =$this->POModel->getItemGroupList('', '');
            $data['type']=2;
            // echo "<pre>";
            //             print_r($data);
            //             die;
            $this->load->view(ADMIN.'store/materialissue/add_material_issue',$data);
    }
    public function issueFromTransfer($received_id){
        
            $this->load->model(ADMIN.'store/ReceiveMaterialIssueModel');
            
            $data['user_data']= $this->CommonModel->getData('users',array('id'=>userId()),'','','row_array');  
            $data['issue_location']= $this->CommonModel->getData('tbl_site',array('id'=>$data['user_data']['site_id']),'id,site_name','','row_array');
            $_data = $this->ReceiveMaterialIssueModel->getReceviedMaterialData('', '0', '0', '0', '0',$received_id,'');
           // echo $this->db->last_query();die;
            $data['issue_info']=$_data[0];
            $data['trf_info_items']= $this->ReceiveMaterialIssueModel->getReceviedMaterialItemsData('', '0', '0', '0', '0','0',array('pi.received_id'=>$received_id));
            
          //  echo $this->db->last_query();die;
            foreach($data['trf_info_items'] as $key=>$info_item){
                $data['trf_info_items'][$key]['available_qty'] = getQuickInventoryAmount($info_item['item_id'],$info_item['received_qty_unit'],$_data[0]['company_id'],$_data[0]['site_id'],$_data[0]['financial_year_id'],$info_item['batch_no'],$info_item['expired_date'],0);;
                $data['trf_info_items'][$key]['available_qty_query'] = $this->db->last_query();
            }
            $data['item_group'] =$this->POModel->getItemGroupList('', '');
            $data['type']=4;
            // echo "<pre>";
            //             print_r($data);
            //             die;
            $this->load->view(ADMIN.'store/materialissue/add_material_issue',$data);
    }
    
    
    public function edit_material_issue($_id=''){
        
            
            $MaterialIssueData = $this->MaterialIssueModel->getMaterialIssueData('', 0, 0, 0, 0,$_id);
            $data['issue_info']=$MaterialIssueData[0];
            $data['material_issue'] =  $MaterialIssueData[0];
            $data['title'] = 'Edit Material Issue Data';    
            $data['vendor_name'] = $this->CommonModel->getData('tbl_vendor_master',array('id'=>$data['material_issue']['issue_from_vendor_id']));
            $data['customer_name'] = $this->CommonModel->getData('tbl_vendor_master',array('id'=>$data['material_issue']['customer_id']));
            $data['party_name'] = $this->CommonModel->getData('tbl_vendor_master',array('id'=>$data['material_issue']['loaded_party_id']));
            $data['transporter_name'] = $this->CommonModel->getData('tbl_vendor_master',array('id'=>$data['material_issue']['transporter_id']));
            $data['site_master'] = $this->CommonModel->getData('tbl_site');
            $data['vendor_master'] = $this->CommonModel->getData('tbl_vendor_master');
            $data['item_groups_master'] = $this->CommonModel->getData('tbl_item_groups',array('is_deleted'=>0));

            $data['request_by'] = $this->CommonModel->getData('users',array('id'=>$data['material_issue']['request_by']),'concat(first_name," ",last_name) as request_user_name,id');
            $data['received_by'] = $this->CommonModel->getData('users',array('id'=>$data['material_issue']['received_by_id']),'concat(first_name," ",last_name) as received_user_name,id');
            $data['department_name'] = $this->CommonModel->getData('tbl_department',array('id'=>$data['material_issue']['department_id']));

            $data['user_data']= $this->CommonModel->getData('users',array('id'=>userId()),'','','row_array');  
            $data['issue_location']= $this->CommonModel->getData('tbl_site',array('id'=>userId('site_id')),'id,site_name','','row_array');

            $data['info_items_data'] = $this->MaterialIssueModel->getMaterialIssueItemData($data['material_issue']['id']);
            // echo $this->db->last_query();
            
            foreach($data['info_items_data'] as $key=>$info_item){
                $data['info_items_data'][$key]['item_batch_list'] = $this->MaterialIssueModel->getItemUnitBatchList(array('i.item_id'=>$info_item['item_id']));
                $data['info_items_data'][$key]['item_unit_list'] = $this->MaterialIssueModel->getItemUnitList(array('i.item_id'=>$info_item['item_id']));
                $data['info_items_data'][$key]['item_weight_unit_list'] = $this->MaterialIssueModel->getWeightItemUnitList(array('i.item_id'=>$info_item['item_id']));
                $data['info_items_data'][$key]['item_group_name'] = $this->CommonModel->getData('tbl_item_groups',array('is_deleted'=>0));
                if($info_item['item_group_id']!=0){
                     $data['info_items_data'][$key]['item_name'] = $this->CommonModel->getData('tbl_items',array('item_group'=>$info_item['item_group_id']));
                }else{
                     $data['info_items_data'][$key]['item_name'] = $this->CommonModel->getData('tbl_items');
                }
               
                $data['info_items_data'][$key]['available_qty'] = getQuickInventoryAmount($info_item['item_id'],$info_item['issue_qty_unit'],$MaterialIssueData[0]['company_id'],$MaterialIssueData[0]['site_id'],$MaterialIssueData[0]['financial_year_id'],$info_item['batch_no'],$info_item['expired_date'],0);;
            
                
            }

            $data['type']=3;
            // echo "<pre>";
            //             print_r($data['info_items_data']);
            //             die;
            $this->load->view(ADMIN.'store/materialissue/add_material_issue',$data);
    }


    public function remove_material_file_attachment()
    {
        $material_file_attachment_id = $this->input->post('material_file_attachment_id');
          
          if($this->CommonModel->iudAction('tbl_material_issue_attachment','','delete',array('id'=>$material_file_attachment_id))){
                $response['result'] = true;
             
            }else{
                $response['result'] = false;
          
            }
            echo json_encode($response);
        }


    public function getAvaliableQty()
    {    
        $post = $this->input->post();
        $item_id = $post['item_id'];   
        $item_unit_id=$post['item_unit_id'];  
        $item_unit = $this->CommonModel->getData('tbl_items_units',array('id'=>$item_unit_id),'unit_id,id','','row_array');
        $company_id = userId('company_id');
        $site_id=userId('site_id');
        $financial_year_id=userId('financial_year_id');
        $batch_no = $post['batch_no'];   
       
        $get_qty = getQuickInventoryAmount($item_id,$item_unit_id,$company_id,$site_id,$financial_year_id,$batch_no);
    //    echo $this->db->last_query();die;
       
        echo json_encode($get_qty);
    }
    public function InnearItemTableData(){
	     if (isset($_GET['id'])) {
            $id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['items']= $this->MaterialIssueModel->getMaterialIssueItemData($id);
            // echo "<pre>";
            // print_r($data['items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/materialissue/inner_items_table', $data,true);
            $response['html'] = $html;
            $response['result'] = true;
            $response['reason'] = 'Data Found';
        } else {
          
            // echo "Error: outerTableId parameter is missing";
           $response['result'] = false;
           $response['reason'] = 'Something went to wrong!';
           $response['html'] = '';
        }
      
        
        if ($html) {
         
        }else{
        
        }
        echo json_encode($response);
	}

}