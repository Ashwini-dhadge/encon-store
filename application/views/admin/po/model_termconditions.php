<style>
   label.error{
      display: none !important;
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

</style>

<form method="post" action="<?= base_url(ADMIN.'master/Site/add_site')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Site</h4>

      <hr>
        <input type="hidden" name="id" id="id" value="<?= isset($site)? $site['id'] : '' ?>">
      <div class=" form-group col-md-12" >
         <label class="form-group" style="margin-bottom: 8px !important;">Company Name</label>
         <?php if(empty($site['company_id'])){?>
         <select class="form-control select2 did-floating-select company_name" required id="companynm"  name="company_id" value=""  style="width: 100%;padding-top: 3px;">
         </select>
         <?php }else{?>
         <select class="form-control select2 did-floating-select company_name" required id="companynm"  name="company_id" value=""  style="width: 100%;">
            <option value=""></option>
            <?php
               foreach ($company_name as $key => $value) {
                 if((isset($site['company_name'])&&$site['company_name']==$value['name'])){
                  $selected="selected";
                   }else{
                   $selected="";
                 } ?>
            <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
            <?php } ?>
         </select>
         <?php }?>
      </div>
     
       <div class="form-group col-md-12">
         <label>Site Name</label>
         <div>
            <input  type="text" class="form-control " required  name="site_name" value="<?= isset($site)? $site['site_name'] : ''; ?>">
         </div>
      </div>
  
      <div class="form-group col-md-12">
         <label >Site Address</label>
         <div>
            <input  type="text" class="form-control " required  name="site_address" value="<?= isset($site)? $site['site_address'] : ''; ?>">
         </div>
      </div>

          

            	 
      
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>

<script>

  $("#companynm").select2({

  ajax: {
    url: base_url +'admin/master/Site/listCompanyName',
    dataType: 'json',
    delay: 250,
    data: function (data) {
            return {
                  searchTerm: data.term,
               };
            },
        processResults: function (response) {
        return {
            results:response
          };
        },
        cache: true
      }
    });

</script>
