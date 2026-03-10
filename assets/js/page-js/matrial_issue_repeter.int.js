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


                    $('#item_group_tables .select2-container').remove();
                    $("select").removeAttr("data-select2-id");
                        $('.item_group_select2').select2({
                              allowClear: true
                        });


                        $('.vender_name').select2({
                              allowClear: true
                        });

                            

                    $('.select2-container').css('width','100%');
                           $('.mydatepicker').datepicker({
                            defaultDate: "today",
                            
                        });

                     getItemGroup();
                     getVendorName();
                     getItemName();
                     
            $(this).slideDown();
        },
        hide: function (e) {
            $(this).slideUp(e)
                           
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


