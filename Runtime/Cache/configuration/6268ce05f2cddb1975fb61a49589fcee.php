<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>职员维护</title>
	<!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
	<link rel="stylesheet" href="	__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
    <style>
        .role-table-list{
            min-width: 1250px;
        }
    </style>
</head>
<body>
<div class="head-wrap">
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">智能手机加油站业务支撑系统</h2>
    <div class="login">
        <div class="left">
            <ul class="left-nav">
                <li><?php echo ($username); ?>,您好 <span></span>
                    <ul>
                        <li><a href="javascript:void(0);" onclick="show_change_password()">修改密码</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="right">
            <a href="javascript:void(0);" onclick="show_user_logout()">退出系统</a>
        </div>
    </div>
</div>
<div id="nav">
    <ul class="main-nav" id="j-nav-active">
        <li class="url_link" url="<?php echo U('monitoring/Index/station');?>"><a href="<?php echo U('monitoring/Index/station');?>">加油站监控</a></li>
        <li class="url_link" url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>">运营管理</a></li>
        <li class="url_link" url="<?php echo U('statistics/Index/index');?>"><a href="<?php echo U('statistics/Index/index');?>">统计分析</a></li>
     <!--   <li class="url_link" url="<?php echo U('ad/Index/index');?>"><a href="<?php echo U('ad/Index/index');?>">广告管理</a></li> -->
        <li class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
</div>


<div id="container">
	<div class="left">
		
<ul class="aside-nav cf">
    <li class="aside-nav-nth1" ><a>系统设置<i class="j-show-list">-</i></a>
            <ul><li class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="<?php echo U('configuration/Org/index');?>"><input  type="button"  value="组织机构" ></a></li>
                <li class="url_link" url="<?php echo U('configuration/Role/show_role');?>"><a href="<?php echo U('configuration/Role/show_role');?>"><input type="button" class="" value="角色维护" ></a></li>
                <li class="url_link" url="<?php echo U('configuration/User/index');?>"><a href="<?php echo U('configuration/User/index');?>"><input type="button" class="" value="职员维护" ></a></li></ul>
    </li>

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
							<input type="submit" id="select_button" name="select_button" class="role-control-btn" value="查询"/>
						</form>
					</div>
					<div class="org-right-btns">
						<form action="">
							<button type="button" class="area-btn" id="j_add_button">添加</button>
							<button type="button" class="area-btn" id="j_mod_button">编辑</button>
							<button type="button" id="j_del_button" class="area-btn">删除</button>
							<button type="button" id="j_reset_password" class="area-btn">重置密码</button>
							<button type="button" id="j_modify_user_state" class="area-btn">激活/失效</button>
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
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="list_sel">
								<span class="span-1">
									<input type="radio" name="radio_list" id="<?php echo ($vo['userRadioID']); ?>" value="<?php echo ($vo['uid']); ?>"  class="role-table-radio"/>
								</span>
								<span class="span-1" title="<?php echo ($vo["realname"]); ?>"><?php echo ($vo["realname"]); ?></span>
								<span class="span-1" title="<?php echo ($vo["sex"]); ?>"><?php echo ($vo["sex"]); ?></span>
								<span class="span-1" title="<?php echo ($vo["telphone"]); ?>"><?php echo ($vo["telphone"]); ?></span>
								<span class="span-3" title="<?php echo ($vo["orgname"]); ?>"><?php echo ($vo["orgname"]); ?></span>
								<span class="span-2" title="<?php echo ($vo["username"]); ?>"><?php echo ($vo["username"]); ?></span>
								<span class="span-1" title="<?php echo ($vo["rolename"]); ?>"><?php echo ($vo["rolename"]); ?></span>
								<span class="span-1" title="<?php echo ($vo["del_flag"]); ?>"><?php echo ($vo["del_flag"]); ?></span>
								<span class="roleid_hidden" style="display:none;" title="#"><?php echo ($vo["uid"]); ?></span>

							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div class="resultpage"><?php echo ($page); ?></div>
			</div>
				<div class="role-table over-h-y rizhi">
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
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
    <p>© 大连捷诺科技有限公司 | <a style="color: #ffffff;" href="http://www.jienuo-service.net/" target="_blank">关于捷诺</a> | 服务热线 0411-86887659</p>
