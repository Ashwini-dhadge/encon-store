<link href="<?= base_url() ?>assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
<style>
   .error{
   color:red;
   }
   .sd{
   display: none;
   }
   .select2-selection__rendered{
   margin-top: 1px;
   }
   .margin-bottom-7{
   margin-bottom: 7px !important;
   }
   .margin-bottom-20{
   margin-bottom: 20px !important;
   }
   label {
   margin-bottom: 0.2rem;
   }
   #mapping{
   margin-left: 20px;
   }
   form label {
   font-weight: 628;
   }
   .select2-selection--multiple{
   border: solid #ced4da 1px !important;
   }
   textarea.form-control
   {
   height: 100px;
   line-height: 1.7 !important;
   }
   /*  .select2-container{
   margin-bottom: 7px !important;
   } */
   .select2-container
   {
   margin-bottom: -12px !important;
   }
   .upper_case
   {
   text-transform: uppercase;
   }
   .select2-selection{
   height: 28px !important;
   }
   .plus{
   padding: 1px 8px;
   /* color: #212529; */
   }
   .input-group, .did-floating-input
   {
   display: flex;
   border-radius: 0 4px 4px 0;
   border-left: 1%;
   padding-left: 0px;
   }
   .btn-success, .btn-success.disabled
   {
   background: #48bc97;
   border: 1px solid #48bc97;
   box-shadow: $success-shadow;
   transition: 0.2s ease-in;
   }
   .swal2-popup .swal2-input {
   height: 1.625em;
   padding: 0 .75em;
   }
</style>
<form method="post" action="<?= base_url(ADMIN.'sales/Lead/add_lead')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4><b>Add New Lead</b></h4>
      <hr>
      <input type="hidden" name="id" id="id" value="<?= isset($lead)? $lead['id'] : '' ?>">
       <div class="row">
         <div class="col-md-4 nopadding pt-3">
            <div class="form-group">

               <div class="input-group">
                  <label for="inputState">Lead Status</label>
                  <?php if(isset($lead['status_id'])){?>
                  <select class="form-control lead_status" id="lead_status" name="status_id" style="width: 100%;" required>
                     <?php
                        foreach ($status_data as $key => $value) {
                        if((isset($status_id)&&$status_id==$value['id'])){
                        $selected="selected";
                        }else{
                         $selected="";
                        } ?>
                     <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['status'] ?></option>
                     <?php } ?>
                  </select>
                <?php } else{?>
                  <select class="form-control lead_status" id="lead_status" name="status_id" style="width: 100%;" required>
                     <?php
                        foreach ($status_data as $key => $value) {
                        if((isset($status_id)&&$status_id==$value['id'])){
                        $selected="selected";
                        }else{
                         $selected="";
                        } ?>
                     <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['status'] ?></option>
                     <?php } ?>
                  </select>
                <?php }?>
                  <label id="lead_status-error" class="error sd" for="lead_status" style="padding-top: 10px;">This field is .</label>
               </div>

            </div>
         </div>
         <div class="col-md-4 nopadding pt-3">
            <div class="form-group">
               <div class="input-group">
                  <label for="inputState">Lead Source</label>
                  <select class="form-control select2 did-floating-select  source_name" id="source_name" name="lead_source_id" style="width: 80%;" required>
                     <?php
                        foreach ($source_data as $key => $value) {
                        if((isset($lead_source_id)&&$lead_source_id==$value['id'])){
                        $selected="selected";
                        }else{
                         $selected="";
                        } ?>
                     <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                     <?php } ?>
                  </select>
                  <div class="input-group-append">
                     <button class="btn btn-success plus " type="button" onclick="sourceData();"  ><i class="fa fa-plus"></i></button>
                  </div>
                  <label id="source_name-error" class="error sd" for="source_name">This field is .</label>
               </div>
            </div>
         </div>
         <div class="col-md-4 nopadding pt-3">
            <div class="form-group">
               <div class="input-group">
                  <label for="inputState">Assigned</label>
                  <select class="form-control assigned" id="assigned" name="assigned_id" style="width: 100%;">
                     <?php
                        foreach ($assigned_data as $key => $value) {
                        if((isset($assigned_id)&&$assigned_id==$value['id'])){
                        $selected="selected";
                        }else{
                         $selected="";
                        } ?>
                     <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['first_name'] ?></option>
                     <?php } ?>
                  </select>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <label>Name</label>
            <div>
               <input  type="text" class="form-control " name="name" required value="<?= isset($lead)? $lead['name'] : ''; ?>">
            </div>
         </div>
         <div class="col-md-6">
            <label>Address</label>
            <div>
               <input  type="text" class="form-control " name="address" value="<?= isset($lead)? $lead['address'] : ''; ?>">
            </div>
         </div>
         <div class="col-md-6 pt-3">
            <label>Position</label>
            <div>
               <input  type="text" class="form-control " name="position" value="<?= isset($lead)? $lead['position'] : ''; ?>">
            </div>
         </div>
         <div class="col-md-6 pt-3">
            <label>Email Address</label>
            <div>
               <input  type="email" class="form-control " name="email" value="<?= isset($lead)? $lead['email'] : ''; ?>">
            </div>
         </div>

      

          <div class="form-group col-md-6 pt-3">
            <label class="control-label">Country</label>
             <select class="form-control select2 did-floating-select country_name" required name="country_id" id="country_id" style="width: 100%" >
                 <?php
                  foreach ($country_data as $key => $value) {
                  if((isset($lead['country_id'])&&$lead['country_id']==$value['id'])){
                  $selected="selected";
                  }else{
                  $selected="";
                  } ?>
                  <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                  <?php } ?> 
            </select>
         </div>
        <div class="col-md-6 pt-3">
            <label>Location</label>
            <div>
               <input  type="text" class="form-control "   name="location" value="<?= isset($lead)? $lead['location'] : ''; ?>">
            </div>
         </div>

         <div class="col-md-6 pt-3">
            <label>Website</label>
            <div>
               <input  type="text" class="form-control "   name="website" value="<?= isset($lead)? $lead['website'] : ''; ?>">
            </div>
         </div>
         <div class="col-md-6 pt-3">
            <label>Phone</label>
            <div>
               <input  type="tel" class="form-control number"   name="phone" value="<?= isset($lead)? $lead['phone'] : ''; ?>"  required minlength="10" maxlength="10" >

            </div>
         </div>
         <div class="col-md-6 pt-3">
            <label>Zipcode</label>
            <div>
               <input  type="text" class="form-control number" required  name="zipcode" value="<?= isset($lead)? $lead['zipcode'] : ''; ?>">
            </div>
         </div>
         <div class="col-md-6 pt-3">
            <label>Company</label>
            <div>
               <input type="text" class="form-control "   name="company" value="<?= isset($lead)? $lead['company'] : ''; ?>">
            </div>
         </div>
        
         <div class="col-md-6 pt-3">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="7"><?= isset($lead)? $lead['description'] : ''; ?></textarea>
         </div>
         <div class="col-md-6 pt-3">
            <label>Comment</label>
            <textarea class="form-control" name="comment"><?= isset($lead)? $lead['comment'] : ''; ?></textarea>
         </div>
          <div class="col-md-6 pt-3">
            <label>Requirment</label>
            <div>
               <input type="text" class="form-control " required  name="requirement" value="<?= isset($lead)? $lead['requirement'] : ''; ?>">
            </div>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/sales/lead.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script><script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
