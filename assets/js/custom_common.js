// chetan code 10 05 2024

$(document).ready(function () {
    getBCityData();
    getSCityData();
    getCustCityData();
});

function getBCityData() {
    //alert();
    var country_id = $(".b_country_name").val();
    var state_id = $(".b_state_name").val();

    $(".b_city_name").select2({
        minimumInputLength: 3,
        // placeholder: 'Select an city',
        ajax: {
            url: base_url + "admin/Common/listCityName",
            dataType: "json",
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                    state_id: state_id,
                    country_id: country_id, // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });
}
function getCustCityData() {
    //alert();
    var country_id = $(".cust_country_name").val();
    var state_id = $(".cust_state_name").val();

    $(".cust_city_name").select2({
        minimumInputLength: 3,
        // placeholder: 'Select an city',
        ajax: {
            url: base_url + "admin/Common/listCityName",
            dataType: "json",
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                    state_id: state_id,
                    country_id: country_id, // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });
}
$(".b_city_name").on("change", function (e) {
    var city_id = $(".b_city_name").val();
    //alert(city_id);

    $.ajax({
        url: base_url + "admin/Common/getCoutryState",
        type: "post",
        dataType: "json",
        data: { city_id: city_id },
        success: function (response) {
            $(".b_country_name").empty();
            $(".b_state_name").empty();

            $(".b_country_name").select2({
                data: response.country,
            });
            $(".b_state_name").select2({
                data: response.state,
            });
        },
    });
});

function getSCityData() {
    //alert();
    var country_id = $(".s_country_name").val();
    var state_id = $(".s_state_name").val();

    $(".s_city_name").select2({
        minimumInputLength: 3,
        // placeholder: 'Select an city',
        ajax: {
            url: base_url + "admin/Common/listCityName",
            dataType: "json",
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term,
                    state_id: state_id,
                    country_id: country_id, // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });
}

$("#s_city").on("change", function (e) {
    var city_id = $("#s_city").val();
    //alert("city Id" + city_id);

    $.ajax({
        url: base_url + "admin/Common/getCoutryState",
        type: "post",
        dataType: "json",
        data: { city_id: city_id },
        success: function (response) {
            $(".s_country_name").empty();
            $(".s_state_name").empty();

            $(".s_country_name").select2({
                data: response.country,
            });
            $(".s_state_name").select2({
                data: response.state,
            });
        },
    });
});

$(".s_city_name").on("change", function (e) {
    var city_id = $(".s_city_name").val();
    //alert(city_id);

    $.ajax({
        url: base_url + "admin/Common/getCoutryState",
        type: "post",
        dataType: "json",
        data: { city_id: city_id },
        success: function (response) {
            $(".s_country_name").empty();
            $(".s_state_name").empty();

            $(".s_country_name").select2({
                data: response.country,
            });
            $(".s_state_name").select2({
                data: response.state,
            });
        },
    });
});

$('.right-side-toggle').click(function(){
  getCompanySiteData();
});
// select/unselect check_box_function  //
$(function() {
          $(".size").click(function(){
              checkwhat  = $(this).data("checkwhat");
              $('input:checkbox.'+checkwhat).not(this).prop('checked', this.checked);
          });
        });


function getChangeCompanyYear(){
  
    $('#common_frm_setting').validate();    
      if($('#common_frm_setting').valid()){
          $.ajax({
              url: base_url + 'admin/Common/changeCompanySiteSetting',
              type: "post",
              data: {
                  'common_company_site_data': $('#common_company_site_data').val(),
                  'common_financial_year':$('#common_financial_year').val()
              },
              dataType: 'json',
              success: function(response) {
                  if(response.result){
                    location.reload(true);
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });
      }
}


function getCompanySiteData(){
        $.ajax({
              url: base_url + 'admin/Common/getIntialCompanySiteData',
              type: "post",
              
              dataType: 'json',
              success: function(response) {
                console.log(response.data)
                  if(response.result){
                    $("#common_company_site_data").select2({
                          dropdownParent: $("#r-panel-body"),
                          data: response.data
                        })
                    $("#common_financial_year").select2({
                         dropdownParent: $("#r-panel-body"),
                          data: response.data1
                        })
                    
                  }else{
                    alert_float('danger', response.reasons);
                  }
                
                
              }
          });

    
}

function getSiteData(){
   var company_id=$('#company_id').val();
    $('#site_id').select2({
            // placeholder: 'Select an state',
            ajax: {
                url:base_url +'admin/Common/listSite',       
                dataType: 'json',
                delay: 250,
                data: function (data) {
           
                    return {
                        searchTerm: data.term,
                         company_id: company_id,// search term
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

$('.item_group_name').select2({
    ajax: {
        url:base_url +'admin/Common/listitem_group_name',       
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

// $('.po_items_sel').select2({
//     ajax: {
//         url:base_url +'admin/Common/list_po_items_sel',       
//             dataType: 'json',
//             delay: 250,
//             data: function (data) {
//                 return {
//                     searchTerm: data.term,
//                     // 'item_group_select_id': $('.item_group_select2').val(),
//                 };
//             },
//             processResults: function (response) {
//                 return {
//                     results:response
//                 };
//             },
//             cache: true
//         }
//     });


$('.user_name').select2({
    ajax: {
        url:base_url +'admin/Common/listuser_name',       
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

$('.department_name').select2({
    ajax: {
        url:base_url +'admin/Common/listdepartment_name',       
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



$('.issue_to_location_site_id').select2({

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




$(".mobile").attr("maxlength", "10");
     $(".mobile").keypress(function(e) {
        var kk = e.which;
         if(kk < 48 || kk > 57)
         e.preventDefault();
     });

     

 $('.my-field').bind('keypress', testInput);
    function testInput(event) {
     var value = String.fromCharCode(event.which);
     var pattern = new RegExp(/[a-zåäö ]/i);
     return pattern.test(value);
  }
  
 $(".numberonly").keypress(function(e) {
                var kk = e.which;
                 if(kk < 48 || kk > 57)
                 e.preventDefault();
             });
             
              $(".allow_decimal").on("input", function(evt) {
               var self = $(this);
               self.val(self.val().replace(/[^0-9\.]/g, ''));
               if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
               {
                 evt.preventDefault();
               }
            });
$('.company_id_a').select2({
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



  $('.site_id_a').select2({
        ajax: {
            url:base_url +'admin/Common/listSite',       
            dataType: 'json',
            delay: 250,
            data: function (data) {
       
                return {
                    searchTerm: data.term,
                     company_id: $('.company_id_a').val(),// search term
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
      $('.country_name').select2({
        ajax: {
            url:base_url +'admin/Common/country_name_list',       
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
     $('.customer_name').select2({
            ajax: {
                url:base_url +'admin/Common/listCustomerName',       
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
        
        $('.plant_name').select2({
            ajax: {
                url:base_url +'admin/Common/plant_name_list',       
                  dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term,
                        'customer_id' :$('.customer_name').val(),
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


    $('.customer_name').on('change', function () {
        $('.plant_name').empty();
        $('.plant_name').prop("disabled", false); 
        $('.plant_name').prop('required',true);


    });  