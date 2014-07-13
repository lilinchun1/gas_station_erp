<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>加油站信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
	<link href="__PUBLIC__/js/AjaxFileUploaderV2.1/ajaxfileupload.css" rel="stylesheet" type="text/css" /><!--引用上传的css样式-->
	<style type="text/css">
	.img_up{
		width:110px;
		height:79px;
		background: url(__PUBLIC__/image/img_up.png) no-repeat center top;
		vertical-align:middle;
		border:#ced0d1 solid 1px;
		float:left;
		cursor: pointer;
		margin-left:10px;
	}

	.file{
		  top: 0;
		  right: 0;
		  width: 100%;
		  height: 100%;
		  cursor: pointer;
		  opacity: 0;
		  clear:left;
	}

	</style>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
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

<div id="container" style="min-width: 1550px">
<div class="left">
    
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>渠道管理<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
            <li class="url_link" url="<?php echo U('channel/Place/index');?>"><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
            <li class="url_link" url="<?php echo U('channel/Device/index');?>"><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
        </ul>
    </li>
</ul>

    <!--<ul class="aside-nav">
        <li class="aside-nav-nth1"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
        <li><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
        <li class="active"><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
    </ul>-->
</div>
<div class="right">
<div class="right-con">
<div class="org-right-con" >
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form name="deviceSelect" method="get" action="<?php echo U('channel/Device/deviceSelect');?>">
            <p>
                <label for="channel-class1" class="">区域</label>
                <select name="channel_first_type_sel" id="channel-class1" class="channel-select-min">
                    <option value="">省份</option>
                </select>
                <select name="channel_second_type_sel" id="channel_second_type_sel" class="channel-select-min">
                    <option value="">城市</option>
                </select>
                <label for="device-drive-id" class="">设备编号</label>
                <input type="text" name="device_no_txt" id="device_no_txt" value="<?php echo ($_GET['device_no_txt']); ?>" class="input-org-info"/>
                <label for="mac1" class="">MAC</label>
                <input type="text" name="mac_txt" id="mac_txt" value="<?php echo ($_GET['mac_txt']); ?>" class="input-org-info"/>
                <label for="device-state" class="">加油站状态</label>
                <select name="select_device_status" id="select_device_status" class="channel-select-min">
                    <option selected value="">选择状态</option> 
					<optgroup label="运行">  
					    <option value="normal" <?php if($_GET['select_device_status'] == 'normal'): ?>selected="selected"<?php endif; ?>>正常</option>  
						<option value="abnormal" <?php if($_GET['select_device_status'] == 'abnormal'): ?>selected="selected"<?php endif; ?>>异常</option>  
					</optgroup>  
					<optgroup label="未运行">  
						<option value="not_use" <?php if($_GET['select_device_status'] == 'not_use'): ?>selected="selected"<?php endif; ?>>未运行</option> 
					</optgroup>
                </select>
                <label for="channel-ss-channel" class="">所属网点</label>
                <input type="text" name="place_name_txt" id="place_name_txt" value="<?php echo ($_GET['place_name_txt']); ?>" class="input-org-info"/>
            </p>
            <p>
                <label for="channel-ss-channel" class="">SIM卡号</label>
                <input type="text" name="place_name_txt" id="place_name_txt" value="" class="input-org-info"/>
                <label for="channel-ss-channel" class="">首次启用日期</label>
                <input type="text" name="place_name_txt" id="place_name_txt" value="" class="input-org-info"/>
				<input type="text" name="select_del_flag_txt" id="select_del_flag_txt" value="0" style="display:none;"/>
                <input type="submit" class="role-control-btn" value="查询"/>
            </p>
        </form>
    </div>
    <div class="org-right-btns">
        <form action="">
            <button type="button" class="area-btn" id="b_add_device">添加</button>
            <button type="button" class="area-btn" id="b_change_device">编辑/查看</button>
            <button type="button" id="j_del_button" class="area-btn">删除</button>
            <button type="button" id="j_repeal_button" class="area-btn">撤销</button>
        </form>
    </div>
