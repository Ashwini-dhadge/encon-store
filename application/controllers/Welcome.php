<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
     function __construct()
        {
                parent::__construct();
                $this->load->model(ADMIN . 'POModel');
               
        }
	public function index()
	{
	    redirect(base_url('admin'));
	   
	}
	
	public function getPOEmailConfirmation($po_id)
	{
		$data['page']="product";
		 $poData = $this->POModel->getViewPoData($po_id);
		 $data['po_data']=$poData[0];
// 		 echo "<pre>";
// 		 print_r($data);die;
	    $this->load->view('confirmation-page',$data);
		
	}
	
	public function updatePOStatus(){
	    $post=$this->input->post();
	    if(isset($post['po_id'])){
	        $this->CommonModel->iudAction('tbl_po', array('vendor_approved'=>1,'vendor_approved_at'=>date('Y-m-d H:i:s')), 'update', array('id' => $post['po_id']));
	    }
	}

}
