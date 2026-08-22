var mouldsize = $("#intermouldSize").val();
var orderId = $("#interorderId").val();
var type = $("#intertype").val();
var manualIndentNo = $("#interFromManualIndentNo").val();

// ---------  For The Interchange Qty Start ------- //

var interChange = $("#interChange").val();
var orderQuty = $("#interorderQuty").val();
var bladeSize = $("#interbladeSize").val();
var aTip = $("#interaTip").val();

// ---------  For The Interchange Qty END ------- //

$(".interIndent")
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
  })
  .on("select2:select", function (e) {
    subIndnet();
    $(".interSubIndent").val(null).trigger("change"); // Clear previous selection
    $(".interSubIndent").select2("open");
  });

console.log($(".interIndent").val());
$(".interSubIndent").select2({});
function subIndnet() {
  $(".interSubIndent")
    .select2({
      placeholder: "Select Sub-Manual Indent",
      ajax: {
        url: base_url + "admin/production/SemifinishedList/listSubIndent",
        dataType: "json",

        delay: 250,
        data: function (data) {
          return {
            searchTerm: data.term,
            manualIndentNo: $(".interIndent").val(),
            mouldsize: $("#intermouldSize").val(),
            type: $("#intertype").val(),
            interChange: interChange,
            orderQuty: orderQuty,
            bladeSize: bladeSize,
            aTip: aTip,
          };
        },
        processResults: function (response) {
          console.log("subindent", response);
          if (Array.isArray(response) && response.length <= 0) {
            $(".dynamicDetails").hide();
          }
          return {
            results: response,
          };
        },
        cache: true,
      },
    })
    .on("select2:select", function (e) {
      var orderId = e.params.data.id;
      var manualIndentNo = e.params.data.text;
      // console.log(selectedText);
      // var orderId = selectedText.split("(")[1]?.split(")")[0] || null;
      console.log("Order ID: ", orderId);

      $("#transferToManualIndnetNo").val(manualIndentNo);
      $("#transferToOrderId").val(orderId);
      // subIndnet();

      if (manualIndentNo) {
        addStatusValue(orderId);
        // $(".subIndent").val(null).trigger("change"); // Clear previous selection
        // $(".subIndent").select2("open");
        // $("#transferDetails").show();

        // inputReadOnly();
      } else {
        // $("#transferDetails").hide();
      }
    });
}
function addStatusValue(orderId) {
  // This function using for the InterChange the Quantity
  $.ajax({
    url: base_url + "admin/production/SemifinishedList/addInterChangeStatus",
    type: "POST",
    data: {
      orderId: orderId,
    },
    dataType: "json",
    success: function (res) {
      console.log(res);
      console.log(res.created_qty);
      $("#ON").text(res.order_no);
      $("#oqty").text(res.order_qty);
      $("#create").text(res.created_qty);
      $("#bladeh").text(res.blade_in_hand_qty);
      $("#bposition").text(res.blade_position_qty);
      $("#tqty").text(res.transfer_qty);
      $("#gcheck").text(res.gap_checking_qty);
      $("#primer").text(res.primer_qty);
      $("#filler").text(res.filler_qty);
      $("#putty").text(res.putty_qty);
      $("#topcoat").text(res.top_coat_qty);
      $("#balancing").text(res.balancing_qty);
      $("#packing").text(res.packing_qty);

      $(".dynamicDetails").show();
    },
  });
}

function interChangeQuantity() {
  var fromQty = parseInt($(".fromQty").text());
  var fromCreated = parseInt($(".fromCreated").text());
  var fromBladeHand = parseInt($(".fromBladeHand").text());
  var fromBladePositions = parseInt($(".fromBladePosition").text());
  var fromTotal = fromCreated + fromBladeHand + fromBladePositions;

  
  

  var toQty = parseInt($(".toQty").text());
  var toCreated = parseInt($(".toCreated").text());
  var toBladeHand = parseInt($(".toBladeHand").text());
  var toBladePosition = parseInt($(".toBladePosition").text());
  var toTotal = toCreated + toBladeHand + toBladePosition;
  // alert(typeof fromQty);

  // var from = [fromCreated, fromBladeHand, fromBladePositions];
  // var to = [toCreated, toBladeHand, toBladePosition];

  // for (var forIndex = 0; forIndex < from.length; forIndex++) {
  //   if(from[forIndex] !== to[forIndex]){
  //   console.log(`from array => ${from[forIndex]} , to array => ${to[forIndex]}`)
  //   }
  // }
}

// function inputReadOnly() {
//   let type = $("#intertype").val();
//   if (type == 1) {
//     let hidden_created_qty = parseInt($("#hidden_created_qty").val());

//     if (isNaN(hidden_created_qty) || hidden_created_qty <= 0) {
//       document.getElementById("CreateQty").readOnly = true;
//       document.getElementById("CreateQty").required = false;
//     } else {
//       document.getElementById("CreateQty").readOnly = false;
//       document.getElementById("CreateQty").required = true;
//     }

