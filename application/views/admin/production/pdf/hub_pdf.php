<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h3 {
            background: #FFEB9C;
            border: 2px solid #000;
            padding: 6px;
            margin-top: 15px;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th,
        table td {
            border: 2px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        /* table th {
            background: #FFEB9C;
        } */

        .header-table td {
            text-align: left;
        }
    </style>
</head>

<body>

    <?php foreach ($indent_details as $value) { ?>

        <table class="header-table">
            <tr>
                <td width="20%"><b>Indent No</b></td>
                <td width="30%"><?= $value['indent_number'] ?></td>

                <td width="20%"><b>Date</b></td>
                <td width="30%">
                    <?= !empty($value['created_at']) ? date('d.m.Y', strtotime($value['created_at'])) : '-' ?>
                </td>
            </tr>

            <tr>
                <td><b>Client</b></td>
                <td><?= strtoupper($value['company_name']) ?></td>

                <td><b>Delivery Date</b></td>
                <td>
                    <?= !empty($value['delivery_date']) ? date('d.m.Y', strtotime($value['delivery_date'])) : '-' ?>
                </td>
            </tr>

            <tr>
                <td><b>Qty</b></td>
                <td><?= $value['qty'] ?></td>

                <td><b>Make</b></td>
                <td><?= $value['make'] ?></td>
            </tr>

            <tr>
                <td><b>Remark</b></td>
                <td colspan="3"><?= $value['remark'] ?></td>
            </tr>
        </table>

        <h3>HUB PLATE DETAILS</h3>

        <table>
            <tr>
                <th>Category</th>
                <th>Way</th>
                <th>OD</th>
                <th>Material</th>
                <th>Thickness</th>
            </tr>

            <tr>
                <td><?= $value['hub_plate_category'] ?: '-' ?></td>
                <td><?= $value['hub_plate_way'] ?: '-' ?></td>
                <td><?= $value['hub_plate_od'] ?: '-' ?></td>
                <td><?= $value['hub_plate_material'] ?: '-' ?></td>
                <td><?= $value['hub_plate_thickness'] ?: '-' ?></td>
            </tr>
        </table>

        <h3>FLANGE / HUBSPOOL DETAILS</h3>

        <table>
            <tr>
                <th>OD</th>
                <th>Size</th>
                <th>PCD</th>
                <th>Drill</th>
            </tr>

            <tr>
                <td><?= $value['flange_hubspool_od'] ?: '-' ?></td>
                <td><?= $value['flange_size'] ?: '-' ?></td>
                <td><?= $value['flange_hubspool_pcd'] ?: '-' ?></td>
                <td><?= $value['flange_hubspool_drill'] ?: '-' ?></td>
            </tr>
        </table>

        <h3>TAPER BUSH / FENNER BUSH DETAILS</h3>

        <table>
            <tr>
                <th>Taper Bush OD</th>
                <th>Bore</th>
                <th>Keyway</th>
                <th>Fenner Bush OD</th>
            </tr>

            <tr>
                <td><?= $value['tapperbush_od'] ?: '-' ?></td>
                <td><?= $value['tapperbush_bore'] ?: '-' ?></td>
                <td><?= $value['tapperbush_keyway'] ?: '-' ?></td>
                <td><?= $value['fennerbush_od'] ?: '-' ?></td>
            </tr>
        </table>

        <h3>HARDWARE DETAILS</h3>

        <table>
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Material</th>
            </tr>

            <tr>
                <td><?= $value['hardware_name_1'] ?: '-' ?></td>
                <td><?= $value['hardware_size_1'] ?: '-' ?></td>
                <td><?= $value['hardware_material_1'] ?: '-' ?></td>
            </tr>

            <tr>
                <td><?= $value['hardware_name_2'] ?: '-' ?></td>
                <td><?= $value['hardware_size_2'] ?: '-' ?></td>
                <td><?= $value['hardware_material_2'] ?: '-' ?></td>
            </tr>
        </table>

        <h3>SPACER DETAILS</h3>

        <table>
            <tr>
                <th>Spacer</th>
            </tr>

            <tr>
                <td><?= $value['spacer'] ?: '-' ?></td>
            </tr>
        </table>

    <?php } ?>

</body>

</html>