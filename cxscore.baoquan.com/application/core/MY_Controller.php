<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wangbaojian
 * Date: 15/10/22
 * Time: 下午10:01
 */
class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        ini_set('date.timezone','Asia/Shanghai');
        //$this->load->library('Logincloud');
       // $this->app_config();
    }

    private function app_config()
    {
        $this->load->library('app_config');
        $this->app_config->get_configs();
    }

    /**
     * 获取签名数据格式化
     * @return array
     */
    public function sign_data()
    {
        $sign = $this->input->get_post('sign');
        //app_output_json($sign);
        if(empty($sign)){
           
            app_output_json(array('code'=>0000,'msg'=>'Parameters is empty'));
        }
        $sign_key = base64_decode($sign);
        
        $sign_key = explode('&',$sign_key);
        $data = array();
        foreach($sign_key as $key=>$value){
            $arr = explode('=',$value);
            $data += array($arr[0] => $arr[1]);
        }
        return $data;
    }

    /**
     * 发送验证码
     * @param $phone
     * @return array
     */
    public function send_message($phone)
    {
        $verification = str_shuffle('1234567890');
        $rand = substr($verification,0,6);
        $msg = "您的验证码是".$rand;
        $this->load->library('messg');
        $data = $this->messg->send_sms($phone, $msg);
        return array('status'=>json_decode($data)->code,'code'=>$rand);
    }
   // json_decode($data)->code
    /**
     * 验证验证码
     * @param $param
     * @return int
     */
    public function verify_code($param =array())
    {
        $data = $this->Logincloud->searchBycode($param);
        if($data && $data['time'] >= time() - 1800){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 无操作数据请求接口验证KEY
     */
    public function verify_key()
    {
        $data = $this->sign_data();
        if(!isset($data['key']) || $data['key'] != KEY){
            app_output_json(array('code'=>0000,'msg'=>'key is empty or wrong'));
        }
    }

    /*有参数访问接口*/
    function request_post($url = '', $param = '') {
            if (empty($url) || empty($param)) {
                return false;
            }
            
            $postUrl = "http://192.168.3.87:3334/".$url;
            $curlPost['data'] = $param;


            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
            $data = curl_exec($ch);//运行curl
            curl_close($ch);

            return $data;
    }
}
