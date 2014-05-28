<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <link rel="stylesheet" href="__PUBLIC__//css/configuration.css"/>
	  <script src="__PUBLIC__/js/jquery-1.6.1.js"></script>
</head>
<body>
<div id="index-login">
    <h1>
        智能手机加油站业务支撑系统
    </h1>
    <div class="index-login-con">
        <p><label for="user-name">用户名:</label><input type="text" name="user-name" id="user-name" class="index-login-input"/></p>
        <p><label for="pass">密码:</label><input type="text" name="pass" id="pass"/></p>
        <p>
            <label for="auth-code">验证码:</label><input type="text" name="" id="auth-code" class="index-login-input"/>
            <img src="<?php echo U('configuration/Login/verify');?>" id="verifyImg" />
            <a href="#" onclick="fleshVerify()">换一换</a>
        </p>
        <p><button type="button">登陆</button></p>



    </div>
    <span></span>
</div>
<script language="JavaScript">
    function fleshVerify(){
        //重载验证码
        var time = new Date().getTime();
        document.getElementById('verifyImg').src='/gas_station_erp/index.php/configuration/Login/verify/' + time;
    }
</script>
</body>
</html>