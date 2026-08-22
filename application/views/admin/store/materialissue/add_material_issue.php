<?php init_header(); ?>

 <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<style>
  
   .error{
   color:red;
   }
   .sd{
   display: none;
   }
   hr {
   margin-top: 0.5rem;
   }
   .text_area{
   margin-top: -4px !important;
   line-height: 2 !important;
   }
   .margin-bottom-7{
   margin-bottom:10px !important;
   }
   .select2-container{
   margin-bottom: 7px !important;
   }
   .upper_case
   {
   text-transform: uppercase;
   }
   
   .lables{
   font-weight: bold;
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

   .file-drop-zone-title {
       padding: 15px 10px !important;
   }
   .main_tbl_reapter{
       background:#eff1f3
   }

</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">

<div class="container-fluid">

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
            <form class="repeater" method="post" action="<?= base_url('admin/store/MaterialIssue/add_materialissue');?>" id="frm_issue" enctype="multipart/form-data"class="form-horizontal" autocomplete="off">
               <div class="row">
                   <?php   // $type=1 noraml material issue $type=2 means grn $type3=edit material issue //type=4  transfter /receveird liat  ?>
                  <input type="hidden" name="id" id="id" value="<?= (isset($id))? $id : '' ?>">
                  <input type="hidden" name="type" id="type" value="<?= (isset($type))? $type : '1' ?>">
                   <input type="hidden" name="issue_id" id="issue_id" value="<?= (isset($issue_info['id'])&& $type==3)? $issue_info['id'] : '' ?>">

                  <input type="hidden" name="company_id" id="company_id" value="<?= (isset($issue_info['company_id']) && $issue_info['company_id'])? $issue_info['company_id'] : userId('company_id');  ?>">
                  <input type="hidden" name="site_id" id="site_id" value="<?= (isset($issue_info['site_id']) && $issue_info['site_id'])? $issue_info['site_id'] : userId('site_id');  ?>">
                  <input type="hidden" name="financial_year_id" id="financial_year_id" value="<?= (isset($issue_info['financial_year_id']) && $issue_info['financial_year_id'])? $issue_info['financial_year_id'] : userId('financial_year_id');  ?>">
                  <input type="hidden"  id="type" value="<?= (isset($type))? $type : '1' ?>">
                  <input type="hidden" name="vendorId" id="vendorId" value="<?= (isset($issue_info['vendor_id']) && $issue_info['vendor_id'])? $issue_info['vendor_id'] : 0  ?>">
                   <input type="hidden" name="transportId" id="transportId" value="<?= (isset($issue_info['transport_id']) && $issue_info['transport_id'])? $issue_info['transport_id'] : 0  ?>">
                  <?php
                //   echo $issue_info['issue_date'];die;
                    if(isset($issue_info['issue_date'])){
                        $issue_date=date('d/m/Y',strtotime($issue_info['issue_date']));
                    }else{
                         $issue_date=date('d/m/Y');
                    }
                    
                    if(isset($issue_info['issue_time'])){
                        $issue_time=date('H:i A',strtotime($issue_info['issue_time']));
                    }else{
                         $issue_time=date('H:i A');
                    }
                    
                    if(isset($issue_info['issue_number'])){
                        $unqie_no=$issue_info['issue_number'];
                    }else{
                        $unqie_no="ISSUE-".userId('company_id')."-".userId('site_id')."-".userId('user_id')."-".rand(0,999);
                        // $unqie_no
                    }
                    
                  ?>
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color">
                              <h6><b>Add Material Issue</b></h6>
                           </span>
                           <hr>
                        </div>
                        <div class="form-group col-md-3 ">
                           <label class=""><b>Material Issue No</b></label>
                           <?php
                           
                           ?>
                           <input type="text" class="form-control" name="issue_number" readonly value="<?= $unqie_no;?>">
                        </div>

                        <div class="form-group col-md-3 ">
                           <label class=""><b>Issue Date</b></label>
                             <div class="input-group">
                                 <input type="text" class="form-control" name="issue_date" id="datepicker-autoclose" value="<?= isset($issue_date)?$issue_date:'';?>" <?= ($type==3)?'disabled':'' ?>>
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                             </div>
                        </div>

                        <div class="form-group col-md-3 ">
                           <label class=""><b>Time</b></label>

                            <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="time-local" class="form-control" value="<?= isset($issue_time)?$issue_time:date('H:i A');?>" name="issue_time" <?= ($type==3)?'readonly':'' ?>>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3 "></div>
                        <div class="form-group col-md-3"></div>
                        <?php
                            if(isset($type)&& $type==2){
                                $issue_type=1;
                            }else if(isset($issue_info['issue_type'])){
                                $issue_type=$issue_info['issue_type'];
                            }else{
                               $issue_type=1;
                                // $unqie_no
                            }
                            
                            if(isset($issue_info['issue_from'])){
                                $issue_from=$issue_info['issue_from'];
                            }
                            
                        ?>
                        <div class="form-group col-md-4" id="type_consumption">
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="1" name="issue_type" id="consumption" <?= (isset($issue_type) && $issue_type==1)?"checked":''; ?>  <?= ($type==3)?'disabled':'' ?>>
                              <label class="form-check-label" for="inlineRadio1" ><b>Consumption/Issue</b></label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="2" name="issue_type" id="transfer" <?= (isset($issue_type) && $issue_type==2)?"checked":''; ?>  <?= ($type==3)?'disabled':'' ?>>
                              <label class="form-check-label" for="inlineRadio2"><b>Transfer</b></label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="3" name="issue_type" id="production" <?= (isset($issue_type) && $issue_type==3)?"checked":''; ?>  <?= ($type==3)?'disabled':'' ?>>
                              <label class="form-check-label" for="inlineRadio3"><b>Production</b></label>
                           </div>
                        </div>
                        <div class="form-group col-md-4">
                           <fieldset class="form-group">
                              <div class="row" id="self_party_stock">
                                 <label class="form-check-label" for="issue_from1"><b>Issue/Transfer Form:-&nbsp;&nbsp;</b>
                                 </label>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="issue_from"  value="1" id="party_stock" <?= (isset($issue_from) && $issue_from==1)?"checked":''; ?>>
                                    <label class="form-check-label" for="issue_from1">
                                    Party Stock&nbsp;&nbsp;
                                    </label>
                                 </div>
                                 <div class="form-check">
                                    <?php if(isset($issue_type)==1){?>
                                       <input class="form-check-input" type="radio" name="issue_from" id="issue_from2" value="2"> <?= (isset($issue_from) && $issue_from==2)?"checked":''; ?>
                                       <label class="form-check-label" for="issue_from2">
                                       Self Stock
                                       </label>
                                    <?php }else{ ?>
                                       <input class="form-check-input" type="radio" name="issue_from" id="issue_from2" value="2" checked <?= (isset($issue_from) && $issue_from==2)?"checked":''; ?>>
                                       <label class="form-check-label" for="issue_from2">
                                       Self Stock
                                       </label>
                                    <?php } ?>
                                 </div>
                              </div>
                           </fieldset>
                        </div>
                        <div class="col-md-6" id="stock_at_vendor" <?= (isset($issue_type) && $issue_type == 1)? 'style="display: block;"' : 'style="display: none;"' ?>>
                           <div class="form-group row"  >
                              <label class="control-label  col-md-6"><b>Consumption/Issue From Stock At Vendor</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 vender_name" id="account_name" name="issue_from_vendor_id" style="width:100%">
                                    <?php
                                        if(isset($vendor_master) && !empty($vendor_master)){
                                            // print_r($vendor_master);die;
                                        foreach ($vendor_master as $key => $value) {
                                          if((isset($issue_info['issue_from_vendor_id'])&&$issue_info['issue_from_vendor_id']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>  
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['account_name'] ?></option>
                                    <?php } 
                                        }
                                    ?>
                                 </select>
                                 <small id="emailHelp" class="form-text" style="color:#6610f2 ;">(Select If Consumption/Issue Form Vender)</small>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3" id="flat" <?= (isset($issue_type) && $issue_type == 1)? 'style="display: block;"' : 'style="display: none;"' ?>>
                           <div class="form-group row" >
                              <label class="control-label col-md-3 "><b>Flat</b></label>
                              <div class="col-md-9">
                                 <input class="form-control " type="text" placeholder="" name="flat"    value="<?= isset($issue_info['flat'])?$issue_info['flat']:'';?>">
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3" id="floor" <?= (isset($issue_type) && $issue_type == 1)? 'style="display: block;"' : 'style="display: none;"' ?>>
                           <div class="form-group row">
                              <label class="control-label col-md-3 "><b>Floor</b></label>
                              <div class="col-md-9">
                                 <input type="text" class="form-control"  placeholder="" name="floor" id="floor" value="<?= isset($issue_info['floor'])?$issue_info['floor']:'';?>">
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group row" >
                              <label class="control-label col-md-6"><b>Issue Location</b></label>
                              <div class="col-md-6">
                                  <?php
                                        if($type==3):
                                            $site_name='';
                                           if(isset($issue_info['issue_location_site_id'])){
                                               foreach ($site_master as $subarray) {
                                                     if ($subarray['id'] == $issue_info['issue_location_site_id']) {
                                                        $site_name=$subarray['site_name'];
                                                    }
                                                }
                                           }
                                             
                                   ?>
                                 <input type="hidden" name="issue_location_site_id" class="form-control site_id" id="site_id" value="<?= isset($issue_info['issue_location_site_id'])?$issue_info['issue_location_site_id']:'';?>">
                                 <input type="hidden" name="old_issue_to_location_site_id" class="form-control site_id" value="<?= isset($issue_info['issue_to_location_site_id'])?$issue_info['issue_to_location_site_id']:'';?>">
                                 <input type="text" name="" class="form-control" readonly id="" value="<?= isset($site_name)?$site_name:'';?>">
                                 <?php
                                        else:
                                            // print_r($issue_info);
                                 ?> 
                                  <input type="hidden" name="issue_location_site_id" class="form-control site_id" id="site_id" value="<?= isset($issue_info['site_id'])?$issue_info['site_id']:userId('site_id');?>">
                                 <input type="text" name="" class="form-control" readonly id="" value="<?= isset($issue_info['site_name'])?$issue_info['site_name']:userId('company_site_name');?>">
                                 <?php
                                        endif;
                                 ?>
                               <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>
                        </div>
                        
                        <div class="form-group col-md-3 ">
                           <div id="issue_to_location_site_id" <?= (isset($issue_info['issue_type']) && $issue_info['issue_type'] == 2)? 'style="display: block;"' : 'style="display: none;"' ?>>
                              <div class="form-group row" >
                                 <label class="control-label col-md-3"><b>To Location</b></label>
                                 <div class="col-md-8">
                                    <select class="form-control select2 issue_to_location_site_id"  id="issue_to_location_site_id" name="issue_to_location_site_id" style="width: 100%;" value="<?= isset($issue_info['issue_to_location_site_id'])?$issue_info['issue_to_location_site_id']:'';?>" <?= ($type==3)?'disabled':'' ?>>
                                          <?php
                                        if(isset($issue_info['issue_to_location_site_id']) && !empty($issue_info['issue_to_location_site_id'])){
                                           foreach ($site_master as $key1 => $site_master) {
                                             if((isset($issue_info['issue_to_location_site_id'])&&$issue_info['issue_to_location_site_id']==$site_master['id'])){
                                              $selected="selected";
                                               }else{
                                               $selected="";
                                             } ?>
                                          <option value="<?= $site_master['id'] ?>"  <?= $selected; ?>><?= $site_master['site_name'] ?></option>
                                       <?php } 
                                           }
                                       ?>
                                    </select>
                                    <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                                 </div>
                              </div>
                           </div>

                           <div  id="customer_id" <?= (isset($issue_from) && $issue_from == 1)? 'style="display: block;"' : 'style="display: none;"' ?>> 
                              <div class="form-group row">
                                 <label class="control-label col-md-3"><b>Customer Name</b></label>
                                 <div class="col-md-9">
                                    <select class="form-control select2 vender_name"  id="customer_id" name="customer_id" style="width: 100%;" >
                                         <?php
                                        if(isset($issue_info['customer_id']) && !empty($issue_info['customer_id'])){
                                           foreach ($customer_name as $key => $value) {
                                             if((isset($issue_info['customer_id'])&& $issue_info['customer_id']==$value['id'])){
                                              $selected="selected";
                                               }else{
                                               $selected="";
                                             } ?>
                                          <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['account_name'] ?></option>
                                       <?php } 
                                           }
                                       ?>
                                    </select>
                                    <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-3 ">
                        </div>
                         <?php
                                    $gate_pass_no=$rst_no='';
                                     if(isset($issue_info['gate_pass_no'])){
                                        $gate_pass_no= $issue_info['gate_pass_no'];
                                     }
                                     
                                    
                                  ?>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Gate Pass No</b></label>
                              <div class="col-md-6">
                                 <input class="form-control gate_pass_no " type="text" placeholder="" id="gate_pass_no" name="gate_pass_no" value="<?= isset($issue_info['gate_pass_no'])?$issue_info['gate_pass_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                          
                             
                           <div class="col-md-8" style="font-weight: bold;">
                              <input type="checkbox"  value="1" id="is_auto_make_gate" name="is_auto_make_gate" <?= (isset($issue_info['is_auto_make_gate']) && $issue_info['is_auto_make_gate']==1)?"checked":''; ?> onclick="automake_gatepassCheckbox()" ><label class="did-floating-label" style="top:0px;margin-left: 20px;"><b>Auto Make Gate Pass No.(On Edit It Will Not Work)</b></label>
                           </div>

                        </div>
                      <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Is Our Carrying Vehicle</b></label>
                              <div class="col-md-6">
                                 <input type="checkbox" id="vehicle_no" value="1"  name="is_our_carrying_vehicle" <?= (isset($issue_info['is_our_carrying_vehicle']) && $issue_info['is_our_carrying_vehicle']==1)?"checked":''; ?>><label class="did-floating-label" style="top:0px;margin-left: 3px;">Carrying Vehicle No.</label>
                                 <!-- carrying_vehicle_no -->
                                 <input class="form-control" type="text" placeholder="" name="carrying_vehicle_no" value="<?= isset($issue_info['carrying_vehicle_no'])?$issue_info['carrying_vehicle_no']:'';?>">
                              </div>
                           </div>
                        </div>


                         <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Carrying Vehicle Driver</b></label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="carrying_vehicle_driver"   value="<?= isset($issue_info['carrying_vehicle_driver'])?$issue_info['carrying_vehicle_driver']:'';?>">
                              </div>
                              <label class="control-label col-md-6"><b>Carrying Vehicle Reading</b></label>
                              <div class="col-md-6 m-t-5">
                                 <!-- carrying_vehicle_reading -->
                                 <input class="form-control " type="text" placeholder="" name="carrying_vehicle_reading"  value="<?= isset($issue_info['carrying_vehicle_reading'])?$issue_info['carrying_vehicle_reading']:'';?>">
                              </div>
                           </div>
 

 
                           
                           <div class="form-group row" id="loaded_via">
                              <label class="control-label col-md-6"><b>Loaded Via</b></label>
                              <div class="col-md-6">
                                 <label class="radio-inline">
                                 <input type="radio" name="is_loaded_via" value="1" checked <?= (isset($issue_info['is_loaded_via']) && $issue_info['is_loaded_via']==1)?"checked":''; ?>>&nbsp;&nbsp;Self
                                 </label>
                                 <label class="radio-inline" >
                                 <input type="radio" name="is_loaded_via" value="2" id="party" <?= (isset($issue_info['is_loaded_via']) && $issue_info['is_loaded_via']==2)?"checked":''; ?>>&nbsp;&nbsp;Party
                                 </label>
                             </div>
                           </div>
                           <div class="form-group row" id="loaded_party_id" style="display:none;">
                              <label class="control-label col-md-6"><b>Party Name</b></label>
                              <div class="col-md-6">
                                 <!-- loaded_party_id -->
                                 <select class="form-control select2 vender_name"  id="party_option" name="loaded_party_id"  style="width:100%;">
                                    <?php
                                        if(isset($party_name) && !empty($party_name)){
                                           foreach ($party_name as $key => $value) {
                                             if((isset($issue_info['loaded_party_id'])&&$issue_info['loaded_party_id']==$value['id'])){
                                              $selected="selected";
                                               }else{
                                               $selected="";
                                             } ?>
                                          <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['account_name'] ?></option>
                                       <?php } 
                                        }
                                    ?>
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Transporter</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 vender_name" name="transporter_id" id="transporter">
                                    <option>Select</option>
                                    <?php
                                        if(isset($vendor_master) && !empty($vendor_master)){
                                        foreach ($vendor_master as $key => $value) {
                                          if((isset($issue_info['transporter_id'])&&$issue_info['transporter_id']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>  
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['account_name'] ?></option>
                                    <?php } 
                                        }
                                    ?>
                                    
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Manual Slip No</b></label>
                              <div class="col-md-6">
                                  <?php
                                    $manual_slip_no=$rst_no='';
                                     if(isset($issue_info['manual_slip_no'])){
                                        $manual_slip_no= $issue_info['manual_slip_no'];
                                     }
                                     if(isset($issue_info['rst_no'])){
                                        $rst_no= $issue_info['rst_no'];
                                     }
                                     
                                    
                                  ?>
                                 <input class="form-control " type="text" placeholder="" name="manual_slip_no"   value="<?= isset($manual_slip_no)?$manual_slip_no:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Indend No</b></label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" required name="indend_no"   value="<?= isset($issue_info['indend_no'])?$issue_info['indend_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>RST No</b></label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="rst_no" value="<?= isset($issue_info['rst_no'])?$issue_info['rst_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                       
                     </div>
                    <div class="row m-t-10">
                        
                        <div class="col-md-6">
                           <span class="text-color">
                            <h6><b>Material Issue</b></h6>
                           </span>
                        </div>
                        <div class="col-md-6" align="right">
                           <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme">Add</button></a>
                        </div>
                     </div>
                     <hr>
                     <div class="table-responsive" data-repeater-list="material_items" id="item_group_tables">
                      <?php
                           if(isset($po_info_items)&& !empty($po_info_items)):
                           ?>
                        <?php
                           foreach ($po_info_items as $key1 => $po_items) {
                           ?>
                            <table class="table table-bordered main_tbl_reapter"  data-repeater-item>
                                <tbody>
                              <tr name="tr_name">
                                    <td>
                                 <div class="form-group ">
                                     <input type="hidden" class="form-control" name="available_qty" value="<?= isset($po_items['available_qty'])?$po_items['available_qty']:0 ?>">
                                    <input type="hidden" name="delete_type" value="2">
                                    <label class="control-label text-left col-md-12">Item Group  </label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)">
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
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)">
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
                                  <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Batch No</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" name="batch_no" style="width:100%" onchange="getAvaliableQuantity(this)">
                                          <?php
                                          $max_qty=0;
                                             foreach($po_items['item_batch_list'] as $key_i2=>$value_batch1){
                                                
                                                 $selected='';
                                                if($po_items['batch_no']==$value_batch1['batch_no']){
                                                   $selected="selected";
                                                   $max_qty=$value_batch1['batch_qty'];
                                                }
                                             ?>
                                             





                                          <option value="<?= $value_batch1['batch_no']; ?>" <?= $selected; ?> data-item_rate_type="<?= isset($po_items['item_rate_type'])?$po_items['item_rate_type']:0 ?>" data-weight_per_rate="<?= isset($po_items['weight_per_rate'])?$po_items['weight_per_rate']:0 ?>" data-weight_per_qty="<?= isset($po_items['weight_per_qty'])?$po_items['weight_per_qty']:0 ?>"  data-item_weight="<?= isset($po_items['item_weight'])?$po_items['item_weight']:0 ?>" data-aviable_qty="<?= isset($po_items['available_qty'])?$po_items['available_qty']:0 ?>"data-expired_date="<?= isset($po_items['expired_date'])?$po_items['expired_date']:0 ?>"data-rate="<?= isset($po_items['rate'])?$po_items['rate']:0 ?>"><?= $value_batch1['batch_no'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    
                                 </div>
                                  <div class="form-group col-md-12">
                                       <label class=""><b>Expired Date</b></label>
                                       <input class="form-control " type="text" placeholder="" name="expired_date"   value="<?= isset($po_items['expired_date'])?$po_items['expired_date']:0 ?>" disabled>
                                    </div>
                                     <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                              </td>
                     
                                 <td width="15%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Req.Qty</b></label>
                                       <input class="form-control " type="text" placeholder="" name="req_qty"   value="<?= $po_items['po_received_quantity']; ?>">
                                    </div>
                                 </td>
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Issue Qty</b></label>
                                       <input type="text" class="form-control po_item_cal item_unit"  name="item_unit" value="<?= $po_items['po_received_quantity']; ?>" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)" data-rule-availableQty="true"  data-rule-decimal="true" >
                                       <div class="form-group ">                                                                     
                                          <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id"  onchange="getBatchwiseUnitWise(this)">
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

                                    <div class="form-group col-md-12 m-t-20">
                                       <label class=""><b>Weight</b></label>
                                       <input class="form-control " type="text" placeholder=""  name="weight" value="<?= ($po_items['item_weight'])?$po_items['item_weight']:'' ?>">
                                       <div class="form-group ">                                                                     
                                          <select class="form-control custom-select select2" style="width:100%" name="weight_item_unit_id" id="weight_item_unit_id"  >
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
                                  
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Rate</b></label>
                                       <input class="form-control " type="text" placeholder="" name="rate"   value="<?= $po_items['item_rate']; ?>" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)">
                                    </div>

                                    <div class="form-group col-md-12">
                                       <label class=""><b>Amount</b></label>
                                       <input class="form-control " type="text" placeholder="" name="amount"   id="" value="<?= $po_items['item_sub_amount']; ?>">
                                    </div>

                                    <div class="form-group col-md-12 m-t-15 display_issued_to" id="">
                                       <label class=""><b>Issue To</b></label>
                                    
                                       <div class="form-check">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="1">
                                          <label class="form-check-label" for="exampleRadios1">
                                             Party/Employee
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="2">
                                          <label class="form-check-label" for="exampleRadios2">
                                          Veh.
                                          </label>
                                       </div>
                                       <div class="form-check ">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="3" >
                                          <label class="form-check-label" for="exampleRadios3">
                                          Other
                                          </label>
                                       </div>



                                       <div class="form-group row emp_issued_to m-t-5" id="emp_issued_to" name="emp_issued_to" style="display:none;">
                                          <label style="padding-right:0px" class="control-label col-md-6"><b>Party/Employee Name</b></label>
                                          <div class="col-md-6" style="padding-left:0px">
                                             <!-- loaded_party_id -->
                                             <select class="form-control select2 vender_name"  id="" name="emp_issued_to_id"  style="width:100%;">
                                                  <?php
                                                if(isset($vendor_master) && !empty($vendor_master)){
                                                foreach ($vendor_master as $key => $value) {
                                                    
                                                 ?>  
                                               <option value="<?= $value['id'] ?>"  ><?= $value['account_name'] ?></option>
                                            <?php } 
                                                }
                                            ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="form-group row vehicle_issed_to m-t-5" id="" name="vehicle_issed_to" style="display:none;">
                                          <label class="control-label col-md-6"><b>Vehicle Name</b></label>
                                          <div class="col-md-6">
                                             <!-- loaded_party_id -->
                                            <input type="text" name="vehicle" class="form-control">
                                          </div>
                                       </div>

                                       <div class="form-group row other_issued m-t-5" id="" name="other_issued" style="display:none;">
                                          <label class="control-label col-md-6"><b>Other</b></label>
                                          <div class="col-md-6">
                                             <!-- loaded_party_id -->
                                             <input type="text" name="other_text" class="form-control">
                                          </div>
                                       </div>
                                    </div>

                                    <div class="form-group col-md-12 m-t-10">
                                       <div class="form-group row">
                                          <div class="col-md-5 mt-1">
                                             <label style="margin-right:10px;"><b>Is Retunable</b></label>
                                             <input type="checkbox" name="is_returnable" value="1">
                                          </div>
                                          <div class="col-md-7 mt-1">
                                             <input class="form-control " type="date" placeholder="" name="returnable_date"   >
                                          </div>
                                       </div>
                                    </div>

                                    </div>
                                 </td>
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12 ">
                                       <label class=""><b>Remark</b></label>
                                       <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="material_issue_remark"></textarea>
                                    </div>
                                 </td>
                                 <td width="3%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12" align="center" style="padding:0px;">
                                      <button data-repeater-delete class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                    </div>
                                 </td>
                                
                              </tr>
                           </tbody>
                            </table> 
                            <?php
                           } //foreach po item end
                           ?>
                        <?php
                            elseif($type==3):
                        ?>
                        <?php
                            // print_r($info_items_data);die;
                           if(isset($info_items_data)&& !empty($info_items_data)){
                           ?>
                        <?php
                           foreach ($info_items_data as $key1 => $items) {
                           ?>
                            <table class="table table-bordered main_tbl_reapter"  data-repeater-item>
                               <tbody>
                                  <tr name="tr_name">
                                        <td>
                                     <div class="form-group ">
                                        <input type="hidden" class="form-control" name="available_qty" value="<?= isset($items['available_qty'])?$items['available_qty']:0 ?>">
                                        
                                        
                                        <input type="hidden" class="form-control" name="old_issue_qty" value="<?= isset($items['issue_qty'])?$items['issue_qty']:0 ?>">
                                        <input type="hidden" class="form-control" name="old_batch_no" value="<?= isset($items['batch_no'])?$items['batch_no']:0 ?>">
                                        <input type="hidden" class="form-control" name="old_issue_qty_unit" value="<?= isset($items['issue_qty_unit'])?$items['issue_qty_unit']:0 ?>">
                                        <input type="hidden" name="delete_type" value="3">
                                        <label class="control-label text-left col-md-12">Item Group  </label>
                                        <div class="col-md-12">
                                           <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)" disabled>
                                               <?php
                                                     if(isset($items['item_group_id']) && $items['item_group_id']==0){
                                                      echo    ' <option value="all" selected>all</option>';
                                                     }
                                            ?>
                                            
                                             
                                              <?php
                                                 foreach($item_groups_master as $key_i=>$value_item){
                                                    if (isset($value_item['parent_group_name'])) {
                                                            $text = $value_item['item_group_name'] . " (" . $value_item['parent_group_name'] . ")";
                                                    } else {
                                                            $text =$value_item['item_group_name'];
                                                    }
                                                     $selected='';
                                                    if($items['item_group_id']==$value_item['id']){
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
                                           <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)" disabled>
                                              <?php
                                                 foreach($items['item_name'] as $key_i1=>$value_item1){
                                                    
                                                     $selected='';
                                                    if($items['item_id']==$value_item1['id']){
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
                                      <div class="form-group ">
                                        <label class="control-label text-left col-md-12">Batch No</label>
                                        <div class="col-md-12">
                                           <select class="form-control custom-select select2 po_items_select" name="batch_no" style="width:100%" onchange="getAvaliableQuantity(this)">
                                              <?php
                                              $max_qty=0;
                                                 foreach($items['item_batch_list'] as $key_i2=>$value_batch1){
                                                    
                                                     $selected='';
                                                    if($items['batch_no']==$value_batch1['batch_no']){
                                                       $selected="selected";
                                                       $max_qty=$value_batch1['batch_qty'];
                                                    }
                                                 ?>
                                            
                                               <option value="<?= $value_batch1['batch_no']; ?>" <?= $selected; ?> data-item_rate_type="<?= isset($po_items['item_rate_type'])?$po_items['item_rate_type']:0 ?>" data-weight_per_rate="<?= isset($po_items['weight_per_rate'])?$po_items['weight_per_rate']:0 ?>" data-weight_per_qty="<?= isset($po_items['weight_per_qty'])?$po_items['weight_per_qty']:0 ?>"  data-item_weight="<?= isset($po_items['item_weight'])?$po_items['item_weight']:0 ?>" data-aviable_qty="<?= isset($po_items['available_qty'])?$po_items['available_qty']:0 ?>"data-expired_date="<?= isset($po_items['expired_date'])?$po_items['expired_date']:0 ?>"data-rate="<?= isset($po_items['rate'])?$po_items['rate']:0 ?>"><?= $value_batch1['batch_no'] ?></option>
                                              <?php
                                                 }
                                                 ?>
                                           </select>
                                           <div class="form-group col-md-12">
                                           <label class=""><b>Expired Date</b></label>
                                           <input class="form-control " type="text" placeholder="" name="expired_date"   value="<?= $items['expired_date']; ?>" disabled>
                                        </div>
                                        </div>
                                        
                                     </div>
                                     <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                                  </td>
                         
                                     <td width="15%" style="border-color: #ffffff;">
                                        <div class="form-group col-md-12">
                                           <label class=""><b>Req.Qty</b></label>
                                           <input class="form-control " type="text" placeholder="" name="req_qty"   value="<?= $items['req_qty']; ?>">
                                        </div>
                                     </td>
                                     <td width="20%" style="border-color: #ffffff;">
                                        <div class="form-group col-md-12">
                                           <label class=""><b>Issue Qty</b></label>
                                           <input type="text" class="form-control po_item_cal  item_unit"  name="item_unit" value="<?= $items['issue_qty']; ?>" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)" data-rule-availableQty="true"   data-rule-decimal="true">
                                           <div class="form-group ">                                                                     
                                              <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id">
                                                    <?php
                                              foreach($items['item_unit_list'] as $key_i2=>$value_item2){
                                                 
                                                  $selected='';
                                                 if($items['issue_qty_unit']==$value_item2['id']){
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
    
                                        <div class="form-group col-md-12 m-t-20">
                                           <label class=""><b>Weight</b></label>
                                           <input class="form-control " type="text" placeholder=""  name="weight" value="<?= ($items['weight'])?$items['weight']:'' ?>">
                                           <div class="form-group ">                                                                     
                                              <select class="form-control custom-select select2" style="width:100%" name="weight_item_unit_id" id="weight_item_unit_id"  >
                                                    <?php
                                              foreach($items['item_weight_unit_list'] as $key_i2=>$value_item2){
                                                 
                                                  $selected='';
                                                 if($items['weight_unit']==$value_item2['id']){
                                                    $selected="selected";
                                                 }
                                              ?>
                                           <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['weight_unit'] ?></option>
                                           <?php
                                              }
                                              ?>
                                              </select>
                                           </div>
                                        </div>
                                     </td>
                                      
                                     <td width="20%" style="border-color: #ffffff;">
                                        <div class="form-group col-md-12">
                                           <label class=""><b>Rate</b></label>
                                           <input class="form-control " type="text" placeholder="" name="rate"   value="<?= $items['rate']; ?>" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)">
                                        </div>
    
                                        <div class="form-group col-md-12">
                                           <label class=""><b>Amount</b></label>
                                           <input class="form-control " type="text" placeholder="" name="amount"   id="" value="<?= $items['amount']; ?>">
                                        </div>
    
                                        <div class="form-group col-md-12 m-t-15 display_issued_to" id="">
                                           <label class=""><b>Issue To</b></label>
                                        
                                           <div class="form-check">
                                              <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="1" <?= ($items['issue_to']&& $items['issue_to']==1)?'checked':'' ?>>
                                              <label class="form-check-label" for="exampleRadios1">
                                                 Party/Employee
                                              </label>
                                           </div>
                                           <div class="form-check">
                                              <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="2" <?= ($items['issue_to']&& $items['issue_to']==2)?'checked':'' ?>>
                                              <label class="form-check-label" for="exampleRadios2">
                                              Veh.
                                              </label>
                                           </div>
                                           <div class="form-check ">
                                              <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="3" <?= ($items['issue_to']&& $items['issue_to']==3)?'checked':'' ?> >
                                              <label class="form-check-label" for="exampleRadios3">
                                              Other
                                              </label>
                                           </div>
    
    
    
                                           <div class="form-group row emp_issued_to m-t-5" id="emp_issued_to" name="emp_issued_to" <?= ($items['issue_to']&& $items['issue_to']==1)?'':'style="display:none;"' ?>
                                              <label style="padding-right:0px" class="control-label col-md-6"><b>Party/Employee Name</b></label>
                                              <div class="col-md-6" style="padding-left:0px">
                                                 <!-- loaded_party_id -->
                                                 <select class="form-control select2 vender_name"  id="" name="emp_issued_to_id"  style="width:100%;">
                                                      
                                                      <?php
                                                    if(isset($vendor_master) && !empty($vendor_master)){
                                                    foreach ($vendor_master as $key => $value) {
                                                        
                                                          if($items['part_id']==$value['id']){
                                                                $selected="selected";
                                                             }
                                                     ?>  
                                                   <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['account_name'] ?></option>
                                                <?php } 
                                                    }
                                                ?>
                                                 </select>
                                                 </select>
                                              </div>
                                           </div>
    
                                           <div class="form-group row vehicle_issed_to m-t-5" id="" name="vehicle_issed_to"  <?= ($items['issue_to']&& $items['issue_to']==2)?'':'style="display:none;"' ?>>
                                              <label class="control-label col-md-6"><b>Vehicle Name</b></label>
                                              <div class="col-md-6">
                                                 <!-- loaded_party_id -->
                                                <input type="text" name="vehicle" class="form-control" <?= $items['vehicle']; ?>>
                                              </div>
                                           </div>
    
                                           <div class="form-group row other_issued m-t-5" id="" name="other_issued"  <?= ($items['issue_to']&& $items['issue_to']==2)?'':'style="display:none;"' ?>>
                                              <label class="control-label col-md-6"><b>Other</b></label>
                                              <div class="col-md-6">
                                                 <!-- loaded_party_id -->
                                                 <input type="text" name="other_text" class="form-control" <?= $items['other_text']; ?>>
                                              </div>
                                           </div>
                                        </div>
    
                                        <div class="form-group col-md-12 m-t-10">
                                           <div class="form-group row">
                                              <div class="col-md-5 mt-1">
                                                 <label style="margin-right:10px;"><b>Is Retunable</b></label>
                                                 <input type="checkbox" name="is_returnable" value="1" <?= ($items['is_returnable']&& $items['is_returnable']==1)?'checked':'' ?> >
                                              </div>
                                              <div class="col-md-7 mt-1">
                                                 <input class="form-control " type="date" placeholder="" name="returnable_date" value="<?= $items['returnable_date'] ?>" >
                                              </div>
                                           </div>
                                        </div>
                                        </div>
    
                                     </td>
                                     <td width="20%" style="border-color: #ffffff;">
                                        <div class="form-group col-md-12 ">
                                           <label class=""><b>Remark</b></label>
                                           <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="material_issue_remark"><?= $items['remark'] ?></textarea>
                                        </div>
                                     </td>
                                     <td width="3%" style="border-color: #ffffff;">
                                        <div class="form-group col-md-12" align="center" style="padding:0px;">
                                          <button data-repeater-delete class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                        </div>
                                     </td>
                                    
                                  </tr>
                               </tbody>
                            </table> 
                            <?php
                           } //foreach po item end
                           }
                           ?>
                        <?php
                            //}
                           elseif($type==4):
                        ?>
                            <?php
                           foreach ($trf_info_items as $key1 => $po_items) {
                           ?>
                            <table class="table table-bordered main_tbl_reapter"  data-repeater-item>
                                <tbody>
                              <tr name="tr_name">
                                    <td>
                                 <div class="form-group ">
                                     <input type="hidden" class="form-control" name="available_qty" value="<?= isset($po_items['available_qty'])?$po_items['available_qty']:0 ?>">
                                    <input type="hidden" name="delete_type" value="2">
                                    <label class="control-label text-left col-md-12">Item Group  </label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)">
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
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)">
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
                                  <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Batch No</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" name="batch_no" style="width:100%" onchange="getAvaliableQuantity(this)">
                                          <?php
                                          $max_qty=0;
                                             foreach($po_items['item_batch_list'] as $key_i2=>$value_batch1){
                                                
                                                 $selected='';
                                                if($po_items['batch_no']==$value_batch1['batch_no']){
                                                   $selected="selected";
                                                   $max_qty=$value_batch1['batch_qty'];
                                                }
                                             ?>
                                             





                                          <option value="<?= $value_batch1['batch_no']; ?>" <?= $selected; ?> data-item_rate_type="<?= isset($po_items['item_rate_type'])?$po_items['item_rate_type']:0 ?>" data-weight_per_rate="<?= isset($po_items['weight_per_rate'])?$po_items['weight_per_rate']:0 ?>" data-weight_per_qty="<?= isset($po_items['weight_per_qty'])?$po_items['weight_per_qty']:0 ?>"  data-item_weight="<?= isset($po_items['item_weight'])?$po_items['item_weight']:0 ?>" data-aviable_qty="<?= isset($po_items['available_qty'])?$po_items['available_qty']:0 ?>"data-expired_date="<?= isset($po_items['expired_date'])?$po_items['expired_date']:0 ?>"data-rate="<?= isset($po_items['rate'])?$po_items['rate']:0 ?>"><?= $value_batch1['batch_no'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                    
                                 </div>
                                  <div class="form-group col-md-12">
                                       <label class=""><b>Expired Date</b></label>
                                       <input class="form-control " type="text" placeholder="" name="expired_date"   value="<?= isset($po_items['expired_date'])?$po_items['expired_date']:0 ?>" disabled>
                                    </div>
                                     <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                              </td>
                     
                                 <td width="15%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Req.Qty</b></label>
                                       <input class="form-control " type="text" placeholder="" name="req_qty"   value="<?= $po_items['received_qty']; ?>">
                                    </div>






                                 </td>
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Issue Qty</b></label>
                                       <input type="text" class="form-control po_item_cal item_unit"  name="item_unit" value="<?= $po_items['received_qty']; ?>" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)" data-rule-availableQty="true"  data-rule-decimal="true" >
                                       <div class="form-group ">                                                                     
                                          <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id"  onchange="getBatchwiseUnitWise(this)">
                                                <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                             if($po_items['received_qty_unit']==$value_item2['id']){
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

                                    <div class="form-group col-md-12 m-t-20">
                                       <label class=""><b>Weight</b></label>
                                       <input class="form-control " type="text" placeholder=""  name="weight" value="<?= ($po_items['weight'])?$po_items['weight']:'' ?>">
                                       <div class="form-group ">                                                                     
                                          <select class="form-control custom-select select2" style="width:100%" name="weight_item_unit_id" id="weight_item_unit_id"  >
                                                <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                             if($po_items['weight_unit']==$value_item2['id']){
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
                                  
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Rate</b></label>


                                       <input class="form-control " type="text" placeholder="" name="rate"   value="<?= $po_items['rate']; ?>" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)">
                                    </div>

                                    <div class="form-group col-md-12">
                                       <label class=""><b>Amount</b></label>
                                       <input class="form-control " type="text" placeholder="" name="amount"   id="" value="<?= $po_items['amount']; ?>">
                                    </div>

                                    <div class="form-group col-md-12 m-t-15 display_issued_to" id="">
                                       <label class=""><b>Issue To</b></label>
                                    
                                       <div class="form-check">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="1">
                                          <label class="form-check-label" for="exampleRadios1">
                                             Party/Employee
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="2">
                                          <label class="form-check-label" for="exampleRadios2">
                                          Veh.
                                          </label>
                                       </div>
                                       <div class="form-check ">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="3" >
                                          <label class="form-check-label" for="exampleRadios3">
                                          Other
                                          </label>
                                       </div>



                                       <div class="form-group row emp_issued_to m-t-5" id="emp_issued_to" name="emp_issued_to" style="display:none;">
                                          <label style="padding-right:0px" class="control-label col-md-6"><b>Party/Employee Name</b></label>
                                          <div class="col-md-6" style="padding-left:0px">
                                             <!-- loaded_party_id -->
                                             <select class="form-control select2 vender_name"  id="" name="emp_issued_to_id"  style="width:100%;">
                                                  <?php
                                                if(isset($vendor_master) && !empty($vendor_master)){
                                                foreach ($vendor_master as $key => $value) {
                                                    
                                                 ?>  
                                               <option value="<?= $value['id'] ?>"  ><?= $value['account_name'] ?></option>
                                            <?php } 
                                                }
                                            ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="form-group row vehicle_issed_to m-t-5" id="" name="vehicle_issed_to" style="display:none;">
                                          <label class="control-label col-md-6"><b>Vehicle Name</b></label>
                                          <div class="col-md-6">
                                             <!-- loaded_party_id -->
                                            <input type="text" name="vehicle" class="form-control">
                                          </div>
                                       </div>

                                       <div class="form-group row other_issued m-t-5" id="" name="other_issued" style="display:none;">
                                          <label class="control-label col-md-6"><b>Other</b></label>
                                          <div class="col-md-6">
                                             <!-- loaded_party_id -->
                                             <input type="text" name="other_text" class="form-control">
                                          </div>
                                       </div>
                                    </div>

                                    <div class="form-group col-md-12 m-t-10">
                                       <div class="form-group row">
                                          <div class="col-md-5 mt-1">
                                             <label style="margin-right:10px;"><b>Is Retunable</b></label>
                                             <input type="checkbox" name="is_returnable" value="1">
                                          </div>
                                          <div class="col-md-7 mt-1">
                                             <input class="form-control " type="date" placeholder="" name="returnable_date"   >
                                          </div>
                                       </div>
                                    </div>

                                    </div>
                                 </td>
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12 ">
                                       <label class=""><b>Remark</b></label>
                                       <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="material_issue_remark"></textarea>
                                    </div>
                                 </td>
                                 <td width="3%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12" align="center" style="padding:0px;">
                                      <button data-repeater-delete class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                    </div>
                                 </td>
                                
                              </tr>
                           </tbody>
                            </table> 
                            <?php
                           } //foreach po item end
                           ?>
                        <?php
                            else:
                        ?>
                         <table class="table table-bordered main_tbl_reapter" style="background:#eff1f3" data-repeater-item>
                           <tbody>
                              <tr name="tr_name">
                                 <td width="20%" style="border-color: #ffffff;">
                                 <input type="hidden" class="form-control" name="available_qty" >

                                    <div class="form-group m-t-20">
                                       <label class="control-label text-left col-md-12">Item Group</label>
                                       <div class="col-md-12">
                                          <select class="form-control custom-select select2 item_group_select2"  name="item_group_id" style="width:100%" onchange="getItemList(this)">
                                             <option></option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group m-t-20">
                                       <label class="control-label text-left col-md-12">Items</label>
                                       <div class="col-md-12">
                                          <select class="form-control custom-select select2 po_items_select po_items_sel"  name="items_id" style="width:100%" onchange="getItemUnits(this)">
                                             <option></option>
                                          </select>
                                       </div>
                                      
                                    </div>
                                    <div class="form-group m-t-20">
                                       <label class="control-label text-left col-md-12">Items Batch</label>
                                       <div class="col-md-12">
                                          <select class="form-control custom-select select2"  name="batch_no" style="width:100%" onchange="getAvaliableQuantity(this)">
                                          </select>
                                       </div>
                                    </div>
                                     <div class="form-group col-md-12">
                                       <label class=""><b>Expired Date</b></label>
                                       <input class="form-control " type="text" placeholder="" name="expired_date"   value="" disabled>
                                    </div>
                                    <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                                 </td>
                                 <td width="15%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Req.Qty</b></label>
                                       <input class="form-control " type="text" placeholder="" name="req_qty"   value="">
                                    </div>
                                 </td>
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Issue Qty</b></label>
                                       <input type="text" class="form-control po_item_cal  item_unit"  name="item_unit" value="0" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)" data-rule-availableQty="true"  data-rule-decimal="true">
                                       <div class="form-group ">                                                                     
                                          <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id" onchange="getBatchwiseUnitWise(this)">
                                          </select>
                                       </div>
                                    </div>

                                    <div class="form-group col-md-12 m-t-20">
                                       <label class=""><b>Weight</b></label>
                                       <input class="form-control " type="text" placeholder=""  name="weight" value="">
                                       <div class="form-group ">                                                                     
                                          <select class="form-control custom-select select2" style="width:100%" name="weight_item_unit_id" id="weight_item_unit_id"  >
                                          </select>
                                       </div>
                                    </div>
                                 </td>
                                  
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12">
                                       <label class=""><b>Rate</b></label>
                                       <input class="form-control " type="text" placeholder="" name="rate"   value="0" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)">
                                    </div>

                                    <div class="form-group col-md-12">
                                       <label class=""><b>Amount</b></label>
                                       <input class="form-control " type="text" placeholder="" name="amount"   id="" value="" readonly>
                                    </div>

                                    <div class="form-group col-md-12 m-t-15 display_issued_to" id="">
                                       <label class=""><b>Issue To</b></label>
                                    
                                       <div class="form-check">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="1">
                                          <label class="form-check-label" for="exampleRadios1">
                                             Party/Employee
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="2">
                                          <label class="form-check-label" for="exampleRadios2">
                                          Veh.
                                          </label>
                                       </div>
                                       <div class="form-check ">
                                          <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="3" >
                                          <label class="form-check-label" for="exampleRadios3">
                                          Other
                                          </label>
                                       </div>
                                       <div class="form-group row emp_issued_to m-t-5" id="emp_issued_to" name="emp_issued_to" style="display:none;">
                                          <label style="padding-right:0px" class="control-label col-md-6"><b>Party/Employee Name</b></label>
                                          <div class="col-md-6" style="padding-left:0px">
                                             <!-- loaded_party_id -->
                                             <select class="form-control select2 vender_name"  id="" name="emp_issued_to_id"  style="width:100%;">
                                             </select>
                                          </div>
                                       </div>

                                       <div class="form-group row vehicle_issed_to m-t-5" id="" name="vehicle_issed_to" style="display:none;">
                                          <label class="control-label col-md-6"><b>Vehicle Name</b></label>
                                          <div class="col-md-6">
                                             <!-- loaded_party_id -->
                                            <input type="text" name="vehicle" class="form-control">
                                          </div>
                                       </div>

                                       <div class="form-group row other_issued m-t-5" id="" name="other_issued" style="display:none;">
                                          <label class="control-label col-md-6"><b>Other</b></label>
                                          <div class="col-md-6">
                                             <!-- loaded_party_id -->
                                             <input type="text" name="other_text" class="form-control">
                                          </div>
                                       </div>
                                    </div>

                                    <div class="form-group col-md-12 m-t-10">
                                       <div class="form-group row">
                                          <div class="col-md-5 mt-1">
                                             <label style="margin-right:10px;"><b>Is Retunable</b></label>
                                             <input type="checkbox" name="is_returnable" value="1">
                                          </div>
                                          <div class="col-md-7 mt-1">
                                             <input class="form-control " type="date" placeholder="" name="returnable_date"   >
                                          </div>
                                       </div>
                                    </div>
                                    </div>
                                 </td>
                                 <td width="20%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12 ">
                                       <label class=""><b>Remark</b></label>
                                       <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="material_issue_remark"></textarea>
                                    </div>
                                 </td>
                                 <td width="3%" style="border-color: #ffffff;">
                                    <div class="form-group col-md-12" align="center" style="padding:0px;">
                                      <button data-repeater-delete class="btn btn-danger btn-theme" type="button" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                    </div>
                                 </td>
                                
                              </tr>
                           </tbody>
                        </table>
                        <?php
                           endif; //update item id
                           ?>
                     
                       
                     </div>
                     <hr>


                     <hr>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Request By</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 user_name" name="request_by" id="req_id" required>
                                    <?php
                                        foreach ($request_by as $key => $value) {
                                          if((isset($issue_info['request_by'])&&$issue_info['request_by']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['request_user_name'] ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Issued By</b></label>
                              <div class="col-md-6">
                                 <input type="hidden" name="issued_by_id" class="form-control" id="issued_by" value="<?= isset($user_data['id'])?$user_data['id']:'';?>">
                                 <?php $issued_by_name = $user_data['first_name']." ".$user_data['last_name'];?>
                                 <input type="text" name="" class="form-control" readonly id="" value="<?= isset($issued_by_name)?$issued_by_name:'';?>">
                              
                                 <!-- <select class="form-control select2 user_name" name="issued_by" id="issued_by">
                                    <option>Select</option>
                                    <option>Sri Lanka</option>
                                 </select> -->
                              </div>
                           </div>
                        </div>

                        <div class="col-md-2">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Department</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 department_name" id="" name="department_id" required>
                                    <option></option>
                                    <?php
                                        foreach ($department_name as $key => $value) {
                                          if((isset($issue_info['department_id'])&&$issue_info['department_id']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['role_name'] ?></option>
                                    <?php } ?>
                                 </select>
                                 <label id="department-error" class="error sd" for="department">This field is .</label>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Received By</b></label>
                              <div class="col-md-5">
                                 <select class="form-control select2 user_name" name="received_by_id" id="received_by" required>
                                    <?php
                                        foreach ($received_by as $key => $value) {
                                          if((isset($issue_info['received_by_id'])&&$issue_info['received_by_id']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['received_user_name'] ?></option>
                                    <?php } ?>

                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value="1" name="is_print_material_issue" id="exampleCheck1" <?= (isset($issue_info['is_print_material_issue']) && $issue_info['is_print_material_issue']==1)?"checked":''; ?> >
                                    <label class="form-check-label" for="exampleCheck1"><b>Print Material Issue</b></label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        


                        <!-- <div class="col-md-2">
                           <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Print Material Issue</label>
                           </div>
                           </div> -->
                     </div>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Remark</b></label>
                              <div class="col-md-6">
                                 <textarea class="form-control" name="remark" id="exampleFormControlTextarea1" rows="3"><?= isset($issue_info['remark'])?$issue_info['remark']:'';?></textarea>
                              </div>
                           </div>
                        </div>



                        <div class="col-md-5 bg-diffrent">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Attach a file</b></label>
                              <div class="col-md-7">
                                 <div class="file-upload-contain">
                                    <?php if(isset($material_attachement)){ ?>
                                           
                                        <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                                          <?php foreach($material_attachement as $key1=>$val){?>
                                             <div class="file-preview-frame file-sortable  kv-preview-thumb remove_material_file_attch(<?= $val['id']?>)" id="remove_material_file_attch_<?= $val['id']?>" data-template="image">
                                                <input type="hidden" class="form-control" id="remove_material_file_attch_id_<?= $val['id']?>" name="file_name_id[]" value="<?= $val['id']?>" multiple />
                                                <div class="kv-file-content">
                                                </div>
                                                <div class="file-thumbnail-footer">
                                                <div class="file-detail">
                                                <div class="file-caption-name" style="color: black;"><?= $val['file_name']?></div>
                                                </div>   
                                                <div class="file-actions">
                                                   <div class="file-footer-buttons">
                                                      <button type="button" onclick= "remove_material_file_attch(<?= $val['id']?>)" class="kv-file-remove file-remove" title="Remove file"><i class="fa fa-times"></i></button>
                                                   </div>
                                                </div>
                                                <span class="file-drag-handle drag-handle-init text-primary" title="Move / Rearrange"><i class="bi-arrows-move"></i></span>
                                                <div class="clearfix"></div>
                                                </div>

                                             <div class="kv-zoom-cache"></div>
                                          </div>
                                          
                                       <?php } }else{?>
                                         
                                                <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="col-md-5">
                           <div class="form-group row">
                             <label for="">Attach a file:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <input type="file" id="" name="" accept="image/png, image/jpeg" />
                           </div>
                           </div> -->
                     </div>
                  </div>
                  <!--<input type="submit" id="btnsubmit"  value="Submit">-->
                    <button type="button" class="btn btn-success btn-theme float-right"style="margin-left: 94%;"onclick="submitIssue()">Submit</button>
                   
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/matrial_issue_repeter.int.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/Auto-TabIndex-master/autotabindex.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/store/matrial_issue.js?v=1.0.1"></script>
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>

 
    <!-- <script src="../assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../assets/node_modules/daterangepicker/daterangepicker.js"></script> -->

<script>

   $(document).ready(function () {
     
      $('#frm_issue').validate();
        //   var validator = $(this[0].form).validate();
        
   });

  
   $(document).ready(function() { 
   $(".numberonly").attr("maxlength", "10");
       $(".numberonly").keypress(function(e) {
          var kk = e.which;
           if(kk < 48 || kk > 57)
           e.preventDefault();
       });
    });
   

   $('#type_consumption').on('change', function() {
      var type_consumption = $( 'input[name=issue_type]:checked' ).val();
      // alert(type_consumption);
      if (type_consumption == 2) {
        $("#issue_to_location_site_id").show();
        $("#flat").hide();
        $("#floor").hide();
        $("#stock_at_vendor").hide();
        $(".display_issued_to").show();


      } else if(type_consumption == 1){
         $("#flat").show();
         $("#floor").show();
         $("#issue_to_location_site_id").hide();
         $("#stock_at_vendor").show();
         $(".display_issued_to").show();
      
      }else if(type_consumption == 3){
         $("#flat").hide();
         $("#floor").hide();
         $("#issue_to_location_site_id").hide();
         $("#stock_at_vendor").hide();
         $(".display_issued_to").hide();
      }
    });
   

   function automake_gatepassCheckbox(){
            let is_auto_make_gate=$("input[type='checkbox'][name='is_auto_make_gate']:checked").val();
            var timestamp = new Date().getTime();
            // Generate a random number (between 0 and 9999)
            var random = Math.floor(Math.random() * 100);
            // Combine prefix, timestamp, and random number to create a unique code
            var uniqueCode = "GATE-PASS"+company_id+"-"+ timestamp+"-"+ random;
    
               // console.log(is_auto_make_gate)
            if(is_auto_make_gate){
                $('.gate_pass_no').attr("disabled", "disabled");;
                $('#gate_pass_no').val(uniqueCode);
            }else{
                 $('.gate_pass_no').removeAttr("disabled");
                
            }
            
            // $('.no_displable_box').removeAttr("disabled");
    }   

 $('#vehicle_n').on('change', function() {
        var vehicle_n =$( 'input[name=vehicle_no]:checked' ).val();
        // console.log(vehicle_no)
        if (vehicle_n == 1) {
          $('#carrying_vehicle_no').show();
          $('#reading').show();
          $('#text_vehicle_no').hide();

        } else {
          $('#carrying_vehicle_no').hide();
           $('#text_vehicle_no').show();
            $('#reading').hide();
        }
      });

 $('#loaded_via').on('change', function() {
        var loaded_via =$( 'input[name=is_loaded_via]:checked' ).val();
         // alert(loaded_via)
        if (loaded_via == 2) {
          $('#loaded_party_id').show();
          
        }else{
         $('#loaded_party_id').hide();
        }
      });

$('#self_party_stock').on('change', function() {
        var self_party_stock =$( 'input[name=issue_from]:checked' ).val();
        // console.log(vehicle_no)
        var type_consumption = $( 'input[name=issue_type]:checked' ).val();
        // var transfer_id = $('#transfer').val();

// alert(transfer_id);alert(self_party_stock);
        if (self_party_stock == 1) {
          $('#customer_id').show();
          $("#issue_to_location_site_id").hide();
        }
        else
         if(self_party_stock == 1 && type_consumption==1){
         $('#customer_id').show();
          $("#issue_to_location_site_id").hide();

        }else
         if(self_party_stock == 1 && type_consumption==2){
         $('#customer_id').hide();
          $("#issue_to_location_site_id").hide();

        }
        else if(self_party_stock == 2 && type_consumption==1){
         $('#customer_id').hide();
          $("#issue_to_location_site_id").hide();

        }else if(self_party_stock == 2 && type_consumption==2){
         $('#customer_id').hide();
         $("#issue_to_location_site_id").show();

        } 
        else {
          $('#customer_id').hide();
           
        }
      });



    // jQuery('#datepicker-autoclose').datepicker({
    //     autoclose: true,
    //     todayHighlight: true,
    // });
    var date = new Date();
    date.setDate(date.getDate());
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
   
        
    jQuery('#datepicker-autoclose').datepicker({ 
            // startDate: date,
            defaultDate: today,
            format: 'dd/mm/yyyy',
    });

    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true,
         format: 'dd/mm/yyyy',
    });

    $('body').autotabindex(
    {
      list: '#po_date,'
    });
    // Clock pickers
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
</script>
