function CheckEmptyInputs() {
    var empty_count = 0;
    $(".po_items_select").each(function () {
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

        if (isEmpty(item_group_id) && item_group_id != 'all') {
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
    console.log("amount_zero_flag=" + amount_zero_flag);
    if ($("#frm_po").valid() && amount_zero_flag != 1 && EmptyInputs == 0) {

        Swal.fire({
            title: 'Are you sure ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {

            if (result.value) {
                $(':disabled').each(function (e) {
                    $(this).removeAttr('disabled');
                });

                $('#frm_po').attr('target', '_blank');
                document.forms["frm_po"].submit();
                $('#frm_po').removeAttr('target');

                window.location.href = base_url + 'admin/BoxPO';
            } else {
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
        })
    }
}

function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}

var tbl_po;

$('.get_vendor').select2({
    ajax: {
        url: base_url + 'admin/BoxPO/listVendorName',
        dataType: 'json',
        delay: 250,
        data: function (data) {
            return { searchTerm: data.term };
        },
        processResults: function (response) {
            return { results: response };
        },
        cache: true
    }
});

$('.get_site, #site_id, #company_id').select2({
    placeholder: 'Select Site',
    allowClear: true,
    ajax: {
        url: base_url + 'admin/BoxPO/listSite',
        dataType: 'json',
        delay: 250,
        data: function (data) {
            return {
                searchTerm: data.term || ''
            };
        },
        processResults: function (response) {

            let results = [{
                id: 'all',
                text: 'All'
            }];

            return {
                results: results.concat(response)
            };
        },
        cache: true
    }
});

$('#vendor_id, #site_id, #company_id, #on_date, #from_date, #to_date')
    .on('change', function () {
        po_filter();
    });

let filterApplied = false;
var tbl_po;

$(document).ready(function () {

    tbl_po = $('#tbl_po').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        order: [[0, "desc"]],
        destroy: true,

        ajax: {
            url: base_url + "admin/BoxPO/listBoxPo",
            type: "POST",
            data: function (d) {

                // if (!filterApplied) {
                //     d.skip = 1;   
                //     return;
                // }

                d.vendor_id = $('#vendor_id').val();
                d.company_id = $('#company_id').val();
                d.site_id = $('#site_id').val();
                d.on_date = $('#on_date').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },

        columns: [
            { title: "Sr No" },
            { title: "Box-PO No", width: "10%" },
            { title: "Box-PO Date" },
            { title: "Vendor" },
            { title: "Company" },
            { title: "Site" },
            // { title: "Total Sq.Inch" },
            // { title: "CU FT" },
            // { title: "Cost" },
            // { title: "Status" },
            { title: "PDF", orderable: false },
            { title: "Action", orderable: false }
        ]
    });

});


let filterAppliedView = false;
var tbl_po_view;

$(document).ready(function () {

    tbl_po_view = $('#tbl_po_view').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        order: [[0, "desc"]],
        destroy: true,

        ajax: {
            url: base_url + "admin/BoxPO/listViewBoxPo",
            type: "POST",
            data: function (d) {

                // if (!filterAppliedView) {
                //     d.skip = 1;   // custom flag
                //     return;
                // }

                d.vendor_id = $('#vendor_id').val();
                d.company_id = $('#company_id').val();
                d.site_id = $('#site_id').val();
                d.on_date = $('#on_date').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },

        columns: [
            { title: "Sr No" },
            { title: "Box-PO No" },
            { title: "Box-PO Date" },
            { title: "Vendor" },
            { title: "Company" },
            { title: "Site" },
            // { title: "Total Sq.Inch" },
            // { title: "CU FT" },
            // { title: "Cost" },
            // { title: "Status" },
            { title: "PDF", orderable: false },
            { title: "Action", orderable: false }
        ]
    });

});


function po_filter() {
    filterApplied = true;
    tbl_po.ajax.reload();
}
function po_filter_view() {
    filterAppliedView = true;
    tbl_po_view.ajax.reload();
}

$("#on_date").change(function () {
    if ($(this).val() != 6) {
        $('.on_date').hide();
    } else {
        $('.on_date').show();
    }
});



$(document).on('click', '.btn-view-po', function () {

    let po_id = $(this).data('id');

    $('#tbl_po tr').removeClass('table-active');
    $(this).closest('tr').removeClass('table-active');

    $('#po_details').html(`
        <div class="text-center p-4">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <p>Loading details...</p>
        </div>
    `);

    $.ajax({
        url: base_url + 'admin/BoxPO/ajaxViewBoxPO',
        type: 'POST',
        data: { po_id: po_id },
        success: function (res) {
            $('#po_details').html(res);
        },
        error: function () {
            $('#po_details').html(`
                <div class="alert alert-danger">
                    Failed to load PO details
                </div>
            `);
        }
    });
});
