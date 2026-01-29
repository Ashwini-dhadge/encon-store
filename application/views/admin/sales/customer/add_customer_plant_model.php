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

   .select2-selection--single{
       height:28px !important;
   }
   
   .label-info {
      background-color: #48bc97;
      font-size: 13px;
    }
    .sel_error{
        display: none;
    }
</style>

<form method="post" id="cust_plant_modal" class="cust_plant" enctype="multipart/form-data">
    <div class="modal-body">
        <h4><?= $sub_title;?></h4><hr>
      
        <input type="hidden" name="id" id="id" value="<?= isset($id)? $id : '' ?>">
       
        <input type="hidden" name="customer_id" value="<?= isset($customer_id)? $customer_id:''?>">
     
        <div class="row" style="margin: 0px;">
            <div class="col-md-12 mb-3">
                <div class="row">
                   <div class="col-md-12">
                      <span class="text-color"><h6><b>Plant info</b></h6></span><hr> 
                   </div>
                 
                   <div class="form-group col-md-4 ">
                     <label class="">Plant Narration</label>
                     <input class="form-control " type="text" name="plant_narration" required value="<?= (isset($plant_narration))? $plant_narration : '' ?>" >
                      
                   </div>

                   <div class="form-group col-md-4 ">
                      <label class="">Plant Address</label>
                      <input class="form-control " type="text" name="plant_address" required value="<?= (isset($plant_address))? $plant_address : '' ?>" >
                   </div>

                </div>
                <hr>
            </div>
            <div class="col-md-12 mb-3">
                <div class="row">
                   <div class="col-md-12">
                      <span class="text-color"><h6><b>Billing Address</b></h6></span><hr> 
                   </div>
                 
                   <div class="form-group col-md-4 ">
                     <label class="">Billing Company</label>
                     <input class="form-control " type="text" name="billing_company" value="<?= (isset($billing_company))? $billing_company : '' ?>" >
                      
                   </div>

                   <div class="form-group col-md-4 ">
                      <label class="">Street</label>
                      <input class="form-control " type="text" name="b_street" value="<?= (isset($b_street))? $b_street : '' ?>" >
                   </div>

                   <div class="form-group col-md-4">
                    <label class="">Post Code</label>
                   <input class="form-control " type="text" name="b_post_code" value="<?= (isset($b_post_code))? $b_post_code : '' ?>" >
                   </div>


                   <div class="form-group col-md-4">
                     <label class="control-label">City</label>
                         <select class="form-control select2 did-floating-select b_city_name" id="getcity" name="b_city_id"  style="width: 100%;" >
                            <?php
                               foreach ($b_city_data as $key => $value) {
                                 if((isset($b_city_id['name'])&&$b_city_id['name']==$value['id'])){
                                  $selected="selected";
                                   }else{
                                   $selected="";
                                 } ?>
                            <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                            <?php } ?> 
                         </select>
                         <label id="b_city_id-error" class="error sel_error" for="b_city_id">This field is required.</label>
                   </div>
                  

                    <div class="form-group col-md-4">
                    <label class="control-label">State</label>
                         <select class="form-control select2 did-floating-select b_state_name" name="b_state_id" style="width: 100%;" >
                            <?php
                               foreach ($b_state_data as $key => $value) {
                                 if((isset($b_state_id['name'])&&$b_state_id['name']==$value['id'])){
                                  $selected="selected";
                                   }else{
                                   $selected="";
                                 } ?>
                            <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                            <?php } ?> 
                         </select>
                         <label id="b_state_id-error" class="error sel_error" for="b_state_id">This field is required.</label>
                      </div>

                      <div class="form-group col-md-4">
                     <label class="control-label">Country</label>
                     <select class="form-control select2 did-floating-select country_name b_country_name" name="b_country_id" style="width: 100%;" >
                       <?php
                           foreach ($b_country_data as $key => $value) {
                             if((isset($b_country_id['name'])&&$b_country_id['name']==$value['id'])){
                              $selected="selected";
                               }else{
                               $selected="";
                             } ?>
                        <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                        <?php } ?> 
      
                     </select>
                     <label id="b_country_id-error" class="error sel_error" for="b_country_id">This field is required.</label>
                   </div>
                    

                  

                </div>
                <hr>
            </div>


            <div class="col-md-12 mb-3">
            <div class="row">
               <div class="col-md-12">
                  <span class="text-color"><h6><b>Shipping Address</b></h6></span><hr> 
               </div>

               <div class="form-group col-lg-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="same_as_billing" name="same_as_billing" value="1">
                        <label class="form-check-label" for="same_as_billing">Same as Billing</label>
                    </div>
               </div>
             
                <div class="form-group col-md-4 ">
                  <label class="">Street</label>
                  <input class="form-control " type="text" name="s_street" value="<?= (isset($s_street))? $s_street : '' ?>" >
               </div>

                <div class="form-group col-md-4">
                <label class="">Post Code</label>
               <input class="form-control " type="text" name="s_post_code" value="<?= (isset($s_post_code))? $s_post_code : '' ?>" >
               </div>


            <div class="form-group col-md-4">
                <label class="control-label">City</label>
                <input type="hidden" name="s_city" id="s_city" />

                <select class="form-control select2 did-floating-select s_city_name" name="s_city_id" style="width: 100%;">
                    <?php
                        if(isset($s_city_id)) {
                        foreach ($s_city_data as $key => $value) {
                            if((isset($s_state_id['id'])&&$s_state_id['id']==$value['id'])){
                            $selected="selected";
                            }else{
                            $selected="";
                            } ?>
                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                    <?php }} ?> 
                </select>
                <label id="s_city_id-error" class="error sel_error" for="s_city_id">This field is required.</label>
            </div>

            <div class="form-group col-md-4">
            <label class="control-label">State</label>
                <select class="form-control select2 did-floating-select s_state_name"  name="s_state_id" style="width: 100%;">
                    <?php
                        if(isset($s_state_id)) {
                        foreach ($s_state_data as $key => $value) {
                            if((isset($s_state_id['id'])&&$s_state_id['id']==$value['id'])){
                            $selected="selected";
                            }else{
                            $selected="";
                            } ?>
                    <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                    <?php }} ?> 
                </select>
                <label id="s_state_id-error" class="error sel_error" for="s_state_id">This field is required.</label>
            </div>

            
            <div class="form-group col-md-4">
                <label class="control-label">Country</label>
                <select class="form-control select2 did-floating-select s_country_name" name="s_country_id" style="width: 100%;">
                <?php
                    if(isset($s_country_id)) {
                    foreach ($s_country_data as $key => $value) {
                        if((isset($s_country_id['id'])&&$s_country_id['id']==$value['id'])){
                        $selected="selected";
                        }else{
                        $selected="";
                        } ?>
                <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                <?php }} ?> 
                </select>
                <label id="b_country_id-error" class="error sel_error" for="s_country_id">This field is required.</label>
            </div>

                
                

               
            </div>
            <hr>
          </div>
        </div>
    </div>


    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
        <input type="submit" class="btn   waves-effect waves-light" id="submit_cust_plant_modal" style="background-color: #48bc97;color:white;" value="Add">
    </div>

