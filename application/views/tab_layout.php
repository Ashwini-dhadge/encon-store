 <?php  init_header(); ?>
    <style>._status{cursor: pointer;}
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #20aee3 !important;
        }
        .text-size,.nav-link{
            font-size: 16px;
        }
        .size{
            /*text-align: center;*/
            width: 18px;
        }
        .form-control:focus{
            box-shadow: none;
        }
        .btn-info{
            padding: 4px;
        }
        thead,td{
        text-align: center;
        }
  .vertical {
            border-right: 1px solid gray;
            height: 200px;
            /*position:absolute;*/
            /*left: 50%;*/
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
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">User Access</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">User Access</a></li>
                            <li class="breadcrumb-item active"><?= $title;?></li>
                        </ol>
                    </div>
                   <!--  -->
                </div>

             
          <div class="row">
            <div class="col-12">
              <div class="card">
                  <div class="card-body">
                   <!-- <//https://codepen.io/JacobLett/pen/XopYBo ?php $this->load->view(ADMIN.'RoleAccess/tbl_Role Access'); ?> -->
                   
                   <!-- start permission view design -->

                   <div class="row">
                        <div class="col-md-2 mb-3 vertical" >
                            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Super Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Employee</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="view-tab" data-toggle="tab" href="#view" role="tab" aria-controls="contact" aria-selected="false">Customer</a>
                                </li>
                            </ul>
                        </div>
    <!-- /.col-md-4 -->
                        <div class="col-md-10">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                   
                                    <!-- column -->
                    <div class="col-12">
                        <!-- <div class="card">
                            <div class="card-body"> -->
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
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>1</td>
                                                <td><b class="text-size">AMC</b></td>
                                                <td>
                                                    
                                                        <input type="checkbox" class="form-control size" id="view_global" name="view_global" title="view_global" value="">
                                                    
                                                </td>
                                                <td>
                                                        <input type="checkbox" class="form-control size" id="view_own" name="view_own" title="view_own" value="">
                                                    
                                                </td>
                                                <td class="text-nowrap">
                                                    
                                                        <input type="checkbox" class="form-control size" id="create" name="create" title="create" value="">
                                                    
                                                </td>
                                                <td>
                                                    
                                                        <input type="checkbox" class="form-control size" id="edit" name="edit" title="edit" value="">
                                                    
                                                </td>
                                                <td>
                                                    
                                                        <input title="delete" class="form-control size" type="checkbox" id="delete" name="delete" value=""></td>
                                                    
                                                
                                                <td><button class="btn btn-info" title="update" id="update" name="update" value="">update</button>    
                                            </tr>

                                            <tr>
                                                <td>2</td>
                                                <td><b class="text-size">Reports</b></td>
                                                <td>
                                                    
                                                        <input type="checkbox" class="form-control size" id="view_global" name="view_global" title="view_global" value="">
                                                    
                                                </td>
                                                <td>
                                                        <input type="checkbox" class="form-control size" id="view_own" name="view_own" title="view_own" value="">
                                                    
                                                </td>
                                                <td class="text-nowrap">
                                                    
                                                        <input type="checkbox" class="form-control size" id="create" name="create" title="create" value="">
                                                    
                                                </td>
                                                <td>
                                                    
                                                        <input type="checkbox" class="form-control size" id="edit" name="edit" title="edit" value="">
                                                    
                                                </td>
                                                <td>
                                                    
                                                        <input title="delete" class="form-control size" type="checkbox" id="delete" name="delete" value=""></td>
                                                    
                                                
                                                <td><button title="update" class="btn btn-info" id="update" name="update" value="">update</button>    
                                            </tr>

                                     
                                          </tbody>
                                    </table>
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                    <!-- column -->
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                   
                                     <div class="col-12">
                        <!-- <div class="card">
                            <div class="card-body"> -->
                                <h4 class="card-title">Admin Permission</h4>
                               
                                <div class="table-responsive">
                                    123456
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                  
                                     <div class="col-12">
                        <!-- <div class="card">
                            <div class="card-body"> -->
                                <h4 class="card-title">Employee Permission</h4>
                               
                                <div class="table-responsive">
                                   123456
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                                </div>
                                <div class="tab-pane fade" id="view" role="tabpanel" aria-labelledby="contact-tab">
                                 
                                     <div class="col-12">
                        <!-- <div class="card">
                            <div class="card-body"> -->
                                <h4 class="card-title">Customer Permission</h4>
                               
                                <div class="table-responsive">
                                    123456
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /.col-md-8 -->
                    </div>

                   <!-- end permission view design -->
                  </div>
                </div>
            </div>
          </div>
<?php  init_footer(); ?>
<!-- <script src="<//?= base_url(); ?>assets/js/page-js/visit_request.js"></script> -->