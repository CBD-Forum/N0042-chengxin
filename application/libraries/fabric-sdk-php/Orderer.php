<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderer {

    public function start()
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && nohup orderer 2>&1 &";

        $ret = mysystem($cmd);

        return $ret;
    }

}
