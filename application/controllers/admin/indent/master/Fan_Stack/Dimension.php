<?php

class Dimension extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'indent/master/FanStackModel');
    isLogin();
  }
  public function index()
  {
    $data['title'] = "Dimension Section";
    $this->load->view(ADMIN . 'master/indent/FanStackDimension/list_dim', $data);
  }

  public function listDimension()
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

    $where['fd.is_deleted'] = 0;
    $count = count($this->FanStackModel->getdDimensionData($searchVal, 0, 0, 0, 0, 0, $where));

    if ($count) {
      $result = $this->FanStackModel->getdDimensionData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

      foreach ($result as $key => $value) {

        $row = [];

        array_push($row, $offset + ($key + 1));

        array_push($row, $value['name']);

        $confirm = "confirm('Are you sure you want to delete this Service?')";

        $action = '
    <div style="display: flex; justify-content: center;">
        <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="dimModal(' . $value['id'] . ')" data-id="' . $value['id'] . '" ><i class="fas fa-edit" aria-hidden="true"></i></a>

        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/master/Fan_Stack/Dimension/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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


  public function dimModal()
  {

    $id = $this->input->post('id');
    $data['sub_title'] = 'Add Dimension';

    if ($id) {
      $dim = $this->FanStackModel->getdDimensionData('', 0, 0, 0, 0, $id);

      $data['dim'] = $dim[0];
    }
    
    // print_r($data['company_name']);die; 
    $html = $this->load->view(ADMIN . 'master/indent/FanStackDimension/model_dim', $data, true);
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

        if ($this->CommonModel->iudAction('tbl_master_indent_fan_dimension', $data1, 'insert')) {
          //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Fan dimension Added Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Add Fan dimension!');
        }
      } else {

        if ($this->CommonModel->iudAction('tbl_master_indent_fan_dimension', $post, 'update', array('id' => $post['id']))) {
          $this->session->set_flashdata('success', 'Fan dimension Updated Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Update Fan dimension!');
        }
      }
      redirect(ADMIN . 'indent/master/Fan_Stack/Dimension');
    }
  }

  public function delete($id = '')
  {
    //    print_r($id);die;

    $this->CommonModel->iudAction('tbl_master_indent_fan_dimension', array('is_deleted' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $id));
    redirect(ADMIN . 'indent/master/Fan_Stack/Dimension');
  }


 /*------------------------------------------------------- For Select2 call   -------------------------------------- */


 public function list_Dimension()
 {

   if (!isset($_GET['searchTerm'])) {
     $json = [];
     $dimension = $this->FanStackModel->getDimension('');
   } else {

     $search = $_GET['searchTerm'];

     $dimension = $this->FanStackModel->getDimension($search);
   }
   
   // $json[] = ['id'=>'all', 'text'=>'Select All'];
   foreach ($dimension as $key => $value) {

     $json[] = ['id' => $value['name'], 'text' => $value['name']];
   }
   echo json_encode($json);
 }


}