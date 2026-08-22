function po_filter() {

    listItemsData(data);

}

var item_list = '';

function listItemsData(data = '') {

    item_list = $('#item_list_tbl').DataTable({
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
            url: base_url + 'admin/PO/listItemsData',
            type: 'POST',
            dataSrc: "data",
            data: data,
        },
        // columnDefs: [{responsivePriority: 1 ,targets: 5}],

        // columns: [        
        //     { title: "Sr._No.", orderable:false },
        //     {  title: "Item" },  
        //     {  title: "Item Description" },
        //     {  title: "Other Description" },
        //     {  title: "Technical Description" },
        //     {  title: "Dispatch_1 Lot Date" },
        //     {  title: "Dispatch_1 Lot Qty" },
        //     {  title: "Total AMount" , orderable:false, "className": "text-center"},
        // ],

    });

}

$('.item_group_select2').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/PO/listItemGroup',
        dataType: 'json',
         allowClear: true,
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

function getItemList(items ,type=0,current_row=0,item_id='') {
    if(type==1 && item_id ){
        // Extract the content between the brackets (including the brackets)
        var row_index = current_row;
         item_group_id= $('select[name="items[' + row_index + '][item_group_id]"]').val();
    }else{
         var name = items.name;

        // Regular expression to match the content between the first pair of square brackets
        var match = name.match(/\[([^\]]+)\]/);
    
        // Extract the content between the brackets (including the brackets)
        var row_index = match ? match[1] : null;
        
        item_group_id=items.value;
    }
   
    console.log("row_index="+row_index)
      console.log("item_group_id="+item_group_id)
      
    var selectElement = $('select[name="items[' + row_index + '][items_id]"]');
    $.ajax({
        url: base_url + 'admin/PO/getItemData',
        type: "post",
        data: {
            'item_group_id': item_group_id
        },
        dataType: 'json',
        success: function(response) {
            // console.log(response.data)
            if (response.result) {
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
                
                // if(item_id){
                //     //  var defaultValues = [item_id];
                //     //  selectElement.val(defaultValues).trigger('change.select2');
                // }else{
                //      var defaultValues = ["", ""];
                //         selectElement.val(defaultValues).trigger('change.select2');
                // }
               
                 var defaultValues = ["", ""];
                        selectElement.val(defaultValues).trigger('change.select2');
            } else {
                alert_float('danger', response.reasons);
            }


        }
    });
}

function getItemUnits(items) {
    var event = items;
    var name = items.name;
    var vendor_id = $('#vendor_id').val();

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

    var selectElement = $('select[name="items[' + row_index + '][items_id]"]');
    $.ajax({
        url: base_url + 'admin/PO/getItemUnitsData',
        type: "post",
        data: {
            'item_id': items.value,
            'vendor_id': vendor_id
        },
        dataType: 'json',
        success: function(response) {

            if (response.result) {

                $('input[name="items[' + row_index + '][item_hsc_code]"]').val(response.data_item.hsn_code)

                if (response.data_item.item_rate == null) {
                    $('input[name="items[' + row_index + '][item_unit_rate]"]').val(response.data_item.rate)
                } else {
                    $('input[name="items[' + row_index + '][item_unit_rate]"]').val(response.data_item.item_rate)
                }


                var unitElement = $('select[name="items[' + row_index + '][item_unit_id]"]');
                unitElement.empty();
                // Append new options to the <select> element
                $.each(response.data, function(index, option) {
                    unitElement.append($('<option>', {
                        value: option.item_unit_id,
                        text: option.short_name
                    }));
                });
                getItemUnitsStock(event)

            } else {
                alert_float('danger', response.reasons);
            }


        }
    });
    // calculatePOItem(items);
}

