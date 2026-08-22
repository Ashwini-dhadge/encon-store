<style>
   label.error {
      display: none !important;
   }

   .select2-selection__rendered {
      margin-top: 1px;
   }

   .margin-bottom-7 {
      margin-bottom: 7px !important;
   }

   .margin-bottom-20 {
      margin-bottom: 20px !important;
   }

   label {
      margin-bottom: 0.2rem;
   }

   #mapping {
      margin-left: 20px;
   }

   form label {
      font-weight: 628;
   }

   .select2-selection--multiple {
      border: solid #ced4da 1px !important;
   }

   .datepicker {
      z-index: 1100 !important;
   }
</style>

<form method="post" action="<?= base_url(ADMIN . 'indent/Indent/saveIndentAllModule') ?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Carbon Fiber Drive Shift</h4>
      <hr>
      <input type="hidden" name="master_indent_id" id="master_indent_id" value="<?= (isset($master_indent_id) ? $master_indent_id : "") ?>">
      <input type="hidden" name="indent_id" id="indentIdModal" value="<?= (isset($indent_id) ? $indent_id : "") ?>">
      <input type="hidden" name="plant_id" id="plant_id" value="<?= (isset($plant_id) ? $plant_id : "") ?>">
      <input type="hidden" id="id" name="id" value="<?= (isset($id) ? $id : "") ?>">
      <div class="row">
         <div class="form-group col-md-4 mt-1">
            <label class="">Dimension</label>
            <input class="form-control " type="text" id="dimension" name="dimension" value="<?= isset($dimension) ? $dimension : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Material</label>
            <select class="form-control select2 did-floating-select" id="material" name="material">
               <option>select</option>
               <option value="Carbon Fibre Composite" <?= (isset($material) && ($material == "Carbon Fibre Composite")) ? "selected" : "" ?>>Carbon Fibre Composite </option>
            </select>
         </div>
         <!-- </div> -->
         <div class="form-group col-md-4 mt-1">
            <label style="border-color:#ced4da;" class="">Remark</label>
            <input class="form-control " type="text" id="remark" name="remark" value="<?= isset($remark) ? $remark : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Qty</label>
            <input class="form-control " type="text" id="qty" name="qty" value="<?= isset($qty) ? $qty : ''; ?>" required>
         </div>
         <div class="form-group col-md-4 mt-1">
            <label class="">Make</label>
            <input class="form-control " type="text" id="make" name="make" value="<?= isset($make) ? $make : ''; ?>" required>
         </div>
         <hr>

         <div class="col-md-12">
            <div class="row">
               <div class="col-md-12 mt-2">
                  <h6 style="font-weight:bold;">Add Technical Specification</h6>
                  <hr>
               </div>

               <div class="col-md-12">
                  <table class="table table-bordered" id="specGroupTable">
                     <thead class="success-table">
                        <tr>
                           <th style="width:6%">Qty</th>
                           <th style="width:15%">Motor Power</th>
                           <th style="width:15%">DBSE</th>
                           <th style="width:15%">Tube (OD * THK)</th>
                           <th class="col-bore">Bore</th>
                           <th class="col-keyway">Keyway</th>
                           <th style="width:14%">Fan RPM</th>
                           <th class="col-action">Action</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>

                  <button type="button" class="btn btn-info btn-xs" id="addSpecGroup">
                     + Add Specification 
                  </button>

                  <div id="quantityStatus" class="mt-2">
                     <strong>Assigned Quantity :</strong>
                     <span id="assignedQty">0</span> /
                     <span id="orderQtyDisplay">0</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
      <button type="button" class="btn waves-effect waves-light" id="submit_btn_modal" onclick="submitAllIndentMaster()" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>

<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
   
