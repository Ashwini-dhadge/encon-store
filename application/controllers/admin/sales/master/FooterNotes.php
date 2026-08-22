<?php
/**
 * 
 */
class FooterNotes extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN.'sales/master/FooterNotesModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Footer Notes';
       
      $this->load->view(ADMIN.'sales/master/footer_notes/list_footer_notes',$data);
    }
   
    
      public function FooterNotesModal()
      {
   
         $id = $this->input->post('id');
         $data['sub_title'] = 'Add Footer Notes';
         if ($id) {
         $Footernotes = $this->FooterNotesModel->getFooterNotesData('',0,0,0,0,$id);
         $data['sub_title'] = 'Edit Footer Notes';
         $data['Footernotes'] = $Footernotes[0];
          }
        
         $html = $this->load->view(ADMIN.'sales/master/footer_notes/model_footer_notes', $data,true);
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

     public function listfooter_notes()
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
        $count = count($this->FooterNotesModel->getFooterNotesData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->FooterNotesModel->getFooterNotesData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['title']);
                 array_push($row, $value['description']);
                  
                 // array_push($row, $value['status']);
                 
                 $confirm = "confirm('Are you sure you want to delete this Footer Notes?')";

                   $action = '
                 <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="FooterNotesModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/sales/master/FooterNotes/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
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
    
 
   public function add_FooterNotes()
    {
        $post = $this->input->post();
        if ($post) {
        if (empty($post['id'])) {
        $post['created_by'] = userId();
        $post['created_at'] = date('Y-m-d H:i:s');
        if ($this->CommonModel->iudAction('tbl_master_footer_notes',$post,'insert')) {
       
          $this->session->set_flashdata('success', 'Footer Notes Added Succesfully!');
        }

        else{
          $this->session->set_flashdata('error','Fail To Add Footer Notes!');
        }
        }else{
            $post['updated_by'] = userId();
            $post['updated_at'] = date('Y-m-d H:i:s');
        if ($this->CommonModel->iudAction('tbl_master_footer_notes',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','Footer Notes Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update Footer Notes!');
        }
      } 
      redirect(base_url(ADMIN.'sales/master/FooterNotes'));
     } 
       
    }
 
 public function delete($id)
   {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_master_footer_notes',array('deleted_by'=>userId(),'deleted_at'=> date('Y-m-d H:i:s')),'update',array('id'=>$id))){

                $this->session->set_flashdata('success','Technical Specification Data Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete Technical Specification');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'sales/master/FooterNotes'));
    }


}