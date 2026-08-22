function filter_customer() {
    var type = $("#type").val();
    var status_data = $("#status_id").val();
    var customer_id = $("#customer_id").val();
    var plant_id = $("#plantid").val();
    // var company_name = $('#company_name').val();
    // var company_id = $('#companynm').val();
    // var company_id = $('#company_id').val();
    // alert(status_data);
    var data = {
        status_id: status_data,
        customer_id: customer_id,
        plant_id: plant_id,
        // 'company_name' :company_name,
        // 'company_id' :company_id,
    };
    listcustomer(data);
    list_opportunity_tracker(data);
    list_customer_plant_info(data);
    list_customer_contact_details(data);
}

var customer = "";
function listcustomer(data = "") {
    customer = $("#customer").DataTable({
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
            url: base_url + "admin/sales/Customer/listcustomer",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [
            { width: "5%", title: "Sr._No.", orderable: false },

            { width: "5%", title: "Company Name" },
            { width: "10%", title: "Address" },
            { width: "10%", title: "Phone" },
            { width: "10%", title: "Email" },
            { width: "10%", title: "City" },
            { width: "10%", title: "State" },
            { width: "10%", title: "Country" },
            { width: "10%", title: "Currency" },
            { width: "10%", title: "Post Code" },
            { width: "10%", title: "Rate Type" },
            { width: "10%", title: "Vat" },
            // { "width": "10%", title: "District Name" },rto_code
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
    filter_customer();
});

// // -------------------billing------------------------------

//     $('.b_country_name').select2({
//         ajax: {
//             url:base_url +'admin/Common/country_name_list',
//               dataType: 'json',
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

//     $('.b_state_name').select2({
//         ajax: {
//             url:base_url +'admin/Common/state_name_list',
//               dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                     'country_id':$('.b_country_name').val(),

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

//     $('.b_city_name').select2({
//         ajax: {
//             url:base_url +'admin/Common/city_name_list',
//               dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                     'state_id':$('.b_state_name').val(),
//                     'country_id':$('.b_country_name').val(),
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

// // -----------------shipping--------------------------------
//     $('.s_country_name').select2({
//         ajax: {
//             url:base_url +'admin/Common/country_name_list',
//               dataType: 'json',
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

//     $('.s_state_name').select2({
//         ajax: {
//             url:base_url +'admin/Common/state_name_list',
//               dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                     'country_id':$('.s_country_name').val(),

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

//     $('.s_city_name').select2({
//         ajax: {
//             url:base_url +'admin/Common/city_name_list',
//               dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                     'state_id':$('.s_state_name').val(),
//                     'country_id':$('.s_country_name').val(),
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

$(".items").select2({
    ajax: {
        // url:base_url +'admin/Common/listCityName',
        url: base_url + "admin/sales/Customer/listitems",
        dataType: "json",
        delay: 250,
        data: function (data) {
            return {
                searchTerm: data.term,
            };
        },
        processResults: function (response) {
            return {
                results: response,
            };
        },
        cache: true,
    },
});

//  opportunity tracker list against customer
var opportunity_tracker = "";
function list_opportunity_tracker(data = "") {
    opportunity_tracker = $("#tbl_customer_opp_tracker").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[0, "desc"]],
        ajax: {
            url:
                base_url +
                "admin/sales/OpportunityTracker/list_opportunity_customer_tracker",
            type: "POST",
            dataSrc: function (response) {
                // Log total count here
                $(".total_count").text(response.total_count);
                return response.data;
            },
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 5 }],

        columns: [
            { title: "Sr._No.", orderable: false },
            { title: "Title" },
            // {  title: "Customer Name" },
            { title: "Contact Person Name" },
            { title: "Contact Person Mobile No" },
            { title: "Status" },
            { title: "Date" },
            { title: "Action", orderable: false, className: "text-center" },
        ],
    });
}

// -------------------------- customer plant -------------------------------------
// customer plant
var customer_plant = "";
function list_customer_plant_info(data = "") {
  
    customer_plant = $("#tbl_customer_plant").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[0, "desc"]],
        ajax: {
            url: base_url + "admin/sales/Customer/list_customer_plant_info",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 2 }],

        columns: [
            { title: "Sr._No.", orderable: false },
            { title: "Plant Narration" },
            { title: "Billing Company" },
            { title: "Action", orderable: false },
        ],
    });
}

$(".customer_plant_form").on("click", function () {
    customer_plant_form();
});

function customer_plant_form(id = "") {
    var c_id = $("#customer_id").val();
    // alert(c_id);
    $.ajax({
        url: base_url + "admin/sales/Customer/customer_plant_form",
        type: "POST",
        data: { id: id, customer_id: c_id },
        dataType: "json",
        success: function (res) {
            $("#_customer_plant").html();
            if (res.result == true) {
                $("#_customer_plant").html(res.html);
                $("#customer_plant_form").modal("show");
            } else {
                alert_float("error", response.reason);
            }
        },
    });
}

