$('.po_item_cal').on('keydown', function(evt) {
  if (evt.key === 'Tab' || evt.key === 'Enter') {
    evt.preventDefault();
    // alert("sd")
  // calculatePOItem(this)
  }
});
$('.po_item_cal').on('blur', function(evt) {
    var element = evt.target;
    //calculatePOItem(element);
});
$('.po_item_cal_final').on('blur', function(evt) {
    // calculateTotal()
});


$('.po_item_cal_final').on('keydown', function(evt) {
  //if (evt.key === 'Tab' || evt.key === 'Enter') {
//    evt.preventDefault();
    // alert("sd")
//   calculateTotal()
  //}
});

function calculatePOItemEvent(evt,element) {
    if (evt.key === 'Tab' || evt.key === 'Enter') {
    evt.preventDefault();
    // alert("sd")
//   calculatePOItem(element)
  }
}

function add_value(element,type) {
        // alert(element)
        // Get the selected option
        var selectedOption = $(element).find(":selected");

        // Access the data attribute
        var tax_rate = selectedOption.data("tax_rate");
        // // console.log(tax_rate)
        var name = element.name;  
        
        var match = name.match(/\[([^\]]+)\]/);

        var row_index = match ? match[1] : null;
        //// console.log("row_index="+row_index)
        //// console.log(row_index)
        // Display the data attribute value
        //// console.log("Selected Option Price: " + tax_rate);
        if(type==2){
                $('input[name="items['+row_index+'][additional_tax_rate]"]').val(tax_rate)
        }else{
                $('input[name="items['+row_index+'][tax_rate]"]').val(tax_rate)
        }
        calculatePOItem(element);
      
    
     
}

function calculateGstValue(element) {
        
        var name = element.name;         
        var match = name.match(/\[([^\]]+)\]/);

}

function getItemList(items){
     var name = items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
   // console.log("row_index="+row_index)
    $('select[name="items['+row_index+'][items_id]"]').empty();
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
    if(!isEmpty(items.value) || (items.value =='all')){
     $.ajax({
              url: base_url + 'admin/PO/getItemData',
              type: "post",  
              data: {'item_group_id':items.value},            
              dataType: 'json',
              success: function(response) {
                //// console.log(response.data)
                  if(response.result){
                     selectElement.select2({
                        data: response.data,
                        minimumInputLength: 0,
                        matcher: function(params, data) {

                            if ($.trim(params.term) === '') {
                                return data;
                            }


                            if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1 ||
                                data.item_code.toString().indexOf(params.term) > -1) {
                                return data;
                            }

                            // If the search term doesn't match the item code or text, return null to exclude the option
                            return null;
                        }
                    });
                   
                      var defaultValues = ["", ""];
                    selectElement.val(defaultValues).trigger('change.select2');
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
    }else{
        var defaultValues = ["", ""];
         selectElement.val(defaultValues).trigger('change.select2');
    }
}
function getItemUnits(items) {
     var name = items.name;
   
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');

    var selectedText = $(selectElement).find("option:selected").text();
    //// console.log(selectedText);
     $('input[name="items['+row_index+'][order_item]"]').val(selectedText)

     $.ajax({
              url: base_url + 'admin/PO/getItemUnitsData',
              type: "post",  
              data: {'item_id':items.value},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                  
                   $('input[name="items['+row_index+'][item_hsc_code]"]').val( response.data_item.hsn_code)
                   $('input[name="items['+row_index+'][item_unit_rate]"]').val( response.data_item.rate)
                    
                        var po_total_pending_qty_unit = $('select[name="items['+row_index+'][po_total_pending_qty_unit]"]');
                        var po_challan_qty_unit = $('select[name="items['+row_index+'][po_challan_qty_unit]"]');
                        var po_received_qty_unit = $('select[name="items['+row_index+'][po_received_qty_unit]"]');
                        var po_rejected_qty_unit = $('select[name="items['+row_index+'][po_rejected_qty_unit]"]');
                        var received_unit = $('select[name="items['+row_index+'][received_unit]"]');
                        var weight_unit = $('select[name="items['+row_index+'][weight_unit]"]');
                        var length_unit = $('select[name="items['+row_index+'][length_unit]"]');
                        var return_qty_unit = $('select[name="items['+row_index+'][return_qty_unit]"]');
                        var item_unit_id = $('select[name="items['+row_index+'][item_unit_id]"]');
                            item_unit_id.empty();
                            po_total_pending_qty_unit.empty();
                            po_challan_qty_unit.empty();
                            po_received_qty_unit.empty();
                            po_rejected_qty_unit.empty();
                            received_unit.empty();
                            weight_unit.empty();
                            length_unit.empty();
                            return_qty_unit.empty();
                            // Append new options to the <select> element
                            $.each( response.data, function (index, option) {
                                
                              
                                item_unit_id.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                                        
                               
                                po_total_pending_qty_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                                
                              
                                 po_challan_qty_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                                
                               
                                  po_received_qty_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));

                               
                                   po_rejected_qty_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                               
                                    received_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                                
                                     weight_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                                
                                      length_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));
                               
                                       return_qty_unit.append($('<option>', {
                                            value: option.item_unit_id,
                                            text: option.short_name
                                        }));

                                    //   return_qty_unit
                            });



                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
      // calculatePOItem(items);
}
function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}

