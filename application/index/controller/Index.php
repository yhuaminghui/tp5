<?php
namespace app\index\controller;
use think\Db;
use think\Loader;
use think\Validate;
use think\captcha\Captcha;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
//       /* $config =    [
//            // 验证码字体大小
//            'fontSize'    =>    20,
//            // 验证码位数
//            'length'      =>    5,
//            // 关闭验证码杂点
//            'useNoise'    =>    false,
//            'useZh'       =>    true,
//            'zhSet'       =>    '们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这'
//        ];
//        $captcha = new Captcha($config);
//        return $captcha->entry();*/
//        $captcha = new \think\captcha\Captcha();
//        return $captcha->entry(2);
//        return $captcha->entry(1);
//        return view();

//        $data = [
//            'name'  =>  '12345678912345632132123123789',
//            'email' =>  '12345612.com'
//        ];
////        $validate = Loader::validate('User');
//        $validate = validate('User');
//        if (!$validate->check($data)) {
//            dump($validate->getError());
//        }else{
//            dump('验证成功');
//        }

//        $time = time();
//        echo $time;
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
        return view();
    }

    public function verify()
    {
        // 循环制
        /*
         * 初始化前两个参数为1，其中定义数组来做的原因是方便理解
         * 循环开始，以下标为2开始处理
         * 不断往数组中添加，当前循环次数的下表对应的值是前两个值得和
         */
//        $array = array();
//        $array[0] = 1;
//        $array[1] = 1;
//        for($i=2;$i<10;$i++){
//            $array[$i] = $array[$i-1]+$array[$i-2];
//        }
//        print_r($array);

        // 1 1 2 3 5 8 13 21 34 55
        /*
         * 递归处理
         * 定义结束递归的条件，由于费波纳奇数列开始的两个值是1，由此可推断第1个值与第二个值得时候就是1，
         * 那么当想获取第一个与第二个斐波那契数的时候直接返回1
         * 将第N个斐波那契数减一加上第N个减二斐波那契数依次递归即可
         *
         */
        $n = 6;
        $result = $this->get($n);
        dump($result);
    }
    public function get($n)
    {
        if($n === 2 || $n === 1) return 1;
        return $this->get($n - 1) + $this->get($n-2);
    }

}