$(".view_customer_plant_data").on("click", function () {
    view_customer_plant_data();
});

function view_customer_plant_data(id = "") {
    // alert(id);
    $.ajax({
        url: base_url + "admin/sales/Customer/view_customer_plant_data",
        type: "POST",
        data: { plant_id: id },
        dataType: "json",
        success: function (res) {
            $("#_view_customer_plant").html();
            if (res.result == true) {
                $("#_view_customer_plant").html(res.html);
                $("#_view_customer_plant_data").modal("show");
            } else {
                alert_float("error", response.reason);
            }
        },
    });
}

$(".deleteBtn").on("click", function () {
    deleteBtn();
});

function deleteBtn(id = "") {
    Swal.fire({
        title: "Are you sure?",
        text: "It will be permanently deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    })
        .then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire("Cancelled", "Item deletion was cancelled.", "info");
                return;
            }

            if (result.value) {
                $.ajax({
                    type: "POST",
                    url:
                        base_url + "admin/sales/Customer/delete_customer_plant",
                    data: {
                        plant_id: id,
                    },
                    dataType: "json",

                    success: function (response) {
                        if (response.result == true) {
                            Swal.fire("Deleted!", response.reason, "success");
                            $("#tbl_customer_plant").DataTable().ajax.reload();
                        } else {
                            Swal.fire("Deleted!", response.reason, "error");
                            $("#tbl_customer_plant").DataTable().ajax.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            "Error!",
                            "Fail to Delete Plant Details",
                            "error"
                        );
                    },
                });
            } else {
                Swal.fire(
                    "Cancelled",
                    "Plant Details deletion was cancelled.",
                    "info"
                );
            }
        })
        .catch((error) => {
            Swal.fire(
                "Error!",
                "An error occurred while deleting the Plant Details.",
                "error"
            );
            console.error("Error:", error);
        });
}

/// chetan code 10-05-2024
// -------------------------- customer contact details -------------------------------------

var customer_plant = "";
function list_customer_contact_details(data = "") {
    customer_plant = $("#tbl_customer_contact_details").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[0, "desc"]],
        ajax: {
            url:
                base_url + "admin/sales/Customer/list_customer_contact_details",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 2 }],

        columns: [
            { title: "Sr._No.", orderable: false },
            { title: "Contact Person" },
            { title: "Mobile No" },
            { title: "Designation" },
            { title: "Action", orderable: false },
        ],
    });
}
/// end chetan code 10-05-2024

/// chetan code 13-05-2024
$(".customer_contact_form").on("click", function () {
    customer_contact_form();
});

function customer_contact_form(id = "") {
    var c_id = $("#customer_id").val();

    //alert(c_id);
    $.ajax({
        url: base_url + "admin/sales/Customer/customer_contact_form",
        type: "POST",
        data: { id: id, customer_id: c_id },
        dataType: "json",
        success: function (res) {
            $("#_customer_contact").html();
            if (res.result == true) {
                $("#_customer_contact").html(res.html);
                $("#customer_contact_form").modal("show");
            } else {
                alert_float("error", response.reason);
            }
        },
    });
}

$(".view_customer_contact_data").on("click", function () {
    view_customer_contact_data();
});

function view_customer_contact_data(id = "") {
    // alert(id);
    $.ajax({
        url: base_url + "admin/sales/Customer/view_customer_contact_data",
        type: "POST",
        data: { contact_id: id },
        dataType: "json",
        success: function (res) {
            $("#_view_customer_contact").html();
            if (res.result == true) {
                $("#_view_customer_contact").html(res.html);
                $("#_view_customer_contact_data").modal("show");
            } else {
                alert_float("error", response.reason);
            }
        },
    });
}

function deleteCustDetailsBtn(id = "") {
    //alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "It will be permanently deleted!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    })
        .then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire("Cancelled", "Item deletion was cancelled.", "info");
                return;
            }

            if (result.value) {
                $.ajax({
                    type: "POST",
                    url:
                        base_url +
                        "admin/sales/Customer/delete_customer_contact_details",
                    data: {
                        contact_id: id,
                    },
                    dataType: "json",

                    success: function (response) {
                        if (response.result == true) {
                            Swal.fire("Deleted!", response.reason, "success");
                            $("#tbl_customer_contact_details")
                                .DataTable()
                                .ajax.reload();
                        } else {
                            Swal.fire("Deleted!", response.reason, "error");
                            $("#tbl_customer_contact_details")
                                .DataTable()
                                .ajax.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            "Error!",
                            "Fail to Delete Customer Contact Details",
                            "error"
                        );
                    },
                });
            } else {
                Swal.fire(
                    "Cancelled",
                    "Contact Details deletion was cancelled.",
                    "info"
                );
            }
        })
        .catch((error) => {
            Swal.fire(
                "Error!",
                "An error occurred while deleting the Contact Details.",
                "error"
            );
            console.error("Error:", error);
        });
}

/// end chetan code 13-05-2024