function getCopytoReceviedQty(element){
        var name = element.name;         
        var match = name.match(/\[([^\]]+)\]/);
        var row_index = match ? match[1] : null;
        let is_grn_update=$("#is_grn_update").val();
        let po_id=$("#po_id").val();
        
        var po_old_received_qty = $('input[name="items['+row_index+'][old_received_qty]"]').val();
        
        if(is_grn_update==1 && !isEmpty(po_id) && !isEmpty(po_old_received_qty)){
            var po_received_qty = parseInt($('input[name="items['+row_index+'][po_received_qty]"]').val());
            var po_main_received_qty = parseInt($('input[name="items['+row_index+'][po_main_received_qty]"]').val());
            var po_total_pending_qty = parseInt($('input[name="items['+row_index+'][po_main_pending_qty]"]').val());
            var po_main_total_qty = parseInt($('input[name="items['+row_index+'][po_main_total_qty]"]').val());
            
            let new_excess_qty=new_qty=new_qty1=0;
            // if(po_main_received_qty > po_main_total_qty){
            //     new_excess_qty=po_main_received_qty-po_main_total_qty;
            // }
            new_qty=po_received_qty-po_old_received_qty
           // console.log("new_qty"+new_qty);
            received_qty= po_main_received_qty+new_qty;
           // console.log("po_main_received_qty"+po_main_received_qty)
           // console.log("new_qty"+new_qty)
            // console.log("new_qty"+received_qty)
            //minus from main qty
            new_qty=po_main_total_qty-received_qty;
            if(received_qty >= po_main_total_qty){
                new_excess_qty=received_qty-po_main_total_qty;
                new_pending_qty=0;
            }else{
                 new_excess_qty=0;
                new_pending_qty=po_main_total_qty-received_qty;
            }
            
            $('input[name="items['+row_index+'][po_excess_qty]"]').val(new_excess_qty);
            $('input[name="items['+row_index+'][po_total_pending_qty]"]').val(new_pending_qty);
            $('input[name="items['+row_index+'][received_qty]"]').val(po_received_qty);
               
        }else{
            var po_received_qty = $('input[name="items['+row_index+'][po_received_qty]"]').val();
            var po_total_pending_qty = $('input[name="items['+row_index+'][po_save_pending_qty]"]').val();
            if(parseInt(po_received_qty) && parseInt(po_total_pending_qty)){
               let po_excess_qty=parseInt(po_received_qty)-parseInt(po_total_pending_qty);
               //// console.log(po_excess_qty);
               if(po_excess_qty >= 1){
                    $('input[name="items['+row_index+'][po_excess_qty]"]').val(po_excess_qty);
               }else{
                     $('input[name="items['+row_index+'][po_excess_qty]"]').val(0);
               }
            }else{
                     $('input[name="items['+row_index+'][po_excess_qty]"]').val(0);
            }
            
             if(parseInt(po_received_qty) && parseInt(po_total_pending_qty)){
               let po_pendng_qty=parseInt(po_total_pending_qty)-parseInt(po_received_qty);
               //// console.log(po_pendng_qty)
               if(po_pendng_qty <= 0){
                    $('input[name="items['+row_index+'][po_total_pending_qty]"]').val(0);
               }else{
                     $('input[name="items['+row_index+'][po_total_pending_qty]"]').val(po_pendng_qty);
               }
        }
        
            $('input[name="items['+row_index+'][received_qty]"]').val(po_received_qty);
           
        }
       
        //// console.log(po_received_qty)
}
function showRejectReasons(element) {
        var name = element.name;         
        var match = name.match(/\[([^\]]+)\]/);
         var row_index = match ? match[1] : null;
        var po_rejected_qty = $('input[name="items['+row_index+'][po_rejected_qty]"]').val();
        if(parseInt(po_rejected_qty)>=1){
                $('select[name="items['+row_index+'][reject_reasons]"]').show();
                 $('input[name="items['+row_index+'][return_qty]"]').val(po_rejected_qty);
                
        }else{
                $('select[name="items['+row_index+'][reject_reasons]"]').hide();
        }
}
function calculatePOItem(element,type=0) {
    if(type==1){
        // var name = element;       
        // var match = name.match(/\[([^\]]+)\]/);    
        var row_index = element;
    }else{
        getCopytoReceviedQty(element)

        var name = element.name;       
        var match = name.match(/\[([^\]]+)\]/);    
        var row_index = match ? match[1] : null;
    }
   
   
  
    let item_weight= parseFloat($('input[name="items['+row_index+'][item_weight]"]').val());
    let item_qty= parseFloat($('input[name="items['+row_index+'][received_qty]"]').val());
    let item_unit_rate= parseFloat($('input[name="items['+row_index+'][item_unit_rate]"]').val());
    let item_rate_type= parseInt($('select[name="items['+row_index+'][item_unit_type]"]').val());
    let discount_type= parseInt($('select[name="items['+row_index+'][discount_type]"]').val());
    let discount_percent= parseFloat($('input[name="items['+row_index+'][discount_percent]"]').val());
    let tax_rate= parseInt($('input[name="items['+row_index+'][tax_rate]"]').val());
    let tax_id= parseInt($('select[name="items['+row_index+'][tax_id]"]').val());
    let tax_type= parseInt($('select[name="items['+row_index+'][gst_type]"]').val());
   
    let additional_tax_rate= parseInt($('input[name="items['+row_index+'][additional_tax_rate]"]').val());
    let additional_tax_id= parseInt($('select[name="items['+row_index+'][additional_tax_id]"]').val());

    let other_charges_type= parseInt($('select[name="items['+row_index+'][other_charges_type]"]').val());
    let item_other_percent= parseFloat($('input[name="items['+row_index+'][item_other_percent]"]').val());
 
    //item_rate_type 1-stock qty and 2 weight

    //other_charges_type 1:@val 2:qty

    //discount_type 1:@val 2:qty

    //tax_type= 1:value 2:qty 3:weight
   
    //// console.log("item_unit_rate"+item_unit_rate)
    if(!isEmpty(item_unit_rate) && !isEmpty(item_rate_type) && ( !isEmpty(item_weight) || !isEmpty(item_qty) ) &&  !isEmpty(row_index)){

        if((item_rate_type==2 && !isEmpty(item_weight) && !isEmpty(item_unit_rate)) || (item_rate_type==1 && !isEmpty(item_qty) && !isEmpty(item_unit_rate))){
                if(item_rate_type==2){
                    item_rate=parseFloat(item_weight*item_unit_rate).toFixed(2);
                }else{
                    item_rate=parseFloat(item_qty*item_unit_rate).toFixed(2);
                }
                 
                $('input[name="items['+row_index+'][item_total]"]').val(item_rate);

                let discount_amount=item_sub_amount=0;
                //discount_type 1:value 2:qty
                if(discount_type==1 && !isEmpty(discount_percent)){
                     discount_amount=(item_rate*(discount_percent/100)).toFixed(2);
                }else if(discount_type==2 && !isEmpty(discount_percent)){
                     discount_amount=(discount_percent*item_qty).toFixed(2);
                }

                $('input[name="items['+row_index+'][discount_value]"]').val(discount_amount);
               
                let other_amount=other_sub_amount=0;
                //discount_type 1:value 2:qty
             
                if(other_charges_type==1 && !isEmpty(item_other_percent)){
                     other_amount=(item_rate*(item_other_percent/100)).toFixed(2);
                }else if(other_charges_type==2 && !isEmpty(item_other_percent)){
                     other_amount=(item_other_percent*item_qty).toFixed(2);
                    
                }
                   
                $('input[name="items['+row_index+'][item_other_charges_amt]"]').val(other_amount);



                item_sub_amount=parseFloat(item_rate)+parseFloat(other_amount)-parseFloat(discount_amount).toFixed(2);
                
                $('input[name="items['+row_index+'][item_final_amount]"]').val(item_sub_amount);

                //calcuate tax rate
                
                if(!isEmpty(tax_rate) && tax_rate!=0 &&  !isEmpty(tax_id) && (!isEmpty(item_sub_amount) || !isEmpty(item_qty) || !isEmpty(item_weight))){
                //// console.log("gst_type"+tax_type)
                   if(tax_type==2){
                        tax_amount=parseFloat(item_qty*tax_rate).toFixed(2);
                   }else if(tax_type==3){
                        tax_amount=parseFloat(item_weight*tax_rate).toFixed(2);
                   }else{
                        tax_amount=parseFloat(item_sub_amount*(tax_rate/100)).toFixed(2);
                   }
                    
                    $('input[name="items['+row_index+'][tax_value]"]').val(tax_amount);
                }


                if(!isEmpty(additional_tax_rate) && additional_tax_rate !=0 &&  !isEmpty(additional_tax_id) && !isEmpty(item_sub_amount)){
                    additional_tax_value=parseFloat(item_sub_amount*(additional_tax_rate/100)).toFixed(2);
                    $('input[name="items['+row_index+'][additional_gst_amount]"]').val(additional_tax_value);
                }

                calculateTotal();
                

        }else{
            if(item_rate_type==2){
                alert("Plese add Item Weight");
            }else{
                alert("Plese add Item Qty/Unit");
            }
        } 
    }   
    
   

   
}
function calculateTotal(){
    let total_pending_qty1=total_received_qty1=total_return_qty=total_other_charges=total_tax_rate=total_additional_tax_rate=final_amount_total=0;
    let total_rate=total_discount_amount=0;

     $(".po_items_select").each(function() {
            
           // console.log($(this))
            element_name=$(this)[0].name;            
            var match = element_name.match(/\[([^\]]+)\]/);
            var x = match ? match[1] : null;
             var style=$(this).closest('.main_tbl_reapter').attr("style");

                if(style!="display: none;"){
            
            
            let item_unit =parseFloat($('input[name="items['+x+'][item_unit]"]').val()).toFixed(2);
            let item_rate =parseFloat($('input[name="items['+x+'][item_total]"]').val()).toFixed(2);
            let discount_amount =parseFloat($('input[name="items['+x+'][discount_value]"]').val()).toFixed(2);
            let total_pending_qty =parseFloat($('input[name="items['+x+'][po_total_pending_qty]"]').val()).toFixed(2);
            let total_received_qty =parseFloat($('input[name="items['+x+'][received_qty]"]').val()).toFixed(2);
            let return_qty =parseFloat($('input[name="items['+x+'][return_qty]"]').val()).toFixed(2);
            let item_other_charges_amt =parseFloat($('input[name="items['+x+'][item_other_charges_amt]"]').val()).toFixed(2);   
                  
                if(total_pending_qty !== "" && !isNaN(total_pending_qty) && !isEmpty(total_pending_qty) && !isEmpty(total_received_qty) &&  (total_received_qty !=0)){
                    total_pending_qty1=parseFloat(total_pending_qty1)+parseFloat(total_pending_qty);
                }
                // // console.log(total_pending_qty1+total_pending_qty1)
                // console.log("total_received_qty1qw"+total_received_qty1);
                if(total_received_qty !== "" && !isNaN(total_received_qty) && !isEmpty(total_received_qty) ){
                    total_received_qty1=parseFloat(total_received_qty1)+parseFloat(total_received_qty);
                }
                // console.log("total_received_qty1"+total_received_qty1);

                if(return_qty !== "" && !isNaN(return_qty) && !isEmpty(return_qty) ){
                    total_return_qty=parseFloat(total_return_qty)+parseFloat(return_qty);
                }

                
                if(item_rate !== "" && !isNaN(item_rate) && !isEmpty(item_rate) ){
                    total_rate=parseFloat(total_rate)+parseFloat(item_rate);
                }
                if(discount_amount !== "" && !isNaN(discount_amount) && !isEmpty(discount_amount) ){
                    total_discount_amount=parseFloat(total_discount_amount)+parseFloat(discount_amount);
                }

                if(item_other_charges_amt !== "" && !isNaN(item_other_charges_amt) && !isEmpty(item_other_charges_amt) ){
                    total_other_charges=parseFloat(total_other_charges)+parseFloat(item_other_charges_amt);
                }




                let tax_value =parseFloat($('input[name="items['+x+'][tax_value]"]').val()).toFixed(2);
                        if(tax_value !== "" && !isNaN(tax_value) && !isEmpty(tax_value) ){
                            total_tax_rate=parseFloat(total_tax_rate)+parseFloat(tax_value);
                            total_tax_rate=parseFloat(total_tax_rate).toFixed(2);
                            
                        }
                let additional_tax_value =parseFloat($('input[name="items['+x+'][additional_tax_value]"]').val()).toFixed(2);
                        if(additional_tax_value !== "" && !isNaN(additional_tax_value) && !isEmpty(additional_tax_value) ){
                            total_additional_tax_rate=parseFloat(total_additional_tax_rate)+parseFloat(additional_tax_value);
                        }

                let item_final_amount =parseFloat($('input[name="items['+x+'][item_final_amount]"]').val()).toFixed(2);
                        if(item_final_amount !== "" && !isNaN(item_final_amount) && !isEmpty(item_final_amount) ){
                            final_amount_total=parseFloat(final_amount_total)+parseFloat(item_final_amount);
                            final_amount_total=parseFloat(final_amount_total).toFixed(2);
                        }
                }
                
    
    });
      //// console.log(total_qty)
     $('#total_pending_qty').val(total_pending_qty1);
     $('#total_received_qty').val(total_received_qty1);
     $('#total_return_qty').val(total_return_qty);
     $('#total_item_amount').val(total_rate);
     $('#total_other_charges').val(total_other_charges);
     $('#total_discount').val(total_discount_amount);

     $('#total_gst').val(total_tax_rate);
     $('#total_additional_gst').val(total_additional_tax_rate);
     $('#total_sub_amount').val(final_amount_total);
   

    //console.log(final_discount_percent)
    let final_discount_percent= parseFloat($('#final_discount_percent').val());
    let final_discount_amount=0;
  
    // if(!isEmpty(final_discount_percent) && final_discount_percent!=0 &&  !isEmpty(final_amount_total) && !isEmpty(final_discount_percent)){
    //         final_discount_amount=parseFloat(final_amount_total*(final_discount_percent/100)).toFixed(2);       
    // }
    $('#final_discount_amount').val(total_discount_amount);
    $('#final_gst').val(total_tax_rate);

    let ld_charges= parseFloat($('#ld_charges').val());

    let freight_amount= parseFloat($('#freight_amount').val());
    let freight_tax_rate= parseFloat($('#freight_tax_rate').val());
    let freight_tax_id= parseInt($('#freight_tax_id').val());
    let freight_additional_tax_rate= parseFloat($('#freight_additional_tax_rate').val());
    let freight_additional_tax_id= parseInt($('#freight_additional_tax_id').val());
    let freight_tax_amount=freight_additional_tax_amount=0;

    if(!isEmpty(freight_amount) && freight_amount!=0 &&  !isEmpty(freight_tax_rate) && !isEmpty(freight_tax_id)){
            freight_tax_amount=parseFloat(freight_amount*(freight_tax_rate/100)).toFixed(2);       
    }
     $('#freight_tax_amount').val(freight_tax_amount);

     if(!isEmpty(freight_amount) && freight_amount!=0 &&  !isEmpty(freight_additional_tax_rate) && !isEmpty(freight_additional_tax_id)){
            freight_additional_tax_amount=parseFloat(freight_amount*(freight_additional_tax_rate/100)).toFixed(2);       
    }
     $('#freight_additional_tax_amount').val(freight_additional_tax_amount);


     //
    let n_tax_amount= parseFloat($('#n_tax_amount').val());
    let new_tax_rate= parseFloat($('#new_tax_rate').val());
    let new_tax_id= parseInt($('#new_tax_id').val());
    let new_tax_amount=0;

    if(!isEmpty(n_tax_amount) && n_tax_amount!=0 &&  !isEmpty(new_tax_rate) && !isEmpty(new_tax_id)){
            new_tax_amount=parseFloat(n_tax_amount*(new_tax_rate/100)).toFixed(2);       
    }
     $('#new_tax_amount').val(new_tax_amount);


     //service tax caluation 
    var service_charge_type = document.querySelector('input[name="service_charge_type"]:checked');
    var service_charge_type_val = service_charge_type.value;

    //service_charge_type 1: on service 2:on item
    let service_charge_amount= parseFloat($('#service_charge_amount').val());
    let service_tax_rate= parseFloat($('#service_tax_rate').val());
  
    let service_tax_amount=0;
    //// console.log("service_charge_type="+service_charge_type_val);
    if(service_charge_type_val==1){
        //// console.log("service_charge_type="+service_charge_type_val);
         if(!isEmpty(service_charge_amount) && service_charge_amount!=0 &&  !isEmpty(service_tax_rate) && !isEmpty(service_tax_rate)){
            service_tax_amount=parseFloat(service_charge_amount*(service_tax_rate/100)).toFixed(2);       
        }

    }else if(service_charge_type_val==2){
        if(!isEmpty(final_amount_total) && final_amount_total!=0 &&  !isEmpty(service_tax_rate) && !isEmpty(service_tax_rate)){
            service_tax_amount=parseFloat(final_amount_total*(service_tax_rate/100)).toFixed(2);       
        }
    }
     $('#service_tax_amount').val(service_tax_amount);

     let po_final_amount=0;
     

    po_final_amount=final_amount_total;
    if(!isEmpty(total_tax_rate)){
        po_final_amount=Number(po_final_amount)+Number(total_tax_rate);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(ld_charges)){
        po_final_amount=Number(po_final_amount)+Number(ld_charges);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(freight_amount)){
        po_final_amount=Number(po_final_amount)+Number(freight_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(freight_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(freight_tax_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(freight_additional_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(freight_additional_tax_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(parseFloat(n_tax_amount).toFixed(2))){
        po_final_amount=Number(po_final_amount)+Number(n_tax_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(parseFloat(new_tax_amount).toFixed(2))){
        po_final_amount=Number(po_final_amount)+Number(new_tax_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(service_charge_amount)){
        po_final_amount=Number(po_final_amount)+Number(service_charge_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(service_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(service_tax_amount);
    }
    
     if(!isEmpty(service_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(service_tax_amount);
    }
    
    let packing_forwarding_amount= parseFloat($('#packing_forwarding_amount').val());
    //// console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(packing_forwarding_amount)){
        po_final_amount=Number(po_final_amount)+Number(packing_forwarding_amount);
    }
    //// console.log("po_final_amount="+po_final_amount);

     po_final_amount1=Math.round(po_final_amount);
    // // console.log("po_final_amount="+po_final_amount);
     let round_off=Number(po_final_amount1)-Number(po_final_amount);
     round_off=parseFloat(round_off).toFixed(2);
     $('#round_off').val(round_off);
     $('#po_final_amount').val(po_final_amount1);
     //calaute Final value


    
}
function add_value_servicetax(type,element) {
    
        // Get the selected option
        var selectedOption = $(element).find(":selected");

        // Access the data attribute
        var tax_rate = selectedOption.data("tax_rate");

        var selector_name;
        if(type==1){
            selector_name='freight_tax_rate';
        }else if(type==2){
            selector_name='freight_additional_tax_rate';

        }else if(type==3){
            selector_name='new_tax_rate';

        }else if(type==4){
            selector_name='service_tax_rate';

        }

        $('#'+selector_name).val( tax_rate);
       
          calculatePOItem(element);
      
     
}
$('.get_vendor').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Vendor/listVendorName',       
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term                       
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
});
$('#receive_location_site_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listSite',       
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term,
                         company_id:company_id,// search term
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
    });



 $('input[name="loaded_via"]').on('change', function() {
        // Get the value of the selected radio button
        var selectedValue = $('input[name="loaded_via"]:checked').val();      
        //// console.log(selectedValue) 
        if(selectedValue==1){
                $('.load_party_vendor_div').hide();
        }else{
                $('.load_party_vendor_div').show();
        }
        // You can use the 'selectedValue' variable as needed
});

function submitGRN(){
    if($('#type').val()!=1){
           var EmptyInputs = CheckEmptyInputsGRN();
    }else{
        EmptyInputs=0;
    }
    let po_final_amount=parseFloat($('#po_final_amount').val());
    let direct_grn_credit_amount=parseFloat($('#direct_grn_credit_amount').val());
    if($('#type')==1){
        //type 1:direct check amount
        if(po_final_amount >direct_grn_credit_amount){
            
        }
        
    }

    // if(($('#type').val()==1) && ($('#id').val()=='') && (po_final_amount > direct_grn_credit_amount) ){
    //     Swal.fire({
    //                 type: 'error',
    //                 title: 'Oops...',
    //                 text: 'The direct GRN value should not exceed '+direct_grn_credit_amount+'.',
    //                 // footer: '<a href>Why do I have this issue?</a>'
    //             }) 
    // }else{
        if($("#form_grn").valid() && po_final_amount!=0  && EmptyInputs==0){      
              Swal.fire({
                        title: 'Are you sure ?',
                        // text: msg,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!'
                    }).then((result) => {
                         
                            if(result.value){
                                 $(':disabled').each(function(e) {
                                  $(this).removeAttr('disabled');
                                })
                                // var form = $(this).parents('form');
                                // form.submit();
                                document.forms["form_grn"].submit();
                            }else{
                               //  event.preventDefault();
                                return false;
                            }
                             
                        });
                    
           
        }else{
             msg1="Some Field Required";
              if(! $("#form_grn").valid()){
                  msg1="Some Field Required";
              }else if(EmptyInputs > 0){
                     msg1="Empty ITEMS Found. Please fill all the required (*) values."; 
              }     
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: msg1,
                    // footer: '<a href>Why do I have this issue?</a>'
                }) 
            //msg=" Customer Total UnPaid Limit "+shipper_customer_unpaid_credit_amount+" is between the "+shipper_customer_credit_min_limit_amount+" and "+shipper_customer_credit_max_limit_amount;
        }   
    // }    
       
}
function CheckEmptyInputsGRN() {
            var empty_count = 0;

            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
               
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;
                var style=$(this).closest('.main_tbl_reapter').attr("style");

                
                if(style!="display: none;"){
                  if(parseInt($('#type').val())==3 || parseInt($('#type').val())==2 ){
                            let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
                            let items_id =($('select[name="items['+x+'][items_id]"]').val());                  
                            let item_rate =($('input[name="items['+x+'][item_unit_rate]"]').val())
                            let received_qty =($('input[name="items['+x+'][received_qty]"]').val())
                            let item_final_amount =($('input[name="items['+x+'][item_final_amount]"]').val())  
                            
                           
                            if (isEmpty(item_group_id) && item_group_id!='all') {
                                 console.log("item_group_id"+item_group_id)

                                empty_count++;
                            }
                            if (isEmpty(items_id)) {
                                  console.log("items_id"+items_id)
                                empty_count++;
                            }
                           
                              if(isEmpty(item_rate) || (item_rate==0)|| (item_rate==0.00))  {
                                     console.log("item_rate"+item_rate)
                                empty_count++;
                            }
                            if (isEmpty(item_final_amount)) {
                                 console.log("item_final_amount"+item_final_amount)
                                empty_count++;
                            }
                            if (isEmpty(received_qty)) {
                                 console.log("received_qty"+received_qty)
                                empty_count++;
                            }      
                  }else{
                           let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
                            let items_id =($('select[name="items['+x+'][items_id]"]').val());                  
                            let item_rate =($('input[name="items['+x+'][item_unit_rate]"]').val())
                            let received_qty =($('input[name="items['+x+'][received_qty]"]').val())
                            let item_final_amount =($('input[name="items['+x+'][item_final_amount]"]').val())

                            if (isEmpty(item_group_id) && item_group_id!='all') {
                                empty_count++;
                            }
                            if (isEmpty(items_id)) {
                                empty_count++;
                            }
                           
                              if(isEmpty(item_rate) || (item_rate==0)|| (item_rate==0.00))  {
                                empty_count++;
                            }
                            if (isEmpty(item_final_amount)) {
                                empty_count++;
                            }
                            if (isEmpty(received_qty)) {
                                empty_count++;
                            }  
                  }
                    
                }
                

            });
            return empty_count;
        }

$(document).ready(function() {
  
    if(!isEmpty($('#type').val())){
         $('.load_party_vendor_div').hide();
         var load_party_vendor_div = $('input[name="loaded_via"]:checked').val();      
       
        if(load_party_vendor_div==1){
                $('.load_party_vendor_div').hide();
        }else{
                $('.load_party_vendor_div').show();
        }
        
        getVendorSiteData(); 
        if(parseInt($('#type').val())==3 || parseInt($('#type').val())==2){
                 var empty_count = 0;
                $(".po_items_select").each(function () {
                        element_name=$(this)[0].name;                           
                        var match = element_name.match(/\[([^\]]+)\]/);
                        var x = match ? match[1] : null;
                        let items_id =($('select[name="items['+x+'][items_id]"]').val());   
                       // console.log("items_id"+items_id)       
                        if (!isEmpty(items_id)) {
                                empty_count++;
                            }

                });         
                if(empty_count==0){
                        alert("Something Went Wrong");
                        window.location.href = base_url+'admin/store/GoodsReceiptNote/poListAginstGRN';
                }  
        }
    }
    
});
function getVendorSiteData(){
        let vendorId=$('#vendorId').val();      
        let type=$('#type').val();      
      
        $.ajax({
              url:base_url +'admin/Vendor/listVendorName',    
              type: "post",              
              dataType: 'json',
              success: function(response) {
                
                  if(response){
                    $(".get_vendor").select2({                       
                          data: response
                    })       
                          
                    $('#received_by').val($('#receivedBy').val()); // Select the option with a value of '1'
                    $('#received_by').trigger('change'); 
                    
                    $('#transport_id').val( $('#transportId').val()); // Select the option with a value of '1'
                    $('#transport_id').trigger('change'); 
                    
                    
                    $('#checked_by').val($('#checkedBy').val()); // Select the option with a value of '1'
                    $('#checked_by').trigger('change'); 
                   
                 //   $("#is_party_vendor_id").select2("val", $('#partyVendorId').val()); 
                   // $("#load_party_id").select2("val", $('#loadedVendorId').val()); 
                    $('#is_party_vendor_id').val($('#partyVendorId').val()); // Select the option with a value of '1'
                    $('#is_party_vendor_id').trigger('change'); // Notif
                    $('#load_party_id').val($('#loadedVendorId').val()); // Select the option with a value of '1'
                    $('#load_party_id').trigger('change'); // Notif
                    
                    $('#vendor_id').val(vendorId); // Select the option with a value of '1'
                    $('#vendor_id').trigger('change'); // Notif
                     
                  }                
              }
          });
          
            $.ajax({
               url:base_url +'admin/Common/listuser_name',       
              type: "post",              
              dataType: 'json',
              success: function(response) {
                
                  if(response){
                    $("#received_by").select2({                       
                          data: response
                    })       
                          
                    $('#received_by').val($('#receivedBy').val()); // Select the option with a value of '1'
                    $('#received_by').trigger('change'); 
                    
                     $("#checked_by").select2({                       
                          data: response
                    })  
                    $('#checked_by').val($('#checkedBy').val()); // Select the option with a value of '1'
                    $('#checked_by').trigger('change'); 
                   
                  }                
              }
          });
        
        if(type==1){
            
            let receiveLocationSiteId=$('#receiveLocationSiteId').val();
            $.ajax({
                 url:base_url +'admin/Common/listSite',  
                type: "post",              
                dataType: 'json',
                data: {
                  'company_id':company_id,                 
                },
                success: function(response) {
              
                  if(response){
                    $("#receive_location_site_id").select2({                       
                          data: response
                    })   
                  
                    //// console.log(response);
                  //  $("#receive_location_site_id").select2("val", receiveLocationSiteId);    
                    $('#receive_location_site_id').val(receiveLocationSiteId); // Select the option with a value of '1'
                    $('#receive_location_site_id').trigger('change'); // Notify any JS components that the value changed
                    //  // console.log(receiveLocationSiteId);
                  }                
                }
            });

        }
    

}

$('#checked_by').select2({
    ajax: {
        url:base_url +'admin/Common/listuser_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });

$('#received_by').select2({
    ajax: {
        url:base_url +'admin/Common/listuser_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });
 $.validator.addMethod("futureDate", function(value, element) {
        //// console.log("asa")
        //// console.log(element)
        var selectedDate = new Date(value);
        var currentDate = new Date();
       // console.log(selectedDate)
       // console.log(currentDate)
        
        return selectedDate >= currentDate;
        
    }, "Please select a future date.");     
    
function clearItems(items){
      var name = items.name;
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

   $('select[name="items[' + row_index + '][items_id]"]').val(null).trigger("change");;
   $('select[name="items[' + row_index + '][item_group_id]"]').val(null).trigger("change");;
    
  
}
