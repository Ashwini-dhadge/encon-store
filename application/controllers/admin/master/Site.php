<?php
/**
 * 
 */
class Site extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'master/SiteModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Site';
       
      $this->load->view(ADMIN.'master/site/list_site',$data);
    }
   public function listsite()
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
          


         $count = count($this->SiteModel->getsiteData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->SiteModel->getsiteData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                 array_push($row, $value['company_name']);
                 array_push($row, $value['site_name']);
                  array_push($row, $value['short_name']);
                 array_push($row, $value['site_inital']);
            	 array_push($row, $value['site_address']);
                 $confirm = "confirm('Are you sure you want to delete this Service?')";

                 $action = '
                 <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="siteModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>';
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


  public function siteModal()
  {
   
    $id = $this->input->post('id');
     $data['sub_title'] = 'Add Site';
    if ($id) {
      $site = $this->SiteModel->getsiteData('',0,0,0,0,$id);
       $data['sub_title'] = 'Edit Site Master';
      $data['site'] = $site[0];
  }
      $data['company_name'] = $this->CommonModel->getData('tbl_company_master'); 
      // print_r($data['company_name']);die; 
    $html = $this->load->view(ADMIN.'master/site/model_site', $data,true);
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

  public function add_site()
  {
    $post = $this->input->post();
    // print_r($post);die;
    if ($post) {

      if (empty($post['id'])) {
       
       if ($this->CommonModel->iudAction('tbl_site',$post,'insert')) {
        //echo $this->db->last_query();die();
          $this->session->set_flashdata('success', 'Site Added Succesfully!');
        }

        else{
          $this->session->set_flashdata('error','Fail To Add Site!');
        }
      }else{
       
        if ($this->CommonModel->iudAction('tbl_site',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','Site Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update Site!');
        }
      } 
      redirect(base_url(ADMIN.'master/Site'));
     } 
       
    }

   public function listCompanyName($value = '') {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $CompanyData = $this->SiteModel->getcompanyName('');
        } else {
            $search = $_GET['searchTerm'];
            $CompanyData = $this->SiteModel->getcompanyName($search);
        }
        foreach ($CompanyData as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['name']];
        }
        echo json_encode($json);
    }


}