     <style>
        .table td .btn {
           display: inline-flex !important;
           align-items: center;
           justify-content: center;
           width: auto !important;
           height: auto !important;
           min-width: 26px;
           min-height: 26px;
           margin: 6px;
           line-height: 1;
           border: 1px solid #818181 !important;
        }

        .table td .btn:hover {
           background-color: #48bc97 !important;
           color: #fff !important;
        }

        .btn-icon {
           width: 36px !important;
           height: 36px !important;
           padding: 0 !important;
        }

        .btn-group-sm .btn {
           width: 34px !important;
           height: 34px !important;
           padding: 0 !important;
        }

        #tbl_po td {
           vertical-align: middle !important;
           white-space: nowrap !important;
        }
     </style>
     <div class="row">
        <div class="col-md-2">
           <label>Vendor</label>
           <select class="form-control custom-select select2 get_vendor" style="width:100%" name="vendor_id" id="vendor_id" onchange="po_filter()" required>
              <option value="">Select</option>

           </select>
        </div>

        <div class="col-md-2">
           <label>Compnay</label>
           <select class="form-control select2 did-floating-select" id="company_id" name="company_id" value="" onchange="po_filter()">
              <option value="">Select</option>
              <option value="all">All</option>
              <?php
               foreach ($company_master as $key => $value) {

               ?>
                 <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
              <?php
               }
               ?>
           </select>
        </div>
        <div class="col-md-2">
           <label>Site Master</label>
           <select class="form-control select2 did-floating-select get_site" id="site_id" name="site_id" value="" onchange="po_filter()">
              <option value="">Select</option>
              <option value="all">All</option>

           </select>
        </div>
        <div class="col-md-2">
           <label>PO Date</label>
           <select class="form-control select2 did-floating-select" id="on_date" name="on_date" value="" onchange="po_filter()">
              <option value="">Select </option>
              <option value="1">Today</option>
              <option value="2">Yesterday</option>
              <option value="3">This Week</option>
              <option value="4">This Month</option>
              <option value="5">This Year</option>
              <!-- <option value="6">Custome Date</option> -->
           </select>
        </div>

        <!-- <div class=" col-md-2  on_date">
           <label class="">From Date</label>
           <input type="date" name="from_date" id="from_date" class="form-control" autocomplete="off" placeholder="From date" onchange="po_filter()">

        </div>
        <div class=" col-md-2  on_date">
           <label class="">To Date</label>
           <input type="date" name="to_date" id="to_date" class="form-control" autocomplete="off" placeholder="To date" onchange="po_filter()">

        </div> -->
        <!-- <div class="col-md-1">
                  <label></label>
                  <button class="btn btn-info filter_clear" style="margin-top: 16px;padding: 2px;">clear</button>
               </div> -->

     </div>
     <div class="table-responsive">
        <table id="tbl_po" class="table display table-bordered text-center" width="100%">
        </table>
     </div>