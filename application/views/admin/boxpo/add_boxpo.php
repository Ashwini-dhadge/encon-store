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

    tr.plank-row {
        background-color: #ffffff !important;
        /* light gray */
    }

    #totalSqColumn {
        background-color: #ffffff !important;
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
                            <?php if (!empty($id) && $type == 2): ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                            <?php endif; ?>
                            <input type="hidden" name="type" value="<?= $type ?>">
                            <input type="hidden" name="amendment_main_boxpo_id" value="<?= ($type == 4) ? $po_info['amendment_main_boxpo_id'] : '' ?>">
                            <input type="hidden" name="amendment_sequence" value="<?= ($type == 4) ? $po_info['amendment_sequence'] : '' ?>">
                            <input type="hidden" name="boxpo_order_sequence" id="boxpo_order_sequence" value="<?= ($type == 2 && isset($po_info['boxpo_order_sequence'])) ? $po_info['boxpo_order_sequence'] : $boxpo_order_sequence ?>">


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
                                                        <input type="text" class="form-control" name="boxpo_order_no" id="boxpo_order_no" readonly required
                                                            value="<?= ($type == 2 && isset($po_info['boxpo_order_no'])) ? $po_info['boxpo_order_no'] : $boxpo_order_no ?>">
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
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">vendor </label>
                                                <div class="col-md-8">
                                                    <select class="form-control get_vendor" name="vendor_id">
                                                        <?php foreach ($vendors as $vendor): ?>
                                                            <option value="<?= $vendor['id']; ?>"
                                                                <?= (!empty($po_info) && $po_info['vendor_id'] == $vendor['id']) ? 'selected' : '' ?>>
                                                                <?= $vendor['account_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                    <label id="vendor_id-error" class="error" for="vendor_id"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4">Joint </label>
                                                <div class="col-md-8">
                                                    <select id="jointToggle" class="form-control mb-3">
                                                        <option value="0">Without JOINT</option>
                                                        <option value="1">With JOINT</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
                                        <tbody>
                                            <tr>
                                                <th style="vertical-align: middle; border: 1px solid #ddd; font-weight: bold;" rowspan="2">SIZE</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(L)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(W)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(H)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">(T)</th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd;  font-weight: bold;">Plank TYPE </th>
                                                <th style="vertical-align: middle; border: 1px solid #ddd; font-weight: bold;">Thickness (mm)</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input id="size_l"
                                                        name="main_length"
                                                        type="number"
                                                        step="0.01"
                                                        class="form-control"
                                                        value="<?= isset($po_info['main_length']) ? $po_info['main_length'] : ''; ?>"
                                                        placeholder="Enter Length">
                                                </td>

                                                <td>
                                                    <input id="size_w"
                                                        name="main_width"
                                                        type="number"
                                                        step="0.01"
                                                        class="form-control"
                                                        value="<?= isset($po_info['main_width']) ? $po_info['main_width'] : ''; ?>"
                                                        placeholder="Enter Width">
                                                </td>

                                                <td>
                                                    <input id="size_h"
                                                        name="main_height"
                                                        type="number"
                                                        step="0.01"
                                                        class="form-control"
                                                        value="<?= isset($po_info['main_height']) ? $po_info['main_height'] : ''; ?>"
                                                        placeholder="Enter Height">
                                                </td>

                                                <td>
                                                    <input id="size_t"
                                                        name="main_thickness"
                                                        type="number"
                                                        step="0.01"
                                                        class="form-control"
                                                        value="<?= isset($po_info['main_thickness']) ? $po_info['main_thickness'] : ''; ?>"
                                                        placeholder="Enter Thickness">
                                                </td>
                                                <td style="vertical-align: middle; border: 1px solid #ddd;">
                                                    <select name="plank_type" id="plank_type" class="form-control">
                                                        <?= (!empty($po_info) && $po_info['plank_type'] == 'Major 1') ? 'selected' : '' ?>>
                                                        <option value="Major 1">Major 1</option>
                                                    </select>

                                                </td>
                                                <td style="width:10%">
                                                    <input type="text" name="thickness" id="thickness" class="form-control" value="<?= isset($po_info['thickness']) ? $po_info['thickness'] : '18/19'; ?>">
                                                </td>

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
                                                    <tr
                                                        <?= $d['section'] === 'Loose Support' ? 'data-loose="1" class="loose-support-row"' : '' ?>
                                                        <?= $d['section'] === 'JOINT >=150' ? 'data-joint="1" class="joint-row"' : '' ?>>

                                                        <td class="section-cell">
                                                            <select class="form-control section" name="dimension[section][]">
                                                                <option value=""></option>
                                                                <?php foreach (['Base', 'Top', 'Long Side', 'Short Side', 'Loose Support', 'JOINT >=150'] as $sec): ?>
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

                                                <tr>
                                                    <td class="section-cell">
                                                        <select class="form-control section" name="dimension[section][]">
                                                            <option value=""></option>
                                                            <option value="Base">Base</option>
                                                            <option value="Top">Top</option>
                                                            <option value="Long Side">Long Side</option>
                                                            <option value="Short Side">Short Side</option>
                                                            <!-- <option value="JOINT >=150">JOINT >=150</option> -->
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
                                                <td rowspan="2" style="vertical-align:middle;">R/W</td>
                                                <td>Sq.inch</td>
                                                <td>3% wastage</td>
                                                <td>Total sq.inch</td>
                                                <td>CU.FT</td>
                                                <td>Rate</td>
                                                <td rowspan="2" style="vertical-align:middle;">Per no.</td>
                                                <td>Cost (Rs.)</td>
                                            </tr>
                                            <tr style="font-weight:600;">
                                                <td id="totalSq" style="color:#1d6600;">0</td>
                                                <td id="wastage">0</td>
                                                <td id="finalSq">0</td>
                                                <td id="cuft">0</td>
                                                <td>
                                                    <input id="rate"
                                                        type="number"
                                                        name="rate"
                                                        step="0.01"
                                                        class="form-control text-center"
                                                        value="<?= isset($po_info['rate']) ? $po_info['rate'] : '0'; ?>"
                                                        style="height:32px;">
                                                </td>
                                                <td id="cost" style="background:#e8f8f3;font-weight:700;">0</td>
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
        function hasMainSizeValues() {

            let L = parseFloat($('#size_l').val());
            let W = parseFloat($('#size_w').val());
            let H = parseFloat($('#size_h').val());
            let T = parseFloat($('#size_t').val());

            return (
                !isNaN(L) && L > 0 &&
                !isNaN(W) && W > 0 &&
                !isNaN(H) && H > 0 &&
                !isNaN(T) && T > 0
            );
        }

        function getMainSize() {
            return {
                L: parseFloat($('#size_l').val()) || 0,
                W: parseFloat($('#size_w').val()) || 0,
                H: parseFloat($('#size_h').val()) || 0,
                T: parseFloat($('#size_t').val()) || 0
            };
        }


        function createJointRows() {

            if ($('#sheetBody tr[data-joint="1"]').length) return;

            let $baseRow = $('#sheetBody tr')
                .filter(function() {
                    return !$(this).data('loose') && !$(this).data('joint');
                })
                .first();

            if (!$baseRow.length) return;

            let $row = $baseRow.clone();
            prepareJointRow($row);

            let $loose = $('#sheetBody tr[data-loose="1"]');
            if ($loose.length) {
                $loose.after($row);
            } else {
                $('#sheetBody').append($row);
            }
        }


        function prepareJointRow($row) {

            $row
                .attr('data-joint', '1')
                .addClass('joint-row');

            $row.find('.section')
                .html('<option value="JOINT >=150" selected>JOINT >=150</option>')
                .prop('disabled', true);

            $row.find('.type')
                .val('Battans')
                .prop('disabled', true);

            $row.find('.length,.width,.thickness,.qty').val('');
            $row.find('button').prop('disabled', true);

            updateRowLayout($row);
        }
    </script>

    <script>
        function keepSpecialRowsAtBottom() {
            let $loose = $('#sheetBody tr[data-loose="1"]');
            let $joint = $('#sheetBody tr[data-joint="1"]');

            if ($loose.length) $('#sheetBody').append($loose);
            if ($joint.length) $('#sheetBody').append($joint);
        }

        $(function() {

            function removeJointRows() {
                $('#sheetBody tr[data-joint="1"]').remove();
            }

            function hasJointFromDB() {
                return $('#sheetBody tr[data-joint="1"]').length > 0;
            }

            $('#jointToggle').on('change', function() {

                if ($(this).val() === '1') {
                    createJointRows();
                } else {
                    removeJointRows();
                }

                calculate(true);
                keepSpecialRowsAtBottom(); // 🔥 FIXED ORDER
            });
            $('#sheetBody tr').each(function() {
                togglePlankRowStyle($(this));
            });


            // EDIT MODE
            if (hasJointFromDB()) {
                $('#jointToggle').val('1');
            } else {
                $('#jointToggle').val('0');
                removeJointRows();
            }

            keepSpecialRowsAtBottom();
        });
    </script>

    <script>
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


        function createLooseSupportRow() {

            let hasLooseSupport = $('#sheetBody tr').filter(function() {
                return (
                    $(this).attr('data-loose') === '1' ||
                    $(this).hasClass('loose-support-row') ||
                    $(this).find('.section option:selected').text().trim() === 'Loose Support'
                );
            }).length > 0;

            if (hasLooseSupport) return;

            let $row = $('#sheetBody tr').filter(function() {
                return !$(this).attr('data-loose');
            }).first().clone();

            if (!$row.length) return;

            $row
                .attr('data-loose', '1')
                .addClass('loose-support-row');

            $row.find('.section')
                .html('<option value="Loose Support" selected>Loose Support</option>')
                .prop('disabled', true);

            $row.find('.type')
                .val('Battans')
                .prop('disabled', true);

            $row.find('.length,.width,.thickness,.qty').val('');

            $row.find('.length')
                .prop('readonly', true)
                .addClass('bg-light');

            $row.find('button').prop('disabled', true);

            $('#sheetBody').append($row);
            updateRowLayout($row);
        }



        function moveLooseSupportToBottom() {
            let $row = $('#sheetBody tr[data-loose="1"]');
            if ($row.length) $('#sheetBody').append($row);
        }


        function syncLooseSupportWidth() {
            let W = parseFloat($('#size_w').val());
            if (isNaN(W)) W = '';

            $('#sheetBody tr[data-loose="1"]').each(function() {
                $(this).find('.length').val(W).prop('readonly', true);
            });
        }



        function applySectionDefaults($row) {
            if (!hasMainSizeValues()) return;

            let section = $row.find('.section').val();
            let type = $row.find('.type').val();

            let mainL = parseFloat($('#size_l').val()) || 0;
            let mainW = parseFloat($('#size_w').val()) || 0;
            let mainH = parseFloat($('#size_h').val()) || 0;
            let mainT = parseFloat($('#size_t').val()) || 0;

            let $len = $row.find('.length');
            let $wid = $row.find('.width');
            let $thk = $row.find('.thickness');
            let $qty = $row.find('.qty');


            if (section === 'Base' && type === 'Planks') {

                if (!$len.val()) {
                    $len.val(mainL + 3);
                }

                if (!$wid.val()) {
                    $wid.val(mainW + 2);
                }

            }


            if (section === 'Base' && type === 'Battans') {

                if (!$len.val()) {
                    $len.val(mainW + 2);
                }

                // keep blank (calculated later)

            }



            if (section === 'Top' && type === 'Planks') {

                if (!$len.val()) {
                    $len.prop('disabled', false);
                    $len.val(mainL + 3);
                }

                if (!$wid.val()) {
                    $wid.val(mainW + 2);
                }

            }


            if (section === 'Top' && type === 'Battans') {

                if (!$len.val()) {
                    $len.val(mainW + 2);
                }

            }


            if (section === 'Long Side' && type === 'Planks') {

                if (!$len.val()) {
                    $len.val(mainL + 3);
                }

                if (!$wid.val()) {
                    $wid.val(mainH);
                }

                if (!$thk.val()) {
                    $thk.val(mainT);
                }
            }

            if (section === 'Long Side' && type === 'Battans') {

                if (!$len.val()) {
                    $len.val(mainH + 5);
                }



            }

            if (section === 'Short Side' && type === 'Planks') {

                if (!$len.val()) {
                    $len.val(mainW);
                }

                if (!$wid.val()) {
                    $wid.val(mainH);
                }

                if (!$thk.val()) {
                    $thk.val(mainT);
                }
            }

            if (section === 'Short Side' && type === 'Battans') {

                // find index of this Short Side + Battans row
                let battanIndex = $('#sheetBody tr').filter(function() {
                    return $(this).find('.section').val() === 'Short Side' &&
                        $(this).find('.type').val() === 'Battans';
                }).index($row);

                if (battanIndex === 0) {

                    if (!$len.val()) {
                        $len.val(mainH - 6);
                    }



                    if (!$qty.val()) {
                        $qty.val(qtyFromHeight(mainH));
                    }
                }

                if (battanIndex === 1) {

                    if (!$len.val()) {
                        $len.val(mainW);
                    }

                    // if (!$wid.val()) {
                    //     $wid.val(3);
                    // }


                }

                if (section === 'JOINT >=150') {

                    if (!$wid.val()) {
                        $wid.val(mainW + 2);
                    }

                    if (!$thk.val()) {
                        $thk.val(mainT);
                    }
                }
            }


            if (section === 'JOINT >=150') {

                // find index of JOINT row
                let jointIndex = $('#sheetBody tr').filter(function() {
                    return $(this).find('.section').val() === 'JOINT >=150';
                }).index($row);

                if (jointIndex === 0) {

                    if (!$wid.val()) {
                        $wid.val(mainW + 2);
                    }

                    if (!$thk.val()) {
                        $thk.val(mainT);
                    }

                    if (!$qty.val()) {
                        $qty.val(mainL >= 150 ? 4 : 0);
                    }
                }

                if (jointIndex === 1) {

                    if (!$wid.val()) {
                        $wid.val(mainH + 2);
                    }

                    if (!$thk.val()) {
                        $thk.val(mainT);
                    }

                    let firstQty = $('#sheetBody tr').filter(function() {
                        return $(this).find('.section').val() === 'JOINT >=150';
                    }).first().find('.qty').val();

                    if (!$qty.val()) {
                        $qty.val(firstQty || 0);
                    }
                }
            }
        }

        function calculate(allowAuto = true) {

            let L = parseFloat($('#size_l').val()) || 0;
            let W = parseFloat($('#size_w').val()) || 0;
            let H = parseFloat($('#size_h').val()) || 0;
            let T = parseFloat($('#size_t').val()) || 1;

            let jointMode = ($('#jointToggle').val() === '1');
            let baseQty = jointMode ? qtyFromLengthWithJoint(L) : qtyFromLengthWithoutJoint(L);
            let totalSq = 0;

            $('#sheetBody tr').each(function() {
                const $row = $(this);
                updateRowLayout($row);

                let section = $row.find('.section').val();
                let type = $row.find('.type').val();

                let rowAllowAuto = allowAuto && hasMainSizeValues();

                let lenInp = $row.find('.length');
                let widInp = $row.find('.width');
                let thkInp = $row.find('.thickness');
                let qtyInp = $row.find('.qty');

                let len = parseFloat(lenInp.val());
                let wid = parseFloat(widInp.val());
                let thk = parseFloat(thkInp.val());
                let qty = parseFloat(qtyInp.val());




                /* ================= BATTANS ================= */

                if (type === 'Battans' && rowAllowAuto) {

                    if (isNaN(thk) && thkInp.val() === '') {

                        let jointMode = ($('#jointToggle').val() === '1');

                        if (jointMode) {

                            if (section === 'Top') {
                                thk = topBattansThicknessWithJoint(L);
                                if (thk > 0) thkInp.val(thk);
                            } else if (section === 'Long Side') {
                                let baseQty = getBaseBattansQty();
                                thk = longSideBattansThicknessWithJoint(L, baseQty);
                                if (thk > 0) thkInp.val(thk);
                            } else if (section === 'Short Side') {
                                thk = T;
                                if (thk > 0) thkInp.val(thk);
                            }

                        } else {

                            if (section === 'Top' || section === 'Long Side') {
                                thk = battansThicknessFromLength(L);
                                if (thk > 0) thkInp.val(thk);
                            } else if (section === 'Short Side') {
                                thk = T;
                                if (thk > 0) thkInp.val(thk);
                            }
                        }
                    }

                    /* ===== BATTANS QTY ===== */

                    if (isNaN(qty) && qtyInp.val() === '') {

                        let baseBattansQty = getBaseBattansQty();

                        if (section === 'Base') {
                            if (baseQty > 0) qty = baseQty;
                        } else if (section === 'Top') {
                            if (baseBattansQty > 0) qty = baseBattansQty;
                        } else if (section === 'Long Side') {
                            if (baseBattansQty > 0) qty = baseBattansQty * 2;
                        } else if (section === 'Short Side') {

                            let battanIndex = $('#sheetBody tr').filter(function() {
                                return $(this).find('.section').val() === 'Short Side' &&
                                    $(this).find('.type').val() === 'Battans';
                            }).index($row);

                            if (battanIndex === 0) {
                                let ssQty = qtyFromHeight(H);
                                if (ssQty > 0) qty = ssQty;
                            }
                        }

                        if (qty !== undefined) qtyInp.val(qty);
                    }
                }


                /* ================= LOOSE SUPPORT ================= */

                if (section === 'Loose Support' && rowAllowAuto) {

                    let looseQty = looseSupportQtyFromLength(L);

                    if (looseQty > 0 && (isNaN(qty) || qtyInp.val() === '')) {
                        qtyInp.val(looseQty);
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


                if (section === 'JOINT >=150' && rowAllowAuto) {

                    let jointIndex = $('#sheetBody tr').filter(function() {
                        return $(this).find('.section').val() === 'JOINT >=150';
                    }).index($row);

                    if (isNaN(wid) && widInp.val() === '') {
                        wid = (jointIndex === 0) ? (W + 2) : (H + 2);
                        widInp.val(wid);
                    }

                    if (rowAllowAuto && isNaN(thk) && thkInp.val() === '') {
                        thk = T;
                        thkInp.val(thk);
                    }

                    if (rowAllowAuto && isNaN(qty) && qtyInp.val() === '') {
                        qty = (L >= 150) ? 4 : 0;
                        qtyInp.val(qty);
                    }
                }

            });

            let wastage = totalSq * 0.03;
            let finalSq = totalSq + wastage;
            let cuft = finalSq / 1728;
            let rate = parseFloat($('#rate').val()) || 0;
            let cost = cuft * rate;

            $('#totalSq').text(totalSq.toFixed(2));
            $('#totalSqColumn').text(totalSq.toFixed(2));
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

        function looseSupportQtyFromLength(L) {

            if (L >= 100) return 4;
            if (L >= 1) return 2;

            return 0;
        }


        function longSideThicknessWithJoint(L, baseQty) {

            if (L >= 150) return 1.5;

            if (baseQty >= 120) return 1;
            if (baseQty >= 115) return 1;
            if (baseQty >= 70) return 1;
            if (baseQty >= 43) return 1;
            if (baseQty >= 1) return 1;

            return 1;
        }

        function getBaseBattansLength() {
            let baseRow = $('#sheetBody tr').filter(function() {
                return $(this).find('.section').val() === 'Base' &&
                    $(this).find('.type').val() === 'Battans';
            }).first();

            return parseFloat(baseRow.find('.length').val()) || 0;
        }


        function topBattansThicknessWithJoint(L) {
            return (L >= 150) ? 1.5 : 1;
        }

        function longSideBattansThicknessWithJoint(L, baseQty) {

            if (L >= 150) return 1.5;

            if (baseQty >= 120) return 1;
            if (baseQty >= 115) return 1;
            if (baseQty >= 70) return 1;
            if (baseQty >= 43) return 1;
            if (baseQty >= 1) return 1;

            return 0;
        }


        function qtyFromLengthWithoutJoint(L) {
            // Excel: =IF(B7>=220,"10",IF(B7>=190,"12",IF(B7>=180,"10",IF(B7>=150,"9",IF(B7>=120,"6",IF(B7>=115,"5",IF(B7>=70,"4",IF(B7>=43,"3",IF(B7>=1,"2")))))))))
            if (L >= 220) return 10;
            if (L >= 190) return 12;
            if (L >= 180) return 10;
            if (L >= 150) return 9;
            if (L >= 120) return 6;
            if (L >= 115) return 5;
            if (L >= 70) return 4;
            if (L >= 43) return 3;
            if (L >= 1) return 2;
            return 0;
        }

        function qtyFromLengthWithJoint(L) {
            // Excel: =IF(B7>=150,"10",IF(B7>=120,"6",IF(B7>=115,"5",IF(B7>=70,"4",IF(B7>=43,"3",IF(B7>=1,"2"))))))
            if (L >= 150) return 10;
            if (L >= 120) return 6;
            if (L >= 115) return 5;
            if (L >= 70) return 4;
            if (L >= 43) return 3;
            if (L >= 1) return 2;
            return 0;
        }

        function getBaseBattansQty() {
            let baseRow = $('#sheetBody tr').filter(function() {
                return $(this).find('.section').val() === 'Base' &&
                    $(this).find('.type').val() === 'Battans';
            }).first();

            return parseFloat(baseRow.find('.qty').val()) || 0;
        }




        function togglePlankRowStyle($row) {
            let type = $row.find('.type').val();

            if (type === 'Planks') {
                $row.addClass('plank-row');
            } else {
                $row.removeClass('plank-row');
            }
        }

        $(document).on('change', '.type', function() {

            let $row = $(this).closest('tr');
            let type = $(this).val();
            let section = $row.find('.section').val();

            if (type === 'Planks' && section) {

                let exists = $('#sheetBody tr').filter(function() {
                    return this !== $row[0] &&
                        $(this).find('.section').val() === section &&
                        $(this).find('.type').val() === 'Planks';
                }).length;

                if (exists > 0) {
                    alert(`Only ONE Plank is allowed in "${section}" section`);
                    $(this).val('');
                    return;
                }
            }

            togglePlankRowStyle($row);
            applySectionDefaults($row);
            calculate(true);
        });



        $(document).on('change', '.type', function() {

            let $row = $(this).closest('tr');
            let selectedType = $(this).val();
            let section = $row.find('.section').val();

            if (selectedType !== 'Planks' || !section) return;

            let plankCount = 0;

            $('#sheetBody tr').each(function() {
                let $r = $(this);

                if (
                    $r[0] !== $row[0] &&
                    $r.find('.section').val() === section &&
                    $r.find('.type').val() === 'Planks'
                ) {
                    plankCount++;
                }
            });

            if (plankCount > 0) {
                alert(`Only ONE Plank is allowed in "${section}" section`);
                $(this).val('');
                return false;
            }
        });



        $(document).on('change', '.section', function() {
            let $row = $(this).closest('tr');
            updateRowLayout($row);
            applySectionDefaults($row);
            calculate(true);
        });

        $(document).on('input', '#size_l,#size_w,#size_h,#size_t', function() {

            if (!hasMainSizeValues()) {
                calculate(false);
                return;
            }

            // 🔥 Let original formula engine handle everything
            $('#sheetBody tr').each(function() {
                applySectionDefaults($(this));
            });

            syncLooseSupportWidth();
            calculate(true);
        });





        $(document).on('input', '.length,.width,.thickness,.qty,#rate', function() {
            calculate(true);
        });


        $(function() {

            $('#sheetBody tr').each(function() {
                togglePlankRowStyle($(this));
            });

            ensureDefaultStructure();
            createLooseSupportRow();
            syncLooseSupportWidth();
            keepSpecialRowsAtBottom();

            calculate(false);
        });



        function addRow() {

            let $row = $('#sheetBody tr').filter(function() {
                let sec = $(this).find('.section').val();
                return (
                    sec &&
                    sec !== 'Loose Support' &&
                    sec !== 'JOINT >=150' &&
                    !$(this).data('loose') &&
                    !$(this).data('joint')
                );
            }).first().clone();

            if (!$row.length) return;

            $row
                .removeAttr('data-loose')
                .removeAttr('data-joint')
                .removeClass('loose-support-row joint-row');

            $row.find('input')
                .not('.sqinch-val')
                .val('')
                .prop('readonly', false)
                .removeClass('bg-light');

            $row.find('.sqinch-text').text('0');
            $row.find('.sqinch-val').val('0');

            $row.find('select')
                .prop('disabled', false);

            $row.find('.section').val('');
            $row.find('.type').val('');

            $row.find('button')
                .prop('disabled', false)
                .css({
                    opacity: 1,
                    cursor: 'pointer'
                });

            let $loose = $('#sheetBody tr[data-loose="1"]');

            if ($loose.length) {
                $loose.before($row);
            } else {
                $('#sheetBody').append($row);
            }

            updateRowLayout($row);
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


        $('form').on('submit', function(e) {

            let plankCount = {};
            let hasError = false;
            let errorMsg = '';

            $('#sheetBody tr').each(function() {

                let $row = $(this);
                let section = $row.find('.section').val();
                let type = $row.find('.type').val();

                let len = parseFloat($row.find('.length').val()) || 0;
                let wid = parseFloat($row.find('.width').val()) || 0;
                let thk = parseFloat($row.find('.thickness').val()) || 0;
                let qty = parseFloat($row.find('.qty').val()) || 0;

                if (!section && !type) return;

                if (type === 'Planks') {
                    plankCount[section] = (plankCount[section] || 0) + 1;

                    if (plankCount[section] > 1) {
                        hasError = true;
                        errorMsg = `Only ONE Plank is allowed in "${section}" section`;
                        return false;
                    }
                }

                if (section === 'Loose Support') {
                    if (qty <= 0 || len <= 0) {
                        hasError = true;
                        errorMsg = 'Loose Support must have Length and Qty greater than 0';
                        return false;
                    }
                }

                if (section === 'JOINT >=150') {
                    if (qty <= 0) {
                        hasError = true;
                        errorMsg = 'JOINT >=150 Qty cannot be 0';
                        return false;
                    }
                }

                if (section && type) {
                    if (len <= 0 || wid <= 0 || thk <= 0 || qty <= 0) {
                        hasError = true;
                        errorMsg = `All fields are required in "${section}" (${type})`;
                        return false;
                    }
                }
            });

            if (hasError) {
                alert(errorMsg);
                e.preventDefault();
                return false;
            }
        });
    </script>

    <script>
        function ensureDefaultStructure() {

            let structure = {
                "Base": {
                    planks: 1,
                    battans: 1
                },
                "Top": {
                    planks: 1,
                    battans: 1
                },
                "Long Side": {
                    planks: 1,
                    battans: 1
                },
                "Short Side": {
                    planks: 1,
                    battans: 2
                }
            };

            Object.keys(structure).forEach(section => {

                let config = structure[section];

                let existingPlanks = findRows(section, 'Planks').length;
                let existingBattans = findRows(section, 'Battans').length;

                if (existingPlanks < config.planks) {
                    let $row = cloneCleanRow();
                    fillRow($row, section, 'Planks');
                    makeRowReadonly($row);
                    insertRowBeforeSpecial($row);
                }

                while (existingBattans < config.battans) {
                    let $row = cloneCleanRow();
                    fillRow($row, section, 'Battans');
                    insertRowBeforeSpecial($row);
                    existingBattans++;
                }

            });

            calculate(false);
        }


        function findRows(section, type) {
            return $('#sheetBody tr').filter(function() {
                return $(this).find('.section').val() === section &&
                    $(this).find('.type').val() === type;
            });
        }

        function cloneCleanRow() {

            let $row = $('#sheetBody tr').first().clone();

            $row.removeAttr('data-loose data-joint')
                .removeClass('loose-support-row joint-row');

            $row.find('input').not('.sqinch-val').val('');
            $row.find('.sqinch-text').text('0');
            $row.find('.sqinch-val').val('0');

            $row.find('select').prop('disabled', false);
            $row.find('button').prop('disabled', false);

            return $row;
        }

        function fillRow($row, section, type) {

            $row.find('.section').val(section);
            $row.find('.type').val(type);

            updateRowLayout($row);

            if (hasMainSizeValues()) {
                applySectionDefaults($row);
            }
        }


        function makeRowReadonly($row) {

            // $row.find('input')
            //     .not('.sqinch-val')
            //     .prop('readonly', true)
            //     .addClass('bg-light');

            $row.find('select').prop('disabled', true);
            $row.find('button').prop('disabled', true);
        }

        function insertRowBeforeSpecial($row) {

            let $special = $('#sheetBody tr[data-loose="1"], #sheetBody tr[data-joint="1"]').first();

            if ($special.length) {
                $special.before($row);
            } else {
                $('#sheetBody').append($row);
            }
        }
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