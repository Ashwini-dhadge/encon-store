<?php

/**
 * 
 */
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReceivedOrders extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'production/ReceivedOrderModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Received Orders';

    $this->load->view(ADMIN . 'production/receivedOrders/list_Received_order', $data);
  }

  public function listReceivedOrders()
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



    $count = count($this->ReceivedOrderModel->getReceivedOrders($searchVal, 0, 0, 0, 0, 0, $where));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->ReceivedOrderModel->getReceivedOrders($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
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
        // $subIndent = "";
        // if(!empty($value['order_no']))
        // {
        //   $subIndent = $value['order_no'];
        // }else{
        //   $subIndent = "Main Order";
        // }

        array_push($row, $orderFor);
        // array_push($row, (isset($value['indent_id']) ? $value['indent_id'] : ""));    // indent number as a project Number
        // array_push($row, (isset($value['manual_indent_no']) ? $value['manual_indent_no'] . "(". $value['id'] .")" : "")); // manual indent no
        array_push($row, (isset($value['indent_number']) ? $value['indent_number'] : "")); // manual indent no
        array_push($row, (isset($value['manual_indent_no']) ? $value['manual_indent_no'] : "")); // manual indent no
        array_push($row, (isset($value['order_no']) ? $value['order_no'] : "")); // sub manual indent 
        // array_push($row,  $subIndent); // sub manual indent 
        array_push($row, $value['indent_date']);
        array_push($row, $value['company_name']);
        // array_push($row, $value['order_for']);
        array_push($row, '<span class="label label-success">' . $value['blade_qty']  . '</span>');
        array_push($row, '<span class="label custome-received">' . $value['order_qty'] . '</span>');
        array_push($row, (isset($value['created_qty']) ? '<span class="label label-primary">' . $value['created_qty'] . '</span>' : " "));
        array_push($row, (isset($value['blade_in_hand_qty']) ? '<span class="label label-primary">' . $value['blade_in_hand_qty'] . '</span>' : " "));
        // array_push($row, (isset($value['blade_position_qty']) ? '<span class="label label-primary">' . $value['blade_position_qty'] . '</span>' : " "));
        array_push($row, (isset($value['transfer_qty']) ? '<span class="label label-primary">' . $value['transfer_qty'] . '</span>' : " "));
        // array_push($row, (isset($value['indent_transfer_qty']) ? $value['indent_transfer_qty'] : ""));



        $action = '<a href="' . base_url() . 'admin/production/Indent/view_indent_blade/' . $value['id'] . '/' . $value['indent_id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        // $action .= '<a href="javascript:void(0);" title="Transfer Qty" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="transferQty(this)" data-id="' . $value['id'] . '" data-manual-indent-no="' . $value['manual_indent_no'] . '" data-indent-id="' . $value['indent_id'] . '"><i class="fas fa-arrow-right" aria-hidden="true"></i></a>';
        // $action .= '<a href="javascript:void(0);" title="Exchange Quantity" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="interChangeQty(this)" data-id="' . $value['id'] . '"><i class="fas fa-exchange-alt" aria-hidden="true"></i></a>';
        // $action .= '<a href="javascript:void(0);" title="Exchange Quantity" class="btn btn-primary waves-effect waves-light btn-sm transferQty ml-1" data-toggle="tooltip" style="font-size: 13px; background: #F0F0F0; color: gray;" onclick="interChangeQty(this)" data-id="' . $value['id'] . '" data-manual-indent-no="' . $value['manual_indent_no'] . '" data-indent-id="' . $value['indent_id'] . '" data-type="3" data-order-qty ="' . $value['order_qty'] . '" data-blade-size="' . $value['blade_size'] . '" data-atip="' . $value['a_tip'] . '"><i class="fas fa-exchange-alt" aria-hidden="true"></i></a>';
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

    $details = $this->ReceivedOrderModel->indentDetails($data['id']);
    // echo"<pre>";
    // print_r($details);
    // die;
    echo json_encode($details);
  }

  public function orderCreation()
  {
    $company_id = $this->session->userdata('company_id');
    $post = $_POST;
    // echo "<pre>";
    // print_r($post); 
    // die;
    $orderData = [
      'created_qty' => !empty($post['created_qty']) ? $post['created_qty'] : null,
      'blade_in_hand_qty' => !empty($post['blade_in_hand_qty']) ? $post['blade_in_hand_qty'] : null,
      // 'blade_position_qty' => !empty($post['blade_position_qty']) ? $post['blade_position_qty'] : null,
      'company_id' => $company_id,
    ];

    // print_r($orderData);
    $oldData = $this->CommonModel->getData('tbl_indent_order_status', array('order_id' => $post['order_id']), '', '', 'row_array');
    $this->CommonModel->iudAction('tbl_indent_order_status', $orderData, 'update', array('order_id' => $post['order_id']));
    // echo "<pre>";
    // print_r($oldData);
    if (
      $post['created_qty'] != $oldData['created_qty'] ||
      $post['blade_in_hand_qty'] != $oldData['blade_in_hand_qty']
      // ||$post['blade_position_qty'] != $oldData['blade_position_qty']
    ) {

      $statusDetails = [];

      if ($post['created_qty'] != $oldData['created_qty']) {
        $statusDetails[] = [
          'order_id' => $post['order_id'],
          'status_id' => $post['created_status'],
          'qty' => $post['created_qty'],
          'remark' => $post['createQtyRemark'],
          'created_by' => userId(),
          'company_id' => $company_id,
        ];
      }

      if ($post['blade_in_hand_qty'] != $oldData['blade_in_hand_qty']) {
        $statusDetails[] = [
          'order_id' => $post['order_id'],
          'status_id' => $post['blade_in_hand_status'],
          'qty' => $post['blade_in_hand_qty'],
          'remark' => $post['bladeHandRemark'],
          'created_by' => userId(),
          'company_id' => $company_id,
        ];
      }

      // if ($post['blade_position_qty'] != $oldData['blade_position_qty']) {
      //   $statusDetails[] = [
      //     'order_id' => $post['order_id'],
      //     'status_id' => $post['blade_position_status'],
      //     'qty' => $post['blade_position_qty'],
      //     'remark' => $post['bladePositionRemark'],
      //     'created_by' => userId(),
      //     'company_id' => $company_id,
      //   ];
      // }

      // Print the details for debugging
      // print_r($statusDetails);

      foreach ($statusDetails as $details) {
        if ($details['qty'] > 0) {
          $this->CommonModel->iudAction('tbl_indent_order_status_details', $details, 'insert');
        }
      }
    }

    $this->session->set_flashdata('success', 'Order Status updated Succesfully');

    echo json_encode([
      'status' => 'success',
      'message' => 'Order Status updated successfully!'
    ]);
  }


  public function transferOrder()
  {
    $company_id = $this->session->userdata('company_id');
    $post = $_POST;
    // echo"<pre>";
    // print_r($post);
    $olddata = $this->CommonModel->getData('tbl_indent_order_status', ['order_id' => $post['order_id']], '', '', 'row_array');
    $updateTransferQty = $olddata['transfer_qty'] + $post['transfer_qty'];
    $blade_in_hand_qty = $olddata['blade_in_hand_qty'] - $post['transfer_qty'];

    if ($blade_in_hand_qty == 0) {
      $blade_in_hand_qty = null;
    }

    $data = [
      // 'order_qty' => $updateReceivedQty,
      // 'blade_position_qty' => $updateBladePostionQty,
      'transfer_qty' =>  $updateTransferQty,
      'company_id' => $company_id,
      'blade_in_hand_qty' => $blade_in_hand_qty
    ];
    $this->CommonModel->iudAction('tbl_indent_order_status', $data, 'update', ['order_id' => $post['order_id']]);
    // print_r($data);

    $statusData = [
      'order_id' => $post['order_id'],
      'status_id' => $post['status'],
      'qty' => $post['transfer_qty'],
      'created_by' => userId(),
      'company_id' => $company_id,
    ];
    $this->CommonModel->iudAction('tbl_indent_order_status_details', $statusData, 'insert');
    // print_r($statusData);
    // die;
    $this->session->set_flashdata('success', 'Order Succesfully Transfer to next plant!');

    echo json_encode([
      'status' => 'success',
      'message' => 'Order Succesfully Transfer to next plant!!'
    ]);
  }

  public function bladeStatusReport()
  {
    $details = $this->ReceivedOrderModel->getBladeStockReport();
    // echo"<pre>";
    // print_r($details);
    // die;
    $company_id = $this->session->userdata('company_id');
    // print_r($company_id);die;
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Blade_Finishing_Status_Report.xlsx"');

    $spreadsheet = new Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();
    $headers = [
      'Location',
      'Date Of Indent.',

      'Name of Party',
      'FAN DIA (feet)',
      'Size Of Mould M.M',
      'Size Of Blade M.M',
      'HUB SIZE',
      'A.Tip (mm)',
      'Punching No.',
      'Way',
      'Set',
      'Total Blade Qty.',
      'Receipt Qty.',
      'For Gap checking',
      'For Primer',
      'For Filler',
      'For putty',
      'For TOP coat',
      'For Balancing',
      'For Packing',
      'Dispatch Qty',

    ];


    $column = 'A';
    foreach ($headers as $header) {
      $cell = $column . '1';
      $activeWorksheet->setCellValue($cell, $header);
      $style = $activeWorksheet->getStyle($cell);
      $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

      $alignment = $style->getAlignment();
      $alignment->setWrapText(true);
      $alignment->setHorizontal(Alignment::HORIZONTAL_LEFT);
      $alignment->setVertical(Alignment::VERTICAL_TOP);


      $headerStyle = $activeWorksheet->getStyle($cell);
      $headerStyle->getFill()->setFillType(Fill::FILL_SOLID);
      // $headerStyle->getFill()->getStartColor()->setARGB('009999');
      $headerStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
      $headerStyle->getAlignment()->setWrapText(true);

      $headerStyle->getAlignment()->setVertical(Alignment::HORIZONTAL_CENTER);


      $column++;
    }

    if (!empty($details)) {
      $row = 2;
      foreach ($details as $detail) {
        $column = 'A';

        $activeWorksheet->setCellValue($column . $row,  $detail['location_name']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['indent_date']);
        $column++;

        $activeWorksheet->setCellValue($column . $row,  $detail['company_name']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['fan_dia_feet']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['mould_size']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['blade_size']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['hub_size']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['a_tip']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['blade_punching_no']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['way']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['order_set']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['blade_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['order_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['gap_checking_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['primer_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['filler_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['putty_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['top_coat_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['balancing_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['packing_qty']);
        $column++;
        $activeWorksheet->setCellValue($column . $row,  $detail['dispatch_qty']);
        $column++;

        $row++;
      }
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
  }
}
