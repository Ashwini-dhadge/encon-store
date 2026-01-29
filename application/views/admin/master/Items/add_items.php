<?php init_header(); ?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
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
   .sd{
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
   /* .select2-selection{
   height: 32px !important;
   } */
   .select2-container--default .select2-selection--multiple .select2-selection__choice {
   background-color: #48bc97 !important;
   border: 1px solid #aaa;
   border-radius: 4px;
   cursor: default;
   float: left;
   margin-right: 5px;
   margin-top: 5px;
   padding: 0 5px;
   }
   .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
   color: #fff;
   cursor: pointer;
   display: inline-block;
   font-weight: bold;
   margin-right: 2px;
   }
   .select2-selection--multiple {
   border: solid #ced4da 1px !important;
   }
   .select2-container .select2-selection--multiple {
   box-sizing: border-box;
   cursor: pointer;
   display: block;
   min-height: 32px;
   user-select: none;
   -webkit-user-select: none;
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
            <form method="post" action="<?= base_url('admin/master/Items/add_items');?>" id="frm" enctype="multipart/form-data"class="form-horizontal">
               <div class="row">
                  <input type="hidden" name="id" id="id" value="<?= (isset($id))? $id : '' ?>">
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color">
                              <h6><b>Add Items Masters</b></h6>
                           </span>
                           <hr>
                        </div>
                        <div class="form-group col-md-4 ">
                           <label class="">Item Name</label>
                           <input class="form-control " type="text" name="item_name" required value="<?= (isset($item_name))? $item_name : '' ?>" >
                        </div>
                        <div class="form-group col-md-4 ">
                           <label class="">Short Name</label>
                           <input class="form-control " type="text" placeholder="" name="short_name"  required value="<?= (isset($short_name))? $short_name : '' ?>" >
                        </div>
                        <div class="form-group col-md-4 ">
                           <label class="">Hsn Code</label>
                           <input class="form-control numberonly" type="text" placeholder="" name="hsn_code"   value="<?= (isset($hsn_code))? $hsn_code : '' ?>" >
                        </div>
                        <div class="form-group col-md-4">
                           <label style="margin-top: 2px;border-color:#ced4da;" class="">Item Group Name</label>
                           <select class="form-control select2 item_group_name"  id="item_group" required name="item_group" value="">
                              <?php
                                 foreach ($item_groups_data as $key => $value) {
                                    if((isset($itemsData)&&$itemsData==$value['id'])){
                                     $selected="selected";
                                      }else{
                                      $selected="";
                                    } ?>
                              <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['item_group_name'] ?></option>
                              <?php } ?>
                           </select>
                           <label id="item_group-error" class="error sd" for="item_group">This field is .</label>
                        </div>
                        <div class="form-group col-md-4">
                           <label style="margin-top: 2px;border-color:#ced4da;" class="">Stock Unit</label>
                           <select class="form-control select2 stock_unit_name"  id="stock_unit" required name="stock_unit" value="">
                              <?php
                                 foreach ($stock_unit as $key => $value) {
                                    if((isset($itemsData)&&$itemsData==$value['id'])){
                                     $selected="selected";
                                      }else{
                                      $selected="";
                                    } ?>
                              <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['unit_name'] ?></option>
                              <?php } ?>
                           </select>
                           <label id="item_group-error" class="error sd" for="item_group">This field is .</label>
                        </div>
                        <div class="form-group col-md-4 ">
                           <label class="">Rate</label>
                           <input class="form-control" type="text" placeholder="" name="rate" required value="<?= (isset($rate))? $rate : '' ?>" >
                        </div>
                        <div class="form-group col-md-4">
                           <label style="margin-left: 10px;border-color:#ced4da;" class="did-floating-label">Item Unit</label>
                           <select class="form-control select2 select2-multiple stock_unit_name" style="width: 100%" id="unit_id" required name="unit_id[]" multiple="multiple" value="">
                              <?php
                                 $items_unit= array_column($units, 'id');
                                  foreach ($units as $key2 => $value2) {
                                      if(in_array($value2['id'],$items_unit)){
                                 
                                      $selected="selected";
                                       }else{
                                       $selected="";
                                        }
                                      ?>
                              <option value="<?= $value2['id'] ?>"<?= $selected; ?>><?= $value2['unit_name']?></option>
                              <?php } ?> 
                           </select>
                        </div>
                     </div>
                  </div>
                  <input type="submit" id="btnsubmit" style="margin-left: 94%;" class="btn btn-success btn-theme float-right" value="Submit">
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/page-js/master/items.js"></script>
<script>
   $(document).ready(function () {
        $.validator.addMethod("regex", function(value, element, regexp) {
            return regexp.test(value);
        }, "Please enter a valid value.");
             $('#frm').validate({
                rules: {
                    // Example field with regular expression validation
                    rate: {
                        regex: /^-{0,1}\d*\.{0,1}\d+$/ // Your regular expression goes here
                    },
                    // Add more fields and their validation rules as needed
                }
            });
      
         })
   
   
   $(document).ready(function() { 
   $(".numberonly").attr("maxlength", "10");
     
    });
   $(".numberonly1").keypress(function(e) {
    // Get the current value of the input field
    var inputValue = $(this).val();
    console.log(inputValue)
    // Get the character code of the key pressed
    var charCode = e.which ? e.which : e.keyCode;
    // Convert the character code to its string representation
    var charTyped = String.fromCharCode(charCode);
    
    // If the typed character is not a digit or a valid decimal point, prevent input
    if (!/[\d.-]/.test(charTyped)) {
        e.preventDefault();
    }

    // If the typed character is a decimal point
    if (charTyped === '.') {
        // If the input already contains a decimal point, prevent input
        if (inputValue.indexOf('.') !== -1) {
            e.preventDefault();
        }
        // If the input is empty and the typed character is a decimal point,
        // insert '0.' into the input field
        if (inputValue === "" && charTyped === '.') {
            $(this).val("0.");
            e.preventDefault();
        }
    }

    // Check if the input matches the regular expression RE
    var isValid = /^-{0,1}\d*\.{0,1}\d+$/.test($(this).val());

    // If the input doesn't match the regular expression, prevent input
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
