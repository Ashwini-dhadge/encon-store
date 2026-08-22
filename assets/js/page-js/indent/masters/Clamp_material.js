function filter_hub() {

  var type = $('#type').val();

  var data = {
    'type': type,
  };

  listClampMaterial(data);
}

var hubsize = '';

function listClampMaterial(data = '') {

  hubsize = $('#clamp_material').DataTable({

    "dom": 'fl<"topbutton">tip',
    oLanguage: {
      sProcessing: '<div class="dt-loader"></div'
    },
    processing: true,
    serverSide: true,
    destroy: true,
    pageLength: 25,
    order: [
      [1, "desc"]
    ],

    ajax: {
      url: base_url + 'admin/indent/master/Clamp/Clamp_material/list_clamp_material',
      type: 'POST',
      dataSrc: "data",
      data: data,
    },

    columnDefs: [{
      responsivePriority: 1,
      targets: 2
    }],

    columns: [{
      "width": "2%",
      title: "Sr._No.",
      orderable: false
    },
    {
      "width": "10%",
      title: "Name"
    },
    {
      "width": "5%",
      title: "Action",
      orderable: false,
      "className": "text-center"
    },
    ],

  });

}

$(document).ready(function () {

  filter_hub();

});


$('.clampModal').on('click', function () {
  clampModal();
});


function clampModal(id = '') {

  $.ajax({
    url: base_url + 'admin/indent/master/Clamp/Clamp_material/clampModal',
    type: 'POST',
    data: {
      'id': id
    },
    dataType: 'json',

    success: function (res) {

      if (res.result == true) {

        $('#_banner2').html(res.html);

        $('#clampModal').modal('show');

      } else {

        alert_float('error', res.reason);

      }
    }
  });
}


$(document).on('submit', '#ClampForm', function (e) {

  e.preventDefault();

  var form = $('#ClampForm')[0];
  var formData = new FormData(form);

  $('#submit_btn').prop('disabled', true);

  $.ajax({

    url: $(this).attr('action'),
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',

    success: function (response) {

      $('#submit_btn').prop('disabled', false);

      if (response.status == true) {

        $('#clampModal').modal('hide');

        $('#ClampForm')[0].reset();

        hubsize.ajax.reload(null, false);

        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.message
        });

      } else {

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response.message
        });

      }
    },

    error: function () {

      $('#submit_btn').prop('disabled', false);

      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Something went wrong!'
      });

    }

  });

});
