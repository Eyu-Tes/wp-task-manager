<?php

namespace app\Base;


class BaseController
{
	public static string $plugin_path;
	public static string $plugin_url;
	public static string $plugin;

	public function __construct(){
		self::$plugin_path = plugin_dir_path(PLUGIN_FILE_URL);
		self::$plugin_url = plugin_dir_url(PLUGIN_FILE_URL);
		self::$plugin = plugin_basename(PLUGIN_FILE_URL);
	}
}
