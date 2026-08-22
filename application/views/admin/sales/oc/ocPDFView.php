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
        </table>
        <table style="border: 1px solid  #000;" cellspacing="0" cellpadding="5">
            <?php //print_r($customerData); ?>
            <tr >
                <td style="text-align:left">
                    <p><strong><?= $quotationData[0]['order_no'] ?></strong></p>
                </td>
                <td style="text-align:right">
                    <p><strong>08TH NOVEMBER’ 2023</strong></p>
                </td>
            </tr>
            <tr > 
                <td colspan="2" style="text-align:left">
                        <strong>To,</strong><br>
                        <strong style="font-size:8px;"><?= $customerContacts['designation'] ?>,</strong><br>
                            <?= $customerData['company_name'] ?>,<br>
                            <?= $customerData['address'] ?><br>
                            CITY :<?= $cities['name'] ?><br>
                            <?= $states['name'] ?> – <?= $customerData['post_code'] ?><br>
                            EMAIL ID.: <?= $customerData['email'] ?><br>
                            CONTACT NO.: +91 <?= $customerData['phone'] ?><br>
                    
                    

                    
                        <h4 style="padding:0px;">KIND ATTN.: <?= $customerContacts['contact_person_name'] ?></h4>
                        <p style=""><strong>SUB.:</strong> <?= $ocData['subject'] ?></p>

                        <p style=""><strong>P.O. DESCRIPTION :</strong>  <?= $ocData['po_descriptions'] ?></p>
                        <p style=""><strong>REF.: </strong>  <?= $ocData['oc_referance'] ?></p>

                        <?= $ocData['header_body_message'] ?>

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
                    <?= $ocData['footer_body_message'] ?>


                    Yours faithfully, <br><br>
                    For <strong>ENCON ENGINEERS</strong><br><br><br>
                    <strong>SANTOSH SAHOO <br>
                    (OFFICER - SALES & MKTG.) <br>
                    Encl.: a/a</strong>

                </td>
                
            </tr>



        </table>






    </body>
</html>
 