</div>
<!-- 控制菜单显示 -->
<input type="hidden" class="urlStr" value="<?php echo ($urlStr); ?>">
<!-- 控制当期页面菜单样式 -->
<input type="hidden" class="nowUrl" value="<?php echo ($nowUrl); ?>">
<script type="text/javascript" src="__PUBLIC__/js/default_load.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<div id="change_password_id" style="display:none;">
    <div class="alert-role-add" >
    <h3>修改密码</h3>
    <div class="alert-role-add-con pdl50">
        <p>
            <label for="old_password_txt" class="role-lab">旧密码&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="old_password_txt" id="old_password_txt" class="input-role-name"/>
        </p>
        <p>
            <label for="new_password_txt" class="role-lab">新密码&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="new_password_txt" id="new_password_txt" class="input-role-name"/>
        </p>
        <p>
            <label for="re_new_password_txt" class="role-lab">确认密码</label>
            <input type="password" name="re_new_password_txt" id="re_new_password_txt" class="input-role-name"/>
        </p>
        <p>
            <button type="button" class="alert-btn3" onclick="change_password()">修改密码</button>
			<a href="." class="closeDOMWindow">
				<button type="button" class="alert-btn2">关闭</button>
			</a>
        </p> 
    </div>
</div>
</div>

<div class="divout" id="j_logout_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>退出</h3>
		<div class="alert-role-add-con">
			<p class="delete-message">确认退出？</p>
			<p>
				<button type="button" class="alert-btn-exit" id="j_logout_ok" onclick="user_logout()">确定</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn-exit">关闭</button>
				</a>
			</p>
		</div>
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
		var pwReg = /[a-zA-Z0-9]{6,16}/;
		if(new_password_txt.length<6||!pwReg.test(new_password_txt)){
			alert("输入的密码不能小于6个字符，且只能为英文或者数字");
			return false;
		}
		$.getJSON(handleUrl,{'old_password_txt':old_password_txt,'new_password_txt':new_password_txt,'re_new_password_txt':re_new_password_txt},
			function (data){
				var tmp_msg = "<?php echo C('change_password_success');?>";
					if(tmp_msg == data)
					{
						alert(data);
						user_logout();
						//window.location.href = window.location.href;
					}
					else
					{
						alert(data);
					}
			}
			,'json'
		);
	}

	function user_logout(){
		var handleUrl = "<?php echo U('configuration/Login/logout');?>";
		window.location.href = handleUrl;
	}

    function headAct(){
        var Ourl = window.location.href;
        if(!document.getElementById('j-nav-active')){return;};
        var Onav = document.getElementById('j-nav-active');
        var nbLi = Onav.getElementsByTagName('li');
        for(var i=0; i<nbLi.length;i++){
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0||Ourl=="/gas_station_erp/index.php/Role/index"||Ourl.indexOf("/gas_station_erp/index.php/Role/index")>=0||Ourl=="/gas_station_erp/index.php/User/index"||Ourl.indexOf("/gas_station_erp/index.php/User/index")>=0||Ourl=="/configuration/Org/index"||Ourl.indexOf("/configuration/Org/index")>=0){
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
<script>
    $(function(){
        $('.aside-nav-nth1 a').click(function(event){
            var oUl1 = $(this).next('ul');
            var OI1 = $(this).find('.j-show-list');
            if(oUl1.is(':visible')){
                OI1.html('+');
                oUl1.hide();
            }else if(oUl1.is(':hidden')){
                OI1.html('-');
                oUl1.show();
            }
            event.stopPropagation();
        });

    })
</script>
<script type="text/javascript">
    function show_change_password(){
        //$('#change_password_id').show();
        $.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#change_password_id'
        });
        return false;
    }

    function show_user_logout(){
        //$('#change_password_id').show();
        $.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#j_logout_win'
        });
        return false;
    }
