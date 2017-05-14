<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Miner extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vcode_model');
        $this->load->helper('sys');
        $this->load->library('fabric-sdk-php/orderer');
        $this->load->library('fabric-sdk-php/peer');
        $this->load->library('fabric-sdk-php/chain');
    }

    public function create($address)
    {

        $c = '\'{"function":"updateBalance","Args":["'. $address .'"]}\'';
        $ret = $this->chain->invoke("wlcc", $c, "ch20");
        var_dump($ret);
    }

}
