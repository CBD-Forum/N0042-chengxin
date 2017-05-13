<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function add()
	{
        $user = $this->session->userdata('user');
        $user = json_decode($user);
        if(!isset($user->id)) {
            echo -1;
            exit;
        }

        $num1 = $this->input->post('num1');
        $num2 = $this->input->post('num2');
        $address_id = $this->input->post('address_id');
        $address_id = intval(substr($address_id,1));
        if($address_id<=0) {
            echo -4;
            exit;
        }
        $this->load->model('Address_model');
        $address = $this->Address_model->getByID($address_id);
        if(!$address || !isset($address->user_id) || $address->user_id != $user->id) {
            echo -5;
            exit;
        } 

        $amount = $num1*1500 + $num2*2000;
        if($amount<=0 || $amount%6000!=0) {
            echo -2;
            exit;
        }

        $this->load->model('User_model');
        $user_detail = $this->User_model->detail($user->id);

        //资金余额不足
        if($num1*1500+$num2*2000>$user_detail->cash_amount) {
            echo -3;
            exit;
        }

        //修改用户账户数据
        $user_detail->cash_amount = $user_detail->cash_amount - $amount;
        $user_detail->order_num = $user_detail->order_num + 1;
        $user_detail->order_sum = $user_detail->order_sum + $amount;
        $user_level_change = false;
        if($user_detail->level == 0 && $amount >= 6000) {
            $user_detail->level = 1;
            $user_level_change = true;
        }
        $user_detail->share_frozen += $amount/6000*10000;
        $this->User_model->detail_update($user_detail);

        //添加订单记录
        $order = array();
        $order['user_id'] = $user->id;
        $detail = array();
        if($num1>0) {
            array_push($detail, array(base_url('images/product11.png'), "三花牌口服液", "1500", $num1));
        }
        if($num2>0) {
            array_push($detail, array(base_url('images/product12.png'), "白藜芦醇果汁", "2000", $num2));
        }
        $order['detail'] = json_encode($detail);
        $order['amount'] = $amount;
        $order['address_id'] = $address->id;
        $order['address'] = $address->address;
        $order['name'] = $address->name;
        $order['phone'] = $address->phone;
        $order['created_at'] = time();
        $this->load->model("Order_model");
        $this->Order_model->add($order);

        //添加股金表记录
        $this->load->model("Share_model");
        $share = array();
        $share['user_id'] = $user->id;
        $share['frozen'] = $amount/6000*10000;
        $share['interval'] = $amount/6000*10000/100;
        $share['created_at'] = time();
        $share_id = $this->Share_model->add($share);

        //添加股金记录表记录
        $share_record = array();
        $share_record['user_id'] = $user->id;
        $share_record['num'] = $amount/6000*10000;
        $share_record['type'] = 0;
        $share_record['note'] = $share_id;
        $share_record['created_at'] = time();
        $this->Share_model->share_record($share_record);


        //修改父节点数据
        $parent_user = $this->User_model->get($user->p_id);
        $i = 1;
        $j = 1;
        while($parent_user) {
            $parent_detail = $this->User_model->detail($parent_user->id);

            //直推消费会员数量
            if($i == 1 && $user_level_change==true && $amount>=6000) {
                $parent_detail->consumer_num++;
            }

            //团队业绩
            $parent_detail->team_sum += $amount;

            //变为初级代理商
            if($parent_detail->consumer_num>=5 && $parent_detail->team_sum >= 200000 && $parent_detail->level<2) {
                $parent_detail->level = 2;
            }

            //变为中级代理商
            
            //更新父节点数据
            $this->User_model->detail_update($parent_detail);

            $i++;
            $user = $parent_user;
            $parent_user = $this->User_model->get($parent_user->p_id);
        }


        echo 1;

	}

}
