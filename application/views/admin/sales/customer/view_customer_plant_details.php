
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
                            <h6><b>Plant Details</b></h6>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            Plant Narration
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['plant_narration']))? $cust_plant_data['plant_narration'] : '' ?>
                        </span></b>
                    </td>

                    <td class="p1">
                        <b><span class="text-color">
                            Plant Address
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['plant_address']))? $cust_plant_data['plant_address'] : '' ?>
                        </span></b>
                    </td>


                </tr>
                
            </tbody>
        </table>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="4">
                        <span class="text-color">
                            <h6><b>Billing Details</b></h6>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            Billing Company 
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['billing_company']))? $cust_plant_data['billing_company'] : '' ?>
                        </span></b>
                    </td>

                    <td class="p1">
                        <b><span class="text-color">
                            Street
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['b_street']))? $cust_plant_data['b_street'] : '' ?>
                        </span></b>
                    </td>
                </tr>

                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                           Post Code
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['b_post_code']))? $cust_plant_data['b_post_code'] : '' ?>
                        </span></b>
                    </td>

                    <td class="p1">
                        <b><span class="text-color">
                            Country
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($b_country_data[0]['name']))? $b_country_data[0]['name'] : '' ?>
                        </span></b>
                    </td>
                </tr>

                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                           State
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($b_state_data[0]['name']))? $b_state_data[0]['name'] : '' ?>
                        </span></b>
                    </td>

                    <td class="p1">
                        <b><span class="text-color">
                            City
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($b_city_data[0]['name']))? $b_city_data[0]['name'] : '' ?>
                        </span></b>
                    </td>
                </tr>

                
            </tbody>
        </table>


         <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="4">
                        <span class="text-color">
                            <h6><b>Shipping Details</b></h6>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            Street
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['s_street']))? $cust_plant_data['s_street'] : '' ?>
                        </span></b>
                    </td>

                    <td class="p1">
                        <b><span class="text-color">
                           Post Code
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($cust_plant_data['s_post_code']))? $cust_plant_data['s_post_code'] : '' ?>
                        </span></b>
                    </td>
                </tr>

                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            Country
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($s_country_data[0]['name']))? $s_country_data[0]['name'] : '' ?>
                        </span></b>
                    </td>
                    <td class="p1">
                        <b><span class="text-color">
                           State
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($s_state_data[0]['name']))? $s_state_data[0]['name'] : '' ?>
                        </span></b>
                    </td>
                </tr>

                <tr>
                    <td class="p1">
                        <b><span class="text-color">
                            City
                        </span></b>
                    </td>
                    <td class="p2">
                        <b><span class="text-color">
                            <?= (isset($s_city_data[0]['name']))? $s_city_data[0]['name'] : '' ?>
                        </span></b>
                    </td>
                </tr>

                
            </tbody>
        </table>


            




