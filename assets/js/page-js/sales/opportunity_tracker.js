function opp_tracker_filter(){

    var status_id = $('#status_id').val(); 
    var plant_id = $('#plant_id').val(); 
    var customerid = $('#customerid').val();

    var data = {     
       'status_id' : status_id,
        'plant_id' : plant_id,
        'customerid' : customerid,
       };
    list_opportunity_tracker(data);
  }

$('#customerid').select2({
  ajax: {
    url: base_url + 'admin/Common/listCompanyName',
    dataType: 'json',
    delay: 250,
    data: function (data) {

      return {
        searchTerm: data.term,
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

$('#plant_id').select2({
  ajax: {
    url: base_url + 'admin/Common/plant_name_list',
    dataType: 'json',
    delay: 250,
    data: function (data) {
      return {
        searchTerm: data.term,
        'customer_id': $('.customer_name').val(),
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
  
   var opportunity_tracker = '';
  function list_opportunity_tracker(data='') {
    
    opportunity_tracker = $('#tbl_opp_tracker').DataTable({
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
          url: base_url +'admin/sales/OpportunityTracker/list_opportunity_tracker',
          type: 'POST',
          dataSrc: function (response) {
                // Log total count here
                 $('.total_count').text(response.total_count);
                return response.data;

            },
          data:data,

      },

      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Title" },
          {  title: "Plant Name" },  
          {  title: "Customer Name" },  
          {  title: "Contact Person Name" },
          {  title: "Contact Person Mobile No" },
          {  title: "Status" },
          {  title: "Date" },
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],

    });

   // console.log(parseInt(dataSrc));
  }


  $(document).ready(function() {
    opp_tracker_filter();
    
});



  $('.opp_tracker_modal').on('click', function() {
    opp_tracker_modal();
  });

  function opp_tracker_modal(id='',type='') {
    // alert(type);
    $.ajax({
          url: base_url +'admin/sales/OpportunityTracker/opp_tracker_modal',
          type: 'POST',
          data: {'id':id,'type' : type},
          dataType:'json',
          success: function(res) {
              $('#_opp_tracker').html();
            if (res.result == true) {
              $('#_opp_tracker').html(res.html);
              $('#opp_tracker_modal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  


    function remove_file_attch(opportunity_tracker_id)
    {
        // alert(po_attachment_id);
        $.ajax({
           url: base_url + 'admin/sales/OpportunityTracker/remove_opportunity_tracker_attachment',
           type: 'post',
           dataType: 'json',
           data: {
              'opportunity_tracker_id': opportunity_tracker_id,
           },
           success: function (response) {
              if (response.result == true) {
                 // alert_float('success', response.reason);
                $('#remove_file_attch_'+opportunity_tracker_id).remove();
               
              } else {
                 // alert_float('danger', response.reason);
              }

           }

        });
    }

function changeFavouriteFlag(id, is_favourite = '') {
    $.ajax({
        url: base_url + 'admin/sales/OpportunityTracker/changeFavouriteFlag',
        type: 'get',
        data: { 'id': id, 'is_favourite': is_favourite },
        dataType: 'json',
        success: function (response) {
            if (response.result == true) {
                // Load the updated content of the div
                $('#refresh_flag_' + id).load(location.href + ' #refresh_flag_' + id);
                alert_float('success', response.reason);
                // Set tooltip message on success
                $('#refresh_flag_' + id).attr('title', response.reason);
            } else {
                alert_float('error', response.reason);
                // Set tooltip message on error
                $('#refresh_flag_' + id).attr('title', response.reason);
            }
        }
    });
}






// function changeFavouriteFlag(id, is_favourite = '') {
//     $.ajax({
//         url: base_url + 'admin/sales/OpportunityTracker/changeFavouriteFlag',
//         type: 'get',
//         data: { 'id': id, 'is_favourite': is_favourite },
//         dataType: 'json',
//         success: function (response) {
//             if (response.result == true) {
//                 // Load the updated content of the div
//                 $('#refresh_flag_' + id).load(location.href + ' #refresh_flag_' + id);

//                 alert_float('success', response.reason);
//             } else {
//                 alert_float('error', response.reason);
//             }
//         }
//     });
// }

