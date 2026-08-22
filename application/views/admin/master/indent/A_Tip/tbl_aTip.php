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
   <h4 class="card-title">A.Tip Master</h4>
</div>

 <div class="col-md-7 align-self-center text-right d-none d-md-block">
 
     <!--  <a href="<?= base_url('admin/UserAccess/add_user');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i> Create Site</a> -->
  	  <button type="button" class="btn btn-info btn-theme aTipModal" data-toggle="modal" data-target="#aTipModal" ><i class="fa fa-plus-circle"></i>
             Create A.Tip
               </button>
   </div>   
</div>
<div class="row no_margin_bottom">

   


      
 </div>                             
<div class="table-responsive">
    <table id="aTip" class="table display table-responsive  no-wrap  table-bordered text-center" width="100%">
      
    </table>
</div>
<div id="aTipModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_banner2"></div>
      </div>
   </div>
</div>
