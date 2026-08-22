<?php

class FanStackModel extends CI_Model
{
    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );

    

    public function getdDimensionData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select('fd.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('fd.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(
                fd.name like '%$searchVal%'
                  )";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } //$this->db->where('u.is_deleted', 0);
         $this->db->where('fd.is_deleted', 0);
        $this->db->from('tbl_master_indent_fan_dimension fd');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    

    public function getHeightData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('fh.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('fh.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(fh.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);
         $this->db->where('fh.is_deleted', 0);
        $this->db->from('tbl_master_indent_fan_height fh');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getDimension($searchTerm = '')
    {
        $this->db->select('fd.*');

        $this->db->from('tbl_master_indent_fan_dimension fd');

        if ($searchTerm) {
            $searchCondition = "(
                fd.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $this->db->where('fd.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getHeight($searchTerm = '')
    {
        $this->db->select('fh.*');

        $this->db->from('tbl_master_indent_fan_height fh');

        if ($searchTerm) {
            $searchCondition = "(
                fh.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
         $this->db->where('fh.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


 
}
