<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        $this->load->model("Product_model");
        $products = $this->Product_model->all();

        $data = array();
        $data['products'] = $products;
		$this->load->view('Home/home.html', $data);
	}

    public function cart()
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
		$this->load->view('Home/cart.html', $data);
    }

    public function score()
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
        $data['user'] = $user;
        $data['addresses'] = $addresses;
        $data['user_detail'] = $user_detail;
		$this->load->view('Home/score.html', $data);
    }

    public function consume()
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
        $data['user'] = $user;
        $data['addresses'] = $addresses;
        $data['user_detail'] = $user_detail;
		$this->load->view('Home/consume.html', $data);
    }
    public function news()
    {
        $data = array();
		$this->load->view('Home/news.html', $data);
    }
}
