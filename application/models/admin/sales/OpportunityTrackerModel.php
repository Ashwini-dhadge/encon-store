<?php
class OpportunityTrackerModel extends CI_Model
{

    protected $dt_Column = array(
                               'ot.id',
                               'ot.title',
                               'ot.customer_id',
                               'ot.contact_person_name',
                               'ot.contact_person_mobile_no',
                               'ot.status',
                                ''
                            );
 
 

    public function getOpportunityTrackerData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where='')
        {
            $this->db->select('ot.*,ct.company_name as customer_name,p.plant_narration');
            $this->db->join('tbl_customer ct','ct.id = ot.customer_id');
            $this->db->join('tbl_plant p','p.id = ot.plant_id');


            if ($id) {
                $this->db->where('ot.id',$id);  
            }

            if($where){
                $this->db->where($where);
            }
           
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    ot.title like '%$searchVal%' or
                    ot.date like '%$searchVal%' or
                    ot.contact_person_name like '%$searchVal%' or
                    ot.contact_person_mobile_no like '%$searchVal%'

                )";

                $this->db->where($searchCondition);
            }
           
            $this->db->from('tbl_opportunity_tracker ot');
           
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

            $query = $this->db->get();
          // echo $this->db->last_query();die; 
            return $query->result_array();
        }


    public function dateWiseOpportunityTrackerInfo($id='',$date=''){
        $this->db->select('t.*,ct.company_name as customer_name,r.start_date_time,r.end_date_time,r.title_reminder,p.plant_narration,,concat(u.first_name," ",u.last_name) as created_by_name');
        $this->db->join('tbl_customer ct','ct.id = t.customer_id');
        $this->db->join('tbl_reminder r','r.ref_id = t.id','left');
        $this->db->join('tbl_plant p','p.id = t.plant_id','left');
        $this->db->join('users u','u.id = t.created_by','left');


            if ($id) {
                $this->db->where('t.opp_tracker_id',$id);  
            }
            if ($date) {
                $this->db->where('t.date',$date);  
            }

            $this->db->from('tbl_opportunity_tracker t');
            $this->db->where('t.type',1);
            $this->db->order_by('t.id','DESC');
            // $this->db->group_by('t.date');

            $query = $this->db->get();
         // echo $this->db->last_query();die;
            return $query->result_array();
    }


    public function getdateInfoData($id=''){
        $this->db->select('tr.id,tr.date,tr.created_at');
          
            if ($id) {
                $this->db->where('tr.opp_tracker_id',$id);  
            }

            $this->db->from('tbl_opportunity_tracker tr');
            $this->db->where('tr.type',1);
            $this->db->group_by('tr.date');
            $this->db->order_by('tr.date','DESC');

            $query = $this->db->get();
         // echo $this->db->last_query();
            return $query->result_array();
    }

    public function getCustomerData($customer_id='')
        {
            $this->db->select('tc.*,cm.name as customer_company_name,s.site_name as site_name,c.name as country_name,st.name as state_name,ct.name as city_name,cd.billing_company,cd.b_street,cd.b_post_code,blc.name as b_country_name,bst.name as b_state_name,bct.name as b_city_name,cd.s_street,cd.s_post_code,slc.name as s_country_name,sst.name as s_state_name,sct.name as s_city_name');

            $this->db->join('tbl_customer_billing_shipping_details cd','tc.id = cd.customer_id');
            // tbl_customer
            $this->db->join('tbl_company_master cm','cm.id = tc.company_id');
            $this->db->join('tbl_site s','cm.id = s.company_id');
            $this->db->join('countries c','c.id = tc.country_id ');
            $this->db->join('states st','st.id =tc.state_id');
            $this->db->join('cities ct','ct.id = tc.city_id');
            
            // customer_Details_billing
            $this->db->join('countries blc','blc.id = cd.b_country_id ');
            $this->db->join('states bst','bst.id =cd.b_state_id');
            $this->db->join('cities bct','bct.id = cd.b_city_id');


            // customer_Details_shipping
           $this->db->join('countries slc','slc.id = cd.s_country_id ');
           $this->db->join('states sst','sst.id =cd.s_state_id');
           $this->db->join('cities sct','sct.id = cd.s_city_id');
           // $this->db->join('tbl_company_master cm','cm.id = tc.company_id');


            if ($customer_id) {
                $this->db->where('tc.id',$customer_id);  
            }
            
            $this->db->from('tbl_customer tc');
            $query = $this->db->get();
            return $query->result_array();
        }


    public function viewOpportunityTrackerInfo($id='')
        {
            $this->db->select('tot.*,ct.company_name as customer_name,concat(u.first_name," ",u.last_name) as created_by_name');
            $this->db->join('tbl_customer ct','ct.id = tot.customer_id','left');
            $this->db->join('users u','u.id = tot.created_by','left');

           
            if ($id) {
                $this->db->where('tot.id',$id);  
            }

            // if($where){
            //     $this->db->where($where);
            // }
            
            $this->db->from('tbl_opportunity_tracker tot');
            $this->db->order_by('tot.id','DESC');

            $query = $this->db->get();
         
            return $query->result_array();
        }

}
