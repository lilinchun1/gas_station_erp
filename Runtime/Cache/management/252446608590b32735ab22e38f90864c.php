<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>版本升级</title>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
						<script type="text/javascript" src="__PUBLIC__/js/script_city.js"></script>
	<script type="text/javascript">
		$(function(){
			//================================================================默认动作

			//================================================================触发操作
			//创建，编辑弹出框
			$('.status_add,.status_udp').click(function(){
				$(".updateId").val("");
				if($(this).hasClass("status_udp")){
					var updateId = $("input[name='app-info']:checked").val();
					if(!updateId){
						alert("请选择编辑条目");
						return;
					}
					var update_status = $("input[name='app-info']:checked").parent().parent().find(".update_status_list").val();
					if(update_status != 0){
						alert("不能编辑");
						return;
					}
					//获取各版本号
					var smartApp_no = $("input[name='app-info']:checked").parent().parent().find(".smartApp_list").text();
					var videoPlayer_no = $("input[name='app-info']:checked").parent().parent().find(".videoPlayer_list").text();
					var updateApp_no = $("input[name='app-info']:checked").parent().parent().find(".updateApp_list").text();
					var smartGuard_no = $("input[name='app-info']:checked").parent().parent().find(".smartGuard_list").text();
					
					$(".updateId").val(updateId);
					
					$("#smartAppNo").val(smartApp_no);
					$("#videoPlayerNo").val(videoPlayer_no);
					$("#updateAppNo").val(updateApp_no);
					$("#smartGuardNo").val(smartGuard_no);
					
					var now=new Date().getTime();//加个时间戳表示每次是新的请求
					$.ajax({
						type: "POST",
						url: "<?php echo U('management/Index/getAreaIdByUpdate');?>",
						data:{"updateId":updateId},
						async: false,
						dataType: "json",
						success: function(data){
							//alert(data);
							$("#target_num").val(data);
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert("请求失败!");
						}
					});
				}
				//===================================================树形结构开始==========
				var handleUrl="<?php echo U('management/Index/getChannelArr');?>";
				var zNodes=new Array();
				var str = new String();
				var arr = new Array();
				str = $("#target_num").val();
				arr = str.split(',');// 注split可以用字符或字符串分割
				var now=new Date().getTime();//加个时间戳表示每次是新的请求
				$.ajax({
					type: "POST",
					url: handleUrl,
					async: false,
					dataType: "json",
					success: function(data){
						$.each(data,function(key,val){
							var kid=val['id'];
							var parent=val['pid'];
							var value=val['value'];
							var length=val['length'];
							for ( var i = 0; i < arr.length; i++) {
								if (arr[i] == kid) {
									zNodes[key]= {'id':kid, 'pId':parent, 'name':value ,'checked' : true};
									break;
								} else {
									zNodes[key]= {'id':kid, 'pId':parent, 'name':value };
								};
							};
						});
					},

					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert("请求失败!");
					}
				});
				$.fn.zTree.init($("#treeDemo"), setting, zNodes);
				//===================================================树形结构结束==========
				//弹出窗口
				showWindow(1,16,17,'#j_add_win');
			});
			if($.browser.mozilla) {
				//file判断
				$("#smartApp").change(function(){
					 var val=$(this).val();  
					 if(val=="SmartApp.exe"){
						return true;
					 } else{
						alert("请选择SmartApp.exe文件");
						$(this).val("");  
						return false;
					 }
				});
				$("#videoPlayer").change(function(){
					 var val=$(this).val();  
					 if(val=="VideoPlayer.exe"){  
						return true;
					 } else{
						alert("请选择VideoPlayer.exe文件");
						$(this).val("");  
						return false;
					 }
				});
				$("#updateApp").change(function(){
					 var val=$(this).val();
					 if(val=="UpdateApp.exe"){
						return true;
					 } else{
						alert("请选择UpdateApp.exe文件");
						$(this).val("");  
						return false;
					 }
				});
				$("#smartGuard").change(function(){
					 var val=$(this).val();  
					 if(val=="SmartGuard.exe"){  
						return true;
					 } else{
						alert("请选择SmartGuard.exe文件");
						$(this).val("");  
						return false;
					 }
				});
			}
			//保存约束
			$("#add_submit").click(function(){
				var smartApp_file =$("#smartApp").val();
				var smartApp_no   =$("#smartAppNo").val();

				var videoPlayer_file =$("#videoPlayer").val();
				var videoPlayer_no   =$("#videoPlayerNo").val();

				var updateApp_file =$("#updateApp").val();
				var updateApp_no   =$("#updateAppNo").val();

				var smartGuard_file =$("#smartGuard").val();
				var smartGuard_no   =$("#smartGuardNo").val();
				if(smartApp_file==""&&smartApp_no!=""){
					alert("请选择SmartApp.exe文件");
					return false;
				}
				if(smartApp_file!=""&&smartApp_no==""){
					alert("请输入SmartApp的版本号");
					return false;
				}


				if(videoPlayer_file==""&&videoPlayer_no!=""){
					alert("请选择videoPlayer.exe文件");
					return false;
				}
				if(videoPlayer_file!=""&&videoPlayer_no==""){
					alert("请输入videoPlayer的版本号");
					return false;
				}


				if(updateApp_file==""&&updateApp_no!=""){
					alert("请选择updateApp.exe文件");
					return false;
				}
				if(updateApp_file!=""&&updateApp_no==""){
					alert("请输入updateApp的版本号");
					return false;
				}


				if(smartGuard_file==""&&smartGuard_no!=""){
					alert("请选择smartGuard.exe文件");
					return false;
				}
				if(smartGuard_file!=""&&smartGuard_no==""){
					alert("请输入smartGuard的版本号");
					return false;
				}

				if(smartApp_no==""&&videoPlayer_no==""&&updateApp_no==""&&smartGuard_no==""){
					alert("请上传至少一个版本数据");
					return false;
				}
				if($('#target_num').val()==""){
					alert("请选择发布渠道");
					return false;
				}
			});
			//删除，更新弹出框
			$(".status_del,.status_send").click(function(){
				var updateId = $("input[name='app-info']:checked").val();
				//获取状态值
				var update_status = $("input[name='app-info']:checked").parent().parent().find(".update_status_list").val();
				if($(this).hasClass("status_del")){
					var noSelMes = "请选择删除条目";
					//改变确认框内容
					$(".delete-message").text("确认删除？");
					$(".del_fb_zf").text("删除");
					$(".del_fb_zf").val("1");
					$("#j_del_win").find("form").attr("action","<?php echo U('management/Index/verup_del');?>");
					if(update_status != 0){
						alert("不能删除");
						return;
					}
				}else if($(this).hasClass("status_send")){
					var noSelMes = "请选择更新条目";
					$(".delete-message").text("确认更新？");
					$(".del_fb_zf").text("更新");
					$(".del_fb_zf").val("2");
					$("#j_del_win").find("form").attr("action","<?php echo U('management/Index/verup_use');?>");
					if(update_status != 0){
						alert("不能更新");
						return;
					}
				}

				if(!updateId){
					alert(noSelMes);
					return;
				}
				$("#updateId_hid").val(updateId);
				
				//弹出页面
				$.openDOMWindow({
					loader:1,
					loaderHeight:16,
					loaderWidth:17,
					windowSourceID:'#j_del_win'
				});
				return false;
			});
			
		channel_name_blurry();
		device_sswd_blurry();
		//查看发布渠道
		$(".j_selrole_button").click(function() {
			var send_id=$(this).parent().find(".app_list_radio").val();
			var quanxian_idurl="<?php echo U('management/Index/getAreaIdByUpdate');?>";
			$.ajax({
				type : "POST",
				url : quanxian_idurl,
				async : false,
				dataType : "json",
				data:{"updateId":send_id},
				success : function(data) {
					$("#quanxian_id").val(data);
				},

				error : function(XMLHttpRequest, textStatus, errorThrown) {
					// alert("请求失败!");
				}
			});
			var handleUrl =  "<?php echo U('management/Index/getChannelArr');?>";
			var zNodes = new Array();
			var now = new Date().getTime();// 加个时间戳表示每次是新的请求
			var str = new String();
			var arr = new Array();
			str = $("#quanxian_id").val();
			arr = str.split(',');// 注split可以用字符或字符串分割
			var idkey = "";

			$.ajax({
				type : "POST",
				url : handleUrl,
				async : false,
				dataType : "json",
				success : function(data) {
					$.each(data, function(key, val) {
						var kid = val['id'];
						var parent = val['pid'];
						var value = val['value'];
						for ( var i = 0; i < arr.length; i++) {
							if (arr[i] == kid) {
								zNodes[key] = {
									'id' : kid,
									'pId' : parent,
									'name' : value,
									'open' : false,
									'checked' : true,
									't' : kid,
									doCheck : false,
									"chkDisabled":true
								};
								break;
							} else {
								zNodes[key] = {
									'id' : kid,
									'pId' : parent,
									'name' : value,
									'open' : false,
									't' : kid,
									doCheck : false,
									"chkDisabled":true
								};
							}
						}

					});
				},

				error : function(XMLHttpRequest, textStatus, errorThrown) {
					// alert("请求失败!");
				}
			});
			var show_setting = getTreeSetting(true,true,false,show_beforeCheck,onCheck);
			
			$.fn.zTree.init($("#show_treeDemo"), show_setting, zNodes);
			var code, log, className = "dark";
			function show_beforeCheck(treeId, treeNode) {
				className = (className === "dark" ? "":"dark");
				showLog("[ "+getTime()+" beforeCheck ]&nbsp;&nbsp;&nbsp;&nbsp;" + treeNode.name );
				return (treeNode.doCheck !== false);
			}
			showWindow(1,16,17,'#j_show_purview');
			return false;
		});
		//查看发布渠道结束

		//点一行则选中

		$(".app_info_list").click(function(){
			$(this).find(".app_list_radio").attr("checked",true);
		});
		$("#j_close").click(function(){
			window.location.href = window.location.href;
		});
		
		$(".role-control-update").click(function(){
			 $.openDOMWindow({
				loader:1,
				loaderHeight:16,
				loaderWidth:17,
				width:1300,
				windowSourceID:'#j_show_update'
			});
			return false;
		});
	});
	function device_sswd_blurry()
	{
		var handleUrl = "<?php echo U('management/Index/devicsswdblurry');?>";
		$.getJSON(handleUrl,{},
			function (data){
				var str = data;
				$("#yichang_address").bigAutocomplete({width:150,data:data,callback:function(data){}});
			}
			,'json'
		);
	}
	function channel_name_blurry()
	{
		var handleUrl = "<?php echo U('channel/Channel/channelnameBlurrySelect');?>";
		var channel_name = '';
		$.getJSON(handleUrl,{},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#yichang_place_name").bigAutocomplete({width:150,data:data,callback:function(data){}});
			}
			,'json'
		);
	}

	</script>
