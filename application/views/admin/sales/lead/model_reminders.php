
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
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
   .form-control{
   border: solid #ced4da 1px !important;
   }
   .datepickerInput {
   z-index: 9999 !important;
   }
   .end_date{
   display: none;
   }
</style>
<form method="post" action="<?= base_url(ADMIN.'sales/Lead/add_reminders')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Reminders</h4>
      <hr>
    
      <div class="row form-group col-md-12">
         <div class="col-md-6">
            <div class="custom-control custom-checkbox mr-sm-2 mb-3">
               <input type="checkbox" class="custom-control-input" id="reminder" name="reminder_for_multiple" value="1">
               <label class="custom-control-label" for="reminder" style="">Set Reminder For multiple!</label>
            </div>
         </div>
         <div class="col-md-6">
            <div class="custom-control custom-checkbox mr-sm-2 mb-3">
               <input type="checkbox" class="custom-control-input" id="all" name="is_display_to_all" value="1">
               <label class="custom-control-label" for="all" style="">Display To All</label>
            </div>
         </div>
      </div>
      <div class="form-group col-md-12">
         <label>Title</label>
         <div>
            <input  type="text" class="form-control " required  name="title" value="">
         </div>
      </div>
      <div class="form-group col-md-12 " id="myModalWithDatePicker">
         <label class="control-label">Start Date</label>
         <div class="input-group">
            <input class="form-control" type="datetime-local" value="" id="example-datetime-local-input" name="start_date_time">
         </div>
      </div>
      <div class="form-group col-md-12 end_date" id="myModalWithDatePicker">
         <label class="control-label">End Date</label>
         <div class="input-group">
            <input class="form-control" type="datetime-local" value="" id="example-datetime-local-input" name="end_date_time">
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/moment/moment.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script>
   $(document).ready(function () {
   
    $('#frm').validate({ 
         
         submitHandler: function(form) {
             form.submit();
         }
     });
   });
</script>
<script>
   /*******************************************/
   // Basic Date Range Picker
   /*******************************************/
   $('.daterange').daterangepicker();
   
   /*******************************************/
   // Date & Time
   /*******************************************/
   $('.datetime').daterangepicker({
       timePicker: true,
       timePickerIncrement: 30,
       locale: {
           format: 'MM/DD/YYYY h:mm A'
       }
   });
   
   /*******************************************/
   //Calendars are not linked
   /*******************************************/
   $('.timeseconds').daterangepicker({
       timePicker: true,
       timePickerIncrement: 30,
       timePicker24Hour: true,
       timePickerSeconds: true,
       locale: {
           format: 'MM-DD-YYYY h:mm:ss'
       }
   });
   
   /*******************************************/
   // Single Date Range Picker
   /*******************************************/
   $('.singledate').daterangepicker({
       singleDatePicker: true,
       showDropdowns: true
   });
   
   /*******************************************/
   // Auto Apply Date Range
   /*******************************************/
   $('.autoapply').daterangepicker({
       autoApply: true,
   });
   
   /*******************************************/
   // Calendars are not linked
   /*******************************************/
   $('.linkedCalendars').daterangepicker({
       linkedCalendars: false,
   });
   
   /*******************************************/
   // Date Limit
   /*******************************************/
   $('.dateLimit').daterangepicker({
       dateLimit: {
           days: 7
       },
   });
   
   /*******************************************/
   // Show Dropdowns
   /*******************************************/
   $('.showdropdowns').daterangepicker({
       showDropdowns: true,
   });
   
   /*******************************************/
   // Show Week Numbers
   /*******************************************/
   $('.showweeknumbers').daterangepicker({
       showWeekNumbers: true,
   });
   
   /*******************************************/
   // Date Ranges
   /*******************************************/
   $('.dateranges').daterangepicker({
       ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
       }
   });
   
   /*******************************************/
   // Always Show Calendar on Ranges
   /*******************************************/
   $('.shawCalRanges').daterangepicker({
       ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
       },
       alwaysShowCalendars: true,
   });
   
   /*******************************************/
   // Top of the form-control open alignment
   /*******************************************/
   $('.drops').daterangepicker({
       drops: "up" // up/down
   });
   
   /*******************************************/
   // Custom button options
   /*******************************************/
   $('.buttonClass').daterangepicker({
       drops: "up",
       buttonClasses: "btn",
       applyClass: "btn-info",
       cancelClass: "btn-danger"
   });
   
   /*******************************************/
   // Language
   /*******************************************/
   $('.localeRange').daterangepicker({
       ranges: {
           "Aujourd'hui": [moment(), moment()],
           'Hier': [moment().subtract('days', 1), moment().subtract('days', 1)],
           'Les 7 derniers jours': [moment().subtract('days', 6), moment()],
           'Les 30 derniers jours': [moment().subtract('days', 29), moment()],
           'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
           'le mois dernier': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
       },
       locale: {
           applyLabel: "Vers l'avant",
           cancelLabel: 'Annulation',
           startLabel: 'Date initiale',
           endLabel: 'Date limite',
           customRangeLabel: 'SÃ©lectionner une date',
           // daysOfWeek: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','Samedi'],
           daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
           monthNames: ['Janvier', 'fÃ©vrier', 'Mars', 'Avril', 'ÐœÐ°i', 'Juin', 'Juillet', 'AoÃ»t', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
           firstDay: 1
       }
   });
</script>
<script>
   // Date Picker
   jQuery('.mydatepicker, #datepicker').datepicker();
   jQuery('#datepicker-autoclose').datepicker({
       autoclose: true,
        container: '#myModalWithDatePicker',
       todayHighlight: true
   });
   
   
    $('.mydatepicker').datepicker({
   defaultDate: "today",
   
   });
   
   jQuery('#date-range').datepicker({
       toggleActive: true
   });
   jQuery('#datepicker-inline').datepicker({
       todayHighlight: true
   });
   // Daterange picker
   $('.input-daterange-datepicker').daterangepicker({
       buttonClasses: ['btn', 'btn-sm'],
       applyClass: 'btn-danger',
       cancelClass: 'btn-inverse'
   });
   $('.input-daterange-timepicker').daterangepicker({
       timePicker: true,
       format: 'MM/DD/YYYY h:mm A',
       timePickerIncrement: 30,
       timePicker12Hour: true,
       timePickerSeconds: false,
       buttonClasses: ['btn', 'btn-sm'],
       applyClass: 'btn-danger',
       cancelClass: 'btn-inverse'
   });
   $('.input-limit-datepicker').daterangepicker({
       format: 'MM/DD/YYYY',
       minDate: '06/01/2015',
       maxDate: '06/30/2015',
       buttonClasses: ['btn', 'btn-sm'],
       applyClass: 'btn-danger',
       cancelClass: 'btn-inverse',
       dateLimit: {
           days: 6
       }
   });
</script>
<script type="text/javascript">
   $(function () {
       $("#reminder").click(function () {
           // Check if the checkbox is checked
           if ($(this).is(":checked")) {
               $(".end_date").show(); // Show the element with the class "end_date"
           } else {
               $(".end_date").hide(); // Hide the element with the class "end_date"
           }
       });
   });
</script>
