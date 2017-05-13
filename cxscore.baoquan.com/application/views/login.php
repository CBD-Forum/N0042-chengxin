<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>账号登录</title>
    <link rel="stylesheet" href="./static/lib/weui.min.css">
    <link rel="stylesheet" href="./static/css/jquery-weui.css">
    <link rel="stylesheet" href="./static/css/demos.css">
    <link rel="stylesheet" href="./static/css/weui.css"/>
    <script src="./static/lib/jquery-2.1.4.js"></script>
    <style type="text/css">

    	.account_input{
    		border:1px solid;
    		border-radius: 10px;
    		width: 90%;
		    background-color: #fff;
		    line-height: 1.41176471;
		    overflow: hidden;
		    position: relative;
		    margin:80px auto;
    	}
    	.input_img{
    		width: 40px;
    	}
    	.input_img img{
    		width: 30px;
    		height: 30px;
    	}
    	.input_number{
    		padding: 10px 15px;
    		display: flex;
    		align-items:center;
    		
    	}
    	.input_span span{
    		display: block;
		    width: 50px;
		    font-size: 20px;
		    word-wrap: break-word;
		    word-break: break-all;
    	}
    	.input_num{
    		flex:1;

    	}
    	.input_num input{
    		width: 100%;
		   /* border: 0;
		    outline: 0;
		    -webkit-appearance: none;
		    background-color: transparent;*/
		    font-size: inherit;
		    color: inherit;
		    height: 1.41176471em;
		    line-height: 1.41176471;
    	}

    	.input_btn button{

	        width:140px;
	        height:40px;
	        line-height:40px;
	        text-align:center;
	        color:#fff;
	        border:none;
	        border-radius:8px;
	        background:#086bd0;
	        display: block;
	        margin: 0 auto;
      }

    </style>
</head>
<body >
	<div class="account">

		<div class="account_login">
		   
	    	<div class="account_input">
	    		<div class="input_number">
		    		<div class="input_img"><img src="./static/images/account_default.png" /></div>
					<div class="input_span"><span>账户</span></div> 
				    <div class="input_num"><input type="text" name="username" placeholder="请输入账号"></div>
			    </div>
			    <hr style="height:1px;border:none;border-top:1px solid;" />
			    <div class="input_number">
		    		<div class="input_img"><img src="./static/images/password.png" /></div>
					<div class="input_span"><span>密码</span></div> 
				    <div class="input_num"><input type="password" name="password" placeholder="请输入密码"></div>
			    </div>
	    	</div>

	    	<div class="input_btn"><button type="button" onclick="doLogin()">确定</button></div>
		    
		</div>
	</div>

 
    
	<script src="./static/lib/fastclick.js"></script>
	<script>
	  $(function() {
	    FastClick.attach(document.body);
	  });
	  var doLogin = function(){
    	
        var user = $("input[name='username']").val();
        var password = $("input[name='password']").val();
     
        if (user == ''|| password == '') {
        	alert("账户或者密码不能为空");
        	return false;
        }

        request = $.ajax({ 
	      type:'post',  
	      url:'http://192.168.3.87:3334/login',  
	      dataType:'json',  
	      timeout : 0, //超时时间设置，单位毫秒
	      ContentType:'application/x-www-formurl-encoded',
	      data:{
	       
	        user: user,
	        password: password,
	      },

	       success:function(data){
	       	console.log(data);
	        if( data.error == '200' ){
	          
	          window.location.href = 'www.baidu.com';
	          
	        }
	      },error:function(err){
	        if(err.status == 422){
	          alert('参数错误！');
	        }
	      }

	    });
	};
	</script>
	<script src="./static/js/jquery-weui.js"></script>

</body>
</html>