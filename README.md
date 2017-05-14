### 1、获取Ubuntu最新版本

### 2、docker安装，参考文档：
```
http://www.cnblogs.com/lighten/p/6034984.html
https://docs.docker.com/engine/installation/linux/ubuntu/
https://docs.docker.com/compose/install/
http://www.tuicool.com/articles/AnIVJn
```
安装docker-compose：
```
sudo apt-get install python-pip
sudo pip install --upgrade pip
sudo pip install -U docker-compose
```
或者：
```
sudo apt-get install docker-compose
```

### 3、go环境搭建，参考文档：
```
https://golang.org/doc/install
```
安装完成后，在.zshrc文件中添加：
```
export PATH=$PATH:/usr/local/go/bin
export GOROOT=/usr/local/go
export GOPATH=~/go
```
然后在命令行中，输入以下命令使配置生效：
```
source .zshrc
```

### 4、fabric代码拷贝，参考文档：
创建~/go/src/github.com/hyperledger/目录：
```
mkdir -p ~/go/src/github.com/hyperledger/
```
拷贝fabric代码：
```
cd ~/go/src/github.com/hyperledger/
git clone https://github.com/hyperledger/fabric
```
安装make依赖：
```
sudo apt-get install cmake build-essential libboost-all-dev -y
```
然后在fabric目录下：
```
cd ~/go/src/github.com/hyperledger/fabric
make native
```
如果编译过程中遇到cp报错，使用如下命令解决：
```
cp build/bin/chaintool build/docker/gotools/bin/protoc-gen-go
```
编译成功后，在.zshrc文件中添加：
```
export PATH=$PATH:~/go/src/github.com/hyperledger/fabric/build/bin
```
让配置生效：
```
source .zshrc
```
创建/var/hyperledger文件夹：
```
sudo mkdir /var/hyperledger
sudo chmod 777 -R /var/hyperledger
```

### 5、nodejs环境安装
```
https://nodejs.org/en/download/package-manager/
```

### 6、诚信网络部署

mines_cc.go
```
$ go build
```

wallet_cc.go安装编译
```
$ mkdir -p $GOPATH/src/golang.org/x
$ mkdir -p $GOPATH/src/golang.org/x
$ cd $GOPATH/src/golang.org/x
$ git clone https://github.com/golang/crypto
```

启动orderer服务
```
$ orderer
```

启动peer服务
```
$ peer node start --peer-defaultchain=false --peer-chaincodedev=true  # --peer-chaincodedev=true 以调试模式启动 
```

create and join channel
```
$ peer channel create -o 127.0.0.1:7050 -c ch1
$ peer channel join -b ch1.block 
```

install chaincode
```
$ peer chaincode install -n wlcc -v 0 -p github.com/hyperledger/fabric/examples/chaincode/go/wallet_cc
```

instantiate chaincode
```
$ peer chaincode instantiate -n wlcc -v 0 -c '{"Args":["init"]}' -o 127.0.0.1:7050 -C ch1
```

invoke
```
peer chaincode invoke -n wlcc -c '{"Function":"getNewAddress","Args":[]}' -o 127.0.0.1:7050 -C ch1 
peer chaincode invoke -n wlcc -c '{"Function":"sendToAddress", "Args":["1JZ1ffgWmdP7k8VqBDdwiu4CvJUXse9mTw", "1F8DeKP9MzpeYfc76QomVufGw43thtxnTy", "1"]}' -o 127.0.0.1:7050 -C ch1
peer chaincode invoke -n wlcc -c '{"Function":"updateBalance", "Args":["134tEohtjdp8M6kkgoofTtqYzGuvj2NVmY"]}' -o 127.0.0.1:7050 -C ch1
peer chaincode invoke -n wlcc -c '{"Function":"query", "Args":["134tEohtjdp8M6kkgoofTtqYzGuvj2NVmY"]}' -o 127.0.0.1:7050 -C ch1
```

query
```
$ peer chaincode query -n wlcc -c '{"Args":["query","a"]}' -o 127.0.0.1:7050 -C ch1
```

