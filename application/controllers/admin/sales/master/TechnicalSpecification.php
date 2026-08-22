<?php
/**
 * 
 */
class TechnicalSpecification extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN.'sales/master/TechnicalSpecificationModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Technical Specification';
       
      $this->load->view(ADMIN.'sales/master/technical_specification/list_technical_specification',$data);
    }
   
    
      public function TechnicalSpecificationModal()
     {
   
         $id = $this->input->post('id');
         $data['sub_title'] = 'Add Technical Specification';
         if ($id) {
         $Technical_s = $this->TechnicalSpecificationModel->getTechnicalSpecificationData('',0,0,0,0,$id);
         $data['sub_title'] = 'Edit Technical Specification';
         $data['Technical_s'] = $Technical_s[0];
          }
        
         $html = $this->load->view(ADMIN.'sales/master/technical_specification/model_technical_specification', $data,true);
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

   
     public function listtechnical_specification()
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
          // print_r($data);die;
        $count = count($this->TechnicalSpecificationModel->getTechnicalSpecificationData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->TechnicalSpecificationModel->getTechnicalSpecificationData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['title']);
                 array_push($row, $value['default_values']);
                  
                 // array_push($row, $value['status']);
                 
                 $confirm = "confirm('Are you sure you want to delete this Plant?')";

                   $action = '
                 <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="TechnicalSpecificationModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/sales/master/TechnicalSpecification/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
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
    
 
   public function add_technical_specification()
    {
        $post = $this->input->post();
        if ($post) {
        if (empty($post['id'])) {
        $post['created_by'] = userId();
        $post['created_at'] = date('Y-m-d H:i:s');
        if ($this->CommonModel->iudAction('tbl_master_technical_specification',$post,'insert')) {
       
          $this->session->set_flashdata('success', 'Technical Specification Added Succesfully!');
        }

        else{
          $this->session->set_flashdata('error','Fail To Add Technical Specification!');
        }
        }else{
            $post['updated_by'] = userId();
            $post['updated_at'] = date('Y-m-d H:i:s');
        if ($this->CommonModel->iudAction('tbl_master_technical_specification',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','Technical Specification Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update Technical Specification!');
        }
      } 
      redirect(base_url(ADMIN.'sales/master/TechnicalSpecification'));
     } 
       
    }
 
 public function delete($id)
   {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_master_technical_specification',array('deleted_by'=>userId(),'deleted_at'=> date('Y-m-d H:i:s')),'update',array('id'=>$id))){

                $this->session->set_flashdata('success','Technical Specification Data Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete Technical Specification');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'sales/master/TechnicalSpecification'));
    }

   
 // public function changeis_active()
 //    {
 //        $get = $this->input->get();
        
 //        if($this->CommonModel->iudAction('tbl_master_plant_name',$get,'update',array('id' => $get['id']))){
 //            $response['result'] = TRUE;
 //            $response['status'] = 'status Updated Successfully';

 //        }else{
            
 //            $response['result'] = FALSE;
 //            $response['status'] = 'status Not Update!';
 //        }
 //        echo json_encode($response);
 //    } 

   


}