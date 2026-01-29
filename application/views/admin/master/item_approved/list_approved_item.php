<?php  init_header(); ?>
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
<style>._status{cursor: pointer;}
   th, td {
   white-space: nowrap !important;
   }
   .btn-sm{
      background: whitesmoke !important;
      border: 1px solid #959595 !important;
      /*color: red !important;*/
   }

     .select2-selection{
    height: 37px !important;
    
  }
  .no_margin_bottom{
   margin-bottom: 0rem !important;
   }
   .dataTables_filter{
       margin-top:0px !important;
   }
   
   .dataTables_length{
       margin-top:0px !important;
   }
    label{
       margin-bottom: 0.2rem;
    }
    .text_wrap{
         word-wrap: break-word !important;
    }
    td{
        word-wrap: break-word !important;
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
                  <h4 class="card-title">Approved Item List </h4>
               </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                  <label>Company</label>
                  <select class="form-control select2 did-floating-select"  id="company_id"   name="company_id" value="" onchange="filter_item_approved()">
                     
                 </select>
               </div>
               <div class="col-md-2">
                  <label>Site</label>
                  <select class="form-control select2 did-floating-select"  id="site_id"   name="site_id" value="" onchange="filter_item_approved()">
                     
                  </select>
               </div>

               <div class="col-md-2">
                  <label>Vendor</label>
                  <select class="form-control select2 did-floating-select"  id="vendor_id"   name="vendor_id" value="" onchange="filter_item_approved()">
                    
                  </select>
               </div>

               <div class="col-md-2">
                  <label>Item Group Name</label>
                  <select class="form-control select2 did-floating-select"  id="item_group_name" name="item_group_name" value="" onchange="filter_item_approved()">
                    
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control select2 did-floating-select"  id="item_name_id" name="item_name_id" value="" onchange="filter_item_approved()">
                   
                  </select>
               </div>

               <div class="col-md-2">
                  <label>Status</label>
                  <select class="form-control select2 did-floating-select"  id="is_approved" name="is_approved" value="" onchange="filter_item_approved()">
                    <option value="all">Select All</option>
                   <option value="0">Pending</option>
                   <option value="1">Approved</option>
                   <option value="2">Reject</option>
                  </select>
               </div>

              
              


            </div>




            <div>

            <div class="table-responsive">
               <table id="tbl_item_approved_list" class="table display table-bordered text-center" width="100%">
               </table>
            </div>

         </div>
      </div>
   </div>
</div>
</div>


<div id="StatusUpdateModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_StatusUpdate"></div>
      </div>
   </div>
</div>

<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/master/item_approved.js"></script>
