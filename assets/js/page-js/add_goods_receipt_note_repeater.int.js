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
            console.log("EmptyInputs="+EmptyInputs)
            if (EmptyInputs > 0) {
                alert("Empty Inputs Found. Please fill all the required (*) values.");
            }else{
                        $('#add_goods_receipt_note .select2-container').remove();
           
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
                     
       
                if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(e);
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
                    let item_rate =($('input[name="items['+x+'][item_unit_rate]"]').val())
                    let received_qty =($('input[name="items['+x+'][received_qty]"]').val())
                    let item_final_amount =($('input[name="items['+x+'][item_final_amount]"]').val())

                    if (isEmpty(item_group_id)) {
                        empty_count++;
                    }
                    if (isEmpty(items_id)) {
                        empty_count++;
                    }
                   
                     if (isEmpty(item_rate)) {
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
function getDeleteRow(){
    console.log("df")
}