<?php init_header(); ?>
<link href="<?= base_url(); ?>assets/css/pages/tab-page.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">
<style>
    .badge{
        padding: 8px !important;
    }
    .label{
        padding: 8px !important;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table th,
    table td {
        border: 3px solid #f3f1f1;
        vertical-align: middle !important;

    }

    table th {
        text-align: center;
    }

    .plus-icon:hover {
        cursor: pointer;
    }

    .bs4-order-tracking {
        margin: 30px 0;
        overflow: hidden;
        color: #878788;
        padding-left: 0;
    }

    .bs4-order-tracking li {
        list-style: none;
        font-size: 13px;
        width: 25%;
        float: left;
        position: relative;
        text-align: center;
    }

    .bs4-order-tracking li>div {
        width: 29px;
        line-height: 29px;
        margin: auto;
        background: #878788;
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
    }

    .bs4-order-tracking li:after {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        width: 150%;
        height: 2px;
        background: #878788;
        z-index: -1;
    }

    .bs4-order-tracking li:first-child:after {
        left: 50%;
    }

    .bs4-order-tracking li:last-child:after {
        width: 0;
    }

    .bs4-order-tracking li.active {
        font-weight: bold;
        color: #000;
    }

    .bs4-order-tracking li.active>div,
    .bs4-order-tracking li.active:after {
        background: #28a745;
    }

    .card-timeline {
        background-color: #fff;
        z-index: 0;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    .customtab2 li a.nav-link {
        padding: 4px;
        color: #6c757d;
        /* border-radius: 4px; */
    }

    .customtab2 li a.nav-link.active,
    .customtab2 li a.nav-link:hover {
        background: #20aee3;
        color: #ffffff !important;
    }

    .tooltip-inner2 {
        font-size: 15px;
    }

    .label.design-selection {
        background-color: #1C819E;
        color: #fff;
    }
    .label.custome-received {
        background-color: #20aee3;
        color: #fff;
    }

    .text-value {
        cursor: pointer;
        color: #6c757d;
    }

    .group-detail-box {
        background-color: #e6f9f6;
        border-left: 4px solid #24d2b5;
        border-radius: 5px;
        padding: 3px;
        font-size: 13px;
        color: #333;
        width: fit-content;
    }

    .group-detail-pre {
        background-color: #f8fdfc;
        border-radius: 6px;
        padding: 8px;
        margin-left: 4px;
    }
</style>


<div class="page-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $this->load->view(ADMIN . 'production/tbl_cfds_Received_Orders'); ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModalCenter" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header" style="background:#48bc97;">
                        <h5 class="modal-title text-white">Order Process Update</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="modal_order_id">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Indent No</label>
                                <input type="text" id="indent_no" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Manual No</label>
                                <input type="text" id="manual_no" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Order No</label>
                                <input type="text" id="order_id" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Company</label>
                                <input type="text" id="company" class="form-control form-control-sm" readonly>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Total Qty</label>
                                <input type="number" id="total_qty" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Progress Completed</label>
                                <input type="number" id="created_qty" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Remaining</label>
                                <input type="number" id="remaining_qty" class="form-control form-control-sm" readonly>
                            </div>

                            <!-- <div class="col-md-3">
                                <label>Tube OD * THK</label>
                                <input type="text" id="tube_od_thk" class="form-control form-control-sm">
                            </div> -->
                        </div>

                        <hr>

                        <div class="mt-3">

                            <h6 class="mb-2">Process Stages</h6>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center" style="font-size:13px;">

                                    <thead style="background:#f5f5f5;">
                                        <tr>
                                            <th style="width:120px;">Status Stage</th>
                                            <th>Design Selection</th>
                                            <th>Filament Winding</th>
                                            <th>Size Cutting</th>
                                            <th>Flange Making</th>
                                            <th>Pipe/Coupler Join</th>
                                            <th>Finishing</th>
                                            <th>Inspection</th>
                                            <th>Packaging</th>
                                            <th>Dispatch</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td><b>Quantity</b></td>

                                            <td><input type="number" id="design" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="filament" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="size_cutting" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="flange_making" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="pipe_coupler_join" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="finishing" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="inspection" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="packaging" class="form-control form-control-sm stage-input"></td>
                                            <td><input type="number" id="dispatch" class="form-control form-control-sm stage-input"></td>
                                        </tr>

                                        <tr>
                                            <td><b>Remark</b></td>

                                            <td><textarea id="remark_design" class="form-control form-control-sm" rows="2" placeholder="Enter notes"></textarea></td>
                                            <td><textarea id="remark_filament" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_size_cutting" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_flange_making" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_pipe_coupler_join" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_finishing" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_inspection" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_packaging" class="form-control form-control-sm" rows="2"></textarea></td>
                                            <td><textarea id="remark_dispatch" class="form-control form-control-sm" rows="2"></textarea></td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>

                        </div>

                        <hr>

                        <div class="mt-3">
                            <label>Overall Progress</label>
                            <div class="progress" style="height:6px;">
                                <div id="progress_bar" class="progress-bar bg-success"></div>
                            </div>
                            <small id="progress_text"></small>
                        </div>

                        <hr>

                        <!-- <div class="mt-3">
                            <label>Remark / Notes</label>
                            <textarea id="remark" class="form-control" rows="2"></textarea>
                        </div> -->

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success btn-sm" id="saveStage">Save</button>
                        <button class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>



        <div class="row" id="details">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Received Order Status : <span id="indent_no"></span></h4>

                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-selected="true">
                                    <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                    <span class="hidden-xs-down">Indent Details</span>
                                </a>
                            </li>

                            <li class="nav-item" id="update-creation">
                                <a class="nav-link" data-toggle="tab" href="#profile6" role="tab" aria-selected="false">
                                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Update Creation</span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div class="tab-pane active" id="home7" role="tabpanel">
                                <div class="p-20 " style="line-height: 21px">
                                    <div class="row">

                                        <div class="col-md-2 fw-bold">Indent No</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="indent_number"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Date</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="date"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Plant Name</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="plant_name"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Customer Name</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="customer_name"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Qty.</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="qty"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Received Qty</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="received_qty"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Dimension</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="dimension"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Material</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="material"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Make</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="make"></span>
                                        </div>

                                        <div class="col-md-2 fw-bold">Remark</div>
                                        <div class="col-md-2">
                                            <span class="text-value" id="remark"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-20 openTabStage" id="profile6" role="tabpanel">

                                <form id="receiveOrderFormTab">
                                    <input type="hidden" id="tab_modal_order_id">
                                    <input type="hidden" id="tab_order_id">

                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">

                                            <thead>
                                                <tr>
                                                    <th>Status Stage</th>
                                                    <th>Design</th>
                                                    <th>Filament</th>
                                                    <th>Size Cutting</th>
                                                    <th>Flange Making</th>
                                                    <th>Pipe/Coupler Join</th>
                                                    <th>Finishing</th>
                                                    <th>Inspection</th>
                                                    <th>Packaging</th>
                                                    <th>Dispatch</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <!-- QTY -->
                                                <tr>
                                                    <td><b>Quantity</b></td>

                                                    <td><input type="number" id="tab_design" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_filament" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_size_cutting" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_flange_making" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_pipe_coupler_join" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_finishing" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_inspection" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_packaging" class="form-control stage-input-tab"></td>
                                                    <td><input type="number" id="tab_dispatch" class="form-control stage-input-tab"></td>
                                                </tr>

                                                <!-- REMARK -->
                                                <tr>
                                                    <td><b>Remark</b></td>

                                                    <td><textarea id="tab_remark_design" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_filament" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_size_cutting" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_flange_making" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_pipe_coupler_join" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_finishing" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_inspection" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_packaging" class="form-control"></textarea></td>
                                                    <td><textarea id="tab_remark_dispatch" class="form-control"></textarea></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- EXTRA -->
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label>Total Qty</label>
                                            <input type="number" id="tab_total_qty" class="form-control" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Created</label>
                                            <input type="number" id="tab_created_qty" class="form-control" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Remaining</label>
                                            <input type="number" id="tab_remaining_qty" class="form-control" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Tube OD * THK</label>
                                            <input type="text" id="tab_tube_od_thk" class="form-control">
                                        </div>
                                    </div>

                                    <!-- PROGRESS -->
                                    <div class="mt-3">
                                        <div class="progress" style="height:6px;">
                                            <div id="tab_progress_bar" class="progress-bar bg-success"></div>
                                        </div>
                                        <small id="tab_progress_text"></small>
                                    </div>

                                    <div class="text-right mt-3">
                                        <button type="button" id="saveStageTab" class="btn btn-success">
                                            Save
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/production/headerpipe_indent.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<script>
    let currentOrder = null;

    $(document).ready(function() {

        // OPEN MODAL
        $(document).on('click', '.openModal', function(e) {

            e.stopPropagation();
            currentOrder = getOrderData($(this));
            fillModalHeader(currentOrder);
            $('#exampleModalCenter').modal('show');
            loadStageData(currentOrder.id);
        });


        // ROW CLICK → TAB
        $(document).on('click', '.clickableRow', function(e) {

            if ($(e.target).closest('.openModal').length) return;
            currentOrder = getOrderData($(this));
            $('a[href="#profile6"]').tab('show');
            loadStageDataIntoTab(currentOrder);
        });

        $(document).on('input', '.stage-input', function() {
            validateStageInputs('');
        });

        $(document).on('input', '.stage-input-tab', function() {
            validateStageInputs('tab_');
        });

        function validateStageInputs(type = '') {
            let total = parseInt($('#' + type + 'remaining_qty').val()) || 0;

            let ids = [
                'design',
                'filament',
                'size_cutting',
                'flange_making',
                'pipe_coupler_join',
                'finishing',
                'inspection',
                'packaging',
                'dispatch'
            ];

            let sum = 0;
            let isValid = true;

            ids.forEach(function(id) {
                let input = $('#' + type + id);
                let val = parseInt(input.val()) || 0;

                if (val < 0) {
                    val = 0;
                    input.val(0);
                }

                sum += val;
            });

            if (sum > total) {

                let currentInput = $(document.activeElement);

                currentInput.val(0);

                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Exceeded',
                    text: 'Total stages qty cannot exceed Remaining Qty (' + total + ')'
                });

                return false;
            }
            let design = parseInt($('#' + type + 'design').val()) || 0;

            $('#' + type + 'created_qty').val(design);
            $('#' + type + 'remaining_qty').val(total);

            if (type == '') {
                updateProgress();
            } else {
                updateTabProgress();
            }
            return true;
        }


        // SAVE MODAL
        $('#saveStage').on('click', function() {

            if (!validateStageInputs('')) return;

            let data = getFRPHPipeStageData('');

            console.log(data);

            $.ajax({
                url: base_url + 'admin/production/Indent/updateFRPHPipeStageData',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(res) {
                    console.log(res);

                    Swal.fire('Saved', 'Stage updated successfully', 'success');

                    $('#exampleModalCenter').modal('hide');
                    $('#receivedOrders').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    Swal.fire('Error', 'Stage data not saved. Check console.', 'error');
                }
            });
        });


        // SAVE TAB
        $('#saveStageTab').on('click', function() {

            if (!validateStageInputs('tab_')) return;

            let data = getFRPHPipeStageData('tab_');

            console.log(data);

            $.ajax({
                url: base_url + 'admin/production/Indent/updateFRPHPipeStageData',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(res) {
                    console.log(res);

                    Swal.fire('Saved', 'Stage updated successfully', 'success');

                    $('#receivedOrders').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    Swal.fire('Error', 'Stage data not saved. Check console.', 'error');
                }
            });
        });


        // TAB SWITCH LOAD
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

            let target = $(e.target).attr("href");

            if (target === '#profile6') {

                if (!currentOrder) {
                    alert("Please select row first");
                    return;
                }

                loadStageDataIntoTab(currentOrder);
            }
        });

    });


    function getOrderData(el) {
        return {
            id: el.data('id'),
            indent: el.data('indent'),
            manual: el.data('manual'),
            company: el.data('company'),
            total: el.data('total'),
            order_qty: el.data('order-qty')
        };
    }

    function fillModalHeader(order) {
        $('#modal_order_id, #order_id').val(order.id);
        $('#indent_no').val(order.indent);
        $('#manual_no').val(order.manual);
        $('#company').val(order.company);
        $('#total_qty').val(order.total);
        $('#remaining_qty').val(order.order_qty);
    }

    function loadStageData(order_id) {

        $.post(base_url + 'admin/production/Indent/getFRPHPipeStageData', {
            order_id
        }, function(res) {

            let stages = res.stages || {};

            resetAll();

            setStageValues(stages, '');
            setStageValues(stages, 'tab_');

            $('#tube_od_thk, #tab_tube_od_thk').val(res.tube_od_thk);

            let total = getVal('#total_qty');
            let design = stages[1]?.qty || 0;

            $('#created_qty, #tab_created_qty').val(design);

            $('#remaining_qty').val(order_qty);

            $('#tab_remaining_qty').val(order_qty);
            updateProgress();
            updateTabProgress();

        }, 'json');
    }

    function loadStageDataIntoTab(order) {

        $('#tab_modal_order_id, #tab_order_id').val(order.id);
        $('#tab_total_qty').val(order.total);
        $('#tab_remaining_qty').val(order.order_qty);

        loadStageData(order.id);
    }


    function getFRPHPipeStageData(prefix) {

        return {
            order_id: $('#' + prefix + 'modal_order_id').val(),
            tube_od_thk: $('#' + prefix + 'tube_od_thk').val(),

            design: $('#' + prefix + 'design').val(),
            filament: $('#' + prefix + 'filament').val(),
            size_cutting: $('#' + prefix + 'size_cutting').val(),
            flange_making: $('#' + prefix + 'flange_making').val(),
            pipe_coupler_join: $('#' + prefix + 'pipe_coupler_join').val(),
            finishing: $('#' + prefix + 'finishing').val(),
            inspection: $('#' + prefix + 'inspection').val(),
            packaging: $('#' + prefix + 'packaging').val(),
            dispatch: $('#' + prefix + 'dispatch').val(),

            remark_design: $('#' + prefix + 'remark_design').val(),
            remark_filament: $('#' + prefix + 'remark_filament').val(),
            remark_size_cutting: $('#' + prefix + 'remark_size_cutting').val(),
            remark_flange_making: $('#' + prefix + 'remark_flange_making').val(),
            remark_pipe_coupler_join: $('#' + prefix + 'remark_pipe_coupler_join').val(),
            remark_finishing: $('#' + prefix + 'remark_finishing').val(),
            remark_inspection: $('#' + prefix + 'remark_inspection').val(),
            remark_packaging: $('#' + prefix + 'remark_packaging').val(),
            remark_dispatch: $('#' + prefix + 'remark_dispatch').val()
        };
    }


    function setStageValues(stages, prefix) {

        let map = ['design', 'filament', 'size_cutting', 'flange_making', 'pipe_coupler_join', 'finishing', 'inspection', 'packaging', 'dispatch'];

        for (let i = 1; i <= 8; i++) {
            if (stages[i]) {
                $('#' + prefix + map[i - 1]).val(stages[i].qty);
                $('#' + prefix + 'remark_' + map[i - 1]).val(stages[i].remark);
            }
        }
    }


    function updateProgress() {

        let total = getVal('#total_qty');

        let sum =
            getVal('#design') +
            getVal('#filament') +
            getVal('#size_cutting') +
            getVal('#flange_making') +
            getVal('#pipe_coupler_join') +
            getVal('#finishing') +
            getVal('#inspection') +
            getVal('#packaging') +
            getVal('#dispatch');

        let percent = total ? (sum / total) * 100 : 0;

        $('#progress_bar').css('width', percent + '%');
        $('#progress_text').text(sum + " / " + total + " Used");
    }

    function updateTabProgress() {

        let total = getVal('#tab_total_qty');

        let sum =
            getVal('#tab_design') +
            getVal('#tab_filament') +
            getVal('#tab_size_cutting') +
            getVal('#tab_flange_making') +
            getVal('#tab_pipe_coupler_join') +
            getVal('#tab_finishing') +
            getVal('#tab_inspection') +
            getVal('#tab_packaging') +
            getVal('#tab_dispatch');

        let percent = total ? (sum / total) * 100 : 0;

        $('#tab_progress_bar').css('width', percent + '%');
        $('#tab_progress_text').text(sum + " / " + total + " Used");
    }



    function getVal(id) {
        return parseInt($(id).val()) || 0;
    }

    function resetAll() {
        $('.stage-input, .stage-input-tab').val(0);
        $('textarea').val('');
    }
</script>