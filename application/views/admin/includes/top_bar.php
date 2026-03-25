   <!-- ============================================================== -->
   <!-- Topbar header - style you can find in pages.scss -->
   <!-- ============================================================== -->
   <style>
       .topbar {
           background: #48bc97 !important;
       }

       .card-no-border .left-sidebar,
       .card-no-border .sidebar-nav {
           background: #48bc97 !important;
       }

       .icon-Car-Wheel {
           color: white !important;
       }

       .btn-theme {
           background: #48bc97 !important;
           border: 1px solid #48bc97 !important;
           transition: 0.2s ease-in;
           color: #fff !important;
       }



       @media (min-width: 768px) {
           .mini-sidebar .sidebar-nav #sidebarnav>li>ul {
               right: -76px !important;
           }

       }
   </style>
   <header class="topbar">
       <!--  <nav class="navbar navbar-light bg-light company_nav_bar">
                <h5 class="no-bottom-margin"> Company Name: <span><input type="hidden" id="company_id" name="company_id"></span><input type="hidden" id="company_site_id" name="company_site_id">
                </h5>
            </nav> -->
       <nav class="navbar top-navbar navbar-expand-md navbar-light">
           <!-- ============================================================== -->
           <!-- Logo -->
           <!-- ============================================================== -->
           <div class="navbar-header">
               <a class="navbar-brand" href="<?= base_url(); ?>">
                   <!-- Logo icon --><b>
                       <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                       <!-- Dark Logo icon -->
                       <img src="<?= base_url(); ?>/assets/images/logo.png" alt="homepage" class="dark-logo" height="70" />
                       <!-- Light Logo icon -->
                       <img src="<?= base_url(); ?>assets/images/logo.png" alt="homepage" class="light-logo" height="70" />
                   </b>
                   <!--End Logo icon -->
                   <!-- Logo text -->
               </a>
           </div>
           <!-- ============================================================== -->
           <!-- End Logo -->
           <!-- ============================================================== -->
           <div class="navbar-collapse">
               <!-- ============================================================== -->
               <!-- toggle and nav items -->
               <!-- ============================================================== -->
               <ul class="navbar-nav mr-auto">
                   <!-- This is  -->
                   <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                   <li class="nav-item hidden-sm-down"><span></span></li>
               </ul>
               <!-- ============================================================== -->
               <!-- User profile and search -->
               <!-- ============================================================== -->
               <ul class="navbar-nav my-lg-0">


                   <!-- ============================================================== -->
                   <!-- Profile -->
                   <!-- ============================================================== -->
                   <li class="nav-item dropdown mega-dropdown"> <a class="nav-link  waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <p class="text-white"><?= userId('company_site_name'); ?></p>
                           <p class="text-white">FY : &nbsp;<?= userId('company_financial_year'); ?></p>
                       </a>

                   </li>
                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle " href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border:4px double white; padding:0;border-radius: 50%; margin-top: 10px">
                           <?php
                            $user_image = userId('image');
                            ?>

                           <img src="<?= !empty($user_image)
                                            ? base_url(USER_PROFILE . $user_image)
                                            : base_url('assets/images/default_user.png'); ?>"
                               alt="user" class="profile-pic"> </a>
                       <div class="dropdown-menu dropdown-menu-right animated flipInY">
                           <ul class="dropdown-user">
                               <li>
                                   <div class="dw-user-box">
                                       <div class="u-img"><img src="<?php echo base_url(USER_PROFILE); ?><?= (userId('image')) ? userId('image') : 'no_image.jpg' ?>" alt="user"></div>
                                       <div class="u-text">
                                           <h4><?= userId('name'); ?></h4>
                                           <p class="text-muted"><?= userId('email'); ?></p><a href="<?= base_url(); ?>admin/Auth/Profile" class="btn btn-rounded btn-danger btn-theme btn-sm">View Profile</a>
                                       </div>
                                   </div>
                               </li>

                               <li><a href="<?= base_url('logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                           </ul>
                       </div>
                   </li>

                   <!-- ============================================================== -->
                   <!-- mega menu -->
                   <!-- ============================================================== -->

                   <!-- ============================================================== -->
                   <!-- End mega menu -->
                   <!-- ============================================================== -->
                   <!-- <li><button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button></li> -->
               </ul>

           </div>
       </nav>
       <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-theme pull-right"><i class="ti-settings text-white"></i></button>
   </header>

   <!-- ============================================================== -->
   <!-- End Topbar header -->
   <!-- ============================================================== -->