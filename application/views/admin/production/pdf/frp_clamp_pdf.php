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
                <th>QTY.</th>
                <th>CLAMP SIZE</th>
                <th>MOC</th>
                <th>DELIVERY</th>
            </tr>
        </thead>

        <tbody>

            <?php
            $sr = 1;
            foreach ($indent_details as $value) { ?>
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
                        <?= $value['qty'] ?? '-' ?>
                    </td>

                    <td>
                        <?= $value['clamp_size'] ?? '-' ?>
                    </td>


                    <td>
                        <?= $value['material'] ?? '-' ?>
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