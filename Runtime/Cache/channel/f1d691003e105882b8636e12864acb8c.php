<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>网点信息</title>
    <!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/city.js"></script>
	<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>

	<script>
		var place_val='';
		var place_flag='';
		function selectPlaceRadio(place_id,place_delete){
			place_val = place_id;
			place_flag = place_delete;
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
<div id="nav" class="top_link">
    <ul class="main-nav" id="j-nav-active"></ul>
</div>
<SCRIPT type="text/javascript">
var getTopLink = "<?php echo U('configuration/User/getTopLink');?>";
$.ajax({
	url            : getTopLink,
	type           : "get",
	dataType       : "json",
	async          : false,
	success        : function(data, textStatus){
    	$(".top_link ul li").remove();
        $.each(data,function(i,n){
        	$(".top_link ul").append("<li class='url_link topLink' url=\"'"+n['url']+"'\"><a href='"+n['url']+"'>"+n['top_name']+"</a></li>");
        });
    }

});
</SCRIPT>
</div>

<div id="container">
<div class="left">
    
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>渠道管理<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('channel/Channel/index');?>'"><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
            <li class="url_link" url="'<?php echo U('channel/Place/index');?>'"><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
            <li class="url_link" url="'<?php echo U('channel/Device/index');?>'"><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
        </ul>
    </li>
</ul>

</div>
<div class="right">
<div class="right-con">
<div class="org-right-con">
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form name="placeSelect" method="get" action="<?php echo U('channel/Place/placeSelect');?>">
            <p>
                <label for="channel-org-name" class="">网点名称&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="place_name_txt" id="place_name_txt" autocomplete="off" value="<?php echo ($_GET['place_name_txt']); ?>"  class="input-org-info"
				onfocus="blurry('place_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
                <label for="channel-ss-are" class="">所属区域</label>&nbsp;
				<span class="select_showcity">
					<select class="select_province" name="select_province" onChange="getCity('<?php echo U('channel/Channel/getCity');?>',this,'');" value=''>
						<option class='0' value='0'>省份</option>
					</select>
					<select class="select_city" name="select_city" value=''>
						<option class='0' value='0'>地级市</option>
					</select>
				</span><!--省市联动-->
                <label for="channel-ss-channel" class="">所属渠道</label>&nbsp;
                <input type="text" name="channel_name_txt" id="channel_name_txt" autocomplete="off" value="<?php echo ($_GET['channel_name_txt']); ?>" class="input-org-info"
				onfocus="blurry('channel_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
                <label for="channel-state" class="">网点状态</label>
                <select name="place_state_sel" id="place_state_sel" class="channel-select-min">
                    <option value="" <?php if($_GET['place_state_sel'] == ''): ?>selected="selected"<?php endif; ?>>全部</option>
                    <option value="test" <?php if($_GET['place_state_sel'] == 'test'): ?>selected="selected"<?php endif; ?>>测试期</option>
                    <option value="use" <?php if($_GET['place_state_sel'] == 'use'): ?>selected="selected"<?php endif; ?>>启用</option>
                </select>
            </p>
            <p>

                <label for="channel-org-name" class="">测试结束期</label>
                <input type="text" name="select_test_end_time_1" id="select_test_end_time_1" class="input-org-info"
                value="<?php echo ($_GET['select_test_end_time_1']); ?>" onClick="WdatePicker()"/>
                &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;
                <input type="text" name="select_test_end_time_2" id="select_test_end_time_2" class="input-org-info"
                value="<?php echo ($_GET['select_test_end_time_2']); ?>" onClick="WdatePicker()"/>
				<input type="text" name="select_del_flag_txt" id="select_del_flag_txt" value="0" style="display:none;"/>
				
                <input type="submit" class="role-control-btn" value="查询"/><input type="button" id="placeDala" class="role-control-btn" value="清空"/> 
            </p>


        </form>
    </div>
    <div class="org-right-btns">
        <form action="">
            <button type="button" class="area-btn" id="b_add_place">添加</button>
            <button type="button" class="area-btn" id="b_change_place">编辑/查看</button>
            <button type="button" id="j_del_button" class="area-btn">删除</button>
            <button type="button" id="j_repeal_button" class="area-btn">撤销</button>
        </form>
    </div>
</div>
<div class="role-table">
    <div class="num-list">共<span id="sum"><?php echo ($place_select_number); ?></span>条</div>
<div class="hd">
    <ul id="place_select_result_ul" class="channel-tab">
    </ul>
</div>
<div class="bd over-h-y">
    <ul class="role-table-list place-tabe-mwidth">
        <li>
            <span class="span-1"></span>
            <span class="span-2"><b>网点名称</b></span>
            <span class="span-3"><b>所属渠道</b></span>
            <span class="span-3"><b>网点地址</b></span>
            <span class="span-1"><b>联系人电话</b></span>
			<?php if($isDeleteResult != 1): ?><span class="span-1"><b>网点状态</b></span><?php endif; ?>
            <span class="span-1"><b>启用日期</b></span>
			<?php if($isDeleteResult != 1): ?><span class="span-1"><b>投放加油站数量</b></span>
			<?php elseif($isDeleteResult == 1): ?>
				<span class="span-1"><b>撤销日期</b></span><?php endif; ?>
        </li>
		 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="list_sel" onClick="selectPlaceRadio('<?php echo ($vo['place_id']); ?>','<?php echo ($vo['isDelete']); ?>');">
				<span class="span-1">
					<input type="radio" name="placeRadioID" value="<?php echo ($vo['place_id']); ?>" 
						 class="role-table-radio"/></span>
				<span class="span-2" title="<?php echo ($vo["place_name"]); ?>"><?php echo ($vo["place_name"]); ?></span>
				<span class="span-3" title="<?php echo ($vo["channel_name"]); ?>"><?php echo ($vo["channel_name"]); ?></span>
				<span class="span-3" title="<?php echo ($vo["region"]); ?>"><?php echo ($vo["region"]); ?></span>
				<span class="span-1" title="<?php echo ($vo["contacts_tel"]); ?>"><?php echo ($vo["contacts_tel"]); ?></span>
				<?php if($isDeleteResult != 1): ?><span class="span-1" title="<?php echo ($vo["status"]); ?>"><?php echo ($vo["status"]); ?></span><?php endif; ?>
				<span class="span-1" title="<?php echo ($vo["begin_time"]); ?>"><?php echo ($vo["begin_time"]); ?></span>
				<?php if($isDeleteResult != 1): ?><span class="span-1" title="<?php echo ($vo["device_num"]); ?>"><?php echo ($vo["device_num"]); ?></span>
				<?php elseif($isDeleteResult == 1): ?>
					<span class="span-1" title="<?php echo ($vo["end_time"]); ?>"><?php echo ($vo["end_time"]); ?></span><?php endif; ?>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
<div class="resultpage"><?php echo ($page); ?></div>
</div>
</div>


<div class="role-table over-h-y rizhi">
    <div class="data-log">
        <h3>操作日志</h3>
    </div>
	<ul class="role-table-list role-table-list2">
		<li><span class='span-3'><b>操作人</b></span><span class='span-3'><b>操作时间</b></span><span class='span-3'><b>操作日志</b></span></li>
	</ul>
    <ul id="log_info" class="role-table-list role-table-list2">
		
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
        //headAct();

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
<div id="j_add_place" style="display:none;">
<div class="alert-role-add verup-alert-add">
    <h3>网点信息</h3>

    <div class="alert-user-add-con">
        <form action="">

            <p>
                <label for="channel-addname" class="role-lab">网点名称</label>
                <input type="text" name="add_place_name_txt" id="add_place_name_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
                <label for="channel-addname" class="role-lab">网点编号</label>
                <input type="text" name="add_place_no_txt" id="add_place_no_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
            </p>

			<p>
                <label for="channel-addname" class="role-lab">联系人</label>
                <input type="text" name="add_contacts_txt" id="add_contacts_txt" class="input-role-name"/>
                <i class="red-color pdl10" style="color: #ffffff;">*</i>
                <label for="channel-addname" class="role-lab">联系人电话</label>
                <input type="text" name="add_contacts_tel_txt" id="add_contacts_tel_txt" class="input-role-name"/>
            </p>


            <p>
                <label for="channel-address1" class="">网点地址</label>
                <span class="select_showcity">
					<select class="select_province" id="add_select_province" name="add_select_province" onChange="getCity('<?php echo U('channel/Channel/getCity');?>',this,'');" value=''>
						<option class='0' value='0'>省份</option>
					</select>
					<select class="select_city" name="add_select_city" value='' id="add_select_city">
						<option class='0' value='0'>地级市</option>
					</select>
				</span><!--省市联动-->                
				<input type="text" name="" id="add_region_txt" class="input-role-name long-input"/>
                <i class="red-color pdl10">*</i>
            </p>
            <p>
                <label for="channel-qd" class="role-lab">所属渠道</label>
                <input type="text" name="add_channel_name_txt" id="add_channel_name_txt" class="input-role-name" onFocus="blurry('channel_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
                <i class="red-color pdl10">*</i>
                <label for="channel-address1" class="">网点状态</label>
                <select name="add_status_sel" id="add_status_sel" class="channel-select-min">
                    <option value="test">测试期</option>
                    <option value="use">启用</option>
                </select>
                <i class="red-color pdl10">*</i>
            </p>


            <p>
                <label for="sq-date">测试日期</label>
                <input type="date" name="add_test_begin_time_sel" id="add_test_begin_time_sel" class="input-org-info min-w"
					style="margin-top: 0;" onClick="WdatePicker()" readonly/>
                <input type="date" name="add_test_end_time_sel" id="add_test_end_time_sel" class="input-org-info min-w"
					style="margin-top: 0;" onClick="WdatePicker()" readonly/>
                <label for="sq-date">启用日期</label>
                <input type="date" name="add_begin_time_sel" id="add_begin_time_sel" class="input-org-info"
                       style="margin-top: 0;" onClick="WdatePicker()" readonly/>
            </p>

            <p>
                <button type="button" class="alert-btn4" id="submit_add_place">保存</button>
				<button type="button" class="alert-btn2" onclick="window.location=window.location">关闭</button>
            </p>
        </form>
    </div>
</div>

<div id="j_change_place" style="display:none;">
<div class="alert-role-add verup-alert-add">
    <h3>网点信息</h3>
    <div class="alert-user-add-con">
        <form action="">

            <p>
                <label for="channel-addname" class="role-lab">网点名称</label>
                <input type="text" name="change_place_name_txt" id="change_place_name_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
                <label for="channel-addname" class="role-lab">网点编号</label>
                <input type="text" name="change_place_no_txt" id="change_place_no_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
            </p>

			<!--<p>
                <label for="channel-addname" class="role-lab">网点地址</label>
                <input type="text" name="change_region_txt" id="change_region_txt" class="input-role-name"/>
                <i class="red-color pdl10">*</i>
            </p>-->

			<p>
                <label for="channel-addname" class="role-lab">联系人</label>
                <input type="text" name="change_contacts_txt" id="change_contacts_txt" class="input-role-name"/>
                <i class="red-color pdl10" style="color: #ffffff;">*</i>
                <label for="channel-addname" class="role-lab">联系人电话</label>
                <input type="text" name="change_contacts_tel_txt" id="change_contacts_tel_txt" class="input-role-name"/>
            </p>


            <p>
                <label for="channel-address1" class="">网点地址</label>
                <span class="select_showcity">
					<select class="select_province" id="change_select_province" name="change_select_province" onChange="getCity('<?php echo U('channel/Channel/getCity');?>',this,'');" value=''>
						<option class='0' value='0'>省份</option>
					</select>
					<select class="select_city" name="change_select_city" value='' id="change_select_city">
						<option class='0' value='0'>地级市</option>
					</select>
				</span><!--省市联动-->              
				<input type="text" name="" id="change_region_txt" class="input-role-name long-input"/>
                <i class="red-color pdl10">*</i>

            </p>
            <p>
                <label for="channel-qd" class="role-lab">所属渠道</label>
                <input type="text" name="change_channel_name_txt" id="change_channel_name_txt" class="input-role-name" onFocus="blurry('channel_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
				<i class="red-color pdl10">*</i>

                <label for="channel-address1" class="">网点状态</label>
				<select name="change_status_sel" id="change_status_sel" class="channel-select-min">
					<option value="test">测试期</option>
					<option value="use">启用</option>
				</select>
				<i class="red-color pdl10">*</i>
             </p>
            <p>
                <label for="sq-date">测试日期</label>
                <input type="date" name="change_test_begin_time_sel" id="change_test_begin_time_sel" class="input-org-info min-w"
                       style="margin-top: 0;" onClick="WdatePicker()" readonly/>
                <input type="date" name="change_test_end_time_sel" id="change_test_end_time_sel" class="input-org-info min-w"
                       style="margin-top: 0;" onClick="WdatePicker()" readonly/>

                <label for="sq-date">启用日期</label>
                <input type="date" name="change_begin_time_sel" id="change_begin_time_sel" class="input-org-info"
					style="margin-top: 0;" onClick="WdatePicker()" readonly/>
            </p>

            <p>
                <button type="button" class="alert-btn4" id="submit_change_place">保存</button>
				<button type="button" class="alert-btn2" onclick="window.location=window.location">关闭</button>
            </p>
        </form>
    </div>
</div>
<!--
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
-->
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>网点信息</h3>
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
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<script type="text/javascript" src="__PUBLIC__/js/blurrySelect.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/log.js"></script>
<script>


	 $(document).ready(function () {
		 //设置page显示
		$(".resultpage").css("display:block");
		//省份传地址
		getProvince("<?php echo U('channel/Channel/getProvince');?>","<?php echo ($_GET['select_province']); ?>","<?php echo U('channel/Channel/getCity');?>","<?php echo ($_GET['select_city']); ?>");

		var sum = $("#sum").text();
		if(sum==""){
			$("#sum").text("0");
		}
		var state = "<?php echo ($isDeleteResult); ?>";
		if(1 == state){
			$("#place_select_result_ul").empty();
			$("#place_select_result_ul").append("<li onclick='place_use_select();'>启用</li><li class='on' onclick='place_remove_select();'>撤销</li>");
		}else{
			$("#place_select_result_ul").empty();
			$("#place_select_result_ul").append("<li class='on' onclick='place_use_select();'>启用</li><li onclick='place_remove_select();'>撤销</li>");
		}

		$('#j_del_button').click(function(){
		    if(place_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(place_flag == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
			 $.openDOMWindow({
			    loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_del_win'
		     });
             return false;
        });

		//单击删除确认按钮
        $('#j_del_ok').click(function(){
            var place_id=place_val;
            var del_handleUrl="<?php echo U('channel/Place/placeDelete');?>";
            $.getJSON(del_handleUrl,{"place_id":place_id},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

		$("#b_add_place").click(function () {
             $.openDOMWindow({
			     loader:1,
				 loaderHeight:16,
				 loaderWidth:17,
				 windowSourceID:'#j_add_place'
			 });
			 return false;
        });

		$("#b_change_place").click(function () {
			if(place_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(place_flag == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
		    var handleUrl = "<?php echo U('channel/Place/placeDetailSelect');?>";
			var place_id=place_val;
			$.getJSON(handleUrl,{"place_id":place_id},
				function (data){
					$("#change_place_id_txt").val(data['place_id']);
					$("#change_place_name_txt").val(data['place_name']);
					$("#change_place_no_txt").val(data['place_no']);
					$("#change_select_showcity").empty();
					//编辑查询传参省市联动
					getProvince("<?php echo U('channel/Channel/getProvince');?>",data['province_id'],"<?php echo U('channel/Channel/getCity');?>",data['city_id']);
					$("#change_channel_name_txt").val(data['channel_name']);
					$("#change_contacts_txt").val(data['contacts']);
					$("#change_contacts_tel_txt").val(data['contacts_tel']);
					$("#change_status_sel").val(data['status']);
					$("#change_test_begin_time_sel").val(data['test_begin_time']);
					$("#change_test_end_time_sel").val(data['test_end_time']);
					$("#change_region_txt").val(data['region']);
					$("#change_begin_time_sel").val(data['begin_time']);
				}
			,'json'
			);
            $.openDOMWindow({
			    loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_change_place'
			});
			return false;
        });

		//撤销网点
        $('#j_repeal_button').click(function(){
			if(place_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(place_flag == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
            var place_id=place_val;
            var del_handleUrl="<?php echo U('channel/Place/placeRepeal');?>";
            $.getJSON(del_handleUrl,{"place_id":place_id},
                    function (data){
						if(confirm("确定要撤销吗？")){
							//alert(data);
							window.location.href = window.location.href;
						}
                    }
                    ,'json'
            );
        });

		$('#submit_add_place').click(function(){
			var handleUrl = "<?php echo U('channel/Place/placeAdd');?>";
			var add_place_name_txt=$("#add_place_name_txt").val();
			var add_place_no_txt=$("#add_place_no_txt").val();
			var add_channel_name_txt=$("#add_channel_name_txt").val();
			var add_contacts_txt=$("#add_contacts_txt").val();
			var add_contacts_tel_txt=$("#add_contacts_tel_txt").val();
			var add_select_province=$("#add_select_province").val();
			var add_select_city=$("#add_select_city").val();
			var add_status_sel=$("#add_status_sel").val();
			//alert(add_status_sel);
			var add_test_begin_time_sel=$("#add_test_begin_time_sel").val();
			var add_test_end_time_sel=$("#add_test_end_time_sel").val();
			var add_region_txt=$("#add_region_txt").val();
			
			var add_begin_time_sel=$("#add_begin_time_sel").val();
			if(add_place_name_txt==""){
				alert("网点名称不能为空");
				return false;
			}
			if(add_place_no_txt==""){
				alert("网点编号不能为空");
				return false;
			}
			if(add_channel_name_txt==""){
				alert("所属渠道不能为空");
				return false;
			}
			if(add_select_province=="省份"){
				alert("请选择省份");
				return false;	
			}
			if(add_select_city=="地级市"){
				alert("请选择城市");
				return false;	
			}
			if(add_region_txt==""){
				alert("网点地址不能为空");
				return false;
			}
			if(add_status_sel=="test"&&(add_test_begin_time_sel==""||add_test_end_time_sel=="")){
				alert("测试期 测试开始时间和测试结束时间不能为空");
				return false;
			}
			if(add_status_sel=="use"&&(add_begin_time_sel=="")){
				alert("启用期 启用日期不能为空");
				return false;
			}
			var z_begin_date	=	add_test_begin_time_sel.replace('-','').replace('-','');
			var z_end_date	=	add_test_end_time_sel.replace('-','').replace('-','');
			if(add_status_sel=="test"&&(z_end_date<=z_begin_date)){
				alert("测试结束时间必须大于测试开始时间");
				return false;
			}
			$.getJSON(handleUrl,{"add_place_name_txt":add_place_name_txt,"add_place_no_txt":add_place_no_txt,
								 "add_select_province":add_select_province,"add_select_city":add_select_city,
								 "add_channel_name_txt":add_channel_name_txt,"add_contacts_txt":add_contacts_txt,
								 "add_contacts_tel_txt":add_contacts_tel_txt,"add_status_sel":add_status_sel,
								 "add_test_begin_time_sel":add_test_begin_time_sel,"add_test_end_time_sel":add_test_end_time_sel,
								 "add_region_txt":add_region_txt,
								 "add_begin_time_sel":add_begin_time_sel
								 },
				function (data){
					var tmp_msg = "<?php echo C('add_place_success');?>";
					if(tmp_msg == data)
					{
						window.location.href = window.location.href;
					}
					else
					{
						alert(data);
					}
				}
			,'json'
			);
        });

		$(".list_sel").click(function(){
			$(this).find(".role-table-radio").attr("checked",'checked');
			$("#log_info").empty();
			//$("#log_info").append("<li><span class='span-3'><b>操作人</b></span><span class='span-3'><b>操作时间</b></span><span class='span-3'><b>操作日志</b></span></li>");
			var handleUrl = "<?php echo U('channel/Channel/logSelect');?>";
			var place_id=place_val;
			log(handleUrl,place_id,"place");

		});

	});
				

	$('#submit_change_place').click(function(){
		var handleUrl = "<?php echo U('channel/Place/placeSave');?>";
		var change_place_id_txt= place_val;
		var change_place_name_txt=$("#change_place_name_txt").val();
		var change_place_no_txt=$("#change_place_no_txt").val();
		var change_select_province=$("#change_select_province").val();
		var change_select_city=$("#change_select_city").val();
		var change_channel_name_txt=$("#change_channel_name_txt").val();
		var change_contacts_txt=$("#change_contacts_txt").val();
		var change_contacts_tel_txt=$("#change_contacts_tel_txt").val();
		var change_status_sel=$("#change_status_sel").val();
		var change_test_begin_time_sel=$("#change_test_begin_time_sel").val();
		var change_test_end_time_sel=$("#change_test_end_time_sel").val();
		var change_region_txt=$("#change_region_txt").val();
		var change_begin_time_sel=$("#change_begin_time_sel").val();
			if(change_place_name_txt==""){
				alert("网点名称不能为空");
				return false;
			}
			if(change_place_no_txt==""){
				alert("网点编号不能为空");
				return false;
			}
			if(change_channel_name_txt==""){
				alert("所属渠道不能为空");
				return false;
			}
			if(change_select_province=="省份"){
				alert("请选择省份");
				return false;	
			}
			if(change_select_city=="地级市"){
				alert("请选择城市");
				return false;	
			}
			if(change_region_txt==""){
				alert("网点地址不能为空");
				return false;
			}
			if(change_status_sel=="test"&&(change_test_begin_time_sel==""||change_test_end_time_sel=="")){
				alert("测试期 测试开始时间和测试结束时间不能为空");
				return false;
			}
			if(change_status_sel=="use"&&(change_begin_time_sel=="")){
				alert("启用期 启用日期不能为空");
				return false;
			}
			var z_begin_date	=	change_test_begin_time_sel.replace('-','').replace('-','');
			var z_end_date	=	change_test_end_time_sel.replace('-','').replace('-','');
			if(change_status_sel=="test"&&(z_end_date<=z_begin_date)){
				alert("测试结束必须大于测试开始时间");
				return false;
			}
		$.getJSON(handleUrl,{"change_place_id_txt":change_place_id_txt,"change_place_name_txt":change_place_name_txt,
								 "change_place_no_txt":change_place_no_txt,
								 "change_select_province":change_select_province,"change_select_city":change_select_city,
								 "change_channel_name_txt":change_channel_name_txt,"change_contacts_txt":change_contacts_txt,
								 "change_contacts_tel_txt":change_contacts_tel_txt,"change_status_sel":change_status_sel,
								 "change_test_begin_time_sel":change_test_begin_time_sel,"change_test_end_time_sel":change_test_end_time_sel,
								 "change_region_txt":change_region_txt,"change_begin_time_sel":change_begin_time_sel
								 },
				function (data){
					var tmp_msg = "<?php echo C('change_place_success');?>";
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
			jQuery(".role-table").slide({trigger: "click"});
	});
	function place_use_select(){
		$("#select_del_flag_txt").val(0);
		placeSelect.submit();
	}

	function place_remove_select(){
		$("#select_del_flag_txt").val(1);
		placeSelect.submit();
	}
</script>
<script>
    $(function(){
        $('.head-wrap,#head,#footer,#container').css('min-width','1500px');
    })
</script>
</body>
</html>