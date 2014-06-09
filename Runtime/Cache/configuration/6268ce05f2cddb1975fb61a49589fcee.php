<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>职员维护</title>
    <!--<link rel="stylesheet" href="../../Public/css/configuration.css"/>-->
	<link rel="stylesheet" href="	__PUBLIC__/css/configuration.css"/>

</head>
<body>
<div id="head">
    <h1 class="head-logo"><a href="index.html">ERP管理系统</a></h1>
    <h2 class="head-tt">111智能手机加油站ERP管理系统</h2>
    <div class="login">
        <div class="left">
            <ul class="left-nav">
                <li>赵洋,您好 <span></span>
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
            <li><a href="<?php echo U('configuration/Role/index');?>"><input type="button" class="" value="角色维护" ></a></li>
            <li class="active"><a href="<?php echo U('configuration/User/index');?>"><input type="button" class="" value="职员维护" ></a></li>
        </ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire">
                        <form name="userSelect" method="get" action="<?php echo U('configuration/User/show_user');?>">
                            <label for="user-name" class="">姓名</label>
                            <input type="text" name="realname_txt" id="realname_txt" class="input-org-info"/>
                            <label for="at-org" class="">所属组织机构</label>
                            <input type="text" name="org_name_txt" id="org_name_txt" class="input-org-info"/>
                            <label for="use-id" class="use-id">账号</label>
                            <input type="text" name="username_txt" id="username_txt" class="input-org-info"/>
                            <input type="submit" id="select_button" name="select_button" class="role-control-btn">
                        </form>
                    </div>
                    <div class="org-right-btns">
                        <form action="">
                            <button type="button" class="area-btn" id="j_add_button">添加</button>
                            <button type="button" class="area-btn" id="j_mod_button">编辑</button>
                            <button type="button" id="j_del_button" class="area-btn">删除</button>
                            <button type="button" id="j_reset_password" class="area-btn">重置密码</button>
                            <button type="button" id="j_modify_user_state" class="area-btn">激活/失效</button>
                        </form>
                    </div>
                </div>
                <div class="role-table over-h-y">
                    <ul class="role-table-list">
                        <li>
                            <span class="span-1"></span>
                            <span class="span-1"><b>姓名</b></span>
                            <span class="span-1"><b>性别</b></span>
                            <span class="span-1"><b>联系电话</b></span>
                            <span class="span-3"><b>所属组织机构</b></span>
                            <span class="span-2"><b>账号</b></span>
                            <span class="span-1"><b>角色</b></span>
                            <span class="span-1"><b>状态</b></span>
                        </li>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
								<span class="span-1">
									<input type="radio" name="radio1" id="<?php echo ($vo['userRadioID']); ?>" value="<?php echo ($vo['uid']); ?>"
										onclick="selectUserRadio('<?php echo ($vo['uid']); ?>');" class="role-table-radio"/>
								</span>
								<span class="span-1" title="#"><?php echo ($vo["realname"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["sex"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["telphone"]); ?></span>
								<span class="span-3" title="#"><?php echo ($vo["orgname"]); ?></span>
								<span class="span-2" title="#"><?php echo ($vo["username"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["rolename"]); ?></span>
								<span class="span-1" title="#"><?php echo ($vo["del_flag"]); ?></span>

							</li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
					<div class="resultpage"><?php echo ($page); ?></div>
            </div>
                <div class="role-table over-h-y">
                    <div class="data-log">
                        <h3>操作日志</h3>
                    </div>
                    <ul class="role-table-list role-table-list2">
                        <li>
                            <span class="span-3"><b>操作人</b></span>
                            <span class="span-3"><b>操作时间</b></span>
                            <span class="span-3"><b>操作日志</b></span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                        <li>
                            <span class="span-3" title="#">Lorem ipsum dolor sit amet.</span>
                            <span class="span-3" title="#">Beatae fugiat impedit ipsa porro!</span>
                            <span class="span-3" title="#">Atque corporis laudantium perspiciatis qui?</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
1111
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<div id="change_password_id" style="display:none;">
    <div class="alert-role-add" >
    <h3>修改密码</h3>
    <div class="alert-role-add-con">
        <p>
            <label for="old_password_txt" class="role-lab">旧密码&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="old_password_txt" id="old_password_txt" class="input-role-name"/>
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
						$('#change_password_id').hide();
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

<div id="j_mod_edit" style="display:none;">
    <div class="alert-role-add">
        <h3>编辑职员信息</h3>
        <div class="alert-user-add-con">
            <form action="">
                <p>
                    <label for="user-addname" class="role-lab">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</label>
                    <input type="text" name="addname" id="mod-name" class="input-role-name"/>
                    <input type="radio" name="change-sex" class="change-sex" id="mod-man" value="1"/><label for="man" class="sex">男</label>
                    <input type="radio" name="change-sex" class="change-sex" id="mod-woman" value="0"/><label for="woman" class="sex">女</label>
                </p>
                <p>
                    <label for="user-phone" class="role-lab">联系电话</label>
                    <input type="text" name="addname" id="mod-user-phone" class="input-role-name"/>
                </p>
                <p>
                    <label for="login-id" class="role-lab">登陆账号</label>
                    <input type="text" name="addname" id="mod-login-id" class="input-role-name"/>
                </p>
                <p>
                    <label for="login-id" class="email">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
                    <input type="text" name="addname" id="mod-email" class="input-role-name"/>
                </p>
                <div>
                    <em>角色</em>
                    <ul class="user-checkbox-list" id="j_mod_ul_checkbox">

                    </ul>
                </div>
                <p>
                    <label for="">所属组织机构:</label>
                <div class="content_wrap">
                    <div class="zTreeDemoBackground left">
                        <ul id="treeDemo1" class="ztree"></ul>
                    </div>
                </div>
                    <div id="menuContent1" class="menuContent" style="display:none; ">
                        <ul id="treeDemo1" class="ztree" style="margin-top:0; width:50px; height: auto;"></ul>
                    </div>
                <input type="hidden" value="" id="mod_id_hidden"/>
                </p>
                <p>
                    <button type="button" class="alert-btn2" id="j_mod_save">保存</button>
                    <a href="." class="closeDOMWindow">
                        <button type="button" class="alert-btn2">关闭</button>
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

<div id="j_add_win" style="display:none;">
    <div class="alert-role-add">
        <h3>添加职员信息</h3>
        <div class="alert-user-add-con">
            <form action="">
                <p>
                    <label for="user-addname" class="role-lab">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</label>
                    <input type="text" name="addname" id="user-addname" class="input-role-name"/>
                    <input type="radio" name="change-sex" class="change-sex" id="man" value="1"/><label for="man" class="sex">男</label>
                    <input type="radio" name="change-sex" class="change-sex" id="woman" value="0"/><label for="woman" class="sex">女</label>
                </p>
                <p>
                    <label for="user-phone" class="role-lab">联系电话</label>
                    <input type="text" name="addname" id="user-phone" class="input-role-name"/>
                </p>
                <p>
                    <label for="login-id" class="role-lab">登陆账号</label>
                    <input type="text" name="addname" id="login-id" class="input-role-name"/>
                </p>
                <p>
                    <label for="login-id" class="email">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
                    <input type="text" name="addname" id="email" class="input-role-name"/>
                </p>
                <div>
                    <em>角色</em>
                    <ul class="user-checkbox-list" id="j_ul_checkbox">

                    </ul>
                </div>
                <p>
                    <label for="">所属组织机构:</label>
                <div class="content_wrap">
                    <div class="zTreeDemoBackground left">
                        <ul id="treeDemo" class="ztree"></ul>
                    </div>
                </div>
                <div id="menuContent" class="menuContent" style="display:none; ">
                    <ul id="treeDemo" class="ztree" style="margin-top:0; width:50px; height: auto;"></ul>
                </div>
                <input type="hidden" value="" id="id_hidden"/>
                </p>
                <p>
                    <button type="button" class="alert-btn2" id="j_add_save">保存</button>
                    <a href="." class="closeDOMWindow">
                        <button type="button" class="alert-btn2">关闭</button>
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
	<div class="alert-role-add" >
		<h3>职员信息</h3>
		<div class="alert-role-add-con">
			<p class="delete-message">请确认是否删除？</p>
			<input type="hidden" value="" id="del_id_hidden"/>
			<p>
				<button type="button" class="alert-btn2" id="j_del_ok">确定</button>
				<a href="." class="closeDOMWindow">
					<button type="button" class="alert-btn2">关闭</button>
				</a>
			</p>
		</div>
	</div>
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<link rel="stylesheet" href="__PUBLIC__/css/tree/tree.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tree/jquery.ztree.excheck-3.5.js"></script>
<script>
	var user_val='';
	function selectUserRadio(user_id){
		user_val = user_id;
	}

    window.onscroll=function(){
        var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
        var fixDiv=document.getElementById('j-fixed-top');
        if(scrollTop>=300){
            fixDiv.style.position='fixed';
            fixDiv.style.top='0px';
        }else if(scrollTop<=299){
            fixDiv.style.position='static';
        }
    };

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

    //============

    $(document).ready(function () {
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
        $("#treeDemo a").click(function(){
          // alert($(this).attr("title"));
            $("#id_hidden").val($(this).attr("title"));
        });

        //单击编辑
        $('#j_mod_button').click(function(){

            //单击保存按钮
            $('#j_add_save').click(function(){
                var add_login_id= $('#mod-login-id').val(); //登陆账号
                var add_user_addname = $('#mod-name').val();      //姓名
                var add_telphone_txt = $('#mod-user-phone').val();      //联系电话
                var add_user_email = $('#mod-email').val();      //邮箱*/
                var add_user_sex = $(':radio[name="change-sex"]:checked').val(); //性别
                var add_org_id = $('#id_hidden').val();  //所属组织机构
                var add_user_ckbox="";
                $(":checkbox[name=role]").each(function() {
                    if ($(this).attr("checked")) {
                        add_user_ckbox += $(this).attr('id')+",";
                    }
                });

                var add_save_handleUrl="<?php echo U('configuration/User/edit_user');?>";
                $.getJSON(add_save_handleUrl,{
                            "modify_realname_txt":add_user_addname,
                            "modify_telphone_txt":add_telphone_txt,
                            "modify_email_txt":add_user_email,
                            "modify_user_name_txt":add_login_id,
                            "modify_sex_txt":add_user_sex,
                            "modify_org_txt":add_org_id,
                            "modify_role_txt":add_user_ckbox},
                        function (data){
                            alert(data);
                            window.location.href = window.location.href;
                        }
                        ,'json'
                )
            });
            $('#j_mod_ul_checkbox').html("");//清空
            //列出角色
            var handleUrl="<?php echo U('configuration/Role/show_all_role');?>";
            $.ajax({
                type: "POST",
                url: handleUrl,
                async: false,
                dataType: "json",
                success: function(data){
                    $.each(data,function(key,val){
                        var id=val['id'];
                        var value=val['value'];
                        $('#j_mod_ul_checkbox').append("<li><input type='checkbox' name='role' class='j_checkbox' value='"+value+"'  id='"+id+"'/><label for='ck1' class='role-lab'>"+value+"</label></li>");
                    });
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // alert("请求失败!");
                }
            });


            // alert(user_val);
            var mod_handleUrl="<?php echo U('configuration/User/userDetailSelect');?>";
            var arr=new Array();
            var str=new String();

            $.getJSON(mod_handleUrl,{ "user_id":user_val},
                    function (data){
                       //alert(data['username']);
                        $("#mod-name").val(data['realname']);
                        $("#mod-user-phone").val(data['telphone']);
                        $("#mod-login-id").val(data['username']);
                        $("#mod-email").val(data['email']);
                        str=data['rolename'];
                        arr=str.split(',');
                        for(var i=0;i<arr.length;i++)
                        {
                            var val=value=arr[i];
                            $("[value="+val+"]").attr("checked",true);
                            //$(".j_checkbox").val(arr[i]).attr("checked",true);
                            //alert();
                        }


                        var sex = data['sex'];
                        if(sex == '0'){
                            $('#mod-woman').eq(0).attr("checked",true);
                        }else{
                            $('#mod-man').eq(0).attr("checked",true);
                        }
                    }
                    ,'json'
            );

            //弹出窗口
            $.openDOMWindow({
                loader:1,
                loaderHeight:16,
                loaderWidth:17,
                windowSourceID:'#j_mod_edit'
            });
            return false;
        });
        //单击添加按钮
        $('#j_add_button').click(function(){
            //列出角色
            var handleUrl="<?php echo U('configuration/Role/show_all_role');?>";
            $.ajax({
                type: "POST",
                url: handleUrl,
                async: false,
                dataType: "json",
                success: function(data){
                    $.each(data,function(key,val){
                        var id=val['id'];
                        var value=val['value'];
                       // $("#j_ul").append("<li><input type='checkbox' id='"+id+"'/>"+value+"</li><br>");
                        $('#j_ul_checkbox').append("<li><input type='checkbox' name='role' value='"+value+"'  id='"+id+"'/><label for='ck1' class='role-lab'>"+value+"</label></li>");
                    });
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // alert("请求失败!");
                }
            });

            //单击保存按钮
            $('#j_add_save').click(function(){
                var add_login_id= $('#user-addname').val(); //登陆账号
                var add_user_addname = $('#login-id').val();      //姓名
                var add_telphone_txt = $('#user-phone').val();      //联系电话
                var add_user_email = $('#email').val();      //邮箱*/
                var add_user_sex = $(':radio[name="change-sex"]:checked').val(); //性别
                var add_org_id = $('#id_hidden').val();  //所属组织机构
                var add_user_ckbox="";
                $(":checkbox[name=role]").each(function() {
                    if ($(this).attr("checked")) {
                        add_user_ckbox += $(this).attr('id')+",";
                    }
                });

                var add_save_handleUrl="<?php echo U('configuration/User/add_user');?>";
                $.getJSON(add_save_handleUrl,{
                            "add_user_name_txt":add_user_addname,
                            "add_telphone_txt":add_telphone_txt,
                            "add_email_txt":add_user_email,
                            "add_realname_txt":add_login_id,
                            "add_sex_txt":add_user_sex,
                            "add_org_txt":add_org_id,
                            "add_role_txt":add_user_ckbox},
                            function (data){
                                alert(data);
                                window.location.href = window.location.href;
                            }
                            ,'json'
                    )
            });

            //弹出窗口
            $.openDOMWindow({
                loader:1,
                loaderHeight:16,
                loaderWidth:17,
                windowSourceID:'#j_add_win'
            });
            return false;
        });

            $('#j_del_button').click(function(){
			 $.openDOMWindow({
			    loader:1,
				loaderHeight:16,
				loaderWidth:17,
				windowSourceID:'#j_del_win'
		     });
             return false;
        });

		//单击删除确认按钮
        $('#j_del_ok').click(function(){
            var delete_user_id_txt= user_val;
            var del_handleUrl="<?php echo U('configuration/User/delete_user');?>";
            $.getJSON(del_handleUrl,{"delete_user_id_txt":delete_user_id_txt},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

		//重置密码
        $('#j_reset_password').click(function(){
            var reset_userid_txt= user_val;
            var del_handleUrl="<?php echo U('configuration/User/reset_password');?>";
            $.getJSON(del_handleUrl,{"reset_userid_txt":reset_userid_txt},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

		//激活失效
        $('#j_modify_user_state').click(function(){
            var modify_userid_txt= user_val;
            var del_handleUrl="<?php echo U('configuration/User/modify_user_state');?>";
            $.getJSON(del_handleUrl,{"modify_userid_txt":modify_userid_txt},
                    function (data){
                        alert(data);
                        window.location.href = window.location.href;
                    }
                    ,'json'
            );
        });

	});
</script>
</body>
</html>