<?php
namespace app\index\controller\v1;

class Index
{
    public function index($version)
    {
        return $version;
    }
}