console.log("type=" + $("#type").val());

function isEmpty(value) {
    return value === undefined || value === null || value === "" || isNaN(value);
}
$(document).ready(function () {
    po_filter();
    grn_filter();
    $(".on_date").hide();
});
function po_filter() {
    var data = {
        vendor_id: $("#vendor_id").val(),
        company_id: $("#company_id").val(),
        site_id: $("#site_id").val(),
        on_date: $("#on_date").val(),
        from_date: $("#from_date").val(),
        to_date: $("#to_date").val(),
        item_id: $("#item_id").val(),
          item_group_id:$('#id_itemgroup').val(),
    };
    listPO(data);
}
function grn_filter() {
    var data = {
        vendor_id: $("#vendor_id").val(),
        company_id: $("#company_id").val(),
        site_id: $("#site_id").val(),
        on_date: $("#on_date").val(),
        from_date: $("#from_date").val(),
        to_date: $("#to_date").val(),
        item_id: $("#item_id").val(),
        is_delete_id: $("#is_delete_id").val(),
        item_group_id:$('#id_itemgroup').val(),
    };
    listGRN(data);
}

var tbl_po = "";
function listPO(data = "") {
    tbl_po = $("#tbl_po").DataTable({
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
            url: base_url + "admin/store/GoodsReceiptNote/listPo",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 5 }],

        columns: [
            { title: "Sr._No.", orderable: false, width: "5%" },
            { title: "PO Order No", width: "5%" },
            { title: "Po Date", width: "5%" },
            { title: "Vendor Name", width: "20%" },
            { title: "Delivery Site", width: "25%" },
            { title: "Total Item Qty", width: "10%" },
            { title: "Total Pending Qty", width: "10%" },
            { title: "Status", width: "10%" },
            { title: "Action", orderable: false, className: "text-center", width: "15%" },
        ],
    });
}
tbl_grn_list = "";
function listGRN(data = "") {
    
    //var isAdmin = true;
      if(superadmin_role_id==login_role){
        var isAdmin = true;
    }else{
        var isAdmin = false;
    }
    
    tbl_grn_list = $("#tbl_grn_list").DataTable({
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
            url: base_url + "admin/store/GoodsReceiptNote/listGRN",
            type: "POST",
            dataSrc: "data",
            data: data,
        },
        columnDefs: [{ responsivePriority: 1, targets: 5 }],

        columns: [
            { title: "Sr._No.", orderable: false },
            { title: "GRN Order No" },
            { title: "GRN Date" },
            { title: "Vendor Name" },
            { title: "Location Site", width: "20%" },
            { title: "Total Item Qty" },
            { title: "Is Issue", width: "5%" },
             { title: "PO NUmber", width: "5%" },
            { title: "Deleted reason", width: "20%" , visible: isAdmin},
            { title: "Action", orderable: false, className: "text-center" },
        ],
    });
    
  

}

$("#on_date").change(function () {
    var on_date = $("#on_date").val();
    // alert(on_date);
    if (on_date != 6) {
        po_filter1();
        $(".on_date").hide();
    } else {
        $(".on_date").show();
    }
});

$("#submitBtn").on("click", function (event) {
    event.preventDefault();

    var allVendorIdsSame = true;
    var allDeliveryIdsSame = true;
    var firstVendorId;
    var firstDeliverySiteId;
    var idsArray = [];
    let cnt = 0;
    let check_cnt=0;

    // Iterate over checkboxes to check if all vendor IDs are the same
    $(".checkbox_grn_po").each(function (index) {
        var isChecked = $(this).prop("checked");
        // console.log("isChecked"+isChecked);
        if (isChecked) {
            cnt = cnt + 1;
            var currentVendorId = $(this).data("vendor_id");
            var delivery_site_id = $(this).data("delivery_site_id");
            var po_id = $(this).data("po_id");
            idsArray.push(po_id);

            if (check_cnt === 0) {
                firstVendorId = currentVendorId;
                firstDeliverySiteId = delivery_site_id;
               //  console.log("firstVendorId=0"+firstVendorId)
                 
            } else {
               // console.log("currentVendorId"+currentVendorId)
               // console.log("firstVendorId=1"+firstVendorId)
                if (currentVendorId !== firstVendorId) {
                    allVendorIdsSame = false;
                    return false;
                }
                if (delivery_site_id !== firstDeliverySiteId) {
                    allDeliveryIdsSame = false;
                    return false;
                }
            }
            check_cnt=check_cnt+1;
        }
         
    });
  //  console.log("allVendorIdsSame"+allVendorIdsSame);
  //  console.log("allDeliveryIdsSame"+allDeliveryIdsSame);
    // If all vendor IDs are the same, submit the form
    if (allVendorIdsSame && allDeliveryIdsSame && cnt != 0) {
        $("<input>")
            .attr({
                type: "hidden",
                name: "po_ids",
                value: idsArray,
            })
            .appendTo("#myForm");

        $("#myForm").submit();
    } else {
        if (cnt == 0) {
            alert(" Select checkbox");
        } else if (!allVendorIdsSame) {
            alert(" Selected vendor Should be same!");
        } else {
            alert(" Selected Delivery Site Address Should be same!");
        }
    }
});
$("#vendor_id").select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + "admin/Vendor/listVendorName",
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

$("#site_id").select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + "admin/Common/listSite",
        dataType: "json",
        delay: 250,
        data: function (data) {
            return {
                searchTerm: data.term,
                company_id: $("#company_id").val(),
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

$(document).ready(function () {
    $("#tbl_po tbody").on("click", "tr img", function (event) {
        var id = $(this).data("id");
        event.preventDefault(); // Prevent the default action of the link
        var tr = $(this).closest("tr");
        var row = tbl_po.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass("shown");
        } else {
            $.ajax({
                url: base_url + "admin/store/GoodsReceiptNote/poInnearItemTableData",
                type: "GET",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    innerTable = response.html;
                    row.child(innerTable).show();
                    tr.addClass("shown");
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        }
    });
    $("#tbl_grn_list tbody").on("click", "tr img", function (event) {
        var id = $(this).data("id");
        event.preventDefault(); // Prevent the default action of the link
        var tr = $(this).closest("tr");
        var row = tbl_grn_list.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass("shown");
        } else {
            $.ajax({
                url: base_url + "admin/store/GoodsReceiptNote/grnInnearItemTableData",
                type: "GET",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    innerTable = response.html;
                    row.child(innerTable).show();
                    tr.addClass("shown");
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        }
    });
});
$("#item_id").select2({
    ajax: {
        url: base_url + "admin/Common/list_item_name",
        dataType: "json",
        delay: 250,
        data: function (data) {
            return {
                searchTerm: data.term,
                item_group_name_id: $("#id_itemgroup").val(),
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