</div>
<div class="role-table" id="select_results" >
    <div class="num-list">共<span id="sum"><?php echo ($device_select_number); ?></span>条</div>
    <div class="hd">
        <ul id="device_select_result_ul" class="channel-tab">
        </ul>
    </div>
    <div class="bd over-h-y" >
        <ul class="role-table-list" style="min-width: 1370px;">
            <li>
                <span class="span-1"></span>
                <span class="span-2"><b>加油站编号</b></span>
                <span class="span-2"><b>MAC</b></span>
                <span class="span-1"><b>加油站型号</b></span>
                <span class="span-2"><b>所属网点</b></span>
                <span class="span-1"><b>所在点位</b></span>
				<?php if($isDeleteResult != 1): ?><span class="span-1"><b>加油站状态</b></span><?php endif; ?>
                <span class="span-1"><b>部署时间</b></span>
				<span class="span-1"><b>启用时间</b></span>
                <span class="span-1"><b>图片预览</b></span>
            </li>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="list_sel" onclick="selectDeviceRadio('<?php echo ($vo['device_id']); ?>','<?php echo ($vo['isDelete']); ?>');">
					<span class="span-1">
						<input type="radio" name="deviceRadioID" id="<?php echo ($vo['deviceRadioID']); ?>" value="<?php echo ($vo['device_id']); ?>"
							  class="role-table-radio"/></span>
					<span class="span-2" title="<?php echo ($vo["device_no"]); ?>"><?php echo ($vo["device_no"]); ?></span>
					<span class="span-2" title="<?php echo ($vo["MAC"]); ?>"><?php echo ($vo["MAC"]); ?></span>
					<span class="span-1" title="<?php echo ($vo["device_type"]); ?>"><?php echo ($vo["device_type"]); ?></span>
					<span class="span-2" title="<?php echo ($vo["place_name"]); ?>"><?php echo ($vo["place_name"]); ?></span>
					<span class="span-1" title="<?php echo ($vo["address"]); ?>"><?php echo ($vo["address"]); ?></span>
					<?php if($isDeleteResult != 1): ?><span class="span-1" title="<?php echo ($vo["status"]); ?>"><?php echo ($vo["status"]); ?></span><?php endif; ?>
					<span class="span-1" title="<?php echo ($vo["deploy_time"]); ?>"><?php echo ($vo["deploy_time"]); ?></span>
					<span class="span-1" title="<?php echo ($vo["begin_time"]); ?>"><?php echo ($vo["begin_time"]); ?></span>
					<?php if(!empty($vo['device_image_0'])): ?><img class="smaallimg" src="<?php echo ($vo["device_image_0"]); ?>" /><?php endif; ?>
							<?php if(!empty($vo['device_image_1'])): ?><img class="smaallimg" src="<?php echo ($vo["device_image_1"]); ?>" /><?php endif; ?>
							<?php if(!empty($vo['device_image_2'])): ?><img class="smaallimg" src="<?php echo ($vo["device_image_2"]); ?>" /><?php endif; ?>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
	<div class="resultpage"><?php echo ($page); ?></div>
    </div>
</div>


<div class="role-table over-h-y">
    <div class="hd">
        <ul class="channel-tab">
            <li class="on" style="background: #ffffff;color: #000000;">操作日志</li>
            <!--<li>删除日志</li>-->
        </ul>

    </div>
    <div class="bd">
		<ul class="role-table-list role-table-list2">
			<li><span class='span-3'><b>操作人</b></span><span class='span-3'><b>操作时间</b></span><span class='span-3'><b>操作日志</b></span></li>
		</ul>
        <ul id="device_log_info" class="role-table-list role-table-list2">
        </ul>
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
<div id="j_add_device" style="display:none;">
<div class="alert-role-add verup-alert-add">
    <h3>加油站信息</h3>
    <div class="alert-user-add-con ">
        <form action="">
            <p>

                <label for="channel-addname" class="role-lab">加油站编号</label>
                <input type="text" name="add_device_no_txt" id="add_device_no_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
                <label for="mac1" class="">MAC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="" id="add_mac1" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="add_mac2" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="add_mac3" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="add_mac4" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="add_mac5" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="add_mac6" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>
				<input type="text" name="add_mac_txt" id="add_mac_txt" class="input-mac" style="display:none;"/>
                <i class="red-color pdl10">*</i>
            </p>

            <p>
                <label for="channel-line-p" class="role-lab">所属网点</label>
                <input type="text" name="add_place_name_txt" id="add_place_name_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>

                <label for="channel-point" class="role-lab">所在点位</label>
                <input type="text" name="add_address_txt" id="add_address_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
            </p>

			<p>
                <label for="channel-point" class="role-lab">加油站型号</label>
                <input type="text" name="add_device_type_txt" id="add_device_type_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>

				<label for="channel-point" class="role-lab">加油站状态</label>
				<select name="add_status_sel" id="add_status_sel" class="channel-select-min">
					<option selected value="">选择状态</option> 
					<optgroup label="运行">  
						<option value="normal">正常</option>  
						<option value="abnormal">异常</option>  
					</optgroup>  
					<optgroup label="未运行">  
						<option value="not_use">未运行</option>    
					</optgroup>  
				</select>
                <i class="red-color pdl10">*</i>
		    </p>

            <p>
                <label for="bs-date">部署日期</label>
                <input type="date" name="add_deploy_time_sel" id="add_deploy_time_sel" class="input-org-info" 
				 style="margin-top: 0;" onClick="WdatePicker()" readonly="readonly"/>
                <i class="red-color pdl10">*</i>
                <label for="sq-date">启用日期</label>
                <input type="date" name="add_begin_time_sel" id="add_begin_time_sel" class="input-org-info" 
				 style="margin-top: 0;" onClick="WdatePicker()" readonly="readonly"/>

            </p>

            <p>
                <label for="sq-date">设置开机时间</label>
                <input type="date" name="add_power_on_time_sel" id="add_power_on_time_sel" class="input-org-info" 
					style="margin-top: 0;" onClick="WtimePicker()" readonly="readonly"/>
                <i class="red-color pdl10" style="color: #ffffff;">*</i>
                <label for="sq-date">设置关机时间</label>
                <input type="date" name="add_power_off_time_sel" id="add_power_off_time_sel" class="input-org-info" 
					style="margin-top: 0;" onClick="WtimePicker()" readonly="readonly"/>
            </p>
            <p>
                <label for="channel-addname" class="role-lab">SIM卡卡号</label>
                <input type="text" name="add_device_no_txt" id="" class="input-role-name"/>

                <label for="channel-addname" class="role-lab">手机号码</label>
                <input type="text" name="add_device_no_txt" id="" class="input-role-name"/>

            </p>
            <p>
                <label for="channel-addname" class="role-lab">首次启用日期</label>
                <input type="text" name="add_device_no_txt" id="" class="input-role-name"/>

            </p>
            <div class="device-point-pic">
                <h4>点位照片</h4>
                <form action="" id="imageForm" enctype="multipart/form-data" method="POST">
					<div id="img_up" class="img_up">
						<input type="file" class="file" name="add_image_path_0" id="add_image_path_0" value="" onChange="upimg()"/>
					</div>
					<div id="img_up_2" class="img_up">
						<input type="file" class="file" name="add_image_path_1" id="add_image_path_1" value="" onChange="upimg_2()"/>
					</div>
					<div id="img_up_3" class="img_up">
						<input type="file" class="file" name="add_image_path_2" id="add_image_path_2" value="" onChange="upimg_3()"/>
					</div>
				</form>
            </div>
            <p>
                <button type="button" class="alert-btn4" id="submit_add_device">保存</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
				</a>
            </p>
        </form>
    </div>
