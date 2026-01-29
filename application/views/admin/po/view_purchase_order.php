<?php init_header();?>

<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<link href="<?= base_url(); ?>/assets/node_modules/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<?php
// print_r($_SESSION);
// $msg = $this->session->flashdata('success');
// echo $msg;die;
?>
<style>
   .lbl_class{
      font-weight: bold;
   }
   .customtab li a.nav-link {
      padding: 4px 8px;
   }
   .wdth{
      width: 10%;
   }
   .wdth_a{
      width: 23%;  
   }
  
  .select2-selection__choice{
      background-color:#48bc97 !important ;
   }
   
   .swal2-modal{
      width:24%;
      margin-bottom:25% !important;  
   }

   .swal2-confirm,.swal2-cancel{
    border: 1px solid #48bc97 !important;
    transition: 0.2s ease-in !important;
    color: #fff !important;
    padding: 5px 10px !important;
    font-size: 16px !important;
    line-height: 1.4 !important;
   }

   .file-drop-zone-title {
    padding: 15px 10px !important;
   }

   .file-preview-image{
       width: auto !important;
       height: 40px !important;
   }

   .file-no-browse,.fileinput-cancel-button{
      display: none;
   }

   .kv-file-content{
      display: none !important;
   }

   .label-info {
      background-color: #48bc97;
   }
   
   .bootstrap-tagsinput{
      width: 100%;
   }

   span.tag{
      font-size: 12px;
   }
