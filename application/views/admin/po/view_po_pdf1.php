<!DOCTYPE html>
<html>
<style>
   #terms_condition p {
      margin-top: 5px !important;
      margin-bottom: 5px !important;
   }

   li {
      line-height: 1.5;
      /* Adjust line height as needed */
   }
</style>

<head>
   <meta charset="utf-8" />
   <title></title>
</head>

<body>
   <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
      <tr class="">
         <td width="20%">
            <span><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($company_master_data['left_image']) ? $company_master_data['left_image'] : 'no_images.png'; ?>" height="52" /></span>
         </td>
         <td width="60%" style="text-align:center;">
            <span style="font-size:12px;"><strong><?= isset($company_master_data['name']) ? $company_master_data['name'] : ''; ?><br>
               </strong><span style="font-size:9px;font-weight: bold;"><?= isset($company_master_data['address']) ? $company_master_data['address'] : ''; ?></span><br>
               <!-- <span style="font-size:9px;font-weight: bold;" >LTD. GOREGAON (WEST), MUMBAI - 400104.</span><br> -->
               <span style="font-size:9px;font-weight: bold;">Email Id - <?= isset($company_master_data['email']) ? $company_master_data['email'] : ''; ?></span>
            </span>
         </td>
         <td width="20%" style="text-align:center;">
            <!-- <span ><img src="<//?= base_url() ?>/assets/images/encon.jpg" height="40" /></span><br> -->
            <span><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($company_master_data['right_image']) ? $company_master_data['right_image'] : 'no_images.png'; ?>" height="52" /></span>

         </td>

      </tr>

      <tr class="">
         <td colspan="3">
            <table width="100%">
               <tr>
                  <td width="33.33%" align="left">
                     <span><strong>PAN No:&nbsp; <?= isset($company_master_data['pan_no']) ? $company_master_data['pan_no'] : ''; ?></strong></span>
                  </td>
                  <td width="33.33%" align="center">
                     <!--<span ><strong>ARN No:&nbsp; <?= isset($company_master_data['arn_no']) ? $company_master_data['arn_no'] : ''; ?></strong></span>-->
                  </td>
                  <td width="33.33%" align="right">
                     <span><strong>GST No:&nbsp; <?= isset($company_master_data['gst_no']) ? $company_master_data['gst_no'] : ''; ?></strong></span>

                  </td>
               </tr>
               <!--<tr>-->
               <!--   <td  width="30%">-->
               <!--      <span><strong>PAN No:</strong></span>-->
               <!--   </td>-->
               <!--   <td width="30%">-->
               <!--      <span ><strong>ARN No</strong></span>-->
               <!--   </td>-->
               <!--   <td   width="40%">-->
               <!--      <span ><strong>GST No. </strong></span>-->
               <!--   </td>-->
               <!--</tr>-->
            </table>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;">
            <span style="font-size:10px;"><strong>PURCHASE ORDER</strong></span>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;">
            <table>
               <tr>
                  <td width="50%" align="left"><br>
                     <address>
                        <strong><br>To,<br></strong>
                        <strong class="trhead">
                           <?= ($vendor_name ?? '') . (!empty($vendor_code) ? " ($vendor_code)" : '') ?>
                        </strong><br>
                        <strong><?= isset($address_details) ? $address_details : ''; ?><br></strong>
                        <strong><?= isset($pincode) ? $pincode : ''; ?><br></strong>
                        <strong>State :<?= isset($state_name) ? $state_name : ''; ?><br></strong>
                        <strong>City :<?= isset($vendor_city_name) ? $vendor_city_name : ''; ?><br></strong>
                        <strong>Email &nbsp;: <?= isset($contact_person_email) ? $contact_person_email : ''; ?><br></strong>
                        <?php
                        if (!empty($emails_other_email)) {
                        ?>
                           <strong>Email Other&nbsp;: <?= isset($emails_other_email) ? $emails_other_email : ''; ?><br></strong>
                        <?php
                        }
                        ?>

                        <strong>PH.&nbsp;: <?= isset($contact_person_mobile_no) ? $contact_person_mobile_no : ''; ?>,<br></strong>
                        <strong>GSTIN/UID: <?= isset($gst_no) ? $gst_no : ''; ?></strong>
                     </address>
                  </td>
                  <td width="50%" align="left">
                     <address>
                        <address>
                           <strong><br>Order No.: <?= isset($po_order_no) ? $po_order_no : ''; ?><br></strong>
                           <strong>Order Date.: <?= isset($po_date) ? dmyDate($po_date) : ''; ?><br></strong>
                           <strong>Ref .: <?= isset($reference) ? $reference : 'N.A'; ?><br></strong>
                        </address>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;">
            <strong style="margin-bottom: 0px;font-size:9px">KIND ATTN : <?= (isset($contact_person_name) && ! is_null($contact_person_name) && ($contact_person_name != 'NULL')) ? $contact_person_name : $account_name; ?></strong>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;">
            <?= isset($line_before_address) ? $line_before_address : ''; ?>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="center">
            <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
               <tr class="heading">
                  <td style="border: 1px solid  #000;" width="6%">
                     <strong>SR.No</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="30%">
                     <strong>DESCRIPTION</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="10%">
                     <strong>HSNCODE</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="10%">
                     <strong> SIZE</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="9%">
                     <strong> QTY</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="10%">
                     <strong> RATE</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="15%">
                     <strong>GST RS.</strong>
                  </td>
                  <td style="border: 1px solid  #000;" width="10%">
                     <strong> TOTAL AMT</strong>
                  </td>
               </tr>

               <?php
               $is_display_dispatch_qty = 0;
               foreach ($po_item_details_data as $key => $value) {
                  if (isset($value['dispatch_1_lot_qty']) || isset($value['dispatch_3_lot_qty']) || isset($value['dispatch_4_lot_qty']) || isset($value['dispatch_2_lot_qty'])) {
                     $is_display_dispatch_qty = 1;
                  }


               ?>
                  <tr class="item">
                     <td align="left" style="border: 1px solid  #000;">
                        <?= $key + 1; ?>
                     </td>
                     <td align="left" style="border: 1px solid  #000;">
                        <?= $value['item_name']; ?>
                        <?php
                        if (isset($value['item_description']) && !empty($value['item_description'])) {
                           echo "<br><b>Description</b>:" . $value['item_description'];
                        }
                        if (isset($value['other_description']) && !empty($value['other_description'])) {
                           echo "<br><b>Other Desc.</b>:" . $value['other_description'];
                        }
                        if (isset($value['technical_description']) && !empty($value['technical_description'])) {
                           echo "<br><b>Technical Desc.</b>:" . $value['technical_description'];
                        }
                        ?>
                     </td>


                     <td align="left" style="border: 1px solid  #000;">
                        <?= $value['hsn_code']; ?>
                     </td>
                     <td align="left" style="border: 1px solid  #000;">
                        <?= $value['item_size']; ?>
                     </td>
                     <td align="right" style="border: 1px solid  #000;">
                        <?= $value['item_qty'] . " " . $value['unit_name']; ?>
                     </td>
                     <td align="right" style="border: 1px solid  #000;">
                        <?= $value['item_rate']; ?>
                     </td>
                     <td align="right" style="border: 1px solid  #000;">
                        <?php
                        if (isset($gst_no) && !empty($gst_no)) {
                           $gst_no_initial = substr($gst_no, 0, 2);
                           if ($gst_no_initial != '27') {
                        ?>
                              IGST:<?= intval($value['tax_rate']); ?>% Rs. <?= $value['tax_value']; ?>
                           <?php
                           } else {
                           ?>
                              CGST:<?= $value['tax_rate'] / 2; ?>% Rs. <?= $value['tax_value'] / 2; ?><br>SGST:<?= $value['tax_rate'] / 2; ?>% Rs. <?= $value['tax_value'] / 2; ?>
                           <?php
                           }
                        } else {
                           ?>
                           IGST:<?= intval($value['tax_rate']); ?>% Rs. <?= $value['tax_value']; ?>
                        <?php
                        }

                        ?>

                     </td>
                     <td style="border: 1px solid  #000;" align="right">
                        <?= $value['item_amount']; ?>
                     </td>
                  </tr>
               <?php
               }
               ?>
               <tr>
                  <td colspan="7" style="border: 1px solid  #000;"> <strong>Item Total :</strong> </td>
                  <td align="right" style="border: 1px solid  #000;"> <strong><?= $po_tax_details_data[0]['item_total_amount']; ?> </strong></td>
               </tr>
               <tr>
                  <td colspan="7" style="border: 1px solid  #000;"> <strong>GST @ : </strong></td>
                  <td align="right" style="border: 1px solid  #000;"> <strong><?= $po_tax_details_data[0]['item_total_gst'] ?> </strong></td>
               </tr>
               <tr>
                  <td colspan="7" style="border: 1px solid  #000;"> <strong>Total Amount In Words</strong>: <strong><?= convertNumber($po_tax_details_data[0]['po_final_amount']); ?> </strong></td>
                  <td align="right" style="border: 1px solid  #000;"><?= moneyFormatIndia($po_tax_details_data[0]['po_final_amount']) ?> </td>

               </tr>



            </table>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" id="terms_condition">
            <strong style="margin-bottom: 0px;font-size:9px">Terms & Conditions :- </strong><br>
            <?= $terms_and_condition; ?>
         </td>

      </tr>
      <?php
      if ($is_display_dispatch_qty == 1):
      ?>
         <tr class="">
            <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" id="terms_condition">
               <strong style="margin-bottom: 0px;">Dispatch Schedule Qty :- </strong><br>
               <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
                  <tr class="heading">
                     <td style="border: 1px solid  #000;" width="5%" rowspan="2">
                        SR.No
                     </td>
                     <td style="border: 1px solid  #000;" width="35%" rowspan="2">
                        Item Name
                     </td>
                     <td style="border: 1px solid  #000;" align="center" width="15%" colspan="2">
                        1st Lot
                     </td>

                     <td style="border: 1px solid  #000;" align="center" width="15%" colspan="2">
                        2nd Lot
                     </td>

                     <td style="border: 1px solid  #000;" align="center" width="15%" colspan="2">
                        3rd Lot
                     </td>

                     <td style="border: 1px solid  #000;" align="center" width="15%" colspan="2">
                        4th Lot
                     </td>

                  </tr>
                  <tr class="heading">

                     <td style="border: 1px solid  #000;" width="5%" align="center">
                        Qty
                     </td>
                     <td style="border: 1px solid  #000;" width="10%" align="center">
                        Date
                     </td>
                     <td style="border: 1px solid  #000;" width="5%" align="center">
                        Qty
                     </td>
                     <td style="border: 1px solid  #000;" width="10%" align="center">
                        Date
                     </td>
                     <td style="border: 1px solid  #000;" width="5%" align="center">
                        Qty
                     </td>
                     <td style="border: 1px solid  #000;" width="10%" align="center">
                        Date
                     </td>
                     <td style="border: 1px solid  #000;" width="5%" align="center">
                        Qty
                     </td>
                     <td style="border: 1px solid  #000;" width="10%" align="center">
                        Date
                     </td>
                  </tr>

                  <?php
                  foreach ($po_item_details_data as $key => $value) {
                     if (isset($value['dispatch_1_lot_qty']) || isset($value['dispatch_3_lot_qty']) || isset($value['dispatch_4_lot_qty']) || isset($value['dispatch_2_lot_qty'])) {
                  ?>
                        <tr class="item">
                           <td align="center" style="border: 1px solid  #000;">
                              <?= $key + 1; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= $value['item_name']; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= $value['dispatch_1_lot_qty']; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= (isset($value['dispatch_1_lot_date']) && ($value['dispatch_1_lot_date'] != '1970-01-01')) ? $value['dispatch_1_lot_date'] : ""; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= $value['dispatch_2_lot_qty']; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= (isset($value['dispatch_2_lot_date']) && ($value['dispatch_2_lot_date'] != '1970-01-01')) ? $value['dispatch_2_lot_date'] : "";; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= $value['dispatch_3_lot_qty']; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= (isset($value['dispatch_3_lot_date']) && ($value['dispatch_3_lot_date'] != '1970-01-01')) ? $value['dispatch_3_lot_date'] : "";; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= $value['dispatch_4_lot_qty']; ?>
                           </td>
                           <td align="center" style="border: 1px solid  #000;">
                              <?= (isset($value['dispatch_4_lot_date']) && ($value['dispatch_4_lot_date'] != '1970-01-01')) ? $value['dispatch_4_lot_date'] : "";; ?>
                           </td>

                        </tr>
                  <?php
                     }
                  }
                  ?>


               </table>
            </td>

         </tr>
      <?php
      endif;
      ?>
      <tr class="">
         <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;"><strong>
               <table cellspacing="5" cellpadding="5">

                  <tr>
                     <td width="50%" align="left"><span>Discount&nbsp;:&nbsp;&nbsp;<?= (isset($po_tax_details_data[0]['item_total_discount']) && $po_tax_details_data[0]['item_total_discount'] != 0.00) ? $po_tax_details_data[0]['item_total_discount'] : 'N.A'; ?></span></td>
                     <td width="50%"><span>Guarantee&nbsp;:&nbsp;&nbsp;<?= isset($guarantee) ? $guarantee : 'N.A'; ?></span></td>
                  </tr>
                  <tr>
                     <td width="50%" align="left"><span>Prices&nbsp;:&nbsp;<?= isset($prices) ? $prices : 'N.A'; ?></span></td>
                     <td width="50%"><span>Packing & Forwarding :<?= isset($packing_forwarding) ? $packing_forwarding : 'N.A'; ?> </span></td>
                  </tr>
                  <tr>
                     <td width="50%" align="left"><span>Trans & Insur:&nbsp;&nbsp;0.00</span></td>
                     <td width="50%"><span>Taxes & Duites :&nbsp;&nbsp; <?= (isset($taxes_duites) && !empty($taxes_duites)) ? $taxes_duites : 'EXTRA, AS APPLICABLE'; ?></span></td>
                  </tr>
                  <tr>
                     <td width="50%" align="left"><span>Delivery :&nbsp;&nbsp;<?= isset($delivery_days) ? $delivery_days : '-'; ?></span></td>
                     <td width="50%"><span>Payment Terms:&nbsp;&nbsp;<?= isset($payment_days) ? $payment_days : '-'; ?></span></td>

                  </tr>

                  <tr>
                     <td width="50%" align="left"><span>LD Clause Charges : &nbsp;&nbsp;<?= isset($po_tax_details_data[0]['ld_charges']) ? $po_tax_details_data[0]['ld_charges'] : '0.00'; ?> <br>LD Clause Text : <?= isset($po_tax_details_data[0]['ld_clause_text']) ? $po_tax_details_data[0]['ld_clause_text'] : 'N.A'; ?>.</span></td>
                     <td width="50%"><span>Delivery Address&nbsp;:&nbsp;&nbsp;
                           <?php

                           if (isset($delivery_party_id) && isset($delivery_party_address)) {
                              $delivery_address = $delivery_party_address;
                           } else if (isset($delivery_site_name)) {
                              $delivery_address = $delivery_site_name;
                           } else {
                              $delivery_address = '-';
                           }
                           ?>
                           <?= $delivery_address; ?></span></td>
                  </tr>


                  <tr>
                     <td width="50%" align="left"><span>Remark&nbsp;:&nbsp;<?= isset($po_remark) ? $po_remark : ''; ?></span></td>
                     <td width="50%"><span>Freight Text &nbsp;:&nbsp;
                           <?php
                           if (($po_tax_details_data[0]['freight_type'] == 1)) {
                              echo "F.O.R";
                           } else if (($po_tax_details_data[0]['freight_type'] == 2)) {
                              echo "To Pay";
                           } else {
                              echo "-";
                           } ?>

                           <?= isset($po_tax_details_data[0]['freight_text']) ? $po_tax_details_data[0]['freight_text'] : 'N.A'; ?></span>
                     </td>
                  </tr>

                  <tr>
                     <td width="30%">
                        <!--  <span></span><br> -->
                        <!-- <span></span><br> -->
                        <?php
                        if (isset($created_signature_image)) {
                        ?>
                           <img src="<?= base_url() ?>assets/uploads/user_signature/<?= isset($created_signature_image) ? $created_signature_image : '-'; ?>" height="40" /><br>
                        <?php
                        } else {
                           echo "<br>";
                        }
                        ?>
                        <span><?= $created_first_name . " " . $created_last_name ?></span><br>
                        <span>Checked By</span>
                     </td>
                     <td width="30%">
                        <?php
                        if (isset($approved_by_signature_image)) {
                        ?>
                           <img src="<?= base_url() ?>assets/uploads/user_signature/<?= isset($approved_by_signature_image) ? $approved_by_signature_image : '-'; ?>" height="40" /><br>
                        <?php
                        } else {
                           echo "<br>";
                        }
                        ?>


                        <?php
                        if (isset($approved_by) && !is_null($approved_by) && !empty($approved_by)) {
                        ?>
                           <span><?= isset($approved_first_name) ? $approved_first_name : ''; ?> <?= isset($approved_last_name) ? $approved_last_name : ''; ?></span><br>
                        <?php
                        } else {
                           echo "<br>";
                        }
                        ?>

                        <span>Approved By</span>
                     </td>
                     <td width="40%" align="center">
                        <?php
                        if (isset($company_master_data['stamp_image'])) {
                        ?>
                           <img src="<?= base_url() ?>assets/uploads/company_stamps/<?= isset($company_master_data['stamp_image']) ? $company_master_data['stamp_image'] : '-'; ?>" height="40" /><br>
                        <?php
                        } else {
                           echo "<br>";
                        }
                        ?>

                        <span>Thanking you,<br>
                           Your's Faithfully<br>
                           For <?= isset($company_master_data['name']) ? $company_master_data['name'] : ''; ?>.<br>
                           <?php
                           if (isset($company_master_data['signature_image'])) {
                           ?>
                              <img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($company_master_data['signature_image']) ? $company_master_data['signature_image'] : '-'; ?>" height="40" /><br>
                           <?php
                           } else {
                              echo "<br>";
                           }
                           ?>
                           <!--Authorised Signatory-->
                        </span>



                     </td>
                  </tr>
               </table>
            </strong>
         </td>
      </tr>
      <tr class="">
         <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;">
            <strong style="margin-bottom: 0px;">WORKS: <?= isset($po_site_address) ? $po_site_address : ''; ?></strong>
         </td>
      </tr>

   </table>
</body>

</html>