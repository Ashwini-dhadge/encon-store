<?php

/*
 Check Login
*/

  function isLogin()
  {
	$CI = & get_instance();
	$user_id = $CI->session->userdata('user_id');
    $project_name = $CI->session->userdata('project_name');
    $api_token = $CI->session->userdata('api_token');
    

  	if($user_id && $project_name=='ENCON'){
  	      $user_data = $CI->CommonModel->getData('users', array('id' => $user_id),'api_token','','row_array');
  	     // if($user_data['api_token']==$api_token ){
  	     //     return $user_id;
  	     // }else{
  	     //     // $CI->session->sess_destroy();
        //   	////   $data['display_message']=$CI->session->set_flashdata('error','Login Anthoer Device');
        //   	 //  $CI->load->view(ADMIN.AUTH.'login',$data);
  	     //  //   $CI->session->set_flashdata('error','Login Anthoer Device');
  	     //    // $CI->session->sess_destroy();
  	          
  	       
  	     // }
  	      return $user_id;
  	         redirect(base_url().'admin_other/1');
  		
  	}else{
  //	print_r($_SESSION);
   // die("dfs");
    redirect(base_url().'admin');
  	
  	}
  }
  
 
  
  function checkLogin()
  {
	$CI = & get_instance();
	$user_id = $CI->session->userdata('user_id');
    $project_name = $CI->session->userdata('project_name');
  	if($user_id && $project_name=='EFS'){
  		return $user_id;
  	}else{
        return 0;
  	//	redirect(base_url().'admin');
  	}
  }

   /*
 Get User ID
*/
  function userId($key='')
  {
    $CI = & get_instance();
    $_key = ($key)? $key : 'user_id';
    return $CI->session->userdata($_key);
  }

 function getRoleAccess()
  {
    $CI = & get_instance();
   $access=array();
  //  $access = $CI->CommonModel->getData('tbl_roles_access', array('role_id' => $CI->session->userdata('role')),'','','row_array');
   // $access = explode(', ', $access['access']);
    return $access;
  }

  function getUserAccess($module_name)
  {
    $CI = & get_instance();
    $access=$module=array();

    $module = $CI->CommonModel->getData('tbl_module', array('name like' => $module_name),'id','','row_array');
    if(isset($module)){
    $access = $CI->CommonModel->getData('tbl_user_access', array('user_id' => userId() ,'module_id'=>$module['id']),'','','row_array');
        return $access;
    }else{
        return $access;
    }
   // echo $CI->db->last_query();
   //  echo $module_name.' '.userId(); die;
    
    
  }
    
  function getMyUserIds($branch_ids)
  {
    $CI = & get_instance();
    $access=$ids=array();

    $ids = $CI->CommonModel->getData('users', array('parent_staffid' => $branch_ids),'id','','');
    if(!empty($ids)){
       $id=array_column($ids, 'id');
        return $id;
    }else{
        return $ids;
    }
   // echo $CI->db->last_query();
   //  echo $module_name.' '.userId(); die;
    
    
  }

  function getUserAccessForModule($module_name,$key='is_menu')
  {
    $CI = & get_instance();
    if(userId('role_id')!= SUPERADMIN_ROLE){
        $access = array();
        $access=getUserAccess($module_name);

        // print_r($access);echo $key;die;
        if (isset($access)&&!empty($access)){
       
            if($key=='is_menu'){
                    if($access['create']==1 || $access['edit']==1 || $access['delete']==1 || $access['view']==1 ){
                        return 1;
                    }else{
                        return 0;
                    }
                }else{
                    if($access[$key]==1){
                         return 1;
                    }else{
                        return 0;
                    }
                }
            }else{
                return 0;
            }
    }else{
        return 1;
    }
    
  }

  function nextId($table)
  {
    $CI = & get_instance();
    $id = $CI->db->select('id')
               ->limit(1)
               ->order_by('id','DESC')
               ->get($table)
               ->row();

    return ($id)? str_pad(intval($id->id)+ 1, 6,0,STR_PAD_LEFT)  : '000001';
  }
   function nextBatchPoId($table)
  {
    $CI = & get_instance();
    $id = $CI->db->select('id')
               ->limit(1)
               ->order_by('id','DESC')
               ->get($table)
               ->row_array();

    return ($id)?$id['id'] : '1';
  }
  function _date($date='')
  {
    $_date = ($date)?  $date : date('Y-m-d');
    return date('d M Y', strtotime($_date));
  }
  /*
    Get Date In SQL Date Format
    @date
  */

  function sqlDate($date)
  {
    return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
  }

  function dmyDate($date)
  {
    return date('d/m/Y', strtotime($date));
  }
  
  function dmyDateTime($date)
  {
    return date('d/m/Y h:i a', strtotime($date));
  }
  
  function dateFormatDate($date)
  {
    return date('d F Y', strtotime($date));
  }
