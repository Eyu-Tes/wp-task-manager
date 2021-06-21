<?php
/*
Plugin Name: Simple Task Manager
*/

defined('ABSPATH') or die('You cannot access this resource!');

// define constant
const PLUGIN_FILE_URL = __FILE__;

// hide admin toolbar from frontend
add_filter('show_admin_bar', '__return_false');
