<?php 

	class OpportunityTracker extends CI_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model(ADMIN.'sales/OpportunityTrackerModel');
			isLogin();
		}


		public function index()
	    {
	     $data['title'] = 'Opportunity Tracker';
	     $data['active'] = 'Opportunity Tracker';

	     $data['inprocess_status_cnt'] = $this->CommonModel->getData('tbl_opportunity_tracker',array('status'=>OPPORTUNITY_STATUS_INPROCESS,'type'=>0),'','','num_rows');
	     $data['complete_status_cnt'] = $this->CommonModel->getData('tbl_opportunity_tracker',array('status'=>OPPORTUNITY_STATUS_COMPLETE,'type'=>0),'','','num_rows');
	  
	     $this->load->view(ADMIN.'sales/opportunity_tracker/list_opportunity_tracker',$data);
	    }

	    public function list_opportunity_tracker()
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

	        $where['ot.type'] = 0;
	        if($data['status_id'] == OPPORTUNITY_STATUS_COMPLETE || $data['status_id'] == OPPORTUNITY_STATUS_INPROCESS){
	            $where['ot.status'] = $data['status_id'];
	        }
	        
	        if($data['plant_id'] !== "all"){
	            $where['ot.plant_id'] = $data['plant_id'];
	        }else {
	        	// $where = array();
	        	$where['ot.type'] = 0;
	        }
	        
	        if($data['customerid'] !== "all"){
	            $where['ot.customer_id'] = $data['customerid'];
	        }else {
	        	// $where = array();
	        	$where['ot.type'] = 0;
	        }

	        

	        $count = count($this->OpportunityTrackerModel->getOpportunityTrackerData($searchVal,0,0,0,0,0,$where));

	        if($count){
	            $result = $this->OpportunityTrackerModel->getOpportunityTrackerData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
	    
	                foreach ($result as $key => $value) {
	            
	                    $row = []; 
	                    array_push($row, $offset + ($key + 1));
	                    array_push($row, $value['title']);
	                    array_push($row, $value['plant_narration']);
	                    array_push($row, $value['customer_name']);
	                    array_push($row, $value['contact_person_name']);
	                    array_push($row, $value['contact_person_mobile_no']);
	                    
	                    if($value['status']==OPPORTUNITY_STATUS_INPROCESS) {
		                    $status = '<p class="badge badge-warning">In-Process</p>';
		                 }else if($value['status']==OPPORTUNITY_STATUS_COMPLETE){
		                    $status = '<p class="badge badge-success">Complete</p>';
		                }
		                else{
		                    $status = '<span> - </span>';
		                }
	                    
	                    array_push($row, $status);

	                    $newDate = date("d F Y", strtotime($value['date']));
                        array_push($row, $newDate);
	                    
	                 


	                    $confirm = "confirm('Are you sure you want to delete this Opportunity Tracker data?')";
	                      
	                     $action='  
	                     	<a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm opp_tracker_modal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="opp_tracker_modal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>

	                     	<a href="'.base_url().'admin/sales/OpportunityTracker/viewOpportunityTracker/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

	                     	<a href="'.base_url().'admin/sales/OpportunityTracker/send_quotation/'.$value['id'] .'" title="Send Quotation" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-file-alt" aria-hidden="true"></i></a>
	                      ';
						 // <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/OpportunityTracker/delete/' . $value['vendor_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>	                                            
	                     array_push($row, $action);
	                     $columns[] = $row;
	               }
	        }
	        $response = [
	            'draw' => $page,
	            'data' => $columns,
	            'recordsTotal' => $count,
	            'total_count' => $count,
	            'recordsFiltered' => $count
	        ];
	        // print_r($response['total_count']);die;
	        echo json_encode($response);
	    }


	    public function viewOpportunityTracker($id='',$redirect_type='')
	    {

	    // echo "<pre>"; print_r($id); echo "<pre>"; print_r($redirect_type);die;
	    	$data['redirect_type'] = $redirect_type;
	    	$opportunity_data = $this->OpportunityTrackerModel->viewOpportunityTrackerInfo($id);
	        $data['opportunity_data'] = $opportunity_data[0];
	        $customer_data = $this->OpportunityTrackerModel->getCustomerData($data['opportunity_data']['customer_id']);
	        if($customer_data)
	            $data['customer_data'] =  $customer_data[0];
	        else
	            $data['customer_data'] =  array();
	        
	        $data['sub_opportunity_data'] = $this->OpportunityTrackerModel->getdateInfoData($id);
	        $data['opp_main_attachment_file'] = $this->CommonModel->getData('tbl_opportunity_tracker_attachement',array('opportunity_tracker_id'=>$id));
	        $data['reminder_dt'] = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$data['opportunity_data']['id']));
	        $data['plant_dt'] = $this->CommonModel->getData('tbl_plant',array('id'=>$data['opportunity_data']['plant_id']));

	        foreach($data['sub_opportunity_data'] as $key=> $value){
	        	$value['date_wise_data']  = $this->OpportunityTrackerModel->dateWiseOpportunityTrackerInfo($id,$value['date']);
	        		
	        		foreach($value['date_wise_data'] as $key3=> $value3){

		        		$value3 = $this->CommonModel->getData('tbl_opportunity_tracker_attachement',array('opportunity_tracker_id'=>$value3['id']));

		        		$value['date_wise_data'][$key3]['opp_sub_attachment_file'] = $value3;
		        	}
				
				$data['opportunity_data']['dates'][$key]= $value;
		    }