/*
File Upload Function
*/

function fileUpload($path, $file_name, $multiple=false)
{
	$CI = & get_instance();
	if ($path  && $file_name) {
		$config['upload_path'] = './'.$path;
	    $config['allowed_types'] = '*';
	    $config['overwrite'] = FALSE;
	    $config['encrypt_name'] = FALSE;
	    $config['remove_spaces'] = TRUE;

	    $CI->load->library('upload', $config);
	    $CI->upload->initialize($config);

	    if ($multiple == false){
	        if ( ! $CI->upload->do_upload($file_name)) {
	        	$return['status'] = false;
	        	$return['message'] = $CI->upload->display_errors();
	        }else{
	        	$uploadData = $CI->upload->data();
	        	$return['status'] = true;
	        	$return['message'] = 'Image uploaded!';
	        	$return['image_name'] = $uploadData['file_name'];
	        }
	    }else{
	        $files = $_FILES;

		    $cpt = count($files);
		    for($i=0; $i<$cpt; $i++)
		    {        
    	  		$tem_path = $files[$file_name]['name'][$i];
    	  		$new_name = time().".".pathinfo($tem_path, PATHINFO_EXTENSION);
	    	  	$_FILES[$file_name]['name']= $new_name;
		        $_FILES[$file_name]['type']= $files[$file_name]['type'][$i];
		        $_FILES[$file_name]['tmp_name']= $files[$file_name]['tmp_name'][$i];
		        $_FILES[$file_name]['error']= $files[$file_name]['error'][$i];
		        $_FILES[$file_name]['size']= $files[$file_name]['size'][$i];    
		        if(!$CI->upload->do_upload($file_name))
		        {
					$return['status'] = false;
        			$return['message'] = $CI->upload->display_errors();
				}else{
					$uploadData = $CI->upload->data();
        			$return['status'] = true;
        			$return['message'] = 'Image uploaded!';
        			$return['image_name'][] = $uploadData['file_name'];
				}
			}
		}
	}else{
		$return ['status'] = false;
		$return ['status'] = 'Invaild Parameters!';
	}
	return $return;
}

function prepare_dt_filter($filter)
{
    $filter = implode(' ', $filter);
    if (_startsWith($filter, 'AND')) {
        $filter = substr($filter, 3);
    } else if (_startsWith($filter, 'OR')) {
        $filter = substr($filter, 2);
    }
    return $filter;
}

if (!function_exists('_startsWith')) {
    function _startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
}

function query()
{
   $CI = & get_instance();
   print_r($CI->db->last_query());die();
}

function getValue($key)
  {
    $CI = & get_instance();
    $result = $CI->db->select('value')
                    ->where('key',$key)
                    ->get('tbl_configs')
                    ->row();

    return $result->value;
}

function getValueCustomerSetting($key,$cust_id='')
  {
    $CI = & get_instance();
    
    if($cust_id){
       $result = $CI->db->select('value')
                    ->where('key',$key)
                     ->where('cust_id',$cust_id)
                    ->get('tbl_customer_setting')
                    ->row();
        if(empty($result)){
           $result = $CI->db->select('value')
                    ->where('key',$key)
                    ->get('tbl_configs')
                    ->row();
            
        }
        return $result->value;
        
    }else{
       $result = $CI->db->select('value')
                    ->where('key',$key)
                    ->get('tbl_configs')
                    ->row();
        return $result->value;
    }
    
}

