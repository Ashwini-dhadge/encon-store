<?php init_header();?>

<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">

<style>
   /*.lbl_class{
      background: lavender;
   }*/
   .form-control{
      border: none;
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
               <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
               
               <div class="row">
                  <input type="hidden" name="id" id="id" value="<?= (isset($vendor_id))? $vendor_id : '' ?>">
                  <input type="hidden" name="company_id" id="company_id" value="<?= userId('company_id'); ?>">
                  <input type="hidden" name="site_id" id="site_id" value="<?= userId('site_id'); ?>">

                  <div class="col-md-4 mb-3 b-r">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Vendor Information</b></h6></span><hr> 
                        </div>
                      
                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Account Name / Vendor Name</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($account_name))? $account_name : '' ?></label>
                        </div>

                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Cheque Print A/C  Name</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($cheque_print_ac_name))? $cheque_print_ac_name : '' ?></label>
                        </div>

                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Code</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($code))? $code : '' ?></label>
                        </div>
                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Opening balance</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($opening_balance))? $opening_balance : '' ?></label>
                        </div>
                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Account Group</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"> <?php 
                                 if($account_group == 1){
                                    echo "Current";
                                 }else if($account_group == 2){
                                    echo "Saving";
                                 }else{
                                    echo "-";
                              }?></label>
                        </div>

                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Account Nature</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($account_nature))? $account_nature : '' ?></label>
                        </div>

                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Vendor Limit</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($vendor_limit))? $vendor_limit : '' ?></label>
                        </div>

                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Company Name</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($company_name))? $company_name : '' ?></label>
                        </div>

                        <div class="form-group col-md-5 ">
                           <label class="lbl_class">Site Name</label>
                        </div>

                        <div class="form-group col-md-7 ">
                           <label class="lbl_class"><?= (isset($site_name))? $site_name : '' ?></label>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Attachment Details</b></h6></span><hr> 
                        </div>
                        
                        <?php $i=1;
                           if($attachment_file){
                              foreach ($attachment_file as $key => $value){?>
                                 <div class="col-md-2">
                                    <a class="image-popup-vertical-fit" href="<?= base_url(); ?>assets/uploads/vendor_image/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>"> 
                                    <div class="col-md-6">
                                       <img class="image-popup-vertical-fit" src="<?= base_url(); ?>assets/uploads/vendor_image/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" height="50px"></a>  
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

                  <div class="col-md-8 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Address Details</b></h6></span><hr> 
                        </div>
                      
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Contact Person Name</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($contact_person_name))? $contact_person_name : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Fax No. 1</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($fax_no_1))? $fax_no_1 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Address</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($address_details))? $address_details : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Contact Person Email</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($contact_person_email))? $contact_person_email : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Fax No. 2</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($fax_no_2))? $fax_no_2 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">City</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($city_name))? $city_name : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Contact Person No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($contact_person_mobile_no))? $contact_person_mobile_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Phone No. 1</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($phone_no_1))? $phone_no_1 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Pincode</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($pincode))? $pincode : '' ?></span>
                        </div>
                        
                         <div class="form-group col-md-2 ">
                           <label class="lbl_class">Remark</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($remark))? $remark : '' ?></span>
                        </div>

                       
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Phone No. 2</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($phone_no_2))? $phone_no_2 : '' ?></span>
                        </div>
                       
                     </div>


                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Bank Details</b></h6></span><hr> 
                        </div>
                      
                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Bank Name 1</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($bank_name_1))? $bank_name_1 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Bank Name 2</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($bank_name_2))? $bank_name_2 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Bank Name 3</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($bank_name_3))? $bank_name_3 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Branch Name 1</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($branch_name_1))? $branch_name_1 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Branch Name 2</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($branch_name_2))? $branch_name_2 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Branch Name 3</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($branch_name_3))? $branch_name_3 : '' ?> </span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Bank A/C No 1 </label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($bank_ac_no_1))? $bank_ac_no_1 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Bank A/C No 2</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($bank_ac_no_2))? $bank_ac_no_2 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Bank A/C No 3</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($bank_ac_no_3))? $bank_ac_no_3 : '' ?></span>
                        </div>
                        
                         <div class="form-group col-md-2 ">
                           <label class="lbl_class">IFSC Code 1</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($ifsc_code_1))? $ifsc_code_1 : '' ?></span>
                        </div>

                         <div class="form-group col-md-2 ">
                           <label class="lbl_class">IFSC Code 2</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($ifsc_code_2))? $ifsc_code_2 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">IFSC Code 3</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($ifsc_code_3))? $ifsc_code_3 : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Credit Limit</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($credit_limit))? $credit_limit : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Credit Days</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($credit_days))? $credit_days : '' ?></span>
                        </div>
                       
                     </div>


                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color"><h6><b>Tax/TDS</b></h6></span><hr> 
                        </div>
                      
                        <div class="form-group col-md-3 ">
                           <label class="lbl_class">Name of Dept./Party (as per 26 AS)</label>
                        </div>
                        <div class="form-group col-md-3 ">
                           <span><?= (isset($name_dept))? $name_dept : '' ?></span>
                        </div>

                        <div class="form-group col-md-2 ">
                           <label class="lbl_class">Maintain Balance Bill by Bill</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?php if($maintain_balance == 1){
                                 echo "Yes";
                           }else if($maintain_balance == 2) {
                                 echo "No";
                           }else{
                                 echo "-";
                           }?></span>
                        </div>

                        <div class="form-group col-md-2 "> </div>
                        

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">GSTIN No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($gst_no))? $gst_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">Pan No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($pan_no))? $pan_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">TAN No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($tan_no))? $tan_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">TIN No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($tin_no))? $tin_no : '' ?></span>
                        </div>


                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">CST No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($cst_no))? $cst_no : '' ?></span>
                        </div>

                        



                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">ECC No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($ecc_no))? $ecc_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">LBT No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($lbt_no))? $lbt_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">ST No</label>
                        </div>
                        <div class="form-group col-md-2 ">
                           <span><?= (isset($st_no))? $st_no : '' ?></span>
                        </div>

                        <div class="form-group col-md-1 ">
                           <label class="lbl_class">Email</label>
                        </div>

                        <div class="form-group col-md-11 ">
                           <span>
                              <?php if($email_dt){
                                 foreach ($email_dt as $key1 => $value1) {
                                    echo $email[] = $value1['email'].', ';
                                 }

                              }else{
                                 echo "-";
                              }
                           ?></span>
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
<!-- end row -->
<?php init_footer(); ?>