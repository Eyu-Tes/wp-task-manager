<?php
// silence warning: Unable to resolve column "col_name"
/** @noinspection SqlResolve */

namespace app\Base;


use wpdb;

class Model extends BaseController
{
	private static wpdb $wpdb;

	public function __construct(){
		parent::__construct();
		global $wpdb;
		self::$wpdb = $wpdb;
		add_shortcode('wp-task', array(Model::class, 'taskmgr_manage'));
	}

	/** Create database table */
	public static function taskmgr_install() {
		$wptask_table = self::$wpdb->prefix . "tm_task";
		$wptask_query = "
		CREATE TABLE IF NOT EXISTS `$wptask_table` (
			id INT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
			created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			title TEXT NOT NULL ,
			`desc` TEXT NOT NULL ,
			`from` INT( 3 ) UNSIGNED NOT NULL ,
			`to` INT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
			deadline TIMESTAMP NOT NULL ,
			status TINYINT( 1 ) NOT NULL DEFAULT '1',
			priority TINYINT( 1 ) NOT NULL DEFAULT '1',
			PRIMARY KEY ( id )
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci";

		self::$wpdb->query($wptask_query);
	}

	/** Display user's nicename */
	public static function taskmgr_username($raw_id): string {
		$name = "Nobody";
		if($raw_id != '0') {
			$user = get_userdata($raw_id);
			if ($user) {
				$name = $user->display_name;
			}
		}
		return $name;
	}

	/** Display formatted date */
	public static function taskmgr_date($raw_date): string {
		if($raw_date != "0000-00-00 00:00:00") {
			return mysql2date(get_option('date_format'), $raw_date);
		}
		else return "Not set";
	}

	/** Display status (non-numeric) */
	public static function taskmgr_status($raw_status): string {
		switch ($raw_status) {
//			case 1: return "Open";
			case 2: return "Closed";
			default: return "Open";
		}
	}

	/** Display priority (non-numeric) */
	public static function taskmgr_priority($raw_priority): string {
		switch ($raw_priority) {
//			case 1: return "Low";
			case 2: return "High";
			default: return "Low";
		}
	}

	/** Check if role is allowed */
	public static function role_is_allowed(): bool {
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$target_roles = ['administrator', 'editor'];
		return count(array_intersect($roles, $target_roles)) > 0;
	}

	/** Record a new task */
	public static function taskmgr_addtask(array $newdata) {
		$wptask_table = self::$wpdb->prefix . "tm_task";
		$wptask_query = "INSERT INTO $wptask_table 
    	( title, `desc`, `from`, `to`, deadline, status, priority) 
    	VALUES ('$newdata[wptask_title]', '$newdata[wptask_description]', '$newdata[wptask_from]', '$newdata[wptask_to]', '$newdata[wptask_deadline]', '$newdata[wptask_status]', '$newdata[wptask_priority]')";
		self::$wpdb->query($wptask_query);
	}

	/** Update a task */
	public static function taskmgr_updatetask(array $newdata) {
		$wptask_table = self::$wpdb->prefix . "tm_task";
		$wptask_query = "UPDATE $wptask_table SET title='$newdata[wptask_title]', `desc`='$newdata[wptask_description]', `to`='$newdata[wptask_to]', deadline='$newdata[wptask_deadline]', status='$newdata[wptask_status]', priority='$newdata[wptask_priority]' WHERE id=$newdata[wptask_taskid]";
		self::$wpdb->query($wptask_query);
	}

	/** Delete a task */
	public static function taskmgr_deletetask(int $id) {
		if(isset($id)){
			$wptask_table = self::$wpdb->prefix . "tm_task";
			self::$wpdb->query("DELETE FROM $wptask_table WHERE id=$id");
			echo '<script>window.location.href="?page=wp-task"</script>';
		}
	}

	/** Create a task */
	public static function taskmgr_add() {
		require_once(parent::$plugin_path . 'templates/add_task.php');
	}

	/** Edit a task */
	public static function taskmgr_edit(int $id) {
		if(isset($id) && !empty($id)){
			$wptask_table = self::$wpdb->prefix . "tm_task";
			$wptask_edit_item = self::$wpdb->get_results("SELECT * FROM $wptask_table WHERE id=$id");
			if(!$wptask_edit_item) {
				echo'<div class="wrap"><h2>There is no such task to edit. Please add one first.</h2></div>';
			}
			else {
				require_once(parent::$plugin_path . 'templates/edit_task.php');
			}
		}
	}

	/** View a task */
	public static function taskmgr_view(int $id) {
		if(isset($id) && !empty($id)){
			$wptask_table = self::$wpdb->prefix . "tm_task";
			$wptask_view_item = self::$wpdb->get_results("SELECT * FROM $wptask_table WHERE id=$id");
			if(!$wptask_view_item) {
				echo'<div class="wrap"><h2>There is no such task to view. Please add one first.</h2></div>';
			}else{
				require_once parent::$plugin_path.'templates/view_task.php';
			}
		}
	}

	/** Admin CP manage page */
	public static function taskmgr_manage() {
		if(isset($_POST['wptask_addtask']) && isset($_POST['wptask_title'])) self::taskmgr_addtask($_POST);
		if(isset($_POST['taskmgr_updatetask'])) self::taskmgr_updatetask($_POST);
		if(isset($_POST['wptask_deletetask'])) self::taskmgr_deletetask($_POST['wptask_taskid']);

		if(isset($_GET['add'])) self::taskmgr_add();
		else if(isset($_GET['view'])) self::taskmgr_view($_GET['view']);
		else if(isset($_GET['edit'])) self::taskmgr_edit($_GET['edit']);
		else require_once parent::$plugin_path.'templates/all_tasks.php';
	}

	/** List tasks */
	public static function taskmgr_tasks(){
		$wptask_table = self::$wpdb->prefix . "tm_task";
		$wptask_manage_items = self::$wpdb->get_results("SELECT * FROM $wptask_table ORDER BY priority DESC");
		$wptask_counted = count($wptask_manage_items);
		$num = 0;
		while($num != $wptask_counted) { ?>
            <tr>
                <td><?php echo $wptask_manage_items[$num]->id; ?></td>
                <td>
                    <div class="d-flex justify-content-between">
                        <a href="?page=wp-task&view=<?php echo $wptask_manage_items[$num]->id; ?>" class="text-primary underline-on-hover">
							<?php echo $wptask_manage_items[$num]->title; ?>
                        </a>
                        <span>
			                <a href="?page=wp-task&edit=<?php echo $wptask_manage_items[$num]->id; ?>" class="btn btn-sm btn-warning">Edit</a>
			            </span>
                    </div>
                </td>
                <td><?php echo self::taskmgr_username((int)$wptask_manage_items[$num]->from); ?></td>
                <td><?php echo self::taskmgr_username((int)$wptask_manage_items[$num]->to); ?></td>
                <td><?php echo self::taskmgr_date($wptask_manage_items[$num]->created_at); ?></td>
                <td><?php echo self::taskmgr_date($wptask_manage_items[$num]->deadline); ?></td>
                <td><?php echo self::taskmgr_status($wptask_manage_items[$num]->status); ?></td>
                <td><?php echo self::taskmgr_priority($wptask_manage_items[$num]->priority); ?></td>
            </tr>
			<?php $num++;
		}
	}
}
