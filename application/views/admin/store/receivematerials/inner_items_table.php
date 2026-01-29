


<div class="table-responsive">
<table class="table table-bordered table_innear mx-auto" align="center">
  <thead>
    <tr>
      <th width="5%">#</th>
      <th>Item Name</th>
      <th>Unit</th>
      <th>Recevied Qty</th>
      
    </tr>
  </thead>
  <tbody>
      <?php
            foreach($material as $key=>$value){
        ?>
         <tr class="table-active">
         <td><?= $key+1; ?></td>
         <td><?= $value['item_name']; ?></td>
         <td><?= $value['unit_name']; ?></td>
         <td><?= $value['received_qty']; ?></td>
         </tr>
        <?php
            }
      ?>
  </tbody>
</table>
</div>
