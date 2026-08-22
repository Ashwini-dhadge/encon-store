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
                            <span class="text-green">Carbon Fiber Composite</span>
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
                                <th>Motor Power</th>
                                <th>DBSE</th>
                                <th>Tube (OD × THK)</th>
                                <th>Fan Diameter</th>
                                <th>No. of Blades</th>
                                <th>Bore</th>
                                <th>Keyway</th>
                                <th>Fan RPM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($specifications)) : ?>
                                <?php foreach ($specifications as $spec_detail) : ?>
                                    <tr>

                                        <td><?= $spec_detail['ord_no'] ?></td>

                                        <td><?= $spec_detail['qty'] ?? 0 ?></td>

                                        <td><?= $spec_detail['group_qty'] ?></td>

                                        <td><?= $spec_detail['motor_power'] ?></td>

                                        <td><?= $spec_detail['dbse'] ?></td>

                                        <td><?= $spec_detail['tube_od_thk'] ?? 'NA' ?></td>

                                        <td><?= $spec_detail['fan_dia'] ?></td>

                                        <td><?= $spec_detail['no_of_blade'] ?></td>

                                        <!-- BORE -->
                                        <?php
                                        $boreArr = !empty($spec_detail['bore'])
                                            ? json_decode($spec_detail['bore'], true)
                                            : [];
                                        ?>

                                        <td>
                                            <?php if (!empty($boreArr)) : ?>

                                                <ul class="mb-0 pl-3">

                                                    <?php foreach ($boreArr as $bore) : ?>

                                                        <?php
                                                        $motor = $bore['motor'] ?? '-';
                                                        $gear  = $bore['gear'] ?? '-';
                                                        ?>

                                                        <li>
                                                            Motor : <?= $motor ?>
                                                            |
                                                            Gear : <?= $gear ?>
                                                        </li>

                                                    <?php endforeach; ?>

                                                </ul>

                                            <?php else : ?>

                                                -

                                            <?php endif; ?>
                                        </td>

                                        <!-- KEYWAY -->
                                        <?php
                                        $keyArr = !empty($spec_detail['keyway'])
                                            ? json_decode($spec_detail['keyway'], true)
                                            : [];
                                        ?>

                                        <td>

                                            <?php if (!empty($keyArr)) : ?>

                                                <ul class="mb-0 pl-3">

                                                    <?php foreach ($keyArr as $key) : ?>

                                                        <?php
                                                        $motor = $key['motor'] ?? '-';
                                                        $gear  = $key['gear'] ?? '-';
                                                        ?>

                                                        <li>
                                                            Motor : <?= $motor ?>
                                                            |
                                                            Gear : <?= $gear ?>
                                                        </li>

                                                    <?php endforeach; ?>

                                                </ul>

                                            <?php else : ?>

                                                -

                                            <?php endif; ?>

                                        </td>

                                        <td><?= !empty($spec_detail['fan_rpm']) ? $spec_detail['fan_rpm'] : '-' ?></td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>
                                    <td colspan="12" class="text-center">
                                        No specification data found
                                    </td>
                                </tr>

                            <?php endif; ?>
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
                                <th>Design Selection</th>
                                <th>Filament Winding</th>
                                <th>Bonding</th>
                                <th>Torque Testing and Finishing</th>
                                <th>Dynamic Balancing</th>
                                <th>Inspection</th>
                                <th>Packaging</th>
                                <th>Dispatch</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?= $indentDetails[0]['client_name'] ?? '' ?></td>
                                <td><?= $indentDetails[0]['indent_date'] ?? '' ?></td>

                                <td><span class=""><?= $spec_detail['group_qty'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Design Selection'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Filament Winding'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Bonding'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Torque Testing'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Dynamic Balancing'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Inspection'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Packaging'] ?></span></td>
                                <td><span class=""><?= $statusFormatted['Dispatch'] ?></span></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php init_footer(); ?>