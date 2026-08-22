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

<form method="post" id="cust_details_modal" class="cust_plant" enctype="multipart/form-data">
    <div class="modal-body">
        <h4><?= $sub_title;?></h4><hr>
        
        <input type="hidden" name="id" id="id" value="<?= isset($customer_contact_details[0]['id'])? $customer_contact_details[0]['id'] : '' ?>">
        
        <input type="hidden" name="customer_id" id="customer_id" value="<?= isset($customer_id)? $customer_id:''?>">
        
        <div class="row" style="margin: 0px;">
            <div class="col-md-12 mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-color"><h6><b>Customer Contact Details</b></h6></span><hr> 
                    
                    </div>
                    
                    <div class="form-group col-md-4 ">
                        <label class="">Contact Name</label>
                        <input class="form-control " type="text" name="contact_person_name" id="contact_person_name" required value="<?= (isset($customer_contact_details[0]['contact_person_name']))? $customer_contact_details[0]['contact_person_name'] : '' ?>" >
                        
                    </div>

                    <div class="form-group col-md-4 ">
                        <label class="">Contact Number</label>
                        <input class="form-control " type="text" name="contact_mobile_no" id="contact_mobile_no" required value="<?= (isset($customer_contact_details[0]['contact_mobile_no']))? $customer_contact_details[0]['contact_mobile_no'] : '' ?>" >
                    </div>

                    <div class="form-group col-md-4 ">
                        <label class="">Designation</label>
                        <input class="form-control " type="text" name="designation" id="designation" required value="<?= (isset($customer_contact_details[0]['designation']))? $customer_contact_details[0]['designation'] : '' ?>" >
                    </div>

                </div>
                <hr>
            </div>

            </div>
            
            </div>
        </div>
    </div>


    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
        <input type="submit" class="btn waves-effect waves-light" id="submit_customer_details_modal" style="background-color: #48bc97;color:white;" value="Add">
    </div>

</form>


<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>

<!-- <script src="<?= base_url(); ?>/assets/js/page-js/sales/customer.js"></script> -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>



<script>
$(document).ready(function() {





 
    $('#submit_customer_details_modal').click(function(e) {
        e.preventDefault(); 

        if ($('#cust_details_modal').valid()) {
            var formData = $('#cust_details_modal').serialize();
            ;
            //console.log(formData);
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/sales/Customer/submit_customer_contact_details_data',
                data: formData,
                dataType:'json',

                success: function(response) {
                     console.log(response.result);
                    if (response.result == true) {

                     alert_float('success',response.reason);
                     $('#customer_contact_form').modal('hide');  
                      $('#tbl_customer_contact_details').DataTable().ajax.reload();
                    }else{
                      alert_float('error',response.reason);
                      $('#customer_contact_form').modal('hide');  
                      $('#tbl_customer_contact_details').DataTable().ajax.reload();
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





</script>




