<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	  <script src="__PUBLIC__/js/jquery-1.6.1.js"></script>
</head>
<body>
<div id="index-login">
    <h1>
        智能手机加油站业务支撑系统
    </h1>
    <div class="index-login-con">
        <p><label for="user-name">用户名:</label><input type="text" name="username" id="username" AUTOCOMPLETE="off" class="index-login-input"/></p>
        <p><label for="pass">密码:</label><input type="text" name="password" id="password" AUTOCOMPLETE="off" /></p>
        <p>
            <label for="auth-code">验证码:</label><input type="text" name="verify" id="verify" AUTOCOMPLETE="off" class="index-login-input"/>
            <img src="<?php echo U('configuration/Login/verify');?>" id="verifyImg" />
            <a href="#" onclick="fleshVerify()">换一换</a>
        </p>
        <p>
            <button type="button" id="login_button" name="login_button" onclick="checkLogin()">登陆</button>
            <em id="tishi"></em>
        </p>



    </div>
    <span></span>
</div>
<script language="JavaScript">
    function fleshVerify(){
        //重载验证码
        var time = new Date().getTime();
        document.getElementById('verifyImg').src='/gas_station_erp/index.php/configuration/Login/verify/' + time;
    }

	function checkLogin(){
		var userName = $("#username").val();
		var password = $("#password").val();
		var verify   = $("#verify").val();
		$.post("/gas_station_erp/index.php/Login/login",{'USER_LOGIN':1,'is_ajax':1,'username':userName,'password':password,'verify':verify},function(data){
			if(data['login'] == 6001){
				//alert("密码密码有误");
				$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 用户名密码有误");
			}
		
			if(data['login'] == 6002){
				//alert("验证码有误");
				$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 验证码有误");
			}
			if(data['login'] == 2001){
				var handleUrl = "<?php echo U('configuration/Login/default_index');?>";
				window.location.href = handleUrl;
			}
		},"json");
	}
	//回车提交事件
	document.onkeydown = function(e){
		var ev = document.all ? window.event : e;
		if(ev.keyCode==13) {
			checkLogin();
		}
	}
</script>
</body>
</html>