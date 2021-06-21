<div class="container">
    <h1 class="text-center my-3"><?php _e("Task Management", 'wptask'); ?></h1>

    <?php if (self::role_is_allowed()) { ?>
        <a href="?page=wp-task&add" class="btn btn-secondary">New Task</a>
    <?php } ?>

    <div class="table-responsive-lg">
        <table id="task" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Assigner</th>
                    <th>Assignee</th>
                    <th>Date Added</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Priority</th>
                </tr>
            </thead>
            <tbody>
		        <?php self::taskmgr_tasks(); ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    jQuery(document).ready(($) => {
        //you can now use $ as your jQuery object.
        $('#task').DataTable({
            responsive: true
        });
    });
</script>
