<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>加油站信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>

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
		//$('#change_password_id').show();
		$.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#change_password_id'
        });
        return false;
	}
</script>
<div id="container">
<div class="left">
    <ul class="aside-nav">
        <li class="aside-nav-nth1"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li><a href="<?php echo U('channel/Channel/index');?>"><input type="button" value="渠道信息"></a></li>
        <li><a href="<?php echo U('channel/Place/index');?>"><input type="button" class="" value="网点信息"></a></li>
        <li class="active"><a href="<?php echo U('channel/Device/index');?>"><input type="button" class="" value="加油站信息"></a></li>
    </ul>
</div>
<div class="right">
<div class="right-con">
<div class="org-right-con">
<div class="role-control" id="j-fixed-top">
    <div class="role-inquire channel-index-btns">
        <form name="deviceSelect" method="get" action="<?php echo U('channel/Device/deviceSelect');?>">
            <p>
                <label for="device-drive-id" class="">设备编号</label>
                <input type="text" name="device_no_txt" id="device_no_txt" class="input-org-info"/>
                <label for="mac1" class="">MAC</label>
                <input type="text" name="mac_txt" id="mac_txt" class="input-org-info"/>
                <label for="device-state" class="">加油站状态</label>
                <select name="select_device_status" id="select_device_status" class="channel-select-min">
                    <option selected value="">选择状态</option> 
					<optgroup label="运行">  
					    <option value="normal">正常</option>  
						<option value="abnormal">异常</option>  
					</optgroup>  
					<optgroup label="未运行">  
						<option value="not_use">未运行</option> 
					</optgroup>
                </select>
                <label for="channel-ss-channel" class="">所属网点</label>
                <input type="text" name="place_name_txt" id="place_name_txt" class="input-org-info"/>
				<input type="text" name="select_del_flag_txt" id="select_del_flag_txt" value="0" style="display:none;"/>
                <input type="submit" class="role-control-btn">
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
        <ul id="device_select_result_ul" class="channel-tab">
        </ul>
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
				<?php if($isDeleteResult != 1): ?><span class="span-1"><b>加油站状态</b></span><?php endif; ?>
                <span class="span-1"><b>部署时间</b></span>
				<span class="span-1"><b>启用时间</b></span>
                <span class="span-1"><b>图片预览</b></span>
            </li>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
					<span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
					<span class="span-1" title="#"><?php echo ($vo["device_no"]); ?></span>
					<span class="span-1" title="#"><?php echo ($vo["MAC"]); ?></span>
					<span class="span-1" title="#"><?php echo ($vo["device_type"]); ?></span>
					<span class="span-2" title="#"><?php echo ($vo["place_name"]); ?></span>
					<span class="span-1" title="#"><?php echo ($vo["address"]); ?></span>
					<?php if($isDeleteResult != 1): ?><span class="span-1" title="#"><?php echo ($vo["status"]); ?></span><?php endif; ?>
					<span class="span-1" title="#"><?php echo ($vo["deploy_time"]); ?></span>
					<span class="span-1" title="#"><?php echo ($vo["begin_time"]); ?></span>
					<span class="span-1" title="#"><img src="__PUBLIC__/image/img.png" alt=""/></span>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
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
                <span class="span-1" title="#"><img src="__PUBLIC__/image/img.png" alt=""/></span>
            </li>
        </ul>
		<!--
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
                <span class="span-1" title="#"><img src="__PUBLIC__/image/img.png" alt=""/></span>
            </li>
        </ul>
		-->

    </div>
</div>

<div class="role-table over-h-y">
    <div class="hd">
        <ul class="channel-tab">
            <li class="on">操作日志</li>
            <!--<li>删除日志</li>-->
        </ul>
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
        <!--<ul class="role-table-list role-table-list2">
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
        </ul>-->
    </div>
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
			<a href="." class="closeDOMWindow">
				<button type="button" class="alert-btn2">关闭</button>
			</a>
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
                <input type="date" name="" id="bs-date" class="input-org-info" style="margin-top: 0;"/>
            </p>

            <p>
                <label for="sq-date">启用日期</label>
                <input type="date" name="" id="sq-date" class="input-org-info" style="margin-top: 0;"/>
            </p>

            <p>
                <label for="sq-date">设置开机时间</label>
                <input type="date" name="" id="sq-date" class="input-org-info" style="margin-top: 0;"/>
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
<script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script>
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

	$(document).ready(function () {
		var state = "<?php echo ($isDeleteResult); ?>";
		if(1 == state){
			$("#device_select_result_ul").append("<li onclick='device_use_select();'>启用</li><li class='on' onclick='device_remove_select();'>撤销</li>");
		}else{
			$("#device_select_result_ul").append("<li class='on' onclick='device_use_select();'>启用</li><li onclick='device_remove_select();'>撤销</li>");
		}
	});

	function device_use_select(){
		$("#select_del_flag_txt").val(0);
		deviceSelect.submit();
	}

	function device_remove_select(){
		$("#select_del_flag_txt").val(1);
		deviceSelect.submit();
	}
</script>
<script type="text/javascript">jQuery(".role-table").slide({trigger: "click"});</script>
</body>
</html>