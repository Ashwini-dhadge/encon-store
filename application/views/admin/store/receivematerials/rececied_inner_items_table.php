


<div class="table-responsive">
<table class="table table-bordered table_innear mx-auto" align="center">
  <thead>
    <tr>
      <th width="5%">#</th>
      <th>Item Name</th>
      <th>Unit</th>
      <th>Batch No</th>
      <th>Expired Date </th>
     
      <th>Recevied Qty</th>
      
      <th>Remark</th>
      
    </tr>

  </thead>
  <tbody>
      <?php
            foreach($material as $key=>$value){
                   if(isset($value['received_qty']) && $value['received_qty'] !=0){
                        $received_qty=$value['pending_qty'];
                    }else{
                        $received_qty=$value['issue_qty'];
                    }
        ?>
         <tr class="table-active">
         <td><?= $key+1; ?></td>
         <td><?= $value['item_name']; ?></td>
         <td><?= $value['unit_name']; ?></td>
         <td><?= $value['batch_no']; ?></td>
         <td><?= $value['expired_date']; ?></td>
           <td><?= $received_qty; ?></td>
         <td><?= $value['remark']; ?></td>
         </tr>
        <?php
            }
      ?>
  </tbody>
</table>
</div>

