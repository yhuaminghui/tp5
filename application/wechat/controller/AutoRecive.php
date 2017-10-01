<?php
namespace app\wechat\Controller;

/**
 * 首页
 */
define("TOKEN", "wo1tian3chi");//定义你公众号自己设置的token
define("APPID", "");//填写你微信公众号的appid 千万要一致啊
define("APPSECRET", "");//填写你微信公众号的appsecret  千万要记得保存 以后要看的话就只有还原了  保存起来 有益无害
class AutoRecive
{
    //判断是介入还是用户  只有第一次介入的时候才会返回echostr
    function index()
    {
        //这个echostr呢  只有说验证的时候才会echo  如果是验证过之后这个echostr是不存在的字段了


            if ($str = $this->checkSignature()) {
                //如果你不知道是否验证成功  你可以先echo echostr 然后再写一个东西
                if($str){
                    echo $str;
                    exit;
                }
            }else{
                $postObj = $GLOBALS["HTTP_RAW_POST_DATA"];
                $postObj = simplexml_load_string($postObj, 'SimpleXMLElement', LIBXML_NOCDATA);
                // 判断类型
                $msgType = $postObj->MsgType;
                file_put_contents('/www/test.log',$msgType);
                switch($msgType)
                {
                    case 'text':
                        $this->seedText($postObj);
                        break;
                    case 'image':
                        $this->seedImage($postObj);
                        break;
                    case 'voice':
                        $this->seedAudio($postObj);
                        break;
                    default :
                        $this->seedDefault();
                        break;
                }
                exit;
        }
    }

    //验证微信开发者模式接入是否成功
    private function checkSignature()
    {
        $echostr = isset($_GET['echostr'])?$_GET['echostr']:'';
        //signature 是微信传过来的 类似于签名的东西
        $signature = $_GET["signature"];
        //微信发过来的东西
        $timestamp = $_GET["timestamp"];
        //微信传过来的值  什么用我不知道...
        $nonce     = $_GET["nonce"];
        //定义你在微信公众号开发者模式里面定义的token
        $token  = TOKEN;
        //三个变量 按照字典排序 形成一个数组
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        //哈希加密  在laravel里面是Hash::
        $tmpStr = sha1($tmpStr);
        //按照微信的套路 给你一个signature没用是不可能的 这里就用得上了
        if ($tmpStr == $signature  && $echostr) {
            return $echostr;
        } else {
            return false;
        }
    }

    //构建一个发送请求的curl方法  微信的东西都是用这个 直接百度
    function https_request($url, $data = null)
    {
        //这个方法我不知道是怎么个意思  我看都是这个方法 就copy过来了
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    // 文本消息被动回复
    public function seedText($postObj = [])
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $msgType = $postObj->MsgType;
        $time = time();

        $textTpl = "<xml>  
                            <ToUserName><![CDATA[%s]]></ToUserName>  
                            <FromUserName><![CDATA[%s]]></FromUserName>  
                            <CreateTime>%s</CreateTime>  
                            <MsgType><![CDATA[%s]]></MsgType>  
                            <Content><![CDATA[%s]]></Content>  
                            <FuncFlag>0</FuncFlag>  
                            </xml>";
        switch ($keyword)
        {
            case '马化腾':
                $contentStr = '马化腾创建了腾讯帝国！';
                break;
            case '马云':
                $contentStr = '马云创建了阿里巴巴帝国！';
                break;
            default :
                $contentStr = '输入：马化腾，或者马云试试';
                break;
        }

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
    }

    // 图片消息被动回复
    public function seedImage($postObj = [])
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $MediaId = $postObj->MediaId;
        $msgType = $postObj->MsgType;
        $time = time();

        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Image>
            <MediaId><![CDATA[%s]]></MediaId>
            </Image>
            </xml>";

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$MediaId);

        echo $resultStr;
    }

    // 语音消息被动回复
    public function seedAudio($postObj = [])
    {
        $toUserName = $postObj->FromUserName;
        $fromUserName = $postObj->ToUserName;
        $time = time();
        $msgType = $postObj->MsgType;
        $mediaId = $postObj->MediaId;
        $recognition = $postObj->Recognition;

        file_put_contents('/www/test.log',$recognition);
        if(strpos($recognition,'借钱') !== false || strpos($recognition,'借点钱') !== false )
        {
            $toUsername = $postObj->FromUserName;
            $fromUsername = $postObj->ToUserName;
            $time = time();

            $textTpl = "<xml>  
                            <ToUserName><![CDATA[%s]]></ToUserName>  
                            <FromUserName><![CDATA[%s]]></FromUserName>  
                            <CreateTime>%s</CreateTime>  
                            <MsgType><![CDATA[%s]]></MsgType>  
                            <Content><![CDATA[%s]]></Content>  
                            <FuncFlag>0</FuncFlag>  
                            </xml>";
            $resultStr = sprintf($textTpl,$toUsername, $fromUsername, $time, 'text', '啥，你说啥，信号不好');
        }else{
            $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Voice>
            <MediaId><![CDATA[%s]]></MediaId>
            </Voice>
            </xml>";

            $resultStr = sprintf($textTpl,$toUserName,$fromUserName,$time,$msgType,$mediaId);
        }

        echo $resultStr;
    }

    // 发送默认信息
    public function seedDefault($postObj = [])
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $msgType = $postObj->MsgType;
        $time = time();

        $textTpl = "<xml>  
                            <ToUserName><![CDATA[%s]]></ToUserName>  
                            <FromUserName><![CDATA[%s]]></FromUserName>  
                            <CreateTime>%s</CreateTime>  
                            <MsgType><![CDATA[%s]]></MsgType>  
                            <Content><![CDATA[%s]]></Content>  
                            <FuncFlag>0</FuncFlag>  
                            </xml>";

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $msgType . ':类型暂不支持');
        echo $resultStr;
    }
}