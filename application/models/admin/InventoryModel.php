<?php
   class InventoryModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );

        protected $inventory_details_Column = array(
                                       'indt.id',
                                       'indt.action',
                                       'indt.ref_id',
                                       'indt.company_id',
                                       'indt.site_id',
                                       'indt.type',
                                       '',
                                       '',
                                       
                                   );

       

        public function getInventoryItemData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
           $sql='(SELECT grn1.item_rate_type FROM tbl_grn_items_details grn1 JOIN tbl_grn g1 ON g1.id=grn1.grn_id WHERE inv.item_id = grn1.item_id AND inv.item_unit_id = grn1.item_unit_id AND inv.batch_no = grn1.batch_no AND inv.expired_date = grn1.expired_date AND g1.site_id = inv.site_id AND g1.financial_year_id = inv.financial_year_id order by grn1.id limit 1) as grn_item_rate_type ,(SELECT osd1.item_rate_type FROM tbl_items_opening_stock_details osd1 JOIN tbl_items_opening_stock os1 ON os1.id=osd1.opening_id WHERE inv.item_id = osd1.item_id AND inv.item_unit_id = osd1.opening_unit_id AND inv.batch_no = osd1.batch_no AND inv.expired_date = osd1.expired_date AND os1.location_id = inv.site_id AND os1.financial_year_id = inv.financial_year_id order by osd1.id limit 1) as os_item_rate_type, (SELECT DISTINCT(CASE WHEN rece_d.weight IS NULL OR rece_d.weight = 0.00 THEN 1 ELSE 2 END) FROM tbl_recevied_material_issue_items_details rece_d JOIN tbl_recevied_material_issue rece ON rece.id = rece_d.received_id WHERE inv.item_id = rece_d.item_id AND inv.item_unit_id = rece_d.received_qty_unit AND inv.batch_no = rece_d.batch_no AND inv.expired_date = rece_d.expired_date AND rece.received_location_site_id = inv.site_id AND rece.financial_year_id = inv.financial_year_id order by rece_d.id limit 1) as recev_item_rate_type, (SELECT DISTINCT(grn1.item_rate) FROM tbl_grn_items_details grn1 JOIN tbl_grn g1 ON g1.id=grn1.grn_id WHERE inv.item_id = grn1.item_id AND inv.item_unit_id = grn1.item_unit_id AND inv.batch_no = grn1.batch_no AND inv.expired_date = grn1.expired_date AND g1.site_id=inv.site_id AND g1.financial_year_id=inv.financial_year_id order by grn1.id limit 1) as grn_item_rate , (SELECT DISTINCT(osd1.unit_rate) FROM tbl_items_opening_stock_details osd1 JOIN tbl_items_opening_stock os1 ON os1.id=osd1.opening_id WHERE inv.item_id = osd1.item_id AND inv.item_unit_id = osd1.opening_unit_id AND inv.batch_no = osd1.batch_no AND inv.expired_date = osd1.expired_date AND os1.location_id=inv.site_id AND os1.financial_year_id=inv.financial_year_id order by osd1.id limit 1) as osd1_item_rate, (SELECT DISTINCT(rece_d.rate) FROM tbl_recevied_material_issue_items_details rece_d JOIN tbl_recevied_material_issue rece ON rece.id=rece_d.received_id WHERE inv.item_id=rece_d.item_id AND inv.item_unit_id=rece_d.received_qty_unit AND inv.batch_no=rece_d.batch_no AND inv.expired_date=rece_d.expired_date AND rece.received_location_site_id=inv.site_id AND rece.financial_year_id=inv.financial_year_id order by rece_d.id limit 1) as rece_d_item_rate, (SELECT DISTINCT(grn1.weight_per_rate) FROM tbl_grn_items_details grn1 JOIN tbl_grn g1 ON g1.id=grn1.grn_id WHERE inv.item_id=grn1.item_id AND inv.item_unit_id=grn1.item_unit_id AND inv.batch_no=grn1.batch_no AND inv.expired_date=grn1.expired_date AND g1.site_id=inv.site_id AND g1.financial_year_id=inv.financial_year_id order by grn1.id limit 1) as grn_weight_per_rate, (SELECT DISTINCT(osd1.weight_per_rate) FROM tbl_items_opening_stock_details osd1 JOIN tbl_items_opening_stock os1 ON os1.id=osd1.opening_id WHERE inv.item_id=osd1.item_id AND inv.item_unit_id=osd1.opening_unit_id AND inv.batch_no=osd1.batch_no AND inv.expired_date=osd1.expired_date AND os1.location_id=inv.site_id AND os1.financial_year_id=inv.financial_year_id order by osd1.id limit 1)as osd1_weight_per_rate, (SELECT MAX(rece_d.amount / rece_d.received_qty) FROM tbl_recevied_material_issue_items_details rece_d JOIN tbl_recevied_material_issue rece ON rece.id=rece_d.received_id WHERE inv.item_id=rece_d.item_id AND inv.item_unit_id=rece_d.received_qty_unit AND inv.batch_no=rece_d.batch_no AND inv.expired_date=rece_d.expired_date AND rece.received_location_site_id=inv.site_id AND rece.financial_year_id=inv.financial_year_id order by rece.id limit 1)as rece_weight_per_rate '; 
           $this->db->select('inv.*,i.short_name as item_name,mu.short_name as item_unit_name,c.name as company_name,s.site_name,fy.to_date,fy.from_date,iu.unit_id as type_unit_id,ig.item_group_name,'.$sql);
           $this->db->join('tbl_items i','i.id=inv.item_id');
           $this->db->join('tbl_items_units iu','iu.id=inv.item_unit_id');
           $this->db->join('tbl_master_unit mu','mu.id=iu.unit_id');
           $this->db->join('tbl_company_master c','c.id=inv.company_id');
           $this->db->join('tbl_site s','s.id=inv.site_id');
           $this->db->join('tbl_master_financial_year fy','fy.id=inv.financial_year_id');
           $this->db->join('tbl_item_groups ig','ig.id=i.item_group');
           
            if($id) {
                $this->db->where('inv.id',$id);            
            }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    i.item_name like '%$searchVal%' or
                    inv.batch_no like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
            }
   		
           $this->db->from('tbl_items_inventory inv');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
            
            $result=$query->result_array();
            $where_type_array=array(1,3,4,6);
            // foreach($result as $key=>$value){
                
            //         $this->db->select(' rate,weight,rate_type ');
            //         $this->db->where('inv.item_id',$value['item_id']);  
            //         $this->db->where('inv.item_unit_id',$value['item_unit_id']);  
            //         $this->db->where('inv.batch_no',$value['batch_no']);  
            //         $this->db->where('inv.expired_date',$value['expired_date']); 
            //         $this->db->where('inv.company_id',$value['company_id']); 
            //         $this->db->where('inv.site_id',$value['site_id']); 
            //         $this->db->where('inv.financial_year_id',$value['financial_year_id']); 
            //         $this->db->where_in('inv.type',$where_type_array); 
                    
            //         $this->db->from('tbl_items_inventory_details inv');
                    
            //         $query = $this->db->get();
            //       // echo $this->db->last_query(); 
            //         $row= $query->row_array();
            //         if(!empty($row['rate'])){
            //             $result[$key]['rate']=$row['rate'];
            //             if($row['rate_type']==2){
            //                  $result[$key]['total']=$value['weight']*$row['rate'];
            //             }else{
            //                  $result[$key]['total']=$value['qty']*$row['rate'];
            //             }
                       
            //             $result[$key]['query']=$this->db->last_query();    
            //         }else{
            //             $result[$key]['rate']=0;
            //             $result[$key]['total']=0;
            //         }
            // }
             return $result;
        }

        public function getInventoryDetailsData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="",$where1="",$inv_item_unit_id="")
         {
           
           $this->db->select('indt.*,i.short_name as item_name,mu.short_name as item_unit_name,c.name as company_name,s.site_name,fy.to_date,fy.from_date,concat(u.first_name," ",u.last_name) as user_name');
           $this->db->join('tbl_items i','i.id=indt.item_id');
           $this->db->join('tbl_items_units iu','iu.id=indt.item_unit_id');
            
           
           $this->db->join('tbl_master_unit mu','mu.id=iu.unit_id');
           $this->db->join('tbl_company_master c','c.id=indt.company_id');
           $this->db->join('tbl_site s','s.id=indt.site_id');
           $this->db->join('tbl_master_financial_year fy','fy.id=indt.financial_year_id');
           $this->db->join('users u','u.id=indt.user_id');

           
            
            if($id) {
                $this->db->where('indt.id',$id);            
            }
          
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    indt.item_name like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
            }
           
            if ($where1) {
                $this->db->where($where1);            
            }

            if ($inv_item_unit_id) {
                $this->db->where('indt.item_unit_id',$inv_item_unit_id);            
            }
        
          $this->db->from('tbl_items_inventory_details indt');

            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->inventory_details_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
            // echo $this->db->last_query();die;
             return $query->result_array();

        }


        public function getUnitNameData($item_id=''){

            $this->db->select('iu.*,mu.id as id_unit,mu.short_name as unit_short_name');
            $this->db->join('tbl_master_unit mu','mu.id = iu.unit_id','left');
         
            if ($item_id) {
                $this->db->where('iu.item_id',$item_id);  
            }
               
            $this->db->from('tbl_items_units iu');
            $this->db->group_by('iu.unit_id');

            $query = $this->db->get();
            // echo $this->db->last_query(); 
            return $query->result_array();
        }

        
    }
?>