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
    /*  New Desgin css Start */
.card-header {
    background-color: #fff;
}

.card-title {
    color: #38a169;
    font-size: 1.4rem;
    font-weight: 500;
}

.card-header .card-title svg {
    margin-right: 0.5rem;
}

.card-content .row>div {
    margin-bottom: 1rem;
}

.btn-toggle {
    padding: 0;
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
    color: #38a169;
    /* font-size: small; */
}

.text-secondary {
    /* font-size: small; */
}

/* table thead th {
        background-color: #48bc97;
        color: white;
    } */

/*  New Desgin css End */
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

        <!-- 1st  -->
            <!-- Indent Details Card -->
        <div class="card mb-4 shadow  rounded">
            <div class="card-header">
                <h3 class="card-title">

                    Indent Details
                </h3>
            </div>
            <div class="card-body ">
                <!-- First Row -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Location</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['location']) ? $indentDetails['location'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-light-green p-2 rounded border border-success d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Date Of Indent</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['indent_date']) ? $indentDetails['indent_date'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Dispatched Plan</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['dispatch_plan_date']) ? $indentDetails['dispatch_plan_date'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Indent Number</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['indent_id']) ? $indentDetails['indent_id'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border  d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Party Name</span>
                            <?php
                                                                                if(isset($indentDetails['order_for']) && ($indentDetails['order_for']==2)){
                                                                                    $party_name="ENCON";
                                                                                }else{
                                                                                     $party_name=isset($indentDetails['client_name']) ? $indentDetails['client_name'] : "-";
                                                                                }
                                                                        ?>
                            <span
                                class="text-green"><?php echo isset($party_name) ?$party_name : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">FAN DIA(feet)</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['fan_dia_feet']) ? $indentDetails['fan_dia_feet'] : "-"; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="row mt-3">
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Size Of Mould</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['mould_size']) ? $indentDetails['mould_size'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Hub Size</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['hub_size']) ? $indentDetails['hub_size'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Blade Size</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['blade_size']) ? $indentDetails['blade_size'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Blade Quantity</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['blade_qty']) ? $indentDetails['blade_qty'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Punching Number</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['blade_punching_no']) ? $indentDetails['blade_punching_no'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">A TIP</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['a_tip']) ? $indentDetails['a_tip'] : "-"; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Third Row -->
                <div class="row mt-3">
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Color</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['color']) ? $indentDetails['color'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Way</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['way']) ? $indentDetails['way'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Set</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['order_set']) ? $indentDetails['order_set'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Total Blade Quantity</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['blade_qty']) ? $indentDetails['blade_qty'] : "-"; ?></span>
                        </div>
                    </div>
                    <!-- <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Order Qty</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['order_qty']) ? $indentDetails['order_qty'] : "-"; ?></span>
                        </div>
                    </div> -->
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Transfer Qty</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['transfer_qty']) ? $indentDetails['transfer_qty'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Ready For Dispatched</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['dispatch_qty']) ? $indentDetails['dispatch_qty'] : "-"; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Fifth Row -->
                <div class="row mt-3">

                 
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Dispatched Date</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['dispatched_date']) ? $indentDetails['dispatched_date'] : "-"; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-white p-2 rounded border border-dark d-flex justify-content-between">
                            <span class="text-secondary font-weight-bold">Dispatched Quantity</span>
                            <span
                                class="text-green"><?php echo isset($indentDetails['dispatch_qty']) ? $indentDetails['dispatch_qty'] : "-"; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Sixth Row -->
                <div class="row mt-3">

                </div>
            </div>

        </div>

        <!-- Main Order Card -->
<div class="card mb-4 shadow rounded">
    <div class="card-header">
        <h3 class="card-title">
            <span>Indent No:</span> 
            <?php echo isset($indentDetails['indent_id']) ? $indentDetails['indent_id'] : "-"; ?> &nbsp;&nbsp; 
            <span>Manual Indent No:</span>
            <?php echo isset($indentDetails['manual_indent_no']) ? $indentDetails['manual_indent_no'] : "-"; ?>
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light-green">
                    <tr>
                        <th colspan="6" class="text-center">Encon(India) Status</th>
                        <th colspan="7" class="text-center">Balaji Plant Status</th>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Blade Qty</th>
                        <th>Created</th>
                        <th>Blade In Hand</th>
                        <!-- <th>Blade Position</th> -->
                        <th>Gap Check</th>
                        <th>Prime</th>
                        <th>Filler</th>
                        <th>Putty</th>
                        <th>Top Coat</th>
                        <th>Balancing</th>
                        <th>Packing</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($details as $value) { ?>
                        <tr>
                            <td><?php echo isset($value['plant_name']) ? $value['plant_name'] : ""?></td>
                            <td><?php echo $value['date']; ?></td>
                            <td><?php echo ($value['status_id'] == 1) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 2) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 3) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 4) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 5) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <!-- <td><?php echo ($value['status_id'] == 6) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td> -->
                            <td><?php echo ($value['status_id'] == 7) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 8) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 9) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 10) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                            <td><?php echo ($value['status_id'] == 12) ? '<span class="badge badge-success">' . $value['qty'] . '</span>' : ''; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

     
    </div>
</div><br><br>
<!-- end row -->

<?php init_footer(); ?>