<style>
   .select2-selection {
      height: 37px !important;

   }

   .no_margin_bottom {
      margin-bottom: 0rem !important;
   }

   .dataTables_filter {
      margin-top: 0px !important;
   }

   .dataTables_length {
      margin-top: 0px !important;
   }
</style>
<div class="row">
   <div class="col-md-5">
      <h4 class="card-title"><?= $title ?></h4>
   </div>

   <div class="col-md-7 align-self-center text-right d-none d-md-block">

      <button type="button" class="btn btn-info btn-theme clampModal" data-toggle="modal" data-target="#clampModal"><i class="fa fa-plus-circle"></i>
         Create Clamp Material
      </button>
   </div>
</div>
<div class="row no_margin_bottom">





</div>
<div class="table-responsive">
   <table id="clamp_material" class="table display table-responsive  no-wrap  table-bordered text-center" width="100%">

   </table>
</div>
<div id="clampModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_banner2"></div>
      </div>
   </div>
</div>