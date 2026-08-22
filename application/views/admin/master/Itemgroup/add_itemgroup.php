<?php init_header(); ?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
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
               <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
               <form method="post" action="<?= base_url('admin/master/ItemGroup/add_itemgroup');?>" id="form" enctype="multipart/form-data"class="form-horizontal">
                  <div class="row">
                     <input type="hidden" name="id" id="id" value="<?= isset($itemgroup)? $itemgroup['id'] : ''; ?>">
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Add Item Group Masters</b></h6>
                              </span>
                              <hr>
                           </div>
                           <!--  <div class="row"> -->
                           <input type="hidden" name="id" id="id" value="<?= isset($itemgroup)? $itemgroup['id'] : ''; ?>">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Item Group</label>
                                 <div class="col-md-9">
                                    <input type="text" class="form-control" required placeholder="" name="item_group_name" value="<?= isset($itemgroup)? $itemgroup['item_group_name'] : ''; ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Primary Group</label>
                                 <div class="col-md-9">
                                    <select id="primary_group" class="form-control select2 did-floating-select primary_group"  data-toggle="tooltip" name="parent_group_id"  value="">
                                       <option></option>
                                       <?php 
                                          foreach ($primary_group as $key => $value) {
                                            if((isset($itemgroup['parent_group_id'])&&$itemgroup['parent_group_id']==$value['id'])){
                                             $selected="selected";
                                              }else{
                                              $selected="";
                                            } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['item_group_name'] ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3 ">Tolerance Level</label>
                                 <div class="col-md-9">
                                    <input type="text" class="form-control numberonly" required placeholder="" name="tolerance_level" value="<?= isset($itemgroup)? $itemgroup['tolerance_level'] : ''; ?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="col-sm-5 " style="padding-left: 170px;">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="customCheck1" name="is_production_type_group" <?= (isset($itemgroup) && $itemgroup['is_production_type_group'] == 1)? 'checked': ''; ?>  value="1" >
                                 <label class="custom-control-label" for="customCheck1">Is Production Type Group </label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="customCheck2" name="manage_service_log_for_issued_items" <?= (isset($itemgroup) && $itemgroup['manage_service_log_for_issued_items'] == 1)? 'checked': ''; ?>  value="1"  >
                                 <label class="custom-control-label" for="customCheck2">Manage Service Log For Issued Items </label>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Item Type</label>
                                 <div class="col-md-9">
                                    <select class="form-control select2 did-floating-select item_type_id" name="item_type_id" required id="item_type_id" >
                                       <?php foreach ($groupitem as $key => $value) {
                                          if((isset($groupitem['item_type_id'])&&$groupitem['item_type_id']==$value['id'])){
                                             $selected="selected";
                                              }else{
                                              $selected="";
                                            } ?>
                                       ?>
                                       <option value="<?= $value['id']?>"<?= $selected; ?> ><?= $value['item_type_name'] ?></option>
                                       <?php }?>
                                    </select>
                                     <label id="item_type_id-error" class="error sd" for="item_type_id">This field is .</label>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Status</label>
                                 <div class="col-md-9">
                                    <div class="custom-control custom-radio custom-control-inline">
                                       <input type="radio" id="customRadio1" name="status" class="custom-control-input" value="1"  <?= (isset($itemgroup) && $itemgroup['status'] == 1)? 'checked': '';?>  checked>
                                       <label class="custom-control-label" for="customRadio1" >Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                       <input type="radio" id="customRadio2" name="status" class="custom-control-input" value="0" <?= (isset($itemgroup) && $itemgroup['status'] == 0)? 'checked': '';?>>
                                       <label class="custom-control-label" for="customRadio2" >In Active</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <div class="row">
                           <div class="col-sm-4 " style="padding-left: 170px;">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="customCheck3" name="is_manage_log_book_for_issued_items" <?= (isset($itemgroup) && $itemgroup['is_manage_log_book_for_issued_items'] == 1)? 'checked': ''; ?>  value="1" >
                                 <label class="custom-control-label" for="customCheck3">Manage Log Book For Issued Items</label>
                              </div>
                           </div>
                           <!--/row-->
                        </div>
                     </div>
                     <hr>
                  </div>
                    <input type="submit" id="btnsubmit" style="margin-left: 90%;" class="btn btn-success btn-theme float-right" value="Submit">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<!-- <script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/js/form-repeater.int.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/bootstrap-multiselect/js/bootstrap-multiselect.js"></script> -->
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<!-- <script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script> -->
<script src="<?= base_url(); ?>assets/js/page-js/master/item_group.js"></script>
<script>
   $(document).ready(function () {
   
    $('#form').validate({ 
         
         submitHandler: function(form) {
             form.submit();
         }
     });
   });
</script>
<style>
   .error{
   color: red;
   }
</style>

<script>
   $(document).ready(function() { 
   $(".numberonly").attr("maxlength", "6");
       $(".numberonly").keypress(function(e) {
          var kk = e.which;
           if(kk < 48 || kk > 57)
           e.preventDefault();
       });
    });
   
   
   
</script>
