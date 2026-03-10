

function po_filter(){
  
    listItemsData(data);
    
  }

  var item_list = '';
  function listItemsData(data='') {
    
     item_list = $('#item_list_tbl').DataTable({
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
          url: base_url +'admin/PO/listItemsData',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      // columnDefs: [{responsivePriority: 1 ,targets: 5}],

      // columns: [        
      //     { title: "Sr._No.", orderable:false },
      //     {  title: "Item" },  
      //     {  title: "Item Description" },
      //     {  title: "Other Description" },
      //     {  title: "Technical Description" },
      //     {  title: "Dispatch_1 Lot Date" },
      //     {  title: "Dispatch_1 Lot Qty" },
      //     {  title: "Total AMount" , orderable:false, "className": "text-center"},
      // ],
     
    });

  }

 $('.item_group_select2').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/PO/listItemGroup',       
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
function getItemList(items){
     var name = items.name;

    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
    // console.log("row_index="+row_index)
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
     $.ajax({
              url: base_url + 'admin/PO/getItemData',
              type: "post",  
              data: {'item_group_id':items.value},            
              dataType: 'json',
              success: function(response) {
                // console.log(response.data)
                  if(response.result){
                    selectElement.select2({                         
                          data: response.data
                        })
                   
                    
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
    }
    
function getItemUnits(items) {
    var event=items;
     var name = items.name;
   
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
     $.ajax({
              url: base_url + 'admin/PO/getItemUnitsData',
              type: "post",  
              data: {'item_id':items.value},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                  
                   $('input[name="items['+row_index+'][item_hsc_code]"]').val( response.data_item.hsn_code)
                   $('input[name="items['+row_index+'][item_unit_rate]"]').val( response.data_item.rate)
                    
                    var unitElement = $('select[name="items['+row_index+'][item_unit_id]"]');

                    // Append new options to the <select> element
                    $.each( response.data, function (index, option) {
                        unitElement.append($('<option>', {
                            value: option.item_unit_id,
                            text: option.short_name
                        }));
                    });
                    getItemUnitsStock(event)

                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
      // calculatePOItem(items);
}
function getItemUnitsStock(items) {
     var name = items.name;
     console.log("sd12")
    // Regular expression to match the content between the first pair of square brackets
    var match = name.match(/\[([^\]]+)\]/);

    // Extract the content between the brackets (including the brackets)
    var row_index = match ? match[1] : null;
  
    var selectElement = $('select[name="items['+row_index+'][items_id]"]');
     var item_unit = $('select[name="items['+row_index+'][item_unit_id]"]').val();
        console.log(items.value)
            console.log(item_unit)
    
     $.ajax({
              url: base_url + 'admin/PO/getItemUnitsStock',
              type: "post",  
              data: {'item_id':items.value,'item_unit_id':item_unit},            
              dataType: 'json',
              success: function(response) {
               
                  if(response.result){
                  
                   $('input[name="items['+row_index+'][item_stock_qty]"]').val( response.stock)
                   
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
      // calculatePOItem(items);
}
function add_value(element) {
    
        // Get the selected option
        var selectedOption = $(element).find(":selected");

        // Access the data attribute
        var tax_rate = selectedOption.data("tax_rate");
        var name = element.name;  
        
        var match = name.match(/\[([^\]]+)\]/);

        var row_index = match ? match[1] : null;
        // console.log("row_index="+row_index)

        // Display the data attribute value
        // console.log("Selected Option Price: " + tax_rate);
         $('input[name="items['+row_index+'][tax_rate]"]').val( tax_rate)
      
       calculatePOItem(element)
     
}
function add_value_additional(element) {
    
        // Get the selected option
        var selectedOption = $(element).find(":selected");

        // Access the data attribute
        var tax_rate = selectedOption.data("tax_rate");
        var name = element.name;  
        
        var match = name.match(/\[([^\]]+)\]/);

        var row_index = match ? match[1] : null;
        // console.log("row_index="+row_index)

        // Display the data attribute value
        // console.log("Selected Option Price: " + tax_rate);
         $('input[name="items['+row_index+'][additional_tax_rate]"]').val( tax_rate);

         calculatePOItem(element);
      
     
}
$('.get_vendor').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Vendor/listVendorName',       
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

    $('#billing_site_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listSite',       
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term,
                         company_id:company_id,// search term
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
    $('#delivery_site_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listSite',       
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
function CheckEmptyInputs() {
            var empty_count = 0;
            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;

                // console.log(element_name.name)
              
                let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
                let items_id =($('select[name="items['+x+'][items_id]"]').val());
                let item_unit_id =($('select[name="items['+x+'][item_unit_id]"]').val());
                let item_rate =($('input[name="items['+x+'][item_rate]"]').val())
                let item_final_amount =($('input[name="items['+x+'][item_final_amount]"]').val())

                    if (isEmpty(item_group_id)) {
                        empty_count++;
                    }
                    if (isEmpty(items_id)) {
                        empty_count++;
                    }
                    if (isEmpty(item_unit_id)) {
                        empty_count++;
                    }
                     if (isEmpty(item_rate)) {
                        empty_count++;
                    }
                    if (isEmpty(item_final_amount)) {
                        empty_count++;
                    }

            });
            return empty_count;
}
function submitPO(){   
     var EmptyInputs = CheckEmptyInputs();
    console.log("EmptyInputs"+EmptyInputs)
    let po_final_amount=parseFloat($('#po_final_amount').val());
    
     if($("#frm_po").valid() && po_final_amount!=0  && EmptyInputs==0){ 
     
              Swal.fire({
                        title: 'Are you sure ?',
                        // text: msg,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!'
                    }).then((result) => {
                         
                            if(result.value){
                                 $(':disabled').each(function(e) {
                                  $(this).removeAttr('disabled');
                                })
                                // var form = $(this).parents('form');
                                // form.submit();
                                document.forms["frm_po"].submit();
                            }else{
                               //  event.preventDefault();
                                return false;
                            }
                             
                        });
                    
           
    }else{
         msg1="Some Field Required";
          if(! $("#frm_po").valid()){
              msg1="Some Field Required";
          }else if(EmptyInputs > 0){
                 msg1="Empty ITEMS Found. Please fill all the required (*) values."; 
          }     
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: msg1,
                // footer: '<a href>Why do I have this issue?</a>'
            }) 
        //msg=" Customer Total UnPaid Limit "+shipper_customer_unpaid_credit_amount+" is between the "+shipper_customer_credit_min_limit_amount+" and "+shipper_customer_credit_max_limit_amount;
    }     
}

function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}
 $(document).ready(function() {
    po_filter();
    if(!isEmpty($('#id').val())){
        getVendorSiteData();
    }
    
});
function po_filter(){  
    var data = {    
                    'vendor_id':$("#vendor_id").val(),
                    'company_id':$("#company_id").val(),
                    'site_id':$("#site_id").val(),
                    'on_date':$("#on_date").val(),
                    'from_date':$("#from_date").val(),
                    'to_date':$("#to_date").val(),
       };
    listPO(data);
    listtermconditions(data);
  }

  var vendor = '';
  function listPO(data='') {
    
     vendor = $('#tbl_po').DataTable({
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
          url: base_url +'admin/PO/listPo',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { title: "Sr._No.", orderable:false },
          {  title: "PO Order No" },  
          {  title: "Po Date" },
          {  title: "Vendor Name" },
          {  title: "Total Item Qty" },
          {  title: "User Name" },
          {  title: "Status" },         
          {  title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

  }

  
function getVendorSiteData(){
        let vendorId=$('#vendorId').val();
        let billingSiteId=$('#billingSiteId').val();
        let deliverySiteId=$('#deliverySiteId').val();
        let deliveryPartyId=$('#deliveryPartyId').val();


        $.ajax({
              url:base_url +'admin/Vendor/listVendorName',    
              type: "post",              
              dataType: 'json',
              success: function(response) {
                
                  if(response){
                    $(".get_vendor").select2({                       
                          data: response
                    })       
                    $("#delivery_party_id").select2("val", deliveryPartyId);        
                    $("#vendor_id").select2("val", vendorId);           
                  }                
              }
          });

        $.ajax({
             url:base_url +'admin/Common/listSite', 
              type: "post",              
              dataType: 'json',
              success: function(response) {
               
                  if(response){
                    $("#delivery_site_id").select2({                       
                          data: response
                    })        
                    $("#delivery_site_id").select2("val", deliverySiteId);          
                  }                
              }
          });

        $.ajax({
             url:base_url +'admin/Common/listSite',  
              type: "post",              
              dataType: 'json',
               data: {
                  'company_id':company_id,                 
              },
              success: function(response) {
              
                  if(response){
                    $("#billing_site_id").select2({                       
                          data: response
                    })   
                    $("#billing_site_id").select2("val", billingSiteId);               
                  }                
              }
          });



}
 $(".numberonly").keypress(function(e) {
    var kk = e.which;
     if(kk < 48 || kk > 57)
     e.preventDefault();
 });
function getPOListingVendorSiteData(){
       $('.on_date').hide();
       $('#vendor_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Vendor/listVendorName',       
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
$('#site_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listSite',       
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

}
  $("#on_date").change(function () {
        var on_date = $('#on_date').val();
        // alert(on_date);
           if (on_date != 6) {
              po_filter1();
              $('.on_date').hide();
            }else{
              $('.on_date').show();
            }
       });


function submit_update_status() {
    var po_status = $('#chg_status').val();
    var po_id = $('.idpo').val();
    var reject_reason = $('.reject_reason').val();
    $.ajax({
      url: base_url + 'admin/PO/submit_update_status',
      type: 'post',
      dataType: 'json',
      data: {'po_id':po_id,'po_status':po_status,'reject_reason':reject_reason},
      success: function (response) {
        // console.log(response);
         if (response.result) {
            alert_float('success', response.reason);
            setTimeout(function(){
               window.location.reload();
            }, 2900);
         } else {
            alert_float('danger', response.reason);
         }
      }
   });
}

 $('.idemail').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/PO/listEmails',       
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

    $('.vendor_email_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/PO/listVendorEmails',       
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term,
                        vendor_id: $('.id_vendor').val(),
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
    




    var po_status = $('#chg_status').val();
    var po_id = $('.idpo').val();
    var reject_reason = $('.reject_reason').val();
    $.ajax({
      url: base_url + 'admin/PO/submit_update_status',
      type: 'post',
      dataType: 'json',
      data: {'po_id':po_id,'po_status':po_status,'reject_reason':reject_reason},
      success: function (response) {
        // console.log(response);
         if (response.result) {
            alert_float('success', response.reason);
            setTimeout(function(){
               window.location.reload();
            }, 2900);
         } else {
            alert_float('danger', response.reason);
         }
      }
   });

  
  function remove_db_file_attch(po_attachment_id)
    {
        // alert(po_attachment_id);
        $.ajax({
           url: base_url + 'admin/PO/remove_po_attachment',
           type: 'post',
           dataType: 'json',
           data: {
              'po_attachment_id': po_attachment_id,
           },
           success: function (response) {
              if (response.result == true) {
                 // alert_float('success', response.reason);
                $('#remove_file_attch_'+po_attachment_id).remove();
                // $('#remove_file_attch_id_'+po_attachment_id).remove();
                
              } else {
                 // alert_float('danger', response.reason);
              }

           }

        });
    }


function listtermconditions(data='') {
    
    termconditions = $('#tbl_termconditions').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 10,
              order: [[1, "desc"]],
      ajax: {
          url: base_url +'admin/Po/listtermconditions',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
     
       columns: [        
          { "width": "10%",  title: "X", orderable:false },
          { "width": "20%", title: "Sr._No." },
          // { "width": "20%", title: "Email" },
          { "width": "20%", title: "Title" },
          { "width": "20%", title: "Particulars" },  
          // { "width": "20%", title: "Total Amount" },  
          // { "width": "20%", title: "Action" , orderable:false, "className": "text-center"},
        ],
    });
     
  }
 $('.term_master_modal').on('click', function() {
    term_master_modal();
  });

  function term_master_modal(id='',type=1) {

    $.ajax({
          url: base_url +'admin/PO/getTermCondition',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              console.log(res.html)
              $('#tbl_po_terms_condition_html').html();
            if (res.result == true) {
              $('#tbl_po_terms_condition_html').html(res.html);
              $('#termsConditionHtml').modal('show');
              // $("#catdrop").select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
  function saveTermsCondition() {

    let title=$('#title').val();
    let particulars=$('#particulars').val();
    
    if(particulars){
          
          $.ajax({
                      url: base_url +'admin/PO/saveTermConditions',
                      type: 'POST',
                      data: {'title':title,'particulars':particulars},
                      dataType:'json',
                      success: function(res) {
                            if(res.result == true){
                              term_master_modal('',2);
                            }else{
                              alert_float('error',response.reason);
                            }
                        }
                });
    }
   
 
  }
  
  //  $('.termconditionsModal').on('click', function() {
  //   termconditionsModal();
  // });

  // function termconditionsModal(id='') {

  //   $.ajax({
  //         url: base_url +'admin/Po/termconditionsModal',
  //         type: 'POST',
  //         data: {'id':id},
  //         dataType:'json',
  //         success: function(res) {
  //             $('#_banner').html();
  //           if (res.result == true) {
  //             $('#_banner').html(res.html);
  //             $('#termconditionsModal').modal('show');
  //             // $("#catdrop").select2();
  //           }else{
  //             alert_float('error',response.reason);
  //           }
  //         }
  //     })
  // }