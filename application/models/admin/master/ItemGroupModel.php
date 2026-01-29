<?php
   class ItemGroupModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        public function getitemgroupData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
            $this->db->select('ig.*,i.item_type_name as item_type_name,u.first_name as created_by_fname,u.last_name as created_by_lname');
            $this->db->join('tbl_master_item_type i','i.id=ig.item_type_id');
            $this->db->join('users u','u.id=ig.created_by','left');
          
           
            if ($id) {
                 $this->db->where('ig.id',$id);            
                     
             }
                $this->db->where('ig.is_deleted', 0);
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    ig.item_group_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }//$this->db->where('u.deleted_by', NULL);
              
            $this->db->from('tbl_item_groups ig');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
           //echo $this->db->last_query();
             return $query->result_array();
        }
    
   
    public function getitemgroupName($searchTerm = '')
        {
            $this->db->select('it.*');
             
            $this->db->from('tbl_master_item_type it');
      
            if ($searchTerm) {
                $searchCondition = "(
                        it.item_type_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            
            $result = $this->db->get()
                ->result_array();
            return $result;
        }
   
          public function getgroupName($searchTerm='')
      {
            $this->db->select('g.*'); 
       
            $this->db->from('tbl_item_groups g');
            $this->db->where('g.item_level',0); 
            // $this->db->where('mz.is_deleted',0);  
        
            if($searchTerm){
                $searchCondition = "(
                    g.item_group_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }
             $this->db->where('g.is_deleted',0);
              $this->db->where('g.status',1);
            $result = $this->db->get()
                           ->result_array();
                          // echo $this->db->lastquery();die;
            return $result;
      }
   
     
      
   
       
       
   }
   ?>