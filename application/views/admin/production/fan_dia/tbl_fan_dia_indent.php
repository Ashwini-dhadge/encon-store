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
    <div class="col-md-5">
        <h4 class="card-title">Fan Dia Indent</h4>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">

        <a href="<?= base_url('admin/production/Indent/add_indentfor_fandia'); ?>" class="btn btn-info btn-theme"><i
                class="fa fa-plus-circle"></i>&nbsp;Create Order For Fan Dia</a>
       
    </div>
</div>
<div class="table-responsive">
    <table id="fan_dia_indent" class="table display table-responsive   table-bordered text-center" width="100%">

    </table>
</div>
