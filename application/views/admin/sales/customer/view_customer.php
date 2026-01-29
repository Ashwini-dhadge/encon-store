<?php init_header(); ?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<style>
   body {
   font-family: "Lato Regular", sans-serif;
   }
   .form-group {
   min-height: 28px;
   font-size: 14px;
   }
   .form-control {
   font-size: 0.8rem;
   }
   label{
   margin-bottom: 0.2rem;
   }
   textarea{
   height:0px !important;
   }
   /*label.error{
   display: none !important;
   }*/
   .error{
   color:red;
   }
   .sd{
   display: none;
   }
   hr {
   margin-top: 0.5rem;
   }
   .text_area{
   margin-top: -4px !important;
   line-height: 2 !important;
   }
   .margin-bottom-7{
   margin-bottom:10px !important;
   }
   .select2-container{
   margin-bottom: 7px !important;
   }
   .upper_case
   {
   text-transform: uppercase;
   }
   .select2-selection{
   height: 27px !important;
   }

   .status_size{
      font-size:15px;
    }
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<div class="row">
   <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card">
         <div class="card-body">
            <h4 class="card-title m-t-10" style="font-weight: bold;">Wind Hans Technologies</h4>
            <hr>
            <h6 style="color: #20aee3 !important;">Profile</h6>
            <hr style="border-bottom: 2px solid #20aee3;">
            <h6>Invoices</h6>
            <hr>
            <h6>Payments</h6>
            <hr>
            <h6>Projects</h6>
            <hr>
            <h6>Files</h6>
            <hr>
            <h6>Reminders</h6>
            <hr>
            <h6>Notes</h6>
            <hr>
         </div>
         <div>
         </div>
      </div>
   </div>
   <div class="col-lg-8 col-xlg-9 col-md-7">
      <div class="card">
         <h4 class="card-title m-t-10 m-l-10" style="font-weight: bold;">Profile</h4>
         <hr>
         <ul class="nav nav-tabs profile-tab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#customerdetails" role="tab">Customer Details</a> </li>
           <!--  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#billing_shipping" role="tab">Billing&Shipping</a> </li> -->
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#contact" role="tab">Contacts</a> </li>
            <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#staff" role="tab">Staff</a> </li> -->
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#opportunity_tracker" role="tab">Opportunity Tracker</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#plant_customer" role="tab">Plant</a> </li>
         </ul>
         <div class="tab-content">
            <div class="tab-pane active" id="customerdetails" role="tabpanel">
               <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                       <span class="text-color">
                           <h6><b>Customer Details</b></h6>
                        </span><hr>
                        <table class="table">
                            
                            <tbody>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Company</th>
                                    <td class="p-1"><?= (isset($company_name))? $company_name : '' ?></td>
                                </tr>    
                                
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Address </th>
                                    <td class="p-1"><?= (isset($address))? $address : '' ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1" style="width:51%;">Phone </th>
                                    <td class="p-1"><?= (isset($phone))? $phone : '' ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Email </th>
                                    <td class="p-1"><?= (isset($email))? $email : '' ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">City</th>
                                    <td class="p-1"><?= (isset($city_data[0]['name']))? $city_data[0]['name'] : '' ?></td>
                                </tr>
                               
                                
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Country</th>
                                    <td class="p-1"><?= (isset($country_data[0]['name']))? $country_data[0]['name'] : '' ?></td>
                                </tr>
                                
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">State:</th>
                                    <td class="p-1"><?= (isset($state_data[0]['name']))? $state_data[0]['name'] : '' ?>
                                       </td>
                                </tr>

                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Currencies:</th>
                                    <td class="p-1">
                                   
                                     <?php
                                            if($currency==1){
                                                echo "INR";
                                            }elseif($currency==''){
                                                echo "-";
                                            }
                                        ?> 

                                       </td>
                                </tr>

                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Rate Type:</th>
                                    <td class="p-1">
                                       
                                        <?php
                                            if($rate_type==1){
                                                echo "KG";
                                            }elseif($rate_type==''){
                                                echo "-";
                                            }
                                        ?> 
                                </tr>

                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Post Code:</th>
                                    <td class="p-1"><?= (isset($post_code))? $post_code : '' ?> 
                                       </td>
                                </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Vat:</th>
                                    <td class="p-1"><?= (isset($vat))? $vat : '' ?> 
                                       </td>
                                </tr>

                               <!--  <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Description:</th>
                                    <td class="p-1"><p class="word_wrap"><//?= isset($vendor_data['description'])? $vendor_data['description']:'';?></p></td>
                                </tr> -->


                                
                            </tbody>
                        </table> 
                    </div>
                    <div class="col-lg-6">
                        <span class="text-color">
                            <h6><b>Billing&Shipping Details</b></h6>
                        </span><hr>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Billing Company</th>
                                    <td class="p-1"><?= (isset($billing_company))? $billing_company : '' ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Billing Street</th>
                                    <td class="p-1"><?= (isset($b_street))? $b_street : '' ?></td>
                                </tr>
                                
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Billing Post Code:</th>
                                    <td class="p-1">
                                     <?= (isset($b_post_code))? $b_post_code : '' ?>   
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Billing City:</th>
                                    <td class="p-1">
                                    <?= (isset($b_city_data[0]['name']))? $b_city_data[0]['name'] : '' ?>
                                    </td>
                                </tr>

                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Billing Country:</th>
                                    <td class="p-1">
                                    <?= (isset($b_country_data[0]['name']))? $b_country_data[0]['name'] : '' ?>
                                    </td>
                                </tr>

                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Billing State:</th>
                                    <td class="p-1">
                                        <?= (isset($b_state_data[0]['name']))? $b_state_data[0]['name'] : '' ?> 
                                    </td>
                                </tr>


                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Shipping Street</th>
                                    <td class="p-1"><?= (isset($s_street))? $s_street : '' ?></td>
                                </tr>

                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Shipping Post Code</th>
                                    <td class="p-1">
                                       <?= (isset($s_post_code))? $s_post_code : '' ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Shipping City</th>
                                    <td class="p-1"> <?= (isset($s_city_data[0]['name']))? $s_city_data[0]['name'] : '' ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Shipping Country</th>
                                    <td class="p-1"><?= (isset($s_country_data[0]['name']))? $s_country_data[0]['name'] : '' ?></td>
                                </tr>

                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;">Shipping State</th>
                                    <td class="p-1"><?= (isset($s_state_data[0]['name']))? $s_state_data[0]['name'] : '' ?> </td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>  
                  </div><hr>
               </div>
            </div>
           
            <div class="tab-pane" id="contact" role="tabpanel">
                <div class="col-md-12 mt-3">
                        <h4 class="card-title col-md-6 float-left">Contact Details</h4>
                        <div class="col-md-6 float-right align-self-center text-right d-none d-md-block">
                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn-sm customer_contact_form" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" data-id="" ><i class="fa fa-plus-circle"></i> Add </a>
                        </div>
                </div>
                <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_customer_contact_details" class="table display table-bordered" width="100%">
                            </table>
                        </div>
                </div>
            </div>
            <!-- <div class="tab-pane" id="staff" role="tabpanel">
               <div class="card-body">
                  4
               </div>
            </div> -->

            <div class="tab-pane" id="opportunity_tracker" role="tabpanel">
               
               <div class="card-body">
                   <div class="">
                  
                       <input type="hidden" name="customer_id" class="customer_name" id="customer_id" value="<?= (isset($id))? $id : '' ?> ">
                       <div class="row">
                           <div class="col-md-5">
                              <h4 class="card-title">Opportunity Tracker</h4>
                           </div>
                           <!-- <div class="col-md-7 align-self-center text-right d-none d-md-block">
                              <a class="btn btn-info btn-theme opp_tracker_modal" data-toggle="modal" data-target="#opp_tracker_modal" ><i class="fa fa-plus-circle"></i>Add Opportunity</a>
                           </div> -->

                        </div>


                        <div class="row">
                            <div class="col-md-4"></div>
                                <div class="col-md-2" style="padding:3px">
                                    <label>Plant Name</label>
                                    <select class="form-control select2 did-floating-select plant_idd"  id="plantid"   name="plant_id" value="" onchange="filter_customer()" style="width:100%">
                                        <option value="all" selected>All</option>
                                    </select>
                                </div>
                                <div class="col-md-2" style="padding:3px">
                                    <label>Status</label>
                                    <select class="form-control select2 did-floating-select status_id"  id="status_id"   name="status_id" value="" onchange="filter_customer()">
                                        <option value="">All</option>
                                        <option value="<?= OPPORTUNITY_STATUS_INPROCESS ?>">In-Process</option>
                                        <option value="<?= OPPORTUNITY_STATUS_COMPLETE ?>">Complete</option>
                                    </select>
                                </div>
                                

                            <div class="col-md-4"></div>
                        </div>
                         <div class="row" style="margin-top:5px">
                        <div class="col-md-4"></div>
                                <div class="col-md-4 text-center d-none d-md-block">
                                          <button class="status_size in_process" style="background: #ff9041;color:whitesmoke;border:#48bc97 1px solid;display: none;"><b>In-process :- &nbsp;&nbsp;<span class="total_count"></span></b>
                                          </button>
                                          
                                          <button class="status_size complete" style="background: #48bc97;color:whitesmoke;border: #48bc97 1px solid;display: none;"><b>Complete :- &nbsp;&nbsp;<span class="total_count"></span></b>
                                          </button>
        
                                          <button class="status_size all_count" style="background: #ffffff;border: #48bc97 1px solid;"><b>All Opportunity :- &nbsp;&nbsp;<span class="total_count"></span></b>
                                          </button>
                                   </div>
        
                                <div class="col-md-4 text-right">
                                        <button class="status_size " style="background: #ff9041;color:whitesmoke;border:#48bc97 1px solid;"><b>In-process :- &nbsp;&nbsp;<span class=""><?= $inprocess_status_cnt;?></span></b>
                                        </button>
                                          
                                        <button class="status_size " style="background: #48bc97;color:whitesmoke;border: #48bc97 1px solid;"><b>Complete :- &nbsp;&nbsp;<span class=""><?= $complete_status_cnt;?></span></b>
                                        </button>
                                </div>
                        </div>
                        


                       <table id="tbl_customer_opp_tracker" class="table display table-bordered" width="100%">
                       </table>
                    </div>
               </div>
            </div>


            <div class="tab-pane" id="plant_customer" role="tabpanel">
               
               <div class="card-body">
                   <div class="">
                       <!-- <input type="hidden" name="customer_id" id="customer_id" value="<?= (isset($id))? $id : '' ?> "> -->
                       <div class="row">
                           <div class="col-md-5">
                              <h4 class="card-title">Plant Details</h4>
                           </div>
                           <div class="col-md-7 align-self-center text-right d-none d-md-block">
                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn-sm customer_plant_form" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" data-id="" ><i class="fa fa-plus-circle"></i> Add </a>
                           </div>

                        </div>
                        <!-- <div class="row">
                            <div class="col-md-4"></div>
                                <div class="col-md-2" style="padding:0px">
                                    <label>Status</label>
                                    <select class="form-control select2 did-floating-select status_id"  id="status_id"   name="status_id" value="" onchange="filter_customer()">
                                        <option value="">All</option>
                                        <option value="1">In-Process</option>
                                        <option value="2">Complete</option>
                                    </select>
                                </div>
                            <div class="col-md-5"></div>
                        </div> -->


                        <div class="table-responsive">
                            
                           <table id="tbl_customer_plant" class="table display table-bordered" width="100%">
                           </table>
                        </div>
                    </div>
               </div>
            </div>


            
         </div>
      </div>
   </div>
