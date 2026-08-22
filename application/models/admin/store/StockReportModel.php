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
     public function getStockItemGroupData($where)
         {
           
            $this->db->select('ti.item_group,ig.item_group_name as item_group_name');
            $this->db->join('tbl_items ti','ti.id = iid.item_id');
            $this->db->join('tbl_item_groups ig','ig.id = ti.item_group');
            
            if ($where) {
                $this->db->where($where);            
                     
            }
   			// $this->db->where('mi.deleted_by', NULL);
            $this->db->from('tbl_items_inventory iid');
            $this->db->where('iid.is_reserve_stock',0);            
            //$this->db->where('iid.type !=',6);          
       
            $this->db->group_by('ti.item_group','asc');
             $this->db->order_by('ig.item_group_name','asc');
            $query = $this->db->get();
            //   echo $this->db->last_query();
            $item_groups=$query->result_array();
            
            
            foreach($item_groups as $key=>$group){
                    $this->db->select('iid.*,ti.item_code,ti.item_name,iu.unit_name,0 AS total_recevied_amt ,0 AS total_issued_amt,count(iid.item_id)');
                    $this->db->join('tbl_items ti','ti.id = iid.item_id');
                    $this->db->join('tbl_item_groups ig','ig.id = ti.item_group');
                    $this->db->join('tbl_master_unit iu','iu.id = ti.stock_unit');
                    // $this->db->join('tbl_grn_items_details gid','gid.item_id = iid.item_id AND gid.batch_no = iid.batch_no AND gid.expired_date = iid.expired_date AND gid.item_unit_id = iid.item_unit_id');
                    if ($where) {
                        $this->db->where($where);  
                    }
                    $this->db->where('ti.item_group',$group['item_group']);      
           		
           		    $this->db->where('iid.is_reserve_stock',0); 
           			// $this->db->where('mi.deleted_by', NULL);
                    $this->db->from('tbl_items_inventory iid');
                    $this->db->group_by('iid.item_id,iid.item_unit_id','asc');
                    $this->db->order_by('ti.item_name','asc');
                      
                    $query = $this->db->get(); 
                    $items=$query->result_array();
                    // echo $this->db->last_query();die;
                    $item_groups[$key]['items']=$items;
                    $item_groups[$key]['query']=$this->db->last_query();;
            }
            
          //  echo "<pre>";
         //   print_r($item_groups);die;
            return $item_groups;
        }
        
        public function getOpenItemStock($input_company_id,$input_site_id,$input_to_date,$input_previous_date,$input_item_id,$input_item_unit_id,$is_first_day_opning){
            //PROCEDURE `procedure_stock_report_opening`(IN `input_item_id` INT, IN `input_item_unit_id` INT, IN `input_company_id` INT, IN `input_site_id` INT, IN `input_previous_date` DATE, IN `input_to_date` DATE, IN `is_first_day_opning` INT)
             $stored_pocedure = "CALL  procedure_stock_report_opening (".$input_item_id.",".$input_item_unit_id.",".$input_company_id.",".$input_site_id.",'".$input_previous_date."','".$input_to_date."',".$is_first_day_opning.")";
            $query = $this->db->query($stored_pocedure);
            $opening_arr=$query->row_array();
             // echo $this->db->last_query();die;
            $query->next_result(); 
            $query->free_result(); 
         
            return $opening_arr;
            
        }
        
        public function getReceivedItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id){
            // PROCEDURE `procedure_stock_report_recevied`(IN `input_item_id` INT, IN `input_item_unit_id` INT, IN `input_company_id` INT, IN `input_site_id` INT, IN `input_from_date` DATE, IN `input_to_date` DATE, IN `input_financial_year_id` INT)
            $stored_pocedure = "CALL procedure_stock_report_recevied(".$input_item_id.",".$input_item_unit_id.",".$input_company_id.",".$input_site_id.",'".$input_from_date."','".$input_to_date."',".$input_financial_year_id.") ";
            $query = $this->db->query($stored_pocedure);
            $received_arr=$query->row_array();
             // echo $this->db->last_query();die;
            $query->next_result(); 
            $query->free_result(); 
            
            return $received_arr;
            
        }
        
        public function getIssueItemStock($input_item_id,$input_item_unit_id,$input_company_id,$input_site_id,$input_from_date,$input_to_date,$input_financial_year_id){
         //   PROCEDURE `procedure_stock_report_issued`(IN `input_item_id` INT, IN `input_item_unit_id` INT, IN `input_company_id` INT, IN `input_site_id` INT, IN `input_from_date` DATE, IN `input_to_date` DATE, IN `input_financial_year_id` INT)
            $stored_pocedure = "CALL procedure_stock_report_issued(".$input_item_id.",".$input_item_unit_id.",".$input_company_id.",".$input_site_id.",'".$input_from_date."','".$input_to_date."',".$input_financial_year_id.") ";
            $query = $this->db->query($stored_pocedure);
            $Issue_array_arr=$query->row_array();
             // echo $this->db->last_query();die;
            $query->next_result(); 
            $query->free_result(); 
        //  
            return $Issue_array_arr;
            
        }
      
        // SELECT item_id,item_unit_id , FROM tbl_items_inventory_details where company_id=2 and site_id=38 GROUP by item_id,item_unit_id; 
    
     }
   ?>