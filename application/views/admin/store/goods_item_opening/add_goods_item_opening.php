<?php init_header(); ?>

 <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>/assets/css/multiple_image.css" rel="stylesheet" type="text/css" />
<style>
  
   .error{
   color:red;
   }
   .sd{
   display: none;
   }
   hr {
   margin-top: 0.5rem;
   }
   .text_area{
   margin-top: -4px !important;
   line-height: 2 !important;
   }
   .margin-bottom-7{
   margin-bottom:10px !important;
   }
   .select2-container{
   margin-bottom: 7px !important;
   }
   .upper_case
   {
   text-transform: uppercase;
   }
   
   .lables{
   font-weight: bold;
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

   .file-drop-zone-title {
       padding: 15px 10px !important;
   }
   .main_tbl_reapter{
       background:#eff1f3
   }

</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">

<div class="container-fluid">

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <!-- <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4> -->
            <form class="repeater" method="post" action="" id="frm_issue" enctype="multipart/form-data"class="form-horizontal" autocomplete="off">
               <div class="row">
                    <input type="hidden" name="id" id="id" value="<?= isset($opening_data['id'])?$opening_data['id']:'' ?>">
                    <input type="hidden" id="locationId" value="<?= userId('site_id'); ?>">
                  <div class="col-md-12 mb-3">
                     <div class="row">
                        <div class="col-md-12">
                           <span class="text-color">
                              <h6><b>Goods Item Opening</b></h6>
                           </span>
                           <hr>
                        </div>
                    
                     </div>
                    <div class="row m-t-10">
                       
                      <div class="col-md-6" >
                     
                           <div class="form-group row">
                              <label class="control-label col-md-2"><b>Location</b></label>
                              <div class="col-md-6">
                                 <select class="form-control select2 " name="location_id" id="location_id" <?= isset($opening_data['id'])?"disabled":"" ?> >
                                      <?php
                                        if(isset($opening_data['location_id'])){
                                            echo "<option value='".$opening_data['location_id']."'>".$opening_data['site_name']."</option>";
                                        }else{
                                    ?>
                                      <option value=""></option>
                                    <?php
                                        }
                                      ?>
                                     
                                       
                                 </select>
                              </div>
                           </div>
                   
                        </div>
                        <div class="col-md-6" align="right"> 
                        <?php
                          if(! isset($opening_data['id']) && empty($opening_data['id'])){
                        ?>
                          <a href="javascript:void(0)" data-repeater-create ><button type="button" class="btn btn-success btn-theme">Add</button></a>
                          <?php
                          }
                          ?>
                        </div>
                     </div>
                     <hr>
                     <div class="table-responsive repeater" id="repeater_po_item">
                   
                     <table class="table table-bordered" data-repeater-list="items" id="po_items_tables">
                        <thead>
                           <tr>
                              <th width="10%">Item Group/ Item Name *</th>
                              <th width="30%">Stock Type & Party</th>
                              <th width="5%">Opening Qty</th>
                              <th width="5%">Opening Weight</th>
                              <th width="5%">Unit Rate</th>
                                 <th width="5%">Disc. Rate %/Amount </th>
                              <th width="5%">Item Amt</th>
                            </tr>
                        </thead>
                           
                             <?php
                           if(isset($opening_data_items)&& !empty($opening_data_items)){
                                foreach ($opening_data_items as $key1 => $items) {
                            ?>
                             <tbody  data-repeater-item  class="repeater-item main_tbl_reapter">
                             <tr>
                                 <td colspan="7"><hr></td>
                             </tr>
                             <tr name="reapter_item_row" class="repeater-item1">
                             
                              <td>

                                
                                  <input type="hidden" class="form-control" name="op_item_id" value="<?= isset($items['id'])?$items['id']:'' ?>">
                                  <input type="hidden" class="form-control" name="old_opening_qty" value="<?= isset($items['opening_qty'])?$items['opening_qty']:0 ?>">
                                
                                  <input type="hidden" class="form-control" name="item_group_id" value="<?= isset($items['item_group_id'])?$items['item_group_id']:0 ?>">
                             
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Item Group   </label>
                                    <div class="col-md-12">
                                             <select class="form-control custom-select select2 " style="width:100%" name="item_group_id"  required onchange="getItemUnitsStock(this)" disabled >
                                                <option value="<?= isset($items['item_group_id'])?$items['item_group_id']:'' ?>"><?= isset($items['item_group_name'])?$items['item_group_name']:'' ?></option>
                                            </select>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label class="control-label text-left col-md-12">Items</label>
                                    <div class="col-md-12">
                                      
                                             <select class="form-control custom-select select2 po_items_select" style="width:100%" name="items_id"  required onchange="getItemUnitsStock(this)" disabled >
                                                <option value="<?= isset($items['item_id'])?$items['item_id']:'' ?>"><?= isset($items['item_name'])?$items['item_name']:'' ?></option>
                                            </select>
                                    </div>
                                 </div>
                             
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Purchase Date</b></label>
                                       </div>
                                       <div class="col-md-4 mt-1">
                                          <input class="form-control " type="date" placeholder="" name="purchase_date"    value="<?= isset($items['pur_date'])?$items['pur_date']:'' ?>" disabled>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Batch/Lots Detail/Pur. Bill/Grn</b></label>
                                       </div>
                                       <div class="col-md-4 mt-1">
                                          <input class="form-control " type="text" name="batch" required  value="<?= isset($items['batch_no'])?$items['batch_no']:'' ?>" disabled>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Expired Date</b></label>
                                       </div>
                                       <div class="col-md-4 mt-1">
                                          <input class="form-control " type="date" placeholder="" data-rule-futureDate="true" name="expired_date"  disabled value="<?= isset($items['expired_date'])?$items['expired_date']:'' ?>"  required>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Opening Stock Type:</b></label>
                                       </div>
                                       <!--  <div class="row"> -->
                                       <div class="col-md-3 mt-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio1" name="opening_stock_type" class="custom-control-input" value="1" <?= (isset($items['opening_stock_type']) && $items['opening_stock_type']==1)?'checked':'' ?>>
                                             <label class="custom-control-label radio-inline" for="customRadio1">Party Stock</label>
                                          </div>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio2" name="opening_stock_type" class="custom-control-input" value="2" <?= (isset($items['opening_stock_type']) && $items['opening_stock_type']==2)?'checked':'' ?>>
                                             <label class="custom-control-label radio-inline" for="customRadio2">Self Stock</label>
                                          </div>
                                       </div>
                                       <!-- </div> -->
                                       <div class="form-group col-md-12 m-t-10">
                                          <div class="form-group row">
                                             <div class="col-md-5 mt-1">
                                                <label style="margin-right:10px;"><b>At Party:</b></label>
                                                <input type="checkbox" name="at_party" value="1" <?= (isset($items['at_party']) && $items['at_party']==2)?'checked':'' ?>>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <input type="text" class="form-control po_item_cal " required name="item_unit" value="<?= isset($items['opening_qty'])?$items['opening_qty']:'0' ?>" onkeydown="calculatePOItemEvent(event,this)" onblur="calculatePOItem(this)" data-rule-decimal="true">
                                    <select class="form-control custom-select select2" style="width:100%" name="item_unit_id"  required onchange="getItemUnitsStock(this)" disabled >
                                        <option value="<?= isset($items['opening_unit_id'])?$items['opening_unit_id']:'' ?>"><?= isset($items['unit_name'])?$items['unit_name']:'' ?></option>
                                    </select>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_weight" placeholder="Weight" value="<?= isset($items['opening_weight'])?$items['opening_weight']:'0' ?>" onkeydown="calculatePOItemEvent(event,this)"  onblur="calculatePOItem(this)">
                                    <!--   <select class="form-control custom-select select2" style="width:100%">
                                       <option>All</option>
                                       </select>
                                       -->
                                 </div>
                              </td>
                              <td>
                                 <input type="text" class="form-control po_item_cal allow_decimal" placeholder="item Rate" name="item_unit_rate" value="<?= isset($items['unit_rate'])?$items['unit_rate']:'0' ?>" onkeydown="calculatePOItemEvent(event,this)"  onblur="calculatePOItem(this)">
                                 <select class="form-control custom-select select2" style="width:100%" name="item_rate_type"  onchange="calculatePOItem( this);">
                                    <option value="1" <?= (isset($items['item_rate_type']) && $items['item_rate_type']==1)?'selected':'selected' ?>>Qty</option>
                                    <option value="2"<?= (isset($items['item_rate_type']) && $items['item_rate_type']==2)?'selected':'' ?>>Weight</option>
                                 </select>
                              </td>
                                <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal" placeholder="Disc. Rate %/Amount " value="<?= isset($items['discount_percent'])?$items['discount_percent']:'0' ?>"  name="discount_percent" onkeydown="calculatePOItemEvent(event,this)" onblur="calculatePOItem(this)">
                                    <select class="form-control custom-select select2" style="width:100%" name="discount_type" onchange="calculatePOItem( this);">
                                       <option value="1" <?= (isset($items['discount_type']) && $items['discount_type']==1)?'selected':'' ?>>@ Val</option>
                                       <option value="2" <?= (isset($items['discount_type']) && $items['discount_type']==2)?'selected':'' ?>>@ Qty</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" readonly value="<?= isset($items['discount_amount'])?$items['discount_amount']:'0' ?>"  name="discount_amount" onkeydown="calculatePOItemEvent(event,this)" onblur="calculatePOItem(this)">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_rate" value="<?= isset($items['item_amt'])?$items['item_amt']:'0' ?>" readonly >
                                 </div>
                              </td>
                           </tr>
                            </tbody>
                            <?php
                                }
                            }else{
                        ?>
                         <tbody  data-repeater-item  class="repeater-item main_tbl_reapter">
                             <tr>
                                 <td colspan="7"><hr></td>
                             </tr>
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
                                    
                                    </div>
                                 </div>
                               <div class="col-md-12">
                                            <a href="javascript:void(0)" name="refreshButton" class="refresh-button text-right" onclick="clearItems(this);"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    </div>
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Purchase Date</b></label>
                                       </div>
                                       <div class="col-md-4 mt-1">
                                          <input class="form-control " type="date" placeholder="" name="purchase_date"   >
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Batch/Lots Detail/Pur. Bill/Grn</b></label>
                                       </div>
                                       <div class="col-md-4 mt-1">
                                          <input class="form-control " type="text" name="batch" required >
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Expired Date</b></label>
                                       </div>
                                       <div class="col-md-4 mt-1">
                                          <input class="form-control " type="date" placeholder="" data-rule-futureDate="true" name="expired_date"   required>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                       <div class="col-md-4 mt-1">
                                          <label style="margin-right:10px;"><b>Opening Stock Type:</b></label>
                                       </div>
                                       <!--  <div class="row"> -->
                                       <div class="col-md-3 mt-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio1" name="opening_stock_type" class="custom-control-input" value="1">
                                             <label class="custom-control-label radio-inline" for="customRadio1">Party Stock</label>
                                          </div>
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio2" name="opening_stock_type" class="custom-control-input" value="2">
                                             <label class="custom-control-label radio-inline" for="customRadio2">Self Stock</label>
                                          </div>
                                       </div>
                                       <!-- </div> -->
                                       <div class="form-group col-md-12 m-t-10">
                                          <div class="form-group row">
                                             <div class="col-md-5 mt-1">
                                                <label style="margin-right:10px;"><b>At Party:</b></label>
                                                <input type="checkbox" name="at_party" value="1" >
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">                                                                     
                                    <input type="text" class="form-control po_item_cal " required name="item_unit" value="0" onkeydown="calculatePOItemEvent(event,this)" onblur="calculatePOItem(this)"  data-rule-decimal="true" >
                                    <select class="form-control custom-select select2" style="width:100%" name="item_unit_id"  required onchange="getItemUnitsStock(this)" >
                                    </select>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group ">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_weight" placeholder="Weight" value="0" onkeydown="calculatePOItemEvent(event,this)"  onblur="calculatePOItem(this)">
                                    <!--   <select class="form-control custom-select select2" style="width:100%">
                                       <option>All</option>
                                       </select>
                                       -->
                                 </div>
                              </td>
                              <td>
                                 <input type="text" class="form-control po_item_cal allow_decimal" placeholder="item Rate" name="item_unit_rate" value="0" onkeydown="calculatePOItemEvent(event,this)"  onblur="calculatePOItem(this)">
                                 <select class="form-control custom-select select2" style="width:100%" name="item_rate_type"  onchange="calculatePOItem( this);">
                                    <option value="1" selected>Qty</option>
                                    <option value="2">Weight</option>
                                 </select>
                              </td>
                                <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal" placeholder="Disc. Rate %/Amount " value=""  name="discount_percent" onkeydown="calculatePOItemEvent(event,this)" onblur="calculatePOItem(this)">
                                    <select class="form-control custom-select select2" style="width:100%" name="discount_type" onchange="calculatePOItem( this);">
                                       <option value="1">@ Val</option>
                                       <option value="2">@ Qty</option>
                                    </select>
                                    <input type="text" class="form-control po_item_cal" readonly value=""  name="discount_amount" onkeydown="calculatePOItemEvent(event,this)" onblur="calculatePOItem(this)">
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="text" class="form-control po_item_cal allow_decimal" name="item_rate" value="0" readonly >
                                 </div>
                              </td>
                           </tr>
                            </tbody>
                        <?php
                            }
                           ?>
                        <tfoot class="bg-light">
                           <tr>
                              <th >Total</th>
                              <th > </th>
                              <th>
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Total QTy" id="total_qty" name="total_qty" readonly  value="<?= isset($opening_data['total_qty'])?$opening_data['total_qty']:'' ?>">
                                 </div>
                              </th>
                              
                           </tr>
                        </tfoot>
                     </table>
                    </div>

                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label class="control-label col-md-3"><b>Remark</b></label>
                              <div class="col-md-6">
                                 <textarea class="form-control" name="remark" id="" rows="3"><?= isset($opening_data['remark'])?$opening_data['remark']:'' ?></textarea>
                              </div>
                           </div>
                        </div>



                       
                     </div>
                  </div>
                  <!--<input type="submit" id="btnsubmit"  value="Submit">-->
                    <button type="button" class="btn btn-success btn-theme float-right"style="margin-left: 94%;"onclick="submitIssue()">Submit</button>
                   
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/node_modules/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/Auto-TabIndex-master/autotabindex.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>
<script src="<?= base_url(); ?>/assets/js/page-js/store/opening_repeater.js?v=1.0.1"></script>
<script src="<?= base_url(); ?>/assets/js/page-js/store/goods_item_opening.js?v=1.0.4"></script>
<script src="<?= base_url(); ?>/assets/js/multiple_image.js"></script>
    <!-- <script src="../assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../assets/node_modules/daterangepicker/daterangepicker.js"></script> -->

<script>

   $(document).ready(function () {
     
      $('#frm_issue').validate();
        //   var validator = $(this[0].form).validate();
        
   });



    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true,
        dateFormat:"Y-m-d"
    });

   $(".allow_decimal").on("input", function(evt) {
               var self = $(this);
               self.val(self.val().replace(/[^0-9\.]/g, ''));
               if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
               {
                 evt.preventDefault();
               }
            });
</script>
