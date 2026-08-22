        
        <?php  $i = 1; foreach($item_rate_updated_data as $update_rate) { ?>
            <tr  style="font-size:11px">
                <td style="color:white;"><span></span><?= $i; ?></td>
                <td style="color:white;"><span></span><?= $update_rate['po_order_no']; ?></td>
                 <td style="color:white;"><?= $update_rate['vendor_name']; ?></td>
                <td style="color:white;"><span></span><?= $update_rate['unit_name']; ?></td>
                <td style="color:white;"><span></span><?= $update_rate['item_rate']; ?></td>
            </tr>
        <?php $i++; }?>
                                        
                                            