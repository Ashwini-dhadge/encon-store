<?php
/**
 * 
 */
class Customer extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
          $this->load->model(ADMIN.'sales/CustomerModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Customer';
        // echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
      $this->load->view(ADMIN.'sales/customer/list_customer',$data);
    }
    public function listcustomer()
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
       
         $count = count($this->CustomerModel->getCustomerData($searchVal,0,0,0,0,0,$where));
        //  echo $this->db->last_query();die;
         if($count){
             $result = $this->CustomerModel->getCustomerData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
           // print_r($result);die;
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                
                
                 array_push($row, $value['company_name']);
                 array_push($row, $value['address']);
                 array_push($row, $value['phone']);
                 array_push($row, $value['email']);
                 array_push($row, $value['city_name']);
                 array_push($row, $value['state_name']);
                 array_push($row, $value['country_name']);
                 // array_push($row, $value['currency']);
                  if ($value['currency'] == 1) {
                    array_push($row, "INR");
                } else {
                    array_push($row, "");
                }
                 array_push($row, $value['post_code']);
                 // array_push($row, $value['rate_type']);
                  if ($value['rate_type'] == 1) {
                    array_push($row, "KG");
                } else {
                    array_push($row, "");
                }
                 array_push($row, $value['vat']);
                 
                 
                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
              
                   <a href="'.base_url().'admin/sales/Customer/viewCustomerData/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                   <a href="'.base_url().'admin/sales/Customer/add_customer/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                
               

                	 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/sales/Customer/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                   
                
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

    public function add_customer($id='')
    {
      
        $data['title'] = 'Add Customer';
        $data['active'] = 'Customer';
        $post = $this->input->post();
       
        if ($post) {
                // echo'<pre>'; print_r($post);die;

                $customer= array(
                        'city_id' =>isset($post['city_id'])?$post['city_id']:'',
                        'state_id' =>isset($post['state_id'])?$post['state_id']:'' ,
                        'country_id' =>isset($post['country_id'])?$post['country_id']:'' ,
                        'company_name' =>isset($post['company_name'])?$post['company_name']:'',
                        'address' =>isset($post['address'])?$post['address']:'',
                        'phone' => isset($post['phone'])?$post['phone']:'',
                        'email' => isset($post['email'])?$post['email']:'',
                        'currency' => isset($post['currency'])?$post['currency']:'',
                        'post_code' => isset($post['post_code'])?$post['post_code']:'',
                        'rate_type' => isset($post['rate_type'])?$post['rate_type']:'',
                        'vat' => isset($post['vat'])?$post['vat']:'',
                        'company_id' =>userId('company_id'),
                        'site_id' =>userId('site_id'),
                     
                    );


                $customer_billing_shipping_details= array(

                        'billing_company' => isset($post['billing_company'])?$post['billing_company']:'',
                        'b_street' => isset($post['b_street'])?$post['b_street']:'',
                        'b_post_code' =>isset($post['b_post_code'])?$post['b_post_code']:'',
                        'b_city_id' =>isset($post['b_city_id'])?$post['b_city_id']:'',
                        'b_country_id' => isset($post['b_country_id'])?$post['b_country_id']:'',
                        'b_state_id' => isset($post['b_state_id'] )?$post['b_state_id'] :'',
                        's_street' => isset($post['s_street'])?$post['s_street']:'',
                        's_post_code' =>isset($post['s_post_code'])?$post['s_post_code']:'',
                        's_city_id' => isset($post['s_city_id'])?$post['s_city_id']:'',
                        's_country_id' =>isset($post['s_country_id'])?$post['s_country_id']:'' ,
                        's_state_id' => isset($post['s_state_id'])?$post['s_state_id']:'',

                    );
        if(isset($post['lead_id'])){
            $customer['lead_id']= $post['lead_id'];
            //  $this->CommonModel->iudAction('tbl_lead', array('status_id' => 3), 'update', array('id' =>$customer['lead_id']));
        }else{
            $customer['lead_id']= NULL;
        }
         
         if(empty($post['id'])) {
            $customer['created_by'] = userId();
            $customer['created_at'] = date('Y-m-d H:i:s');

                $insert_id = $this->CommonModel->iudAction('tbl_customer',$customer,'insert');

                if($insert_id){
                    $customer_billing_shipping_details['customer_id']=$insert_id;
                 
                    $customer_billing_shipping_details['plant_narration'] = DEFAULT_PLANT_NARRATION;  
                    
                    $this->CommonModel->iudAction('tbl_plant',$customer_billing_shipping_details,'insert');

                    $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer_billing_shipping_details,'insert');
                   
                   if(isset($post['lead_id'])){
                       
                         $this->CommonModel->iudAction('tbl_lead', array('status_id' => 3), 'update', array('id' =>$customer['lead_id']));
                    }
                   
                    $this->session->set_flashdata('success','Customer Added Succesfully!');
                }else{
                    $this->session->set_flashdata('error','Customer Data Not Added !');
                }
                

            }else{
    
                $customer['updated_by'] = userId();
                $customer['updated_at'] = date('Y-m-d H:i:s');
             // echo "<pre>";  print_r($post);die;
                $this->CommonModel->iudAction('tbl_customer',$customer,'update',array('id' => $post['id']));
                $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer_billing_shipping_details,'update',array('customer_id' => $post['id']));
             
                $this->session->set_flashdata('success','Customer Data Update Successfully');
         }
            


           redirect(base_url(ADMIN.'sales/Customer'));
        }
       
          if($id){
             $customerData = $this->CustomerModel->getCustomerData('', 0, 0, 0, 0,$id);
             $data=  $customerData[0];
         
            // $data['cust_billing_shipping_deails'] = $this->CommonModel->getData('tbl_customer_billing_shipping_details',array('customer_id'=> $data['id']),'id,billing_company');
            $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
            $data['city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['city_id']),'id,name');
            $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');

            $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
            $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
            $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

             $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
            $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
            $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');


           }
          // echo '<pre>';print_r($data);die;
         $this->load->view(ADMIN.'sales/customer/add_customer',$data); 
  
    }



    public function viewCustomerData($id)
    {
        $customerData = $this->CustomerModel->getCustomerData('', 0, 0, 0, 0,$id);
        $data=  $customerData[0];
        $data['city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['city_id']),'id,name');
        $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
         $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');

        $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
        $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
        $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

            
        $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
        $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
        $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');

        $data['inprocess_status_cnt'] = $this->CommonModel->getData('tbl_opportunity_tracker',array('customer_id'=>$data['id'],'status'=>OPPORTUNITY_STATUS_INPROCESS,'type'=>0),'','','num_rows');
        $data['complete_status_cnt'] = $this->CommonModel->getData('tbl_opportunity_tracker',array('customer_id'=>$data['id'],'status'=>OPPORTUNITY_STATUS_COMPLETE,'type'=>0),'','','num_rows');

        // echo "<pre>"; print_r($data);die;
       $this->load->view(ADMIN.'sales/customer/view_customer',$data);
    }

   
    public function listitems($value='')
      {
          if(!isset($_GET['searchTerm'])){ 
              $json = [];
              $items_name=$this->CustomerModel->getitemsName('');
          }else{
              $search = $_GET['searchTerm'];
              $items_name=$this->CustomerModel->getitemsName($search);
          }
             foreach ($items_name as $key => $value) {
              
              $json[] = ['id'=>$value['id'], 'text'=>$value['item_name']];
              }  
          echo json_encode($json);
      }

      
   

    public function delete($customer_id)
    {
        // print_r($vendor_id);die;
        if ($customer_id) {
        $customer['deleted_at'] = date('Y-m-d H:i:s');
        $customer['deleted_by'] = userId();
            if ($this->CommonModel->iudAction('tbl_customer',$customer,'update',array('id'=>$customer_id))){
              $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer,'update',array('customer_id'=>$customer_id));
            
                $this->session->set_flashdata('success','Customer Deleted Successfully!');
            }else{
                $this->session->set_flashdata('error','Fail to Delete Customer ');
            }
        }else{
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'sales/Customer'));
    }



    // ---------------------------- customer plant ----------------------------

    public function customer_plant_form($id='')     
    {
            
       $id = $this->input->post('id');
       $data['customer_id'] = $this->input->post('customer_id');
       $data['sub_title'] = 'Add Customer Plants Info';

        
       
        if($id){
           
            $customerData = $this->CustomerModel->getPlantCustomerData('', 0, 0, 0, 0,$id);
            $data=  $customerData[0];
            // echo $this->db->last_query();die;
            $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
            $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
            $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

            $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
            $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
            $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');

             $data['sub_title'] = 'Edit Customer Plants Info';
        }
// echo "<pre>"; print_r($data);die;
        $html = $this->load->view(ADMIN.'sales/customer/add_customer_plant_model', $data,true); 
       

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



    public function list_customer_plant_info(){
    
        $data = $_POST;
            $columns = [];
            $page = $data['draw'];
            $limit = $data['length'];
            $offset = $data['start'];
            $searchVal = $data['search']['value'];
            $sortColIndex = $data['order'][0]['column'];
            $sortBy = $data['order'][0]['dir'];
            $where = array();
            
            if(isset($data['customer_id'])){
            $where['tp.customer_id'] = $data['customer_id'];
            }   

            $count = count($this->CustomerModel->getPlantCustomerData($searchVal,0,0,0,0,0,$where));
            if($count){
                $result = $this->CustomerModel->getPlantCustomerData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
            // echo "<pre>"; print_r($result);die;
                foreach ($result as $key => $value) {
            
                    $row = []; 

                    array_push($row, $offset+($key+1));
                
                
                    array_push($row, $value['plant_narration']);
                    array_push($row, $value['billing_company']);
                    
                    
                    $confirm = "confirm('Are you sure you want to delete this plant details?')";

                    $action = '
                    
                    <a href="javascript:void(0);" title="view" class="btn btn-primary waves-effect waves-light btn-sm view_customer_plant_data" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" onclick="view_customer_plant_data('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                    <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm customer_plant_form" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" onclick="customer_plant_form('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>';

                    array_push($row, $action);

                    // <a href="javascript:void(0)" data-toggle="modal" data-target="" title="delete" class="btn btn-primary waves-effect waves-light btn-sm deleteBtn"  onclick="deleteBtn('.$value['id'] .')"  data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-trash" aria-hidden="true"></i></a>

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
        


    public function submit_customer_plant_data($id='')
    {
      
        $data['title'] = 'Add Customer';
        $data['active'] = 'Customer';
        $post = $this->input->post();
       
         // echo'<pre>'; print_r($post);die;

        if ($post) {
              

                $customer_billing_shipping_details= array(
                        'plant_narration' => isset($post['plant_narration'])?$post['plant_narration']:'',
                        'plant_address' => isset($post['plant_address'])?$post['plant_address']:'',
             
                        'billing_company' => isset($post['billing_company'])?$post['billing_company']:'',
                        'b_street' => isset($post['b_street'])?$post['b_street']:'',
                        'b_post_code' =>isset($post['b_post_code'])?$post['b_post_code']:'',
                        'b_city_id' =>isset($post['b_city_id'])?$post['b_city_id']:'',
                        'b_country_id' => isset($post['b_country_id'])?$post['b_country_id']:'',
                        'b_state_id' => isset($post['b_state_id'] )?$post['b_state_id'] :'',
                        's_street' => isset($post['s_street'])?$post['s_street']:'',
                        's_post_code' =>isset($post['s_post_code'])?$post['s_post_code']:'',
                        's_city_id' => isset($post['s_city_id'])?$post['s_city_id']:'',
                        's_country_id' =>isset($post['s_country_id'])?$post['s_country_id']:'' ,
                        's_state_id' => isset($post['s_state_id'])?$post['s_state_id']:'',

                    );


         if(empty($post['id'])) {
             $customer_billing_shipping_details['customer_id']=isset($post['customer_id'])?$post['customer_id']:'';
            $customer_billing_shipping_details['created_by'] = userId();
            $customer_billing_shipping_details['created_at'] = date('Y-m-d H:i:s');

                $insert_id = $this->CommonModel->iudAction('tbl_plant',$customer_billing_shipping_details,'insert');

                if($insert_id){
                    
                    $response['result'] = true;
                    $response['reason'] = 'Customer Plant Data Added Succesfully!';

                }else{
                    $response['result'] = false;
                    $response['reason'] = 'Customer Plant Data Not Added !';
                }
              
            }else{
    
                $customer_billing_shipping_details['updated_by'] = userId();
                $customer_billing_shipping_details['updated_at'] = date('Y-m-d H:i:s');
                

                if($this->CommonModel->iudAction('tbl_plant',$customer_billing_shipping_details,'update',array('id' => $post['id']))){
                    $response['result'] = true;
                    $response['reason'] = 'Customer Plant Data Updated Succesfully!';
                }else{
                    $response['result'] = false;
                    $response['reason'] = 'Customer Plant Data Not Updated !';
                }
                

                
         }
         
        }
        // print_r($response);
         echo json_encode($response);

  
    }



    public function view_customer_plant_data($id='')     
    {
            
        $id = $this->input->post('plant_id');
        $data['sub_title'] = 'Add Customer Plants Info';

        if($id){
            $custPlantData = $this->CustomerModel->getPlantCustomerData('', 0, 0, 0, 0,$id);
            $data['cust_plant_data'] =  $custPlantData[0];
        
            $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['cust_plant_data']['b_city_id']),'id,name');
            $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['cust_plant_data']['b_country_id']),'id,name');
            $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['cust_plant_data']['b_state_id']),'id,name');

            $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['cust_plant_data']['s_city_id']),'id,name');
            $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['cust_plant_data']['s_country_id']),'id,name');
            $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['cust_plant_data']['s_state_id']),'id,name');
            
            $data['sub_title'] = 'Customer Plants Info';
        }
    // echo "<pre>"; print_r($data);die;
        $html = $this->load->view(ADMIN.'sales/customer/view_customer_plant_details', $data,true); 
        

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






    public function delete_customer_plant()
    {   
        $plant_id = $this->input->post('plant_id');
        // print_r($plant_id);die;
        if ($plant_id) {
         $delete['deleted_at'] = date('Y-m-d H:i:s');
         $delete['deleted_by'] = userId();

            if ($this->CommonModel->iudAction('tbl_plant',$delete,'update',array('id'=>$plant_id))){
                $response['result'] = true;
                $response['reason'] = 'Plant Data Deleted Succesfully!';
                $this->session->set_flashdata('success','Customer Deleted Successfully!');
            }else{
                $response['result'] = false;
                $response['reason'] = 'Fail to Delete Plant Data!';
            }
        }else{
             $response['result'] = false;
             $response['reason'] = 'Fail to Delete Plant Data!';
        }
        
         echo json_encode($response);
    }

     
  public function add_customer_lead_convert($id='') {
    $post = $this->input->post();
        if (!empty($post)) {
            $lead_cust_convert = isset($post['lead_cust_convert']) ? $post['lead_cust_convert'] : 0; 

        if ($lead_cust_convert == 1) {
           
            $data = array(
                'lead_id' => $post['id'],
                'company_name' => $post['company_name'],
                'address' => $post['address'],
                'phone' => $post['phone'],
                'email' => $post['email'],
                'country_id' => $post['country'],
                'post_code' => $post['zipcode'],
                'lead_cust_convert' => 1
            );
            $data['country_data'] = $this->CommonModel->getData('countries','','id,name');
           

        } else {
            $data = $post;
        }
        } else {
        $data = array();
        }
     // echo '<pre>';print_r($data);die;
    $this->load->view(ADMIN.'sales/customer/add_customer', $data);
}


