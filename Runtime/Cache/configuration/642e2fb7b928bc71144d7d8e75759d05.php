<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>组织结构</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
    <style>
        @media screen and (max-width: 1300px){
            input.input-org-info,input{width: 160px;
                }
            input.min-w{
                width: 85px;}
            #container{min-width: 1200px;}
        }
    </style>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
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
        <li class="url_link" url="<?php echo U('control/Index/index');?>"><a href="<?php echo U('control/Index/index');?>">加油站监控</a></li>
        <li class="url_link" url="<?php echo U('channel/Channel/index');?>"><a href="<?php echo U('channel/Channel/index');?>">渠道管理</a></li>
        <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>">运营管理</a></li>
        <li class="url_link" url="<?php echo U('statistics/Index/index');?>"><a href="<?php echo U('statistics/Index/index');?>">统计分析</a></li>
        <li class="url_link" url="<?php echo U('ad/Index/index');?>"><a href="<?php echo U('ad/Index/index');?>">广告管理</a></li>
        <li class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    </ul>
</div>
</div>

<div id="container">
    <div class="left">
        
<ul class="aside-nav cf">
    <li class="aside-nav-nth1" ><a>系统设置<i class="j-show-list">-</i></a>
            <ul><li class="url_link" url="<?php echo U('configuration/Org/index');?>"><a href="<?php echo U('configuration/Org/index');?>"><input  type="button"  value="组织机构" ></a></li>
                <li class="url_link" url="<?php echo U('configuration/Role/show_role');?>"><a href="<?php echo U('configuration/Role/show_role');?>"><input type="button" class="" value="角色维护" ></a></li>
                <li class="url_link" url="<?php echo U('configuration/User/index');?>"><a href="<?php echo U('configuration/User/index');?>"><input type="button" class="" value="职员维护" ></a></li></ul>
    </li>

