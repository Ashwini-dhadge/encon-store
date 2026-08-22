<?php
/**
 *
 */
class GoodsReceiptNote extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'store/GRNModel');
        $this->load->model(ADMIN . 'POModel');
         isLogin();
    }
        
    public function index()
    {
        
        $data['title'] = 'Goods Receipt Note List';
        $data['active'] = 'GoodsReceiptNote';
          $data['company_master'] = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1));
        $this->load->view(ADMIN.'store/goods_receipt_note/list_goods_receipt_note',$data);
    }

     public function poListAginstGRN()
    {
        $data['title'] = 'Goods Receipt Note List';
        $data['active'] = 'GoodsReceiptNote';
        $this->load->view(ADMIN.'store/goods_receipt_note/list_po',$data);
    }

    public function add_Goods_Receipt_Note($type=1,$id='')
    {
        $post=$this->input->post();
          
        $data['title'] = 'Add Goods Receipt Note';
        //type 1: update grn 
        //type 2: create grn from PO
         
        $data['master_tax_list'] = $this->CommonModel->getData('tbl_master_tax', array('status' => 1, 'is_deleted' => 0));
        $data['master_reject_list'] = $this->CommonModel->getData('tbl_master_reject_reasons', array('is_deleted' => 0));
        $data['grn_number'] = $this->GRNModel->getGRNNumber();
        $data['type']=$type;
        if($type==2){
                         //$id is po_id
                      
                        $po_data = $this->POModel->getPOData('', '0', '0', '0', '0',$id,'');
                       //  echo $this->db->last_query();die;
                        $po_info=array('id'=>$po_data[0]['id'],'vendor_id'=>$po_data[0]['vendor_id'],'freight_type'=>$po_data[0]['freight_type']);                         
                        $data['po_info']=$po_info;
                        $data['po_info_items']= $this->POModel->getPOItemDataALL(array($id));
                        $data['item_group'] =$this->POModel->getItemGroupList('', '');
                        $data['is_grn_update']=0;
                        
                        $data['item_group'] =$this->POModel->getItemGroupList('', '');
                        $data['item_list'] =$this->POModel->getItemList('', '');
                        //   echo "<pre>";
                        //     print_r($data);
                        //     die;
                      
        }else if(isset($post) && !empty($post) && $post['type']==3){
            //mutiple po create 1 grn
            $data['type']=3;
            $po_ids=explode(",", $post['po_ids']);
            $po_data = $this->POModel->getPOData('', '0', '0', '0', '0',$po_ids[0],'');
            $po_info=array('id'=>$post['po_ids'],'vendor_id'=>$po_data[0]['vendor_id'],'freight_type'=>$po_data[0]['freight_type']);                         
            $data['po_info']=$po_info;
            $data['po_info_items']= $this->POModel->getPOItemDataALL($po_ids);
            $data['is_grn_update']=0;
            
            $data['item_group'] =$this->POModel->getItemGroupList('', '');
            $data['item_list'] =$this->POModel->getItemList('');
            // echo "<pre>";
            // print_r($data);
            // die;
        }else if($type==1 && $id){
                        $grn_data = $this->GRNModel->getGRNData('', '0', '0', '0', '0',$id,'');
                        $data['grn_info']=$grn_data[0];
                        $data['po_info_items']= $this->GRNModel->getGRNItemDataALL(array('p.id'=>$id));
                        $data['item_group'] =$this->POModel->getItemGroupList('', '');
                        $data['issue_type']=1;
                        $data['is_grn_update']=1;
                        // echo "<pre>";
                        // print_r($data);
                        // die;
        }
// echo "<pre>";
//                         print_r($data);
//                         die;
        $this->load->view(ADMIN.'store/goods_receipt_note/add_goods_receipt_note', $data);
    }

    public function saveGrn()
    {
       
       $attachement = array();
        $post = $this->input->post();
                
            if ($post){
                        

                        if(isset($post['grn_date'])) {
                          
                                $formattedDate =strtotime(str_replace('/', '-', $post['grn_date']));
                                $grn_date = date('Y-m-d',$formattedDate);
                               
                        } else {
                                $grn_date = date('Y-m-d');
                        }
                      
                        if(isset($post['grn_time'])) {
                                $grn_time = date('H:m', strtotime($post['grn_time']));
                        } else {
                                $grn_time = date('H:m');
                        }


                        
                        if(isset($post['bill_date'])) {
                                $formattedDate =strtotime(str_replace('/', '-', $post['bill_date']));
                                $bill_date = date('Y-m-d',$formattedDate);
                               
                        } 

                        if(isset($post['lr_date'])) {
                                $formattedDate =strtotime(str_replace('/', '-', $post['lr_date']));
                                $lr_date = date('Y-m-d',$formattedDate);
                               
                        } 

                        if(isset($post['challan_date'])) {
                               $formattedDate =strtotime(str_replace('/', '-', $post['challan_date']));
                                $challan_date = date('Y-m-d',$formattedDate);
                           
                        } 

                        if(isset($post['custom_inward_date'])) {
                                $formattedDate =strtotime(str_replace('/', '-', $post['custom_inward_date']));
                                $custom_inward_date = date('Y-m-d',$formattedDate);
                                
                        }
                        
                        if(isset($post['unload_date'])) {
                            //   print_r($post['unload_date']);
                                $formattedDate =strtotime(str_replace('/', '-', $post['unload_date']));
                                $unload_date = date('Y-m-d',$formattedDate);
                        }
                        
                      
                        
                        $grn_order_sequence = $this->GRNModel->getGRNOrderSequenceNumber();
                        
                      

                         $insert = array(
                                'po_id' => (isset($post['po_id'])) ? $post['po_id'] :NULL,
                                'grn_order_sequence' => $grn_order_sequence,
                                'grn_no'=> (isset($post['grn_no'])) ? $post['grn_no'] :NULL,  
                                'grn_date'=>(isset($grn_date)) ? $grn_date :NULL,     
                                'grn_time'=>(isset($grn_time)) ? $grn_time :NULL,                                                            
                                'remark' => (isset($post['reamrk'])) ? $post['reamrk'] :NULL,
                                'line_in_bottom' => (isset($post['line_in_bottom'])) ? $post['line_in_bottom'] :NULL,
                                'jurisdiction' => (isset($post['jurisdiction'])) ? $post['jurisdiction'] :NULL,
                                'financial_year_id' => userId('financial_year_id'),
                                'company_id' => userId('company_id'),
                                'site_id' => userId('site_id'),
                                'created_by' => userId(),
                                'manual_slip_no'=>(isset($post['manual_slip_no']))?$post['manual_slip_no']:NULL,
                                'unload_date'=>(isset($unload_date))?$unload_date:NULL,
                                'received_from'=>(isset($post['received_from']))?$post['received_from']:NULL,
                                'received_by'=>(isset($post['received_by']))?$post['received_by']:NULL,
                                 'checked_by'=>(isset($post['checked_by']))?$post['checked_by']:NULL,
                                'receive_location_site_id'=>(isset($post['receive_location_site_id']))?$post['receive_location_site_id']:NULL,
                                'vendor_id'=>(isset($post['vendor_id']))?$post['vendor_id']:NULL,
                                'is_cash_payment'=>(isset($post['is_cash_payment']))?$post['is_cash_payment']:NULL,
                                'is_party_vendor'=>(isset($post['is_party_vendor']))?$post['is_party_vendor']:NULL,
                                'is_party_vendor_id'=>(isset($post['is_party_vendor_id']))?$post['is_party_vendor_id']:NULL,
                                'is_aginst_c_form'=>(isset($post['is_aginst_c_form']))?$post['is_aginst_c_form']:NULL,
                                'is_reverse_charge'=>(isset($post['is_reverse_charge']))?$post['is_reverse_charge']:NULL,
                                'party_bill_amount'=>(isset($post['party_bill_amount']))?$post['party_bill_amount']:NULL,
                                'party_bill_no'=>(isset($post['party_bill_no']))?$post['party_bill_no']:NULL,
                                'transport_id'=>(isset($post['transport_id']))?$post['transport_id']:NULL,
                                'transport_name'=>(isset($post['transport_name']))?$post['transport_name']:NULL,
                                'driver_name'=>(isset($post['driver_name']))?$post['driver_name']:NULL,
                                'loaded_via'=>(isset($post['loaded_via']))?$post['loaded_via']:NULL,
                                'loaded_vendor_id'=>(isset($post['load_party_id']))?$post['load_party_id']:NULL,
                                'lr_no'=>(isset($post['lr_no']))?$post['lr_no']:NULL,
                                'lr_date'=>(isset($lr_date))?$lr_date:NULL,
                                'challan_no'=>(isset($post['challan_no']))?$post['challan_no']:NULL,
                                'challan_date'=>(isset($challan_date))?$challan_date:NULL,
                                'vehicle_reading'=>(isset($post['vehicle_reading']))?$post['vehicle_reading']:NULL,
                                'vehicle_no'=>(isset($post['vehicle_no']))?$post['vehicle_no']:NULL,
                                'rst_no'=>(isset($post['rst_no']))?$post['rst_no']:NULL,
                                'gate_pass_no'=>(isset($post['gate_pass_no']))?$post['gate_pass_no']:NULL,
                                'custom_inward_no'=>(isset($post['custom_inward_no']))?$post['custom_inward_no']:NULL,
                                'custom_inward_date'=>(isset($custom_inward_date))?$custom_inward_date:NULL,
                                'lab_report_no'=>(isset($post['lab_report_no']))?$post['lab_report_no']:NULL,
                                'bill_date'=>(isset($bill_date))?$bill_date:NULL, 
                                'is_material_issue'=>(isset($post['is_material_issue']))?$post['is_material_issue']:NULL, 

                        );
                         
                        if (empty($post['id'])) {
                                $company_id=userId('company_id');
                                $site_id= userId('site_id');
                                 $financial_year_id=userId('financial_year_id');
                                $grn_id = $this->CommonModel->iudAction('tbl_grn', $insert, 'insert');
                        } else {
                                unset($insert['created_by']);
                                unset($insert['site_id']);
                                unset($insert['company_id']);
                                unset($insert['financial_year_id']);
                                $insert['updated_at'] = date('Y-m-d');
                                $insert['updated_by'] = userId();
                                $this->CommonModel->iudAction('tbl_grn', $insert, 'update', array('id' => $post['id']));
                                $grn_id = $post['id'];
                                
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
                    
                         //tax deatils
                         
 
                        $insert_tax_data = array(
                                'grn_id' => $grn_id,
                                'total_pending_qty' => (isset($post['total_pending_qty'])) ? $post['total_pending_qty'] :NULL,
                                'total_received_qty' => (isset($post['total_received_qty'])) ? $post['total_received_qty'] :NULL,
                                'total_return_qty' =>(isset($post['total_return_qty'])) ? $post['total_return_qty'] :NULL,
                                'total_other_charges' =>(isset($post['total_other_charges'])) ? $post['total_other_charges'] :NULL,
                                'item_total_qty' => (isset($post['total_received_qty'])) ? $post['total_received_qty'] :NULL,
                                'total_item_subtotal' => (isset($post['total_item_amount'])) ? $post['total_item_amount'] :NULL,                               
                                'item_total_discount' => (isset($post['total_discount'])) ? $post['total_discount'] :NULL,
                                'total_item_gst' => (isset($post['total_gst'])) ? $post['total_gst'] :NULL,
                                'total_additional_gst' => (isset($post['total_additional_gst'])) ? $post['total_additional_gst'] :NULL,
                                'total_item_subtotal' => (isset($post['total_sub_amount'])) ? $post['total_sub_amount'] :NULL,
                                'discount_percent' => (isset($post['final_discount_percent'])) ? $post['final_discount_percent'] :NULL,
                                'discount_amount' => (isset($post['final_discount_amount'])) ? $post['final_discount_amount'] :NULL,
                                'gst_amount' => (isset($post['final_gst'])) ? $post['final_gst'] :NULL,
                                'ld_charges' => (isset($post['ld_charges'])) ? $post['ld_charges'] :NULL,   
                                'ld_clause_text' => (isset($post['ld_clause_text'])) ? $post['ld_clause_text'] :NULL,   
                                'freight_type' => (isset($post['freight'])) ? $post['freight'] :NULL,
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
                                'new_tax_amount' => (isset($post['new_tax_amount'])) ? $post['new_tax_amount'] :NULL,
                                'service_charge_type' => (isset($post['service_charge_type'])) ? $post['service_charge_type'] :NULL,
                                'service_charge_amount' => (isset($post['service_charge_amount'])) ? $post['service_charge_amount'] :NULL,
                                'service_tax_id' => (isset($post['service_tax_id'])) ? $post['service_tax_id'] :NULL,
                                'service_tax_rate' => (isset($post['service_tax_rate'])) ? $post['service_tax_rate'] :NULL,
                                'service_tax_amount' => (isset($post['service_tax_amount'])) ? $post['service_tax_amount'] :NULL,
                                'round_off' => (isset($post['round_off'])) ? $post['round_off'] :NULL,
                                'landed_cost_final_amount' => (isset($post['po_final_amount'])) ? $post['po_final_amount'] : '',
                                'packing_forwarding_amount'=>(isset($post['packing_forwarding_amount'])) ? $post['packing_forwarding_amount'] : NULL,
                        );
                       


                        if (empty($post['id'])) {
                                $po_ids = $this->CommonModel->iudAction('tbl_grn_tax_details', $insert_tax_data, 'insert');
                        } else {
                                unset($insert['created_by']);
                                $insert['updated_at'] = date('Y-m-d');
                                $insert['updated_by'] = userId();
                                $grn_id=$post['id'];
                                $this->CommonModel->iudAction('tbl_grn_tax_details', $insert_tax_data, 'update', array('grn_id' => $grn_id));
                                // $po_id = $post['id'];
                        } 
                        
                        //
                        $delete_item_array=array();
                        if(isset($post['id']) && ($post['is_grn_update'] && $post['id'])){
                             $old_grn_item_data=$this->CommonModel->getData('tbl_grn_items_details', array('grn_id' => $grn_id), '', '', '');
                             $old_item_array=array_column($old_grn_item_data, 'item_id');
                             $new_item_array=array_column($post['items'], 'items_id');
                             //array difference
                             $delete_item_array= array_diff($old_item_array, $new_item_array);
                        }
                        

                        if(isset($post['items']) && count($post['items']) != 0) {
                                // echo "<pre>";
                                // print_r($post['items']);
                                 
                        
                                foreach ($post['items'] as $key => $item) {
                                     $is_new_unit_change=0;
                                        if(!empty($post['id'])) {
                                            $get_grn_item_data = $this->CommonModel->getData('tbl_grn_items_details', array('grn_id' =>$post['id'],'deleted_by' => NULL ,'item_id'=>$item['items_id'],'id'=>$item['grn_item_id']),'','','row_array');
                                        }else{
                                            $get_grn_item_data=array();
                                        }
                                        //echo $this->db->last_query();die;
                                        
                                        $is_inv_add=$is_inv_minius=$update_qty=$is_new_batch=0;
                                        $old_batch_no='';
                                         $expired_date=NULL;
                                        if(isset($item['expired_date'])) {
                                            $expired_date = date('Y-m-d',strtotime($item['expired_date']));
                                        }
                                       $new_received_qty=$item['po_received_qty'];;
                                    //   echo "<pre>";
                                    //   print_r($item);
                                        if(isset($post['id']) && !empty($get_grn_item_data) && isset($get_grn_item_data['received_qty']) && isset($get_grn_item_data['batch_no']) && isset($item['po_received_qty'])){
                                            $old_received_qty=$get_grn_item_data['received_qty'];
                                            $new_received_qty=$item['po_received_qty'];
                                            
                                            $old_received_unit=$get_grn_item_data['item_unit_id'];
                                            $new_received_unit=$item['received_unit'];
                                            
                                            $old_expired_date=$get_grn_item_data['expired_date'];
                                            $new_expired_date=$expired_date;
                                            

                                         //   echo $new_received_qty."<br>".$old_received_qty;
                                            if($old_received_unit==$new_received_unit && $old_expired_date==$new_expired_date){
                                                 if($item['batch_no']==$get_grn_item_data['batch_no']){
                                                    if($new_received_qty > $old_received_qty){
                                                        $update_qty=$new_received_qty-$old_received_qty;
                                                        $is_inv_add=1;
                                                        //add update qty
                                                    }else if($new_received_qty < $old_received_qty){
                                                        $update_qty=$old_received_qty-$new_received_qty;
                                                        $is_inv_minius=1;
                                                        //minius update qty
                                                    }else if($old_received_qty==$new_received_qty && $old_expired_date!=$new_expired_date){
                                                        
                                                    }
                                                    
                                                    
                                                    $is_new_batch=0;
                                                }else{
                                                    //new batch new qty add aginst that batcha and from old batch remove that recevied qty
                                                    $is_new_batch=1;
                                                    $is_inv_add=1;
                                                    $is_inv_minius=1;
                                                    $update_qty=$new_received_qty;
                                                    $old_batch_no=$get_grn_item_data['batch_no'];
                                                    $old_expired_date=$get_grn_item_data['expired_date'];
                                                    
                                                }
                                                 $is_new_unit_change=0;
                                            }else{
                                                    $is_new_unit_change=1;
                                                    $is_new_batch=1;
                                                    $is_inv_add=1;
                                                    $is_inv_minius=1;
                                                    $new_qty=$new_received_qty;
                                                    $old_qty=$old_received_qty;
                                                    $old_batch_no=$get_grn_item_data['batch_no'];
                                                    $old_expired_date=$get_grn_item_data['expired_date'];
                                                    $new_batch_no=$item['batch_no'];
                                                    $new_expired_date=$item['expired_date'];
                                            }
                                           
                                        }
                                        // echo "<br>".$is_inv_add."<br>".$update_qty."<br>".$old_received_qty."<br>".$new_received_qty."<br>".$old_qty."<br>".$new_qty;
                                       
                                        $update_batch_no=$item['batch_no'];
                                        $update_expired_date=$expired_date;
                                        
                                       if(isset($item['item_weight']) && !empty($item['item_weight'])){
                                           if(!empty($item['received_qty'])==0){
                                                $weight_per_qty=$item['item_weight']/$item['received_qty'];
                                                $rate_per_weight=$item['item_final_amount']/$item['received_qty'];
                                           }else{
                                                $weight_per_qty=NULL;
                                                $rate_per_weight=NULL;
                                           }
                                           
                                        }else{
                                            $weight_per_qty=NULL;
                                            $rate_per_weight=NULL;
                                        }
                                       
                                        
                                        $insert_item_data = array(
                                                'grn_id' => $grn_id,
                                                'item_group_id' => (isset($item['item_group_id'])) ? $item['item_group_id'] :NULL,
                                                'item_id' => (isset($item['items_id'])) ? $item['items_id'] :NULL,
                                                'received_qty'=>(isset($item['received_qty']))?$item['received_qty']:NULL,
                                                'item_unit_id'=>(isset($item['received_unit']))?$item['received_unit']:NULL,
                                                'item_weight'=>(isset($item['item_weight']))?$item['item_weight']:NULL,
                                                'item_weight_unit'=>(isset($item['item_weight_unit']))?$item['item_weight_unit']:NULL,
                                                'item_length'=>(isset($item['item_length']))?$item['item_length']:NULL,
                                                'item_length_unit_id'=>(isset($item['item_length_unit_id']))?$item['item_length_unit_id']:NULL,
                                                'why_change_reason'=>(isset($item['reason']))?$item['reason']:NULL,  
                                                'item_rate' => (isset($item['item_unit_rate'])) ? $item['item_unit_rate'] :NULL,
                                                'item_rate_type' => (isset($item['item_unit_type'])) ? $item['item_unit_type'] :NULL,
                                                'item_sub_amount' => (isset($item['item_total'])) ? $item['item_total'] :NULL,
                                                'item_return_qty'=>(isset($item['return_qty']))?$item['return_qty']:NULL,
                                                'item_return_qty_unit'=>(isset($item['return_qty_unit']))?$item['return_qty_unit']:NULL,
                                                'item_other_charges_type' => (isset($item['other_charges_type'])) ? $item['other_charges_type'] :NULL,
                                                'item_other_charges_percentage' => (isset($item['item_other_percent'])) ? $item['item_other_percent'] :NULL,
                                                'item_other_charges_value' => (isset($item['item_other_charges_amt'])) ? $item['item_other_charges_amt'] :NULL,
                                                'item_discount_percent' => (isset($item['discount_percent'])) ? $item['discount_percent'] :NULL,
                                                'item_discount_type' => (isset($item['discount_type'])) ? $item['discount_type'] :NULL,
                                                'item_discount_amount' => (isset($item['discount_value'])) ? $item['discount_value'] :NULL,                                                
                                                'tax_id' => (isset($item['tax_id'])) ? $item['tax_id'] :NULL,
                                                'tax_type' => (isset($item['gst_type'])) ? $item['gst_type'] :NULL,
                                                'tax_rate' => (isset($item['tax_rate'])) ? $item['tax_rate'] :NULL,
                                                'tax_value' => (isset($item['tax_value'])) ? $item['tax_value'] :NULL,
                                                'additional_tax_id' => (isset($item['additional_gst'])) ? $item['additional_gst'] :NULL,
                                                'additional_tax_rate' => (isset($item['additional_tax_rate'])) ? $item['additional_tax_rate'] :NULL,
                                                'additional_tax_value' => (isset($item['additional_gst_amount'])) ? $item['additional_gst_amount'] :NULL,
                                                'item_amount' => (isset($item['item_final_amount'])) ? $item['item_final_amount'] :NULL,                                              
                                                'warranty_description' => (isset($item['warranty_desc'])) ? $item['warranty_desc'] :NULL,
                                                'other_description' => (isset($item['other_desc'])) ? $item['other_desc'] :NULL,
                                                'technical_description ' => (isset($item['technical_description'])) ? $item['technical_description'] :NULL,
                                                'po_total_pending_qty'=>(isset($item['po_total_pending_qty']))?$item['po_total_pending_qty']:NULL,
                                                'po_total_pending_qty_unit'=>(isset($item['po_total_pending_qty_unit']))?$item['po_total_pending_qty_unit']:NULL,
                                                'po_excess_quantity'=>(isset($item['po_excess_qty']))?$item['po_excess_qty']:NULL,
                                                'po_challan_quantity'=>(isset($item['po_challan_qty']))?$item['po_challan_qty']:NULL,
                                                'po_challan_qty_unit'=>(isset($item['po_challan_qty_unit']))?$item['po_challan_qty_unit']:NULL,
                                                'po_received_quantity'=>(isset($item['po_received_qty']))?$item['po_received_qty']:NULL,
                                                'po_received_qty_unit'=>(isset($item['po_received_qty_unit']))?$item['po_received_qty_unit']:NULL,
                                                'po_rejected_quantity'=>(isset($item['po_rejected_qty']))?$item['po_rejected_qty']:NULL,
                                                'po_rejected_qty_unit'=>(isset($item['po_rejected_qty_unit']))?$item['po_rejected_qty_unit']:NULL, 
                                                'po_adjustment_qty'=>(isset($item['po_adjustment_qty']))?$item['po_adjustment_qty']:NULL, 
                                                'batch_no'=>(isset($item['batch_no']))?$item['batch_no']:NULL, 
                                                'expired_date'=>(isset($expired_date))?$expired_date:NULL, 
                                                'reject_reasons'=>(isset($item['reject_reasons']))?$item['reject_reasons']:NULL, 
                                                'created_by' => userId(),
                                                'weight_per_qty'=>$weight_per_qty,
                                                'weight_per_rate'=>$rate_per_weight
                                                
                                        );
                                        $item_rate_type=$item['item_unit_type'];
                                        $item_weight=$item['item_weight'];
                                        $item_unit_rate=$item['item_unit_rate'];
                                        
                                        //  echo "<pre>";
                                        
                                        if (isset($item['grn_item_id']) && !empty($item['grn_item_id'])) {
                                                unset($insert_item_data['created_by']);
                                                
                                                $insert_item_data['updated_at'] = date('Y-m-d');
                                                $insert_item_data['updated_by'] = userId();
                                                
                                                if((isset($item['po_id']) && $post['type']==1) ){
                                                     $insert_item_data['po_id']=$item['po_id'];
                                                    $chk = $this->CommonModel->getData('tbl_grn_items_details',array('po_id'=>$item['po_id'],'item_group_id'=>$item['item_group_id'],'item_id'=>$item['items_id'],'deleted_by' => NULL),'sum(received_qty) as total ','','row_array'); 
                                                    if(!is_null($chk['total']) && isset($chk['total']) && $chk['total']!=0){
                                                        $earlier_receive_qty=$chk['total'];
                                                    }else{
                                                       $earlier_receive_qty=NULL; 
                                                    }
                                                    $insert_item_data['earlier_receive_qty']=$earlier_receive_qty;
                                                    
                                                    
                                                    $chk1 = $this->CommonModel->getData('tbl_po_items_details',array('id'=>$item['po_id'],'item_group_id'=>$item['item_group_id'],'item_id'=>$item['items_id']),'sum(item_qty) as total ','','row_array'); 
                                                    if(!is_null($chk1['total']) && isset($chk1['total']) && $chk1['total']!=0){
                                                        $total_item_po_qty=$chk['total'];
                                                    }else{
                                                       $total_item_po_qty=NULL; 
                                                    }
                                                    $insert_item_data['total_item_po_qty']=$total_item_po_qty;
                                                }
                                                
                                                
                                                $this->CommonModel->iudAction('tbl_grn_items_details', $insert_item_data, 'update', array('id' => $item['grn_item_id']));
                                                $sub_grn_id=$item['grn_item_id'];
                                               
                                                 if ((isset($item['po_id']) && $post['type']==1)) {
                                                    //  echo "po_total_pending_qty".$item['po_total_pending_qty'];die;
                                                        if(isset($item['po_total_pending_qty']) && ($item['po_total_pending_qty']==0)){   
                                                             $this->CommonModel->iudAction('tbl_po_items_details', array('po_grn_status'=>2,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('po_id' => $item['po_id'],'item_id'=>$item['items_id']));
                                                        }else if(isset($item['po_total_pending_qty']) && ($item['po_total_pending_qty']!=0) && isset($item['po_adjustment_qty']) && ($item['po_adjustment_qty']!=0)){
                                                             $this->CommonModel->iudAction('tbl_po_items_details', array('po_grn_status'=>2,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('po_id' => $item['po_id'],'item_id'=>$item['items_id']));
                                                        }else{
                                                             $this->CommonModel->iudAction('tbl_po_items_details', array('po_grn_status'=>1,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('po_id' => $item['po_id'],'item_id'=>$item['items_id']));
                                                        }
                                                    }
                                                    // echo $this->db->last_query();die;
                                                   
                                
                                
                                              
                                                 if(isset($post['id']) && ($post['is_grn_update'] && $post['id'])){
                                                     
                                                    if( $is_new_unit_change==0){
                                                            if($is_new_batch==1){
                                                                updateQuickInventory($item['items_id'],$item['received_unit'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,GRN_TYPE,$grn_id,userId(),$update_batch_no,$update_expired_date,0,$sub_grn_id,$item_rate_type,$item_weight,$item_unit_rate);
                                                                updateQuickInventory($item['items_id'],$item['received_unit'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,GRN_TYPE,$grn_id,userId(),$old_batch_no,$old_expired_date,0,$sub_grn_id);
                                                            }else if($is_new_batch==0){
                                                                if($is_inv_add==1){
                                                                     updateQuickInventory($item['items_id'],$item['received_unit'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,GRN_TYPE,$grn_id,userId(),$update_batch_no,$update_expired_date,0,$sub_grn_id,$item_rate_type,$item_weight,$item_unit_rate);
                                                                }
                                                                
                                                                if($is_inv_minius==1){
                                                                    updateQuickInventory($item['items_id'],$item['received_unit'],$update_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,GRN_TYPE,$grn_id,userId(),$update_batch_no,$update_expired_date,0,$sub_grn_id);
                                                                }
                                                            }
                                                    }else{
                                                        //unite item change
                                                            //new add
                                                            
                                                            updateQuickInventory($item['items_id'],$new_received_unit,$new_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ADD,GRN_TYPE,$grn_id,userId(),$new_batch_no,$new_expired_date,0,$sub_grn_id,$item_rate_type,$item_weight,$item_unit_rate);
                                                            //old remove
                                                            updateQuickInventory($item['items_id'],$old_received_unit,$old_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,GRN_TYPE,$grn_id,userId(),$old_batch_no,$old_expired_date,0,$sub_grn_id);
                                                    }
                                                     
                                                }
                                                
                                                
                                        //              if($item['batch_no']=='t-9'){
                                        //     // echo "is_inv_add=".$is_inv_add."<br>";
                                        //     // echo "is_inv_minius=".$is_inv_minius."<br>";
                                        //     // echo "update_qty=".$update_qty."<br>";
                                        //     //  echo "is_new_unit_change=".$is_new_unit_change."<br>";
                                        //     //   echo "is_new_batch=".$is_new_batch."<br>";
                                        //     // print_r($post['id']);
                                        //     //   print_r($post['is_grn_update']);
                                        //     //echo $this->db->last_query();
                                               
                                        //     die;
                                        // }
                                                
                                        }else{
                                            //if type 3= mutiple po create po or grn create single po
                                            if($post['type']==3 || $post['type']==2 || (isset($item['po_id']) && $post['type']==1) ){
                                                    $insert_item_data['po_id']=$item['po_id'];
                                                    $insert_item_data['po_item_id']=$item['po_item_id'];
                                                   
                                                    $chk = $this->CommonModel->getData('tbl_grn_items_details',array('po_id'=>$item['po_id'],'item_group_id'=>$item['item_group_id'],'item_id'=>$item['items_id'],'deleted_by' => NULL),'sum(received_qty) as total ','','row_array'); 
                                                    if(!is_null($chk['total']) && isset($chk['total']) && $chk['total']!=0){
                                                        $earlier_receive_qty=$chk['total'];
                                                    }else{
                                                       $earlier_receive_qty=NULL; 
                                                    }
                                                    $insert_item_data['earlier_receive_qty']=$earlier_receive_qty;
                                                    
                                                    
                                                    $chk1 = $this->CommonModel->getData('tbl_po_items_details',array('id'=>$item['po_id'],'item_group_id'=>$item['item_group_id'],'item_id'=>$item['items_id']),'sum(item_qty) as total ','','row_array'); 
                                                    if(!is_null($chk1['total']) && isset($chk1['total']) && $chk1['total']!=0){
                                                        $total_item_po_qty=$chk['total'];
                                                    }else{
                                                       $total_item_po_qty=NULL; 
                                                    }
                                                    $insert_item_data['total_item_po_qty']=$total_item_po_qty;
                                                    
                                                    
                                                    
                                            }
                                             
    
                                            $grn_item_s = $this->CommonModel->iudAction('tbl_grn_items_details', $insert_item_data, 'insert');

                                            if($post['type']==3 || $post['type']==2){
                                                //updateids
                                                 if (isset($item['po_item_id']) && !empty($item['po_item_id']) || (isset($item['po_id']) && $post['type']==1)) {
                                                        if(isset($item['po_total_pending_qty']) && ($item['po_total_pending_qty']==0)){   
                                                             $this->CommonModel->iudAction('tbl_po_items_details', array('po_grn_status'=>2,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $item['po_item_id']));
                                                        }else if(isset($item['po_total_pending_qty']) && ($item['po_total_pending_qty']!=0) && isset($item['po_adjustment_qty']) && ($item['po_adjustment_qty']!=0)){
                                                             $this->CommonModel->iudAction('tbl_po_items_details', array('po_grn_status'=>2,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $item['po_item_id']));
                                                        }else{
                                                             $this->CommonModel->iudAction('tbl_po_items_details', array('po_grn_status'=>1,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $item['po_item_id']));
                                                        }
                                                    }
                                            }
                                            $batch_no=(isset($item['batch_no']))?$item['batch_no']:NULL; 
                                            $expired_date=(isset($expired_date))?$expired_date:NULL;
                                           
                                      
                                                //in Grn add condition 
                                                 updateQuickInventory($item['items_id'],$item['received_unit'],$item['received_qty'],userId('company_id'),userId('site_id'),userId('financial_year_id'),INVENTORY_ACTION_ADD,GRN_TYPE,$grn_id,userId(),$batch_no,$expired_date,0,$grn_item_s, $item_rate_type,$item_weight,$item_unit_rate);
                                          
                                           
                                          
                                        }
                                }
                        }
                        
                        if(isset($post['id']) && ($post['is_grn_update'] && $post['id']) && !empty($delete_item_array)){
                            //update case if grn Item Delete From 
                            if(count($delete_item_array) !=0){
                                
                                    foreach ($delete_item_array as $key => $delete_item) {
                                        $get_grn_item_data=array();
                                        $get_grn_item_data = $this->CommonModel->getData('tbl_grn_items_details', array('grn_id' => $post['id'], 'deleted_by' => NULL ,'item_id'=>$delete_item),'','','row_array');
                                        if(isset($post['id']) && !empty($get_grn_item_data) && isset($get_grn_item_data['received_qty']) && isset($get_grn_item_data['batch_no'])){
                                            $delete_qty=$get_grn_item_data['received_qty'];
                                            $delete_batch_no=$get_grn_item_data['batch_no'];
                                            $delete_expired_date=$get_grn_item_data['expired_date'];
                                            
                                                $insert_item_data['deleted_at'] = date('Y-m-d');
                                                $insert_item_data['deleted_by'] = userId();
                                                $this->CommonModel->iudAction('tbl_grn_items_details', $insert_item_data, 'update', array('item_id' => $delete_item,'grn_id'=>$post['id']));
                                                
                                                updateQuickInventory($delete_item,$get_grn_item_data['item_unit_id'],$delete_qty,$company_id,$site_id,$financial_year_id,INVENTORY_ACTION_ISSUE_MINUS,GRN_TYPE,$grn_id,userId(),$delete_batch_no,$delete_expired_date,0,$post['id']);
                                               
                                        }
                                    }
                            }
                        }
                         $attachement = array();

                        if (!empty($_FILES['file_name']['name'][0])) {
                                $uploadStatus = myUpload(GRN_ATTACH, 'file_name', true);
                                if(!empty($uploadStatus)){
                                     $attachement = $uploadStatus['data'];
                                }
                               
                        }

                        if (empty($post['id']) && empty($post['file_name_id'])) {
                           foreach ($attachement as $key => $value) {
                                $insert_attch_data = array(
                                         'grn_id' => $grn_id,
                                        'file_name' => $value['file_name'],
                                        'created_by' => userId()
                                 );
                                 $this->CommonModel->iudAction('tbl_grn_attachment', $insert_attch_data, 'insert');
                            }
                        } else {
                                
                                if(isset($post['file_name_id'] )){
                                     foreach ($post['file_name_id'] as $key4 => $val4) {
                                
                                        $chk = $this->CommonModel->getData('tbl_grn_attachment',array('id'=>$val4),'','','row_array'); 
    
                                        if($chk){
                                            $update_attch_data = array(
                                                    'grn_id' => $grn_id,
                                                    'file_name' => $chk['file_name'],
                                                    'updated_by' => userId(),
                                                    'updated_at' => date('Y-m-d'),
                                            );
                                            $this->CommonModel->iudAction('tbl_grn_attachment',$update_attch_data,'update',array('id'=>$val4,'po_id'=>$post['id']));
                                        }else{
                                          $this->CommonModel->iudAction('tbl_grn_attachment','','delete',array('id'=>$val4,'po_id'=>$post['id']));    
                                        }
                                            
                                       
                                    }
                                }
                                
                               

                                foreach ($attachement as $key => $value) {
                                    $update_attch_data_a = array(
                                        'grn_id' => $grn_id,
                                        'file_name' => $value['file_name'],
                                        'updated_by' => userId(),
                                        'updated_at' => date('Y-m-d'),
                                      );
                                     $this->CommonModel->iudAction('tbl_grn_attachment', $update_attch_data_a, 'insert');
                                }        

                                   
                                }
                    if($post['type']==3 || $post['type']==2 || ($post['type']==1 && isset($post['po_id']))){
                        // 'po_id' => (isset($post['po_id'])) ? $post['po_id'] :NULL,
                        $po_id=$post['po_id'];
                        $po_ids=explode(",", $post['po_id']);
                        $this->updateALLPOStatus($po_ids);
                    }
                       // echo "<pre>";
//                     $request = http_build_query($_POST);
// $size = strlen($request);
// echo $size;
                          //  print_r($post);
                            // die;
                    // die;
                    if(isset($post['is_material_issue']) && $post['is_material_issue']==1){
                         $this->session->set_flashdata('success','GRN Successfully');
                         redirect(base_url().'admin/store/MaterialIssue/issueFromGRN/'.$grn_id);
                    }else if($post['type']==3 || $post['type']==2){
                        $this->session->set_flashdata('success','GRN Successfully');
                    redirect(base_url().'admin/store/GoodsReceiptNote/poListAginstGRN');
                    }else{
                        $this->session->set_flashdata('success','GRN Successfully');
                    redirect(base_url().'admin/store/GoodsReceiptNote/index');
                    }
                    
                    
     
            }else{
                $this->session->set_flashdata('error','GRN not created');
                         redirect(base_url().'admin/PO');
            }
            
    }
     public function listPo()
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
         if(!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id']!="all"){
            $item_id=$data['item_id'];
         }else{
            $item_id='';
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
         
        $where['p.po_status']=1;
        $where['p.po_grn_status !=']=2;
        $count = count($this->POModel->getPOData($searchVal,0,0,0,0,0,$where,$item_id));
        
        if($count){
            $result = $this->POModel->getPOData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id);
            // echo $this->db->last_query();die;
                foreach ($result as $key => $value) {
                    $flag=$own_flag_access=0;
                    $row = []; 
                    $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['id'].'" title="View Items">';
                    $html='<input type="checkbox" class=" form-check-input checkbox_grn_po" value="'.$value['id'].'" data-vendor_id="'.$value['vendor_id'].'" data-delivery_site_id="'.$value['delivery_site_id'].'" data-po_id="'.$value['id'].'">';
                    $cnt=$offset + ($key + 1);
                    array_push($row, $html." ".$cnt." ".$html1);
                    array_push($row, '<a href="'.base_url().'admin/PO/viewPoDetailsData/'.$value['po_id'] .'" title="view" class="" data-toggle="tooltip">'.$value['po_order_no'].'</a>');
                    array_push($row, dmyDate($value['po_date']));
                    array_push($row, $value['vendor_name']);
                    array_push($row, $value['delivery_site_name']);

                    $pending_array=array();
                    $pending_qty=$item_total_qty=0;
                    $pending_array=$this->GRNModel->getPOPendingCount(array('p.id' =>$value['po_id']));
                   // echo $this->db->last_query();die;
                    if(isset($pending_array) && !empty($pending_array)){
                        if(isset($value['item_total_qty']) && isset($pending_array['received_qty'])){
                            $pending_qty=$value['item_total_qty']-$pending_array['received_qty'];

                        }
                        if(isset($value['total_po_qty'])){
                            $item_total_qty=$value['total_po_qty'];
                        }
                    }

                    if(isset($value['item_total_qty']) &&  isset($item_total_qty) && $item_total_qty==0){
                        $item_total_qty=$value['item_total_qty'];
                    }

                    array_push($row,$item_total_qty);
                    array_push($row,$pending_qty);                
                    if($value['po_grn_status']==0){
                         $status='<center><span class="badge badge-danger">Pending</span></center>';
                         $flag=1;
                    }else if($value['po_status']==1){
                         $status='<center><span class="badge badge-success">Inprocess</span></center>';
                    }else if($value['po_status']==2){
                         $status='<center><span class="badge badge-success">Completed</span></center>';
                    }
                    array_push($row, $status);
                   
                    $action='';

                    $action='<a href="'.base_url().'admin/store/GoodsReceiptNote/add_Goods_Receipt_Note/2/'.$value['id'] .'" title="po_pdf" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;">Create GRN</a>'; 


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
    public function updateALLPOStatus($po_ids)
    {
        foreach($po_ids as $key=>$value){
            if($value){
                    $item_ids = $this->CommonModel->getData('tbl_po_items_details', array('po_id' => $value,'deleted_by'=>NULL),'po_grn_status');

                    if(!empty($item_ids) && count($item_ids)){
                        $status_arr=array_column($item_ids , 'po_grn_status');
                         $valueCount = isset(array_count_values($status_arr)[2]) ? array_count_values($status_arr)[2] : 0;
                         $valuePendingCount = isset(array_count_values($status_arr)[0]) ? array_count_values($status_arr)[0] : 0;
                         if($valueCount==count($status_arr)){
                                //update complaeted
                            $this->CommonModel->iudAction('tbl_po', array('po_grn_status'=>2,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $value));
                         }else if($valuePendingCount==count($status_arr)){
                            ////update pending
                            $this->CommonModel->iudAction('tbl_po', array('po_grn_status'=>0,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $value));
                         }else{
                            //inprocess
                            $this->CommonModel->iudAction('tbl_po', array('po_grn_status'=>1,'updated_by'=>userId(),'updated_at'=>date('Y-m-d')), 'update', array('id' => $value));
                         }
                            
                    }
            }
        }
        // code...
    }
    public function listGRN()
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
              if($data['site_id'] !='all'){
                   $where['p.site_id'] = $data['site_id'];
              }
         }else{
             //$where['p.site_id'] =userId('site_id');
         } 
         if(empty($data['company_id']) &&  empty($data['site_id'])){
             $where['p.company_id'] =userId('company_id');
             $where['p.site_id'] =userId('site_id');
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
            $where['date(p.po_date) BETWEEN "'.$from_date.'" AND "'.$to_date.'" ']=NULL;
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
         
        if (userId('role_id') == SUPERADMIN_ROLE) {
            if ($data['is_delete_id'] == "1") {

                $where['p.deleted_by'] = $data['is_delete_id'];
            } elseif ($data['is_delete_id'] == "0") {

                $where['p.deleted_by'] = NULL;
            }
        } else {

            $where['p.deleted_by'] = NULL;
        }
        
        $count = count($this->GRNModel->getGRNData($searchVal,0,0,0,0,0,$where,$item_id));
        // echo $this->db->last_query();
        if($count){
            $result = $this->GRNModel->getGRNData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$item_id);
            // echo $this->db->last_query();die;
                foreach ($result as $key => $value) {
                    $flag=$own_flag_access=0;
                    $row = []; 
                  
                   if(!empty($value['po_id'])){
                        $po_data = $this->CommonModel->getData('tbl_po', array('id' => $value['po_id']), 'po_grn_status', '', 'row_array');
                        if(!empty($po_data['po_grn_status']) && isset($po_data['po_grn_status']) && $po_data['po_grn_status']==2){
                            $flag=1;
                        }
                        $own_flag_access=0;
                         $lbl='<span class="label label-light-warning">PO AGAINST</span>';
                    }else{
                        $lbl='<span class="label label-light-warning">DIRECT</span>';
                    }
                    $html1='<img src="'.base_url().'assets/images/plus.png" alt="Image 1" width="20px" data-id="'.$value['grn_id'].'" title="View Items">';
                    array_push($row, $offset + ($key + 1)." ".$lbl." ".$html1);
                    array_push($row, '<a href="'.base_url().'admin/store/GoodsReceiptNote/view_grn_item/'.$value['grn_id'] .'" title="view" class="" data-toggle="tooltip">'.$value['grn_no'].'</a>');
                    array_push($row, dmyDate($value['grn_date']));
                    array_push($row, $value['vendor_name']);
                    array_push($row, $value['location_site_name']);         
                    array_push($row,$value['item_total_qty']);
                    $issu_count = $this->GRNModel->checkMaterialIssueOrNot(array('pi.grn_id' => $value['grn_id']));
                    if($issu_count){
                        array_push($row,'<span class="label label-light-success">Yes</span>');
                    }else{
                        array_push($row,'<span class="label label-light-danger">No</span>');
                    }
                    
                   
                    $action='';
                   
                    if($value['grn_created_by']==userId()){
                        $own_flag_access=1;
                    }
                    if (userId('role_id') == SUPERADMIN_ROLE) {
                        if(!is_null($value['deleted_by'])){
                             array_push($row, "Reasons".$value['deleted_reason'] ."<br>&nbsp;&nbsp;&nbsp;Deleted By".$value['deleted_by_fname']." ".$value['deleted_by_lname']."<br>Deleted At ".$value['deleted_at']);
                        }else{
                            array_push($row,'');
                        }
                       
                    }else{
                         array_push($row,'');
                    }
                     
                  
                    if((getUserAccessForModule('Store','edit')) || ($own_flag_access) || userId('role_id')==SUPERADMIN_ROLE ):
                            if($flag==0){
                                $action .='<a href="' . base_url() . 'admin/store/GoodsReceiptNote/add_Goods_Receipt_Note/1/'.$value['grn_id'] . '" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';  
                            }
                    endif; 
                    
                    $confirm = "confirm('Are you sure you want to delete this GRN . Its effect on item Inventory ?')";
                    if(getUserAccessForModule('Store','delete') || ($own_flag_access) || userId('role_id')==SUPERADMIN_ROLE):
                        // $action .= ' <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/store/GoodsReceiptNote/grnDelete/' . $value['grn_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                         $action .= '<a href="javascript:void(0)" data-toggle="modal" data-target="" title="delete" class="btn btn-primary waves-effect waves-light btn-sm deleteBtn"  onclick="deleteBtn('.$value['id'] .')"  data-toggle="tooltip" style="font-size:13px;color: gray !important;"><i class="fas fa-trash" aria-hidden="true"></i></a>';

                    endif;
                    $action .= '<a href="'.base_url().'admin/store/GoodsReceiptNote/view_grn_item/'.$value['id'] .'" title="print Grn" class="btn btn-primary waves-effect waves-light btn-sm"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-eye" aria-hidden="true"></i></a>';        
                   $action .= '<a href="'.base_url().'admin/store/GoodsReceiptNote/generate_pdf/'.$value['id'] .'" title="print Grn" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-print" aria-hidden="true"></i></a>';     
                    // if($value['is_material_issue'] == NULL){
                     $action .= '<a href="'.base_url().'admin/store/MaterialIssue/issueFromGRN/'.$value['id'] .'" title="Direct GRN Material Issues " class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px; margin-right: 5px;color: gray !important;"><i class="fas fa-plus" aria-hidden="true"></i></a>';
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

    public function grnDelete(){
       $flag=0;
       // $po_item_id=$post['po_item_id'];
        $post = $this->input->post();
        $grn_id=$post['grn_id'];
        if($grn_id ){
        
        $grn_data = $this->CommonModel->getData('tbl_grn', array('id' => $grn_id), '', '', 'row_array');
        $grn_item_data=$this->CommonModel->getData('tbl_grn_items_details', array('grn_id' => $grn_id,'deleted_by'=>NULL), '', '', '');
        
        // echo "<pre>";
        // print_r($grn_data);
        // print_r($grn_item_data);die;
        if(!empty($grn_data) && !empty($grn_item_data)){
             foreach($grn_item_data as $key=>$item){
                $getItemQty=getQuickInventoryAmount($item['item_id'],$item['item_unit_id'],$grn_data['company_id'],$grn_data['site_id'],$grn_data['financial_year_id'],$item['batch_no'],$item['expired_date'],0);
                if($item['received_qty'] > $getItemQty){
                    $flag=1;
                }
             }
             if(isset($grn_data['po_id'])&& !empty($grn_data['po_id'])){
                 $flag=1;
             }
          
             if($flag==1){
                   $response['result']=false;
                   $response['reasons']="You can not delete GRN . becuse some item issued ";
                      $this->session->set_flashdata('error','You can not delete GRN . becuse some item issued');
             }else{
                 //delete GRN and GRN ITEM
                 
                $this->CommonModel->iudAction('tbl_grn',array('deleted_reason'=>$post['reason'],'deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$grn_id));
                // $this->CommonModel->iudAction('tbl_grn_attachment',array('deleted_at'=> date('Y-m-d H:i:s'),'deleted_by'=>userId()),'update',array('grn_id'=>$grn_id));
  
                foreach($grn_item_data as $key=>$item){
                    $this->CommonModel->iudAction('tbl_grn_items_details',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$item['id']));   
                     //delete from inventory
                    updateQuickInventory($item['item_id'],$item['item_unit_id'],$item['received_qty'],$grn_data['company_id'],$grn_data['site_id'],$grn_data['financial_year_id'],INVENTORY_ACTION_ISSUE_MINUS,GRN_TYPE,$grn_id,userId(),$item['batch_no'],$item['expired_date'],0,$item['id']);
                    
                   // echo $this->db->last_query();die;
                }
                 
                $description="GRN deleted -".$grn_data['grn_no']." by ".userId('name');
                $json_data_login=encode_arr($grn_data);
                //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');
        
                ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor 5:Store
                 //sub_ref_type:1 tbl_user
                $data_action_log_array=array(userId(),userId('role_id'),userId('common_financial_year'),userId('company_id'),userId('site_id'),'update',$description,5,$grn_id,'','',date('Y-m-d H:i:s'),$json_data_login);;
                updateInActionLogFile($data_action_log_array);
             }
             //  $this->session->set_flashdata('success','PO Items Deleted');
               $response['result']=true;
               $response['reasons']="PO Items Deleted";
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
    public function view_grn($id=''){
        $viewGRNpdf = $this->GRNModel->getGRNviewpdfData($id);
        $data=  $viewGRNpdf[0];
        
        $data['grn_item_details_data'] = $this->GRNModel->getGrnItemDetailsData($id);
        $data['company_name'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['company_id']),'','','row_array');
        
        // echo "<pre>";
        // print_r($data);
        $this->load->view(ADMIN.'store/goods_receipt_note/view_grn_pdf',$data); 
       
         }
    public function view_grn_item($id=''){
			$grn_data = $this->GRNModel->getGRNviewpdfData($id);
			$data=  $grn_data[0];
			$data['grn_item_details_data'] = $this->GRNModel->getGrnItemDetailsData($id);
			$data['grn_tax_details_data'] = $this->GRNModel->getGrnTaxDetailsData($id);
			
			$data['company_name'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['company_id']),'','','row_array');
			$data['attachment_file'] = $this->CommonModel->getData('tbl_grn_attachment',array('grn_id'=>$id));
// 			echo "<pre>"; print_r($data);die;   
			
			
			// site_id   
			
			$this->load->view(ADMIN.'store/goods_receipt_note/view_grn_item',$data); 
		   
		}
	public function poInnearItemTableData(){
	     if (isset($_GET['id'])) {
            $po_id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['po_info_items']= $this->POModel->getPOItemDataALL(array($po_id));;
            
            // echo "<pre>";
            // print_r($data['po_info_items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/goods_receipt_note/inner_items_table', $data,true);
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
	public function grnInnearItemTableData(){
	     if (isset($_GET['id'])) {
            $po_id = $_GET['id'];
        
            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['items']= $this->GRNModel->getGRNItemDataALL(array('p.id'=>$po_id));;
            // echo "<pre>";
            // print_r($data['po_info_items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN.'store/goods_receipt_note/grn_inner_items_table', $data,true);
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
 public function generate_pdf($id='') {
     	        $this->load->library('pdf');
    $post = $this->input->post();
    $where = array();
    $viewGRNpdf = $this->GRNModel->getGRNviewpdfData($id);
    $data =  $viewGRNpdf[0];
        
    $data['grn_item_details_data'] = $this->GRNModel->getGrnItemDetailsData($id);
    $data['company_name'] = $this->CommonModel->getData('tbl_company_master', array('id' => $data['company_id']), '', '', 'row_array');
    $data['received'] = $this->CommonModel->getData('users', array('id' => $data['received_by']), 'first_name,last_name', '', 'row_array');
    $data['checked'] = $this->CommonModel->getData('users', array('id' => $data['checked_by']), 'first_name,last_name', '', 'row_array');
    $data['created'] = $this->CommonModel->getData('users', array('id' => $data['created_by']), 'first_name,last_name', '', 'row_array');
        // echo '<pre>';print_r($data);die; 
    $htmlContent = $this->load->view(ADMIN.'store/goods_receipt_note/grnprint_report', $data, true);

    // Add your PDF generation logic
    $this->pdf->setPageOrientation('L'); // Set landscape orientation
    $this->pdf->AddPage();
    $this->pdf->SetMargins(5, 5, 5);
    $this->pdf->SetFont('helvetica', '', 12);
    $this->pdf->writeHTML($htmlContent, true, false, true, false, '');
    $this->pdf->Output('grn_report.pdf', 'I'); // 'I' for inline display
}

	
}

?>
