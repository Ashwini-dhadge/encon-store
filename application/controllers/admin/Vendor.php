<?php
/**
 * 
 */
class Vendor extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'VendorModel');
         $this->load->model(ADMIN.'CommonCustModel');
         isLogin();
    }

    public function index()
    {
     $data['title'] = 'Vendor List';
     $data['active'] = 'Vendor';
     $this->load->view(ADMIN.'vendor/list_vendor',$data);
    }

     public function listVendor()
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
        // if($data['comp_id']){
        //     $where['company_id'] = $data['comp_id'];
        // }

        if($data['id_city']){
            $where['vmd.city_id'] = $data['id_city'];
        }
        
        $pan_nm = $data['pan_nm'];
        $tin_nm = $data['tin_nm'];

        $count = count($this->VendorModel->getVendorData($searchVal,0,0,0,0,0,$where,$pan_nm,$tin_nm));
        // echo $this->db->last_query();die;

        if($count){
            $result = $this->VendorModel->getVendorData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$pan_nm,$tin_nm);
    
                foreach ($result as $key => $value) {
            
                    $row = []; 
                     array_push($row, $offset + ($key + 1));
                    array_push($row, $value['vendor_code']);
                    array_push($row, $value['account_name']);
                    array_push($row, $value['contact_person_email']);
                    array_push($row, $value['contact_person_mobile_no']);
                    array_push($row, '<span class="text_wrap">'.$value['address_details'].'</span>');
                    array_push($row, $value['city_name']);
                    array_push($row, $value['pan_no']);
                    array_push($row, $value['gst_no']);
                    array_push($row, $value['tan_no']);
                    array_push($row, $value['tin_no']);

                    
                    $confirm = "confirm('Are you sure you want to delete this Vendor?')";


                    // $action = '<a href="'.base_url().'admin/PO/viewPoDetailsData/2" title="view purchase order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>
                      
                     $action=' <a href="'.base_url().'admin/Vendor/viewVendor/'.$value['vendor_id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                      <a href="' . base_url() . 'admin/Vendor/submit_vendor_data/'.$value['vendor_id'] . '" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>

                      <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/Vendor/delete/' . $value['vendor_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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
    

    public function viewPurchaseOrder($vendor_id='')
    {
        $this->load->view(ADMIN.'vendor/view_purchase_order');
    }


    public function viewVendor($vendor_id='')
    {
        $vendorData = $this->VendorModel->getViewVendorData($vendor_id);
        $data =  $vendorData[0];

        $data['email_dt'] = $this->CommonModel->getData('tbl_vendor_master_email',array('vendor_id'=>$vendor_id),'(email_id) as email');
        $data['attachment_file'] = $this->CommonModel->getData('tbl_vendor_master_attachment',array('vendor_id'=>$vendor_id));
// echo "<pre>"; print_r($data);die;
        $this->load->view(ADMIN.'vendor/view_vendor',$data);
    }



    public function add_vendor($_id='')
    {
        // $this->load->view(ADMIN.'vendor/add_vendor');
        $this->load->view(ADMIN.'vendor/add_vendor');
    }

    public function submit_vendor_data($_id='')
    {
        $data['title'] = 'Add Vendor';
        $data['active'] = 'Vendor';
        $post = $this->input->post();
        $vendor_attachement=array();
        if ($post) {
            
                $vendor= array(
                        'account_name' =>isset($post['account_name'])?$post['account_name']:'',
                        'cheque_print_ac_name' =>isset($post['cheque_print_ac_name'])?$post['cheque_print_ac_name']:'' ,
                        'code' =>isset($post['code'])?$post['code']:'' ,
                        'opening_balance' =>isset($post['opening_balance'])?$post['opening_balance']:'',
                        'account_group' =>isset($post['account_group'])?$post['account_group']:'',
                        'account_nature' => isset($post['account_nature'])?$post['account_nature']:'',
                        'vendor_limit' => isset($post['vendor_limit'])?$post['vendor_limit']:'',
                        'company_id' => isset($post['company_id'])?$post['company_id']:'',
                        'site_id' => isset($post['site_id'])?$post['site_id']:'',
                    );


                $vendor_details= array(
                        'address_details' => isset($post['address_details'])?$post['address_details']:'',
                        'city_id' => isset($post['city_id'])?$post['city_id']:'',
                        'pincode' =>isset($post['pincode'])?$post['pincode']:'',
                        'phone_no_1' =>isset($post['phone_no_1'])?$post['phone_no_1']:'',
                        'phone_no_2' => isset($post['phone_no_2'])?$post['phone_no_2']:'',
                        'fax_no_1' => isset($post['fax_no_1'] )?$post['fax_no_1'] :'',
                        'fax_no_2' => isset($post['fax_no_2'])?$post['fax_no_2']:'',
                        'contact_person_name' =>isset($post['contact_person_name'])?$post['contact_person_name']:'',
                        'contact_person_mobile_no' => isset($post['contact_person_mobile_no'])?$post['contact_person_mobile_no']:'',
                        'contact_person_email' =>isset($post['contact_person_email'])?$post['contact_person_email']:'' ,
                        'remark' => isset($post['remark'])?$post['remark']:'',

                        'bank_ac_no_1' => isset($post['bank_ac_no_1'])?$post['bank_ac_no_1']:'' ,
                        'ifsc_code_1' => isset($post['bank_ac_no_1'])?$post['bank_ac_no_1']:'',
                        'bank_ac_no_2' => isset($post['bank_ac_no_2'])?$post['bank_ac_no_2']:'',
                        'ifsc_code_2' => isset($post['ifsc_code_2'])?$post['ifsc_code_2']:'',
                        'bank_ac_no_3' => isset($post['bank_ac_no_3'])?$post['bank_ac_no_3']:'' ,
                        'ifsc_code_3' => isset($post['ifsc_code_3'])?$post['ifsc_code_3']:'' ,
                        'bank_name_1' => isset($post['bank_name_1'])?$post['bank_name_1']:'',
                        'branch_name_1' => isset($post['branch_name_1'])?$post['branch_name_1']:'',
                        'bank_name_2' => isset($post['bank_name_2'])?$post['bank_name_2']:'',
                        'branch_name_2' => isset($post['branch_name_2'])?$post['branch_name_2']:'',
                        'bank_name_3' => isset($post['bank_name_3'])?$post['bank_name_3']:'',
                        'branch_name_3' => isset($post['branch_name_3'])?$post['branch_name_3']:'',
                        'credit_limit' => isset($post['credit_limit'])?$post['credit_limit']:'',
                        'credit_days' => isset($post['credit_days'])?$post['credit_days']:'',

                         'name_dept' =>isset($post['name_dept'])?$post['name_dept']:'', 
                         'gst_no' => isset($post['gst_no'])?$post['gst_no']:'',
                         'tin_no' => isset($post['tin_no'])?$post['tin_no']:'',
                         'pan_no' => isset($post['pan_no'])?$post['pan_no']:'',
                         'tan_no' => isset($post['tan_no'])?$post['tan_no']:'', 
                         'cst_no' => isset($post['cst_no'])?$post['cst_no']:'',

                         'st_no' => isset($post['st_no'])?$post['st_no']:'',
                         'ecc_no' => isset($post['ecc_no'])?$post['ecc_no']:'',
                         'lbt_no' => isset($post['lbt_no'])?$post['lbt_no']:'',
                         'maintain_balance' => isset($post['maintain_balance'])?$post['maintain_balance']:'',
                         // 'file_name' => $post['file_name'],
                    );


                $vendor_attachement=array();
                if(! empty($_FILES['file_name']['name'])){
                    $uploadStatus = myUpload(VENDOR_IMAGE,'file_name',true);
                    if(isset( $uploadStatus['data']) && !empty( $uploadStatus['data'])){
                          $vendor_attachement = $uploadStatus['data'];
                    }
                  
                }


         if(empty($post['id'])) {
            $vendor['created_by'] = userId();
            $vendor['created_at'] = date('Y-m-d H:i:s');

                $insert_id = $this->CommonModel->iudAction('tbl_vendor_master',$vendor,'insert');

                if($insert_id){
                    $vendor_details['vendor_id']=$insert_id;

                    $this->CommonModel->iudAction('tbl_vendor_master_details',$vendor_details,'insert');
                     foreach($post['email'] as $key1=>$value1)
                        {

                         $insert_email[]= 
                                    array(
                                       
                                          'vendor_id' => $insert_id,
                                          'email_id' => $value1['email'],
                                          'created_by' => userId(),
                                    );
                               }
                            $this->CommonModel->iudAction('tbl_vendor_master_email', $insert_email,'batch_insert');
                    if(!empty($vendor_attachement)){
                        foreach($vendor_attachement as $key=>$value)
                        { 
                            $vendor_attachement = array(
                                 'vendor_id'=> $insert_id, 
                                 'file_name' => $value['file_name']
                                );
                        $this->CommonModel->iudAction('tbl_vendor_master_attachment',$vendor_attachement,'insert');
                        }
                    }
                      

                  //  echo $this->db->last_query();die;
                    $this->session->set_flashdata('success','Vendor Data Added Successfully');
                }else{
                    $this->session->set_flashdata('error','Vendor Data Not Added !');
                }
                

                // Array ( [project_name] => ENCON [user_id] => 1 [name] => super1 admin1 [image] => [email] => superadmin@gmail.com [role_id] => 1 [parent_staffid] => 0 [parent_staff_role] => 0  [role] => Super Admin [financial_year_id] => 1 [company_id] => 2 [site_id] => 40 [company_site_name] => ENCON (INDIA)-PLOT NO.B-127 (EI (P)) [company_financial_year] => 31/03/2023-01/04/2023 [is_login] => 0 [login_msg] => Hello

                // $description="Add to new vendor - ".userId('name')." as ".userId('role')." at ".$getCompanyDataSite['company_name']."-".$getDataSite['site_name'];
                // $json_data_login=encode_arr($post);
                // //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

                // $data_action_log_array=array(userId(),userId('role_id'),$post['common_financial_year'],$getDataSite['company_id'],$post['common_company_site_data'],'change',$description,'','','','','',date('Y-m-d H:i:s'),$json_data_login);;
                // updateInActionLogFile($data_action_log_array);
           


            }else{
    
                $vendor['updated_by'] = userId();
                $vendor['updated_at'] = date('Y-m-d H:i:s');
             // echo "<pre>";  print_r($post);die;
                $this->CommonModel->iudAction('tbl_vendor_master',$vendor,'update',array('id' => $post['id']));
                $this->CommonModel->iudAction('tbl_vendor_master_details',$vendor_details,'update',array('vendor_id' => $post['id']));
                
                foreach($post['email'] as $key4=>$val4)
                   { 
                    if(isset($val4['id_email'])){
                            $chk = $this->CommonModel->getData('tbl_vendor_master_email',array('id'=>$val4['id_email']),'','','row_array'); 

                            if($chk){
                                $update_email = array(
                                    'id' => $val4['id_email'],
                                    'vendor_id' => $post['id'],
                                    'email_id' => $val4['email'],
                                    'updated_by' => userId(),
                                    'updated_at' => date('Y-m-d'),
                                );
                            
                             $this->CommonModel->iudAction('tbl_vendor_master_email',$update_email,'update',array('id'=>$val4['id_email']));
        
                             $this->CommonModel->iudAction('tbl_vendor_master_email','','delete',array('id !='=>$val4['id_email']));
                    }
                    
                  
                    }else{
                        $update_email_1 = array(
                            'vendor_id' => $post['id'],
                            'email_id' => $val4['email'],
                            'updated_by' => userId(),
                            'updated_at' => date('Y-m-d'),
                        );
                    
                       $this->CommonModel->iudAction('tbl_vendor_master_email',$update_email_1,'insert');
                    }
                }

               if(isset($post['file_name_id']) && !empty($post['file_name_id'])){
                    foreach ($post['file_name_id'] as $key4 => $val4) {
                                
                        $chk = $this->CommonModel->getData('tbl_vendor_master_attachment',array('id'=>$val4),'','','row_array'); 
    
                        if($chk){
                            $update_attch_data = array(
                                    'vendor_id'=> $post['id'], 
                                    'file_name' => $chk['file_name'],
                                    'updated_by' => userId(),
                                    'updated_at' => date('Y-m-d'),
                            );
                            $this->CommonModel->iudAction('tbl_vendor_master_attachment',$update_attch_data,'update',array('id'=>$val4,'vendor_id'=>$post['id']));
                        }else{
                          $this->CommonModel->iudAction('tbl_vendor_master_attachment','','delete',array('id'=>$val4,'vendor_id'=>$post['id']));    
                        }
                   
                }
               }
                 
                 if(isset($vendor_attachement) && !empty($vendor_attachement)){
                        foreach ($vendor_attachement as $key => $value) {
                            $update_attch_data_a = array(
                                'vendor_id'=> $post['id'], 
                                'file_name' => $value['file_name'],
                                'updated_by' => userId(),
                                'updated_at' => date('Y-m-d'),
                              );
                             $this->CommonModel->iudAction('tbl_vendor_master_attachment', $update_attch_data_a, 'insert');
                        }        
                 }
                $this->session->set_flashdata('success','Vendor Data Update Successfully');
         }
            


            redirect(base_url(ADMIN.'Vendor'));
        }
        if($_id){
            $vendorData = $this->VendorModel->getVendorData('', 0, 0, 0, 0,$_id);
         
            $data =  $vendorData[0];
      
            $data['title'] = 'Edit Vendor Data';    

            $data['company_data'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['company_id'],'is_active'=>1),'id,name');
            $data['site_data'] = $this->CommonModel->getData('tbl_site',array('id'=>$data['site_id'],'company_id'=>$data['company_id'],'is_active'=>1),'id,site_name');
            $data['city_data'] = $this->CommonModel->getData('cities',array('id'=>$data['city_id'],'is_active'=>1),'id,name');
 
            $data['tax_tds_email'] = $this->CommonModel->getData('tbl_vendor_master_email',array('vendor_id'=>$_id),'id,email_id');
            $data['attachement'] = $this->CommonModel->getData('tbl_vendor_master_attachment',array('vendor_id'=>$_id));
          }
         $this->load->view(ADMIN.'vendor/add_vendor',$data);
  
    }



    public function delete($vendor_id)
    {
        // print_r($vendor_id);die;
        if ($vendor_id) {
        $vendor['deleted_at'] = date('Y-m-d H:i:s');
        $vendor['deleted_by'] = userId();
            if ($this->CommonModel->iudAction('tbl_vendor_master',$vendor,'update',array('id'=>$vendor_id))){

                $this->CommonModel->iudAction('tbl_vendor_master_attachment',$vendor,'update',array('vendor_id'=>$vendor_id));
                $this->CommonModel->iudAction('tbl_vendor_master_details',$vendor,'update',array('vendor_id'=>$vendor_id));
                $this->CommonModel->iudAction('tbl_vendor_master_email',$vendor,'update',array('vendor_id'=>$vendor_id));
               
                $this->session->set_flashdata('success','Vendor Deleted Successfully');
            }else{
                $this->session->set_flashdata('error','Fail to Delete Vendor ');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'Vendor'));
    }

    public function listVendorName($value='')
      {
            if(!isset($_GET['searchTerm'])){ 
                  $json = [];
                  $vendor_name=$this->VendorModel->getVendorName('');
            }else{
                  $search = $_GET['searchTerm'];
                  $vendor_name=$this->VendorModel->getVendorName($search);
            }
            // Initialize the JSON array
            $json = [];
            
            // Add empty option at the beginning
            $json[] = ['id' => '', 'text' => 'Select Vendor']; // Empty option

            foreach ($vendor_name as $key => $value) {
              $json[] = ['id'=>$value['id'], 'text'=>$value['account_name'],'address'=>$value['address_details']];
            }  
            echo json_encode($json);
      }

    public function remove_vendor_attachment()
    {
        $vendor_attachment_id = $this->input->post('vendor_attachment_id');
          
          if($this->CommonModel->iudAction('tbl_vendor_master_attachment','','delete',array('id'=>$vendor_attachment_id))){
                $response['result'] = true;
                // $response['reason'] = 'Removed Successfully';

            }else{
                $response['result'] = false;
                // $response['reason'] = 'not Removed!';
            }
            echo json_encode($response);
        }

      


}
?>
