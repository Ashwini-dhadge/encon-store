// function filter_indent() {
//   var type = $("#type").val();
//   var indentid = $("#indentid").val();
//   var data = {
//     type: type,
//     indentid: indentid,
//   };
//   listbladeindent(data);
// }
$(document).ready(function () {
  var bladeindent = ""; // Initialize variable
  $("#details").hide();

  filter_indent();
  // listReceivedOrders();
});

function filter_indent() {
  var data = {};
  listReceivedOrders(data);
}
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
      url: base_url + "admin/production/ReceivedOrders/listReceivedOrders",
      type: "POST",
      dataSrc: "data",
      data: data,
    },

    columnDefs: [{ responsivePriority: 1, targets: 3 }],

    columns: [
      { width: "5%", title: "Sr._No.", orderable: false },

      { width: "5%", title: "Order Type" },
      { width: "7%", title: "indent Number" },
      { width: "7%", title: "Indent Manual No" },
      { width: "7%", title: "Order No" },
      { width: "5%", title: "Date" },
      { width: "8%", title: "Customer Name" },
      // { width: "10%", title: "Plant Name" },
      { width: "6%", title: "Indent Blade Qty" },
      { width: "5%", title: "Order Qty" },
      { width: "6%", title: "Created" },
      { width: "6%", title: "Blade in Hand" },
      // { width: "6%", title: "Blade Position" },
      { width: "6%", title: "Transfer Qty" },
      // { width: "6%", title: "Indent Transfer Qty" },
      {
        width: "5%",
        title: "Action",
        orderable: false,
        className: "text-center",
      },
    ],
  });
}
// listReceivedOrders();
$("#receivedOrders").on("click", ".plus-icon", function () {
  var dataId = $(this).data("id");
  // alert(dataId)
  $.ajax({
    url: base_url + "admin/production/ReceivedOrders/indentDetails",
    type: "POST",
    data: { id: dataId },
    dataType: "json",
    success: function (res) {
      console.log(res);

      $("#details").show();

      /* ------  set in hidden Start -------*/
      $("#order_id").val(res.id);
      $("#order_id_transfer").val(res.id);
      $("#blade_qty_hidden").val(res.blade_qty);
      $("#order_qty_hidden").val(res.order_qty);
      $("#created_qty_hidden").val(res.created_qty);
      // $("#blade_position_hidden").val(res.blade_position_qty);
      $("#received_qty_hidden").val(res.order_qty);
      $("#transfer_qty_hidden").val(res.transfer_qty);
      $("#indent_transfer_qty").val(res.indent_transfer_qty);

      /* ------  set in hidden End -------*/

      $("#indet_no").text(res.indent_id);
      $("#date").text(res.indent_date);
      $("#name_plates").text(res.name_plate);
      $("#blade_qtys").text(res.blade_qty);
      $("#received_qtys").text(res.order_qty);
      $("#mould_sizes").text(res.mould_size);
      $("#blade_sizes").text(res.blade_size);
      $("#punching_nos").text(res.blade_punching_no);
      $("#atips").text(res.a_tip);
      $("#colors").text(res.color);
      $("#name_plates").text(res.name_plate);

      /* --- This is value show in update creation table ------ */

      $("#createQty").val(res.created_qty);
      $("#blade_in_hand").val(res.blade_in_hand_qty);
      // $("#blade_position").val(res.blade_position_qty);

      /*  ---------------------   End   -------------------------     */

      /* --- This is value show in Transfer status section ------ */

      $("#transfer_qty").val(res.blade_in_hand_qty);

      // this is transfer qty to balaji plant
      /*  ---------------------   End   -------------------------     */
      let transferQty = $("#transfer_qty").val();
      // console.log(transferQty);
      let orderQty = parseInt($("#order_qty_hidden").val()) || 0;
      let transferQtyy = parseInt($("#transfer_qty_hidden").val()) || 0;
      let totalQty = orderQty - transferQtyy;
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
      // let blade_position = parseInt($("#blade_position").val()) || 0;
      let orderQty = parseInt($("#order_qty_hidden").val()) || 0;
      let transferQty = parseInt($("#transfer_qty_hidden").val()) || 0;
      let indentTransferQty = parseInt($("#indent_transfer_qty").val()) || 0;
      console.log(indentTransferQty)

      let totalQty = orderQty - transferQty - indentTransferQty;
      // alert(totalQty)

      let totalSum = createQty + blade_in_hand;
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
      // blade_position_qty: {
      //   validateQuantitySum: true,
      // },
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
      // blade_position_qty: {
      //   validateQuantitySum: function () {
      //     return $.validator.messages.validateQuantitySum;
      //   },
      // },
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

function transferQty(element) {
  // console.log("jdf");
  var id = $(element).data("id");
  var indent_id = $(element).data("indent-id");
  var manual_indent_no = $(element).data("manual-indent-no");
 var type = 1; // Encon Recevied Orders
 var interChangeType = $(element).data("type"); // InterChange Type is 3
 var orderQty = $(element).data("order-qty");
 var bladeSize = $(element).data("blade-size");
 var aTip = $(element).data("atip");
//  alert(interChangeType)
console.log(`interChangeType ${interChangeType}, orderQty ${orderQty} , bladeSize ${bladeSize} , aTip ${aTip}`);

  console.log("ID:", id);
  console.log("Indent ID:", indent_id);
  console.log("Manual Indent No:", manual_indent_no);
  $.ajax({
    url: base_url + "admin/production/SemifinishedList/transferQty",
    type: "POST",
    data: {
      id: id,
      manual_indent_no: manual_indent_no,
      type: type,
      orderQty:orderQty,
      bladeSize:bladeSize,
      aTip: aTip,
      interChangeType: interChangeType,
    },
    dataType: "json",
    success: function (res) {
      $("#_banner2").html();
      if (res.result == true) {
        $("#_banner2").html(res.html);
        $("#transferQtyModal").modal("show");
        // $("#catdrop").select2();
      } else {
        alert_float("error", response.reason);
      }
    },
  });
}

function interChangeQty(element)
{
  var id = $(element).data("id");
  // var indent_id = $(element).data("indent-id");
  // var manual_indent_no = $(element).data("manual-indent-no");
  // var interChangeType = $(element).data("type"); // InterChange Type
  var type = 1; // Balaji Plant (Semifinished Stage)
  // var interChangeType = $(element).data("type"); // InterChange Type is 3
  var interChangeType = 3; // InterChange Type is 3
  // var orderQty = $(element).data("order-qty");
  // var bladeSize = $(element).data("blade-size");
  // var aTip = $(element).data("atip"); 
  // console.log(`interChangeType ${interChangeType}, orderQty ${orderQty} , bladeSize ${bladeSize} , aTip ${aTip}`);

   console.log("ID:", id);
  // console.log("Indent ID:", indent_id);
  // console.log("Manual Indent No:", manual_indent_no);
  $.ajax({
    url: base_url + "admin/production/SemifinishedList/interChnageQty",
    type: "POST",
    data: {
      id: id,
      type:type,
      interChangeType:interChangeType
    },
    dataType: "json",
    success: function (res) {
      $("#_banner3").html();
      if (res.result == true) {
        $("#_banner3").html(res.html);
        $("#interChangeQtyModal").modal("show");
        // $("#catdrop").select2();
      } else {
        alert_float("error", response.reason);
      }
    },
  });
}
// function check(){

//   // var oldcreated = document.getElementById('oldcreatedqty');
//   // console.log(oldcreated);
  
// }


