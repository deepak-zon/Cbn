<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('cbn/system_type'), array('id' => 'system-type-form', 'class' => 'form_submit')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('add_new_system'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <div class="form-group" id="all_state">
                        </div>
                        <span class="errstate_id"></span>
                        <div id="additional"></div>
                        <div class="form-group" app-field-wrapper="name"><small class="req text-danger">* </small><label for="name" class="control-label"><?php echo _l('system_name'); ?></label><input type="text" id="name" name="system_name" class="form-control" value="">
                            <span class="errsystem_name"></span>
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
        <?php echo form_open(admin_url('cbn/system_type'), array('id' => 'system-type-form', 'class' => 'form_submit')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('edit_new_system'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <input type="hidden" id="system_id" name="system_id" />
                        <div class="form-group" id="all_state_edit">
                        </div>
                        <span class="errstate_id"></span>
                        <div id="additional"></div>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"><?php echo _l('system_name'); ?></label><input type="text" id="system_edit_name" name="system_name" class="form-control" value=""></div>
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
    function systems_type() {
        $('#add').modal('show');
        $.post('cbn/show_state', function(res) {
            $("#all_state").html(res);
            $('#select_state').selectpicker('refresh');
        });
    }

    function edit_type(elem) {
        var dataId = $(elem).data("id");
        var state_id = $(elem).data("state_id");
        var system_name = $(elem).data("system_name");
        $("#system_id").val(dataId);
        $("#system_edit_name").val(system_name);
        $('#edit').modal('show');
        $.ajax({
            type: "GET",
            url: 'cbn/show_state',
            data: {
                id_state: state_id
            },
            success: function(result) {
                $("#all_state_edit").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
</script>