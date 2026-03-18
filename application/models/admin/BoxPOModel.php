<?php

/**
 * 
 */

class BoxPOModel extends CI_Model
{
    public function getBoxPOData(
        $search = '',
        $sortCol = 0,
        $sortDir = 'DESC',
        $limit = 0,
        $offset = 0,
        $where = []
    ) {
        $columns = [
            'p.boxpo_order_no',
            'p.boxpo_date',
            'v.account_name',
            'c.name',
            's.site_name',
            'p.total_sq_inch',
            'p.cu_ft',
            'p.total_cost',
            'p.boxpo_status'
        ];

        $this->db
            ->select('
            p.*,
            v.account_name AS vendor_name,
            v.vendor_code,
            c.name AS company_name,
            s.site_name
        ')
            ->from('tbl_box_po p')
            ->join('tbl_vendor_master v', 'v.id = p.vendor_id', 'left')
            ->join('tbl_company_master c', 'c.id = p.company_id', 'left')
            ->join('tbl_site s', 's.id = p.site_id', 'left')
            ->where('p.deleted_at IS NULL');

        if (!empty($where)) {
            foreach ($where as $key => $val) {
                if ($val === null) {
                    $this->db->where($key, null, false);
                } else {
                    $this->db->where($key, $val);
                }
            }
        }

        if (!empty($search)) {
            $this->db->group_start()
                ->like('p.boxpo_order_no', $search)
                ->or_like('v.account_name', $search)
                ->or_like('c.name', $search)
                ->or_like('s.site_name', $search)
                ->group_end();
        }

        if (isset($columns[$sortCol])) {
            $this->db->order_by($columns[$sortCol], $sortDir);
        } else {
            $this->db->order_by('p.id', 'DESC');
        }

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }


    public function getBoxPOList($filters = [])
    {
        $this->db
            ->select('
            p.*,
            v.account_name as vendor_name,
            c.name as company_name,
            s.site_name
        ')
            ->from('tbl_box_po p')
            ->join('tbl_vendor_master v', 'v.id = p.vendor_id', 'left')
            ->join('tbl_company_master c', 'c.id = p.company_id', 'left')
            ->join('tbl_site s', 's.id = p.site_id', 'left')
            ->where('p.deleted_at IS NULL');

        if (!empty($filters['vendor_id'])) {
            $this->db->where('p.vendor_id', $filters['vendor_id']);
        }

        if (!empty($filters['company_id']) && $filters['company_id'] != 'all') {
            $this->db->where('p.company_id', $filters['company_id']);
        }

        if (!empty($filters['site_id']) && $filters['site_id'] != 'all') {
            $this->db->where('p.site_id', $filters['site_id']);
        }

        if (!empty($filters['on_date'])) {
            switch ($filters['on_date']) {
                case 1: 
                    $this->db->where('DATE(p.boxpo_date)', date('Y-m-d'));
                    break;

                case 2: 
                    $this->db->where('DATE(p.boxpo_date)', date('Y-m-d', strtotime('-1 day')));
                    break;

                case 3:
                    $this->db->where('YEARWEEK(p.boxpo_date, 1)=YEARWEEK(CURDATE(), 1)');
                    break;

                case 4: 
                    $this->db->where('MONTH(p.boxpo_date)', date('m'));
                    $this->db->where('YEAR(p.boxpo_date)', date('Y'));
                    break;

                case 5: 
                    $this->db->where('YEAR(p.boxpo_date)', date('Y'));
                    break;

                case 6: 
                    if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                        $this->db->where('DATE(p.boxpo_date) >=', $filters['from_date']);
                        $this->db->where('DATE(p.boxpo_date) <=', $filters['to_date']);
                    }
                    break;
            }
        }

        return $this->db
            ->order_by('p.id', 'DESC')
            ->get()
            ->result();
    }

    public function getItemGroupList($searchTerm = '', $where = '')
    {
        $this->db->select('c.*,c1.item_group_name as parent_group_name ');

        $this->db->from('tbl_item_groups c');
        $this->db->join('tbl_item_groups c1', 'c1.id=c.parent_group_id', 'left');


        if ($searchTerm) {

            $searchCondition = "(
                c.item_group_name like '%$searchTerm%'
                 )";

            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }

        $this->db->where('c.status', 1);
        // $this->db->where('c1.status',1);
        $this->db->where('c.is_deleted', 0);
        // $this->db->where('c1.is_deleted', 0);
        $this->db->order_by('c.item_group_name', 'asc');
        $result = $this->db->get()
            ->result_array();
        //echo $this->db->last_query();

        return $result;
    }

