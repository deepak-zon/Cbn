<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="type" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('cbn/franchies_type'), array('id' => 'state-type-form', 'class' => 'form_submit')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('add_new_franchies'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <div class="form-group" id="all_systems">
                        </div>
                        <span class="errsystem_id"></span>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"> <small class="req text-danger">* </small><?php echo _l('franchise_number'); ?></label><input type="text" id="franchise_number" name="franchise_number" class="form-control" value=""></div>
                        <span class="errfranchise_number"></span>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"><small class="req text-danger">* </small><?php echo _l('franchise_name'); ?></label><input type="text" id="franchise_name" name="franchise_name" class="form-control" value=""></div>
                        <span class="errfranchise_name"></span>
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
        <?php echo form_open(admin_url('cbn/franchies_type'), array('id' => 'state-type-form', 'class' => 'form_submit')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('add_new_franchies'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <input type="hidden" id="franchise_id" name="franchise_id" />
                        <div class="form-group" id="all_edit_systems">
                        </div>
                        <span class="errsystem_id"></span>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"> <small class="req text-danger">* </small><?php echo _l('franchise_number'); ?></label><input type="text" id="franchise_edit_number" name="franchise_number" class="form-control" value=""></div>
                        <span class="errfranchise_number"></span>
                        <div class="form-group" app-field-wrapper="name"><label for="name" class="control-label"><small class="req text-danger">* </small><?php echo _l('franchise_name'); ?></label><input type="text" id="franchise_edit_name" name="franchise_name" class="form-control" value=""></div>
                        <span class="errfranchise_name"></span>
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

<script>
    function new_type() {
        $('#type').modal('show');
        $.post('cbn/show_system', function(res) {
            $("#all_systems").html(res);
            $('#select_state').selectpicker('refresh');
        });
    }

    function edit_type(elem) {
        var dataId = $(elem).data("id");
        var system_id = $(elem).data("system_id");
        var franchise_name = $(elem).data("franchise_name");
        var franchise_number = $(elem).data("franchise_number");
        $("#franchise_id").val(dataId);
        $("#franchise_edit_number").val(franchise_number);
        $("#franchise_edit_name").val(franchise_name);
        $('#edit').modal('show');
        $.ajax({
            type: "GET",
            url: 'cbn/show_system',
            data: {
                id_system: system_id
            },
            success: function(result) {
                $("#all_edit_systems").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
</script>