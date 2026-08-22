<?php init_header(); ?>
<link href="<?= base_url() ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .sd {
        display: none;
    }

    .file-drop-zone-title {
        padding: 15px 10px !important;
    }

    .file-preview-image {
        width: auto !important;
        height: 40px !important;
    }

    .file-no-browse,
    .fileinput-cancel-button {
        display: none;
    }

    .kv-file-content {
        display: none !important;
    }

    .color-table.success-table thead th {
        background-color: #48bc97 !important;
        color: #ffffff;
    }

    /* Reduce Bore & Keyway column width */
    /* #specGroupTable .col-bore,
    #specGroupTable .col-keyway {
        width: 5%;
        min-width: 120px;
    } */

    /* Bore & Keyway inputs compact */
    #specGroupTable .bore-wrapper input,
    #specGroupTable .keyway-wrapper input {
        padding: 4px 6px;
        font-size: 12px;
    }

    /* Increase Action column */
    #specGroupTable .col-action {
        width: 10%;
        min-width: 140px;
    }

    /* Keep action buttons inline */
    #specGroupTable .col-action .btn {
        margin-right: 4px;
    }

    /* Prevent table breaking layout */
    #specGroupTable td {
        vertical-align: top;
    }

    /* Quantity Status Styles */
    .quantity-status {
        padding: 3px 9px;
        border-radius: 4px;
        /* margin-top: 10px; */
        font-weight: bold;
        display: inline-block;
    }

    .quantity-status.complete {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
    }

    .quantity-status.incomplete {
        color: #856404;
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
    }

    .quantity-status.exceeded {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }

    /* External table specific styles */
    #specGroupTableExt .add-qty {
        width: 70px;
    }

    #specGroupTableExt td {
        vertical-align: middle;
    }

    /* Action button container */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 4px;
    }

    .bore-row input,
    .keyway-row input {
        width: 45%;
        margin-right: 5px;
    }
