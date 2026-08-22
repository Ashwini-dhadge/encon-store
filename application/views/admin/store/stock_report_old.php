<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Simple HTML Page</title>
      <style>
         body {
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         font-weight: 400px;
         }
         .container {
         /*  border: 2px solid #000; */
         padding: 20px;
         }
         .heading {
         font-size: 15px;
         text-align: center;
         margin-bottom: 0; /* Remove bottom margin */
         padding-bottom: 0; /* Remove bottom padding */
         }
         .date{
         font-size: 10px;
         }
         .sub_header{
         font-size: 9px;
         align-items:right;
         font-weight: bold;
         text-decoration: underline;
         }
         .head_desc{
         font-size: 9px;
         }
         table, th, td {
         border: 1px solid black;
         border-collapse: collapse;
         margin-top: 0; /* Remove top margin */
         padding-top: 0; /* Remove top padding */
         }
         .item-group {
         font-weight: bold;
         font-size: 8px;
         }
         .item_name{
         font-size: 10px;
         }
         .tbl_head{
         font-weight: bold;
         font-size: 9px;
         }
         .item_footer{
         font-size: 10px;
         font-weight: bold;
         color: #0000FF;
         }
      </style>
   </head>
   <body>
      <!--   <div class="container">
         -->    
      <p class="heading">Stock Register Item Wise Report<br><span class="date">From Date:<?php echo date('d F Y', strtotime($from_date_formatted)); ?> To Date:<?php echo date('d F Y', strtotime($to_date_formatted)); ?> </span></p>
      <p>
         <span class="sub_header">ENCON INTERNATIONAL:</span>
         <span class="head_desc">
            <!-- <?php echo $item_detail[0]['site_name']; ?><br> -->
            <?php
               if (!empty($item_detail)) {
                  
                   echo $item_detail[0]['site_name'];
               } else {
                   
                   echo "No data available";
               }
               ?><br>
            <?php
               if (!empty($item_detail) && isset($item_detail[0]['item_group_name'])) {
                  
                   echo "Item Group: - " . $item_detail[0]['item_group_name'];
               } else {
                  
                   echo "";
               }
               ?>
         </span>
      </p>
      <table style="width:100%;font-size: 10px;">
         <tr class="tbl_head">
            <th>Sr</th>
            <th  >Item<br>Code</th>
            <th colspan="2">Particular / Item</th>
            <th></th>
            <th>Stock<br>Qty</th>
            <th>Opening</th>
            <th>Received</th>
            <th>Issued</th>
            <th colspan="2">Balance</th>
         </tr>
         <tr class="tbl_head">
            <th></th>
            <th ></th>
            <th colspan="2"></th>
            <th></th>
            <th>Unit</th>
            <th>Stock Qty uptoDate</th>
            <th>Stock Qty uptoDate</th>
            <th>Stock Qty uptoDate</th>
            <th>Stock Qty uptoDate</th>
            <th>Stock Amt uptoDate</th>
         </tr>
         <tr>
            <td colspan="12" class="item-group">Item Group : WHEEL</td>
         </tr>
         <?php $row_number = 1; ?>
         <?php foreach ($item_detail as $item): ?>
         <tr class="item_name">
            <td><?php echo $row_number; ?></td>
            <td><?php echo $item['item_code']; ?></td>
            <td colspan="2"><?php echo $item['item_name']; ?></td>
            <td></td>
            <td><?php echo $item['unit_name']; ?></td>
            <td><?php echo $item['qty']; ?></td>
            <td><?php echo $item['received_quantity']; ?></td>
            <td><?php echo $item['issued_quantity']; ?></td>
            <td><?php echo $item['qty'] + $item['received_quantity'] - $item['issued_quantity']; ?></td>
            <td style="text-align:right;"><?php echo $item['item_rate'] * ($item['qty'] + $item['received_quantity'] - $item['issued_quantity']); ?>.00</td>
            <!-- <td></td>
               <td></td> -->
         </tr>
         <?php $row_number++; ?>
         <?php endforeach; ?>
         <tr>
            <td colspan="12" class="item-group">Item Group : PRIMER</td>
         </tr>
         <tr class="item_name">
            <td></td>
            <td></td>
            <td colspan="2"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="item_footer">
            <td> </td>
            <td> </td>
            <td colspan="4">Grand Total:</td>
            <?php
               $opening_total_qty = 0; 
               foreach ($item_detail as $item):
                   $opening_total_qty += $item['qty']; 
               endforeach;
               ?>
            <td><?php echo $opening_total_qty; ?></td>
            <?php
               $total_received_qty = 0;
               foreach ($item_detail as $item) {
                   $total_received_qty += $item['received_quantity'];
               }
               
               ?>
            <td><?php echo $total_received_qty; ?></td>
            <?php
               $total_issued_qty = 0;
               foreach ($item_detail as $item) {
                   $total_issued_qty += $item['issued_quantity'];
               }
               
               ?>
            <td><?php echo $total_issued_qty; ?></td>
            <?php 
               $total_balance = 0; 
               
               foreach ($item_detail as $item) { 
                   $balance = $item['qty'] + $item['received_quantity'] - $item['issued_quantity'];
                   $total_balance += $balance;
                   }
               ?>
            <td><?php echo $total_balance; ?></td>
            <?php 
               $total_stock_amt = 0;
               
               foreach ($item_detail as $item) { 
                 
                   $stock_amt = $item['item_rate'] * ($item['qty'] + $item['received_quantity'] - $item['issued_quantity']);
                   
                   
                   $total_stock_amt += $stock_amt;
               }
               ?>
            <td style="text-align:right;"><?php echo $total_stock_amt; ?></td>
            <td></td>
            <!-- <td colspan="2">54654</td> -->
         </tr>
      </table>
   </body>
</html>