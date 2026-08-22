<?php
   class EmailTemplateModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
         public function getEmailTemplateData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
          {
           
            $this->db->select('et.*,');
           
            if ($id) {
                 $this->db->where('et.id',$id);            
                     
             }
              $this->db->where('et.is_deleted', 0);
   
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    et.site_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }//$this->db->where('u.deleted_by', NULL);
   
            $this->db->from('tbl_master_email_template et');
       
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
