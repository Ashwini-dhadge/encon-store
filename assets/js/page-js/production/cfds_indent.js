function filter_indent() {
  var data = {
    type: $("#type").val(),
    indentid: 22,
    from_date: $("#from_date").val(),
    to_date: $("#to_date").val()
  };

  listbladeindent(data);
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
function listbladeindent(data = {}) {
  bladeindent = $("#blade_indent").DataTable({
    dom: 'fl<"topbutton">tip',
    processing: true,
    serverSide: true,
    destroy: true,
    pageLength: 25,
    order: [[1, "desc"]],
    ajax: {
      url: base_url + "admin/production/Indent/list_carbon_fiber_drive_shaft",
      type: "POST",
      dataSrc: "data",
      data: function (d) {
        return $.extend({}, d, data);
      }
    },
    columns: [
      {
        width: "5%",
        title: "",
        orderable: false
      },
      {
        width: "5%",
        title: "Sr._No.",
        orderable: false
      },
      {
        width: "5%",
        title: "Client Name"
      },
      {
        width: "5%",
        title: "Plant Name"
      },
      {
        width: "5%",
        title: "Project Number"
      },
      {
        width: "5%",
        title: "Indent Mannual No"
      },
      {
        width: "10%",
        title: "Date"
      },
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
// $(".indent_id").select2({
//   ajax: {
//     url: base_url + "admin/production/Indent/listindent",
//     dataType: "json",
//     delay: 250,
//     data: function (data) {
//       return {
//         searchTerm: data.term,
//       };
//     },
//     processResults: function (response) {
//       return {
//         results: response,
//       };
//     },
//     cache: true,
//   },
// });

$(".client_name").select2({
  ajax: {
    // url:base_url +'admin/Common/listclientName',
    url: base_url + "admin/production/Indent/listclientName",
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

$(".mould_size").select2({
  ajax: {
    url: base_url + "admin/production/Indent/listmould_size",
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

$(".a_tip").select2({
  ajax: {
    // url:base_url +'admin/Common/listclientName',
    url: base_url + "admin/production/Indent/list_a_tip",
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
      url: base_url + "admin/production/Indent/list_cfds_ReceivedOrders",
      type: "POST",
      dataSrc: "data",
      data: data,
    },

    columnDefs: [{ responsivePriority: 1, targets: 3 }],

    columns: [
      { width: "5%", title: "Sr._No.", orderable: false },

      { width: "5%", title: "Order Type" },
      { width: "5%", title: "Order Number" },
      // { width: "7%", title: "Indent Number" },
      { width: "7%", title: "Indent Manual No" },
      // { width: "7%", title: "Order No" },
      { width: "5%", title: "Date" },
      { width: "8%", title: "Customer Name" },
      // { width: "10%", title: "Plant Name" },
      { width: "6%", title: "Total Qty" },
      { width: "5%", title: "Order Qty" },
      { width: "6%", title: "Design Selection" },
      { width: "6%", title: "Filament Winding " },
      { width: "6%", title: "Bonding " },
      { width: "6%", title: "Torque Testing and Finishing" },
      { width: "6%", title: "Dynamic Balancing" },
      { width: "6%", title: "Inspection " },
      { width: "6%", title: "Packaging " },
      { width: "6%", title: "Dispatch " },
      {
        width: "10%",
        title: "Action",
        orderable: false,
        className: "text-center",
      },
    ],
  });
}

$("#receivedOrders").on("click", ".plus-icon", function () {

  var dataId = $(this).data("id");
  console.log(dataId);
  // alert(dataId)
  $.ajax({
    url: base_url + "admin/production/Indent/indentDetails",
    type: "POST",
    data: { id: dataId },
    dataType: "json",
    success: function (res) {
      console.log(res);

      // $("#details").show();
      let targetSection = $("#details");
      targetSection.show();

      /* ------ SMOOTH SCROLL TO DETAILS ------ */
      $("html, body").animate(
        { scrollTop: targetSection.offset().top - 80 },
        500,
      );

      /* ------ OPTIONAL FOCUS ------ */
      targetSection.attr("tabindex", "-1").focus();

      /* ------  set in hidden Start -------*/
      $("#order_id").val(res.id);
      $("#order_id_transfer").val(res.id);
      $("#blade_qty_hidden").val(res.blade_qty);
      $("#order_qty_hidden").val(res.order_qty);
      $("#created_qty_hidden").val(res.created_qty);
      $("#blade_position_hidden").val(res.blade_position_qty);
      $("#received_qty_hidden").val(res.order_qty);
      $("#transfer_qty_hidden").val(res.transfer_qty);
      $("#indent_transfer_qty").val(res.indent_transfer_qty);

      /* ------  set in hidden End -------*/

      $("#indent_number").text(res.indent_no);
      $("#date").text(res.date);
      $("#plant_name").text(res.plant_name);
      $("#customer_name").text(res.customer_name);
      $("#qty").text(res.qty);
      $("#received_qty").text(res.received_qty);
      $("#dimension").text(res.dimension);
      $("#material").text(res.material);
      $("#make").text(res.make);
      $("#remark").text(res.remark);

      /* --- This is value show in update creation table ------ */

      $("#createQty").val(res.created_qty);
      $("#blade_in_hand").val(res.blade_in_hand_qty);
      $("#blade_position").val(res.blade_position_qty);

      /*  ---------------------   End   -------------------------     */

      /* --- This is value show in Transfer status section ------ */

      $("#transfer_qty").val(res.blade_position_qty);

      // this is transfer qty to balaji plant
      /*  ---------------------   End   -------------------------     */
      let transferQty = $("#transfer_qty").val();
      // console.log(transferQty);
      let orderQty = parseInt($("#order_qty_hidden").val()) || 0;
      let transferQtyy = parseInt($("#transfer_qty_hidden").val()) || 0;
      // let totalQty = orderQty - transferQtyy;
      let totalQty = 1;
      console.log(orderQty, transferQtyy, totalQty);

      if (totalQty === 0) {
        $("#update-creation").hide();
      } else {
        $("#update-creation").show();
      }

      if (
        transferQty === "" ||
        transferQty === "0" ||
        parseFloat(transferQty) <= 0
      ) {
        $("#transfer-button").hide();
      } else {
        $("#transfer-button").show();
      }
    },
  });


  $.validator.addMethod(
    "validateQuantitySum",
    function (value, element, params) {
      let createQty = parseInt($("#createQty").val()) || 0;
      let blade_in_hand = parseInt($("#blade_in_hand").val()) || 0;
      let blade_position = parseInt($("#blade_position").val()) || 0;
      let orderQty = parseInt($("#order_qty_hidden").val()) || 0;
      let transferQty = parseInt($("#transfer_qty_hidden").val()) || 0;
      let indentTransferQty = parseInt($("#indent_transfer_qty").val()) || 0;
      console.log(indentTransferQty)

      let totalQty = orderQty - transferQty - indentTransferQty;
      // alert(totalQty)

      let totalSum = createQty + blade_in_hand + blade_position;
      $.validator.messages.validateQuantitySum = `Total sum (${totalSum}) exceeds the available quantity (${totalQty}).`;
      return totalSum <= totalQty;
    },
    function () {
      // The error message is now dynamically set in the `$.validator.messages.validateQuantitySum`
      return $.validator.messages.validateQuantitySum;
    }
  );

  $("#receiveOrderForm").validate({
    rules: {
      created_qty: {
        validateQuantitySum: true,
      },
      blade_in_hand_qty: {
        validateQuantitySum: true,
      },
      blade_position_qty: {
        validateQuantitySum: true,
      },
    },
    messages: {
      created_qty: {
        validateQuantitySum: function () {
          return $.validator.messages.validateQuantitySum;
        },
      },
      blade_in_hand_qty: {
        validateQuantitySum: function () {
          return $.validator.messages.validateQuantitySum;
        },
      },
      blade_position_qty: {
        validateQuantitySum: function () {
          return $.validator.messages.validateQuantitySum;
        },
      },
    },
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
  });

  $("#receiveOrderForm").on("submit", function (e) {
    e.preventDefault();

    if ($(this).valid()) {
      var formData = $(this).serialize();
      console.log(formData);

      var confirmed = confirm("Are you sure you want to Update Order Status?");
      if (confirmed) {
        $.ajax({
          url: base_url + "admin/production/ReceivedOrders/orderCreation",
          type: "POST",
          data: formData,
          success: function (response) {
            try {
              var jsonResponse = JSON.parse(response);
              if (jsonResponse.status === "success") {
                window.location.href =
                  base_url + "admin/production/ReceivedOrders/index";
              } else {
              }
            } catch (e) {
              console.error("Error parsing response:", e);
            }
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    }
  });

  $("#tansferForm").on("submit", function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
    console.log(formData);
    var confirmed = confirm("Are you sure you want to Transfer Qty?");

    if (confirmed) {
      $.ajax({
        url: base_url + "admin/production/ReceivedOrders/transferOrder",
        type: "POST",
        data: formData,
        success: function (response) {
          var jsonResponse = JSON.parse(response);
          if (jsonResponse.status === "success") {
            window.location.href =
              base_url + "admin/production/ReceivedOrders/index";
          }
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
        },
      });
    }
  });

  /* ----------   End  ----------------------------- */



});



function openInterChangeModal(id, indent_id) {
  order_id = id;
  indent_id = indent_id;
  $("#interChangeQtyModal").modal("show");

  $.ajax({
    url: base_url + "admin/production/Indent/getIndentStatusData/" + order_id,
    type: "POST",
    data: { order_id: order_id, indent_id: indent_id },
    success: function (response) {
      // alert(response)
    },
  })

}



// =====================================
// SELECT ALL
// =====================================

$(document).on('change', '#select_all_cfds', function () {

  $('.cfds_checkbox').prop(
    'checked',
    $(this).prop('checked')
  );

});

// =====================================
// GET SELECTED IDS
// =====================================

function getSelectedCFDSRows() {
  let selected = [];

  $('.cfds_checkbox:checked').each(function () {

    selected.push($(this).val());

  });

  return selected;
}

// =====================================
// EXPORT SELECTED PDF
// =====================================

$(document).on('click', '#export_selected_pdf', function () {

  let selected = getSelectedCFDSRows();

  if (selected.length == 0) {

    alert('Please select rows');

    return;
  }

  let url =
    base_url +
    'admin/production/Indent/export_selected_cfds_pdf?ids=' +
    selected.join(',');

  window.open(url, '_blank');

});

// =====================================
// EXPORT SELECTED EXCEL
// =====================================

$(document).on('click', '#export_selected_excel', function () {

  let selected = getSelectedCFDSRows();

  if (selected.length == 0) {

    alert('Please select rows');

    return;
  }

  let url =
    base_url +
    'admin/production/Indent/export_selected_cfds_excel?ids=' +
    selected.join(',');

  window.open(url, '_blank');

});