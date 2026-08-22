<style>
.select2-selection__rendered{
 margin-top: 1px;
}
.margin-bottom-7{
 margin-bottom: 7px !important;
 }
.margin-bottom-20{
 margin-bottom: 20px !important;
 }
 label 
 {
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
table {
border-collapse: collapse;
}
td{
border: 1px solid black;
padding: 5px;
white-space: pre-wrap; /* or word-wrap: break-word; */
}
</style>
<form method="post" action="<?= base_url(ADMIN.'sales/TechnicalSpecification/add_technical_specification')?>" id="form" enctype="multipart/form-data">
      <div class="modal-body">
      <h4>Add Technical Specification</h4>
      <hr>
      
      <input type="hidden" name="id" id="id" value="<?= isset($Technical_s)? $Technical_s['id'] : '' ?>">
      
       <div class="form-group col-md-12">
         <label>Title</label>
         <div>
            <input  type="text" class="form-control " required  name="title" value="<?= isset($Technical_s)? $Technical_s['title'] : ''; ?>">
         </div>
      </div>
      
       <!--  <div class="form-group col-md-12">
         <label>Default Values</label>
         <div>
            <input  type="text" class="form-control " required  name="default_values" value="<?= isset($Technical_s)? $Technical_s['default_values'] : ''; ?>">
         </div>
      </div> -->

      <div class="form-group col-md-12">
         <label>Default Values</label>
         <textarea class="form-control" name="default_values" id="default_values"  placeholder="Enter your text here..." col="6" style="height:200px !important;"><?= isset($Technical_s)? $Technical_s['default_values'] : ''; ?></textarea>
      </div>
      </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
        <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
     </div>
  </form>

<script src="<?= base_url() ?>assets/node_modules/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/config.js"></script>
<script>
  $(document).ready(function () {
  $('#form').validate({ 
    submitHandler: function(form) {
    form.submit();
        }
    });
});
     CKEDITOR.replace('default_values',{
     height: '250px'   ,
     uiColor: '#f8f9fa',    
     
   });
</script>
<style>
     .error{
      color: red;
   }
</style>