function export($header_array,$data_array,$file_name)
 {
        $CI = & get_instance();

        $fileName = '-'.time().'.xlsx';  
        $CI ->load->library('excel');

        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);


         $table_columns = $header_array;

         $column = 0;

         foreach ($table_columns as $dd) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1, $dd);
              $column++;
         }

         $row_no = 2 ;
         foreach ($data_array  as $key => $data) {
                foreach ($data as $key1 => $value1) {
                    //echo "key-".$key." = row_no".$row_no."<br>";

                    $object->getActiveSheet()->setCellValueByColumnAndRow($key1 ,$row_no,$value1 );
                    //$object->getActiveSheet()->getStyleByColumnAndRow($key1, $row_no)->setWidth(30);
                }
                
               
                $row_no++;
         }
         //set each row height
         //change the font size
            $object->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            //set each column width
            $lettter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
             foreach ($header_array  as $key => $data) {
                  $object->getActiveSheet()->getColumnDimension($lettter[$key])->setAutoSize(true);
             }
            
          
    //   ob_end_clean(); 
  
       $objWriter = new PHPExcel_Writer_Excel2007($object);
     
        // download file
         header("Content-Type: application/vnd.ms-excel");
         $filename=$file_name.time().'.xlsx';
         header('Content-Disposition: attachment;filename='.$filename);
         
          $objWriter->save('php://output');   
       
}
function exportCsv1($header_array,$data_array,$file_name)
{
     // file name 
   $filename =$file_name.date('Y-m-d').'.csv'; 
   header("Content-Description: File Transfer"); 
   header("Content-Disposition: attachment; filename=$filename"); 
   header("Content-Type: application/csv; ");
   


   // file creation 
   $file = fopen('php://output', 'w');
 
   $header = $header_array; 
   fputcsv($file, $header);
   foreach ($data_array as $key=>$line){ 
     fputcsv($file,$line); 
   }
   fclose($file); 
   exit; 
}
function addVendorBiiling($vendor_id,$type,$ref_id,$shipment_id=0){
    //type 	1:request 2:manifest 3:drs 
     $ci =& get_instance();
        $vendor_data = $ci->CommonModel->getData('tbl_vendor_profile', array('vendor_id' => $vendor_id),'billing_type,per_rate','','row_array');
        if($type==VENDOR_BILLING_TYPE_MANIFEST){
            $tbl_name='tbl_manifest_details';
            $where['manifest_id']=$ref_id;
            // 	public function getDataWhereIn($table,$where='',$fields='',$group_by='',$return='', $where_in_key='',$where_arry=array())
           $insert_data_tbl='tbl_mainfest_vendor_billing';
           $insert_data=array('vendor_id'=>$vendor_id,'manifest_id'=>$ref_id,'status'=>0);
           $where_check_data=array('vendor_id'=>$vendor_id,'manifest_id'=>$ref_id);
            $getShipmentIds=$ci->CommonModel->getData($tbl_name, $where,'shipment_id'); 
            $shipmentArray= array_column($getShipmentIds, 'shipment_id');
        }elseif($type==VENDOR_BILLING_TYPE_DRS){
            $tbl_name='tbl_drs_shipments';
            $where['drs_id']=$ref_id;
            $insert_data_tbl='tbl_drs_vendor_billing';
            $insert_data=array('vendor_id'=>$vendor_id,'drs_id'=>$ref_id,'status'=>0,'shipment_id'=>$shipment_id);
            $where_check_data=array('vendor_id'=>$vendor_id,'drs_id'=>$ref_id,'shipment_id'=>$shipment_id);
            $shipmentArray= array($shipment_id);
        }
      
        $getShipmentData=$ci->CommonModel->getDataWhereIn('tbl_shipment','',' sum(chargeable_weight) as total_wt,sum(no_of_package) as no_of_package ,count(id) as no_of_shipment ','','row_array','id',$shipmentArray);
        
      //  echo $ci->db->last_query();die;
        $amount=0;
        if($vendor_data['billing_type']==VENDOR_BILLING_TYPE_PER_PACKET){
              $amount=$getShipmentData['no_of_package']*$vendor_data['per_rate'];
        }elseif($vendor_data['billing_type']==VENDOR_BILLING_TYPE_PER_SHIPMENT){
              $amount=$getShipmentData['no_of_shipment']*$vendor_data['per_rate'];
        }elseif($vendor_data['billing_type']==VENDOR_BILLING_TYPE_PER_KG){
              $amount=$getShipmentData['total_wt']*$vendor_data['per_rate'];
        }
        $insert_data['amount']=$amount;
        $insert_data['total_wt']=$getShipmentData['total_wt'];
        $insert_data['no_of_package']=$getShipmentData['no_of_package'];
        $insert_data['no_of_shipment']=$getShipmentData['no_of_shipment'];
        $insert_data['rate']=$vendor_data['per_rate'];
        $insert_data['pending_amount']=$amount;
        
        $check_data = $ci->CommonModel->getData($insert_data_tbl , $where_check_data,'','','num_rows');
        if(isset($check_data) && $check_data!=0){
             $ci->CommonModel->iudAction($insert_data_tbl, $insert_data, 'update',$where_check_data);
        }else{
             $ci->CommonModel->iudAction($insert_data_tbl, $insert_data, 'insert');
        }
       //$ci->db->last_query();die;
}
function updateVendorBiilingStatus($type,$ref_id,$status=1,$shipment_id=0){
    // 	0:pending 1:created 1:pay
       $ci =& get_instance();
        if($type==VENDOR_BILLING_TYPE_MANIFEST){
            $tbl_name='tbl_manifest_details';
            $where['manifest_id']=$ref_id;
            // 	public function getDataWhereIn($table,$where='',$fields='',$group_by='',$return='', $where_in_key='',$where_arry=array())
           $insert_data_tbl='tbl_mainfest_vendor_billing';
           $updata_data=array('status'=>$status,'updated_by'=>userId(),'updated_at'=>date('Y-m-d H:i:s'));
           $updata_where_data=array('manifest_id'=>$ref_id,'status'=>0);
  
 
        }elseif($type==VENDOR_BILLING_TYPE_DRS){
            $tbl_name='tbl_drs_shipments';
            $where['drs_id']=$ref_id;
            $insert_data_tbl='tbl_drs_vendor_billing';
            $updata_data=array('status'=>$status,'updated_by'=>userId(),'updated_at'=>date('Y-m-d H:i:s'));
            $updata_where_data=array('drs_id'=>$ref_id);
        }
        $ci->CommonModel->iudAction($insert_data_tbl, $updata_data, 'update',$updata_where_data);
      //  $this->CommonModel->getData($tbl_name,array('manifest_id'=>$id),'','','num_rows');
}

