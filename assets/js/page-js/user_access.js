var role_id=0;
function filter_user(){
    var data = {        
        'role_id' : $('#role_id').val()        
       };

    listUserAccess(data);
  }

  
  
  
   var users = '';
  function listUserAccess(data='') {
    
     users = $('#user_access').DataTable({
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
          url: base_url +'admin/UserAccess/listUserAccess',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          { "width": "5%",  title: "Sr._No.", orderable:false },
          { "width": "15%", title: "User Name" },  
          { "width": "15%", title: "Mobile Number" },
          { "width": "15%", title: "Email" },  
          { "width": "20%", title: "Company Name" },  
          { "width": "10%", title: "Role Name" },  
          { "width": "15%", title: "Action" , orderable:false, "className": "text-center"},
      ],
     
    });

 
    
    
  }

  
  $(document).ready(function() {

   filter_user();
     user_id=$('#id').val();
   if(user_id){
      getUserAccessData(user_id);
      getParentData($('#parent_staff_role').val());       
   }

});


$( "#parent_staff_role" ).change(function() {
      if(! $('#id').val()){     
            getParentData(this.value);         
      }
});


// $('#parent_staff_role').on('change', function () {
//       if(! $('#id').val()){
     
//             getParentData(this.value);
         
//       }
//    }).change();

$('#parent_staffid').on('change', function () {
     // if(! $('#id').val()){
          getRoleAccessUserData($('#parent_staff_role').val(),this.value)
        
   //   }
      
   }).change();



 function getRoleAccessUserData(role_id,parent_user_id) {
               // alert(role_id);
          if(role_id && role_id !=1){
               $.ajax({
                    url: base_url+'admin/UserAccess/getDataRoleUserAccess',
                    type: "post",
                    data: {
                      'role_id': role_id,
                      'parent_user_id':parent_user_id
                    },
                    dataType:'json',
                    success: function (response) {
                      if(response.result == true){
                        if(response.data_roles_access.length){
                                for (var i = 0; i < response.data_roles_access.length; i++) {
                                           module_id=response.data_roles_access[i].module_id
                                           
                                            if( parseInt(response.data_roles_access[i].view_own)==1){
                                                  $('#view_own_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#view_own_'+module_id).prop('checked', false);;
                                                  $('#view_own_'+module_id).attr("disabled", "disabled");
                                            }


                                            if( parseInt(response.data_roles_access[i].view_global)==1){
                                                   $('#view_global_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#view_global_'+module_id).prop('checked', false);;
                                                  $('#view_global_'+module_id).attr("disabled", "disabled");
                                            }


                                            if( parseInt(response.data_roles_access[i].create)==1){
                                                   $('#create_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#create_'+module_id).prop('checked', false);;
                                                  $('#create_'+module_id).attr("disabled", "disabled");
                                            }


                                            if( parseInt(response.data_roles_access[i].edit)==1){
                                                   $('#edit_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#edit_'+module_id).prop('checked', false);;
                                                  $('#edit_'+module_id).attr("disabled", "disabled");
                                            }


                                            if( parseInt(response.data_roles_access[i].delete)==1){
                                                   $('#delete_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#delete_'+module_id).prop('checked', false);;
                                                  $('#delete_'+module_id).attr("disabled", "disabled");
                                            }
                            }
                        }
                      
                      }else{
                        alert_float('danger',response.reason);
                      }
                   } 
                });
          }else{
            if(role_id==1){
               $('.all_check').prop('checked', true);;
            }else{
               $('.all_check').prop('checked', false);;
            }

          }
               
}


function getParentData(role_id) {
               // alert(role_id);
          if(role_id ){
               $.ajax({
                    url: base_url+'admin/UserAccess/getDataParent',
                    type: "post",
                    data: {
                      'role_id': role_id,
                      'user_id':$('#id').val()
                    },
                    dataType:'json',
                    success: function (response) {
                      $('#parent_staffid').empty();  
                      $('#parent_staffid').select2({
                           data: response. parent_name
                        })
                   } 
                });
          }else{
            
             $('#parent_staffid').val(null).trigger("change");
          }
               
}

function getUserAccessData(user_id) {
               // alert(role_id);
          if(user_id){
               $.ajax({
                    url: base_url+'admin/UserAccess/getDataAllUserData',
                    type: "post",
                    data: {
                      'user_id': user_id,
                      'role_id':$('#role_id').val()                     
                    },
                    dataType:'json',
                    success: function (response) {
                                  

                        if(response.data_user_access.length){
                                for (var i = 0; i < response.data_user_access.length; i++) {
                                           module_id=response.data_user_access[i].module_id;
                                          $('#user_module_id_'+module_id).val(response.data_user_access[i].id);


                                        
                                                  if(parseInt(response.data_user_access[i].view_own)==1){
                                                        $('#view_own_'+module_id).prop('checked', 'checked');
                                                  }else{
                                                        $('#view_own_'+module_id).prop('checked', false);;
                                                  }
                                                
                                                if( parseInt(response.data_user_access[i].view)==1){
                                                       $('#view_global_'+module_id).prop('checked', 'checked');
                                                }else{
                                                      $('#view_global_'+module_id).prop('checked', false);;
                                                }
                                            
                                                if( parseInt(response.data_user_access[i].create)==1){
                                                       $('#create_'+module_id).prop('checked', 'checked');
                                                }else{
                                                      $('#create_'+module_id).prop('checked', false);;
                                                }
                                             

                                             
                                                if( parseInt(response.data_user_access[i].edit)==1){
                                                       $('#edit_'+module_id).prop('checked', 'checked');
                                                }else{
                                                      $('#edit_'+module_id).prop('checked', false);;
                                                }
                                             

                                              
                                                if( parseInt(response.data_user_access[i].delete)==1){
                                                       $('#delete_'+module_id).prop('checked', 'checked');
                                                }else{
                                                      $('#delete_'+module_id).prop('checked', false);;
                                                }

                                                if(parseInt(response.data_user_access[i].view)==1 &&
                                                parseInt(response.data_user_access[i].create)==1 &&
                                                parseInt(response.data_user_access[i].edit)==1 &&
                                                parseInt(response.data_user_access[i].delete)==1)
                                                {
                                                   $('.selectAll_'+module_id).prop('checked', 'checked');
                                                }else if(! parseInt(response.data_user_access[i].view)==1 &&
                                                    ! parseInt(response.data_user_access[i].create)==1 &&
                                                    ! parseInt(response.data_user_access[i].edit)==1 &&
                                                    ! parseInt(response.data_user_access[i].delete)==1){
                                                    
                                                    $('.selectAll_'+module_id).prop('disabled','disabled');
                                                }
                                         
                            }
                        }

                   } 
                });
          }else{
            
             $('#parent_staffid').val(null).trigger("change");
          }
               
}