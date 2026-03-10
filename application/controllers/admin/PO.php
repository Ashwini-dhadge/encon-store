<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 *
 */
class PO extends CI_Controller
{
        function __construct()
        {
                parent::__construct();
                $this->load->model(ADMIN . 'POModel');
                $this->load->library('phpmailer_lib');
                isLogin();
        }
        public function index()
        {
         $data['title'] = 'Po List';
         $data['active'] = 'Vendor';
         $data['company_master'] = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1));
         $this->load->view(ADMIN.'po/list_po',$data);
        }
        public function add($id='', $type = 0)
        {
        
                $data['title'] = 'User Access';
                $data['master_tax_list'] = $this->CommonModel->getData('tbl_master_tax', array('status' => 1, 'is_deleted' => 0));
                $data['term_and_conditions_data'] = $this->CommonModel->getData('tbl_master_term_and_condition',array('is_deleted' => 0,'is_default'=>1),'','','');
                $data['site_info'] = $this->CommonModel->getData('tbl_site', array('id' => userId('site_id')), 'site_address', '', 'row_array');
                $data['cost_projects'] = $this->CommonModel->getData('tbl_cost_project',array('deleted_by' => NULL));
                $number=$this->POModel->getPONumber();
                $data['po_number'] = $number['po_no'];
                $data['po_order_sequence'] = $number['po_order_sequence'];
               
                if(isset($id) && !empty($id)){
                         $po_data = $this->POModel->getPOData('', '0', '0', '0', '0',$id,'');
                         $po_info=$po_data[0];                         
                         $data['po_info']=$po_data[0];
                         $data['po_info_items']= $this->POModel->getPOItemData(array('pi.po_id'=>$id));
                        //  echo $this->db->last_query();die;
                         $data['item_group'] =$this->POModel->getItemGroupList('', '');
                         $attachement = $this->CommonModel->getData('tbl_po_attachment',array('po_id'=>$id));
                         $files=array();
                         foreach($attachement as $key=>$value){
                             $temp_file_array=array();
                             $temp_file_array=array('name'=>$value['file_name'],'size'=>filesize(PO_ATTACH.$value['file_name']),'url'=>base_url().PO_ATTACH.$value['file_name'] ,'id'=>$value['id']);
                             $files[]=$temp_file_array;
                         }
                         $data['attachement']=$files;
                         
                         foreach($data['po_info_items'] as $key=>$vl){
    						$item_rate_updated = $this->POModel->getItemRateUpdated($vl['item_id']);
    						$data['item_rate_updated_data'][] = $item_rate_updated;
    					}
                        //   echo "<pre>";
                        //   print_r($id);  print_r( $data['po_info_items']);die;
                }
                 if (isset($type) && !empty($type)) {
                    if ($type == 1) {
                        $number = $this->POModel->getPONumber();
                        // echo $this->db->last_query();die;
                        $data['po_order_sequence'] = $number['po_order_sequence'];
                        $data['po_number'] = $number['po_no'];
                    } elseif ($type == 2) {
                        $po_info = $this->CommonModel->getData('tbl_po', array('id' => $id), 'id ,po_order_no,po_order_sequence,amendment_main_po_id', '', 'row_array');
                        // $data['po_number'] = $number['po_no'];
        
                        $data['po_order_sequence'] = $po_info['po_order_sequence'];
                        $data['amendment_main_po_id'] = $po_info['amendment_main_po_id'];
                        // $number1 = $this->POModel->getPONumber();
                      
                        //    print_r($data['po_order_no']);die;
                        $number2 = $this->POModel->getAmendmentSequences($id);
                        // print_r($number2);die;
                        $data['amendment_sequences'] = $number2['amendment_sequences'];
                        $data['po_number'] = $po_info['po_order_no'] . "-" . $data['amendment_sequences'];   //for amendment squences number
                        $data['amendment_po'] = $id;
                    }
                }
                $data['type']=$type;
                // echo"<pre>";print_r($data);die;
                //$data['termconditions'] = $this->CommonModel->getData('tbl_master_term_and_condition',array('is_deleted' => 0));
                $this->load->view(ADMIN . 'po/add_po', $data);
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
      
                $json[] = ['id' => "all", 'text' => "all"];
                  
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
                 $where = array();
                if (isset($post['item_group_id'])&& !empty($post['item_group_id'])) {
                    if($post['item_group_id']!='all'){
                        $where['i.item_group'] = $post['item_group_id']; 
                    }
                       
                } else {
                        $where = array();
                }

                $items = $this->POModel->getItemList($where);
                // echo $this->db->last_query();
                $json = array();
                foreach ($items as $key => $value) {
                        
                        $json[] = [
                                'id' => $value['id'], 'text' => $value['short_name'],'item_code' => $value['item_code'], 'data-short_name' => $value['short_name'], 'hsn_code' => $value['hsn_code'], 'rate' => $value['rate']
                        ];
                }

                $response['result'] = true;
                $response['data'] = $json;
                echo json_encode($response);
        }
        public function getItemUnitsData()
        {
                $post = $this->input->post();
                if (isset($post['item_id'])) {
                        $where['i.id'] = $post['item_id'];
                        $where1['i.item_id'] = $post['item_id'];
                        $where1['u.is_deleted'] = 0;
                } else {
                        $where = array();
                        $where1 = array();
                }
                $items_info = $this->POModel->getItemList($where);
                $items_units = $this->POModel->getItemUnitList($where1);
                if (isset($post['item_id'])) {
                $items_batchs_no = $this->POModel->getItemUnitBatchList(array('i.item_id'=>$post['item_id']));
                }else{
                    $items_batchs_no=array();
                }
                
                if(isset($post['vendor_id'])){
                        $is_check_ven_item_rate = $this->CommonModel->getData('tbl_vendor_item_rate',array('vendor_id'=>$post['vendor_id'],'item_id'=>$post['item_id']),'','','num_rows'); 

                        if($is_check_ven_item_rate > 0){
                           $items_info = $this->POModel->getVendorItemRateList($where,$post['vendor_id']);
                        }else{
                           $items_info = $this->POModel->getItemList($where);         
                        }
                }else{
                    $items_info = $this->POModel->getItemList($where);         
                }
               
                
                $items_units = $this->POModel->getItemUnitList($where1);
                // print_r($items_units);
               // die;
                foreach($items_units as $key=>$value){
                    $amt=getQuickInventoryAmount($value['item_id'],$value['item_unit_id'],userId('company_id'),userId('site_id'),userId('financial_year_id'));
                    $items_units[$key]['qty']=$amt;
                }
                 foreach($items_batchs_no as $key=>$value){
                    $amt=getQuickInventoryAmount($value['item_id'],$value['item_unit_id'],userId('company_id'),userId('site_id'),userId('financial_year_id'),$value['batch_no'],$value['expired_date'],0);
                    $items_batchs_no[$key]['qty']=$amt;
                }
                
       // print_r($cites);die;
                $json = array();
                if(!empty($items_info)){
                    $response['result'] = true;
                    $response['data_item'] = $items_info[0];
                    $response['data'] = $items_units;
                    $response['batch_info'] = $items_batchs_no;
                    echo json_encode($response);
                }else{
                    $response['result'] = true;
                    $response['data_item'] = array();
                    $response['data'] = $items_units;
                    $response['batch_info'] = $items_batchs_no;
                    echo json_encode($response);
                }
                
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
             
                
                  $items_batchs_no = $this->POModel->getItemUnitBatchList(array('i.is_reserve_stock'=>0,'i.item_id'=>$post['item_id'],'i.item_unit_id'=>$post['item_unit_id'],'i.company_id'=>userId('company_id'),'i.site_id'=>userId('site_id'),'i.financial_year_id'=>userId('financial_year_id')));
                // echo $this->db->last_query();
                 foreach($items_batchs_no as $key=>$value){
                    $amt=getQuickInventoryAmount($value['item_id'],$value['item_unit_id'],userId('company_id'),userId('site_id'),userId('financial_year_id'),$value['batch_no'],$value['expired_date'],0);
                    $items_batchs_no[$key]['qty']=$amt;
                    $items_batchs_no[$key]['qty_query']=$this->db->last_query();
                    $rate= $this->POModel->getItemRateBatchList(array('gi.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'item_unit_id'=>$value['item_unit_id'],'grn.company_id'=>userId('company_id'),'grn.site_id'=>userId('site_id')));
                     $items_batchs_no[$key]['rate_query_1']=$this->db->last_query();  
                    if(!empty($rate) && isset($rate['item_rate']) && $rate['item_rate']!=0.00){
                        $items_batchs_no[$key]['rate']=isset($rate['item_rate'])?$rate['item_rate']:0;
                        $items_batchs_no[$key]['item_rate_type']=isset($rate['item_rate_type'])?$rate['item_rate_type']:0;
                        $items_batchs_no[$key]['item_weight']=isset($rate['item_weight'])?$rate['item_weight']:0;
                        $items_batchs_no[$key]['weight_per_qty']=isset($rate['weight_per_qty'])?$rate['weight_per_qty']:0;
                         $items_batchs_no[$key]['weight_per_rate']=isset($rate['weight_per_rate'])?$rate['weight_per_rate']:0;
                        $items_batchs_no[$key]['rate_query']=$this->db->last_query();
                    }else{
                        //get rate from OS
                        // $rate_opening= $this->POModel->getItemRateBatchListFromOS(array('os.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'opening_unit_id'=>$value['item_unit_id'],'location_id'=>userId('site_id'),'financial_year_id'=>userId('financial_year_id')));
                          $rate_opening= $this->POModel->getItemRateBatchListFromOS(array('os.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'opening_unit_id'=>$value['item_unit_id'],'location_id'=>userId('site_id')));
                            // echo $this->db->last_query();
                        if(!empty($rate_opening) && isset($rate_opening['unit_rate']) && $rate_opening['unit_rate']!=0.00){
                            $items_batchs_no[$key]['rate']=isset($rate_opening['unit_rate'])?$rate_opening['unit_rate']:0;
                            $items_batchs_no[$key]['item_rate_type']=isset($rate_opening['item_rate_type'])?$rate_opening['item_rate_type']:0;
                            $items_batchs_no[$key]['item_weight']=isset($rate_opening['opening_weight'])?$rate_opening['opening_weight']:0;
                            $items_batchs_no[$key]['weight_per_qty']=isset($rate_opening['weight_per_qty'])?$rate_opening['weight_per_qty']:0;
                            $items_batchs_no[$key]['weight_per_rate']=isset($rate_opening['weight_per_rate'])?$rate_opening['weight_per_rate']:0;
                            $items_batchs_no[$key]['rate_query']=$this->db->last_query();
                        }else{
                            //transfered 
                            //   $rate_opening= $this->POModel->getItemRateBatchListFromRecevied(array('os.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'received_qty_unit'=>$value['item_unit_id'],'received_location_site_id'=>userId('site_id'),'financial_year_id'=>userId('financial_year_id')));
                              $rate_opening= $this->POModel->getItemRateBatchListFromRecevied(array('os.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'received_qty_unit'=>$value['item_unit_id'],'received_location_site_id'=>userId('site_id')));
                                //   echo $this->db->last_query();die;
                              if(!empty($rate_opening) && isset($rate_opening['rate']) && $rate_opening['rate']!=0.00){
                                    $items_batchs_no[$key]['rate']=isset($rate_opening['rate'])?$rate_opening['rate']:0;
                                    $items_batchs_no[$key]['item_rate_type']=isset($rate_opening['item_rate_type'])?$rate_opening['item_rate_type']:0;
                                    $items_batchs_no[$key]['item_weight']=isset($rate_opening['weight'])?$rate_opening['weight']:0;
                                    $items_batchs_no[$key]['weight_per_qty']=isset($rate_opening['weight_per_qty'])?$rate_opening['weight_per_qty']:0;
                                    $items_batchs_no[$key]['weight_per_rate']=isset($rate_opening['weight_per_rate'])?$rate_opening['weight_per_rate']:0;
                                    $items_batchs_no[$key]['rate_query']=$this->db->last_query();
                                }else{
                                    //transfered 
                                    $items_batchs_no[$key]['rate_query']=$this->db->last_query();
                                    $items_batchs_no[$key]['rate']=0;
                                }
                          
                        }
                    } 
                    
                    
                }



       // print_r($cites);die;
                $json = array();
                $response['result'] = true;
                $response['batch_info'] = $items_batchs_no;
                 $response['batch_info11'] = $items_batchs_no;
                echo json_encode($response);
        }
        public function add_po()
        {
                $post = $this->input->post();
                    // echo "<pre>"; print_r($_FILES);die;
                        // if (!empty($_FILES['file_name']['name'][0])) {
                        //         $uploadStatus = myUpload(PO_ATTACH, 'file_name', true);
                        //         if(!empty($uploadStatus)){
                        //              $attachement = $uploadStatus['data'];
                        //         }
                               
                        // }
                //   echo "<pre>"; print_r($_FILES); print_r($attachement);die;
                if ($post) {
                        if (isset($post['po_date'])) {
                            
                                $formattedDate =strtotime(str_replace('/', '-', $post['po_date']));
                                $po_date = date('Y-m-d',$formattedDate);
                        } else {
                                $po_date = date('Y-m-d');
                        }
                      
                       
                        
                        if(isset($post['po_order_no'])){
                            $po_order_sequence =isset($post['po_order_sequence']) ?$post['po_order_sequence']:1;     
                            $po_order_no = $post['po_order_no'];
                            
                            $is_add= $this->CommonModel->getData('tbl_po', array('po_order_no' => $po_order_no),'','','num_rows');
                            if($is_add==1){
                                $number=$this->POModel->getPOMaxSequenceNumber();
                                $po_order_no = $number['po_no'];
                                $po_order_sequence = $number['po_order_sequence'];
                            }
                        }else{
                            $number=$this->POModel->getPOMaxSequenceNumber();
                            $po_order_no = $number['po_no'];
                            $po_order_sequence = $number['po_order_sequence'];
                        }
                        
                        
                        //echo $po_order_no;die;
                        if(isset($post['po_valid_from_to_date'])) {
                                $date1 = explode(" - ", $post['po_valid_from_to_date']);
                                if (isset($date1[0])) {
                                        $formattedDate1 =strtotime(str_replace('/', '-', $date1[0]));
                                        $po_valid_from = date('Y-m-d',$formattedDate1);
                                        // $po_valid_from = date('Y-m-d', strtotime($date1[0]));
                                } else {
                                        $po_valid_from = date('Y-m-d');
                                }

                                if (isset($date1[1])) {
                                        $formattedDate2 =strtotime(str_replace('/', '-', $date1[1]));
                                        $po_valid_to = date('Y-m-d', $formattedDate2);
                                } else {
                                        $po_valid_to = date('Y-m-d');
                                }
                        }
                        if (isset($post['type']) && $post['type'] == 2) {
                                    $po_order_sequence_amendment = $post['amendment_sequences'];
                                   //  $amendment_main_po_id = $post['po_order_no'];            
                              
                        }
           


                        $insert = array(
                                'po_order_no' => (isset($po_order_no)) ?$po_order_no :NULL,
                                'po_order_sequence' => $po_order_sequence,
                                'amendment_sequences' => (isset($po_order_sequence_amendment)) ? $po_order_sequence_amendment : NULL,
                                'amendment_main_po_id' => (isset($post['amendment_po']) && $post['amendment_po']!=0) ? $post['amendment_po'] : NULL,
                                'po_date' => $po_date,
                                'po_valid_from' => $po_valid_from,
                                'po_valid_to' => $po_valid_to,
                                'cost_project_id' => (isset($post['cost_project_id'])) ? $post['cost_project_id'] :NULL,
                                'vendor_id' => (isset($post['vendor_id'])) ? $post['vendor_id'] :NULL,
                                'line_before_address' => (isset($post['line_before_address'])) ? $post['line_before_address'] :NULL,
                                'cost_project_address' => (isset($post['cost_project_address'])) ? $post['cost_project_address'] :NULL,
                                'delivery_days' => (isset($post['delivery_days'])) ? $post['delivery_days'] :NULL,
                                'delivery_days_for_alerts' => (isset($post['delivery_days_for_alerts'])) ? $post['delivery_days_for_alerts'] :NULL,
                                'payment_days' => (isset($post['payment_days'])) ? $post['payment_days'] :NULL,
                                'payment_days_for_alerts' => (isset($post['payment_days_for_alerts'])) ? $post['payment_days_for_alerts'] :NULL,
                                'guarantee' => (isset($post['guarantee'])) ? $post['guarantee'] :NULL,
                                'reference' => (isset($post['reference'])) ? $post['reference'] :NULL,
                                'billing_site_id' => (isset($post['billing_site_id'])) ? $post['billing_site_id'] :NULL,
                                'delivery_site_id' => (isset($post['delivery_site_id'])) ? $post['delivery_site_id'] :NULL,
                                'delivery_party_id' => (isset($post['delivery_party_id'])) ? $post['delivery_party_id'] :NULL,
                                'address1' => (isset($post['address1'])) ? $post['address1'] :NULL,
                                'address2' => (isset($post['address2'])) ? $post['address2'] :NULL,
                                'address3' => (isset($post['address3'])) ? $post['address3'] :NULL,
                                'prices' => (isset($post['prices'])) ? $post['prices'] :NULL,
                                'terms_and_condition' => (isset($post['terms_and_condition'])) ? $post['terms_and_condition'] :NULL,
                                'remark' => (isset($post['remark'])) ? $post['remark'] :NULL,
                                'line_in_bottom' => (isset($post['line_in_bottom'])) ? $post['line_in_bottom'] :NULL,
                                'jurisdiction' => (isset($post['jurisdiction'])) ? $post['jurisdiction'] :NULL,
                                'packing_forwarding' => (isset($post['packing_forwarding'])) ? $post['packing_forwarding'] :NULL,
                                'taxes_duites' => (isset($post['taxes_duites'])) ? $post['taxes_duites'] :NULL,
                                'financial_year_id' => userId('financial_year_id'),
                                'company_id' => userId('company_id'),
                                'site_id' => userId('site_id'),
                                'created_by' => userId(),
                        );
                        if (empty($post['id'])) {
                                $po_id = $this->CommonModel->iudAction('tbl_po', $insert, 'insert');
                        } else {
                                unset($insert['po_order_no']);
                                unset($insert['po_order_sequence']);
                                unset($insert['site_id']);
                                unset($insert['company_id']);
                                unset($insert['financial_year_id']);
                                $insert['updated_at'] = date('Y-m-d');
                                $insert['updated_by'] = userId();
                                $this->CommonModel->iudAction('tbl_po', $insert, 'update', array('id' => $post['id']));
                                $po_id = $post['id'];
                        }

                        //tax deatils
                        $insert_tax_data = array(
                                'po_id' => $po_id,
                                'item_total_qty' => (isset($post['total_qty'])) ? $post['total_qty'] :NULL,
                                'item_total_sub_amount' => (isset($post['total_item_rate'])) ? $post['total_item_rate'] :NULL,
                                'item_total_discount' => (isset($post['total_discount_amount'])) ? $post['total_discount_amount'] :NULL,
                                'item_total_gst' => (isset($post['total_tax_rate'])) ? $post['total_tax_rate'] :NULL,
                                'item_total_additional_gst' => (isset($post['total_additional_tax_rate'])) ? $post['total_additional_tax_rate'] :NULL,
                                'item_total_amount' => (isset($post['final_amount_total'])) ? $post['final_amount_total'] :NULL,
                                'discount_percent' => (isset($post['final_discount_percent'])) ? $post['final_discount_percent'] :NULL,
                                'discount_amount' => (isset($post['final_discount_amount'])) ? $post['final_discount_amount'] :NULL,
                                'gst_amount' => (isset($post['final_gst'])) ? $post['final_gst'] :NULL,
                                'ld_charges' => (isset($post['ld_charges'])) ? $post['ld_charges'] :NULL,   
                                 'ld_clause_text' => (isset($post['ld_clause_text'])) ? $post['ld_clause_text'] :NULL,   
                                'freight_type' => (isset($post['freight'])) ? $post['freight'] :NULL,
                                'freight_text' => (isset($post['freight_text'])) ? $post['freight_text'] :NULL,
                                'freight_amount' => (isset($post['freight_amount'])) ? $post['freight_amount'] :NULL,
                                'freight_tax_id' => (isset($post['freight_tax_id'])) ? $post['freight_tax_id'] :NULL,
                                'freight_tax_rate' => (isset($post['freight_tax_rate'])) ? $post['freight_tax_rate'] :NULL,
                                'freight_tax_amount' => (isset($post['freight_tax_amount'])) ? $post['freight_tax_amount'] :NULL,
                                'freight_amount' => (isset($post['freight_amount'])) ? $post['freight_amount'] :NULL,
                                'freight_additional_tax_id' => (isset($post['freight_additional_tax_id'])) ? $post['freight_additional_tax_id'] :NULL,
                                'freight_additional_tax_rate' => (isset($post['freight_additional_tax_rate'])) ? $post['freight_additional_tax_rate'] :NULL,
                                'freight_additional_tax_amount' => (isset($post['freight_additional_tax_amount'])) ? $post['freight_additional_tax_amount'] :NULL,
                                'new_tax_name' => (isset($post['new_tax_name'])) ? $post['new_tax_name'] :NULL,
                                'new_tax_id' => (isset($post['new_tax_id'])) ? $post['new_tax_id'] :NULL,
                                'new_tax_rate' => (isset($post['new_tax_rate'])) ? $post['new_tax_rate'] :NULL,
                                'new_tax_amount' => (isset($post['n_tax_amount'])) ? $post['n_tax_amount'] :NULL,
                                'service_charge_type' => (isset($post['service_charge_type'])) ? $post['service_charge_type'] :NULL,
                                'service_charge_amount' => (isset($post['service_charge_amount'])) ? $post['service_charge_amount'] :NULL,
                                'service_tax_id' => (isset($post['service_tax_id'])) ? $post['service_tax_id'] :NULL,
                                'service_tax_rate' => (isset($post['service_tax_rate'])) ? $post['service_tax_rate'] :NULL,
                                'service_tax_amount' => (isset($post['service_tax_amount'])) ? $post['service_tax_amount'] :NULL,
                                'round_off' => (isset($post['round_off'])) ? $post['round_off'] :NULL,
                                'po_final_amount' => (isset($post['po_final_amount'])) ? $post['po_final_amount'] : ''
                        );

                        


                        if (empty($post['id'])) {
                                $po_ids = $this->CommonModel->iudAction('tbl_po_tax_details', $insert_tax_data, 'insert');
                        } else {
                                unset($insert['created_by']);
                                $insert['updated_at'] = date('Y-m-d');
                                $insert['updated_by'] = userId();
                                $this->CommonModel->iudAction('tbl_po_tax_details', $insert_tax_data, 'update', array('po_id' => $po_id));
                                // $po_id = $post['id'];
                        }
                        
                        if (isset($post['items']) && count($post['items']) != 0) {
                                // echo "<pre>";
                                // print_r($post['items']);
                                foreach ($post['items'] as $key => $item) {
                                   //  echo $item['dispatch_1_lot_date']."<br>";
                                         if(isset($item['dispatch_1_lot_date'])) {
                                           // $item['dispatch_1_lot_date'] =strtotime(str_replace('/', '-', $item['dispatch_1_lot_date']));
                                            $item['dispatch_1_lot_date1'] = date('Y-m-d',strtotime($item['dispatch_1_lot_date']));
                                        }else{
                                            $item['dispatch_1_lot_date1']=NULL;
                                        }
                                        //  echo $item['dispatch_1_lot_date1']."<br>";
                                        if(isset($item['dispatch_2_lot_date'])) {
                                              //  $item['dispatch_2_lot_date'] =strtotime(str_replace('/', '-', $item['dispatch_2_lot_date']));
                                                $item['dispatch_2_lot_date1'] = date('Y-m-d',strtotime($item['dispatch_2_lot_date']));
                                                
                                        }else{
                                            $item['dispatch_2_lot_date1']=NULL;
                                        }
                                        if(isset($item['dispatch_3_lot_date'])) {
                                              //  $item['dispatch_3_lot_date'] =strtotime(str_replace('/', '-', $item['dispatch_3_lot_date']));
                                                $item['dispatch_3_lot_date1'] = date('Y-m-d',strtotime($item['dispatch_3_lot_date']));
                                                
                                        }else{
                                            $item['dispatch_3_lot_date1']=NULL;
                                        }
                                        if(isset($item['dispatch_4_lot_date'])) {
                                               // $item['dispatch_4_lot_date'] =strtotime(str_replace('/', '-', $item['dispatch_4_lot_date']));
                                                $item['dispatch_4_lot_date1'] = date('Y-m-d',strtotime($item['dispatch_4_lot_date']));
                                                
                                        }else{
                                            $item['dispatch_4_lot_date1']=NULL;
                                        }
                        
                                        


                                        $insert_item_data = array(
                                                'po_id' => $po_id,
                                                'item_group_id' => (isset($item['item_group_id'])) ? $item['item_group_id'] :NULL,
                                                'item_id' => (isset($item['items_id'])) ? $item['items_id'] :NULL,
                                                'item_stock_qty' => (isset($item['item_stock_qty'])) ? $item['item_stock_qty'] :NULL,
                                                'item_size' => (isset($item['item_size'])) ? $item['item_size'] :NULL,
                                                'item_qty' => (isset($item['item_unit'])) ? $item['item_unit'] :NULL,
                                                'item_unit_id' => (isset($item['item_unit_id'])) ? $item['item_unit_id'] :NULL,
                                                'item_weight' => (isset($item['item_weight'])) ? $item['item_weight'] :NULL,
                                                'item_rate' => (isset($item['item_unit_rate'])) ? $item['item_unit_rate'] :NULL,
                                                'item_rate_type' => (isset($item['item_rate_type'])) ? $item['item_rate_type'] :NULL,
                                                'item_sub_amount' => (isset($item['item_rate'])) ? $item['item_rate'] :NULL,
                                                'item_discount_percent' => (isset($item['discount_percent'])) ? $item['discount_percent'] :NULL,
                                                'item_discount_type' => (isset($item['discount_type'])) ? $item['discount_type'] :NULL,
                                                'item_discount_amount' => (isset($item['discount_amount'])) ? $item['discount_amount'] :NULL,
                                                'tax_id' => (isset($item['tax_id'])) ? $item['tax_id'] :NULL,
                                                'tax_rate' => (isset($item['tax_rate'])) ? $item['tax_rate'] :NULL,
                                                'tax_value' => (isset($item['tax_value'])) ? $item['tax_value'] :NULL,
                                                'additional_tax_id' => (isset($item['additional_tax_id'])) ? $item['additional_tax_id'] :NULL,
                                                'additional_tax_rate' => (isset($item['additional_tax_rate'])) ? $item['additional_tax_rate'] :NULL,
                                                'additional_tax_value' => (isset($item['additional_tax_value'])) ? $item['additional_tax_value'] :NULL,
                                                'item_amount' => (isset($item['item_final_amount'])) ? $item['item_final_amount'] :NULL,
                                                'dispatch_1_lot_qty' => (isset($item['dispatch_1_lot_qty'])&& !empty($item['dispatch_1_lot_qty'])) ? $item['dispatch_1_lot_qty'] :NULL,
                                                'dispatch_1_lot_date' => (isset($item['dispatch_1_lot_date1']) && !empty($item['dispatch_1_lot_date1'])) ? date('Y-m-d', strtotime($item['dispatch_1_lot_date1'])) :NULL,
                                                'dispatch_4_lot_qty' => (isset($item['dispatch_4_lot_qty']) && !empty($item['dispatch_4_lot_qty'])) ? $item['dispatch_4_lot_qty'] :NULL,
                                                'dispatch_4_lot_date' => (isset($item['dispatch_4_lot_date1'])&& !empty($item['dispatch_4_lot_date1'])) ? date('Y-m-d', strtotime($item['dispatch_4_lot_date1'])) :NULL,
                                                'dispatch_2_lot_qty' => (isset($item['dispatch_2_lot_qty'])&& !empty($item['dispatch_2_lot_qty'])) ? $item['dispatch_2_lot_qty'] :NULL,
                                                'dispatch_2_lot_date' => (isset($item['dispatch_2_lot_date1'])&& !empty($item['dispatch_2_lot_date1'])) ? date('Y-m-d', strtotime($item['dispatch_2_lot_date1'])) :NULL,
                                                'dispatch_3_lot_qty' => (isset($item['dispatch_3_lot_qty'])&& !empty($item['dispatch_3_lot_qty'])) ? $item['dispatch_3_lot_qty'] :NULL,
                                                'dispatch_3_lot_date' => (isset($item['dispatch_3_lot_date1'])&& !empty($item['dispatch_3_lot_date1'])) ? date('Y-m-d', strtotime($item['dispatch_3_lot_date1'])) :NULL,
                                                'item_description' => (isset($item['item_description'])) ? $item['item_description'] :NULL,
                                                'other_description' => (isset($item['other_description'])) ? $item['other_description'] :NULL,
                                                'technical_description ' => (isset($item['technical_description'])) ? $item['technical_description'] :NULL,
                                                'created_by' => userId()
                                        );
                                        //  echo "<pre>";
                                        // print_r($item);
                                        //  print_r($insert_item_data);
                                        if (isset($item['po_item_id']) && !empty($item['po_item_id'])&& $post['type'] == 0) {
                                                unset($insert_item_data['created_by']);
                                                
                                                $insert_item_data['updated_at'] = date('Y-m-d');
                                                $insert_item_data['updated_by'] = userId();
                                                $this->CommonModel->iudAction('tbl_po_items_details', $insert_item_data, 'update', array('id' => $item['po_item_id']));
                                                $po_item_ids=$item['po_item_id'];
                                        }else{
                                                $po_item_ids = $this->CommonModel->iudAction('tbl_po_items_details', $insert_item_data, 'insert');
                                           
                                        }
                                        
                                        //approved rate when  old rate not match to new rate
                                             if($post['vendor_id']){
                                                      $check_vendor_old_rate = $this->CommonModel->getData('tbl_vendor_item_rate',array('vendor_id'=>$post['vendor_id'],'item_id'=>$item['items_id']),'id,item_rate as rate','','row_array');       
                                                        
                                                        if($check_vendor_old_rate){
                                                           $old_rate = (isset($check_vendor_old_rate['rate'])) ? $check_vendor_old_rate['rate'] :'';     
                                                        }else{
                                                            $check_old_rate = $this->CommonModel->getData('tbl_items',array('id'=>$item['items_id']),'id,rate','','row_array');
                                                            $old_rate = (isset($check_old_rate['rate'])) ? $check_old_rate['rate'] :'';    
                                                        }
                                                
                                                }
                                               
                                                $new_rate = (isset($item['item_unit_rate'])) ? $item['item_unit_rate'] :'0';

                                                $insert_approve_item_rate = array(
                                                                'vendor_id' => (isset($post['vendor_id'])) ? $post['vendor_id'] :NULL,
                                                                'item_group_id' => (isset($item['item_group_id'])) ? $item['item_group_id'] :NULL,
                                                                'item_id' => (isset($item['items_id'])) ? $item['items_id'] :NULL,
                                                                'reference_id' => $po_id,
                                                                'po_items_id' => $po_item_ids,
                                                                'old_rate' => $old_rate,
                                                                'new_rate' => $new_rate,
                                                                'type' => 1,
                                                        );


                                                $insert_approve_item_rate['company_id'] = userId('company_id');
                                                $insert_approve_item_rate['site_id'] = userId('site_id'); 
                                                $insert_approve_item_rate['created_by'] = userId(); 

                                                if($old_rate != $item['item_unit_rate']){
                                                    
                                                    if(userId('role_id')==MANAGER_ROLE ){
                                                        $insert_approve_item_rate['is_approved'] = 1; 
                                                        $insert_approve_item_rate['approved_at'] = date('Y-m-d H:m:s');     
                                                        $insert_approve_item_rate['approved_by'] = userId(); 

                                                         $this->CommonModel->iudAction('tbl_approved_item_rate',$insert_approve_item_rate,'insert'); 
                                                         $insert_vendor_item_rate = $this->CommonModel->iudAction('tbl_vendor_item_rate',array('vendor_id'=> $post['vendor_id'],'item_group_id'=>$item['item_group_id'] , 'item_id'=>$item['items_id'] , 'item_rate'=>$new_rate,'created_by'=> userId() ,'updated_by'=> userId(),'updated_at'=> date('Y-m-d H:i:s')),'insert');

                                                         $this->CommonModel->iudAction('tbl_po',array('po_rate_approved_status'=>1,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s') ),'update',array('id'=>$po_id));
                                                         $this->CommonModel->iudAction('tbl_po_items_details',array('po_rate_approved_status'=>1,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s') ),'update',array('id'=>$po_item_ids));

                                                    }else{
                                                        $check_exist_rate=array();
                                                        $check_exist_rate = $this->CommonModel->getData('tbl_approved_item_rate',array('vendor_id'=>$post['vendor_id'],'item_id'=>$item['items_id'], 'reference_id' => $po_id,'po_items_id' => $po_item_ids,'type' => 1),'id','','row_array');       
                                                        if(!empty($check_exist_rate) && isset($check_exist_rate['id'])){
                                                             $this->CommonModel->iudAction('tbl_approved_item_rate',$insert_approve_item_rate,'update',array('id'=>$check_exist_rate['id'])); 
                                                           
                                                        }else{
                                                            $this->CommonModel->iudAction('tbl_approved_item_rate',$insert_approve_item_rate,'insert'); 
                                                        }
                                                       
                                                        $this->CommonModel->iudAction('tbl_po_items_details',array('po_rate_approved_status'=>0,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s') ),'update',array('id'=>$po_item_ids));
                                                        $this->CommonModel->iudAction('tbl_po',array('po_rate_approved_status'=>0,'updated_by'=>userId() ,'updated_at'=>date('Y-m-d H:m:s') ),'update',array('id'=>$po_id));
                                                    }
 
                                                }
                                        
                                }
                        }
                        // die;
                        $attachement = array();
                        // echo "<pre>"; print_r($_FILES);die;
                        if (!empty($_FILES['file_name']['name'][0])) {
                                $uploadStatus = myUpload(PO_ATTACH, 'file_name', true);
                                if(!empty($uploadStatus)){
                                     $attachement = $uploadStatus['data'];
                                }
                               
                        }
                           if (!empty($attachement) && isset($po_id)) {
                           foreach ($attachement as $key => $value) {
                                $insert_attch_data = array(
                                        'po_id' => $po_id,
                                        'file_name' => $value['file_name'],
                                        'created_by' => userId()
                                 );
                                 $this->CommonModel->iudAction('tbl_po_attachment', $insert_attch_data, 'insert');
                            }
                        } 
                        $removedFiles=json_decode($_POST['removedFiles'],true);
                         if(isset($removedFiles) && !empty($removedFiles)){
                            foreach ($removedFiles as $key4 => $val4) {
                            
                                $chk = $this->CommonModel->getData('tbl_po_attachment',array('id'=>$val4),'','','row_array'); 
                                if(!empty($chk['file_name'])){
                                    $filePath = $_SERVER['DOCUMENT_ROOT'] . PO_ATTACH . $chk['file_name'];
                                    if (file_exists($filePath)) {
                                        unlink($filePath);
                                    } 
                                    $this->CommonModel->iudAction('tbl_po_attachment','','delete',array('id'=>$val4));    
                                }
                                
                                
                            }
                        } 
                        

                        // if (empty($post['id']) && empty($post['file_name_id'])) {
                        //   foreach ($attachement as $key => $value) {
                        //         $insert_attch_data = array(
                        //                 'po_id' => $po_id,
                        //                 'file_name' => $value['file_name'],
                        //                 'created_by' => userId()
                        //          );
                        //          $this->CommonModel->iudAction('tbl_po_attachment', $insert_attch_data, 'insert');
                        //     }
                        // } else {
                        //          if(isset($post['file_name_id'])){
                        //             foreach ($post['file_name_id'] as $key4 => $val4) {
                                    
                        //                 $chk = $this->CommonModel->getData('tbl_po_attachment',array('id'=>$val4),'','','row_array'); 
    
                        //                 if($chk){
                        //                     $update_attch_data = array(
                        //                             'po_id' => $po_id,
                        //                             'file_name' => $chk['file_name'],
                        //                             'updated_by' => userId(),
                        //                             'updated_at' => date('Y-m-d'),
                        //                     );
                        //                     $this->CommonModel->iudAction('tbl_po_attachment',$update_attch_data,'update',array('id'=>$val4,'po_id'=>$post['id']));
                        //                 }else{
                        //                   $this->CommonModel->iudAction('tbl_po_attachment','','delete',array('id'=>$val4,'po_id'=>$post['id']));    
                        //                 }
                                            
                                       
                        //             }
                        //          }
                                
                        //         if(isset($attachement)){
                        //             foreach ($attachement as $key => $value) {
                        //                 $update_attch_data_a = array(
                        //                     'po_id' => $po_id,
                        //                     'file_name' => $value['file_name'],
                        //                     'updated_by' => userId(),
                        //                     'updated_at' => date('Y-m-d'),
                        //                   );
                        //                  $this->CommonModel->iudAction('tbl_po_attachment', $update_attch_data_a, 'insert');
                                   
                        //             }   
                        //       }

                        // }                         
                       
                        $po_invoice_pdf_name=$this->create_pdf($po_id);
                        $this->CommonModel->iudAction('tbl_po', array('po_invoice_pdf_name'=>$po_invoice_pdf_name,'updated_at'=>date('Y-m-d'),'updated_by'=>userId()), 'update', array('id' =>$po_id));
                         
                        //  die;
                        $this->session->set_flashdata('success','PO Added Successfully');
                         redirect(base_url().'admin/PO');
                }
           
    }
    public function listPo(){
    
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
            $where['p.vendor_id'] = $data['vendor_id'];
         } 
          if(isset($data['company_id'])&&!empty($data['company_id'])){
              if($data['company_id'] !='all'){
                   $where['p.company_id'] = $data['company_id'];
              }
         }else{
             //$where['p.company_id'] =userId('company_id');
         }
          if(isset($data['site_id'])&& !empty($data['site_id'])){
              if($data['company_id'] !='all'){
                   $where['p.site_id'] = $data['site_id'];
              }
         }else{
             //$where['p.site_id'] =userId('site_id');
         } 
         if(empty($data['company_id']) &&  empty($data['site_id'])){
             $where['p.company_id'] =userId('company_id');
             $where['p.site_id'] =userId('site_id');
             
         }
          if(userId('financial_year_id')){
              $where['p.financial_year_id'] =userId('financial_year_id');
          }
        
         if(isset($on_date)){
              if ($on_date == 1) {
            $from_date = date('Y-m-d');
             $where['date(p.po_date)'] = date('Y-m-d',strtotime($from_date));
         }else if ($on_date == 2) {
            $from_date = date('Y-m-d', strtotime('-1 days'));
             $where['date(p.po_date)'] = date('Y-m-d',strtotime($from_date));
         }else if ($on_date == 3) {
            $from_date = date('Y-m-d', strtotime('last monday'));
            $to_date = date('Y-m-d', strtotime('next sunday'));
            $where['date(p.po_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
         }else if ($on_date == 4) {
            $from_date = date('Y-m-d', strtotime('first day of this month'));
            $to_date = date('Y-m-d', strtotime('last day of this month'));
            $where['date(p.po_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;

         }else if ($on_date == 5) {
            $from_date = date('Y-m-d', strtotime('01/31'));
            $to_date = date('Y-m-d', strtotime('12/31'));
            $where['date(p) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
         }else if($on_date == 6){
            $from = new DateTime($from_date);
            $to = new DateTime($to_date);
            $from_date = $from->format('Y-m-d 00:00:00');
            $to_date = $to->format('Y-m-d 23:59:59');
            $where['date(p.po_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
        }
         }
         
        
        if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
         }
         
         if(isset($data['cost_project_id'])&&!empty($data['cost_project_id'])){
              if($data['cost_project_id'] !='all'){
                   $where['p.cost_project_id'] = $data['cost_project_id'];
              }
         }else{
             //$where['p.company_id'] =userId('company_id');
         }


       
        $count = count($this->POModel->getPOData($searchVal,0,0,0,0,0,$where,$item_id));
        // echo $this->db->last_query();die;
        if($count){
            $result = $this->POModel->getPOData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id);
            // echo $this->db->last_query();die;
                foreach ($result as $key => $value) {
                    $flag=$own_flag_access=0;
                    $row = []; 
                    $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['po_id'].'" title="View Items">';
                     array_push($row, $offset + ($key + 1)." ".$html1);
                    array_push($row, '<a href="'.base_url().'admin/PO/viewPoDetailsData/'.$value['po_id'] .'" title="view" class="" data-toggle="tooltip">'.$value['po_order_no'].'</a>');
                    array_push($row, dmyDate($value['po_date']));
                    array_push($row, $value['vendor_name']);
                    array_push($row, $value['item_total_qty']);
                    array_push($row, $value['first_name']." ".$value['last_name']);
                     if($value['po_status']==0){
                         $status='<center><span class="badge badge-danger">Created</span></center>';
                         $flag=1;
                    }else if($value['po_status']==1){
                         $status='<center><span class="badge badge-success">Approved</span></center>';
                    }else if($value['po_status']==2){
                         $status='<center><span class="badge badge-success">Rejected</span></center>';
                    }

                    array_push($row, $status);
                      array_push($row, $value['cost_project_name']);
                    if($value['po_created_by']==userId()){
                        $own_flag_access=1;
                    }
                   
                   
                   
                    $confirm = "confirm('Are you sure you want to delete this PO?')";
                    $action='';
                        //$action='<a href="'.base_url().'admin/PO/po_pdf/'.$value['id'] .'" title="po_pdf" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-print" aria-hidden="true"></i></a>';
                        if(isset($value['po_invoice_pdf_name'])){
                             $action='<a href="'.base_url().PO_PDF_PATH.$value['po_invoice_pdf_name'] .'?t=' . time().'" title="po_pdf" target="_blank" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-print" aria-hidden="true"></i></a>';
                        }else{
                            $action='';
                        }
                         $action .= ' <a href="'.base_url().'admin/PO/viewPoDetailsData/'.$value['po_id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    
                        if((getUserAccessForModule('Purchase order','edit') &&  $flag==1) || ($flag && $own_flag_access) || userId('role_id')==SUPERADMIN_ROLE || userId('role_id')==MANAGER_ROLE):
                            $action .='<a href="' . base_url() . 'admin/PO/add/'.$value['po_id'] . '" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                         
                        endif;
                        
                        if(getUserAccessForModule('Purchase order','delete') && $flag==1 || ($flag && $own_flag_access) || userId('role_id')==SUPERADMIN_ROLE):
                            $action .= ' <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/PO/poDelete/' . $value['po_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                        
                        endif;
                        $confirm1 = "confirm('Are you sure you want to Copy this PO?')";
                        $confirm2 = "confirm('Are you sure you want to Amendment this PO?')";
                        $action .= ' <a onclick="return ' . $confirm1 . '" href="' . base_url() . 'admin/PO/add/' . $value['po_id'] . '/1" title="Copy Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fa fa-copy" aria-hidden="true"></i></a>';
                        if($value['amendment_main_po_id']==NULL || $value['amendment_main_po_id']==0){
                          $action .= ' <a onclick="return ' . $confirm2 . '" href="' . base_url() . 'admin/PO/add/' . $value['po_id'] . '/2" title="Amendment Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" >Amendment </a>';   
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
        
    public function poDeleteItems(){
        $post=$this->input->post();
        $po_id=$post['po_id'];
        $po_item_id=$post['po_item_id'];
        if($po_id && $po_item_id){
        
        
        $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'po_order_no', '', 'row_array');
         
        $this->CommonModel->iudAction('tbl_po_items_details',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$po_item_id));
            
            
        $description="PO Item deleted -".$po_data['po_order_no']." by ".userId('name');
        $json_data_login=encode_arr($post);
        //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

        ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor
         //sub_ref_type:1 tbl_user
        $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,1,$po_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
        updateInActionLogFile($data_action_log_array);
        
        
            $response['result']=true;
            $response['reasons']="PO Items Deleted";
        }else{
              $response['result']=false;
              $response['reasons']="Something Went Wrong";
        }
        
      
        echo json_encode($response);die;
    }
    
    public function poDelete($po_id){
       
       // $po_item_id=$post['po_item_id'];
        if($po_id ){
        
        $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'po_order_no', '', 'row_array');
         
        $this->CommonModel->iudAction('tbl_po',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$po_id));
        $this->CommonModel->iudAction('tbl_po_items_details',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('po_id'=>$po_id));    
            
        $description="PO deleted -".$po_data['po_order_no']." by ".userId('name');
        $json_data_login=encode_arr($po_id);
        //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

        ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor
         //sub_ref_type:1 tbl_user
        $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,1,$po_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
        updateInActionLogFile($data_action_log_array);
        
            $response['result']=true;
            $response['reasons']="PO Items Deleted";
        }else{
              $response['result']=false;
              $response['reasons']="Something Went Wrong";
        }
        
      
         redirect(base_url(ADMIN.'PO'));
    }
   

    public function poItemsTOtalItemdetailsUpdate(){
        $post=$this->input->post();
        $po_id=$post['po_id'];
        $total_qty=$post['total_qty'];
        $po_final_amount=$post['po_final_amount'];
        if($po_id ){
                        $insert_tax_data = array(
                                'item_total_qty' => (isset($post['total_qty'])) ? $post['total_qty'] :NULL,
                                'item_total_sub_amount' => (isset($post['total_item_rate'])) ? $post['total_item_rate'] :NULL,
                                'item_total_discount' => (isset($post['total_discount_amount'])) ? $post['total_discount_amount'] :NULL,
                                'item_total_gst' => (isset($post['total_tax_rate'])) ? $post['total_tax_rate'] :NULL,
                                'item_total_additional_gst' => (isset($post['total_additional_tax_rate'])) ? $post['total_additional_tax_rate'] :NULL,
                                'item_total_amount' => (isset($post['final_amount_total'])) ? $post['final_amount_total'] :NULL,
                                'round_off' => (isset($post['round_off'])) ? $post['round_off'] :NULL,
                                'po_final_amount' => (isset($post['po_final_amount'])) ? $post['po_final_amount'] : ''
                        );

            $check_po_data = $this->CommonModel->getData('tbl_po_tax_details', array('po_id' => $po_id), 'po_final_amount', '', 'num_rows');
         
                    if($check_po_data){ 
                                $insert['updated_at'] = date('Y-m-d');
                                $insert['updated_by'] = userId();
                                $this->CommonModel->iudAction('tbl_po_tax_details', $insert_tax_data, 'update', array('po_id' => $po_id));
                                // $po_id = $post['id'];
                        }

        
        
        $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'po_order_no', '', 'row_array');
         
      
            
            
        $description="PO Item deleted update item qty -".$po_data['po_order_no']." by ".userId('name');
        $json_data_login=encode_arr($post);
        //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

        ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor
         //sub_ref_type:1 tbl_user
        $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,1,$po_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
        updateInActionLogFile($data_action_log_array);
        
        
            $response['result']=true;
            $response['reasons']="PO Items Deleted";
        }else{
              $response['result']=false;
              $response['reasons']="Something Went Wrong";
        }
        
      
        echo json_encode($response);die;
    }
    public function po_pdf($po_id=''){
        //   $po_pdfview = $this->POModel->getViewPopdf($po_id);
        //     $data =  $po_pdfview[0];
             $poData = $this->POModel->getViewPoData($po_id);
        $data =  $poData[0];
        $data['po_item_details_data'] = $this->POModel->getPoItemDetailsData($po_id);
        $data['po_tax_details_data'] = $this->POModel->getPoTaxDetailsData($po_id);
        
           // echo "<pre>"; print_r($data);die; 
            $this->load->view(ADMIN.'po/view_po_pdf',$data); 
        
    }

    public function submit_update_status(){
        $post = $this->input->post();
        $po_id = isset($post['po_id'])?$post['po_id']:'';  
        // print_r($po_id);die;
        $po_status = isset($post['po_status'])?$post['po_status']:''; 

        if($po_status == 2){
          $reject_reason = isset($post['reject_reason'])?$post['reject_reason']:'';
        }else{
          $reject_reason = NUll;      
        }      
        $approved_by = userId();
        $approved_at = date('Y-m-d H:m:s');

       $update_dt = $this->CommonModel->iudAction('tbl_po',array('po_status'=>$po_status,'reject_reasons'=>$reject_reason,'approved_by'=>$approved_by,'approved_at'=>$approved_at),'update',array('id'=>$po_id));  
        
        $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'po_order_no', '', 'row_array');
        $description="PO Approved -".$po_data['po_order_no']." by ".userId('name');
        $json_data_login=encode_arr($po_id);
        $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,1,$po_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
        updateInActionLogFile($data_action_log_array);     
        $po_invoice_pdf_name=$this->create_pdf($po_id);
        $this->CommonModel->iudAction('tbl_po', array('po_invoice_pdf_name'=>$po_invoice_pdf_name,'updated_at'=>date('Y-m-d'),'updated_by'=>userId()), 'update', array('id' =>$po_id));
        
        if($update_dt){
             $this->session->set_flashdata('success','Status Updated Succesfully');
           
        }else{
             $this->session->set_flashdata('success','Falied to Update Status!');
           
        }
          redirect(base_url().'admin/PO/viewPoDetailsData/'.$po_id);
        // echo json_encode($response);
    }

    public function create_pdf($po_id='') {
       // Your HTML content
        $this->load->library('pdf');
      
           
        $poData = $this->POModel->getViewPoData($po_id);
        $data =  $poData[0];
    //     echo "<pre>";
    //   print_r($data);die;
        $data['po_item_details_data'] = $this->POModel->getPoItemDetailsData($po_id);
        $data['po_tax_details_data'] = $this->POModel->getPoTaxDetailsData($po_id);
        $data['email_data']=$this->POModel->getVendorEmailData('',$poData[0]['vendor_id']);
        // echo $this->db->last_query();die;
        // echo "<pre>";
        
          if(!empty($data['email_data'])){
               $emails = array_column($data['email_data'], 'email_id');
            //   print_r( $emails);die;
               $data['emails_other_email'] = implode(', ', $emails);
          }else{
              $data['emails_other_email']='';
          }
          
        // Load the view and capture its content
        $data['company_master_data'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['company_po_id']),'','','row_array');
    
        $htmlContent = $this->load->view(ADMIN.'po/view_po_pdf1', $data, true);
        // echo $htmlContent;die;
        // Add a page
        $this->pdf->AddPage();
        // Set zero margins
        
                $pdf=$this->pdf;
        // $pdf->setCreator(PDF_CREATOR);
        // $pdf->setAuthor('Encon');
        // $pdf->setTitle('Encon');
        // $pdf->setSubject('Encon');
        // $pdf->setKeywords('Encon');
        
        
        
        // set margins
       // $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
        // $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
         $this->pdf->SetPrintHeader(false);
         $this->pdf->SetPrintFooter(false);
        
        // set auto page breaks
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        
        $this->pdf->SetMargins(5,5,5);
        // Set font size
        $this->pdf->SetFont('helvetica', '',7);
        
        // Write HTML content
        $this->pdf->writeHTML($htmlContent);
        
        // $this->pdf->setDebug(true);
        // Save PDF to a file
        //$file_name="ENCON_PO_PDF_".$po_id.".pdf";
        $file_name=$data['po_order_no'].".pdf";
        $pdfOutputPath = FCPATH . 'pdfs/'.$file_name;
        
            // ✅ Set headers to prevent caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: 0");
    
        $this->pdf->Output($pdfOutputPath,'F');
        // die;
        return $file_name;
        //  $this->pdf->Output($pdfOutputPath);
        // echo "PDF generated successfully at $pdfOutputPath";


    }
    public function listEmails()
      {
          if(!isset($_GET['searchTerm'])){ 
              $json = [];
              $email_data=$this->POModel->getEmailData('');
          }else{
              $search = $_GET['searchTerm'];
              $email_data=$this->POModel->getEmailData($search);
          }
             foreach ($email_data as $key => $value) {
               $json[] = ['id'=>$value['email'], 'text'=>$value['email']];
              }  
          echo json_encode($json);
      }
    public function listVendorEmails()
      {
         $vendor_id = $_GET['vendor_id'];

          if(!isset($_GET['searchTerm']) && isset($vendor_id)){ 
              $json = [];
              
              $email_data=$this->POModel->getVendorEmailData('',$vendor_id);
               $vendor_wmail_id= $this->CommonModel->getData('tbl_vendor_master_details', array('vendor_id' =>$vendor_id),'id,contact_person_email','','row_array');
          }else{
              $search = $_GET['searchTerm'];

              $email_data=$this->POModel->getVendorEmailData($search,$vendor_id);
          }
           
           if(isset($vendor_wmail_id['contact_person_email'])){
               $json[] = ['id'=>$vendor_wmail_id['contact_person_email'], 'text'=>$vendor_wmail_id['contact_person_email'],'selected'=>true];
           }

             foreach ($email_data as $key => $value) {
                $json[] = ['id'=>$value['id'], 'text'=>$value['email_id'],'selected'=>true];
              }  
          echo json_encode($json);
      }
    public function viewPoDetailsData($po_id=''){
        
        $poData = $this->POModel->getViewPoData($po_id);
       // echo $this->db->last_query();die;
        $data =  $poData[0];
        $data['po_item_details_data'] = $this->POModel->getPoItemDetailsData($po_id);
        $data['po_tax_details_data'] = $this->POModel->getPoTaxDetailsData($po_id);
        $data['vendor_dt'] = $this->CommonModel->getData('users',array('id'=>$po_id),'address as vendor_address,concat(first_name," ",last_name) as approved_by_name');      
         $data['company_master'] = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1));

        $data['attachment_file'] = $this->CommonModel->getData('tbl_po_attachment',array('po_id'=>$po_id));
       
        $vendor_master_email = $this->CommonModel->getData('tbl_vendor_master_email',array('vendor_id'=>$data['vendor_id']),'id,vendor_id,email_id');
    
        $vendor_contact_person_email = $this->CommonModel->getData('tbl_vendor_master_details',array('vendor_id'=>$data['vendor_id']),'contact_person_email as id,vendor_id,contact_person_email as email_id');
       
        $data['vendor_master_email'] = array_merge($vendor_master_email,$vendor_contact_person_email);
        
      //  print_r($vendor_contact_person_email);

        $user_detail = $this->CommonModel->getData('users',array('id'=>userId()),'id,email,created_by','','row_array');
        if($user_detail['id'] == $user_detail['created_by']){
             $user_email = $this->CommonModel->getData('users',array('id'=>$user_detail['id']),'id,email','','');
        }else{
            
            $user_created_by_email = $this->CommonModel->getData('users',array('id'=>$user_detail['created_by']),'id,email','','');
           
            if(isset($user_created_by_email['email']) && $user_created_by_email['email']=='superadmin@gmail.com'){
                $useremail = array_merge($user_created_by_email,$user_email_data); 
                $user_email = $useremail;
            }else{
                $user_email_data = $this->CommonModel->getData('users',array('id'=>$user_detail['id']),'id,email','','');
                $user_email = $user_email_data;
            }
            
           
        }
      
        $data['user_email'] = $user_email; 
        $data['department_data'] =$this->CommonModel->getData('tbl_department',array('id'=>2),'id,email_id','','row_array');
        $data['emailmessage'] = $this->CommonModel->getData('tbl_master_email_template',array('is_deleted' => 0));
        // echo "<pre>"; print_r($data['user_email'] );die;
        // die;
        // $data['user_email']
        // echo "<pre>"; print_r($data );die;
        $this->load->view(ADMIN.'po/view_purchase_order',$data);
    }
    public function sendMailWithattchement(){
        $mail = $this->phpmailer_lib->load();
          
        //   $attachmentPath = $_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_6.pdf';
        //   echo $attachmentPath;
        // echo "<pre>";
        // print_r($_FILES);die;
         $post = $this->input->post();
    
         $poid = isset($post['poid'])?$post['poid']:'';
         $vendor_id = isset($post['id_vendor'])?$post['id_vendor']:'';
                
         
        if(($_FILES['additional_attacheMent']['name'])){
               $uploadStatus = myUpload(ADDITIONAL_ATTACHEMENT,'additional_attacheMent',true);

               if(isset($uploadStatus['data'])){
                  $add_attachement = $uploadStatus['data'];
               }else{
                  $add_attachement = array();       
               }        
               
                  // echo "<pre>";  print_r($add_attachement);
            }

          $dt['subject'] = isset($post['subject'])?$post['subject']:'';
          
          $data['msg'] = isset($post['message'])?$post['message']:''; 
          $data['name'] ='vendor_name';
            $cc_array=array();
              foreach ($post['vendor_email_id'] as $key => $value) {
                 $dt['vendor_email'][] = $value;
                 if($key==0){
                   $vendor_email=$value;
                 }else{
                    
                       array_push($cc_array,$value);
                 }
              }
        //   print_r($post);die;
            if(isset($post['email_id'])){
                foreach ($post['email_id'] as $key1 => $value1) {
                    array_push($cc_array,$value1);
                }  
            }
                
            if(isset($post['new_email'])){
               $new_email=explode(',', $post['new_email']);
                foreach ($new_email as $key1 => $value1) {
                    array_push($cc_array,$value1);
                     if(! isset($vendor_email) && empty($vendor_email)){
                       $vendor_email=$value1;
                   }
                }  
            }
            $absolutePath = FCPATH;
         // for po attachement
          if(! empty($post['checkbox'])){
                $po_attachment = array();
                $po_attachment_file = array();
                $po_attachment = $this->CommonModel->getData('tbl_po_attachment',array('po_id'=>$poid));
               
                foreach ($po_attachment as $key3 => $value3) {
                     $po_attachment_file[] = $absolutePath . 'assets/uploads/po_attchment/'.$value3['file_name'];
                     // echo "<pre>"; print_r($data['user_email'] );
                }
                //echo "<pre>"; print_r($poattachement );die;
          }else{
                $po_attachment_file = array();
          }

          if(! empty($post['checkbox_po_invoice_pdf_name'])){
               $po_invoice_pdf_name = array ($absolutePath . 'pdfs/'.$post['po_invoice_pdf_name']);
            //   $mime_type = mime_content_type($po_invoice_pdf_name1);
            //   echo "<pre>"; print_r($po_invoice_pdf_name1);
            //   echo "<pre>"; print_r($mime_type);die;
            //   $mail->addAttachment($po_invoice_pdf_name1, $post['po_invoice_pdf_name'], 'base64', $mime_type);
            //   $mail->addAttachment($po_invoice_pdf_name1);
          }else{
                $po_invoice_pdf_name = array();         
          }

          //  for additional attachement
        $upload_additional_attachement = array();
        foreach ($add_attachement as $key2 => $value2) {

             $uploadattachement = $absolutePath.'assets/uploads/additional_attchment/'.$value2["file_name"];

             $upload_additional_attachement[] = $uploadattachement;
             // echo "<pre>"; print_r($data['user_email'] );
        }
        
        if(!empty($po_attachment_file) && !empty($upload_additional_attachement)){
             $array_attach = array_merge($po_attachment_file,$upload_additional_attachement);
        }else if(!empty($po_attachment_file)){
            $array_attach=$po_attachment_file;
        }else if(!empty($upload_additional_attachement)){
             $array_attach=$upload_additional_attachement;
        }else{
            $array_attach=array();
        }
   
        if(!empty($array_attach) && !empty($po_invoice_pdf_name) ){
            $attachement_array=array_merge($array_attach , $po_invoice_pdf_name);
        }else if(!empty($array_attach)){
            $attachement_array=$array_attach;
        }else if(!empty($po_invoice_pdf_name)){
             $attachement_array=$po_invoice_pdf_name;
        }else{
            $attachement_array=array();
        }
        
        $poData = $this->POModel->getViewPoData($poid);
       // print_r($poData);die;
        $data['msg']=isset($post['message'])?$post['message']:''; ;
        $data['link']=base_url()."po-email-confirmation/".$poid;
        $data['po_order_no']=$poData[0]['po_order_no'];
        $data['company_name']=$poData[0]['company_name'];
        $data['site_name']=$poData[0]['po_site_name'];
        $data['site_address']=$poData[0]['company_address'];
        $htmlContent1 =  $this->load->view('admin/emails/po_template_1', $data, TRUE);      
       // echo $htmlContent1;die;
       
       if(empty($cc_array)){
          $cc_array=array('procurement@encongroup.in','enconrksharma@gmail.com');
       }else{
          if(!in_array("procurement@encongroup.in", $cc_array))
          {
              array_push($cc_array,"procurement@encongroup.in");
          }
          
           if(!in_array("enconrksharma@gmail.com", $cc_array))
          {
              array_push($cc_array,"enconrksharma@gmail.com");
          }
        //   if(!in_array("ritikshukla@encongroup.in", $cc_array))
        //   {
        //       array_push($cc_array,"ritikshukla@encongroup.in");
        //   }
            
       }
       

       if(! empty($vendor_email) && ! empty($cc_array)){
        $res1= sendMailByPhpMailer($vendor_email,$post['subject'], $htmlContent1,$attachement_array,$cc_array);
       }
   
        if ($res1) {      
            $this->session->set_flashdata('success', 'Mail sent Successfully'); 
           // echo "ok";
        }else{
            $this->session->set_flashdata('error',"Mail Not send");
          //echo "Mail Not Send";
        }
        // die;
          redirect(base_url().'admin/PO/viewPoDetailsData/'.$poid);
        // echo "<pre>"; print_r($data);die;
    }
    public function remove_po_attachment(){
        $po_attachment_id = $this->input->post('po_attachment_id');
          
          if($this->CommonModel->iudAction('tbl_po_attachment','','delete',array('id'=>$po_attachment_id))){
                $response['result'] = true;
                // $response['reason'] = 'Removed Successfully';

            }else{
                $response['result'] = false;
                // $response['reason'] = 'not Removed!';
            }
            echo json_encode($response);
        }
    public function listtermconditions()
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
          


         $count = count($this->POModel->gettermconditionsData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->POModel->gettermconditionsData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
            
                 $row = []; 
                 array_push($row,'<div></div>');
                 array_push($row, $offset+($key+1));
                
                  
                 array_push($row, $value['title']);
                 array_push($row, $value['particulars']);
                 $confirm = "confirm('Are you sure you want to delete this Service?')";

                 // $action = '
                 // <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="siteModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>';
                 // array_push($row, $action);

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
    public function add_termconditions(){
    $post = $this->input->post();
    
    if ($post) {

      if (empty($post['id'])) {
       
       if ($this->CommonModel->iudAction('tbl_master_term_and_condition',$post,'insert')) {
        //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'TermCondition Added Succesfully!');
        }

        else{
          $this->session->set_flashdata('error','Fail To Add TermCondition!');
        }
      }
      redirect(base_url(ADMIN.'Po/add'));
     }
     $this->load->view(ADMIN.'po/add_termconditions'); 

 }
    public function getItemUnitsStock()
    {
            $post = $this->input->post();
            if (isset($post['item_id']) && isset($post['item_unit_id'])) {
                  $Stock = $this->CommonModel->getData('tbl_items_inventory', array('company_id' => userId('company_id'),'site_id'=>userId('site_id'),'financial_year_id'=>userId('financial_year_id'),'item_id'=>$post['item_id'],'item_unit_id'=>$post['item_unit_id']), 'qty', '', 'row_array');
                  if(isset($Stock['qty'])){
                      $stocks=$Stock['qty'];
                  }else{
                      $stocks=0;
                  }
                  
            } else {
                 $stocks=0;
            } 
            if (isset($post['item_id']) && isset($post['item_unit_id'])) {
               
                $data['item_rate_updated_data'] = $this->POModel->getItemRateUpdated($post['item_id'],$post['item_unit_id']);

                $html = $this->load->view(ADMIN.'po/item_rate_updated_data', $data,true);
                
                if($html){
                  $response['html_data'] = $html;        
                }
                
               
            }

            $json = array();
            $response['result'] = true;
            $response['stock'] = $stocks;
            echo json_encode($response);
    }
    public function getTermCondition(){
        
        $id = $this->input->post('id');
        $data['sub_title'] = 'Add Site';
           
        $data['termconditions'] = $this->CommonModel->getData('tbl_master_term_and_condition',array('is_deleted' => 0));
          // print_r($data['company_name']);die; 
        $html = $this->load->view(ADMIN.'po/terms_condition_modal', $data,true);
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
    public function saveTermConditions(){
    $post = $this->input->post();
    
    if ($post) {
        $insert_id='';
      if (!empty($post['particulars'])) {
       $insert_id=$this->CommonModel->iudAction('tbl_master_term_and_condition',$post,'insert');
      }
      if ($insert_id) {
          $response['html'] = $insert_id;
          $response['result'] = true;
          $response['reason'] = 'Data Found';
        }else{
          $response['result'] = false;
          $response['reason'] = 'Something went to wrong!';
        }
        
     }else{
         $response['result'] = false;
          $response['reason'] = 'Something went to wrong!';
     }
     echo json_encode($response);  

 }
 public function InnearItemTableData(){
	     if (isset($_GET['id'])) {
            $id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['items']= $this->POModel->getPOItemData(array('pi.po_id'=>$id));;
            // echo "<pre>";
            // print_r($data['items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'po/inner_items_table', $data,true);
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
	 public function download_po_report_list()
    {
         $data=$this->input->post();
       
         
         $on_date = $this->input->post('on_date');
         $from_date = $this->input->post('from_date');
         $to_date = $this->input->post('to_date');
         $where = array();
         // 

         if(isset($data['vendor_id']) && !empty($data['vendor_id'])){
            $where['p.vendor_id'] = $data['vendor_id'];
         } 
          if(isset($data['company_id']) && !empty($data['company_id'])){
              if($data['company_id'] !='all'){
                   $where['p.company_id'] = $data['company_id'];
              }
         }else{
             //$where['p.company_id'] =userId('company_id');
         }
          if(isset($data['site_id'])&& !empty($data['site_id'])){
              if($data['company_id'] !='all'){
                   $where['p.site_id'] = $data['site_id'];
              }
         }else{
             //$where['p.site_id'] =userId('site_id');
         } 
         if(empty($data['company_id']) &&  empty($data['site_id'])){
             $where['p.company_id'] =userId('company_id');
             $where['p.site_id'] =userId('site_id');
             $where['p.financial_year_id'] =userId('financial_year_id');
         }
         if (isset($on_date)) {
        if ($on_date == 1) {
            // Today
            $from_date = date('Y-m-d');
            $where['DATE(p.po_date)'] = $from_date;
        } elseif ($on_date == 2) {
            // Yesterday
            $from_date = date('Y-m-d', strtotime('-1 day'));
            $where['DATE(p.po_date)'] = $from_date;
        } elseif ($on_date == 3) {
            // This Week (Monday to Sunday)
            $from_date = date('Y-m-d', strtotime('last monday'));
            $to_date = date('Y-m-d', strtotime('next sunday'));
            $where['DATE(p.po_date) >='] = $from_date;
            $where['DATE(p.po_date) <='] = $to_date;
        } elseif ($on_date == 4) {
            // This Month (First day to Last day)
            $from_date = date('Y-m-01');
            $to_date = date('Y-m-t');
            $where['DATE(p.po_date) >='] = $from_date;
            $where['DATE(p.po_date) <='] = $to_date;
        } elseif ($on_date == 5) {
            // This Year (January 1st to December 31st)
            $from_date = date('Y-01-01');
            $to_date = date('Y-12-31');
            $where['DATE(p.po_date) >='] = $from_date;
            $where['DATE(p.po_date) <='] = $to_date;
        } elseif ($on_date == 6 && !empty($from_date) && !empty($to_date)) {
            // Custom Date Range
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));
            $where['DATE(p.po_date) >='] = $from_date;
            $where['DATE(p.po_date) <='] = $to_date;
        }
    }

         
        
        if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
         }
         
         if(isset($data['cost_project_id'])&&!empty($data['cost_project_id'])){
              if($data['cost_project_id'] !='all'){
                   $where['p.cost_project_id'] = $data['cost_project_id'];
              }
         }else{
             //$where['p.company_id'] =userId('company_id');
         }
        $total=0;
        $row1 = []; 
        $table_columns=array();
        // print_r($where);die;
        $count = count($this->POModel->getPoReportData('',0,$where));
        // echo $this->db->last_query();die;
            if($count)
            {
            $table_columns = array('Po Number','Vender Name','Item Group','Item Name','Unit','Rate','Qty','Amount','Cost Project Name','PO Date');
            $po_report_data = $this->POModel->getPoReportData('',0,$where);
            foreach ($po_report_data as $key => $data) 
            {  
                $row = [];
                 
                array_push($row, $data['po_order_no']);
                array_push($row, $data['vender_name']);
                array_push($row, $data['item_group_name']);
                array_push($row, $data['item_name']);
                array_push($row, $data['unit_name']);
                array_push($row, $data['item_rate']);
                array_push($row, $data['item_total_qty']);
                array_push($row, $data['item_amount']);
                array_push($row, $data['cost_project_name']);
                array_push($row, $data['po_date']);
                $columns[] = $row;
                }
                exportCsv1($table_columns,$columns,'Po_Report');
            }else{
               
               $this->session->set_flashdata('success','No data For Export ');
              
            } 
           
        redirect(ADMIN.'PO');
    }

}
