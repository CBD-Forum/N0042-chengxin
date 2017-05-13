<?php

/**
 * Created by PhpStorm.
 * User: wangbaojian
 * Date: 15/10/23
 * Time: 上午10:01
 */
class Messg
{
    /**
     * 智能apikey
     */
    public $apikey = "96d0c193841f257943c6ac6c5bfbe352";

    /**
     * 发短信接口
     * @param string $text 短信内容
     * @param string $mobile 接受手机
     */
    public function send_sms($mobile, $content)
    {
        $content = '【数秦科技】' . $content;
        $url = "http://yunpian.com/v1/sms/send.json";
        $encoded_text = urlencode("$content");
        $mobile = urlencode("$mobile");
        $post_string = "apikey=" . $this->apikey . "&text=$encoded_text&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }

    /*
     * @param string $url 服务url地址
     * @param string $query 为请求串
     */
    protected function sock_post($url, $query)
    {
        $data = "";
        $info = parse_url($url);
        $fp = fsockopen($info["host"], 80, $errno, $errstr, 30);
        if (!$fp) {
            return $data;
        }
        $head = "POST " . $info['path'] . " HTTP/1.0\r\n";
        $head .= "Host: " . $info['host'] . "\r\n";
        $head .= "Referer: http://" . $info['host'] . $info['path'] . "\r\n";
        $head .= "Content-type: application/x-www-form-urlencoded\r\n";
        $head .= "Content-Length: " . strlen(trim($query)) . "\r\n";
        $head .= "\r\n";
        $head .= trim($query);
        $write = fputs($fp, $head);
        $header = "";
        while ($str = trim(fgets($fp, 4096))) {
            $header .= $str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp, 4096);
        }
        return $data;
    }
}