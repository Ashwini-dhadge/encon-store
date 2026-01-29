<?php
/**
 * 
 */
class Auth extends CI_Controller
{   
    function __construct()
    {
        parent::__construct();
        // isLogin();
    }


    public function index($is_display_message='')
    {
        
        if ($post_data = $this->input->post()) {
            // $role_id=$post_data['role_id'];
            $email=$post_data['email'];
            $password=$post_data['password'];
            $post_data['deleted_by']=NULL;
            $data = $this->CommonModel->getData('users',$post_data);

            if ($data) {
                $data_jwt = array(
                    'reg_type' => $data[0]['role_id'],
                    'reg_id' => $data[0]['id'],
                    'reg_email' =>  $data[0]['email'],
                    'reg_name' => $data[0]['first_name'] . " " . ucwords($data[0]['last_name']),
                    'key' => create6NumRandom()
                );
                $api_token = JWTEncode($data_jwt);
                $this->CommonModel->iudAction('users', array('api_token'=>$api_token),'update', array('id' => $data[0]['id']));
                $branch_data=array();
                $role_data = $this->CommonModel->getData('tbl_roles', array('id' => $data[0]['role_id']),'role_name','','row_array');     

                $getDataSite = $this->CommonModel->getData('tbl_site', array('is_active'=>1,'id'=>$data[0]['site_id']),'company_id,id,site_name,site_inital,short_name','','row_array');
                $getCompanyDataSite = $this->CommonModel->getData('tbl_company_master', array('id'=>$data[0]['company_id']),'name as company_name','','row_array');
                $getFinancialYear = $this->CommonModel->getData('tbl_master_financial_year', array('id'=>$data[0]['financial_year_id']),'from_date,to_date','','row_array');

                $financial_year= date('d/m/Y',strtotime($getFinancialYear['from_date']))."-".date('d/m/Y',strtotime($getFinancialYear['to_date']));
                $session = array(
                        'project_name'=>'ENCON',
                        'user_id' => $data[0]['id'],
                        'name' => $data[0]['first_name'].' '.$data[0]['last_name'],
                        'image' => $data[0]['image'], 
                        'email' => $data[0]['email'],
                        'role_id' => $data[0]['role_id'],
                        'parent_staffid'=> $data[0]['parent_staffid'],
                        'parent_staff_role'=> $data[0]['parent_staff_role'],
                        'api_token'=>$api_token,                        
                        'role'=>$role_data['role_name'],
                        'financial_year_id'=> $data[0]['financial_year_id'],
                        'company_id'=> $data[0]['company_id'],
                        'site_id'=> $data[0]['site_id'], 
                        'company_site_name'=>$getCompanyDataSite['company_name']."-".$getDataSite['short_name'],
                        'company_financial_year' =>$financial_year,    
                        'site_inital'=>$getDataSite['site_inital']
                    );
                
                  



                $this->session->set_userdata($session);
                $login_time = array('user_id' => $data[0]['id'], 'login_time' =>date('Y-m-d H:i:s') );  
                
             
               
                $browser_array = str_replace( array( '\'', '"',',' , ';', '<', '>' ), ' ', $_SERVER['HTTP_USER_AGENT']);
                $data_login=array($data[0]['id'],$data[0]['role_id'],'admin','login',$_SERVER['REMOTE_ADDR'],$browser_array,date('Y-m-d H:i:s'));
                updateInLoginFile($data_login);    
               
                //ref_type: 2:role 3:User 4:Branch 5:Franchise 6:Hub 7:Shipment 8:	DRS Shipment 9:Customer 10:pincode 11:Manifest 12:Received Manifest 13:Vendor
                $description=" logged - ".userId('name')." as ".$role_data['role_name']." in ".userId('branch_name');
                $json_data_login=encode_arr($post_data);
                $data_action_log_array=array($data[0]['id'],$data[0]['role_id'],'admin','login',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                updateInActionLogFile($data_action_log_array);
            //    $this->session->set_flashdata('success','Login Successfully');

                $this->session->set_userdata('is_login','1');
                $msg="Hello <h5>". $data[0]['first_name'].' '.$data[0]['last_name']."</h5><br>Company Name:".$getCompanyDataSite['company_name']."<br>Site Name:".$getDataSite['site_name']."<br>[Financial Year:".$financial_year."]";
                $this->session->set_userdata('login_msg',$msg);
               // print_r($_SESSION);
                //die;
                
                redirect(base_url('dashboard'));  
            }else{
                $this->session->set_flashdata('error','Invaild Username Or Password');
                redirect(base_url('admin'));
            }
        }elseif($is_display_message==1){
             $this->session->sess_destroy();
             $data['display_message']='Login Anthoer Device';
              //redirect(base_url('admin'));
           //  print_r($data);die;
          	$this->load->view(ADMIN.AUTH.'login',$data);
        }else{
             $api_token = userId('api_token');
            //  die;
            if (userId('user_id') && userId('project_name')=='ENCON') { 
                $user_data = $this->CommonModel->getData('users', array('id' => userId()),'api_token','','row_array');
                //print_r($user_data);
                if($user_data['api_token']==$api_token){
  	                     redirect(base_url('dashboard'));
          	      }else{
          	           $data=array();
                           $this->session->sess_destroy();
                        $this->load->view(ADMIN.'auth/login', $data);
          	      }
            }else
            {
                $data=array();
               
                $this->load->view(ADMIN.'auth/login', $data);
              
            }
        }
    }

    public function Profile(){
        $profile= $this->CommonModel->getData('users',array('id'=>isLogin()));
        $data['profile']=$profile[0];
        // print_r($data['profile']);die;
        $this->load->view(ADMIN.AUTH.'view_profile',$data);

    }

 public function add($_id='')
    {
  
        $post = $this->input->post();
    
        if ($post) {
               
              // print_r($_FILES);die;
                 if ($_FILES) {
                $result = fileUpload(USER_PROFILE,'image');
                if ($result['status'] == true) {
                    $post['image'] = $result['image_name']; 
                }else{
                    unset($post['image']);
                }
            }else{
                unset($post['image']);
            }
          
            if (!$post['id']) {                  

                        if ($this->CommonModel->iudAction('users',$post,'insert')) {
                            $this->session->set_flashdata('success','Image Updated Successfully'); 
                           
                            $description=userId('name')." Change Profile Image  in ".userId('branch_name');
                             $json_data_login=encode_arr($post);
                            $data_action_log_array=array( userId(),userId('role_id'),userId('branch_id'),'update',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                            updateInActionLogFile($data_action_log_array);
                        }else{
                            $this->session->set_flashdata('error','Fail To Update');
                        }
                
            }else{
  
                $this->CommonModel->iudAction('users', $post,'update', array('id' => $post['id']));
            
                $this->session->set_flashdata('success','Image Updated Successfully');
            }
            redirect(base_url(ADMIN.'Auth/Profile'));
        }  
      
        $this->load->view(ADMIN.'auth/view_profile',$data);
    }
 
 public function update_data($_id='')
    {
      $post = $this->input->post();
       // print_r($post);die;

        if ($post) {
                    
            if (!$post['id']) {                  

                        if ($this->CommonModel->iudAction('users',$post,'insert')) { 
                         $this->session->set_flashdata('error','Updated Successfully');   
                        
                        
                        $description=userId('name')." update profile in ".userId('branch_name');
                         $json_data_login=encode_arr($post);
                        
                        $data_action_log_array=array( userId(),userId('role_id'),userId('branch_id'),'update',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                        updateInActionLogFile($data_action_log_array);
                         
                        }else{
                            $this->session->set_flashdata('error','Fail To Update');
                        }
              
            }else{
  
                $this->CommonModel->iudAction('users', $post,'update', array('id' => $post['id']));
                
                $description=userId('name')." update profile in ".userId('branch_name');
                $json_data_login=encode_arr($post);
                $data_action_log_array=array( userId(),userId('role_id'),userId('branch_id'),'update',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                updateInActionLogFile($data_action_log_array);
              
                $this->session->set_flashdata('success','Updated Successfully');
            }
            redirect(base_url(ADMIN.'Auth/Profile'));
        }  
       
        $this->load->view(ADMIN.'auth/view_profile',$data);
    }


 public function changePassword()
     {
        
        $post = $this->input->post();
        if ($post) {
            $where = array('id' => $post['id'], 'password' => $post['old_password']);
            $data = array('password' => $post['password']);
            $this->CommonModel->iudAction('users', $data,'update', $where);
            if($this->db->affected_rows() > 0){
                $response = array(
                    'result' => true,
                    'reason' => 'Users Password Change Successfully',
                );
                
                    $description=userId('name')." Change Password in ".userId('branch_name');
                    $json_data_login=encode_arr($post);
                    $data_action_log_array=array( userId(),userId('role_id'),userId('branch_id'),'update',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                    updateInActionLogFile($data_action_log_array);
                        
                        
            }else{
                $response = array(
                    'result' => false,
                    'reason' => 'Old Password are Wrong',
                );
            }
        }else{
            $response = array(
                'result' => false,
                'reason' => INVAILD_INPUT
            );
        }
        echo json_encode($response);

    
}



    public function logout()
    {
        if(!empty($this->session->userdata('user_id'))){
                    if( userId('role_id')==HUB_ROLE || userId('role_id')==FRANCHISE_ROLE || userId('role_id')==BRANCH_ROLE || userId('role_id')==SUPERADMIN_ROLE){
                                $branch_id=userId();
                    }elseif(userId('role_id') == ADMIN_ROLE || userId('role_id') == SALES_EMPLOYEE || userId('role_id') == ACCOUNT_EMPLOYEE || userId('role_id') == CUSTOMER_SUPPORT || userId('role_id') == OPERATIONAL_EMPLOYEE || userId('role_id') == DELIVERY_BOY){
                        $branch_id=userId('parent_staffid'); 
                    }
                   
                    $browser_array = str_replace( array( '\'', '"',',' , ';', '<', '>' ), ' ', $_SERVER['HTTP_USER_AGENT']);
                      
                    $data_login=array(userId(),userId('role_id'),$branch_id,'logout',$_SERVER['REMOTE_ADDR'],$browser_array,date('Y-m-d H:i:s'));
                    updateInLoginFile($data_login);    
                    
                    
                    $description=userId('name')." Logout  From".userId('branch_name');
                    $json_data_login='';
                    $data_action_log_array=array( userId(),userId('role_id'),userId('branch_id'),'logout',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
                    updateInActionLogFile($data_action_log_array);
                  
        }
        
          $this->session->sess_destroy();
        
        return redirect(base_url('admin'));
    }
     public function autologout()
    {
        if( userId('role_id')==HUB_ROLE || userId('role_id')==FRANCHISE_ROLE || userId('role_id')==BRANCH_ROLE || userId('role_id')==SUPERADMIN_ROLE){
                    $branch_id=userId();
        }elseif(userId('role_id') == ADMIN_ROLE || userId('role_id') == SALES_EMPLOYEE || userId('role_id') == ACCOUNT_EMPLOYEE || userId('role_id') == CUSTOMER_SUPPORT || userId('role_id') == OPERATIONAL_EMPLOYEE || userId('role_id') == DELIVERY_BOY){
            $branch_id=userId('parent_staffid'); 
        }
       
        $browser_array = str_replace( array( '\'', '"',',' , ';', '<', '>' ), ' ', $_SERVER['HTTP_USER_AGENT']);        
        
        $data_login=array(userId(),userId('role_id'),$branch_id,'logout',$_SERVER['REMOTE_ADDR'],$browser_array,date('Y-m-d H:i:s'));
        updateInLoginFile($data_login);    
        $this->session->sess_destroy();
        
        $description=userId('name')." Logout  From".userId('branch_name');
        $json_data_login='';
        $data_action_log_array=array( userId(),userId('role_id'),userId('branch_id'),'logout',$description,'0',3, userId(),'0','0',date('Y-m-d H:i:s'),$json_data_login);;
        updateInActionLogFile($data_action_log_array);
       
         echo "true";
       
    }

}