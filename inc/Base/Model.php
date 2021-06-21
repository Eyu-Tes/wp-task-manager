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

	/** Manage pages */
	public static function taskmgr_manage() {
		require_once parent::$plugin_path.'templates/admin.php';
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
