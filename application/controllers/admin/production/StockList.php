<?php

/**
 * 
 */
class StockList extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    // $this->load->model(ADMIN . 'production/ReceivedOrdersModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Stock';

    $this->load->view(ADMIN . 'production/stockLists/list_stock', $data);
  }



  
}
