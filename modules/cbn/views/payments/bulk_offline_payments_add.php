<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    #dropzoneDragArea {
        background-color: #fbfdff;
        border: 1px dashed #c0ccda;
        border-radius: 4px;
        padding: 35px;
        text-align: center;
        margin-bottom: 15px;
        cursor: pointer;
    }
</style>
<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <?php echo form_open_multipart(admin_url('cbn/file_upload'), array('class' => 'upload_file', 'id' => 'bulk_offline_payments')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('new_upload'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="add_class" class="col-md-12">
                        <div id="additional"></div>
                        <label for="upload" id="upload_tag" style="width:100%;">
                            <div class="form-group" id="dropzoneDragArea">
                                <span id="csv_file_name">Drop Files here to upload</span>
                                <input type="file" id="upload" name="file_csv" class="form-control ofline_payments" style="display:none">
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4" id="test_upload" style="display:none;">
                        <div style="margin-top:30px;margin-left:50px;">
                            <button type="submit" class="btn btn-info upload_btn"><?php echo _l('test_upload'); ?></button>
                        </div>
                    </div>
                    <div class="col-md-12" id="table_payment">
                    </div>
                </div>
            </div>
            <input type="hidden" id="confirm_upload" data-url="<?= admin_url('cbn/bulk_offline_payments_upload'); ?>">
            <input type="hidden" id="no_of_account" name="no_of_account">
            <input type="hidden" id="total_amount" name="total_amount">
            <?php echo form_close(); ?>
            <div class="modal-footer">
                <div class="text-center" id="payment_message" style="font-size:20px;color:#03a9f4;"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function add_payment() {
        $('#add').modal('show');
    }
</script>