<script>
   $(document).ready(function() {

      /* =============================
         FORM VALIDATION
      ============================== */
      $('#form').validate({
         rules: {
            qty: {
               required: true,
               min: 1
            }
         },
         messages: {
            qty: {
               required: "Please enter quantity",
               min: "Quantity must be at least 1"
            }
         }
      });


      /* =============================
         QUANTITY MANAGEMENT
      ============================== */
      let QuantityManager = {

         getOrderQty: function() {
            return parseInt($('#qty').val()) || 0;
         },

         getAssignedQty: function() {
            let total = 0;
            $('.group-qty').each(function() {
               total += parseInt($(this).val()) || 0;
            });
            return total;
         },

         updateDisplay: function() {
            const assigned = this.getAssignedQty();
            const orderQty = this.getOrderQty();

            $('#assignedQty').text(assigned);
            $('#orderQtyDisplay').text(orderQty);

            return {
               assigned,
               orderQty
            };
         }
      };


      /* =============================
         EVENT HANDLERS
      ============================== */

      $('#qty').on('keyup change', function() {
         QuantityManager.updateDisplay();
      });


      $('#addSpecGroup').on('click', function() {
         const orderQty = QuantityManager.getOrderQty();
         const assigned = QuantityManager.getAssignedQty();

         if (orderQty === 0) {
            Swal.fire({
               icon: 'warning',
               title: 'Enter Quantity First',
               text: 'Please enter Qty before adding specification groups.',
               confirmButtonColor: '#48bc97'
            });
            return;
         }

         if (assigned >= orderQty) {
            Swal.fire({
               icon: 'warning',
               title: 'Quantity Completed',
               text: 'All quantity has been assigned to specification groups.',
               confirmButtonColor: '#48bc97'
            });
            return;
         }

         addSpecGroupRow();
         QuantityManager.updateDisplay();
      });


      /* =============================
         COPY ROW (FIXED RESET)
      ============================== */
      $(document).on('click', '.copyRow', function() {

         const orderQty = QuantityManager.getOrderQty();
         const assigned = QuantityManager.getAssignedQty();

         if (assigned >= orderQty) {
            Swal.fire({
               icon: 'warning',
               title: 'Cannot Add More',
               text: 'All quantity has been assigned.',
               confirmButtonColor: '#48bc97'
            });
            return;
         }

         let clone = $(this).closest('tr').clone(false);

         clone.find('.group-qty').val('');

         // reset bore
         clone.find('.bore-wrapper').html(getBoreHtml());

         // reset keyway
         clone.find('.keyway-wrapper').html(getKeywayHtml());

         $('#specGroupTable tbody').append(clone);
         QuantityManager.updateDisplay();
      });


      $(document).on('click', '.removeRow', function() {
         $(this).closest('tr').remove();
         QuantityManager.updateDisplay();
      });


      $(document).on('keyup change', '.group-qty', function() {
         const val = parseInt($(this).val()) || 0;
         const orderQty = QuantityManager.getOrderQty();
         const assigned = QuantityManager.getAssignedQty();

         if (val < 1) {
            $(this).val('');
            return;
         }

         if (assigned > orderQty) {
            Swal.fire({
               icon: 'warning',
               title: 'Quantity Exceeded',
               text: `Total assigned quantity (${assigned}) exceeds Qty (${orderQty}).`,
               confirmButtonColor: '#48bc97'
            });
            $(this).val('');
         }

         QuantityManager.updateDisplay();
      });


      /* =============================
         BORE MANAGEMENT (FIXED)
      ============================== */
      function getBoreHtml() {
         return `
         <div class="input-group mb-1 bore-row">
            <input type="text" name="bore[][]" class="form-control" placeholder="Enter bore">
            <div class="input-group-append">
               <button type="button" class="btn btn-success btn-xs addBore">+</button>
            </div>
         </div>`;
      }

      $(document).on('click', '.addBore', function() {
         $(this).closest('.bore-wrapper').append(`
         <div class="input-group mb-1 bore-row">
            <input type="text" name="bore[][]" class="form-control" placeholder="Enter bore">
            <div class="input-group-append">
               <button type="button" class="btn btn-danger btn-xs removeBore">-</button>
            </div>
         </div>
      `);
      });

      $(document).on('click', '.removeBore', function() {
         if ($(this).closest('.bore-wrapper').find('.bore-row').length > 1) {
            $(this).closest('.bore-row').remove();
         }
      });


      /* =============================
         KEYWAY MANAGEMENT (FIXED)
      ============================== */
      function getKeywayHtml() {
         return `
         <div class="input-group mb-1 keyway-row">
            <input type="text" name="keyway[][]" class="form-control" placeholder="Enter keyway">
            <div class="input-group-append">
               <button type="button" class="btn btn-success btn-xs addKeyway">+</button>
            </div>
         </div>`;
      }

      $(document).on('click', '.addKeyway', function() {
         $(this).closest('.keyway-wrapper').append(`
         <div class="input-group mb-1 keyway-row">
            <input type="text" name="keyway[][]" class="form-control" placeholder="Enter keyway">
            <div class="input-group-append">
               <button type="button" class="btn btn-danger btn-xs removeKeyway">-</button>
            </div>
         </div>
      `);
      });

      $(document).on('click', '.removeKeyway', function() {
         if ($(this).closest('.keyway-wrapper').find('.keyway-row').length > 1) {
            $(this).closest('.keyway-row').remove();
         }
      });


      /* =============================
         FORM SUBMIT (UNCHANGED FLOW)
      ============================== */
      $('#submit_btn_modal').on('click', function() {

         if (!$('#form').valid()) return;

         const {
            assigned,
            orderQty
         } = QuantityManager.updateDisplay();
         const hasSpecGroups = $('.group-qty').length > 0;

         if (orderQty === 0) {
            Swal.fire({
               icon: 'error',
               title: 'Invalid Quantity',
               text: 'Please enter Qty.',
               confirmButtonColor: '#48bc97'
            });
            return;
         }

         if (!hasSpecGroups) {
            Swal.fire({
               icon: 'error',
               title: 'No Specifications',
               text: 'Please add at least one technical specification group.',
               confirmButtonColor: '#48bc97'
            });
            return;
         }

         if (assigned !== orderQty) {
            Swal.fire({
               icon: 'error',
               title: 'Quantity Mismatch',
               text: `Assigned quantity (${assigned}) must exactly match Qty (${orderQty}).`,
               confirmButtonColor: '#48bc97'
            });
            return;
         }

         $('#form').submit();
      });


      /* =============================
         ADD SPEC GROUP ROW
      ============================== */
      function addSpecGroupRow() {
         const row = `
         <tr>
            <td>
               <input type="number" name="group_qty[]" class="form-control group-qty" min="1" required>
            </td>
            <td><input type="text" name="motor_power[]" class="form-control" placeholder="e.g., 10 HP"></td>
            <td><input type="text" name="dbse[]" class="form-control" placeholder="Enter DBSE"></td>
            <td><input type="text" name="tube_od_thk[]" class="form-control" placeholder="e.g., 50*3"></td>
            <td><div class="bore-wrapper">${getBoreHtml()}</div></td>
            <td><div class="keyway-wrapper">${getKeywayHtml()}</div></td>
            <td><input type="text" name="fan_rpm[]" class="form-control" placeholder="Enter fan RPM"></td>
            <td class="col-action">
               <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-secondary btn-xs copyRow mr-1">
                     <i class="fa fa-copy"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-xs removeRow">
                     <i class="fa fa-trash"></i>
                  </button>
               </div>
            </td>
         </tr>`;

         $('#specGroupTable tbody').append(row);
      }


      QuantityManager.updateDisplay();

   });
</script>