</style>
<style>
        .dropzone {border: none ;}
        .custom-dropzone {
            margin-top: 5px;
            padding: 5px;
            border: 2px dashed #ced4da;
            border-radius: 20px;
            background-color: #f1f8fe;
        }
        .dropzone-previews {
            margin-top: 10px;
        }
        .dropzone .dz-preview .dz-image {
            /*width: auto;*/
            /*height: 50px;*/
        }

    </style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- 1st  -->
   <div class="row">
      <div class="col-6">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 ">
                      <?php
                      $data['company_master']=$company_master;
                      $this->load->view(ADMIN.'po/common_list' ,$data); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-6">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 ">
                     <div class="row">
                        <div class="col-md-12">
                         
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs customtab" role="tablist">
                                  <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#purchase_order" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down text-color"><h6><b>Purchase Order Info</b></h6></span></a> </li>
                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#delivery_billing_site" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><h6><b>Delivery/Billing Site</b></h6></span></a> </li>
                                  
                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#item_tab" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><h6><b>Item</b></h6></span></a> </li>

                                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#terms_condition" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"><h6><b>Terms & Condition</b></h6></span></a> </li>
                              </ul>
                         

                               <!-- Tab panes -->
                               <div class="tab-content">
                                   <div class="tab-pane active" id="purchase_order" role="tabpanel">
                                       <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="row">
                                             <div class="col-md-7 ">
                                                <div class="row">
                                                   <div class="row col-md-12">
                                                      <input type="hidden" name="po_id" id="idpo" class="form-control po_status idpo" value="<?= isset($id)?$id :'';?>" >
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Po Order No.</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($po_order_no)?$po_order_no :''; ?></span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Vendor</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($vendor_name)?$vendor_name :''; ?></span>
                                                      </div>
                                                      
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Po Date.</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($po_date)?dmyDate($po_date) :''; ?></span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">PO Valid From and To</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($po_valid_from)?dmyDate($po_valid_from) :''; ?> to <?= isset($po_valid_to)?dmyDate($po_valid_to) :''; ?></span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">PO Status</label>
                                                      </div>
                                                     
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                            <?php $po_stat = isset($po_status)?$po_status :'';
                                                                  if($po_stat == 0){
                                                                     echo "Pending";
                                                                  }elseif($po_stat == 1) { 
                                                                     echo "Approved";
                                                                  }elseif($po_stat == 2) {
                                                                     echo "Reject";
                                                                  }else{
                                                                     echo "-";
                                                                  }  
                                                               ?>
                                                         </span>
                                                      </div>
                                                      <?php $po_stat = isset($po_status)?$po_status :'';
                                                         if($po_stat == 2){ ?>
                                                            <div class="form-group col-md-4 ">
                                                               <label class="lbl_class">Reject Reason</label>
                                                            </div>
                                                            <div class="form-group col-md-8 ">
                                                               <span>
                                                                  <?= isset($reject_reasons)?$reject_reasons :'';?>
                                                               </span>
                                                            </div>
                                                        <?php } ?>
                                                     

                                                      <?php $postat = isset($po_status)?$po_status :'';
                                                         if($postat == 1){ ?>  
                                                         <div class="form-group col-md-4 ">
                                                            <label class="lbl_class">Approved By</label>
                                                         </div>
                                                         <div class="form-group col-md-8 ">
                                                            <span>
                                                                <?php
                                                                       if($approved_first_name){
                                                                           $app_name=$approved_first_name." ".$approved_last_name;
                                                                       }else{
                                                                           $app_name='';
                                                                       }
                                                                   ?>
                                                               <?= isset($app_name)?$app_name :'';?>
                                                            </span>
                                                         </div>
                                                      
 
                                                         <div class="form-group col-md-4 ">
                                                            <label class="lbl_class">Approved At</label>
                                                         </div>
                                                         <div class="form-group col-md-8 ">
                                                            <span>
                                                               <?= isset($approved_at)?dmyDateTime($approved_at) :'';?>
                                                            </span>
                                                         </div>
                                                      <?php } ?>
 

                                                      
                                                        <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Created By</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                             <?php
                                                                    if($created_first_name){
                                                                        $created_name=$created_first_name." ".$created_last_name;
                                                                    }else{
                                                                        $created_name='';
                                                                    }
                                                                ?>
                                                            <?= isset($created_name)?$created_name :'';?>
                                                         </span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Address</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($vendor_dt[0]['vendor_address'])?$vendor_dt[0]['vendor_address']:'' ?></span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Is Email Approved by Vendor </label>
                                                      </div> 
 
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                            <?= (isset($vendor_approved) && $vendor_approved==1)?'Yes' :'';?>
                                                         </span>
                                                      </div>
                                                      <div class="form-group col-md-4 ">
                                                         <label class="lbl_class">Approved At</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                            <?= isset($vendor_approved_at)?date('d F Y',strtotime($vendor_approved_at)) :'';?>
                                                         </span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-5 ">
                                                 <form action="<?= base_url()."admin/PO/submit_update_status"; ?>" method="post">
                                                <div class="row">
                                                   <?php
                                                      $po_rate_approved_status = isset($po_rate_approved_status)?$po_rate_approved_status :'';
                                                       if((userId('role_id') == MANAGER_ROLE && $po_status == PO_STATUS_PENDING)|| userId('role_id')==SUPERADMIN_ROLE){
                                                            $readonly='';
                                                       }else{
                                                           $readonly='disabled';
                                                       }
                                                   ?>
                                                   <!-- <//?php if((userId('role_id') == MANAGER_ROLE)){?> -->
                                                      <div class="col-md-5" style="padding:0px 5px;">
                                                         <select class="form-control select2 mr_btm" id="chg_status" name="po_status" <?= $readonly; ?>>
                                                            <option >Change Status to</option>
                                                            <option value="0" <?= (isset($po_status)&& ($po_status==0) )?"selected":"" ?>>Pending</option>
                                                            <option value="1" <?= (isset($po_status)&& ($po_status==1) )?"selected":"" ?>>Approved</option>
                                                            <option value="2" <?= (isset($po_status)&& ($po_status==2) )?"selected":"" ?>>Reject</option>
                                                         </select> 
                                                      </div>
                                                   <!-- <//?php } ?> -->
                                                   
                                                   <?php 
                                                //   echo  userId('role_id'); die;
                                                   if((isset($po_rate_approved_status)&& !empty($po_rate_approved_status) && ($po_rate_approved_status == 0 || $po_rate_approved_status == 2))){ 
                                                   ?>   
                                                      <div class="col-md-2 send_email_btn_a" style="padding:0px 5px;display: none;">
                                                         <button type="button" class="btn btn-info btn-theme" data-toggle="modal" data-target="#exampleModalCenter">
                                                            <i class="mdi mdi-email"></i></button>
                                                      </div>

                                                      <div class="col-md-2 send_email_btn" id="" style="padding:0px 5px;display: none;">
                                                         <button type="button" class="btn btn-info btn-theme" id="model-error-icon_2" >
                                                         <i class="mdi mdi-email"></i></button>
                                                      </div>

                                                      <?php }else{ 
                                                     
                                                      ?>
                                                         <?php if(((userId('role_id') == MANAGER_ROLE) || (userId('role_id') == SUPERADMIN_ROLE)) && isset($po_status) && ($po_status==PO_STATUS_APPROVED) ){?>
                                                            <div class="col-md-2 send_email_btn" id="" style="padding:0px 5px;">
                                                               <button type="button" class="btn btn-info btn-theme" data-toggle="modal" data-target="#exampleModalCenter">
                                                                  <i class="mdi mdi-email"></i></button>
                                                            </div>
                                                         <?php } ?>
                                                   <?php }?> 

                                                </div>

                                                   <?php
                                                      $status_po = isset($po_status)?$po_status :'';
                                                      if((userId('role_id') == MANAGER_ROLE) && $status_po == PO_STATUS_PENDING){
                                                    ?>
                                                     <input type="hidden" name="po_id" class="form-control po_status" value="<?= isset($id)?$id :'';?>">
                                                     <div class="row">
                                                         <div class="col-md-5" id="reason" style="padding:3px 5px;display: none;">
                                                            <span>Reason</span>
                                                            <textarea type="text" class="form-control reject_reason" id="reason" name="reject_res" value="" style="height: 40px;"><?= isset($reject_reasons)?$reject_reasons:'';?></textarea>
                                                         </div>
                                                      </div>
                                                      <div class="row">
                                                       
                                                      <?php if((isset($po_rate_approved_status) && ($po_rate_approved_status == PO_STATUS_PENDING || $po_rate_approved_status == PO_STATUS_REJECTED )) && (userId('role_id') == MANAGER_ROLE || userId('role_id') == SUPERADMIN_ROLE )){ ?>   
                                                             <div class="col-md-5 submit_btn_1" id="" style="padding:3px 5px;display: none;">
                                                            <input class="btn btn-info btn-theme" alt="alert" class="img-fluid model_img"
                                                               id="model-error-icon_1"  style="float:right;width:60%" value="Update">
                                                         </div>

                                                         <div class="col-md-5 btn_submit" id="" style="padding:3px 5px;display: none;">
                                                            <input type="submit" class="btn btn-info btn-theme "  style="float:right;" value="Update">
                                                         </div>
                                                          
                                                      <?php }else{ 
                                                         
                                                      ?>
                                                       <div class="col-md-5 submit_btn" id="" style="padding:3px 5px;display: none;">
                                                            <input type="submit" class="btn btn-info btn-theme "  style="float:right;" value="Update">
                                                         </div>
                                                         
                                                      <?php }?> 

                                                   </div>

                                                   <?php
                                                      }
                                                   ?>
                                                </form>
                                                  
                                                
                                             </div>





                                          </div><hr>


                                          <div class="row">
                                             <div class="col-md-6">
                                                <span class="text-color"><h6><b>#<?= isset($po_order_no)?$po_order_no:'';?></b></h6></span>
                                             </div>
                                                <div class="col-md-6">
                                                    <?php if((isset($po_rate_approved_status) && ($po_rate_approved_status == PO_STATUS_PENDING || $po_rate_approved_status == PO_STATUS_REJECTED ))){ ?>   
                                                     <span class="text-danger"><p>The item rate is either approved pending or rejected.<?= $po_rate_approved_status; ?></p></span>
                                                     <?php
                                                        }
                                                     ?> 
                                                </div>
                                             <div class="form-group col-md-12 ">
                                                <span>Encon Group</span>
                                             </div>
                                          </div>
                                          <div class="col-md-12 mt-2 " style="">
                     
                                             <table class="table" >
                                                <tbody align="center">
                                                   <tr>
                                                      <td class="lbl_class" style="width:4%">Sr. No.</td>
                                                      <td class="lbl_class" style="width:20%">Item</td>
                                                      <td class="lbl_class" style="width:3%">Size/Part_No/ Grade</td>
                                                      <td class="lbl_class" style="width:3%">Qty/Unit</td>
                                                      <td class="lbl_class" style="width:3%">Weight</td>
                                                      <td class="lbl_class" style="width:3%">Unit Rate</td>
                                                      <td class="lbl_class" style="width:3%">Item Amount</td>
                                                      <td class="lbl_class" style="width:3%">Discount Amount</td>
                                                      <td class="lbl_class" style="width:3%">Gst/Vat Amount</td>
                                                      
                                                      <td class="lbl_class" style="width:3%">Total Amount</b></td>
                                                   </tr>
                                              
                                                   <?php $item_sub_amount=0; foreach($po_item_details_data as $key=>$value) {?>
                                                      <tr>
                                                         <td>
                                                            <span class=""><?= $key+1;?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_name'];?></span>
                                                         </td>
                                                         
                                                         <td>
                                                            <span class=""><?= $value['item_size'];?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_qty'];?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_weight'];?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_rate'];?></span>
                                                            <?php
                                                                if(isset($value['po_rate_approved_status']) && $value['po_rate_approved_status']==PO_STATUS_REJECTED){
                                                                    echo '<span class="badge badge-danger " >Reject</span>';
                                                                }else if(isset($value['po_rate_approved_status']) && $value['po_rate_approved_status']==PO_STATUS_APPROVED){
                                                                     echo '<span class="badge badge-success " >Approved</span>';
                                                                }else if(isset($value['po_rate_approved_status']) && $value['po_rate_approved_status']==PO_STATUS_PENDING){
                                                                     echo '<span class="badge badge-primary " >Pending</span>';
                                                                }
                                                            ?>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_sub_amount'];?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_discount_amount'];?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['tax_value']?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $value['item_amount'];?></span>
                                                         </td>
                                                      </tr>
                                                   <?php $item_sub_amount= $item_sub_amount + $value['item_sub_amount']; } ?>
                                                

                                                      <!-- po tax details -->

                                                      <?php foreach($po_tax_details_data as $key=>$val) {?>
                                                      <tr><td></td></tr>   
                                                      <tr>
                                                         <td colspan="6" align="right">
                                                            <span class="lbl_class">On Item Value</span>
                                                         </td>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">Discount</span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['discount_percent']." %"?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['discount_amount']?></span>
                                                         </td>
                                                      </tr>

                                                      <tr>
                                                         <td colspan="6" align="right">
                                                            <span class="lbl_class">On Bal</span>
                                                         </td>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">GST/VAT</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>

                                                         <td>
                                                            <span class=""><?= $val['gst_amount']?></span>
                                                         </td>
                                                      </tr>

                                                      <tr>
                                                         <td colspan="6" align="right">
                                                            <span class=""></span>
                                                         </td>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">LD Clause</span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>

                                                         <td colspan="1">
                                                            <span class=""><?= $val['ld_charges']?></span>
                                                         </td>
                                                      </tr>

                                                      
                                                      <tr>
                                                         <td colspan="6" rowspan="3" align="right">
                                                            <span class="lbl_class">Freight(F.O.R)</span>
                                                         </td>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">
                                                               <?php 
                                                                  if($val['freight_type']==1){
                                                                     echo "F.O.R";
                                                                  }else if($val['freight_type']==2) { 
                                                                     echo "TO PAY";
                                                                  }else{
                                                                     echo "-";
                                                                  } 
                                                               ?>
                                                            </span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>

                                                         <td>
                                                            <span class=""><?= $val['freight_amount'];?></span>
                                                         </td>


                                                      </tr>
                                                      <tr>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class" align="right">VAT/GST on Freight(F.O.R)</span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['freight_tax_name']?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['freight_tax_amount']?></span>
                                                         </td>
                                                      </tr>     
                                                      <tr>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class" align="right">Additional VAT on Freight</span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['freight_additional_tax_name']?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['freight_additional_tax_amount']?></span>
                                                         </td>

                                                         
                                                      </tr>                                                       
                                                      <tr>
                                                         <td colspan="6"  rowspan="2" align="right">
                                                            <span class="lbl_class">IF Any Other Add</span>
                                                         </td>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class"><?= $val['new_tax_name']?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class="">0</span>
                                                         </td>
                                                      </tr>     
                                                      <tr>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">VAT/GST on If Any Other</span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['new_gst_vat_name']?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['new_tax_amount']?></span>
                                                         </td>
                                                      </tr>    

                                                      <tr>
                                                         <td colspan="6" rowspan="2" align="right">
                                                            <span class="lbl_class" >Service Charges</span>
                                                         </td>
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">
                                                            <?php 
                                                                  if($val['service_charge_type']==1){
                                                                     echo "on service charge";
                                                                  }else if($val['service_charge_type']==2) { 
                                                                     echo "on item value";
                                                                  }else{
                                                                     echo "-";
                                                                  } 
                                                               ?>
                                                            </span>
                                                         </td>
                                                         <td>
                                                            <span class=""></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['service_charge_amount'];?></span>
                                                         </td>
                                                      </tr>     
                                                      <tr>
                                                         
                                                         <td colspan="2" align="right">
                                                            <span class="lbl_class">Service Tax</span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['tax_name'];?></span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['service_tax_amount'];?></span>
                                                         </td>
                                                      </tr> 

                                                      <tr>
                                                         <td colspan="9" align="right">
                                                            <span class="lbl_class">Round Off</span>
                                                         </td>
                                                         <td>
                                                            <span class=""><?= $val['round_off']?></span>
                                                         </td>
                                                      </tr>   
                                                       
                                                   <!-- <//?php } ?> -->

                                                   <tr>
                                                      <td colspan="9" align="right"><span style="font-weight:bold;">Sub Total</span></td>
                                                      <td><span style="font-weight:bold;"><?= $val['item_total_amount']?></span></td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td colspan="9" align="right"><span style="font-weight:bold;">Total</span></td>
                                                      <td><span style="font-weight:bold;"><?= moneyFormatIndia( $val['po_final_amount'] );?></span></td>
                                                      
                                                   </tr>
                                                <?php } ?>
                                                </tbody>
                                                 
                                             </table>

                                             <!-- tax details -->
                                             <table class="table" border="1">
                                                <tbody>
                                                   <tr>
                                                      <!-- <td style="width:4%"><b>Sr. No.</b></td>
                                                      <td style="width:30%"><b>Item</b></td>
                                                      <td style="width:5%"><b>Quantity</b></td>
                                                      <td style="width:5%"><b>Unit Price</b></td>
                                                      <td style="width:5%"><b>Into Money</b></td>
                                                      <td style="width:5%"><b>Tax</b></td>
                                                      <td style="width:5%"><b>Sub Total</b></td>
                                                      <td style="width:5%"><b>Discount</b></td>
                                                      <td style="width:10%"><b>Discount (money)</b></td>
                                                      <td style="width:10%"><b>Total</b></td> -->
                                                   </tr>
                                                   
                                                </tbody>
                                                 
                                          </table>

                                          </div>
                                       </div>
                                   </div>


                                   <div class="tab-pane " id="delivery_billing_site" role="tabpanel">
                                       <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="">
                                             <div class="col-md-12" style="padding: 0px;">
                                                <span class="text-color"><h6><b>Delivery/Billing Site Details</b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Delivery Days
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_days)?$delivery_days:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Delivery Days Alerts  
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_days_for_alerts)?$delivery_days_for_alerts:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Party
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_party_name)?$delivery_party_name:'';?> </span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Payment Days
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($payment_days)?$payment_days:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                             Payment Days Alerts  
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($payment_days_for_alerts)?$payment_days_for_alerts:'';?></span>
                                                      </td>
                                                      <td>
                                                         <span class="lbl_class">
                                                             Billing Site  
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($billing_site_name)?$billing_site_name :''; ?></span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Guarantee
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($guarantee)?$guarantee:'';?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                          Prices
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($prices)?$prices :'-'; ?></span>
                                                      </td>
                                                      <td>
                                                         <span class="lbl_class">
                                                            Delivery Site
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($delivery_site_name)?$delivery_site_name :''; ?></span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Address 1
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($address1)?$address1 :'-'; ?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Address 2
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($address2)?$address2 :'-'; ?></span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Address 3
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($address3)?$address3 :'-'; ?></span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="wdth">
                                                         <span class="lbl_class">
                                                           Reference
                                                         </span>
                                                      </td>
                                                      <td class="wdth_a">
                                                         <span><?= isset($reference)?$reference :'-'; ?></span>
                                                      </td>
                                                   </tr>
                                                  
                                                </tbody>
                                             </table>

                                             <div class="col-md-12" style="padding: 0px;">
                                                <span class="text-color"><h6><b>Cost Project Details</b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:5%">
                                                         <span class="lbl_class">
                                                            Line Before Address
                                                         </span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span><?= isset($line_before_address)?$line_before_address:'';?></span>
                                                      </td>
                                                      <td style="width:5%">
                                                         <span class="lbl_class">
                                                           Address
                                                         </span>
                                                      </td>
                                                      <td class="wdth">
                                                         <span><?= isset($cost_project_address)?$cost_project_address:'';?></span>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>


                                       </div>
                                   </div>



                                   <div class="tab-pane" id="item_tab" role="tabpanel">
                                      <div class="" style="padding: 15px 15px 0px 15px;">
                                       <?php foreach ($po_item_details_data as $key2 => $value2) {?>
                                          
                                          <div class="row">
                                             <div class="col-md-12" style="padding:0px"><hr>
                                                <span class="text-color"><h6><b><?= $key2+1;?>.&nbsp;<?= $value2['item_name'];?></b></h6></span>
                                             </div>
                                             <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:4%" > <i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%"><span class="lbl_class">
                                                            Item Name  
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><?= $value2['item_name'];?></td>
                                                   </tr>
                                                   <?php 
                                                      if($value2['dispatch_1_lot_date'] && $value2['dispatch_1_lot_qty'] ||
                                                         $value2['dispatch_2_lot_date'] && $value2['dispatch_2_lot_qty'] ||
                                                         $value2['dispatch_3_lot_date'] && $value2['dispatch_3_lot_qty'] ||
                                                         $value2['dispatch_4_lot_date'] && $value2['dispatch_4_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                               </i></td>
                                                            <td style="width:30%" ><span class="lbl_class">
                                                                  Dispatch Schedule Qty  
                                                               </span>
                                                            </td>
                                                            <td><span class="lbl_class">
                                                                  Date
                                                               </span>
                                                            </td>
                                                            <td><span class="lbl_class">
                                                                   Qty  
                                                               </span>
                                                            </td>
                                                         </tr>
                                                         <?php if($value2['dispatch_1_lot_date'] && $value2['dispatch_1_lot_qty']){ ?>
                                                            <tr>
                                                               <td style="width:3%" ></td>
                                                               <td style="width:30%"><span class="lbl_class">
                                                                     Dispatch 1St Lot  
                                                                  </span>
                                                               </td>
                                                               <td style="width:30%" ><?php if($value2['dispatch_1_lot_date']){
                                                                  echo $value2['dispatch_1_lot_date'];
                                                               }?>
                                                              </td>

                                                               <td style="width:30%" ><?php if($value2['dispatch_1_lot_qty']){
                                                                  echo $value2['dispatch_1_lot_qty'];
                                                               }?>
                                                               </td>
                                                            </tr>
                                                         <?php }?>
                                                         <?php if($value2['dispatch_2_lot_date'] && $value2['dispatch_2_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:3%" ></td>
                                                            <td style="width:30%"><span class="lbl_class">
                                                                  Dispatch 2nd Lot  
                                                               </span>
                                                            </td>
                                                            <td style="width:30%" ><?php if($value2['dispatch_2_lot_date']){
                                                               echo $value2['dispatch_2_lot_date'];
                                                            }?>
                                                            </td>

                                                            <td style="width:30%" ><?php if($value2['dispatch_2_lot_qty']){
                                                               echo $value2['dispatch_2_lot_qty'];
                                                            }?>
                                                            </td>
                                                         </tr>
                                                      <?php }?>
                                                      <?php if($value2['dispatch_3_lot_date'] && $value2['dispatch_3_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:3%" ></td>
                                                            <td style="width:30%"><span class="lbl_class">
                                                                  Dispatch 3rd Lot   
                                                               </span>
                                                            </td>
                                                            <td style="width:30%" ><?php if($value2['dispatch_3_lot_date']){
                                                               echo $value2['dispatch_3_lot_date'];
                                                            }?>
                                                            </td>

                                                            <td style="width:30%" >
                                                               <?php if($value2['dispatch_3_lot_qty']){
                                                               echo $value2['dispatch_3_lot_qty'];
                                                            }?>
                                                            
                                                            </td>
                                                         </tr>
                                                      <?php }?>
                                                      <?php if($value2['dispatch_4_lot_date'] && $value2['dispatch_4_lot_qty']){ ?>
                                                         <tr>
                                                            <td style="width:3%" ></td>
                                                            <td style="width:30%"><span class="lbl_class">
                                                                 Dispatch 4th Lot  
                                                               </span>
                                                            </td>
                                                            <td style="width:30%" ><?php if($value2['dispatch_4_lot_date']){
                                                               echo $value2['dispatch_4_lot_date'];
                                                            }?>

                                                            </td>

                                                            <td style="width:30%" ><?php if($value2['dispatch_4_lot_qty']){
                                                               echo $value2['dispatch_4_lot_qty'];
                                                            }?>
                                                            </td>
                                                         </tr>
                                                      <?php }?>
                                                   <?php }?>

                                                   <tr>
                                                      <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%" ><span class="lbl_class">
                                                           Item Description
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><span>
                                                            <?= isset($value2['item_description'])?$value2['item_description']:'';?>
                                                         </span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%" ><span class="lbl_class">
                                                           Other Description
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><span>
                                                            <?= isset($value2['other_description'])?$value2['other_description']:'';?>
                                                         </span>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="width:4%" ><i style="font-size: 14px;" class="fa fa-arrow-circle-right" aria-hidden="true">
                                                         </i></td>
                                                      <td style="width:30%" ><span class="lbl_class">
                                                           Technical Description
                                                         </span>
                                                      </td>
                                                      <td colspan="2"><span>
                                                            <?= isset($value2['technical_description'])?$value2['technical_description']:'';?>
                                                         </span>
                                                      </td>
                                                   </tr>

                                                </tbody>
                                             </table>
                                          </div>
                                          <?php }?>
                                       </div>
                                   </div>

                                   <div class="tab-pane" id="terms_condition" role="tabpanel">
                                      <div class="" style="padding: 20px 0px 0px 0px;">
                                          <div class="row">
                                             <div class="col-md-12">
                                                      <span class="text-color"><h6><b>Terms & Condition</b></h6></span><hr> 
                                                   </div>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="row col-md-12">
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Terms & Condition</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span>
                                                            <?= isset($terms_and_condition)?$terms_and_condition:'';?>
                                                         </span>
                                                      </div>
                                                      
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12 ">
                                                <div class="row">
                                                   <div class="form-group col-md-2">
                                                         <label class="lbl_class">Remark</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($remark)?$remark:'';?></span>
                                                      </div>
                                                      <div class="col-md-1"></div>
                                                      <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Jurisdiction</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($jurisdiction)?$jurisdiction:'';?></span>
                                                      </div>
                                                     <div class="col-md-1"></div>

                                                     <div class="form-group col-md-2 ">
                                                         <label class="lbl_class">Line in bottom</label>
                                                      </div>
                                                      <div class="form-group col-md-8 ">
                                                         <span><?= isset($line_in_bottom)?$line_in_bottom:'';?></span>
                                                      </div>
                                                      <div class="col-md-1"></div>
                                                      
                                                      <div class="col-md-1"></div>
                                                </div>
                                             </div>

                                             <div class="col-md-12 ">
                                                <div class="row">
                                                   <div class="col-md-12">
                                                      <span class="text-color"><h6><b>Attach Files</b></h6></span><hr> 
                                                   </div>
                                                    <?php $i=1;
                                                      if($attachment_file){
                                                         foreach ($attachment_file as $key => $value){?>
                                                            <div class="col-md-2">
                                                               <a class="image-popup-vertical-fit" href="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>"> 
                                                               <div class="col-md-6">
                                                                  <img class="image-popup-vertical-fit" src="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" height="50px"></a>  
                                                               </div>
                                                               </a>
                                                            </div>
                                                         <?php $i++; } }else{ ?> 
                                                            <div class="col-md-6">
                                                               <center>NO Data</center>
                                                            </div>
                                                   <?php } ?>
                                                </div>
                                             </div>

                                          </div>
                                       </div>
                                   </div>
                               </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

</div>
</div><br><br>
<!-- end row -->

<div id="display_item_details" class="modal fade mymodal" data-backdrop="static" data-keyboard="false"   role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div id="_item_details"></div>
       </div>
  </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLongTitle">Send a purchase order</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body" id="slimtest1" style="height: 700px !important;">
            <form action="<?= base_url();?>admin/PO/sendMailWithattchement" class="dropzone" enctype="multipart/form-data" method="post" class="form-upload" id="form_email" autocomplete="off">
               <input type="hidden" name="id_vendor" id="id_vendor" class="form-control po_status id_vendor" value="<?= isset($vendor_id)?$vendor_id :'';?>" >
               <input type="hidden" name="poid" id="poid" class="form-control" value="<?= isset($id)?$id :'';?>" >
            
               <div class="col-md-12">
                  <label class="lbl_class"><b style="color:red">*</b> Vendor Email</label>
                  <select class="form-control select2 mr_btm email_bg vendor_email_id" name="vendor_email_id[]" multiple="mutiple" id="" style=" width:100%;">
                     <?php
                         foreach ($vendor_master_email as $key => $value) {
                           if(! empty($value['email_id'])){
                              if((isset($vendor_id)&&$vendor_id==$value['vendor_id'])){
                               $selected="selected";
                                }else{
                                $selected="";
                              } ?>
                              <option value="<?= $value['email_id'] ?>"  <?= $selected; ?>><?= $value['email_id']?></option>   
                              
                           
                     <?php } } ?>
                  </select> 
               </div>



               <div class="col-md-12" style="margin:10px 0px 10px 0px;">
                  <label class="lbl_class">New Email</label>
                  <div class="tags-default" >
                     <input type="email" class="form-control" value="" name="new_email" id="new_email" data-role="tagsinput" placeholder="add tags" style="width:100%"> 
                  </div>
               </div>
                <?php
                    // print_r($department_data);
                    //  print_r($user_email);
                ?>
               <div class="col-md-12" style="margin:10px 0px 10px 0px;">
                  <label class="lbl_class"><b style="color:red">*</b> Send to</label>
                 
                  <select class="form-control select2 mr_btm email_bg idemail" name="email_id[]" multiple="mutiple" id="" style=" width:100%;">.
                    <?php
                        if(isset($department_data['email_id'])){
                    ?>
                     <option value="<?= $department_data['email_id'] ?>" selected><?= $department_data['email_id']; ?></option>
                    <?php
                        }
                    ?>
                     <?php
                         foreach ($user_email as $key => $value) {
                           if((isset($created_by)&&$created_by==$value['id'])){
                            $selected="selected";
                             }else{
                             $selected="selected";
                           } ?>
                        <option value="<?= $value['email'] ?>"  <?= $selected; ?>><?= $value['email'] ?></option>
                     <?php } ?>
                  </select> 
               </div>
               
               <div class="form-group col-md-12"  style="margin:10px 0px 0px 0px;">
                  <label class="lbl_class">Subject</label>
                  <input  type="text" class="form-control" id="subject" name="subject" required value="PO For <?= isset($vendor_name)?$vendor_name :''; ?>">
               </div>

               <div class="col-md-12" style="margin:10px 0px 0px 0px;">
                  <input type="checkbox" id="check" name="checkbox" value="1"><label>&emsp;Attach Purchase Order Files</label>&emsp;
                  <input type="checkbox" id="checkbox_po_invoice_pdf_name" name="checkbox_po_invoice_pdf_name" value="1" checked><label>&emsp;PO</label>
               </div>
               
               <div class="col-md-12" id="file_attach" style="display: none;">
                  <div class="row">
                      <?php $i=1;
                        if($attachment_file){
                           foreach ($attachment_file as $key => $value){?>
                              <div class="col-md-offset-3" style="padding:5px">
                                 <a class="image-popup-vertical-fit" id="ipsum" href="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" style="z-index: 1051"> 
                                    <div class="col-md-4">
                                       <img class="image-popup-vertical-fit" id="lorem" src="<?= base_url(); ?>assets/uploads/po_attchment/<?= (isset($value['file_name'])?$value['file_name']:'no_image.png')?>" height="50px"></a>  
                                    </div>
                                 </a>
                              </div>
                           <?php $i++; } 
                        }else{ ?> 
                           <div class="col-md-6">
                              <center>NO Data</center>
                           </div>
                     <?php } ?>
                  </div>
               </div>  
               <div class="form-group col-md-12 po_invoice_pdf"  style="margin:10px 0px 0px 0px; display: none;">
                  <label class="lbl_class">PO Invoice</label>
                  <?php if(isset($po_invoice_pdf_name)){?>
                        <input  type="hidden" class="form-control" name="po_invoice_pdf_name" value="<?= isset($po_invoice_pdf_name)?$po_invoice_pdf_name :'';?>" >
                        <span class=""><a target="_blank" href="<?= base_url(); ?><?=PO_PDF_PATH ?><?= $po_invoice_pdf_name?>"><p><?= isset($po_invoice_pdf_name)?$po_invoice_pdf_name :'';?></p></a></span>   
                  <?php } ?>
                  
               </div>

               <div class="form-group col-md-12" style="margin:10px 0px 0px 0px;">
                  <label class="lbl_class">Message</label>  
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#email_template_modal" data-whatever="@mdo" style="background-color: #48bc97 !important;padding: 5px 10px;">ADD Messages</button>
                   <textarea type="text"  id="message" name="message"  class="form-control message" ></textarea>
               </div>


               <div class="form-group col-md-12"  style="margin:10px 0px 0px 0px;">
                  <label class="lbl_class">Additional AttacheMent</label>
                   <!--<input  type="file" id="fileInput" class="form-control" name="additional_attacheMent[]" multiple />-->
                      <input type="file" id="fileInput" name="additional_attacheMent[]" style="display: none;" multiple>
                    <!-- Dropzone preview area -->
                                    <div id="dropzone" class="dropzone custom-dropzone"></div>
                                    <div class="dropzone-previews"></div>
                  <!-- <input  type="file" class="form-control"  name="additional_attacheMent[]" multiple > -->
               </div>



               <div class="modal-footer" style="margin-top: 15px;">
                 <button type="button" class="btn btn-secondary btn-theme" data-dismiss="modal">Close</button>
                 <input type="submit" class="btn btn-info btn-theme" style="" id="submit_po" value="Send">
               </div>
            </form>

         </div>
      
    </div>
  </div>
</div>
<div class="form-group col-md-12">
               
                 <div class="modal fade" id="email_template_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="left: 30%;;">
                    <div class="modal-dialog" role="document">
                       <div class="modal-content">
                          <div class="modal-header">
                             <h5 class="modal-title" id="exampleModalLabel">Email message</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <div class="modal-body">
                             <div class="col-12">
                                <form>
                                   <div class="table-responsive">
                                      <table id="myTable" class="tablesaw table-bordered table-hover table no-wrap" width="100%">
                                         <thead>
                                            <tr>
                                               <th>X</th>
                                               <th  width="10%">Sr.No</th>
                                               <th class="text-nowrap" >Messages</th>
                                            </tr>
                                         </thead>
                                         <tbody>
                                            <?php $i = 1; foreach($emailmessage as $mail) { ?>
                                            <tr>
                                               <td>
                                                  <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                                                     <input type="checkbox" class="custom-checkbox-checked" id="checkbox<?= $i; ?>"  name="" data-message="<?= $mail['message']; ?>"> 
                                                  </div>
                                               </td>
                                               <td><?= $i; ?></td>
                                               <td class="text-nowrap"><?= $mail['message']; ?></td>
                                            </tr>
                                            <?php $i++; }?>
                                         </tbody>
                                      </table>
                                   </div>
                                   <div class="modal-footer">
                                      <button type="button" class="btn btn-inverse btn-theme-sm" data-dismiss="modal">Close</button> 
                                      <button type="button" class="btn btn-success btn-theme"  onclick="updateData()" style="background-color: #48bc97;color:white;">Add</button>
                                   </div>
                                </form>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>

<br>

<?php init_footer(); ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/po.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/config.js"></script>

<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/additional-methods.js"></script>

<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>
 <script src="<?= base_url(); ?>/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url(); ?>/assets/node_modules/ps/perfect-scrollbar.jquery.min.js"></script>

<script>
  
    $('#chg_status').on('change', function() {
      var status = $('#chg_status').val();
      // alert(status);
      if(status == 1){
         $('#reason').hide();
         $('.submit_btn').show();
         $('.submit_btn_1').show();
         $('.btn_submit').hide();
         $('.send_email_btn_a').hide();
         $('.send_email_btn').show();

      }else if(status == 2){
        $('#reason').show();
        $('.submit_btn').show();
        $('.submit_btn_1').hide();
        $('.btn_submit').show();
        $('.send_email_btn_a').show();
        $('.send_email_btn').hide();

      }else{
         $('#reason').hide();
         $('.submit_btn').hide();
         $('.submit_btn_1').hide();
         $('.btn_submit').hide();
         $('.send_email_btn_a').hide();
         $('.send_email_btn').show();
      }
    });
   


</script>

<script type="text/javascript">
   $('#check').change(function(){
      var checked = $('#check').is(':checked');
         // alert(checked); 
      if(checked == true){
         $('#file_attach').show();
      }else{
         $('#file_attach').hide();
      }
  });


   $('#checkbox_po_invoice_pdf_name').change(function(){
      var checked_a = $('#checkbox_po_invoice_pdf_name').is(':checked');
         // alert(checked_a);
      if(checked_a == true){
         $('.po_invoice_pdf').show();
      }else{
         $('.po_invoice_pdf').hide();
      }

   });


//   CKEDITOR.replace( 'message',{
//      height: '100px'   ,
//      uiColor: '#383f48'    
//   });
   
   
</script>


<script>
 $(document).ready(function() {
    getPOListingVendorSiteData();
  
});
    

   $("#model-error-icon_1").click(function () {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Please Approve Pending Po Order Rate!',
                // footer: '<a href>Why do I have this issue?</a>'
            })
        });

   $("#model-error-icon_2").click(function () {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Please Approve Pending Po Order Rate!',
                // footer: '<a href>Why do I have this issue?</a>'
            })
        });