    public function getItemList($where = '')
    {
        $this->db->select('i.* ');

        $this->db->from('tbl_items i');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('i.deleted_by', NULL);
        $this->db->order_by('i.item_name', 'asc');
        $result = $this->db->get()
            ->result_array();
        //echo $this->db->last_query();

        return $result;
    }


    public function getVendorItemRateList($where = '', $vendor_id = '')
    {
        $this->db->select('i.*,vir.item_rate');
        $this->db->join('tbl_vendor_item_rate vir', 'vir.item_id = i.id', 'left');
        $this->db->from('tbl_items i');

        // $this->db->where('vir.vendor_id',$vendor_id);
        // $this->db->where('vir.item_id',$item_id);

        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('i.item_name', 'asc');
        $result = $this->db->get()
            ->result_array();
        // echo $this->db->last_query();die;

        return $result;
    }


    public function getItemUnitList($where = '')
    {
        $this->db->select('i.*,i.id as item_unit_id ,u.short_name');
        $this->db->from('tbl_items_units i');
        $this->db->join('tbl_master_unit u', 'u.id=i.unit_id', 'left');

        if ($where) {
            $this->db->where($where);
        }

        $this->db->order_by('u.short_name', 'desc');
        $result = $this->db->get()
            ->result_array();

        return $result;
    }

    // public function getPONumber()
    // {
    //     $financial_year_id = userId('financial_year_id');
    //     $company_id = userId('company_id');
    //     $site_id = userId('site_id');
    //     $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));



    //     $this->db->select('max(po_order_sequence) as po_order_sequence');
    //     $this->db->from('tbl_box_po i');
    //     $this->db->where('i.financial_year_id', $financial_year_id);
    //     $this->db->where('i.company_id', $company_id);
    //     $this->db->where('i.site_id', $site_id);




    //     $this->db->order_by('i.id', 'desc');
    //     $result = $this->db->get()
    //         ->row_array();

    //     if (isset($result['po_order_sequence'])) {
    //     } else {
    //         $po_number = 1;
    //     }



    //     $po_no = userId('site_inital') . "-" . $po_number;
    //     $number['po_order_sequence'] = $po_number;
    //     $number['po_no'] = userId('site_inital') . "-" . date('Y') . "-" . $po_number;;
    //     return $number;
    // }

    public function getBoxPONumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id        = userId('company_id');
        $site_id           = userId('site_id');

        $siteInitial = userId('site_inital');
        $year        = date('Y');

        $this->db->select('MAX(boxpo_order_sequence) AS last_seq');
        $this->db->from('tbl_box_po');
        $this->db->where('financial_year_id', $financial_year_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('site_id', $site_id);

        $row = $this->db->get()->row_array();

        $nextSeq = (!empty($row['last_seq']))
            ? ((int)$row['last_seq'] + 1)
            : 1;

        $boxpoNo = $siteInitial . '-' . $year . '-' . $nextSeq;

        return [
            'boxpo_order_sequence' => $nextSeq,
            'boxpo_order_no'       => $boxpoNo
        ];
    }


    public function getPOMaxSequenceNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $this->db->select('max(po_order_sequence) as po_order_sequence');
        $this->db->from('tbl_po i');
        $this->db->where('i.financial_year_id', $financial_year_id);
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.site_id', $site_id);
        $this->db->where('(i.amendment_main_po_id IS NULL OR i.amendment_main_po_id = 0)');
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()
            ->row_array();

        //   echo $this->db->last_query();
        if (isset($result['po_order_sequence'])) {

            if ($company_id == 3 && $site_id == 2) {
                //missing sequence  791 to 821 that we want add after 456 start sequence 473
                if ($result['po_order_sequence'] == 821) {
                    $po_number = 14;
                } else if ($result['po_order_sequence'] == 790) {
                    $po_number = 822;
                } else {
                    $po_number =  $result['po_order_sequence'] + 1;
                }
                //   $po_number=$result['po_order_sequence']+1;
            } else {
                $po_number = $result['po_order_sequence'] + 1;
            }
        } else {
            $po_number = 1;
        }

