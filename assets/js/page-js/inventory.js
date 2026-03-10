function inventory_filter(){

    var material_issue_id = $('#material_issue_id').val();
    var companyid = $('#companyid').val();
    var site_id = $('#site_id').val();
    var inventory_item_id = $('#inventory_item_id').val();

     var data = {    
            'material_issue_id' : material_issue_id,
            'companyid': companyid,
            'site_id': site_id, 
            'inventory_item_id': inventory_item_id,
          };


    list_inventory_data(data);
    // list_inventory_details_information(data);
   
  }
  var inventory_data = '';
  function list_inventory_data(data='') {
    
     inventory_data = $('#inventory_tbl').DataTable({
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
          url: base_url +'admin/Inventory/list_inventory_data',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Item Name" },  
          {  title: "Unit Name" },
          {  title: "Quantity" },
          {  title: "Company Name" },  
          {  title: "Site Name" },   
          {  title: "Financial_year_id" },  
          {  title: "Action" , orderable:false, "className": "text-center"},
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
    var inventory_item_id_a = $('#inventory_item_id_a').val();
    var inv_item_unit_id = $('#inv_item_unit_id').val();

     var data = {    
           'material_issue_id' : material_issue_id,
            'companyid_a': companyid_a,
            'site_id_a': site_id_a, 
            'inventory_item_id_a': inventory_item_id_a,
            'inv_item_unit_id' : inv_item_unit_id,
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
            
            $('#final_amount').text(total_final_total);
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


  $('#companyid').on('change', function () {
   $('#site_id').empty();
  });  


  $('#reset_filter').on('click', function () {
    $('#inventory_item_id_a').empty();
    $('#companyid_a').empty(); $('#site_id_a').empty();

  });  

  $('#companyid_a').on('change', function () {
   $('#site_id_a').empty();
  });  

 $('#inventory_item_id_a').on('change', function () {
    $('#companyid_a').empty(); $('#site_id_a').empty();
    $('#inv_item_unit_id').val('');
  });  

