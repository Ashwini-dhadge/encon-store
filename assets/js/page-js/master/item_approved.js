function filter_item_approved(){

    var type = $('#type').val(); 
    var item_group_name = $('#item_group_name').val();      
    var item_name_id = $('#item_name_id').val();  
    var vendor_id = $('#vendor_id').val();  
    var company_id = $('#company_id').val();  
    var site_id = $('#site_id').val();  
    var is_approved = $('#is_approved').val();
   
    var data = {
        'type':type,
        'item_group_name' : item_group_name,      
        'item_name_id' : item_name_id,
        'vendor_id' : vendor_id,
        'company_id' : company_id,
        'site_id' : site_id,
        'is_approved' : is_approved,
        };

    listApproveData(data);
  }
  






  var approveData = '';
  function listApproveData(data='') {
    
    approveData = $('#tbl_item_approved_list').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[0, "desc"]],
      ajax: {
          url: base_url +'admin/master/ItemApprovedRate/listItemApproved',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          {  title: "Sr._No.", orderable:false },
          {  title: "Po Order No" },
          {  title: "Item Group Name" }, 
          {  title: "Item Name" },
          {  title: "Vendor Name" },
          {  title: "Company Name" },
          {  title: "Site Name" },
          {  title: "Old Rate" },
          {  title: "New Rate" },
          {  title: "Approved" },
          {  title: "Approved By" },
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_item_approved();

});

  // $('.StatusUpdateModal').on('click', function() {
  //   StatusUpdateModal();
  // });

  function StatusUpdateModal(id='') {

    $.ajax({
          url: base_url +'admin/master/ItemApprovedRate/StatusUpdateModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_StatusUpdate').html();
            if (res.result == true) {
              $('#_StatusUpdate').html(res.html);
              $('#StatusUpdateModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  

// function changeStatus(id,is_approved='') {
//   $.ajax({
//     url:base_url +'admin/master/ItemApprovedRate/changeStatus',   
//     type:'get',
//     data:{'id':id, 'is_approved': is_approved},
//     dataType:'json',
//     success: function(response) {
//       if (response.result == true) {
//         if (is_approved == 1) {
//         $('#is_approved'+id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'changeStatus('+id+',2)','title':'Click for Reject'}).text('Approve');
//         }else{
//         $('#is_approved'+id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'changeStatus('+id+',1)','title':'Click for Approve'}).text('Reject');
//         }
//          $('#tbl_item_approved_list').DataTable().ajax.reload();
//         alert_float('success',response.reason);
//       }else{
//         alert_float('error',response.reason);
//       }
//     }
//   });
// }


$('#company_id').select2({
    ajax: {
        url:base_url +'admin/Common/listCompanyName',       
        dataType: 'json',
        delay: 250,
        data: function (data) {
            return {
                searchTerm: data.term,
            };
        },
        processResults: function (response) {
            return {
                results:response
            };
        },
        cache: true
    }

});


$('#site_id').select2({
    ajax: {
        url:base_url +'admin/Common/listSite',       
        dataType: 'json',
        delay: 250,
        data: function (data) {
   
            return {
                searchTerm: data.term,
                company_id:$('#company_id').val()
            };
        },
        processResults: function (response) {
            return {
                results:response
            };
        },
        cache: true
    }

});

$('#vendor_id').select2({
    // placeholder: 'Select an state',
    ajax: {
        url:base_url +'admin/Common/listvender_name', 
        dataType: 'json',
        delay: 250,
        data: function (data) {
   
            return {
                searchTerm: data.term                       
            };
        },
        processResults: function (response) {
            return {
                results:response
            };
        },
        cache: true
    }
});


$('#item_group_name').select2({
    ajax: {
        url:base_url +'admin/Common/listitem_group_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });


$('#item_name_id').select2({
    ajax: {
        url:base_url +'admin/Common/list_item_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                    item_group_name_id:$('#item_group_name').val()
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });


    // $('#company_id').on('change', function() {
    //     $('#site_id').empty();$('#vendor_id').empty();$('#item_group_name').empty();$('#item_name_id').empty();
    // });

    // $('#site_id').on('change', function() {
    //     $('#vendor_id').empty();$('#item_group_name').empty();$('#item_name_id').empty();
    // });
    // $('#vendor_id').on('change', function() {
    //     $('#item_group_name').empty();$('#item_name_id').empty();
    // });
    //  $('#item_group_name').on('change', function() {
    //    $('#item_name_id').empty();
    // });

