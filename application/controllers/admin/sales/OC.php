<?php
/**
 * 
 */
class OC extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN.'sales/OCModel');
        $this->load->model(ADMIN.'sales/QuotationModel');

        isLogin();

        $this->load->helper('jpgraph');
        $this->load->library('pdf');

    }

    public function index()
    {
        $data['title'] = 'OC';
        $this->load->view(ADMIN.'sales/oc/list_oc',$data);
    }

    public function listOCData()
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

            $count = count($this->OCModel->getOCListData($searchVal,0,0,0,0,0,$where));
            if($count){
                $result = $this->OCModel->getOCListData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
                //print_r($result);die;
                foreach ($result as $key => $value) {
            
                    $row = []; 

                    array_push($row, $offset+($key+1));
                    array_push($row, $value['order_no']);
                    array_push($row, $value['contact_person_name']);
                    array_push($row, $value['purchase_order_no']);
                    array_push($row, $value['purchase_order_date']);
                    array_push($row, $value['subject']);

                    
                    $confirm = "confirm('Are you sure you want to delete this OC?')";

                    // <a href="' . base_url() . 'admin/sales/Quotation/add_quotation/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-edit" aria-hidden="true"></i></a>

                    // <a href="' . base_url() . 'admin/sales/Quotation/add_oc/'.$value['id'].'" title="OC" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="far fa-file-alt"></i></a>

                    $action = '
                        <a target="_blank" href="' . base_url() . 'admin/sales/OC/viewOCPdf/' . $value['id'] . '" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                        <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/sales/OC/deleteOC/' . $value['id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-bs-placement="top" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                        ';
                
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

    public function add_oc($id = '')
    {
        $data['title'] = 'Add OC';
        $data['active'] = 'Quotation';
        $data['quotation_id'] = $id;
        $post = $this->input->post();

        // tbl_customer_quotation
        $data['quotationData'] = $this->CommonModel->getData('tbl_customer_quotation',array('id'=>$id),'id,company_id,order_no,amendment_main_quotation_id,amendment_sequences,customer_id,referance,subject,estimated_date,expiry_date,commercial,roiDescription');

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

            redirect(base_url(ADMIN.'sales/quotation'));
        }

        $this->load->view(ADMIN.'sales/quotation/add_oc', $data);
    }

    public function viewOCPdf($id)
    {
        $data['id'] = $id;  
        $data['ocData'] = $this->CommonModel->getData('tbl_customer_oc',array('id'=>$id),'*','','row_array');
        $data['quotationData'] = $this->CommonModel->getData('tbl_customer_quotation',array('id'=>$data['ocData']['quotation_id']),'id,company_id,order_no,amendment_main_quotation_id,amendment_sequences,customer_id,referance,subject,estimated_date,expiry_date,commercial,roiDescription');
        
        $data['company_master_data'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['quotationData'][0]['company_id']),'','','row_array');
        // tbl_customer_contact_details
        $data['customerContacts'] = $this->CommonModel->getData('tbl_customer_contact_details',array('customer_id'=>$data['ocData']['customer_id']),'*','','row_array');
        // tbl_customer
        $data['customerData'] = $this->CommonModel->getData('tbl_customer',array('id'=>$data['quotationData'][0]['customer_id']),'*','','row_array');
        // cities
        $data['cities'] = $this->CommonModel->getData('cities',array('id'=>$data['customerData']['city_id']),'*','','row_array');
        // countries
        $data['countries'] = $this->CommonModel->getData('countries',array('id'=>$data['cities']['country_id']),'*','','row_array');
        // states
        $data['states'] = $this->CommonModel->getData('states',array('id'=>$data['cities']['state_id']),'*','','row_array');

        $data['quotationTechnicalSpecificationData'] = $this->QuotationModel->getQuotationTechnicalSpecification(array('quotation_id'=>$data['ocData']['quotation_id']));


        $htmlContent = $this->load->view(ADMIN.'sales/oc/ocPDFView', $data, true);
    

        $pdf = new TCPDF();

        $pdf->setOpenCell(false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Quotation OC');

        $pdf->AddPage();

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(5, 5, 5);

        $pdf->SetFont('helvetica', '',9);

        $pdf->writeHTML($htmlContent);

        //$pdf->Image(base_url() . 'assets/images/graph.png', 15, 140, 0, 0, 'PNG');
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    

        $file_name = "ENCON_QUOTATION_OC.pdf";
        // ob_end_clean();
        $pdf->Output($file_name, 'I');
    }


    public function deleteOC($OCId)
    {  
        if ($OCId) {
            $oc['deleted_at'] = date('Y-m-d H:i:s');
            $oc['deleted_by'] = userId();
                if ($this->CommonModel->iudAction('tbl_customer_oc',$oc,'update',array('id'=>$OCId))){
                    $this->session->set_flashdata('success','OC Deleted Successfully!');
                }else{
                    $this->session->set_flashdata('error','Fail to Delete OC ');
                }
        }
        else
        {
            $this->session->set_flashdata('error',INVAILD_INPUT);
        }
        
        redirect(base_url(ADMIN.'sales/OC'));
    
    }

}
?>