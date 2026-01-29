<?php
    $this->load->view(ADMIN.INC.'right_bar_footer');
?>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer">
   © 2023 <?= PROJECT_NAME; ?>
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?= base_url()?>assets/node_modules/jquery/jquery.min.js"></script>
<!-- Bootstrap popper Core JavaScript -->
<script src="<?= base_url()?>assets/node_modules/bootstrap/js/popper.min.js"></script>
<script src="<?= base_url()?>assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?= base_url()?>assets/node_modules/ps/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?= base_url()?>assets/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?= base_url()?>assets/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?= base_url()?>assets/js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!--sparkline JavaScript -->
<!-- select 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="<?= base_url()?>assets/node_modules/styleswitcher/jQuery.style.switcher.js"></script>
<!-- Required datatable js -->
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/datatable/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<!-- <script src="<//?= base_url(); ?>assets/node_modules/datatable/js/pages/datatables.init.js"></script> -->
<!-- <script src="<//?= base_url(); ?>assets/node_modules/datatable/libs/parsleyjs/parsley.min.js"></script> -->
<script src="<?= base_url() ?>/assets/node_modules/toast-master/js/jquery.toast.js"></script>
<script src="<?= base_url() ?>/assets/js/toastr.js"></script>
<!--   <script src="<?= base_url(); ?>assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
   <script src="<?= base_url(); ?>assets/node_modules/sparkline/jquery.sparkline.min.js"></script> -->
<!--   <script src="https://unpkg.com/@popperjs/core@2"></script>
   <script src="https://unpkg.com/tippy.js@6"></script> -->
<!--Custom JavaScript -->
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script>
   function alert_float(type, message) {
          $.toast({
                 heading: '',
                 text: message,
                 position: 'top-right',
             
                 icon: type,
                 hideAfter: 3500
                 
               });
     }
</script>
<?php if ($msg = $this->session->flashdata('success')): ?>
<script type="text/javascript">
   alert_float("success","<?= $msg ?>");
</script>
<?php endif ?>
<?php if ($msg = $this->session->flashdata('error')): ?>
<script type="text/javascript">
   alert_float("error","<?= $msg ?>");
   
</script>
<?php endif ?>
<script type="text/javascript">
    <?php if ( userId('login_msg') &&  userId('is_login')==1): 
        $msg = userId('login_msg'); 
         $this->session->set_userdata(array('is_login'=>0));
    ?>
    console.log("<?= $msg ?>")
     $.toast({
        heading: 'Welcome to ENCON ERP',
        text: "<?= $msg ?>",
        position: 'bottom-right',
        loaderBg: '#48bc97',       
        hideAfter: 6000,
        stack: 6,
        textAlign: 'center'
    })
     <?php endif ?>
</script>
<script type="text/javascript">
   $('.scroll_div').perfectScrollbar();
   
</script>
<script>
   $(window).on('beforeunload',function(e) {
     e = e || window.event;
     var localStorageTime = localStorage.getItem('storagetime')
     if(localStorageTime!=null && localStorageTime!=undefined){
       var currentTime = new Date().getTime(),
           timeDifference = currentTime - localStorageTime;
   
       if(timeDifference<25){//Browser Closed
          localStorage.removeItem('storagetime');
                   $.ajax({
                             url: base_url+'admin/Auth/autologout',
                             type: "post",
                            
                             dataType:'json',
                             success: function (response) {
                                 if(response){
                                     window.location.reload();
                                 }
                             }
                   });
       }else{//Browser Tab Closed
          localStorage.setItem('storagetime',new Date().getTime());
         // console.log("browser tab")
       }
       
       //   $.ajax({
       //       url: base_url+'admin/Auth/autologout',
       //       type: "post",
            
       //       dataType:'json',
       //       success: function (response) {
       //           if(response){
       //               window.location.reload();
       //           }
       //       }
       //   });
   
     }else{
       localStorage.setItem('storagetime',new Date().getTime());
     }
   });
    $(document).ready(function() {
      // Initialize Select2 on #as
      $("#as").select2();
    });
    
   
</script>
</body>
</html>
