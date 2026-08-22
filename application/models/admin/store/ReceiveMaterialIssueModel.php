<?php
   class ReceiveMaterialIssueModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'p.id',
                                       'p.id',
                                       '',
                                       '',
                                       
                                   );
       
        public function getMaterialIssueTransferData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where='',$item_id='',$item_group_id='')
        {
           
             if(isset($item_id) && !empty($item_id) || isset($item_group_id) && !empty($item_group_id)){
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
                             $this->db->where('mii.issue_id = p.id', NULL, false);
                               $subquery =$this->db->get_compiled_select();

                // Fetch the compiled subquery SQL string
                $subquery_sql = "($subquery)";

            }
            
            // echo $subquery_sql;die;
            
            $this->db->select('p.*,s.short_name as location_site_name,s1.short_name as to_location_site_name');
            
            $this->db->join('tbl_site s','s.id=p.issue_location_site_id');
            $this->db->join('tbl_site s1','s1.id=p.issue_to_location_site_id');

            
            if ($id) {
                $this->db->where('p.id',$id);  
            }

            if($where){
                $this->db->where($where);
            }
            
            if(isset($item_id) && !empty($item_id) ||  isset($item_group_id) && !empty($item_group_id) ){
                    $this->db->where("p.id IN $subquery_sql");
            }
            
            
            $this->db->where('p.is_transfer_completed',0);
            $this->db->where('p.issue_type',2);
            $this->db->where('p.deleted_by',NULL);
    
           
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    p.issue_number like '%$searchVal%' or
                    p.issue_date like '%$searchVal%' or
                    p.issue_from like '%$searchVal%' 
                )";
  

 
                $this->db->where($searchCondition);
            }
           
            $this->db->from('tbl_material_issue p');
        
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

            $query = $this->db->get();
            // echo $this->db->last_query();die; 
            return $query->result_array();
        }
         protected $dt_Column1 = array(
                                       'p.id',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        public function getReceviedMaterialData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where='',$item_id='',$item_group_id='')
        {
             if(isset($item_id) && !empty($item_id) || isset($item_group_id) && !empty($item_group_id)){
                    $this->db->select('mii.received_id');
                    $this->db->from('tbl_recevied_material_issue_items_details mii');
                    $this->db->join('tbl_items i','i.id=mii.item_id'); 
                               if(isset($item_id) && !empty($item_id)){
                                 $this->db->where('mii.item_id', $item_id);
                               }
                               if(isset($item_group_id) && !empty($item_group_id)){
                                    $this->db->where('i.item_group', $item_group_id);
                               }
                            
                              $this->db->where('mii.deleted_by', NULL);
                             $this->db->where('mii.received_id = p.id', NULL, false);
                               $subquery =$this->db->get_compiled_select();

                // Fetch the compiled subquery SQL string
                $subquery_sql = "($subquery)";

            }
            
            
            
            $this->db->select('p.*,s.short_name  as recevier_location_site_name,s1.short_name as sender_location_site_name,u.first_name as transfer_first_name,u.last_name as transfer_last_name,u1.first_name as recevier_first_name,u1.last_name as recevier_last_name,p.received_location_site_id as site_id ,s.company_id as company_id ');
            
            $this->db->join('tbl_site s','s.id=p.received_location_site_id');
            $this->db->join('tbl_site s1','s1.id=p.issue_from_location_site_id');
            $this->db->join('users u','u.id=p.transfered_by','left');
            $this->db->join('users u1','u1.id=p.received_by_id','left');

  
 
 
            if ($id) {
                $this->db->where('p.id',$id);  
            }

            if($where){
                $this->db->where($where);
            }
           
            $this->db->where('p.deleted_by',NULL);
    
           
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    p. received_no  like '%$searchVal%' or
                    p.received_date like '%$searchVal%' 
                   
                )";
  

 
                $this->db->where($searchCondition);
            }
            
             if(isset($item_id) && !empty($item_id)){
                    $this->db->where("p.id IN $subquery_sql");
            }
           
            $this->db->from('tbl_recevied_material_issue  p');
        
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column1[$sortColIndex], $sortBy);

            $query = $this->db->get();
           // echo $this->db->last_query();die; 
            return $query->result_array();
        }
        
        
         public function getMaterialIssuePendingCount($where_in_array,$where=''){
            //  print_r($where);
                $this->db->select('(pi.issue_qty) AS total_issue_qty,IFNULL(SUM(gi.received_qty), 0) AS received_qty');        
                $this->db->from('tbl_material_issue_items_details pi');         
                $this->db->join('tbl_items i','i.id=pi.item_id'); 
                $this->db->join('tbl_material_issue p','p.id=pi.issue_id'); 
                $this->db->join('tbl_recevied_material_issue_items_details gi','gi.issue_id=pi.issue_id and pi.item_id = gi.item_id','LEFT'); 
               
                if($where_in_array) {
                      $this->db->where_in('p.id',$where);
                } 
                if($where){
                     $this->db->where($where);
                }
                $this->db->where('pi.deleted_by',NULL);
                $this->db->group_by('p.id');
               
                $result = $this->db->get()
                                   ->row_array();
                
        //    echo $this->db->last_query();die;
             return $result;
        }   
         public function getReceviedMaterialItems($where){
                $this->db->select(' i.item_name,received_qty,unit_name ');        
                $this->db->from('tbl_recevied_material_issue_items_details pi');         
                $this->db->join('tbl_items i','i.id=pi.item_id'); 
                 $this->db->join('tbl_items_units iu','iu.id=pi.received_qty_unit'); 
                 $this->db->join('tbl_master_unit u','u.id=iu.unit_id'); 
               
                if($where) {
                      $this->db->where($where);
                } 
                $this->db->where('pi.deleted_by',NULL);
                
                $result = $this->db->get()
                                   ->result_array();
                
            // echo $this->db->last_query();die;
             return $result;
        }   
        public function viewMaterialIssueTransferData($id='')
        {
            // $this->db->select('p.*,s.site_name as location_site_name,s1.site_name as to_location_site_name,st.site_name,cm.name as company_name,concat(mfy.to_date," to ",mfy.from_date) as financial_year');
            
            // $this->db->join('tbl_site s','s.id=p.issue_location_site_id');
            // $this->db->join('tbl_site s1','s1.id=p.issue_to_location_site_id');

           $this->db->select('p.*,cm.name as company_name,s.site_name as site_name,concat(ib.first_name," ",ib.last_name) as issued_by_name,concat(rqb.first_name," ",rqb.last_name) as request_by_name,concat(rbi.first_name," ",rbi.last_name) as received_by_name,td.role_name as department_name,concat(mfy.to_date," to ",mfy.from_date) as financial_year,vm.account_name as ps_customer_name,csvm.account_name as issue_from_stock_vendor_name,ilsi.site_name as issue_location_site_name,tlsi.site_name as issue_to_location_site_name,trans.account_name as transporter_name');
           
           $this->db->join('tbl_company_master cm','cm.id = p.company_id');
           $this->db->join('tbl_site s','s.id = p.site_id');

           $this->db->join('users ib','ib.id = p.issued_by');
           $this->db->join('users rqb','rqb.id = p.request_by');
           $this->db->join('users rbi','rbi.id = p.received_by_id');
           $this->db->join('tbl_department td','td.id = p.department_id');
           $this->db->join('tbl_master_financial_year mfy','mfy.id = p.financial_year_id');
           $this->db->join('tbl_vendor_master vm','vm.id = p.customer_id','left');
           $this->db->join('tbl_vendor_master csvm','csvm.id = p.issue_from_vendor_id','left');
           $this->db->join('tbl_vendor_master trans','trans.id = p.transporter_id','left');

           $this->db->join('tbl_site ilsi','ilsi.id = p.issue_location_site_id','left');
           $this->db->join('tbl_site tlsi','tlsi.id = p.issue_to_location_site_id','left');



            
            if ($id) {
                $this->db->where('p.id',$id);  
            }

            $this->db->where('p.is_transfer_completed',0);
            $this->db->where('p.issue_type',2);
            $this->db->where('p.deleted_by',NULL);
               
            $this->db->from('tbl_material_issue p');
    
            $query = $this->db->get();
            return $query->result_array();
        }

         protected $dt_Column_1 = array(
                                       'mid.id',
                                       'mid.id',
                                       '',
                                       '',
                                       
                                   );

         public function MaterialIssueItemDataView($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
          $this->db->select('mid.*,ig.item_group_name,i.short_name');
          $this->db->join('tbl_item_groups ig','ig.id=mid.item_group_id');
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
            $this->db->order_by($this->dt_Column_1[$sortColIndex], $sortBy);
            $query = $this->db->get();
         
             return $query->result_array();
        }

                public function viewReceviedMaterialData($id='')
        {
            $this->db->select('p.*,s.site_name as recevier_location_site_name,s1.site_name as sender_location_site_name,u.first_name as transfer_first_name,u.last_name as transfer_last_name,u1.first_name as recevier_first_name,u1.last_name as recevier_last_name,st.site_name,cm.name as company_name,concat(mfy.to_date," to ",mfy.from_date) as financial_year,trans.account_name as transporter_name');
            
            $this->db->join('tbl_site s','s.id=p.received_location_site_id');
            $this->db->join('tbl_site s1','s1.id=p.issue_from_location_site_id');
            $this->db->join('users u','u.id=p.transfered_by','left');
            $this->db->join('users u1','u1.id=p.received_by_id','left');
            $this->db->join('tbl_site st','st.id=p.site_id');
            $this->db->join('tbl_company_master cm','cm.id=p.company_id');
            $this->db->join('tbl_master_financial_year mfy','mfy.id = p.financial_year_id');
            $this->db->join('tbl_vendor_master trans','trans.id = p.transporter_id','left');
            // transporter_name
 
            if ($id) {
                $this->db->where('p.id',$id);  
            }

            $this->db->where('p.deleted_by',NULL);
    
           
            $this->db->from('tbl_recevied_material_issue  p');

            $query = $this->db->get();
           // echo $this->db->last_query();die; 
            return $query->result_array();
        }

          protected $dt_Column_mat1 = array(
                                       'pi.id',
                                       'pi.id',
                                       '',
                                       '',
                                       
                                   );

        public function getReceviedMaterialItemsData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           
           $this->db->select('pi.*,ig.item_group_name,ig.item_group_name as parent_group_name,i.short_name');
           $this->db->join('tbl_item_groups ig','ig.id=pi.item_group_id','left');
           $this->db->join('tbl_items i','i.id=pi.item_id');
           
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
            
            $this->db->where('pi.deleted_by', NULL);
            $this->db->from('tbl_recevied_material_issue_items_details pi'); 
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column_mat1[$sortColIndex], $sortBy);
            
            $query = $this->db->get();
         // echo $this->db->last_query();die;
           $result = $query->result_array();
             foreach ($result as $key => $value) {
                            $this->db->select('i.*');
                            $this->db->from('tbl_items i');
                            if ($value['item_group_id'] != 0) {
                                $this->db->where('i.item_group', $value['item_group_id']);
                            }
                            $result1 = $this->db->get()->result_array();
                            $result[$key]['item_list'] = $result1;
                            $result[$key]['item_unit_list'] = $this->getItemUnitList(['i.item_id' => $value['item_id']]);
                            $result[$key]['item_batch_list'] = $this->getItemUnitBatchList(['i.item_id' => $value['item_id']]);
                        
            }
            return $result;
        }
        public function getItemUnitList($where = '')
    {
        $this->db->select('i.*,i.id as item_unit_id ,u.short_name');
        $this->db->from('tbl_items_units i');
        $this->db->join('tbl_master_unit u', 'u.id=i.unit_id', 'left');

        if ($where) {
            $this->db->where($where);
        }
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();

        return $result;
    }
    public function getItemUnitBatchList($where = '')
    {
        $this->db->select('count(i.id),i.batch_no , sum(qty) as batch_qty');
        $this->db->from('tbl_items_inventory i');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->group_by('i.batch_no');
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();

        return $result;
    }
     }
   ?>
