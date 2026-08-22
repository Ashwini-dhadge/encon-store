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
      <h4>Add Hub</h4>
      <hr>
      <input type="hidden" name="master_indent_id" id="master_indent_id" value="<?= (isset($master_indent_id) ? $master_indent_id : "") ?>">
      <input type="hidden" name="indent_id" id="indentIdModal" value="<?= (isset($indent_id) ? $indent_id : "") ?>">
      <input type="hidden" name="plant_id" id="plant_id" value="<?= (isset($plant_id) ? $plant_id : "") ?>">
      <input type="hidden" id="id" name="id" value="<?= (isset($id) ? $id : "") ?>">
      <input type="hidden" id="hubSize"  value="<?= (isset($hub_size) ? $hub_size : "") ?>">
      <input type="hidden" id="hubMaterial"  value="<?= (isset($hub_material) ? $hub_material : "") ?>">
      <input type="hidden" id="hubHardwares"  value="<?= (isset($hardwares) ? $hardwares : "") ?>">
      <input type="hidden" id="hubThickness"  value="<?= (isset($thikness) ? $thikness : "") ?>">
      <input type="hidden" id="hubPlateOd"  value="<?= (isset($plate_od) ? $plate_od : "") ?>">
       
      <div class="row">
         <!--<div class="form-group col-md-4 mt-1">-->
         <!--   <label class="">Hub Plate/Hub Size</label>-->
         <!--   <select class="form-control select2 did-floating-select hub_size" id="hub_size" required name="hub_size">-->
         <!--      <option value="">Select</option>-->
            
         <!--   </select>-->
         <!--   <label id="hub_size-error" class="error" for="hub_size"></label>-->
         <!--</div>-->
         <div class="form-group col-md-4 mt-1">
            <label class="">Hub Material</label>
            <select class="form-control select2 did-floating-select material" id="material" required name="hub_material">
            </select>
            <label id="material-error" class="error" for="material"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Bore</label>
            <input class="form-control" type="text" placeholder="" name="bore" required id="bore" value="<?= isset($bore) ? $bore : ''; ?>">
            <label id="bore-error" class="error" for="bore"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Taper Bush</label>
            <select class="form-control select2 did-floating-select" id="taper_bush" required name="taper_bush">
               <option value="">Select</option>
               <option value="190MM ODX110MML SG"<?= (isset($taper_bush)&& $taper_bush=='190MM ODX110MML SG' ? 'selected' : "") ?>>190MM ODX110MML SG</option>
                <option value="290MM ODX150MML SG"<?= (isset($taper_bush)&& $taper_bush=='290MM ODX150MML SG' ? 'selected' : "") ?>>290MM ODX150MML SG</option>
                <option value="320MM ODX170MML SG"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX170MML SG' ? 'selected' : "") ?>>320MM ODX170MML SG</option>
                <option value="270MM ODX195MML SG"<?= (isset($taper_bush)&& $taper_bush=='270MM ODX195MML SG' ? 'selected' : "") ?>>270MM ODX195MML SG</option>
                <option value="300MM ODX255MML SG"<?= (isset($taper_bush)&& $taper_bush=='300MM ODX255MML SG' ? 'selected' : "") ?>>300MM ODX255MML SG</option>
                <option value="320MM ODX255MML SG"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX255MML SG' ? 'selected' : "") ?>>320MM ODX255MML SG</option>
                <option value="320MM ODX220MML SG"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX220MML SG' ? 'selected' : "") ?>>320MM ODX220MML SG</option>
                <option value="320MM ODX305MML SG"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX305MML SG' ? 'selected' : "") ?>>320MM ODX305MML SG</option>
                <option value="360MM ODX305MML SG"<?= (isset($taper_bush)&& $taper_bush=='360MM ODX305MML SG' ? 'selected' : "") ?>>360MM ODX305MML SG</option>
                <option value="320MM ODX305MML SG"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX305MML SG' ? 'selected' : "") ?>>320MM ODX305MML SG</option>
                <option value="410MM ODX305MML SG"<?= (isset($taper_bush)&& $taper_bush=='410MM ODX305MML SG' ? 'selected' : "") ?>>410MM ODX305MML SG</option>
                <option value="290MM ODX140MML SS304"<?= (isset($taper_bush)&& $taper_bush=='290MM ODX140MML SS304' ? 'selected' : "") ?>>290MM ODX140MML SS304</option>
                <option value="320MM ODX170MML SS304"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX170MML SS304' ? 'selected' : "") ?>>320MM ODX170MML SS304</option>
                <option value="160MM ODX100MML SS316L"<?= (isset($taper_bush)&& $taper_bush=='160MM ODX100MML SS316L' ? 'selected' : "") ?>>160MM ODX100MML SS316L</option>
                <option value="290MM ODX140MML SS316L"<?= (isset($taper_bush)&& $taper_bush=='290MM ODX140MML SS316L' ? 'selected' : "") ?>>290MM ODX140MML SS316L</option>
                <option value="320MM ODX170MML SS316l"<?= (isset($taper_bush)&& $taper_bush=='320MM ODX170MML SS316l' ? 'selected' : "") ?>>320MM ODX170MML SS316l</option>
            </select>
            <label id="taper_bush-error" class="error" for="taper_bush"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Taper Bush Material</label>
            <select class="form-control  did-floating-select " id="taper_bush_material" required name="taper_bush_material">
            <option value="">Select</option>
                <option value="HG Iron Grade 415">HG Iron Grade 415</option>
               <option value="CI Grade 20" <?= (isset($taper_bush_material)&& $taper_bush_material=='CI Grade 20' ? 'selected' : "") ?>>CI Grade 20</option> 
               <option value="SS304" <?= (isset($taper_bush_material)&& $taper_bush_material=='SS304' ? 'selected' : "") ?>>SS304</option> 
               <option value="SS316" <?= (isset($taper_bush_material)&& $taper_bush_material=='SS316' ? 'selected' : "") ?>>SS316</option> 
               <option value="SS316L" <?= (isset($taper_bush_material)&& $taper_bush_material=='SS316L' ? 'selected' : "") ?>>SS316L</option> 
               <option value="MS" <?= (isset($taper_bush_material)&& $taper_bush_material=='MS' ? 'selected' : "") ?>>MS</option> 
               
               
            </select>
            <label id="material-error" class="error" for="material"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Key Way</label>
            <input class="form-control" type="text" placeholder="" name="keyway" required id="keyway" value="<?= isset($keyway) ? $keyway : ''; ?>">
            <label id="keyway-error" class="error" for="keyway"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Hub Spool</label>
            <input class="form-control" type="text" placeholder="" name="hub_spool" required id="hub_spool" value="<?= isset($hub_spool) ? $hub_spool : ''; ?>">
            <label id="hub_spool-error" class="error" for="hub_spool"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Hub Spool Material</label>
            <select class="form-control  did-floating-select " id="material" required name="hub_spool_material">
                <option value="">Select</option>
                <option value="HG Iron Grade 415">HG Iron Grade 415</option>
                <option value="CI Grade 20" <?= (isset($hub_spool_material)&& $hub_spool_material=='CI Grade 20' ? 'selected' : "") ?>>CI Grade 20</option> 
                <option value="SS304" <?= (isset($hub_spool_material)&& $hub_spool_material=='SS304' ? 'selected' : "") ?>>SS304</option> 
                <option value="SS316" <?= (isset($hub_spool_material)&& $hub_spool_material=='SS316' ? 'selected' : "") ?>>SS316</option> 
                <option value="SS316L" <?= (isset($hub_spool_material)&& $hub_spool_material=='SS316L' ? 'selected' : "") ?>>SS316L</option> 
                <option value="MS" <?= (isset($hub_spool_material)&& $hub_spool_material=='MS' ? 'selected' : "") ?>>MS</option> 
            </select>
            <label id="material-error" class="error" for="material"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Spacer</label>
            <input class="form-control" type="text" placeholder="" name="spacer" required id="spacer" value="<?= isset($spacer) ? $spacer : ''; ?>">
            <label id="spacer-error" class="error" for="spacer"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Hardwares</label>
            <select class="form-control select2 did-floating-select hardwares" id="hardwares" required name="hardwares">
               <option value="">Select</option>
            </select>
            <label id="hardwares-error" class="error" for="hardwares"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Qty</label>
            <input class="form-control" type="text" placeholder="" name="qty" required id="qty" value="<?= isset($qty) ? $qty : ''; ?>">
            <label id="qty-error" class="error" for="qty"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Clamp way</label>
            <input class="form-control" type="text" placeholder="" name="clamp_way" required id="clamp_way" value="<?= isset($clamp_way) ? $clamp_way : ''; ?>">
            <label id="clamp_way-error" class="error" for="clamp_way"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Clamp</label>
            <select class="form-control select2 did-floating-select" id="clamp" required name="clamp">
               <option value="">Select</option>
               <option value="5155 FRP" <?= (isset($clamp)&& $clamp=='5155 FRP' ? 'selected' : "") ?>> 5155 FRP</option>
                <option value="7576 FRP" <?= (isset($clamp)&& $clamp=='7576 FRP' ? 'selected' : "") ?>>7576 FRP</option>
                <option value="8081 FRP" <?= (isset($clamp)&& $clamp=='8081 FRP' ? 'selected' : "") ?>>8081 FRP</option>
                <option value="103105 FRP" <?= (isset($clamp)&& $clamp=='103105 FRP' ? 'selected' : "") ?>>103105 FRP</option>
                <option value="128130 FRP" <?= (isset($clamp)&& $clamp=='128130 FRP' ? 'selected' : "") ?>>128130 FRP</option>
                <option value="152155 FRP" <?= (isset($clamp)&& $clamp=='152155 FRP' ? 'selected' : "") ?>>152155 FRP</option>
                <option value="158159 FRP" <?= (isset($clamp)&& $clamp=='158159 FRP' ? 'selected' : "") ?>>158159 FRP</option>
                <option value="145150 FRP" <?= (isset($clamp)&& $clamp=='145150 FRP' ? 'selected' : "") ?>>145150 FRP</option>
                <option value="168171 FRP" <?= (isset($clamp)&& $clamp=='168171 FRP' ? 'selected' : "") ?>>168171 FRP</option>
                <option value="181185 FRP" <?= (isset($clamp)&& $clamp=='181185 FRP' ? 'selected' : "") ?>>181185 FRP</option>
                <option value="4141 HE 30 OF" <?= (isset($clamp)&& $clamp=='4141 HE 30 OF' ? 'selected' : "") ?>>4141 HE 30 OF</option>
                <option value="5155 HE 30 OF" <?= (isset($clamp)&& $clamp=='5155 HE 30 OF' ? 'selected' : "") ?>>5155 HE 30 OF</option>
                <option value="7576 SS304 OF" <?= (isset($clamp)&& $clamp=='5155 HE 30 OF' ? 'selected' : "") ?>>5155 HE 30 OF</option>
                <option value="7576 SS316L OF" <?= (isset($clamp)&& $clamp=='7576 SS316L OF' ? 'selected' : "") ?>>7576 SS316L OF</option>
                <option value="8081 SS304 OF" <?= (isset($clamp)&& $clamp=='8081 SS304 OF' ? 'selected' : "") ?>>8081 SS304 OF</option>
                <option value="8081 SS316L OF" <?= (isset($clamp)&& $clamp=='>8081 SS316L OF' ? 'selected' : "") ?>>8081 SS316L OF</option>
                <option value="103105 SS304 OF" <?= (isset($clamp)&& $clamp=='103105 SS304 OF' ? 'selected' : "") ?>>103105 SS304 OF</option>
                <option value="103105  SS316L OF" <?= (isset($clamp)&& $clamp=='103105  SS316L OF' ? 'selected' : "") ?>>103105  SS316L OF</option>
                <option value="128130 SS304 OF" <?= (isset($clamp)&& $clamp=='128130 SS304 OF' ? 'selected' : "") ?>>128130 SS304 OF</option>
                <option value="128130  SS316L OF" <?= (isset($clamp)&& $clamp=='128130  SS316L OF' ? 'selected' : "") ?>>128130  SS316L OF</option>
                <option value="152155 SS304 OF" <?= (isset($clamp)&& $clamp=='152155 SS304 OF' ? 'selected' : "") ?>>152155 SS304 OF</option>
                <option value="152155  SS316L OF" <?= (isset($clamp)&& $clamp=='152155  SS316L OF' ? 'selected' : "") ?>>152155  SS316L OF</option>
                <option value="158159 SS304 OF" <?= (isset($clamp)&& $clamp=='158159 SS304 OF' ? 'selected' : "") ?>>158159 SS304 OF</option>
                <option value="158159  SS316L OF" <?= (isset($clamp)&& $clamp=='158159  SS316L OF' ? 'selected' : "") ?>>158159  SS316L OF</option>
                <option value="145150 SS304OF" <?= (isset($clamp)&& $clamp=='145150 SS304OF' ? 'selected' : "") ?>>145150 SS304OF</option>
                <option value="145150  SS316L OF" <?= (isset($clamp)&& $clamp=='145150  SS316L OF' ? 'selected' : "") ?>>145150  SS316L OF</option>
                <option value="168171 SS304 OF" <?= (isset($clamp)&& $clamp=='168171 SS304 OF' ? 'selected' : "") ?>>168171 SS304 OF</option>
                <option value="168171  SS316L OF" <?= (isset($clamp)&& $clamp=='168171  SS316L OF' ? 'selected' : "") ?>>168171  SS316L OF</option>
                <option value="181185 SS304 OF" <?= (isset($clamp)&& $clamp=='181185 SS304 OF' ? 'selected' : "") ?>>181185 SS304 OF</option>
                <option value="181185  SS316L OF" <?= (isset($clamp)&& $clamp=='181185  SS316L OF' ? 'selected' : "") ?>>181185  SS316L OF</option>
                <option value="2525 AL" <?= (isset($clamp)&& $clamp=='2525 AL' ? 'selected' : "") ?>>2525 AL</option>
                <option value="3131 AL" <?= (isset($clamp)&& $clamp=='3131 AL' ? 'selected' : "") ?>>3131 AL</option>
                <option value="4141 AL" <?= (isset($clamp)&& $clamp=='4141 AL' ? 'selected' : "") ?>>4141 AL</option>
                <option value="5155 AL" <?= (isset($clamp)&& $clamp=='5155 AL' ? 'selected' : "") ?>>5155 AL</option>
                <option value="6566 AL" <?= (isset($clamp)&& $clamp=='6566 AL' ? 'selected' : "") ?>>6566 AL</option>
                <option value="7576 AL" <?= (isset($clamp)&& $clamp=='7576 AL' ? 'selected' : "") ?>>7576 AL</option>
                <option value="8081 AL" <?= (isset($clamp)&& $clamp=='8081 AL' ? 'selected' : "") ?>>8081 AL</option>
                <option value="103105 AL" <?= (isset($clamp)&& $clamp=='103105 AL' ? 'selected' : "") ?>> 103105 AL</option>
                <option value="128130 AL" <?= (isset($clamp)&& $clamp=='128130 AL' ? 'selected' : "") ?>> 128130 AL</option>
                <option value="152155 AL" <?= (isset($clamp)&& $clamp=='152155 AL' ? 'selected' : "") ?>> 152155 AL</option>
                <option value="158159 AL" <?= (isset($clamp)&& $clamp=='158159 AL' ? 'selected' : "") ?>> 158159 AL</option>
                <option value="145150 AL" <?= (isset($clamp)&& $clamp=='145150 AL' ? 'selected' : "") ?>> 145150 AL</option>
                <option value="168171 AL" <?= (isset($clamp)&& $clamp=='168171 AL' ? 'selected' : "") ?>> 168171 AL</option>
                <option value="181185 AL" <?= (isset($clamp)&& $clamp=='181185 AL' ? 'selected' : "") ?>> 181185 AL</option>
                <option value="221225 AL" <?= (isset($clamp)&& $clamp=='221225 AL' ? 'selected' : "") ?>> 221225 AL</option>
                <option value="152155 SG" <?= (isset($clamp)&& $clamp=='152155 SG' ? 'selected' : "") ?>> 152155 SG</option>
                <option value="103/105 SG" <?= (isset($clamp)&& $clamp=='103/105 SG' ? 'selected' : "") ?>>103/105 SG</option>
                <option value="128130 SG" <?= (isset($clamp)&& $clamp=='128130 SG' ? 'selected' : "") ?>> 128130 SG</option>
                <option value="145150 SG" <?= (isset($clamp)&& $clamp=='145150 SG' ? 'selected' : "") ?>> 145150 SG</option>
                <option value="168171 SG" <?= (isset($clamp)&& $clamp=='168171 SG' ? 'selected' : "") ?>> 168171 SG</option>
                <option value="181185 SG" <?= (isset($clamp)&& $clamp=='181185 SG' ? 'selected' : "") ?>> 181185 SG</option>
            </select>
            <label id="clamp-error" class="error" for="clamp"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Clamp Material</label>
            <select class="form-control  did-floating-select " id="material" required name="clamp_material">
               <option value="">Select</option>
               <option value="Aluminium LM-6" <?= (isset($clamp_material)&& $clamp_material=='Aluminium LM-6' ? 'selected' : "") ?>>Aluminium LM-6</option> 
               <option value="FRP" <?= (isset($clamp_material)&& $clamp_material=='FRP' ? 'selected' : "") ?>>FRP</option> 
               <option value="SS304" <?= (isset($clamp_material)&& $clamp_material=='SS304' ? 'selected' : "") ?>>SS304</option> 
               <option value="SS316L" <?= (isset($clamp_material)&& $clamp_material=='SS316L' ? 'selected' : "") ?>>SS316L</option> 
               <option value="SS904" <?= (isset($clamp_material)&& $clamp_material=='SS904' ? 'selected' : "") ?>>SS904</option> 
            </select> 
            <label id="material-error" class="error" for="material"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Thikness</label>
            <select class="form-control select2 did-floating-select thikness" id="thikness" required name="thikness">

               <!-- <option value="1" <?= (isset($thikness) && ($thikness == 1)) ? "selected" : "" ?>>3meter</option>
               <option value="2" <?= (isset($thikness) && ($thikness == 2)) ? "selected" : "" ?>>5meter</option> -->
            </select>
            <label id="thikness-error" class="error" for="thikness"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Treatment</label>
            <select class="form-control select2 did-floating-select" id="treatment" required name="treatment">
               <option value="MSHDG"  <?= (isset($treatment) && ($treatment == "MSHDG")) ? "selected" : "" ?>>MSHDG</option>
               <option value="ZINC PLATING"  <?= (isset($treatment) && ($treatment == "ZINC PLATING")) ? "selected" : "" ?>>ZINC PLATING</option>
            </select>
            <label id="treatment-error" class="error" for="treatment"></label>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Plate OD</label>
            <select class="form-control select2 did-floating-select plate_od" id="plate_od" required name="plate_od">

               <!-- <option value="1"  <?= (isset($treatment) && ($treatment == 1)) ? "selected" : "" ?>>Treatment</option> -->
            </select>
            <label id="plate_od-error" class="error" for="plate_od"></label>
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