</form>


<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>

<!-- <script src="<?= base_url(); ?>/assets/js/page-js/sales/customer.js"></script> -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>



<script>
$(document).ready(function() {

    // $('#same_as_billing').change(function() {
    //     if(this.checked) {
    //         var b_street = $('input[name="b_street"]').val();
    //         var b_post_code = $('input[name="b_post_code"]').val();
    //         var b_country_id = $('select[name="b_country_id"]').val();
    //         var b_state_id = $('select[name="b_state_id"]').val();
    //         var b_city_id = $('select[name="b_city_id"]').val();

    //         //alert(b_country_id);

    //         $('input[name="s_street"]').val(b_street).attr('readonly',true);;
    //         $('input[name="s_post_code"]').val(b_post_code).attr('readonly',true);
            
    //         $('select[name="s_country_id"]').val(b_country_id).trigger('change').attr('readonly',true);
    //         $('select[name="s_state_id"]').val(b_state_id).trigger('change').attr('readonly',true);
    //         $('select[name="s_city_id"]').val(b_city_id).trigger('change').attr('readonly',true);
    //     }else{
    //         $('input[name="s_street"]').val('').attr('readonly',false);
    //         $('input[name="s_post_code"]').val('').attr('readonly',false);

    //         $('select[name="s_country_id"]').val('').trigger('change').attr('readonly',false);
    //         $('select[name="s_state_id"]').val('').trigger('change').attr('readonly',false);;
    //         $('select[name="s_city_id"]').val('').trigger('change').attr('readonly',false);;
    //     }
    // });

    $('#same_as_billing').change(function() {
    if(this.checked) {
        var b_street = $('input[name="b_street"]').val();
        var b_post_code = $('input[name="b_post_code"]').val();
        var b_country_id = $('select[name="b_country_id"]').val();
        var b_state_id = $('select[name="b_state_id"]').val();
        var b_city_id = $('select[name="b_city_id"]').val();
        var b_city_name = $('select[name="b_city_id"] option:selected').text();

        //alert(b_city_name);

        $('input[name="s_street"]').val(b_street);
        $('input[name="s_post_code"]').val(b_post_code);

        $('select[name="s_city_id"]').select2({
                placeholder: b_city_name,
                
            }).trigger('change');
        
        $('#s_city').val(b_city_id).trigger('change');
        $('select[name="s_country_id"]').attr('readonly', true);
        $('select[name="s_state_id"]').attr('readonly', true);
        $('select[name="s_city_id"]').attr('readonly', true);
    } else {
        $('input[name="s_street"]').val('').attr('readonly', false);
        $('input[name="s_post_code"]').val('').attr('readonly', false);
        $('select[name="s_country_id"]').val('').trigger('change.select2');
        $('select[name="s_state_id"]').val('').trigger('change');
        $('input[name="s_city"]').val('').attr('readonly', false);
        $('select[name="s_city_id"]').select2();
        getSCityData();
    }
});




 
    $('#submit_cust_plant_modal').click(function(e) {
        e.preventDefault(); 

        if ($('#cust_plant_modal').valid()) {
          
            var formData = $('#cust_plant_modal').serialize();
            
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/sales/Customer/submit_customer_plant_data',
                data: formData,
                dataType:'json',

                success: function(response) {
                     console.log(response.result);
                    if (response.result == true) {

                     alert_float('success',response.reason);
                     $('#customer_plant_form').modal('hide');  
                      $('#tbl_customer_plant').DataTable().ajax.reload();
                    }else{
                      alert_float('error',response.reason);
                      $('#customer_plant_form').modal('hide');  
                      $('#tbl_customer_plant').DataTable().ajax.reload();
                    }

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response
                    $('#response').html('Error occurred. Please try again.'); // Display error message
                }
            });
        }
    });
});



   $(".number").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }else{
        return true;
    }
   });


   $('.b_country_name').change(function() {
        // Check if a value is selected
        if ($(this).val() !== '') {
            // Hide the error message
            $('#b_country_id-error').hide();
        }
    });
   $('.b_state_name').change(function() {
        // Check if a value is selected
        if ($(this).val() !== '') {
            // Hide the error message
            $('#b_state_id-error').hide();
        }
    });
   $('.b_city_name').change(function() {
        // Check if a value is selected
        if ($(this).val() !== '') {
            // Hide the error message
            $('#b_city_id-error').hide();
        }
    });
  $('.s_country_name').change(function() {
        // Check if a value is selected
        if ($(this).val() !== '') {
            // Hide the error message
            $('#s_country_id-error').hide();
        }
    });
   $('.s_state_name').change(function() {
        // Check if a value is selected
        if ($(this).val() !== '') {
            // Hide the error message
            $('#s_state_id-error').hide();
        }
    });
   $('.s_city_name').change(function() {
        // Check if a value is selected
        if ($(this).val() !== '') {
            // Hide the error message
            $('#s_city_id-error').hide();
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




