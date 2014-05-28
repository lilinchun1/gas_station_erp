<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>角色维护</title>
    <!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
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
            <li class="aside-nav-nth1"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
            <li><a href="<?php echo U('Org/index');?>"><input  type="button"  value="组织结构" ></a></li>
            <li class="active"><a href="<?php echo U('Role/index');?>"><input type="button" class="" value="角色维护" ></a></li>
            <li><a href="<?php echo U('User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
        </ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire">
                        <form action="">
                            <label for="role-name" class="role-lab">角色名称</label>
                            <input type="text" name="" id="role-name" class="input-org-info"/>
                            <button type="button" class="role-control-btn">查询</button>
                        </form>
                    </div>
                    <div class="org-right-btns">
                        <form action="">
                            <button type="button" class="area-btn">添加</button>
                            <button type="button" class="area-btn">编辑</button>
                            <button type="button" class="area-btn">删除</button>
                            <button type="button" class="area-btn">查看权限</button>
                        </form>
                    </div>
                </div>
                <div class="role-table over-h-y">
                    <ul class="role-table-list">
                        <li>
                            <span class="span-1"></span>
                            <span class="span-2"><b>角色名称</b></span>
                            <span class="span-3"><b>角色描述</b></span>
                            <span class="span-2"><b>创建人</b></span>
                            <span class="span-2"><b>创建日期</b></span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
                        </li>
                        <li>
                            <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                            <span class="span-2" title="#">22222222222</span>
                            <span class="span-3" title="#">33333333333</span>
                            <span class="span-2" title="#">44444444444</span>
                            <span class="span-2" title="#">55555555555</span>
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
    <h3>添加角色信息</h3>
    <div class="alert-role-add-con">
        <form action="">
            <p>
                <label for="role-addname" class="role-lab">角色名称</label>
                <input type="text" name="addname" id="role-addname" class="input-role-name"/>
            </p>
            <p>
                <label for="role-textarea" class="role-lab">角色名称</label>
                <textarea name="" id="role-textarea" cols="30" rows="3" class="role-teatarea"></textarea>
            </p>
            <p>
                <label for="">设置权限</label>
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
    <h3>编辑角色信息</h3>
    <div class="alert-role-add-con">
        <form action="">
            <p>
                <label for="role-addname" class="role-lab">角色名称</label>
                <input type="text" name="addname" id="role-addname" class="input-role-name"/>
            </p>
            <p>
                <label for="role-textarea" class="role-lab">角色名称</label>
                <textarea name="" id="role-textarea" cols="30" rows="3" class="role-teatarea"></textarea>
            </p>
            <p>
                <label for="">设置权限</label>
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
    <h3>角色信息</h3>
    <div class="alert-role-add-con">
        <p class="delete-message">请确认是否删除？</p>
        <p>
            <button type="button" class="alert-btn2">保存</button>
            <button type="button" class="alert-btn2">关闭</button>
        </p>
    </div>
</div>
</body>
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
</html>