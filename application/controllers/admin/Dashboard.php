<?php
/**
 * 
 */
class Dashboard extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		isLogin();
	}

	public function index()
	{   
	     $where = $data=array();
        
	       $this->load->view(ADMIN.DASHBOARD.'dashboard',$data);
	}
   
}
?>