</head>
<body>
<div class="head-wrap">
<div id="head">
    <h1 class="head-logo"><a href="<?php echo U('configuration/Login/default_index');?>">ERP管理系统</a></h1>
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
		
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>刊例管理<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>"><input type="button" value="刊例维护"></a></li>
            <li class="url_link" url="<?php echo U('management/Index/addRuleTarget');?>"><a href="<?php echo U('management/Index/addRuleTarget');?>"><input type="button" class="" value="刊例发布"></a></li>
            <li class="url_link" url="<?php echo U('management/Index/verup');?>"><a href="<?php echo U('management/Index/verup');?>"><input type="button" class="" value="版本升级"></a></li>
        </ul>
    </li>
</ul>

	</div>
	<div class="right">
		<div class="right-con">
			<div class="org-right-con">
				<div class="role-control" id="j-fixed-top">
					<div class="role-inquire channel-index-btns">
						<form action="" method="post">
							<p>
								<label for="channel-org-name" class="">SmartApp</label>
								<input type="text" name="smartApp" id="channel-org-name" class="input-org-info"/>
								<label for="maintain-create-people" class="">VideoPlayer</label>
								<input type="text" name="videoPlayer" id="maintain-create-people" class="input-org-info"/>
								<label for="maintain-create-date" class="">UpdateApp</label>
								<input type="text" name="updateApp" id="maintain-create-date" class="input-org-info"/>
								<label for="maintain-create-date" class="">SmartGuard</label>
								<input type="text" name="smartGuard" id="maintain-create-date" class="input-org-info"/>
								<button type="submit" name="select" class="role-control-btn">查询</button>
								<button type="button" id="verupDele" name="select" class="role-control-btn">清空</button>
							</p>
						</form>
					</div>
					<div class="org-right-btns">
						<form action="">
							<button type="button" class="area-btn status_add">添加</button>
							<button type="button" class="area-btn status_udp">编辑</button>
							<button type="button" class="area-btn status_del">删除</button>
							<button type="button" class="area-btn status_send">更新</button>
						</form>
					</div>
				</div>
				<div class="role-table">
					<div class="bd over-h-y">
						<ul class="role-table-list">
							<li>
								<span class="span-1"></span>
								<span class="span-1"><b>SmartApp</b></span>
								<span class="span-1"><b>VideoPlayer</b></span>
								<span class="span-1"><b>UpdateApp</b></span>
								<span class="span-1"><b>SmartGuard</b></span>
								<span class="span-1"><b>发布渠道</b></span>
								<span class="span-1"><b>发布状态</b></span>
								<span class="span-2"><b>更新日期</b></span>
								<span class="span-1"><b>更新信息</b></span>
							</li>
							<?php if(is_array($app_dev_update_arr)): foreach($app_dev_update_arr as $key=>$app_dev_update): ?><li class="app_info_list">
								<span class="span-1"><input type="radio" name="app-info"  class="app_list_radio" value="<?php echo ($app_dev_update['id']); ?>"/></span>
								<span class="span-1 smartApp_list"><?php echo ($app_dev_update['smart_app']); ?></span>
								<span class="span-1 videoPlayer_list"><?php echo ($app_dev_update['video_player']); ?></span>
								<span class="span-1 updateApp_list"><?php echo ($app_dev_update['update_app']); ?></span>
								<span class="span-1 smartGuard_list"><?php echo ($app_dev_update['smart_guard']); ?></span>
								<span class="j_selrole_button fthover span-1" title="发布渠道">发布渠道</span>
								<span class="span-1">
									<?php if($app_dev_update['status'] == 0): ?>待更新
									<?php else: ?>
										已更新<?php endif; ?>
									<input type="hidden" class="update_status_list" value="<?php echo ($app_dev_update['status']); ?>"/>
								</span>
								<span class="span-2"><?php echo ($app_dev_update['status_date']); ?></span>
								<span id="select_cli" class="role-control-update span-1" value="<?php echo ($app_dev_update['id']); ?>" >更新信息</span>
							</li><?php endforeach; endif; ?>
						</ul>
						<div class="resultpage"><?php echo ($page); ?></div>
						<input type="hidden" value="" id="quanxian_id"/>
					</div>
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
	<div class="alert-role-add exit-alert" >
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
<!--创建弹出框-->
<div class="alert-org-add" id="j_add_win" style=" display:none;">
	<div class="verup-alert-add">
		<form action="<?php echo U('management/Index/verup_add_udp');?>" method="post" enctype="multipart/form-data">
			<h3>版本信息</h3>
			<div class="verup-alert-con">
				<div class="verup-alert-con-left">
					<p>
						<label for="smartApp">SmartApp&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<input type="file" name="smartApp" id="smartApp" class="" style="border: 0 none; width: 69px;"/>
						<label for="main-pg">版本号</label>
						<input type="text" name="smartAppNo" id="smartAppNo" class="input-org-info"/>
					</p>
					<p>
						<label for="videoPlayer">VideoPlayer</label>
						<input type="file" name="videoPlayer" id="videoPlayer" class="input-org-info" style="border: 0 none; width: 72px;"/>
						<label for="main-pg">版本号</label>
						<input type="text" name="videoPlayerNo" id="videoPlayerNo" class="input-org-info"/>
					</p>
					<p>
						<label for="updateApp">UpdateApp</label>
						<input type="file" name="updateApp" id="updateApp" class="input-org-info" style="border: 0 none; width: 72px;"/>
						<label for="main-pg">版本号</label>
						<input type="text" name="updateAppNo" id="updateAppNo" class="input-org-info"/>
					</p>
					<p>
						<label for="smartGuard">SmartGuard</label>
						<input type="file" name="smartGuard" id="smartGuard" class="input-org-info" style="border: 0 none; width: 72px;"/>
						<label for="main-pg">版本号</label>
						<input type="text" name="smartGuardNo" id="smartGuardNo" class="input-org-info"/>
					</p>
				</div>
				<div class="verup-alert-con-right">
					<p>发布渠道</p>
					<div class="verup-tree-tab">
						<input type="hidden" name="target_num" id="target_num" class="input-role-name" value=""/>
					</div>
					<div class="zTreeDemoBackground left">
						<ul id="treeDemo" class="ztree"></ul>
					</div>
				</div>
				<div class="alt-btn-sc cf">
					<input type="hidden" name="updateId" class="updateId" value=""/>
					<button type="submit" name="add_udp" class="alert-btn4" value="1" id="add_submit">保存</button>
					
					<button type="button" class="alert-btn" id="j_close">关闭</button>

				</div>
			</div>
		</form>
	</div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<form action="" method="post">
			<h3>APP</h3>
			<div class="alert-role-add-con">
				<p class="delete-message">确认删除？</p>
				<p>
					<input type="hidden" name="updateId_hid" id="updateId_hid" value=""/>
					<button type="submit" name="del_fb_zf" class="alert-btn2 del_fb_zf" id="j_del_ok" value="1">删除</button>
					<a href="." class="closeDOMWindow">
						<button type="button" class="alert-btn2">关闭</button>
					</a>
				</p>
			</div>
		</form>
	</div>
