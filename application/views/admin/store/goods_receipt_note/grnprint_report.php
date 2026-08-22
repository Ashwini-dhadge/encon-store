<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Grn Report</title>
      <link href="<?= base_url() ?>assets/css/pages/card-page.css" rel="stylesheet" />
      <link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
      <style>
         .heading {
         font-size: 9px;
         text-align: center;
         margin-bottom: 0; /* Remove bottom margin */
         padding-bottom: 0; /* Remove bottom padding */
         font-weight: bold;
         }
         table {
         width: 100%;
         font-weight: bold;
         font-weight: bold;
         font-size: 9px;
         border-collapse: collapse;
         }
         th, td{
         border: none;
         padding: 5px;
         }
         .bordered th, .bordered td {
         border: 1px solid black;
         }
      </style>
      <style>
         @media print {
         #pdf-button {
         display: none;
         }
         }
      </style>
   </head>
   <body>
      <p class="heading" ><?= ucwords($compnay_name); ?><br><?= ucwords($company_address); ?><br><?= ucwords($site_name); ?><br> GOODS RECEIPT NOTE<br></p>
      <table style="width:100%; font-weight: bold;font-weight:bold;font-size: 9px;padding-left: 20px;">
         <tr>
            <th>Indent No:<?= isset($custom_inward_no)?$custom_inward_no :''; ?></th>
            <th>Arrival Date:</th>
            <th>GRN No:<?= isset($grn_no)?$grn_no :''; ?></th>
         </tr>
         <tr>
            <td>Indent Date:<?= isset($custom_inward_date)?dmyDate($custom_inward_date) :''; ?></td>
            <td>Unload Date:<?= isset($unload_date)?dmyDate($unload_date) :''; ?></td>
            <td>GRN Date:<?= isset($grn_date)?dmyDate($grn_date) :''; ?></td>
         </tr>
         <tr>
            <td>ENCON Ref No:</td>
            <td>Bill No:<?= isset($party_bill_no)?$party_bill_no :''; ?></td>
            <td>Gate Pass No:<?= isset($gate_pass_no)?$gate_pass_no :''; ?></td>
         </tr>
         <tr>
            <td>P.Order No:<?= isset($po_date)?dmyDate($po_date) :''; ?></td>
            <td>Bill Date:<?= isset($bill_date)?dmyDate($bill_date) :''; ?></td>
            <td>Time In:<?= isset($grn_time)?$grn_time :''; ?></td>
         </tr>
         <tr>
            <td>P.Order Date:<?= isset($po_date)?dmyDate($po_date) :''; ?></td>
            <td></td>
            <td>Lab. No:<?= isset($lab_report_no)?$lab_report_no :''; ?></td>
         </tr>
         <tr>
            <td>Vendor Name:<?= isset($account_name)?$account_name :''; ?></td>
            <td></td>
            <td>Challan No:<?= isset($challan_no)?$challan_no :''; ?></td>
         </tr>
         <tr>
            <td>Transport:<?= isset($transport_name)?$transport_name :''; ?></td>
            <td></td>
            <td>Driver Name:<?= isset($driver_name)?$driver_name :''; ?></td>
         </tr>
         <tr>
            <td>LR No./Dt:<?= isset($lr_no)?$lr_no :''; ?><?= isset($lr_date)?dmyDate($lr_date) :''; ?></td>
            <td></td>
            <td>RST No:<?= isset($rst_no)?$rst_no :''; ?></td>
         </tr>
         <tr>
            <td>Mnl. Slip No:<?= isset($manual_slip_no)?$manual_slip_no :''; ?></td>
            <td></td>
            <td>Packing Forwarding Amount :<?= isset($packing_forwarding_amount)?$packing_forwarding_amount :''; ?></td>
         </tr>
         <tr>
            <td>Vehicle No:<?= isset($vehicle_no)?$vehicle_no :''; ?></td>
            <td></td>
            <td></td>
         </tr>
      </table>
      <br><br>
      <table class="bordered">
         <tr>
            <th style="width:2%">Sr</th>
            <th style="width:4%">Item Code</th>
            <th style="width:20%" align="left">Description</th>
            <th style="width:4%">Unit</th>
            <th style="width:4%">Rate</th>
            <th style="width:5%">PO Qty(A)</th>
            <th style="width:5%">Challan Qty</th>
            <th style="width:6%">Total Received Qty(B)</th>
            <th style="width:5%">Already Recv. Qty earlier GRN in Linked Po(C)</th>
            <th style="width:5%">Return Qty(D)</th>
            <th style="width:5%">Net Received Qty E=(B-D)</th>
            <th style="width:6%">GRN Amount</th>
            <th style="width:5%">TotalRecv.Qty till date in Link PO F=(C+E)</th>
            <th style="width:6%">Balance Qty G=(A-F)</th>
            <th style="width:7%">Tax Amount</th>
            <th style="width:9%">NetAmount After PO Tax & PO Discount</th>
         </tr>
         <?php  
            $totalItemQty = $totalreceiedQty=$totalgrnamt=$totaltaxamt=$totalpotaxamt=$total_item_po_qty1=$totalSubgrnamt=0;
            foreach($grn_item_details_data as $key=>$value) {
               
                $totalItemQty += $value['total_aginst_po'];
                $totalreceiedQty += $value['received_qty'];
                $totalgrnamt += $value['item_amount'];
                $totalSubgrnamt += $value['item_sub_amount'];
                $totaltaxamt += $value['grn_txt_value'];
                $totalpotaxamt += $value['tax_value'] + $value['item_discount_amount'];
                $total_item_po_qty1 += $value['total_aginst_po'];
            ?>
         <tr>
            <td align="center"><?= $key+1; ?></td>
            <td align="center"><?= $value['item_code']; ?></td>
            <td align="left"><?= $value['item_name']; ?>
               <?php
                  if(isset($value['warranty_description'])&& !empty($value['warranty_description'])){
                      echo "<br><b>Warranty Description</b>:".$value['warranty_description'];
                  }
                  if(isset($value['other_description'])&& !empty($value['other_description'])){
                      echo "<br><b>Other Desc.</b>:".$value['other_description'];
                  }
                   if(isset($value['technical_description']) && !empty($value['technical_description'])){
                      echo "<br><b>Technical Desc.</b>:".$value['technical_description'];
                  }
                  ?>
            </td>
            <td align="center"><?= $value['unit_name']; ?></td>
            <td align="center"><?= $value['item_rate']; ?></td>
            <td align="center"><?= $value['total_aginst_po']; ?></td>
            <td align="center"><?= $value['po_challan_quantity']; ?></td>
            <td align="center"><?= $value['received_qty']; ?></td>
            <td align="center"><?= $value['earlier_receive_qty']; ?></td>
            <td align="center"><?= $value['item_return_qty']; ?></td>
            <?php
               $netrecived = $value['received_qty'] - $value['item_return_qty'];
               ?>
            <td align="center"><?= $netrecived ?></td>
            <td align="center"><?= $value['item_sub_amount']; ?></td>
            <?php
               $totalrecived = $netrecived+ $value['earlier_receive_qty'];;?>
            <td align="center"><?=  $totalrecived; ?></td>
            <?php
               $balenceqty = $value['total_aginst_po']-$totalrecived;?>
            <td align="center"><?= $balenceqty;?></td>
            <td align="center">
               GST@<?= $value['grn_txt_rate']; ?>%
               <p class="no-margin-bottom"></p>
               <?= $value['grn_txt_value']; ?>
            </td>
            <td align="center" >
               <div class="horizontal-partition" style="border-bottom: 1px solid #ddd;">
                  <p class="no-margin-bottom"> <?= isset($value['item_amount'])?$value['item_amount']:"-"; ?></p>
               </div>
               <!-- Second partition -->
               <p class="no-margin-bottom"><?= $value['item_amount']+$value['grn_txt_value']; ?></p>
            </td>
         </tr>
         <?php }?>
         <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">TOTAL</td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"><?= $total_item_po_qty1; ?></td>
            <td align="center"></td>
            <td align="center"><?= $totalreceiedQty; ?></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"><?= $totalSubgrnamt; ?></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"><?= $totaltaxamt; ?></td>
            <td align="center"> <?= isset($value['item_amount'])?$value['item_amount']:"-"; ?></td>
         </tr>
         <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">TOTAL WITH GST@</td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"><?= $total_item_po_qty1; ?></td>
            <td align="center"></td>
            <td align="center"><?= $totalreceiedQty; ?></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"><?= $totalSubgrnamt; ?></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"><?= $totaltaxamt; ?></td>
            <td align="center"><?= $value['landed_cost_final_amount']; ?></td>
         </tr>
         <!-- Add more rows here -->
      </table>
      <br><br><br>
      <table style="width:100%; font-weight: bold;font-weight:bold;font-size: 9px;">
         <tr>
            <th><?php echo (isset($created['first_name']) && isset($created['last_name'])) ? ($created['first_name'] . ' ' . $created['last_name']) : ''; ?><br>Prepared By :</th>
            <th><?php if(isset($received['first_name']) && isset($received['last_name'])) {echo $received['first_name'] . ' ' . $received['last_name'];
               }?><br>Received By</th>
            <th><?= isset($first_name)?$first_name :'';; ?> <?= isset($last_name)?$last_name :'';; ?> <br>Despatched By</th>
            <th><?php echo (isset($checked['first_name']) && isset($checked['last_name'])) ? ($checked['first_name'] . ' ' . $checked['last_name']) : '<br>'; ?><br>Checked By</th>
            <th><br><br>Authorised Signatory</th>
            <th><?php echo (isset($created['first_name']) && isset($created['last_name'])) ? ($created['first_name'] . ' ' . $created['last_name']) : ''; ?> <br>Created By</th>
            <th ><?php echo (isset($remark) && isset($remark)) ? ($remark) : ''; ?><br>Remark</th>
         </tr>
      </table>
   </body>
</html>