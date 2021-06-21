<?php
/*
Plugin Name: Simple Task Manager
*/

defined('ABSPATH') or die('You cannot access this resource!');

if(file_exists(__DIR__.'/vendor/autoload.php')){
	require_once __DIR__.'/vendor/autoload.php';
}

// define constant
const PLUGIN_FILE_URL = __FILE__;

use app\Base\Activate;
use app\Base\Deactivate;

//activate plugin
function activate_taskmgr() {
	Activate::activate();
}
register_activation_hook(PLUGIN_FILE_URL, 'activate_taskmgr');

//deactivate plugin
function deactivate_taskmgr(){
	Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_taskmgr' );

// hide admin toolbar from frontend
add_filter('show_admin_bar', '__return_false');
