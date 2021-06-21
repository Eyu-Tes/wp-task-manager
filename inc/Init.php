<?php


namespace app;


use app\Base;

final class Init
{
	private static function get_services(): array {
		// return class names with namespaces
		return [
			Base\Enqueue::class,
			Base\Model::class
		];
	}

	public static function register_services(){
		foreach( self::get_services() as $class){
			$service = self::instantiate( $class );
			if( method_exists($service, 'register') ){
				$service->register();
			}
		}
	}

	private static function instantiate( $class ){
		return new $class();
	}
}
