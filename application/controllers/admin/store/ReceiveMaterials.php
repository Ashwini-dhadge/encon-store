<?php
/**
 * 
 */
class ReceiveMaterials extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN.'store/ReceiveMaterialIssueModel');
        $this->load->model(ADMIN.'CommonCustModel');
        $this->load->model(ADMIN . 'store/MaterialIssueModel');
        $this->load->model(ADMIN . 'POModel');
         
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'MaterialIssue';
       
      $this->load->view(ADMIN.'store/receivematerials/list_materialissue',$data);
    }
    public function receiveMaterial()
    {
        $data['title'] = 'MaterialIssue';
       
      $this->load->view(ADMIN.'store/receivematerials/list_receivematerial',$data);
    }
    public function listMaterialIssue()
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
       
       
         $on_date = $this->input->post('on_date');
         $from_date = $this->input->post('from_date');
         $to_date = $this->input->post('to_date');
         
         


        if(isset($data['company_id']) && ! empty($data['company_id'])){
              if($data['company_id'] !== 'all'){
                   $where['s1.company_id'] = $data['company_id'];
              }
         }else{
             $where['p.company_id'] =userId('company_id');
         }
        
         if(isset($data['site_id'])&& !empty($data['site_id'])){
              if($data['site_id'] !== 'all'){
                   $where['p.issue_to_location_site_id'] = $data['site_id'];
              }
         }else{
             $where['p.issue_to_location_site_id'] =userId('site_id');
         } 
         
         if(isset($data['vendor_id'])&& !empty($data['vendor_id'])){
              if($data['vendor_id'] !== 'all'){
                   $where['p.issue_from_vendor_id'] = $data['vendor_id'];
              }
         }
         
         
         
        
         if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
         }
         if(!empty($data['id_itemgroup']) &&  isset($data['id_itemgroup']) && $data['id_itemgroup']!="all"){
            $itemgroup=$data['id_itemgroup'];
         }else{
            $itemgroup='';
         }
        // echo $itemgroup;die;
         

         if($on_date !== 'all'){
                if ($on_date == 1) {
                    $from_date = date('Y-m-d');
                     $where['date(p.issue_date)'] = date('Y-m-d',strtotime($from_date));
                 }else if ($on_date == 2) {
                    $from_date = date('Y-m-d', strtotime('-1 days'));
                     $where['date(p.issue_date)'] = date('Y-m-d',strtotime($from_date));
                 }else if ($on_date == 3) {
                    $from_date = date('Y-m-d', strtotime('last monday'));
                    $to_date = date('Y-m-d', strtotime('next sunday'));
                    $where['date(p.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
                 }else if ($on_date == 4) {
                    $from_date = date('Y-m-d', strtotime('first day of this month'));
                    $to_date = date('Y-m-d', strtotime('last day of this month'));
                    $where['date(p.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
        
                 }else if ($on_date == 5) {
                    $from_date = date('Y-m-d', strtotime('01/31'));
                    $to_date = date('Y-m-d', strtotime('12/31'));
                    $where['date(p.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
                 }else if($on_date == 6){
                    $from = new DateTime($from_date);
                    $to = new DateTime($to_date);
                    $from_date = $from->format('Y-m-d 00:00:00');
                    $to_date = $to->format('Y-m-d 23:59:59');
                    $where['date(p.issue_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
                }
        }
        
        
        
      
        
        $count = count($this->ReceiveMaterialIssueModel->getMaterialIssueTransferData($searchVal,0,0,0,0,0,$where,$item_id,$itemgroup));
        // echo $this->db->last_query();die;
        if($count){
            $result = $this->ReceiveMaterialIssueModel->getMaterialIssueTransferData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id,$itemgroup);
            // echo $this->db->last_query();die;
                foreach ($result as $key => $value) {
                    $flag=$own_flag_access=0;
                    $row = []; 
                    // $html='<input type="checkbox" class=" form-check-input checkbox_grn_po" value="'.$value['id'].'" >';
                    $html='';
                    $cnt=$offset + ($key + 1);
                     $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['id'].'" title="View Items">';
                    array_push($row, $offset + ($key + 1)." ".$html1);
                    array_push($row, '<a href="'.base_url().'admin/store/MaterialIssue/view_material_issue/'.$value['id'] .'" title="view" class="" data-toggle="tooltip">'.$value['issue_number'].'</a>');
                    array_push($row, dmyDate($value['issue_date']));
                    array_push($row, $value['location_site_name']);
                    array_push($row, $value['to_location_site_name']);
                    
                    $pending_array=array();
                    $pending_qty=$item_total_qty=0;
                    $issue_total_qty= $this->CommonModel->getData('tbl_material_issue_items_details',array('deleted_by'=>NULL,'issue_id'=>$value['id']),' sum(issue_qty) as total','','row_array');
                    if(isset($issue_total_qty['total'])){
                        $total_issue_qty=$issue_total_qty['total'];
                    }else{
                        $total_issue_qty=0;
                    }
                
                    $pending_array=$this->ReceiveMaterialIssueModel->getMaterialIssuePendingCount('',array('p.id' =>$value['id']));
                    //echo $this->db->last_query();die;
                   
                    if(isset($pending_array) && !empty($pending_array) && $total_issue_qty){
                        if(isset($total_issue_qty) && isset($pending_array['received_qty'])){
                            $pending_qty=$total_issue_qty-$pending_array['received_qty'];
                        }
                    }

                    array_push($row,$total_issue_qty);
                    array_push($row,$pending_qty);                
                    if($value['is_transfer_completed']==0){
                         $status='<center><span class="badge badge-danger">Pending</span></center>';
                         $flag=1;
                    }else if($value['po_status']==1){
                         $status='<center><span class="badge badge-success">Inprocess</span></center>';
                    }else if($value['po_status']==2){
                         $status='<center><span class="badge badge-success">Completed</span></center>';
                    }
                    array_push($row, $status);
                   
                    $action='';

                    $action='<a href="'.base_url().'admin/store/ReceiveMaterials/issueFromRecevied/'.$value['id'] .'" title="Recevied Material" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;">Recevied Material</a>'; 
                    $action.='<a href="'.base_url().'admin/store/ReceiveMaterials/ViewMaterialIssue/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>'; 

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
    
     public function listReceviedMaterial()
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
       
       
         $on_date = $this->input->post('on_date');
         $from_date = $this->input->post('from_date');
         $to_date = $this->input->post('to_date');
         
         


        if(isset($data['company_id'])&&!empty($data['company_id'])){
              if($data['company_id'] !== 'all'){
                   $where['s1.company_id'] = $data['company_id'];
              }
             
         }else{
             $where['p.company_id'] =userId('company_id');
         }

         if(isset($data['site_id'])&& !empty($data['site_id'])){
              if($data['site_id'] !== 'all'){
                   $where['p.received_location_site_id'] = $data['site_id'];
              }
              // else{
              //      $where['p.received_location_site_id'] =userId('site_id');
              // }
         }else{
             $where['p.site_id'] =userId('site_id');
         } 
         
       
           
         if(isset($on_date)){
                if ($on_date == 1) {
                    $from_date = date('Y-m-d');
                     $where['date(p.received_date)'] = date('Y-m-d',strtotime($from_date));
                 }else if ($on_date == 2) {
                    $from_date = date('Y-m-d', strtotime('-1 days'));
                     $where['date(p.received_date)'] = date('Y-m-d',strtotime($from_date));
                 }else if ($on_date == 3) {
                    $from_date = date('Y-m-d', strtotime('last monday'));
                    $to_date = date('Y-m-d', strtotime('next sunday'));
                    $where['date(p.received_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
                 }else if ($on_date == 4) {
                    $from_date = date('Y-m-d', strtotime('first day of this month'));
                    $to_date = date('Y-m-d', strtotime('last day of this month'));
                    $where['date(p.received_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
        
                 }else if ($on_date == 5) {
                    $from_date = date('Y-m-d', strtotime('01/31'));
                    $to_date = date('Y-m-d', strtotime('12/31'));
                    $where['date(p.received_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
                 }else if($on_date == 6){
                    $from = new DateTime($from_date);
                    $to = new DateTime($to_date);
                    $from_date = $from->format('Y-m-d 00:00:00');
                    $to_date = $to->format('Y-m-d 23:59:59');
                    $where['date(p.received_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
                }
        }
          
         if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
         }
         if(!empty($data['id_itemgroup']) &&  isset($data['id_itemgroup']) && $data['id_itemgroup']!="all"){
            $itemgroup=$data['id_itemgroup'];
         }else{
            $itemgroup='';
         }
      
        
        $count = count($this->ReceiveMaterialIssueModel->getReceviedMaterialData($searchVal,0,0,0,0,0,$where,$item_id,$itemgroup));
        // echo $this->db->last_query();die;
        if($count){
            $result = $this->ReceiveMaterialIssueModel->getReceviedMaterialData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id,$itemgroup);
            // echo $this->db->last_query();die;
                foreach ($result as $key => $value) {
                    $flag=$own_flag_access=0;
                    $row = []; 
                    // $html='<input type="checkbox" class=" form-check-input checkbox_grn_po" value="'.$value['id'].'" >';
                    $html='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['id'].'" title="View Items">';
                    $cnt=$offset + ($key + 1);
                    array_push($row, $html." ".$cnt." ");
                    //  array_push($row,$value['id']);
                    array_push($row, '<a href="javascript:void(0)" title="view" class="" data-toggle="tooltip">'.$value['received_no'].'</a>');
                    array_push($row, dmyDate($value['received_date']));
                    array_push($row, $value['recevier_location_site_name']);
                    array_push($row, $value['sender_location_site_name']);
                    // array_push($row, $value['transfer_first_name']." ".$value['transfer_last_name']);
                    array_push($row, $value['recevier_first_name']." ".$value['recevier_last_name']);
          
                    if($value['is_transfer_completed']==0){
                         $status='<center><span class="badge badge-danger">Inprocess</span></center>';
                         $flag=1;
                    }else if($value['is_transfer_completed']==1){
                         $status='<center><span class="badge badge-success">Completed</span></center>';
                    }else{
                         $status='<center><span class="badge badge-danger">Pending</span></center>';
                         $flag=1;
                    }
                    array_push($row, $status);
                   
                     $action='<a href="'.base_url().'admin/store/ReceiveMaterials/ViewReceviedMaterialIssue/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a> '; 
                      $action .= '<a href="'.base_url().'admin/store/MaterialIssue/issueFromTransfer/'.$value['id'] .'" title="Direct GRN Material Issues " class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px; margin-right: 5px;color: gray !important;"><i class="fas fa-plus" aria-hidden="true"></i></a>';
                    // }

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
    
    public function issueFromRecevied($issue_id){
      
            $data['user_data']= $this->CommonModel->getData('users',array('id'=>userId()),'','','row_array');  
            $data['issue_location']= $this->CommonModel->getData('tbl_site',array('id'=>$data['user_data']['site_id']),'id,site_name','','row_array');
            $MaterialIssueData = $this->MaterialIssueModel->getMaterialIssueData('', 0, 0, 0, 0,$issue_id);
            $data['material_issue'] =  $MaterialIssueData[0];
            $data['item_groups_master'] = $this->CommonModel->getData('tbl_item_groups',array('is_deleted'=>0));
            $data['info_items_data'] = $this->MaterialIssueModel->getMaterialIssueItemData($issue_id,array('mid.is_transfer_completed !='=>1));
       //     echo $this->db->last_query();
              $data['site_master'] = $this->CommonModel->getData('tbl_site');
            foreach($data['info_items_data'] as $key=>$info_item){
                $data['info_items_data'][$key]['item_batch_list'] = $this->MaterialIssueModel->getItemUnitBatchList(array('i.item_id'=>$info_item['item_id']));
                $data['info_items_data'][$key]['item_unit_list'] = $this->MaterialIssueModel->getItemUnitList(array('i.item_id'=>$info_item['item_id']));
                $data['info_items_data'][$key]['item_weight_unit_list'] = $this->MaterialIssueModel->getWeightItemUnitList(array('i.item_id'=>$info_item['item_id']));
                $data['info_items_data'][$key]['item_group_name'] = $this->CommonModel->getData('tbl_item_groups',array('is_deleted'=>0));
                if($info_item['item_group_id']==0){
                  $data['info_items_data'][$key]['item_name'] = $this->CommonModel->getData('tbl_items',array('deleted_by'=>NULL));
                }else{
                  $data['info_items_data'][$key]['item_name'] = $this->CommonModel->getData('tbl_items',array('deleted_by'=>NULL,'item_group'=>$info_item['item_group_id'])); 
                }
                
                
                $issue_total_qty= $this->CommonModel->getData('tbl_material_issue_items_details',array('deleted_by'=>NULL,'issue_id'=>$issue_id,'item_id'=>$info_item['item_id']),' sum(issue_qty) as total','','row_array');
                if(isset($issue_total_qty['total'])){
                    $total_issue_qty=$issue_total_qty['total'];
                }else{
                    $total_issue_qty=0;
                }
                $pending_array=$this->ReceiveMaterialIssueModel->getMaterialIssuePendingCount('',array('p.id' =>$info_item['issue_id'],'pi.item_id'=>$info_item['item_id']));
                
                if(isset($pending_array['received_qty']) && $total_issue_qty ){
                    $data['info_items_data'][$key]['received_qty_query'] = $this->db->last_query();
                    $data['info_items_data'][$key]['received_qty'] = $pending_array['received_qty'];
                    $data['info_items_data'][$key]['pending_qty'] = $total_issue_qty-$pending_array['received_qty'];
                }else{
                    $data['info_items_data'][$key]['received_qty'] = 0;
                    $data['info_items_data'][$key]['pending_qty'] = 0;
                }
                
            
                
            }
            
        //   echo"<pre>";
        //   print_r($data);die;
            $this->load->view(ADMIN.'store/receivematerials/add_material_issue',$data);
    }
    
    
     public function add_receviedmaterialissue($_id='')
    {
            $data['title'] = 'Add Items';
            $data['item_groups_data'] = array();
            $data['stock_unit'] =array();
            $data['units']=array();
        
            $post = $this->input->post();

                
               
                if(isset($post['received_date'])) {
                            //   print_r($post['unload_date']);
                                $formattedDate =strtotime(str_replace('/', '-', $post['received_date']));
                                $received_date = date('Y-m-d',$formattedDate);
                }
               
               
                $insert_items = array(
                        'issue_id' =>isset($post['issue_id'])?$post['issue_id']:NULL,
                        'company_id' =>isset($post['company_id'])?$post['company_id']:NULL,
                        'site_id' => isset($post['site_id'])?$post['site_id']:NULL,
                        'financial_year_id' => isset($post['financial_year_id'])?$post['financial_year_id']:NULL,
                        'received_no' => isset($post['received_no'])?$post['received_no']:NULL, 
                        'received_date' => isset($received_date)?$received_date:NULL, 
                        'received_time' => isset($post['received_time'])?$post['received_time']:NULL, 
                        'received_location_site_id' => isset($post['received_location_site_id'])?$post['received_location_site_id']:NULL,
                        'issue_from_location_site_id' => isset($post['issue_from_location_site_id'])?$post['issue_from_location_site_id']:NULL,
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
                        'transfered_by' => isset($post['transfered_by'])?$post['transfered_by']:NULL,
                        'received_by_id' => isset($post['received_by_id'])?$post['received_by_id']:NULL, 
                    );


                $material_issue_attachement=array();
               
        if ($post) {
                    
                        $insert_items['created_by'] = userId();
                        $insert_id = $this->CommonModel->iudAction('tbl_recevied_material_issue', $insert_items, 'insert');
                        $r_issue_id=$insert_id;
                        $company_id =isset($post['company_id'])?$post['company_id']:userId('company_id');
                        $site_id=isset($post['site_id'])?$post['site_id']:userId('site_id');
                        $financial_year_id=isset($post['financial_year_id'])?$post['financial_year_id']:userId('financial_year_id');
                                 
                    
                    if ($r_issue_id) {

                        if(!empty($post['material_items']) && count($post['material_items']) != 0){
                        foreach($post['material_items'] as $key1=>$value1)
                        {             
                            
                            if(isset($value1['item_unit']) && isset($value1['old_issue_qty'])){
                                $is_complete_transfer=0;
                                $received_qty=$value1['item_unit'];
                                if(isset($value1['received_issue_qty'])){
                                    //
                                    $pending_qty=$value1['old_issue_qty']-$value1['received_issue_qty']-$value1['item_unit'];
                                }else{
                                     $pending_qty=$value1['old_issue_qty']-$value1['item_unit'];
                                }
                                
                                if($pending_qty==0){
                                    $is_complete_transfer=1;
                                    $issue_transfer_status=1;
                                }else{
                                     $issue_transfer_status=0;
                                }
                            }           

                            $material_issue = array(
                                 'issue_id' =>isset($post['issue_id'])?$post['issue_id']:NULL,
                                 'received_id'=>$r_issue_id,
                                 'item_group_id' => isset($value1['item_group_id'])?$value1['item_group_id']:NULL,
                                 'item_id' => isset($value1['items_id'])?$value1['items_id']:NULL,
                                 'received_qty' => isset($value1['item_unit'])?$value1['item_unit']:NULL,
                                 'received_qty_unit' => isset($value1['item_unit_id'])?$value1['item_unit_id']:NULL,
                                 'weight' => isset($value1['weight'])?$value1['weight']:NULL,
                                 'weight_unit' => isset($value1['weight_item_unit_id'])?$value1['weight_item_unit_id']:NULL,
                                 'rate' => isset($value1['rate'])?$value1['rate']:NULL,
                                 'amount' => isset($value1['amount'])?$value1['amount']:NULL,
                                 'remark' => isset($value1['material_issue_remark'])?$value1['material_issue_remark']:NULL,
                                 'batch_no' => isset($value1['batch_no'])?$value1['batch_no']:NULL,
                                 'expired_date' => isset($value1['expired_date'])?$value1['expired_date']:NULL,
                                 'issue_transfer_status' => isset($value1['issue_transfer_status'])?$value1['issue_transfer_status']:0,
                                 'created_at' => userId() ,
                                );  

                          
                           
                                $recevied_item_id=$this->CommonModel->iudAction('tbl_recevied_material_issue_items_details',$material_issue,'insert');
                                
                                $recveied_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['received_location_site_id']),'id,company_id','','row_array');
                                
                                // echo "pending_qty".$pending_qty."<br>";
                                if($pending_qty!=0){
                                    //update the resvered qty
                                     
                                     updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$received_qty,$recveied_company_ids['company_id'],$post['received_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ISSUE_MINUS,RECEVIED_STOCK_TYPE,$r_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],IS_INVENTORY_REVERSED,$recevied_item_id);
                                    //addd invertey
                                    
                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$received_qty,$recveied_company_ids['company_id'],$post['received_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ADD,RECEVIED_STOCK_TYPE,$r_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],0,$recevied_item_id);
                                    
                                    $this->CommonModel->iudAction('tbl_material_issue_items_details', array('is_transfer_completed'=>0,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('issue_id'=>$post['issue_id'],'item_group_id'=>$value1['item_group_id'],'item_id'=>$value1['items_id'],'batch_no'=>$value1['batch_no'],'expired_date'=>$value1['expired_date']));
                                }else if($pending_qty==0){
                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$received_qty,$recveied_company_ids['company_id'],$post['received_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ISSUE_MINUS,RECEVIED_STOCK_TYPE,$r_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],IS_INVENTORY_REVERSED,$recevied_item_id);
                                    //addd invertey
                                    
                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$received_qty,$recveied_company_ids['company_id'],$post['received_location_site_id'],userId('financial_year_id') ,INVENTORY_ACTION_ADD,RECEVIED_STOCK_TYPE,$r_issue_id,userId(),$value1['batch_no'],$value1['expired_date'],0,$recevied_item_id);
                                    
                                    $this->CommonModel->iudAction('tbl_material_issue_items_details', array('is_transfer_completed'=>1,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('issue_id'=>$post['issue_id'],'item_group_id'=>$value1['item_group_id'],'item_id'=>$value1['items_id'],'batch_no'=>$value1['batch_no'],'expired_date'=>$value1['expired_date']));
                                }
                                // echo $this->db->last_query()."<br>";
                                
                            }
                        }
                    $this->updateALLISSUEStatus($post['issue_id'],$r_issue_id);
                    $this->session->set_flashdata('success', 'Material Issue Data Added Succesfully!');
                }else{
                     $this->session->set_flashdata('error','Fail To Add Material Issue Data !');
                }

            if(isset($post['is_material_issue']) && $post['is_material_issue']==1){
                         //$this->session->set_flashdata('success','GRN Successfully');
                redirect(base_url().'admin/store/MaterialIssue/issueFromTransfer/'.$r_issue_id);
            }else{
                redirect(base_url(ADMIN.'store/ReceiveMaterials'));
            }
          
           
        }
        

            $data['user_data']= $this->CommonModel->getData('users',array('id'=>userId()),'','','row_array');  
            $data['issue_location']= $this->CommonModel->getData('tbl_site',array('id'=>userId('site_id')),'id,site_name','','row_array');
            $data['type']=1;
            $this->load->view(ADMIN.'store/materialissue/add_material_issue',$data); 
    }
    public function updateALLISSUEStatus($issue_id,$r_issue_id)
    {
        
        if($issue_id && $r_issue_id){
                $r_item_ids = $this->CommonModel->getData('tbl_material_issue_items_details', array('issue_id' => $issue_id,'deleted_by'=>NULL),'is_transfer_completed');
                
                $flag_completed=1;
                foreach($r_item_ids as $key=>$value){
                    if($value['is_transfer_completed']==0){
                        $flag_completed=0;
                    }
                }
              
                         
                if($flag_completed==1){
                      $this->CommonModel->iudAction('tbl_material_issue', array('is_transfer_completed'=>1,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $issue_id));
                        $this->CommonModel->iudAction('tbl_recevied_material_issue', array('is_transfer_completed'=>1,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $r_issue_id));
                        
                }else{
                     $this->CommonModel->iudAction('tbl_material_issue', array('is_transfer_completed'=>0,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $issue_id));
                }
         
                   
        }
        // code...
    }
    public function parentTableData(){
            // Simulated parent table data
        $parentTableData = array(
            array("id" => 1, "name" => "John", "age" => 30),
            array("id" => 2, "name" => "Alice", "age" => 25),
            array("id" => 3, "name" => "Bob", "age" => 35)
        );
        
        // Output the parent table data as JSON
        header('Content-Type: application/json');
        echo json_encode($parentTableData);
    }
    
      public function childTableData(){
        if (isset($_GET['outerTableId'])) {
            $outerTableId = $_GET['outerTableId'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $innerTableData = array(
                array("detail1" => "Detail A", "detail2" => "Detail B"),
                array("detail1" => "Detail C", "detail2" => "Detail D"),
                // Add more inner table data here
            );
        
            // Output the inner table data as JSON
            header('Content-Type: application/json');
            echo json_encode($innerTableData);
        } else {
            // Handle error if outerTableId parameter is not provided
            header("HTTP/1.0 400 Bad Request");
            echo "Error: outerTableId parameter is missing";
        }
    }
      public function receviedItemTableData(){
        if (isset($_GET['received_id'])) {
            $received_id = $_GET['received_id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['material'] =$this->ReceiveMaterialIssueModel->getReceviedMaterialItems(array('pi.received_id'=>$received_id));
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/receivematerials/inner_items_table', $data,true);
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
    
     public function listReceviedMaterialItemsData()
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
         
         if($data['received_material_issue_id']){
            $where['pi.received_id'] = $data['received_material_issue_id'];
         }

         $count = count($this->ReceiveMaterialIssueModel->getReceviedMaterialItemsData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->ReceiveMaterialIssueModel->getReceviedMaterialItemsData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
           
               foreach ($result as $key => $value) {
                 $row = []; 
                 array_push($row, $offset+($key+1));
                 array_push($row, $value['short_name']);
                 array_push($row, $value['item_group_name']);
                 array_push($row, $value['received_qty']);
                 array_push($row, $value['weight']);
                 array_push($row, $value['rate']);
                 array_push($row, $value['amount']);
                 array_push($row, $value['remark']);
                 $confirm = "confirm('Are you sure you want to delete this Material Issue?')";
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
         $count = count($this->ReceiveMaterialIssueModel->MaterialIssueItemDataView($searchVal,0,0,0,0,0,$where));
       //  echo $this->db->last_query();die;
         if($count){
             $result = $this->ReceiveMaterialIssueModel->MaterialIssueItemDataView($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
            // echo '<pre>'; print_r($result);die;
               foreach ($result as $key => $value) {
                 $row = []; 
                 array_push($row, $offset+($key+1));
                 array_push($row, $value['short_name']);
                 array_push($row, $value['item_group_name']);
                 array_push($row, $value['issue_qty']);
                 array_push($row, $value['weight']);
                 array_push($row, $value['rate']);
                 array_push($row, $value['amount']);
                 if($value['is_returnable']==1){
                    array_push($row, "Yes");
                 }else{
                    array_push($row, "No");
                 }
                //  if($value['returnable_date']=="0000-00-00"){
                //     array_push($row, "-");
                //  }else{
                //     array_push($row, dmyDate($value['returnable_date']));
                //  }
                 array_push($row, $value['remark']);
                 $confirm = "confirm('Are you sure you want to delete this Material Issue?')";
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
       public function ViewReceviedMaterialIssue($recevied_material_issue_id='')
    {
        $recevied_material_issue_data = $this->ReceiveMaterialIssueModel->viewReceviedMaterialData($recevied_material_issue_id);
        $data = $recevied_material_issue_data[0];
       
        // $data['return_by'] = $this->CommonModel->getData('users',array('id'=>$data['return_by']),'concat(first_name," ",last_name) as return_by_user_name,id','','row_array');
        // $data['received_by'] = $this->CommonModel->getData('users',array('id'=>$data['received_by']),'concat(first_name," ",last_name) as received_user_name,id','','row_array');
           
        // echo "<pre>"; print_r($data);die;    
        $this->load->view(ADMIN.'store/receivematerials/view_receive_material_issue',$data);
    }


    public function ViewMaterialIssue($material_issue_id='')
    {
        $material_issue_data = $this->ReceiveMaterialIssueModel->viewMaterialIssueTransferData($material_issue_id);
        $data = $material_issue_data[0];
       
        // $data['return_by'] = $this->CommonModel->getData('users',array('id'=>$data['return_by']),'concat(first_name," ",last_name) as return_by_user_name,id','','row_array');
        // $data['received_by'] = $this->CommonModel->getData('users',array('id'=>$data['received_by']),'concat(first_name," ",last_name) as received_user_name,id','','row_array');
           
        // echo "<pre>"; print_r($data);die;    
        $this->load->view(ADMIN.'store/receivematerials/view_material_issue',$data);
    }
    	public function receviedInnearItemTableData(){
	     if (isset($_GET['id'])) {
            $_id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['material'] = $this->MaterialIssueModel->getMaterialIssueItemData($_id,array('mid.is_transfer_completed !='=>1));
            //  echo $this->db->last_query();die;
              foreach($data['material'] as $key=>$info_item){
                $total_issue_qty=0;
                $issue_total_qty= $this->CommonModel->getData('tbl_material_issue_items_details',array('deleted_by'=>NULL,'issue_id'=>$_id,'item_id'=>$info_item['item_id']),' sum(issue_qty) as total','','row_array');
                if(isset($issue_total_qty['total'])){
                    $total_issue_qty=$issue_total_qty['total'];
                }else{
                    $total_issue_qty=0;
                }
                $pending_array=$this->ReceiveMaterialIssueModel->getMaterialIssuePendingCount('',array('p.id' =>$info_item['issue_id'],'pi.item_id'=>$info_item['item_id']));
             //  echo $this->db->last_query();
                if(isset($pending_array['received_qty']) && $pending_array['received_qty']!=0 && $total_issue_qty ){
                    $data['material'][$key]['received_qty_query'] = $this->db->last_query();
                    $data['material'][$key]['received_qty'] = $pending_array['received_qty'];
                    $data['material'][$key]['______total_issue_qty'] = $total_issue_qty;
                    $data['material'][$key]['pending_qty'] = $total_issue_qty-$pending_array['received_qty'];
                }else{
                    $data['material'][$key]['received_qty'] = 0;
                    $data['material'][$key]['pending_qty'] = 0;
                }
                
                
            }
            // echo "<pre>";
            // print_r($data['material']);die;
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/receivematerials/rececied_inner_items_table', $data,true);
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