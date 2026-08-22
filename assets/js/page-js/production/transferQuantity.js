var mouldsize = $("#mouldSize").val();
var orderId = $("#orderId").val();
var type = $("#type").val();
var manualIndentNo = $("#fromManualIndentNo").val();

// ---------  For The Interchange Qty Start ------- //

var interChange = $("#interChange").val();
var orderQuty = $("#orderQuty").val();
var bladeSize = $("#bladeSize").val();
var aTip = $("#aTip").val();



// ---------  For The Interchange Qty END ------- //

var manualIndentNo = $("#fromManualIndentNo").val();
// alert(manualIndentNo)
// console.log(mouldsize);
// console.log(type);
$(".indent")
  .select2({
    placeholder: "Select Manual Indent",
    ajax: {
      url: base_url + "admin/production/SemifinishedList/listIndent",
      dataType: "json",

      delay: 250,
      data: function (data) {
        return {
          searchTerm: data.term,
          mouldsize: mouldsize,
          orderId: orderId,
          type: type,
          manualIndentNo: manualIndentNo,
          // interChange: interChange,
          // orderQuty: orderQuty,
          // bladeSize: bladeSize,
          // aTip: aTip,
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  })
  .on("select2:select", function (e) {
    
    subIndnet();
    $(".subIndent").val(null).trigger("change"); // Clear previous selection
      $(".subIndent").select2("open");
    
  });

console.log($(".indent").val());
$(".subIndent").select2({});
function subIndnet() {
  $(".subIndent").select2({
    placeholder: "Select Sub-Manual Indent",
    ajax: {
      url: base_url + "admin/production/SemifinishedList/listSubIndent",
      dataType: "json",

      delay: 250,
      data: function (data) {
        return {
          searchTerm: data.term,
          manualIndentNo: $(".indent").val(),
          mouldsize : $("#mouldSize").val(),
          type :$("#type").val(),
          interChange: interChange,
          orderQuty: orderQuty,
          bladeSize: bladeSize,
          aTip: aTip,
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  }).on("select2:select", function (e) {
    var orderId = e.params.data.id;
    var manualIndentNo = e.params.data.text;
    
    
    console.log("Order ID: ", orderId);
    console.log("manualIndentNo : ", manualIndentNo);
    console.log("interChange : ", interChange);


    if(interChange !== ""){       // This is for the InterChange Qunatity
      addStatusValue(orderId);
    }

    $("#transferToManualIndnetNo").val(manualIndentNo);
    $("#transferToOrderId").val(orderId);
    // subIndnet();
   
    if (manualIndentNo) {
      
      $("#transferDetails").show();

      inputReadOnly();
    } else {
      $("#transferDetails").hide();
    }
  });
}

function addStatusValue(orderId){        // This function using for the InterChange the Quantity
  $.ajax({
    url: base_url + "admin/production/SemifinishedList/addInterChangeStatus",
    type: "POST",
    data: {
      orderId:orderId,
    },
    dataType: "json",
    success: function (res) {
      console.log(res);
      console.log(res.created_qty);
      $("#CreateQty").val(res.created_qty);
      $("#BladeHandQty").val(res.blade_in_hand_qty);
      $("#BladePosQty").val(res.blade_position_qty);
      
    },
  });
}

function inputReadOnly() {
  let type = $("#type").val();
  if (type == 1) {
    let hidden_created_qty = parseInt($("#hidden_created_qty").val());

    if (isNaN(hidden_created_qty) || hidden_created_qty <= 0) {
      document.getElementById("CreateQty").readOnly = true;
      document.getElementById("CreateQty").required = false;
    } else {
      document.getElementById("CreateQty").readOnly = false;
      document.getElementById("CreateQty").required = true;
    }

    const hidden_blade_in_hand_qty = parseInt(
      $("#hidden_blade_in_hand_qty").val()
    );
    console.log(hidden_blade_in_hand_qty);
    if (isNaN(hidden_blade_in_hand_qty) || hidden_blade_in_hand_qty <= 0) {
      document.getElementById("BladeHandQty").readOnly = true;
      document.getElementById("BladeHandQty").required = false;
    } else {
      document.getElementById("BladeHandQty").readOnly = false;
      document.getElementById("BladeHandQty").required = true;
    }
    const hidden_blade_position_qty = parseInt(
      $("#hidden_blade_position_qty").val()
    );
    console.log(hidden_blade_position_qty);
    if (isNaN(hidden_blade_position_qty) || hidden_blade_position_qty <= 0) {
      document.getElementById("BladePosQty").readOnly = true;
      document.getElementById("BladePosQty").required = false;
    } else {
      document.getElementById("BladePosQty").readOnly = false;
      document.getElementById("BladePosQty").required = true;
    }
  } else if (type == 2) {
    let hidden_gapchecking = parseInt($("#hidden_gapchecking").val());

    if (isNaN(hidden_gapchecking) || hidden_gapchecking <= 0) {
      document.getElementById("GapCheckQty").readOnly = true;
      document.getElementById("GapCheckQty").required = false;
    } else {
      document.getElementById("GapCheckQty").readOnly = false;
      document.getElementById("GapCheckQty").required = true;
    }
    let hidden_primer_qty = parseInt($("#hidden_primer_qty").val());

    if (isNaN(hidden_primer_qty) || hidden_primer_qty <= 0) {
      document.getElementById("PrimerQty").readOnly = true;
      document.getElementById("PrimerQty").required = false;
    } else {
      document.getElementById("PrimerQty").readOnly = false;
      document.getElementById("PrimerQty").required = true;
    }
    let hidden_filler_qty = parseInt($("#hidden_filler_qty").val());

    if (isNaN(hidden_filler_qty) || hidden_filler_qty <= 0) {
      document.getElementById("FillerQty").readOnly = true;
      document.getElementById("FillerQty").required = false;
    } else {
      document.getElementById("FillerQty").readOnly = false;
      document.getElementById("FillerQty").required = true;
    }

    let hidden_putty_qty = parseInt($("#hidden_putty_qty").val());

    if (isNaN(hidden_putty_qty) || hidden_putty_qty <= 0) {
      document.getElementById("PuttyQty").readOnly = true;
      document.getElementById("PuttyQty").required = false;
    } else {
      document.getElementById("PuttyQty").readOnly = false;
      document.getElementById("PuttyQty").required = true;
    }

    let hidden_top_coat_qty = parseInt($("#hidden_top_coat_qty").val());

    if (isNaN(hidden_top_coat_qty) || hidden_top_coat_qty <= 0) {
      document.getElementById("TopCoatQty").readOnly = true;
      document.getElementById("TopCoatQty").required = false;
    } else {
      document.getElementById("TopCoatQty").readOnly = false;
      document.getElementById("TopCoatQty").required = true;
    }

    let hidden_balancing_qty = parseInt($("#hidden_balancing_qty").val());

    if (isNaN(hidden_balancing_qty) || hidden_balancing_qty <= 0) {
      document.getElementById("BalancingQty").readOnly = true;
      document.getElementById("BalancingQty").required = false;
    } else {
      document.getElementById("BalancingQty").readOnly = false;
      document.getElementById("BalancingQty").required = true;
    }
    let hidden_packing_qty = parseInt($("#hidden_packing_qty").val());

    if (isNaN(hidden_packing_qty) || hidden_packing_qty <= 0) {
      document.getElementById("PackingQty").readOnly = true;
      document.getElementById("PackingQty").required = false;
    } else {
      document.getElementById("PackingQty").readOnly = false;
      document.getElementById("PackingQty").required = true;
    }
  }
}

// $.validator.addMethod(
//   "validateQuantity",
//   function (value, element) {
//     let hidden_created_qty = parseInt($("#hidden_created_qty").val());
//     let entered_value = parseInt(value);
//     // console.log(element)

//     if (isNaN(hidden_created_qty) || isNaN(entered_value)) {
//       return false;
//     }

//     $.validator.messages.validateQuantity = `Total quantity (${entered_value}) exceeds the available quantity (${hidden_created_qty}).`;
//     return hidden_created_qty >= entered_value;
//   },
//   function () {
//     return $.validator.messages.validateQuantity;
//   }
// );
// $.validator.addMethod(
//   "validateQuantity2",
//   function (value, element) {
//     let hidden_blade_in_hand_qty = parseInt(
//       $("#hidden_blade_in_hand_qty").val()
//     );
//     let entered_value = parseInt(value);
//     // console.log(entered_value)

//     if (isNaN(hidden_blade_in_hand_qty) || isNaN(entered_value)) {
//       return false;
//     }

//     $.validator.messages.validateQuantity2 = `Total quantity (${entered_value}) exceeds the available quantity (${hidden_blade_in_hand_qty}).`;
//     return hidden_blade_in_hand_qty >= entered_value;
//   },
//   function () {
//     return $.validator.messages.validateQuantity2;
//   }
// );
// $.validator.addMethod(
//   "validateQuantity3",
//   function (value, element) {
//     let hidden_blade_position_qty = parseInt(
//       $("#hidden_blade_position_qty").val()
//     );
//     let entered_value = parseInt(value);
//     // console.log(element)

//     if (isNaN(hidden_blade_position_qty) || isNaN(entered_value)) {
//       return false;
//     }

//     $.validator.messages.validateQuantity3 = `Total quantity (${entered_value}) exceeds the available quantity (${hidden_blade_position_qty}).`;
//     return hidden_blade_position_qty >= entered_value;
//   },
//   function () {
//     return $.validator.messages.validateQuantity3;
//   }
// );
// $.validator.addMethod(
//   "validateGapQty",
//   function (value, element) {
//     let hidden_gapchecking = parseInt($("#hidden_gapchecking").val());

//     // alert(hidden_gapchecking)
//     let entered_value = parseInt(value);
//     // console.log(element)

//     if (isNaN(hidden_gapchecking) || isNaN(entered_value)) {
//       return false;
//     }

//     $.validator.messages.validateGapQty = `Total quantity (${entered_value}) exceeds the available quantity (${hidden_gapchecking}).`;
//     return hidden_gapchecking >= entered_value;
//   },
//   function () {
//     return $.validator.messages.validateGapQty;
//   }
// );

// $.validator.addMethod(
//   "validatePrimerQty",
//   function (value, element) {
//     let hidden_primer_qty = parseInt($("#hidden_primer_qty").val());
//     let entered_value = parseInt(value);
//     // console.log(element)

//     if (isNaN(hidden_primer_qty) || isNaN(entered_value)) {
//       return false;
//     }

//     $.validator.messages.validatePrimerQty = `Total quantity (${entered_value}) exceeds the available quantity (${hidden_primer_qty}).`;
//     return hidden_primer_qty >= entered_value;
//   },
//   function () {
//     return $.validator.messages.validatePrimerQty;
//   }
// );

$("#transferOrderForm").validate({
  submitHandler: function (form) {
    if (confirm("Confirm order?")) {
      form.submit();
    }
  },
});

// $("#submit_btn").on("click", function () {
//   let = confirm("Do you want to transfer Quantity ?");
// //   if (confirm) {
// //     $("#transferOrderForm").submit();
// //   } else {
// //   }
// });

// rules: {
//     created_qty: {
//         validateQuantity: true,
//     },
//     blade_in_hand_qty: {
//         validateQuantity2: true,
//     },
//     blade_position_qty: {
//         validateQuantity3: true,
//     },
//     // Add rules for other fields based on type
//     // gap_checking_qty: {
//     //     validateGapQty: true,
//     // },
//     // primer_qty: {
//     //     validatePrimerQty: true,
//     // },
//     filler_qty: {
//     },
//     putty_qty: {
//     },
//     top_coat_qty: {
//     },
//     balancing_qty: {
//     },
//     packing_qty: {
//     },
// },
// messages: {
//     created_qty: {
//         validateQuantity: function() {
//             return $.validator.messages.validateQuantity;
//         },
//     },
//     blade_in_hand_qty: {
//         validateQuantity2: function() {
//             return $.validator.messages.validateQuantity2;
//         },
//     },
//     blade_position_qty: {
//         validateQuantity3: function() {
//             return $.validator.messages.validateQuantity3;
//         },
//     },
//     // Add messages for other fields based on type
//     // gap_checking_qty: {
//     //     validateGapQty: function() {
//     //         return $.validator.messages.validateGapQty;
//     //     },
//     // },
//     // primer_qty: {
//     //     validatePrimerQty: function() {
//     //         return $.validator.messages.validatePrimerQty;
//     //     },
//     // },
//     filler_qty: {
//     },
//     putty_qty: {
//     },
//     top_coat_qty: {
//     },
//     balancing_qty: {
//     },
//     packing_qty: {
//     },
// },
//   errorPlacement: function (error, element) {
//     error.insertAfter(element);
//   },
//   submitHandler: function (form) {
//     var formData = $(form).serialize();
//     console.log(formData);
//     var confirmed = confirm("Are you sure you want to Update Order Status?");
//     if (confirmed) {
//       $.ajax({
//         url: base_url + "admin/production/ReceivedOrders/orderCreation",
//         type: "POST",
//         data: formData,
//         success: function (response) {
//           console.log("Success:", response);
//         },
//         error: function (xhr, status, error) {
//           console.error("Error:", error);
//         },
//       });
//     }
//   },
