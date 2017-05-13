<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Vcode_model');
    }

	public function check()
	{

	}

    public function register()
    {
        $phone = $this->input->post('phone');
        $vcode = $this->input->post('vcode');
        $password = $this->input->post('password');
        $parent = $this->input->post('parent');

        $vcode_last = $this->Vcode_model->check($phone, $vcode);

        if(isset($vcode_last->created_at)) {
            if($vcode_last->created_at > time()-3600) {
                if($this->User_model->exist($phone)) {
                    echo -3;
                }else {
                    $ret = $this->User_model->create($phone, $password, $parent);
                    echo $ret ? 1: 0;
                }
            }else {
                //验证码过期
                echo -2;
            }
        }else {
            //验证码不正确
            echo -1;
        }
    }

    public function login()
    {
        $phone = $this->input->post("phone");
        $password = $this->input->post("password");

        $user = $this->User_model->check($phone, $password);

        if($user) {
            $this->session->set_userdata('user', json_encode($user));
            echo 1;
        }else {
            echo 0;
        }



    }
}
