


$(document).ready(function(){
  role_id=$('#role_id').val();
 
  
    $( ".all_role_ids_tab" ).each(function() {
              getRoleAccessData($(this).data("role_id"))  
    });

  });

function getRoleAccessData(role_id) {
               // alert(role_id);
                $.ajax({
                    url: base_url+'admin/RoleAccess/getDataRole',
                    type: "post",
                    data: {
                      'role_id': role_id,
                    },
                    dataType:'json',
                    success: function (response) {
                      if(response.result == true){
                        if(response.data_roles_access.length){
                                for (var i = 0; i < response.data_roles_access.length; i++) {
                                           module_id=response.data_roles_access[i].module_id
                                            if(role_id==1){
                                                if(response.data_roles_access[i].module_id==1){
                                                        $(".all_check_"+role_id).prop('checked', 'checked');                                                     
                                                        $('.all_check_'+role_id).attr("disabled", "disabled");
                                                        
                                                        $('#view_own_'+role_id+'_'+module_id).removeAttr("disabled");
                                                        $('#view_global_'+role_id+'_'+module_id).removeAttr("disabled");
                                                        $('#create_'+role_id+'_'+module_id).removeAttr("disabled");
                                                        $('#edit_'+role_id+'_'+module_id).removeAttr("disabled");
                                                        $('#delete_'+role_id+'_'+module_id).removeAttr("disabled");
                                                        
                                                                                          
                                                }
                                            }
                                            if( parseInt(response.data_roles_access[i].id)){

                                                  $('#role_module_id_'+role_id+'_'+module_id).val(response.data_roles_access[i].id);
                                            }else{
                                                  $('#role_module_id_'+role_id+'_'+module_id).val(0);
                                            }
                                           
                                            if( parseInt(response.data_roles_access[i].view_own)==1){
                                                   $('#view_own_'+role_id+'_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#view_own_'+role_id+'_'+module_id).prop('checked', false);;
                                            }


                                            if( parseInt(response.data_roles_access[i].view_global)==1){
                                                   $('#view_global_'+role_id+'_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#view_global_'+role_id+'_'+module_id).prop('checked', false);;
                                            }


                                            if( parseInt(response.data_roles_access[i].create)==1){
                                                   $('#create_'+role_id+'_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#create_'+role_id+'_'+module_id).prop('checked', false);;
                                            }


                                            if( parseInt(response.data_roles_access[i].edit)==1){
                                                   $('#edit_'+role_id+'_'+module_id).prop('checked', 'checked');
                                            }else{
                                                  $('#edit_'+role_id+'_'+module_id).prop('checked', false);;
                                            }
                                            
                                            if(parseInt(response.data_roles_access[i].view_own)==1 && 
                                                parseInt(response.data_roles_access[i].view_global)==1 &&
                                                parseInt(response.data_roles_access[i].create)==1 &&
                                                parseInt(response.data_roles_access[i].edit)==1 )
                                            {
                                               $('#select_all_'+role_id+'_'+module_id).prop('checked', 'checked');
                                            }
                                            
                                            

                                            // if( parseInt(response.data_roles_access[i].delete)==1){
                                            //       $('#delete_'+role_id+'_'+module_id).prop('checked', 'checked');
                                            // }else{
                                            //       $('#delete_'+role_id+'_'+module_id).prop('checked', false);;
                                            // }
                            }
                        }else{
                            $('.access_role_'+role_id).find('[type=checkbox]').removeAttr("disabled");
                            $('.access_role_'+role_id).find('[type=checkbox]').prop('checked', false);

                            $('.all_check_1').attr("disabled", "disabled");
                            $('#view_own_1_1').removeAttr("disabled");
                            $('#view_global_1_1').removeAttr("disabled");
                            $('#create_1_1').removeAttr("disabled");
                            $('#edit_1_1').removeAttr("disabled");
                           // $('#delete_1_1').removeAttr("disabled");
                        }
                        
                      
                      }else{
                        alert_float('danger',response.reason);
                      }
                   } 
                });
}


