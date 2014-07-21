<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>监控平台</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
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

<div id="container">
    <div class="left">
        
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>远程监控<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('monitoring/Index/station');?>"><a href="<?php echo U('monitoring/Index/station');?>"><input  type="button"  value="监控平台" ></a></li>
            <!--<li class="url_link" url=""><a href=""><input type="button" class="" value="监控设置" ></a></li>-->
            <!--<li class="url_link" url=""><a href=""><input type="button" class="" value="异常记录" ></a></li>-->
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
                                <dt><b class="icon-checkmark-circle green-color"></b><em><?php echo ($devRightNum); ?></em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em><?php echo ($devBreakNum); ?></em></dt>
                            </dl>
                        </li>
                        <li>
                            <h4>APP应用</h4>
                            <span><img src="__PUBLIC__/image/1.png" alt=""/></span>
                            <dl class="station-zhuangtai">
                                <dt><b class="icon-checkmark-circle green-color"></b><em>0</em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em>0</em></dt>
                            </dl>
                        </li>
                        <li>
                            <h4>媒体广告</h4>
                            <span><img src="__PUBLIC__/image/4.png" alt=""/></span>
                            <dl class="station-zhuangtai">
                                <dt><b class="icon-checkmark-circle green-color"></b><em>0</em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em>0</em></dt>
                            </dl>
                        </li>
                        <li>
                            <h4>远程操作</h4>
                            <span><img src="__PUBLIC__/image/5.png" alt=""/></span>
                            <dl class="station-zhuangtai">
                                <dt><b class="icon-checkmark-circle green-color"></b><em>0</em></dt>
                                <dt><b class="icon-cancel-circle red-color"></b><em>0</em></dt>
                            </dl>
                        </li>
                    </ul>
                    <!-- 
                    <div class="station-state-list-cx">
						<span id="hide">
							<label for="channel-ss-are">所属网点</label>
							<select name="add_agent_type_sel" id="channel-ss-are" class="channel-select-min">
								<option selected value="">省份</option>
								<option class="industry" value="trade">2</option>
								<option class="area" value="area">3</option>
							</select>
							<select name="add_agent_type_sel" id="channel-class2" class="channel-select-min">
								<option selected value="">城市</option>
								<option class="industry" value="trade">2</option>
								<option class="area" value="area">3</option>
							</select>
						  -- <select name="add_agent_type_sel" id="channel-class3" class="channel-select-min">
								<option selected value="">区域</option>
								<option class="industry" value="trade">2</option>
								<option class="area" value="area">3</option>
							</select>--
							<input placeholder="请输入渠道名称" type="text" name="" id="channel-ss-channel" class="station-info"/>
							<button type="button" class="role-control-btn">查询</button>
							<button type="button" class="role-control-btn">导出</button>
						</span>
                        <div class="mode-change">
                            <a href="" class="active">监控台模式</a> <a href="">列表模式</a>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="station-state-list"  id="j-station-sh1">
                <div class="station-state-tree1">
					<div class="zTreeDemoBackground left">
							<ul id="treeDemo" class="ztree"></ul>
					</div>
                </div>
                <ul class="station-state-list-con">
                    <?php if(is_array($devPageBreakArr)): foreach($devPageBreakArr as $key=>$devBreak): ?><li>
	                        <div class="station-state-info">
	                            <em>报警时间 ： <?php echo ($devBreak['wrong_begin_time']); ?></em>
	                            <em>报警时长  ： <?php echo ($devBreak['continueTime']); ?></em>
	                            <em><?php echo ($devBreak['province']); ?>  <?php echo ($devBreak['city']); ?>  <?php echo ($devBreak['address']); ?> <?php echo ($devBreak['dev_mac']); ?> <?php echo ($devBreak['dev_no']); ?></em>
	                        </div>
	                        <div class="station-state-dl">
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em>在线状态</em>
	                                    <?php if($devBreak['on_line'] == 0): ?><span class="icon-checkmark green-color"></span>
										<?php else: ?>
											<span class="icon-close red-color"></span><?php endif; ?>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em>正常开机</em>
	                                    <?php if($devBreak['start_time'] == 0): ?><span class="icon-checkmark green-color"></span>
										<?php else: ?>
											<span class="icon-close red-color"></span><?php endif; ?>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em>正常关机</em>
	                                    <?php if($devBreak['shutdown_time'] == 0): ?><span class="icon-checkmark green-color"></span>
										<?php else: ?>
											<span class="icon-close red-color"></span><?php endif; ?>
	                                </span>
	                            </div>
	                            <div class="row-lt">
	                                <span class="row-lt-l">
	                                    <em>APP刊例</em>
	                                    <span class="icon-close red-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em>上屏程序版本</em>
	                                    <span class="icon-checkmark green-color"></span>
	                                </span>
	                                <span class="row-lt-l">
	                                    <em>下屏程序版本</em>
	                                    <span class="icon-close red-color"></span>
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
				<a id="up_page">上一页</a>
				<span class="current"><?php echo ($pageNum); ?></span>
				<a id="down_page">下一页</a>
			</div>
            <!-- 
            <div class="station-state-list table-state" id="j-station-sh2">
                <ul class="station-list2-wz">
                    <li class="first-line">
                        <span>加油站所属网点</span>
                        <span>MAC地址</span>
                        <span>在线状态</span>
                        <span>正常开机</span>
                        <span>正常关机</span>
                        <span>APP刊例</span>
                        <span>上屏程序版本</span>
                        <span>下屏程序版本</span>
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
             -->
        </div>
    </div>
    <input type="hidden" name="pageNum" class="pageNum" id="pageNum" value="<?php echo ($pageNum); ?>"/>
    <input type="hidden" name="areaId" class="areaId" id="areaId" value="<?php echo ($areaId); ?>"/>
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
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<!--树形结构类-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript">jQuery(".alert-set-tab").slide({trigger:"click"});</script>
<script>
//===================================================树形结构js==========================
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
    }
};
var handleUrl="<?php echo U('monitoring/Index/getProvinceCity');?>";
var zNodes=new Array();
var now=new Date().getTime();//加个时间戳表示每次是新的请求
$.ajax({
    type: "POST",
    url: handleUrl,
    async: false,
    dataType: "json",
    success: function(data){
        $.each(data,function(key,val){
            var kid=val['area_id'];
            var parent=val['pid'];
            var value=val['area_name'];
            zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':true ,'t':kid};
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

var key;

//===================================================树形结构js结束==========
    $(function () {
		//===================================================树形结构js传递==========
		$.fn.zTree.init($("#treeDemo"), setting, zNodes);
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
		$("#treeDemo a").click(function(){
			var agent_id=$(this).attr("title");//省市ID
			$('#areaId').val(agent_id);
			$('#pageNum').val(1);//页数初始化
			var page_Num=$('#pageNum').val();//页数
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+page_Num+"&areaId="+agent_id;
		 });
        $("#down_page").click(function(){
			var page_Num=$('#pageNum').val();//页数
			var agent_id=$('#areaId').val();//省市ID
			var new_page_Num=Number(page_Num)+1;
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+new_page_Num+"&areaId="+agent_id;
		});
		$("#up_page").click(function(){
			var page_Num=$('#pageNum').val();//页数
			var agent_id=$('#areaId').val();//省市ID
			var new_page_Num=page_Num-1;
			window.location.href="<?php echo U('monitoring/Index/station');?>"+"?pageNum="+new_page_Num+"&areaId="+agent_id;
		});
    });

</script>
</body>
</html>