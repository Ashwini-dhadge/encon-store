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
   

   table td { 
    word-wrap: break-word;
    
   }
  th, td {
   white-space: nowrap !important;
   }
 table td { 
    word-wrap: break-word;
    
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
                  <h4 class="card-title">Recevied Material Issue</h4>
               </div>
               <div class="col-md-7 align-self-center text-right d-none d-md-block">
                
               </div>  
            </div>
            <div class="row">
               <div class="col-md-2">
                  <label>Company Name</label>
                  <select class="form-control custom-select select2 company_id_a" id="companyid_a" onchange="po_filter()"  name="company_name_id" style="width:100%" >
                     <option value="all" selected>Select</option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Site Name</label>
                  <select class="form-control custom-select select2 site_id_a" id="site_id_a" onchange="po_filter()" name="site_name_id" style="width:100%" >
                     <option value="all" selected>Select</option>
                  </select>
               </div>
               <!--<div class="col-md-2">-->
               <!--   <label>Vendor</label>-->
               <!--   <select class="form-control select2 did-floating-select"  id="vendor_id"   name="vendor_id" value="" onchange="po_filter()">-->
                    
               <!--   </select>-->
               <!--</div>-->
                   <div class="col-md-2">
                  <label>Item Group</label>
                  <select class="form-control select2 did-floating-select item_group_name"  id="id_itemgroup"   name="id_itemgroup" value="" onchange="po_filter()">
                       <option value="all" selected>Select All</option>
                  </select>
               </div>
                 <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control custom-select select2 inventory_item_id" id="inventory_items"  style="width:100%"  onchange="po_filter()">
                        <option value=""></option>
                  </select>
               </div>

               <div class="col-md-2">
                  <label>Select Date</label>
                  <select class="form-control select2 did-floating-select"  id="on_date"   name="on_date" value="" onchange="po_filter()">
                      <option value="all">Select </option>
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
                    <input type="date" name="from_date" id="from_date" class="form-control" autocomplete="off" placeholder="From date" onchange="po_filter()">
                      
                </div>
                <div class=" col-md-2  on_date">
                    <label class="">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" autocomplete="off" placeholder="To date" onchange="po_filter()">
                    
                </div>



            </div>   
            <div>
               

            <div class="table-responsive">
               <table id="recevie_material_issue_tbl" class="table display table-bordered text-center" width="100%">
               </table>
            </div>

         </div>
      </div>
   </div>
</div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/store/recevie_issue.js"></script>
<!-- Sweet-Alert  -->
    <script src="<?= base_url();?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url();?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


