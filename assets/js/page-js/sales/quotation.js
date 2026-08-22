$(document).ready(function () {
    filter_technicalSpecification();
    filter_FooterNotsData();
    filter_listQuotationData();
    filter_listocHeaderFooterTbl();
    filter_listocFooterTbl();

    $("#checkAll").click(function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

    $("#checkAllFNotes").click(function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

    $("#companyName").select2({
        minimumInputLength: 3,
        ajax: {
            url: base_url + "admin/Common/listCompanyName",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            tags: true,
            cache: true,
        },
    });

    $("#customerName").select2({
        minimumInputLength: 3,
        ajax: {
            url: base_url + "admin/sales/quotation/listCustomerName",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            tags: true,
            cache: true,
        },
    });

    $("#quotationCustomer").select2({
        ajax: {
            url: base_url + "admin/sales/quotation/listCustomerName",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function (data) {
                // Define the "Select All" option
                var selectAllOption = {
                    id: "all",
                    text: "All",
                };

                // Prepend the "Select All" option to the results array
                data.unshift(selectAllOption);

                return {
                    results: data,
                };
            },
            cache: true,
        },
        tags: true,
    });

    // Handle "Select All" option selection
    $("#quotationCustomer").on("select2:select", function (e) {
        if (e.params.data.id === "select-all") {
            // Select all options
            var allOptions = $("#quotationCustomer").find("option");
            allOptions.prop("selected", true);
            $("#quotationCustomer").trigger("change");
        }
    });
});

function getTechnicalSpecifications() {
    $("#technicalSpecificationModel").modal("show");
}

function getFooterNotes() {
    $("#footerNotesModel").modal("show");
}

function filter_technicalSpecification() {
    var data = {};
    listTechnicalSpecification(data);
}

function filter_FooterNotsData() {
    var data = {};
    listFooterNotsData(data);
}

function listTechnicalSpecification(data = "") {
    var technicalSpecificationTbl = $("#technicalSpecificationTbl").DataTable({
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
            url: base_url + "admin/sales/quotation/getTechnicalSpecification",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [
            {
                width: "5%",
                title: "<input type='checkbox' id='checkAll' />",
                orderable: false,
            },

            { width: "10%", title: "Title" },
            { width: "10%", title: "Default Values" },
            {
                width: "10%",
                title: "Action",
                orderable: false,
                className: "text-center",
            },
        ],
    });
}

function listFooterNotsData(data = "") {
    var FooterNotsDataTbl = $("#footerNotesTbl").DataTable({
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
            url: base_url + "admin/sales/quotation/getFooterNotesData",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [
            {
                width: "5%",
                title: "<input type='checkbox' id='checkAllFNotes' />",
                orderable: false,
            },

            { width: "10%", title: "Title", className: "text-left" },
            { width: "10%", title: "Description", className: "text-left" },
            {
                width: "10%",
                title: "Action",
                orderable: false,
                className: "text-center",
            },
        ],
    });
}
var deletedTechnicalSpecifications = [];
function getCheckedTechSpecification() {
    var existingSpecifications = [];

    // Collect the current specification IDs and titles to prevent duplicates
    $("#techSpecificationDiv .control-label").each(function () {
        existingSpecifications.push($(this).text().trim());
    });

    $(".checkTechSpecipication").each(function () {
        if ($(this).is(":checked")) {
            var title = $(this).attr("data-title");
            var defaultValue = $(this).attr("data-defaultvalue");
            var specificationId = $(this).attr("data-specificationid");

            // Check if the title already exists in the form
            if (!existingSpecifications.includes(title)) {
                // Append the new technical specification to the div
                $("#techSpecificationDiv").append(
                    '<div class="input-group mt-2">' +
                        '<div class="col-md-3"><label class="control-label">' +
                        title +
                        "</label></div>" +
                        '<div class="col-md-8"><input type="text" class="form-control" value="' +
                        defaultValue +
                        '" name="techSpecification[' +
                        specificationId +
                        ']" id="" ></div>' +
                        '<div class="input-group-prepend"><a class="remove_techSpeci btn btn-primary btn-sm text-danger"><i class="fa fa-times"></i></a></div>' +
                        "</div>"
                );

                // Add the new title to the list of existing specifications
                existingSpecifications.push(title);
            }
        }
    });

    // Add click event listener to remove buttons
    $(document).on("click", ".remove_techSpeci", function () {
        var techSpecificationId = $(this)
            .closest(".input-group")
            .find('[type="hidden"]')
            .val();
        if (techSpecificationId) {
            deletedTechnicalSpecifications.push(techSpecificationId);
        }
        // console.log(deletedTechnicalSpecifications);

        $(this).closest(".input-group").remove();

        $(".checkTechSpecipication").prop("checked", false);
    });

    // Hide the modal after updating
    $("#technicalSpecificationModel").modal("hide");
}

$("#submitFrm").on("click", function () {
    alert("submit");
});

function getCheckedFooterNotes() {
    var existingMasterFooterNoteIds = [];

    var checkedCount = existingMasterFooterNoteIds.length;

    $(".checkFooterNotes").each(function () {
        if ($(this).is(":checked")) {
            var footerNotesId = $(this).attr("data-footerNotesId");

            if (existingMasterFooterNoteIds.includes(footerNotesId)) {
                return true;
            }

            checkedCount++;
            var title = $(this).attr("data-title");
            var description = $(this).attr("data-description");

            var editorClass = "editor" + checkedCount;

            $("#footerNotesDiv").append(
                '<div class="col-md-6 p-0 float-left"><div class="form-group col-md-11 p-0 float-left"><input type="hidden" name="cust_foot_id[]" value="' +
                    footerNotesId +
                    '" /><label class="control-label">' +
                    title +
                    '</label><div class="input-group"><div class="editor-container col-md-12 p-0"><textarea name="footerNotes[' +
                    footerNotesId +
                    ']" class="' +
                    editorClass +
                    '">' +
                    description +
                    "</textarea></div></div></div></div>"
            );

            ClassicEditor.create(
                document.querySelector("." + editorClass)
            ).catch((error) => {
                console.error(error);
            });
        }
    });

    $("#footerNotesModel").modal("hide");
}

function calculateCost() {
    var subTotal = 0;
    var discount = $("#discount").val();
    var adjustment = $("#adjustment").val();
    var amountWithoutTax = 0;
    var calculated_taxAmt = 0;
    var totalTaxValue = 0;

    $('tbody[data-repeater-list="group-a"] tr').each(function () {
        var quantity =
            parseInt($(this).find('input[name$="[quantity]"]').val()) || 0;
        var rate = parseFloat($(this).find('input[name$="[rate]"]').val()) || 0;
        var tax =
            parseFloat($(this).find('select[name$="[tax_slab]"]').text()) || 0;

        $('select[name$="[tax_slab]"]').select2({
            // minimumInputLength: 3,
            ajax: {
                url: base_url + "admin/sales/quotation/listTaxSlab",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data,
                    };
                },
                cache: true,
            },
        });

        amountWithoutTax = quantity * rate;

        calculated_taxAmt = amountWithoutTax * (tax / 100);
        totalTaxValue += calculated_taxAmt;

        //var amount = quantity * rate + quantity * rate * (tax / 100);
        //var amount = quantity * rate;

        $(this)
            .find('input[name$="[amount]"]')
            .val(amountWithoutTax.toFixed(2));

        //subTotal1 += amount;
        /// subtotal calculation
        subTotal += amountWithoutTax;
        $("#subTotalValue").html(subTotal.toFixed(2));

        /// tax calculation
        $(this)
            .find('input[name$="[calculated_taxAmt]"]')
            .val(calculated_taxAmt.toFixed(2));
        $("#totalTaxValue").html(totalTaxValue.toFixed(2));

        /// discount calculation
        var discountAmount = (discount * (subTotal + totalTaxValue)) / 100;
        var afterDiscount =
            subTotal +
            totalTaxValue -
            (discount * (subTotal + totalTaxValue)) / 100;
        $("#afterDiscountValue").html(discountAmount.toFixed(2));

        /// adjustment
        $("#afterAdjustmentValue").html(adjustment);

        //grand total calculation
        var grandTotal = afterDiscount - adjustment;
        $("#grandTotalValue").html(Math.round(grandTotal).toFixed(2));
        // roundOff = Math.round(grandTotal);
    });
}

