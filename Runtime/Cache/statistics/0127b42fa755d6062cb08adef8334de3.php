<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>渠道信息</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
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
                                <label for="channel-class1" class="">渠道类型</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select-min">
                                    <option value="">全部</option>
                                </select>
                                <select name="channel_second_type_sel" id="channel_second_type_sel" class="channel-select-min">
                                    <option value="">全部</option>
                                </select>
                                <label for="channel-org-name" class="">渠道名称</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                                <label for="channel-org-name" class="">网点名称</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                            </p>
                            <p>
                                <label for="channel-org-name" class="">加油站编号</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                                <input type="radio" name="period" id="month"/>
                                <label for="month">按月统计</label>
                                <input type="radio" name="period" id="week"/>
                                <label for="week">按周统计</label>
                                <input type="radio" name="period" id="day"/>
                                <label for="day">按天统计</label>
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
                    <div class="hd">
                        <ul class="channel-tab">
                            <li>安装量分析</li>
                            <li>平均安装量分析</li>
                        </ul>
                    </div>
                    <div class="bd">
                        <div class="div-tab-chart">
                            <div class="tongji-tu">
                                <div id="container_table" style="min-width: 400px; height: 350px; margin: 0 auto"></div>
                            </div>
                            <div class="list-wrap-statistics">
                                <div class="bingtu">
                                    <div class="bingtu-tt">
                                        安装量分析
                                    </div>
									<div id="dabing_container" style="min-width:200px;height: 325px"></div>
                                </div>
                                <div class="role-table w66p">
                                    <div class="data-log">
                                        <h3>安装量明细<input type="submit" class="role-control-btn" value="导出" /></h3>

                                    </div>
                                    <ul class="statistics-list">
                                        <li>
                                            <span class='span-1'><b>日期</b></span>
                                            <span class='span-1'><b>安装总量</b></span>
                                            <span class='span-1'><b>ios安装量</b></span>
                                            <span class='span-1'><b>Android安装量</b></span>
                                            <span class='span-1'><b>游戏</b></span>
                                            <span class='span-1'><b>应用</b></span>
                                            <span class='span-1'><b>图书</b></span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li><li>
                                        <span class='span-1'>11111111</span>
                                        <span class='span-1'>22222222</span>
                                        <span class='span-1'>33333333</span>
                                        <span class='span-1'>44444444</span>
                                        <span class='span-1'>55555555</span>
                                        <span class='span-1'>66666666</span>
                                        <span class='span-1'>77777777</span>
                                    </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                            <span class='span-1'>55555555</span>
                                            <span class='span-1'>66666666</span>
                                            <span class='span-1'>77777777</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="div-tab-chart">
                            <div class="tongji-tu" id="avg_div">
								<div id="avg_container" style="min-width:400px; height: 400px; margin: 0 auto; "></div>
                            </div>
                            <div class="list-wrap-statistics">
                                <div class="bingtu w49p" style="border: 0 none;">
                                    <div class="bingtu-tt" style="border-bottom: 0 none;background: #ffffff;">
                                        <input type="submit" class="role-control-btn2 active" value="top10 &uarr;" />
                                        <input type="submit" class="role-control-btn2" value="top10 &darr;" />
                                    </div>
									<div id="top_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto; border: 1px solid #dadada;"></div>
                                </div>
                                <div class="role-table w66p w50p">
                                    <div class="data-log">
                                        <h3>平均安装量<input type="submit" class="role-control-btn" value="导出" /></h3>

                                    </div>
                                    <ul class="statistics-list">
                                        <li>
                                            <span class='span-1'><b>日期</b></span>
                                            <span class='span-1'><b>安装总量</b></span>
                                            <span class='span-1'><b>加油站数量</b></span>
                                            <span class='span-1'><b>1台加油站1天平均安装量</b></span>
                                        </li>
                                        <li>
                                            <span class='span-1'>11111111</span>
                                            <span class='span-1'>22222222</span>
                                            <span class='span-1'>33333333</span>
                                            <span class='span-1'>44444444</span>
                                        </li>

                                    </ul>
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

