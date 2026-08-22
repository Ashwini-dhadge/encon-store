<?php
class RoleAccessModel extends CI_Model
{


    public function getModalRoleWiseName()
     {

        $this->db->select('r.*');
        $this->db->from('tbl_module r');
        $this->db->where('r.is_active','1');       
        $query = $this->db->get();
      
        $result=$query->result_array();
        foreach ($result as $key => $module) {
              
        }
    }


 
}
  ?>