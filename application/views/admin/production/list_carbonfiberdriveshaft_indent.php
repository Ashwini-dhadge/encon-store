<?php init_header(); ?>
<link href="<?= base_url() ?>assets/css/label_floating.css" rel="stylesheet">
<style>
   ._status {
      cursor: pointer;
   }

   th,
   td {
      white-space: nowrap;
   }

   .btn-sm {
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

      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div style="display: flex; justify-content: space-between;">
                     <div class="mb-2">
                        <button type="button" class="btn text-black btn-sm" id="export_selected_pdf">
                           <i class="fas fa-file-pdf text-danger mr-1"></i>
                           Export Selected PDF
                        </button>
                        <button type="button" class="btn text-black btn-sm" id="export_selected_excel">
                           <i class="fas fa-file-excel mr-1 text-success"></i>
                           Export Selected Excel
                        </button>
                     </div>
                     <div class="mb-2 d-flex align-items-center">
                        <input type="date" name="from_date" class="form-control" id="from_date">
                        <span class="mx-2">To</span>
                        <input type="date" name="to_date" class="form-control" id="to_date">
                        <button type="button" id="dateFilterBtn" class="btn text-dark btn-sm ml-2">Filter</button>
                        <button type="button" id="dateResetBtn" class="btn btn-light btn-sm ml-2">Reset</button>
                     </div>
                  </div>
                  <hr>
                  <?php $this->load->view(ADMIN . 'production/tbl_cfds_indent'); ?>
               </div>
            </div>
         </div>
      </div>
      <?php init_footer(); ?>
      <script src="<?= base_url(); ?>assets/js/page-js/production/cfds_indent.js"></script>
      <script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>