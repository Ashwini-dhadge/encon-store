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
 <form method="post" action="<?= base_url(ADMIN.'master/CostProject/add_cost_project')?>" id="form" enctype="multipart/form-data">
        <div class="modal-body">
            <h4>Add Cost Project</h4>
            <hr>
            <input  type="hidden" class="form-control" name="id" value="<?= isset($costProject)? $costProject['id'] : ''; ?>">
            <div class="form-group col-md-12">
                <label style="border-color:#ced4da;" class="">Cost Project Name</label>
                <input type="text" class="form-control" required name="cost_project_name" value="<?= isset($costProject)? $costProject['cost_project_name'] : ''; ?>">
            </div>
            <div class="form-group col-md-12">
                <label>Description</label>
                <textarea class="form-control" id="exampleTextarea" rows="5" required placeholder="Description" name="description" style="height: 100px;"><?= isset($costProject)? $costProject['description'] : ''; ?></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-inverse btn-theme-sm" data-dismiss="modal">Close</button> 
            <button type="submit" class="btn btn-success btn-theme" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
        </div>
    </form>
   <script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
    <script>
        // jQuery validation setup
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
