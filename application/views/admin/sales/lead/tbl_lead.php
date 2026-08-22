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
</style>
<div class="row">
<div class="col-md-5">
   <h4 class="card-title">Lead</h4>
</div>

 <div class="col-md-7 align-self-center text-right d-none d-md-block">
 
     <!--  <a href="<?= base_url('admin/UserAccess/add_user');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i> Create Site</a> -->
      <button type="button" class="btn btn-info btn-theme leadModal" data-toggle="modal" data-target="#leadModal .bd-example-modal-lg" ><i class="fa fa-plus-circle"></i>
      Create New Lead</button>
   </div>   
</div>
<div class="row no_margin_bottom">
 <div class="col-md-2">
                  <label>Assigned</label>
                  <select class="form-control custom-select select2 assigned_id" id="assigned_id" onchange="filter_lead()"  name="assigned" style="width:100%" >
                      <option value="all" selected>Select All</option>
                  </select>
               </div>
                <div class="col-md-2">
                  <label>Status</label>
                  <select class="form-control custom-select select2 status_id" id="status_id" onchange="filter_lead()" name="status_id" style="width:100%" >
                    <option value="all" selected>Select All</option>
                  
                  </select>
               </div>
                <div class="col-md-2">
                  <label>Source</label>
                  <select class="form-control custom-select select2 source_id" id="source_id" onchange="filter_lead()" name="source_id" style="width:100%" >
                    <option value="all" selected>Select All</option>
                  
                  </select>
             
            </div>


      
 </div>    
                          
<!-- <div class="row no_margin_bottom">
  
</div> -->



<div class="row no_margin_bottom">
  
</div>

<div class="table-responsive">
   <table id="lead" class="table display  no-wrap  table-bordered text-center" width="100%">
   </table>
</div>
 
<div id="leadModal" class="modal fade bd-example-modal-lg" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_banner"></div>
      </div>
   </div>
</div>
