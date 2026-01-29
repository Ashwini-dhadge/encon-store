<?php init_header(); ?>

 <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<style>
   body {
   /* font-family: "Lato Regular", sans-serif; */
   }
  /*  .form-group {
   min-height: 28px;
   font-size: 14px;
   } */
  /*  .form-control {
   font-size: 0.8rem;
   } */
  /*  label{
   margin-bottom: 0.2rem;
   } */
  /*  textarea{
   height:0px !important;
   } */
   /*label.error{
   display: none !important;
   }*/
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
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
            <form class="repeater" method="post" action="<?= base_url('admin/store/MaterialIssue/add_materialissue');?>" id="frm" enctype="multipart/form-data"class="form-horizontal" autocomplete="off">
               <div class="row">
                  <input type="hidden" name="id" id="id" value="<?= (isset($id))? $id : '' ?>">
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color">
                              <h6><b>Add Material Issue</b></h6>
                           </span>
                           <hr>
                        </div>
                        <div class="form-group col-md-3 ">
                           <label class="">Material Issue No.3456543</label>
                        </div>
                        <div class="form-group col-md-3 ">
                           <label class="">Issue Date</label>
                           <!--  <div class="input-group">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="po_date" id="po_date" value="">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div> -->


                                           
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="date" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                </div>
                                            </div>
                                      
                           <!-- <input class="form-control " type="date" placeholder="" name="issue_date"  required value="2011-08-19" > -->
                        </div>

                        <div class="form-group col-md-3 ">
                           <label class="">Time</label>

                            <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" value="13:14" name="time">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                        </div>
                           <!-- <input class="form-control " type="time" placeholder="" name="time" required  value="13:45:00"> -->
                        </div>
                        <div class="form-group col-md-3 ">
                           <!--  <label class="">Time</label> -->
                           <!--  <input class="form-control " type="time" placeholder="" name="hsn_code" required  value="13:45:00"> -->
                        </div>
                        <div class="form-group col-md-3">
                           <!-- <label style="margin-top: 2px;border-color:#ced4da;" class="">Item Group Name</label>
                              <select class="form-control select2 item_group_name"  id="item_group" required name="item_group" value="">
                                
                              </select>
                              <label id="item_group-error" class="error sd" for="item_group">This field is .</label> -->
                        </div>
                        <div class="form-group col-md-4" id="type_consumption">
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="1" name="type_consumption_issue" id="consumption" >
                              <label class="form-check-label" for="inlineRadio1" >Consumption/Issue</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="2" name="type_consumption_issue" id="transfer">
                              <label class="form-check-label" for="inlineRadio2">Transfer</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" value="3" name="type_consumption_issue" id="production">
                              <label class="form-check-label" for="inlineRadio3">Production</label>
                           </div>
                        </div>
                        <div class="form-group col-md-4">
                           <fieldset class="form-group">
                              <div class="row" id="self_party_stock">
                                 <label class="form-check-label" for="gridRadios1">
                                 Issue/Transfer Form:-&nbsp;&nbsp;
                                 </label>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gridRadios"  value="1" id="party_stock" >
                                    <label class="form-check-label" for="gridRadios1">
                                    Party Stock&nbsp;&nbsp;
                                    </label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2" checked>
                                    <label class="form-check-label" for="gridRadios2">
                                    Self Stock
                                    </label>
                                 </div>
                              </div>
                           </fieldset>
                        </div>
                        <div class="col-md-6" >
                           <div class="form-group row" id="stock_at_vendor">
                              <label class="control-label  col-md-6">Consumption/Issue From Stock At Vendor</label>
                              <div class="col-md-6">
                                 <select class="form-control select2 vender_name" id="account_name" name="account_name">
                                    <?php
                                 foreach ($stock_unit as $key => $value) {
                                    if((isset($itemsData)&&$itemsData==$value['id'])){
                                     $selected="selected";
                                      }else{
                                      $selected="";
                                    } ?>
                              <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['unit_name'] ?></option>
                              <?php } ?>
                                 </select>
                                 <small id="emailHelp" class="form-text" style="color:#6610f2 ;">(Select If Consumption/Issue Form Vender)</small>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group row" id="flat">
                              <label class="control-label col-md-3 ">Flat</label>
                              <div class="col-md-9">
                                 <input class="form-control " type="text" placeholder="" name="flat"  required  value="">
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group row" id="floor">
                              <label class="control-label col-md-3 ">Floor</label>
                              <div class="col-md-9">
                                 <input type="text" class="form-control numberonly" required placeholder="" name="floor" id="floor" value="<?= isset($itemgroup)? $itemgroup['tolerance_level'] : ''; ?>">
                              </div>
                           </div>
                        </div>


                        <!--  <div class="col-md-3" id="to_location" style="display:none;">
                           <div class="form-group row" id="floor">
                              <label class="control-label text-right col-md-4 ">To Location</label>
                              <div class="col-md-9">
                                <select class="form-control select2" required id="to_location" name="to_location" >
                                   
                                 </select>
                              </div>
                           </div>
                        </div> -->
                        <!--  <div class="col-md-3" id="to_location" style="display:none;">
                           <div class="form-group row" >
                               <label class="control-label text-right col-md-6">To Location</label>
                              <div class="col-md-6">
                                 <select class="form-control custom-select" required id="to_location" name="to_location" >
                                    <
                                    <option value=""></option>
                                    }
                                    option
                                    <option>India33</option>
                                    <option>Sri Lanka</option>
                                 </select>
                                 <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>
                        </div> -->


                       
                       <!--   <div class="col-md-6" id="to_location" style="display:none;">
                           <div class="form-group row">
                              <label class="control-label col-md-6">To Location</label>
                              <div class="col-md-6">
                                 <select class="form-control custom-select" required id="to_location" name="to_location" >
                                    <
                                    <option value=""></option>
                                    }
                                    option
                                    <option>India33</option>
                                    <option>Sri Lanka</option>
                                 </select>
                                 <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>
                        </div> -->
                        

                        <div class="col-md-6">
                           <div class="form-group row" >
                              <label class="control-label col-md-6">Issue Location</label>
                              <div class="col-md-6">
                                 <input type="hidden" name="site_id" class="form-control site_id" id="site_id" value="<?= isset($issue_location['id'])?$issue_location['id']:'';?>">
                                 <input type="text" name="" class="form-control" readonly id="" value="<?= isset($issue_location['site_name'])?$issue_location['site_name']:'';?>">
                                 <!-- <select class="form-control" required id="issue_location" name="issue_location" >
                                   <option>sdfff</option>
                                 </select> -->
                                 <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>


                           



                        </div>
                        <div class="form-group col-md-3 ">
                           <div class="form-group row" id="to_location" style="display:none;">
                              <label class="control-label col-md-3">To Location</label>
                              <div class="col-md-9">
                                 <select class="form-control select2 to_location "  id="to_location" name="to_location" style="width: 100%;">
                                    
                                 </select>
                                 <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>

                            
                            <div class="form-group row" id="customer" style="display:none;">
                              <label class="control-label col-md-3">Customer</label>
                              <div class="col-md-9">
                                 <select class="form-control select2 vender_name"  id="customer" name="customer" style="width: 100%;" >
                                   
                                 </select>
                                 <label id="issue_location-error" class="error sd" for="issue_location">This field is .</label>
                              </div>
                           </div>




                        </div>
                        <div class="form-group col-md-3 ">
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Gate Pass No.</label>
                              <div class="col-md-6">
                                 <input class="form-control gate_pass_no " type="text" placeholder="" name="gate_pass_no" required  value="">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                          
                             
                           <div class="col-md-8" style="font-weight: bold;">
                              <input type="checkbox"  value="1" id="automake_gatepass" name="automake_gatepass" onclick="automake_gatepassCheckbox()" ><label class="did-floating-label" style="top:0px;margin-left: 20px;">Auto Make Gate Pass No.(On Edit It Will Not Work)</label>
                           </div>

                        </div>
                      <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Is Our Carrying Vehicle.</label>
                              <div class="col-md-6">
                                 <input type="checkbox" id="vehicle_no" value="1"  name="vehicle_no" ><label class="did-floating-label" style="top:0px;margin-left: 3px;">Carrying Vehicle No.</label>
                                 <input class="form-control  " type="text" placeholder="" name="gate_pass_no" required  value="">
                              </div>
                           </div>
                        </div>


                         <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Carrying Vehicle Driver</label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="" required  value="">
                              </div>
                           </div>
                           <div class="form-group row" id="loaded_via">
                              <label class="control-label col-md-6">Loaded Via</label>
                              <div class="col-md-6">
                                 <label class="radio-inline">
                                 <input type="radio" name="optradio" checked>&nbsp;&nbsp;Self
                                 </label>
                                 <label class="radio-inline" >
                                 <input type="radio" name="optradio" value="1" id="party">&nbsp;&nbsp;Party
                                 </label>
                                 <!--  <select class="form-control select2 vender_name"  id="customer" name="customer" style="width: 100%;" >
                                   
                                 </select> -->

                                 
                                 <!-- <label class="radio-inline">
                                    <input type="radio" name="optradio">Option 3
                                    </label> -->
                              </div>
                           </div>
                           <div class="form-group row" id="party_option_select" style="display:none;">
                              <label class="control-label col-md-6"></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 vender_name"  id="party_option" name="party_option"  style="width:100%;">
                                 </select>
                              </div>
                           </div>


                            
                        </div>







                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Transporter</label>
                              <div class="col-md-6">
                                 <select class="form-control select2 vender_name" id="transporter">
                                    <option>Select</option>
                                    
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Manual Slip No.</label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="manual_slip_no" required  value="">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Indend No.</label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="indend_no" required  value="">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <!--   <div class="form-group row">
                              <label class="control-label col-md-6">RST No.</label>
                              <div class="col-md-6">
                                <input class="form-control " type="text" placeholder="" name="" required  value="">
                              </div>
                              </div> -->
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">RST No.</label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="rst_no" required  value="">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <!--  <div class="form-group row">
                              <label class="control-label col-md-6">RST No.</label>
                              <div class="col-md-6">
                                <input class="form-control " type="text" placeholder="" name="" required  value="">
                              </div>
                              </div> -->
                        </div>
                        <!-- <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Enter Using Barcode</label>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="barcode" required  value="">
                              </div>
                           </div>
                        </div> -->
                        <!-- <div class="col-md-6"> -->
                           <!-- <div class="form-group row">
                              <label class="control-label col-md-6">Enter Using Barcode</label>
                              <div class="col-md-6">
                                <input class="form-control " type="text" placeholder="" name="" required  value="">
                              </div>
                              </div> -->
                        <!-- </div> -->
                       <!--  <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label col-md-6">Enter Using Recipe Name/Code/No.Of Set</label>
                              <div class="col-md-6">
                                 <select class="form-control custom-select" name="recipe_name">
                                    <option>Select</option>
                                    <option>Sri Lanka</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="" required  value="">
                              </div>
                              <div class="col-md-6">
                                 <input class="form-control " type="text" placeholder="" name="" required  value="">
                              </div>
                           </div>
                        </div> -->
                     </div>
                     <div class="row m-t-10">
                        <div class="col-md-6">
                           <h3 class="box-title">Material Issue</h3>
                        </div>
                        <div class="col-md-6" align="right">
                           <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme">Add</button></a>
                        </div>
                     </div>
                     <div data-repeater-list="material_items" style=""  >
                        <div data-repeater-item class="repeater-item" >
                           <hr>
                           <div class="row" >
                              <div class="form-group col-md-3 b-r "  id="item_group_tables">
                                 <label class="">Item Group/Item Name</label>
                                  <select class="form-control custom-select select2 item_group_name" required name="item_group_name" style="width:100%">
                                    <?php
                                       foreach ($stock_unit as $key => $value) {
                                          if((isset($itemsData)&&$itemsData==$value['id'])){
                                           $selected="selected";
                                            }else{
                                            $selected="";
                                          } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['item_group_name'] ?></option>
                                    <?php } ?>
                                 </select>

                              </div>
                              <div class="form-group col-md-1 b-r">
                                 <label class="">Req.Qty</label>
                                 <input class="form-control " type="text" placeholder="" name="req_qty" required  value="">
                              </div>
                              <div class="form-group col-md-2 b-r">
                                 <label class="">Issue Qty</label>
                                 <input class="form-control " type="text" placeholder="" required name="issueQty"   value="">
                              </div>
                              <div class="form-group col-md-3 b-r">
                                 <label class="">Rate</label>
                                 <input class="form-control " type="text" placeholder="" name="rate" required  value="">
                              </div>
                              <div class="form-group col-md-3 ">
                                 <label class="">Remark</label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="remark"></textarea>
                              </div>
                              <!--  <div class="form-group ">
                                 <label for="exampleFormControlTextarea1">Example textarea</label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                 </div> -->
                           </div>
