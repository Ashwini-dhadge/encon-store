 let tbl_open;
 filter();
 function filter(){

   
    var data = {    
                    'company_id':$("#company_id").val(),
                    'site_id':$("#site_id").val(),
                    'on_date':$("#on_date").val(),
                    'from_date':$("#from_date").val(),
                    'to_date':$("#to_date").val(),
                    'item_id':$("#item_id").val(),
       };

    list_material_issue(data);
   
  }
 
function list_material_issue(data='') {
    
     tbl_open = $('#tbl').DataTable({
            "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[0, "desc"]],
      ajax: {
          url: base_url +'admin/store/GoodsItemOpening/list_opening_stock',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Company Name" },  
          {  title: "Site Name" },   
          {  title: "Remark" },  
          {  title: "Tota Qty" },
          {  title: "Created By" },  
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }
 $('.item_group_select2').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/PO/listItemGroup',       
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

 $.ajax({
        url: base_url + 'admin/Common/listSite',
        type: "post",
        dataType: 'json',
        success: function(response) {

            if (response) {
                $("#location_id").select2({
                    data: response
                })
                // $("#delivery_site_id").select2("val", deliverySiteId); 
                let locationId = $('#locationId').val();
                $('#location_id').val(locationId);
                $('#location_id').trigger('change');
            }
        }
    });
    
$.validator.addMethod("futureDate", function(value, element) {
        // console.log("asa")
        // console.log(element)
        var selectedDate = new Date(value);
        var currentDate = new Date();
        console.log(selectedDate)
        console.log(currentDate)
        
        return selectedDate >= currentDate;
        
    }, "Please select a future date.");  
function getItemList(items){
     var name = items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
      if(!isEmpty(items.value) || (items.value =='all')){
     $.ajax({
              url: base_url + 'admin/PO/getItemData',
              type: "post",  
              data: {'item_group_id':items.value},            
              dataType: 'json',
              success: function(response) {
                // console.log(response.data)
                  if(response.result){
                      selectElement.empty(); 
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
    var event=items;
     var name = items.name;
     var vendor_id = $('#vendor_id').val();
   
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
     $.ajax({
              url: base_url + 'admin/PO/getItemUnitsData',
              type: "post",  
              data: {'item_id':items.value, 'vendor_id': vendor_id},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                  
                   $('input[name="items['+row_index+'][item_hsc_code]"]').val( response.data_item.hsn_code)

                   if(response.data_item.item_rate == null ){
                     $('input[name="items['+row_index+'][item_unit_rate]"]').val( response.data_item.rate)
                   }else{
                     $('input[name="items['+row_index+'][item_unit_rate]"]').val( response.data_item.item_rate)
                   }
                  
                    
                    var unitElement = $('select[name="items['+row_index+'][item_unit_id]"]');
                     unitElement.empty();     
                    // Append new options to the <select> element
                    $.each( response.data, function (index, option) {
                        unitElement.append($('<option>', {
                            value: option.item_unit_id,
                            text: option.short_name
                        }));
                    });
                    getItemUnitsStock(event)

                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
      // calculatePOItem(items);
}
function getItemUnitsStock(items) {
     var name = items.name;
     
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
     var item_unit = $('select[name="items['+row_index+'][item_unit_id]"]').val();
        console.log(items.value)
            console.log(item_unit)
    
     $.ajax({
              url: base_url + 'admin/PO/getItemUnitsStock',
              type: "post",  
              data: {'item_id':items.value,'item_unit_id':item_unit},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                  
                   $('input[name="items['+row_index+'][item_stock_qty]"]').val( response.stock)
                   
                  }else{
                    alert_float('danger', response.reasons);
                  }
                  $('[name="items['+row_index+'][tbl_item_rate_update_html]"]').html(response.html_data);
                
              }
          });
      // calculatePOItem(items);
}
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
    
   
    //item_rate_type 1-qty and 2 weight

    if(!isEmpty(item_unit_rate) && !isEmpty(item_unit_rate)&& ( !isEmpty(item_weight) || !isEmpty(item_qty)) &&  !isEmpty(row_index)){

        if((item_rate_type==2  && !isEmpty(item_unit_rate)) || (item_rate_type==1 && !isEmpty(item_qty) && !isEmpty(item_unit_rate))){
                if(item_rate_type==2){
                    item_rate=parseFloat(item_weight*item_unit_rate).toFixed(2);
                }else{
                    item_rate=parseFloat(item_qty*item_unit_rate).toFixed(2);
                }
                
                let discount_amount=item_sub_amount=0;
                //discount_type 1:value 2:qty
                if(discount_type==1 && !isEmpty(discount_percent)){
                     discount_amount=(item_rate*(discount_percent/100)).toFixed(2);
                }else if(discount_type==2 && !isEmpty(discount_percent)){
                     discount_amount=(discount_percent*item_qty).toFixed(2);
                }
                // console.log("discount_type"+discount_type)
                //  console.log("discount_percent"+discount_percent)
                // console.log("discount_amount"+discount_amount)
                $('input[name="items['+row_index+'][discount_amount]"]').val(discount_amount);
                  item_sub_amount=item_rate-discount_amount;
                
                console.log(item_rate)
                $('input[name="items['+row_index+'][item_rate]"]').val(item_sub_amount);
                
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
    });

     $('#total_qty').val(total_qty);
}
function submitIssue(){   
     var EmptyInputs = CheckEmptyInputs();
    console.log("EmptyInputs"+EmptyInputs)
   
     if($("#frm_issue").valid()  && EmptyInputs==0){ 
     
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
                                document.forms["frm_issue"].submit();
                            }else{
                               //  event.preventDefault();
                                return false;
                            }
                             
                        });
                    
           
    }else{
         msg1="Some Field Required";
          if(! $("#frm_issue").valid()){
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
}
function CheckEmptyInputs() {
            var empty_count = 0;
            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;
                var style=$(this).closest('.main_tbl_reapter').css('display');
          
                if(style!="none"){
                    console.log("empty_count_name="+element_name)
                    console.log("style="+style)
                     console.log("x="+x)
                    let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
                    let items_id =($('select[name="items['+x+'][items_id]"]').val());                  
                    let item_rate =($('input[name="items['+x+'][item_unit]"]').val())
                   
                        
                        
                //     if(!isEmpty(grn_item_id) && grn_item_id!=0){
                   
                        if(isEmpty(item_group_id) &&  item_group_id!='all') {
                             console.log("item_group_id="+item_group_id)
                            empty_count++;
                        }
                        if (isEmpty(items_id)) {
                             console.log("items_id="+items_id)
                            empty_count++;
                        }
                    
                        if (isEmpty(item_rate) || item_rate==0.00 || item_rate==0  || item_rate==0.0 ) {
                             console.log("item_rate="+item_rate)
                            empty_count++;
                        }
                       
                }
                

            });
            return empty_count;
}
 $(document).ready(function() {
$('#tbl tbody').on('click', 'tr img', function (event) {
    var id = $(this).data('id');
    event.preventDefault(); // Prevent the default action of the link
    var tr = $(this).closest('tr');
    var row = tbl_open.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        $.ajax({
            url: base_url + 'admin/store/GoodsItemOpening/innearItemTableData',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                innerTable = response.html;
                row.child(innerTable).show();
                tr.addClass('shown');
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
});

});
$('#site_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listSite',       
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term,
                        company_id:$('#company_id').val()
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
$('#company_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listCompanyName',       
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
$('#item_id').select2({
        ajax: {
            url:base_url +'admin/Common/list_item_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                    'item_group_name_id':$('#id_itemgroup').val()
                    
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
    function clearItems(items){
      var name = items.name;
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

    $('select[name="items[' + row_index + '][items_id]"]').val(null).trigger("change");;
    $('select[name="items[' + row_index + '][item_group_id]"]').val(null).trigger("change");;
 

    
  
}
$.validator.addMethod("decimal", function(value, element) {
    
    if (this.optional(element) || /^-?\d+(\.\d+)?$/.test(value)) {
      return true;
       
    } else {
        $.validator.messages.availableQty = "Please enter a valid decimal number";
        return false;
    }
    // Returning true initially as AJAX is asynchronous
    // return true;
}, function(params, element) {
    // Custom error message function, this will display the dynamically set error message
    return $.validator.format($.validator.messages.availableQty, params);
});


// Set default error message for the availableQty method
$.validator.messages.availableQty = "Stock not available.";
