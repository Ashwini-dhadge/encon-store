<?php init_header(); ?>
<link href="<?= base_url(); ?>assets/css/pages/tab-page.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">
<style>
/* #receiveOrderForm, table {
  border: 1px solid black;
  border-collapse: collapse;
} */
table,
th,
td,
tr {
    border: 3px solid #f3f1f1;
    border-collapse: collapse;
}

table th {
    text-align: center;
}

.plus-icon:hover {
    cursor: pointer;
}

.bs4-order-tracking {
    margin-bottom: 30px;
    overflow: hidden;
    color: #878788;
    padding-left: 0px;
    margin-top: 30px
}

.bs4-order-tracking li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
    color: #878788;
    text-align: center
}

.bs4-order-tracking li:first-child:before {
    margin-left: 15px !important;
    padding-left: 11px !important;
    text-align: left !important
}

.bs4-order-tracking li:last-child:before {
    margin-right: 5px !important;
    padding-right: 11px !important;
    text-align: right !important
}

.bs4-order-tracking li>div {
    color: #fff;
    width: 29px;
    text-align: center;
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: #878788;
    border-radius: 50%;
    margin: auto
}

.bs4-order-tracking li:after {
    content: '';
    width: 150%;
    height: 2px;
    background: #878788;
    position: absolute;
    left: 0%;
    right: 0%;
    top: 15px;
    z-index: -1
}

.bs4-order-tracking li:first-child:after {
    left: 50%
}

.bs4-order-tracking li:last-child:after {
    left: 0% !important;
    width: 0% !important
}

.bs4-order-tracking li.active {
    font-weight: bold;
    color: black;
}

.bs4-order-tracking li.active>div {
    background: #28a745
}

.bs4-order-tracking li.active:after {
    background: #28a745
}

.card-timeline {
    background-color: #fff;
    z-index: 0
}

.nav-tabs .nav-link.active {
    color: white;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;

}

.customtab2 li a.nav-link.active {
    background: #20aee3;
    color: #ffffff !important;
}

.customtab2 li a.nav-link:hover {
    color: #ffffff !important;
    background: #20aee3;
}

.tooltip-inner2 {
    font-size: 15px;
}

