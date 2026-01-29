<?php
/**
 * 
 */
class TermCondition extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'master/TermConditionModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'TermCondition Master';
       
      $this->load->view(ADMIN.'master/Termcondition/list_termcondition',$data);
    }
   public function listtermcondition()
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
       
         $count = count($this->TermConditionModel->getTermConditionData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->TermConditionModel->getTermConditionData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
           // print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['title']);
                 array_push($row, $value['particulars']);
                 
                 
                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="termconditionModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                	 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/master/TermCondition/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                
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

     public function termconditionModal()
  {
   
    $id = $this->input->post('id');
     $data['sub_title'] = 'Add Term Condition';
    if ($id) {
      $Termcondition = $this->TermConditionModel->getTermConditionData('',0,0,0,0,$id);
       $data['sub_title'] = 'Edit Termcondition Master';
      $data['Termcondition'] = $Termcondition[0];
  }
      
    $html = $this->load->view(ADMIN.'master/Termcondition/model_termcondition', $data,true);
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


   public function add_termcondition()
  {
    $post = $this->input->post();
    
    if ($post) {
        if(! isset($post['is_default'])){
                $post['is_default']=0;   
          }
        // print_r($post);die;
      if (empty($post['id'])) {
          
       if ($this->CommonModel->iudAction('tbl_master_term_and_condition',$post,'insert')) {
        //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'TermCondition Added Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Add TermCondition!');
        }
      }else{
       
        if ($this->CommonModel->iudAction('tbl_master_term_and_condition',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','TermCondition Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update TermCondition!');
        }
        
      } 
      redirect(base_url(ADMIN.'master/TermCondition'));
     } 
    }


    
      public function delete($id)
    {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_master_term_and_condition',array('is_deleted'=>isLogin()),'update',array('id'=>$id))){
               
                $this->session->set_flashdata('success','TermCondition Data Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete TermCondition Data');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'master/TermCondition'));
    }

   
}