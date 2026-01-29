<style>
   label.error{
   display: none !important;
   }
   .select2-selection__rendered{
   margin-top: 1px;
   }
   .margin-bottom-7{
   margin-bottom: 7px !important;
   }
   .margin-bottom-20{
   margin-bottom: 20px !important;
   }
   label {
   margin-bottom: 0.2rem;
   }
   #mapping{
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
</style>
<form method="post" action="<?= base_url(ADMIN.'indent/Indent/saveIndentAllModule')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Carbon Fiber Drive Shift</h4>
      <hr>
     <input type="hidden" name="master_indent_id" id="master_indent_id" value="<?= (isset($master_indent_id)?$master_indent_id:"") ?>">
      <input type="hidden" name="indent_id" id="indentIdModal" value="<?= (isset($indent_id)?$indent_id:"") ?>">
      <input type="hidden" name="plant_id" id="plant_id" value="<?= (isset($plant_id)?$plant_id:"") ?>">
      <input type="hidden" id="id" name="id" value="<?= (isset($id)?$id:"") ?>">
      <div class="row">
         <div class="form-group col-md-4 mt-1">
            <label class="">Dimension</label>
            <input class="form-control " type="text"  id="dimension" name="dimension" value="<?= isset($dimension)?$dimension:'';?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Material</label>
            <select class="form-control select2 did-floating-select"  id="material"  name="material" >
               <option >select</option>
               <option value="Carbon Fibre Composite"  <?= (isset($material) && ($material == "Carbon Fibre Composite")) ? "selected" : "" ?>>Carbon Fibre Composite </option>
            </select>
         </div>
         <!-- </div> -->
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Remark</label>
            <input class="form-control " type="text" id="remark" name="remark"   value="<?= isset($remark)?$remark:'';?>" required >             
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Qty</label>
            <input class="form-control " type="text" id="qty" name="qty"   value="<?= isset($qty)?$qty:'';?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Make</label>
            <input class="form-control " type="text" id="make" name="make"   value="<?= isset($make)?$make:'';?>" required>
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
<script>
   $(document).ready(function () {
      $('#form').validate();
   });
</script>