</div>
<!--发布渠道-->
<div id="j_show_purview" style="display:none">
	<div class="alert-role-add">
		<h3>发布渠道</h3>

				<div class="zTreeDemoBackground left">
					<ul id="show_treeDemo" class="ztree"></ul>
					<input type="text" value="" id="show_quanxian_id"/>
				</div>

		<a href="." class="closeDOMWindow">
			<button type="button" class="alert-btn2">关闭</button>
		</a>
		<div class="bk10"></div>
	</div>
</div>
<!--弹出表格框-->
<div id="j_show_update" style="display:none">
    <div class="alert-table1" style="background:#fff;width:100%">
        <div class="role-inquire channel-index-btns">
            <form name="deviceSelect" method="post" action="<?php echo U('management/Index/verupUpda');?>">
                <p>
                    <label for="select_showcity" class="">所在区域</label>
               		<span id="select_showcity_up"></span>
                    <label for="yichang_place_name" class="">渠道名称</label>
                    <input type="text" name="yichang_place_name" id="yichang_place_name" value="" class="input-org-info"/>
                    <label for="yichang_address" class="">网点名称</label>
                    <input type="text" name="yichang_address" id="yichang_address" value="" class="input-org-info"/>
                    <label for="yichang_devMac" class="">MAC</label>
                    <input type="text" name="yichang_devMac" id="yichang_devMac" value="" class="input-org-info"/>
                    <br>
                    <label for="yichang_devNo" class="">状态</label>
                    <select class="channel-select" name="channelselect" id="channelselect">
                        <option>更新成功</option>
                        <option>更新失败</option>
                    </select>
              <!--   <button type="submit" class="role-control-btn">查询</button>-->
				   <button type="button" class="role-control-btn" id="yichang_select" onClick="show_yichang()">查询</button>
                     <button type="button" class="role-control-btn">导出</button>
					   <a href="." class="closeDOMWindow">
           			 		<button type="button" class="alert-btn2">关闭</button>
      				   </a>
                </p>

            </form>
        </div>
        <ul class="statistics-list" style="border:0" id="ul_list">
            <li>
                <span class='span-1'><b>省份</b></span>
                <span class='span-1'><b>城市</b></span>
                <span class='span-1'><b>渠道名称</b></span>
                <span class='span-1'><b>所属网点</b></span>
                <span class='span-1'><b>加油站编号</b></span>
                <span class='span-1'><b>MAC</b></span>
                <span class='span-1'><b>SmartApp</b></span>
                <span class='span-1'><b>VideoPlayer</b></span>
                <span class='span-1'><b>Update-App</b></span>
                <span class='span-1'><b>SmartGuard</b></span>
            </li>
        </ul>
		<span id="yichang_up_page">上一页</span> <span id="dang_page" ></span> <span id="yichang_down_page">下一页</span>     共<span id="zong_page"></span>页
      
    </div>
