<?php  init_header(); ?>
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
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
    white-space: normal !important;
    word-wrap: break-word !important;;
    text-align:left;
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
               <div class="col-md-5">
                  <h4 class="card-title">Items Master</h4>
               </div>
               <div class="col-md-7 align-self-center text-right d-none d-md-block">
                
                     <a href="<?= base_url('admin/master/Items/add_items');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Add Items</a>
                
               </div>  
            </div>
            <div>
               <div class="row">
               <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control select2 did-floating-select item_name"  id="item_name"   name="item_name" value="" onchange="items_filter()">
                     <option value="all" selected>Select All</option>
                  </select>
               </div>
               
                <div class="col-md-2">
                  <label>Item Group</label>
                  <select class="form-control select2 did-floating-select item_group_name"  id="id_itemgroup"   name="id_itemgroup" value="" onchange="items_filter()">
                       <option value="all" selected>Select All</option>
                  </select>
               </div>

                <div class="col-md-2">
                  <label>Stock Unit</label>
                  <select class="form-control select2 did-floating-select stock_unit_name"  id="id_stock"   name="id_stock" value="" onchange="items_filter()">
                       <option value="all" selected>Select All</option>
                  </select>
               </div>
               
            </div> 

            <div class="table-responsive">
               <table id="items_tbl" class="table display table-bordered text-center" width="100%">
               </table>
            </div>

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
<script src="<?= base_url(); ?>assets/js/page-js/master/items.js?v=1.0.3"></script>