<!--<script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>-->
<!--<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>-->
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
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript">
$(function () {
	
        $('#container_table').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: '安装量分析'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: ['1月份', '2月份', '3月份', '4月份', '5月份', '6月份',
                    '7月份', '8月份', '9月份', '10月份', '11月份', '12月份']
            }],
			lang: {
				printChart:"打印图表",
				downloadJPEG:"下载JPEG格式图片",
				downloadPDF:"下载PDF格式文件",
				downloadPNG:"下载PNG格式图片",
				downloadSVG:"下载SVG格式文件"
			},
            yAxis: [{ // Secondary yAxis
					title: {
						text: '',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					labels: {
						format: '{value}',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
				},
				{ // Primary yAxis
					labels: {
						format: '{value}%',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: '',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
				opposite: true
            }],
            tooltip: {
                shared: true
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },

            series: [{
                name: '安装总量',
                type: 'column',
                yAxis: 0,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                tooltip: {
                    valueSuffix: ''
                }
				
    
            },{
			    name: 'ios安装量',
                type: 'column',
                yAxis: 0,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                tooltip: {
                    valueSuffix: ''
                },
				visible: false//默认隐藏
            },
			{
			    name: 'Android安装量',
                type: 'column',
                yAxis: 0,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                tooltip: {
                    valueSuffix: ''
                },
				visible: false//默认隐藏
            },{
                name: '成功安装率',
                type: 'spline',
				yAxis: 1,
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                tooltip: {
                    valueSuffix: '%'
                }
            },
			 {
                name: 'IOS安装率',
                type: 'spline',
				yAxis: 1,
                data: [9.6, 10.9, 19.5, 24.5, 38.2, 11.5, 15.2, 16.5, 13.3, 28.3, 33.9, 29.6],
                tooltip: {
                    valueSuffix: '%'
                },
				visible: false//默认隐藏
            },
			 {
                name: 'Android安装率',
                type: 'spline',
				yAxis: 1,
                data: [17.0, 26.9, 39.5, 44.5, 28.2, 11.5, 15.2, 26.5, 33.3, 48.3, 53.9, 19.6],
                tooltip: {
                    valueSuffix: '%'
                },
				visible: false//默认隐藏
            }
			]
        });

//大饼图
	$('#dabing_container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45,
                beta: 0
            }
        },
		colors:[
			'#77a1e5',//第一个颜色
			'#f15c80',//第二个颜色
			'#a6c96a',//第三个颜色
			'#1aadce', //。。。。
			   '#492970',
			   '#f28f43', 
			   'blue', 
			   '#c42525', 
			   '#a6c96a'
		 ],
		lang: {
			printChart:"打印图表",
			downloadJPEG:"下载JPEG格式图片",
			downloadPDF:"下载PDF格式文件",
			downloadPNG:"下载PNG格式图片",
			downloadSVG:"下载SVG格式文件"
		},
        title: {
            text: '安装量类型分析'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '安装率',
            data: [
                ['游戏',   45.0],
                ['图书',   26.8],
                ['应用',    8.5]
            ]
        }]
    });
	//平均安装量
	$('#avg_container').highcharts({
		chart: {
            type: 'area'
        },
		xAxis: [{
			categories: ['1月份', '2月份', '3月份', '4月份', '5月份', '6月份',
			'7月份', '8月份', '9月份', '10月份', '11月份', '12月份']
        }],
		yAxis: {
			min: 0,
			title: {
				text: '平均安装量'
			},
			labels: {
				format: '{value}',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			}
        },
		lang: {
			printChart:"打印图表",
			downloadJPEG:"下载JPEG格式图片",
			downloadPDF:"下载PDF格式文件",
			downloadPNG:"下载PNG格式图片",
			downloadSVG:"下载SVG格式文件"
		},
		colors:[
			'#77a1e5',//第一个颜色
			'#f15c80',//第二个颜色
			'#a6c96a',//第三个颜色
			'#1aadce', //。。。。
			   '#492970',
			   '#f28f43', 
			   'blue', 
			   '#c42525', 
			   '#a6c96a'
		 ],
        title: {
            text: '平均安装量分析'
        },

        series: [{
            type: 'area',
            name: '平均总安装量',
            data: [17.0, 26.9, 39.5, 44.5, 28.2, 11.5, 15.2, 26.5, 33.3, 48.3, 53.9, 19.6],
			tooltip: {
                    valueSuffix: ''
            }
        }]
    });
	//top10
    $('#top_container').highcharts({
		chart: {
			type: 'bar'
		},
		title: {
			text: '平均安装量排名'
		},
		lang: {
			printChart:"打印图表",
			downloadJPEG:"下载JPEG格式图片",
			downloadPDF:"下载PDF格式文件",
			downloadPNG:"下载PNG格式图片",
			downloadSVG:"下载SVG格式文件"
		},
		xAxis: {
			categories: ['大连', '北京', '鞍山', '长春', '哈尔滨','济南','天津','重庆','桂林','宁夏']
		},
		yAxis: {
			title: {
				text: ''
			},
			labels: {
				format: '{value}',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			}
		},
		legend: {
			reversed: true
		},
		labels: {
			format: '{value}',
			style: {
				color: Highcharts.getOptions().colors[0]
			}
		},
		plotOptions: {
			series: {
				stacking: 'normal'
			}
		},
			series: [{
			name: '平均安装量',
			data: [50, 40, 35, 30, 25,20,18,15,10,5],
			tooltip: {
               valueSuffix: ''
            }
		}]
	});
	jQuery(".role-table").slide({trigger:"click"});
 });
</script>


<script src="__PUBLIC__/js/table/highcharts.js"></script>
<script src="__PUBLIC__/js/table/modules/exporting.js"></script>
<!--<script src="__PUBLIC__/js/table/highcharts-3d.js"></script>-->
<!--3D效果不能做自适应效果!-->


</body>
</html>