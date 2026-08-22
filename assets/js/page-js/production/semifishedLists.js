$(document).ready(function () {
  var bladeindent = "";
  $("#details").hide();

  filter_indent();
});
function filter_indent() {
  var data = {};
  listSemifinishedList(data);
}
// $(document).ready(function () {
var receivedOrderTable = "";
$("#details").hide();

function listSemifinishedList(data = "") {
  receivedOrderTable = $("#tblSemifinished").DataTable({
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
      url: base_url + "admin/production/SemifinishedList/listSemifinshedOrder",
      type: "POST",
      dataSrc: "data",
      data: data,
    },

    columnDefs: [{ responsivePriority: 1, targets: 3 }],

    columns: [
      { width: "3%", title: "Sr._No.", orderable: false },

      { width: "8%", title: "Project Number" },
      { width: "8%", title: "Indent Manual No" },
      { width: "6%", title: "Order No" },
      { width: "5%", title: "Order Type" },
      { width: "5%", title: "Date" },
      { width: "8%", title: "Customer Name" },
      // { width: "10%", title: "Plant Name" },
      { width: "5%", title: "Blade Qty" },
      { width: "5%", title: "Transfer Qty" },
      { width: "5%", title: "Gap Checking" },
      { width: "5%", title: "Primer" },
      { width: "5%", title: "Filler" },
      { width: "5%", title: "Putty" },
      { width: "5%", title: "Top Coat" },
      { width: "5%", title: "Balancing" },
      { width: "5%", title: "Packing" },
      { width: "5%", title: "Dispatch Qty" },
      {
        width: "5%",
        title: "Action",
        orderable: false,
        className: "text-center",
      },
    ],
  });
}

