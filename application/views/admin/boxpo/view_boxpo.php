<?php init_header(); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <?php $this->load->view(ADMIN . 'boxpo/view_common_list'); ?>
            </div>

            <div class="col-md-6">
                <div id="po_details">
                    <div class="alert alert-info">
                        Click on View to see PO details
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/boxpo.js?v=1.0.2"></script>