//   echo "<pre>"; print_r($data);die;	

	        $this->load->view(ADMIN.'sales/opportunity_tracker/view_opportunity_tracker_info',$data);

	    }

	    



		public function opp_tracker_modal()		
		{
			
		    $id = $this->input->post('id');
		    $data['type'] = $this->input->post('type');

		    $data['sub_title'] = 'Add Opportunity Tracker';

// echo "<pre>"; print_r($post);print_r( $data['type']);die;
		    if($id && empty($data['type']) || ($id && $data['type'] == OPPORTUNITY_TYPE_TWO) || ($data['type'] == OPPORTUNITY_TYPE_TWO)){
		    	 $where = array();
		    	// $where['ot.type'] = 0;
		    	$data['opportunity_data'] =  'get id and $type is empty';
		    	$opportunity_data = $this->OpportunityTrackerModel->getOpportunityTrackerData('', 0, 0, 0, 0,$id,$where);
	            $data['opportunity_data'] =  $opportunity_data[0];
	      		$data['sub_title'] = 'Edit Opportunity Tracker Data';  
	      		$data['customer_name'] = $this->CommonModel->getData('tbl_customer',array('id'=>$data['opportunity_data']['customer_id']),'','','');
	      		$data['attachement'] = $this->CommonModel->getData('tbl_opportunity_tracker_attachement',array('opportunity_tracker_id'=>$data['opportunity_data']['id']));

   			    $data['reminder'] = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$data['opportunity_data']['id'],'module_id'=>SALES_OPPORTUNITY),'','','row_array');

   			    $data['plant_name'] = $this->CommonModel->getData('tbl_plant',array('id'=>$data['opportunity_data']['plant_id']));

		    }else if($id && ($data['type'] == OPPORTUNITY_TYPE_THREE)){
		    	$where['ot.type'] = 1;
		    	$opportunity_data = $this->OpportunityTrackerModel->getOpportunityTrackerData('', 0, 0, 0, 0,$id,$where);
	            $data['opportunity_data'] =  $opportunity_data[0];
	      		$data['sub_title'] = 'Edit Opportunity Tracker Data';  
	      		$data['customer_name'] = $this->CommonModel->getData('tbl_customer',array('id'=>$data['opportunity_data']['customer_id']),'','','');
	      		$data['attachement'] = $this->CommonModel->getData('tbl_opportunity_tracker_attachement',array('opportunity_tracker_id'=>$data['opportunity_data']['id']));

	      		$data['reminder'] = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$data['opportunity_data']['id'],'module_id'=>SALES_OPPORTUNITY),'','','row_array');
	      		$data['plant_name'] = $this->CommonModel->getData('tbl_plant',array('id'=>$data['opportunity_data']['plant_id']));

		    }else if($id && ($data['type'] == OPPORTUNITY_TYPE_ONE)){
		          $data['sub_title'] = 'Add Opportunity Tracker';
		    	  $data['type'] = $this->input->post('type');
		    	  $data['opportunity_data'] = $this->CommonModel->getData('tbl_opportunity_tracker',array('id'=>$id),'id,customer_id,plant_id','','row_array');
				  $data['customer_name'] = $this->CommonModel->getData('tbl_customer',array('id'=>$data['opportunity_data']['customer_id']),'','','');	
				  // $data['reminder'] = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$data['opportunity_data']['id'],'module_id'=>SALES_OPPORTUNITY),'','','row_array');
				  $data['plant_name'] = $this->CommonModel->getData('tbl_plant',array('id'=>$data['opportunity_data']['plant_id']));
		    }

