<?php init_header();?>

<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">

<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />

<style>

   .sd{
      display: none;
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


   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
               <form class="repeater" action="<?= base_url();?>admin/Vendor/submit_vendor_data"  enctype="multipart/form-data" method="post" id="frm" autocomplete="off">
                  <div class="row">
                    <input type="hidden" name="id" id="id" value="<?= (isset($vendor_id))? $vendor_id : '' ?>">
                    <input type="hidden" name="company_id" id="company_id" value="<?= userId('company_id'); ?>">
                    <input type="hidden" name="site_id" id="site_id" value="<?= userId('site_id'); ?>">

                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color"><h6><b>Add Vendor Masters</b></h6></span><hr> 
                           </div>
                         
                           <div class="form-group col-md-2 ">
                              <label class="">Account Name / Vendor Name</label>
                              <input class="form-control " type="text" name="account_name" required value="<?= (isset($account_name))? $account_name : '' ?>" >
                              
                           </div>

                           <div class="form-group col-md-2 ">
                              <label class="">Cheque Print A/C  Name</label>
                              <input class="form-control " type="text" placeholder="" name="cheque_print_ac_name"  value="<?= (isset($cheque_print_ac_name))? $cheque_print_ac_name : '' ?>" >
                             
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="">Code</label>
                              <input class="form-control numberonly" type="text" placeholder="" name="code"  value="<?= (isset($code))? $code : '' ?>" >
                            
                           </div>

                           <div class="form-group col-md-2 ">
                              <label class="">Opening balance</label>
                              <input class="form-control numberonly" type="text" placeholder="" name="opening_balance"  value="<?= (isset($opening_balance))? $opening_balance : '' ?>" >
                              
                           </div>
                           <div class="form-group col-md-2">
                              <label style="border-color:#ced4da;" class="">Account Group</label>
                              <select class="form-control select2 did-floating-select"  id="account_group"  name="account_group" >
                                 <option></option>
                                 <option value="1" <?= (isset($account_group) && $account_group == 1)? 'selected': '';?> >Current</option>
                                 <option value="2" <?= (isset($account_group) && $account_group == 2)? 'selected': '';?> >Saving</option>
                              </select>
                           </div>
                       
                           
                           <div class="form-group col-md-2 ">
                              <label class="">Account Nature</label>
                              <input class="form-control " type="text" placeholder="" name="account_nature"   value="<?= (isset($account_nature))? $account_nature : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="">Vendor Limit</label>
                              <input class="form-control numberonly" type="text" placeholder="" name="vendor_limit"   value="<?= (isset($vendor_limit))? $vendor_limit : '' ?>">
                           </div>
                        </div>
                        <hr>
                     </div>

                     <div class="col-md-3 mb-3 b-r">
                        <div class="row" style="margin-top: -22px;">
                           <div class="form-group col-md-12" style="margin: 0px;">
                              <span class="text-color"><h6><b>Address Details</b></h6></span>
                            <hr> 
                           </div>
                           
                           <div class="form-group col-md-12 ">
                              <label class="">Address</label>
                              <textarea class="form-control " type="text" placeholder=" " name="address_details" id=""  ><?= (isset($address_details))? $address_details : '' ?></textarea>
                           </div>

                           <div class="form-group col-md-6 ">
                              <label style="border-color:#ced4da;" class="">City</label>
                              <select class="form-control select2 city_name" required id="city_id"  name="city_id">
                                 <?php
                                     foreach ($city_data as $key => $value) {
                                       if((isset($city_id)&&$city_id==$value['id'])){
                                        $selected="selected";
                                         }else{
                                         $selected="";
                                       } ?>
                                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                 <?php } ?>
                              </select>
                              <label id="city_id-error" class="error sd" for="city_id">This field is .</label>
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Pincode</label>
                              <input class="form-control " type="text" placeholder=" " name="pincode" id="pincode"  value="<?= (isset($pincode))? $pincode : '' ?>"  >
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Phone No. 1</label>
                              <input class="form-control mobile" type="text" placeholder=" " name="phone_no_1" id="phone_no_1"   value="<?= (isset($phone_no_1))? $phone_no_1 : '' ?>" >
                              
                           </div>
                           <div class="form-group col-md-6 ">
                               <label class="">Phone No. 2</label>
                              <input class="form-control mobile" type="text" placeholder=" " name="phone_no_2" id="phone_no_2"   value="<?= (isset($phone_no_2))? $phone_no_2 : '' ?>">
                             
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Fax No. 1</label>
                              <input class="form-control mobile" type="text" placeholder=" " name="fax_no_1" id="fax_no_1"   value="<?= (isset($fax_no_1))? $fax_no_1 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                               <label class="">Fax No. 2</label>
                              <input class="form-control mobile" type="text" placeholder=" " name="fax_no_2" id="fax_no_2"   value="<?= (isset($fax_no_2))? $fax_no_2 : '' ?>">
                             
                           </div>

                           <div class="form-group col-md-6 ">
                              <label class="">Contact Person Name</label>
                              <input class="form-control " type="text" placeholder=" " name="contact_person_name" id="contact_person_name"   value="<?= (isset($contact_person_name))? $contact_person_name : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Contact Person No</label>
                              <input class="form-control mobile" type="text" placeholder=" " name="contact_person_mobile_no" id="contact_person_mobile_no"  value="<?= (isset($contact_person_mobile_no))? $contact_person_mobile_no : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Contact Person Email</label>
                              <input class="form-control " type="email" placeholder=" " name="contact_person_email" id="contact_person_email"  value="<?= (isset($contact_person_email))? $contact_person_email : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-12 ">
                              <label class="">Remark</label>
                              <textarea class="form-control " type="text" placeholder=" " name="remark" id="remark"  ><?= (isset($remark))? $remark : '' ?></textarea>
                              
                           </div>
                         

                        </div>
                     </div>


                     <div class="col-md-3 mb-3 b-r">
                        <div class="row" style="margin-top: -22px;">
                           <div class="form-group col-md-12" style="margin: 0px;">
                              <span class="text-color"><h6><b>Bank Details</b></h6></span>
                            <hr> 
                           </div>
                           
                           <div class="form-group col-md-6 ">
                              <label class="">Bank A/C No 1</label>
                              <input class="form-control numberonly" type="text" placeholder=" " name="bank_ac_no_1" id=""  value="<?= (isset($bank_ac_no_1))? $bank_ac_no_1 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">IFSC Code 1</label>
                              <input class="form-control " type="text" placeholder=" " name="ifsc_code_1" id=""  value="<?= (isset($ifsc_code_1))? $ifsc_code_1 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Bank A/C No 2</label>
                              <input class="form-control numberonly" type="text" placeholder=" " name="bank_ac_no_2" id=""  value="<?= (isset($bank_ac_no_2))? $bank_ac_no_2 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">IFSC Code 2</label>
                              <input class="form-control " type="text" placeholder=" " name="ifsc_code_2" id=""  value="<?= (isset($ifsc_code_2))? $ifsc_code_2 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Bank A/C No 3</label>
                              <input class="form-control numberonly" type="text" placeholder=" " name="bank_ac_no_3" id=""  value="<?= (isset($bank_ac_no_3))? $bank_ac_no_3 : '' ?>">
                             
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">IFSC Code 3</label>
                              <input class="form-control " type="text" placeholder=" " name="ifsc_code_3" id=""  value="<?= (isset($ifsc_code_3))? $ifsc_code_3 : '' ?>">
                              
                           </div>

                           <div class="form-group col-md-6 ">
                              <label class="">Bank Name 1</label>
                              <input class="form-control " type="text" placeholder=" " name="bank_name_1" id=""  value="<?= (isset($bank_name_1))? $bank_name_1 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                               <label class="">Branch Name 1</label>
                              <input class="form-control " type="text" placeholder=" " name="branch_name_1" id=""  value="<?= (isset($branch_name_1))? $branch_name_1 : '' ?>">
                             
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Bank Name 2</label>
                              <input class="form-control " type="text" placeholder=" " name="bank_name_2" id=""  value="<?= (isset($bank_name_2))? $bank_name_2 : '' ?>">
                             
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Branch Name 2</label>
                              <input class="form-control " type="text" placeholder=" " name="branch_name_2" id=""  value="<?= (isset($branch_name_2))? $branch_name_2 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Bank Name 3</label>
                              <input class="form-control " type="text" placeholder=" " name="bank_name_3" id=""  value="<?= (isset($bank_name_3))? $bank_name_3 : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Branch Name 3</label>
                              <input class="form-control " type="text" placeholder=" " name="branch_name_3" id=""  value="<?= (isset($branch_name_3))? $branch_name_3 : '' ?>">
                              
                           </div>

                           <div class="form-group col-md-6 ">
                               <label class="">Credit Limit</label>
                              <input class="form-control numberonly" type="text" placeholder=" " name="credit_limit" placeholder="0" id="credit_limit"  value="<?= (isset($credit_limit))? $credit_limit : '' ?>" >
                             
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Credit Days</label>
                              <input class="form-control numberonly" type="text" placeholder=" " name="credit_days" placeholder="0" id="credit_days"  value="<?= (isset($credit_days))? $credit_days : '' ?>">
                              
                           </div>
                        </div>
                     </div>


                     <div class="col-md-3 mb-3 b-r">
                        <div class="row" style="margin-top: -22px;">
                           <div class="form-group col-md-12" style="margin: 0px;">
                              <span class="text-color"><h6><b>Tax/TDS</b></h6></span>
                            <hr> 
                           </div>
                           
                           <div class="form-group col-md-12 ">
                              <label class="">Name of Dept./Party (as per 26 AS)</label>
                              <input class="form-control " type="text" placeholder=" " name="name_dept" id="name_dept"  value="<?= (isset($name_dept))? $name_dept : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">GSTIN No</label>
                              <input class="form-control " type="text" placeholder=" "  name="gst_no" id="gst_no"  value="<?= (isset($gst_no))? $gst_no : '' ?>" >
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">TIN No</label>
                              <input class="form-control " type="text" placeholder=" " name="tin_no" id="tin_no"  value="<?= (isset($tin_no))? $tin_no : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">Pan No</label>
                              <input class="form-control " type="text" placeholder=" "  name="pan_no" id="pan_no"  value="<?= (isset($pan_no))? $pan_no : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">TAN No</label>
                              <input class="form-control " type="text" placeholder=" " name="tan_no" id="tan_no"  value="<?= (isset($tan_no))? $tan_no : '' ?>">
                              
                           </div>
                           <div class="form-group col-md-6 ">
                              <label class="">CST No</label>
                              <input class="form-control " type="text" placeholder=" " name="cst_no" id="cst_no"  value="<?= (isset($cst_no))? $cst_no : '' ?>">
                              
                           </div>
                            <div class="form-group col-md-6 ">
                              <label class="">ST No</label>
                              <input class="form-control " type="text" placeholder=" " name="st_no" id="st_no"  value="<?= (isset($st_no))? $st_no : '' ?>">
                              
                           </div>

                           <div class="form-group col-md-6 ">
                              <label class="">ECC No</label>
                              <input class="form-control " type="text" placeholder=" " name="ecc_no" id="ecc_no"  value="<?= (isset($ecc_no))? $ecc_no : '' ?>">
                              
                           </div>
                            <div class="form-group col-md-6 ">
                              <label class="">LBT No</label>
                              <input class="form-control " type="text" placeholder=" " name="lbt_no" id="lbt_no"  value="<?= (isset($lbt_no))? $lbt_no : '' ?>">
                              
                           </div>

                           <div class="form-group col-md-6">
                              <label style="margin-top: 2px;border-color:#ced4da;" class="">Maintain Balance Bill by Bill</label>
                              <select class="form-control select2 did-floating-select"  id=""  name="maintain_balance" >
                                 <option></option>
                                 <option value="1" <?= (isset($maintain_balance) && $maintain_balance == 1)? 'selected': '';?> >Yes</option>
                                 <option value="2" <?= (isset($maintain_balance) && $maintain_balance == 2)? 'selected': '';?> >No</option>
                              </select>
                              
                           </div>

                           <div class="form-group col-md-5">
                              <?php if(! empty($tax_tds_email)) {?>
                                 <div data-repeater-list="email">
                                    <div class="col-md-1">
                                       <a href="javascript:void(0)" data-repeater-create style="float: left; margin-left: -10px;"><i class="fa fa-plus-circle"></i></a>
                                    </div>

                                    <?php foreach($tax_tds_email as $key4 => $val4) {?>

                                    <div data-repeater-item>
                                       <button data-repeater-delete class="btn btn-danger btn-theme" type="button" style="float: right;padding: 1px 5px;margin:25px -30px 0px 0px;" value="delete"> <i class="fas fa-trash-alt "></i> </button>

                                       <label class="">Email Id</label>
                                       
                                       <input class="form-control " type="hidden" placeholder="" name="id_email" id="id_email" value="<?= isset($val4['id'])?$val4['id'] :''?>" >

                                       <input class="form-control " type="email" placeholder="" name="email" id="email" value="<?= isset($val4['email_id'])?$val4['email_id'] :''?>" >
                                    </div>
                                    <?php } ?>
                                    
                                 </div>

                              <?php }else{ ?>
                                 <div data-repeater-list="email">
                                    <div class="col-md-1">
                                       <a href="javascript:void(0)" data-repeater-create style="float: left;margin-left: -10px;"><i class="fa fa-plus-circle"></i></a>
                                    </div>
                                    <div data-repeater-item>

                                       <button data-repeater-delete class="btn btn-danger btn-theme" type="button" style="float: right;padding: 1px 5px;margin:25px -30px 0px 0px;" value="delete"> <i class="fas fa-trash-alt "></i> </button>

                                       <label class="">Email Id</label>
                                       <input class="form-control " type="email" placeholder=" " name="email" id="email" >

                                    </div>
                                 </div>
                              <?php } ?>
                              
                           </div>
                           
                             
                           


                           <div class="form-group col-md-5" style="padding-left:0px;">
                              
                              <!-- <div data-repeater-list="email" class="col-md-12" >
                                       
                                 <div data-repeater-item class="" style="padding-left:0px;">
                                    <div class="form-group  col-md-12 " style="padding-left:0px">
                                       <label class="">Email Id</label>
                                       <input class="form-control " type="email" placeholder=" " name="email" id="email"  >
                                    </div>
                                    <div class="col-lg-1">
                                       <button data-repeater-delete type="button" class="btn btn-danger float-left" style="margin-bottom:8px;padding:2px 10px;margin-top:-8px" value="delete"> <i class="fas fa-trash-alt "></i> </button>
                                    </div> 
                                 </div>
                              </div> -->
                           </div>
                          <!--  <div class="form-group col-md-1 ">
                              <a href="javascript:void(0)" data-repeater-create style="float: right;"><i class="fa fa-plus-circle"></i></a>
                           </div> -->





                        </div>
                     </div>

                      <div class="col-md-3 mb-3">
                        <div class="row" style="margin-top: -22px;">
                           <div class="form-group col-md-12" style="margin: 0px;">
                              <span class="text-color"><h6><b>Attachment Details</b></h6></span>
                            <hr> 
                           </div>
                           
                          <!--  <div class="form-group col-md-12 ">
                              <label class="">File</label> -->
                              <!-- <input class="form-control " type="file" placeholder="" name="file_name[]" multiple="mutiple">
                              <//?php if(isset($file_name)){?>
                                 <span>File Name :- </span>
                              <//?php }else{ ?>
                                 <span></span>
                              <//?php }?> -->
                             
                             
                           </div>

                           <div class="col-md-12 bg-diffrent">
                                 <div class="form-group">
                                    <label class="">Attach a file</label>
                                    <div class="col-md-12" style="padding:0px;">
                                          <div class="file-upload-contain">
                                    <?php if(isset($attachement)){ ?>
                                           
                                           <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                                          <?php foreach($attachement as $key1=>$val){?>
                                             <div class="file-preview-frame file-sortable  kv-preview-thumb remove_file_attch_(<?= $val['id']?>)" id="remove_file_attch_<?= $val['id']?>" data-template="image">
                                                <input type="text" class="form-control" id="remove_file_attch_id_<?= $val['id']?>" name="file_name_id[]" value="<?= $val['id']?>" multiple />
                                                <div class="kv-file-content">
                                                </div>
                                                <div class="file-thumbnail-footer">
                                                <div class="file-detail">
                                                <div class="file-caption-name" style="color: black;"><?= $val['file_name']?></div>
                                                </div>   
                                                <div class="file-actions">
                                                   <div class="file-footer-buttons">
                                                      <button type="button" onclick= "remove_file_attch(<?= $val['id']?>)" class="kv-file-remove file-remove" title="Remove file"><i class="fa fa-times"></i></button>
                                                   </div>
                                                </div>
                                                <span class="file-drag-handle drag-handle-init text-primary" title="Move / Rearrange"><i class="bi-arrows-move"></i></span>
                                                <div class="clearfix"></div>
                                                </div>

                                             <div class="kv-zoom-cache"></div></div>
                                          
                                    <?php } }else{?>
                                      
                                             <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                                          
                                    <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        </div>
                     </div>
            
                  <input type="submit" id="btnsubmit" style="margin-left: 90%;" class="btn btn-info btn-theme" value="Submit">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/add_vendor_repeater.int.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/vendor.js"></script>
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>

<script>
   $(document).ready(function () {
     
      $('#frm').validate({

          rules: {
            gst_no: {
              gst_no: true
            },

            pan_no: {
              pan_no: true
            },

            tan_no: {
              tan_no: true
            }

          },

       });
        
         $.validator.addMethod("gst_no", function(value3, element3) {
             var gst_value = value3.toUpperCase();
             
             var reg = /([0-9]){2}([A-Z]){3}([PCHABGJLFT]){1}([A-Z]){1}([0-9]){4}([A-Z]){1}([0-9]){1}([Z]){1}([A-Z0-9]){1}$/;
             if (this.optional(element3)) {
               return true;
             }
             if (gst_value.match(reg)) {
               return true;
             } else {
               return false;
             }

           }, "Enter Valid GST Number");

          $.validator.addMethod("pan_no", function(value3, element3) {
             var pan_number = value3.toUpperCase();
             
             var reg = /([A-Z]){3}([PCHABGJLFT]){1}([A-Z]){1}([0-9]){4}([A-Z]){1}$/;
             if (this.optional(element3)) {
               return true;
             }
             if (pan_number.match(reg)) {
               return true;
             } else {
               return false;
             }

           }, "Enter Valid Pan Number");

           $.validator.addMethod("tan_no", function(value3, element3) {
             var pan_number = value3.toUpperCase();
             
             var reg =/([A-Z]){4}([0-9]){5}([A-Z]){1}$/;
             if (this.optional(element3)) {
               return true;
             }
             if (pan_number.match(reg)) {
               return true;
             } else {
               return false;
             }

           }, "Enter Valid Tan Number");

         })

   // $(function(){
   //      $('.select2-mutiple').multiselect();
   //  });
</script>



