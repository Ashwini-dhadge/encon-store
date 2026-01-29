<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />

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

   .bootstrap-tagsinput{
      width: 100%;
   }

   .datepicker-orient-bottom{
     top: 60px !important;
     left: 20px !important; 
   
   }
   
   .label-info {
      background-color: #48bc97;
      font-size: 13px;
    }

    .select2-container .select2-selection--single {
      height: 28px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 28px !important;
    }
</style>

<form method="post" action="<?= base_url(ADMIN.'sales/OpportunityTracker/submmit_opportunity_tracker_data')?>" id="form_val" enctype="multipart/form-data">
    <div class="modal-body">
        <h4><?= $sub_title;?></h4><hr>
      
        <input type="hidden" name="id" id="id" value="<?= isset($opportunity_data['id'])? $opportunity_data['id'] : '' ?>">
        <input type="hidden" name="id_opp_track" id="id_opp_track" value="<?= isset($opportunity_data['opp_tracker_id'])? $opportunity_data['opp_tracker_id'] : '' ?>">
        <input type="hidden" name="type" id="type" value="<?= isset($type)? $type : '' ?>">

        <div class="form-group col-md-12" >
            
        </div>

        
        <div class="row" style="margin: 0px;">
            <div class="form-group col-md-6">
                <label><b>Customer Name</b></label>
                <?php if(empty($opportunity_data['customer_id'])){?>
                    <select class="form-control select2 did-floating-select customer_name"  id=""  name="customer_id" value=""  style="width: 100%;padding-top: 3px;">
                    </select>
                <?php }else{?>
                    <?php if($type == 1){?>
                        <input type="hidden" name="customer_id" value="<?= isset($opportunity_data['customer_id'])? $opportunity_data['customer_id'] : '' ?>">
                        <select class="form-control select2 did-floating-select customer_name" disabled name="customer_id" value=""  style="width: 100%;">
                            <?php
                                foreach ($customer_name as $key => $value) {
                                  if((isset($opportunity_data['customer_id']) && $opportunity_data['customer_id'] == $value['id'])){
                                    $selected="selected";
                                    }else{
                                    $selected="";
                                    } 
                                ?>
                                <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['company_name'] ?></option>
                            <?php } ?>
                        </select>
                    <?php }else if($type == 3){?>
                        <input type="hidden" name="customer_id" value="<?= isset($opportunity_data['customer_id'])? $opportunity_data['customer_id'] : '' ?>">
                        <select class="form-control select2 did-floating-select customer_name" disabled name="customer_id" value=""  style="width: 100%;">
                            <?php
                                foreach ($customer_name as $key => $value) {
                                  if((isset($opportunity_data['customer_id']) && $opportunity_data['customer_id'] == $value['id'])){
                                    $selected="selected";
                                    }else{
                                    $selected="";
                                    } 
                                ?>
                                <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['company_name'] ?></option>
                            <?php } ?>
                        </select>
                    <?php }else{ ?>
                        <select class="form-control select2 did-floating-select customer_name"  id=""  name="customer_id" value=""  style="width: 100%;">
                            <?php
                                foreach ($customer_name as $key => $value) {
                                  if((isset($opportunity_data['customer_id']) && $opportunity_data['customer_id'] == $value['id'])){
                                    $selected="selected";
                                    }else{
                                    $selected="";
                                    } 
                                ?>
                                <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['company_name'] ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?> 
                    
                <?php } ?>
            </div>

            <div class="form-group col-md-6">
                <label><b>Plant Name</b></label>
                <select class="form-control select2 did-floating-select plant_name"  id=""  name="plant_name_id" value=""  style="width: 100%;padding-top: 3px;">
                    <?php
                        foreach ($plant_name as $key => $value) {
                          if((isset($opportunity_data['plant_name_id']) && $opportunity_data['plant_name_id'] == $value['id'])){
                            $selected="selected";
                            }else{
                            $selected="";
                            } 
                        ?>
                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['plant_narration'] ?></option>
                   <?php } ?>        
                </select>
            </div>

            <div class="form-group col-md-6">
                <label><b>Title</b></label>
                <input type="text" class="form-control " required  name="title" value="<?= isset($opportunity_data['title'])? $opportunity_data['title'] : '' ?>">
            </div>
      
            <div class="form-group col-md-6">
                <label><b>Date</b></label>
                 <!-- <input type="text" class="form-control mydatepicker" name="dateq" id="" value="<?= isset($opportunity_data['date'])? $opportunity_data['date'] :date('m-d-Y');?>"> -->
                         <input type="datetime-local" class="form-control" name="date" value="<?= isset($opportunity_data['date'])? $opportunity_data['date'] :date('Y-m-d h:i');?>">

                        <!-- <div class="date" id="datePicker">
                             <input type="datetime-local" class="form-control" name="date" value="<//?= isset($opportunity_data['date'])? $opportunity_data['date'] :date('Y-m-d');?>">
                             <span class="input-group-addon">
                                  <i class="glyphicon glyphicon-calendar"></i>
                             </span>
                        </div> -->
                           

            </div>

            <div class="form-group col-md-6">
                <label><b>Contact Person Name</b></label>
                <input  type="text" class="form-control " required  name="contact_person_name" value="<?= isset($opportunity_data['contact_person_name'])? $opportunity_data['contact_person_name'] : '' ?>">
            </div>

            <div class="form-group col-md-6">
                <label><b>Contact Person Mobile No</b></label>
                <input  type="text" class="form-control number" required minlength="10" maxlength="10" name="contact_person_mobile_no" value="<?= isset($opportunity_data['contact_person_mobile_no'])? $opportunity_data['contact_person_mobile_no'] : '' ?>">
            </div>

                <div class="form-group col-md-12">
                    <label><b>New Email</b></label>
                    <div class="tags-default" >
                        <input type="email" class="form-control" value="<?= isset($opportunity_data['email_ids'])? $opportunity_data['email_ids'] : '' ?>" name="email_ids" id="new_email" data-role="tagsinput" placeholder="add tags" style="width:100%"> 
                    </div>
                </div>


            <div class="col-md-6" style="margin-bottom:5px ;">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="is_check" name="is_check_reminder"  <?= (isset($opportunity_data['is_check_reminder']) && $opportunity_data['is_check_reminder'] == 1)? 'checked': 0 ; ?> value="1">
                  <label class="custom-control-label" for="is_check"><b>Are you sure Do you want to add reminder!</b></label>
                </div>
            </div>

            
        </div>

        <div class="form-group col-md-12">
            <label><b>Description</b></label>
            <textarea class="form-control" name="description" id="description" placeholder="Enter your text here..." style="height:200px !important;"><?= (isset($opportunity_data['description']))?$opportunity_data['description']:''; ?></textarea>
        </div>

        <div class="col-md-12 bg-diffrent">
            <div class="form-group">
                <label class=""><b>Attach a file</b></label>
                <div class="col-md-12" style="padding:0px;">
                    <div class="file-upload-contain">
                    <?php if(isset($attachement)){ ?>
                        <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                        <?php foreach($attachement as $key1=>$val){?>
                            <div class="file-preview-frame file-sortable  kv-preview-thumb remove_file_attch_(<?= $val['id']?>)" id="remove_file_attch_<?= $val['id']?>" data-template="image">
                                <input type="hidden" class="form-control" id="remove_file_attch_id_<?= $val['id']?>" name="file_name_id[]" value="<?= $val['id']?>" multiple />
                                <div class="kv-file-content"></div>
                                <div class="file-thumbnail-footer">
                                    <div class="file-detail">
                                    <div class="file-caption-name" style="color: black;"><?= $val['file_name']?></div>
                                    </div>   
                                    <div class="file-actions">
                                       <div class="file-footer-buttons">
                                          <button type="button" onclick= "remove_file_attch(<?= $val['id']?>)" class="kv-file-remove file-remove" title="Remove file"><i class="fa fa-times"></i></button>
                                       </div>
                                    </div>
                                    <span class="file-drag-handle drag-handle-init text-primary" title="Move / Rearrange"><i class="bi-arrows-move"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="kv-zoom-cache"></div>
                            </div>
                        <?php } 
                    }else{?>
                        <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                    <?php } ?>

                </div>
             </div>
          </div>
       </div>

            <div class="div_reminder" <?= (isset($opportunity_data['is_check_reminder']) && $opportunity_data['is_check_reminder'] == 1)? 'style="display:block"':'style="display:none"'; ?> >
                <h5>Reminder</h5><hr>
                <!-- value="<?= isset($reminder['id'])? $reminder['id'] : ''; ?>" -->
                <!-- <input type="text" name="id_reminder" value="<?= isset($reminder['id'])? $reminder['id'] : ''; ?>"> -->
                <div class="col-md-12" >
                    <div class="row form-group col-md-12" style="padding:0px ;">
                        <div class="col-md-5">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="checkbox0" name="reminder_for_multiple" <?= (isset( $opportunity_data['reminder_for_multiple']) && $opportunity_data['reminder_for_multiple'] == 1)? 'checked':0; ?> value="1">
                              <label class="custom-control-label" for="checkbox0"><b>Set Reminder For multiple!</b></label>
                            </div>
                        </div>
                     
                    </div>
                    <div class="row col-md-12" style="padding:0px ;">
                        <div class="col-md-6" id="">
                            <label class="control-label"><b>Start Date</b></label>
                            <div class="">
                                <input class="form-control emty" type="datetime-local" value="<?= isset($reminder['start_date_time'])? $reminder['start_date_time'] : ''; ?>" id="start_date" name="start_date_time">
                            </div>
                        </div>
                        <div class="col-md-6 end_date" id="" <?= (isset( $opportunity_data['reminder_for_multiple']) && $opportunity_data['reminder_for_multiple'] == 1)? 'style="display: block;"': 'style="display: none;"'; ?> >
                            <label class="control-label"><b>End Date</b></label>
                            <div class="">
                                <input class="form-control emty emty_a" type="datetime-local" value="<?= isset($reminder)? $reminder['end_date_time'] : ''; ?>" id="example-datetime-local-input" name="end_date_time">
                            </div>
                        </div>
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
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">
   $(function () {
       $("#checkbox0").click(function () {
           // Check if the checkbox is checked
           if ($(this).is(":checked")) {
             
               $(".end_date").show(); 
           } else {
               $(".end_date").hide(); 
                $(".emty_a").val(""); 
           }
       });
   });

   $("#is_check").click(function () {
       // Check if the checkbox is checked
       if ($(this).is(":checked")) {
           $(".div_reminder").show(); 
           $("#start_date").attr("required", "true");
           $(".emty").val("");
       } else {
           $(".div_reminder").hide();
           $(".emty").val(""); 
       }
   });
</script>



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



// var today = new Date();

// var optComponent = {
//   format: 'yyyy-mm-dd',
//   container: '#datePicker',
//   orientation: 'bottom',
//   todayHighlight: true,
//   autoclose: true
// };

// // COMPONENT
// $( '#datePicker' ).datepicker( optComponent );
// $( '#datePicker' ).datepicker( 'setDate', today );



</script>




