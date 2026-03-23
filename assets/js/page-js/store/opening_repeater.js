$(document).ready(function () {
    "use strict";
    $(".repeater").repeater({
        defaultValues: {
            "textarea-input": "foo",
            "text-input": "bar",
            "select-input": "B",
            "checkbox-input": ["A", "B"],
            "radio-input": "B"
        },
        isFirstItemUndeletable: true,
         show: function () {
                var EmptyInputs = CheckEmptyInputs1();
                console.log("EmptyInputs="+EmptyInputs);
                
                if (EmptyInputs > 0) {
                    alert("Empty Inputs Found. Please fill all the required (*) values.");
                }else{

                    // $('#item_group_tables .select2-container').remove();
                    // $("select").removeAttr("data-select2-id");
                    $('.item_group_select2').select2({
                          allowClear: true
                    });


                        // $('.vender_name').select2({
                        //       allowClear: true
                        // });

                            

                    $('.select2-container').css('width','100%');
                           $('.mydatepicker').datepicker({
                            defaultDate: "today",
                            
                    });
                    // $('select[name="items['+row_index+'][item_group_id]"]').removeAttr('disabled').val(null).trigger('change');
                    // $('select[name="items['+row_index+'][items_id]"]').removeAttr('disabled').empty();
                        

                     
                     
                    //$(this).slideDown();
                    var $newItem1 = $(this).clone();
                    console.log($newItem1);
                    $newItem1.find('.select2-container').remove();
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
                    $listContainer.prepend($newItem1);
                    // $newItem1.slideDown();
                    // getItemGroup();
                    //  getVendorName();
                    //  getItemName();
                    $newItem1.slideDown(function() {
                            $newItem1.find('.item_group_select2').select2({
                                ajax: {
                                    url: base_url + 'admin/PO/listItemGroup',
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
                              $newItem1.find('.po_item_cal').on('blur', function(evt) {
                                    var element = evt.target;
                                    calculatePOItem(element);
                                });
                               
                                    
                    });
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
            // $(this).slideUp(e)
            let product_count=0;
                if(confirm('Are you sure you want to delete this element?')) {
                    
                        product_count=CheckTotalItems();
                        if(product_count==1){
                            alert("You Can not delete this item one item should be added");
                        }else{
                            $(this).slideUp(e);
                        }
                        
                        // calculateTotal();
                }               
        },
        ready: function (e) {}
    }), window.outerRepeater = $(".outer-repeater").repeater({
        defaultValues: {
            "text-input": "outer-default"
        },
        show: function () {
            console.log("outer show"), $(this).slideDown()
        },
        hide: function (e) {
            console.log("outer delete"), $(this).slideUp(e)
        },
        repeaters: [{
            selector: ".inner-repeater",
            defaultValues: {
                "inner-text-input": "inner-default"
            },
            show: function () {
                console.log("inner show"), $(this).slideDown()
            },
            hide: function (e) {
                console.log("inner delete"), $(this).slideUp(e)
            }
        }]
    })
});



function getItemGroup(){
console.log("sd");
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


function getVendorName(){

$('.vender_name').select2({
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

}


function getItemName(){

$('.po_items_sel').select2({
    ajax: {
        url:base_url +'admin/Common/list_po_items_sel',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                    // 'item_group_select_id': $('.item_group_select2').val(),
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
function CheckEmptyInputs1() {
            var empty_count = 0;
            $(".po_items_select").each(function () {
                element_name=$(this)[0].name;            
                var match = element_name.match(/\[([^\]]+)\]/);
                var x = match ? match[1] : null;
                var style=$(this).closest('.main_tbl_reapter').css('display');
          
                if(style!="none"){
                    console.log("empty_count_name="+element_name)
                    console.log("style="+style)
                     console.log("x="+x)
                    let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
                    let items_id =($('select[name="items['+x+'][items_id]"]').val());                  
                    let item_rate =($('input[name="items['+x+'][item_unit_rate]"]').val())
                   
                        
                        
                //     if(!isEmpty(grn_item_id) && grn_item_id!=0){
                   
                        if(isEmpty(item_group_id) &&  item_group_id!='all') {
                             console.log("item_group_id="+item_group_id)
                            empty_count++;
                        }
                        if (isEmpty(items_id)) {
                             console.log("items_id="+items_id)
                            empty_count++;
                        }
                       //console.log("item_rate="+item_rate)
                        if (isEmpty(item_rate) || item_rate==0.00 || item_rate==0 || item_rate==0.0 ) {
                             console.log("item_rate="+item_rate)
                            empty_count++;
                        }
                       
                }
                

            });
            return empty_count;
}
$('.repeater').on('data-repeater-create', function() {
    // Get the newly created repeater item
    var $newItem = $(this).find('.repeater-item').first(); // Assuming the newly created item is the first child with class .repeater-item

    // Initialize validation rules for the newly created item
    $newItem.find('input[data-rule-availableQty="true"]').each(function() {
        $(this).rules('add', {
            availableQty: true
        });
    });

    // Trigger validation for the new item
    $newItem.find('input').valid(); // This triggers validation for all inputs in the new item
});
function getDeleteRowDublicate(){
   
     $(".main_tbl_reapter").each(function () {
            if ($(this).css('display') === 'none') {
                    console.log("ds")
                    $(this).remove();
            }
                

            });
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
function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
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
            
            
          }                
      }
    });
  
 
   
}