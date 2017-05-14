/**
 * 钱包
 * 
 * @author      mozarlee
 * @time        2017-05-11 14:18:30
 * @created by  Sublime Text 3
 *
 * peer chaincode query -o orderer:7050 -u admin -C testchannel -n test_wallets_id_0 -c '{"Function": "query", "Args": ["test_address"]}'
 */

package main

import (
	"encoding/json"
	"fmt"
	"strconv"
	"os"
	"github.com/vsergeev/btckeygenie/btckey"
	"crypto/rand"

	"github.com/hyperledger/fabric/core/chaincode/shim"
	pb "github.com/hyperledger/fabric/protos/peer"
)

// WalletChaincode example simple Chaincode implementation
type WalletChaincode struct {
}

type wallet struct {
	ObjectType string `json:"docType"` //docType is used to distinguish the various types of objects in state database
	Address       string `json:"address"`    //the fieldtags are needed to keep case from bouncing around
	Balance   float64 `json:"balance"`
}

type Address struct {
	BitcionAddress string 
	PublicKey string
	PrivateKey string
}

// ===================================================================================
// Main
// ===================================================================================
func main() {
	err := shim.Start(new(WalletChaincode))
	if err != nil {
		fmt.Printf("Error starting Simple chaincode: %s", err)
	}
}

// Init initializes chaincode
// ===========================
func (t *WalletChaincode) Init(stub shim.ChaincodeStubInterface) pb.Response {
	return shim.Success(nil)
}

// Invoke - Our entry point for Invocations
// ========================================
func (t *WalletChaincode) Invoke(stub shim.ChaincodeStubInterface) pb.Response {
	function, args := stub.GetFunctionAndParameters()

	if function == "getNewAddress" {
		return t.getNewAddress(stub, args)
	} else if function == "query" {
		return t.query(stub, args)
	} else if function == "updateBalance" {
		return t.updateBalance(stub, args)
	} else if function == "sendToAddress" {
		return t.sendToAddress(stub, args)
	}

	return shim.Error("Received unknown function invocation")
}

/**
 * 获取新地址
 */
func (t *WalletChaincode) getNewAddress(stub shim.ChaincodeStubInterface, args []string) pb.Response {

	var err error
	// 生成私钥
	// 生成公钥
	// 生成地址
	address, publicKey, privateKey := t.generateAddress();

	balance := 0.00000000

	// ==== Check if address already exists ====
	walletAsBytes, err := stub.GetState(address)
	if err != nil {
		fmt.Println("Failed to get address: " + err.Error())
		return shim.Error("Failed to get address: " + err.Error())
	} else if walletAsBytes != nil {
		fmt.Println("This address already exists: " + address)
		return shim.Error("This address already exists: " + address)
	}

	// // 写入文件
	addressObj := Address{
		BitcionAddress: address,
		PublicKey: publicKey,
		PrivateKey: privateKey,
	}

	saveRes := t.saveToFile(addressObj)

	if saveRes {
		// ==== Create wallet object and marshal to JSON ====
		objectType := "wallet"
		wallet := &wallet{objectType, address, balance}
		walletJSONasBytes, err := json.Marshal(wallet)
		if err != nil {
			return shim.Error(err.Error())
		}

		// === Save wallet to state ===
		err = stub.PutState(address, walletJSONasBytes)
		if err != nil {
			fmt.Println("Failed to getNewAddress")
			return shim.Error(err.Error())
		}

		fmt.Println("Address is: %s", address)

		addressValue, err := stub.GetState(address)
		return shim.Success(addressValue)
	}

	return shim.Error("Save publicKey,privateKey,address error")
}

/**
 * 保存地址公钥到文件
 */
func (t *WalletChaincode) saveToFile(addressObj Address) bool {
	a_json, err := json.Marshal(addressObj)
	if err != nil {
		return false
	}

	writestring := a_json

	var filename = "./saveaddress.txt";
	var f    *os.File
	var err1   error;
	//写入文档

	exist := true;
	if _, err := os.Stat(filename); os.IsNotExist(err) {
		exist = false;
	}

	if exist {  //如果文件存在
		f, err1 = os.OpenFile(filename, os.O_APPEND, 0666)  //打开文件
	}else {
		f, err1 = os.Create(filename)  //创建文件
	}

	if err1 != nil {
		return false
	}

	defer f.Close()
	f.Write(writestring)

	return true
}

/**
 * 生成地址
 * @param  {[type]} t *WalletChaincode) generateAddress() (string [description]
 * @return {[type]}   [description]
 */
