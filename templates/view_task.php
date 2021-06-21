<div class="container">
    <h2 class="my-3"><?php _e("Task $id", 'wptask'); ?></h2>
    <h5 class="title"><?php echo $wptask_view_item['0']->title; ?></h5>
    <p class="desc"><?php echo $wptask_view_item['0']->desc; ?></p>
    <p>
        Assigned By: <strong><?php echo self::taskmgr_username((int) $wptask_view_item['0']->from); ?></strong> </br>
        Date Created: <em><?php echo self::taskmgr_date($wptask_view_item['0']->created_at); ?></em>  </br>
        Deadline: <em><?php echo self::taskmgr_date($wptask_view_item['0']->deadline); ?></em> </br>
        currently Assigned To: <em><strong><?php echo self::taskmgr_username((int) $wptask_view_item['0']->to); ?></strong></em>
    </p>

    <a href="?page=wp-task" class="btn btn-default">Cancel</a>
</div>