<!-- =========== -->
                           <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" required name="items_id"style="width:100%" onchange="getItemUnits(this)">
                                          <option></option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group m-t-40">
                                    <label class="control-label text-left col-md-12">HSC Code</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control" name="item_hsc_code" readonly>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">STOCK QTY</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control numberonly" name="item_stock_qty">
                                    </div>
                                 </div>

<!-- ====================== -->

                           <div class="row">
                              <div class="col-md-3 b-r">
                                 <div class="form-group row ">
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" required name="items_id"style="width:100%">
                                          <option></option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="form-group col-md-1 b-r">
                                 <!--  <label class="">Req.Qty</label>
                                    <input class="form-control " type="text" placeholder="" name="" required  value=""> -->
                              </div>
                              <div class="form-group col-md-2 b-r">
                                 <select class="form-control custom-select">
                                    <option>All</option>
                                    <option>Sri Lanka</option>
                                 </select>
                                 <label class="">Weight</label>
                                 <input class="form-control " type="text" placeholder="" name="" required  value="">
                                 <select class="form-control custom-select mt-2">
                                    <option>All</option>
                                    <option>Sri Lanka</option>
                                 </select>
                              </div>
                              <div class="form-group col-md-3 b-r">
                                 <label class="">Amount</label>
                                 <input class="form-control " type="text" placeholder="" required name="issue_to"   value="">
                                 <label for="exampleFormControlTextarea1">Issue To</label>
                                 <label id="issue_to-error" class="error sd" for="issue_to">This field is .</label>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                    Party/Employee
                                    </label>
                                 </div>
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                    Veh.
                                    </label>
                                 </div>
                                 <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" >
                                    <label class="form-check-label" for="exampleRadios3">
                                    Other
                                    </label>
                                 </div>
                                 <!--  <div class="form-group col-md-3 "> -->
                                 <!--  </div> -->
                              </div>
                              <!--  <div class="form-group" style="color:#d63384  ;font-weight: bold;">
                                 <label for="exampleFormControlTextarea1">Cost Work</label>
                                 
                                 </div> -->
                           </div>
                           <div class="row">
                              <div class="form-group col-md-3 b-r">
                                 <hr>
                                 <div class="form-group" style="color:#d63384  ;font-weight: bold;">
                                    <label for="exampleFormControlTextarea1">Cost Work</label>
                                 </div>
                              </div>
                              <div class="form-group col-md-1 b-r">
                                 <!--  <label class="">Req.Qty</label>
                                    <input class="form-control " type="text" placeholder="" name="" required  value=""> -->
                              </div>
                              <div class="form-group col-md-2 b-r">
                              </div>
                              <div class="col-md-3 b-r">
                                 <input class="form-control " type="text" placeholder="" name="" required  value="">
                                 <div class="form-group row ml-2">
                                    <label>Is Retunable&nbsp;<input type="checkbox" name="thing-1" value="coding" class="mt-2" ></label>
                                    <div class="col-md-6 mt-1">
                                       <input class="form-control " type="date" placeholder="" name=""  required value="dd/yy/mm" >
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">  
                                 <button data-repeater-delete class="btn btn-danger " type="button" style="" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3">Request By:</label>
                              <div class="col-md-6">
                                 <select class="form-control select2 user_name" id="req_id">
                                    <option>Select</option>
                                    <option>Sri Lanka</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3">Issued By:</label>
                              <div class="col-md-6">
                                 <select class="form-control select2 user_name" id="issued_by">
                                    <option>Select</option>
                                    <option>Sri Lanka</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3">Department:</label>
                              <div class="col-md-6">
                                 <select class="form-control custom-select" required name="department">
                                    <option></option>
                                    <option>Select</option>
                                    <option>Sri Lanka</option>
                                 </select>
                                 <label id="department-error" class="error sd" for="department">This field is .</label>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-7">
                           <div class="form-group row">
                              <label class="control-label col-md-2 ">Received By:</label>
                              <div class="col-md-4 pl-4 ">
                                 <select class="form-control select2 user_name" id="received_by">
                                    <option>Select</option>
                                    <option>Sri Lanka</option>
                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check pl-4">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Print Material Issue</label>
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
                              <label class="control-label col-md-3">Remark:</label>
                              <div class="col-md-6">
                                 <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3">Attach a file:</label>
                              <div class="col-md-6">
                                 <input class="form-control " type="file" placeholder="" name=""  required >
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
                  <input type="submit" id="btnsubmit" style="margin-left: 94%;" class="btn btn-success btn-theme float-right" value="Submit">
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
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/Auto-TabIndex-master/autotabindex.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/store/matrial_issue.js"></script>
 
    <!-- <script src="../assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../assets/node_modules/daterangepicker/daterangepicker.js"></script> -->