</script>
<script>
   $(document).ready(function () {
   
    $('#form').validate({ 
         
         submitHandler: function(form) {
             form.submit();
         }
     });
   });
</script>
<style>
   .error{
   color: red;
   }
</style>
<script>
   $(function() {
       // Switchery
       var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
       $('.js-switch').each(function() {
           new Switchery($(this)[0], $(this).data());
       });
      
      
       $(".vertical-spin").TouchSpin({
           verticalbuttons: true
       });
       var vspinTrue = $(".vertical-spin").TouchSpin({
           verticalbuttons: true
       });
       if (vspinTrue) {
           $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
       }
       $("input[name='tch1']").TouchSpin({
           min: 0,
           max: 100,
           step: 0.1,
           decimals: 2,
           boostat: 5,
           maxboostedstep: 10,
          
       });
       $("input[name='tch2']").TouchSpin({
           min: -1000000000,
           max: 1000000000,
           stepinterval: 50,
           maxboostedstep: 10000000,
           prefix: '$'
       });
       $("input[name='tch3']").TouchSpin();
       $("input[name='tch3_22']").TouchSpin({
           initval: 40
       });
      
     
       $(".ajax").select2({
           ajax: {
               url: "https://api.github.com/search/repositories",
               dataType: 'json',
               delay: 250,
               data: function(params) {
                   return {
                       q: params.term, // search term
                       page: params.page
                   };
               },
               processResults: function(data, params) {
                  
                   params.page = params.page || 1;
                   return {
                       results: data.items,
                       pagination: {
                           more: (params.page * 30) < data.total_count
                       }
                   };
               },
               cache: true
           },
           escapeMarkup: function(markup) {
               return markup;
           }, // let our custom formatter work
           minimumInputLength: 1,
           //templateResult: formatRepo, // omitted for brevity, see the source of this page
           //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
       });
   });
   

   $(".number").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }else{
        return true;
    }
   });

</script>
<script>
   function sourceData() {
       Swal.fire({
           title: '<label for="name" class="control-label"> Add Source</label>',
           html: '<input type="text" class="swal2-input" id="name" name="name" placeholder="Source Name" style="color:black;">',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes!'
       }).then((result) => {
         // console.log(result);
           if (result.value) {
               var name = $('#name').val();
               $.ajax({
                   type: 'POST',
                   url: '<?= base_url("admin/sales/Lead/sourceData") ?>',
                   data: { name: name },
                   dataType: 'json',
                   success: function(response) {
                       // Handle success response
                       Swal.fire({
                           title: 'Success!',
                           text: 'Data added successfully!',
                           icon: 'success'
                       }).then(() => {
                           // Close the SweetAlert window
                           Swal.close();
                       });
                   },
                   error: function(xhr, status, error) {
                       // Handle error response
                       Swal.fire({
                           title: 'Error!',
                           text: 'Failed to add data!',
                           icon: 'error'
                       });
                       console.error(xhr.responseText);
                   }
               });
           }
       });
   }
</script>
