function filter_color() {
  var type = $("#type").val();

  var data = {
    type: type,
  };
  listColor(data);
}
var color = "";
function listColor(data = "") {
  color = $("#color").DataTable({
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
      url: base_url + "admin/indent/master/Blade/Color/listColor",
      type: "POST",
      dataSrc: "data",
      data: data,
    },
    columnDefs: [{ responsivePriority: 1, targets: 2 }],

    columns: [
      { width: "2%", title: "Sr._No.", orderable: false },
      { width: "10%", title: "Name" },

      {
        width: "5%",
        title: "Action",
        orderable: false,
        className: "text-center",
      },
    ],
  });
}
$(document).ready(function () {
  filter_color();
});

$(".colorModal").on("click", function () {
  colorModal();
});

function colorModal(id = "") {
  console.log("jdf");
  $.ajax({
    url: base_url + "admin/indent/master/Blade/Color/colorModal",
    type: "POST",
    data: { id: id },
    dataType: "json",
    success: function (res) {
      $("#_banner2").html();
      if (res.result == true) {
        $("#_banner2").html(res.html);
        $("#colorModal").modal("show");
        // $("#catdrop").select2();
      } else {
        alert_float("error", response.reason);
      }
    },
  });
}



// $('.color').select2({
  
//   width: '100%',
//   ajax: {
//     url: base_url + 'admin/indent/master/Blade/Color/list_color',
//     dataType: 'json',
//     type: "get",
//     delay: 500,
//     data: function(params) {
//       return {
//         searchTerm: params.term
//       };
//     },
//     processResults: function(data) {
//       return {
//         results: data
//       };
//     },
//     cache: true
//   }
// }).on('select2:select', function (e) {
//   var selectedValue = e.params.data.id; 
//   console.log("Selected ID: " + selectedValue);
// });

