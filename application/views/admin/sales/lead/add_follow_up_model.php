<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<style>
   /* label.error{
   display: none !important;
   }*/
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
   .select2-selection--multiple{
   border: solid #ced4da 1px !important;
   }
   .file-drop-zone-title {
   padding: 15px 10px !important;
   }
   .file-preview-image{
   width: auto !important;
   height: 40px !important;
   }
   .file-no-browse,.fileinput-cancel-button{
   display: none;
   }
   .kv-file-content{
   display: none !important;
   }
   .datepicker-orient-bottom{
   top: 60px !important;
   left: 20px !important; 
   }
</style>
<form method="post" action="<?= base_url(ADMIN.'sales/Lead/submit_follow_up_data')?>" id="form_val" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Follow Up</h4>
      <hr>
      <input type="hidden" name="id" id="id" value="<?= isset($follow_up[0]['id'])? $follow_up[0]['id'] : '' ?>">
      <input type="hidden" name="lead_id" id="lead_id" value="<?= isset($lead_id)? $lead_id : '' ?>">
      <div class="row" style="margin: 0px;">
         <div class="form-group col-md-6">
            <label><b>Title</b></label>
            <input  type="text" class="form-control " required  name="title" value="<?= isset($follow_up[0]['title'])? $follow_up[0]['title'] : '' ?>">
         </div>
         <div class="form-group col-md-6">
            <label><b>Date</b></label>
            
            <input type="datetime-local" class="form-control" name="date" value="<?= isset($follow_up[0]['date'])? $follow_up[0]['date'] : date('Y-m-d h:i');?>">
         </div>
         <div class="form-group col-md-6">
            <label><b>Contact Person Name</b></label>
            <input  type="text" class="form-control " required  name="contact_person_name" value="<?= isset($follow_up[0]['contact_person_name'])? $follow_up[0]['contact_person_name'] : '' ?>">
         </div>
         <div class="form-group col-md-6">
            <label><b>Contact Person Mobile No</b></label>
            <input  type="text" class="form-control number" required minlength="10" maxlength="10" name="contact_person_mobile_no" value="<?= isset($follow_up[0]['contact_person_mobile_no'])? $follow_up[0]['contact_person_mobile_no'] : '' ?>">
         </div>
      </div>
     
      <div class="form-group col-md-12">
         <label><b>Description</b></label>
         <textarea class="form-control" name="description" id="description" placeholder="Enter your text here..." style="height:200px !important;"><?= isset($follow_up[0]['description'])? $follow_up[0]['description'] : '' ?></textarea>
      </div>
       <div class="custom-control custom-checkbox mr-sm-2 mb-3  col-md-12" style="padding-left: 2.5rem;">
         <input type="checkbox" class="custom-control-input" id="lead_add_reminder" name="lead_add_reminder"  <?= (isset( $follow_up[0]['lead_add_reminder']) && $follow_up[0]['lead_add_reminder'] == 1)? 'checked': ''; ?>  value="1">
         <label class="custom-control-label" for="lead_add_reminder"><b>If You Want To Set Reminder!</b></label>
      </div>
      <?php
         $reminderDisplayStyle = !empty($reminder) ? '' : 'style="display:none;"';
         ?>
      <div class="reminder" <?= $reminderDisplayStyle ?>>
         <h4>Add Reminder</h4>
         <hr>
 
    <input type="hidden" name="follow_up_id" id="follow_up_id" value="<?= isset($reminder['follow_up_id']) ? $reminder['follow_up_id'] : '' ?>"> 
         <div class="row form-group col-md-6">
           <!--  <div class="col-md-6">
               <div class="custom-control custom-checkbox mr-sm-2 mb-1">
                  <input type="checkbox" class="custom-control-input" id="checkbox0" name="reminder_for_multiple" <?= (isset($reminder['reminder_for_multiple']) && $reminder['reminder_for_multiple'] == 1) ? 'checked' : '' ?> value="1">
                  <label class="custom-control-label" for="checkbox0">Set Reminder For multiple!</label>
               </div>
            </div> -->
            <div class="col-md-6">
               <div class="custom-control custom-checkbox mr-sm-2 mb-1">
                  <input type="checkbox" class="custom-control-input" id="all" name="is_display_to_all" <?= (isset($reminder['is_display_to_all']) && $reminder['is_display_to_all'] == 1) ? 'checked' : '' ?> value="1">
                  <label class="custom-control-label" for="all" style="">Display To All</label>
               </div>
            </div>
         </div>
         <div class="row" style="margin: 0px;">
            <div class="form-group col-md-6">
               <label><b>Title</b></label>
               <input type="text" class="form-control" required name="title_reminder" value="<?= isset($reminder['title_reminder']) ? $reminder['title_reminder'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               <label><b>Start Date</b></label> 
               <input class="form-control" type="datetime-local" value="<?= isset($reminder['start_date_time'])? $reminder['start_date_time'] :date('Y-m-d h:i');?>" id="example-datetime-local-input" name="start_date_time">
            </div>

            <div class="form-group col-md-6 " >
               <label><b>End Date</b></label>
               <input class="form-control" type="datetime-local" value="<?= isset($reminder['end_date_time'])? $reminder['end_date_time'] : ''; ?>" id="example-datetime-local-input" name="end_date_time">
            </div>

             


         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?= base_url(); ?>/assets/node_modules/moment/moment.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?= base_url(); ?>/assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/config.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/sales/opportunity_tracker.js"></script>
<script>
   $(document).ready(function () {
   
       $('#form_val').validate();
   
   
       CKEDITOR.replace( 'description',{
           height: '200px'   ,
           uiColor: '#f8f9fa',    
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
<script type="text/javascript">
   $(document).ready(function (){
      
       var lead_add_reminder = $('#lead_add_reminder').prop("checked");
       if (lead_add_reminder) {
           $(".reminder").show(); 
       } else {
           $(".reminder").hide(); 
       }
       
      
       $("#lead_add_reminder").click(function () {
          
           if ($(this).is(":checked")) {
               $(".reminder").show(); 
           } else {
               $(".reminder").hide(); 
           }
       });
   });
</script>
