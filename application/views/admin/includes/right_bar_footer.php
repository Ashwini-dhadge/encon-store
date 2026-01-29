  <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar ">
                    <div class="slimscrollright">

                        <div class="rpanel-title"> Change Details <span><i class="ti-close right-side-toggle close-right-side-toggle"></i></span> </div>
                        <div class="r-panel-body" id="r-panel-body">
                               
                             <form action="<?= base_url('admin/Common/saveCompanyYear') ?>" method="post" id="common_frm_setting">                               
                                <div class="form-body">
                                    <div class="card-body" style="padding: 0.75rem !important;">
                                    
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Company Site</label>
                                                       <select class="select2 form-control custom-select" id="common_company_site_data" name="common_company_site_data"  style="width:100%" required>                                                       
                                                    </select>
                                                    <label id="common_company_site_data-error" class="error" for="common_company_site_data"></label>
                                                   </div>
                                                   <div class="form-group has-success">
                                                    <label class="control-label">Financial Year</label>
                                                    <select class="select2 form-control custom-select" id="common_financial_year" name="common_financial_year" style="width:100%" required></select>                                                       
                                                    <label id="common_financial_year-error" class="error" for="common_financial_year"></label>
                                                   </div>
                                            </div>
                                             <div class="col-md-12">
                                                <button type="button" class="btn btn-success btn-theme float-right" onclick="getChangeCompanyYear()">Change</button>  
                                             </div>                                             
                                        </div>                                      
                                    </div>         
                                </div>
                            </form>                               
                           
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->