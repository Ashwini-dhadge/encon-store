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

    #blade_indent tr:hover {
        background-color: #48bc9720 !important;
        font-size: 12px !important;
    }

    
</style>
<div class="row">
    <div class="col-md-5">
        <h4 class="card-title"><?= $title ?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">

        <a href="<?= base_url('admin/production/Indent/createorder_frp_headerpipe'); ?>" class="btn btn-info btn-theme btn-xs"><i
                class="fa fa-plus-circle"></i>&nbsp;Create Order For Encon (India)</a>
    </div>
</div>
<div class="table-responsive">
    <table id="blade_indent" class="table display table-responsive   table-bordered text-center" width="100%">

    </table>
</div>