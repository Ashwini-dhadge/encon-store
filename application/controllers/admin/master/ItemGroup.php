<?php
/**
 * 
 */
class ItemGroup extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'master/ItemGroupModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Item Group';
       
      $this->load->view(ADMIN.'master/Itemgroup/list_itemgroup',$data);
    }
   public function listitemgroup()
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
       
         $count = count($this->ItemGroupModel->getitemgroupData($searchVal,0,0,0,0,0,$where));
        // print_r($count);die;
         if($count){
             $result = $this->ItemGroupModel->getitemgroupData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
           // echo '<pre>'; print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['item_group_name']);
                 array_push($row, $value['item_type_name']);
                 if($value['parent_group_id']==0){
                 
                  array_push($row,"-"); 
                 }else{
                  array_push($row, $value['item_group_name']);
                 }
                 
                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
                 <a href="'.base_url().'admin/master/ItemGroup/add_itemgroup/'.$value['id'] .'" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>

                   <a onclick="return '.$confirm.'" href="'.base_url() .'admin/master/ItemGroup/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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




    public function add_itemgroup($_id='')
    {
       $data['title'] = 'Add Itemgroup';
       $post = $this->input->post();
        
        if ($post) {
           

          if(! empty($post['parent_group_id'])){
            $post['item_level']=1;
          }
          else{
            $post['item_level']=0;
          }

           // print_r($post);die;
            if (empty($post['id'])) {
                
                if ($this->CommonModel->iudAction('tbl_item_groups',$post,'insert')) {
                   
                    $this->session->set_flashdata('success','Item group Added Succesfully!');                  
                }else{
                   
                    $this->session->set_flashdata('error','Fail To Added Item group....!');
                }
            }else{
                

                if ($this->CommonModel->iudAction('tbl_item_groups',$post,'update', array('id' => $post['id']))) {
                   
                    $this->session->set_flashdata('success','Item group Updated Successfully');        
                }else{
                   
                    $this->session->set_flashdata('error','Fail To Update Item group....!');
                }
        
            }
            redirect(base_url(ADMIN.'master/ItemGroup'));
        }
        if ($_id) {
            $data['sub_title'] = 'Edit user';
             $itemgroup = $this->ItemGroupModel->getitemgroupData('', 0, 0, 0, 0,$_id,0,0,0);
            $data['itemgroup'] = $itemgroup[0];
             // echo '<pre>';print_r($data['itemgroup']);die;
            // $data['roles'] = $this->CommonModel->getData('tbl_roles');
             $data['groupitem'] = $this->CommonModel->getData('tbl_master_item_type',array('id'=> $data['itemgroup']['item_type_id']));
              $data['primary_group'] = $this->CommonModel->getData('tbl_item_groups',array('id'=> $data['itemgroup']['parent_group_id'],'item_level'=>0));
        }
         
       
        $this->load->view(ADMIN.'master/Itemgroup/add_itemgroup',$data); 
    }


  

        public function listItemGroupName($value = '')
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $itemgroupData = $this->ItemGroupModel->getitemgroupName('');
        } else {
            $search = $_GET['searchTerm'];
            $itemgroupData = $this->ItemGroupModel->getitemgroupName($search);
        }
        foreach ($itemgroupData as $key => $value) {
            
            $json[] = ['id' => $value['id'], 'text' => $value['item_type_name']];
        }
        echo json_encode($json);
    }

       public function itemgrouplist($value = '') {
           if (!isset($_GET['searchTerm'])) {
               $json = [];
               $itemgroup = $this->ItemGroupModel->getgroupName('');
           } else {
               $search = $_GET['searchTerm'];
               $itemgroup = $this->ItemGroupModel->getgroupName($search);
           }
           foreach ($itemgroup as $key => $value) {
               $json[] = ['id' => $value['id'], 'text' => $value['item_group_name']];
           }
           echo json_encode($json);
       }

  public function delete($id)
    {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_item_groups',array('is_deleted'=>isLogin()),'update',array('id'=>$id))){
               
                $this->session->set_flashdata('success','ItemGroup Data Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete ItemGroup Data');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'master/ItemGroup'));
    }

}