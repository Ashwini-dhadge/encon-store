<?php  init_header(); ?>

  <link href="<?= base_url()?>assets/css/custome.css" rel="stylesheet">
  <link href="<?= base_url()?>assets/css/sample_form.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

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
                      <div class="form-group col-md-6 did-floating-label-content">
                        <input class="form-control did-floating-input" required name="first_name"  type="text" placeholder=" " value="<?=( isset($first_name))? $first_name : '';?>">
                        <label class="did-floating-label">First Name</label>
                      </div>
                      <div class="form-group col-md-6 did-floating-label-content">
                        <input class="form-control did-floating-input" required type="text"  name="last_name" value="<?=( isset($last_name))? $last_name : '';?>"> 
                        <label class="did-floating-label">Last Name</label>
                      </div>

                      <div class="form-group col-md-6 did-floating-label-content">
                        <input class="form-control did-floating-input" required type="text"  type="text" name="contact" placeholder=" " value="<?=( isset($contact))? $contact : '';?>">
                        <label class="did-floating-label">Mobile Number</label>
                      </div>
                      <div class="form-group col-md-6 did-floating-label-content">
                        <input class="form-control did-floating-input" required type="email" name="email" placeholder=" " value="<?=( isset($email))? $email : '';?>">
                        <label class="did-floating-label">Email</label>
                      </div>
                     
                   <div class="form-group col-md-6 did-floating-label-content">
                         <input class="form-control did-floating-input" required type="text" name="address" placeholder=" " value="<?=( isset($address))? $address : '';?>">
                        <label class="did-floating-label">Address</label>
                   </div>

                    <div class="form-group col-md-6 did-floating-label-content did-error-input">
                        <div>
                           <select class="form-control select2 did-floating-select getcity" id="city"  name="city_id" value="">
                            
                           </select>
                           <label style="margin-top: 5px;border-color:#ced4da;" class="did-floating-label">City</label>
                           <label id="city-error" class="error" style="margin-top:15px;" for="city"></label>
                        </div>
                     </div>

                     <div class="form-group col-md-6 did-floating-label-content did-error-input">
                        <div>
                           <select class="form-control select2 did-floating-select getcountry" id="country"  name="country_id" value="">
                             
                           </select>
                           <label style="margin-top: 5px;border-color:#ced4da;" class="did-floating-label">Country</label>
                           <label id="country-error" class="error" style="margin-top:15px;" for="country"></label>
                        </div>
                     </div>

                     <div class="form-group col-md-6 did-floating-label-content did-error-input">
                        <div>
                           <select class="form-control select2 did-floating-select getstate"  id="state"  name="state_id" value="">
                            
                           </select>
                           <label style="margin-top: 5px;border-color:#ced4da;" class="did-floating-label">State</label>
                           <label id="state-error" class="error" style="margin-top:15px;" for="state"></label>
                        </div>
                     </div>

                    <div class="form-group col-md-6 did-floating-label-content did-error-input">
                        <div>
                           <select class="form-control select2 did-floating-select" required id="role_id" name="role_id" value="">
                                <option value=""></option>
                                 <?php
                                foreach ($user_roles as $key => $value) {
                              ?>
                                <option value="<?= $value['id'] ?>"  <?= (isset($role_id) && $role_id ==$value['id'])? 'selected': '';?>><?= $value['role_name'] ?></option>
                                <?php } ?>

                           </select>
                           <label style="margin-top: 5px;border-color:#ced4da;" class="did-floating-label">Role Name</label>
                           <label id="role_id-error" class="error" style="margin-top:2px;" for="role_id"></label>
                        </div>
                     </div>


                    <div class="form-group col-md-6 did-floating-label-content did-error-input">
                        <div>
                           <select class="form-control select2 did-floating-select" required id="parent_staff_role"   name="parent_staff_role" value="">
                                <option value=""></option>
                                 <?php
                                foreach ($main_role as $key => $value) {
                              ?>
                                <option value="<?= $value['id'] ?>" <?= (isset($parent_staff_role) && $parent_staff_role ==$value['id'])? 'selected': '';?>  ><?= $value['role_name'] ?></option>
                                <?php } ?>

                           </select>
                           <label style="margin-top: 5px;border-color:#ced4da;" class="did-floating-label">Parent Role</label>
                           <label id="parent_staff_role-error" class="error" for="parent_staff_role"></label>
                        </div>
                     </div>


                     <div class="form-group col-md-6 did-floating-label-content did-error-input">
                       
                        <div>
                           <select class="form-control select2 did-floating-select" required name="parent_staffid" id="parent_staffid" value="">
                               <option value=""></option>
                                

                           </select>
                           <label style="margin-left: 10px;border-color:#ced4da;" class="did-floating-label">Parent Name</label>
                           <label id="parent_staffid-error" class="error" style="margin-top: 11px;" for="parent_staffid"></label>
                        </div>
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
                                  <th>Sr.No</th>
                                  <th>Permission</th>
                                  <th>View(global)</th>
                                  <th>View(own)</th>
                                  <th>Create</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                                </tr>
                              </thead>
                               <tbody>
                                                <?php
                                                    foreach($modules as $key2=>$value2){
                                                      
                                                ?>
                                                    <tr id="row_<?= $value2['id']; ?>" class="access_role_row access_role_<?= $value2['id']; ?>">
                                                    <td><?= ++$key2; ?>
                                                      
                                                      <input type="hidden" name="module_id[]" value="<?= $value2['id']; ?>">
                                                      <input type="hidden" id="user_module_id_<?= $value2['id']; ?>" name="user_module_id_<?= $value2['id']; ?>" value="">
                                                    </td>
                                                    <td><b class="text-size"><?= ucwords($value2['name']); ?></b></td>
                                                    <td>
                                                      <center>
                                                        <input type="checkbox" class="form-control size  all_check" id="view_global_<?= $value2['id']; ?>" name="view_global_<?= $value2['id']; ?>" title="view_global[]" value="1">
                                                      </center>
                                                    </td>
                                                    <td>
                                                      <center>
                                                           <input type="checkbox" class="form-control size all_check" id="view_own_<?= $value2['id']; ?>" name="view_own_<?= $value2['id']; ?>" title="view_own" value="1">
                                                      </center>
                                                    </td>
                                                    <td>
                                                      <center>
                                                           <input type="checkbox" class="form-control size all_check" id="create_<?= $value2['id']; ?>" name="create_<?= $value2['id']; ?>" title="create[]" value="1">
                                                      </center>
                                                    </td>
                                                    <td>
                                                      <center>
                                                           <input type="checkbox" class="form-control size all_check" id="edit_<?= $value2['id']; ?>" name="edit_<?= $value2['id']; ?>" title="edit" value="1">
                                                      </center>
                                                    </td>
                                                    <td>
                                                      <center>
                                                           <input title="delete" class="form-control size all_check" type="checkbox" id="delete_<?= $value2['id']; ?>" name="delete_<?= $value2['id']; ?>" value="1">
                                                      </center>
                                                    </td>
                                                        
                                                    
                                                   <!--  <td><button class="btn btn-info" title="update" id="update" name="update" value="0">update</button>    
                                                    </td> -->
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
               <input type="submit" style="float: right;margin-left: 5px;" class="btn btn-info" value="update">
               <a href="<?= base_url('admin/UserAccess');?>" style="float: right;" class="btn btn-info">Back</a>
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
        // $('#frm').validate();
        $('#frm').validate({
                    rules: {
                        email: {
                            required: true,
                             remote: {
                                url: base_url+"admin/UserAccess/email_check",
                                type: "post"
                             }
                           },
                        contact: {
                            required: true,
                             remote: {
                                url: base_url+"admin/UserAccess/contact_check",
                                type: "post"
                             }
                           }, 
                         },
                    messages: {
                    email: {
                        required: "Please enter your email id",
                        remote: "Email is Already in Use !"
                    },
                    contact: {
                        required: "Please enter your Mobile Number",
                        remote: "Mobile Number is Already in Use !"
                    },
                },
            
            });
      </script>
 
