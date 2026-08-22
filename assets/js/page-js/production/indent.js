function filter_indent() {
  var type = $("#type").val();
  var indentid = $("#indentid").val();
  var data = {
    type: type,
    indentid: indentid,
  };
  listbladeindent(data);
}
var bladeindent = "";
function listbladeindent(data = "") {
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
      url: base_url + "admin/production/Indent/listblade_indent",
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
        id="select_all_blade">
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
  filter_indent();
});

$(".indent_id").select2({
  ajax: {
    url: base_url + "admin/production/Indent/listindent",
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

// $('.costprojectModal').on('click', function() {
//    costprojectModal();
//  });

//  function costprojectModal(id='') {

//    $.ajax({
//          url: base_url +'admin/master/CostProject/costprojectModal',
//          type: 'POST',
//          data: {'id':id},
//          dataType:'json',
//          success: function(res) {
//              $('#_banner').html();
//            if (res.result == true) {
//              $('#_banner').html(res.html);
//              $('#costprojectModal').modal('show');
//              // $("#catdrop").select2();
//            }else{
//              alert_float('error',response.reason);
//            }
//          }
//      })
//  }
//


$(document).on('change', '#select_all_blade', function () {

  $('.blade_checkbox').prop(
    'checked',
    $(this).prop('checked')
  );

});


function getSelectedBladeRows() {
  let selected = [];

  $('.blade_checkbox:checked').each(function () {

    selected.push($(this).val());

  });

  return selected;
}

$(document).on('click', '#export_selected_pdf', function () {

  let selected = getSelectedBladeRows();

  if (selected.length == 0) {

    alert('Please select rows');

    return;
  }

  let url =
    base_url +
    'admin/production/Indent/export_selected_blade_pdf?ids=' +
    selected.join(',');

  window.open(url, '_blank');

});


$(document).on('click', '#export_selected_excel', function () {

  let selected = getSelectedBladeRows();

  if (selected.length == 0) {

    alert('Please select rows');

    return;
  }

  let url =
    base_url +
    'admin/production/Indent/export_selected_blade_excel?ids=' +
    selected.join(',');

  window.open(url, '_blank');

});


