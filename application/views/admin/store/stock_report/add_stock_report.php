<?php init_header(); ?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<style>
   body {
   font-family: "Lato Regular", sans-serif;
   }
   .form-group {
   min-height: 28px;
   font-size: 14px;
   }
   .form-control {
   font-size: 0.8rem;
   }
   label{
   margin-bottom: 0.2rem;
   }
   textarea{
   height:0px !important;
   }
   /*label.error{
   display: none !important;
   }*/
   .error{
   color:red;
   }
   .err_cls{
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
   .select2-selection{
   height: 32px !important;
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
               <input type="hidden" name="company_id_session" id="company_id_session" value="<?= userId('company_id'); ?>"> 
                <input type="hidden" name="site_id_session" id="site_id_session" value="<?= userId('site_id'); ?>"> 
                
               <form method="post" action="<?= base_url('admin/store/StockReport/generate_pdf');?>" id="stcok_report" enctype="multipart/form-data"class="form-horizontal" target="_blank">
                  <div class="row">
                     <!-- <input type="hidden" name="id" id="id" value="<?= isset($itemgroup)? $itemgroup['id'] : ''; ?>"> -->
                     <div class="col-md-12">
                        <span class="text-color">
                           <h6><b>Stock Report</b></h6>
                        </span>
                        <hr>
                     </div>

                     <div class="col-md-2"></div>
                     <div class="col-md-8 mb-3">
                         <div class="row">
                           <div class="col-md-2 m-t-5">
                              <label>Financial Year </label>
                           </div>
                           
                           <div class="col-md-4 m-t-5">
                              <select class="form-control select2 did-floating-select"  id="financial_year_id" required name="financial_year_id" value="" >
                                  <?php
                                  $selected="";
                                    foreach($financial_years as $key=>$value){
                                        if($value['is_active']==1){
                                            $selected="selected";
                                        }
                                ?>
                                <option value="<?= $value['id'] ?>" <?= $selected; ?>><?=  date('d/m/Y',strtotime($value['from_date']))."-".date('d/m/Y',strtotime($value['to_date'])) ?></option>
                                <?php
                                    }
                                  ?>
                              </select>
                              <label id="company_id-error" class="error err_cls" for="company_id">This field is required.</label>
                           </div>
                          </div>
                        <div class="row">
                           <div class="col-md-2 m-t-5">
                              <label>Company Name</label>
                           </div>
                           
                           <div class="col-md-4 m-t-5">
                              <select class="form-control select2 did-floating-select"  id="company_id" required name="company_id" value="" onchange="emptySite()">
                              </select>
                              <label id="company_id-error" class="error err_cls" for="company_id">This field is required.</label>
                           </div>


                           <div class="col-md-2 m-t-5">
                              <label>Site Name</label>
                           </div>

                           <div class="col-md-4">
                              <select class="form-control select2 did-floating-select"  id="site_id"  name="site_id" value="" >
                              </select>
                              <label id="site_id-error" class="error err_cls" for="site_id">This field is required.</label>
                           </div>


                           <div class="col-md-2 m-t-5">
                              <label>Item Group</label>
                           </div>
                           <div class="col-md-4 m-t-5">
                              <select class="form-control select2 did-floating-select select2 item_group_select2"  id="item_group_id"  name="item_group_id" value="" >
                              </select>
                              <label id="item_group_id-error" class="error err_cls" for="item_group_id">This field is required.</label>
                           </div>
                        

                           <div class="col-md-2 m-t-5">
                              <label>Item Name</label>
                           </div>
                           <div class="col-md-4 m-t-5">
                              <select class="form-control select2 did-floating-select select2 "  id="item_name_id"  name="item_name_id" value="" >
                              </select>
                              <label id="item_name_id-error" class="error err_cls" for="item_name_id">This field is required.</label>
                           </div>

                           <div class="col-md-2 m-t-5">
                              <label>From Date</label>
                           </div>
                           <div class="col-md-4 m-t-5">
                              <div class="input-group" style="width:100%">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" required name="from_date" id="from_date" value="" required >
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                              <label id="from_date-error" class="error err_cls" for="from_date">This field is required.</label>
                           </div>

                           <div class="col-md-2 m-t-5">
                              <label>To Date</label>
                           </div>
                           <div class="col-md-4 m-t-5">
                              <div class="input-group" style="width:100%">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" required name="to_date" id="to_date" value="" required>
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                              <label id="to_date-error" class="error err_cls" for="to_date">This field is required.</label>
                           </div>
                           
                        </div>
                     </div>
                     <div class="col-md-2"></div>

                  </div>

               
                   <div class="row">
                     <div class="col-md-10 m-t-5" >
                        <input type="submit" id="btnsubmit" class="btn btn-success btn-theme float-right" value="Stock Report">
                     </div>
                  </div>

               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>/assets/js/page-js/store/stock_report.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script>
   $(document).ready(function () {
     
      $('#stcok_report').validate();
  
      $('#company_id').change(function() {
         if ($(this).val() !== '') {
           $('#company_id-error').hide();
         } else {
           $('#company_id-error').show();
         }
       });

      $('#site_id').change(function() {
         if ($(this).val() !== '') {
           $('#site_id-error').hide();
         } else {
           $('#site_id-error').show();
         }
       });

      $('#item_group_id').change(function() {
         if ($(this).val() !== '') {
           $('#item_group_id-error').hide();
         } else {
           $('#item_group_id-error').show();
         }
       });

      $('#item_name_id').change(function() {
         if ($(this).val() !== '') {
           $('#item_name_id-error').hide();
         } else {
           $('#item_name_id-error').show();
         }
       });

   });


   
   
   
</script>
<script>
   $('.daterange').daterangepicker();
   var date = new Date();
   var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
   
   $('.mydatepicker').datepicker({
    defaultDate: today,
      format: 'dd/mm/yyyy',
   });
   
   $('.myPreviousDatepicker').datepicker({
    defaultDate: today,
    minDate: null  // Set the minimum date to today, preventing selection of previous dates
   });

</script>