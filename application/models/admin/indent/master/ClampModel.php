<?php

class ClampModel extends CI_Model
{
    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );

    public function getClampTypeData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('ct.*');
        if ($id) {
            $this->db->where('ct.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(ct.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_clamp_type ct');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('ct.is_deleted', 0);
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }




    public function getClampType($searchTerm = '')
    {
        $this->db->select('ct.*');

        $this->db->from('tbl_master_indent_clamp_type ct');

        if ($searchTerm) {
            $searchCondition = "(
                ct.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $this->db->where('ct.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getClampMaterialData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('cm.*');
        if ($id) {
            $this->db->where('cm.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(cm.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_clamp_material cm');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('cm.is_deleted', 0);
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getClampMaterial($searchTerm = '')
    {
        $this->db->select('cm.*');

        $this->db->from('tbl_master_indent_clamp_material cm');

        if ($searchTerm) {
            $searchCondition = "(
                ct.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $this->db->where('cm.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }
}
