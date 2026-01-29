<?php init_header(); ?>

 <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">

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
            <?php
                if(isset($return_issue_date)){
                    $return_issue_date=date('d/m/Y',strtotime($return_issue_date));
                }else{
                    $return_issue_date=date('d/m/Y');
                }
                
            ?>
            <form class="repeater" method="post" action="<?= base_url('admin/store/MaterialIssueReturn/add_materialissue_return');?>" id="frm_issue" enctype="multipart/form-data"class="form-horizontal" autocomplete="off">
               <div class="row">
                   <input type="hidden" name="id" id="id" value="<?= (isset($material_issue_return['id']))? $material_issue_return['id'] : '' ?>">
                   <input type="hidden" name="material_issue_return_id" id="material_issue_return_id" value="<?= (isset($material_issue_return['id']))? $material_issue_return['id'] : '' ?>">

                  <input type="hidden" name="company_id" id="company_id" value="<?= userId('company_id');?>">
                  <input type="hidden" name="site_id" id="site_id" value="<?= userId('site_id');?>">
                  <input type="hidden" name="financial_year_id" id="financial_year_id" value="<?= userId('financial_year_id');?>">

                  
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color">
                              <h6><b>Return Material </b></h6>
                           </span>
                           <hr>
                        </div>
                        <div class="form-group col-md-3 ">
                           <label class=""><b>M. Rtn. No</b></label>
                           <?php
                            $unqie_no="RTN_NO-".userId('company_id')."-".userId('site_id')."-".userId('user_id')."-".rand(0,999);
                           ?>
                           <input type="text" class="form-control" name="m_rtn_no" readonly value="<?= isset($m_rtn_no)?$m_rtn_no: $unqie_no;?>"

                           value="">
                        </div>

                        <div class="form-group col-md-3 ">
                           <label class=""><b>Return Date</b></label>
                             <div class="input-group">
                                 <input type="text" class="form-control" name="return_issue_date" id="datepicker-autoclose" value="<?= isset($return_issue_date)?$return_issue_date:date('Y-m-d');?>">
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                             </div>
                        </div>

                        <div class="form-group col-md-4 "></div>
                        <div class="form-group col-md-3">
                           <label class="control-label"><b>Return Type 
                              </b></label>
                        </div>
                    

                        <div class="form-group col-md-6" id="type_consumption">

                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="1" name="issue_type" id="consumption" <?= (isset($issue_type) && $issue_type==1)?"checked":''; ?> >
                              <label class="form-check-label" for="inlineRadio1" ><b>Consumption/Issue</b></label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="2" name="issue_type" id="transfer" <?= (isset($issue_type) && $issue_type==2)?"checked":''; ?> >
                              <label class="form-check-label" for="inlineRadio2"><b>Transfer</b></label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="3" name="issue_type" id="production" <?= (isset($issue_type) && $issue_type==3)?"checked":'checked'; ?> >
                              <label class="form-check-label" for="inlineRadio3"><b>Production</b></label>
                           </div>
                           <!--<div class="form-check form-check-inline">-->
                           <!--   <input class="form-check-input" type="radio" value="4" name="issue_type" id="scrap" <?= (isset($issue_type) && $issue_type==4)?"checked":''; ?> >-->
                           <!--   <label class="form-check-label" for="inlineRadio4"><b>Scrap</b></label>-->
                           <!--</div>-->
                           <!--<div class="form-check form-check-inline">-->
                           <!--   <input class="form-check-input" type="radio" value="5" name="issue_type" id="wastage" <?= (isset($issue_type) && $issue_type==5)?"checked":''; ?> >-->
                           <!--   <label class="form-check-label" for="inlineRadio5"><b>Wastage</b></label>-->
                           <!--</div>-->
                           <!--<div class="form-check form-check-inline">-->
                           <!--   <input class="form-check-input" type="radio" value="6" name="issue_type" id="re_usable" <?= (isset($issue_type) && $issue_type==6)?"checked":''; ?> >-->
                           <!--   <label class="form-check-label" for="inlineRadio6"><b>Re-Usable</b></label>-->
                           <!--</div>-->
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="7" name="issue_type" id="fresh" <?= (isset($issue_type) && $issue_type==7)?"checked":''; ?> >
                              <label class="form-check-label" for="inlineRadio7"><b>Fresh</b></label>
                           </div>
                        </div>
                       
                        <div class="col-md-6" id="stock_at_vendor" <?= (isset($issue_type) && $issue_type == 1)? 'style="display: block;"' : 'style="display: none;"' ?>>
                           <div class="form-group row"  >
                              <label class="control-label  col-md-6"><b>Consumption/Issue From Stock At Vendor</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 vender_name" id="account_name" name="issue_from_vendor_id" style="width:100%">
                                    <?php
                                        if(isset($vendor_name) && !empty($vendor_name)){
                                        foreach ($vendor_name as $key => $value) {
                                          if((isset($issue_from_vendor_id)&&$issue_from_vendor_id==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['vendor_name'] ?></option>
                                    <?php } 
                                        }
                                    ?>
                                 </select>
                                 <small id="emailHelp" class="form-text" style="color:#6610f2 ;">(Select If Consumption/Issue Form Vender)</small>
                              </div>
                           </div>
                        </div>
                         <div class="col-md-12"></div>


                        <div class="col-md-6">
                           <div class="form-group row" >
                              <label class="control-label col-md-6"><b>Return Location</b></label>
                              <div class="col-md-6">
                                 <input type="hidden" name="return_issue_location" class="form-control site_id" id="site_id" value="<?= isset($issue_location['id'])?$issue_location['id']:'';?>">
                                 <input type="text" name="" class="form-control" readonly id="" value="<?= isset($issue_location['site_name'])?$issue_location['site_name']:'';?>">
                               <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>
                        </div>
                        
                        <div class="form-group col-md-4 ">
                           <div id="issue_to_location_site_id" <?= (isset($issue_from) && $issue_from == 2)? 'style="display: block;"' : 'style="display: none;"' ?>>
                              <div class="form-group row" >
                                 <label class="control-label col-md-3"><b>From Location</b></label>
                                 <div class="col-md-8">
                                    <select class="form-control select2 issue_to_location_site_id"  id="issue_to_location_site_id" name="from_location_id" style="width: 100%;" >
                                       <?php
                                    //   print_r($issue_location);die;
                                          
                                          if(isset($tbl_site) && !empty($tbl_site)){
                                              
                                           foreach ($tbl_site as $key => $value) {
                                             if((isset($from_location_id)&&$from_location_id==$value['id'])){
                                              $selected="selected";
                                               }else{
                                               $selected="";
                                             } ?>
                                          <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['site_name'] ?></option>
                                       <?php } 
                                           }
                                       ?>
                                          
                                    </select>
                                    <label id="issue_to_location_site_id-error" class="error sd" for="issue_location">This field is .</label>
                                 </div>
                              </div>
                           </div>

                           <div  id="customer_id" <?= (isset($issue_from) && $issue_from == 1)? 'style="display: block;"' : 'style="display: none;"' ?>> 
                              <div class="form-group row">
                                 <label class="control-label col-md-3"><b>Customer Name</b></label>
                                 <div class="col-md-9">
                                    <select class="form-control select2 vender_name"  id="customer_id" name="customer_id" style="width: 100%;" >
                                    </select>
                                    <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-2">
                        </div>
                     
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Gate Pass No</b></label>
                              <div class="col-md-6">
                                 <input class="form-control gate_pass_no " type="text" placeholder="" id="gate_pass_no" name="gate_pass_no" value="<?= isset($material_issue_return['gate_pass_no'])?$material_issue_return['gate_pass_no']:'';?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                          
                             
                           <div class="col-md-8" style="font-weight: bold;">
                              <input type="checkbox"  value="1" id="is_auto_make_gate" name="is_auto_make_gate" <?= (isset($material_issue_return['is_auto_make_gate']) && $material_issue_return['is_auto_make_gate']==1)?"checked":''; ?> onclick="automake_gatepassCheckbox()" ><label class="did-floating-label" style="top:0px;margin-left: 20px;"><b>Auto Make Gate Pass No.(On Edit It Will Not Work)</b></label>
                           </div>

                        </div>
                      <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6"><b>Is Our Carrying Vehicle</b></label>
                              <div class="col-md-6">
                                 <input type="checkbox" id="vehicle_no" value="1"  name="is_our_carrying_vehicle" <?= (isset($material_issue_return['is_our_carrying_vehicle']) && $material_issue_return['is_our_carrying_vehicle']==1)?"checked":''; ?>><label class="did-floating-label" style="top:0px;margin-left: 3px;">Carrying Vehicle No.</label>
                                 <!-- carrying_vehicle_no -->
                                 <!-- <input class="form-control  " type="text" placeholder="" name="carrying_vehicle_no" value="<//?= isset($grn_info['vehicle_no'])?$grn_info['vehicle_no']:'';?>"> -->
                              </div>
                           </div>
                        </div>


                         <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Carrying Vehicle No</b></label>

                              <div class="col-md-6">
                                  <input class="form-control  " type="text" placeholder="" name="carrying_vehicle_no" value="<?= isset($material_issue_return['carrying_vehicle_no'])?$material_issue_return['carrying_vehicle_no']:'';?>">

                              </div>
                             
                           </div>
                        
                     </div>

                     <div class="col-md-6">
                        <div class="form-group row rtn_frm_self">
                           <label class="control-label col-md-6"><b>Return From</b></label>
                           <div class="col-md-6">
                              <input type="checkbox" id="is_return_from" value="1"  name="is_return_from" <?= (isset($material_issue_return['is_return_from']) && $material_issue_return['is_return_from']==1)?"checked":''; ?>><label class="did-floating-label" style="top:0px;margin-left: 3px;">Self Stock.</label>
                            
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6"></div>

                    <div class="row col-md-12 m-t-10">
                        
                        <div class="col-md-8">
                           <span class="text-color">
                            <h6><b>Product Info</b></h6>
                           </span>
                        </div>
                        <div class="col-md-4" align="right">
                           <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme">Add</button></a>
                        </div>
                     </div>
                     <hr>
                     <div class="table-responsive" data-repeater-list="material_items" id="item_group_tables" style="padding: 10px;">
                      <?php
                    //   echo "<pre>";print_r($info_items_data);die;
                           if(isset($info_items_data)&& !empty($info_items_data)){
                           ?>
                        <?php
                           foreach ($info_items_data as $key1 => $dt_items) {
                           ?>
                           <table class="table table-bordered main_tbl_reapter"  data-repeater-item>
                              <tbody>
                                 <tr>
                                       <td  width="20%" style="border-color: #ffffff;">
                                    <div class="form-group ">
                                       <input type="hidden" name="material_issue_return_deatils_id" id="" value="<?= (isset($dt_items['id']))? $dt_items['id'] : '' ?>">
                                       <input type="hidden" name="material_issue_return_id" id="" value="<?= (isset($dt_items['material_issue_return_id']))? $dt_items['material_issue_return_id'] : '' ?>">
                                       
                                       
                                       <label class="control-label text-left col-md-12">Item Group  </label>
                                       <div class="col-md-12">
                                          <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)" disabled>
                                              <?php
                                                foreach($dt_items['item_group_name'] as $key_i1=>$value_item1){
                                                   
                                                    $selected='';
                                                   if($dt_items['item_id']==$value_item1['id']){
                                                      $selected="selected";
                                                   }
                                                ?>
                                             <option value="<?= $value_item1['id']; ?>" <?= $selected; ?>><?= $value_item1['item_group_name'] ?></option>
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
                                                foreach($dt_items['item_name'] as $key_i1=>$value_item1){
                                                   
                                                    $selected='';
                                                   if($dt_items['item_id']==$value_item1['id']){
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
                                          <select class="form-control custom-select select2 po_items_select" name="batch_no" style="width:100%" onchange="getItemUnits(this)" disabled>
                                             <?php
                                                if(!empty($dt_items['item_batch_list'])){
                                                    
                                                
                                                foreach($dt_items['item_batch_list'] as $key_i2=>$value_batch1){
                                                   
                                                    $selected='';
                                                   if($dt_items['batch_no']==$value_batch1['batch_no']){
                                                      $selected="selected";
                                                      
                                                   }
                                                ?>
                                             <option value="<?= $value_batch1['batch_no']; ?>" <?= $selected; ?>><?= $value_batch1['batch_no'] ?></option>
                                             <?php
                                                }
                                                }else{
                                            ?>
                                               <option value="<?= $dt_items['batch_no']; ?>" <?= $selected; ?>><?= $dt_items['batch_no'] ?></option>
                                            <?php
                                                }
                                            ?>
                                          </select>
                                       </div>
                                       
                                    </div>


                                    <div class="form-group col-md-12">
                                       <label class=""><b>Expired Date</b></label>
                                       <input class="form-control " type="text" placeholder="" readonly name="expired_date"   value="<?= isset($dt_items['expired_date'])?$dt_items['expired_date']:0 ?>" >
                                    </div>
                                       <div class="col-md-12 refesh_block" name="refesh_block"      <?= (isset($material_issue_return['id']))?'style="display: none;"':''  ?>>
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                                 </td>
                        
                                  
                                    <td width="20%" style="border-color: #ffffff;"> 
 
                                       <div class="form-group col-md-12">
                                          <label class=""><b>Return Qty</b></label>
                                          <input type="text" class="form-control po_item_cal numberonly item_unit"  name="item_unit" value="<?= $dt_items['return_qty']; ?>" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)" >
                                          <div class="form-group ">                                                                     
                                             <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id" onchange="getBatchwiseUnitWise(this)">
                                                   <?php
                                             foreach($dt_items['item_unit_list'] as $key_i2=>$value_item2){
                                                
                                                 $selected='';
                                                if($dt_items['return_qty_unit']==$value_item2['item_unit_id']){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item2['item_unit_id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                             </select>

                                          </div>
                                       </div>

                                       <div class="form-group col-md-12 m-t-20">
                                          <label class=""><b>Weight</b></label>
                                          <input class="form-control " type="text" placeholder=""  name="weight" value="<?= ($dt_items['weight'])?$dt_items['weight']:'' ?>">
                                          <div class="form-group ">                                                                     
                                             <select class="form-control custom-select select2" style="width:100%" name="weight_item_unit_id" id="weight_item_unit_id"  >
                                                   <?php
                                             foreach($dt_items['item_unit_list'] as $key_i2=>$value_item2){
                                                
                                                 $selected='';
                                                if($dt_items['weight_unit']==$value_item2['item_unit_id']){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item2['item_unit_id']; ?>" <?= $selected; ?>><?= $value_item2['weight_unit'] ?></option>
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
                                          <input class="form-control " type="text" placeholder="" name="rate"   value="<?= $dt_items['rate']; ?>" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)" >
                                       </div>

                                       <div class="form-group col-md-12">
                                          <label class=""><b>Amount</b></label>
                                          <input class="form-control " type="text" placeholder="" name="amount"   id="" value="<?= $dt_items['amount']; ?>">
                                       </div>

                                       <div class="form-group col-md-12 m-t-15 display_issued_to" id="">
                                          <label class=""><b></b></label>
                                       
                                          <div class="form-check">
                                             <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="1" <?= (isset($dt_items['issue_to']) && $dt_items['issue_to'] == 1)? 'checked':''; ?>>
                                             <label class="form-check-label" for="exampleRadios1">
                                                Party/Employee
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="2" <?= (isset($dt_items['issue_to']) && $dt_items['issue_to'] == 2)? 'checked':''; ?>>
                                             <label class="form-check-label" for="exampleRadios2">
                                               Vehicle Name
                                             </label>
                                          </div>
                                          <div class="form-check ">
                                             <input class="form-check-input" type="radio" name="issue_to" onclick="display_issued_to(this)" id="" value="3" <?= (isset($dt_items['issue_to']) && $dt_items['issue_to'] == 3)? 'checked':''; ?>>
                                             <label class="form-check-label" for="exampleRadios3">
                                             Other
                                             </label>
                                          </div>



                                          <div class="form-group row emp_issued_to m-t-5" id="emp_issued_to" name="emp_issued_to" <?= (isset($dt_items['issue_to']) && $dt_items['issue_to'] == 1)? '':'style="display:none"'; ?>>

                                             <label style="padding-right:0px" class="control-label col-md-6"><b>Party/Employee Name</b></label>
                                             <div class="col-md-6" style="padding-left:0px">
                                                <select class="form-control select2 vender_name"  id="" name="emp_issued_to_id"  style="width:100%;">
                                                   <?php
                                                       foreach ($info_items_data[0]['vendor_name_dt'] as $key => $value) {
                                                         if((isset($dt_items['emp_issued_to_id'])&&$dt_items['emp_issued_to_id']==$value['id'])){
                                                          $selected="selected";
                                                           }else{
                                                           $selected="";
                                                         } ?>
                                                      <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['account_name'] ?></option>
                                                   <?php  
                                                      }
                                                   ?>
                                                </select>
                                             </div>
                                          </div>


                                          <div class="form-group row vehicle_issed_to m-t-5" id="" name="vehicle_issed_to"  <?= (isset($dt_items['issue_to']) && $dt_items['issue_to'] == 2)? '':'style="display:none"'; ?>>
                                             <label class="control-label col-md-6"><b>Vehicle Name</b></label>
                                             <div class="col-md-6" style="padding-left: 0px;">
                                                <!-- loaded_party_id -->
                                               <input type="text" name="vehicle" class="form-control" value="<?= (isset($dt_items['vehicle']))?$dt_items['vehicle']: ''; ?>">
                                             </div>
                                          </div>

                                          <div class="form-group row other_issued m-t-5" id="" name="other_issued"  <?= (isset($dt_items['issue_to']) && $dt_items['issue_to'] == 3)? '':'style="display:none"'; ?>>
                                             <label class="control-label col-md-6"><b>Other</b></label>
                                             <div class="col-md-6" style="padding-left: 0px;">
                                                <!-- loaded_party_id -->
                                                <input type="text" name="other_text" class="form-control" value="<?= (isset($dt_items['other_text']))?$dt_items['other_text']: ''; ?>">
                                             </div>
                                          </div>

                                          <!--<div class="form-group row m-t-5">-->
                                          <!--   <label class="control-label col-md-3"><b>Is Retunable</b></label>-->
                                          <!--   <div class="col-md-1 mt-1">-->
                                          <!--      <input type="checkbox" name="is_returnable" value="1"  <?= (isset($dt_items['is_returnable']) && $dt_items['is_returnable'] == 1)? 'checked':''; ?> >-->
                                          <!--   </div>-->
                                          <!--   <div class="col-md-2 mt-1"></div>-->
                                          <!--   <div class="form-group col-md-6" style="padding-left:0px">-->
                                          <!--      <div class="" >-->
                                          <!--         <input class="form-control " type="date" placeholder="" name="returnable_date" value="<?= isset($dt_items['returnable_date'])? $dt_items['returnable_date']:''; ?>" >-->
                                          <!--      </div>-->
                                          <!--   </div>-->
                                          <!--</div>-->

                                          
                                       </div>
            
                                 </div>


                                    
                                      
                                       
                                    </td>
                                    <td width="20%" style="border-color: #ffffff;">
                                       <div class="form-group col-md-12 ">
                                          <label class=""><b>Remark</b></label>
                                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="material_issue_remark"><?= (isset($dt_items['material_issue_remark']))?$dt_items['material_issue_remark']: ''; ?></textarea>
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
                           } 
                           ?>
                        <?php
                           }else{ ?>
                           <table class="table table-bordered main_tbl_reapter" style="background:#eff1f3" data-repeater-item>
                              <tbody>
                                 <tr>
                                    <td width="20%" style="border-color: #ffffff;">
                                    <!-- <input type="hidden" class="form-control" name="available_qty" > -->

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
                                          <label class="control-label text-left col-md-12">Batch No</label>
                                          <div class="col-md-12">
                                             <select class="form-control custom-select select2 po_items_select" name="batch_no" style="width:100%" onchange="getAvaliableQuantity(this)">
                                                <?php
                                                
                                                   foreach($dt_items['item_batch_list'] as $key_i2=>$value_batch1){
                                                      
                                                       $selected='';
                                                      if($dt_items['batch_no']==$value_batch1['batch_no']){
                                                         $selected="selected";
                                                        
                                                      }
                                                   ?>
                                                <option value="<?= $value_batch1['batch_no']; ?>" <?= $selected; ?> ><?= $value_batch1['batch_no'] ?></option>
                                                <?php
                                                   }
                                                   ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="form-group col-md-12">
                                          <label class=""><b>Expired Date</b></label>
                                          <input class="form-control " type="date" placeholder="" readonly name="expired_date"   value="<?= isset($dt_items['expired_date'])?$dt_items['expired_date']:'' ?>" >
                                       </div>
                                       
                                        <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                        </div>
                                    
                                    </td>
                                   
                                    <td width="20%" style="border-color: #ffffff;">
                                       <div class="form-group col-md-12">
                                          <label class=""><b>Return Qty</b></label>
                                          <input type="text" class="form-control po_item_cal numberonly item_unit"  name="item_unit" value="0" onkeydown="getIssueQuantity(event,this)" onblur="calculateFinalAMount(this)" >

                                          <!-- <input type="text" class="form-control po_item_cal numberonly item_unit"  name="item_unit" value="0" onkeydown="getIssueQuantity(event,this)" max="23"> -->

                                          <div class="form-group ">   
                                          <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id" onchange="getBatchwiseUnitWise(this)">                                                                  
                                             <!-- <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id" onchange="getValidationMax()"> -->
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
                                          <input class="form-control " type="text" placeholder="" name="rate"   value="0" onkeydown="getIssueRate(event,this)" onblur="calculateFinalAMount(this)" >
                                       </div>

                                       <div class="form-group col-md-12">
                                          <label class=""><b>Amount</b></label>
                                          <input class="form-control " type="text" placeholder="" name="amount"   id="" value="">
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
                                                Vehicle Name
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
                                             <div class="col-md-6" style="padding-left:15px">
                                                <!-- loaded_party_id -->
                                                <select class="form-control select2 vender_name"  id="" name="emp_issued_to_id"  style="width:100%;">
                                                </select>
                                             </div>
                                          </div>

                                          <div class="form-group row vehicle_issed_to m-t-5" id="" name="vehicle_issed_to" style="display:none;">
                                             <label class="control-label col-md-6" style="padding-right:0px"><b>Vehicle Name</b></label>
                                             <div class="col-md-6" style="padding-left: 15px;">
                                                <!-- loaded_party_id -->
                                               <input type="text" name="vehicle" class="form-control" >
                                             </div>
                                          </div>

                                          <div class="form-group row other_issued m-t-5" id="" name="other_issued" style="display:none;">
                                             <label class="control-label col-md-6" style="padding-right:0px"><b>Other</b></label>
                                             <div class="col-md-6" style="padding-left: 15px;">
                                                <!-- loaded_party_id -->
                                                <input type="text" name="other_text" class="form-control">
                                             </div>
                                          </div>
                                       </div>
                                       
                                       <!--<div class="form-group col-md-12">-->
                                       <!--   <div class="row">-->
                                       <!--      <div class="col-md-6">-->
                                       <!--         <label><b>Is Retunable</b></label>-->
                                       <!--         <input type="checkbox" class="m-l-10" name="is_returnable" value="1">-->
                                       <!--      </div>-->
                                       <!--      <div class="col-md-6">-->
                                       <!--         <input class="form-control " type="date" placeholder="" name="returnable_date"   >-->
                                       <!--      </div>-->
                                       <!--   </div>-->
                                       <!--</div>-->

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

                          <?php } 
                           ?>
                     
                        


                     </div>

                     <div class="col-md-12 m-t-10">
                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label"><b>Return By</b></label>
                                 <select class="form-control custom-select select2 user_name"  name="return_by" style="width:100%">
                                    <?php
                                        foreach ($return_by as $key => $value) {
                                          if((isset($material_issue_return['return_by'])&&$material_issue_return['return_by']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['return_by_user_name'] ?></option>
                                    <?php  
                                       }
                                    ?>
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-md-3 m-t-20" style="margin-left:20px;">
                              <div class="form-group">
                                    <input type="checkbox" name="is_material_return_print" value="1" <?= (isset($material_issue_return['is_material_return_print']) && $material_issue_return['is_material_return_print'] == 1)? 'checked':''; ?>>
                                    <label style="margin-left:10px;"><b>Print Material Return</b></label>
                              </div>
                           </div>
                           


                        </div>

                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label"><b>Received By</b></label>
                                 <select class="form-control custom-select select2 user_name"  name="received_by" style="width:100%">
                                    <?php
                                        foreach ($received_by as $key => $value) {
                                          if((isset($material_issue_return['received_by'])&&$material_issue_return['received_by']==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['received_user_name'] ?></option>
                                    <?php  
                                       }
                                    ?>
                                 </select>
                              </div>
                           </div>
                         
                        </div>

                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label class="control-label"><b>Remark</b></label>
                                 <textarea class="form-control" name="return_item_remark"><?= (isset($material_issue_return['return_item_remark']))?$material_issue_return['return_item_remark']: ''; ?></textarea>
                              </div>
                           </div>
                        </div>



                     
                     </div>



                     <hr>


                  </div>
                  <!--<input type="submit" id="btnsubmit"  value="Submit">-->
                    <button type="button" class="btn btn-success btn-theme float-right"style="margin-left: 94%;"onclick="submitIssue()">Submit</button>
                   
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/store/return_matrial_issue_repeter.int.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/Auto-TabIndex-master/autotabindex.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js?v=1.0.1"></script>
<script src="<?= base_url(); ?>assets/js/page-js/store/matrial_issue_return.js?v=1.0.1"></script>


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
        $(".rtn_frm_self").hide();

      } else if(type_consumption == 1){
         $("#flat").show();
         $("#floor").show();
         $("#issue_to_location_site_id").hide();
         $("#stock_at_vendor").show();
         $(".display_issued_to").show();
         $(".rtn_frm_self").show();
      }else if(type_consumption == 3){
         $("#flat").hide();
         $("#floor").hide();
         $("#issue_to_location_site_id").hide();
         $("#stock_at_vendor").hide();
         $(".display_issued_to").hide();
         $(".rtn_frm_self").show();
      }else{
         $("#issue_to_location_site_id").hide();
        $("#flat").hide();
        $("#floor").hide();
        $("#stock_at_vendor").hide();
        $(".display_issued_to").hide();
        $(".rtn_frm_self").hide();

         $(".rtn_frm_self").hide();   
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




    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true,
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true,
        dateFormat:"Y-m-d"
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
