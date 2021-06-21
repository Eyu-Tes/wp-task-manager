<?php


namespace app\Base;


class Deactivate {
	public static function deactivate(){
		flush_rewrite_rules();
	}
}
