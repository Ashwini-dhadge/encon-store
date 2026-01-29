<?php
   class CustomerModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
        protected $dt_Column_a = array(
                                        'tp.id',
                                        'tp.plant_narration',
                                        'tp.plant_address',
                                        'tp.billing_company','','',        
                                        '',
                                    );
        protected $dt_Column_b = array(
            'ccd.id',
            'ccd.plant_narration',
            'ccd.plant_address',
            'ccd.billing_company','','',        
            '',
        );

        public function getCustomerData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
        {
        
            $this->db->select('cust.*,s.name as state_name,c.name as city_name,cnt.name as country_name,cbsd.*,cust.id');
            $this->db->join('tbl_customer_billing_shipping_details cbsd','cbsd.customer_id=cust.id');
            $this->db->join('states s','s.id=cust.state_id','left');
            $this->db->join('cities c','c.id=cust.city_id','left');
            $this->db->join('countries cnt','cnt.id=cust.country_id','left');


            if ($id) {
                $this->db->where('cust.id',$id);            
                    
            }
            // $this->db->where('cust.is_deleted', 0);
                $this->db->where('cust.deleted_by',NULL);  

            if (strlen($searchVal)) {
                $searchCondition = "(
                    cust.company_name like '%$searchVal%'
                )";
                $this->db->where($searchCondition);
            }

            if ($where) {
                $this->db->where($where);            
                    
            }//$this->db->where('u.deleted_by', NULL);

            $this->db->from('tbl_customer cust');
    
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
            $query = $this->db->get();
            // echo $this->db->last_query();
            return $query->result_array();
        }

        public function getCountryName($searchTerm='',$where='')
        {
        $this->db->select('co.*'); 
        $this->db->from('countries co');
        // $this->db->where('c.is_active',1);

        if($where) {
            $this->db->where($where);
        }

        if($searchTerm){
            $searchCondition = "(
                co.name like '%$searchTerm%'
                )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
                        ->result_array();
        return $result;
        }

        public function getCityName($searchTerm='',$where='')
        {
        $this->db->select('c.*'); 
        $this->db->from('cities c');
        // $this->db->where('c.is_active',1);

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
   
   
        public function getStateName($searchTerm='',$where='')
        {
            $this->db->select('s.*'); 
            $this->db->from('states s');
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

    public function getitemsName($searchTerm='',$where='')
    {
        $this->db->select('i.*'); 
        $this->db->from('tbl_items i');
        // $this->db->where('c.is_active',1);

        if($where) {
            $this->db->where($where);
        }

        if($searchTerm){
            $searchCondition = "(
                i.item_name like '%$searchTerm%'
                )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
                        ->result_array();
        return $result;
    }



    public function getPlantCustomerData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
    {
        
        $this->db->select('tp.*,sb.name as b_state_name,cb.name as b_city_name,cntb.name as b_country_name,ss.name as s_state_name,sc.name as s_city_name,scnt.name as s_country_name,c.email as customer_email,c.phone as customer_contact_no,tp.id');
        $this->db->join('tbl_customer c','c.id = tp.customer_id','left');
        // $this->db->join('tbl_customer_billing_shipping_details cbsd','cbsd.customer_id=tp.customer_id','left');
        $this->db->join('states sb','sb.id=tp.b_state_id','left');
        $this->db->join('cities cb','cb.id=tp.b_city_id','left');
        $this->db->join('countries cntb','cntb.id=tp.b_country_id','left');

        $this->db->join('states ss','ss.id=tp.s_state_id','left');
        $this->db->join('cities sc','sc.id=tp.s_city_id','left');
        $this->db->join('countries scnt','scnt.id=tp.s_country_id','left');


            if ($id) {
                $this->db->where('tp.id',$id);            
                    
            }
            // $this->db->where('cust.is_deleted', 0);
                $this->db->where('tp.deleted_by',NULL);  

            if (strlen($searchVal)) {
                $searchCondition = "(
                tp.plant_narration like '%$searchVal%' or
                tp.plant_address like '%$searchVal%' or
                cbsd.billing_company like '%$searchVal%' or
                c.email like '%$searchVal%' or
                    c.phone like '%$searchVal%'
                )";
                $this->db->where($searchCondition);
            }

            if ($where) {
                $this->db->where($where);            
                    
            }//$this->db->where('u.deleted_by', NULL);

            $this->db->from('tbl_plant tp');
    
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column_a[$sortColIndex], $sortBy);
            $query = $this->db->get();
            // echo $this->db->last_query();
            return $query->result_array();
    }

        // chetan code 10 05 2024

        public function getCustomerContactDetailsData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
        {
            
            $this->db->select('*');



                if ($id) {
                    $this->db->where('ccd.id',$id);            
                        
                }
                // $this->db->where('cust.is_deleted', 0);
                    $this->db->where('ccd.deleted_by',NULL);  

                if (strlen($searchVal)) {
                    $searchCondition = "(
                    ccd.contact_person_name like '%$searchVal%' or
                    ccd.contact_mobile_no like '%$searchVal%' or
                    ccd.designation like '%$searchVal%'
                    )";
                    $this->db->where($searchCondition);
                }

                if ($where) {
                    $this->db->where($where);            
                        
                }//$this->db->where('u.deleted_by', NULL);

                $this->db->from('tbl_customer_contact_details ccd');
        
                if($limit){
                    $this->db->limit($limit, $offset);
                }
                $this->db->order_by($this->dt_Column_b[$sortColIndex], $sortBy);
                $query = $this->db->get();
                // echo $this->db->last_query();
                return $query->result_array();
        }

        // end chetan code 10 05 2024

      
     }
   ?>
