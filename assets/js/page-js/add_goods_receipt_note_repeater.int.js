$(document).ready(function () {
    "use strict";
    getPOItemsGroup();

    $(".repeater").repeater({
        defaultValues: {
            "textarea-input": "foo",
            "text-input": "bar",
            "select-input": "B",
            "checkbox-input": ["A", "B"],
            "radio-input": "B"
        },
       
         show: function () {

            var EmptyInputs = CheckEmptyInputs1();
            // console.log("EmptyInputs="+EmptyInputs);
            
            if (EmptyInputs > 0) {
                alert("Empty Inputs Found. Please fill all the required (*) values.");
            }else{
                        // $('#add_goods_receipt_note .select2-container').remove();
                        
                        // $('#grn_items_tables .select2-container').css('display','none');
                        // $('.select2-container--below').css('display','block');
                        // $('.select2-container--above').css('display','block');
                        
                        //$("select").removeAttr("data-select2-id");
                        // $('.item_group_select2').select2({
                        //       allowClear: true
                        // });
                        
                        $('.select2-container').css('width','100%');
                       
                    
                        var date = new Date();
                        date.setDate(date.getDate());
                        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                       
                        $('.mydatepicker').datepicker({
                            defaultDate:today,
                            
                        });    
                        jQuery('.myPreviousDatepicker').datepicker({ 
                                startDate: date,
                                defaultDate: today
                        });
            
                        var repeaterItem = $(this);
                       //   console.log(repeaterItem);
                       
                       //   $(this).slideDown();
                        // var $newItem = $(this).clone();

                        // Find the list container of the repeater
                        // var $listContainer = $(this).closest('.repeater').find('[data-repeater-list]');
                
                        // Prepend the new item to the list container
                        // $listContainer.prepend($newItem);
                        
                        
                        var outerHTML = repeaterItem[0].outerHTML;
                        //console.log(repeaterItem[0].innerHTML);
                        var element=$(outerHTML).find('tr').attr('name');
                        var match = element.match(/\[([^\]]+)\]/);    
                        var row_index = match ? match[1] : null;
                        
                       
                       
                          //   $(this).slideDown();
                        getPOItemsGroup(1,row_index);
                        // getItemList1(row_index);
                        var $newItem1 = $(this).clone();
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
                        // Slide down the new row
                        // Optionally, initialize Select2 on the new Select elements if needed
                        // $newItem1.find('.item_group_select2').select2({
                        //     allowClear: true
                        // });
                     //   Find the list container of the repeater
                        var $listContainer = $(this).closest('.repeater').find('[data-repeater-list]');
                        
                        console.log("as$newItem1"+$newItem1)
                        //Prepend the new item to the list container
                        $listContainer.prepend($newItem1);
                        
                        
                        // Clear Select2 dropdowns only for the new row
                       // Clear Select2 dropdowns only for the new row
                        $('button[name="items['+row_index+'][btn-delete]"]').removeAttr('data-grn_item_id');
                        $('button[name="items['+row_index+'][btn-delete]"]').removeAttr('data-po_id');
                        $('button[name="items['+row_index+'][btn-delete]"]').removeAttr('data-po_item_id');
                        $('select[name="items['+row_index+'][item_group_id]"]').removeAttr('disabled').val(null).trigger('change');
                        $('select[name="items['+row_index+'][items_id]"]').removeAttr('disabled').empty();
                        
                        // $('.item_unit_select').removeAttr('disabled').empty();
                        $('thead[name="items['+row_index+'][tbl_po_item_thead]"]').siblings('.item_unit_select').removeAttr('disabled').empty();
                        $('thead[name="items['+row_index+'][tbl_po_item_thead]"]').siblings('.refesh_block').removeAttr('style').empty();
                          $('div[name="items['+row_index+'][refesh_block]"]').removeAttr('style');
                        let item_rate_type= parseInt($('select[name="items['+row_index+'][item_rate_type]"]').val());
                        let discount_type= parseInt($('select[name="items['+row_index+'][discount_type]"]').val());
                        
                        
                         $('input[name="items['+row_index+'][batch_no]"]').val("");
                          $('input[name="items['+row_index+'][expired_date]"]').val("");
                        $('select[name="items['+row_index+'][item_rate_type]"]').val(1);
                        $('select[name="items['+row_index+'][discount_type]"]').val(1);
            
                        // Trigger the change event to update the Select2
                        $('select[name="items['+row_index+'][item_rate_type]"] option:selected').remove();
                       // $('select[name="items['+row_index+'][discount_type]"] option:selected').remove();
                    
                        $('select[name="items['+row_index+'][item_rate_type]"]').trigger('change');
                        //$('select[name="items['+row_index+'][discount_type]"]').trigger('change');
                        
                        // Remove the selected item from the dropdown menu
                        // $('select[name="items['+row_index+'][item_unit_type]"] option:selected').remove();
                        $('select[name="items['+row_index+'][item_unit_type]"]').val(null).trigger('change');
                        $('select[name="items['+row_index+'][item_unit_type]"]').val(1);
                        $('select[name="items['+row_index+'][item_unit_type]"]').trigger('change');
                        
                        $('select[name="items['+row_index+'][other_charges_type]"]').val(null).trigger('change');
                        $('select[name="items['+row_index+'][other_charges_type]"]').val(1);
                        $('select[name="items['+row_index+'][other_charges_type]"]').trigger('change');
                        
                         $('select[name="items['+row_index+'][gst_type]"]').val(null).trigger('change');
                        $('select[name="items['+row_index+'][gst_type]"]').val(1);
                        $('select[name="items['+row_index+'][gst_type]"]').trigger('change');
                      
                         $('select[name="items['+row_index+'][tax_id]"]').val(null).trigger('change');
                        
                        // Optionally, slide down the new item
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
                             var divSelector = '[name="items['+row_index+'][po_item_update_div]"]';  
                                    $newItem1.find(divSelector).empty();
                    });
                    setPreviousItem($newItem1);
                    
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
                     
       let product_count=0;
                if(confirm('Are you sure you want to delete this element?')) {
                    
                        product_count=CheckTotalItems();
                        if(product_count==1){
                            alert("You Can not delete this item one item should be added");
                        }else{
                            $(this).slideUp(e);
                        }
                        
                        calculateTotal();
                }
                           
        },
        ready: function (e) {
            console.log("SD")
        }
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

function getPOItemsGroup(type=0,row_index=''){
   console.log("type="+type)
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
    if(type==1){
        var defaultValue = '';
        var defaultOption = new Option('', defaultValue, true, true);
        if(! isEmpty(row_index) || row_index==0){
            $('select[name="items['+row_index+'][item_group_id]"]').append(defaultOption).trigger('change');
        }
    }
    // // Add default value
    //     var defaultValue = '';
    //     var defaultOption = new Option('', defaultValue, true, true);
    //     $('.item_group_select2').append(defaultOption).trigger('change');

    
}

function CheckEmptyInputs1() {
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
                    let item_group_id =($('select[name="items['+x+'][item_group_id]"]').val());
                    let items_id =($('select[name="items['+x+'][items_id]"]').val());                  
                    let item_rate =($('input[name="items['+x+'][item_unit_rate]"]').val())
                    let received_qty =($('input[name="items['+x+'][received_qty]"]').val())
                    let item_final_amount =($('input[name="items['+x+'][item_final_amount]"]').val())
                    
                    let grn_item_id=$('input[name="items['+x+'][grn_item_id]"]').val();
                   // console.log("grn_item_id="+grn_item_id)
                    if(!isEmpty(grn_item_id) && grn_item_id!=0){
                       
                    }else{
                         if (isEmpty(item_group_id) && item_group_id!='all') {
                            empty_count++;
                        }
                        if (isEmpty(items_id)) {
                            empty_count++;
                        }
                    }
                

                   
                   
                    if(isEmpty(item_rate) || (item_rate==0)|| (item_rate==0.00))  {
                        empty_count++;
                    }
                    
                    if (isEmpty(item_final_amount)) {
                        empty_count++;
                    }
                    if (isEmpty(received_qty)) {
                        empty_count++;
                    }
                }
                

            });
            return empty_count;
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
function getDeleteRowDublicate(){
   
     $(".main_tbl_reapter").each(function () {
            if ($(this).css('display') === 'none') {
                    console.log("ds")
                    $(this).remove();
            }
                

            });
}

     
$('.po_adjustment_qty').on('blur', function() {
            element_name=$(this)[0].name;            
            var match = element_name.match(/\[([^\]]+)\]/);
            var x = match ? match[1] : null;
            let po_adjustment_qty =($('input[name="items['+x+'][po_adjustment_qty]"]').val());
            let po_id=$("#po_id").val();
            var po_old_received_qty = $('input[name="items['+x+'][old_received_qty]"]').val();
             
            if(($('#type').val()==2 || $('#type').val()==3 ) && po_adjustment_qty!=0){
                let po_received_qty =parseInt($('input[name="items['+x+'][po_received_qty]"]').val());
                let po_save_pending_qty =parseInt($('input[name="items['+x+'][po_save_pending_qty]"]').val());
               
                var po_adjustment_qty_new=po_save_pending_qty-po_received_qty;
                // console.log("po_adjustment_qty_new"+po_adjustment_qty_new);
                //  console.log("po_adjustment_qty_old"+po_adjustment_qty);
                if(po_adjustment_qty_new==po_adjustment_qty){
                     $('#form_grn').valid = function() {
                        return true;
                      };
                }else{
                      alert("Adjustment Qty Should be 0 or "+po_adjustment_qty_new);
                      $('input[name="items['+x+'][po_received_qty]"]').val(po_adjustment_qty_new)
                }
                 $(this).valid();
                
            }else if(($('#type').val()==1) && !isEmpty(po_id) && !isEmpty(po_old_received_qty) && po_adjustment_qty!=0){
                var po_received_qty = $('input[name="items['+x+'][po_received_qty]"]').val();
                var po_main_received_qty = $('input[name="items['+x+'][po_main_received_qty]"]').val();
                var po_total_pending_qty = $('input[name="items['+x+'][po_main_pending_qty]"]').val();
                var po_main_total_qty = $('input[name="items['+x+'][po_main_total_qty]"]').val();
            

                if(parseInt(po_old_received_qty) > parseInt(po_received_qty)){
                 total_qty=po_old_received_qty-po_received_qty;
                 po_new_recevied_qty=parseInt(po_main_received_qty)-parseInt(total_qty);
                }else if(parseInt(po_old_received_qty) < parseInt(po_received_qty)){
                     total_qty=po_received_qty-po_old_received_qty;
                     po_new_recevied_qty=parseInt(po_main_received_qty)+parseInt(total_qty);
                    
                }else{
                     po_new_recevied_qty=po_old_received_qty;
                }
               
                  var po_adjustment_qty_new=po_main_total_qty-po_new_recevied_qty;
                
                if(po_adjustment_qty_new==po_adjustment_qty){
                     $('#form_grn').valid = function() {
                        return true;
                      };
                }else{
                      alert("Adjustment Qty Should be 0 or "+po_adjustment_qty_new);
                    //   if(po_adjustment_qty_new >= 1){
                    //       $('input[name="items['+x+'][po_adjustment_qty]"]').val(po_adjustment_qty_new)
                    //   }else{
                    //       $('input[name="items['+x+'][po_adjustment_qty]"]').val(0)
                    //   }
                     $('input[name="items['+x+'][po_adjustment_qty]"]').val(0)
                      
                }
                 $(this).valid();
                
            }else{
                let grn_item_id=$('input[name="items['+x+'][grn_item_id]"]').val();
                // console.log("grn_item_id="+grn_item_id)
                if(!isEmpty(grn_item_id) && grn_item_id!=0 || $('#type').val()==2 || $('#type').val()==3 ){
                   
                }else{
                    $('input[name="items['+x+'][item_unit_rate]"]').val(0);
                }
               
            }
        $(this).valid();
      });
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