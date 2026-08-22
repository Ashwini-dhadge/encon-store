<?php
   class FooterNotesModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'fn.id',
                                       'fn.title',
                                       'fn.description',
                                       '',
                                       
                                   );
        public function getFooterNotesData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('fn.*,');
           if ($id) {
                 $this->db->where('fn.id',$id);            
                     
            }
           if (strlen($searchVal)) {
                 $searchCondition = "(
                    fn.title like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
           }
           if ($where) {
              $this->db->where($where);            
            }
           $this->db->where('fn.deleted_by',NULL);
           $this->db->from('tbl_master_footer_notes fn');
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
