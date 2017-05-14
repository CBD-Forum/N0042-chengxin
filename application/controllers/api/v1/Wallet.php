<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vcode_model');
        $this->load->helper('sys');
    }

	public function getnewaddress()
	{
        //$ret = shell_exec("export PATH=\$PATH:/opt/lampp/bin && php -v");

        //$ret = exec("cd ~/go/src/github.com/hyperledger/fabric && export PATH=\$PATH:~/go/src/github.com/hyperledger/fabric/build/bin && peer chaincode invoke -n wlcc -c '{\"Function\":\"getNewAddress\", \"Args\":[]}' -o localhost:7050 -C ch1 2>&1");
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer chaincode invoke -n wlcc -o localhost:7050 -C ch2 -c '{\"function\":\"getNewAddress\",\"Args\":[]}'";
        //$cmd = "cd ~/go/src/github.com/hyperledger/fabric && export GOPATH=/home/ubuntu/go && export PATH=\$PATH:~/go/src/github.com/hyperledger/fabric/build/bin && peer chaincode invoke -n wlcc -c '{\"Function\":\"getNewAddress\", \"Args\":[]}' -o localhost:7050 -C ch1 2>&1";
        $ret = mysystem($cmd);
        //$ret = shell_exec("cd ~/go/src/github.com/hyperledger/fabric && peer chaincode invoke -n wlcc -c '{\"Function\":\"getNewAddress\", \"Args\":[]}' -o localhost:7050 -C ch1");

        $address = preg_match('/address\\\\\":\\\\\"(.*)\\\\\",\\\\\"balance/', $ret, $matches);
        echo $matches[1];

        //return $matches[1];
	}

    public function sendFromToAddress($a,$b,$amount)
    {
    }

}
