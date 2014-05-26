<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<HTML>
<head>
	<TITLE> ZTREE DEMO - checkbox</TITLE>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
	<script type="text/javascript" src="__PUBLIC__/js/tree/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
	<script type="text/javascript">
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
							var value='"'+val['value']+'"';
							zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':false};
						});
						alert(zNodes[1]);
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
		
		$(document).ready(function(){	
				$.fn.zTree.init($("#treeDemo"), setting,zNodes);
				setCheck();
				$("#py").bind("change", setCheck);
				$("#sy").bind("change", setCheck);
				$("#pn").bind("change", setCheck);
				$("#sn").bind("change", setCheck);
		});

	</script>
</head>

<BODY>
<div class="content_wrap">
	<div class="zTreeDemoBackground left">
		<ul id="treeDemo" class="ztree"></ul>
	</div>
	<div id="test">
	</div>
</div>
</BODY>
</HTML>