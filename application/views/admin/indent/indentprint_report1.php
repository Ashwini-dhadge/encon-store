<!DOCTYPE html>
<html>
   <style>
   #terms_condition p{
       margin-top:5px !important;
        margin-bottom:5px !important;
   }
    li {
            line-height: 1.5; /* Adjust line height as needed */
        }
   </style>
   <head>
      <meta charset="utf-8" />
      <title></title>
   </head>
   <body>
     <?php  $count_plant_id=1;$total_qty=0; if (isset($indent_specific_data[0])): ?>
     
     
    
      <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
         <tr class="">
            <td  width="20%" >
               <span ><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($indent_specific_data[0]['left_image'])?$indent_specific_data[0]['left_image']:'no_images.png';?>" height="52" /></span>
            </td>
            <td width="60%" style="text-align:center;">
               <span style="font-size:12px;" ><strong>Encon Group of Companies<br>
               </strong><span style="font-size:9px;font-weight: bold;" ><?= isset($indent_specific_data[0]['address'])?$indent_specific_data[0]['address']:''; ?></span><br>
               <!-- <span style="font-size:9px;font-weight: bold;" >LTD. GOREGAON (WEST), MUMBAI - 400104.</span><br> -->
               <span style="font-size:9px;font-weight: bold;" >Email Id - <?= isset($indent_specific_data[0]['company_email'])?$indent_specific_data[0]['company_email']:''; ?></span>
             </span>
            </td>
            <td   width="20%" style="text-align:center;">
               <!-- <span ><img src="<//?= base_url() ?>/assets/images/encon.jpg" height="40" /></span><br> -->
               <span ><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($indent_specific_data[0]['right_image'])?$indent_specific_data[0]['right_image']:'no_images.png';?>" height="52" /></span>

            </td>

         </tr>

         <tr class="">
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
               <span style="font-size:10px;"><strong>INDENT INFORMATION</strong></span>
            </td>
         </tr>
          
         <tr class="">
            <td colspan="3">
               <table width="100%">
                  <tr>
                     <td  width="15%" align="left">
                        <span ><strong>Party Name </strong></span>
                     </td>
                     <td  width="5%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="30%" align="left">
                        <span ><strong><?= isset($indentviewData['client_name'])? $indentviewData['client_name'] :''; ?></strong></span>
                     </td>
                     
                     <td  width="20%" align="left">
                        <span ><strong>Plant Name </strong></span>
                     </td>
                     <td  width="1%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="20%" align="left">
                        <span ><strong><?= isset($indent_specific_data[0]['site_name'])? $indent_specific_data[0]['site_name'] :''; ?></strong></span>
                     </td>
                     
                  </tr>
                 <tr>
                     <td  width="15%" align="left">
                        <span ><strong>Delivery Date </strong></span>
                     </td>
                     <td  width="5%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="30%" align="left">
                        <span ><strong><?= isset($indentviewData['delivery_date'])? $indentviewData['delivery_date'] :''; ?></strong></span>
                     </td>
                     <td  width="20%" align="left">
                        <span ><strong>Indent Date</strong></span>
                     </td>
                     <td  width="1%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="20%" align="left">
                        <span ><strong><?= isset($indentviewData['date'])? $indentviewData['date'] :''; ?></strong></span>
                     </td>
                    
                  </tr>
                  <tr>
                     <td  width="15%" align="left">
                        <span ><strong>Mannual Indent No </strong></span>
                     </td>
                     <td  width="5%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="30%" align="left">
                        <span ><strong><?= isset($indentviewData['indent_number'])? $indentviewData['indent_number'] :''; ?></strong></span>
                     </td>
                     <td  width="20%" align="left">
                        <span ><strong>Indent No </strong></span>
                     </td>
                     <td  width="1%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="20%" align="left">
                        <span ><strong><?= isset($indentviewData['indent_no'])? $indentviewData['indent_no'] :''; ?></strong></span>
                     </td>
                     
                  </tr>
                  
               </table>
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
                           <strong>SR.No</strong>
                        </td>
                        <td style="border: 1px solid  #000;" width="20%">
                           <strong>SITE NAME</strong>
                        </td>
                        <td style="border: 1px solid  #000;" width="10%">
                           <strong>INDENT FOR</strong>
                        </td>
                        
                        <td colspan="2" style="border: 1px solid  #000;" width="45%">
                           <strong>DESCRIPTION</strong>
                        </td>
                        
                        <td style="border: 1px solid  #000;" width="9%">
                          <strong> QTY</strong>
                        </td>
                        <td style="border: 1px solid  #000;" width="10%">
                          <strong> Date</strong>
                        </td>
                       
                     </tr>
                     
                      <?php 
                        
                        foreach ($indent_specific_data as $key => $value1):
                            
                      ?>
                    <tr nobr="true">
                     <td align="center"  valign="middle" rowspan="<?= $value1['field_count'] ?>" style="border: 1px solid  #000;"><?php echo $offset + ($key + 1); ?></td>
                     <?php
                           
                            if($count_plant_id==1){
                                $total_indent_type=$value1['site_count'];
                                 
                     ?>
                     <td align="center"  valign="middle" rowspan="<?= $value1['site_total_indent_count'] ?>" style="border: 1px solid  #000;font-size:9px;"><?php echo $value1['site_name']; ?></td>
                     <?php
                        }
                        if($total_indent_type==$count_plant_id){
                             $count_plant_id=1;
                        }else{
                             $count_plant_id=$count_plant_id+1;
                        }
                      ?>
                    
                     <td align="center"   valign="middle" rowspan="<?= $value1['field_count'] ?>" style="border: 1px solid  #000;font-size:9px;"><?php echo $value1['indent_name']; ?></td>
                      


                         <?php
                           $sub_tbl_data = $this->CommonModel->getData($value1['db_table_name'], array('id' => $value1['ref_id']), '', '', 'row_array');
                           if (!empty($sub_tbl_data)){
                                 $count=0;
                               foreach ($sub_tbl_data as $key => $value) {
                                     
                                 if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
                                          $qty = isset($sub_tbl_data[$value1['db_qty_field_name']]) ? $sub_tbl_data[$value1['db_qty_field_name']] : 0;  
                                         
                                          if($count!=0){
                                                  echo " <tr>";
                                             }
                                       ?>
                       <td  valign="middle" style="border: 1px solid  #000;"><?php echo ucfirst(str_replace("_", " ", $key)); ?></td>
                        <td valign="middle" style="border: 1px solid  #000;"><?php echo $value; ?></td>
                          <?php 
                           if($count!=0){
                              echo " </tr>";
                           }
                           
                           if($count==0){
                                 $total_qty=$total_qty+(int)$qty;
                        ?>
                      <td align="center" rowspan="<?= $value1['field_count'] ?>" style="border: 1px solid  #000;"><?php echo $qty; ?></td>
                      <td align="center" rowspan="<?= $value1['field_count'] ?>" style="border: 1px solid  #000;"><?php echo dmyDateTime($value1['created_at']); ?></td>
                    </tr>
                    <?php
                        }//count                             
                        $count=$count+1;
                        }
                        }//forech
                        }
                        endforeach;
                        ?>
                     <tr>
                         <td colspan="5"  style="border: 1px solid  #000;"> <strong>Qty Total :</strong> </td>
                           <td align="right"  style="border: 1px solid  #000;"> <strong><?= $total_qty; ?> </strong></td>
                     </tr>
                     
                      


                </table>
            </td>
         </tr>
         
         <tr class="">
            <td colspan="3" align="left" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" ><strong>
              <table cellspacing="5" cellpadding="5">
                        <tr>
                        <td width="30%">
                          <!--  <span></span><br> -->
                           <!-- <span></span><br> -->
                           <span></span><br>

                           <span><?= $indent_specific_data[0]['first_name']." ".$indent_specific_data[0]['last_name'] ?></span><br>
                           <span>Checked By</span>
                        </td >
                        <td width="30%">
                           <span></span><br>
                             <span><?= $indent_specific_data[0]['first_name']." ".$indent_specific_data[0]['last_name'] ?></span><br>
                          
                           <span>Approved By</span>
                        </td >
                        <td width="40%" align="center">
                          

                        </td>
                     </tr>
            </table>
            </strong>
            </td>
         </tr>
          <tr class="">
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
                <strong style="margin-bottom: 0px;">WORKS: <?= isset($indent_specific_data[0]['site_address'])?$indent_specific_data[0]['site_address']:'';?></strong>
            </td>
         </tr>
         
      </table>
        <?php endif; ?>
   </body>
</html>
