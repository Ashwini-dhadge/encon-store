
<style>
    .table_innear{
    margin-left: auto;
    margin-right: auto;
      width: 50%;
}
</style>

<div class="table-responsive">
<table class="table table-bordered table_innear mx-auto" align="center">
  <thead>
    <tr>
      <th width="5%">#</th>
      <th>Item Name</th>
     
      <th>Total PO Qty</th>
      <th>Total PO Pending Qty</th>
       <th>Total PO Pending Qty</th>
    </tr>
  </thead>
  <tbody>
      <?php
            foreach($po_info_items as $key=>$value){
        ?>
         <tr class="table-active">
         <td><?= $key+1; ?></td>
         <td><?= $value['item_name']; ?></td>
         <td><?= $value['total_po_qty']; ?></td>
         <td><?= $value['received_qty']; ?></td>
         <td><?= $value['pending_qty']; ?></td>
         </tr>
        <?php
            }
      ?>
  </tbody>
</table>
</div>




