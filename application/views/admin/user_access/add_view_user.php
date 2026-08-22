<?php  init_header(); ?>
<style>

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
      <!-- <div class="row page-titles">
        <div class="col-md-5 align-self-center">
          <h3 class="text-themecolor">User</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            <li class="breadcrumb-item active">
              <//?= $title;?>
            </li>
          </ol>
        </div>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
        </div> 
      </div> -->
      

      <form method="post" id="frm" enctype="multipart/form-data" >
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
            
              <div class="row">
               <input type="hidden" name="id" id="id" value="<?= (isset($id))? $id : '' ?>">
               

                  <div class="col-md-6 mb-3 vertical">
                    <h4 class="card-title">Add User</h4>
                    <div class="row">

                      <div class="form-group col-md-6 ">
                         <label class="">First Name</label>
                        <input class="form-control " required name="first_name"  type="text" placeholder=" " value="<?=( isset($first_name))? $first_name : '';?>">
                       
                      </div>
                      <div class="form-group col-md-6 ">
                         <label class="">Last Name</label>
                        <input class="form-control " required type="text"  name="last_name" value="<?=( isset($last_name))? $last_name : '';?>"> 
                       
                      </div>

                      <div class="form-group col-md-6 ">
                         <label class="">Mobile Number</label>
                        <input class="form-control  mobile" required type="text"   type="text"  minlength="10" maxlength="10" name="contact" placeholder=" " value="<?=( isset($contact))? $contact : '';?>" contactCheck>
                       
                      </div>
                      <div class="form-group col-md-6 ">
                        <label class="">Email</label>
                        <input class="form-control " required type="text"  name="email" placeholder=" "  value="<?= (isset($email))? $email : ''; ?>" emailCheck>
                        
                      </div>
                       <div class="form-group col-md-6 ">
                          <label class="">Password</label>
                        <input class="form-control " required type="text"  name="password" placeholder=" "  value="<?= (isset($password))? $password : ''; ?>">
                      
                        </div>

                     
                   <div class="form-group col-md-6 ">
                        <label class="">Address</label>
                         <input class="form-control " required type="text"  name="address" placeholder=" " value="<?=( isset($address))? $address : '';?>">
                        
                   </div>


                    
                    <div class="form-group col-md-6  did-error-input  margin-bottom-7" >
                          <label style="margin-top: 5px;border-color:#ced4da;" class="">Financial Year</label>
                           <select class="form-control select2 did-floating-select select2" required id="financial_year_id" name="financial_year_id" value="" >
                                <option value=""></option>
                                 <?php
                                foreach ($financial_year as $key => $value) {  
                                 $date1=date('d/m/Y',strtotime($value['from_date']))."-".date('d/m/Y',strtotime($value['to_date']))                                 
                              ?>
                                <option value="<?= $value['id'] ?>"  <?= (isset($financial_year_id) && $financial_year_id ==$value['id'])? 'selected': 'selected';?>><?= $date1 ?></option>
                                <?php                                
                                } 
                                ?>
                           </select>   
                     </div>

                      <div class="form-group col-md-6  did-error-input  margin-bottom-7" >
                          <label style="margin-top: 5px;border-color:#ced4da;" class="">Company Name</label>
                           <select class="form-control select2 did-floating-select select2" required id="company_id" name="company_id" value="" onchange="getSiteData()">
                                <option value=""></option>
                                 <?php
                                foreach ($company_master as $key => $value) {
                                    
                              ?>
                                <option value="<?= $value['id'] ?>"  <?= (isset($company_id) && $company_id ==$value['id'])? 'selected': '';?>><?= $value['name'] ?></option>
                                <?php                                 
                                } 
                                ?>
                           </select>   
                     </div>

                      <div class="form-group col-md-6  did-error-input  margin-bottom-7" >
                          <label style="margin-top: 5px;border-color:#ced4da;" class="">Site Name</label>
                           <select class="form-control select2 did-floating-select select2" required id="site_id" name="site_id" value="" >
                                <option value=""></option>
                                 <?php
                                foreach ($site_master as $key => $value) {
                                   
                              ?>
                                <option value="<?= $value['id'] ?>"  <?= (isset($site_id) && $site_id ==$value['id'])? 'selected': '';?>><?= $value['site_name'] ?></option>
                                <?php 
                               
                                } 
                                ?>
                           </select>   
                     </div>
                      <div class="form-group col-md-6  did-error-input  margin-bottom-7" >
                          <label style="margin-top: 5px;border-color:#ced4da;" class="">Role Name</label>
                           <select class="form-control select2 did-floating-select select2" required id="role_id" name="role_id" value="" >
                                <option value=""></option>
                                 <?php
                                foreach ($user_roles as $key => $value) {
                                   
                              ?>
                                <option value="<?= $value['id'] ?>"  <?= (isset($role_id) && $role_id ==$value['id'])? 'selected': '';?>><?= $value['role_name'] ?></option>
                                <?php 
                               
                                } 
                                ?>
                           </select>   
                     </div>
                       <div class="form-group col-md-6  did-error-input  margin-bottom-7" >
                          <label style="margin-top: 5px;border-color:#ced4da;" class="">Department</label>
                           <select class="form-control select2 did-floating-select select2" required id="department_id" name="department_id" value="" >
                                <option value=""></option>
                                 <?php
                                foreach ($departments as $key1 => $value1) {
                                   
                              ?>
                                <option value="<?= $value1['id'] ?>"  <?= (isset($department_id) && $department_id ==$value1['id'])? 'selected': '';?>><?= $value1['role_name'] ?></option>
                                <?php 
                              
                                } 
                                ?>
                           </select>   
                     </div>

                    </div>
                  </div>
                  <div class="col-md-6" style="padding:1px">
                    <div>
                      <div  >
                        <div class="col-12">
                          <h4 class="card-title">Permission</h4>
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="8%">Sr.No</th>
                                  <th align="left" >Permission</th>
                                  <th width="8%">Select All</th>
                                  <th width="8%">View</th>                                  
                                  <th width="8%">Create</th>
                                  <th width="8%">Edit</th>
                                  <th width="8%">Delete</th>
                                </tr>
                              </thead>
                               <tbody>
                                                <?php
                                                    foreach($modules as $key2=>$value2){
                                                  ?>
                                                    <tr id="row_<?= $value2['id']; ?>" class="access_role_row access_role_<?= $value2['id']; ?>">
                                                    <td ><?= ++$key2; ?>
                                                      
                                                      <input type="hidden" name="module_id[]" value="<?= $value2['id']; ?>">
                                                      <input type="hidden" id="user_module_id_<?= $value2['id']; ?>" name="user_module_id_<?= $value2['id']; ?>" value="">
                                                    </td>
                                                    <td align="left" class="text-left"><span class="text-color"><?= ucwords($value2['name']); ?></span></td>
                                                    <td>
                                                      <center>
                                                        <input type="checkbox" id="select_all_<?= $value2['id']; ?>" data-checkwhat ="selectAll_<?= $value2['id']; ?>" data-chkvalue="<?= $value2['id']; ?>" name="sel_all_<?= $value2['id']; ?>" class="size all_check selectAll_<?= $value2['id']; ?>"/>
                                                      </center>
                                                    </td>

                                                    <td >
                                                      <center>
                                                        <input type="checkbox" class="size1  all_check selectAll_<?= $value2['id']; ?>" id="view_global_<?= $value2['id']; ?>" name="view_global_<?= $value2['id']; ?>"  title="view_global[]" data-chkvalue="<?= $value2['id']; ?>" value="1">
                                                      </center>
                                                    </td>
                                                                                                        <td>
                                                      <center>
                                                           <input type="checkbox" class="size1 all_check selectAll_<?= $value2['id']; ?>" id="create_<?= $value2['id']; ?>" data-chkvalue="<?= $value2['id']; ?>" name="create_<?= $value2['id']; ?>" title="create[]" value="1">
                                                      </center>
                                                    </td>
                                                    <td>
                                                      <center>
                                                           <input type="checkbox" class="size1 all_check selectAll_<?= $value2['id']; ?>" id="edit_<?= $value2['id']; ?>" data-chkvalue="<?= $value2['id']; ?>" name="edit_<?= $value2['id']; ?>" title="edit" value="1">
                                                      </center>
                                                    </td>
                                                    <td>
                                                      <center>
                                                           <input title="delete" class="size1 all_check selectAll_<?= $value2['id']; ?>" type="checkbox" id="delete_<?= $value2['id']; ?>" data-chkvalue="<?= $value2['id']; ?>" name="delete_<?= $value2['id']; ?>" value="1">
                                                      </center>
                                                    </td>
                                                     
                                                </tr>
                                                
                                                <?php
                                                       
                                                    }
                                                ?>
                                                   
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <input type="submit" style="float: right;margin-left: 5px;" class="btn btn-info  btn-theme chk_y_n"  value="update">
               <a href="<?= base_url('admin/UserAccess');?>" style="float: right;" class="btn btn-info  btn-theme">Back</a>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php  init_footer(); ?>
      <script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
      <script src="<?= base_url(); ?>assets/js/page-js/user_access.js"></script>
      <script src="<?= base_url(); ?>assets/node_modules/select2/select2-cascade.js"></script>
     
      <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

      <script>
        $(function() {
          $(".selectAll").click(function(){
              checkwhat  = $(this).data("checkwhat");
              
              $('input:checkbox.'+checkwhat).not(this).prop('checked', this.checked);
          });
        });
      </script>
      
       <script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
      <script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

      <script>
       $(document).ready(function () {
   
       $('#frm').validate({
           rules: {
               email: {
                   required: true,
                    remote: {
                       url: base_url+"admin/UserAccess/emailCheck/"+$('#id').val(),
                       type: "post"
                    }
                  }, 
   
                 contact: {
                   required: true,
                    remote: {
                       url: base_url+"admin/UserAccess/contactCheck/"+$('#id').val(),
                       type: "post"
                    }
                  }
          
           },
           messages: {
           email: {
               required: "Please enter User Name",
               remote: "Email is already in use!"
           },
           contact: {
               required: "Please Enter Contact Number",
               remote: "Contact Number already in use!"
           }
       },
         success: function (label, element) {
                $(element).removeAttr("title");
                 $(element).removeAttr('data-original-title');
                $(element).tooltip("hide");
            }
   
   });
       jQuery.validator.addMethod('emailCheck', function (value, element, param) {
        
         {
           return $.ajax({
             url:base_url +"admin/UserAccess/emailCheck",
             method:"POST",
             data:{email:value},
             dataType:"json",
             success:function(output)
             {
               return output;
             }
           });
         }
       },'email Id alreday exists');
   
        jQuery.validator.addMethod('contactCheck', function (value, element, param) {
        
         {
           return $.ajax({
             url:base_url +"admin/UserAccess/contactCheck",
             method:"POST",
             data:{username:value},
             dataType:"json",
             success:function(output)
             {
               return output;
             }
           });
         }
       },'Contact Number alreday exists');
     });
      </script>
<script>
          $('.chk_y_n').click(function() {
            var check_y_n = $('.size1').is(':checked');  
              // alert(check_y_n);
              if (check_y_n == true) {
                  
              } else {
                  Swal.fire({
                      type: 'error',
                      text: 'User Access Permission is not selected!',
                 })
                  return false;
              }
          });
      </script>


