<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>渠道信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
	<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">111智能手机加油站ERP管理系统</h2>
    <div class="login">
        <div class="left">
            <ul class="left-nav">
                <li>赵洋,您好 <span></span>
                    <ul>
                        <li><a href="javascript:void(0);" onclick="show_change_password()">修改密码</a></li>
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
    <ul class="main-nav" id="j-nav-active">
        <li><a href="">加油站监控</a></li>
        <li><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li><a href="">运营管理</a></li>
        <li><a href="">统计分析</a></li>
        <li><a href="">广告管理</a></li>
        <li><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
<script type="text/javascript">
	function show_change_password(){
		$('#change_password_id').show();
	}
</script>
<div id="container">
<div class="left">
    <ul class="aside-nav">
        <li class="aside-nav-nth1"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="active"><a href="<?php echo U('channel/Channel/index');?>"><input  type="button"  value="渠道信息" ></a></li>
        <li><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息" ></a></li>
        <li><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息" ></a></li>
    </ul>
</div>
<div class="right">
<div class="right-con">
<div class="org-right-con">
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form action="">
            <p>
                <label for="channel-org-name" class="">渠道商名称&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="" id="channel-org-name" class="input-org-info"/>
                <label for="channel-class1" class="">渠道类型</label>
                <select name="add_agent_type_sel" id="channel-class1" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <select name="add_agent_type_sel" id="channel-class2" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <label for="channel-org-in" class="">所属组织机构</label>
                <select name="add_agent_type_sel" id="channel-org-in" class="channel-select">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <label for="channel-are1" class="">所在区域</label>
                <select name="add_agent_type_sel" id="channel-are1" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <select name="add_agent_type_sel" id="channel-are1" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
            </p>
            <p>
                <label for="channel-org-name" class="">合同开始日期</label>
                <input type="date" name="" id="" class="input-org-info"/>&nbsp;&nbsp;--&nbsp;&nbsp;<input type="date" name="" id="" class="input-org-info"/>
                <label for="channel-org-name" class="">合同截至日期</label>
                <input type="date" name="" id="" class="input-org-info"/>&nbsp;&nbsp;--&nbsp;&nbsp;<input type="date" name="" id="" class="input-org-info"/>
                <button type="button" class="role-control-btn">查询</button>
            </p>


        </form>
    </div>
    <div class="org-right-btns">
        <form action="">
            <button type="button" class="area-btn">添加</button>
            <button type="button" class="area-btn">编辑/查看</button>
            <button type="button" class="area-btn">终止合同</button>
        </form>
    </div>
</div>
<div class="role-table">
    <div class="hd">
        <ul class="channel-tab"><li class="on">启用</li><li>撤销</li></ul>
    </div>
    <div class="bd over-h-y">
        <ul class="role-table-list">
    <li>
        <span class="span-1"></span>
        <span class="span-1"><b>姓名</b></span>
        <span class="span-1"><b>性别</b></span>
        <span class="span-1"><b>联系电话</b></span>
        <span class="span-3"><b>所属组织机构</b></span>
        <span class="span-2"><b>账号</b></span>
        <span class="span-1"><b>角色</b></span>
        <span class="span-1"><b>状态</b></span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
        <span class="span-1" title="#">Dolore eius expedita molestias!</span>
        <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    </ul>
        <ul class="role-table-list">
        <li>
            <span class="span-1"></span>
            <span class="span-1"><b>姓名</b></span>
            <span class="span-1"><b>性别</b></span>
            <span class="span-1"><b>联系电话</b></span>
            <span class="span-3"><b>所属组织机构</b></span>
            <span class="span-2"><b>账号</b></span>
            <span class="span-1"><b>角色</b></span>
            <span class="span-1"><b>状态</b></span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">1111111111111111111111111</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
            <span class="span-1" title="#">Dolore eius expedita molestias!</span>
            <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>
        </ul>
    </div>
</div>

<div class="role-table over-h-y">
    <div class="data-log">
        <h3>操作日志</h3>
    </div>
    <ul class="role-table-list role-table-list2">
        <li>
            <span class="span-3"><b>操作人</b></span>
            <span class="span-3"><b>操作时间</b></span>
            <span class="span-3"><b>操作日志</b></span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
        <li>
            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
        </li>
    </ul>
</div>
</div>
</div>
</div>
</div>
<div id="footer">
1111
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<div id="change_password_id" class="alert-role-add" style="display:none;">
    <h3>修改密码</h3>
    <div class="alert-role-add-con">
        <p>
            <label for="old-pass" class="role-lab">旧密码&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="old_password_txt" id="old_password_txt" class="input-role-name"/>
        </p>
        <p>
            <label for="new-pass" class="role-lab">新密码&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="new_password_txt" id="new_password_txt" class="input-role-name"/>
        </p>
        <p>
            <label for="rnew-pass" class="role-lab">确认密码</label>
            <input type="password" name="re_new_password_txt" id="re_new_password_txt" class="input-role-name"/>
        </p>
        <p>
            <button type="button" class="alert-btn2" onclick="change_password()">修改密码</button>

        </p>
    </div>
