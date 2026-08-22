<?php init_header();?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<!-- Date picker plugins css -->
<link href="<?= base_url()?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
   <link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
   
   <link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" /> -->
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
               <form class="repeater" action=""  enctype="multipart/form-data" method="post" id="frm" autocomplete="off">
                  <div class="row">
                     <!--  <input type="hidden" name="id" id="id" value="<?= (isset($vendor_id))? $vendor_id : '' ?>">
                        <input type="hidden" name="company_id" id="company_id" value="<?= userId('company_id'); ?>">
                        <input type="hidden" name="site_id" id="site_id" value="<?= userId('site_id'); ?>"> -->
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Add Indent</b></h6>
                              </span>
                              <hr>
                           </div>
                           <div class="form-group col-md-3">
                              <label style="border-color:#ced4da;" class="">Client Name</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Client Name</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 ">
                              <label class="">Indent No</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                        </div>
                        <!--   <hr> -->
                     </div>
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Indent For</b></h6>
                              </span>
                           </div>
                           <div class="form-group col-md-3">
                              <!--  <label style="border-color:#ced4da;" class="">Client Name</label> -->
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Fan & Blade</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3">
                              <!--  <label style="border-color:#ced4da;" class="">Client Name</label> -->
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Plant</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="col-md-3">
                              <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme"><i class="fa fa-plus-circle"></i>Add Row</button></a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <span class="text-color">
                           <h6><b>Blade</b></h6>
                        </span>
                        <hr>
                     </div>
                     <div class="col-md-12 mb-2" data-repeater-list="indent_blade" style="background: #eff1f3;">
                        <div class="row" data-repeater-item class="repeater-item">
                           <div class="form-group col-md-3">
                              <label style="border-color:#ced4da;" class="">Date</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-3 ">
                              <label class="">Project</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3">
                              <label style="border-color:#ced4da;" class="">Module Size</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Module Size</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 ">
                              <label class="">Fan-Dia</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Blade Qty</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">A.Tip(mm)</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select A.Tip Size</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Blade Size(mm)</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Blade Punching Number</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">No Of Set</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select No Of Set</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Color</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Color</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Name Plate</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Material</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select No Of Set</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Delivery Date</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" id="datepicker-autoclose123" placeholder="mm/dd/yyyy">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Tag Number</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Product Plant</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Product Plant</option>
                              </select>
                           </div>
                           <div class="col-md-3" style="padding-top: 27px;">  
                              <button data-repeater-delete class="btn btn-danger " type="button" style="" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                           </div>
                        </div>
                      <!--    <hr style="border-color: #ffffff;"> -->
                      <div class="" style="padding-top: 30px;"><hr style="border-color: #ffffff;"> </div>
                     </div>
                     <div class="col-md-6">
                        <span class="text-color">
                           <h6><b>Hub</b></h6>
                        </span>
                        <hr>
                     </div>
                     <div class="col-md-6" align="right">
                           <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme">Add Hub</button></a>
                        </div>
                     <div class="col-md-12 mb-2" data-repeater-list="indent_hub" style="background: #eff1f3;">
                        <div class="row" data-repeater-item class="repeater-item">
                          <!--  <div class="form-group col-md-3">
                              <label style="border-color:#ced4da;" class="">Date</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div> -->
                           <div class="form-group col-md-3 ">
                              <label class="">Hub</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3">
                              <label style="border-color:#ced4da;" class="">Clamp</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Clamp Size</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 ">
                              <label class="">Hub Spool</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Taper Bush</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Bore</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Bore Size</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Key Way</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Key Way</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Spacer</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Hardwares</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select</option>
                                 <option value="1">Current</option>
                                 <option value="2">Saving</option>
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Qty</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select </option>
                                
                              </select>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Fan Stack</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select </option>
                                
                              </select>
                           </div>
                            <div class="form-group col-md-3 mt-2">
                              <label class="">Frp Pultrusion</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                             <div class="form-group col-md-3 mt-2">
                              <label class="">Frp Cladding Sheet</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Delivery Date</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" id="datepicker-autoclose-delivery-date" placeholder="mm/dd/yyyy">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label class="">Tag Number</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                            <div class="form-group col-md-3 mt-2">
                              <label class="">Material</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="" >
                           </div>
                           <div class="form-group col-md-3 mt-2">
                              <label style="border-color:#ced4da;" class="">Product Plant</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Select Product Plant</option>
                              </select>
                           </div>
                         <!--   <div class="col-md-3" style="padding-top: 27px;">  
                              <button data-repeater-delete class="btn btn-danger " type="button" style="" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                           </div> -->
                        </div>
                      <!--    <hr style="border-color: #ffffff;"> -->
                      <div class="" style="padding-top: 30px;"><hr style="border-color: #ffffff;"> </div>
                     </div>
                   
                  </div>
                  <hr>
                  <input type="submit" id="btnsubmit" style="margin-left: 90%;" class="btn btn-info btn-theme" value="Submit">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/add_vendor_repeater.int.js"></script>
