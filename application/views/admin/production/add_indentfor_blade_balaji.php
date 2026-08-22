<?php init_header(); ?>
<link href="<?= base_url() ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
    type="text/css" />
<link href="<?= base_url() ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
    type="text/css" />
<!--alerts CSS -->
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
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="" action="<?php echo base_url() ?>admin/production/Indent/CreateOrderforBladeb"
                            enctype="multipart/form-data" method="post" id="frm_indent" autocomplete="off">
                            <input type="hidden" name="order_for" value="<?php echo  $type ?>">
                            <input type="hidden" name="orderQty" id="orderQty" value="<?php echo isset($orderQty) ? $orderQty : ''; ?>">

                            <div class="row">
                                <?php if ($type == "2") { ?>
                                    <div class="col-md-12 mb-3">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-color">
                                                    <h6><b>Add Indent for Blade Encon(India)</b></h6>
                                                </span>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label style="border-color:#ced4da;" class="">Location</label>
                                                <div class="input-group">
                                                    <!-- <input type="text" class="form-control" id="indent_date"  name="date" value="" required> -->
                                                    <select class="form-control select2 " name="location_id"
                                                        id="location_id">
                                                        <option value="1">ENCON FAN (INDIA) PRIVATE LIMITED</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label style="border-color:#ced4da;" class="">Indent Date</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="indent_date"
                                                        name="indent_date" value="" required>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label style="border-color:#ced4da;" class="">Delivery Date</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="indent_date"
                                                        name="delivery_date" value="" required>

                                                </div>

                                            </div>

                                            <!-- <div class="form-group col-md-3">
                                                <label class="">Indent No</label>
                                                <input class="form-control" type="text" id="indent_no" placeholder="" name="indent_id" value="">
                                            </div> -->
                                            <div class="form-group col-md-3">
                                                <label class="">Manual Indent No</label>
                                                <input class="form-control" type="text" id="manual_indent_no" placeholder=""
                                                    name="manual_indent_no" value="">
                                            </div>


                                            <!-- 
                                            <div class="form-group col-md-3">
                                                <label class="">Party Name</label>
                                                <select class="form-control select2 client_name" onclick="this.setAttribute('value', this.value);" required name="party_id" id="compnay_id" value="">

                                                </select>
                                            </div> -->

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold; ">Blade Details</h6>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Mould Size</label>
                                                <select class="form-control select2 mould_size"
                                                    onclick="this.setAttribute('value', this.value);" required
                                                    name="mould_size" id="" value="">

                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Blade Size</label>
                                                <input class="form-control blade_size" type="text" id="blade_size" name="blade_size">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Hub Size</label>
                                                <input class="form-control hub_size" type="text" id="hub_size" name="hub_size">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Size</label>
                                                <input class="form-control clamp_size" type="text" id="clamp_size" name="clamp_size">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Collor Length</label>
                                                <input class="form-control collor_length" type="text" id="collor_length" name="collor_length">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Length</label>
                                                <input class="form-control clamp_length" type="text" id="clamp_length" name="clamp_length">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp to Hub Dist</label>
                                                <input class="form-control collor_hub_dist" type="text" id="collor_hub_dist" name="collor_hub_dist">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Fan Dia (MM)</label>
                                                <input class="form-control fan_dia_mm" type="text" id="fan_dia_mm" name="fan_dia_mm" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Fan Dia (FT)</label>
                                                <input class="form-control fan_dia_ft" type="text" id="fan_dia_ft" name="fan_dia_ft" readonly>
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label class="">Indent Blade Quantity</label>
                                                <input class="form-control" type="text" id="" placeholder="" name="blade_qty" value="">
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label class="">Create Order Quantity</label>
                                                <input class="form-control" type="text" id="" placeholder=""
                                                    name="order_qty" value="">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">Core</label>
                                                <input class="form-control" type="text" id="" placeholder="" name="core"
                                                    value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Way</label>
                                                <input class="form-control" type="text" id="" placeholder="" name="way"
                                                    value="" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">Set</label>
                                                <input class="form-control" type="text" id="" placeholder=""
                                                    name="order_set" value="" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">A Tip</label>
                                                <select class="form-control select2 a_tip"
                                                    onclick="this.setAttribute('value', this.value);" required name="a_tip"
                                                    id="" value="">

                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Punching Number</label>
                                                <input class="form-control" type="text" id="blade_qty" placeholder=""
                                                    name="blade_punching_no" value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Remark</label>
                                                <input class="form-control" type="text" id="blade_qty" placeholder=""
                                                    name="remark" value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Error 404</label>
                                                <select class="form-control select2 "
                                                    onclick="this.setAttribute('value', this.value);" required name="error"
                                                    id="" value="">
                                                    <option value="1">404</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Type</label>
                                                <select class="form-control select2 "
                                                    onclick="this.setAttribute('value', this.value);" required name="type"
                                                    id="compnay_id" value="">
                                                    <option value="1">Polyster</option>
                                                    <option value="2">Extra Rubber</option>
                                                    <option value="3">Fom Core</option>
                                                    <option value="4">Rubber Bag</option>
                                                </select>
                                            </div>

                                        </div>

                                        <!--   <hr> -->
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12 mb-3">
                                        <!-- <input type="hidden" name="indent_id" id="indent_id" value="<?php echo $blade_data['id']; ?>"> -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-color">
                                                    <h6><b>Add Indent for Blade (Balaji)</b></h6>
                                                </span>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label style="border-color:#ced4da;" class="">Location</label>
                                                <div class="input-group">
                                                    <!-- <input type="text" class="form-control" id="indent_date"  name="date" value="" required> -->
                                                    <select class="form-control select2 " name="location_id" readonly
                                                        id="location_id">
                                                        <option value="1">PLOT NO.123 ((ECTPL)), SINNAR TALUKA AUDYOGIK
                                                            VAS... </option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label style="border-color:#ced4da;" class="">Indent Date</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="indent_date"
                                                        name="indent_date" readonly
                                                        value="<?php echo $blade_data['date']; ?>" required>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label style="border-color:#ced4da;" class="">Displach Plan</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" readonly id="indent_date"
                                                        name="dispatch_date" value="<?php echo $blade_data['date']; ?>"
                                                        required>

                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 d-none">
                                                <label class="">Indent No</label>

                                                <input class="form-control" type="text" id="indent_id" placeholder=""
                                                    name="indent_id" value="<?php echo $blade_data['indent_id']; ?>"
                                                    readonly>


                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">Manual Indent No</label>
                                                <input class="form-control" type="text" id="manual_indent_no" placeholder=""
                                                    name="manual_indent_no"
                                                    value="<?php echo $blade_data['indent_number']; ?>" readonly>
                                            </div>



                                            <div class="form-group col-md-3">
                                                <label class="">Party Name</label>

                                                <select class="form-control select2 " readonly required name="party_id"
                                                    id="party_id">
                                                    <option value="<?php echo $blade_data['company_id']; ?>">
                                                        <?php echo $blade_data['client_name']; ?></option>

                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">FAN DIA(feet)</label>
                                                <input class="form-control" type="text" id="indent_no" readonly
                                                    placeholder="16" name="fan_dia_feet" value="">
                                            </div>

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold; ">Blade </h6>
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Mould Size</label>
                                                <select class="form-control select2 " required name="mould_size" readonly>
                                                    <option value="<?php echo $blade_data['mould_size'] ?>">
                                                        <?php echo $blade_data['mould_size'] ?> </option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Hub Size</label>
                                                <input class="form-control" type="text" id="indent_no" readonly
                                                    placeholder="" name="hub_size" value="">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Blade Size</label>
                                                <input class="form-control blade_size" type="text" id="indent_no" readonly
                                                    placeholder="" name="blade_size"
                                                    value="<?php echo $blade_data['blade_size'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Hub Size</label>
                                                <input class="form-control hub_size" type="text" id="hub_size" name="hub_size" value="<?php echo $blade_data['hub_size'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Size</label>
                                                <input class="form-control clamp_size" type="text" id="clamp_size" name="clamp_size" value="<?php echo $blade_data['clamp_size'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Collor Length</label>
                                                <input class="form-control collor_length" type="text" id="collor_length" name="collor_length" value="<?php echo $blade_data['collor_length'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp Length</label>
                                                <input class="form-control clamp_length" type="text" id="clamp_length" name="clamp_length" value="<?php echo $blade_data['clamp_length'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Clamp to Hub Dist</label>
                                                <input class="form-control collor_hub_dist" type="text" id="collor_hub_dist" name="collor_hub_dist" value="<?php echo $blade_data['collor_hub_dist'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Fan Dia (MM)</label>
                                                <input class="form-control fan_dia_mm" type="text" id="fan_dia_mm" name="fan_dia_mm" value="<?php echo $blade_data['fan_dia_mm'] ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Fan Dia (FT)</label>
                                                <input class="form-control fan_dia_ft" type="text" id="fan_dia_ft" name="fan_dia_ft" value="<?php echo $blade_data['fan_dia_ft'] ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Indent Blade Quantity</label>
                                                <input class="form-control" type="text" id="blade_qty" readonly
                                                    placeholder="4" name="blade_qty"
                                                    value="<?php echo $blade_data['blade_qty'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Punching Number</label>
                                                <input class="form-control" type="text" id="blade_qty" readonly
                                                    placeholder="" name="blade_punching_no"
                                                    value="<?php echo $blade_data['blade_punching_no'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">A Tip</label>
                                                <select class="form-control select2" required name="a_tip" id="" readonly>
                                                    <option value="<?php echo $blade_data['a_tip'] ?>">
                                                        <?php echo $blade_data['a_tip'] ?> </option>
                                                </select>
                                            </div>



                                            <div class="form-group col-md-3">
                                                <label class="">Color</label>
                                                <input class="form-control" type="text" readonly id="blade_qty"
                                                    placeholder="white" name="color"
                                                    value="<?php echo $blade_data['color'] ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Name Plate</label>
                                                <input class="form-control" type="text" id="blade_qty" readonly
                                                    placeholder="44" name="name_plate"
                                                    value="<?php echo $blade_data['name_plate'] ?>">
                                            </div>

                                            <div class="col-md-12">
                                                <h6 class="m-b-0 mt-3" style="font-weight:bold; ">Details</h6>
                                                <hr>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="">Way</label>
                                                <input class="form-control" type="text" id="blade_qty" placeholder="" readonly
                                                    name="way" value="<?php echo $blade_data['way'] ?>" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Set</label>
                                                <input class="form-control" type="text" id="blade_qty" placeholder="" readonly
                                                    name="order_set" value="<?php echo $blade_data['set'] ?>" required>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Total Blade Quantity</label>
                                                <input class="form-control" type="text" id="total_blade_qty" readonly
                                                    placeholder="" name="total_blade_qty"
                                                    value="<?php echo $blade_data['blade_qty'] ?>">
                                            </div>

                                            <?php $remaining_qty = $blade_data['blade_qty'] - $blade_data['order_qty']; ?>
                                            <div class="form-group col-md-3">
                                                <label class="">Remaining Quantity</label>
                                                <input class="form-control" type="text" id="remaining_qty" readonly
                                                    placeholder="" name="total_blade_qty"
                                                    value="<?php echo $remaining_qty ?? 0; ?>">
                                            </div>
                                            
                                            <div class="form-group col-md-3">
                                                <label class="">Create Order Quantity</label>
                                                <input class="form-control" type="text" id="create_order_qty" placeholder=""
                                                    name="order_qty" value="" required>
                                            </div>



                                            <!-- <div class="form-group col-md-3">
                                                <label class="">Blade Finishing Status</label>
                                                <select class="form-control select2 "
                                                    onclick="this.setAttribute('value', this.value);" required
                                                    name="status_finishing" id="compnay_id" value="">
                                                    <option value="1">Gap Checking</option>
                                                    <option value="2">Primer</option>
                                                    <option value="3">Filler</option>
                                                    <option value="4">Putty</option>
                                                    <option value="5">Top Coat</option>
                                                    <option value="6">Balancing</option>
                                                    <option value="7">Packing</option>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label class="">Dispatched Date</label>
                                                <input class="form-control" type="date" id="" placeholder=""
                                                    name="dispatched_date">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="">Dispatched Quantity</label>
                                                <input class="form-control" type="text" id="" placeholder=""
                                                    name="dispatched_qty" value="">
                                            </div>


                                            <div class="form-group col-md-3 ">
                                                <fieldset>

                                                    <div class="custom-control custom-checkbox mt-4">
                                                        <input type="checkbox" name="ready_to_dispatch"
                                                            data-validation-maxchecked-maxchecked="2"
                                                            data-validation-maxchecked-message="Don't be greedy!"
                                                            class="custom-control-input" id="customCheck8" value="1">
                                                        <label class="custom-control-label" for="customCheck8">Ready For
                                                            Dispatched</label>
                                                    </div>
                                                </fieldset>

                                            </div> -->

                                        </div>

                                        <!--   <hr> -->
                                    </div>
                                <?php } ?>
                                <!--  <div class="row"> -->

                                <hr>
                                <button type="submit" class="btn btn-success btn-theme float-right"
                                    style="margin-left: 94%;">Submit</button>
                        </form>



                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<?php init_footer(); ?>

