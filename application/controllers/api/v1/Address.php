<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Address_model');
    }

    public function add()
    {
        $user = $this->session->userdata('user');
        $user = json_decode($user);

        if(!isset($user->id)) {
            echo -1;
            exit;
        }

        $address = $this->input->post("address");
        $name = $this->input->post("name");
        $phone = $this->input->post("phone");

        $ret = $this->Address_model->add($user->id, $address, $name, $phone);

        echo $ret;

    }

}
