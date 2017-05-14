#!/bin/bash

cd ~/go/src/github.com/hyperledger/fabric

peer chaincode invoke -n wlcc -c '{"Function":"getNewAddress", "Args":[]}' -o localhost:7050 -C ch1