function updateShipmentStatus($shipment_id,$internal_status_id,$status_id,$current_branch_id='',$previous_branch_id='',$shipment_payment_status='',$activity_details='',$ref_id='',$type='' ){
            // //ref_type:  	1:shipment id 2:bagging 3:manifest 4:drs 	
          
                $ci =& get_instance();
                $insert_data=array(
                                    'shipment_id'=>$shipment_id,
                                    'internal_status_id'=>$internal_status_id,
                                    'status_id'=>$status_id,
                                    'current_branch_id'=>$current_branch_id,
                                    'previous_branch_id'=>$previous_branch_id,
                                    'activity_details'=>$activity_details,
                                    'ref_id'=>$ref_id,
                                    'type'=>$type
                            );
                if(isset($current_branch_id) && $current_branch_id!=''){
                    $insert_data['current_branch_id']=$current_branch_id;
                }else{
                    if( userId('role_id')==HUB_ROLE || userId('role_id')==FRANCHISE_ROLE || userId('role_id')==BRANCH_ROLE || userId('role_id')==SUPERADMIN_ROLE){
                        $parent_staffid=userId('user_id');
                        $insert_data['current_branch_id']=$parent_staffid;
                    }elseif(userId('role_id') == ADMIN_ROLE || userId('role_id') == SALES_EMPLOYEE || userId('role_id') == ACCOUNT_EMPLOYEE || userId('role_id') == CUSTOMER_SUPPORT || userId('role_id') == OPERATIONAL_EMPLOYEE || userId('role_id') == DELIVERY_BOY){
                        $parent_staffid=userId('parent_staffid'); 
                        $insert_data['current_branch_id']=$parent_staffid;   
                    }
                    
                }
                
                if(isset($previous_branch_id) && $previous_branch_id!=''){
                    $insert_data['previous_branch_id']=$previous_branch_id;
                }
                
                if(isset($shipment_payment_status) && $shipment_payment_status!=''){
                    $insert_data['shipment_payment_status']=$shipment_payment_status;
                }
                
                $ci->CommonModel->iudAction('tbl_shipment', array('internal_status'=>$internal_status_id,'status'=>$status_id,'updated_by'=>userId(),'update_at'=>date('Y-m-d H:i:s')), 'update',array('id'=>$shipment_id));
                
                $ci->CommonModel->iudAction('tbl_shipment_status', $insert_data, 'insert');
}
function updateInLoginFile($data){
    $data1=array();
    //$data=array(user_id,role_id,branch_id,type(login/logout),system_inforamtion,brwoserinforamtion,datetime);
     $ci =& get_instance();
     $ci->load->helper('file');
     
     // Set the file path and name
    $filePathName = LOG_PROFILE.'';
    $date_current=date("Y-m-d");
    $filePath=$filePathName.LOG_FILE_PREFIX.$date_current.".csv";

    // Define the data to write to the CSV file
    // Check if the file exists
 
    if(!file_exists($filePath)) {
        // Create the file if it doesn't exist
        touch($filePath);
        chmod($filePath,0777);
         $data_new=array('user_id','role_id','branch_id','login/logout','system_inforamtion','brwoser_inforation','created_at');
         $data1=array($data_new,$data);
    }else{
       $data1=array($data);
    }

    if(!empty($data1)){
      
           $handle = fopen($filePath, 'a+');
            if ($handle !== FALSE) {
               
                foreach($data1 as $key=>$value){
                     fputcsv($handle, $value);
                }
                   
              
                fclose($handle);
                return TRUE;
            } else {
                return FALSE;
            }
    }
}  
function updateInActionLogFile($data){
    //action:  add/update
    //ref_type: 1: purchase order MOdule 2:master 3:use mangement 4: vendor 5:store
    //sub_ref_type:1 tbl_user
    //sub_ref:
    //sub _ref:
   
    
    //$data=array(user_id,role_id,financial,company_id,site_id,action,descrbtion,ref_type,ref_id,'sub_ref_type',sub_ref_id,datetime);

    $data1=array();
 
     $ci =& get_instance();
     $ci->load->helper('file');
     
     // Set the file path and name
    $filePathName = ACTION_LOG_PROFILE.'';
    $date_current=date("Y-m-d");
    $filePath=$filePathName.ACTION_LOG_FILE_PREFIX.$date_current.".csv";

    // Define the data to write to the CSV file
    // Check if the file exists
 
    if(!file_exists($filePath)) {
        // Create the file if it doesn't exist
        touch($filePath);
        chmod($filePath,0777);
        $data_new=array('user_id','role_id','financial_year','company_id','site_id','action','description','ref_type','ref_id','sub_ref_type','sub_ref_id','created_at','json_data');
        $data1=array($data_new,$data);
    }else{
       $data1=array($data);
    }

    if(!empty($data1)){
      
           $handle = fopen($filePath, 'a+');
            if ($handle !== FALSE) {
               
                foreach($data1 as $key=>$value){
                     fputcsv($handle, $value);
                }
                   
              
                fclose($handle);
                return TRUE;
            } else {
                return FALSE;
            }
    }
}    
function encode_arr($data) {
    return base64_encode(serialize($data));
}