$('#select_all_1_1').on('change', function () {
  
      if( this.checked){
        $('.chk_select_all_1').removeAttr('disabled');
        $('.chk_select_all_1').prop('checked', 'true');
        $('.chk_select_all_1').attr("disabled", "disabled");
        $('#chk_select_all_1_1').removeAttr('disabled');
      }else{
        $('.chk_select_all_1').removeAttr('disabled');
        
      }
   }).change();


  $('#view_global_1_1').on('change', function () {
  
      if( this.checked){
        $('.chk_view_global_1').removeAttr('disabled');
        $('.chk_view_global_1').prop('checked', 'true');
        $('.chk_view_global_1').attr("disabled", "disabled");
        $('#view_global_1_1').removeAttr('disabled');
      }else{
        $('.chk_view_global_1').removeAttr('disabled');
        $('.chk_view_global_1').prop('checked', false);
        $('.chk_view_global_1').attr("disabled", "disabled");
        $('#view_global_1_1').removeAttr('disabled');
      }
   }).change();

  $('#view_own_1_1').on('change', function () {
  
      if( this.checked){
        $('.chk_view_own_1').removeAttr('disabled');
        $('.chk_view_own_1').prop('checked', 'true');
        $('.chk_view_own_1').attr("disabled", "disabled");
        $('#view_own_1_1').removeAttr('disabled');
      }else{
        $('.chk_view_own_1').removeAttr('disabled');
        $('.chk_view_own_1').prop('checked', false);
        $('.chk_view_own_1').attr("disabled", "disabled");
        $('#view_own_1_1').removeAttr('disabled');
      }
   }).change();


  $('#create_1_1').on('change', function () {
   
      if( this.checked){
        $('.chk_create_1').removeAttr('disabled');
        $('.chk_create_1').prop('checked', 'true');
        $('.chk_create_1').attr("disabled", "disabled");
        $('#create_1_1').removeAttr('disabled');
      }else{
        $('.chk_create_1').removeAttr('disabled');
        $('.chk_create_1').prop('checked', false);
        $('.chk_create_1').attr("disabled", "disabled");
        $('#create_1_1').removeAttr('disabled');
      }
   }).change();

  $('#edit_1_1').on('change', function () {
    
      if( this.checked){
        $('.chk_edit_1').removeAttr('disabled');
        $('.chk_edit_1').prop('checked', 'true');
        $('.chk_edit_1').attr("disabled", "disabled");
        $('#edit_1_1').removeAttr('disabled');
      }else{
        $('.chk_edit_1').removeAttr('disabled');
        $('.chk_edit_1').prop('checked', false);
        $('.chk_edit_1').attr("disabled", "disabled");
        $('#edit_1_1').removeAttr('disabled');
      }
   }).change();

  $('#delete_1_1').on('change', function () {
  
      if( this.checked){
        $('.chk_delete_1').removeAttr('disabled');
        $('.chk_delete_1').prop('checked', 'true');
        $('.chk_delete_1').attr("disabled", "disabled");
        $('#delete_1_1').removeAttr('disabled');
      }else{
        $('.chk_delete_1').removeAttr('disabled');
        $('.chk_delete_1').prop('checked', false);
        $('.chk_delete_1').attr("disabled", "disabled");
        $('#delete_1_1').removeAttr('disabled');
      }
   }).change();


  // select/unselect check_box_function  //
    $(function() {
          $(".size").click(function(){
              checkwhat  = $(this).data("checkwhat");
              $('input:checkbox.'+checkwhat).not(this).prop('checked', this.checked);
          });
        });

    $(document).ready(function(){
          
        $(".all_check").on("change",function(){
           // console.log(this);
           // var id=0;
           var x = $(this).data('chkvalue');
           // alert(x);
           $('.selectAll_'+x).each(function() {
            
            var view_global = $('#view_global_'+x).prop('checked');
            var view_own = $('#view_own_'+x).prop('checked');
            var create = $('#create_'+x).prop('checked');
            var edit = $('#edit_'+x).prop('checked');
            var delete1 = $('#delete_'+x).prop('checked');
            
           
            if(view_global == true 
                && view_own == true 
                && create == true 
                && edit == true 
                ){
                 // console.log('yes');
                $('#select_all_'+x).prop('checked', 'checked');
            }else{
                // console.log('no');
                $('#select_all_'+x).prop('checked', false);
            }

            });
        });
      });


