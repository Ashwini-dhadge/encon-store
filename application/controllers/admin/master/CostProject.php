<?php
/**
 * 
 */
class CostProject extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'master/CostProjectModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'CostProject Master';
       
      $this->load->view(ADMIN.'master/cost_project/list_cost_project',$data);
    }
   public function listcostproject()
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
       
         $count = count($this->CostProjectModel->getCostProjectData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->CostProjectModel->getCostProjectData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
           // print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['cost_project_name']);
                 array_push($row, $value['description']);
                 
                 
                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="costprojectModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                	 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/master/CostProject/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                
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

     public function costprojectModal()
  {
   
    $id = $this->input->post('id');
     $data['sub_title'] = 'Add Cost Project';
    if ($id) {
      $costProject = $this->CostProjectModel->getCostProjectData('',0,0,0,0,$id);
       $data['sub_title'] = 'Edit costProject Master';
      $data['costProject'] = $costProject[0];
  }
      
    $html = $this->load->view(ADMIN.'master/cost_project/model_cost_project', $data,true);
    if ($html) {
      $response['html'] = $html;
      $response['result'] = true;
      $response['reason'] = 'Data Found';
    }else{
      $response['result'] = fasle;
      $response['reason'] = 'Something went to wrong!';
    }
    echo json_encode($response);
  }


  public function add_cost_project()
  {
    $post = $this->input->post();
    
    if ($post) {
        // print_r($post);die;
      if (empty($post['id'])) {
            $post['created_by'] = userId();
            $post['created_at'] = date('Y-m-d H:i:s');
       if ($this->CommonModel->iudAction('tbl_cost_project',$post,'insert')) {
        //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Cost Project Added Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Add Cost Project!');
        }
      }else{
                $post['updated_by'] = userId();
                $post['updated_at'] = date('Y-m-d H:i:s');
        if ($this->CommonModel->iudAction('tbl_cost_project',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','Cost Project Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update Cost Project!');
        }
        
      } 
      redirect(base_url(ADMIN.'master/CostProject'));
     } 
    }




  public function delete($id)
    {
       $po_cost_project_data = $this->CommonModel->getData('tbl_po',array('cost_project_id'=>$id),'','','row_array');
        if ($id) {
        
          if (!empty($po_cost_project_data)){
                
                $this->session->set_flashdata('error','This Cost Project is already Used By Po Module');
                  
              }else{
                
                  $this->CommonModel->iudAction('tbl_cost_project',array('deleted_by'=>userId(),'deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>userId(),'updated_at'=>date('Y-m-d H:i:s')),'update',array('id'=>$id));
                  $this->session->set_flashdata('success','Cost Project Data Deleted Successfully');
              }
          }else{
              $this->session->set_flashdata('error',INVAILD_INPUT);
          }
        redirect(base_url(ADMIN.'master/CostProject'));
    }


    public function listCostProjectName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $costproject_name = $this->CostProjectModel->getcostprojectName('');
        } else {
            $search = $_GET['searchTerm'];
            $costproject_name = $this->CostProjectModel->getcostprojectName($search);
        }
        foreach ($costproject_name as $key => $value) {
            
            $json[] = ['id' => $value['id'], 'text' => $value['cost_project_name']];
        }
        echo json_encode($json);
    }
    
     

   
}