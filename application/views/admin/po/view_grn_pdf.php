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
</style>
<!-- table table-borderless.........without border
   table display table-bordered  table-striped no-wrap............with border -->
<div class="page-wrapper">
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
                                       <span class="trhead">ENCON COOLING TOWERS PVT. LTD.<br>PLOT NO.109 & 110<br>Plot no. 109 & 110; STICE Musalgaon MIDC Sinnar , SINNAR <br> GOODS RECEIPT NOTE<br></span>
                                    </th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                       <!--  <div class="col-md-4" style="padding: 0px;">
                           <table class="table table-borderless" style="width: 100%;">
                              <thead class="center">
                                 <tr>
                                    <th>
                                       <center>
                                          <img class="img" src="<?= base_url(); ?>assets/images/qr.png">
                                       </center>
                                    </th>
                                 </tr>
                                 <tr>
                                    <th></th>
                                 </tr>
                              </thead>
                           </table>
                        </div> -->
                     </div>
                     <div class="row">
                        <div class="table-responsive ">
                           <div class="col-md-12" style="float:left;padding: 0px;">
                           	<div class="row" style="padding-left: 100px;">
                           	<div class="col-md-4"> 
                           	<table class="table table-borderless table-responsive" style="width: 100%;">
                           		 <tbody>
                           		 	<tr>
                                       <td class="width">
                                          <span class="trhead">Indent No.&nbsp;:</span><br>
                                          <span class="trhead">Indent Date&nbsp;:</span><br>
                                          <span class="trhead">ENCON Ref No&nbsp;:</span><br>
                                          <span class="trhead">P.Order No. :&nbsp;<?= isset($po_order_no)?$po_order_no :''; ?></span><br>
                                           <span class="trhead">P.Order Date : &nbsp;<?= isset($po_date)?$po_date :''; ?></span><br>
                                           <span class="trhead">Vendor Name : SUPREME CORPORATION </span><br>
                                           <span class="trhead">Transport :</span><br>
                                           <span class="trhead">LR No./Dt. : 09-11-2023</span><br>
                                           <span class="trhead"> Mnl. Slip No. :</span><br>
                                             <span class="trhead">Vehicle No. :</span><br>
                                       </td>
                                     
                                    </tr>
                           		 </tbody>
                           	</table>
                           </div>
                           	<div class="col-md-4">	<table class="table table-borderless  table-responsive" style="width: 100%;">
                           		 <tbody>
                           		 	<tr>
                                       <td class="width">
                                          <span class="trhead">Arrival Date : 09-11-2023 04:20PM</span><br>
                                           <span class="trhead"> Unload Date : 09-11-2023 04:20PM</span><br>
                                            <span class="trhead">Bill No. : 23-24/0395</span><br>
                                             <span class="trhead">Bill Date : 08-11-2023 04:20PM</span><br>

                                       </td>
                                     


                                      
                                    </tr>
                           		 </tbody>
                           	</table></div>
                           	<div class="col-md-4">	<table class="table table-responsive table-borderless " style="width: 100%;">
                           		 <tbody>
                           		 	<tr>
                                       <td class="width">
                                          <span class="trhead">GRN No. : 109-1</span><br>
                                          <span class="trhead"> GRN Date : 09-11-2023 04:20PM</span><br>
                                          <span class="trhead">Gate Pass No. :</span><br>
                                          <span class="trhead">Time In :</span><br>
                                          <span class="trhead">Lab. No. :</span><br>
                                          <span class="trhead">Challan No. :</span><br>
                                              <span class="trhead">Driver Name :</span><br> 
                                              <span class="trhead">RST No. :</span><br>
                                              <span class="trhead"></span><br>
                                              <span class="trhead"></span><br>
                                       </td>
                                     
                                    </tr>
                           		 </tbody>
                           	</table>
                           </div>
                           	</div>
                              <div class="col-md-12">
                                 <table class="table table-bordered">
 
  <tbody>
    <tr class="heading">
      
      <td>Sr.</td>
      <td>Item<br>Code</td>
      <td>Description</td>
      <td>Unit</td>
      <td>Rate</td>
      <td>PO Qty<br>(A)</td>
      <td>Challan<br>Qty</td>
      <td>Total<br>Received<br>Qty<br>(B)</td>
      <td>Already<br>Recv. Qtyearlier<br>GRN in<br>Linked Po<br>(C)</td>
      <td>Return<br>Qty<br>(D)</td>
      <td>Net Received<br>Qty<br>E=(B-D)</td>
      <td>GRN<br>Amount</td>
      <td>TotalRecv.<br>Qty till<br>date in<br>Link PO<br>F=(C+E)</td>
      <td>Balance Qty<br>G=(A-F)</td>
      <td>Tax<br>Amount</td>
      <td>Net<br>Amount<br>After<br>PO Tax &<br>PO<br>Discount</td>
    </tr>
    <tr>
    
      <td>1</td>
      <td>3470</td>
      <td>LIBERTY SAFETY SHOES<br>NO 6</td>
      <td>PAIR</td>
      <td>840</td>
      <td>4</td>
      <td></td>
      <td>4</td>
      <td></td>
      <td></td>
     <td>4</td>
      <td>3360</td>
      <td>4</td>
      <td></td>
      <td>GST@12.<br>00%<br>403.20</td>
      <td>3360<br>-----------<br>3763.24</td>
    </tr>
    <tr>
    
      <td>2</td>
      <td>2176</td>
      <td>SAFETY SHOES TIGER<br>7NO</td>
      <td>PAIR</td>
      <td>840</td>
      <td>8</td>
      <td></td>
      <td>8</td>
      <td></td>
      <td></td>
     <td>8</td>
      <td>6720</td>
      <td>8</td>
      <td></td>
      <td>GST@12.<br>00%<br>806.40</td>
      <td>6720<br>-----------<br>7526.48</td>
    </tr>
    <tr>
    
      <td>3</td>
      <td>2178</td>
      <td>SAFETY SHOES TIGER<br>8NO</td>
      <td>PAIR</td>
      <td>840</td>
      <td>15</td>
      <td></td>
      <td>15</td>
      <td></td>
      <td></td>
     <td>15</td>
      <td>12600</td>
      <td>15</td>
      <td></td>
      <td>GST@12.<br>00%<br>1512.00</td>
      <td>12600<br>-----------<br>14112.14</td>
   </tr>
   <tr>
    
      <td>4</td>
      <td>2181</td>
      <td>SAFETY SHOES TIGER<br>9NO</td>
      <td>PAIR</td>
      <td>840</td>
      <td>8</td>
      <td></td>
      <td>8</td>
      <td></td>
      <td></td>
     <td>8</td>
      <td>6720</td>
      <td>8</td>
      <td></td>
      <td>GST@12.<br>00%<br>806.40</td>
      <td>6720<br>-----------<br>7526.48</td>
  </tr>
   <tr class="heading">
      
      <td>Sr.</td>
      <td>Item<br>Code</td>
      <td>Description</td>
      <td>Unit</td>
      <td>Rate</td>
      <td>PO Qty<br>(E)</td>
      <td>Challan<br>Qty</td>
      <td>Total<br>Received<br>Qty<br>(B)</td>
      <td>Already<br>Recv. Qtyearlier<br>GRN in<br>Linked Po<br>(A)</td>
      <td>Return<br>Qty</td>
      <td>Net Received<br>Qty<br>(B)</td>
      <td>GRN<br>Amount</td>
      <td>TotalRecv.<br>Qty till<br>date in<br>Link PO<br>C=(A+B)</td>
      <td>Balance Qty<br>D=(E-C)</td>
      <td>Tax<br>Amount</td>
      <td>Net<br>Amount<br>After<br>PO Tax &<br>PO<br>Discount</td>
    </tr>

       <tr>
    
      <td>5</td>
      <td>2180</td>
      <td>SAFETY SHOES TIGER<br>10NO</td>
      <td>PAIR</td>
      <td>840</td>
      <td>4</td>
      <td></td>
      <td>4</td>
      <td></td>
      <td></td>
     <td>4</td>
      <td>3360</td>
      <td>4</td>
      <td></td>
      <td>GST@12.<br>00%<br>403.20</td>
      <td>3360<br>-----------<br>3763.24</td>
  </tr>
  <tr>
    
      <td>6</td>
      <td>5882</td>
      <td>SAFETY SHOES TIGER<br>11NO</td>
      <td>PAIR</td>
      <td>840</td>
      <td>3</td>
      <td></td>
      <td>3</td>
      <td></td>
      <td></td>
     <td>3</td>
      <td>2520</td>
      <td>3</td>
      <td></td>
      <td>GST@12.<br>00%<br>302.40</td>
      <td>2520<br>-----------<br>2822.42</td>
  </tr>
  <tr>
    
      <td></td>
      <td></td>
      <td>T O T A L</td>
      <td></td>
      <td></td>
      <td>42</td>
      <td></td>
      <td>42</td>
      <td></td>
      <td></td>
     <td>42</td>
      <td>35280</td>
      <td>42</td>
      <td></td>
      <td>4233.6</td>
      <td>35280</td>
  </tr>
   <tr>
    
      <td></td>
      <td></td>
      <td>T O T A L WITH GST@</td>
      <td></td>
      <td></td>
      <td>42</td>
      <td></td>
      <td>42</td>
      <td></td>
      <td></td>
     <td>42</td>
      <td>35280</td>
      <td>42</td>
      <td></td>
      <td></td>
      <td>39514</td>
  </tr>
  </tbody>
</table>
                              </div>

                              <div class="col-md-12">
                                 <div class="col-md-3" style="padding-bottom: 90px;">Remark:</div>
                              </div>

                              <div class="col-md-12">
                                 <div class="row" style="padding-bottom: 20px;">
                                 <div class="col-md-4" ></div>
                                 <div class="col-md-4" >KAILAS MALI</div>
                                 <div class="col-md-4" ></div>
                                 </div>
                              </div>

                              <div class="col-md-12">
                                 <div class="row" style="padding-bottom: 200px;">
                                 <div class="col-md-2" >Prepared By :</div>
                                 <div class="col-md-2" >Received By</div>
                                 <div class="col-md-2" >Despatched By</div>
                                 <div class="col-md-2" >Checked By</div>
                                 <div class="col-md-2" >Authorised Signatory</div>
                                 <div class="col-md-2" >Created By</div>
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
   </div>
</div>
<?php  init_footer(); ?> <script src="
   <?= base_url(); ?>assets/js/custom_common.js?v=1.0.1"></script>
