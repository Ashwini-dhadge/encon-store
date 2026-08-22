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
                            <span
                                class="text-green"><?php echo isset($indentDetails['client_name']) ? $indentDetails['client_name'] : "-"; ?></span>
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
                <h3 class="card-title"><span class="">Indent No :</span> <?php echo isset($indentDetails['indent_id']) ? $indentDetails['indent_id'] : "-"; ?> &nbsp;&nbsp; <span class="">Manual Indent No : </span>
                    <?php echo isset($indentDetails['manual_indent_no']) ? $indentDetails['manual_indent_no'] : "-"; ?>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light-green">
                            <tr>
                                <th colspan="4" class="text-center">Encon(India)Status</th>
                                <th colspan="7" class="text-center">Balaji Plant Status</th>
                            </tr>
                            <tr>
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

                            <td>
                                <?php if (!empty($details['blade_qty'])) : ?>
                                <!-- <span class="badge badge-success"> -->
                                    <?php echo $details['blade_qty']; ?>
                                <!-- </span> -->
                                <?php else : ?>
                             
                                -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($details['createdTotal'])) : ?>
                                <!-- <span class="badge badge-success"> -->
                                    <?php echo $details['createdTotal']; ?>
                                <!-- </span> -->
                                <?php else : ?>
                             
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['bladeHandTotal'])) : ?>
                               
                                    <?php echo $details['bladeHandTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <!-- <td>
                                <?php if (!empty($details['bladePositionTotal'])) : ?>
                               
                                    <?php echo $details['bladePositionTotal']; ?>
                            
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td> -->

                            <td>
                                <?php if (!empty($details['gapTotal'])) : ?>
                                
                                    <?php echo $details['gapTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['primerTotal'])) : ?>
                               
                                    <?php echo $details['primerTotal']; ?>
                                
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['fillerTotal'])) : ?>
                                
                                    <?php echo $details['fillerTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['puttyTotal'])) : ?>
                               
                                    <?php echo $details['puttyTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['topCoatTotal'])) : ?>
                               
                                    <?php echo $details['topCoatTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['balancingTotal'])) : ?>
                               
                                    <?php echo $details['balancingTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($details['packingTotal'])) : ?>
                               
                                    <?php echo $details['packingTotal']; ?>
                               
                                <?php else : ?>
                                -
                                <?php endif; ?>
                            </td>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sub Orders Card -->
        <div class="card shadow rounded">
            <div class="card-header">
                <h3 class="card-title">Sub Orders</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light-green">
                            <tr>
                               
                                <th colspan="6" class="text-center">Encon(India)Status</th>
                                <th colspan="7" class="text-center">Balaji plant Status</th>
                               
                            </tr>
                            <tr>
                                <!-- <th></th> -->
                                <th>Order ID</th>
                                <th>Qty</th>
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
                            <?php foreach($subOrder as $orders) { ?>
                            <tr class="hover-bg-green">
                                <td><?php echo isset($orders['order_no']) ? $orders['order_no'] : "" ?></td>
                                <td><?php echo isset($orders['order_qty']) ? $orders['order_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['created_qty']) ? $orders['created_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['blade_in_hand_qty']) ? $orders['blade_in_hand_qty'] : "" ?></td>
                                <!-- <td class="text-center"><?php echo isset($orders['blade_position_qty']) ? $orders['blade_position_qty'] : "" ?></td> -->
                                <td class="text-center"><?php echo isset($orders['gap_checking_qty']) ? $orders['gap_checking_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['primer_qty']) ? $orders['primer_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['filler_qty']) ? $orders['filler_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['putty_qty']) ? $orders['putty_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['top_coat_qty']) ? $orders['top_coat_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['balancing_qty']) ? $orders['balancing_qty'] : "" ?></td>
                                <td class="text-center"><?php echo isset($orders['packing_qty']) ? $orders['packing_qty'] : "" ?></td>
                               
                            </tr>
                           
                             <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><br><br>
<!-- end row -->

<?php init_footer(); ?>