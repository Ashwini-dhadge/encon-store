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
    }
</style>


<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $this->load->view(ADMIN . 'production/fan_dia/tbl_fan_dia_indent'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/production/fan_dia_indent.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>