<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

	public function buy()
	{
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            echo -1;
            exit;
        }

        $stock_num = $this->input->post('stock_num');
        $stock_num = abs($stock_num);

        $this->load->model('User_model');
        $user_detail = $this->User_model->detail($user->id);

        //可用股金数量不足
        if($stock_num > $user_detail->share_free) {
            echo -1;
            exit;
        }

        //update user detail
        $user_detail->share_free -= $stock_num;
        $user_detail->stock_num += $stock_num;
        $this->User_model->detail_update($user_detail);

        //add share record
        $this->load->model("Share_model");
        $share_record = array();
        $share_record['user_id'] = $user->id;
        $share_record['num'] = $stock_num;
        $share_record['type'] = 6;
        $share_record['created_at'] = time();
        $this->Share_model->share_record($share_record);

        //add stock buy
        $this->load->model("Stock_model");
        $stock_buy = array();
        $stock_buy['user_id'] = $user->id;
        $stock_buy['stock_num'] = $stock_num;
        $stock_buy['status'] = 1;
        $stock_buy['created_at'] = time();
        $this->Stock_model->stock_buy($stock_buy);

        echo 1;
        exit;

	}

}
