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
         <span class="sub_header"><?= isset($company_name['name'])?$company_name['name']:'' ?>:</span>
         <span class="sub_header"><?= isset($site_name['site_name'])?$site_name['site_name']:'' ?>:</span>
         <span class="head_desc">
          
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
 <?php
foreach ($item_detail as $key_g => $group): 
?>
<tr>
    <td colspan="12" class="item-group">Item Group: <?= $group['item_group_name']; ?></td>
</tr>
<?php
    $opening_total_qty = $total_received_qty = $total_issued_qty = $total_balance = $total_stock_amt = 0;
    foreach ($group['items'] as $key_i => $item):
        $opening_total_qty   += $item['balance'];
        $total_received_qty  += $item['total_received'];
        $total_issued_qty    += $item['total_issued'];
        $total_balance       += $item['closing_qty'];
        $total_stock_amt     += $item['closing_amount'];
?>
<tr class="item_name">
    <td><?= $key_i + 1; ?></td>
    <td><?= $item['item_code']; ?></td>
    <td colspan="2"><?= $item['item_name']; ?></td>
    <td></td>
    <td><?= $item['unit_name']; ?></td>
    <td><?= number_format($item['balance'], 2); ?></td>
    <td><?= number_format($item['total_received'], 2); ?></td>
    <td><?= number_format($item['total_issued'], 2); ?></td>
    <td><?= number_format($item['closing_qty'], 2); ?></td>
    <td style="text-align:right;"><?= number_format($item['closing_amount'], 2); ?></td>
</tr>
<?php endforeach; ?>
<tr class="item_footer">
    <td></td>
    <td></td>
    <td colspan="4">Grand Total:</td>
    <td><?= number_format($opening_total_qty, 2); ?></td>
    <td><?= number_format($total_received_qty, 2); ?></td>
    <td><?= number_format($total_issued_qty, 2); ?></td>
    <td><?= number_format($total_balance, 2); ?></td>
    <td style="text-align:right;"><?= number_format($total_stock_amt, 2); ?></td>
</tr>
<?php endforeach; ?>

         
      </table>
   </body>
</html>