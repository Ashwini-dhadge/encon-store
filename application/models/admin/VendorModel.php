<?php
class VendorModel extends CI_Model
{

    protected $dt_Column = array(
                                'vm.id',
                                'vm.account_name',
                                'vmd.contact_person_email',
                                'vmd.contact_person_mobile_no',
                                'vmd.address_details',
                                'vmd.city_id',
                                'vmd.pan_no',
                                'vmd.gst_no',
                                'vmd.tan_no',
                                'vmd.tin_no',
                                ''
                            );
 
 

    public function getVendorData($searchVal='',$sortColIndex='0',$sortBy='desc',$limit='0', $offset='0',$id='',$where='',$pan_nm='',$tin_nm='')
        {
            $this->db->select('vmd.*,vm.*,vm.id as vendor_id,c.name as city_name');
            $this->db->join('tbl_vendor_master_details vmd','vmd.vendor_id=vm.id');
            $this->db->join('cities c','c.id=vmd.city_id');
            // $this->db->join('tbl_vendor_master_attachment vma','vma.vendor_id=vm.id');


            
            if ($id) {
                $this->db->where('vm.id',$id);  
            }

            if($where){
                $this->db->where($where);
            }
            
            if($pan_nm == 2){
                $this->db->where('vmd.pan_no !=','');  
            }elseif($pan_nm == 3){
                $this->db->where('vmd.pan_no =','');  
            }

            if($tin_nm == 2){
               $this->db->where('vmd.tin_no !=','');  
            }elseif($tin_nm == 3){
               $this->db->where('vmd.tin_no =','');  
            }
  
           
            if (strlen($searchVal)) {
                 $searchCondition = "(
                    vm.account_name like '%$searchVal%' or
                    vmd.contact_person_email like '%$searchVal%' or
                    vmd.contact_person_mobile_no like '%$searchVal%' or
                    vmd.address_details like '%$searchVal%' or
                    c.name like '%$searchVal%' or
                    vmd.pan_no like '%$searchVal%' or
                    vmd.gst_no like '%$searchVal%' or
                    vmd.tan_no like '%$searchVal%' or
                    vmd.tin_no like '%$searchVal%' 
                )";

                $this->db->where($searchCondition);
            }
           
            $this->db->from('tbl_vendor_master vm');
             $this->db->where('vm.deleted_by',NULL);  
            if($limit){
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

            $query = $this->db->get();
         //  echo $this->db->last_query();die; 
            return $query->result_array();
        }


    public function getViewVendorData($vendor_id='')
        {
            $this->db->select('vmd.*,vm.*,vm.id as vendor_id,c.name as city_name,cm.name as company_name,s.site_name as site_name');
            $this->db->join('tbl_vendor_master_details vmd','vmd.vendor_id=vm.id');
            $this->db->join('cities c','c.id=vmd.city_id');
            $this->db->join('tbl_company_master cm','cm.id=vm.company_id');
            $this->db->join('tbl_site s','s.id=vm.site_id');

            if ($vendor_id) {
                $this->db->where('vm.id',$vendor_id);  
            }
            
            $this->db->from('tbl_vendor_master vm');
            $query = $this->db->get();
           // echo $this->db->last_query();die; 
            return $query->result_array();
        }

    public function getVendorName($searchTerm='')
      {
            $this->db->select('mv.*,vmd.address_details'); 
            $this->db->from('tbl_vendor_master mv');
              $this->db->join('tbl_vendor_master_details vmd','vmd.vendor_id=mv.id');
            if($searchTerm){
                $searchCondition = "(
                    mv.account_name like '%$searchTerm%'
                 )";
                $this->db->where($searchCondition);
            }
             $this->db->where('mv.deleted_by',NULL);  
            $result = $this->db->get()
                           ->result_array();
            return $result;
      }
}
