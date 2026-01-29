<?php

class Height extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'indent/master/FanStackModel');
        isLogin();
    }
    public function index()
    {
        $data['title'] = "Height";
        $this->load->view(ADMIN . 'master/indent/Fan_Stack_Height/list_height', $data);
    }

    public function listHeight()
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

        $where['fh.is_deleted'] = 0;
        $count = count($this->FanStackModel->getHeightData($searchVal, 0, 0, 0, 0, 0, $where));

        if ($count) {
            $result = $this->FanStackModel->getHeightData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
            // print_r($result);die;
            foreach ($result as $key => $value) {

                $row = [];

                array_push($row, $offset + ($key + 1));

                array_push($row, $value['name']);

                $confirm = "confirm('Are you sure you want to delete this Service?')";

                $action = '
    <div style="display: flex; justify-content: center;">
        <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="hightModal(' . $value['id'] . ')" data-id="' . $value['id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>

        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/master/Fan_Stack/Height/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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


    public function hightModal()
    {

        $id = $this->input->post('id');
           $data['sub_title'] = 'Add Dimension';
        if ($id) {
            $height = $this->FanStackModel->getHeightData('', 0, 0, 0, 0, $id);
            //  $data['sub_title'] = 'Edit Dimension Master';
            $data['height'] = $height[0];
        }
        
        // print_r($data['company_name']);die; 
        $html = $this->load->view(ADMIN . 'master/indent/Fan_Stack_Height/model_height', $data, true);
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

    public function addMaster($id = '')
    {
        $post = $this->input->post();

        if ($post) {
            $data1 = array(
                'name' => $this->input->post('name'),
                'created_by' => userId(),
            );
            // print_r($data1);die;
            if (empty($post['id'])) {

                if ($this->CommonModel->iudAction('tbl_master_indent_fan_height', $data1, 'insert')) {
                    $this->session->set_flashdata('success', 'Height added successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add Height!');
                }
            } else {

                if ($this->CommonModel->iudAction('tbl_master_indent_fan_height', $post, 'update', array('id' => $post['id']))) {
                    $this->session->set_flashdata('success', 'Height updated successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update Height!');
                }
            }
            redirect(ADMIN . 'indent/master/Fan_Stack/Height');
        }

        // Load view for adding or editing
        if (!empty($id)) {
            $data['height'] = $this->CommonModel->getData('tbl_master_indent_fan_height', array('id' => $id), '', '', 'row_array');
        } else {
            $data['height'] = null;
        }
        $this->load->view('admin/master/indent/Fan_Stack_Height/height_master', $data);
    }




    public function delete($id = '')
    {
        //    print_r($id);die;
        // $is_deleted = 1;
        $this->CommonModel->iudAction('tbl_master_indent_fan_height', array('is_deleted' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $id));
        redirect(ADMIN . 'indent/master/Fan_Stack/Height');
    }


    /*------------------------------------------------------- For Select2 call   -------------------------------------- */


 public function list_Height()
 {

   if (!isset($_GET['searchTerm'])) {
     $json = [];
     $height = $this->FanStackModel->getHeight('');
   } else {

     $search = $_GET['searchTerm'];

     $height = $this->FanStackModel->getHeight($search);
   }
   
   // $json[] = ['id'=>'all', 'text'=>'Select All'];
   foreach ($height as $key => $value) {

     $json[] = ['id' => $value['name'], 'text' => $value['name']];
   }
   echo json_encode($json);
 }
}
