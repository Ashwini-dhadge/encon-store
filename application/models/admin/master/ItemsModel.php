<?php
   class ItemsModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        public function getitemsData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
            $this->db->select('i.*,mu.unit_name,ig.item_group_name,u.first_name as created_by_fname,u.last_name as created_by_lname,u1.first_name as updated_by_fname,u1.last_name as updated_by_lname');
            $this->db->join('tbl_master_unit mu','mu.id=i.stock_unit');
            $this->db->join('tbl_item_groups ig','ig.id=i.item_group');
            $this->db->join('users u','u.id=i.created_by','left');
            $this->db->join('users u1','u1.id=i.updated_by','left');
           
            if ($id) {
                 $this->db->where('i.id',$id);            
                     
             }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    i.item_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
   			$this->db->where('i.deleted_by', NULL);
            $this->db->from('tbl_items i');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
         
             return $query->result_array();
        }

        public function viewItemsData($id)
        {
            $this->db->select('i.*,mu.unit_name,ig.item_group_name');

            $this->db->join('tbl_master_unit mu','mu.id=i.stock_unit');
            $this->db->join('tbl_item_groups ig','ig.id=i.item_group');
            $this->db->join('tbl_items_units u','u.id=i.item_group');

            if ($id) {
                $this->db->where('i.id',$id);  
            }
            // $this->db->where('v.deleted_by', NULL);
            $this->db->from('tbl_items i');
            $query = $this->db->get();
         
            return $query->result_array();
        }
    
   
    public function getitemgroupName($searchTerm = '')
        {
            $this->db->select('g.*');
             
            $this->db->from('tbl_item_groups g');
      
            if ($searchTerm) {
                $searchCondition = "(
                        g.item_group_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $this->db->where('g.is_deleted',0);
              $this->db->where('g.status',1);
            $result = $this->db->get()
                ->result_array();
            return $result;
        }
        
   		 public function getstockunitName($searchTerm = '')
        {
            $this->db->select('u.*');
             
            $this->db->from('tbl_master_unit u');
      
            if ($searchTerm) {
                $searchCondition = "(
                        u.unit_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $result = $this->db->get()
                ->result_array();
            return $result;
        }

         public function item_unit($id=''){
           $this->db->select('mu.*');
            $this->db->from('tbl_items_units iu');
             $this->db->join('tbl_master_unit mu','mu.id=iu.unit_id');
              $this->db->where('iu.item_id',$id);
            // if($where){
            //     $this->db->where($where);
            //  }
           
            $result = $this->db->get()
                ->result_array();
            return $result;
        }

         public function getitemName($searchTerm='')
      {
            $this->db->select('is.*'); 
            $this->db->from('tbl_items is');
           
            if($searchTerm){
                $searchCondition = "(
                 i.item_code like '%$searchVal%' or
                    is.item_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }
            $result = $this->db->get()
                           ->result_array();
            return $result;
      }

     }
   ?>
