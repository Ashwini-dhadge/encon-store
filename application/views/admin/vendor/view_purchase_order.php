<?php init_header();?>

<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">

<style>
   .lbl_class{
      font-weight: bold;
   }
   .customtab li a.nav-link {
      padding: 4px 8px;
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
      <div class="col-4">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 ">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Purchase Order Details</b></h6></span><hr> 
                        </div>

                      
                        <div class="form-group col-md-12 ">
                           <div class="table-responsive">
                              <table id="purchser_order_tbl" class="table display table-bordered text-center" width="100%">
                              </table>
                           </div>
                        </div>

                     </div>
                  
                     
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-8">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 ">
                     <div class="row">
                        <div class="col-md-12">
                         
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs customtab" role="tablist">
                                  <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#purchase_order" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down text-color"><h6><b>Purchase Order Info</b></h6></span></a> </li>
                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#delivery_billing_site" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><h6><b>Delivery/Billing Site</b></h6></span></a> </li>
                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#terms_condition" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"><h6><b>Terms & Condition</b></h6></span></a> </li>
                              </ul>
                         

                               <!-- Tab panes -->
                               <div class="tab-content">
                                   <div class="tab-pane active" id="purchase_order" role="tabpanel">
                                       <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="row">
                                             <div class="col-md-7 ">
                                                <div class="row">
                                                   <div class="row col-md-12">
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Po Order No.</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>PO-0004-Nov-2023-ABCNSK001</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Vendor</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Vendor Name</span>
                                                      </div>
                                                      
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Po Date.</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>10/09/2023</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">PO Valid From and To</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>10/08/2023 - 11/09/2023</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Address</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Address Address</span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-5 ">
                                                <div class="row">
                                                   <div class="col-md-5" style="padding:0px 5px;">
                                                      <select class="form-control select2 mr_btm" name="" id="" >
                                                         <option >Change Status to</option>
                                                         <option value="1">Active</option>
                                                         <option value="2">In-Active</option>
                                                      </select> 
                                                   </div>
                                                   <div class="col-md-3 " style="padding:0px 5px;">
                                                      <select class="form-control select2 mr_btm" name="" id="" >
                                                         <option >More</option>
                                                         <option value="1">Yes</option>
                                                         <option value="2">No</option>
                                                      </select> 
                                                   </div>
                                                   <div class="col-md-2 " style="padding:0px 5px;">
                                                      <select class="form-control select2 mr_btm" name="" id="" >
                                                         <option></option>
                                                         <option value="1">Yes</option>
                                                         <option value="2">No</option>
                                                      </select> 
                                                   </div>
                                                   <div class="col-md-2 " style="padding:0px 5px ;">
                                                      <button type="button" class="btn btn-info btn-theme" data-toggle="modal" data-target="#exampleModalCenter">
                                                         <i class="mdi mdi-email"></i></button>
                                                   </div>
                                                </div>
                                             </div>



                                          </div><hr>
                                          <div class="row">
                                             <div class="col-md-7">
                                                <div class="col-md-12">
                                                   <span class="text-color"><h6><b>#PO-0004-Nov-2023-ABCNSK001 - Encon1</b></h6></span>
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                   <span>Encon Group</span>
                                                </div>
                                             </div>
                                             <div class="col-md-5">
                                                <span class="lbl_class">Dispatch Schedule Qty</span>
                                                
                                                <div class="row col-md-12" style="margin-top: 5px;">
                                                   <div class="col-md-3 ">
                                                      <sapn class="lbl_class">01/09/2023</sapn>
                                                   </div>
                                                   <div class=" col-md-3 ">
                                                      <span>40</span>
                                                   </div>
                                                   
                                                   <div class="col-md-3 ">
                                                      <sapn class="lbl_class">03/09/2023</sapn>
                                                   </div>
                                                   <div class="col-md-3 ">
                                                      <span>40</span>
                                                   </div>
                                                   <div class="col-md-3 ">
                                                      <sapn class="lbl_class">04/09/2023</sapn>
                                                   </div>
                                                   <div class="col-md-3 ">
                                                      <span>44</span>
                                                   </div>
                                                   <div class="col-md-3 ">
                                                      <sapn class="lbl_class">05/09/2023</sapn>
                                                   </div>
                                                   <div class="form-group col-md-3 ">
                                                      <span>30</span>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-12 mt-2 " style="">
                  
                                             <table class="table" border="1">
                                                <tbody align="center">
                                                   <tr>

                                                      <td style="width:4%"><b>Sr. No.</b></td>
                                                      <td style="width:20%"><b>Item</b></td>
                                                      
                                                      <td style="width:16%"><b>Description</b></td>
                                                      <td style="width:16%"><b>Other Description</b></td>
                                                      <td style="width:16%"><b>Technical Description</b></td>
                                                      
                                                      <td style="width:2%"><b>Size/Part_No/ Grade</b></td>
                                                      <td style="width:2%"><b>Qty/Unit</b></td>
                                                      <td style="width:2%"><b>Weight</b></td>
                                                      <td style="width:3%"><b>Unit Rate</b></td>
                                                      <td style="width:3%"><b>Item Amount</b></td>
                                                      <td style="width:3%"><b>Discount Amount</b></td>
                                                      <td style="width:3%"><b>Gst/Vat Amount</b></td>
                                                      
                                                      <td style="width:2%"><b>Total Amount</b></td>
                                                     

                                                   </tr>
                                              
                                                   
                                                      <tr>
                                                         <td>
                                                            <span class="">1</span>
                                                         </td>
                                                         <td>
                                                            <span class="">test 1</span>
                                                         </td>
                                                         <td>
                                                            <span class="">1</span>
                                                         </td>
                                                         <td>
                                                            <span class="">1</span>
                                                         </td>
                                                         <td>
                                                            <span class="">1</span>
                                                         </td>
                                                         <td>
                                                            <span class="">1</span>
                                                         </td>
                                                         <td>
                                                            <span class="">2</span>
                                                         </td>
                                                         <td>
                                                            <span class="">195.00</span>
                                                         </td>
                                                         <td>
                                                            <span class="">40.00</span>
                                                         </td>
                                                         <td>
                                                            <span class="">50.00</span>
                                                         </td>
                                                         <td>
                                                            <span class="">60.00</span>
                                                         </td>
                                                         <td>
                                                            <span class="">70.00</span>
                                                         </td>
                                                         <td>
                                                            <span class="">195.00</span>
                                                         </td>

                                                        

                                                      </tr>
                                                      
                                                      <tr>
                                                         <td colspan="12" align="right"><span style="font-weight:bold;">Sub Total</span></td>
                                                         <td><span style="font-weight:bold;">195.00</span></td>
                                                         
                                                      </tr>
                                                      <tr>
                                                         <td colspan="12" align="right"><span style="font-weight:bold;">Total</span></td>
                                                         <td><span style="font-weight:bold;">195.00</span></td>
                                                         
                                                      </tr>
                                                 
                                                </tbody>
                                                 
                                             </table>

                                             <!-- tax details -->
                                             <table class="table" border="1">
                                                <tbody>
                                                   <tr>
                                                      <!-- <td style="width:4%"><b>Sr. No.</b></td>
                                                      <td style="width:30%"><b>Item</b></td>
                                                      <td style="width:5%"><b>Quantity</b></td>
                                                      <td style="width:5%"><b>Unit Price</b></td>
                                                      <td style="width:5%"><b>Into Money</b></td>
                                                      <td style="width:5%"><b>Tax</b></td>
                                                      <td style="width:5%"><b>Sub Total</b></td>
                                                      <td style="width:5%"><b>Discount</b></td>
                                                      <td style="width:10%"><b>Discount (money)</b></td>
                                                      <td style="width:10%"><b>Total</b></td> -->
                                                   </tr>
                                                      <tr>
                                                         <td align="left">
                                                            <span class="lbl_class">On Item Value</span>
                                                         </td>
                                                         <td align="right">
                                                            <span class="lbl_class">Discount</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>

                                                      <tr>
                                                         <td align="left">
                                                            <span class="lbl_class">On Bal</span>
                                                         </td>
                                                         <td align="right">
                                                            <span class="lbl_class">GST/VAT</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>

                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>

                                                      <tr>
                                                         <td align="left">
                                                            <span class=""></span>
                                                         </td>
                                                         <td align="right">
                                                            <span class="lbl_class">LD Clause</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>

                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>

                                                      
                                                      <tr>
                                                         <td rowspan="3" align="left">
                                                            <span class="lbl_class">Freight(F.O.R)</span>
                                                         </td>
                                                         <td>
                                                            <span class="lbl_class">F.O.R/TO PAY</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>

                                                         <td>
                                                            <span class="">0</span>
                                                         </td>


                                                      </tr>
                                                      <tr>
                                                         <td>
                                                            <span class="lbl_class" align="right">VAT/GST on Freight(F.O.R)</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>     
                                                      <tr>
                                                         <td>
                                                            <span class="lbl_class" align="right">Additional VAT on Freight</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>

                                                         
                                                      </tr>                                                       
                                                      <tr>
                                                         <td rowspan="1" align="left">
                                                            <span class="lbl_class">IF Any Other Add</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>     
                                                      <tr>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td align="left"    >
                                                            <span class="lbl_class">VAT/GST on If Any Other</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>    

                                                      <tr>
                                                         <td rowspan="left" align="left">
                                                            <span class="lbl_class" >Service Charges</span>
                                                         </td>
                                                         <td>
                                                            <span class="lbl_class">on service charge/on item value</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>     
                                                      <tr>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class="lbl_class">Service Tax</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr> 

                                                      <tr>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td align="right">
                                                            <span class="lbl_class">Round Off</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>   

                                                      <tr>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td align="right">
                                                            <span class="lbl_class">Total PO Value</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>                                                       
                                                 
                                                </tbody>
                                                 
                                          </table>

                                          </div>
                                       </div>
                                   </div>


                                   <div class="tab-pane " id="delivery_billing_site" role="tabpanel">
                                       <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="row">
                                             <div class="col-md-4">
                                                <div class="row">
                                                   <div class="row col-md-12">
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Delivery Days</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>44</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Payment Days</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>56</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Guarantee</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Return</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                          <label class="lbl_class">Address 1</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Address</span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Reference</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Reference Reference Refe Refer Reference Reference Reference Reference</span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-4 ">
                                                <div class="row">
                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">For Alerts</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>44</span>
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">For Alerts</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>alert</span>
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">Prices</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>Return</span>
                                                   </div>

                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">Address 2</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>Address</span>
                                                   </div>


                                                </div>
                                             </div>
                                             <div class="col-md-4 ">
                                                <div class="row">
                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">Billing Site</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>44</span>
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">Delivery Site</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>alert</span>
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">Party</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>Return</span>
                                                   </div>

                                                   <div class="form-group col-md-4 ">
                                                      <label class="lbl_class">Address 3</label>
                                                   </div>
                                                   <div class="form-group col-md-8 ">
                                                      <span>Address</span>
                                                   </div>

                                                </div>
                                             </div>
                                             
                                          </div>
                                       </div>
                                   </div>

                                   <div class="tab-pane" id="terms_condition" role="tabpanel">
                                      <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="row">
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="row col-md-12">
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Terms & Condition</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                            Term. This Agreement is effective from the date both parties sign the Acceptance Documents and shall remain in force until expiry or termination of all SOWs and Order Forms in accordance with this Agreement.
                                                            
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
                                                         <span>56</span>
                                                      </div>
                                                      <div class="col-md-1"></div>
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Jurisdiction</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Return</span>
                                                      </div>
                                                     <div class="col-md-1"></div>

                                                     <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Line in bottom</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>Return</span>
                                                      </div>
                                                      <div class="col-md-1"></div>
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Attach Files</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>File 1, File 2</span>
                                                      </div>
                                                      <div class="col-md-1"></div>
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


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Send a purchase order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="col-md-12">
               <label><b style="color:red">*</b> Send to</label>
               <select class="form-control select2 mr_btm" name="" id="" >
                  <option ></option>
                 
               </select> 
            </div>
            
            <div class="col-md-12" style="margin:10px 0px 10px 0px;">
               <input type="checkbox" id="" name="" value=""><label for="vehicle1">&emsp;Attach Purchase Order Pdf</label>
            </div>  


            <div class="form-group col-md-12">
               <label>Message</label>
                  <textarea id="message" name="message" class="form-control" cols="2">
                  </textarea>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-theme" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info btn-theme">Send</button>
      </div>
    </div>
  </div>
</div>
<br>

<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/po.js"></script>
<script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>
    <script type="text/javascript">

      CKEDITOR.replace( 'message',{
        height: '100px'   ,
        uiColor: '#383f48'    
      });
    $("#frm_validate").validate();
    </script>