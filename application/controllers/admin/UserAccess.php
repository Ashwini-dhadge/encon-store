<?php
/**
 *
 */
class UserAccess extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(ADMIN . 'UserAccessModel');
        $this->load->model(ADMIN . 'CommonCustModel');
        isLogin();
    }
    public function index() {
        $data['title'] = 'User Access';
        $data['user_roles'] = $this->CommonModel->getData('tbl_roles', array('is_main_role' => 0));
        $data['main_role'] = $this->CommonModel->getData('tbl_roles', array('is_main_role' => 1));
      
        $this->load->view(ADMIN . 'user_access/list_user_access', $data);
    }
    public function listUserAccess() {
        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $where = array();
        if ($data['role_id']) {
            $where['u.role_id'] = $data['role_id'];
        }
        if (userId('role_id') != SUPERADMIN_ROLE) {
            $where['u.id !='] = userId();
        }
        
        $count = count($this->UserAccessModel->getUserData($searchVal, 0, 0, 0, 0, 0, $where));
     //   echo $this->db->last_query();die;
        if ($count) {
            $result = $this->UserAccessModel->getUserData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
            foreach ($result as $key => $value) {
               // print_r($result);die;
                $row = [];
                array_push($row, $offset + ($key + 1));
                array_push($row, ucfirst($value['first_name'] . " " . $value['last_name']));
                array_push($row, $value['contact']);
                array_push($row, $value['email']);
                array_push($row, $value['company_name']);
                array_push($row, $value['role_name']);
                $confirm = "confirm('Are you sure you want to delete this user?')";
                $action = '
                <a href="' . base_url() . 'admin/UserAccess/view_user/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                if (getUserAccessForModule('User', 'edit')|| userId('role_id')==SUPERADMIN_ROLE):
                    $action.= '<a href="' . base_url() . 'admin/UserAccess/add_user/' . $value['id'] . '" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                else:
                    $action.= '';
                endif;
                if (getUserAccessForModule('User', 'delete')):
                    $action.= '<a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/UserAccess/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                else:
                    $action.= '';
                endif;
                array_push($row, $action);
                $columns[] = $row;
            }
        }
        $response = ['draw' => $page, 'data' => $columns, 'recordsTotal' => $count, 'recordsFiltered' => $count];
        echo json_encode($response);
    }
    public function view_user($id = '') {
        $data['title'] = 'User';
        $data['roles'] = $this->CommonModel->getData('tbl_roles');
        // $data['modules'] = $this->CommonModel->getData('tbl_module');
        $data['modules'] = $this->UserAccessModel->getUserAccessData($id);
        $data['users'] = $this->UserAccessModel->getUserViewData($id);
        // echo "<pre>";  print_r($data);die;
        $this->load->view(ADMIN . 'user_access/view_user', $data);
    }
    public function add_user($_id = '') {
        $post = $post1 = $this->input->post();
        if ($post) {
            $json_data_login=encode_arr($post);


 
            $insert_user = array('first_name' => $post['first_name'], 'last_name' => $post['last_name'], 'contact' => $post['contact'], 'address' => $post['address'], 'email' => $post['email'],  'password' => $post['password'],'role_id' => $post['role_id'], 'financial_year_id' => $post['financial_year_id'], 'site_id' => $post['site_id'], 'company_id' => $post['company_id'],'department_id'=>$post['department_id']);
            if (empty($post['id'])) {
                $insert_user['created_by'] = userId();
                $insert_user['created_at'] = date('Y-m-d H:i:s');
                $s_id = $this->CommonModel->iudAction('users', $insert_user, 'insert');
                
                 
                            
                if ($s_id) {
                    $insert_user_details = array('user_id' => $s_id);
                    $this->CommonModel->iudAction('user_profile', $insert_user_details, 'insert');
                    foreach ($post['module_id'] as $key1 => $moduleid) {
                        $role_data = array();
                        $mid = $moduleid;
                        $role_data = array('user_id' => $s_id, 'module_id' => $mid, 'create' => (isset($post['create_' . $mid])) ? ($post['create_' . $mid]) : 0, 'edit' => (isset($post['edit_' . $mid])) ? ($post['edit_' . $mid]) : 0, 'delete' => (isset($post['delete_' . $mid])) ? ($post['delete_' . $mid]) : 0, 'view' => (isset($post['view_global_' . $mid])) ? ($post['view_global_' . $mid]) : 0);
                        $this->CommonModel->iudAction('tbl_user_access', $role_data, 'insert');
                    }
                    $role_data_name = $this->CommonModel->getData('tbl_roles',array('id'=>$post['role_id']), 'role_name', '', 'row_array');
                    $activity_details='ADD a  user details with username "'.$post['first_name']." ".$post['last_name'].'" , role "'.$role_data_name['role_name'].'" in '.userId('company_site_name');
                    $action_log="update";
                    //$data=array(user_id,role_id,branch_id,action,descrbtion,shipment_id,ref_type,ref_id,'sub_ref_type',sub_ref_id,datetime);
                    array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

                    $data_action_log_array=array(userId(),userId('role_id'),userId('company_id'),userId('site_id'),userId('financial_year_id'),$action_log,$activity_details,3,3, $post['id'],'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                    updateInActionLogFile($data_action_log_array);   

                    $this->session->set_flashdata('success', 'User Data Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'User Data Not Added !');
                }
            } else {
                $insert_user['updated_by'] = userId();
                $insert_user['updated_at'] = date('Y-m-d H:i:s');
                $this->CommonModel->iudAction('users', $insert_user, 'update', array('id' => $post['id']));
              //  $update_user_details = array('country_id' => $post['country_id'], 'state_id' => $post['state_id'], 'city_id' => $post['city_id']);
              //  $this->CommonModel->iudAction('user_profile', $update_user_details, 'update', array('user_id' => $post['id']));
                foreach ($post['module_id'] as $key1 => $moduleid) {
                    $role_data = array();
                    $mid = $moduleid;
                    $role_data = array('user_id' => $post['id'], 'module_id' => $mid, 'create' => (isset($post['create_' . $mid])) ? ($post['create_' . $mid]) : 0, 'edit' => (isset($post['edit_' . $mid])) ? ($post['edit_' . $mid]) : 0, 'delete' => (isset($post['delete_' . $mid])) ? ($post['delete_' . $mid]) : 0, 'view' => (isset($post['view_global_' . $mid])) ? ($post['view_global_' . $mid]) : 0);
                    $user_module_id = (isset($post['user_module_id_' . $mid])) ? ($post['user_module_id_' . $mid]) : 0;
                    if ($user_module_id) {
                        $this->CommonModel->iudAction('tbl_user_access', $role_data, 'update', array('id' => $user_module_id));
                    } else {
                        $this->CommonModel->iudAction('tbl_user_access', $role_data, 'insert');
                    }
                }
                
                 $role_data_name = $this->CommonModel->getData('tbl_roles',array('id'=>$post['role_id']), 'role_name', '', 'row_array');
                $activity_details='Updated a  user details with username "'.$post['first_name']." ".$post['last_name'].'" , role "'.$role_data_name['role_name'].'" in '.userId('company_site_name');
                $action_log="update";
                //$data=array(user_id,role_id,branch_id,action,descrbtion,shipment_id,ref_type,ref_id,'sub_ref_type',sub_ref_id,datetime);
                array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

                $data_action_log_array=array(userId(),userId('role_id'),userId('company_id'),userId('site_id'),userId('financial_year_id'),$action_log,$activity_details,3,3, $post['id'],'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                updateInActionLogFile($data_action_log_array);   
                $this->session->set_flashdata('success', 'User Data Update Successfully');
            }
            redirect(base_url(ADMIN . 'UserAccess'));
        }
        if ($_id) {
            $user_data = $this->UserAccessModel->getUserData('', 0, 0, 0, 0, $_id);
            $data = $user_data[0];
            $data['title'] = 'Edit User';
            $data['site_master'] = $this->CommonModel->getData('tbl_site', array('is_active' => 1,'company_id'=>$user_data[0]['company_id']));
        }
        $data['title'] = 'Add User';
        $data['user_roles'] = $this->CommonModel->getData('tbl_roles', array('is_main_role' => 0));
        $data['main_role'] = $this->CommonModel->getData('tbl_roles', array('is_main_role' => 1));
        $data['modules'] = $this->CommonModel->getData('tbl_module', array('is_display_user_access' => 1));
        $data['financial_year'] = $this->CommonModel->getData('tbl_master_financial_year', array('is_deleted' => 0));
        $data['company_master'] = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1));
          $data['departments'] = $this->CommonModel->getData('tbl_department');
        // $data['permission_module'] = $this->CommonModel->getData('tbl_module',array('is_active'=>1,'id >'=>1));
        // echo "<pre>";print_r($data);die;
        $this->load->view(ADMIN . 'user_access/add_view_user', $data);
    }
    public function getDataParent() {
        $json = $where = array();
        if (isset($_POST['role_id'])) {
            $where['role_id'] = $_POST['role_id'];
        }
        $users = array();
        if (isset($_POST['user_id'])) {
            $where1['id'] = $_POST['user_id'];
            $users = $this->CommonModel->getData('users', $where1, 'id, CONCAT(first_name," ",last_name) AS name,parent_staffid', '', 'row_array');
        }
        $where['deleted_by'] = NULL;
        //print_r($users); die;
        $parents = $this->CommonModel->getData('users', $where, 'id, CONCAT(first_name," ",last_name) AS name,parent_staffid');
        //echo $this->db->last_query();die;
        $json['parent_name'][] = ['id' => '', 'text' => ''];
        foreach ($parents as $key => $value) {
            if (isset($users['parent_staffid']) && $users['parent_staffid'] == $value['id']) {
                $json['parent_name'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
            } else {
                $json['parent_name'][] = ['id' => $value['id'], 'text' => $value['name']];
            }
        }
        echo json_encode($json);
    }
    public function getDataAllUserData() {
        $json = $where = array();
       
        $where['deleted_by'] = NULL;
        $user_id = $_POST['user_id'];
        if (isset($user_id) && !empty($user_id)) {
            $user_data = $this->CommonModel->getData('users', array('id' => $user_id), 'parent_staffid', '', 'row_array');
            $user_profile = $this->CommonModel->getData('user_profile', array('user_id' => $user_id), 'country_id,state_id,city_id', '', 'row_array');
            $parent = $user_data['parent_staffid'];
            $city = isset($user_profile['city_id'])?$user_profile['city_id']:'';
            $state = isset($user_profile['state_id'])?$user_profile['state_id']:'';
            $country1 = isset($user_profile['country_id'])?$user_profile['country_id']:'';
        }
        $parents = $this->CommonModel->getData('users', $where, 'id, CONCAT(first_name," ",last_name) AS name');
        foreach ($parents as $key => $value) {
            if ($value['id'] == $parent) {
                $json['parent'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
            } else {
                $json['parent'][] = ['id' => $value['id'], 'text' => $value['name']];
            }
        }
        $country = $this->CommonCustModel->getCoutry('', '');
        foreach ($country as $key => $value) {
            if ($country1 == $value['id']) {
                $json['country'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
            } else {
                $json['country'][] = ['id' => $value['id'], 'text' => $value['name']];
            }
        }
        if ($country1) {
            $states = $this->CommonCustModel->getState('', array('country_id' => $country1));
            foreach ($states as $key => $value) {
                if ($state == $value['id']) {
                    $json['state'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
                } else {
                    $json['state'][] = ['id' => $value['id'], 'text' => $value['name']];
                }
            }
        } else {
            $json['state'][] = array();
        }
        if ($country1 && $state) {
            $cities = $this->CommonCustModel->getCity('', array('country_id' => $country1, 'state_id' => $state));
            foreach ($cities as $key => $value) {
                if ($city == $value['id']) {
                    $json['city'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
                } else {
                    $json['city'][] = ['id' => $value['id'], 'text' => $value['name']];
                }
            }
        } else {
            $json['city'][] = array();
        }
        $user_access = $this->CommonModel->getData('tbl_user_access', array('user_id' => $user_id));
        $json['data_user_access'] = $user_access;
        
        // $user_access = $this->UserAccessModel->getUserModuleAcess(array('ua.user_id' => $user_id));
        echo json_encode($json);
    }
    public function getUserDataRole() {
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
    public function getDataRoleUserAccess() {
        $role_id = $this->input->post('role_id');
        $parent_user_id = $this->input->post('parent_user_id');
        $response = array();
        if ($parent_user_id) {
            $parent_access = array();
            $parent_access = $this->CommonModel->getData('tbl_user_access', array('user_id' => $parent_user_id));
            if (count($parent_access)) {
                $data_roles_access = $parent_access;
            } else {
                $data_roles_access = $this->CommonModel->getData('tbl_roles_access', array('role_id' => $role_id));
            }
            $response['result'] = TRUE;
            $response['data_roles_access'] = $data_roles_access;
            echo json_encode($response);
        } else {
            $response['result'] = FALSE;
            $response['reason'] = 'Role ID Required';
            echo json_encode($response);
        }
    }
    public function emailCheck($id = '') {
        if (isset($_POST['email'])) {
            if ($id == 0) {
                $count = $this->CommonModel->getData('users', array('email' => $_POST['email']), '', '', 'num_rows');
            } else {
                $count = $this->CommonModel->getData('users', array('email' => $_POST['email'], 'id !=' => $id), '', '', 'num_rows');
            }
            if ($count) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
    public function contactCheck($id = '') {
        if (isset($_POST['contact'])) {
            if ($id == 0) {
                $count = $this->CommonModel->getData('users', array('contact' => $_POST['contact']), '', '', 'num_rows');
            } else {
                $count = $this->CommonModel->getData('users', array('contact' => $_POST['contact'], 'id !=' => $id), '', '', 'num_rows');
            }
            if ($count) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
    public function delete($id) {
        if ($id) {
            if ($this->CommonModel->iudAction('users', array('deleted_by' => isLogin()), 'update', array('id' => $id))) {
                $this->session->set_flashdata('success', 'User Data Deleted Successfully');
            } else {
                $this->session->set_flashdata('error', 'Fail to Delete User Data');
            }
        } else {
            $this->session->set_flashdata('error', INVAILD_INPUT);
        }
        redirect(base_url(ADMIN . 'UserAccess'));
    }
}