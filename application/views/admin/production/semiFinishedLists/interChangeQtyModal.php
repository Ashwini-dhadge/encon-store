<style>
    .detail-container {
        display: flex;
        flex-direction: row;
        /* Horizontal layout */
        justify-content: space-between;
        /* Space between items */
        align-items: center;
        /* Center vertically */
    }

    .detail-item {
        flex: 1;
        /* Equal space for each item */
        margin: 5px;
        /* Margin between items */
        padding: 8px;
        border: 1px solid #ddd;
        /* Optional border */
        border-radius: 4px;
        /* Optional rounded corners */
        display: flex;
        /* Flexbox for label and value */
        justify-content: space-between;
        /* Space between label and value */
    }

    .detail-label {
        font-weight: bold;
    }

    .detail-value {
        color: #333;
       
    }
    .hover-bg:hover {
        cursor: pointer;
        
    }
    .fa-exchange-alt:hover {
        cursor: pointer;
    }
</style>
<div class="modal-body">
    <form method="post" id="interchangeQtyForm"
        action="<?php echo base_url() . 'admin/production/SemifinishedList/transferOrder'; ?>">
        <input type="hidden" name="type" id="intertype" value="<?php echo isset($type) ? $type : ""; ?>">
        <input type="hidden" name="mouldsize" id="intermouldSize"
            value="<?php echo isset($mould_size) ? $mould_size : ""; ?>">

        <input type="hidden" name="orderId" id="interorderId" value="<?php echo isset($orderId) ? $orderId : ""; ?>">
        <input type="hidden" name="fromManualIndentNo" id="interFromManualIndentNo"
            value="<?php echo isset($manualIndentNo) ? $manualIndentNo : ""; ?>">

        <!-- -------------------------------- For The Interchange Qty Start ------------------- -->

        <input type="hidden" name="interChange" id="interChange"
            value="<?php echo isset($interChangeType) ? $interChangeType : ""; ?>">
        <input type="hidden" name="orderQuty" id="interorderQuty"
            value="<?php echo isset($orderQty) ? $orderQty : ""; ?>">
        <input type="hidden" name="bladeSize" id="interbladeSize"
            value="<?php echo isset($bladeSize) ? $bladeSize : ""; ?>">
        <input type="hidden" name="aTip" id="interaTip" value="<?php echo isset($aTip) ? $aTip : ""; ?>">


        <!-- -------------------------------- For The Interchange Qty End --------------------- -->
        <?php if ($type == 1) { ?>
            <input type="hidden" name="from_hidden_1" id="hidden_created_qty"
                value="<?php echo isset($orderStatus['created_qty']) ? $orderStatus['created_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_2" id="hidden_blade_in_hand_qty"
                value="<?php echo isset($orderStatus['blade_in_hand_qty']) ? $orderStatus['blade_in_hand_qty'] : ""; ?>">
            <!-- <input type="hidden" name="from_hidden_3" id="hidden_blade_position_qty"
                value="<?php echo isset($orderStatus['blade_position_qty']) ? $orderStatus['blade_position_qty'] : ""; ?>"> -->
        <?php } else { ?>
            <input type="hidden" name="from_hidden_4" id="hidden_gapchecking"
                value="<?php echo isset($orderStatus['gap_checking_qty']) ? $orderStatus['gap_checking_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_5" id="hidden_primer_qty"
                value="<?php echo isset($orderStatus['primer_qty']) ? $orderStatus['primer_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_6" id="hidden_filler_qty"
                value="<?php echo isset($orderStatus['filler_qty']) ? $orderStatus['filler_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_7" id="hidden_putty_qty"
                value="<?php echo isset($orderStatus['putty_qty']) ? $orderStatus['putty_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_8" id="hidden_top_coat_qty"
                value="<?php echo isset($orderStatus['top_coat_qty']) ? $orderStatus['top_coat_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_9" id="hidden_balancing_qty"
                value="<?php echo isset($orderStatus['balancing_qty']) ? $orderStatus['balancing_qty'] : ""; ?>">
            <input type="hidden" name="from_hidden_10" id="hidden_packing_qty"
                value="<?php echo isset($orderStatus['packing_qty']) ? $orderStatus['packing_qty'] : ""; ?>">
        <?php } ?>


        <div class="ml-2 mb-2">
            <p class="detail-label">Inter Change Details:</p>
            <div class="detail-container ml-1">
                <div class="detail-item">
                    <span class="detail-label">Mould Size:</span>
                    <span class="detail-value"><?php echo isset($mould_size) ? $mould_size : ""; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Manual Indent No:</span>
                    <span class="detail-value"><?php echo isset($manualIndentNo) ? $manualIndentNo : ""; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Blade Size:</span>
                    <span class="detail-value"><?php echo isset($bladeSize) ? $bladeSize : ""; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">ATip:</span>
                    <span class="detail-value"><?php echo isset($aTip) ? $aTip : ""; ?></span>
                </div>
            </div>
        </div>

        <div class="row justify-content-center pb-3">

            <div class="col-md-5">
                <label class="">Transfer To</label>
                <select name="" id="" class="form-control interIndent select2" style="width: 100%;" required></select>
                <input type="hidden" name="transferToManualIndnetNo" id="transferToManualIndnetNo">
                <input type="hidden" name="transferToOrderId" id="transferToOrderId">
            </div>
            <div class="col-md-5">
                <label class="">Sub-indent</label>
                <select name="" id="" class="form-control interSubIndent select2" style="width: 100%;"
                    required></select>

            </div>
        </div>

        <?php if ($type == 2) { ?>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="text-center">Order No</th>
                        <!-- <th>Manual Indent No</th>
                    <th>Mould Size</th> -->

                        <th>Transfer Qty</th>
                        <th>Gap Checking</th>
                        <th>Primer</th>
                        <th>Filler</th>
                        <th>Putty</th>
                        <th>Top Coat</th>
                        <th>Balancing</th>
                        <th>Packing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><?php echo isset($order_no) ? $order_no : ""; ?></td>
                        <!-- <td><?php echo isset($manualIndentNo) ? $manualIndentNo : ""; ?></td>
                    <td><?php echo isset($mould_size) ? $mould_size : ""; ?></td> -->

                        <td class="text-center"><?php echo isset($orderStatus['transfer_qty']) ? $orderStatus['transfer_qty'] : ""; ?></td>
                        <td class="text-center"><?php echo isset($orderStatus['gap_checking_qty']) ? $orderStatus['gap_checking_qty'] : ""; ?>
                        </td>
                        <td class="text-center"><?php echo isset($orderStatus['primer_qty']) ? $orderStatus['primer_qty'] : ""; ?></td>
                        <td class="text-center"><?php echo isset($orderStatus['filler_qty']) ? $orderStatus['filler_qty'] : ""; ?></td>
                        <td class="text-center"><?php echo isset($orderStatus['putty_qty']) ? $orderStatus['putty_qty'] : ""; ?></td>
                        <td class="text-center"><?php echo isset($orderStatus['top_coat_qty']) ? $orderStatus['top_coat_qty'] : ""; ?></td>
                        <td class="text-center"><?php echo isset($orderStatus['balancing_qty']) ? $orderStatus['balancing_qty'] : ""; ?></td>
                        <td class="text-center"><?php echo isset($orderStatus['packing_qty']) ? $orderStatus['packing_qty'] : ""; ?></td>
                    </tr>
                    <tr class="dynamicDetails" id="" style="display: none;">
                        <td id="ON" class="text-center"></td>
                        <td id="tqty" class="text-center"></td>
                        <td id="primer" class="text-center"></td>
                        <td id="filler" class="text-center"></td>
                        <td id="putty" class="text-center"></td>
                        <td id="topcoat" class="text-center"></td>
                        <td id="balancing" class="text-center"></td>
                        <td id="packing" class="text-center"></td>

                    </tr>
                </tbody>
            </table>
        <?php } ?>

        <?php if ($type == 1) { ?>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Order Qty</th>
                        <!-- <th>Manual Indent No</th>
                    <th>Mould Size</th> -->
                        <th>Created</th>
                        <th>Blade In Hand</th>
                        <!-- <th>Blade Position</th> -->

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" ><?php echo isset($order_no) ? $order_no : ""; ?></td>
                        <td class="text-center fromQty"><?php echo isset($orderQty) ? $orderQty : ""; ?></td>
                        <!-- <td><?php echo isset($manualIndentNo) ? $manualIndentNo : ""; ?></td>
                         <td><?php echo isset($mould_size) ? $mould_size : ""; ?></td> -->
                        <td class="text-center fromCreated"><?php echo isset($orderStatus['created_qty']) ? $orderStatus['created_qty'] : ""; ?></td>
                        <td class="text-center fromBladeHand"><?php echo isset($orderStatus['blade_in_hand_qty']) ? $orderStatus['blade_in_hand_qty'] : ""; ?>
                        </td>
                        <!-- <td class="text-center fromBladePosition"><?php echo isset($orderStatus['blade_position_qty']) ? $orderStatus['blade_position_qty'] : ""; ?>
                        </td> -->

                    </tr>
                    <tr class="dynamicDetails" id="" style="display: none;">
                        <td id="ON" class="text-center"></td>
                        <td id="oqty" class="text-center toQty"></td>
                        <td id="create" class="text-center toCreated"></td>
                        <td id="bladeh" class="text-center toBladeHand"></td>
                        <td id="bposition" class="text-center toBladePosition"></td>

                    </tr>
                    <tr class="dynamicDetails" id="" style="display: none;">
                        <td id="" colspan="2">Inter-Change Qunatity</td>
                        <!-- <td id=""></td> -->
                        <td id="" class="text-center"><i class="fas fa-exchange-alt " aria-hidden="true"onclick="checkfirst()" style="transform:rotate(90deg)"></i></td>
                        <td id="" class="text-center"><i class="fas fa-exchange-alt " aria-hidden="true" onclick="checksec()"style="transform:rotate(90deg)"></i></td>
                        <td id="" class="text-center"><i class="fas fa-exchange-alt " aria-hidden="true" onclick="checkthre()"style="transform:rotate(90deg)"></i></td>

                    </tr>
                    <tr class="dynamicDetails border border-success" id="" style="display: none;">
                        <td id="" colspan="2" rowspan="2" class="pt-4 ">New Inter-Change Qunatity</td>
                        <!-- <td id=""></td> -->
                        <td id="" class="text-center"><input type="text" name="oldcreatedqty" id="oldcreatedqty" class="w-25" disabled></td>
                        <td id="" class="text-center"><input type="text" name="oldbladehandqty" id="oldbladehandqty"class="w-25" disabled></td>
                        <td id="" class="text-center"><input type="text" name="oldbladepositionqty" id="oldbladepositionqty" class="w-25" disabled></td>

                    </tr>
                    <tr class="dynamicDetails" id="" style="display: none;">
                      
                    <!-- <td colspan="2"></td> -->
                        <td id="" class="text-center"><input type="text" name="newcreatedqty" id="newcreatedqty" class="w-25" disabled></td>
                        <td id="" class="text-center"><input type="text" name="newbladehandqty" id="newbladehandqty" class="w-25" disabled></td>
                        <td id="" class="text-center"><input type="text" name="newbladepositionqty" id="newbladepositionqty" class="w-25" disabled></td>

                    </tr>
                </tbody>
            </table>
        <?php } ?>

        <div class="row justify-content-center pb-3 dynamicDetails " style="display: none;">

            <span style="display: inline-block; padding: 6px; background-color: grey;" class="rounded hover-bg" onclick="interChangeQuantity()">
                <i class="fas fa-exchange-alt" aria-hidden="true" style="color: white;" title="InterChange"></i>
            </span>
        </div>

        <!-- <div class="col-md-6" id="transferDetails" style="display:none"> -->


        <!-- <div class="row" id="transferDetails" style="display:none">

            <div class="col-md-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Status Stage</th>
                            <?php if ($type == 1) { ?>
                                <th>Created</th>
                                <th>Blade in Hand</th>
                                <th>Blade Position</th>
                            <?php } elseif ($type == 2) { ?>
                                <th>Gap Checking</th>
                                <th>Primer</th>
                                <th>Filler</th>
                                <th>Putty</th>
                                <th>TOP Coat</th>
                                <th>Balancing</th>
                                <th>Packing</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">Quantity</td>
                            <?php if ($type == 1) { ?>
                                <td>
                                    <input type="text" class="form-control cq" placeholder=" " name="1_qty" id="CreateQty"
                                        max="<?php echo isset($orderStatus['created_qty']) ? $orderStatus['created_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="2_qty" id="BladeHandQty"
                                        max="<?php echo isset($orderStatus['blade_in_hand_qty']) ? $orderStatus['blade_in_hand_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="3_qty" id="BladePosQty"
                                        max="<?php echo isset($orderStatus['blade_position_qty']) ? $orderStatus['blade_position_qty'] : ""; ?>">

                                </td>
                            <?php } elseif ($type == 2) { ?>
                                <td>
                                    <input type="text" class="form-control" placeholder=" " name="4_qty" id="GapCheckQty"
                                        max="<?php echo isset($orderStatus['gap_checking_qty']) ? $orderStatus['gap_checking_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="5_qty" id="PrimerQty"
                                        max="<?php echo isset($orderStatus['primer_qty']) ? $orderStatus['primer_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="6_qty" id="FillerQty"
                                        max="<?php echo isset($orderStatus['filler_qty']) ? $orderStatus['filler_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="7_qty" id="PuttyQty"
                                        max="<?php echo isset($orderStatus['putty_qty']) ? $orderStatus['putty_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="8_qty" id="TopCoatQty"
                                        max="<?php echo isset($orderStatus['top_coat_qty']) ? $orderStatus['top_coat_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="9_qty" id="BalancingQty"
                                        max="<?php echo isset($orderStatus['balancing_qty']) ? $orderStatus['balancing_qty'] : ""; ?>">

                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="" name="10_qty" id="PackingQty"
                                        max="<?php echo isset($orderStatus['packing_qty']) ? $orderStatus['packing_qty'] : ""; ?>">

                                </td>
                            <?php } ?>
                        </tr>

                    </tbody>
                </table>

            </div>


        </div> -->



        <!-- </div> -->
        <!-- </div> -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class="btn   waves-effect waves-light" id="submit_btn"
                style="background-color: #48bc97;color:white;">InterChange</button>
        </div>
    </form>
    <!-- <script src="<?= base_url(); ?>assets/js/page-js/production/transferQuantity.js?v=1.0.1"></script> -->
    <script src="<?= base_url(); ?>assets/js/page-js/production/interChangeQuantity.js?v=1.0.1"></script>
    <script>

    </script>