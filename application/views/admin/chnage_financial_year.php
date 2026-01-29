 <?php init_header();  ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
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
             
              <form method="post" action="<?= base_url('admin/ChangeFinancialYear');?>" id="form" enctype="multipart/form-data"class="form-horizontal">
                  <div class="row">
                     <!-- <input type="hidden" name="id" id="id" value="<?= isset($itemgroup)? $itemgroup['id'] : ''; ?>"> -->
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Change Financial Year</b></h6>
                              </span>
                              <hr>
                           </div>
                         
                  
                           <div class="col-md-2">
                              <label>To Date</label>
                              <div class="input-group" style="width:100%">
                                 <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="to_date" id="to_date" value="" required>
                              </div>
                           </div>
                                    <div class="col-md-2">
                              <label>From Date</label>
                              <div class="input-group" style="width:100%">
                                 <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="from_date" id="from_date" value="" required >
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                  </div>
                  <input type="submit" id="btnsubmit" style="margin-left: 90%;" class="btn btn-success btn-theme float-right" value="Stock Report">
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
                
                <!-- End Page Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
             <?php  init_footer(); ?>
        <!-- Chart JS -->
    
    <script type="text/javascript">
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var screenHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

    // Log the screen dimensions
    console.log("Screen Width: " + screenWidth);
    console.log("Screen Height: " + screenHeight);
    </script>