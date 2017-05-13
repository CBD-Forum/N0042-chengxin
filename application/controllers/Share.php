<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Share_model');
        $this->load->model('User_model');
    }

    public function record()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect(base_url('user/login'));
        }

        $records = $this->Share_model->get_record_by_user_id($user->id);

        $data = array();
        $data['records'] = $records;
        $data['record_type_arr'] = array(
            '0'=>"报单冻结",
            '1'=>"原始股冻结",
            '2'=>"释放",
            '3'=>"转出",
            '4'=>"转入",
            '5'=>"购买",
            '6'=>"股权申购扣除"
        );
        $this->load->view('Share/record.html', $data);
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
		$this->load->view('Share/transfer.html', $data);
    }

    public function transfer_success()
    {
        $data = array();
        $this->load->view('Share/transfer_success.html', $data);
    }

    public function buy()
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

        $this->load->view('Share/buy.html', $data);
    }

    public function buy_success()
    {
        $data = array();
        $this->load->view('Share/buy_success.html', $data);
    }

}
