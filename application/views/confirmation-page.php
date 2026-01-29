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

<body class="card-no-border">
 

      <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
   
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
      <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
        <section id="wrapper" >
          <div class="row">
            <div class="col-md-4 offset-md-4 ">
              <div class="card">
              <div class="card-body">
                <div class=" ">
                 <h1 class="text-info text-center">Purchase Order Confirmation</h1>
                </div>
                <input type="hidden" name="po_id" id="po_id" value="<?= $po_data['id']; ?>">
                 <h4>Thank you for confirming the receipt of Purchase Order #<?= $po_data['po_order_no']; ?>.</h4>
                <table class="table no-border">
                  <tbody>
                    <tr>
                      <td>Purchase Order Number</td>
                      <td class="font-medium"><?= $po_data['po_order_no']; ?></td>
                    </tr>
                    <tr>
                      <td>Date</td>
                      <td class="font-medium"><?= date('d F Y',strtotime($po_data['po_date'])); ?></td>
                    </tr>
                   
                     </tbody>
                </table>
                <hr>
                <p class="text-center">Thank you for choosing <strong><?= $po_data['company_name'] ?></strong> . We appreciate your business!</p>
              </div>
            </div>
              <div class="card">
                <div class="card-body">
                   <h1 class="text-info"></h1>
                   <p></p>
                </div>
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
    <script>var base_url = '<?= base_url(); ?>';var _admin = 'admin/';  </script>
    <!--Custom JavaScript -->
      <script>
          $.ajax({
              url: base_url + 'updatePOApprove',
              type: "post",  
              data: {'po_id':$('#po_id').val()},            
              dataType: 'json',
              success: function(response) {
                
              }
          });
      </script>
    
</body>

</html>