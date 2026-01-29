<?php  init_header(); ?>
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<!-- Page wrapper  -->
<style>
   .select2-container{
   width:80%;
   }
   button:focus,
   input:focus{
   outline: none;
   box-shadow: none;
   }
   a,
   a:hover{
   text-decoration: none;
   }
   .file-drop-zone-title {
   padding: 15px 10px !important;
   }
   .file-preview-image{
   width: auto !important;
   height: 40px !important;
   }
   .file-no-browse,.fileinput-cancel-button{
   display: none;
   }
   .kv-file-content{
   display: none !important;
   }
</style>
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
   <div class="row">
      <div class="col-lg-12">
         <div class="card ">
            <!--  <div class="card-header bg-info">
               <h4 class="m-b-0 text-white">Purchase Order </h4>
               </div> -->
            <div class="card-body">
               <form class="repeater form-upload" method="post"  autocomplete="off" id="form_grn" enctype="multipart/form-data" action="<?= base_url('admin/store/GoodsReceiptNote/saveGrn'); ?>">
                  <div class="form-body">
                     <div class="row ">
                        <div class="col-md-6">
                           <h3 class="box-title">Goods Receipt Note</h3>
                           <?php
                              $grn_date=date('d/m/Y');
                              $grn_time=date('H:m');
                              // echo  $grn_info['grn_date'];die;
                           // print_r($grn_info);die;
                              //type 1: direct GRN 2: GRn ahinst PO
                                    if($type==2 || $type==3){
                                       $po_id=$po_info['id'];
                                       $vendorId=$po_info['vendor_id'];
                                    }else if($type==1 && isset($grn_info) && !empty($grn_info)){
                                        //update
                                       $po_id=$grn_info['po_id'];
                                       $vendorId=$grn_info['vendor_id'];
                                       $id=$grn_info['id'];
                                       $grn_number=$grn_info['grn_no'];
                                       $grn_order_sequence=$grn_info['grn_order_sequence'];
                                       $grn_date=date('d/m/Y',strtotime($grn_info['grn_date']));
                                       $grn_time=date('H:m',strtotime($grn_info['grn_time']));
                                       
                                       
                                    }else{
                                       
                                         $grn_date=date('d/m/Y');
                                         $grn_time=date('H:m');
                                        
                                    }
                                    
                                    // echo $grn_number;die;
                              ?>
                           <input type="hidden" name="po_id" id="po_id" value="<?= isset($po_id)?$po_id:"" ?>">
                           <input type="hidden" name="vendorId" id="vendorId" value="<?= isset($vendorId)?$vendorId:"" ?>">
                           <input type="hidden" id="receiveLocationSiteId"  value="<?= (isset($grn_info['receive_location_site_id']))?$grn_info['receive_location_site_id']:''; ?>">
                           <input type="hidden" id="receivedBy"  value="<?= (isset($grn_info['received_by']))?$grn_info['received_by']:''; ?>">
                           <input type="hidden" id="checkedBy"  value="<?= (isset($grn_info['checked_by']))?$grn_info['checked_by']:''; ?>">
                           <input type="hidden" id="transportId"  value="<?= (isset($grn_info['transport_id']))?$grn_info['transport_id']:''; ?>">
                           <input type="hidden" id="partyVendorId"  value="<?= (isset($grn_info['is_party_vendor_id']))?$grn_info['is_party_vendor_id']:''; ?>">
                           <input type="hidden" id="loadedVendorId"  value="<?= (isset($grn_info['loaded_vendor_id']))?$grn_info['loaded_vendor_id']:''; ?>">
                           <input type="hidden" name="id" id="id" value="<?= isset($id)?$id:"" ?>">
                           <input type="hidden" name="type" id="type" value="<?= $type; ?>">
                           <input type="hidden" name="is_grn_update" id="is_grn_update" value="<?= (isset($is_grn_update)?$is_grn_update:0); ?>">
                            <input type="hidden" name="grn_order_sequence" id="grn_order_sequence" value="<?= $grn_order_sequence; ?>">
                           
                           <input type="hidden" name="direct_grn_credit_amount" id="direct_grn_credit_amount" value="<?= getValue('direct_grn_credit_amount'); ?>">
                        </div>
                     </div>
                     <hr class="m-t-0 m-b-10">
                     <div class="row ">
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">GRN No.</label>
                              <div class="col-md-8">
                                 <input type="text" class="form-control" value="<?= $grn_number ?>" name="grn_no" id="grn_no" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Date-Time</label>
                              <div class="col-md-8">
                                 <div class="input-group" style="width:60%">
                                     <?php
                                        if(isset($id)){
                                            $class_name="mydatepicker";
                                        }else{
                                            $class_name="precurdatepicker";
                                        }
                                     ?>
                                    <input type="text" class="form-control <?= $class_name; ?>" placeholder="mm/dd/yyyy" name="grn_date" id="grn_date" value="<?= isset($grn_date)?$grn_date:"" ?>" required>
                                    <div class="input-group-append">
                                       <span class="input-group-text"><i class="ti-calendar"></i></span>
                                    </div>
                                 </div>
                                 <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true" style="width:60%">
                                    <input type="time" class="form-control" value="<?= isset($grn_time)?$grn_time:"" ?>" name="time">
                                    <div class="input-group-append">
                                       <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Manual Slip No.</label>
                              <div class="col-md-8">
                                 <input type="text" class="form-control" value="<?= (isset($grn_info['manual_slip_no']))?$grn_info['manual_slip_no']:''; ?>" name="manual_slip_no" id="manual_slip_no">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Unload Date</label>
                              <div class="col-md-8">
                                 <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="unload_date" id="unload_date" value="<?= (isset($grn_info['unload_date']))?date('d/m/Y',strtotime($grn_info['unload_date'])):date('d/m/Y'); ?>">
                                    <div class="input-group-append">
                                       <span class="input-group-text"><i class="ti-calendar"></i></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Recd.From</label>
                              <div class="col-md-8">
                                 <div class="form-group row">
                                    <?php
                                       $received_from=1;
                                       if($type==2){
                                           $received_from=1;
                                       }else if($type==1 && isset($grn_info['received_from'])){
                                           $received_from=$grn_info['received_from'];
                                       }
                                       ?>
                                    <div class="col-md-6">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio1" name="received_from" class="custom-control-input" value="1" <?= ($received_from==1)?"checked":"" ?>>
                                          <label class="custom-control-label" for="customRadio1">Self(Vendor)</label>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio2" name="received_from" class="custom-control-input" value="2" <?= ($received_from==2)?"checked":"" ?>>
                                          <label class="custom-control-label" for="customRadio2">Party(Customer)</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Receive Location</label>
                              <div class="col-md-8">
                                 <select class="form-control custom-select select2" id="receive_location_site_id"  name="receive_location_site_id" style="width:100%" required >
                                    <option></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Way Bill Form</label>
                              <div class="col-md-8">
                                 <select class="form-control custom-select select2" id="way_bill_form"  name="way_bill_form" style="width:100%" >
                                    <option></option>
                                 </select>
                              </div>
                           </div>
                           </div> -->
                        <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Received By</label>
                              <div class="col-md-8">
                                 <select class="form-control custom-select select2 " id="received_by"  name="received_by" style="width:100%" >
                                    <option></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                         <div class="col-md-3">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-4">Checked By</label>
                              <div class="col-md-8">
                                 <select class="form-control custom-select select2 " id="checked_by"  name="checked_by" style="width:100%" >
                                    <option></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group  row">
                              <label class="control-label text-right col-md-4">Vendor / Customer</label>
                              <div class="col-md-8">
                                 <select class="form-control custom-select select2 get_vendor" required id="vendor_id"  name="vendor_id" style="width:100%" >
                                    <option></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-3"></label>
                              <div class="col-md-9">
                                 <div class="form-group row">
                                    <div class="col-md-6" style="padding-right: 2px;">
                                       <div class="form-check custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input form-check-input" id="is_cash_payment" name="is_cash_payment" value="1" <?= (isset($grn_info['is_cash_payment'])&&($grn_info['is_cash_payment']==1))?'checked':''; ?>>
                                          <label class="custom-control-label form-check-label" for="is_cash_payment">Cash Payment</label>
                                       </div>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 2px;">
                                       <div class="form-check custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input form-check-input" id="is_party_vendor" name="is_party_vendor" value="1" <?= (isset($grn_info['is_party_vendor'])&&($grn_info['is_party_vendor']==1))?'checked':''; ?>>
                                          <label class="custom-control-label form-check-label" for="is_party_vendor">At Party (vendor)</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-2">
                           <select class="form-control custom-select select2 get_vendor" id="is_party_vendor_id"  name="is_party_vendor_id" style="width:100%" >
                              <option></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-3"></label>
                           <div class="col-md-9">
                              <div class="form-group row">
                                 <div class="col-md-6" style="padding-right: 2px;">
                                    <div class="form-check custom-control custom-checkbox" >
                                       <input type="checkbox" class="custom-control-input form-check-input" id="is_aginst_c_form" name="is_aginst_c_form" value="1"  <?= (isset($grn_info['is_aginst_c_form'])&&($grn_info['is_aginst_c_form']==1))?'checked':''; ?>>
                                       <label class="custom-control-label form-check-label" for="is_aginst_c_form">Against C Form</label>
                                    </div>
                                 </div>
                                 <div class="col-md-6" style="padding-right: 2px;">
                                    <div class="form-check custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input form-check-input" id="is_reverse_charge" name="is_reverse_charge" value="1"  <?= (isset($grn_info['is_reverse_charge'])&&($grn_info['is_reverse_charge']==1))?'checked':''; ?>>
                                       <label class="custom-control-label form-check-label" for="is_reverse_charge">Reverse Charge</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Party Bill Amount</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" value="<?= (isset($grn_info['party_bill_amount']))?$grn_info['party_bill_amount']:'0'; ?>" name="party_bill_amount" id="party_bill_amount">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Party Bill No.</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" value="<?= (isset($grn_info['party_bill_no']))?$grn_info['party_bill_no']:'0'; ?>" name="party_bill_no" id="party_bill_no">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Bill Date.</label>
                           <div class="input-group  col-md-8">
                              <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="bill_date" id="bill_date" value="<?= (isset($grn_info['bill_date']))?date('d/m/Y',strtotime($grn_info['bill_date'])):date('d/m/Y'); ?>">
                              <div class="input-group-append">
                                 <span class="input-group-text"><i class="ti-calendar"></i></span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Transport</label>
                           <div class="col-md-8">
                              <select class="form-control custom-select select2 get_vendor" id="transport_id"  name="transport_id" style="width:100%" >
                                 <option></option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Or</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" value="<?= (isset($grn_info['transport_name']))?$grn_info['transport_name']:'0'; ?>" name="transport_name" id="transport_name">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Driver Name</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" value="<?= (isset($grn_info['driver_name']))?$grn_info['driver_name']:'0'; ?>" name="driver_name" id="driver_name">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Loaded View</label>
                           <div class="col-md-8">
                              <div class="form-group row">
                                 <div class="col-md-3">
                                    <div class="custom-control custom-radio">
                                       <input type="radio" id="loaded_via-2" name="loaded_via" class="custom-control-input" value="1"   <?= (isset($grn_info['loaded_via'])&&($grn_info['loaded_via']==1))?'checked':''; ?>>
                                       <label class="custom-control-label" for="loaded_via-2">Self</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="custom-control custom-radio">
                                       <input type="radio" id="loaded_via-1" name="loaded_via" class="custom-control-input" value="2"  <?= (isset($grn_info['loaded_via'])&&($grn_info['loaded_via']==2))?'checked':''; ?> >
                                       <label class="custom-control-label" for="loaded_via-1">Party</label>
                                    </div>
                                 </div>
                                 <div class="col-md-9 load_party_vendor_div" style="<?= (isset($grn_info['loaded_via'])&&($grn_info['loaded_via']==2))?'display: block':''; ?>" >
                                    <select class="form-control custom-select select2 get_vendor" id="load_party_id"  name="load_party_id" style="width:100%;">
                                       <option></option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Lr.No.</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" value="<?= (isset($grn_info['lr_no']))?$grn_info['lr_no']:'0'; ?>" name="lr_no" id="lr_no">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Lr Date</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="lr_date" id="lr_date" value="<?= (isset($grn_info['lr_date']))?date('d/m/Y',strtotime($grn_info['lr_date'])):date('d/m/Y'); ?>">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Challan No.</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" value="<?= (isset($grn_info['challan_no']))?$grn_info['challan_no']:''; ?>" name="challan_no" id="challan_no">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Challan Date</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="challan_date" id="challan_date" value="<?= (isset($grn_info['challan_date']))?date('d/m/Y',strtotime($grn_info['challan_date'])):date('d/m/Y'); ?>">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Carring Vehicle No.</label>
                           <div class="col-md-8" >
                              <div class="input-group">
                                 <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" value="<?= (isset($grn_info['vehicle_no']))?$grn_info['vehicle_no']:''; ?>">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Reading</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control" name="vehicle_reading" id="vehicle_reading" value="<?= (isset($grn_info['vehicle_reading']))?$grn_info['vehicle_reading']:''; ?>">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">RST No.</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control" name="rst_no" id="rst_no" value="<?= (isset($grn_info['rst_no']))?$grn_info['rst_no']:''; ?>">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Gate Pass No.</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control" name="gate_pass_no" id="gate_pass_no" value="<?= (isset($grn_info['gate_pass_no']))?$grn_info['gate_pass_no']:''; ?>">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Custom Inward No.</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control" name="custom_inward_no" id="custom_inward_no" value="<?= (isset($grn_info['custom_inward_no']))?$grn_info['custom_inward_no']:''; ?>">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Custom Inward Date</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="custom_inward_date" id="custom_inward_date" value="<?= (isset($grn_info['custom_inward_date']))?date('d/m/Y',strtotime($grn_info['custom_inward_date'])):date('d/m/Y'); ?>">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Lab Report No.</label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control" name="lab_report_no" id="lab_report_no" value="<?= (isset($grn_info['lab_report_no']))?$grn_info['lab_report_no']:''; ?>">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row m-t-10">
                     <div class="col-md-6">
                        <h3 class="box-title">Received Items Group/Item</h3>
                     </div>
                     <div class="col-md-6" align="right" id="reapter_add_div">
                        <?php
                          
                          //  if(($type!=2 && $type!=3)){
                             ?>
                        <a href="javascript:void(0)" data-repeater-create id="grn_po_item_add" ><button type="button" class="btn btn-success btn-theme">Add</button></a>
                        <?php
                         //  }
                           ?>
                     </div>
                  </div>
                  <hr class="m-t-0 m-b-10">
                  <div class="table-responsive" data-repeater-list="items" id="add_goods_receipt_note">
                     <?php
                        if(isset($po_info_items)&& !empty($po_info_items)):
                        // echo "<pre>";
                        // print_r($po_info_items);
                        ?>
                     <?php
                        foreach ($po_info_items as $key1 => $po_items) {
                          
                        ?>
                     <table class="table table-bordered main_tbl_reapter" data-repeater-item id="grn_items_tables">
                        <thead style="background-color:#e5e5e5;"  name="tbl_po_item_thead">
                           <tr name="tr_head">
                              <th width="15%">
                                 Received Items Group/Item *
                              </th>
                              <th width="7%">Ordered Item/ Why Change Reason</th>
                              <th width="12%">Po Pending Qty</th>
                              <th width="5%">Recv. Qty *</th>
                              <th width="5%">Return Qty</th>
                              <th width="5%">Rate / Amount</th>
                              <th width="5%">Other Charges Disc. Item Wise Amount </th>
                              <th width="10%">GST/VAT Rate % / Amt</th>
                              <th width="10%">Amount</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr >
                              <td>
                                 
                                
                                 <?php
                                    if($type!=1){
                                        // echo "<pre>";
                                        // print_r($po_items);
                                    ?>
                                 <input type="hidden" name="po_item_id" value="<?= $po_items['id']; ?>">
                                 <input type="hidden" name="grn_item_id" value="0">
                                 <input type="hidden" name="po_save_pending_qty" value="<?= isset($po_items['pending_qty'])?$po_items['pending_qty']:0; ?>">
                                  <!--<input type="hidden" class="po_items_select" name="items_id" value="<?= $po_items['item_id']; ?>">-->
                                  <!--<input type="hidden" name="item_group_id" value="<?= $po_items['item_group_id']; ?>">-->
                                   <div class="form-group ">
                                    <input type="hidden" name="type" value="2">
                                    <label class="control-label text-left col-md-12">Item Group  </label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)" disabled>
                                          <?php
                                             if(isset($po_items['item_group_id']) && $po_items['item_group_id']==0){
                                         ?>
                                             <option value="all" selected>all</option>
                                         <?php
                                            }
                                             foreach($item_group as $key_i=>$value_item){
                                                if (isset($value_item['parent_group_name'])) {
                                                        $text = $value_item['item_group_name'] . " (" . $value_item['parent_group_name'] . ")";
                                                } else {
                                                        $text =$value_item['item_group_name'];
                                                }
                                                 $selected='';
                                                if($po_items['item_group_id']==$value_item['id']){
                                                   $selected="selected";
                                             
                                                }
                                             ?>
                                          <option value="<?= $value_item['id']; ?>" <?= $selected; ?>><?= $text ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Items <?= $po_items['item_id']; ?></label>
                                    <div class="col-md-12">
                                        <?php 
                                               $group_id=$po_items['item_group_id'];
                                               // echo $group_id;
                                                if($group_id==0){
                                                    $filteredItems=array();
                                                    $filteredItems=$item_list;
                                                    
                                                }else{
                                                    $filteredItems=array();
                                                     $filteredItems = array_values(array_filter($item_list, function($item) use ($group_id) {
                                                        return $item['item_group'] == $group_id;
                                                    }));
                                                }
                                               // echo "<pre>";
                                               // print_r($group_id);

                                        ?>
                                       <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)" disabled>
                                          <?php
                                             foreach($filteredItems as $key_i1=>$value_item1){
                                                
                                                 $selected='';
                                                if($po_items['item_id']==$value_item1['id']){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item1['id']; ?>" <?= $selected; ?>><?= $value_item1['item_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    
                                 </div>
                                 <?php
                                    }else if($type==1 && isset($grn_info)){
                                    ?>
                                 <input type="hidden" name="po_item_id" value="">
                                 <input type="hidden" name="grn_item_id" value="<?= $po_items['id']; ?>">
                                 <input type="hidden" name="po_save_pending_qty" value="<?= isset($po_items['po_total_pending_qty'])?$po_items['po_total_pending_qty']:0; ?>">
                                  <input type="hidden" name="po_main_total_qty" value="<?= isset($po_items['total_po_qty'])?$po_items['total_po_qty']:0; ?>">
                                   <input type="hidden" name="po_main_received_qty" value="<?= isset($po_items['po_received_qty'])?$po_items['po_received_qty']:0; ?>">
                                 <input type="hidden" name="po_main_pending_qty" value="<?= isset($po_items['pending_qty'])?$po_items['pending_qty']:0; ?>">
                                 <?php
                         
                                    }else{
                                    ?>
                                 <input type="hidden" name="po_item_id" value="">
                                 <input type="hidden" name="grn_item_id" value="">
                                 <input type="hidden" name="po_save_pending_qty" value="0">
                                  <input type="hidden" class="po_items_select" name="items_id" value="<?= $po_items['item_id']; ?>">
                                  <input type="hidden" name="item_group_id" value="<?= $po_items['item_group_id']; ?>">
                                 <?php
                                    }
                                    ?>
                                 <input type="hidden" name="po_id" value="<?= $po_items['po_id']; ?>">
                            
                                 <?php
                                //  echo $is_grn_update;die;
                                    if(isset($is_grn_update) && $is_grn_update==0 && isset($po_items['po_order_no'])){
                                ?>
                                     <div class="form-group " id="po_item_update_div" name="po_item_update_div">
                                    <p><label class="control-label text-left col-md-12">Items Name: <b><?= $po_items['item_name']; ?></b></label></p>
                                    <p><label class="control-label text-left col-md-12">HSC CODE: <b><?= $po_items['hsn_code']; ?></b></label></p>
                                    <?php
                                       if($type!=1){
                                       ?>
                                    <p><label class="control-label text-left col-md-12">PO Order NO: <b><?= $po_items['po_order_no']; ?></b></label></p>
                                    <?php
                                       }
                                       ?>
                                    <p><label class="control-label text-left col-md-12">Technical Description </label><?= $po_items['technical_description']; ?></p>
                                 </div>
                                
                                <?php
                                    }else{
                                ?>
                                 <div class="form-group ">
                                            <?php
                                                if(!empty($po_items['po_order_no'])){
                                            ?>
                                             <p><label class="control-label text-left col-md-12">PO Order NO: <b><?= $po_items['po_order_no']; ?></b></label></p>
                                            <?php
                                                }
                                            ?>
                                         
                                     
                                        <label class="control-label text-left col-md-12">Item Group  </label>
                                        <div class="col-md-12">
                                           <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)" <?= (isset($is_grn_update) && $is_grn_update==1)?'disabled':'' ?>>
                                          <?php
                                                     if(isset($po_items['item_group_id']) && $po_items['item_group_id']==0){
                                                      echo    ' <option value="all" selected>all</option>';
                                                     }
                                            ?>
                                          <?php
                                             foreach($item_group as $key_i=>$value_item){
                                                if (isset($value_item['parent_group_name'])) {
                                                        $text = $value_item['item_group_name'] . " (" . $value_item['parent_group_name'] . ")";
                                                } else {
                                                        $text =$value_item['item_group_name'];
                                                }
                                                 $selected='';
                                                if($po_items['item_group_id']==$value_item['id']){
                                                   $selected="selected";
                                             
                                                }
                                             ?>
                                          <option value="<?= $value_item['id']; ?>" <?= $selected; ?>><?= $text ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                        </div>
                                     </div>
                                     <div class="form-group ">
                                        <label class="control-label text-left col-md-12">Items</label>
                                        <div class="col-md-12">
                                           <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)" <?= (isset($is_grn_update)&& $is_grn_update==1)?'disabled':'' ?>>
                                          <?php
                                             foreach($po_items['item_list'] as $key_i1=>$value_item1){
                                                
                                                 $selected='';
                                                if($po_items['item_id']==$value_item1['id']){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item1['id']; ?>" <?= $selected; ?>><?= $value_item1['item_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                        </div>
                                     </div>
                                       <div class="col-md-12 refesh_block" name="refesh_block"      <?= (isset($is_grn_update)&& $is_grn_update==1)?'style="display: none;"':''  ?>>
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                                     <div class="form-group m-t-40">
                                        <label class="control-label text-left col-md-12">HSC Code</label>
                                        <div class="col-md-10">
                                           <input type="text" class="form-control" name="item_hsc_code" readonly>
                                        </div>
                                     </div>
                                <?php
                                    }
                                 ?>
                                    
                                 
                                 
                                 
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Batch Number</label>
                                    <div class="col-md-6">
                                       <input type="text" class="form-control" name="batch_no" value="<?= isset($po_items['batch_no'])?$po_items['batch_no']:""; ?>" required <?= (isset($is_grn_update)&& $is_grn_update==1)?'readonly':""; ?>>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label text-left col-md-12">Expired Date</label>
                                    <div class="col-md-6">
                                       <input type="date" class="form-control " name="expired_date" required value="<?= isset($po_items['expired_date'])?$po_items['expired_date']:""; ?>" <?= (isset($is_grn_update)&& $is_grn_update==1)?'readonly':""; ?>>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-40">
                                    <label class="control-label">Order Item</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <input type="text" class="form-control" name="order_item"  value="<?= isset($po_items['order_item'])?$po_items['order_item']:""; ?>">
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label">Reason</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="reason" value="<?= isset($po_items['reason'])?$po_items['reason']:""; ?>"></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <table class="m-t-30 m-b-30">
                                    <tbody>
                                       <tr>
                                          <div class="form-group">
                                       <tr>
                                       <td>Total<br>Pending<br>Quantity</td>
                                       <?php
                                          $pending_qty=0;
                                          if($type==1 && isset($po_items['po_total_pending_qty'])){
                                              $pending_qty=$po_items['po_total_pending_qty'];
                                          }else if($type==3 || $type==2){
                                               $pending_qty=$po_items['pending_qty'];
                                          }
                                          
                                          $received_qty=0;
                                          if($type==1 && isset($po_items['received_qty'])){
                                              $received_qty=$po_items['received_qty'];
                                          }else if($type==3){
                                               $received_qty=$po_items['received_qty'];
                                          }else{
                                              $received_qty=0;
                                          }
                                          
                                          ?>
                                       <td style="width:45%"><input  class="form-control" placeholder="0" type="text" name="po_total_pending_qty" <?= ($type==1)?"readonly":""; ?> value="<?= isset($pending_qty)?$pending_qty:0; ?>" readonly></td>
                                       <td style="width:45%">
                                       <select class="form-control item_unit_select"  name="po_total_pending_qty_unit">
                                       <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                             if(isset($po_items['item_unit_id']) && $po_items['item_unit_id']==$value_item2['id'] || (isset($po_items['po_total_pending_qty_unit']) && $type==1 && $po_items['po_total_pending_qty_unit']==$value_item2['id'])){
                                                $selected="selected";
                                             }
                                          ?>
                                       <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                       <?php
                                          }
                                          ?>
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Excess<br>Quantity</td>
                                       <td style="width:45%"><input  name="po_excess_qty" class="form-control" placeholder="0" type="text" <?= ($type==1)?"readonly":""; ?> value="<?= isset($po_items['po_excess_quantity'])?$po_items['po_excess_quantity']:"0"; ?>" readonly></td>
                                       <td style="width:45%"></td>
                                       </tr>
                                       <tr>
                                       <td>Challan<br>Quantity</td>
                                       <td style="width:45%"><input  name="po_challan_qty" class="form-control" placeholder="0" type="text" value="<?= isset($po_items['po_challan_quantity'])?$po_items['po_challan_quantity']:"0"; ?>"></td>
                                       <td style="width:45%">
                                       <select class="form-control item_unit_select"  name="po_challan_qty_unit">
                                       <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                             if(isset($po_items['item_unit_id']) && $po_items['item_unit_id']==$value_item2['id'] || (isset($po_items['po_challan_qty_unit']) && $type==1 && $po_items['po_challan_qty_unit']==$value_item2['id'])){
                                                $selected="selected";
                                             }
                                          ?>
                                       <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                       <?php
                                          }
                                          ?>
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Received<br>Quantity</td>
                                       <td style="width:45%"><input type="hidden" name="old_received_qty" id="old_received_qty" value="<?= isset($received_qty)?$received_qty:"0"; ?>"><input  class="form-control" placeholder="0" type="text" required name="po_received_qty" value="<?= isset($received_qty)?$received_qty:"0"; ?>" onblur="calculatePOItem(this)" ></td>
                                       <td style="width:45%">
                                       <select class="form-control item_unit_select"  name="po_received_qty_unit">
                                       <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                              if(isset($po_items['item_unit_id']) && $po_items['item_unit_id']==$value_item2['id'] || (isset($po_items['po_received_qty_unit']) && $type==1 && $po_items['po_received_qty_unit']==$value_item2['id'])){
                                                $selected="selected";
                                             }
                                          ?>
                                       <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                       <?php
                                          }
                                          ?>
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Rejected<br>Quantity</td>
                                       <td style="width:45%">
                                       <input  class="form-control" placeholder="0" type="text" value="<?= isset($po_items['po_rejected_qty'])?$po_items['po_rejected_qty']:"0"; ?>" name="po_rejected_qty" onblur="showRejectReasons(this)" <?= ($type==1)?"readonly":""; ?>>
                                       </td>
                                       <td style="width:45%">
                                       <select class="form-control item_unit_select"  name="po_rejected_qty_unit">
                                       <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                              if(isset($po_items['item_unit_id']) && $po_items['item_unit_id']==$value_item2['id'] || (isset($po_items['po_rejected_qty_unit']) && $type==1 && $po_items['po_rejected_qty_unit']==$value_item2['id'])){
                                                $selected="selected";
                                             }
                                          ?>
                                       <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                       <?php
                                          }
                                          ?>
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Adjustment<br>Quantity</td>
                                       <td style="width:45%">
                                           <?php
                                                 if(isset($po_id) && $is_grn_update==1){
                                                     $readonly="";
                                                 }else if($type==2 || $type=3){
                                                      $readonly="";
                                                 }else{
                                                     $readonly='readonly';
                                                 }
                                                 
                                           ?>
                                       <input  class="form-control po_adjustment_qty" placeholder="0" type="text" value="<?= isset($po_items['po_adjustment_qty'])?$po_items['po_adjustment_qty']:"0"; ?>" name="po_adjustment_qty"   <?= $readonly; ?>>
                                       </td>
                                       <td style="width:45%">
                                       </td>
                                       </tr>
                                       </div>
                                       </tr>
                                       <tr>
                                          <td colspan="3">
                                             <select class="form-control" required name="reject_reasons" style="<?= ($type==1 && isset($po_items['po_rejected_quantity']) && ($po_items['po_rejected_quantity']==0))?'':'display:none;'; ?>">
                                                <option>Select Reasons</option>
                                                <?php 
                                                   // $defult_tax_rate=0;
                                                   foreach ($master_reject_list as $key11 => $value11) {
                                                       $selected='';
                                                       if($type==1 && isset($po_items['reject_reasons'])&& $po_items['reject_reasons']==$value11['particulars']){
                                                           $selected="selected";
                                                       }
                                                   ?>                                                              
                                                <option value="<?= $value11['particulars'] ?>" <?= $selected; ?>><?= $value11['particulars']; ?></option>
                                                <?php
                                                   }
                                                   ?>
                                             </select>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="received_qty" id="" value="<?= isset($received_qty)?$received_qty:"0"; ?>" readonly>
                                    <div class="col-md-10" style="padding:0px">
                                       <select class="form-control item_unit_select" required name="received_unit">
                                          <?php
                                             foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                                
                                                 $selected='';
                                                //  if(isset($po_items['item_unit_id']) && $po_items['item_unit_id']==$value_item2['id'] || (isset($po_items['po_total_pending_qty_unit']) && $type==1 && $po_items['po_total_pending_qty_unit']==$value_item2['id'])){
                                                 if(isset($po_items['item_unit_id']) && $po_items['item_unit_id']==$value_item2['id']){
                                                       $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <label>Weight</label>
                                    <input type="text" class="form-control" name="item_weight" id="" value="<?= isset($po_items['item_weight'])?$po_items['item_weight']:""; ?>" onblur="calculatePOItem(this)">
                                    <div class="col-md-10" style="padding:0px">
                                       <select class="form-control " required name="weight_unit">
                                          <?php
                                             foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                                
                                                 $selected='';
                                                if((isset($po_items['item_weight_unit'])&& $po_items['item_weight_unit']==$value_item2['id'])||(isset($po_items['item_weight_unit'])&& $po_items['item_weight_unit']==$value_item2['id'])){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <label>Length</label>
                                    <input type="text" class="form-control" name="length" id="" value="<?= isset($po_items['length'])?$po_items['length']:""; ?>" onblur="calculatePOItem(this)">
                                    <div class="col-md-10" style="padding:0px">
                                       <select class="form-control item_unit_select" required name="length_unit">
                                          <?php
                                             foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                                
                                                 $selected='';
                                                 if((isset($po_items['item_unit_id'])&& $po_items['item_unit_id']==$value_item2['id'])||(isset($po_items['item_length_unit_id'])&& $po_items['item_length_unit_id']==$value_item2['id'])){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group" style="margin-top: 75px;">
                                    <input type="text" class="form-control m-t-40" name="return_qty" id="" value="<?= isset($po_items['return_qty'])?$po_items['return_qty']:""; ?>" <?= ($type==1)?"readonly":""  ?>>
                                    <div class="col-md-10 " style="padding:0px">
                                       <select class="form-control item_unit_select" required name="return_qty_unit">
                                          <?php
                                             foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                                
                                                 $selected='';
                                                if($po_items['item_unit_id']==$value_item2['id']){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group" style="margin-top: 60px;">
                                    <span>@</span>
                                    <input type="text" class="form-control po_item_cal" name="item_unit_rate" id="" value="<?= isset($po_items['item_rate'])?$po_items['item_rate']:"0" ?>">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="item_unit_type" onchange="calculatePOItem(this)">
                                          <option value="1" <?= (isset($po_items['item_rate_type'])&&$po_items['item_rate_type']==1)?"selected":"" ?>>Stock Qty</option>
                                          <option value="2"<?= (isset($po_items['item_rate_type'])&&$po_items['item_rate_type']==2)?"selected":"" ?>>Weight</option>
                                       </select>
                                    </div>
                                    =
                                    <input type="text" class="form-control" name="item_total" id="" value="<?= isset($po_items['item_sub_amount'])?$po_items['item_sub_amount']:"0" ?>">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-20">
                                    <span>Other Charges</span>
                                    <input type="text" class="form-control" name="item_other_percent" id="" value="<?= isset($po_items['item_other_charges_percentage'])?$po_items['item_other_charges_percentage']:""; ?>" onblur="calculatePOItem(this)">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="other_charges_type" onchange="calculatePOItem(this)">
                                          <option value="1"  <?= (isset($po_items['item_other_charges_percentage'])&&$po_items['item_other_charges_percentage']==1)?"selected":"selected" ?>>@ val</option>
                                          <option value="2" <?= (isset($po_items['item_other_charges_percentage'])&&$po_items['item_other_charges_percentage']==1)?"selected":"" ?>>@ qty</option>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="item_other_charges_amt" id="" value="<?= isset($po_items['item_other_charges_value'])?$po_items['item_other_charges_value']:""; ?>" readonly>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <span>Discount</span>
                                    <input type="text" class="form-control" name="discount_percent" id="" value="<?= isset($po_items['order_item'])?$po_items['order_item']:""; ?>" onblur="calculatePOItem(this)">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="discount_type" onchange="calculatePOItem(this)">
                                          <option value="1" <?= (isset($po_items['item_discount_type'])&&$po_items['item_discount_type']==1)?"selected":"selected" ?>>@ val</option>
                                          <option value="2" <?= (isset($po_items['item_discount_type'])&&$po_items['item_discount_type']==2)?"selected":"" ?>>@ qty</option>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="discount_value" id="" value="<?= isset($po_items['item_discount_amount'])?$po_items['item_discount_amount']:""; ?>" readonly>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-10">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="tax_id" onchange="add_value(this);">
                                          <option>Select Gst</option>
                                          <?php 
                                             // $defult_tax_rate=0;
                                             foreach ($master_tax_list as $key => $value) {
                                                 $selected='';
                                                 if($key==0){
                                                     $defult_tax_rate=$value['tax_rate'];
                                                 }
                                                 if(isset($grn_info['tax_id'])&& $type==1 && $value['id']==$grn_info['tax_id']){
                                                     $selected="selected";
                                                 }
                                                 if(isset($po_items['tax_id']) && $value['id']==$po_items['tax_id']){
                                                      $selected="selected";
                                                 }
                                             ?>                                                              
                                          <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>"  <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" readonly name="tax_rate" id="" value="<?= isset($po_items['tax_rate'])?$po_items['tax_rate']:""; ?>" readonly>
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="gst_type" onchange="calculatePOItem(this)">
                                          <option value="1" selected>value</option>
                                          <option value="2">Stock Qty</option>
                                          <option value="3">weight</option>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="tax_value" id="" value="<?= isset($po_items['tax_value'])?$po_items['tax_value']:""; ?>" readonly>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <span>Additional</span>
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="additional_gst" onchange="add_value(this,2);">
                                          <option>Select Gst</option>
                                          <?php 
                                             // $defult_tax_rate=0;
                                             
                                             foreach ($master_tax_list as $key => $value) {
                                                 $selected='';
                                                 if($key==0){
                                                     $defult_tax_rate=$value['tax_rate'];
                                                     
                                                 }
                                                 if(isset($grn_info['additional_tax_id']) &&$type==1 && $value['id']==$grn_info['additional_tax_id']){
                                                     $selected="selected";
                                                 }
                                             ?>                                                              
                                          <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="additional_tax_rate" value="<?= isset($po_items['additional_tax_rate'])?$po_items['additional_tax_rate']:"0"; ?>">
                                    <input type="text" class="form-control" name="additional_gst_amount" value="<?= isset($po_items['additional_gst_amount'])?$po_items['additional_gst_amount']:"0"; ?>">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-40" >
                                    <input type="text" class="form-control" style="margin-top: 70px;" readonly name="item_final_amount" id="" value="<?= isset($po_items['item_amount'])?$po_items['item_amount']:"0"; ?>">
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2">
                                 <div class="form-group ">
                                    <label class="control-label">Warranty Description</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="warranty_desc" ><?= isset($po_items['warranty_description'])?$po_items['warranty_description']:""; ?></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label">Other Description</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="other_desc" ><?= isset($po_items['other_description'])?$po_items['other_description']:""; ?></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label">Technical Description</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="technical_description" ><?= isset($po_items['technical_description'])?$po_items['technical_description']:""; ?></textarea>
                                    </div>
                                 </div>
                              </td>
                              <!-- --------------------- -->
                              <td colspan="3" style="text-align:right">
                                 <?php
                                  //  if($type!=1){
                                    ?>
                                 <!--<button name="btn-delete"  data-repeater-delete  data-type="<?= $type ?>" data-po_id="<?= $po_items['po_id']; ?>" data-po_item_id="<?= $po_items['po_item_id']; ?>" class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>-->
                                 <?php
                                   if($type==1 && $is_grn_update==1 && !isset($po_items['po_id'])){
                                ?>
                                <button name="btn-delete" data-repeater-delete  data-type="<?= $type ?>" data-grn_id="<?= $po_items['grn_id']; ?>" data-grn_item_id="<?= $po_items['id']; ?>" data-po_id="<?= $po_items['po_id']; ?>" data-po_item_id="<?= $po_items['item_id']; ?>" class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                <?php
                                    }else{
                                ?>
                                <button name="btn-delete" data-repeater-delete class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                <?php
                                    } 
                                    ?>
                              </td>
                              <!-- ----------------------------- -->
                           </tr>
                        </tbody>
                     </table>
                     <?php
                        }else ://item Foreach end
                        ?>
                       <table class="table table-bordered main_tbl_reapter" data-repeater-item id="grn_items_tables">
                        <thead style="background-color:#e5e5e5;"  name="tbl_po_item_thead">
                           <tr name="tr_head">
                              <th width="15%">
                                 Received Items Group/Item *
                              </th>
                              <th width="7%">Ordered Item/ Why Change Reason</th>
                              <th width="12%">Po Pending Qty</th>
                              <th width="5%">Recv. Qty *</th>
                              <th width="5%">Return Qty</th>
                              <th width="5%">Rate / Amount</th>
                              <th width="5%">Other Charges Disc. Item Wise Amount </th>
                              <th width="10%">GST/VAT Rate % / Amt</th>
                              <th width="10%">Amount</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Item Group  </label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 item_group_select2" required name="item_group_id" style="width:100%" onchange="getItemList(this)">
                                          <option></option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" required name="items_id"style="width:100%" onchange="getItemUnits(this)">
                                          <option></option>
                                       </select>
                                    </div>
                                 </div>
                                  <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                                 <div class="form-group m-t-40">
                                    <label class="control-label text-left col-md-12">HSC Code</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control" name="item_hsc_code" readonly>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Batch Number</label>
                                    <div class="col-md-6">
                                       <input type="text" class="form-control" name="batch_no" required>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label text-left col-md-12">Expired Date</label>
                                    <div class="col-md-6">
                                       <input type="date" class="form-control " name="expired_date" required data-rule-futureDate="true">
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-40">
                                    <label class="control-label">Order Item</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <input type="text" class="form-control" name="order_item"  value="">
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label">Reason</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="reason" value=""></textarea>
                                    </div>
                                 </div>
                                 <!--   <div class="form-group m-b-40">
                                    <div class="row m-1">
                                       <label class="control-label" style="padding:0px;">Is Royalty</label>
                                       <div class="form-check custom-control custom-checkbox" style="margin-left:10px;">
                                          <input type="checkbox" class="custom-control-input form-check-input" id="customControlAutosizing6">
                                          <label class="custom-control-label form-check-label" for="customControlAutosizing6"></label>
                                       </div>
                                    </div>
                                    </div> -->
                                 <!-- 1 field remainig  -->
                              </td>
                              <td>
                                 <table class="m-t-30 m-b-30">
                                    <tbody>
                                       <tr>
                                          <div class="form-group">
                                       <tr>
                                       <td>Total<br>Pending<br>Quantity</td>
                                       <td style="width:45%"><input  class="form-control" placeholder="0" type="text" name="po_total_pending_qty" readonly></td>
                                       <td style="width:45%">
                                       <select class="form-control"  name="po_total_pending_qty_unit">
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Excess<br>Quantity</td>
                                       <td style="width:45%"><input  name="po_excess_qty" class="form-control" placeholder="0" type="text" readonly></td>
                                       <td style="width:45%"></td>
                                       </tr>
                                       <tr>
                                       <td>Challan<br>Quantity</td>
                                       <td style="width:45%"><input  name="po_challan_qty" class="form-control" placeholder="0" type="text" ></td>
                                       <td style="width:45%">
                                       <select class="form-control"  name="po_challan_qty_unit">
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Received<br>Quantity</td>
                                       <td style="width:45%"><input  class="form-control" placeholder="0" type="text" required name="po_received_qty" onblur="calculatePOItem(this)"></td>
                                       <td style="width:45%">
                                       <select class="form-control"  name="po_received_qty_unit">
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Rejected<br>Quantity</td>
                                       <td style="width:45%">
                                       <input  class="form-control" placeholder="0" type="text" name="po_rejected_qty" onblur="showRejectReasons(this)">
                                       </td>
                                       <td style="width:45%">
                                       <select class="form-control"  name="po_rejected_qty_unit">
                                       </select>
                                       </td>
                                       </tr>
                                       <tr>
                                       <td>Adjustment<br>Quantity</td>
                                       <td style="width:45%">
                                       <input  class="form-control po_adjustment_qty" placeholder="0" type="text" value="<?= isset($po_items['po_adjustment_qty'])?$po_items['po_adjustment_qty']:"0"; ?>" name="po_adjustment_qty"   <?= ($type==2 || $type==3)?"":"readonly"; ?>>
                                       </td>
                                       <td style="width:45%">
                                       </td>
                                       </tr>
                                       <tr>
                                       <td colspan="3">
                                       <select class="form-control" required name="reject_reasons" style="display:none;">
                                       <option>Select Reasons</option>
                                       <?php 
                                          // $defult_tax_rate=0;
                                          foreach ($master_reject_list as $key11 => $value11) {
                                           
                                          ?>                                                              
                                       <option value="<?= $value11['particulars'] ?>"><?= $value11['particulars']; ?></option>
                                       <?php
                                          }
                                          ?>
                                       </select>
                                       </td>
                                       </tr></div>
                                    </tbody>
                                 </table>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="received_qty" id="" value="0" readonly>
                                    <div class="col-md-10" style="padding:0px">
                                       <select class="form-control" required name="received_unit">
                                       </select>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <label>Weight</label>
                                    <input type="text" class="form-control" name="item_weight" id="" value="0" onblur="calculatePOItem(this)">
                                    <div class="col-md-10" style="padding:0px">
                                       <select class="form-control" required name="weight_unit">
                                       </select>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <label>Length</label>
                                    <input type="text" class="form-control" name="length" id="" value="0" onblur="calculatePOItem(this)">
                                    <div class="col-md-10" style="padding:0px">
                                       <select class="form-control" required name="length_unit">
                                       </select>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group" style="margin-top: 75px;">
                                    <input type="text" class="form-control m-t-40" name="return_qty" id="" value="0">
                                    <div class="col-md-10 " style="padding:0px">
                                       <select class="form-control" required name="return_qty_unit">
                                       </select>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group" style="margin-top: 60px;">
                                    <span>@</span>
                                    <input type="text" class="form-control po_item_cal" name="item_unit_rate" id="" value="0">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="item_unit_type" onchange="calculatePOItem(this)">
                                          <option value="1">Stock Qty</option>
                                          <option value="2">Weight</option>
                                       </select>
                                    </div>
                                    =
                                    <input type="text" class="form-control" name="item_total" id="" value="0">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-20">
                                    <span>Other Charges</span>
                                    <input type="text" class="form-control" name="item_other_percent" id="" value="0" onblur="calculatePOItem(this)">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="other_charges_type" onchange="calculatePOItem(this)">
                                          <option value="1" selected>@ val</option>
                                          <option value="2">@ qty</option>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="item_other_charges_amt" id="" value="0" readonly>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <span>Discount</span>
                                    <input type="text" class="form-control" name="discount_percent" id="" value="0" onblur="calculatePOItem(this)">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="discount_type" onchange="calculatePOItem(this)">
                                          <option value="1" selected>@ val</option>
                                          <option value="2">@ qty</option>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="discount_value" id="" value="0" readonly>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-10">
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="tax_id" onchange="add_value(this);">
                                          <option>Select Gst</option>
                                          <?php 
                                             // $defult_tax_rate=0;
                                             foreach ($master_tax_list as $key => $value) {
                                                 if($key==0){
                                                     $defult_tax_rate=$value['tax_rate'];
                                                 }
                                             ?>                                                              
                                          <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>"><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" readonly name="tax_rate" id="" value="0" readonly>
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="gst_type" onchange="calculatePOItem(this)">
                                          <option value="1" selected>value</option>
                                          <option value="2">Stock Qty</option>
                                          <option value="3">weight</option>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="tax_value" id="" value="0.00" readonly>
                                 </div>
                                 <hr>
                                 <div class="form-group">
                                    <span>Additional</span>
                                    <div class="col-md-12 " style="padding:0px">
                                       <select class="form-control" required name="additional_gst" onchange="add_value(this,2);">
                                          <option>Select Gst</option>
                                          <?php 
                                             // $defult_tax_rate=0;
                                             foreach ($master_tax_list as $key => $value) {
                                                 if($key==0){
                                                     $defult_tax_rate=$value['tax_rate'];
                                                 }
                                             ?>                                                              
                                          <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>"><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    <input type="text" class="form-control" name="additional_tax_rate" id="" value="0">
                                    <input type="text" class="form-control" name="additional_gst_amount" id="" value="0">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group m-t-40" >
                                    <input type="text" class="form-control" style="margin-top: 70px;" readonly name="item_final_amount" id="" value="0">
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2">
                                 <div class="form-group ">
                                    <label class="control-label">Warranty Description</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="warranty_desc" id="" value=""></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label">Other Description</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="other_desc" id="" value=""></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label">Technical Description</label>
                                    <div class="col-md-12" style="padding:0px;">
                                       <textarea type="text" class="form-control" name="technical_description" id="" value=""></textarea>
                                    </div>
                                 </div>
                              </td>
                              <!-- --------------------- -->
                              <td colspan="3" style="text-align:right">
                                 <button data-repeater-delete class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                              </td>
                              <!-- ----------------------------- -->
                           </tr>
                        </tbody>
                     </table>
                     <?php
                        endif;
                        ?>
                
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <tbody>
                           <tr>
                              <td width="15%">Total</td>
                              <td width="7%"></td>
                              <td width="12%">
                                 <span>Total Pending Quantity</span>
                                 <input type="text" class="form-control" readonly name="total_pending_qty" id="total_pending_qty" value="0">
                              </td>
                              <td width="5%">
                                 <span><br></span>
                                 <input type="text" class="form-control" readonly name="total_received_qty" id="total_received_qty" value="0">
                              </td>
                              <td width="5%">
                                 <span><br></span>
                                 <input type="text" class="form-control" readonly name="total_return_qty" id="total_return_qty" value="0">
                              </td>
                              <td width="5%">
                                 <span><br></span>
                                 <input type="text" class="form-control" readonly name="total_item_amount" id="total_item_amount" value="0">
                              </td>
                              <td width="5%">
                                 <span>Total Other Charges</span>
                                 <input type="text" class="form-control" readonly name="total_other_charges" id="total_other_charges" value="0">
                                 <span>Total Discount</span>
                                 <input type="text" class="form-control" readonly name="total_discount" id="total_discount" value="0">
                              </td>
                              <td width="10%">
                                 <span><br></span>
                                 <input type="text" class="form-control" readonly name="total_gst" id="total_gst" value="0">
                                 <span>Add</span>
                                 <input type="text" class="form-control" readonly name="total_additional_gst" id="total_additional_gst" value="0">
                              </td>
                              <td width="10%">
                                 <span><br></span>
                                 <input type="text" class="form-control" readonly name="total_sub_amount" id="total_sub_amount" value="0">
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <!-- ------------------------ -->
                  <div class="row ">
                     <div class="col-md-6">
                        <h3 class="box-title">Terms & Condition </h3>
                        <hr class="m-t-0 m-b-10">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Remark </label>
                                 <div class="col-md-9">
                                    <textarea class="form-control" name="reamrk" id="reamrk"value="" placeholder="Enter your text here..."><?= (isset($grn_info['remark']))?$grn_info['remark']:''; ?></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Line in bottom </label>
                                 <div class="col-md-9">
                                    <input type="text" class="form-control" name="line_in_bottom" id="line_in_bottom" value="<?= (isset($grn_info['line_in_bottom']))?$grn_info['line_in_bottom']:''; ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Jurisdiction </label>
                                 <div class="col-md-9">
                                    <input type="text" class="form-control" name="jurisdiction" id="jurisdiction" value="<?= (isset($grn_info['jurisdiction']))?$grn_info['jurisdiction']:''; ?>">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-9 bg-diffrent">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-3">Attach a file </label>
                              <div class="col-md-9" style="padding:0px;">
                                 <div class="file-upload-contain">
                                    <input id="multiplefileupload" type="file" multiple  name="file_name[]"/>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="form-group mt-5">
                           <label for="">Choose Images</label>
                           <input type="file" class="form-control" name="images[]" multiple id="upload-img" />
                           </div>
                           <div class="img-thumbs img-thumbs-hidden" style="background: white;border: none;" id="img-preview"></div> -->
                        <!-- <div class="row">
                           <div class="col-6">
                               <div class="card">
                                   <div class="card-body">
                                       <h4 class="card-title">Dropzone</h4>
                                       <div class="dropzone">
                                           <div class="fallback">
                                               <input name="file" type="file" multiple />
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           </div> -->
                     </div>
                     <div class="col-md-6">
                        <h3 class="box-title">Tax Details</h3>
                        <hr class="m-t-0 m-b-10">
                        <div class="table-responsive" >
                           <table class="table table-bordered">
                              <tr>
                                 <td width="30%">[On Item Value]</td>
                                 <td width="20%" class="text-right">Discount</td>
                                 <td width="10%" class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" name="final_discount_percent" id="final_discount_percent" value="<?= (isset($grn_info['discount_percent']))?$grn_info['discount_percent']:'0'; ?>" readonly>
                                    </div>
                                 </td>
                                 <td width="2%">%</td>
                                 <td width="15%" class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" name="final_discount_amount" id="final_discount_amount" value="<?= (isset($grn_info['discount_amount']))?$grn_info['discount_amount']:'0'; ?>" readonly>
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td >[On Bal]</td>
                                 <td class="text-right">GST/VAT</td>
                                 <td class=""> </td>
                                 <td></td>
                                 <td class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" readonly id="final_gst" name="final_gst" value="<?= (isset($grn_info['gst_amount']))?$grn_info['gst_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td ></td>
                                 <td class="text-right">
                                    LD Clause 
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final" name="ld_clause_text" id="ld_clause_text" placeholder="LD Caluse Text " value="<?= (isset($grn_info['ld_clause_text']))?$grn_info['ld_clause_text']:''; ?>">
                                    </div>
                                 </td>
                                 <td class="">
                                 </td>
                                 <td></td>
                                 <td class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final "  name="ld_charges" id="ld_charges" value="<?= (isset($grn_info['ld_charges']))?$grn_info['ld_charges']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td rowspan="3">
                                    <div class="form-group row">
                                       <label class="control-label text-left col-md-6">  Freight (F.O.R.) </label>
                                    </div>
                                 </td>
                                 <td class="text-right" >
                                    <div class="form-group row">
                                       <div class="col-md-6">
                                          <?php
                                             $freight_type='';
                                             if(isset($po_info['freight_type'])){
                                                 $freight_type=$po_info['freight_type'];
                                             }else if(isset($grn_info['freight_type'])){
                                                  $freight_type=$grn_info['freight_type'];
                                             }
                                             ?>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="freight_1" name="freight" class="custom-control-input" onchange="calculateTotal()" value="1" <?= (isset($freight_type) && $freight_type==1)?"checked":''; ?>>
                                             <label class="custom-control-label" for="freight_1">F.O.R</label>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="freight_2" name="freight" class="custom-control-input" onchange="calculateTotal()" value="2" <?= (isset($freight_type)&& $freight_type==2)?"checked":''; ?>>
                                             <label class="custom-control-label" for="freight_2">TO PAY</label>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td class="">
                                 </td>
                                 <td></td>
                                 <td class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" name="freight_amount" id="freight_amount" value="<?= (isset($grn_info['freight_amount']))?$grn_info['freight_amount']:'0'; ?>" >
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <label>VAT/GST on Freight</label>
                                    <select class="form-control custom-select select2 po_item_cal_final" id="freight_tax_id"  name="freight_tax_id" style="width:100%" onchange="add_value_servicetax(1,this);">
                                       <option>Select Tax Value</option>
                                       <?php 
                                          foreach ($master_tax_list as $key => $value) {
                                                   $selected='';
                                                   if($grn_info['freight_tax_id']==$value['id']){
                                                      $selected="selected";
                                                   }
                                          ?>                                                              
                                       <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </td>
                                 <td class="">
                                    <div class="form-group">
                                       <label></label>
                                       <input type="text" class="form-control po_item_cal_final" name="freight_tax_rate" id="freight_tax_rate" readonly value="<?= (isset($grn_info['freight_tax_rate']))?$grn_info['freight_tax_rate']:'0'; ?>">
                                    </div>
                                 </td>
                                 <td>  <label></label>%</td>
                                 <td class="">
                                    <div class="form-group">
                                       <label></label>
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" readonly name="freight_tax_amount" id="freight_tax_amount" value="<?= (isset($grn_info['freight_tax_amount']))?$grn_info['freight_tax_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <label>Additional VAT on Freight</label>
                                    <select class="form-control custom-select select2" id="freight_additional_tax_id" name="freight_additional_tax_id" style="width:100%" onchange="add_value_servicetax(2,this);">
                                       <option>Select Tax Value</option>
                                       <?php 
                                          foreach ($master_tax_list as $key => $value) {
                                              if($key==0){
                                                  $defult_tax_rate=$value['tax_rate'];
                                              }
                                              $selected='';
                                                   if($grn_info['freight_additional_tax_id']==$value['id']){
                                                      $selected="selected";
                                                   }
                                          ?>                                                              
                                       <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </td>
                                 <td class="">
                                    <div class="form-group">
                                       <label></label>
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" name="freight_additional_tax_rate" readonly id="freight_additional_tax_rate" value="<?= (isset($grn_info['freight_additional_tax_rate']))?$grn_info['freight_additional_tax_rate']:'0'; ?>">
                                    </div>
                                 </td>
                                 <td>  <label></label>%</td>
                                 <td class="">
                                    <div class="form-group">
                                       <label></label>
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" name="freight_additional_tax_amount" readonly id="freight_additional_tax_amount" value="<?= (isset($grn_info['freight_additional_tax_amount']))?$grn_info['freight_additional_tax_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="30%" colspan="1">Packing and Forwarding </td>
                                 <td width="20%" class="text-right">
                                 </td>
                                 <td width="10%" class="">
                                 </td>
                                 <td width="2%"></td>
                                 <td width="15%" class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final" name="packing_forwarding_amount" id="packing_forwarding_amount"   onblur="calculateTotal()" value="<?= (isset($grn_info['packing_forwarding_amount']))?$grn_info['packing_forwarding_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="30%" rowspan="2">If Any Other Add    </td>
                                 <td width="20%" class="text-right">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final" name="new_tax_name" id="new_tax_name" placeholder="If Any Other Add Name " value="<?= (isset($grn_info['new_tax_name']))?$grn_info['new_tax_name']:''; ?>">
                                    </div>
                                 </td>
                                 <td width="10%" class="">
                                 </td>
                                 <td width="2%"></td>
                                 <td width="15%" class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final" name="n_tax_amount" id="n_tax_amount" onblur="calculateTotal()"value="<?= (isset($grn_info['new_tax_amount']))?$grn_info['new_tax_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <td>
                                 <label>VAT/GST on If Any Other </label>
                                 <select class="form-control custom-select select2"  id="new_tax_id" name="new_tax_id" style="width:100%" onchange="add_value_servicetax(3,this)">
                                    <option>Select Tax Value</option>
                                    <?php 
                                       foreach ($master_tax_list as $key => $value) {
                                                $selected='';
                                                if($grn_info['new_tax_id']==$value['id']){
                                                   $selected="selected";
                                                   $value_1=$value['tax_rate'];
                                                }
                                       ?>                                                              
                                    <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                    <?php
                                       }
                                       ?>
                                 </select>
                              </td>
                              <td class="">
                                 <div class="form-group">
                                    <label></label>
                                    <input type="text" class="form-control po_item_cal_final" name="new_tax_rate" id="new_tax_rate" readonly value="<?= (isset($value_1))?$value_1:'0'; ?>">
                                 </div>
                              </td>
                              <td>  <label></label>%</td>
                              <td class="">
                                 <div class="form-group">
                                    <label></label>
                                    <input type="text" class="form-control po_item_cal_final" name="new_tax_amount" readonly id="new_tax_amount" value="<?= (isset($grn_info['new_tax_rate']))?$grn_info['new_tax_rate']:'0'; ?>">
                                 </div>
                              </td>
                              </tr>
                              <tr>
                                 <td width="30%" rowspan="2">Service Charges  
                                 </td>
                                 <td width="10%" class="" colspan="2">
                                    <div class="form-group row">
                                       <div class="col-md-6">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio3" name="service_charge_type" class="custom-control-input" value="1" checked onchange="calculateTotal()">
                                             <label class="custom-control-label" for="customRadio3">on service charge </label>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio4" name="service_charge_type" class="custom-control-input" value="2" onchange="calculateTotal()">
                                             <label class="custom-control-label" for="customRadio4">on item value</label>
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td width="2%"></td>
                                 <td width="15%" class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" name="service_charge_amount" id="service_charge_amount" onblur="calculateTotal()" value="<?= (isset($grn_info['service_charge_amount']))?$grn_info['service_charge_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                              <td>
                                 <label>Service Tax </label>
                                 <select class="form-control custom-select select2" id="service_tax_id" name="service_tax_id" style="width:100%" onchange="add_value_servicetax(4,this);">
                                    <option>Select Tax Value</option>
                                    <?php 
                                       foreach ($master_tax_list as $key => $value) {
                                            $selected='';
                                                if($grn_info['service_tax_id']==$value['id']){
                                                   $selected="selected";
                                                }
                                       ?>                                                              
                                    <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                    <?php
                                       }
                                       ?>
                                 </select>
                              </td>
                              <td class="">
                                 <div class="form-group">
                                    <label></label>
                                    <input type="text" class="form-control po_item_cal_final allow_decimal" name="service_tax_rate" id="service_tax_rate" value="<?= (isset($grn_info['service_tax_rate']))?$grn_info['service_tax_rate']:'0'; ?>">
                                 </div>
                              </td>
                              <td>  <label></label>%</td>
                              <td class="">
                                 <div class="form-group">
                                    <label></label>
                                    <input type="text" class="form-control po_item_cal_final allow_decimal" name="service_tax_amount" id="service_tax_amount" value="<?= (isset($grn_info['service_tax_amount']))?$grn_info['service_tax_amount']:'0'; ?>">
                                 </div>
                              </td>
                              </tr>
                              <tr>
                                 <td ></td>
                                 <td class="text-right">Round Off</td>
                                 <td class=""></td>
                                 <td></td>
                                 <td class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" id="round_off" name="round_off" value="<?= (isset($grn_info['round_off']))?$grn_info['round_off']:'0'; ?>" readonly>
                                    </div>
                                 </td>
                              </tr>
                              <tr>
                                 <td ></td>
                                 <td class="text-right">Total Landed Cost </td>
                                 <td class=""></td>
                                 <td></td>
                                 <td class="">
                                    <div class="form-group">
                                       <input type="text" class="form-control po_item_cal_final allow_decimal" id="po_final_amount" name="po_final_amount" readonly value="<?= (isset($grn_info['landed_cost_final_amount']))?$grn_info['landed_cost_final_amount']:'0'; ?>">
                                    </div>
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="form-actions">
                     <div class="row">
                        <div class="col-md-6"> </div>
                        <div class="col-md-6">
                           <div class="row">
                              <div class="col-md-offset-3 col-md-12" style="text-align: center;">
                                 <?php
                                    if(! isset($grn_info['is_material_issue']) && !isset($grn_info['id'])){
                                    ?>
                                 <div class="form-check custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input form-check-input" id="is_material_issue" name="is_material_issue" value="1" <?= (isset($grn_info['is_material_issue'])&&($grn_info['is_material_issue']==1))?'checked':''; ?>>
                                    <label class="custom-control-label form-check-label" for="is_material_issue">is Material Issue</label>
                                 </div>
                                 <?php
                                    }
                                    ?>
                                 <div class="col-md-offset-3 col-md-12" style="text-align: center;"> 
                                    <button type="button" class="btn btn-success btn-theme" onclick="submitGRN()">Submit</button>
                                    <button type="button" class="btn btn-inverse btn-theme-sm">Cancel</button> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
               </form>
               <!-- <div class="container-fluid">
                  <div class="row">
                     <div class="col-6">
                         <div class="card">
                             <div class="card-body">
                                 <h4 class="card-title">Dropzone</h4>
                                 <form action="#" class="dropzone">
                                     <div class="fallback">
                                         <input name="file" type="file" multiple />
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                  </div>
                  </div> -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?= base_url(); ?>/assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?= base_url(); ?>/assets/node_modules/dropzone-master/dist/dropzone.js"></script> -->
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/add_goods_receipt_note_repeater.int.js?v=1.0.8"></script>
<script src="<?= base_url(); ?>/assets/js/page-js/store/grn_cal.js?v=1.0.10"></script>
<script>
   $('.daterange').daterangepicker();
   var date = new Date();
   var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
   $('.precurdatepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: new Date(), // Prevents selecting future dates
        autoclose: true,
        todayHighlight: true
    });

   $('.mydatepicker').datepicker({
    defaultDate: today,
      format: 'dd/mm/yyyy',
   });
   
   $('.myPreviousDatepicker').datepicker({
    defaultDate: today,
    minDate: null  // Set the minimum date to today, preventing selection of previous dates
   });
   
</script>
