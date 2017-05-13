<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function buy()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            echo -1;
            exit;
        }

        $user_detail = $this->User_model->detail($user->id);

        $num = $this->input->post('num');
        $cash = $num/10000*6000;
        if($num <=0 || $cash > $user_detail->cash_amount) {
            echo -2;
            exit;
        }

        //修改用户账户
        $user_detail->cash_amount -= $cash;
        $user_detail->share_free += $num;
        $this->User_model->detail_update($user_detail);

        //添加股金流水
        $this->load->model("Share_model");
        $share_record = array();
        $share_record['user_id'] = $user->id;
        $share_record['num'] = $num;
        $share_record['type'] = 5;
        $share_record['created_at'] = time();
        $this->Share_model->share_record($share_record);


        echo 1;
        exit;

    }

	public function transfer()
	{
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            echo -1;
            exit;
        }

        $to_user_id = $this->input->post('to_user_id');
        $to_phone = $this->input->post('to_phone');
        $share_num = $this->input->post('share_num');
        $share_num = abs($share_num);

        $to_user = $this->User_model->exist($to_phone);
        if(!isset($to_user->id) || $to_user->id != $to_user_id) {
            echo -2;
            exit;
        }
        $user_detail = $this->User_model->detail($user->id);
        $to_user_detail = $this->User_model->detail($to_user->id);

        //可用股金数量不足
        if($share_num > $user_detail->share_free) {
            echo -3;
            exit;
        }

        //update user detail
        $user_detail->share_free -= $share_num;
        $to_user_detail->share_free += $share_num;
        $this->User_model->detail_update($user_detail);
        $this->User_model->detail_update($to_user_detail);

        //add share record
        $this->load->model("Share_model");
        $share_record = array();
        $share_record['user_id'] = $user->id;
        $share_record['num'] = $share_num;
        $share_record['type'] = 3;
        $share_record['created_at'] = time();
        $this->Share_model->share_record($share_record);

        $share_record = array();
        $share_record['user_id'] = $to_user->id;
        $share_record['num'] = $share_num;
        $share_record['type'] = 4;
        $share_record['created_at'] = time();
        $this->Share_model->share_record($share_record);

        echo 1;
        exit;

	}

}
