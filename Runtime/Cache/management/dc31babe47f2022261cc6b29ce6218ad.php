<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>刊例维护</title>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript">
	$(function(){
		//================================================================默认动作
		//固定标题
		window.onscroll = function () {
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			var fixDiv = document.getElementById('j-fixed-top');
			if (scrollTop >= 300) {
				fixDiv.style.position = 'fixed';
				fixDiv.style.top = '0px';
			} else if (scrollTop <= 299) {
				fixDiv.style.position = 'static';
			}
		}
		//禁止浏览器自动填充
		$("form").attr( "autocomplete","off");
		//================================================================触发
		//添加，编辑弹出框
		$('#rule_no_add,#rule_no_udp').click(function(){
			//编辑
			if($(this).hasClass("rule_no_udp")){
				//获取选中行期刊号
				var rule_no = $("input[name='role-info']:checked").parent().parent().find(".rule_no_list").text();
				if(rule_no == ""){
					alert("请选择编辑条目");
					return;
				}
				//赋值到编辑窗口中
				$("#rule_no_hid").val(rule_no);
				//隐藏域期刊号
				$("#old_rule_no").val(rule_no);
				$("button[name='add_udp']").val("2");
			}else{
				$("button[name='add_udp']").val("1");
			}
			//弹出页面
			$.openDOMWindow({
				loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_add_win'
			});
			return false;
		});
		//删除弹出框
		$(".rule_no_del").click(function(){
			var rule_no = $("input[name='role-info']:checked").parent().parent().find(".rule_no_list").text();
			if(rule_no == ""){
				alert("请选择删除条目");
				return;
			}
			$("#del_rule_no").val(rule_no);
			
			//弹出页面
			$.openDOMWindow({
				loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_del_win'
			});
			return false;
		});
		//点一行则选中
		$(".rule_info_list").click(function(){
			$(this).find(".role-table-radio").attr("checked",true);
		});
		//app查看
		$(".app_info_list").click(function(){
			var rule_no = $(this).parent().parent().find(".rule_no_list").text();
			var val = window.showModalDialog("<?php echo U('management/Index/app_info');?>/rule_no/"+rule_no,self,"dialogwidth=850px;dialogheight=700px;dialogtop=200px;dialogleft=700px;center=no;help=no;resizable=no;status=no;scroll=yes");
		});
	});
	</script>
</head>
<body>
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">智能手机加油站ERP管理系统</h2>
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
        <li class="url_link" url=""><a href="">加油站监控</a></li>
        <li class="url_link" url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>">运营管理</a></li>
        <li class="url_link" url="<?php echo U('channel/Channele/index2');?>"><a href="">统计分析</a></li>
        <li class="url_link" url="<?php echo U('channel/Channele/index2');?>"><a href="">广告管理</a></li>
        <li class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
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
<div id="container">
	<div class="left">
        <ul class="aside-nav">
    <li class="aside-nav-nth1" class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="">APP刊例管理</a></li>
    <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>"><input type="button" value="刊例维护"></a></li>
    <li class="url_link" url="<?php echo U('management/Index/addRuleTarget');?>"><a href="<?php echo U('management/Index/addRuleTarget');?>"><input type="button" class="" value="刊例发布"></a></li>
    <li class="url_link" url="<?php echo U('management/Index/verup');?>"><a href="<?php echo U('management/Index/verup');?>"><input type="button" class="" value="版本升级"></a></li>
</ul>
	</div>
	<div class="right">
		<div class="right-con">
			<div class="org-right-con">
				<div class="role-control" id="j-fixed-top">
					<div class="role-inquire channel-index-btns">
						<form action="" method="post">
							<p>
								<label for="channel-org-name" class="">刊例号</label>
								<input type="text" name="rule_no_sel" id="channel-org-name" class="input-org-info"/>
								<label for="maintain-create-people" class="">创建人</label>
								<input type="text" name="createuser_sel" id="maintain-create-people"
									   class="input-org-info"/>
								<label for="maintain-create-date" class="">创建日期</label>
								<input type="text" name="createtime_sel" id="maintain-create-date" class="input-org-info" onClick="WdatePicker()" readonly/>
								<button type="submit" name="select" class="role-control-btn">查询</button>
							</p>
						</form>
					</div>
					<div class="org-right-btns">
						<form action="">
							<button type="button" id="rule_no_add" class="area-btn rule_no_add">添加</button>
							<button type="button" id="rule_no_udp" class="area-btn rule_no_udp">编辑</button>
							<button type="button" id="rule_no_del" class="area-btn rule_no_del">删除</button>

						</form>
					</div>
				</div>
				<div class="role-table">
					<div class="bd over-h-y">
						<ul class="role-table-list">
							<li>
								<span class="span-1"></span>
								<span class="span-2"><b>刊例号</b></span>
								<span class="span-2"><b>创建人</b></span>
								<span class="span-2"><b>创建日期</b></span>
								<span class="span-3"><b>刊例详情</b></span>

							</li>
							<?php if(is_array($issueArr)): foreach($issueArr as $key=>$issue): ?><li class="rule_info_list">
									<span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
									<span class="span-2 rule_no_list" title="#"><?php echo ($issue["rule_no"]); ?></span>
									<span class="span-2" title="#"><?php echo ($issue["realname"]); ?></span>
									<span class="span-2" title="#"><?php echo ($issue["createtime"]); ?></span>
									<span class="span-3" title="#"><a href="#" class="app_info_list">查看</a></span>
								</li><?php endforeach; endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="footer">

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
    <div class="alert-role-add-con">
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
            <button type="button" class="alert-btn2" onclick="change_password()">修改密码</button>
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
				<button type="button" class="alert-btn2" id="j_logout_ok" onclick="user_logout()">确定</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
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
		$.getJSON(handleUrl,{'old_password_txt':old_password_txt,'new_password_txt':new_password_txt,'re_new_password_txt':re_new_password_txt},
			function (data){
				var tmp_msg = "<?php echo C('change_password_success');?>";
					if(tmp_msg == data)
					{
						alert(data);
						window.location.href = window.location.href;
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

<!-- 创建，编辑刊例 -->
<div class="alert-org-add" id="j_add_win" style=" display:none;">
	<div class="alert-role-add">
		<form action="" method="post" enctype="multipart/form-data">
			<h3>刊例信息</h3>
			<div class="alert-user-add-con">
				<p>
					<label for="rule_no_hid" class="role-lab">刊例名称</label>
					<input type="text" name="rule_no" id="rule_no_hid" class="input-role-name"/>
					<input type="hidden" name="old_rule_no" id="old_rule_no" value=""/>
				</p>
	
				<p>
					<label for="maintain-xx" class="role-lab">刊例明细</label>
					<input type="file" name="app_file" id="maintain-xx" class="input-role-name" style="border: 0 none;"/>
				</p>
	
				<p>
					<button type="submit" name="add_udp" class="alert-btn2" value="1">保存</button>
					<a href="." class="closeDOMWindow">
						<button type="button" class="alert-btn">关闭</button>
					</a>
				</p>
			</div>
		</form>
	</div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<form action="" method="post">
			<h3>期刊</h3>
			<div class="alert-role-add-con">
				<p class="delete-message">确认删除？</p>
				<p>
					<input type="hidden" name="del_rule_no" id="del_rule_no" value=""/>
					<button type="submit" name="delete" class="alert-btn2" id="j_del_ok" value="1">删除</button>
					<a href="." class="closeDOMWindow">
						<button type="button" class="alert-btn2">关闭</button>
					</a>
				</p>
			</div>
		</form>
	</div>
</div>
</body>
</html>