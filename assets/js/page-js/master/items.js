function items_filter(){
   var item_name = $('#item_name').val();
   var id_itemgroup = $('#id_itemgroup').val();
   var id_stock = $('#id_stock').val();
   
     var data = {     
       'item_name' : item_name,
       'id_itemgroup' : id_itemgroup,
       'id_stock' : id_stock,
        };
    listItems(data);
  }
  var items = '';
  function listItems(data='') {
    
     items = $('#items_tbl').DataTable({
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
          url: base_url +'admin/master/Items/listItems',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false, width:"5%"},
          {  title: "Item Name" ,width:"20%"},  
          {  title: "Short Name",width:"15%" },
            {  title: "Item Code",width:"15%" },
          {  title: "Hsn Code",width:"5%" },
        // {  title: "Item Group" },
          {  title: "Stock Unit" ,width:"5%" },
          {  title: "Item Group" ,width:"5%" },
          {  title: "Rate" ,width:"5%" },
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
      render: function ( data, type, row ) {
        return '<span style="white-space:nowrap">' + data + "</span>";
        }
     
    });

  }

  
  $(document).ready(function() {
    items_filter();
    
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

$('.stock_unit_name').select2({
    ajax: {
        url:base_url +'admin/master/Items/liststock_unit',       
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

$('.item_name').select2({
            ajax: {
                url:base_url +'admin/master/Items/listItemName',       
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