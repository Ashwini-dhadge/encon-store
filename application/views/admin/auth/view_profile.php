 <?php  init_header(); ?>


        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
            <!--     <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus-circle"></i> Create New</button>
                    </div>
                    <div class="">
                        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img width="100" height="auto" src="<?php echo base_url(USER_PROFILE);?><?= (userId('image'))? userId('image') : 'no_image.jpg' ?>">
                                  
                                    <!-- <//?php echo print_r($profile);?> -->
                                    <h4 class="card-title m-t-10"><?= (isset($profile['first_name']))? $profile['first_name'] : ''; ?></h4>
                                    <!--<h6 class="card-subtitle">Accoubts Manager Amix corp</h6>-->
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-12">
                                            <font class="font-medium">  
                                               <form action="<?= base_url();?>admin/Auth/add" enctype="multipart/form-data" method="post">
                                                    <input type="hidden" name="id" value="<?= (isset($profile['id']))? $profile['id'] : '' ?>">
                                                    <input required style="width: 70%;" type="file" class="form-control" name="image" >
                                                    <input style="margin-top: -8px;font-size: 12px;" class="btn btn-info btn-theme" type="submit" value="upload"> 
                                                </form>
                                            </font>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body"> <small class="text-muted">Email Address </small>
                                <h6><?= (isset($profile['email']))? $profile['email'] : ''; ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                                <h6><?= (isset($profile['contact']))? $profile['contact'] : ''; ?></h6> 

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Profile</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Change Password</a> </li>
                                <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Timeline</a> </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">

                                	  <div class="card-body">
                                        <form class="form-horizontal form-material" action="<?= base_url();?>admin/Auth/update_data" enctype="multipart/form-data" method="post">
                                            <input type="hidden" name="id" value="<?= (isset($profile['id']))? $profile['id'] : '' ?>">
                                            <div class="form-group">
                                                <label class="col-md-12">Name</label>
                                                <div class="col-md-12">
                                                   <input  type="text" class="form-control" required name="first_name" value="<?= (isset($profile['first_name']))? $profile['first_name'] : ''; ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Last Name</label>
                                                <div class="col-md-12">
                                                    <input  type="text" class="form-control" name="last_name" value="<?= (isset($profile['last_name']))? $profile['last_name'] : ''; ?>">
                                                    
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input  type="text" class="form-control"  readonly name="email" value="<?= (isset($profile['email']))? $profile['email'] : ''; ?>" >

                                                </div>
                                            
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-12">Mobile</label>
                                                <div class="col-md-12">
                                                    <input  type="text" class="form-control"  name="contact" readonly value="<?= (isset($profile['contact']))? $profile['contact'] : ''; ?>">

                                                </div>
                                            
                                            </div>
                                         
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="submit" class="btn btn-info btn-theme" value="update" class="btn btn-success" >
                                                </div>
                                            </div>
                                        </form>
                                       
                                    </div>
								</div>
                                <!--second tab-->
                                <div class="tab-pane" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material" id="changePassword" >
                                            <input type="hidden" name="id" value="<?= (isset($profile['id']))? $profile['id'] : ''; ?>" >
                                            <div class="form-group">
                                                <label class="col-md-12">Old Password</label>
                                                <div class="col-md-12">
                                                    <input  type="password" class="form-control" id="pass_log_id" required name="old_password" value="<?= (isset($profile['password']))? $profile['password'] : ''; ?>">
                                                </div>
                                                <div class="col-md-1" style="margin-top: -20px;float: right;">
                                                    <span class="fa fa-eye icon" id="show-password"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">New Password</label>
                                                <div class="col-md-12">
                                                    <input  type="password" class="form-control new_password" required name="password" id="new_password" >
                                                </div>
                                                <div class="col-md-1" style="margin-top: -20px;float: right;">
                                                    <span class="fa fa-eye icon_n" id="show_new_password"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Confirm Password</label>
                                                <div class="col-md-12">
                                                    <input  type="password" class="form-control cnf_password" id="cnf_password" required name="c_password" >
                                                </div>
                                                <div class="col-md-1" style="margin-top: -20px;float: right;">
                                                    <span class="fa fa-eye icon_c" id="show_cnf_password"></span>
                                                </div>
                                                 <div style="margin-left: 15px;" class="registrationFormAlert" id="CheckPasswordMatch"></div>
                                            
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-info updt_pass btn-theme ">Update Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->

               <?php  init_footer(); ?>
            <script>
                $(document).ready(function(){
                    $('#changePassword').on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                          type: 'post',
                          url: base_url+'admin/Auth/changePassword',
                          data: $('form').serialize(),
                          dataType:'json',
                          success: function (response) {

                            if(response.result == true){
                          
                          alert_float('success',"Password Change Successfully");
                        }else{
                         
                          alert_float('error',"Please Enter Correct Password");
                        }

                          }
                        });
                      });
                  });


                $('.icon').click(function () {
                   if ($('#pass_log_id').attr('type') == 'text') {
                      $('#pass_log_id').attr('type', 'password');
                      $('#show-password').removeClass('fa-eye-slash').addClass('fa-eye');
                   } else {
                      $('#pass_log_id').attr('type', 'text');
                      $('#show-password').removeClass('fa-eye').addClass('fa-eye-slash');
                   }
                });

                $('.icon_n').click(function () {
                   if ($('#new_password').attr('type') == 'text') {
                      $('#new_password').attr('type', 'password');
                      $('#show_new_password').removeClass('fa-eye-slash').addClass('fa-eye');
                   } else {
                      $('#new_password').attr('type', 'text');
                      $('#show_new_password').removeClass('fa-eye').addClass('fa-eye-slash');
                   }
                });

                $('.icon_c').click(function () {
                   if ($('#cnf_password').attr('type') == 'text') {
                      $('#cnf_password').attr('type', 'password');
                      $('#show_cnf_password').removeClass('fa-eye-slash').addClass('fa-eye');
                   } else {
                      $('#cnf_password').attr('type', 'text');
                      $('#show_cnf_password').removeClass('fa-eye').addClass('fa-eye-slash');
                   }
                });

                function checkPasswordMatch() {
                    var password = $(".new_password").val();
                    var confirmPassword = $(".cnf_password").val();
                    
                    if (password != confirmPassword){
                        $("#CheckPasswordMatch").html("Passwords does not match!").css('color', 'red');
                          $(".updt_pass").attr('disabled', 'disabled'); 
                    }
                    else{
                        $("#CheckPasswordMatch").html("Passwords match.").css('color', 'green');;
                        $(".updt_pass").removeAttr('disabled');
                    }
                }
                
                $(document).ready(function () {
                   $(".cnf_password").keyup(checkPasswordMatch);
                });
            </script>
