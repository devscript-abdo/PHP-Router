<?php
/**
 * Simple Router  --------------------------------------------------*
 * @category   Web Development
 * @package    Simple Router
 * @version    1.0
 * @copyright  2017-2018
 * @author     Elmarzougui Abdelghafour ( fb.com/devscript )
 */
use App\Router\Router;
class Route
{


    public static function __callStatic($name, $arguments)
    {

        //$_GET['path']: the 'path' is a key defined in the .htacces file
        $router = new Router($_GET['path']);

        return call_user_func_array([$router,$name],$arguments);
    }


}