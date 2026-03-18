
$("#on_date").change(function () {
        var on_date = $('#on_date').val();
        // alert(on_date);
           if (on_date != 6) {
              material_issue_return_filter();
              $('.on_date').hide();
            }else{
              $('.on_date').show();
            }
       });



function material_issue_return_filter(){

   
       var mtr_issue_id = $('#mtr_issue_id').val();
    var on_date = $("#on_date").val();
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var company_id = $(".companyid_a").val();
    var site_id = $(".site_id_a").val();
     var inventory_item_id = $('#item_id').val();
    var vendor_id = $('#vendor_id').val();
 
     var data = {     
            'mtr_issue_id' : mtr_issue_id,
            'on_date': on_date,
            'vendor_id': vendor_id,
            'from_date': from_date,
            'to_date': to_date,
            'company_id': company_id,
            'site_id': site_id,
             'item_id': inventory_item_id,
                 'item_group_id':$('#id_itemgroup').val(),
        };
    list_material_issue_return(data);
     list_material_items_issue(data);
  }

  
  
  
   var tbl_material_issue_return = '';
  function list_material_issue_return(data='') {
    
    tbl_material_issue_return = $('#tbl_material_issue_return').DataTable({
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
          url: base_url +'admin/store/MaterialIssueReturn/list_material_issue_return',
          type: 'POST',
          dataSrc: function (response) {
                // Log total count here
                 $('.total_count').text(response.total_count);
                return response.data;

            },
          data:data,

      },

      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Company Name" },  
          {  title: "Site Name" },  
          {  title: "Financial Year" },
          {  title: "Type" },  
          {  title: "M.RTN.No" },
          {  title: "Date" },
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],

    });

  }

  $(document).ready(function() {
    material_issue_return_filter();
    $('.on_date').hide();
});





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
              url: base_url + 'admin/store/MaterialIssueReturn/getItemData',
              type: "post",  
              data: {'item_group_id':material_items.value},            
              dataType: 'json',
              success: function(response) {
                // console.log(response.data)
                selectElement.empty();
                //  batch_no.empty();
                    selectElement.append($('<option>', {
                        value: '',
                        text: 'Select Item' ,
                       'item_code':''// You can customize the label here
                    }));
                    
                  if(response.result){
                     selectElement.select2({
                        data: response.data,
                        minimumInputLength: 0,
                        matcher: function(params, data) {
                            if ($.trim(params.term) === '') {
                                return data;
                            }
                            console.log(data)
                            if (
                                    data &&
                                    (
                                        data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1 ||
                                        (data.item_code && data.item_code.toString().indexOf(params.term.toString()) > -1)
                                    )
                                ) {
                                    return data;
                                }

                            // If the search term doesn't match the item code or text, return null to exclude the option
                            return null;
                        }
                    });
                   
                    // Get the Select2 dropdown container
                    var $select2Container = selectElement.next('.select2-container');
                    
                    // Append a default option
                    $select2Container.find('.select2-selection__rendered').append('<span class="select2-selection__choice">Default Option</span>');
                    
                    // Trigger Select2 to update itself
                    selectElement.trigger('change');
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
              }
          });

    }

function getItemUnits(material_items) {
    console.log("DF")
     var name = material_items.name;
   
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="material_items['+row_index+'][items_id]"]');
     $.ajax({
              url: base_url + 'admin/store/MaterialIssueReturn/getItemUnitsData',
              type: "post",  
              data: {'item_id':material_items.value},            
              dataType: 'json',
              success: function(response) {
            //   console.log(response);
                  if(response.result){
                 // console.log(response.data[0].rate);
                   // $('input[name="material_items['+row_index+'][rate]"]').val(response.data_item.rate);
                  
                   $('input[name="material_items['+row_index+'][rate]"]').val(response.data[0].rate);
                    
                    var unitElement = $('select[name="material_items['+row_index+'][item_unit_id]"]');
                    var weightElement = $('select[name="material_items['+row_index+'][weight_item_unit_id]"]');
                    
                    
                     $('#unitElement').empty();
                    // Append new options to the <select> element
                     unitElement.empty();
                     weightElement.empty();
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
                        // optionElement.attr('data-aviable_qty', option.qty);
                    
                        unitElement.append(optionElement);

                        
                        var optionElement = $('<option>', {
                           value: option.item_unit_id,
                            text: option.short_name
                        });
                         weightElement.append(optionElement);
                        
                        // weightElement.append($('<option>', {
                        //     value: option.item_unit_id,
                        //     text: option.short_name
                        // }));
                        
                     
                    });
                   getBatchwiseUnitWise(material_items);

                  }else{
                    // alert_float('danger', response.reasons);
                  }
                
                 
              }
          });

}

