<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function vcode()
	{
        if(!is_cli()) {
            die("不是命令行执行");
        }

        $file_lock = "vcode_lock";
        if(file_exists($file_lock)) {
            die($file_lock."文件存在");
        }else {
            file_put_contents($file_lock, Date("Y-m-d H:i:s", time()));
        }

        $this->load->model("Vcode_model");
        $unsent_one = $this->Vcode_model->unsent_one();


        if($unsent_one) {
            $this->load->helper('juhe');
            $sendUrl = 'http://v.juhe.cn/sms/send';

            $smsConf = array(
                'key' => 'c2a5d95ed2f02d1442c8ae673192c991',
                'mobile' => $unsent_one->phone,
                'tpl_id' => '33593',
                'tpl_value' => '#code#='.$unsent_one->vcode
            );

            $content = juhecurl($sendUrl, $smsConf, 1);

            if($content) {
                $result = json_decode($content, true);
                $error_code = $result['error_code'];
                if($error_code == 0) {
                    echo "短信发送成功，短信ID：".$result['result']['sid'];
                    $ret = $this->db->update('vcode', array('status'=>1, 'updated_at'=>time()), "id=".$unsent_one->id);
                    var_dump($ret);
                }else {
                    $msg = $result['reason'];
                    echo "短信发送失败（".$error_code."）：".$msg;
                }
            }else {
                echo "请求短信发送失败";
            }

        }


        unlink($file_lock);
	}


}