</script>
<div id="j_add_win" style="display:none;">
	<div class="alert-role-add">
		<h3 class="h_title">添加职员信息</h3>
		<div class="alert-user-add-con">
			<form action="">
				<p>
					<label for="realname" class="role-lab">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</label>
					<input type="text" name="addname" id="realname" class="input-role-name"/><i class="red-color pdl10">*</i>
					<input type="radio" name="change-sex" class="change-sex" id="man" value="1"/><label for="man" class="sex">男</label>
					<input type="radio" name="change-sex" class="change-sex" id="woman" value="0"/><label for="woman" class="sex">女</label>
				</p>
				<p>
					<label for="user-phone" class="role-lab">联系电话</label>
					<input type="text" name="addname" id="user-phone" class="input-role-name"/>
				</p>
				<p>
					<label for="login-id" class="role-lab">登陆账号</label>
					<input type="text" name="addname" id="login-id" class="input-role-name"/><i class="red-color pdl10">*</i>
				</p>
				<p>
					<label for="login-id" class="email">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
					<input type="text" name="addname" id="email" class="input-role-name"/>
				</p>
				<p>
					<label for="role_agent_id" class="role-lab">所属组织</label>
					<select id="role_agent_id" class="role_agent_id">
						<option value="">请选择组织</option>
					</select>
				</p>
				<div>
					<label>角色</label>
					<ul class="user-checkbox-list" id="j_ul_checkbox">

					</ul>
				</div>
				<p>
					<input type="hidden" name="uid_hid" class="uid_hid"/>
					<button type="button" class="alert-btn2" id="j_add_save">保存</button>
					<button type="button" class="alert-btn2" id="j_close">关闭</button>

				</p>
			</form>
		</div>
	</div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>职员信息</h3>
		<div class="alert-role-add-con">
			<p class="delete-message">请确认是否删除？</p>
			<input type="hidden" value="" id="del_id_hidden"/>
			<p>
				<button type="button" class="alert-btn2" id="j_del_ok">确定</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">取消</button>
				</a>
			</p>
		</div>
	</div>
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/jquery.bigautocomplete.css" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script>
$(function(){
	//赋组织值
	var getAgentUrl = "<?php echo U('configuration/Role/getAgentArr');?>";
	$.post(getAgentUrl,{},function(data){
		$.each(data,function(i,n){
			var mstr = "";
			switch(n['lv']){
				case 1:mstr = "==";break;
				case 2:mstr = "====";break;
				case 3:mstr = "======";break;
				case 4:mstr = "========";break;
				case 5:mstr = "==========";break;
				case 6:mstr = "============";break;
			}
			$(".role_agent_id").append("<option value='"+n['agent_id']+"'>"+mstr+n['agent_name']+"</option>");
		})
	},"json");
	//组织改变触发
	$(".role_agent_id").change(function(){
		var role_agent_id = $(this).val();
		//组织改变后之前选中的角色取消
		roleStr = "";
		role_check(role_agent_id);
	});
	
	
	//点一行则选中
	$(".list_sel").click(function(){
		$(this).find(".role-table-radio").attr("checked",true); 
	});
	
});

