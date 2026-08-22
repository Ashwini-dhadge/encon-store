<!DOCTYPE html>
<html>
    <style>
    #terms_condition p{
        margin-top:5px !important;
        margin-bottom:5px !important;
    }
    #tech td{
        padding: 5px;
        background-color: #000 !important;
    }   
    
    </style>
    <head>
        <meta charset="utf-8" />
        <title>A simple, clean, and responsive HTML invoice template</title>
    </head>
    <body>
        <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="3">
            <tr class="">
            <td  width="20%" >
                <span ><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($company_master_data['left_image'])?$company_master_data['left_image']:'no_images.png';?>" height="40" /></span>
            </td>
            <td width="60%" style="text-align:center;">
                <span style="font-size:12px;" ><strong><?= isset($company_master_data['name'])?$company_master_data['name']:''; ?><br>
                </strong><span style="font-size:9px;font-weight: bold;" ><?= isset($company_master_data['address'])?$company_master_data['address']:''; ?></span><br>
                <!-- <span style="font-size:9px;font-weight: bold;" >LTD. GOREGAON (WEST), MUMBAI - 400104.</span><br> -->
                <span style="font-size:9px;font-weight: bold;" >Email Id - <?= isset($company_master_data['email'])?$company_master_data['email']:''; ?></span>
                </span>
            </td>
            <td   width="20%" style="text-align:center;">
                <!-- <span ><img src="<//?= base_url() ?>/assets/images/encon.jpg" height="40" /></span><br> -->
                <span ><img src="<?= base_url() ?>assets/uploads/company_logo/<?= isset($company_master_data['right_image'])?$company_master_data['right_image']:'no_images.png';?>" height="40" /></span>

            </td>

            </tr>

            <tr class="">
            <td colspan="3">
                <table>
                    <tr>
                        <td  width="30%">
                        <span ><strong>PAN No:&nbsp; <?= isset($company_master_data['pan_no'])? $company_master_data['pan_no'] :''; ?></strong></span>
                        </td>
                        <td width="40%" align="center">
                        <span ><strong>ARN No:&nbsp; <?= isset($company_master_data['arn_no'])? $company_master_data['arn_no'] :''; ?></strong></span>
                        </td>
                        <td width="30%" align="right">
                            <span ><strong>GST No:&nbsp; <?= isset($company_master_data['gst_no'])? $company_master_data['gst_no'] :''; ?></strong></span>

                        </td>
                    </tr>
                </table>
            </td>
            </tr>
            <tr class="" style="background-color: #f2f2f2;">
                <td colspan="3"  align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;"> 
                    <span style="font-size:10px;"><strong>QUOTATION</strong></span>
                </td>
            </tr>
            <tr class="" style="background-color: #fff; ">
                <td colspan="1" align="center" style="border-left:1px solid #000"><strong><?= isset($quotationData[0]['order_no'])?$quotationData[0]['order_no'] :''; ?> </strong>
                </td>
                <td align="center" style="background-color: #fff; "> 
                    
                </td>
                <td style="border-right:1px solid #000"><strong>Estimate Date </strong>: <?= isset($quotationData[0]['estimated_date'])?$quotationData[0]['estimated_date'] :''; ?>
                </td>
            </tr>
            <tr class="" style="border-style:hidden;" >
                <td colspan="3" align="left" >
                    <table >
                    <?//= print_r($quotationData) ?>
                        <tr>
                                <td width="40%">
                                    <strong>To&nbsp;,</strong> <br>
                                    <strong><?= isset($customerDetails[0]['company_name'] )?$customerDetails[0]['company_name']  :''; ?></strong> &nbsp;<br>
                                    <?= isset($customerDetails[0]['address'])?$customerDetails[0]['address'] :''; ?><br>
                                    <?= isset($pincode)?$pincode :''; ?>
                                    <?= isset($customerDetails[0]['phone'])?$customerDetails[0]['phone'] :''; ?><br>
                                    <?= isset($customerDetails[0]['email'])?$customerDetails[0]['email'] :''; ?><br>
                                    <!-- State  :<?//= isset($state_name)?$state_name :''; ?><br>
                                    City  :<?//= isset($state_name)?$state_name :''; ?><br>
                                    Email &nbsp;: <?//= isset($contact_person_email)?$contact_person_email :''; ?><br>
                                    PH.&nbsp;: <?//= isset($contact_person_mobile_no)?$contact_person_mobile_no :''; ?>,<br>
                                    GSTIN/UID: <?//= isset($gst_no)?$gst_no :''; ?> -->
                                </td>
                                <td align="left">
                                    <strong>Billing Address&nbsp;:-</strong> <br>
                                    <strong><?= isset($customerBillingShippingDetails[0]['billing_company'] )?$customerBillingShippingDetails[0]['billing_company']  :''; ?></strong> &nbsp;<br>
                                    <?= isset($customerBillingShippingDetails[0]['b_street'])?$customerBillingShippingDetails[0]['b_street'] :''; ?><br>
                                    
                                    <?= isset($b_city_data[0]['name'])?$b_city_data[0]['name'] :''; ?> -
                                    <?= isset($customerBillingShippingDetails[0]['b_post_code'])?$customerBillingShippingDetails[0]['b_post_code'] :''; ?><br>
                                    <?= isset($b_state_data[0]['name'])?$b_state_data[0]['name'] :''; ?>,
                                    <?= isset($b_country_data[0]['name'])?$b_country_data[0]['name'] :''; ?>
                                </td>

                                <td>
                                    <strong>Shipping Address&nbsp;:-</strong> <br>
                                    <strong><?= isset($customerBillingShippingDetails[0]['billing_company'] )?$customerBillingShippingDetails[0]['billing_company']  :''; ?></strong> &nbsp;<br>
                                    <?= isset($customerBillingShippingDetails[0]['s_street'])?$customerBillingShippingDetails[0]['s_street'] :''; ?><br>
                                    <?= isset($s_city_data[0]['name'])?$s_city_data[0]['name'] :''; ?> - 
                                    <?= isset($customerBillingShippingDetails[0]['s_post_code'])?$customerBillingShippingDetails[0]['s_post_code'] :''; ?>

                                    <br>
                                    <?= isset($s_state_data[0]['name'])?$s_state_data[0]['name'] :''; ?>,
                                    <?= isset($s_country_data[0]['name'])?$s_country_data[0]['name'] :''; ?>
                                    
                            </td>
                        </tr>     
                    </table>
                    
                </td>
                
            </tr>
            <tr class="" style="background-color: #f2f2f2;">
                <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
                    <strong style="margin-bottom: 0px;">KIND ATTN : <?= isset($customerData[0]['contact_person_name'] )?$customerData[0]['contact_person_name']  :''; ?></strong>
                </td>
            </tr>
            

            <tr class="">
                <td colspan="3" align="left" style="border-top: 1px solid #000;" ><strong style="font-size: 8px;">Dear Sir/Mam,</strong>
                    <?= isset($quotationData[0]['commercial'])?$quotationData[0]['commercial'] :''; ?>

                </td>
            </tr>

            
            <tr class="">
                <td colspan="3" align="center" >
                    <div class="clearfix"></div>
                    
                    <table id="tech" cellpadding="5" style="background-color: #fff; width: 100%; margin: 0 auto !important;">
                        <tr>
                            <td></td>
                            <td colspan="2" style="text-align: center; border:solid 2px #000" >
                                <strong style="font-size: 10px;">Technical Annexure</strong>
                            </td>
                            <td></td>
                        </tr>
                        <?php
                        if (count($quotationTechnicalSpecificationData) > 0) {
                            foreach ($quotationTechnicalSpecificationData as $key => $value) {
                                ?>
                                <tr style="border-style: hidden;">
                                    <td></td>
                                    <td style="background-color: #ccc; border:solid 2px #000; text-align: left"><strong><?= $value['title'] ?></strong></td>
                                    <td style="background-color: #ffffff; border:solid 2px #000; text-align: left"><?= $value['technical_description'] ?></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                    
                    <br>
                    
                </td>
                
            </tr>
                    
            
        </table>

        <table  style="border: 1px solid  #000;" cellspacing="0" cellpadding="5">
            <tr class="" style="background-color: #ccc;">
                <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
                    <strong style="margin-bottom: 0px; font-size:10px">ROI </strong>
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong>ENUMERATION OF   POWER  CONSUMPTION OF YOUR PARAG MAKE ACC FAN VIS A VIS ENCON   HIGH   EFFICIENCY   E-GLASS   EPOXY   FRP   FAN   &   CAPITAL   RECOVERY   DERIVED AS  UNDER  :</strong>
                </td>
            </tr>
            <?php 
                // print_r($quotationRoiData);

                $roi_amount_total = 0;
                $bullet_counter = 'a';

                if (count($quotationRoiData) > 0) {
                    foreach ($quotationRoiData as $key => $value) {
            ?>
                        <tr>
                            <td colspan="2"> <?= $bullet_counter . ") " . $value['roi_title'] ?> </td>
                            <td><strong>= <?= $value['roi_amount'] ?></strong></td>
                        </tr>
            <?php
                        $roi_amount_total += $value['roi_amount'];
                        $bullet_counter++; 
                    }
                }
            ?>

        
            <!-- <tr>
                <td colspan="2"> A) Power consumed by your existing ACC Fans (7 Nos.)                </td>
                <td><strong>=  437.50 KW</strong></td>
            </tr> -->


            <tr>
                <td colspan="2"></td>
                <td style="border-top: dotted 1px #000; border-top-style: dotted;"><strong>=  <?php echo $roi_amount_total; ?> /-</strong></td>
            </tr>
            <!-- <tr>
                <td colspan="2"></td>
                <td style="border-top: dotted 1px #000; border-top-style: dotted;"><strong>=  396.30 Days or /-</strong></td>
            </tr>

            <tr>
                <td colspan="2"></td>
                <td style="border-top: dotted 1px #000; border-top-style: dotted;"><strong>=  13.21 Months/-</strong></td>
            </tr> -->

            <tr>
                <td colspan="3" align="center">
                    <img width="250" src="<?= base_url('assets/images/graph.png'); ?>" alt="Graph">
                </td>
            </tr>

            <tr>
                <td colspan="3" >
                    <?php echo $quotationData[0]['roiDescription']; ?>
                </td>
            </tr>
            
            
        </table>


        <!-- <br pagebreak="true"/> -->
        <table  style="border: 1px solid  #000;" cellspacing="0" cellpadding="5">
            <tr class="" style="background-color: #ccc;">
                <td colspan="3" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
                    <strong style="margin-bottom: 0px; font-size:10px">Quotation Details </strong>
                </td>
            </tr>
                <tr class="heading"  >
                    <td style="border: 1px solid  #000;" width="6%" align="center">
                        <strong>No</strong>
                    </td>
                    <!-- <td style="border: 1px solid  #000;" width="20%" align="center">
                        <strong>ITEM</strong>
                    </td> -->
                    <td style="border: 1px solid  #000;" width="50%" align="center">
                        <strong>DESCRIPTION</strong>
                    </td>
                    <td style="border: 1px solid  #000;"width="10%" align="center">
                        <strong>QTY</strong>
                    </td>
                    <td style="border: 1px solid  #000;" width="9%" align="center">
                        <strong>RATE</strong>
                    </td>
                    <td style="border: 1px solid  #000;" width="10%" align="center">
                        <strong>TAX</strong>
                    </td>
                    <td style="border: 1px solid  #000;" width="15%" align="center">
                        <strong>AMT</strong>
                    </td>
                    <!-- <td style="border: 1px solid  #000;" width="10%">
                        
                    </td> -->
                </tr>
                
                <?php
                if (count($quitationItemData) > 0) {
                    $i = 1;
                    foreach ($quitationItemData as $key => $value) {
                        ?>
                        <tr class="item">
                            <td  align="center" style="border: 1px solid  #000;">
                                <?= $i ?>
                            </td>
                            <!-- <td  align="left" style="border: 1px solid  #000;">
                                <?//= $value['item_name'] ?>
                            </td> -->
                            <td align="left" style="border: 1px solid  #000;"><?= $value['item_description'] ?>
                            </td>
                            <td align="center" style="border: 1px solid  #000;">
                                <?= $value['item_qty'] ?>
                            </td>
                            <td align="center" style="border: 1px solid  #000;">
                                <?= $value['item_rate'] ?>
                            </td>
                            <td align="center" style="border: 1px solid  #000;" >
                                <?= $value['tax_value'] ?>
                            </td>
                            <td style="border: 1px solid  #000;" align="right">
                                <?= $value['item_amount'] ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
                
                
                <tr>
                    <td align="right" colspan="5"  style="border: 1px solid  #000;">Sub Total : </td>
                    <td align="right"  style="border: 1px solid  #000;"><?= $quitationItemData[0]['item_total_sub_amount']; ?> </td>
                </tr>
                <tr>
                    <td align="right" colspan="5"  style="border: 1px solid  #000;">Discount : </td>
                    <td align="right"  style="border: 1px solid  #000;"><?= $quitationItemData[0]['discount_percent']; ?> </td>
                </tr>
                <tr>
                    <td align="right" colspan="5"  style="border: 1px solid  #000;">Adjustment : </td>
                    <td align="right"  style="border: 1px solid  #000;"><?= $quitationItemData[0]['adjustment_value']; ?> </td>
                </tr>
                <tr>
                    <td align="right" colspan="5" style="border: 1px solid  #000;">Tax @ : </td>
                    <td align="right"  style="border: 1px solid  #000;"><?= $quitationItemData[0]['item_total_gst'] ?> </td>
                </tr>
                <tr >
                    <td align="right" colspan="5"  style="border: 1px solid  #000;"> <strong style="margin-bottom: 0px;">Grand Total : </strong>  </td>
                    <td align="right"  style="border: 1px solid  #000;"><strong style="margin-bottom: 0px;"> <?= $quitationItemData[0]['item_total_amount'] ?> </strong> </td>
                </tr>

                <tr class="" style="background-color: #ccc;">
                    <td colspan="7" align="center" style="border-top: 1px solid #000;border-bottom: 1px solid  #000;" >
                        <strong style="margin-bottom: 0px;">Total Amount In Words: <?php 
                        
                            
                            $total_amt_word = strval(convertNumber($quitationItemData[0]['item_total_amount']))                        
                        
                        ; echo ucwords($total_amt_word); ?></strong>
                    </td>
                </tr>
                


        </table>

       
        
        

        <table border="1" style="border: 1px solid  #000; " cellspacing="0" cellpadding="5" width="100%">
                        <tr>
                            <td>
                            </td>
                        </tr>
            <?php 
            
                if (count($quotationFooterNotesData) > 0) {
                    foreach ($quotationFooterNotesData as $key => $value) {
                        ?>
                        <tr style="background-color: #ccc; border:solid 1px #000;">
                            <td>
                                <strong><?= $value['title'] ?> :-</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= $value['technical_description'] ?>
                            </td>
                        </tr>
            <?php
                    }
                }
            ?>
        </table>


       


        

    </body>
</html>
 