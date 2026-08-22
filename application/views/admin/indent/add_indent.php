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
                <input type="hidden" name="indent_id" id="indent_id" value="<?= isset($indentData['id'])?$indentData['id']:'' ?>">
                <input type="hidden" name="id" id="id" value="<?= isset($indentData['id'])?$indentData['id']:'' ?>">
                
                <input type="hidden" name="clientId" id="clientId" value="<?= isset($indentData['client_id'])?$indentData['client_id']:'' ?>">
                 <input type="hidden" name="" id="clientPlantId" value="<?= isset($indentData['plant_id'])?$indentData['plant_id']:'' ?>">
                  <input type="hidden" name="indent_sequence" id="indent_sequence" value="<?= $indentseqNumber ?>">

                <?php
                    if(isset($indentData['id'])){
                        $indentNumber=$indentData['indent_no'];
                        $indent_date=$indentData['date'];
                    }else{
                        $indent_date=date('Y-m-d');
                    }
                ?> 
 
               <div class="row">
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
                              <select class="form-control select2 did-floating-select client_name"  id="client_id" required name="client_id" onchange="getCustomerPlantName()">
                              </select>
                               <label id="client_id-error" class="error" for="client_id"></label>
                           </div>
                           <div class="form-group col-md-3">
                              <label class="">Plant</label>
                              <select class="form-control select2 did-floating-select"  id="plants"  name="plants" >
                              </select>
                           </div>
                           <div class="form-group col-md-3">
                              <label class="">Indent No</label>
                              <input class="form-control" type="text" id="indent_no" placeholder="" name="indent_no" value="<?php echo $indentNumber; ?>" readonly>
                           </div>
                          <div class="form-group col-md-3 ">
                           <label style="border-color:#ced4da;" class="">Date</label>
                           <div class="input-group">
                              <input type="date" class="form-control" id="indent_date"  name="date" value="<?= $indent_date;  ?>" required>
                           </div>
                        </div>
                        <div class="form-group col-md-3">
                              <label class="">Mannual Indent No</label>
                            <input class="form-control" type="text" id="indent_number" placeholder="" required name="indent_number" value="<?= isset($indentData['indent_number'])?$indentData['indent_number']:'' ?>" >

                           </div>
                           <div class="form-group col-md-3 ">
                           <label style="border-color:#ced4da;" class="">Delivery Date</label>
                           <div class="input-group">
                              <input type="date" class="form-control" id="indent_date"  name="delivery_date" value="<?= $indent_date;  ?>" required>
                             
                           </div>
                        </div>
                        </div>
                   
                     <!--   <hr> -->
                  </div>
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <!--  <span class="text-color">
                              <h6><b>Indent For</b></h6>
                              </span> -->
                        </div>
                        <div class="form-group col-md-3">
                           <label class="">Indent For</label>
                           <select  class="form-control select2 did-floating-select indent_name" id="indent_name" name="indent_name" >
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label class="">Plant Name(Site)</label>
                           <select id="company_plant_name" class="select2 form-control " name="plant_name" style="width:100%"  >
                           </select>
                        </div>
                       
                        <div class="form-group col-md-3 " style="padding-top:24px;">
                           <button type="button" class="btn btn-info btn-theme open_modal_indent_blade" data-toggle="modal" data-target="#open_modal_indent_blade" ><i class="fa fa-plus-circle"></i>
                           Add Indent For
                           </button>

                           
                        </div>
                     </div>
                  </div>
                  <!--  <div class="row"> -->
                  <div class="form-group col-md-12 mt-2">
                     
                     <div class="table-responsive ">
                        <table id="tbl_indent_details" class="table display table-bordered table-striped  table color-table success-table " style="width: 100%;">
                         
                        </table>
                     </div>
                  </div>
                   
                  
               </div>
               <hr>
                <?php
                    if(isset($indentData['id'])){
                ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        
                        <div class="col-md-6 ">
                            <input type="button" id="update_indent" class="btn btn-info btn-theme float-right" onclick="updateIndent()" value="Update Indent"> 
                        </div>
                    </div>
                </div>
                    
                <?php
                    }      
                ?>
            </form>
                
                  <div id="modal_indent" class="modal fade indent large-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                           <div id="_banner">
                           </div>
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

<!-- Sweet-Alert  -->
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>

<script src="<?= base_url(); ?>assets/js/page-js/indent/indent.js"></script>
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
