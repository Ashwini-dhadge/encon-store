var poRepeater='';
$(document).ready(function () {
		
	poRepeater=$(".repeater").repeater({
		defaultValues: {
			"textarea-input": "foo",
			"text-input": "bar",
			"select-input": "B",
			"checkbox-input": ["A", "B"],
			"radio-input": "B"
		},		
		  isFirstItemUndeletable: false,
		 show: function () {
		 
		 	var EmptyInputs = CheckEmptyInputs1();
            // console.log("EmptyInputs="+EmptyInputs)
            if (EmptyInputs > 0) {
                alert("Empty Inputs Found. Please fill all the required (*) values.");
            }else{
                        $('#po_items_tables .select2-container').remove();
		   
            		    $("select").removeAttr("data-select2-id");
                            $('.item_group_select2').select2({
                              allowClear: true
                        });
            			
            			$('.select2-container').css('width','100%');
            			   $('.mydatepicker').datepicker({
            			    defaultDate: "today",
            			    
            			});
            		   	getPOItemsGroup();
            
                        var repeaterItem = $(this);
                        var outerHTML = repeaterItem[0].outerHTML;
                        var element=$(outerHTML).find('tr').attr('name');
                        var match = element.match(/\[([^\]]+)\]/);    
                        var row_index = match ? match[1] : null;
                        
                        let item_rate_type= parseInt($('select[name="items['+row_index+'][item_rate_type]"]').val());
                        let discount_type= parseInt($('select[name="items['+row_index+'][discount_type]"]').val());
                        
                        $('select[name="items['+row_index+'][item_rate_type]"]').val(1);
                        $('select[name="items['+row_index+'][discount_type]"]').val(1);
            
                    // Trigger the change event to update the Select2
                        $('select[name="items['+row_index+'][item_rate_type]"]').trigger('change');
                        $('select[name="items['+row_index+'][discount_type]"]').trigger('change');
                        $(this).slideDown();
                        
                        
                        $('.po_item_cal').on('blur', function(evt) {
                            var element = evt.target;
                            calculatePOItem(element);
                        });
                        $('.po_item_cal_final').on('blur', function(evt) {
                            calculateTotal()
                        });

             }
		},
		hide: function (e) {
		  //  $(this).slideUp(e)
		    var repeaterItem = $(this);
		     console.log(repeaterItem[0])
            var outerHTML = repeaterItem[0].outerHTML;
            var element=$(outerHTML).find('tr').attr('name');
            console.log(element)
            var match = element.match(/\[([^\]]+)\]/);    
            var row_index = match ? match[1] : null;
                        
            let po_id= parseInt($('#id').val());
            let po_item_id= parseInt($('input[name="items['+row_index+'][po_item_id]"]').val());
            let delete_type= parseInt($('input[name="items['+row_index+'][delete_type]"]').val());
            console.log("delete_type="+delete_type)
            if(delete_type==1){
                calculateTotal();
                 $(this).slideUp(e);
            }else{
                 Swal.fire({
                title: "Are you sure to Delete this Item?",
                text: "You will not able to revert this. ",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, revert it!",
                // reverseButtons: true,
                }).then(function(result) {
                if (result.value) {
                      
                         $.ajax({
                                            url: base_url + 'admin/PO/poDeleteItems',
                                            type: 'post',
                                            dataType: 'json',
                                            data: {
                                                'final_amount_total': $('#final_amount_total').val(),
                                                'po_id':po_id,
                                                'po_item_id':po_item_id                                    
                                            },
                                            success: function(response) {
                                                if (response.result) {
                                                  $(this).slideUp(e);
                                                  
                                                   repeaterItem.slideUp(400, function () {
                                                        calculateTotal();
                                                        getUpdateItemAginstData(po_id);
                                                       
                                                      
                                                     });
                                          
                                                    //   $(this).slideUp(e);
                                                    //  calculateTotal()
                                                     alert_float('success', response.reasons);
                                                      
                                                } else {
                                                    alert_float('danger', response.reasons);
                                                }
                                            }
            
                                        });
                    
                   
                } else if (result.dismiss === "cancel") {
            
                }
            }); 
            }
		         		       
		},
		ready: function (e) {
			
		}
	})
});

// $(document).on('click', '[data-repeater-create]', function (e) {
//     var EmptyInputs = CheckEmptyInputs();
//     console.log(EmptyInputs)
//         if (EmptyInputs > 0) {
//             alert("Empty Inputs Found. Please fill all the required (*) values.");
//         }
// 		e.stopPropagation();
//         return false;
// });

function getPOItemsGroup(){
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

    
}
function getUpdateItemAginstData(po_id){

            $.ajax({
                    url: base_url + 'admin/PO/poItemsTOtalItemdetailsUpdate',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'po_id':po_id,
                        'total_qty':$('#total_qty').val(),
                        'total_item_rate':$('#total_item_rate').val(),
                        'total_discount_amount':$('#total_discount_amount').val(),
                        'final_amount_total':$('#final_amount_total').val(),
                        'total_tax_rate':$('#total_tax_rate').val(),
                        'total_additional_tax_rate':$('#total_additional_tax_rate').val(),
                        'po_final_amount':$('#po_final_amount').val(),
                        'round_off':$('#round_off').val(),
                    },
                    success: function(response) {
                    }

                });
}
// $('.item_group_select2').select2().on('select2:select', function (e) {
//     var selectedData = e.params.data;
//     console.log('Selected Data:', selectedData);
// });
function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}
function deleteElement(){
    console.log("Dd")
}

function CheckEmptyInputs1() {
            var empty_count = 0;
            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
	            var match = element_name.match(/\[([^\]]+)\]/);
	            var x = match ? match[1] : null;
                var style=$(this).closest('.repeater-item').attr("style");
	            console.log("empty_count_name="+element_name)
	            
	            if(style!="display: none;"){
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
	            }
	            

            });
            return empty_count;
        }
