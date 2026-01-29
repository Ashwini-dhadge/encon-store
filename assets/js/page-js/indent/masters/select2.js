$('.a_tip').select2({
  
    width: '100%',
    ajax: {
      url: base_url + 'admin/indent/master/Blade/A_tip/list_aTip',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });


  $('.color').select2({
  
    width: '100%',
    ajax: {
      url: base_url + 'admin/indent/master/Blade/Color/list_color',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });



  $(document).ready(function () {
    $('.hardwares').select2({
      
      width: '100%',
    ajax: {
      url: base_url + 'admin/indent/master/Hub/Hardware/list_Hardware',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });
  });



  $(document).ready(function () {
    $('.heights').select2({
      
      width: '100%',
      ajax: {
      url: base_url + 'admin/indent/master/Fan_Stack/Height/list_Height',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });
  });




  $(document).ready(function () {
    $('.hub_size').select2({
      
      width: '100%',
      ajax: {
      url: base_url + 'admin/indent/master/Hub/Hub_size/list_hubSize',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });
  });



  $(document).ready(function () {
    $('.material').select2({
      
      width: '100%',
    ajax: {
      url: base_url + 'admin/indent/master/Hub/Material/list_Material',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });
  });




  $('.module_size').select2({
  
    width: '100%',
    ajax: {
      url: base_url + 'admin/indent/master/Blade/Mould_size/listMould',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });




  $(document).ready(function () {
    $('.dimension').select2({
      
      width: '100%',
      ajax: {
      url: base_url + 'admin/indent/master/Fan_Stack/Dimension/list_Dimension',
      dataType: 'json',
      type: "get",
      delay: 500,
      data: function(params) {
        return {
          searchTerm: params.term
        };
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  }).on('select2:select', function (e) {
    var selectedValue = e.params.data.id; 
    console.log("Selected ID: " + selectedValue);
  });
  });




  $(document).ready(function () {
    $('.thikness').select2({
      
      width: '100%',
      ajax: {
        url: base_url + 'admin/indent/master/Hub/Thickness/list_Thickness',
        dataType: 'json',
        type: "get",
        delay: 500,
        data: function(params) {
          return {
            searchTerm: params.term
          };
        },
        processResults: function(data) {
          return {
            results: data
          };
        },
        cache: true
      }
    }).on('select2:select', function (e) {
      var selectedValue = e.params.data.id; 
      console.log("Selected ID: " + selectedValue);
    });
    });


    $('.plate_od').select2({
      
        width: '100%',
        ajax: {
          url: base_url + 'admin/indent/master/Hub/Plate_Od/list_PlateOd',
          dataType: 'json',
          type: "get",
          delay: 500,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(data) {
            return {
              results: data
            };
          },
          cache: true
        }
      }).on('select2:select', function (e) {
        var selectedValue = e.params.data.id; 
        console.log("Selected ID: " + selectedValue);
      });

