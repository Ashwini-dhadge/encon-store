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
                           <span class="text-color"><h6><b>Received Matrial Issue Information</b></h6></span><hr> 
                        </div>
                      
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Company Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($company_name))? $company_name : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Site Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($site_name))? $site_name : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Financial Year</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($financial_year))? $financial_year : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Received Number</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($received_no))? $received_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Received Date</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($received_date))? $received_date : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Received Time</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($received_time))? $received_time : '' ?></span>
                        </div>



                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Received Location Site Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($recevier_location_site_name))? $recevier_location_site_name : '' ?></span>
                        </div>
                        
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Issue From Location Site Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($sender_location_site_name))? $sender_location_site_name : '' ?></span>
                        </div>
                       
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
                           <span><?= (isset($gate_pass_no))? $gate_pass_no : '' ?></span>
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
                           <span><?= (isset($carrying_vehicle_no))? $carrying_vehicle_no : '' ?></span>
                        </div>
                         <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Carrying Vehicle Driver</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($carrying_vehicle_driver))? $carrying_vehicle_driver : '' ?></span>
                        </div>
                         <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Carrying Vehicle Reading</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($carrying_vehicle_reading))? $carrying_vehicle_reading : '' ?></span>
                        </div>
                        

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Is Loaded Via</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span>
                              <?php 
                                 if($is_loaded_via == 1){
                                    echo "Self";
                                 }else if($is_loaded_via == 2){
                                    echo "Party";
                                 }else{
                                    echo "-";
                                 }
                              ?>
                              </span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Transporter Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($transporter_name))? $transporter_name : '' ?></span>
                        </div>
       
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Indend No</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($indend_no))? $indend_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Remark</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($remark))? $remark : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>RST No</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($rst_no))? $rst_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Received By Name</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($recevier_first_name))? $recevier_first_name : '' ?> <?= (isset($recevier_last_name))? $recevier_last_name : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class"><b>Transfered By</b></label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($transfer_first_name))? $transfer_first_name : '' ?> <?= (isset($transfer_last_name))? $transfer_last_name : '' ?></span>
                        </div>


                     </div>  

                  </div>

                  <div class="col-md-12 mb-2">
                     <div class="table-responsive">
                        <span class="text-color"><h6><b>Received Items Details</b></h6></span><hr> 
                        <input type="hidden" name="received_material_issue_id" id="received_material_issue_id" value="<?= isset($id)?$id:'';?>">
                        <table id="received_material_issue_items_tbl" class="table display table-bordered" style="text-align:center;" width="100%">
                           <!-- <thead>
                              <th>Sr._No.</th>
                              <th>Item Name</th>
                              <th>Item Group Name</th>
                              <th>Issue Qty</th>
                              <th>Weight</th>
                              <th>Rate</th>
                              <th>Amount</th>
                              <th>Returnable</th>
                              <th>Returnable Date</th>
                              <th>Remark</th>
                              <th>Action</th>
                           </thead> -->
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
<script src="<?= base_url(); ?>assets/js/page-js/store/recevie_issue_list.js?v=1.0.0"></script>

<script>
</script>