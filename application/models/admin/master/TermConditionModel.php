<?php
   class TermConditionModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        public function getTermConditionData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('tc.*,');
          
            if ($id) {
                 $this->db->where('tc.id',$id);            
                     
             }
           $this->db->where('tc.is_deleted', 0);
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    tc.title like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
   			
            $this->db->from('tbl_master_term_and_condition tc');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
         // echo $this->db->last_query();die;
             return $query->result_array();
        }
   
      
     }
   ?>
