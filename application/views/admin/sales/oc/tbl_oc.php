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
      <h4 class="card-title">OC List</h4>
   </div>
   
   <!-- <div class="col-md-7 align-self-center text-right d-none d-md-block">
       <a href="<?//= base_url('admin/sales/Quotation/add_quotation');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>Create Quotation</a>
    
   </div> -->
</div>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="row">
        <div class="col-md-3"></div>
        select dropdown start
        <div class="col-md-2">
            <label>Customer Name</label>
            <select class="form-control select2 did-floating-select quotationCustomer"  id="quotationCustomer"   name="cust_id" value="" onchange="filter_listQuotationData()">
                <option value="all" selected>All</option>
            </select>
        </div>


        <div class="col-md-2">
            <label>Status</label>
            <select class="form-control select2 did-floating-select quotationStatus"  id="quotationStatus"   name="quotationStatus" value="" onchange="filter_listQuotationData()">
                <option value="all">All</option>
                <option value="<?//= QUOTATION_STATUS_PENDING ?>">Pending</option>
                <option value="<?//= QUOTATION_STATUS_APPROVED ?>">Approved</option>
            </select>
        </div>

        end 
        <div class="col-md-3 text-right"></div>

        </div>
    </div>    
</div> -->


<div class="table-responsive">
    <table id="ocListTbl" class="table display table-responsive  no-wrap  table-bordered text-center" width="100%">

    </table>
</div>


