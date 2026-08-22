 function filter_technical_specification(){

    var type = $('#type').val(); 
    var data = {
          'type':type,
        };
    listtechnical_specification(data);
  }
  var technical = '';
  function listtechnical_specification(data='') {
    
    technical = $('#technical_specification').DataTable({
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
          url: base_url +'admin/sales/master/TechnicalSpecification/listtechnical_specification',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "5%", title: "Sr._No.", orderable:false },
          { "width": "5%", title: "Title" }, 
          { "width": "10%", title: "Values" },
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_technical_specification();

});

  $('.TechnicalSpecificationModal').on('click', function() {
    TechnicalSpecificationModal();
  });

  function TechnicalSpecificationModal(id='') {

    $.ajax({
          url: base_url +'admin/sales/master/TechnicalSpecification/TechnicalSpecificationModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#TechnicalSpecificationModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
