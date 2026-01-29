<?php

class Mould_size extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'indent/master/BladeModel');
    isLogin();
  }
  public function index()
  {
    $data['title'] = "Mould Size";
    $this->load->view(ADMIN . 'master/indent/Mould_size/list_mould', $data);
  }

  public function listMouldSize()
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

    $where['bms.is_deleted'] = 0;
    $count = count($this->BladeModel->listMouldSize($searchVal, 0, 0, 0, 0, 0, $where));

    if ($count) {
      $result = $this->BladeModel->listMouldSize($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

      foreach ($result as $key => $value) {

        $row = [];

        array_push($row, $offset + ($key + 1));

        array_push($row, $value['name']);

        $confirm = "confirm('Are you sure you want to delete this Service?')";

        $action = '
        <div style="display: flex; justify-content: center;">
            <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="mouldSizeModal(' . $value['id'] . ')" data-id="' . $value['id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>
    
            <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/master/Blade/Mould_size/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray; margin-right: 10px;"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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



  public function mouldSizeModal()
  {

    $id = $this->input->post('id');
    $data['sub_title'] = 'Add Dimension';
    if ($id) {
      $mould = $this->BladeModel->listMouldSize('', 0, 0, 0, 0, $id);
      $data['sub_title'] = 'Edit Dimension Master';
      $data['mould'] = $mould[0];
    }
    //   $data['company_name'] = $this->CommonModel->getData('tbl_company_master'); 
    // print_r($data['company_name']);die; 
    $html = $this->load->view(ADMIN . 'master/indent/Mould_size/model_mould', $data, true);
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

        if ($this->CommonModel->iudAction('tbl_master_indent_blade_mould_size', $data1, 'insert')) {
          //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Mould Size Added Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Add Mould Size!');
        }
      } else {

        if ($this->CommonModel->iudAction('tbl_master_indent_blade_mould_size', $post, 'update', array('id' => $post['id']))) {
          $this->session->set_flashdata('success', 'Mould Size Updated Succesfully!');
        } else {
          $this->session->set_flashdata('error', 'Fail To Update Mould Size!');
        }
      }
      redirect(ADMIN . 'indent/master/Blade/Mould_size');
    }
  }

  public function delete($id = '')
  {
    //    print_r($id);die;

    $this->CommonModel->iudAction('tbl_master_indent_blade_mould_size', array('is_deleted' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $id));
    redirect(ADMIN . 'indent/master/Blade/Mould_size');
  }







  /*------------------------------------------------------- For Select2 call   -------------------------------------- */


  public function listMould()
  {
   
     if (!isset($_GET['searchTerm'])) {
         $json = [];
         $mouldData = $this->BladeModel->getMouldSize('');
     } else {

         $search = $_GET['searchTerm'];
        
         $mouldData = $this->BladeModel->getMouldSize($search);
     }
     // $json[] = ['id'=>'all', 'text'=>'Select All'];
     foreach ($mouldData as $key => $value) {
         
         $json[] = ['id' => $value['name'], 'text' => $value['name']];
     }
     echo json_encode($json);
 }
}