<script>
   $(document).ready(function () {
     
      $('#frm').validate({
   
       });
      
         })
   
   
   $(document).ready(function() { 
   $(".numberonly").attr("maxlength", "10");
       $(".numberonly").keypress(function(e) {
          var kk = e.which;
           if(kk < 48 || kk > 57)
           e.preventDefault();
       });
    });
   
   $('#transfer').on('change', function() {
      var transfer = $( 'input[name=transfer]:checked' ).val();
      // alert(type_nbc);
      if (transfer) {
       $("#flat").hide();
       $("#floor").hide();
      } else{
          $("#to_location").show();

         // $('#central_branch').find('select').find('option[value]').remove();
         // $("#central_branch").hide();
      }

      $('#type_consumption').on('change', function() {
      var type_consumption = $( 'input[name=type_consumption_issue]:checked' ).val();
      // alert(type_nbc);
      if (type_consumption == 2) {
        $("#to_location").show();
        $("#flat").hide();
         $("#floor").hide();
         $("#stock_at_vendor").hide();


      } else if(type_consumption == 1){
          $("#flat").show();
         $("#floor").show();
          $("#to_location").hide();
          $("#stock_at_vendor").show();
         // $('#flat').find('select').find('option[value]').remove();
         // $('#floor').find('select').find('option[value]').remove();
         // $("#flat").hide();
         // $("#floor").hide();
      }else if(type_consumption == 3){
         $("#flat").hide();
         $("#floor").hide();
          $("#to_location").hide();
          $("#stock_at_vendor").hide();
      }
    });
    });


   function automake_gatepassCheckbox(){
            let automake_gatepass=$("input[type='checkbox'][name='automake_gatepass']:checked").val();
               // console.log(automake_gatepass)
            if(automake_gatepass){
                $('.gate_pass_no').attr("disabled", "disabled");;
                
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
        var loaded_via =$( 'input[name=optradio]:checked' ).val();
         alert(loaded_via)
        if (loaded_via == 1) {
          $('#party_option_select').show();
          
        }else{
         $('#party_option_select').hide();
        }
      });
$('#self_party_stock').on('change', function() {
        var self_party_stock =$( 'input[name=gridRadios]:checked' ).val();
        // console.log(vehicle_no)
        if (self_party_stock == 1) {
          $('#customer').show();
          $("#to_location").hide();
        } else {
          $('#customer').hide();
           
        }
      });

 // $('.daterange').daterangepicker();
 //   $('.mydatepicker').datepicker({
 //    defaultDate: "today"
 //   });
 //    $('.mydatepicker').datepicker({
 //    defaultDate: "today",
    
 //   });

  // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
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
