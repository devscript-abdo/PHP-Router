<?php
/**
 * Simple Router  --------------------------------------------------*
 * @category   Web Development
 * @package    Simple Router
 * @version    1.0
 * @copyright  2017-2018
 * @author     Elmarzougui Abdelghafour ( fb.com/devscript )
 */

namespace App\Router;


/**
 * Class Route
 * @package App\Router
 */
class Route
{


    protected $path;

    protected $callable;

    protected $matches = [];

    protected $params = [];


    public function __construct($path,$callable)
    {

        $this->path     = trim($path,'/');
        $this->callable = $callable;

    }

    public function IsMatch($param,$regx)
    {

        $this->params[$param]= str_replace('(','(?:', $regx);

        return $this;

    }


    public function match($url)
    {

        $url = trim($url,'/');


        $path = preg_replace_callback('#{([\w]+)}#',[$this,'paramMatch'],$this->path);
        $regx ="#^$path$#i";


        if(!preg_match($regx,$url,$matches))
        {
            return false;
        }

        array_shift($matches);

        $this->matches = $matches;

        return true;
    }

    private  function paramMatch($match)
    {

        if(isset($this->params[$match[1]]))
        {

            return '(' . $this->params[$match[1]]. ')';
        }

        return '([^/]+)';
    }


    public function call()
    {
        if(is_string($this->callable))
        {
            $params = explode('@',$this->callable);

            // $params[0] in this case is the name of the Controller :)
            //
            // ex: PostContoller@index == PostContoller=$params[0]
            // index=$params[1]


            $controller = "App\\Controller\\".$params[0];

            $controller = new $controller();

            return call_user_func_array([$controller,$params[1]],$this->matches);

        }
        if(is_array($this->callable))
        {
            if(!array_key_exists('controller',$this->callable))
            {
                throw new RouterExceptionCallableKey("Sorry this key ['controller'] not Found");
            }


            if(!array_key_exists('action',$this->callable))
            {

                throw new RouterExceptionCallableKey("Sorry this key ['action'] not Found");
            }

            $controller = "App\\Controller\\".$this->callable['controller'];

            if(class_exists($controller))
            {
                $controller = new $controller();

                if(!method_exists($controller,$this->callable['action']))
                {
                    unset($controller);

                    throw new RouterExceptionMethod("Sorry this method : ".'['.$this->callable['action'].']'."  not exits in this controller");
                }
                return call_user_func_array([$controller,$this->callable['action']],$this->matches);

            }

        }

    }
    public function getUrl($params)
    {
        $path = $this->path;

        foreach ($params as $k => $v)
        {
            $path = str_replace("{$k}",$v,$path);
        }
        return $path;
    }

}