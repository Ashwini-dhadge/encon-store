<?php init_header(); ?>
<link href="<?= base_url(); ?>assets/css/pages/tab-page.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/node_modules/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<style>
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
                        <?php $this->load->view(ADMIN . 'BalajiPlantDashboard/tbl_BalajiPlant'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="details">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Order status: <span id="indent_no"></span></h4>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Indent Details</span></a> </li>
                            <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile6" role="tab"
                                    aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Add Creation</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"
                                    aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Creation Status</span></a> </li> -->
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span>
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
                                            <label class="lbl_class"><span>IND001</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Date</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>2024-06-28</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Plant Name</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>Client A</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Customer Name</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>Client A</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Blade Qty.</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class">90</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Received Qty</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class">90</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Mould Size</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>2750 MM</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Blade Size (mm)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>8</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Blade Punching Number</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>123</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">A.Tip (mm)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>25mm</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Color</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>Blue</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class font-weight-bold">Name Plate</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="lbl_class"><span>150mm</span></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20" id="profile6" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">

                                            <div class="col-md-2 form-group">
                                                <label for="transfer-to"><b>Select Creation Stage</b></label>
                                                <select id="select_stage" class="form-control custom-select stage">
                                                    <option value="" disabled selected>Select Stage</option>
                                                    <option value="Created">Created</option>
                                                    <option value="Hand">Blade in Hand</option>
                                                    <option value="Position">Blade Position</option>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-2 create">
                                                <label class="lbl_class "><b>Created</b></label>
                                                <input type="text" class="form-control " placeholder=" " name="created">

                                            </div>
                                            <div class="form-group col-md-2 hand">
                                                <label class="lbl_class"><b>Blade in Hand</b></label>
                                                <input type="text" class="form-control " placeholder="" name="blande_in_hand">

                                            </div>
                                            <!-- <div class="form-group col-md-2 position">
                                                <label class="lbl_class"><b>Blade Position</b></label>
                                                <input type="text" class="form-control " placeholder="" name="blande_in_position">

                                            </div> -->
                                            <div class="form-group col-md-2 added_by">
                                                <label class="lbl_class"><b>Added By</b></label>
                                                <select id="added_by" class="form-control custom-select stage">
                                                    <option value="" disabled selected>Select </option>
                                                    <option value="Samarth">Samarth</option>
                                                    <option value="Shubham">Shubham</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 remark">
                                                <label for="additional-notes"><b>Remark</b></label>
                                                <textarea class="form-control" rows="3" id="remark" placeholder="Enter any additional notes here"></textarea>
                                            </div>



                                        </div>

                                    </div>

                                </div>
                                <div class="d-flex justify-content-center mt-2">
                                    <button type="submit" class="btn btn-success btn-theme"> Submit</button>
                                </div>
                            </div>
                            <div class="tab-pane p-20 " id="profile7" role="tabpanel">
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="lbl_class"><b>Created</b></label>
                                                <input type="text" class="form-control" placeholder="Created Status"
                                                    value="50">

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="lbl_class"><b>Blade in Hand</b></label>
                                                <input type="text" class="form-control" placeholder="50 units"
                                                    value="30">

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="lbl_class"><b>Blade Position</b></label>
                                                <input type="text" class="form-control" placeholder="Assembly Line 3"
                                                    value="10">

                                            </div>
                                        </div>

                                    </div>
                                </div> -->
                                <div class="card card-timeline px-2 border-none ">
                                    <ul class="bs4-order-tracking d-flex justify-content-center">
                                        <li class="step active" id="created-stage">
                                            <div><i class="fas fa-user"></i></div> Created(50)
                                        </li>
                                        <li class="step active" id="blade-in-hand-stage">
                                            <div><i class="fas fa-bread-slice"></i></div> Blade in Hand(40)
                                        </li>
                                        <!-- <li class="step active">
                                            <div><i class="fas fa-truck"></i></div> Blade Position(30)
                                        </li> -->

                                    </ul>
                                    <!-- <a class="mytooltip text-center" href="javascript:void(0)"><i class="fas fa-info-circle"></i>
                                        <span class="tooltip-content5">
                                            <span class="tooltip-text3">
                                                <span class="tooltip-inner2">In Blade Position Add 30 Blade</span>
                                            </span>
                                        </span>


                                    </a> -->


                                    <!-- <span class="text-center"><b>In transit</b>. The order has been Created!</span> -->
                                </div>
                            </div>

                            <div class="tab-pane p-20" id="messages7" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="created-status"><b>Total Received Qty Blade</b></label>
                                            <input type="text" class="form-control" id="created-status" value="90">
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="transfer-to"><b>Transfer to</b></label>
                                            <select id="transfer-to" class="form-control custom-select">
                                                <option value="" disabled selected>Select Plant</option>
                                             
                                                <option value="Encon India"selected>Encon India</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="transfer-to"><b>Transfer by</b></label>
                                            <select id="transfer-by" class="form-control custom-select">
                                                <option value="" disabled selected>Select</option>
                                                <option value="Samarth">Samarth</option>
                                                <option value="Shubham">Shubham</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group mt-4 text-center">
                                    <button type="button" id="transfer-button" class="btn btn-success text-center">Transfer</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php init_footer(); ?>
    <script src="<?= base_url(); ?>assets/js/page-js/production/balajiPlant.js"></script>
    <script src="<?= base_url(); ?>assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>