</script>


  <script>
    $(document).ready(function() {
    //   $('#email-tags-input').tagsinput({
    //     confirmKeys: [13, 44, 32], // Enter, comma, space
    //     typeahead: {
    //       source: function(query, process) {
    //         // Basic email validation using a regular expression
    //         var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    //         // Split the entered text into individual tags
    //         var tags = query.split(',');

    //         // Filter out invalid email tags
    //         var validEmailTags = tags.filter(function(tag) {
    //           return emailRegex.test(tag.trim());
    //         });

    //         process(validEmailTags);
    //       }
    //     }
    //   });
    $('#form_email').validate();
    });
    function updateData() {
      CKEDITOR.replace( 'message',{
     height: '100px'   ,
     uiColor: '#383f48'    
   });
    var checkboxes = document.querySelectorAll('.custom-checkbox-checked');
    var html_content = '';
    var hasListItems = false;

    Swal.fire({
        title: 'Are you sure to add Email Messages?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
   
      if (result.value) {
          checkboxes.forEach(function (checkbox) {
              if (checkbox.checked) {
                  var message = checkbox.dataset.message;
                  html_content += "<p>" + message + "</p>";
                  // console.log(html_content);
              }
          });

          var html = '<p>' + html_content + '</p>';
          CKEDITOR.instances.message.setData(html);
          $('#email_template_modal').modal('hide');
      } else {
          console.log("User clicked Cancel. CKEditor not updated.");
      }

    });
}

