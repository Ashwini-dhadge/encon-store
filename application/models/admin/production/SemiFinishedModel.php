<?php

use function PHPSTORM_META\type;

class SemiFinishedModel extends CI_Model
{

    protected $dt_Column = array(
        '',
        '',
        '',
        '',

    );


    public function getSemifinishedOrderLists($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select("tio.*,ios.order_qty,ios.transfer_qty,ios.gap_checking_qty,ios.primer_qty,ios.filler_qty,ios.putty_qty,ios.top_coat_qty,ios.balancing_qty,ios.packing_qty,ios.dispatch_qty, tc.company_name");
        // $this->db->select("tio.*,ios.*");
        $this->db->join("tbl_indent_order_status ios", 'ios.order_id=tio.id', 'left');
        $this->db->join('tbl_customer tc', 'tc.id=tio.party_id', 'left');
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
        $this->db->where('ios.transfer_qty !=', 0);
        $this->db->from('tbl_indent_order tio');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function indentDetails($id)
    {
        $this->db->select("tio.*,tios.created_qty,tios.blade_in_hand_qty,tios.blade_position_qty,tios.transfer_qty,tios.gap_checking_qty,tios.primer_qty,tios.filler_qty,tios.putty_qty,tios.top_coat_qty,tios.balancing_qty,tios.packing_qty,tios.dispatch_qty");
        $this->db->join("tbl_indent_order_status tios", "tios.order_id=tio.id");
        $this->db->where("tio.id", $id);
        $this->db->from('tbl_indent_order tio');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getMouldSize($searchTerm = '', $mouldsize = '', $orderId = "", $type = "", $manualIndentNo="",$interChange="",$bladeSize="",$aTip="")
    {

       
        $this->db->distinct();
        $this->db->select('tio.manual_indent_no');
        $this->db->from('tbl_indent_order tio');
        if ($mouldsize) {
            $this->db->where('tio.mould_size', $mouldsize);
        }
         // if ($searchTerm) {
        //     $this->db->like('tio.mould_size', $searchTerm);
        // }

        if ($manualIndentNo) {
        $this->db->where('tio.manual_indent_no !=', $manualIndentNo);
        // $this->db->where('tio.id !=', $orderId);
        }
        if($interChange == 3){
            // $this->db->where('order_qty',$orderQuty);
            $this->db->where('mould_size',$mouldsize);
            $this->db->where('a_tip',$aTip);
            $this->db->where('blade_size',$bladeSize);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getsubIndent($searchTerm = '', $manualIndentNo = '', $mouldsize = "", $type ='',$interChange="",$bladeSize="",$aTip="")
    {
        $this->db->select('tio.order_no,tio.id');
        $this->db->join('tbl_indent_order_status tios', 'tios.order_id=tio.id');
        $this->db->from('tbl_indent_order tio');
        if ($searchTerm) {
            $this->db->like('tio.order_no', $searchTerm);
        }
        // $this->db->where('tio.manual_indent_no', $manualIndentNo);
        $this->db->where('tio.order_sequence !=', 0);
        $this->db->where('tio.mould_size', $mouldsize);
        $this->db->where('tio.manual_indent_no ', $manualIndentNo);

        $this->db->where('tio.deleted_by', NULL);
        if($type == 1) {
        $this->db->group_start() 
         ->where('tios.created_qty >=', 1)
         ->or_where('tios.blade_in_hand_qty >=', 1)
         ->or_where('tios.blade_position_qty >=', 1)
         ->group_end(); 
        }
        if($type == 2) {
            $this->db->group_start() 
         ->where('tios.gap_checking_qty >=', 1)
         ->or_where('tios.primer_qty >=', 1)
         ->or_where('tios.filler_qty >=', 1)
         ->or_where('tios.putty_qty >=', 1)
         ->or_where('tios.top_coat_qty >=', 1)
         ->or_where('tios.balancing_qty >=', 1)
         ->or_where('tios.packing_qty >=', 1)
         ->group_end(); 
        }
        if($interChange == 3){
            // $this->db->where('order_qty',$orderQuty);
            $this->db->where('mould_size',$mouldsize);
            $this->db->where('a_tip',$aTip);
            $this->db->where('blade_size',$bladeSize);
        }

        $result = $this->db->get()->result_array();
        return $result;
    }
}

  // $this->db->where('(COALESCE(tios.created_qty, 0) >= 1 
        // OR COALESCE(tios.blade_in_hand_qty, 0) >= 1 
        // OR COALESCE(tios.blade_position_qty, 0) >= 1)', NULL, FALSE);