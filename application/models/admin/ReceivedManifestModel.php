<?php
   class ReceivedManifestModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       'u.id',
                                       'u.manifest_no',
                                       
                                   );
        public function getReceivedManifestData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="" ,$type=0)
         {
            if( userId('role_id')==HUB_ROLE || userId('role_id')==FRANCHISE_ROLE || userId('role_id')==BRANCH_ROLE){
                $parent_staffid=userId('user_id');
               
            }elseif(userId('role_id') == ADMIN_ROLE || userId('role_id') == SALES_EMPLOYEE || userId('role_id') == ACCOUNT_EMPLOYEE || userId('role_id') == CUSTOMER_SUPPORT || userId('role_id') == OPERATIONAL_EMPLOYEE || userId('role_id') == DELIVERY_BOY){
                    $parent_staffid=userId('parent_staffid'); 
            }
            
           $this->db->select('u.*,v.name as vender_name')
            ->join('tbl_vendor as v','v.id=u.vendor_id','left');
            
            $this->db->group_start();  
            if($id) {
                 $this->db->where('u.id',$id);
            }
   
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    u.manifest_no like '%$searchVal%' or
                    u.origin like '%$searchVal%' or
                    u.destination like '%$searchVal%' 
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                    $this->db->where($where);            
                     
            }//$this->db->where('u.deleted_by', NULL);
            if($type==0){
            $this->db->where('status',MANIFEST_SEND); 
            }
            $this->db->group_end();
            if($type==0){
                if(userId('role_id')!=SUPERADMIN_ROLE){
                $shp_arry=array(MANIFEST_RECVIED);
                $this->db->or_group_start();
                $this->db->where_in('u.status', $shp_arry);
                $this->db->where('u.cureent_parent_id', $parent_staffid);
                $this->db->group_end();
                 }  
            }
           
            $this->db->from('tbl_manifest u');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
             return $query->result_array();
        }

        public function getShipmentData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
         {
            //  /SELECT i.*, group_concat(b.bag_no) FROM tbl_manifest_details i INNER JOIN tbl_shipment_bagging b ON FIND_IN_SET(b.id, i.is_bag_shipment) 
           
           $this->db->select('u.*, group_concat(b.bag_no) as bag_nos,m.status')
            ->join('tbl_shipment_bagging b','FIND_IN_SET(b.id, u.is_bag_shipment)','left')
            ->join('tbl_manifest m','m.id=u.manifest_id');
            if ($id) {
                 $this->db->where('u.id',$id);      
             }
   
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    u.awb_no like '%$searchVal%'or
                    u.actual_weight like '%$searchVal%'
                  )";
                $this->db->where($searchCondition);
            }
   
            if ($where) {
                $this->db->where($where);            
                     
            }//$this->db->where('u.deleted_by', NULL);
            
            $this->db->group_by('u.shipment_id');
            $this->db->from('tbl_manifest_details u');
       
            if($limit){
                $this->db->limit($limit, $offset);
            }
            //$this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
             return $query->result_array();
        }

       
   }
   ?>