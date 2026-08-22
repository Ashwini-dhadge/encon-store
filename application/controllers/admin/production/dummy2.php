<?php

/**
 * 
 */
class SemifinishedList extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'production/SemiFinishedModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Received Orders';

    $this->load->view(ADMIN . 'production/semiFinishedLists/list_Semifinished', $data);
  }

  public function listSemifinshedOrder()
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



    $count = count($this->SemiFinishedModel->getSemifinishedOrderLists($searchVal, 0, 0, 0, 0, 0, $where));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->SemiFinishedModel->getSemifinishedOrderLists($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
      // echo"<pre>";
      // print_r($result);die;


      foreach ($result as $key => $value) {

        $row = [];

        $keyPlusOne = $offset + ($key + 1);
        $row[] = '<i class="fas fa-plus-circle plus-icon" data-id="' . $value['id'] . '"></i> ' . $keyPlusOne;
        $orderFor = "";
        if ($value['order_for'] == 1) {
          $orderFor = "Indent";
        } elseif ($value['order_for'] == 2) {
          $orderFor = 'Self';
        }

        // array_push($row, $orderFor);
        array_push($row, (isset($value['indent_id']) ? $value['indent_id'] : ""));  // project Number
        array_push($row, (isset($value['manual_indent_no']) ? $value['manual_indent_no'] : ""));  // Manual Indent Number
        array_push($row, $orderFor);
        array_push($row, $value['indent_date']);
        array_push($row, $value['company_name']);
        // array_push($row, $value['order_for']);
        array_push($row, '<span class="label label-success">' . $value['blade_qty']  . '</span>');
        array_push($row, (isset($value['transfer_qty']) ? '<span class="label custome-received">' . $value['transfer_qty'] . '</span>' : " "));
        array_push($row, (isset($value['gap_checking_qty']) ? '<span class="label custom-label-yeal">' . $value['gap_checking_qty'] . '</span>' : " "));
        array_push($row, (isset($value['primer_qty']) ? '<span class="label label-info">' . $value['primer_qty'] . '</span>' : " "));
        array_push($row, (isset($value['filler_qty']) ? '<span class="label label-warning">' . $value['filler_qty'] . '</span>' : " "));
        array_push($row, (isset($value['putty_qty']) ? '<span class="label custom-label-teal">' . $value['putty_qty'] . '</span>' : " "));
        array_push($row, (isset($value['top_coat_qty']) ? '<span class="label label-inverse">' . $value['top_coat_qty'] . '</span>' : " "));
        array_push($row, (isset($value['balancing_qty']) ? '<span class="label custom-label-ceal">' . $value['balancing_qty'] . '</span>' : " "));
        array_push($row, (isset($value['packing_qty']) ? '<span class="label custom-label-peal">' . $value['packing_qty'] . '</span>' : " "));
        array_push($row, (isset($value['dispatch_qty']) ? '<span class="label custom-label-keal">' . $value['dispatch_qty'] . '</span>' : " "));




        $action = '<a href="' . base_url() . 'admin/production/Indent/view_indent_blade/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        $action .= '<a href="javascript:void(0);" title="Transfer Qty" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="transferQty(this)" data-id="' . $value['id'] . '" data-manual-indent-no="' . $value['manual_indent_no'] . '" data-indent-id="' . $value['indent_id'] . '"><i class="fas fa-arrow-right" aria-hidden="true"></i></a>';
        $action .= '<a href="#" title="Exchange Quantity" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="" data-id="' . $value['id'] . '" data-manual-indent-no="' . $value['manual_indent_no'] . '" data-indent-id="' . $value['indent_id'] . '"><i class="fas fa-exchange-alt" aria-hidden="true"></i></a>';

        // $action .= '<a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray; " onclick="transferQty(' . $value['id'] . ')" data-id="' . $value['indent_id'] . '"><i class="fas fa-edit" aria-hidden="true"></i></a>';

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


  public function indentDetails()
  {
    $data = $_POST;

    $details = $this->SemiFinishedModel->indentDetails($data['id']);
    // echo"<pre>";
    // print_r($details);
    // die;
    echo json_encode($details);
  }

  public function semifinishedOrder()
  {
    $company_id = $this->session->userdata('company_id');
    $post = $_POST;

    // Prepare new order data
    $semiFinishedOrderData = [
      'gap_checking_qty' => !empty($post['gap_checking_qty']) ? $post['gap_checking_qty'] : NULL,
      'primer_qty' => !empty($post['primer_qty']) ? $post['primer_qty'] : NULL,
      'filler_qty' => !empty($post['filler_qty']) ? $post['filler_qty'] : NULL,
      'putty_qty' => !empty($post['putty_qty']) ? $post['putty_qty'] : NULL,
      'top_coat_qty' => !empty($post['top_coat_qty']) ? $post['top_coat_qty'] : NULL,
      'balancing_qty' => !empty($post['balancing_qty']) ? $post['balancing_qty'] : NULL,
      'packing_qty' => !empty($post['packing_qty']) ? $post['packing_qty'] : NULL,
      'company_id' => $company_id,

    ];

    // Fetch old data
    $oldData = $this->CommonModel->getData('tbl_indent_order_status', array('order_id' => $post['order_id']), '', '', 'row_array');

    // Update the order data
    $this->CommonModel->iudAction('tbl_indent_order_status', $semiFinishedOrderData, 'update', array('order_id' => $post['order_id']));

    // Prepare status details based on changes
    $statusDetails = [];

    if ($post['gap_checking_qty'] != $oldData['gap_checking_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['gapCheckingStatus'],
        'qty' => $post['gap_checking_qty'],
        'remark' => $post['gap_checking_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    if ($post['primer_qty'] != $oldData['primer_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['primerStatus'],
        'qty' => $post['primer_qty'],
        'remark' => $post['primer_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    if ($post['filler_qty'] != $oldData['filler_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['fillerStatus'],
        'qty' => $post['filler_qty'],
        'remark' => $post['filler_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    if ($post['putty_qty'] != $oldData['putty_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['puttyStatus'],
        'qty' => $post['putty_qty'],
        'remark' => $post['putty_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    if ($post['top_coat_qty'] != $oldData['top_coat_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['topCoatStatus'],
        'qty' => $post['top_coat_qty'],
        'remark' => $post['top_coat_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    if ($post['balancing_qty'] != $oldData['balancing_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['balancingStatus'],
        'qty' => $post['balancing_qty'],
        'remark' => $post['balancing_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    if ($post['packing_qty'] != $oldData['packing_qty']) {
      $statusDetails[] = [
        'order_id' => $post['order_id'],
        'status_id' => $post['packingStatus'],
        'qty' => $post['packing_qty'],
        'remark' => $post['packing_remark'],
        'created_by' => userId(),
        'company_id' => $company_id,
      ];
    }

    // Insert new records if any quantity has changed
    foreach ($statusDetails as $details) {
      if ($details['qty'] > 0) {
        $this->CommonModel->iudAction('tbl_indent_order_status_details', $details, 'insert');
      }
    }

    // Set success message and return response
    $this->session->set_flashdata('success', 'Order Status Updated Successfully');
    echo json_encode([
      'status' => 'success',
      'message' => 'Order Status updated successfully!'
    ]);
  }


  public function dispatchOrder()
  {
    $company_id = $this->session->userdata('company_id');
    $post = $_POST;
    // echo"<pre>";
    // print_r($post);
    $olddata = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $post['order_id']], '', '', 'row_array');

    $updateDispatchQty = $olddata['dispatch_qty'] + $post['dispatch_qty'];

    $updatePackingQty = $post['packingQty'] - $post['dispatch_qty'];
    $data = [
      'packing_qty' => $updatePackingQty,
      'dispatch_qty' => $updateDispatchQty,
      'company_id' => $company_id,
    ];
    // print_r($data);
    // die;
    $this->CommonModel->iudAction('tbl_indent_order_status', $data, 'update', ['order_id' => $post['order_id']]);

    $statusData = [
      'order_id' => $post['order_id'],
      'status_id' => $post['status'],
      'qty' => $post['dispatch_qty'],
      'created_by' => userId(),
      'company_id' => $company_id,
    ];
    $this->CommonModel->iudAction('tbl_indent_order_status_details', $statusData, 'insert');
    // print_r($statusData);
    // die;
    $this->session->set_flashdata('success', 'Order Dispatch Succesfully ');

    echo json_encode([
      'status' => 'success',
      'message' => 'Order Dispatch Succesfully'
    ]);
  }


  public function transferQty()
  {
    // echo"<pre>";
    // print_r($_POST);die;
    $orderId = $this->input->post('id');
    $manualIndentNo = $this->input->post('manual_indent_no');
    $type = $this->input->post('type');  // 1 for Encon Received Order. 2 for Balaji plant Semifinished Stage.
    // print_r($type);die;
    if ($orderId && $manualIndentNo) {
      $data['orderId'] = $orderId;
      $data['type'] = $type;
      $data['manualIndentNo'] = $manualIndentNo;
      $getIndentOrder = $this->CommonModel->getData('tbl_indent_order', ['id' => $orderId], 'mould_size', '', 'row_array');
      $getOrderStatus = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $orderId], 'created_qty,blade_in_hand_qty,blade_position_qty,transfer_qty,gap_checking_qty,primer_qty,filler_qty,putty_qty,top_coat_qty,balancing_qty,packing_qty,', '', 'row_array');
      $data['mould_size'] = $getIndentOrder['mould_size'];
      $data['orderStatus'] = $getOrderStatus;
      // echo"<pre>";
      // print_r($data);die;
    }

    $html = $this->load->view(ADMIN . "production/semiFinishedLists/transferQty_Modal", $data, true);
    if ($html) {
      $response['html'] = $html;
      $response['result'] = true;
      $response['reason'] = 'Data Found';
    } else {
      $response['result'] = false;
      $response['reason'] = 'Something went to wrong!';
    }
    echo json_encode($response);
  }

  public function listIndent()
  {

    $json = [];


    $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
    $mouldsize = isset($_GET['mouldsize']) ? $_GET['mouldsize'] : '';
    $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';


    $mouldData = $this->SemiFinishedModel->getMouldSize($searchTerm, $mouldsize, $orderId, $type);


    foreach ($mouldData as $key => $value) {
      // $json[] = ['id' => $value['manual_indent_no'], 'text' => $value['manual_indent_no']]; // modified
      $json[] = ['id' => $value['manual_indent_no'], 'text' => $value['manual_indent_no'] . "(" . $value['id'] . ")"]; //original 
      // $json[] = ['id' => $value['manual_indent_no'], 'text' => $value['manual_indent_no']. "(" .'123' . ")"]; //original 
    }


    echo json_encode($json);
  }

  // public function transferOrder()
  // {

  //   // echo "<pre>";
  //   $post = $_POST;
  //   // print_r($post);
  //   // die;
  //   $whereCondition = [];
  //   $updateIndentOrderStatus = [];
  //   $transferOrderDetails = [];
  //   $transferIndentOrder = [];

  //   if ($post['type'] == 1) {

  //     $created_qty = !empty($post['created_qty']) ? $post['created_qty'] : 0;
  //     $blade_in_hand_qty = !empty($post['blade_in_hand_qty']) ? $post['blade_in_hand_qty'] : 0;
  //     $blade_position_qty = !empty($post['blade_position_qty']) ? $post['blade_position_qty'] : 0;
  //     $total_transfer_qty = $created_qty + $blade_in_hand_qty + $blade_position_qty;
  //     if (!empty($post['created_qty'])) {
  //       $transferOrderDetails[] = [
  //         'from_indent_id' => !empty($post['fromManualIndentNo']) ? $post['fromManualIndentNo'] : NULL,
  //         'to_indent_id' => !empty($post['transferToManualIndnetNo']) ? $post['transferToManualIndnetNo'] : NULL,
  //         'from_indent_status_id' => 1,
  //         'to_indent_status_id' => 1,
  //         'from_indent_qty' => !empty($post['from_hidden_created_qty']) ? $post['from_hidden_created_qty'] : NULL,
  //         'to_indent_qty' => !empty($post['created_qty']) ? $post['created_qty'] : NULL,
  //         'created_at' => date('Y-m-d H:i:s'),
  //         'created_by' => userId(),

  //       ];
  //       $whereCondition[] = [
  //         'order_id' => $post['orderId'],
  //         'qty' => !empty($post['from_hidden_created_qty']) ? $post['from_hidden_created_qty'] : NULL
  //       ];
  //       $updateCreatedQty = $post['from_hidden_created_qty'] - $post['created_qty'];
  //       $updateIndentOrderStatus[] = [
  //         'created_qty' => $updateCreatedQty,
  //       ];
  //       $transferIndentOrder[] = [
  //         'created_qty' =>  $post['created_qty'],

  //       ];
  //     }
  //     if (!empty($post['blade_in_hand_qty'])) {
  //       $transferOrderDetails[] = [
  //         'from_indent_id' => !empty($post['fromManualIndentNo']) ? $post['fromManualIndentNo'] : NULL,
  //         'to_indent_id' => !empty($post['transferToManualIndnetNo']) ? $post['transferToManualIndnetNo'] : NULL,
  //         'from_indent_status_id' => 2,
  //         'to_indent_status_id' => 2,
  //         'from_indent_qty' => !empty($post['from_hidden_blade_in_hand_qty']) ? $post['from_hidden_blade_in_hand_qty'] : NULL,
  //         'to_indent_qty' => !empty($post['blade_in_hand_qty']) ? $post['blade_in_hand_qty'] : NULL,
  //         'created_at' => date('Y-m-d H:i:s'),
  //         'created_by' => userId(),

  //       ];
  //       $whereCondition[] = [
  //         'order_id' => $post['orderId'],
  //         'qty' => !empty($post['from_hidden_blade_in_hand_qty']) ? $post['from_hidden_blade_in_hand_qty'] : NULL
  //       ];
  //       $updateBladeHandQty = $post['from_hidden_blade_in_hand_qty'] - $post['blade_in_hand_qty'];
  //       $updateIndentOrderStatus[] = [
  //         'blade_in_hand_qty' => $updateBladeHandQty,
  //       ];
  //       $transferIndentOrder[] = [
  //         'blade_in_hand_qty' => $post['blade_in_hand_qty'],
  //       ];
  //     }
  //     if (!empty($post['blade_position_qty'])) {
  //       $transferOrderDetails[] = [
  //         'from_indent_id' => !empty($post['fromManualIndentNo']) ? $post['fromManualIndentNo'] : NULL,
  //         'to_indent_id' => !empty($post['transferToManualIndnetNo']) ? $post['transferToManualIndnetNo'] : NULL,
  //         'from_indent_status_id' => 3,
  //         'to_indent_status_id' => 3,
  //         'from_indent_qty' => !empty($post['from_hidden_blade_position_qty']) ? $post['from_hidden_blade_position_qty'] : NULL,
  //         'to_indent_qty' => !empty($post['blade_position_qty']) ? $post['blade_position_qty'] : NULL,
  //         'created_at' => date('Y-m-d H:i:s'),
  //         'created_by' => userId(),

  //       ];
  //       $whereCondition[] = [
  //         'order_id' => $post['orderId'],
  //         'qty' => !empty($post['from_hidden_blade_position_qty']) ? $post['from_hidden_blade_position_qty'] : NULL
  //       ];
  //       $updateBladePositionQty = $post['from_hidden_blade_position_qty'] - $post['blade_position_qty'];
  //       $updateIndentOrderStatus[] = [
  //         'blade_Position_qty' => $updateBladePositionQty,
  //       ];
  //       $transferIndentOrder[] = [
  //         'blade_position_qty' => $post['blade_position_qty']
  //       ];
  //     }

  //     // echo"<pre>";
  //     // print_r($transferOrderDetails);
  //     // $updateStatus = [];
  //     $updateIndentOrderStatus[] = [
  //       'indent_transfer_qty' => $total_transfer_qty,
  //     ];
  //     foreach ($transferOrderDetails as $transferDetails) {
  //       // echo"<pre>";
  //       // print_r($transferDetails);
  //       $transferId = $this->CommonModel->iudAction('tbl_indent_order_transfer', $transferDetails, 'insert');
  //       if ($transferId) {
  //         foreach ($whereCondition as $where)
  //           $updateOrderStatus = $this->CommonModel->iudAction('tbl_indent_order_status_details', ['is_transfer' => 1, 'transfer_id' => $transferId], 'update', $where);
  //         if ($updateOrderStatus) {
  //           foreach ($updateIndentOrderStatus as $indentOrderStatus) {
  //             $updateIndentOrder = $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatus, 'update', ['order_id' => $post['orderId']]);
  //             if ($updateIndentOrder) {
  //               foreach ($transferIndentOrder as $uio) {
  //                 $this->CommonModel->iudAction('tbl_indent_order_status', $uio, 'update', ['order_id' => $post['transferToOrderId']]);
  //               }
  //             }
  //           }
  //         }
  //       }
  //       // print_r($transferId);
  //     }

  //   }
  // }
  public function transferOrder()
  {
    $post = $_POST;
    echo "<pre>";
    // print_r($post);
    // die;
    echo "<br>";
    $whereCondition = [];
    $updateIndentOrderStatus = [];
    $transferOrderDetails = [];
    $transferIndentOrder = [];
    $indentStatusDetails = [];

    if ($post['type'] == 1) {

      $created_qty = isset($post['created_qty']) && $post['created_qty'] !== '' ? $post['created_qty'] : 0;
      $blade_in_hand_qty = isset($post['blade_in_hand_qty']) && $post['blade_in_hand_qty'] !== '' ? $post['blade_in_hand_qty'] : 0;
      $blade_position_qty = isset($post['blade_position_qty']) && $post['blade_position_qty'] !== '' ? $post['blade_position_qty'] : 0;
      $total_transfer_qty = $created_qty + $blade_in_hand_qty + $blade_position_qty;

      // transfer  insert
      $transferOrder= array(
        'from_indent_id' => !empty($post['fromManualIndentNo']) ? $post['fromManualIndentNo'] : NULL,
        'to_indent_id' => !empty($post['transferToManualIndnetNo']) ? $post['transferToManualIndnetNo'] : NULL,
        'from_order_id' => !empty($post['orderId']) ? $post['orderId'] : NULL,
        'to_order_id' => !empty($post['transferToOrderId']) ? $post['transferToOrderId'] : NULL,   
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => userId(),
      );
     
      $transferId = $this->CommonModel->iudAction('tbl_indent_order_transfer', $transferOrder, 'insert');
    
      if (isset($post['created_qty']) && $post['created_qty'] !== '') {
        $transferOrderDetails[] = [
          'transfer_id'=>$transferId,
          'from_indent_status_id' => 1,
          'to_indent_status_id' => 1,
          'from_indent_qty' => isset($post['from_hidden_created_qty']) ? $post['from_hidden_created_qty'] : NULL,
          'to_indent_qty' => isset($post['created_qty']) ? $post['created_qty'] : NULL,
          
        ];

     
        $updateCreatedQty = $post['from_hidden_created_qty'] - $post['created_qty'];
        $orderOldDetails = [       
          'status_id' => 1,
            'qty' => $updateCreatedQty,
            'transfer_id'=>$transferId,
            'is_transfer'=>1,
            'status_id' => 1,
            'qty' => $updateCreatedQty,
            'order_id'=>!empty($post['orderId']) ? $post['orderId'] : NULL,
        ];
        $indentOrderStatusOld = [       
          'created_qty' => 1,
          'qty' => $updateCreatedQty,
  
        ];
        
        $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatusOld, 'update', ['order_id' => $post['orderId']]);
        $this->CommonModel->iudAction('tbl_indent_order_status_details', $orderOldDetails, 'insert');
         // indent order new old
         $updateCreatedQty = $post['from_hidden_created_qty'] - $post['created_qty'];
        
        //new 
        $transferCreatedQty = $post['created_qty']; //update prvious qty get and add
        $orderOldDetails = [       
          'status_id' => 1,
          'qty' => $transferCreatedQty,
          'order_id'=>!empty($post['transferToOrderId']) ? $post['transferToOrderId'] : NULL,
          'is_transfer'=>1,
          'transfer_id'=>$transferId
        ];
        $indentOrderStatusOld_1 = [       
          'created_qty' => 1,
          'qty' => $transferCreatedQty,
  
        ];
        $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatusOld_1, 'update', ['order_id' => $post['transferToOrderId']]);
        $this->CommonModel->iudAction('tbl_indent_order_status_details', $orderOldDetails, 'insert');
       
      }


      if (isset($post['blade_in_hand_qty']) && $post['blade_in_hand_qty'] !== '') {
        $transferOrderDetails[] = [
          'transfer_id'=>$transferId,
           'from_indent_status_id' =>2,
           'to_indent_status_id' => 2,
           'from_indent_qty' => isset($post['from_hidden_created_qty']) ? $post['from_hidden_created_qty'] : NULL,
           'to_indent_qty' => isset($post['created_qty']) ? $post['created_qty'] : NULL,
           
         ];


          $updateCreatedQty = $post['from_hidden_created_qty'] - $post['created_qty'];
        $orderOldDetails = [       
          'status_id' => 1,
            'qty' => $updateCreatedQty,
            'transfer_id'=>$transferId,
            'is_transfer'=>1,
            'status_id' => 1,
            'qty' => $updateCreatedQty,
            'order_id'=>!empty($post['orderId']) ? $post['orderId'] : NULL,
        ];
        $indentOrderStatusOld = [       
          'created_qty' => $updateCreatedQty,
        
        ];
        
        $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatusOld, 'update', ['order_id' => $post['orderId']]);
        $this->CommonModel->iudAction('tbl_indent_order_status_details', $orderOldDetails, 'insert');
         // indent order new old
         $updateCreatedQty = $post['from_hidden_created_qty'] - $post['created_qty'];
        
        //new 
        $transferCreatedQty = $post['created_qty']; //update prvious qty get and add
        $orderOldDetails = [       
          'status_id' => 1,
          'qty' => $transferCreatedQty,
          'order_id'=>!empty($post['transferToOrderId']) ? $post['transferToOrderId'] : NULL,
          'is_transfer'=>1,
          'transfer_id'=>$transferId
        ];
        $indentOrderStatusOld_1 = [       
          'created_qty' => 1,
          'qty' => $transferCreatedQty,
  
        ];
        $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatusOld_1, 'update', ['order_id' => $post['transferToOrderId']]);
        $this->CommonModel->iudAction('tbl_indent_order_status_details', $orderOldDetails, 'insert');
       
      }


      if (isset($post['blade_position_qty']) && $post['blade_position_qty'] !== '') {
        $transferOrderDetails[] = [
          'transfer_id'=>$transferId,
           'from_indent_status_id' => 3,
           'to_indent_status_id' => 3,
           'from_indent_qty' => isset($post['from_hidden_created_qty']) ? $post['from_hidden_created_qty'] : NULL,
           'to_indent_qty' => isset($post['created_qty']) ? $post['created_qty'] : NULL,
           
         ];
       
      }

      // Update indent_transfer_qty
      $transferId = $this->CommonModel->iudAction('tbl_indent_order_transfer_details', $transferOrderDetails, 'batch_insert');

     die;
      redirect(base_url('admin/production/ReceivedOrders'));
    }
  }
}


   // echo"<pre>";
      // print_r($getData);
      // $newOrderNo="";
      // $newSequenceNo="";

      // if ($getData) {

      //   if ($getData['order_no'] == "" && $getData['order_sequence'] == "") {
      //       $newOrderNo = $getData['manual_indent_no'] . "-" . 1;
      //       $newSequenceNo = 1;
      //   } else {

      //       $sequenceNo = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $getData['manual_indent_no']], 'MAX(order_sequence) as order_sequence', '', 'row_array');


      //       $orderSequenceNo = !empty($sequenceNo['order_sequence']) ? intval($sequenceNo['order_sequence']) + 1 : 1;
      //       $newSequenceNo = $orderSequenceNo;


      //       $newOrderNo = $getData['manual_indent_no'] . "-" . $newSequenceNo;
      //   }
      // } 

      // die;