function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}
  document.getElementById("new_email").addEventListener("keydown", function(event) {
    // Check if the Enter key (key code 13) was pressed
    if (event.keyCode === 13) {
        // Prevent the default action (form submission, page refresh, etc.)
        event.preventDefault();
    }
});

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
 $('#slimtest1').perfectScrollbar();
  </script>
<script>
  var removedFiles = []; // Array to store removed files
 Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "upload.php",
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 10,
            maxFilesize: 50,
            acceptedFiles: '.jpg, .jpeg, .png, .gif, .pdf, .doc, .txt, .csv, .xlsx',
            dictDefaultMessage: 'Drop files here or click to upload',
            init: function() {
                var submitButton = document.getElementById("submit_po");
                var fileInput = document.getElementById("fileInput");
                
                
                var myDropzone = this;
              
                submitButton.addEventListener("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    var fileList = new DataTransfer();
                    myDropzone.files.forEach(function(file) {
                        if (file.upload === undefined) {
                            // Existing mock files, create a real file object
                           // var blob = new Blob([file], { type: file.type });
                           // var realFile = new File([blob], file.name, { type: file.type });
                          //  fileList.items.add(realFile);
                        } else {
                            // New files added by Dropzone
                            fileList.items.add(file);
                        }
                    });
                    fileInput.files = fileList.files;
                    
                  //   removedFilesInput.value = JSON.stringify(removedFiles);

                    document.getElementById("form_email").submit();
                });

                this.on("addedfile", function(file) {
                    console.log("Added file: " + file.name);
                });

                this.on("removedfile", function(file) {
                    console.log("Removed file: " + file.name);
                   // removedFiles.push(file.id);
                });
            }
        });
</script>
