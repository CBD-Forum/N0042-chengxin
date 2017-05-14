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

