<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="#" onclick="new_type(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('add_new_franchies'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <table class="table dt-table" data-order-col="1" data-order-type="asc">
                            <thead>
                                <th><?php echo _l('id'); ?></th>
                                <th><?php echo _l('franchise_name'); ?></th>
                                <th><?php echo _l('franchise_number'); ?></th>
                                <th><?php echo _l('system_name'); ?></th>
                                <th><?php echo _l('system_state'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                            </thead>
                            <?php if (count($franchise) > 0) { ?>
                                <tbody>
                                    <?php foreach ($franchise as $source) { ?>
                                        <tr>
                                            <td><?php echo $source['id']; ?></td>
                                            <td>
                                                <span class="text-muted">
                                                    <?php echo $source['franchise_name']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?php echo $source['franchise_number']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?php echo $source['system_name']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?php echo $source['state_name']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" onclick="edit_type(this)" data-id="<?php echo $source['id']; ?>" data-system_id="<?php echo $source['system_id']; ?>" data-franchise_name="<?php echo $source['franchise_name']; ?>" data-franchise_number="<?php echo $source['franchise_number']; ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                                                <?php if (!check_franchise_daelte($source['id'])) { ?>
                                                    <a href="<?php echo admin_url('cbn/franchise_delete/' . $source['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                                <?php } else { ?>
                                                    <a href="#" onclick="delete_franchise();" class="btn btn-danger btn-icon" disabled><i class="fa fa-remove"></i></a>
                                                <?php } ?>
                                            </td>
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
<?php $this->load->view('franchises/franchise_type'); ?>
<?php init_tail(); ?>
</body>
<script>
    function delete_franchise() {
        alert("You can't delete this franchise. It has records linked.");
    }
</script>

</html>