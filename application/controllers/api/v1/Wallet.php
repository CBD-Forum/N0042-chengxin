<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vcode_model');
        $this->load->helper('sys');
        $this->load->library('fabric-sdk-php/orderer');
        $this->load->library('fabric-sdk-php/peer');
        $this->load->library('fabric-sdk-php/chain');
    }

    public function test()
    {
        //$ret = $this->chaincode->install("wlcc", 30, "github.com/hyperledger/fabric/examples/chaincode/go/wallet_cc");
        //$ret = $this->channel->create_c("localhost:7050", "ch14");
        //$ret = $this->channel->join_to("ch11.block");
        //$ret = $this->peer->start();

        //$ret->chaincode->instantiate("wlcc", "33", "'{\"Args\":[\"init\"]}'", "ch11");
        $c = "'{\"function\":\"getNewAddress\",\"Args\":[]}'";
        $ret = $this->chain->invoke("wlcc", $c, "ch20");
        echo $ret;
    }

	public function getnewaddress()
	{
        $c = '\'{"function":"getNewAddress","Args":[]}\'';
        $ret = $this->chain->invoke("wlcc", $c, "ch20");

        $address = preg_match('/address\\\\\":\\\\\"(.*)\\\\\",\\\\\"balance/', $ret, $matches);
        echo $matches[1];
        exit;

        //return $matches[1];
	}

    public function query($a)
    {

        $c = '\'{"function":"query","Args":["'. $a .'"]}\'';
        $ret = $this->chain->invoke("wlcc", $c, "ch20");

        $response = preg_match('/payload:(.*?)>/', $ret, $matches);
        $ll = json_decode($matches[1]);
        $ll = json_decode($ll);

        echo $ll->balance;
        exit;

    }

    public function sendFromToAddress($a,$b,$amount)
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer chaincode invoke -n wlcc -o localhost:7050 -C ch2 -c '{\"function\":\"sendToAddress\",\"Args\":[\"".$a."\",\"".$b."\",\"".$amount."\"]}'";

        $c = '\'{"function":"sendToAddress","Args":["'. $a .'","'. $b .'","'. $amount .'"]}\'';
        $ret = $this->chain->invoke("wlcc", $c, "ch20");
        var_dump($ret);
    }

}
