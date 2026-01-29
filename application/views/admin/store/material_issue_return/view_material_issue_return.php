<?php init_header();?>

<!-- <link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">

<style>
   /*.lbl_class{
      background: lavender;
   }*/
   b{
      font-weight: bold;
   }

   .form-control{
      border: none;
   }
   th.sorting{
      padding-right:0px !important;
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

<!-- 1st  -->
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
               
               <div class="row">
            
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Return Material Issue Information</b></h6></span><hr> 
                        </div>
                      
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Company Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($company_name))? $company_name : '-' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Site Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($site_name))? $site_name : '-' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Financial Year</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($financial_year))? $financial_year : '-' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>RTN Number</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($m_rtn_no))? $m_rtn_no : '-' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Return Issue Date</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($return_issue_date))? $return_issue_date : '-' ?></span>
                        </div>


                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Issue Type</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span>
                              <?php  (isset($return_issue_type))? $return_issue_type : '-';
                                 if($return_issue_type == 1){
                                    echo "Consumption/Issue";
                                 }else if($return_issue_type == 2){
                                    echo "Transfer";
                                 }else if($return_issue_type == 3){
                                    echo "Production";
                                 }else if($return_issue_type == 7){
                                    echo "Fresh";
                                 }else{
                                    echo "-";
                                 }
                              ?>
                           </span>
                        </div>

                        
                        <!-- <//?php if($issue_from_vendor_id == 1) {?> -->
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Customer Name</b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <span><?= (isset($ps_customer_name))? $ps_customer_name : '-' ?></span>
                           </div>
                        <!-- <//?php }?> -->


                        <!-- <//?php if($return_issue_type == 1) {?> -->
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Issue From Vendor Name</b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <span><?= (isset($issue_from_stock_vendor_name))? $issue_from_stock_vendor_name : '-' ?></span>
                           </div>
                        <!-- <//?php }?> -->


                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Return Issue Location</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($return_issue_location))? $return_issue_location : '-' ?></span>
                        </div>
                        
                        <!-- <//?php if($return_issue_type == 3) {?> -->
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>From Location Site Name</b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <span><?= (isset($from_location_name))? $from_location_name : '-' ?></span>
                           </div>
                        <!-- <//?php }?> -->

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Is Auto Make Gate Pass No</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span>
                              <?php 
                                 if($is_auto_make_gate == 1){
                                    echo "Yes";
                                 }else{
                                    echo "-";
                                 }
                              ?>
                           </span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Gate Pass No</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($gate_pass_no))? $gate_pass_no : '-' ?></span>
                        </div>
                        
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Is Our Carrying Vehicle</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span>
                              <?php 
                                 if($is_our_carrying_vehicle == 1){
                                    echo "Yes";
                                 }else{
                                    echo "-";
                                 }
                              ?>
                           </span>
                        </div>
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Carrying Vehicle No</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($carrying_vehicle_no))? $carrying_vehicle_no : '-' ?></span>
                        </div>
               
                      
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Return Item Remark</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($return_item_remark))? $return_item_remark : '-' ?></span>
                        </div>


                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Return By</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($return_by['return_by_user_name']))? $return_by['return_by_user_name'] : '-' ?></span>
                        </div>


                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Received By Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($received_by['received_user_name']))? $received_by['received_user_name'] : '-' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Is Print Material Issue</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span>
                              <?php 
                                 if($is_material_return_print == 1){
                                    echo "Yes";
                                 }else{
                                    echo "-";
                                 }
                              ?>
                           </span>
                        </div>


                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Remark</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($return_item_remark))? $return_item_remark : '-' ?></span>
                        </div>


                     </div>  

                  </div>

                  <div class="col-md-12 mb-2">
                     <div class="table-responsive">
                        <span class="text-color"><h6><b>Return Items Details</b></h6></span><hr> 
                        <input type="hidden" name="mtr_issue_id" id="mtr_issue_id" value="<?= isset($id)?$id:'';?>">
                        <table id="return_material_issue_items" class="table display table-bordered" style="text-align:center;" width="100%">
                          
                        </table>
                     </div>
                  </div>




               </div>
            </div>
         </div>
      </div>
   </div>

</div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/store/matrial_issue_return.js"></script>
