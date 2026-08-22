<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 2px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        table th {
            background: #FFEB9C;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>SR. NO.</th>
                <th>INDENT NO.</th>
                <th>DATE</th>
                <th>CLIENT</th>
                <th>FAN DIA</th>
                <th>DBSE</th>
                <th>QTY.</th>
                <th>MOTOR POWER/RPM</th>
                <th>MOTOR SIDE<br>SHAFT DIA / KEY WAY</th>
                <th>GEAR SIDE<br>SHAFT DIA / KEY WAY</th>
                <th>GEARBOX MODEL NO.</th>
                <th>FAN RPM</th>
                <th>DELIVERY</th>
            </tr>
        </thead>

        <tbody>

            <?php
            $sr = 1;

            foreach ($indent_details as $value) {

                $bore = !empty($value['bore'])
                    ? json_decode($value['bore'], true)
                    : [];

                $keyway = !empty($value['keyway'])
                    ? json_decode($value['keyway'], true)
                    : [];

                $motor_side = '';
                $gear_side = '';

                if (!empty($bore)) {

                    foreach ($bore as $index => $boreValue) {

                        $motor_bore = $boreValue['motor'] ?? '-';
                        $gear_bore = $boreValue['gear'] ?? '-';

                        $motor_key = $keyway[$index]['motor'] ?? '-';
                        $gear_key = $keyway[$index]['gear'] ?? '-';

                        $motor_side .= $motor_bore . ' MM (' . $motor_key . ')<br>';
                        $gear_side .= $gear_bore . ' MM (' . $gear_key . ')<br>';
                    }
                }
                ?>

                <tr>

                    <td>
                        <?= $sr ?>
                    </td>

                    <td>
                        <?= $value['indent_number'] ?? '-' ?>
                    </td>

                    <td>
                        <?= date('d.m.Y', strtotime($value['created_at'])) ?>
                    </td>

                    <td>
                        <?= strtoupper($value['client_name'] ?? '-') ?>
                    </td>

                    <td>
                        <?= $value['fan_dia'] ?? '-' ?>
                    </td>

                    <td>
                        <?= $value['dbse'] ?? '-' ?>
                    </td>

                    <td>
                        <?= $value['qty'] ?? '-' ?>
                    </td>

                    <td>
                        <?= $value['motor_power'] ?? '-' ?> /
                        <?= $value['fan_rpm'] ?? '-' ?>
                    </td>

                    <td>
                        <?= !empty(trim(strip_tags($motor_side))) ? $motor_side : '-' ?>
                    </td>

                    <td>
                        <?= !empty(trim(strip_tags($gear_side))) ? $gear_side : '-' ?>
                    </td>
                    <td>
                        <?= $value['gearbox_model_no'] ?? '-' ?>
                    </td>

                    <td>
                        <?= $value['fan_rpm'] ?? '-' ?>
                    </td>

                    <td>
                        <?= date('d.m.Y', strtotime($value['delivery_date'])) ?>
                    </td>

                </tr>

                <?php
                $sr++;
            }
            ?>

        </tbody>

    </table>

</body>

</html>