<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Config_model');
        $this->load->model('Stock_model');
    }

	public function buy()
	{
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        $user_detail = $this->User_model->detail($user->id);
        $stock_config = $this->Config_model->get_by_name("stock_num_allow");

        $data = array();
        $data['user'] = $user;
        $data['user_detail'] = $user_detail;
        $data['stock_num_allow'] = $stock_config->value;
		$this->load->view('Stock/buy.html', $data);
	}

    public function success()
    {
        $this->load->view('Stock/success.html');
    }

    public function buy_list()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        $stock_buy_arr = $this->Stock_model->buy_list($user->id);

        $data = array();
        $data['user'] = $user;
        $data['stock_buy_arr'] = $stock_buy_arr;
        $data['status_arr'] = array(
            '0' => "申购中",
            '1' => "申购完成"
        );
        $this->load->view('Stock/buy_list.html', $data);
    }

}
