<style>
    .nav-tabs-custom .nav-link {
        font-weight: 600;
    }

    .nav-tabs-custom .nav-link.active {
        background: #f8f9fa;
        border-bottom: 2px solid #48bc97;
    }

    .dim-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .dim-table th,
    .dim-table td {
        border: 1px solid #ddd;
        padding: 6px;
        text-align: center;
        vertical-align: middle;
    }

    .dim-gray {
        background: #f2f2f2;
        font-weight: 600;
    }

    .dim-section {
        text-align: left;
        font-weight: bold;
    }

    .dim-right {
        text-align: right;
    }
</style>

<div class="card shadow-sm">
    <div class="card-body p-0">

        <ul class="nav nav-tabs nav-tabs-custom px-3 pt-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#po-details" role="tab">
                    <i class="fa fa-info-circle mr-1"></i> Box PO Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#vendor-details" role="tab">
                    <i class="fa fa-info-circle mr-1"></i> Vendor Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#po-dimensions" role="tab">
                    <i class="fa fa-th-large mr-1"></i> Dimensions
                </a>
            </li>
        </ul>

        <div class="tab-content p-3">

            <div class="tab-pane fade active show" id="po-details" role="tabpanel">

                <h6 class="mb-3 text-uppercase text-muted">Box PO Summary</h6>

                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th width="40%">PO No</th>
                        <td><?= $po['boxpo_order_no'] ?></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><?= dmyDate($po['boxpo_date']) ?></td>
                    </tr>
                    <tr>
                        <th>Vendor</th>
                        <td><?= $vendor['vendor_name'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th>3% Wastage</th>
                        <td><?= number_format((float)$po['wastage_sq_inch'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Total Sq. Inch</th>
                        <td><?= number_format((float)$po['net_sq_inch'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>CU FT</th>
                        <td><?= number_format((float)$po['cu_ft'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Rate</th>
                        <td><?= number_format((float)$po['rate'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Total Cost</th>
                        <td class="font-weight-bold text-success">
                            ₹ <?= number_format((float)$po['total_cost'], 2) ?>
                        </td>
                    </tr>
                </table>
            </div>


            <div class="tab-pane fade" id="vendor-details" role="tabpanel">

                <div class="row">

                    <div class="col-md-6">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="fa fa-building mr-1"></i> Vendor Information
                                </h6>

                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th width="40%">Vendor Name</th>
                                        <td><?= $vendor['vendor_name'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td><?= $vendor['vendor_city_name'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td><?= $vendor['state_name'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pincode</th>
                                        <td><?= $vendor['pincode'] ?? '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="fa fa-user mr-1"></i> Contact Details
                                </h6>

                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th width="40%">Contact Email</th>
                                        <td><?= $vendor['contact_person_email'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td><?= $vendor['contact_person_mobile_no'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td><?= $vendor['phone'] ?? '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="fa fa-list mr-1"></i> Other Details
                                </h6>

                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th>GST No</th>
                                        <td><span class="badge badge-success p-2" style="font-size: 12px;"><?= $vendor['company_gst_no'] ?? '-' ?></span></td>
                                    </tr>
                                    <tr>
                                        <th>PAN Card Number</th>
                                        <td><span class="badge badge-primary p-2" style="font-size: 12px;"><?= $vendor['pan_no'] ?? '-' ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold mb-2 text-primary">
                                    <i class="fa fa-map-marker mr-1"></i> Address
                                </h6>
                                <div class="p-3 bg-light rounded">
                                    <?= nl2br($vendor['address_details'] ?? '-') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="tab-pane fade" id="po-dimensions" role="tabpanel">
                <?php
                $grouped = [];
                foreach ($dimensions as $d) {
                    $grouped[$d['section']][$d['type']][] = $d;
                }

                if (!function_exists('v')) {
                    function v($arr, $key)
                    {
                        return (isset($arr[$key]) && $arr[$key] !== '') ? $arr[$key] : '-';
                    }
                }
                ?>

                <h6 class="mb-3 text-uppercase text-muted">Dimension Details</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Section</th>
                                <th>Type</th>
                                <th>Length</th>
                                <th>X</th>
                                <th>Width</th>
                                <th>X</th>
                                <th>Thickness</th>
                                <th>Qty</th>
                                <th>Sq. Inch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sections = ['Base', 'Top', 'Long Side', 'Short Side', 'Loose Support'];
                            if (!empty($grouped['JOINT >=150'])) {
                                $sections[] = 'JOINT >=150';
                            }

                            foreach ($sections as $sec):
                                if (empty($grouped[$sec])) continue;
                                $isSpecial = ($sec === 'Loose Support' || $sec === 'JOINT >=150');
                                $plank   = $grouped[$sec]['Planks'][0] ?? [];
                                $battans = $grouped[$sec]['Battans'] ?? [];
                                if ($isSpecial):
                                    $row = !empty($plank) ? $plank : ($battans[0] ?? []);
                            ?>
                                    <tr class="dim-gray">
                                        <td colspan="2" class="dim-section"><?= $sec ?></td>
                                        <td><?= v($row, 'length') ?></td>
                                        <td>X</td>
                                        <td><?= v($row, 'width') ?></td>
                                        <td>X</td>
                                        <td><?= v($row, 'thickness') ?></td>
                                        <td><?= v($row, 'qty') ?></td>
                                        <td class="dim-right">
                                            <?= is_numeric(v($row, 'sq_inch')) ? number_format(v($row, 'sq_inch'), 2) : '-' ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr class="dim-gray">
                                        <td class="dim-section"><?= $sec ?></td>
                                        <td>Planks</td>
                                        <td><?= v($plank, 'length') ?></td>
                                        <td>X</td>
                                        <td><?= v($plank, 'width') ?></td>
                                        <td>X</td>
                                        <td><?= v($plank, 'thickness') ?></td>
                                        <td><?= v($plank, 'qty') ?></td>
                                        <td class="dim-right">
                                            <?= is_numeric(v($plank, 'sq_inch')) ? number_format(v($plank, 'sq_inch'), 2) : '-' ?>
                                        </td>
                                    </tr>
                                    <?php for ($i = 0; $i < 3; $i++): $b = $battans[$i] ?? []; ?>
                                        <tr>
                                            <td></td>
                                            <td>Battans</td>
                                            <td><?= v($b, 'length') ?></td>
                                            <td>X</td>
                                            <td><?= v($b, 'width') ?></td>
                                            <td>X</td>
                                            <td><?= v($b, 'thickness') ?></td>
                                            <td><?= v($b, 'qty') ?></td>
                                            <td class="dim-right">
                                                <?= is_numeric(v($b, 'sq_inch')) ? number_format(v($b, 'sq_inch'), 2) : '-' ?>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>