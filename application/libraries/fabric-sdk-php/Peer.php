<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peer {

    public function start()
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && nohup peer node start --peer-defaultchain=false 2>&1 &";

        $ret = mysystem($cmd);

        return $ret;

    }

    public function version()
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer version";

        $ret = mysystem($cmd);

        return $ret;
    }
}
