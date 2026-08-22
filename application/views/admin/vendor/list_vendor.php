<?php  init_header(); ?>
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
<style>._status{cursor: pointer;}
   th, td {
   white-space: nowrap !important;
   }
   .btn-sm{
      background: whitesmoke !important;
      border: 1px solid #959595 !important;
      /*color: red !important;*/
   }

     .select2-selection{
    height: 37px !important;
    
  }
  .no_margin_bottom{
   margin-bottom: 0rem !important;
   }
   .dataTables_filter{
       margin-top:0px !important;
   }
   
   .dataTables_length{
       margin-top:0px !important;
   }
    label{
       margin-bottom: 0.2rem;
    }
    .text_wrap{
         word-wrap: break-word !important;
    }
    td{
        word-wrap: break-word !important;
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
            <div class="row">
               <div class="col-md-5">
                  <h4 class="card-title">Vendor </h4>
               </div>
               <div class="col-md-7 align-self-center text-right d-none d-md-block">
                  <?php  if(getUserAccessForModule('Vendor','create')): ?>
                     <a href="<?= base_url('admin/Vendor/add_vendor');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Add Vendor</a>
                  <?php endif; ?>
               </div>  
            </div>
            <div>

            <div class="row">
                <?php
                    if(userId('role_id')==SUPERADMIN_ROLE){
                ?>
                <input type="hidden" name="comp_id" id="comp_id" value="" >
                <?php
                    }else{
                ?>
                <input type="hidden" name="comp_id" id="comp_id" value="<?= userId('company_id'); ?>" >
                <?php
                    }
                ?>
               
               <div class="col-md-2">
                  <label>City</label>
                  <select class="form-control select2 did-floating-select city_name"  id="id_city"   name="id_city" value="" onchange="vendor_filter()">
                     <option value=""></option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Pan Number</label>
                  <select class="form-control select2 did-floating-select"  id="pan_nm"   name="pan_nm" value="" onchange="vendor_filter()">
                     <option value="1">All</option>
                     <option value="2">Pan Number Entered</option>
                     <option value="3">Pan Number Not Entered</option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Tin Number</label>
                  <select class="form-control select2 did-floating-select"  id="tin_nm"   name="tin_nm" value="" onchange="vendor_filter()">
                     <option value="1">All</option>
                     <option value="2">Tin Number Entered</option>
                     <option value="3">Tin Number Not Entered</option>
                  </select>
               </div>
               <!-- <div class="col-md-1">
                  <label></label>
                  <button class="btn btn-info filter_clear" style="margin-top: 16px;padding: 2px;">clear</button>
               </div> -->

            </div>  

            <div class="table-responsive">
               <table id="vendor_tbl" class="table display table-bordered text-center" width="100%">
               </table>
            </div>

         </div>
      </div>
   </div>
</div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/vendor.js"></script>