function clearItems(items){
      var name = items.name;
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

   $('select[name="items[' + row_index + '][items_id]"]').val(null).trigger("change");;
    $('select[name="items[' + row_index + '][item_group_id]"]').val(null).trigger("change");;
    
  
}
function getItemUnitsStock(items) {
    var name = items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;

    var selectElement = $('select[name="items[' + row_index + '][items_id]"]');
    var item_unit = $('select[name="items[' + row_index + '][item_unit_id]"]').val();
    console.log(items.value)
    console.log(item_unit)

    $.ajax({
        url: base_url + 'admin/PO/getItemUnitsStock',
        type: "post",
        data: {
            'item_id': items.value,
            'item_unit_id': item_unit
        },
        dataType: 'json',
        success: function(response) {

            if (response.result) {

                $('input[name="items[' + row_index + '][item_stock_qty]"]').val(response.stock)

            } else {
                alert_float('danger', response.reasons);
            }
            $('[name="items[' + row_index + '][tbl_item_rate_update_html]"]').html(response.html_data);

        }
    });
    // calculatePOItem(items);
}

function add_value(element) {

    // Get the selected option
    var selectedOption = $(element).find(":selected");

    // Access the data attribute
    var tax_rate = selectedOption.data("tax_rate");
    var name = element.name;

    var match = name.match(/\[([^\]]+)\]/);

    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)

    // Display the data attribute value
    // console.log("Selected Option Price: " + tax_rate);
    $('input[name="items[' + row_index + '][tax_rate]"]').val(tax_rate)

    calculatePOItem(element)

}

function add_value_additional(element) {

    // Get the selected option
    var selectedOption = $(element).find(":selected");

    // Access the data attribute
    var tax_rate = selectedOption.data("tax_rate");
    var name = element.name;

    var match = name.match(/\[([^\]]+)\]/);

    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)

    // Display the data attribute value
    // console.log("Selected Option Price: " + tax_rate);
    $('input[name="items[' + row_index + '][additional_tax_rate]"]').val(tax_rate);

    calculatePOItem(element);


}
$('.get_vendor').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/Vendor/listVendorName',
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

