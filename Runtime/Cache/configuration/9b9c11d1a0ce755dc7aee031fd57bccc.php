<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>默认页</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
</head>
<body>
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">智能手机加油站ERP管理系统</h2>
    <div class="login">
        <div class="left">
            <ul class="left-nav">
                <li>赵洋,您好 <span></span>
                    <ul>
                        <li><a href="">修改密码</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="right">
            <a href="<?php echo U('configuration/Login/logout');?>">退出系统</a>
        </div>
    </div>
</div>
<div id="nav">
    <ul class="main-nav">
        <li><a href="">加油站监控</a></li>
        <li><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li><a href="">运营管理</a></li>
        <li><a href="">统计分析</a></li>
        <li><a href="">广告管理</a></li>
        <li><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
<div id="container">
   <div class="default-index">
       <div class="default-index-tt">

       </div>
       <div class="pic-dp">

       </div>
       <div class="default-index-wz">
           <h1></h1>
           <em>自由定制投放方案，个性高效，全城到达每个广告位都期待被您征服，色彩出众画面亮丽，高质的音频输出，保证每个视频、图片、文字的精彩播放。</em>
       </div>
   </div>
</div>
<div id="footer">

</div>

</body>
</html>