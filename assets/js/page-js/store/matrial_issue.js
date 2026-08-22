function material_issue_filter() {
    var company_id = $('#company_id').val();
    var site_id = $('#site_id').val();
    var vendor_id = $('#vendor_id').val();
    var issue_type = $('#issue_type').val();
    var on_date = $('#on_date').val();
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();

    var data = {
        'material_issue_id': $('#material_issue_id').val(),
        'company_id': company_id,
        'site_id': site_id,
        'vendor_id': vendor_id,
        'issue_type': issue_type,
        'on_date': $('#on_date').val(),
        'from_date': $('#from_date').val(),
        'to_date': $('#to_date').val(),
        'item_id': $("#item_id").val(),
    };




    list_material_issue(data);
    list_material_items_issue(data);
}
var material_issue_tbl = '';

function list_material_issue(data = '') {

    material_issue_tbl = $('#material_issue_tbl').DataTable({
        "dom": 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div'
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [
            [0, "desc"]
        ],
        ajax: {
            url: base_url + 'admin/store/MaterialIssue/list_material_issue',
            type: 'POST',
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{
            responsivePriority: 1,
            targets: 5
        }],
        "scrollX": false, // Enable horizontal scrolling if needed
        "autoWidth": false,
        columns: [{
                title: "Sr._No.",
                orderable: false,
                width: "5%"
            },
            {
                title: "Issue Number",
                width: "5%"
            },
            {
                title: "Issue Date",
                width: "5%"
            },
            {
                title: "Company Name",
                width: "10%"
            },
            {
                title: "Site Name",
                width: "10%"
            },

            {
                title: "Type Name",
                width: "5%"
            },
            {
                title: "Issued by Name",
                width: "5%"
            },
            {
                title: "Request by Name",
                width: "5%"
            },
            {
                title: "Received by Name",
                width: "5%"
            },
            {
                title: "Department Name",
                width: "5%"
            },
            {
                title: "Vendor Name",
                width: "5%"
            },
            {
                title: "Action",
                orderable: false,
                "className": "text-center",
                width: "5%"
            },
        ],

    });

}

$(document).ready(function() {
    material_issue_filter();
    getVendorSiteData();
});



var material_issue_items = '';

function list_material_items_issue(data = '') {

    material_issue_items = $('#material_issue_items_tbl').DataTable({
        "dom": 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div'
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [
            [0, "desc"]
        ],
        ajax: {
            url: base_url + 'admin/store/MaterialIssue/list_material_issue_items_data',
            type: 'POST',
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{
            responsivePriority: 1,
            targets: 5
        }],

        columns: [{
                title: "Sr._No.",
                orderable: false
            },
            {
                title: "Item Name"
            },
            {
                title: "Item Group Name"
            },
            {
                title: "Issue Qty"
            },
            {
                title: "Weight"
            },
            {
                title: "Rate"
            },
            {
                title: "Amount"
            },
            {
                title: "Returnable"
            },
            {
                title: "Returnable Date"
            },
            // {  title: "issue_to"}
            // {  title: "Party Name" },
            // {  title: "Vehicle Name" },
            // {  title: "Other Text" },
            {
                title: "Remark"
            },

            // {  title: "Action" , orderable:false, "className": "text-center"},
        ],

    });

}




$('.item_group_select2').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/PO/listItemGroup',
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

function getItemList(material_items) {
    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)
    var selectElement = $('select[name="material_items[' + row_index + '][items_id]"]');
    if (!isEmpty(material_items.value) || (material_items.value == 'all')) {
        $.ajax({
            url: base_url + 'admin/PO/getItemData',
            type: "post",
            data: {
                'item_group_id': material_items.value
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response.data)
                selectElement.empty();
                if (response.result) {
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

                    // Get the Select2 dropdown container
                    var $select2Container = selectElement.next('.select2-container');

                    // Append a default option
                    $select2Container.find('.select2-selection__rendered').append('<span class="select2-selection__choice">Default Option</span>');

                    // Trigger Select2 to update itself
                    var defaultValues = ["", ""];
                    selectElement.val(defaultValues).trigger('change.select2');
                    // selectElement.trigger('change');
                } else {
                    alert_float('danger', response.reasons);
                }

            }
        });
    } else {
        var defaultValues = ["", ""];
        selectElement.val(defaultValues).trigger('change.select2');
    }


}

