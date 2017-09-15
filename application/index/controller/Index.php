<?php
namespace app\index\controller;
use think\Db;
class Index
{
    public function index()
    {
        echo '测试github 的 webhooks';
//        添加数据
//        $rand = mt_rand(100000,999999);
//        $sql = [
//            'account'       =>  'root',
//            'password'      =>  'root',
//            'salf'          =>  $rand,
//            'encryption'    =>  sha1('root' . $rand)
//        ];
//        $model = Db::name('login')->insert($sql);
//        dump($model);
//        return '';
    }
}
