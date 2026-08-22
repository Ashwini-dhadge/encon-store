<?php  init_header(); ?>
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
    
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>._status{cursor: pointer;}
  


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
  
  .buttons-columnVisibility{
      color:#000 !important;
  }
 button.dt-button:hover:not(.disabled){
        color:#000 !important;
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
               <div class="col-md-8">
                  <h4 class="card-title">Inventory List</h4>
               </div>
               <div class="col-md-4 align-self-center text-right d-none d-md-block">
                  <a href="<?= base_url('admin/store/MaterialIssue/add_materialissue');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Add Inventory List</a>
               </div>  
            </div>
           
            <div class="row">
               <div class="col-md-2">
                  <label>Company Name</label>
                  <select class="form-control custom-select select2 company_id" id="companyid" onchange="inventory_filter()"  name="company_name_id" style="width:100%" >
                     <?php
                         foreach ($company_name as $key => $value) {
                           if(( userId('company_id')==$value['id'])){
                            $selected="selected";
                             }else{
                             $selected="";
                           } ?>
                        <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Site Name</label>
                  <select class="form-control custom-select select2 site_id" id="site_id" onchange="inventory_filter()" name="site_name_id" style="width:100%" >

                     <?php
                         foreach ($site_name as $key => $value) {
                           if(( userId('site_id')==$value['id'])){
                            $selected="selected";
                             }else{
                             $selected="";
                           } ?>
                        <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['site_name'] ?></option>
                     <?php } ?>
                  
                  </select>
               </div>
                <div class="col-md-2">
                  <label>Item Group</label>
                  <select class="form-control select2 did-floating-select item_group_name"  id="id_itemgroup"   name="id_itemgroup" value="" onchange="inventory_filter()">
                       <option value="all" selected>Select All</option>
                  </select>
               </div>
                 <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control custom-select select2 inventory_item_id" id="inventory_items"  style="width:100%"  onchange="inventory_filter()">
                        <option value=""></option>
                  </select>
               </div>
                <div class="col-md-2">
                  <label>Reserve Stock</label>
                  <select class="form-control select2 did-floating-select is_reserve_stock"  id="is_reserve_stock"   name="is_reserve_stock" value="" onchange="inventory_filter()">
                  <option value="">All</option>
                  <option value="<?= RESERVE ?>">Reserved</option>
                  <option value="<?= NOT_RESERVE ?>">Not Reserved</option>
                  </select>
                  </div>

            </div>

           <div>
                
            </div>

            <div class="table-responsive">
                
               <table id="inventory_tbl" class="table display table-bordered text-center" width="100%">
               </table>
            </div>

         
         </div>
      </div>
   </div>
</div>

<?php  init_footer(); ?>
  
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- Include DataTables Buttons extension -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
 
    <!-- Include JSZip for Excel export -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- Include DataTables Buttons extension for Excel export -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/js/page-js/inventory.js?1.0.3"></script>
<script>

</script>
