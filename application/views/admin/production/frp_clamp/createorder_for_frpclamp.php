<?php init_header(); ?>
<link href="<?= base_url() ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
    type="text/css" />
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
                        <form class=""
                            action="<?php echo base_url() ?>admin/production/Indent/Createorderfor_frp_clamp"
                            enctype="multipart/form-data" method="post" id="frm_indent" autocomplete="off">
                            <input type="hidden" name="order_for" value="<?php echo $type ?>">
                            <input type="hidden" name="indent_sequence" id="indent_sequence"
                                value="<?php echo isset($indentseqNumber) ? $indentseqNumber : ''; ?>">
                            <?php if (isset($blade_data['order_id'])) { ?>
                                <input type="hidden" name="order_id" id="order_id"
                                    value="<?php echo isset($blade_data['order_id']) ? $blade_data['order_id'] : ''; ?>">
                            <?php } ?>
                            <input type="hidden" name="indent_db_id" value="<?= $blade_data['indent_id'] ?? '' ?>">

                            <div class="row">
                                <?php if ($type == "2") { ?>
                                    <input type="hidden" name="spec_id[]" value="">
                                    <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-color">
                                                    <h6><b>Add Indent for FRP Clamp</b></h6>
                                                </span>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label style="border-color:#ced4da;">Location</label>
                                                <select class="form-control select2" name="location_id" id="location_id">
                                                    <option value="3">ENCON COOLING TOWERS PVT. LTD</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label style="border-color:#ced4da;">Indent Date</label>
                                                <input type="date" class="form-control form-control-sm" id="indent_date"
                                                    name="indent_date" value="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">Indent No</label>
                                                <input class="form-control" type="text" id="indent_no"
                                                    name="indent_no" value="<?php echo (isset($indentNumber)) ? $indentNumber : ''; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="border-color:#ced4da;">Delivery Date</label>
                                                <input type="date" class="form-control form-control-sm" id="delivery_date"
                                                    name="delivery_date" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Manual Indent No</label>
                                                <input class="form-control form-control-sm" type="text" id="indent_number"
                                                    placeholder="" name="indent_number">
                                            </div>

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold;">Product Details</h6>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Size</label>
                                                <select class="form-control custom-select select2 " name="clamp_size">
                                                    <option value="" selected disabled>Select Size</option>
                                                    <?php foreach ($clamp_type as $type): ?>
                                                        <option value="<?php echo $type['name']; ?>">
                                                            <?php echo $type['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Material</label>
                                                <select class="form-control custom-select select2" name="material">
                                                    <option value="FRP">FRP</option>
                                                    <?php /* foreach ($clamp_type as $type): ?>
                                                       <option value="<?php echo $type['id']; ?>">
                                                           <?php echo $type['name']; ?>
                                                       </option>
                                                   <?php endforeach; */ ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Create Order Quantity</label>
                                                <input class="form-control form-control-sm" type="number"
                                                    id="create_order_qty" name="qty" value="" min="1" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Make</label>
                                                <input class="form-control form-control-sm" type="text" id="make"
                                                    placeholder="" name="make" value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Remark</label>
                                                <input class="form-control form-control-sm" type="text" id="remark"
                                                    placeholder="" name="remark" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mt-4">
                                                <h6 style="font-weight:bold;">Technical Specifications</h6>
                                                <hr>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2 mb-3 form-group">
                                                        <label>PCD 1</label>
                                                        <input type="text" class="form-control " name="pcd_1" id="pcd1">
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group">
                                                        <label>PCD 2</label>
                                                        <input type="text" class="form-control " name="pcd_2" id="pcd2">
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group">
                                                        <label>Drill Size MM</label>
                                                        <input type="text" class="form-control " name="drill_size"
                                                            id="drill_size">
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group">
                                                        <label>Length MM</label>
                                                        <input type="text" class="form-control " name="length" id="length">
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group">
                                                        <label>Width MM</label>
                                                        <input type="text" class="form-control " name="width" id="width">
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group">
                                                        <label>Height MM</label>
                                                        <input type="text" class="form-control " name="height" id="height">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-color">
                                                    <h6><b>Order Details</b></h6>
                                                </span>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Location</label>
                                                <select class="form-control form-control-sm select2 compact-input"
                                                    name="location_id" id="location_id_ext" readonly>
                                                    <option value="1">PLOT NO.123 ((ECTPL)), SINNAR TALUKA AUDYOGIK VAS...
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Indent Date</label>
                                                <input type="date" class="form-control form-control-sm compact-input"
                                                    id="indent_date_ext" name="indent_date" readonly
                                                    value="<?php echo isset($blade_data['date']) ? $blade_data['date'] : ''; ?>"
                                                    required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Delivery Date</label>
                                                <input type="date" class="form-control form-control-sm compact-input"
                                                    id="delivery_date_ext" name="delivery_date" readonly
                                                    value="<?php echo isset($blade_data['delivery_date']) ? $blade_data['delivery_date'] : ''; ?>"
                                                    required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Indent No</label>
                                                <input class="form-control form-control-sm compact-input" type="text"
                                                    id="indent_no" name="indent_no"
                                                    value="<?php echo isset($blade_data['indent_no']) ? $blade_data['indent_no'] : ''; ?>"
                                                    readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Manual Indent No</label>
                                                <input class="form-control form-control-sm compact-input" type="text"
                                                    id="indent_number" placeholder="" name="indent_number"
                                                    value="<?php echo isset($blade_data['indent_number']) ? $blade_data['indent_number'] : ''; ?>"
                                                    readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Party Name</label>
                                                <input class="form-control form-control-sm compact-input" type="text"
                                                    id="client_name" readonly placeholder="" name="client_name"
                                                    value="<?php echo isset($blade_data['client_name']) ? $blade_data['client_name'] : ''; ?>">
                                            </div>

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold;">Product Details</h6>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Size</label>
                                                <!-- <select class="form-control custom-select select2 " name="clamp_size">
                                                    <option value="" selected disabled>Select Size</option>
                                                    <?php foreach ($clamp_type as $type): ?>
                                                        <option value="<?php echo $type['name']; ?>">
                                                            <?php echo $type['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> -->
                                                <input type="text" name="clamp_size" id="" class="form-control" value="<?php echo isset($blade_data['clamp_size']) ? $blade_data['clamp_size'] : ''; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Material</label>
                                                <!-- <select class="form-control custom-select select2" name="material">
                                                    <?php foreach ($clamp_material as $material): ?>
                                                        <option <?= (!empty($material) && $material == $material['material']) ? 'selected' : ''; ?>>
                                                            <?php echo $material['material']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> -->
                                                <input type="text" name="material" id="" class="form-control" value="<?php echo isset($blade_data['material']) ? $blade_data['material'] : ''; ?>" readonly>
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label>Make</label>
                                                <input class="form-control form-control-sm compact-input" type="text"
                                                    id="make_ext" placeholder="" name="make"
                                                    value="<?php echo isset($blade_data['make']) ? $blade_data['make'] : ''; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Remark</label>
                                                <input class="form-control form-control-sm compact-input" type="text"
                                                    id="remark_ext" placeholder="" name="remark"
                                                    value="<?php echo isset($blade_data['remark']) ? $blade_data['remark'] : ''; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Total Order Quantity</label>
                                                <input class="form-control form-control-sm compact-input" type="number"
                                                    id="totalorder_qty" placeholder="" name="total_order_qty"
                                                    value="<?php echo isset($blade_data['total_order_qty']) ? $blade_data['total_order_qty'] : 0; ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Create Order Quantity</label>
                                                <input class="form-control form-control-sm" type="number" name="qty" value="<?php echo isset($blade_data['order_qty']) ? $blade_data['order_qty'] : 0; ?>" required>
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
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>PCD 1</label>
                                                            <input type="text" class="form-control " value="<?= $blade_data['pcd_1'] ?? '' ?>" name="pcd_1" id="pcd1">
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>PCD 2</label>
                                                            <input type="text" class="form-control " value="<?= $blade_data['pcd_2'] ?? ''  ?>" name="pcd_2" id="pcd2">
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Drill Size MM</label>
                                                            <input type="text" class="form-control " value="<?= $blade_data['drill_size'] ?? ''  ?>" name="drill_size"
                                                                id="drill_size">
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Length MM</label>
                                                            <input type="text" class="form-control " value="<?= $blade_data['length'] ?? ''  ?>" name="length"
                                                                id="length">
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Width MM</label>
                                                            <input type="text" class="form-control " value="<?= $blade_data['width'] ?? ''  ?>" name="width"
                                                                id="width">
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Height MM</label>
                                                            <input type="text" class="form-control " value="<?= $blade_data['height'] ?? ''  ?>" name="height"
                                                                id="height">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>


                                <div class="col-md-12 mt-4">

                                    <div class="card border">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0">CLAMP DETAILS</h5>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center mb-0" id="clampPreviewTable">

                                                <thead style="background:#d9d9d9;">
                                                    <tr>
                                                        <th>CLAMP</th>
                                                        <th>SIZE (LXWXH)</th>
                                                        <th>PCD</th>
                                                        <th>DRILL</th>
                                                        <!-- <th>BOLT</th>
                                                        <th>SUPPORTING BOLT PCD</th>
                                                        <th>WEIGHT / CLAMP</th> -->
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr id="previewRow">
                                                        <td class="font-weight-bold text-danger">NONE</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <!-- <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td> -->
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>

                                        <div class="card-footer text-right">
                                            <button type="button" class="btn btn-success btn-sm"
                                                id="generateClampPreview">
                                                <i class="fa fa-table"></i> Generate Preview
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success btn-theme float-right">
                                        Submit Indent
                                    </button>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <!-- <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-primary btn-sm" id="syncClampData">
                                <i class="fa fa-refresh"></i> Sync Clamp Details
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>

<!-- JS -->
<script>
    $('#generateClampPreview').on('click', function() {

        let clampName = $('select[name="material"] option:selected').text().trim();
        let materialName = $('select[name="clamp_size"] option:selected').text().trim();

        let pcd1 = $('#pcd1').val();
        let pcd2 = $('#pcd2').val();

        let drill = $('#drill_size').val();
        let bolt = $('#bolt').val();
        let supportPcd = $('#supporting_bolt_pcd').val();

        let weight = $('#weight').val();

        let length = $('#length').val();
        let width = $('#width').val();
        let height = $('#height').val();

        // Clamp display
        let clampDisplay = clampName + ' ' + materialName;

        // Size display
        let sizeDisplay = length + ' X ' + width + ' X ' + height;

        // PCD display
        let pcdDisplay = pcd1;

        if (pcd2 != '') {
            pcdDisplay += ' X ' + pcd2;
        }

        let html = `
        <tr id="previewRow">
            <td class="font-weight-bold">
                ${clampDisplay}
            </td>

            <td>
                ${sizeDisplay}
            </td>

            <td>
                ${pcdDisplay}
            </td>

            <td>
                ${drill}
            </td>

        </tr>
    `;

        $('#clampPreviewTable tbody').html(html);

    });
</script>

<script src="<?= base_url(); ?>assets/node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>