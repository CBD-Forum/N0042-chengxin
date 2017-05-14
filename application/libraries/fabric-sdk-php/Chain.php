<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chain {

    public function invoke($n, $c, $CC, $o="localhost:7050")
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer chaincode invoke -n $n -c $c -o $o -C $CC";

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
