<?php


namespace app\Base;


class Activate {
	public static function activate() {
		flush_rewrite_rules();
		# initialize tables here
	}
}
