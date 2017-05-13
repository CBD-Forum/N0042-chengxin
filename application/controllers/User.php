<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

	public function index()
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
        $data['user_level_arr'] = array(
            '0'=>"普通会员",
            '1'=>"消费会员",
            '2'=>"初级代理商",
            '3'=>"中级代理商",
            '4'=>"高级代理商",
            '5'=>"分公司",
            '6'=>"总公司"
        );
		$this->load->view('User/index.html', $data);
	}


    public function detail($user_id=NULL)
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }

        if(!isset($user_id)) {
            $user_id = $user->id;
        }

        if(!$this->User_model->is_child($user->id, $user_id) && $user->id != $user_id) {
            echo "无权查看";
            exit;
        }

        $user = $this->User_model->get($user_id);
        $user_detail = $this->User_model->detail($user_id);

        $childs = $this->User_model->childs($user_id);
        foreach($childs as &$child) {
            $child_detail = $this->User_model->detail($child->id);

            $child->level = $child_detail->level;
        }


        $data = array();
        $data['user'] = $user;
        $data['user_detail'] = $user_detail;
        $data['user_level_arr'] = array(
            '0'=>"普通会员",
            '1'=>"消费会员",
            '2'=>"初级代理商",
            '3'=>"中级代理商",
            '4'=>"高级代理商",
            '5'=>"分公司",
            '6'=>"总公司"
        );
        $data['childs'] = $childs;
		$this->load->view('User/detail.html', $data);

    }

    public function login()
    {
        if($this->session->userdata('user')) {
            redirect('user/index');
        }

        $success_url = base_url()."user/index";
        $this->load->view('User/login.html', array("success_url"=>$success_url));
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login');
    }

    public function register()
    {
        $this->load->view('User/register.html');
    }

    public function success()
    {
        $this->load->view('User/success.html');
    }
}
