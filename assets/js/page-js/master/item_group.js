function filter_itemgroup(){

    var type = $('#type').val(); 
    var item_type_id = $('#item_type_id').val();      
     var item_type_id = $('#item_type').val();   
    var item_group_name = $('#item_group_name').val();  
    var primary_group = $('#primary_group').val();  
   
    var data = {
          'type':type,
          'item_type_id' :item_type_id,
         'item_group_name' :item_group_name,
         'primary_group' :primary_group,
        };
    listitemgroup(data);
  }
  var itemgroup = '';
  function listitemgroup(data='') {
    
    itemgroup = $('#itemgroup').DataTable({
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
          url: base_url +'admin/master/ItemGroup/listitemgroup',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
       columnDefs: [{responsivePriority: 1 ,targets: 3}],

       columns: [        
          { "width": "5%", title: "Sr._No.", orderable:false },
           
          { "width": "5%", title: "Item Group Name" }, 
           { "width": "10%", title: "Item Type" },
          //  { "width": "10%", title: "Parent Group" },
            { "width": "10%", title: "Primary Group" },
          { "width": "10%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });
  }

  $(document).ready(function() {

  filter_itemgroup();

});


$("#item_type_id").select2({
  ajax: {
    url: base_url +'admin/master/ItemGroup/listItemGroupName',
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
  

 
  $('#primary_group').select2({

            ajax: {
                url:base_url +'admin/master/ItemGroup/itemgrouplist',       
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