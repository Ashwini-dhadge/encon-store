<?php

class Color extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'indent/master/BladeModel');
    isLogin();
  }
  public function index()
  {
    $data['title'] = "Colour";
    $this->load->view(ADMIN . 'master/indent/Color/list_color', $data);
  }

  public function listColor()
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

    $where['bc.is_deleted'] = 0;
    $count = count($this->BladeModel->ColorModel($searchVal, 0, 0, 0, 0, 0, $where));

    if ($count) {
      $result = $this->BladeModel->ColorModel($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

      foreach ($result as $key => $value) {

        $row = [];

        array_push($row, $offset + ($key + 1));

        array_push($row, $value['name']);

        $confirm = "confirm('Are you sure you want to delete this Service?')";

        $action = '
    <div style="display: flex; justify-content: center;">
        <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="colorModal(' . $value['id'] . ')" data-id="' . $value['id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>

        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/master/Blade/Color/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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



  public function colorModal()
  {

    $id = $this->input->post('id');
    $data['sub_title'] = 'Add Dimension';
    if ($id) {
      $color = $this->BladeModel->ColorModel('', 0, 0, 0, 0, $id);
      $data['sub_title'] = 'Edit Dimension Master';
      $data['color'] = $color[0];
    }
  
    // print_r($data['company_name']);die; 
    $html = $this->load->view(ADMIN . 'master/indent/Color/model_color', $data, true);
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

        if ($this->CommonModel->iudAction('tbl_master_indent_blade_color', $data1, 'insert')) {
          //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Color Added Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Add Color!');
        }
      } else {

        if ($this->CommonModel->iudAction('tbl_master_indent_blade_color', $post, 'update', array('id' => $post['id']))) {
          $this->session->set_flashdata('success', 'Color Updated Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Update Color!');
        }
      }
      redirect(ADMIN . 'indent/master/Blade/Color');
    }
  }

  public function delete($id = '')
  {
    //    print_r($id);die;
    $is_deleted = 1;
    $this->CommonModel->iudAction('tbl_master_indent_blade_color', array('is_deleted' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $id));
    redirect(ADMIN . 'indent/master/Blade/Color');
  }


  

 /*------------------------------------------------------- For Select2 call   -------------------------------------- */


 public function list_color()
 {
  
    if (!isset($_GET['searchTerm'])) {
        $json = [];
        $mouldData = $this->BladeModel->getColor('');
    } else {

        $search = $_GET['searchTerm'];
       
        $mouldData = $this->BladeModel->getColor($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($mouldData as $key => $value) {
        
        $json[] = ['id' => $value['name'], 'text' => $value['name']];
    }
    echo json_encode($json);
}


}
