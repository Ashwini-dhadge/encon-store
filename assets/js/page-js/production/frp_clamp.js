function filter_indent() {
  var type = $("#type").val();
  var indentid = 7;
  var data = {
    type: type,
    indentid: indentid,
    from_date: $("#from_date").val(),
    to_date: $("#to_date").val()
  };
  listfrpclampindent(data);
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
function listfrpclampindent(data = "") {
  bladeindent = $("#blade_indent").DataTable({
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
      url: base_url + "admin/production/Indent/list_frp_clamp",
      type: "POST",
      dataSrc: "data",
      data: data,
    },
    columnDefs: [{ responsivePriority: 1, targets: 3 }],

    columns: [
      {
        width: "3%",
        title: `
        <input type="checkbox"
        id="select_all_frphp">
    `,
        orderable: false
      },
      { width: "5%", title: "Sr._No.", orderable: false },

      { width: "5%", title: "Client Name" },
      { width: "5%", title: "Plant Name" },
      { width: "5%", title: "Project Number" },
      { width: "5%", title: "Indent Mannual No" },
      { width: "10%", title: "Date" },
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
      url: base_url + "admin/production/Indent/list_frp_clamp_received_orders",
      type: "POST",
      dataSrc: "data",
      data: data,
    },

    columnDefs: [{ responsivePriority: 1, targets: 3 }],

    columns: [
      { width: "5%", title: "Sr._No.", orderable: false },

      { width: "5%", title: "Order Type" },
      { width: "5%", title: "Order Number" },
      { width: "7%", title: "Material" },
      { width: "5%", title: "Date" },
      { width: "5%", title: "Client" },
      { width: "6%", title: "Total Qty" },
      { width: "5%", title: "Order Qty" },
      { width: "5%", title: "Under Finishing" },
      { width: "5%", title: "Finish" },
      { width: "5%", title: "Paintaing" },
      { width: "5%", title: "Dispatch" },
      {
        width: "10%",
        title: "Action",
        orderable: false,
        className: "text-center",
      },
    ],
  });
}
$(document).on('change', '#select_all_frphp', function () {

  $('.header_pipe_checkbox').prop(
    'checked',
    $(this).prop('checked')
  );

});


function getSelectedHPRows() {
  let selected = [];

  $('.header_pipe_checkbox:checked').each(function () {

    selected.push($(this).val());

  });

  return selected;
}

$(document).on('click', '#export_selected_pdf', function () {

  let selected = getSelectedHPRows();

  if (selected.length == 0) {

    alert('Please select rows');

    return;
  }

  let url =
    base_url +
    'admin/production/Indent/export_selected_frp_clamp_pdf?ids=' +
    selected.join(',');

  window.open(url, '_blank');

});


$(document).on('click', '#export_selected_excel', function () {

  let selected = getSelectedHPRows();

  if (selected.length == 0) {

    alert('Please select rows');

    return;
  }

  let url =
    base_url +
    'admin/production/Indent/export_selected_frpclamp_excel?ids=' +
    selected.join(',');

  window.open(url, '_blank');

});

