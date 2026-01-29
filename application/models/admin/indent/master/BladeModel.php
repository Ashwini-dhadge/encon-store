<?php

class BladeModel extends CI_Model
{
    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );

    public function listMouldSize($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('bms.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('bms.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(bms.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);
        $this->db->where('bms.is_deleted', 0);
        $this->db->from('tbl_master_indent_blade_mould_size bms');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function a_TipModel($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('bt.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('bt.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(bt.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);
         $this->db->where('bt.is_deleted', 0);
        $this->db->from('tbl_master_indent_blade_a_tip bt');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function ColorModel($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('bc.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('bc.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(bc.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);
         $this->db->where('bc.is_deleted', 0);
        $this->db->from('tbl_master_indent_blade_color bc');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function SetModel($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('bs.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('bs.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(bs.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);
           $this->db->where('bs.is_deleted', 0);
        $this->db->from('tbl_master_indent_blade_set bs');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    // --------------------------------------         FOR SELECT 2   -------------------------------------------------------------------------------------------//
    public function getMouldSize($searchTerm = '')
    {
        $this->db->select('ms.*');

        $this->db->from('tbl_master_indent_blade_mould_size ms');

        if ($searchTerm) {
            $searchCondition = "(
                        ms.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
            $this->db->where('ms.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getTip($searchTerm = '')
    {
        $this->db->select('at.*');

        $this->db->from('tbl_master_indent_blade_a_tip at');

        if ($searchTerm) {
            $searchCondition = "(
                at.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $this->db->where('at.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getColor($searchTerm = '')
    {
        $this->db->select('bc.*');

        $this->db->from('tbl_master_indent_blade_color bc');

        if ($searchTerm) {
            $searchCondition = "(
                bc.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
         $this->db->where('bc.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }
}
