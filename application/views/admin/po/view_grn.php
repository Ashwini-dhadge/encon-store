<?php init_header();?>

<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<link href="<?= base_url(); ?>/assets/node_modules/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />




<style>
   .lbl_class{
      font-weight: bold;
   }
   .customtab li a.nav-link {
      padding: 4px 8px;
   }
   .wdth{
      width: 10%;
   }
   .wdth_a{
      width: 23%;  
   }
  
  .select2-selection__choice{
      background-color:#48bc97 !important ;
   }
   
   .swal2-modal{
      width:24%;
      margin-bottom:25% !important;  
   }

   .swal2-confirm,.swal2-cancel{
    border: 1px solid #48bc97 !important;
    transition: 0.2s ease-in !important;
    color: #fff !important;
    padding: 5px 10px !important;
    font-size: 16px !important;
    line-height: 1.4 !important;
   }

   .file-drop-zone-title {
    padding: 15px 10px !important;
   }

   .file-preview-image{
       width: auto !important;
       height: 40px !important;
   }

   .file-no-browse,.fileinput-cancel-button{
      display: none;
   }

   .kv-file-content{
      display: none !important;
   }
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- 1st  -->
   <div class="row">
     
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 ">
                     <div class="row">
                        <div class="col-md-12">
                         
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs customtab" role="tablist">
                                  <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#purchase_order" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down text-color"><h6><b>Goods Receipt Note Info</b></h6></span></a> </li>
                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#delivery_billing_site" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><h6><b>Delivery/Billing Site</b></h6></span></a> </li>
                                  
                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#item_tab" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><h6><b>Item</b></h6></span></a> </li>

                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#terms_condition" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"><h6><b>Terms & Condition</b></h6></span></a> </li>
                              </ul>
                         

                               <!-- Tab panes -->
                               <div class="tab-content">
                                   <div class="tab-pane active" id="purchase_order" role="tabpanel">
                                       <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="">
                                             <div class="col-md-12" style="padding: 0px;">
                                                <span class="text-color"><h6><b>GRN Details</b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Grn No.
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($grn_no)?$grn_no:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                            Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($grn_date)?$grn_date:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                            Time
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>
                                                            <?=   
                                                                 $time = date('h:i a', strtotime($grn_time));  
                                                                 isset($time)?($time):'';?></span>
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Manual Slip No
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($manual_slip_no)?$manual_slip_no:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                         Unload Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($unload_date)?$unload_date:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                            Received From
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>
                                                            <?php
                                                               if($received_from == 1){
                                                                  echo "Self";
                                                               }else{
                                                                  echo "Party/Customer";
                                                               }
                                                            ?>
                                                         </span>
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td>
                                                         <span class="lbl_class">
                                                            Received Location
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($receive_location_site_name)?$receive_location_site_name:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Received By
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>recv.by</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Vendor/Customer Name
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>vendor/customer</span>
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td>
                                                         <span class="lbl_class">
                                                           Cash Payment
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>Yes/No</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           At Party (vendor)
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>Yes/No <br>vendor name</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Against C Form
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                          <span>Yes/No</span>
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Reverse Charge
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>Yes/No</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                            Party Bill No.
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>Bill_No_896588</span>
                                                      </td>
                                                   
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Bill Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>20/11/2023</span>
                                                      </td>
                                                   
                                                      
                                                   </tr>

                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Transport Name
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>Transport Name</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Driver Name
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>Driver Name</span>
                                                      </td>
                                                   
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Loaded View (self/party)
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>loaded view name</span>
                                                      </td>
                                                   
                                                     
                                                   </tr>

                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Lr Number
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>LR2135136</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Lr Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>20/11/2023</span>
                                                      </td>
                                                   
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Challan No
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>20112023</span>
                                                      </td>
                                                   
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Challan Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>20/11/2023</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Lr Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>20/11/2023</span>
                                                      </td>
                                                   
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Carring Vehicle No.
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>MH20112023</span>
                                                      </td>

                                                     
                                                   </tr>

                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Reading
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>12313212</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           RST No.
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>RST12313212</span>
                                                      </td>
                                                   
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Gate Pass No.
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>GPN12313212</span>
                                                      </td>
                                                   
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Custom Inward No
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>12313212</span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Custom Inward Date
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>12313212</span>
                                                      </td>
                                                   
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Lab Report No
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span>12313212</span>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>

                                             <div class="row">
                                                <div class="col-md-12">
                                                   <span class="text-color"><h6><b>#<?= isset($po_order_no)?$po_order_no:'';?></b></h6></span>
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                   <span>Encon Group</span>
                                                </div>
                                             </div>
                                             <div class="col-md-12 mt-2 " style="">
                        
                                                <table class="table" >
                                                   <tbody align="center">
                                                      <tr>
                                                         <td class="lbl_class" style="width:4%">Sr. No.</td>
                                                         <td class="lbl_class" style="width:20%">Item</td>
                                                         <td class="lbl_class" style="width:3%">Recv.Qty</td>
                                                         <td class="lbl_class" style="width:3%">Weight</td>
                                                         <td class="lbl_class" style="width:3%">length</td>
                                                         <td class="lbl_class" style="width:3%">Return Qty</td>
                                                         <td class="lbl_class" style="width:3%">Rate</td>
                                                         <td class="lbl_class" style="width:3%">Other Charges</td>
                                                         <td class="lbl_class" style="width:3%">Discount Amount</td>
                                                         <td class="lbl_class" style="width:3%">Gst/Vat Amount</td>
                                                         <td class="lbl_class" style="width:3%">Total Amount</b></td>
                                                      </tr>
                                                 
                                                      <?php $item_sub_amount=0; foreach($grn_item_details_data as $key=>$value) {?>
                                                         <tr>
                                                            <td>
                                                               <span class="">1</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= isset($value['item_name'])?$value['item_name']:'';?></span>
                                                            </td>
                                                            
                                                            <td>
                                                               <span class=""><?= isset($value['received_qty'])?$value['item_weight']:'';?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= isset($value['item_weight'])?$value['item_weight']:'';?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= isset($value['item_length'])?$value['item_length']:'-';?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= isset($value['item_return_qty'])?$value['item_return_qty']:'' ;?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= isset($value['item_other_charges_value'])?$value['item_other_charges_value']:'';?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= isset($value['item_discount_amount'])?$value['item_discount_amount']:'';?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $value['tax_value']?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $value['item_amount'];?></span>
                                                            </td>
                                                         </tr>
                                                      <?php $item_sub_amount= $item_sub_amount + $value['item_sub_amount']; } ?>
                                                   

                                                         <!-- po tax details -->

                                                         <?php foreach($grn_tax_details_data as $key=>$val) {?>
                                                         <tr><td></td></tr>   
                                                         <tr>
                                                            <td colspan="6" align="right">
                                                               <span class="lbl_class">On Item Value</span>
                                                            </td>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">Discount</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['discount_percent']." %"?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['discount_amount']?></span>
                                                            </td>
                                                         </tr>

                                                         <tr>
                                                            <td colspan="6" align="right">
                                                               <span class="lbl_class">On Bal</span>
                                                            </td>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">GST/VAT</span>
                                                            </td>
                                                            <td>
                                                               <span class=""></span>
                                                            </td>

                                                            <td>
                                                               <span class=""><?= $val['gst_amount']?></span>
                                                            </td>
                                                         </tr>

                                                         <tr>
                                                            <td colspan="6" align="right">
                                                               <span class=""></span>
                                                            </td>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">LD Clause</span>
                                                            </td>
                                                            <td>
                                                               <span class=""></span>
                                                            </td>

                                                            <td colspan="1">
                                                               <span class=""><?= $val['ld_charges']?></span>
                                                            </td>
                                                         </tr>

                                                         
                                                         <tr>
                                                            <td colspan="6" rowspan="3" align="right">
                                                               <span class="lbl_class">Freight(F.O.R)</span>
                                                            </td>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">
                                                                  <?php 
                                                                     if($val['freight_type']==1){
                                                                        echo "F.O.R";
                                                                     }else if($val['freight_type']==2) { 
                                                                        echo "TO PAY";
                                                                     }else{
                                                                        echo "-";
                                                                     } 
                                                                  ?>
                                                               </span>
                                                            </td>
                                                            <td>
                                                               <span class=""></span>
                                                            </td>

                                                            <td>
                                                               <span class=""><?= $val['freight_amount'];?></span>
                                                            </td>


                                                         </tr>
                                                         <tr>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class" align="right">VAT/GST on Freight(F.O.R)</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['freight_tax_name']?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['freight_tax_amount']?></span>
                                                            </td>
                                                         </tr>     
                                                         <tr>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class" align="right">Additional VAT on Freight</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['freight_additional_tax_name']?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['freight_additional_tax_amount']?></span>
                                                            </td>

                                                            
                                                         </tr>                                                       
                                                         <tr>
                                                            <td colspan="6"  rowspan="2" align="right">
                                                               <span class="lbl_class">IF Any Other Add</span>
                                                            </td>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class"><?= $val['new_tax_name']?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""></span>
                                                            </td>
                                                            <td>
                                                               <span class="">0</span>
                                                            </td>
                                                         </tr>     
                                                         <tr>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">VAT/GST on If Any Other</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['new_grn_vat_name']?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['new_tax_amount']?></span>
                                                            </td>
                                                         </tr>    

                                                         <tr>
                                                            <td colspan="6" rowspan="2" align="right">
                                                               <span class="lbl_class" >Service Charges</span>
                                                            </td>
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">
                                                               <?php 
                                                                     if($val['service_charge_type']==1){
                                                                        echo "on service charge";
                                                                     }else if($val['service_charge_type']==2) { 
                                                                        echo "on item value";
                                                                     }else{
                                                                        echo "-";
                                                                     } 
                                                                  ?>
                                                               </span>
                                                            </td>
                                                            <td>
                                                               <span class=""></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['service_charge_amount'];?></span>
                                                            </td>
                                                         </tr>     
                                                         <tr>
                                                            
                                                            <td colspan="2" align="right">
                                                               <span class="lbl_class">Service Tax</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['tax_name'];?></span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['service_tax_amount'];?></span>
                                                            </td>
                                                         </tr> 

                                                         <tr>
                                                            <td colspan="9" align="right">
                                                               <span class="lbl_class">Round Off</span>
                                                            </td>
                                                            <td>
                                                               <span class=""><?= $val['round_off']?></span>
                                                            </td>
                                                         </tr>   
                                                          
                                                      <!-- <//?php } ?> -->

                                                      <tr>
                                                         <td colspan="9" align="right"><span style="font-weight:bold;">Sub Total</span></td>
                                                         <td><span style="font-weight:bold;"><//?= $val['item_total_amount']?></span></td>
                                                         
                                                      </tr>
                                                      <tr>
                                                         <td colspan="9" align="right"><span style="font-weight:bold;">Total</span></td>
                                                         <td><span style="font-weight:bold;"><//?= $val['po_final_amount']?></span></td>
                                                         
                                                      </tr>
                                                   <?php } ?>
                                                   </tbody>
                                                    
                                                </table>
                                             </div>
                                          </div>


                                       </div>
                                       
                                   </div>


                                   <div class="tab-pane " id="delivery_billing_site" role="tabpanel">
                                       <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="">
                                             <div class="col-md-12" style="padding: 0px;">
                                                <span class="text-color"><h6><b>GRN Items Details</b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Delivery Days
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_days)?$delivery_days:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Delivery Days Alerts  
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_days_for_alerts)?$delivery_days_for_alerts:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Party
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_party_name)?$delivery_party_name:'';?> </span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Payment Days
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($payment_days)?$payment_days:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Payment Days Alerts  
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($payment_days_for_alerts)?$payment_days_for_alerts:'';?></span>
                                                      </td>
                                                      <td>
                                                         <span class="lbl_class">
                                                             Billing Site  
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($billing_site_name)?$billing_site_name :''; ?></span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Guarantee
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($guarantee)?$guarantee:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Prices
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($prices)?$prices :'-'; ?></span>
                                                      </td>
                                                      <td>
                                                         <span class="lbl_class">
                                                            Delivery Site
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_site_name)?$delivery_site_name :''; ?></span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Address 1
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($address1)?$address1 :'-'; ?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Address 2
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($address2)?$address2 :'-'; ?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Address 3
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($address3)?$address3 :'-'; ?></span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Reference
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($reference)?$reference :'-'; ?></span>
                                                      </td>
                                                   </tr>
                                                  
                                                </tbody>
                                             </table>

                                             <div class="col-md-12" style="padding: 0px;">
                                                <span class="text-color"><h6><b>Cost Project Details</b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:5%">
                                                         <span class="lbl_class">
                                                            Line Before Address
                                                         </span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span><?= isset($line_before_address)?$line_before_address:'';?></span>
                                                      </td>
                                                      <td style="width:5%">
                                                         <span class="lbl_class">
                                                           Address
                                                         </span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span><?= isset($cost_project_address)?$cost_project_address:'';?></span>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>


                                       </div>
                                   </div>



                                   <div class="tab-pane" id="item_tab" role="tabpanel">
                                      <div class="" style="padding: 15px 15px 0px 15px;">
                                       <?php foreach ($po_item_details_data as $key2 => $value2) {?>
                                          
                                          <div class="row">
                                             <div class="col-md-12" style="padding:0px"><hr>
                                                <span class="text-color"><h6><b><?= $key2+1;?>.&nbsp;<?= $value2['item_name'];?></b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 75%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:4%" > <i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%"><span class="lbl_class">
                                                            Item Name  
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><?= $value2['item_name'];?></td>
                                                   </tr>
                                                   <?php 
                                                      if($value2['dispatch_1_lot_date'] && $value2['dispatch_1_lot_qty'] ||
                                                         $value2['dispatch_2_lot_date'] && $value2['dispatch_2_lot_qty'] ||
                                                         $value2['dispatch_3_lot_date'] && $value2['dispatch_3_lot_qty'] ||
                                                         $value2['dispatch_4_lot_date'] && $value2['dispatch_4_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                               </i></td>
                                                            <td style="width:30%" ><span class="lbl_class">
                                                                  Dispatch Schedule Qty  
                                                               </span>
                                                            </td>
                                                            <td><span class="lbl_class">
                                                                  Date
                                                               </span>
                                                            </td>
                                                            <td><span class="lbl_class">
                                                                   Qty  
                                                               </span>
                                                            </td>
                                                         </tr>
                                                         <?php if($value2['dispatch_1_lot_date'] && $value2['dispatch_1_lot_qty']){ ?>
                                                            <tr>
                                                               <td style="width:3%" ></td>
                                                               <td style="width:30%"><span class="lbl_class">
                                                                     Dispatch 1St Lot  
                                                                  </span>
                                                               </td>
                                                               <td style="width:30%" ><?php if($value2['dispatch_1_lot_date']){
                                                                  echo $value2['dispatch_1_lot_date'];
                                                               }?>
                                                              </td>

                                                               <td style="width:30%" ><?php if($value2['dispatch_1_lot_qty']){
                                                                  echo $value2['dispatch_1_lot_qty'];
                                                               }?>
                                                               </td>
                                                            </tr>
                                                         <?php }?>
                                                         <?php if($value2['dispatch_2_lot_date'] && $value2['dispatch_2_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:3%" ></td>
                                                            <td style="width:30%"><span class="lbl_class">
                                                                  Dispatch 2nd Lot  
                                                               </span>
                                                            </td>
                                                            <td style="width:30%" ><?php if($value2['dispatch_2_lot_date']){
                                                               echo $value2['dispatch_2_lot_date'];
                                                            }?>
                                                            </td>

                                                            <td style="width:30%" ><?php if($value2['dispatch_2_lot_qty']){
                                                               echo $value2['dispatch_2_lot_qty'];
                                                            }?>
                                                            </td>
                                                         </tr>
                                                      <?php }?>
                                                      <?php if($value2['dispatch_3_lot_date'] && $value2['dispatch_3_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:3%" ></td>
                                                            <td style="width:30%"><span class="lbl_class">
                                                                  Dispatch 3rd Lot   
                                                               </span>
                                                            </td>
                                                            <td style="width:30%" ><?php if($value2['dispatch_3_lot_date']){
                                                               echo $value2['dispatch_3_lot_date'];
                                                            }?>
                                                            </td>

                                                            <td style="width:30%" >
                                                               <?php if($value2['dispatch_3_lot_qty']){
                                                               echo $value2['dispatch_3_lot_qty'];
                                                            }?>
                                                            
                                                            </td>
                                                         </tr>
                                                      <?php }?>
                                                      <?php if($value2['dispatch_4_lot_date'] && $value2['dispatch_4_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:3%" ></td>
                                                            <td style="width:30%"><span class="lbl_class">
                                                                 Dispatch 4th Lot  
                                                               </span>
                                                            </td>
                                                            <td style="width:30%" ><?php if($value2['dispatch_4_lot_date']){
                                                               echo $value2['dispatch_4_lot_date'];
                                                            }?>

                                                            </td>

                                                            <td style="width:30%" ><?php if($value2['dispatch_4_lot_qty']){
                                                               echo $value2['dispatch_4_lot_qty'];
                                                            }?>
                                                            </td>
                                                         </tr>
                                                      <?php }?>
                                                   <?php }?>

                                                   <tr>
                                                      <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%" ><span class="lbl_class">
                                                           Item Description
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><span>
                                                            <?= isset($value2['item_description'])?$value2['item_description']:'';?>
                                                         </span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%" ><span class="lbl_class">
                                                           Other Description
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><span>
                                                            <?= isset($value2['other_description'])?$value2['other_description']:'';?>
                                                         </span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%" ><span class="lbl_class">
                                                           Technical Description
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><span>
                                                            <?= isset($value2['technical_description'])?$value2['technical_description']:'';?>
                                                         </span>
                                                      </td>
                                                   </tr>

                                                </tbody>
                                             </table>
                                          </div>
                                          <?php }?>
                                       </div>
                                   </div>

                                   <div class="tab-pane" id="terms_condition" role="tabpanel">
                                      <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="row">
                                             <div class="col-md-12">
                                                      <span class="text-color"><h6><b>Terms & Condition</b></h6></span><hr> 
                                                   </div>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="row col-md-12">
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Terms & Condition</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                            <?= isset($terms_and_condition)?$terms_and_condition:'';?>
                                                         </span>
                                                      </div>
                                                      
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12 ">
                                                <div class="row">
                                                   <div class="form-group col-md-2">
                                                         <label class="lbl_class">Remark</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($remark)?$remark:'';?></span>
                                                      </div>
                                                      <div class="col-md-1"></div>
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Jurisdiction</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($jurisdiction)?$jurisdiction:'';?></span>
                                                      </div>
                                                     <div class="col-md-1"></div>

                                                     <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Line in bottom</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($line_in_bottom)?$line_in_bottom:'';?></span>
                                                      </div>
                                                      <div class="col-md-1"></div>
                                                      
                                                      <div class="col-md-1"></div>
                                                </div>
                                             </div>

                                             <div class="col-md-12 ">
                                                <div class="row">
                                                   <div class="col-md-12">
                                                      <span class="text-color"><h6><b>Attach Files</b></h6></span><hr> 
                                                   </div>
                                                    <?php $i=1;
                                                      if($attachment_file){
                                                         foreach ($attachment_file as $key => $value){?>
                                                            <div class="col-md-2">
                                                               <a class="image-popup-vertical-fit" href="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>"> 
                                                               <div class="col-md-6">
                                                                  <img class="image-popup-vertical-fit" src="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" height="50px"></a>  
                                                               </div>
                                                               </a>
                                                            </div>
                                                         <?php $i++; } }else{ ?> 
                                                            <div class="col-md-6">
                                                               <center>NO Data</center>
                                                            </div>
                                                   <?php } ?>
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
      </div>

</div>
</div><br><br>
<!-- end row -->

<div id="display_item_details" class="modal fade mymodal" data-backdrop="static" data-keyboard="false"   role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div id="_item_details"></div>
       </div>
  </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLongTitle">Send a purchase order</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
            <form action="<?= base_url();?>admin/PO/sendMailWithattchement" enctype="multipart/form-data" method="post" class="form-upload" id="form_email" autocomplete="off">
               <input type="hidden" name="id_vendor" id="id_vendor" class="form-control po_status id_vendor" value="<?= isset($vendor_id)?$vendor_id :'';?>" >
               <input type="hidden" name="poid" id="poid" class="form-control" value="<?= isset($id)?$id :'';?>" >
            
               <div class="col-md-12">
                  <label class="lbl_class"><b style="color:red">*</b> Vendor Email</label>
                  <select class="form-control select2 mr_btm email_bg vendor_email_id" name="vendor_email_id[]" multiple="mutiple" id="" style=" width:100%;">
                     <?php
                         foreach ($vendor_master_email as $key => $value) {
                           if((isset($vendor_id)&&$vendor_id==$value['vendor_id'])){
                            $selected="selected";
                             }else{
                             $selected="";
                           } ?>
                        <option value="<?= $value['email_id'] ?>"  <?= $selected; ?>><?= $value['email_id']?></option>
                     <?php } ?>
                  </select> 
               </div>

               <div class="col-md-12" style="margin:10px 0px 10px 0px;">
                  <label class="lbl_class"><b style="color:red">*</b> Send to</label>
                  <select class="form-control select2 mr_btm email_bg idemail" required name="email_id[]" multiple="mutiple" id="" style=" width:100%;">
                     <?php
                         foreach ($user_email as $key => $value) {
                           if((isset($created_by)&&$created_by==$value['id'])){
                            $selected="selected";
                             }else{
                             $selected="selected";
                           } ?>
                        <option value="<?= $value['email'] ?>"  <?= $selected; ?>><?= $value['email'] ?></option>
                     <?php } ?>
                  </select> 
               </div>
               
               <div class="form-group col-md-12"  style="margin:10px 0px 0px 0px;">
                  <label class="lbl_class">Subject</label>
                  <input  type="text" class="form-control" id="subject"  name="subject">
               </div>

               <div class="col-md-12" style="margin:10px 0px 0px 0px;">
                  <input type="checkbox" id="check" name="checkbox" value="1"><label>&emsp;Attach Purchase Order Files</label>&emsp;
                  <input type="checkbox" id="checkbox_po_invoice_pdf_name" name="checkbox_po_invoice_pdf_name" value="1"><label>&emsp;Attach PO Invoice Pdf File</label>
               </div>
               
               <div class="col-md-12" id="file_attach" style="display: none;">
                  <div class="row">
                      <?php $i=1;
                        if($attachment_file){
                           foreach ($attachment_file as $key => $value){?>
                              <div class="col-md-offset-3" style="padding:5px">
                                 <a class="image-popup-vertical-fit" id="ipsum" href="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" style="z-index: 1051"> 
                                    <div class="col-md-4">
                                       <img class="image-popup-vertical-fit" id="lorem" src="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" height="50px"></a>  
                                    </div>
                                 </a>
                              </div>
                           <?php $i++; } 
                        }else{ ?> 
                           <div class="col-md-6">
                              <center>NO Data</center>
                           </div>
                     <?php } ?>
                  </div>
               </div>  
               <div class="form-group col-md-12 po_invoice_pdf"  style="margin:10px 0px 0px 0px; display: none;">
                  <label class="lbl_class">PO Invoice Pdf Name</label>
                  <?php if(isset($po_invoice_pdf_name)){?>
                        <input  type="hidden" class="form-control" name="po_invoice_pdf_name" value="<?= isset($po_invoice_pdf_name)?$po_invoice_pdf_name :'';?>" >
                        <span class=""><a target="_blank" href="<?= base_url(); ?><?=PO_PDF_PATH ?><?= $po_invoice_pdf_name?>"><p><?= isset($po_invoice_pdf_name)?$po_invoice_pdf_name :'';?></p></a></span>   
                  <?php } ?>
                  
               </div>

               <div class="form-group col-md-12" style="margin:10px 0px 0px 0px;">
                  <label class="lbl_class">Message</label>
                   <textarea type="text"  id="message1" name="message" required class="form-control message" ></textarea>
               </div>


               <div class="form-group col-md-12"  style="margin:10px 0px 0px 0px;">
                  <label class="lbl_class">Additional AttacheMent</label>
                   <input id="multiplefileupload" type="file" class="form-control" name="additional_attacheMent[]" multiple />
                  <!-- <input  type="file" class="form-control"  name="additional_attacheMent[]" multiple > -->
               </div>



               <div class="modal-footer" style="margin-top: 15px;">
                 <button type="button" class="btn btn-secondary btn-theme" data-dismiss="modal">Close</button>
                 <input type="submit" class="btn btn-info btn-theme" style="" value="Send">
               </div>
            </form>

         </div>
      
    </div>
  </div>
</div>
<br>

<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/po.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/config.js"></script>

<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>

<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>

<script>
  
    $('#chg_status').on('change', function() {
      var status = $('#chg_status').val();
      // alert(status);
      if(status == 1){
         $('#reason').hide();
         $('#submit_btn').show();
      }else if(status == 2){
        $('#reason').show();
        $('#submit_btn').show();
      }else{
         $('#reason').hide();
         $('#submit_btn').hide();
      }
    });
   
</script>

<script type="text/javascript">
   $('#check').change(function(){
      var checked = $('#check').is(':checked');
         // alert(checked); 
      if(checked == true){
         $('#file_attach').show();
      }else{
         $('#file_attach').hide();
      }
  });


   $('#checkbox_po_invoice_pdf_name').change(function(){
      var checked_a = $('#checkbox_po_invoice_pdf_name').is(':checked');
         // alert(checked_a);
      if(checked_a == true){
         $('.po_invoice_pdf').show();
      }else{
         $('.po_invoice_pdf').hide();
      }

   });


   CKEDITOR.replace( 'message',{
     height: '100px'   ,
     uiColor: '#383f48'    
   });
</script>


    <script>
 $(document).ready(function() {
    getPOListingVendorSiteData();
  
});
    
</script>
