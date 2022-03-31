<?php
/**
 * This file route configuration for the application.
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Orkhan Shafizada
 */

namespace App\Core;

class Route
{

    /**
     * @var array[]
     */
    private static $routes = [
        'GET'   => [],
        'POST'  => []
    ];


    /**
     * @param $route
     * @param $action
     * @return void
     */
    public static function get($route , $action )
    {
        self::$routes['GET'][ trim( $route , '/' ) ] =  $action;
    }


    /**
     * @param $route
     * @param $action
     * @return void
     */
    public static function post($route, $action )
    {
        self::$routes['POST'][ trim( $route , '/' ) ] =  $action;
    }


    /**
     * @return array[]
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }


    /**
     * @return void
     */
    public static function dispatch()
    {
        $routes = self::getRoutes();
        $request_type = $_SERVER['REQUEST_METHOD'];
        $routes = $routes[ $request_type ] ?? [];

        if (self::cleanUrl()) {
            $url = explode(self::cleanUrl(), $_SERVER['REQUEST_URI']);
            $route_path = trim( $url[1], '/' );
        }else{
            $route_path = trim( $_SERVER['REQUEST_URI'], '/' );
        }
        $route = $routes[ $route_path ] ?? [];

        if( count( $route ) == 0 ) {
            header("HTTP/1.0 404 Not Found");
            die('Route not found');
        }
        $controller = $route[ 0 ];
        $action     = $route[ 1 ];

        if( !method_exists( $controller, $action ))
        {
            header("HTTP/1.0 404 Not Found");
            die( $controller . '::' . $action . ' method not found');
        }
        $request_object = (object) $_REQUEST;
        unset( $request_object->route );

        call_user_func_array( [ (new $controller), $action ], [ $request_object ]);
    }

    protected static function cleanUrl(){
        $url = explode('localhost', $_ENV['APP_URL']);

        return $url[1];
    }
}
