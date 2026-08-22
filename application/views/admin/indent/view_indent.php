<?php init_header(); ?>
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<style>
 
   b {
   font-weight: bold;
   }
   .form-control {
   border: none;
   }
   th.sorting {
   padding-right: 0px !important;
   }
   label {
   display: inline-block;
   margin-bottom: .0rem;
   }
   .color-table.success-table thead th {
   background: #48bc97 !important;
   color: #ffffff;
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
      <!-- Loop through each plant data -->
      <?php foreach ($indent_specific_data as $indentId => $indentData): ?>
      <!-- Start of card -->
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color">
                                 <h6><b>Indent Information</b></h6>
                              </span>
                              <hr>
                           </div>
                           
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Indent Number:</b></label><br>
                              <span><?= $indentviewData['indent_number']?></span>
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b></b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <span></span>
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b></b></label>
                           </div>
                         
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Plant Name:</b></label><br>
                              <span><?= $indentData['site_name']; ?></span>
                           </div>
                           <div class="form-group col-md-2 ">
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Bill No:</b></label><br>
                              <span><?= $indentviewData['indent_no']?></span>
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b></b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <span></span>
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b></b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Indent Date:</b></label><br>
                              <span><?= $indentviewData['date']?></span>
                           </div>
                           <div class="form-group col-md-2 ">
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Party Name:</b></label><br>
                              <span><?= $indentviewData['client_name']?></span><br>
                              <span><?= $indentviewData['plant_narration']?></span>
                           </div>
                           <div class="form-group col-md-2 ">
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b></b></label>
                           </div>
                           <div class="form-group col-md-2 ">
                              <span></span>
                           </div>
                           <div class="form-group col-md-2 ">
                              <label class="lbl_class"><b>Instruction No:</b></label><br>
                              <span><?= $indentviewData['indent_no']?></span>
                           </div>
                           <div class="form-group col-md-2 ">
                           </div>
                         
                        </div>
                     </div>
                     <div class="col-md-12 mb-2">
                        <div class="table-responsive">
                         
                           <table class="table display table-bordered no-wrap table color-table success-table" style="width: 100%; color: #ffffff;">
                              <thead>
                                 <tr>
                                    <th scope="col" style="width: 10%;">Sr._No</th>
                                    <th scope="col" style="width: 20%;">Indent For</th>
                                    <th scope="col" style="width: 30%;">Description</th>
                                    <th scope="col" style="width: 20%;">Qty</th>
                                    <th scope="col" style="width: 20%;">Date</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php foreach ($indentData['indent_details'] as $key => $value1): ?>
                                 <tr>
                                    <td><?php echo $offset + ($key + 1); ?></td>
                                    <td><?php echo $value1['indent_name']; ?></td>
                                    <td>
                                       <?php
                                         
                                          $sub_tbl_data = $this->CommonModel->getData($value1['db_table_name'], array('id' => $value1['ref_id']), '', '', 'row_array');
                                          if (!empty($sub_tbl_data)) {
                                              echo '<table style="width:100%; margin:0;">';
                                              foreach ($sub_tbl_data as $key => $value) {
                                                  if ($key !== 'id' && $key !== 'plant_id' && $key !== 'master_indent_id' && $key !== 'indent_id' && $key !== 'created_at' && $key !== 'created_by' && $key !== 'updated_at' && $key !== 'updated_by' && $key !== 'deleted_by' && $key !== 'deleted_at') {
                                                      echo '<tr><td>' . ucfirst(str_replace("_", " ", $key)) . ':</td><td>' . $value . '</td></tr>';
                                                  }
                                              }
                                              echo '</table>';
                                              $qty = isset($sub_tbl_data[$value1['db_qty_field_name']]) ? $sub_tbl_data[$value1['db_qty_field_name']] : 0;
                                          } else {
                                              $qty = 0;
                                          }
                                          ?>
                                    </td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $value1['created_at']; ?></td>
                                 </tr>
                                 <?php endforeach; ?>
                              </tbody>
                           </table>
                         
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End of card -->
      <?php endforeach; ?>
   </div>
</div>
</div>
</div>
</div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/indent/indent.js"></script>