</style>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="" action="<?php echo base_url() ?>admin/production/Indent/CreateOrderforcarbon_fiber_drive_shaft"
                            enctype="multipart/form-data" method="post" id="frm_indent" autocomplete="off">
                            <input type="hidden" name="order_for" value="<?php echo $type ?>">
                            <input type="hidden" name="indent_sequence" id="indent_sequence" value="<?php echo isset($blade_data['delivery_date']) ? $indentseqNumber : ''; ?>">
                            <?php if (isset($blade_data['order_id'])) { ?>
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo isset($blade_data['order_id']) ? $blade_data['order_id'] : ''; ?>">
                            <?php } ?>
                            <input type="hidden" name="indent_db_id" value="<?= $blade_data['id'] ?? '' ?>">

                            <div class="row">
                                <?php if ($type == "2") { ?>
                                    <input type="hidden" name="spec_id[]" value="">
                                    <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-color">
                                                    <h6><b>Add Indent for Fan Dia</b></h6>
                                                </span>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label style="border-color:#ced4da;">Location</label>
                                                <select class="form-control select2" name="location_id" id="location_id">
                                                    <option value="7">ENCON INTERNATIONAL</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label style="border-color:#ced4da;">Indent Date</label>
                                                <input type="date" class="form-control form-control-sm" id="indent_date" name="indent_date" value="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">Indent No</label>
                                                <input class="form-control" type="text" id="indent_no" placeholder="" name="indent_no" value="<?php echo $indentNumber; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="border-color:#ced4da;">Delivery Date</label>
                                                <input type="date" class="form-control form-control-sm" id="delivery_date" name="delivery_date" value="" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Manual Indent No</label>
                                                <input class="form-control form-control-sm" type="text" id="manual_indent_no" placeholder="" name="manual_indent_no" value="">
                                            </div>

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold;">Product Details</h6>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Dimension</label>
                                                <input class="form-control form-control-sm" type="text" id="dimension" placeholder="" name="dimension" value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Material</label>
                                                <select class="form-control form-control-sm did-floating-select select2" id="material" name="material">
                                                    <option value="">Select</option>
                                                    <option value="carbon_fiber_composite">Carbon Fiber Composite</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Create Order Quantity</label>
                                                <input class="form-control form-control-sm" type="number" id="create_order_qty" placeholder="" name="order_qty" value="" min="1" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Make</label>
                                                <input class="form-control form-control-sm" type="text" id="make" placeholder="" name="make" value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Remark</label>
                                                <input class="form-control form-control-sm" type="text" id="remark" placeholder="" name="remark" value="">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Attach File for Design</label>
                                                <input class="form-control form-control-sm" type="file" id="design_file" name="design_file">
                                                <?php if (!empty($group['design_file'])) { ?>
                                                    <a href="<?= base_url(CFSD_DESIGN_FILE . $group['design_file']) ?>" target="_blank">
                                                        View File
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mt-4">
                                                <h6 style="font-weight:bold;">Technical Specification Groups</h6>
                                                <hr>
                                            </div>

                                            <div class="col-md-12">
                                                <table class="table table-bordered" id="specGroupTable">
                                                    <thead class="success-table">
                                                        <tr>
                                                            <th style="width:6%">Qty</th>
                                                            <th style="width:8%">Motor Power</th>
                                                            <th style="width:8%">DBSE</th>
                                                            <th style="width:10%">Fan Diameter</th>
                                                            <th style="width:8%">No of Blades</th>
                                                            <th class="col-bore" style="width:15%">Bore</th>
                                                            <th class="col-keyway" style="width:15%">Keyway</th>
                                                            <th style="width:10%">Fan RPM</th>
                                                            <th style="width:14%">Gear box model no.</th>
                                                            <th class="col-action">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>

                                                <button type="button" class="btn btn-info btn-xs" id="addSpecGroup">
                                                    + Add Specification
                                                </button>

                                                <div id="quantityStatus" class="quantity-status incomplete">
                                                    <strong>Assigned Quantity :</strong>
                                                    <span id="assignedQty">0</span> /
                                                    <span id="orderQtyDisplay">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-color">
                                                    <h6><b>Add Indent for Fan Dia</b></h6>
                                                </span>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Location</label>
                                                <select class="form-control form-control-sm select2 compact-input" name="location_id" id="location_id_ext" readonly>
                                                    <option value="1">PLOT NO.123 ((ECTPL)), SINNAR TALUKA AUDYOGIK VAS...</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Indent Date</label>
                                                <input type="date" class="form-control form-control-sm compact-input" id="indent_date_ext" name="indent_date" readonly value="<?php echo isset($blade_data['date']) ? $blade_data['date'] : ''; ?>" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Delivery Date</label>
                                                <input type="date" class="form-control form-control-sm compact-input" id="delivery_date_ext" name="delivery_date" readonly value="<?php echo isset($blade_data['delivery_date']) ? $blade_data['delivery_date'] : ''; ?>" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Indent No</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="indent_no" name="indent_no" value="<?php echo isset($blade_data['indent_no']) ? $blade_data['indent_no'] : ''; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Manual Indent No</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="manual_indent_no_ext" placeholder="" name="manual_indent_no" value="<?php echo isset($blade_data['indent_number']) ? $blade_data['indent_number'] : ''; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Party Name</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="client_name" readonly placeholder="" name="client_name" value="<?php echo isset($blade_data['client_name']) ? $blade_data['client_name'] : ''; ?>">
                                            </div>

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold;">Product Details</h6>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Dimension</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="dimension_ext" readonly placeholder="" name="dimension" value="<?php echo isset($blade_data['dimension']) ? $blade_data['dimension'] : ''; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Material</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="material_ext" readonly placeholder="" name="material" value="<?php echo isset($blade_data['material']) ? $blade_data['material'] : ''; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Make</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="make_ext" placeholder="" name="make" value="<?php echo isset($blade_data['make']) ? $blade_data['make'] : ''; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Total Order Quantity</label>
                                                <input class="form-control form-control-sm compact-input" type="number" id="totalorder_qty" placeholder="" name="totalorder_qty" value="<?php echo isset($blade_data['qty']) ? $blade_data['qty'] : 0; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Remark</label>
                                                <input class="form-control form-control-sm compact-input" type="text" id="remark_ext" placeholder="" name="remark" value="<?php echo isset($blade_data['remark']) ? $blade_data['remark'] : ''; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Create Order Quantity</label>
                                                <input class="form-control form-control-sm compact-input" type="number" id="create_order_qty_ext" placeholder="" name="order_qty" value="0" readonly required>
                                                <small class="text-muted">Auto-calculated from selected groups</small>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Attach File for Design</label>
                                                <input class="form-control form-control-sm" type="file" id="design_file" name="design_file">
                                                <?php if (!empty($blade_data['design_file'])) { ?>
                                                    <a href="<?= base_url(CFSD_DESIGN_FILE . $blade_data['design_file']) ?>" target="_blank">
                                                        View File
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mt-4">
                                                <h5 style="font-weight:600; margin-bottom:4px;">
                                                    Technical Specification
                                                </h5>
                                                <hr style="margin-top:6px;">
                                            </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered align-middle text-center" id="specGroupTableExt">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:6%">Avail Qty</th>
                                                                <th style="width:10%">Motor Power</th>
                                                                <th style="width:10%">DBSE</th>
                                                                <th style="width:10%">Fan Diameter</th>
                                                                <th style="width:10%">No. of Blades</th>
                                                                <th style="width:5%">Bore</th>
                                                                <th style="width:5%">Keyway</th>
                                                                <th style="width:10%">Fan RPM</th>
                                                                <th style="width:12%">Gear box model no.</th>
                                                                <th style="width:10%">Select Qty</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($specifications)) { ?>
                                                                <?php foreach ($specifications as $index => $group) { ?>
                                                                    <input type="hidden" name="spec_id[]" value="<?= $group['id'] ?>">
                                                                    <tr>
                                                                        <td>
                                                                            <input type="number" name="group_qty[]"
                                                                                value="<?= $group['group_qty']; ?>"
                                                                                class="form-control group-qty compact-input" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="motor_power[]"
                                                                                value="<?= $group['motor_power']; ?>"
                                                                                class="form-control compact-input">
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="dbse[]"
                                                                                value="<?= $group['dbse']; ?>"
                                                                                class="form-control compact-input">
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="fan_dia[]"
                                                                                value="<?= $group['fan_dia']; ?>"
                                                                                class="form-control compact-input">
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="no_of_blade[]"
                                                                                value="<?= $group['no_of_blade']; ?>"
                                                                                class="form-control compact-input">
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if (!empty($group['bore'])) {

                                                                                $bore = is_array($group['bore']) ? $group['bore'] : json_decode($group['bore'], true);
                                                                                $boreText = [];

                                                                                if (!empty($bore)) {
                                                                                    foreach ($bore as $b) {

                                                                                        $motor = $b['motor'] ?? '-';
                                                                                        $gear  = $b['gear'] ?? '-';

                                                                                        if (is_array($motor)) {
                                                                                            $motor = $motor['motor'] ?? '-';
                                                                                            $gear  = $motor['gear'] ?? ($b['gear'] ?? '-');
                                                                                        }

                                                                                        if (is_array($gear)) {
                                                                                            $gear = $gear['gear'] ?? '-';
                                                                                        }

                                                                                        $boreText[] = $motor . ' / ' . $gear;
                                                                                    }
                                                                                }

                                                                                echo !empty($boreText) ? implode('<br>', $boreText) : '-';
                                                                            } else {
                                                                                echo '-';
                                                                            }
                                                                            ?>

                                                                            <input type="hidden"
                                                                                name="bore[]"
                                                                                value='<?= !empty($group["bore"]) ? (is_array($group["bore"]) ? htmlspecialchars(json_encode($group["bore"]), ENT_QUOTES, "UTF-8") : htmlspecialchars($group["bore"], ENT_QUOTES, "UTF-8")) : "" ?>'>
                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                            if (!empty($group['keyway'])) {

                                                                                $keyway = is_array($group['keyway']) ? $group['keyway'] : json_decode($group['keyway'], true);
                                                                                $keywayText = [];

                                                                                if (!empty($keyway)) {
                                                                                    foreach ($keyway as $k) {

                                                                                        $motor = $k['motor'] ?? '-';
                                                                                        $gear  = $k['gear'] ?? '-';

                                                                                        if (is_array($motor)) {
                                                                                            $motor = $motor['motor'] ?? '-';
                                                                                            $gear  = $motor['gear'] ?? ($k['gear'] ?? '-');
                                                                                        }

                                                                                        if (is_array($gear)) {
                                                                                            $gear = $gear['gear'] ?? '-';
                                                                                        }

                                                                                        $keywayText[] = $motor . ' / ' . $gear;
                                                                                    }
                                                                                }

                                                                                echo !empty($keywayText) ? implode('<br>', $keywayText) : '-';
                                                                            } else {
                                                                                echo '-';
                                                                            }
                                                                            ?>

                                                                            <input type="hidden"
                                                                                name="keyway[]"
                                                                                value='<?= !empty($group["keyway"]) ? (is_array($group["keyway"]) ? htmlspecialchars(json_encode($group["keyway"]), ENT_QUOTES, "UTF-8") : htmlspecialchars($group["keyway"], ENT_QUOTES, "UTF-8")) : "" ?>'>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="fan_rpm[]"
                                                                                value="<?= $group['fan_rpm']; ?>"
                                                                                class="form-control compact-input">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="gearbox_model_no[]"
                                                                                value="<?= $group['gearbox_model_no']; ?>"
                                                                                class="form-control compact-input">
                                                                        </td>

                                                                        <td>
                                                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                                                <input type="checkbox" class="qty-check" data-max-qty="<?php echo $group['group_qty']; ?>">

                                                                                <input type="number"
                                                                                    class="form-control form-control-sm add-qty m-2"
                                                                                    style="width:70px;"
                                                                                    min="1"
                                                                                    max="<?php echo $group['group_qty']; ?>"
                                                                                    disabled
                                                                                    placeholder="Qty"
                                                                                    name="ext_group_qty[<?php echo $index; ?>]">

                                                                                <input type="hidden"
                                                                                    name="ext_group_id[<?php echo $index; ?>]"
                                                                                    value="<?php echo $group['id']; ?>">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td colspan="8">No specification found</td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                                <div id="quantityStatusExt" class="quantity-status incomplete">
                                                    <strong>Assigned Quantity :</strong>
                                                    <span id="assignedQtyExt">0</span> /
                                                    <span id="orderQtyDisplayExt">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success btn-theme float-right">
                                        Submit Indent
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>

<!-- JS -->
<script src="<?= base_url(); ?>assets/node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize form validation
        $('#frm_indent').validate({
            rules: {
                'order_qty': {
                    required: true,
                    min: 1
                }
            },
            messages: {
                'order_qty': {
                    required: "Please enter order quantity",
                    min: "Quantity must be at least 1"
                }
            },
            errorClass: "text-danger",
            errorElement: "span"
        });

        const QuantityManager = {
            // For ENCON form
            getOrderQty: function() {
                const val = $('#create_order_qty').val();
                return val ? parseInt(val) : 0;
            },

            getAssignedQty: function() {
                let total = 0;
                $('.group-qty').each(function() {
                    const val = $(this).val();
                    if (val) total += parseInt(val);
                });
                return total;
            },

            // For External form
            getExternalOrderQty: function() {
                const val = $('#create_order_qty_ext').val();
                return val ? parseInt(val) : 0;
            },

            getExternalAssignedQty: function() {
                let total = 0;
                $('.add-qty:not(:disabled)').each(function() {
                    const val = $(this).val();
                    if (val) total += parseInt(val);
                });
                return total;
            },

            getTotalOrderQty: function() {
                const val = $('#totalorder_qty').val();
                return val ? parseInt(val) : 0;
            },

            updateDisplay: function() {
                const orderQty = this.getOrderQty();
                const assigned = this.getAssignedQty();

                $('#assignedQty').text(assigned);
                $('#orderQtyDisplay').text(orderQty);

                const statusEl = $('#quantityStatus');
                statusEl.removeClass('complete incomplete exceeded');

                if (orderQty === 0) {
                    statusEl.addClass('incomplete');
                } else if (assigned > orderQty) {
                    statusEl.addClass('exceeded');
                } else if (assigned === orderQty) {
                    statusEl.addClass('complete');
                } else {
                    statusEl.addClass('incomplete');
                }

                return {
                    assigned,
                    orderQty
                };
            },

            updateExternalDisplay: function() {
                return updateExternalOrderQty();
            }
        };

        function updateExternalOrderQty() {
            let totalAssigned = 0;
            let totalOrderQty = QuantityManager.getTotalOrderQty();

            // Calculate total assigned quantity
            $('.add-qty:not(:disabled)').each(function() {
                const val = $(this).val();
                if (val) totalAssigned += parseInt(val);
            });

            // Update assigned quantity display
            $('#assignedQtyExt').text(totalAssigned);
            $('#orderQtyDisplayExt').text(totalOrderQty);

            // Update Create Order Quantity field
            $('#create_order_qty_ext').val(totalAssigned);

            // Update status indicator
            const statusEl = $('#quantityStatusExt');
            statusEl.removeClass('complete incomplete exceeded');

            if (totalAssigned === 0) {
                statusEl.addClass('incomplete');
            } else if (totalAssigned > totalOrderQty) {
                statusEl.addClass('exceeded');
            } else if (totalAssigned === totalOrderQty) {
                statusEl.addClass('complete');
            } else {
                statusEl.addClass('incomplete');
            }

            // Validate against total order quantity
            if (totalAssigned > totalOrderQty) {
                showExceededWarning(totalAssigned, totalOrderQty);
                return false;
            }

            return {
                totalAssigned,
                totalOrderQty
            };
        }

        function showExceededWarning(assigned, total) {
            Swal.fire({
                icon: 'warning',
                title: 'Quantity Exceeded',
                html: `Assigned quantity (${assigned}) exceeds Total Order Quantity (${total}).<br>Please reduce quantities to proceed.`,
                confirmButtonColor: '#48bc97'
            });
        }

        // Create order quantity validation
        $('#create_order_qty').on('keyup change', function() {
            QuantityManager.updateDisplay();
        });

        // Add specification group
        $('#addSpecGroup').on('click', function() {
            const orderQty = QuantityManager.getOrderQty();
            const assigned = QuantityManager.getAssignedQty();

            if (orderQty === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Enter Quantity First',
                    text: 'Please enter Create Order Quantity before adding specification groups.',
                    confirmButtonColor: '#48bc97'
                });
                return;
            }

            if (assigned >= orderQty) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Quantity Completed',
                    text: 'All quantity has been assigned to specification groups.',
                    confirmButtonColor: '#48bc97'
                });
                return;
            }

            addSpecGroupRow();
            QuantityManager.updateDisplay();
        });

        // Copy row
        $(document).on('click', '.copyRow', function() {

            const row = $(this).closest('tr');

            const data = {
                group_qty: row.find('[name="group_qty[]"]').val(),
                motor_power: row.find('[name="motor_power[]"]').val(),
                dbse: row.find('[name="dbse[]"]').val(),
                fan_dia: row.find('[name="fan_dia[]"]').val(),
                no_of_blade: row.find('[name="no_of_blade[]"]').val(),
                fan_rpm: row.find('[name="fan_rpm[]"]').val(),
                gearbox_model_no: row.find('[name="gearbox_model_no[]"]').val()
            };

            addSpecGroupRow();

            const newRow = $('#specGroupTable tbody tr:last');

            newRow.find('[name="group_qty[]"]').val(data.group_qty);
            newRow.find('[name="motor_power[]"]').val(data.motor_power);
            newRow.find('[name="dbse[]"]').val(data.dbse);
            newRow.find('[name="fan_dia[]"]').val(data.fan_dia);
            newRow.find('[name="no_of_blade[]"]').val(data.no_of_blade);
            newRow.find('[name="fan_rpm[]"]').val(data.fan_rpm);
            newRow.find('[name="gearbox_model_no[]"]').val(data.gearbox_model_no);
        });

        // Remove row
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            QuantityManager.updateDisplay();
        });

        // Quantity validation on change
        $(document).on('keyup change', '.group-qty', function() {
            const val = parseInt($(this).val()) || 0;
            const orderQty = QuantityManager.getOrderQty();
            const assigned = QuantityManager.getAssignedQty();

            if (val < 1) {
                $(this).val('');
                QuantityManager.updateDisplay();
                return;
            }

            if (assigned > orderQty) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Quantity Exceeded',
                    text: `Total assigned quantity (${assigned}) exceeds order quantity (${orderQty}).`,
                    confirmButtonColor: '#48bc97'
                });
                $(this).val('');
            }

            QuantityManager.updateDisplay();
        });

        // Enable/disable quantity input
        $(document).on("change", ".qty-check", function() {
            const row = $(this).closest("tr");
            const input = row.find(".add-qty");
            const maxQty = parseInt($(this).data('max-qty')) || 0;

            if ($(this).is(":checked")) {
                input.prop("disabled", false)
                    .attr('max', maxQty)
                    .val('1')
                    .focus();
            } else {
                input.prop("disabled", true).val("");
            }

            updateExternalOrderQty();
        });

        // Validate external quantity input
        $(document).on("keyup change", ".add-qty", function() {
            const row = $(this).closest("tr");
            const maxQty = parseInt($(this).attr('max')) || 0;
            const enteredQty = parseInt($(this).val()) || 0;
            const checkbox = row.find('.qty-check');

            if (!checkbox.is(":checked")) {
                $(this).val("").prop("disabled", true);
                return;
            }

            if (enteredQty < 1) {
                $(this).val('1');
                updateExternalOrderQty();
                return;
            }

            if (enteredQty > maxQty) {
                Swal.fire({
                    icon: "warning",
                    title: "Invalid Quantity",
                    text: "Entered quantity cannot exceed available qty (" + maxQty + ").",
                    confirmButtonColor: "#48bc97"
                });
                $(this).val(maxQty).focus();
            }

            updateExternalOrderQty();
        });

        // Bore field management
        $(document).on('click', '.addBore', function() {

            const wrapper = $(this).closest('.bore-wrapper');
            const index = $(this).closest('tr').data('index');

            wrapper.append(`
                <div class="input-group mb-1 bore-row">
                    <input type="text" name="bore[${index}][]" placeholder="Motor" class="form-control compact-input">
                    <input type="text" name="bore[${index}][]" placeholder="Gear" class="form-control compact-input">

                    <button type="button" class="btn btn-danger btn-xs removeBore">-</button>
                </div>
            `);
        });

        $(document).on('click', '.removeBore', function() {
            if ($(this).closest('.bore-wrapper').find('.bore-row').length > 1) {
                $(this).closest('.bore-row').remove();
            }
        });

        // Keyway field management
        $(document).on('click', '.addKeyway', function() {

            const wrapper = $(this).closest('.keyway-wrapper');
            const index = $(this).closest('tr').data('index');

            wrapper.append(`
                <div class="input-group mb-1 keyway-row">
                    <input type="text" name="keyway[${index}][]" placeholder="Motor" class="form-control compact-input">
                    <input type="text" name="keyway[${index}][]" placeholder="Gear" class="form-control compact-input">

                    <button type="button" class="btn btn-danger btn-xs removeKeyway">-</button>
                </div>
            `);
        });

        $(document).on('click', '.removeKeyway', function() {
            if ($(this).closest('.keyway-wrapper').find('.keyway-row').length > 1) {
                $(this).closest('.keyway-row').remove();
            }
        });

        $('#frm_indent').on('submit', function(e) {
            e.preventDefault();
            const orderType = $('input[name="order_for"]').val();
            let isValid = true;

            if (orderType == "2") {
                // ENCON form validation
                const {
                    assigned,
                    orderQty
                } = QuantityManager.updateDisplay();
                const hasSpecGroups = $('.group-qty').length > 0;

                if (orderQty === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Quantity',
                        text: 'Please enter Create Order Quantity.',
                        confirmButtonColor: '#48bc97'
                    });
                    isValid = false;
                } else if (!hasSpecGroups) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No Specifications',
                        text: 'Please add at least one technical specification group.',
                        confirmButtonColor: '#48bc97'
                    });
                    isValid = false;
                } else if (assigned !== orderQty) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Quantity Mismatch',
                        text: `Assigned quantity (${assigned}) must exactly match Create Order Quantity (${orderQty}).`,
                        confirmButtonColor: '#48bc97'
                    });
                    isValid = false;
                }

                // Validate each group quantity
                $('.group-qty').each(function(index) {
                    const qty = parseInt($(this).val()) || 0;
                    if (qty < 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Group Quantity',
                            text: `Specification group ${index + 1} has an invalid quantity.`,
                            confirmButtonColor: '#48bc97'
                        });
                        isValid = false;
                        return false;
                    }
                });
            } else {
                // External form validation
                const {
                    totalAssigned,
                    totalOrderQty
                } = updateExternalOrderQty();
                const hasSelectedGroups = $('.qty-check:checked').length > 0;

                if (!hasSelectedGroups) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No Quantity Selected',
                        text: 'Please select at least one Quantity.',
                        confirmButtonColor: '#48bc97'
                    });
                    isValid = false;
                } else if (totalAssigned === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No Quantity Assigned',
                        text: 'Please assign quantities to selected specification groups.',
                        confirmButtonColor: '#48bc97'
                    });
                    isValid = false;
                } else if (totalAssigned > totalOrderQty) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Quantity Exceeded',
                        text: `Assigned quantity (${totalAssigned}) exceeds Total Order Quantity (${totalOrderQty}).`,
                        confirmButtonColor: '#48bc97'
                    });
                    isValid = false;
                }

                // Validate each selected group quantity
                $('.add-qty:not(:disabled)').each(function(index) {
                    const qty = parseInt($(this).val()) || 0;
                    if (qty < 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Group Quantity',
                            text: `Specification group ${index + 1} has an invalid quantity.`,
                            confirmButtonColor: '#48bc97'
                        });
                        isValid = false;
                        return false;
                    }
                });
            }

            if (isValid) {
                this.submit();
            }
        });
        // <td><input type="text" name="tube_od_thk[]" class="form-control compact-input" placeholder="e.g., 50*3"></td>
        let specRowCounter = 0;

        function addSpecGroupRow() {

            const index = specRowCounter++;

            const row = `
                <tr data-index="${index}">
                    <td>
                        <input type="number" name="group_qty[]" class="form-control group-qty compact-input" min="1" required>
                    </td>

                    <td>
                        <input type="text" name="motor_power[]" class="form-control compact-input">
                    </td>

                    <td>
                        <input type="text" name="dbse[]" class="form-control compact-input">
                    </td>

                    <td>
                        <input type="text" name="fan_dia[]" class="form-control compact-input">
                    </td>

                    <td>
                        <input type="text" name="no_of_blade[]" class="form-control compact-input">
                    </td>

                    <!-- BORE -->
                    <td>
                        <div class="bore-wrapper">

                            <div class="input-group mb-1 bore-row">
                                <input type="text" name="bore[${index}][]" placeholder="Motor" class="form-control compact-input">
                                <input type="text" name="bore[${index}][]" placeholder="Gear" class="form-control compact-input">

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success btn-xs addBore">+</button>
                                </div>
                            </div>

                        </div>
                    </td>

                    <!-- KEYWAY -->
                    <td>
                        <div class="keyway-wrapper">

                            <div class="input-group mb-1 keyway-row">
                                <input type="text" name="keyway[${index}][]" placeholder="Motor" class="form-control compact-input">
                                <input type="text" name="keyway[${index}][]" placeholder="Gear" class="form-control compact-input">

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success btn-xs addKeyway">+</button>
                                </div>
                            </div>

                        </div>
                    </td>

                    <td>
                        <input type="text" name="fan_rpm[]" class="form-control compact-input">
                    </td>
                    <td>
                        <input type="text" name="gearbox_model_no[]" class="form-control compact-input">
                    </td>

                    <td class="col-action">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-secondary btn-xs copyRow">
                                <i class="fa fa-copy"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs removeRow">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;

            $('#specGroupTable tbody').append(row);
        }

        // Set default dates
        const today = new Date().toISOString().split('T')[0];
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 7);
        const nextWeekStr = nextWeek.toISOString().split('T')[0];

        $('#indent_date').val(today);
        $('#delivery_date').val(nextWeekStr);

        // Initialize displays
        QuantityManager.updateDisplay();
        updateExternalOrderQty();

        // Initialize Select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });
    });
</script>