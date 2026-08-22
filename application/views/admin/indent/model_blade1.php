<link href="<?= base_url() ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<style>
   .select2-selection__rendered {
      margin-top: 1px;
   }

   .margin-bottom-7 {
      margin-bottom: 7px !important;
   }

   .margin-bottom-20 {
      margin-bottom: 20px !important;
   }

   label {
      margin-bottom: 0.2rem;
   }

   #mapping {
      margin-left: 20px;
   }

   form label {
      font-weight: 628;
   }

   .select2-selection--multiple {
      border: solid #ced4da 1px !important;
   }

   .datepicker {
      z-index: 1100 !important;
   }
</style>
<form method="post" action="<?= base_url(ADMIN . 'indent/Indent/saveIndentAllModule') ?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Blade</h4>
      <hr>
      <input type="hidden" name="master_indent_id" id="master_indent_id" value="<?= (isset($master_indent_id) ? $master_indent_id : "") ?>">
      <input type="hidden" name="indent_id" id="indentIdModal" value="<?= (isset($indent_id) ? $indent_id : "") ?>">
      <input type="hidden" name="plant_id" id="plant_id" value="<?= (isset($plant_id) ? $plant_id : "") ?>">
      <input type="hidden" id="id" name="id" value="<?= (isset($id) ? $id : "") ?>">
      <input type="hidden" id="mouldSize"  value="<?= (isset($mould_size) ? $mould_size : "") ?>">
      <input type="hidden" id="aTip"  value="<?= (isset($a_tip) ? $a_tip : "") ?>">
      <input type="hidden" id="dcolor"  value="<?= (isset($color) ? $color : "") ?>">


      <div class="row">
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Mould Size</label>
            <select class="form-control select2 module_size" id="mould_size" required name="mould_size">
               <option value=""></option>
               <!-- <option value="1" <?= (isset($mould_size) && ($mould_size == 1)) ? "selected" : "" ?>>3000C</option> -->
            </select>
            <label id="module_size-error" class="error" for="module_size"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Blade Size(mm)</label>
            <input class="form-control" type="text" placeholder="" name="blade_size" value="<?= isset($blade_size) ? $blade_size : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Blade Qty</label>
            <input class="form-control" type="text" placeholder="" name="blade_qty" value="<?= isset($blade_qty) ? $blade_qty : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Blade Punching Number</label>
            <input class="form-control" type="text" placeholder="" name="blade_punching_no" value="<?= isset($blade_punching_no) ? $blade_punching_no : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">A.Tip(mm)</label>
            <select class="form-control select2 did-floating-select a_tip" id="a_tip" name="a_tip" required>
            
            </select>
            <label id="a_tip-error" class="error" for="a_tip"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Color</label>
            <select class="form-control select2 did-floating-select color" id="color" name="color" value="<?= isset($color) ? $color : ''; ?>" required>
              
            </select>
            <label id="color-error" class="error" for="color"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Name Plate</label>
            <input class="form-control" type="text" placeholder="" name="name_plate" value="<?= isset($name_plate) ? $name_plate : ''; ?>" required>
         </div>
      </div>
   </div>

   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
      <button type="button" class="btn   waves-effect waves-light" id="submit_btn_modal" onclick="submitAllIndentMaster()" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>

<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/indent/masters/select2.js"></script>


<script>
   $(document).ready(function() {
      $('#form').validate();
   });
</script>
<style>
   .error {
      color: red;
   }
</style>