function decode_arr($data) {
    return unserialize(base64_decode($data));
}

function decimalToInterger($decimalNumber){
    
    $decimalNumber1 = $decimalNumber - (int)$decimalNumber;
     if ($decimalNumber1 == 0 || $decimalNumber1 == 0.00) {
            $number=(int)$decimalNumber;
     } else {
            $number=$decimalNumber;
     }
     
     return $number;
}
function decimalFormatNumber($decimalNumber){
    return sprintf('%0.2f', $decimalNumber); 
}
function updateQuickInventory($item_id = '',$item_unit_id = '',$quantity='',$company_id = '',$site_id='',$financial_year_id='' ,$action=1,$type='',$ref_id = '',$user_id='',$batch_no='',$expired_date='',$is_reserve_stock=0,$sub_ref_id=0,$item_rate_type=1,$item_weight=0,$item_unit_rate=0){
    $CI = & get_instance();
 
    $rate_details=array();
    if(isset($sub_ref_id) && $sub_ref_id!=0){
        $sub_ref_id=$sub_ref_id;
    }else{
        $sub_ref_id=NULL;
    }
    
     if(isset($item_weight) && $item_weight!=0){
        $rate_details['weight']=$item_weight;
     }else{
        $rate_details['weight']=NULL;
     }
     if(isset($item_unit_rate)&& $item_unit_rate!=0){
            $rate_details['rate']=$item_unit_rate;
            $rate_details['rate_type']=$item_rate_type;
     }else{
         $rate_details=getRate($item_id,$item_unit_id,$quantity,$company_id,$site_id,$financial_year_id,$type,$ref_id,$batch_no,$expired_date);
          if(empty($rate_details)){
                $rate_details['rate']=NULL;
                $rate_details['weight']=NULL;
                $rate_details['rate_type']=1;
            }
     }
   
   

 
    $inst=array(
                    'item_id'=>$item_id,
                    'item_unit_id'=>$item_unit_id,
                    'user_id'=>$user_id,
                    'type'=>$type,
                    'ref_id'=>$ref_id,
                    'action'=>$action,
                    'qty'=>$quantity,
                    'company_id'=>$company_id,
                    'site_id'=>$site_id,
                    'financial_year_id'=>$financial_year_id,
                    'batch_no'=>$batch_no,
                    'expired_date'=>$expired_date,
                    'is_reserve_stock'=>$is_reserve_stock,
                    'rate'=>$rate_details['rate'],
                    'weight'=>$rate_details['weight'],
                    'rate_type'=>$rate_details['rate_type'],
                    'sub_ref_id'=>$sub_ref_id
        );



    
    $CI->CommonModel->iudAction('tbl_items_inventory_details', $inst, 'insert');
     
    updateItemInventory($item_id,$item_unit_id,$quantity,$action,$company_id,$site_id,$financial_year_id,$batch_no,$expired_date,$is_reserve_stock);
}