function getItemUnits(material_items) {
    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

    var selectElement = $('select[name="material_items[' + row_index + '][items_id]"]');
    $.ajax({
        url: base_url + 'admin/PO/getItemUnitsData',
        type: "post",
        data: {
            'item_id': material_items.value,
            'vendor_id': $('#issue_from_vendor_id').val()
        },
        dataType: 'json',
        success: function(response) {

            if (response.result) {

                $('input[name="material_items[' + row_index + '][rate]"]').val(response.data_item.rate);

                var unitElement = $('select[name="material_items[' + row_index + '][item_unit_id]"]');
                var weightElement = $('select[name="material_items[' + row_index + '][weight_item_unit_id]"]');


                $('#unitElement').empty();
                // Append new options to the <select> element
                unitElement.empty();
                $.each(response.data, function(index, option) {
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
                console.log("as")
                // var batch_no = $('select[name="material_items['+row_index+'][batch_no]"]');
                // batch_no.empty();
                // batch_no.append($('<option>', {
                //     value: '',
                //     text: 'Select Batch' // You can customize the label here
                // }));

                // $.each( response.batch_info, function (index, option) {

                //     var optionElement = $('<option>', {
                //         value: option.batch_no,
                //         text: option.batch_no+"("+option.qty+")"
                //     });

                //     // Add data attribute using the attr method
                //     optionElement.attr('data-aviable_qty', option.qty);
                //     optionElement.attr('data-expired_date', option.expired_date);
                //     batch_no.append(optionElement);
                // });
                // getValidationMax();
                getBatchwiseUnitWise(material_items);
            } else {
                alert_float('danger', response.reasons);
            }

            //  getAvaliableQuantity(material_items);
        }
    });

    // calculatePOItem(items);
}



function getBatchwiseUnitWise(material_items) {
    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

    var selectElement = $('select[name="material_items[' + row_index + '][items_id]"]');
    var item_unit_id = $('select[name="material_items[' + row_index + '][item_unit_id]"]');


    $.ajax({
        url: base_url + 'admin/PO/getUnitBatchWiseData',
        type: "post",
        data: {
            'item_id': selectElement.val(),
            'item_unit_id': item_unit_id.val(),
            'vendor_id': $('#issue_from_vendor_id').val()
        },
        dataType: 'json',
        success: function(response) {

            if (response.result) {

                var unitElement = $('select[name="material_items[' + row_index + '][item_unit_id]"]');
                var weightElement = $('select[name="material_items[' + row_index + '][weight_item_unit_id]"]');



                var batch_no = $('select[name="material_items[' + row_index + '][batch_no]"]');
                batch_no.empty();
                batch_no.append($('<option>', {
                    value: '',
                    text: 'Select Batch' // You can customize the label here
                }));

                $.each(response.batch_info, function(index, option) {
                   // console.log(option)
                    var optionElement = $('<option>', {
                        value: option.batch_no,
                        text: option.batch_no + "(" + option.qty + ")"
                    });

                    // Add data attribute using the attr method
                    optionElement.attr('data-aviable_qty', option.qty);
                    optionElement.attr('data-expired_date', option.expired_date);
                    optionElement.attr('data-rate', option.rate);
                    optionElement.attr('data-item_rate_type', option.item_rate_type);
                    optionElement.attr('data-item_weight', option.item_weight);
                    optionElement.attr('data-weight_per_qty', option.weight_per_qty);
                    optionElement.attr('data-weight_per_rate', option.weight_per_rate);
                    
                    


                    batch_no.append(optionElement);
                });
                getValidationMax();

            } else {
                alert_float('danger', response.reasons);
            }

            //  getAvaliableQuantity(material_items);
        }
    });

    // calculatePOItem(items);
}

function getAvaliableQuantity(material_items) {
    // alert("ds")
    var name = material_items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    //  console.log("row_index="+row_index)
    var selectElement = $('select[name="material_items[' + row_index + '][items_id]"]');
    var batch_no = $('select[name="material_items[' + row_index + '][batch_no]"]');
    var item_unit_id = $('select[name="material_items[' + row_index + '][item_unit_id]"]');

    var selectedOption = batch_no.find('option:selected');
    console.log(selectedOption)
    var aviableQty = selectedOption.data('aviable_qty');
    var expired_date = selectedOption.data('expired_date');
    var rate = selectedOption.data('rate');
    var item_rate_type = selectedOption.data('item_rate_type');
    if(item_rate_type==2){
         var weight_per_rate = selectedOption.data('weight_per_rate');
         $('input[name="material_items[' + row_index + '][rate]"]').val(weight_per_rate);
    }else{
         $('input[name="material_items[' + row_index + '][rate]"]').val(rate);
    }


    $('input[name="material_items[' + row_index + '][available_qty]"]').val(aviableQty);
    $('input[name="material_items[' + row_index + '][expired_date]"]').val(expired_date);
   


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

function getValidationMax() {
    $(".po_items_select").each(function() {
        element_name = $(this)[0].name;

        var match = element_name.match(/\[([^\]]+)\]/);
        var x = match ? match[1] : null;

        var unitElement = $('select[name="material_items[' + x + '][batch_no]"]');
        var item_unit = $('input[name="material_items[' + x + '][item_unit]"]');

        var selectedOption = unitElement.find('option:selected');
        var aviableQty = selectedOption.data('aviable_qty');
        console.log("aviableQty" + aviableQty);
        $('input[name="material_items[' + x + '][available_qty]"]').val(aviableQty)
        // $(item_unit).attr('max', aviableQty);

    });
}


function display_issued_to(material_items) {
    var name = material_items.name;
    var match = name.match(/\[([^\]]+)\]/);
    var x = match ? match[1] : null;

    var display_type_issued = $('input[name="material_items[' + x + '][issue_to]"]:checked').val();

    if (display_type_issued == 1) {
        $('[name="material_items[' + x + '][emp_issued_to]"]').show();
        $('[name="material_items[' + x + '][vehicle_issed_to]"]').hide();
        $('[name="material_items[' + x + '][other_issued]"]').hide();

    } else if (display_type_issued == 2) {
        $('[name="material_items[' + x + '][emp_issued_to]"]').hide();
        $('[name="material_items[' + x + '][vehicle_issed_to]"]').show();
        $('[name="material_items[' + x + '][other_issued]"]').hide();


    } else if (display_type_issued == 3) {
        $('[name="material_items[' + x + '][emp_issued_to]"]').hide();
        $('[name="material_items[' + x + '][vehicle_issed_to]"]').hide();
        $('[name="material_items[' + x + '][other_issued]"]').show();

    }
}

function getIssueQuantity(evt, element) {
    if (evt.key === 'Tab' || evt.key === 'Enter') {
        // evt.preventDefault();
        // alert("sd")
        calculateFinalAMount(element)
    }
}

function getIssueRate(evt, element) {
    if (evt.key === 'Tab' || evt.key === 'Enter') {
        // evt.preventDefault();
        // alert("sd")
        calculateFinalAMount(element)
    }
}



function calculateFinalAMount(element) {

    var name = element.name;
    console.log(name);
    var match = name.match(/\[([^\]]+)\]/);

    var row_index = match ? match[1] : null;
    
    var batchNoElement = $('select[name="material_items[' + row_index + '][batch_no]"]');
    var selectedOption = batchNoElement.find('option:selected');
    var item_rate_type = parseInt(selectedOption.data('item_rate_type'));
    var weight_per_qty = selectedOption.data('weight_per_qty');
    var weight_per_rate = selectedOption.data('weight_per_rate');
   console.log("item_rate_type"+item_rate_type);
        
    let items_unit = parseFloat($('input[name="material_items[' + row_index + '][item_unit]"]').val()).toFixed(2);;
    let rate = parseInt($('input[name="material_items[' + row_index + '][rate]"]').val());
    let weight = $('input[name="material_items[' + row_index + '][weight]"]').val();
    //if(isEmpty(weight)|| weight==0 || weight==0.00){
         
  //  }
    
    if(item_rate_type==2){
        weight = items_unit * weight_per_qty;
          $('input[name="material_items[' + row_index + '][weight]"]').val(weight);
     
         console.log("weight"+weight);
      //  $('input[name="material_items[' + row_index + '][weight]"]').val(weight);
      //  $('input[name="material_items[' + row_index + '][rate]"]').val(rate);
        final_total=items_unit*rate;
    }else{
        final_total = items_unit * rate;
    }
   
    $('input[name="material_items[' + row_index + '][amount]"]').val(parseFloat(final_total).toFixed(2));
}




