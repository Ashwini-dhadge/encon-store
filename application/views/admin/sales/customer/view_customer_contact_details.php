
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
  
      
    .select2-selection--multiple{
        border: solid #ced4da 1px !important;
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
    .p1{
        width: 20%;
        font-weight: bolder;
    }

    .p2{
        width: 30%;
    }
  
</style>
    <div class="modal-header">
        <h4 class="modal-title"><?= $sub_title;?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="4">
                        <span class="text-color">
                            <h6><b>Customer Contact Details </b></h6>
                           
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            Contact Person Name
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($customer_contact_details[0]['contact_person_name']))? $customer_contact_details[0]['contact_person_name'] : '' ?>
                        </span></b>
                    </td>

                    <td class="p1">
                        <b><span class="text-color">
                            Contact Number
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($customer_contact_details[0]['contact_mobile_no']))? $customer_contact_details[0]['contact_mobile_no'] : '' ?>
                        </span></b>
                    </td>


                </tr>

                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            Designation
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($customer_contact_details[0]['designation']))? $customer_contact_details[0]['designation'] : '' ?>
                        </span></b>
                    </td>

                   

                </tr>
                
            </tbody>
        </table>


       


       


            




