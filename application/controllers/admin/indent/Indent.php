<?php

/**
 * 
 */
class Indent extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(ADMIN . 'indent/IndentModel');
    isLogin();
  }

  public function index()
  {
    $data['title'] = 'Indent';

    $this->load->view(ADMIN . 'indent/list_indent', $data);
  }

  public function add_indent($id = '')
  {
    // print_r($id);
    // $data['indentNumber'] = $this->generateIndentNumber();
    $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
    $data['indentNumber'] = $this->IndentModel->getindentNumber();

    if (!empty($id)) {
      $where = array();
      $indentData = $this->IndentModel->getindentData('', 0, 0, 0, 0, $id, $where);
      $data['indentData'] =  $indentData[0];
      //  print_r($data['indentData']);die;  

    }
    $this->load->view(ADMIN . 'indent/add_indent', $data);
  }

  public function getPlants()
  {

    $json = [];


    $customerId = $this->input->post('customer_id');
    // print_r("id " . $customerId);die;

    $searchTerm = $this->input->post('search');

    $plantsData = $this->IndentModel->getPlantsData($customerId, $searchTerm);


    foreach ($plantsData as $key => $value) {
      $json[] = ['id' => $value['id'], 'text' => $value['plant_narration']];
    }


    echo json_encode($json);
  }

  public function list_aTip()
  {

    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $mouldData = $this->BladeModel->getTip('');
    } else {

      $search = $_GET['searchTerm'];

      $mouldData = $this->BladeModel->getTip($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($mouldData as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['name']];
    }
    echo json_encode($json);
  }

  private function generateIndentNumber()
  {
    // Generate the indent number based on the current date and time
    $prefix = "IN-" . userId('site_inital') . "-" . time(); // Prefix with "IN-" and current date/time in YYYYMMDDHHMMSS format
    // You can add additional formatting or logic here if needed
    return $prefix;
  }

  // public function open_modal_indent_master()
  // {

  //   $master_indent_id = $this->input->post('master_indent_id');
  //   $indent_id = $this->input->post('indent_id');
  //   $id = $this->input->post('id');
  //   // print_r($master_indent_id);echo"<br>";
  //   // print_r($indent_id);echo"<br>";
  //   // print_r($id);echo"<br>";
  //   // die;

  //   if (isset($master_indent_id)) {

  //     $master_indent_tbl = $this->CommonModel->getData('tbl_master_indent_for', array('id' => $master_indent_id), '', '', 'row_array');
  //     // print_r($master_indent_tbl);die;
  //     if (isset($master_indent_tbl['db_view_modal_name'])) {
  //       if (isset($id) && $id != 0) {
  //         $data = array();
  //         $sub_tbl_data = $this->CommonModel->getData($master_indent_tbl['db_table_name'], array('id' => $id), '', '', 'row_array');
  //         //  echo $this->db->last_query();die;
  //         $data = $sub_tbl_data;
  //       } else {
  //         $data = array();
  //       }
  //       // print_r($data);die;
  //       $html = $this->load->view(ADMIN . 'indent/' . $master_indent_tbl['db_view_modal_name'], $data, true);

  //       // print_r($master_indent_tbl);die;

  //       if ($html) {
  //         $response['html'] = $html;
  //         $response['result'] = true;
  //         $response['reason'] = 'Data Found';
  //       } else {
  //         $response['result'] = false;
  //         $response['reason'] = 'Something went to wrong!1';
  //       }
  //     } else {
  //       $response['result'] = false;
  //       $response['reason'] = 'Something went to wrong!2';
  //     }
  //   } else {
  //     $response['result'] = false;
  //     $response['reason'] = 'Something went to wrong!3';
  //   }
  //   echo json_encode($response);
  // }

  public function open_modal_indent_master()
  {
    $master_indent_id = $this->input->post('master_indent_id');
    $indent_id        = $this->input->post('indent_id');
    $id               = $this->input->post('id');

    if (isset($master_indent_id)) {

      $master_indent_tbl = $this->CommonModel->getData(
        'tbl_master_indent_for',
        ['id' => $master_indent_id],
        '',
        '',
        'row_array'
      );

      if (isset($master_indent_tbl['db_view_modal_name'])) {

        $data = [];
        $data['indentseqNumber'] = $this->IndentModel->getIndentSequenceNumber();
        $data['indentNumber'] = $this->IndentModel->getindentNumber();
        $data['clamp_type'] = $this->CommonModel->getData('tbl_master_indent_clamp_type', ['status' => 1], 'id,name');
        $data['clamp_material'] = $this->CommonModel->getData('tbl_master_indent_clamp_material', ['status' => 1], 'id,name');


        $company_data = $this->CommonModel->getData(
          'tbl_indent',
          ['id' => $indent_id],
          'plant_id',
          '',
          'row_array'
        );

        $data['plant_id'] = $company_data['plant_id'] ?? '';

        $clientId = $this->CommonModel->getData(
          'tbl_indent',
          ['id' => $indent_id],
          'client_id',
          '',
          'row_array'
        );

        $data['client_id'] = $clientId['client_id'] ?? '';

        if (!empty($id)) {

          $sub_tbl_data = $this->CommonModel->getData(
            $master_indent_tbl['db_table_name'],
            ['id' => $id],
            '',
            '',
            'row_array'
          );

          $data = array_merge($data, $sub_tbl_data);

          $indentData = $this->CommonModel->getData(
            'tbl_indent',
            ['id' => $indent_id],
            '*',
            '',
            'row_array'
          );

          if (!empty($indentData)) {
            $data['indent_db_id'] = $indentData['id'] ?? '';
            $data['indentNumber'] = $indentData['indent_no'] ?? '';
            $data['manual_indent_no'] = $indentData['indent_number'] ?? '';
            $data['indentseqNumber'] = $indentData['indent_sequence'] ?? '';
            $data['plant_id'] = $indentData['plant_id'] ?? '';
            $data['client_id'] = $indentData['client_id'] ?? '';
          }

          if ($master_indent_id == 7) {

            $specs = $this->CommonModel->getData(
              'tbl_carbon_fiber_drive_shaft_specifications',
              ['indent_sub_id' => $id],
              '',
              '',
              'result_array'
            );

            if (!empty($specs)) {
              foreach ($specs as &$s) {
                $s['bore']   = !empty($s['bore']) ? json_decode($s['bore'], true) : [];
                $s['keyway'] = !empty($s['keyway']) ? json_decode($s['keyway'], true) : [];
              }
            }

            $data['specifications'] = $specs;
          }


          if ($master_indent_id == 21) {
            $indentseq_no = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'indent_sequence',
              '',
              'row_array'
            );
            $data['indentseqNumber'] = $indentseq_no['indent_sequence'] ?? '';

            $indent_number = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'indent_no',
              '',
              'row_array'
            );
            $data['indentNumber'] = $indent_number['indent_no'] ?? '';
            $clientId = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'client_id',
              '',
              'row_array'
            );

            $data['client_id'] = $clientId['client_id'] ?? '';

            $company_data = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'plant_id',
              '',
              'row_array'
            );

            $data['plant_id'] = $company_data['plant_id'] ?? '';
            $specs = $this->CommonModel->getData(
              'tbl_frp_header_pipe_specifications',
              ['indent_sub_id' => $id],
              '',
              '',
              'result_array'
            );

            if (!empty($specs)) {
              foreach ($specs as &$s) {
                $s['length_dia'] = !empty($s['length_dia']) ? $s['length_dia'] : '';
              }
            }


            $data['specifications'] = $specs;
          }



          if ($master_indent_id == 22) {
            // echo $id;
            // die;
            $data['specifications'] = $this->CommonModel->getData(
              'tbl_frp_clamp_specifications',
              ['indent_id' => $indent_id],
              '*',
              '',
              'row_array'
            );


            $indentseq_no = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'indent_sequence',
              '',
              'row_array'
            );
            $data['indentseqNumber'] = $indentseq_no['indent_sequence'] ?? '';

            $indent_number = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'indent_no',
              '',
              'row_array'
            );
            $data['indentNumber'] = $indent_number['indent_no'] ?? '';
            $clientId = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'client_id',
              '',
              'row_array'
            );

            $data['client_id'] = $clientId['client_id'] ?? '';

            $company_data = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_id],
              'plant_id',
              '',
              'row_array'
            );

            $data['plant_id'] = $company_data['plant_id'] ?? '';
            // echo '<pre>';
            // print_r($data['client_id']);
            // die;

            $data['clamp_type'] = $this->CommonModel->getData(
              'tbl_master_indent_clamp_type',
              ['status' => 1],
              'id,name'
            );

            $data['clamp_material'] = $this->CommonModel->getData(
              'tbl_master_indent_clamp_material',
              ['status' => 1],
              'id,name'
            );

            // echo '<pre>';
            // print_r($data);
            // die;
          }
        }

        if ($master_indent_id == 1) {
          $data['clamp_size'] = $this->IndentModel->getClampSize();
          $data['selected_clamp_size'] = isset($edit_data['clamp_size']) ? $edit_data['clamp_size'] : '';
          $data['selected_clamp_length'] = isset($edit_data['clamp_length']) ? $edit_data['clamp_length'] : '';
        }

        // echo "<pre>";
        // print_r($data['clamp_size']);
        // exit;


        $html = $this->load->view(
          ADMIN . 'indent/' . $master_indent_tbl['db_view_modal_name'],
          $data,
          true
        );

        if ($html) {
          $response = [
            'result' => true,
            'html'   => $html,
            'reason' => 'Data Found'
          ];
        } else {
          $response = ['result' => false, 'reason' => 'View load failed'];
        }
      } else {
        $response = ['result' => false, 'reason' => 'Modal view not found'];
      }
    } else {
      $response = ['result' => false, 'reason' => 'Invalid request'];
    }

    echo json_encode($response);
  }

  // public function open_modal_indent_master()
  // {

  //   $master_indent_id = $this->input->post('master_indent_id');
  //   $indent_id = $this->input->post('indent_id');
  //   $id = $this->input->post('id');
  //   // print_r($master_indent_id);echo"<br>";
  //   // print_r($indent_id);echo"<br>";
  //   // print_r($id);echo"<br>";
  //   // die;

  //   if (isset($master_indent_id)) {
  //     $master_indent_tbl = $this->CommonModel->getData('tbl_master_indent_for', array('id' => $master_indent_id), '', '', 'row_array');
  //     // print_r($master_indent_tbl);die;
  //     if (isset($master_indent_tbl['db_view_modal_name'])) {
  //       if (isset($id) && $id != 0) {
  //         $data = array();
  //         $sub_tbl_data = $this->CommonModel->getData($master_indent_tbl['db_table_name'], array('id' => $id), '', '', 'row_array');
  //         //  echo $this->db->last_query();die;
  //         $data = $sub_tbl_data;
  //       } else {
  //         $data = array();
  //       }

  //       // print_r($data);die;
  //       $html = $this->load->view(ADMIN . 'indent/' . $master_indent_tbl['db_view_modal_name'], $data, true);
  //       if ($html) {
  //         $response['html'] = $html;
  //         $response['result'] = true;
  //         $response['reason'] = 'Data Found';
  //       } else {
  //         $response['result'] = false;
  //         $response['reason'] = 'Something went to wrong!1';
  //       }
  //     } else {
  //       $response['result'] = false;
  //       $response['reason'] = 'Something went to wrong!2';
  //     }
  //   } else {
  //     $response['result'] = false;
  //     $response['reason'] = 'Something went to wrong!3';
  //   }
  //   echo json_encode($response);
  // }


  public function listIndentName($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $indentData = $this->IndentModel->getindentName('');
    } else {
      $search = $_GET['searchTerm'];
      $indentData = $this->IndentModel->getindentName($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($indentData as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['indent_name']];
    }
    echo json_encode($json);
  }


  public function listclientName($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $clientData = $this->IndentModel->getclientName('');
    } else {
      $search = $_GET['searchTerm'];
      $clientData = $this->IndentModel->getclientName($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($clientData as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['company_name']];
    }
    echo json_encode($json);
  }



  public function listplantName($value = '')
  {
    if (!isset($_GET['searchTerm'])) {
      $json = [];
      $plantData = $this->IndentModel->getplantName('');
    } else {
      $search = $_GET['searchTerm'];
      $plantData = $this->IndentModel->getplantName($search);
    }
    // $json[] = ['id'=>'all', 'text'=>'Select All'];
    foreach ($plantData as $key => $value) {

      $json[] = ['id' => $value['id'], 'text' => $value['short_name']];
    }
    echo json_encode($json);
  }





  public function saveIndent()
  {
    $post = $this->input->post();
    // print_r($post);die;
    if (!empty($post['date'])) {
      $converted_date = date('Y-m-d', strtotime($post['date']));
    } else {
      $converted_date = date('Y-m-d');
    }
    if (!empty($post['delivery_date'])) {
      $delivery_date = date('Y-m-d', strtotime($post['delivery_date']));
    } else {
      $delivery_date = NULL;
    }




    $array_indent = array(

      'client_id' => isset($post['client_id']) ? $post['client_id'] : '',
      'plant_id' => isset($post['plants']) ? $post['plants'] : '',
      'indent_no' => isset($post['indent_no']) ? $post['indent_no'] : '',
      'date' => $converted_date,
      'delivery_date' => $delivery_date,
      'created_by' => userId(),
      'indent_sequence' => isset($post['indent_sequence']) ? $post['indent_sequence'] : '',
      'indent_number' => isset($post['indent_number']) ? $post['indent_number'] : '',

    );
    // print_r( $array_indent);die;
    if (isset($post['id']) && !empty($post['id'])) {
      unset($array_indent['created_by']);
      $array_indent['updated_at'] = date('Y-m-d H:i:s');
      $array_indent['updated_by'] = userId();


      $indent_id = $this->CommonModel->iudAction('tbl_indent', $array_indent, 'update', array('id' => $post['id']));
    } else {
      $indent_id = $this->CommonModel->iudAction('tbl_indent', $array_indent, 'insert');
    }
    //echo $this->db->last_query();die;
    //  echo  $indent_id;
    if ($indent_id) {
      $response['indentId'] = $indent_id;
      $response['result'] = true;
      $response['reason'] = 'Data Found';
    } else {
      $response['result'] = false;
      $response['reason'] = 'Something went to wrong!';
    }
    echo json_encode($response);
  }

  // org
  // public function saveIndentAllModule()
  // {
  //   $post = $this->input->post();
  //   //     echo "<pre>";
  //   // print_r($post);
  //   // die;

  //   if (isset($post['master_indent_id'])) {
  //     $master_indent_tbl = $this->CommonModel->getData('tbl_master_indent_for', array('id' => $post['master_indent_id']), 'id,db_table_name', '', 'row_array');
  //     // print_r($master_indent_tbl);die;
  //     if (isset($master_indent_tbl['db_table_name'])) {
  //       if (isset($post['id']) && !empty($post['id'])) {
  //         $post['updated_by'] = userId();
  //         $post['updated_at'] = date('Y-m-d H:i:s');
  //         $indent_module_id = $post['id'];
  //         $this->CommonModel->iudAction($master_indent_tbl['db_table_name'], $post, 'update', array('id' => $post['id']));
  //       } else {
  //         $post['created_by'] = userId();
  //         $indent_module_id = $this->CommonModel->iudAction($master_indent_tbl['db_table_name'], $post, 'insert');

  //         $data_details_data = array(
  //           'indent_id' => $post['indent_id'],
  //           'plant_id' => $post['plant_id'],
  //           'master_indent_id' => $post['master_indent_id'],
  //           'ref_id' => $indent_module_id,
  //           'created_by' => userId(),
  //           'created_at' => date('Y-m-d H:i:s')
  //         );
  //         $this->CommonModel->iudAction('tbl_indent_details', $data_details_data, 'insert');
  //       }
  //       // $response['tbody'] =$this->getTableViewLoad($post['master_indent_id'],$indent_module_id);
  //       $response['result'] = true;
  //       $response['reason'] = 'Data Found';
  //     } else {
  //       $response['result'] = false;
  //       $response['reason'] = 'Indent datbase for not found';
  //     }
  //   } else {
  //     $response['result'] = false;
  //     $response['reason'] = 'Indent for not found';
  //   }
  //   echo json_encode($response);
  // }

  //working but some isshue 
  // public function saveIndentAllModule()
  // {
  //   $post = $this->input->post();
  //    echo"<pre>";
  //    print_r($post);
  //    die;
  //   if (isset($post['master_indent_id'])) {

  //     $master_indent_tbl = $this->CommonModel->getData(
  //       'tbl_master_indent_for',
  //       array('id' => $post['master_indent_id']),
  //       'id,db_table_name',
  //       '',
  //       'row_array'
  //     );

  //     if (isset($master_indent_tbl['db_table_name'])) {

  //       $specFields = ['group_qty', 'motor_power', 'dbse', 'tube_od_thk', 'bore', 'keyway', 'fan_rpm'];

  //       foreach ($specFields as $field) {
  //         if (isset($post[$field])) {
  //           unset($post[$field]);
  //         }
  //       }

  //       if (isset($post['id']) && !empty($post['id'])) {

  //         $post['updated_by'] = userId();
  //         $post['updated_at'] = date('Y-m-d H:i:s');

  //         $indent_module_id = $post['id'];

  //         $this->CommonModel->iudAction(
  //           $master_indent_tbl['db_table_name'],
  //           $post,
  //           'update',
  //           array('id' => $post['id'])
  //         );
  //       } else {

  //         $post['created_by'] = userId();

  //         $indent_module_id = $this->CommonModel->iudAction(
  //           $master_indent_tbl['db_table_name'],
  //           $post,
  //           'insert'
  //         );

  //         $data_details_data = array(
  //           'indent_id'        => $post['indent_id'],
  //           'plant_id'         => $post['plant_id'],
  //           'master_indent_id' => $post['master_indent_id'],
  //           'ref_id'           => $indent_module_id,
  //           'created_by'       => userId(),
  //           'created_at'       => date('Y-m-d H:i:s')
  //         );

  //         $this->CommonModel->iudAction('tbl_indent_details', $data_details_data, 'insert');
  //       }

  //       if ($post['master_indent_id'] == 7) {

  //         $this->db->where('indent_sub_id', $indent_module_id);
  //         $this->db->delete('tbl_carbon_fiber_drive_shaft_specifications');

  //         $group_qty = $this->input->post('group_qty');
  //         $motor_power = $this->input->post('motor_power');
  //         $dbse = $this->input->post('dbse');
  //         $tube_od_thk = $this->input->post('tube_od_thk');
  //         $fan_rpm = $this->input->post('fan_rpm');
  //         $boreArr = $this->input->post('bore');
  //         $keywayArr = $this->input->post('keyway');

  //         if (!empty($group_qty)) {

  //           foreach ($group_qty as $i => $qty) {

  //             if (empty($qty)) continue;

  //             /* ===== collect ALL bore values ===== */
  //             $boreValues = [];
  //             if (!empty($boreArr)) {
  //               foreach ($boreArr as $b) {
  //                 if (isset($b[0]) && $b[0] !== '') {
  //                   $boreValues[] = $b[0];
  //                 }
  //               }
  //             }

  //             /* ===== collect ALL keyway values ===== */
  //             $keywayValues = [];
  //             if (!empty($keywayArr)) {
  //               foreach ($keywayArr as $k) {
  //                 if (isset($k[0]) && $k[0] !== '') {
  //                   $keywayValues[] = $k[0];
  //                 }
  //               }
  //             }

  //             $specData = [
  //               'indent_id'     => $post['indent_id'],
  //               'indent_sub_id' => $indent_module_id,

  //               'group_qty'     => $qty,
  //               'motor_power'   => $motor_power[$i] ?? null,
  //               'dbse'          => $dbse[$i] ?? null,
  //               'tube_od_thk'   => $tube_od_thk[$i] ?? null,

  //               'bore'          => !empty($boreValues) ? json_encode($boreValues) : null,
  //               'keyway'        => !empty($keywayValues) ? json_encode($keywayValues) : null,

  //               'fan_rpm'       => $fan_rpm[$i] ?? null,
  //             ];

  //             //  echo "<pre>";
  //             //       print_r($specData);
  //             //       die;  

  //             $this->CommonModel->iudAction(
  //               'tbl_carbon_fiber_drive_shaft_specifications',
  //               $specData,
  //               'insert'
  //             );
  //           }
  //         }
  //       }


  //       $response['result'] = true;
  //       $response['reason'] = 'Data Found';
  //     } else {
  //       $response['result'] = false;
  //       $response['reason'] = 'Indent datbase for not found';
  //     }
  //   } else {
  //     $response['result'] = false;
  //     $response['reason'] = 'Indent for not found';
  //   }
  //   echo json_encode($response);
  // }

  public function saveIndentAllModule()
  {
    $post = $this->input->post();
    // echo '<pre>';
    // print_r($post);
    // die;

    if (isset($post['master_indent_id'])) {
      // echo '<pre>';
      // print_r($post);
      // die;
      $master_indent_tbl = $this->CommonModel->getData(
        'tbl_master_indent_for',
        ['id' => $post['master_indent_id']],
        '*',
        '',
        'row_array'
      );


      if (isset($master_indent_tbl['db_table_name'])) {

        if ($post['master_indent_id'] == 7) {

          $specFields = [
            'group_qty',
            'motor_power',
            'dbse',
            'tube_od_thk',
            'fan_dia',
            'no_of_blade',
            'bore',
            'keyway',
            'fan_rpm',
            'gearbox_model_no'
          ];
        } elseif ($post['master_indent_id'] == 21) {

          $specFields = [
            'group_qty',
            'length_dia',
            'ext_group_qty',
            'ext_group_id',
            'length_dia_id'
          ];
        } else {
          $specFields = [];
        }

        foreach ($specFields as $field) {

          unset($post[$field]);
        }


        unset($post['spec_id']);
        unset($post['design_file']);

        // if ($post['master_indent_id'] == 21) {

        //   // $order_for        = 1;
        //   // $indent_date      = $post['indent_date'] ?? date('Y-m-d');
        //   // $indent_db_id     = $post['indent_db_id'] ?? '';
        //   // $indent_sequence  = $post['indent_sequence'] ?? '';
        //   // // $manual_indent_no = $post['indent_number'] ?? '';
        //   // $order_qty        = $post['order_qty'] ?? 0;

        //   // unset($post['order_for']);
        //   // unset($post['indent_db_id']);
        //   // unset($post['indent_sequence']);
        //   // // unset($post['indent_number']);
        //   // unset($post['order_qty']);
        // }

        if (!in_array($post['master_indent_id'], [21, 22])) {

          if (!empty($post['id'])) {

            $post['updated_by'] = userId();
            $post['updated_at'] = date('Y-m-d H:i:s');

            $indent_module_id = $post['id'];

            $this->CommonModel->iudAction(
              $master_indent_tbl['db_table_name'],
              $post,
              'update',
              ['id' => $post['id']]
            );
          } else {

            $post['created_by'] = userId();

            $indent_module_id = $this->CommonModel->iudAction(
              $master_indent_tbl['db_table_name'],
              $post,
              'insert'
            );

            $data_details_data = [

              'indent_id'        => $post['indent_id'],
              'plant_id'         => $post['plant_id'],
              'master_indent_id' => $post['master_indent_id'],
              'ref_id'           => $indent_module_id,
              'created_by'       => userId(),
              'created_at'       => date('Y-m-d H:i:s')
            ];

            $this->CommonModel->iudAction(
              'tbl_indent_details',
              $data_details_data,
              'insert'
            );
          }
        }

        if ($post['master_indent_id'] == 7) {

          $this->db->trans_begin();
          $this->db->where('indent_sub_id', $indent_module_id);
          $this->db->delete('tbl_carbon_fiber_drive_shaft_specifications');

          $group_qty   = $this->input->post('group_qty');
          $motor_power = $this->input->post('motor_power');
          $dbse        = $this->input->post('dbse');
          $tube_od_thk = $this->input->post('tube_od_thk');
          $fan_dia     = $this->input->post('fan_dia');
          $no_of_blade = $this->input->post('no_of_blade');
          $fan_rpm     = $this->input->post('fan_rpm');
          $boreArr     = $this->input->post('bore');
          $keywayArr   = $this->input->post('keyway');
          $gearbox_model_no = $this->input->post('gearbox_model_no');

          if (!empty($group_qty)) {

            foreach ($group_qty as $i => $qty) {

              if (empty($qty)) continue;

              $borePairs = [];
              if (!empty($boreArr[$i])) {

                $values = array_values(array_filter($boreArr[$i], function ($v) {
                  return $v !== null && $v !== '';
                }));

                for ($j = 0; $j < count($values); $j += 2) {

                  $borePairs[] = [
                    'motor' => $values[$j] ?? null,
                    'gear'  => $values[$j + 1] ?? null
                  ];
                }
              }

              $keywayPairs = [];

              if (!empty($keywayArr[$i])) {

                $values = array_values(array_filter($keywayArr[$i], function ($v) {
                  return $v !== null && $v !== '';
                }));

                for ($j = 0; $j < count($values); $j += 2) {

                  $keywayPairs[] = [
                    'motor' => $values[$j] ?? null,
                    'gear'  => $values[$j + 1] ?? null
                  ];
                }
              }


              $specData = [

                'indent_id'     => $post['indent_id'] ?? $indent_module_id,
                'indent_sub_id' => $indent_module_id,
                'group_qty'     => $qty,
                'motor_power'   => $motor_power[$i] ?? null,
                'dbse'          => $dbse[$i] ?? null,
                'tube_od_thk'   => $tube_od_thk[$i] ?? null,
                'fan_dia'       => $fan_dia[$i] ?? null,
                'no_of_blade'   => $no_of_blade[$i] ?? null,
                'fan_rpm'       => $fan_rpm[$i] ?? null,
                'gearbox_model_no' => $gearbox_model_no[$i] ?? null,

                'bore'   => !empty($borePairs)
                  ? json_encode($borePairs)
                  : null,

                'keyway' => !empty($keywayPairs)
                  ? json_encode($keywayPairs)
                  : null,
              ];

              $this->CommonModel->iudAction(
                'tbl_carbon_fiber_drive_shaft_specifications',
                $specData,
                'insert'
              );
            }
          }


          $manual_indent_no = $this->db
            ->select('indent_number')
            ->where('id', $post['indent_id'])
            ->get('tbl_indent')
            ->row('indent_number');


          $total_qty = !empty($group_qty)
            ? array_sum($group_qty)
            : 0;


          $orderData = [

            'order_for'        => 1,
            'indent_date'      => $post['indent_date']
              ?? date('Y-m-d'),

            'delivery_date'    => !empty($post['delivery_date'])
              ? date('Y-m-d', strtotime($post['delivery_date']))
              : NULL,

            'party_id'         => $post['plant_id'] ?? '',
            'indent_id'        => $post['indent_id']
              ?? $indent_module_id,

            'manual_indent_no' => $manual_indent_no,
            'remark'           => $post['remark'] ?? '',
            'total_order_qty'  => $total_qty,
            'order_qty'         => $order_qty,
            'created_at'       => date('Y-m-d H:i:s'),
            'created_by'       => userId(),
          ];


          $order_id = $post['order_id'] ?? '';

          if (!empty($order_id)) {

            $orderData['updated_at'] = date('Y-m-d H:i:s');
            $orderData['updated_by'] = userId();

            $this->CommonModel->iudAction(
              'tbl_indent_carbon_fiber_drive_shaft_received_orders',
              $orderData,
              'update',
              ['id' => $order_id]
            );
          } else {

            $order_id = $this->CommonModel->iudAction(
              'tbl_indent_carbon_fiber_drive_shaft_received_orders',
              $orderData,
              'insert'
            );

            if (!$order_id) {

              echo '<pre>';
              print_r($orderData);
              print_r($this->db->error());
              echo $this->db->last_query();
              die;
            }

            if ($order_id) {

              $stages = $this->db
                ->order_by('id', 'ASC')
                ->get('tbl_cfds_stage_master')
                ->result();

              foreach ($stages as $stage) {

                $detailData = [

                  'order_id'   => $order_id,
                  'status_id'  => $stage->id,
                  'qty'        => 0,
                  'date'       => date('Y-m-d'),
                  'remark'     => '',
                  'company_id' => $this->session->userdata('company_id'),
                  'created_by' => userId(),
                  'created_at' => date('Y-m-d H:i:s')
                ];

                $this->CommonModel->iudAction(
                  'tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail',
                  $detailData,
                  'insert'
                );
              }


              $statusData = [

                'order_id'            => $order_id,
                'qty'                 => $total_qty,
                'order_qty'           => $total_qty,
                'indent_transfer_qty' => 0,
                'company_id'          => $this->session->userdata('company_id'),
                'created_qty'         => 0,
                'created_at'          => date('Y-m-d H:i:s'),
                'created_by'          => userId()
              ];

              $this->CommonModel->iudAction(
                'tbl_indent_carbon_fiber_drive_shaft_received_order_status',
                $statusData,
                'insert'
              );
            }
          }


          if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            echo '<pre>';
            print_r($this->db->error());
            die;
          } else {

            $this->db->trans_commit();
          }
        }
        if ($post['master_indent_id'] == 21) {

          $this->db->trans_begin();
          $order_for        = 1;
          $indent_date      = $post['indent_date'] ?? date('Y-m-d');
          $indent_db_id     = $post['indent_db_id'] ?? '';
          $indent_sequence  = $post['indent_sequence'] ?? '';
          // $manual_indent_no = $post['indent_number'] ?? '';
          $order_qty        = $post['order_qty'] ?? 0;

          unset($post['order_for']);
          unset($post['indent_db_id']);
          unset($post['indent_sequence']);
          // unset($post['indent_number']);
          unset($post['order_qty']);

          $company_id = $this->session->userdata('company_id');

          $converted_date = !empty($post['date'])
            ? date('Y-m-d', strtotime($post['date']))
            : date('Y-m-d');

          $delivery_date = !empty($post['delivery_date'])
            ? date('Y-m-d', strtotime($post['delivery_date']))
            : NULL;

          $deliverydate = $this->CommonModel->getData(
            'tbl_indent',
            ['id' => $indent_db_id],
            'delivery_date',
            '',
            'row_array'
          );

          $delivery_date = !empty($deliverydate['delivery_date']) ? $deliverydate['delivery_date'] : NULL;


          $client_id = $this->session->userdata('user_id');

          $plant_id = $this->CommonModel->getData(
            'tbl_indent',
            ['id' => $indent_db_id],
            'plant_id',
            '',
            'row_array'
          );

          $plant_id = !empty($plant_id['plant_id']) ? $plant_id['plant_id'] : NULL;

          $existingIndentData = [];

          if (!empty($indent_db_id)) {

            $existingIndentData = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_db_id],
              '*',
              '',
              'row_array'
            );
          }

          $array_indent = [

            'client_id'       => $client_id,
            'plant_id'        => $plant_id,
            // 'indent_no'       => $post['indent_no'] ?? '',
            'date'            => $converted_date,
            'delivery_date'   => $delivery_date,
            'indent_sequence' => !empty($indent_sequence)
              ? $indent_sequence
              : ($existingIndentData['indent_sequence'] ?? ''),

            'indent_number'   => !empty($post['manual_indent_no'])
              ? $post['manual_indent_no']
              : ($existingIndentData['indent_number'] ?? ''),

            'is_lock'         => 0
          ];

          $indent_id = $indent_db_id;

          if (!empty($indent_id)) {

            $array_indent['updated_by'] = userId();
            $array_indent['updated_at'] = date('Y-m-d H:i:s');

            $this->CommonModel->iudAction(
              'tbl_indent',
              $array_indent,
              'update',
              ['id' => $indent_id]
            );
          } else {

            $array_indent['created_by'] = userId();
            $indent_id = $this->CommonModel->iudAction(
              'tbl_indent',
              $array_indent,
              'insert'
            );
          }

          if ($indent_id) {

            $moduleData = [

              'master_indent_id' => 21,
              'indent_id'        => $indent_id,
              'plant_id'         => $plant_id,
              'dimension'        => $post['dimension'] ?? '',
              'material'         => $post['material'] ?? '',
              'remark'           => $post['remark'] ?? '',
              'qty' => $order_qty,
              'make'             => $post['make'] ?? '',
            ];

            $design_file = null;

            if (!empty($_FILES['design_file']['name'])) {

              $result = fileUpload(
                FRP_HEADER_PIPE_DESIGN_FILE,
                'design_file'
              );

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

              'indent_id'        => $indent_id,
              'plant_id'         => $plant_id,
              'master_indent_id' => 21,
              'ref_id'           => $indent_module_id,
              'created_by'       => userId(),
              'created_at'       => date('Y-m-d H:i:s')
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

            $group_qty = $this->input->post('group_qty') ?: [];

            $ext_group_qty = $this->input->post('ext_group_qty') ?: [];

            foreach ($group_qty as $i => $qty) {

              if (
                isset($ext_group_qty[$i]) &&
                $ext_group_qty[$i] != ''
              ) {

                $group_qty[$i] = $ext_group_qty[$i];
              }
            }

            $length_dia = $this->input->post('length_dia') ?: [];

            if (!empty($group_qty)) {

              foreach ($group_qty as $i => $qty) {

                if (empty($qty)) continue;

                $specData = [

                  'indent_id'     => $indent_id,
                  'indent_sub_id' => $indent_module_id,
                  'group_qty'     => $qty,
                  'length_dia'    => $length_dia[$i] ?? null,
                  'created_at'    => date('Y-m-d H:i:s'),
                  'updated_at'    => date('Y-m-d H:i:s')
                ];

                $this->CommonModel->iudAction(
                  'tbl_frp_header_pipe_specifications',
                  $specData,
                  'insert'
                );
              }
            }
          }

          $orderData = [

            'order_for' => $order_for,
            'indent_date' => $indent_date,
            'delivery_date' => $delivery_date,
            'party_id' => $plant_id,
            'indent_id' => $indent_id,
            'manual_indent_no' => $array_indent['indent_number'],
            'remark' => $post['remark'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => userId(),
            'order_qty' => !empty($post['ext_group_qty'])
              ? array_sum($post['ext_group_qty'])
              : 0,
          ];

          $existingOrder = $this->CommonModel->getData(
            'tbl_indent_frp_header_pipe_received_orders',
            [
              'indent_id' => $indent_id
            ],
            '*',
            '',
            'row_array'
          );

          $order_id = $existingOrder['id'] ?? '';
          if (!empty($order_id)) {

            $orderData['order_qty'] =
              !empty($post['ext_group_qty'])
              ? array_sum($post['ext_group_qty'])
              : 0;

            $orderData['updated_by'] = userId();

            $orderData['updated_at'] = date('Y-m-d H:i:s');

            $this->CommonModel->iudAction(
              'tbl_indent_frp_header_pipe_received_orders',
              $orderData,
              'update',
              ['id' => $order_id]
            );
          } else {

            $orderData['created_by'] = userId();

            $orderData['total_order_qty'] = $order_qty;
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

                $existsDetail = $this->CommonModel->getData(
                  'tbl_indent_frp_header_pipe_received_order_status_detail',
                  [
                    'order_id' => $order_id,
                    'status_id' => $stage->id
                  ],
                  '*',
                  '',
                  'row_array'
                );

                if (empty($existsDetail)) {

                  $this->CommonModel->iudAction(
                    'tbl_indent_frp_header_pipe_received_order_status_detail',
                    [
                      "order_id"   => $order_id,
                      "status_id"  => $stage->id,
                      "qty"        => 0,
                      "company_id" => $company_id,
                      "created_by" => userId(),
                      "created_at" => date('Y-m-d H:i:s')
                    ],
                    'insert'
                  );
                }
              }

              $existsStatus = $this->CommonModel->getData(
                'tbl_indent_frp_header_pipe_received_order_status',
                [
                  'order_id' => $order_id
                ],
                '*',
                '',
                'row_array'
              );

              $statusData = [

                "order_id" => $order_id,

                'qty' => $order_qty,

                'order_qty' => $order_qty,

                'company_id' => $company_id
              ];

              if (!empty($existsStatus)) {

                $statusData['updated_by'] = userId();
                $statusData['updated_at'] = date('Y-m-d H:i:s');

                $this->CommonModel->iudAction(
                  'tbl_indent_frp_header_pipe_received_order_status',
                  $statusData,
                  'update',
                  ['id' => $existsStatus['id']]
                );
              } else {

                $statusData['created_by'] = userId();
                $statusData['created_at'] = date('Y-m-d H:i:s');

                $this->CommonModel->iudAction(
                  'tbl_indent_frp_header_pipe_received_order_status',
                  $statusData,
                  'insert'
                );
              }
            }
          }

          if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            $response = [
              'result' => false,
              'reason' => 'Transaction failed'
            ];
          } else {

            $this->db->trans_commit();

            $response = [
              'result' => true,
              'reason' => 'Saved Successfully'
            ];
          }

          echo json_encode($response);
          exit;
        }
        if ($post['master_indent_id'] == 22) {

          $this->db->trans_begin();
          $order_for        = 1;
          $indent_date      = $post['indent_date'] ?? date('Y-m-d');
          $indent_db_id     = $post['indent_db_id'] ?? '';
          $indent_sequence  = $post['indent_sequence'] ?? '';
          $order_qty        = $post['order_qty'] ?? 0;

          unset($post['order_for']);
          unset($post['indent_db_id']);
          unset($post['indent_sequence']);
          // unset($post['indent_number']);
          unset($post['order_qty']);

          $company_id = $this->session->userdata('company_id');

          $converted_date = !empty($post['date'])
            ? date('Y-m-d', strtotime($post['date']))
            : date('Y-m-d');

          $delivery_date = !empty($post['delivery_date'])
            ? date('Y-m-d', strtotime($post['delivery_date']))
            : NULL;

          $deliverydate = $this->CommonModel->getData(
            'tbl_indent',
            ['id' => $indent_db_id],
            'delivery_date',
            '',
            'row_array'
          );

          $delivery_date = !empty($deliverydate['delivery_date']) ? $deliverydate['delivery_date'] : NULL;

          // echo '<pre>';
          // print_r($delivery_date);
          // die;
          $client_id = $this->session->userdata('user_id');

          $plant_id = $this->CommonModel->getData(
            'tbl_indent',
            ['id' => $indent_db_id],
            'plant_id',
            '',
            'row_array'
          );

          $plant_id = !empty($plant_id['plant_id']) ? $plant_id['plant_id'] : NULL;

          $existingIndentData = [];

          if (!empty($indent_db_id)) {

            $existingIndentData = $this->CommonModel->getData(
              'tbl_indent',
              ['id' => $indent_db_id],
              '*',
              '',
              'row_array'
            );
          }
          $array_indent = [

            'client_id'       => $client_id,
            'plant_id'        => $post['plant_id'],
            // 'indent_no'       => $post['indent_no'] ?? '',
            'date'            => $converted_date,
            'delivery_date'   => $delivery_date,
            'indent_sequence' => !empty($indent_sequence)
              ? $indent_sequence
              : ($existingIndentData['indent_sequence'] ?? ''),

            'indent_number'   => !empty($post['manual_indent_no'])
              ? $post['manual_indent_no']
              : ($existingIndentData['indent_number'] ?? ''),

            'is_lock'         => 0
          ];

          $indent_id = $indent_db_id;

          if (!empty($indent_id)) {

            $array_indent['updated_by'] = userId();
            $array_indent['updated_at'] = date('Y-m-d H:i:s');
            $array_indent['plant_id'] = $post['plant_id'];

            $this->CommonModel->iudAction(
              'tbl_indent',
              $array_indent,
              'update',
              ['id' => $indent_id]
            );
          } else {

            $array_indent['created_by'] = userId();
            $indent_id = $this->CommonModel->iudAction(
              'tbl_indent',
              $array_indent,
              'insert'
            );
          }
          if ($indent_id) {

            $moduleData = [

              'master_indent_id' => 22,
              'indent_id'        => $indent_id,
              'plant_id'         => $post['plant_id'] ?? '',
              'clamp_size'       => $post['clamp_size'] ?? '',
              'material'         => $post['material'] ?? '',
              'qty'              => $order_qty,
              'make'             => $post['make'] ?? '',
              'remark'           => $post['remark'] ?? '',
            ];

            $existingModule = $this->CommonModel->getData(
              'tbl_indent_frp_clamp',
              ['indent_id' => $indent_id],
              '*',
              '',
              'row_array'
            );

            if (!empty($existingModule)) {

              $moduleData['updated_at'] = date('Y-m-d H:i:s');

              $moduleData['updated_by'] = userId();

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

            $data_details_data = [

              'indent_id'        => $indent_id,
              'plant_id'         => $post['plant_id'] ?? '',
              'master_indent_id' => 22,
              'ref_id'           => $indent_module_id,
              'created_by'       => userId(),
              'created_at'       => date('Y-m-d H:i:s')
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
          $orderData = [

            'order_for' => $order_for,
            'indent_date' => $indent_date,
            'delivery_date' => $delivery_date,
            'party_id' => $post['client_id'],
            'indent_id' => $indent_id,
            'manual_indent_no' => $array_indent['indent_number'],
            'remark' => $post['remark'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => userId(),
            'order_qty' => !empty($post['ext_group_qty'])
              ? array_sum($post['ext_group_qty'])
              : 0,
          ];

          $existingOrder = $this->CommonModel->getData(
            'tbl_indent_frp_clamp_received_orders',
            [
              'indent_id' => $indent_id
            ],
            '*',
            '',
            'row_array'
          );

          $order_id = $existingOrder['id'] ?? '';
          if (!empty($order_id)) {

            $orderData['order_qty'] =
              !empty($post['ext_group_qty'])
              ? array_sum($post['ext_group_qty'])
              : 0;

            $orderData['updated_by'] = userId();

            $orderData['updated_at'] = date('Y-m-d H:i:s');

            $this->CommonModel->iudAction(
              'tbl_indent_frp_clamp_received_orders',
              $orderData,
              'update',
              ['id' => $order_id]
            );
          } else {

            $orderData['created_by'] = userId();

            $orderData['total_order_qty'] = $order_qty;
            $order_id = $this->CommonModel->iudAction(
              'tbl_indent_frp_clamp_received_orders',
              $orderData,
              'insert'
            );

            if ($order_id) {

              $stages = $this->db
                ->order_by('sequence', 'ASC')
                ->get('tbl_frp_clamp_stage_master')
                ->result();

              foreach ($stages as $stage) {

                $existsDetail = $this->CommonModel->getData(
                  'tbl_indent_frp_clamp_received_order_status_detail',
                  [
                    'order_id' => $order_id,
                    'status_id' => $stage->id
                  ],
                  '*',
                  '',
                  'row_array'
                );

                if (empty($existsDetail)) {

                  $this->CommonModel->iudAction(
                    'tbl_indent_frp_clamp_received_order_status_detail',
                    [
                      "order_id"   => $order_id,
                      "status_id"  => $stage->id,
                      "qty"        => 0,
                      "company_id" => $company_id,
                      "created_by" => userId(),
                      "created_at" => date('Y-m-d H:i:s')
                    ],
                    'insert'
                  );
                }
              }

              $existsStatus = $this->CommonModel->getData(
                'tbl_indent_frp_clamp_received_order_status',
                [
                  'order_id' => $order_id
                ],
                '*',
                '',
                'row_array'
              );

              $statusData = [

                "order_id" => $order_id,

                'qty' => $order_qty,

                'order_qty' => $order_qty,

                'company_id' => $company_id
              ];

              if (!empty($existsStatus)) {

                $statusData['updated_by'] = userId();
                $statusData['updated_at'] = date('Y-m-d H:i:s');

                $this->CommonModel->iudAction(
                  'tbl_indent_frp_clamp_received_order_status',
                  $statusData,
                  'update',
                  ['id' => $existsStatus['id']]
                );
              } else {

                $statusData['created_by'] = userId();
                $statusData['created_at'] = date('Y-m-d H:i:s');

                $this->CommonModel->iudAction(
                  'tbl_indent_frp_clamp_received_order_status',
                  $statusData,
                  'insert'
                );
              }
            }
          }
          if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            $response = [
              'result' => false,
              'reason' => 'Transaction failed'
            ];
          } else {

            $this->db->trans_commit();

            $response = [
              'result' => true,
              'reason' => 'Saved Successfully'
            ];
          }

          echo json_encode($response);
          exit;
        }
        $response = [
          'result' => true,
          'reason' => 'Saved successfully'
        ];
      } else {
        $response = [
          'result' => false,
          'reason' => 'Indent database not found'
        ];
      }
    } else {
      $response = [
        'result' => false,
        'reason' => 'Master indent ID missing'
      ];
    }

    echo json_encode($response);
    exit();
  }


  public function getTableViewLoad($master_indent_id, $indent_module_id)
  {
    $master_indent_tbl = $this->CommonModel->getData('tbl_master_indent_for', array('id' => $master_indent_id), '', '', 'row_array');
    $tbodyHtml = '';
    if (isset($master_indent_tbl['db_table_name'])) {
      $sub_tbl_data = $this->CommonModel->getData($master_indent_tbl['db_table_name'], array('id' => $indent_module_id), '', '', 'row_array');
      $plant_info = $this->CommonModel->getData('tbl_site', array('id' => $sub_tbl_data['plant_id']), '', '', 'row_array');
      $output = '';
      foreach ($sub_tbl_data as $key => $value) {
        if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
          $output .= ucfirst(str_replace("_", " ", $key)) . ": $value\n";
        }
      }
      $confirm = "confirm('Are you sure you want to delete this ?')";

      $action = '<a href="javascript:void(0);" title="Edit" onclick="open_modal_indent_blade(' . $master_indent_id . ',' . $sub_tbl_data['indent_id'] . ',' . $indent_module_id . ')" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
      $action .= '<a href="javascript:void(0);"  onclick="open_modal_indent_delete_blade(' . $master_indent_id . ',' . $sub_tbl_data['indent_id'] . ',' . $indent_module_id . ')" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
      $qty = isset($sub_tbl_data[$master_indent_tbl['db_qty_field_name']]) ? $sub_tbl_data[$master_indent_tbl['db_qty_field_name']] : 0;
      $tbodyHtml = '<tr id="tr_indent_' . $indent_module_id . '"><th width="20px"><br>1</th><th>' . $plant_info['site_name'] . '</th><th>' . $master_indent_tbl['indent_name'] . '</th><th>' . $output . '</th><th>' . $qty . '</th><td>' . $action . '</td></tr>';
    }
    return $tbodyHtml;
  }

  function getIndentModuleDetailsData()
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
    $where['ti.indent_id'] = $data['indent_id'];

    $count = count($this->IndentModel->getIndentModuleData($searchVal, 0, 0, 0, 0, 0, $where));
    if ($count) {
      $result = $this->IndentModel->getIndentModuleData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
      // echo $this->db->last_query();die;

      // echo"<pre>";
      //   print_r($result);
      //   die;  

      foreach ($result as $key1 => $value1) {
        $flag = $own_flag_access = 0;
        $row = [];

        array_push($row, $offset + ($key1 + 1));
        array_push($row, $value1['site_name']);
        array_push($row, $value1['indent_name']);

        //desc
        $sub_tbl_data = $this->CommonModel->getData($value1['db_table_name'], array('id' => $value1['ref_id']), '', '', 'row_array');
        if (!empty($sub_tbl_data)) {
          $output = '';
          foreach ($sub_tbl_data as $key => $value) {
            if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
              $output .= ucfirst(str_replace("_", " ", $key)) . ": $value\n";
            }
          }
          $qty = isset($sub_tbl_data[$value1['db_qty_field_name']]) ? $sub_tbl_data[$value1['db_qty_field_name']] : 0;
        } else {
          $output = '';
          $qty = 0;
        }



        array_push($row, $output);
        array_push($row, $qty);

        $confirm = "confirm('Are you sure you want to delete this PO?')";
        $action = '<a href="javascript:void(0);" title="Edit" onclick="open_modal_indent_blade(' . $value1['master_indent_id'] . ',' . $value1['indent_id'] . ',' . $value1['ref_id'] . ')" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
        $action .= '<a href="javascript:void(0);"  onclick="open_modal_indent_delete_blade(' . $value1['master_indent_id'] . ',' . $value1['indent_id'] . ',' . $value1['ref_id'] . ',' . $value1['indent_details_id'] . ')" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
        //   $action .= '<a href="javascript:void(0)" onclick="IndentGetLock(' . $value['id'] . ',0)" title="Click Here For Unlock" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-lock" aria-hidden="true"></i></a>';
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

  function deleteModuleIndent()
  {
    $post = $this->input->post();

    if (isset($post['master_indent_id']) && isset($post['indent_details_id'])) {
      $master_indent_tbl = $this->CommonModel->getData('tbl_master_indent_for', array('id' => $post['master_indent_id']), 'id,db_table_name', '', 'row_array');
      if (isset($master_indent_tbl['db_table_name'])) {
        if (isset($post['id']) && !empty($post['id'])) {
          $indent_details_id = $post['indent_details_id'];
          unset($post['indent_details_id']);
          $post['deleted_by'] = userId();
          $post['deleted_at'] = date('Y-m-d H:i:s');
          $indent_module_id = $post['id'];
          $this->CommonModel->iudAction($master_indent_tbl['db_table_name'], $post, 'update', array('id' => $post['id']));
          $this->CommonModel->iudAction('tbl_indent_details', array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('indent_id' => $post['indent_id'], 'ref_id' => $post['id'], 'id' => $indent_details_id));
          //echo $this->db->last_query();die;
          // $response['tbody'] =$this->getTableViewLoad($post['master_indent_id'],$indent_module_id);
          $response['result'] = true;
          $response['reason'] = 'Indent For Deleted ';
        } else {
          $response['result'] = false;
          $response['reason'] = 'Indent for not found';
        }
      } else {
        $response['result'] = false;
        $response['reason'] = 'Indent for not found';
      }
      echo json_encode($response);
      die;
    }
  }

  public function listindent()
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
    // print_r($data);die;


    $where['ti.deleted_by'] = NULL;
    $count = count($this->IndentModel->getindentData($searchVal, 0, 0, 0, 0, 0, $where));
    // echo $this->db->last_query();die;
    if ($count) {
      $result = $this->IndentModel->getindentData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
      // echo"<pre>";
      // print_r($result);die;
      foreach ($result as $key => $value) {

        $row = [];

        array_push($row, $offset + ($key + 1));

        // array_push($row, $value['company_name']);
        array_push($row, $value['client_name']);
        array_push($row, $value['plant_narration']);
        array_push($row, $value['indent_no']);
        array_push($row, $value['indent_number']);
        array_push($row, $value['date']);
        $confirm = "confirm('Are you sure you want to delete this Service?')";

        $action = '<a href="' . base_url() . 'admin/indent/Indent/add_indent/' . $value['id'] . '" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-edit" aria-hidden="true"></i></a>';
        $action .= '<a href="' . base_url() . 'admin/indent/Indent/viewIndentData/' . $value['id'] . '" title="View" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-eye" aria-hidden="true"></i></a>';
        $action .= '<a href="' . base_url() . 'admin/indent/Indent/generate_pdf/' . $value['id'] . '" title="print indent" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-print" aria-hidden="true"></i></a>';
        $action .= '<a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/indent/Indent/delete_indent/' . $value['id'] . '" title="Delete indent" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-trash" aria-hidden="true"></i></a>';
        if ($value['is_lock'] == 0):
          $action .= '<a href="javascript:void(0)" onclick="indentGetLock(' . $value['id'] . ',1)" title="Click Here For Lock" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-unlock" aria-hidden="true"></i></a>';
        elseif ($value['is_lock'] == 1):
          $action .= '<a href="javascript:void(0)" onclick="indentGetLock(' . $value['id'] . ',0)" title="Click Here For Unlock" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-lock" aria-hidden="true"></i></a>';
        else:
          $action .= '';
        endif;
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

  public function delete_indent($id)
  {
    if ($id) {

      $this->CommonModel->iudAction('tbl_indent', array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $id));

      $indent_details =   $this->CommonModel->getData('tbl_indent_details', array('indent_id' => $id), '', '', 'result_array');
      // echo"<pre>";
      // print_r($indent_details);die;
      foreach ($indent_details as $indDet) {

        $master_indent_details =  $this->CommonModel->getData('tbl_master_indent_for', array('id' => $indDet['master_indent_id']), '', '', 'row_array');
        $this->CommonModel->iudAction('tbl_indent_details', array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('indent_id' => $id));

        $this->CommonModel->iudAction($master_indent_details['db_table_name'], array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('indent_id' => $id, 'id' => $indDet['ref_id']));
      }
      $this->session->set_flashdata('success', 'Indent Deleted Succesfully!');
      redirect(ADMIN . 'indent/indent');
    }
  }

  public function viewIndentData($id = '', $indent_id = '')
  {
    $indentviewData = $this->IndentModel->getindentData('', 0, 0, 0, 0, $id);
    $data['indentviewData'] = $indentviewData[0];
    $data['plant_data'] = $this->IndentModel->getSiteNameByIndentId($id);
    $groupedIndentData = $this->IndentModel->getIndentViewData(array('ti.indent_id' => $id), 1);

    $indentData = [];
    foreach ($groupedIndentData as $key => $record) {
      $indentData = $this->IndentModel->getIndentViewData(array('ti.indent_id' => $id, 'ti.plant_id' => $record['plant_id']), 0);
      $groupedIndentData[$key]['indent_details'] =  $indentData;
    }

    $data['indent_specific_data'] = $groupedIndentData;
    $data['offset'] = 0;

    $this->load->view(ADMIN . 'indent/view_indent', $data);
  }
  public function generate_pdf($id = '', $indent_id = '')
  {
    $this->load->library('pdf');
    $post = $this->input->post();
    $where = array();
    $indentviewData = $this->IndentModel->getindentData('', 0, 0, 0, 0, $id);
    $data['indentviewData'] = $indentviewData[0];
    $data['plant_data'] = $this->IndentModel->getSiteNameByIndentId($id);
    $groupedIndentData = $this->IndentModel->getIndentViewData(array('ti.indent_id' => $id), 1);

    $indentData = [];
    foreach ($groupedIndentData as $key => $record) {
      $indentData = $this->IndentModel->getIndentViewData(array('ti.indent_id' => $id, 'ti.plant_id' => $record['plant_id']), 0);
      $groupedIndentData[$key]['indent_details'] =  $indentData;
    }

    $data['indent_specific_data'] = $groupedIndentData;
    $data['offset'] = 0;

    $htmlContent = $this->load->view(ADMIN . 'indent/indentprint_report1', $data, true);
    // print_r($htmlContent);die;

    $this->pdf->AddPage();
    $pdf = $this->pdf;
    $this->pdf->SetPrintHeader(false);
    $this->pdf->SetPrintFooter(false);
    $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $this->pdf->SetMargins(5, 5, 5);

    $this->pdf->SetFont('helvetica', '', 8);
    $this->pdf->writeHTML($htmlContent, true, false, true, false, '');
    $this->pdf->Output('indent_report.pdf', 'I'); // 'I' for inline display
  }
  public function IndentLock()
  {
    $post = $this->input->post();
    $indent_id = $post['indent_id'];
    $is_lock = $post['is_lock'];

    if ($indent_id) {

      $this->CommonModel->iudAction('tbl_indent', array('updated_by' => userId(), 'updated_at' => date('Y-m-d H:i:s'), 'is_lock' => $is_lock), 'update', array('id' => $indent_id));


      $response['result'] = true;
      $response['reasons'] = "Indent Lock Successfully";
    } else {
      $response['result'] = false;
      $response['reasons'] = "Something Went Wrong";
    }


    echo json_encode($response);
    die;
  }
}
