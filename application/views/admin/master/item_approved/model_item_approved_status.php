<style>
   label.error{
      display: none !important;
   }

   .select2-selection__rendered{
      margin-top: 1px;
   }

    .margin-bottom-7{
            margin-bottom: 7px !important;
        }
        .margin-bottom-20{
            margin-bottom: 20px !important;
        }
      
      label {
          margin-bottom: 0.2rem;
      }
      #mapping{
        margin-left: 20px;
      }
      form label {
		  font-weight: 628;
		}
     
      .select2-selection--multiple{
            border: solid #ced4da 1px !important;
      }

</style>




<form method="post" action="<?= base_url(ADMIN.'master/ItemApprovedRate/changeStatus')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4><?= $sub_title;?></h4>

      <hr>
        <input type="hidden" name="item_approved_id" id="item_approved_id" value="<?= isset($item_approved['id'])? $item_approved['id'] : ''; ?>">
        
        <input type="hidden" name="item_vendor_id" id="item_vendor_id" value="<?= isset($item_approved['vendor_id'])? $item_approved['vendor_id'] : ''; ?>">
        <input type="hidden" name="item_group_id" id="item_group_id" value="<?= isset($item_approved['item_group_id'])? $item_approved['item_group_id'] : ''; ?>">
        <input type="hidden" name="item_id" id="item_id" value="<?= isset($item_approved['item_id'])? $item_approved['item_id'] : ''; ?>">
        <input type="hidden" name="item_approved_type" id="item_approved_type" value="<?= isset($item_approved['type'])? $item_approved['type'] : ''; ?>">
        <input type="hidden" name="item_po_id" id="item_po_id" value="<?= isset($item_approved['reference_id'])? $item_approved['reference_id'] : ''; ?>">
        <input type="hidden" name="po_items_ids" id="po_items_ids" value="<?= isset($item_approved['po_items_id'])? $item_approved['po_items_id'] : ''; ?>">
        
        
            <div class="form-group col-md-12">
              <label>Item Group Name</label>
                <div>
                    <input readonly type="text" class="form-control "  value="<?= isset($item_approved['item_group_name'])? $item_approved['item_group_name'] : ''; ?>">
                </div>
            </div>

            <div class="form-group col-md-12">
              <label>Item Name</label>
                <div>
                    <input readonly type="text" class="form-control "  value="<?= isset($item_approved['item_name'])? $item_approved['item_name'] : ''; ?>">
                </div>
            </div>

            <div class="form-group col-md-12">
              <label>Company Name</label>
                <div>
                    <input readonly type="text" class="form-control "  value="<?= isset($item_approved['company_name'])? $item_approved['company_name'] : ''; ?>">
                </div>
            </div>
        
            <div class="form-group col-md-12">
              <label>Site Name</label>
                <div>
                    <input readonly type="text" class="form-control "  value="<?= isset($item_approved['site_name'])? $item_approved['site_name'] : ''; ?>">
                </div>
            </div>

            <div class="form-group col-md-12">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Vendor Name</label>
                         <input readonly type="text" class="form-control " value="<?= isset($item_approved['vendor_name'])? $item_approved['vendor_name'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Po Item No</label>
                        <input readonly type="text" class="form-control " value="<?= isset($item_approved['po_order_no'])? $item_approved['po_order_no'] : ''; ?>">
                    </div>
                </div>
            </div>  

            <div class="form-group col-md-12">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Type</label>
                         <?php 
                            if($item_approved['type'] == 1){ ?>
                                <input readonly type="text" class="form-control " value="Purchase Order">
                            <?php }else if($item_approved['type'] == 2){ ?>
                                <input readonly type="text" class="form-control " value="Item Master">
                            <?php }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <label>Reference Name</label>
                        <input readonly type="text" class="form-control " value="<?= isset($reference_name)? $reference_name : ''; ?>">
                    </div>
                </div>
            </div>  

      
            
            <div class="form-group col-md-12">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Old Rate</label>
                        <input readonly type="text" class="form-control " value="<?= isset($item_approved['old_rate'])? $item_approved['old_rate'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label>New Rate</label>
                        <input readonly type="text" class="form-control" name="new_rate" value="<?= isset($item_approved['new_rate'])? $item_approved['new_rate'] : ''; ?>">
                    </div>
                </div>
            </div>            

            <div class="form-group col-md-12">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Approved</label>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio3" name="is_approved" class="custom-control-input" value="1" <?= ((isset($item_approved['is_approved'])) && $item_approved['is_approved'] == 1)? 'checked': '';?>>
                                    <label class="custom-control-label" for="customRadio3">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio4" name="is_approved" class="custom-control-input" value="2" <?= ((isset($item_approved['is_approved'])) && $item_approved['is_approved'] == 2)? 'checked': '';?>>
                                    <label class="custom-control-label" for="customRadio4">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($item_approved['is_approved'] == 1){?>
                        <div class="col-md-6">
                            <label>Approved By</label>
                            <input readonly type="text" class="form-control " value="<?= isset($item_approved['approved_by_name'])? $item_approved['approved_by_name'] : ''; ?>">
                        </div>
                    <?php } ?>


                </div>
            </div>



            	 
      
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Update</button>
    </div>
</form>

