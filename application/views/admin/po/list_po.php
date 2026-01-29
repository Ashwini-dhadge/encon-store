<?php  init_header(); ?>
<style>
  table {
    border-collapse: collapse;
  }

  td {
    border: 1px solid black;
    padding: 5px;
    white-space: pre-wrap; /* or word-wrap: break-word; */
  }
</style>

<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">


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
                  <h4 class="card-title">PO </h4>
               </div>
               <div class="col-md-7 align-self-center text-right d-none d-md-block">
                  <?php  if(getUserAccessForModule('Purchase order','create')): ?>
                     <a href="<?= base_url('admin/PO/add');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Add PO</a>
                  <?php endif; ?>
               </div>  
            </div>
            <div>
            
            <?php
                      $data['company_master']=$company_master;
                      $this->load->view(ADMIN.'po/common_list' ,$data); 
            ?>

         </div>
      </div>
   </div>
</div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/po.js?v=1.0.2"></script>
<script>
 $(document).ready(function() {
    getPOListingVendorSiteData();
  
});
    
</script>
