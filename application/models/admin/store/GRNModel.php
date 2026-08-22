<?php
/**
 *
 */

class GRNModel extends CI_Model
{
    public function getGRNNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $this->db->select('grn_order_sequence');
        $this->db->from('tbl_grn i');
        $this->db->where('i.financial_year_id', $financial_year_id);
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.site_id', $site_id);
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()->row_array();

        $this->db->select('id');
        $this->db->from('tbl_grn i');
        $this->db->order_by('i.id', 'desc');
        $result1 = $this->db->get()->row_array();

        //echo $this->db->last_query();
        if (isset($result['grn_order_sequence'])) {
            $grn_number = $result['grn_order_sequence'] + 1;
        } else {
            $grn_number = 1;
        }

        if (isset($result1['id'])) {
            $grn_id = $result1['id'] + 1;
        } else {
            $grn_id = 1;
        }

        // $grn_no=$grn_id."-".$firstTwoLetters."-".$company_id."-".$site_id."-".$grn_number;
        $grn_no = userId('site_inital') . "-" . $grn_number;
        return $grn_no;
    }
    public function getGRNOrderSequenceNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $this->db->select('grn_order_sequence');
        $this->db->from('tbl_grn i');
        $this->db->where('i.financial_year_id', $financial_year_id);
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.site_id', $site_id);
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()->row_array();
        if (isset($result['grn_order_sequence'])) {
            return $result['grn_order_sequence'] + 1;
        } else {
            return 1;
        }
    }
    protected $dt_Column = ['p.id', 'p.po_order_no', 'p.po_date', 'v.account_name', 'pt.item_total_qty', 'u.first_name', 'p.po_status', ''];
    public function getPOData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = '')
    {
        $this->db->select('p.*,pt.*,u.first_name,u.last_name,v.account_name as vendor_name,pt.item_total_qty,p.id as po_id ,p.created_by as po_created_by,s.site_name as delivery_site_name');
        $this->db->join('tbl_vendor_master v', 'v.id=p.vendor_id');
        $this->db->join('users u', 'u.id=p.created_by');
        $this->db->join('tbl_po_tax_details pt', 'pt.po_id=p.id');
        $this->db->join('tbl_site s', 's.id=p.delivery_site_id');

        if ($id) {
            $this->db->where('p.id', $id);
        }

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('p.deleted_by', null);

        if (strlen($searchVal)) {
            $searchCondition = "(
                    p.po_order_no like '%$searchVal%' or
                    p.guarantee like '%$searchVal%' or
                    p.reference like '%$searchVal%' or
                   v.account_name like '%$searchVal%' 
                    
                )";

            $this->db->where($searchCondition);
        }

        $this->db->from('tbl_po p');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result_array();
    }
    public function getPoOrderSequenceNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $this->db->select('po_order_sequence');
        $this->db->from('tbl_po i');
        $this->db->where('i.financial_year_id', $financial_year_id);
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.site_id', $site_id);
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()->row_array();
        if (isset($result['po_order_sequence'])) {
            return $result['po_order_sequence'] + 1;
        } else {
            return 1;
        }
    }
    public function getPOItemData($where = '')
    {
        $this->db->select('pi.*,pi.id as po_item_id, i.item_name,i.hsn_code ');
        $this->db->from('tbl_po_items_details pi');
        $this->db->join('tbl_items i', 'i.id=pi.item_id');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('pi.deleted_by', null);

        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();

        foreach ($result as $key => $value) {
            $this->db->select('i.*');
            $this->db->from('tbl_items i');
            $this->db->where('i.item_group', $value['item_group_id']);
            $result1 = $this->db->get()->result_array();
            $result[$key]['item_list'] = $result1;
            $result[$key]['item_unit_list'] = $this->getItemUnitList(['i.item_id' => $value['item_id']]);
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
        $this->db->join('tbl_grn_items_details gi', 'gi.po_id=pi.po_id and pi.item_id = gi.item_id', 'LEFT');

        if ($where_in) {
            $this->db->where_in('pi.po_id', $where_in);
        }
        $this->db->where('pi.deleted_by', null);
        $this->db->group_by(' pi.id, i.item_name, i.hsn_code, p.po_order_no, pi.item_qty');
        $this->db->having('pending_qty > 0');

        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();

        foreach ($result as $key => $value) {
            $this->db->select('i.*');
            $this->db->from('tbl_items i');
            $this->db->where('i.item_group', $value['item_group_id']);
            $result1 = $this->db->get()->result_array();
            $result[$key]['item_list'] = $result1;
            $result[$key]['item_unit_list'] = $this->getItemUnitList(['i.item_id' => $value['item_id']]);
        }

        return $result;
    }
    public function getViewPoData($po_id = '')
    {
        $this->db->select(
            'p.*,vm.account_name as vendor_name,s.site_name as billing_site_name,ds.site_name as delivery_site_name,vp.account_name as delivery_party_name,vm.*,vmp.*,c.name as vendor_city_name,sv.name as state_name,u.first_name as created_first_name,u.last_name as created_last_name ,u1.first_name as approved_first_name,u1.last_name as approved_last_name ,p.id'
        );
        $this->db->join('tbl_vendor_master vm', 'vm.id=p.vendor_id');
        $this->db->join('tbl_site s', 's.id=p.billing_site_id', 'left');
        $this->db->join('tbl_site ds', 'ds.id=p.delivery_site_id', 'left');
        $this->db->join('tbl_vendor_master vp', 'vp.id=p.delivery_party_id', 'left');
        $this->db->join('tbl_vendor_master_details vmp', 'vmp.vendor_id=vm.id');
        $this->db->join('cities c', 'c.id=vmp.city_id', 'left');
        $this->db->join('states sv', 'sv.id=c.state_id', 'left');
        $this->db->join('users u', 'p.created_by=u.id', 'left');
        $this->db->join('users u1', 'u1.id=p.approved_by', 'left');

        if ($po_id) {
            $this->db->where('p.id', $po_id);
        }

        $this->db->from('tbl_po p');
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result_array();
    }
    public function getPOPendingCount($where)
    {
        $this->db->select('sum(pi.item_qty) AS total_po_qty,IFNULL(SUM(gi.received_qty), 0) AS received_qty');
        $this->db->from('tbl_po_items_details pi');
        $this->db->join('tbl_items i', 'i.id=pi.item_id');
        $this->db->join('tbl_po p', 'p.id=pi.po_id');
        $this->db->join('tbl_grn_items_details gi', 'gi.po_id=pi.po_id and pi.item_id = gi.item_id', 'LEFT');

        if ($where) {
            $this->db->where_in('p.id', $where);
        }
        $this->db->where('pi.deleted_by', null);
        $this->db->group_by('p.id');

        $result = $this->db->get()->row_array();

        // echo $this->db->last_query();die;
        return $result;
    }
    protected $dt_Column1 = ['p.id', 'p.grn_no', 'p.grn_date', 'v.account_name', 'pt.item_total_qty', 'u.first_name', 'p.status', ''];
    public function getGRNData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = '', $item_id = '')
    {
        if (isset($item_id) && !empty($item_id)) {
            $subquery = $this->db
                ->select('pi.grn_id')
                ->from('tbl_grn_items_details pi')
                ->where('pi.item_id', $item_id)
                ->where('pi.deleted_by', null)
                ->where('pi.grn_id = p.id', null, false)
                ->get_compiled_select();

            // Fetch the compiled subquery SQL string
            $subquery_sql = "($subquery)";
        }

        $this->db->select('p.*,p.created_by as grn_created_by,pt.*,u.first_name,u.last_name,v.account_name as vendor_name,pt.item_total_qty,p.id as grn_id ,p.created_by as po_created_by,s.site_name as location_site_name ,tg.first_name as deleted_by_fname,tg.last_name as deleted_by_lname');
        $this->db->join('tbl_vendor_master v', 'v.id=p.vendor_id','left');
        $this->db->join('users u', 'u.id=p.created_by');
        $this->db->join('tbl_grn_tax_details pt', 'pt.grn_id=p.id');
        $this->db->join('tbl_site s', 's.id=p.receive_location_site_id', 'left');
        $this->db->join('users tg', 'tg.id=p.deleted_by', 'left');
        if ($id) {
            $this->db->where('p.id', $id);
        }

        if ($where) {
            $this->db->where($where);
        }
       // $this->db->where('p.deleted_by', null);
        

        if (strlen($searchVal)) {
            $searchCondition = "(
                    p.grn_no like '%$searchVal%' or
                    p.remark like '%$searchVal%' or
                    s.site_name like '%$searchVal%' or
                    p.manual_slip_no like '%$searchVal%' or
                   v.account_name like '%$searchVal%' 
                    
                )";

            $this->db->where($searchCondition);
        }
        if (isset($item_id) && !empty($item_id)) {
            $this->db->where("p.id IN $subquery_sql");
        }

        $this->db->from('tbl_grn p');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column1[$sortColIndex], $sortBy);

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result_array();
    }
    public function getGRNItemDataALL($where)
    {
        $this->db->select('pi.*,pi.id AS grn_item_id,i.item_name,i.hsn_code,p.grn_no,u.unit_name');
        $this->db->from('tbl_grn_items_details pi');
        $this->db->join('tbl_items i', 'i.id=pi.item_id');
        $this->db->join('tbl_items_units iu', 'iu.id=pi.item_unit_id');
        $this->db->join('tbl_master_unit u', 'u.id=iu.unit_id');

        $this->db->join('tbl_grn p', 'p.id=pi.grn_id');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('pi.deleted_by', null);

        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();

        foreach ($result as $key => $value) {
            $this->db->select('i.*');
            $this->db->from('tbl_items i');
            if ($value['item_group_id'] != 0) {
                $this->db->where('i.item_group', $value['item_group_id']);
            }
            $result1 = $this->db->get()->result_array();
            $result[$key]['item_list'] = $result1;
            $result[$key]['item_unit_list'] = $this->getItemUnitList(['i.item_id' => $value['item_id']]);
            $result[$key]['item_batch_list'] = $this->getItemUnitBatchList(['i.item_id' => $value['item_id']]);
            if ($value['po_id'] != null || $value['po_id'] != 0) {
                $this->db->select('pi.item_qty AS total_po_qty,IFNULL(SUM(gi.received_qty), 0) AS received_qty,(pi.item_qty - IFNULL(SUM(gi.received_qty), 0)) AS pending_qty,p.po_order_no');
                $this->db->from('tbl_po_items_details pi');
                $this->db->join('tbl_po p', 'p.id=pi.po_id');
                $this->db->join('tbl_grn_items_details gi', 'gi.po_id=pi.po_id and pi.item_id = gi.item_id', 'LEFT');
                $this->db->where('pi.po_id', $value['po_id']);
                $this->db->where('pi.item_id', $value['item_id']);
                $this->db->where('pi.deleted_by', null);
                $this->db->where('pi.po_grn_status !=', 2);
                $this->db->group_by(' p.id,pi.id');
                // $this->db->having('pending_qty > 0');
                $result2 = $this->db->get()->row_array();
                if (!empty($result2)) {
                    $result[$key]['po_received_qty'] = $result2['received_qty'];
                    $result[$key]['total_po_qty'] = $result2['total_po_qty'];
                    $result[$key]['pending_qty'] = $result2['pending_qty'];
                    $result[$key]['po_order_no'] = $result2['po_order_no'];
                } else {
                    $result[$key]['po_received_qty'] = 0;
                    $result[$key]['total_po_qty'] = 0;
                    $result[$key]['pending_qty'] = 0;
                    $result[$key]['po_order_no'] = '';
                }
            } else {
                $result[$key]['po_received_qty'] = 0;
                $result[$key]['total_po_qty'] = 0;
                $result[$key]['pending_qty'] = 0;
            }
        }

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
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();

        return $result;
    }
    public function getItemUnitBatchList($where = '')
    {
        $this->db->select('count(i.id),i.batch_no , sum(qty) as batch_qty');
        $this->db->from('tbl_items_inventory i');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->group_by('i.batch_no');
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();

        return $result;
    }
    public function getGRNviewpdfData($id = '')
    {
        $this->db->select(
            'tg.*,p.po_order_no,p.po_date,vm.account_name,u.first_name,u.last_name,c.name as compnay_name,c.address as company_address,cs.site_name,cs.site_address,lpi.account_name as load_party_name ,gtd.packing_forwarding_amount '
        );
        $this->db->join('tbl_vendor_master vm', 'vm.id=tg.vendor_id','left');
        $this->db->join('tbl_po p', 'p.id=tg.po_id', 'left');
        $this->db->join('users u', 'u.id=tg.created_by');
        $this->db->join('tbl_company_master c', 'c.id=tg.company_id');
        $this->db->join('tbl_site cs', 'cs.id=tg.site_id');
        $this->db->join('tbl_vendor_master lpi', 'lpi.id=tg.loaded_vendor_id', 'left');
        $this->db->join('tbl_grn_tax_details gtd', 'gtd.grn_id=tg.id');
        if ($id) {
            $this->db->where('tg.id', $id);
        }

        $this->db->from('tbl_grn tg');
        $query = $this->db->get();

        return $query->result_array();
    }
    public function getGrnItemDetailsData($id = '')
    {
        $this->db->select(
            'gid.*,i.item_name,u.unit_name,i.item_code,i.stock_unit,i.rate,gtd.gst_amount,gtd.packing_forwarding_amount,gtd.landed_cost_final_amount,gid.item_discount_percent as grn_discount_percent,gid.item_discount_amount as grn_discount_amt,gid.tax_rate as grn_txt_rate ,gid.tax_value as grn_txt_value ,item_qty as total_aginst_po'
        );
        $this->db->join('tbl_items i', 'i.id=gid.item_id', 'left');
        // $this->db->join('tbl_po_items_details pid','pid.po_id=gid.po_id','left');
        $this->db->join('tbl_grn_tax_details gtd', 'gtd.grn_id=gid.grn_id');
        $this->db->join('tbl_po_items_details pid', 'pid.po_id=gid.po_id and pid.item_id=gid.item_id', 'left');
        $this->db->join('tbl_items_units iu', 'iu.id=gid.item_unit_id');
        $this->db->join('tbl_master_unit u', 'u.id=iu.unit_id');

        $this->db->where('gid.deleted_by', null);
        $this->db->where('gid.grn_id', $id);
        $this->db->from('tbl_grn_items_details gid');
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result_array();
    }
    public function getGrnTaxDetailsData($grn_id = '')
    {
        $this->db->select('td.*,mt.tax_name, ft.tax_name as freight_tax_name,adft.tax_name as freight_additional_tax_name,nft.tax_name as new_grn_vat_name');
        $this->db->join('tbl_master_tax mt', 'mt.id=td.service_tax_id', 'left');
        $this->db->join('tbl_master_tax ft', 'ft.id=td.freight_tax_id', 'left');
        $this->db->join('tbl_master_tax adft', 'adft.id=td.freight_additional_tax_id', 'left');
        $this->db->join('tbl_master_tax nft', 'nft.id=td.new_tax_id', 'left');
        $this->db->where('td.grn_id', $grn_id);
        $this->db->from('tbl_grn_tax_details td');
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result_array();
    }
    public function checkMaterialIssueOrNot($where)
    {
        $this->db->select('pi.*,pi.id AS grn_item_id,i.item_name,i.hsn_code,p.grn_no');
        $this->db->from('tbl_grn_items_details pi');
        $this->db->join('tbl_items i', 'i.id=pi.item_id');
        $this->db->join('tbl_grn p', 'p.id=pi.grn_id');
        $this->db->join('tbl_material_issue_items_details mi', 'mi.item_id=pi.item_id and mi.batch_no=pi.batch_no and mi.expired_date=pi.expired_date');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('pi.deleted_by', null);
        $this->db->where('mi.deleted_by', null);
        $result = $this->db->get()->num_rows();
        // echo $this->db->last_query();

        return $result;
    }
}
?>
