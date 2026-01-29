<?php
   class QuotationModel extends CI_Model
   {
   
       protected $dt_Column = array(
                                       '',
                                       '',
                                       '',
                                       '',
                                       
                                   );
          // public function getCustomerData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where="")
          //  {
           
          //    $this->db->select('cust.*,s.name as state_name,c.name as city_name,cnt.name as country_name,cbsd.*');
          //      $this->db->join('tbl_customer_billing_shipping_details cbsd','cbsd.customer_id=cust.id');
          //   $this->db->join('states s','s.id=cust.state_id','left');
          //   $this->db->join('cities c','c.id=cust.city_id','left');
          //   $this->db->join('countries cnt','cnt.id=cust.country_id','left');


          //    if ($id) {
          //         $this->db->where('cust.id',$id);            
                     
          //     }
          //      // $this->db->where('cust.is_deleted', 0);
          //        $this->db->where('cust.deleted_by',0);  
   
          //    if (strlen($searchVal)) {
          //         $searchCondition = "(
          //            cust.company_name like '%$searchVal%'
          //          )";
          //        $this->db->where($searchCondition);
          //    }
   
          //    if ($where) {
          //        $this->db->where($where);            
                     
          //    }//$this->db->where('u.deleted_by', NULL);
   
          //    $this->db->from('tbl_customer cust');
       
          //    if($limit){
          //        $this->db->limit($limit, $offset);
          //    }
          //    $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
          //    $query = $this->db->get();
          //    // echo $this->db->last_query();
          //     return $query->result_array();
          // }

      //       public function getCountryName($searchTerm='',$where='')
      // {
      //       $this->db->select('co.*'); 
      //       $this->db->from('countries co');
      //       // $this->db->where('c.is_active',1);
    
      //       if($where) {
      //           $this->db->where($where);
      //       }

      //       if($searchTerm){
      //           $searchCondition = "(
      //               co.name like '%$searchTerm%'
      //            )";
      //           $this->db->where($searchCondition);
      //       }

      //       $result = $this->db->get()
      //                      ->result_array();
      //       return $result;
      // }

      //   public function getCityName($searchTerm='',$where='')
      // {
      //       $this->db->select('c.*'); 
      //       $this->db->from('cities c');
      //       // $this->db->where('c.is_active',1);
    
      //       if($where) {
      //           $this->db->where($where);
      //       }

      //       if($searchTerm){
      //           $searchCondition = "(
      //               c.name like '%$searchTerm%'
      //            )";
      //           $this->db->where($searchCondition);
      //       }

      //       $result = $this->db->get()
      //                      ->result_array();
      //       return $result;
      // }
   
   
      //   public function getStateName($searchTerm='',$where='')
      // {
      //       $this->db->select('s.*'); 
      //       $this->db->from('states s');
      //       // $this->db->where('c.is_active',1);
    
      //       if($where) {
      //           $this->db->where($where);
      //       }

      //       if($searchTerm){
      //           $searchCondition = "(
      //               s.name like '%$searchTerm%'
      //            )";
      //           $this->db->where($searchCondition);
      //       }

      //       $result = $this->db->get()
      //                      ->result_array();
      //       return $result;
      // }
     }
   ?>
