<!DOCTYPE html>
<html>

<head>

    <style>
        @page {
            margin: 18px 22px 25px 22px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        /* =========================================
           MAIN TABLE
        ========================================= */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #555;
            padding: 6px 5px;
            text-align: center;
            vertical-align: middle;
        }

        /* =========================================
           DOCUMENT HEADER
        ========================================= */

        .document-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .document-header td {
            border: none;
            padding: 0;
        }

        .company-name {
            font-size: 17px;
            font-weight: bold;
            text-align: left;
            color: #1f2933;
            letter-spacing: 0.5px;
        }

        .document-title {
            font-size: 15px;
            font-weight: bold;
            text-align: right;
            color: #1f2933;
            text-transform: uppercase;
        }

        .document-subtitle {
            font-size: 8px;
            color: #666;
            margin-top: 3px;
        }

        /* =========================================
           TOP DOCUMENT BAR
        ========================================= */

        .document-bar {
            background: #FFEB9C;
            color: #fff;
            padding: 0px 9px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .document-bar td {
            border: 1px solid #FFEB9C;
            color: #030202;
            padding: 7px;
        }

        /* =========================================
           SECTION HEADER
        ========================================= */

        .section-header {
            background: #e9eef2;
            color: #080808;
            font-weight: bold;
            font-size: 9px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .section-header td {
            text-align: left;
            padding: 6px 8px;
            border: 1px solid #6b7280;
        }

        /* =========================================
           FIELD LABEL
        ========================================= */

        .field-label {
            background: #f1f3f5;
            font-weight: bold;
            font-size: 8.5px;
            color: #374151;
            text-transform: uppercase;
        }

        .field-value {
            background: #ffffff;
            font-size: 10px;
            color: #111827;
            min-height: 16px;
        }

        /* =========================================
           IMPORTANT VALUES
        ========================================= */

        .important-value {
            font-weight: bold;
            font-size: 10.5px;
            color: #111827;
        }

        /* =========================================
           INDENT NUMBER
        ========================================= */

        .indent-number {
            font-weight: bold;
            font-size: 11px;
            color: #111827;
        }

        /* =========================================
           SPECIFICATION TABLE
        ========================================= */

        .spec-table {
            margin-bottom: 10px;
        }

        .spec-table th {
            background: #f1f3f5;
            color: #000000;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .spec-table td {
            font-size: 10px;
        }

        /* =========================================
           STATUS / COLOR
        ========================================= */

        .color-value {
            font-weight: bold;
        }

        /* =========================================
           FOOTER
        ========================================= */

        .footer {
            margin-top: 15px;
            border-top: 1px solid #777;
            padding-top: 6px;
            font-size: 7.5px;
            color: #666;
        }

        .footer table {
            width: 100%;
        }

        .footer td {
            border: none;
            padding: 2px;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            text-align: right;
        }

        /* =========================================
           PAGE BREAK
        ========================================= */

        .record {
            page-break-inside: avoid;
        }
    </style>

</head>


<body>

    <?php

    $sr = 1;

    foreach ($indent_details as $value) {

    ?>

        <div class="record">


            <!-- =====================================================
         DOCUMENT HEADER
    ====================================================== -->

            <table class="document-header">

                <tr>

                    <td width="60%">

                        <div class="company-name">
                           BLADE MANUFACTURING / PRODUCTION
                        </div>

                        <div class="document-subtitle">
                            INDUSTRIAL COMPONENT SPECIFICATION DOCUMENT
                        </div>

                    </td>

                    <td width="40%">

                        <div class="document-title">
                            INDENT SPECIFICATION
                        </div>

                        <div class="document-subtitle" style="text-align:right;">
                            Production Reference Document
                        </div>

                    </td>

                </tr>

            </table>


            <!-- =====================================================
         DOCUMENT IDENTIFICATION
    ====================================================== -->

            <table class="document-bar">

                <tr>

                    <td colspan="4">
                        DOCUMENT INFORMATION
                    </td>

                </tr>

            </table>


            <table class="spec-table">

                <tr>

                    <td colspan="4" class="field-label">
                        SR. NO.
                    </td>

                    <td colspan="4" class="field-label">
                        INDENT NO.
                    </td>

                    <td colspan="4" class="field-label">
                        DATE
                    </td>

                    <td colspan="8" class="field-label">
                        CLIENT
                    </td>

                </tr>

                <tr>

                    <td colspan="4" class="field-value important-value">
                        <?= $sr ?>
                    </td>

                    <td colspan="4" class="field-value indent-number">
                        <?= $value['indent_number'] ?? '-' ?>
                    </td>

                    <td colspan="4" class="field-value">
                        <?= !empty($value['created_at'])
                            ? date('d.m.Y', strtotime($value['created_at']))
                            : '-' ?>
                    </td>

                    <td colspan="8" class="field-value important-value">
                        <?= strtoupper($value['client_name'] ?? '-') ?>
                    </td>

                </tr>

            </table>


            <!-- =====================================================
         DIMENSION SPECIFICATIONS
    ====================================================== -->

            <table class="document-bar">

                <tr>

                    <td colspan="20">
                        DIMENSION &amp; COMPONENT SPECIFICATIONS
                    </td>

                </tr>

            </table>


            <table class="spec-table">

                <tr>

                    <th colspan="4">
                        MOULD SIZE
                    </th>

                    <th colspan="4">
                        BLADE SIZE
                    </th>

                    <th colspan="4">
                        HUB SIZE
                    </th>

                    <th colspan="4">
                        CLAMP SIZE
                    </th>

                    <th colspan="4">
                        COLOR LENGTH
                    </th>

                </tr>

                <tr>

                    <td colspan="4" class="important-value">
                        <?= $value['mould_size'] ?? '-' ?>
                    </td>

                    <td colspan="4" class="important-value">
                        <?= $value['blade_size'] ?? '-' ?>
                    </td>

                    <td colspan="4" class="important-value">
                        <?= $value['hub_size'] ?? '-' ?>
                    </td>

                    <td colspan="4" class="important-value">
                        <?= $value['clamp_size'] ?? '-' ?>
                    </td>

                    <td colspan="4">
                        <?= $value['collor_length'] ?? '-' ?>
                    </td>

                </tr>

            </table>


            <!-- =====================================================
         LENGTH & FAN SPECIFICATIONS
    ====================================================== -->

            <table class="document-bar">

                <tr>

                    <td colspan="20">
                        LENGTH &amp; FAN SPECIFICATIONS
                    </td>

                </tr>

            </table>


            <table class="spec-table">

                <tr>

                    <th colspan="5">
                        CLAMP LENGTH
                    </th>

                    <th colspan="5">
                        COLOR HUB DIST
                    </th>

                    <th colspan="5">
                        FAN DIA MM
                    </th>

                    <th colspan="5">
                        FAN DIA FT
                    </th>

                </tr>

                <tr>

                    <td colspan="5" class="important-value">
                        <?= $value['clamp_length'] ?? '-' ?>
                    </td>

                    <td colspan="5">
                        <?= $value['collor_hub_dist'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="important-value">
                        <?= $value['fan_dia_mm'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="important-value">
                        <?= $value['fan_dia_ft'] ?? '-' ?>
                    </td>

                </tr>

            </table>


            <!-- =====================================================
         BLADE SPECIFICATIONS
    ====================================================== -->

            <table class="document-bar">

                <tr>

                    <td colspan="20">
                        BLADE &amp; PUNCHING SPECIFICATIONS
                    </td>

                </tr>

            </table>


            <table class="spec-table">

                <tr>

                    <th colspan="5">
                        BLADE QTY
                    </th>

                    <th colspan="5">
                        BLADE PUNCHING NO.
                    </th>

                    <th colspan="5">
                        A TIP
                    </th>

                    <th colspan="5">
                        COLOR
                    </th>

                </tr>

                <tr>

                    <td colspan="5" class="important-value">
                        <?= $value['blade_qty'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="important-value">
                        <?= $value['blade_punching_no'] ?? '-' ?>
                    </td>

                    <td colspan="5">
                        <?= $value['a_tip'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="color-value">
                        <?= $value['color'] ?? '-' ?>
                    </td>

                </tr>

            </table>


            <!-- =====================================================
         FINAL PRODUCTION DETAILS
    ====================================================== -->

            <table class="document-bar">

                <tr>

                    <td colspan="20">
                        PRODUCTION &amp; DELIVERY DETAILS
                    </td>

                </tr>

            </table>


            <table class="spec-table">

                <tr>

                    <th colspan="5">
                        NAME PLATE
                    </th>

                    <th colspan="5">
                        SET
                    </th>

                    <th colspan="5">
                        WAY
                    </th>

                    <th colspan="5">
                        DELIVERY
                    </th>

                </tr>

                <tr>

                    <td colspan="5" class="important-value">
                        <?= $value['name_plate'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="important-value">
                        <?= $value['set'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="important-value">
                        <?= $value['way'] ?? '-' ?>
                    </td>

                    <td colspan="5" class="important-value">
                        <?= !empty($value['delivery_date'])
                            ? date('d.m.Y', strtotime($value['delivery_date']))
                            : '-' ?>
                    </td>

                </tr>

            </table>


            <!-- =====================================================
         APPROVAL / CONTROL AREA
    ====================================================== -->

            <table style="margin-top:14px;">

                <tr>

                    <td colspan="5" class="field-label">
                        PREPARED BY
                    </td>

                    <td colspan="5" class="field-label">
                        CHECKED BY
                    </td>

                    <td colspan="5" class="field-label">
                        APPROVED BY
                    </td>

                    <td colspan="5" class="field-label">
                        STATUS
                    </td>

                </tr>

                <tr>

                    <td colspan="5" style="height:28px;">
                        &nbsp;
                    </td>

                    <td colspan="5">
                        &nbsp;
                    </td>

                    <td colspan="5">
                        &nbsp;
                    </td>

                    <td colspan="5">
                        <strong>PRODUCTION</strong>
                    </td>

                </tr>

            </table>


            <!-- =====================================================
         FOOTER
    ====================================================== -->

            <div class="footer">

                <table>

                    <tr>

                        <td class="footer-left" width="50%">
                            Industrial Production Document
                        </td>

                        <td class="footer-right" width="50%">
                            Confidential / Controlled Copy
                        </td>

                    </tr>

                </table>

            </div>


        </div>


    <?php

        $sr++;
    }

    ?>

</body>

</html>