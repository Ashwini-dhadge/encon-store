<style>
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
   .btn1 {
   padding: 1px 17px 4px 18px;
   }
   .input-group-text {
   display: flex;
   align-items: center;
   font-weight: 400;
   height: 34px;
   color: #323840;
   padding: 0 5px 0 20px;
   font-size: 12px;
   text-align: center;
   white-space: nowrap;
   border: #6c757d;
}
.pl-4, .px-4 {
    padding-left: 10.5rem!important;
}
.card {
    margin-bottom: 10px;
}

</style>
<div class="row">
   <div class="col-md-5">
      <h4 class="card-title">Quotation</h4>
   </div>
   <div class="col-md-7 align-self-center text-right d-none d-md-block">
       <a href="<?= base_url('admin/sales/Quotation/add_quotation');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Create Quotation</a>
    
   </div>
</div>
<!-- <div class="row no_margin_bottom">
  
</div> -->

<div class="table-responsive">
   <table id="customer" class="table display table-responsive  no-wrap  table-bordered text-center" width="100%">

   </table>
</div>
 	<!-- <a href="<?= base_url('admin/Customer/add_customer');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>View</a> -->
<div id="siteModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_banner"></div>
      </div>
   </div>
</div>


