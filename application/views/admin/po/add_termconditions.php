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
               <form method="post" action="<?= base_url('admin/Po/add_termconditions');?>" id="form" enctype="multipart/form-data"class="form-horizontal">
                  <div class="row">
                   
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Add Terms and Conditions</b></h6>
                              </span>
                              <hr>
                           </div>
                           <!--  <div class="row"> -->
                           <input type="hidden" name="id" id="id" value="<?= isset($itemgroup)? $itemgroup['id'] : ''; ?>">
                           <div class="col-md-6">
                               <label >Title</label>
                               <input  type="text" required  class="form-control" name="title" value="">
                           </div>
                           <div class="col-md-6">
                              <label >New Add</label>
                                 <input  type="text" required  class="form-control" name="particulars" value="">

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
