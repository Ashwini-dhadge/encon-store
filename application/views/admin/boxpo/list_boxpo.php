<?php init_header(); ?>
<style>
    table {
        border-collapse: collapse;
    }

    td {
        border: 1px solid black;
        /* padding: 10px; */
        white-space: pre-wrap;
        /* or word-wrap: break-word; */
    }

</style>

<link href="<?= base_url() ?>assets/css/label_floating.css" rel="stylesheet">

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="card-title">Box-PO </h4>
                            </div>
                            <div class="col-md-7 align-self-center text-right d-none d-md-block">
                                <?php if (getUserAccessForModule('Purchase order', 'create')): ?>
                                    <a href="<?= base_url('admin/BoxPO/add'); ?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Add Box-PO</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>

                            <?php
                            $data['company_master'] = $company_master;
                            $this->load->view(ADMIN . 'boxpo/common_list', $data);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php init_footer(); ?>
        <script src="<?= base_url(); ?>assets/js/page-js/boxpo.js?v=1.0.2"></script>