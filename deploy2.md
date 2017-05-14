
诚信网络部署

mines_cc.go

    $ go build

wallet_cc.go安装编译

    $ mkdir -p $GOPATH/src/golang.org/x
    $ mkdir -p $GOPATH/src/golang.org/x
    $ cd $GOPATH/src/golang.org/x
    $ git clone https://github.com/golang/crypto

启动orderer服务

    $ orderer

启动peer服务

    $ peer node start --peer-defaultchain=false --peer-chaincodedev=true  # --peer-chaincodedev=true 以调试模式启动 

create and join channel

    $ peer channel create -o 127.0.0.1:7050 -c ch1
    $ peer channel join -b ch1.block 

install chaincode

    $ peer chaincode install -n wlcc -v 0 -p github.com/hyperledger/fabric/examples/chaincode/go/wallet_cc

instantiate chaincode

    $ peer chaincode instantiate -n wlcc -v 0 -c '{"Args":["init"]}' -o 127.0.0.1:7050 -C ch1

invoke
```
    peer chaincode invoke -n wlcc -c '{"Function":"getNewAddress","Args":[]}' -o 127.0.0.1:7050 -C ch1 
    peer chaincode invoke -n wlcc -c '{"Function":"sendToAddress", "Args":["1JZ1ffgWmdP7k8VqBDdwiu4CvJUXse9mTw", "1F8DeKP9MzpeYfc76QomVufGw43thtxnTy", "1"]}' -o 127.0.0.1:7050 -C ch1
    peer chaincode invoke -n wlcc -c '{"Function":"updateBalance", "Args":["134tEohtjdp8M6kkgoofTtqYzGuvj2NVmY"]}' -o 127.0.0.1:7050 -C ch1
    peer chaincode invoke -n wlcc -c '{"Function":"query", "Args":["134tEohtjdp8M6kkgoofTtqYzGuvj2NVmY"]}' -o 127.0.0.1:7050 -C ch1
```

query

    $ peer chaincode query -n wlcc -c '{"Args":["query","a"]}' -o 127.0.0.1:7050 -C ch1


