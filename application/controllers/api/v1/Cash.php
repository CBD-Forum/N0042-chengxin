<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model("Cash_model");
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
        $amount = $this->input->post('amount');
        $amount = abs($amount);

        $to_user = $this->User_model->exist($to_phone);
        if(!isset($to_user->id) || $to_user->id != $to_user_id) {
            echo -2;
            exit;
        }
        $user_detail = $this->User_model->detail($user->id);
        $to_user_detail = $this->User_model->detail($to_user->id);

        //可用股金数量不足
        if($amount > $user_detail->cash_amount) {
            echo -3;
            exit;
        }

        //update user detail
        $user_detail->cash_amount -= $amount;
        $to_user_detail->cash_amount += $amount;
        $this->User_model->detail_update($user_detail);
        $this->User_model->detail_update($to_user_detail);

        //add share record
        $record = array();
        $record['user_id'] = $user->id;
        $record['amount'] = $amount;
        $record['type'] = 3;
        $record['created_at'] = time();
        $this->Cash_model->add_record($record);

        $record = array();
        $record['user_id'] = $to_user->id;
        $record['amount'] = $amount;
        $record['type'] = 4;
        $record['created_at'] = time();
        $this->Cash_model->add_record($record);

        echo 1;
        exit;

	}

}
