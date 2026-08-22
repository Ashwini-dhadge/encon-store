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
        // $this->db->join('tbl_indent_order tio', 'tio.indent_id = i.indent_no','right');


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
        // $this->db->group_by('tio.id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function getSum($indentNo)
    {
        // $this->db->select('SUM(tios.created_qty + tios.blade_in_hand_qty + tios.blade_position_qty) as totalQty');
        $this->db->select('tios.order_qty,SUM(COALESCE(tios.created_qty, 0) + COALESCE(tios.blade_in_hand_qty, 0) + COALESCE(tios.blade_position_qty, 0)) as totalQty');

        //  $this->db->join('tbl_indent_order tio','tio.indent_id=i.indent_no');
        $this->db->join('tbl_indent_order_status tios', 'tios.order_id=tio.id');
        $this->db->from('tbl_indent_order tio');
        $this->db->where('tio.indent_id', $indentNo);
        // $this->db->group_by('tio.indent_id');
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->row_array();
    }
    public function getBlade($indentNo)
    {

        $this->db->select('SUM(tios.created_qty + tios.blade_in_hand_qty + tios.blade_position_qty) as totalQty');
        $this->db->join('tbl_indent_order_status tios', 'tios.order_id=tio.id');
        $this->db->from('tbl_indent_order tio');
        $this->db->where('tio.indent_id', $indentNo);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->row_array();
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


    public function indentDetails($id, $blade_indent_id = '')
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
        // print_r($db_table_name);die;

        // Step 2: Construct and execute the dynamic query
        $this->db->select("i.*, 
        tid.indent_id,
        tid.master_indent_id, 
        tid.ref_id, 
        tmi.db_table_name,
        tb.mould_size,
        tb.blade_size,
        tb.hub_size,
        tb.clamp_size,
        tb.collor_length,
        tb.clamp_length,
        tb.collor_hub_dist,
        tb.fan_dia_mm,
        tb.fan_dia_ft,
        tb.blade_qty,
        tb.blade_punching_no,
        tb.a_tip,tb.color,
        tb.name_plate,
        tb.way,
        tb.set,
        c.company_name as client_name,
        c.id as company_id,
        tio.order_qty as order_qty
        ");
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_indent_order tio', 'tio.indent_id = i.id', 'left');
        $this->db->select_sum('tio.order_qty');
        $this->db->order_by('tio.id', 'DESC');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id');
        $this->db->order_by('i.id', 'DESC');
        $this->db->where("i.id", $id);


        if (isset($blade_indent_id)) {
            $this->db->where("tid.ref_id", $blade_indent_id);
        }
        $this->db->from('tbl_indent i');



        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        return $result;
    }

    // public function indentOrderDetails($id)
    // {
    //     $this->db->select("tio.*,tios.dispatch_qty,tios.transfer_qty,c.company_name as client_name");
    //     $this->db->where("tio.id", $id);
    //     $this->db->join("tbl_indent_order_status tios", 'tios.order_id=tio.id', 'left');
    //     $this->db->join('tbl_customer c', 'c.id= tio.party_id');
    //     $this->db->from('tbl_indent_order tio');
    //     $result = $this->db->get()->result_array();

    //     return $result;
    // }


    // public function orderStatus($indent_no) {
    //     $this->db->select("tio.id,tio.blade_qty,SUM(tios.created_qty) AS createdTotal, SUM(tios.blade_in_hand_qty) AS bladeHandTotal, SUM(tios.blade_position_qty) AS bladePositionTotal, SUM(tios.gap_checking_qty) AS gapTotal, SUM(tios.primer_qty) AS primerTotal, SUM(tios.filler_qty) AS fillerTotal, SUM(tios.putty_qty) AS puttyTotal, SUM(tios.top_coat_qty) AS topCoatTotal, SUM(tios.balancing_qty) AS balancingTotal, SUM(tios.packing_qty) AS packingTotal");
    //     $this->db->where("tio.indent_id", $indent_no);
    //     $this->db->join('tbl_indent_order_status tios','tios.order_id=tio.id');
    //     // $this->db->group_by('tio.indent_id');

    //     $this->db->from('tbl_indent_order tio');
    //     $result = $this->db->get()->row_array();


    //     return $result;
    // }

    // public function subOrders($indent_no) {
    //     $this->db->select('tio.order_no,tios.order_qty,tios.created_qty,tios.blade_in_hand_qty,tios.blade_position_qty,tios.gap_checking_qty,tios.primer_qty,tios.filler_qty,tios.putty_qty,tios.top_coat_qty,tios.balancing_qty,tios.packing_qty');
    //     $this->db->join('tbl_indent_order_status tios','tios.id=tio.id');
    //     $this->db->where('tio.indent_id',$indent_no);
    //     // $this->db->where('tio.order_sequence !=',0);
    //     $this->db->from('tbl_indent_order tio');
    //     $result = $this->db->get()->result_array();
    //     return $result;

    // }
    public function indentOrderDetails($id)
    {
        $this->db->select("tio.*,,c.company_name as client_name");
        $this->db->where("tio.id", $id);
        $this->db->join("tbl_indent_order_status tios", 'tios.order_id=tio.id', 'left');
        $this->db->join('tbl_customer c', 'c.id= tio.party_id');
        $this->db->from('tbl_indent_order tio');
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function cfdsrOrderDetails($id)
    {
        $this->db->select("
            ticfdsr.id as ord_no, 
            ti.indent_no,
            ti.indent_number,
            ti.date as indent_date,
            ti.delivery_date,
            ticfdsr.id as indent_id,
            ticfdsr.manual_indent_no,
            ticfds.dimension,
            ticfds.material,
            ticfds.make,
            ticfds.remark,
            ts.site_name,
            tcm.name as client_name,
            ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_carbon_fiber_drive_shaft_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_carbon_fiber_drive_shift ticfds", 'ticfds.indent_id=ti.id', 'left');
        $this->db->join("tbl_site ts", 'ts.id=ti.plant_id', 'left');
        $this->db->join("tbl_customer tc", 'tc.id=ti.client_id', 'left');
        $this->db->join("tbl_company_master tcm", 'tcm.id=tc.company_id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function frpheaderpipeOrderDetails($id)
    {
        $this->db->select("
            ticfdsr.id as ord_no, 
            ti.indent_no,
            ti.date as indent_date,
            ti.delivery_date,
            ticfdsr.id as indent_id,
            ticfdsr.manual_indent_no,
            ticfdsr.order_qty,
            ticfds.dimension,
            ticfds.material,
            ticfds.make,
            ticfds.remark,
            ts.site_name,
            tcm.name as client_name,
            ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_frp_header_pipe_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_frp_header_pipe ticfds", 'ticfds.indent_id=ti.id', 'left');
        $this->db->join("tbl_site ts", 'ts.id=ti.plant_id', 'left');
        $this->db->join("tbl_customer tc", 'tc.id=ti.client_id', 'left');
        $this->db->join("tbl_company_master tcm", 'tcm.id=tc.company_id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function cfdsrSpecifications($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        tcfdss.*,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_carbon_fiber_drive_shaft_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_carbon_fiber_drive_shaft_specifications tcfdss", 'tcfdss.indent_id=ti.id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function frpheaderpipeSpecifications($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        ticfdsr.total_order_qty,
        tcfdss.*,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_frp_header_pipe_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_frp_header_pipe_specifications tcfdss", 'tcfdss.indent_id=ti.id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function cfdsrOrderStatusDetails($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        ticfdsrosd.*,
        tcsm.stage_name as status,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_carbon_fiber_drive_shaft_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail ticfdsrosd", 'ticfdsrosd.order_id=ticfdsr.id', 'left');
        $this->db->join("tbl_cfds_stage_master tcsm", "tcsm.id=ticfdsrosd.status_id", 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function frpheaderpipeOrderStatusDetails($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        ticfdsrosd.*,
        tcsm.stage_name as status,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_frp_header_pipe_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_frp_header_pipe_received_order_status_detail ticfdsrosd", 'ticfdsrosd.order_id=ticfdsr.id', 'left');
        $this->db->join("tbl_frp_header_pipe_stage_master tcsm", "tcsm.id=ticfdsrosd.status_id", 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }


    public function getIndentStatusData($order_id)
    {
        $this->db->select("
        ticfdsrosd.*,
        tcsm.stage_name as status,
        ");
        $this->db->from("tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail ticfdsrosd");
        $this->db->where("ticfdsrosd.order_id", $order_id);
        $this->db->join("tbl_cfds_stage_master tcsm", "tcsm.id=ticfdsrosd.status_id", 'left');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getcfdsIndentStatuslist()
    {
        $this->db->from("tbl_cfds_stage_master tcsm");
        $this->db->select("tcsm.id as status_id, tcsm.stage_name");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function orderStatus($id)
    {
        // $this->db->select('iosd.id, iosd.order_id, iosd.status_id, SUM(iosd.qty) as sumQty, DATE(iosd.date) as date');
        $this->db->select('iosd.id, iosd.order_id, iosd.status_id, iosd.qty, DATE(iosd.date) as date,tp.plant_narration as plant_name');
        $this->db->join('tbl_plant tp', 'tp.id=iosd.company_id');
        $this->db->from('tbl_indent_order_status_details iosd');
        $this->db->where('iosd.order_id', $id);
        $this->db->where('iosd.status_id !=', 13);
        $this->db->order_by('iosd.status_id', 'ASC');
        // $this->db->group_by('iosd.status_id');
        // $this->db->group_by('iosd.date');

        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();die;
        return $result;
    }







    public function getOrderQty($indent_no)
    {
        $this->db->select('SUM(tios.order_qty) as orderQty');
        $this->db->join('tbl_indent_order_status tios', 'tios.order_id=tio.id');
        $this->db->from('tbl_indent_order tio');
        $this->db->where('tio.indent_id', $indent_no);
        $result = $this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $result;
    }



    public function indentOrderDetailsi($indent_no)
    {
        $this->db->select("tio.*,tios.dispatch_qty,tios.transfer_qty,c.company_name as client_name");
        $this->db->where("tio.indent_id", $indent_no);
        $this->db->join("tbl_indent_order_status tios", 'tios.order_id=tio.id', 'left');
        $this->db->join('tbl_customer c', 'c.id= tio.party_id');
        $this->db->from('tbl_indent_order tio');
        $this->db->group_by('tio.indent_id');
        $result = $this->db->get()->result_array();

        return $result;
    }


    public function orderStatusi($indent_no)
    {
        $this->db->select("tio.id,tio.blade_qty,SUM(tios.created_qty) AS createdTotal, SUM(tios.blade_in_hand_qty) AS bladeHandTotal, SUM(tios.blade_position_qty) AS bladePositionTotal, SUM(tios.gap_checking_qty) AS gapTotal, SUM(tios.primer_qty) AS primerTotal, SUM(tios.filler_qty) AS fillerTotal, SUM(tios.putty_qty) AS puttyTotal, SUM(tios.top_coat_qty) AS topCoatTotal, SUM(tios.balancing_qty) AS balancingTotal, SUM(tios.packing_qty) AS packingTotal");
        $this->db->where("tio.indent_id", $indent_no);
        $this->db->join('tbl_indent_order_status tios', 'tios.order_id=tio.id');
        // $this->db->group_by('tio.indent_id');

        $this->db->from('tbl_indent_order tio');
        $result = $this->db->get()->row_array();


        return $result;
    }

    public function subOrdersi($indent_no)
    {
        $this->db->select('tio.order_no,tios.order_qty,tios.created_qty,tios.blade_in_hand_qty,tios.blade_position_qty,tios.gap_checking_qty,tios.primer_qty,tios.filler_qty,tios.putty_qty,tios.top_coat_qty,tios.balancing_qty,tios.packing_qty');
        $this->db->join('tbl_indent_order_status tios', 'tios.id=tio.id');
        $this->db->where('tio.indent_id', $indent_no);
        // $this->db->where('tio.order_sequence !=',0);
        $this->db->from('tbl_indent_order tio');
        $result = $this->db->get()->result_array();
        return $result;
    }

    //for carbon fiber drive shaft indent

    function getcfdsIndentData(
        $searchVal = '',
        $sortColIndex = 0,
        $sortBy = 'DESC',
        $limit = 0,
        $offset = 0,
        $count = 0,
        $where = [],
        $from_date = '',
        $to_date = '',
        $id = '',
    ) {

        $this->db->select('i.*,tid.*,c.company_name as client_name,  p.plant_narration,tid.ref_id as indent_bland_id');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id= i.id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        $this->db->join('tbl_plant p', 'p.id = i.plant_id');
        // $this->db->join('tbl_indent_order tio', 'tio.indent_id = i.indent_no','right');


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

        if (!empty($from_date)) {
            $this->db->where('i.date >=', $from_date);
        }

        if (!empty($to_date)) {
            $this->db->where('i.date <=', $to_date);
        }

        // $this->db->where('tid.master_indent_id',1);      
        $this->db->from('tbl_indent i');
        // $this->db->group_by('tio.id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->result_array();
    }
    // public function indentDetailsforcfds($id, $blade_indent_id = '')
    // {
    //     // Step 1: Fetch the db_table_name
    //     $this->db->select('tmi.db_table_name');
    //     $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
    //     $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
    //     $this->db->where('i.id', $id);
    //     $this->db->from('tbl_indent i');
    //     $query = $this->db->get();
    //     $result = $query->row_array();
    //     // echo $this->db->last_query();die;

    //     if (!$result) {
    //         // Handle case where no result is found
    //         return [];
    //     }

    //     $db_table_name = $result['db_table_name'];
    //     // print_r($db_table_name);die;

    //     // Step 2: Construct and execute the dynamic query
    //     $this->db->select("i.*, tid.master_indent_id, tid.ref_id, tmi.db_table_name,c.company_name as client_name,c.id as company_id,
    //     tb.dimension,tb.material,tb.remark,tb.qty,tb.make
    //     ");
    //     $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
    //     $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
    //     $this->db->join('tbl_customer c', 'c.id= i.client_id');
    //     $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id'); 
    //     $this->db->where("i.id", $id);

    //     if (isset($blade_indent_id)) {
    //         $this->db->where("tid.ref_id", $blade_indent_id);
    //     }
    //     $this->db->from('tbl_indent i');



    //     $result = $this->db->get()->result_array();
    //     // echo $this->db->last_query();die;
    //     return $result;
    // }

    public function indentDetailsforcfds($id, $blade_indent_id = '')
    {
        $this->db->select('tmi.db_table_name');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->where('i.id', $id);
        $this->db->from('tbl_indent i');

        $result = $this->db->get()->row_array();

        if (!$result) return [];

        $db_table_name = $result['db_table_name'];

        $this->db->select("
        i.*, 
        tid.master_indent_id, 
        tid.ref_id, 
        tmi.db_table_name,
        c.company_name as client_name,
        c.id as company_id,
        tb.dimension,
        tb.material,
        tb.remark,
        tb.qty,
        tb.make,
        tcfds.id as order_id,
        ticfds.design_file,
        ticfds.remark,
    ");

        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->join('tbl_indent_carbon_fiber_drive_shift ticfds', 'ticfds.indent_id = i.id');
        $this->db->join('tbl_customer c', 'c.id = i.client_id');
        $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id');
        $this->db->join('tbl_indent_carbon_fiber_drive_shaft_received_orders tcfds', 'tcfds.indent_id = i.id');


        $this->db->where("i.id", $id);

        if (!empty($blade_indent_id)) {
            $this->db->where("tid.ref_id", $blade_indent_id);
        }

        $this->db->from('tbl_indent i');

        $mainData = $this->db->get()->row_array();

        if (!$mainData) return [];

        $specs = $this->db
            ->where('indent_sub_id', $mainData['ref_id'])
            ->get('tbl_carbon_fiber_drive_shaft_specifications')
            ->result_array();

        if (!empty($specs)) {
            foreach ($specs as &$s) {
                $s['bore']   = !empty($s['bore']) ? json_decode($s['bore'], true) : [];
                $s['keyway'] = !empty($s['keyway']) ? json_decode($s['keyway'], true) : [];
            }
        }

        $mainData['specifications'] = $specs;

        return $mainData;
    }

    public function indentDetailsforfrphp($id, $blade_indent_id = '')
    {
        $this->db->select('tmi.db_table_name');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->where('i.id', $id);
        $this->db->from('tbl_indent i');

        $result = $this->db->get()->row_array();

        if (!$result) return [];

        $db_table_name = $result['db_table_name'];

        $this->db->select("
        i.*, 
        tid.master_indent_id, 
        tid.ref_id, 
        tmi.db_table_name,
        c.company_name as client_name,
        c.id as company_id,
        tifrphp.dimension,
        tifrphp.material,
        tifrphp.remark,
        tifrphp.qty,
        tifrphp.make,
        tifrphp.design_file,
        tcfds.id as order_id,
    ");

        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->join('tbl_indent_frp_header_pipe tifrphp', 'tifrphp.indent_id = i.id');
        $this->db->join('tbl_customer c', 'c.id = i.client_id');
        $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id');
        $this->db->join('tbl_indent_frp_header_pipe_received_orders tcfds', 'tcfds.indent_id = i.id');


        $this->db->where("i.id", $id);

        if (!empty($blade_indent_id)) {
            $this->db->where("tid.ref_id", $blade_indent_id);
        }

        $this->db->from('tbl_indent i');

        $mainData = $this->db->get()->row_array();

        if (!$mainData) return [];

        $specs = $this->db
            ->where('indent_sub_id', $mainData['ref_id'])
            ->get('tbl_frp_header_pipe_specifications')
            ->result_array();

        if (!empty($specs)) {
            foreach ($specs as &$s) {
                $s['bore']   = !empty($s['bore']) ? json_decode($s['bore'], true) : [];
                $s['keyway'] = !empty($s['keyway']) ? json_decode($s['keyway'], true) : [];
            }
        }

        $mainData['specifications'] = $specs;

        return $mainData;
    }

    //end carbon fiber drive shaft indent

    //for header pipe indent

    public function getheaderpipeIndentData(
        $searchVal = '',
        $sortColIndex = 0,
        $sortBy = 'DESC',
        $limit = 0,
        $offset = 0,
        $count = 0,
        $where = [],
        $from_date = '',
        $to_date = '',
        $id = '',
    ) {

        $this->db->select('i.*,tid.*,c.company_name as client_name,  p.plant_narration,tid.ref_id as indent_bland_id');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id= i.id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        $this->db->join('tbl_plant p', 'p.id = i.plant_id');
        // $this->db->join('tbl_indent_order tio', 'tio.indent_id = i.indent_no','right');
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

        if (!empty($from_date)) {
            $this->db->where('i.date >=', $from_date);
        }

        if (!empty($to_date)) {
            $this->db->where('i.date <=', $to_date);
        }

        // $this->db->where('tid.master_indent_id',1);      
        $this->db->from('tbl_indent i');
        // $this->db->group_by('tio.id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function getClampIndentData(
        $searchVal = '',
        $sortColIndex = 0,
        $sortBy = 'DESC',
        $limit = 0,
        $offset = 0,
        $count = 0,
        $where = [],
        $from_date = '',
        $to_date = '',
        $id = '',
    ) {

        $this->db->select('i.*,tid.*,c.company_name as client_name,  p.plant_narration,tid.ref_id as indent_bland_id');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id= i.id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        $this->db->join('tbl_plant p', 'p.id = i.plant_id');
        // $this->db->join('tbl_indent_order tio', 'tio.indent_id = i.indent_no','right');
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

        if (!empty($from_date)) {
            $this->db->where('i.date >=', $from_date);
        }

        if (!empty($to_date)) {
            $this->db->where('i.date <=', $to_date);
        }

        // $this->db->where('tid.master_indent_id',1);      
        $this->db->from('tbl_indent i');
        // $this->db->group_by('tio.id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->result_array();
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
    // public function getindentNumber()
    // {
    //     $this->db->select('id, indent_sequence');
    //     $this->db->from('tbl_indent');
    //     $this->db->order_by('id', 'DESC');
    //     $row = $this->db->get()->row_array();

    //     if ($row) {
    //         if (!empty($row['indent_sequence'])) {
    //             $indent_number = $row['indent_sequence'] + 1;
    //         } else {
    //             $indent_number = $row['id'] + 1;
    //         }
    //     } else {
    //         $indent_number = 1;
    //     }

    //     $indent_no = userId('site_inital') . "-" . $indent_number;
    //     return $indent_no;
    // }

    public function getIndentDetails($indent_no = '')
    {
        $this->db->select('
        i.*,
        ticfds.id as module_id,
        ticfds.dimension,
        ticfds.material,
        ticfds.remark,
        ticfds.qty,
        ticfds.make
    ');
        $this->db->from('tbl_indent i');
        $this->db->join('tbl_indent_carbon_fiber_drive_shift ticfds', 'ticfds.indent_id = i.id', 'left');
        $this->db->where('i.indent_no', $indent_no);

        $indent = $this->db->get()->row_array();

        if (!$indent) return [];

        $this->db->select('*');
        $this->db->from('tbl_carbon_fiber_drive_shaft_specifications');
        $this->db->where('indent_sub_id', $indent['module_id']);

        $specs = $this->db->get()->result_array();

        $indent['specifications'] = $specs;

        return $indent;
    }

    public function getcdfsExportIndentDetails($indent_no = '')
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        ticfds.id as module_id,
        ticfds.dimension,
        ticfds.material,
        ticfds.remark,
        ticfds.qty,
        ticfds.make,

        spec.*
    ");

        $this->db->from('tbl_indent i');

        // CFDS MODULE
        $this->db->join(
            'tbl_indent_carbon_fiber_drive_shift ticfds',
            'ticfds.indent_id = i.id',
            'left'
        );

        // CUSTOMER
        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        // ACTUAL CLIENT / COMPANY
        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        // SPECIFICATIONS
        $this->db->join(
            'tbl_carbon_fiber_drive_shaft_specifications spec',
            'spec.indent_sub_id = ticfds.id',
            'left'
        );

        $this->db->where('i.indent_no', $indent_no);

        return $this->db->get()->result_array();
    }

    public function getcdfsExportIndentDetailsSelected($indentNos = [])
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        ticfds.id as module_id,
        ticfds.dimension,
        ticfds.material,
        ticfds.remark,
        ticfds.qty,
        ticfds.make,

        spec.*
    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_carbon_fiber_drive_shift ticfds',
            'ticfds.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        $this->db->join(
            'tbl_carbon_fiber_drive_shaft_specifications spec',
            'spec.indent_sub_id = ticfds.id',
            'left'
        );

        $this->db->where_in('i.indent_no', $indentNos);

        return $this->db->get()->result_array();
    }

    public function getCFDSorderStatusData($searchVal = '', $limit = 10, $offset = 0)
    {
        $this->db->select("
        i.id as indent_main_id,
        i.indent_no,
        ticfds.id,
        ticfds.order_for,
        ticfds.indent_id,
        ticfds.manual_indent_no,
        ticfds.indent_date,
        ticfds.total_order_qty,
        ticfds.order_qty,
        cm.name as company_name,
        tcfdss.tube_od_thk,

        MAX(CASE WHEN ticfdsod.status_id = 1 THEN ticfdsod.qty END) as design,
        MAX(CASE WHEN ticfdsod.status_id = 2 THEN ticfdsod.qty END) as filament,
        MAX(CASE WHEN ticfdsod.status_id = 3 THEN ticfdsod.qty END) as bonding,
        MAX(CASE WHEN ticfdsod.status_id = 4 THEN ticfdsod.qty END) as torque,
        MAX(CASE WHEN ticfdsod.status_id = 5 THEN ticfdsod.qty END) as balancing,
        MAX(CASE WHEN ticfdsod.status_id = 6 THEN ticfdsod.qty END) as inspection,
        MAX(CASE WHEN ticfdsod.status_id = 7 THEN ticfdsod.qty END) as packaging,
        MAX(CASE WHEN ticfdsod.status_id = 8 THEN ticfdsod.qty END) as dispatch
    ");

        $this->db->from('tbl_indent i');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_carbon_fiber_drive_shaft_received_orders ticfds', 'ticfds.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail ticfdsod', 'ticfdsod.order_id = ticfds.id', 'left');
        $this->db->join('tbl_indent_carbon_fiber_drive_shaft_received_order_status ticfdsros', 'ticfdsros.order_id = ticfds.id', 'left');
        $this->db->join('tbl_company_master cm', 'cm.id = ticfdsros.company_id', 'left');
        $this->db->join('tbl_carbon_fiber_drive_shaft_specifications tcfdss', 'tcfdss.indent_id = i.id', 'left');

        $this->db->where('i.deleted_by', NULL);
        $this->db->where('i.is_lock', 1);
        $this->db->where('tid.master_indent_id', 7);

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like('i.indent_no', $searchVal);
            $this->db->or_like('ticfds.manual_indent_no', $searchVal);
            $this->db->group_end();
        }

        $this->db->group_by('ticfds.id');
        $this->db->order_by('ticfds.id', 'DESC');

        if ($limit != -1) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    public function getStageDataByOrder($order_id)
    {
        $this->db->select("
        ticfdsod.status_id,
        ticfdsod.qty,
        ticfds.order_qty,
        ticfdsod.remark,
        ticfdss.tube_od_thk,
        ticfdsod.order_id
    ");

        $this->db->from('tbl_indent_carbon_fiber_drive_shaft_received_order_status_detail ticfdsod');

        $this->db->join(
            'tbl_indent_carbon_fiber_drive_shaft_received_orders ticfds',
            'ticfds.id = ticfdsod.order_id',
            'left'
        );

        $this->db->join(
            'tbl_carbon_fiber_drive_shaft_specifications ticfdss',
            'ticfdss.indent_sub_id = ticfds.indent_id',
            'left'
        );

        $this->db->where('ticfdsod.order_id', $order_id);

        $result = $this->db->get()->result_array();

        $final = [
            'stages'       => [],
            'tube_od_thk'  => '',
            'order_id'     => $order_id,
            'order_qty'    => 0
        ];

        foreach ($result as $row) {

            $final['stages'][$row['status_id']] = [
                'qty'    => $row['qty'],
                'remark' => $row['remark']
            ];

            $final['order_qty'] = $row['order_qty'];

            if (!empty($row['tube_od_thk'])) {
                $final['tube_od_thk'] = $row['tube_od_thk'];
            }
        }

        return $final;
    }

    public function getFRPHPipeStageData($order_id)
    {
        $this->db->select("
        ticfdsod.status_id,
        ticfdsod.qty,
        ticfdsod.remark,
        ticfdsod.order_id,
        ticfds.order_qty,
    ");

        $this->db->from('tbl_indent_frp_header_pipe_received_order_status_detail ticfdsod');

        $this->db->join(
            'tbl_indent_frp_header_pipe_received_orders ticfds',
            'ticfds.id = ticfdsod.order_id',
            'left'
        );

        $this->db->join(
            'tbl_frp_header_pipe_specifications ticfdss',
            'ticfdss.indent_sub_id = ticfds.indent_id',
            'left'
        );
        $this->db->where('ticfdsod.order_id', $order_id);

        $result = $this->db->get()->result_array();
        $final = [
            'stages' => [],
            'order_id' => $order_id,
            'order_qty' => 0
        ];
        foreach ($result as $row) {
            $final['stages'][$row['status_id']] = [
                'qty' => $row['qty'],
                'remark' => $row['remark']
            ];
        }

        return $final;
    }


    public function getFRPHPorderStatusData($searchVal = '', $limit = 10, $offset = 0, $master_indent_id = '')
    {
        $this->db->select("
            i.id as indent_main_id,
            i.indent_no,
            ticfds.id,
            ticfds.order_for,
            ticfds.indent_id,
            ticfds.manual_indent_no,
            ticfds.indent_date,
            ticfds.total_order_qty,
            ticfds.order_qty,
            tifhp.qty,
            cm.name as company_name,

            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 1 THEN ticfdsod.qty END), 0) as design,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 2 THEN ticfdsod.qty END), 0) as filament,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 3 THEN ticfdsod.qty END), 0) as size_cutting,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 4 THEN ticfdsod.qty END), 0) as flange_making,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 5 THEN ticfdsod.qty END), 0) as pipe_coupler_join,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 6 THEN ticfdsod.qty END), 0) as finishing,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 7 THEN ticfdsod.qty END), 0) as inspection,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 8 THEN ticfdsod.qty END), 0) as packaging,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 9 THEN ticfdsod.qty END), 0) as dispatch
        ");

        $this->db->from('tbl_indent i');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_frp_header_pipe tifhp', 'tifhp.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_frp_header_pipe_received_orders ticfds', 'ticfds.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_frp_header_pipe_received_order_status_detail ticfdsod', 'ticfdsod.order_id = ticfds.id', 'left');
        $this->db->join('tbl_indent_frp_header_pipe_received_order_status ticfdsros', 'ticfdsros.order_id = ticfds.id', 'left');
        $this->db->join('tbl_company_master cm', 'cm.id = ticfdsros.company_id', 'left');
        $this->db->join('tbl_frp_header_pipe_specifications tcfdss', 'tcfdss.indent_id = i.id', 'left');

        $this->db->where('i.deleted_by', NULL);
        $this->db->where('i.is_lock', 1);
        $this->db->where('tid.master_indent_id', 21);

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like('i.indent_no', $searchVal);
            $this->db->or_like('ticfds.manual_indent_no', $searchVal);
            $this->db->group_end();
        }

        $this->db->group_by('ticfds.id');
        $this->db->order_by('ticfds.id', 'DESC');

        if ($limit != -1) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    public function getfrphpExportIndentDetails($indent_no = '')
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.id as module_id,
        tifhp.dimension,
        tifhp.material,
        tifhp.remark,
        tifhp.qty,
        tifhp.make,

        spec.*
    ");

        $this->db->from('tbl_indent i');

        // CFDS MODULE
        $this->db->join(
            'tbl_indent_frp_header_pipe tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        // CUSTOMER
        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        // ACTUAL CLIENT / COMPANY
        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        // SPECIFICATIONS
        $this->db->join(
            'tbl_frp_header_pipe_specifications spec',
            'spec.indent_sub_id = tifhp.id',
            'left'
        );

        $this->db->where('i.indent_no', $indent_no);

        return $this->db->get()->result_array();
    }

    public function getfrphpExportIndentDetailsSelected($indentNos = [])
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.id as module_id,
        tifhp.dimension,
        tifhp.material,
        tifhp.remark,
        tifhp.qty,
        tifhp.make,

        spec.*
    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_frp_header_pipe tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        $this->db->join(
            'tbl_frp_header_pipe_specifications spec',
            'spec.indent_sub_id = tifhp.id',
            'left'
        );

        $this->db->where_in('i.indent_no', $indentNos);

        return $this->db->get()->result_array();
    }

    public function getFrpclampIndentData($searchVal = '', $sortColIndex = '0', $sortBy = 'desc', $limit = '0', $offset = '0', $id = '', $where = "")
    {

        $this->db->select('i.*,tid.*,c.company_name as client_name,  p.plant_narration,tid.ref_id as indent_bland_id');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id= i.id');
        $this->db->join('tbl_customer c', 'c.id= i.client_id');
        $this->db->join('tbl_plant p', 'p.id = i.plant_id');
        // $this->db->join('tbl_indent_order tio', 'tio.indent_id = i.indent_no','right');
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
        // $this->db->group_by('tio.id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //   echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function indentDetailsforfrpclamp($id, $blade_indent_id = '')
    {
        $this->db->select('tmi.db_table_name');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->where('i.id', $id);
        $this->db->from('tbl_indent i');

        $result = $this->db->get()->row_array();

        if (!$result)
            return [];

        $db_table_name = $result['db_table_name'];

        $this->db->select("
        i.*, 
        tid.master_indent_id, 
        tid.indent_id, 
        tid.ref_id, 
        tmi.db_table_name,
        c.company_name as client_name,
        c.id as company_id,
        tifc.clamp_size,
        tifc.material,
        tifc.remark,
        tifc.qty,
        tifc.make,
        tifcro.id as order_id,
        tifcro.total_order_qty,
        tifcro.order_qty,
        spec.*
    ");

        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->join('tbl_indent_frp_clamp tifc', 'tifc.indent_id = i.id');
        $this->db->join('tbl_customer c', 'c.id = i.client_id');
        $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id');
        $this->db->join(
            '(SELECT *
                FROM tbl_indent_frp_clamp_received_orders
                WHERE id IN (
                    SELECT MAX(id)
                    FROM tbl_indent_frp_clamp_received_orders
                    GROUP BY indent_id
                )
                ) tifcro',
            'tifcro.indent_id = i.id',
            'left'
        );
        $this->db->join('tbl_frp_clamp_specifications spec', 'spec.indent_id = tifc.indent_id');


        $this->db->where("i.id", $id);

        if (!empty($blade_indent_id)) {
            $this->db->where("tid.ref_id", $blade_indent_id);
        }

        $this->db->from('tbl_indent i');

        $mainData = $this->db->get()->row_array();

        if (!$mainData)
            return [];
        return $mainData;
    }

    public function getFRPClamporderStatusData($searchVal = '', $limit = 10, $offset = 0, $master_indent_id = '')
    {
        $this->db->select("
            i.id as indent_main_id,
            i.indent_no,
            ticfds.id,
            ticfds.order_for,
            ticfds.indent_id,
            ticfds.manual_indent_no,
            ticfds.indent_date,
            ticfds.total_order_qty,
            ticfds.order_qty,
            tc.company_name as company_name,

            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 1 THEN ticfdsod.qty END), 0) as under_finishing,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 2 THEN ticfdsod.qty END), 0) as finishing,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 3 THEN ticfdsod.qty END), 0) as paintaing,
            COALESCE(MAX(CASE WHEN ticfdsod.status_id = 4 THEN ticfdsod.qty END), 0) as dispatch,
        ");

        $this->db->from('tbl_indent i');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_frp_clamp_received_orders ticfds', 'ticfds.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_frp_clamp_received_order_status_detail ticfdsod', 'ticfdsod.order_id = ticfds.id', 'left');
        $this->db->join('tbl_indent_frp_clamp_received_order_status ticfdsros', 'ticfdsros.order_id = ticfds.id', 'left');
        $this->db->join('tbl_customer tc', 'tc.id = i.client_id', 'left');
        $this->db->join('tbl_frp_header_pipe_specifications tcfdss', 'tcfdss.indent_id = i.id', 'left');

        $this->db->where('i.deleted_by', NULL);
        $this->db->where('i.is_lock', 1);
        $this->db->where('tid.master_indent_id', 22);

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like('i.indent_no', $searchVal);
            $this->db->or_like('ticfds.manual_indent_no', $searchVal);
            $this->db->group_end();
        }

        $this->db->group_by('ticfds.id');
        $this->db->order_by('ticfds.id', 'DESC');

        if ($limit != -1) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    public function getFRPClampStageData($order_id)
    {
        $this->db->select("
        ticfdsod.status_id,
        ticfdsod.qty,
        ticfdsod.remark,
        ticfdsod.order_id,
        ticfds.order_qty,
    ");

        $this->db->from('tbl_indent_frp_clamp_received_order_status_detail ticfdsod');

        $this->db->join(
            'tbl_indent_frp_clamp_received_orders ticfds',
            'ticfds.id = ticfdsod.order_id',
            'left'
        );

        $this->db->join(
            'tbl_frp_clamp_specifications ticfdss',
            'ticfdss.indent_sub_id = ticfds.indent_id',
            'left'
        );
        $this->db->where('ticfdsod.order_id', $order_id);

        $result = $this->db->get()->result_array();
        $final = [
            'stages' => [],
            'order_id' => $order_id,
            'order_qty' => 0
        ];

        foreach ($result as $row) {

            $final['order_qty'] = $row['order_qty'];

            $final['stages'][$row['status_id']] = [
                'qty' => $row['qty'],
                'remark' => $row['remark']
            ];
        }

        return $final;
    }

    public function frpClampOrderDetails($id)
    {
        $this->db->select("
            ticfdsr.id as ord_no, 
            ti.indent_no,
            ti.date as indent_date,
            ti.delivery_date,
            ticfdsr.id as indent_id,
            ticfdsr.manual_indent_no,
            ticfdsr.order_qty,
            ticfds.clamp_size,
            ticfds.material,
            ticfds.make,
            ticfds.remark,
            ts.site_name,
            tcm.name as client_name,
            tmicm.name as material_name
            ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_frp_clamp_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_frp_clamp ticfds", 'ticfds.indent_id=ti.id', 'left');
        $this->db->join("tbl_master_indent_clamp_material tmicm", 'tmicm.id=ticfds.material', 'left');
        $this->db->join("tbl_site ts", 'ts.id=ti.plant_id', 'left');
        $this->db->join("tbl_customer tc", 'tc.id=ti.client_id', 'left');
        $this->db->join("tbl_company_master tcm", 'tcm.id=tc.company_id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function frpclampSpecifications($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        ticfdsr.total_order_qty,
        ticfdsr.order_qty,
        tcfdss.*,
        tifc.*,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_frp_clamp_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_frp_clamp_specifications tcfdss", 'tcfdss.indent_id=ti.id', 'left');
        $this->db->join("tbl_indent_frp_clamp tifc", 'tifc.indent_id=ti.id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getfrpClampExportIndentDetails($indent_no = '')
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.id as module_id,
        tifhp.clamp_size,
        tifhp.material,
        tifhp.remark,
        tifhp.qty,
        tifhp.make,

        spec.*
    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_frp_clamp tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        $this->db->join(
            'tbl_frp_clamp_specifications spec',
            'spec.indent_sub_id = tifhp.id',
            'left'
        );

        $this->db->where('i.indent_no', $indent_no);

        return $this->db->get()->result_array();
    }

    public function getfrpClampExportIndentDetailsSelected($indentNos = [])
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.id as module_id,
        tifhp.clamp_size,
        tifhp.material,
        tifhp.remark,
        tifhp.qty,
        tifhp.make,

        spec.*
    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_frp_clamp tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        $this->db->join(
            'tbl_frp_clamp_specifications spec',
            'spec.indent_sub_id = tifhp.id',
            'left'
        );

        $this->db->where_in('i.indent_no', $indentNos);

        return $this->db->get()->result_array();
    }

    public function getHubIndentData(
        $searchVal = '',
        $sortColIndex = 0,
        $sortBy = 'DESC',
        $limit = 0,
        $offset = 0,
        $count = 0,
        $where = [],
        $from_date = '',
        $to_date = '',
        $id = ''
    ) {

        $this->db->select('
        i.*,
        tid.*,
        c.company_name as client_name,
        p.plant_narration,
        tid.ref_id as indent_bland_id
    ');

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_details tid',
            'tid.indent_id = i.id',
            'LEFT'
        );

        $this->db->join(
            'tbl_customer c',
            'c.id = i.client_id',
            'LEFT'
        );

        $this->db->join(
            'tbl_plant p',
            'p.id = i.plant_id',
            'LEFT'
        );

        if (!empty($id)) {
            $this->db->where('i.id', $id);
        }

        $this->db->where('i.is_lock', 1);
        $this->db->where('i.deleted_by IS NULL', null, false);

        // Hub only
        $this->db->where('tid.master_indent_id', 2);

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like('i.indent_no', $searchVal);
            $this->db->or_like('i.indent_number', $searchVal);
            $this->db->group_end();
        }

        if (!empty($from_date)) {
            $this->db->where('DATE(i.date) >=', $from_date);
        }

        if (!empty($to_date)) {
            $this->db->where('DATE(i.date) <=', $to_date);
        }

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('i.id', 'DESC');

        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        return $query->result_array();
    }

    public function indentDetailsforhub($id, $blade_indent_id = '')
    {
        $this->db->select('tmi.db_table_name');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->where('i.id', $id);
        $this->db->from('tbl_indent i');

        $result = $this->db->get()->row_array();

        if (!$result) return [];

        $db_table_name = $result['db_table_name'];

        $this->db->select("
        i.*, 
        tid.master_indent_id, 
        tid.ref_id, 
        tmi.db_table_name,
        c.company_name as client_name,
        c.id as company_id,
        tifrphp.*,
        tcfds.id as order_id,
        tcfds.order_qty,
        tcfds.total_order_qty
    ");

        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id');
        $this->db->join('tbl_master_indent_for tmi', 'tmi.id = tid.master_indent_id');
        $this->db->join('tbl_indent_hub tifrphp', 'tifrphp.indent_id = i.id');
        $this->db->join('tbl_customer c', 'c.id = i.client_id');
        $this->db->join("$db_table_name tb", 'tb.id = tid.ref_id');
        $this->db->join(
            '(SELECT *
      FROM tbl_indent_hub_received_orders
      WHERE id IN (
          SELECT MAX(id)
          FROM tbl_indent_hub_received_orders
          GROUP BY indent_id
      )
    ) tcfds',
            'tcfds.indent_id = i.id',
            'left'
        );

        $this->db->where("i.id", $id);

        if (!empty($blade_indent_id)) {
            $this->db->where("tid.ref_id", $blade_indent_id);
        }

        $this->db->from('tbl_indent i');

        $mainData = $this->db->get()->row_array();

        if (!$mainData) return [];


        return $mainData;
    }

    public function getHuborderStatusData($searchVal = '', $limit = 10, $offset = 0, $master_indent_id = '')
    {
        $this->db->select("
        i.id as indent_main_id,
        i.indent_no,
        ticfds.id,
        ticfds.order_for,
        ticfds.indent_id,
        ticfds.manual_indent_no,
        ticfds.indent_date,
        ticfds.total_order_qty,
        ticfds.order_qty,
        tc.company_name as company_name,

        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 1 THEN ticfdsod.qty END),0) AS hubplate_machining,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 2 THEN ticfdsod.qty END),0) AS hubplate_inspection,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 3 THEN ticfdsod.qty END),0) AS hubplate_galvanising,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 4 THEN ticfdsod.qty END),0) AS hubplate_painting,

        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 5 THEN ticfdsod.qty END),0) AS hubspool_machining,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 6 THEN ticfdsod.qty END),0) AS hubspool_final_machining,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 7 THEN ticfdsod.qty END),0) AS hubspool_inspection,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 8 THEN ticfdsod.qty END),0) AS hubspool_painting,

        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 9 THEN ticfdsod.qty END),0) AS clamp_machining,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 10 THEN ticfdsod.qty END),0) AS clamp_inspection,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 11 THEN ticfdsod.qty END),0) AS clamp_painting,

        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 12 THEN ticfdsod.qty END),0) AS hardware_forging,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 13 THEN ticfdsod.qty END),0) AS hardware_machining,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 14 THEN ticfdsod.qty END),0) AS hardware_inspection,

        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 15 THEN ticfdsod.qty END),0) AS assembly,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 16 THEN ticfdsod.qty END),0) AS inspection_overall,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 17 THEN ticfdsod.qty END),0) AS dynamic_balancing,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 18 THEN ticfdsod.qty END),0) AS packing,
        COALESCE(MAX(CASE WHEN ticfdsod.status_id = 19 THEN ticfdsod.qty END),0) AS dispatch
    ");

        $this->db->from('tbl_indent i');
        $this->db->join('tbl_indent_details tid', 'tid.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_hub_received_orders ticfds', 'ticfds.indent_id = i.id', 'left');
        $this->db->join('tbl_indent_hub_received_order_status_detail ticfdsod', 'ticfdsod.order_id = ticfds.id', 'left');
        $this->db->join('tbl_indent_hub_received_order_status ticfdsros', 'ticfdsros.order_id = ticfds.id', 'left');
        $this->db->join('tbl_customer tc', 'tc.id = i.client_id', 'left');

        $this->db->where('i.deleted_by', NULL);
        $this->db->where('i.is_lock', 1);
        $this->db->where('tid.master_indent_id', 2);
        $this->db->where('ticfds.order_qty >', 0);

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like('i.indent_no', $searchVal);
            $this->db->or_like('ticfds.manual_indent_no', $searchVal);
            $this->db->group_end();
        }

        $this->db->group_by('ticfds.id');
        $this->db->order_by('ticfds.id', 'DESC');

        if ($limit != -1) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    public function getHubStageData($order_id)
    {
        $this->db->select("
        ticfdsod.status_id,
        ticfdsod.qty,
        ticfdsod.remark,
        ticfdsod.order_id,
        ticfds.order_qty,
    ");

        $this->db->from('tbl_indent_hub_received_order_status_detail ticfdsod');

        $this->db->join(
            'tbl_indent_hub_received_orders ticfds',
            'ticfds.id = ticfdsod.order_id',
            'left'
        );

        $this->db->where('ticfdsod.order_id', $order_id);

        $result = $this->db->get()->result_array();
        $final = [
            'stages' => [],
            'order_id' => $order_id,
            'order_qty' => 0
        ];

        foreach ($result as $row) {

            $final['order_qty'] = $row['order_qty'];

            $final['stages'][$row['status_id']] = [
                'qty' => $row['qty'],
                'remark' => $row['remark']
            ];
        }

        return $final;
    }

    public function HubOrderDetails($id)
    {
        $this->db->select("
            ticfdsr.id as ord_no, 
            ti.indent_no,
            ti.indent_number,
            ti.date as indent_date,
            ti.delivery_date,
            ticfdsr.id as indent_id,
            ticfdsr.manual_indent_no,
            ticfdsr.order_qty,
            ticfds.*,
            ts.site_name,
            tcm.name as client_name,
            ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_hub_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_hub ticfds", 'ticfds.indent_id=ti.id', 'left');
        $this->db->join("tbl_site ts", 'ts.id=ti.plant_id', 'left');
        $this->db->join("tbl_customer tc", 'tc.id=ti.client_id', 'left');
        $this->db->join("tbl_company_master tcm", 'tcm.id=tc.company_id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function HubOrderStatusDetails($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        ticfdsrosd.*,
        tcsm.stage_name as status,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_hub_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_hub_received_order_status_detail ticfdsrosd", 'ticfdsrosd.order_id=ticfdsr.id', 'left');
        $this->db->join("tbl_frp_hub_stage_master tcsm", "tcsm.id=ticfdsrosd.status_id", 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function HubSpecifications($id)
    {
        $this->db->select("
        ticfdsr.id as ord_no,
        ticfdsr.total_order_qty,
        ticfdsr.order_qty,
        tifc.*,
        ");
        $this->db->where("ticfdsr.id", $id);
        $this->db->from("tbl_indent_hub_received_orders ticfdsr");
        $this->db->join("tbl_indent ti", 'ti.id=ticfdsr.indent_id', 'left');
        $this->db->join("tbl_indent_hub tifc", 'tifc.indent_id=ti.id', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getHubExportIndentDetails($indent_no = '')
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.*

    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_hub tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        $this->db->where('i.indent_no', $indent_no);

        return $this->db->get()->result_array();
    }

    public function getHubExportIndentDetailsSelected($indentNos = [])
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.*,

    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_hub tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );


        $this->db->where_in('i.indent_no', $indentNos);

        return $this->db->get()->result_array();
    }

    public function getBladeExportIndentDetails($indent_no = '')
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.*

    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_blade tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );

        $this->db->where('i.indent_no', $indent_no);

        return $this->db->get()->result_array();
    }

    public function getBladeExportIndentDetailsSelected($indentNos = [])
    {
        $this->db->select("
        i.id,
        i.indent_number,
        i.created_at,
        i.delivery_date,
        i.date as indent_date,

        customer.id as customer_id,
        customer.company_name,

        company.id as company_id,
        company.name as client_name,

        tifhp.*,

    ");

        $this->db->from('tbl_indent i');

        $this->db->join(
            'tbl_indent_blade tifhp',
            'tifhp.indent_id = i.id',
            'left'
        );

        $this->db->join(
            'tbl_customer customer',
            'customer.id = i.client_id',
            'left'
        );

        $this->db->join(
            'tbl_company_master company',
            'company.id = customer.company_id',
            'left'
        );


        $this->db->where_in('i.indent_no', $indentNos);

        return $this->db->get()->result_array();
    }
}
