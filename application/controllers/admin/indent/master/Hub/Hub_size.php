<?php

class Hub_size extends CI_Controller
{


  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'indent/master/HubModel');
    isLogin();
  }
  public function index()
  {
    $data['title'] = "Hub Size";
    $this->load->view(ADMIN . 'master/indent/Hub_size/list_hubsize', $data);
  }


  public function list_hub()
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

    $where['hs.is_deleted'] = 0;
    $count = count($this->HubModel->getHubData($searchVal, 0, 0, 0, 0, 0, $where));

    if ($count) {
      $result = $this->HubModel->getHubData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

      foreach ($result as $key => $value) {

        $row = [];

        array_push($row, $offset + ($key + 1));

        array_push($row, $value['name']);

        $confirm = "confirm('Are you sure you want to delete this Service?')";

        $action = '
    <div style="display: flex; justify-content: center;">
        <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="hubModal(' . $value['id'] . ')" data-id="' . $value['id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>

        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/master/Hub/Hub_size/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
    </div>
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



  public function hubModal()
  {

    $id = $this->input->post('id');
    $data['sub_title'] = 'Add Dimension';
    if ($id) {
      $hub = $this->HubModel->getHubData('', 0, 0, 0, 0, $id);
      // $data['sub_title'] = 'Edit Dimension Master';
      $data['hub'] = $hub[0];
    }
    
    // print_r($data['company_name']);die; 
    $html = $this->load->view(ADMIN . 'master/indent/Hub_size/model_hubsize', $data, true);
    if ($html) {
      $response['html'] = $html;
      $response['result'] = true;
      $response['reason'] = 'Data Found';
    } else {
      $response['result'] = false;
      $response['reason'] = 'Something went to wrong!';
    }
    echo json_encode($response);
  }




  public function addMaster()
  {
    $post = $this->input->post();
    // print_r($post);die;
    if ($post) {
      $data1 = array(
        'name' => $this->input->post('name'),
        'created_by' => userId(),
      );
      if (empty($post['id'])) {

        if ($this->CommonModel->iudAction('tbl_master_indent_hub_size', $data1, 'insert')) {
          //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Hub Size Added Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Add Hub Size!');
        }
      } else {

        if ($this->CommonModel->iudAction('tbl_master_indent_hub_size', $post, 'update', array('id' => $post['id']))) {
          $this->session->set_flashdata('success', 'Hub Size Updated Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Update Hub Size!');
        }
      }
      redirect(ADMIN . 'indent/master/Hub/Hub_size');
    }
  }

  public function delete($id = '')
  {
    //    print_r($id);die;

    $this->CommonModel->iudAction('tbl_master_indent_hub_size', array('is_deleted' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $id));
    redirect(ADMIN . 'indent/master/Hub/Hub_size');
  }



 /*------------------------------------------------------- For Select2 call   -------------------------------------- */


 public function list_hubSize()
 {
  
    if (!isset($_GET['searchTerm'])) {
        $json = [];
        $mouldData = $this->HubModel->getHubSize('');
    } else {

        $search = $_GET['searchTerm'];
       
        $mouldData = $this->HubModel->getHubSize($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($mouldData as $key => $value) {
        
        $json[] = ['id' => $value['name'], 'text' => $value['name']];
    }
    echo json_encode($json);
}



}
