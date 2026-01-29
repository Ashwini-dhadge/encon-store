function filter_termcondition(){

    var type = $('#type').val(); 
    
    var data = {
          'type':type,
        
        };
    listtermcondition(data);
  }
  var termcondition = '';
  function listtermcondition(data='') {
    
    termcondition = $('#termcondition').DataTable({
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
          url: base_url +'admin/master/TermCondition/listtermcondition',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "5%", title: "Sr._No.", orderable:false },
           
          { "width": "5%", title: "Title" }, 
           { "width": "10%", title: "Terms Conditions" },
           
          // { "width": "10%", title: "District Name" },rto_code
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
     
  } 
$(document).ready(function() {

  filter_termcondition();

});

  $('.termconditionModal').on('click', function() {
    termconditionModal();
  });

  function termconditionModal(id='') {

    $.ajax({
          url: base_url +'admin/master/TermCondition/termconditionModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#termconditionModal').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
