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

    h6 {
        background: #48bc97;
        padding: 5px 5px 5px;
        color: #fff;
    }
</style>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class=""
                            action="<?php echo base_url() ?>admin/production/Indent/CreateOrderfor_hub"
                            enctype="multipart/form-data" method="post" id="frm_indent" autocomplete="off">
                            <input type="hidden" name="order_for" value="<?php echo $type ?>">
                            <input type="hidden" name="indent_sequence" id="indent_sequence"
                                value="<?php echo isset($blade_data['delivery_date']) ? $indentseqNumber ?? '' : ''; ?>">
                            <?php if (isset($blade_data['order_id'])) { ?>
                                <input type="hidden" name="order_id" id="order_id"
                                    value="<?php echo isset($blade_data['order_id']) ? $blade_data['order_id'] : ''; ?>">
                            <?php } ?>
                            <input type="hidden" name="indent_db_id" value="<?= $blade_data['id'] ?? '' ?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ($type == "2") { ?>
                                        <div class="col-md-12 mb-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="text-color">
                                                        <h6><b>Add Indent for Hub</b></h6>
                                                    </span>
                                                    <hr>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label style="border-color:#ced4da;">Location</label>
                                                    <select class="form-control select2" name="location_id"
                                                        id="location_id">
                                                        <option value="7">ENCON INTERNATIONAL</option>
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
                                                        name="indent_no" value="<?php echo $indentNumber ?? ''; ?>" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label style="border-color:#ced4da;">Delivery Date</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        id="delivery_date" name="delivery_date" value="" required>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Manual Indent No</label>
                                                    <input class="form-control form-control-sm" type="text"
                                                        id="manual_indent_no" name="indent_number"
                                                        value="">
                                                </div>

                                                <div class="col-md-12">
                                                    <h6 class="m-b-0 mt-3" style="font-weight:bold;">Product Details</h6>
                                                    <hr>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Create Order Quantity</label>
                                                    <input class="form-control form-control-sm" type="number"
                                                        id="create_order_qty" name="qty" value="" min="1" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Make</label>
                                                    <input class="form-control form-control-sm" type="text" id="make" name="make" value="">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Remark</label>
                                                    <input class="form-control form-control-sm" type="text" id="remark" name="remark" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 mt-4">
                                                    <h6 style="font-weight:bold;">Hub Plate Data</h6>
                                                    <hr>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Plate Category</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_category">
                                                                <option value="" disabled selected>Select Category</option>
                                                                <option value="single_plate">Single Plate</option>
                                                                <option value="double_plate">Double Plate</option>
                                                                <option value="ring_plate">Ring Plate</option>
                                                                <option value="dia_case">Dia Case</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label>Plate Way</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_way">
                                                                <option value="" disabled selected>Select Way</option>
                                                                <option value="4">4MM</option>
                                                                <option value="6">6MM</option>
                                                                <option value="8">8MM</option>
                                                                <option value="10">10MM</option>
                                                                <option value="12">12MM</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Plate OD</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_od">
                                                                <option value="" disabled selected>Select Diameter</option>
                                                                <?php foreach ($plate_od as $data): ?>
                                                                    <option value="<?php echo $data['name']; ?>">
                                                                        <?php echo $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Plate Hub Material</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_material">
                                                                <option value="" disabled selected>Select Material</option>
                                                                <?php foreach ($materials as $material): ?>
                                                                    <option value="<?php echo $material['name']; ?>">
                                                                        <?php echo $material['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Plate Thickness</label>
                                                            <select class="form-control custom-select select2 " name="hub_plate_thickness">
                                                                <option value="" disabled selected>Select Thickness</option>
                                                                <?php foreach ($thickness as $type): ?>
                                                                    <option value="<?php echo $type['name']; ?>">
                                                                        <?php echo $type['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 mt-4">
                                                    <h6 style="font-weight:bold;">Flange / HubSpool Data</h6>
                                                    <hr>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange / Hubspool Dimension</label>
                                                            <select class="form-control custom-select select2" name="flange_hubspool_od">
                                                                <option value="" disabled selected>Select Dimension</option>
                                                                <option>2012</option>
                                                                <option>2517</option>
                                                                <option>3020</option>
                                                                <option>3020L</option>
                                                                <option>3535</option>
                                                                <option>3535L</option>
                                                                <option>3020L (SS304)</option>
                                                                <option>3020L (SS316L)</option>
                                                                <option>3535L (SS304)</option>
                                                                <option>200MM OD X 144MML SG</option>
                                                                <option>315MM OD X 156MML SG</option>
                                                                <option>400MM OD X 220MML SG</option>
                                                                <option>450MM OD X220MML SG</option>
                                                                <option>500MM OD X 260MML SG</option>
                                                                <option>550MM OD X 260MML SG</option>
                                                                <option>400MM OD X 192MML SG</option>
                                                                <option>500MM OD X 260MML SG</option>
                                                                <option>315MM OD X 156MML SS304</option>
                                                                <option>400MM OD X 220MML SS304</option>
                                                                <option>400MM OD X 220MML SS304 new pattern</option>
                                                                <option>270MM OD X 140MML SS304</option>
                                                                <option>400MM OD X 192MML SS304</option>
                                                                <option>450MM OD X220MML SS304</option>
                                                                <option>450MM OD X220MML SS316L</option>
                                                                <option>315MM OD X 156MML SS316L</option>
                                                                <option>400MM OD X 220MML SS316L</option>
                                                                <option>270MM OD X 140MML SS316L</option>
                                                                <option>400MM OD X 192MML SS316L</option>
                                                                <option>400MM OD X 220MML SS316L new pattern</option>
                                                                <option>400MM OD X 220MML SS316L new pattern with out rib</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange Size</label>
                                                            <input class="form-control form-control-sm" type="text" id="flange_size" name="flange_size" value="">
                                                        </div>

                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange / Hubspool PCD</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="flange_hubspool_pcd" name="flange_hubspool_pcd" value="">
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange / Hubspool Drill</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="flange_hubspool_drill" name="flange_hubspool_drill" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 mt-4 border-right">
                                                    <h6 style="font-weight:bold;">Tapperbush Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Tapperbush Dimension</label>
                                                            <select class="form-control custom-select select2" name="tapperbush_od">
                                                                <option value="" disabled selected>Select Dimension</option>
                                                                <option>2012</option>
                                                                <option>2517</option>
                                                                <option>3020</option>
                                                                <option>3020L</option>
                                                                <option>3535</option>
                                                                <option>3535L</option>
                                                                <option>3020L (SS304)</option>
                                                                <option>3020L (SS316L)</option>
                                                                <option>3535L (SS304)</option>
                                                                <option>200MM OD X 144MML SG</option>
                                                                <option>315MM OD X 156MML SG</option>
                                                                <option>400MM OD X 220MML SG</option>
                                                                <option>450MM OD X220MML SG</option>
                                                                <option>500MM OD X 260MML SG</option>
                                                                <option>550MM OD X 260MML SG</option>
                                                                <option>400MM OD X 192MML SG</option>
                                                                <option>500MM OD X 260MML SG</option>
                                                                <option>315MM OD X 156MML SS304</option>
                                                                <option>400MM OD X 220MML SS304</option>
                                                                <option>400MM OD X 220MML SS304 new pattern</option>
                                                                <option>270MM OD X 140MML SS304</option>
                                                                <option>400MM OD X 192MML SS304</option>
                                                                <option>450MM OD X220MML SS304</option>
                                                                <option>450MM OD X220MML SS316L</option>
                                                                <option>315MM OD X 156MML SS316L</option>
                                                                <option>400MM OD X 220MML SS316L</option>
                                                                <option>270MM OD X 140MML SS316L</option>
                                                                <option>400MM OD X 192MML SS316L</option>
                                                                <option>400MM OD X 220MML SS316L new pattern</option>
                                                                <option>400MM OD X 220MML SS316L new pattern with out rib</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Tapperbush Bore</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="tapperbush_bore" name="tapperbush_bore" value="">
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Tapperbush Keyway</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="tapperbush_keyway" name="tapperbush_keyway" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4">
                                                    <h6 style="font-weight:bold;">Finnerbush Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3 form-group">
                                                            <label>Finnerbush Dimension</label>
                                                            <select class="form-control custom-select select2" name="fennerbush_od">
                                                                <option value="" disabled selected>Select Dimension</option>
                                                                <option>2012</option>
                                                                <option>2517</option>
                                                                <option>3020</option>
                                                                <option>3020L</option>
                                                                <option>3535</option>
                                                                <option>3535L</option>
                                                                <option>3020L (SS304)</option>
                                                                <option>3020L (SS316L)</option>
                                                                <option>3535L (SS304)</option>
                                                                <option>200MM OD X 144MML SG</option>
                                                                <option>315MM OD X 156MML SG</option>
                                                                <option>400MM OD X 220MML SG</option>
                                                                <option>450MM OD X220MML SG</option>
                                                                <option>500MM OD X 260MML SG</option>
                                                                <option>550MM OD X 260MML SG</option>
                                                                <option>400MM OD X 192MML SG</option>
                                                                <option>500MM OD X 260MML SG</option>
                                                                <option>315MM OD X 156MML SS304</option>
                                                                <option>400MM OD X 220MML SS304</option>
                                                                <option>400MM OD X 220MML SS304 new pattern</option>
                                                                <option>270MM OD X 140MML SS304</option>
                                                                <option>400MM OD X 192MML SS304</option>
                                                                <option>450MM OD X220MML SS304</option>
                                                                <option>450MM OD X220MML SS316L</option>
                                                                <option>315MM OD X 156MML SS316L</option>
                                                                <option>400MM OD X 220MML SS316L</option>
                                                                <option>270MM OD X 140MML SS316L</option>
                                                                <option>400MM OD X 192MML SS316L</option>
                                                                <option>400MM OD X 220MML SS316L new pattern</option>
                                                                <option>400MM OD X 220MML SS316L new pattern with out rib</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-9 border-right mt-4">
                                                    <h6 style="font-weight:bold;">Hardware Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Hardware Name</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="quantity" name="hardware_name_1" value="">
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Size</label>
                                                            <select class="form-control custom-select select2 " name="hardware_size_1">
                                                                <option value="" disabled selected>Select Size</option>
                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?php echo $data['name']; ?>">
                                                                        <?php echo $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Material</label>
                                                            <select class="form-control custom-select select2 " name="hardware_material_1">
                                                                <option value="" disabled selected>Select Material</option>
                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?php echo $data['name']; ?>">
                                                                        <?php echo $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 border-bottom mb-2"></div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Hardware Name</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="quantity" name="hardware_name_2" value="">
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Size</label>
                                                            <select class="form-control custom-select select2 " name="hardware_size_2">
                                                                <option value="" disabled selected>Select Size</option>
                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?php echo $data['name']; ?>">
                                                                        <?php echo $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Material</label>
                                                            <select class="form-control custom-select select2 " name="hardware_material_2">
                                                                <option value="" disabled selected>Select Material</option>
                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?php echo $data['name']; ?>">
                                                                        <?php echo $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <h6 style="font-weight:bold;">Spacer Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3 form-group">
                                                            <label>Spacer</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="quantity" placeholder="Add Value" name="spacer" value="">
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
                                                        <h6><b>Add Indent for Hub</b></h6>
                                                    </span>
                                                    <hr>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label style="border-color:#ced4da;">Location</label>
                                                    <select class="form-control select2" name="location_id"
                                                        id="location_id">
                                                        <option value="7">ENCON INTERNATIONAL</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label style="border-color:#ced4da;">Indent Date</label>
                                                    <input type="date" class="form-control form-control-sm compact-input"
                                                        id="indent_date_ext" name="indent_date" readonly
                                                        value="<?php echo isset($blade_data['date']) ? $blade_data['date'] : ''; ?>"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="">Indent No</label>
                                                    <input class="form-control form-control-sm compact-input" type="text"
                                                        id="indent_no" name="indent_no"
                                                        value="<?php echo isset($blade_data['indent_no']) ? $blade_data['indent_no'] : ''; ?>"
                                                        readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label style="border-color:#ced4da;">Delivery Date</label>
                                                    <input type="date" class="form-control form-control-sm compact-input"
                                                        id="delivery_date_ext" name="delivery_date" readonly
                                                        value="<?php echo isset($blade_data['delivery_date']) ? $blade_data['delivery_date'] : ''; ?>"
                                                        required>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Manual Indent No</label>
                                                    <input class="form-control form-control-sm compact-input" type="text"
                                                        id="manual_indent_no_ext" name="indent_number"
                                                        value="<?php echo isset($blade_data['indent_number']) ? $blade_data['indent_number'] : ''; ?>"
                                                        readonly>
                                                </div>

                                                <div class="col-md-12">
                                                    <h6 class="m-b-0 mt-3" style="font-weight:bold;">Product Details</h6>
                                                    <hr>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Total Order Quantity</label>
                                                    <input class="form-control form-control-sm compact-input" type="number"
                                                        id="totalorder_qty" placeholder="" name="total_order_qty"
                                                        value="<?php echo isset($blade_data['total_order_qty']) ? $blade_data['total_order_qty'] : 0; ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Create Order Quantity</label>
                                                    <input class="form-control form-control-sm" type="number" name="qty" min="1" required>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Make</label>
                                                    <input class="form-control form-control-sm compact-input" type="text"
                                                        id="make_ext" name="make"
                                                        value="<?php echo isset($blade_data['make']) ? $blade_data['make'] : ''; ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Remark</label>
                                                    <input class="form-control form-control-sm compact-input" type="text"
                                                        id="remark_ext" name="remark"
                                                        value="<?php echo isset($blade_data['remark']) ? $blade_data['remark'] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 mt-4">
                                                    <h6 style="font-weight:bold;">Hub Plate Data</h6>
                                                    <hr>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Plate Category</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_category">
                                                                <option value="" disabled>Select Category</option>
                                                                <option value="single_plate"
                                                                    <?= (!empty($blade_data['hub_plate_category']) && $blade_data['hub_plate_category'] == 'single_plate') ? 'selected' : ''; ?>>
                                                                    Single Plate
                                                                </option>

                                                                <option value="double_plate"
                                                                    <?= (!empty($blade_data['hub_plate_category']) && $blade_data['hub_plate_category'] == 'double_plate') ? 'selected' : ''; ?>>
                                                                    Double Plate
                                                                </option>

                                                                <option value="ring_plate"
                                                                    <?= (!empty($blade_data['hub_plate_category']) && $blade_data['hub_plate_category'] == 'ring_plate') ? 'selected' : ''; ?>>
                                                                    Ring Plate
                                                                </option>

                                                                <option value="dia_case"
                                                                    <?= (!empty($blade_data['hub_plate_category']) && $blade_data['hub_plate_category'] == 'dia_case') ? 'selected' : ''; ?>>
                                                                    Dia Case
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label>Plate Way</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_way">
                                                                <option value="" disabled selected>Select Way</option>
                                                                <option value="4"
                                                                    <?= (!empty($blade_data['hub_plate_way']) && $blade_data['hub_plate_way'] == '4') ? 'selected' : ''; ?>>
                                                                    4MM
                                                                </option>

                                                                <option value="6"
                                                                    <?= (!empty($blade_data['hub_plate_way']) && $blade_data['hub_plate_way'] == '6') ? 'selected' : ''; ?>>
                                                                    6MM
                                                                </option>

                                                                <option value="8"
                                                                    <?= (!empty($blade_data['hub_plate_way']) && $blade_data['hub_plate_way'] == '8') ? 'selected' : ''; ?>>
                                                                    8MM
                                                                </option>

                                                                <option value="10"
                                                                    <?= (!empty($blade_data['hub_plate_way']) && $blade_data['hub_plate_way'] == '10') ? 'selected' : ''; ?>>
                                                                    10MM
                                                                </option>

                                                                <option value="12"
                                                                    <?= (!empty($blade_data['hub_plate_way']) && $blade_data['hub_plate_way'] == '12') ? 'selected' : ''; ?>>
                                                                    12MM
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Plate OD</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_od">
                                                                <option value="" disabled>Select Diameter</option>

                                                                <?php foreach ($plate_od as $data): ?>
                                                                    <option value="<?= $data['name']; ?>"
                                                                        <?= (!empty($blade_data['hub_plate_od']) && $blade_data['hub_plate_od'] == $data['name']) ? 'selected' : ''; ?>>
                                                                        <?= $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 mb-3 form-group">
                                                            <label>Plate Hub Material</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_material">
                                                                <option value="" disabled>Select Material</option>

                                                                <?php foreach ($materials as $material): ?>
                                                                    <option value="<?= $material['name']; ?>"
                                                                        <?= (!empty($blade_data['hub_plate_material']) && $blade_data['hub_plate_material'] == $material['name']) ? 'selected' : ''; ?>>
                                                                        <?= $material['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Plate Thickness</label>
                                                            <select class="form-control custom-select select2" name="hub_plate_thickness">
                                                                <option value="" disabled>Select Thickness</option>

                                                                <?php foreach ($thickness as $type): ?>
                                                                    <option value="<?= $type['name']; ?>"
                                                                        <?= (!empty($blade_data['hub_plate_thickness']) && $blade_data['hub_plate_thickness'] == $type['name']) ? 'selected' : ''; ?>>
                                                                        <?= $type['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 mt-4">
                                                    <h6 style="font-weight:bold;">Flange / HubSpool Data</h6>
                                                    <hr>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange / Hubspool Dimension</label>
                                                            <?php
                                                            $dimensions = [
                                                                '2012',
                                                                '2517',
                                                                '3020',
                                                                '3020L',
                                                                '3535',
                                                                '3535L',
                                                                '3020L (SS304)',
                                                                '3020L (SS316L)',
                                                                '3535L (SS304)',
                                                                '200MM OD X 144MML SG',
                                                                '315MM OD X 156MML SG',
                                                                '400MM OD X 220MML SG',
                                                                '450MM OD X220MML SG',
                                                                '500MM OD X 260MML SG',
                                                                '550MM OD X 260MML SG',
                                                                '400MM OD X 192MML SG',
                                                                '315MM OD X 156MML SS304',
                                                                '400MM OD X 220MML SS304',
                                                                '400MM OD X 220MML SS304 new pattern',
                                                                '270MM OD X 140MML SS304',
                                                                '400MM OD X 192MML SS304',
                                                                '450MM OD X220MML SS304',
                                                                '450MM OD X220MML SS316L',
                                                                '315MM OD X 156MML SS316L',
                                                                '400MM OD X 220MML SS316L',
                                                                '270MM OD X 140MML SS316L',
                                                                '400MM OD X 192MML SS316L',
                                                                '400MM OD X 220MML SS316L new pattern',
                                                                '400MM OD X 220MML SS316L new pattern with out rib'
                                                            ];
                                                            ?>

                                                            <select class="form-control custom-select select2" name="flange_hubspool_od">
                                                                <option value="" disabled>Select Dimension</option>

                                                                <?php foreach ($dimensions as $dimension): ?>
                                                                    <option value="<?= $dimension ?>"
                                                                        <?= (!empty($blade_data['flange_hubspool_od']) && $blade_data['flange_hubspool_od'] == $dimension) ? 'selected' : ''; ?>>
                                                                        <?= $dimension ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange Size</label>
                                                            <input class="form-control form-control-sm" type="text" id="flange_size" name="flange_size"
                                                                value="<?= isset($blade_data['flange_size']) ? $blade_data['flange_size'] : ''; ?>">
                                                        </div>

                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange / Hubspool PCD</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="flange_hubspool_pcd" name="flange_hubspool_pcd"
                                                                value="<?= isset($blade_data['flange_hubspool_pcd']) ? $blade_data['flange_hubspool_pcd'] : ''; ?>">
                                                        </div>
                                                        <div class="col-md-3 mb-3 form-group">
                                                            <label>Flange / Hubspool Drill</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="flange_hubspool_drill" name="flange_hubspool_drill"
                                                                value="<?= isset($blade_data['flange_hubspool_drill']) ? $blade_data['flange_hubspool_drill'] : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 mt-4 border-right">
                                                    <h6 style="font-weight:bold;">Tapperbush Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Tapperbush Dimension</label>
                                                            <?php
                                                            $dimensions = [
                                                                '2012',
                                                                '2517',
                                                                '3020',
                                                                '3020L',
                                                                '3535',
                                                                '3535L',
                                                                '3020L (SS304)',
                                                                '3020L (SS316L)',
                                                                '3535L (SS304)',
                                                                '200MM OD X 144MML SG',
                                                                '315MM OD X 156MML SG',
                                                                '400MM OD X 220MML SG',
                                                                '450MM OD X220MML SG',
                                                                '500MM OD X 260MML SG',
                                                                '550MM OD X 260MML SG',
                                                                '400MM OD X 192MML SG',
                                                                '315MM OD X 156MML SS304',
                                                                '400MM OD X 220MML SS304',
                                                                '400MM OD X 220MML SS304 new pattern',
                                                                '270MM OD X 140MML SS304',
                                                                '400MM OD X 192MML SS304',
                                                                '450MM OD X220MML SS304',
                                                                '450MM OD X220MML SS316L',
                                                                '315MM OD X 156MML SS316L',
                                                                '400MM OD X 220MML SS316L',
                                                                '270MM OD X 140MML SS316L',
                                                                '400MM OD X 192MML SS316L',
                                                                '400MM OD X 220MML SS316L new pattern',
                                                                '400MM OD X 220MML SS316L new pattern with out rib'
                                                            ];
                                                            ?>

                                                            <select class="form-control custom-select select2" name="tapperbush_od">
                                                                <option value="" disabled>Select Dimension</option>

                                                                <?php foreach ($dimensions as $dimension): ?>
                                                                    <option value="<?= $dimension ?>"
                                                                        <?= (!empty($blade_data['tapperbush_od']) && $blade_data['tapperbush_od'] == $dimension) ? 'selected' : ''; ?>>
                                                                        <?= $dimension ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Tapperbush Bore</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="tapperbush_bore" name="tapperbush_bore"
                                                                value="<?= isset($blade_data['tapperbush_bore']) ? $blade_data['tapperbush_bore'] : ''; ?>">
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Tapperbush Keyway</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="tapperbush_keyway" name="tapperbush_keyway"
                                                                value="<?= isset($blade_data['tapperbush_keyway']) ? $blade_data['tapperbush_keyway'] : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4">
                                                    <h6 style="font-weight:bold;">Finnerbush Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3 form-group">
                                                            <label>Finnerbush Dimension</label>
                                                            <?php
                                                            $dimensions = [
                                                                '2012',
                                                                '2517',
                                                                '3020',
                                                                '3020L',
                                                                '3535',
                                                                '3535L',
                                                                '3020L (SS304)',
                                                                '3020L (SS316L)',
                                                                '3535L (SS304)',
                                                                '200MM OD X 144MML SG',
                                                                '315MM OD X 156MML SG',
                                                                '400MM OD X 220MML SG',
                                                                '450MM OD X220MML SG',
                                                                '500MM OD X 260MML SG',
                                                                '550MM OD X 260MML SG',
                                                                '400MM OD X 192MML SG',
                                                                '315MM OD X 156MML SS304',
                                                                '400MM OD X 220MML SS304',
                                                                '400MM OD X 220MML SS304 new pattern',
                                                                '270MM OD X 140MML SS304',
                                                                '400MM OD X 192MML SS304',
                                                                '450MM OD X220MML SS304',
                                                                '450MM OD X220MML SS316L',
                                                                '315MM OD X 156MML SS316L',
                                                                '400MM OD X 220MML SS316L',
                                                                '270MM OD X 140MML SS316L',
                                                                '400MM OD X 192MML SS316L',
                                                                '400MM OD X 220MML SS316L new pattern',
                                                                '400MM OD X 220MML SS316L new pattern with out rib'
                                                            ];
                                                            ?>
                                                            <select class="form-control custom-select select2" name="fennerbush_od">
                                                                <option value="" disabled>Select Dimension</option>

                                                                <?php foreach ($dimensions as $dimension): ?>
                                                                    <option value="<?= $dimension ?>"
                                                                        <?= (!empty($blade_data['fennerbush_od']) && $blade_data['fennerbush_od'] == $dimension) ? 'selected' : ''; ?>>
                                                                        <?= $dimension ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-9 border-right mt-4">
                                                    <h6 style="font-weight:bold;">Hardware Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Hardware Name</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="quantity" name="hardware_name_1"
                                                                value="<?= isset($blade_data['hardware_name_1']) ? $blade_data['hardware_name_1'] : ''; ?>">
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Size</label>
                                                            <select class="form-control custom-select select2" name="hardware_size_1">
                                                                <option value="" disabled>Select Size</option>

                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?= $data['name']; ?>"
                                                                        <?= (!empty($blade_data['hardware_size_1']) && $blade_data['hardware_size_1'] == $data['name']) ? 'selected' : ''; ?>>
                                                                        <?= $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Material</label>
                                                            <select class="form-control custom-select select2" name="hardware_material_1">
                                                                <option value="" disabled>Select Material</option>

                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?= $data['name']; ?>"
                                                                        <?= (!empty($blade_data['hardware_material_1']) && $blade_data['hardware_material_1'] == $data['name']) ? 'selected' : ''; ?>>
                                                                        <?= $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 border-bottom mb-2"></div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Hardware Name</label>
                                                            <input class="form-control form-control-sm"
                                                                type="text"
                                                                name="hardware_name_2"
                                                                value="<?= !empty($blade_data['hardware_name_2']) ? $blade_data['hardware_name_2'] : ''; ?>">
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Size</label>
                                                            <select class="form-control custom-select select2" name="hardware_size_2">
                                                                <option value="" disabled>Select Size</option>

                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?= $data['name']; ?>"
                                                                        <?= (!empty($blade_data['hardware_size_2']) && $blade_data['hardware_size_2'] == $data['name']) ? 'selected' : ''; ?>>
                                                                        <?= $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3 form-group">
                                                            <label>Material</label>
                                                            <select class="form-control custom-select select2" name="hardware_material_2">
                                                                <option value="" disabled>Select Material</option>

                                                                <?php foreach ($hardware_size as $data): ?>
                                                                    <option value="<?= $data['name']; ?>"
                                                                        <?= (!empty($blade_data['hardware_material_2']) && $blade_data['hardware_material_2'] == $data['name']) ? 'selected' : ''; ?>>
                                                                        <?= $data['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <h6 style="font-weight:bold;">Spacer Data</h6>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3 form-group">
                                                            <label>Spacer</label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="quantity" placeholder="Add Value" name="spacer"
                                                                value="<?= !empty($blade_data['spacer']) ? $blade_data['spacer'] : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>


                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success btn-theme float-right">
                                        Submit Indent
                                    </button>
                                </div>
                            </div>
                        </form>


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
<script src="<?= base_url(); ?>assets/node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>