</div>
</div>

<div id="j_change_device" style="display:none;">
<div class="alert-role-add verup-alert-add">
    <h3>加油站信息</h3>

    <div class="alert-user-add-con">
        <form action="">
            <p>
                <label for="channel-addname" class="role-lab">加油站编号</label>
                <input type="text" name="change_device_no_txt" id="change_device_no_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>

                <label for="mac1" class="">MAC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="" id="change_mac1" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="change_mac2" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="change_mac3" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="change_mac4" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="change_mac5" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>-
                <input type="text" name="" id="change_mac6" class="input-mac" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength="2"/>
				<input type="text" name="change_mac_txt" id="change_mac_txt" class="input-mac" style="display:none;"/>
                <i class="red-color pdl10">*</i>
            </p>

            <p>
                <label for="channel-line-p" class="role-lab">所属网点</label>
                <input type="text" name="change_place_name_txt" id="change_place_name_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>

                <label for="channel-point" class="role-lab">所在点位</label>
                <input type="text" name="change_address_txt" id="change_address_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
            </p>

			<p>
                <label for="channel-point" class="role-lab">加油站型号</label>
                <input type="text" name="change_device_type_txt" id="change_device_type_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>

				<label for="channel-point" class="role-lab">加油站状态</label>
				<select name="change_status_sel" id="change_status_sel" class="channel-select-min">
					<option selected value="">选择状态</option> 
					<optgroup label="运行">  
						<option value="normal">正常</option>  
						<option value="abnormal">异常</option>  
					</optgroup>  
					<optgroup label="未运行">  
						<option value="not_use">未运行</option>    
					</optgroup>  
				</select>
                <i class="red-color pdl10">*</i>
		    </p>

            <p>
                <label for="bs-date">部署日期</label>
                <input type="date" name="change_deploy_time_sel" id="change_deploy_time_sel" class="input-org-info" 
					style="margin-top: 0;" onClick="WdatePicker()" readonly="readonly"/>
                <i class="red-color pdl10">*</i>
                <label for="sq-date">启用日期</label>
                <input type="date" name="change_begin_time_sel" id="change_begin_time_sel" class="input-org-info" 
					style="margin-top: 0;" onClick="WdatePicker()" readonly="readonly"/>
            </p>

            <p>
                <label for="sq-date">设置开机时间</label>
                <input type="date" name="change_power_on_time_sel" id="change_power_on_time_sel" class="input-org-info" 
					style="margin-top: 0;" onClick="WtimePicker()" readonly="readonly"/>
                <i class="red-color pdl10" style="color: #ffffff;">*</i>
                <label for="sq-date">设置关机时间</label>
                <input type="date" name="change_power_off_time_sel" id="change_power_off_time_sel" class="input-org-info" 
					style="margin-top: 0;" onClick="WtimePicker()" readonly="readonly"/>
            </p>
            <p>
                <label for="channel-addname" class="role-lab">SIM卡卡号</label>
                <input type="text" name="add_device_no_txt" id="" class="input-role-name"/>

                <label for="channel-addname" class="role-lab">手机号码</label>
                <input type="text" name="add_device_no_txt" id="" class="input-role-name"/>

            </p>
            <p>
                <label for="channel-addname" class="role-lab">首次启用日期</label>
                <input type="text" name="add_device_no_txt" id="" class="input-role-name"/>

            </p>
            <div class="device-point-pic">
                <h4>点位照片</h4>
                <form action="" id="imageForm" enctype="multipart/form-data" method="POST">
					<div id="change_img_up" class="img_up">
						<input type="file" class="file" name="change_image_path_0" id="change_image_path_0" value="" onChange="change_upimg()"/>
						<input type="hidden" name="change_image_id_0" id="change_image_id_0" class="change_image_id_0" style="width:164px"/>
					</div>
					<div id="change_img_up_2" class="img_up">
						<input type="file" class="file" name="change_image_path_1" id="change_image_path_1" value="" onChange="change_upimg_2()"/>
						<input type="hidden" name="change_image_id_1" id="change_image_id_1" class="change_image_id_1" style="width:164px"/>
					</div>
					<div id="change_img_up_3" class="img_up">
						<input type="file" class="file" name="change_image_path_2" id="change_image_path_2" value="" onChange="change_upimg_3()"/>
						<input type="hidden" name="change_image_id_2" id="change_image_id_2" class="change_image_id_2" style="width:164px"/>
					</div>
				</form>
            </div>
            <p>
                <button type="button" class="alert-btn4" id="submit_change_device">保存</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
				</a>
            </p>
        </form>
    </div>
