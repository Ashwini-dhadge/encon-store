<style>
    .select2-selection {
        height: 37px !important;

    }

    .no_margin_bottom {
        margin-bottom: 0rem !important;
    }

    .dataTables_filter {
        margin-top: 0px !important;
    }

    .dataTables_length {
        margin-top: 0px !important;
    }
</style>
<div class="row">
    <div class="col-md-2">
        <h4 class="card-title"><?php echo $title; ?></h4>
    </div>

    <div class="col-md-10 d-flex flex-row-reverse">
        <a href="<?= base_url('admin/production/ReceivedOrders/bladeStatusReport'); ?>"
            class="btn btn-primary btn-sm">Status Report</a>
    </div>



</div>

<div class="table-responsive">
    <table id="receivedOrders" class="table display table-responsive table-bordered text-center" width="100%">

    </table>
</div>