function getQuickInventoryAmount($item_id,$item_unit_id,$company_id = '',$site_id='',$financial_year_id='',$batch_no='',$expired_date='',$is_reserve_stock=''){
    $CI = & get_instance();
    $where=array('item_id'=>$item_id,'item_unit_id'=>$item_unit_id,'qty !='=>0.00);
    if($is_reserve_stock!=''){
        $where['is_reserve_stock']=$is_reserve_stock;
    }else{
         $where['is_reserve_stock']=0;
    }
    
    if($batch_no!=''){
        $where['batch_no']=$batch_no;
    }
    if($expired_date!=''){
        $where['expired_date']=$expired_date;
    }
    

    if(!empty($company_id)){
        $where['company_id']=$company_id;
    }
    if(!empty($site_id)){
        $where['site_id']=$site_id;
    }
    if(!empty($financial_year_id)){
        $where['financial_year_id']=$financial_year_id;
    }
  
    $totalQty=array();
    $totalQty = $CI->CommonModel->getData('tbl_items_inventory', $where,'qty','','row_array','id','desc');
    
    if(isset($totalQty['qty']) && !empty($totalQty['qty'])){
      $qty = $totalQty['qty']; 
    }else{
      $qty =0;      
     }
    return $qty;
}

function updateItemInventory($item_id,$item_unit_id,$quantity,$action,$company_id = '',$site_id='',$financial_year_id='',$batch_no='',$expired_date='',$is_reserve_stock=''){
        $CI = & get_instance();
        $getItemQty=getQuickInventoryAmount($item_id,$item_unit_id,$company_id,$site_id,$financial_year_id,$batch_no,$expired_date,$is_reserve_stock);
        
       // print_r($getItemQty);
        if(! isset($getItemQty)){
            $getItemQty=0;
        }
        
        if($action==1){
             $Balance=$getItemQty+$quantity;
            
        }elseif($action==2){//dispatch
             $Balance=$getItemQty-$quantity;
           
        }

      $dataQty=array();
      $dataQty = $CI->CommonModel->getData('tbl_items_inventory', array('item_id' => $item_id,'item_unit_id'=>$item_unit_id,'company_id'=>$company_id,'site_id'=>$site_id,'financial_year_id'=>$financial_year_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date,'is_reserve_stock'=>$is_reserve_stock),'id','','row_array');
      
      if(!isset($dataQty['id']) && empty($dataQty)){
        $inst=array(
                    'item_id'=>$item_id,
                    'item_unit_id'=>$item_unit_id,                    
                    'qty'=>$Balance,
                    'company_id'=>$company_id,
                    'site_id'=>$site_id,
                    'batch_no'=>$batch_no,
                    'expired_date'=>$expired_date,
                    'financial_year_id'=>$financial_year_id,
                    'is_reserve_stock'=>$is_reserve_stock
                   
        );
         $CI->CommonModel->iudAction('tbl_items_inventory', $inst, 'insert');
      }else{
         $CI->CommonModel->iudAction('tbl_items_inventory', array( 'qty'=>$Balance), 'update',array('id'=>$dataQty['id']));
      }

    
}

