<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel {

    public function create_c($o, $c)
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer channel create -o $o -c $c";

        $ret = mysystem($cmd);

        return $ret;

    }

    public function join_to($b)
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer channel join -b $b";

        $ret = mysystem($cmd);

        return $ret;
    }

}
