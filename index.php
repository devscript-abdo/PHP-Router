<?php

/**
 * Simple Router  --------------------------------------------------*
 * @category   Web Development
 * @package    Simple Router
 * @version    1.0
 * @copyright  2017-2018
 * @author     Elmarzougui Abdelghafour ( fb.com/devscript )
 */
require 'vendor/autoload.php';

// This Class is for Call static
// Router::get() : in realy mode is $router->get();
require 'Route.php';


// in this cas we use the CallBack as Array :)
Route::get('/',['controller'=>'HomeController','action'=>'index'],'home');


// in this cas we use the CallBack as String and we Exploded by the '@' :)

//Route::get('/','HomeController@index');



Route::get('/posts/{id}/{slug}','PostController@show')

    ->IsMatch('id','[0-9]+')

    ->IsMatch('slug','[a-z]+');

/*Route::get('posts/{id}/{slug}',

    [
        'name'=>'post.single',
        'controller'=>'PostController',
        'action'=>'show'
    ]);

Route::post('posts/{id}/{slug}',

    [
        'name'=>'post.set',
        'controller'=>'PostController',
        'action'=>'set'
    ]);
*/
Route::run();