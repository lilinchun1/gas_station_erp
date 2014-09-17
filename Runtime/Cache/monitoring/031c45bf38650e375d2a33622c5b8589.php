<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>监控平台</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/script_city.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
    <style>
        #head,.head-wrap,#footer,#container{
            min-width: 1300px;
        }
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

<div id="container">
    <div class="left">
        
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>远程监控<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('monitoring/Index/station');?>'"><a href="<?php echo U('monitoring/Index/station');?>"><input  type="button"  value="监控平台" ></a></li>
            <!--<li class="url_link" url="''"><a href=""><input type="button" class="" value="监控设置" ></a></li>-->
            <!--<li class="url_link" url="''"><a href=""><input type="button" class="" value="异常记录" ></a></li>-->
        </ul>
    </li>
</ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="station-con" id="j-tataion-tool">
                <div class="station-control">
                    <ul class="station-control-list">
                        <li>
                            <h4>系统监控</h4>
                            <span><img src="__PUBLIC__/image/6.png" alt=""/></span>
                            <dl class="station-zhuangtai">
                                <dt id="xitong_3"><b>合计</b><em id="sum"></em></dt>
                                <dt id="xitong_1"><b class="icon-checkmark-circle green-color"></b><em id="devRightNum"><?php echo ($devRightNum); ?></em></dt>
                                <dt id="xitong_0"><b class="icon-cancel-circle red-color"></b><em id="devBreakNum"><?php echo ($devBreakNum); ?></em></dt>
                                <dt id="xitong_2"><b class="icon-bulb yellow-color"></b><em id="devUnfindNum"><?php echo ($devUnfindNum); ?></em></dt>
                            </dl>
                        </li>
                        <li>
                            <h4>APP应用</h4>
                            <span><img src="__PUBLIC__/image/1.png" alt=""/></span>
                            <dl class="station-zhuangtai">
							<!--
                                <dt><b class="icon-checkmark-circle green-color"></b><em>0</em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em>0</em></dt>
							-->
                            </dl>
                        </li>
                        <li>
                            <h4>媒体广告</h4>
                            <span><img src="__PUBLIC__/image/4.png" alt=""/></span>
                            <dl class="station-zhuangtai">
							<!--
                                <dt><b class="icon-checkmark-circle green-color"></b><em>0</em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em>0</em></dt>
							-->
                            </dl>
                        </li>
                        <li>
                            <h4>远程操作</h4>
                            <span><img src="__PUBLIC__/image/5.png" alt=""/></span>
                            <!--<dl class="station-zhuangtai">
                                <dt><b class="icon-checkmark-circle green-color"></b><em>0</em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em>0</em></dt>
                            </dl>-->
                        </li>
                    </ul>
                    <div class="station-state-list-cx">
						<span id="hide">
							<label for="channelName">渠道名称</label>
							<input  type="text" name="channelName" id="channelName" class="station-info" value="<?php echo ($channelName); ?>"
							onfocus="blurry('channel_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
                            
							&nbsp;&nbsp;&nbsp;&nbsp;
							<label for="place_name">网点名称</label>
							<input  type="text" name="place_name" id="place_name" class="station-info" value="<?php echo ($place_name); ?>" 
							onfocus="blurry('place_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>

							&nbsp;&nbsp;&nbsp;&nbsp;
							<label for="place_name">加油站编号</label>
							<input  type="text" name="device_no" id="device_no" class="station-info" value="<?php echo ($device_no); ?>" 
							onfocus="blurry('device_no','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
                            
                            
							<button type="button" class="channel_select role-control-btn" id="channel_select">查询</button>
							<button type="button" class="role-control-btn" id="stationDele">清空</button>
                            <button type="button" class="station_export role-control-btn" id="station_export">导出</button>
							<!--
							<button type="button" class="role-control-btn">导出</button>
							-->
						</span>
                        <div class="mode-change">
                            <!--<a href="" class="active">监控台模式</a><a href="">列表模式</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="station-state-list"  id="j-station-sh1">
                <div class="station-state-tree1">
					<div class="zTreeDemoBackground left">
							<ul id="treeDemo" class="ztree"></ul>
					</div>
                </div>
                <ul class="station-state-list-con">
                    <?php if(is_array($showDevPageArr)): foreach($showDevPageArr as $key=>$devBreak): ?><li>
	                        <div class="station-state-info">
								<em><?php echo ($devBreak['province']); ?>  <?php echo ($devBreak['city']); ?> <?php echo ($devBreak['place_name']); ?> <?php echo ($devBreak['address']); ?> <?php echo ($devBreak['dev_mac']); ?> <?php echo ($devBreak['dev_no']); ?></em>
								<p style="margin-top:5px;">
									<?php if($devBreak['on_line'] != 0): ?><em>报警时间 ： <?php echo ($devBreak['wrong_begin_time']); ?></em><?php endif; ?>
									<?php if($devBreak['on_line'] != 0): ?><em>报警时长  ： <?php echo ($devBreak['continueTime']); ?></em><?php endif; ?>
								</p>
	                        </div>
	                        <div class="station-state-dl">
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em>在线状态</em>
	                                    <?php if($devBreak['on_line'] == 0): ?><span class="icon-checkmark green-color"></span>
										<?php else: ?>
											<span class="icon-close red-color"></span><?php endif; ?>
	                                </span>
	                                <span class="row-lt-l" style="color: #5095fc">
	                                	<?php if($devBreak['on_line'] != 0): echo ($devBreak['start_time']); endif; ?>
                                        
	                                    <!--<em>正常开机</em>
	                                    <?php if($devBreak['start_time'] == 0): ?><span class="icon-checkmark green-color"></span>
										<?php else: ?>
											<span class="icon-close red-color"></span><?php endif; ?>-->
	                                </span>
	                                <span class="row-lt-l" style="color: #5095fc">
                                        <!--<?php if($devBreak['on_line'] != 0): echo ($devBreak['shutdown_time']); endif; ?>
	                                    <em>正常关机</em>
	                                    <?php if($devBreak['shutdown_time'] == 0): ?><span class="icon-checkmark green-color"></span>
										<?php else: ?>
											<span class="icon-close red-color"></span><?php endif; ?>-->
	                                </span>
	                            </div>
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">APP刊例</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">上屏程序版本</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">下屏程序版本</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                            </div>
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">中屏状态</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">上屏状态</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">广告刊例</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                            </div>
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">网络流量预警</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">开关机时间预警</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                            </div>
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">CPU预警</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em class="ccc-color">硬盘预警</em>
	                                    <span class="icon-spam yellow-color"></span>
	                                </span>
	                            </div>
	                        </div>
	                    </li><?php endforeach; endif; ?>
                </ul>
            </div>
			<div class="resultpage">
				<a id="up_page" style="cursor:pointer">«</a>
				<span>
				<span class="up" style="cursor:pointer"></span>
				<span class="current"><?php echo ($pageNum); ?></span>
				<span class="down" style="cursor:pointer"></span>
				</span>
				<a id="down_page" style="cursor:pointer">»</a>
				<span id="count" style="border:0" class="pages-number">共<span id="page_num" style="border:0"><?php echo ($countPageNum); ?></span>页</span>
				<span class="pages-number">
				到第
				<select id="select_page"></select>
				页
				</span>
				
			</div>
           
            <div class="station-state-list table-state" id="j-station-sh2">
                <ul class="station-list2-wz">
                    <li class="first-line">
                        <span>加油站所属网点</span>
                        <span>MAC地址</span>
                        <span>报警时间</span>
                        <span>报警时长</span>
                        <span>在线状态</span>
                        <span>正常开机</span>
                        <span>正常关机</span>
                    </li>
                    <li>
                        <span title="#">11111111111111111111Lorem ipsum dolor sit amet.</span>
                        <span title="#">Lorem ipsum dolor sit amet.</span>
                        <span title="#">Facere impedit qui tenetur voluptates!</span>
                        <span title="#">A dicta dolorem quo similique.</span>
                        <span title="#">Ipsam molestias nesciunt ratione sapiente.</span>
                        <span title="#">Maxime natus nulla pariatur tempore?</span>
                        <span title="#">Inventore officia optio perferendis quis.</span>
                        <span title="#">Laboriosam magnam necessitatibus similique ut.</span>
                    </li>
                    <li>
                        <span title="#">11111111111111111111Lorem ipsum dolor sit amet.</span>
                        <span title="#">Lorem ipsum dolor sit amet.</span>
                        <span title="#">Facere impedit qui tenetur voluptates!</span>
                        <span title="#">A dicta dolorem quo similique.</span>
                        <span title="#">Ipsam molestias nesciunt ratione sapiente.</span>
                        <span title="#">Maxime natus nulla pariatur tempore?</span>
                        <span title="#">Inventore officia optio perferendis quis.</span>
                        <span title="#">Laboriosam magnam necessitatibus similique ut.</span>
                    </li>
                    <li>
                        <span title="#">11111111111111111111Lorem ipsum dolor sit amet.</span>
                        <span title="#">Lorem ipsum dolor sit amet.</span>
                        <span title="#">Facere impedit qui tenetur voluptates!</span>
                        <span title="#">A dicta dolorem quo similique.</span>
                        <span title="#">Ipsam molestias nesciunt ratione sapiente.</span>
                        <span title="#">Maxime natus nulla pariatur tempore?</span>
                        <span title="#">Inventore officia optio perferendis quis.</span>
                        <span title="#">Laboriosam magnam necessitatibus similique ut.</span>
                    </li>
                </ul>
            </div>
             
        </div>
    </div>
    <input type="hidden" name="pageNum" class="pageNum" id="pageNum" value="<?php echo ($pageNum); ?>"/><!--页数-->
    <input type="hidden" name="areaId" class="areaId" id="areaId" value="<?php echo ($areaId); ?>"/><!--省市ID-->
	<input type="hidden" name="level" class="level" id="level" value="<?php echo ($level); ?>" /><!--等级-->
	<input type="hidden" name="showModel" class="showModel" id="showModel" value="<?php echo ($showModel); ?>" /><!--监控模式-->

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
<div id="station_win" style="display:none">
	<div class="alert-table1" style="background:#fff;width:100%;padding-bottom:20px">
        <div class="defult-tt">
            未监控加油站信息
        </div>
		<div class="role-inquire channel-index-btns">
				<p>
					<label for="yichang_channelName" class="">渠道名称</label>
					<input type="text" name="yachang_channelName" id="yichang_channelName" value="" class="input-org-info"
					onfocus="blurry('channel_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
					<label for="yichang_place_name" class="">网点名称</label>
					<input type="text" name="yichang_place_name" id="yichang_place_name" value="" class="input-org-info"
					onfocus="blurry('place_name','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
					<label for="yichang_address" class="">点位名称</label>
					<input type="text" name="yichang_address" id="yichang_address" value="" class="input-org-info"
					onfocus="blurry('device_address','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
					<label for="yichang_devMac" class="">MAC</label>
					<input type="text" name="yichang_devMac" id="yichang_devMac" value="" class="input-org-info"
					onfocus="blurry('device_mac','<?php echo U('channel/Channel/getAllLike');?>',this)"/>
					<br>
					<label for="yichang_devNo" class="">加油站编号</label>
					<input type="text" name="yichang_devNo" id="yichang_devNo" value="" class="input-org-info"
					onfocus="blurry('device_no','<?php echo U('channel/Channel/getAllLike');?>',this)"/>

					<label for="devNoBeginTime" class="">查询数据类型</label>
					<select class="input-org-info" id="devNoBeginTime" name="devNoBeginTime" value="" style="width:150px">
						<option value="1">未返回数据的机器</option>
						<option value="2">未设开机时间的机器</option>
					</select>
					<button type="button" class="yichang_select role-control-btn" id="yichang_select">查询</button>
                    <button type="button" class="yichang_export role-control-btn" id="yichang_export">导出</button>
                    <button type="button" class="role-control-btn" id="yichang_close">关闭</button>
                    <span id="showDevNum"></span>
				</p>

		</div>
		<div id="table">
		<ul class="statistics-list" style="border:0" id="yichang_list">
			<li>
				<span class='span-1'><b>省份</b></span>
				<span class='span-1'><b>城市</b></span>
				<span class='span-1'><b>渠道名称</b></span>
				<span class='span-1'><b>网点名称</b></span>
				<span class='span-1'><b>点位名称</b></span>
				<span class='span-1'><b>MAC</b></span>
				<span class='span-1'><b>编号</b></span>
			</li>
		</ul>
		</div>
	</div>
