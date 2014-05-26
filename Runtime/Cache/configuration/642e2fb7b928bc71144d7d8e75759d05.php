<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>组织结构</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
	<!--树形结构类-->
	<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
	<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
</head>

<script type="text/javascript">
//===================================================树形结构js==========================
	var setting = {
		check: {
			enable: true
		},
		data: {
			simpleData: {
			enable: true
			}
		}
	};
	var handleUrl="http://127.0.0.1/gas_station_erp/index.php/configuration/Org/show_area_tree";
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
				zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':false};
			});
		},
							  
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			 // alert("请求失败!");
		}
	});


		var code;
		
		function setCheck() {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			py = $("#py").attr("checked")? "p":"",
			sy = $("#sy").attr("checked")? "s":"",
			pn = $("#pn").attr("checked")? "p":"",
			sn = $("#sn").attr("checked")? "s":"",
			type = { "Y":py + sy, "N":pn + sn};
			zTree.setting.check.chkboxType = type;
			showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
		}
		function showCode(str) {
			if (!code) code = $("#code");
			code.empty();
			code.append("<li>"+str+"</li>");
		}

//===================================================树形结构js结束==========




$(document).ready(function(){

//===================================================树形结构js传递==========
	$.fn.zTree.init($("#treeDemo"), setting,zNodes);
	setCheck();
	$("#py").bind("change", setCheck);
	$("#sy").bind("change", setCheck);
	$("#pn").bind("change", setCheck);
	$("#sn").bind("change", setCheck);
//=====================================================单击添加按钮弹出模态窗事件============================================
	$('#j_add_button').click(function(){ 
			$.openDOMWindow({ 
				loader:1, 
				loaderHeight:16, 
				loaderWidth:17, 
				windowSourceID:'#j_add_win' 
			}); 
				return false; 
	});
});
</script>








<body>
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">智能手机加油站ERP管理系统</h2>
    <div class="login">
        <div class="left">
            <ul class="left-nav">
                <li>赵洋,您好 <span></span>
                    <ul>
                        <li><a href="">修改密码</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="right">
            <a href="">退出系统</a>
        </div>
    </div>
</div>
<div id="nav">
    <ul class="main-nav">
        <li><a href="">资源管理</a></li>
        <li><a href="">渠道管理</a></li>
        <li><a href="">运维管理</a></li>
        <li><a href="">报表分析</a></li>
        <li class="active"><a href="">系统设置</a></li>
    </ul>
</div>
<div id="container">
    <div class="left">
        <ul class="aside-nav">
            <li class="aside-nav-nth1"><a href="">系统设置</a></li>
            <li class="active"><a href="<?php echo U('Org/index');?>"><input  type="button"  value="组织结构" ></a></li>
            <li><a href="<?php echo U('Role/index');?>"><input type="button" class="" value="角色维护" ></a></li>
            <li><a href="<?php echo U('User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
        </ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="org-right-btns">
                    <form action="">
                        <button type="button" class="area-btn" id="j_add_button">新增</button>
                        <button type="button" class="area-btn">编辑</button>
                        <button type="button" class="area-btn">删除</button>
                        <button type="button" class="area-btn">上移</button>
                        <button type="button" class="area-btn">下移</button>
                    </form>
                </div>
                <div class="org-right-tree">



				<div class="content_wrap">
					<div class="zTreeDemoBackground left">
							<ul id="treeDemo" class="ztree"></ul>
					</div>
				</div>
                    <!-- 容器 -->
                    <div id="J_Tree"></div>
                    <!-- 结果收集、设置回显数据 -->
                    <input type="hidden" id="J_TreeResult" value='{"id":"291"}'>
                </div>
                <div class="org-right-info">
                    <h3>组织机构信息</h3>
                    <form action="">
                        <div class="info-left cf">
                            <label for="org">组织机构名称</label><input type="text" name="" id="org" class="input-org-info"/>
                            <label for="linkman">联系人</label><input type="text" name="" id="linkman" class="input-org-info"/>
                            <label for="address">办公地址</label><input type="text" name="" id="address" class="input-org-info"/>
                            <label for="contract-number">合同编号</label><input type="text" name="" id="contract-number" class="input-org-info"/>
                        </div>
                        <div class="info-right cf">
                            <label for="org-s">上级组织机构</label><input type="text" name="" id="org-s" class="input-org-info"/>
                            <label for="phone">联系电话</label><input type="text" name="" id="phone" class="input-org-info"/>
                            <label for="yw-are">业务范围</label><input type="text" name="" id="yw-are" class="input-org-info"/>
                            <em>
                                <label for="sq-date">授权日期</label><input type="text" name="" id="sq-date" class="input-org-info min-w"/>
                                <input type="text" name="" id="date" class="input-org-info min-w"/>
                                <input type="checkbox" name="" id="forver" class="org-input-c"/><label class="lab-ckbox" for="forver">永久</label>
                            </em>
                        </div>
                    </form>
                    <div class="info-bottom">
                        <em>
                            所属渠道商总数：
                        </em>
                        <em>
                            加油站总数：
                        </em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">

</div>
<div class="alert-org-add" id="j_add_win" style=" display:none;">
    <div class="org-right-info">
        <h3>组织机构信息</h3>
        <form action="">
            <div class="info-left cf">
                <label for="org">组织机构名称</label><input type="text" name="" id="org" class="input-org-info"/>
                <label for="linkman">联系人</label><input type="text" name="" id="linkman" class="input-org-info"/>
                <label for="address">办公地址</label><input type="text" name="" id="address" class="input-org-info"/>
                <label for="contract-number">合同编号</label><input type="text" name="" id="contract-number" class="input-org-info"/>
            </div>
            <div class="info-right cf">
                <label for="org-s">上级组织机构</label><input type="text" name="" id="org-s" class="input-org-info"/>
                <label for="phone">联系电话</label><input type="text" name="" id="phone" class="input-org-info"/>
                <label for="yw-are">业务范围</label><input type="text" name="" id="yw-are" class="input-org-info"/>
                <em>
                    <label for="sq-date">授权日期</label><input type="text" name="" id="sq-date" class="input-org-info min-w"/>
                    <input type="text" name="" id="date" class="input-org-info min-w"/>
                    <input type="checkbox" name="" id="forver" class="org-input-c"/><label class="lab-ckbox" for="forver">永久</label>
                </em>
            </div>
        </form>
        <div class="info-bottom">
            <button type="button" class="alert-btn">保存</button>
            <button type="button" class="alert-btn">关闭</button>
        </div>
    </div>
</div>

</body>
</html>