function remove_material_file_attch(material_file_attachment_id) {
    // alert(po_attachment_id);
    $.ajax({
        url: base_url + 'admin/store/MaterialIssue/remove_material_file_attachment',
        type: 'post',
        dataType: 'json',
        data: {
            'material_file_attachment_id': material_file_attachment_id,
        },
        success: function(response) {
            if (response.result == true) {
                // alert_float('success', response.reason);
                $('#remove_material_file_attch_' + material_file_attachment_id).remove();

            } else {
                // alert_float('danger', response.reason);
            }

        }

    });
}

function getVendorSiteData() {
    let vendorId = $('#vendorId').val();
    let transportId = $('#vendorId').val();
    let type = $('#type').val();
    if (type == 2) {
        $.ajax({
            url: base_url + 'admin/Vendor/listVendorName',
            type: "post",
            dataType: 'json',
            success: function(response) {

                if (response) {
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

function submitIssue() {
    var EmptyInputs = CheckEmptyInputs();
    console.log("EmptyInputs" + EmptyInputs)
    let po_final_amount = parseFloat($('#po_final_amount').val());

    if ($("#frm_issue").valid() && EmptyInputs == 0) {

        Swal.fire({
            title: 'Are you sure ?',
            // text: msg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {

            if (result.value) {
                $(':disabled').each(function(e) {
                    $(this).removeAttr('disabled');
                })
                // var form = $(this).parents('form');
                // form.submit();
                document.forms["frm_issue"].submit();
            } else {
                //  event.preventDefault();
                return false;
            }

        });


    } else {
        msg1 = "Some Field Required";
        if (!$("#frm_issue").valid()) {
            msg1 = "Some Field Required";
        } else if (EmptyInputs > 0) {
            msg1 = "Empty ITEMS Found. Please fill all the required (*) values.";
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

    $(".po_items_select").each(function() {
        element_name = $(this)[0].name;

        var match = element_name.match(/\[([^\]]+)\]/);
        var x = match ? match[1] : null;
        var style = $(this).closest('.main_tbl_reapter').css('display');

        if (style != "none") {
            let item_group_id = ($('select[name="material_items[' + x + '][item_group_id]"]').val());
            let items_id = ($('select[name="material_items[' + x + '][items_id]"]').val());
            let item_unit_id = ($('select[name="material_items[' + x + '][item_unit_id]"]').val());
            console.log(item_group_id)
            console.log(items_id)
            console.log(item_unit_id)
            if (isEmpty(item_group_id) && item_group_id != 'all') {
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
// $('.item_unit').on('blur', function() {
//     // Validate the form after the input loses focus
//  $(this).valid();
// });
$.validator.addMethod("availableQty", function(value, element) {
    var type = $('#type').val();

    if (this.optional(element) || /^-?\d+(\.\d+)?$/.test(value)) {


        var currentQty = parseFloat(value);
        var match = element.name.match(/\[([^\]]+)\]/);
        var row_index = match ? match[1] : null;

        var items_id = parseInt($('select[name="material_items[' + row_index + '][items_id]"]').val());
        var batch_no = $('select[name="material_items[' + row_index + '][batch_no]"]').val();
        var item_unit_id = parseInt($('select[name="material_items[' + row_index + '][item_unit_id]"]').val());



        var available_qty = parseInt($('input[name="material_items[' + row_index + '][available_qty]"]').val());;
        console.log("s" + available_qty);
        if (type == 3) {
            // Validation logic for type 3
            var old_issue_qty = parseInt($('input[name="material_items[' + row_index + '][old_issue_qty]"]').val());
            var old_batch_no = $('input[name="material_items[' + row_index + '][old_batch_no]"]').val();
            var old_issue_qty_unit = parseInt($('input[name="material_items[' + row_index + '][old_issue_qty_unit]"]').val());
            var batch_no = $('select[name="material_items[' + row_index + '][batch_no]"]').val();
            var item_unit_id = parseInt($('select[name="material_items[' + row_index + '][item_unit_id]"]').val());

            // console.log(old_batch_no)
            // console.log(batch_no)
            if (!isEmpty(old_issue_qty)) {
                if (old_batch_no == batch_no) {
                    // Same batch number logic
                    console.log(old_issue_qty_unit)
                    console.log(item_unit_id)
                    if (old_issue_qty_unit == item_unit_id) {
                        // Your condition here
                        new_qty = 0;
                        if (old_issue_qty < currentQty) {
                            new_qty = currentQty - old_issue_qty;
                            // console.log("new_qty="+new_qty)
                            //check new qty
                            if (new_qty <= available_qty) {
                                return true;
                            } else {
                                $.validator.messages.availableQty = "Stock not available. Available quantity: " + available_qty;
                                return false;
                            }
                        } else {
                            return true;
                        }
                    } else {
                        // Quantity comparison
                        if (available_qty >= currentQty) {
                            return true;
                        } else {
                            $.validator.messages.availableQty = "Stock not available. Available quantity: " + available_qty;
                            return false;
                        }
                    }
                } else {
                    // Different batch number logic
                    console.log(available_qty + ">=" + currentQty)
                    if (available_qty >= currentQty) {
                        return true;
                    } else {
                        $.validator.messages.availableQty = "Stock not available. Available quantity: " + available_qty;
                        return false;
                    }
                }
            } else {
                var selectedOption = $('select[name="material_items[' + row_index + '][batch_no]"]').find('option:selected');
                var available_qty = selectedOption.data('aviable_qty');
                if (available_qty >= currentQty) {
                    return true;
                } else {
                    $.validator.messages.availableQty = "Stock not available. Available quantity: " + available_qty;
                    return false;
                }
            }

        } else {
            // Validation logic for other types
            if (available_qty >= currentQty) {
                return true;
            } else {
                $.validator.messages.availableQty = "Stock not available. Available quantity: " + available_qty;
                return false;
            }
        }
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

$("#on_date").change(function() {
    var on_date = $('#on_date').val();
    // alert(on_date);
    if (on_date != 6) {
        material_issue_filter();
        $('.on_date').hide();
    } else {
        $('.on_date').show();
    }
});


$('#company_id').select2({
    ajax: {
        url: base_url + 'admin/Common/listCompanyName',
        dataType: 'json',
        delay: 250,
        data: function(data) {
            return {
                searchTerm: data.term,
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

$('#site_id').select2({
    ajax: {
        url: base_url + 'admin/Common/listSite',
        dataType: 'json',
        delay: 250,
        data: function(data) {

            return {
                searchTerm: data.term,
                company_id: $('#company_id').val()
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
$(document).ready(function() {
    $('#material_issue_tbl tbody').on('click', 'tr img', function(event) {
        var id = $(this).data('id');
        event.preventDefault(); // Prevent the default action of the link
        var tr = $(this).closest('tr');
        var row = material_issue_tbl.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.ajax({
                url: base_url + 'admin/store/MaterialIssue/InnearItemTableData',
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
        url: base_url + 'admin/Common/list_item_name',
        dataType: 'json',
        delay: 250,
        data: function(data) {

            return {
                searchTerm: data.term,
                'item_group_name_id': $('#id_itemgroup').val()

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

function clearItems(items) {
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