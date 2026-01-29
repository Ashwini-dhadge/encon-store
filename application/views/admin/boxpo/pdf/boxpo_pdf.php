<?php
$grouped = [];
foreach ($dimensions as $d) {
    $grouped[$d['section']][$d['type']][] = $d;
}
?>
<?php
if (!function_exists('v')) {
    function v($arr, $key)
    {
        return (isset($arr[$key]) && $arr[$key] !== '') ? $arr[$key] : '-';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .page {
            border: 1px solid #000000;
            padding: 6px;
            border-bottom: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 0.4px solid #000;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        .no-border td {
            border: none;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .gray {
            background: #cfcfcf;
            font-weight: bold;
        }

        .section {
            font-weight: bold;
            text-align: left;
        }

        .bottom_div {
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="page">

        <table class="no-border">
            <tr>
                <td width="20%" class="left">
                    <img src="<?= base_url() ?>assets/uploads/company_logo/<?= $company_master_data['left_image'] ?? 'no_images.png'; ?>" height="50">
                </td>
                <td width="60%" style="text-align:center; padding-left: 15px; padding-right: 15px;">
                    <strong style="font-size:14px;">
                        <?= $company_master_data['name'] ?? '' ?>
                    </strong><br>
                    <span style="font-size:10px;font-weight:bold;">
                        <?= $company_master_data['address'] ?? '' ?>
                    </span><br>
                    <span style="font-size:10px;font-weight:bold;">
                        Email : <?= $company_master_data['email'] ?? '' ?>
                    </span>
                </td>
                <td width="20%" style="text-align:right;">
                    <img src="<?= base_url() ?>assets/uploads/company_logo/<?= $company_master_data['right_image'] ?? 'no_images.png'; ?>" height="50">
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="left" style="border:none;"><strong>PAN :</strong> <?= $company_master_data['pan_no'] ?? '' ?></td>
                <td class="right" style="border:none;"><strong>GST :</strong> <?= $company_master_data['gst_no'] ?? '' ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="title">BOX-PURCHASE ORDER</td>
            </tr>
        </table>

        <table>
            <tr>
                <td width="50%" class="left" style="border-right:none;">
                    <strong>To,</strong><br>
                    <strong><?= $vendor['vendor_name'] ?? '' ?></strong><br>
                    <?= $vendor['address_details'] ?? '' ?><br>
                    <?= $vendor['pincode'] ?? '' ?><br>
                    <strong>State :</strong> <?= $vendor['state_name'] ?? '' ?><br>
                    <strong>City :</strong> <?= $vendor['vendor_city_name'] ?? '' ?><br>
                    <strong>Email :</strong> <?= $vendor['contact_person_email'] ?? '' ?><br>
                    <strong>PH :</strong> <?= $vendor['contact_person_mobile_no'] ?? '' ?><br>
                    <strong>GSTIN :</strong> <?= $vendor['company_gst_no'] ?? '' ?>
                </td>
                <td width="50%" class="left" style="border-left:none;">
                    <strong>Order No :</strong> <?= $po['boxpo_order_no'] ?? '' ?><br>
                    <strong>Order Date :</strong> <?= !empty($po['boxpo_date']) ? dmyDate($po['boxpo_date']) : '' ?>
                </td>
            </tr>
        </table>

        <br>

        <table>
            <tr>
                <th rowspan="2">SIZE</th>
                <th>(L)</th>
                <th>(W)</th>
                <th>(H)</th>
                <th>(T)</th>
                <th colspan="2">Plank Type</th>
                <th colspan="2">Thickness</th>
            </tr>
            <tr>
                <td><?= $po['main_length'] ?? '' ?></td>
                <td><?= $po['main_width'] ?? '' ?></td>
                <td><?= $po['main_height'] ?? '' ?></td>
                <td><?= $po['main_thickness'] ?? '' ?></td>
                <td colspan="2"><?= $po['plank_type'] ?? '' ?></td>
                <td colspan="2"><?= $po['thickness'] ?? '' ?></td>
            </tr>
        </table>

        <br>

        <table>
            <thead>
                <tr>
                    <th width="12%">S.NO</th>
                    <th colspan="6">Details</th>
                    <th width="8%">Qty</th>
                    <th width="10%">Sq.Inch</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sections = ['Base', 'Top', 'Long Side', 'Short Side', 'Loose Support'];
                if (!empty($grouped['JOINT >=150'])) {
                    $sections[] = 'JOINT >=150';
                }

                foreach ($sections as $sec):

                    $isSpecial = ($sec === 'Loose Support' || $sec === 'JOINT >=150');
                    $plank   = $grouped[$sec]['Planks'][0] ?? [];
                    $battans = $grouped[$sec]['Battans'] ?? [];
                ?>

                    <?php if ($isSpecial): ?>

                        <?php
                        $row = !empty($plank) ? $plank : ($battans[0] ?? []);
                        ?>

                        <tr class="gray">
                            <td colspan="2"><?= $sec ?></td>
                            <td><?= v($row, 'length') ?></td>
                            <td>X</td>
                            <td><?= v($row, 'width') ?></td>
                            <td>X</td>
                            <td><?= v($row, 'thickness') ?></td>
                            <td><?= v($row, 'qty') ?></td>
                            <td><?= v($row, 'sq_inch') ?></td>
                        </tr>

                    <?php else: ?>

                        <!-- PLANK ROW (ALWAYS) -->
                        <tr class="gray">
                            <td class="section"><?= $sec ?></td>
                            <td>Planks</td>
                            <td><?= v($plank, 'length') ?></td>
                            <td>X</td>
                            <td><?= v($plank, 'width') ?></td>
                            <td>X</td>
                            <td><?= v($plank, 'thickness') ?></td>
                            <td><?= v($plank, 'qty') ?></td>
                            <td><?= v($plank, 'sq_inch') ?></td>
                        </tr>

                        <!-- BATTANS (ALWAYS 3 ROWS) -->
                        <?php for ($i = 0; $i < 3; $i++):
                            $b = $battans[$i] ?? [];
                        ?>
                            <tr>
                                <td></td>
                                <td>Battans</td>
                                <td><?= v($b, 'length') ?></td>
                                <td>X</td>
                                <td><?= v($b, 'width') ?></td>
                                <td>X</td>
                                <td><?= v($b, 'thickness') ?></td>
                                <td><?= v($b, 'qty') ?></td>
                                <td><?= v($b, 'sq_inch') ?></td>
                            </tr>
                        <?php endfor; ?>

                    <?php endif; ?>

                <?php endforeach; ?>

                <tr>
                    <td colspan="8" class="right"><strong>Total sq inch</strong></td>
                    <td><strong><?= number_format($po['total_sq_inch'] ?? 0, 2) ?></strong></td>
                </tr>

            </tbody>

        </table>

        <br>

        <table>
            <tr>
                <th rowspan="2">R/W</th>
                <th>Sq.inch</th>
                <th>3% Wastage</th>
                <th>Total Sq.inch</th>
                <th>Cu.ft</th>
                <th>Rate</th>
                <th rowspan="2">Per No</th>
                <th>Cost</th>
            </tr>
            <tr>
                <td><?= number_format($po['total_sq_inch'] ?? 0, 0) ?></td>
                <td><?= number_format($po['wastage_sq_inch'] ?? 0, 2) ?></td>
                <td><?= number_format($po['net_sq_inch'] ?? 0, 2) ?></td>
                <td><?= number_format($po['cu_ft'] ?? 0, 2) ?></td>
                <td><?= number_format($po['rate'] ?? 0, 2) ?></td>
                <td><strong><?= number_format($po['total_cost'] ?? 0, 2) ?></strong></td>
            </tr>
        </table>

        <div class="bottom_div"></div>
    </div>
</body>

</html>