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
   <h4 class="card-title">Site Master</h4>
</div>

 <div class="col-md-7 align-self-center text-right d-none d-md-block">
 
     <!--  <a href="<?= base_url('admin/UserAccess/add_user');?>" class="btn btn-info btn-theme"><i class="fa fa-plus-circle"></i> Create Site</a> -->
  	  <button type="button" class="btn btn-info btn-theme siteModal" data-toggle="modal" data-target="#siteModal" ><i class="fa fa-plus-circle"></i>
             Create Site
               </button>
   </div>   
</div>
<div class="row no_margin_bottom">

     <!--  <div class="form-group col-md-3 did-floating-label-content did-error-input no_margin_bottom">
          <div>
             <select class="form-control select2 did-floating-select"  id="role_id"   name="role_id" value="" onchange="filter_user()">
                  <option value=""></option>
                   <?php
                  foreach ($user_roles as $key => $value) {
                ?>
                  <option value="<?= $value['id'] ?>"  <?= (isset($role_id) && $role_id ==$value['id'])? 'selected': '';?>><?= $value['role_name'] ?></option>
                  <?php } ?>

             </select>
             <label style="margin-top: 2px;border-color:#ced4da;" class="did-floating-label">Role Name</label>
             <label id="role_id-error" class="error" for="role_id"></label>
          </div>
      </div> -->


      
 </div>                             
<div class="table-responsive">
    <table id="site" class="table display table-responsive  no-wrap  table-bordered text-center" width="100%">
      
    </table>
</div>
<div id="siteModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_banner"></div>
      </div>
   </div>
</div>
