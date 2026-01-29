
                                        <?php $i = 1; foreach($termconditions as $terms) { ?>
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                                                <!--  <input type="checkbox" class="custom-control-input" id="checkbox<?= $i; ?>" name="forannexure[]" value="<?= $i; ?>" > -->
                                                        <!-- <label class="custom-control-label" for="checkbox<?= $i; ?>">For Annexure</label>  -->

                                                       <!-- <input type="checkbox" class="custom-checkbox" data-id="termsConditions" > -->
                                                         
                                                                   <!--  <input type="checkbox" class="custom-checkbox" id="checkbox' . $i . '" data-id="' . $terms['id'] . '" name=""> -->
                                                        <?php 
                                                            if($terms['is_default'] == 1) { ?>
                                                                <input type="checkbox" class="custom-checkbox-checked" id="checkbox<?= $i; ?>" data-title="<?= $terms['title']; ?>"  data-particulars="<?= $terms['particulars'];?>" disabled checked  name=""> 
                                                            <?php }else{ ?>
                                                                <input type="checkbox" class="custom-checkbox-checked" id="checkbox<?= $i; ?>" data-title="<?= $terms['title']; ?>"  data-particulars="<?= $terms['particulars']; ?>"   name=""> 
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td><?= $i; ?></td>
                                                <td><?= $terms['title']; ?></td>
                                                <td class="text-nowrap"><?= $terms['particulars']; ?></td>
                                            </tr>
                                        <?php $i++; }?>
                                        
                                            