<?php

namespace app\Menu;

use app\Base\Model;

class Admin
{
	public Setting $settings;
	public array $pages = array();

	public function __construct()
	{
		$this->settings = new Setting();
	}

	public function register()
	{
		$this->pages = array(
			array(
				'page_title' => __('Simple Task Manager', 'wptask'),
				'menu_title' => __('Task Manager', 'wptask'),
				'capability' => 'edit_posts',
				'menu_slug' => 'wp-task',
				'callback' =>  array(Model::class, 'taskmgr_manage'),
				'icon_url' =>  'dashicons-editor-ol',
				'position' =>  2
			)
		);
		$this->settings->AddPage($this->pages)->register();
	}
}
