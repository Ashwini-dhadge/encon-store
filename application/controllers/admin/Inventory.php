<?php
/**
 * 
 */
class Inventory extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
         $this->load->model(ADMIN.'InventoryModel');
         $this->load->model(ADMIN.'CommonCustModel');
         
        isLogin();
    }

    public function index()
    {
        $data['title'] = 'Inventory';
        $data['company_name'] = $this->CommonModel->getData('tbl_company_master',array('id'=>userId('company_id'),'is_active'=>1),'id,name');
        $data['site_name'] = $this->CommonModel->getData('tbl_site',array('id'=>userId('site_id'),'is_active'=>1),'id,site_name');
      $this->load->view(ADMIN.'inventory/list_inventory',$data);
    }


    public function list_inventory_data()
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

         if($data['companyid'] == "all"){
            $where = array();
         }else{
            $where['inv.company_id'] = $data['companyid'];
         }
         
          $where['inv.financial_year_id'] = userId('financial_year_id');
          

         if($data['site_id'] == "all"){
            if($data['companyid'] == "all"){
               $where = array();
            }else{
                $where['inv.company_id'] = $data['companyid'];
            }
         }else if(empty($data['site_id'])){
            $where = array();
         }else{
            $where['inv.site_id'] = $data['site_id'];
         }
         
         if($data['id_itemgroup'] == "all"){
           // $where = array();
         }else{
            $where['i.item_group'] = $data['id_itemgroup'];
         }
       
         if(isset($data['item_id']) && !empty($data['item_id']) && $data['item_id'] != "all"){
              $where['inv.item_id'] = $data['item_id'];
         }
          if($data['is_reserve_stock'] == RESERVE || $data['is_reserve_stock'] == NOT_RESERVE){
           $where['inv.is_reserve_stock'] = $data['is_reserve_stock'];
           }
          if($limit==-1){
              $limit=0;
          }
         $count = count($this->InventoryModel->getInventoryItemData($searchVal,0,0,0,0,0,$where));
       //  echo $this->db->last_query();
         if($count){
             $result = $this->InventoryModel->getInventoryItemData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where);
            // echo '<pre>'; print_r($result);die;
            $row1 = []; 
               foreach ($result as $key => $value) {
            
                 $row = []; 

                 array_push($row, $offset+($key+1));
                 array_push($row, $value['item_group_name']);
                  if($value['is_reserve_stock']== 1){                                             
                   $reserve_stock='<span class="badge badge-success" style="font-size: 10px;">Reserved</span>';
                   }else if($value['is_reserve_stock']== 0){
                   $reserve_stock='';
                    }
                 array_push($row, $value['item_name']." ".$reserve_stock);
                 array_push($row, $value['item_unit_name']);
                 array_push($row, $value['qty']);
                 array_push($row, $value['batch_no']);
                 array_push($row, dmyDate($value['expired_date']));
                 array_push($row, $value['company_name']);
                 array_push($row, $value['site_name']);
                 array_push($row, $value['to_date']." to ".$value['from_date']);
                 if($value['grn_item_rate_type'] && $value['grn_item_rate_type']==1){
                     $rate=$value['grn_item_rate'];
                     $total=$value['qty']*$value['grn_item_rate'];
                 }else if($value['grn_item_rate_type'] && $value['grn_item_rate_type']==2){
                     $rate=$value['grn_weight_per_rate'];
                     $total=$value['qty']*$value['grn_weight_per_rate'];
                 }else if($value['os_item_rate_type'] && $value['os_item_rate_type']==1){
                     $rate=$value['osd1_item_rate'];
                     if(!is_null($value['osd1_item_rate']) && !empty($value['osd1_item_rate'])){
                        $total=$value['qty']* $value['osd1_item_rate'];
                     }else{
                         $total=NULL;
                     }
                     
                 }else if($value['os_item_rate_type'] && $value['os_item_rate_type']==2){
                     $rate=$value['osd1_weight_per_rate'];
                     $total=$value['qty']*$value['osd1_weight_per_rate'];
                 }else if($value['recev_item_rate_type'] && $value['recev_item_rate_type']==1){
                     $rate=$value['rece_d_item_rate'];
                     $total=$value['qty']*$value['rece_d_item_rate'];
                 }else if($value['recev_item_rate_type'] && $value['recev_item_rate_type']==2){
                     $rate=$value['rece_weight_per_rate'];
                     $total=$value['qty']*$value['rece_weight_per_rate'];
                 }else{
                     $rate=NULL;
                    $total=NULL;
                 }
                 
                 array_push($row, $rate);
                 array_push($row, $total);
 
 
                $action ='<a href="'.base_url().'admin/Inventory/view_inventory_details/'.$value['id'].'" title="view" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" style="background:#F0F0F0;color: gray;" ><i class="fas fa-eye" aria-hidden="true"></i></a>';

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
   
   
   function export_all_inventory_data(){
         $data = $_POST;
         $columns = [];
         $where = array();

         if($data['companyid'] == "all"){
            $where = array();
         }else{
            $where['inv.company_id'] = $data['companyid'];
         }

         if($data['site_id'] == "all"){
            if($data['companyid'] == "all"){
               $where = array();
            }else{
                $where['inv.company_id'] = $data['companyid'];
            }
         }else if(empty($data['site_id'])){
            $where = array();
         }else{
            $where['inv.site_id'] = $data['site_id'];
         }
         
         if($data['id_itemgroup'] == "all"){
           // $where = array();
         }else{
            $where['i.item_group'] = $data['id_itemgroup'];
         }
         $where['inv.financial_year_id'] = userId('financial_year_id');
        
         $response = $this->InventoryModel->getInventoryItemData('',0,0,0,0,0,$where);
          echo json_encode($response);
   }

    public function view_inventory_details($id='')
    {

        $data['sub_title'] = 'Invetory Information';
        $where=array();
        $where['inv.financial_year_id'] = userId('financial_year_id');
        // print_r( userId('financial_year_id'));die;
        $inv_data = $this->InventoryModel->getInventoryItemData('',0,0,0,0,$id,$where);
        $data['sub_title'] = 'Invetory Information';
        if(isset($inv_data[0])&& !empty($inv_data[0])){
             $data['inventory'] = $inv_data[0];
        $data['company_name'] = $this->CommonModel->getData('tbl_company_master',array('id'=>$data['inventory']['company_id'],'is_active'=>1),'id,name');
        $data['site_name'] = $this->CommonModel->getData('tbl_site',array('id'=>$data['inventory']['site_id'],'is_active'=>1),'id,site_name');
        $data['item_name'] = $this->CommonModel->getData('tbl_items',array('id'=>$data['inventory']['item_id'],'deleted_by'=>NULL),'id,short_name');
           // $data['batch_name'] = $this->CommonModel->getData('tbl_items_inventory_details',array('id'=>$data['inventory']['id']),'batch_no');
        $data['batch_name'] = $this->CommonModel->getData('tbl_items_inventory',array('item_id'=>$data['inventory']['item_id'],'company_id'=>$data['inventory']['company_id'],'site_id'=>$data['inventory']['site_id']),'batch_no');

        $data['unit_name'] = $this->InventoryModel->getUnitNameData($data['inventory']['item_id']);

        // echo "<pre>"; print_r($data);die;
        $this->load->view(ADMIN.'inventory/inventory_details_view',$data);
        }else{
            redirect('admin/Inventory');
            // https://encongroup.co.in/ERP/admin/Inventory
        }
       
    }



   public function list_inventory_details_information()
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
         $where1 = array();
         $inv_item_unit_id = array();
          // $batch_no_a = array();
         // print_r($data);die;
        

         if($data['inv_item_unit_id']){
            $inv_item_unit_id = $data['inv_item_unit_id'];
         }
         $where['indt.financial_year_id'] = userId('financial_year_id');

         if($data['inventory_item_id_a'] == "all" || empty($data['inventory_item_id_a'])){
           
         }else{
            $where['indt.item_id'] = $data['inventory_item_id_a'];
         }

         
         if($data['companyid_a'] == "all" || empty($data['companyid_a'])){
            
         }else{
            $where['indt.company_id'] = $data['companyid_a'];
            
         }

         if($data['site_id_a'] == "all" || empty($data['site_id_a'])){
            
         }else{
           $where['indt.site_id'] = $data['site_id_a'];
            
         }


         if(isset($data['batch_no_a']) && $data['batch_no_a'] == "all" || empty($data['batch_no_a'])){
       
         }else{
             if(isset($data['batch_no_a'])){
                $where['batch_no like "'.$data['batch_no_a'].'"'] = NULL; 
             }
           
            
         }

         if(isset($data['batch_no_a']) && $data['item_unit_id'] == "all" || empty($data['item_unit_id'])){
       
         }else{
             if(isset($data['batch_no_a'])){
                  $where['iu.unit_id'] = $data['item_unit_id'];
             }
          
            
         }

           if($data['is_reserve_stock'] == RESERVE || $data['is_reserve_stock'] == NOT_RESERVE){
                $where['indt.is_reserve_stock'] = $data['is_reserve_stock'];
            }

        //for all total
         $totat_qty=$this->InventoryModel->getSUMQtyInventoryDetailsData($searchVal,0,0,0,0,0,$where,$where1,$inv_item_unit_id);
         $where_reserver=$where;
         $where_reserver['indt.is_reserve_stock'] = 1;
         $totat_reserve_qty=$this->InventoryModel->getSUMQtyInventoryDetailsData($searchVal,0,0,0,0,0,$where_reserver,$where1,$inv_item_unit_id);
       
      
         $count = count($this->InventoryModel->getInventoryDetailsData($searchVal,0,0,0,0,0,$where,$where1,$inv_item_unit_id));
        // echo $this->db->last_query();die;
         if($count){
             $result = $this->InventoryModel->getInventoryDetailsData($searchVal, $sortColIndex, $sortBy, $limit, $offset,0,$where,$where1,$inv_item_unit_id);
            //  echo '<pre>'; print_r($result);die;
             $row1 = [];
             $sum=$sum2=0;
               $total_reserve_stock=0;
               foreach ($result as $key => $value) {
                //   if ($value['is_reserve_stock'] == 1) {
                //         if($value['action']== 1){
                //             $total_reserve_stock=$total_reserve_stock+1;
                //         }else{
                //             $total_reserve_stock=$total_reserve_stock-1;
                //         }
                //     }
                 $row = []; 

                 array_push($row, $offset+($key+1));
                 //type     // 	1:grn 2:marterial_issued 3:Opening stock 4:transfer/recevied material 5:retrn
                 if($value['action']== 1 && $value['type']==1){
                    $grn_number = $this->CommonModel->getData('tbl_grn',array('id'=>$value['ref_id']),'id,grn_no','','row_array');
                     array_push($row, 'Add Stock Quantity By Reference Number <br> <a href="'.base_url().'admin/store/GoodsReceiptNote/view_grn/'.$value['ref_id'] .'" style="text-color:red !important" title="view" data-toggle="tooltip" >'.$grn_number['grn_no'].'</a>'); 
                   
                 }else  if($value['action']== 2 && $value['type']==1){
                    $grn_number = $this->CommonModel->getData('tbl_grn',array('id'=>$value['ref_id']),'id,grn_no','','row_array');
                     array_push($row, 'Reduce the quantity of stock by Reference number <br> <a href="'.base_url().'admin/store/GoodsReceiptNote/view_grn/'.$value['ref_id'] .'" style="text-color:red !important" title="view" data-toggle="tooltip" >'.$grn_number['grn_no'].'</a>'); 
                   
                 }else  if($value['action']== 1 && $value['type']==2){
                    $material_issued = $this->CommonModel->getData('tbl_material_issue',array('id'=>$value['ref_id']),'id,issue_number','','row_array');
                    array_push($row, 'add the quantity of stock that was returned.<br> <a href="'.base_url().'admin/store/MaterialIssue/view_material_issue/'.$value['ref_id'] .'" style="text-color:red !important" title="view" data-toggle="tooltip" >'.$material_issued['issue_number'].'</a>'); 
                   
                 }else if($value['action']== 2 && $value['type']==2){
                    $material_issued = $this->CommonModel->getData('tbl_material_issue',array('id'=>$value['ref_id']),',id,issue_number','','row_array');
                    array_push($row, 'Issued Stock Quantity By Reference Number <br> <a href="'.base_url().'admin/store/MaterialIssue/view_material_issue/'.$value['ref_id'] .'" style="text-color:red !important" title="view" data-toggle="tooltip" >'.$material_issued['issue_number'].'</a>'); 

                 }else if($value['action']== 2 && $value['type']==3){
                      $getData = $this->CommonModel->getData('tbl_items_opening_stock',array('id'=>$value['ref_id']),'id,deleted_reason','','row_array');
                    array_push($row, ' Reduce the quantity of opening stock becuase of <b>'.$getData['deleted_reason']."</b>"); 

                 }else  if($value['action']== 1 && $value['type']==3){
                    
                    array_push($row, 'add the quantity of stock that was Opening.'); 
                 }else if($value['action']== 2 && $value['type']==4){
                      $getData = $this->CommonModel->getData('tbl_recevied_material_issue',array('id'=>$value['ref_id']),'id,received_no','','row_array');
                    array_push($row, ' Reduce the quantity of Transfered becuase of <b>'.$getData['received_no']."</b>"); 

                 }else  if($value['action']== 1 && $value['type']==4){
                    
                    array_push($row, 'add the quantity of stock that was Transfered.'); 
                   
                 }else if($value['action']== 2 && $value['type']==5){
                      $getData = $this->CommonModel->getData('tbl_material_issue_return',array('id'=>$value['ref_id']),'id,m_rtn_no','','row_array');
                    array_push($row, ' Reduce the quantity of Return becuase of <b>'.$getData['m_rtn_no']."</b>"); 

                 }else  if($value['action']== 1 && $value['type']==5){
                    
                    array_push($row, 'add the quantity of stock that was Return.'); 
                     
                 }else{
                    array_push($row, "-");
                 }


                

                 array_push($row, $value['item_name']);
                 array_push($row, $value['item_unit_name']);
                  array_push($row, $value['batch_no']);
                  array_push($row, dmyDate($value['expired_date']));

                 array_push($row,$value['company_name']);
                 array_push($row,$value['site_name']);


                 if($value['type']== 1){
                   array_push($row, "GRN");     
                 }else if($value['type']== 2){
                    array_push($row, "Marterial Issued");
                 }else{
                    array_push($row, "-");
                 }

                 if($value['action']== 1){
                   array_push($row, $value['qty']);     
                   $sum = $sum + $value['qty'];
                 }else{
                    array_push($row, "-");
                 }


                 if($value['action']== 2){
                     array_push($row, $value['qty']);
                     $sum2 = $sum2 + $value['qty'];
                 }else{
                    array_push($row, "-");
                 }

                 $date = $value['created_at']; 
                 $new_date = date('d M Y', strtotime($date));
                  array_push($row, $new_date);

                 $time = $value['created_at']; 
                 $new_time = date('h:i:s a', strtotime($date));  
                  array_push($row, $new_time);

                  array_push($row, dmyDate($value['from_date'])." to ".dmyDate($value['to_date']));

                 $columns[] = $row;

             }


                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, '<span style="font-weight:bold"><b>Total</b></span>');

                array_push($row1, '<span>'.$sum.'</span>');
                array_push($row1, '<span>'.$sum2.'</span>');
                // $finl_total = $sum - $sum2;
                    
                array_push($row1, "");
                array_push($row1, "");
                array_push($row1, "");    
              $columns[] = $row1;

         }
        
         $response = [
             'draw' => $page,
             'data' => $columns,
             'recordsTotal' => $count,
             'recordsFiltered' => $count,
             'final_total' => isset($totat_qty['final_qty'])?$totat_qty['final_qty']:0,
             'total_reserve_stock' => isset($totat_reserve_qty['final_qty'])?$totat_reserve_qty['final_qty']:0,
         ];
         echo json_encode($response);
    
   }


    public function listInventoryUnitName($value='')
      {
          if(!isset($_GET['searchTerm'])){ 
              $json = [];
              $unit_name = $this->InventoryModel->getUnitNameData('');
          }else{
              $search = $_GET['searchTerm'];
              $unit_name = $this->InventoryModel->getUnitNameData($search);
          }
             $json[] = ['id'=>'all', 'text'=>'Select All'];
             foreach ($unit_name as $key => $value) {
              
              $json[] = ['id'=>$value['id_unit'], 'text'=>$value['unit_short_name']];
              }  
          echo json_encode($json);
      }




}
?>