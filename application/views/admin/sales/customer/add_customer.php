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
   height: 28px !important;
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
 <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
             
                 <form action="<?= base_url();?>admin/sales/Customer/add_customer"  enctype="multipart/form-data" method="post" id="frm" autocomplete="off">
                 <!--  <input type="hidden" name="id" id="id" value="<?= isset($customer)? $customer['id'] : '' ?>"> -->
                   <input type="hidden" name="id" id="id" value="<?= (isset($customer_id))? $customer_id : '' ?>">
                   <input type="hidden" name="lead_id" id="lead_id" value="<?= (isset($lead_id))? $lead_id : '' ?>">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color"><h6><b>Customer Details</b></h6></span><hr> 
                           </div>
                          
                        </div>
                        
                     </div>

                     <div class="col-md-12 mb-3">
                        <div class="row">
                          
                           <div class="form-group col-md-3 ">
                              <label class="">Company</label>
                              <input class="form-control " type="text" name="company_name" required value="<?= (isset($company_name))? $company_name : '' ?>" >
                              
                           </div>

                           <div class="form-group col-md-3 ">
                              <label class="">Address</label>
                              <input class="form-control " type="text" name="address"  value="<?= (isset($address))? $address : '' ?>" >
                             
                           </div>
                           <div class="form-group col-md-3 ">
                              <label class="">Phone</label>
                              <input class="form-control mobile" type="text" name="phone"  value="<?= (isset($phone))? $phone : '' ?>" >
                           </div>

                           <div class="form-group col-md-3 ">
                             <label class="">Email</label>
                                             <input class="form-control " type="email" name="email"  value="<?= (isset($email))? $email : '' ?>" >
                           </div>
                           
                       
                           <div class="form-group col-md-3">
                                 <label class="control-label">City</label>
                                    <select class="form-control select2 did-floating-select cust_city_name b_city_name"  name="city_id" id="city_id" >
                                       <?php
                                          foreach ($city_data as $key => $value) {
                                             if((isset($city_id['name'])&&$city_id['name']==$value['id'])){
                                             $selected="selected";
                                                }else{
                                                $selected="";
                                             } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                       <?php } ?> 
                                    </select>
                              </div>
                              
                              <div class="form-group col-md-3 ">
                                 <label class="control-label">State</label>
                                    <select class="form-control select2 did-floating-select cust_state_name b_state_name"  name="state_id" id="state_id" >
                                       <?php
                                          foreach ($state_data as $key => $value) {
                                             if((isset($state_id)&&$state_id==$value['id'])){
                                             $selected="selected";
                                                }else{
                                                $selected="";
                                             } ?>
                                       <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                       <?php } ?>  
                                    </select>
                              </div>
                             



                              <div class="form-group col-md-3 ">
                              <label class="control-label">Country</label>
                                 <select class="form-control select2 did-floating-select cust_country_name b_country_name"  name="country_id" id="country_id" >
                                    <?php
                                       foreach ($country_data as $key => $value) {
                                          if((isset($country_id)&&$country_id==$value['id'])){
                                          $selected="selected";
                                             }else{
                                             $selected="";
                                          } ?>
                                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                    <?php } ?> 
                                 </select>
                              </div>

                            <div class="form-group col-md-3 ">
                            <label class="">Post Code</label>
                           <input class="form-control " type="text" name="post_code"  value="<?= (isset($post_code))? $post_code : '' ?>" >
                           </div>
                             <div class="form-group col-md-3 ">
                             <label class="control-label">Currencies</label>
                              <select class="form-control custom-select" data-placeholder="Choose a Category"  name="currency"  tabindex="1">
                              <option></option>
                               <option value="1" <?= (isset($currency) && $currency == 1)? 'selected': '';?>>INR</option>
                                             </select>
                           </div>
                          
                             <!-- <div class="form-group col-md-3 ">
                            <label class="control-label">Rate Type</label>
                            <select class="form-control custom-select" data-placeholder="Choose a Category" required name="rate_type" tabindex="1">
                            <option></option>
                            <option value="1" <? //=// (isset($rate_type) && $rate_type == 1)? 'selected': '';?>>Kg</option>
                                             </select>
                           </div> -->

                           

                             <!-- <div class="form-group col-md-3 ">
                            <label class="control-label">Vat</label>
                           <select class="form-control custom-select" data-placeholder="Choose a Category" name="vat" tabindex="1">
                           <option></option>
                           <option value="1" <?//= (isset($vat) && $vat== 1)? 'selected': '';?>>No Tax 0.00</option>
                           <option value="2" <?//= (isset($vat) && $vat == 2)? 'selected': '';?>>100.00</option>
                           </select>
                           </div> -->

                        </div>
                        <hr>
                     </div>

                     <div class="col-md-6 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color"><h6><b>Billing Address</b></h6></span><hr> 
                           </div>
                         
                           <div class="form-group col-md-4 ">
                             <label class="">Billing Company</label>
                             <input class="form-control " type="text" name="billing_company" required  value="<?= (isset($billing_company))? $billing_company : '' ?>" >
                              
                           </div>

                           <div class="form-group col-md-4 ">
                              <label class="">Street</label>
                              <input class="form-control " type="text" name="b_street"   value="<?= (isset($b_street))? $b_street : '' ?>" >
                           </div>

                           <div class="form-group col-md-4">
                            <label class="">Post Code</label>
                           <input class="form-control " type="text" name="b_post_code"   value="<?= (isset($b_post_code))? $b_post_code : '' ?>" >
                           </div>

                           <div class="form-group col-md-4">
                              <label class="control-label">City</label>
                              <select class="form-control select2 did-floating-select b_city_name"  name="b_city_id"   >
                                 <?php
                                    foreach ($b_city_data as $key => $value) {
                                       if((isset($b_city_id['id'])&&$b_city_id['id']==$value['id'])){
                                       $selected="selected";
                                          }else{
                                          $selected="";
                                       } ?>
                                 <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                 <?php } ?> 
                              </select>
                           </div>
                           
                           


                              <div class="form-group col-md-4">
                              <label class="control-label">State</label>
                                 <select class="form-control select2 did-floating-select b_state_name"  name="b_state_id"  id="b_state_id">
                                    <?php
                                       foreach ($b_state_data as $key => $value) {
                                          if((isset($b_state_id['id'])&&$b_state_id['id']==$value['id'])){
                                          $selected="selected";
                                             }else{
                                             $selected="";
                                          } ?>
                                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                    <?php } ?> 
                                 </select>
                              </div>

                              
                              <div class="form-group col-md-4">
                              <label class="control-label">Country</label>
                              <select class="form-control select2 did-floating-select b_country_name"  name="b_country_id"  id="b_country_id">
                                    <?php
                                    foreach ($b_country_data as $key => $value) {
                                       if((isset($b_country_id['id'])&&$b_country_id['id']==$value['id'])){
                                       $selected="selected";
                                          }else{
                                          $selected="";
                                       } ?>
                                 <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                 <?php } ?> 
                              </select>
                           </div>
                              

                          

                        </div>
                        <hr>
                     </div>


                      <div class="col-md-6 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color"><h6><b>Shipping Address</b></h6></span><hr> 
                           </div>
                         
                            <div class="form-group col-md-4 ">
                              <label class="">Street</label>
                              <input class="form-control " type="text" name="s_street"   value="<?= (isset($s_street))? $s_street : '' ?>" >
                           </div>

                            <div class="form-group col-md-4">
                            <label class="">Post Code</label>
                           <input class="form-control " type="text" name="s_post_code"   value="<?= (isset($s_post_code))? $s_post_code : '' ?>" >
                           </div>

                           <div class="form-group col-md-4">
                             <label class="control-label">City</label>
                                 <select class="form-control select2 did-floating-select s_city_name"   name="s_city_id" >
                                     <?php
                                       foreach ($s_city_data as $key => $value) {
                                         if((isset($s_state_id['name'])&&$s_state_id['name']==$value['id'])){
                                          $selected="selected";
                                           }else{
                                           $selected="";
                                         } ?>
                                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                    <?php } ?> 
                                 </select>
                           </div>

                             <div class="form-group col-md-4">
                            <label class="control-label">State</label>
                                 <select class="form-control select2 did-floating-select s_state_name"   name="s_state_id" >
                                   <?php
                                       foreach ($s_state_data as $key => $value) {
                                         if((isset($s_state_id['name'])&&$s_state_id['name']==$value['id'])){
                                          $selected="selected";
                                           }else{
                                           $selected="";
                                         } ?>
                                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                    <?php } ?> 
                                 </select>
                              </div>

                              <div class="form-group col-md-4">
                             <label class="control-label">Country</label>
                             <select class="form-control select2 did-floating-select s_country_name"   name="s_country_id" >
                                 <?php
                                    foreach ($s_country_data as $key => $value) {
                                      if((isset($s_country_id['name'])&&$s_country_id['name']==$value['id'])){
                                       $selected="selected";
                                        }else{
                                        $selected="";
                                      } ?>
                                 <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                 <?php } ?> 
                              </select>
                           </div>
                              

                           
                        </div>
                        <hr>
                     </div>

                    


                  

                     
                     </div>
            
                  <input type="submit" id="btnsubmit" style="margin-left: 90%;" class="btn btn-info btn-theme" value="Submit">
               </form>
            </div>
         </div>
      </div>
   </div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/sales/customer.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script>
   $(document).ready(function () {
   
    $('#frm').validate({ 
         
         submitHandler: function(form) {
             form.submit();
         }
     });
   });
</script>
<style>
   .error{
   color: red;
   }
</style>
<script>
  
</script>
<!-- 
   <script>
      $(document).ready(function() { 
      $(".numberonly").attr("maxlength", "6");
          $(".numberonly").keypress(function(e) {
             var kk = e.which;
              if(kk < 48 || kk > 57)
              e.preventDefault();
          });
       });
      
      
      
   </script> -->
