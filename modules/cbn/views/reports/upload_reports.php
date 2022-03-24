<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="#" onclick="return false;" class="btn btn-info pull-left display-block"><?php echo _l('new_upload'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <table class="table dt-table" data-order-col="1" data-order-type="asc">
                            <thead>
                                <th><?php echo _l('payment_upload'); ?></th>
                                <th><?php echo _l('payment_date'); ?></th>
                                <th><?php echo _l('payment_no_of_account'); ?></th>
                                <th><?php echo _l('payment_amount'); ?></th>
                                <th><?php echo _l('payment_uploaded_by'); ?></th>
                                <th><?php echo _l('payment_status'); ?></th>
                                <th><?php echo _l('payment_report'); ?></th>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

</body>

</html>