</div>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/jquery.bigautocomplete.css"/>
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>


<!--树形结构类-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript">
showprovince("select_province", "select_city", "<?php echo ($_GET['select_province']); ?>", "select_showcity_up");
showcity("select_city", "<?php echo ($_GET['select_city']); ?>", "select_province", "select_showcity_up");
</script>
<script type="text/javascript">



//===================================================树形结构js==========================
var setting = {
	check: {
		enable: true
	},
	data: {
		simpleData: {
			enable: true
		}
	},
	view: {
		dblClickExpand: false
	},
	callback: {

		onCheck: onCheck
		
	}
};
var code;
function onCheck(event, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("treeDemo");
	nodes = zTree.getCheckedNodes(true);

	var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
	var halfCheck = treeObj.getNodes()[0].getCheckStatus();
	
	//console.log(node);
	v = "";
	for (var i=0, l=nodes.length; i<l; i++) {
		v += nodes[i].id + ",";
	}
	if (v.length > 0 ) v = v.substring(0, v.length-1);
	//要赋值的文本框id
	var cityObj = $("#target_num");
	cityObj.attr("value", v);
}
//===================================================树形结构js结束==========

var key=1;
var p=1;


$("#yichang_up_page").click(function(){
	if(p--<=1){
		p=1;
	}	
	show_yichang();
});
$("#yichang_down_page").click(function(){
	if(p++>=key){
		p=key;		
	}
	show_yichang();
});

