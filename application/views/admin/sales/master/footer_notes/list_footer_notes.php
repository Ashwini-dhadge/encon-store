<?php init_header();?>

<div class="page-wrapper">

<div class="container-fluid">
   
    <div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <?php $this->load->view(ADMIN.'sales/master/footer_notes/tbl_footer_notes'); ?>   
         </div>
      </div>
   </div>
</div>

</div>
<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/js/page-js/sales/master/footer_notes.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>