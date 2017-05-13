<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Cash_model");
    }

    public function recharge()
    {
        //从session中获取用户信息
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        //获取用户详情
        $user_detail = $this->User_model->detail($user->id);

        $data = array();
        $data['user'] = $user;
        $data['user_detail'] = $user_detail;
		$this->load->view('Cash/recharge.html', $data);
    }

    public function record()
    {
        //从session中获取用户信息
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        $records = $this->Cash_model->records($user->id);

        $data['records'] = $records;
        $data['record_type_arr'] = array(
            '0'=>"其他",
            '1'=>"充值",
            '2'=>"提现",
            '3'=>"转出",
            '4'=>"转入",
            '5'=>"分红",
            '6'=>"推广奖励",
            '7'=>"市场奖励",
            '8'=>"管理奖励",
            '9'=>"服务奖励",
            '10'=>"购买股金"
        );
        $this->load->view('Cash/record.html', $data);
    }

    public function transfer()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        $user_detail = $this->User_model->detail($user->id);

        $data = array();
        $data['user'] = $user;
        $data['user_detail'] = $user_detail;
		$this->load->view('Cash/transfer.html', $data);
    }

    public function transfer_success()
    {
        $this->load->view('Cash/transfer_success.html');
    }

    public function withdraw()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        $user_detail = $this->User_model->detail($user->id);

        $data = array();
        $data['user'] = $user;
        $data['user_detail'] = $user_detail;
		$this->load->view('Cash/withdraw.html', $data);
    }

}
