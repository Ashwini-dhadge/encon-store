<?php
/**
 * 
 */
class GoodsItemOpening extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'store/GoodsItemOpeningModel');
         $this->load->model(ADMIN.'CommonCustModel');
         
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'GoodsItemOpening';
        $this->load->view(ADMIN.'store/goods_item_opening/list_goods_item_opening',$data);
    }

    public function add_goods_item_opening($id=''){
         $post = $this->input->post();
        if(isset($post) && !empty($post)){
                // echo "<pre>";
                // print_r($post);
                // die;
               
                    $opening_arr = array(
                        'company_id' =>isset($post['company_id'])?$post['company_id']:userId('company_id'),
                        'site_id' => isset($post['site_id'])?$post['site_id']:userId('site_id'),
                        'financial_year_id' => isset($post['financial_year_id'])?$post['financial_year_id']:userId('financial_year_id'),
                        'remark' => isset($post['remark'])?$post['remark']:NULL, 
                        'location_id'=>isset($post['location_id'])?$post['location_id']:NULL, 
                        'total_qty'=>isset($post['total_qty'])?$post['total_qty']:NULL, 
                    );
                    
                    if(empty($post['id'])) {
                        $opening_arr['created_by'] = userId();
                        $insert_id = $this->CommonModel->iudAction('tbl_items_opening_stock', $opening_arr, 'insert');
                        $opening_id=$insert_id;
                        $company_id =isset($post['company_id'])?$post['company_id']:userId('company_id');
                        $site_id=isset($post['site_id'])?$post['site_id']:userId('site_id');
                        $financial_year_id=isset($post['financial_year_id'])?$post['financial_year_id']:userId('financial_year_id');
                                 
                    }else{
                        $opening_arr['updated_at'] = date('Y-m-d');
                        $opening_arr['updated_by'] = userId();
                        $this->CommonModel->iudAction('tbl_items_opening_stock', $opening_arr, 'update', array('id' => $post['id']));
                        $insert_id=$post['id']; 
                        $opening_id=$insert_id;
                    }
                    // print_r($post['items']);
                    // echo $opening_id;
                    
                    if(!empty($post['items']) && count($post['items']) != 0){
                        foreach($post['items'] as $key1=>$value1)
                        {             
                                
                                if(isset($value1['op_item_id'])){
                                    $get_issue_item_data = $this->CommonModel->getData('tbl_items_opening_stock_details', array('id' =>$value1['op_item_id']),'','','row_array'); 
                                }else{
                                    $get_issue_item_data = $this->CommonModel->getData('tbl_items_opening_stock_details', array('opening_id' =>$post['id'],'deleted_by' => NULL ,'item_id'=>$value1['items_id'],'opening_unit_id'=>$value1['item_unit_id'],'batch_no'=>$value1['batch'],'expired_date'=>$value1['expired_date']),'','','row_array'); 
                                     
                                }
                                           
                                if(isset($value1['op_item_id'])){
                                    if($value1['old_opening_qty']==$value1['item_unit']){
                                    $is_update=0;
                                    $is_add=0;
                                    $is_minus=0;
                                    $update_qty=0;
                                    }else{
                                          $is_update=1;
                                          if($value1['old_opening_qty'] > $value1['item_unit']){
                                              $update_qty=$value1['old_opening_qty']-$value1['item_unit'];
                                              $is_add=0;
                                              $is_minus=1;
                                          }else{
                                              $update_qty=$value1['item_unit']-$value1['old_opening_qty'];
                                              $is_add=1;
                                              $is_minus=0;
                                          }
                                    }
                                }else{
                                    $is_update=1;
                                    $is_add=1;
                                    $is_minus=0;
                                    $update_qty=isset($value1['item_unit'])?$value1['item_unit']:0;
                                }
                                
                                if(isset($value1['item_weight']) && !empty($value1['item_weight'])){
                                    $weight_per_qty=$value1['item_weight']/$value1['item_unit'];
                                    $rate_per_weight=$value1['item_rate']/$value1['item_unit'];
                                }else{
                                    $weight_per_qty=NULL;
                                    $rate_per_weight=NULL;
                                }
                                
                              
                                  
                                $material_issue = array(
                                                         'opening_id'=> $opening_id, 
                                                         'item_group_id' => isset($value1['item_group_id'])?$value1['item_group_id']:NULL,
                                                         'item_id' => isset($value1['items_id'])?$value1['items_id']:NULL,
                                                         'pur_date' => isset($value1['purchase_date'])?date('Y-m-d',strtotime($value1['purchase_date'])):NULL,
                                                         'opening_stock_type' => isset($value1['opening_stock_type'])?$value1['opening_stock_type']:NULL,
                                                         'at_party' => isset($value1['at_party'][0])?$value1['at_party'][0]:NULL,
                                                         'opening_qty' => isset($value1['item_unit'])?$value1['item_unit']:NULL,
                                                         'opening_unit_id' => isset($value1['item_unit_id'])?$value1['item_unit_id']:NULL,
                                                         'opening_weight' => isset($value1['item_weight'])?$value1['item_weight']:NULL,
                                                         'unit_rate' => isset($value1['item_unit_rate'])?$value1['item_unit_rate']:NULL,
                                                         'item_amt' => isset($value1['item_rate'])?$value1['item_rate']:NULL,
                                                         'item_rate_type'=> isset($value1['item_rate_type'])?$value1['item_rate_type']:NULL,
                                                         'batch_no' => isset($value1['batch'])?$value1['batch']:NULL,
                                                         'expired_date' => isset($value1['expired_date'])?$value1['expired_date']:NULL,
                                                         'discount_percent'=> isset($value1['discount_percent'])?$value1['discount_percent']:NULL,
                                                         'discount_type' => isset($value1['discount_type'])?$value1['discount_type']:NULL,
                                                         'discount_amount' => isset($value1['discount_amount'])?$value1['discount_amount']:NULL,
                                                         'created_at' => userId() ,
                                                         'weight_per_qty'=>$weight_per_qty,
                                                         'weight_per_rate'=>$rate_per_weight
                                                        );  
                                
                                
                                                        
                                if(isset($get_issue_item_data['id']) && !empty($get_issue_item_data['id'])){
                                    $material_issue['updated_by']=userId();
                                    $material_issue['updated_at']=date('Y-m-d H:i:s');
                                     
 
                                    $this->CommonModel->iudAction('tbl_items_opening_stock_details', $material_issue, 'update', array('id' => $get_issue_item_data['id']));
                                    $opening_sub_id= $get_issue_item_data['id'];
                                }else{
                                    $opening_sub_id=$this->CommonModel->iudAction('tbl_items_opening_stock_details', $material_issue, 'insert');
                                }
                                
                                
                                
                                //
                                
                                $location_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$post['location_id']),'id,company_id','','row_array');
                                if(isset($get_issue_item_data['id'])){
                                    updateQtyRateInventory($opening_id,$opening_sub_id,OPENING_STOCK_TYPE,$value1['item_unit'],$value1['item_rate_type'],$value1['item_weight'],$value1['item_unit_rate'],$value1['items_id'],$value1['item_unit_id'],$location_company_ids['company_id'],$post['location_id'],userId('financial_year_id'),$value1['batch'],$value1['expired_date'],$update_qty,$is_add,$is_minus);  
                                  
                                    // if($is_minus){
                                    //      updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$update_qty,$location_company_ids['company_id'],$post['location_id'],userId('financial_year_id') ,INVENTORY_ACTION_ISSUE_MINUS,OPENING_STOCK_TYPE,$opening_id,userId(),$value1['batch'],$value1['expired_date'],$opening_sub_id); 
                                    // }
                                }else{
                                    updateQuickInventory($value1['items_id'],$value1['item_unit_id'],$value1['item_unit'],$location_company_ids['company_id'],$post['location_id'],userId('financial_year_id') ,INVENTORY_ACTION_ADD,OPENING_STOCK_TYPE,$opening_id,userId(),$value1['batch'],$value1['expired_date'],0,$opening_sub_id,$value1['item_rate_type'],$value1['item_weight'],$value1['item_unit_rate']); 
                                }
                               
                                    
                              
                        }
                    }
                    $this->session->set_flashdata('success', 'Opening Stock Data Added Succesfully!');
                    redirect(base_url(ADMIN.'store/GoodsItemOpening'));
        }else{
            if($id){
                $opening_id = $this->GoodsItemOpeningModel->getOpeningStockData('',0,0,0,0,$id,'','');
              //  echo $this->db->last_query();
                $data['opening_data']= $opening_id[0];
                $data['opening_data_items']= $this->GoodsItemOpeningModel->getOpeningItemDataALL(array('p.id'=>$id));;
                
                // 	echo "<pre>";
                // 	print_r($data);
                // 	die;
                		$this->load->view(ADMIN.'store/goods_item_opening/add_goods_item_opening',$data);
            }else{
                	$this->load->view(ADMIN.'store/goods_item_opening/add_goods_item_opening');
            }
            
        }
    
    }
     public function add_goods_item_opening1(){
         	$this->load->view(ADMIN.'store/goods_item_opening/add_goods_item_opening1');
     }
     public function stockDelete(){
       $flag=0;
       // $po_item_id=$post['po_item_id'];
        $post = $this->input->post();
        $opening_id=$post['opening_id'];
        if($opening_id){
        
        $data = $this->CommonModel->getData('tbl_items_opening_stock', array('id' => $opening_id), '', '', 'row_array');
        $item_data=$this->CommonModel->getData('tbl_items_opening_stock_details', array('opening_id' => $opening_id,'deleted_by'=>NULL), '', '', '');
        
        // echo "<pre>";
        // print_r($data);
        // print_r($item_data);
        if(!empty($data) && !empty($item_data)){
             
                 //delete ISSUE  and GRN ITEM
                 
                $this->CommonModel->iudAction('tbl_items_opening_stock',array('deleted_reason'=>$post['reason'],'deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$opening_id));
                // $this->CommonModel->iudAction('tbl_grn_attachment',array('deleted_at'=> date('Y-m-d H:i:s'),'deleted_by'=>userId()),'update',array('grn_id'=>$grn_id));
  
                foreach($item_data as $key=>$item){
                    $this->CommonModel->iudAction('tbl_items_opening_stock_details',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$item['id']));   
                     //delete from inventory
                     $location_company_ids= $this->CommonModel->getData('tbl_site',array('id'=>$data['location_id']),'id,company_id','','row_array');
                     
                    updateQuickInventory($item['item_id'],$item['opening_unit_id'],$item['opening_qty'],$location_company_ids['company_id'],$data['location_id'],$data['financial_year_id'],INVENTORY_ACTION_ISSUE_MINUS,OPENING_STOCK_TYPE,$opening_id,userId(),$item['batch_no'],$item['expired_date'],0,$item['id']);
                    // echo $this->db->last_query();   
                   // echo $this->db->last_query();die;
                } 
  
                $description="Opening Stock deleted - by ".userId('name');
                $json_data_login=encode_arr($grn_data);
                //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');
        
                ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor 5:Store
                 //sub_ref_type:1 tbl_user
                $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,5,$opening_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
                updateInActionLogFile($data_action_log_array);
                // die;
             //  $this->session->set_flashdata('success','PO Items Deleted');
               $response['result']=true;
               $response['reasons']="Opening Stock Items Deleted";
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
    
    public function list_opening_stock()
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
         
         


         if(isset($data['vendor_id']) && !empty($data['vendor_id'])){
            $where['mi.vendor_id'] = $data['vendor_id'];
         } 
          if(isset($data['company_id'])&&!empty($data['company_id'])){
              if($data['company_id'] !='all'){
                   $where['s.company_id'] = $data['company_id'];
              }
         }else{
             //$where['p.company_id'] =userId('company_id');
         }
          if(isset($data['site_id'])&& !empty($data['site_id'])){
              if($data['company_id'] !='all'){
                   $where['mi.location_id'] = $data['site_id'];
              }
         }else{
             //$where['p.site_id'] =userId('site_id');
         } 
         if(empty($data['company_id']) &&  empty($data['site_id'])){
             $where['s.company_id'] =userId('company_id');
             $where['mi.location_id'] =userId('site_id');
         }
         if(isset($on_date)){
              if ($on_date == 1) {
            $from_date = date('Y-m-d');
             $where['date(mi.created_at)'] = date('Y-m-d',strtotime($from_date));
         }else if ($on_date == 2) {
            $from_date = date('Y-m-d', strtotime('-1 days'));
             $where['date(mi.created_at)'] = date('Y-m-d',strtotime($from_date));
         }else if ($on_date == 3) {
            $from_date = date('Y-m-d', strtotime('last monday'));
            $to_date = date('Y-m-d', strtotime('next sunday'));
            $where['date(mi.created_at) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
         }else if ($on_date == 4) {
            $from_date = date('Y-m-d', strtotime('first day of this month'));
            $to_date = date('Y-m-d', strtotime('last day of this month'));
            $where['date(mi.created_at) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;

         }else if ($on_date == 5) {
            $from_date = date('Y-m-d', strtotime('01/31'));
            $to_date = date('Y-m-d', strtotime('12/31'));
            $where['date(mi.created_at) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
         }else if($on_date == 6){
            $from = new DateTime($from_date);
            $to = new DateTime($to_date);
            $from_date = $from->format('Y-m-d 00:00:00');
            $to_date = $to->format('Y-m-d 23:59:59');
            $where['date(mi.created_at) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
        }
         }
         
        if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
         }
       
         $count = count($this->GoodsItemOpeningModel->getOpeningStockData($searchVal,0,0,0,0,0,$where,$item_id));
        //  echo $this->db->last_query();die;
         if($count){
               $result = $this->GoodsItemOpeningModel->getOpeningStockData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id);
            // echo '<pre>'; print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 
                  $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['id'].'" title="View Items">';
                 array_push($row, $offset+($key+1)." ".$html1);
                 array_push($row, $value['company_name']);
                 array_push($row, $value['site_name']);
                 
                  array_push($row, $value['remark']);
                 array_push($row, $value['total_qty']);
                  array_push($row, $value['created_by_name']);
                 $flag=$own_flag_access=0;
                if($value['created_by']==userId()){
                        $own_flag_access=1;
                }
               
                
                $confirm = "confirm('Are you sure you want to delete this Opening Stock . Its effect on item Inventory ?')";
                    if(getUserAccessForModule('Store','delete') || ($own_flag_access) || userId('role_id')==SUPERADMIN_ROLE):
                        // $action .= ' <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/store/GoodsReceiptNote/grnDelete/' . $value['grn_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                         $action = '<a href="javascript:void(0)" data-toggle="modal" data-target="" title="delete" class="btn btn-primary waves-effect waves-light btn-sm deleteBtn"  onclick="deleteBtn('.$value['id'] .')"  data-toggle="tooltip" style="font-size:13px;color: gray !important;"><i class="fas fa-trash" aria-hidden="true"></i></a>';

                    endif;
                    
                //   $action .='<a href="'.base_url().'admin/store/MaterialIssue/view_material_issue/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
              //  if(userId()==13){
                       $action .= '<a href="'.base_url().'admin/store/GoodsItemOpening/add_goods_item_opening/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
              //  }    
              
      
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
    public function innearItemTableData(){
	     if (isset($_GET['id'])) {
            $po_id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['items']= $this->GoodsItemOpeningModel->getOpeningItemDataALL(array('p.id'=>$po_id));;
            // echo "<pre>";
            // print_r($data['po_info_items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/goods_item_opening/inner_items_table', $data,true);
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