<?php
/**
 * 
 */
class Lead extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
          $this->load->model(ADMIN.'sales/LeadModel');
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Lead';
        $this->load->view(ADMIN.'sales/lead/list_lead',$data);
    }
   
     public function listlead()
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
       

        
          
           
        if ($data['status_id'] !== "all") {
          $where['l.status_id'] = $data['status_id'];
        }

        if ($data['assigned_id'] !== "all") {
            $where['l.assigned_id'] = $data['assigned_id'];
        }

        if ($data['source_id'] !== "all") {
            $where['l.lead_source_id'] = $data['source_id'];
        }


         $count = count($this->LeadModel->getleadData($searchVal,0,0,0,0,0,$where));
         if($count){
             $result = $this->LeadModel->getleadData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
               
                 array_push($row, $value['name']);
                 array_push($row, $value['email']);
                 array_push($row, $value['phone']);
                array_push($row, ucfirst($value['first_name'] . " " . $value['last_name']));
                 
                 array_push($row, $value['source_name']);
                 array_push($row, $value['phone']);
                 array_push($row, $value['created_at']);
                 array_push($row, $value['requirement']);
                
                     if ($value['status_id'] == 1) {
                    array_push($row,'<center><span class="badge badge-danger">Pending</span></center>');
                } else if($value['status_id'] == 2) {
                    array_push($row, '<center><span class="badge badge-warning">In Process</center>');
                }
                else if($value['status_id'] == 3) {
                    array_push($row,'<center><span class="badge badge-info">Complete</center>');
                }
                else{
                   array_push($row, "");
                }

                 $confirm = "confirm('Are you sure you want to delete this ItemGroup?')";

                 $action = '
              
                   <a href="'.base_url().'admin/sales/Lead/viewLeadData/'.$value['id'] .'" title="view" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>

                  <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm editModal"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;"onclick="leadModal('.$value['id'] .')" data-id="'.$value['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>


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
 
  public function leadModal()
  {
    
    $id = $this->input->post('id');
     $data['sub_title'] = 'Add Lead';
      $data['status_data'] = $this->CommonModel->getData('tbl_lead_status',array('id'=> 1),'id,status');
    if ($id) {
      $lead = $this->LeadModel->getleadData('',0,0,0,0,$id);
       $data['sub_title'] = 'Edit Lead Master';
      $data['lead'] = $lead[0];
      $data['country_data'] = $this->CommonModel->getData('countries','','id,name');  
       $data['state_data'] = $this->CommonModel->getData('states',array('id'=>$data['lead']['state_id']),'id,name');
       $data['city_data'] = $this->CommonModel->getData('cities',array('id'=>$data['lead']['city_id']),'id,name');
       $data['status_data'] = $this->CommonModel->getData('tbl_lead_status',array('id'=> $data['lead']['status_id']),'id,status');
       $data['source_data'] = $this->CommonModel->getData('tbl_source',array('id'=> $data['lead']['lead_source_id']),'id,name');
       $data['assigned_data'] = $this->CommonModel->getData('users',array('id'=> $data['lead']['assigned_id']),'id,first_name');

  }
        // $data['country_data'] = $this->CommonModel->getData('countries','','id,name');  
      // echo '<pre>';print_r($data);die;    
    $html = $this->load->view(ADMIN.'sales/lead/model_lead', $data,true);
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


   public function reminderModal()
  {
   
    $id = $this->input->post('id');
  
    $html = $this->load->view(ADMIN.'sales/lead/model_reminders', $data,true);
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



public function viewLeadData($id='', $follow_up_id='') {
    $LeadData = $this->LeadModel->getleadData('', 0, 0, 0, 0, $id);
    $data =  $LeadData[0];
    
    $data['country_data'] = $this->CommonModel->getData('countries',array('id'=> $data['country_id']),'id,name');
        // $data['state_data'] = $this->CommonModel->getData('states',array('id'=> $data['state_id']),'id,name');
        $data['status'] = $this->CommonModel->getData('tbl_lead_status',array('id'=> $data['status_id']),'id,status');
        $data['source'] = $this->CommonModel->getData('tbl_source',array('id'=> $data['lead_source_id']),'id,name');
        $data['assigned'] = $this->CommonModel->getData('users',array('id'=> $data['assigned_id']),'id,first_name,last_name');
      
        $user_data = $this->LeadModel->viewUserData($id);
        $data['user_data'] = $user_data;

    $follow_up_data = $this->LeadModel->viewFollowupData($id);
    $data['follow_up_data'] = $follow_up_data;

    // Fetch reminder data for each follow-up
    $reminder_data = [];
    foreach ($follow_up_data as $follow_up) {
        $reminder_data[$follow_up['id']] = $this->LeadModel->viewReminderData($follow_up['id']);
    }
    $data['reminder_data'] = $reminder_data;
      // echo '<pre>';print_r($data['user_data']);die;
    $this->load->view(ADMIN.'sales/lead/view_lead', $data);
}


  public function add_lead()
  {
    $post = $this->input->post();
    
    if ($post) {

      if (empty($post['id'])) {
       
       if ($this->CommonModel->iudAction('tbl_lead',$post,'insert')) {
       
          $this->session->set_flashdata('success', 'Lead Added Succesfully!');
        }

        else{
          $this->session->set_flashdata('error','Fail To Add Lead!');
        }
      }else{
       
        if ($this->CommonModel->iudAction('tbl_lead',$post,'update',array('id'=> $post['id']))) {
          $this->session->set_flashdata('success','Lead Updated Succesfully!');
        }else{
          $this->session->set_flashdata('error','Fail To Update Lead!');
        }
      } 
      redirect(base_url(ADMIN.'sales/Lead'));
     } 
      
    }



   
   public function listsourceName($value='')
      {
          if(!isset($_GET['searchTerm'])){ 
              $json = [];
              $source_name=$this->LeadModel->getSourceName('');
          }else{
              $search = $_GET['searchTerm'];
              $source_name=$this->LeadModel->getSourceName($search);
          }
             foreach ($source_name as $key => $value) {
              
              $json[] = ['id'=>$value['id'], 'text'=>$value['name']];
              }  
          echo json_encode($json);
      }

      
    //  public function listassignedName($value='')
    //   {
    //       if(!isset($_GET['searchTerm'])){ 
    //           $json = [];
    //           $assigned_name=$this->LeadModel->getAssignedName('');
    //       }else{
    //           $search = $_GET['searchTerm'];
    //           $assigned_name=$this->LeadModel->getAssignedName($search);
    //       }
    //          foreach ($assigned_name as $key => $value) {
              
    //           $json[] = ['id'=>$value['id'], 'text'=>$value['first_name']];
    //           }  
    //       echo json_encode($json);
    //   }

      
    //   public function listatusName($value='')
    //   {
    //       if(!isset($_GET['searchTerm'])){ 
    //           $json = [];
    //           $status_name=$this->LeadModel->getStatusName('');
    //       }else{
    //           $search = $_GET['searchTerm'];
    //           $status_name=$this->LeadModel->getStatusName($search);
    //       }
    //          foreach ($status_name as $key => $value) {
              
    //           $json[] = ['id'=>$value['id'], 'text'=>$value['status']];
    //           }  
    //       echo json_encode($json);
    //   }

// public function sourceData() {

//     $post = $this->input->post();
//     if ($post) {
//         $data = array(
//             'name' => $post['name'], 
//         );

//         if (empty($post['id'])) {
//             if ($this->CommonModel->iudAction('tbl_source', $data, 'insert')) {
//                 $this->session->set_flashdata('success', 'Source Added Successfully!');
//             } else {
//                 $this->session->set_flashdata('error', 'Failed To Add Source!');
//             }
//         } else {
//             if ($this->CommonModel->iudAction('tbl_source', $data, 'update', array('id' => $post['id']))) {
//                 $this->session->set_flashdata('success', 'Source Updated Successfully!');
//             } else {
//                 $this->session->set_flashdata('error', 'Failed To Update Source!');
//             }
//         }

//     }
//     $data['status'] =  "Success";
//     echo json_encode($data);

// }

  public function add_reminders($id='')
    {
   
        $post = $this->input->post();
      
         $start_date = isset($post['start_date_time'])?$post['start_date_time']:'';            
                $start_date_timestamp = strtotime($start_date);
                $date_start = date('Y-m-d H:i:s', $start_date_timestamp); 

                if(isset($post['reminder_for_multiple'])) {
                    $end_date = isset($post['end_date_time']) ? $post['end_date_time'] : '';            
                    $end_date_timestamp = strtotime($end_date);
                    $date_end = date('Y-m-d H:i:s', $end_date_timestamp); 
                } else {
                    $end_date = NULL;
                }
                $module_id = 1;
                $class_name = 'orange';
        if ($post) {
              

                $reminder= array(
                        'title' =>isset($post['title'])?$post['title']:'',
                        'start_date_time' => isset($date_start)?$date_start:NULL, 
                        'end_date_time' => isset($date_end)?$date_end:NULL, 
                        'module_id' =>isset($module_id)?$module_id:NULL,
                        'class_name' => isset($class_name)?$class_name:'orange',
                        'is_display_to_all' => isset($post['is_display_to_all'])?$post['is_display_to_all']:'',
                        'reminder_for_multiple' => isset($post['reminder_for_multiple'])?$post['reminder_for_multiple']:'',
                        'user_id' =>userId('user_id'),
                      
                    );

         if(empty($post['id'])) {
           

                $insert_id = $this->CommonModel->iudAction('tbl_reminder',$reminder,'insert');
                 $this->session->set_flashdata('success','Reminder Data Added Succesfully!');


            }else{
    
                $this->CommonModel->iudAction('tbl_reminder',$reminder,'update',array('id' => $post['id']));
              
             
                $this->session->set_flashdata('success','Reminder Data Update Successfully');
         }
         
           redirect(base_url(ADMIN.'sales/Lead'));

        }
       
         $this->load->view(ADMIN.'sales/customer/add_customer',$data); 
  
    }


  public function fetchEventsData() {
    $dynamicData = $this->CommonModel->getData('tbl_reminder');
    $events = array();

    foreach ($dynamicData as $item) {
        $startDateTime = new DateTime($item['start_date_time']);
        $startFormatted = $startDateTime->format('Y-m-d\TH:i:s');

        $event = array(
            'title' => $item['title_reminder'], // Ensure 'title' property is set
            'start' => $startFormatted,
            'backgroundColor' => $item['class_name'],
        );

        if (userId('user_id') == $item['user_id']) {
            if (!empty($item['end_date_time'])) {
                $endDateTime = new DateTime($item['end_date_time']);
                $endFormatted = $endDateTime->format('Y-m-d\TH:i:s');
                $event['end'] = $endFormatted;
            }
            $events[] = $event;
        } elseif (userId('user_id') != $item['user_id'] && $item['is_display_to_all'] == 1 && $item['module_id'] == 1) {
            if (!empty($item['end_date_time'])) {
                $endDateTime = new DateTime($item['end_date_time']);
                $endFormatted = $endDateTime->format('Y-m-d\TH:i:s');
                $event['end'] = $endFormatted;
            }
            $events[] = $event;
        }
    }

    echo json_encode($events);
}


    
   public function lead_follow_up_modal($id='',$follow_up_id='')
{

   
    $data['lead_id']= $this->input->post('id');
    $follow_up_id= $this->input->post('follow_up_id');
    $data['sub_title'] = 'Add Lead';
    if ($follow_up_id !='') {
        $follow_up = $this->LeadModel->getFollowData($data['lead_id'],$follow_up_id);
        $reminder = $this->LeadModel->getReminderData($data['lead_id'],$follow_up_id);
         $data['sub_title'] = 'Edit Lead Master';
        $data['follow_up'] = $follow_up;
        $data['reminder'] = isset($reminder[0])?$reminder[0]:[];
      
    }
      // echo '<pre>';print_r($data['reminder']);die;
    $html = $this->load->view(ADMIN.'sales/lead/add_follow_up_model', $data, true);

    if ($html) {
        $response['html'] = $html;
        $response['result'] = true;
        $response['reason'] = 'Data Found';
    } else {
        $response['result'] = false;
        $response['reason'] = 'Something went wrong!';
    }

    echo json_encode($response);
}

public function submit_follow_up_data($id=''){
    $data['title'] = 'Follow Up';
    $post = $this->input->post();
     // echo '<pre>';print_r($post);die;
  if ($post) {
     
      $start_date = isset($post['start_date_time'])?$post['start_date_time']:'';            
                $start_date_timestamp = strtotime($start_date);
                $date_start = date('Y-m-d H:i:s', $start_date_timestamp); 

                $start_date = isset($post['start_date_time']) ? $post['start_date_time'] : '';            
                $start_date_timestamp = strtotime($start_date);
                $date_start = date('Y-m-d H:i:s', $start_date_timestamp); 

                $end_date = isset($post['end_date_time']) ? $post['end_date_time'] : NULL; // Set end date to NULL if not provided
                if (!empty($end_date)) {
                $end_date_timestamp = strtotime($end_date);
                $date_end = date('Y-m-d H:i:s', $end_date_timestamp); 
                }

              $module_id = SALES_LEAD;
              $class_name = 'orange';
    
        $insert_follow_up = array(
          
                      // 'id' => isset($post['id']) ? $post['id'] : '',
                      'lead_id' => isset($post['lead_id']) ? $post['lead_id'] : '',
                      'title' => isset($post['title']) ? $post['title'] : '',
                      'date' => isset($post['date']) ? $post['date'] : '',
                      'contact_person_name' => isset($post['contact_person_name']) ? $post['contact_person_name'] : '',
                      'contact_person_mobile_no' => isset($post['contact_person_mobile_no']) ? $post['contact_person_mobile_no'] : '',
                      'description' => isset($post['description']) ? $post['description'] : '',
                      'lead_add_reminder' => isset($post['lead_add_reminder']) ? $post['lead_add_reminder'] : '',
                      'created_by' => userId(),
                      'created_at' => date('Y-m-d H:i:s')
        );
      
         $Lead_add_reminders= array(
                        'title_reminder' =>isset($post['title_reminder'])?$post['title_reminder']:'',
                        'start_date_time' => isset($date_start)?$date_start:NULL, 
                        'end_date_time' => isset($date_end)?$date_end:NULL, 
                        'module_id' =>isset($module_id)?$module_id:NULL,
                        'class_name' => isset($class_name)?$class_name:'orange',
                        'is_display_to_all' => isset($post['is_display_to_all'])?$post['is_display_to_all']:'',
                        'reminder_for_multiple' => isset($post['reminder_for_multiple'])?$post['reminder_for_multiple']:'',
                        'user_id' =>userId('user_id'),
        );
            // print_r($post);die; 
           if(empty($post['id'])) {
            
                $insert_id = $this->CommonModel->iudAction('tbl_lead_follow_up',$insert_follow_up,'insert');
                if($insert_id && isset($post['lead_add_reminder']) && $post['lead_add_reminder']==1){
                    $Lead_add_reminders['ref_id']= $insert_follow_up['lead_id'];
                    $Lead_add_reminders['follow_up_id']= $insert_id;
                    $this->CommonModel->iudAction('tbl_reminder',$Lead_add_reminders,'insert');
                   
                }
                 $this->session->set_flashdata('success','Data Added Succesfully!');
            }
            else{

            //  echo '<pre>';print_r($insert_follow_up);     
            
                $this->CommonModel->iudAction('tbl_lead_follow_up',$insert_follow_up,'update',array('id' => $post['id']));

                  $reminder = $this->LeadModel->getReminderData($post['lead_id'],$post['id']);
                 // echo '<pre>';print_r(count($reminder)); die; 

                if(count($reminder)== 0){
                    if($post['lead_add_reminder']==1){
                      $Lead_add_reminders['ref_id']= $post['lead_id'];
                      $Lead_add_reminders['follow_up_id']= $post['id'];
                      $this->CommonModel->iudAction('tbl_reminder',$Lead_add_reminders,'insert');
                      // $this->session->set_flashdata('success','Data Added Succesfully!');
                  }
                } else{

                   $this->CommonModel->iudAction('tbl_lead_follow_up',$insert_follow_up,'update',array('id' => $post['id']));

                  if($post['lead_add_reminder']==1){
                   $this->CommonModel->iudAction('tbl_reminder',$Lead_add_reminders,'update',array('follow_up_id' =>$post['id']));
                 }else{
                  $this->CommonModel->iudAction('tbl_reminder',array('is_deleted'=>isLogin()),'update',array('follow_up_id'=>$post['id']));
                 }
                } 

                



             
                $this->session->set_flashdata('success','Data Update Successfully');
         }
         
          $this->session->set_flashdata('is_display_followup','1');
          
         // redirect(base_url(ADMIN.'sales/Lead/viewLeadData/'.$id.'#home'));
          redirect(base_url(ADMIN.'sales/Lead/viewLeadData/'.$insert_follow_up['lead_id']));
        
        }
      
}



}