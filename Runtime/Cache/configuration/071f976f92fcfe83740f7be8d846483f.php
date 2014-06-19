<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>角色维护</title>
    <!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
</head>
<body>
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">智能手机加油站ERP管理系统</h2>
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
<div id="container">
    <div class="left">
        <ul class="aside-nav">
    <li class="aside-nav-nth1"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
    <li><a href="<?php echo U('configuration/Org/index');?>"><input  type="button"  value="组织结构" ></a></li>
    <li><a href="<?php echo U('configuration/Role/show_role');?>"><input type="button" class="" value="角色维护" ></a></li>
    <li><a href="<?php echo U('configuration/User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
</ul>
        <!--<ul class="aside-nav">
            <li class="aside-nav-nth1"><a href="<?php echo U('configuration/Org/index');?>">系统设置</a></li>
            <li><a href="<?php echo U('configuration/Org/index');?>"><input  type="button"  value="组织结构" ></a></li>
            <li class="active"><a href="<?php echo U('configuration/Role/show_role');?>"><input type="button" class="" value="角色维护" ></a></li>
            <li><a href="<?php echo U('configuration/User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
        </ul>-->
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire">
                        <form name="roleSelect" method="get" action="<?php echo U('configuration/Role/show_role');?>">
                            <label for="role-name" class="role-lab">角色名称</label>
                            <input type="text" name="role_name_txt" id="role_name_txt" value="<?php echo ($_GET['role_name_txt']); ?>" 
								autocomplete="off" class="input-org-info"/>
                            <input type="submit" id="select_button" name="select_button" class="role-control-btn">
                        </form>
                    </div>
                    <div class="org-right-btns">
                            <button type="button" class="area-btn" id="j_add_button">添加</button>
                            <button type="button" class="area-btn" id="j_mod_button">编辑</button>
                            <button type="button" class="area-btn" id="j_del_button">删除</button>
                            <button type="button" class="area-btn" id="j_selrole_button">查看权限</button>
							<input type="text" id="selrole_hidden_id" value="" />
							<input type="text" id="quanxian_id" value="" />
							
                    </div>
                </div>
                <div class="role-table over-h-y">
                    <ul class="role-table-list">
                        <li>
                            <span class="span-1"></span>
                            <span class="span-2"><b>角色名称</b></span>
                            <span class="span-3"><b>角色描述</b></span>
                            <span class="span-2"><b>创建人</b></span>
                            <span class="span-2"><b>创建日期</b></span>
                        </li>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="list_sel">
									<span class="span-1"><input type="radio" name="role-info_rad" id="" class="role-table-radio"/></span>
									<span class="span-2" title="#"><?php echo ($vo["rolename"]); ?></span>
									<span class="span-3" title="#"><?php echo ($vo["memo"]); ?></span>
									<span class="span-2" title="#"><?php echo ($vo["addusername"]); ?></span>
									<span class="span-2" title="#"><?php echo ($vo["adddate"]); ?></span>
									<!--角色ID-->
									<span class="roleid_hidden" title="#" style="display:none;"><?php echo ($vo["roleid"]); ?></span>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
					<div class="resultpage"><?php echo ($page); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer">

</div>
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


<div id="j_add_win" style="display:none;">
	<div class="alert-role-add w1k">
		<h3>添加角色信息</h3>
		<div class="alert-role-add-con">
			<form action="">
				<p>
					<label for="add_role_name_txt" class="role-lab">角色名称</label>
					<input type="text" name="addname"  class="input-role-name" id="add_role_name_txt"/>
				</p>
				<p>
					<label for="add_memo_txt" class="role-lab">角色描述</label>
					<textarea name=""  cols="30" rows="3" class="role-teatarea" id="add_memo_txt"></textarea>
				</p>

				<p>
					<button type="button" class="alert-btn2" id="j_add_save">保存</button>
					<button type="button" class="alert-btn2" id="j_add_close">关闭</button>
				</p>
			</form>
		</div>
        <div class="tree">
            <p>
                <label for="cityid">设置权限</label>

                <!--权限树形-->
            	<div class="zTreeDemoBackground left">
					<ul id="treeDemo" class="ztree"></ul>
					<input type="text" value="" id="add_quanxian_id"/>
				</div>
				
            </p>
        </div>
	</div>