.label.custome-received {
    background-color: #1C819E;
    color: white;
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
                        <?php $this->load->view(ADMIN . 'production/receivedOrders/tbl_Received_Orders'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="details">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Received Order Status : <span id="indent_no"></span></h4>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"
                                    aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">Indent Details</span></a> </li>
                            <li class="nav-item" id="update-creation"> <a class="nav-link" data-toggle="tab"
                                    href="#profile6" role="tab" aria-selected="false"><span class="hidden-sm-up"><i
                                            class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Update Creation</span></a> </li>
                            <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"
                                    aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Order Status</span></a> </li> -->
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab"
                                    aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                    <span class="hidden-xs-down">Transferred Status</span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="home7" role="tabpanel">
                                <div class="p-20">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Indent No</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="indet_no"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Date</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="date"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Plant Name</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="plant_names"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Customer Name</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="customer_names"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Blade Qty.</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class " id="blade_qtys"></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Received Qty</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class" id="received_qtys"></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Mould Size</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class "><span id="mould_sizes"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Blade Size (mm)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="blade_sizes"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Blade Punching Number</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="punching_nos"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">A.Tip (mm)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="atips"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Color</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="colors"></span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Name Plate</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span id="name_plates"></span></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20" id="profile6" role="tabpanel">
                                <form action="" id="receiveOrderForm">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <table class="table">
                                                <div class="form-row">
                                                    <input type="hidden" name="order_id" id="order_id">
                                                    <!-- <input type="hidden" name="blade_qty" id="blade_qty_hidden">-->

                                                    <input type="hidden" name="order_qty" id="order_qty_hidden">
                                                    <!-- <input type="hidden" name="create_qty" id="created_qty_hidden">  -->
                                                    <!-- <div class="col-md-2 form-group">
                                                    <label for="transfer-to"><b>Select Creation Stage</b></label>
                                                    <select id="select_stage" class="form-control custom-select stage"
                                                        name="status_id" required>
                                                        <option value="" disabled selected>Select Stage</option>
                                                        <option value="1">Created</option>
                                                        <option value="2">Blade in Hand</option>
                                                        <option value="3">Blade Position</option>
                                                    </select>
                                                </div> -->



                                                    <thead>
                                                        <tr>
                                                            <th>Status Stage</th>
                                                            <th>Created</th>
                                                            <th>Blade in Hand</th>
                                                            <!-- <th>Blade Position</th> -->

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">Quantity</td>
                                                            <td>
                                                                <input type="text" class="form-control" placeholder=" "
                                                                    name="created_qty" id="createQty">
                                                                <input type="hidden" class="form-control"
                                                                    placeholder=" " name="created_status" id=""
                                                                    value="1">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="blade_in_hand_qty" id="blade_in_hand">
                                                                <input type="hidden" class="form-control" placeholder=""
                                                                    name="blade_in_hand_status" id="" value="2">
                                                            </td>
                                                            <!-- <td>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="blade_position_qty" id="blade_position">
                                                                <input type="hidden" class="form-control" placeholder=""
                                                                    name="blade_position_status" id="" value="3">
                                                            </td> -->
                                                            <!-- <td>
                                                                <select id="added_by"
                                                                    class="form-control custom-select stage">
                                                                    <option value="" disabled selected>Select</option>
                                                                    <option value="Samarth">Samarth</option>
                                                                    <option value="Shubham">Shubham</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" rows="3" id="remark"
                                                                    placeholder="Enter any additional notes here"></textarea>
                                                            </td> -->
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Remark</td>
                                                            <td>
                                                                <textarea class="form-control" rows="3"
                                                                    name="createQtyRemark"
                                                                    placeholder="Enter any additional notes here"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" rows="3"
                                                                    name="bladeHandRemark"
                                                                    placeholder="Enter any additional notes here"></textarea>
                                                            </td>
                                                            <!-- <td>
                                                                <textarea class="form-control" rows="3"
                                                                    name="bladePositionRemark"
                                                                    placeholder="Enter any additional notes here"></textarea>
                                                            </td> -->
                                                        </tr>
                                                    </tbody>
                                                </div>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" class="btn btn-success btn-theme" id=""> Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- <div class="tab-pane p-20 " id="profile7" role="tabpanel">
                                

                                <div class="card card-timeline px-2 border-none ">
                                    <ul class="bs4-order-tracking d-flex justify-content-center">
                                        <li class="step active" id="created-stage">
                                            <div><i class="fas fa-calendar-check"></i></div> Created(50)
                                        </li>
                                        <li class="step active" id="blade-in-hand-stage">
                                            <div><i class="fas fa-tools"></i></div> Blade in Hand(40)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-cogs"></i></div> Blade Position(30)
                                        </li>

                                    </ul>
                                    <a class="mytooltip text-center" href="javascript:void(0)"><i
                                            class="fas fa-info-circle"></i>
                                        <span class="tooltip-content5">
                                            <span class="tooltip-text3">
                                                <span class="tooltip-inner2">In Blade Position Add 30 Blade</span>
                                            </span>
                                        </span>


                                    </a>


                                    
                                </div>

                          
                            </div> -->

                            <div class="tab-pane p-20" id="messages7" role="tabpanel">
                                <form action="" id="tansferForm">
                                    <input type="hidden" name="order_id" id="order_id_transfer">
                                    <!-- <input type="hidden" name="blade_position_qty" id="blade_position_hidden"> -->
                                    <input type="hidden" name="receivedqty" id="received_qty_hidden">
                                    <input type="hidden" name="transferqty" id="transfer_qty_hidden">
                                    <input type="hidden" name="indent_transfer_qty" id="indent_transfer_qty">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="created-status"><b>Total Received Qty Blade</b></label>
                                                <input type="text" class="form-control" id="transfer_qty" value=""
                                                    name="transfer_qty" readonly>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="transfer-to"><b>Transfer to</b></label>
                                                <select id="transfer-to" class="form-control" name="status">

                                                    <option value="14">Balaji Plant</option>

                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="transfer-by"><b>Transfer by</b></label>
                                                <select id="transfer-by" class="form-control custom-select">
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Samarth">Samarth</option>
                                                    <option value="Shubham">Shubham</option>
                                                </select>
                                            </div>

                                        </div> -->
                                    </div>

                                    <div class="form-group mt-4 text-center">
                                        <button type="submit" id="transfer-button"
                                            class="btn btn-success text-center">Transfer</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="transferQtyModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="_banner2"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="interChangeQtyModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">InterChange Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="_banner3"></div>
                </div>
            </div>
        </div>
    </div>
    <?php init_footer(); ?>
    <script src="<?= base_url(); ?>assets/js/page-js/production/received_orders.js"></script>
    <script src="<?= base_url(); ?>assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>
    <script src="<?= base_url(); ?>assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>
    <script>
    // $('#receiveOrderForm').validate();
    </script>