<?php
   class MaterialIssueReturnModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'mir.id',
                                       'mir.id',
                                       '',
                                       '',
                                       
                                   );
        protected $dt_Column1 = array(
                                       'mid.id',
                                    
                                       '',
                                       
                                   );
        public function getMaterialIssueReturnData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="",$item_id='',$item_group_id='')
         {
             
             if(isset($item_id) && !empty($item_id) || isset($item_group_id) && !empty($item_group_id)){
                    $this->db->select('mii.material_issue_return_id');
                    $this->db->from('tbl_material_issue_return_details mii');
                    $this->db->join('tbl_items i','i.id=mii.item_id'); 
                               if(isset($item_id) && !empty($item_id)){
                                 $this->db->where('mii.item_id', $item_id);
                               }
                               if(isset($item_group_id) && !empty($item_group_id)){
                                    $this->db->where('i.item_group', $item_group_id);
                               }
                            
                              $this->db->where('mii.deleted_by', NULL);
                             $this->db->where('mii.material_issue_return_id = mir.id', NULL, false);
                               $subquery =$this->db->get_compiled_select();

                // Fetch the compiled subquery SQL string
                $subquery_sql = "($subquery)";

            }
           
           $this->db->select('mir.*,cm.name as company_name,s.site_name as site_name,concat(mfy.to_date," to ",mfy.from_date) as financial_year');

           // s.site_name as site_name,concat(rqb.first_name," ",rqb.last_name) as request_by_name,concat(rbi.first_name," ",rbi.last_name) as received_by_name
           
           $this->db->join('tbl_company_master cm','cm.id = mir.company_id');
           $this->db->join('tbl_site s','s.id = mir.site_id');
           $this->db->join('tbl_master_financial_year mfy','mfy.id = mir.financial_year_id');

           // $this->db->join('users rqb','rqb.id = mir.request_by');
           // $this->db->join('users rbi','rbi.id = mir.received_by_id');
         
           
            if ($id) {
                 $this->db->where('mir.id',$id);            
                     
             }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    mir.item_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
             if(isset($item_id) && !empty($item_id) ||  isset($item_group_id) && !empty($item_group_id) ){
                    $this->db->where("mir.id IN $subquery_sql");
            }
   			$this->db->where('mir.deleted_by', NULL);
            $this->db->from('tbl_material_issue_return mir');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
         // echo $this->db->last_query();die;
             return $query->result_array();
        }


         public function getMaterialIssueReturnItemData($id='')
         {
           
           $this->db->select('mid.*,ig.item_group_name,ig.item_group_name as parent_group_name,i.short_name');
           $this->db->join('tbl_item_groups ig','ig.id=mid.item_group_id');
           $this->db->join('tbl_items i','i.id=mid.item_id');
           

           if($id) {
                 $this->db->where('mid.material_issue_return_id',$id);            
            }
       
            $this->db->where('mid.deleted_by', NULL);
            $this->db->from('tbl_material_issue_return_details mid');
                
            $query = $this->db->get();
         
             return $query->result_array();
        }




        public function getItemUnitBatchList($where=''){
            $this->db->select('count(miid.id),miid.batch_no,issue_qty,miid.item_id,miid.issue_qty_unit,miid.batch_no,miid.expired_date,miid.issue_qty');
           
 
            $this->db->from('tbl_material_issue_items_details miid');         
            $this->db->join('tbl_material_issue m','m.id=miid.issue_id'); 
          
            $this->db->where('m.issue_location_site_id',userId('site_id'));
            if($where) {
                  $this->db->where($where);
            } 
            
            $this->db->group_by('miid.batch_no,miid.expired_date');
            $result = $this->db->get()
                               ->result_array();
            //   echo $this->db->last_query();die;

            return $result;
        } 


        public function getItemUnitList($where=''){
            $this->db->select('iid.*,iid.issue_qty_unit as item_unit_id ,u.short_name,iid.rate');      
           
            $this->db->from('tbl_material_issue_items_details iid');   

            $this->db->join('tbl_items_units iu','iu.item_id=iid.item_id and iid.issue_qty_unit=iu.id'); 
            $this->db->join('tbl_master_unit u','u.id=iu.unit_id'); 
            $this->db->join('tbl_material_issue m','m.id=iid.issue_id'); 
          
            $this->db->where('m.issue_location_site_id',userId('site_id'));
            // $this->db->group_by('iid.item_id,iid.item_group_id,iid.issue_qty_unit,iid.batch_no,iid.expired_date');
            $this->db->group_by('iid.item_id,iid.item_group_id,iid.issue_qty_unit');
            if($where) {
                  $this->db->where($where);
            } 
            $result = $this->db->get()
                               ->result_array();
            //   echo $this->db->last_query();die;

            return $result;
        }    


        public function getWeightItemUnitList($where=''){
            $this->db->select('di.*,di.id as item_unit_id ,u.short_name as weight_unit');  
            
            $this->db->from('tbl_material_issue_items_details di');         
            
            $this->db->join('tbl_items_units iu','iu.item_id=di.item_id'); 
            $this->db->join('tbl_master_unit u','u.id=iu.unit_id'); 

            if($where) {
                  $this->db->where($where);
            } 

            $result = $this->db->get()
                               ->result_array();
          
              return $result;
        }




        public function getItemList($where='')
        {
          $this->db->select('i.*,i.id as iditem,i.short_name,i.item_code'); 
          $this->db->from('tbl_items i');
          
           $this->db->join('tbl_material_issue_items_details u','u.item_id=i.id'); 
           $this->db->join('tbl_material_issue m','m.id=u.issue_id'); 
          
            $this->db->where('m.issue_location_site_id',userId('site_id'));
            if($where) {
                  $this->db->where($where);
            } 
            $this->db->group_by('u.item_id');
            $this->db->order_by('i.item_name', 'asc');
            $result = $this->db->get()
                           ->result_array();
            // echo $this->db->last_query();

            return $result;
        }  
   
               public function viewMaterialIssueReturnData($id='')
        {
           
           $this->db->select('mir.*,cm.name as company_name,s.site_name as site_name,concat(mfy.to_date," to ",mfy.from_date) as financial_year,vm.account_name as issue_from_stock_vendor_name,cvm.account_name as ps_customer_name,frts.site_name as from_location_name');
           $this->db->join('tbl_company_master cm','cm.id = mir.company_id');
           $this->db->join('tbl_site s','s.id = mir.site_id');
           $this->db->join('tbl_master_financial_year mfy','mfy.id = mir.financial_year_id');
           $this->db->join('tbl_vendor_master vm','vm.id=mir.issue_from_vendor_id','left');
           $this->db->join('tbl_vendor_master cvm','cvm.id=mir.customer_id','left');
           $this->db->join('tbl_site frts','frts.id=mir.from_location_id','left');
 

            if($id) {
                $this->db->where('mir.id',$id);            
            }
           
            $this->db->where('mir.deleted_by', NULL);
            $this->db->from('tbl_material_issue_return mir');
       
            $query = $this->db->get();
         // echo $this->db->last_query();die;
             return $query->result_array();
        }




        public function getMaterialIssueReturnItemsData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('mid.*,ig.item_group_name,ig.item_group_name as parent_group_name,i.short_name');
           $this->db->join('tbl_item_groups ig','ig.id=mid.item_group_id');
           $this->db->join('tbl_items i','i.id=mid.item_id');
           
           // if($id) {
           //       $this->db->where('mid.material_issue_return_id',$id);            
           //  }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    i.short_name like '%$searchVal%' or
                    ig.item_group_name like '%$searchVal%' 
   
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }
            
            $this->db->where('mid.deleted_by', NULL);
            $this->db->from('tbl_material_issue_return_details mid');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column1[$sortColIndex], $sortBy);
            
            $query = $this->db->get();
         // echo $this->db->last_query();die;
            return $query->result_array();

        }
        public function getMaterialIssueReturnItemData1($id='')
         {
           
          $this->db->select('mid.*,ig.item_group_name,ig.item_group_name as parent_group_name,i.short_name,u.unit_name,i.item_name');
          $this->db->join('tbl_item_groups ig','ig.id=mid.item_group_id','left');
          $this->db->join('tbl_items i','i.id=mid.item_id');
          $this->db->join('tbl_items_units iu','iu.id=mid.return_qty_unit');
          $this->db->join('tbl_master_unit u','u.id=iu.unit_id');

          if($id) {
                 $this->db->where('mid.material_issue_return_id',$id);            
            }
       
            $this->db->where('mid.deleted_by', NULL);
            $this->db->from('tbl_material_issue_return_details mid');
                
            $query = $this->db->get();
        //  echo $this->db->last_query();die;
             return $query->result_array();
        }


     
 
}

?>
