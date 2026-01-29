<?php
   class ItemApprovedRateModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                   
                                   'ar.id',
                                   'p.po_order_no',
                                   'ig.item_group_name',
                                   'i.short_name',
                                   'vm.account_name',
                                   'cm.name',
                                   'ts.site_name','','',
                                   'ar.is_approved',
                                   'u.first_name',
                                   ''
                                   );


        public function getAprovedItemData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('ar.*,i.id as item_id,ig.item_group_name,i.short_name as item_name,cm.name as company_name,ts.site_name,concat(u.first_name," ",u.last_name) as approved_by_name, vm.account_name as vendor_name, p.po_order_no,ar.id');
           $this->db->join('tbl_item_groups ig','ig.id=ar.item_group_id','left');
           $this->db->join('tbl_items i','i.id=ar.item_id','left'); 
           $this->db->join('tbl_company_master cm','cm.id=ar.company_id','left'); 
           $this->db->join('tbl_site ts','ts.id=ar.site_id','left'); 
           $this->db->join('users u','u.id=ar.approved_by','left'); 
           
           $this->db->join('tbl_vendor_master vm','vm.id=ar.vendor_id','left'); 

           $this->db->join('tbl_po p','p.id=ar.reference_id','left'); 
                                                                
            if ($id) {
                $this->db->where('ar.id',$id);            
             }
   
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    p.po_order_no like '%$searchVal%' or
                    ig.item_group_name like '%$searchVal%' or
                    i.short_name like '%$searchVal%' or
                    vm.account_name like '%$searchVal%' or
                    cm.name like '%$searchVal%' or
                    ts.site_name like '%$searchVal%' 
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
            }

            //$this->db->where('u.deleted_by', NULL);
   
            $this->db->from('tbl_approved_item_rate ar');


            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
           // echo $this->db->last_query();die;
             return $query->result_array();
        }
       
        public function getItemCountApproved($po_id){
            $this->db->select('po_rate_approved_status');
            $this->db->where('pi.po_id', $po_id);
            $this->db->group_start();
            $this->db->where('po_rate_approved_status', 1);
            $this->db->or_where('po_rate_approved_status IS NULL');
            $this->db->group_end();
            $this->db->from('tbl_po_items_details pi');
             $query = $this->db->get();
           // echo $this->db->last_query();die;
             return $query->result_array();
        }
   }
   ?>
