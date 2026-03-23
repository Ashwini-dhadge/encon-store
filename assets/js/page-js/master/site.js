function filter_site(){

    var type = $('#type').val(); 
    var company_name = $('#company_name').val();      
    var company_id = $('#companynm').val();  
    var company_id = $('#company_id').val();  
   
    var data = {
          'type':type,
         'company_name' :company_name,
         'company_id' :company_id,
        };
    listsite(data);
  }
  var site = '';
  function listsite(data='') {
    
    site = $('#site').DataTable({
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
          url: base_url +'admin/master/Site/listsite',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "5%", title: "Sr._No.", orderable:false },
          { "width": "5%", title: "Company" }, 
          { "width": "10%", title: "Site Name" },
          { "width": "5%", title: "Site Short" },
          { "width": "5%", title: "Site Initial" },
          { "width": "10%", title: "Site Address" },
          // { "width": "10%", title: "District Name" },rto_code
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_site();

});

  $('.siteModal').on('click', function() {
    siteModal();
  });

  function siteModal(id='') {

    $.ajax({
          url: base_url +'admin/master/Site/siteModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#siteModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
