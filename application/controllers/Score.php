<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Score extends CI_Controller {

    public function detail()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        //获取用户详情
        $this->load->model("User_model");
        $user_detail = $this->User_model->detail($user->id);

        $data = array();
        $data['user'] = $user;
        $data['user_detail'] = $user_detail;
		$this->load->view('Score/detail.html', $data);
    }
}
