<?php  init_header(); ?>
<!-- <link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet"> -->
<style>._status{cursor: pointer;}
  
  .no_margin_bottom{
   margin-bottom: 0rem !important;
   }
   .dataTables_filter{
       margin-top:0px !important;
   }
   
   .dataTables_length{
       margin-top:0px !important;
   }
   table.dataTable>thead>tr>td:not(.sorting_disabled) {
    padding-right: 4px;
   }
    label{
       margin-bottom: 0.2rem;
    }
    b{
      font-size: 12px;
    }
   table td { 
    word-wrap: break-word;
   }
   thead
 
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
            <h5><strong><?= $sub_title;?></strong></h5><hr>
            <div class="row">
                <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control custom-select select2" id="inventory_item_id_a" onchange="inventory_filter_a()"  name="inventory_item_id" style="width:100%" >
                     <?php
                         foreach ($item_name as $key => $value) {
                           if((isset($inventory['item_id'])&&$inventory['item_id']==$value['id'])){
                            $selected="selected";
                             }else{
                             $selected="";
                           } ?>
                        <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['short_name'] ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Company Name</label>
                  <select class="form-control custom-select select2" id="companyid_a" onchange="inventory_filter_a()"  name="company_name_id" style="width:100%" >
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
                  <select class="form-control custom-select select2" id="site_id_a" onchange="inventory_filter_a()" name="site_name_id" style="width:100%" >

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
                  <label>Batch No</label>
               
                  <select class="form-control custom-select select2" id="batch_no_a" onchange="inventory_filter_a()" name="batch_no" style="width:100%" >

                     <?php
                         foreach ($batch_name as $key => $value) {
                           if(($inventory['batch_no']==$value['batch_no'])){
                            $selected="selected";
                             }else{
                             $selected="";
                           } ?>
                        <option value="<?= $value['batch_no'] ?>"  <?= $selected; ?>><?= $value['batch_no'] ?></option>
                     <?php } ?>
                  
                  </select>
               </div>

               <div class="col-md-1">
                  <label>Unit Name</label>`
                  <select class="form-control custom-select select2" id="item_unit_id" onchange="inventory_filter_a()" name="item_unit_id" style="width:100%" >

                     <?php
                         foreach ($unit_name as $key => $value) {
                           if((isset($inventory['item_unit_id'])&&$inventory['type_unit_id']==$value['unit_id'])){
                            $selected="selected";
                             }else{
                             $selected="";
                           } ?>
                        <option value="<?= $value['unit_id'] ?>"  <?= $selected; ?>><?= $value['unit_short_name'] ?></option>
                     <?php } ?>
                  
                  </select>
               </div>
                <div class="col-md-2">
                           <label>Reserve Stock</label>`
                           <select class="form-control custom-select select2 is_reserve_stock" id="is_reserve_stock" onchange="inventory_filter_a()" name="is_reserve_stock" style="width:100%" >
                           <option value="">All</option>
                           <option value="<?= RESERVE ?>">Reserved</option>
                           <option value="<?= NOT_RESERVE ?>">Not Reserved</option>
                           </select>
                </div>
               </div>
               <div class="row">
               <div class="col-md-2 col-xs-2 m-t-20" >
                  <button class="btn btn-theme" id="reset_filter">Reset Filter</button>
               </div>

               <!-- <div class="col-md-3 col-xs-2 text-center">
               </div> -->
             
               <div class="col-md-3 col-xs-2 m-t-20">
                     <center><b style=""><h5><strong>Total Quantity</strong></h5></b>
                     <p class="" style="margin-bottom: 10px;"><strong><h6><span class="" id="final_amount"></span></h6></strong></p>
                     </center> 
              
               </div>
                <div class="col-md-3 col-xs-2  m-t-20">
                   <center><b style=""><h5><strong>Total Reserve Stock</strong></h5></b>
                   <p class="" style="margin-bottom: 10px;"><strong><h6><span class="" id="reserve_stock_count"></span></h6></strong></p>
                   </center> 
                </div>
            </div>
            
               <div class="col-md-12 mb-2" style="padding:0px;margin-top: 20px;">

                  <div class="">
                     <div class="col-md-12" style="padding:0px;margin-top: 10px;">
                        <span class="text-color"><h6><strong>Invetory Details</strong></h6></span><hr> 
                     </div>


                     <div class="table-responsive">
                        
                        <input type="hidden" name="inv_item_unit_id" id="inv_item_unit_id" value="<?= isset($inventory['item_unit_id'])?$inventory['item_unit_id']:'';?>">
                        <table id="inventory_details_information" class="table display table-bordered text-center" width="100%">
                           <thead>
                                 <td>Sr.No</td>
                                 <td>Description</td>
                                 <td>Item Name</td>
                                 <td>Unit Name</td>
                               <td>Batch No</td>
                                <td>Expired Date</td> 
                                 <td>Company Name</td>
                                 <td>Site Name</td>
                                 <!--  <td>Batch No</td>
                                <td>Expired Date</td>  -->
                                 <td>Type</td>
                                 <td>Inward Quantity</td>
                                 <td>Outward Quantity</td>
                                 <td>Date</td>
                                 <td>Time</td>
                                 <td>Financial Year</td>

                           </thead>
                        </table>

                        
                     </div>
  
                  </div>
               </div>

                     

         
         </div>
      </div>
   </div>
</div>

<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/inventory.js"></script>

