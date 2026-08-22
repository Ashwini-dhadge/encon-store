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
        <h4>Add FRP Clamp</h4>
        <hr>
        <input type="hidden" name="master_indent_id" id="master_indent_id" value="22">
        <input type="hidden" name="order_for" value="1">
        <input type="hidden" name="indent_db_id" id="indentIdModal" value="<?= $indent_db_id ?? $indent_id ?? '' ?>">
        <input type="hidden" name="plant_id" value="<?= (isset($plant_id) ? $plant_id : "") ?>">
        <input type="hidden" name="client_id" value="<?= (isset($client_id) ? $client_id : "") ?>">
        <input type="hidden" id="id" name="id" value="<?= isset($id) ? $id : '' ?>">
        <!-- <input type="hidden" name="indent_sequence" value="<?= $indentseqNumber ?? '' ?>"> -->
        <input type="hidden" name="manual_indent_no" value="<?= $manual_indent_no ?? '' ?>">
        <!-- <input type="hidden" name="indent_no" value="<?= $indentNumber ?? '' ?>"> -->
        <div class="row">
            <div class="form-group col-md-4 mt-1">
                <label>Clamp Size</label>
                <select class="form-control custom-select select2" name="clamp_size">
                    <option value="" disabled <?= empty($clamp_size) ? 'selected' : ''; ?>>
                        Select Size
                    </option>

                    <?php foreach ($clamp_type as $type): ?>
                        <option value="<?= $type['name']; ?>"
                            <?= (!empty($clamp_size) && $clamp_size == $type['name']) ? 'selected' : ''; ?>>
                            <?= $type['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-4 mt-1">
                <label>Clamp Material</label>
                <select class="form-control custom-select select2" name="material">
                    <option value="" disabled <?= empty($material) ? 'selected' : ''; ?>>
                        Select Material
                    </option>

                    <?php foreach ($clamp_material as $m): ?>
                        <option value="<?= $m['name']; ?>"
                            <?= (!empty($material) && $material == $m['name']) ? 'selected' : ''; ?>>
                            <?= $m['name']; ?>
                        </option>
                    <?php endforeach; ?>
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
                        <div class="row">
                            <div class="col-md-4 mb-3 form-group">
                                <label>PCD 1</label>
                                <input type="text" class="form-control " value="<?= $specifications['pcd_1'] ?? '' ?>" name="pcd_1" id="pcd1">
                            </div>
                            <div class="col-md-4 mb-3 form-group">
                                <label>PCD 2</label>
                                <input type="text" class="form-control " value="<?= $specifications['pcd_2'] ?? '' ?>" name="pcd_2" id="pcd2">
                            </div>
                            <div class="col-md-4 mb-3 form-group">
                                <label>Drill Size MM</label>
                                <input type="text" class="form-control " value="<?= $specifications['drill_size'] ?? '' ?>" name="drill_size"
                                    id="drill_size">
                            </div>
                            <div class="col-md-4 mb-3 form-group">
                                <label>Length MM</label>
                                <input type="text" class="form-control " value="<?= $specifications['length'] ?? '' ?>" name="length" id="length">
                            </div>
                            <div class="col-md-4 mb-3 form-group">
                                <label>Width MM</label>
                                <input type="text" class="form-control " value="<?= $specifications['width'] ?? '' ?>" name="width" id="width">
                            </div>
                            <div class="col-md-4 mb-3 form-group">
                                <label>Height MM</label>
                                <input type="text" class="form-control " value="<?= $specifications['height'] ?? '' ?>" name="height" id="height">
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