</div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>设备信息</h3>
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
<!--<script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>-->
<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
<link rel="stylesheet" href="__PUBLIC__/css/jquery.bigautocomplete.css" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WtimePicker.js"></script>
<script src="__PUBLIC__/js/AjaxFileUploaderV2.1/ajaxfileupload.js"></script><!--图片上传-->
<script>
	var device_val='';
	var device_flag='';
	var tmp_change_image_path_0 = '';
	var tmp_change_image_path_1 = '';
	var tmp_change_image_path_2 = '';
	var tmp_image_path_0 = '';
	var tmp_image_path_1 = '';
	var tmp_image_path_2 = '';
	function selectDeviceRadio(device_id, device_delete){
		device_val = device_id;
		device_flag = device_delete;
	}


	$(document).ready(function () {
		var sum = $("#sum").text();
		if(sum==""){
			$("#sum").text("0");
		}
		var state = "<?php echo ($isDeleteResult); ?>";
		if(1 == state){
			$("#device_select_result_ul").empty();
			$("#device_select_result_ul").append("<li onclick='device_use_select();'>启用</li><li class='on' onclick='device_remove_select();'>撤销</li>");
		}else{
			$("#device_select_result_ul").empty();
			$("#device_select_result_ul").append("<li class='on' onclick='device_use_select();'>启用</li><li onclick='device_remove_select();'>撤销</li>");
		}

		place_name_blurry();
		device_mac_blurry();
		device_no_blurry();
		add_place_name_blurry();
		change_place_name_blurry();

		 $('#j_del_button').click(function(){
		     if(device_val == '')
			 {
			     alert("<?php echo C('no_select_data');?>");
				 return;
			 }
			 if(device_flag == 1)
			 {
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			 }
			 $.openDOMWindow({
			    loader:1,
				loaderHeight:17,
				loaderWidth:18,
				windowSourceID:'#j_del_win'
		     });
             return false;
        });

		//撤销网点
        $('#j_repeal_button').click(function(){
			if(device_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(device_val == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
            var device_id=device_val;
            var del_handleUrl="<?php echo U('channel/Device/deviceRepeal');?>";
            $.getJSON(del_handleUrl,{"device_id":device_id},
                    function (data){
						if(confirm("确定要撤销吗？")){
							alert(data);
							window.location.href = window.location.href;
						}
                    }
                    ,'json'
            );
        });

		//单击删除确认按钮
        $('#j_del_ok').click(function(){
            var device_id= device_val;
            var del_handleUrl="<?php echo U('channel/Device/deviceDelete');?>";
            $.getJSON(del_handleUrl,{"device_id":device_id},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

		//弹出添加框
        $('#b_add_device').click(function(){
            $.openDOMWindow({
			     loader:1,
				 loaderHeight:16,
				 loaderWidth:17,
				 windowSourceID:'#j_add_device'
			 });
			 return false;
        });

		$('#b_change_device').click(function(){
			if(device_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(device_flag == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
			var handleUrl = "<?php echo U('channel/Device/deviceDetailSelect');?>";
			var device_id=device_val;
			$.getJSON(handleUrl,{"device_id":device_val},
				function (data){
					$("#change_device_id_txt").val(data['device_id']);
					$("#change_device_no_txt").val(data['device_no']);
					//$("#change_mac_txt").val(data['MAC']);
					$("#change_mac1").val(data['MAC1']);
					$("#change_mac2").val(data['MAC2']);
					$("#change_mac3").val(data['MAC3']);
					$("#change_mac4").val(data['MAC4']);
					$("#change_mac5").val(data['MAC5']);
					$("#change_mac6").val(data['MAC6']);
					$("#change_place_name_txt").val(data['place_name']);
					$("#change_deploy_time_sel").val(data['deploy_time']);
					$("#change_begin_time_sel").val(data['begin_time']);
					$("#change_status_sel").val(data['status']);
					$("#change_device_type_txt").val(data['device_type']);
					$("#change_address_txt").val(data['address']);
					$("#change_power_on_time_sel").val(data['power_on_time']);
					$("#change_power_off_time_sel").val(data['power_off_time']);
					var image_path_0 = "<?php echo C('image_url');?>"+data['image_path_0'];
					var image_path_1 = "<?php echo C('image_url');?>"+data['image_path_1'];
					var image_path_2 = "<?php echo C('image_url');?>"+data['image_path_2'];

					$("#change_img_up").css("background-image","url("+image_path_0+")"); 
					$("#change_img_up_2").css("background-image","url("+image_path_1+")"); 
					$("#change_img_up_3").css("background-image","url("+image_path_2+")"); 
					$("#change_img_up").css("background-size","100% 100%"); //文本框手势
					$("#change_img_up_2").css("background-size","100% 100%"); //文本框手势
					$("#change_img_up_3").css("background-size","100% 100%"); //文本框手势
					tmp_change_image_path_0 = data['image_path_0'];
					tmp_change_image_path_1 = data['image_path_1'];
					tmp_change_image_path_2 = data['image_path_2'];
					$("#change_image_id_0").val(data['image_id_0']);
					$("#change_image_id_1").val(data['image_id_1']);
					$("#change_image_id_2").val(data['image_id_2']);
				}
			,'json'
			);
            $.openDOMWindow({
			     loader:1,
				 loaderHeight:16,
				 loaderWidth:17,
				 windowSourceID:'#j_change_device'
			 });
			 return false;
        });
		$(".input-mac").keyup(function(){
			var mac=$(this).val();
			if(mac.length>=2){
				$(this).next().focus();
			}
		});
		$('#submit_add_device').click(function(){
			var handleUrl = "<?php echo U('channel/Device/deviceAdd');?>";
			var add_device_no_txt=$("#add_device_no_txt").val();//终端编号
			var add_mac_txt=$("#add_mac1").val() + "-" + $("#add_mac2").val() + "-" + $("#add_mac3").val() + "-" +
				$("#add_mac4").val() + "-" + $("#add_mac5").val() + "-" + $("#add_mac6").val();//mac地址
				//MAC验证
			var reg1 = /^[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}$/;
			var reg2 = /^[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}$/;

			if (!reg1.test(add_mac_txt)) {
				alert("MAC地址输入有误");
				return false;
			}
			var add_place_name_txt=$("#add_place_name_txt").val();//所属网点
			var add_deploy_time_sel=$("#add_deploy_time_sel").val();//部署时间
			var add_begin_time_sel=$("#add_begin_time_sel").val();//启动时间
			var add_status_sel=$("#add_status_sel").val();//终端状态
			var add_device_type_txt=$("#add_device_type_txt").val();//终端型号
			var add_address_txt=$("#add_address_txt").val();//终端地址
			var add_power_on_time_sel=$("#add_power_on_time_sel").val();
			var add_power_off_time_sel=$("#add_power_off_time_sel").val();
			var add_image_path_0=tmp_image_path_0;
			var add_image_path_1=tmp_image_path_1;
			var add_image_path_2=tmp_image_path_2;
			if (add_device_no_txt=="") {
				alert("加油站编号不能为空");
				return false;
			} 
			if (add_place_name_txt=="") {
				alert("所属网点不能为空");
				return false;
			} 
			if (add_address_txt=="") {
				alert("所在点位不能为空");
				return false;
			} 
			if (add_status_sel=="") {
				alert("请选择加油站状态");
				return false;
			} 
			if (add_power_on_time_sel=="") {
				alert("启用日期不能为空");
				return false;
			} 
			$.getJSON(handleUrl,{"add_device_no_txt":add_device_no_txt,"add_mac_txt":add_mac_txt,"add_place_name_txt":add_place_name_txt,
								 "add_deploy_time_sel":add_deploy_time_sel,"add_begin_time_sel":add_begin_time_sel,
								 "add_status_sel":add_status_sel,"add_device_type_txt":add_device_type_txt,
								 "add_address_txt":add_address_txt,
								 "add_power_on_time_sel":add_power_on_time_sel,"add_power_off_time_sel":add_power_off_time_sel,
								 "add_image_path_0":add_image_path_0,"add_image_path_1":add_image_path_1,"add_image_path_2":add_image_path_2
								 },
				function (data){
					var tmp_msg = "<?php echo C('add_device_success');?>";
					if(tmp_msg == data)
					{
						alert(data);
						window.location.href = window.location.href;
					}
					else
					{
						//$(".cli_tishi").html("<img src='__PUBLIC__/image/th.png'/>"+data+"");
						alert(data);
					}
				}
			,'json'
			);

        });

		$('#submit_change_device').click(function(){
			var handleUrl = "<?php echo U('channel/Device/deviceSave');?>";
			var change_device_id_txt= device_val;
			var change_device_no_txt=$("#change_device_no_txt").val();//终端编号
			var change_mac_txt=$("#change_mac1").val() + "-" + $("#change_mac2").val() + "-" + $("#change_mac3").val() + "-" +
				$("#change_mac4").val() + "-" + $("#change_mac5").val() + "-" + $("#change_mac6").val();//mac地址
			//MAC验证
			var reg1 = /^[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}\-[A-Fa-f0-9]{1,2}$/;
			var reg2 = /^[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}\:[A-Fa-f0-9]{1,2}$/;
			//alert(change_mac_txt);
			if (!reg1.test(change_mac_txt)) {
				alert("MAC地址输入有误");
				return false;
			}
			var change_place_name_txt=$("#change_place_name_txt").val();//所属网点
			var change_deploy_time_sel=$("#change_deploy_time_sel").val();//部署时间
			var change_begin_time_sel=$("#change_begin_time_sel").val();//启动时间
			var change_status_sel=$("#change_status_sel").val();//终端状态
			var change_device_type_txt=$("#change_device_type_txt").val();//终端型号
			var change_address_txt=$("#change_address_txt").val();//终端地址
			var change_power_on_time_sel=$("#change_power_on_time_sel").val();
			var change_power_off_time_sel=$("#change_power_off_time_sel").val();
			var change_image_id_0=$("#change_image_id_0").val();
			var change_image_id_1=$("#change_image_id_1").val();
			var change_image_id_2=$("#change_image_id_2").val();
			var change_image_path_0=tmp_change_image_path_0;
			var change_image_path_1=tmp_change_image_path_1;
			var change_image_path_2=tmp_change_image_path_2;
			if (change_device_no_txt=="") {
				alert("加油站编号不能为空");
				return false;
			} 
			if (change_place_name_txt=="") {
				alert("所属网点不能为空");
				return false;
			} 
			if (change_address_txt=="") {
				alert("所在点位不能为空");
				return false;
			} 
			if (change_status_sel=="") {
				alert("请选择加油站状态");
				return false;
			} 
			if (change_power_on_time_sel=="") {
				alert("启用日期不能为空");
				return false;
			} 
			$.getJSON(handleUrl,{"change_device_id_txt":change_device_id_txt,"change_device_no_txt":change_device_no_txt,
								 "change_mac_txt":change_mac_txt,"change_place_name_txt":change_place_name_txt,
								 "change_deploy_time_sel":change_deploy_time_sel,"change_begin_time_sel":change_begin_time_sel,
								 "change_status_sel":change_status_sel,"change_device_type_txt":change_device_type_txt,
								 "change_address_txt":change_address_txt,
								 "change_power_on_time_sel":change_power_on_time_sel,"change_power_off_time_sel":change_power_off_time_sel,
								 "change_image_id_0":change_image_id_0,"change_image_id_1":change_image_id_1,"change_image_id_2":change_image_id_2,
								 "change_image_path_0":change_image_path_0,"change_image_path_1":change_image_path_1,"change_image_path_2":change_image_path_2
								 },
				function (data){
					var tmp_msg = "<?php echo C('change_device_success');?>";
					if(tmp_msg == data)
					{
						alert(data);
						window.location.href = window.location.href;
					}
					else
					{
						//$(".cli_tishi").html("<img src='__PUBLIC__/image/th.png'/>"+data+"");
						alert(data);
					}
				}
			,'json'
			);

		});

		$(".list_sel").click(function(){
			$(this).find(".role-table-radio").attr("checked",'checked');
			$("#device_log_info").empty();
			//$("#device_log_info").append("<li><span class='span-3'><b>操作人</b></span><span class='span-3'><b>操作时间</b></span><span class='span-3'><b>操作日志</b></span></li>");
			var handleUrl = "<?php echo U('channel/Device/deviceLogSelect');?>";
			var device_id=device_val;
			$.getJSON(handleUrl,{"device_id":device_id},
				function (data){
					$.each(data, function(i,item){
						    $("#device_log_info").append("<li><span class='span-3'>" + item.user + "</span><span class='span-3'>" +
								item.time + "</span><span class='span-3' title='" + item.info + "'>" + item.info + "</span></li>");
					});
			}
			,'json'
			);
		});
		$(".resultpage").attr("style","display:block");
	});

	function place_name_blurry()
	{
		var handleUrl = "<?php echo U('channel/Place/placenameBlurrySelect');?>";
		var place_name = '';
		$.getJSON(handleUrl,{"place_name":place_name},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#place_name_txt").bigAutocomplete({width:150,data:data,callback:function(data){}});
			}
			,'json'
		);
	}

	function device_mac_blurry()
	{
		var handleUrl = "<?php echo U('channel/Device/devicemacBlurrySelect');?>";
		$.getJSON(handleUrl,{},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#mac_txt").bigAutocomplete({width:150,data:data,callback:function(data){}});
			}
			,'json'
		);
	}

	function device_no_blurry()
	{
		var handleUrl = "<?php echo U('channel/Device/devicenoBlurrySelect');?>";
		var device_no = '';
		$.getJSON(handleUrl,{"device_no":device_no},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#device_no_txt").bigAutocomplete({width:150,data:data,callback:function(data){}});
			}
			,'json'
		);
	}

	function add_place_name_blurry()
	{
		var handleUrl = "<?php echo U('channel/Place/placenameBlurrySelect');?>";
		var place_name = '';
		$.getJSON(handleUrl,{},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#add_place_name_txt").bigAutocomplete({width:250,data:data,callback:function(data){}});
			}
			,'json'
		);
	}

	function change_place_name_blurry()
	{
		var handleUrl = "<?php echo U('channel/Place/placenameBlurrySelect');?>";
		var place_name = '';
		$.getJSON(handleUrl,{"place_name":place_name},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#change_place_name_txt").bigAutocomplete({width:250,data:data,callback:function(data){}});
			}
			,'json'
		);
	}

	function device_use_select(){
		$("#select_del_flag_txt").val(0);
		deviceSelect.submit();
	}

	function device_remove_select(){
		$("#select_del_flag_txt").val(1);
		deviceSelect.submit();
	}

	function upimg(){
		var file = $("#add_image_path_0").val();  
			if(file==""){  
				alert("请选择图片");  
				return;  
			}  
			else{  
				//判断上传的文件的格式是否正确  
				var fileType = file.substring(file.lastIndexOf(".")+1);  
				if(fileType!="jpg" && fileType!="jpeg"){  
					alert("上传文件格式错误");  
					return;  
				}  
				else{
					var url = "<?php echo U('channel/Device/uploadImage');?>"; 
					var tmp_url = "";
					$.ajaxFileUpload({  
						url:url,  
						secureuri:false, 
						data:{},
						fileElementId:"add_image_path_0",        //file的id  
						dataType:"text",                  //返回数据类型为文本  
						success:function(data,status){ 
							tmp_url = "<?php echo C('image_url');?>" + data;
							$("#img_up").css("background","url("+tmp_url+")"); //文本框手势
							$("#img_up").css("background-size","100% 100%"); //文本框手势
							//$("#add_image_path_0").val(data);
							//document.getElementById("#add_image_path_0").value = data;
							tmp_image_path_0 = data;
							},
							error:function(data, status, e){
								   alert(e);
							}
						})  
					}
				}  
	} 

	function upimg_2(){
		var file = $("#add_image_path_1").val();  
			if(file==""){  
				alert("请选择图片");  
				return;  
			}  
			else{  
				//判断上传的文件的格式是否正确  
				var fileType = file.substring(file.lastIndexOf(".")+1);  
				if(fileType!="jpg" &&  fileType!="jpeg"){  
					alert("上传文件格式错误");  
					return;  
				}  
				else{
					var url = "<?php echo U('channel/Device/uploadImage');?>";  
					var tmp_url = "";
					$.ajaxFileUpload({  
						url:url,  
						secureuri:false, 
						data:{},
						fileElementId:"add_image_path_1",        //file的id  
						dataType:"text",                  //返回数据类型为文本  
						success:function(data,status){ 
							tmp_url = "<?php echo C('image_url');?>" + data;
							$("#img_up_2").css("background-image","url("+tmp_url+")"); //文本框手势
							$("#img_up_2").css("background-size","100% 100%"); //文本框手势
							//$("#add_image_path_1").val(data);
							//document.getElementById("#add_image_path_1").value = data;
							tmp_image_path_1 = data;
							},
							error:function(data, status, e){
								   alert(e);
							}
						})  
					}
				}  
	
	}

	function upimg_3(){
		var file = $("#add_image_path_2").val();  
			if(file==""){  
				alert("请选择图片");  
				return;  
			}  
			else{  
				//判断上传的文件的格式是否正确  
				var fileType = file.substring(file.lastIndexOf(".")+1);  
				if(fileType!="jpg" &&  fileType!="jpeg"){  
					alert("上传文件格式错误");  
					return;  
				}  
				else{
					var url = "<?php echo U('channel/Device/uploadImage');?>"; 
					var tmp_url = "";
					$.ajaxFileUpload({  
						url:url,  
						secureuri:false, 
						data:{},
						fileElementId:"add_image_path_2",        //file的id  
						dataType:"text",                  //返回数据类型为文本  
						success:function(data,status){ 
							tmp_url = "<?php echo C('image_url');?>" + data;
							$("#img_up_3").css("background-image","url("+tmp_url+")"); //文本框手势
							$("#img_up_3").css("background-size","100% 100%"); //文本框手势
							//$("#add_image_path_2").val(data);
							//document.getElementById("#add_image_path_2").value = data;
							tmp_image_path_2 = data;
							},
							error:function(data, status, e){
								   alert(e);
							}
						})  
					}
				}  
	} 

	function change_upimg(){
		var file = $("#change_image_path_0").val();  
			if(file==""){  
				alert("请选择图片");  
				return;  
			}  
			else{  
				//判断上传的文件的格式是否正确  
				var fileType = file.substring(file.lastIndexOf(".")+1);  
				if(fileType!="jpg" && fileType!="jpeg"){  
					alert("上传文件格式错误");  
					return;  
				}  
				else{
					var url = "<?php echo U('channel/Device/uploadImage');?>"; 
					var tmp_url = "";
					$.ajaxFileUpload({  
						url:url,  
						secureuri:false, 
						data:{},
						fileElementId:"change_image_path_0",        //file的id  
						dataType:"text",                  //返回数据类型为文本  
						success:function(data,status){ 
							tmp_url = "<?php echo C('image_url');?>" + data;
							$("#change_img_up").css("background","url("+tmp_url+")"); //文本框手势
							$("#change_img_up").css("background-size","100% 100%"); //文本框手势
							//$("#change_image_path_0").val(data);
							//document.getElementById("#change_image_path_0").value = data;
							tmp_change_image_path_0 = data;
							},
							error:function(data, status, e){
								   alert(e);
							}
						})  
					}
				}  
	} 

	function change_upimg_2(){
	    var file = $("#change_image_path_1").val();  
		if(file==""){  
			alert("请选择图片");  
			return;  
		}  
		else{  
			//判断上传的文件的格式是否正确  
			var fileType = file.substring(file.lastIndexOf(".")+1);  
			if(fileType!="jpg" &&  fileType!="jpeg"){  
				alert("上传文件格式错误");  
				return;  
			}  
			else{
				var url = "<?php echo U('channel/Device/uploadImage');?>"; 
				var tmp_url = "";
				$.ajaxFileUpload({  
					url:url,  
					secureuri:false, 
					data:{},
					fileElementId:"change_image_path_1",        //file的id  
					dataType:"text",                  //返回数据类型为文本  
					success:function(data,status){ 
						tmp_url = "<?php echo C('image_url');?>" + data;
						$("#change_img_up_2").css("background-image","url("+tmp_url+")"); //文本框手势
						$("#change_img_up_2").css("background-size","100% 100%"); //文本框手势
						//$("#change_image_path_1").val(data);
						//document.getElementById("#change_image_path_1").value = data;
						tmp_change_image_path_1 = data;
						},
						error:function(data, status, e){
							   alert(e);
						}
					})  
				}
			}  
	 }

	 function change_upimg_3(){
		var file = $("#change_image_path_2").val();  
			if(file==""){  
				alert("请选择图片");  
				return;  
			}  
			else{  
				//判断上传的文件的格式是否正确  
				var fileType = file.substring(file.lastIndexOf(".")+1);  
				if(fileType!="jpg" &&  fileType!="jpeg"){  
					alert("上传文件格式错误");  
					return;  
				}  
				else{
					var url = "<?php echo U('channel/Device/uploadImage');?>"; 
					var tmp_url = "";
					$.ajaxFileUpload({  
						url:url,  
						secureuri:false, 
						data:{},
						fileElementId:"change_image_path_2",        //file的id  
						dataType:"text",                  //返回数据类型为文本  
						success:function(data,status){ 
							tmp_url = "<?php echo C('image_url');?>" + data;
							$("#change_img_up_3").css("background-image","url("+tmp_url+")"); //文本框手势
							$("#change_img_up_3").css("background-size","100% 100%"); //文本框手势
							//$("#change_image_path_2").val(data);
							//document.getElementById("#change_image_path_2").value = data;
							tmp_change_image_path_2 = data;
							},
							error:function(data, status, e){
								   alert(e);
							}
						})  
					}
				}  
	}

	$(function(){
		ImgPreview();	
	});
var ImgPreview=function(){
	$(".smaallimg").hover(function(e){ 
		jQuery("<img class='preview' src='"+this.src+"'/>").appendTo("#select_results");
		$(".preview").css("top",(e.pageY-5)+"px").css("position","absolute").css("margin-left","80px").css("margin-bottom","300px").css("width","550px").css("height","400px").fadeIn("fast");
	},function(){
		$(".preview").remove();
	});
	$(".smaallimg").mousemove(function(e){
		$(".preview").css("top",(e.pageY-5)+"px").css("position","absolute").css("margin-left","80px");
	});
};
</script>
<script type="text/javascript">jQuery(".role-table").slide({trigger: "click"});</script>
<script>
    $(function(){
        $('.head-wrap,#head,#footer').css('min-width','1550px');
    })
</script>
</body>
</html>