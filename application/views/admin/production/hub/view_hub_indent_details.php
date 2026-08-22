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

                <h5 class="card-title my-3">Production Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Ord No</th>
                                <th>Total Qty</th>
                                <th>Ordered Qty</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $specifications[0]['ord_no'] ?? '' ?></td>
                                <td><?= $specifications[0]['total_order_qty'] ?? '' ?></td>
                                <td><?= $specifications[0]['order_qty'] ?? '' ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <hr>
                <h5 class="card-title my-3">Hub Plate Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Hub Plate Category</th>
                                <th>Hub Plate Way</th>
                                <th>Hub Plate OD</th>
                                <th>Hub Plate Material</th>
                                <th>Hub Plate Thickness</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= ucfirst(str_replace('_', ' ', $specifications[0]['hub_plate_category'])) ?? '' ?></td>
                                <td><?= $specifications[0]['hub_plate_way'] ?? '' ?></td>
                                <td><?= $specifications[0]['hub_plate_od'] ?? '' ?></td>
                                <td><?= $specifications[0]['hub_plate_material'] ?? '' ?></td>
                                <td><?= $specifications[0]['hub_plate_thickness'] ?? '' ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <hr>
                <h5 class="card-title my-3">Flange / Hubspool Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Flange / Hubspool OD</th>
                                <th>Flange Size</th>
                                <th>Flange / Hubspool PCD</th>
                                <th>Flange / Hubspool Drill</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $specifications[0]['flange_hubspool_od'] ?? '' ?></td>
                                <td><?= $specifications[0]['flange_size'] ?? '' ?></td>
                                <td><?= $specifications[0]['flange_hubspool_pcd'] ?? '' ?></td>
                                <td><?= $specifications[0]['flange_hubspool_drill'] ?? '' ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <hr>
                <h5 class="card-title my-3">Taperbush Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Taperbush OD</th>
                                <th>Taperbush Bore</th>
                                <th>Taperbush Keyway</th>
                                <th>Finerbush OD</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $specifications[0]['tapperbush_od'] ?? '' ?></td>
                                <td><?= $specifications[0]['tapperbush_bore'] ?? '' ?></td>
                                <td><?= $specifications[0]['tapperbush_keyway'] ?? '' ?></td>
                                <td><?= $specifications[0]['fennerbush_od'] ?? '' ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <hr>
                <h5 class="card-title my-3">Hardware and Spacer Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered process-table">
                        <thead class="bg-light-green">
                            <tr>
                                <th>Hardware 1 Name</th>
                                <th>Hardware 1 Size</th>
                                <th>Hardware 1 Material</th>
                                <th>Hardware 2 Name</th>
                                <th>Hardware 2 Size</th>
                                <th>Hardware 2 Material</th>
                                <th>Spacer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $specifications[0]['hardware_name_1'] ?? '' ?></td>
                                <td><?= $specifications[0]['hardware_size_1'] ?? '' ?></td>
                                <td><?= $specifications[0]['hardware_material_1'] ?? '' ?></td>
                                <td><?= $specifications[0]['hardware_name_2'] ?? '' ?></td>
                                <td><?= $specifications[0]['hardware_size_2'] ?? '' ?></td>
                                <td><?= $specifications[0]['hardware_material_1'] ?? '' ?></td>
                                <td><?= $specifications[0]['spacer'] ?? '' ?></td>
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
                                <th>Painting</th>
                                <th>Assembly</th>
                                <th>Inspection Overall</th>
                                <th>Dynamic balancing</th>
                                <th>Dispatch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $indentDetails[0]['client_name'] ?? '' ?></td>
                                <td><?= $indentDetails[0]['indent_date'] ?? '' ?></td>

                                <td><span class=""><?= $indentDetails[0]['order_qty'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Assembly'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Inspection Overall'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Dynamic Balancing'] ?? '' ?></span></td>
                                <td><span class=""><?= $statusFormatted['Packing'] ?? '' ?></span></td>
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