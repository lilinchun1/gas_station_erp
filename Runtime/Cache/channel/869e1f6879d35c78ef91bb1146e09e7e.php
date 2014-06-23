<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>渠道信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<link rel="stylesheet" href="__PUBLIC__/css/attribute.css"/>

	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/script_city.js"></script>
	<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div class="head-wrap">
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
        <li class="url_link" url="<?php echo U('control/Index/index');?>"><a href="<?php echo U('control/Index/index');?>">加油站监控</a></li>
        <li class="url_link" url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>">运营管理</a></li>
        <li class="url_link" url="<?php echo U('statistics/Index/index');?>"><a href="<?php echo U('statistics/Index/index');?>">统计分析</a></li>
        <li class="url_link" url="<?php echo U('ad/Index/index');?>"><a href="<?php echo U('ad/Index/index');?>">广告管理</a></li>
        <li class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
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
    <li class="aside-nav-nth1 url_link"  url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
    <li class="url_link" url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
    <li class="url_link" url="<?php echo U('channel/Place/index');?>"><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
    <li class="url_link" url="<?php echo U('channel/Device/index');?>"><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
</ul>


    <!--<ul class="aside-nav">
        <li class="aside-nav-nth1"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="active"><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
        <li><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
        <li><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
    </ul>-->
</div>
<div class="right">
<div class="right-con">
<div class="org-right-con">
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form name="channelSelect" method="get" action="<?php echo U('channel/Channel/channelSelect');?>">
            <p>
                <label for="channel-org-name" class="">渠道商名称&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="channel_name_txt" id="channel_name_txt" autocomplete="off" class="input-org-info"
					value="<?php echo ($_GET['channel_name_txt']); ?>"/>
                <label for="channel-class1" class="">渠道类型</label>
                <select name="channel_first_type_sel" id="channel_first_type_sel" class="channel-select-min">
                    <option value="">全部</option>
                    <?php if(is_array($first_channel_type)): foreach($first_channel_type as $key=>$type): if($type["channel_type_id"] == $_GET['channel_first_type_sel']): ?><option selected=selected value="<?php echo ($type["channel_type_id"]); ?>"><?php echo ($type["channel_type_name"]); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($type["channel_type_id"]); ?>"><?php echo ($type["channel_type_name"]); ?></option><?php endif; endforeach; endif; ?>
                </select>
                <select name="channel_second_type_sel" id="channel_second_type_sel" class="channel-select-min">
                    <option value="">全部</option>
                </select>
                <label for="channel-org-in" class="">所属组织机构</label>
                <input type="text" name="agent_name_txt" id="agent_name_txt" autocomplete="off" class="channel-select"
                       value="<?php echo ($_GET['agent_name_txt']); ?>"/>
                <label for="channel-are1" class="">所在区域</label>
                <span id="select_showcity"></span>
                <script type="text/javascript">
                    showprovince("select_province", "select_city", "<?php echo ($_GET['select_province']); ?>", "select_showcity");
                    showcity("select_city", "<?php echo ($_GET['select_city']); ?>", "select_province", "select_showcity");
                </script>
            </p>
            <p>
                <label for="channel-org-name" class="">合同开始日期</label>
                <input type="text" name="contract_begin_time_1" id="contract_begin_time_1" class="input-org-info"
                       value="<?php echo ($_GET['contract_begin_time_1']); ?>" onClick="WdatePicker()"/>
                &nbsp;&nbsp;--&nbsp;&nbsp;
                <input type="text" name="contract_begin_time_2" id="contract_begin_time_2" class="input-org-info"
                       value="<?php echo ($_GET['contract_begin_time_2']); ?>" onClick="WdatePicker()"/>
                <label for="channel-org-name" class="">合同截至日期</label>
                <input type="text" name="contract_end_time_1" id="contract_end_time_1" class="input-org-info"
                       value="<?php echo ($_GET['contract_end_time_1']); ?>" onClick="WdatePicker()"/>
                &nbsp;&nbsp;--&nbsp;&nbsp;
                <input type="text" name="contract_end_time_2" id="contract_end_time_2" class="input-org-info"
                       value="<?php echo ($_GET['contract_end_time_2']); ?>" onClick="WdatePicker()"/>
			    <input type="text" name="select_del_flag_txt" id="select_del_flag_txt" value="0" style="display:none;"/>
                <input type="submit" class="role-control-btn">
            </p>


        </form>
    </div>
    <div class="org-right-btns">
        <form action="">
            <button type="button" class="area-btn" id="b_add_channel">添加</button>
            <button type="button" class="area-btn" id="b_change_channel">编辑/查看</button>
            <button type="button" id="delete_contract" class="area-btn">终止合同</button>
        </form>
    </div>
