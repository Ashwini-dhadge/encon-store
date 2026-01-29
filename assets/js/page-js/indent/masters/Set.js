function filter_set(){

  var type = $('#type').val(); 
 
 
  var data = {
        'type':type,
     
      };
      listSet(data);
}
var set = '';
function listSet(data='') {
  
  set = $('#set').DataTable({
   
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
        url: base_url +'admin/indent/master/Blade/Set/listSet',
        type: 'POST',
        dataSrc: "data",
        data:data,
    },
    columnDefs: [{responsivePriority: 1 ,targets: 2}],

     columns: [        
        { "width": "2%", title: "Sr._No.", orderable:false },
        { "width": "10%", title: "Name" }, 
     
        { "width": "5%", title: "Action" , orderable:false, "className": "text-center"},
    ],
   
  });
   
} 
$(document).ready(function() {

  filter_set();

});

$('.setModal').on('click', function() {
  setModal();
});

function setModal(id='') {
console.log("jdf");
  $.ajax({
        url: base_url +'admin/indent/master/Blade/Set/setModal',
        type: 'POST',
        data: {'id':id},
        dataType:'json',
        success: function(res) {
            $('#_banner2').html();
          if (res.result == true) {
            $('#_banner2').html(res.html);
            $('#setModal').modal('show');
            // $("#catdrop").select2();
          }else{
            alert_float('error',response.reason);
          }
        }
    })
}