$('#billing_site_id').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/Common/listSite',
        dataType: 'json',
        delay: 250,
        data: function(data) {

            return {
                searchTerm: data.term,
                company_id: company_id, // search term
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
$('#delivery_site_id').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/Common/listSite',
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

function CheckEmptyInputs() {
    var empty_count = 0;
    $(".po_items_select").each(function() {
        element_name = $(this)[0].name;
        var match = element_name.match(/\[([^\]]+)\]/);
        var x = match ? match[1] : null;

        console.log(element_name)

        let item_group_id = ($('select[name="items[' + x + '][item_group_id]"]').val());
        let items_id = ($('select[name="items[' + x + '][items_id]"]').val());
        let item_unit_id = ($('select[name="items[' + x + '][item_unit_id]"]').val());
        let item_rate = ($('input[name="items[' + x + '][item_rate]"]').val())
        let item_final_amount = ($('input[name="items[' + x + '][item_final_amount]"]').val())
        let item_rate_type = ($('select[name="items[' + x + '][item_rate_type]"]').val())

        if (isEmpty(item_group_id) && item_group_id!='all') {
            empty_count++;
            console.log("item_group_id" + item_group_id)
        }
        if (isEmpty(items_id)) {
            empty_count++;
            console.log("items_id" + items_id)
        }
        if (isEmpty(item_unit_id)) {
            empty_count++;
            console.log("item_unit_id" + item_unit_id)
        }
        if (isEmpty(item_rate)) {
            empty_count++;
            console.log("item_rate" + item_rate)
        }
        if (isEmpty(item_final_amount)) {
            empty_count++;
            console.log("item_final_amount" + item_final_amount)
        }

    });
    return empty_count;
}

function submitPO() {
    var EmptyInputs = CheckEmptyInputs();
    console.log("EmptyInputsPO" + EmptyInputs)
    let po_final_amount = parseFloat($('#po_final_amount').val());
    let amount_zero_flag = 0;
    $(".po_items_select").each(function() {
        //item_rate_type if weight that case item_final_amould should be zero
        element_name = $(this)[0].name;
        var match = element_name.match(/\[([^\]]+)\]/);
        var x = match ? match[1] : null;

        console.log("element_name" + element_name)

        let item_group_id = ($('select[name="items[' + x + '][item_group_id]"]').val());
        let items_id = ($('select[name="items[' + x + '][items_id]"]').val());
        let item_unit_id = ($('select[name="items[' + x + '][item_unit_id]"]').val());
        let item_rate = ($('input[name="items[' + x + '][item_unit_rate]"]').val());
        let item_rate_type = ($('select[name="items[' + x + '][item_rate_type]"]').val())
        let item_final_amount = ($('input[name="items[' + x + '][item_final_amount]"]').val());
        let item_weight = ($('input[name="items[' + x + '][item_weight]"]').val())

        console.log("item_rate_type" + item_rate_type);
        console.log("item_final_amount" + item_final_amount)
        console.log("item_weight" + item_weight)
        if (parseInt(item_rate_type) == 1 && parseInt(item_final_amount) == 0) {
            console.log("item_rate_type" + item_rate_type)
            console.log("item_final_amount" + item_final_amount)
            amount_zero_flag = 1;
            console.log("amount_zero_flag   sasa" + item_rate)
        } else if (parseInt(item_rate_type) == 2 && (isEmpty(item_rate) || (parseInt(item_rate) == 0))) {
            console.log("item_rate_type" + parseInt(item_rate_type))
            console.log("item_rate" + item_rate)
            amount_zero_flag = 1;
            console.log("amount_zero_flag   sasa12" + item_rate)
        }

    });
    console.log("amount_zero_flag=" + amount_zero_flag);
    if ($("#frm_po").valid() && amount_zero_flag != 1 && EmptyInputs == 0) {

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
                document.forms["frm_po"].submit();
            } else {
                //  event.preventDefault();
                return false;
            }

        });


    } else {
        msg1 = "Some Field Required";
        if (!$("#frm_po").valid()) {
            msg1 = "Some Field Required";
        } else if (EmptyInputs > 0) {
            msg1 = "Empty ITEMS Found. Please fill all the required (*) values.";
        } else if (amount_zero_flag == 0) {
            msg1 = "Total Amount Not be Zero ";
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
$(document).ready(function() {
    po_filter();

    setBillingaddress();
    if (!isEmpty($('#id').val())|| $('#type').val() ==1 || $('#type').val() ==2) {
        getVendorSiteData();
    }

});

function po_filter() {
    var data = {
        'vendor_id': $("#vendor_id").val(),
        'company_id': $("#company_id").val(),
        'site_id': $("#site_id").val(),
        'on_date': $("#on_date").val(),
        'from_date': $("#from_date").val(),
        'to_date': $("#to_date").val(),
        'item_id':$("#item_id").val(),
        'cost_project_id':$("#cost_project_id").val(),

    };
    listPO(data);
    listtermconditions(data);
}

var tbl_po = '';

function listPO(data = '') {

    tbl_po = $('#tbl_po').DataTable({
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
            url: base_url + 'admin/PO/listPo',
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
                title: "PO Order No"
            },
            {
                title: "Po Date"
            },
            {
                title: "Vendor Name"
            },
            {
                title: "Total Item Qty"
            },
            {
                title: "User Name"
            },
            {
                title: "Status"
            },
            {title: "Cost Project Name"},
            {
                title: "Action",
                orderable: false,
                "className": "text-center"
            },
        ],

    });

}


