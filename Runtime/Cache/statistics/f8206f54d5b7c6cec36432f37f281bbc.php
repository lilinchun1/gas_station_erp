<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>app排名</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
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

<div id="container" style="min-width: 990px">
    <div class="left">
        
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>运营分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('statistics/Index/index');?>'"><a href="<?php echo U('statistics/Index/index');?>"><input type="button" value="安装量分析"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/user_statistics');?>'"><a href="<?php echo U('statistics/Index/user_statistics');?>"><input type="button" value="app排名"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/app_installed');?>'"><a href="<?php echo U('statistics/Index/app_installed');?>"><input type="button" value="App安装量"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_analysis');?>'"><a href="<?php echo U('statistics/Index/ad_analysis');?>"><input type="button" value="广告分析"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_play');?>'"><a href="<?php echo U('statistics/Index/ad_play');?>"><input type="button" value="广告播放"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_maintain');?>'"><a href="<?php echo U('statistics/Index/ad_maintain');?>"><input type="button" value="广告维护"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>用户分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('statistics/Index/user_behavior');?>'"><a href="<?php echo U('statistics/Index/user_behavior');?>"><input type="button" value="用户行为分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>App分析<i class="j-show-list">-</i></a>
        <ul>

            <li class="url_link" url="'<?php echo U('statistics/Index/app_analysis');?>'"><a href="<?php echo U('statistics/Index/app_analysis');?>"><input type="button" value="App分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>报表数据<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('statistics/Index/installed_daily');?>'"><a href="<?php echo U('statistics/Index/installed_daily');?>"><input type="button" value="安装量日报"></a></li>
        </ul>
    </li>
</ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire channel-index-btns">
                        <form name="channelSelect" method="get" action="">
                            <p>
                                <label for="channel-class1" class="">组织机构</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select">
                                    <option value="">总公司</option>
                                </select>
                                <label for="channel-class1" class="">区域</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select-min">
                                    <option value="">省份</option>
                                </select>
                                <select name="channel_second_type_sel" id="channel_second_type_sel" class="channel-select-min">
                                    <option value="">城市</option>
                                </select>
                                <label for="channel-class1" class="">APP类型</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select">
                                    <option value="">全部</option>
                                </select>
                                <label for="channel-class1" class="">结算类型</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select">
                                    <option value="">全部</option>
                                </select>
                            </p>
                            <p>
                                <label for="channel-org-name" class="">app名称</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                                <label for="channel-org-name" class="">app ID</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>

                                <label for="channel-org-name" class="">刊例号</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                                <label for="contract_end_time_1">查询日期</label>
                                <input type="text" name="contract_end_time_1" id="contract_end_time_1" class="input-org-info"
                                       value="<?php echo ($_GET['contract_end_time_1']); ?>" onClick="WdatePicker()"/>
                                &nbsp;至&nbsp;
                                <input type="text" name="contract_end_time_2" id="contract_end_time_2" class="input-org-info"
                                       value="<?php echo ($_GET['contract_end_time_2']); ?>" onClick="WdatePicker()"/>
                                <input type="text" name="select_del_flag_txt" id="select_del_flag_txt" value="0" style="display:none;"/>

                                <input type="submit" class="role-control-btn" value="查询" />
                            </p>
                        </form>
                    </div>

                </div>
                <div class="role-table station-chart">
                    <div class="tab-wrap tab-wrap-100">
                        <div class="hd">
                            <ul class="channel-tab">
                                <li>IOS安装明细</li>
                                <li>Android安装明细</li>
                                <input type="submit" class="role-control-btn fr" value="导出" />
                            </ul>
                        </div>
                        <div class="bd">
                            <div class="div-tab-chart">
                                <div class="list-wrap-statistics">
                                    <div class="role-table3">
                                        <ul class="statistics-list">
                                            <li>
                                                <span class='span-1'><b>app名称</b></span>
                                                <span class='span-1'><b>app类型</b></span>
                                                <span class='span-1'><b>结算类型</b></span>
                                                <span class='span-1'><b>安装总量</b></span>
                                                <span class='span-1'><b>成功安装量</b></span>
                                                <span class='span-1'><b>普通安装量</b></span>
                                                <span class='span-1'><b>强充安装量</b></span>
                                                <span class='span-1'><b>快充安装量</b></span>
                                            </li>
                                            <li>
                                                <span class='span-1'>11111111</span>
                                                <span class='span-1'>22222222</span>
                                                <span class='span-1'>33333333</span>
                                                <span class='span-1'>44444444</span>
                                                <span class='span-1'>55555555</span>
                                                <span class='span-1'>66666666</span>
                                                <span class='span-1'>77777777</span>
                                                <span class='span-1'>88888888</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="div-tab-chart">
                                <div class="list-wrap-statistics">
                                    <div class="role-table3">
                                        <ul class="statistics-list">
                                            <li>
                                                <span class='span-1'><b>app名称</b></span>
                                                <span class='span-1'><b>app类型</b></span>
                                                <span class='span-1'><b>结算类型</b></span>
                                                <span class='span-1'><b>安装总量</b></span>
                                                <span class='span-1'><b>成功安装量</b></span>
                                                <span class='span-1'><b>普通安装量</b></span>
                                                <span class='span-1'><b>强充安装量</b></span>
                                                <span class='span-1'><b>快充安装量</b></span>
                                            </li>
                                            <li>
                                                <span class='span-1'>11111111</span>
                                                <span class='span-1'>22222222</span>
                                                <span class='span-1'>33333333</span>
                                                <span class='span-1'>44444444</span>
                                                <span class='span-1'>55555555</span>
                                                <span class='span-1'>66666666</span>
                                                <span class='span-1'>77777777</span>
                                                <span class='span-1'>88888888</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bk3">

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>

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
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>

<script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>

<script type="text/javascript">
    $(function () {

        jQuery(".tab-wrap").slide({trigger:"click"});
    });
</script>


<script src="__PUBLIC__/js/table/highcharts.js"></script>
<script src="__PUBLIC__/js/table/modules/exporting.js"></script>
<!--<script src="__PUBLIC__/js/table/highcharts-3d.js"></script>-->
<!--3D效果不能做自适应效果!-->


</body>
</html>