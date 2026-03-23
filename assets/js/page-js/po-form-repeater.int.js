var poRepeater='';
let previous_row=0;
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
            console.log("EmptyInputs="+EmptyInputs)
            if (EmptyInputs > 0) {
                alert("Empty Inputs Found. Please fill all the required (*) values.");
            }else{
                        // $('#po_items_tables .select2-container').remove();
		                  
                        //             $('#po_items_tables .select2-container').css('display','none');
                        //             $('.select2-container--below').css('display','block');
                        //             $('.select2-container--above').css('display','block');
            
                        // 		    $("select").removeAttr("data-select2-id");
                        //                 $('.item_group_select2').select2({
                        //                   allowClear: true
                        //             });
                        			
                        // 			$('.select2-container').css('width','100%');
                        // 			   $('.mydatepicker').datepicker({
                        // 			    defaultDate: "today",
                        			    
                        // 			});
                        // 		   	getPOItemsGroup();
            
                        var repeaterItem = $(this);
                        var outerHTML = repeaterItem[0].outerHTML;
                        var element=$(outerHTML).find('tr').attr('name');
                        var match = element.match(/\[([^\]]+)\]/);    
                        var row_index = match ? match[1] : null;
                       
                        
                        let item_rate_type= parseInt($('select[name="items['+row_index+'][item_rate_type]"]').val());
                        let discount_type= parseInt($('select[name="items['+row_index+'][discount_type]"]').val());
                        
                        $('select[name="items['+row_index+'][item_rate_type]"]').val(1);
                        $('select[name="items['+row_index+'][discount_type]"]').val(1);
                        $('input[name="items['+row_index+'][item_weight]"]').val(0);
                        $('input[name="items['+row_index+'][delete_type]"]').val(1);
            
                        // Trigger the change event to update the Select2
                        $('select[name="items['+row_index+'][item_rate_type]"]').trigger('change');
                        $('select[name="items['+row_index+'][discount_type]"]').trigger('change');
                        
                        
                        var $newItem1 = $(this).clone();
                        
                        
                        $newItem1.find('.item_group_select2').removeAttr('disabled').val(null).trigger('change');
                        $newItem1.find('.po_items_select').removeAttr('disabled').empty();
                        $newItem1.find('select.select2').each(function() {
                            if ($(this).hasClass('select2-hidden-accessible')) {
                                    $(this).removeAttr("data-select2-id").removeClass('select2-hidden-accessible').next('.select2-container').remove();
                                    $(this).prev('.select2').remove();
                                    $(this).siblings('span').remove();
                                    $(this).find('option[data-select2-id]').remove(); // Remove orphaned option elements
                                    
                                }
                        });
                        var $listContainer = $(this).closest('.repeater').find('[data-repeater-list]');
                            $newItem1.slideDown(function() {
                 
                            $newItem1.find('.vender_name').select2({
                                   ajax: {
                                            url:base_url +'admin/Common/listvender_name',       
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
                    });
                        
                      
                        //Prepend the new item to the list container
                        $listContainer.prepend($newItem1);
                        setPreviousItem($newItem1)
                     
                        getDeleteRowDublicate();
                        
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
		  product_count=CheckTotalItems();
		        if(product_count==1){
                            alert("You Can not delete this item one item should be added");
                }else{
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
function CheckTotalItems() {
            var empty_count = 0;
            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;
                var style=$(this).closest('.main_tbl_reapter').attr("style");
                // console.log("empty_count_name="+element_name)
                //   console.log("style="+style)
                //     console.log("x="+x)
                
                if(style!="display: none;"){
                    empty_count++;
                }
                

            });
            return empty_count;
}
function CheckEmptyInputs1() {
            var empty_count = 0;
            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
	            var match = element_name.match(/\[([^\]]+)\]/);
	            var x = match ? match[1] : null;
                
	            var style=$(this).closest('.main_tbl_reapter').css('display');
          
                if(style!="none"){
	             
	                let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
    	            let items_id =($('select[name="items['+x+'][items_id]"]').val());
    	            let item_unit_id =($('select[name="items['+x+'][item_unit_id]"]').val());
    	            let item_rate =($('input[name="items['+x+'][item_rate]"]').val())
    	            let item_final_amount =($('input[name="items['+x+'][item_final_amount]"]').val())
                    
                 
                    if (isEmpty(item_group_id) && item_group_id!='all' ) {
                        
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
function getDeleteRowDublicate(){
   
     $(".main_tbl_reapter").each(function () {
            if ($(this).css('display') === 'none') {
                    console.log("ds")
                    $(this).remove();
            }
                

            });
}
function setPreviousItem(item){
    var element_name = item.find('.item_group_select2').attr("name");
    var match = element_name.match(/\[([^\]]+)\]/);
	var current_row = match ? match[1] : null;
    $.ajax({
      url: base_url + 'admin/PO/listItemGroup',      
      type: "post",              
      dataType: 'json',
      success: function(response) {
        
          if(response){
            $('select[name="items['+current_row+'][item_group_id]"]').select2({                       
                  data: response
            })       
            let prev_item_group_id =($('select[name="items[0][item_group_id]"]').val());
            $('select[name="items['+current_row+'][item_group_id]"]').val(prev_item_group_id); // Select the option with a value of '1'
            $('select[name="items['+current_row+'][item_group_id]"]').trigger('change'); 
             let prev_items_id =($('select[name="items[0][items_id]"]').val());
            getItemList('',1,current_row,prev_items_id);
            
          }                
      }
    });
  
  
//     $.ajax({
//         url:base_url +'admin/Common/list_item_name',    
//         type: "GET",              
//         dataType: 'json',
//         data:{
//                 'item_group_name_id':$('select[name="items[0][item_group_id]"]').val(),
//             },
     
//       success: function(response) {
        
//           if(response){
//             $('select[name="items['+current_row+'][items_id]"]').select2({                       
//                   data: response
//             })       
//            
//             $('select[name="items['+current_row+'][items_id]"]').val(prev_items_id); // Select the option with a value of '1'
//             $('select[name="items['+current_row+'][items_id]"]').trigger('change'); 
            
            
//           }                
//       }
//   });
    
    
   
}