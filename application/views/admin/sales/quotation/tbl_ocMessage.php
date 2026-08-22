<div class="table-responsive">
    

    <?php 
        if($type == '1'){
            ?> 
                <input type="hidden" id="ocHeaderFooterType" value="<?php echo $type; ?>">
                <table id="ocHeadeFooterTbl" class="table display  no-wrap  table-bordered text-center" width="100%">
                </table>
            <?php
        }else
        {
            ?> 
                <input type="hidden" id="ocFooterType" value="<?php echo $type; ?>">
                <table id="ocFooterTbl" class="table display no-wrap table-bordered text-center" width="100%">
                </table>
            <?php
        }


    ?>
</div>