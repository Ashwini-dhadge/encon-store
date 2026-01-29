<?php
/**
 *
 */
class RoleAccess extends CI_Controller {
    function __construct() {
        parent::__construct();
        // $this->load->model(ADMIN.'VisitRequestModel');
        isLogin();
    }
    public function index() {
        $data['title'] = 'Role Access';
        $data['roles'] = $this->CommonModel->getData('tbl_roles', array('is_main_role' => '1'));
        $data['modules'] = $this->CommonModel->getData('tbl_module', array('is_active' => '1'));
        $this->load->view(ADMIN . 'role_access/view_role_access', $data);
    }
    public function getDataRole() {
        $role_id = $this->input->post('role_id');
        $response = array();
        if ($role_id) {
            $data_roles_access = $this->CommonModel->getData('tbl_roles_access', array('role_id' => $role_id));
            $response['result'] = TRUE;
            $response['data_roles_access'] = $data_roles_access;
            echo json_encode($response);
        } else {
            $response['result'] = FALSE;
            $response['reason'] = 'Role ID Required';
            echo json_encode($response);
        }
    }
    public function updateAccess() {
        $post = $this->input->post();
        // echo"<pre>";
        //  print_r($post);die;
        if (isset($post['roles'])) {
            foreach ($post['roles'] as $key => $role) {
                foreach ($role['id'] as $key1 => $module_id) {
                    if ($role['role_id'] == 1) {
                        $role_data = array();
                        $role_id = $role['role_id'];
                        $role_data = array('module_id' => $module_id, 'role_id' => $role_id, 'create' => (isset($post['create_' . $role_id . '_' . $module_id])) ? ($post['create_' . $role_id . '_' . $module_id]) : 0, 'edit' => (isset($post['edit_' . $role_id . '_' . $module_id])) ? ($post['edit_' . $role_id . '_' . $module_id]) : 0, 'delete' => (isset($post['delete_' . $role_id . '_' . $module_id])) ? ($post['delete_' . $role_id . '_' . $module_id]) : 0, 'view_global' => (isset($post['view_global_' . $role_id . '_' . $module_id])) ? ($post['view_global_' . $role_id . '_' . $module_id]) : 0, 'view_own' => (isset($post['view_own_' . $role_id . '_' . $module_id])) ? ($post['view_own_' . $role_id . '_' . $module_id]) : 0,);
                        if (isset($role['role_module_id'][$key1]) && !empty($role['role_module_id'][$key1])) {
                            $role_module_id = $role['role_module_id'][$key1];
                            $this->CommonModel->iudAction('tbl_roles_access', $role_data, 'update', array('id' => $role_module_id));
                            
                            $module_data_name = $this->CommonModel->getData('tbl_module', array('id' => $module_id), 'name', '', 'row_array');
                            $activity_details='Updated role access for  '.$module_data_name['name'];
                            $action_log="update";
                        } else {
                            $this->CommonModel->iudAction('tbl_roles_access', $role_data, 'insert');
                            
                            $module_data_name = $this->CommonModel->getData('tbl_module', array('id' => $module_id), 'name', '', 'row_array');
                            $activity_details='Inserted role access for  '.$module_data_name['name'];
                            $action_log="insert";
                        }
                        $json_data_login=encode_arr($post);
                       
                        $data_action_log_array=array(userId(),userId('role_id'),userId('branch_id'),$action_log,$activity_details,0,2, $role_module_id,'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                        updateInActionLogFile($data_action_log_array);
                        break;
                    } else {
                        $role_data = array();
                        $role_id = $role['role_id'];
                        $role_data = array('module_id' => $module_id, 'role_id' => $role_id, 'create' => (isset($post['create_' . $role_id . '_' . $module_id])) ? ($post['create_' . $role_id . '_' . $module_id]) : 0, 'edit' => (isset($post['edit_' . $role_id . '_' . $module_id])) ? ($post['edit_' . $role_id . '_' . $module_id]) : 0, 'delete' => (isset($post['delete_' . $role_id . '_' . $module_id])) ? ($post['delete_' . $role_id . '_' . $module_id]) : 0, 'view_global' => (isset($post['view_global_' . $role_id . '_' . $module_id])) ? ($post['view_global_' . $role_id . '_' . $module_id]) : 0, 'view_own' => (isset($post['view_own_' . $role_id . '_' . $module_id])) ? ($post['view_own_' . $role_id . '_' . $module_id]) : 0,);
                        if (isset($role['role_module_id'][$key1]) && !empty($role['role_module_id'][$key1])) {
                            $role_module_id = $role['role_module_id'][$key1];
                            $this->CommonModel->iudAction('tbl_roles_access', $role_data, 'update', array('id' => $role_module_id));
                            
                            $module_data_name = $this->CommonModel->getData('tbl_module', array('id' => $module_id), 'name', '', 'row_array');
                            $activity_details='Updated role access for  '.$module_data_name['name'];
                            $action_log="update";
                            
                        } else {
                            $this->CommonModel->iudAction('tbl_roles_access', $role_data, 'insert');
                            
                            $module_data_name = $this->CommonModel->getData('tbl_module', array('id' => $module_id), 'name', '', 'row_array');
                            $activity_details='Inserted role access for  '.$module_data_name['name'];
                            $action_log="insert";
                        }
                        $json_data_login=encode_arr($post);
                        $data_action_log_array=array(userId(),userId('role_id'),userId('branch_id'),$action_log,$activity_details,0,2, $role_module_id,'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                        updateInActionLogFile($data_action_log_array);
                        // echo($this->db->last_query()."<br>");
                        
                    }
                }
            }
            $this->session->set_flashdata('success', 'Data Updated Successfully');
        } else {
            $this->session->set_flashdata('error', 'Data Not Updated !');
        }
        redirect(base_url(ADMIN . 'RoleAccess'));
    }
}
?>