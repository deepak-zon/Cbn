<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
    .btn-outline-danger {
        color: #dc3545;
        background-color: transparent;
        background-image: none;
        border-color: #dc3545;
    }

    .btn-outline-primary {
        color: #03a9f4;
        background-color: transparent;
        background-image: none;
        border-color: #03a9f4;
    }
</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a style="margin-right:20px;"
                            <?php if (has_permission('bulk_offline_payments', '', 'create')) { ?>
                             onclick="add_payment();return false;" 
                             <?php }else{ ?>
                                href="<?= admin_url('cbn/access_denied');?>"
                             <?php }?>
                             class="btn btn-info pull-left display-block"><?php echo _l('new_upload'); ?></a>
                            <?php echo form_open(admin_url('cbn/download_sample_csv'), array('id' => 'download-payment-sample', 'class' => 'download-payment-sample')); ?>
                            <input type="hidden" name="download_sample" value="assets/csv_file/sample_import_file.csv">
                            <button type="submit" class="btn btn-success"><?= _l('download_sample'); ?></button>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <table class="table dt-table" data-order-col="1" data-order-type="asc">
                            <thead>
                                <th><?php echo _l('upload_payment'); ?></th>
                                <th><?php echo _l('payment_date'); ?></th>
                                <th><?php echo _l('payment_no_of_account'); ?></th>
                                <th><?php echo _l('payment_amount'); ?></th>
                                <th><?php echo _l('payment_uploaded_by'); ?></th>
                                <th><?php echo _l('payment_status'); ?></th>
                                <?php if (has_permission('bulk_offline_payments', '', 'view')) { ?>
                                <th><?php echo _l('payment_report'); ?></th>
                                <?php } ?>
                            </thead>
                            <?php if (count($bulk_payments) > 0) { ?>
                                <tbody>
                                    <?php foreach ($bulk_payments as $source) { ?>
                                        <tr>
                                            <td><?= $source['upload']; ?></td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= $source['date']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= $source['number_of_accounts']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= $base_currency->symbol . " " . $source['amount']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= $source['uploaded_by']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= ($source['status'] == 1) ? "Successful" : "Faild";
                                                    $source['status']; ?>
                                                </span>
                                            </td>
                                            <?php if (has_permission('bulk_offline_payments', '', 'view')) { ?>
                                            <td>
                                                <span class="text-muted">
                                                    <a class="btn btn-outline-danger" href="<?= base_url() ?>modules/cbn/uploads/pdf_files/<?= $source['report']; ?>.pdf" download><?= _l('download_invoice') ?></a>
                                                </span>
                                            </td>       
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('payments/bulk_offline_payments_add'); ?>
<?php init_tail(); ?>

</body>
<script>
    $(document).ready(function() {
        $(".ofline_payments").change(function(e) {
            var file_name = e.target.files[0].name;
            $("#add_class").removeClass();
            $("#add_class").addClass("col-md-8");
            $("#csv_file_name").html(file_name);
            //$("#upload_tag").attr('for', '');
            $("#test_upload").css("display", "block");
        });
    });
</script>

</html>