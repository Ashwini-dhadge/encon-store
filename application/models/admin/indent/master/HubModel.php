<?php

class HubModel extends CI_Model
{
    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );

    public function getHubData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('hs.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('hs.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(hs.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_hub_size hs');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('hs.is_deleted', 0);
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getPlateOd($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('po.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('po.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(po.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_hub_plate_od po');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
          $this->db->where('po.is_deleted', 0);
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getMaterialData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('hm.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('hm.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(hm.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_hub_material hm');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
          $this->db->where('hm.is_deleted', 0);
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getThicknessData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('ht.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('ht.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(ht.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_hub_thickness ht');
        $this->db->where('ht.is_deleted', 0);
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getHardwareData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = '', $where = '')
    {
        $this->db->select('hh.*');
        // $this->db->join('tbl_company_master c', 'c.id=s.company_id');
        if ($id) {
            $this->db->where('hh.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(hh.name LIKE '%$searchVal%')";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        } // $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_master_indent_hub_hardwares hh');
         $this->db->where('hh.is_deleted', 0);
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }







    /*------------------------------------------------------       Select2 calls    ------------------------------------------------------------------*/


    public function getHubSize($searchTerm = '')
    {
        $this->db->select('hs.*');

        $this->db->from('tbl_master_indent_hub_size hs');

        if ($searchTerm) {
            $searchCondition = "(
                hs.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $this->db->where('hs.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }

    public function getHardware($searchTerm = '')
    {
        $this->db->select('hh.*');

        $this->db->from('tbl_master_indent_hub_hardwares hh');

        if ($searchTerm) {
            $searchCondition = "(
                hh.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
         $this->db->where('hh.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getMarterial($searchTerm = '')
    {
        $this->db->select('hm.*');

        $this->db->from('tbl_master_indent_hub_material hm');

        if ($searchTerm) {
            $searchCondition = "(
                hm.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
         $this->db->where('hm.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getThickness($searchTerm = '')
    {
        $this->db->select('ht.*');

        $this->db->from('tbl_master_indent_hub_thickness ht');

        if ($searchTerm) {
            $searchCondition = "(
                ht.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
         $this->db->where('ht.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }


    public function getPlateOdData($searchTerm = '')
    {
        $this->db->select('po.*');

        $this->db->from('tbl_master_indent_hub_plate_od po');

        if ($searchTerm) {
            $searchCondition = "(
                po.name like '%$searchTerm%' 
                     )";
            $this->db->where($searchCondition);
        }
        $this->db->where('po.is_deleted', 0);
        $result = $this->db->get()
            ->result_array();
        return $result;
    }
}