//     const hidden_blade_in_hand_qty = parseInt(
//       $("#hidden_blade_in_hand_qty").val()
//     );
//     console.log(hidden_blade_in_hand_qty);
//     if (isNaN(hidden_blade_in_hand_qty) || hidden_blade_in_hand_qty <= 0) {
//       document.getElementById("BladeHandQty").readOnly = true;
//       document.getElementById("BladeHandQty").required = false;
//     } else {
//       document.getElementById("BladeHandQty").readOnly = false;
//       document.getElementById("BladeHandQty").required = true;
//     }
//     const hidden_blade_position_qty = parseInt(
//       $("#hidden_blade_position_qty").val()
//     );
//     console.log(hidden_blade_position_qty);
//     if (isNaN(hidden_blade_position_qty) || hidden_blade_position_qty <= 0) {
//       document.getElementById("BladePosQty").readOnly = true;
//       document.getElementById("BladePosQty").required = false;
//     } else {
//       document.getElementById("BladePosQty").readOnly = false;
//       document.getElementById("BladePosQty").required = true;
//     }
//   } else if (type == 2) {
//     let hidden_gapchecking = parseInt($("#hidden_gapchecking").val());

//     if (isNaN(hidden_gapchecking) || hidden_gapchecking <= 0) {
//       document.getElementById("GapCheckQty").readOnly = true;
//       document.getElementById("GapCheckQty").required = false;
//     } else {
//       document.getElementById("GapCheckQty").readOnly = false;
//       document.getElementById("GapCheckQty").required = true;
//     }
//     let hidden_primer_qty = parseInt($("#hidden_primer_qty").val());

//     if (isNaN(hidden_primer_qty) || hidden_primer_qty <= 0) {
//       document.getElementById("PrimerQty").readOnly = true;
//       document.getElementById("PrimerQty").required = false;
//     } else {
//       document.getElementById("PrimerQty").readOnly = false;
//       document.getElementById("PrimerQty").required = true;
//     }
//     let hidden_filler_qty = parseInt($("#hidden_filler_qty").val());

//     if (isNaN(hidden_filler_qty) || hidden_filler_qty <= 0) {
//       document.getElementById("FillerQty").readOnly = true;
//       document.getElementById("FillerQty").required = false;
//     } else {
//       document.getElementById("FillerQty").readOnly = false;
//       document.getElementById("FillerQty").required = true;
//     }

//     let hidden_putty_qty = parseInt($("#hidden_putty_qty").val());

//     if (isNaN(hidden_putty_qty) || hidden_putty_qty <= 0) {
//       document.getElementById("PuttyQty").readOnly = true;
//       document.getElementById("PuttyQty").required = false;
//     } else {
//       document.getElementById("PuttyQty").readOnly = false;
//       document.getElementById("PuttyQty").required = true;
//     }

//     let hidden_top_coat_qty = parseInt($("#hidden_top_coat_qty").val());

//     if (isNaN(hidden_top_coat_qty) || hidden_top_coat_qty <= 0) {
//       document.getElementById("TopCoatQty").readOnly = true;
//       document.getElementById("TopCoatQty").required = false;
//     } else {
//       document.getElementById("TopCoatQty").readOnly = false;
//       document.getElementById("TopCoatQty").required = true;
//     }

//     let hidden_balancing_qty = parseInt($("#hidden_balancing_qty").val());

//     if (isNaN(hidden_balancing_qty) || hidden_balancing_qty <= 0) {
//       document.getElementById("BalancingQty").readOnly = true;
//       document.getElementById("BalancingQty").required = false;
//     } else {
//       document.getElementById("BalancingQty").readOnly = false;
//       document.getElementById("BalancingQty").required = true;
//     }
//     let hidden_packing_qty = parseInt($("#hidden_packing_qty").val());

//     if (isNaN(hidden_packing_qty) || hidden_packing_qty <= 0) {
//       document.getElementById("PackingQty").readOnly = true;
//       document.getElementById("PackingQty").required = false;
//     } else {
//       document.getElementById("PackingQty").readOnly = false;
//       document.getElementById("PackingQty").required = true;
//     }
//   }
// }

$("#interchangeQtyForm").validate({
  submitHandler: function (form) {
    if (confirm("Confirm order?")) {
      form.submit();  
    }
  },
});

function checkfirst() {
  // alert("hi")
  var oldcreated = document.getElementById("oldcreatedqty");
  var newcreatedqty = document.getElementById("newcreatedqty");
  if (oldcreated.disabled == true && newcreatedqty.disabled == true) {
    oldcreated.disabled = false;
    newcreatedqty.disabled = false;
  } else {
    oldcreated.disabled = true;
    newcreatedqty.disabled = true;
  }
}
function checksec() {
  // alert("hi")
  var oldbladehandqty = document.getElementById("oldbladehandqty");
  var newbladehandqty = document.getElementById("newbladehandqty");
  if (oldbladehandqty.disabled == true && newbladehandqty.disabled == true) {
    oldbladehandqty.disabled = false;
    newbladehandqty.disabled = false;
  } else {
    oldbladehandqty.disabled = true;
    newbladehandqty.disabled = true;
  }
}
function checkthre() {
  // alert("hi")
  var oldbladepositionqty = document.getElementById("oldbladepositionqty");
  var newbladepositionqty = document.getElementById("newbladepositionqty");
  if (
    oldbladepositionqty.disabled == true &&
    newbladepositionqty.disabled == true
  ) {
    oldbladepositionqty.disabled = false;
    newbladepositionqty.disabled = false;
  } else {
    oldbladepositionqty.disabled = true;
    newbladepositionqty.disabled = true;
  }
}
