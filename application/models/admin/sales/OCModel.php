<?php
class OCModel extends CI_Model
{
    protected $dt_Column = array
    (
        'co.id',
        'co.quotation_id',
        'co.customer_id',
        'co.purchase_order_no',
        'co.purchase_order_date',
        'co.subject',

    );

    public function getOCListData($searchVal='',$sortColIndex='0',$sortBy='ASC',$limit='0', $offset='0',$id='',$where="")
    {
        // `id`, `customer_id`, `quotation_id`, `main_quotation_id`, `po_descriptions`, `oc_referance`, `purchase_order_no`, `purchase_order_date`, `ga_drawing_no`, `proforma_order_no`, `proforma_invoice_date`, `header_body_message`, `footer_body_message`, `subject`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_by`, `deleted_at`

        // `id`, `company_id`, `order_no`, `order_sequence`, `amendment_main_quotation_id`, `amendment_sequences`, `commercial`, `roiDescription`, `quotation_status`, `customer_id`, `referance`, `subject`, `estimated_date`, `expiry_date`, `approved_by`, `approved_at`, `quotation_invoice_pdf_name`
        $this->db->select('co.*,ccd.contact_person_name,ccd.contact_mobile_no,cq.id as cq_id,cq.order_no,cq.amendment_main_quotation_id,cq.amendment_sequences,cq.customer_id as cq_customer_id,cq.referance,cq.subject as cq_subject,cq.estimated_date,cq.expiry_date,cq.commercial,cq.roiDescription');
        // tbl_customer_contact_details
        $this->db->join('tbl_customer_contact_details ccd', 'ccd.id = co.customer_id', 'left');
        // tbl_customer_quotation
        $this->db->join('tbl_customer_quotation cq', 'cq.id = co.quotation_id', 'left');
        
        if (strlen($searchVal)) 
        {
            $searchCondition = "(
                oc.purchase_order_no like '%$searchVal%'
                )";
            $this->db->where($searchCondition);
        }
    
        if ($where) {
            $this->db->where($where);            
                
        }
            
        $this->db->where('co.deleted_by', NULL);

        $this->db->from('tbl_customer_oc co');

        //$this->db->order_by('mts.id', $sortBy);
        
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();

    }
}
?>