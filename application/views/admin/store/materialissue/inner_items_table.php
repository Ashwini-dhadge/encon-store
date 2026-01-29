
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
      <th>Unit Name</th>
      <th>Batch No </th>
      <th>Expired Date</th>
      <th>Issue Qty </th>
      <th>Rate</th>
      <th>Amount</th>
      <th>Remark</th>
    </tr>
  </thead>
  <tbody>
      <?php
            foreach($items as $key=>$value){
        ?>
         <tr class="table-active">
         <td><?= $key+1; ?></td>
         <td><?= $value['item_name']; ?></td>
          <td><?= $value['unit_name']; ?></td>
         <td><?= $value['batch_no']; ?></td>
         <td><?= $value['expired_date']; ?></td>
         <td><?= $value['issue_qty']; ?></td>
         <td><?= $value['rate']; ?></td>
         <td><?= $value['amount']; ?></td>
            <td><?= $value['remark']; ?></td>
         </tr>
        <?php
            }
      ?>
  </tbody>
</table>
</div>

 
 