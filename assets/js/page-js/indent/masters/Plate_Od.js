function filter_plate(){

  var type = $('#type').val(); 
 
 
  var data = {
        'type':type,
     
      };
      listtPlateOd(data);
}
var plate = '';
function listtPlateOd(data='') {
  
  plate = $('#plate').DataTable({
   
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
        url: base_url +'admin/indent/master/Hub/Plate_Od/listtPlateOd',
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

  filter_plate();

});

$('.plateModal').on('click', function() {
  plateModal();
});

function plateModal(id='') {
console.log("jdf");
  $.ajax({
        url: base_url +'admin/indent/master/Hub/Plate_Od/plateModal',
        type: 'POST',
        data: {'id':id},
        dataType:'json',
        success: function(res) {
            $('#_banner2').html();
          if (res.result == true) {
            $('#_banner2').html(res.html);
            $('#plateModal').modal('show');
            // $("#catdrop").select2();
          }else{
            alert_float('error',response.reason);
          }
        }
    })
}

