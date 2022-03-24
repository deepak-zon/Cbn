<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('cbn/state_type'), array('id' => 'state-type-form', 'class' => 'form_submit')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('new_state'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"> <small class="req text-danger">* </small><?php echo _l('state_name'); ?></label><input type="text" id="state_name" name="state_name" class="form-control" value="">
                            <span class="errstate_name"></span>
                        </div>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"><?php echo _l('state_short_letters'); ?></label><input type="text" id="state_short_letters" name="state_short_letters" class="form-control" value="">
                            <span class="errstate_short_letters"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('cbn/state_update'), array('id' => 'state-type-form', 'class' => 'form_submit')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('edit_state'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <input type="hidden" id="state_id" name="state_id" />
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"> <small class="req text-danger">* </small><?php echo _l('state_name'); ?></label><input type="text" id="state_edit_name" name="state_name" class="form-control">
                            <span class="errstate_name"></span>
                        </div>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"><?php echo _l('state_short_letters'); ?></label><input type="text" id="state_edit_letters" name="state_short_letters" class="form-control"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('update'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function new_type() {
        $('#add').modal('show');
    }

    function edit_type(elem) {
        var dataId = $(elem).data("id");
        var datname = $(elem).data("name");
        var dataletter = $(elem).data("letter");
        $("#state_id").val(dataId);
        $("#state_edit_name").val(datname);
        $("#state_edit_letters").val(dataletter);
        $('#edit').modal('show');
    }
</script>