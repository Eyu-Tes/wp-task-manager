<?php

namespace app\Base;


class Enqueue extends BaseController
{
	public function register(){
		//enqueue scripts in the admin panel
		add_action('admin_enqueue_scripts', array($this, 'enqueue'),9999);

		//enqueue scripts in the frontend
		add_action('wp_enqueue_scripts', array($this, 'enqueue'),9999);
	}

	public function enqueue(){
		//css stylesheets
		wp_enqueue_style('tm_fa_style', parent::$plugin_url.'assets/fontawesome/css/all.min.css');
		wp_enqueue_style('tm_bt_style', parent::$plugin_url.'assets/bootstrap/bootstrap.min.css');
		wp_enqueue_style('tm_mdb_style', parent::$plugin_url.'assets/mdb/css/mdb.min.css');
		wp_enqueue_style('tm_dt_style', parent::$plugin_url.'assets/mdb/css/addons/datatables.min.css');
		wp_enqueue_style('tm_jui_style', parent::$plugin_url . 'assets/mdb/css/addons/jquery-ui.min.css');
		wp_enqueue_style('tm_cu_style', parent::$plugin_url . 'assets/custom/style.css');

		//js scripts
		wp_enqueue_script('tm_p_script', parent::$plugin_url . 'assets/bootstrap/popper.min.js', false, false, true);
		wp_enqueue_script('tm_bt_script', parent::$plugin_url.'assets/bootstrap/bootstrap.min.js', array('jquery', 'jquery-ui-dialog'), false, true);
		wp_enqueue_script('tm_mdb_script', parent::$plugin_url.'assets/mdb/js/mdb.min.js', false, false, true);
		wp_enqueue_script('tm_dt_script', parent::$plugin_url.'assets/mdb/js/addons/datatables.min.js', false, false, true);
		wp_enqueue_script('tm_cu_script', parent::$plugin_url . 'assets/custom/script.js', false, false, true);
	}
}
