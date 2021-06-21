<?php
    function get_user_id(): int {
		$current_user = wp_get_current_user();
		return $current_user->ID;
	}
?>

<div class="container">
    <form id="task-form" action="" method="post">
        <h2 class="my-3"><?php _e("New Task", 'wptask'); ?></h2>
        <input name="wptask_addtask" id="wptask_addtask" value="true" type="hidden" />
        <input name="wptask_from" id="wptask_from" value="<?php echo get_user_id(); ?>" type="hidden" />
        <div class="form-group row">
            <label for="wptask_title" class="col-sm-3 col-form-label">Title</label>
            <div class="col-sm-9">
                <input name="wptask_title" id="wptask_title" type="text" class="form-control"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_description" class="col-sm-3 col-form-label">Description</label>
            <div class="col-sm-9">
                <textarea name="wptask_description" id="wptask_description" rows="5" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_to" class="col-sm-3 col-form-label">Assigned To</label>
            <div class="col-sm-9">
	            <?php wp_dropdown_users("name=wptask_to&seleted&class=form-control"); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_deadline" class="col-sm-3 col-form-label">Deadline</label>
            <div class="col-sm-9">
                <input name="wptask_deadline" id="wptask_deadline" type="date" class="form-control"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_status" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
                <select name="wptask_status" id="wptask_status" class="form-control">
                    <option value="1">Open</option>
                    <option value="2">Closed</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="wptask_priority" class="col-sm-3 col-form-label">Priority</label>
            <div class="col-sm-9">
                <select name="wptask_priority" id="wptask_priority" class="form-control">
                    <option value="1">Low</option>
                    <option value="2">High</option>
                </select>
            </div>
        </div>
        <div class="form-group my-3">
            <input name="Submit" value="Create" type="submit" class="btn btn-sm btn-primary"/>
            <a href="?page=wp-task" class="btn btn-sm btn-default">Cancel</a>
        </div>
    </form>
</div>
