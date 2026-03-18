function filter_lead(){

    var type = $('#type').val(); 
    var status_id = $('#status_id').val(); 
    var assigned_id = $('#assigned_id').val(); 
    var source_id = $('#source_id').val(); 
    var state_id = $('#state_id').val(); 

    
   
    var data = {
          'type':type,
          'status_id':status_id,
          'assigned_id':assigned_id,
          'source_id':source_id,
          'state_id':state_id,
        
        };
    listlead(data);
  }
  var lead = '';
  function listlead(data='') {
    
    lead = $('#lead').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[1, "desc"]],
      ajax: {
          url: base_url +'admin/sales/lead/listlead',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "5%", title: "Sr._No.", orderable:false },
           
          { "width": "10%", title: "Name" }, 
           { "width": "10%", title: "Email" },
            { "width": "10%", title: "Phone" },
            { "width": "10%", title: "Assigned" },
          
            { "width": "10%", title: "Lead Source" },
            { "width": "10%", title: "Last Contact" },
            { "width": "10%", title: "Created" },
            { "width": "10%", title: "Requirement" },
              { "width": "10%", title: "Status" },
          // { "width": "10%", title: "District Name" },rto_code
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],


     
    });
     
  } 
$(document).ready(function() {

  filter_lead();

});

  $('.leadModal').on('click', function() {
    leadModal();
  });

  function leadModal(id='') {

    $.ajax({
          url: base_url +'admin/sales/Lead/leadModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#leadModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }

function lead_follow_up_modal(follow_up_id='') {
  
  // if (follow_up_id == '') {
  //   $('#lead_follow_up_modal').modal('show');
  // } else {
     var id = $('#id').val(); 
      $.ajax({
          url: base_url + 'admin/sales/Lead/lead_follow_up_modal',
          type: 'POST',
          data: {
              'id': id,
              'follow_up_id': follow_up_id 
          },
          dataType: 'json',
          success: function(res) {
              if (res.result == true) {
                  $('#_follow_up').html(res.html);
                  $('#lead_follow_up_modal').modal('show');
              } else {
                  alert_float('error', res.reason);
              }
          }
      });
    //}
}


$('.reminderModal').on('click', function() {
    reminderModal();
  });

  function reminderModal(id='') {
 
    $.ajax({
          url: base_url +'admin/sales/Lead/reminderModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#reminderModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
$('.source_name').select2({
            ajax: {
                // url:base_url +'admin/Common/listCityName',       
                url:base_url +'admin/Common/listsourceNameform',       
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
$('.assigned').select2({
            ajax: {
                 // url:base_url +'admin/Common/listassignedNameform',       
                url:base_url +'admin/Common/listassignedNameform',       
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



$('.lead_status').select2({
            ajax: {
                // url:base_url +'admin/Common/listCityName',       
                url:base_url +'admin/Common/listatusNameform',       
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

$('.status_id').select2({
            ajax: {
                // url:base_url +'admin/Common/listCityName',       
                url:base_url +'admin/Common/listatusName',       
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



$('.assigned_id').select2({
            ajax: {
                // url:base_url +'admin/Common/listCityName',       
                url:base_url +'admin/Common/listassignedName',       
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


        

        $('.source_id').select2({
            ajax: {
                // url:base_url +'admin/Common/listCityName',       
                url:base_url +'admin/Common/listsourceName',       
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