</div>
<div class="role-table">
    <div class="hd">
        <ul class="channel-tab" id="j-tab-ch">
        </ul>
    </div>
    <div class="bd over-h-y">
        <ul class="role-table-list">
            <li>
                <span class="span-1"></span>
                <span class="span-1"><b>渠道商名称</b></span>
                <span class="span-1"><b>渠道商类型</b></span>
                <span class="span-1"><b>所属组织机构</b></span>
                <span class="span-3"><b>地址信息</b></span>
                <span class="span-2"><b>合同开始日期</b></span>
                <span class="span-1"><b>合同截至日期</b></span>
                <span class="span-1"><b>启用网点数量</b></span>
                <span class="span-1"><b>投放加油站数量</b></span>
            </li>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="list_sel" onclick="selectChannelRadio('<?php echo ($vo['channel_id']); ?>','<?php echo ($vo['channel_type_father_id']); ?>',
							'<?php echo ($vo['channel_type_id']); ?>','<?php echo ($vo['isDelete']); ?>');">
                    <span class="span-1">
						<input type="radio" name="channelDetailID" id="<?php echo ($vo['channelDetailID']); ?>" value="<?php echo ($vo['channel_id']); ?>" 
							 class="role-table-radio"/>
					</span>
                    <span class="span-1" title="#"><?php echo ($vo["channel_name"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["channel_type_name"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["agent_name"]); ?></span>
                    <span class="span-3" title="#"><?php echo ($vo["channel_address"]); ?></span>
                    <span class="span-2" title="#"><?php echo ($vo["begin_time"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["end_time"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["place_num"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["device_num"]); ?></span>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
		<div class="resultpage"><?php echo ($page); ?></div>
        <!--<ul class="role-table-list">
            <li>
                <span class="span-1"></span>
                <span class="span-1"><b>渠道商名称</b></span>
                <span class="span-1"><b>渠道商类型</b></span>
                <span class="span-1"><b>所属组织机构</b></span>
                <span class="span-3"><b>地址信息</b></span>
                <span class="span-2"><b>合同开始日期</b></span>
                <span class="span-1"><b>合同截至日期</b></span>
                <span class="span-1"><b>启用网点数量</b></span>
                <span class="span-1"><b>投放加油站数量</b></span>
            </li>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                    <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                    <span class="span-1" title="#"><?php echo ($vo["channel_name"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["channel_type_name"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["agent_name"]); ?></span>
                    <span class="span-3" title="#"><?php echo ($vo["channel_address"]); ?></span>
                    <span class="span-2" title="#"><?php echo ($vo["begin_time"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["end_time"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["place_num"]); ?></span>
                    <span class="span-1" title="#"><?php echo ($vo["device_num"]); ?></span>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
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
        </ul>-->
    </div>
</div>

<div class="role-table over-h-y">
    <div class="data-log">
        <h3>操作日志</h3>
    </div>
    <ul id="channel_log_info" class="role-table-list role-table-list2">
    </ul>
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

<!--添加框-->
<div id="j_add_channel" style="display:none;">
<div class="alert-role-add">
    <h3>渠道信息</h3>

    <div class="alert-user-add-con">
            <p>
				<label for="channel-address1" class="">所属组织机构：</label>
                <select name="add_agent_id_sel" id="add_agent_id_sel" class="channel-select-min" style="width:150px">
                   <option selected value="">请选择所属组织</option>
				   <?php if(is_array($all_agent)): foreach($all_agent as $key=>$agent): ?><option value="<?php echo ($agent["agent_id"]); ?>"><?php echo ($agent["agent_name"]); ?></option><?php endforeach; endif; ?>
                </select>
			</p>

            <p>
                <label for="channel-addname" class="role-lab">渠道名称</label>
                <input type="text" name="add_channel_name_txt" id="add_channel_name_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="channel-address1" class="">渠道地址</label>
                <span id="add_select_showcity"></span><!--省市联动-->
            </p>
            <p>
                <label for="channel-address1" class="">渠道类型</label>
				<select style="width:164px" name="add_channel_first_type_sel" id="add_channel_first_type_sel" class="channel-select-min">
					<option value="">请选择类型</option>
					<?php if(is_array($first_channel_type)): foreach($first_channel_type as $key=>$type): ?><option value="<?php echo ($type["channel_type_id"]); ?>"><?php echo ($type["channel_type_name"]); ?></option><?php endforeach; endif; ?>
				</select>
                <select name="add_channel_second_type_sel" id="add_channel_second_type_sel" class="channel-select-min">
					<option value="">全部</option>
				</select>
                <a class="channel-wz-a"  id="sort_button">修改类别</a><a class="channel-wz-a" id="attr_button">修改属性</a>
				<html>

<div class="mod_sort" style="display:none;" id="mod_sort">
	<div class="mod_txt">所属类别</div>
	<div id="mod_kl"><!--类别放的地方begin-->
		
	</div><!--类别放的地方end-->

	<div><!--确定框-->
		<input id="add_class_ok_button" type="button" value="" class="mod_but"/>
	</div>


</div>
</html>
				<html>
<div class="mod_arrt" style="display:none;" id="mod_arrt">
<div class="mod_txt" style="float:left;">所属类别</div>
		<div id="mod_rt" ><!--类别放的地方begin-->

		</div><!--类别放的地方end-->
		<div id="mod_arrt_bl" style="margin-top:10px;"><!--属性放的地方-->
			
		</div>
		<div><!--确定框-->
			<input id="" type="button" value="" class="mod_but"/>
		</div>
</div>
</html>
            </p>
            <p>
                <label for="user-phone" class="role-lab">联系人&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="add_contacts_txt" id="add_contacts_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="user-phone" class="role-lab">联系电话</label>
                <input type="text" name="add_contacts_tel_txt" id="add_contacts_tel_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="login-id" class="role-lab">合同编号</label>
                <input type="text" name="add_contract_number_txt" id="add_contract_number_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="sq-date">授权日期</label>
                <input type="text" name="add_begin_time_sel" id="add_begin_time_sel" class="input-org-info min-w" 
					onClick="WdatePicker()" readonly="readonly" style="margin-top: 0;"/>
                <input type="text" name="add_end_time_sel" id="add_end_time_sel" class="input-org-info min-w" 
					onClick="WdatePicker()" readonly="readonly" style="margin-top: 0;"/>
            </p>

            <p>
                <button type="button" class="alert-btn2" id="submit_add_channel">保存</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
				</a>
            </p>
    </div>
</div>
</div>

<!--修改框-->
<div id="j_change_channel" style="display:none;">
<div class="alert-role-add">
    <h3>渠道信息</h3>

    <div class="alert-user-add-con">
        <form action="">
            <p>
				<label for="channel-address1" class="">所属组织机构：</label>
                <select name="change_belong_agent_id_sel" id="change_belong_agent_id_sel" class="channel-select-min" style="width:150px">
                   <option selected value="">请选择所属组织</option>
				   <?php if(is_array($all_agent)): foreach($all_agent as $key=>$agent): ?><option value="<?php echo ($agent["agent_id"]); ?>"><?php echo ($agent["agent_name"]); ?></option><?php endforeach; endif; ?>
                </select>
			</p>

            <p>
                <label for="channel-addname" class="role-lab">渠道名称</label>
                <input type="text" name="change_channel_name_txt" id="change_channel_name_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="channel-address1" class="">渠道地址</label>
                <span id="change_select_showcity"></span><!--省市联动-->
            </p>
            <p>
                <label for="channel-address1" class="">渠道类型</label>
				<select style="width:164px" name="change_channel_first_type_sel" id="change_channel_first_type_sel" class="channel-select-min">
					<option value="">请选择类型</option>
					<?php if(is_array($first_channel_type)): foreach($first_channel_type as $key=>$type): ?><option value="<?php echo ($type["channel_type_id"]); ?>"><?php echo ($type["channel_type_name"]); ?></option><?php endforeach; endif; ?>
				</select>
                <select name="change_channel_second_type_sel" id="change_channel_second_type_sel" class="channel-select-min">
					<option value="">全部</option>
				</select>
                <!--<a class="channel-wz-a" href="">修改类别</a><a class="channel-wz-a" href="">修改属性</a>-->
            </p>
            <p>
                <label for="user-phone" class="role-lab">联系人&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="change_contacts_txt" id="change_contacts_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="user-phone" class="role-lab">联系电话</label>
                <input type="text" name="change_contacts_tel_txt" id="change_contacts_tel_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="login-id" class="role-lab">合同编号</label>
                <input type="text" name="change_contract_number_txt" id="change_contract_number_txt" class="input-role-name"/>
            </p>

            <p>
                <label for="sq-date">授权日期</label>
                <input type="text" name="change_begin_time_sel" id="change_begin_time_sel" class="input-org-info min-w" 
					onClick="WdatePicker()" readonly="readonly" style="margin-top: 0;"/>
                <input type="text" name="change_end_time_sel" id="change_end_time_sel" class="input-org-info min-w" 
					onClick="WdatePicker()" readonly="readonly" style="margin-top: 0;"/>
            </p>

            <p>
                <button type="button" class="alert-btn2" id="submit_change_channel">保存</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
				</a>
            </p>
        </form>
    </div>
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
<!--<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>-->
<script>
	var channel_val='';
	var channel_flag='';
	var channel_first_type='';
	var channel_second_type='';
	function selectChannelRadio(channel_id, first_type, second_type, channel_delete){
		channel_val = channel_id;
		channel_first_type = first_type;
		channel_second_type = second_type;
		channel_flag = channel_delete;
	}

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

</script>
<!--<script type="text/javascript">jQuery(".role-table").slide({trigger: "click"});</script>-->
<link rel="stylesheet" href="__PUBLIC__/css/jquery.bigautocomplete.css" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		var state = "<?php echo ($isDeleteResult); ?>";
		if(1 == state){
			$(".channel-tab").append("<li onclick='channel_use_select();'>启用</li><li class='on' onclick='channel_remove_select();'>撤销</li>");
		}else{
			$(".channel-tab").append("<li class='on' onclick='channel_use_select();'>启用</li><li onclick='channel_remove_select();'>撤销</li>");
		}
        agent_name_blurry();
        channel_name_blurry();
        var channel_first_type_sel = $("#channel_first_type_sel").val();
        if ('' != channel_first_type_sel) {
            var channel_second_type_sel = "<?php echo ($_GET['channel_second_type_sel']); ?>";
            $("#channel_second_type_sel option").remove();
            var handleUrl = "<?php echo U('channel/Channel/channelSecondTypeSelect');?>";
            $.getJSON(handleUrl, {'channel_first_type_sel': channel_first_type_sel},
                    function (data) {
                        $("#channel_second_type_sel").append("<option value=''>全部</option>");
                        $.each(data, function (key, val) {
                            if (val['channel_type_id'] == channel_second_type_sel) {
                                $("#channel_second_type_sel").append("<option selected=selected																			value=" + val['channel_type_id'] + ">" + val['channel_type_name'] + "</option>");
                            }
                            else {
                                $("#channel_second_type_sel").append("<option value=" + val['channel_type_id'] + ">" + val['channel_type_name'] + "</option>");
                            }
                        });
                    }
                    , 'json'
            );
        }
        $("#channel_first_type_sel").change(function () {
            var channel_first_type_sel = $("#channel_first_type_sel").val();
            $("#channel_second_type_sel option").remove();
            var handleUrl = "<?php echo U('channel/Channel/channelSecondTypeSelect');?>";
            $.getJSON(handleUrl, {'channel_first_type_sel': channel_first_type_sel},
                    function (data) {
                        $("#channel_second_type_sel").append("<option value=''>全部</option>");
                        $.each(data, function (key, val) {
                            $("#channel_second_type_sel").append("<option value='" + val['channel_type_id'] + "'>" + val['channel_type_name'] + "</option>");
                        });
                    }
                    , 'json'
            );
        });

		$("#add_channel_first_type_sel").change(function(){
			var channel_first_type_sel = $("#add_channel_first_type_sel").val();
			$("#add_channel_second_type_sel option").remove();
			var handleUrl = "<?php echo U('Channel/channelSecondTypeSelect');?>";
			$.getJSON(handleUrl,{'channel_first_type_sel':channel_first_type_sel},
				function (data){
					$("#add_channel_second_type_sel").append("<option value=''>全部</option>");
					$.each(data,function(key,val){
						$("#add_channel_second_type_sel").append("<option value='" + val['channel_type_id']+ "'>"+ val['channel_type_name'] +"</option>");
					});
				}
				,'json'
			);
		});

		$("#change_channel_first_type_sel").change(function(){
			var channel_first_type_sel = $("#change_channel_first_type_sel").val();
			$("#change_channel_second_type_sel option").remove();
			var handleUrl = "<?php echo U('Channel/channelSecondTypeSelect');?>";
			$.getJSON(handleUrl,{'channel_first_type_sel':channel_first_type_sel},
				function (data){
					$("#change_channel_second_type_sel").append("<option value=''>全部</option>");
					$.each(data,function(key,val){
						$("#change_channel_second_type_sel").append("<option value='" + val['channel_type_id']+ "'>"+ val['channel_type_name'] +"</option>");
					});
				}
				,'json'
			);
		});

		$("#delete_contract").click(function () {
			if(channel_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(channel_flag == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
            var channel_id= channel_val;
            var del_handleUrl="<?php echo U('channel/Channel/channelContractDelete');?>";
            $.getJSON(del_handleUrl,{"channel_id":channel_id},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

		$("#b_add_channel").click(function () {
             $.openDOMWindow({
			     loader:1,
				 loaderHeight:16,
				 loaderWidth:17,
				 windowSourceID:'#j_add_channel'
			 });
			 return false;
        });

		$('#submit_add_channel').click(function(){
			var handleUrl = "<?php echo U('channel/Channel/channelAdd');?>";
			var add_channel_name_txt=$("#add_channel_name_txt").val();//渠道商名称
			var add_agent_id_sel=$("#add_agent_id_sel").val();//所属代理商
			var add_select_province=$("#add_select_province").val();//省份
			var add_select_city=$("#add_select_city").val();//城市
			var add_channel_first_type_sel=$("#add_channel_first_type_sel").val();//类型
			var add_channel_second_type_sel=$("#add_channel_second_type_sel").val();//属性
			var add_contacts_txt=$("#add_contacts_txt").val();//联系人名称
			var add_contacts_tel_txt=$("#add_contacts_tel_txt").val();//联系人电话
			//var add_channel_address_txt=$("#add_channel_address_txt").val();//渠道商地址
			var add_contract_number_txt=$("#add_contract_number_txt").val();
			var add_begin_time_sel=$("#add_begin_time_sel").val();
			var add_end_time_sel=$("#add_end_time_sel").val();
			$.getJSON(handleUrl,{"add_channel_name_txt":add_channel_name_txt,"add_agent_id_sel":add_agent_id_sel,
								 "add_contacts_tel_txt":add_contacts_tel_txt,
								 "add_select_province":add_select_province,"add_select_city":add_select_city,
								 "add_channel_first_type_sel":add_channel_first_type_sel,"add_channel_second_type_sel":add_channel_second_type_sel,
								 "add_contacts_txt":add_contacts_txt,"add_contract_number_txt":add_contract_number_txt,
								 "add_begin_time_sel":add_begin_time_sel,"add_end_time_sel":add_end_time_sel
								 },
				function (data){
					var tmp_msg = "<?php echo C('add_channel_success');?>";
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
        });

		$("#b_change_channel").click(function () {
			if(channel_val == '')
			{
				alert("<?php echo C('no_select_data');?>");
				return;
			}
			if(channel_flag == 1)
			{
				alert("<?php echo C('repeal_no_edit');?>");
				return;
			}
			var handleUrl = "<?php echo U('channel/Channel/channelDetailSelect');?>";
			var channel_id=channel_val;
			$.getJSON(handleUrl,{"channel_id":channel_val},
				function (data){
					$("#change_channel_name_txt").val(data['channel_name']);
					//$("#change_agent_id_sel").val(data['agent_id']);

					var handleUrl = "<?php echo U('channel/Channel/getAllAgent');?>";
					var agentTab = "";
					var tmp_agentid;
					var belong_agent_id = data['agent_id'];
					$.getJSON(handleUrl,{},
						function (data){
							//agentTab += "<option value=\"\">请选择所属代理商</option>";
							$.each(data, function(i,item){
								tmp_agentid = item.agent_id;
								if(tmp_agentid == belong_agent_id)
								{
									agentTab += "<option value =" + "'" + item.agent_id + "' selected='selected'>" + item.agent_name + "</option>";
								}
								else
								{
									agentTab += "<option value =" + "'" + item.agent_id + "'>" + item.agent_name + "</option>";
								}
						});
						$("#change_belong_agent_id_sel").html(agentTab);
					}
					,'json'
					);

					if('' == channel_first_type)
					{
						handleUrl = "<?php echo U('channel/Channel/getAllChannelType');?>";
						var typeTab = "";
						$.getJSON(handleUrl,{},
							function (data){
								typeTab += "<option value=\"\">全部</option>";
								$.each(data, function(i,item){
									typeTab += "<option value =" + "'" + item.channel_type_id + "'>" + item.channel_type_name + "</option>";
							});
							$("#change_channel_first_type_sel").html(typeTab);
						}
						,'json'
						);
					}
					else if('0' == channel_first_type)
					{
						handleUrl = "<?php echo U('channel/Channel/getAllChannelType');?>";
						var typeTab = "";
						var tmp_typeid;
						$.getJSON(handleUrl,{},
							function (data){
								typeTab += "<option value=\"\">全部</option>";
								$.each(data, function(i,item){
									tmp_typeid = item.channel_type_id;
									if(tmp_typeid == channel_second_type)
									{
										typeTab += "<option value =" + "'" + item.channel_type_id + "' selected='selected'>" + item.channel_type_name + "</option>";
									}
									else
									{
										typeTab += "<option value =" + "'" + item.channel_type_id + "'>" + item.channel_type_name + "</option>";
									}
							});
							$("#change_channel_first_type_sel").html(typeTab);
						}
						,'json'
						);

						handleUrl = "<?php echo U('channel/Channel/channelSecondTypeSelect');?>";
						var secondTypeTab = "";
						var tmp_secondTypeid;
						$.getJSON(handleUrl,{'channel_first_type_sel':channel_second_type},
							function (data){
								secondTypeTab += "<option value=\"\">全部</option>";
								$.each(data, function(i,item){
									secondTypeTab += "<option value =" + "'" + item.channel_type_id + "'>" + item.channel_type_name + "</option>";
							});
							$("#change_channel_second_type_sel").html(secondTypeTab);
						}
						,'json'
						);
					}
					else
					{
						handleUrl = "<?php echo U('channel/Channel/getAllChannelType');?>";
						var typeTab = "";
						var tmp_typeid;
						$.getJSON(handleUrl,{},
							function (data){
								typeTab += "<option value=\"\">全部</option>";
								$.each(data, function(i,item){
									tmp_typeid = item.channel_type_id;
									if(tmp_typeid == channel_first_type)
									{
										typeTab += "<option value =" + "'" + item.channel_type_id + "' selected='selected'>" + item.channel_type_name + "</option>";
									}
									else
									{
										typeTab += "<option value =" + "'" + item.channel_type_id + "'>" + item.channel_type_name + "</option>";
									}
							});
							$("#change_channel_first_type_sel").html(typeTab);
						}
						,'json'
						);

						handleUrl = "<?php echo U('channel/Channel/channelSecondTypeSelect');?>";
						var secondTypeTab = "";
						var tmp_secondTypeid;
						$.getJSON(handleUrl,{'channel_first_type_sel':channel_first_type},
							function (data){
								secondTypeTab += "<option value=\"\">全部</option>";
								$.each(data, function(i,item){
									tmp_secondTypeid = item.channel_type_id;
									if(tmp_secondTypeid == channel_second_type)
									{
										secondTypeTab += "<option value =" + "'" + item.channel_type_id + "' selected='selected'>" + item.channel_type_name + "</option>";
									}
									else
									{
										secondTypeTab += "<option value =" + "'" + item.channel_type_id + "'>" + item.channel_type_name + "</option>";
									}
							});
							$("#change_channel_second_type_sel").html(secondTypeTab);
						}
						,'json'
						);
					}

					$("#change_select_showcity").empty();
					showprovince("change_select_province", "change_select_city", data['province'], "change_select_showcity");
					showcity("change_select_city", data['city'], "change_select_province", "change_select_showcity");
					if('0' == channel_first_type)
					{
						$("#change_channel_first_type_sel").val(channel_second_type);
						$("#change_channel_second_type_sel").val('');
					}
					else
					{
						$("#change_channel_first_type_sel").val(channel_first_type);
						$("#change_channel_second_type_sel").val(channel_second_type);
					}
					$("#change_contacts_txt").val(data['contacts']);
					$("#change_contacts_tel_txt").val(data['contacts_tel']);
					//$("#change_channel_address_txt").val(data['channel_address']);
					$("#change_contract_number_txt").val(data['contract_number']);
					$("#change_begin_time_sel").val(data['begin_time']);
					$("#change_end_time_sel").val(data['end_time']);
				}
			,'json'
			);
            $.openDOMWindow({
			    loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_change_channel'
			});
			return false;
        });

		$('#submit_change_channel').click(function(){
			var handleUrl = "<?php echo U('channel/Channel/channelSave');?>";
			var change_channel_name_txt=$("#change_channel_name_txt").val();//渠道商名称
			var change_channel_id_txt= channel_val;
			var change_agent_id_sel=$("#change_belong_agent_id_sel").val();
			//var change_src_province= channel_province;
			//var change_src_city= channel_city;
			var change_dst_province=$("#change_select_province").val();//省份
			var change_dst_city=$("#change_select_city").val();//城市
			var src_channel_first_type=channel_first_type;//类型
			var src_channel_second_type=channel_second_type;//属性
			var dst_channel_first_type_sel=$("#change_channel_first_type_sel").val();//类型
			var dst_channel_second_type_sel=$("#change_channel_second_type_sel").val();//属性
			var change_contacts_txt=$("#change_contacts_txt").val();//联系人名称
			var change_contacts_tel_txt=$("#change_contacts_tel_txt").val();//联系人电话
			//var change_channel_address_txt=$("#change_channel_address_txt").val();//渠道商地址
			var change_contract_number_txt=$("#change_contract_number_txt").val();
			var change_begin_time_sel=$("#change_begin_time_sel").val();
			var change_end_time_sel=$("#change_end_time_sel").val();
			$.getJSON(handleUrl,{"change_channel_name_txt":change_channel_name_txt,"change_channel_id_txt":change_channel_id_txt,
								"change_agent_id_sel":change_agent_id_sel,"change_dst_province":change_dst_province,"change_dst_city":change_dst_city,
								 "src_channel_first_type":src_channel_first_type,"src_channel_second_type":src_channel_second_type,
								 "dst_channel_first_type_sel":dst_channel_first_type_sel,"dst_channel_second_type_sel":dst_channel_second_type_sel,
								 "change_contacts_txt":change_contacts_txt,"change_contacts_tel_txt":change_contacts_tel_txt,
								 //"change_channel_tel_txt":change_channel_tel_txt,"change_channel_address_txt":change_channel_address_txt,
								 "change_contract_number_txt":change_contract_number_txt,"change_begin_time_sel":change_begin_time_sel,
								 "change_end_time_sel":change_end_time_sel
								 },
				function (data){
					var tmp_msg = "<?php echo C('change_channel_success');?>";
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
		});

		
		//点击修改类别事件  显示弹窗
		$("#sort_button").click(function(){
			//显示弹窗
			$("#mod_sort").slideDown(500);
			zong_bind();
			chushihua();
			$("#mod_kl").html("");
			
		});//点击修改类别结束

		//点击完成事件隐藏窗口

		$("#add_class_ok_button").click(function(){
			//隐藏弹窗
			$("#mod_sort").slideUp(500);
			handleUrl = "<?php echo U('Channel/getAllChannelType');?>";
			var typeTab = "";
			$.getJSON(handleUrl,{},
				function (data){
					typeTab += "<option value=\"\">请选择类型</option>";
					$.each(data, function(i,item){
						typeTab += "<option value =" + "'" + item.channel_type_id + "'>" + item.channel_type_name + "</option>";
					});
				$("#add_channel_first_type_sel").html(typeTab);
				}
			,'json'
			);
		});


		//点击修改属性事件  显示弹窗
		$("#attr_button").click(function(){
			//显示弹窗
			$("#mod_arrt").slideDown(500);
			$("#mod_arrt_bl").html("");//初始化遍历属性窗
			sort_kk();
			chushihua();
			$("#select_sort").remove();//初始化遍历类型列表
			//绑定遍历
		});//点击修改类别结束

		//点击完成事件隐藏窗口

		$(".mod_but").click(function(){
			//隐藏弹窗
			$("#mod_arrt").slideUp(500);
			$("#select_sort").remove();//初始化遍历类型列表
			$("#mod_arrt_bl").html("");//初始化遍历属性窗
		});



//===============================================单击查询框里某一条数据=======================================
		$(".list_sel").click(function(){
			$(this).find(".role-table-radio").attr("checked",'checked');
			$("#channel_log_info").empty();
			$("#channel_log_info").append("<li><span class='span-3'><b>操作人</b></span><span class='span-3'><b>操作时间</b></span><span class='span-3'><b>操作日志</b></span></li>");
			var handleUrl = "<?php echo U('channel/Channel/channelLogSelect');?>";
			var channel_id=channel_val;
			$.getJSON(handleUrl,{"channel_id":channel_id},
				function (data){
					$.each(data, function(i,item){
						    $("#channel_log_info").append("<li><span class='span-3'>" + item.user + "</span><span class='span-3'>" +
								item.time + "</span><span class='span-3' title='" + item.info + "'>" + item.info + "</span></li>");
					});
			}
			,'json'
			);
		});

    });

    function agent_name_blurry() {
        var handleUrl = "<?php echo U('channel/Agent/agentnameBlurrySelect');?>";
        var agent_name = '';
        $.getJSON(handleUrl, {"agent_name": agent_name},
                function (data) {
                    var str = data;
                    //alert(data);
                    //alert(str[1]['title']);
                    $("#agent_name_txt").bigAutocomplete({width: 150, data: data, callback: function (data) {
                    }});
                }
                , 'json'
        );
    }

    function channel_name_blurry() {
        var handleUrl = "<?php echo U('channel/Channel/channelnameBlurrySelect');?>";
        $.getJSON(handleUrl, {},
                function (data) {
                    var str = data;
                    //alert(data);
                    //alert(str[1]['title']);
                    $("#channel_name_txt").bigAutocomplete({width: 150, data: data, callback: function (data) {
                    }});
                }
                , 'json'
        );
    }

	function channel_use_select(){
		$("#select_del_flag_txt").val(0);
		channelSelect.submit();
	}

	function channel_remove_select(){
		$("#select_del_flag_txt").val(1);
		channelSelect.submit();
	}





	//属性_遍历json查询类型
	function sort_kk(){
			$("#mod_arrt_bl").html("");//初始化遍历属性窗
			//访问json
			var str = "";
			$.get("<?php echo U('Channel/getAllChannelType');?>",{'str':str},function(data1){
				$("#mod_rt").append("<select id='select_sort' value=''><option>请选择所属类型</option></select>");
				$.each(data1,function(key,val){
						$("#select_sort").append("<option value='"+val['channel_type_id']+"'>"+val['channel_type_name']+"</option>");
				});	
				$("#select_sort").bind("change", sel_arrt);
			},"json")
			
		}

	//属性_查询按照类别查询属性
	function sel_arrt(){
		$("#mod_arrt_bl").html("");//初始化遍历属性窗
		var thisval= $('#select_sort option:selected').val();//此文本的val
		if(thisval!="请选择所属类型"){
			//这个地方要疯了。。记得一定要在channel前面加/
			var posturl="<?php echo U('channel/Channel/channelSecondTypeSelect');?>"+'/channel_first_type_sel/'+thisval;
			var str = "";
			$.get(posturl,{'str':str},function(data2){
				$.each(data2,function(key,val){
					$("#mod_arrt_bl").append("<div><input type='text' value='"+val['channel_type_name']+"' id='"+val['channel_type_id']+"' class='sel_sort'/><input type='button' class='delect_sort'/></div>");
					
				})
			chushihua();//初始化样式
			$(".sel_sort").bind("dblclick", mod_arrt);//绑定文本框修改事件
			$("#mod_arrt_bl").append("<input type='button' value='添加属性' class='add_sort'/> ")//添加属性按钮
			$(".delect_sort").bind("click", del_arrt_bind);//绑定删除单击事件
			$(".add_sort").bind("click", add_arrt_bind);//绑定添加单击事件
			lang=0;
			},"json")
		}else{
			chushihua();//初始化样式
			$("#mod_arrt_bl").html("");//初始化遍历属性窗
		}
	}
	//属性_添加
	function add_arrt_bind(){
		var lang=$(".sel_sort").length;
		var lastval=$(".sel_sort:last").val();
		if(lang<=11&&lastval!=""){
			$(this).before("<div><input type='text' value='' id='' class='sel_sort'/><input type='button' class='delect_sort'/></div>");
			$(".sel_sort").bind("dblclick", mod_arrt);//绑定文本框双击事件
			$(".delect_sort").bind("click", del_arrt_bind);//绑定删除单击事件
			$(".sel_sort").attr("readonly", "readonly");  //给文本框设置只读样式
			$(".sel_sort").css("cursor","pointer");//文本框手势
		}
	}
	//属性_修改
	function mod_arrt(){
		 oldval=$(this).val()//记录原来的值
		 $(this).attr("readonly", false);  //取消文本框只读
		 $(this).css("cursor","auto");//取消文本框手势
		 $(".sel_sort").unbind("dblclick", mod_arrt);//解除绑定
		 $(this).blur(function(){
			 if(oldval!==""){
				newval=$(this).val();//记录现在的值
				if(newval==oldval){
					chushihua();
				}else{
					//向服务器请求更改
						var thisid= $(this).attr("id");//此文本的ID
						var faval= $('#select_sort option:selected').val();//此文本父级菜单的值
						$.getJSON("<?php echo U('channel/Channel/channelTypeSave');?>",{"first_channel_type_id":faval,"second_channel_type_id":thisid,"dst_channel_type_name":newval},
						function (lp){
							var tmp_msg = "<?php echo C('change_channel_success');?>";
							if(tmp_msg != lp)
							{
								alert(lp);
							}
						}
						,'json'
						);
						$("#mod_arrt_bl").html("");
						sel_arrt();
						chushihua();
				}
			 }else{
				//进行新增
				newval=$(this).val();//现在的值
				if(newval!=""){
					var faval= $('#select_sort option:selected').val();//此文本父级菜单的值
					$.getJSON("<?php echo U('channel/Channel/channelTypeAdd');?>",{"channel_type_father_id":faval,"channel_type_name":newval},
							function (lp){
								var tmp_msg = "<?php echo C('add_type_success');?>";
								if(tmp_msg != lp)
								{
									alert(lp);
								}
								$("#mod_arrt_bl").html("");
								sel_arrt();
								chushihua();
							}
							,'json'
							);
				}else{
					$("#mod_arrt_bl").html("");
					sel_arrt();
					chushihua();
				}
			 }
		});
	}

	//属性_单击删除方法
	function del_arrt_bind(){
		var del_thisid=$(this).parent().find(".sel_sort").attr("id");
		$.getJSON("<?php echo U('channel/Channel/channelTypeDelete');?>",{"channel_type_id":del_thisid},
			function (lp){
				var tmp_msg = "<?php echo C('delete_type_success');?>";
				if(tmp_msg != lp)
				{
					alert(lp);
				}
				$("#mod_arrt_bl").html("");
				sel_arrt();
				chushihua();
			}
			,'json'
		);

	}
	//类别_遍历json查询类型
	function zong_bind(){
			$("#mod_kl").html("");
			//访问json
			var str = "";
			//控制换行的变量
			var kongzhi=1;
			$.get("<?php echo U('channel/Channel/getAllChannelType');?>",{'str':str},function(data1){
				$.each(data1,function(key,val){
					if(kongzhi==3){
						$("#mod_kl").append("<div><input type='text' value='"+val['channel_type_name']+"' id='"+val['channel_type_id']+"' class='sel_leibie'/><input type='button' class='delect_sort'/></div><br/>");
					}else{
						$("#mod_kl").append("<div><input type='text' value='"+val['channel_type_name']+"' id='"+val['channel_type_id']+"' class='sel_leibie'/><input type='button' class='delect_sort'/></div>");
					}
				});
				var oldval="";
				var newval="";
				$(".sel_leibie").one("dblclick", sel_sort_bind);//绑定文本框双击事件
				$(".delect_sort").bind("click", del_sort_bind);//绑定删除单击事件
				$(".sel_leibie").attr("readonly", "readonly");  //给文本框设置只读样式
				$(".sel_leibie").css("cursor","pointer");//文本框手势
				$("#mod_kl").append("<input type='button' value='添加类别' class='add_sort'/> ")//添加类型按钮
				$(".add_sort").one("click", add_sort_bind);//绑定添加单击事件
				
			},"json")
		}
	//类别_双击文本框修改方法
	function sel_sort_bind(){
		 oldval=$(this).val()//把原来的值付给
		 $(this).attr("readonly", false);  //取消文本框只读
		 $(this).css("cursor","auto");//取消文本框手势
		 $(".sel_leibie").unbind("dblclick", sel_sort_bind);//解除绑定
		 $(this).blur(function(){
			 if(oldval!=""){
				newval=$(this).val();//现在的值
				if(newval==oldval){
					chushihua();
				}else{
					//向服务器请求更改
						var thisid= $(this).attr("id");//此文本的ID
						$.getJSON("<?php echo U('channel/Channel/channelTypeSave');?>",{"first_channel_type_id":thisid,"dst_channel_type_name":newval},
						function (lp){
							var tmp_msg = "<?php echo C('change_type_success');?>";
							if(tmp_msg != lp)
							{
								alert(lp);
							}
						}
						,'json'
						);
						$("#mod_kl").html("");
						zong_bind();
						chushihua();
				}
			 }else{
				//进行新增
				newval=$(this).val();//现在的值
				if(newval!=""){
					$.getJSON("<?php echo U('channel/Channel/channelTypeAdd');?>",{"channel_type_name":newval},
							function (lp){
								var tmp_msg = "<?php echo C('add_type_success');?>";
								if(tmp_msg != lp)
								{
									alert(lp);
								}
								$("#mod_kl").html("");
								zong_bind();
								chushihua();
							}
							,'json'
							);
				}else{
					$("#mod_kl").html("");
					zong_bind();
					chushihua();
				}
			 }
		});
	};
	//类别_单击删除方法
	function del_sort_bind(){
		var del_thisid=$(this).parent().find(".sel_leibie").attr("id");
		$.getJSON("<?php echo U('channel/Channel/channelTypeDelete');?>",{"channel_type_id":del_thisid},
			function (lp){
				var tmp_msg = "<?php echo C('delete_type_success');?>";
				if(tmp_msg != lp)
				{
					alert(lp);
				}
				$("#mod_kl").html("");
				zong_bind();
				chushihua();
			}
			,'json'
		);

	}

	//类别_添加方法
	function add_sort_bind(){
		var lang=$(".sel_leibie").length;
		var lastval=$(".sel_sort:last").val();
		if(lang<=11&&lastval!=""){
			$(this).before("<div><input type='text' value='' id='' class='sel_leibie'/><input type='button' class='delect_sort'/></div>");

			$(".sel_leibie").bind("dblclick", sel_sort_bind);//绑定文本框双击事件
			$(".delect_sort").bind("click", del_sort_bind);//绑定删除单击事件
			$(".sel_leibie").attr("readonly", "readonly");  //给文本框设置只读样式
			$(".sel_leibie").css("cursor","pointer");//文本框手势
		}
	}


	//类别_初始化所有类型
	function chushihua(){
	
		$(".sel_sort").attr("readonly", "readonly"); 
		$(".sel_sort").css("cursor","pointer");//文本框手势
	}
</script>
<script type="text/javascript">
			showprovince("add_select_province", "add_select_city", "省份", "add_select_showcity");
			showcity("add_select_city", "城市", "add_select_province", "add_select_showcity"); 
</script>
</body>
</html>