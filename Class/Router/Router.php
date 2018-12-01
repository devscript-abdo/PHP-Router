<?php

namespace App\Router;

/**
 * Simple Router  --------------------------------------------------*
 * @category   Web Development
 * @package    Simple Router
 * @version    1.0
 * @copyright  2017-2018
 * @author     Elmarzougui Abdelghafour ( fb.com/devscript )
 */
class Router
{


    private $url;

    private static $routes = [];

    private $namedRoutes =[];

    protected  $errors;

    public function __construct($url)
    {
        $this->url = $url;

    }

    public function get($path,$callable,$NameOfRoute = null)
    {

        return $this->add($path,$callable,$NameOfRoute,'GET');
    }

    public function post($path,$callable,$NameOfRoute = null)
    {

        return $this->add($path,$callable,$NameOfRoute,'POST');
    }

    private function add($path,$callable,$NameOfRoute,$method)
    {
        $route = new Route($path,$callable);

        self::$routes[$method][] = $route;

        if(is_array($callable) && $NameOfRoute===null)
        {
            $NameOfRoute = $callable['name'];
        }
        if($NameOfRoute)
        {
            $this->namedRoutes[$NameOfRoute] = $route;

        }
        return $route;
    }

    public function run()
    {

        if(!isset(self::$routes[$_SERVER['REQUEST_METHOD']]))
        {

            throw new RouterException('REQUEST_METHOD NOT exist');
        }

        foreach (self::$routes[$_SERVER['REQUEST_METHOD']] as  $route)
        {

            if($route->match($this->url)) {

                return $route->call();
            }
        }
        throw new RouterException('no matching routes');
    }

    public function url($name,$params=[])
    {
        if(!isset($this->namedRoutes[$name]))
        {
            throw new RouterException('no routes match this name');
        }
        return  $this->namedRoutes[$name]->getUrl($params);

    }

}