<?php
class ReceivedOrderModel extends CI_Model
{

    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );


    public function getReceivedOrders($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select("
        tio.*,
        ti.indent_number as manual_indent_no,
        ti.indent_no as indent_number,
        ios.order_qty,
        ios.blade_position_qty,
        ios.created_qty,
        ios.blade_in_hand_qty,
        ios.transfer_qty,
        ios.indent_transfer_qty, 
        tc.company_name,");
        // $this->db->select("tio.*,ios.*");
        $this->db->join("tbl_indent_order_status ios", 'ios.order_id=tio.id', 'left');
        $this->db->join('tbl_customer tc', 'tc.id=tio.party_id', 'left');
        $this->db->join('tbl_indent ti', 'ti.id=tio.indent_id', 'left');
        if ($id) {
            // $this->db->where('ti.id', $id);
        }
        if (strlen($searchVal)) {
            // $searchCondition = "(
            //         ti.tbl_indent like '%$searchVal%'
            //       )";
            // $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }
        // $this->db->where('tio.order_for', 2);
        $this->db->from('tbl_indent_order tio');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }

    // public function indentDetails($id)
    // {
    //         $this->db->select("tio.*");
    //         $this->db->where("id", $id);
    //         $this->db->from('tbl_indent_order tio');
    //         $query = $this->db->get();
    //         return $query->row_array();  
    // }

    public function indentDetails($id)
    {
        $this->db->select("tio.*,tios.created_qty,tios.blade_in_hand_qty,tios.blade_position_qty,tios.transfer_qty,tios.indent_transfer_qty");
        $this->db->join("tbl_indent_order_status tios", "tios.order_id=tio.id");
        $this->db->where("tio.id", $id);
        $this->db->from('tbl_indent_order tio');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getBladeStockReport()
    {
        $this->db->select("tio.order_for,tio.indent_date,tio.delivery_date,tio.dispatch_plan_date,tio.fan_dia_feet,tio.indent_id,tio.mould_size,tio.hub_size,tio.blade_size,tio.blade_punching_no,tio.a_tip,tio.way,tio.order_set,tio.blade_qty,tios.created_qty,tios.order_qty,tios.blade_in_hand_qty,tios.blade_position_qty,tios.transfer_qty,tios.gap_checking_qty,tios.primer_qty,tios.filler_qty,tios.putty_qty,tios.top_coat_qty,tios.balancing_qty,tios.packing_qty,tios.dispatch_qty,tc.company_name,tcm.name as location_name");
        $this->db->join("tbl_indent_order_status tios", "tios.order_id=tio.id");
        $this->db->join('tbl_customer tc', 'tc.id=tio.party_id', 'left');
        $this->db->join('tbl_company_master tcm', 'tcm.id=tios.company_id', 'left');
        $this->db->from('tbl_indent_order tio');
        $this->db->where('tio.deleted_by', NULL);

        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        return $result;
    }
    // public function getBladeStockReport()
    // {
    //     $this->db->select("tio.order_for,tio.indent_date,tio.delivery_date,tio.indent_id,tio.mould_size,tio.hub_size,tio.blade_size,tio.blade_punching_no,tio.a_tip,tio.way,tio.order_set,tio.blade_qty,tios.created_qty,tios.blade_in_hand_qty,tios.blade_position_qty,tios.transfer_qty,tc.company_name,tiosd.status_id,tiosd.qty");
    //     $this->db->join("tbl_indent_order_status tios", "tios.order_id=tio.id");
    //     $this->db->join("tbl_indent_order_status_details tiosd","tiosd.order_id=tio.id","left");
    //     $this->db->join('tbl_customer tc', 'tc.id=tio.party_id', 'left');
    //     $this->db->from('tbl_indent_order tio');

    //     $result = $this->db->get()->result_array();
    //     // echo $this->db->last_query();die;
    //     return $result;
    // }
}
