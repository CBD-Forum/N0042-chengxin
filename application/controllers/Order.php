<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function index()
	{
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            redirect('user/login');
        }
        $this->load->model('Order_model');
        $orders = $this->Order_model->getByUserID($user->id);
        $data = array();
        $data['orders'] = $orders;
        $data['order_status_arr'] = array(
            '0'=>"待发货",
            '1'=>"已发货"
        );
		$this->load->view('Order/index.html', $data);
	}

	public function success()
	{
        $data = array();
		$this->load->view('Order/success.html', $data);
	}

}
