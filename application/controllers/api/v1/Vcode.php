<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcode extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vcode_model');
        $this->load->helper('juhe');
    }

	public function generate()
	{
        $phone = $this->input->post('phone');

        $vcode_last = $this->Vcode_model->last($phone);
        //一小时内只发送一次
        if(isset($vcode_last->created_at) && $vcode_last->created_at > time()-3600) {
            echo -1;
        }else {
            $vcode = rand(100000, 999999);
            $ret = $this->Vcode_model->create($phone, $vcode);
            echo $ret ? 1 : 0;
        }
	}

    public function test()
    {
        echo hash("sha256", 12);
        exit;

        header('content-type:text/html;charset=utf-8');

        $sendUrl = 'http://v.juhe.cn/sms/send';

        $smsConf = array(
            'key' => 'c2a5d95ed2f02d1442c8ae673192c991',
            'mobile' => "18858261398",
            'tpl_id' => '33593',
            'tpl_value' => '#code#=1234'
        );

        $content = juhecurl($sendUrl, $smsConf, 1);

        if($content) {
            $result = json_decode($content, true);
            $error_code = $result['error_code'];
            if($error_code == 0) {
                echo "短信发送成功，短信ID：".$result['result']['sid'];
            }else {
                $msg = $result['reason'];
                echo "短信发送失败（".$error_code."）：".$msg;
            }
        }else {
            echo "请求短信发送失败";
        }
    }

}