</ul>

        <!--<ul class="aside-nav">
            <li class="aside-nav-nth1"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
            <li class="active"><a href="<?php echo U('configuration/Org/index');?>"><input  type="button"  value="组织结构" ></a></li>
            <li><a href="<?php echo U('configuration/Role/show_role');?>"><input type="button" class="" value="角色维护" ></a></li>
            <li><a href="<?php echo U('configuration/User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
        </ul>-->
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="org-right-btns">
                    <form action="">
                        <button type="button" class="area-btn" id="j_add_button">新增</button>
                        <button type="button" class="area-btn" id="j_mod_button">编辑</button>
                        <button type="button" class="area-btn" id="j_del_button">删除</button>
                        <!--<button type="button" class="area-btn">上移</button>
                        <button type="button" class="area-btn">下移</button>-->
                    </form>
                </div>
                <div class="org-right-tree">



				<div class="content_wrap">
					<div class="zTreeDemoBackground left">
							<ul id="treeDemo" class="ztree"></ul>
					</div>
				</div>

                </div>
                <div class="org-right-info" id="j_org">
                    <h3>组织机构信息</h3>
                        <div class="info-left cf">
                            <label for="change_agent_name_txt">组织机构名称</label><input type="text" name="" id="change_agent_name_txt" readonly="true" class="input-org-info"/><i class="red-color pdl10">*</i>
                            <label for="linkman">联系人</label><input readonly="true" type="text" name="" id="change_legal_txt" class="input-org-info"/>
                            <label for="address">办公地址</label><input readonly="true" type="text" name="" id="change_companyAddr_txt" class="input-org-info"/>
                            <label for="contract-number">合同编号</label><input readonly="true" type="text" name="" id="change_contract_number_txt" class="input-org-info"/>
                            <input type="text" id="agent_id_hid" value=""/>
                            <input type="text" id="agent_pid_hid" value=""/>
                        </div>
                    <div class="info-right cf">

                            <label for="org-s">上级组织机构</label><input readonly="true" type="text" name="" id="father_agent_name" class="input-org-info"/>
                            <label for="phone">联系电话</label><input readonly="true" type="text" name="" id="change_legal_tel_txt" class="input-org-info"/>
                            <label for="yw-are">业务范围</label><input readonly="true" type="text" name="" id="area_name" class="input-org-info"/><i class="red-color pdl10">*</i>



                            <label class="wenben">公司电话</label><input readonly="true" type="text" name="tel_txt" id="change_tel_txt" class="input-org-info" />
                            <em>
                                <label for="sq-date">授权日期</label>
								<input readonly="true" type="text" name="" id="sq-date" class="input-org-info min-w"/>
                                <input readonly="true" type="text" name="" id="date" class="input-org-info min-w"/>
                                <!--<input readonly="true" type="checkbox" name="" id="forver" class="org-input-c"/>-->
								<label class="lab-ckbox" for="forver" id="forever">永久</label>
                            </em>

                        </div>

                    <div class="info-bottom">
                        <em>
                            所属渠道商总数：<span id="channel_num"></span>
                        </em>
                        <em>
                            加油站总数：<span id="device_num"></span>
                        </em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <p>© 大连捷诺科技有限公司 <a style="color: #ffffff;" href="http://www.jienuo-service.net/">关于捷诺</a> | 服务热线 0411-86887659</p>
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
<script>
    $(function(){
        $('.aside-nav-nth1').click(function(event){
            var oUl1 = $(this).find('ul');
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
<div class="alert-org-add" id="j_add_win" style=" display:none;">
    <div class="org-right-info" id="add">
        <h3>组织机构信息</h3>
        <form action="">
            <div class="info-left cf">
                <label for="org">组织机构名称</label><input type="text" name="" id="j_add_org" class="input-org-info"/><i class="red-color pdl10">*</i>
                <label for="linkman">联系人</label><input type="text" name="" id="j_add_linkman" class="input-org-info"/>
                <label for="address">办公地址</label><input type="text" name="" id="j_add_address" class="input-org-info"/>
                <label for="contract-number">合同编号</label><input type="text" name="" id="j_add_contract-number" class="input-org-info"/>
            </div>
            <div class="info-right cf">
                <label for="org-s">上级组织机构</label><input type="text" name="" id="j_add_org-s" class="input-org-info" readonly="readonly" />
                <label for="phone">联系电话</label><input type="text" name="" id="j_add_phone" class="input-org-info"/>
                <label for="yw-are">业务范围</label><input type="text" name="" id="restxts" class="input-org-info" readonly="readonly"/><i class="red-color pdl10">*</i>
				<input name="test"  id="j-choose" value="选择" type="button"/>
				<input type='hidden' id='resvals' value=''>											

                <label class="wenben">公司电话</label><input type="text" name="add_tel_txt" id="add_tel_txt" class="input-org-info" />
                <em>
                    <label for="sq-date">授权日期</label>
					<input type="text" name="" id="j_add_sq-date" class="input-org-info min-w" onClick="WdatePicker()" readonly="readonly"/>
                    <input type="text" name="" id="j_add_date" class="input-org-info min-w" onClick="WdatePicker()" readonly="readonly"/>
                    <input type="checkbox" name="" id="j_add_forever_check" class="org-input-c"/>
					<label class="lab-ckbox" for="forver">永久</label>
                </em>
            </div>
        </form>
        <div class="info-bottom">
            <button type="button" class="alert-btn" id="j_add_save">保存</button>

			<button type="button" class="alert-btn" id="j_close">关闭</button>

        </div>
    </div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>组织结构</h3>
		<div class="alert-role-add-con">
			<p class="delete-message">请确认是否删除？</p>
			<input type="hidden" value="" id="del_id_hidden"/>
			<p>
				<button type="button" class="alert-btn2" id="j_del_ok">删除</button>
				<a href="#" class="closeDOMWindow">
					<button type="button" class="alert-btn2">取消</button>
				</a>
			</p>
		</div>
	</div>
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<!--树形结构类-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script><!--日历JS插件-->
<script type="text/javascript" src="__PUBLIC__/js/jquery-levelSelect-ajax.js"></script><!--省市联动JS插件-->


<script type="text/javascript">
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
var handleUrl="<?php echo U('configuration/Org/show_org_tree');?>";
var zNodes=new Array();
var now=new Date().getTime();//加个时间戳表示每次是新的请求
$.ajax({
    type: "POST",
    url: handleUrl,
    async: false,
    dataType: "json",
    success: function(data){
        $.each(data,function(key,val){
            var kid=val['id'];
            var parent=val['parent'];
            var value=val['value'];
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

//=====================================================监听是否永久复选框====================================



$(document).ready(function(){

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

//===================================================展示信息========================================
    $("#treeDemo a").click(function(){
        $("#j_org input").val("");//初始化文本框
        var mod_handleUrl = "<?php echo U('configuration/Org/orgDetailSelect');?>";
        var agent_id=$(this).attr("title");
        $.getJSON(mod_handleUrl,{"agent_id":agent_id},
                function (data){
                    $("#agent_id_hid").val(agent_id);
					$("#agent_pid_hid").val(data['father_agentid']);//上级组织机构id
                    //var tmp_change_father_agent_id = data['father_agentid'];
                    //$("#change_agent_id_txt").val(data['agent_id']);
                    $("#change_agent_name_txt").val(data['agent_name']);//组织机构名称

                    $("#change_legal_tel_txt").val(data['legal_tel']);//联系人电话
                    $("#change_legal_txt").val(data['legal']);//联系人
                    $("#change_tel_txt").val(data['tel']);//公司电话
                    $("#change_companyAddr_txt").val(data['companyAddr']);//办公地址
                    $("#change_contract_number_txt").val(data['contract_number']);//合同编号
                    $("#father_agent_name").val(data['father_agent_name']);//上级组织机构
                    $("#area_name").val(data['area_name']);//业务范围NAME
                    var forever_type=data['forever_type'];//是否永久
                    $("#channel_num").text(data['channel_num']);//渠道数量

                    $("#device_num").text(data['device_num']);//加油站数量
                    if('1' == forever_type){
                        $("#sq-date").hide();
                        $("#date").hide();
						$("#forever").show();
                    }else{
                        $("#sq-date").show();
                        $("#date").show();
                        $("#forever").hide();
                        $("#sq-date").val(data['begin_time']);
                        $("#date").val(data['end_time']);
                    }
                }
                ,'json'
        );
    })
//=====================================================单击添加按钮弹出模态窗事件============================================
    $('#j_add_button').click(function(){
		$("#add .input-org-info").val("");//初始化文本
		if ($('#agent_id_hid').val()=="")
		{	
			alert("请选择一条组织结构再进行增加");
			return false;
		}
		var add_father_value_sel=$("#change_agent_name_txt").val();
		$('#j_add_org-s').val(add_father_value_sel);
		//=====================================================业务范围事件============================================
    $("#j-choose").click(function(){
		var id=$('#agent_id_hid').val();
		var url="<?php echo U('configuration/Org/show_org_area_tree');?>";
        $.openLayer({
            maxItems : 5,
            pid : "0",
			url:url,
			id:id,
            returnText : "restxts",
            returnValue : "resvals",
            span_width : {d1:120,d2:150,d3:150},
            index : 10005
        });
    });
        //保存
        $('#j_add_save').click(function(){
            var add_agent_name_txt=$('#j_add_org').val();//组织机构名称
			if (add_agent_name_txt=="")
			{	
				alert("请输入组织机构名称");
				return false;
			}
		

            //var add_agent_type_sel=$("#add_agent_type_sel").val();//代理商类型

           // var add_agent_level_sel=$('#add_agent_level_sel').val();//代理商级别

            var add_legal_txt=$('#j_add_linkman').val();//联系人
			if (add_legal_txt=="")
			{	
				//alert("请输入联系人");
				//return false;
			}

            var add_companyAddr_txt=$('#j_add_address').val();//办公地址
			if (add_companyAddr_txt=="")
			{	
				//alert("请输入办公地址");
				//return false;
			}

            var add_tel_txt=$('#add_tel_txt').val();//公司电话
			if (add_tel_txt=="")
			{	
				//alert("请输入公司电话");
				//return false;
			}

            var add_contract_number_txt=$('#j_add_contract-number').val();//合同编号
			if (add_contract_number_txt=="")
			{	
				//alert("请输入合同编号");
				//return false;
			}

            var add_father_agentid_sel=$('#agent_id_hid').val();//上级组织机构id
			//alert(add_father_agentid_sel);

            var add_legal_tel_txt=$('#j_add_phone').val();//联系电话
			if (add_legal_tel_txt=="")
			{	
				//alert("请输入联系人电话");
				//return false;
			}

            var add_org_area=$('#resvals').val();//业务范围
			if (add_org_area=="")
			{	
				alert("请选择业务范围");
				return false;
			}

            var add_begin_time_sel=$('#j_add_sq-date').val();//授权日期

            var add_end_time_sel=$('#j_add_date').val();//授权日期

            var is_add_forever_checked = $("#j_add_forever_check").attr('checked');
            var add_forever_check="";
            if('checked' == is_add_forever_checked)
            {
                var add_forever_check = '1';
            }
            else
            {
                var add_forever_check = '0';
            }

            //return false;
            var add_handleUrl="<?php echo U('configuration/Org/add_org');?>";
            $.getJSON(add_handleUrl,{"add_agent_name_txt":add_agent_name_txt,"add_legal_txt":add_legal_txt,
                        "add_companyAddr_txt":add_companyAddr_txt,
                        "add_tel_txt":add_tel_txt,

                        "add_contract_number_txt":add_contract_number_txt,"add_father_agentid_sel":add_father_agentid_sel,
                        "add_legal_tel_txt":add_legal_tel_txt,"add_org_area":add_org_area,"add_contract_number_txt":add_contract_number_txt,
                        "add_companyAddr_txt":add_companyAddr_txt,"add_begin_time_sel":add_begin_time_sel,"add_end_time_sel":add_end_time_sel,"add_forever_check":add_forever_check},
                    function (data){
                        var tmp_msg = "<?php echo C('add_agents_success');?>";
                        if(tmp_msg == data)
                        {
                            alert(data);
                            window.location.href = window.location.href;
                        }
                        else
                        {
                            alert(data);
                            //$(".cli_tishi").html("<img src='__PUBLIC__/image/th.png'/>"+data+"");
                        }
                    }
                    ,'json'
            );
        });//结束
		$("#j_add_forever_check").click(function(){
			 var is_add_forever_checked = $("#j_add_forever_check").attr('checked');
			if('checked' == is_add_forever_checked)
				{
					$('#j_add_sq-date').css("visibility","hidden");
					$('#j_add_date').css("visibility","hidden");
				}
			else
				{
					$('#j_add_sq-date').css("visibility","visible");
					$('#j_add_date').css("visibility","visible");
				}
		});
		//关闭按钮
		$("#j_close").click(function(){
			window.location.href = window.location.href;
		});

        $.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#j_add_win'
        });
        return false;
    });
//=====================================================单击修改按钮事件======================================================
    $('#j_mod_button').click(function(){
		if ($('#agent_id_hid').val()=="")
		{	
			alert("请选择一条组织结构再进行编辑");
			return false;
		}
		$("#add .input-org-info").val("");//初始化文本
		$("#j-choose").click(function(){
			var pid=$('#agent_pid_hid').val();
			var url="<?php echo U('configuration/Org/show_org_area_tree');?>";
			$.openLayer({
				maxItems : 5,
				url:url,
				pid : "0",
				id:pid,
				returnText : "restxts",
				returnValue : "resvals",
				span_width : {d1:120,d2:150,d3:150},
				index : 10005
			});
		});
        var mod_handleUrl = "<?php echo U('configuration/Org/orgDetailSelect');?>";
        var agent_id=$("#agent_id_hid").val();
        $.getJSON(mod_handleUrl,{"agent_id":agent_id},
                function (data){
                    $("#j_add_org").val(data['agent_name']);//组织机构名称
                    $("#j_add_phone").val(data['legal_tel']);//联系人电话
                    $("#j_add_linkman").val(data['legal']);//联系人
                    $("#add_tel_txt").val(data['tel']);//公司电话
                    $("#j_add_address").val(data['companyAddr']);//办公地址
                    $("#j_add_contract-number").val(data['contract_number']);//合同编号
                    $("#j_add_org-s").val(data['father_agent_name']);//上级组织机构
                    $("#restxts").val(data['area_name']);//业务范围NAME
					$("#resvals").val(data['area_id']);//业务范围NAME
                    var forever_type=data['forever_type'];//是否永久
                    if('1' == forever_type)
                    {
                        $("#j_add_forever_check").attr('checked','checked');
						$('#j_add_sq-date').css("visibility","hidden");
						$('#j_add_date').css("visibility","hidden");
                    }
                    else
                    {
                        $("#j_add_forever_check").attr('checked',false);
						$('#j_add_sq-date').css("visibility","visible");
						$('#j_add_date').css("visibility","visible");
                        $("#j_add_sq-date").val(data['begin_time']);
                        $("#j_add_date").val(data['end_time']);
                    }


                }
                ,'json'
        );
        //保存
        $('#j_add_save').click(function(){
            var add_agent_name_txt=$('#j_add_org').val();//组织机构名称
			if (add_agent_name_txt=="")
			{	
				alert("请输入组织机构名称");
				return false;
			}

            var add_legal_txt=$('#j_add_linkman').val();//联系人
			if (add_legal_txt=="")
			{	
				//alert("请输入联系人名称");
				//return false;
			}

            var add_companyAddr_txt=$('#j_add_address').val();//办公地址
			if (add_companyAddr_txt=="")
			{	
				//alert("请输入办公地址");
				//return false;
			}

            var add_tel_txt=$('#add_tel_txt').val();//公司电话
			if (add_tel_txt=="")
			{	
				//alert("请输入公司电话");
				//return false;
			}

            var add_contract_number_txt=$('#j_add_contract-number').val();//合同编号
			if (add_contract_number_txt=="")
			{	
				//alert("请输入合同编号");
				//return false;
			}

            //var add_father_agentid_sel=$('#agent_id_hid').val();//上级组织机构
			//alert(add_father_agentid_sel);

            var add_legal_tel_txt=$('#j_add_phone').val();//联系电话
			if (add_legal_tel_txt=="")
			{	
				//alert("请输入联系人电话");
				//return false;
			}
            var add_org_area=$('#resvals').val();//业务范围
			if (add_org_area=="")
			{	
				alert("请选择业务范围");
				return false;
			}

            var add_begin_time_sel=$('#j_add_sq-date').val();//授权日期

            var add_end_time_sel=$('#j_add_date').val();//授权日期

            var is_add_forever_checked = $("#j_add_forever_check").attr('checked');
            var add_forever_check="";
            if('checked' == is_add_forever_checked)
            {
                var add_forever_check = '1';
            }
            else
            {
                var add_forever_check = '0';
            }
            //return false;
            var mod_save_handleUrl="<?php echo U('configuration/Org/edit_org');?>";
            $.getJSON(mod_save_handleUrl,{"change_agent_name_txt":add_agent_name_txt,"change_legal_txt":add_legal_txt,"change_agent_id_txt":agent_id,
                        "change_companyAddr_txt":add_companyAddr_txt,
                        "change_tel_txt":add_tel_txt,
                        "change_contract_number_txt":add_contract_number_txt,
                        "change_legal_tel_txt":add_legal_tel_txt,"change_dst_area":add_org_area,"change_contract_number_txt":add_contract_number_txt,
                        "change_companyAddr_txt":add_companyAddr_txt,"change_begin_time_sel":add_begin_time_sel,"change_end_time_sel":add_end_time_sel,"change_forever_check":add_forever_check},
                    function (data){
                        var tmp_msg = "<?php echo C('change_agent_success');?>";
                        if(tmp_msg == data)
                        {
                            alert(data);
                            window.location.href = window.location.href;
                        }
                        else
                        {
                            alert(data);
                            //$(".cli_tishi").html("<img src='__PUBLIC__/image/th.png'/>"+data+"");
                        }
                    }
                    ,'json'
            );
        });//结束
		$("#j_add_forever_check").click(function(){
			var is_add_forever_checked = $("#j_add_forever_check").attr('checked');
			if('checked' == is_add_forever_checked)
				{
					$('#j_add_sq-date').css("visibility","hidden");
					$('#j_add_date').css("visibility","hidden");
				}
			else
				{
					$('#j_add_sq-date').css("visibility","visible");
					$('#j_add_date').css("visibility","visible");
				}
		});
		//关闭按钮
		$("#j_close").click(function(){
			window.location.href = window.location.href;
		});

        $.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#j_add_win'
        });
        return false;
    })

//=====================================================单击删除按钮弹出模态窗事件============================================
    $('#j_del_button').click(function(){
		if ($('#agent_id_hid').val()=="")
		{	
			alert("请选择一条组织结构再进行删除");
			return false;
		}
        var ki=$("#agent_id_hid").val();
        $("#del_id_hidden").val(ki);
        //单击删除确认按钮
        $('#j_del_ok').click(function(){
            var kid=$("#del_id_hidden").val();
            var del_handleUrl="<?php echo U('configuration/Org/delete_org');?>";
            $.getJSON(del_handleUrl,{"agent_id":kid},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

        $.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#j_del_win'
        });
        return false;


    });







});

</script>
</body>
</html>