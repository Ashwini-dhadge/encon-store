function filter_indent() {
    var type = $("#type").val();
    var indentid = 2;
    var data = {
        type: type,
        indentid: indentid,
        from_date: $("#from_date").val(),
        to_date: $("#to_date").val()
    };
    listHubindent(data);
    listReceivedOrders(data);
}
$(document).on("click", "#dateFilterBtn", function () {
    filter_indent();
});

$(document).on("click", "#dateResetBtn", function () {
    $("#from_date").val("");
    $("#to_date").val("");
    filter_indent();
});

var bladeindent = "";
function listHubindent(data = "") {
    bladeindent = $("#blade_indent").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[1, "desc"]],
        ajax: {
            url: base_url + "admin/production/Indent/list_hub",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [
            {
                width: "3%",
                title: `
        <input type="checkbox"
        id="select_all_frphp">
    `,
                orderable: false
            },
            { width: "5%", title: "Sr._No.", orderable: false },

            { width: "5%", title: "Client Name" },
            // { width: "5%", title: "Plant Name" },
            { width: "5%", title: "Project Number" },
            { width: "5%", title: "Indent Mannual No" },
            { width: "10%", title: "Date" },
            {
                width: "10%",
                title: "Action",
                orderable: false,
                className: "text-center",
            },
        ],
    });
}
$(document).ready(function () {
    $("#details").hide();
    filter_indent();
});

var receivedOrderTable = "";
function listReceivedOrders(data = "") {
    receivedOrderTable = $("#receivedOrders").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[1, "desc"]],
        ajax: {
            url: base_url + "admin/production/Indent/list_hub_received_orders",
            type: "POST",
            dataSrc: "data",
            data: data,
        },

        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [

            {
                title: "Action",
                orderable: false
            },
            { title: "Order Type" },
            { title: "Order Number" },
            { title: "Manual No" },
            { title: "Date" },
            { title: "Client" },
            { title: "Total Qty" },
            { title: "Order Qty" },

            { title: "HP Machining" },
            { title: "HP Inspection" },
            { title: "HP Galvanising" },
            { title: "HP Painting" },

            { title: "HS Machining" },
            { title: "HS Final Mach." },
            { title: "HS Inspection" },
            { title: "HS Painting" },

            { title: "Clamp Machining" },
            { title: "Clamp Inspection" },
            { title: "Clamp Painting" },

            { title: "HW Forging" },
            { title: "HW Machining" },
            { title: "HW Inspection" },

            { title: "Assembly" },
            { title: "Inspection Overall" },
            { title: "Dynamic Balancing" },
            { title: "Packing" },
            { title: "Dispatch" },

        ]
    });
}
$(document).on('change', '#select_all_frphp', function () {

    $('.header_pipe_checkbox').prop(
        'checked',
        $(this).prop('checked')
    );

});


function getSelectedHPRows() {
    let selected = [];

    $('.header_pipe_checkbox:checked').each(function () {

        selected.push($(this).val());

    });

    return selected;
}

$(document).on('click', '#export_selected_pdf', function () {

    let selected = getSelectedHPRows();

    if (selected.length == 0) {

        alert('Please select rows');

        return;
    }

    let url =
        base_url +
        'admin/production/Indent/export_selected_hub_pdf?ids=' +
        selected.join(',');

    window.open(url, '_blank');

});


$(document).on('click', '#export_selected_excel', function () {

    let selected = getSelectedHPRows();

    if (selected.length == 0) {

        alert('Please select rows');

        return;
    }

    let url =
        base_url +
        'admin/production/Indent/export_selected_hub_excel?ids=' +
        selected.join(',');

    window.open(url, '_blank');

});