</div>
<div id="j_mod_win" style="display:none">
	<div class="alert-role-add w1k">
		<h3>编辑角色信息</h3>
		<div class="alert-role-add-con">
			<form action="">
                <p>
					<label for="role-addname" class="role-lab">角色名称</label>
					<input type="text" name="addname" id="mod_rolename" class="input-role-name"/>
				</p>
				<p>
					<label for="role-textarea" class="role-lab">角色描述</label>
					<textarea name="" id="mod_memo" cols="30" rows="3" class="role-teatarea"></textarea>
				</p>

				<p>
					<button type="button" class="alert-btn2" id="j_mod_save">保存</button>

					<button type="button" class="alert-btn2" id="j_mod_close">关闭</button>

				</p>
                <input type="text" id="mod_id_hide" value=""/>
			</form>
		</div>
        <div class="tree">
            <p>
                <label for="">设置权限</label>
                <!--权限树形-->
            	<div class="zTreeDemoBackground left">
					<ul id="mod_treeDemo" class="ztree"></ul>
					<input type="text" value="" id="mod_quanxian_id"/>
				</div>
            <div id="mod_menuContent" class="menuContent" style="display:none; ">
                <ul id="mod_treeDemo" class="ztree" style="margin-top:0; width:50px; height: 50px;"></ul>
            </div>
            </p>
        </div>
	</div>
</div>

<div id="j_show_purview" style="display:none">
	<div class="alert-role-add">
        <h3>查看权限</h3>

                <div class="zTreeDemoBackground left">
					<ul id="show_treeDemo" class="ztree"></ul>
					<input type="text" value="" id="show_quanxian_id"/>
				</div>

		<a href="." class="closeDOMWindow">
		    <button type="button" class="alert-btn2">关闭</button>
		</a>
        <div class="bk10"></div>
	</div>
</div>

<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>用户角色</h3>
		<div class="alert-role-add-con">
			<p class="delete-message">请确认是否删除？</p>
			<input type="hidden" value="" id="del_id_hidden"/>
			<p>
				<button type="button" class="alert-btn2" id="j_del_ok">删除</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
				</a>
			</p>
		</div>
	</div>
