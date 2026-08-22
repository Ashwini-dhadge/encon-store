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
      <input type="hidden" id="mouldSize" value="<?= (isset($mould_size) ? $mould_size : "") ?>">
      <input type="hidden" id="aTip" value="<?= (isset($a_tip) ? $a_tip : "") ?>">
      <input type="hidden" id="dcolor" value="<?= (isset($color) ? $color : "") ?>">


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
            <input class="form-control" type="text" placeholder="" id="blade_size" name="blade_size" value="<?= isset($blade_size) ? $blade_size : ''; ?>" required>
         </div>
         <div class="form-group col-md-3">
            <label>Hub Size</label>
            <input class="form-control" type="text" id="hub_size" name="hub_size" value="<?= isset($hub_size) ? $hub_size : ''; ?>">
         </div>

         <!-- <div class="form-group col-md-3">
            <label>Clamp Size</label>
            <input class="form-control" type="text" id="clamp_size" name="clamp_size" value="<?= isset($clamp_size) ? $clamp_size : ''; ?>">
            <select class="form-control select2" name="hub_size" required>
               <?php foreach ($clamp_size as $value) { ?>
                  <option value=""><?= $value['clamp_size'] ?></option>
               <?php } ?>
            </select>
         </div> -->

         <div class="form-group col-md-3">
            <label>Clamp Size</label>
            <select class="form-control select2" id="clamp_size" name="clamp_size" required>
               <option value="">Select Clamp Size</option>
               <?php
               $sizes = [];
               foreach ($clamp_size as $value) {
                  if (!in_array($value['clamp_size'], $sizes)) {
                     $sizes[] = $value['clamp_size'];
               ?>
                     <option value="<?= $value['clamp_size']; ?>">
                        <?= $value['clamp_size']; ?>
                     </option>
               <?php
                  }
               }
               ?>
            </select>
         </div>

         <div class="form-group col-md-3">
            <label>Collor Length</label>
            <input class="form-control" type="text" id="collor_length" name="collor_length" value="<?= isset($collor_length) ? $collor_length : ''; ?>">
         </div>

         <!-- <div class="form-group col-md-3">
            <label>Clamp Length</label>
            <input class="form-control" type="text" id="clamp_length" name="clamp_length" value="<?= isset($clamp_length) ? $clamp_length : ''; ?>">
            <select class="form-control select2 clamp_length" id="clamp_length" name="clamp_length" required>
               <option value="" disabled selected>Select Dimension</option>
               <?php foreach ($clamp_size as $value) { ?>
                  <option value=""><?= $value['clamp_length'] ?></option>
               <?php } ?>
            </select>
         </div> -->

         <div class="form-group col-md-3">
            <label>Clamp Length</label>
            <select class="form-control select2" id="clamp_length" name="clamp_length" required>
               <option value="">Select Clamp Length</option>
            </select>
         </div>

         <div class="form-group col-md-3">
            <label>Clamp to Hub Dist</label>
            <input class="form-control" type="text" id="collor_hub_dist" name="collor_hub_dist" value="<?= isset($collor_hub_dist) ? $collor_hub_dist : ''; ?>">
         </div>

         <div class="form-group col-md-3">
            <label>Fan Dia (MM)</label>
            <input class="form-control" type="text" id="fan_dia_mm" name="fan_dia_mm" readonly value="<?= isset($fan_dia_mm) ? $fan_dia_mm : ''; ?>">
         </div>

         <div class="form-group col-md-3">
            <label class="">Fan Dia (FT)</label>
            <input class="form-control" type="text" id="fan_dia_ft" name="fan_dia_ft" readonly value="<?= isset($fan_dia_ft) ? $fan_dia_ft : ''; ?>">
         </div>

         <div class="form-group col-md-6 mt-1">
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
         <div class="form-group col-md-4 mt-1">
            <label class="">Way</label>
            <input class="form-control" type="text" placeholder="" name="way" value="<?= isset($set) ? $set : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Set</label>
            <input class="form-control" type="text" placeholder="" name="set" value="<?= isset($way) ? $way : ''; ?>" required>
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
   var clampData = <?= json_encode($clamp_size); ?>;

   $('#clamp_size').on('change', function() {

      var size = $(this).val();

      $('#clamp_length').empty();
      $('#clamp_length').append('<option value="">Select Clamp Length</option>');

      $.each(clampData, function(i, item) {

         if (item.clamp_size == size) {

            $('#clamp_length').append(
               '<option value="' + item.clamp_length + '">' +
               item.clamp_length +
               '</option>'
            );

         }

      });

      $('#clamp_length').trigger('change');
   });
</script>
<script>
   function calculateFanDiaMM() {
      let bladeSize = parseFloat(document.getElementById('blade_size').value) || 0;
      let hubSize = parseFloat(document.getElementById('hub_size').value) || 0;
      let clampLength = parseFloat(document.getElementById('clamp_length').value) || 0;
      let collorLength = parseFloat(document.getElementById('collor_length').value) || 0;
      let collorHubDist = parseFloat(document.getElementById('collor_hub_dist').value) || 0;

      let fanDiaMM =
         (bladeSize * 2) +
         hubSize -
         (collorLength * 2) -
         (clampLength * 2) -
         (collorHubDist * 2);

      document.getElementById('fan_dia_mm').value = fanDiaMM.toFixed(2);

      let fanDiaFT = fanDiaMM / 304.8;
      document.getElementById('fan_dia_ft').value = parseFloat(fanDiaFT.toFixed(2));
   }

   // Existing inputs
   [
      'blade_size',
      'hub_size',
      'collor_length',
      'collor_hub_dist'
   ].forEach(function(id) {
      document.getElementById(id).addEventListener('input', calculateFanDiaMM);
   });

   // Clamp length is a select
   document.getElementById('clamp_length').addEventListener('change', calculateFanDiaMM);
</script>
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