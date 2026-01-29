<?php init_header(); ?>
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<!-- Page wrapper  -->
<style>
    .dropzone {
        border: none;
    }

    .table thead th,
    .table tbody td {
        vertical-align: middle;
        padding: 6px;
        border: 1px solid #ddd;
    }

    .table tbody td .form-control {
        text-align: center;
        margin: 0px;
        border: 1px solid #ddd;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .control-label {
        /* font-weight: 600; */
        /* font-size: 13px; */
    }

    .form-control {
        height: 34px;
        font-size: 13px;
    }

    textarea.form-control {
        height: 70px;
        resize: vertical;
    }
</style>
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <!--  <div class="card-header bg-info">
            <h4 class="m-b-0 text-white">Purchase Order </h4>
            </div> -->
                    <div class="card-body">
                        <form method="post" autocomplete="off" id="frm_po" name="frm_po" action="<?= base_url('admin/BoxPO/add_boxpo'); ?>">
                            <?php if (!empty($id)): ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                            <?php endif; ?>

                            <div class="form-body">
                                <div class="row ">
                                    <div class="col-md-6">
                                        <h3 class="box-title">Box Purchase Order Info</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="box-title">Cost Project</h3>
                                    </div>
                                </div>
                                <hr class="m-t-0 m-b-10">
                                <div>
                                    <div class="row ">
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">Box-PO Order No. </label>
                                                <div class="col-md-8">
                                                    <div class="col-md-12">
                                                        <?php if (isset($type) && $type == 1) { ?>
                                                            <input type="text" class="form-control" value="<?= $po_number; ?>" readonly name="boxpo_order_no" id="boxpo_order_no">
                                                        <?php } elseif (isset($type) && $type == 2) { ?>
                                                            <input type="text" class="form-control" value="<?= $po_number; ?>" readonly name="boxpo_order_no" id="boxpo_order_no">
                                                        <?php } else { ?>
                                                            <input type="text" class="form-control" value="<?= (isset($po_info['boxpo_order_no'])) ? $po_info['boxpo_order_no'] : $po_number; ?>" readonly name="boxpo_order_no" id="boxpo_order_no">
                                                        <?php } ?>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">Box-PO Date </label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <?php
                                                        if (isset($id)) {
                                                            $class_name = "mydatepicker";
                                                        } else {
                                                            $class_name = "precurdatepicker";
                                                        }
                                                        ?>
                                                        <input type="text" class="form-control <?= $class_name; ?>" placeholder="mm/dd/yyyy" name="boxpo_date" id="boxpo_date" value="<?= (isset($po_info['boxpo_date'])) ? date('d/m/Y', strtotime($po_info['boxpo_date'])) : date('d/m/Y'); ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">Line Before Address </label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" id="line_before_address" value="<?= (isset($po_info['line_before_address'])) ? $po_info['line_before_address'] : ''; ?>" name="line_before_address">Dear Sir, We are pleased to place our order for followings and requests you to acknowledge receipt and confirm per return  </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">Box-PO Valid From and To</label>
                                                <div class="col-md-8">
                                                    <div class='input-group mb-3'>
                                                        <?php
                                                        if (
                                                            !empty($po_info['boxpo_valid_from']) &&
                                                            !empty($po_info['boxpo_valid_to'])
                                                        ) {
                                                            $date = date('d/m/Y', strtotime($po_info['boxpo_valid_from']))
                                                                . ' - '
                                                                . date('d/m/Y', strtotime($po_info['boxpo_valid_to']));
                                                        } else {
                                                            $date = '';
                                                        }
                                                        ?>

                                                        <input type='text' class="form-control daterange" required id="boxpo_valid_from_to_date" name="boxpo_valid_from_to_date" value="<?= $date; ?>" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <span class="ti-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">vendor </label>
                                                <div class="col-md-8">
                                                    <select class="form-control custom-select select2 get_vendor"
                                                        style="width:100%"
                                                        name="vendor_id"
                                                        id="vendor_id"
                                                        required>

                                                        <?php if (!empty($po_info)): ?>
                                                            <option value="<?= $po_info['vendor_id']; ?>" selected>
                                                                <?= $vendor['account_name'] ?? 'Selected Vendor'; ?>
                                                            </option>
                                                        <?php endif; ?>

                                                    </select>

                                                    <label id="vendor_id-error" class="error" for="vendor_id"></label>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">Address </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="cost_project_address" id="cost_project_address" value="<?= (isset($po_info['address'])) ? $po_info['address'] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                </div>

                                <h3 class="box-title">Dimensions</h3>
                                <hr class="m-t-0 m-b-10">
                                <!-- ================= SIZE & VENDOR ================= -->
                                <!-- ================== CU FT SHEET ================== -->
                                <div>

                                    <table class="table table-bordered text-center" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th colspan="8" style="background-color: #48bc97; color: #fff; font-weight: bold;"><b>CU FT SHEET</b></th>
                                            </tr>
                                            <tr>
                                                <th style="vertical-align: middle; border: 1px solid #ddd; font-weight: bold;">Vendor</th>
                                                <th colspan="7" class="text-left">
                                                    <select class="form-control get_vendor" name="vendor_id">
                                                        <?php foreach ($vendors as $vendor): ?>
                                                            <option value="<?= $vendor['id']; ?>"
                                                                <?= (!empty($po_info) && $po_info['vendor_id'] == $vendor['id']) ? 'selected' : '' ?>>
                                                                <?= $vendor['account_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th style="vertical-align: middle; border: 1px solid #ddd; font-weight: bold;" rowspan="2">SIZE</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(L)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(W)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(H)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(T)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">Plank TYPE </th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd; font-weight: bold;">Thickness</th>
                                            </tr>
                                            <tr>
                                                <td><input id="size_l" type="number" step="0.01" class="form-control" placeholder="Enter Length"></td>
                                                <td><input id="size_w" type="number" step="0.01" class="form-control" placeholder="Enter Width"></td>
                                                <td><input id="size_h" type="number" step="0.01" class="form-control" placeholder="Enter Height"></td>
                                                <td><input id="size_t" type="number" step="0.01" class="form-control" placeholder="Enter Thickness"></td>
                                                <td style="vertical-align: middle; border: 1px solid #ddd;">Major 1"</td>
                                                <td>18/19mm</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered text-center" id="cutSheetTable">
                                        <thead>
                                            <tr>
                                                <th>Section</th>
                                                <th>Type</th>
                                                <th>Length</th>
                                                <th>X</th>
                                                <th>Width</th>
                                                <th>X</th>
                                                <th>Thickness</th>
                                                <th>Qty</th>
                                                <th>Sq.inch</th>
                                                <th>
                                                    <button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody id="sheetBody">

                                            <?php if (!empty($dimensions)): ?>

                                                <?php foreach ($dimensions as $d): ?>
                                                    <tr>
                                                        <td class="section-cell">
                                                            <select class="form-control section" name="dimension[section][]">
                                                                <option value=""></option>
                                                                <?php foreach (['Base', 'Top', 'Long Side', 'Short Side', 'JOINT >=150'] as $sec): ?>
                                                                    <option value="<?= $sec ?>" <?= ($d['section'] == $sec) ? 'selected' : '' ?>>
                                                                        <?= $sec ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>

                                                        <td class="type-cell">
                                                            <select class="form-control type" name="dimension[type][]">
                                                                <option value=""></option>
                                                                <option value="Planks" <?= $d['type'] == 'Planks' ? 'selected' : '' ?>>Planks</option>
                                                                <option value="Battans" <?= $d['type'] == 'Battans' ? 'selected' : '' ?>>Battans</option>
                                                            </select>
                                                        </td>

                                                        <td><input type="number" class="form-control length" name="dimension[length][]" value="<?= $d['length'] ?>"></td>
                                                        <td>X</td>
                                                        <td><input type="number" class="form-control width" name="dimension[width][]" value="<?= $d['width'] ?>"></td>
                                                        <td>X</td>
                                                        <td><input type="number" class="form-control thickness" name="dimension[thickness][]" value="<?= $d['thickness'] ?>"></td>
                                                        <td><input type="number" class="form-control qty" name="dimension[qty][]" value="<?= $d['qty'] ?>"></td>

                                                        <td class="sqinch">
                                                            <input type="hidden" name="dimension[sq_inch][]" class="sqinch-val" value="<?= $d['sq_inch'] ?>">
                                                            <span class="sqinch-text"><?= $d['sq_inch'] ?></span>
                                                        </td>

                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            <?php else: ?>

                                                <!-- ✅ DEFAULT ROW FOR ADD MODE (REQUIRED FOR REPEATER) -->
                                                <tr>
                                                    <td class="section-cell">
                                                        <select class="form-control section" name="dimension[section][]">
                                                            <option value=""></option>
                                                            <option value="Base">Base</option>
                                                            <option value="Top">Top</option>
                                                            <option value="Long Side">Long Side</option>
                                                            <option value="Short Side">Short Side</option>
                                                            <option value="Loose Support">Loose Support</option>
                                                            <option value="JOINT >=150">JOINT >=150</option>
                                                        </select>
                                                    </td>

                                                    <td class="type-cell">
                                                        <select class="form-control type" name="dimension[type][]">
                                                            <option value=""></option>
                                                            <option value="Planks">Planks</option>
                                                            <option value="Battans">Battans</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="number" class="form-control length" name="dimension[length][]"></td>
                                                    <td>X</td>
                                                    <td><input type="number" class="form-control width" name="dimension[width][]"></td>
                                                    <td>X</td>
                                                    <td><input type="number" class="form-control thickness" name="dimension[thickness][]"></td>
                                                    <td><input type="number" class="form-control qty" name="dimension[qty][]"></td>

                                                    <td class="sqinch">
                                                        <input type="hidden" name="dimension[sq_inch][]" class="sqinch-val" value="0">
                                                        <span class="sqinch-text">0</span>
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                                                    </td>
                                                </tr>

                                            <?php endif; ?>

                                        </tbody>


                                        <tfoot>
                                            <tr style="background:#f8f9fa;font-weight:600;">
                                                <td colspan="8" class="text-right">Total Sq.inch</td>
                                                <td id="totalSqColumn" colspan="2">0</td>
                                            </tr>
                                        </tfoot>

                                    </table>

                                    <hr style="border-top: 2px solid #48bc97;">

                                    <table class="table table-bordered text-center mt-3" style="font-size:14px;">
                                        <tbody>
                                            <tr style="background:#f2f2f2;font-weight:600;">
                                                <td>Total Sq.inch</td>
                                                <td id="totalSq" style="color: #1d6600;">0</td>

                                                <td>3% Wastage</td>
                                                <td id="wastage">0</td>

                                                <td>Net Sq.inch</td>
                                                <td id="finalSq">0</td>
                                            </tr>

                                            <tr style="font-weight:600;">
                                                <td>CU FT</td>
                                                <td id="cuft">0</td>

                                                <td>Rate</td>
                                                <td style="padding:4px;">
                                                    <input id="rate"
                                                        type="number"
                                                        name="rate"
                                                        step="0.01"
                                                        class="form-control text-center"
                                                        value="800"
                                                        style="height:32px;">
                                                </td>

                                                <td style="background:#e8f8f3;">Cost</td>
                                                <td id="cost"
                                                    style="background:#e8f8f3;font-weight:700;">
                                                    0
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <input type="hidden" name="total_sq_inch" id="total_sq_inch">
                                    <input type="hidden" name="wastage_sq_inch" id="wastage_sq_inch">
                                    <input type="hidden" name="net_sq_inch" id="net_sq_inch">
                                    <input type="hidden" name="cu_ft" id="cu_ft">
                                    <input type="hidden" name="total_cost" id="total_cost">
                                </div>

                            </div>
                            <hr>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6"> </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-12">
                                                <button type="button" class="btn btn-success btn-theme" onclick="submitPO()" id="submit_po">Submit</button>
                                                <button type="button" class="btn btn-inverse btn-theme-sm">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php init_footer(); ?>

    <script>
        /* =========================================================
   AUTO LOOSE SUPPORT – DO NOT TOUCH CALC LOGIC
========================================================= */

        function qtyFromLength(L) {
            if (L >= 150) return 10;
            if (L >= 120) return 6;
            if (L >= 115) return 5;
            if (L >= 70) return 4;
            if (L >= 43) return 3;
            if (L >= 1) return 2;
            return 0;
        }

        function qtyFromHeight(H) {
            if (H >= 70) return 10;
            if (H >= 50) return 8;
            if (H >= 30) return 6;
            if (H >= 1) return 4;
            return 0;
        }

        function battansThicknessFromLength(L) {
            return (L >= 150) ? 1.5 : 1;
        }

        function looseSupportQty(L) {
            return (L >= 100) ? 4 : 2;
        }

        /* ================= UI ================= */

        function updateRowLayout($row) {
            const section = $row.find('.section').val();
            const $sectionCell = $row.find('.section-cell');
            const $typeCell = $row.find('.type-cell');

            if (section === 'Loose Support' || section === 'JOINT >=150' || section === '') {
                $sectionCell.attr('colspan', 2);
                $typeCell.hide();
            } else {
                $sectionCell.attr('colspan', 1);
                $typeCell.show();
            }
        }

        /* ================= LOOSE SUPPORT ================= */

        function createLooseSupportRow() {

            if ($('#sheetBody tr[data-loose="1"]').length) return;

            let $row = $('#sheetBody tr:first').clone();

            $row.attr('data-loose', '1');

            $row.find('.section')
                .html('<option value="Loose Support" selected>Loose Support</option>')
                .prop('disabled', true);

            $row.find('.type')
                .val('Battans')
                .prop('disabled', true);

            $row.find('.length,.width,.thickness,.qty').val('');

            $row.find('.width')
                .prop('readonly', true)
                .addClass('bg-light');

            $row.find('button').prop('disabled', true).css({
                opacity: 0.5,
                cursor: 'not-allowed'
            });

            $('#sheetBody').append($row);
            updateRowLayout($row);
        }

        function moveLooseSupportToBottom() {
            let $row = $('#sheetBody tr[data-loose="1"]');
            if ($row.length) $('#sheetBody').append($row);
        }

        /* ================= WIDTH SYNC ================= */

        function syncLooseSupportWidth() {
            let W = parseFloat($('#size_w').val());
            if (isNaN(W)) W = '';

            $('#sheetBody tr[data-loose="1"]').each(function() {
                $(this).find('.width')
                    .val(W)
                    .prop('readonly', true);
            });
        }

        /* ================= CALC (UNCHANGED) ================= */

        function calculate(allowAuto = true) {

            let L = parseFloat($('#size_l').val()) || 0;
            let W = parseFloat($('#size_w').val()) || 0;
            let H = parseFloat($('#size_h').val()) || 0;
            let T = parseFloat($('#size_t').val()) || 1;

            let baseQty = qtyFromLength(L);
            let totalSq = 0;

            $('#sheetBody tr').each(function() {
                const $row = $(this);
                updateRowLayout($row);

                let section = $row.find('.section').val();
                let type = $row.find('.type').val();

                let lenInp = $row.find('.length');
                let widInp = $row.find('.width');
                let thkInp = $row.find('.thickness');
                let qtyInp = $row.find('.qty');

                let len = parseFloat(lenInp.val());
                let wid = parseFloat(widInp.val());
                let thk = parseFloat(thkInp.val());
                let qty = parseFloat(qtyInp.val());

                if (type === 'Battans' && allowAuto) {

                    if (isNaN(wid) && widInp.val() === '') {
                        if (section === 'Base' || section === 'Top') wid = W + 2;
                        else if (section === 'Long Side') wid = H + 5;
                        else if (section === 'Short Side') wid = H - 6;
                        else if (section === 'Loose Support') wid = W;
                        widInp.val(wid);
                    }

                    if (isNaN(thk) && thkInp.val() === '') {
                        if (section === 'Base') thk = 3;
                        else if (section === 'Top' || section === 'Long Side') thk = battansThicknessFromLength(L);
                        else if (section === 'Short Side') thk = T;
                        else if (section === 'Loose Support') thk = 2;
                        thkInp.val(thk);
                    }

                    if (isNaN(qty) && qtyInp.val() === '') {
                        if (section === 'Base' || section === 'Top') qty = baseQty;
                        else if (section === 'Long Side') qty = baseQty * 2;
                        else if (section === 'Short Side') qty = qtyFromHeight(H);
                        else if (section === 'Loose Support') qty = looseSupportQty(L);
                        qtyInp.val(qty);
                    }
                }

                len = parseFloat(lenInp.val()) || 0;
                wid = parseFloat(widInp.val()) || 0;
                thk = parseFloat(thkInp.val()) || 0;
                qty = parseFloat(qtyInp.val()) || 0;

                let sq = len * wid * thk * qty;

                $row.find('.sqinch-text').text(sq.toFixed(2));
                $row.find('.sqinch-val').val(sq.toFixed(2));

                if (section !== '') totalSq += sq;
            });

            let wastage = totalSq * 0.03;
            let finalSq = totalSq + wastage;
            let cuft = finalSq / 1728;
            let rate = parseFloat($('#rate').val()) || 0;
            let cost = cuft * rate;

            $('#totalSq').text(totalSq.toFixed(0));
            $('#wastage').text(wastage.toFixed(2));
            $('#finalSq').text(finalSq.toFixed(2));
            $('#cuft').text(cuft.toFixed(2));
            $('#cost').text(cost.toFixed(2));

            $('#total_sq_inch').val(totalSq.toFixed(2));
            $('#wastage_sq_inch').val(wastage.toFixed(2));
            $('#net_sq_inch').val(finalSq.toFixed(2));
            $('#cu_ft').val(cuft.toFixed(2));
            $('#total_cost').val(cost.toFixed(2));
        }

        /* ================= ADD / REMOVE ================= */

        function addRow() {
            let $row = $('#sheetBody tr:not([data-loose]):first').clone();

            $row.find('input').not('.sqinch-val').val('');
            $row.find('.sqinch-text').text('0');
            $row.find('.sqinch-val').val('0');
            $row.find('.section').val('');
            $row.find('.type').val('');

            $('#sheetBody').append($row);

            moveLooseSupportToBottom();
            calculate(false);
        }

        function removeRow(btn) {
            let $row = $(btn).closest('tr');
            if ($row.data('loose')) return;

            if ($('#sheetBody tr:not([data-loose])').length > 1) {
                $row.remove();
                moveLooseSupportToBottom();
                calculate(false);
            }
        }

        /* ================= EVENTS ================= */

        $(document).on('input', '#size_l,#size_w,#size_h,#size_t', function() {
            syncLooseSupportWidth();
            calculate(true);
        });

        $(document).on('input', '.length,.width,.thickness,.qty,#rate', function() {
            calculate(true);
        });

        /* ================= INIT ================= */

        $(function() {
            createLooseSupportRow();
            syncLooseSupportWidth();
            moveLooseSupportToBottom();
            calculate(false);
        });
    </script>






    <!-- Plugin JavaScript -->
    <script src="<?= base_url(); ?>/assets/node_modules/moment/moment.js"></script>
    <script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
    <script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="<?= base_url(); ?>/assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
    <script src="<?= base_url(); ?>/assets/js/page-js/boxpo.js?v=1.0.2"></script>

    <script>
        //   $('.daterange').daterangepicker();
        $('.daterange').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment(),
            endDate: moment()
        });
        $('.precurdatepicker').datepicker({
            format: 'dd/mm/yyyy',
            endDate: new Date(), // Prevents selecting future dates
            autoclose: true,
            todayHighlight: true
        });

        $('.mydatepicker').datepicker({
            defaultDate: "today",
            format: 'dd/mm/yyyy',
        });
        $('body').autotabindex({
            list: '#boxpo_date,#boxpo_valid_from_to_date,#vendor_id,#cost_project_address,#delivery_days,#delivery_days_for_alerts,#payment_days,#payment_days_for_alerts,#guarantee,#reference,#prices,#billing_site_id,#delivery_site_id,#delivery_party_id,#address1,#address2,#address3,#final_discount_percent,#final_discount_amount,#final_gst,#ld_charges,#freight_amount,#freight_tax_id,#freight_tax_rate,#freight_tax_amount,#freight_additional_tax_rate,#freight_additional_tax_rate,#freight_additional_tax_amount,#new_tax_name,n_tax_amount,#new_tax_id,#service_charge_amount,#service_tax_id,#service_tax_rate,#service_tax_amount,#round_off,#po_final_amount'
        });
    </script>