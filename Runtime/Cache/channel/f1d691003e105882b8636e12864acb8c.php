<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>网点信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
    <script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>
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
    <ul class="main-nav" id="j-nav-active">
        <li><a href="">加油站监控</a></li>
        <li><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li><a href="">运营管理</a></li>
        <li><a href="">统计分析</a></li>
        <li><a href="">广告管理</a></li>
        <li><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
<div id="container">
<div class="left">
    <ul class="aside-nav">
        <li class="aside-nav-nth1"><a href="">渠道管理</a></li>
        <li><a href="<?php echo U('Channel/index');?>"><input  type="button"  value="渠道信息" ></a></li>
        <li class="active"><a href="<?php echo U('Place/index');?>"><input type="button" class="" value="网点信息" ></a></li>
        <li><a href="<?php echo U('Device/index');?>"><input type="button" class="" value="加油站信息" ></a></li>
    </ul>
</div>
<div class="right">
<div class="right-con">
<div class="org-right-con">
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form action="">
            <p>
                <label for="channel-org-name" class="">网店名称&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="" id="channel-org-name" class="input-org-info"/>
                <label for="channel-ss-are" class="">所属区域</label>
                <select name="add_agent_type_sel" id="channel-ss-are" class="channel-select-min">
                    <option selected value="">省份</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <select name="add_agent_type_sel" id="channel-class2" class="channel-select-min">
                    <option selected value="">城市</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <label for="channel-ss-channel" class="">所属渠道</label>
                <input type="text" name="" id="channel-ss-channel" class="input-org-info"/>

            </p>
            <p>
                <label for="channel-org-name" class="">测试结束期</label>
                <input type="date" name="" id="" class="input-org-info"/>&nbsp;&nbsp;--&nbsp;&nbsp;<input type="date" name="" id="" class="input-org-info"/>
                <label for="channel-state" class="">网点状态</label>
                <select name="add_agent_type_sel" id="channel-state" class="channel-select-min">
                    <option selected value="">启用</option>
                    <option class="industry" value="trade">测试期</option>

                </select>
                <button type="button" class="role-control-btn">查询</button>
            </p>


        </form>
    </div>
    <div class="org-right-btns">
        <form action="">
            <button type="button" class="area-btn">添加</button>
            <button type="button" class="area-btn">编辑/查看</button>
            <button type="button" class="area-btn">删除</button>
            <button type="button" class="area-btn">撤销</button>
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
        <span class="span-2"><b>网点名称</b></span>
        <span class="span-2"><b>所属渠道</b></span>
        <span class="span-3"><b>网点地址</b></span>
        <span class="span-1"><b>网点电话</b></span>
        <span class="span-1"><b>网点状态</b></span>
        <span class="span-1"><b>启用日期</b></span>
        <span class="span-1"><b>投放加油站数量</b></span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
    <li>
        <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
        <span class="span-2" title="#">1111111111111111111111111</span>
        <span class="span-2" title="#">Dolore eius expedita molestias!</span>
        <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
        <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
        <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
        <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
        <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
    </li>
</ul>
    <ul class="role-table-list">
        <li>
            <span class="span-1"></span>
            <span class="span-2"><b>网点名称</b></span>
            <span class="span-2"><b>所属渠道</b></span>
            <span class="span-3"><b>网点地址</b></span>
            <span class="span-1"><b>网点电话</b></span>
            <span class="span-1"><b>启用日期</b></span>
            <span class="span-1"><b>撤销日期</b></span>
        </li>
        <li>
            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
            <span class="span-2" title="#">222222222222222</span>
            <span class="span-2" title="#">Dolore eius expedita molestias!</span>
            <span class="span-3" title="#">Blanditiis dolorum pariatur vitae?</span>
            <span class="span-1" title="#">Perspiciatis quae ratione repudiandae!</span>
            <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
            <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
        </li>

    </ul>
</div>
</div>

<div class="role-table over-h-y">
    <div class="hd">
        <ul class="channel-tab"><li class="on">操作日志</li><li>删除日志</li></ul>
    </div>
<div class="bd">
    <ul class="role-table-list role-table-list2">
        <li>
            <span class="span-3"><b>操作人</b></span>
            <span class="span-3"><b>操作时间</b></span>
            <span class="span-3"><b>操作内容</b></span>
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
    <ul class="role-table-list role-table-list2">
        <li>
            <span class="span-3"><b>操作人</b></span>
            <span class="span-3"><b>操作时间</b></span>
            <span class="span-3"><b>操作内容</b></span>
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
</div>
<div id="footer">
1111
</div>
<script>
    window.onload=function(){
        headAct();

    };
    function headAct(){
        var Ourl = window.location.href;
        if(!document.getElementById('j-nav-active')){return;}
        var Onav = document.getElementById('j-nav-active');
        var nbLi = Onav.getElementsByTagName('li')
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
            if(Ourl=="/gas_station_erp/index.php/channel/Channel/index"||Ourl.indexOf("/gas_station_erp/index.php/channel/Channel/index")>=0||Ourl=="/gas_station_erp/index.php/channel/Channel/index"||Ourl.indexOf("/gas_station_erp/index.php/channel/Channel/index")>=0||Ourl=="/gas_station_erp/index.php/channel/Channel/index"||Ourl.indexOf("/gas_station_erp/index.php/channel/Channel/index")>=0){
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
    <h3>添加职员信息</h3>
    <div class="alert-user-add-con">
        <form action="">
            <p>
                <label for="user-addname" class="role-lab">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</label>
                <input type="text" name="addname" id="user-addname" class="input-role-name"/>
                <input type="radio" name="change-sex" class="change-sex" id="man"/><label for="man" class="sex">男</label>
                <input type="radio" name="change-sex" class="change-sex" id="woman"/><label for="woman" class="sex">女</label>
            </p>
            <p>
                <label for="user-phone" class="role-lab">联系电话</label>
                <input type="text" name="addname" id="user-phone" class="input-role-name"/>
            </p>
            <p>
                <label for="login-id" class="role-lab">登陆账号</label>
                <input type="text" name="addname" id="login-id" class="input-role-name"/>
            </p>
            <div>
                <em>角色</em>
                <ul class="user-checkbox-list">
                    <li><input type="checkbox" name="" id="ck1"/><label for="ck1" class="role-lab">角色a</label></li>
                    <li><input type="checkbox" name="" id="ck2"/><label for="ck2" class="role-lab">角色a</label></li>
                    <li><input type="checkbox" name="" id="ck3"/><label for="ck3" class="role-lab">角色a</label></li>
                    <li><input type="checkbox" name="" id="ck4"/><label for="ck4" class="role-lab">角色a</label></li>
                    <li><input type="checkbox" name="" id="ck5"/><label for="ck5" class="role-lab">角色a</label></li>
                    <li><input type="checkbox" name="" id="ck6"/><label for="ck6" class="role-lab">角色a</label></li>
                </ul>
            </div>
            <p>
                <label for="">所属组织机构</label>
                <!-- 容器 -->
            <div id="J_Tree"></div>
            <!-- 结果收集、设置回显数据 -->
            <input type="hidden" id="J_TreeResult" value='{"id":"291"}'>
            </p>
            <p>
                <button type="button" class="alert-btn2">保存</button>
                <button type="button" class="alert-btn2">关闭</button>
            </p>
        </form>
    </div>
</div>

<div class="alert-role-add">
    <h3>职员信息</h3>
    <div class="alert-role-add-con">
        <p class="delete-message">请确认是否删除？</p>
        <p>
            <button type="button" class="alert-btn2">保存</button>
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