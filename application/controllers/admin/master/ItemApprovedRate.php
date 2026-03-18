<?php
/**
 * 
 */
class ItemApprovedRate extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'master/ItemApprovedRateModel');
         $this->load->model(ADMIN.'CommonModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Approved Item Rate';
       
      $this->load->view(ADMIN.'master/item_approved/list_approved_item',$data);
    }

   public function listItemApproved()
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
        
         if($data['item_group_name'] == 'all'){
            if($data['company_id'] == 'all'){
                if($data['site_id'] == 'all'){
                    if($data['vendor_id'] == 'all'){
                         if($data['item_name_id']== 'all'){
                            if($data['is_approved'] == 'all'){
                                $where = array();
                             }else{
                                $where['ar.is_approved'] = $data['is_approved'];
                             }
                         }else if($data['item_name_id']){
                            $where['ar.item_id'] = $data['item_name_id'];
                         }
                     }else if($data['vendor_id']){
                        $where['ar.vendor_id'] = $data['vendor_id'];
                     }
                 }else if($data['site_id']){
                    $where['ar.site_id'] = $data['site_id'];
                 }
            }else if($data['company_id']){
                $where['ar.company_id'] = $data['company_id'];
            }
         }else if($data['item_group_name']){
            $where['ar.item_group_id'] = $data['item_group_name'];
         }


         if($data['item_name_id']== 'all'){
           if($data['company_id'] == 'all'){
                if($data['site_id'] == 'all'){
                    if($data['vendor_id'] == 'all'){
                         if($data['item_group_name'] == 'all'){
                           if($data['is_approved'] == 'all'){
                                $where = array();
                             }else{
                                $where['ar.is_approved'] = $data['is_approved'];
                             }
                         }else if($data['item_group_name']){
                            $where['ar.item_group_id'] = $data['item_group_name'];
                         }
                     }else if($data['vendor_id']){
                        $where['ar.vendor_id'] = $data['vendor_id'];
                     }
                }else if($data['site_id']){
                    $where['ar.site_id'] = $data['site_id'];
                }
            }else if($data['company_id']){
                $where['ar.company_id'] = $data['company_id'];
            }
         }else if($data['item_name_id']){
            $where['ar.item_id'] = $data['item_name_id'];
         }



         if($data['vendor_id'] == 'all'){
            if($data['company_id'] == 'all'){
                if($data['site_id'] == 'all'){
                    if($data['item_group_name'] == 'all'){
                        if($data['item_name_id']== 'all'){
                            if($data['is_approved'] == 'all'){
                                $where = array();
                             }else{
                                $where['ar.is_approved'] = $data['is_approved'];
                             }
                         }else if($data['item_name_id']){
                            $where['ar.item_id'] = $data['item_name_id'];
                         }
                     }else if($data['item_group_name']){
                        $where['ar.item_group_id'] = $data['item_group_name'];
                     }
             }else if($data['site_id']){
                $where['ar.site_id'] = $data['site_id'];
             }

             }else if($data['company_id']){
                $where['ar.company_id'] = $data['company_id'];
             }
         }else if($data['vendor_id']){
            $where['ar.vendor_id'] = $data['vendor_id'];
         }




         if($data['company_id'] == 'all'){
            if($data['site_id'] == 'all'){
                 if($data['vendor_id'] == 'all'){
                    if($data['item_group_name'] == 'all'){
                        if($data['item_name_id']== 'all'){
                            if($data['is_approved'] == 'all'){
                                $where = array();
                             }else{
                                $where['ar.is_approved'] = $data['is_approved'];
                             }
                         }else if($data['item_name_id']){
                            $where['ar.item_id'] = $data['item_name_id'];
                         }
                     }else if($data['item_group_name']){
                        $where['ar.item_group_id'] = $data['item_group_name'];
                     }
                 }else if($data['vendor_id']){
                    $where['ar.vendor_id'] = $data['vendor_id'];
                 }
             }else if($data['site_id']){
                $where['ar.site_id'] = $data['site_id'];
             }
         }else if($data['company_id']){
            $where['ar.company_id'] = $data['company_id'];
         }



        if($data['site_id'] == 'all'){
            if($data['company_id'] == 'all'){
                if($data['vendor_id'] == 'all'){
                    if($data['item_group_name'] == 'all'){
                        if($data['item_group_name'] == 'all'){
                            if($data['is_approved'] == 'all'){
                                    $where = array();
                                }else{
                                    $where['ar.is_approved'] = $data['is_approved'];
                                }
                             }else if($data['item_group_name']){
                            $where['ar.item_group_id'] = $data['item_group_name'];
                         }
                     }else if($data['item_group_name']){
                        $where['ar.item_group_id'] = $data['item_group_name'];
                     }
                 }else if($data['vendor_id']){
                    $where['ar.vendor_id'] = $data['vendor_id'];
                 }
            }else if($data['company_id']){
                $where['ar.company_id'] = $data['company_id'];
            }

         }else  if($data['site_id']){
            $where['ar.site_id'] = $data['site_id'];
         }


         if($data['is_approved'] == 'all'){
            if($data['company_id'] == 'all'){
                if($data['site_id'] == 'all'){
                     if($data['vendor_id'] == 'all'){
                        if($data['item_group_name'] == 'all'){
                            if($data['item_name_id']== 'all'){
                                $where = array();
                             }else if($data['item_name_id']){
                                $where['ar.item_id'] = $data['item_name_id'];
                             }
                         }else if($data['item_group_name']){
                            $where['ar.item_group_id'] = $data['item_group_name'];
                         }
                     }else if($data['vendor_id']){
                        $where['ar.vendor_id'] = $data['vendor_id'];
                     }
                 }else if($data['site_id']){
                    $where['ar.site_id'] = $data['site_id'];
                 }
            }else if($data['company_id']){
                $where['ar.company_id'] = $data['company_id'];
            }     

         }else{
            $where['ar.is_approved'] = $data['is_approved'];
         }


         $count = count($this->ItemApprovedRateModel->getAprovedItemData($searchVal,0,0,0,0,0,$where));
        //  echo $this->db->last_query();die;
         if($count){
             $result = $this->ItemApprovedRateModel->getAprovedItemData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
                   $is_edit=1;
                 if($value['type']==APPROVED_TYPE_PO){
                    $po_items_id = $this->CommonModel->getData('tbl_po_items_details',array('id'=>$value['po_items_id']),'po_rate_approved_status','','row_array'); 
                    if(isset($po_items_id['po_rate_approved_status'])&& $po_items_id['po_rate_approved_status']==1){
                         $is_edit=0;
                    }else{
                         $is_edit=1;
                    }
                   
                 }else if($value['type']==APPROVED_TYPE_ITEM){
                     $is_edit=1;
                      // $ref_name_1 = $this->CommonModel->getData('tbl_po_items_details',array('id'=>$value['po_items_id']),'po_rate_approved_status','','row_array');  
                 }
                 
                 
                 $row = []; 
                 array_push($row, $offset+($key+1));
                 array_push($row, $value['po_order_no']);
                 array_push($row, $value['item_group_name']);
                 array_push($row, $value['item_name']);
                 array_push($row, $value['vendor_name']);

                 // array_push($row, $value['type']);
                 
                 // if($value['type'] == 1){
                 //    array_push($row, 'reference_name');
                 // }else if($value['type'] == 2){
                 //    array_push($row, 'reference_name');
                 // }else{
                 //    array_push($row, '-');
                 // }

                 array_push($row, $value['company_name']);
                 array_push($row, $value['site_name']);
                 array_push($row, $value['old_rate']);
                 array_push($row, $value['new_rate']);

                  if ($value['is_approved'] == 1) {
                       $status = '<span class="badge badge-success " style="font-size:12px">Approve</span>';
                       $approve_by_name = $value['approved_by_name'];
                  }else if($value['is_approved'] == 2){
                       $status = '<span class="badge badge-danger " style="font-size:12px">Reject</span>';
                       $approve_by_name = $value['approved_by_name'];
                  }else if($value['is_approved'] == 0){
                       $status = '<span class="badge badge-warning " style="font-size:12px">Pending</span>';
                       $approve_by_name = '-';
                  }

                 // if ($value['is_approved'] == 1) {
                 //       $status = '<span class="badge badge-success " onclick="changeStatus('.$value['id'] .',2)" style="font-size:12px" id="is_approved_'.$value['id'].'" title="Click for Reject">Approve</span>';
                 //  }else if($value['is_approved'] == 2){
                 //       $status = '<span class="badge badge-danger " onclick="changeStatus('.$value['id'] .',1)" style="font-size:12px" id="is_approved_'.$value['id'].'" title="Click for Approve">Reject</span>';
                 //  }else if($value['is_approved'] == 0){
                 //       $status = '<span class="badge badge-danger " onclick="changeStatus('.$value['id'] .',0)" style="font-size:12px" id="is_approved_'.$value['id'].'" title="Click for Approve">Pending</span>';
                 //  }
                  array_push($row,$status);
                  array_push($row, $approve_by_name);

                 $confirm = "confirm('Are you sure you want to delete this Service?')";

                    if ($value['is_approved'] == 1) {
                       $action = '-';
                    }else{
                          if($is_edit==0){
                               $action = '-';
                          }else{
                               $action = '
                                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="StatusUpdateModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>';
                          }
                          
                    }

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


  public function StatusUpdateModal()
  {
   
    $id = $this->input->post('id');
     $data['sub_title'] = 'Status Update';
    if ($id) {
      $itemappr = $this->ItemApprovedRateModel->getAprovedItemData('',0,0,0,0,$id);
       $data['sub_title'] = 'Status Update';
      $data['item_approved'] = $itemappr[0];

      if($data['item_approved']['type'] == 1 ){
          $ref_name = $this->CommonModel->getData('tbl_po',array('id'=>$data['item_approved']['reference_id']),'po_order_no','','row_array');
          $data['reference_name'] = $ref_name['po_order_no'];

      }else{
          $ref_name_1 = $this->CommonModel->getData('tbl_items',array('id'=>$data['item_approved']['reference_id']),'short_name','','row_array');
          $data['reference_name'] = $ref_name_1['short_name'];

      }



  }
  // echo "<pre>"; print_r($data);die;
    $html = $this->load->view(ADMIN.'master/item_approved/model_item_approved_status', $data,true);
    if ($html) {
      $response['html'] = $html;
      $response['result'] = true;
      $response['reason'] = 'Data Found';
    }else{
      $response['result'] = fasle;
      $response['reason'] = 'Something went to wrong!';
    }
    echo json_encode($response);
  }


  // public function changeStatus()
  //      {
  //         $status = $this->input->get();
  //         if($this->CommonModel->iudAction('tbl_approved_item_rate',$status,'update',array('id'=>$status['id']))){
  //              $response['result'] = TRUE;
  //              $response['reason'] = 'Approve Status Updated Successfully';
              
  //          }else{
  //              $response['result'] = FALSE;
  //              $response['reason'] = 'Approve Status Not Update!';
  //          }
  //          echo json_encode($response);
  //      }




  public function changeStatus()
       {

          $post = $this->input->post();
          $appr_it_id = $post['item_approved_id'];
        //   print_r($post);die;
          if(!isset($post['is_approved'])){
               $status_update['is_approved'] = 1;
          }else{
               $status_update['is_approved'] = $post['is_approved'];
          }
         
          $item_approved_type = $post['item_approved_type'];
          $status_update['approved_at'] = date('Y-m-d H:m:s');

          if($status_update['is_approved'] == 2){
            $status_update['approved_by'] = userId();
            $status=2;
          
          }else if($status_update['is_approved'] == 1){
            $status_update['approved_by'] = userId();
            
            
            $status=1;

          }else{
            $status_update['approved_by'] = '-';
            $status=0;
          }
         
           $this->CommonModel->iudAction('tbl_po_items_details',array('po_rate_approved_status'=>$status,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s')),'update',array('id'=>$post['po_items_ids']));

     
          if($this->CommonModel->iudAction('tbl_approved_item_rate',$status_update,'update',array('id'=>$appr_it_id))){
                
                if($item_approved_type==APPROVED_TYPE_PO){
                        
                        if(isset($post['item_vendor_id'])){
                            $ref_num_rows = $this->CommonModel->getData('tbl_vendor_item_rate',array('vendor_id'=>$post['item_vendor_id'],'item_group_id'=>$post['item_group_id'] , 'item_id'=>$post['item_id']),'id','','row_array');
                            if(isset($ref_num_rows['id']) && !empty($ref_num_rows)){
                                $insert_vendor_item_rate = $this->CommonModel->iudAction('tbl_vendor_item_rate',array('vendor_id'=> $post['item_vendor_id'],'item_group_id'=>$post['item_group_id'] , 'item_id'=>$post['item_id'] , 'item_rate'=>$post['new_rate'],'updated_by'=> userId(),'updated_at'=> date('Y-m-d H:i:s')),'update',array('id'=>$ref_num_rows['id']));
                            }else{
                                $insert_vendor_item_rate = $this->CommonModel->iudAction('tbl_vendor_item_rate',array('vendor_id'=> $post['item_vendor_id'],'item_group_id'=>$post['item_group_id'] , 'item_id'=>$post['item_id'] , 'item_rate'=>$post['new_rate'],'created_by'=> userId() ,'updated_by'=> userId(),'updated_at'=> date('Y-m-d H:i:s')),'insert');
                            }
                     
                        }
                        if(isset($post['po_items_ids'])){
                            $po_id_ref = $this->CommonModel->getData('tbl_po_items_details',array('id'=>$post['po_items_ids']),'po_id','','row_array');
                            if(isset($po_id_ref['po_id']) && !empty($po_id_ref['po_id'])){
                                $po_items_count = $this->CommonModel->getData('tbl_po_items_details',array('po_id'=>$po_id_ref['po_id']),'po_rate_approved_status','','num_rows');
                                $po_approved_item_count = $this->ItemApprovedRateModel->getItemCountApproved($po_id_ref['po_id']);
                                
                                $count_rows=count($po_approved_item_count);
                                if($po_items_count==$count_rows && ($po_approved_item_count[0]['po_rate_approved_status']==1|| $po_approved_item_count[0]['po_rate_approved_status']==NULL) ){
                                    $this->CommonModel->iudAction('tbl_po',array('po_rate_approved_status'=>1,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s')),'update',array('id'=>$po_id_ref['po_id']));
                                }else{
                                    $this->CommonModel->iudAction('tbl_po',array('po_rate_approved_status'=>0,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s')),'update',array('id'=>$po_id_ref['po_id']));
                                }
                                //    echo $this->db->last_query();die;
                                // print_r($po_id_ref1);
                                // print_r($po_approved_ref);
                                // die;
                               
                            }  
                        }
                        
                }else if($item_approved_type==APPROVED_TYPE_ITEM){
                    
                }
                
            
               $response['result'] = TRUE;
               $response['reason'] = 'Approve Status Updated Successfully';
              
           }else{
               $response['result'] = FALSE;
               $response['reason'] = 'Approve Status Not Update!';
           }

            redirect(base_url().'admin/master/ItemApprovedRate');
          
           
       }



}