<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>加油站信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
    <script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>
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
        <li><a href="<?php echo U('Place/index');?>"><input type="button" class="" value="网点信息" ></a></li>
        <li class="active"><a href="<?php echo U('Device/index');?>"><input type="button" class="" value="加油站信息" ></a></li>
    </ul>
</div>
<div class="right">
<div class="right-con">
<div class="org-right-con">
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form action="">
            <p>
                <label for="device-drive-id" class="">设备编号</label>
                <input type="text" name="" id="device-drive-id" class="input-org-info"/>
                <label for="mac1" class="">MAC</label>
                <input type="text" name="" id="mac1" class="input-mac"/>-
                <input type="text" name="" id="mac2" class="input-mac"/>-
                <input type="text" name="" id="mac3" class="input-mac"/>-
                <input type="text" name="" id="mac4" class="input-mac"/>-
                <input type="text" name="" id="mac5" class="input-mac"/>-
                <input type="text" name="" id="mac6" class="input-mac"/>
                <label for="device-state" class="">加油站状态</label>
                <select name="add_agent_type_sel" id="device-state" class="channel-select-min">
                    <option selected value="">1</option>
                    <option class="industry" value="trade">2</option>
                    <option class="area" value="area">3</option>
                </select>
                <label for="channel-ss-channel" class="">所属网点</label>
                <input type="text" name="" id="channel-ss-channel" class="input-org-info"/>
                <button type="button" class="role-control-btn">查询</button>
            </p>
        </form>
    </div>
    <div class="org-right-btns">
        <form action="">
            <button type="button" class="area-btn">添加</button>
            <button type="button" class="area-btn">编辑/查看</button>
            <button type="button" class="area-btn">删除</button>
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
                <span class="span-1"><b>加油站编号</b></span>
                <span class="span-1"><b>MAC</b></span>
                <span class="span-1"><b>加油站类型</b></span>
                <span class="span-2"><b>所属网点</b></span>
                <span class="span-1"><b>所在点位</b></span>
                <span class="span-1"><b>加油站状态</b></span>
                <span class="span-1"><b>部署时间</b></span>
                <span class="span-1"><b>启用时间</b></span>
                <span class="span-1"><b>图片预览</b></span>
            </li>
            <li>
                <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                <span class="span-1" title="#">1111111111111111111111111</span>
                <span class="span-1" title="#">Dolore eius expedita molestias!</span>
                <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
                <span class="span-2" title="#">Perspiciatis quae ratione repudiandae!</span>
                <span class="span-1" title="#">Ipsa nulla quidem voluptate?</span>
                <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
                <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
                <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
                <span class="span-1" title="#"><img src="../../Public/image/img.png" alt=""/></span>
            </li>
        </ul>
        <ul class="role-table-list">
            <li>
                <span class="span-1"></span>
                <span class="span-2"><b>加油站编号</b></span>
                <span class="span-1"><b>MAC</b></span>
                <span class="span-1"><b>加油站类型</b></span>
                <span class="span-2"><b>所属网点</b></span>
                <span class="span-2"><b>所在点位</b></span>
                <span class="span-2"><b>部署时间</b></span>
                <span class="span-1"><b>图片预览</b></span>
            </li>
            <li>
                <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                <span class="span-2" title="#">222222222222222222</span>
                <span class="span-1" title="#">Dolore eius expedita molestias!</span>
                <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
                <span class="span-2" title="#">Perspiciatis quae ratione repudiandae!</span>
                <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
                <span class="span-2" title="#">Consequuntur eveniet itaque velit.</span>
                <span class="span-1" title="#"><img src="../../Public/image/img.png" alt=""/></span>
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
<div class="alert-role-add">
    <h3>修改密码</h3>
    <div class="alert-role-add-con">
        <p>
            <label for="old-pass" class="role-lab">旧密码&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="addname" id="old-pass" class="input-role-name"/>
        </p>
        <p>
            <label for="new-pass" class="role-lab">新密码&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="addname" id="new-pass" class="input-role-name"/>
        </p>
        <p>
            <label for="rnew-pass" class="role-lab">确认密码</label>
            <input type="password" name="addname" id="rnew-pass" class="input-role-name"/>
        </p>
        <p>
            <button type="button" class="alert-btn2">修改密码</button>

        </p>
    </div>
</div>
<script>
    window.onload=function(){
        headAct();

    };
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
            <p>
                所属组织机构：<span>机构1</span>
            </p>
            <p>
                <label for="channel-addname" class="role-lab">设备编号</label>
                <input type="text" name="addname" id="channel-addname" class="input-role-name"/>
            </p>
            <p>
                <label for="mac1" class="">MAC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="" id="mac1" class="input-mac"/>-
                <input type="text" name="" id="mac2" class="input-mac"/>-
                <input type="text" name="" id="mac3" class="input-mac"/>-
                <input type="text" name="" id="mac4" class="input-mac"/>-
                <input type="text" name="" id="mac5" class="input-mac"/>-
                <input type="text" name="" id="mac6" class="input-mac"/>
            </p>
            <p>
                <label for="channel-line-p" class="role-lab">所属网点</label>
                <input type="text" name="addname" id="channel-line-p" class="input-role-name"/>
            </p>
            <p>
                <label for="channel-point" class="role-lab">所在点位</label>
                <input type="text" name="addname" id="channel-point" class="input-role-name"/>
            </p>
            <p>
                <label for="bs-date">部署日期</label>
                <input  type="date" name="" id="bs-date" class="input-org-info" style="margin-top: 0;"/>
            </p>
            <p>
                <label for="sq-date">启用日期</label>
                <input  type="date" name="" id="sq-date" class="input-org-info" style="margin-top: 0;"/>
            </p>
            <p>
                <label for="sq-date">设置开机时间</label>
                <input  type="date" name="" id="sq-date" class="input-org-info" style="margin-top: 0;"/>
            </p>
            <p>
                <label for="sq-date">设置关机时间</label>
                <input type="date" name="" id="sq-date" class="input-org-info" style="margin-top: 0;"/>
            </p>
            <div class="device-point-pic">
                <h4>点位照片</h4>
                <span><img src="" alt=""/></span>
                <span><img src="" alt=""/></span>
                <span><img src="" alt=""/></span>
            </div>
            <p>
                <button type="button" class="alert-btn2">保存</button>
                <button type="button" class="alert-btn2">关闭</button>
            </p>
        </form>
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