</div>
<!--树形结构类-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/jquery.bigautocomplete.css" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/blurrySelect.js"></script>
<script>
//===================================================树形结构js==========================
var curMenu = null, zTree_Menu = null;
var setting = {
    data: {
        key: {
            title: "t"
        },
        simpleData: {
            enable: true
        }
    },
    view: {
        fontCss: getFontCss
    },
	callback: {
		beforeClick: zTreeOnClick
	}
};
var handleUrl="<?php echo U('monitoring/Index/getProvinceCity');?>";
var zNodes=new Array();
var now=new Date().getTime();//加个时间戳表示每次是新的请求
var showModel=$("#showModel").val();
$.ajax({
    type: "get",
    url: handleUrl,
    async: false,
    dataType: "json",
	data:{"showModel":showModel},
    success: function(data){
        $.each(data,function(key,val){
            var kid=val['area_id'];
            var parent=val['pid'];
            var value=val['area_name'];
			var level=val['level'];
            zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':true ,'t':level};
        });
    },

    error: function(XMLHttpRequest, textStatus, errorThrown) {
        // alert("请求失败!");
    }
});

function focusKey(e) {
    if (key.hasClass("empty")) {
        key.removeClass("empty");
    }
}
function blurKey(e) {
    if (key.get(0).value === "") {
        key.addClass("empty");
    }
}
var lastValue = "", nodeList = [], fontCss = {};
function clickRadio(e) {
    lastValue = "";
    searchNode(e);
}
function searchNode(e) {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
    if (!$("#getNodesByFilter").attr("checked")) {
        var value = $.trim(key.get(0).value);
        var keyType = "";
        if ($("#name").attr("checked")) {
            keyType = "name";
        } else if ($("#level").attr("checked")) {
            keyType = "level";
            value = parseInt(value);
        } else if ($("#id").attr("checked")) {
            keyType = "id";
            value = parseInt(value);
        }
        if (key.hasClass("empty")) {
            value = "";
        }
        if (lastValue === value) return;
        lastValue = value;
        if (value === "") return;
        updateNodes(false);

        if ($("#getNodeByParam").attr("checked")) {
            var node = zTree.getNodeByParam(keyType, value);
            if (node === null) {
                nodeList = [];
            } else {
                nodeList = [node];
            }
        } else if ($("#getNodesByParam").attr("checked")) {
            nodeList = zTree.getNodesByParam(keyType, value);
        } else if ($("#getNodesByParamFuzzy").attr("checked")) {
            nodeList = zTree.getNodesByParamFuzzy(keyType, value);
        }
    } else {
        updateNodes(false);
        nodeList = zTree.getNodesByFilter(filter);
    }
    updateNodes(true);

}
function updateNodes(highlight) {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
    for( var i=0, l=nodeList.length; i<l; i++) {
        nodeList[i].highlight = highlight;
        zTree.updateNode(nodeList[i]);
    }
}
function getFontCss(treeId, treeNode) {
    return (!!treeNode.highlight) ? {color:"#A60000", "font-weight":"bold"} : {color:"#333", "font-weight":"normal"};
}
function filter(node) {
    return !node.isParent && node.isFirstNode;
}
function zTreeOnClick(event, treeId, treeNode) {
    //$("#level").val(treeId.level);
	var agent_id=treeId.id;//省市ID
	$('#areaId').val(agent_id);
	$('#pageNum').val(1);//页数初始化
	var page_Num=$('#pageNum').val();//页数
	var level=treeId.t;//等级
	var showModel=$("#showModel").val();//监控模式
	window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel;
};
var key;
var p=1;
function show_yichang(select_export){
	$(".select_li").remove();//初始化
	$(".resultpage").remove();//初始化
	var channelName=$("#yichang_channelName").val();//渠道
	var place_name=$("#yichang_place_name").val();//网点
	var address=$("#yichang_address").val();//点位
	var devMac=$("#yichang_devMac").val();//mac
	var devNo=$("#yichang_devNo").val();//编号
	var devNoBeginTime=$("#devNoBeginTime").val();
	var agent_id=$('#areaId').val();//省市ID
	var level=$("#level").val();//等级
	var showModel=2;//监控模式
	if(select_export==0){
		var handleUrl = "<?php echo U('monitoring/Index/station');?>";
	}else if(select_export==1){
		window.location.href="<?php echo U('monitoring/Index/monitorExport');?>"+"?showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name+"&address="+address+"&devMac="+devMac+"&devNo="+devNo+"&devNoBeginTime="+devNoBeginTime+"&agent_id="+agent_id+"&level="+level;
		return false;
	}
	$.ajax({
		type: "get",
		url: handleUrl,
		async: false,
		dataType: "json",
		data:{
		"channelName":channelName,
		"place_name":place_name,
		"address":address,
		"devMac":devMac,
		"devNo":devNo,
		"devNoBeginTime":devNoBeginTime,
		"areaId":agent_id,
		"level":level,
		"showModel":showModel,
		"pageNum":p
		},
		success: function(data){
			var showDevNum=data['showDevNum']//查询总数
			$("#showDevNum").html("查询共"+showDevNum+"条数据");
			var showDevPageArr=data['showDevPageArr'];
			$.each(showDevPageArr, function(i,item){
				$("#yichang_list").append("<li class='select_li'><span class='span-1'>"+item['province']+"</span><span class='span-1'>"+
				item['city']+"</span><span class='span-1'>"+
				item['channel_name']+"</span><span class='span-1'>"+
				item['place_name']+"</span><span class='span-1'>"+
				item['address']+"</span><span class='span-1'>"+
				item['dev_mac']+"</span><span class='span-1'>"+
				item['dev_no']+"</span></li>");
			});
			p = Number(data['pageNum']);//接收当前页
			var countPageNum = data['countPageNum'];//接收总页数
			$("#table").append("<div class='resultpage' style=''>"+"<a id='yichang_up_page' style='cursor:pointer'>«</a>"+"<span id='up_pages'></span>"+"<span class='current'>"+p+"</span>"+"<span id='down_pages'></span>"+"<a id='yichang_down_page' style='cursor:pointer'>»</a>"+"<span class='pages-number'>共"+countPageNum+"页</span>"+"<span>到第<select id='select_page_yichang'></select>页</span>"+"</div>");
			if(p=="1"){
				$("#yichang_up_page").hide();
			}
			if(p==countPageNum){
				$("#yichang_down_page").hide();
			}
			//前面的页码
			for (var i=p-3;i<=p-1 ; i++)
			{
				if(i<=1){
					break;
				}
				if(i>1){
					$("#up_pages").append("<a class='page_pp' value='"+i+"' style='cursor:pointer'>"+i+"</a>");
				}
			}
			//后面的页码
			for (var i=p+1;i<=p+3; i++)
			{
				if(i<=countPageNum){
					$("#down_pages").append("<a class='page_pp' value='"+i+"' style='cursor:pointer'>"+i+"</a>");
				}
			}
			//页码select
			for(var i=1;i<=countPageNum;i++){
				if(i==p){
					$("#select_page_yichang").append("<option value='"+i+"' selected='selected'>"+i+"</option>");
				}else{
					$("#select_page_yichang").append("<option value='"+i+"'>"+i+"</option>");
				}
			}
			$("#select_page_yichang").change(function(){
				p=$(this).val();//页数
				up_yichang();
			});
			$(".page_pp").click(function(){
				p=$(this).text();
				up_yichang();
			});
			$("#yichang_up_page").click(function(){
				p--;	
				up_yichang();
			});
			$("#yichang_down_page").click(function(){
				p++;	
				down_yichang();
			});
		},
	
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("请求失败!");
		}
	});
}
function up_yichang(){
	show_yichang(); 
}
function down_yichang(){
	show_yichang(); 
}

