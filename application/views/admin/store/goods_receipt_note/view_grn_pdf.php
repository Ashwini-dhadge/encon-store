<?php  init_header_print(); ?>
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
   font-weight: 900;
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
   .heading{
   font-weight: bold;
   color:black;
   font-size: 12px;
   }
   @page {
   margin: 0cm;
   }
   .horizontal-partition {
   border-bottom: 1px solid #ddd;
   padding-bottom: 8px;
   margin-bottom: 8px;
   }
   .no-margin-bottom{
   margin-bottom: 0 !important;
   }
</style>
<style>
   @media print {
   #pdf-button {
   display: none;
   }
   }
</style>
<!-- table table-borderless.........without border
   table display table-bordered  table-striped no-wrap............with border -->
<div class="page-wrapper" id="PDFcontent">
   <div class="container-fluid no-padding-top">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-outline-info">
               <!--  <div class="card-header">
                  <div class="row">
                     <div class="col-md-10">
                        <h4 class="m-b-0 text-white">
                           <a href="javascript:void(0);" onclick="history.back()">
                           <i class="fa fa-arrow-circle-left" style="color: white;"></i>
                           </a> Customer Invoice List View
                        </h4>
                     </div>
                     <div class="col-md-2"></div>
                  </div>
                  </div> -->
               <div class="col-md-12" style="padding:0px">
                  <th class="trhead" style="width:18%">
                  </th>
               </div>
               <div class="card-body">
                  <div class="col-md-12 padding-right-5">
                     <div class="row">
                        <div class="col-md-4" style="padding: 0px;"></div>
                        <div class="col-md-4" style="padding: 0px;">
                           <table class="table table-borderless" style="width: 100%;">
                              <thead class="center">
                                 <tr>
                                    <th>
                                       <span class="trhead"> </span>
                                    </th>
                                 </tr>
                                 <tr>
                                    <th>
                                       <span class="trhead"><?= ucwords($compnay_name); ?><br><?= ucwords($company_address); ?><br><?= ucwords($site_name); ?><br> GOODS RECEIPT NOTE<br></span>
                                    </th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12" style="float:left;padding: 0px;">
                           <div class="row" style="padding-left: 100px;">
                              <div class="col-md-4">
                                 <table class="table table-borderless table-responsive" style="width: 100%;">
                                    <tr>
                                       <td class="trhead">Indent No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($custom_inward_no)?$custom_inward_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Indent Date.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($custom_inward_date)?dmyDate($custom_inward_date) :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">ENCON Ref No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">P.Order No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($po_date)?dmyDate($po_date) :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">P.Order Date.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($po_date)?dmyDate($po_date) :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Vendor Name</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($account_name)?$account_name :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Transport</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($transport_name)?$transport_name :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">LR No./Dt.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($lr_no)?$lr_no :''; ?><?= isset($lr_date)?dmyDate($lr_date) :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Mnl. Slip No. </td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($manual_slip_no)?$manual_slip_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Vehicle No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($vehicle_no)?$vehicle_no :''; ?></td>
                                    </tr>
                                 </table>
                              </div>
                              <div class="col-md-4">
                                 <table class="table table-borderless table-responsive" style="width: 100%;">
                                    <tr>
                                       <td class="trhead">Arrival Date.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Unload Date.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($unload_date)?dmyDate($unload_date) :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Bill No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($party_bill_no)?$party_bill_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Bill Date.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($bill_date)?dmyDate($bill_date) :''; ?></td>
                                    </tr>
                                 </table>
                              </div>
                              <div class="col-md-4">
                                 <table class="table table-borderless table-responsive" style="width: 100%;">
                                    <tr>
                                       <td class="trhead">GRN No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($grn_no)?$grn_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">GRN Date.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($grn_date)?dmyDate($grn_date) :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Gate Pass No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($gate_pass_no)?$gate_pass_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Time In.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($grn_time)?$grn_time :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Lab. No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($lab_report_no)?$lab_report_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Challan No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($challan_no)?$challan_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Driver Name.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($driver_name)?$driver_name :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">RST No.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($rst_no)?$rst_no :''; ?></td>
                                    </tr>
                                    <tr>
                                       <td class="trhead">Packing and Forwarding.</td>
                                       <td class="trhead">:</td>
                                       <td class="trhead"><?= isset($packing_forwarding_amount)?$packing_forwarding_amount :''; ?></td>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <table class="table table-bordered" width="100%">
                                 <tbody>
                                    <tr class="heading">
                                       <td width="3%" align="center">Sr.</td>
                                       <td width="5%" align="center">Item<br>Code</td>
                                       <td width="10%" align="center">Description</td>
                                       <td width="5%" align="center">Unit</td>
                                       <td width="5%" align="center">Rate</td>
                                       <td width="5%" align="center">PO Qty<br>(A)</td>
                                       <td width="" align="center">Challan<br>Qty</td>
                                       <td width="" align="center">Total<br>Received<br>Qty<br>(B)</td>
                                       <td width="" align="center">Already<br>Recv. Qtyearlier<br>GRN in<br>Linked Po<br>(C)</td>
                                       <td width="" align="center">Return<br>Qty<br>(D)</td>
                                       <td width="" align="center">Net Received<br>Qty<br>E=(B-D)</td>
                                       <td width="" align="center">GRN<br>Amount</td>
                                       <td width="" align="center">TotalRecv.<br>Qty till<br>date in<br>Link PO<br>F=(C+E)</td>
                                       <td width="" align="center">Balance Qty<br>G=(A-F)</td>
                                       <td width="" align="center">Tax<br>Amount</td>
                                       <td width="" align="center">NetAmount<br>After<br>PO Tax &<br>PO<br>Discount</td>
                                    </tr>
                                    <?php  
                                       $totalItemQty = $totalreceiedQty=$totalgrnamt=$totaltaxamt=$totalpotaxamt=$total_item_po_qty1=$totalSubgrnamt=0;
                                       foreach($grn_item_details_data as $key=>$value) {
                                          
                                           $totalItemQty += $value['total_aginst_po'];
                                           $totalreceiedQty += $value['received_qty'];
                                           $totalgrnamt += $value['item_amount'];
                                           $totalSubgrnamt += $value['item_sub_amount'];
                                           $totaltaxamt += $value['grn_txt_value'];
                                           $totalpotaxamt += $value['tax_value'] + $value['item_discount_amount'];
                                           $total_item_po_qty1 += $value['total_aginst_po'];
                                       ?>
                                    <tr>
                                       <td align="center"><?= $key+1; ?></td>
                                       <td align="center"><?= $value['hsn_code']; ?></td>
                                       <td align="center"><?= $value['item_name']; ?>
                                        <?php
                                            if(isset($value['warranty_description'])&& !empty($value['warranty_description'])){
                                                echo "<br><b>Warranty Description</b>:".$value['warranty_description'];
                                            }
                                            if(isset($value['other_description'])&& !empty($value['other_description'])){
                                                echo "<br><b>Other Desc.</b>:".$value['other_description'];
                                            }
                                             if(isset($value['technical_description']) && !empty($value['technical_description'])){
                                                echo "<br><b>Technical Desc.</b>:".$value['technical_description'];
                                            }
                                       ?>
                                        

 
                                       </td>
                                       <td align="center"><?= $value['stock_unit']; ?></td>
                                       <td align="center"><?= $value['item_rate']; ?></td>
                                       <td align="center"><?= $value['total_aginst_po']; ?></td>
                                       <td align="center"><?= $value['po_challan_quantity']; ?></td>
                                       <td align="center"><?= $value['received_qty']; ?></td>
                                       <td align="center"><?= $value['earlier_receive_qty']; ?></td>
                                       <td align="center"><?= $value['item_return_qty']; ?></td>
                                       <?php
                                          $netrecived = $value['received_qty'] - $value['item_return_qty'];
                                          ?>
                                       <td align="center"><?= $netrecived ?></td>
                                       <td align="center"><?= $value['item_sub_amount']; ?></td>
                                       <?php
                                          $totalrecived = $netrecived+ $value['earlier_receive_qty'];;?>
                                       <td align="center"><?=  $totalrecived; ?></td>
                                       <?php
                                          $balenceqty = $value['total_aginst_po']-$totalrecived;?>
                                       <td align="center"><?= $balenceqty;?></td>
                                       <td align="center">
                                          GST@<?= $value['grn_txt_rate']; ?>%
                                          <p class="no-margin-bottom"></p>
                                          <?= $value['grn_txt_value']; ?>
                                       </td>
                                       <td align="center">
                                          <div class="horizontal-partition">
                                             <p class="no-margin-bottom"> <?= isset($value['item_amount'])?$value['item_amount']:"-"; ?></p>
                                          </div>
                                          <!-- Second partition -->
                                          <p class="no-margin-bottom"><?= $value['item_amount']+$value['grn_txt_value']; ?></p>
                                       </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center">TOTAL</td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $total_item_po_qty1; ?></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $totalreceiedQty; ?></td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $totalSubgrnamt; ?></td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $totaltaxamt; ?></td>
                                       <td align="center"> <?= isset($value['item_amount'])?$value['item_amount']:"-"; ?></td>
                                    </tr>
                                    <tr>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center">TOTAL WITH GST@</td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $total_item_po_qty1; ?></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $totalreceiedQty; ?></td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $totalSubgrnamt; ?></td>
                                       <td align="center"></td>
                                       <td align="center"></td>
                                       <td align="center"><?= $totaltaxamt; ?></td>
                                       <td align="center"><?= $value['landed_cost_final_amount']; ?></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <div class="col-md-12">
                              <div class="col-md-3" style="padding-bottom: 50px;">Remark: </div>
                           </div>
                           <!--  <div class="col-md-12"><?php echo  strip_tags($remark);?>
                              <div class="row" style="padding-bottom: 20px;">
                              <div class="col-md-4" ></div>
                              <div class="col-md-4" >KAILAS MALI</div>
                              <div class="col-md-4" ></div>
                              </div>
                              </div> -->
                           <div class="col-md-12" style="font-weight: bold;color:black;">
                              <div class="row" style="padding-bottom: 200px;">
                                 <div class="col-md-2" ><br>Prepared By :</div>
                                 <div class="col-md-2" ><br>Received By:</div>
                                 <div class="col-md-2" ><?= isset($first_name)?$first_name :'';; ?> <?= isset($last_name)?$last_name :'';; ?> <br>Despatched By</div>
                                 <div class="col-md-2" ><br>Checked By</div>
                                 <div class="col-md-2" ><br>Authorised Signatory</div>
                                 <div class="col-md-2" ><br>Created By</div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   
   <!--<input id="pdf-button" type="button" value="Download PDF" onclick="downloadPDF()" />-->
</div>
<?php  init_footer(); ?> 
<script src="<?= base_url(); ?>assets/js/custom_common.js?v=1.0.1"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PrintArea/2.4.1/jquery.PrintArea.min.js" integrity="sha512-mPA/BA22QPGx1iuaMpZdSsXVsHUTr9OisxHDtdsYj73eDGWG2bTSTLTUOb4TG40JvUyjoTcLF+2srfRchwbodg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/PrintArea/2.4.1/PrintArea.css" integrity="sha512-4hufni74YXhS+9wxYTyC9ykJu65BGFw1L+Rweywuu+K12kCFWtoq/bjvjw2XJv2Q5WZivKJd22gv1EFIiUExpw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <script>

$(document).ready(function(){


printResult();


    
});
function printResult() {
    var DocumentContainer = document.getElementById('PDFcontent');
      $("#PDFcontent").printArea({ mode: 'popup', popClose: true });
}
 
</script>