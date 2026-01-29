   console.log("type="+$('#type').val())

function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}
 $(document).ready(function() {
    po_filter();
$('.on_date').hide();
});

function po_filter(){  
        var received_material_issue_id = $("#received_material_issue_id").val();
        var company_id = $("#companyid_a").val();
        var site_id = $("#site_id_a").val();
        var on_date =  $("#on_date").val();
        var from_date =  $("#from_date").val();
        var to_date =   $("#to_date").val();
         var inventory_item_id = $('#inventory_items').val();

    var data = {    
                   
                   'received_material_issue_id' : received_material_issue_id,
                    'company_id' : company_id,
                    'site_id' : site_id,
                    'on_date' : on_date,
                    'from_date' : from_date,
                    'to_date' : to_date,
                    'item_id': inventory_item_id,
                 'id_itemgroup':$('#id_itemgroup').val(),
       };
    listPO(data);
      list_received_material_issue_items(data);
  }
 

  var recevie_material_list_tbl = '';
  function listPO(data='') {
    
     recevie_material_list_tbl = $('#recevie_material_list_tbl').DataTable({
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
          url: base_url +'admin/store/ReceiveMaterials/listReceviedMaterial',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
           { title: "Sr._No.", orderable:false , "className": 'details-control'},
        //   { title: "id", "visible": false},
          {  title: "Recevied No" },  
          {  title: "Received Date" },
          {  title: "Received Site Name" },
          {  title: "Sender Site Name" },
        //   {  title: "Total Item Qty" },
        //   {  title: "Transfered Name" },        
          {  title: "Recevied Name" },       
          {  title: "Status" },         
          {  title: "Action" ,className:'details-control'}  
      ],
     
    });

  } 

  


  $("#on_date").change(function () {
        var on_date = $('#on_date').val();
        // alert(on_date);
           if (on_date != 6) {
             list_received_material_issue_items();
              $('.on_date').hide();
            }else{
              $('.on_date').show();
            }
       });
 $(document).ready(function() {
$('#recevie_material_list_tbl tbody').on('click', 'tr img', function (event) {
    var id = $(this).data('id');
    event.preventDefault(); // Prevent the default action of the link
    var tr = $(this).closest('tr');
    var row = recevie_material_list_tbl.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        $.ajax({
            url: base_url + 'admin/store/ReceiveMaterials/receviedItemTableData',
            type: 'GET',
            data: { received_id: id },
            dataType: 'json',
            success: function (response) {
                innerTable = response.html;
                row.child(innerTable).show();
                tr.addClass('shown');
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
});
});

var received_material_issue_items_tbl = '';
  function list_received_material_issue_items(data='') {
    
    received_material_issue_items_tbl = $('#received_material_issue_items_tbl').DataTable({
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
          url: base_url +'admin/store/ReceiveMaterials/listReceviedMaterialItemsData',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Item Name" },  
          {  title: "Item Group Name" },   
          {  title: "Issue Qty" },  
          {  title: "Weight" },
          {  title: "Rate" },  
          {  title: "Amount" },
          // {  title: "issue_to"}
          // {  title: "Party Name" },
          // {  title: "Vehicle Name" },
          // {  title: "Other Text" },
          {  title: "Remark" },

          // {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }
  $('.inventory_item_id').select2({
        ajax: {
            url:base_url +'admin/Common/list_item_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                    'item_group_name_id':$('#id_itemgroup').val()
                    
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