function getRate($item_id,$item_unit_id,$quantity,$company_id,$site_id,$financial_year_id,$type,$ref_id,$batch_no,$expired_date){
    $CI = & get_instance();
    $CI->load->model(ADMIN . 'CommonCustModel');
    // print_r($type);die;
    if($type==GRN_TYPE || $type==OPENING_STOCK_TYPE || $type==LAST_YEAR_OPENING_STOCK_TYPE){
        if($type==GRN_TYPE){ 
             $getRate = $CI->CommonModel->getData('tbl_grn_items_details', array('grn_id'=>$ref_id,'item_id' => $item_id,'item_unit_id'=>$item_unit_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date),'item_rate,item_weight,item_rate_type','','row_array');
           
            if(!empty($getRate)){
                 $rate=$getRate['item_rate'];
                 $weight=$getRate['item_weight'];
                 $item_rate_type=$getRate['item_rate_type'];
            }else{
                 $rate=NULL;
                $weight=NULL;
                $item_rate_type=1;
            }
            
        }else if($type==OPENING_STOCK_TYPE){
             $getRate = $CI->CommonModel->getData('tbl_items_opening_stock_details', array('opening_id'=>$ref_id,'item_id' => $item_id,'opening_unit_id'=>$item_unit_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date),'unit_rate,opening_weight,item_rate_type','','row_array');
             $rate=$getRate['unit_rate'];
             $weight=$getRate['opening_weight'];
             $item_rate_type=$getRate['item_rate_type'];
 
        }else if($type==LAST_YEAR_OPENING_STOCK_TYPE){ 
             $getRate = $CI->CommonModel->getData('tbl_items_financial_year_opening_stock_details', array('financial_year_opening_id'=>$ref_id,'item_id' => $item_id,'item_unit_id'=>$item_unit_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date),'unit_rate,weight,rate_type','','row_array');
             
              if(!empty($getRate)){
                 $rate=$getRate['unit_rate'];
                 $weight=$getRate['weight'];
                 $item_rate_type=$getRate['rate_type'];
            }else{
                 $rate=NULL;
                $weight=NULL;
                $item_rate_type=1;
            }
            
        }else{
            $rate=NULL;
            $weight=NULL;
            $item_rate_type=1;
        }
    }else{
        $where_grn=array('item_id' => $item_id,'item_unit_id'=>$item_unit_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date,'company_id'=>$company_id,'site_id'=>$site_id,'financial_year_id'=>$financial_year_id);
        $where_os=array('item_id' => $item_id,'opening_unit_id'=>$item_unit_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date,'location_id'=>$site_id,'financial_year_id'=>$financial_year_id);
        $getRateGrn=$getRateOS=array();
        $getRateGrn = $CI->CommonCustModel->getRateFromGrn($where_grn);
        $getRateOS = $CI->CommonCustModel->getRateFromOpeningStock($where_os);
       
        if(!empty($getRateGrn)){
            $rate=$getRateGrn['item_rate'];
            if(!empty($getRateGrn['received_qty'])){
                $per_weight=$getRateGrn['item_weight']/$getRateGrn['received_qty'];
                $weight=$per_weight*$quantity;
            }else{
                $weight=$getRateGrn['item_weight'];
            }
            $item_rate_type=$getRateGrn['item_rate_type'];
         }else if(!empty($getRateOS)){
             $rate=$getRateOS['unit_rate'];
            
            if(!empty($getRateGrn['opening_qty'])){
                $per_weight=$getRateOS['opening_weight']/$getRateOS['opening_qty'];
                $weight=$per_weight*$quantity;
            }else{
                $weight=$getRateOS['opening_weight'];
            }
            
             $item_rate_type=$getRateOS['item_rate_type'];
         }else{
            $rate=NULL;
            $weight=NULL;
            $item_rate_type=1;
         }
    }
    $response['rate']=$rate;
    $response['weight']=$weight;
    $response['rate_type']=$item_rate_type;
    return $response;

}
 
