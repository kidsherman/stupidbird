<?php
/**
 * 微信公众平台-文本回复功能源代码
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-09
 */

//引入回复文本的函数文件
require_once 'responseText.func.inc.php';
require_once 'responseNews.func.inc.php';

//define your token
define("TOKEN", "stupidbird");
$wechatObj = new wechat();
$wechatObj->responseMsg();
$wechatObj->valid();

class wechat
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE) {
                case "text":
                    $resultStr = $this->handleText($postObj);
                    break;
                case "event":
                    $resultStr = $this->handleEvent($postObj);
                    break;
                default:
                    $resultStr = "Unknow msg type: " . $RX_TYPE;
                    break;
            }
            echo $resultStr;
        } else {
            echo "";
            exit;
        }
    }

    public function handleText($postObj)
    {
        $keyword = trim($postObj->Content);


        if (strcmp((string )$postObj->FromUserName, "o_NPejsr4C13G3xFZaSfRSqU03Tk") == 0) {
            if (!empty($keyword)) {
                $record = array(
                    'title' => "今日销售简报" . "\n" . "___________________________________" . "\n" .
                        "微信接口测试，您看到了请果断无视",
                    //'title' =>'今日销售简报'.'\n'.'___________________'.'\n'.'（微信接口测试，您看到了请果断无视）',
                    'description' => '今日销售iphone 6 3台，oppo 1台，vivo 1台，小米 1台，充电宝 1个,...详情请点击',
                    'picUrl' => 'http://d3.freep.cn/3tb_1505121823458ynp550081.jpg',
                    'url' => 'http://stupidbird.gotoip55.com/report.html');

                $resultStr = _response_news($postObj, $record);
                echo $resultStr;
            } else {
                echo "Input something...";
            }
        } else {
            if (!empty($keyword)) {
                $contentStr = "感谢你的回复！老臭虫正在调试微信API接口，所以回复的信息对您来说暂时没有什么意义，您就当帮我测试了：）";
                //$contentStr = "aaa".$postObj->FromUserName."aaa";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                $resultStr = _response_text($postObj, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }

        }
    }


    public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event) {
            case "subscribe":
                $contentStr = "感谢您关注老臭虫" . "\n" . "-----------------------------" . "\n" .
                    "请君看取百年事,业就扁舟泛五湖";
                break;
            default:
                $contentStr = "Unknow Event: " . $object->Event;
                break;
        }
        $resultStr = _response_text($object, $contentStr);
        return $resultStr;
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}

?>