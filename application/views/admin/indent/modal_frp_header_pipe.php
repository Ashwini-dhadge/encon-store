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

<!-- action="<?= base_url(ADMIN . 'indent/Indent/saveIndentAllModule') ?>" -->
<form method="post" id="form" enctype="multipart/form-data">
    <div class="modal-body">
        <h4>Add FRP Header Pipe</h4>
        <hr>
        <input type="hidden" name="master_indent_id" id="master_indent_id" value="21">
        <input type="hidden" name="order_for" value="1">
        <input type="hidden" name="indent_db_id" id="indentIdModal" value="<?= $indent_db_id ?? $indent_id ?? '' ?>">
        <input type="hidden" name="plant_id" id="plant_id" value="<?= (isset($plant_id) ? $plant_id : "") ?>">
        <input type="hidden" id="id" name="id" value="<?= (isset($id) ? $id : "") ?>">
        <!-- <input type="hidden" name="indent_sequence" value="<?= $indentseqNumber ?? '' ?>"> -->
        <input type="hidden" name="manual_indent_no" value="<?= $manual_indent_no ?? '' ?>">
        <!-- <input type="hidden" name="indent_no" value="<?= $indentNumber ?? '' ?>"> -->
        <div class="row">
            <div class="form-group col-md-4 mt-1">
                <label class="">Dimension</label>
                <input class="form-control " type="text" id="dimension" name="dimension" value="<?= isset($dimension) ? $dimension : ''; ?>" required>
            </div>
            <div class="form-group col-md-4 mt-1">
                <label class="">Material</label>
                <select class="form-control select2 did-floating-select" id="material" name="material">
                    <option>select</option>
                    <option value="FRP Header Pipe" <?= (isset($material) && ($material == "FRP Header Pipe")) ? "selected" : "" ?>>Frp Header Pipe</option>
                </select>
            </div>
            <!-- </div> -->
            <div class="form-group col-md-4 mt-1">
                <label style="border-color:#ced4da;" class="">Remark</label>
                <input class="form-control " type="text" id="remark" name="remark" value="<?= isset($remark) ? $remark : ''; ?>" required>
            </div>
            <div class="form-group col-md-4 mt-1">
                <label class="">Qty</label>
                <input class="form-control" type="number" id="qty" name="order_qty" value="<?= isset($qty) ? $qty : ''; ?>" required>
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
                                    <th style="width:15%">Qty</th>
                                    <th style="width:20%">Length Diameter</th>
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
    $.ajax({
        url: base_url + 'admin/indent/Indent/saveIndentAllModule',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function(response) {

            console.log(response);

            $('#submit_btn_modal').prop('disabled', false);

            if (response.result == true) {

                // Swal.fire({
                //     icon: 'success',
                //     title: 'Success',
                //     text: response.reason
                // }); 
                // alert(response.reason);
                window.location.reload();
                $('#con-close-modal').modal('hide');

                if ($.fn.DataTable.isDataTable('#tbl_indent')) {
                    $('#tbl_indent').DataTable().ajax.reload(null, false);
                }

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.reason
                });

                // ✅ DO NOT CLOSE MODAL
            }
        },

        error: function(xhr) {

            $('#submit_btn_modal').prop('disabled', false);

            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Check console/network response'
            });

            // ✅ MODAL STAYS OPEN
        }
    });
</script>
<script>
    $(document).ready(function() {

        $('#form').validate({
            rules: {
                qty: {
                    required: true,
                    min: 1
                }
            }
        });

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

        $('#qty').on('keyup change', function() {
            QuantityManager.updateDisplay();
        });

        $('#addSpecGroup').on('click', function() {

            const orderQty = QuantityManager.getOrderQty();
            const assigned = QuantityManager.getAssignedQty();

            if (orderQty === 0) {
                Swal.fire('Enter Qty first');
                return;
            }

            if (assigned >= orderQty) {
                Swal.fire('All quantity assigned');
                return;
            }

            addSpecGroupRow();
            QuantityManager.updateDisplay();
        });

        $(document).on('click', '.copyRow', function() {

            const orderQty = QuantityManager.getOrderQty();
            const assigned = QuantityManager.getAssignedQty();

            if (assigned >= orderQty) {
                Swal.fire('Cannot add more');
                return;
            }

            let clone = $(this).closest('tr').clone(false);

            clone.find('.group-qty').val('');
            clone.find('input[name="length_dia[]"]').val('');

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
                Swal.fire(`Assigned (${assigned}) exceeds Qty (${orderQty})`);
                $(this).val('');
            }

            QuantityManager.updateDisplay();
        });

        $('#submit_btn_modal').on('click', function() {

            if (!$('#form').valid()) return;

            const {
                assigned,
                orderQty
            } =
            QuantityManager.updateDisplay();

            if (orderQty === 0) {
                Swal.fire('Enter Qty');
                return;
            }

            if (assigned !== orderQty) {
                Swal.fire('Quantity mismatch');
                return;
            }

            submitAllIndentMaster();
        });

        let specRowCounter = 0;

        function addSpecGroupRow() {

            const index = specRowCounter++;

            const row = `
    <tr data-index="${index}">
        <td>
            <input type="number"
                   name="group_qty[]"
                   class="form-control group-qty"
                   min="1"
                   required>
        </td>

        <td>
            <input type="text"
                   name="length_dia[]"
                   class="form-control"
                   placeholder="e.g. 16*60">
        </td>

        <td>
            <button type="button"
                    class="btn btn-secondary btn-xs copyRow">
                <i class="fa fa-copy"></i>
            </button>

            <button type="button"
                    class="btn btn-danger btn-xs removeRow">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>`;

            $('#specGroupTable tbody').append(row);
        }

        QuantityManager.updateDisplay();

        /* =============================
           LOAD EXISTING DATA (EDIT)
        ============================== */
        let existingSpecs = <?= isset($specifications) ? json_encode($specifications) : '[]' ?>;

        if (existingSpecs.length > 0) {

            existingSpecs.forEach(function(spec) {

                const row = `
            <tr>
                <td>
                    <input type="number" name="group_qty[]" class="form-control group-qty" value="${spec.group_qty ?? ''}" min="1">
                </td>
                <td>
                    <input type="text" name="length_dia[]" class="form-control" value="${spec.length_dia ?? ''}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-xs removeRow"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;

                $('#specGroupTable tbody').append(row);
            });

            QuantityManager.updateDisplay();
        }

    });
</script>