<!-- <script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
   <script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
   <script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
   <script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>
   <script src="<?= base_url(); ?>assets/js/page-js/vendor.js"></script>
   <script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script> -->
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script>
   $('#check-minutes').click(function(e) {
       // Have to stop propagation here
       e.stopPropagation();
       input.clockpicker('show').clockpicker('toggleView', 'minutes');
   });
   if (/mobile/i.test(navigator.userAgent)) {
       $('input').prop('readOnly', true);
   }
   
   
   // Date Picker
   jQuery('.mydatepicker, #datepicker').datepicker();
   jQuery('#datepicker-autoclose').datepicker({
       autoclose: true,
       todayHighlight: true
   });
    jQuery('#datepicker-autoclose123').datepicker({
       autoclose: true,
       todayHighlight: true
   });
   
     jQuery('#datepicker-autoclose-delivery-date').datepicker({
       autoclose: true,
       todayHighlight: true
   });
   jQuery('#date-range').datepicker({
       toggleActive: true
   });
   jQuery('#datepicker-inline').datepicker({
       todayHighlight: true
   });
   
   
</script>


 <div class="form-group col-md-3">
                              <!--  <label style="border-color:#ced4da;" class="">Client Name</label> -->
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option>Fan & Blade</option>
                                 <option value="1">Fan & Blade</option>
                                 <option value="2">Hub</option>
                                 <option value="3">Fan Stack</option>
                                 <option value="4">Frp Pultrusion</option>
                                 <option value="5">Frp Cladding Sheet</option>
                                 <option value="6">Frp Basin Sump</option>
                              </select>
                           </div>

                           

// $('.open_modal_indent_blade').on('click', function() {
//     open_modal_indent_blade();
//   });

//   function open_modal_indent_blade(id='') {

//     $.ajax({
//           url: base_url +'admin/indent/Indent/open_modal_indent_blade',
//           type: 'POST',
//           data: {'id':id},
//           dataType:'json',
//           success: function(res) {
//               $('#_banner').html();
//             if (res.result == true) {
//               $('#_banner').html(res.html);
//               $('#modal_blade').modal('show');
//               // $("#catdrop").select2();
//             }else{
//               alert_float('error',response.reason);
//             }
//           }
//       })
//   }




// $('.open_modal_indent_blade').on('click', function() {
//     var selectedValue = $('#dropdown').val(); // Get the selected dropdown value
//     open_modal_indent_blade(selectedValue);
// });

// function open_modal_indent_blade(selectedValue) {
//     var url;
//     // Determine the URL based on the selected dropdown value
//     if (selectedValue === '1') {
//         url = base_url + 'admin/indent/Indent/open_modal_indent_blade';
//     } else if (selectedValue === '2') {
//         url = base_url + 'admin/indent/Indent/open_modal_indent_hub';
//     }else if (selectedValue === '3') {
//         url = base_url + 'admin/indent/Indent/open_modal_fan_stack';
//     }else if (selectedValue === '4') {
//         url = base_url + 'admin/indent/Indent/open_modal_frp_pultrusion';
//     }else if (selectedValue === '5') {
//         url = base_url + 'admin/indent/Indent/open_modal_frp_cladding_sheet';
//     }
//     else if (selectedValue === '6') {
//         url = base_url + 'admin/indent/Indent/open_modal_frp_basin_sump';
//     } else if (selectedValue === '7') {
//         url = base_url + 'admin/indent/Indent/open_modal_carbon_fiber_drive_shift';
//     }
//     else if (selectedValue === '8') {
//         url = base_url + 'admin/indent/Indent/open_modal_torque_tube_base_frame';
//     } else if (selectedValue === '9') {
//         url = base_url + 'admin/indent/Indent/open_modal_bracket_fan_guard';
//     }else if (selectedValue === '10') {
//         url = base_url + 'admin/indent/Indent/open_modal_nozzle';
//     }else if (selectedValue === '11') {
//         url = base_url + 'admin/indent/Indent/open_modal_fills';
//     }else if (selectedValue === '12') {
//         url = base_url + 'admin/indent/Indent/open_modal_draft_eliminator';
//     }else if (selectedValue === '13') {
//         url = base_url + 'admin/indent/Indent/open_modal_motor';
//     }else if (selectedValue === '14') {
//         url = base_url + 'admin/indent/Indent/open_modal_gear_box';
//     }else if (selectedValue === '15') {
//         url = base_url + 'admin/indent/Indent/open_modal_gearbox_oil';
//     }else if (selectedValue === '16') {
//         url = base_url + 'admin/indent/Indent/open_modal_oil_level_and_vibration_cut_off_switch';
//     }else if (selectedValue === '17') {
//         url = base_url + 'admin/indent/Indent/open_modal_junction_box_for_instruments';
//     }else if (selectedValue === '18') {
//         url = base_url + 'admin/indent/Indent/open_modal_all_hardware';
//     }else if (selectedValue === '19') {
//         url = base_url + 'admin/indent/Indent/open_modal_fan_dia';
//     }else if (selectedValue === '20') {
//         url = base_url + 'admin/indent/Indent/open_modal_motor_canopy';
//     }
//     // Add more conditions for additional dropdown values and URLs if needed  

//     // Make AJAX request to fetch the content for the selected modal
//     $.ajax({
//         url: url,
//         type: 'POST',
//         data: {'id': selectedValue},
//         dataType: 'json',
//         success: function(res) {
//             if (res.result == true) {
//                   $('#modal_indent').modal('show');
//                     $('#modal_indent .modal-content').html(res.html);
               
//             } else {
//                 alert_float('error', response.reason);
//             }
//         }
//     });
// }