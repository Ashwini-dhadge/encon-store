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
            <form class="repeater" method="post" action="<?= base_url('admin/store/ReceiveMaterials/add_receviedmaterialissue');?>" id="frm_issue" enctype="multipart/form-data"class="form-horizontal" autocomplete="off">
               <div class="row">
                  <input type="hidden" name="id" id="id" value="<?= (isset($id))? $id : '' ?>">
                 
                  <input type="hidden" name="issue_id" id="issue_id" value="<?= (isset($material_issue['id']))? $material_issue['id'] : '' ?>">

                  <input type="hidden" name="company_id" id="company_id" value="<?= (isset($material_issue['company_id']) && $material_issue['company_id'])? $material_issue['company_id'] : userId('company_id');  ?>">
                  <input type="hidden" name="site_id" id="site_id" value="<?= (isset($material_issue['site_id']) && $material_issue['site_id'])? $material_issue['site_id'] : userId('site_id');  ?>">
                  <input type="hidden" name="financial_year_id" id="financial_year_id" value="<?= (isset($material_issue['financial_year_id']) && $material_issue['financial_year_id'])? $material_issue['financial_year_id'] : userId('financial_year_id');  ?>">
                
                
                
                  <?php
                 
                    
                        $unqie_no="TRF-".userId('company_id')."-".userId('site_id')."-".userId('user_id')."-".rand(0,999);
                        
                  ?>
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color">
                              <h6><b>Add Received Material Issue</b></h6>
                           </span>
                           <hr>
                        </div>
                        <div class="form-group col-md-3 ">
                           <label class=""><b>Received Material No</b></label>
                           <?php
                           
                           ?>
                           <input type="text" class="form-control" name="received_no" readonly value="<?= $unqie_no;?>">
                        </div>

                        <div class="form-group col-md-3 ">
                           <label class=""><b>Recevied Date</b></label>
                             <div class="input-group">
                                  <?php
                                        if(isset($id)){
                                            $class_name="mydatepicker";
                                        }else{
                                            $class_name="precurdatepicker";
                                        }
                                     ?>
                                 <input type="text" class="form-control <?= $class_name; ?>" name="received_date" id="datepicker-autoclose" value="<?= date('d/m/Y') ?>">
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                             </div>
                        </div>

                        <div class="form-group col-md-3 ">
                           <label class=""><b>Time</b></label>

                            <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="time-local" class="form-control" value="<?= date('H:i:s') ?>" name="received_time">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                       
        
                        <div class="col-md-6">
                           <div class="form-group row" >
                              <label class="control-label col-md-6"><b>Recevied Location</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 issue_to_location_site_id"  id="received_location_site_id" name="received_location_site_id" style="width: 100%;" disabled>
                                          <?php
                                        //   print_r($material_issue);
                                        if(isset($material_issue['issue_to_location_site_id']) && !empty($material_issue['issue_to_location_site_id'])){
                                           foreach ($site_master as $key1 => $sites) {
                                             if((isset($material_issue['issue_to_location_site_id'])&&$material_issue['issue_to_location_site_id']==$sites['id'])){
                                              $selected="selected";
                                               }else{
                                               $selected="";
                                             } ?>
                                          <option value="<?= $sites['id'] ?>"  <?= $selected; ?>><?= $sites['site_name'] ?></option>
                                       <?php } 
                                           }
                                       ?>
                                    </select>
                                 
                               <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>
                        </div>
                        
                        <div class="form-group col-md-3 ">
                          
                              <div class="form-group row" >
                                 <label class="control-label col-md-3"><b>From Location</b></label>
                                 <div class="col-md-8">
                                    <select class="form-control select2 issue_to_location_site_id"  id="issue_from_location_site_id" name="issue_from_location_site_id" style="width: 100%;" disabled>
                                          <?php
                                          print_r($material_issue);
                                        if(isset($material_issue['issue_location_site_id']) && !empty($material_issue['issue_location_site_id'])){
                                           foreach ($site_master as $key1 => $sites) {
                                             if((isset($material_issue['issue_location_site_id'])&& $material_issue['issue_location_site_id']==$sites['id'])){
                                              $selected="selected";
                                               }else{
                                               $selected="";
                                             } ?>
                                          <option value="<?= $sites['id'] ?>"  <?= $selected; ?>><?= $sites['site_name'] ?></option>
                                       <?php } 
                                           }
                                       ?>
                                    </select>
                                    <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                                 </div>
                              </div>
                        </div>
                     
                      
                        <div class="form-group col-md-3 ">
                        </div>
                         <?php
                                    $gate_pass_no=$rst_no='';
                                     if(isset($material_issue['gate_pass_no'])){
                                        $gate_pass_no= $material_issue['gate_pass_no'];
                                     }
                                     
                                    
                                  ?>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Gate Pass No</b></label>
                              <div class="col-md-6">
                                 <input class="form-control gate_pass_no " type="text" placeholder="" id="gate_pass_no" name="gate_pass_no" value="<?= isset($material_issue['gate_pass_no'])?$material_issue['gate_pass_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                          <div class="col-md-8" style="font-weight: bold;">
                              <input type="checkbox"  value="1" id="is_auto_make_gate" name="is_auto_make_gate" <?= (isset($material_issue['is_auto_make_gate']) && $material_issue['is_auto_make_gate']==1)?"checked":''; ?> onclick="automake_gatepassCheckbox()" ><label class="did-floating-label" style="top:0px;margin-left: 20px;"><b>Auto Make Gate Pass No.(On Edit It Will Not Work)</b></label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Is Our Carrying Vehicle</b></label>
                              <div class="col-md-6">
                                 <input type="checkbox" id="vehicle_no" value="1"  name="is_our_carrying_vehicle" <?= (isset($material_issue['is_our_carrying_vehicle']) && $material_issue['is_our_carrying_vehicle']==1)?"checked":''; ?>><label class="did-floating-label" style="top:0px;margin-left: 3px;">Carrying Vehicle No.</label>
                                 <!-- carrying_vehicle_no -->
                                 <input class="form-control" type="text" placeholder="" name="carrying_vehicle_no" value="<?= isset($material_issue['carrying_vehicle_no'])?$material_issue['carrying_vehicle_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Carrying Vehicle Driver</b></label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="carrying_vehicle_driver"   value="<?= isset($material_issue['carrying_vehicle_driver'])?$material_issue['carrying_vehicle_driver']:'';?>">
                              </div>
                              <label class="control-label col-md-6"><b>Carrying Vehicle Reading</b></label>
                              <div class="col-md-6 m-t-5">
                                 <!-- carrying_vehicle_reading -->
                                 <input class="form-control " type="text" placeholder="" name="carrying_vehicle_reading"  value="<?= isset($material_issue['carrying_vehicle_reading'])?$material_issue['carrying_vehicle_reading']:'';?>">
                              </div>
                        </div>
 

 
                           
                           <div class="form-group row" id="loaded_via">
                              <label class="control-label col-md-6"><b>Loaded Via</b></label>
                              <div class="col-md-6">
                                 <label class="radio-inline">
                                 <input type="radio" name="is_loaded_via" value="1" checked <?= (isset($material_issue['is_loaded_via']) && $material_issue['is_loaded_via']==1)?"checked":''; ?>>&nbsp;&nbsp;Self
                                 </label>
                                 <label class="radio-inline" >
                                 <input type="radio" name="is_loaded_via" value="2" id="party" <?= (isset($material_issue['is_loaded_via']) && $material_issue['is_loaded_via']==2)?"checked":''; ?>>&nbsp;&nbsp;Party
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
                                             if((isset($material_issue['loaded_party_id'])&&$material_issue['loaded_party_id']==$value['id'])){
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
                                          if((isset($material_issue['transporter_id'])&&$material_issue['transporter_id']==$value['id'])){
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
                                     if(isset($material_issue['manual_slip_no'])){
                                        $manual_slip_no= $material_issue['manual_slip_no'];
                                     }
                                     if(isset($material_issue['rst_no'])){
                                        $rst_no= $material_issue['rst_no'];
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
                                 <input class="form-control " type="text" placeholder="" required name="indend_no"   value="<?= isset($material_issue['indend_no'])?$material_issue['indend_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>RST No</b></label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="rst_no" value="<?= isset($material_issue['rst_no'])?$material_issue['rst_no']:'';?>">
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
                        <!--<div class="col-md-6" align="right">-->
                        <!--   <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme">Add</button></a>-->
                        <!--</div>-->
                     </div>
                     <hr>
                     <div class="table-responsive" data-repeater-list="material_items" id="item_group_tables">
                   
                        <?php
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
                                        <input type="hidden" class="form-control" name="old_issue_qty" value="<?= isset($items['issue_qty'])?$items['issue_qty']:0 ?>">
                                        <input type="hidden" class="form-control" name="received_issue_qty" value="<?= isset($items['received_qty'])?$items['received_qty']:0 ?>">
                                        <input type="hidden" class="form-control" name="old_issue_qty_unit" value="<?= isset($items['issue_qty_unit'])?$items['issue_qty_unit']:0 ?>">
                                        <?php
                                            if(isset($items['received_qty']) && $items['received_qty'] !=0){
                                                $max=$items['pending_qty'];
                                            }else{
                                                $max=$items['issue_qty'];
                                            }
                                        ?>
                                        
                                        <input type="hidden" name="delete_type" value="3">
                                        <label class="control-label text-left col-md-12">Item Group  </label>
                                        <div class="col-md-12">
                                           <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)" disabled>
                                              <?php
                                                if($items['item_group_id']==0){
                                                    echo '  <option value="0">All</option>';
                                                }else{
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
                                                }
                                                 ?>
                                           </select>
                                        </div>
                                     </div>
                                     <div class="form-group ">
                                        <label class="control-label text-left col-md-12">Items <?php echo $items['item_id']; ?></label>
                                        <div class="col-md-12">
                                           <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)" disabled>
                                              <?php
                                                 foreach($items['item_name'] as $key_i1=>$value_item1){
                                                     
                                                    // echo $items['item_id']."_".$value_item1['id'];     
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
                                           <select class="form-control custom-select select2 po_items_select" name="batch_no" style="width:100%" onchange="getAvaliableQuantity(this)" disabled>
                                              <?php
                                              $max_qty=0;
                                                 foreach($items['item_batch_list'] as $key_i2=>$value_batch1){
                                                    
                                                     $selected='';
                                                    if($items['batch_no']==$value_batch1['batch_no']){
                                                       $selected="selected";
                                                       $max_qty=$value_batch1['batch_qty'];
                                                    }
                                                 ?>
                                              <option value="<?= $value_batch1['batch_no']; ?>" <?= $selected; ?> data-aviable_qty="<?= isset($po_items['available_qty'])?$po_items['available_qty']:0 ?>" ><?= $value_batch1['batch_no'] ?></option>
                                              <?php
                                                 }
                                                 ?>
                                           </select>
                                           
                                        </div>
                                        <div class="col-md-12">
                                           <label class=""><b>Expired Date</b></label>
                                           <input class="form-control " type="text" placeholder="" name="expired_date"   value="<?= $items['expired_date']; ?>" disabled>
                                        </div>
                                        
                                     </div>
                                    
                                    </td>
                         
                                    <td width="20%" style="border-color: #ffffff;">
                                        <div class="form-group col-md-12">
                                           <label class=""><b>Recevied Qty</b></label>
                                           <input type="text" class="form-control po_item_cal numberonly item_unit"  name="item_unit" value="<?= $max; ?>" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)"  max="<?= $max; ?>" >
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
                                           <input class="form-control " type="text" placeholder="" name="rate"   value="<?= $items['rate']; ?>" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)" >
                                        </div>
    
                                        <div class="form-group col-md-12">
                                           <label class=""><b>Amount</b></label>
                                           <input class="form-control " type="text" placeholder="" name="amount"   id="" value="<?= $items['amount']; ?>">
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
                        
                  
                       
                     </div>
                     <hr>


                     <hr>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Received By</b></label>
                              <div class="col-md-6">
                                  <select class="form-control select2 user_name" name="received_by_id" id="received_by" required>
                                   

                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Transfered By</b></label>
                              <div class="col-md-6">
                                 <input type="hidden" name="issued_by_id" class="form-control" id="issued_by" value="<?= isset($material_issue['issued_by'])?$material_issue['issued_by']:'';?>">
                                 <?php $issued_by_name = $user_data['first_name']." ".$user_data['last_name'];?>
                                 <input type="text" name="" class="form-control" readonly id="" value="<?= isset($material_issue['issued_by_name'])?$material_issue['issued_by_name']:'';?>">
                              
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
                              <label class="control-label col-md-3"><b>Remark</b></label>
                              <div class="col-md-6">
                                 <textarea class="form-control" name="remark" id="exampleFormControlTextarea1" rows="3"><?= isset($material_issue['remark'])?$material_issue['remark']:'';?></textarea>
                              </div>
                           </div>
                        </div>
                          <div class="col-md-5">
                           <div class="form-group row">
                               <div class="col-md-6">
                               <div class="form-check custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input form-check-input" id="is_material_issue" name="is_material_issue" value="1" <?= (isset($grn_info['is_material_issue'])&&($grn_info['is_material_issue']==1))?'checked':''; ?>>
                                    <label class="custom-control-label form-check-label" for="is_material_issue">is Material Issue</label>
                                 </div>
                                 </div>
                            </div>
                            </div>
                    </div>
                
                    <div class="row">
                              <div class="col-md-offset-3 col-md-12" style="text-align: center;">
                                 
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
<script src="<?= base_url(); ?>assets/js/page-js/store/matrial_issue.js"></script>
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
   

    var date = new Date();
    date.setDate(date.getDate());
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
   
         $('.precurdatepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: new Date(), // Prevents selecting future dates
        autoclose: true,
        todayHighlight: true
    });

    $('.mydatepicker').datepicker({
    defaultDate: "today",
      format: 'dd/mm/yyyy',
   });
    // jQuery('#datepicker-autoclose').datepicker({ 
    //         // startDate: date,
    //         defaultDate: today,
    //         format: 'dd/mm/yyyy',
    // });
</script>