function getVendorSiteData() {
    let vendorId = $('#vendorId').val();
    let billingSiteId = $('#billingSiteId').val();
    let deliverySiteId = $('#deliverySiteId').val();
    let deliveryPartyId = $('#deliveryPartyId').val();


    $.ajax({
        url: base_url + 'admin/Vendor/listVendorName',
        type: "post",
        dataType: 'json',
        success: function(response) {

            if (response) {
                $(".get_vendor").select2({
                    data: response
                })
                $("#delivery_party_id").val(deliveryPartyId);
                // alert(deliveryPartyId)
                $('#delivery_party_id').trigger('change');

                $('#vendor_id').val(vendorId);
                $('#vendor_id').trigger('change');
                // alert(vendorId)
            }
        }
    });

    $.ajax({
        url: base_url + 'admin/Common/listSite',
        type: "post",
        dataType: 'json',
        success: function(response) {

            if (response) {
                $("#delivery_site_id").select2({
                    data: response
                })
                // $("#delivery_site_id").select2("val", deliverySiteId);        
                $('#delivery_site_id').val(deliverySiteId);
                $('#delivery_site_id').trigger('change');
            }
        }
    });

    $.ajax({
        url: base_url + 'admin/Common/listSite',
        type: "post",
        dataType: 'json',
        data: {
            'company_id': company_id,
        },
        success: function(response) {

            if (response) {
                $("#billing_site_id").select2({
                    data: response
                })
                // $("#billing_site_id").select2("val", billingSiteId);  
                $('#billing_site_id').val(billingSiteId);
                $('#billing_site_id').trigger('change');
            }
        }
    });


}
$(".numberonly").keypress(function(e) {
    var kk = e.which;
    if (kk < 48 || kk > 57)
        e.preventDefault();
});

