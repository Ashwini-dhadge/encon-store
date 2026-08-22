<?php  init_header(); ?>
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/css/pages/stylish-tooltip.css" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<!-- Page wrapper  -->
<style>

 
 
   .text-nowrap{
       white-space: normal !important;
   }
      .text-nowrap{
       white-space: normal !important;
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
   .select2-selection.select2-selection--single {
  padding-right: 50px !important;
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
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<div class="row">
   <div class="col-lg-12">
      <div class="card ">
         <!--  <div class="card-header bg-info">
            <h4 class="m-b-0 text-white">Purchase Order </h4>
            </div> -->
         <div class="card-body">
            <form  enctype="multipart/form-data" method="post" class="dropzone" autocomplete="off" id="frm_po" name="frm_po" action="<?= base_url('admin/PO/add_po'); ?>">
                <?php if (isset($type) && $type == 1) {
                        $_po_info_id = '';
                     } else if (isset($type) && $type == 2) {
                        $_po_info_id = '';
                     } else {
                        if (isset($po_info['id'])) {
                           $_po_info_id = $po_info['id'];
                        } else {
                           $_po_info_id = '';
                        }
                     }
                     ?>
                <input type="hidden" name="id" id="id" value="<?= $_po_info_id; ?>">
                <input type="hidden" name="type" id="type" value="<?= isset($type) ? $type : ''; ?>">
                <input type="hidden" name="amendment_sequences" id="amendment_sequences" value="<?= isset($amendment_sequences) ? $amendment_sequences : ''; ?>">
                <input type="hidden" name="amendment_po" id="amendment_po" value="<?= isset($amendment_po) ? $amendment_po : ''; ?>">
                <input type="hidden" name="po_order_sequence" id="po_order_sequence" value="<?= isset($po_order_sequence)?$po_order_sequence:''; ?>">
                <input type="hidden"  id="vendorId" value="<?= (isset($po_info['vendor_id']))?$po_info['vendor_id']:''; ?>">             
                 <input type="hidden"  id="billingSiteId" value="<?= (isset($po_info['billing_site_id']))?$po_info['billing_site_id']:''; ?>">
                <input type="hidden"  id="deliverySiteId" value="<?= (isset($po_info['delivery_site_id']))?$po_info['delivery_site_id']:''; ?>">
                <input type="hidden"  id="deliveryPartyId" value="<?= (isset($po_info['delivery_party_id']))?$po_info['delivery_party_id']:''; ?>">
                <div class="form-body">
                  <div class="row ">
                     <div class="col-md-6">
                        <h3 class="box-title">Purchase Order Info</h3>
                     </div>
                     <div class="col-md-6">
                        <h3 class="box-title">Cost Project</h3>
                     </div>
                  </div>
                  <hr class="m-t-0 m-b-10">
                  <div class="row ">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">PO Order No. </label>
                           <div class="col-md-8">
                               <div class="col-md-9">
                                    <?php if (isset($type) && $type == 1) { ?>
                                       <input type="text" class="form-control" value="<?= $po_number; ?>" readonly name="po_order_no" id="po_order_no">
                                    <?php } elseif (isset($type) && $type == 2) { ?>
                                       <input type="text" class="form-control" value="<?= $po_number; ?>" readonly name="po_order_no" id="po_order_no">
                                    <?php } else { ?>
                                       <input type="text" class="form-control" value="<?= (isset($po_info['po_order_no'])) ? $po_info['po_order_no'] : $po_number; ?>" readonly name="po_order_no" id="po_order_no">
                                    <?php } ?>

                                 </div>
                             
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">PO Date </label>
                           <div class="col-md-8">
                              <div class="input-group">
                                 <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="po_date" id="po_date" value="<?= (isset($po_info['po_date']))?date('d/m/Y',strtotime($po_info['po_date'])):date('d/m/Y'); ?>">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <!--   <div class="form-group row">
                           <label class="control-label text-right col-md-3">Vendor </label>
                           <div class="col-md-9">
                              <input type="text" class="form-control">
                           </div>
                           </div> -->
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Line Before Address </label>
                           <div class="col-md-8">
                              <textarea class="form-control" id="line_before_address" value="<?= (isset($po_info['line_before_address']))?$po_info['line_before_address']:''; ?>"  name="line_before_address" >Dear Sir, We are pleased to place our order for followings and requests you to acknowledge receipt and confirm per return  </textarea>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!--/row-->
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">PO Valid From and To</label>
                           <div class="col-md-8">
                              <div class='input-group mb-3'>
                                 <?php
                                    if(isset($po_info['po_valid_from']) && isset($po_info['po_valid_to']) ){
                                       $date=date("m/d/Y",strtotime($po_info['po_valid_from']))." - ".date("m/d/Y",strtotime($po_info['po_valid_to']));
                                    
                                    }else{
                                        $date='';
                                    }
                                    ?>
                                 <input type='text' class="form-control daterange"   required id="po_valid_from_to_date" name="po_valid_from_to_date"  value="<?=  $date; ?>" />
                                 <div class="input-group-append">
                                    <span class="input-group-text">
                                    <span class="ti-calendar"></span>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">vendor </label>
                           <div class="col-md-8">
                              <select class="form-control custom-select select2 get_vendor" style="width:100%"  name="vendor_id" id="vendor_id" required>                               
                              </select>
                              <label id="vendor_id-error" class="error" for="vendor_id"></label>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Address </label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="cost_project_address" id="cost_project_address" value="<?= (isset($po_info['cost_project_address']))?$po_info['cost_project_address']:''; ?>">
                           </div>
                        </div>
                     </div>
                   

                     <!--/span-->
                     <!--/span-->
                  </div>
                  <h3 class="box-title">Delivery/Billing Site</h3>
                  <hr class="m-t-0 m-b-10">
                  <!--/row-->
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Delivery Days</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="delivery_days" id="delivery_days" value="<?= (isset($po_info['delivery_days']))?$po_info['delivery_days']:''; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-6"> For Alerts</label>
                           <div class="col-md-6">
                              <input type="text" class="form-control numberonly" id="delivery_days_for_alerts" name="delivery_days_for_alerts" value="<?= (isset($po_info['delivery_days_for_alerts']))?$po_info['delivery_days_for_alerts']:''; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Billing Site</label>
                           <div class="col-md-8">
                              <select class="form-control custom-select select2" id="billing_site_id" name="billing_site_id" style="width:100%">
                                 <option></option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Address 1 </label>
                           <div class="col-md-8">
                               <input type="hidden" value="<?= $site_info['site_address']; ?>" id="site_address">
                              <input type="text" class="form-control" value="<?= (isset($po_info['address1']))?$po_info['address1']: $site_info['site_address']; ?>"  name="address1" id="address1"> 
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Payment Days</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" id="payment_days" name="payment_days" value="<?= (isset($po_info['payment_days']))?$po_info['payment_days']:''; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-6"> For Alerts</label>
                           <div class="col-md-6">
                              <input type="text" class="form-control numberonly" id="payment_days_for_alerts" name="payment_days_for_alerts" value="<?= (isset($po_info['payment_days_for_alerts']))?$po_info['payment_days_for_alerts']:''; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Delivery Site </label>
                           <div class="col-md-8">
                              <select class="form-control custom-select select2" id="delivery_site_id" name="delivery_site_id" style="width:100%">
                                 <option></option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Address 2 </label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" placeholder="Address2" name="address2" id="address2"  value="<?= (isset($po_info['address2']))?$po_info['address2']:''; ?>">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Guarantee</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" id="guarantee" name="guarantee"  value="<?= (isset($po_info['guarantee']))?$po_info['guarantee']:''; ?>">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-2">
                     </div>
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Party</label>
                           <div class="col-md-8">
                              <select class="form-control custom-select select2 get_vendor" id="delivery_party_id" name="delivery_party_id" style="width:100%" onchnage="getAddressSite(this)" >                               
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Address 3 </label>
                           <div class="col-md-8">
                              <input type="text"  class="form-control" name="address3" id="address3" value="<?= (isset($po_info['address3']))?$po_info['address3']:''; ?>">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Reference</label>
                           <div class="col-md-8">
                              <textarea class="form-control" id="reference" name="reference" value=""><?= (isset($po_info['reference']))?$po_info['reference']:''; ?></textarea>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group row">
                           <label class="control-label text-right col-md-4">Prices</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" id="prices" name="prices" value="<?= (isset($po_info['prices']))?$po_info['prices']:''; ?>">
                           </div>
                        </div>
                         <div class="form-group row">
                               <label class="control-label text-right col-md-4">Cost Project Name</label>
                               <div class="col-md-8">
                                   <select class="form-control custom-select select2 get_cost_project" style="width:100%" name="cost_project_id" id="cost_project_id" >
                                        <option value=""></option>
                                       <?php foreach ($cost_projects as $cost_project): ?>
                                           <option value="<?php echo $cost_project['id']; ?>" <?php echo isset($po_info['cost_project_id']) && $cost_project['id'] == $po_info['cost_project_id'] ? 'selected' : ''; ?>>
                                               <?php echo $cost_project['cost_project_name']; ?>
                                           </option>
                                       <?php endforeach; ?>
                                   </select>
                                   <label id="cost_project_id-error" class="error" for="cost_project_id"></label>
                               </div>
                           </div>
                     </div>
                     <div class="col-md-3">
                          
                  </div>
                  </div>
                  <h3 class="box-title">Items</h3>
                  <hr class="m-t-0 m-b-10">
                  <div class="table-responsive repeater" id="repeater_po_item">
                     <a href="javascript:void(0)" data-repeater-create class="float-right" style="margin-right:25px;"  >
                        <i class="fa fa-plus-circle">
                           <div></div>
                        </i>
                        <label id="lbl_eway_bill">Add Items</label>
                     </a>
                     <table class="table table-bordered" data-repeater-list="items" id="po_items_tables">
                        <thead>
                           <tr>
                              <th width="15%">Item Group/ Item Name * </th>
                              <th width="7%">Size/ Part-No/ Grade </th>
                              <th width="15%">Qty/Unit</th>
                              <th width="5%">Weight</th>
                              <th width="5%">Unit Rate</th>
                              <th width="5%">Item Amt</th>
                              <th width="5%">Disc. Rate %/Amount </th>
                              <th width="10%">GST/VAT Rate % / Amt</th>
                              <th width="10%">Amount</th>
                           </tr>
                        </thead>
                        
                        <?php
                           if(isset($po_info_items)&& !empty($po_info_items)):
                           ?>
                        <?php
                            // echo "<pre>";print_r($po_info_items);die;
                           foreach ($po_info_items as $key1 => $po_items) {
                           ?>
                        <tbody  data-repeater-item  class="repeater-item main_tbl_reapter">
                           <tr name="reapter_item_row" class="bg-light repeater-item1" >
                              <td>
                                 <div class="form-group ">
                                    <input type="hidden" name="po_item_id" value="<?= $po_items['po_item_id']; ?>">
                                    <input type="hidden" name="delete_type" value="2">
                                    <label class="control-label text-left col-md-12">Item Group  </label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 item_group_select2" name="item_group_id" style="width:100%" onchange="getItemList(this)" readonly>
                                            <?php
                                                if(isset($po_items['item_group_id']) && $po_items['item_group_id']=="0"){
                                                    $selected="selected";
                                                    $option='<option value="all" selected >all</option>';
                                                }
                                            ?>
                                             <?= ($option)? $option:''; ?>
                                          <?php
                                             foreach($item_group as $key_i=>$value_item){
                                                  $option='';
                                                if (isset($value_item['parent_group_name'])) {
                                                        $text = $value_item['item_group_name'] . " (" . $value_item['parent_group_name'] . ")";
                                                } else {
                                                        $text =$value_item['item_group_name'];
                                                }
                                                 $selected='';
                                                if($po_items['item_group_id']==$value_item['id']){
                                                   $selected="selected";
                                             
                                                }
                                                
                                              
                                               
                                             ?>
                                       
                                          <option value="<?= $value_item['id']; ?>" <?= $selected; ?>><?= $text ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" name="items_id" style="width:100%" onchange="getItemUnits(this)" readonly>
                                          <?php
                                             foreach($po_items['item_list'] as $key_i1=>$value_item1){
                                                
                                                 $selected='';
                                                if($po_items['item_id']==$value_item1['id']){
                                                   $selected="selected";
                                                }
                                             ?>
                                          <option value="<?= $value_item1['id']; ?>" <?= $selected; ?>><?= $value_item1['item_name'] ?></option>
                                          <?php
                                             }
                                             ?>
                                       </select>
                                    </div>
                                                                        <div class="col-md-12" style="text-align:right">
                                       <a class="mytooltip" href="javascript:void(0)"><i class="btn btn-sm  fas fa-info-circle" style="margin-top: 2px;font-size: 20px;" aria-hidden="true"></i>
                                          <span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2" style="padding: 10px;">
                                             <div class="">
                                                <table class="table-bordered table-hover no-wrap" width="100%">
                                                    <tbody style="font-size:11px;color: white;">
                                                        <tr>
                                                            <td style="color:white;">Sr.No</td>
                                                            <td style="color:white;">Po Number</td>
                                                             <td style="color:white;">Vendor Name</td>
                                                            <td style="color:white;">Unit</td>
                                                            
                                                            <td style="color:white;">Rate</td>
                                                        </tr>
                                                    </tbody>
                                                    <?php if(isset($item_rate_updated_data)){?>
                                                    <tbody id="tbl_item_rate_update_html" name="tbl_item_rate_update_html">
                                                    <?php  $i = 1; foreach($item_rate_updated_data[$key1] as $update_rate) { ?>
                                                         <tr  style="font-size:11px">
                                                             <td style="color:white;"><span></span><?= $i; ?></td>
                                                             <td style="color:white;"><span></span><?= $update_rate['po_order_no']; ?></td>
                                                              <td style="color:white;"><?= $update_rate['vendor_name']; ?></td>
                                                             <td style="color:white;"><span></span><?= $update_rate['unit_name']; ?></td>
                                                             <td style="color:white;"><span></span><?= $update_rate['item_rate']; ?></td>
                                                         </tr>
                                                     <?php $i++; }?>
                                                  <?php }?>
                                                  </tbody>
                                                </table>
                                             </div>
                                       </span></span></span></a>
                                    </div>
                                 </div>
                                 <div class="form-group m-t-40">
                                    <label class="control-label text-left col-md-12">HSC Code</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control" name="item_hsc_code" readonly value="<?= ($po_items['hsn_code'])?$po_items['hsn_code']:''; ?>">
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">STOCK QTY</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control" name="item_stock_qty" value="<?= ($po_items['item_stock_qty'])?$po_items['item_stock_qty']:''; ?>">
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <input type="text" class="form-control" placeholder="Size/ Part-No/ Grade " name="item_size" value="<?= ($po_items['item_size'])?$po_items['item_size']:''?>">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">
                                    <input type="text" class="form-control po_item_cal numberonly" required name="item_unit"  onkeydown="calculatePOItemEvent(event,this)" value="<?= ($po_items['item_qty'])?$po_items['item_qty']:''?>">
                                    <select class="form-control custom-select select2" style="width:100%" name="item_unit_id" id="item_unit_id" required >
                                       <?php
                                          foreach($po_items['item_unit_list'] as $key_i2=>$value_item2){
                                             
                                              $selected='';
                                             if($po_items['item_unit_id']==$value_item2['id']){
                                                $selected="selected";
                                             }
                                          ?>
                                       <option value="<?= $value_item2['id']; ?>" <?= $selected; ?>><?= $value_item2['short_name'] ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </div>
                                 <table class="table table-bordered">
                                    <tr>
                                       <td colspan="3"><b>Dispatch Schedule Qty.</b></td>
                                    </tr>
                                    <tr>
                                       <td width="20%" >1st Lot</td>
                                       <td width="35%"><input type="text" class="form-control numberonly"  name="dispatch_1_lot_qty" value="<?= ($po_items['dispatch_1_lot_qty'])?$po_items['dispatch_1_lot_qty']:''; ?>"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control" name="dispatch_1_lot_date" value="<?= ($po_items['dispatch_1_lot_date']&& $po_items['dispatch_1_lot_date']!='1970-01-01')?date('Y-m-d',strtotime($po_items['dispatch_1_lot_date'])):'' ?>">
                                             <!--<div class="input-group-append">-->
                                             <!--   <span class="input-group-text"><i class="ti-calendar"></i></span>-->
                                             <!--</div>-->
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="20%" >2nd Lot</td>
                                       <td width="35%"><input type="text" class="form-control numberonly"  name="dispatch_2_lot_qty" value="<?= ($po_items['dispatch_2_lot_qty'])?$po_items['dispatch_2_lot_qty']:'' ?>"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control "   name="dispatch_2_lot_date" value="<?= ($po_items['dispatch_2_lot_date']&& $po_items['dispatch_2_lot_date']!='1970-01-01')?date('Y-m-d',strtotime($po_items['dispatch_2_lot_date'])):'' ?>">
                                             <!--<div class="input-group-append">-->
                                             <!--   <span class="input-group-text"><i class="ti-calendar"></i></span>-->
                                             <!--</div>-->
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="20%" >3rd Lot</td>
                                       <td width="35%"><input type="text" class="form-control numberonly"  name="dispatch_3_lot_qty" value="<?= ($po_items['dispatch_3_lot_qty'])?$po_items['dispatch_3_lot_qty']:'' ?>"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control "  name="dispatch_3_lot_date" value="<?= ($po_items['dispatch_3_lot_date'] && $po_items['dispatch_3_lot_date']!='1970-01-01')?date('Y-m-d',strtotime($po_items['dispatch_3_lot_date'])):'' ?>">
                                             <!--<div class="input-group-append">-->
                                             <!--   <span class="input-group-text"><i class="ti-calendar"></i></span>-->
                                             <!--</div>-->
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="20%" >4th Lot</td>
                                       <td width="35%"><input type="text" class="form-control numberonly"  name="dispatch_4_lot_qty" value="<?= ($po_items['dispatch_4_lot_qty'])?$po_items['dispatch_4_lot_qty']:'' ?>"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control "   name="dispatch_4_lot_date" value="<?= ($po_items['dispatch_4_lot_date'] && $po_items['dispatch_4_lot_date']!='1970-01-01')?date('Y-m-d',strtotime($po_items['dispatch_4_lot_date'])):'' ?>">
                                             <!--<div class="input-group-append">-->
                                             <!--   <span class="input-group-text"><i class="ti-calendar"></i></span>-->
                                             <!--</div>-->
                                          </div>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                              <td>
                                 <div class="form-group ">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_weight" placeholder="Weight" value="<?= ($po_items['item_weight'])?$po_items['item_weight']:'' ?>" onkeydown="calculatePOItemEvent(event,this)">
                                    <!--   <select class="form-control custom-select select2" style="width:100%">
                                       <option>All</option>
                                       </select>
                                       -->
                                 </div>
                              </td>
                              <td>
                                 <input type="text" class="form-control po_item_cal allow_decimal" placeholder="item Rate" name="item_unit_rate"  onkeydown="calculatePOItemEvent(event,this)" value="<?= ($po_items['item_rate'])?$po_items['item_rate']:'' ?>">
                                 <select class="form-control custom-select select2" style="width:100%" name="item_rate_type"  onchange="calculatePOItem( this);">
                                    <option value="1" <?= (isset($po_items['item_rate_type'])&& ($po_items['item_rate_type']==1) )?"selected":"" ?>>Qty</option>
                                    <option value="2" <?= (isset($po_items['item_rate_type'])&& ($po_items['item_rate_type']==2) )?"selected":"" ?>>Weight</option>
                                 </select>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_rate"  readonly value="<?= ($po_items['item_sub_amount'])?$po_items['item_sub_amount']:''?>">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal" placeholder="Disc. Rate %/Amount " value="<?= ($po_items['item_discount_percent'])?$po_items['item_discount_percent']:''?>"  name="discount_percent" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" name="discount_type" onchange="calculatePOItem( this);">
                                       <option value="1"<?= (isset($po_items['item_discount_type'])&& ($po_items['item_discount_type']==1) )?"selected":"" ?>>@ Val</option>
                                       <option value="2"<?= (isset($po_items['item_discount_type'])&& ($po_items['item_discount_type']==2) )?"selected":"" ?>>@ Qty</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" readonly value="<?= ($po_items['item_discount_amount'])?$po_items['item_discount_amount']:''?>"  name="discount_amount" onkeydown="calculatePOItemEvent(event,this)">
                                 </div>
                              </td>
                              <td rowspan="2">
                                 <div class="form-group">
                                    <select class="form-control custom-select select2"  name="tax_id" style="width:100%" onchange="add_value(this);">
                                       <option>Select Gst</option>
                                       <?php 
                                          // $defult_tax_rate=0;
                                          foreach ($master_tax_list as $key => $value) {
                                              if($key==0){
                                                  $defult_tax_rate=$value['tax_rate'];
                                              }
                                                $selected='';
                                                   if($po_items['tax_id']==$value['id']){
                                                      $selected="selected";
                                                   }
                                          ?>                                                              
                                       <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" name="tax_rate" value="<?= ($po_items['tax_rate'])?$po_items['tax_rate']:''?>" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" onchange="calculatePOItem( this);">
                                       <option>value</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal allow_decimal" readonly name="tax_value" value="<?= ($po_items['tax_value'])?$po_items['tax_value']:''?>" readonly onkeydown="calculatePOItemEvent(event,this)">
                                 </div>
                                 <hr class="m-t-40 m-b-40">
                                 <div class="form-group">
                                    <label>Additional</label>
                                    <select class="form-control custom-select select2"  name="additional_tax_id" style="width:100%" onchange="add_value_additional(this);">
                                       <option>Select Additional GST</option>
                                       <?php 
                                          // $defult_tax_rate=0;
                                          foreach ($master_tax_list as $key => $value) {
                                                   $selected='';
                                                   if($po_items['additional_tax_id']==$value['id']){
                                                      $selected="selected";
                                                   }
                                          ?>                                                              
                                       <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?=  $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" name="additional_tax_rate" value="<?= ($po_items['additional_tax_rate'])?$po_items['additional_tax_rate']:''?>" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" onchange="calculatePOItem( this);">
                                       <option>value</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="additional_tax_value" readonly value="<?= ($po_items['additional_tax_value'])?$po_items['additional_tax_value']:''?>" onkeydown="calculatePOItemEvent(event,this)">
                                 </div>
                              </td>
                              <td rowspan="2">
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="item_final_amount" readonly value="<?= ($po_items['item_amount'])?$po_items['item_amount']:''?>">
                                    <button data-repeater-delete type="button" class="btn btn-sm btn-danger float-left delete_type_item_btn" style="margin-bottom:8px;" value="delete" data-type="2" data-po_id="<?= $po_items['po_id']; ?>" data-po_item_id="<?= $po_items['po_item_id']; ?>">
                                    <i class="fas fa-trash-alt"  data-type="2" data-po_id="<?= $po_items['po_id']; ?>" data-po_item_id="<?= $po_items['po_item_id']; ?>"></i>
                                    </button>
                                 </div>
                              </td>
                           </tr>
                           <tr class="bg-light">
                              <td>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Description </label>
                                    <div class="col-md-10">
                                       <textarea class="form-control" placeholder="Enter your text here..." name="item_description"><?= ($po_items['item_description'])?$po_items['item_description']:''?></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Other Description </label>
                                    <div class="col-md-10">
                                       <textarea class="form-control" placeholder="Enter your text here..." colspan="5" name="other_description"><?= ($po_items['other_description'])?$po_items['other_description']:''?></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Technical Description </label>
                                    <div class="col-md-10">
                                       <textarea class="form-control" placeholder="Enter your text here..." name="technical_description"><?= ($po_items['technical_description'])?$po_items['technical_description']:''?></textarea>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                        <?php
                           } //foreach po item end
                           ?>
                        <?php
                            else:
                        ?>
                        <tbody  data-repeater-item  class="repeater-item main_tbl_reapter">
                           <tr name="reapter_item_row" class="repeater-item1">
                              <input type="hidden" name="delete_type" value="1">
                              <td>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Item Group  </label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 item_group_select2" required name="item_group_id" style="width:100%" onchange="getItemList(this)">
                                          <option></option>
                                       </select>
                                    </div>
                                     
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                       <select class="form-control custom-select select2 po_items_select" required name="items_id"style="width:100%" onchange="getItemUnits(this)">
                                          <option></option>
                                       </select>
                                       <div class="col-md-12" style="text-align:right">
                                       <a class="mytooltip" href="javascript:void(0)"><i class="btn btn-sm  fas fa-info-circle" style="margin-top: 2px;font-size: 20px;" aria-hidden="true"></i>
                                          <span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2" style="padding: 10px;">
                                             <div class="">
                                                <table class="table-bordered table-hover no-wrap" width="100%">
                                                    <tbody style="font-size:11px;color: white;">
                                                        <tr>
                                                            <td style="color:white;">Sr.No</td>
                                                            <td style="color:white;">Po Number</td>
                                                             <td style="color:white;">Vendor Name</td> 
                                                            <td style="color:white;">Unit</td>
                                                            <td style="color:white;">Rate</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody id="tbl_item_rate_update_html" name="tbl_item_rate_update_html"></tbody>

                                                </table>
                                             </div>
                                       </span></span></span></a>
                                       <a href="javascript:void(0)" name="refreshButton" class="refresh-button" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                                    </div>
                                 </div>
                                 <div class="form-group m-t-40">
                                    <label class="control-label text-left col-md-12">HSC Code</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control" name="item_hsc_code" readonly>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">STOCK QTY</label>
                                    <div class="col-md-10">
                                       <input type="text" class="form-control numberonly" name="item_stock_qty" readonly>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <input type="text" class="form-control" placeholder="Size/ Part-No/ Grade " name="item_size">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <input type="text" class="form-control po_item_cal numberonly" required name="item_unit" value="0" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" name="item_unit_id"  required onchange="getItemUnitsStock(this)" >
                                    </select>
                                 </div>
                                 <table class="table table-bordered">
                                    <tr>
                                       <td colspan="3"><b>Dispatch Schedule Qty.</b></td>
                                    </tr>
                                    <tr>
                                       <td width="20%" >1st Lot</td>
                                       <td width="27%"><input type="text" class="form-control numberonly" id="dispatch_1_lot_qty" name="dispatch_1_lot_qty"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control " placeholder="mm/dd/yyyy" id="dispatch_1_lot_date" name="dispatch_1_lot_date">
                                            
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="" >2nd Lot</td>
                                       <td width=""><input type="text" class="form-control numberonly" id="dispatch_2_lot_qty" name="dispatch_2_lot_qty"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control " placeholder="mm/dd/yyyy" id="dispatch_2_lot_date" name="dispatch_2_lot_date">
                                             
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="" >3rd Lot</td>
                                       <td width=""><input type="text" class="form-control numberonly" id="dispatch_3_lot_qty" name="dispatch_3_lot_qty"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control" placeholder="mm/dd/yyyy" id="dispatch_3_lot_date" name="dispatch_3_lot_date">
                                             
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td width="" >4th Lot</td>
                                       <td width=""><input type="text" class="form-control numberonly" id="dispatch_4_lot_qty" name="dispatch_4_lot_qty"></td>
                                       <td>
                                          <div class="input-group">
                                             <input type="date" class="form-control " placeholder="mm/dd/yyyy" id="dispatch_4_lot_date" name="dispatch_4_lot_date">
                                             
                                          </div>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                              <td>
                                 <div class="form-group ">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_weight" placeholder="Weight" value="0" onkeydown="calculatePOItemEvent(event,this)">
                                    <!--   <select class="form-control custom-select select2" style="width:100%">
                                       <option>All</option>
                                       </select>
                                       -->
                                 </div>
                              </td>
                              <td>
                                 <input type="text" class="form-control po_item_cal allow_decimal" placeholder="item Rate" name="item_unit_rate" value="0" onkeydown="calculatePOItemEvent(event,this)">
                                 <select class="form-control custom-select select2" style="width:100%" name="item_rate_type"  onchange="calculatePOItem( this);">
                                    <option value="1" selected>Qty</option>
                                    <option value="2">Weight</option>
                                 </select>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_rate" value="0" readonly>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal allow_decimal" placeholder="Disc. Rate %/Amount " value="0"  name="discount_percent" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" name="discount_type" onchange="calculatePOItem( this);">
                                       <option value="1" selected>@ Val</option>
                                       <option value="2">@ Qty</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal allow_decimal" value="0" readonly  name="discount_amount" onkeydown="calculatePOItemEvent(event,this)">
                                 </div>
                              </td>
                              <td rowspan="2">
                                 <div class="form-group">
                                    <select class="form-control custom-select select2"  name="tax_id" style="width:100%" onchange="add_value(this);">
                                       <option>Select Gst</option>
                                       <?php 
                                          // $defult_tax_rate=0;
                                          foreach ($master_tax_list as $key => $value) {
                                              if($key==0){
                                                  $defult_tax_rate=$value['tax_rate'];
                                              }
                                          ?>                                                              
                                       <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>"><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" name="tax_rate" value="0s" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" onchange="calculatePOItem( this);">
                                       <option>value</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal allow_decimal"  readonly name="tax_value" value="0" readonly onkeydown="calculatePOItemEvent(event,this)">
                                 </div>
                                 <hr class="m-t-40 m-b-40">
                                 <div class="form-group">
                                    <label>Additional</label>
                                    <select class="form-control custom-select select2"  name="additional_tax_id" style="width:100%" onchange="add_value_additional(this);">
                                       <option>Select Additional GST</option>
                                       <?php 
                                          // $defult_tax_rate=0;
                                          foreach ($master_tax_list as $key => $value) {
                                                if($key==0){
                                              $defult_tax_rate=$value['tax_rate'];
                                          }
                                          ?>                                                              
                                       <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>"><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" name="additional_tax_rate" value="0" onkeydown="calculatePOItemEvent(event,this)">
                                    <select class="form-control custom-select select2" style="width:100%" onchange="calculatePOItem( this);">
                                       <option>value</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="additional_tax_value" value="0" onkeydown="calculatePOItemEvent(event,this)" readonly>
                                 </div>
                              </td>
                              <td rowspan="2">
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="item_final_amount" readonly >
                                    <button data-repeater-delete type="button" class="btn btn-sm btn-danger float-left" style="margin-bottom:8px;" value="delete" data-type="1">
                                    <i class="fas fa-trash-alt"  data-type="1"></i>
                                    </button>
                                 </div>
                              </td>
                           </tr>
                           <tr >
                              <td>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Description </label>
                                    <div class="col-md-10">
                                       <textarea class="form-control" placeholder="Enter your text here..." name="item_description"></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Other Description </label>
                                    <div class="col-md-10">
                                       <textarea class="form-control" placeholder="Enter your text here..." colspan="5" name="other_description"></textarea>
                                    </div>
                                 </div>
                              </td>
                              <td colspan="3">
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Technical Description </label>
                                    <div class="col-md-10">
                                       <textarea class="form-control" placeholder="Enter your text here..." name="technical_description"></textarea>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                        <?php
                           endif; //update item id
                           ?>
                        <tfoot class="bg-light">
                           <tr>
                              <th >Total</th>
                              <th > </th>
                              <th>
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Total QTy" id="total_qty" name="total_qty" readonly  value="<?= isset($po_info['item_total_qty'])?$po_info['item_total_qty']:''?>">
                                 </div>
                              </th>
                              <th></th>
                              <th></th>
                              <th >
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Total item amount" id="total_item_rate" name="total_item_rate" value="<?= isset($po_info['item_total_sub_amount'])?$po_info['item_total_sub_amount']:''?>" readonly>
                                 </div>
                              </th>
                              <th >
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Total Discount amount"id="total_discount_amount" value="<?= isset($po_info['item_total_discount'])?$po_info['item_total_discount']:''?>" name="total_discount_amount" readonly>
                                 </div>
                              </th>
                              <th >
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Total GSt Amount" id="total_tax_rate" value="<?= isset($po_info['item_total_gst'])?$po_info['item_total_gst']:''?>"name="total_tax_rate" readonly>
                                 </div>
                                 <div class="form-group">
                                    <label>Add</label>
                                    <input type="text" class="form-control"  placeholder="Total GSt Additional Amount" id="total_additional_tax_rate" value="<?= isset($po_info['item_total_additional_gst'])?$po_info['item_total_additional_gst']:''?>" name="total_additional_tax_rate" readonly>
                                 </div>
                              </th>
                              <th>
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Final Amount Total"id="final_amount_total"  value="<?= isset($po_info['item_total_amount'])?$po_info['item_total_amount']:''?>" name="final_amount_total" readonly>
                                 </div>
                              </th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="box-title">Terms & Condition </h3>
                     <hr class="m-t-0 m-b-10">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-3">Remark </label>
                              <div class="col-md-9">
                                 <textarea class="form-control" name="remark" id="remark" value="" placeholder="Enter your text here..."><?= (isset($po_info['remark']))?$po_info['remark']:''; ?></textarea>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-3">Line in bottom </label>
                              <div class="col-md-9">
                                 <input type="text" class="form-control" name="line_in_bottom" id="line_in_bottom" value="<?= (isset($po_info['line_in_bottom']))?$po_info['line_in_bottom']:''; ?>">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-3">Jurisdiction </label>
                              <div class="col-md-9">
                                 <input type="text" class="form-control" name="jurisdiction" id="jurisdiction" value="<?= (isset($po_info['jurisdiction']))?$po_info['jurisdiction']:''; ?>">
                              </div>
                           </div>
                        </div>
                       
                         
                        <div class="col-md-9 bg-diffrent">
                           <div class="form-group row">
                              <label class="control-label text-right col-md-3">Attach a file </label>
                              <div class="col-md-9" style="padding:0px;">
                                   <input type="file" id="fileInput" name="file_name[]" style="display: none;" multiple>
                                    <input type="hidden" id="removedFiles" name="removedFiles" />
                                    <!-- Dropzone preview area -->
                                     <div id="dropzone" class="dropzone custom-dropzone"></div>
                                    <div class="dropzone-previews"></div>
                                
                                 </div>
                              <!--  <div class="col-md-9" style="padding:0px;">
                                 <div class="file-upload-contain">
                                    <input id="multiplefileupload" type="file" class="form-control" name="file_name[]" multiple />
                                 </div>
                                 </div> -->
                           </div>
                        </div>
                     </div>
                                <div class="row">
                        <div class="col-md-12">
                           <div class="form-group row">

                              <label class="control-label text-right col-md-3">
                                 Terms & Condition <br>
                                  <button type="button" class="btn btn-info btn-theme term_master_modal " data-toggle="modal" data-target=".bd-example-modal-lg">Terms From Master</button>
                              </label> 
                              <?php 
                                 if(isset($po_info['terms_and_condition'])){?>
                                    <div class="col-md-9">
                                       <textarea class="form-control" name="terms_and_condition" id="terms_and_condition"  placeholder="Enter your text here..." col="6" style="height:200px !important;"><?= (isset($po_info['terms_and_condition']))?$po_info['terms_and_condition']:''; ?></textarea>
                                    </div>
                              <?php }else{?>
                                    <div class="col-md-9">
                                       <textarea class="form-control" name="terms_and_condition" id="terms_and_condition"  placeholder="Enter your text here..." col="6" style="height:200px !important;"><?php foreach ($term_and_conditions_data as $key => $tac) { ?><b><p><?= (isset($tac['title']))?$tac['title']:''; ?></b>:<?= (isset($tac['particulars']))?$tac['particulars']:''; ?> <?php } ?></p></textarea>
                                    </div>
                              <?php } ?> 
                           </div>

                        </div>
                 
                     
            </div>
            <!-- <div id="termconditionsModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
            <div class="modal-content">
            <div id="_banner"></div>
            </div>termconditionsModal
            </div>
            </div> -->
            </div>
            <div class="col-md-6"><h3 class="box-title">Tax Details</h3>
            <hr class="m-t-0 m-b-10">
            <div class="table-responsive" >
            <table class="table table-bordered">
            <tr>
            <td width="30%">[On Item Value]</td>
            <td width="20%" class="text-right">Discount</td>
            <td width="10%" class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="final_discount_percent" id="final_discount_percent" value="<?= (isset($po_info['discount_percent']))?$po_info['discount_percent']:'0'; ?>">
            </div>
            </td>
            <td width="2%">%</td>
            <td width="15%" class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="final_discount_amount" id="final_discount_amount" value="<?= (isset($po_info['discount_amount']))?$po_info['discount_amount']:'0'; ?>" redonly>
            </div>
            </td>
            </tr>
            <tr>
            <td >[On Bal]</td>
            <td class="text-right">GST/VAT</td>
            <td class=""> </td>
            <td></td>
            <td class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" readonly id="final_gst" name="final_gst" value="<?= (isset($po_info['gst_amount']))?$po_info['gst_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            <tr>
            <td ></td>
            <td class="text-right">LD Clause 
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final" name="ld_clause_text" id="ld_clause_text" placeholder="LD Caluse Text " value="<?= (isset($po_info['ld_clause_text']))?$po_info['ld_clause_text']:''; ?>">
            </div>
            </td>
            <td class="">
            </td>
            <td></td>
            <td class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final "  name="ld_charges" id="ld_charges" value="<?= (isset($po_info['ld_charges']))?$po_info['ld_charges']:'0'; ?>">
            </div>
            </td>
            </tr>
            <tr>
            <td rowspan="3">
            <div class="form-group row">
            <label class="control-label text-left col-md-6">  Freight (F.O.R.) </label>
            </div>
            </td>
            <td class="text-right" >
            <div class="form-group row">
            <div class="col-md-6">
            <div class="custom-control custom-radio">
            <input type="radio" id="customRadio1" name="freight" class="custom-control-input" onchange="calculateTotal()" value="1" <?= (isset($po_info['freight_type']) && $po_info['freight_type']==1)?"checked":''; ?>>
            <label class="custom-control-label" for="customRadio1">F.O.R</label>
            </div>
            </div>
            <div class="col-md-6">
            <div class="custom-control custom-radio">
            <input type="radio" id="customRadio2" name="freight" class="custom-control-input" onchange="calculateTotal()" value="2" <?= (isset($po_info['freight_type'])&& $po_info['freight_type']==2)?"checked":''; ?>>
            <label class="custom-control-label" for="customRadio2">TO PAY</label>
            </div>
            </div>
            </div>
             <div class="form-group">
            <input type="text" class="form-control po_item_cal_final" name="freight_text" id="freight_text" placeholder="Freight Text " value="<?= (isset($po_info['freight_text']))?$po_info['freight_text']:''; ?>">
            </div>
            </td>
            <td class="">
                
            </td>
            <td></td>
            <td class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="freight_amount" id="freight_amount" value="<?= (isset($po_info['freight_amount']))?$po_info['freight_amount']:'0'; ?>" >
            </div>
            </td>
            </tr>
            <tr>
            <td>    
            <label>VAT/GST on Freight</label>
            <select class="form-control custom-select select2 po_item_cal_final" id="freight_tax_id"  name="freight_tax_id" style="width:100%" onchange="add_value_servicetax(1,this);">
            <option>Select Tax Value</option>
            <?php 
               foreach ($master_tax_list as $key => $value) {
                        $selected='';
                        if($po_info['freight_tax_id']==$value['id']){
                           $selected="selected";
                        }
               ?>                                                              
            <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
            <?php
               }
               ?>
            </select>
            </td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final" name="freight_tax_rate" id="freight_tax_rate" readonly value="<?= (isset($po_info['freight_tax_rate']))?$po_info['freight_tax_rate']:'0'; ?>">
            </div>
            </td>
            <td>  <label></label>%</td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final allow_decimal" readonly name="freight_tax_amount" id="freight_tax_amount" value="<?= (isset($po_info['freight_tax_amount']))?$po_info['freight_tax_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            <tr>
            <td>    
            <label>Additional VAT on Freight</label>
            <select class="form-control custom-select select2" id="freight_additional_tax_id" name="freight_additional_tax_id" style="width:100%" onchange="add_value_servicetax(2,this);">
            <option>Select Tax Value</option>
            <?php 
               foreach ($master_tax_list as $key => $value) {
                   if($key==0){
                       $defult_tax_rate=$value['tax_rate'];
                   }
                   $selected='';
                        if($po_info['freight_additional_tax_id']==$value['id']){
                           $selected="selected";
                        }
               ?>                                                              
            <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
            <?php
               }
               ?>
            </select>
            </td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="freight_additional_tax_rate" readonly id="freight_additional_tax_rate" value="<?= (isset($po_info['freight_additional_tax_rate']))?$po_info['freight_additional_tax_rate']:'0'; ?>">
            </div>
            </td>
            <td>  <label></label>%</td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="freight_additional_tax_amount" readonly id="freight_additional_tax_amount" value="<?= (isset($po_info['freight_additional_tax_amount']))?$po_info['freight_additional_tax_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            <tr>
            <td width="30%" rowspan="2">If Any Other Add    </td>
            <td width="20%" class="text-right"> 
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final" name="new_tax_name" id="new_tax_name" placeholder="If Any Other Add Name " value="<?= (isset($po_info['new_tax_name']))?$po_info['new_tax_name']:''; ?>">
            </div></td>
            <td width="10%" class="">
            </td>
            <td width="2%"></td>
            <td width="15%" class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final" name="n_tax_amount" id="n_tax_amount" value="<?= (isset($po_info['new_tax_amount']))?$po_info['new_tax_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            <td>    
            <label>VAT/GST on If Any Other </label>
            <select class="form-control custom-select select2"  id="new_tax_id" name="new_tax_id" style="width:100%" onchange="add_value_servicetax(3,this);">
            <option>Select Tax Value</option>
            <?php 
               foreach ($master_tax_list as $key => $value) {
                        $selected='';
                        if($po_info['new_tax_id']==$value['id']){
                           $selected="selected";
                        }
               ?>                                                              
            <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
            <?php
               }
               ?>
            </select>
            </td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final" name="new_tax_rate" id="new_tax_rate" readonly value="<?= (isset($po_info['new_tax_rate']))?$po_info['new_tax_rate']:'0'; ?>">
            </div>
            </td>
            <td>  <label></label>%</td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final" name="new_tax_amount" readonly id="new_tax_amount" value="<?= (isset($po_info['new_tax_amount']))?$po_info['new_tax_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            <tr>
            <td width="30%" rowspan="2">Service Charges  
            </td>
            <td width="10%" class="" colspan="2">
            <div class="form-group row">
            <div class="col-md-6">
            <div class="custom-control custom-radio">
            <input type="radio" id="customRadio3" name="service_charge_type" class="custom-control-input" value="1" checked onchange="calculateTotal()">
            <label class="custom-control-label" for="customRadio3">on service charge </label>
            </div>
            </div>
            <div class="col-md-6">
            <div class="custom-control custom-radio">
            <input type="radio" id="customRadio4" name="service_charge_type" class="custom-control-input" value="2" onchange="calculateTotal()">
            <label class="custom-control-label" for="customRadio4">on item value</label>
            </div>
            </div>
            </div>   
            </td>
            <td width="2%"></td>
            <td width="15%" class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="service_charge_amount" id="service_charge_amount" value="<?= (isset($po_info['service_charge_amount']))?$po_info['service_charge_amount']:'0'; ?>">
            </div>
            </td>
            </tr>   
            <td>    
            <label>Service Tax </label>
            <select class="form-control custom-select select2" id="service_tax_id" name="service_tax_id" style="width:100%" onchange="add_value_servicetax(4,this);">
            <option>Select Tax Value</option>
            <?php 
               foreach ($master_tax_list as $key => $value) {
                    $selected='';
                        if($po_info['service_tax_id']==$value['id']){
                           $selected="selected";
                        }
               ?>                                                              
            <option value="<?= $value['id'] ?>" data-tax_rate="<?= $value['tax_rate'] ?>" <?= $selected; ?>><?= $value['short_name']."(".$value['tax_name'].")"; ?></option>
            <?php
               }
               ?>
            </select>
            </td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="service_tax_rate" id="service_tax_rate" value="<?= (isset($po_info['service_tax_rate']))?$po_info['service_tax_rate']:'0'; ?>">
            </div>
            </td>
            <td>  <label></label>%</td>
            <td class="">
            <div class="form-group">
            <label></label>
            <input type="text" class="form-control po_item_cal_final allow_decimal" name="service_tax_amount" id="service_tax_amount" value="<?= (isset($po_info['service_tax_amount']))?$po_info['service_tax_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            <tr>
            <td ></td>
            <td class="text-right">Round Off</td>
            <td class=""></td>
            <td></td>
            <td class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" id="round_off" name="round_off" value="<?= (isset($po_info['round_off']))?$po_info['round_off']:'0'; ?>" readonly>
            </div>
            </td>
            </tr>
            <tr>
            <td ></td>
            <td class="text-right">Total PO Value </td>
            <td class=""></td>
            <td></td>
            <td class="">
            <div class="form-group">
            <input type="text" class="form-control po_item_cal_final allow_decimal" id="po_final_amount" name="po_final_amount" readonly value="<?= (isset($po_info['po_final_amount']))?$po_info['po_final_amount']:'0'; ?>">
            </div>
            </td>
            </tr>
            </table>
            </div></div>
            </div>
            <hr>
            <div class="form-actions">
               <div class="row">
                  <div class="col-md-6"> </div>
                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                           <button type="button" class="btn btn-success btn-theme"  onclick="submitPO()" id="submit_po">Submit</button>
                           <button type="button" class="btn btn-inverse btn-theme-sm">Cancel</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            </form>
         </div>

         <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="termsConditionHtml">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">

                           <div class="modal-body" style="text-align: left;">
                           <h4>Terms & Condition</h4>
                           <hr>
                           <!--<a href="<?= base_url('admin/Po/add_termconditions');?>" class="btn btn-info btn-theme mb-3" ><i class="fa fa-plus-circle"></i> Create New Term&Conditions</a>-->
                            <div class="form-group col-md-12">
                          
                           
                           <form action="" id="addtermconditions" method="post" enctype="multipart/form-data">
                              <div class="row">
                                  <div class="col-md-4">
                                 <label >Title</label>
                                 <div>
                                 <input  type="text" required  class="form-control" id="title" name="title" value="">
                                
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label >New Add</label>
                                 <div>
                                 <input  type="text" required  class="form-control" id="particulars" name="particulars" value="">
                                
                                 </div>
                              </div>
                              <div class="col-md-1 m-t-15">
                                
                                 <div>
                                 <input type="button" class="btn btn-success btn-theme" onclick="saveTermsCondition()" value="Add" style="margin-top: 10px;" >
                                 </div>
                              </div>
                           </div>
                           </form>
                          
                          
                           </div> 
                           <div class="col-12">
                                    <form>
                                  <div class="table-responsive">
                                    <table id="myTable" class="tablesaw table-bordered table-hover table no-wrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th>X</th>
                                                <th  width="10%">Sr.No</th>
                                                <th width="25%">Title</th>
                                                <th class="text-nowrap" >Particulars</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_po_terms_condition_html"></tbody>

                                    </table>
                                    </div>
                                     <div class="modal-footer">
                                    <button type="button" class="btn btn-inverse btn-theme-sm" data-dismiss="modal">Close</button> 
                                    <button type="button" class="btn btn-success btn-theme"  onclick="updateData()" style="background-color: #48bc97;color:white;"  >Add</button>
                                    </div>
                                  </form>
                                    </div>




                                    </div>
                                   
                           </div>
                           </div>
                           </div>
      </div>
   </div>
</div>
<?php  init_footer(); ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<!-- Plugin JavaScript -->
<script src="<?= base_url(); ?>/assets/node_modules/moment/moment.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/node_modules/ckeditor/config.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?= base_url(); ?>/assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>/assets/js/page-js/po-form-repeater.int.js?v=1.0.6"></script>
<script src="<?= base_url(); ?>/assets/js/page-js/po_item_calc.js?v=1.0.3"></script>
<script src="<?= base_url(); ?>/assets/js/page-js/po.js?v=1.0.1"></script>
<script src="<?= base_url(); ?>assets/node_modules/Auto-TabIndex-master/autotabindex.js"></script>
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>

<script>
//   $('.daterange').daterangepicker();
    $('.daterange').daterangepicker({
    locale: {
        format: 'DD/MM/YYYY'
    },
    startDate: moment(),
    endDate: moment()
});

    $('.mydatepicker').datepicker({
    defaultDate: "today",
      format: 'dd/mm/yyyy',
   });
    $('body').autotabindex(
    {
      list: '#po_date,#po_valid_from_to_date,#vendor_id,#cost_project_address,#delivery_days,#delivery_days_for_alerts,#payment_days,#payment_days_for_alerts,#guarantee,#reference,#prices,#billing_site_id,#delivery_site_id,#delivery_party_id,#address1,#address2,#address3,#final_discount_percent,#final_discount_amount,#final_gst,#ld_charges,#freight_amount,#freight_tax_id,#freight_tax_rate,#freight_tax_amount,#freight_additional_tax_rate,#freight_additional_tax_rate,#freight_additional_tax_amount,#new_tax_name,n_tax_amount,#new_tax_id,#service_charge_amount,#service_tax_id,#service_tax_rate,#service_tax_amount,#round_off,#po_final_amount'
    });
    
     CKEDITOR.replace( 'terms_and_condition',{
     height: '250px'   ,
     uiColor: '#f8f9fa',    
     readOnly: true  
   });

</script>



<script>
function updateData() {
    var checkboxes = document.querySelectorAll('.custom-checkbox-checked');
    var selectedValues = [];
    var html_content = '';
    var html_content1 = '';
    var hasListItems = false;

    Swal.fire({
        title: 'Are you sure to add terms and conditions?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) { // User clicked "Yes"
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    var title = checkbox.dataset.title;
                    var particulars = checkbox.dataset.particulars;

                    if (title.length === 0) {
                        html_content += "<li>" + particulars + "</li>";
                    } else {
                        hasListItems = true;
                        html_content1 += "<p><b>" + title + "</b>:" + particulars + "</p>";
                    }
                }
            });

            html = '<ul>' + html_content + '</ul>' + " " + html_content1;
            CKEDITOR.instances.terms_and_condition.setData(html);
            $('#myModal').modal('hide'); 
        } else {
           
            console.log("User clicked Cancel. CKEditor not updated.");
           
        }
    });
}

function isEmpty(value) {
    return value === undefined || value === null || value === '' || isNaN(value);
}

function getAddressSite(element){
    //   var site_address = $('#site_address').val();
        address=$(element).select2('data')[0].address;
      //  console.log("address"+address);
         $('#address1').val(address);
 
}


</script>
<script>
  var removedFiles = []; // Array to store removed files
 Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "upload.php",
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 10,
            maxFilesize: 5,
            acceptedFiles: '.jpg, .jpeg, .png, .gif, .pdf, .doc, .txt, .csv, .xlsx',
            dictDefaultMessage: 'Drop files here or click to upload',
            init: function() {
                var submitButton = document.getElementById("submit_po");
                var fileInput = document.getElementById("fileInput");
                var removedFilesInput = document.getElementById("removedFiles");
                
                var myDropzone = this;

                // PHP files array
               var files = <?= isset($attachement) && !empty($attachement) ? json_encode($attachement) : '[]'; ?>;


                if (files.length > 0) {
                        files.forEach(function(file) {
                            var mockFile = { name: file.name, size: file.size, id: file.id };
                    
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, file.url);
                            myDropzone.emit("complete", mockFile);
                            myDropzone.files.push(mockFile);
                        });
                    }

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
                    
                     removedFilesInput.value = JSON.stringify(removedFiles);

                    //document.getElementById("upload-form").submit();
                });

                this.on("addedfile", function(file) {
                    console.log("Added file: " + file.name);
                });

                this.on("removedfile", function(file) {
                    console.log("Removed file: " + file.name);
                    removedFiles.push(file.id);
                });
            }
        });
</script>
