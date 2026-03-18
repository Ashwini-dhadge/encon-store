function vendor_filter(){
   var comp_id = $('#comp_id').val();
   var id_city = $('#id_city').val();
   var pan_nm = $('#pan_nm').val();
   var tin_nm = $('#tin_nm').val();

    var data = {     
           'comp_id' : comp_id,
           'id_city': id_city,
           'pan_nm': pan_nm,
           'tin_nm': tin_nm,
       };
    listVendor(data);
  }

  
  
  
   var vendor = '';
  function listVendor(data='') {
    
     vendor = $('#vendor_tbl').DataTable({
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
          url: base_url +'admin/Vendor/listVendor',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "Vendor Code" },  
          {  title: "Vendor Name" },  
          {  title: "Email" },
          {  title: "Phone No" },
          {  title: "Address" },
          {  title: "City Name" },
          {  title: "PAN No." },
          {  title: "GST No." },
          {  title: "TAN No." },
          {  title: "TIN No." },
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }

  
  $(document).ready(function() {
    vendor_filter();
    
});



$('.company_name').select2({
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

$('.site_name').select2({
            ajax: {
                url:base_url +'admin/Common/listSiteName',       
                  dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term,
                        company_id: $('.company_name').val()// search term
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

$('.city_name').select2({
            ajax: {
                url:base_url +'admin/Common/listCityName',       
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

    $('.vendor_name').select2({
            ajax: {
                url:base_url +'admin/Vendor/listVendorName',       
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


    // $('.filter_clear').on('click', function() {
    //    $('#vendor_name').empty('');
    //    $('#id_city').empty('');
    //    $('.pan_nm').val('1');
    //    $('.tin_nm').val('1');
       
    // });


    function remove_file_attch(vendor_attachment_id)
    {
        // alert(po_attachment_id);
        $.ajax({
           url: base_url + 'admin/Vendor/remove_vendor_attachment',
           type: 'post',
           dataType: 'json',
           data: {
              'vendor_attachment_id': vendor_attachment_id,
           },
           success: function (response) {
              if (response.result == true) {
                 // alert_float('success', response.reason);
                $('#remove_file_attch_'+vendor_attachment_id).remove();
                // $('#remove_file_attch_id_'+po_attachment_id).remove();
                
              } else {
                 // alert_float('danger', response.reason);
              }

           }

        });
    }

