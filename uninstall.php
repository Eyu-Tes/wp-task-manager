<?php

if(! defined('WP_UNINSTALL_PLUGIN')){
	die;
}

global $wpdb;
$wptask_table = $wpdb->prefix . "task";
$tables = array($wptask_table);
foreach ($tables as $table) {
	$wpdb->query("DROP TABLE IF EXISTS $table");
}
