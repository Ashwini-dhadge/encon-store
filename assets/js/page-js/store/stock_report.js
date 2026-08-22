function stock_report_filter(){
var company_id = $('#company_id').val();  
var site_id = $('#site_id').val(); 
// var item_group_id = $('#item_group_id').val(); 


     var data = {    
       
        'company_id' : company_id,
        'site_id' : site_id,
        // 'item_group_id' : item_group_id,
       
          
        };

  }



   $(document).ready(function() {
    stock_report_filter();
    setUpdateData();
});
function emptySite() {
   $('#site_id').val(null).trigger('change');
   $.ajax({
        url:base_url +'admin/store/StockReport/listSite', 
        type: "post",
        dataType: 'json',
        data:{company_id:$('#company_id').val()},
        
        success: function(response) {
            //alert($('#company_id').val())
            if (response) {
                $("#site_id").select2({
                    data: response
                })
                // $("#site_id").val($('#site_id_session').val());
                // alert(deliveryPartyId)
                // $('#site_id').trigger('change');
            }
        }
    });
  // Add your code here to perform actions based on the selected value
}
function setUpdateData(){
     $.ajax({
       url: base_url + 'admin/store/StockReport/listCompanyName',  
        type: "post",
        dataType: 'json',
        success: function(response) {

            if (response) {
                $("#company_id").select2({
                    data: response
                })
                $("#company_id").val($('#company_id_session').val());
                // alert(deliveryPartyId)
                $('#company_id').trigger('change');

            }
        }
    });
     $.ajax({
        url:base_url +'admin/store/StockReport/listSite', 
        type: "post",
        dataType: 'json',
        data:{company_id:$('#company_id_session').val()},
        
        success: function(response) {
            //alert($('#company_id').val())
            if (response) {
                $("#site_id").select2({
                    data: response
                })
                $("#site_id").val($('#site_id_session').val());
                // alert(deliveryPartyId)
                $('#site_id').trigger('change');
            }
        }
    });

}

   $('#company_id').select2({
        ajax: {
            url: base_url + 'admin/store/StockReport/listCompanyName',        
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });



   $('#site_id').select2({
    ajax: {
        // url:base_url +'admin/Common/listSite',       
        url:base_url +'admin/store/StockReport/listSite',       
        dataType: 'json',
        delay: 250,
        data: function (data) {
   
            return {
                searchTerm: data.term,
                company_id:$('#company_id').val()
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


   $('.item_group_select2').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/PO/listItemGroup',      
                // url:base_url +'/admin/master/Items/listItemgroupName',
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term                       
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