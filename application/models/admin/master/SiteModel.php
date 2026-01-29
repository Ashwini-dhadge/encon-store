<?php
   class SiteModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        public function getsiteData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('s.*,c.name as company_name');
           $this->db->join('tbl_company_master c','c.id=s.company_id');
            if ($id) {
                 $this->db->where('s.id',$id);            
                     
             }
   
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    s.site_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }//$this->db->where('u.deleted_by', NULL);
   
            $this->db->from('tbl_site s');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
           //echo $this->db->last_query();
             return $query->result_array();
        }
    
   
    public function getcompanyName($searchTerm = '')
        {
            $this->db->select('cm.*');
             
            $this->db->from('tbl_company_master cm');
            //$this->db->where('state_id');
   
            if ($searchTerm) {
                $searchCondition = "(
                        cm.name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $result = $this->db->get()
                ->result_array();
            return $result;
        }
     
   
   
       
       
   }
   ?>
