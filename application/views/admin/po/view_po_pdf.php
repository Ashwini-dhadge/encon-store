<?php  init_header(); ?>
<link href="<?= base_url() ?>assets/css/pages/card-page.css" rel="stylesheet" />
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
<style>
   ._status {
   cursor: pointer;
   }
   .card-header {
   background: #398bf7;
   border-color: #398bf7;
   padding: 0.25rem 0.25rem;
   margin-top: -10px;
   }
   .center {
   text-align: center;
   }
   .trhead {
   /*font-weight: 500;*/
   font-size: 12px;
   }
   .img {
   float:right;
   padding: 5px;
   height: auto;
   width: 30%;
   }
   tr {
   background: white !important;
   }
   .th1,
   .td1 {
   border: solid 1px #000;
   padding: 10px;
   }
   .table-bordered,
   .table-bordered td {
   border: 2px solid #dee2e6;
   }
   .bdr {
   border: 1px solid;
   }
   .trhead_aa {
   border: 1px solid #dee2e6 !important;
   text-align: center;
   }
   .border {
   border-right: 0px solid #dee2e6 !important;
   border-left: 0px solid #dee2e6 !important;
   border-top: 2px solid #dee2e6 !important;
   border-bottom: 2px solid #dee2e6 !important;
   }
   .border_1 {
   border-right: 0px solid #dee2e6 !important;
   border-left: 0px solid #dee2e6 !important;
   border-top: 0px solid #dee2e6 !important;
   border-bottom: 1px solid #dee2e6 !important;
   }
   .text_align_right {
   text-align: right;
   }
   .width {
   width: 12%;
   }
   .width_i {
   width: 54%;
   }
   .card-body{
   outline:1px solid black;
   margin-bottom: 30px;
   margin-left: 30px;
   margin-right: 30px;
   margin-top: 30px;
   }
   @page {
   margin: 0cm;
   }
</style>
<!-- table table-borderless.........without border
   table display table-bordered  table-striped no-wrap............with border -->
