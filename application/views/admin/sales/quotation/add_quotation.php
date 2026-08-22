<?php init_header(); ?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">

<style>
    body {
    font-family: "Lato Regular", sans-serif;
    }
    .form-group {
    min-height: 28px;
    font-size: 14px;
    }
    .form-control {
    font-size: 0.8rem;
    }
    label{
    margin-bottom: 0.2rem;
    }
    textarea{
    height:-2px !important;
    }
    /*label.error{
    display: none !important;
    }*/
    .error{
    color:red;
    }
    .sd{
    display: none;
    }
    hr {
    margin-top: 0.5rem;
    }
    /*  .text_area{
    margin-top: -4px !important;
    line-height: 2 !important;
    } */

    .margin-bottom-7{
    margin-bottom:10px !important;
    }
    .select2-container{
    margin-bottom: 7px !important;
    }
    .upper_case
    {
    text-transform: uppercase;
    }
    .select2-selection{
    height: 28px !important;
    }


    .ck.ck-content.ck-editor__editable {
    height: 200px;
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
        <form action="<?= base_url();?>admin/sales/quotation/add_quotation" enctype="multipart/form-data" method="post" id="frm" autocomplete="off">

                <div class="card float-left col-lg-12 mb-5">
                    <div class="card-body">
                        <div class="col-md-12 float-left">
                            <div class="col-md-12">
                                <span class="text-color"><h6><b><?= $title ?></b></h6></span><hr> 
                            </div>
                            <!-- amendment_main_quotation_id -->
                            <!-- amendment_sequences -->
                            <?php  //print_r($amendment_main_quotation_id); ?>
                            
                            <input type="hidden" name="quotation_id" class="form-control" value="<?= isset($quotationData[0]['id']) ? $quotationData[0]['id'] : '' ?>" >

                            <?php 
                                if(isset($amendment_main_quotation_id) && $amendment_main_quotation_id != 0) {
                            ?>
                               
                                <input type="hidden" name="type" class="form-control" value=<?= $type ?> >
                                <input type="hidden" name="amendment_main_quotation_id" class="form-control" value="<?= $amendment_main_quotation_id ?>" >
                                <input type="hidden" name="amendment_sequences" class="form-control" value="<?= $amendment_sequences ?>" >
                            <?php } ?>


                            <div class="col-md-6 float-left border-right">
                                <?php if(isset($quotationData[0]['order_no'])) { 
                                    if(isset($amendment_main_quotation_id) && $amendment_main_quotation_id != 0) {
                                        $order_no = $amen_order_no;   
                                    } else {
                                        $order_no = $quotationData[0]['order_no'];
                                    } 
                                ?>
                                <input type="hidden" name="order_no" class="form-control" value="<?= $order_no ?>" >
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Quotation No</label>
                                    <input type="text" name="quotation_no" class="form-control" value="<?= $order_no ?>" readonly >
                                </div>
                                <?php } ?>

                                <div class="col-md-12 float-left p-0">

                                    <div class="form-group col-md-6 float-left">
                                        <label class="control-label">Company Name</label>
                                        <div class="input-group">
                                            <select class="form-control" name="company_id" id="companyName" required>
                                                <?php 
                                                    if(isset($quotationData[0]['company_id']))
                                                    {
                                                ?>
                                                    <option value="<?= isset($quotationData[0]['company_id']) ? $quotationData[0]['company_id'] : '' ?>"><?= isset($quotationData[0]['company_id']) ? $companyData[0]['name'] : '' ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div>

                                    <div class="form-group col-md-6 float-left">
                                        <label class="control-label">Customer Name</label>
                                        <div class="input-group">
                                            <select class="form-control" name="customer_id" id="customerName" required>

                                            <?php
                                                if(isset($quotationData[0]['customer_id']))
                                                {
                                            ?>
                                            
                                                <option value="<?= isset($quotationData[0]['customer_id']) ? $quotationData[0]['customer_id'] : '' ?>"><?= isset($quotationData[0]['customer_id']) ? $customerData[0]['contact_person_name'] : '' ?></option>
                                                   
                                                
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div>
                                </div>


                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Subject</label>
                                    <input type="text" class="form-control" value="<?= (isset($quotationData[0]['subject']))? $quotationData[0]['subject'] : '' ?>" name="subject" id="" required>
                                </div>

                                <div class="form-group col-md-12 float-left">
                                    <div class="input-group">
                                        <div class="col-md-6 float-left pl-0">
                                            <label class="control-label"><b>Technical Specification</b></label>
                                        </div>

                                        <div class="col-md-6 float-left text-right">
                                            <div class="input-group-prepend float-right">
                                                <a href="javascript:void(0)" onclick="getTechnicalSpecifications()" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size:12px;background:#F0F0F0;color: gray;"><i class="fas fa-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div> 
                                    </div>
                                    

                                    

                                    <div id="techSpecificationDiv">
                                        <?php 
                                            if(isset($quotationTechnicalSpecificationData) && count($quotationTechnicalSpecificationData) > 0) {
                                                foreach($quotationTechnicalSpecificationData as $techSpec) {
                                        ?>
                                        <div class="input-group mt-2">
                                            <input type="hidden" name="tech_specificationId[<?= $techSpec['master_technical_id'] ?>]" value="<?= $techSpec['cqts_id']; ?>" />
                                            <div class="col-md-3">
                                                <label class="control-label"><?= $techSpec['technical_title'] ?></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" required value="<?= $techSpec['technical_description'] ?>" name="techSpecification[<?= $techSpec['master_technical_id'] ?>]" id="" >
                                            </div>
                                            <div class="input-group-prepend">
                                                <a class="remove_techSpeci btn btn-primary btn-sm text-danger"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </div>


                                    
                                </div>
                            </div>

                            <div class="col-md-6 float-left">
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Referance</label>
                                    <input type="text" value="<?= (isset($quotationData[0]['referance']))? $quotationData[0]['referance'] : '' ?>" class="form-control" name="referance" id="">
                                </div>

                                <div class="form-group col-md-6 float-left">
                                    <label class="control-label">Estimated Date</label>
                                    <div class="input-group">
                                        <input type="date" value="<?= (isset($quotationData[0]['estimated_date']))? $quotationData[0]['estimated_date'] : '' ?>" class="form-control" name="estimated_date">
                                        <!-- <div class="input-group-prepend">
                                            <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size:12px;background:#F0F0F0;color: gray;"><i class="fas fa-calendar" aria-hidden="true"></i></a>
                                        </div> -->
                                    </div> 
                                </div>

                                <div class="form-group col-md-6 float-left">
                                    <label class="control-label">Expiry Date</label>
                                    <div class="input-group">
                                        <input type="date" value="<?= (isset($quotationData[0]['expiry_date']))? $quotationData[0]['expiry_date'] : '' ?>" class="form-control" name="expiry_date">
                                        <!-- <div class="input-group-prepend">
                                            <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size:12px;background:#F0F0F0;color: gray;"><i class="fas fa-calendar" aria-hidden="true"></i></a>
                                        </div> -->
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-6 float-left repeater1">
                                <div class="form-group col-md-12 float-left">
                                    <div class="col-lg-12 p-0 mb-1 float-left" data-repeater-list="group-b">
                                        <label class="control-label">ROI</label>
                                        <a data-repeater-create href="javascript:void(0)" class="btn btn-primary waves-effect waves-light btn-sm float-right" style="font-size: 12px; background: #F0F0F0; color: gray;"><i class="fas fa-plus" aria-hidden="true"></i></a>

                                        <!-- quotationRoiData -->

                                        <?php 
                                            if(isset($quotationRoiData) && count($quotationRoiData) > 0) {
                                                foreach($quotationRoiData as $roi) {
                                        ?>
                                            <div class="input-group mb-1 mt-1 float-left" data-repeater-item>
                                                <div class="col-lg-9 p-0 mr-2">
                                                <input type="hidden" class="form-control col-lg-12 " name="roi_id" value="<?= $roi['id'] ?>">

                                                    <input type="text" class="form-control col-lg-12 " name="roi_title" value="<?= $roi['roi_title'] ?>" placeholder="ROI Title">
                                                </div>

                                                <div class="col-lg-2 p-0 mr-2 float-left">
                                                    <input type="text" class="form-control col-lg-12 mr-1 float-left" name="roi_amount" value="<?= $roi['roi_amount'] ?>" placeholder="ROI Amount">
                                                    
                                                </div>

                                                <div class="input-group-prepend float-right">
                                                    <a data-repeater-delete class="btn btn-primary btn-sm text-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            
                                            </div>
                                        <?php
                                                }
                                            } else {
                                        ?>
                                            <div class="input-group mb-1 mt-1 float-left" data-repeater-item>
                                                <div class="col-lg-9 p-0 mr-2">
                                                    <input type="text" class="form-control col-lg-12 " name="roi_title" placeholder="ROI Title">
                                                </div>

                                                <div class="col-lg-2 p-0 mr-2 float-left">
                                                    <input type="text" class="form-control col-lg-12 mr-1 float-left" name="roi_amount" placeholder="ROI Amount">
                                                    
                                                </div>

                                                <div class="input-group-prepend float-right">
                                                    <a data-repeater-delete class="btn btn-primary btn-sm text-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            
                                            </div>
                                        <?php } ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 float-left">
                                <hr>
                            </div>
                            

                            <div class="col-md-6 float-left">
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Message</label>
                                    <div class="input-group">
                                        <div class="editor-container col-md-12 p-0">
                                            <textarea name="commercial" class="editor" required>
                                                <?= (isset($quotationData[0]['commercial']))? $quotationData[0]['commercial'] : '' ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 float-left">
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">ROI Description</label>
                                    <div class="input-group">
                                        <div class="editor-container col-md-12 p-0">
                                            <textarea name="roiDescription" class="roiDescriptionEditor" required>
                                                <?= (isset($quotationData[0]['roiDescription']))? $quotationData[0]['roiDescription'] : '' ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div>
                </div>


                <hr>


                <div class="card float-left col-lg-12 mb-5">
                    <div class="card-body">
                        <div class="col-md-12 float-left repeater">

                            <div class="col-lg-12 float-left mt-3" class="">
                                <table class="table table-bordered table-hover table no-wrap invoiceTable" style="background:#eff1f3">
                                    <input data-repeater-create type="button" class="btn btn-primary float-right text-primary add_item" value="Add Item"/>
                                    <thead>
                                        <tr>
                                            <!-- <th><b>Item</b></th> -->
                                            <th width="150"><b>Description</b></th>
                                            <th width="150"><b>Quantity</b></th>
                                            <th width="150"><b>Rate</b></th>
                                            <th width="150"><b>Tax</b></th>
                                            <th width="150"><b>Amount</b></th>
                                            <th width="2"></th>

                                        </tr>
                                    </thead>
                                    <tbody data-repeater-list="group-a">

                                            <?php 
                                                
                                                if(isset($quotationItemData) && count($quotationItemData) > 0) {
                                                    //echo "<pre>";
                                                    //print_r($quotationItemData);
                                                    $q_i = 1;
                                                    foreach($quotationItemData as $item) {
                                                    
                                            ?>

                                            <tr data-repeater-item class="repeater-group">
                                            <!--<td><textarea class="form-control" rows="3" name="item_name" placeholder="Item Name"></textarea></td> -->
                                                <!-- <td><textarea class="form-control" rows="3" name="description" placeholder="Description"></textarea></td> -->
                                                <input type="hidden" name="quotationItemData_id" value="<?= $item['item_id']; ?>" />
                                                <input type="hidden" name="quotationItemDetailsData_id" value="<?= $item['id']; ?>" />

                                                <td width="150">
                                                    <div class="editor-container col-md-12 p-0" style="width: 1000px !important;">
                                                        <textarea name="description" class="item_description_editor1<?= $q_i ?>">
                                                            <?= $item['item_description'] ?>
                                                        </textarea>
                                                    </div>
                                                </td>
                                                <td><input type="text" class="form-control text-center" value="<?= $item['item_qty'] ?>" onkeyup="calculateCost()" name="quantity" placeholder="Qty"></td>
                                                <td><input type="text" class="form-control text-center" value="<?= $item['item_rate'] ?>" onkeyup="calculateCost()" name="rate" placeholder="Rate"></td>
                                                <td>
                                                    <select class="form-control" name="tax_slab" onchange="calculateCost()">
                                                        <?php 
                                                            if(isset($item)) {

                                                            
                                                        ?>
                                                            <option value="<?= $item['tax_id'] ?>"><?= $item['tax_rate'] ?></option>
                                                        <?php
                                                        
                                                            }
                                                        ?>

                                                    </select><br>
                                                    <input type="text" style="background:none !important; border:none !important" readonly name="calculated_taxAmt" class="p-0 col-md-12 float-left text-center background-none"></input>
                                                </td>
                                                <td><input type="text" class="form-control text-center" onkeyup="calculateCost()" name="amount" placeholder="Amount" value="<?= $item['item_amount'] ?>"></td>
                                                <td><a data-repeater-delete class="btn btn-primary btn-sm text-danger"><i class="fa fa-times"></i></a>  </td>
                                            
                                            </tr>

                                            <script>
                                                    
                                                    var editorQId1 = '<?= $q_i ?>';   
                                            </script>

                                            <?php
                                                $q_i++;
                                                    }
                                                } else {
                                            ?>
                                                <tr data-repeater-item class="repeater-group">
                                                <!--<td><textarea class="form-control" rows="3" name="item_name" placeholder="Item Name"></textarea></td> -->
                                                    <!-- <td><textarea class="form-control" rows="3" name="description" placeholder="Description"></textarea></td> -->
                                                    <td>
                                                        <div class="editor-container col-md-12 p-0">
                                                            <textarea name="description" class="item_description_editor"></textarea>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" class="form-control text-center" onkeyup="calculateCost()" name="quantity" placeholder="Qty"></td>
                                                    <td><input type="text" class="form-control text-center" onkeyup="calculateCost()" name="rate" placeholder="Rate"></td>
                                                    <td>
                                                        <select class="form-control" name="tax_slab" onchange="calculateCost()">
                                                        </select><br>
                                                        <input type="text" style="background:none !important; border:none !important" readonly name="calculated_taxAmt" class="p-0 col-md-12 float-left text-center background-none"></input>
                                                    </td>
                                                    <td><input type="text" class="form-control text-center" onkeyup="calculateCost()" name="amount" placeholder="Amount"></td>
                                                    <td><a data-repeater-delete class="btn btn-primary btn-sm text-danger"><i class="fa fa-times"></i></a>  </td>
                                                
                                                </tr>
                                            <?php } ?>
                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="incoice_bb" colspan="2"></td>
                                            <td class="incoice_bb"><span class="float-right font-weight-bold"> Sub Total </span></td>
                                            <td class="incoice_bb"><span class="float-right font-weight-bold">₹ <span id="subTotalValue"><?= isset($quotationItemData) ? $quotationItemData[0]['item_total_sub_amount'] : '0.00' ?> </span> /-</span></td>
                                        </tr>
                                        
                                        <tr>
                                            <td  colspan="2"></td>
                                            <td class="incoice_bb" colspan="2"><span class="float-right font-weight-bold"> Discount (%) </span></td>
                                            <td class="incoice_bb" ><input type="text" name="discount" id="discount" onkeyup="calculateCost()" value="<?= isset($quotationItemData) ? $quotationItemData[0]['discount_percent'] : '0' ?>" class="form-control text-right" > </td>
                                            <td class="incoice_bb" ><span class="float-right font-weight-bold">₹ <span id="afterDiscountValue"><?= isset($quotationItemData) ? $quotationItemData[0]['discount_amount'] : '0.00' ?></span> /- </span></td>
                                        </tr>
                                        <tr>
                                            <td  colspan="2"></td>
                                            <td class="incoice_bb" colspan="2"><span class="float-right font-weight-bold"> Adjustment </span></td>
                                            <td class="incoice_bb" ><input type="text" onkeyup="calculateCost()" id="adjustment" name="adjustment" class="form-control text-right" value="<?= isset($quotationItemData) ? $quotationItemData[0]['adjustment_value'] : '0' ?>"> </td>
                                            <td class="incoice_bb" ><span class="float-right font-weight-bold">₹ <span id="afterAdjustmentValue"><?= isset($quotationItemData) ? $quotationItemData[0]['adjustment_value'] : '0' ?></span> /- </span></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="incoice_bb" colspan="2"></td>
                                            <td class="incoice_bb"><span class="float-right font-weight-bold"> Tax</span></td>
                                            <td class="incoice_bb"><span class="float-right font-weight-bold">₹ <span id="totalTaxValue"><?= isset($quotationItemData) ? $quotationItemData[0]['tax_value'] : '0' ?> </span> /-</span></td>
                                        </tr>

                                        <tr>
                                            <td  colspan="2"></td>
                                            <td colspan="2"></td>
                                            <td><span class="float-right font-weight-bold"> Total </span></td>
                                            <td><span class="float-right font-weight-bold">₹ <span id="grandTotalValue"><?= isset($quotationItemData) ? $quotationItemData[0]['item_total_amount'] : '0' ?> </span>/- </span></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <a href="javascript:void(0)" onclick="getFooterNotes()" class="btn btn-primary waves-effect waves-light btn-sm mb-1" style="font-size:12px;background:#F0F0F0;color: gray;"><i class="fas fa-plus" aria-hidden="true"></i>Add Details</a>

                            
                                <div id="footerNotesDiv">

                                    <?php 
                                        if(isset($quotationFooterNotesData) && count($quotationFooterNotesData) > 0) {
                                            $i = 1;
                                            foreach($quotationFooterNotesData as $footerNote) {
                                            
                                                //print_r($quotationFooterNotesData);
                                                // master_footer_note_id
                                    ?>
                                        <div class="col-md-6 p-0 float-left">
                                            <div class="form-group col-md-11 p-0 float-left">
                                                <input type="hidden" data-master_footer_note="<?= $footerNote['master_footer_note_id'] ?>" name="cust_foot_id1[]" value="<?= $footerNote['cust_foot_id']; ?>" />
                                                <input type="hidden" name="master_footer_id[]" value="<?= $footerNote['master_footer_note_id'] ?>" />

                                                <label class="control-label"><?= $footerNote['technical_title'] ?></label>
                                                <div class="input-group">
                                                    <div class="editor-container col-md-12 p-0">
                                                        <textarea name="footerNotes[]" class="editor1<?= $i ?>">
                                                        <?= $footerNote['technical_description'] ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                                var editorId1 = '<?= $i ?>';   
                                        </script>

                                        <?php 
                                            $i++;
                                            }
                                        }

                                        ?>
                                            
                                        
                                </div>

                            </div>

                            <div class="col-lg-12 float-left text-right">
                                <input type="submit" id="submitFrm" class="btn btn-info btn-theme" value="Submit">
                            </div>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>

<!-- /// Technical Specification Model -->
<div id="technicalSpecificationModel" class="modal fade bd-example-modal-lg" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Technical Specification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $this->load->view(ADMIN.'sales/quotation/tbl_technicalSpecification'); ?>   
            </div>
            <div class="modal-footer">
                <button type="button" onclick="getCheckedTechSpecification()" class="btn btn-info btn-theme">Add Technical Specification</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
<!-- /// end Technical Specification Model -->


<!-- /// Technical Specification Model -->
<div id="footerNotesModel" class="modal fade bd-example-modal-lg" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Invoice Footer Notes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $this->load->view(ADMIN.'sales/quotation/tbl_footerNotes'); ?>   
            </div>
            <div class="modal-footer">
                <button type="button" onclick="getCheckedFooterNotes()" class="btn btn-info btn-theme">Add Footer Notes</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
<!-- /// end Technical Specification Model -->

<style>
    .invoiceTable
    {

    }
    .invoiceTable th
    {
        background-color:#48bc97 !important;
        padding:10px;
        color:#fff;
        text-align:center;
    }
    .invoiceTable td
    {
        vertical-align: center;
        padding:10px;
    }
    .invoiceTable .incoice_bb  {
        border-bottom: solid 1px #CAD1DC !important;
    }
    

</style>

<!-- end row -->
<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/sales/quotation.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<!-- https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js -->


 

<script>

    
    $(document).ready(function () {
        "use strict";

        
        function countRepeaters() {
            var repeaterCount = $('.repeater .repeater-group').length;
            return repeaterCount;
        }

        ClassicEditor.create(document.querySelector('.item_description_editor')).catch((error) => {
            console.error(error);
        });
        

        

        $(".repeater").repeater({
            show: function () {
                $(this).slideDown();

                $(this).find('.item_description_editor11').attr('class', 'item_description_editor'+ countRepeaters());
                
                $(this).find('.item_description_editor').attr('class', 'item_description_editor'+ countRepeaters());
                
                var editorContainer = document.querySelector('.item_description_editor' + countRepeaters());
                editorContainer.style.width = '200px';

                // Create CKEditor instance
                ClassicEditor.create(editorContainer).catch((error) => {
                    console.error(error);
                });
                
                countRepeaters();


            },
            hide: function (deleteElement) {
                if (
                    confirm(
                        "Are you sure you want to delete this element?"
                    )
                ) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function (setIndexes) {},
            isFirstItemUndeletable: true
        });


            var deletedROI = [];

            $(".repeater1").repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    var $item = $(this);
                    if (confirm("Are you sure you want to delete this element?")) {
                        var roiId = $item.find('[name^="group-b["][name$="][roi_id]"]').val();
                        if (roiId) {
                            deletedROI.push(roiId);
                        }
                        $item.slideUp(deleteElement);
                        //console.log(deletedROI);
                    }
                },
                ready: function (setIndexes) {},
                isFirstItemUndeletable: false
            });

        

            $('#submitFrm').on('click', function() {
                // alert("s");
                if(deletedROI.length > 0) {
                    var deletedROIIds = deletedROI.join(',');
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "deletedROIIds")
                        .attr('value', deletedROIIds)
                        .appendTo('#frm');
                }

                // deletedTechnicalSpecifications

                if(deletedTechnicalSpecifications.length > 0) {
                    var deletedTechSpecIds = deletedTechnicalSpecifications.join(',');
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "deletedTechSpecIds")
                        .attr('value', deletedTechSpecIds)
                        .appendTo('#frm');
                }
                //alert(deletedTechnicalSpecifications);

                
            });


            
    });
</script>

<script>
$(document).ready(function () {

    ClassicEditor.create(document.querySelector('.roiDescriptionEditor')).catch((error) => {
        console.error(error);
    });
 
    for (let i = 0; i <= editorId1; i++) {
        // alert(editorId1);
        // console.log(i);
        ClassicEditor.create(document.querySelector('.editor1'+ i)).catch((error) => {
            console.error(error);
        });
    }

    // editorQId1
    for (let i = 0; i <= editorQId1; i++) {
        // alert(editorId1);
        // console.log(i);
        ClassicEditor.create(document.querySelector('.item_description_editor1'+ i)).catch((error) => {
            console.error(error);
        });
    }


    
$('#frm').validate({ 
        
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
<style>
   .error{
   color: red;
   }
</style>
<script>
   $('.daterange').daterangepicker();
   $('.mydatepicker').datepicker({
    defaultDate: "today"
   });
    $('.mydatepicker').datepicker({
    defaultDate: "today",
    
   });
   
   $('.myPreviousDatepicker').datepicker({
    defaultDate: "today",
    minDate: null  // Set the minimum date to today, preventing selection of previous dates
});

     jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true,
        dateFormat:"Y-m-d"
    });

   
   
   
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
   
    
   
</script>
<!-- 
   <script>
      $(document).ready(function() { 
      $(".numberonly").attr("maxlength", "6");
          $(".numberonly").keypress(function(e) {
             var kk = e.which;
              if(kk < 48 || kk > 57)
              e.preventDefault();
          });
       });
      
      
      
   </script> -->