function getBatchwiseUnitWise(material_items){
     console.log("As");
    var name = material_items.name;
   
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="material_items['+row_index+'][items_id]"]');
    var item_unit_id = $('select[name="material_items['+row_index+'][item_unit_id]"]');
    
  
     $.ajax({
              url: base_url + 'admin/store/MaterialIssueReturn/getUnitBatchWiseData',
              type: "post",  
              data: {'item_id':selectElement.val(),'item_unit_id':item_unit_id.val()},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                 
                    var unitElement = $('select[name="material_items['+row_index+'][item_unit_id]"]');
                    var weightElement = $('select[name="material_items['+row_index+'][weight_item_unit_id]"]');
                    var batch_no = $('select[name="material_items['+row_index+'][batch_no]"]');
                    
                    batch_no.empty();
                    batch_no.append($('<option>', {
                        value: '',
                        text: 'Select Batch' // You can customize the label here
                    }));

                    $.each( response.batch_info, function (index, option) {
                      
                        var optionElement = $('<option>', {
                            value: option.batch_no,
                            text: option.batch_no
                        });
                    
                        // Add data attribute using the attr method
                        optionElement.attr('data-aviable_qty', option.issue_qty);
                        optionElement.attr('data-expired_date', option.expired_date);
                        optionElement.attr('data-rate', option.rate);
                        batch_no.append(optionElement);
                    });
                    // getValidationMax();

                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                //  getAvaliableQuantity(material_items);
              }
          });
    
      // calculatePOItem(items);
}

function getAvaliableQuantity(material_items){
    // alert("ds")
    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    //  console.log("row_index="+row_index)
    var selectElement = $('select[name="material_items['+row_index+'][items_id]"]');
    var batch_no = $('select[name="material_items['+row_index+'][batch_no]"]');
    var item_unit_id = $('select[name="material_items['+row_index+'][item_unit_id]"]');
    
    var selectedOption = batch_no.find('option:selected');
    console.log(selectedOption)
 
    var expired_date = selectedOption.data('expired_date');
    var rate = selectedOption.data('rate');
     
    
    $('input[name="material_items['+row_index+'][expired_date]"]').val(expired_date);
    $('input[name="material_items['+row_index+'][amount]"]').val(rate);
    
    
    // $.ajax({
    //       url: base_url + 'admin/store/MaterialIssue/getAvaliableQty',
    //       type: "post",  
    //       data: {'item_id':material_items.value,'item_unit_id':item_unit_id.val(),'batch_no':batch_no.val()},            
    //       dataType: 'json',
    //       success: function(get_qty) {
    //          $('input[name="material_items['+row_index+'][available_qty]"]').val(get_qty);
    //          getValidationMax();
    //       }
    //   });
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

                        let item_unit =($('input[name="material_items['+x+'][item_unit]"]').val());
                        let item_rate =($('input[name="material_items['+x+'][rate]"]').val());
                        let item_amount =($('input[name="material_items['+x+'][amount]"]').val());




                        console.log(item_group_id)
                         console.log(items_id)
                          console.log(item_unit_id)
                        if (isEmpty(item_group_id) && item_group_id!='all') {
                            empty_count++;
                        }
                        if (isEmpty(items_id)) {
                            empty_count++;
                        }
                        if (isEmpty(item_unit_id)) {
                            empty_count++;
                        }

                        if (isEmpty(item_unit)) {
                            empty_count++;
                        }
                         if (isEmpty(item_rate) || item_rate==0.00 || item_rate==0 || item_rate==0.0 ) {
                            empty_count++;
                        }
                        if (isEmpty(item_amount)) {
                            empty_count++;
                        }

                }
                

            });
            return empty_count;
        }
var return_material_issue_items = '';
  function list_material_items_issue(data='') {
    
    return_material_issue_items = $('#return_material_issue_items').DataTable({
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
          url: base_url +'admin/store/MaterialIssueReturn/list_return_material_issue_items_data',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Item Name" },  
          {  title: "Item Group Name" },   
          {  title: "Return Issue Qty" },  
          {  title: "Weight" },
          {  title: "Rate" },  
          {  title: "Amount" },
          {  title: "Returnable" },
          {  title: "Returnable Date" },
          {  title: "Remark" },
      ],
     
    });

  }
function clearItems(items){
      var name = items.name;
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

   $('select[name="material_items[' + row_index + '][items_id]"]').val(null).trigger("change");;
    $('select[name="material_items[' + row_index + '][item_group_id]"]').val(null).trigger("change");;
    $('select[name="material_items[' + row_index + '][batch_no]"]').val(null).trigger("change");;
    $('input[name="material_items[' + row_index + '][expired_date]"]').val('');
    

    
  
}
$(document).ready(function() {
    // alert("Zx")
    $('#tbl_material_issue_return tbody').on('click', 'tr img', function(event) {
        var id = $(this).data('id');
        //   alert("Zx")
        event.preventDefault(); // Prevent the default action of the link
        var tr = $(this).closest('tr');
        var row = tbl_material_issue_return.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.ajax({
                url: base_url + 'admin/store/MaterialIssueReturn/InnearItemTableData',
                type: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    innerTable = response.html;
                    row.child(innerTable).show();
                    tr.addClass('shown');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

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
$('#vendor_id').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/Common/listvender_name',
        dataType: 'json',
        delay: 250,
        data: function(data) {

            return {
                searchTerm: data.term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    }
});