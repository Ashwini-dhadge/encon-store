<?php
   class LeadModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
         public function getleadData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
           {
           
             $this->db->select('l.*,u.first_name as first_name ,u.last_name as last_name ,s.name as source_name');
              $this->db->join('users u','u.id=l.assigned_id'); 
              $this->db->join('tbl_source s','s.id=l.lead_source_id'); 
             

             if ($id) {
                  $this->db->where('l.id',$id);            
                     
              }
              $this->db->order_by('l.id', 'desc');
   
             if (strlen($searchVal)) {
                  $searchCondition = "(
                     l.name like '%$searchVal%'
                   )";
                 $this->db->where($searchCondition);
             }
   
             if ($where) {
                 $this->db->where($where);            
                     
             }
   
             $this->db->from('tbl_lead l');
       
             if($limit){
                 $this->db->limit($limit, $offset);
             }
             $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
             $query = $this->db->get();
            
              return $query->result_array();
          }


    public function getSourceName($searchTerm='',$where='')
      {
            $this->db->select('s.*'); 
            $this->db->from('tbl_source s');
            // $this->db->where('c.is_active',1);
    
            if($where) {
                $this->db->where($where);
            }

            if($searchTerm){
                $searchCondition = "(
                    s.name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }

      
       public function getAssignedName($searchTerm='',$where='')
      {
            $this->db->select('u.*'); 
            $this->db->from('users u');
             $this->db->where('u.department_id',3);
    
            if($where) {
                $this->db->where($where);
            }

            if($searchTerm){
                $searchCondition = "(
                    u.first_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }

      
      public function getStatusName($searchTerm='',$where='')
      {
            $this->db->select('ls.*'); 
            $this->db->from('tbl_lead_status ls');
             // $this->db->where('u.department_id',3);
    
            if($where) {
                $this->db->where($where);
            }

            if($searchTerm){
                $searchCondition = "(
                    ls.status like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }


       public function viewFollowupData($id='')
        {
            $this->db->select('fu.*,');
            
            if ($id) {
                $this->db->where('fu.lead_id',$id);  
            }

            // if($where){
            //     $this->db->where($where);
            // }
            
            $this->db->from('tbl_lead_follow_up fu');
            $this->db->order_by('fu.id','DESC');

            $query = $this->db->get();
             // echo $this->db->last_query();
            return $query->result_array();
        }

        
         public function viewUserData($id='')
        {
            $this->db->select('us.*,');
            
            if ($id) {
                $this->db->where('us.id',$id);  
            }

            // if($where){
            //     $this->db->where($where);
            // }
            
            $this->db->from('users us');
            $this->db->order_by('us.id','DESC');

            $query = $this->db->get();
             // echo $this->db->last_query();
            return $query->result_array();
        }


        public function getFollowData($id='',$follow_up_id='')
        {
            $this->db->select('f.*,');
          

            $this->db->from('tbl_lead_follow_up f');
           // $this->db->order_by('f.id','DESC');
             if ($follow_up_id != '') {
                $this->db->where('f.id',$follow_up_id);  
            }
            if ($id) {
                $this->db->where('f.lead_id',$id);  
            }
            $query = $this->db->get();
          // echo $this->db->last_query();
            return $query->result_array();
        }
         public function getReminderData($lead_id='',$follow_up_id='')
        {
            $this->db->select('r.*,');
          
            // if($where){
            //     $this->db->where($where);
            // }
            $this->db->from('tbl_reminder r');
           // $this->db->order_by('f.id','DESC');
             if ($follow_up_id != '') {
                $this->db->where('r.follow_up_id',$follow_up_id);  
            }
            if ($lead_id) {
                $this->db->where('r.ref_id',$lead_id);  
            }
            $query = $this->db->get();
            // echo $this->db->last_query();
            return $query->result_array();
        }


        
        // public function viewReminderData($id='')
        // {
        //     $this->db->select('r.*,');
            
        //     if ($id) {
        //         $this->db->where('r.reference_id',$id);  
        //     }

        //     // if($where){
        //     //     $this->db->where($where);
        //     // }
            
        //     $this->db->from('tbl_reminder r');
        //     $this->db->order_by('r.id','DESC');

        //     $query = $this->db->get();
        //      // echo $this->db->last_query();
        //     return $query->result_array();
        // }

        public function viewReminderData($follow_up_id='')
        {
            $this->db->select('r.*,');
            
            if ($follow_up_id) {
                $this->db->where('r.follow_up_id',$follow_up_id);  
            }

            // if($where){
            //     $this->db->where($where);
            // }
            
            $this->db->from('tbl_reminder r');
            $this->db->order_by('r.id','DESC');

            $query = $this->db->get();
             // echo $this->db->last_query();
            return $query->result_array();
        }
        
        
        //  public function getfollowData($id='',$where='')
        // {
        //     $this->db->select('f.*,');
        //     $this->db->where('f.id');
    
        //     if($where) {
        //         $this->db->where($where);
        //     }
        //     // if($where){
        //     //     $this->db->where($where);
        //     // }
            
        //     $this->db->from('tbl_lead_follow_up f');
            

        //     $query = $this->db->get();
        //     echo $this->db->last_query();
        //     return $query->result_array();
        // }

         
      
   
     }

     
   ?>