function filter_listQuotationData() {
    var customer_id = $("#quotationCustomer").val();
    var status_id = $("#quotationStatus").val();
    //console.log(customer_id);
    var data = { customer_id: customer_id, quotation_status: status_id };
    listQuotationData(data);
}

function listQuotationData(data = "") {
    var quotationListTbl = $("#quotationList").DataTable({
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
            url: base_url + "admin/sales/quotation/listQuotationData",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 3 }],

        columns: [
            {
                width: "5%",
                title: "Sr No",
            },

            { width: "15%", title: "Quotation No" },
            { width: "20%", title: "Customer Name" },
            { width: "10%", title: "Customer Mobile No" },
            { width: "15%", title: "Quotation Amount" },
            { width: "10%", title: "Estimate Date" },
            { width: "10%", title: "Expiry Date" },
            { width: "10%", title: "Status" },
            {
                width: "10%",
                title: "Action",
                orderable: false,
                className: "text-center",
            },
        ],
    });
}

// headerMsgModel
$(".headerMsgModel").on("click", function () {
    $("#headerMsgModel").modal("show");
});
//footerMsgModel

$(".footerMsgModel").on("click", function () {
    $("#footerMsgModel").modal("show");
});

// filter_listocHeaderFooterTbl
function filter_listocHeaderFooterTbl() {
    var ocHeaderFooterType = $("#ocHeaderFooterType").val();

    var data = { ocHeaderFooterType: ocHeaderFooterType };
    listocHeaderFooterTbl(data);
}

