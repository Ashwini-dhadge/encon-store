<?php

/**
 * 
 */
class Common extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'CommonCustModel');
        isLogin();
    }

    public function getIntialCompanySiteData()
    {
        $branch = $hub = $franchise = $result = array();
        $getDataCompany = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1), 'name,id', '', '');
        $result1 = array();

        foreach ($getDataCompany as $key => $comp) {
            $result['text'] = $comp['name'];
            $getDataSite = $this->CommonModel->getData('tbl_site', array('is_active' => 1, 'company_id' => $comp['id']), 'site_name,id', '', '');
            $json = [];
            foreach ($getDataSite as $key => $value) {
                if ($value['id'] == userId('site_id')) {
                    $json[] = ['id' => $value['id'], 'text' => $value['site_name'], 'selected' => true];
                } else {
                    $json[] = ['id' => $value['id'], 'text' => $value['site_name']];
                }
            }
            $result['children'] = $json;
            $result1[] = $result;
        }
        $branch = $hub = $franchise = $result = array();

        $getData = $this->CommonModel->getData('tbl_master_financial_year', array('is_deleted' => 0), ' to_date,from_date,id ', '', '');
        $result2 = [];
        foreach ($getData as $key => $value) {
            if ($value['id'] == userId('financial_year_id')) {
                $result2[] = ['id' => $value['id'], 'text' => date('Y', strtotime($value['to_date'])) . "-" . date('y', strtotime($value['from_date'])), 'selected' => true];
            } else {
                $result2[] = ['id' => $value['id'], 'text' => date('Y', strtotime($value['to_date'])) . "-" . date('y', strtotime($value['from_date']))];
            }
        }

        $response['result'] = true;
        $response['data'] = $result1;
        $response['data1'] = $result2;
        echo json_encode($response);
    }


    function changeCompanySiteSetting()
    {
        $post = $this->input->post();
        if ($post) {
            $getDataSite = $this->CommonModel->getData('tbl_site', array('is_active' => 1, 'id' => $post['common_company_site_data']), 'company_id,id,site_name,site_inital,short_name', '', 'row_array');
            $getCompanyDataSite = $this->CommonModel->getData('tbl_company_master', array('id' => $getDataSite['company_id']), 'name as company_name', '', 'row_array');
            $getFinancialYear = $this->CommonModel->getData('tbl_master_financial_year', array('id' => $post['common_financial_year']), 'from_date,to_date', '', 'row_array');


            $session = array(
                'company_id' => $getDataSite['company_id'],
                'site_id' => $post['common_company_site_data'],
                'financial_year_id' => $post['common_financial_year'],
                'company_site_name' => $getCompanyDataSite['company_name'] . "-" . $getDataSite['short_name'],
                'company_financial_year' => date('Y', strtotime($getFinancialYear['to_date'])) . "-" . date('y', strtotime($getFinancialYear['from_date'])),
                'site_inital' => $getDataSite['site_inital']
            );
            $this->session->set_userdata($session);


            $description = " Login to new site and financial year - " . userId('name') . " as " . userId('role') . " at " . $getCompanyDataSite['company_name'] . "-" . $getDataSite['site_name'];
            $json_data_login = encode_arr($post);
            //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

            $data_action_log_array = array(userId(), userId('role_id'), $post['common_financial_year'], $getDataSite['company_id'], $post['common_company_site_data'], 'change', $description, '', '', '', '', '', date('Y-m-d H:i:s'), $json_data_login);;
            updateInActionLogFile($data_action_log_array);

            $response['result'] = true;
        } else {
            $response['result'] = false;
            $response['reason'] = 'Something Went Wrong Not change site and financial year';
        }
        echo json_encode($response);
    }



    public function listSite()
    {
        $search = '';
        $where = array();
        $json = [];
        $search = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
        $company_id = isset($_REQUEST['company_id']) ? $_REQUEST['company_id'] : '';

        if (isset($search)) {
            $search = $search;
        } else {

            $search = '';
        }

        if (isset($company_id) && !empty($company_id)) {
            $where['company_id'] = $company_id;
        }

        $sites = $this->CommonCustModel->getCompanySite($search, $where);
        // echo $this->db->last_query();die;
        // print_r($cites);die;
        $json[] = ['id' => 'all', 'text' => 'Select All'];

        foreach ($sites as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['short_name']];
        }
        echo json_encode($json);
    }

    public function listCityName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $city_name = $this->CommonCustModel->getCityName('');
        } else {
            $search = $_GET['searchTerm'];
            $city_name = $this->CommonCustModel->getCityName($search);
        }
        foreach ($city_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['name']];
        }
        echo json_encode($json);
    }


    public function listvender_name($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $vender_nameData = $this->CommonCustModel->getvenderName('');
        } else {
            $search = $_GET['searchTerm'];
            $vender_nameData = $this->CommonCustModel->getvenderName($search);
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($vender_nameData as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['account_name']];
        }
        echo json_encode($json);
    }

    public function listitem_group_name($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $itemgroup_nameData = $this->CommonCustModel->getitemgroupName('');
        } else {
            $search = $_GET['searchTerm'];
            $itemgroup_nameData = $this->CommonCustModel->getitemgroupName($search);
        }

        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($itemgroup_nameData as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['item_group_name']];
        }
        echo json_encode($json);
    }


    public function list_po_items_sel()
    {
        $search = '';
        $where = array();
        $json = [];
        $search = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
        $item_group_select_id = isset($_GET['item_group_select_id']) ? $_GET['item_group_select_id'] : '';

        if (isset($search)) {
            $search = $search;
        } else {

            $search = '';
        }

        if (isset($item_group_select_id) && !empty($item_group_select_id)) {
            $where['i.item_group_select_id'] = $item_group_select_id;
        }



        $sites = $this->CommonCustModel->getlist_po_items_sel_data($search, $where);
        // print_r($cites);die;

        foreach ($sites as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['short_name']];
        }
        echo json_encode($json);
    }





    public function listuser_name($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $user_nameData = $this->CommonCustModel->getuserName('');
        } else {
            $search = $_GET['searchTerm'];
            $user_nameData = $this->CommonCustModel->getuserName($search);
        }
        foreach ($user_nameData as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['first_name'] . " " . $value['last_name'], 'role_name' => $value['role_name']];
        }
        echo json_encode($json);
    }

    public function listdepartment_name($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $department_Data = $this->CommonCustModel->getdepartment_Name('');
        } else {
            $search = $_GET['searchTerm'];
            $department_Data = $this->CommonCustModel->getdepartment_Name($search);
        }
        foreach ($department_Data as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['role_name']];
        }
        echo json_encode($json);
    }
    public function listCompanyName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $company_name = $this->CommonCustModel->getCompanyName('');
        } else {
            $search = $_GET['searchTerm'];
            $company_name = $this->CommonCustModel->getCompanyName($search);
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($company_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['name']];
        }

        echo json_encode($json);
    }
    public function listInventoryItemName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $inventory_name = $this->CommonCustModel->getInventoryItemName('');
        } else {
            $search = $_GET['searchTerm'];
            $inventory_name = $this->CommonCustModel->getInventoryItemName($search);
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($inventory_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['short_name']];
        }

        echo json_encode($json);
    }

    public function list_item_name($value = '')
    {
        $json = [];

        if (isset($_GET['searchTerm']) && isset($_GET['item_group_name_id'])) {
            $search = $_GET['searchTerm'];
            $item_group_name_id = $_GET['item_group_name_id'];
            $item_group_name_id = $_GET['item_group_name_id'];
            if ($item_group_name_id = !'all') {

                $item_name = $this->CommonCustModel->getItemName($search, $item_group_name_id);
            } else {
                $item_name = $this->CommonCustModel->getItemName($search);
            }
        } elseif (isset($_GET['searchTerm'])) {
            $search = $_GET['searchTerm'];
            $item_name = $this->CommonCustModel->getItemName($search, '');
        } elseif (isset($_GET['item_group_name_id'])) {

            $item_group_name_id = $_GET['item_group_name_id'];

            //  echo $item_group_name_id;
            if ($item_group_name_id == 'all') {
                $item_name = $this->CommonCustModel->getItemName();
            } else {
                $item_name = $this->CommonCustModel->getItemName('', $item_group_name_id);
            }
            //  echo "sds1";
        } else {
            $item_name = $this->CommonCustModel->getItemName('');
        }
        // echo $this->db->last_query();
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($item_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['short_name']];
        }
        echo json_encode($json);
    }
    public function listbatchno($value = '')
    {
        $json = [];
        if (isset($_GET['searchTerm']) && isset($_GET['inventory_item_id_a'])) {
            $search = $_GET['searchTerm'];
            $item_id = $_GET['inventory_item_id_a'];
            $batch_name = $this->CommonCustModel->getbatchNo($search, $item_id);
        } elseif (isset($_GET['searchTerm'])) {
            $search = $_GET['searchTerm'];
            $batch_name = $this->CommonCustModel->getbatchNo($search, '');
        } elseif (isset($_GET['inventory_item_id_a'])) {
            $item_id = $_GET['inventory_item_id_a'];
            $batch_name = $this->CommonCustModel->getbatchNo('', $item_id);
        } else {
            $batch_name = $this->CommonCustModel->getbatchNo('');
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($batch_name as $key => $value) {
            $json[] = ['id' => $value['batch_no'], 'text' => $value['batch_no']];
        }
        echo json_encode($json);
    }


    // public function listsite_name($value = '')
    // {
    //     if (!isset($_GET['searchTerm'])) {
    //         $json = [];
    //         $site_nameData = $this->CommonCustModel->getCompanySite('');
    //     } else {
    //         $search = $_GET['searchTerm'];
    //         $site_nameData = $this->CommonCustModel->getCompanySite($search);
    //     }
    //     foreach ($site_nameData as $key => $value) {

    //         $json[] = ['id' => $value['id'], 'text' => $value['site_name']];
    //     }
    //     echo json_encode($json);
    // }
    public function list_cost_project($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $cost_project_name = $this->CommonCustModel->getCostProjectName('');
        } else {
            $search = $_GET['searchTerm'];
            $cost_project_name = $this->CommonCustModel->getCostProjectName($search);
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($cost_project_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['cost_project_name']];
        }

        echo json_encode($json);
    }

    public function getCoutryState($value = '')
    {

        $json = [];
        $search = '';
        $where = array();
        $state = $state1 = '';
        $json = [];

        $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';



        if (isset($city_id) && !empty($city_id)) {
            $city_ids = $this->CommonModel->getData('cities', array('id' => $city_id, 'is_active' => 1), 'state_id,country_id', '', 'row_array');
            $state = $city_ids['state_id'];
            $country1 = $city_ids['country_id'];
        }



        $country = $this->CommonCustModel->getCoutry('', $where);
        foreach ($country as $key => $value) {
            if ($country1 == $value['id']) {
                $json['country'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
            } else {
                $json['country'][] = ['id' => $value['id'], 'text' => $value['name']];
            }
        }
        if ($country1) {
            $states = $this->CommonCustModel->getState('', array('country_id' => $country1));
        } else {
            $states = $this->CommonCustModel->getState('', $where);
        }
        foreach ($states as $key => $value) {
            if ($state == $value['id']) {
                $json['state'][] = ['id' => $value['id'], 'text' => $value['name'], 'selected' => true];
            } else {
                $json['state'][] = ['id' => $value['id'], 'text' => $value['name']];
            }
        }


        echo json_encode($json);
    }
    public function listassignedNameform($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $assigned_name = $this->CommonCustModel->getAssignedName('');
        } else {
            $search = $_GET['searchTerm'];
            $assigned_name = $this->CommonCustModel->getAssignedName($search);
        }

        foreach ($assigned_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['first_name']];
        }
        echo json_encode($json);
    }
    public function listsourceNameform($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $source_name = $this->CommonCustModel->getSourceName('');
        } else {
            $search = $_GET['searchTerm'];
            $source_name = $this->CommonCustModel->getSourceName($search);
        }
        foreach ($source_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['name']];
        }
        echo json_encode($json);
    }
    public function listsourceName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $source_name = $this->CommonCustModel->getSourceName('');
        } else {
            $search = $_GET['searchTerm'];
            $source_name = $this->CommonCustModel->getSourceName($search);
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($source_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['name']];
        }
        echo json_encode($json);
    }

    public function listatusName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $status_name = $this->CommonCustModel->getStatusName('');
        } else {
            $search = $_GET['searchTerm'];
            $status_name = $this->CommonCustModel->getStatusName($search);
        }
        $json[] = ['id' => 'all', 'text' => 'Select All'];
        foreach ($status_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['status']];
        }
        echo json_encode($json);
    }

    public function listatusNameform($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $status_name = $this->CommonCustModel->getStatusName('');
        } else {
            $search = $_GET['searchTerm'];
            $status_name = $this->CommonCustModel->getStatusName($search);
        }
        foreach ($status_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['status']];
        }
        echo json_encode($json);
    }
    public function listCustomerName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $cust_name = $this->CommonCustModel->getCustommerSite('');
        } else {
            $search = $_GET['searchTerm'];
            $cust_name = $this->CommonCustModel->getCustommerSite($search);
        }
        //  $json[] = ['id' => 'all', 'text' => "Select All"];

        foreach ($cust_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['company_name']];
        }
        echo json_encode($json);
    }

    public function listCustomerNameSA($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $cust_name = $this->CommonCustModel->getCustommerSite('');
        } else {
            $search = $_GET['searchTerm'];
            $cust_name = $this->CommonCustModel->getCustommerSite($search);
        }
        $json[] = ['id' => 'all', 'text' => "Select All"];
        foreach ($cust_name as $key => $value) {

            $json[] = ['id' => $value['id'], 'text' => $value['company_name']];
        }
        echo json_encode($json);
    }



    public function plant_name_list_SA($value = '')
    {
        $json = [];
        if (isset($_GET['searchTerm']) && isset($_GET['customer_id'])) {
            $search = $_GET['searchTerm'];
            $customer_id = $_GET['customer_id'];
            $plant_name = $this->CommonCustModel->getPlantName($search, $customer_id);
        } elseif (isset($_GET['searchTerm'])) {
            $search = $_GET['searchTerm'];
            $plant_name = $this->CommonCustModel->getPlantName($search, '');
        } elseif (isset($_GET['customer_id'])) {
            $customer_id = $_GET['customer_id'];
            $plant_name = $this->CommonCustModel->getPlantName('', $customer_id);
        } else {
            $plant_name = $this->CommonCustModel->getPlantName('');
        }
        $json[] = ['id' => 'all', 'text' => "Select All"];
        foreach ($plant_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['plant_narration']];
        }
        echo json_encode($json);
    }
    public function country_name_list($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $country_name = $this->CommonCustModel->getCoutry('');
        } else {
            $search = $_GET['searchTerm'];
            $country_name = $this->CommonCustModel->getCoutry($search);
        }
        foreach ($country_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['name']];
        }
        echo json_encode($json);
    }
    public function plant_name_list($value = '')
    {
        $json = [];
        if (isset($_GET['searchTerm']) && isset($_GET['customer_id'])) {
            $search = $_GET['searchTerm'];
            $customer_id = $_GET['customer_id'];
            $plant_name = $this->CommonCustModel->getPlantName($search, $customer_id);
        } elseif (isset($_GET['searchTerm'])) {
            $search = $_GET['searchTerm'];
            $plant_name = $this->CommonCustModel->getPlantName($search, '');
        } elseif (isset($_GET['customer_id'])) {
            $customer_id = $_GET['customer_id'];
            $plant_name = $this->CommonCustModel->getPlantName('', $customer_id);
        } else {
            $plant_name = $this->CommonCustModel->getPlantName('');
        }
        //  $json[] = ['id' => 'all', 'text' => "Select All"];

        foreach ($plant_name as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['plant_narration']];
        }
        echo json_encode($json);
    }
}
