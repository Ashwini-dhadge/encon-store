<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
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
   .select2-selection--multiple{
   border: solid #ced4da 1px !important;
   }
   .datepicker{
   z-index: 1100 !important;
   }
   .error{
   color:red;
   }
</style>
<form method="post" action="<?= base_url(ADMIN . 'indent/Indent/saveIndentAllModule') ?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Fan Stack</h4>
      <hr>
      <input type="hidden" name="master_indent_id" id="master_indent_id" value="<?= (isset($master_indent_id) ? $master_indent_id : "") ?>">
      <input type="hidden" name="indent_id" id="indentIdModal" value="<?= (isset($indent_id) ? $indent_id : "") ?>">
      <input type="hidden" name="plant_id" id="plant_id" value="<?= (isset($plant_id) ? $plant_id : "") ?>">
      <input type="hidden" id="id" name="id" value="<?= (isset($id) ? $id : "") ?>">
      <input type="hidden" id="FanStackdimension" value="<?= (isset($dimension) ? $dimension : "") ?>">
       <input type="hidden" id="Fanmaterial" value="<?= (isset($material) ? $material : "") ?>">
      <input type="hidden" id="Fanheight" value="<?= (isset($height) ? $height : "") ?>">
      
      <div class="row">
         <div class="form-group col-md-4 mt-1">
            <label class="">Dimension</label>
            <select class="form-control select2 did-floating-select dimension" id="dimension" required name="dimension">
              
            </select>
            <label id="dimension-error" class="error" for="dimension"></label>
         </div>
         <!-- </div> -->
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Height</label>
            <select class="form-control select2 did-floating-select heights" required id="height" name="height">
               
            </select>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Qty</label>
            <input class="form-control " type="text" name="qty" id="qty" value="<?= isset($qty) ? $qty : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Material</label>
            
            <select class="form-control select2 did-floating-select" id="material" required name="material">
               <option value="">Select</option>
               <option value="FRP"<?= (isset($material)&& $material=='FRP' ? 'selected' : "") ?>>FRP</option>
            </select>
            <!--<select class="form-control select2 did-floating-select material" id="material" required name="material" required>
               
            </select>-->
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Remark</label>
            <input class="form-control " type="text" id="remark" required name="remark" value="<?= isset($remark) ? $remark : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Make</label>
            <input class="form-control " type="text" id="make" required name="make" value="<?= isset($make) ? $make : ''; ?>" required>
         </div>
      </div>
   </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
      <button type="button" class="btn   waves-effect waves-light" id="submit_btn_modal" onclick="submitAllIndentMaster()" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/indent/masters/select2.js"></script>
<script>
   $(document).ready(function () {
      $('#form').validate();
   });
</script>