/// chetan code 10 05 2024
public function list_customer_contact_details(){
    $data = $_POST;
     $columns = [];
     $page = $data['draw'];
     $limit = $data['length'];
     $offset = $data['start'];
     $searchVal = $data['search']['value'];
     $sortColIndex = $data['order'][0]['column'];
     $sortBy = $data['order'][0]['dir'];
     $where = array();
        
     if(isset($data['customer_id'])){
        $where['ccd.customer_id'] = $data['customer_id'];
     }   


    $count = count($this->CustomerModel->getCustomerContactDetailsData($searchVal,0,0,0,0,0,$where));
    if($count){
        $result = $this->CustomerModel->getCustomerContactDetailsData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
    // echo "<pre>"; print_r($result);die;
        foreach ($result as $key => $value) {
    
            $row = []; 

            array_push($row, $offset+($key+1));
        
        
            array_push($row, $value['contact_person_name']);
            array_push($row, $value['contact_mobile_no']);
            array_push($row, $value['designation']);

            
            
            $confirm = "confirm('Are you sure you want to delete this plant details?')";

            $action = '
            
            <a href="javascript:void(0);" title="view" class="btn btn-primary waves-effect waves-light btn-sm view_customer_contact_data" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" onclick="view_customer_contact_data('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-eye" aria-hidden="true"></i></a>

            <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm customer_contact_form" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" onclick="customer_contact_form('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>
            
            
            <a href="javascript:void(0)" data-toggle="modal" data-target="" title="delete" class="btn btn-primary waves-effect waves-light btn-sm deleteCustDetailsBtn"  onclick="deleteCustDetailsBtn('.$value['id'] .')"  data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-trash" aria-hidden="true"></i></a>
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
/// end chetan code 10 05 2024


/// chetan code 13 05 2024
    public function submit_customer_contact_details_data($id='')
    {
        
        $data['title'] = 'Add Customer';
        $data['active'] = 'Customer';
        $post = $this->input->post();
        
        //echo'<pre>'; print_r($post);die;

        if ($post) {
            
            $customer_contact_details= array(
                    'contact_person_name' => isset($post['contact_person_name'])?$post['contact_person_name']:'',
                    'contact_mobile_no' => isset($post['contact_mobile_no'])?$post['contact_mobile_no']:'',
                    'designation' => isset($post['designation'])?$post['designation']:'',
                );


            if(empty($post['id'])) {
                //print_r($post['id']);die;
                $customer_contact_details['customer_id']= isset($post['customer_id'])?$post['customer_id']:'';
                $customer_contact_details['created_by'] = userId();
                $customer_contact_details['created_at'] = date('Y-m-d H:i:s');

                $insert_id = $this->CommonModel->iudAction('tbl_customer_contact_details',$customer_contact_details,'insert');

                if($insert_id){
                    
                    $response['result'] = true;
                    $response['reason'] = 'Customer Contact Data Added Succesfully!';

                }else{
                    $response['result'] = false;
                    $response['reason'] = 'Customer Contact Data Not Added !';
                }
                
            }else{

                $customer_contact_details['updated_by'] = userId();
                $customer_contact_details['updated_at'] = date('Y-m-d H:i:s');
                

                if($this->CommonModel->iudAction('tbl_customer_contact_details',$customer_contact_details,'update',array('id' => $post['id']))){
                    $response['result'] = true;
                    $response['reason'] = 'Customer Contact Data Updated Succesfully!';
                }else{
                    $response['result'] = false;
                    $response['reason'] = 'Customer Contact Data Not Updated !';
                }
                

                
            }
            
        }
        // print_r($response);
            echo json_encode($response);


    }


    public function customer_contact_form($id='')     
    {
            
        $id = $this->input->post('id');
        $data['customer_id'] = $this->input->post('customer_id');
        $data['sub_title'] = 'Add Customer Contact Info';


        //print_r($data);die;

        
        
        if($id){
            $data['customer_contact_details'] = $this->CommonModel->getData('tbl_customer_contact_details',array('id'=> $id),'id,customer_id,contact_person_name,contact_mobile_no,designation');

            $data['sub_title'] = 'Edit Customer Customer Info';
        }
    // echo "<pre>"; print_r($data);die;
        $html = $this->load->view(ADMIN.'sales/customer/add_customer_details_model', $data,true); 
        

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

    public function view_customer_contact_data($id='')     
    {
            
        $id = $this->input->post('contact_id');
        $data['sub_title'] = 'Add Customer Contact Info';

        if($id){
        
            $data['customer_contact_details'] = $this->CommonModel->getData('tbl_customer_contact_details',array('id'=> $id),'id,customer_id,contact_person_name,contact_mobile_no,designation');
            
            $data['sub_title'] = 'Customer Contact Info';
        }
        //echo "<pre>"; print_r($data);die;
        $html = $this->load->view(ADMIN.'sales/customer/view_customer_contact_details.php', $data,true); 
        

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


    public function delete_customer_contact_details()
    {
        $contact_id = $this->input->post('contact_id');

        if(!empty($contact_id))
        {
            $contact['deleted_at'] = date('Y-m-d H:i:s');
            $contact['deleted_by'] = userId();
            
                $this->CommonModel->iudAction('tbl_customer_contact_details',$contact,'update',array('id'=>$contact_id));
            
                $response['result'] = true;
                $response['reason'] = 'Contact Deleted Succesfully!';
            
        }
        else
        {
            $this->session->set_flashdata('error',INVAILD_INPUT);
            $response['result'] = false;
                $response['reason'] = 'Not Deleted Succesfully!';
        }
        
        echo json_encode($response);
    }


/// end chetan code 13 05 2024
    

}