<?php  init_header(); ?>
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
<style>._status{cursor: pointer;}
   th, td {
   white-space: nowrap;
   }
   .btn-sm{
      background: whitesmoke !important;
      border: 1px solid #959595 !important;
      /*color: red !important;*/
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
<!-- <div class="row page-titles">
   <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">User Access</h3>
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="javascript:void(0)">User Access</a></li>
         <li class="breadcrumb-item active">User Access</li>
      </ol>
   </div>
   <div class="col-md-7 align-self-center text-right d-none d-md-block">
      <a href="<?= base_url('admin/UserAccess/add_user');?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> Create User Access </a>
   </div>
</div> -->
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <?php $this->load->view(ADMIN.'user_access/tbl_user_access'); ?>   
         </div>
      </div>
   </div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/user_access.js"></script>
