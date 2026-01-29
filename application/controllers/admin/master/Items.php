<?php
/**
 * 
 */
class Items extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'master/ItemsModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Items Master';
       
      $this->load->view(ADMIN.'master/Items/list_items',$data);
    }
   public function listItems()
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
       
        if($data['item_name'] == "all" ){
            if($data['id_itemgroup'] == "all" ){
                 $where = array();
                if($data['id_stock'] == "all"){
                   $where = array();
                }else{
                   $where['mu.id'] = $data['id_stock'];
                }

            }else{
                $where['ig.id'] = $data['id_itemgroup'];
            }

         }else{
            $where['i.id'] = $data['item_name'];
         }



        if($data['id_itemgroup'] == "all"){
            if($data['item_name'] == "all" ){
                $where = array();
                
                if($data['id_stock'] == "all"){
                   $where = array();
                }else{
                   $where['mu.id'] = $data['id_stock'];
                }

            }else{
                $where['i.id'] = $data['item_name'];
            }

         }else{
            $where['ig.id'] = $data['id_itemgroup'];
         }



         if($data['id_stock'] == "all"){
            if($data['item_name'] == "all" ){
                 $where = array();
                if($data['id_itemgroup'] == "all"){
                   $where = array();
                }else{
                   $where['ig.id'] = $data['id_itemgroup'];
                }

            }else{
                $where['i.id'] = $data['item_name'];
            }

         }else{
            $where['mu.id'] = $data['id_stock'];
         }

          if($limit==-1){
              $limit=0;
          }
         $count = count($this->ItemsModel->getitemsData($searchVal,0,0,0,0,0,$where));
        //  echo $this->db->last_query();die;
         if($count){
             $result = $this->ItemsModel->getitemsData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
            // echo '<pre>'; print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['item_name']);
                 array_push($row, $value['short_name']);
                 array_push($row, $value['item_code']);
                 array_push($row, $value['hsn_code']);
                 // array_push($row, $value['hsn_code']);
                 
                 array_push($row, $value['unit_name']);
                 array_push($row, $value['item_group_name']);
                 array_push($row, $value['rate']);
                 array_push($row,date('d-m-Y h:i a',strtotime($value['created_at']))."<br>". $value['created_by_fname']." ".$value['created_by_lname']);
                 if(isset($value['updated_at'])){
                      array_push($row,date('d-m-Y h:i a',strtotime($value['updated_at']))."<br>". $value['updated_by_fname']." ".$value['updated_by_lname']);
                 }else{
                      array_push($row,'-');
                 }
                
                 
                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
                 <a href="'.base_url().'admin/master/Items/add_items/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';

                  $action.='<a href="'.base_url().'admin/master/Items/view_items/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
                  if (getUserAccessForModule('Items', 'delete')):
                    $action.='<a onclick="return '.$confirm.'" href="'.base_url() .'admin/master/Items/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                     else:
                           $action.= '';
                       endif;
                       
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

    public function add_items($_id='')
    {
            $data['title'] = 'Add Items';
            $data['item_groups_data'] = array();
            $data['stock_unit'] =array();
            $data['units']=array();
            $post = $this->input->post();
        
       if ($post) {
            if (empty($post['id'])) {
            	
                 $insert_items['item_name'] = $post['item_name'];
                   $insert_items['short_name'] = $post['short_name'];
                   $insert_items['hsn_code'] = $post['hsn_code'];
                   $insert_items['item_group'] = $post['item_group'];
                   $insert_items['stock_unit'] = $post['stock_unit'];
                   $insert_items['rate'] = $post['rate'];
                   $insert_items['created_by'] = userId();
                   $insert_items['created_at'] = date('Y-m-d H:i:s');

                 $insert_id = $this->CommonModel->iudAction('tbl_items', $insert_items, 'insert');
                 
                    if($insert_id) {
                        $item_code=$insert_id;
                        
                        $this->CommonModel->iudAction('tbl_items',array('item_code'=>$item_code),'update', array('id' => $insert_id));
                            
                        if(isset($post['unit_id'])){
                            foreach($post['unit_id'] as $key=>$value){
                                 $this->CommonModel->iudAction('tbl_items_units',array('item_id'=>$insert_id ,'unit_id'=>$value),'insert');
                                   
                            }
                        }
                    
                        $insert_approve_item_rate = array(
                                'item_group_id' => (isset($post['item_group'])) ? $post['item_group'] :NULL,
                                'item_id' => (isset($insert_id)) ? $insert_id :NULL,
                                'reference_id' => (isset($insert_id)) ? $insert_id :NULL,
                                'company_id' => userId('company_id'),
                                'site_id' => userId('site_id'), 
                                'new_rate' => (isset($post['rate'])) ? $post['rate'] :'0',
                                'type' => 2,
                        );



                        $this->CommonModel->iudAction('tbl_approved_item_rate',$insert_approve_item_rate,'insert');
                        $this->session->set_flashdata('success', 'Items Added Succesfully!');
                        
                    }else{
                      $this->session->set_flashdata('error','Fail To Add Items!');
                    }
                
                   
            }else{

                $old_rate = $this->CommonModel->getData('tbl_items',array('id'=>$post['id']),'id,rate','','row_array');
              
                    $update_items['item_name'] = $post['item_name'];
                    $update_items['short_name'] = $post['short_name'];
                    $update_items['hsn_code'] = $post['hsn_code'];
                    $update_items['item_group'] = $post['item_group'];
                    $update_items['stock_unit'] = $post['stock_unit'];
                    $update_items['rate'] = $post['rate'];
                    $update_items['updated_at'] =  date('Y-m-d H:m:s');
                    $update_items['updated_by'] = userId();
                    
                //   $update_items['created_at'] = date('Y-m-d H:i:s');

                $this->CommonModel->iudAction('tbl_items',$update_items,'update', array('id' => $post['id']));
 



         if(isset($post['unit_id'])){
           $new_array = $post['unit_id'];
            $new_items1 = implode(',',$new_array);
            $items_ids = $this->CommonModel->getData('tbl_items_units',array('item_id'=> $post['id'] ));
            $new_old_array = array_column($items_ids,'unit_id');
            $new_items_id=$post['unit_id'];
            $result=array_diff($new_items_id,$new_old_array);
            $result1=array_diff($new_old_array,$new_items_id);
            $marge = array_merge($result, $result1); 
           
             foreach ($marge as $key => $value) {
                            if(in_array($value, $new_items_id)) {
                             $is_exist = $this->CommonModel->getData('tbl_items_units',array('item_id'=> $post['id'],'unit_id'=>$value),'','','num_rows');
                        
                               $items_id_update = array(
                                    array(
                                        'unit_id'=> $value, 
                                        'item_id' =>$post['id'] ,
                                        'created_by'=>userId()
                                    )
                                );
                                 if($is_exist==0){
                                      $this->db->insert_batch('tbl_items_units',$items_id_update, 'insert');
                                 }
                              
                            } else {
                                $is_exist_item = $this->CommonModel->getData('tbl_items_units',array('item_id'=> $post['id'],'unit_id'=>$value),'id','','row_array');
                                $is_exist = $this->CommonModel->getData('tbl_items_inventory_details',array('item_unit_id'=> $is_exist_item['id'],'item_id'=>$post['id']),'','','num_rows');
                                 if($is_exist==0){
                                      $this->CommonModel->iudAction('tbl_items_units','', 'delete', array('unit_id' =>$value,'item_id'=>$post['id']));
                                 }else{
                                      $this->session->set_flashdata('error','Items NOt deleted used In inventory Succesfully!');
                                     
                                 }
                            }
                        }


            }
            // die;
                $update_approve_item_rate = array(
                        'item_group_id' => (isset($post['item_group'])) ? $post['item_group'] :NULL,
                        'item_id' => (isset($post['id'])) ? $post['id'] :NULL,
                        'reference_id' => (isset($post['id'])) ? $post['id'] :NULL,
                        'company_id' => userId('company_id'),
                        'site_id' => userId('site_id'), 
                        'old_rate' => (isset($old_rate['rate'])) ? $old_rate['rate'] :'0',
                        'new_rate' => (isset($post['rate'])) ? $post['rate'] :'0',
                        'type' => 2,
                        'updated_at' => date('Y-m-d H:m:s'),
                        'updated_by' => userId(),
                    );

              $this->CommonModel->iudAction('tbl_approved_item_rate',$update_approve_item_rate,'update',array('item_id'=>$post['id'] ,'item_group_id'=> $post['item_group']));



          $this->session->set_flashdata('success','Items Updated Succesfully!');
             
        
            }
            redirect(base_url(ADMIN.'master/Items'));
        }
      
        if($_id){
            $itemsData = $this->ItemsModel->getitemsData('', 0, 0, 0, 0,$_id);
            $data =  $itemsData[0];
            $data['title'] = 'Edit Items Data';    
            $data['item_groups_data'] = $this->CommonModel->getData('tbl_item_groups',array('id'=>$data['item_group']),'id,item_group_name');
            $data['stock_unit'] = $this->CommonModel->getData('tbl_master_unit',array('id'=>$data['stock_unit']),'id,unit_name');
            $data['units']= $this->ItemsModel->item_unit($_id);
        }
          
       
        $this->load->view(ADMIN.'master/Items/add_items',$data); 
    }

       public function view_items($id)
    {
     $data['title'] = 'Items';
   
     $Items = $this->ItemsModel->viewItemsData($id);
     $data['Items'] = $Items[0]; 
      $data['units']= $this->ItemsModel->item_unit($id);

       // echo "<pre>";print_r($data);die;
     $this->load->view(ADMIN.'master/Items/view_items',$data);
    }


        public function listItemgroupName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $itemgroupData = $this->ItemsModel->getitemgroupName('');
        } else {
            $search = $_GET['searchTerm'];
            $itemgroupData = $this->ItemsModel->getitemgroupName($search);
        }
        $json[] = ['id'=>'all', 'text'=>'Select All'];
        foreach ($itemgroupData as $key => $value) {
            
            $json[] = ['id' => $value['id'], 'text' => $value['item_group_name']];
        }
        echo json_encode($json);
    }

     public function liststock_unit($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $stock_unitData = $this->ItemsModel->getstockunitName('');
        } else {
            $search = $_GET['searchTerm'];
            $stock_unitData = $this->ItemsModel->getstockunitName($search);
        }
        $json[] = ['id'=>'all', 'text'=>'Select All'];
        foreach ($stock_unitData as $key => $value) {
            
            $json[] = ['id' => $value['id'], 'text' => $value['unit_name']];
        }
        echo json_encode($json);
    }

    
     public function listItemName($value='')
      {
          if(!isset($_GET['searchTerm'])){ 
              $json = [];
              $listitem_name=$this->ItemsModel->getitemName('');
          }else{
              $search = $_GET['searchTerm'];
              $listitem_name=$this->ItemsModel->getitemName($search);
          }
            $json[] = ['id'=>'all', 'text'=>'Select All'];
             foreach ($listitem_name as $key => $value) {
              
              $json[] = ['id'=>$value['id'], 'text'=>$value['item_name']];
              }  
          echo json_encode($json);
      }

    public function delete($id)
    {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_items',array('deleted_by'=>isLogin(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$id))){
               
                $this->session->set_flashdata('success','Items Data Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete Items Data');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'master/Items'));
    }

}