<?php
class UserAccessModel extends CI_Model
{

    protected $dt_Column = array(
                                    'u.id',
                                    'u.first_name',
                                    'u.contact',
                                    'u.email',
                                    'u.address',
                                    'u.role_id',
                                    ''
                                
                                 );


     public function getUserData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
     {
      
        $this->db->select('u.*,c.name as company_name,r.role_name');
      
        // $this->db->select('ua.*,u.*,ua.id as user_access_id');
        // $this->db->join('tbl_user_access ua','ua.user_id=u.id');
        $this->db->join('user_profile up','up.user_id=u.id','left');       
        $this->db->join('tbl_roles r','r.id=u.role_id','left');
        $this->db->join('tbl_company_master c','c.id=u.company_id');
       
        

        
        if ($id) {
            $this->db->where('u.id',$id);  
        }

        if($where){
            $this->db->where($where);
        }

        if (strlen($searchVal)) {
             $searchCondition = "(
                concat(u.first_name,' ',u.last_name) like '%$searchVal%' or
                u.contact like '%$searchVal%'  or 
                r.role_name like '%$searchVal%'  
            )";
            $this->db->where($searchCondition);
        }
       
        
        $this->db->where('u.deleted_by', NULL);
         $this->db->where('u.role_id !=', SUPERADMIN_ROLE);

        $this->db->from('users u');
    
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
      // echo $this->db->last_query();die();
        return $query->result_array();
    }
    
    public function editModuleAcess($id='')
    {
        $this->db->select('m.id,m.name,ua.id as uaid, ua.user_id, ua.module_id, ua.create, ua.edit, ua.delete, ua.view_global, ua.view_own');
        $this->db->from('tbl_module m');
        $this->db->join('tbl_user_access ua','ua.module_id = m.id','left');
        $this->db->where('ua.user_id',$id);
        // $this->db->where('ua.module_id',$user_data);
        $this->db->where('m.is_active',1);
        $query = $this->db->get();

        // foreach ($query as $key=>$row) {
        //     $data[] = $row;
        // }
        // echo $this->db->last_query();
        return $query->result_array();
    } 

    public function getUserModuleAcess($where)
    {
        $this->db->select('ua.*,');
        $this->db->from('tbl_user_access ua');     
        $this->db->where($where);       
        $query = $this->db->get();
        $result=$query->result_array();

        foreach ($result as $key=>$row) {
            $data[] = $row;
        }
        // echo $this->db->last_query();
        return $result;
    } 


    public function getRoleName($searchTerm='')
     {

        $this->db->select('r.*');
        $this->db->from('tbl_roles r');
        // $this->db->where('r.is_main_role',0);

      
        if($searchTerm){
           $searchCondition = "(     
                r.role_name  like '%$searchTerm%'  
     
            )";
            $this->db->where($searchCondition);
        }
       
        $query = $this->db->get();

      
        return $query->result_array();
    }

    
    public function getBranchName($searchTerm='')
     {

        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.role_id',BRANCH_ROLE);

        if($searchTerm){
           $searchCondition = "(     
                u.first_name  like '%$searchTerm%'  
     
            )";
            $this->db->where($searchCondition);
        }
       
        $query = $this->db->get();

      
        return $query->result_array();
    }

    public function getUserAccessData($id='')
     {
        $this->db->select('ua.*,m.name');
        $this->db->join('tbl_module m','ua.module_id=m.id','left');
        $this->db->from('tbl_user_access ua');
        $this->db->where('ua.user_id',$id);
        $query = $this->db->get();

        // echo $this->db->last_query();die;
        return $query->result_array();
     }


    public function getUserViewData($id='')
     {
       
        $this->db->select('u.*,up.country_id,up.state_id,concat(us.first_name," ",us.last_name) as parent_name,r.role_name,c.name as company_name,s.site_name');
      // pr.role_name as parent_role_name
        
        $this->db->join('user_profile up','up.user_id=u.id','left');
        $this->db->join('users us','us.id=u.parent_staffid','left');
        $this->db->join('tbl_roles r','r.id=u.role_id','left');
         $this->db->join('tbl_company_master c','c.id=u.company_id','left');
            $this->db->join('tbl_site s','s.id=u.site_id','left');

        // $this->db->join('tbl_roles pr','pr.id=u.parent_staff_role','left');
                
        if ($id) {
            $this->db->where('u.id',$id);  
        }
        
       
        
        $this->db->where('u.deleted_by', NULL);
       
        $this->db->from('users u');
    
        $query = $this->db->get();
     // echo $this->db->last_query();die();
        return $query->result_array();
    }

 
}
  ?>