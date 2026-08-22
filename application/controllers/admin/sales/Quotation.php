<?php
/**
 * 
 */
class Quotation extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN.'sales/QuotationModel');
        isLogin();

        $this->load->helper('jpgraph');
        // $this->load->library('tcpdf');

    }

    public function index()
    {
        $data['title'] = 'Quotation';
        $this->load->view(ADMIN.'sales/quotation/list_quotation',$data);
    }

    public function listQuotationData()
    {

        $data = $_POST;
            $columns = [];
            $page = $data['draw'];
            $limit = $data['length'];
            $offset = $data['start'];
            $searchVal = $data['search']['value'];
            $sortColIndex = $data['order'][0]['column'];
            $sortBy = $data['order'][0]['dir'];
            $where = array();

            if($data['customer_id'] !== "all"){
	            $where['cq.customer_id'] = $data['customer_id'];
	        }

            if($data['quotation_status'] !== "all"){
	            $where['cq.quotation_status'] = $data['quotation_status'];
	        }
            

            $count = count($this->QuotationModel->getQuotationListData($searchVal,0,0,0,0,0,$where));
            if($count){
                $result = $this->QuotationModel->getQuotationListData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
                //print_r($result);die;
                foreach ($result as $key => $value) {

                    $total_quotation_amount = $this->CommonModel->getData('tbl_customer_quotation_tax_details',array('quotation_id'=>$value['id']),'item_total_amount');
            
                    $row = []; 

                    array_push($row, $offset+($key+1));

                    // change color order no
                    if($value['amendment_main_quotation_id'] == NULL)
                    {
                        $order_no = '<span style="color:green;"><strong>'.$value['order_no'].'</strong></span>';
                    }
                    else
                    {
                        $order_no = $value['order_no'];
                    }

                    // fetch data where id = $value['id'];
                    

                    array_push($row, $order_no);
                    array_push($row, $value['contact_person_name']);
                    array_push($row, $value['contact_mobile_no']);
                    array_push($row, $total_quotation_amount[0]['item_total_amount']);
                    array_push($row, $value['estimated_date']);
                    array_push($row, $value['expiry_date']);

                    if($value['quotation_status'] == 0)
                    {
                        $quotation_status = '<span class="badge badge-danger">Pending</span>';
                    }
                    else
                    {
                        $quotation_status = '<span class="badge badge-success">Approved</span>';
                    }

                    //print_r($last_amendmend_sequence[0]['amendment_sequences']);die;

                    

                    array_push($row, $quotation_status);
                    
                    
                    $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                    $lastRecord = $this->QuotationModel->getLastQuotation($value['amendment_main_quotation_id']);

                    if ($lastRecord['id'] == $value['id']) {

                        $action = '
                        <a target="_blank" href="' . base_url() . 'admin/sales/Quotation/viewQuotationData/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                        <a href="' . base_url() . 'admin/sales/Quotation/add_quotation/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                        
                        <a href="' . base_url() . 'admin/sales/Quotation/add_quotation/' . $value['id'] . '/amendment" title="Amendment" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="far fa-bookmark"></i></a>

                        <a href="' . base_url() . 'admin/sales/Quotation/add_oc/'.$value['id'].'" title="OC" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="far fa-file-alt"></i></a>

                        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/sales/Quotation/deleteQuotation/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                        ';
                    } else {
                        // $amendment = '';

                        $action = '
                        <a target="_blank" href="' . base_url() . 'admin/sales/Quotation/viewQuotationData/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                        <a href="' . base_url() . 'admin/sales/Quotation/add_quotation/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                        <a href="' . base_url() . 'admin/sales/Quotation/add_oc/'.$value['id'].'" title="OC" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="far fa-file-alt"></i></a>

                        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/sales/Quotation/deleteQuotation/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                        ';
                    }
                    // $action = '  <a href="' . base_url() . 'admin/sales/Quotation/add_quotation/' . $value['id'] . '/amendment" title="Amendment" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="far fa-bookmark"></i></a>';
                    array_push($row, $action);
                    $columns[] = $row;


                }
            }
            $response = [
                'draw' => $page,
                'data' => $columns,
                'recordsTotal' => $count,
                'recordsFiltered' => $count
            ];
            echo json_encode($response);

    }


    public function add_quotation($id=''){

        $data['title'] = 'Add Quotation';
        $data['active'] = 'Quotation';
        $post = $this->input->post();

        $type = $this->uri->segment(6);
        $q_type = $this->input->post('type');

        $random_three_digit = rand(100,999);
        $random_one_digit = rand(1,9);
        /// tbl_customer_quotation
        $quotation_id = $this->input->post('quotation_id');

        $company_id = $this->input->post('company_id');

        $order_no = 'EFFPL/CE-RK/JSW/'.$random_three_digit.'/'.$random_one_digit;
        $order_sequence = $random_one_digit;
        $customer_id = $this->input->post('customer_id');
        $referance = $this->input->post('referance');
        $subject = $this->input->post('subject');
        $estimated_date = $this->input->post('estimated_date');
        $expiry_date = $this->input->post('expiry_date');
        $commercial = $this->input->post('commercial');
        $roiDescription = $this->input->post('roiDescription');

        $quotation_status = 0;

        /// tbl_customer_quotation_roi
        $roi = $this->input->post('roi');

        /// tbl_customer_quotation_items_details insertion
        $discount = $this->input->post('discount');
        $adjustment = $this->input->post('adjustment');
        
        
        
        
        if($post)
        {
            // echo "<pre>";
            // print_r($_POST);die;
            if(empty($quotation_id) || ($q_type == 'amendment'))
            {
                //echo 'insert';die();
                $customer_quotation = array(
                    'company_id' => $company_id,
                    'order_no' => $order_no,
                    'order_sequence' => $order_sequence,
                    'customer_id' => $customer_id,
                    'referance' => $referance,
                    'subject' => $subject,
                    'estimated_date' => $estimated_date,
                    'expiry_date' => $expiry_date,
                    'commercial' => $commercial,
                    'roiDescription' => $roiDescription,
                    'quotation_status' => $quotation_status,
                    'created_by' => userId(),
                    'created_at' => date('Y-m-d H:i:s')
                );

                if($q_type == 'amendment')
                {
                    $customer_quotation['order_no'] = $this->input->post('order_no');
                    $customer_quotation['amendment_main_quotation_id'] = $this->input->post('amendment_main_quotation_id');
                    $customer_quotation['amendment_sequences'] = $this->input->post('amendment_sequences');
                }
    
                $insert_quotation_id = $this->CommonModel->iudAction('tbl_customer_quotation',$customer_quotation,'insert');
                
                
                if($insert_quotation_id)
                {
    
                    $group_b = $post['group-b'];
                    foreach ($group_b as $key => $value) {
                        $customer_quotation_roi = array(
                            'quotation_id' => $insert_quotation_id,
                            'roi_title' => $value['roi_title'],
                            'roi_amount' => $value['roi_amount'],
                            'created_by' => userId(),
                            'created_at' => date('Y-m-d H:i:s')
                        );
    
                        $insert_quotation_roi_id = $this->CommonModel->iudAction('tbl_customer_quotation_roi',$customer_quotation_roi,'insert');
                    }
    
                    /// tbl_customer_quotation_technical_specification insertion
                    foreach ($post['techSpecification'] as $key => $value) {
                        $technical_title = $this->CommonModel->getData('tbl_master_technical_specification',array('id'=>$key),'title');
                        $customer_quotation_technical_specification = array(
                            'quotation_id' => $insert_quotation_id,
                            'master_technical_id' => $key,
                            'technical_title' => $technical_title[0]['title'],
                            'technical_description' => $value,
                            'created_by' => userId(),
                            'created_at' => date('Y-m-d H:i:s')
                        );
    
                        // print_r($key);
    
                        $insert_quotation_technical_specification_id = $this->CommonModel->iudAction('tbl_customer_quotation_technical_specification',$customer_quotation_technical_specification,'insert');
                    }
    
                    $subTotal = 0;
                    $totalTaxValue = 0;
                    $group = $post['group-a'];
                    foreach ($group as $key => $value) {
                          if(!isset($value['tax_slab'])){
                            $value['tax_slab']=4;
                        }
                        $taxRate = $this->CommonModel->getData('tbl_master_tax',array('id'=>$value['tax_slab']),'tax_rate');
    
                        $customer_quotation_items_details = array(
                            'quotation_id' => $insert_quotation_id,
                            'item_name' => isset($value['item_name'])?$value['item_name']:'',
                            'item_description' => $value['description'],
                            'item_qty' => $value['quantity'],
                            'item_rate' => $value['rate'],
                            'tax_id' => $value['tax_slab'],
                            'tax_rate' => $taxRate[0]['tax_rate'],
                            'tax_value' => doubleval($value['calculated_taxAmt']),
                            'item_amount' => $value['amount'],
                            'created_by' => userId(),
                            'created_at' => date('Y-m-d H:i:s')
                        );
    
                        // print_r($customer_quotation_items_details);
    
                        $insert_quotation_items_details_id = $this->CommonModel->iudAction('tbl_customer_quotation_items_details',$customer_quotation_items_details,'insert');
    
                        $subTotal += $value['amount'];
                        $totalTaxValue += doubleval($value['calculated_taxAmt']);
      
                    }
                    
                    $discountAmount = (($subTotal + $totalTaxValue) * $discount) / 100;
    
                    $afterDiscount = $subTotal + $totalTaxValue - $discountAmount;
    
                    $grandTotal = $afterDiscount - $adjustment;
    
    
                    // print_r($grandTotal);die;
                    // tbl_customer_quotation_tax_details insertion
                    $customer_quotation_tax_details = array(
                        'quotation_id' => $insert_quotation_id,
                        'item_total_sub_amount' => $subTotal,
                        'item_total_gst' => round(doubleval($totalTaxValue),2),
                        'discount_percent' => $discount,
                        'discount_amount' => round(doubleval($discountAmount),2),
                        'adjustment_value' => $adjustment,
                        'round_off' => round(doubleval($grandTotal),2),
                        'item_total_amount' => round($grandTotal),
    
                        'created_by' => userId(),
                        'created_at' => date('Y-m-d H:i:s')
                    );
    
                    $insert_quotation_tax_details_id = $this->CommonModel->iudAction('tbl_customer_quotation_tax_details',$customer_quotation_tax_details,'insert');
                      // echo "<pre>";
                      // print_r($customer_quotation_tax_details);die;
    
    
                    // tbl_customer_quotation_footer_notes insertion
                    foreach ($post['footerNotes'] as $key => $value) {
                        $footer_title = $this->CommonModel->getData('tbl_master_footer_notes',array('id'=>$key),'title');
                        $customer_quotation_footer_notes = array(
                            'quotation_id' => $insert_quotation_id,
                            'master_footer_note_id' => $key,
                            'technical_title' => isset($footer_title[0]['title'])?$footer_title[0]['title']:'',
                            'technical_description' => $value,
                            'created_by' => userId(),
                            'created_at' => date('Y-m-d H:i:s')
                        );
    
                          // print_r($customer_quotation_footer_notes);die;
    
                        $insert_quotation_footer_notes_id = $this->CommonModel->iudAction('tbl_customer_quotation_footer_note',$customer_quotation_footer_notes,'insert');
                    }
    
                    $this->session->set_flashdata('success','Quotation Added Succesfully!');
                }
            
            
                redirect(base_url(ADMIN.'sales/quotation'));

            }
            elseif(!empty($quotation_id))
            {
                // print_r($post);
                // die;
                $customer_quotation = array(
                    'company_id' => $company_id,
                    'customer_id' => $customer_id,
                    'referance' => $referance,
                    'subject' => $subject,
                    'estimated_date' => $estimated_date,
                    'expiry_date' => $expiry_date,
                    'commercial' => $commercial,
                    'roiDescription' => $roiDescription,
                    'quotation_status' => $quotation_status,
                    'updated_by' => userId(),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                $update_quotation_id = $this->CommonModel->iudAction('tbl_customer_quotation',$customer_quotation,'update',array('id'=> $quotation_id));

                //print_r($update_quotation_id);die();
                
                if($update_quotation_id)
                {

                    
                    $group_b = $post['group-b'];
                    foreach ($group_b as $key => $value) 
                    {

                        $customer_quotation_roi_id = $value['roi_id'];
                        //print_r($value);
                        $customer_quotation_roi = array(
                            'roi_title' => $value['roi_title'],
                            'roi_amount' => $value['roi_amount'],
                            'updated_by' => userId(),
                            'updated_at' => date('Y-m-d H:i:s')
                        );

                        if(isset($customer_quotation_roi_id))
                        {
                            $update_quotation_roi_id = $this->CommonModel->iudAction('tbl_customer_quotation_roi',$customer_quotation_roi,'update',array('id'=> $customer_quotation_roi_id));
                        }
                        
                        if(empty($customer_quotation_roi_id)){
                            $customer_quotation_roi['quotation_id'] = $quotation_id;
                            $insert_quotation_roi = $this->CommonModel->iudAction('tbl_customer_quotation_roi',$customer_quotation_roi,'insert');
                        }   
                    }

                    $deletedRoiIds = $this->input->post('deletedROIIds');
                    
                    // convert to array
                    $deletedRoiIds1 = explode(',', $deletedRoiIds);
                    if(!empty($deletedRoiIds1))
                    {
                        foreach ($deletedRoiIds1 as $key => $value) {
                            $this->CommonModel->iudAction('tbl_customer_quotation_roi',array(),'delete',array('id'=> $value));
                        }
                    }

                    foreach ($post['techSpecification'] as $key => $value) {
                        $tech_specificationId = $post['tech_specificationId'];
                        $customer_quotation_technical_specification_id = isset($tech_specificationId[$key]) ? $tech_specificationId[$key] : null;

                        $technical_title = $this->CommonModel->getData('tbl_master_technical_specification', array('id'=>$key), 'title');
                        $customer_quotation_technical_specification = array(
                            'quotation_id' => $quotation_id,
                            'master_technical_id' => $key,
                            'technical_title' => $technical_title[0]['title'],
                            'technical_description' => $value,
                            'updated_by' => userId(),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                    
                        //print_r($customer_quotation_technical_specification_id);

                        if (isset($customer_quotation_technical_specification_id)) {
                            
                            $update_quotation_technical_specification_id = $this->CommonModel->iudAction('tbl_customer_quotation_technical_specification', $customer_quotation_technical_specification, 'update', array('id' => $customer_quotation_technical_specification_id));
                        } 
                        
                        
                        if(empty($customer_quotation_technical_specification_id))
                        {
                            
                            $customer_quotation_technical_specification['created_by'] = userId();
                            $customer_quotation_technical_specification['created_at'] = date('Y-m-d H:i:s');
                    
                            $insert_quotation_technical_specification_id = $this->CommonModel->iudAction('tbl_customer_quotation_technical_specification', $customer_quotation_technical_specification, 'insert');
                        }
                    }

                    // deletedTechSpecIds

                    $deletedTechSpecIds = $this->input->post('deletedTechSpecIds');

                    $deletedTechSpecIds1 = explode(',', $deletedTechSpecIds);
                    if(!empty($deletedTechSpecIds1))
                    {
                        foreach ($deletedTechSpecIds1 as $key => $value) {
                            $this->CommonModel->iudAction('tbl_customer_quotation_technical_specification',array(),'delete',array('id'=> $value));
                        }
                    }

                        
                    $subTotal = 0;
                    $totalTaxValue = 0;
                    $group = $post['group-a'];
                   
                    foreach ($group as $key => $value) {
                        if(!isset($value['tax_slab'])){
                            $value['tax_slab']=4;
                        }
                        $taxRate = $this->CommonModel->getData('tbl_master_tax',array('id'=>$value['tax_slab']),'tax_rate');

                        $customer_quotation_items_details_id = $value['quotationItemData_id'];
    
                        $customer_quotation_items_details = array(
            
                            'item_description' => $value['description'],
                            'item_qty' => $value['quantity'],
                            'item_rate' => $value['rate'],
                            'tax_id' => $value['tax_slab'],
                            'tax_rate' => $taxRate[0]['tax_percentage'],
                            'tax_value' => doubleval($value['calculated_taxAmt']),
                            'item_amount' => $value['amount'],
                            'updated_by' => userId(),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
    
                        // echo "<pre>";
                        // print_r($customer_quotation_items_details); 
                        
                        if(isset($customer_quotation_items_details_id))
                        {
                            $update_quotation_items_details = $this->CommonModel->iudAction('tbl_customer_quotation_items_details',$customer_quotation_items_details,'update', array('id'=>$customer_quotation_items_details_id));

                        }

                        if(empty($customer_quotation_items_details_id))
                        {
                            $customer_quotation_items_details['quotation_id'] = $quotation_id;
                            $customer_quotation_items_details['created_by'] = userId();
                            $customer_quotation_items_details['created_at'] = date('Y-m-d H:i:s');

                            $update_quotation_items_details = $this->CommonModel->iudAction('tbl_customer_quotation_items_details',$customer_quotation_items_details,'insert');
                        }


    
                        $subTotal += $value['amount'];
                        $totalTaxValue += doubleval($value['calculated_taxAmt']);

                        $quotationItemDetailsData_id = $value['quotationItemDetailsData_id'];
      
                    }
                    
                    
                    $discountAmount = (($subTotal + $totalTaxValue) * $discount) / 100;
    
                    $afterDiscount = $subTotal + $totalTaxValue - $discountAmount;
    
                    $grandTotal = $afterDiscount - $adjustment;
                    
                    
                    // print_r($quotationItemDetailsData_id);die();
                    // print_r($grandTotal);die;
                    // tbl_customer_quotation_tax_details insertion
                    $customer_quotation_tax_details = array(
                        // 'quotation_id' => $insert_quotation_id,
                        'item_total_sub_amount' => $subTotal,
                        'item_total_gst' => round(doubleval($totalTaxValue),2),
                        'discount_percent' => $discount,
                        'discount_amount' => round(doubleval($discountAmount),2),
                        'adjustment_value' => $adjustment,
                        'round_off' => round(doubleval($grandTotal),2),
                        'item_total_amount' => round($grandTotal),
    
                        'updated_by' => userId(),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    
                    if(isset($customer_quotation_items_details_id))
                    {
                        $update_quotation_tax_details_id = $this->CommonModel->iudAction('tbl_customer_quotation_tax_details',$customer_quotation_tax_details,'update', array('id'=>$quotationItemDetailsData_id));

                    }
                    

                    $cust_foot_id = $post['cust_foot_id'];
                    //print_r($cust_foot_id);die;
                    foreach ($post['footerNotes'] as $key => $value) {
                        $footer_title = $this->CommonModel->getData('tbl_master_footer_notes', array('id' => $key), 'title');
                        //print_r();
                        $customer_quotation_footer_notes = array(
                            'technical_description' => $value,
                            'updated_by' => userId(),
                            'updated_at' => date('Y-m-d H:i:s')
                        );

                        if(isset($cust_foot_id[$key])) {
                            $update_quotation_footer_notes_id = $this->CommonModel->iudAction('tbl_customer_quotation_footer_note', $customer_quotation_footer_notes, 'update', array('id' => $cust_foot_id[$key]));
                        } 
                        
                        
                        if(empty($cust_foot_id[$key]))
                        {
                            $customer_quotation_footer_notes['technical_title'] = $footer_title[0]['title'];
                            $customer_quotation_footer_notes['master_footer_note_id'] = $key;
                            $customer_quotation_footer_notes['quotation_id'] = $quotation_id;
                            $customer_quotation_footer_notes['created_by'] = userId();
                            $customer_quotation_footer_notes['created_at'] = date('Y-m-d H:i:s');
                            $insert_quotation_footer_notes_id = $this->CommonModel->iudAction('tbl_customer_quotation_footer_note', $customer_quotation_footer_notes, 'insert');
                        }
                        
                    }

    
                    $this->session->set_flashdata('success','Quotation Updated Succesfully!');
                    redirect(ADMIN.'sales/Quotation', $data);

                }
            }




            
        }

        if($id)
        {
            // getQuotationData
            // $data['title'] = 'Edit Quotation';
            if($type == 'amendment')
            {
                $data['title'] = 'Amendment Quotation';
            }
            else
            {
                $data['title'] = 'Edit Quotation';
            }

            $data['active'] = 'Quotation';
            // $data['quotationData'] = $this->QuotationModel->getQuotationData($id);
            $data['quotationData'] = $this->CommonModel->getData('tbl_customer_quotation',array('id'=>$id),'id,company_id,order_no,amendment_main_quotation_id,amendment_sequences,customer_id,referance,subject,estimated_date,expiry_date,commercial,roiDescription');
            $data['companyData'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['quotationData'][0]['company_id']),'id,name');
            $data['customerData'] = $this->CommonModel->getData('tbl_customer_contact_details',array('id'=>$data['quotationData'][0]['customer_id']),'id,contact_person_name,contact_mobile_no');
            $data['quotationRoiData'] = $this->CommonModel->getData('tbl_customer_quotation_roi',array('quotation_id'=>$id),'*');

            $data['quotationTechnicalSpecificationData'] = $this->QuotationModel->getQuotationTechnicalSpecification(array('quotation_id'=>$id));

            $data['quotationItemData'] = $this->QuotationModel->getQuotationItemDetails(array('quotation_id'=>$id));

            $data['quotationFooterNotesData'] = $this->QuotationModel->getQuotationFooterNotes(array('quotation_id'=>$id));

            // if($type == 'amendment')
            // {
            //     $data['amendment_main_quotation_id'] = $data['quotationData'][0]['id'];
            //     $get_last_order_no = $this->CommonModel->getData('tbl_customer_quotation',array('id'=>$data['quotationData'][0]['amendment_main_quotation_id']),'order_no'); ;
                
            //     $data['amendment_sequences'] = (isset($get_last_order_no[0]['amendment_sequences']) ? $get_last_order_no[0]['amendment_sequences'] :0) + 1;

            //     $order_no = $data['quotationData'][0]['order_no'];
                
            //     $data['type'] = $type;
            // }

            if($type == 'amendment')
            {
                // Get the main quotation id for reference
                // $data['amendment_main_quotation_id'] = $data['quotationData'][0]['id'];
                $data['amendment_main_quotation_id'] = (isset($data['quotationData'][0]['amendment_main_quotation_id']) ? $data['quotationData'][0]['amendment_main_quotation_id'] : $data['quotationData'][0]['id']);
                //print_r($data['amendment_main_quotation_id']);die;


                // fetch data from the main quotation using amendment_main_quotation_id
                $data['main_quotation_data'] = $this->CommonModel->getData('tbl_customer_quotation', array('id' => $data['amendment_main_quotation_id'],'amendment_main_quotation_id'=> NULL, 'amendment_sequences' => NULL), 'id,order_no,amendment_main_quotation_id, amendment_sequences');

                //print_r($data['main_quotation_data']);die;

                // fetch last amendment data using main quotation id
                $data['amendment_data'] = $this->CommonModel->getData('tbl_customer_quotation', array('amendment_main_quotation_id' => $data['amendment_main_quotation_id']), 'id,order_no,amendment_main_quotation_id, amendment_sequences');

                if(empty($data['amendment_data']))
                {
                    $data['amendment_data'] = $data['main_quotation_data'];
                }
                
                //print_r($data['amendment_data']);die;

                $data['last_amendment_data'] = end($data['amendment_data']);

                //print_r($data['last_amendment_data']);die;

                $last_amendmend_sequence = (isset($data['last_amendment_data']['amendment_sequences']) ? $data['last_amendment_data']['amendment_sequences'] : 0);

                //print_r($last_amendmend_sequence);die;

                //print_r($last_amendmend_sequence);die;

                if($last_amendmend_sequence == 0)
                {
                    $o_sequence = 1;
                }
                else
                {
                    $o_sequence = $data['amendment_data'][0]['amendment_sequences'];
                }


                //$o_sequence = ;

                //print_r($o_sequence);die;
                
                // generate new order number and amendment sequence
                $data['amen_order_no'] = $data['main_quotation_data'][0]['order_no'] . '-' . ($o_sequence + $last_amendmend_sequence);

                //$data['amen_order_no'] = $data['main_quotation_data'][0]['order_no'] . '-' . ((isset($data['amendment_data'][0]['amendment_sequences']) && $data['amendment_data'][0]['amendment_sequences'] != 0) ? $data['amendment_data'][0]['amendment_sequences'] : 1) + $last_amendmend_sequence;


                //print_r($data['amen_order_no']);die;

                // Fetch the last order number and its amendment sequence
                $get_last_order_no = $this->CommonModel->getData('tbl_customer_quotation', array('id' => $data['amendment_main_quotation_id']), 'order_no, amendment_sequences');

                //print_r($get_last_order_no);die;
                // Extract the order number and sequence
                $last_order_no = $get_last_order_no[0]['order_no'];
                $amendment_sequence = isset($get_last_order_no[0]['amendment_sequences']) ? $get_last_order_no[0]['amendment_sequences'] : 0;

                // Increment the amendment sequence for the new order
                $data['amendment_sequences'] = $last_amendmend_sequence + 1;

                // Append the sequence to the original order number to create the new order number
                // $order_no_parts = explode('-', $last_order_no);
                // $order_no_base = $order_no_parts[0]; // Extract the base order number
                // $new_order_no = $order_no_base . '-' . $data['amendment_sequences'];

                // Set the new order number and type for the amendment
                // $order_no = $new_order_no;
                $data['type'] = $type;
            }

            
        }
        


        $this->load->view(ADMIN.'sales/quotation/add_quotation', $data);

    
    }


    public function add_oc($id = '')
    {
        $data['title'] = 'Add OC';
        $data['active'] = 'Quotation';
        $data['quotation_id'] = $id;
        $post = $this->input->post();

        // tbl_customer_quotation
        $data['quotationData'] = $this->CommonModel->getData('tbl_customer_quotation',array('id'=>$id),'id,company_id,order_no,amendment_main_quotation_id,amendment_sequences,customer_id,referance,subject,estimated_date,expiry_date,commercial,roiDescription');
        $data['headerMessageData'] = $this->CommonModel->getData('tbl_master_oc_header_footer','','*');

        if($post)
        {

            $oc = array(
                'customer_id' => $this->input->post('customer_id'),
                'quotation_id' => $this->input->post('quotation_id'),
                'main_quotation_id' => $this->input->post('main_quotation_id'),
                'subject' => $this->input->post('subject'),
                'po_descriptions' => $this->input->post('po_descriptions'),
                'purchase_order_no' => $this->input->post('purchase_order_no'),
                'purchase_order_date' => $this->input->post('purchase_order_date'),
                'proforma_order_no' => $this->input->post('proforma_order_no'),
                'proforma_invoice_date' => $this->input->post('proforma_invoice_date'),
                'ga_drawing_no' => $this->input->post('ga_drawing_no'),
                'oc_referance' => $this->input->post('oc_referance'),
                'header_body_message' => $this->input->post('header_body_message'),
                'footer_body_message' => $this->input->post('footer_body_message'),
                'created_by' => userId(),
                'created_at' => date('Y-m-d H:i:s')
            );

            $insert_oc_id = $this->CommonModel->iudAction('tbl_customer_oc',$oc,'insert');

            if($insert_oc_id)
            {
                $this->session->set_flashdata('success','OC Added Succesfully!');
            }
            else
            {
                $this->session->set_flashdata('error','OC Data Not Added !');
            }

            redirect(base_url(ADMIN.'sales/OC'));
        }

        $this->load->view(ADMIN.'sales/quotation/add_oc', $data);
    }

    public function getOcHeaderFooterData($data= '')
    {
        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $ocHeaderFooterType = $data['ocHeaderFooterType'];
        
        $where = array(
            'type' => $ocHeaderFooterType
        );
    
        // tbl_master_oc_header_footer
        $count = count($this->QuotationModel->getOcHeaderFooterData($searchVal, 0, 0, 0, 0, 0, $where));
    
        if ($count) {
            $result = $this->QuotationModel->getOcHeaderFooterData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);
    
            foreach ($result as $key => $value) {
                $row = []; 
    
                
                array_push($row, '<input type="checkbox" class="checkOCHeaderFooter" name="oc_headerFooter[]" data-particulars="'.$value['particulars'].'" value="'.$value['id'].'" id="oc_headerFooter_'.$value['id'].'" />'); 
                array_push($row, $value['particulars']); 
                
    
                $columns[] = $row;
            }
        }
    
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ];
        echo json_encode($response);
    }
    
    //  public function addQuotation($id='')
    // {
      
    //     $data['title'] = 'Add Quotation';
    //     $data['active'] = 'Customer';
    //     $post = $this->input->post();
       
    //     if ($post) 
    //     {
    //             // echo'<pre>'; print_r($post);die;

    //             $customer= array(
    //                     'city_id' =>isset($post['city_id'])?$post['city_id']:'',
    //                     'state_id' =>isset($post['state_id'])?$post['state_id']:'' ,
    //                     'country_id' =>isset($post['country_id'])?$post['country_id']:'' ,
    //                     'company_name' =>isset($post['company_name'])?$post['company_name']:'',
    //                     'address' =>isset($post['address'])?$post['address']:'',
    //                     'phone' => isset($post['phone'])?$post['phone']:'',
    //                     'email' => isset($post['email'])?$post['email']:'',
    //                     'currency' => isset($post['currency'])?$post['currency']:'',
    //                     'post_code' => isset($post['post_code'])?$post['post_code']:'',
    //                     'rate_type' => isset($post['rate_type'])?$post['rate_type']:'',
    //                     'vat' => isset($post['vat'])?$post['vat']:'',
    //                     'company_id' =>userId('company_id'),
    //                     'site_id' =>userId('site_id'),
                     
    //                 );


    //             $customer_billing_shipping_details= array(
    //                     'billing_company' => isset($post['billing_company'])?$post['billing_company']:'',
    //                     'b_street' => isset($post['b_street'])?$post['b_street']:'',
    //                     'b_post_code' =>isset($post['b_post_code'])?$post['b_post_code']:'',
    //                     'b_city_id' =>isset($post['b_city_id'])?$post['b_city_id']:'',
    //                     'b_country_id' => isset($post['b_country_id'])?$post['b_country_id']:'',
    //                     'b_state_id' => isset($post['b_state_id'] )?$post['b_state_id'] :'',
    //                     's_street' => isset($post['s_street'])?$post['s_street']:'',
    //                     's_post_code' =>isset($post['s_post_code'])?$post['s_post_code']:'',
    //                     's_city_id' => isset($post['s_city_id'])?$post['s_city_id']:'',
    //                     's_country_id' =>isset($post['s_country_id'])?$post['s_country_id']:'' ,
    //                     's_state_id' => isset($post['s_state_id'])?$post['s_state_id']:'',

    //                 );


    //         if(empty($post['id'])) 
    //         {
    //             $customer['created_by'] = userId();
    //             $customer['created_at'] = date('Y-m-d H:i:s');

    //             $insert_id = $this->CommonModel->iudAction('tbl_customer',$customer,'insert');

    //             if($insert_id)
    //             {
    //                 $customer_billing_shipping_details['customer_id']=$insert_id;

    //                 $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer_billing_shipping_details,'insert');
                    
    //                 $this->session->set_flashdata('success','Customer Added Succesfully!');
    //             }
    //             else
    //             {
    //                 $this->session->set_flashdata('error','Customer Data Not Added !');
    //             }
                

    //         }
    //         else
    //         {
    
    //             // $customer['updated_by'] = userId();
    //             // $customer['updated_at'] = date('Y-m-d H:i:s');
    //          // echo "<pre>";  print_r($post);die;
    //             $this->CommonModel->iudAction('tbl_customer',$customer,'update',array('id' => $post['id']));
    //             $this->CommonModel->iudAction('tbl_customer_billing_shipping_details',$customer_billing_shipping_details,'update',array('customer_id' => $post['id']));
                
    //             $this->session->set_flashdata('success','Customer Data Update Successfully');
    //         }
            


    //         redirect(base_url(ADMIN.'sales/Customer'));
    //     }
    
    //         if($id)
    //         {
    //             $customerData = $this->CustomerModel->getCustomerData('', 0, 0, 0, 0,$id);
    //             $data=  $customerData[0];
                
    //             // $data['cust_billing_shipping_deails'] = $this->CommonModel->getData('tbl_customer_billing_shipping_details',array('customer_id'=> $data['id']),'id,billing_company');
    //             $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
    //             $data['city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['city_id']),'id,name');
    //             $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');

    //             $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
    //             $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
    //             $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

    //             $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
    //             $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
    //             $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');


    //         }
    //       // echo '<pre>';print_r($data);die;
    //         $this->load->view(ADMIN.'sales/customer/add_customer',$data); 
  
    // }



    // public function viewCustomerData($id){
    //     $customerData = $this->CustomerModel->getCustomerData('', 0, 0, 0, 0,$id);
    //     $data=  $customerData[0];
    //     $data['city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['city_id']),'id,name');
    //     $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
    //      $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');

    //       $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['b_city_id']),'id,name');
    //         $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['b_country_id']),'id,name');
    //         $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['b_state_id']),'id,name');

            
    //          $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['s_city_id']),'id,name');
    //         $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['s_country_id']),'id,name');
    //         $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['s_state_id']),'id,name');

    //    $this->load->view(ADMIN.'sales/customer/view_customer',$data);
    // }

      //  public function listcountryName($value='')
      // {
      //     if(!isset($_GET['searchTerm'])){ 
      //         $json = [];
      //         $country_name=$this->CustomerModel->getCountryName('');
      //     }else{
      //         $search = $_GET['searchTerm'];
      //         $country_name=$this->CustomerModel->getCountryName($search);
      //     }
      //        foreach ($country_name as $key => $value) {
              
      //         $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
      //         }  
      //     echo json_encode($json);
      // }

    
     // public function listcityName($value='')
     //  {
     //      if(!isset($_GET['searchTerm'])){ 
     //          $json = [];
     //          $city_name=$this->CustomerModel->getCityName('');
     //      }else{
     //          $search = $_GET['searchTerm'];
     //          $city_name=$this->CustomerModel->getCityName($search);
     //      }
     //         foreach ($city_name as $key => $value) {
              
     //          $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
     //          }  
     //      echo json_encode($json);
     //  }

      

      //  public function liststateName($value='')
      // {
      //     if(!isset($_GET['searchTerm'])){ 
      //         $json = [];
      //         $state_name=$this->CustomerModel->getStateName('');
      //     }else{
      //         $search = $_GET['searchTerm'];
      //         $state_name=$this->CustomerModel->getStateName($search);
      //     }
      //        foreach ($state_name as $key => $value) {
              
      //         $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
      //         }  
      //     echo json_encode($json);
      // }
   

    public function deleteQuotation($quotation_id)
    {

        if ($quotation_id) {
            $quotation['deleted_at'] = date('Y-m-d H:i:s');
            $quotation['deleted_by'] = userId();
                if ($this->CommonModel->iudAction('tbl_customer_quotation',$quotation,'update',array('id'=>$quotation_id))){
                    $this->CommonModel->iudAction('tbl_customer_quotation_footer_note',$quotation,'update',array('quotation_id'=>$quotation_id));
                    $this->CommonModel->iudAction('tbl_customer_quotation_items_details',$quotation,'update',array('quotation_id'=>$quotation_id));
                    $this->CommonModel->iudAction('tbl_customer_quotation_roi',$quotation,'update',array('quotation_id'=>$quotation_id));
                    $this->CommonModel->iudAction('tbl_customer_quotation_tax_details',$quotation,'update',array('quotation_id'=>$quotation_id));
                    $this->CommonModel->iudAction('tbl_customer_quotation_technical_specification',$quotation,'update',array('quotation_id'=>$quotation_id));
                
                    $this->session->set_flashdata('success','Quotation Deleted Successfully!');
                }else{
                    $this->session->set_flashdata('error','Fail to Delete Customer ');
                }
        }
        else
        {
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'sales/Quotation'));
    }







    /// chetan code 15 05 2024

    public function getTechnicalSpecification()
    {
      $data = $_POST;
            $columns = [];
            $page = $data['draw'];
            $limit = $data['length'];
            $offset = $data['start'];
            $searchVal = $data['search']['value'];
            $sortColIndex = $data['order'][0]['column'];
            $sortBy = $data['order'][0]['dir'];
            $where = array();
          
            $count = count($this->QuotationModel->getTechnicalSpecificationData($searchVal,0,0,0,0,0,$where));
            if($count){
                $result = $this->QuotationModel->getTechnicalSpecificationData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
              // print_r($result);die;
                  foreach ($result as $key => $value) 
                  {
              
                    $row = []; 
  
                    array_push($row, '<input type="checkbox" class="checkTechSpecipication" data-specificationId="'.$value['id'].'" name="technicalSpecification[]" data-title="'.$value['title'].'" data-defaultValue="'.$value['default_values'].'" value="'.$value['id'].'" id="techSpecification_'.$value['id'].'" />');
                  
                    array_push($row, $value['title']);
                    array_push($row, $value['default_values']);
                    
                    $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";
  
                    // $action = '
                
                    //   <a href="'.base_url().'admin/sales/Customer/viewCustomerData/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>
  
                    //   <a href="'.base_url().'admin/sales/Customer/add_customer/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                  
                  
  
                    //   <a onclick="return '.$confirm.'" href="'.base_url() .'admin/sales/Customer/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                    $action = '';
  
                      
                  
                    array_push($row, $action);
                    
                    $columns[] = $row;
  
                }
            }
            $response = [
                'draw' => $page,
                'data' => $columns,
                'recordsTotal' => $count,
                'recordsFiltered' => $count
            ];
            echo json_encode($response);
    }


    public function getFooterNotesData()
    {
      $data = $_POST;
            $columns = [];
            $page = $data['draw'];
            $limit = $data['length'];
            $offset = $data['start'];
            $searchVal = $data['search']['value'];
            $sortColIndex = $data['order'][0]['column'];
            $sortBy = $data['order'][0]['dir'];
            $where = array();
          
            $count = count($this->QuotationModel->getFooterNotesData($searchVal,0,0,0,0,0,$where));
            if($count){
                $result = $this->QuotationModel->getFooterNotesData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
              // print_r($result);die;
                  foreach ($result as $key => $value) 
                  {
              
                    $row = []; 
  
                    array_push($row, '<input type="checkbox" class="checkFooterNotes" name="footerNotes[]" data-footerNotesId="'.$value['id'].'" data-title="'.$value['title'].'" value="'.$value['id'].'" id="footerNotes_'.$value['id'].'" data-description="'.$value['description'].'" />');
                  
                    array_push($row, $value['title']);
                    array_push($row, $value['description']);
                    
                    $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";
  
                    // $action = '
                
                    //   <a href="'.base_url().'admin/sales/Customer/viewCustomerData/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>
  
                    //   <a href="'.base_url().'admin/sales/Customer/add_customer/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                  
                  
  
                    //   <a onclick="return '.$confirm.'" href="'.base_url() .'admin/sales/Customer/delete/'.$value['id'].'" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';

                    $action = '';
  
                   
                  
                    array_push($row, $action);
                    
                    $columns[] = $row;
  
                }
            }
            $response = [
                'draw' => $page,
                'data' => $columns,
                'recordsTotal' => $count,
                'recordsFiltered' => $count
            ];
            echo json_encode($response);
    }

    /// end chetan code 15 05 2024


    /// chetan code 16 05 2024
    public function listCustomerName($value='')
    {
        if(!isset($_GET['searchTerm'])){ 
            $json = [];
            $customer_name=$this->QuotationModel->getCustomerName('');
        }else{
            $search = $_GET['searchTerm'];
            $customer_name=$this->QuotationModel->getCustomerName($search);
        }
            foreach ($customer_name as $key => $value) {
            
            $json[] = ['id'=>$value['id'], 'text'=>$value['company_name']];
            }  
        echo json_encode($json);
    }

    public function listTaxSlab($value='')
    {
        if(!isset($_GET['searchTerm'])){ 
            $json = [];
            $customer_name=$this->QuotationModel->getTaxSlabName('');
        }else{
            $search = $_GET['searchTerm'];
            $customer_name=$this->QuotationModel->getTaxSlabName($search);
        }
            foreach ($customer_name as $key => $value) {
            
            $json[] = ['id'=>$value['id'], 'text'=>$value['tax_percentage']];
            }  
        echo json_encode($json);
    }

    /// end chetan code 16 05 2024


    /// chetan code 20 05 2024
    public function viewQuotationData($id)
    {
        
        $this->load->library('pdf');
        $this->load->helper('jpgraph');
    
        
          // $this->generateGraph();

        $data['id'] = $id;

        $data['quotationData'] = $this->CommonModel->getData('tbl_customer_quotation',array('id'=>$id),'id,company_id,order_no,customer_id,referance,subject,estimated_date,expiry_date,commercial,roiDescription');
       // echo $this->db->last_query();die;
       // $data['customerData'] = $this->CommonModel->getData('tbl_customer_contact_details',array('id'=>$data['quotationData'][0]['customer_id']),'id,customer_id,contact_person_name,contact_mobile_no');
//         company_name
// address
// phone
// email 
                $data['customerData'] = array();
        //print_r($data['quotationData']);die;
        $data['customerDetails'] = $this->CommonModel->getData('tbl_customer',array('id'=>$data['quotationData'][0]['customer_id']),'company_name,address,phone,email,currency,post_code,rate_type,vat');
        $data['customerBillingShippingDetails'] = $this->CommonModel->getData('tbl_customer_billing_shipping_details',array('customer_id'=>$data['quotationData'][0]['customer_id']),'billing_company,b_street,b_post_code,b_city_id,b_country_id,b_state_id,s_street,s_post_code,s_city_id,s_country_id,s_state_id');


        $data['b_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['customerBillingShippingDetails'][0]['b_city_id']),'id,name');
        $data['b_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['customerBillingShippingDetails'][0]['b_country_id']),'id,name');
        $data['b_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['customerBillingShippingDetails'][0]['b_state_id']),'id,name');

            
        $data['s_city_data'] = $this->CommonModel->getData('cities',array('id'=> $data['customerBillingShippingDetails'][0]['s_city_id']),'id,name');
        $data['s_country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['customerBillingShippingDetails'][0]['s_country_id']),'id,name');
        $data['s_state_data'] = $this->CommonModel->getData('states',array('id'=> $data['customerBillingShippingDetails'][0]['s_state_id']),'id,name');

        

        $data['quotationRoiData'] = $this->CommonModel->getData('tbl_customer_quotation_roi',array('quotation_id'=>$id),'id,roi_title,roi_amount');
        $data['quotationTechnicalSpecificationData'] = $this->QuotationModel->getQuotationTechnicalSpecification(array('quotation_id'=>$id));
        $data['quitationItemData'] = $this->QuotationModel->getQuotationItemDetails(array('quotation_id'=>$id));
        $data['quotationFooterNotesData'] = $this->QuotationModel->getQuotationFooterNotes(array('quotation_id'=>$id));
        $data['quotationTaxDetailsData'] = $this->CommonModel->getData('tbl_customer_quotation_tax_details',array('quotation_id'=>$id),'item_total_sub_amount,item_total_gst,discount_percent,discount_amount,adjustment_value,round_off,item_total_amount');

        $data['company_master_data'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['quotationData'][0]['company_id']),'','','row_array');

        // echo "<pre>";
        // print_r($data['b_city_data']);die;



        $htmlContent = $this->load->view(ADMIN.'sales/quotation/quotationPDFView', $data, true);
    
        $pdf = new TCPDF();

        $pdf->setOpenCell(false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Quotation');

        $pdf->AddPage();

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(5, 5, 5);

        $pdf->SetFont('helvetica', '', 7);

        $pdf->writeHTML($htmlContent);

        //$pdf->Image(base_url() . 'assets/images/graph.png', 15, 140, 0, 0, 'PNG');
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $file_name = "ENCON_QUOTATION.pdf";
      //  ob_end_clean();
        $pdf->Output($file_name, 'I');
    }



    /// end chetan code 20 05 2024


    /// chetan code 21 05 2024
    public function generateGraph() {
        
        load_jpgraph();
    
        
        $data1y = array(40, 60, 80, 100, 120);
        $data2y = array(20, 50, 70, 90, 110);  
    
        
        $graph = new Graph(350, 250, 'auto');
        $graph->SetScale('textlin');
    
        // title
        $graph->title->Set('ROI Comparison');
        $graph->title->SetFont(FF_FONT1, FS_BOLD);
    
        // X-axis
        $graph->xaxis->SetTitle('Year', 'center');
        $graph->xaxis->SetTitleMargin(15);
        $graph->xaxis->SetTickLabels(array('1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year'));
        $graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
        $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10); 
        $graph->xaxis->SetLabelAngle(0); 
    
        // Y-axis
        $graph->yaxis->SetTitle('Value', 'center');
        $graph->yaxis->SetTitleMargin(22);
        $graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
        $graph->yaxis->SetFont(FF_FONT1, FS_NORMAL);
    
        // first bar plot
        $b1plot = new BarPlot($data1y);
        $b1plot->SetFillColor('#6495ED');
        $b1plot->SetLegend('ENCON');
        
    
        // second bar plot
        $b2plot = new BarPlot($data2y);
        $b2plot->SetFillColor('#B22222');
        $b2plot->SetLegend('Existing');



        $graph->legend->SetPos(0.1,0.07,'left','top');
    
    
        $gbplot = new GroupBarPlot(array($b1plot, $b2plot));
        $gbplot->SetWidth(0.6);
        $graph->Add($gbplot);
        


        
        $graph->Stroke(FCPATH . 'assets/images/graph.png');
    }
    
    
    
    
    
    /// end chetan code 21 05 2024

    /// chetan code 24 05 2024
    // public function OCView($id='')
    // {
    //     $data['id'] = $id;  
        
    //     $data['company_master_data'] = $this->CommonModel->getData('tbl_company_master',array('id'=>1),'','','row_array');


    //     $htmlContent = $this->load->view(ADMIN.'sales/quotation/ocPDFView', $data, true);
    
    //     $pdf = new TCPDF();

    //     $pdf->setOpenCell(false);

    //     // Set document information
    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetTitle('Quotation OC');

    //     $pdf->AddPage();

    //     // remove default header/footer
    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(false);

    //     $pdf->SetMargins(5, 5, 5);

    //     $pdf->SetFont('helvetica', '',9);

    //     $pdf->writeHTML($htmlContent);

    //     //$pdf->Image(base_url() . 'assets/images/graph.png', 15, 140, 0, 0, 'PNG');
        
    //     // set auto page breaks
    //     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    

    //     $file_name = "ENCON_QUOTATION_OC.pdf";
    //     ob_end_clean();
    //     $pdf->Output($file_name, 'I');
    // }
   
    /// end chetan code 24 05 2024
}


