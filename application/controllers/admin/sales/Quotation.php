<?php
/**
 * 
 */
class Quotation extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
          $this->load->model(ADMIN.'sales/QuotationModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Quotation';
       $this->load->view(ADMIN.'sales/quotation/list_quotation',$data);
    }
   // public function listcustomer()
   // {

   //   $data = $_POST;
   //       $columns = [];
   //       $page = $data['draw'];
   //       $limit = $data['length'];
   //       $offset = $data['start'];
   //       $searchVal = $data['search']['value'];
   //       $sortColIndex = $data['order'][0]['column'];
   //       $sortBy = $data['order'][0]['dir'];
   //       $where = array();
       
   //       $count = count($this->CustomerModel->getCustomerData($searchVal,0,0,0,0,0,$where));
   //       if($count){
   //           $result = $this->CustomerModel->getCustomerData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
   //         // print_r($result);die;
   //             foreach ($result as $key => $value) {
            
   //               $row = []; 

   //               array_push($row, $offset+($key+1));
                
                
   //               array_push($row, $value['company_name']);
   //               array_push($row, $value['address']);
   //               array_push($row, $value['phone']);
   //               array_push($row, $value['email']);
   //               array_push($row, $value['city_name']);
   //               array_push($row, $value['state_name']);
   //               array_push($row, $value['country_name']);
   //               // array_push($row, $value['currency']);
   //                if ($value['currency'] == 1) {
   //                  array_push($row, "INR");
   //              } else {
   //                  array_push($row, "");
   //              }
   //               array_push($row, $value['post_code']);
   //               // array_push($row, $value['rate_type']);
   //                if ($value['rate_type'] == 1) {
   //                  array_push($row, "KG");
   //              } else {
   //                  array_push($row, "");
   //              }
   //               array_push($row, $value['vat']);
                 
                 
   //               $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

   //               $action = '
              
   //                 <a href="'.base_url().'admin/sales/Customer/viewCustomerData/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

   //                 <a href="'.base_url().'admin/sales/Customer/add_customer/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                
               

   //              	 <a onclick="return '.$confirm.'" href="'.base_url() .'admin/sales/Customer/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                   
                
			// 		array_push($row, $action);

   //               $columns[] = $row;

   //           }
   //       }
   //       $response = [
   //           'draw' => $page,
   //           'data' => $columns,
   //           'recordsTotal' => $count,
   //           'recordsFiltered' => $count
   //       ];
   //       echo json_encode($response);
    
   // }


    public function add_quotation(){
      $this->load->view(ADMIN.'sales/quotation/add_quotation'); 
    }

    //  public function add_customer($id='')
    // {
      
    //     $data['title'] = 'Add Customer';
    //     $data['active'] = 'Customer';
    //     $post = $this->input->post();
       
    //     if ($post) {
    //             // echo'<pre>'; print_r($post);die;

    //             $customer= array(
    //                     'city_id' =>isset($post['city_id'])?$post['city_id']:'',
    //                     'state_id' =>isset($post['state_id'])?$post['state_id']:'' ,
    //                     'country_id' =>isset($post['country_id'])?$post['country_id']:'' ,
    //                     'company_name' =>isset($post['company_name'])?$post['company_name']:'',
    //                     'address' =>isset($post['address'])?$post['address']:'',
    //                     'phone' => isset($post['phone'])?$post['phone']:'',
    //                     'email' => isset($post['email'])?$post['email']:'',
    //                     'currency' => isset($post['currency'])?$post['currency']:'',
    //                     'post_code' => isset($post['post_code'])?$post['post_code']:'',
    //                     'rate_type' => isset($post['rate_type'])?$post['rate_type']:'',
    //                     'vat' => isset($post['vat'])?$post['vat']:'',
    //                     'company_id' =>userId('company_id'),
    //                     'site_id' =>userId('site_id'),
                     
    //                 );


    //             $customer_billing_shipping_details= array(
    //                     'billing_company' => isset($post['billing_company'])?$post['billing_company']:'',
    //                     'b_street' => isset($post['b_street'])?$post['b_street']:'',
    //                     'b_post_code' =>isset($post['b_post_code'])?$post['b_post_code']:'',
    //                     'b_city_id' =>isset($post['b_city_id'])?$post['b_city_id']:'',
    //                     'b_country_id' => isset($post['b_country_id'])?$post['b_country_id']:'',
    //                     'b_state_id' => isset($post['b_state_id'] )?$post['b_state_id'] :'',
    //                     's_street' => isset($post['s_street'])?$post['s_street']:'',
    //                     's_post_code' =>isset($post['s_post_code'])?$post['s_post_code']:'',
    //                     's_city_id' => isset($post['s_city_id'])?$post['s_city_id']:'',
    //                     's_country_id' =>isset($post['s_country_id'])?$post['s_country_id']:'' ,
    //                     's_state_id' => isset($post['s_state_id'])?$post['s_state_id']:'',

    //                 );


    //      if(empty($post['id'])) {
    //         $customer['created_by'] = userId();
    //         $customer['created_at'] = date('Y-m-d H:i:s');

    //             $insert_id = $this->CommonModel->iudAction('tbl_customer',$customer,'insert');

    //             if($insert_id){
    //                 $customer_billing_shipping_details['customer_id']=$insert_id;

    //                 $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer_billing_shipping_details,'insert');
                   
    //                 $this->session->set_flashdata('success','Customer Added Succesfully!');
    //             }else{
    //                 $this->session->set_flashdata('error','Customer Data Not Added !');
    //             }
                

    //         }else{
    
    //             // $customer['updated_by'] = userId();
    //             // $customer['updated_at'] = date('Y-m-d H:i:s');
    //          // echo "<pre>";  print_r($post);die;
    //             $this->CommonModel->iudAction('tbl_customer',$customer,'update',array('id' => $post['id']));
    //             $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer_billing_shipping_details,'update',array('customer_id' => $post['id']));
             
    //             $this->session->set_flashdata('success','Customer Data Update Successfully');
    //      }
            


    //        redirect(base_url(ADMIN.'sales/Customer'));
    //     }
       
    //       if($id){
    //          $customerData = $this->CustomerModel->getCustomerData('', 0, 0, 0, 0,$id);
    //          $data=  $customerData[0];
         
    //         // $data['cust_billing_shipping_deails'] = $this->CommonModel->getData('tbl_customer_billing_shipping_details',array('customer_id'=> $data['id']),'id,billing_company');
    //         $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
    //         $data['city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['city_id']),'id,name');
    //         $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');

    //         $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
    //         $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
    //         $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

    //          $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
    //         $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
    //         $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');


    //        }
    //       // echo '<pre>';print_r($data);die;
    //      $this->load->view(ADMIN.'sales/customer/add_customer',$data); 
  
    // }



    // public function viewCustomerData($id){
    //     $customerData = $this->CustomerModel->getCustomerData('', 0, 0, 0, 0,$id);
    //     $data=  $customerData[0];
    //     $data['city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['city_id']),'id,name');
    //     $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
    //      $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');

    //       $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
    //         $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
    //         $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

            
    //          $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
    //         $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
    //         $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');

    //    $this->load->view(ADMIN.'sales/customer/view_customer',$data);
    // }

      //  public function listcountryName($value='')
      // {
      //     if(!isset($_GET['searchTerm'])){ 
      //         $json = [];
      //         $country_name=$this->CustomerModel->getCountryName('');
      //     }else{
      //         $search = $_GET['searchTerm'];
      //         $country_name=$this->CustomerModel->getCountryName($search);
      //     }
      //        foreach ($country_name as $key => $value) {
              
      //         $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
      //         }  
      //     echo json_encode($json);
      // }

    
     // public function listcityName($value='')
     //  {
     //      if(!isset($_GET['searchTerm'])){ 
     //          $json = [];
     //          $city_name=$this->CustomerModel->getCityName('');
     //      }else{
     //          $search = $_GET['searchTerm'];
     //          $city_name=$this->CustomerModel->getCityName($search);
     //      }
     //         foreach ($city_name as $key => $value) {
              
     //          $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
     //          }  
     //      echo json_encode($json);
     //  }

      

      //  public function liststateName($value='')
      // {
      //     if(!isset($_GET['searchTerm'])){ 
      //         $json = [];
      //         $state_name=$this->CustomerModel->getStateName('');
      //     }else{
      //         $search = $_GET['searchTerm'];
      //         $state_name=$this->CustomerModel->getStateName($search);
      //     }
      //        foreach ($state_name as $key => $value) {
              
      //         $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
      //         }  
      //     echo json_encode($json);
      // }
   

    //   public function delete($customer_id)
    // {
    //     // print_r($vendor_id);die;
    //     if ($customer_id) {
    //     $customer['deleted_at'] = date('Y-m-d H:i:s');
    //     $customer['deleted_by'] = userId();
    //         if ($this->CommonModel->iudAction('tbl_customer',$customer,'update',array('id'=>$customer_id))){
    //           $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer,'update',array('customer_id'=>$customer_id));
            
    //             $this->session->set_flashdata('success','Customer Deleted Successfully!');
    //         }else{
    //             $this->session->set_flashdata('error','Fail to Delete Customer ');
    //         }
    //     }else{
    //         $this->session->set_flashdata('error',INVAILD_INPUT);
    //     }
        
    //     redirect(base_url(ADMIN.'sales/Customer'));
    // }
}