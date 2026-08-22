<?php init_header(); ?>
<link href="<?= base_url() ?>assets/css/pages/ribbon-page.css" rel="stylesheet">

<style>
    .lbl_class {
        font-weight: bold;
    }

    .lbl1_class {
        color: #fff;
    }

    .customtab li a.nav-link {
        padding: 4px 8px;
    }

    .wdth {
        width: 10%;
    }

    .wdth_a {
        width: 23%;
    }

    .select2-selection__choice {
        background-color: #48bc97 !important;
    }

    .card-header {
        background-color: #fff;
    }

    .card-title {
        color: #38a169;
        font-weight: 500;
    }

    .card-content .row>div {
        margin-bottom: 1rem;
    }

    .table-head {
        background-color: #f0fff4;
    }

    .bg-light-green {
        background-color: #f0fff4;
    }

    .hover-bg-green:hover {
        background-color: #f0fff4;
    }

    .text-green {
        color: #6c757d;
    }

    /* Only second table font size */
    .process-table th,
    .process-table td {
        font-size: 13px;
        vertical-align: middle;
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid">

        <div class="card mb-2 shadow rounded">
            <div class="card-header">
                <h5 class="card-title">Indent Details</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Location</span>
                            <span class="text-green">ENCON PLANT</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Date Of Indent</span>
                            <span class="text-green"><?= $indentDetails[0]['indent_date'] ?? '' ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Delivery Date</span>
                            <span class="text-green"><?= $indentDetails[0]['delivery_date'] ?? '' ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Indent Number</span>
                            <span class="text-green"><?= $indentDetails[0]['indent_no'] ?? '' ?></span>
                        </div>
                    </div>


                </div>

                <!-- Product Details (NO BORDERS) -->
                <div class="row ">
                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Party Name</span>
                            <span class="text-green"><?= $indentDetails[0]['client_name'] ?? '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Dimension</span>
                            <span class="text-green"><?= $indentDetails[0]['dimension'] ?? '' ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Material</span>
                            <span class="text-green"><?= $indentDetails[0]['material_name'] ?? ''; ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bg-white p-2 rounded d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Make</span>
                            <span class="text-green"><?= $indentDetails[0]['make'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="bg-white p-2 rounded d-flex">
                            <span class="text-secondary font-weight-bold">Remark</span>
                            <span class="text-green ml-5"><?= $indentDetails[0]['remark'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
                <hr>

                <h5 class="card-title">Technical Specification Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Ord No</th>
                                <th>Total Qty</th>
                                <th>Ordered Qty</th>
                                <th>PCD 1</th>
                                <th>PCD 2</th>
                                <th>Drill Size</th>
                                <th>Length</th>
                                <th>Width</th>
                                <th>Height</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $specifications[0]['ord_no'] ?? '' ?></td>
                                <td><?= $specifications[0]['total_order_qty'] ?? '' ?></td>
                                <td><?= $specifications[0]['order_qty'] ?? '' ?></td>
                                <td><?= $specifications[0]['pcd_1'] ?? '' ?></td>
                                <td><?= $specifications[0]['pcd_2'] ?? '' ?></td>
                                <td><?= $specifications[0]['drill_size'] ?? '' ?></td>
                                <td><?= $specifications[0]['length'] ?? '' ?></td>
                                <td><?= $specifications[0]['width'] ?? '' ?></td>
                                <td><?= $specifications[0]['height'] ?? '' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="card mb-4 shadow rounded">
            <div class="card-header">
                <h5 class="card-title">
                    <span>Indent No:</span> <?= $indentDetails[0]['indent_no'] ?? '' ?> &nbsp;&nbsp;
                    <span>Manual Indent No:</span> <?= $indentDetails[0]['indent_number'] ?? '' ?>
                </h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Ordered Qty</th>
                                <th>Under Finishing</th>
                                <th>Finishing</th>
                                <th>Paintaing</th>
                                <th>Dispatch</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?= $indentDetails[0]['client_name'] ?? '' ?></td>
                                <td><?= $indentDetails[0]['indent_date'] ?? '' ?></td>

                                <td><span class=""><?= $indentDetails[0]['order_qty'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Under Finishing'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Finishing'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Paintaing'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Dispatch'] ?? '' ?></span></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php init_footer(); ?>