</div>
<script>
    window.onload=function(){
        headAct();

    };

	function change_password(){
		var handleUrl = "<?php echo U('configuration/Login/change_password');?>";
		var old_password_txt=$('#old_password_txt').val();//业务范围
		var new_password_txt=$('#new_password_txt').val();//业务范围
		var re_new_password_txt=$('#re_new_password_txt').val();//业务范围
		$.getJSON(handleUrl,{'old_password_txt':old_password_txt,'new_password_txt':new_password_txt,'re_new_password_txt':re_new_password_txt},
			function (data){
				var tmp_msg = "<?php echo C('change_password_success');?>";
					if(tmp_msg == data)
					{
						alert(data);
						$('#change_password_id').hide();
					}
					else
					{
						alert(data);
					}
			}
			,'json'
		);
	}

    function headAct(){
        var Ourl = window.location.href;
        if(!document.getElementById('j-nav-active')){return;};
        var Onav = document.getElementById('j-nav-active');
        var nbLi = Onav.getElementsByTagName('li');
        for(var i=0; i<nbLi.length;i++){
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0||Ourl=="/gas_station_erp/index.php/Role/index"||Ourl.indexOf("/gas_station_erp/index.php/Role/index")>=0||Ourl=="/gas_station_erp/index.php/User/index"||Ourl.indexOf("/gas_station_erp/index.php/User/index")>=0){
                       nbLi[5].className='active';//系统设置
                        return;
            }
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0){
                nbLi[4].className='active';//广告管理
                return;
            }
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0){
                nbLi[3].className='active';//统计分析
                return;
            }
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0){
                nbLi[2].className='active';//运营管理
                return;
            }
            if(Ourl=="/gas_station_erp/index.php/channel/Channel/index"||Ourl.indexOf("/gas_station_erp/index.php/channel/Channel/index")>=0||Ourl=="/gas_station_erp/index.php/channel/Place/index"||Ourl.indexOf("/gas_station_erp/index.php/channel/Place/index")>=0||Ourl=="/gas_station_erp/index.php/channel/Device/index"||Ourl.indexOf("/gas_station_erp/index.php/channel/Device/index")>=0){
                nbLi[1].className='active';//渠道管理
                return;
            }
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0){
                nbLi[0].className='active';//加油站监控
                return;
            }


        }

    }
</script>

<div class="alert-role-add">
    <h3>渠道信息</h3>
    <div class="alert-user-add-con">
        <form action="">
            <p>所属组织机构：<span>分子公司1</span></p>
            <p>
                <label for="channel-addname" class="role-lab">渠道名称</label>
                <input type="text" name="addname" id="channel-addname" class="input-role-name"/>
            </p>
            <p>
                <label for="channel-address1" class="">渠道地址</label>
                <select name="add_agent_type_sel" id="channel-address1" class="channel-select-min">
                    <option selected value="">省</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <select name="add_agent_type_sel" id="channel-address2" class="channel-select-min">
                    <option selected value="">市</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <input type="text" name="addname" id="channel-addname" class="input-role-name"/>
            </p>
            <p>
                <label for="channel-address1" class="">渠道类型</label>
                <select name="add_agent_type_sel" id="channel-address1" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <select name="add_agent_type_sel" id="channel-address2" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <a href="">修改类别</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="">修改属性</a>
            </p>
            <p>
                <label for="user-phone" class="role-lab">联系人&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="addname" id="user-phone" class="input-role-name"/>
            </p>
            <p>
                <label for="user-phone" class="role-lab">联系电话</label>
                <input type="text" name="addname" id="user-phone" class="input-role-name"/>
            </p>
            <p>
                <label for="login-id" class="role-lab">合同编号</label>
                <input type="text" name="addname" id="login-id" class="input-role-name"/>
            </p>
            <p>
                <label for="sq-date">授权日期</label>
                <input type="date" name="" id="sq-date" class="input-org-info min-w" style="margin-top: 0;"/>
                <input type="date" name="" id="date" class="input-org-info min-w" style="margin-top: 0;"/>
            </p>
            <p>
                <button type="button" class="alert-btn2">保存</button>
                <button type="button" class="alert-btn2">关闭</button>
            </p>
        </form>
    </div>
</div>

<div class="alert-role-add">
    <h3></h3>
    <div class="alert-role-add-con">
        <p>
            <label for="del-data" class="role-lab">*撤销日期</label>
            <input type="text" name="addname" id="del-data" class="input-role-name"/>
        </p>
        <p>
            <button type="button" class="alert-btn2">确定</button>
            <button type="button" class="alert-btn2">关闭</button>
        </p>
    </div>
</div>
<script>
    window.onscroll=function(){
        var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
        var fixDiv=document.getElementById('j-fixed-top');
        if(scrollTop>=300){
            fixDiv.style.position='fixed';
            fixDiv.style.top='0px';
        }else if(scrollTop<=299){
            fixDiv.style.position='static';
        }
    }
</script>
<script type="text/javascript">jQuery(".role-table").slide();</script>
</body>
</html>