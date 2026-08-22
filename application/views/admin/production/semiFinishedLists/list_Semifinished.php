<?php init_header(); ?>
<link href="<?= base_url(); ?>assets/css/pages/tab-page.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<style>
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
    color: #dc3545
}

.bs4-order-tracking li.active>div {
    background: #dc3545
}

.bs4-order-tracking li.active:after {
    background: #dc3545
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
                        <?php $this->load->view(ADMIN . 'production/semiFinishedLists/tbl_Semifinished'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="details">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">SemiFinished Product status : <span id="indent_no"></span></h4>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"
                                    aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">Order Details</span></a> </li>
                            <li class="nav-item" id="update-creation"> <a class="nav-link" data-toggle="tab"
                                    href="#profile6" role="tab" aria-selected="false"><span class="hidden-sm-up"><i
                                            class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Update Creation</span></a> </li>
                            <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"
                                    aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Order Status</span></a> </li> -->
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab"
                                    aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                    <span class="hidden-xs-down">Dispatch Status</span></a> </li>
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
                                <form action="" id="semifinishedOrderForm">
                                    <input type="hidden" name="order_id" id="order_id">
                                    <input type="hidden" name="transfer_qty" id="transfer_qty_hidden">
                                    <input type="hidden" name="dispatch_qty" id="dispatch_qty_hidden">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Status Stage</th>
                                                        <th>Gap Checking</th>
                                                        <th>Primer</th>
                                                        <th>Filler</th>
                                                        <th>Putty</th>
                                                        <th>TOP Coat</th>
                                                        <th>Balancing</th>
                                                        <th>Packing</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">Quantity</td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=" "
                                                                name="gap_checking_qty" id="gap_checking_qty">
                                                            <input type="hidden" class="form-control" placeholder=" "
                                                                name="gapCheckingStatus" value="4">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="primer_qty" id="primer_qty">
                                                            <input type="hidden" class="form-control" placeholder=""
                                                                name="primerStatus" value="5">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="filler_qty" id="filler_qty">
                                                            <input type="hidden" class="form-control" placeholder=""
                                                                name="fillerStatus" value="6">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="putty_qty" id="putty_qty">
                                                            <input type="hidden" class="form-control" placeholder=""
                                                                name="puttyStatus" value="7">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="top_coat_qty" id="top_coat_qty">
                                                            <input type="hidden" class="form-control" placeholder=""
                                                                name="topCoatStatus" value="8">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="balancing_qty" id="balancing_qty">
                                                            <input type="hidden" class="form-control" placeholder=""
                                                                name="balancingStatus" value="9">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="packing_qty" id="packing_qty">
                                                            <input type="hidden" class="form-control" placeholder=""
                                                                name="packingStatus" value="10">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">Remark</td>
                                                        <td>
                                                            <textarea class="form-control" rows="3"
                                                                name="gap_checking_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="3" name="primer_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="3" name="filler_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="3" name="putty_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="3"
                                                                name="top_coat_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="3"
                                                                name="balancing_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="3"
                                                                name="packing_remark"
                                                                placeholder="Enter any additional notes here"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="col-md-1"></div>

                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" class="btn btn-success btn-theme"
                                            id="semifinishedOrderForm"> Submit</button>
                                    </div>
                                </form>
                            </div>

                            <!-- <div class="tab-pane p-20 " id="profile7" role="tabpanel">

                                <div class="card card-timeline px-2 border-none ">
                                    <ul class="bs4-order-tracking d-flex justify-content-center">
                                        
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> Gap Checking(1)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> Primer(2)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> Filler(0)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> Putty(0)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> TOP Coat(3)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> Balancing(2)
                                        </li>
                                        <li class="step active">
                                            <div><i class="fas fa-user"></i></div> Packing(1)
                                        </li>
                                    </ul>

                                    <a class="mytooltip text-center" href="javascript:void(0)"><i
                                            class="fas fa-info-circle"></i>
                                        <span class="tooltip-content5">
                                            <span class="tooltip-text3">
                                                <span class="tooltip-inner2">Blade Packed To Dispatched</span>
                                            </span>
                                        </span>


                                    </a>


                                
                                </div>
                            </div> -->

                            <div class="tab-pane p-20" id="messages7" role="tabpanel">
                                <form action="" id="dispatchForm">
                                    <input type="hidden" name="order_id" id="order_id_dispatch">
                                    <input type="hidden" name="packingQty" id="packing_hidden">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="created-status"><b>Dispatch QTY</b></label>
                                                <input type="text" class="form-control" id="" value=""
                                                    name="dispatch_qty">
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="transfer-to"><b>Dispatch to</b></label>
                                                <select id="transfer-to" class="form-control custom-select"
                                                    name="status">
                                                    <option value="12">Balaji Plant</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="transfer-to"><b>Dispatch by</b></label>
                                                <select id="transfer-by" class="form-control custom-select">
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Samarth">Samarth</option>
                                                    <option value="Shubham">Shubhah</option>
                                                </select>
                                            </div>

                                        </div>
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
    <script src="<?= base_url(); ?>assets/js/page-js/production/semifishedLists.js"></script>
    <script src="<?= base_url(); ?>assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>