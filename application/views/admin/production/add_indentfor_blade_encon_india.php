<?php init_header();?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url()?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url()?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!--alerts CSS -->
<link href="<?= base_url()?>assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<style>
   .sd{
   display: none;
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
   .color-table.success-table thead th {
   background-color: #48bc97 !important;
   color: #ffffff;
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
                <form class="" action=""  enctype="multipart/form-data" method="post" id="frm_indent" autocomplete="off">
                
               <div class="row">
                  <div class="col-md-12 mb-3">
                   
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Add Indent for Blade Encon(India)</b></h6>
                              </span>
                              <hr>
                           </div>
                        
                           <div class="form-group col-md-3 ">
                           <label style="border-color:#ced4da;" class="">Location</label>
                           <div class="input-group">
                              <!-- <input type="text" class="form-control" id="indent_date"  name="date" value="" required> -->
                              <select class="form-control select2 " name="location_id"  id="location_id" >
                                     <option value="1">ENCON FAN (INDIA) PRIVATE LIMITED</option>
                                 </select>
                           </div>
                         
                        </div>

                           <div class="form-group col-md-3 ">
                           <label style="border-color:#ced4da;" class="">Indent Date</label>
                           <div class="input-group">
                              <input type="date" class="form-control" id="indent_date"  name="date" value="" required>
                             
                           </div>
                         
                        </div>

                        <div class="form-group col-md-3 ">
                           <label style="border-color:#ced4da;" class="">Delivery Date</label>
                           <div class="input-group">
                              <input type="date" class="form-control" id="indent_date"  name="date" value="" required>
                             
                           </div>
                         
                        </div>

                        <div class="form-group col-md-3">
                              <label class="">Indent No</label>
                              <input class="form-control" type="text" id="indent_no" placeholder="CT31" name="indent_no" value="" readonly>
                           </div>

                          

                           <div class="form-group col-md-3">
                              <label class="">Party Name</label>
                              <select class="form-control select2 client_name" onclick="this.setAttribute('value', this.value);" required name="compnay_id" id="compnay_id" value="">
                                   
                                 </select>
                           </div>

                           <div class="col-md-12">
                              <h6 class="m-b-0 mt-3" style="font-weight:bold; ">Blade Details</h6>
                           <hr></div>

                           <div class="form-group col-md-3">
                              <label class="">Mould Size</label>
                              <select class="form-control select2 mould_size" onclick="this.setAttribute('value', this.value);" required name="" id="" value="">
                                   
                                 </select>
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Blade Size</label>
                              <input class="form-control" type="text" id="indent_no" placeholder="" name="blade_size" value="" >
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Blade Quantity</label>
                              <input class="form-control" type="text" id="blade_qty" placeholder="" name="blade_qty" value="" >
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Core</label>
                              <input class="form-control" type="text" id="blade_qty" placeholder="" name="core" value="" >
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Way</label>
                              <input class="form-control" type="text" id="blade_qty" placeholder="" name="Way" value="" >
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">A Tip</label>
                              <select class="form-control select2 a_tip" onclick="this.setAttribute('value', this.value);" required name="" id="" value="">
                                   
                                 </select>
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Punching Number</label>
                              <input class="form-control" type="text" id="blade_qty" placeholder="" name="punhing_n" value="" >
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Remark</label>
                              <input class="form-control" type="text" id="blade_qty" placeholder="" name="punhing_n" value="" >
                           </div>

                           <div class="form-group col-md-3">
                              <label class="">Error 404</label>
                              <select class="form-control select2 " onclick="this.setAttribute('value', this.value);" required name="" id="" value="">
                                   <option value="1">404</option>
                                 </select>
                           </div>
                       
                           <div class="form-group col-md-3">
                              <label class="">Type</label>
                              <select class="form-control select2 " onclick="this.setAttribute('value', this.value);" required name="compnay_id" id="compnay_id" value="">
                              <option value="1">Polyster</option>  
                              <option value="2">Extra Rubber</option>  
                              <option value="3">Fom Core</option>  
                              <option value="4">Rubber Bag</option>  
                              </select>
                           </div>
                         
                        </div>
                   
                     <!--   <hr> -->
                  </div>
                  
                  <!--  <div class="row"> -->
                 
               <hr>
               <button type="button" class="btn btn-success btn-theme float-right"style="margin-left: 94%;">Submit</button>
            </form>
                
                 
                
               </div>
              
                
          
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>

<!-- Sweet-Alert  -->
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>

<script src="<?= base_url(); ?>assets/js/page-js/production/indent.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script>
 
   
   // Date Picker
   jQuery('.mydatepicker, #datepicker').datepicker();
   jQuery('#datepicker-autoclose').datepicker({
       autoclose: true,
       todayHighlight: true
   });

</script>
<script>

$(document).ready(function() {
    $('#frm_indent').validate();
});
</script>
<style>
   .error{
   color: red;
   }
</style>
