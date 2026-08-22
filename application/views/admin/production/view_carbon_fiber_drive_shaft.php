<?php init_header(); ?>

<style>
    .card-premium {
        border-radius: 14px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .kpi-box {
        border: 1px solid #1abc9c;
        border-radius: 12px;
        padding: 15px;
    }

    .kpi-title {
        font-size: 12px;
        opacity: 0.8;
    }

    .kpi-value {
        font-size: 20px;
        font-weight: bold;
    }

    .progress {
        height: 8px;
        border-radius: 10px;
    }

    .badge-modern {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
    }

    .table-premium thead {
        background: #1abc9c;
        color: white;
    }

    .table-premium tbody tr:hover {
        background: #f4f6f9;
    }

    .section-title {
        font-weight: 600;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .section-box {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px 20px;
        background: #ffffff;
        margin-bottom: 15px;
        transition: 0.2s;
    }

    .section-box:hover {
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 12px;
        color: #2c3e50;
        font-size: 14px;
    }

    .info-grid div {
        margin-bottom: 6px;
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid">

        <div class="card card-premium p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="text-primary mb-0">CFDS Indent</h4>
                    <small class="text-muted"><?= $indent_details['indent_no'] ?></small>
                </div>

                <div>
                    <a href="<?= base_url('admin/production/Indent/CreateOrderforcarbon_fiber_drive_shaft/'  . $indent_details['indent_no']) ?>" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                    <a href="<?= base_url('admin/production/Indent/carbonfiberdriveshaft_indent') ?>" class="btn btn-sm btn-primary">
                        Back
                    </a>
                </div>
            </div>

            <!-- KPI CARDS -->
            <div class="row mb-3">

                <?php
                $totalQty = $indent_details['qty'];
                $assigned = 0;
                $rpmTotal = 0;
                $count = count($indent_details['specifications']);

                foreach ($indent_details['specifications'] as $s) {
                    $assigned += (int)($s['group_qty'] ?? 0);
                    $rpmTotal += (int)($s['fan_rpm'] ?? 0);
                }

                $avgRPM = $count ? round($rpmTotal / $count) : 0;
                $progress = $totalQty ? ($assigned / $totalQty) * 100 : 0;
                ?>

                <div class="col-md-3">
                    <div class="kpi-box">
                        <div class="kpi-title">Total Qty</div>
                        <div class="kpi-value"><?= $totalQty ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="kpi-box">
                        <div class="kpi-title">Assigned Qty</div>
                        <div class="kpi-value"><?= $assigned ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="kpi-box">
                        <div class="kpi-title">Groups</div>
                        <div class="kpi-value"><?= $count ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="kpi-box">
                        <div class="kpi-title">Avg RPM</div>
                        <div class="kpi-value"><?= $avgRPM ?></div>
                    </div>
                </div>

            </div>

            <!-- PROGRESS -->
            <div class="mb-3">
                <label><b>Quantity Progress</b></label>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: <?= $progress ?>%"></div>
                </div>
                <small><?= $assigned ?> / <?= $totalQty ?></small>
            </div>

            <!-- DETAILS -->
            <div class="section-box">
                <div class="section-title">Indent Details</div>

                <div class="row info-grid">
                    <div class="col-md-3"><b>Date:</b> <?= $indent_details['date'] ?></div>
                    <div class="col-md-3"><b>Delivery:</b> <?= $indent_details['delivery_date'] ?></div>
                    <div class="col-md-3"><b>Manual:</b> <?= $indent_details['indent_number'] ?></div>
                    <div class="col-md-3">
                        <span class="badge badge-success badge-modern">LOCKED</span>
                    </div>
                </div>
            </div>

            <!-- PRODUCT -->
            <div class="section-box">
                <div class="section-title">Product</div>

                <div class="row info-grid">
                    <div class="col-md-3"><b>Dimension:</b> <?= $indent_details['dimension'] ?></div>
                    <div class="col-md-3"><b>Material:</b> <?= $indent_details['material'] ?></div>
                    <div class="col-md-3"><b>Make:</b> <?= $indent_details['make'] ?></div>
                    <div class="col-md-3"><b>Qty:</b> <?= $indent_details['qty'] ?></div>
                    <div class="col-md-12 mt-2"><b>Remark:</b> <?= $indent_details['remark'] ?></div>
                </div>
            </div>
            <!-- TABLE -->
            <div class="section-title">Technical Specifications</div>

            <div class="table-responsive">
                <table class="table table-bordered table-premium">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Motor</th>
                            <th>DBSE</th>
                            <th>Fan</th>
                            <th>Blade</th>
                            <th>Bore</th>
                            <th>Keyway</th>
                            <th>RPM</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($indent_details['specifications'] as $spec): ?>
                            <tr>
                                <td><span class="badge badge-info"><?= $spec['group_qty'] ?></span></td>
                                <td><?= $spec['motor_power'] ?></td>
                                <td><?= $spec['dbse'] ?></td>
                                <td><?= $spec['fan_dia'] ?></td>
                                <td><?= $spec['no_of_blade'] ?></td>

                                <td>
                                    <?php
                                    $b = json_decode($spec['bore'], true);
                                    echo implode(', ', $b ?? []);
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $k = json_decode($spec['keyway'], true);
                                    echo implode(', ', $k ?? []);
                                    ?>
                                </td>

                                <td><b><?= $spec['fan_rpm'] ?></b></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<?php init_footer(); ?>