<?php
   class StockReportModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
       
           public function getStockReportData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$where="")
         {
           
           $this->db->select('iid.*,ti.item_code,ti.item_group,ti.stock_unit,iu.unit_name,ti.item_name,ig.item_group_name,ts.site_name,(CASE WHEN iid.action = 1 THEN iid.qty ELSE 0 END) AS received_quantity,
             (CASE WHEN iid.action = 2 THEN iid.qty ELSE 0 END) AS issued_quantity,gid.item_rate');
            $this->db->join('tbl_items ti','ti.id = iid.item_id');
            $this->db->join('tbl_master_unit iu','iu.id = ti.stock_unit');
            $this->db->join('tbl_item_groups ig','ig.id = ti.item_group');
            $this->db->join(' tbl_site ts','ts.id = iid.site_id');
            $this->db->join(' tbl_grn_items_details gid','gid.item_id = iid.item_id AND gid.batch_no = iid.batch_no AND gid.expired_date = iid.expired_date AND gid.item_unit_id = iid.item_unit_id');


   

             
           // $this->db->join('tbl_company_master cm','cm.id = s.company_id');
           // $this->db->join('users ib','ib.id = mi.created_by');
           
          
           
            if ($where) {
                $this->db->where($where);            
                     
            }
   			// $this->db->where('mi.deleted_by', NULL);
            $this->db->from('tbl_items_inventory_details iid');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
             // echo $this->db->last_query();
             return $query->result_array();
        }
      public function getCompanyName($searchTerm='')
      {
            $this->db->select('cm.*'); 
            $this->db->from('tbl_company_master cm');
            $this->db->where('cm.is_active',1);

            if($searchTerm){
                $searchCondition = "(
                    cm.name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }


        public function getCompanySite($searchTerm='',$where='')
    {
          $this->db->select('s.id,s.site_name'); 
          $this->db->from('tbl_site s');       

         if($searchTerm){

            $searchCondition = "(
                s.site_name like '%$searchTerm%'
                 )";

            $this->db->where($searchCondition);
            }
            
            if($where) {
            $this->db->where($where);
            }  
            

            $result = $this->db->get()
                           ->result_array();

            return $result;
    
    }  
     public function getStockItemGroupData($where,$from_date_formatted='',$to_date_formatted='')
         {
           
            $this->db->select('ti.item_group,ig.item_group_name as item_group_name');
            $this->db->join('tbl_items ti','ti.id = iid.item_id');
            $this->db->join('tbl_item_groups ig','ig.id = ti.item_group');
            
            if ($where) {
                $this->db->where($where);            
                     
            }
   			// $this->db->where('mi.deleted_by', NULL);
            $this->db->from('tbl_items_inventory_details iid');
       
            $this->db->group_by('ti.item_group','asc');
            $query = $this->db->get();
             // echo $this->db->last_query();
            $item_groups=$query->result_array();
            
            
            foreach($item_groups as $key=>$group){
                    $this->db->select('iid.*,ti.item_name,iu.unit_name, SUM(CASE WHEN iid.action = 1 THEN iid.qty ELSE 0 END) AS total_recevied ,SUM(CASE WHEN iid.action = 2 THEN iid.qty ELSE 0 END) AS total_issued');
                    $this->db->join('tbl_items ti','ti.id = iid.item_id');
                    $this->db->join('tbl_item_groups ig','ig.id = ti.item_group');
                    $this->db->join('tbl_master_unit iu','iu.id = ti.stock_unit');
                    if ($where) {
                        $this->db->where($where);  
                    }
                    $this->db->where('ti.item_group',$group['item_group']);      
           			if(isset($from_date_formatted)){
           			    $this->db->where('date(iid.created_at) >=', $from_date_formatted);
           			}
           			if(isset($to_date_formatted)){
           			  	$this->db->where('date(iid.created_at) <=', $to_date_formatted);
           			}
           		
           			// $this->db->where('mi.deleted_by', NULL);
                    $this->db->from('tbl_items_inventory_details iid');
                    $this->db->group_by('iid.item_id,iid.item_unit_id','asc');
                    
                    $query = $this->db->get(); 
                    $items=$query->result_array();
                    $item_groups[$key]['items']=$items;
            }
            
            return $item_groups;
        }
        
        public function getOpenItemStock($where){
            $this->db->select('SUM(CASE WHEN action = 1 THEN qty ELSE -qty END) AS balance');
            if ($where) {
                $this->db->where($where);            
                     
            }
            $this->db->from('tbl_items_inventory_details iid');
            $query = $this->db->get();
             // echo $this->db->last_query();
            return $query->row_array();
            
        }
      
        // SELECT item_id,item_unit_id , FROM tbl_items_inventory_details where company_id=2 and site_id=38 GROUP by item_id,item_unit_id; 
    
     }
   ?>
