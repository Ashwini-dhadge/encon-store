<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * 
 */
class Indent extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'production/IndentModel');
    $this->load->model(ADMIN . 'production/ReceivedOrderModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Indent';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 1), 'id,indent_name');
    //  print_r($data['indent_name']);die;
    $this->load->view(ADMIN . 'production/list_indent', $data);
  }


  public function listblade_indent()
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

    if ($data['indentid'] == "all") {
      $where = array();
    } else {
      $where['tid.master_indent_id'] = $data['indentid'];
    }

    $count = count($this->IndentModel->getBladeIndentData($searchVal, 0, 0, 0, 0, 0, $where));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->IndentModel->getBladeIndentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
      // echo"<pre>";
      // print_r($result);die;

      foreach ($result as $key => $value) {
        $total = $this->IndentModel->getSum($value['indent_no']);
        // echo"<pre>";
        // print_r($total);
        // $bladeQty = $this->IndentModel->getBlade($value['indent_no']);
        // $bladeQty = $this->CommonModel->getData('tbl_indent_order',['indent_id'=>$value['indent_no']],'blade_qty','','result_array');
        // print_r($bladeQty);
        // echo $this->db->last_query();die;
        //   echo"<pre>";
        // print_r($total);

         $row = [];
        $checkbox = '
          <input type="checkbox"
          class="blade_checkbox"
          name="selected_rows[]"
          value="' . $value['indent_no'] . '">
          ';
        array_push($row, $checkbox);

        array_push($row, $offset + ($key + 1));
        array_push($row, $value['client_name']);
        array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['indent_number']);
        array_push($row, $value['date']);


        $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";



        $check_exist1 = $this->CommonModel->getData('tbl_indent_order', array('indent_id' => $value['indent_no']), '', '', 'num_rows');
        $checkSameQuantity = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $value['indent_number']], 'SUM(order_qty) as totalOrderQty,blade_qty', '', 'result_array');
        // print_r($checkSameQuantity);die;
        if ($check_exist1) {
          $action = ' <a href="' . base_url() . 'admin/production/Indent/view_indent_blade2/' . $value['indent_no'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        } else {
          $action = '';
        }

        $action .= '
        <a href="' . base_url() . 'admin/production/Indent/exportpdf_blade/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
              title="Export PDF" class="btn btn-primary waves-effect waves-light btn-sm" target="_blank">
              <i class="fas fa-file-pdf"></i>
            </a>

            <a href="' . base_url() . 'admin/production/Indent/exportexcel_blade/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
              title="Export Excel" class="btn btn-success waves-effect waves-light btn-sm" target="_blank">
              <i class="fas fa-file-excel"></i>
            </a>

        <a onclick="return " href="' . base_url() . 'admin/production/Indent/CreateOrderforBladeb/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" title="Create Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-check-square" aria-hidden="true"></i></a>
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



  public function listindent($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $indent_name = $this->IndentModel->getIndentName('');
    } else {
      $search = $_GET['searchTerm'];
      $indent_name = $this->IndentModel->getIndentName($search);
    }
    $json[] = ['id' => 'all', 'text' => 'Select All'];
    foreach ($indent_name as $key => $value) {
      $json[] = ['id' => $value['id'], 'text' => $value['indent_name']];
    }

    echo json_encode($json);
  }



  public function CreateOrderforBladeb($id = "", $blade_indent_id = "", $indent_no = "")
  {
    $company_id = $this->session->userdata('company_id');
    if ($_POST) {
      $post = $_POST;
      // echo"<pre>";
      // print_r($post);die;
      // die;
      if ($post['order_for'] == "2") {
        $data = array(
          'order_for' => isset($post['order_for']) ? $post['order_for'] : '',
          'indent_date' => isset($post['indent_date']) ? $post['indent_date'] : '',
          'delivery_date' => isset($post['delivery_date']) ? $post['delivery_date'] : '',
          'indent_id' => isset($post['indent_id']) ? $post['indent_id'] : '',
          'manual_indent_no' => isset($post['manual_indent_no']) ? $post['manual_indent_no'] : '',
          'mould_size' => isset($post['mould_size']) ? $post['mould_size'] : '',
          'blade_size' => isset($post['blade_size']) ? $post['blade_size'] : '',
          'hub_size' => isset($post['hub_size']) ? $post['hub_size'] : '',
          'clamp_size' => isset($post['clamp_size']) ? $post['clamp_size'] : '',
          'collor_length' => isset($post['collor_length']) ? $post['collor_length'] : '',
          'clamp_length' => isset($post['clamp_length']) ? $post['clamp_length'] : '',
          'collor_hub_dist' => isset($post['collor_hub_dist']) ? $post['collor_hub_dist'] : '',
          'fan_dia_mm' => isset($post['fan_dia_mm']) ? $post['fan_dia_mm'] : '',
          'fan_dia_ft' => isset($post['fan_dia_ft']) ? $post['fan_dia_ft'] : '',
          'blade_qty' => isset($post['blade_qty']) ? $post['blade_qty'] : '',
          'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          'core' => isset($post['core']) ? $post['core'] : '',
          'way' => isset($post['way']) ? $post['way'] : '',
          'order_set' => isset($post['order_set']) ? $post['order_set'] : '',
          'a_tip' => isset($post['a_tip']) ? $post['a_tip'] : '',
          'blade_punching_no' => isset($post['blade_punching_no']) ? $post['blade_punching_no'] : '',
          'remark' => isset($post['remark']) ? $post['remark'] : '',
          'type' => isset($post['type']) ? $post['type'] : '',
          'created_by' => userId(),

        );


        // echo"<pre>";
        // print_r($data);
        // die;
        $result = $this->CommonModel->iudAction('tbl_indent_order', $data, 'insert', '');
        // echo"<pre>";
        // print_r($result);
        $getData = $this->CommonModel->getData('tbl_indent_order', ['id' => $result], '*', '', 'row_array');

        $sequenceNo = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $getData['manual_indent_no']], 'MAX(order_sequence) as order_sequence', '', 'row_array');

        $newSequenceNo = !empty($sequenceNo['order_sequence']) ? intval($sequenceNo['order_sequence']) + 1 : 1;


        $newOrderNo = $getData['manual_indent_no'] . "-" . $newSequenceNo;
        if ($result) {
          $data = array(
            "order_id" => $result,
            'status_id' => 13,
            'qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
            'created_by' => userId(),
            'company_id' => $company_id,
          );
          $this->CommonModel->iudAction('tbl_indent_order_status_details', $data, 'insert', '');

          $data2 = array(
            "order_id" => $result,
            'qty' => isset($post['blade_qty']) ? $post['blade_qty'] : '',
            'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
            'company_id' => $company_id,
          );
          $this->CommonModel->iudAction('tbl_indent_order_status', $data2, 'insert', '');
        }
        $this->session->set_flashdata('success', 'Encon Order Added Succesfully!');
        redirect(base_url(ADMIN . 'production/Indent'));
      } elseif ($post['order_for'] == "1") {

        // $post = $_POST;
        // echo"<pre>";
        // print_r($post);die;
        $data = array(
          'order_for' => isset($post['order_for']) ? $post['order_for'] : '',
          'indent_date' => isset($post['indent_date']) ? $post['indent_date'] : '',
          'delivery_date' => isset($post['dispatch_date']) ? $post['dispatch_date'] : '',
          'party_id' => isset($post['party_id']) ? $post['party_id'] : '',
          'indent_id' => isset($post['indent_id']) ? $post['indent_id'] : '',
          'manual_indent_no' => isset($post['manual_indent_no']) ? $post['manual_indent_no'] : '',
          'fan_dia_feet' => isset($post['fan_dia_feet']) ? $post['fan_dia_feet'] : '',
          'mould_size' => isset($post['mould_size']) ? $post['mould_size'] : '',
          'blade_size' => isset($post['blade_size']) ? $post['blade_size'] : '',
          'hub_size' => isset($post['hub_size']) ? $post['hub_size'] : '',
          'clamp_size' => isset($post['clamp_size']) ? $post['clamp_size'] : '',
          'collor_length' => isset($post['collor_length']) ? $post['collor_length'] : '',
          'clamp_length' => isset($post['clamp_length']) ? $post['clamp_length'] : '',
          'collor_hub_dist' => isset($post['collor_hub_dist']) ? $post['collor_hub_dist'] : '',
          'fan_dia_mm' => isset($post['fan_dia_mm']) ? $post['fan_dia_mm'] : '',
          'fan_dia_ft' => isset($post['fan_dia_ft']) ? $post['fan_dia_ft'] : '',
          'blade_qty' => isset($post['blade_qty']) ? $post['blade_qty'] : '',
          'blade_punching_no' => isset($post['blade_punching_no']) ? $post['blade_punching_no'] : '',
          'a_tip' => isset($post['a_tip']) ? $post['a_tip'] : '',
          'color' => isset($post['color']) ? $post['color'] : '',
          'name_plate' => isset($post['name_plate']) ? $post['name_plate'] : '',
          'way' => isset($post['way']) ? $post['way'] : '',
          'order_set' => isset($post['order_set']) ? $post['order_set'] : '',
          'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          'created_by' => userId(),
        );
        // echo"<pre>";
        // print_r($data);die;
        $result = $this->CommonModel->iudAction('tbl_indent_order', $data, 'insert', '');
        // echo"<pre>";
        // print_r($result);
        // die;


        $getData = $this->CommonModel->getData('tbl_indent_order', ['id' => $result], '*', '', 'row_array');


        $sequenceNo = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $getData['manual_indent_no']], 'MAX(order_sequence) as order_sequence', '', 'row_array');


        $newSequenceNo = isset($sequenceNo['order_sequence']) ? intval($sequenceNo['order_sequence']) + 1 : 0;


        $newOrderNo = $getData['manual_indent_no'] . ($newSequenceNo > 0 ? '-' . $newSequenceNo : '');


        $updateData = [
          'order_no' => $newOrderNo,
          'order_sequence' => $newSequenceNo,
          'manual_indent_no' => isset($post['manual_indent_no']) ? $post['manual_indent_no'] : '',
          'indent_id' => isset($post['indent_id']) ? $post['indent_id'] : '',
        ];

        $updateIndent = $this->CommonModel->iudAction('tbl_indent_order', $updateData, 'update', ['id' => $result]);


        if ($result) {
          $data = array(
            "order_id" => $result,
            'status_id' => 13,
            'qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
            'created_by' => userId(),
          );
          $this->CommonModel->iudAction('tbl_indent_order_status_details', $data, 'insert', '');

          $data2 = array(
            "order_id" => $result,
            'qty' => isset($post['total_blade_qty']) ? $post['total_blade_qty'] : '',
            'order_qty' => isset($post['order_qty']) ? $post['order_qty'] : '',
          );
          $this->CommonModel->iudAction('tbl_indent_order_status', $data2, 'insert', '');
        }

        $this->session->set_flashdata('success', 'Encon Order Added Succesfully!');
        redirect(base_url(ADMIN . 'production/Indent'));
      }
    }
    $blade = $this->IndentModel->indentDetails($id, $blade_indent_id);
    $order = $this->IndentModel->getOrderQty($indent_no);
    // echo $this->db->last_query();
    // print_r($order);die;
    // echo"<pre>";
    // print_r($blade);die;
    //  echo $this->db->last_query();die;
    $data['blade_data'] = $blade[0];
    $data['type'] = "1";
    $data['orderQty'] = $order['orderQty'];
    //  echo "<pre>";print_r( $data['blade_data']);die;
    $this->load->view(ADMIN . 'production/add_indentfor_blade_balaji', $data);
  }

  public function exportpdf_blade($indent_id, $indent_bland_id, $indent_no)
  {
    $data['indent_details'] = $this->IndentModel->getBladeExportIndentDetails($indent_no);

    $html = $this->load->view(
      'admin/production/pdf/blade_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    $pdf->stream(
      'BLADE_' . $indent_no . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function exportexcel_blade($indent_id, $indent_bland_id, $indent_no){
    $details = $this->IndentModel->getBladeExportIndentDetails($indent_no);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'MOULD SIZE',
      'F1' => 'BLADE SIZE',
      'G1' => 'HUB SIZE',
      'H1' => 'CLAMP SIZE',
      'I1' => 'COLLOR LENGTH',
      'J1' => 'CLAMP LENGTH',
      'K1' => 'COLOR HUB DIST',
      'L1' => 'FAN DIA (MM)',
      'M1' => 'FAN DIA (FT)',
      'N1' => 'BLADE QTY',
      'O1' => 'BLADE PUNCHING NO.',
      'P1' => 'A TIP',
      'Q1' => 'COLOR',
      'R1' => 'NAME PLATE',
      'S1' => 'SET',
      'T1' => 'WAY',
      'U1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:U1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);
    $row = 2;
    $sr = 1;

    foreach ($details as $value) {
      $sheet->setCellValue('A' . $row, $sr);
      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );
      $sheet->setCellValue('C' . $row, !empty($value['indent_date']) ? $value['indent_date'] : '-');
      $sheet->setCellValue('D' . $row, !empty($value['client_name']) ? $value['client_name'] : '-');
      $sheet->setCellValue('E' . $row, !empty($value['mould_size']) ? $value['mould_size'] : '-');
      $sheet->setCellValue('F' . $row, !empty($value['blade_size']) ? $value['blade_size'] : '-');
      $sheet->setCellValue('G' . $row, !empty($value['hub_size']) ? $value['hub_size'] : '-');
      $sheet->setCellValue('H' . $row, !empty($value['clamp_size']) ? $value['clamp_size'] : '-');
      $sheet->setCellValue('I' . $row, !empty($value['collor_length']) ? $value['collor_length'] : '-');
      $sheet->setCellValue('J' . $row, !empty($value['clamp_length']) ? $value['clamp_length'] : '-');
      $sheet->setCellValue('K' . $row, !empty($value['collor_hub_dist']) ? $value['collor_hub_dist'] : '-');
      $sheet->setCellValue('L' . $row, !empty($value['fan_dia_mm']) ? $value['fan_dia_mm'] : '-');
      $sheet->setCellValue('M' . $row, !empty($value['fan_dia_ft']) ? $value['fan_dia_ft'] : '-');
      $sheet->setCellValue('N' . $row, !empty($value['blade_qty']) ? $value['blade_qty'] : '-');
      $sheet->setCellValue('O' . $row, !empty($value['blade_punching_no']) ? $value['blade_punching_no'] : '-');
      $sheet->setCellValue('P' . $row, !empty($value['a_tip']) ? $value['a_tip'] : '-');
      $sheet->setCellValue('Q' . $row, !empty($value['color']) ? $value['color'] : '-');
      $sheet->setCellValue('R' . $row, !empty($value['name_plate']) ? $value['name_plate'] : '-');
      $sheet->setCellValue('S' . $row, !empty($value['set']) ? $value['set'] : '-');
      $sheet->setCellValue('T' . $row, !empty($value['way']) ? $value['way'] : '-');
      $sheet->setCellValue('U' . $row, !empty($value['delivery_date']) ? $value['delivery_date'] : '-');
    

      $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'U') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'BLADE_SELECTED_' . date('YmdHis') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }

  public function export_selected_blade_excel(){
    $ids = $this->input->get('ids');

    $indentNos = explode(',', $ids);

    $details =
      $this->IndentModel
      ->getBladeExportIndentDetailsSelected($indentNos);


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'MOULD SIZE',
      'F1' => 'BLADE SIZE',
      'G1' => 'HUB SIZE',
      'H1' => 'CLAMP SIZE',
      'I1' => 'COLLOR LENGTH',
      'J1' => 'CLAMP LENGTH',
      'K1' => 'COLOR HUB DIST',
      'L1' => 'FAN DIA (MM)',
      'M1' => 'FAN DIA (FT)',
      'N1' => 'BLADE QTY',
      'O1' => 'BLADE PUNCHING NO.',
      'P1' => 'A TIP',
      'Q1' => 'COLOR',
      'R1' => 'NAME PLATE',
      'S1' => 'SET',
      'T1' => 'WAY',
      'U1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:U1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);
    $row = 2;
    $sr = 1;

    foreach ($details as $value) {
      $sheet->setCellValue('A' . $row, $sr);
      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );
      $sheet->setCellValue('C' . $row, !empty($value['indent_date']) ? $value['indent_date'] : '-');
      $sheet->setCellValue('D' . $row, !empty($value['client_name']) ? $value['client_name'] : '-');
      $sheet->setCellValue('E' . $row, !empty($value['mould_size']) ? $value['mould_size'] : '-');
      $sheet->setCellValue('F' . $row, !empty($value['blade_size']) ? $value['blade_size'] : '-');
      $sheet->setCellValue('G' . $row, !empty($value['hub_size']) ? $value['hub_size'] : '-');
      $sheet->setCellValue('H' . $row, !empty($value['clamp_size']) ? $value['clamp_size'] : '-');
      $sheet->setCellValue('I' . $row, !empty($value['collor_length']) ? $value['collor_length'] : '-');
      $sheet->setCellValue('J' . $row, !empty($value['clamp_length']) ? $value['clamp_length'] : '-');
      $sheet->setCellValue('K' . $row, !empty($value['collor_hub_dist']) ? $value['collor_hub_dist'] : '-');
      $sheet->setCellValue('L' . $row, !empty($value['fan_dia_mm']) ? $value['fan_dia_mm'] : '-');
      $sheet->setCellValue('M' . $row, !empty($value['fan_dia_ft']) ? $value['fan_dia_ft'] : '-');
      $sheet->setCellValue('N' . $row, !empty($value['blade_qty']) ? $value['blade_qty'] : '-');
      $sheet->setCellValue('O' . $row, !empty($value['blade_punching_no']) ? $value['blade_punching_no'] : '-');
      $sheet->setCellValue('P' . $row, !empty($value['a_tip']) ? $value['a_tip'] : '-');
      $sheet->setCellValue('Q' . $row, !empty($value['color']) ? $value['color'] : '-');
      $sheet->setCellValue('R' . $row, !empty($value['name_plate']) ? $value['name_plate'] : '-');
      $sheet->setCellValue('S' . $row, !empty($value['set']) ? $value['set'] : '-');
      $sheet->setCellValue('T' . $row, !empty($value['way']) ? $value['way'] : '-');
      $sheet->setCellValue('U' . $row, !empty($value['delivery_date']) ? $value['delivery_date'] : '-');


      $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'U') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'BLADE_SELECTED_' . date('YmdHis') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;


  }


  public function export_selected_blade_pdf()
  {
    $ids = $this->input->get('ids');

    if (empty($ids)) {
      show_error('No rows selected');
    }

    $indentNos = explode(',', $ids);

    $data['indent_details'] =
      $this->IndentModel
      ->getBladeExportIndentDetailsSelected($indentNos);


    $html = $this->load->view(
      'admin/production/pdf/blade_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();

    $pdf->loadHtml($html);

    $pdf->setPaper('A4', 'landscape');

    $pdf->render();


    $pdf->stream(
      'BLADE_SELECTED_' . date('YmdHis') . '.pdf',
      array(
        "Attachment" => 0
      )
    );
  }




  public function view_indent_blade($id, $indent_no)
  {

    // $indentDetails = $this->IndentModel->indentOrderDetails($id);

    // $data['indentDetails'] = $indentDetails[0];
    // // $data['details'][0] = $this->IndentModel->orderStatus($indent_no);
    // $data['detail'] = $this->IndentModel->orderStatus($indent_no);
    // $data['subOrder'] = $this->IndentModel->subOrders($indent_no);
    $indentDetails = $this->IndentModel->indentOrderDetails($id);

    $data['indentDetails'] = $indentDetails[0];
    $data['details'] = $this->IndentModel->orderStatus($id);
    // $details = $this->IndentModel->orderStatus($id);
    //  echo"<pre>";
    //   print_r($data);
    //   die;



    $this->load->view(ADMIN . 'production/view_indent_blade1', $data);
  }

  public function view_indent_blade2($indent_no)
  {
    // $indentDetails = $this->IndentModel->indentOrderDetails2($indent_no);
    // // echo $this->db->last_query();die;
    // $data['indentDetails'] = $indentDetails[0];
    // $data['details'] = $this->IndentModel->orderStatus2($indentDetails[0]['id']);

    $indentDetails = $this->IndentModel->indentOrderDetailsi($indent_no);
    // echo"<pre>";
    // print_r($indentDetails);die;
    // echo $this->db->last_query();die;
    $data['indentDetails'] = $indentDetails[0];
    $data['details'] = $this->IndentModel->orderStatusi($indent_no);
    // $orderstatus= $this->IndentModel->orderStatusi($indent_no);
    // echo"<pre>";
    // print_r($orderstatus);
    // die;
    $data['subOrder'] = $this->IndentModel->subOrdersi($indent_no);

    $this->load->view(ADMIN . 'production/view_indent_blade', $data);
  }

  public function add_createfor_blade_encon($id = '')
  {
    $data['type'] = "2";
    $this->load->view(ADMIN . 'production/add_indentfor_blade_balaji', $data);
    // $this->load->view(ADMIN . 'production/add_indentfor_blade_encon_india');
  }

  public function listclientName($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $client = $this->IndentModel->getclientName('');
    } else {
      $search = $_GET['searchTerm'];
      $client = $this->IndentModel->getclientName($search);
    }
    foreach ($client as $key => $value) {

      $json[] = ['id' => $value['company_name'], 'text' => $value['company_name']];
    }
    echo json_encode($json);
  }


  public function listmould_size($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $mould = $this->IndentModel->getmouldsize('');
    } else {
      $search = $_GET['searchTerm'];
      $mould = $this->IndentModel->getmouldsize($search);
    }
    foreach ($mould as $key => $value) {

      $json[] = ['id' => $value['name'], 'text' => $value['name']];
    }
    echo json_encode($json);
  }



  public function list_a_tip($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $a_tip = $this->IndentModel->get_a_tip('');
    } else {
      $search = $_GET['searchTerm'];
      $a_tip = $this->IndentModel->get_a_tip($search);
    }
    foreach ($a_tip as $key => $value) {

      $json[] = ['id' => $value['name'], 'text' => $value['name']];
    }
    echo json_encode($json);
  }


  //1 for carbon fiber drive shaft indent view 

  public function carbonfiberdriveshaft_indent()
  {
    $data['title'] = 'Indent';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 1), 'id,indent_name');
    //  print_r($data['indent_name']);die;
    $this->load->view(ADMIN . 'production/list_carbonfiberdriveshaft_indent', $data);
  }

  public function list_carbon_fiber_drive_shaft()
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

    if ($data['indentid'] == "all") {
      $where = array();
    } else {
      $where['tid.master_indent_id'] = 7;
    }

    $from_date = $data['from_date'] ?? '';
    $to_date   = $data['to_date'] ?? '';

    if (!empty($from_date)) {
      $where['DATE(i.date) >='] = $from_date;
    }

    if (!empty($to_date)) {
      $where['DATE(i.date) <='] = $to_date;
    }

    $count = count($this->IndentModel->getcfdsIndentData($searchVal, 0, 0, 0, 0, 0, $where, $from_date, $to_date));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->IndentModel->getcfdsIndentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where, $from_date, $to_date);
      // echo"<pre>";
      // print_r($result);die;

      foreach ($result as $key => $value) {
        $total = $this->IndentModel->getSum($value['indent_no']);

        $row = [];
        $checkbox = '
          <input type="checkbox"
          class="cfds_checkbox"
          name="selected_rows[]"
          value="' . $value['indent_no'] . '">
          ';

        array_push($row, $checkbox);
        array_push($row, $offset + ($key + 1));
        array_push($row, $value['client_name']);
        array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['indent_number']);
        array_push($row, $value['date']);


        $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";



        $check_exist1 = $this->CommonModel->getData('tbl_indent_order', array('indent_id' => $value['indent_no']), '', '', 'num_rows');
        $checkSameQuantity = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $value['indent_number']], 'SUM(order_qty) as totalOrderQty,blade_qty', '', 'result_array');
        // print_r($checkSameQuantity);die;

        if ($check_exist1) {
          $action = ' <a href="' . base_url() . 'admin/production/Indent/view_carbon_fiber_drive_shaft/' . $value['indent_no'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        } else {
          $action = '';
        }

        $action .= '<a onclick="return " href="' . base_url() . 'admin/production/Indent/exportpdf_carbon_fiber_drive_shaft/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Export PDF" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" target="_blank">
                      <i class="fas fa-file-pdf"></i>
                    </a>

                    <a href="' . base_url() . 'admin/production/Indent/exportexcel_carbon_fiber_drive_shaft/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Export Excel"
                      class="btn btn-success waves-effect waves-light btn-sm"
                      target="_blank" target="_blank">
                      <i class="fas fa-file-excel"></i>
                    </a>
                    
                    <a onclick="return " href="' . base_url() . 'admin/production/Indent/CreateOrderforcarbon_fiber_drive_shaft/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Create Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" >
                      <i class="fas fa-check-square" aria-hidden="true"></i>
                    </a>';


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

  public function exportpdf_carbon_fiber_drive_shaft($indent_id, $indent_bland_id, $indent_no)
  {
    $data['indent_details'] = $this->IndentModel->getcdfsExportIndentDetails($indent_no);

    $html = $this->load->view(
      'admin/production/pdf/carbon_fiber_drive_shaft_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();

    $pdf->loadHtml($html);

    $pdf->setPaper('A4', 'landscape');

    $pdf->render();

    $pdf->stream(
      'CFDS_' . $indent_no . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_cfds_pdf()
  {
    $ids = $this->input->get('ids');

    if (empty($ids)) {
      show_error('No rows selected');
    }

    $indentNos = explode(',', $ids);

    $data['indent_details'] =
      $this->IndentModel
      ->getcdfsExportIndentDetailsSelected($indentNos);

    $html = $this->load->view(
      'admin/production/pdf/carbon_fiber_drive_shaft_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();

    $pdf->loadHtml($html);

    $pdf->setPaper('A4', 'landscape');

    $pdf->render();

    $pdf->stream(
      'CFDS_SELECTED_' . date('YmdHis') . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_cfds_excel()
  {
    $ids = $this->input->get('ids');

    $indentNos = explode(',', $ids);

    $details =
      $this->IndentModel
      ->getcdfsExportIndentDetailsSelected($indentNos);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'FAN DIA',
      'F1' => 'DBSE',
      'G1' => 'QTY.',
      'H1' => 'MOTOR POWER/RPM',
      'I1' => 'MOTOR SIDE SHAFT DIA / KEY WAY',
      'J1' => 'GEAR SIDE SHAFT DIA / KEY WAY',
      'K1' => 'GEARBOX MODEL NO.',
      'L1' => 'FAN RPM',
      'M1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:M1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);

    $row = 2;
    $sr = 1;

    foreach ($details as $value) {

      $bore = !empty($value['bore'])
        ? json_decode($value['bore'], true)
        : [];

      $keyway = !empty($value['keyway'])
        ? json_decode($value['keyway'], true)
        : [];

      $motor_side = '';
      $gear_side = '';

      if (!empty($bore)) {

        foreach ($bore as $index => $boreValue) {

          $motor_bore = $boreValue['motor'] ?? '-';
          $gear_bore = $boreValue['gear'] ?? '-';

          $motor_key = $keyway[$index]['motor'] ?? '-';
          $gear_key = $keyway[$index]['gear'] ?? '-';

          $motor_side .= $motor_bore . ' MM (' . $motor_key . ')' . "\n";
          $gear_side .= $gear_bore . ' MM (' . $gear_key . ')' . "\n";
        }
      }

      $sheet->setCellValue('A' . $row, $sr);

      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );

      $sheet->setCellValue(
        'C' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );

      $sheet->setCellValue(
        'D' . $row,
        !empty($value['client_name'])
          ? strtoupper($value['client_name'])
          : '-'
      );

      $sheet->setCellValue(
        'E' . $row,
        !empty($value['fan_dia'])
          ? $value['fan_dia']
          : '-'
      );

      $sheet->setCellValue(
        'F' . $row,
        !empty($value['dbse'])
          ? $value['dbse']
          : '-'
      );

      $sheet->setCellValue(
        'G' . $row,
        !empty($value['qty'])
          ? $value['qty']
          : '-'
      );

      $sheet->setCellValue(
        'H' . $row,
        (!empty($value['motor_power']) || !empty($value['fan_rpm']))
          ? $value['motor_power'] . ' / ' . $value['fan_rpm']
          : '-'
      );

      $sheet->setCellValue(
        'I' . $row,
        !empty(trim($motor_side))
          ? trim($motor_side)
          : '-'
      );

      $sheet->setCellValue(
        'J' . $row,
        !empty(trim($gear_side))
          ? trim($gear_side)
          : '-'
      );

      $sheet->setCellValue(
        'K' . $row,
        !empty($value['gearbox_model_no'])
          ? $value['gearbox_model_no']
          : '-'
      );

      $sheet->setCellValue(
        'L' . $row,
        !empty($value['fan_rpm'])
          ? $value['fan_rpm']
          : '-'
      );

      $sheet->setCellValue(
        'M' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );

      // ROW STYLE

      $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'M') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'CFDS_SELECTED_' . date('YmdHis') . '.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }

  public function exportexcel_carbon_fiber_drive_shaft($indent_id, $indent_bland_id, $indent_no)
  {
    $details = $this->IndentModel->getcdfsExportIndentDetails($indent_no);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'FAN DIA',
      'F1' => 'DBSE',
      'G1' => 'QTY.',
      'H1' => 'MOTOR POWER/RPM',
      'I1' => 'MOTOR SIDE SHAFT DIA / KEY WAY',
      'J1' => 'GEAR SIDE SHAFT DIA / KEY WAY',
      'K1' => 'GEARBOX MODEL NO.',
      'L1' => 'FAN RPM',
      'M1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:M1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);

    $row = 2;
    $sr = 1;

    foreach ($details as $value) {

      $bore = !empty($value['bore'])
        ? json_decode($value['bore'], true)
        : [];

      $keyway = !empty($value['keyway'])
        ? json_decode($value['keyway'], true)
        : [];

      $motor_side = '';
      $gear_side = '';

      if (!empty($bore)) {

        foreach ($bore as $index => $boreValue) {

          $motor_bore = $boreValue['motor'] ?? '-';
          $gear_bore = $boreValue['gear'] ?? '-';

          $motor_key = $keyway[$index]['motor'] ?? '-';
          $gear_key = $keyway[$index]['gear'] ?? '-';

          $motor_side .= $motor_bore . ' MM (' . $motor_key . ')' . "\n";
          $gear_side .= $gear_bore . ' MM (' . $gear_key . ')' . "\n";
        }
      }

      $sheet->setCellValue('A' . $row, $sr);

      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );

      $sheet->setCellValue(
        'C' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );

      $sheet->setCellValue(
        'D' . $row,
        !empty($value['client_name'])
          ? strtoupper($value['client_name'])
          : '-'
      );

      $sheet->setCellValue(
        'E' . $row,
        !empty($value['fan_dia'])
          ? $value['fan_dia']
          : '-'
      );

      $sheet->setCellValue(
        'F' . $row,
        !empty($value['dbse'])
          ? $value['dbse']
          : '-'
      );

      $sheet->setCellValue(
        'G' . $row,
        !empty($value['qty'])
          ? $value['qty']
          : '-'
      );

      $sheet->setCellValue(
        'H' . $row,
        (!empty($value['motor_power']) || !empty($value['fan_rpm']))
          ? $value['motor_power'] . ' / ' . $value['fan_rpm']
          : '-'
      );

      $sheet->setCellValue(
        'I' . $row,
        !empty(trim($motor_side))
          ? trim($motor_side)
          : '-'
      );

      $sheet->setCellValue(
        'J' . $row,
        !empty(trim($gear_side))
          ? trim($gear_side)
          : '-'
      );

      $sheet->setCellValue(
        'K' . $row,
        !empty($value['gearbox_model_no'])
          ? $value['gearbox_model_no']
          : '-'
      );

      $sheet->setCellValue(
        'L' . $row,
        !empty($value['fan_rpm'])
          ? $value['fan_rpm']
          : '-'
      );

      $sheet->setCellValue(
        'M' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );

      // ROW STYLE

      $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'M') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'CFDS_' . $indent_no . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }

  public function view_carbon_fiber_drive_shaft($indent_no)
  {

    // $indentDetails = $this->IndentModel->indentDetailsforcfds($indent_no);
    // $data['indentDetails'] = $indentDetails;
    // $data['details'] = $this->IndentModel->orderStatusi($indent_no);
    // $data['subOrder'] = $this->IndentModel->subOrdersi($indent_no);

    $data['indent_details'] = $this->IndentModel->getIndentDetails($indent_no);
    // echo'<pre>';
    // print_r($data);
    // die;
    $this->load->view(ADMIN . 'production/view_carbon_fiber_drive_shaft', $data);
  }

  public function CreateOrderforcarbon_fiber_drive_shaft($id = "", $blade_indent_id = "", $indent_no = "")
  {
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $company_id = $this->session->userdata('company_id');
    // print_r($_FILES);die; 
    if ($_POST) {

      $post = $_POST;
      // echo"<pre>";
      // print_r($post);
      // die();

      $converted_date = !empty($post['date']) ? date('Y-m-d', strtotime($post['date'])) : date('Y-m-d');
      $delivery_date = !empty($post['delivery_date']) ? date('Y-m-d', strtotime($post['delivery_date'])) : NULL;

      $client_id = $this->session->userdata('user_id');
      $plant_id = $this->session->userdata('company_id');


      // echo "<pre>";
      // print_r($post['indent_sequence']);
      // die();

      $indent_id = $post['indent_db_id'] ?? '';

      if (!empty($indent_id)) {

        $existingIndent = $this->CommonModel->getData(
          'tbl_indent',
          ['id' => $indent_id],
          '*',
          '',
          'row_array'
        );

        $indentSequence = $existingIndent['indent_sequence'];
        $indentNo = $existingIndent['indent_no'];
        $manualIndentNo = $existingIndent['indent_number'];
      } else {

        $indentSequence = $post['indent_sequence'] ?? $this->IndentModel->getIndentSequenceNumber();
        $indentNo = $post['indent_no'] ?? $this->IndentModel->getindentNumber();
        $manualIndentNo = $post['manual_indent_no'] ?? '';
      }
      $array_indent = [
        'client_id'       => $client_id,
        'plant_id'        => $plant_id,
        'indent_no'       => $indentNo,
        'date'            => $converted_date,
        'delivery_date'   => $delivery_date,
        'indent_sequence' => $indentSequence,
        'indent_number'   => $manualIndentNo,
        'is_lock'         => 1
      ];
      if (!empty($indent_id)) {
        $array_indent['updated_by'] = userId();
        $array_indent['updated_at'] = date('Y-m-d H:i:s');
        // $array_indent['indent_no'] = $post['indent_no'];
        $this->CommonModel->iudAction('tbl_indent', $array_indent, 'update', ['id' => $indent_id]);
      } else {
        $array_indent['created_by'] = userId();

        $indent_id = $this->CommonModel->iudAction('tbl_indent', $array_indent, 'insert');
      }

      if ($indent_id) {

        $moduleData = [
          'master_indent_id' => 7,
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'dimension' => $post['dimension'] ?? '',
          'material' => $post['material'] ?? '',
          'remark' => $post['remark'] ?? '',
          'qty' => $post['order_qty'] ?? '',
          'make' => $post['make'] ?? '',
        ];


        $design_file = null;

        if (!empty($_FILES['design_file']['name'])) {
          $result = fileUpload(CFSD_DESIGN_FILE, 'design_file');
          if ($result['status'] == true) {
            $design_file = $result['image_name'];
          }
        }

        if ($design_file) {
          $moduleData['design_file'] = $design_file;
        }

        $existingModule = $this->CommonModel->getData(
          'tbl_indent_carbon_fiber_drive_shift',
          ['indent_id' => $indent_id],
          '*',
          '',
          'row_array'
        );

        if (!empty($existingModule)) {

          $moduleData['updated_at'] = date('Y-m-d H:i:s');
          $moduleData['updated_by'] = userId();
          $moduleData['qty'] = ($post['totalorder_qty'] ?? 0) - ($post['order_qty'] ?? 0);
          $this->CommonModel->iudAction(
            'tbl_indent_carbon_fiber_drive_shift',
            $moduleData,
            'update',
            ['indent_id' => $indent_id]
          );

          $indent_module_id = $existingModule['id'];
        } else {

          $moduleData['created_at'] = date('Y-m-d H:i:s');
          $moduleData['created_by'] = userId();

          $indent_module_id = $this->CommonModel->iudAction(
            'tbl_indent_carbon_fiber_drive_shift',
            $moduleData,
            'insert'
          );
        }

        $data_details_data = [
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'master_indent_id' => 7,
          'ref_id' => $indent_module_id,
          'created_by' => userId(),
          'created_at' => date('Y-m-d H:i:s')
        ];

        $existingDetail = $this->CommonModel->getData(
          'tbl_indent_details',
          [
            'indent_id' => $indent_id,
            'master_indent_id' => 7
          ],
          '*',
          '',
          'row_array'
        );

        if ($existingDetail) {
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $data_details_data,
            'update',
            ['id' => $existingDetail['id']]
          );
        } else {
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $data_details_data,
            'insert'
          );
        }

        $spec_id = $this->input->post('spec_id') ?: [];
        $group_qty = $this->input->post('group_qty') ?: [];
        $ext_group_qty = $this->input->post('ext_group_qty') ?: [];

        $oldSpecs = [];

        $existingSpecs = $this->db
          ->where('indent_sub_id', $indent_module_id)
          ->get('tbl_carbon_fiber_drive_shaft_specifications')
          ->result_array();

        foreach ($existingSpecs as $oldSpec) {
          $oldSpecs[$oldSpec['id']] = $oldSpec;
        }

        foreach ($group_qty as $i => $qty) {

          $oldQty = (float)($qty ?? 0);

          if (!empty($spec_id[$i]) && isset($oldSpecs[$spec_id[$i]])) {
            $oldQty = (float)$oldSpecs[$spec_id[$i]]['group_qty'];
          }

          $extQty = (float)($ext_group_qty[$i] ?? 0);

          $group_qty[$i] = $oldQty - $extQty;

          if ($group_qty[$i] < 0) {
            $group_qty[$i] = 0;
          }
        }

        $this->db->where('indent_sub_id', $indent_module_id);
        $this->db->delete('tbl_carbon_fiber_drive_shaft_specifications');


        $motor_power = $this->input->post('motor_power') ?: [];
        $dbse = $this->input->post('dbse') ?: [];
        $tube_od_thk = $this->input->post('tube_od_thk') ?: [];
        $fan_dia = $this->input->post('fan_dia') ?: [];
        $no_of_blade = $this->input->post('no_of_blade') ?: [];
        $fan_rpm = $this->input->post('fan_rpm') ?: [];
        $boreArr = $this->input->post('bore');
        $keywayArr = $this->input->post('keyway');
        $gearbox_model_no = $this->input->post('gearbox_model_no') ?: [];

        if (!empty($group_qty)) {

          $this->db->where('indent_sub_id', $indent_module_id);
          $this->db->delete('tbl_carbon_fiber_drive_shaft_specifications');

          foreach ($group_qty as $i => $qty) {

            if (empty($qty))
              continue;
            $borePairs = [];

            if (isset($boreArr[$i])) {
              $boreValues = is_array($boreArr[$i]) ? $boreArr[$i] : json_decode($boreArr[$i], true);

              if (!empty($boreValues)) {
                if (isset($boreValues[0]) && is_array($boreValues[0]) && array_key_exists('motor', $boreValues[0])) {
                  foreach ($boreValues as $pair) {
                    $borePairs[] = [
                      'motor' => $pair['motor'] ?? null,
                      'gear' => $pair['gear'] ?? null
                    ];
                  }
                } else {
                  $boreValues = array_values(array_filter($boreValues, function ($v) {
                    return $v !== null && $v !== '';
                  }));

                  for ($j = 0; $j < count($boreValues); $j += 2) {
                    $borePairs[] = [
                      'motor' => $boreValues[$j] ?? null,
                      'gear' => $boreValues[$j + 1] ?? null
                    ];
                  }
                }
              }
            }


            $keywayPairs = [];

            if (isset($keywayArr[$i])) {
              $keywayValues = is_array($keywayArr[$i]) ? $keywayArr[$i] : json_decode($keywayArr[$i], true);

              if (!empty($keywayValues)) {

                if (isset($keywayValues[0]) && is_array($keywayValues[0]) && array_key_exists('motor', $keywayValues[0])) {
                  foreach ($keywayValues as $pair) {
                    $keywayPairs[] = [
                      'motor' => $pair['motor'] ?? null,
                      'gear' => $pair['gear'] ?? null
                    ];
                  }
                } else {
                  $keywayValues = array_values(array_filter($keywayValues, function ($v) {
                    return $v !== null && $v !== '';
                  }));

                  for ($j = 0; $j < count($keywayValues); $j += 2) {
                    $keywayPairs[] = [
                      'motor' => $keywayValues[$j] ?? null,
                      'gear' => $keywayValues[$j + 1] ?? null
                    ];
                  }
                }
              }
            }

            $specData = [
              'indent_id' => $indent_id,
              'indent_sub_id' => $indent_module_id,
              'group_qty' => $qty,
              'motor_power' => $motor_power[$i] ?? null,
              'dbse' => $dbse[$i] ?? null,
              'tube_od_thk' => $tube_od_thk[$i] ?? null,
              'fan_dia' => $fan_dia[$i] ?? null,
              'no_of_blade' => $no_of_blade[$i] ?? null,
              'fan_rpm' => $fan_rpm[$i] ?? null,

              'bore' => !empty($borePairs) ? json_encode($borePairs) : null,
              'keyway' => !empty($keywayPairs) ? json_encode($keywayPairs) : null,
              'gearbox_model_no' => $gearbox_model_no[$i] ?? null

            ];

            $this->CommonModel->iudAction(
              'tbl_carbon_fiber_drive_shaft_specifications',
              $specData,
              'insert'
            );
          }
        }
      }

      $issuedQty = !empty($ext_group_qty)
        ? array_sum($ext_group_qty)
        : 0;

      // Get last order for this indent
      $lastOrder = $this->db
        ->where('indent_id', $indent_id)
        ->order_by('id', 'DESC')
        ->get('tbl_indent_carbon_fiber_drive_shaft_received_orders')
        ->row_array();

      // Initial quantity for first order, otherwise previous remaining quantity
      $oldTotalQty = !empty($lastOrder)
        ? (float)$lastOrder['total_order_qty']
        : (float)$post['order_qty'];

      $newTotalQty = $oldTotalQty - $issuedQty;

      if ($newTotalQty < 0) {
        $newTotalQty = 0;
      }

      $orderData = [
        'order_for'        => $post['order_for'],
        'indent_date'      => $post['indent_date'],
        'delivery_date'    => $delivery_date,
        'party_id'         => $plant_id,
        'indent_id'        => $indent_id,
        'manual_indent_no' => $array_indent['indent_number'],
        'remark'           => $post['remark'] ?? '',
        'order_qty'        => $issuedQty,
        'total_order_qty' => $newTotalQty,
        'created_by'       => userId(),
        'created_at'       => date('Y-m-d H:i:s')
      ];

      // Always insert new order
      $order_id = $this->CommonModel->iudAction(
        'tbl_indent_carbon_fiber_drive_shaft_received_orders',
        $orderData,
        'insert'
      );

      if ($order_id) {

        // Create stage detail rows
        $stages = $this->db
          ->order_by('sequence', 'ASC')
          ->get('tbl_cfds_stage_master')
          ->result();

        foreach ($stages as $stage) {

          $this->CommonModel->iudAction(
            'tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail',
            [
              'order_id'   => $order_id,
              'status_id'  => $stage->id,
              'qty'        => 0,
              'company_id' => $company_id,
              'created_by' => userId(),
              'created_at' => date('Y-m-d H:i:s')
            ],
            'insert'
          );
        }

        // Create status row
        $this->CommonModel->iudAction(
          'tbl_indent_carbon_fiber_drive_shaft_received_order_status',
          [
            'order_id'            => $order_id,
            'qty'                 => $newTotalQty,
            'order_qty'           => $issuedQty,
            'indent_transfer_qty' => 0,
            'created_qty'         => 0,
            'company_id'          => $company_id,
            'created_by'          => userId(),
            'created_at'          => date('Y-m-d H:i:s')
          ],
          'insert'
        );
      }
      // }

      $this->session->set_flashdata('success', 'Order Saved Successfully!');
      redirect(base_url(ADMIN . 'production/Indent/carbonfiberdriveshaft_indent'));
    }

    // LOAD VIEW
    $blade = $this->IndentModel->indentDetailsforcfds($id, $blade_indent_id, $indent_no);

    $data['blade_data'] = $blade;
    $data['specifications'] = $blade['specifications'] ?? [];
    $data['type'] = "1";

    // echo'<pre>';
    // print_r($data);
    // die;

    $this->load->view(ADMIN . 'production/add_indentfor_carbonfiberdriveshaft', $data);
  }

  public function add_indentfor_carbonfiberdriveshaft($id = '')
  {
    $data['type'] = "2";
    $user_details = $this->session->userdata();
    $data['user_details'] = $user_details;
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();
    // echo'<pre>'; print_r($data);die;
    $this->load->view(ADMIN . 'production/add_indentfor_carbonfiberdriveshaft', $data);
    // $this->load->view(ADMIN . 'production/add_indentfor_blade_encon_india');
  }

  public function cfds_received_order()
  {
    $data['title'] = 'Carbon Fiber Drive Shaft Received Orders';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 1), 'id,indent_name');
    $data['status_data'] = $this->IndentModel->getcfdsIndentStatuslist();

    //  print_r($data['indent_name']);die;
    $this->load->view(ADMIN . 'production/list_cfds_received_order', $data);
  }

  public function list_cfds_ReceivedOrders()
  {
    $data = $_POST;

    $limit = $data['length'];
    $offset = $data['start'];
    $search = $data['search']['value'];

    $result = $this->IndentModel->getCFDSorderStatusData($search, $limit, $offset);
    $rows = [];
    $sr = $offset;

    foreach ($result as $value) {
      if ((float) $value['order_qty'] <= 0) {
        continue;
      }
      $sr++;

      $row = [];

      $total = $value['total_order_qty'];

      array_push(
        $row,
        '
                <i class="fas fa-plus-circle plus-icon clickableRow"
                    data-id="' . $value['id'] . '"
                    data-indent="' . $value['indent_no'] . '"
                    data-manual="' . $value['manual_indent_no'] . '"
                    data-company="' . $value['company_name'] . '"
                    data-total="' . $value['total_order_qty'] . '">
                </i> ' . $sr
      );

      $orderFor = ($value['order_for'] == 1) ? 'Indent' : 'Self';
      array_push($row, $orderFor);

      array_push($row, $value['indent_no']);
      array_push($row, $value['manual_indent_no']);
      array_push($row, $value['indent_date']);
      array_push($row, $value['company_name']);

      array_push($row, '<span class="badge badge-success">' . $total . '</span>');
      array_push($row, '<span class="badge badge-warning">' . $value['order_qty'] . '</span>');

      array_push($row, '<span class="label design-selection openModal"
                            data-id="' . $value['id'] . '"
                            data-indent="' . $value['indent_no'] . '"
                            data-manual="' . $value['manual_indent_no'] . '"
                            data-company="' . $value['company_name'] . '"
                            data-total="' . $value['total_order_qty'] . '"
                            data-created="' . $value['design'] . '"
                            style="cursor:pointer;">
                            ' . $value['design'] . '
                        </span>');

      array_push($row, '<span class="label custome-received">' . $value['filament'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['bonding'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['torque'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['balancing'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['inspection'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['packaging'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['dispatch'] . '</span>');

      $action = '<a href="' . base_url() . 'admin/production/Indent/view_cfds_indent_details/' . $value['id'] . '/' . $value['indent_id'] . '" 
                    class="btn btn-primary btn-sm" style="background:#F0F0F0;color:gray;">
                    <i class="fas fa-eye"></i>
                  </a>

                 ';
      //  <a href="javascript:void(0);" class="btn btn-primary btn-sm m-1" 
      //                     style="background:#F0F0F0;color:gray;"
      //                     onclick="openInterChangeModal(' . $value['id'] . ')">
      //                     <i class="fas fa-exchange-alt"></i>
      //                   </a>
      array_push($row, $action);

      $rows[] = $row;
    }


    echo json_encode([
      "draw" => intval($data['draw']),
      "recordsTotal" => count($rows),
      "recordsFiltered" => count($rows),
      "data" => $rows
    ]);
  }

  public function getIndentStatusData($order_id)
  {
    $data['indent_status'] = $this->IndentModel->getIndentStatusData($order_id);
    echo "<pre>";
    print_r($data);
    die();
    echo json_encode($data);
  }

  public function getStageData()
  {
    $order_id = $this->input->post('order_id');
    $data = $this->IndentModel->getStageDataByOrder($order_id);
    echo json_encode($data);
  }

  public function getFRPHPipeStageData()
  {
    $order_id = $this->input->post('order_id');
    $data = $this->IndentModel->getFRPHPipeStageData($order_id);
    echo json_encode($data);
  }

  public function updateStageData()
  {
    $post = $this->input->post();

    // echo '<pre>';
    // print_r($post);
    // die();

    $order_id = $post['order_id'];
    $tube_od_thk = $post['tube_od_thk'] ?? '';

    $order = $this->CommonModel->getData(
      'tbl_indent_carbon_fiber_drive_shaft_received_orders',
      ['id' => $order_id],
      '',
      '',
      'row_array'
    );

    if (!$order) {
      echo json_encode(['status' => false, 'msg' => 'Order not found']);
      return;
    }

    $indent_sub = $order['indent_id'];

    // ✅ UPDATE TUBE OD THK IN SPEC TABLE
    if (!empty($tube_od_thk)) {

      $this->CommonModel->iudAction(
        'tbl_carbon_fiber_drive_shaft_specifications',
        ['tube_od_thk' => $tube_od_thk],
        'update',
        ['indent_id' => $indent_sub]
      );
    }
    // if($tube_od_thk){
    //   echo '<pre>';
    //   print_r($post);
    //   die();
    // }

    // ✅ STAGE UPDATE
    $stages = [
      1 => ['qty' => $post['design'], 'remark' => $post['remark_design']],
      2 => ['qty' => $post['filament'], 'remark' => $post['remark_filament']],
      3 => ['qty' => $post['bonding'], 'remark' => $post['remark_bonding']],
      4 => ['qty' => $post['torque'], 'remark' => $post['remark_torque']],
      5 => ['qty' => $post['balancing'], 'remark' => $post['remark_balancing']],
      6 => ['qty' => $post['inspection'], 'remark' => $post['remark_inspection']],
      7 => ['qty' => $post['packaging'], 'remark' => $post['remark_packaging']],
      8 => ['qty' => $post['dispatch'], 'remark' => $post['remark_dispatch']],
    ];

    foreach ($stages as $status_id => $data) {

      $qty = isset($data['qty']) && $data['qty'] !== '' ? (int) $data['qty'] : 0;
      $remark = isset($data['remark']) ? trim($data['remark']) : '';

      if ($qty <= 0 && $remark === '')
        continue;

      $exists = $this->CommonModel->getData(
        'tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail',
        [
          'order_id' => $order_id,
          'status_id' => $status_id
        ],
        '',
        '',
        'row_array'
      );

      if (!empty($exists)) {

        $this->CommonModel->iudAction(
          'tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail',
          [
            'qty' => $qty,
            'remark' => $remark,
            'date' => date('Y-m-d'),
            'created_by' => userId()
          ],
          'update',
          ['id' => $exists['id']]
        );
      } else {

        $this->CommonModel->iudAction(
          'tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail',
          [
            'order_id' => $order_id,
            'status_id' => $status_id,
            'qty' => $qty,
            'remark' => $remark,
            'date' => date('Y-m-d'),
            'created_by' => userId(),
            'created_at' => date('Y-m-d H:i:s')
          ],
          'insert'
        );
      }
    }

    echo json_encode([
      'status' => true,
      'msg' => 'Stage + Tube updated successfully'
    ]);
  }

  public function updateFRPHPipeStageData()
  {
    $post = $this->input->post();

    // echo '<pre>';
    // print_r($post);
    // die();

    $order_id = $post['order_id'];

    $order = $this->CommonModel->getData(
      'tbl_indent_frp_header_pipe_received_orders',
      ['id' => $order_id],
      '',
      '',
      'row_array'
    );

    if (!$order) {
      echo json_encode(['status' => false, 'msg' => 'Order not found']);
      return;
    }

    $indent_sub = $order['indent_id'];

    // ✅ UPDATE TUBE OD THK IN SPEC TABLE

    // if($tube_od_thk){
    //   echo '<pre>';
    //   print_r($post);
    //   die();
    // }

    // ✅ STAGE UPDATE
    $stages = [
      1 => ['qty' => $post['design'], 'remark' => $post['remark_design']],
      2 => ['qty' => $post['filament'], 'remark' => $post['remark_filament']],
      3 => ['qty' => $post['size_cutting'], 'remark' => $post['remark_size_cutting']],
      4 => ['qty' => $post['flange_making'], 'remark' => $post['remark_flange_making']],
      5 => ['qty' => $post['pipe_coupler_join'], 'remark' => $post['remark_pipe_coupler_join']],
      6 => ['qty' => $post['finishing'], 'remark' => $post['remark_finishing']],
      6 => ['qty' => $post['inspection'], 'remark' => $post['remark_inspection']],
      7 => ['qty' => $post['packaging'], 'remark' => $post['remark_packaging']],
      8 => ['qty' => $post['dispatch'], 'remark' => $post['remark_dispatch']],
    ];

    foreach ($stages as $status_id => $data) {

      $qty = isset($data['qty']) && $data['qty'] !== '' ? (int) $data['qty'] : 0;
      $remark = isset($data['remark']) ? trim($data['remark']) : '';

      if ($qty <= 0 && $remark === '')
        continue;

      $exists = $this->CommonModel->getData(
        'tbl_indent_frp_header_pipe_received_order_status_detail',
        [
          'order_id' => $order_id,
          'status_id' => $status_id
        ],
        '',
        '',
        'row_array'
      );

      if (!empty($exists)) {

        $this->CommonModel->iudAction(
          'tbl_indent_frp_header_pipe_received_order_status_detail',
          [
            'qty' => $qty,
            'remark' => $remark,
            'date' => date('Y-m-d'),
            'created_by' => userId()
          ],
          'update',
          ['id' => $exists['id']]
        );
      } else {

        $this->CommonModel->iudAction(
          'tbl_indent_frp_header_pipe_received_order_status_detail',
          [
            'order_id' => $order_id,
            'status_id' => $status_id,
            'qty' => $qty,
            'remark' => $remark,
            'date' => date('Y-m-d'),
            'created_by' => userId(),
            'created_at' => date('Y-m-d H:i:s')
          ],
          'insert'
        );
      }
    }

    echo json_encode([
      'status' => true,
      'msg' => 'Data updated successfully'
    ]);
  }

  public function indentDetails()
  {
    $data = $_POST;

    // $details = $this->ReceivedOrderModel->indentDetails($data['id']);
    // echo"<pre>";
    // print_r($details);
    // die;

    $details = [
      'id' => 1,
      'indent_no' => 'EFFPL-P-127-20',
      'date' => '2024-08-26',
      'plant_name' => 'EFFPL Plant',
      'customer_name' => 'ABC Industries',
      'qty' => 10,
      'received_qty' => 2,
      'dimension' => '2850 MM',
      'material' => 'Carbon Fibre Composite',
      'make' => '1 to 10',
      'remark' => '20MM'
    ];

    echo json_encode($details);
  }

  public function view_cfds_indent_details($id, $indent_no)
  {
    $data['indentDetails'] = $this->IndentModel->cfdsrOrderDetails($id);
    $data['specifications'] = $this->IndentModel->cfdsrSpecifications($id);

    $order_status_details = $this->IndentModel->cfdsrOrderStatusDetails($id);

    $statusFormatted = [
      'Qty' => 0,
      'Design Selection' => 0,
      'Filament Winding' => 0,
      'Bonding' => 0,
      'Torque Testing' => 0,
      'Dynamic Balancing' => 0,
      'Inspection' => 0,
      'Packaging' => 0,
      'Dispatch' => 0,
    ];
    $maxQty = 0;
    foreach ($order_status_details as $row) {

      if ($row['qty'] > $maxQty) {
        $maxQty = $row['qty'];
      }

      if ($row['status_id'] == 1) {
        $statusFormatted['Design Selection'] = $row['qty'];
      }

      if ($row['status_id'] == 2) {
        $statusFormatted['Filament Winding'] = $row['qty'];
      }

      if ($row['status_id'] == 3) {
        $statusFormatted['Bonding'] = $row['qty'];
      }

      if ($row['status_id'] == 4) {
        $statusFormatted['Torque Testing'] = $row['qty'];
      }

      if ($row['status_id'] == 5) {
        $statusFormatted['Dynamic Balancing'] = $row['qty'];
      }

      if ($row['status_id'] == 6) {
        $statusFormatted['Inspection'] = $row['qty'];
      }

      if ($row['status_id'] == 7) {
        $statusFormatted['Packaging'] = $row['qty'];
      }

      if ($row['status_id'] == 8) {
        $statusFormatted['Dispatch'] = $row['qty'];
      }
    }

    // ✅ FINAL QTY
    $statusFormatted['Qty'] = $maxQty;

    $data['statusFormatted'] = $statusFormatted;

    $this->load->view(ADMIN . 'production/view_indent_cfds', $data);
  }

  public function CreateOrderfor_frp_headerpipe($id = "", $blade_indent_id = "", $indent_no = "")
  {
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $company_id = $this->session->userdata('company_id');
    // print_r($_FILES);die; 
    if ($_POST) {

      $post = $_POST;
      // echo"<pre>";
      // print_r($post);
      // die();
      $converted_date = !empty($post['date']) ? date('Y-m-d', strtotime($post['date'])) : date('Y-m-d');
      $delivery_date = !empty($post['delivery_date']) ? date('Y-m-d', strtotime($post['delivery_date'])) : NULL;

      $client_id = $this->session->userdata('user_id');
      $plant_id = $this->session->userdata('company_id');

      $indent_id = $post['indent_db_id'] ?? '';

      if (!empty($indent_id)) {

        // Existing indent → use stored values
        $existingIndent = $this->CommonModel->getData(
          'tbl_indent',
          ['id' => $indent_id],
          '*',
          '',
          'row_array'
        );

        $indentSequence = !empty($existingIndent['indent_sequence'])
          ? $existingIndent['indent_sequence']
          : $this->IndentModel->getIndentSequenceNumber();

        $indentNo = !empty($existingIndent['indent_no'])
          ? $existingIndent['indent_no']
          : $this->IndentModel->getindentNumber();

        $manualIndentNo = $existingIndent['indent_number'] ?? '';
      } else {

        // New indent
        $indentSequence = !empty($post['indent_sequence'])
          ? $post['indent_sequence']
          : $this->IndentModel->getIndentSequenceNumber();

        $indentNo = !empty($post['indent_no'])
          ? $post['indent_no']
          : $this->IndentModel->getindentNumber();

        $manualIndentNo = $post['manual_indent_no'] ?? '';
      }
      $array_indent = [
        'client_id'       => $client_id,
        'plant_id'        => $plant_id,
        'indent_no'       => $indentNo,
        'date'            => $converted_date,
        'delivery_date'   => $delivery_date,
        'indent_sequence' => $indentSequence,
        'indent_number'   => $manualIndentNo,
        'is_lock'         => 1
      ];

      if (!empty($indent_id)) {
        $array_indent['updated_by'] = userId();
        $array_indent['updated_at'] = date('Y-m-d H:i:s');
        // $array_indent['indent_no'] = $post['indent_no'];
        $this->CommonModel->iudAction('tbl_indent', $array_indent, 'update', ['id' => $indent_id]);
      } else {
        $array_indent['created_by'] = userId();

        $indent_id = $this->CommonModel->iudAction('tbl_indent', $array_indent, 'insert');
      }

      if ($indent_id) {

        $moduleData = [
          'master_indent_id' => 21,
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'dimension' => $post['dimension'] ?? '',
          'material' => $post['material'] ?? '',
          'remark' => $post['remark'] ?? '',
          'qty' => $post['order_qty'] ?? '',
          'make' => $post['make'] ?? '',
        ];


        $design_file = null;

        if (!empty($_FILES['design_file']['name'])) {
          $result = fileUpload(FRP_HEADER_PIPE_DESIGN_FILE, 'design_file');
          if ($result['status'] == true) {
            $design_file = $result['image_name'];
          }
        }

        if ($design_file) {
          $moduleData['design_file'] = $design_file;
        }

        $existingModule = $this->CommonModel->getData(
          'tbl_indent_frp_header_pipe',
          ['indent_id' => $indent_id],
          '*',
          '',
          'row_array'
        );

        if (!empty($existingModule)) {

          $moduleData['updated_at'] = date('Y-m-d H:i:s');
          $moduleData['updated_by'] = userId();
          $moduleData['qty'] = ($post['totalorder_qty'] ?? 0) - ($post['order_qty'] ?? 0);

          $this->CommonModel->iudAction(
            'tbl_indent_frp_header_pipe',
            $moduleData,
            'update',
            ['indent_id' => $indent_id]
          );

          $indent_module_id = $existingModule['id'];
        } else {

          $moduleData['created_at'] = date('Y-m-d H:i:s');
          $moduleData['created_by'] = userId();

          $indent_module_id = $this->CommonModel->iudAction(
            'tbl_indent_frp_header_pipe',
            $moduleData,
            'insert'
          );
        }

        $data_details_data = [
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'master_indent_id' => 21,
          'ref_id' => $indent_module_id,
          'created_by' => userId(),
          'created_at' => date('Y-m-d H:i:s')
        ];

        $existingDetail = $this->CommonModel->getData(
          'tbl_indent_details',
          [
            'indent_id' => $indent_id,
            'master_indent_id' => 21
          ],
          '*',
          '',
          'row_array'
        );

        if ($existingDetail) {
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $data_details_data,
            'update',
            ['id' => $existingDetail['id']]
          );
        } else {
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $data_details_data,
            'insert'
          );
        }

        $this->db->where('indent_sub_id', $indent_module_id);
        $this->db->delete('tbl_frp_header_pipe_specifications');

        $spec_id = $this->input->post('spec_id') ?: [];
        $group_qty = $this->input->post('group_qty') ?: [];
        $ext_group_qty = $this->input->post('ext_group_qty') ?: [];

        $oldSpecs = [];

        $existingSpecs = $this->db
          ->where('indent_sub_id', $indent_module_id)
          ->get('tbl_frp_header_pipe_specifications')
          ->result_array();

        foreach ($existingSpecs as $oldSpec) {
          $oldSpecs[$oldSpec['id']] = $oldSpec;
        }
        foreach ($group_qty as $i => $qty) {

          $oldQty = (float)($qty ?? 0);

          if (!empty($spec_id[$i]) && isset($oldSpecs[$spec_id[$i]])) {
            $oldQty = (float)$oldSpecs[$spec_id[$i]]['group_qty'];
          }

          $extQty = (float)($ext_group_qty[$i] ?? 0);

          $group_qty[$i] = $oldQty - $extQty;

          if ($group_qty[$i] < 0) {
            $group_qty[$i] = 0;
          }
        }
        $length_dia = $this->input->post('length_dia') ?: [];

        if (!empty($group_qty)) {

          $this->db->where('indent_sub_id', $indent_module_id);
          $this->db->delete('tbl_frp_header_pipe_specifications');

          foreach ($group_qty as $i => $qty) {

            if (empty($qty))
              continue;
            $specData = [
              'indent_id' => $indent_id,
              'indent_sub_id' => $indent_module_id,
              'group_qty' => $qty,
              'length_dia' => $length_dia[$i] ?? null,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s'),

            ];

            $this->CommonModel->iudAction(
              'tbl_frp_header_pipe_specifications',
              $specData,
              'insert'
            );
          }
        }
      }

      $issuedQty = !empty($post['ext_group_qty'])
        ? array_sum($post['ext_group_qty'])
        : 0;

      $lastOrder = $this->db
        ->where('indent_id', $indent_id)
        ->order_by('id', 'DESC')
        ->get('tbl_indent_frp_header_pipe_received_orders')
        ->row_array();

      $oldTotalQty = !empty($lastOrder)
        ? (float)$lastOrder['total_order_qty']
        : (float)$post['order_qty'];

      $newTotalQty = $oldTotalQty - $issuedQty;

      if ($newTotalQty < 0) {
        $newTotalQty = 0;
      }

      $orderData = [
        'order_for'        => $post['order_for'],
        'indent_date'      => $post['indent_date'],
        'delivery_date'    => $delivery_date,
        'party_id'         => $plant_id,
        'indent_id'        => $indent_id,
        'manual_indent_no' => $array_indent['indent_number'],
        'remark'           => $post['remark'] ?? '',
        'total_order_qty'  => $newTotalQty,
        'order_qty'        => $issuedQty,
        'created_by'       => userId(),
        'created_at'       => date('Y-m-d H:i:s')
      ];

      $order_id = $this->CommonModel->iudAction(
        'tbl_indent_frp_header_pipe_received_orders',
        $orderData,
        'insert'
      );

      if ($order_id) {

        $stages = $this->db
          ->order_by('sequence', 'ASC')
          ->get('tbl_frp_header_pipe_stage_master')
          ->result();

        foreach ($stages as $stage) {

          $detailData = [
            'order_id'   => $order_id,
            'status_id'  => $stage->id,
            'qty'        => 0,
            'company_id' => $company_id,
            'created_by' => userId(),
            'created_at' => date('Y-m-d H:i:s')
          ];

          $this->CommonModel->iudAction(
            'tbl_indent_frp_header_pipe_received_order_status_detail',
            $detailData,
            'insert'
          );
        }

        $statusData = [
          'order_id'            => $order_id,
          'qty'                 => $newTotalQty,
          'order_qty'           => $issuedQty,
          'indent_transfer_qty' => 0,
          'company_id'          => $company_id,
          'created_qty'         => 0,
          'created_by'          => userId(),
          'created_at'          => date('Y-m-d H:i:s')
        ];

        $this->CommonModel->iudAction(
          'tbl_indent_frp_header_pipe_received_order_status',
          $statusData,
          'insert'
        );
      }

      $this->session->set_flashdata('success', 'Order Saved Successfully!');
      redirect(base_url(ADMIN . 'production/Indent/frp_header_pipe_indent'));
    }

    // LOAD VIEW
    $blade = $this->IndentModel->indentDetailsforfrphp($id, $blade_indent_id, $indent_no);

    $data['blade_data'] = $blade;
    $data['specifications'] = $blade['specifications'] ?? [];
    $data['type'] = "1";

    // echo'<pre>';
    // print_r($data);
    // die;

    $this->load->view(ADMIN . 'production/frp_header_pipe/createorder_for_frpheaderpipe', $data);
  }


  //2 for Header Pipe 
  public function frp_header_pipe_indent()
  {
    $data['title'] = 'Frp Header Pipe Indent';
    $data['type'] = "2";
    $this->load->view(ADMIN . 'production/frp_header_pipe/list_header_pipe_indent', $data);
  }

  public function list_header_pipe()
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

    // if ($data['indentid'] == "all") {
    if ($data['indentid'] == "all") {
      $where = array();
    } else {
      $where['tid.master_indent_id'] = 21;
    }

    $from_date = $data['from_date'] ?? '';
    $to_date   = $data['to_date'] ?? '';

    if (!empty($from_date)) {
      $where['DATE(i.date) >='] = $from_date;
    }

    if (!empty($to_date)) {
      $where['DATE(i.date) <='] = $to_date;
    }


    $count = count($this->IndentModel->getheaderpipeIndentData($searchVal, 0, 0, 0, 0, 0, $where, $from_date, $to_date));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->IndentModel->getheaderpipeIndentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where, $from_date, $to_date);
      foreach ($result as $key => $value) {
        $total = $this->IndentModel->getSum($value['indent_no']);

        $row = [];
        $checkbox = '
          <input type="checkbox"
          class="header_pipe_checkbox"
          name="selected_rows[]"
          value="' . $value['indent_no'] . '">
          ';
        array_push($row, $checkbox);
        array_push($row, $offset + ($key + 1));
        array_push($row, $value['client_name']);
        array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['indent_number']);
        array_push($row, $value['date']);


        $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";



        $check_exist1 = $this->CommonModel->getData('tbl_indent_order', array('indent_id' => $value['indent_no']), '', '', 'num_rows');
        $checkSameQuantity = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $value['indent_number']], 'SUM(order_qty) as totalOrderQty,blade_qty', '', 'result_array');
        // print_r($checkSameQuantity);die;

        if ($check_exist1) {
          $action = ' <a href="' . base_url() . 'admin/production/Indent/view_frp_headerpipe/' . $value['indent_no'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        } else {
          $action = '';
        }

        $action .= '<a onclick="return " href="' . base_url() . 'admin/production/Indent/exportpdf_header_pipe/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Export PDF" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" target="_blank">
                      <i class="fas fa-file-pdf"></i>
                    </a>

                    <a href="' . base_url() . 'admin/production/Indent/exportexcel_header_pipe/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Export Excel"
                      class="btn btn-success waves-effect waves-light btn-sm"
                      target="_blank" target="_blank">
                      <i class="fas fa-file-excel"></i>
                    </a>
                    
                    <a onclick="return " href="' . base_url() . 'admin/production/Indent/CreateOrderfor_frp_headerpipe/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                     title="Create Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" >
                     <i class="fas fa-check-square" aria-hidden="true"></i>
                    </a>';

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

  public function exportpdf_header_pipe($indent_id, $indent_bland_id, $indent_no)
  {
    $data['indent_details'] = $this->IndentModel->getfrphpExportIndentDetails($indent_no);

    $html = $this->load->view(
      'admin/production/pdf/header_pipe_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'landscape');
    $pdf->render();

    $pdf->stream(
      'HP_' . $indent_no . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_frphp_pdf()
  {
    $ids = $this->input->get('ids');

    if (empty($ids)) {
      show_error('No rows selected');
    }

    $indentNos = explode(',', $ids);

    $data['indent_details'] =
      $this->IndentModel
      ->getfrphpExportIndentDetailsSelected($indentNos);

    $html = $this->load->view(
      'admin/production/pdf/header_pipe_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();

    $pdf->loadHtml($html);

    $pdf->setPaper('A4', 'landscape');

    $pdf->render();

    $pdf->stream(
      'HP_SELECTED_' . date('YmdHis') . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function exportexcel_header_pipe($indent_id, $indent_bland_id, $indent_no)
  {
    $details = $this->IndentModel->getfrphpExportIndentDetailsSelected($indent_no);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'QTY',
      'F1' => 'LENGTH DIAMETER',
      'G1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:G1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);

    $row = 2;
    $sr = 1;

    foreach ($details as $value) {

      $sheet->setCellValue('A' . $row, $sr);

      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );

      $sheet->setCellValue(
        'C' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );

      $sheet->setCellValue(
        'D' . $row,
        !empty($value['client_name'])
          ? strtoupper($value['client_name'])
          : '-'
      );

      $sheet->setCellValue(
        'E' . $row,
        !empty($value['group_qty'])
          ? $value['group_qty']
          : '-'
      );

      $sheet->setCellValue(
        'F' . $row,
        !empty($value['length_dia'])
          ? $value['length_dia']
          : '-'
      );

      $sheet->setCellValue(
        'G' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );


      // ROW STYLE

      $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'G') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'HP_SELECTED_' . date('YmdHis') . '.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }

  public function export_selected_frphp_excel()
  {
    $ids = $this->input->get('ids');

    $indentNos = explode(',', $ids);

    $details =
      $this->IndentModel
      ->getfrphpExportIndentDetailsSelected($indentNos);


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'QTY',
      'F1' => 'LENGTH DIAMETER',
      'G1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:G1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);

    $row = 2;
    $sr = 1;

    foreach ($details as $value) {

      $sheet->setCellValue('A' . $row, $sr);

      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );

      $sheet->setCellValue(
        'C' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );

      $sheet->setCellValue(
        'D' . $row,
        !empty($value['client_name'])
          ? strtoupper($value['client_name'])
          : '-'
      );

      $sheet->setCellValue(
        'E' . $row,
        !empty($value['group_qty'])
          ? $value['group_qty']
          : '-'
      );

      $sheet->setCellValue(
        'F' . $row,
        !empty($value['length_dia'])
          ? $value['length_dia']
          : '-'
      );

      $sheet->setCellValue(
        'G' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );


      // ROW STYLE

      $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'G') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'HP_SELECTED_' . date('YmdHis') . '.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }


  public function createorder_frp_headerpipe($id = '')
  {
    $data['type'] = "2";
    $data['title'] = 'Create Order For Frp Header Pipe';
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();
    $this->load->view(ADMIN . 'production/frp_header_pipe/createorder_for_frpheaderpipe', $data);
  }

  public function view_header_pipe_indent_details($id, $indent_no)
  {
    $data['indentDetails'] = $this->IndentModel->frpheaderpipeOrderDetails($id);
    $data['specifications'] = $this->IndentModel->frpheaderpipeSpecifications($id);

    $order_status_details = $this->IndentModel->frpheaderpipeOrderStatusDetails($id);

    $statusFormatted = [
      'Qty' => 0,
      'Design selection' => 0,
      'Filament Winding' => 0,
      'Size cutting' => 0,
      'Flange making' => 0,
      'Pipe coupler join' => 0,
      'Finishing' => 0,
      'Inspection' => 0,
      'Packaging' => 0,
      'Dispatch' => 0,
    ];

    $maxQty = 0;

    foreach ($order_status_details as $row) {

      if ($row['qty'] > $maxQty) {
        $maxQty = $row['qty'];
      }

      if ($row['status_id'] == 1) {
        $statusFormatted['Design selection'] = $row['qty'];
      }

      if ($row['status_id'] == 2) {
        $statusFormatted['Filament Winding'] = $row['qty'];
      }

      if ($row['status_id'] == 3) {
        $statusFormatted['Size cutting'] = $row['qty'];
      }

      if ($row['status_id'] == 4) {
        $statusFormatted['Flange making'] = $row['qty'];
      }

      if ($row['status_id'] == 5) {
        $statusFormatted['Pipe coupler join'] = $row['qty'];
      }

      if ($row['status_id'] == 6) {
        $statusFormatted['Finishing'] = $row['qty'];
      }

      if ($row['status_id'] == 7) {
        $statusFormatted['Inspection'] = $row['qty'];
      }

      if ($row['status_id'] == 8) {
        $statusFormatted['Packaging'] = $row['qty'];
      }

      if ($row['status_id'] == 9) {
        $statusFormatted['Dispatch'] = $row['qty'];
      }
    }

    // ✅ FINAL QTY
    $statusFormatted['Qty'] = $maxQty;

    $data['statusFormatted'] = $statusFormatted;

    $this->load->view(ADMIN . 'production/frp_header_pipe/view_header_pipe_indent_details', $data);
  }

  public function frp_header_pipe_received_order()
  {
    $data['title'] = 'Frp Header Pipe Received Order';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 2), 'id,indent_name');
    //  print_r($data['indent_name']);die;
    $this->load->view(ADMIN . 'production/frp_header_pipe/list_frp_header_pipe_received_order', $data);
  }

  public function list_frp_header_pipe_received_orders()
  {
    $data = $_POST;

    $limit = $data['length'];
    $offset = $data['start'];
    $search = $data['search']['value'];

    $result = $this->IndentModel->getFRPHPorderStatusData($search, $limit, $offset);
    $rows = [];
    $sr = $offset;

    foreach ($result as $value) {
      if ((float) $value['order_qty'] <= 0) {
        continue;
      }
      $sr++;

      $row = [];

      $total = ($value['total_order_qty']);

      array_push(
        $row,
        '
                <i class="fas fa-plus-circle plus-icon clickableRow"
                    data-id="' . $value['id'] . '"
                    data-indent="' . $value['indent_no'] . '"
                    data-manual="' . $value['manual_indent_no'] . '"
                    data-company="' . $value['company_name'] . '"
                    data-total="' . $value['total_order_qty'] . '"
                    data-order-qty="' . $value['order_qty'] . '">
                </i> ' . $sr
      );

      $orderFor = ($value['order_for'] == 1) ? 'Indent' : 'Self';
      array_push($row, $orderFor);

      array_push($row, $value['indent_no']);
      array_push($row, $value['manual_indent_no']);
      array_push($row, $value['indent_date']);
      array_push($row, $value['company_name']);

      array_push($row, '<span class="badge badge-success">' . $total . '</span>');
      array_push($row, '<span class="badge badge-warning">' . $value['order_qty'] . '</span>');

      array_push($row, '<span class="label design-selection openModal"
                            data-id="' . $value['id'] . '"
                            data-indent="' . $value['indent_no'] . '"
                            data-manual="' . $value['manual_indent_no'] . '"
                            data-company="' . $value['company_name'] . '"
                            data-total="' . $value['total_order_qty'] . '"
                            data-created="' . $value['design'] . '"
                            data-order-qty="' . $value['order_qty'] . '"
                            style="cursor:pointer;">
                            ' . $value['design'] . '
                        </span>');

      array_push($row, '<span class="label custome-received">' . $value['filament'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['size_cutting'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['flange_making'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['pipe_coupler_join'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['finishing'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['inspection'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['packaging'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['dispatch'] . '</span>');

      $action = '<a href="' . base_url() . 'admin/production/Indent/view_header_pipe_indent_details/' . $value['id'] . '/' . $value['indent_id'] . '" 
                    class="btn btn-primary btn-sm" style="background:#F0F0F0;color:gray;">
                    <i class="fas fa-eye"></i>
                  </a>

                 ';
      //  <a href="javascript:void(0);" class="btn btn-primary btn-sm m-1" 
      //                     style="background:#F0F0F0;color:gray;"
      //                     onclick="openInterChangeModal(' . $value['id'] . ')">
      //                     <i class="fas fa-exchange-alt"></i>
      //                   </a>
      array_push($row, $action);

      $rows[] = $row;
    }

    echo json_encode([
      "draw" => intval($data['draw']),
      "recordsTotal" => count($rows),
      "recordsFiltered" => count($rows),
      "data" => $rows
    ]);
  }


  //3. Clamp Indent 
  public function frp_clamp_indent()
  {
    $data['title'] = 'FRP Clamp';
    $this->load->view(ADMIN . 'production/frp_clamp/list_frp_clamp_indent', $data);
  }

  public function list_frp_clamp()
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

    // if ($data['indentid'] == "all") {
    if ($data['indentid'] == "all") {
      $where = array();
    } else {
      $where['tid.master_indent_id'] = 22;
    }

    $from_date = $data['from_date'] ?? '';
    $to_date   = $data['to_date'] ?? '';

    if (!empty($from_date)) {
      $where['DATE(i.date) >='] = $from_date;
    }

    if (!empty($to_date)) {
      $where['DATE(i.date) <='] = $to_date;
    }


    $count = count($this->IndentModel->getClampIndentData($searchVal, 0, 0, 0, 0, 0, $where, $from_date, $to_date));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->IndentModel->getClampIndentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where, $from_date, $to_date);
      // echo"<pre>";
      // print_r($result);die;

      foreach ($result as $key => $value) {
        $total = $this->IndentModel->getSum($value['indent_no']);
        $row = [];
        $checkbox = '
          <input type="checkbox"
          class="header_pipe_checkbox"
          name="selected_rows[]"
          value="' . $value['indent_no'] . '">
          ';
        array_push($row, $checkbox);
        array_push($row, $offset + ($key + 1));
        array_push($row, $value['client_name']);
        array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['indent_number']);
        array_push($row, $value['date']);


        $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";



        $check_exist1 = $this->CommonModel->getData('tbl_indent_order', array('indent_id' => $value['indent_no']), '', '', 'num_rows');
        $checkSameQuantity = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $value['indent_number']], 'SUM(order_qty) as totalOrderQty,blade_qty', '', 'result_array');
        // print_r($checkSameQuantity);die;

        if ($check_exist1) {
          $action = ' <a href="' . base_url() . 'admin/production/Indent/view_frp_headerpipe/' . $value['indent_no'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        } else {
          $action = '';
        }

        $action .= ' <a onclick="return " href="' . base_url() . 'admin/production/Indent/exportpdf_frp_clamp/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Export PDF" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" target="_blank">
                      <i class="fas fa-file-pdf"></i>
                    </a>

                    <a href="' . base_url() . 'admin/production/Indent/exportexcel_frp_clamp/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Export Excel"
                      class="btn btn-success waves-effect waves-light btn-sm"
                      target="_blank" target="_blank">
                      <i class="fas fa-file-excel"></i>
                    </a>
                    
                    <a onclick="return " 
                      href="' . base_url() . 'admin/production/Indent/Createorderfor_frp_clamp/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
                      title="Create Order" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" >
                      <i class="fas fa-check-square" aria-hidden="true"></i>
                    </a>';

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

  public function create_order_for_frp_clamp($id = '')
  {
    $data['title'] = 'Create Order For Frp Clamp';
    $data['type'] = "2";
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();
    $data['clamp_type'] = $this->CommonModel->getData('tbl_master_indent_clamp_type', ['status' => 1], 'id,name');
    $data['clamp_material'] = $this->CommonModel->getData('tbl_master_indent_clamp_material', ['status' => 1], 'id,name');

    $this->load->view(ADMIN . 'production/frp_clamp/createorder_for_frpclamp', $data);
  }

  public function exportpdf_frp_clamp($indent_id, $indent_bland_id, $indent_no)
  {
    $data['indent_details'] = $this->IndentModel->getfrpClampExportIndentDetails($indent_no);

    $html = $this->load->view(
      'admin/production/pdf/frp_clamp_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'landscape');
    $pdf->render();

    $pdf->stream(
      'CLAMP_' . $indent_no . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_frp_clamp_pdf()
  {
    $ids = $this->input->get('ids');

    if (empty($ids)) {
      show_error('No rows selected');
    }

    $indentNos = explode(',', $ids);

    $data['indent_details'] =
      $this->IndentModel
      ->getfrpClampExportIndentDetailsSelected($indentNos);

    $html = $this->load->view(
      'admin/production/pdf/frp_clamp_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();

    $pdf->loadHtml($html);

    $pdf->setPaper('A4', 'landscape');

    $pdf->render();

    $pdf->stream(
      'CLAMP_SELECTED_' . date('YmdHis') . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_frpclamp_excel()
  {
    $ids = $this->input->get('ids');

    $indentNos = explode(',', $ids);

    $details =
      $this->IndentModel
      ->getfrphpExportIndentDetailsSelected($indentNos);


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'QTY',
      'F1' => 'CLAMP SIZE',
      'G1' => 'MATERIAL',
      'H1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:H1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);

    $row = 2;
    $sr = 1;

    foreach ($details as $value) {

      $sheet->setCellValue('A' . $row, $sr);

      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );

      $sheet->setCellValue(
        'C' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );

      $sheet->setCellValue(
        'D' . $row,
        !empty($value['client_name'])
          ? strtoupper($value['client_name'])
          : '-'
      );

      $sheet->setCellValue(
        'E' . $row,
        !empty($value['qty'])
          ? $value['qty']
          : '-'
      );

      $sheet->setCellValue(
        'F' . $row,
        !empty($value['clamp_size'])
          ? $value['clamp_size']
          : '-'
      );

      $sheet->setCellValue(
        'G' . $row,
        !empty($value['material'])
          ? $value['material']
          : '-'
      );

      $sheet->setCellValue(
        'H' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );


      // ROW STYLE

      $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'H') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'CLAMP_SELECTED_' . date('YmdHis') . '.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }


  public function exportexcel_frp_clamp($indent_id, $indent_bland_id, $indent_no)
  {
    $details = $this->IndentModel->getfrpClampExportIndentDetailsSelected($indent_no);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      'A1' => 'SR. NO.',
      'B1' => 'INDENT NO.',
      'C1' => 'DATE',
      'D1' => 'CLIENT',
      'E1' => 'QTY',
      'F1' => 'CLAMP SIZE',
      'G1' => 'MOC',
      'H1' => 'DELIVERY',
    ];

    foreach ($headers as $cell => $value) {
      $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:H1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ]);

    $row = 2;
    $sr = 1;

    foreach ($details as $value) {

      $sheet->setCellValue('A' . $row, $sr);

      $sheet->setCellValue(
        'B' . $row,
        !empty($value['indent_number'])
          ? $value['indent_number']
          : '-'
      );

      $sheet->setCellValue(
        'C' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );

      $sheet->setCellValue(
        'D' . $row,
        !empty($value['client_name'])
          ? strtoupper($value['client_name'])
          : '-'
      );

      $sheet->setCellValue(
        'E' . $row,
        !empty($value['qty'])
          ? $value['qty']
          : '-'
      );

      $sheet->setCellValue(
        'F' . $row,
        !empty($value['clamp_size'])
          ? $value['clamp_size']
          : '-'
      );

      $sheet->setCellValue(
        'G' . $row,
        !empty($value['material'])
          ? $value['material']
          : '-'
      );

      $sheet->setCellValue(
        'H' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );


      // ROW STYLE

      $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
          'vertical' => Alignment::VERTICAL_CENTER,
          'wrapText' => true,
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      $row++;
      $sr++;
    }

    foreach (range('A', 'H') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'CLAMP_SELECTED_' . date('YmdHis') . '.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    $writer->save('php://output');

    exit;
  }


  public function Createorderfor_frp_clamp($id = "", $blade_indent_id = "", $indent_no = "")
  {
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $company_id = $this->session->userdata('company_id');

    if ($_POST) {
      $post = $_POST;
      $converted_date = !empty($post['date']) ? date('Y-m-d', strtotime($post['date'])) : date('Y-m-d');
      $delivery_date = !empty($post['delivery_date']) ? date('Y-m-d', strtotime($post['delivery_date'])) : NULL;

      $client_id = $this->session->userdata('user_id');
      $plant_id = $this->session->userdata('company_id');

      $indent_id = $post['indent_db_id'] ?? '';

      if (!empty($indent_id)) {

        // Existing indent → use stored values
        $existingIndent = $this->CommonModel->getData(
          'tbl_indent',
          ['id' => $indent_id],
          '*',
          '',
          'row_array'
        );

        $indentSequence = !empty($existingIndent['indent_sequence'])
          ? $existingIndent['indent_sequence']
          : $this->IndentModel->getIndentSequenceNumber();

        $indentNo = !empty($existingIndent['indent_no'])
          ? $existingIndent['indent_no']
          : $this->IndentModel->getindentNumber();

        $manualIndentNo = $existingIndent['indent_number'] ?? '';
      } else {

        // New indent
        $indentSequence = !empty($post['indent_sequence'])
          ? $post['indent_sequence']
          : $this->IndentModel->getIndentSequenceNumber();

        $indentNo = !empty($post['indent_no'])
          ? $post['indent_no']
          : $this->IndentModel->getindentNumber();

        $manualIndentNo = $post['indent_number'] ?? '';
      }
      $array_indent = [
        'client_id'       => $client_id,
        'plant_id'        => $plant_id,
        'indent_no'       => $indentNo,
        'date'            => $converted_date,
        'delivery_date'   => $delivery_date,
        'indent_sequence' => $indentSequence,
        'indent_number'   => $manualIndentNo,
        'is_lock'         => 1
      ];


      if (!empty($indent_id)) {
        $array_indent['updated_by'] = userId();
        $array_indent['updated_at'] = date('Y-m-d H:i:s');
        $this->CommonModel->iudAction('tbl_indent', $array_indent, 'update', ['id' => $indent_id]);
      } else {
        $array_indent['created_by'] = userId();
        $indent_id = $this->CommonModel->iudAction('tbl_indent', $array_indent, 'insert');
      }

      if ($indent_id) {
        // echo '<pre>';
        // print_r($_POST);
        // die();
        $moduleData = [
          'master_indent_id' => 22,
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'clamp_size' => $post['clamp_size'] ?? '',
          'material' => $post['material'] ?? '',
          'remark' => $post['remark'] ?? '',
          'qty' => $post['qty'] ?? '',
          'make' => $post['make'] ?? '',
        ];

        $existingModule = $this->CommonModel->getData(
          'tbl_indent_frp_clamp',
          [
            'indent_id' => $indent_id,
            'master_indent_id' => 22
          ],
          '*',
          '',
          'row_array'
        );

        if (!empty($existingModule)) {
          // echo '<pre>';
          // print_r($indent_id);
          // die();
          $moduleData = [
            'master_indent_id' => 22,
            'indent_id' => $indent_id,
            'plant_id' => $plant_id,
            'clamp_size' => $post['clamp_size'] ?? '',
            'material' => $post['material'] ?? '',
            'remark' => $post['remark'] ?? '',
            'qty' => $post['qty'] ?? '',
            'make' => $post['make'] ?? '',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => userId(),
          ];
          $this->CommonModel->iudAction(
            'tbl_indent_frp_clamp',
            $moduleData,
            'update',
            ['indent_id' => $indent_id]
          );

          $indent_module_id = $existingModule['id'];
        } else {

          $moduleData['created_at'] = date('Y-m-d H:i:s');
          $moduleData['created_by'] = userId();

          $indent_module_id = $this->CommonModel->iudAction(
            'tbl_indent_frp_clamp',
            $moduleData,
            'insert'
          );
        }

        $indent_details_data = [
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'master_indent_id' => 22,
          'ref_id' => $indent_module_id,
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => userId(),
        ];

        $existingDetail = $this->CommonModel->getData(
          'tbl_indent_details',
          [
            'indent_id' => $indent_id,
            'master_indent_id' => 22,
          ],
          '*',
          '',
          'row_array'
        );

        if ($existingDetail) {
          // echo '<pre>';
          // print_r('existing details found');
          // die();
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $indent_details_data,
            'update',
            ['id' => $existingDetail['id']]
          );
        } else {
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $indent_details_data,
            'insert'
          );
        }

        // $this->db->where('indent_sub_id', $indent_module_id);
        // $this->db->delete('tbl_frp_clamp_specifications');

        $specification = [
          'indent_id' => $indent_id,
          'indent_sub_id' => $indent_module_id,
          'pcd_1' => $post['pcd_1'] ?? '',
          'pcd_2' => $post['pcd_2'] ?? '',
          'drill_size' => $post['drill_size'] ?? '',
          'length' => $post['length'] ?? '',
          'width' => $post['width'] ?? '',
          'height' => $post['height'] ?? '',
        ];

        $existingSpec = $this->CommonModel->getData(
          'tbl_frp_clamp_specifications',
          [
            'indent_id' => $indent_id,
            'indent_sub_id' => $indent_module_id
          ],
          '*',
          '',
          'row_array'
        );

        if (!empty($existingSpec)) {

          // echo '<pre>';
          // print_r($indent_id);
          // die();

          $specification['updated_at'] = date('Y-m-d H:i:s');
          $specification['updated_by'] = userId();

          $this->CommonModel->iudAction(
            'tbl_frp_clamp_specifications',
            $specification,
            'update',
            ['id' => $existingSpec['id']]
          );
        } else {
          $specification['created_at'] = date('Y-m-d H:i:s');
          $specification['created_by'] = userId();

          $this->CommonModel->iudAction(
            'tbl_frp_clamp_specifications',
            $specification,
            'insert'
          );
        }
      }

      $order_id = $this->input->post('order_id');
      // echo '<pre>';
      // print_r($order_id);
      // die();

      $ext_total_order_qty = $this->CommonModel->getData(
        'tbl_indent_frp_clamp_received_orders',
        [
          'id' => $order_id,
        ],
        'total_order_qty',
        '',
        'row_array'
      );

      $total_order_qty = $ext_total_order_qty['total_order_qty'] - $post['qty'] ?? 0;

      $orderData = [
        'order_for' => $post['order_for'],
        'indent_date' => $converted_date,
        'delivery_date' => $delivery_date,
        'party_id' => $client_id,
        'indent_id' => $indent_id,
        'manual_indent_no' => $post['indent_number'],
        'total_order_qty' => $total_order_qty,
        'order_qty' => $post['qty'],
        'remark' => $post['remark'],
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => userId(),
      ];
      if (!empty($order_id)) {

        if (isset($order_id)) {
          $total_order_qty = $ext_total_order_qty['total_order_qty'] - $post['qty'] ?? 0;
        }

        $orderData = [
          'order_for' => $post['order_for'],
          'indent_date' => $converted_date,
          'delivery_date' => $delivery_date,
          // 'client_id' => $client_id,
          'party_id' => $client_id,
          'indent_id' => $indent_id,
          'manual_indent_no' => $post['indent_number'],
          'total_order_qty' => $total_order_qty,
          'order_qty' => $post['qty'] ?? 0,
          'remark' => $post['remark'] ?? '',
          'updated_by' => userId(),
          'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->CommonModel->iudAction(
          'tbl_indent_frp_clamp_received_orders',
          $orderData,
          'insert',
          // ['id' => $order_id]
        );

        $this->db->where('order_id', $order_id)
          ->update(
            'tbl_indent_frp_clamp_received_order_status',
            [
              'order_qty' => $post['qty'] ?? 0,
              'updated_by' => userId(),
              'updated_at' => date('Y-m-d H:i:s')
            ]
          );
      } else {
        // echo '<pre>';
        // print_r($orderData);
        // die();
        $orderData = [
          'order_for' => $post['order_for'],
          'indent_date' => $converted_date,
          'delivery_date' => $delivery_date,
          'party_id' => $client_id,
          'indent_id' => $indent_id,
          'manual_indent_no' => $post['indent_number'],
          'total_order_qty' => $post['qty'] ?? 0,
          'order_qty' => 0,
          'remark' => $post['remark'] ?? '',
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => userId(),
        ];

        $order_id = $this->CommonModel->iudAction(
          'tbl_indent_frp_clamp_received_orders',
          $orderData,
          'insert'
        );

        // if($order_id){
        //   echo '<pre>';
        //   print_r('inserted order id '.$order_id);
        //   die();
        // }

        if ($order_id) {

          $stages = $this->db->order_by('sequence', 'ASC')
            ->get('tbl_frp_clamp_stage_master')
            ->result();

          foreach ($stages as $stage) {

            $this->CommonModel->iudAction(
              'tbl_indent_frp_clamp_received_order_status_detail',
              [
                "order_id" => $order_id,
                "status_id" => $stage->id,
                "qty" => 0,
                "company_id" => $company_id,
                "created_by" => userId(),
                "created_at" => date('Y-m-d H:i:s')
              ],
              'insert'
            );
          }

          $this->CommonModel->iudAction(
            'tbl_indent_frp_clamp_received_order_status',
            [
              "order_id" => $order_id,
              'qty' => $post['qty'] ?? '',
              'order_qty' => $post['total_order_qty'] ?? '',
              'company_id' => $company_id,
              'created_by' => userId(),
              'created_at' => date('Y-m-d H:i:s')
            ],
            'insert'
          );
        }
      }
      $this->session->set_flashdata('success', 'Order Saved Successfully!');
      redirect(base_url(ADMIN . 'production/Indent/frp_clamp_indent'));
    }
    $blade = $this->IndentModel->indentDetailsforfrpclamp($id, $blade_indent_id, $indent_no);
    $data['blade_data'] = $blade;
    $data['clamp_type'] = $this->CommonModel->getData('tbl_master_indent_clamp_type', ['status' => 1], 'id,name');
    $data['clamp_material'] = $this->CommonModel->getData('tbl_master_indent_clamp_material', ['status' => 1], 'id,name');

    $data['type'] = "1";
    // echo "<pre>";
    // print_r($data);
    // die();
    $this->load->view(ADMIN . 'production/frp_clamp/createorder_for_frpclamp', $data);
  }

  public function frp_clamp_received_order()
  {
    $data['title'] = 'Frp Clamp Received Order';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 2), 'id,indent_name');
    //  print_r($data['indent_name']);die;
    $this->load->view(ADMIN . 'production/frp_clamp/list_frp_clamp_received_order', $data);
  }
  public function list_frp_clamp_received_orders()
  {
    $data = $_POST;

    $limit = $data['length'];
    $offset = $data['start'];
    $search = $data['search']['value'];

    $result = $this->IndentModel->getFRPClamporderStatusData($search, $limit, $offset);
    $rows = [];
    $sr = $offset;

    foreach ($result as $value) {
      if ((float) $value['order_qty'] <= 0) {
        continue;
      }
      $sr++;

      $row = [];

      $total = $value['total_order_qty'];

      array_push(
        $row,
        '<span class="clickableRow"
        data-id="' . $value['id'] . '"
        data-indent="' . $value['indent_no'] . '"
        data-manual="' . $value['manual_indent_no'] . '"
        data-company="' . $value['company_name'] . '"
        data-total="' . $value['total_order_qty'] . '"
        data-order-qty="' . $value['order_qty'] . '"
        style="cursor:pointer;">
        <i class="fas fa-plus-circle text-success"></i>
    </span> ' . $sr
      );

      $orderFor = ($value['order_for'] == 1) ? 'Self' : 'External';
      array_push($row, $orderFor);

      array_push($row, $value['indent_no']);
      array_push($row, $value['manual_indent_no']);
      array_push($row, $value['indent_date']);
      array_push($row, $value['company_name']);

      array_push($row, '<span class="badge badge-success">' . $total . '</span>');
      array_push($row, '<span class="badge badge-warning">' . $value['order_qty'] . '</span>');

      array_push($row, '<span class="label design-selection openModal"
                            data-id="' . $value['id'] . '"
                            data-indent="' . $value['indent_no'] . '"
                            data-manual="' . $value['manual_indent_no'] . '"
                            data-company="' . $value['company_name'] . '"
                            data-total="' . $value['total_order_qty'] . '"
                            data-created="' . $value['under_finishing'] . '"
                            data-order-qty="' . $value['order_qty'] . '"
                            style="cursor:pointer;">
                            ' . $value['under_finishing'] . '
                        </span>');

      array_push($row, '<span class="label custome-received">' . $value['finishing'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['paintaing'] . '</span>');
      array_push($row, '<span class="label custome-received">' . $value['dispatch'] . '</span>');

      $action = '<a href="' . base_url() . 'admin/production/Indent/view_frp_clamp_indent_details/' . $value['id'] . '/' . $value['indent_id'] . '" 
                    class="btn btn-primary btn-sm" style="background:#F0F0F0;color:gray;">
                    <i class="fas fa-eye"></i>
                  </a>

                 ';
      //  <a href="javascript:void(0);" class="btn btn-primary btn-sm m-1" 
      //                     style="background:#F0F0F0;color:gray;"
      //                     onclick="openInterChangeModal(' . $value['id'] . ')">
      //                     <i class="fas fa-exchange-alt"></i>
      //                   </a>
      array_push($row, $action);

      $rows[] = $row;
    }

    echo json_encode([
      "draw" => intval($data['draw']),
      "recordsTotal" => count($rows),
      "recordsFiltered" => count($rows),
      "data" => $rows
    ]);
  }

  public function getFRPClampStageData()
  {
    $order_id = $this->input->post('order_id');
    $data = $this->IndentModel->getFRPClampStageData($order_id);
    // echo '<pre>';
    // print_r($order_id);
    // die();
    echo json_encode($data);
  }

  public function updateFRPClampStageData()
  {
    $post = $this->input->post();

    // echo '<pre>';
    // print_r($post);
    // die();

    $order_id = $post['order_id'];

    $order = $this->CommonModel->getData(
      'tbl_indent_frp_clamp_received_orders',
      ['id' => $order_id],
      '',
      '',
      'row_array'
    );

    if (!$order) {
      echo json_encode(['status' => false, 'msg' => 'Order not found']);
      return;
    }

    $indent_sub = $order['indent_id'];

    // ✅ STAGE UPDATE
    $stages = [
      1 => ['qty' => $post['under_finishing'], 'remark' => $post['remark_under_finishing']],
      2 => ['qty' => $post['finishing'], 'remark' => $post['remark_finishing']],
      3 => ['qty' => $post['painting'], 'remark' => $post['remark_painting']],
      4 => ['qty' => $post['dispatch'], 'remark' => $post['remark_dispatch']],
    ];

    foreach ($stages as $status_id => $data) {

      $qty = isset($data['qty']) && $data['qty'] !== '' ? (int) $data['qty'] : 0;
      $remark = isset($data['remark']) ? trim($data['remark']) : '';

      if ($qty <= 0 && $remark === '')
        continue;

      $exists = $this->CommonModel->getData(
        'tbl_indent_frp_clamp_received_order_status_detail',
        [
          'order_id' => $order_id,
          'status_id' => $status_id
        ],
        '',
        '',
        'row_array'
      );

      if (!empty($exists)) {

        $this->CommonModel->iudAction(
          'tbl_indent_frp_clamp_received_order_status_detail',
          [
            'qty' => $qty,
            'remark' => $remark,
            'date' => date('Y-m-d'),
            'created_by' => userId()
          ],
          'update',
          ['id' => $exists['id']]
        );
      } else {

        $this->CommonModel->iudAction(
          'tbl_indent_frp_clamp_received_order_status_detail',
          [
            'order_id' => $order_id,
            'status_id' => $status_id,
            'qty' => $qty,
            'remark' => $remark,
            'date' => date('Y-m-d'),
            'created_by' => userId(),
            'created_at' => date('Y-m-d H:i:s')
          ],
          'insert'
        );
      }
    }

    echo json_encode([
      'status' => true,
      'msg' => 'Data updated successfully'
    ]);
  }


  public function view_frp_clamp_indent_details($id, $indent_no)
  {
    $data['indentDetails'] = $this->IndentModel->frpClampOrderDetails($id);
    // echo'<pre>';
    // print_r($data['indentDetails']);
    // die;
    $data['specifications'] = $this->IndentModel->frpclampSpecifications($id);

    $order_status_details = $this->IndentModel->frpheaderpipeOrderStatusDetails($id);

    $statusFormatted = [
      'Qty' => 0,
      'Under Finishing' => 0,
      'Finishing' => 0,
      'Paintaing' => 0,
      'Dispatch' => 0,
    ];

    $maxQty = 0;

    foreach ($order_status_details as $row) {

      if ($row['qty'] > $maxQty) {
        $maxQty = $row['qty'];
      }

      if ($row['status_id'] == 1) {
        $statusFormatted['Under Finishing'] = $row['qty'];
      }

      if ($row['status_id'] == 2) {
        $statusFormatted['Finishing'] = $row['qty'];
      }

      if ($row['status_id'] == 3) {
        $statusFormatted['Paintaing'] = $row['qty'];
      }

      if ($row['status_id'] == 4) {
        $statusFormatted['Dispatch'] = $row['qty'];
      }
    }

    // ✅ FINAL QTY
    $statusFormatted['Qty'] = $maxQty;

    $data['statusFormatted'] = $statusFormatted;

    $this->load->view(ADMIN . 'production/frp_clamp/view_frp_clamp_indent_details', $data);
  }


  //4 for Hub Plate 
  public function hub_indent()
  {
    $data['title'] = 'Hub Plate Indent';
    $data['type'] = "2";
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();
    $data['clamp_type'] = $this->CommonModel->getData('tbl_master_indent_clamp_type', ['status' => 1], 'id,name');
    $data['clamp_material'] = $this->CommonModel->getData('tbl_master_indent_clamp_material', ['status' => 1], 'id,name');

    $this->load->view(ADMIN . 'production/hub/list_hub_indent', $data);
  }

  public function list_hub()
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

    // if ($data['indentid'] == "all") {
    if ($data['indentid'] == "all") {
      $where = array();
    } else {
      $where['tid.master_indent_id'] = 2;
    }

    $from_date = $data['from_date'] ?? '';
    $to_date   = $data['to_date'] ?? '';

    if (!empty($from_date)) {
      $where['DATE(i.date) >='] = $from_date;
    }

    if (!empty($to_date)) {
      $where['DATE(i.date) <='] = $to_date;
    }


    $count = count($this->IndentModel->getHubIndentData($searchVal, 0, 0, 0, 0, 0, $where, $from_date, $to_date));
    // echo"<pre>";
    // print_r($count);die;
    if ($count) {
      $result = $this->IndentModel->getHubIndentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where, $from_date, $to_date);
      // echo"<pre>";
      // print_r($result);die;

      foreach ($result as $key => $value) {
        $total = $this->IndentModel->getSum($value['indent_no']);
        $row = [];
        $checkbox = '
          <input type="checkbox"
          class="header_pipe_checkbox"
          name="selected_rows[]"
          value="' . $value['indent_no'] . '">
          ';
        array_push($row, $checkbox);
        array_push($row, $offset + ($key + 1));
        array_push($row, $value['client_name']);
        // array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['indent_number']);
        array_push($row, $value['date']);


        $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";



        $check_exist1 = $this->CommonModel->getData('tbl_indent_order', array('indent_id' => $value['indent_no']), '', '', 'num_rows');
        $checkSameQuantity = $this->CommonModel->getData('tbl_indent_order', ['manual_indent_no' => $value['indent_number']], 'SUM(order_qty) as totalOrderQty,blade_qty', '', 'result_array');
        // print_r($checkSameQuantity);die;

        if ($check_exist1) {
          $action = ' <a href="' . base_url() . 'admin/production/Indent/view_frp_headerpipe/' . $value['indent_no'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';
        } else {
          $action = '';
        }

        $action .= ' <a href="' . base_url() . 'admin/production/Indent/exportpdf_hub/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
              title="Export PDF" class="btn btn-primary waves-effect waves-light btn-sm" target="_blank">
              <i class="fas fa-file-pdf"></i>
            </a>

            <a href="' . base_url() . 'admin/production/Indent/exportexcel_hub/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
              title="Export Excel" class="btn btn-success waves-effect waves-light btn-sm" target="_blank">
              <i class="fas fa-file-excel"></i>
            </a>
            
            <a href="' . base_url() . 'admin/production/Indent/CreateOrderfor_hub/' . $value['indent_id'] . '/' . $value['indent_bland_id'] . '/' . $value['indent_no'] . '" 
              title="Create Order" class="btn btn-primary waves-effect waves-light btn-sm">
              <i class="fas fa-check-square"></i>
            </a>';

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

  public function exportpdf_hub($indent_id, $indent_bland_id, $indent_no)
  {
    $data['indent_details'] = $this->IndentModel->getHubExportIndentDetails($indent_no);

    $html = $this->load->view(
      'admin/production/pdf/hub_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'landscape');
    $pdf->render();

    $pdf->stream(
      'HUB_' . $indent_no . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_hub_pdf()
  {
    $ids = $this->input->get('ids');

    if (empty($ids)) {
      show_error('No rows selected');
    }

    $indentNos = explode(',', $ids);

    $data['indent_details'] =
      $this->IndentModel
      ->getHubExportIndentDetailsSelected($indentNos);

    $html = $this->load->view(
      'admin/production/pdf/hub_pdf',
      $data,
      true
    );

    $pdf = new Dompdf();

    $pdf->loadHtml($html);

    $pdf->setPaper('A4', 'landscape');

    $pdf->render();

    $pdf->stream(
      'HUB_SELECTED_' . date('YmdHis') . '.pdf',
      array("Attachment" => 0)
    );
  }

  public function export_selected_hub_excel()
  {
    $ids = $this->input->get('ids');

    $indentNos = explode(',', $ids);

    $details =
      $this->IndentModel->getHubExportIndentDetailsSelected($indentNos);


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $row = 1;

    $headerStyle = [
      'font' => [
        'bold' => true,
        'size' => 10,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ];

    $cellStyle = [
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
    ];

    foreach ($details as $value) {

      $sheet->setCellValue('A' . $row, 'Indent No');
      $sheet->setCellValue('B' . $row, $value['indent_number'] ?? '-');
      $sheet->setCellValue('C' . $row, 'Date');
      $sheet->setCellValue(
        'D' . $row,
        !empty($value['created_at'])
          ? date('d.m.Y', strtotime($value['created_at']))
          : '-'
      );
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Client');
      $sheet->setCellValue(
        'B' . $row,
        !empty($value['company_name'])
          ? strtoupper($value['company_name'])
          : '-'
      );
      $sheet->setCellValue('C' . $row, 'Delivery Date');
      $sheet->setCellValue(
        'D' . $row,
        !empty($value['delivery_date'])
          ? date('d.m.Y', strtotime($value['delivery_date']))
          : '-'
      );
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Qty');
      $sheet->setCellValue('B' . $row, $value['qty'] ?? '-');
      $sheet->setCellValue('C' . $row, 'Make');
      $sheet->setCellValue('D' . $row, $value['make'] ?? '-');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Remark');
      $sheet->mergeCells('B' . $row . ':D' . $row);
      $sheet->setCellValue('B' . $row, $value['remark'] ?? '-');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row += 2;

      // HUB PLATE DETAILS

      $sheet->mergeCells('A' . $row . ':E' . $row);
      $sheet->setCellValue('A' . $row, 'HUB PLATE DETAILS');
      $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(
        ['Category', 'Way', 'OD', 'Material', 'Thickness'],
        null,
        'A' . $row
      );
      $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['hub_plate_category'] ?: '-',
        $value['hub_plate_way'] ?: '-',
        $value['hub_plate_od'] ?: '-',
        $value['hub_plate_material'] ?: '-',
        $value['hub_plate_thickness'] ?: '-'
      ], null, 'A' . $row);

      $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($cellStyle);
      $row += 2;

      // FLANGE DETAILS

      $sheet->mergeCells('A' . $row . ':D' . $row);
      $sheet->setCellValue('A' . $row, 'FLANGE / HUBSPOOL DETAILS');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(
        ['OD', 'Size', 'PCD', 'Drill'],
        null,
        'A' . $row
      );

      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['flange_hubspool_od'] ?: '-',
        $value['flange_size'] ?: '-',
        $value['flange_hubspool_pcd'] ?: '-',
        $value['flange_hubspool_drill'] ?: '-'
      ], null, 'A' . $row);

      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row += 2;

      // TAPER BUSH

      $sheet->mergeCells('A' . $row . ':D' . $row);
      $sheet->setCellValue('A' . $row, 'TAPER BUSH / FENNER BUSH DETAILS');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(
        ['Taper Bush OD', 'Bore', 'Keyway', 'Fenner Bush OD'],
        null,
        'A' . $row
      );

      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['tapperbush_od'] ?: '-',
        $value['tapperbush_bore'] ?: '-',
        $value['tapperbush_keyway'] ?: '-',
        $value['fennerbush_od'] ?: '-'
      ], null, 'A' . $row);

      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row += 2;

      // HARDWARE

      $sheet->mergeCells('A' . $row . ':C' . $row);
      $sheet->setCellValue('A' . $row, 'HARDWARE DETAILS');
      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(
        ['Name', 'Size', 'Material'],
        null,
        'A' . $row
      );

      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['hardware_name_1'] ?: '-',
        $value['hardware_size_1'] ?: '-',
        $value['hardware_material_1'] ?: '-'
      ], null, 'A' . $row);

      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->fromArray([
        $value['hardware_name_2'] ?: '-',
        $value['hardware_size_2'] ?: '-',
        $value['hardware_material_2'] ?: '-'
      ], null, 'A' . $row);

      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($cellStyle);
      $row += 2;

      // SPACER

      $sheet->mergeCells('A' . $row . ':B' . $row);
      $sheet->setCellValue('A' . $row, 'SPACER DETAILS');
      $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Spacer');
      $sheet->setCellValue('B' . $row, $value['spacer'] ?: '-');

      $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($cellStyle);

      $row += 4;
    }

    foreach (range('A', 'E') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'HUB_SELECTED_' . date('YmdHis') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
  }


  public function exportexcel_hub($indent_id, $indent_bland_id, $indent_no)
  {
    $details = $this->IndentModel->getHubExportIndentDetails($indent_no);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $row = 1;

    $headerStyle = [
      'font' => ['bold' => true, 'size' => 10],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'FFEB9C'],
      ],
    ];

    $cellStyle = [
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
      ],
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
    ];

    foreach ($details as $value) {

      $sheet->setCellValue('A' . $row, 'Indent No');
      $sheet->setCellValue('B' . $row, $value['indent_number'] ?? '-');
      $sheet->setCellValue('C' . $row, 'Date');
      $sheet->setCellValue('D' . $row, !empty($value['created_at']) ? date('d.m.Y', strtotime($value['created_at'])) : '-');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Client');
      $sheet->setCellValue('B' . $row, !empty($value['company_name']) ? strtoupper($value['company_name']) : '-');
      $sheet->setCellValue('C' . $row, 'Delivery Date');
      $sheet->setCellValue('D' . $row, !empty($value['delivery_date']) ? date('d.m.Y', strtotime($value['delivery_date'])) : '-');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Qty');
      $sheet->setCellValue('B' . $row, $value['qty'] ?? '-');
      $sheet->setCellValue('C' . $row, 'Make');
      $sheet->setCellValue('D' . $row, $value['make'] ?? '-');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Remark');
      $sheet->mergeCells('B' . $row . ':D' . $row);
      $sheet->setCellValue('B' . $row, $value['remark'] ?? '-');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row += 2;

      $sheet->mergeCells('A' . $row . ':E' . $row);
      $sheet->setCellValue('A' . $row, 'HUB PLATE DETAILS');
      $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(['Category', 'Way', 'OD', 'Material', 'Thickness'], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['hub_plate_category'] ?: '-',
        $value['hub_plate_way'] ?: '-',
        $value['hub_plate_od'] ?: '-',
        $value['hub_plate_material'] ?: '-',
        $value['hub_plate_thickness'] ?: '-'
      ], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($cellStyle);
      $row += 2;

      $sheet->mergeCells('A' . $row . ':D' . $row);
      $sheet->setCellValue('A' . $row, 'FLANGE / HUBSPOOL DETAILS');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(['OD', 'Size', 'PCD', 'Drill'], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['flange_hubspool_od'] ?: '-',
        $value['flange_size'] ?: '-',
        $value['flange_hubspool_pcd'] ?: '-',
        $value['flange_hubspool_drill'] ?: '-'
      ], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row += 2;

      $sheet->mergeCells('A' . $row . ':D' . $row);
      $sheet->setCellValue('A' . $row, 'TAPER BUSH / FENNER BUSH DETAILS');
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(['Taper Bush OD', 'Bore', 'Keyway', 'Fenner Bush OD'], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['tapperbush_od'] ?: '-',
        $value['tapperbush_bore'] ?: '-',
        $value['tapperbush_keyway'] ?: '-',
        $value['fennerbush_od'] ?: '-'
      ], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($cellStyle);
      $row += 2;

      $sheet->mergeCells('A' . $row . ':C' . $row);
      $sheet->setCellValue('A' . $row, 'HARDWARE DETAILS');
      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray(['Name', 'Size', 'Material'], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->fromArray([
        $value['hardware_name_1'] ?: '-',
        $value['hardware_size_1'] ?: '-',
        $value['hardware_material_1'] ?: '-'
      ], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($cellStyle);
      $row++;

      $sheet->fromArray([
        $value['hardware_name_2'] ?: '-',
        $value['hardware_size_2'] ?: '-',
        $value['hardware_material_2'] ?: '-'
      ], null, 'A' . $row);
      $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($cellStyle);
      $row += 2;

      $sheet->mergeCells('A' . $row . ':B' . $row);
      $sheet->setCellValue('A' . $row, 'SPACER DETAILS');
      $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($headerStyle);
      $row++;

      $sheet->setCellValue('A' . $row, 'Spacer');
      $sheet->setCellValue('B' . $row, $value['spacer'] ?: '-');
      $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($cellStyle);

      $row += 3;
    }

    foreach (range('A', 'E') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'HUB_' . date('YmdHis') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }





  public function create_order_for_hub()
  {
    $data['title'] = 'Hub Plate Indent';
    $data['type'] = "2";
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();
    $data['plate_od_data'] = $this->CommonModel->getData('tbl_master_indent_hub_plate_od', ['status' => 1], 'id,name');

    $data['thickness'] = $this->CommonModel->getData('tbl_master_indent_hub_thickness', ['status' => 1], 'id,name');
    $data['materials'] = $this->CommonModel->getData('tbl_master_indent_hub_material', ['status' => 1], 'id,name');
    $data['plate_od'] = $this->CommonModel->getData('tbl_master_indent_hub_plate_od', ['status' => 1], 'id,name');
    $data['hardware_size'] = $this->CommonModel->getData('tbl_master_indent_hub_hardwares', ['status' => 1], 'id,name');
    $this->load->view(ADMIN . 'production/hub/createorder_for_hub', $data);
  }

  public function CreateOrderfor_hub($id = "", $blade_indent_id = "", $indent_no = "")
  {
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $company_id = $this->session->userdata('company_id');

    if ($_POST) {
      $post = $_POST;
      $converted_date = !empty($post['date']) ? date('Y-m-d', strtotime($post['date'])) : date('Y-m-d');
      $delivery_date = !empty($post['delivery_date']) ? date('Y-m-d', strtotime($post['delivery_date'])) : NULL;

      $client_id = $this->session->userdata('user_id');
      $plant_id = $this->session->userdata('company_id');

      $indent_id = $post['indent_db_id'] ?? '';

      if (!empty($indent_id)) {

        // Existing indent → use stored values
        $existingIndent = $this->CommonModel->getData(
          'tbl_indent',
          ['id' => $indent_id],
          '*',
          '',
          'row_array'
        );

        $indentSequence = !empty($existingIndent['indent_sequence'])
          ? $existingIndent['indent_sequence']
          : $this->IndentModel->getIndentSequenceNumber();

        $indentNo = !empty($existingIndent['indent_no'])
          ? $existingIndent['indent_no']
          : $this->IndentModel->getindentNumber();

        $manualIndentNo = $existingIndent['indent_number'] ?? '';
      } else {

        // New indent
        $indentSequence = !empty($post['indent_sequence'])
          ? $post['indent_sequence']
          : $this->IndentModel->getIndentSequenceNumber();

        $indentNo = !empty($post['indent_no'])
          ? $post['indent_no']
          : $this->IndentModel->getindentNumber();

        $manualIndentNo = $post['indent_number'] ?? '';
      }
      $array_indent = [
        'client_id'       => $client_id,
        'plant_id'        => $plant_id,
        'indent_no'       => $indentNo,
        'date'            => $converted_date,
        'delivery_date'   => $delivery_date,
        'indent_sequence' => $indentSequence,
        'indent_number'   => $manualIndentNo,
        'is_lock'         => 1
      ];


      if (!empty($indent_id)) {
        $array_indent['updated_by'] = userId();
        $array_indent['updated_at'] = date('Y-m-d H:i:s');
        $this->CommonModel->iudAction('tbl_indent', $array_indent, 'update', ['id' => $indent_id]);
      } else {
        $array_indent['created_by'] = userId();
        $indent_id = $this->CommonModel->iudAction('tbl_indent', $array_indent, 'insert');
      }

      if ($indent_id) {
        // echo '<pre>';
        // print_r($_POST);
        // die();
        $moduleData = [
          'master_indent_id' => 2,
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'remark' => $post['remark'] ?? '',
          'make' => $post['make'] ?? '',
          'qty' => $post['qty'] ?? '',
          'hub_plate_category' => $post['hub_plate_category'] ?? '',
          'hub_plate_way' => $post['hub_plate_way'] ?? '',
          'hub_plate_od' => $post['hub_plate_od'] ?? '',
          'hub_plate_material' => $post['hub_plate_material'] ?? '',
          'hub_plate_thickness' => $post['hub_plate_thickness'] ?? '',
          'flange_hubspool_od' => $post['flange_hubspool_od'] ?? '',
          'flange_size' => $post['flange_size'] ?? '',
          'flange_hubspool_pcd' => $post['flange_hubspool_pcd'] ?? '',
          'flange_hubspool_drill' => $post['flange_hubspool_drill'] ?? '',
          'tapperbush_od' => $post['tapperbush_od'] ?? '',
          'tapperbush_bore' => $post['tapperbush_bore'] ?? '',
          'tapperbush_keyway' => $post['tapperbush_keyway'] ?? '',
          'fennerbush_od' => $post['fennerbush_od'] ?? '',
          'hardware_name_1' => $post['hardware_name_1'] ?? '',
          'hardware_size_1' => $post['hardware_size_1'] ?? '',
          'hardware_material_1' => $post['hardware_material_1'] ?? '',
          'hardware_name_2' => $post['hardware_name_2'] ?? '',
          'hardware_size_2' => $post['hardware_size_2'] ?? '',
          'hardware_material_2' => $post['hardware_material_2'] ?? '',
          'spacer' => $post['spacer'] ?? '',
        ];

        $existingModule = $this->CommonModel->getData(
          'tbl_indent_hub',
          [
            'indent_id' => $indent_id,
            'master_indent_id' => 2
          ],
          '*',
          '',
          'row_array'
        );

        if (!empty($existingModule)) {
          // echo '<pre>';
          // print_r($indent_id);
          // die();
          $moduleData = [
            'master_indent_id' => 2,
            'indent_id' => $indent_id,
            'plant_id' => $plant_id,
            'hub_plate_category' => $post['hub_plate_category'] ?? '',
            'hub_plate_way' => $post['hub_plate_way'] ?? '',
            'hub_plate_od' => $post['hub_plate_od'] ?? '',
            'hub_plate_material' => $post['hub_plate_material'] ?? '',
            'hub_plate_thickness' => $post['hub_plate_thickness'] ?? '',
            'flange_hubspool_od' => $post['flange_hubspool_od'] ?? '',
            'flange_size' => $post['flange_size'] ?? '',
            'flange_hubspool_pcd' => $post['flange_hubspool_pcd'] ?? '',
            'flange_hubspool_drill' => $post['flange_hubspool_drill'] ?? '',
            'tapperbush_od' => $post['tapperbush_od'] ?? '',
            'tapperbush_bore' => $post['tapperbush_bore'] ?? '',
            'tapperbush_keyway' => $post['tapperbush_keyway'] ?? '',
            'fennerbush_od' => $post['fennerbush_od'] ?? '',
            'hardware_name_1' => $post['hardware_name_1'] ?? '',
            'hardware_size_1' => $post['hardware_size_1'] ?? '',
            'hardware_material_1' => $post['hardware_material_1'] ?? '',
            'hardware_name_2' => $post['hardware_name_2'] ?? '',
            'hardware_size_2' => $post['hardware_size_2'] ?? '',
            'hardware_material_2' => $post['hardware_material_2'] ?? '',
            'spacer' => $post['spacer'] ?? '',

            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => userId(),
          ];
          $this->CommonModel->iudAction(
            'tbl_indent_hub',
            $moduleData,
            'update',
            ['indent_id' => $indent_id]
          );

          $indent_module_id = $existingModule['id'];
        } else {

          $moduleData['created_at'] = date('Y-m-d H:i:s');
          $moduleData['created_by'] = userId();

          $indent_module_id = $this->CommonModel->iudAction(
            'tbl_indent_hub',
            $moduleData,
            'insert'
          );
        }

        $indent_details_data = [
          'indent_id' => $indent_id,
          'plant_id' => $plant_id,
          'master_indent_id' => 2,
          'ref_id' => $indent_module_id,
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => userId(),
        ];

        $existingDetail = $this->CommonModel->getData(
          'tbl_indent_details',
          [
            'indent_id' => $indent_id,
            'master_indent_id' => 2,
          ],
          '*',
          '',
          'row_array'
        );

        if ($existingDetail) {
          // echo '<pre>';
          // print_r('existing details found');
          // die();
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $indent_details_data,
            'update',
            ['id' => $existingDetail['id']]
          );
        } else {
          $this->CommonModel->iudAction(
            'tbl_indent_details',
            $indent_details_data,
            'insert'
          );
        }
      }

      $order_id = $this->input->post('order_id');
      // echo '<pre>';
      // print_r($order_id);
      // die();

      $ext_total_order_qty = $this->CommonModel->getData(
        'tbl_indent_hub_received_orders',
        [
          'id' => $order_id,
        ],
        'total_order_qty',
        '',
        'row_array'
      );

      $total_order_qty = $ext_total_order_qty['total_order_qty'] - $post['qty'] ?? 0;

      $orderData = [
        'order_for' => $post['order_for'],
        'indent_date' => $converted_date,
        'delivery_date' => $delivery_date,
        'party_id' => $client_id,
        'indent_id' => $indent_id,
        'manual_indent_no' => $post['indent_number'],
        'total_order_qty' => $total_order_qty,
        'order_qty' => $post['qty'],
        'remark' => $post['remark'],
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => userId(),
      ];
      if (!empty($order_id)) {

        if (isset($order_id)) {
          $total_order_qty = $ext_total_order_qty['total_order_qty'] - $post['qty'] ?? 0;
        }

        $orderData = [
          'order_for' => $post['order_for'],
          'indent_date' => $converted_date,
          'delivery_date' => $delivery_date,
          // 'client_id' => $client_id,
          'party_id' => $client_id,
          'indent_id' => $indent_id,
          'manual_indent_no' => $post['indent_number'],
          'total_order_qty' => $total_order_qty,
          'order_qty' => $post['qty'] ?? 0,
          'remark' => $post['remark'] ?? '',
          'updated_by' => userId(),
          'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->CommonModel->iudAction(
          'tbl_indent_hub_received_orders',
          $orderData,
          'insert',
          // ['id' => $order_id]
        );

        $this->db->where('order_id', $order_id)
          ->update(
            'tbl_indent_hub_received_order_status',
            [
              'order_qty' => $post['qty'] ?? 0,
              'updated_by' => userId(),
              'updated_at' => date('Y-m-d H:i:s')
            ]
          );
      } else {
        // echo '<pre>';
        // print_r($orderData);
        // die();
        $orderData = [
          'order_for' => $post['order_for'],
          'indent_date' => $converted_date,
          'delivery_date' => $delivery_date,
          'party_id' => $client_id,
          'indent_id' => $indent_id,
          'manual_indent_no' => $post['indent_number'],
          'total_order_qty' => $post['qty'] ?? 0,
          'order_qty' => 0,
          'remark' => $post['remark'] ?? '',
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => userId(),
        ];

        $order_id = $this->CommonModel->iudAction(
          'tbl_indent_hub_received_orders',
          $orderData,
          'insert'
        );

        // if($order_id){
        //   echo '<pre>';
        //   print_r('inserted order id '.$order_id);
        //   die();
        // }

        if ($order_id) {

          $stages = $this->db
            ->order_by('component_name', 'ASC')
            ->order_by('sequence', 'ASC')
            ->get('tbl_frp_hub_stage_master')
            ->result();

          foreach ($stages as $stage) {
            $detailData = [
              'order_id'   => $order_id,
              'status_id'  => $stage->id,
              'qty'        => 0,
              'company_id' => $company_id,
              'created_by' => userId(),
              'created_at' => date('Y-m-d H:i:s')
            ];

            $this->CommonModel->iudAction(
              'tbl_indent_hub_received_order_status_detail',
              $detailData,
              'insert'
            );
          }

          $statusData = [
            'order_id'            => $order_id,
            'qty'                 => $post['qty'] ?? '',
            'order_qty'           => $post['total_order_qty'] ?? '',
            'indent_transfer_qty' => 0,
            'company_id'          => $company_id,
            'created_qty'         => 0,
            'created_by'          => userId(),
            'created_at'          => date('Y-m-d H:i:s')
          ];

          $this->CommonModel->iudAction(
            'tbl_indent_hub_received_order_status',
            $statusData,
            'insert'
          );
        }
      }
      $this->session->set_flashdata('success', 'Order Saved Successfully!');
      redirect(base_url(ADMIN . 'production/Indent/hub_indent'));
    }


    $blade = $this->IndentModel->indentDetailsforhub($id, $blade_indent_id, $indent_no);
    $data['blade_data'] = $blade;

    $data['plate_od_data'] = $this->CommonModel->getData('tbl_master_indent_hub_plate_od', ['status' => 1], 'id,name');
    $data['thickness'] = $this->CommonModel->getData('tbl_master_indent_hub_thickness', ['status' => 1], 'id,name');
    $data['materials'] = $this->CommonModel->getData('tbl_master_indent_hub_material', ['status' => 1], 'id,name');
    $data['plate_od'] = $this->CommonModel->getData('tbl_master_indent_hub_plate_od', ['status' => 1], 'id,name');
    $data['hardware_size'] = $this->CommonModel->getData('tbl_master_indent_hub_hardwares', ['status' => 1], 'id,name');

    $data['type'] = "1";

    $this->load->view(ADMIN . 'production/hub/createorder_for_hub', $data);
  }

  public function view_hub_indent_details($id, $indent_no)
  {
    $data['indentDetails'] = $this->IndentModel->HubOrderDetails($id);
    // echo'<pre>';
    // print_r($data['indentDetails']);
    // die;
    $data['specifications'] = $this->IndentModel->HubSpecifications($id);
    // echo '<pre>';
    // print_r($data['specifications']);
    // die;

    $order_status_details = $this->IndentModel->HubOrderStatusDetails($id);

    $statusFormatted = [
      'Qty' => 0,
      'Assembly' => 0,
      'Inspection Overall' => 0,
      'Dynamic Balancing' => 0,
      'Packing' => 0,
      'Dispatch' => 0,
    ];

    $maxQty = 0;

    foreach ($order_status_details as $row) {

      if ($row['qty'] > $maxQty) {
        $maxQty = $row['qty'];
      }

      if ($row['status_id'] == 1) {
        $statusFormatted['Assembly'] = $row['qty'];
      }

      if ($row['status_id'] == 2) {
        $statusFormatted['Inspection Overall'] = $row['qty'];
      }

      if ($row['status_id'] == 3) {
        $statusFormatted['Dynamic Balancing'] = $row['qty'];
      }

      if ($row['status_id'] == 4) {
        $statusFormatted['Packing'] = $row['qty'];
      }
      
      if ($row['status_id'] == 4) {
        $statusFormatted['Dispatch'] = $row['qty'];
      }
    }

    // ✅ FINAL QTY
    $statusFormatted['Qty'] = $maxQty;

    $data['statusFormatted'] = $statusFormatted;

    $this->load->view(ADMIN . 'production/hub/view_hub_indent_details', $data);
  }

  public function hub_received_order()
  {
    $data['title'] = 'Hub Plate Received Order';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 2), 'id,indent_name');
    $this->load->view(ADMIN . 'production/hub/list_hub_received_order', $data);
  }

  public function list_hub_received_orders()
  {
    $data = $_POST;

    $limit  = isset($data['length']) ? $data['length'] : 10;
    $offset = isset($data['start']) ? $data['start'] : 0;
    $search = isset($data['search']['value']) ? $data['search']['value'] : '';
    $draw   = isset($data['draw']) ? intval($data['draw']) : 0;

    $result = $this->IndentModel->getHuborderStatusData($search, $limit, $offset);

    $rows = [];
    $sr = $offset;

    foreach ($result as $value) {
      $sr++;

      $row = [];

      $total = $value['total_order_qty'];
      $action = '
      <div class="d-flex align-items-center justify-content-center gap-2 p-2">
          <button type="button"
              class="btn btn-success btn-xs openModal mr-1"
              data-id="' . $value['id'] . '"
              data-indent="' . $value['indent_no'] . '"
              data-manual="' . $value['manual_indent_no'] . '"
              data-company="' . $value['company_name'] . '"
              data-total="' . $value['total_order_qty'] . '"
              data-order-qty="' . $value['order_qty'] . '">
              <i class="fas fa-edit"></i>
          </button>

      <a href="' . base_url() . 'admin/production/Indent/view_hub_indent_details/' . $value['id'] . '/' . $value['indent_id'] . '" 
            class="btn btn-primary btn-xs" style="background:#F0F0F0;color:gray;">
            <i class="fas fa-eye"></i>
        </a>
      </div>
      ';

      array_push($row, $action);
    

      $orderFor = ($value['order_for'] == 1) ? 'Indent' : 'Self';
      array_push($row, $orderFor);

      array_push($row, $value['indent_no']);
      array_push($row, $value['manual_indent_no']);
      array_push($row, $value['indent_date']);
      array_push($row, $value['company_name']);

      array_push($row, '<span class="badge badge-success">' . $total . '</span>');
      array_push($row, '<span class="badge badge-warning">' . $value['order_qty'] . '</span>');


      // Hubplate
      array_push($row, '<span class="badge badge-info">' . $value['hubplate_machining'] . '</span>');
      array_push($row, '<span class="badge badge-info">' . $value['hubplate_inspection'] . '</span>');
      array_push($row, '<span class="badge badge-info">' . $value['hubplate_galvanising'] . '</span>');
      array_push($row, '<span class="badge badge-info">' . $value['hubplate_painting'] . '</span>');

      // Hubspool
      array_push($row, '<span class="badge badge-primary">' . $value['hubspool_machining'] . '</span>');
      array_push($row, '<span class="badge badge-primary">' . $value['hubspool_final_machining'] . '</span>');
      array_push($row, '<span class="badge badge-primary">' . $value['hubspool_inspection'] . '</span>');
      array_push($row, '<span class="badge badge-primary">' . $value['hubspool_painting'] . '</span>');

      // Clamp
      array_push($row, '<span class="badge badge-warning">' . $value['clamp_machining'] . '</span>');
      array_push($row, '<span class="badge badge-warning">' . $value['clamp_inspection'] . '</span>');
      array_push($row, '<span class="badge badge-warning">' . $value['clamp_painting'] . '</span>');

      // Hardware
      array_push($row, '<span class="badge badge-secondary">' . $value['hardware_forging'] . '</span>');
      array_push($row, '<span class="badge badge-secondary">' . $value['hardware_machining'] . '</span>');
      array_push($row, '<span class="badge badge-secondary">' . $value['hardware_inspection'] . '</span>');

      // Common
      array_push($row, '<span class="badge badge-success">' . $value['assembly'] . '</span>');
      array_push($row, '<span class="badge badge-success">' . $value['inspection_overall'] . '</span>');
      array_push($row, '<span class="badge badge-success">' . $value['dynamic_balancing'] . '</span>');
      array_push($row, '<span class="badge badge-success">' . $value['packing'] . '</span>');
      array_push($row, '<span class="badge badge-success">' . $value['dispatch'] . '</span>');
     

      $rows[] = $row;
    }

    echo json_encode([
      "draw" => $draw,
      "recordsTotal" => count($rows),
      "recordsFiltered" => count($rows),
      "data" => $rows
    ]);
  }

  public function updateHubStageData()
  {
    // echo '<pre>';
    // print_r($_POST);
    // die();
    $order_id = $this->input->post('order_id');

    $stages = json_decode(
      $this->input->post('stages'),
      true
    );

    if (!$order_id || empty($stages)) {

      echo json_encode([
        'status' => false
      ]);
      return;
    }

    foreach ($stages as $row) {

      $exists = $this->db
        ->where('order_id', $order_id)
        ->where('status_id', $row['status_id'])
        ->get('tbl_indent_hub_received_order_status_detail')
        ->row_array();

      $data = [
        'qty' => $row['qty'],
        'remark' => $row['remark']
      ];

      if ($exists) {

        $this->db
          ->where('id', $exists['id'])
          ->update(
            'tbl_indent_hub_received_order_status_detail',
            $data
          );
      } else {

        $data['order_id'] = $order_id;
        $data['status_id'] = $row['status_id'];

        $this->db->insert(
          'tbl_indent_hub_received_order_status_detail',
          $data
        );
      }
    }

    echo json_encode([
      'status' => true
    ]);
  }

  public function getHubStageData()
  {
    $order_id = $this->input->post('order_id');

    $stages = $this->db
      ->where('order_id', $order_id)
      ->get('tbl_indent_hub_received_order_status_detail')
      ->result_array();

    echo json_encode([
      'stages' => $stages
    ]);
  }

  public function getHubStageMaster()
  {
    $stages = $this->db
      ->order_by('component_name')
      ->order_by('sequence')
      ->get('tbl_frp_hub_stage_master')
      ->result_array();

    echo json_encode($stages);
  }



  //5. Fan Dia Indent
  public function fan_dia_indent()
  {
    $data['title'] = 'Fan Dia Indent';
    $data['indent_name'] = $this->CommonModel->getData('tbl_master_indent_for', array('id' => 19), 'id,indent_name');
    $this->load->view(ADMIN . 'production/fan_dia/list_fan_dia_indent', $data);
  }

  public function add_indentfor_fandia($id = '')
  {
    $data['type'] = "2";
    $user_details = $this->session->userdata();
    $data['user_details'] = $user_details;
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();
    // echo'<pre>'; print_r($data);die;
    $this->load->view(ADMIN . 'production/fan_dia/add_indentfor_fandia', $data);
  }
}
