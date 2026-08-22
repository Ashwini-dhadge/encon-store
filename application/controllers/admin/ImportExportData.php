<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExportData extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('admin/CommonModel');
        $this->load->library('form_validation');
        $this->load->helper('file');
    }
    
    public function importVendor(){
        $data = array();
        $data['title']="Add Users";
      
        $this->load->view('admin/import/vendor_import', $data);
    }
     public function download1()
       {
            $table_columns = array('pincode','city_category_name','is_prepaid','is_serviceable','is_cash','is_reverse_pickup','is_cod','nearest_airport1','nearest_airport2','km_nearest_airport1','km_nearest_airport2','nearest_railwaystation1','km_nearest_railwaystation1','nearest_railwaystation2','km_nearest_railwaystation2','latitude','longitude');

            $columns=array();
            exportCsv1($table_columns,$columns,'pincode_format');
       }


/* ================================================================================================= 
    Used to Pincode Module
   ================================================================================================= */

      

/* ================================================================================================= 
    used to city to city additonal Rate Module
   ================================================================================================= */
  public function all_vendor_import() {
        $data = array();
        $memData = $response = array();
        $post = $this->input->post();
       
        if (!empty($_FILES)) {
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
                echo is_uploaded_file($_FILES['file']['tmp_name']);
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('CSVReader');
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    echo "<pre>";
                    print_r($csvData);
                    $i = 0;
                    $response = array();
                    $response['member'] = array();
                    foreach ($csvData as $key => $row) {
                        // print_r($row);
                        if (!empty($row)) {
                            if (isset($row['CITY']) && !empty($row['CITY'])) {
                                $row['CITY']=trim($row['CITY']);
                                $checkExistCity = $this->CommonModel->getData('cities', array('name like' =>$row['CITY']), 'id as city_id ', '', 'row_array');
                                if (isset($checkExistCity['city_id'])) {
                                    $city_id = $checkExistCity['city_id'];
                                } else {
                                    //insert state if not found
                                    if(isset($row['STATE']) && !empty($row['STATE'])){
                                        $row['STATE']=trim($row['STATE']);
                                         if($row['STATE']=='MAHARASTRA'){
                                            $row['STATE']='Maharashtra';
                                         }
                                         
                                          $checkExistState = $this->CommonModel->getData('states', array('name like' => $row['STATE']), 'id as state_id,country_id,country_code ', '', 'row_array');
                                          if(isset($checkExistState['state_id'])){
                                            $state_id=$checkExistState['state_id'];
                                            //insert city
                                             $city_id = $this->CommonModel->iudAction('cities', array('state_id' => $state_id, 'state_code' => NULL,'country_id'=> $checkExistState['country_id'],'country_code'=> $checkExistState['country_code']), 'insert');
                                          }else{
                                            $state_id = $this->CommonModel->iudAction('states', array('name' => $row['STATE'], 'country_id'=>'101','country_code'=>'IN'), 'insert');
                                            $city_id = $this->CommonModel->iudAction('cities', array('state_id' => $state_id, 'state_code' => NULL,'country_id'=>'101','country_code'=>'IN'), 'insert');
                                          }
                                    }
                                }
                            } else {
                                $city_id =NULL;
                            }    
                            
                            if(isset($row['NAME'])){
                                $row['NAME']=trim($row['NAME']);
                                  $vendor_nsert_data=array(
                                                    'account_name'=>(isset($row['NAME']))?$row['NAME']:NULL,
                                                    'company_id'=>9,
                                                    'site_id'=>25,
                                                    'created_by'=>1,
                                                );
                                $vendor_id= $this->CommonModel->iudAction('tbl_vendor_master', $vendor_nsert_data, 'insert');
                                 
                                $master_data=array('address_details'=>(isset($row['ADDRESS'])?$row['ADDRESS']:NULL),
                                                    'address_2'=>(isset($row['ADDRLINE2'])?$row['ADDRLINE2']:NULL),
                                                    'city_id'=>($city_id)?$city_id:NULL,
                                                    'pincode'=>(isset($row['PINCODE'])?$row['PINCODE']:NULL),
                                                    'phone_no_1'=>(isset($row['LEDGERPHONE'])?$row['LEDGERPHONE']:NULL),
                                                    'contact_person_name'=>(isset($row['LEDGERCONTACT'])?$row['LEDGERCONTACT']:NULL),
                                                    'contact_person_mobile_no'=>(isset($row['LEDGERPHONE'])?$row['LEDGERPHONE']:NULL),
                                                    'contact_person_email'=>(isset($row['EMAIL'])?$row['EMAIL']:NULL),
                                                    'gst_no '=>(isset($row['GSTINNO'])?$row['GSTINNO']:NULL),
                                                    'vendor_id'=>$vendor_id
                                                    );
                                $this->CommonModel->iudAction('tbl_vendor_master_details', $master_data, 'insert');
                            }
                
                              

                        }
                    }
                } else {
                    $response['total_num_row'] = count($csvData);
                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                }
           
           // $response['total_num_row'] = count($csvData);

            // echo "<pre>";
            // print_r($response);die;
         
        } else {
            $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
        }
    }

  public function all_master_item() {
        $data = array();
        $memData = $response = array();
        $post = $this->input->post();
       
        if (!empty($_FILES)) {
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
                //echo is_uploaded_file($_FILES['file']['tmp_name']);
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('CSVReader');
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    echo "<pre>";
                   // print_r($csvData);die;
                    $i = 0;
                    $response = array();
                    $response['member'] = array();
                    foreach ($csvData as $key => $row) {
                        // print_r($row);
                        if (!empty($row)) {
                            // if (isset($row['ITEM TYPE']) && !empty($row['ITEM TYPE'])) {
                            //      $row['ITEM TYPE']=trim($row['ITEM TYPE']);
                            //     $checkExistItemType = $this->CommonModel->getData('tbl_master_item_type', array('item_type_name like' =>trim($row['ITEM TYPE'])), 'id', '', 'row_array');
                            //     if (isset($checkExistItemType['id'])) {
                            //         $item_type_id = $checkExistItemType['id'];
                            //     } else {
                            //         //insert state if not found
                            //          $item_type_id = $this->CommonModel->iudAction('tbl_master_item_type', array('item_type_name' =>trim($row['ITEM TYPE']), 'status' => 1,'created_by'=> 1), 'insert');
                            //     }
                            // } else {
                            //     $item_type_id =NULL;
                            // }    
                             $item_type_id=$row['ITEM TYPE'];


 
                            if (isset($row['Item Group']) && !empty($row['Item Group'])) {
                                $row['Item Group']=trim($row['Item Group']);
                                if($row['Item Group']==273){
                                    $item_group =273;  
                                }else{
                                        $checkExistItemGroup = $this->CommonModel->getData('tbl_item_groups', array('item_group_name like' =>trim($row['Item Group'])), 'id ', '', 'row_array');
                                        if (isset($checkExistItemGroup['id'])) {
                                            $item_group = $checkExistItemGroup['id'];
                                        } else {
                                            //insert state if not found
                                             $item_group = $this->CommonModel->iudAction('tbl_item_groups', array('item_group_name' =>trim($row['Item Group']),'item_type_id'=>$item_type_id,'parent_group_id'=>NULL,'item_level'=>0,'status' => 1,'created_by'=> 1), 'insert');
                                        }
                                }
                               
                            } else {
                                $item_group =NULL;
                            }    
                             //$item_group =$row['Item Group'];
                            //   $item_unit_id =array();
                            //  if (isset($row['UNIT STOCK']) && !empty($row['UNIT STOCK'])) {
                            //     $row['UNIT STOCK']=trim($row['UNIT STOCK']);
                            //     $item_units=explode("&",$row['UNIT STOCK']);
                            //     foreach($item_units as $key=>$value){
                            //             $checkExist1 = $this->CommonModel->getData('tbl_master_unit', array('unit_name like' => trim($value)), 'id ', '', 'row_array');
                            //             if (isset($checkExist1['id'])) {
                            //                 $item_unit_id[] = $checkExist1['id'];
                            //             } else {
                            //                 //insert state if not found
                            //                  $item_unit_id[] = $this->CommonModel->iudAction('tbl_master_unit', array('unit_name' => trim($value),'short_name'=>trim($value),'status' => 1,'created_by'=> 1), 'insert');
                            //             } 
                            //     }
                               
                            // } else {
                            //     $item_unit_id =array();
                            // }    
                            $item_unit_id =$row['UNIT STOCK'];
                            
                            // echo $item_type_id."-".$item_group."-".$item_unit_id."-".$row['Item Name']."<br>";
                            if(isset($item_type_id) && ! is_null($item_type_id) && isset($item_group) && ! is_null($item_group) && isset($item_unit_id) && ! empty($item_unit_id) && isset($row['Item Name']) && !empty($row['Item Name'])){
                                $unit_ids=$row['UNIT STOCK'];
                                $stock_unit=explode("&",$unit_ids);
                                        
                                $checkItemExist1 = $this->CommonModel->getData('tbl_items', array('item_name like' => trim($row['Item Name']),'item_group'=>$item_group), 'id', '', 'row_array');
                                                $item_code=str_pad($row['ID'], 4, '0', STR_PAD_LEFT);
                                                $insert_data=array(
                                                    'item_code'=>$item_code,
                                                    'item_name'=>isset($row['Item Name'])?trim($row['Item Name']):NULL,
                                                    'short_name'=>isset($row['Item Name'])?trim($row['Item Name']):NULL,
                                                    'hsn_code'=>NULL,
                                                    'item_group'=>$item_group,
                                                    'stock_unit'=>$stock_unit[0],
                                                    'rate'=>isset($row['RATE'])?trim($row['RATE']):NULL,
                                                    'created_by'=>1,
                                                );
                                if (isset($checkItemExist1['id'])) {
                                   $not_insert_array[]=$row;
                                } else {
                                    //insert state if not found
                                        $item_id= $this->CommonModel->iudAction('tbl_items', $insert_data, 'insert');
                                        $unit_ids=$row['unit_ids'];
                                        $item_units=explode("&",$unit_ids);
                         
                                        foreach($item_units as $key=>$value){
                                            $this->CommonModel->iudAction('tbl_items_units', array('item_id'=>$item_id,'unit_id'=>trim($value),'created_by'=>1), 'insert');
                                        }
                                }
                                
                               
                            }else{
                                $not_insert_array[]=$row;
                                print_r($row);
                            }
                
                               

                        }
                    }
                } else {
                    $response['total_num_row'] = count($csvData);
                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                }
           
           // $response['total_num_row'] = count($csvData);
            die;
            // echo "<pre>";
            // print_r($not_insert_array);die;
         
        } else {
            $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
        }
    }
}