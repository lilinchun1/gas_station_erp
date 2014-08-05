<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>安装量日报</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/script_city.js"></script>
    <style>
        #head,.head-wrap,#footer{
            min-width: 990px;
        }
        .role-control{
            width: 99.7%;}
    </style>
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

<div id="container" style="min-width: 990px">
    <div class="left">
        
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>运营分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('statistics/Index/index');?>"><a href="<?php echo U('statistics/Index/index');?>"><input type="button" value="安装量分析"></a></li>
            <li class="url_link" url="<?php echo U('statistics/Index/user_statistics');?>"><a href="<?php echo U('statistics/Index/user_statistics');?>"><input type="button" value="接入用户分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>用户分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('statistics/Index/user_behavior');?>"><a href="<?php echo U('statistics/Index/user_behavior');?>"><input type="button" value="用户行为分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>App分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('statistics/Index/app_installed');?>"><a href="<?php echo U('statistics/Index/app_installed');?>"><input type="button" value="App安装量分析"></a></li>
            <li class="url_link" url="<?php echo U('statistics/Index/app_analysis');?>"><a href="<?php echo U('statistics/Index/app_analysis');?>"><input type="button" value="App分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>报表数据<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('statistics/Index/installed_daily');?>"><a href="<?php echo U('statistics/Index/installed_daily');?>"><input type="button" value="安装量日报"></a></li>
        </ul>
    </li>
</ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire channel-index-btns">
                        <form id="formid" name="channelSelect" method="get" action="">
                            <p>
                                <label for="channel-class1" class="">区域</label>
				                <span id="select_showcity"></span>
				                <script type="text/javascript">
				                    showprovince("select_province", "select_city", "<?php echo ($_GET['select_province']); ?>", "select_showcity");
				                    showcity("select_city", "<?php echo ($_GET['select_city']); ?>", "select_province", "select_showcity");
				                </script>

                                <label for="day">查询日期</label>
                                <input type="text" name="contract_end_time_1" id="contract_end_time_1" class="input-org-info"
                                       value="<?php echo ($_GET['contract_end_time_1']); ?>" onClick="WdatePicker()"/>
                                &nbsp;至&nbsp;
                                <input type="text" name="contract_end_time_2" id="contract_end_time_2" class="input-org-info"
                                       value="<?php echo ($_GET['contract_end_time_2']); ?>" onClick="WdatePicker()"/>
                                <input type="text" name="select_del_flag_txt" id="select_del_flag_txt" value="0" style="display:none;"/>
                                <input type="button" id="do_search_bt" class="role-control-btn" value="查询" />
                            </p>
                        </form>
                    </div>

                </div>
                <div class="role-table station-chart">
                    <div class="list-wrap-statistics">
                        <div class="role-table">
                            <div class="data-log">
                                <h3>安装量日报表<input id="all_export_execl_bt" type="button" class="role-control-btn" value="导出" /></h3>

                            </div>
                            <ul class="statistics-list">
                            <li>
                                    <span class='span-1'><b>日期</b></span>
                                    <span class='span-1'><b>安装总量</b></span>
                                    <span class='span-1'><b>IOS安装量</b></span>
                                    <span class='span-1'><b>Android安装量</b></span>
                                    <span class='span-1'><b>已统计加油站数量</b></span>
                                    <span class='span-1'><b>未统计加油站数量</b></span>
                                    <span class='span-1'><b>异常加油站数量</b></span>
                                </li>
	                             <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="list_sel">
					                    <span class="span-1" title="<?php echo ($vo["reg_date"]); ?>"><?php echo (date('Y-m-d',$vo["reg_date"])); ?> </span>
					                    <span class="span-1" title="<?php echo ($vo["install_num"]); ?>"><?php echo ($vo["install_num"]); ?></span>
					                    <span class="span-1" title="<?php echo ($vo["ios_num"]); ?>"><?php echo ($vo["ios_num"]); ?></span>
					                    <span class="span-1" title="<?php echo ($vo["android_num"]); ?>"><?php echo ($vo["android_num"]); ?></span>
					                    <span class="span-1" title="<?php echo ($vo["succ_num"]); ?>" onclick="succ_num_click();"><?php echo ($vo["succ_num"]); ?></span>
					                    <span class="span-1" title="<?php echo ($vo["fail_num"]); ?>"><?php echo ($vo["fail_num"]); ?></span>
					                    <span class="span-1" title="<?php echo ($vo["unfind_num"]); ?>"><?php echo ($vo["unfind_num"]); ?></span>
					                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            <div class="resultpage"><?php echo ($page); ?></div>
                        </div>
                    </div>
                </div>

                <div class="bk3">

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
<div class="alert-table1">
    <div class="data-log">
        <h3>未统计加油站安装量明细<input type="submit" class="role-control-btn fr" value="导出" /><input type="submit" class="role-control-btn fr" value="关闭" /></h3>
    </div>
    <ul class="statistics-list">
        <li>
            <span class='span-1'><b>网点地址</b></span>
            <span class='span-1'><b>点位信息</b></span>
            <span class='span-1'><b>MAC</b></span>
            <span class='span-1'><b>操作</b></span>
        </li>
        <li>
            <span class='span-1'>11111111</span>
            <span class='span-1'>22222222</span>
            <span class='span-1'>33333333</span>
            <span class='span-1'><input type="submit" class="role-control-btn" value="已统计" /></span>
        </li>

    </ul>
</div>
<div id="succ_num_win" style="display:none">
	<div class="alert-table1" style="background-color:#ffffff;width:100%">
		<div class="data-log">
			<h3>已统计加油站<input type="submit" class="role-control-btn fr" value="导出" /><input type="submit" class="role-control-btn fr" value="关闭" /></h3>
		</div>
		<ul class="statistics-list">
			<li>
				<span class='span-1'><b>网点地址</b></span>
				<span class='span-1'><b>点位信息</b></span>
				<span class='span-1'><b>MAC</b></span>
				<span class='span-1'><b>安装总量</b></span>
				<span class='span-1'><b>IOS安装量</b></span>
				<span class='span-1'><b>Abdrid安装量</b></span>
			</li>
			<li>
				<span class='span-1'>11111111</span>
				<span class='span-1'>22222222</span>
				<span class='span-1'>33333333</span>
				<span class='span-1'>44444444</span>
				<span class='span-1'>55555555</span>
				<span class='span-1'>66666666</span>
			</li>

		</ul>
	</div>
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<script language="javascript">
	$("#all_export_execl_bt").click(function (){
		var url = "<?php echo U('statistics/export/all_export');?>";
		$("#formid").attr("action",url);
		$("#formid").submit();
	});
	
	$("#do_search_bt").click(function (){
		var url = "<?php echo U('statistics/Index/installed_daily_doseach');?>";
		$("#formid").attr("action",url);
		$("#formid").submit();
	});
	function succ_num_click(){
		$.openDOMWindow({
			loader:1,
			loaderHeight:16,
			loaderWidth:17,
			windowSourceID:'#succ_num_win'
		});
		return false;
	}
</script>


</body>
</html>