//===================================================树形结构js结束==========
    $(function () {
		//算合计
		var sum=parseInt($("#devRightNum").text())+parseInt($("#devBreakNum").text())+parseInt($("#devUnfindNum").text());
		$("#sum").append(sum);
		//系统监控框 默认样式
		var showModel_mode=$("#showModel").val();
		if(showModel_mode==0){
			$("#xitong_0").css("background-color","#effcff");
		}
		if(showModel_mode==1){
			$("#xitong_1").css("background-color","#effcff");
		}
		//===================================================树形结构js传递==========
		$.fn.zTree.init($("#treeDemo"), setting, zNodes);

		//console.log(curMenu);


		key = $("#key");
		key.bind("focus", focusKey)
				.bind("blur", blurKey)
				.bind("propertychange", searchNode)
				.bind("input", searchNode);
		$("#name").bind("change", clickRadio);
		$("#level").bind("change", clickRadio);
		$("#id").bind("change", clickRadio);
		$("#getNodeByParam").bind("change", clickRadio);
		$("#getNodesByParam").bind("change", clickRadio);
		$("#getNodesByParamFuzzy").bind("change", clickRadio);
		$("#getNodesByFilter").bind("change", clickRadio);
        $('.mode-change a:eq(0)').click(function () {
			$("#hide").show();
            $('#j-station-sh1').show();
            $('#j-station-sh2').hide();
            $(this).addClass('active');
            $('.mode-change a:eq(1)').removeClass();
            return false;
        });
        $('.mode-change a:eq(1)').click(function () {
			$("#hide").hide();
            $('#j-station-sh1').hide();
            $('#j-station-sh2').show();
            $(this).addClass('active');
            $('.mode-change a:eq(0)').removeClass();
            return false;
        });
        
        //循环刷新
        var iID=setTimeout(function(){location.reload();},1000*60*60);
        $("#down_page").click(function(){
			var page_Num=$('#pageNum').val();//页数
			var agent_id=$('#areaId').val();//省市ID
			var new_page_Num=Number(page_Num)+1;
			var level=$("#level").val();//等级
			var showModel=$("#showModel").val();//监控模式
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+new_page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name;
		});
		$("#up_page").click(function(){
			var page_Num=$('#pageNum').val();//页数
			var agent_id=$('#areaId').val();//省市ID
			var new_page_Num=page_Num-1;
			var level=$("#level").val();//等级
			var showModel=$("#showModel").val();//监控模式
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+new_page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name;
		});
		//点击系统监控显示数据success
		$("#xitong_1").click(function(){
			var page_Num=1;//页数
			var agent_id=$('#areaId').val();//省市ID
			var level=$("#level").val();//等级
			var showModel=1;//监控模式
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name;
		});
		//点击系统监控显示数据error
		$("#xitong_0").click(function(){
			var page_Num=1;//页数
			var agent_id=$('#areaId').val();//省市ID
			var level=$("#level").val();//等级
			var showModel=0;//监控模式
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name;
		});

		//点击系统监控显示数据异常弹出框
		$("#xitong_2").click(function(){
			//0为查询，1为导出
			$("#yichang_select,#yichang_export").click(function(){
				if($(this).hasClass('yichang_select')){
					show_yichang(0);
				}else{
					show_yichang(1);
				}
			});
			$("#yichang_close").click(function(){
				window.location.href = window.location.href;
			});
			$.openDOMWindow({
			    loader:1,
				loaderHeight:16,
				loaderWidth:17,
				width:900,
				windowSourceID:'#station_win'
			});
			return false;
		});
		$("#channel_select,#station_export").click(function(){
			var page_Num=1;//页数
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			var device_no=$("#device_no").val();//加油站编号
			var showModel=$("#showModel").val();//监控模式
			if($(this).hasClass('channel_select')){
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name+"&device_no="+device_no;
			}else{
			window.location.href="<?php echo U('monitoring/Index/monitorExport');?>"+"?pageNum="+page_Num+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name+"&device_no="+device_no;
			}
		});
		var count=Number($("#page_num").text());//获取总页数
		var dangqian_page=Number($(".current").text());//获取当前页码
		//前面的页码
		for (var i=dangqian_page-3;i<=dangqian_page-1 ; i++)
		{
			if(i<=1){
				break;
			}
			if(i>1){
				$(".up").append("<a class='page_uu' value='"+i+"'>"+i+"</a>");
			}
		}
		//后面的页码
		for (var i=dangqian_page+1;i<=dangqian_page+3; i++)
		{
			if(i<=count){
				$(".down").append("<a class='page_uu' value='"+i+"'>"+i+"</a>");
			}
		}

		if(dangqian_page=="1"){
			$("#up_page").hide();
		}
		if(dangqian_page==count){
			$("#down_page").hide();
		}
		for(var i=1;i<=count;i++){
			if(i==dangqian_page){
				$("#select_page").append("<option value='"+i+"' selected='selected'>"+i+"</option>");
			}else{
				$("#select_page").append("<option value='"+i+"'>"+i+"</option>");
			}
		}
		$(".page_uu").click(function(){
			var page_Num=$(this).text();//页数
			var agent_id=$('#areaId').val();//省市ID
			var level=$("#level").val();//等级
			var showModel=$("#showModel").val();//监控模式
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			var device_no=$("#device_no").val();//加油站编号
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name+"&device_no="+device_no;
		})
		$("#select_page").change(function(){
			var page_Num=$(this).val();//页数
			var agent_id=$('#areaId').val();//省市ID
			var level=$("#level").val();//等级
			var showModel=$("#showModel").val();//监控模式
			var channelName=$("#channelName").val();//渠道
			var place_name=$("#place_name").val();//网点
			var device_no=$("#device_no").val();//加油站编号
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&areaId="+agent_id+"&level="+level+"&showModel="+showModel+"&channelName="+channelName+"&place_name="+place_name+"&device_no="+device_no;
		});
    });
jQuery(".alert-set-tab").slide({trigger:"click"});

setInterval(function(){window.location.reload()},1000*5*60);
</script>
</body>
</html>