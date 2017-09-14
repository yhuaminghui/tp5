<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'inkad>';
    }

    public function home($name,$id)
    {
        dump(input('name'));
        return $id . $name;
//        return $_GET;
//        return input();
    }

    public function user()
    {
        $this->request->param('get.id');
//        return input('get.id');
    }
}
