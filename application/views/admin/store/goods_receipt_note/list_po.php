<?php  init_header(); ?>
<style>
    .dataTables_wrapper .dataTables_wrapper .dataTables_scroll .dataTables_scrollBody table.dataTable tbody th,
    .dataTables_wrapper .dataTables_wrapper .dataTables_scroll .dataTables_scrollBody table.dataTable tbody td {
      word-wrap: break-word;
      white-space: normal;
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
                  <h4 class="card-title">GRN Aginst PO </h4>
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
                  <select class="form-control select2 did-floating-select city_name"  id="vendor_id"   name="vendor_id" value="" onchange="po_filter()">
                     <option value=""></option>
                  </select>
               </div>
               
               <div class="col-md-2">
                  <label>Compnay</label>
                  <select class="form-control select2 did-floating-select"  id="company_id"   name="company_id" value="" onchange="po_filter()">
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
                  <select class="form-control select2 did-floating-select"  id="site_id"   name="site_id" value="" onchange="po_filter()">
                         <option value="">Select</option>
                     <option value="all">All</option>
                    
                  </select>
               </div>
                  <div class="col-md-2">
                  <label>Item Group</label>
                  <select class="form-control select2 did-floating-select item_group_name"  id="id_itemgroup"   name="id_itemgroup" value="" onchange="po_filter()">
                       <option value="all" selected>Select All</option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control custom-select select2" id="item_id"  style="width:100%"  onchange="po_filter()">
                        <option value=""></option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>PO Date</label>
                  <select class="form-control select2 did-floating-select"  id="on_date"   name="on_date" value="" onchange="po_filter()">
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
                      <input type="date" name="from_date" id="from_date" class="form-control" autocomplete="off" placeholder="From date" onchange="po_filter()">
                      
                </div>
                <div class=" col-md-2  on_date">
                      <label class="">To Date</label>
                      <input type="date" name="to_date" id="to_date" class="form-control" autocomplete="off" placeholder="To date" onchange="po_filter()">
                    
                 </div>
               <!-- <div class="col-md-1">
                  <label></label>
                  <button class="btn btn-info filter_clear" style="margin-top: 16px;padding: 2px;">clear</button>
               </div> -->

            </div>  

            
               

            <div class="table-responsive">

               <table id="tbl_po" class="table display table-bordered text-center" width="100%">
               </table>
            </div>
               <div class="form-actions">
                        <div class="row">
                           <div class="col-md-6"> </div>
                           <div class="col-md-6">
                              <form id="myForm" action="<?= base_url()."admin/store/GoodsReceiptNote/add_Goods_Receipt_Note" ?>" method="post">
                                 <input type="hidden" name="type" id="type" value="3">
                                  
                              <button class="btn btn-info btn-theme"  type="submit" id="submitBtn" >Create GRN</button></form>
                           </div>
                        </div>
                     </div>
            <div class="row">
                   
               </div>
      </div>
   </div>
</div>
</div>
</div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/store/grn.js?v=1.0.3"></script>