</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<!--树形结构类-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<link rel="stylesheet" href="__PUBLIC__/css/jquery.bigautocomplete.css" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script>
window.onscroll=function(){
    var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
    var fixDiv=document.getElementById('j-fixed-top');
    if(scrollTop>=300){
        fixDiv.style.position='fixed';
        fixDiv.style.top='0px';
    }else if(scrollTop<=299){
        fixDiv.style.position='static';
    }
}
//===================================================树形结构js==========================
		var setting = {
			check: {
				enable: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			view: {
				dblClickExpand: false
			},
			callback: {
				beforeClick: beforeClick,
				onCheck: onCheck
			}
		};

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
		function beforeClick(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheck(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getCheckedNodes(true),
			v = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].id + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			var cityObj = $("#add_quanxian_id");
			cityObj.attr("value", v);
		}

		function showMenu() {
			var cityObj = $("#add_quanxian_id");
			var cityOffset = $("#add_quanxian_id").offset();
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "add_quanxian_id" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}
		

//===================================================树形结构js结束==========
//===================================================修改树形结构js开始==========
		var mod_setting = {
			check: {
				enable: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			view: {
				dblClickExpand: false
			},
			callback: {
				beforeClick: mod_beforeClick,
				onCheck: mod_onCheck
			}
		};
		
		function mod_setCheck() {
			var zTree = $.fn.zTree.getZTreeObj("mod_treeDemo"),
			py = $("#py").attr("checked")? "p":"",
			sy = $("#sy").attr("checked")? "s":"",
			pn = $("#pn").attr("checked")? "p":"",
			sn = $("#sn").attr("checked")? "s":"",
			type = { "Y":py + sy, "N":pn + sn};
			zTree.setting.check.chkboxType = type;
			showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
		}
		function mod_showCode(str) {
			if (!code) code = $("#code");
			code.empty();
			code.append("<li>"+str+"</li>");
		}
		function mod_beforeClick(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("mod_treeDemo");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function mod_onCheck(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("mod_treeDemo"),
			nodes = zTree.getCheckedNodes(true),
			v = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].id + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			var cityObj = $("#mod_quanxian_id");
			cityObj.attr("value", v);
		}

		function mod_showMenu() {
			var cityObj = $("#mod_quanxian_id");
			var cityOffset = $("#mod_quanxian_id").offset();
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function mod_hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "mod_quanxian_id" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}












$(document).ready(function(){




//===============================================保存添加事件=======================================
	$('#j_add_button').click(function(){
			var handleUrl="<?php echo U('configuration/Role/select_all_purview');?>";
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
//===================================================树形结构js传递==========
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			setCheck();
			$("#py").bind("change", setCheck);
			$("#sy").bind("change", setCheck);
			$("#pn").bind("change", setCheck);
			$("#sn").bind("change", setCheck);
        //保存
        $('#j_add_save').click(function(){
			var add_role_name_txt=$("#add_role_name_txt").val();//角色名
			var add_memo_txt=$("#add_memo_txt").val();//角色描述
			var add_menu_id_txt=$("#add_quanxian_id").val();//权限ID
			//alert(add_role_name_txt);
            //return false;
            var add_handleUrl="<?php echo U('configuration/Role/add_role');?>";
            $.getJSON(add_handleUrl,{"add_role_name_txt":add_role_name_txt,"add_memo_txt":add_memo_txt,
                        "add_menu_id_txt":add_menu_id_txt},
                    function (data){
						alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });//结束
		$("#j_add_close").click(function(){
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
//===============================================单击查看权限事件=======================================
	$("#j_selrole_button").click(function(){
			var role_id=$("#selrole_hidden_id").val();
			if(role_id==""){
				alert("请选择一条角色信息再进行查看");
				return false;
			}
			/*
			var role_handleUrl="<?php echo U('configuration/Role/select_purview');?>";
			var purview_role_id_txt=$("#selrole_hidden_id").val();
            $.getJSON(role_handleUrl,{"purview_role_id_txt":purview_role_id_txt},
                    function (data){
						alert(data);
                    }
                    ,'json'
            );
			*/
			//========权限
			var handleUrl="<?php echo U('configuration/Role/select_all_purview');?>";
			var zNodes=new Array();
			var now=new Date().getTime();//加个时间戳表示每次是新的请求
			var str=new String();
			var arr=new Array();
			str=$("#quanxian_id").val();
			arr=str.split(',');//注split可以用字符或字符串分割
			var idkey="";
			
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
					for(var i=0;i<arr.length;i++)
					{
						if(arr[i]==kid){
							zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':true ,checked:true,'t':kid};
							break;
						}else{
							zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':true ,'t':kid};
						}
					}

				});
			},

			error: function(XMLHttpRequest, textStatus, errorThrown) {
				// alert("请求失败!");
			}
		});
			$.fn.zTree.init($("#show_treeDemo"), mod_setting, zNodes);

			$.openDOMWindow({
				loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_show_purview'
        });
        return false;
	});
//=====================================================单击删除按钮弹出模态窗事件============================================
    $('#j_del_button').click(function(){
		var role_id=$("#selrole_hidden_id").val();
		if(role_id==""){
			alert("请选择一条角色信息再进行编辑");
			return false;
		}
        var delete_role_id_txt=$("#selrole_hidden_id").val();
        //单击删除确认按钮
        $('#j_del_ok').click(function(){
            var del_handleUrl="<?php echo U('configuration/Role/delete_role');?>";
            $.getJSON(del_handleUrl,{"delete_role_id_txt":delete_role_id_txt},
                    function (data){
                       // alert(data);
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
//===============================================单击编辑事件=======================================
	$("#j_mod_button").click(function(){
		//========权限
			var handleUrl="<?php echo U('configuration/Role/select_all_purview');?>";
			var zNodes=new Array();
			var now=new Date().getTime();//加个时间戳表示每次是新的请求
			var str=new String();
			var arr=new Array();
			str=$("#quanxian_id").val();
			arr=str.split(',');//注split可以用字符或字符串分割
			var idkey="";
			
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
					for(var i=0;i<arr.length;i++)
					{
						if(arr[i]==kid){
							zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':true ,checked:true,'t':kid};
							break;
						}else{
							zNodes[key]= {'id':kid, 'pId':parent, 'name':value, 'open':true ,'t':kid};
						}
					}

				});
			},

			error: function(XMLHttpRequest, textStatus, errorThrown) {
				// alert("请求失败!");
			}
		});
			$.fn.zTree.init($("#mod_treeDemo"), mod_setting, zNodes);
			mod_setCheck();
			$("#py").bind("change", mod_setCheck);
			$("#sy").bind("change", mod_setCheck);
			$("#pn").bind("change", mod_setCheck);
			$("#sn").bind("change", mod_setCheck);

			var role_id=$("#selrole_hidden_id").val();
			if(role_id==""){
				alert("请选择一条角色信息再进行编辑");
				return false;
			}
			var mod_handleUrl="<?php echo U('configuration/Role/roleDetailSelect');?>/role_id/"+role_id;
			var now=new Date().getTime();//加个时间戳表示每次是新的请求
			$.ajax({
				type: "POST",
				url: mod_handleUrl,
				async: false,
				dataType: "json",
				success: function(data){
					$("#mod_rolename").val(data['rolename']);//名称
					$("#mod_memo").val(data['memo']);//描述
					$("#mod_quanxian_id").val(data['menuid']);//权限ID
					$("#mod_id_hide").val(data['roleid']);//id
				},

				error: function(XMLHttpRequest, textStatus, errorThrown) {
					 alert("请求失败!");
				}
			});
//========权限结束

		//保存
        $('#j_mod_save').click(function(){
			var modify_role_id_txt=$("#mod_id_hide").val();//id
			var modify_role_name_txt=$("#mod_rolename").val();//名称
			var modify_memo_txt=$("#mod_memo").val();//描述
			var modify_menu_id_txt=$("#mod_quanxian_id").val();//权限id
            var mod_save_handleUrl="<?php echo U('configuration/Role/edit_role');?>";
            $.getJSON(mod_save_handleUrl,{"modify_role_id_txt":modify_role_id_txt,"modify_role_name_txt":modify_role_name_txt,"modify_memo_txt":modify_memo_txt,
                        "modify_menu_id_txt":modify_menu_id_txt},
                    function (data){
                        alert(data);
						window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });//结束
		$("#j_mod_close").click(function(){
			window.location.href = window.location.href;
		});
		//展示
		 $.openDOMWindow({
            loader:1,
            loaderHeight:16,
            loaderWidth:17,
            windowSourceID:'#j_mod_win'
        });
        return false;
	});



//===============================================单击查询框里某一条数据=======================================
	$(".list_sel").click(function(){
		$(this).find(".role-table-radio").attr("checked",'checked'); 
		var id= $(this).find(".roleid_hidden").text();
		$("#selrole_hidden_id").val(id);
		var mod_handleUrl="<?php echo U('configuration/Role/roleDetailSelect');?>/role_id/"+id;
		var now=new Date().getTime();//加个时间戳表示每次是新的请求
		$.ajax({
				type: "POST",
				url: mod_handleUrl,
				async: false,
				dataType: "json",
				success: function(data){
					$("#quanxian_id").val(data['menuid']);//权限ID
				},

				error: function(XMLHttpRequest, textStatus, errorThrown) {
					 alert("请求失败!");
				}
		});
    });





	role_name_blurry();

});

	function role_name_blurry()
	{
		var handleUrl = "<?php echo U('configuration/Role/rolenameBlurrySelect');?>";
		var role_name = '';
		$.getJSON(handleUrl,{"role_name":role_name},
			function (data){
				var str = data;
				//alert(data);
				//alert(str[1]['title']);
				$("#role_name_txt").bigAutocomplete({width:150,data:data,callback:function(data){}});
			}
			,'json'
		);
	}
</script>
</html>