function filter_listocFooterTbl() {
    var ocHeaderFooterType = $("#ocFooterType").val();

    var data = { ocHeaderFooterType: ocHeaderFooterType };
    listocFooterTbl(data);
}

function listocHeaderFooterTbl(data = "") {
    var listocHeaderFooterTbl = $("#ocHeadeFooterTbl").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div>',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[1, "desc"]],
        ajax: {
            url: base_url + "admin/sales/quotation/getOcHeaderFooterData",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 1 }],
        columns: [
            {
                width: "5%",
                title: "<input type='checkbox' id='checkAll' />",
                orderable: false,
            },
            { width: "10%", title: "Particulars", className: "text-left" },
        ],
    });
}

function listocFooterTbl(data = "") {
    var listocFooterTbl = $("#ocFooterTbl").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div>',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[1, "desc"]],
        ajax: {
            url: base_url + "admin/sales/quotation/getOcHeaderFooterData",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 1 }],
        columns: [
            {
                width: "5%",
                title: "<input type='checkbox' id='checkAll' />",
                orderable: false,
            },
            { width: "10%", title: "Particulars", className: "text-left" },
        ],
    });
}

// getCheckedOCMessage
// #getCheckedOCMessage

$("#getCheckedOCMessage").on("click", function () {
    var existingMasterFooterNoteIds = [];

    $(".checkOCHeaderFooter").each(function () {
        if ($(this).is(":checked")) {
            var particulars = $(this).attr("data-particulars");

            if (window.editor) {
                var currentContent = window.editor.getData();
                var newContent = currentContent + particulars;
                window.editor.setData(newContent);
            }
        }
    });

    $("#headerMsgModel").modal("hide");
});

$("#getCheckedOCFooterMessage").on("click", function () {
    $(".checkOCHeaderFooter").each(function () {
        if ($(this).is(":checked")) {
            var particulars = $(this).attr("data-particulars");

            if (window.roiDescriptionEditor) {
                var currentContent = window.roiDescriptionEditor.getData();
                var newContent = currentContent + particulars;
                window.roiDescriptionEditor.setData(newContent);
            } else {
                console.error(
                    "ROI Description Editor not found or initialized."
                );
            }
        }
    });

    $("#footerMsgModel").modal("hide");
});
