 <?php  init_header(); ?>
   <link href="<?= base_url()?>assets/css/custome.css" rel="stylesheet">
  <link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
  <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <style>._status{cursor: pointer;}
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #499eff !important;
            /*background-color: #20aee3 !important;*/
        }
        .text-size,.nav-link{
            font-size: 12px;
        }
        .size{
            /*text-align: center;*/
            width: 18px;
        }
        .:focus{
            box-shadow: none;
        }
        .btn-info{
            padding: 4px;
        }
       
        
    </style>

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
            
          <div class="row">
            <div class="col-12">
              <div class="card">
                  <div class="card-body">
                   <!-- <//https://codepen.io/JacobLett/pen/XopYBo ?php $this->load->view(ADMIN.'RoleAccess/tbl_Role Access'); ?> -->
                   
                   <!-- start permission view design -->
                   <form action="<?= base_url()."admin/RoleAccess/updateAccess" ?>" method="post">
                      <input type="hidden" id="role_id" value="<?= (isset($roles)&&$roles[0]['id'] )?$roles[0]['id']:0 ?>">
                           <div class="row">
                                <div class="col-md-2 mb-3" >
                                    <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                                        <?php
                                           foreach($roles as $key=>$value){
                                        ?>
                                        <li class="nav-item" style="background: #0c53a3;">
                                            <a class="nav-link <?= ($key==0)?"active":"" ?> all_role_ids_tab" id="tab-<?= $key; ?>" data-toggle="tab" href="#tabcontant-<?= $key; ?>" role="tab" aria-controls="<?= $value['role_name']; ?>" aria-selected="true"  data-role_id="<?= $value['id']; ?>" onclick="getRoleAccessData(<?= $value['id']; ?>)"><span style="color:white;"><?= $value['role_name']; ?></span></a>
                                        </li>
                                        <?php
                                           }
                                        ?>
                                      
                                    </ul>
                                </div>
                                  <!-- /.col-md-4 -->
                                <div class="col-md-10">
                                           <div class="tab-content" id="myTabContent">
                                         <?php
                                           foreach($roles as $key1=>$value1){
                                              
                                        ?>
                                        
                                        <div class="tab-pane fade <?= ($key1==0)?"show active":"" ?>" id="tabcontant-<?= $key1; ?>" role="tabpanel" aria-labelledby="tab-<?= $key1; ?>">
                                           
                                            <!-- column -->
                                             <div class="col-11">
                             
                                                <h4 class="card-title"><?= $value1['role_name']; ?></h4>
                                                  
                                                <div class="table-responsive">
                                                <table class="table table-bordered">
                                                        <thead>
                                                                <tr>
                                                                  <th width="8%">Sr.No</th>
                                                                  <th class="text-left" width="10%">Permission</th>
                                                                  <th  width="8%">Select All</th>
                                                                  <th  width="8%">View(global)</th>
                                                                  <th  width="8%">View(own)</th>
                                                                  <th  width="8%">Create</th>
                                                                  <th  width="8%">Edit</th>
                                                                  <!--<th  width="8%">Delete</th>-->
                                                                </tr>
                                                              </thead>
                                                        <tbody>
                                                            <?php
                                                            $i=0;
                                                                foreach($modules as $key2=>$value2){
                                                                    
                                                                   if((($value2['id'] != 1) || ($value2['id'] == 1 && $value1['id'] == 1)) && (($value2['id'] != 2) || ($value2['id'] == 2 && $value1['id'] == 1))):
                                                            ?>
                                                                <tr id="row_<?= $value2['id']; ?>" class="access_role_row access_role_<?= $value1['id']; ?>">
                                                                <td><?=  ++$i;  ?>
                                                                    <input type="hidden" value="<?= ++$key2; ?>">
                                                                    <input type="hidden" name="roles[<?= $key1; ?>][role_id]" value="<?= $value1['id']; ?>">
                                                                    <input type="hidden" name="roles[<?= $key1; ?>][id][]" value="<?= $value2['id']; ?>">
                                                                    <input type="hidden" id="role_module_id_<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="roles[<?= $key1; ?>][role_module_id][]" value="">
                                                                </td>
                                                                <td class="text-left"><span style="margin: 5px 0px 5px 0px;" class="text-color"><?= ucwords($value2['name']); ?></span></td>

                                                                <td>
                                                                	<center>
                                                                		<input type="checkbox" id="select_all_<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="selectAll" data-checkwhat ="selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="sel_all_<?= $value2['id']; ?>" data-chkvalue="<?= $value1['id']; ?>_<?= $value2['id']; ?>" class=" size chk_select_all_<?= $value1['id']; ?>  all_check selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>"/>
                                                                	</center>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" class=" size1 all_check_<?= $value1['id']; ?> all_check chk_view_global_<?= $value1['id']; ?> selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>" id="view_global_<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="view_global_<?= $value1['id']; ?>_<?= $value2['id']; ?>" data-chkvalue="<?= $value1['id']; ?>_<?= $value2['id']; ?>" title="view_global[]" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" class=" size1 all_check all_check_<?= $value1['id']; ?> chk_view_own_<?= $value1['id']; ?> selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>" id="view_own_<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="view_own_<?= $value1['id']; ?>_<?= $value2['id']; ?>" data-chkvalue="<?= $value1['id']; ?>_<?= $value2['id']; ?>"title="view_own" value="1">
                                                                </td>
                                                                <td class="text-nowrap">
                                                                    <input type="checkbox" class=" size1 all_check all_check_<?= $value1['id']; ?> chk_create_<?= $value1['id']; ?> selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>" id="create_<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="create_<?= $value1['id']; ?>_<?= $value2['id']; ?>" data-chkvalue="<?= $value1['id']; ?>_<?= $value2['id']; ?>" title="create[]" value="1">
                                                                </td>
                                                                <td>
                                                                    
                                                                        <input type="checkbox" class=" size all_check all_check_<?= $value1['id']; ?> chk_edit_<?= $value1['id']; ?> selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>" id="edit_<?= $value1['id']; ?>_<?= $value2['id']; ?>" data-chkvalue="<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="edit_<?= $value1['id']; ?>_<?= $value2['id']; ?>" title="edit" value="1">
                                                                    
                                                                </td>
                                                                <!--<td>-->
                                                                    
                                                                <!--        <input title="delete" class=" size all_check all_check_<?= $value1['id']; ?> chk_delete_<?= $value1['id']; ?> selectAll_<?= $value1['id']; ?>_<?= $value2['id']; ?>" type="checkbox" id="delete_<?= $value1['id']; ?>_<?= $value2['id']; ?>" data-chkvalue="<?= $value1['id']; ?>_<?= $value2['id']; ?>" name="delete_<?= $value1['id']; ?>_<?= $value2['id']; ?>" value="1">-->
                                                                <!--</td>-->
                                                                    
                                                                
                                                               <!--  <td><button class="btn btn-info" title="update" id="update" name="update" value="0">update</button>    
                                                                </td> -->
                                                            </tr>
                                                            
                                                            <?php
                                                                   endif;
                                                                }
                                                            ?>
                                                   
                                                          </tbody>
                                                    </table>
                                                </div>
                                  
                                            </div>
                                        <!-- column -->
                                        </div>
                                        <?php
                                           }
                                        ?>
                                     
                                    </div>
                                       <input type="submit" style="float: right;margin-left: 5px;" class="btn btn-info" value="update">
                                </div>
                            <!-- /.col-md-8 -->
                            </div>

                   <!-- end permission view design -->
                    </form>
                  </div>
                </div>
            </div>
          </div>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/role_access.js"></script>

<script type="text/javascript">
    $('#beer').on('change', function () {
            this.value = this.checked ? 1 : 0;
   }).change();
</script>