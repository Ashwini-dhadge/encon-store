<?php

class Clamp_type extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'indent/master/ClampModel');
        isLogin();
    }
    public function index()
    {
        $data['title'] = "Clamp Type";
        $this->load->view(ADMIN . 'master/indent/Clamp_type/list_clamptype', $data);
    }


    public function list_clamp_type()
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

        $where['ct.is_deleted'] = 0;
        $count = count($this->ClampModel->getClampTypeData($searchVal, 0, 0, 0, 0, 0, $where));

        if ($count) {
            $result = $this->ClampModel->getClampTypeData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

            foreach ($result as $key => $value) {

                $row = [];

                array_push($row, $offset + ($key + 1));

                array_push($row, $value['name']);

                $confirm = "confirm('Are you sure you want to delete this data?')";

                $action = '
                    <div style="display: flex; justify-content: center;">
                        <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="clampModal(' . $value['id'] . ')" data-id="' . $value['id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>

                        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/master/Clamp/Clamp_type/delete/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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



    public function clampModal()
    {

        $id = $this->input->post('id');
        $data['sub_title'] = 'Add Dimension';
        if ($id) {
            $hub = $this->ClampModel->getClampTypeData('', 0, 0, 0, 0, $id);
            $data['hub'] = $hub[0];
        }

        $html = $this->load->view(ADMIN . 'master/indent/Clamp_type/modal_clamptype', $data, true);
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

        if ($post) {
            $data1 = array(
                'name'       => $this->input->post('name'),
                'created_by' => userId(),
                'created_at' => date('Y-m-d H:i:s')
            );
            if (empty($post['id'])) {
                $insert = $this->CommonModel->iudAction(
                    'tbl_master_indent_clamp_type',
                    $data1,
                    'insert'
                );
                if ($insert) {
                    echo json_encode([
                        'status'  => true,
                        'message' => 'Clamp Type Added Successfully!'
                    ]);
                } else {
                    echo json_encode([
                        'status'  => false,
                        'message' => 'Failed To Add Clamp Type!'
                    ]);
                }
            } else {
                $update = $this->CommonModel->iudAction(
                    'tbl_master_indent_clamp_type',
                    $data1,
                    'update',
                    array('id' => $post['id'])
                );
                if ($update) {

                    echo json_encode([
                        'status'  => true,
                        'message' => 'Clamp Type Updated Successfully!'
                    ]);
                } else {
                    echo json_encode([
                        'status'  => false,
                        'message' => 'Failed To Update Clamp Type!'
                    ]);
                }
            }
        }
    }


    public function delete($id = '')
    {
        //    print_r($id);die;

        $this->CommonModel->iudAction('tbl_master_indent_clamp_type', array('is_deleted' => 1, 'deleted_at' => date('Y-m-d H:i:s'), 'status' => 0, 'deleted_by' => userId()), 'update', array('id' => $id));
        redirect(ADMIN . 'indent/master/Clamp/Clamp_type');
    }


}
