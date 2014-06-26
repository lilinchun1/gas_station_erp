<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>登陆</title>
<link rel="stylesheet" href="../../Public/css/configuration.css" />
<link rel="stylesheet" href="__PUBLIC__/css/configuration.css" />
<script src="__PUBLIC__/js/jquery-1.6.1.js"></script>
</head>
<body>
<div class="wrap">
    <div id="index-login">
        <h1>
            智能手机加油站业务支撑系统
        </h1>
        <div class="logo-360"></div>
        <div class="index-login-con">
            <div class="login-tt-head">
                <b class="index-login-con-tt1">用户登陆</b>
                <b class="index-login-con-tt2">UserLogin</b>
            </div>
            <p><label for="username">用户名:</label><input type="text" name="username" id="username" AUTOCOMPLETE="off" class="index-login-input"/></p>
            <p><label for="password">密&nbsp;&nbsp;&nbsp;码:</label><input type="password" name="password" id="password" AUTOCOMPLETE="off" /></p>
            <p>
                <label for="verify">验证码:</label><input type="text" name="verify" id="verify" AUTOCOMPLETE="off" class="index-login-input haf-input"/>
                <img src="<?php echo U('configuration/Login/verify');?>" id="verifyImg" height="28" />
                <a href="#" onclick="fleshVerify()">换一换</a>
            </p>
            <p>
                <button type="button" id="login_button" name="login_button" onclick="checkLogin()">登陆</button>
                <em id="tishi"></em>
            </p>



        </div>
        <span></span>
    </div>
</div>
	<script type="text/javascript">
		function fleshVerify() {
			//重载验证码
			var time = new Date().getTime();
			document.getElementById('verifyImg').src = '/gas_station_erp/index.php/configuration/Login/verify/' + time;
		}

		function checkLogin() {
			var userName = $("#username").val();
			var password = $("#password").val();
			var verify = $("#verify").val();
			if(verify==""){
				$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 请输入验证码");
				return false;
			}
			if(userName==""){
				$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 请输入用户名");
				return false;
			}
			if(password==""){
				$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 请输入密码");
				return false;
			}
			$.post(
				"/gas_station_erp/index.php/Login/login",
				{
					'USER_LOGIN' : 1,
					'is_ajax' : 1,
					'username' : userName,
					'password' : password,
					'verify' : verify
				},
				function(data) {
					if(data['login'] == 6000){
						//alert("用户错误");
						$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 用户名不存在，请重新输入");
					}
					if(data['login'] == 6003){
						//alert("用户错误");
						$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 该用户已经失效，请联系管理员");
					}
					if(data['login'] == 6001){
						//alert("密码密码有误");
						$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 密码有误，请重新输入");
					}
				
					if(data['login'] == 6002){
						//alert("验证码有误");
						$("#tishi").html("<img src='__PUBLIC__/image/tanhao.png'/> 验证码有误");
					}
					if(data['login'] == 2001){
						var handleUrl = "<?php echo U('configuration/Login/default_index');?>";
						window.location.href = handleUrl;
					}
				}, "json");
		}
		//回车提交事件
		document.onkeydown = function(e) {
			var ev = document.all ? window.event : e;
			if (ev.keyCode == 13) {
				checkLogin();
			}
		}
	</script>
</body>
</html>