<?php
class QuotationModel extends CI_Model
{

    protected $dt_Column = array
    (
        'mts.id',
        'mts.title',
        'mts.unit',
    );

    protected $dt_Column2 = array
    (
        'mohf.id',
        'mohf.particulars'
    );

    protected $dt_Column1 = array
    (
        'cq.id',
        'cq.order_no',
        'ccd.contact_person_name',
        'ccd.contact_mobile_no',
        'cq.subject',
        'cq.estimated_date',
        'cq.expiry_date',
    );
    
    public function getTechnicalSpecificationData($searchVal='',$sortColIndex='0',$sortBy='ASC',$limit='0', $offset='0',$id='',$where="")
    {
        $this->db->select('*');
        
        if (strlen($searchVal)) 
        {
            $searchCondition = "(
                mts.title like '%$searchVal%' or
                mts.default_values like '%$searchVal%'
                )";
            $this->db->where($searchCondition);
        }
    
        if ($where) {
            $this->db->where($where);            
                
        }
            
        $this->db->where('mts.deleted_by', NULL);

        $this->db->from('tbl_master_technical_specification mts');

        //$this->db->order_by('mts.id', $sortBy);
        
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();

    }

    public function getFooterNotesData($searchVal='',$sortColIndex='0',$sortBy='ASC',$limit='0', $offset='0',$id='',$where="")
    {
        $this->db->select('*');
        
        if (strlen($searchVal)) 
        {
            $searchCondition = "(
                mts.title like '%$searchVal%' or
                mts.description like '%$searchVal%'
                )";
            $this->db->where($searchCondition);
        }
    
        if ($where) {
            $this->db->where($where);            
                
        }
            
        $this->db->where('mts.deleted_by', NULL);

        $this->db->from('tbl_master_footer_notes mts');

        //$this->db->order_by('mts.id', $sortBy);
        
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();

    }

    /// chetan code 16 05 2024

    public function getCustomerName($searchTerm='',$state_id='',$country_id='')
    {
        $this->db->select('ccd.*'); 
        $this->db->from('tbl_customer ccd');
        $this->db->where('ccd.deleted_by',NULL);


        if($searchTerm){
            $searchCondition = "(
                ccd.company_name like '%$searchTerm%'
                )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
                    ->result_array();
        return $result;
    }

    public function getTaxSlabName($searchTerm='',$state_id='',$country_id='')
    {
        $this->db->select('mts.*, mts.tax_rate as tax_percentage'); 
        $this->db->from('tbl_master_tax mts');
        $this->db->where('mts.is_deleted',0);


        if($searchTerm){
            $searchCondition = "(
                mts.tax_name like '%$searchTerm%'
                )";
            $this->db->where($searchCondition);
        }

        $result = $this->db->get()
                    ->result_array();
        return $result;
    }

    /// end chetan code 16 05 2024


    /// chetan code 17 05 2024

    public function getQuotationListData($searchVal='',$sortColIndex='0',$sortBy='ASC',$limit='0', $offset='0',$id='',$where="")
    {
        $this->db->select('cq.*,ccd.company_name as contact_person_name,ccd.phone as contact_mobile_no');
        $this->db->join('tbl_customer ccd', 'ccd.id = cq.customer_id', 'left');
        
        if (strlen($searchVal)) 
        {
            $searchCondition = "(
                cq.order_no like '%$searchVal%' or
                ccd.contact_person_name like '%$searchVal%' or
                ccd.contact_mobile_no like '%$searchVal%'
                )";
            $this->db->where($searchCondition);
        }
    
        if ($where) {
            $this->db->where($where);            
                
        }
            
        $this->db->where('cq.deleted_by', NULL);

        $this->db->from('tbl_customer_quotation cq');

        //$this->db->order_by('mts.id', $sortBy);
        
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column1[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();

    }


    public function getQuotationTechnicalSpecification($where="")
    {
        $this->db->select('cqts.id as cqts_id,cqts.quotation_id,cqts.master_technical_id,cqts.technical_title,cqts.technical_description,mts.id as mts_id,mts.title,mts.default_values');
        $this->db->join('tbl_master_technical_specification mts', 'mts.id = cqts.master_technical_id', 'left');
        $this->db->where('cqts.deleted_by', NULL);
        $this->db->where($where);
        $this->db->from('tbl_customer_quotation_technical_specification cqts');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    // tbl_customer_quotation_footer_note

    public function getQuotationFooterNotes($where="")
    {
        $this->db->select('cqfn.id as cust_foot_id,cqfn.quotation_id,cqfn.master_footer_note_id,cqfn.technical_title,cqfn.technical_description,mfn.*');
        $this->db->join('tbl_master_footer_notes mfn', 'mfn.id = cqfn.master_footer_note_id', 'left');
        $this->db->where('cqfn.deleted_by', NULL);
        $this->db->where($where);
        $this->db->from('tbl_customer_quotation_footer_note cqfn');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // tbl_customer_quotation_items_details
    // tbl_customer_quotation_tax_details

    public function getQuotationItemDetails($where="")
    {
        // print_r($where['quotation_id']);die;
        $this->db->select('cqid.id as item_id,cqid.quotation_id,cqid.item_name,cqid.item_description,cqid.item_qty,cqid.item_rate,cqid.tax_id,cqid.tax_rate,cqid.tax_value,cqid.item_amount,cqtd.*');
        $this->db->join('tbl_customer_quotation_tax_details cqtd', 'cqtd.quotation_id = '.$where['quotation_id'], 'left'); 
        $this->db->where('cqid.quotation_id',$where['quotation_id']);
        $this->db->where('cqid.deleted_by', NULL);
        $this->db->from('tbl_customer_quotation_items_details cqid');
       
        $query = $this->db->get();
        return $query->result_array();

    }
    
    /// end chetan code 17 05 2024

    // SELECT * FROM `tbl_customer_quotation` WHERE `amendment_main_quotation_id` = 1 OR `id` = 1 ORDER BY `id` DESC LIMIT 1;


    public function getLastQuotation($id)
    {
        $this->db->select('*');
        $this->db->where('amendment_main_quotation_id', $id);
        $this->db->or_where('id', $id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $this->db->from('tbl_customer_quotation');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getOcHeaderFooterData($searchVal='',$sortColIndex='0',$sortBy='ASC',$limit='0', $offset='0',$id='',$where="")
    {
        $this->db->select('*');
        
        if (strlen($searchVal)) 
        {
            $searchCondition = "(
                mohf.particulars like '%$searchVal%'
                )";
            $this->db->where($searchCondition);
        }
    
        if ($where) {
            $this->db->where($where);            
                
        }
            
        $this->db->where('mohf.is_deleted', 0);

        $this->db->from('tbl_master_oc_header_footer mohf');

        //$this->db->order_by('mts.id', $sortBy);
        
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column2[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();

    }

}
?>