        $po_no = userId('site_inital') . "-" . $po_number;
        $number['po_order_sequence'] = $po_number;
        $number['po_no'] = userId('site_inital') . "-" . date('Y') . "-" . $po_number;;
        return $number;
    }


    protected $dt_Column = array(
        'p.id',
        'p.po_order_no',
        'p.po_date',
        'v.account_name',
        'pt.item_total_qty',
        'u.first_name',
        'p.boxpo_status',
        ''
    );
    public function getPOData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = '', $item_id = '', $item_group_id = '')
    {

        if (isset($item_id) && !empty($item_id) || isset($item_group_id) && !empty($item_group_id)) {
            $this->db->select('pi.po_id');;
            $this->db->from('tbl_po_items_details pi');
            $this->db->join('tbl_items i', 'i.id=pi.item_id');
            if (isset($item_id) && !empty($item_id)) {
                $this->db->where('pi.item_id', $item_id);
            }


            if (isset($item_group_id) && !empty($item_group_id)) {
                $this->db->where('i.item_group', $item_group_id);
            }

            $this->db->where('pi.deleted_by', NULL);
            $this->db->where('pi.po_id = p.id', NULL, false);
            $subquery = $this->db->get_compiled_select();

            // Fetch the compiled subquery SQL string
            $subquery_sql = "($subquery)";
        }
        $this->db->select('p.*, pt.*, u.first_name, u.last_name, v.account_name as vendor_name, pt.item_total_qty, p.id as po_id, p.created_by as po_created_by, s.site_name as delivery_site_name, pt.freight_type, p.id,cp.cost_project_name');
        $this->db->from('tbl_po p');
        $this->db->join('tbl_vendor_master v', 'v.id = p.vendor_id');
        $this->db->join('users u', 'u.id = p.created_by');
        $this->db->join('tbl_po_tax_details pt', 'pt.po_id = p.id');
        $this->db->join('tbl_site s', 's.id = p.delivery_site_id', 'left');
        $this->db->join('tbl_cost_project cp', 'cp.id = p.cost_project_id', 'left');

        // Add a subquery to filter results based on certain conditions
        // $subquery = $this->db->select('pi.po_id')
        //                      ->from('tbl_po_items_details pi')
        //                      ->where('pi.item_id', $item_id)
        //                      ->where('pi.deleted_by', NULL)
        //                      ->where('pi.po_id = p.id', NULL, false)
        //                      ->get_compiled_select();

        // $this->db->where_in('p.id',$subquery, false); // Encapsulate subquery with brackets

        // Add other conditions
        if ($id) {
            $this->db->where('p.id', $id);
        }

        if ($where) {
            $this->db->where($where);
        }

        $this->db->where('p.deleted_by', NULL);

        if (strlen($searchVal)) {
            $searchCondition = "(
                        p.po_order_no like '%$searchVal%' or
                        p.guarantee like '%$searchVal%' or
                        p.reference like '%$searchVal%' or
                        v.account_name like '%$searchVal%' 
                    )";

            $this->db->where($searchCondition);
        }


        // Apply the subquery in the WHERE clause
        if (isset($item_id) && !empty($item_id) || isset($item_group_id) && !empty($item_group_id)) {
            $this->db->where("p.id IN $subquery_sql");
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getPoOrderSequenceNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));



        $this->db->select('po_order_sequence');
        $this->db->from('tbl_box_po i');
        $this->db->where('i.financial_year_id', $financial_year_id);
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.site_id', $site_id);
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()
            ->row_array();
        if (isset($result['po_order_sequence'])) {
            return $result['po_order_sequence'] + 1;
        } else {
            return 1;
        }
    }
    public function getPOItemData($where = '')
    {
        $this->db->select('pi.*,pi.id as po_item_id, i.item_name,i.hsn_code,p.po_order_no ,u.unit_name');
        $this->db->from('tbl_po_items_details pi');
        $this->db->join('tbl_po p', 'p.id=pi.po_id');
        $this->db->join('tbl_items i', 'i.id=pi.item_id');
        $this->db->join('tbl_items_units iu', 'iu.id=pi.item_unit_id');
        $this->db->join('tbl_master_unit u', 'u.id=iu.unit_id');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('pi.deleted_by', NULL);

        $result = $this->db->get()
            ->result_array();
        //   echo $this->db->last_query();die;

        foreach ($result as $key => $value) {
            $this->db->select('i.*');
            $this->db->from('tbl_items i');
            if ($value['item_group_id'] != 0) {
                $this->db->where('i.item_group', $value['item_group_id']);
            }

            $result1 = $this->db->get()
                ->result_array();
            $result[$key]['item_list'] = $result1;
            $result[$key]['item_unit_list'] = $this->getItemUnitList(array('i.item_id' => $value['item_id']));
            // echo  $this->db->last_query();die;
        }

        return $result;
    }
    public function getPOItemDataALL($where_in)
    {
        $this->db->select('pi.*, pi.id AS po_item_id,i.item_name,i.hsn_code,p.po_order_no,pi.item_qty AS total_po_qty,IFNULL(SUM(gi.received_qty), 0) AS received_qty,(pi.item_qty - IFNULL(SUM(gi.received_qty), 0)) AS pending_qty');
        $this->db->from('tbl_po_items_details pi');
        $this->db->join('tbl_items i', 'i.id=pi.item_id');
        $this->db->join('tbl_po p', 'p.id=pi.po_id');
        $this->db->join('tbl_grn_items_details gi', 'gi.po_id=pi.po_id and pi.item_id = gi.item_id and gi.deleted_by is null and gi.po_item_id=pi.id', 'LEFT');

        if ($where_in) {
            $this->db->where_in('pi.po_id', $where_in);
        }
        $this->db->where('pi.deleted_by', NULL);
        $this->db->where('pi.po_grn_status !=', 2);
        $this->db->group_by(' p.id,pi.id');
        $this->db->having('pending_qty > 0');

        $result = $this->db->get()
            ->result_array();
        // echo $this->db->last_query();

        foreach ($result as $key => $value) {
            $this->db->select('i.*');
            $this->db->from('tbl_items i');
            $this->db->where('i.item_group', $value['item_group_id']);
            $result1 = $this->db->get()
                ->result_array();
            $result[$key]['item_list'] = $result1;
            $result[$key]['item_unit_list'] = $this->getItemUnitList(array('i.item_id' => $value['item_id']));
        }

        return $result;
    }
    public function getViewBoxPoData($boxpo_id)
    {
        $this->db->select('
        bp.*,
        vm.account_name AS vendor_name,
        vmd.address_details AS vendor_address,
        c.name AS vendor_city_name,
        s.name AS vendor_state_name,

        cm.name AS company_name,
        cm.address AS company_address,
        cm.email AS company_email,
        cm.pan_no,
        cm.gst_no,
        cm.left_image,
        cm.right_image
    ');

        $this->db->from('tbl_box_po bp');

        $this->db->join('tbl_vendor_master vm', 'vm.id = bp.vendor_id', 'left');
        $this->db->join('tbl_vendor_master_details vmd', 'vmd.vendor_id = vm.id', 'left');
        $this->db->join('cities c', 'c.id = vmd.city_id', 'left');
        $this->db->join('states s', 's.id = c.state_id', 'left');

        $this->db->join('tbl_company_master cm', 'cm.id = bp.company_id', 'left');

        $this->db->where('bp.id', $boxpo_id);

        return $this->db->get()->row_array();
    }

    public function getBoxPoVendorData($vendor_id)
    {
        $this->db->select('
        vm.id,
        vm.account_name AS vendor_name,
        vm.vendor_code,
        vm.company_id,
        vm.site_id,

        vmd.address_details,
        vmd.pincode,
        vmd.contact_person_email,
        vmd.contact_person_mobile_no,

        c.name AS vendor_city_name,
        s.name AS state_name,

        cm.name AS company_name,
        cm.address AS company_address,
        cm.email AS company_email,
        cm.left_image,
        cm.right_image,
        cm.pan_no,
        cm.gst_no AS company_gst_no,

        st.site_name,
        st.site_address
    ');

        $this->db->from('tbl_vendor_master vm');
        $this->db->join('tbl_vendor_master_details vmd', 'vmd.vendor_id = vm.id', 'left');
        $this->db->join('cities c', 'c.id = vmd.city_id', 'left');
        $this->db->join('states s', 's.id = c.state_id', 'left');

        $this->db->join('tbl_company_master cm', 'cm.id = vm.company_id', 'left');
        $this->db->join('tbl_site st', 'st.id = vm.site_id', 'left');

        $this->db->where('vm.id', $vendor_id);

        return $this->db->get()->row_array();
    }

    public function hasActiveAmendment($boxpo_id)
    {
        return $this->db
            ->from('tbl_box_po')
            ->where('amendment_main_boxpo_id', $boxpo_id)
            ->group_start()
            ->where('deleted_by IS NULL', null, false)
            ->or_where('deleted_by', 0)
            ->group_end()
            ->count_all_results() > 0;
    }

    public function buildAmendmentOrderNo($base_order_no, $amendment_seq)
    {
        return $base_order_no . '-' . $amendment_seq;
    }

    public function getLatestBoxPOVersion($base_boxpo_id)
    {
        return $this->db
            ->from('tbl_box_po')
            ->group_start()
            ->where('id', $base_boxpo_id)
            ->or_where('amendment_main_boxpo_id', $base_boxpo_id)
            ->group_end()
            ->order_by('amendment_sequence', 'DESC')
            ->limit(1)
            ->get()
            ->row_array();
    }

    public function getBaseBoxPO($boxpo_id)
    {
        $po = $this->db
            ->from('tbl_box_po')
            ->where('id', $boxpo_id)
            ->get()
            ->row_array();

        if (!$po) {
            return null;
        }

        if (!empty($po['amendment_main_boxpo_id'])) {
            return $this->getBaseBoxPO($po['amendment_main_boxpo_id']);
        }

        return $po; 
    }

    public function getNextAmendmentSequence($base_boxpo_id)
    {
        $row = $this->db
            ->select_max('amendment_sequence')
            ->from('tbl_box_po')
            ->where('amendment_main_boxpo_id', $base_boxpo_id)
            ->get()
            ->row_array();

        return ((int) $row['amendment_sequence']) + 1;
    }





    public function getValidBoxPO($po_id)
    {
        return $this->db
            ->from('tbl_box_po')
            ->where('id', $po_id)
            ->where('vendor_id IS NOT NULL', null, false)
            ->where('vendor_id !=', 0)
            ->get()
            ->row_array();
    }

    // public function getValidDimensions($po_id)
    // {
    //     return $this->db
    //         ->from('tbl_box_po_dimensions')
    //         ->where('box_po_id', $po_id)
    //         ->group_start()
    //         ->where('deleted_at IS NULL', null, false)
    //         ->or_where('deleted_at', '0000-00-00 00:00:00')
    //         ->group_end()
    //         ->where('section IS NOT NULL', null, false)
    //         ->where('section !=', '')
    //         ->where('qty >', 0)
    //         ->get()
    //         ->result_array();
    // }
    public function getValidDimensions($po_id)
    {
        return $this->db
            ->from('tbl_box_po_dimensions')
            ->where('box_po_id', $po_id)
            ->group_start()
            ->where('deleted_at IS NULL', null, false)
            ->or_where('deleted_at', '0000-00-00 00:00:00')
            ->group_end()
            ->where('qty >', 0)
            ->order_by('id', 'ASC')
            ->get()
            ->result_array();
    }


    public function getSite($site_id)
    {
        return $this->db
            ->get_where('tbl_site', ['id' => $site_id])
            ->row_array();
    }

    public function getCompany($company_id)
    {
        return $this->db
            ->get_where('tbl_company_master', ['id' => $company_id])
            ->row_array();
    }






    public function getPoItemDetailsData($po_id = '')
    {

        $this->db->select('pid.*,i.item_name,i.hsn_code,u.unit_name');
        $this->db->join('tbl_items i', 'i.id=pid.item_id');
        $this->db->join('tbl_items_units iu', 'iu.id=pid.item_unit_id');
        $this->db->join('tbl_master_unit u', 'u.id=iu.unit_id');
        $this->db->where('pid.po_id', $po_id);
        $this->db->from('tbl_po_items_details pid');
        $this->db->order_by('pid.id', 'desc');

        $this->db->where('pid.deleted_by', NULL);
        $query = $this->db->get();
        // echo $this->db->last_query();die; 
        return $query->result_array();
    }

    public function getPoTaxDetailsData($po_id = '')
    {

        $this->db->select('td.*,mt.tax_name, ft.tax_name as freight_tax_name,adft.tax_name as freight_additional_tax_name,nft.tax_name as new_gst_vat_name');
        $this->db->join('tbl_master_tax mt', 'mt.id=td.service_tax_id', 'left');
        $this->db->join('tbl_master_tax ft', 'ft.id=td.freight_tax_id', 'left');
        $this->db->join('tbl_master_tax adft', 'adft.id=td.freight_additional_tax_id', 'left');
        $this->db->join('tbl_master_tax nft', 'nft.id=td.new_tax_id', 'left');
        $this->db->where('td.po_id', $po_id);
        $this->db->from('tbl_po_tax_details td');
        $query = $this->db->get();
        // echo $this->db->last_query();die; 
        return $query->result_array();
    }
    public function getViewPopdf($po_id = '')
    {

        $this->db->select('p.*,vd.*,i.*,id.*');
        $this->db->join('tbl_vendor_master_details vd', 'vd.vendor_id=p.vendor_id');
        $this->db->join('tbl_po_items_details id', 'id.po_id=p.id');
        $this->db->join('tbl_items i', 'i.id=id.item_id');
        // $this->db->join('tbl_vendor_master vp','vp.id=p.delivery_party_id');

        if ($po_id) {
            $this->db->where('p.id', $po_id);
        }

        $this->db->from('tbl_po p');
        $query = $this->db->get();
        // echo $this->db->last_query();die; 
        return $query->result_array();
    }
    public function getEmailData($searchTerm = '')
    {
        $this->db->select('em.*');
        $this->db->from('users em');
        // $this->db->where('em.role_id !=',SUPERADMIN_ROLE);
        // $this->db->where('em.created_by',userId());
        if ($searchTerm) {
            $searchCondition = "(
                    em.email like '%$searchTerm%'
                 )";
            $this->db->where($searchCondition);
        }
        $result = $this->db->get()
            ->result_array();
        return $result;
    }

    public function getVendorEmailData($searchTerm = '', $vendor_id = '')
    {
        $this->db->select('me.*');

        $this->db->from('tbl_vendor_master_email me');
        $this->db->where('me.vendor_id', $vendor_id);
        if ($searchTerm) {
            $searchCondition = "(
                    me.email_id like '%$searchTerm%'
                 )";
            $this->db->where($searchCondition);
        }
        $result = $this->db->get()
            ->result_array();
        return $result;
    }



    public function gettermconditionsData($id = '')
    {

        $this->db->select('tc.*,');


        if ($id) {
            $this->db->where('tc.id', $id);
        }

        $this->db->from('tbl_master_term_and_condition tc');
        $query = $this->db->get();
        // echo $this->db->last_query();die; 
        return $query->result_array();
    }
    public function getItemUnitBatchList($where = '')
    {
        $this->db->select('count(i.id),item_id,item_unit_id,i.batch_no,i.expired_date');
        $this->db->from('tbl_items_inventory i');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('i.qty!=', 0.00);
        $this->db->group_by('item_id,item_unit_id,batch_no,expired_date');
        $result = $this->db->get()
            ->result_array();
        //echo $this->db->last_query();

        return $result;
    }
    public function getItemRateBatchList($where = '')
    {
        $this->db->select('item_rate,item_amount,received_qty,item_rate_type, item_weight,weight_per_qty,weight_per_rate ');
        $this->db->from('tbl_grn_items_details gi');
        $this->db->join('tbl_grn grn', 'grn.id = gi.grn_id');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('gi.id', 'desc');
        $result = $this->db->get()
            ->row_array();
        //echo $this->db->last_query();

        return $result;
    }

    public function getItemRateBatchListFromOS($where = '')
    {
        $this->db->select('unit_rate,opening_qty,item_amt,item_rate_type,opening_weight,weight_per_qty,weight_per_rate');
        $this->db->from('tbl_items_opening_stock_details os');
        $this->db->join('tbl_items_opening_stock osd', 'osd.id = os.opening_id');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('os.id', 'desc');
        $result = $this->db->get()
            ->row_array();
        //echo $this->db->last_query();

        return $result;
    }
    public function getItemRateBatchListFromRecevied($where = '')
    {
        $this->db->select('os.rate,os.amount,os.received_qty,weight,(CASE WHEN os.weight IS NULL OR os.weight = 0.00 THEN 1 ELSE 2 END) as item_rate_type,(os.amount / os.received_qty) as weight_per_rate,(CASE WHEN os.weight IS NULL OR os.weight = 0.00 THEN (os.amount / os.received_qty) ELSE NULL END) as weight_per_qty ');
        $this->db->from('tbl_recevied_material_issue_items_details os');
        $this->db->join('tbl_recevied_material_issue osd', 'osd.id = os.received_id');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('os.id', 'desc');
        $result = $this->db->get()
            ->row_array();
        //echo $this->db->last_query();

        return $result;
    }




    public function getItemRateUpdated($item_id = '', $unit_id = '')
    {

        $this->db->select('pd.id,pd.po_id,pd.item_id,pd.item_rate,tp.po_order_no,tmu.short_name as unit_name ,vm.account_name as vendor_name');
        $this->db->join('tbl_po tp', 'tp.id = pd.po_id');
        $this->db->join('tbl_items_units tiu', 'tiu.id = pd.item_unit_id');
        $this->db->join('tbl_master_unit tmu', 'tmu.id=tiu.unit_id');
        $this->db->join('tbl_vendor_master vm', 'vm.id = tp.vendor_id');

        if ($item_id) {
            $this->db->where('pd.item_id', $item_id);
        }

        // if ($unit_id) {
        //     $this->db->where('pd.item_unit_id',$unit_id);  
        // }

        $this->db->from('tbl_po_items_details pd');
        $this->db->order_by('pd.id', 'DESC');
        $this->db->limit(5);

        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }
    public function getAmendmentSequences($_po_id)
    {

        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');

        $this->db->select('amendment_sequences');
        $this->db->from('tbl_po i');
        $this->db->where('i.financial_year_id', $financial_year_id);
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.site_id', $site_id);
        $this->db->where('i.amendment_main_po_id', $_po_id);
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()
            ->row_array();

        if (isset($result['amendment_sequences'])) {
            $po_number = $result['amendment_sequences'] + 1;
            // print_r($po_number);die;
        } else {
            $po_number = 1;
        }
        $number['amendment_sequences'] = $po_number;
        return $number;
    }
    public function getPoReportData($searchVal = '', $id = '', $where = "")
    {

        $this->db->select('pid.*,p.*,p.po_order_no as po_order_no,pt.item_total_qty,v.account_name as vender_name,ig.item_group_name as item_group_name,i.item_name as item_name,u.unit_name,cp.cost_project_name');
        $this->db->join('tbl_po p', 'p.id= pid.po_id');
        $this->db->join('tbl_vendor_master v', 'v.id=p.vendor_id');
        $this->db->join('tbl_item_groups ig', 'ig.id=pid.item_group_id');
        $this->db->join('tbl_items i', 'i.id=pid.item_id');
        $this->db->join('tbl_items_units iu', 'iu.id=pid.item_unit_id');
        $this->db->join('tbl_master_unit u', 'u.id=iu.unit_id');
        $this->db->join('tbl_po_tax_details pt', 'pt.po_id = p.id');
        $this->db->join('tbl_cost_project cp', 'cp.id = p.cost_project_id', 'left');
        if ($id) {
            $this->db->where('pid.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(
                    p.po_order_no like '%$searchVal%' 
                   
                  )";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('pid.deleted_by', NULL);

        $this->db->from('tbl_po_items_details pid');

        // if($limit){
        //     $this->db->limit($limit, $offset);
        // }

        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }
}
