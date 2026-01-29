<?php
/**
 * 
 */
class EmailTemplate extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
          $this->load->model(ADMIN.'master/EmailTemplateModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'EmailTemplate Master';
       
      $this->load->view(ADMIN.'master/emailtemplate/list_emailtemplate',$data);
    }
   public function listemailtemplate()
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
       
         $count = count($this->EmailTemplateModel->getEmailTemplateData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->EmailTemplateModel->getEmailTemplateData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
           // print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                
                 array_push($row, $value['message']);
                 
                 
                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
              

                
                 <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="emailtemplateModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                	 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/master/EmailTemplate/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                
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

     public function emailtemplateModal()
  {
   
    $id = $this->input->post('id');
     $data['sub_title'] = 'Add Email template';
    if ($id) {
      $emailtemplate = $this->EmailTemplateModel->getEmailTemplateData('',0,0,0,0,$id);
       $data['sub_title'] = 'Edit emailtemplate Master';
      $data['emailtemplate'] = $emailtemplate[0];

  }
     
    $html = $this->load->view(ADMIN.'master/emailtemplate/model_emailtemplate', $data,true);
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


   public function add_emailtemplate()
  {
    $post = $this->input->post();
    
    if ($post) {
         // print_r($post);die;
      if (empty($post['id'])) {
       if ($this->CommonModel->iudAction('tbl_master_email_template',$post,'insert')) {
        //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Email Template Added Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Add Email Template!');
        }
      }else{
       
        if ($this->CommonModel->iudAction('tbl_master_email_template',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','Email Template Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update Email Template!');
        }
        
      } 
      redirect(base_url(ADMIN.'master/EmailTemplate'));
     } 
    }
    
      public function delete($id)
    {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_master_email_template',array('is_deleted'=>isLogin()),'update',array('id'=>$id))){
               
                $this->session->set_flashdata('success','Email Template Data Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete Email Template');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'master/EmailTemplate'));
    }

   
}