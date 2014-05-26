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
	var handleUrl="http://127.0.0.1/gas_station_erp/index.php/configuration/Org/show_org_tree";
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
//=====================================================单击新建保存按钮============================================
	$('#j_add_save').click(function(){
		var add_agent_name_txt=$('#j_add_org').val();//组织机构名称
		var add_legal_txt=$('#j_add_linkman').val();//联系人
		var add_companyAddr_txt=$('#j_add_address').val();//办公地址
		var add_contract_number_txt=$('#j_add_contract-number').val();//合同编号
		var add_father_agentid_sel=$('#j_add_org-s').val();//上级组织机构
		var add_legal_tel_txt=$('#j_add_phone').val();//联系电话
		var add_org_area=$('#j_add_yw-are').val();//业务范围
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
		
		var add_handleUrl="http://127.0.0.1/gas_station_erp/index.php/configuration/Org/add_org";
		$.getJSON(add_handleUrl,{"add_agent_name_txt":add_agent_name_txt,"add_legal_txt":add_legal_txt,
								 "add_companyAddr_txt":add_companyAddr_txt,
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
	})

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
                            <label for="add_agent_type_sel">代理商类型</label>
                            <select style="width:164px" name="add_agent_type_sel" id="add_agent_type_sel" class="add_agent_type_sel">
                                <option selected value="">请选择</option>
                                <option class="industry" value="trade">行业型</option>
                                <option class="area" value="area">区域型</option>
                            </select>
                        </div>
                        <div class="info-right cf">

                            <label for="org-s">上级组织机构</label><input type="text" name="" id="org-s" class="input-org-info"/>
                            <label for="phone">联系电话</label><input type="text" name="" id="phone" class="input-org-info"/>
                            <label for="yw-are">业务范围</label><input type="text" name="" id="yw-are" class="input-org-info"/>
                            <label class="wenben">公司电话</label><input type="text" name="add_tel_txt" id="add_tel_txt" class="input-org-info" />
                            <em>
                                <label for="sq-date">授权日期</label><input type="text" name="" id="sq-date" class="input-org-info min-w"/>
                                <input type="text" name="" id="date" class="input-org-info min-w"/>
                                <input type="checkbox" name="" id="forver" class="org-input-c"/><label class="lab-ckbox" for="forver">永久</label>
                            </em>
                            <label class="add_agent_level_sel">代理商级别:&nbsp;</label>
                            <select style="width:164px" name="add_agent_level_sel" id="add_agent_level_sel" class="add_agent_level_sel">
                                <option selected="selected" value="">请选择</option>
                                <option class="one" value="1">一级代理商</option>
                                <option class="two" value="2">二级代理商</option>
                            </select>

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
                <label for="org">组织机构名称</label><input type="text" name="" id="j_add_org" class="input-org-info"/>
                <label for="linkman">联系人</label><input type="text" name="" id="j_add_linkman" class="input-org-info"/>
                <label for="address">办公地址</label><input type="text" name="" id="j_add_address" class="input-org-info"/>
                <label for="contract-number">合同编号</label><input type="text" name="" id="j_add_contract-number" class="input-org-info"/>
            </div>
            <div class="info-right cf">
                <label for="org-s">上级组织机构</label><input type="text" name="" id="j_add_org-s" class="input-org-info"/>
                <label for="phone">联系电话</label><input type="text" name="" id="j_add_phone" class="input-org-info"/>
                <label for="yw-are">业务范围</label><input type="text" name="" id="j_add_yw-are" class="input-org-info"/>
                <em>
                    <label for="sq-date">授权日期</label><input type="text" name="" id="j_add_sq-date" class="input-org-info min-w"/>
                    <input type="text" name="" id="j_add_date" class="input-org-info min-w"/>
                    <input type="checkbox" name="" id="j_add_forever_check" class="org-input-c"/><label class="lab-ckbox" for="forver">永久</label>
                </em>
            </div>
        </form>
        <div class="info-bottom">
            <button type="button" class="alert-btn" id="j_add_save">保存</button>
			<a href="." class="closeDOMWindow">
				 <button type="button" class="alert-btn">关闭</button>
			</a>
        </div>
    </div>
</div>

</body>
</html>