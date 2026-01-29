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
   <h4 class="card-title">Indent</h4>
</div>

 <div class="col-md-7 align-self-center text-right d-none d-md-block">
 
      <a href="<?= base_url('admin/indent/Indent/add_indent');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i>&nbsp;Create New Indent</a>
  	 <!--  <button type="button" class="btn btn-info btn-theme siteModal" data-toggle="modal" data-target="#siteModal" ><i class="fa fa-plus-circle"></i>
             Create New Indent
               </button> -->
   </div>   
</div>
                            
<div class="table-responsive">
    <table id="indent" class="table display table-responsive   table-bordered text-center" width="100%">
      
    </table>
</div>
<!-- <div id="siteModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_banner"></div>
      </div>
   </div>
</div> -->
