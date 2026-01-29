 function filter_costproject(){

    var type = $('#type').val(); 
    
    var data = {
          'type':type,
        
        };
    listcostproject(data);
  }
  var costproject = '';
  function listcostproject(data='') {
    
    costproject = $('#costproject').DataTable({
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
          url: base_url +'admin/master/CostProject/listcostproject',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "5%", title: "Sr._No.", orderable:false },
           
          { "width": "5%", title: "Cost Project Name" }, 
           { "width": "10%", title: "Description" },
           
          // { "width": "10%", title: "District Name" },rto_code
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_costproject();

});


 $('.costprojectModal').on('click', function() {
    costprojectModal();
  });

  function costprojectModal(id='') {

    $.ajax({
          url: base_url +'admin/master/CostProject/costprojectModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#costprojectModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  