<?php
/**
 * 
 */
class ChangeFinancialYear extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		isLogin();
	}

	public function index()
	{   
	     $where = $data=array();
         $post=$this->input->post();
         if($post){
            $last_financial_year_id = $this->CommonModel->getData('tbl_master_financial_year', array('is_active' =>1),'id','','row_array');  
            $this->CommonModel->iudAction('tbl_master_financial_year', array('is_active'=>0),'update');
            $financial_year_id=$this->CommonModel->iudAction('tbl_master_financial_year', array('to_date'=>date('Y-m-d',strtotime($post['to_date'])),'from_date'=>date('Y-m-d',strtotime($post['from_date'])),'is_active'=>1),'insert', array('id' => $data[0]['id']));
          //  $financial_year_id=2;
            if($financial_year_id){
                //update In user Table
                 $last_financial_year_id=isset($last_financial_year_id['id'])?$last_financial_year_id['id']:userId('financial_year_id');
                // $last_financial_year_id=1;
                 $this->CommonModel->iudAction('users', array('financial_year_id'=>$financial_year_id),'update');
                 
                 //update all openin stock to cyyent stock
                 $opening_arr = array(
                        'company_id' =>isset($post['company_id'])?$post['company_id']:userId('company_id'),
                        'site_id' => isset($post['site_id'])?$post['site_id']:userId('site_id'),
                        'financial_year_id' => isset($post['financial_year_id'])?$post['financial_year_id']:userId('financial_year_id'),
                        'remark' => 'Last Financial Year update To current Financial Year update', 
                        'location_id'=>NULL, 
                        'total_qty'=>isset($post['total_qty'])?$post['total_qty']:NULL, 
                    );
                    
                  $insert_id = $this->CommonModel->iudAction('tbl_items_opening_stock', $opening_arr, 'insert');
                  //$insert_id=97;
                  $item_datas = $this->CommonModel->getData('tbl_items_inventory', array('financial_year_id' => $last_financial_year_id,'qty !='=>0),'','','');  
                  $item_datas_details=$item_datas;
                  $item_opening_details=$item_datas;
                 // echo "<pre>";
                //   print_r($item_datas);
                  if(!empty($item_datas)){
                      foreach ($item_datas as &$row) {
                            unset($row['id']);
                            unset($row['created_by']);
                            unset($row['updated_by']);
                            unset($row['updated_at']);
                            $row['financial_year_id'] = $financial_year_id;
                    }
                    foreach ($item_datas_details as &$row1) {
                            unset($row1['id']);
                            unset($row1['created_by']);
                            unset($row1['updated_by']);
                            unset($row1['updated_at']);
                             $row['financial_year_id'] = $financial_year_id;
                            $row1['user_id'] = userId();
                            $row1['type'] = OPENING_STOCK_TYPE;
                            $row1['ref_id'] = $insert_id;
                            $row1['action'] = INVENTORY_ACTION_ADD;
                            $row1['created_at'] = date('Y-m-d H:i:s');
                            $row1['created_by'] = userId();
                    }
                    foreach ($item_opening_details as &$row2) {
                          
                            $row2['opening_id'] = $insert_id;
                            $row2['pur_date'] = date('Y-m-d');
                            $row2['opening_stock_type'] =NULL;
                            $row2['at_party'] =NULL;
                            $row2['opening_qty'] =$row2['qty'];
                            $row2['opening_unit_id'] =$row2['item_unit_id'];
                            $row2['created_at'] = date('Y-m-d H:i:s');
                            
                            unset($row2['id']);
                            unset($row2['created_by']);
                            unset($row2['updated_by']);
                            unset($row2['updated_at']);
                            unset($row2['item_unit_id']);
                            unset($row2['qty']);
                            unset($row2['site_id']);
                            unset($row2['company_id']);
                            unset($row2['financial_year_id']);
                            unset($row2['is_reserve_stock']);
                           
                    }

                  }
 
 
                   $this->db->insert_batch('tbl_items_inventory', $item_datas);
                  $this->db->insert_batch('tbl_items_inventory_details', $item_datas_details);
                  $this->db->insert_batch('tbl_items_opening_stock_details', $item_opening_details);
                  $this->session->set_flashdata('success', 'Last Year Opening Stock Data Added Succesfully!');
                  redirect(base_url(ADMIN.'store/GoodsItemOpening'));
            }
         }else{
             $this->load->view(ADMIN.'chnage_financial_year',$data);
         }
	     
	}
	public function updateOpeningStock1()
	{   
	     $where = $data=array();
         $post=$this->input->post();
         
            $last_financial_year_id = 1;  
         //   $this->CommonModel->iudAction('tbl_master_financial_year', array('is_active'=>0),'update');
         //   $financial_year_id=$this->CommonModel->iudAction('tbl_master_financial_year', array('to_date'=>date('Y-m-d',strtotime($post['to_date'])),'from_date'=>date('Y-m-d',strtotime($post['from_date'])),'is_active'=>1),'insert', array('id' => $data[0]['id']));
          //  $financial_year_id=2;
          
                //update In user Table
                // $last_financial_year_id=isset($last_financial_year_id['id'])?$last_financial_year_id['id']:userId('financial_year_id');
                // $last_financial_year_id=1;
             //    $this->CommonModel->iudAction('users', array('financial_year_id'=>$financial_year_id),'update');
                 
                 //update all openin stock to cyyent stock
                 $opening_arr = array(
                        'to_date'=>'2024-04-01',
                        'from_date'=>'2025-03-31',
                        'company_id' =>2,
                        'site_id' => 28,
                        'financial_year_id' => 2,
                        'remark' => 'Last Financial Year update To current Financial Year update', 
                        'current_financial_year_id'=>2,
                        'last_financial_year_id'=>1,
                        'created_by'=>userId()
                    );

 
                //  $insert_id = $this->CommonModel->iudAction('tbl_items_financial_year_opening_stock', $opening_arr, 'insert');
                  //$insert_id=97;
                  $item_datas = $this->CommonModel->getData('tbl_items_inventory', array('financial_year_id' => $last_financial_year_id,'qty !='=>0),'','','');  
                  $item_datas_details=$item_datas;
                  $item_opening_details=$item_datas;
                 // echo "<pre>";
                //   print_r($item_datas);
                  if(!empty($item_datas)){
                   $wrong_arry=[];
                    foreach ($item_opening_details as &$row2) { 
                          
                            $row2['financial_year_opening_id'] = 1;
                            $row2['created_at'] = date('Y-m-d H:i:s');
                             $where2=array('item_id'=>$row2['item_id'],'item_unit_id'=>$row2['item_unit_id'],'batch_no'=>$row2['batch_no'],'expired_date'=>$row2['expired_date'],'is_reserve_stock'=>$row2['is_reserve_stock'],'company_id'=>$row2['company_id'],'financial_year_id'=>$row2['financial_year_id'],'site_id'=>$row2['site_id'],'financial_year_id' =>1);
                            
                             $item_datas = $this->CommonModel->getLastYearRate($where2); 
                             if($item_datas)
                             {
                                 if($item_datas['type']==1){
                                    $grn_data = $this->CommonModel->getData('tbl_grn_items_details', array('item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id'],'grn_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','row_array'); 
                                    $row2['unit_rate'] = isset($grn_data['item_rate'])?$grn_data['item_rate']:"0.00";
                                 }else if($item_datas['type']==3){
                                    $opening_data = $this->CommonModel->getData('tbl_items_opening_stock_details', array('item_id' => $item_datas['item_id'],'opening_unit_id' => $item_datas['item_unit_id'],'opening_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','row_array'); 
                                    $row2['unit_rate'] = $opening_data['unit_rate'];
                                 }else if($item_datas['type']==5){
                                      $wrong_arry[]=$item_datas;
                                      $opening_data = $this->CommonModel->getData('tbl_recevied_material_issue_items_details', array('item_id' => $item_datas['item_id'],'received_qty_unit' => $item_datas['item_unit_id'],'received_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','row_array'); 
                                    $row2['unit_rate'] = $opening_data['rate'];
                                 }
                                  
                             }
                    
                        unset($row2['id']);
                         $insert_id = $this->CommonModel->iudAction('tbl_items_financial_year_opening_stock_details', $row2, 'insert');
                  //$insert_id=97;   
                    }

                  }
            echo "<pre>";
            print_r($item_opening_details);
            // die;
//  print_r($wrong_arry);die;
 
               //   $this->db->insert_batch('tbl_items_financial_year_opening_stock_details', $item_opening_details);die;
                  $this->session->set_flashdata('success', 'Last Year Opening Stock Data Added Succesfully!');
                  redirect(base_url(ADMIN.'store/GoodsItemOpening'));
            
         
	     
	}
    public function updateOpeningStock()
	{   
	     $where = $data=array();
        
          
        $item_datas = $this->CommonModel->getData('tbl_items_inventory', array('financial_year_id' => 1,'qty !='=>0),'','',''); 
        
            $item_opening_details=$item_datas;
            foreach ($item_opening_details as &$row2) {
                          
                            $row2['opening_id'] = 97;
                            $row2['pur_date'] = date('Y-m-d');
                            $row2['opening_stock_type'] =NULL;
                            $row2['at_party'] =NULL;
                            $row2['opening_qty'] =$row2['qty'];
                            $row2['opening_unit_id'] =$row2['item_unit_id'];
                            $row2['created_at'] = date('Y-m-d H:i:s');
                             

                            $where1=array('item_id'=>$row2['item_id'],'item_unit_id'=>$row2['item_unit_id'],'batch_no'=>$row2['batch_no'],'expired_date'=>$row2['expired_date'],'is_reserve_stock'=>$row2['is_reserve_stock'],'company_id'=>$row2['company_id'],'financial_year_id'=>$row2['financial_year_id'],'site_id'=>$row2['site_id'],'financial_year_id' => 1);
                            $item_datas1 = $this->CommonModel->getData('tbl_items_inventory', $where1,'','','');  
                              $row2['financial_year_id_1'] = $item_datas1;
                               $where2=array('item_id'=>$row2['item_id'],'item_unit_id'=>$row2['item_unit_id'],'batch_no'=>$row2['batch_no'],'expired_date'=>$row2['expired_date'],'is_reserve_stock'=>$row2['is_reserve_stock'],'company_id'=>$row2['company_id'],'financial_year_id'=>$row2['financial_year_id'],'site_id'=>$row2['site_id'],'financial_year_id' =>2,'ref_id'=>97);
                            $item_datas2 = $this->CommonModel->getData('tbl_items_inventory_details', $where2,'','','');  
                              $row2['financial_year_id_2'] = $item_datas2;
                              $row2['financial_year_id_2_count'] = count($item_datas2);
                               $row2['financial_year_id_1_count'] = count($item_datas1);
                            
                            unset($row2['id']);
                            unset($row2['created_by']);
                            unset($row2['updated_by']);
                            unset($row2['updated_at']);
                            unset($row2['item_unit_id']);
                            unset($row2['qty']);
                            unset($row2['site_id']);
                            unset($row2['company_id']);
                            unset($row2['financial_year_id']);
                            unset($row2['is_reserve_stock']);
                            
                          if( $row2['financial_year_id_2_count']!= $row2['financial_year_id_1_count'] ){
                              $wrong_arry[]=$row2;
                             
                          }
                           
                    }
             echo "<pre>";
             echo "item_opening_details".count($item_opening_details);
               echo "<br>wrong_arry".count($wrong_arry);die;
                 print_r($wrong_arry);
         die;
	     
	}
	public function updateRefIdInInventory()
	{   
	     $where = $data=array();
        
          
        $item_opening_details = $this->CommonModel->getData('tbl_items_inventory_details',array('sub_ref_id'=>NULL,'is_last_year_transfer_balance'=>0),'',''); 
        
           $wrong_arry=$wrong_arry1=$wrong_arry2=array();
             echo "<pre>";
            foreach ($item_opening_details as $key=>$item_datas) {
                                if($item_datas['type']==1){
                                    $grn_data = $this->CommonModel->getData('tbl_grn_items_details', array('item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id'],'grn_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                    $item_opening_details[$key]['no_count_same'] = $grn_data;
                                     if($grn_data==1){
                                        //$grn_data = $this->CommonModel->getData('tbl_grn_items_details', array('item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id'],'grn_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','',''); 
                                      //  $this->CommonModel->iudAction('tbl_items_inventory_details', array('sub_ref_id'=>$grn_data[0]['id']),'update',array('id'=>$item_datas['id']));
                                           $wrong_arry3[]= $item_datas;
                                    }
                                    if($grn_data==0){
                                        $wrong_arry[]= $item_datas;
                                    }
                                    if($grn_data==2){
                                        $wrong_arry1[$key]= $item_datas;
                                        $wrong_arry1[$key]['item']=$this->CommonModel->getData('tbl_grn_items_details', array('item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id'],'grn_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'id','',''); 
                                    }
                                    if($grn_data==3){
                                        $wrong_arry2[]= $item_datas;
                                    }
                                 }else if($item_datas['type']==2){
                                    $data1 = $this->CommonModel->getData('tbl_material_issue_items_details', array('item_id' => $item_datas['item_id'],'issue_qty_unit' => $item_datas['item_unit_id'],'issue_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                    $item_opening_details[$key]['no_count_same'] = $data1;
                                    if($data1==1){
                                      //   $data1 = $this->CommonModel->getData('tbl_material_issue_items_details', array('item_id' => $item_datas['item_id'],'issue_qty_unit' => $item_datas['item_unit_id'],'issue_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','',''); 
                                       //  $this->CommonModel->iudAction('tbl_items_inventory_details', array('sub_ref_id'=>$data1[0]['id']),'update',array('id'=>$item_datas['id']));
                                            $wrong_arry3[]= $item_datas;
                                    }
                                    if($data1==0){
                                          $wrong_arry[]= $item_datas;
                                    }
                                     if($data1==2){
                                        $wrong_arry1[$key]= $item_datas;
                                         $wrong_arry1[$key]['item']= $this->CommonModel->getData('tbl_material_issue_items_details', array('item_id' => $item_datas['item_id'],'issue_qty_unit' => $item_datas['item_unit_id'],'issue_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'id','',''); 
                                    }
                                    if($data1==3){
                                        $wrong_arry2[]= $item_datas;
                                    }
                                 }else if($item_datas['type']==5){
                                    $data2 = $this->CommonModel->getData('tbl_material_issue_return_details', array('item_id' => $item_datas['item_id'],'return_qty_unit' => $item_datas['item_unit_id'],'material_issue_return_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                    $item_opening_details[$key]['no_count_same'] = $data2;
                                    if($data2==1){
                                     //   $data2 = $this->CommonModel->getData('tbl_material_issue_return_details', array('item_id' => $item_datas['item_id'],'return_qty_unit' => $item_datas['item_unit_id'],'material_issue_return_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','',''); 
                                     //    $this->CommonModel->iudAction('tbl_items_inventory_details', array('sub_ref_id'=>$data2[0]['id']),'update',array('id'=>$item_datas['id']));
                                            $wrong_arry3[]= $item_datas;
                                    }
                                    if($data2==0){
                                          $wrong_arry[]= $item_datas;
                                    }
                                     if($data2==2){
                                        $wrong_arry1[$key]= $item_datas;
                                        $wrong_arry1[$key]['item']=$this->CommonModel->getData('tbl_material_issue_return_details', array('item_id' => $item_datas['item_id'],'return_qty_unit' => $item_datas['item_unit_id'],'material_issue_return_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'id','','');
                                    }
                                    if($data2==3){
                                        $wrong_arry2[]= $item_datas;
                                    }
                                 }else if($item_datas['type']==3){
                                    $data3 = $this->CommonModel->getData('tbl_items_opening_stock_details', array('item_id' => $item_datas['item_id'],' opening_unit_id' => $item_datas['item_unit_id'],'opening_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                    $item_opening_details[$key]['no_count_same'] = $data3;
                                    if($data3==1){
                                        // $data3 = $this->CommonModel->getData('tbl_items_opening_stock_details', array('item_id' => $item_datas['item_id'],' opening_unit_id' => $item_datas['item_unit_id'],'opening_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','',''); 
                                      //  $this->CommonModel->iudAction('tbl_items_inventory_details', array('sub_ref_id'=>$data3[0]['id']),'update',array('id'=>$item_datas['id']));
                                            $wrong_arry3[]= $item_datas;
                                    }
                                    if($data3==0){
                                         $wrong_arry[]= $item_datas;
                                    }
                                     if($data3==2){
                                        $wrong_arry1[]= $item_datas;
                                        $wrong_arry1[$key]['item']=$this->CommonModel->getData('tbl_items_opening_stock_details', array('item_id' => $item_datas['item_id'],' opening_unit_id' => $item_datas['item_unit_id'],'opening_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'id','',''); 
                                    }
                                    if($data3==3){
                                        $wrong_arry2[]= $item_datas;
                                    }
                                 }else if($item_datas['type']==4){
                                      $opening_data = $this->CommonModel->getData('tbl_recevied_material_issue_items_details', array('item_id' => $item_datas['item_id'],'received_qty_unit' => $item_datas['item_unit_id'],'received_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                     $item_opening_details[$key]['no_count_same'] = $opening_data;
                                    if($opening_data==1){
                                        // $opening_data = $this->CommonModel->getData('tbl_recevied_material_issue_items_details', array('item_id' => $item_datas['item_id'],'received_qty_unit' => $item_datas['item_unit_id'],'received_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','',''); 
                                        // $this->CommonModel->iudAction('tbl_items_inventory_details', array('sub_ref_id'=>$opening_data[0]['id']),'update',array('id'=>$item_datas['id']));
                                            $wrong_arry3[]= $item_datas;
                                    }
                                     if($opening_data==0){
                                         $wrong_arry[]= $item_datas;
                                    }
                                     if($opening_data==2){
                                        $wrong_arry1[$key]= $item_datas;
                                        $wrong_arry1[$key]['item']=$this->CommonModel->getData('tbl_recevied_material_issue_items_details', array('item_id' => $item_datas['item_id'],'received_qty_unit' => $item_datas['item_unit_id'],'received_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'id','',''); 
                                    }
                                    if($opening_data==3){
                                        $wrong_arry2[]= $item_datas;
                                    }
                                 }else if($item_datas['type']==6){

 
                                     $opening_data1 = $this->CommonModel->getData('tbl_items_financial_year_opening_stock_details', array('company_id' => $item_datas['company_id'],'site_id' => $item_datas['site_id'],'is_reserve_stock'=>$item_datas['is_reserve_stock'],'item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id'],'qty'=>$item_datas['qty'],'financial_year_opening_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                     $item_opening_details[$key]['no_count_same'] = $opening_data1;
                                    if($opening_data1==1){
                                        // $opening_data1 = $this->CommonModel->getData('tbl_items_financial_year_opening_stock_details', array('company_id' => $item_datas['company_id'],'site_id' => $item_datas['site_id'],'is_reserve_stock'=>$item_datas['is_reserve_stock'],'item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id'],'qty'=>$item_datas['qty'],'financial_year_opening_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'','','num_rows'); 
                                      //$this->CommonModel->iudAction('tbl_items_inventory_details', array('sub_ref_id'=>$opening_data1[0]['id']),'update',array('id'=>$item_datas['id']));
                                            $wrong_arry3[]= $item_datas;
                                    }
                                     if($opening_data1==0){
                                         $wrong_arry[]= $item_datas;
                                    }
                                     if($opening_data1==2){
                                        $wrong_arry1[$key]= $item_datas;
                                        $wrong_arry1[$key]['item']=$this->CommonModel->getData('tbl_recevied_material_issue_items_details', array('item_id' => $item_datas['item_id'],'received_qty_unit' => $item_datas['item_unit_id'],'received_id' => $item_datas['ref_id'],'batch_no' => $item_datas['batch_no'],'expired_date' => $item_datas['expired_date']),'id','',''); 
                                    }
                                    if($opening_data1==3){
                                        $wrong_arry2[]= $item_datas;
                                    }
                                 }
                           

                        //     $item_datas1 = getRate($row2['item_id'],$row2['item_unit_id'],$row2['qty'],$row2['company_id'],$row2['site_id'],$row2['financial_year_id'],$row2['type'],$row2['ref_id'],$row2['batch_no'],$row2['expired_date']);  
                        //     $wrong_arry[]= $row2['id'];
                        //     $this->CommonModel->iudAction('tbl_items_inventory_details', $item_datas1,'update', array('id' => $row2['id']));
                        //   echo $this->db->last_query()."<br>";
                    }
             echo "<pre>";
             echo "item_opening_details".count($item_opening_details)."<br>";
              echo "item_opening_details---0-------".count($wrong_arry);
                echo "item_opening_details--2-------".count($wrong_arry1);
                 echo "item_opening_details--3-------".count($wrong_arry2);
              // echo "item_opening_details--1-------".count($wrong_arry3);
          //echo "<br>wrong_arry".count($wrong_arry);
//          $first_names = array_column($item_opening_details, 'no_count_same');

// print_r($first_names);
//           die;
              print_r($wrong_arry);;die;
        //  die;
	     
	}
	public function checkUnitRate(){
	   $sql = "SELECT * 
                FROM tbl_items_inventory 
                WHERE id NOT IN (
                    SELECT inv.id 
                    FROM tbl_items_inventory inv 
                    JOIN tbl_items i ON i.id = inv.item_id 
                    JOIN tbl_items_units u ON u.id = inv.item_unit_id
                ) 
                ORDER BY tbl_items_inventory.item_id ASC";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $result1=$result2=array();
          foreach ($result as $key=>$item_datas) {
             $test=$this->CommonModel->getData('tbl_items_units', array('item_id' => $item_datas['item_id']),'','',''); 
             if(count($test)==1){
                 $array=$item_datas;
                 $array['unit_array']=$test;
                  $result2[]=$array;
                 // $this->CommonModel->iudAction('tbl_items_inventory', array('item_unit_id'=>$test[0]['id']),'update', array('item_id' => $item_datas['item_id'],'item_unit_id' => $item_datas['item_unit_id']));
                  echo $this->db->last_query();
                 // $this->CommonModel->iudAction('tbl_items_inventory_details', array('item_unit_id'=>$test[0]['id']),'update', array('item_unit_id' => $item_datas['item_unit_id'],'item_id' => $item_datas['item_id']));
                  echo "<br>".$this->db->last_query();
                //   if($key==0){
                //       die;
                //   }
             }else{
                  $array=$item_datas;
                  $array['unit_array']=$test;
                  $result1[]=$array;
             }
            
          }
        echo "<pre>";
        echo count($result)."-".count($result1)."-".count($result2);
        print_r($result1);
    
	}
	
	public function updatePOItemID(){
	    $wrong_arry3=$wrong_arry4=$wrong_arry5=array();
	         $test=$this->CommonModel->getData('tbl_grn_items_details', array('po_id !=' =>0),'','',''); 
	            foreach ($test as $key=>$item_datas) {
	                 $test[$key]['count_item']=$this->CommonModel->getData('tbl_po_items_details', array('po_id' => $item_datas['po_id'],'item_id'=>$item_datas['item_id'],'item_unit_id'=>$item_datas['item_unit_id']),'','','num_rows'); 
	                 if($test[$key]['count_item']==0){
	                     $wrong_arry[]=$test;
	                 }
	                 
	                 if($test[$key]['count_item']==1){
	                     $wrong_arry1[]=$test;
	                 }
	                 
	                 if($test[$key]['count_item']==2){
	                     $wrong_arry2[]=$test;
	                 }
	                 
	                 if($test[$key]['count_item']==3){
	                      $po_ids= $item_datas['po_id'];  
	                      $item_id= $item_datas['item_id'];  
	                      $item_unit_id= $item_datas['item_unit_id'];
                          $id_S=$this->CommonModel->getData('tbl_po_items_details', array('po_id' => $item_datas['po_id'],'item_id'=>$item_datas['item_id'],'item_unit_id'=>$item_datas['item_unit_id']),'group_concat(id) as id','','');; 
	                      $wrong_arry3[]=array('ids'=>$id_S,'po_ids'=>$po_ids,'item_id'=>$item_id,'item_unit_id'=>$item_unit_id);
	                 }
	                 
	                 if($test[$key]['count_item']==4){
	                     $wrong_arry4[]=$test;
	                 }
	                 
	                 if($test[$key]['count_item']==5){
	                     $wrong_arry5[]=$test;
	                 }
	                 
	                 if($test[$key]['count_item']==6){
	                     $wrong_arry6[]=$test;
	                 }
	                 
 
	            }
	            
	           //   echo "item_opening_details".count($test)."<br>";
              echo "item_opening_details---0-------".count($wrong_arry);
                echo "item_opening_details--1-------".count($wrong_arry1);
                 echo "item_opening_details--2-------".count($wrong_arry2);
                  echo "item_opening_details--3-------".count($wrong_arry3);
                   echo "item_opening_details--4-------".count($wrong_arry4);
                     echo "item_opening_details--5-------".count($wrong_arry5);
	         echo "<pre>";
	         print_r($wrong_arry3);die;
	}
	
}
?>