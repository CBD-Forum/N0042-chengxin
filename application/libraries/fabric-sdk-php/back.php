<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chain{

    public function f1($n, $v, $p)
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer chaincode install -n $n -v $v -p $p";

        $ret = mysystem($cmd);

        return $ret;
    }

    public function f2($n, $v, $c, $CC, $o="localhost:7050")
    {
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer chaincode instantiate -n $n -v $v -c $c -o $o -C $CC";

        $ret = mysystem($cmd);

        return $ret;

    }

    public function f3($n, $c, $CC, $o="localhost:7050")
    {
        echo 2;
        exit;
        $cmd = "export GOPATH=/home/ubuntu/go && export PATH=\$PATH:/home/ubuntu/go/src/github.com/hyperledger/fabric/build/bin && cd ~/go/src/github.com/hyperledger/fabric && peer chaincode invoke -n $n -v $v -c $c -o $o -C $CC";

        $ret = mysystem($cmd);

        return $ret;
    }


}
