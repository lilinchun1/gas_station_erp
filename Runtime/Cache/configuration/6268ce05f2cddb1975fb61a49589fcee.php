<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>职员维护</title>
    <!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
	<link rel="stylesheet" href="	__PUBLIC__/css/configuration.css"/>

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
        <li><a href="<?php echo U('management/Index/importingApp');?>">运营管理</a></li>
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
            <li class="aside-nav-nth1"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
            <li><a href="<?php echo U('Org/index');?>"><input  type="button"  value="组织结构" ></a></li>
            <li><a href="<?php echo U('Role/index');?>"><input type="button" class="" value="角色维护" ></a></li>
            <li class="active"><a href="<?php echo U('User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
        </ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire">
                        <form name="userSelect" method="get" action="<?php echo U('configuration/User/show_user');?>">
                            <label for="user-name" class="">姓名</label>
                            <input type="text" name="realname_txt" id="realname_txt" class="input-org-info"/>
                            <label for="at-org" class="">所属组织机构</label>
                            <input type="text" name="org_name_txt" id="org_name_txt" class="input-org-info"/>
                            <label for="use-id" class="use-id">账号</label>
                            <input type="text" name="username_txt" id="username_txt" class="input-org-info"/>
                            <input type="submit" id="select_button" name="select_button" class="role-control-btn">
                        </form>
                    </div>
                    <div class="org-right-btns">
                        <form action="">
                            <button type="button" class="area-btn">添加</button>
                            <button type="button" class="area-btn">编辑</button>
                            <button type="button" class="area-btn">删除</button>
                            <button type="button" class="area-btn">重置密码</button>
                            <button type="button" class="area-btn">激活/失效</button>
                        </form>
                    </div>
                </div>
                <div class="role-table over-h-y">
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
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
								<span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
								<span class="span-1" title="#"><?php echo ($vo["realname"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["sex"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["telphone"]); ?></span>
								<span class="span-3" title="#"><?php echo ($vo["orgname"]); ?></span>
								<span class="span-2" title="#"><?php echo ($vo["username"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["rolename"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["del_flag"]); ?></span>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
					<div class="resultpage"><?php echo ($page); ?></div>
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
            if(Ourl=="/gas_station_erp/index.php/management/Index/importingApp"||Ourl.indexOf("/gas_station_erp/index.php/management/Index/importingApp")>=0||Ourl=="/management/Index/addRuleTarget"||Ourl.indexOf("/management/Index/addRuleTarget")>=0){
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
            <p>
                <label for="login-id" class="email">邮箱</label>
                <input type="text" name="addname" id="email" class="input-role-name"/>
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
            <button type="button" class="alert-btn2">删除</button>
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
</body>
</html>