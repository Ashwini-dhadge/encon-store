$(document).ready(function() {
    filter_listOCData();
});

function filter_listOCData() {
    var data = {};
    listOCData(data);
}

function listOCData(data = "") {
    var OCListTbl = $("#ocListTbl").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sPrOCessing: '<div class="dt-loader"></div',
        },
        prOCessing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[1, "desc"]],
        ajax: {
            url: base_url + "admin/sales/OC/listOCData",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [
            {
                width: "10%",
                title: "S.No",
                orderable: false,
            },

            { width: "20%", title: "Quotation No" },
            { width: "20%", title: "Customer Name" },
            { width: "20%", title: "Purchase Order No" },
            { width: "10%", title: "Purchase Date" },
            { width: "20%", title: "Subject" },

            {
                width: "20%",
                title: "Action",
                orderable: false,
                className: "text-center",
            },
        ],
    });
}
