<!DOCTYPE html>
<html>
   <style>
   </style>
   <head>
      <meta charset="utf-8" />
      <title>A simple, clean, and responsive HTML invoice template</title>
   </head>
   <body>
      <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
         <tr class="">
            <td  width="20%" >
               <span ><img src="<?= base_url() ?>/assets/images/encon.jpg" height="50" /></span>
            </td>
            <td width="60%" style="text-align:center;">
               <span style="font-size:12px;" ><strong>ENCON COOLING TOWERS PVT. LTD.<br>
               </strong><span style="font-size:9px;font-weight: bold;" >GALA NO.75, BLDG NO.5, NEW ASHIRWAD IND. PREMISES CO-OP.</span><br>
               <span style="font-size:9px;font-weight: bold;" >LTD. GOREGAON (WEST), MUMBAI - 400104.</span><br>
               <span style="font-size:9px;font-weight: bold;" >Email Id - encon@encongroup.in</span>
             </span>
            </td>
            <td   width="20%" style="text-align:center;">
               <span ><img src="<?= base_url() ?>/assets/images/encon.jpg" height="50" /></span><br>
               <span ><img src="<?= base_url() ?>/assets/images/encon.jpg" height="50" /></span>

            </td>

         </tr>

         <tr class="">
            <td colspan="3">
               <table>
                  <tr>
                     <td  width="30%">
                        <span ><strong>PAN No:</strong></span>
                     </td>
                     <td width="30%">
                        <span ><strong>ARN No</strong></span>
                     </td>
                     <td   width="40%">
                        <span ><strong>GST No. </strong></span>
                     </td>
                  </tr>
                  <tr>
                     <td  width="30%">
                        <span><strong>PAN No:</strong></span>
                     </td>
                     <td width="30%">
                        <span ><strong>ARN No</strong></span>
                     </td>
                     <td   width="40%">
                        <span ><strong>GST No. </strong></span>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr class="">
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <span style="font-size:10px;"><strong>PURCHASE ORDER</strong></span>
            </td>
         </tr>
          <tr class="">
            <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <table >
                <tr>
                        <td width="50%">
                           <strong>To&nbsp;,</strong> <br>
                           <?= isset($vendor_name)?$vendor_name :''; ?>&nbsp;<br>
                           <?= isset($address_details)?$address_details :''; ?><br>
                           <?= isset($pincode)?$pincode :''; ?><br>
                           State  :<?= isset($state_name)?$state_name :''; ?><br>
                           City  :<?= isset($state_name)?$state_name :''; ?><br>
                           Email &nbsp;: <?= isset($contact_person_email)?$contact_person_email :''; ?><br>
                           PH.&nbsp;: <?= isset($contact_person_mobile_no)?$contact_person_mobile_no :''; ?>,<br>
                           GSTIN/UID: <?= isset($gst_no)?$gst_no :''; ?>
                        </td>
                        <td align="left"> <strong>Order No. : <?= isset($po_order_no)?$po_order_no :''; ?> </strong><br>
                           <strong>Order Date </strong>: <?= isset($po_date)?$po_date :''; ?><br>
                           <strong>Ref </strong>: N.A.<br>
                        </td>
                     </tr>     
                </table>
            </td>
         </tr>
          <tr class="">
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <strong style="margin-bottom: 0px;">KIND ATTN : MR. RAJENDRA TIWARI</strong>
            </td>
         </tr>
          <tr class="">
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <?= isset($line_before_address)?$line_before_address :''; ?>
            </td>
         </tr>
         <tr class="">
            <td colspan="3" align="center"  >
                 <table  style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
                     <tr class="heading"  >
                        <td style="border: 1px solid  #000;" width="6%">
                           SR.No
                        </td>
                        <td style="border: 1px solid  #000;">
                           DESCRIPTION
                        </td>
                        <td style="border: 1px solid  #000;">
                           HSNCODE
                        </td>
                        <td style="border: 1px solid  #000;">
                           SIZE
                        </td>
                        <td style="border: 1px solid  #000;">
                           QTY
                        </td>
                        <td style="border: 1px solid  #000;">
                           RATE
                        </td>
                        <td style="border: 1px solid  #000;">
                           GST RS.
                        </td>
                        <td style="border: 1px solid  #000;">
                           TOTAL AMT
                        </td>
                     </tr>
                    
                          <?php
                        foreach($po_item_details_data as $key=>$value){
                        ?>
                         <tr class="item">
                            <td  align="left" style="border: 1px solid  #000;">
                               <?= $key+1; ?>
                            </td>
                            <td  align="left" style="border: 1px solid  #000;">
                               <?= $value['item_name']."<br>".$value['item_description']; ?>
                            </td>
                            <td align="left" style="border: 1px solid  #000;">
                               <?= $value['hsn_code']; ?>
                            </td>
                            <td align="left" style="border: 1px solid  #000;">
                               <?= $value['item_size']; ?>
                            </td>
                            <td align="right" style="border: 1px solid  #000;">
                               <?= $value['item_qty']; ?>
                            </td>
                            <td align="right" style="border: 1px solid  #000;" >
                               <?= $value['item_rate']; ?>
                            </td>
                            <td align="right" style="border: 1px solid  #000;">
                               CGST:<?= $value['tax_rate']/2; ?>% Rs. <?= $value['tax_value']/2; ?><br>SGST:<?= $value['tax_rate']/2; ?>% Rs. <?= $value['tax_value']/2; ?>
                            </td>
                            <td style="border: 1px solid  #000;" align="right">
                               <?= $value['item_sub_amount']; ?>
                            </td>
                         </tr>
                     <?php
                        }
                         ?>
                     <tr>
                         <td colspan="7"  style="border: 1px solid  #000;">Item Total : </td>
                           <td align="right"  style="border: 1px solid  #000;"><?= $po_tax_details_data[0]['item_total_sub_amount']; ?> </td>
                     </tr>
                     <tr>
                         <td colspan="7" style="border: 1px solid  #000;">GST @ : </td>
                           <td align="right"  style="border: 1px solid  #000;"><?= $po_tax_details_data[0]['item_total_sub_amount'] ?> </td>
                     </tr>
                      <tr>
                         <td colspan="7"  style="border: 1px solid  #000;">Total Amount In Words: THIRTY FOUR THOUSAND TWO HUNDRED TWENTY ONLY </td>
                           <td align="right"  style="border: 1px solid  #000;"><?= $po_tax_details_data[0]['item_total_sub_amount'] ?> </td>
                     </tr>
                      
                </table>
            </td>
         </tr>
         <tr class="">
            <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <strong style="margin-bottom: 0px;">Terms & Conditions :- </strong>
            </td>
         </tr>
         
         <tr class="">
            <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
              <table cellspacing="5" cellpadding="5">
                     <tr>
                        <td width="100%" colspan="2">
                           <b> Terms:- </b><br>
                           1) YOU ARE REQUESTED TO MAKE THE BILLING TO OUR WORKS ADDRESS & SEND COPY TO OUR REGD. OFFICE ADDRESS.<br>
                           2) PLEASE ENSURE THE MATERIAL QUALITY & PROMP DELIVERY - ESSANCE OF THIS ORDER.<br>
                           3) TC & GC REQUIRED WITH SUPPLY. YOU`LL ENSURE GOOD QUALITY, STRENGHT & FINISH OF PRODUCT.<br>
                           4) PROPER HANDLING &PACKING TO AVOID VOID TRANSIT LOADING & UNLOADING SHIPMENT AND AVOID DAMAGE.<br>
                           5) P & F INCLUDED.<br>
                           6) GUARANTEE / WARRANTY: 18 MONTHS FROM THE DATE OF DISPATCH OR 12 MONTHS FROM THE DATE OF COMMISSIONING,<br>
                           WHICHEVER IS LATER.<br><br><br>
                        </td>
                     </tr>
                       <tr>
                        <td width="50%" align="left"><span >Discount&nbsp;:&nbsp;&nbsp;N.A.</span></td>
                        <td  width="50%"><span>Guarantee&nbsp;:&nbsp;&nbsp;(18/12) MONTHS</span></td>
                        </tr>
                         <tr>
                        <td width="50%" align="left"><span >Prices&nbsp;:&nbsp;&nbspEX WORKS.</span></td>
                        <td  width="50%"><span>Packing & Forwarding&nbsp;:&nbsp;&nbsp;N.A.</span></td>
                        </tr>
                          <tr>
                        <td width="50%" align="left"><span >Prices&nbsp;:&nbsp;&nbspEX WORKS.</span></td>
                        <td  width="50%"><span>Packing & Forwarding&nbsp;:&nbsp;&nbsp;N.A.</span></td>
                        </tr>
                         <tr>
                        <td width="50%" align="left"><span >Prices&nbsp;:&nbsp;&nbspEX WORKS.</span></td>
                        <td  width="50%"><span>Packing & Forwarding&nbsp;:&nbsp;&nbsp;N.A.</span></td>
                        </tr>
                         <tr>
                        <td width="50%" align="left"><span >Prices&nbsp;:&nbsp;&nbspEX WORKS.</span></td>
                        <td  width="50%"><span>Packing & Forwarding&nbsp;:&nbsp;&nbsp;N.A.</span></td>
                        </tr>
                         <tr>
                        <td width="50%" align="left"><span >Prices&nbsp;:&nbsp;&nbspEX WORKS.</span></td>
                        <td  width="50%"><span>Packing & Forwarding&nbsp;:&nbsp;&nbsp;N.A.</span></td>
                        </tr>
                        
                        <tr>
                        <td width="30%">
                           <span></span><br>
                           <span></span><br>
                           <span></span><br>
                           <span><?= $created_first_name." ".$created_last_name ?></span><br>
                           <span>Checked By</span><br>
                        </td >
                        <td width="30%">
                           <span></span><br>
                           <span></span><br>
                           <span></span><br>
                           <span><?= $created_first_name." ".$created_last_name ?></span><br>
                           <span>Checked By</span><br>
                        </td >
                        <td width="40%" align="center">
                           <span>Thanking you,</span><br>
                           <span>Your's Faithfully</span><br>
                           <span>For ENCON COOLING TOWERS PVT. LTD.</span><br>
                           <span>Sign</span><br>
                           <span>Authorised Signatory</span><br>
                        </td>
                     </tr>
            </table>
            </td>
         </tr>
          <tr class="">
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <strong style="margin-bottom: 0px;"> WORKS: PLOT NO. 109/110,H/2-1 SINNAR TALUKA AUDYOGIK VASAHAT MARYADLT MIDC SINNER POST MUSALGON , DIST.: NASHIK - 422 1031</strong>
            </td>
         </tr>
         
      </table>
   </body>
</html>
