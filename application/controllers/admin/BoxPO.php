<?php

use Mpdf\Mpdf;

error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 *
 */
class BoxPO extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'BoxPOModel');
        $this->load->library('phpmailer_lib');
        isLogin();
    }
    public function index()
    {
        $data['title'] = 'Box-Po List';
        $data['active'] = 'Vendor';
        $data['company_master'] = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1));
        $this->load->view(ADMIN . 'boxpo/list_boxpo', $data);
    }

    public function listVendorName()
    {
        $search = $this->input->get('searchTerm');

        $this->db->select('id, account_name');
        if (!empty($search)) {
            $this->db->like('account_name', $search);
        }

        $vendors = $this->db->get('tbl_vendor_master')->result();

        $data = [];
        foreach ($vendors as $v) {
            $data[] = [
                'id'   => $v->id,          
                'text' => $v->account_name
            ];
        }

        echo json_encode($data);
    }

    public function listSite()
    {
        $search = $this->input->get('searchTerm');

        $this->db->select('id, site_name');
        if (!empty($search)) {
            $this->db->like('site_name', $search);
        }

        $vendors = $this->db->get('tbl_site')->result();

        $data = [];
        foreach ($vendors as $v) {
            $data[] = [
                'id'   => $v->id,         
                'text' => $v->site_name
            ];
        }

        echo json_encode($data);
    }

    public function listBoxPo()
    {

        $rows   = [];

        $data   = $_POST;

        $page   = isset($data['draw']) ? intval($data['draw']) : 1;
        $limit  = isset($data['length']) ? intval($data['length']) : 10;
        $offset = isset($data['start']) ? intval($data['start']) : 0;

        $search = $data['search']['value'] ?? '';
        $sortDir = ($data['order'][0]['dir'] ?? 'DESC') === 'asc' ? 'ASC' : 'DESC';
        $sortCol = 'p.id';
        $sortColIndex = $data['order'][0]['column'] ?? 0;

        $where = [];

        if (!empty($data['vendor_id'])) {
            $where['p.vendor_id'] = $data['vendor_id'];
        }

        if (!empty($data['company_id']) && $data['company_id'] !== 'all') {
            $where['p.company_id'] = $data['company_id'];
        }

        if (!empty($data['site_id']) && $data['site_id'] !== 'all') {
            $where['p.site_id'] = $data['site_id'];
        }

        if (empty($data['company_id']) && empty($data['site_id'])) {
            $where['p.company_id'] = userId('company_id');
            $where['p.site_id']    = userId('site_id');
        }

        $on_date   = $data['on_date'] ?? '';
        $from_date = $data['from_date'] ?? '';
        $to_date   = $data['to_date'] ?? '';

        if ($on_date == 1) {
            $where['DATE(p.boxpo_date)'] = date('Y-m-d');
        } elseif ($on_date == 2) {
            $where['DATE(p.boxpo_date)'] = date('Y-m-d', strtotime('-1 day'));
        } elseif ($on_date == 3) {
            $from = date('Y-m-d', strtotime('last monday'));
            $to   = date('Y-m-d', strtotime('next sunday'));
            $where['DATE(p.boxpo_date) BETWEEN "' . $from . '" AND "' . $to . '"'] = NULL;
        } elseif ($on_date == 4) {
            $where['MONTH(p.boxpo_date)'] = date('m');
            $where['YEAR(p.boxpo_date)']  = date('Y');
        } elseif ($on_date == 5) {
            $where['YEAR(p.boxpo_date)'] = date('Y');
        } elseif ($on_date == 6 && $from_date && $to_date) {
            $where['DATE(p.boxpo_date) BETWEEN "' . $from_date . '" AND "' . $to_date . '"'] = NULL;
        }

        $count = count(
            $this->BoxPOModel->getBoxPOData($search, 0, 0, 0, 0, $where)
        );

        if ($count > 0) {
            $result = $this->BoxPOModel->getBoxPOData(
                $search,
                $sortColIndex,
                $sortDir,
                $limit,
                $offset,
                $where
            );

            foreach ($result as $key => $value) {

                $row = [];

                array_push($row, $offset + ($key + 1));
                array_push(
                    $row,
                    '<a class="text-primary" title="View in Details" href="' . base_url('admin/BoxPO/ViewBoxPO/' . $value['id']) . '" title="View">'
                        . $value['boxpo_order_no'] .
                        '</a>'
                );

                array_push($row, dmyDate($value['boxpo_date']));
                array_push($row, $value['vendor_name']);
                array_push($row, $value['company_name']);
                array_push($row, $value['site_name']);
                // array_push($row, number_format($value['total_sq_inch'], 0));
                // array_push($row, number_format($value['cu_ft'], 2));
                // array_push($row, number_format($value['total_cost'], 2));

                // $status = ($value['boxpo_status'] == 1)
                //     ? '<span class="badge badge-success">Approved</span>'
                //     : '<span class="badge badge-warning">Pending</span>';
                // array_push($row, $status);

                $pdfBtn  = '';
                $pdfFile = '';
                $baseDir = FCPATH . 'uploads/boxpo/';


                if (!empty($value['amendment_main_boxpo_id']) && $value['amendment_main_boxpo_id'] > 0) {

                    $pdfFile = 'BOX_PO_AMENDMENT_' .
                        $value['amendment_main_boxpo_id'] . '_' .
                        $value['amendment_sequence'] . '.pdf';
                } elseif (file_exists($baseDir . 'BOX_PO_COPY_' . $value['id'] . '.pdf')) {

                    $pdfFile = 'BOX_PO_COPY_' . $value['id'] . '.pdf';
                } else {

                    $pdfFile = 'BOX_PO_' . $value['id'] . '.pdf';
                }

                if (file_exists($baseDir . $pdfFile)) {
                    $pdfBtn = '<a href="' . base_url('uploads/boxpo/' . $pdfFile) . '" 
                target="_blank"
                class="btn btn-sm btn-primary"
                title="PDF">
                <i class="fa fa-file-pdf"></i>
              </a>';
                }

                $row[] = $pdfBtn;



                //  <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '" 
                //        class="btn btn-sm btn-primary" title="View">
                //        <i class="fa fa-eye"></i>
                //     </a>

                $showAmendButton = empty($value['amendment_main_boxpo_id'])
                    || $value['amendment_main_boxpo_id'] == 0;

                $action = '<div class="btn-group">

                <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '" 
                class="btn btn-primary btn-sm" title="Edit">
                <i class="fa fa-edit"></i>
                </a>


                <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '/copy' . '" 
                class="btn btn-primary btn-sm"
                onclick="return confirm(\'Are you sure you want to copy this Box PO?\')"
                title="Copy">
                <i class="fa fa-copy"></i>
                </a>

                
                <a href="' . base_url('admin/BoxPO/DeleteBoxPO/' . $value['id']) . '" 
                class="btn btn-primary btn-sm"
                onclick="return confirm(\'Are you sure you want to delete this Box PO?\')"
                title="Delete">
                <i class="fa fa-trash"></i>
                </a>
';

                if ($showAmendButton) {
                    $action .= '
                <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '/amend' . '" 
                class="btn btn-primary btn-sm"
                onclick="return confirm(\'Are you sure you want to amend this Box PO?\')"
                title="Amend">
                Amendment
                </a>';
                }

                $action .= '</div>';

                $row[] = $action;


                array_push($row, $action);
                $rows[] = $row;
            }
        }

        echo json_encode([
            'draw'            => $page,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'            => $rows
        ]);
    }
    public function listViewBoxPo()
    {


        $rows   = [];

        $data   = $_POST;

        $page   = isset($data['draw']) ? intval($data['draw']) : 1;
        $limit  = isset($data['length']) ? intval($data['length']) : 10;
        $offset = isset($data['start']) ? intval($data['start']) : 0;

        $search = $data['search']['value'] ?? '';
        $sortDir = ($data['order'][0]['dir'] ?? 'DESC') === 'asc' ? 'ASC' : 'DESC';
        $sortCol = 'p.id';


        $where = [];

        if (!empty($data['vendor_id'])) {
            $where['p.vendor_id'] = $data['vendor_id'];
        }

        if (!empty($data['company_id']) && $data['company_id'] !== 'all') {
            $where['p.company_id'] = $data['company_id'];
        }

        if (!empty($data['site_id']) && $data['site_id'] !== 'all') {
            $where['p.site_id'] = $data['site_id'];
        }

        if (empty($data['company_id']) && empty($data['site_id'])) {
            $where['p.company_id'] = userId('company_id');
            $where['p.site_id']    = userId('site_id');
        }

        $on_date   = $data['on_date'] ?? '';
        $from_date = $data['from_date'] ?? '';
        $to_date   = $data['to_date'] ?? '';

        if ($on_date == 1) {
            $where['DATE(p.boxpo_date)'] = date('Y-m-d');
        } elseif ($on_date == 2) {
            $where['DATE(p.boxpo_date)'] = date('Y-m-d', strtotime('-1 day'));
        } elseif ($on_date == 3) {
            $where['YEARWEEK(p.boxpo_date,1)=YEARWEEK(CURDATE(),1)'] = null;
        } elseif ($on_date == 4) {
            $where['MONTH(p.boxpo_date)'] = date('m');
            $where['YEAR(p.boxpo_date)']  = date('Y');
        } elseif ($on_date == 5) {
            $where['YEAR(p.boxpo_date)'] = date('Y');
        } elseif ($on_date == 6 && $from_date && $to_date) {
            $where['DATE(p.boxpo_date) BETWEEN "' . $from_date . '" AND "' . $to_date . '"'] = null;
        }

        $count = count(
            $this->BoxPOModel->getBoxPOData($search, 0, 0, 0, 0, $where)
        );

        if ($count > 0) {
            $result = $this->BoxPOModel->getBoxPOData(
                $search,
                $sortCol,
                $sortDir,
                $limit,
                $offset,
                $where
            );

            foreach ($result as $key => $value) {

                $row = [];

                array_push($row, $offset + ($key + 1));
                array_push(
                    $row,
                    '<a href=" javascript:void(0);" class="btn-view-po" data-id="' . $value['id'] . '" title="View">'
                        . $value['boxpo_order_no'] .
                        '</a>'
                );

                array_push($row, dmyDate($value['boxpo_date']));
                array_push($row, $value['vendor_name']);
                array_push($row, $value['company_name']);
                array_push($row, $value['site_name']);
                // array_push($row, number_format($value['total_sq_inch'], 0));
                // array_push($row, number_format($value['cu_ft'], 2));
                // array_push($row, number_format($value['total_cost'], 2));

                // $status = ($value['boxpo_status'] == 1)
                //     ? '<span class="badge badge-success">Approved</span>'
                //     : '<span class="badge badge-warning">Pending</span>';
                // array_push($row, $status);

                $pdfBtn  = '';
                $pdfFile = '';
                $baseDir = FCPATH . 'uploads/boxpo/';


                if (!empty($value['amendment_main_boxpo_id']) && $value['amendment_main_boxpo_id'] > 0) {

                    $pdfFile = 'BOX_PO_AMENDMENT_' .
                        $value['amendment_main_boxpo_id'] . '_' .
                        $value['amendment_sequence'] . '.pdf';
                } elseif (file_exists($baseDir . 'BOX_PO_COPY_' . $value['id'] . '.pdf')) {

                    $pdfFile = 'BOX_PO_COPY_' . $value['id'] . '.pdf';
                } else {

                    $pdfFile = 'BOX_PO_' . $value['id'] . '.pdf';
                }

                if (file_exists($baseDir . $pdfFile)) {
                    $pdfBtn = '<a href="' . base_url('uploads/boxpo/' . $pdfFile) . '" 
                target="_blank"
                class="btn btn-sm btn-primary"
                title="PDF">
                <i class="fa fa-file-pdf"></i>
              </a>';
                }

                $row[] = $pdfBtn;



                //  <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '" 
                //        class="btn btn-sm btn-primary" title="View">
                //        <i class="fa fa-eye"></i>
                //     </a>

                $showAmendButton = empty($value['amendment_main_boxpo_id'])
                    || $value['amendment_main_boxpo_id'] == 0;

                $action = '<div class="btn-group">

                <a href="javascript:void(0)" 
                        class="btn btn-sm btn-primary btn-view-po" data-id="' . $value['id'] . '" title="View">
                        <i class="fa fa-eye"></i>
                    </a>

                <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '" 
                class="btn btn-primary btn-sm" title="Edit">
                <i class="fa fa-edit"></i>
                </a>


                <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '/copy' . '" 
                class="btn btn-primary btn-sm"
                onclick="return confirm(\'Are you sure you want to copy this Box PO?\')"
                title="Copy">
                <i class="fa fa-copy"></i>
                </a>

                
                <a href="' . base_url('admin/BoxPO/DeleteBoxPO/' . $value['id']) . '" 
                class="btn btn-primary btn-sm"
                onclick="return confirm(\'Are you sure you want to delete this Box PO?\')"
                title="Delete">
                <i class="fa fa-trash"></i>
                </a>
';

                if ($showAmendButton) {
                    $action .= '
                <a href="' . base_url('admin/BoxPO/add/' . $value['id']) . '/amend' . '" 
                class="btn btn-primary btn-sm"
                onclick="return confirm(\'Are you sure you want to amend this Box PO?\')"
                title="Amend">
                Amendment
                </a>';
                }

                $action .= '</div>';

                $row[] = $action;


                array_push($row, $action);
                $rows[] = $row;
            }
        }

        echo json_encode([
            'draw'            => $page,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'            => $rows
        ]);
    }

    public function add($id = '', $type = '')
    {
        $data['title'] = 'Box PO';
        $number = $this->BoxPOModel->getBoxPONumber();
        $data['boxpo_order_no']        = $number['boxpo_order_no'];
        $data['boxpo_order_sequence'] = $number['boxpo_order_sequence'];
        $data['type'] = 1;

        // EDIT
        if (!empty($id) && $type !== 'copy' && $type !== 'amend') {

            $data['po_info'] = $this->db
                ->from('tbl_box_po')
                ->where('id', $id)
                ->group_start()
                ->where('deleted_by IS NULL', null, false)
                ->or_where('deleted_by', 0)
                ->group_end()
                ->get()
                ->row_array();

            if (empty($data['po_info'])) {
                show_error('Box PO not found', 404);
            }

            $data['dimensions'] = $this->db
                ->from('tbl_box_po_dimensions')
                ->where('box_po_id', $id)
                ->group_start()
                ->where('deleted_by IS NULL', null, false)
                ->or_where('deleted_by', 0)
                ->group_end()
                ->get()
                ->result_array();

            $data['boxpo_order_no']        = $data['po_info']['boxpo_order_no'];
            $data['boxpo_order_sequence'] = $data['po_info']['boxpo_order_sequence'];

            $data['id']   = $id;
            $data['type'] = 2; // edit

            // echo '<pre>';
            // print_r($data);
            // die();
        }

        // COPY
        if (!empty($id) && $type === 'copy') {

            $data['po_info'] = $this->db
                ->from('tbl_box_po')
                ->where('id', $id)
                ->group_start()
                ->where('deleted_by IS NULL', null, false)
                ->or_where('deleted_by', 0)
                ->group_end()
                ->get()
                ->row_array();

            if (empty($data['po_info'])) {
                show_error('Box PO not found', 404);
            }

            $data['dimensions'] = $this->db
                ->from('tbl_box_po_dimensions')
                ->where('box_po_id', $id)
                ->group_start()
                ->where('deleted_by IS NULL', null, false)
                ->or_where('deleted_by', 0)
                ->group_end()
                ->get()
                ->result_array();

            unset($data['po_info']['id']); // force INSERT
            $data['type'] = 3; // copy
        }

        if (!empty($id) && $type === 'amend') {

            $base_po = $this->BoxPOModel->getBaseBoxPO($id);

            if (empty($base_po)) {
                show_error('Base Box PO not found', 404);
            }

            $amendment_seq = $this->BoxPOModel
                ->getNextAmendmentSequence($base_po['id']);

            // 3️⃣ Build amended order number
            $data['boxpo_order_no'] = $this->BoxPOModel
                ->buildAmendmentOrderNo(
                    $base_po['boxpo_order_no'],
                    $amendment_seq
                );

            // $data['boxpo_order_sequence'] = $base_po['boxpo_order_sequence'];
            $newNumber = $this->BoxPOModel->getBoxPONumber();

            $data['boxpo_order_sequence'] = $newNumber['boxpo_order_sequence'];

            $data['po_info'] = $this->db
                ->from('tbl_box_po')
                ->where('id', $id)
                ->get()
                ->row_array();

            $data['dimensions'] = $this->db
                ->from('tbl_box_po_dimensions')
                ->where('box_po_id', $id)
                ->group_start()
                ->where('deleted_by IS NULL', null, false)
                ->or_where('deleted_by', 0)
                ->group_end()
                ->get()
                ->result_array();

            unset($data['po_info']['id']);

            $data['po_info']['amendment_main_boxpo_id'] = $base_po['id'];
            $data['po_info']['amendment_sequence']      = $amendment_seq;

            $data['type'] = 4; // amendment
        }


        $data['vendors'] = $this->CommonModel->getData('tbl_vendor_master');

        $this->load->view(ADMIN . 'boxpo/add_boxpo', $data);
    }

    public function add_boxpo()
    {
        $isAjax = $this->input->is_ajax_request();
        $post   = $this->input->post();
        // echo '<pre>'; print_r($post); die();
        $type = (int) ($post['type'] ?? 1);

        if (!empty($post['amendment_main_boxpo_id'])) {
            $type = 4;
            unset($post['id']);
        }
        $poData = [
            'boxpo_order_no'        => $post['boxpo_order_no'] ?? null,
            'boxpo_order_sequence' => $post['boxpo_order_sequence'] ?? null,
            'boxpo_date'           => !empty($post['boxpo_date'])
                ? date('Y-m-d', strtotime(str_replace('/', '-', $post['boxpo_date'])))
                : null,

            'line_before_address' => $post['line_before_address'] ?? null,
            'vendor_id'           => $post['vendor_id'] ?? null,
            'address'             => $post['cost_project_address'] ?? null,

            'plank_type'      => $post['plank_type'] ?? null,
            'thickness'       => $post['thickness'] ?? 0,
            'main_length'     => (float) ($post['main_length'] ?? 0),
            'main_width'      => (float) ($post['main_width'] ?? 0),
            'main_height'     => (float) ($post['main_height'] ?? 0),
            'main_thickness'  => (float) ($post['main_thickness'] ?? 0),

            'total_sq_inch'   => (float) ($post['total_sq_inch'] ?? 0),
            'wastage_sq_inch' => (float) ($post['wastage_sq_inch'] ?? 0),
            'net_sq_inch'     => (float) ($post['net_sq_inch'] ?? 0),
            'cu_ft'           => (float) ($post['cu_ft'] ?? 0),
            'rate'            => (float) ($post['rate'] ?? 0),
            'total_cost'      => (float) ($post['total_cost'] ?? 0),

            'company_id'        => userId('company_id'),
            'site_id'           => userId('site_id'),
            'financial_year_id' => userId('financial_year_id'),
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => userId(),
            'updated_at'        => date('Y-m-d H:i:s'),
            'updated_by'        => userId()
        ];

        if ($type === 4) {

            $newNumber = $this->BoxPOModel->getBoxPONumber();

            $poData['boxpo_order_sequence']     = $newNumber['boxpo_order_sequence'];
            $poData['amendment_main_boxpo_id']  = (int) $post['amendment_main_boxpo_id'];
            $poData['amendment_sequence']       = (int) $post['amendment_sequence'];
        }




        if (!empty($post['boxpo_valid_from_to_date'])) {
            [$from, $to] = array_map('trim', explode(' - ', $post['boxpo_valid_from_to_date']));
            $fromDate = DateTime::createFromFormat('d/m/Y', $from);
            $toDate   = DateTime::createFromFormat('d/m/Y', $to);

            if ($fromDate && $toDate) {
                $poData['boxpo_valid_from'] = $fromDate->format('Y-m-d');
                $poData['boxpo_valid_to']   = $toDate->format('Y-m-d');
            }
        }

        if (!empty($post['id']) && $type !== 4) {

            $this->CommonModel->iudAction('tbl_box_po', $poData, 'update', ['id' => $post['id']]);
            $boxPoId = $post['id'];
            $this->CommonModel->iudAction(
                'tbl_box_po_dimensions',
                [
                    'updated_by' => userId(),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => userId(),
                    'deleted_at' => date('Y-m-d H:i:s')
                ],
                'update',
                ['box_po_id' => $boxPoId]
            );
        } else {

            // INSERT
            $poData['created_at'] = date('Y-m-d H:i:s');
            $poData['created_by'] = userId();

            $boxPoId = $this->CommonModel->iudAction(
                'tbl_box_po',
                $poData,
                'insert'
            );
        }

        if (!empty($post['dimension']['section'])) {

            $batch = [];

            foreach ($post['dimension']['section'] as $i => $section) {

                $length    = (float) ($post['dimension']['length'][$i] ?? 0);
                $width     = (float) ($post['dimension']['width'][$i] ?? 0);
                $thickness = (float) ($post['dimension']['thickness'][$i] ?? 0);
                $qty       = (float) ($post['dimension']['qty'][$i] ?? 0);
                $sq        = (float) ($post['dimension']['sq_inch'][$i] ?? 0);

                if (
                    empty($section) &&
                    $length == 0 &&
                    $width == 0 &&
                    $thickness == 0 &&
                    $qty == 0
                ) {
                    continue;
                }

                $batch[] = [
                    'box_po_id' => $boxPoId,
                    'section'   => $section,
                    'type'      => $post['dimension']['type'][$i] ?? null,
                    'length'    => $length,
                    'width'     => $width,
                    'thickness' => $thickness,
                    'qty'       => $qty,
                    'sq_inch'   => $sq,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }

            if (!empty($batch)) {
                $this->CommonModel->iudAction(
                    'tbl_box_po_dimensions',
                    $batch,
                    'batch_insert'
                );
            }
        }

        $po = $this->BoxPOModel->getValidBoxPO($boxPoId);

        $po_site = $this->CommonModel->getData(
            'tbl_site',
            ['id' => $po['site_id']],
            '',
            '',
            'row_array'
        );

        $vendor = $this->BoxPOModel->getBoxPoVendorData($po['vendor_id']);


        $dimensions = $this->BoxPOModel->getValidDimensions($po['id']);


        $company_master_data = $this->BoxPOModel->getCompany($po['company_id']);


        //    echo '<pre>';
        //    print_r($po);
        //    echo '</pre>';

        // $this->load->view(
        //     'admin/boxpo/pdf/boxpo_pdf',
        //     compact('po', 'vendor', 'dimensions', 'company_master_data', 'po_site'),
        // );
        // return; 

        $footerHtml = '
                <table width="100%" style="border-left:1px solid #000;border-right:1px solid #000; font-size:9px; font-weight:bold;">
                    <tr>
                        <td align="center">
                            WORKS: ' . ($po_site['site_address'] ?? '') . '
                        </td>
                    </tr>
                </table>
                ';

        $html = $this->load->view(
            'admin/boxpo/pdf/boxpo_pdf',
            compact('po', 'vendor', 'dimensions', 'company_master_data', 'po_site'),
            true
        );

        $mpdf = new \Mpdf\Mpdf([
            'format'        => 'A4',
            'margin_top'    => 12,
            'margin_bottom' => 15,
            'margin_left'   => 8,
            'margin_right'  => 8
        ]);



        $mpdf->SetTitle('BOX PO');
        $mpdf->SetAuthor('ERP');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->showImageErrors = true;

        $mpdf->SetHTMLFooter($footerHtml);

        $mpdf->WriteHTML($html);


        // Save PDF
        $dir = FCPATH . 'uploads/boxpo/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // ---------------- PDF FILE NAME LOGIC ----------------

        if (!empty($po['amendment_main_boxpo_id'])) {

            $baseId  = (int) $po['amendment_main_boxpo_id'];
            $amendNo = (int) ($po['amendment_sequence'] ?? 1);

            $fileName = 'BOX_PO_AMENDMENT_' . $baseId . '_' . $amendNo . '.pdf';

            // 2️⃣ Copy
        } elseif ($type === 3) {

            $fileName = 'BOX_PO_COPY_' . $boxPoId . '.pdf';

            // 3️⃣ Normal PO (add / edit)
        } else {

            $fileName = 'BOX_PO_' . $boxPoId . '.pdf';
        }

        $filePath = $dir . $fileName;

        // Save PDF
        $mpdf->Output($filePath, 'F');

        // Ajax / normal flow
        if ($isAjax) {
            echo json_encode([
                'status'  => true,
                'message' => 'Box PO saved successfully',
                'pdf_url' => base_url('uploads/boxpo/' . $fileName)
            ]);
            exit;
        }

        redirect(base_url('uploads/boxpo/' . $fileName));
    }

    public function ViewBoxPO($id)
    {
        $box_po = $this->CommonModel->getData('tbl_box_po', array('id' => $id));
        $box_po_dimensions = $this->CommonModel->getData('tbl_box_po_dimensions', array('box_po_id' => $id));
        // echo '<pre>'; print_r($box_po); echo '</pre>';
        // echo '<pre>'; print_r($box_po_dimensions); echo '</pre>';
        $this->load->view('admin/boxpo/view_boxpo', compact('box_po', 'box_po_dimensions'));
    }

    public function ajaxViewBoxPO()
    {
        $po_id = $this->input->post('po_id');

        if (!$po_id) {
            echo '<div class="alert alert-danger">Invalid PO</div>';
            return;
        }

        $po = $this->BoxPOModel->getValidBoxPO($po_id);

        if (empty($po)) {
            json_encode(['status' => false, 'message' => 'Invalid PO']);
        }

        $vendor    = $this->BoxPOModel->getBoxPoVendorData($po['vendor_id']);
        $dimensions = $this->BoxPOModel->getValidDimensions($po_id);
        $company   = $this->BoxPOModel->getCompany($po['company_id']);
        $po_site   = $this->BoxPOModel->getSite($po['site_id']);

        $this->load->view(
            ADMIN . 'boxpo/boxpo_details_view',
            [
                'po'                   => $po,
                'vendor'               => $vendor,
                'dimensions'           => $dimensions,
                'company_master_data'  => $company,
                'po_site'              => $po_site
            ]
        );
    }

    public function DeleteBoxPO($id)
    {
        if ($id) {
            $this->CommonModel->iudAction(
                'tbl_box_po_dimensions',
                [
                    'updated_by' => userId(),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => userId(),
                    'deleted_at' => date('Y-m-d H:i:s')
                ],
                'update',
                ['box_po_id' => $id]
            );

            $this->CommonModel->iudAction(
                'tbl_box_po',
                [
                    'updated_by' => userId(),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => userId(),
                    'deleted_at' => date('Y-m-d H:i:s')
                ],
                'update',
                ['id' => $id]
            );
            redirect(base_url(ADMIN . 'boxpo'));
        }
    }

    public function listItemGroup()
    {
        $search = '';
        $where = array();
        $json = [];
        $search = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

        if (isset($search)) {
            $search = $search;
        } else {
            $search = '';
        }

        $cites = $this->BoxPOModel->getItemGroupList($search, $where);

        $json[] = ['id' => "all", 'text' => "all"];

        foreach ($cites as $key => $value) {
            if (isset($value['parent_group_name'])) {
                $json[] = ['id' => $value['id'], 'text' => $value['item_group_name'] . " (" . $value['parent_group_name'] . ")"];
            } else {
                $json[] = ['id' => $value['id'], 'text' => $value['item_group_name']];
            }
        }
        echo json_encode($json);
    }

   /* public function getItemData()
    {
        $post = $this->input->post();
        $where = array();
        if (isset($post['item_group_id']) && !empty($post['item_group_id'])) {
            if ($post['item_group_id'] != 'all') {
                $where['i.item_group'] = $post['item_group_id'];
            }
        } else {
            $where = array();
        }

        $items = $this->BoxPOModel->getItemList($where);
        // echo $this->db->last_query();
        $json = array();
        foreach ($items as $key => $value) {

            $json[] = [
                'id' => $value['id'],
                'text' => $value['short_name'],
                'item_code' => $value['item_code'],
                'data-short_name' => $value['short_name'],
                'hsn_code' => $value['hsn_code'],
                'rate' => $value['rate']
            ];
        }

        $response['result'] = true;
        $response['data'] = $json;
        echo json_encode($response);
    }
    public function getItemUnitsData()
    {
        $post = $this->input->post();
        if (isset($post['item_id'])) {
            $where['i.id'] = $post['item_id'];
            $where1['i.item_id'] = $post['item_id'];
            $where1['u.is_deleted'] = 0;
        } else {
            $where = array();
            $where1 = array();
        }
        $items_info = $this->BoxPOModel->getItemList($where);
        $items_units = $this->BoxPOModel->getItemUnitList($where1);
        if (isset($post['item_id'])) {
            $items_batchs_no = $this->BoxPOModel->getItemUnitBatchList(array('i.item_id' => $post['item_id']));
        } else {
            $items_batchs_no = array();
        }

        if (isset($post['vendor_id'])) {
            $is_check_ven_item_rate = $this->CommonModel->getData('tbl_vendor_item_rate', array('vendor_id' => $post['vendor_id'], 'item_id' => $post['item_id']), '', '', 'num_rows');

            if ($is_check_ven_item_rate > 0) {
                $items_info = $this->BoxPOModel->getVendorItemRateList($where, $post['vendor_id']);
            } else {
                $items_info = $this->BoxPOModel->getItemList($where);
            }
        } else {
            $items_info = $this->BoxPOModel->getItemList($where);
        }


        $items_units = $this->BoxPOModel->getItemUnitList($where1);
        // print_r($items_units);
        // die;
        foreach ($items_units as $key => $value) {
            $amt = getQuickInventoryAmount($value['item_id'], $value['item_unit_id'], userId('company_id'), userId('site_id'), userId('financial_year_id'));
            $items_units[$key]['qty'] = $amt;
        }
        foreach ($items_batchs_no as $key => $value) {
            $amt = getQuickInventoryAmount($value['item_id'], $value['item_unit_id'], userId('company_id'), userId('site_id'), userId('financial_year_id'), $value['batch_no'], $value['expired_date'], 0);
            $items_batchs_no[$key]['qty'] = $amt;
        }

        // print_r($cites);die;
        $json = array();
        if (!empty($items_info)) {
            $response['result'] = true;
            $response['data_item'] = $items_info[0];
            $response['data'] = $items_units;
            $response['batch_info'] = $items_batchs_no;
            echo json_encode($response);
        } else {
            $response['result'] = true;
            $response['data_item'] = array();
            $response['data'] = $items_units;
            $response['batch_info'] = $items_batchs_no;
            echo json_encode($response);
        }
    }
    public function getUnitBatchWiseData()
    {
        $post = $this->input->post();
        if (isset($post['item_id'])) {
            $where['i.id'] = $post['item_id'];
            $where1['i.item_id'] = $post['item_id'];
            $where1['i.item_unit_id'] = $post['item_unit_id'];
            $where1['u.is_deleted'] = 0;
        } else {
            $where = array();
            $where1 = array();
        }


        $items_batchs_no = $this->BoxPOModel->getItemUnitBatchList(array('i.is_reserve_stock' => 0, 'i.item_id' => $post['item_id'], 'i.item_unit_id' => $post['item_unit_id'], 'i.company_id' => userId('company_id'), 'i.site_id' => userId('site_id'), 'i.financial_year_id' => userId('financial_year_id')));
        // echo $this->db->last_query();
        foreach ($items_batchs_no as $key => $value) {
            $amt = getQuickInventoryAmount($value['item_id'], $value['item_unit_id'], userId('company_id'), userId('site_id'), userId('financial_year_id'), $value['batch_no'], $value['expired_date'], 0);
            $items_batchs_no[$key]['qty'] = $amt;
            $items_batchs_no[$key]['qty_query'] = $this->db->last_query();
            $rate = $this->BoxPOModel->getItemRateBatchList(array('gi.batch_no' => $value['batch_no'], 'expired_date' => $value['expired_date'], 'item_id' => $value['item_id'], 'item_unit_id' => $value['item_unit_id'], 'grn.company_id' => userId('company_id'), 'grn.site_id' => userId('site_id')));
            $items_batchs_no[$key]['rate_query_1'] = $this->db->last_query();
            if (!empty($rate) && isset($rate['item_rate']) && $rate['item_rate'] != 0.00) {
                $items_batchs_no[$key]['rate'] = isset($rate['item_rate']) ? $rate['item_rate'] : 0;
                $items_batchs_no[$key]['item_rate_type'] = isset($rate['item_rate_type']) ? $rate['item_rate_type'] : 0;
                $items_batchs_no[$key]['item_weight'] = isset($rate['item_weight']) ? $rate['item_weight'] : 0;
                $items_batchs_no[$key]['weight_per_qty'] = isset($rate['weight_per_qty']) ? $rate['weight_per_qty'] : 0;
                $items_batchs_no[$key]['weight_per_rate'] = isset($rate['weight_per_rate']) ? $rate['weight_per_rate'] : 0;
                $items_batchs_no[$key]['rate_query'] = $this->db->last_query();
            } else {
                //get rate from OS
                // $rate_opening= $this->BoxPOModel->getItemRateBatchListFromOS(array('os.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'opening_unit_id'=>$value['item_unit_id'],'location_id'=>userId('site_id'),'financial_year_id'=>userId('financial_year_id')));
                $rate_opening = $this->BoxPOModel->getItemRateBatchListFromOS(array('os.batch_no' => $value['batch_no'], 'expired_date' => $value['expired_date'], 'item_id' => $value['item_id'], 'opening_unit_id' => $value['item_unit_id'], 'location_id' => userId('site_id')));
                // echo $this->db->last_query();
                if (!empty($rate_opening) && isset($rate_opening['unit_rate']) && $rate_opening['unit_rate'] != 0.00) {
                    $items_batchs_no[$key]['rate'] = isset($rate_opening['unit_rate']) ? $rate_opening['unit_rate'] : 0;
                    $items_batchs_no[$key]['item_rate_type'] = isset($rate_opening['item_rate_type']) ? $rate_opening['item_rate_type'] : 0;
                    $items_batchs_no[$key]['item_weight'] = isset($rate_opening['opening_weight']) ? $rate_opening['opening_weight'] : 0;
                    $items_batchs_no[$key]['weight_per_qty'] = isset($rate_opening['weight_per_qty']) ? $rate_opening['weight_per_qty'] : 0;
                    $items_batchs_no[$key]['weight_per_rate'] = isset($rate_opening['weight_per_rate']) ? $rate_opening['weight_per_rate'] : 0;
                    $items_batchs_no[$key]['rate_query'] = $this->db->last_query();
                } else {
                    //transfered 
                    //   $rate_opening= $this->BoxPOModel->getItemRateBatchListFromRecevied(array('os.batch_no'=>$value['batch_no'],'expired_date'=>$value['expired_date'],'item_id'=>$value['item_id'],'received_qty_unit'=>$value['item_unit_id'],'received_location_site_id'=>userId('site_id'),'financial_year_id'=>userId('financial_year_id')));
                    $rate_opening = $this->BoxPOModel->getItemRateBatchListFromRecevied(array('os.batch_no' => $value['batch_no'], 'expired_date' => $value['expired_date'], 'item_id' => $value['item_id'], 'received_qty_unit' => $value['item_unit_id'], 'received_location_site_id' => userId('site_id')));
                    //   echo $this->db->last_query();die;
                    if (!empty($rate_opening) && isset($rate_opening['rate']) && $rate_opening['rate'] != 0.00) {
                        $items_batchs_no[$key]['rate'] = isset($rate_opening['rate']) ? $rate_opening['rate'] : 0;
                        $items_batchs_no[$key]['item_rate_type'] = isset($rate_opening['item_rate_type']) ? $rate_opening['item_rate_type'] : 0;
                        $items_batchs_no[$key]['item_weight'] = isset($rate_opening['weight']) ? $rate_opening['weight'] : 0;
                        $items_batchs_no[$key]['weight_per_qty'] = isset($rate_opening['weight_per_qty']) ? $rate_opening['weight_per_qty'] : 0;
                        $items_batchs_no[$key]['weight_per_rate'] = isset($rate_opening['weight_per_rate']) ? $rate_opening['weight_per_rate'] : 0;
                        $items_batchs_no[$key]['rate_query'] = $this->db->last_query();
                    } else {
                        //transfered 
                        $items_batchs_no[$key]['rate_query'] = $this->db->last_query();
                        $items_batchs_no[$key]['rate'] = 0;
                    }
                }
            }
        }
        // print_r($cites);die;
        $json = array();
        $response['result'] = true;
        $response['batch_info'] = $items_batchs_no;
        $response['batch_info11'] = $items_batchs_no;
        echo json_encode($response);
    }





    public function poDeleteItems()
    {
        $post = $this->input->post();
        $po_id = $post['box_po_id'];
        $po_item_id = $post['po_item_id'];
        if ($po_id && $po_item_id) {


            $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'boxpo_order_no', '', 'row_array');

            $this->CommonModel->iudAction('tbl_po_items_details', array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $po_item_id));


            $description = "PO Item deleted -" . $po_data['boxpo_order_no'] . " by " . userId('name');
            $json_data_login = encode_arr($post);
            //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

            ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor
            //sub_ref_type:1 tbl_user
            $data_action_log_array = array(userId(), userId('role_id'), userId('common_financial_year'), userId('company_id'), userId('site_id'), 'update', $description, 1, $po_id, '', '', date('Y-m-d H:i:s'), $json_data_login);;
            updateInActionLogFile($data_action_log_array);


            $response['result'] = true;
            $response['reasons'] = "PO Items Deleted";
        } else {
            $response['result'] = false;
            $response['reasons'] = "Something Went Wrong";
        }


        echo json_encode($response);
        die;
    }

    public function poDelete($po_id)
    {

        if ($po_id) {

            $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'boxpo_order_no', '', 'row_array');

            $this->CommonModel->iudAction('tbl_po', array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('id' => $po_id));
            $this->CommonModel->iudAction('tbl_po_items_details', array('deleted_by' => userId(), 'deleted_at' => date('Y-m-d H:i:s')), 'update', array('box_po_id' => $po_id));

            $description = "PO deleted -" . $po_data['boxpo_order_no'] . " by " . userId('name');
            $json_data_login = encode_arr($po_id);
            $data_action_log_array = array(userId(), userId('role_id'), userId('common_financial_year'), userId('company_id'), userId('site_id'), 'update', $description, 1, $po_id, '', '', date('Y-m-d H:i:s'), $json_data_login);;
            updateInActionLogFile($data_action_log_array);

            $response['result'] = true;
            $response['reasons'] = "PO Items Deleted";
        } else {
            $response['result'] = false;
            $response['reasons'] = "Something Went Wrong";
        }


        redirect(base_url(ADMIN . 'PO'));
    }


    public function poItemsTOtalItemdetailsUpdate()
    {
        $post = $this->input->post();
        $po_id = $post['box_po_id'];
        $total_qty = $post['total_qty'];
        $po_final_amount = $post['po_final_amount'];
        if ($po_id) {
            $insert_tax_data = array(
                'item_total_qty' => (isset($post['total_qty'])) ? $post['total_qty'] : NULL,
                'item_total_sub_amount' => (isset($post['total_item_rate'])) ? $post['total_item_rate'] : NULL,
                'item_total_discount' => (isset($post['total_discount_amount'])) ? $post['total_discount_amount'] : NULL,
                'item_total_gst' => (isset($post['total_tax_rate'])) ? $post['total_tax_rate'] : NULL,
                'item_total_additional_gst' => (isset($post['total_additional_tax_rate'])) ? $post['total_additional_tax_rate'] : NULL,
                'item_total_amount' => (isset($post['final_amount_total'])) ? $post['final_amount_total'] : NULL,
                'round_off' => (isset($post['round_off'])) ? $post['round_off'] : NULL,
                'po_final_amount' => (isset($post['po_final_amount'])) ? $post['po_final_amount'] : ''
            );

            $check_po_data = $this->CommonModel->getData('tbl_po_tax_details', array('box_po_id' => $po_id), 'po_final_amount', '', 'num_rows');

            if ($check_po_data) {
                $insert['updated_at'] = date('Y-m-d');
                $insert['updated_by'] = userId();
                $this->CommonModel->iudAction('tbl_po_tax_details', $insert_tax_data, 'update', array('box_po_id' => $po_id));
                // $po_id = $post['id'];
            }



            $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'boxpo_order_no', '', 'row_array');




            $description = "PO Item deleted update item qty -" . $po_data['boxpo_order_no'] . " by " . userId('name');
            $json_data_login = encode_arr($post);
            //array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');

            ////ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor
            //sub_ref_type:1 tbl_user
            $data_action_log_array = array(userId(), userId('role_id'), userId('common_financial_year'), userId('company_id'), userId('site_id'), 'update', $description, 1, $po_id, '', '', date('Y-m-d H:i:s'), $json_data_login);;
            updateInActionLogFile($data_action_log_array);


            $response['result'] = true;
            $response['reasons'] = "PO Items Deleted";
        } else {
            $response['result'] = false;
            $response['reasons'] = "Something Went Wrong";
        }


        echo json_encode($response);
        die;
    }
    public function po_pdf($po_id = '')
    {
        //   $po_pdfview = $this->BoxPOModel->getViewPopdf($po_id);
        //     $data =  $po_pdfview[0];
        $poData = $this->BoxPOModel->getViewPoData($po_id);
        $data =  $poData[0];
        $data['po_item_details_data'] = $this->BoxPOModel->getPoItemDetailsData($po_id);
        $data['po_tax_details_data'] = $this->BoxPOModel->getPoTaxDetailsData($po_id);

        // echo "<pre>"; print_r($data);die; 
        $this->load->view(ADMIN . 'po/view_po_pdf', $data);
    }

    public function submit_update_status()
    {
        $post = $this->input->post();
        $po_id = isset($post['box_po_id']) ? $post['box_po_id'] : '';
        // print_r($po_id);die;
        $po_status = isset($post['po_status']) ? $post['po_status'] : '';

        if ($po_status == 2) {
            $reject_reason = isset($post['reject_reason']) ? $post['reject_reason'] : '';
        } else {
            $reject_reason = NUll;
        }
        $approved_by = userId();
        $approved_at = date('Y-m-d H:m:s');

        $update_dt = $this->CommonModel->iudAction('tbl_po', array('po_status' => $po_status, 'reject_reasons' => $reject_reason, 'approved_by' => $approved_by, 'approved_at' => $approved_at), 'update', array('id' => $po_id));

        $po_data = $this->CommonModel->getData('tbl_po', array('id' => $po_id), 'boxpo_order_no', '', 'row_array');
        $description = "PO Approved -" . $po_data['boxpo_order_no'] . " by " . userId('name');
        $json_data_login = encode_arr($po_id);
        $data_action_log_array = array(userId(), userId('role_id'), userId('common_financial_year'), userId('company_id'), userId('site_id'), 'update', $description, 1, $po_id, '', '', date('Y-m-d H:i:s'), $json_data_login);;
        updateInActionLogFile($data_action_log_array);
        $po_invoice_pdf_name = $this->create_pdf($po_id);
        $this->CommonModel->iudAction('tbl_po', array('po_invoice_pdf_name' => $po_invoice_pdf_name, 'updated_at' => date('Y-m-d'), 'updated_by' => userId()), 'update', array('id' => $po_id));

        if ($update_dt) {
            $this->session->set_flashdata('success', 'Status Updated Succesfully');
        } else {
            $this->session->set_flashdata('success', 'Falied to Update Status!');
        }
        redirect(base_url() . 'admin/PO/viewPoDetailsData/' . $po_id);
        // echo json_encode($response);
    }

    public function create_pdf($po_id = '')
    {
        $this->load->library('pdf');


        $poData = $this->BoxPOModel->getViewPoData($po_id);
        $data =  $poData[0];
        $data['po_item_details_data'] = $this->BoxPOModel->getPoItemDetailsData($po_id);
        $data['po_tax_details_data'] = $this->BoxPOModel->getPoTaxDetailsData($po_id);
        $data['email_data'] = $this->BoxPOModel->getVendorEmailData('', $poData[0]['vendor_id']);

        if (!empty($data['email_data'])) {
            $emails = array_column($data['email_data'], 'email_id');
            $data['emails_other_email'] = implode(', ', $emails);
        } else {
            $data['emails_other_email'] = '';
        }

        $data['company_master_data'] = $this->CommonModel->getData('tbl_company_master', array('id' => $data['company_po_id']), '', '', 'row_array');

        $htmlContent = $this->load->view(ADMIN . 'po/view_po_pdf1', $data, true);
        $this->pdf->AddPage();

        $pdf = $this->pdf;
        $this->pdf->SetPrintHeader(false);
        $this->pdf->SetPrintFooter(false);

        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


        $this->pdf->SetMargins(5, 5, 5);
        $this->pdf->SetFont('helvetica', '', 7);

        $this->pdf->writeHTML($htmlContent);

        $file_name = $data['boxpo_order_no'] . ".pdf";
        $pdfOutputPath = FCPATH . 'pdfs/' . $file_name;

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->pdf->Output($pdfOutputPath, 'F');
        return $file_name;
    }
    public function listEmails()
    {
        if (!isset($_GET['searchTerm'])) {
            $json = [];
            $email_data = $this->BoxPOModel->getEmailData('');
        } else {
            $search = $_GET['searchTerm'];
            $email_data = $this->BoxPOModel->getEmailData($search);
        }
        foreach ($email_data as $key => $value) {
            $json[] = ['id' => $value['email'], 'text' => $value['email']];
        }
        echo json_encode($json);
    }
    public function listVendorEmails()
    {
        $vendor_id = $_GET['vendor_id'];

        if (!isset($_GET['searchTerm']) && isset($vendor_id)) {
            $json = [];

            $email_data = $this->BoxPOModel->getVendorEmailData('', $vendor_id);
            $vendor_wmail_id = $this->CommonModel->getData('tbl_vendor_master_details', array('vendor_id' => $vendor_id), 'id,contact_person_email', '', 'row_array');
        } else {
            $search = $_GET['searchTerm'];

            $email_data = $this->BoxPOModel->getVendorEmailData($search, $vendor_id);
        }

        if (isset($vendor_wmail_id['contact_person_email'])) {
            $json[] = ['id' => $vendor_wmail_id['contact_person_email'], 'text' => $vendor_wmail_id['contact_person_email'], 'selected' => true];
        }

        foreach ($email_data as $key => $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['email_id'], 'selected' => true];
        }
        echo json_encode($json);
    }
    public function viewPoDetailsData($po_id = '')
    {

        $poData = $this->BoxPOModel->getViewPoData($po_id);
        // echo $this->db->last_query();die;
        $data =  $poData[0];
        $data['po_item_details_data'] = $this->BoxPOModel->getPoItemDetailsData($po_id);
        $data['po_tax_details_data'] = $this->BoxPOModel->getPoTaxDetailsData($po_id);
        $data['vendor_dt'] = $this->CommonModel->getData('users', array('id' => $po_id), 'address as vendor_address,concat(first_name," ",last_name) as approved_by_name');
        $data['company_master'] = $this->CommonModel->getData('tbl_company_master', array('is_active' => 1));

        $data['attachment_file'] = $this->CommonModel->getData('tbl_po_attachment', array('box_po_id' => $po_id));

        $vendor_master_email = $this->CommonModel->getData('tbl_vendor_master_email', array('vendor_id' => $data['vendor_id']), 'id,vendor_id,email_id');

        $vendor_contact_person_email = $this->CommonModel->getData('tbl_vendor_master_details', array('vendor_id' => $data['vendor_id']), 'contact_person_email as id,vendor_id,contact_person_email as email_id');

        $data['vendor_master_email'] = array_merge($vendor_master_email, $vendor_contact_person_email);

        //  print_r($vendor_contact_person_email);

        $user_detail = $this->CommonModel->getData('users', array('id' => userId()), 'id,email,created_by', '', 'row_array');
        if ($user_detail['id'] == $user_detail['created_by']) {
            $user_email = $this->CommonModel->getData('users', array('id' => $user_detail['id']), 'id,email', '', '');
        } else {

            $user_created_by_email = $this->CommonModel->getData('users', array('id' => $user_detail['created_by']), 'id,email', '', '');

            if (isset($user_created_by_email['email']) && $user_created_by_email['email'] == 'superadmin@gmail.com') {
                $useremail = array_merge($user_created_by_email, $user_email_data);
                $user_email = $useremail;
            } else {
                $user_email_data = $this->CommonModel->getData('users', array('id' => $user_detail['id']), 'id,email', '', '');
                $user_email = $user_email_data;
            }
        }

        $data['user_email'] = $user_email;
        $data['department_data'] = $this->CommonModel->getData('tbl_department', array('id' => 2), 'id,email_id', '', 'row_array');
        $data['emailmessage'] = $this->CommonModel->getData('tbl_master_email_template', array('is_deleted' => 0));
        // echo "<pre>"; print_r($data['user_email'] );die;
        // die;
        // $data['user_email']
        // echo "<pre>"; print_r($data );die;
        $this->load->view(ADMIN . 'po/view_purchase_order', $data);
    }
    public function sendMailWithattchement()
    {
        $mail = $this->phpmailer_lib->load();

        //   $attachmentPath = $_SERVER["DOCUMENT_ROOT"].'/2023/encongroup/v4/pdfs/ENCON_PO_PDF_6.pdf';
        //   echo $attachmentPath;
        // echo "<pre>";
        // print_r($_FILES);die;
        $post = $this->input->post();

        $poid = isset($post['poid']) ? $post['poid'] : '';
        $vendor_id = isset($post['id_vendor']) ? $post['id_vendor'] : '';


        if (($_FILES['additional_attacheMent']['name'])) {
            $uploadStatus = myUpload(ADDITIONAL_ATTACHEMENT, 'additional_attacheMent', true);

            if (isset($uploadStatus['data'])) {
                $add_attachement = $uploadStatus['data'];
            } else {
                $add_attachement = array();
            }

            // echo "<pre>";  print_r($add_attachement);
        }

        $dt['subject'] = isset($post['subject']) ? $post['subject'] : '';

        $data['msg'] = isset($post['message']) ? $post['message'] : '';
        $data['name'] = 'vendor_name';
        $cc_array = array();
        foreach ($post['vendor_email_id'] as $key => $value) {
            $dt['vendor_email'][] = $value;
            if ($key == 0) {
                $vendor_email = $value;
            } else {

                array_push($cc_array, $value);
            }
        }
        //   print_r($post);die;
        if (isset($post['email_id'])) {
            foreach ($post['email_id'] as $key1 => $value1) {
                array_push($cc_array, $value1);
            }
        }

        if (isset($post['new_email'])) {
            $new_email = explode(',', $post['new_email']);
            foreach ($new_email as $key1 => $value1) {
                array_push($cc_array, $value1);
                if (! isset($vendor_email) && empty($vendor_email)) {
                    $vendor_email = $value1;
                }
            }
        }
        $absolutePath = FCPATH;
        // for po attachement
        if (! empty($post['checkbox'])) {
            $po_attachment = array();
            $po_attachment_file = array();
            $po_attachment = $this->CommonModel->getData('tbl_po_attachment', array('box_po_id' => $poid));

            foreach ($po_attachment as $key3 => $value3) {
                $po_attachment_file[] = $absolutePath . 'assets/uploads/po_attchment/' . $value3['file_name'];
                // echo "<pre>"; print_r($data['user_email'] );
            }
            //echo "<pre>"; print_r($poattachement );die;
        } else {
            $po_attachment_file = array();
        }

        if (! empty($post['checkbox_po_invoice_pdf_name'])) {
            $po_invoice_pdf_name = array($absolutePath . 'pdfs/' . $post['po_invoice_pdf_name']);
            //   $mime_type = mime_content_type($po_invoice_pdf_name1);
            //   echo "<pre>"; print_r($po_invoice_pdf_name1);
            //   echo "<pre>"; print_r($mime_type);die;
            //   $mail->addAttachment($po_invoice_pdf_name1, $post['po_invoice_pdf_name'], 'base64', $mime_type);
            //   $mail->addAttachment($po_invoice_pdf_name1);
        } else {
            $po_invoice_pdf_name = array();
        }

        //  for additional attachement
        $upload_additional_attachement = array();
        foreach ($add_attachement as $key2 => $value2) {

            $uploadattachement = $absolutePath . 'assets/uploads/additional_attchment/' . $value2["file_name"];

            $upload_additional_attachement[] = $uploadattachement;
            // echo "<pre>"; print_r($data['user_email'] );
        }

        if (!empty($po_attachment_file) && !empty($upload_additional_attachement)) {
            $array_attach = array_merge($po_attachment_file, $upload_additional_attachement);
        } else if (!empty($po_attachment_file)) {
            $array_attach = $po_attachment_file;
        } else if (!empty($upload_additional_attachement)) {
            $array_attach = $upload_additional_attachement;
        } else {
            $array_attach = array();
        }

        if (!empty($array_attach) && !empty($po_invoice_pdf_name)) {
            $attachement_array = array_merge($array_attach, $po_invoice_pdf_name);
        } else if (!empty($array_attach)) {
            $attachement_array = $array_attach;
        } else if (!empty($po_invoice_pdf_name)) {
            $attachement_array = $po_invoice_pdf_name;
        } else {
            $attachement_array = array();
        }

        $poData = $this->BoxPOModel->getViewPoData($poid);
        // print_r($poData);die;
        $data['msg'] = isset($post['message']) ? $post['message'] : '';;
        $data['link'] = base_url() . "po-email-confirmation/" . $poid;
        $data['boxpo_order_no'] = $poData[0]['boxpo_order_no'];
        $data['company_name'] = $poData[0]['company_name'];
        $data['site_name'] = $poData[0]['po_site_name'];
        $data['site_address'] = $poData[0]['company_address'];
        $htmlContent1 =  $this->load->view('admin/emails/po_template_1', $data, TRUE);
        // echo $htmlContent1;die;

        if (empty($cc_array)) {
            $cc_array = array('ramkrushna@encongroup.in', 'enconrksharma@gmail.com');
        } else {
            if (!in_array("ramkrushna@encongroup.in", $cc_array)) {
                array_push($cc_array, "ramkrushna@encongroup.in");
            }

            if (!in_array("enconrksharma@gmail.com", $cc_array)) {
                array_push($cc_array, "enconrksharma@gmail.com");
            }
            //   if(!in_array("ritikshukla@encongroup.in", $cc_array))
            //   {
            //       array_push($cc_array,"ritikshukla@encongroup.in");
            //   }

        }


        if (! empty($vendor_email) && ! empty($cc_array)) {
            $res1 = sendMailByPhpMailer($vendor_email, $post['subject'], $htmlContent1, $attachement_array, $cc_array);
        }

        if ($res1) {
            $this->session->set_flashdata('success', 'Mail sent Successfully');
            // echo "ok";
        } else {
            $this->session->set_flashdata('error', "Mail Not send");
            //echo "Mail Not Send";
        }
        // die;
        redirect(base_url() . 'admin/PO/viewPoDetailsData/' . $poid);
        // echo "<pre>"; print_r($data);die;
    }
    public function remove_po_attachment()
    {
        $po_attachment_id = $this->input->post('po_attachment_id');

        if ($this->CommonModel->iudAction('tbl_po_attachment', '', 'delete', array('id' => $po_attachment_id))) {
            $response['result'] = true;
            // $response['reason'] = 'Removed Successfully';

        } else {
            $response['result'] = false;
            // $response['reason'] = 'not Removed!';
        }
        echo json_encode($response);
    }
    public function listtermconditions()
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



        $count = count($this->BoxPOModel->gettermconditionsData($searchVal, 0, 0, 0, 0, 0, $where));
        if ($count) {
            $result = $this->BoxPOModel->gettermconditionsData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
            foreach ($result as $key => $value) {

                $row = [];
                array_push($row, '<div></div>');
                array_push($row, $offset + ($key + 1));


                array_push($row, $value['title']);
                array_push($row, $value['particulars']);
                $confirm = "confirm('Are you sure you want to delete this Service?')";

                // $action = '
                // <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="siteModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>';
                // array_push($row, $action);

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
    public function add_termconditions()
    {
        $post = $this->input->post();

        if ($post) {

            if (empty($post['id'])) {

                if ($this->CommonModel->iudAction('tbl_master_term_and_condition', $post, 'insert')) {
                    //echo $this->db->last_query();die();
                    $this->session->set_flashdata('success', 'TermCondition Added Succesfully!');
                } else {
                    $this->session->set_flashdata('error', 'Fail To Add TermCondition!');
                }
            }
            redirect(base_url(ADMIN . 'Po/add'));
        }
        $this->load->view(ADMIN . 'po/add_termconditions');
    }
    public function getItemUnitsStock()
    {
        $post = $this->input->post();
        if (isset($post['item_id']) && isset($post['item_unit_id'])) {
            $Stock = $this->CommonModel->getData('tbl_items_inventory', array('company_id' => userId('company_id'), 'site_id' => userId('site_id'), 'financial_year_id' => userId('financial_year_id'), 'item_id' => $post['item_id'], 'item_unit_id' => $post['item_unit_id']), 'qty', '', 'row_array');
            if (isset($Stock['qty'])) {
                $stocks = $Stock['qty'];
            } else {
                $stocks = 0;
            }
        } else {
            $stocks = 0;
        }
        if (isset($post['item_id']) && isset($post['item_unit_id'])) {

            $data['item_rate_updated_data'] = $this->BoxPOModel->getItemRateUpdated($post['item_id'], $post['item_unit_id']);

            $html = $this->load->view(ADMIN . 'po/item_rate_updated_data', $data, true);

            if ($html) {
                $response['html_data'] = $html;
            }
        }

        $json = array();
        $response['result'] = true;
        $response['stock'] = $stocks;
        echo json_encode($response);
    }
    public function getTermCondition()
    {

        $id = $this->input->post('id');
        $data['sub_title'] = 'Add Site';

        $data['termconditions'] = $this->CommonModel->getData('tbl_master_term_and_condition', array('is_deleted' => 0));
        // print_r($data['company_name']);die; 
        $html = $this->load->view(ADMIN . 'po/terms_condition_modal', $data, true);
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
    public function saveTermConditions()
    {
        $post = $this->input->post();

        if ($post) {
            $insert_id = '';
            if (!empty($post['particulars'])) {
                $insert_id = $this->CommonModel->iudAction('tbl_master_term_and_condition', $post, 'insert');
            }
            if ($insert_id) {
                $response['html'] = $insert_id;
                $response['result'] = true;
                $response['reason'] = 'Data Found';
            } else {
                $response['result'] = false;
                $response['reason'] = 'Something went to wrong!';
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Something went to wrong!';
        }
        echo json_encode($response);
    }
    public function InnearItemTableData()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Simulated inner table data based on the provided outerTableId
            // You can replace this with your actual data retrieval logic
            $data['items'] = $this->BoxPOModel->getPOItemData(array('pi.po_id' => $id));;
            // echo "<pre>";
            // print_r($data['items']);
            // echo $this->db->last_query();
            $html = $this->load->view(ADMIN . 'po/inner_items_table', $data, true);
            $response['html'] = $html;
            $response['result'] = true;
            $response['reason'] = 'Data Found';
        } else {

            // echo "Error: outerTableId parameter is missing";
            $response['result'] = false;
            $response['reason'] = 'Something went to wrong!';
            $response['html'] = '';
        }


        if ($html) {
        } else {
        }
        echo json_encode($response);
    }
    public function download_po_report_list()
    {
        $data = $this->input->post();


        $on_date = $this->input->post('on_date');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $where = array();
        // 

        if (isset($data['vendor_id']) && !empty($data['vendor_id'])) {
            $where['p.vendor_id'] = $data['vendor_id'];
        }
        if (isset($data['company_id']) && !empty($data['company_id'])) {
            if ($data['company_id'] != 'all') {
                $where['p.company_id'] = $data['company_id'];
            }
        } else {
            //$where['p.company_id'] =userId('company_id');
        }
        if (isset($data['site_id']) && !empty($data['site_id'])) {
            if ($data['company_id'] != 'all') {
                $where['p.site_id'] = $data['site_id'];
            }
        } else {
            //$where['p.site_id'] =userId('site_id');
        }
        if (empty($data['company_id']) &&  empty($data['site_id'])) {
            $where['p.company_id'] = userId('company_id');
            $where['p.site_id'] = userId('site_id');
            $where['p.financial_year_id'] = userId('financial_year_id');
        }
        if (isset($on_date)) {
            if ($on_date == 1) {
                // Today
                $from_date = date('Y-m-d');
                $where['DATE(p.box_po_date)'] = $from_date;
            } elseif ($on_date == 2) {
                // Yesterday
                $from_date = date('Y-m-d', strtotime('-1 day'));
                $where['DATE(p.box_po_date)'] = $from_date;
            } elseif ($on_date == 3) {
                // This Week (Monday to Sunday)
                $from_date = date('Y-m-d', strtotime('last monday'));
                $to_date = date('Y-m-d', strtotime('next sunday'));
                $where['DATE(p.box_po_date) >='] = $from_date;
                $where['DATE(p.box_po_date) <='] = $to_date;
            } elseif ($on_date == 4) {
                // This Month (First day to Last day)
                $from_date = date('Y-m-01');
                $to_date = date('Y-m-t');
                $where['DATE(p.box_po_date) >='] = $from_date;
                $where['DATE(p.box_po_date) <='] = $to_date;
            } elseif ($on_date == 5) {
                // This Year (January 1st to December 31st)
                $from_date = date('Y-01-01');
                $to_date = date('Y-12-31');
                $where['DATE(p.box_po_date) >='] = $from_date;
                $where['DATE(p.box_po_date) <='] = $to_date;
            } elseif ($on_date == 6 && !empty($from_date) && !empty($to_date)) {
                // Custom Date Range
                $from_date = date('Y-m-d', strtotime($from_date));
                $to_date = date('Y-m-d', strtotime($to_date));
                $where['DATE(p.box_po_date) >='] = $from_date;
                $where['DATE(p.box_po_date) <='] = $to_date;
            }
        }



        if (!empty($data['item_id']) &&  isset($data['item_id']) && $data['item_id'] != "all") {
            $item_id = $data['item_id'];
        } else {
            $item_id = '';
        }

        if (isset($data['cost_project_id']) && !empty($data['cost_project_id'])) {
            if ($data['cost_project_id'] != 'all') {
                $where['p.cost_project_id'] = $data['cost_project_id'];
            }
        } else {
            //$where['p.company_id'] =userId('company_id');
        }
        $total = 0;
        $row1 = [];
        $table_columns = array();
        // print_r($where);die;
        $count = count($this->BoxPOModel->getPoReportData('', 0, $where));
        // echo $this->db->last_query();die;
        if ($count) {
            $table_columns = array('Po Number', 'Vender Name', 'Item Group', 'Item Name', 'Unit', 'Rate', 'Qty', 'Amount', 'Cost Project Name', 'PO Date');
            $po_report_data = $this->BoxPOModel->getPoReportData('', 0, $where);
            foreach ($po_report_data as $key => $data) {
                $row = [];

                array_push($row, $data['boxpo_order_no']);
                array_push($row, $data['vender_name']);
                array_push($row, $data['item_group_name']);
                array_push($row, $data['item_name']);
                array_push($row, $data['unit_name']);
                array_push($row, $data['item_rate']);
                array_push($row, $data['item_total_qty']);
                array_push($row, $data['item_amount']);
                array_push($row, $data['cost_project_name']);
                array_push($row, $data['box_po_date']);
                $columns[] = $row;
            }
            exportCsv1($table_columns, $columns, 'Po_Report');
        } else {

            $this->session->set_flashdata('success', 'No data For Export ');
        }

        redirect(ADMIN . 'PO');
    }
        */
}
