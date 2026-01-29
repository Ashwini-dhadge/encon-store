<?php

class Thickness extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model( ADMIN.'indent/master/HubModel');
        isLogin();
    }
    public function index()
    {
       $data['title'] = "Thickness Section";
        $this->load->view(ADMIN . 'master/indent/Thickness/list_thickness',$data);
    }


    public function listThickness()
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

        $where['ht.is_deleted'] = 0;
        $count = count($this->HubModel->getThicknessData($searchVal, 0, 0, 0, 0, 0, $where));
        
        if ($count) {
            $result = $this->HubModel->getThicknessData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
            
            foreach ($result as $key => $value) {

                $row = [];

                array_push($row, $offset + ($key + 1));

                array_push($row, $value['name']);
                
                $confirm = "confirm('Are you sure you want to delete this Service?')";

                $action = '
    <div style="display: flex; justify-content: center;">
        <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; margin-right: 10px;" onclick="materialModal(' . $value['id'] . ')" data-id="' . $value['id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>

        <a onclick="return '.$confirm.'" href="'.base_url() .'admin/indent/master/Hub/Thickness/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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


    public function thicknessModal()
    {

        $id = $this->input->post('id');
        $data['sub_title'] = 'Add Dimension';
        if ($id) {
            $thickness = $this->HubModel->getThicknessData('', 0, 0, 0, 0, $id);
            // $data['sub_title'] = 'Edit Dimension Master';
            $data['thickness'] = $thickness[0];
        }
        //   $data['company_name'] = $this->CommonModel->getData('tbl_company_master'); 
        // print_r($data['company_name']);die; 
        $html = $this->load->view(ADMIN . 'master/indent/Thickness/model_thickness', $data, true);
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

    public function addMaster($id = '') {
        $post = $this->input->post();
       
       
        if ($post) {
            $data1 = array(
                'name'=>$this->input->post('name'),
                'created_by' => userId(),
            );
            if (empty($post['id'])) {
                
                if ($this->CommonModel->iudAction('tbl_master_indent_hub_thickness', $data1, 'insert')) {
                    $this->session->set_flashdata('success', 'Thickness Added Successfully!');
                    redirect(ADMIN . 'indent/master/Hub/Thickness');
                } else {
                    $this->session->set_flashdata('error', 'Failed to Add Thickness!');
                }
            } else {
               
                if ($this->CommonModel->iudAction('tbl_master_indent_hub_thickness', $post, 'update',array('id'=>$post['id']))) {
                    $this->session->set_flashdata('success', 'Thickness Updated Successfully!');
                    redirect(ADMIN . 'indent/master/Hub/Thickness');
                } else {
                    $this->session->set_flashdata('error', 'Failed to Update Thickness!');
                }
            }
        }
        
      
        if (!empty($id)) {
            $data['thickness'] = $this->CommonModel->getData('tbl_master_indent_hub_thickness', array('id' => $id), '', '', 'row_array');
            $this->load->view('admin/master/indent/Thickness/thickness_master', $data);
        } else {
            $this->load->view('admin/master/indent/Thickness/thickness_master');
        }
        
 
       
    }

    public function delete($id ='') {
    //    print_r($id);die;
        $is_deleted = 1;
        $this->CommonModel->iudAction('tbl_master_indent_hub_thickness',array('is_deleted'=>userId(),'deleted_at' =>date('Y-m-d H:i:s')),'update',array('id'=>$id));
        redirect(ADMIN . 'indent/master/Hub/Thickness');
    }



    /*------------------------------------------------------- For Select2 call   -------------------------------------- */


  public function list_Thickness()
  {

    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $hardware = $this->HubModel->getThickness('');
    } else {

      $search = $_GET['searchTerm'];

      $hardware = $this->HubModel->getThickness($search);
    }
    
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($hardware as $key => $value) {

      $json[] = ['id' => $value['name'], 'text' => $value['name']];
    }
    echo json_encode($json);
  }
    
    
    
}
