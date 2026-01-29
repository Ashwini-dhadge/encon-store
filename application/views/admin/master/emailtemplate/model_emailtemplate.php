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
<form method="post" action="<?= base_url(ADMIN.'master/EmailTemplate/add_emailtemplate')?>" id="frm_validate" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Email Template</h4>
      <hr>
        <input type="hidden" name="id" id="id" value="<?= isset($emailtemplate)? $emailtemplate['id'] : '' ?>">
    
      <div class="form-group col-md-12">
         <label>Messages</label>
        
          <textarea class="form-control" id="exampleTextarea" rows="5" required placeholder="Message" name="message" style="height: 100px;" ><?= isset($emailtemplate)? $emailtemplate['message'] : ''; ?></textarea>
      </div>
    
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-inverse btn-theme-sm" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn btn-success btn-theme" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>


