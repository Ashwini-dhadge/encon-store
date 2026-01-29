<?php
   class MaterialIssueModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'mi.id',
                                       'mi.id',
                                       '',
                                       '',
                                       
                                   );
        protected $dt_Column1 = array(
                                       'mid.id',
                                    
                                       '',
                                       
                                   );
        public function getMaterialIssueData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="",$item_id='',$item_group_id='')
         {
            if(isset($item_id) && !empty($item_id)|| isset($item_group_id) && !empty($item_group_id)){
                $this->db->select('mii.issue_id');
                $this->db->from('tbl_material_issue_items_details mii');
                 $this->db->join('tbl_items i','i.id=mii.item_id'); 
                 if(isset($item_id) && !empty($item_id)){
                                 $this->db->where('mii.item_id', $item_id);
                }
                if(isset($item_group_id) && !empty($item_group_id)){
                            $this->db->where('i.item_group', $item_group_id);
                }
                
                $this->db->where('mii.deleted_by', NULL);
                $this->db->where('mii.issue_id = mi.id', NULL, false);
                 $subquery = $this->db->get_compiled_select();

                // Fetch the compiled subquery SQL string
                $subquery_sql = "($subquery)";

            }
             
           
           $this->db->select('mi.*,cm.name as company_name,s.site_name as site_name,concat(ib.first_name," ",ib.last_name) as issued_by_name,concat(rqb.first_name," ",rqb.last_name) as request_by_name,concat(rbi.first_name," ",rbi.last_name) as received_by_name,td.role_name as department_name,v.account_name as vender_name');
           
           $this->db->join('tbl_company_master cm','cm.id = mi.company_id');
           $this->db->join('tbl_site s','s.id = mi.site_id');
           $this->db->join('users ib','ib.id = mi.issued_by');
           $this->db->join('users rqb','rqb.id = mi.request_by');
           $this->db->join('users rbi','rbi.id = mi.received_by_id');
           $this->db->join('tbl_department td','td.id = mi.department_id');
            $this->db->join('tbl_vendor_master v','v.id = mi.issue_from_vendor_id','left');
           
            if ($id) {
                 $this->db->where('mi.id',$id);            
                     
             }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    mi.issue_number like '%$searchVal%' or
                    rqb.first_name like '%$searchVal%' or
                    ib.first_name like '%$searchVal%' or
                    mi.remark like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
    
 
            if ($where) {
                $this->db->where($where);            
                     
            }
   			$this->db->where('mi.deleted_by', NULL);
   			
   			if(isset($item_id) && !empty($item_id)|| isset($item_group_id) && !empty($item_group_id)){
                    $this->db->where("mi.id IN $subquery_sql");
            }
            
            
            $this->db->from('tbl_material_issue mi');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
         
             return $query->result_array();
        }

        public function getMaterialIssueViewData($material_issue_id='')
        {
           
           $this->db->select('mi.*,cm.name as company_name,s.site_name as site_name,concat(ib.first_name," ",ib.last_name) as issued_by_name,concat(rqb.first_name," ",rqb.last_name) as request_by_name,concat(rbi.first_name," ",rbi.last_name) as received_by_name,td.role_name as department_name,concat(mfy.to_date," to ",mfy.from_date) as financial_year,vm.account_name as ps_customer_name,csvm.account_name as issue_from_stock_vendor_name,ilsi.site_name as issue_location_site_name,tlsi.site_name as issue_to_location_site_name,trans.account_name as transporter_name');
           
           $this->db->join('tbl_company_master cm','cm.id = mi.company_id');
           $this->db->join('tbl_site s','s.id = mi.site_id');

           $this->db->join('users ib','ib.id = mi.issued_by');
           $this->db->join('users rqb','rqb.id = mi.request_by');
           $this->db->join('users rbi','rbi.id = mi.received_by_id');
           $this->db->join('tbl_department td','td.id = mi.department_id');
           $this->db->join('tbl_master_financial_year mfy','mfy.id = mi.financial_year_id');
           $this->db->join('tbl_vendor_master vm','vm.id = mi.customer_id','left');
           $this->db->join('tbl_vendor_master csvm','csvm.id = mi.issue_from_vendor_id','left');
           $this->db->join('tbl_vendor_master trans','trans.id = mi.transporter_id','left');

           $this->db->join('tbl_site ilsi','ilsi.id = mi.issue_location_site_id','left');
           $this->db->join('tbl_site tlsi','tlsi.id = mi.issue_to_location_site_id','left');
         
         

            if ($material_issue_id) {
                 $this->db->where('mi.id',$material_issue_id);            
                     
             }
         
            $this->db->where('mi.deleted_by', NULL);
            $this->db->from('tbl_material_issue mi');
       
            $query = $this->db->get();
         
             return $query->result_array();
        }


  



         public function getMaterialIssueItemDataView($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
          $this->db->select('mid.*,ig.item_group_name,i.short_name');
          $this->db->join('tbl_item_groups ig','ig.id=mid.item_group_id','left');
          $this->db->join('tbl_items i','i.id=mid.item_id');
           
           
          if ($where) {
                 $this->db->where($where);            
            }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    i.short_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
            $this->db->where('mid.deleted_by', NULL);
            $this->db->from('tbl_material_issue_items_details mid');
                
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column1[$sortColIndex], $sortBy);
            $query = $this->db->get();
         
             return $query->result_array();
        }
         public function getMaterialIssueItemData($id='',$where='')
         {
           
           $this->db->select('mid.*,ig.item_group_name,ig.item_group_name as parent_group_name,i.short_name,u.unit_name,i.item_name');
           $this->db->join('tbl_item_groups ig','ig.id=mid.item_group_id','left');
           $this->db->join('tbl_items i','i.id=mid.item_id');
           $this->db->join('tbl_items_units iu','iu.id=mid.issue_qty_unit');
           $this->db->join('tbl_master_unit u','u.id=iu.unit_id');

           if($id) {
                 $this->db->where('mid.issue_id',$id);            
            }
               if($where) {
                 $this->db->where($where);            
            }
       
            $this->db->where('mid.deleted_by', NULL);
            $this->db->from('tbl_material_issue_items_details mid');
                
            $query = $this->db->get();
        //  echo $this->db->last_query();die;
             return $query->result_array();
        }



        public function getMaterialItemGroupList($searchTerm='',$where='')
        {
              $this->db->select('ig.*,ig1.item_group_name as parent_group_name '); 
           
              $this->db->from('tbl_item_groups ig');
              $this->db->join('tbl_item_groups ig1','ig1.id=ig.parent_group_id','left');       
          

             if($searchTerm){

                $searchCondition = "(
                    c.item_group_name like '%$searchTerm%'
                     )";

                $this->db->where($searchCondition);
                }
                
                if($where) {
                      $this->db->where($where);
                } 
                
                $this->db->where('ig.status',1);
                $this->db->where('ig.is_deleted', 0);
                $this->db->order_by('ig.item_group_name', 'asc');
                $result = $this->db->get()
                               ->result_array();
              
                return $result;
        }  
        public function getItemUnitList($where=''){
            $this->db->select('i.*,i.id as item_unit_id ,u.short_name');        
            $this->db->from('tbl_items_units i');         
            $this->db->join('tbl_master_unit u','u.id=i.unit_id','left'); 

            if($where) {
                  $this->db->where($where);
            } 
            $result = $this->db->get()
                               ->result_array();
              //echo $this->db->last_query();

            return $result;
        }    
        public function getItemUnitBatchList($where=''){
            $this->db->select('count(i.id),i.batch_no , sum(qty) as batch_qty');        
            $this->db->from('tbl_items_inventory i');         
           
            if($where) {
                  $this->db->where($where);
            } 
            $this->db->group_by('i.batch_no');
            $result = $this->db->get()
                               ->result_array();
              //echo $this->db->last_query();

            return $result;
        } 


        public function getWeightItemUnitList($where=''){
            $this->db->select('i.*,i.id as item_unit_id ,u.short_name as weight_unit');        
            $this->db->from('tbl_items_units i');         
            $this->db->join('tbl_master_unit u','u.id=i.unit_id','left'); 

            if($where) {
                  $this->db->where($where);
            } 

            $result = $this->db->get()
                               ->result_array();
          
              return $result;
        }
    
     }
   ?>
