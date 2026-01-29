<?php
class IndentModel extends CI_Model
{

    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );
    public function getindentData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select('ti.*,c.company_name as client_name,  p.plant_narration');
        $this->db->join('tbl_customer c', 'c.id=ti.client_id');
        $this->db->join('tbl_plant p', 'p.id = ti.plant_id');
        if ($id) {
            $this->db->where('ti.id', $id);
        }
        if (strlen($searchVal)) {
            $searchCondition = "(
                    ti.tbl_indent like '%$searchVal%'
                  )";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }

        $this->db->from('tbl_indent ti');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getIntentData($id = '')
    {
        $this->db->select('ti.*,');
        $this->db->from('tbl_master_indent_for ti');

        if ($id) {
            $this->db->where('ti.id', $id);
        }

        // $this->db->where('pi.deleted_by',NULL);

        $result = $this->db->get()
            ->result_array();
        // echo $this->db->last_query();


        return $result;
    }

    public function getindentName($searchTerm = '')
    {
        $this->db->select('i.*');

        $this->db->from('tbl_master_indent_for i');

        if ($searchTerm) {
            $searchCondition = "(
                        i.indent_name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
         $this->db->order_by('i.display_sequences', 'asc');
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getclientName($searchTerm = '')
    {
        $this->db->select('c.*');

        $this->db->from('tbl_customer c');

        if ($searchTerm) {
            $searchCondition = "(
                        c.company_name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getplantName($searchTerm = '')
    {
        $this->db->select('s.*');

        $this->db->from('tbl_site s');

        if ($searchTerm) {
            $searchCondition = "(
                        s.site_name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $result = $this->db->get()
            ->result_array();
        return $result;
    }

    public function getBladeData($id = '')
    {

        $this->db->select('tb.*,');


        if ($id) {
            $this->db->where('tb.id', $id);
        }

        $this->db->from('tbl_indent_blade tb');
        $query = $this->db->get();
        // echo $this->db->last_query();die; 
        return $query->result_array();
    }

    public function getIndentModuleData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select('ti.*,min.db_table_name,min.indent_name,s.short_name as site_name,min.db_qty_field_name ,ti.id as indent_details_id');
        $this->db->join('tbl_indent in', 'in.id=ti.indent_id');
        $this->db->join('tbl_site s', 's.id=ti.plant_id');
        $this->db->join('tbl_master_indent_for min', 'min.id=ti.master_indent_id');

        if ($id) {
            $this->db->where('ti.id', $id);
        }
        // $this->db->where('cp.deleted_by',NULL);
        if (strlen($searchVal)) {
            $searchCondition = "(
                    in.indent_name like '%$searchVal%'
                  )";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('ti.deleted_by', NULL);
        $this->db->from('tbl_indent_details ti');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result_array();
    }
    public function getSiteNameByIndentId($indent_id = '')
    {
        $this->db->select('ts.site_name');
        $this->db->from('tbl_indent_details tid');
        $this->db->join('tbl_site ts', 'tid.plant_id = ts.id');
        $this->db->where('tid.indent_id', $indent_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->site_name;
        } else {
            return null;
        }
    }
    public function getIndentViewData($where = "", $is_group_by = 0)
    {
        $this->db->select('ti.*, min.db_table_name, min.indent_name, s.site_name, min.db_qty_field_name,min.field_count,in.indent_number,c.left_image,c.name as company_name ,c.address as company_address,c.email as company_email,s.site_address,c.right_image,u.first_name,u.last_name,c.signature_image ,(select count(id) from tbl_indent_details ind where  ti.plant_id=ind.plant_id and ti.indent_id=ind.indent_id )as site_count,(select sum(field_count) from tbl_indent_details mind join tbl_master_indent_for min1 on min1.id=mind.master_indent_id where mind.plant_id=ti.plant_id and ti.indent_id=mind.indent_id  )as site_total_indent_count, ti.indent_id as plant_id');
        $this->db->join('tbl_indent in', 'in.id = ti.indent_id');
        $this->db->join('tbl_site s', 's.id = ti.plant_id');
         $this->db->join('tbl_company_master c', 'c.id = s.company_id');
        $this->db->join('tbl_master_indent_for min', 'min.id = ti.master_indent_id');
        $this->db->join('users u', 'u.id = in.created_by');
        if ($where) {
            $this->db->where($where);
        }

        // $this->db->where('ti.indent_id IS NOT NULL'); 
        $this->db->from('tbl_indent_details ti');
        if ($is_group_by) {
            $this->db->group_by('ti.plant_id');
        }
         $this->db->order_by('s.site_name asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPlantsData($customerId = '', $searchTerm = '')
    {
        $this->db->select('tp.id, tp.plant_narration');
        $this->db->from('tbl_plant tp');
        $this->db->where('customer_id', $customerId);
        $this->db->where('tp.plant_narration like "%' . $searchTerm . '%"');
        $result = $this->db->get()
            ->result_array();
        return $result;
        print_r($result);
        die;
    }
    public function getIndentSequenceNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $this->db->select('indent_sequence');
        $this->db->from('tbl_indent i');
        
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()->row_array();
        if (isset($result['indent_sequence'])) {
            return $result['indent_sequence'] + 1;
        } else {
            return 1;
        }
    }

        public function getindentNumber()
    {
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $this->db->select('indent_sequence');
        $this->db->from('tbl_indent i');
        
        $this->db->order_by('i.id', 'desc');
        $result = $this->db->get()->row_array();

        $this->db->select('id');
        $this->db->from('tbl_indent i');
        $this->db->order_by('i.id', 'desc');
        $result1 = $this->db->get()->row_array();

        //echo $this->db->last_query();
        if (isset($result['indent_sequence'])) {
            $indent_number = $result['indent_sequence'] + 1;
        } else {
            $indent_number = 1;
        }

        if (isset($result1['id'])) {
            $indent_number = $result1['id'] + 1;
        } else {
            $indent_number = 1;
        }

      
        $indent_no = userId('site_inital') . "-" . $indent_number;
        return $indent_no;
    }

}
