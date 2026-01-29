    <form action="<?= base_url('admin/PO/download_po_report_list');?>" method="post">
     
     <div class="row">
               <div class="col-md-2">
                  <label>Vendor</label>
                  <select class="form-control select2 did-floating-select city_name"  id="vendor_id"   name="vendor_id" value="" onchange="po_filter()">
                     <option value=""></option>
                  </select>
               </div>
               
               <div class="col-md-2">
                  <label>Compnay</label>
                  <select class="form-control select2 did-floating-select"  id="company_id"   name="company_id" value="" onchange="po_filter()">
                         <option value="">Select</option>
                     <option value="all">All</option>
                     <?php
                                foreach ($company_master as $key => $value) {
                                    
                              ?>
                                <option value="<?= $value['id'] ?>" ><?= $value['name'] ?></option>
                                <?php                                 
                                } 
                                ?>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Site Master</label>
                  <select class="form-control select2 did-floating-select"  id="site_id"   name="site_id" value="" onchange="po_filter()">
                         <option value="">Select</option>
                     <option value="all">All</option>
                    
                  </select>
               </div>
                <div class="col-md-2">
                  <label>Item Name</label>
                  <select class="form-control custom-select select2" id="item_id"  style="width:100%"  onchange="po_filter()">
                        <option value=""></option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>Cost Project Name</label>
                  <select class="form-control custom-select select2 project_cost" id="cost_project_id"  style="width:100%"  onchange="po_filter()">
                        <option value=""></option>
                  </select>
               </div>
               <div class="col-md-2">
                  <label>PO Date</label>
                  <select class="form-control select2 did-floating-select"  id="on_date"   name="on_date" value="" onchange="po_filter()">
                      <option value="">Select </option>
                         <option value="1">Today</option>
                         <option value="2">Yesterday</option>
                         <option value="3">This Week</option>
                         <option value="4">This Month</option>
                         <option value="5">This Year</option>
                         <option value="6">Custome Date</option>
                  </select>
               </div>
                
                <div class=" col-md-2  on_date">
                    <label class="">From Date</label>
                      <input type="date" name="from_date" id="from_date" class="form-control" autocomplete="off" placeholder="From date" onchange="po_filter()">
                      
                </div>
                <div class=" col-md-2  on_date">
                      <label class="">To Date</label>
                      <input type="date" name="to_date" id="to_date" class="form-control" autocomplete="off" placeholder="To date" onchange="po_filter()">
                    
                 </div>
               <!-- <div class="col-md-1">
                  <label></label>
                  <button class="btn btn-info filter_clear" style="margin-top: 16px;padding: 2px;">clear</button>
               </div> -->

            </div>  
              <div class="col-md-12 align-self-center text-right d-none d-md-block">
            <a href="" class="btn btn-info btn-theme"><i class="fa fa-plus-circle" ></i>&nbsp;<input type="submit" style="border: none;background: none;"  id="submit" name="submit" class="text-white" value="Export"></a>

        </div>
    </form>
    <div class="table-responsive">
       <table id="tbl_po" class="table display table-bordered text-center" width="100%">
       </table>
    </div>