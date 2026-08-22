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
     <?php foreach ($indent_specific_data as $indentId => $indentData): ?>
     
     <?php
        if($indentId!=0){
    ?>
     <p style="page-break-before: always;"></p>
    <?php
        }
     ?>
    
      <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
         <tr class="">
            <td  width="20%" >
               <span ><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($indentData['left_image'])?$indentData['left_image']:'no_images.png';?>" height="52" /></span>
            </td>
            <td width="60%" style="text-align:center;">
               <span style="font-size:12px;" ><strong>Encon Group of Companies<br>
               </strong><span style="font-size:9px;font-weight: bold;" ><?= isset($indentData['address'])?$indentData['address']:''; ?></span><br>
               <!-- <span style="font-size:9px;font-weight: bold;" >LTD. GOREGAON (WEST), MUMBAI - 400104.</span><br> -->
               <span style="font-size:9px;font-weight: bold;" >Email Id - <?= isset($indentData['company_email'])?$indentData['company_email']:''; ?></span>
             </span>
            </td>
            <td   width="20%" style="text-align:center;">
               <!-- <span ><img src="<//?= base_url() ?>/assets/images/encon.jpg" height="40" /></span><br> -->
               <span ><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($indentData['right_image'])?$indentData['right_image']:'no_images.png';?>" height="52" /></span>

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
                        <span ><strong><?= isset($indentData['site_name'])? $indentData['site_name'] :''; ?></strong></span>
                     </td>
                     
                  </tr>
                 <tr>
                     <td  width="15%" align="left">
                        <span ><strong>Plant Name </strong></span>
                     </td>
                     <td  width="5%" align="left">
                        <span ><strong>:&nbsp;</strong></span>
                     </td>
                      <td  width="30%" align="left">
                        <span ><strong><?= isset($indentviewData['plant_narration'])? $indentviewData['plant_narration'] :''; ?></strong></span>
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
                        <span ><strong> </strong></span>
                     </td>
                     <td  width="1%" align="left">
                        <span ><strong>&nbsp;</strong></span>
                     </td>
                      <td  width="20%" align="left">
                        <span ><strong></strong></span>
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
                        <td style="border: 1px solid  #000;" width="30%">
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
                        $total_qty=0;
                      foreach ($indentData['indent_details'] as $key => $value1):
                           
                      ?>
                    <tr nobr="true">
                     <td align="center"  valign="middle" rowspan="<?= $value1['field_count'] ?>" style="border: 1px solid  #000;"><?php echo $offset + ($key + 1); ?></td>
                     <td align="center" valign="middle" rowspan="<?= $value1['field_count'] ?>" style="border: 1px solid  #000;font-size:9px;"><?php echo $value1['indent_name']; ?></td>


                         <?php
                           $sub_tbl_data = $this->CommonModel->getData($value1['db_table_name'], array('id' => $value1['ref_id']), '', '', 'row_array');
                           if (!empty($sub_tbl_data)){
                                 $count=0;
                               foreach ($sub_tbl_data as $key => $value) {
                                     
                                 if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
                                          $qty = isset($sub_tbl_data[$value1['db_qty_field_name']]) ? $sub_tbl_data[$value1['db_qty_field_name']] : 0;  
                                           $total_qty=$total_qty+(int)$qty;
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

                           <span><?= $indentData['first_name']." ".$indentData['last_name'] ?></span><br>
                           <span>Checked By</span>
                        </td >
                        <td width="30%">
                           <span></span><br>
                             <span><?= $indentData['first_name']." ".$indentData['last_name'] ?></span><br>
                          
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
                <strong style="margin-bottom: 0px;">WORKS: <?= isset($indentData['site_address'])?$indentData['site_address']:'';?></strong>
            </td>
         </tr>
         
      </table>
        <?php endforeach; ?>
   </body>
</html>
