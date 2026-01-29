<?php
/**
 * 
 */
class CommonCustModel extends CI_Model
{
	// country, state, city
       public function getCoutry($searchTerm='',$where='')
    {
          $this->db->select('c.*'); 
       
          $this->db->from('countries c');
      

         if($searchTerm){

            $searchCondition = "(
                c.name like '%$searchTerm%'
                 )";

            $this->db->where($searchCondition);
            }
            
            if($where) {
            		$this->db->where($where);
            } 

            $result = $this->db->get()
                           ->result_array();

            return $result;
    
    }
     public function getState($searchTerm='',$where='')
    {
          $this->db->select('s.*'); 
          $this->db->from('states s');
        

         if($searchTerm){

            $searchCondition = "(
                s.name like '%$searchTerm%'
                 )";

            $this->db->where($searchCondition);
            }
            
            if($where) {
            $this->db->where($where);
            } 
            
       
            $result = $this->db->get()
                           ->result_array();

            return $result;
    
    }


    public function getCityName($searchTerm='',$where='')
      {
            $this->db->select('c.*'); 
            $this->db->from('cities c');
            $this->db->where('c.is_active',1);
    
            if($where) {
                $this->db->where($where);
            }

            if($searchTerm){
                $searchCondition = "(
                    c.name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }
   

    public function getCompanySite($searchTerm='',$where='')
    {
          $this->db->select('s.id,s.site_name,s.short_name'); 
          $this->db->from('tbl_site s');       

         if($searchTerm){

            $searchCondition = "(
                s.site_name like '%$searchTerm%'
                 )";

            $this->db->where($searchCondition);
            }
            
            if($where) {
            $this->db->where($where);
            }  
            

            $result = $this->db->get()
                           ->result_array();

            return $result;
    
    }  


    
    public function getvenderName($searchTerm = '')
        {
            $this->db->select('v.*');
             
            $this->db->from('tbl_vendor_master v');
      
            if ($searchTerm) {
                $searchCondition = "(
                        v.account_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $result = $this->db->get()
                ->result_array();
            return $result;
        }


        public function getitemgroupName($searchTerm = '')
        {
            $this->db->select('ig.*');
             
            $this->db->from('tbl_item_groups ig');
      
            if ($searchTerm) {
                $searchCondition = "(
                        ig.item_group_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $result = $this->db->get()
                ->result_array();
            return $result;
        }

        public function getuserName($searchTerm = '')
        {
            $this->db->select('u.*,r.role_name');
           $this->db->join('tbl_roles r','r.id=u.role_id','left');
            $this->db->from('users u');
            
            if ($searchTerm) {
                $searchCondition = "(
                        u.first_name like '%$searchTerm%' or
                        u.last_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $this->db->where('u.role_id !=',1);
            
            $result = $this->db->get()
                ->result_array();
            return $result;
        }

        public function getdepartment_Name($searchTerm = '')
        {
            $this->db->select('d.*');
             
            $this->db->from('tbl_department d');
      
            if ($searchTerm) {
                $searchCondition = "(
                        d.role_name like '%$searchTerm%' 
                     )";
                $this->db->where($searchCondition);
            }
            $result = $this->db->get()
                ->result_array();
            return $result;
        }



        public function getlist_po_items_sel_data($searchTerm='',$where='')
        {
              $this->db->select('i.*'); 
              $this->db->from('tbl_items i');     


             if($searchTerm){

                $searchCondition = "(
                     i.item_code like '%$searchTerm%' or
                    i.short_name like '%$searchTerm%' 
                     )";

                $this->db->where($searchCondition);
                }
                
                if($where) {
                $this->db->where($where);
                }  
                

                $result = $this->db->get()
                               ->result_array();

                return $result;
        
        }  
       
        public function getCompanyName($searchTerm='')
      {
            $this->db->select('cm.*'); 
            $this->db->from('tbl_company_master cm');
            $this->db->where('cm.is_active',1);

            if($searchTerm){
                $searchCondition = "(
                    cm.name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }
     public function getInventoryItemName($searchTerm='')
      {
            $this->db->select('i.*'); 
            $this->db->from('tbl_items i');
          
            if($searchTerm){
                $searchCondition = "(
                    i.short_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }
    public function getItemName($searchTerm='',$item_group_id='')
    {
          $this->db->select('i.*'); 
          $this->db->from('tbl_items i');
          $this->db->where('i.deleted_by',NULL);  
         
         if($item_group_id){
            $this->db->where('i.item_group',$item_group_id);
         }

         if($searchTerm){

            $searchCondition = "(
                 i.item_code like '%$searchTerm%' or
                i.short_name like '%$searchTerm%'
                 )";

            $this->db->where($searchCondition);
            }
            
            $result = $this->db->get()
                           ->result_array();

            return $result;
    }
    public function getbatchNo($searchTerm='',$item_id='')
    {
         // $this->db->select('distinct(id.batch_no),item_id'); 
        $this->db->select('id.*'); 
         $this->db->from('tbl_items_inventory_details id');

         if($item_id == "all"){

         }else{
            $this->db->where('id.item_id',$item_id);
         }

         $this->db->group_by('id.batch_no');
        
         if($searchTerm){

            $searchCondition = "(
                id.batch_no like '%$searchTerm%'
            )";

            $this->db->where($searchCondition);
            }
            
            $result = $this->db->get()
                           ->result_array();

            return $result;
    }
     public function getCostProjectName($searchTerm='')
      {
            $this->db->select('tcp.*,'); 
            $this->db->from('tbl_cost_project tcp');
           
            if($searchTerm){
                $searchCondition = "(
                    tcp.cost_project_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }
             $this->db->where('tcp.deleted_by',NULL);  
            $result = $this->db->get()
                           ->result_array();
            return $result;
      }
      
       public function getRateFromGrn($where)
      {
            $this->db->select('item_rate,item_weight,item_rate_type,gi.received_qty'); 
            $this->db->from('tbl_grn_items_details gi');
            $this->db->join('tbl_grn g','g.id=gi.grn_id'); 
           
            if($where){
               $this->db->where($where);
            }
            
            $result = $this->db->get()
                           ->row_array();
            // echo $this->db->last_query();die;
            return $result;
      }
      
      public function getRateFromOpeningStock($where)
      {
            $this->db->select('unit_rate,opening_weight,item_rate_type,gi.opening_qty'); 
            $this->db->from('tbl_items_opening_stock_details gi');
            $this->db->join('tbl_items_opening_stock g','g.id=gi.opening_id'); 
           
            if($where){
               $this->db->where($where);
            }
            
            $result = $this->db->get()
                           ->row_array();
            return $result;
      }
      public function getRateFromPreviousOpeningStock($where)
      {
            $this->db->select('unit_rate,weight,rate_type'); 
            $this->db->from('tbl_items_financial_year_opening_stock_details gi');
            $this->db->join('tbl_items_financial_year_opening_stock g','g.id=gi.financial_year_opening_id'); 
           
            if($where){
               $this->db->where($where);
            }
            
            $result = $this->db->get()
                           ->row_array();
            return $result;
      }
      /*sales */
    public function getPlantName($searchTerm='',$customer_id='')
    {
          $this->db->select('p.*'); 
          $this->db->from('tbl_plant p');

         if($customer_id){
            $this->db->where('p.customer_id',$customer_id);
         }

         if($searchTerm){
            $searchCondition = "(
                p.plant_narration like '%$searchTerm%'
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
        public function getCustommerSite($searchTerm='')
      {
            $this->db->select('c.*'); 
            $this->db->from('tbl_customer c');
           $this->db->where('c.deleted_by',NULL);

            if($searchTerm){
                $searchCondition = "(
                    c.company_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }

            $result = $this->db->get()
                           ->result_array();
            return $result;
      }



}
?>