<!-- Sweet-Alert  -->
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>

<script src="<?= base_url(); ?>assets/js/page-js/production/indent.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script>
    function calculateFanDiaMM() {
        let bladeSize = parseFloat(document.getElementsByClassName('blade_size')[0].value) || 0;
        let hubSize = parseFloat(document.getElementsByClassName('hub_size')[0].value) || 0;
        let clampLength = parseFloat(document.getElementsByClassName('clamp_length')[0].value) || 0;
        let collorLength = parseFloat(document.getElementsByClassName('collor_length')[0].value) || 0;
        let collorHubDist = parseFloat(document.getElementsByClassName('collor_hub_dist')[0].value) || 0;

        let fanDiaMM =
            (bladeSize * 2) +
            hubSize -
            (collorLength * 2) -
            (clampLength * 2) -
            (collorHubDist * 2);

        // Set Fan Dia (MM)
        document.getElementsByClassName('fan_dia_mm')[0].value = fanDiaMM.toFixed(2);

        // Calculate and Set Fan Dia (FT)
        let fanDiaFT = fanDiaMM / 304.8;
        document.getElementsByClassName('fan_dia_ft')[0].value = fanDiaFT.toFixed(2);
    }

    // Recalculate whenever any input changes
    [
        'blade_size',
        'hub_size',
        'clamp_length',
        'collor_length',
        'collor_hub_dist'
    ].forEach(function(className) {
        document.getElementsByClassName(className)[0].addEventListener('input', calculateFanDiaMM);
    });
</script>
<script>
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    $(document).ready(function() {
        $('#frm_indent').validate();

        function validateQuantities() {

            var OrderQty = parseInt($("#orderQty").val()) || 0;
            var totalBladeQty = parseInt($("#total_blade_qty").val()) || 0;
            var createOrderQty = parseInt($("#create_order_qty").val()) || 0;
            var remainingQty = parseInt($('#remaining_qty').val()) || 0;
            var totallQty = createOrderQty + OrderQty;
            console.log(`totalBladeQty ${totalBladeQty}, createOrderQty ${createOrderQty} , OrderQty ${OrderQty}`);

            // alert(totalBladeQty)
            if (!isNaN(remainingQty) && !isNaN(totallQty)) {
                if (remainingQty < totallQty) {

                    alert(" Create Order Quantity cannot be greater than Remaining Quantity. Remaining quantity is " + remainingQty);
                    $("#create_order_qty").val("");
                    return false;
                }
            }
            return true;
        }
        $("#create_order_qty").on("change", function() {
            validateQuantities();
        });
    });
</script>
<style>
    .error {
        color: red;
    }
</style>