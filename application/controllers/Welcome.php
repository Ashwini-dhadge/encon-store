<?php
// require_once FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
     function __construct()
        {
                parent::__construct();
                $this->load->model(ADMIN . 'POModel');
               
        }
	public function index()
	{
	    redirect(base_url('admin'));
	   
	}
	
	public function getPOEmailConfirmation($po_id)
	{
		$data['page']="product";
		 $poData = $this->POModel->getViewPoData($po_id);
		 $data['po_data']=$poData[0];
// 		 echo "<pre>";
// 		 print_r($data);die;
	    $this->load->view('confirmation-page',$data);
		
	}
	
	public function updatePOStatus(){
	    $post=$this->input->post();
	    if(isset($post['po_id'])){
	        $this->CommonModel->iudAction('tbl_po', array('vendor_approved'=>1,'vendor_approved_at'=>date('Y-m-d H:i:s')), 'update', array('id' => $post['po_id']));
	    }
	}
	
    public function export_to_excel() {
        ini_set('memory_limit', '1024M'); // 1GB Memory
        set_time_limit(1800); // 30 minutes

        $this->load->database();

        // Optimized query: Fetch all data grouped by company_id
        $query = $this->db->query("
           SELECT
			c.name as company_name,
            s.site_name,
            i.item_name,
            i.item_code,
            u.unit_name,
            inv_d.company_id,
            inv_d.site_id,
            inv_d.financial_year_id,
            inv_d.item_id,
            inv_d.item_unit_id,
            inv_d.batch_no,
            inv_d.expired_date,
            inv_d.is_reserve_stock,             
            sum(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE 0 END) AS total_received,
            sum(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END) AS total_issued,
            (sum(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE 0 END) -  sum(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END))as balance,
            (SELECT GROUP_CONCAT(inv.qty) from tbl_items_inventory inv WHERE inv.company_id=inv_d.company_id and inv.site_id=inv_d.site_id and inv.item_id=inv_d.item_id and  inv.item_unit_id=inv_d.item_unit_id and inv.batch_no=inv_d.batch_no and inv.expired_date=inv_d.expired_date and inv_d.is_reserve_stock=0) as inv_qty
		
        FROM
            `tbl_items_inventory_details` inv_d
        JOIN tbl_company_master c on c.id=inv_d.company_id
        join tbl_site s on s.id=inv_d.site_id
        join tbl_items i on i.id=inv_d.item_id
        join tbl_items_units iu on iu.id=inv_d.item_unit_id
        join tbl_master_unit u on u.id=iu.unit_id
        LEFT JOIN tbl_grn_items_details grn ON
            inv_d.type = 1 AND inv_d.ref_id = grn.grn_id AND inv_d.item_id = grn.item_id AND inv_d.item_unit_id = grn.item_unit_id AND grn.deleted_by IS NULL  and inv_d.batch_no=grn.batch_no and inv_d.sub_ref_id=grn.id
        LEFT JOIN tbl_material_issue_items_details mi ON
            inv_d.type = 2 AND inv_d.ref_id = mi.issue_id AND inv_d.item_id = mi.item_id AND inv_d.item_unit_id = mi.issue_qty_unit AND mi.deleted_by IS NULL  and inv_d.sub_ref_id=mi.id
        LEFT JOIN tbl_items_opening_stock_details os ON
            inv_d.type = 3 AND inv_d.ref_id = os.opening_id AND inv_d.item_id = os.item_id AND inv_d.item_unit_id = os.opening_unit_id AND os.deleted_by IS NULL and os.id=inv_d.sub_ref_id
        LEFT JOIN tbl_recevied_material_issue_items_details rs ON
            inv_d.type = 4 AND inv_d.ref_id = rs.received_id AND inv_d.item_id = rs.item_id AND inv_d.item_unit_id = rs.received_qty_unit AND rs.deleted_by IS NULL and inv_d.sub_ref_id=rs.id
        LEFT JOIN tbl_material_issue_return_details mr ON
            inv_d.type = 5 AND inv_d.ref_id = mr.material_issue_return_id AND inv_d.item_id = mr.item_id AND inv_d.item_unit_id = mr.return_qty_unit AND mr.deleted_by IS NULL and mr.id=inv_d.sub_ref_id
        
        WHERE 
            inv_d.type != 6 AND  
            inv_d.is_reserve_stock = 0 AND           
            inv_d.financial_year_id = 2 
            GROUP by inv_d.company_id,inv_d.site_id,inv_d.item_id,inv_d.item_unit_id,inv_d.batch_no 
            ORDER BY `balance` ASC 
        ");

        $results = $query->result_array();

        $data = $query->result_array();

        if (empty($data)) {
            echo "No data found!";
            return;
        }

        // Group data by company name
        $groupedData = [];
        foreach ($data as $row) {
            $groupedData[$row['company_name']][] = $row;
        }

        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Remove default blank sheet
        $sheetIndex = 0;

        // Loop through companies to create sheets
        foreach ($groupedData as $companyName => $rows) {
            $sheet = $spreadsheet->createSheet($sheetIndex);
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $sheet->setTitle(substr($companyName, 0, 30)); // Sheet name (max 30 chars)

            // Set headers
            $headers = [
                "Site Name", "Item Name", "Item Code", "Unit", "Batch No", 
                "Expired Date", "Total Received", "Total Issued", "Balance"
            ];

            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $col++;
            }

            // Add data rows
            $rowNum = 2;
            foreach ($rows as $row) {
                $sheet->setCellValue('A' . $rowNum, $row['site_name']);
                $sheet->setCellValue('B' . $rowNum, $row['item_name']);
                $sheet->setCellValue('C' . $rowNum, $row['item_code']);
                $sheet->setCellValue('D' . $rowNum, $row['unit_name']);
                $sheet->setCellValue('E' . $rowNum, $row['batch_no']);
                $sheet->setCellValue('F' . $rowNum, $row['expired_date']);
                $sheet->setCellValue('G' . $rowNum, $row['total_received']);
                $sheet->setCellValue('H' . $rowNum, $row['total_issued']);
                $sheet->setCellValue('I' . $rowNum, $row['balance']);
                $rowNum++;
            }

            $sheetIndex++;
        }

        // Set first sheet as active
        $spreadsheet->setActiveSheetIndex(0);

        // Generate file for download
        // $filename = "Inventory_Report_" . date('Ymd') . ".xlsx";
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('php://output');
        // exit();
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false); // Speeds up writing
        $writer->save('php://output'); // Stream data directly
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Inventory_Report.xlsx"');
        header('Content-Length: ' . filesize($tempFile));
        readfile($tempFile);
        unlink($tempFile);
        exit();
        
    }
    
    public function exportToExcel(){
        set_time_limit(0);  // No time limit
ini_set('memory_limit', '512M');  // Increase memory limit
            $directory = FCPATH . 'uploads/reports/';

// Check if directory exists, if not, create it
if (!is_dir($directory)) {
    mkdir($directory, 0777, true); // Create directory with full permissions
}

// Create a new spreadsheet for all companies
$spreadsheet = new Spreadsheet();

// Fetch companies
$query = $this->db->query("SELECT DISTINCT id as company_id, name as company_name FROM tbl_company_master");
$companies = $query->result();

// Iterate through companies
foreach ($companies as $company) {
    // Ensure the company name does not exceed 31 characters for the sheet title
    $sheetTitle = substr($company->company_name, 0, 31);
    $sheetTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $sheetTitle);  // Replace non-alphanumeric characters

    // Create a new sheet for each company
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($sheetTitle);  // Set the sheet title as the truncated company name

    // Set headers for the sheet
    $sheet->setCellValue('A1', 'Company Name');
    $sheet->setCellValue('B1', 'Site Name');
    $sheet->setCellValue('C1', 'Item Name');
    $sheet->setCellValue('D1', 'Unit Name');
    $sheet->setCellValue('E1', 'Batch No');
    $sheet->setCellValue('F1', 'Expired Date');
    $sheet->setCellValue('G1', 'Total Received');
    $sheet->setCellValue('H1', 'Total Issued');
    $sheet->setCellValue('I1', 'Balance');
    $sheet->setCellValue('J1', 'QTY');

    // Fetch data for this company
    // $sql = "SELECT c.name as company_name, s.site_name, i.item_name, inv_d.batch_no,
    //               SUM(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE 0 END) AS total_received,
    //               SUM(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END) AS total_issued,
    //               (SUM(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE 0 END) - SUM(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END)) AS balance
    //         FROM tbl_items_inventory_details inv_d
    //         JOIN tbl_company_master c ON c.id = inv_d.company_id
    //         JOIN tbl_site s ON s.id = inv_d.site_id
    //         JOIN tbl_items i ON i.id = inv_d.item_id
    //         WHERE inv_d.company_id = ?
    //         GROUP BY inv_d.site_id, inv_d.item_id, inv_d.batch_no
    //         ORDER BY balance ASC";
     $sql = "SELECT 
                c.name as company_name, 
                s.site_name, 
                i.item_name, 
                u.unit_name, 
                inv_d.batch_no, 
                inv_d.expired_date, 
                sum(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE 0 END) AS total_received, 
                sum(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END) AS total_issued, 
                (sum(CASE WHEN inv_d.action = 1 THEN inv_d.qty ELSE 0 END) - sum(CASE WHEN inv_d.action = 2 THEN inv_d.qty ELSE 0 END)) as balance,
                (SELECT GROUP_CONCAT(inv.qty) from tbl_items_inventory inv WHERE inv.company_id=inv_d.company_id and inv.site_id=inv_d.site_id and inv.item_id=inv_d.item_id and  inv.item_unit_id=inv_d.item_unit_id and inv.batch_no=inv_d.batch_no and inv.expired_date=inv_d.expired_date and inv_d.is_reserve_stock=0) as inv_qty
		
              
            FROM tbl_items_inventory_details inv_d
            JOIN tbl_company_master c on c.id=inv_d.company_id
            JOIN tbl_site s on s.id=inv_d.site_id
            JOIN tbl_items i on i.id=inv_d.item_id
            JOIN tbl_items_units iu on iu.id=inv_d.item_unit_id
            JOIN tbl_master_unit u on u.id=iu.unit_id
            LEFT JOIN tbl_grn_items_details grn ON inv_d.type = 1 
                 AND inv_d.ref_id = grn.grn_id 
                 AND inv_d.item_id = grn.item_id 
                 AND inv_d.item_unit_id = grn.item_unit_id 
                 AND grn.deleted_by IS NULL  
                 AND inv_d.batch_no=grn.batch_no 
                 AND inv_d.sub_ref_id=grn.id
            LEFT JOIN tbl_material_issue_items_details mi ON inv_d.type = 2 
                 AND inv_d.ref_id = mi.issue_id 
                 AND inv_d.item_id = mi.item_id 
                 AND inv_d.item_unit_id = mi.issue_qty_unit 
                 AND mi.deleted_by IS NULL  
                 AND inv_d.sub_ref_id=mi.id
            LEFT JOIN tbl_items_opening_stock_details os ON inv_d.type = 3 
                 AND inv_d.ref_id = os.opening_id 
                 AND inv_d.item_id = os.item_id 
                 AND inv_d.item_unit_id = os.opening_unit_id 
                 AND os.deleted_by IS NULL 
                 AND os.id=inv_d.sub_ref_id
            LEFT JOIN tbl_recevied_material_issue_items_details rs ON inv_d.type = 4 
                 AND inv_d.ref_id = rs.received_id 
                 AND inv_d.item_id = rs.item_id 
                 AND inv_d.item_unit_id = rs.received_qty_unit 
                 AND rs.deleted_by IS NULL 
                 AND inv_d.sub_ref_id=rs.id
            LEFT JOIN tbl_material_issue_return_details mr ON inv_d.type = 5 
                 AND inv_d.ref_id = mr.material_issue_return_id 
                 AND inv_d.item_id = mr.item_id 
                 AND inv_d.item_unit_id = mr.return_qty_unit 
                 AND mr.deleted_by IS NULL 
                 AND mr.id=inv_d.sub_ref_id
            WHERE inv_d.type != 6 
            AND inv_d.is_reserve_stock = 0 
            AND inv_d.financial_year_id = 2 
            AND inv_d.company_id = ?
            GROUP BY inv_d.company_id, inv_d.site_id, inv_d.item_id, inv_d.item_unit_id, inv_d.batch_no
            ORDER BY balance ASC";
    
    $result = $this->db->query($sql, [$company->company_id])->result();


    // Fill data in the sheet
    $row = 2;
    foreach ($result as $data) {
        $sheet->setCellValue("A$row", $data->company_name);
        $sheet->setCellValue("B$row", $data->site_name);
        $sheet->setCellValue("C$row", $data->item_name);
        $sheet->setCellValue("D$row", $data->unit_name);
        $sheet->setCellValue("E$row", $data->batch_no);
        $sheet->setCellValue("F$row", $data->expired_date);
        $sheet->setCellValue("G$row", $data->total_received);
        $sheet->setCellValue("H$row", $data->total_issued);
        $sheet->setCellValue("I$row", $data->balance);
        $sheet->setCellValue("J$row", $data->inv_qty);
        $row++;
    }
}
        // Save the file for all companies
        $filename = 'inventory_report_all_companies_all.xlsx';
        // Set header for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        // Write to Excel file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');


        // $filePath = $directory . $filename;
        // // $writer = new Xlsx($spreadsheet);
        // // $writer->save($filePath);
        // $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        // $writer->setPreCalculateFormulas(false); // Speeds up writing
        // $writer->save('php://output'); // Stream data directly
        echo "All company reports generated in one Excel file: $filename \n";


    }
    public function updateRefIdOpening1(){
        $sql = "SELECT ref_id FROM `tbl_items_inventory_details` WHERE `type` = 2 and sub_ref_id=2250  and id> 69203  GROUP by ref_id ";
        $query = $this->db->query($sql);
        $result= $query->result_array(); 
    
//   echo $this->db->last_query();die;
    
    foreach($result as $key=>$value){
        
        $sql = "SELECT * FROM tbl_items_inventory_details WHERE type = 2 AND ref_id =  ".$value['ref_id'];
        $query = $this->db->query($sql);
        $result1= $query->result_array(); 
    
            foreach($result1 as $key2=>$value2){
                  
                         $sql2 = "    
                           SELECT id FROM `tbl_material_issue_items_details` inv_d 
                            WHERE
                               issue_id = ".$value['ref_id']." and inv_d.issue_qty=".$value2['qty']." and inv_d.item_id=".$value2['item_id']."  and   inv_d.issue_qty_unit=".$value2['item_unit_id']."  and inv_d.batch_no='".$value2['batch_no']."'  and inv_d.expired_date='".$value2['expired_date']."'" ;
                            $query2 = $this->db->query($sql2);
                            $result2= $query2->row_array(); 
                        
                       // print_r($result1);die;
                    if (!empty($result2['id'])) {
                         $result[$key2]['new_ref_id']=$result2['id'];
                         $result[$key2]['update_id']=$value2['id'];
                        $this->db->where('id', $value2['id'])
                                 ->update('tbl_items_inventory_details', ['sub_ref_id' => $result2['id']]);
                                 
                                  echo $this->db->last_query();echo "<br>";
                    }
            }
    
      
          
        
        // echo $this->db->last_query();
        // echo"<pre>";
     
       
       
    }
    echo "<pre>";
    print_r($result);die;
    }
}
