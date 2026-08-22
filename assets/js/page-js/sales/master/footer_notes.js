 function filter_footer_notes(){

    var type = $('#type').val(); 
    var data = {
          'type':type,
        };
    listfooter_notes(data);
  }
  var footer_notes = '';
  function listfooter_notes(data='') {
    
    footer_notes = $('#footer_notes').DataTable({
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
          url: base_url +'admin/sales/master/FooterNotes/listfooter_notes',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "2%", title: "Sr._No.", orderable:false },
          { "width": "5%", title: "Title" }, 
          { "width": "20%", title: "Description" },
          { "width": "5%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_footer_notes();

});

  $('.FooterNotesModal').on('click', function() {
    FooterNotesModal();
  });

  function FooterNotesModal(id='') {

    $.ajax({
          url: base_url +'admin/sales/master/FooterNotes/FooterNotesModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#FooterNotesModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