function getPOListingVendorSiteData() {
    $('.on_date').hide();
    $('#vendor_id').select2({
        // placeholder: 'Select an state',
        ajax: {
            url: base_url + 'admin/Vendor/listVendorName',
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
    $('#site_id').select2({
        // placeholder: 'Select an state',
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

}
$("#on_date").change(function() {
    var on_date = $('#on_date').val();
    // alert(on_date);
    if (on_date != 6) {
        po_filter1();
        $('.on_date').hide();
    } else {
        $('.on_date').show();
    }
});


function submit_update_status() {
    var po_status = $('#chg_status').val();
    var po_id = $('.idpo').val();
    var reject_reason = $('.reject_reason').val();
    $.ajax({
        url: base_url + 'admin/PO/submit_update_status',
        type: 'post',
        dataType: 'json',
        data: {
            'po_id': po_id,
            'po_status': po_status,
            'reject_reason': reject_reason
        },
        success: function(response) {
            // console.log(response);
            if (response.result) {
                alert_float('success', response.reason);
                setTimeout(function() {
                    window.location.reload();
                }, 2900);
            } else {
                alert_float('danger', response.reason);
            }
        }
    });
}

$('.idemail').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/PO/listEmails',
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

$('.vendor_email_id').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/PO/listVendorEmails',
        dataType: 'json',
        delay: 250,
        data: function(data) {

            return {
                searchTerm: data.term,
                vendor_id: $('.id_vendor').val(),
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


// var po_status = $('#chg_status').val();
// var po_id = $('.idpo').val();
// var reject_reason = $('.reject_reason').val();
// $.ajax({
//     url: base_url + 'admin/PO/submit_update_status',
//     type: 'post',
//     dataType: 'json',
//     data: {
//         'po_id': po_id,
//         'po_status': po_status,
//         'reject_reason': reject_reason
//     },
//     success: function(response) {
//         // console.log(response);
//         if (response.result) {
//             alert_float('success', response.reason);
//             setTimeout(function() {
//                 window.location.reload();
//             }, 2900);
//         } else {
//             alert_float('danger', response.reason);
//         }
//     }
// });


function remove_db_file_attch(po_attachment_id) {
    // alert(po_attachment_id);
    $.ajax({
        url: base_url + 'admin/PO/remove_po_attachment',
        type: 'post',
        dataType: 'json',
        data: {
            'po_attachment_id': po_attachment_id,
        },
        success: function(response) {
            if (response.result == true) {
                // alert_float('success', response.reason);
                $('#remove_file_attch_' + po_attachment_id).remove();
                // $('#remove_file_attch_id_'+po_attachment_id).remove();

            } else {
                // alert_float('danger', response.reason);
            }

        }

    });
}


function listtermconditions(data = '') {

    termconditions = $('#tbl_termconditions').DataTable({
        "dom": 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div'
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 10,
        order: [
            [1, "desc"]
        ],
        ajax: {
            url: base_url + 'admin/Po/listtermconditions',
            type: 'POST',
            dataSrc: "data",
            data: data,
        },

        columns: [{
                "width": "10%",
                title: "X",
                orderable: false
            },
            {
                "width": "20%",
                title: "Sr._No."
            },
            // { "width": "20%", title: "Email" },
            {
                "width": "20%",
                title: "Title"
            },
            {
                "width": "20%",
                title: "Particulars"
            },
            // { "width": "20%", title: "Total Amount" },  
            // { "width": "20%", title: "Action" , orderable:false, "className": "text-center"},
        ],
    });

}
$('.term_master_modal').on('click', function() {
    term_master_modal();
});

function term_master_modal(id = '', type = 1) {

    $.ajax({
        url: base_url + 'admin/PO/getTermCondition',
        type: 'POST',
        data: {
            'id': id
        },
        dataType: 'json',
        success: function(res) {
            console.log(res.html)
            $('#tbl_po_terms_condition_html').html();
            if (res.result == true) {
                $('#tbl_po_terms_condition_html').html(res.html);
                $('#termsConditionHtml').modal('show');
                // $("#catdrop").select2();
            } else {
                alert_float('error', response.reason);
            }
        }
    })
}

function saveTermsCondition() {

    let title = $('#title').val();
    let particulars = $('#particulars').val();

    if (particulars) {

        $.ajax({
            url: base_url + 'admin/PO/saveTermConditions',
            type: 'POST',
            data: {
                'title': title,
                'particulars': particulars
            },
            dataType: 'json',
            success: function(res) {
                if (res.result == true) {
                    term_master_modal('', 2);
                } else {
                    alert_float('error', response.reason);
                }
            }
        });
    }


}

function setBillingaddress() {
    $.ajax({
        url: base_url + 'admin/Common/listSite',
        type: "post",
        dataType: 'json',
        data: {
            'company_id': company_id,
        },
        success: function(response) {

            if (response) {
                $("#billing_site_id").select2({
                    data: response
                })

                console.log(site_id);

                $('#billing_site_id').val(site_id); // Select the option with a value of '1'
                $('#billing_site_id').trigger('change');
            }
        }
    });


}

//  $('.termconditionsModal').on('click', function() {
//   termconditionsModal();
// });

// function termconditionsModal(id='') {

//   $.ajax({
//         url: base_url +'admin/Po/termconditionsModal',
//         type: 'POST',
//         data: {'id':id},
//         dataType:'json',
//         success: function(res) {
//             $('#_banner').html();
//           if (res.result == true) {
//             $('#_banner').html(res.html);
//             $('#termconditionsModal').modal('show');
//             // $("#catdrop").select2();
//           }else{
//             alert_float('error',response.reason);
//           }
//         }
//     })
// }
$(document).ready(function() {
$('#tbl_po tbody').on('click', 'tr img', function (event) {
    var id = $(this).data('id');
    event.preventDefault(); // Prevent the default action of the link
    var tr = $(this).closest('tr');
    var row = tbl_po.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        $.ajax({
            url: base_url + 'admin/PO/InnearItemTableData',
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
  
$('.get_cost_project').select2({
    // placeholder: 'Select an state',
    ajax: {
        url:base_url +'admin/Common/list_cost_project',   
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


$('.project_cost').select2({
        ajax: {
            url:base_url +'admin/Common/list_cost_project',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term
                    // 'item_group_name_id':$('#id_itemgroup').val()
                    
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
