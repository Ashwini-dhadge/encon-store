<?php

/**
 * 
 */
class BalajiPlantDashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    // $this->load->model(ADMIN . 'production/ReceivedOrdersModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Balaji Plant Dashboard';

    $this->load->view(ADMIN . 'BalajiPlantDashboard/list_BalajiPlant', $data);
  }


  



  
}
