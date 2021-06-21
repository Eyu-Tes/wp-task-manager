<div class="container">
	<h2 class="my-3"><?php _e("Task $id", 'wptask'); ?></h2>
	<form id="task-form" action="" method="post">
		<input name="taskmgr_updatetask" id="wptask_updatetask" value="true" type="hidden" />
		<input name="wptask_taskid" id="wptask_taskid" value="<?php echo $id; ?>" type="hidden" />
        <div class="form-group row">
            <label for="wptask_title" class="col-sm-3 col-form-label">Title</label>
            <div class="col-sm-9">
                <input name="wptask_title" id="wptask_title" value="<?php echo $wptask_edit_item['0']->title; ?>" type="text" class="form-control"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_description" class="col-sm-3 col-form-label">Description</label>
            <div class="col-sm-9">
                <td><textarea name="wptask_description" id="wptask_description" rows="5" class="form-control"><?php echo $wptask_edit_item['0']->desc; ?></textarea></td>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_date" class="col-sm-3 col-form-label">Created On</label>
            <div class="col-sm-9">
                <h6><?php echo self::taskmgr_date($wptask_edit_item['0']->created_at); ?></h6>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_deadline" class="col-sm-3 col-form-label">Deadline</label>
            <div class="col-sm-9">
                <td><input name="wptask_deadline" id="wptask_deadline" value="<?php echo date('Y-m-d', strtotime($wptask_edit_item['0']->deadline)); ?>" type="date" class="form-control"/></td>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_to" class="col-sm-3 col-form-label">Assigned To</label>
            <div class="col-sm-9">
	            <?php
	            $to = $wptask_edit_item['0']->to;
	            wp_dropdown_users("name=wptask_to&selected=$to&class=form-control");
	            ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_status" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
                <select name="wptask_status" id="wptask_status" class="form-control">
                    <option value="1" <?php if ($wptask_edit_item['0']->status == 1) echo "selected=\"selected\""; ?>>Open</option>
                    <option value="2" <?php if ($wptask_edit_item['0']->status == 2) echo "selected=\"selected\""; ?>>Closed</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_priority" class="col-sm-3 col-form-label">Priority</label>
            <div class="col-sm-9">
                <select name="wptask_priority" id="wptask_priority" class="form-control">
                    <option value="1" <?php if ($wptask_edit_item['0']->priority == 1) echo "selected=\"selected\""; ?>>Low</option>
                    <option value="2" <?php if ($wptask_edit_item['0']->priority == 2) echo "selected=\"selected\""; ?>>High</option>
                </select>
            </div>
        </div>
        <div class="form-group my-3">
            <input name="Submit" value="Update" type="submit" class="btn btn-sm btn-primary"/>
            <form action="" method="post">
                <input name="wptask_taskid" id="wptask_taskid" value="<?php echo $id; ?>" type="hidden"/>
                <?php
                if ( self::role_is_allowed() ) { ?>
                    <input name="wptask_deletetask" value="Delete" type="submit" class="btn btn-sm btn-danger"/>
                <?php } ?>
            </form>
            <a href="?page=wp-task" class="btn btn-sm btn-default">Cancel</a>
        </div>
    </form>
</div>