function show_yichang(){
	
	$(".select_li").remove();//初始化
	var select_id=$('input:radio:checked').val();
	var select_province=$("#select_province").val();
	var select_city=$("#select_city").val();
	var yichang_place_name=$("#yichang_place_name").val();
	var yichang_address=$("#yichang_address").val();
	var yichang_devMac=$("#yichang_devMac").val();
	var channelselect=$("#channelselect").val();
	
	var handleUrl = "<?php echo U('management/Index/verupUpda');?>";
	$.getJSON(handleUrl,{
		"select_province":select_province,
		"select_city":select_city,
		"yichang_place_name":yichang_place_name,
		"yichang_address":yichang_address,
		"yichang_devMac":yichang_devMac,
		"channelselect":channelselect,
		"select_id":select_id,
		},
		function (data){
		if(data==''){
			$("#dang_page").text(1);
			$("#zong_page").text(1);
			key=1;
		}
			$("#dang_page").text(p);
			//alert($('#pageNum').val());//页数
			$.each(data, function(i,item){
		
			var count_page=parseInt(data.length/5)+1;//共多少页
			$("#zong_page").text(count_page);
			var cou_page=parseInt(data.length%5);//最后一页
			key=count_page;
				if((p<count_page) && (i>=(p-1)*5) && (i<p*5)){
					$("#ul_list").append("<li class='select_li'><span class='span-1'>"+item['province']+"</span><span class='span-1'>"+
					item['city']+"</span><span class='span-1'>"+
					item['channel_name']+"</span><span class='span-1'>"+
					item['place_name']+"</span><span class='span-1'>"+
					item['device_no']+"</span><span class='span-1'>"+
					item['dev_mac']+"</span><span class='span-1'>"+
					item['smart_app']+"</span><span class='span-1'>"+
					item['video_player']+"</span><span class='span-1'>"+
					item['update_app']+"</span><span class='span-1'>"+
					item['smart_guard']+"</span></li>");		
				}else if((p==count_page) && (i>=p-1*5) && (i<cou_page)){
					$("#ul_list").append("<li class='select_li'><span class='span-1'>"+item['province']+"</span><span class='span-1'>"+
					item['city']+"</span><span class='span-1'>"+
					item['channel_name']+"</span><span class='span-1'>"+
					item['place_name']+"</span><span class='span-1'>"+
					item['device_no']+"</span><span class='span-1'>"+
					item['dev_mac']+"</span><span class='span-1'>"+
					item['smart_app']+"</span><span class='span-1'>"+
					item['video_player']+"</span><span class='span-1'>"+
					item['update_app']+"</span><span class='span-1'>"+
					item['smart_guard']+"</span></li>");		
				}
			});
			
		}
	,'json'
	);
	


}
</script>
</body>
</html>