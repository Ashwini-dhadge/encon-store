   console.log("type="+$('#type').val())

function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}
 $(document).ready(function() {
    po_filter();
  getVendorSiteData();
   $('.on_date').hide();
});
function getVendorSiteData(){
        let vendorId=$('#vendorId').val();      
        let transportId=$('#vendorId').val();  
        let type=$('#type').val();      
           if(type==2){
            $.ajax({
                  url:base_url +'admin/Vendor/listVendorName',    
                  type: "post",              
                  dataType: 'json',
                  success: function(response) {
                    
                      if(response){
                        $("#account_name").select2({                       
                              data: response
                        })       
                      
                        $('#account_name').val(vendorId); // Select the option with a value of '1'
                        $('#account_name').trigger('change'); // Notif
                        
                          $("#transporter").select2({                       
                              data: response
                        })       
                      
                        $('#transporter').val(transportId); // Select the option with a value of '1'
                        $('#transporter').trigger('change'); // Notif
                        
                        
                        
                      
                      }                
                  }
              });
           }
     

}
function po_filter(){  
          var material_issue_id = $("#material_issue_id").val();
        var company_id = $("#companyid_a").val();
        var site_id = $("#site_id_a").val();
        var on_date =  $("#on_date").val();
        var from_date =  $("#from_date").val();
        var to_date =   $("#to_date").val();
      
        var inventory_item_id = $('#inventory_items').val();

    var data = {    

                'material_issue_id' : material_issue_id,
                'company_id' : company_id,
                'site_id' : site_id,
                'on_date' : on_date,
                'from_date' : from_date,
                'to_date' : to_date,
                'item_id': inventory_item_id,
                 'id_itemgroup':$('#id_itemgroup').val(),
                // 'vendor_id':$('#vendor_id').val(),/

            };
    listPO(data);
     list_material_items_issue(data)
  }
 

  var recevie_material_issue_tbl = '';
  function listPO(data='') {
    
     recevie_material_issue_tbl = $('#recevie_material_issue_tbl').DataTable({
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
          url: base_url +'admin/store/ReceiveMaterials/listMaterialIssue',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false ,width:"5%"},
          {  title: "Issue No" ,width:"10%"},  
          {  title: "Issue Transfer Date" ,width:"15%"},
          {  title: "Send Site Name" ,width:"15%"},
          {  title: "Recevier Site Name" ,width:"10%"},
          {  title: "Total Item Qty" ,width:"5%"},
          {  title: "Total Pending Qty",width:"5%" },          
          {  title: "Status" ,width:"5%"},         
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }

  


  $("#on_date").change(function () {
        var on_date = $('#on_date').val();
        // alert(on_date);
           if (on_date != 6) {
              po_filter();
              $('.on_date').hide();
            }else{
              $('.on_date').show();
            }
       });




var material_issue_items = '';
  function list_material_items_issue(data='') {
    
    material_issue_items = $('#items_material_issue').DataTable({
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
          url: base_url +'admin/store/ReceiveMaterials/list_material_issue_items_data',
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
          {  title: "Returnable" },
        //   {  title: "Returnable Date" },
          // {  title: "issue_to"}
          // {  title: "Party Name" },
          // {  title: "Vehicle Name" },
          // {  title: "Other Text" },
          {  title: "Remark" },

          // {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }


$(document).ready(function() {
    $('#recevie_material_issue_tbl tbody').on('click', 'tr img', function(event) {
        var id = $(this).data('id');
        event.preventDefault(); // Prevent the default action of the link
        var tr = $(this).closest('tr');
        var row = recevie_material_issue_tbl.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.ajax({
                url: base_url + 'admin/store/ReceiveMaterials/receviedInnearItemTableData',
                type: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    innerTable = response.html;
                    row.child(innerTable).show();
                    tr.addClass('shown');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

});

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
$('#vendor_id').select2({
    // placeholder: 'Select an state',
    ajax: {
        url: base_url + 'admin/Common/listvender_name',
        dataType: 'json',
        delay: 250,
        data: function(data) {

            return {
                searchTerm: data.term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    }
});