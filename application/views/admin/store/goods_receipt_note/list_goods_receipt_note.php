<?php  init_header(); ?>
<style>

table td {
  word-wrap: break-word;
  }
#tbl_grn_list td {
  white-space:inherit;
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
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-5">
                  <h4 class="card-title">GRN List </h4>
               </div>
               <div class="col-md-7 align-self-center text-right d-none d-md-block">
                  <?php  if(getUserAccessForModule('Store order','create')): ?>
                     <a href="<?= base_url('admin/store/GoodsReceiptNote/add_Goods_Receipt_Note');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Add Direct GRN</a>
                  <?php endif; ?>
               </div>  
            </div>
            <div>
            
                <div class="row">
               <div class="col-md-2">
                  <label>Vendor</label>
                  <select class="form-control select2 did-floating-select city_name"  id="vendor_id"   name="vendor_id" value="" onchange="grn_filter()">
                     <option value=""></option>
                  </select>
               </div>
               
               <div class="col-md-2">
                  <label>Compnay</label>
                  <select class="form-control select2 did-floating-select"  id="company_id"   name="company_id" value="" onchange="grn_filter()">
                         <option value="">Select</option>
                     <option value="all">All</option>
                     <?php
                                foreach ($company_master as $key => $value) {
                                    
                              ?>
                                <option value="<?= $value['id'] ?>"  <?= (isset($company_id) && $company_id ==$value['id'])? 'selected': '';?>><?= $value['name'] ?></option>
                                <?php                                 
                                } 
                                ?>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Site Master</label>
                  <select class="form-control select2 did-floating-select"  id="site_id"   name="site_id" value="" onchange="grn_filter()">
                         <option value="">Select</option>
                     <option value="all">All</option>
                    
                  </select>
               </div>
                <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control custom-select select2" id="item_id"  style="width:100%"  onchange="grn_filter()">
                        <option value=""></option>
                  </select>
               </div>
                  <?php if (userId('role_id') == SUPERADMIN_ROLE) { ?>
                                    <div class="col-md-2">
                                        <label>Is Display Deleted</label>
                                        <select class="form-control select2 did-floating-select" id="is_delete_id" name="is_delete_id" value="" onchange="grn_filter()">
                                            <option value="">Select </option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>

                                        </select>
                                    </div>
                                <?php } ?>
               <div class="col-md-2">
                  <label>GRN Date</label>
                  <select class="form-control select2 did-floating-select"  id="on_date"   name="on_date" value="" onchange="grn_filter()">
                      <option value="">Select </option>
                         <option value="1">Today</option>
                         <option value="2">Yesterday</option>
                         <option value="3">This Week</option>
                         <option value="4">This Month</option>
                         <option value="5">This Year</option>
                         <option value="6">Custome Date</option>
                  </select>
               </div>
                
                <div class=" col-md-2  on_date">
                    <label class="">From Date</label>
                      <input type="date" name="from_date" id="from_date" class="form-control" autocomplete="off" placeholder="From date" onchange="grn_filter()">
                      
                </div>
                <div class=" col-md-2  on_date">
                      <label class="">To Date</label>
                      <input type="date" name="to_date" id="to_date" class="form-control" autocomplete="off" placeholder="To date" onchange="grn_filter()">
                    
                 </div>
               <!-- <div class="col-md-1">
                  <label></label>
                  <button class="btn btn-info filter_clear" style="margin-top: 16px;padding: 2px;">clear</button>
               </div> -->

            </div>  

            
               

            <div class="table-responsive">

               <table id="tbl_grn_list" class="table display table-bordered text-center" width="100%">
               </table>
            </div>
           
         
      </div>
   </div>
</div>
</div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/store/grn.js?v=1.0.3"></script>

 <!-- Sweet-Alert  -->
    <script src="<?= base_url();?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url();?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


<script>

   $('.deleteBtn').on('click', function() {
    deleteBtn();
   });

 function deleteBtn(id = '') {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        confirmButtonColor: '#dc3545', 
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'Item deletion was cancelled.', 'info');
            return; 
        }
        if (result.value) { 
            Swal.fire({
                title: 'Delete GRN Confirmation',
                html: `
                    <div class="row">
                        <label class="col-sm-4 col-form-label text-sm-left">Reason:</label>
                        <div class="col-sm-12">
                            <textarea id="reason" class="form-control" row="2" cols="50" placeholder="Reason for deleting the record"></textarea>
                        </div>
                        <div class="col-sm-4 col-form-label text-sm-left" style="padding:0px 15px;">
                           <small id="reason-error" class="text-danger" style="display:none;">Reason is required</small>
                        </div>
                    </div>`,
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dc3545', // Red color
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const reason = $('#reason').val();
                    if (!reason) {
                        $('#reason-error').show();
                        return false; // Prevents the Swal from closing
                    }
                    return {
                        reason: reason
                    };
                }
            }).then((result) => {
                if (result.value && result.value.reason) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'admin/store/GoodsReceiptNote/grnDelete',
                        data: {
                            grn_id: id,
                            reason: result.value.reason
                        },
                        success: function(response) {
                            Swal.fire('Deleted!','Grn Details Deleted Successfully!', 'success');
                             location.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Fail to Delete Grn Details' , 'error');
                            
                        }
                    });
                } else {
                    Swal.fire('Cancelled', 'Grn Details deletion was cancelled.', 'info');
                }
            }).catch((error) => {
                Swal.fire('Error!', 'An error occurred while deleting the Grn Details.', 'error');
                console.error('Error:', error);
            });
        }
    });

    setInterval( function () {
       $('#tbl_grn_list').DataTable().ajax.reload();
   }, 1000 );
}





</script>
