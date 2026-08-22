<?php
   class TechnicalSpecificationModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'ts.id',
                                       'ts.title',
                                       'ts.default_values',
                                       '',
                                       
                                   );
        public function getTechnicalSpecificationData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('ts.*,');
          
           if ($id) {
                 $this->db->where('ts.id',$id);            
                     
            }
         if (strlen($searchVal)) {
                 $searchCondition = "(
                    ts.title like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
           }
         if ($where) {
              $this->db->where($where);            
            }
          $this->db->where('ts.deleted_by',NULL);  
          $this->db->from('tbl_master_technical_specification ts');
          if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
           //echo $this->db->last_query();
             return $query->result_array();
        }
    
   
   }
   ?>
