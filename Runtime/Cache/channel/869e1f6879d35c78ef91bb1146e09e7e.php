<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>渠道信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/script_city.js"></script>
	<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
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
            <a href="javascript:void(0);" onclick="show_user_logout()">退出系统</a>
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
        <li class="aside-nav-nth1"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="active"><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
        <li><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
        <li><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
    </ul>
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
            <button type="button" class="area-btn">编辑/查看</button>
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
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                    <span class="span-1">
						<input type="radio" name="<?php echo ($vo['channelDetailID']); ?>" id="<?php echo ($vo['channelDetailID']); ?>" value="<?php echo ($vo['channel_id']); ?>" 
							onclick="selectChannelRadio('<?php echo ($vo['channel_id']); ?>');" class="role-table-radio"/>
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
            <li>
                <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                <span class="span-1" title="#">Lorem ipsum dolor sit.</span>
                <span class="span-1" title="#">Dolore eius expedita molestias!</span>
                <span class="span-1" title="#">Blanditiis dolorum pariatur vitae?</span>
                <span class="span-3" title="#">Perspiciatis quae ratione repudiandae!</span>
                <span class="span-2" title="#">Ipsa nulla quidem voluptate?</span>
                <span class="span-1" title="#">Consequuntur eveniet itaque velit.</span>
                <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
                <span class="span-1" title="#">Aspernatur blanditiis ipsum nulla!</span>
            </li>
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
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<div id="change_password_id" style="display:none;">
    <div class="alert-role-add" >
    <h3>修改密码</h3>
    <div class="alert-role-add-con">
        <p>
            <label for="old_password_txt" class="role-lab">旧密码&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="old_password_txt" id="old_password_txt" class="input-role-name"/>
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

<div id="j_add_channel" style="display:none;">
<div class="alert-role-add">
    <h3>渠道信息</h3>

    <div class="alert-user-add-con">
        <form action="">
            <p>
				<label for="channel-address1" class="">所属组织机构：</label>
                <select name="add_agent_id_sel" id="add_agent_id_sel" class="channel-select-min">
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
                <a class="channel-wz-a" href="">修改类别</a><a class="channel-wz-a" href="">修改属性</a>
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
	function selectChannelRadio(channel_id){
		channel_val = channel_id;
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

		$("#delete_contract").click(function () {
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
</script>
<script type="text/javascript">
			showprovince("add_select_province", "add_select_city", "省份", "add_select_showcity");
			showcity("add_select_city", "城市", "add_select_province", "add_select_showcity"); 
</script>
</body>
</html>