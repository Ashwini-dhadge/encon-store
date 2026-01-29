
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

<!---->
    <form method="post" action="<?= base_url(ADMIN.'ImportExportData/all_master_item')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Site</h4>

      <hr>
      
       <div class="form-group col-md-12">
         <label>Item Import</label>
         <div>
            <input  type="file" class="form-control " required  name="file" value="">
         </div>
      </div>
  
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>


   <form method="post" action="<?= base_url(ADMIN.'ImportExportData/all_vendor_import')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Vendor</h4>

      <hr>
      
       <div class="form-group col-md-12">
         <label>Vendor Import</label>
         <div>
            <input  type="file" class="form-control " required  name="file" value="">
         </div>
      </div>
  
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>