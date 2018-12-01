<?php
/**
 * Simple Router  --------------------------------------------------*
 * @category   Web Development
 * @package    Simple Router
 * @version    1.0
 * @copyright  2017-2018
 * @author     Elmarzougui Abdelghafour ( fb.com/devscript )
 */

namespace App\Controller;


class PostController
{


    public function index()
    {
         echo "News page";
    }

    public function show($id,$slug)
    {
         echo "im the article ID: $id ... SLUG: $slug";
    }

    public function set()
    {
        var_dump($_POST);

    }

}