<div class="page-wrapper">
   <div class="container-fluid no-padding-top">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-outline-info">
               <div class="card-body ">
                  <div class="col-md-12 padding-right-5">
                     <div class="row">
                        <div class="table-responsive ">
                           <div class="col-md-12" style="float:left;padding: 0px;">
                              <table class="table table-borderless" style="width: 100%;">
                                 <thead class="center">
                                    <tr>
                                       <th colspan="4">
                                          <span class="trhead">
                                          <strong>
                                          <u>PURCHASE ORDER</u>
                                          </strong>
                                          </span>
                                       </th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="row">
                           <div class="col-md-6">
                              <table class="table table-borderless table-responsive" style="width: 100%;">
                                 <tbody>
                                    <tr>
                                       <td class="width">
                                          <!--   <span class="trhead">Indent No.&nbsp;:</span><br> -->
                                          <span class="trhead">To&nbsp;,</span><br>
                                          <span class="trhead"><?= isset($vendor_name)?$vendor_name :''; ?>&nbsp;</span><br>
                                          <span class="trhead"><?= isset($address_details)?$address_details :''; ?></span><br>
                                          <span class="trhead"><?= isset($pincode)?$pincode :''; ?> </span><br>
                                          <span class="trhead">State  :<?= isset($state_name)?$state_name :''; ?></span><br>
                                          <span class="trhead">City  :<?= isset($state_name)?$state_name :''; ?></span><br>
                                          <span class="trhead">Email &nbsp;: <?= isset($contact_person_email)?$contact_person_email :''; ?></span><br>
                                          <span class="trhead">PH.&nbsp;: <?= isset($contact_person_mobile_no)?$contact_person_mobile_no :''; ?>,</span><br>
                                          <span class="trhead">GSTIN/UID: <?= isset($gst_no)?$gst_no :''; ?></span><br>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <div class="col-md-6">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="table-responsive ">
                           <div class="col-md-12" style="float:left;padding: 10px;">
                              <table class="table table-hover table-fixed" style="width: 100%;">
                                 <thead>
                                    <tr class="border" style="text-align:center;">
                                       <th></th>
                                       <th></th>
                                       <th></th>
                                       <th></th>
                                       <!-- <th></th> -->
                                       <th>
                                          <span class="trhead"><b>KIND ATTN : MR. RAJENDRA TIWARI</b></span>
                                       </th>
                                    </tr>
                                 </thead>
                                 <tbody style="text-align:center">
                                    <tr class="border">
                                       <td colspan="14" class="border" style="text-align:center">
                                          <span class="trhead" ><b> <?= isset($line_before_address)?$line_before_address :''; ?></b>
                                          </span>
                                       </td>
                                    </tr>
                                    <tr class="border">
                                       <td colspan="5" style="text-align: center;">
                                          <div class="col-md-12">
                                             <table class="table table-bordered " width="100%">
                                                <tbody>
                                                   <tr class="heading">
                                                      <td>SR.No </td>
                                                      <td>DESCRIPTION</td>
                                                      <td>HSNCODE</td>
                                                      <td>SIZE</td>
                                                      <td>QTY</td>
                                                      <td>RATE</td>
                                                      <td>GST RS.</td>
                                                      <td>TOTAL AMT</td>
                                                   </tr>
                                                   <?php
                                                      foreach($po_item_details_data as $key=>$value){
                                                      ?>
                                                   <tr >
                                                      <td><?= $key+1; ?></td>
                                                      <td><?= $value['item_name']."<br>".$value['item_description']; ?></td>
                                                      <td> <?= $value['hsn_code']; ?></td>
                                                      <td><?= $value['item_size']; ?></td>
                                                      <td><?= $value['item_qty']; ?></td>
                                                      <td><?= $value['item_rate']; ?></td>
                                                      <td>CGST:<?= $value['tax_rate']/2; ?>% Rs. <?= $value['tax_value']/2; ?><br>SGST:<?= $value['tax_rate']/2; ?>% Rs. <?= $value['tax_value']/2; ?></td>
                                                      <td><?= $value['item_sub_amount']; ?></td>
                                                   </tr>
                                                   <?php
                                                      }
                                                      
                                                      ?>
                                                   <tr>
                                                      <th scope="row">Item Total : </th>
                                                      <td colspan="6"></td>
                                                      <td><?= $po_tax_details_data[0]['item_total_gst']; ?></td>
                                                   </tr>
                                                   <tr>
                                                      <td></td>
                                                      <td colspan="6">GST @</td>
                                                      <td><?= $po_tax_details_data[0]['item_total_sub_amount']; ?></td>
                                                   </tr>
                                                   <tr>
                                                      <td></td>
                                                      <td colspan="6" style="text-align: left;">Total Amount In Words: <?=  (convertNumber($po_tax_details_data[0]['item_total_sub_amount']));?>  </td>
                                                      <td><?= $po_tax_details_data[0]['item_total_sub_amount'] ?></td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </td>
                                    </tr>
                                    <tr class="border">
                                       <td colspan="5" style="text-align: left;">
                                          <span class="trhead">
                                          Terms & Conditions :- <br> 
                                          </span>
                                       </td>
                                    </tr>
                                    <tr class="">
                                       <td colspan="19" style="text-align: left;">
                                          <span class="trhead">Terms: <b style="font-size:14"> 
                                          </span>
                                          <?= $terms_and_condition; ?>
                                       
                                          <div class="col-md-12">
                                             <div class="row trhead">
                                                <div class="col-md-6 trhead">
                                                   <span >Discount&nbsp;:&nbsp;&nbsp;N.A.</span><br>
                                                   <span>Prices&nbsp; : &nbsp;&nbsp;EX WORKS</span><br>
                                                   <span>Trans & Insur&nbsp; :&nbsp;&nbsp; 0.00 </span><br>
                                                   <span>Delivery&nbsp;:&nbsp;&nbsp;BY 01.12.2023</span><br>
                                                   <span>Payment Terms &nbsp;:&nbsp;&nbsp;100 % 30 DAYS FROM DATE OF DISPATCH</span><br>
                                                   <span>Remark&nbsp;:&nbsp;&nbsp;N.A.</span><br>
                                                </div>
                                                <div class="col-md-6"> 
                                                   <span>Guarantee&nbsp;:&nbsp;&nbsp;(18/12) MONTHS</span><br>
                                                   <span>Packing & Forwarding&nbsp;:&nbsp;&nbsp;N.A.</span><br>
                                                   <span>Taxes & Duites&nbsp;:&nbsp;&nbsp;EXTRA, AS APPLICABLE</span><br>
                                                   <span>LD Clause&nbsp;:&nbsp;&nbsp;N.A.</span><br>
                                                   <span>Delivery Address&nbsp;:&nbsp;&nbsp;Plot no. 109 & 110; STICE Musalgaon MIDC Sinnar</span><br>
                                                </div>
                                             </div>
                                          </div>
                                          <br><br><br>
                                          <div class="co-md-12 trhead">
                                             <div class="row">
                                                <div class="col-md-4"> <span></span><br>
                                                   <span></span><br>
                                                   <span></span><br>
                                                   <span><?= $created_first_name." ".$created_last_name ?></span><br>
                                                   <span>Checked By</span><br>
                                                </div>
                                                <div class="col-md-4"> 
                                                   <span></span><br>
                                                   <span></span><br>
                                                   <span></span><br>
                                                   <span><?= $approved_first_name." ".$approved_last_name ?></span><br>
                                                   <span>Approved By</span><br>
                                                </div>
                                                <div class="col-md-4"> <span>Thanking you,</span><br>
                                                   <span>Your's Faithfully</span><br>
                                                   <span>For ENCON COOLING TOWERS PVT. LTD.</span><br>
                                                   <span>Sign</span><br>
                                                   <span>Authorised Signatory</span><br>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <br>
                        <table class="table table-hover table-fixed" style="width: 100%;">
                           <thead>
                              <tr class="border" style="text-align:center;">
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <th></th>
                                 <!-- <th></th> -->
                                 <th>
                                    <span class="trhead">WORKS: PLOT NO. 109/110,H/2-1 SINNAR TALUKA AUDYOGIK VASAHAT MARYADLT MIDC SINNER POST MUSALGON , DIST.: NASHIK - 422 1031</span>
                                 </th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php  init_footer(); ?>
