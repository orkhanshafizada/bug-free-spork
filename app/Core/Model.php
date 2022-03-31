<?php
/**
 * This file model configuration for the application.
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Orkhan Shafizada
 */
namespace App\Core;

class Model extends QueryBuilder
{
    /**
     * @var null
     */
    protected static $table = null;
    /**
     * @var
     */
    protected $conn;


    /**
     * @param $name
     * @param $arguments
     * @return false|mixed|void
     */
    public static function __callStatic($name, $arguments)
	{
		$m = new QueryBuilder( static::class );
		if( method_exists( $m, $name ) )
		{
			return call_user_func_array( [$m, $name], $arguments );
		}
	}
}