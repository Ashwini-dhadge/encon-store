<?php
class IndentModel extends CI_Model
{

    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );
    public function getBladeIndentData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select('i.*,tid.*,c.company_name as client_name,  p.plant_narration,tid.ref_id as indent_bland_id');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id= i.id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        $this->db->join('tbl_plant p', 'p.id = i.plant_id');
        if ($id) {
            $this->db->where('i.id', $id);
        }
        $this->db->where('i.deleted_by', NULL);
        $this->db->where('i.is_lock', 1);
        if (strlen($searchVal)) {
            $searchCondition = "(
                    i.indent_no like '%$searchVal%'
                  )";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }

        // $this->db->where('tid.master_indent_id',1);      
        $this->db->from('tbl_indent i');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->result_array();
    }


    public function bladeData($id)
    {
        $this->db->select('tid.*,i.*,c.company_name as client_name,');
        $this->db->join('tbl_indent i', 'i.id= tid.indent_id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        if ($id) {
            $this->db->where('tid.id', $id);
        }
        // $this->db->where('ci.is_active',1);    
        // $this->db->where('v.deleted_by', NULL);
        $this->db->from('tbl_indent_details tid');
        $query = $this->db->get();

        return $query->result_array();
    }



    public function getIndentName($searchTerm = '')
    {
        $this->db->select('mi.*');
        $this->db->from('tbl_master_indent_for mi');
        // $this->db->where('cm.is_active',1);

        if ($searchTerm) {
            $searchCondition = "(
                    mi.indent_name like '%$searchTerm%'
                 )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
            ->result_array();
        return $result;
    }




    public function getclientName($searchTerm = '', $where = '')
    {
        $this->db->select('c.*');
        $this->db->from('tbl_customer c');
        if ($where) {
            $this->db->where($where);
        }

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


    public function getmouldsize($searchTerm = '', $where = '')
    {
        $this->db->select('bms.*');
        $this->db->from('tbl_master_indent_blade_mould_size bms');
        if ($where) {
            $this->db->where($where);
        }

        if ($searchTerm) {
            $searchCondition = "(
                   bms.name like '%$searchTerm%'
                 )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
            ->result_array();
        return $result;
    }



    public function get_a_tip($searchTerm = '', $where = '')
    {
        $this->db->select('at.*');
        $this->db->from('tbl_master_indent_blade_a_tip at');
        if ($where) {
            $this->db->where($where);
        }

        if ($searchTerm) {
            $searchCondition = "(
                   at.name like '%$searchTerm%'
                 )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function indentDetails($id,$blade_indent_id='')
    {
        // Step 1: Fetch the db_table_name
        $this->db->select('tmi.db_table_name');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->where('i.id', $id);
        $this->db->from('tbl_indent i');
        $query = $this->db->get();
        $result = $query->row_array();
        // echo $this->db->last_query();die;
        if (!$result) {
            // Handle case where no result is found
            return [];
        }

        $db_table_name = $result['db_table_name'];

        // Step 2: Construct and execute the dynamic query
        $this->db->select("i.*, tid.master_indent_id, tid.ref_id, tmi.db_table_name,tb.mould_size,tb.blade_size,tb.blade_qty,tb.blade_punching_no,tb.a_tip,tb.color,tb.name_plate");
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id'); // Use dynamic table name
        $this->db->where("i.id", $id);
       
        if(isset($blade_indent_id)){
            $this->db->where("tid.ref_id", $blade_indent_id);
        }
        $this->db->from('tbl_indent i');


       
        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        return $result;
    }

    public function indentOrderDetails($id)
    {
            $this->db->select("tio.*");
            $this->db->where("tio.id",$id);
            $this->db->join("tbl_indent_order_status tios",'tios.order_id=tio.id','left');
            $this->db->from('tbl_indent_order tio');
            $result = $this->db->get()->result_array();

        return $result;
    }

    public function orderStatus($id)
    {
        // $this->db->select('iosd.id, iosd.order_id, iosd.status_id, SUM(iosd.qty) as sumQty, DATE(iosd.date) as date');
        $this->db->select('iosd.id, iosd.order_id, iosd.status_id, iosd.qty, DATE(iosd.date) as date');
        $this->db->from('tbl_indent_order_status_details iosd');
        $this->db->where('iosd.order_id', $id);
        $this->db->where('iosd.status_id !=', 13);
        $this->db->order_by('iosd.id','DESC');
        // $this->db->group_by('iosd.status_id');
        // $this->db->group_by('iosd.date');
        
        $result = $this->db->get()->result_array();
    // echo $this->db->last_query();die;
        return $result;
    }
    
}
