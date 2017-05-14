<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consume extends CI_Controller {

    public function detail()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        //获取用户地址
        $this->load->model("Address_model");
        $addresses = $this->Address_model->all($user->id);

        //获取用户详情
        $this->load->model("User_model");
        $user_detail = $this->User_model->detail($user->id);

        $data = array();
        $data['addresses'] = $addresses;
        $data['user_detail'] = $user_detail;
		$this->load->view('Consume/detail.html', $data);
    }

}