func (t *WalletChaincode) generateAddress() (string, string, string) {
	var priv btckey.PrivateKey

	priv, _ = btckey.GenerateKey(rand.Reader)

	/* Convert to Compressed Address */
	address := priv.ToAddress()
	
	/* Convert to Public Key Compressed Bytes (33 bytes) */
	pub_bytes_compressed := priv.PublicKey.ToBytes()
	publicKey := ""
	for i := 0; i < len(pub_bytes_compressed); i++ {
		publicKey += fmt.Sprintf("%02X", pub_bytes_compressed[i])
	}

	pri_bytes := priv.ToBytes()
	privateKey := ""
	for i := 0; i < len(pri_bytes); i++ {
		privateKey += fmt.Sprintf("%02X", pri_bytes[i])
	}

	return address, publicKey, privateKey
}

/**
 * 查询某个地址信息
 */
func (t *WalletChaincode) query(stub shim.ChaincodeStubInterface, args []string) pb.Response {
	var address, jsonResp string
	var err error

	if len(args) != 1 {
		return shim.Error("Incorrect number of arguments. Expecting user of the user to query")
	}

	address = args[0]
	valAsbytes, err := stub.GetState(address) //get the address from chaincode state
	if err != nil {
		jsonResp = "{\"Error\":\"Failed to get state for " + address + "\"}"
		return shim.Error(jsonResp)
	} else if valAsbytes == nil {
		jsonResp = "{\"Error\":\"address does not exist: " + address + "\"}"
		return shim.Error(jsonResp)
	}

	jsonResp = string(valAsbytes)
	fmt.Printf("Query Response:%s\n", jsonResp)
	return shim.Success(valAsbytes)
}

/**
 * 更新地址余额
 */
func (t *WalletChaincode) updateBalance(stub shim.ChaincodeStubInterface, args []string) pb.Response {
	address := args[0]
	balance := 500.00000000

	walletAsBytes, err := stub.GetState(address)
	if err != nil {
		return shim.Error("Failed to get address:" + err.Error())
	} else if walletAsBytes == nil {
		return shim.Error("address does not exist")
	}

	walletToTransfer := wallet{}
	err = json.Unmarshal(walletAsBytes, &walletToTransfer) //unmarshal it aka JSON.parse()
	if err != nil {
		return shim.Error(err.Error())
	}

	walletToTransfer.Balance = walletToTransfer.Balance + balance //change the owner

	walletJSONasBytes, _ := json.Marshal(walletToTransfer)
	err = stub.PutState(address, walletJSONasBytes) //rewrite the wallet
	if err != nil {
		return shim.Error(err.Error())
	}

	return shim.Success(nil)
}

/**
 * 转账
 */
func (t *WalletChaincode) sendToAddress(stub shim.ChaincodeStubInterface, args []string) pb.Response {

	if len(args) != 3 {
		return shim.Error("Incorrect number of arguments. Expecting 3")
	}

	addressA := args[0] // a转给b
	addressB := args[1]
	btc := args[2]

	btc_float, _ := strconv.ParseFloat(btc, 64)

	// sign := args[4] // 签名

	// // 验证交易
	// if sign != "sign" {
	// 	return shim.Error("Sign error")
	// }

	// Get the state from the ledger a账户减少相应金额
	Avalbytes, err := stub.GetState(string(addressA))
	if err != nil {
		return shim.Error("Failed to get state")
	} 

	if Avalbytes == nil {
		return shim.Error("Entity not found")
	}

	walletA := wallet{}
	err = json.Unmarshal([]byte(Avalbytes), &walletA) //unmarshal it aka JSON.parse()
	if err != nil {
		return shim.Error(err.Error())
	}

	if walletA.Balance < btc_float {
		return shim.Error("Balance is not enough")
	}

	walletA.Balance = walletA.Balance - btc_float //change
	walletAJSONasBytes, _ := json.Marshal(walletA)
	err = stub.PutState(addressA, walletAJSONasBytes) //rewrite the wallet
	if err != nil {
		return shim.Error(err.Error())
	}

	// Get the state from the ledger b账户增加相应金额
	Bvalbytes, err := stub.GetState(addressB)
	if err != nil {
		return shim.Error("Failed to get state")
	} else if Bvalbytes == nil {
		return shim.Error("Entity not found")
	}

	walletB := wallet{}
	err = json.Unmarshal(Bvalbytes, &walletB) //unmarshal it aka JSON.parse()
	if err != nil {
		return shim.Error(err.Error())
	}

	walletB.Balance = walletB.Balance + btc_float //change
	walletBJSONasBytes, _ := json.Marshal(walletB)
	err = stub.PutState(addressB, walletBJSONasBytes) //rewrite the wallet
	if err != nil {
		return shim.Error(err.Error())
	}

	return shim.Success(nil)
}
