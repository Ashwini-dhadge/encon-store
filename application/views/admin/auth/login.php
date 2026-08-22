<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <title><?= PROJECT_NAME; ?></title>
    <link rel="canonical" href="" />
    <!-- Favicon icon -->

     <link rel="shortcut icon" href="<?= base_url()?>assets/images/favicon-16x16.png" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- page css -->
    <link href="<?= base_url() ?>assets/css/pages/login-register-lock.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    
    <!-- You can change the theme colors from here -->
<link href="<?= base_url() ?>assets/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<style>

    .login-register {
background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  height: 100%;
  width: 100%;
  padding: 10% 0;
  position: fixed;

    }    
    .error{
        color: red;
    }
    .btn-info, .btn-info.disabled {
        background: #0a53a5 !important;
        border: 1px solid #0a53a5 !important;
        transition: 0.2s ease-in;
    }
    .btn-theme{
        background: #48bc97 !important;
        border: 1px solid #48bc97 !important;
        transition: 0.2s ease-in;
        color:#fff !important;
    }
</style>
<body class="card-no-border">
 

      <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"><?= PROJECT_NAME; ?></p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
      <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
     
    <section id="wrapper">
        <div class="login-register" width="auto" height="100%" style="background-image:url(<?= base_url() ?>/assets/images/background/splash.png);">
            <div class="login-box card" style="margin-top: -15px;">
                <div class="card-body">
                    <?php if ($msg = $this->session->flashdata('success')): ?>
                             <div class="alert alert-success" role="alert">
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?= $msg ?></div>
                           <?php endif ?>
                           <?php if ($msg = $this->session->flashdata('error')): ?>
                              <div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?= $msg ?></div>
                           <?php endif ?>
                           
                           <?php if (isset($display_message)): ?>
                              <div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?= $display_message ?></div>
                           <?php endif ?>
                    <form class="form-horizontal form-material" method="post"id="loginform" action="<?= base_url('admin') ?>" enctype="multipart/form-data" >
                        <img src="<?= base_url()?>/assets/images/logo.png" style="height: 40px;" alt="homepage" class="light-logo" /> 
                        <!-- <h3 class="box-title m-b-20" style="font-size:30px;"><center>EFS(I) LOGISTICS SOLUTIONS</center></h3> -->

                      <!--  <div class="form-group">
                            <label>Select User Role</label>
                            <div class="col-xs-12">
                                 <select class="form-control border1" required id="role_id" name="role_id" aria-label="Default select example">
                                    <option value="" selected>Select User Role</option>
                                   
                                   
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                           <!-- <label>Username</label> -->
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="username" name="email" required placeholder="Enter username" multiple="true"></div>
                        </div>
                        <div class="form-group">
                           <!-- <label>Password</label> -->
                            <div class="col-xs-12">
                                  <input type="password" class="form-control" id="password" required name="password" placeholder="Enter password"> </div>
                        </div>
                       
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <center><button class="btn btn-block btn-info btn-rounded btn-theme" style="width:60%;" type="submit">Log In</button></button>
                            </div>
                        </div>
                       
                       
                    </form>
                  
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>/assets/node_modules/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>/assets/node_modules/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
    <!--Custom JavaScript -->
      <script type="text/javascript">
          setInterval(function(){
                $('.alert').fadeOut("slow");
         }, 3000);
      </script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
   $("#loginform").validate();
});
</script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    
</body>

</html>