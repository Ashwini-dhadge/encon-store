function inventory_filter(){

    var material_issue_id = $('#material_issue_id').val();
    var companyid = $('#companyid').val();
    var site_id = $('#site_id').val();
    var batch_no_a = $('#batch_no_a').val();
    var inventory_item_id = $('#inventory_items').val();
    var is_reserve_stock = $('#is_reserve_stock').val();
     
     var data = {    
            'material_issue_id' : material_issue_id,
            'companyid': companyid,
            'site_id': site_id, 
            'batch_no_a': batch_no_a, 
            'item_id': inventory_item_id,
            'id_itemgroup':$('#id_itemgroup').val(),
             'is_reserve_stock': is_reserve_stock,
          };


    list_inventory_data(data);
    // list_inventory_details_information(data);
   
  }
  var inventory_data = '';
  function list_inventory_data(data='') {
   var inventory_data = $('#inventory_tbl').DataTable({
    "dom": 'Bfl<"topbutton">tip',
    oLanguage: {
        sProcessing: '<div class="dt-loader"></div>'
    },
    processing: true,
    serverSide: true,
    destroy: true,
    pageLength: 25,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All']
    ],
    order: [[0, "desc"]],
    ajax: {
        url: base_url + 'admin/Inventory/list_inventory_data',
        type: 'POST',
        dataSrc: "data",
        data: data,
    },
    columnDefs: [
        { responsivePriority: 1, targets: 5 },
        { targets: [10, 11], visible: false } // Hide columns 11 and 12 initially
    ],
    columns: [
        { title: "Sr._No.", orderable: false },
        { title: "Item Group Name" },
        { title: "Item Name" },
        { title: "Unit Name" },
        { title: "Balance" },
        { title: "Batch NO" },
        { title: "Expired Date" },
        { title: "Company Name" },
        { title: "Site Name" },
        { title: "Financial_year_id" },
        { title: "Rate" },
        { title: "Total" },
        { title: "Action", orderable: false, "className": "text-center" },
    ],

    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Export Excel',
            filename: 'exported_data',
            exportOptions: {
                modifier: {
                    pageLength: -1 // Export all pages
                }
            }
        },
         {
            extend: 'pdfHtml5',
            text: 'Export pdf',
            filename: 'exported_data',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
            }
        },
        'colvis'
    ],
});
 
   


  }
  
  $(document).ready(function() {
    inventory_filter();
     inventory_filter_a();

  });



function inventory_filter_a(){
    var material_issue_id = $('#material_issue_id').val();
    var companyid_a = $('#companyid_a').val();
    var site_id_a = $('#site_id_a').val();
    var batch_no_a = $('#batch_no_a').val();
    var inventory_item_id_a = $('#inventory_item_id_a').val();
    var inv_item_unit_id = $('#inv_item_unit_id').val();
    var item_unit_id =  $('#item_unit_id').val();
    var is_reserve_stock =  $('#is_reserve_stock').val();
// alert(item_unit_id);
     var data = {    
           'material_issue_id' : material_issue_id,
            'companyid_a': companyid_a,
            'site_id_a': site_id_a, 
            'batch_no_a': batch_no_a, 
            'inventory_item_id_a': inventory_item_id_a,
            'inv_item_unit_id' : inv_item_unit_id,
            'item_unit_id' : item_unit_id,
             'is_reserve_stock' : is_reserve_stock,
          };
    list_inventory_details_information(data);
  }



  var inventory_details_data = '';
  function list_inventory_details_information(data='') {
  
     inventory_details_data = $('#inventory_details_information').DataTable({
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
          url: base_url +'admin/Inventory/list_inventory_details_information',
          type: 'POST',
          dataSrc: function (json) {

            // console.log(json.final_total);
            // Access the additional information
            var total_final_total = json.final_total;
             var total_reserve_stock = json.total_reserve_stock;
            $('#final_amount').text(total_final_total);
             $('#reserve_stock_count').text(total_reserve_stock);
            // document.getElementById("final_total_amount").innerHTML = total_response_count; 
          
            // Return the data source for DataTables
            return json.data;
        },
          data:data,

      },


      // columnDefs: [{responsivePriority: 1 ,targets: 5}],

      // columns: [        
      //     { title: "Sr._No.", orderable:false },
      //     {  title: "Description" },  
      //     {  title: "Quantity" },
      //     {  title: "Type" },
      //     {  title: "Reference Name" },
      //     {  title: "Action" },  
     
      //     // {  title: "Action" , orderable:false, "className": "text-center"},
      // ],
     
    });

  }



$('.company_id').select2({
        ajax: {
            url:base_url +'admin/Common/listCompanyName',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
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


  $('.site_id').select2({
        ajax: {
            url:base_url +'admin/Common/listSite',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                     company_id: $('#companyid').val(),// search term
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



$('#companyid_a').select2({
        ajax: {
            url:base_url +'admin/Common/listCompanyName',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
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


  $('#site_id_a').select2({
        ajax: {
            url:base_url +'admin/Common/listSite',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                     company_id: $('#companyid_a').val(),// search term
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


  $('#batch_no_a').select2({
        ajax: {
            url:base_url +'admin/Common/listbatchno',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                    inventory_item_id_a: $('#inventory_item_id_a').val(),// search term
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


 


  $('#inventory_item_id_a').select2({
        ajax: {
            url:base_url +'admin/Common/listInventoryItemName',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                    
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


$('#item_unit_id').select2({
        ajax: {
            url:base_url +'admin/Inventory/listInventoryUnitName',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                    
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


  $('#companyid').on('change', function () {  filename: 'exported_data',
   $('#site_id').empty();
  });  


  $('#reset_filter').on('click', function () {
    $('#inventory_item_id_a').empty();
    $('#companyid_a').empty(); $('#site_id_a').empty();
    $('#batch_no_a').empty();$('#item_unit_id').empty();

  });  

  $('#companyid_a').on('change', function () {
   $('#site_id_a').empty();$('#batch_no_a').empty();
   $('#item_unit_id').empty();
  });  

 $('#inventory_item_id_a').on('change', function () {
    $('#companyid_a').empty(); $('#site_id_a').empty();
    $('#inv_item_unit_id').val('');$('#batch_no_a').empty();
    $('#item_unit_id').empty();
  });  

$('.item_group_name').select2({
    ajax: {
        url:base_url +'admin/master/Items/listItemgroupName',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
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
    
    
  $('#item_name_id').select2({
        ajax: {
            url:base_url +'admin/Common/list_item_name',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                    'item_group_name_id':$('#item_group_id').val()
                    
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
