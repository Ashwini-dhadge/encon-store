$('.po_item_cal').on('keydown', function(evt) {
  if (evt.key === 'Tab' || evt.key === 'Enter') {
    evt.preventDefault();
    // alert("sd")
   calculatePOItem(this)
  }
});
$('.po_item_cal').on('blur', function(evt) {
    var element = evt.target;
    calculatePOItem(element);
});
$('.po_item_cal_final').on('blur', function(evt) {
    calculateTotal()
});


$('.po_item_cal_final').on('keydown', function(evt) {
  //if (evt.key === 'Tab' || evt.key === 'Enter') {
//    evt.preventDefault();
    // alert("sd")
   calculateTotal()
  //}
});

function calculatePOItemEvent(evt,element) {
    if (evt.key === 'Tab' || evt.key === 'Enter') {
    evt.preventDefault();
    // alert("sd")
   calculatePOItem(element)
  }
}
function calculatePOItem(element,type=0) {
    if(type==1){
        // var name = element;       
        // var match = name.match(/\[([^\]]+)\]/);    
        var row_index = element;
    }else{
        var name = element.name;       
        var match = name.match(/\[([^\]]+)\]/);    
        var row_index = match ? match[1] : null;
    }
   
   
   
  
    let item_weight= parseFloat($('input[name="items['+row_index+'][item_weight]"]').val());
    let item_qty= parseFloat($('input[name="items['+row_index+'][item_unit]"]').val());
    let item_unit_rate= parseFloat($('input[name="items['+row_index+'][item_unit_rate]"]').val());
    let item_rate_type= parseInt($('select[name="items['+row_index+'][item_rate_type]"]').val());
    let discount_type= parseInt($('select[name="items['+row_index+'][discount_type]"]').val());
    let discount_percent= parseFloat($('input[name="items['+row_index+'][discount_percent]"]').val());
    let tax_rate= parseFloat($('input[name="items['+row_index+'][tax_rate]"]').val());
    let tax_id= parseInt($('select[name="items['+row_index+'][tax_id]"]').val());
   
    let additional_tax_rate= parseFloat($('input[name="items['+row_index+'][additional_tax_rate]"]').val());
    let additional_tax_id= parseInt($('select[name="items['+row_index+'][additional_tax_id]"]').val());

 
    //item_rate_type 1-qty and 2 weight
   
    if(!isEmpty(item_unit_rate) && !isEmpty(item_unit_rate)&& ( !isEmpty(item_weight) || !isEmpty(item_qty)) &&  !isEmpty(row_index)){

        if((item_rate_type==2  && !isEmpty(item_unit_rate)) || (item_rate_type==1 && !isEmpty(item_qty) && !isEmpty(item_unit_rate))){
                if(item_rate_type==2){
                    item_rate=parseFloat(item_weight*item_unit_rate).toFixed(2);
                }else{
                    item_rate=parseFloat(item_qty*item_unit_rate).toFixed(2);
                }
                
                $('input[name="items['+row_index+'][item_rate]"]').val(item_rate);

                let discount_amount=item_sub_amount=0;
                //discount_type 1:value 2:qty
                if(discount_type==1 && !isEmpty(discount_percent)){
                     discount_amount=(item_rate*(discount_percent/100)).toFixed(2);
                }else if(discount_type==2 && !isEmpty(discount_percent)){
                     discount_amount=(discount_percent*item_qty).toFixed(2);
                }

                $('input[name="items['+row_index+'][discount_amount]"]').val(discount_amount);

                item_sub_amount=item_rate-discount_amount;

                $('input[name="items['+row_index+'][item_final_amount]"]').val(item_sub_amount);

                //calcuate tax rate
                
                if(!isEmpty(tax_rate) && tax_rate!=0 &&  !isEmpty(tax_id) && !isEmpty(item_sub_amount)){
                    tax_amount=parseFloat(item_sub_amount*(tax_rate/100)).toFixed(2);
                    $('input[name="items['+row_index+'][tax_value]"]').val(tax_amount);
                }else{
                    $('input[name="items['+row_index+'][tax_value]"]').val(0);
                }


                if(!isEmpty(additional_tax_rate) && additional_tax_rate !=0 &&  !isEmpty(additional_tax_id) && !isEmpty(item_sub_amount)){
                    additional_tax_value=parseFloat(item_sub_amount*(additional_tax_rate/100)).toFixed(2);
                    $('input[name="items['+row_index+'][additional_tax_value]"]').val(additional_tax_value);
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
    let total_qty=total_tax_rate=total_additional_tax_rate=final_amount_total=0;
    let total_rate=total_discount_amount=0;

     $(".po_items_select").each(function() {
            
           // console.log($(this))
            element_name=$(this)[0].name;            
            var match = element_name.match(/\[([^\]]+)\]/);
            var x = match ? match[1] : null;

            // console.log(element_name.name)
          
            let item_unit =parseFloat($('input[name="items['+x+'][item_unit]"]').val()).toFixed(2);
            let item_rate =parseFloat($('input[name="items['+x+'][item_rate]"]').val()).toFixed(2);
            let discount_amount =parseFloat($('input[name="items['+x+'][discount_amount]"]').val()).toFixed(2);
              
                  
                if(item_unit !== "" && !isNaN(item_unit) && !isEmpty(item_unit) ){
                    total_qty=parseFloat(total_qty)+parseFloat(item_unit);
                }
                 //console.log("total_qty"+total_qty)   
                if(item_rate !== "" && !isNaN(item_rate) && !isEmpty(item_rate) ){
                    total_rate=parseFloat(total_rate)+parseFloat(item_rate);
                }
                if(discount_amount !== "" && !isNaN(discount_amount) && !isEmpty(discount_amount) ){
                    total_discount_amount=parseFloat(total_discount_amount)+parseFloat(discount_amount);
                }
                  console.log("discount_amount"+total_discount_amount)

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
                
    
    });
       console.log(total_qty)
     $('#total_qty').val(total_qty);
     $('#total_item_rate').val(total_rate);
     $('#total_discount_amount').val(total_discount_amount);
     $('#total_tax_rate').val(total_tax_rate);
     $('#total_additional_tax_rate').val(total_additional_tax_rate);
     $('#final_amount_total').val(final_amount_total);
   

    //console.log(final_discount_percent)
    let final_discount_percent= parseFloat($('#final_discount_percent').val());
    let final_discount_amount=0;
  
    if(!isEmpty(final_discount_percent) && final_discount_percent!=0 &&  !isEmpty(final_amount_total) && !isEmpty(final_discount_percent)){
            final_discount_amount=parseFloat(final_amount_total*(final_discount_percent/100)).toFixed(2);       
    }
    $('#final_discount_amount').val(final_discount_amount);
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

    //  packing and forwarding
 //   let packing_forwarding_amount= parseFloat($('#packing_forwarding_amount').val());
    
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
  //  console.log("service_charge_type="+service_charge_type_val);
    if(service_charge_type_val==1){
      //  console.log("service_charge_type="+service_charge_type_val);
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
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(ld_charges)){
        po_final_amount=Number(po_final_amount)+Number(ld_charges);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(freight_amount)){
        po_final_amount=Number(po_final_amount)+Number(freight_amount);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(freight_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(freight_tax_amount);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(freight_additional_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(freight_additional_tax_amount);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(parseFloat(n_tax_amount).toFixed(2))){
        po_final_amount=Number(po_final_amount)+Number(n_tax_amount);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(parseFloat(new_tax_amount).toFixed(2))){
        po_final_amount=Number(po_final_amount)+Number(new_tax_amount);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(service_charge_amount)){
        po_final_amount=Number(po_final_amount)+Number(service_charge_amount);
    }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(service_tax_amount)){
        po_final_amount=Number(po_final_amount)+Number(service_tax_amount);
    }
    //   if(!isEmpty(packing_forwarding_amount)){
    //     po_final_amount=Number(po_final_amount)+Number(packing_forwarding_amount);
    // }
    // console.log("po_final_amount="+po_final_amount);
    if(!isEmpty(final_discount_amount)){
        po_final_amount=Number(po_final_amount)-Number(final_discount_amount);
    }
    
   
    // console.log("po_final_amount="+po_final_amount);

     po_final_amount1=Math.round(po_final_amount);
     console.log("po_final_amount="+po_final_amount);
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
       
        calculateTotal();
      
     
}


function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}




