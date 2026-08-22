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
    white-space: normal !important;
    word-wrap: break-word !important;;
    text-align:left;
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

<script src="<?= base_url(); ?>assets/js/page-js/master/items.js?v=1.0.1"></script>