function filter_emailtemplate(){

    var type = $('#type').val(); 
    
    var data = {
          'type':type,
        
        };
    listemailtemplate(data);
  }
  var emailtemplate = '';
  function listemailtemplate(data='') {
    
    emailtemplate = $('#emailtemplate').DataTable({
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
          url: base_url +'admin/master/EmailTemplate/listemailtemplate',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 2}],

       columns: [  
              
          { "width": "2%", title: "Sr._No.", orderable:false },
          { "width": "20%", title: "Massage" },
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_emailtemplate();

});

  $('.emailtemplateModal').on('click', function() {
    emailtemplateModal();
  });

  function emailtemplateModal(id='') {

    $.ajax({
          url: base_url +'admin/master/EmailTemplate/emailtemplateModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#emailtemplateModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
