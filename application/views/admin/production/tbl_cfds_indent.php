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
    }
</style>
<div class="row">
    <div class="col-md-5">
        <h4 class="card-title">Carbon Fiber Drive Shaft Indent</h4>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">

        <a href="<?= base_url('admin/production/Indent/add_indentfor_carbonfiberdriveshaft'); ?>" class="btn btn-info btn-theme"><i
                class="fa fa-plus-circle"></i>&nbsp;Create Order For Carbon Fiber Drive Shaft</a>
        <!--  <button type="button" class="btn btn-info btn-theme siteModal" data-toggle="modal" data-target="#siteModal" ><i class="fa fa-plus-circle"></i>
             Create New Indent
               </button> -->
    </div>
</div>
<div class="row">
    <!-- <div class="col-md-2">

        <select class="form-control custom-select select2 indent_id" id="indentid" onchange="filter_indent()"
            name="indent_name_id" style="width:100%">
            <option value="all">Select All</option>
            <?php foreach ($indent_name as $value): ?>
                <?php
                $selected = '';
                if ($value['id'] == 1) {
                    $selected = 'selected';
                }
                ?>
                <option value="<?= $value['id'] ?>" <?= $selected ?>><?= $value['indent_name'] ?></option>
            <?php endforeach; ?>
        </select>

    </div> -->
</div>
<div class="table-responsive">
    <table id="blade_indent" class="table display table-responsive   table-bordered text-center" width="100%">

    </table>
</div>
<!-- <div id="siteModal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div id="_banner"></div>
      </div>
   </div>
</div> -->