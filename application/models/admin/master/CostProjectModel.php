<?php
   class CostProjectModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        public function getCostProjectData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('cp.*,');
          
            if ($id) {
                 $this->db->where('cp.id',$id);            
                     
             }
            $this->db->where('cp.deleted_by',NULL);
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    cp.cost_project_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
   			
            $this->db->from('tbl_cost_project cp');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
         // echo $this->db->last_query();die;
             return $query->result_array();
        }
   
        public function getcostprojectName($searchTerm='')
      {
            $this->db->select('tcp.*,'); 
            $this->db->from('tbl_cost_project tcp');
           
            if($searchTerm){
                $searchCondition = "(
                    tcp.cost_project_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }
             $this->db->where('tcp.deleted_by',0);  
            $result = $this->db->get()
                           ->result_array();
            return $result;
      }
     }
   ?>
