function material_issue_filter(){

   
     var data = {    
        'material_issue_id' : $('#material_issue_id').val(),
             };

    list_material_issue(data);
    list_material_items_issue(data);
  }
  var items = '';
  function list_material_issue(data='') {
    
     items = $('#material_issue_tbl').DataTable({
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
          url: base_url +'admin/store/MaterialIssue/list_material_issue',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Company Name" },  
          {  title: "Site Name" },   
          {  title: "Issue Number" },  
          {  title: "Issue Date" },
          {  title: "Type Name" },  
          {  title: "Issued by Name" },
          {  title: "Request by Name" },
          {  title: "Received by Name" },
          {  title: "Department Name" },

          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }

  
  $(document).ready(function() {
    material_issue_filter();
    getVendorSiteData();
});



var material_issue_items = '';
  function list_material_items_issue(data='') {
    
    material_issue_items = $('#material_issue_items_tbl').DataTable({
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
          url: base_url +'admin/store/MaterialIssue/list_material_issue_items_data',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Item Name" },  
          {  title: "Item Group Name" },   
          {  title: "Issue Qty" },  
          {  title: "Weight" },
          {  title: "Rate" },  
          {  title: "Amount" },
          {  title: "Returnable" },
          {  title: "Returnable Date" },
          // {  title: "issue_to"}
          // {  title: "Party Name" },
          // {  title: "Vehicle Name" },
          // {  title: "Other Text" },
          {  title: "Remark" },

          // {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }



// $('.item_group_name').select2({
//     ajax: {
//         url:base_url +'admin/master/Items/listItemgroupName',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });

// $('.vender_name').select2({
//     ajax: {
//         url:base_url +'admin/store/MaterialIssue/listvender_name',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });

// $('.item_group_name').select2({
//     ajax: {
//         url:base_url +'admin/store/MaterialIssue/listitem_group_name',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });

// $('.user_name').select2({
//     ajax: {
//         url:base_url +'admin/store/MaterialIssue/listuser_name',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });


// $('.to_location').select2({
//     ajax: {
//         url:base_url +'admin/store/MaterialIssue/listsite_name',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });


// $('#party_option').select2({
//     ajax: {
//         url:base_url +'admin/store/MaterialIssue/listvender_name',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });
// $('.item_name').select2({
//             ajax: {
//                 url:base_url +'admin/master/Items/listItemName',       
//                   dataType: 'json',
//                 delay: 250,
//                 data: function (data) {
//                     return {
//                         searchTerm: data.term,
//                     };
//                 },
//                 processResults: function (response) {
//                     return {
//                         results:response
//                     };
//                 },
//                 cache: true
//             }
//         });


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

function getItemList(material_items){
    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)
    var selectElement = $('select[name="material_items['+row_index+'][items_id]"]');
     $.ajax({
              url: base_url + 'admin/PO/getItemData',
              type: "post",  
              data: {'item_group_id':material_items.value},            
              dataType: 'json',
              success: function(response) {
                // console.log(response.data)
                  if(response.result){
                    selectElement.select2({                         
                          data: response.data
                        })
                   
                    
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
              }
          });

    }

function getItemUnits(material_items) {
     var name = material_items.name;
   
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="material_items['+row_index+'][items_id]"]');
     $.ajax({
              url: base_url + 'admin/PO/getItemUnitsData',
              type: "post",  
              data: {'item_id':material_items.value},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                 
                   $('input[name="material_items['+row_index+'][rate]"]').val( response.data_item.rate);
                    
                    var unitElement = $('select[name="material_items['+row_index+'][item_unit_id]"]');
                    var weightElement = $('select[name="material_items['+row_index+'][weight_item_unit_id]"]');
                    
                    
                     $('#unitElement').empty();
                    // Append new options to the <select> element
                    $.each( response.data, function (index, option) {
                        // console.log(option.qty)
                        // unitElement.append($('<option>', {
                        //     value: option.item_unit_id,
                        //     text: option.short_name,
                        // }));
                        var optionElement = $('<option>', {
                            value: option.item_unit_id,
                            text: option.short_name
                        });
                    
                        // Add data attribute using the attr method
                        optionElement.attr('data-aviable_qty', option.qty);
                    
                        unitElement.append(optionElement);
                        
                        weightElement.append($('<option>', {
                            value: option.item_unit_id,
                            text: option.short_name
                        }));
                        
                    
                     
                    });
                    
                    getValidationMax();

                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
     getAvaliableQuantity(material_items);
      // calculatePOItem(items);
}




function getAvaliableQuantity(material_items){

    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)
    var selectElement = $('select[name="material_items['+row_index+'][items_id]"]');

    $.ajax({
          url: base_url + 'admin/store/MaterialIssue/getAvaliableQty',
          type: "post",  
          data: {'item_id':material_items.value},            
          dataType: 'json',
          success: function(get_qty) {
             $('input[name="material_items['+row_index+'][available_qty]"]').val(get_qty);
          }
      });
}

function getValidationMax(){
         $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
               
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;
                
                var unitElement = $( 'select[name="material_items['+x+'][item_unit_id]"]' );
                var item_unit = $( 'input[name="material_items['+x+'][item_unit]"]' );
                 
                 
                var selectedOption = unitElement.find('option:selected');
                var aviableQty = selectedOption.data('aviable_qty');
                console.log("aviableQty"+aviableQty);
                $(item_unit).attr('max', aviableQty);
                
         });
}


function display_issued_to(material_items){
    var name = material_items.name;
    var match = name.match(/\[([^\]]+)\]/);
    var x = match ? match[1] : null;
  
      var display_type_issued = $( 'input[name="material_items['+x+'][issue_to]"]:checked' ).val();
      
      if (display_type_issued == 1) {
        $('[name="material_items['+x+'][emp_issued_to]"]').show();
        $('[name="material_items['+x+'][vehicle_issed_to]"]').hide();
        $('[name="material_items['+x+'][other_issued]"]').hide();
      
      }else if(display_type_issued == 2){
        $('[name="material_items['+x+'][emp_issued_to]"]').hide();
        $('[name="material_items['+x+'][vehicle_issed_to]"]').show();
        $('[name="material_items['+x+'][other_issued]"]').hide();
      

      }else if(display_type_issued == 3){
         $('[name="material_items['+x+'][emp_issued_to]"]').hide();
         $('[name="material_items['+x+'][vehicle_issed_to]"]').hide();
         $('[name="material_items['+x+'][other_issued]"]').show();
      
      }
 }

    function getIssueQuantity(evt,element) {
        if (evt.key === 'Tab' || evt.key === 'Enter') {
        evt.preventDefault();
        // alert("sd")
       calculateFinalAMount(element)
      }
    }

     function getIssueRate(evt,element) {
        if (evt.key === 'Tab' || evt.key === 'Enter') {
        evt.preventDefault();
        // alert("sd")
       calculateFinalAMount(element)
      }
    }


    
    function calculateFinalAMount(element) {

     var name = element.name;       
        console.log(name);
        var match = name.match(/\[([^\]]+)\]/);    
        
        var row_index = match ? match[1] : null;

        let items_unit= parseInt($('input[name="material_items['+row_index+'][item_unit]"]').val());
        let rate= parseInt($('input[name="material_items['+row_index+'][rate]"]').val());

        final_total = parseFloat(items_unit * rate).toFixed(2); 
     
        $('input[name="material_items['+row_index+'][amount]"]').val(final_total); 
    }




function remove_material_file_attch(material_file_attachment_id)
    {
        // alert(po_attachment_id);
        $.ajax({
           url: base_url + 'admin/store/MaterialIssue/remove_material_file_attachment',
           type: 'post',
           dataType: 'json',
           data: {
              'material_file_attachment_id': material_file_attachment_id,
           },
           success: function (response) {
              if (response.result == true) {
                 // alert_float('success', response.reason);
                $('#remove_material_file_attch_'+material_file_attachment_id).remove();
                
              } else {
                 // alert_float('danger', response.reason);
              }

           }

        });
    }
function getVendorSiteData(){
        let vendorId=$('#vendorId').val();      
        let transportId=$('#vendorId').val();  
        let type=$('#type').val();      
           if(type==2){
            $.ajax({
                  url:base_url +'admin/Vendor/listVendorName',    
                  type: "post",              
                  dataType: 'json',
                  success: function(response) {
                    
                      if(response){
                        $("#account_name").select2({                       
                              data: response
                        })       
                      
                        $('#account_name').val(vendorId); // Select the option with a value of '1'
                        $('#account_name').trigger('change'); // Notif
                        
                          $("#transporter").select2({                       
                              data: response
                        })       
                      
                        $('#transporter').val(transportId); // Select the option with a value of '1'
                        $('#transporter').trigger('change'); // Notif
                        
                        
                        
                      
                      }                
                  }
              });
           }
     

}
function submitIssue(){   
     var EmptyInputs = CheckEmptyInputs();
    console.log("EmptyInputs"+EmptyInputs)
    let po_final_amount=parseFloat($('#po_final_amount').val());
    
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
function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}
function CheckEmptyInputs() {
            var empty_count = 0;

            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
               
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;
                var style=$(this).closest('.main_tbl_reapter').attr("style");
                
                
                if(style!="display: none;"){
                        let item_group_id =($('select[name="material_items['+x+'][item_group_id]"]').val());
                        let items_id =($('select[name="material_items['+x+'][items_id]"]').val());
                        let item_unit_id =($('select[name="material_items['+x+'][item_unit_id]"]').val());
                        console.log(item_group_id)
                         console.log(items_id)
                          console.log(item_unit_id)
                        if (isEmpty(item_group_id)) {
                            empty_count++;
                        }
                        if (isEmpty(items_id)) {
                            empty_count++;
                        }
                        if (isEmpty(item_unit_id)) {
                            empty_count++;
                        }
                }
                

            });
            return empty_count;
        }
