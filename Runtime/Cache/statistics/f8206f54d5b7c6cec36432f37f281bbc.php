<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>渠道信息</title>
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
            <li>按用户量分析</li>
            <li>按用户类型分析</li>
        </ul>
    </div>
    <div class="bd">
        <div class="div-tab-chart">
            <div class="tongji-tu">
                <div id="container_table" style="min-width: 400px; height: 350px; margin: 0 auto"></div>
            </div>
            <div class="list-wrap-statistics">
                <!--<div class="bingtu">
                    <div class="bingtu-tt">
                        安装量分析
                    </div>
                    <div id="dabing_container" style="min-width:200px;height: 325px"></div>
                </div>-->
                <div class="role-table">
                    <div class="data-log">
                        <h3 class="biao-tt">用户接入量明细<input type="submit" class="role-control-btn fr-btn" value="导出" /></h3>

                    </div>
                    <ul class="statistics-list">
                        <li>
                            <span class='span-1'><b>日期</b></span>
                            <span class='span-1'><b>使用人数</b></span>
                            <span class='span-1'><b>下载应用人数</b></span>
                            <span class='span-1'><b>用户转化率</b></span>
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
        <div class="div-tab-chart">

            <div class="list-wrap-statistics">
				<div class="tongji-tu" id="avg_div">
					<div id="type_container" style="min-width:400px; height: 400px; margin: 0 auto; "></div>
                </div>
                <div class="role-table">
                    <div class="data-log">
                        <h3 class="biao-tt">平均安装量<input type="submit" class="role-control-btn fr-btn" value="导出" /></h3>

                    </div>
                    <ul class="statistics-list">
                        <li>
                            <span class='span-1'><b>日期</b></span>
                            <span class='span-1'><b>ios使用人数</b></span>
                            <span class='span-1'><b>ios下载应用人数</b></span>
                            <span class='span-1'><b>ios用户转化率</b></span>
                            <span class='span-1'><b>Android使用人数</b></span>
                            <span class='span-1'><b>Android下载应用人数</b></span>
                            <span class='span-1'><b>android用户转化率</b></span>
                        </li>
                        <li>
                            <span class='span-1'>11111111</span>
                            <span class='span-1'>22222222</span>
                            <span class='span-1'>33333333</span>
                            <span class='span-1'>44444444</span>
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

<!--<script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>-->
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
            text: '用户量分析'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: ['1月份', '2月份', '3月份', '4月份', '5月份', '6月份',
                '7月份', '8月份', '9月份', '10月份', '11月份', '12月份']
        }],
		colors:[
            '#77a1e5',//第一个颜色
            'red',//第二个颜色
            '#a6c96a',//第三个颜色
            '#1aadce', //。。。。
            '#492970',
            '#f28f43',
            'blue',
            '#c42525',
            '#a6c96a'
        ],
		yAxis: [
				{ // Primary yAxis
					labels: {
						format: '{value}%',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					title: {
						text: '',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					opposite: true
				},
				{ // Secondary yAxis
					title: {
						text: '',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					labels: {
						format: '{value}',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					}
				}
				],

			tooltip: { 
				formatter: function() { 
					if(this.point.stackTotal!=undefined){
						return '<b>'+ this.x +'</b><br>'+ this.series.name +': '+ this.y +'<br>'+ '接入用户总量: '+ this.point.stackTotal; 
					}else{
						return '<b>'+ this.x +'</b><br>'+ this.series.name +': '+ this.y +'<br>'; 
					}
				} 
			}, 
			plotOptions: { 
					column: {
						stacking: 'normal',
						/*dataLabels: {
							enabled: true, color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white' 
						} */
					} 
			},


        series: [{
				name:'未安装用户数量',
                type: 'column',
                data: [3, 4, 4, 2, 5,3,1,4,1,6,7,4],
				yAxis: 1
            },{
                name: '安装用户数量',
				type: 'column',
                data: [5, 3, 4, 7, 2 ,3,1,4,1,4,1,2],
				yAxis: 1
            },
			{
				name: '用户转化率',
				type: 'spline',
				data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
				tooltip: {
					valueSuffix: '%'
				},
				yAxis: 0
			}]
    });

    //用户类型分析
    $('#type_container').highcharts({
           chart: {
                zoomType: 'xy'
            },
            title: {
                text: '用户类型分析'
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
			colors:[
				'#77a1e5',//第一个颜色
				'red',//第二个颜色
				'#a6c96a',//第三个颜色
				'#1aadce', //。。。。
				   '#492970',
				   '#f28f43', 
				   'blue', 
				   '#c42525', 
				   '#a6c96a'
			],
            yAxis: [
				{ // Primary yAxis
					labels: {
						format: '{value}%',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					title: {
						text: '',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					opposite: true
				},
				{ // Secondary yAxis
					title: {
						text: '',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					labels: {
						format: '{value}',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					}
					
				}
				],
			tooltip: { 
				formatter: function() { 
					if(this.point.stackTotal!=undefined){
						if(this.series.name=='安装用户数量:'||this.series.name=='未安装用户数量:'){
							return '<b>'+ this.x +'IOS</b><br>'+ this.series.name +''+ this.y +'<br>'+ '接入用户总量: '+ this.point.stackTotal; 
						}
						if(this.series.name=='安装用户数量'||this.series.name=='未安装用户数量'){
							return '<b>'+ this.x +'Android</b><br>'+ this.series.name +': '+ this.y +'<br>'+ '接入用户总量: '+ this.point.stackTotal; 
						}
					}else{
						return '<b>'+ this.x +'</b><br>'+ this.series.name +': '+ this.y +'<br>'; 
					}
				} 
			}, 
			plotOptions: { 
					column: {
						stacking: 'normal',
						/*dataLabels: {
							enabled: true, color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white' 
						} */
					} 
			},

            series: [{
                name: '未安装用户数量:',
                type: 'column',
                yAxis: 1,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
				stack: 'ios'
    
            },
			{
                name: '安装用户数量:',
				type: 'column',
				yAxis: 1,
                data: [115, 113, 114, 117, 121 ,113,111,141,111,141,111,121],
				stack: 'ios'
            },
			{
				name:'Android未安装用户数量',
                type: 'column',
				yAxis: 1,
                data: [33, 44, 14, 52, 75,73,61,64,61,66,74,44],
				stack: 'Android'
            },{
			    name: 'Android安装用户数量',
                type: 'column',
                yAxis: 1,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
				stack: 'Android'
				//visible: false//默认隐藏
            },


			{
                name: 'ios用户转化率',
                type: 'spline',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                tooltip: {
                    valueSuffix: '%'
                },
				yAxis: 0
            },
			 {
                name: 'Android用户转化率',
                type: 'spline',
                data: [9.6, 10.9, 19.5, 24.5, 38.2, 11.5, 15.2, 16.5, 13.3, 28.3, 33.9, 29.6],
                tooltip: {
                    valueSuffix: '%'
                },
				yAxis: 0
				//visible: false//默认隐藏
            }
			]
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