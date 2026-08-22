<?php 

    class MaterialIssueReturn extends CI_Controller{
        function __construct()
        {
            parent::__construct();
            $this->load->model(ADMIN.'store/MaterialIssueReturnModel');
             $this->load->model(ADMIN . 'POModel');
            isLogin();
        }


        public function index()
        {
         $data['title'] = 'Material Issue Return';
         $data['active'] = 'MaterialIssue Return';
         $this->load->view(ADMIN.'store/material_issue_return/list_material_issue_return',$data);
        }

        public function list_material_issue_return()
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
            if(isset($data['company_id'] ) && $data['company_id'] !== 'all'){
                $where['mir.company_id'] = $data['company_id'];
            }
            
            if(isset($data['site_id'] ) && $data['site_id'] !== 'all'){
                 $where['mir.site_id'] = $data['site_id'];
            }


            if ($data['on_date'] == 1) {
            $from_date = date('Y-m-d');
             $where['mir.return_issue_date'] = date('Y-m-d',strtotime($from_date));
             }else if ($data['on_date'] == 2) {
                $from_date = date('Y-m-d', strtotime('-1 days'));
                 $where['mir.return_issue_date'] = date('Y-m-d',strtotime($from_date));
             }else if ($data['on_date'] == 3) {
                $from_date = date('Y-m-d', strtotime('last monday'));
                $to_date = date('Y-m-d', strtotime('next sunday'));
                $where['mir.return_issue_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']='';
             }else if ($data['on_date'] == 4) {
                 
                $from_date = date('Y-m-d', strtotime('first day of this month'));
                $to_date = date('Y-m-d', strtotime('last day of this month'));
                $where['mir.return_issue_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']='';

             }else if ($data['on_date'] == 5) {
                    if(isset($from_date) && isset($to_date)){
                        $from_date = date('Y-m-d', strtotime('01/31'));
                        $to_date = date('Y-m-d', strtotime('12/31'));
                        $where['mir.return_issue_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']='';
                    }
             }else if($data['on_date'] == 6){
                 if(isset($from_date) && isset($to_date)){
                    $from = new DateTime($from_date);
                    $to = new DateTime($to_date);
                    $from_date = $from->format('Y-m-d 00:00:00');
                    $to_date = $to->format('Y-m-d 23:59:59');
                    $where['mir.return_issue_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']='';  
                 }
               
            }
           
            if(isset($data['vendor_id'])&& $data['vendor_id'] != 'all' && !empty($data['vendor_id'])){
                $where['mir.issue_from_vendor_id'] = $data['vendor_id'];
            }
            if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
                $item_id=$data['item_id'];
             }else{
                $item_id='';
             }
             if(!empty($data['item_group_id']) &&  isset($data['item_group_id']) && $data['item_group_id']!="all"){
                $item_group_id=$data['item_group_id'];
             }else{
                $item_group_id='';
             }

            $count = count($this->MaterialIssueReturnModel->getMaterialIssueReturnData($searchVal,0,0,0,0,0,$where,$item_id,$item_group_id));
           // echo $this->db->last_query();die;
            if($count){
                $result = $this->MaterialIssueReturnModel->getMaterialIssueReturnData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id,$item_group_id);
        
                    foreach ($result as $key => $value) {
                
                        $row = []; 
                        $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['id'].'" title="View Items">';
                         array_push($row, $offset+($key+1)." ".$html1);
                        array_push($row, $value['company_name']);
                        array_push($row, $value['site_name']);
                        array_push($row, $value['financial_year']);

                        if($value['return_issue_type'] == CONSUMPTION_ISSUE) {
                            $return_type = 'Consumption/Issue';
                        }else if($value['return_issue_type'] == TRANSFER){
                            $return_type = 'Transfer';
                        }else if($value['return_issue_type'] == PRODUCTION){
                            $return_type = 'Production';
                        }else if($value['return_issue_type'] == SCRAP){
                            $return_type = 'Scrap';
                        }else if($value['return_issue_type'] == WASTAGE){
                            $return_type = 'Wastage';
                        }else if($value['return_issue_type'] == RE_USABLE){
                            $return_type = 'Re_Usable';
                        }else if($value['return_issue_type'] == FRESH){
                            $return_type = 'Fresh';
                        }else{
                            $return_type = '<span> - </span>';
                        }

                        array_push($row, $return_type);
                        array_push($row, $value['m_rtn_no']);
                        array_push($row, dmyDate($value['return_issue_date']));

                        $confirm = "confirm('Are you sure you want to delete this Record?')";
                          
                         $action='  
                            <a href="'.base_url().'admin/store/MaterialIssueReturn/viewReturnMaterialIssueReturn/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                             <a href="'.base_url().'admin/store/MaterialIssueReturn/add_materialissue_return/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>';

                         array_push($row, $action);
                         $columns[] = $row;
                   }
            }
            $response = [
                'draw' => $page,
                'data' => $columns,
                'recordsTotal' => $count,
                'total_count' => $count,
                'recordsFiltered' => $count
            ];
            // print_r($response['total_count']);die;
            echo json_encode($response);
        }



    public function add_materialissue_return($_id='')
    {
        $data['title'] = 'Add Items';
        $data['item_groups_data'] = array();
        $post = $this->input->post();
        
        // echo "<pre>"; print_r($post);die;
        if(isset($post['return_issue_date'])) {
                            //   print_r($post['unload_date']);
                $formattedDate =strtotime(str_replace('/', '-', $post['return_issue_date']));
                $return_issue_date = date('Y-m-d',$formattedDate);
        }else{
             $return_issue_date = date('Y-m-d');
        }
                
        if ($post) {
            $insert_array = array(
                    'company_id' =>isset($post['company_id'])?$post['company_id']:NULL,
                    'site_id' => isset($post['site_id'])?$post['site_id']:NULL,
                    'financial_year_id' => isset($post['financial_year_id'])?$post['financial_year_id']:NULL,
                    'm_rtn_no' => isset($post['m_rtn_no'])?$post['m_rtn_no']:NULL, 
                    'return_issue_date' => $return_issue_date, 
                    'return_issue_type' =>isset($post['issue_type'])?$post['issue_type']:NULL, 
                    'issue_from_vendor_id' => isset($post['issue_from_vendor_id  '])?$post['issue_from_vendor_id ']:NULL, 
                    'return_issue_location' => isset($post['return_issue_location'])?$post['return_issue_location']:NULL, 
                    'from_location_id' => isset($post['from_location_id'])?$post['from_location_id']:NULL, 
                    'customer_id' => isset($post['customer_id'])?$post['customer_id']:NULL, 
                    'gate_pass_no' => isset($post['gate_pass_no'])?$post['gate_pass_no']:NULL, 
                    'is_auto_make_gate' => isset($post['is_auto_make_gate'])?$post['is_auto_make_gate']:NULL, 
                    'is_our_carrying_vehicle' => isset($post['is_our_carrying_vehicle'])?$post['is_our_carrying_vehicle']:NULL, 
                    'carrying_vehicle_no' => isset($post['carrying_vehicle_no'])?$post['carrying_vehicle_no']:NULL, 
                    'is_return_from' => isset($post['is_return_from'])?$post['is_return_from']:NULL, 
                    'return_by' => isset($post['return_by'])?$post['return_by']:NULL,
                    'received_by' => isset($post['received_by'])?$post['received_by']:NULL,
                    'return_item_remark' => isset($post['return_item_remark'])?$post['return_item_remark']:NULL,
                    'is_material_return_print' => isset($post['is_material_return_print'][0])?$post['is_material_return_print'][0]:0,
                );

            if(empty($post['id'])) {

                $insert_array['created_by'] = userId();

                $insert_id = $this->CommonModel->iudAction('tbl_material_issue_return', $insert_array, 'insert');
                $company_id =isset($post['company_id'])?$post['company_id']:userId('company_id');
                $site_id=isset($post['site_id'])?$post['site_id']:userId('site_id');
                $financial_year_id=isset($post['financial_year_id'])?$post['financial_year_id']:userId('financial_year_id');
                
                
                if ($insert_id) {
                    foreach($post['material_items'] as $key1=>$value1)
                    {             
                        $material_issue = array(
                             'material_issue_return_id'=> $insert_id, 
                             'item_group_id' => isset($value1['item_group_id'])?$value1['item_group_id']:NULL,
                             'item_id' => isset($value1['items_id'])?$value1['items_id']:NULL,
                             'batch_no' => isset($value1['batch_no'])?$value1['batch_no']:NULL,
                             'expired_date' => isset($value1['expired_date'])?$value1['expired_date']:NULL,
                             'return_qty' => isset($value1['item_unit'])?$value1['item_unit']:NULL,
                             'return_qty_unit' => isset($value1['item_unit_id'])?$value1['item_unit_id']:NULL,
                             'weight' => isset($value1['weight'])?$value1['weight']:NULL,
                             'weight_unit' => isset($value1['weight_item_unit_id'])?$value1['weight_item_unit_id']:NULL,
                             'rate' => isset($value1['rate'])?$value1['rate']:NULL,
                             'amount' => isset($value1['amount'])?$value1['amount']:NULL,
                             'issue_to' => isset($value1['issue_to'])?$value1['issue_to']:NULL,
                             'emp_issued_to_id' => isset($value1['emp_issued_to_id'])?$value1['emp_issued_to_id']:NULL,
                             'vehicle' => isset($value1['vehicle'])?$value1['vehicle']:NULL,
                             'other_text' => isset($value1['other_text'])?$value1['other_text']:NULL,
                             'is_returnable' => isset($value1['is_returnable'][0])?$value1['is_returnable'][0]:NULL,
                             'returnable_date' => isset($value1['returnable_date'])?$value1['returnable_date']:NULL,

                             'material_issue_remark' => isset($value1['material_issue_remark'])?$value1['material_issue_remark']:NULL,
                            
                             'created_by' => userId(),
                            );  

                        $this->CommonModel->iudAction('tbl_material_issue_return_details',$material_issue,'insert');
                        
                        //
                          updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],userId('company_id'),userId('site_id'),userId('financial_year_id') ,INVENTORY_ACTION_ADD,RETURN_TYPE,$insert_id,userId(),$value1['batch_no'],$value1['expired_date']);
                    }
                
                    $this->session->set_flashdata('success', 'Return Material Data Added Succesfully!');
                }else{
                    $this->session->set_flashdata('error','Fail To Add Return Material Data !');
                }
            
            }else{
                // update
                $insert_array['updated_by'] = date('Y-m-d h:i A');
                $insert_array['updated_at'] = userId();
            
            // echo "<pre>"; print_r($post);die;
                unset($insert_array['site_id']);
                unset($insert_array['company_id']);
                unset($insert_array['financial_year_id']);
                
                $this->CommonModel->iudAction('tbl_material_issue_return', $insert_array, 'update',array('id'=>$post['id']));
                $insert_id=$post['id'];
                $get_data = $this->CommonModel->getData('tbl_material_issue_return', array('id' => $post['id']),'company_id,site_id,financial_year_id','','row_array');
                        if(! empty($get_data)){
                            $company_id=$get_data['company_id'];
                            $site_id=$get_data['site_id'];
                            $financial_year_id=$get_data['financial_year_id'];
                        }else{
                            $company_id=userId('company_id');
                            $site_id= userId('site_id');
                            $financial_year_id=userId('financial_year_id');
                        }
                        
                    $delete_item_array=array();
                    if(isset($post['material_issue_return_id']) && !empty($post['material_issue_return_id'])){
                         $old_grn_item_data=$this->CommonModel->getData('tbl_material_issue_return_details', array('material_issue_return_id' =>$post['material_issue_return_id']), '', '', '');
                         $old_item_array=array_column($old_grn_item_data, 'item_id');
                         $new_item_array=array_column($post['material_items'], 'items_id');
                         //array difference
                         $delete_item_array= array_diff($old_item_array, $new_item_array);
                    }
                        
                        
                    foreach($post['material_items'] as $key1=>$value1)
                    {   
                        
                                  
                            $get_issue_item_data=array();
                            $is_inv_add=$is_inv_minius=$update_qty=$is_new_batch='';
                            $get_issue_item_data = $this->CommonModel->getData('tbl_material_issue_return_details', array('material_issue_return_id' =>$post['material_issue_return_id'],'deleted_by' => NULL ,'item_id'=>$value1['items_id']),'','','row_array');
                        
                            if(isset($post['material_issue_return_id']) && ! empty($get_issue_item_data)){
                                 
 
                                  $is_inv_add=$is_inv_minius=$update_qty=$is_new_batch=0;
                                  if(isset($post['material_issue_return_id']) && !empty($get_issue_item_data) && isset($get_issue_item_data['return_qty']) && isset($get_issue_item_data['batch_no']) && isset($value1['item_unit'])){
                                    $old_issued_qty=$get_issue_item_data['return_qty'];
                                    $new_received_qty=$value1['item_unit']; 

                                    //echo $new_received_qty."<br>".$old_received_qty;die;
                                    if($value1['batch_no']==$get_issue_item_data['batch_no']){
                                        if($new_received_qty > $old_issued_qty){
                                            $update_qty=$new_received_qty-$old_issued_qty;
                                            //
                                            $is_inv_add=1;
                                            
                                            //add update qty
                                        }else if($new_received_qty < $old_issued_qty){
                                            $update_qty=$old_issued_qty-$new_received_qty;
                                            $is_inv_minius=1;
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
                                $update_expired_date=$value1['expired_date'];
                                
                                
                        }
                       
                        
                        $material_issue = array(
                             'item_group_id' => isset($value1['item_group_id'])?$value1['item_group_id']:NULL,
                             'item_id' => isset($value1['items_id'])?$value1['items_id']:NULL,
                             'batch_no' => isset($value1['batch_no'])?$value1['batch_no']:NULL,
                             'expired_date' => isset($value1['expired_date'])?$value1['expired_date']:NULL,
                             'return_qty' => isset($value1['item_unit'])?$value1['item_unit']:NULL,
                             'return_qty_unit' => isset($value1['item_unit_id'])?$value1['item_unit_id']:NULL,
                             'weight' => isset($value1['weight'])?$value1['weight']:NULL,
                             'weight_unit' => isset($value1['weight_item_unit_id'])?$value1['weight_item_unit_id']:NULL,
                             'rate' => isset($value1['rate'])?$value1['rate']:NULL,
                             'amount' => isset($value1['amount'])?$value1['amount']:NULL,
                             'issue_to' => isset($value1['issue_to'])?$value1['issue_to']:NULL,
                             'emp_issued_to_id' => isset($value1['emp_issued_to_id'])?$value1['emp_issued_to_id']:NULL,
                             'vehicle' => isset($value1['vehicle'])?$value1['vehicle']:NULL,
                             'other_text' => isset($value1['other_text'])?$value1['other_text']:NULL,
                             'is_returnable' => isset($value1['is_returnable'][0])?$value1['is_returnable'][0]:NULL,
                             'returnable_date' => isset($value1['returnable_date'])?$value1['returnable_date']:NULL,

                             'material_issue_remark' => isset($value1['material_issue_remark'])?$value1['material_issue_remark']:NULL,
                          
                            );  
                            
                        $material_issue['updated_by'] = userId();

                         $get_return_item_data = $this->CommonModel->getData('tbl_material_issue_return_details', array('material_issue_return_id' =>$post['material_issue_return_id'],'item_id'=>$value1['items_id'],'return_qty_unit'=>$value1['item_unit_id']),'','','row_array');    
                       
                        if(! empty($get_return_item_data['id']) && isset($get_return_item_data['id'])){
                        
                            $this->CommonModel->iudAction('tbl_material_issue_return_details',$material_issue,'update',array('id'=>$get_return_item_data['id']));

                        }else{
                            $material_issue['material_issue_return_id'] =$post['material_issue_return_id'];
                            $this->CommonModel->iudAction('tbl_material_issue_return_details',$material_issue,'insert'); 
                          
                        }
                        
                        if(isset($post['material_issue_return_id'])){
                                //if new batch add in update GRN recevird qty add from new batch and from old batch remove it
                                if($is_new_batch==1){
                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,RETURN_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date);
                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,RETURN_TYPE,$insert_id,userId(),$old_batch_no,$old_expired_date);
                                }else if($is_new_batch==0){
                                    if($is_inv_add==1){
                                         updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,RETURN_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date);
                                    }
                                    
                                    if($is_inv_minius==1){
                                        updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,RETURN_TYPE,$insert_id,userId(),$update_batch_no,$update_expired_date);
                                    }
                                }
                        }
                           
                    }

                        if(isset($post['material_issue_return_id']) && !empty($delete_item_array)){
                                    //update case if grn Item Delete From 
                                    if(count($delete_item_array) !=0){
                                        
                                            foreach ($delete_item_array as $key => $delete_item) {
                                                $get_item_data=array();
                                                $get_item_data = $this->CommonModel->getData('tbl_material_issue_return_details', array('material_issue_return_id' => $post['material_issue_return_id'], 'deleted_by' => NULL ,'item_id'=>$delete_item),'','','row_array');
                                             
                                                if(isset($post['material_issue_return_id']) && !empty($get_item_data) && isset($get_item_data['return_qty']) && isset($get_item_data['batch_no'])){
                                                    $delete_qty=$get_item_data['return_qty'];
                                                    $delete_batch_no=$get_item_data['batch_no'];
                                                    $delete_expired_date=$get_item_data['expired_date'];
                                                     
                                                    $insert_item_data=array();
                                                    $insert_item_data['deleted_at'] = date('Y-m-d');
                                                    $insert_item_data['deleted_by'] = userId();
                                                    $this->CommonModel->iudAction('tbl_material_issue_return_details', $insert_item_data, 'update', array('item_id' => $delete_item,'material_issue_return_id'=>$post['material_issue_return_id']));
                                                        
                                                    updateQuickInventory($delete_item,$get_item_data['return_qty_unit'],$delete_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,RETURN_TYPE,$insert_id,userId(),$delete_batch_no,$delete_expired_date);
                                                    
                                                }
                                            }
                                    }
                            }

                $this->session->set_flashdata('success','Return Material Data Update Successfully');
            }

            redirect(base_url(ADMIN.'store/MaterialIssueReturn'));
        }

        
        if($_id){
            
            $mt_return_data = $this->MaterialIssueReturnModel->getMaterialIssueReturnData('', 0, 0, 0, 0,$_id);
            $data['material_issue_return'] =  $mt_return_data[0];
            $data['title'] = 'Edit Return Material Issue';    
          
            $items_data = $this->MaterialIssueReturnModel->getMaterialIssueReturnItemData($data['material_issue_return']['id']);
            //   echo "<pre>"; print_r($items_data);die;
            foreach($items_data as $key=>$info_item){
                $info_item['item_batch_list'] = $this->MaterialIssueReturnModel->getItemUnitBatchList(array('miid.item_id'=>$info_item['item_id']));
                $info_item['item_unit_list'] = $this->MaterialIssueReturnModel->getItemUnitList(array('iid.item_id'=>$info_item['item_id']));
                $info_item['item_weight_unit_list'] = $this->MaterialIssueReturnModel->getWeightItemUnitList(array('di.item_id'=>$info_item['item_id']));
                $info_item['item_group_name'] = $this->CommonModel->getData('tbl_item_groups',array('id'=>$info_item['item_group_id']));
                $info_item['item_name'] = $this->CommonModel->getData('tbl_items',array('item_group'=>$info_item['item_group_id']));
                $info_item['vendor_name_dt'] = $this->CommonModel->getData('tbl_vendor_master',array('id'=>$info_item['emp_issued_to_id']));
                
                $data['info_items_data'][$key] = $info_item;

                  // echo "<pre>"; print_r($data);die;
            }

    
           $data['return_by'] = $this->CommonModel->getData('users',array('id'=>$data['material_issue_return']['return_by']),'concat(first_name," ",last_name) as return_by_user_name,id');
           $data['received_by'] = $this->CommonModel->getData('users',array('id'=>$data['material_issue_return']['received_by']),'concat(first_name," ",last_name) as received_user_name,id'); 

        }
        // echo "<pre>"; print_r($data);die;
        $data['issue_location'] = $this->CommonModel->getData('tbl_site',array('id'=>userId('site_id')),'id,site_name','','row_array');
         $data['tbl_site'] = $this->CommonModel->getData('tbl_site',array('id'=>userId('site_id')),'id,site_name','','');
        $this->load->view(ADMIN.'store/material_issue_return/add_material_issue_return',$data); 
  
    }

    


        public function getItemData()
        {
                $post = $this->input->post();
                 $where = array();
                if (isset($post['item_group_id'])) {
                       if($post['item_group_id']!='all'){
                           $where['i.item_group'] = $post['item_group_id'];
                       }
                        
                } else {
                        $where = array();
                }

                $items = $this->MaterialIssueReturnModel->getItemList($where);
            // echo "<pre>"; print_r($items);die;
                $json = array();

                foreach ($items as $key => $value) {
                        
                        $json[] = [
                                'id' => $value['iditem'], 'text' => $value['short_name'], 'data-short_name' => $value['short_name'], 'rate' => $value['rate'],'item_code' => $value['item_code']
                        ];
                }
                
                if(!empty($items)){
                     $response['result'] = true;
                    $response['data'] = $json;
                }else{
                     $response['result'] = false;
                $response['reasons'] = "NO Item To return";
                }
            //   print_r($response);die;
                echo json_encode($response);
        }

        public function getItemUnitsData()
        {
                $post = $this->input->post();
                if (isset($post['item_id'])) {
                        $where['i.id'] = $post['item_id'];
                        $where1['iid.item_id'] = $post['item_id'];
                        $where1['u.is_deleted'] = 0;
                } else {
                        $where = array();
                        $where1 = array();
                }
                
                $items_info = $this->MaterialIssueReturnModel->getItemList($where);
                $items_units = $this->MaterialIssueReturnModel->getItemUnitList($where1);
                // $items_batchs_no = $this->MaterialIssueReturnModel->getItemUnitBatchList(array('miid.item_id'=>$post['item_id']));
                
                // echo "<pre>"; print_r($items_info);
                // echo "<pre>"; print_r($items_units);
                // echo "<pre>"; print_r($items_batchs_no);
                // die;

                $json = array();
                if(!empty($items_info)){
                    $response['result'] = true;
                    $response['data_item'] = $items_info[0];
                    $response['data'] = $items_units;
                }else{
                    $response['result'] = false;
                    $response['data_item'] = array();
                    $response['data'] = array();
                }
               
                // $response['batch_info'] = $items_batchs_no;
                echo json_encode($response);
        }
           public function getUnitBatchWiseData()
        {
                $post = $this->input->post();
                if (isset($post['item_id'])) {
                        $where['i.id'] = $post['item_id'];
                        $where1['i.item_id'] = $post['item_id'];
                        $where1['i.item_unit_id'] = $post['item_unit_id'];
                        $where1['u.is_deleted'] = 0;
                } else {
                        $where = array();
                        $where1 = array();
                }
             
                $items_batchs_no = $this->MaterialIssueReturnModel->getItemUnitBatchList(array('miid.item_id'=>$post['item_id'],'miid.issue_qty_unit'=>$post['item_unit_id']));
                //  echo $this->db->last_query();
                // print_r($items_batchs_no);
                 foreach($items_batchs_no as $key=>$value){
                   
                    $items_batchs_no[$key]['issue_qty']=$value['issue_qty'];
                    $rate= $this->POModel->getItemRateBatchList(array('gi.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date']));
                    $items_batchs_no[$key]['rate']=isset($rate['item_rate'])?$rate['item_rate']:0;
                    
                }
                
       // print_r($cites);die;
                $json = array();
                $response['result'] = true;
                $response['batch_info'] = $items_batchs_no;
                echo json_encode($response);
        }
            public function viewReturnMaterialIssueReturn($material_issue_return_id='')
        {
            $material_issue_return = $this->MaterialIssueReturnModel->viewMaterialIssueReturnData($material_issue_return_id);
            $data = $material_issue_return[0];
           
            $data['return_by'] = $this->CommonModel->getData('users',array('id'=>$data['return_by']),'concat(first_name," ",last_name) as return_by_user_name,id','','row_array');
            $data['received_by'] = $this->CommonModel->getData('users',array('id'=>$data['received_by']),'concat(first_name," ",last_name) as received_user_name,id','','row_array');
               
            // echo "<pre>"; print_r($data);die;
            $this->load->view(ADMIN.'store/material_issue_return/view_material_issue_return',$data);
        }


    public function list_return_material_issue_items_data()
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

            if($data['mtr_issue_id']){
                $where['mid.material_issue_return_id'] = $data['mtr_issue_id'];
            }

            $count = count($this->MaterialIssueReturnModel->getMaterialIssueReturnItemsData($searchVal,0,0,0,0,0,$where));

            if($count){
                $result = $this->MaterialIssueReturnModel->getMaterialIssueReturnItemsData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
                
                // echo "<pre>"; print_r($result);die;
                    foreach ($result as $key => $value) {
                
                        $row = []; 
                        array_push($row, $offset + ($key + 1));
                        array_push($row, $value['short_name']);
                        array_push($row, $value['item_group_name']);
                        array_push($row, $value['return_qty']);

                        array_push($row, $value['weight']);
                        array_push($row, $value['rate']);
                        array_push($row, $value['amount'].'.00');
                        
                        if($value['is_returnable'] == 0) {
                            array_push($row, 'No');    
                        }else{
                            array_push($row, 'Yes');
                        }


                        if($value['returnable_date'] == '0000-00-00') {
                            array_push($row, '-');    
                        }else{
                            array_push($row, dmyDate($value['returnable_date']));
                        }
                        

                        
                        array_push($row, $value['material_issue_remark']);


                        $columns[] = $row;
                   }
            }
            $response = [
                'draw' => $page,
                'data' => $columns,
                'recordsTotal' => $count,
                'total_count' => $count,
                'recordsFiltered' => $count
            ];
            // print_r($response['total_count']);die;
            echo json_encode($response);
        }
        public function InnearItemTableData(){
	     if (isset($_GET['id'])) {
            $id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['items']= $this->MaterialIssueReturnModel->getMaterialIssueReturnItemData1($id);
            // echo "<pre>";
            // print_r($data['items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/material_issue_return/inner_items_table', $data,true);
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

?>