function moneyFormatIndia($num) {
    return preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
    
}

function updateQtyRateInventory($ref_id = '',$sub_ref_id = '',$type='',$quantity='',$item_rate_type = '',$item_unit_rate=0,$item_weight=0,$item_id='',$item_unit_id='',$company_id='',$site_id='',$financial_year_id='',$batch_no='',$expired_date='',$update_qty='',$is_add='',$is_minus=''){
  

    $CI = & get_instance();
    
    if(isset($item_weight) && $item_weight!=0){
        $item_weight1=$item_weight;
     }else{
        $item_weight1=NULL;
     }
    $inst=array(
                    
                    'qty'=>$quantity,
                    'rate'=>$item_unit_rate,
                    'weight'=>$item_weight1,
                    'rate_type'=>$item_rate_type,
                    'updated_by'=>userId(),
                    'updated_at'=>Date('Y-m-d H:i:s')
        );
    $dataInventorycheck = $CI->CommonModel->getData('tbl_items_inventory_details', array('ref_id'=>$ref_id,'sub_ref_id'=>$sub_ref_id,'type'=>$type),'id','','row_array');
    if(isset($dataInventorycheck['id'])&& !empty($dataInventorycheck['id'])){
         $CI->CommonModel->iudAction('tbl_items_inventory_details', $inst, 'update',array('ref_id'=>$ref_id,'sub_ref_id'=>$sub_ref_id,'type'=>$type));
    }else{
         $dataInventorycheckWithItem = $CI->CommonModel->getData('tbl_items_inventory_details', array('ref_id'=>$ref_id,'type'=>$type,'item_id' => $item_id,'item_unit_id'=>$item_unit_id,'company_id'=>$company_id,'site_id'=>$site_id,'financial_year_id'=>$financial_year_id,'batch_no'=>$batch_no,'expired_date'=>$expired_date),'id','','row_array');
        if(isset($dataInventorycheckWithItem['id'])&& !empty($dataInventorycheckWithItem['id'])){
            $inst['sub_ref_id']=$sub_ref_id;
            $CI->CommonModel->iudAction('tbl_items_inventory_details', $inst, 'update',array('id'=>$dataInventorycheckWithItem['id']));
        }
        
    }
    if($update_qty!=0){
        if($is_add==1){
         updateItemInventory($item_id,$item_unit_id,$update_qty,1,$company_id,$site_id,$financial_year_id,$batch_no,$expired_date,0);
        }
        if($is_minus==1){
             updateItemInventory($item_id,$item_unit_id,$update_qty,2,$company_id,$site_id,$financial_year_id,$batch_no,$expired_date,0);
        }
    }
    
      
    
}
if (!function_exists('generate_material_issue_number')) {
    function generate_material_issue_number()
    {
        $CI =& get_instance();
        $CI->load->database();
        
        
        $financial_year_id = userId('financial_year_id');
        $company_id = userId('company_id');
        $site_id = userId('site_id');
        $firstTwoLetters = strtoupper(substr(userId('name'), 0, 2));

        $CI->db->select('issue_order_sequence');
        $CI->db->from('tbl_material_issue i');
        $CI->db->where('i.financial_year_id', $financial_year_id);
        $CI->db->where('i.company_id', $company_id);
        $CI->db->where('i.site_id', $site_id);
        $CI->db->order_by('i.id', 'desc');
        $result = $CI->db->get()->row_array();

      
        //echo $this->db->last_query();
        if (isset($result['issue_order_sequence'])) {
            $sequence_number = $result['issue_order_sequence'] + 1;
            
            
        } else {
            $sequence_number = 1;
        }

       
        $currentYear = date("Y");
        $nextYear = $currentYear + 1;
            
        // If before April, use previous financial year
        if (date("m") < 4) {
            $currentYear -= 1;
            $nextYear -= 1;
        }
        $prefix_year=substr($currentYear, 2) . "-" . substr($nextYear, 2);
        
        $new_number = "ISSUE-".userId('site_inital') . "/".$prefix_year. '/' .$sequence_number;
        $number=array();
        $number['order_sequence']=$sequence_number;
        $number['new_number']=$new_number;
        return $number;

     }
}
?>