//保持组织id用,分割
var roleStr = "";
//复选框触发
function j_checkbox(obj){
	if($(obj).attr("checked")){
		roleStr += $(obj).val()+",";
	}else{
		roleStr = roleStr.replace($(obj).val()+",","");
	}
}
//给定组织id显示该组织下角色，并赋已选中的角色
function role_check(role_agent_id){
	var getAgentUrl = "<?php echo U('configuration/Role/getRoleByAgentId');?>";
	$.post(getAgentUrl,{'role_agent_id':role_agent_id},function(data){
		$('#j_ul_checkbox li').remove();
		$.each(data,function(i,n){
			checked = "";
			if(roleStr.indexOf(n['roleid']+",") >= 0 )
			{
				checked = "checked"
			}
			$('#j_ul_checkbox').append("<li><input type='checkbox' name='role' class='j_checkbox' value='"+n['roleid']+"' onclick='j_checkbox(this)' "+checked+"/><label for='ck1' class='role-lab'>"+n['rolename']+"</label></li>");
		})
	},"json");
}

	$(document).ready(function () {
		//单击 添加/编辑 按钮
		$('#j_add_button,#j_mod_button').click(function(){
			//为添加
			if($(this).attr("id") == "j_add_button"){
				$(".h_title").text("添加职员信息");
				//给隐藏域赋空值
				$(".uid_hid").val("");
			//为编辑
			}else if($(this).attr("id") == "j_mod_button"){
				$(".h_title").text("修改职员信息");
				var user_id= $("input[name='radio_list']:checked").val();
				//显示
				if(!user_id){
					alert("请选择编辑条目");
					return;
				}
				//给隐藏域赋值
				$(".uid_hid").val(user_id);
				//给编辑框赋值
				var mod_handleUrl="<?php echo U('configuration/User/userDetailSelect');?>";
				//组织id
				var agent_id;
				$.getJSON(mod_handleUrl,{ "user_id":user_id},
					function (data){
					   //alert(data['username']);
						$("#realname").val(data['realname']);
						$("#user-phone").val(data['telphone']);
						$("#login-id").val(data['username']);
						$("#email").val(data['email']);

						agent_id = data['orgid'];
						//改变组织下拉框
						$(".role_agent_id option[value='"+agent_id+"']").attr("selected",true);
						//给角色字符串赋值
						roleStr = data['role_id_str'];
						//指定组织下选中已有的角色
						role_check(agent_id);
						
						//性别赋值
						var sex = data['sex'];
						if(sex == '0'){
							$('#woman').eq(0).attr("checked",true);
						}else{
							$('#man').eq(0).attr("checked",true);
						}
					}
				,'json');
			}
			//弹出窗口
			showWindow(1,16,17,'#j_add_win');
			return false;
		});
		
		//单击保存按钮
		$('#j_add_save').click(function(){
			var user_id = $(".uid_hid").val();
			var handleUrl;
			if(user_id){
				//编辑路径
				handleUrl="<?php echo U('configuration/User/edit_user');?>";
			}else{
				//添加路径
				handleUrl="<?php echo U('configuration/User/add_user');?>";
			}
			var realname = $('#realname').val();	  //姓名
			var login_id= $('#login-id').val(); //登陆账号
			var telphone_txt = $('#user-phone').val();	  //联系电话
			var add_user_email = $('#email').val();	  //邮箱*/
			var user_sex = $(':radio[name="change-sex"]:checked').val(); //性别
			var org_id = $('#role_agent_id').val();  //所属组织机构
			var emailRegExp = new RegExp(		 "[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
			if (!emailRegExp.test(add_user_email)||add_user_email.indexOf('.')==-1){
				alert("请检查邮箱格式");
				return false;
			}

			$.getJSON(handleUrl,{
					"userid_txt":user_id,
					"realname_txt":realname,
					"telphone_txt":telphone_txt,
					"email_txt":add_user_email,
					"user_name_txt":login_id,
					"sex_txt":user_sex,
					"org_txt":org_id,
					"role_txt":roleStr
				},
				function (data){
					alert(data);
					window.location.href = window.location.href;
				}
			,'json');
		});
		
		
		
		//关闭按钮
		$("#j_close").click(function(){
			window.location.href = window.location.href;
		});

		//单击删除确认按钮
		$('#j_del_ok').click(function(){
			var delete_user_id_txt= $("input[name='radio_list']:checked").val();
			var del_handleUrl="<?php echo U('configuration/User/delete_user');?>";
			$.getJSON(del_handleUrl,{"delete_user_id_txt":delete_user_id_txt},
					function (data){
						alert(data);
						window.location.href = window.location.href;
					}
					,'json'
			);
		});

		//重置密码
		$('#j_reset_password').click(function(){
			var reset_userid_txt= $("input[name='radio_list']:checked").val();
			if( !reset_userid_txt ){
				alert("请选择一条职员信息再进行编辑");
				return;
			}
			var del_handleUrl="<?php echo U('configuration/User/reset_password');?>";
			$.getJSON(del_handleUrl,{"reset_userid_txt":reset_userid_txt},
				function (data){
					alert(data);
					window.location.href = window.location.href;
				}
				,'json'
			);
		});

		//激活失效
		$('#j_modify_user_state').click(function(){
			var modify_userid_txt= $("input[name='radio_list']:checked").val();
			if( modify_userid_txt == ''){
				alert("请选择一条职员信息再进行编辑");
				return;
			}
			var del_handleUrl="<?php echo U('configuration/User/modify_user_state');?>";
			$.getJSON(del_handleUrl,{"modify_userid_txt":modify_userid_txt},
				function (data){
					alert(data);
					window.location.href = window.location.href;
				}
				,'json'
			);
		});
			agent_name_blurry();
});
    function agent_name_blurry() {
        var handleUrl = "<?php echo U('channel/Agent/agentnameBlurrySelect');?>";
        var agent_name = '';
        $.getJSON(handleUrl, {"agent_name": agent_name},
                function (data) {
                    var str = data;
                    //alert(data);
                    //alert(str[1]['title']);
                    $("#org_name_txt").bigAutocomplete({width: 150, data: data, callback: function (data) {
                    }});
                }
                , 'json'
        );
    }
</script>
</body>
</html>