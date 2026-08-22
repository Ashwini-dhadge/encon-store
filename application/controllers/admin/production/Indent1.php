<?php

/**
 * 
 */
class Indent extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'production/IndentModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Indent';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 1), 'id,indent_name');
    //  print_r($data['indent_name']);die;
    $this->load->view(ADMIN . 'production/list_indent', $data);
  }


  public function listblade_indent()
  {
    $data = $_POST;
    $columns = [];
    $page = $data['draw'];
    $limit = $data['length'];
    $offset = $data['start'];
    $searchVal = $data['search']['value'];
    $sortColIndex = $data['order'][0]['column'];
    $sortBy = $data['order'][0]['dir'];
    $where = array();

    if ($data['indentid'] == "all") {
      $where = array();
    } else {
      $where['tid.master_indent_id'] = $data['indentid'];
    }

    $count = count($this->IndentModel->getBladeIndentData($searchVal, 0, 0, 0, 0, 0, $where));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->IndentModel->getBladeIndentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
      // echo"<pre>";
      // print_r($result);die;

      foreach ($result as $key => $value) {

        $row = [];

        array_push($row, $offset + ($key + 1));
        array_push($row, $value['client_name']);
        array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['date']);


        $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

        $action = '
                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="costprojectModal(' . $value['id'] . ')" data-id="' . $value['id'] . '" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                	 <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/master/CostProject/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                   <a href="' . base_url() . 'admin/production/Indent/view_indent_blade/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>
                    <a onclick="return " href="' . base_url() . 'admin/production/Indent/CreateOrderforBladeb/' . $value['indent_id'] . '/'.$value['indent_bland_id'].'" title="Create Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-check-square" aria-hidden="true"></i></a>
                       ';

        array_push($row, $action);



        $columns[] = $row;
      }
    }
    $response = [
      'draw' => $page,
      'data' => $columns,
      'recordsTotal' => $count,
      'recordsFiltered' => $count
    ];
    echo json_encode($response);
  }



  public function listindent($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $indent_name = $this->IndentModel->getIndentName('');
    } else {
      $search = $_GET['searchTerm'];
      $indent_name = $this->IndentModel->getIndentName($search);
    }
    $json[] = ['id' => 'all', 'text' => 'Select All'];
    foreach ($indent_name as $key => $value) {
      $json[] = ['id' => $value['id'], 'text' => $value['indent_name']];
    }

    echo json_encode($json);
  }



  public function CreateOrderforBladeb($id = "",$blade_indent_id="")
  {
   
    if ($_POST) {
      $post = $_POST;
    
      // die;
      if ($post['order_for'] == "2") {
        $data = array(
          'order_for' => isset($post['order_for']) ? $post['order_for'] : '',
          'indent_date' => isset($post['indent_date']) ? $post['indent_date'] : '',
          'delivery_date' => isset($post['delivery_date']) ? $post['delivery_date'] : '',
          'mould_size' => isset($post['mould_size']) ? $post['mould_size'] : '',
          'blade_size' => isset($post['blade_size']) ? $post['blade_size'] : '',
          'blade_qty' => isset($post['blade_qty']) ? $post['blade_qty'] : '',
          'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          'core' => isset($post['core']) ? $post['core'] : '',
          'way' => isset($post['way']) ? $post['way'] : '',
          'a_tip' => isset($post['a_tip']) ? $post['a_tip'] : '',
          'blade_punching_no' => isset($post['blade_punching_no']) ? $post['blade_punching_no'] : '',
          'remark' => isset($post['remark']) ? $post['remark'] : '',
          'type' => isset($post['type']) ? $post['type'] : '',
          'created_by' => userId(),
        );


        // echo"<pre>";
        // print_r($data);
        // die;
        $result =  $this->CommonModel->iudAction('tbl_indent_order', $data, 'insert', '');

        if ($result) {
          $data = array(
            "order_id" => $result,
            'status_id' => 13,
            'qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
            'created_by' => userId(),
          );
          $this->CommonModel->iudAction('tbl_indent_order_status_details', $data, 'insert', '');

          $data2 = array(
            "order_id" => $result,
            'qty' => isset($post['blade_qty']) ? $post['blade_qty'] : '',
            'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          );
          $this->CommonModel->iudAction('tbl_indent_order_status', $data2, 'insert', '');
        }
        $this->session->set_flashdata('success', 'Encon Order Added Succesfully!');
        redirect(base_url(ADMIN . 'production/Indent'));
      } elseif ($post['order_for'] == "1") {

        // $post = $_POST;
        // echo"<pre>";
        // print_r($post);die;
        $data = array(
          'order_for' => isset($post['order_for']) ? $post['order_for'] : '',
          'indent_date' => isset($post['indent_date']) ? $post['indent_date'] : '',
          'delivery_date' => isset($post['dispatch_date']) ? $post['dispatch_date'] : '',
          'party_id' => isset($post['party_id']) ? $post['party_id'] : '',
          'indent_id' => isset($post['indent_id']) ? $post['indent_id'] : '',
          'fan_dia_feet' => isset($post['fan_dia_feet']) ? $post['fan_dia_feet'] : '',
          'mould_size' => isset($post['mould_size']) ? $post['mould_size'] : '',
          'hub_size' => isset($post['hub_size']) ? $post['hub_size'] : '',
          'blade_size' => isset($post['blade_size']) ? $post['blade_size'] : '',
          'blade_qty' => isset($post['blade_qty']) ? $post['blade_qty'] : '',
          'blade_punching_no' => isset($post['blade_punching_no']) ? $post['blade_punching_no'] : '',
          'a_tip' => isset($post['a_tip']) ? $post['a_tip'] : '',
          'color' => isset($post['color']) ? $post['color'] : '',
          'name_plate' => isset($post['name_plate']) ? $post['name_plate'] : '',
          'way' => isset($post['way']) ? $post['way'] : '',
          'order_set' => isset($post['order_set']) ? $post['order_set'] : '',
          'blade_qty' => isset($post['total_blade_qty']) ? $post['total_blade_qty'] : '',
          'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          'created_by' => userId(),
        );
        // echo"<pre>";
        // print_r($data);die;
        $result =  $this->CommonModel->iudAction('tbl_indent_order', $data, 'insert', '');

        if ($result) {
          $data = array(
            "order_id" => $result,
            'status_id' => 13,
            'qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
            'created_by' => userId(),
          );
          $this->CommonModel->iudAction('tbl_indent_order_status_details', $data, 'insert', '');

          $data2 = array(
            "order_id" => $result,
            'qty' => isset($post['total_blade_qty']) ? $post['total_blade_qty'] : '',
            'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          );
          $this->CommonModel->iudAction('tbl_indent_order_status', $data2, 'insert', '');
        }

        $this->session->set_flashdata('success', 'Encon Order Added Succesfully!');
        redirect(base_url(ADMIN . 'production/Indent'));
      }
    }
    $blade = $this->IndentModel->indentDetails($id,$blade_indent_id);
   // echo $this->db->last_query();die;
    $data['blade_data'] = $blade[0];
    $data['type'] = "1";
    //  echo "<pre>";print_r( $data['blade_data']);die;
    $this->load->view(ADMIN . 'production/add_indentfor_blade_balaji', $data);
  }




  public function view_indent_blade($id)
  {
    $indentDetails = $this->IndentModel->indentOrderDetails($id);

    $data['indentDetails'] = $indentDetails[0];
    $data['details'] = $this->IndentModel->orderStatus($id);
    // $details = $this->IndentModel->orderStatus($id);
    //  echo"<pre>";
    //   print_r($details);
    //   die;
    
    $this->load->view(ADMIN . 'production/view_indent_blade', $data);
  }

  public function add_createfor_blade_encon($id = '')
  {
    $data['type'] = "2";
    $this->load->view(ADMIN . 'production/add_indentfor_blade_balaji', $data);
    // $this->load->view(ADMIN . 'production/add_indentfor_blade_encon_india');
  }

  public function listclientName($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $client = $this->IndentModel->getclientName('');
    } else {
      $search = $_GET['searchTerm'];
      $client = $this->IndentModel->getclientName($search);
    }
    foreach ($client as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['company_name']];
    }
    echo json_encode($json);
  }


  public function listmould_size($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $mould = $this->IndentModel->getmouldsize('');
    } else {
      $search = $_GET['searchTerm'];
      $mould = $this->IndentModel->getmouldsize($search);
    }
    foreach ($mould as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['name']];
    }
    echo json_encode($json);
  }



  public function list_a_tip($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $a_tip = $this->IndentModel->get_a_tip('');
    } else {
      $search = $_GET['searchTerm'];
      $a_tip = $this->IndentModel->get_a_tip($search);
    }
    foreach ($a_tip as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['name']];
    }
    echo json_encode($json);
  }
}
