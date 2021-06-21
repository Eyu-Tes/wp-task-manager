<?php


namespace app\Base;


class Activate {
	public static function activate() {
		flush_rewrite_rules();
		Model::taskmgr_install();
	}
}
