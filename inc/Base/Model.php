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
}
