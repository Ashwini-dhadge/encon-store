let indent_id = "";
$(document).ready(function () {
  console.log("indent_id" + indent_id);
  $("#frm_indent").validate();
  if (!isEmpty($("#id").val())) {
    indent_id = $("#indent_id").val();
    getClientData();
  }
});
function getClientData() {
  let client_id = $("#clientId").val();

  $.ajax({
    url: base_url + "admin/indent/Indent/listclientName",
    type: "post",
    dataType: "json",
    success: function (response) {
      if (response) {
        $("#client_id").select2({
          data: response,
        });
        // $("#billing_site_id").select2("val", billingSiteId);
        $("#client_id").val(client_id);
        $("#client_id").trigger("change");
      }
    },
  });
}
//alert(indent_id);
$("#company_plant_name").select2({
  ajax: {
    url: base_url + "admin/indent/Indent/listplantName",
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

$(".client_name")
  .select2({
    ajax: {
      url: base_url + "admin/indent/Indent/listclientName",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  })
  .on("select2:select", function (e) {
    var selectedValue = e.params.data.id; // Access the ID here
    console.log("Selected ID: " + selectedValue);
  });

$(".indent_name")
  .select2({
    ajax: {
      url: base_url + "admin/indent/Indent/listIndentName",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  })
  .on("select2:select", function (e) {
    var selectedValue = e.params.data.id; // Access the ID here
    console.log("Selected ID: " + selectedValue);
  });

$(".open_modal_indent_blade").on("click", function () {
  var selectedValue = $("#indent_name").val();
  if (indent_id == "" && $('#frm_indent').valid()) {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "mr-2 btn btn-danger",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Are you sure?",
        text: "Do you want to add this indent.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, proceed!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
      })
      .then((result) => {
        if (result.value) {
          // if($('#formData').valid()){
          var formData = $("#frm_indent").serialize();

          $.ajax({
            url: base_url + "admin/indent/Indent/saveIndent",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (res) {
              if (res.result == true) {
                indent_id = res.indentId;
                $("#indent_id").val(indent_id);
                $("#client_id").val(client_id);
                window.location.href =
                  base_url + "admin/indent/Indent/add_indent/" + indent_id;
                // open_modal_indent_blade(selectedValue,indent_id);
              } else {
                alert_float("error", response.reason);
              }
            },
          });
          //}
          //ajax

          //empty check indent_id //indent submit ajax ew insenrt
          //response indent id
          //golbl

          //$('#modal_indent').modal('show');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelled",
            "Modal opening cancelled.",
            "error"
          );
        }
      });
  } else {
    open_modal_indent_blade(selectedValue, indent_id, 0);
  }
});

function open_modal_indent_blade(selectedValue, indent_id, sub_indent_id = 0) {
  // console.log(selectedValue)
  selectedValue = parseInt(selectedValue);
  plant_name = $('#company_plant_name').val();

  if (selectedValue && plant_name || sub_indent_id) {
    $.ajax({
      url: base_url + "admin/indent/Indent/open_modal_indent_master",
      type: "POST",
      data: {
        master_indent_id: selectedValue,
        indent_id: indent_id,
        id: sub_indent_id,
      },
      dataType: "json",
      success: function (res) {
        if (res.result == true) {
          $("#modal_indent").modal("show");
          $("#modal_indent .modal-content").html(res.html);
          $("#master_indent_id").val(selectedValue);
          $("#indentIdModal").val(indent_id);
          $("#plant_id").val($("#company_plant_name").val());
          $("#master_indent_id").val(selectedValue);
          if (sub_indent_id) {
            setupdateSelect2(selectedValue);
          }

        } else {
          alert_float("error", response.reason);
        }
      },
    });
  } else {
    alert_float("error", "Indent Not select NOT Found");
  }
}

function submitAllIndentMaster() {
  if ($("#form").valid()) {
    var formData = $("#form").serialize();
    $.ajax({
      url: base_url + "admin/indent/Indent/saveIndentAllModule",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function (res) {
        if (res.result == true) {
          //  $('#tbody_indent').append(res.tbody);
          //     $('#modal_indent').hide();
          $("#modal_indent").modal("toggle");
          filter();
        } else {
          alert_float("error", response.reason);
        }
      },
    });
  }
}

$(document).ready(function () {
  filter();
});
function filter() {
  var data = {
    indent_id: $("#indent_id").val(),
  };
  listGetData(data);
}
function listGetData(data = "") {
  console.log($("#indent_id").val());
  tbl_po = $("#tbl_indent_details").DataTable({
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
      url: base_url + "admin/indent/Indent/getIndentModuleDetailsData",
      type: "POST",
      dataSrc: "data",
      data: data,
    },
    columnDefs: [{ responsivePriority: 1, targets: 4 }],

    columns: [
      { title: "Sr._No.", orderable: false, width: "5%" },
      { title: "Plant_name", width: "20%" },
      { title: "Indent For", width: "10%" },
      { title: "Descrption", width: "40%" },
      { title: "Qty", width: "10%" },
      {
        title: "Action",
        orderable: false,
        className: "text-center",
        width: "15%",
      },
    ],
  });
}

function open_modal_indent_delete_blade(
  master_indent_id,
  indent_id,
  sub_indent_id,
  indent_details_id
) {
  const swalWithBootstrapButtons1 = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "mr-2 btn btn-danger",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons1
    .fire({
      title: "Are you sure?",
      text: "Do you want to Delete Module this indent.",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, proceed!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: base_url + "admin/indent/Indent/deleteModuleIndent",
          type: "POST",
          data: {
            master_indent_id: master_indent_id,
            indent_id: indent_id,
            id: sub_indent_id,
            indent_details_id: indent_details_id
          },
          dataType: "json",
          success: function (res) {
            if (res.result == true) {
              filter();
              alert_float("succes", res.success);
            } else {
              alert_float("error", res.reason);
            }
          },
        });
        // }
        //ajax

        //empty check indent_id //indent submit ajax ew insenrt
        //response indent id
        //golbl

        //$('#modal_indent').modal('show');
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Modal opening cancelled.",
          "error"
        );
      }
    });
}
function filter_indent() {
  var type = $("#type").val();
  var data = {
    type: type,
  };
  listindent(data);
}
var indent = "";
function listindent(data = "") {
  indent = $("#indent").DataTable({
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
      url: base_url + "admin/indent/Indent/listindent",
      type: "POST",
      dataSrc: "data",
      data: data,
    },
    columnDefs: [{ responsivePriority: 1, targets: 3 }],

    columns: [
      { width: "5%", title: "Sr._No.", orderable: false },

      { width: "5%", title: "Client Name" },
      { width: "5%", title: "Plant Name" },
      { width: "5%", title: "Indent Number" },
      { width: "5%", title: "Manual Indent Number" },
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
function isEmpty(value) {
  return value === undefined || value === null || value === "" || isNaN(value);
}
function updateIndent() {
  var formData = $("#frm_indent").serialize();
  $.ajax({
    url: base_url + "admin/indent/Indent/saveIndent",
    type: "POST",
    data: formData,
    dataType: "json",
    success: function (res) {
      if (res.result == true) {
        window.location.href = base_url + "admin/indent/Indent";
        //  loaction.load()
      } else {
        alert_float("error", response.reason);
      }
    },
  });
}

$(document).ready(function () {
  setUpdateData();
  $('.client_name').change(function () {

    var client = $(this).val();

    console.log("value" + client);

    $('#company_plant_name').select2({

      placeholder: 'Select plants',
      ajax: {
        url: base_url + "admin/indent/Indent/listplantName",
        type: 'post',
        dataType: 'json',
        data: function (params) {
          return {
            search: params.term
          };
        },
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true

      }
    });
  });
});

function setUpdateData() {

  //company plat
  $.ajax({
    url: base_url + "admin/indent/Indent/getPlants",
    type: "post",
    dataType: 'json',
    data: { customer_id: $('#clientId').val() },

    success: function (response) {
      //alert($('#company_id').val())
      if (response) {
        $("#plants").select2({
          data: response
        })
        $("#plants").val($('#clientPlantId').val());
        // alert(deliveryPartyId)
        $('#plants').trigger('change');
      }
    }
  });



}

function getCustomerPlantName() {
  $('#plants').empty();
  $('#plants').select2({
    ajax: {
      url: base_url + 'admin/Common/plant_name_list',
      dataType: 'json',
      delay: 250,
      data: function (data) {
        return {
          searchTerm: data.term,
          'customer_id': $('#client_id').val(),
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }
  });
}

function setupdateSelect2(indent_for) {
  if (indent_for == 1) {
    $.ajax({
      url: base_url + 'admin/indent/master/Blade/Mould_size/listMould',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#mould_size").select2({
            data: response
          })
          $("#mould_size").val($('#mouldSize').val());
          // alert(deliveryPartyId)
          $('#mould_size').trigger('change');
        }
      }
    });
    $.ajax({
      url: base_url + 'admin/indent/master/Blade/A_tip/list_aTip',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#a_tip").select2({
            data: response
          })
          $("#a_tip").val($('#aTip').val());
          // alert(deliveryPartyId)
          $('#a_tip').trigger('change');
        }
      }
    });
    $.ajax({
      url: base_url + 'admin/indent/master/Blade/Color/list_color',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#color").select2({
            data: response
          })
          $("#color").val($('#dcolor').val());
          // alert(deliveryPartyId)
          $('#color').trigger('change');
        }
      }
    });
  } else if (indent_for == 2) {
    $.ajax({
      url: base_url + 'admin/indent/master/Hub/Hub_size/list_hubSize',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#hub_size").select2({
            data: response
          })
          $("#hub_size").val($('#hubSize').val());

          $('#hub_size').trigger('change');
        }
      }
    });

    $.ajax({
      url: base_url + 'admin/indent/master/Hub/Material/list_Material',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#material").select2({
            data: response
          })
          $("#material").val($('#hubMaterial').val());
          console.log("aaa" + $('#hubMaterial').val())
          $('#material').trigger('change');
        }
      }
    });

    $.ajax({
      url: base_url + 'admin/indent/master/Hub/Hardware/list_Hardware',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#hardwares").select2({
            data: response
          })
          $("#hardwares").val($('#hubHardwares').val());
          // alert(deliveryPartyId)
          $('#hardwares').trigger('change');
        }
      }
    });


    $.ajax({
      url: base_url + 'admin/indent/master/Hub/Thickness/list_Thickness',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#thikness").select2({
            data: response
          })
          $("#thikness").val($('#hubThickness').val());
          // alert(deliveryPartyId)
          $('#thikness').trigger('change');
        }
      }
    });

    $.ajax({
      url: base_url + 'admin/indent/master/Hub/Plate_Od/list_PlateOd',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#plate_od").select2({
            data: response
          })
          $("#plate_od").val($('#hubPlateOd').val());
          // alert(deliveryPartyId)
          $('#plate_od').trigger('change');
        }
      }
    });

  } else if (indent_for == 3) {
    $.ajax({
      url: base_url + 'admin/indent/master/Fan_Stack/Dimension/list_Dimension',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#dimension").select2({
            data: response
          })
          $("#dimension").val($('#FanStackdimension').val());

          $('#dimension').trigger('change');
        }
      }
    });

    $.ajax({
      url: base_url + 'admin/indent/master/Hub/Material/list_Material',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#material").select2({
            data: response
          })
          $("#material").val($('#Fanmaterial').val());

          $('#material').trigger('change');
        }
      }
    });
    $.ajax({
      url: base_url + 'admin/indent/master/Fan_Stack/Height/list_Height',
      type: "post",
      dataType: 'json',
      success: function (response) {
        //alert($('#company_id').val())
        if (response) {
          $("#height").select2({
            data: response
          })
          $("#height").val($('#Fanheight').val());

          $('#height').trigger('change');
        }
      }
    });



  }
}

function indentGetLock(indent_id, is_lock) {
  if (is_lock == 1) {
    msg = "Are you sure For Lock this indent";
  } else {
    msg = "Are you sure For UnLock this indent";
  }

  if (confirm(msg)) {
    // User clicked "OK"
    $.ajax({
      url: base_url + "admin/indent/Indent/IndentLock",
      type: "post",
      dataType: "json",
      data: {
        indent_id: indent_id,
        is_lock: is_lock,
      },
      success: function (response) {
        if (response.result) {
          alert_float("success", response.reasons);
          $("#indent").DataTable().ajax.reload();
          $("#indent").DataTable().draw();
          // location.reload();$("#tbl_indent_details").
        } else {
          alert_float("danger", response.reasons);
        }
      },
    });
  } else {
    // // User clicked "Cancel"
    // console.log("User canceled the action.");
  }

}