</div>
<div id="customer_plant_form" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_customer_plant"></div>
      </div>
   </div>
</div>

<div id="_view_customer_plant_data" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_view_customer_plant"></div>
      </div>
   </div>
</div>

<div id="_view_customer_contact_data" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_view_customer_contact"></div>
      </div>
   </div>
</div>

<div id="customer_contact_form" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_customer_contact"></div>
      </div>
   </div>
</div>

<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>

<script src="<?= base_url();?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url();?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

<script src="<?= base_url(); ?>assets/js/page-js/sales/customer.js"></script>


<script>
   $(document).ready(function () {
   
    $('#form').validate({ 
         
         submitHandler: function(form) {
             form.submit();
         }
     });
   });
</script>
    <script> 
        $('.status_id').on('change', function () { 
         var status = $('.status_id').val();
            
            if (status == 1) { 
               $('.in_process').show(); 
               $('.complete').hide(); 
               $('.all_count').hide(); 
            } 
            else if (status == 2) { 
               $('.in_process').hide(); 
               $('.complete').show(); 
               $('.all_count').hide();
            }else {
               $('.in_process').hide(); 
               $('.complete').hide(); 
               $('.all_count').show();
            } 
            
        }); 




        $('.plant_idd').select2({
            ajax: {
                url:base_url +'admin/Common/plant_name_list_SA',       
                  dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term,
                        'customer_id' :$('.customer_name').val(),
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        }); 




    </script> 
<style>
   .error{
   color: red;
   }
</style>