// echo "<pre>"; print_r($data);die;

			$html = $this->load->view(ADMIN.'sales/opportunity_tracker/add_opportunity_modal', $data,true);	
		   

		    if ($html) {
		      $response['html'] = $html;
		      $response['result'] = true;
		      $response['reason'] = 'Data Found';
		    }else{
		      $response['result'] = fasle;
		      $response['reason'] = 'Something went to wrong!';
		    }
		    echo json_encode($response);
		}

		
		public function submmit_opportunity_tracker_data($_id='')
	    {
	        $data['title'] = 'Opportunity Tracker';
		    $data['active'] = 'Opportunity Tracker';
	        $post = $this->input->post();
	        $attachement_file=array();
	        
	        if ($post) {
	        	if(! empty($_FILES['file_name']['name'])){
	                $uploadStatus = myUpload(OPPORTUNITY_TRACKER_IMAGE,'file_name',true);
	                if(isset( $uploadStatus['data']) && !empty( $uploadStatus['data'])){
	                      $attachement_file = $uploadStatus['data'];
	                }
	            }
	            
	            if($post['date']){
	                $post['date']=date('Y-m-d H:i:s',strtotime($post['date']));
	            }

			 //  echo "<pre>";  print_r($post);
			 //	  echo "<pre>";   
            	$insert_opp_tracker = array(
            			'customer_id' => isset($post['customer_id'])?$post['customer_id']:'',
            			'plant_id' => isset($post['plant_name_id'])?$post['plant_name_id']:'',
            			'title' => isset($post['title'])?$post['title']:'',
            			'date' => isset($post['date'])?$post['date']:'',
            			'is_check_reminder'=> isset($post['is_check_reminder'])?$post['is_check_reminder']:NULL,
            			// 'reminder_for_multiple' => isset($post['reminder_for_multiple'])?$post['reminder_for_multiple']:NULL,
            			'contact_person_name' => isset($post['contact_person_name'])?$post['contact_person_name']:'',
            			'contact_person_mobile_no' => isset($post['contact_person_mobile_no'])?$post['contact_person_mobile_no']:'',
            			'email_ids' => isset($post['email_ids'])?$post['email_ids']:'',
            			'description' => isset($post['description'])?$post['description']:'',
            		);
             
            	  $start_date = isset($post['start_date_time'])?$post['start_date_time']:'';            
	              $start_date_timestamp = strtotime($start_date);
	              $date_start = date('Y-m-d H:i:s', $start_date_timestamp); 
	              
				 if(! empty($post['end_date_time'])){
					$end_date = isset($post['end_date_time']) ? $post['end_date_time'] : '';            
		           	$end_date_timestamp = strtotime($end_date);
	              	$date_end = date('Y-m-d H:i:s', $end_date_timestamp); 
	             }
	             
	             $class_name = 'green';


	              if(isset($post['is_check_reminder'])){

	              	$reminder= array(
		                'title_reminder' =>isset($post['title_reminder'])?$post['title_reminder']:'',
                        'start_date_time' => isset($date_start)?$date_start:NULL, 
                        'end_date_time' => isset($date_end)?$date_end:NULL, 
                        'module_id' => SALES_OPPORTUNITY,
                        'class_name' => isset($class_name)?$class_name:'green',
                        'is_display_to_all' => isset($post['is_display_to_all'])?$post['is_display_to_all']:'',
                        // 'reminder_for_multiple' => isset($post['reminder_for_multiple'])?$post['reminder_for_multiple']:'',
                        'user_id' =>userId('user_id'),
                	);	
	              }
                //   print_r($reminder);die;
	            if(empty($post['id'])) {
	        	
		            $insert_opp_tracker['created_by'] = userId();
		            $insert_opp_tracker['created_at'] = date('Y-m-d H:i:s');

		        	$insert_id = $this->CommonModel->iudAction('tbl_opportunity_tracker',$insert_opp_tracker,'insert');
		            
		            if($insert_id){
		            	if($attachement_file){
		                	foreach($attachement_file as $key=>$value)
		                    { 
		                        $attachement_file = array(
		                        	'opportunity_tracker_id'=> $insert_id, 
		                            'file_name' => $value['file_name']
		                        );
		                        $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement',$attachement_file,'insert');
		                    }
		                }

		                if(isset($post['is_check_reminder'])){
				            $reminder['ref_id'] = $insert_id;
				        	$this->CommonModel->iudAction('tbl_reminder',$reminder,'insert');
				        }

		                    $this->session->set_flashdata('success','Opportunity Tracker Data Added Successfully');
		            }else{
		            	$this->session->set_flashdata('error','Opportunity Tracker Data Not Added !');
		            }

		        }else{
					// echo "<pre>"; print_r($post);
					// echo "<pre>"; print_r($attachement_file);die;
					if($post['type'] == OPPORTUNITY_TYPE_ONE){
						$reminder['module_id'] = SALES_OPPORTUNITY;
	                    $reminder['class_name'] = 'green';

		            	$insert_opp_tracker = array(
	            			'customer_id' => isset($post['customer_id'])?$post['customer_id']:'',
	            			'plant_id' => isset($post['plant_name_id'])?$post['plant_name_id']:'',
	            			'title' => isset($post['title'])?$post['title']:'',
	            			'type' => 1,
	            			'opp_tracker_id' => isset($post['id'])?$post['id']:'',
	            			'is_check_reminder'=> isset($post['is_check_reminder'])?$post['is_check_reminder']:'',
	            			// 'reminder_for_multiple' => isset($post['reminder_for_multiple'])?$post['reminder_for_multiple']:'',
	            			'date' => isset($post['date'])?$post['date']:'',
	            			'contact_person_name' => isset($post['contact_person_name'])?$post['contact_person_name']:'',
	            			'contact_person_mobile_no' => isset($post['contact_person_mobile_no'])?$post['contact_person_mobile_no']:'',
	            			'email_ids' => isset($post['email_ids'])?$post['email_ids']:'',
	            			'description' => isset($post['description'])?$post['description']:'',
	            		);
						
					// 	echo "<pre>"; print_r($post);
					// echo "<pre>"; print_r($reminder);die;
		            	$insert_opp_tracker['created_by'] = userId();
		            	$insert_opp_tracker['created_at'] = date('Y-m-d H:i:s');

					  	$inst_id = $this->CommonModel->iudAction('tbl_opportunity_tracker',$insert_opp_tracker,'insert');

					  	if(isset($post['is_check_reminder'])){
			        		
			        		// $chk_reminder_dt = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        		
			        		// if(! empty($chk_reminder_dt)){
			        			// $reminder['ref_id'] = $inst_id;

		              			// $this->CommonModel->iudAction('tbl_reminder',$reminder,'update',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        		// }else{
			        			$reminder['ref_id'] = $inst_id;
		              			$this->CommonModel->iudAction('tbl_reminder',$reminder,'insert');
			        		// }
			        		
			        	}

			        	if(isset($attachement_file) && !empty($attachement_file)){
		                    foreach ($attachement_file as $key => $value) {
		                        $update_attch_data_a = array(
		                	       'opportunity_tracker_id'=> $inst_id, 
		                           'file_name' => $value['file_name'],
		                           'updated_by' => userId(),
		                           'updated_at' => date('Y-m-d'),
		                        );
		                        $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement', $update_attch_data_a, 'insert');
		                    }        
		                }

					}else if($post['type'] == OPPORTUNITY_TYPE_THREE){

		        	 // echo "<pre>";  print_r($post);die;

		        		$reminder['module_id'] = SALES_OPPORTUNITY;
	                    $reminder['class_name'] = 'green';
	                //     echo "<pre>"; print_r($post);
					// echo "<pre>"; print_r($reminder);die;

		            	$insert_opp_tracker = array(
	            			'customer_id' => isset($post['customer_id'])?$post['customer_id']:'',
	            			'plant_id' => isset($post['plant_name_id'])?$post['plant_name_id']:'',
	            			'title' => isset($post['title'])?$post['title']:'',
	            			'opp_tracker_id' => isset($post['id_opp_track'])?$post['id_opp_track']:'',
	            			'type' => 1,
	            			'is_check_reminder'=> isset($post['is_check_reminder'])?$post['is_check_reminder']:'',
	            			// 'reminder_for_multiple' => isset($post['reminder_for_multiple'])?$post['reminder_for_multiple']:NULL,
	            			'date' => isset($post['date'])?$post['date']:'',
	            			'contact_person_name' => isset($post['contact_person_name'])?$post['contact_person_name']:'',
	            			'contact_person_mobile_no' => isset($post['contact_person_mobile_no'])?$post['contact_person_mobile_no']:'',
	            			'email_ids' => isset($post['email_ids'])?$post['email_ids']:'',
	            			'description' => isset($post['description'])?$post['description']:'',
	            		);
						
					   $update_id = $this->CommonModel->iudAction('tbl_opportunity_tracker',$insert_opp_tracker,'update',array('id'=>$post['id']));


					   if(isset($post['is_check_reminder'])){
			        		
			        		$chk_reminder_dt = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        		
			        		if(! empty($chk_reminder_dt)){
			        			$reminder['ref_id'] = $post['id'];
		              			$this->CommonModel->iudAction('tbl_reminder',$reminder,'update',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        		}else{
			        			$reminder['ref_id'] = $post['id'];
		              			$this->CommonModel->iudAction('tbl_reminder',$reminder,'insert');
			        		}
			        		
			        	}else{
			        		$this->CommonModel->iudAction('tbl_reminder','','delete',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        	}

					   // $this->CommonModel->iudAction('tbl_reminder',$reminder,'update',array('id'=>$post['id_reminder'],'ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
		                  

					  if(isset($post['file_name_id']) && !empty($post['file_name_id'])){
		                    foreach ($post['file_name_id'] as $key4 => $val4) {
		                       
		                        $chk = $this->CommonModel->getData('tbl_opportunity_tracker_attachement',array('id'=>$val4),'','','row_array'); 
		    
		                        if($chk){
		                            $update_attch_data = array(
		                                    'opportunity_tracker_id'=> $post['id'], 
		                                 	'file_name' => $chk['file_name'],
		                                    'updated_by' => userId(),
		                                    'updated_at' => date('Y-m-d'),
		                            );
		                            $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement',$update_attch_data,'update',array('id'=>$val4,'opportunity_tracker_id'=>$post['id']));
		                        }else{
		                          $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement','','delete',array('id'=>$val4,'opportunity_tracker_id'=>$post['id']));    
		                        }
			                }
		               	}

		               	if(isset($attachement_file) && !empty($attachement_file)){
		                    foreach ($attachement_file as $key => $value) {
		                        $update_attch_data_a = array(
		                	       'opportunity_tracker_id'=> $post['id'], 
		                           'file_name' => $value['file_name'],
		                           'updated_by' => userId(),
		                           'updated_at' => date('Y-m-d'),
		                        );
		                        $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement', $update_attch_data_a, 'insert');
		                    }        
		                }


					}else{
						$insert_opp_tracker['updated_by'] = userId();
	    		        $insert_opp_tracker['updated_at'] = date('Y-m-d H:i:s');
			        	$this->CommonModel->iudAction('tbl_opportunity_tracker',$insert_opp_tracker,'update',array('id' => $post['id']));
			        	
			        	if(isset($post['is_check_reminder'])){
			        		
			        		$chk_reminder_dt = $this->CommonModel->getData('tbl_reminder',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        		
			        		if(! empty($chk_reminder_dt)){
			        			$reminder['ref_id'] = $post['id'];
		              			$this->CommonModel->iudAction('tbl_reminder',$reminder,'update',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        		}else{
			        			$reminder['ref_id'] = $post['id'];
		              			$this->CommonModel->iudAction('tbl_reminder',$reminder,'insert');
			        		}
			        		
			        	}else{
			        		$this->CommonModel->iudAction('tbl_reminder','','delete',array('ref_id'=>$post['id'],'module_id'=>SALES_OPPORTUNITY));
			        	}
		                
		                if(isset($post['file_name_id']) && !empty($post['file_name_id'])){
		                    foreach ($post['file_name_id'] as $key4 => $val4) {
		                       
		                        $chk = $this->CommonModel->getData('tbl_opportunity_tracker_attachement',array('id'=>$val4),'','','row_array'); 
		    
		                        if($chk){
		                            $update_attch_data = array(
		                                    'opportunity_tracker_id'=> $post['id'], 
		                                 	'file_name' => $chk['file_name'],
		                                    'updated_by' => userId(),
		                                    'updated_at' => date('Y-m-d'),
		                            );
		                            $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement',$update_attch_data,'update',array('id'=>$val4,'opportunity_tracker_id'=>$post['id']));
		                        }else{
		                          $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement','','delete',array('id'=>$val4,'opportunity_tracker_id'=>$post['id']));    
		                        }
			                }
		               	}

		               	 if(isset($attachement_file) && !empty($attachement_file)){
		                    foreach ($attachement_file as $key => $value) {
		                        $update_attch_data_a = array(
		                	       'opportunity_tracker_id'=> $post['id'], 
		                           'file_name' => $value['file_name'],
		                           'updated_by' => userId(),
		                           'updated_at' => date('Y-m-d'),
		                        );
		                        $this->CommonModel->iudAction('tbl_opportunity_tracker_attachement', $update_attch_data_a, 'insert');
		                    }        
		                }

					}

	                $this->session->set_flashdata('success','Opportunity Tracker Data Update Successfully');
		        }


	        	if($post['type'] == OPPORTUNITY_TYPE_ONE){
		        	redirect(base_url(ADMIN.'sales/OpportunityTracker/viewOpportunityTracker/'.$post['id'].'/'.OPPORTUNITY_TYPE_FOUR));
		        }else if($post['type'] == OPPORTUNITY_TYPE_THREE){
		        	redirect(base_url(ADMIN.'sales/OpportunityTracker/viewOpportunityTracker/'.$post['id_opp_track'].'/'.OPPORTUNITY_TYPE_FOUR));
		        }else if($post['type'] == OPPORTUNITY_TYPE_TWO){
		        	redirect(base_url(ADMIN.'sales/OpportunityTracker/viewOpportunityTracker/'.$post['id'].'/'.OPPORTUNITY_TYPE_FOUR));	
		        }else{
		        	redirect(base_url(ADMIN.'sales/OpportunityTracker'));	
		        }
			}
	    }



	    
	public function remove_opportunity_tracker_attachment()
	    {
	        $opportunity_tracker_id = $this->input->post('opportunity_tracker_id');
	          
	    	    if($this->CommonModel->iudAction('tbl_opportunity_tracker_attachement','','delete',array('id'=>$opportunity_tracker_id))){
	                $response['result'] = true;
	                // $response['reason'] = 'Removed Successfully';

	            }else{
	                $response['result'] = false;
	                // $response['reason'] = 'not Removed!';
	            }
	        echo json_encode($response);
	    }


	public function changeFavouriteFlag()
       {
          $is_favourite = $this->input->get('is_favourite');
          $opp_id = $this->input->get('id');

          if($this->CommonModel->iudAction('tbl_opportunity_tracker',array('is_favourite'=>$is_favourite),'update',array('id'=>$opp_id))){
               $response['result'] = TRUE;
               $response['reason'] = 'Technical Flag Updated Successfully';
              
           }else{
               $response['result'] = FALSE;
               $response['reason'] = 'Technical Flag Not Updated Successfully!';
           }
           echo json_encode($response);
       }
	

	    //  use customer view opportunity
	    public function list_opportunity_customer_tracker()
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
	        $where['ot.type'] = 0;

	         if($data['status_id'] == OPPORTUNITY_STATUS_COMPLETE || $data['status_id'] == OPPORTUNITY_STATUS_INPROCESS){
	            $where['ot.status'] = $data['status_id'];
	        }
	        
	        if($data['plant_id'] !== "all"){
	            $where['ot.plant_id'] = $data['plant_id'];
	        }else {
	        	// $where = array();
	        	$where['ot.type'] = 0;
	        }
	        
	        if(isset($data['customer_id'])){
	        	$where['ot.customer_id'] = $data['customer_id'];
	        }

	        $count = count($this->OpportunityTrackerModel->getOpportunityTrackerData($searchVal,0,0,0,0,0,$where));

	        if($count){
	            $result = $this->OpportunityTrackerModel->getOpportunityTrackerData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
	    // print_r($response);die;	
	                foreach ($result as $key => $value) {
	            
	                    $row = []; 
	                    array_push($row, $offset + ($key + 1));
	                    array_push($row, $value['title']);
	                    // array_push($row, $value['customer_name']);
	                    array_push($row, $value['contact_person_name']);
	                    array_push($row, $value['contact_person_mobile_no']);
	                    
	                    if($value['status']== OPPORTUNITY_STATUS_INPROCESS) {
		                    $status = '<p class="badge badge-warning">In-Process</p>';
		                 }else if($value['status']== OPPORTUNITY_STATUS_COMPLETE){
		                    $status = '<p class="badge badge-success">Complete</p>';
		                }
		                else{
		                    $status = '<span> - </span>';
		                }
	                    
	                    array_push($row, $status);

	                    $newDate = date("d F Y", strtotime($value['date']));
                        array_push($row, $newDate);
	                    
	                 


	                    $confirm = "confirm('Are you sure you want to delete this Opportunity Tracker data?')";
	                      
	                     $action='  
	                     		<a href="'.base_url().'admin/sales/OpportunityTracker/viewOpportunityTracker/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';

	                     	    
	                     	    // <a href="'.base_url().'admin/sales/OpportunityTracker/viewOpportunityTracker/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>


	                     		// <a href="'.base_url().'admin/sales/OpportunityTracker/send_quotation/'.$value['id'] .'" title="Send Quotation" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-file-alt" aria-hidden="true"></i></a>

						 // <a onclick="return ' . $confirm . '" href="' . base_url() . 'admin/OpportunityTracker/delete/' . $value['vendor_id'] . '" title="Delete" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="color: gray;" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>	                                            
	                     array_push($row, $action);
	                     $columns[] = $row;
	               }
	        }
	        $response = [
	            'draw' => $page,
	            'data' => $columns,
	            'recordsTotal' => $count,
	            'total_count' => $count,
	            'recordsFiltered' => $count
	        ];
	        echo json_encode($response);
	    }


		/// chetan code 10 05 2024

		public function getCustomerInfo()
		{
			$contact_person_mobile_no = $this->input->post('contact_person_mobile_no');
			$result = $this->CommonModel->getData('tbl_customer_contact_details',array('contact_mobile_no'=>$contact_person_mobile_no),'','','row_array');

			$output = array(
				'contact_mobile_no' => $result['contact_mobile_no'],
				'contact_person_name' => $result['contact_person_name'],
			);

			echo json_encode($output);
		}


		/// end chetan code 10 05 2024
	    
       
	}

?>