$("#tblSemifinished").on("click", ".plus-icon", function () {
  var dataId = $(this).data("id");
  $("#details").show();
  // alert(dataId)
  $.ajax({
    url: base_url + "admin/production/SemifinishedList/indentDetails",
    type: "POST",
    data: { id: dataId },
    dataType: "json",
    success: function (res) {
      console.log(res);

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

      /* ------  set in hidden Start -------*/
      $("#order_id").val(res.id);
      $("#order_id_dispatch").val(res.id); // for dispatch order
      $("#packing_hidden").val(res.packing_qty);

      /* ------  set in hidden End -------*/

      /* --- This is value show in update creation table ------ */
      $("#gap_checking_qty").val(res.gap_checking_qty);
      $("#primer_qty").val(res.primer_qty);
      $("#filler_qty").val(res.filler_qty);
      $("#putty_qty").val(res.putty_qty);
      $("#top_coat_qty").val(res.top_coat_qty);
      $("#balancing_qty").val(res.balancing_qty);
      $("#packing_qty").val(res.packing_qty);
      $("#transfer_qty_hidden").val(res.transfer_qty);
      $("#dispatch_qty_hidden").val(res.dispatch_qty);
      /*  ---------------------   End   -------------------------     */

      /* ------ This is value show in Transfer status section ------ */
      $("#dispatch_Qty").val(res.packing_qty);
      const qty = res.packing_qty;
      console.log(qty);

      /* ----------------------------------- END ---------------- */
      let dispatchQuantity = $("#packing_qty").val();

      let transferQty = parseInt($("#transfer_qty_hidden").val()) || 0;
      let dispatchQty = parseInt($("#dispatch_qty_hidden").val()) || 0;
      let totalQty = transferQty - dispatchQty;
      console.log("Total Quantity Available: ", totalQty);
      if (totalQty === 0) {
        $("#update-creation").hide();
      } else {
        $("#update-creation").show();
      }

      if (
        dispatchQuantity === "" ||
        dispatchQuantity === "0" ||
        parseFloat(dispatchQuantity) <= 0
      ) {
        $("#transfer-button").hide();
      } else {
        $("#transfer-button").show();
      }

      $.validator.addMethod(
        "validateQuantitySum",
        function (value, element, params) {
          let gapCheckingQty = parseInt($("#gap_checking_qty").val()) || 0;
          let primerQty = parseInt($("#primer_qty").val()) || 0;
          let fillerQty = parseInt($("#filler_qty").val()) || 0;
          let puttyQty = parseInt($("#putty_qty").val()) || 0;
          let topCoatQty = parseInt($("#top_coat_qty").val()) || 0;
          let balancingQty = parseInt($("#balancing_qty").val()) || 0;
          let packingQty = parseInt($("#packing_qty").val()) || 0;
          let transferQty = parseInt($("#transfer_qty_hidden").val()) || 0;
          let dispatchQty = parseInt($("#dispatch_qty_hidden").val()) || 0;

          let totalQty = transferQty - dispatchQty;

          let totalSum =
            gapCheckingQty +
            primerQty +
            fillerQty +
            puttyQty +
            topCoatQty +
            balancingQty +
            packingQty;
          $.validator.messages.validateQuantitySum = `Total sum (${totalSum}) exceeds the available quantity (${totalQty}).`;
          return totalSum <= totalQty;
        },
        function () {
          // The error message is now dynamically set in the `$.validator.messages.validateQuantitySum`
          return $.validator.messages.validateQuantitySum;
        }
      );

      $("#semifinishedOrderForm").validate({
        rules: {
          gap_checking_qty: {
            validateQuantitySum: true,
          },
          primer_qty: {
            validateQuantitySum: true,
          },
          filler_qty: {
            validateQuantitySum: true,
          },
          putty_qty: {
            validateQuantitySum: true,
          },
          top_coat_qty: {
            validateQuantitySum: true,
          },
          balancing_qty: {
            validateQuantitySum: true,
          },
          packing_qty: {
            validateQuantitySum: true,
          },
        },
        messages: {
          gap_checking_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
          primer_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
          filler_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
          putty_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
          top_coat_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
          balancing_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
          packing_qty: {
            validateQuantitySum: function () {
              return $.validator.messages.validateQuantitySum;
            },
          },
        },
        errorPlacement: function (error, element) {
          error.insertAfter(element);
        },
      });

      // Form submission handler
      $("#semifinishedOrderForm").on("submit", function (e) {
        e.preventDefault();

        // Validate the form
        if ($(this).valid()) {
          var formData = $(this).serialize();
          console.log(formData);

          var confirmed = confirm(
            "Are you sure you want to Update Order Status?"
          );
          if (confirmed) {
            $.ajax({
              url:
                base_url +
                "admin/production/SemifinishedList/semifinishedOrder",
              type: "POST",
              data: formData,
              dataType: "json",
              success: function (res) {
                if (res.status === "success") {
                  window.location.href =
                    base_url + "admin/production/SemifinishedList/index";
                } else {
                }
              },
              error: function (xhr, status, error) {
                console.error("Error:", error);
              },
            });
          }
        }
      });
    },
  });

  $.validator.addMethod(
    "greaterThan",
    function (value, element, param) {
      // Convert value to a number
      var dispatchQty = parseFloat(value);
      // Convert param to a number
      var maxQty = parseFloat($(param).val());
      // Check if dispatchQty is greater than zero and less than or equal to maxQty
      return dispatchQty > 0 && dispatchQty <= maxQty;
    },
    "Dispatch Qty must be greater than zero and cannot be greater than the available quantity."
  );

  $("#dispatchForm").validate({
    rules: {
      dispatch_qty: {
        required: true,
        greaterThan: "#packing_hidden",
      },
      dispatch_by: {
        required: true,
      },
      status: {
        required: true,
      },
    },
    messages: {
      dispatch_qty: {
        required: "Please enter the dispatch quantity.",
      },
      dispatch_by: {
        required: "Please select who is dispatching.",
      },
      status: {
        required: "Please select where to dispatch.",
      },
    },
    submitHandler: function (form) {
      var formData = $(form).serialize();
      console.log(formData);
      var confirmed = confirm("Are you sure you want to Dispatch Qty?");
      if (confirmed) {
        $.ajax({
          url: base_url + "admin/production/SemifinishedList/dispatchOrder",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (res) {
            if (res.status === "success") {
              window.location.href =
                base_url + "admin/production/SemifinishedList/index";
            }
          },
        });
      }
    },
  });
});

// function transferQty(id = "",indent_id="",manual_indent_no="") {
function transferQty(element) {
  // console.log("jdf");
  var id = $(element).data("id");
  var indent_id = $(element).data("indent-id");
  var manual_indent_no = $(element).data("manual-indent-no");
  var interChangeType = $(element).data("type"); // InterChange Type
  var type = 2; // Balaji Plant (Semifinished Stage)
  var interChangeType = $(element).data("type"); // InterChange Type is 3
  var orderQty = $(element).data("order-qty");
  var bladeSize = $(element).data("blade-size");
  var aTip = $(element).data("atip"); 
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
  var indent_id = $(element).data("indent-id");
  var manual_indent_no = $(element).data("manual-indent-no");
  var interChangeType = $(element).data("type"); // InterChange Type
  var type = 2; // Balaji Plant (Semifinished Stage)
  var interChangeType = $(element).data("type"); // InterChange Type is 3
  var orderQty = $(element).data("order-qty");
  var bladeSize = $(element).data("blade-size");
  var aTip = $(element).data("atip"); 
  console.log(`interChangeType ${interChangeType}, orderQty ${orderQty} , bladeSize ${bladeSize} , aTip ${aTip}`);

   console.log("ID:", id);
  console.log("Indent ID:", indent_id);
  console.log("Manual Indent No:", manual_indent_no);
  $.ajax({
    url: base_url + "admin/production/SemifinishedList/interChnageQty",
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


