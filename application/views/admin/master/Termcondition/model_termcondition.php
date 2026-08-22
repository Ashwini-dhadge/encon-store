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
<form method="post" action="<?= base_url(ADMIN.'master/TermCondition/add_termcondition')?>" id="frm_validate" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Term Condition</h4>
      <hr>
      <input  type="hidden" class="form-control "   name="id" value="<?= isset($Termcondition)? $Termcondition['id'] : ''; ?>">
      <div class="form-group col-md-12">
         <label style="border-color:#ced4da;" class="">Title</label>
        <input  type="text" class="form-control "   name="title" value="<?= isset($Termcondition)? $Termcondition['title'] : ''; ?>">
      </div>
      <div class="form-group col-md-12">
         <label>Terms Conditions</label>
        
          <textarea class="form-control" id="exampleTextarea" rows="5" required placeholder="Terms Conditions" name="particulars" style="height: 100px;" ><?= isset($Termcondition)? $Termcondition['particulars'] : ''; ?></textarea>
      </div>
      <div class="form-group row">                                   
        <div class="col-md-6" style="padding-right: 2px;">
           <div class="form-check custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input form-check-input" id="is_default" name="is_default" value="1" <?= (isset($Termcondition['is_default']) && $Termcondition['is_default']==1)? 'checked' : ''; ?>>
              <label class="custom-control-label form-check-label" for="is_default">Is Display Default</label>
           </div>
        </div>
         
     </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-inverse btn-theme-sm" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn btn-success btn-theme" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>

<
