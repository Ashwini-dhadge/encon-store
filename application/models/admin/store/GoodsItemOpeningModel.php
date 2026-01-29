<?php
   class GoodsItemOpeningModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'mi.id',
                                       'mi.id',
                                       '',
                                       '',
                                       
                                   );
       
           public function getOpeningStockData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="",$item_id='',$item_group_id='')
         {
             if(isset($item_id) && !empty($item_id)|| isset($item_group_id) && !empty($item_group_id)){
                $this->db->select('pi.opening_id');
                $this->db->from('tbl_items_opening_stock_details pi');
                $this->db->join('tbl_items i','i.id=pi.item_id');
                // $this->db->where('pi.item_id', $item_id);
                if(isset($item_id) && !empty($item_id)){
                    $this->db->where('pi.item_id', $item_id);
                }
                if(isset($item_group_id) && !empty($item_group_id)){
                    $this->db->where('i.item_group', $item_group_id);
                }
                
                $this->db->where('pi.deleted_by', NULL);
                $this->db->where('pi.opening_id = mi.id', NULL, false);
                 $subquery = $this->db->get_compiled_select();

                // Fetch the compiled subquery SQL string
                $subquery_sql = "($subquery)";

             }
             

 
                
              
           
           $this->db->select('mi.*,cm.name as company_name,s.short_name as site_name,concat(ib.first_name," ",ib.last_name) as created_by_name');
           $this->db->join('tbl_site s','s.id = mi.location_id');
           $this->db->join('tbl_company_master cm','cm.id = s.company_id');
           $this->db->join('users ib','ib.id = mi.created_by');
           
           
            if ($id) {
                 $this->db->where('mi.id',$id);            
                     
             }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    mi.item_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
             if(isset($item_id) && !empty($item_id)|| isset($item_group_id) && !empty($item_group_id)){
                    $this->db->where("mi.id IN $subquery_sql");
            }
   			$this->db->where('mi.deleted_by', NULL);
            $this->db->from('tbl_items_opening_stock mi');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
         
             return $query->result_array();
        }
         public function getOpeningItemDataALL($where){
                $this->db->select('pi.*,i.item_name,i.hsn_code,u.unit_name,g.item_group_name');        
                $this->db->from('tbl_items_opening_stock_details pi');         
                $this->db->join('tbl_items i','i.id=pi.item_id'); 
                $this->db->join('tbl_items_units iu','iu.id=pi.opening_unit_id');
                $this->db->join('tbl_master_unit u','u.id=iu.unit_id');
                $this->db->join('tbl_item_groups g','g.id=pi.item_group_id','left');
                $this->db->join('tbl_items_opening_stock p','p.id=pi.opening_id'); 
                  
 
                if($where) {
                      $this->db->where($where);
                } 
                $this->db->where('pi.deleted_by',NULL);
               
                $result = $this->db->get()
                                   ->result_array();
               // echo $this->db->last_query();

               
                return $result;
        }
    
     }
   ?>
