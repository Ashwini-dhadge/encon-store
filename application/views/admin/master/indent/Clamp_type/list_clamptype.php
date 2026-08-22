<?php init_header(); ?>
<link href="<?= base_url() ?>assets/css/label_floating.css" rel="stylesheet">
<style>
   ._status {
      cursor: pointer;
   }

   th,
   td {
      /*white-space: pre-wrap !important;*/
   }

   .btn-sm {
      background: whitesmoke !important;
      border: 1px solid #959595 !important;
      /*color: red !important;*/
   }

   table {
      border-collapse: collapse;
   }
</style>


<div class="page-wrapper">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <?php $this->load->view(ADMIN . 'master/indent/Clamp_type/tbl_clamptype'); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/indent/masters/Clamp_type.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>