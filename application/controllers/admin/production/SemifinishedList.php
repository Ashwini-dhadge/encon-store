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
        array_push($row, (isset($value['order_no']) ? $value['order_no'] : ""));
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




        $action = '<a href="' . base_url() . 'admin/production/Indent/view_indent_blade/' . $value['id'] . '/' .$value['indent_id']. '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        // $action .= '<a href="javascript:void(0);" title="Transfer Qty" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="transferQty(this)" data-id="' . $value['id'] . '" data-manual-indent-no="' . $value['manual_indent_no'] . '" data-indent-id="' . $value['indent_id'] . '"><i class="fas fa-arrow-right" aria-hidden="true"></i></a>';
        // $action .= '<a href="javascript:void(0);" title="Exchange Quantity" class="btn btn-primary waves-effect waves-light btn-sm  ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="interChangeQty(this)" data-id="' . $value['id'] . '" data-manual-indent-no="' . $value['manual_indent_no'] . '" data-indent-id="' . $value['indent_id'] . '" data-type="3" data-order-qty ="' . $value['order_qty'] . '" data-blade-size="' . $value['blade_size'] . '" data-atip="' . $value['a_tip'] . '"><i class="fas fa-exchange-alt" aria-hidden="true"></i></a>';

        // interChangeQty
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
    $interChangeType = $this->input->post('interChangeType'); // For the InterChange Qty type is 3.
    $orderQty = $this->input->post('orderQty');
    $bladeSize = $this->input->post('bladeSize');
    $aTip = $this->input->post('aTip');
    // print_r($type);die;
    if ($orderId && $manualIndentNo) {
      $data['orderId'] = $orderId;
      $data['type'] = $type;
      $data['manualIndentNo'] = $manualIndentNo;
      $data['interChangeType'] = $interChangeType;
      $data['orderQty'] = $orderQty;
      $data['bladeSize'] = $bladeSize;
      $data['aTip'] = $aTip;
      $getIndentOrder = $this->CommonModel->getData('tbl_indent_order', ['id' => $orderId], 'mould_size,order_no', '', 'row_array');
      $getOrderStatus = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $orderId], 'created_qty,blade_in_hand_qty,blade_position_qty,transfer_qty,gap_checking_qty,primer_qty,filler_qty,putty_qty,top_coat_qty,balancing_qty,packing_qty,', '', 'row_array');
      $data['mould_size'] = $getIndentOrder['mould_size'];
      $data['order_no'] = $getIndentOrder['order_no'];
      $data['orderStatus'] = $getOrderStatus;
      // echo"<pre>";
      // print_r($getIndentOrder);die;
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
  public function interChnageQty()
  {
    
    // echo"<pre>";
    // print_r($_POST);die;
    $orderId = $this->input->post('id');
    // $manualIndentNo = $this->input->post('manual_indent_no');
    $type = $this->input->post('type');  // 1 for Encon Received Order. 2 for Balaji plant Semifinished Stage.
    $interChangeType = $this->input->post('interChangeType'); // For the InterChange Qty type is 3.
    // $orderQty = $this->input->post('orderQty');
    // $bladeSize = $this->input->post('bladeSize');
    // $aTip = $this->input->post('aTip');
    // print_r($type);die;
    if ($orderId ) {
      $data['orderId'] = $orderId;
      $data['type'] = $type;
      // $data['manualIndentNo'] = $manualIndentNo;
      $data['interChangeType'] = $interChangeType;
      // $data['orderQty'] = $orderQty;
      // $data['bladeSize'] = $bladeSize;
      // $data['aTip'] = $aTip;
      $getIndentOrder = $this->CommonModel->getData('tbl_indent_order', ['id' => $orderId], 'indent_id,manual_indent_no,mould_size,order_no,a_tip,blade_size,order_qty', '', 'row_array');
      // echo"<pre>";
      // print_r($getIndentOrder);die;
      $getOrderStatus = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $orderId], 'created_qty,blade_in_hand_qty,blade_position_qty,transfer_qty,gap_checking_qty,primer_qty,filler_qty,putty_qty,top_coat_qty,balancing_qty,packing_qty,', '', 'row_array');
      $data['manualIndentNo'] = $getIndentOrder['manual_indent_no'];
      $data['mould_size'] = $getIndentOrder['mould_size'];
      $data['order_no'] = $getIndentOrder['order_no'];
      $data['bladeSize'] = $getIndentOrder['blade_size'];
      $data['aTip'] = $getIndentOrder['a_tip'];
      $data['orderQty'] = $getIndentOrder['order_qty'];
      $data['orderStatus'] = $getOrderStatus;
      // echo"<pre>";
      // print_r($getIndentOrder);die;
    }
    // print_r($data);die;
    $html = $this->load->view(ADMIN . "production/semiFinishedLists/interChangeQtyModal", $data, true);
    // print_r($html);
    // die;
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
    $manualIndentNo = isset($_GET['manualIndentNo']) ? $_GET['manualIndentNo'] : '';
    $interChange = isset($_GET['interChange']) ? $_GET['interChange'] : '';
    $orderQuty = isset($_GET['orderQuty']) ? $_GET['orderQuty'] : '';
    $bladeSize = isset($_GET['bladeSize']) ? $_GET['bladeSize'] : '';
    $aTip = isset($_GET['aTip']) ? $_GET['aTip'] : '';


    $mouldData = $this->SemiFinishedModel->getMouldSize($searchTerm, $mouldsize, $orderId, $type,$manualIndentNo,$interChange,$bladeSize,$aTip);
  //  echo $this->db->last_query();die;

    foreach ($mouldData as $key => $value) {
      $json[] = ['id' => $value['manual_indent_no'], 'text' => $value['manual_indent_no']]; // modified
      // $json[] = ['id' => $value['manual_indent_no'], 'text' => $value['manual_indent_no'] . "(" . $value['id'] . ")"]; //original 
      // $json[] = ['id' => $value['manual_indent_no'], 'text' => $value['manual_indent_no']. "(" .'123' . ")"]; //original 
    }


    echo json_encode($json);
  }

  public function listSubIndent()
  {
    $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
    $manualIndentNo = isset($_GET['manualIndentNo']) ? $_GET['manualIndentNo'] : '';
    $mouldsize = isset($_GET['mouldsize']) ? $_GET['mouldsize'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $interChange = isset($_GET['interChange']) ? $_GET['interChange'] : '';
    $orderQuty = isset($_GET['orderQuty']) ? $_GET['orderQuty'] : '';
    $bladeSize = isset($_GET['bladeSize']) ? $_GET['bladeSize'] : '';
    $aTip = isset($_GET['aTip']) ? $_GET['aTip'] : '';
    $mouldData = $this->SemiFinishedModel->getsubIndent($searchTerm, $manualIndentNo,$mouldsize,$type,$interChange,$bladeSize,$aTip);
    // echo $this->db->last_query();die;
    $json =[];
    foreach ($mouldData as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['order_no']]; // modified

    }
    echo json_encode($json);
  }


  public function transferOrder()
  {
    $post = $_POST;
    // echo "<pre>";
    // print_r($post);
    // die;
    // echo "<br>";
    $whereCondition = [];
    $updateIndentOrderStatus = [];
    $transferOrderDetails = [];
    $transferIndentOrder = [];
    $indentStatusDetails = [];

    // if ($post['type'] == 1) {


    $total_transfer_qty = 0;
    $fortotal_transfer_qty = [];

    $totalNewOrderQty = 0;

    // transfer  insert
    $transferOrder = array(
      'from_indent_id' => !empty($post['fromManualIndentNo']) ? $post['fromManualIndentNo'] : NULL,
      'to_indent_id' => !empty($post['transferToManualIndnetNo']) ? $post['transferToManualIndnetNo'] : NULL,
      'from_order_id' => !empty($post['orderId']) ? $post['orderId'] : NULL,
      'to_order_id' => !empty($post['transferToOrderId']) ? $post['transferToOrderId'] : NULL,
      'created_at' => date('Y-m-d H:i:s'),
      'created_by' => userId(),
    );

    $transferId = $this->CommonModel->iudAction('tbl_indent_order_transfer', $transferOrder, 'insert');

    $status_master_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    $status_master__label_array = array('created_qty', 'blade_in_hand_qty', 'blade_position_qty', 'gap_checking_qty', 'primer_qty', 'filler_qty', 'putty_qty', 'top_coat_qty', 'balancing_qty', 'packing_qty');

    foreach ($status_master_array as $key => $status_id) {

      $from_hidden_status_id = isset($post['from_hidden_' . $status_id]) ? $post['from_hidden_' . $status_id] : NULL;
      $status_id_qty = isset($post[$status_id . '_qty']) ? $post[$status_id . '_qty'] : NULL;
      // echo"status_id_qty";
      // print_r($status_id_qty);
      // die;
      // array_push($fortotal_transfer_qty, $status_id_qty);

      $lbel = $status_master__label_array[$key];
      if (isset($status_id_qty) && $status_id_qty !== '') {

        $totalNewOrderQty = $totalNewOrderQty + $status_id_qty;

        $transferOrderDetails[] = [
          'transfer_id' => $transferId,
          'from_indent_status_id' => $status_id,
          'to_indent_status_id' => $status_id,
          'from_indent_qty' => $from_hidden_status_id,
          'to_indent_qty' => $status_id_qty,
        ];


        $updateCreatedQty =   $from_hidden_status_id - $status_id_qty;
        if ($updateCreatedQty !== 0) {
          $orderOldDetails = [

            'order_id' => !empty($post['orderId']) ? $post['orderId'] : NULL,
            'qty' => $updateCreatedQty,
            'status_id' => $status_id,
            'is_transfer' => 1,
            'transfer_id' => $transferId,
          ];

          // $fortotal_transfer_qty.array_push($status_id_qty);
          $this->CommonModel->iudAction('tbl_indent_order_status_details', $orderOldDetails, 'insert');
        }

        $total_transfer_qty += $status_id_qty;

        $data = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $post['orderId']], 'indent_transfer_qty', '', 'row_array');

        if (!empty($data) && isset($data['indent_transfer_qty']) && $data['indent_transfer_qty'] !== 0) {
          $total_transfer_qty += $data['indent_transfer_qty'];
        }


        $indentOrderStatusOld = [
          'indent_transfer_qty' => $total_transfer_qty,
          $lbel => $updateCreatedQty,
        ];

        $update =  $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatusOld, 'update', ['order_id' => $post['orderId']]);
        if ($update) {
          $total_transfer_qty = 0;
        }
        // indent order new old
        $updateCreatedQty =  $from_hidden_status_id - $status_id_qty;

        //new 
        //  echo"<pre>";
        //  print_r($data); 
        // die;
        $transferCreatedQty = $status_id_qty;
        $updatetransferCreatedQty = $status_id_qty; //update prvious qty get and add
        $prevQty = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $post['transferToOrderId']], 'created_qty,blade_in_hand_qty,blade_position_qty', '', 'row_array');
        if (!empty($prevQty) && isset($prevQty[$lbel]) && $prevQty[$lbel] !== 0) {
          $updatetransferCreatedQty += $prevQty[$lbel];
        }
        if ($transferCreatedQty !== 0) {
          $orderOldDetails = [
            'status_id' => $status_id,
            'qty' => $transferCreatedQty,
            'order_id' => !empty($post['transferToOrderId']) ? $post['transferToOrderId'] : NULL,
            'is_transfer' => 1,
            'transfer_id' => $transferId
          ];

          $this->CommonModel->iudAction('tbl_indent_order_status_details', $orderOldDetails, 'insert');
        }
        $indentOrderStatusOld_1 = [
          $lbel =>  $updatetransferCreatedQty,

        ];
        $this->CommonModel->iudAction('tbl_indent_order_status', $indentOrderStatusOld_1, 'update', ['order_id' => $post['transferToOrderId']]);
      }
    }
    // print_r($totalNewOrderQty);


    // Update indent_transfer_qty
    $transferId = $this->CommonModel->iudAction('tbl_indent_order_transfer_details', $transferOrderDetails, 'batch_insert');
    $getData = $this->CommonModel->getData('tbl_indent_order', ['id' => $post['orderId']], '*', '', 'row_array');



    $sequenceNo = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $getData['manual_indent_no']], 'MAX(order_sequence) as order_sequence', '', 'row_array');


    $newSequenceNo = !empty($sequenceNo['order_sequence']) ? intval($sequenceNo['order_sequence']) + 1 : 1;


    $newOrderNo = $getData['manual_indent_no'] . "-" . $newSequenceNo;


    if (isset($totalNewOrderQty) && $totalNewOrderQty !== 0) {
      $data = array(
        'order_for' => isset($getData['order_for']) ? $getData['order_for'] : '',
        'indent_date' => isset($getData['indent_date']) ? $getData['indent_date'] : '',
        'delivery_date' => isset($getData['delivery_date']) ? $getData['delivery_date'] : '',
        'indent_id' => isset($getData['indent_id']) ? $getData['indent_id'] : '',
        'manual_indent_no' => isset($getData['manual_indent_no']) ? $getData['manual_indent_no'] : '',
        'order_no' => $newOrderNo,
        'order_sequence' => $newSequenceNo,
        'fan_dia_feet' => isset($getData['fan_dia_feet']) ? $getData['fan_dia_feet'] : '',
        'mould_size' => isset($getData['mould_size']) ? $getData['mould_size'] : '',
        'hub_size' => isset($getData['hub_size']) ? $getData['hub_size'] : '',
        'blade_size' => isset($getData['blade_size']) ? $getData['blade_size'] : '',
        'blade_qty' => isset($getData['blade_qty']) ? $getData['blade_qty'] : '',
        'blade_punching_no' => isset($getData['blade_punching_no']) ? $getData['blade_punching_no'] : '',
        'a_tip' => isset($getData['a_tip']) ? $getData['a_tip'] : '',
        'color' => isset($getData['color']) ? $getData['color'] : '',
        'name_plate' => isset($getData['name_plate']) ? $getData['name_plate'] : '',
        'way' => isset($getData['way']) ? $getData['way'] : '',
        'order_set' => isset($getData['order_set']) ? $getData['order_set'] : '',
        'blade_qty' => isset($getData['blade_qty']) ? $getData['blade_qty'] : '',
        'order_qty' =>  $totalNewOrderQty,
        'created_by' => userId(),
      );
      // echo"<pre>";
      // print_r($data);
      // die;
      $result =  $this->CommonModel->iudAction('tbl_indent_order', $data, 'insert', '');

      if ($result) {
        $data = array(
          "order_id" => $result,
          'status_id' => 13,
          'qty' => $totalNewOrderQty,
          'created_by' => userId(),
        );
        $this->CommonModel->iudAction('tbl_indent_order_status_details', $data, 'insert', '');

        $data2 = array(
          "order_id" => $result,
          'qty' => isset($getData['blade_qty']) ? $getData['blade_qty'] : '',
          'order_qty' => $totalNewOrderQty,
        );
        $this->CommonModel->iudAction('tbl_indent_order_status', $data2, 'insert', '');
      }
    }
    //  die;
    redirect(base_url('admin/production/ReceivedOrders'));
    // }  // type 1 if closed
  }


  public function addInterChangeStatus() {
    // print_r($_POST);die;
    $post = $_POST;
    // $data = [];
    $data1 = $this->CommonModel->getData('tbl_indent_order_status',['order_id'=>$post['orderId']],'*','','row_array');
    $data2 = $this->CommonModel->getData('tbl_indent_order',['id'=>$post['orderId']],'order_no','','row_array');
    //  $combinedData = array_merge($data1, $data2);

    // Output the combined data for debugging
    // echo "<pre>";
    // print_r($combinedData);
    // echo "</pre>";
    // $result = array_combine($data1,$data2);
    
    echo json_encode(array_merge($data1, $data2));
  }
}
