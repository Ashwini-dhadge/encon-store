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
   height: 32px !important;
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
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body p-b-0">
                     <h4 class="card-title">Customer</h4>
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#customer_details" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Customer Details</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#billing_shipping" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Billing&Shipping</span></a> </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content">
                        <div class="tab-pane active" id="customer_details" role="tabpanel">
                           <div class="p-20">
                              <div class="tab-pane active" id="customer_details" role="tabpanel">
                                 <div class="p-20">
                                    <form action="<?= base_url();?>admin/sales/Customer/add_customer"  enctype="multipart/form-data" method="post" id="frm" autocomplete="off">
                                       <input type="hidden" name="id" id="id" value="<?= isset($customer)? $customer['id'] : '' ?>">
                                       <div class="row">
                                          <div class="form-group col-md-6 ">
                                             <label class="">Customer</label>
                                             <input class="form-control " type="text" name="customer_name" required value="<?= isset($customer)? $customer['customer_name'] : ''; ?>" >
                                          </div>
                                          <div class="form-group col-md-6 ">
                                             <label class="">Address</label>
                                             <input class="form-control " type="text" name="address" required value="<?= isset($customer)? $customer['address'] : ''; ?>" >
                                          </div>
                                          <div class="form-group col-md-6 ">
                                             <label class="">Phone</label>
                                             <input class="form-control " type="text" name="phone" required value="<?= isset($customer)? $customer['phone'] : ''; ?>" >
                                          </div>
                                          <div class="form-group col-md-6 ">
                                             <label class="control-label">City</label>
                                             <select class="form-control select2 did-floating-select city_name" required name="city_id" id="city_id" >
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
                                          <div class="form-group col-md-6 ">
                                             <label class="">Email</label>
                                             <input class="form-control " type="email" name="email" required value="<?= isset($customer)? $customer['email'] : ''; ?>" >
                                          </div>
                                          <div class="form-group col-md-6">
                                             <label class="control-label">Country</label>
                                             <select class="form-control select2 did-floating-select country_name" required name="country_id" id="country_id" >
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
                                          <div class="form-group col-md-6">
                                             <label class="control-label">Currencies</label>
                                             <select class="form-control custom-select" data-placeholder="Choose a Category" required name="currency"  tabindex="1">
                                                <option></option>
                                                <option value="1"<?= (isset($customer['currency']) && $customer['currency'] == 1)? 'selected': '';?>>INR</option>
                                             </select>
                                          </div>
                                          <div class="form-group col-md-6 ">
                                             <label class="control-label">State</label>
                                             <select class="form-control select2 did-floating-select state_name" required name="state_id" id="state_id" >
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
                                          <div class="form-group col-md-6">
                                             <label class="control-label">Rate Type</label>
                                             <select class="form-control custom-select" data-placeholder="Choose a Category" required name="rate_type" tabindex="1">
                                                <option></option>
                                                <option value="1" <?= (isset($customer['rate_type']) && $customer['rate_type'] == 1)? 'selected': '';?>>Kg</option>
                                             </select>
                                          </div>
                                          <div class="form-group col-md-6">
                                             <label class="">Post Code</label>
                                             <input class="form-control " type="text" name="post_code" required value="<?= isset($customer)? $customer['post_code'] : ''; ?>" >
                                          </div>
                                          <div class="form-group col-md-6">
                                             <label class="control-label">Vat</label>
                                             <select class="form-control custom-select" data-placeholder="Choose a Category" name="vat" required tabindex="1">
                                                <option></option>
                                                <option value="1" <?= (isset($customer['vat']) && $customer['vat'] == 1)? 'selected': '';?>>No Tax 0.00</option>
                                                <option value="2" <?= (isset($customer['vat']) && $customer['vat'] == 2)? 'selected': '';?>>100.00</option>
                                             </select>
                                          </div>
                                       </div>
                                       <input type="submit" id="btnsubmit" style="margin-left: 94%;" class="btn btn-success btn-theme float-right" value="Submit">
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane  p-10" id="billing_shipping" role="tabpanel">
                           <div class="row">
                              <div class="col-md-12">
                                 <form method="post" action="<?= base_url('admin/master/Items/add_items');?>" id="frm" enctype="multipart/form-data"class="form-horizontal">
                                 <div class="row">
                                    <div class="col-md-6">
                                       
                                          <span class="text-color">
                                             <h6><b>Billing Address</b><span class="float-right" style="color: #20aee3 !important;font-size: 11px;">Same As Customer Info</span></h6>
                                          </span>
                                          <hr>
                                          <div class="form-group col-md-12">
                                             <label class="">Billing Company</label>
                                             <input class="form-control " type="text" name="billing_company" required value="" >
                                          </div>
                                          <div class="form-group col-md-12">
                                             <label class="">Street</label>
                                             <input class="form-control " type="text" name="street" required value="" >
                                          </div>
                                          <div class="form-group col-md-12">
                                             <label class="">City</label>
                                             <input class="form-control " type="text" name="city" required value="" >
                                          </div>
                                          <div class="form-group col-md-12">
                                             <label class="">State</label>
                                             <input class="form-control " type="text" name="state" required value="" >
                                          </div>
                                          <div class="form-group col-md-12">
                                             <label class="">Post Code</label>
                                             <input class="form-control " type="text" name="post_code" required value="" >
                                          </div>
                                          <div class="form-group col-md-12">
                                             <label class="control-label">Country</label>
                                             <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                                <option></option>
                                                <option value="Category 1">1</option>
                                               
                                             </select>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                    <span class="text-color">
                                    <h6><b>Shipping Address</b><span class="float-right" style="color: #20aee3 !important;font-size: 11px;">Copy Billing Address</span></h6>
                                    </span>
                                    <hr>
                                    <div class="form-group col-md-12">
                                    <label class="">Street</label>
                                    <input class="form-control " type="text" name="street" required value="" >
                                    </div>
                                    <div class="form-group col-md-12">
                                    <label class="">City</label>
                                    <input class="form-control " type="text" name="city" required value="" >
                                    </div>
                                    <div class="form-group col-md-12">
                                    <label class="">State</label>
                                    <input class="form-control " type="text" name="state" required value="" >
                                    </div>
                                    <div class="form-group col-md-12">
                                    <label class="">Post Code</label>
                                    <input class="form-control " type="text" name="post_code" required value="" >
                                    </div>
                                    <div class="form-group col-md-12">
                                    <label class="control-label">Country</label>
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                    <option></option>
                                    <option value="Category 1">1</option>
                                   
                                    </select>
                                    </div>
                                    </div>
                                   
                                 </div>
                                 <input type="submit" id="btnsubmit" style="margin-left: 0%;" class="btn btn-success btn-theme mr-2 float-right" value="Submit And Create Contact">
                           <input type="submit" id="btnsubmit" class="btn btn-success btn-theme mr-2 float-right" value="Submit">
                           </form>
                              </div>
                           </div>
                           <!--  <input type="submit" id="btnsubmit" style="margin-left: 94%;" class="btn btn-success btn-theme float-right" value="Submit">  -->
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
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
