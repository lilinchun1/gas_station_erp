<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>版本升级</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>


    <script type="text/javascript">
        $(function(){
            //================================================================默认动作

            //禁止浏览器自动填充
            $("form").attr( "autocomplete","off");
            //================================================================触发操作
            //创建，编辑弹出框
            $('.status_add,.status_udp').click(function(){
                if($(this).hasClass("status_udp")){
                    var rule_status = $("input[name='role-info']:checked").parent().parent().find(".rule_status_list").val();
                    if(rule_status >= 2){
                        alert("不能编辑");
                        return;
                    }
                    var rule_no = $("input[name='role-info']:checked").parent().parent().find(".rule_no_list").text();
                    var start_time = $("input[name='role-info']:checked").parent().parent().find(".start_time_list").text();
                    if(rule_no == ""){
                        alert("请选择编辑条目");
                        return;
                    }
                    $("#rule_no").val(rule_no);
                    $("#start_time").val(start_time);
                }
                $.openDOMWindow({
                    loader:1,
                    loaderHeight:16,
                    loaderWidth:17,
                    windowSourceID:'#j_add_win'
                });
                return false;
            });


            //删除，发布，作废弹出框
            $(".status_del,.status_2,.status_3").click(function(){
                //获取状态值
                var rule_status = $("input[name='role-info']:checked").parent().parent().find(".rule_status_list").val();
                if($(this).hasClass("status_del")){
                    var noSelMes = "请选择删除条目";
                    //改变确认框内容
                    $(".delete-message").text("确认删除？");
                    $(".del_fb_zf").text("删除");
                    $(".del_fb_zf").val("1");
                    if(rule_status >= 2){
                        alert("不能删除");
                        return;
                    }
                }else if($(this).hasClass("status_2")){
                    var noSelMes = "请选择要发布条目";
                    $(".delete-message").text("确认发布？");
                    $(".del_fb_zf").text("发布");
                    $(".del_fb_zf").val("2");
                    if(rule_status != 1){
                        alert("不能发布");
                        return;
                    }
                }else if($(this).hasClass("status_3")){
                    var noSelMes = "请选择要作废条目";
                    $(".delete-message").text("确认作废？");
                    $(".del_fb_zf").text("作废");
                    $(".del_fb_zf").val("3");
                    if(rule_status != 2){
                        alert("不能作废");
                        return;
                    }
                }

                var rule_no = $("input[name='role-info']:checked").parent().parent().find(".rule_no_list").text();
                if(rule_no == ""){
                    alert(noSelMes);
                    return;
                }
                $("#rule_no_hid").val(rule_no);

                //弹出页面
                $.openDOMWindow({
                    loader:1,
                    loaderHeight:16,
                    loaderWidth:17,
                    windowSourceID:'#j_del_win'
                });
                return false;
            });
            //点一行则选中
            $(".rule_info_list").click(function(){
                $(this).find(".role-table-radio").attr("checked",true);
            });

        });
        //根据选择范围圈定应用名称下拉内容
        function getAppRule() {
            $.post("<?php echo U('management/Index/getAppRule');?>", {'sad':1}, function(data) {
                var str = data;
                //str = [{title:"中国移动网上营业厅"},{title:"中国银行"},{title:"中国移动"},{title:"中国好声音第三期"},{title:"中国好声音 第一期"},{title:"中国电信网上营业厅"},{title:"中国工商银行"},{title:"中国好声音第二期"},{title:"中国地图"}];
                $("#rule_no").bigAutocomplete({
                    width : 150,
                    data : str,
                    callback : function(data) {
                    }
                });
            }, "json");
        }
    </script>
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

<div id="container">
    <div class="left">
        
<ul class="aside-nav">
    <li class="aside-nav-nth1" ><a>刊例管理<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="<?php echo U('management/Index/importingApp');?>"><a href="<?php echo U('management/Index/importingApp');?>"><input type="button" value="刊例维护"></a></li>
            <li class="url_link" url="<?php echo U('management/Index/addRuleTarget');?>"><a href="<?php echo U('management/Index/addRuleTarget');?>"><input type="button" class="" value="刊例发布"></a></li>
            <li class="url_link" url="<?php echo U('management/Index/verup');?>"><a href="<?php echo U('management/Index/verup');?>"><input type="button" class="" value="版本升级"></a></li>
        </ul>
    </li>
</ul>

        <!--<ul class="aside-nav">
            <li class="aside-nav-nth1"><a href="">APP刊例管理</a></li>
            <li><a href="<?php echo U('management/Index/importingApp');?>"><input type="button" value="刊例维护"></a></li>
            <li><a href="<?php echo U('management/Index/addRuleTarget');?>"><input type="button" class="" value="刊例发布"></a></li>
            <li class="active"><a href="<?php echo U('management/Index/verup');?>"><input type="button" class="" value="版本升级"></a></li>
        </ul>-->
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire channel-index-btns">
                        <form action="" method="post">
                            <p>
                                <label for="channel-org-name" class="">主程序</label>
                                <input type="text" name="rule_no_sel" id="channel-org-name" class="input-org-info"/>
                                <label for="maintain-create-people" class="">smartapp</label>
                                <input type="text" name="createuser_sel" id="maintain-create-people"
                                       class="input-org-info"/>
                                <label for="maintain-create-date" class="">广告播放程序</label>
                                <input type="text" name="rule_no_sel" id="maintain-create-date" class="input-org-info"/>
                                <button type="submit" name="select" class="role-control-btn">查询</button>
                            </p>
                        </form>
                    </div>
                    <div class="org-right-btns">
                        <form action="">
                            <button type="button" class="area-btn status_add">创建</button>
                            <button type="button" class="area-btn status_udp">编辑</button>
                            <button type="button" class="area-btn status_del">删除</button>
                            <button type="button" class="area-btn status_2">更新</button>
                        </form>
                    </div>
                </div>
                <div class="role-table">
                    <div class="bd over-h-y">
                        <ul class="role-table-list">
                            <li>
                                <span class="span-1"></span>
                                <span class="span-2"><b>主程序</b></span>
                                <span class="span-2"><b>smartapp</b></span>
                                <span class="span-2"><b>广告播放程序</b></span>
                                <span class="span-1"><b>发布渠道</b></span>
                                <span class="span-1"><b>发布状态</b></span>
                                <span class="span-2"><b>更新日期</b></span>
                                <span class="span-1"><b>更新信息</b></span>
                            </li>
                           <li>
                               <span class="span-1"><input type="radio" name="role-info" id="" class="role-table-radio"/></span>
                               <span class="span-2">Lorem ipsum dolor sit amet, consectetur.</span>
                               <span class="span-2">At error officiis provident quaerat sit.</span>
                               <span class="span-2">Corporis distinctio esse eum fugiat repudiandae?</span>
                               <span class="span-1"><a href="" class="fthover">发布渠道</a></span>
                               <span class="span-1">Aliquid consequuntur molestiae omnis quibusdam vel!</span>
                               <span class="span-2">Alias at aut hic laudantium quae.</span>
                               <span class="span-1"><a href="" class="fthover">更新信息</a></span>
                           </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<!--创建弹出框-->
<div class="alert-org-add" id="j_add_win" style=" display:none;">
    <div class="verup-alert-add">
        <form action="" method="post">
            <h3>版本信息</h3>
            <div class="verup-alert-con">
                <div class="verup-alert-con-left">
                    <p>
                        <label for="main-pg">SmartApp</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                    <p>
                        <label for="main-pg">VideoPlayer</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                    <p>
                        <label for="main-pg">UpdateApp</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                    <p>
                        <label for="main-pg">SmartGuard</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                </div>
                <div class="verup-alert-con-right">
                    <p>发布渠道</p>
                    <div class="verup-tree-tab">
                        <a href="" class="active">所属区域</a>
                        <a href="">渠道类型</a>
                    </div>
                </div>
                <div class="alt-btn-sc cf">
                    <button type="submit" name="add_udp" class="alert-btn4" value="1">保存</button>
                    <a href="." class="closeDOMWindow">
                        <button type="button" class="alert-btn">关闭</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!--编辑弹出框-->
<div class="alert-org-add" id="j_edit_win" style=" display:none;">
    <div class="verup-alert-add">
        <form action="" method="post">
            <h3>版本信息</h3>
            <div class="verup-alert-con">
                <div class="verup-alert-con-left">
                    <p>
                        <label for="main-pg">SmartApp</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                    <p>
                        <label for="main-pg">VideoPlayer</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                    <p>
                        <label for="main-pg">UpdateApp</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                    <p>
                        <label for="main-pg">SmartGuard</label>
                        <input type="text" name="" id="main-pg" class="input-org-info"/>
                        <button class="role-control-btn">浏览</button>
                    </p>
                </div>
                <div class="verup-alert-con-right">
                    <p>发布渠道</p>
                    <div class="verup-tree-tab">
                        <a href="" class="active">所属区域</a>
                        <a href="">渠道类型</a>
                    </div>
                </div>
                <div class="alt-btn-sc cf">
                    <button type="submit" name="add_udp" class="alert-btn4" value="1">保存</button>
                    <a href="." class="closeDOMWindow">
                        <button type="button" class="alert-btn">关闭</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!--删除确认框-->
<div class="divout" id="j_del_win" style="display:none;">
    <div class="alert-role-add" >
        <form action="" method="post">
            <h3>期刊</h3>
            <div class="alert-role-add-con">
                <p class="delete-message">确认删除？</p>
                <p>
                    <input type="hidden" name="rule_no_hid" id="rule_no_hid" value=""/>
                    <button type="submit" name="del_fb_zf" class="alert-btn2 del_fb_zf" id="j_del_ok" value="1">删除</button>
                    <a href="." class="closeDOMWindow">
                        <button type="button" class="alert-btn2">关闭</button>
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
<!--发布渠道弹出框-->
<!--<div class="alert-org-add" id="j_edit_win" style=" display:none1;">
    <div class="verup-alert-add">
        <form action="" method="post">
            <h3>发布渠道</h3>
            <div class="verup-alert-con">

                <div class="verup-alert-con-right">
                    <p>发布渠道</p>
                </div>
                <div class="alt-btn-sc cf">
                    <button type="submit" name="add_udp" class="alert-btn2" value="1">保存</button>
                    <a href="." class="closeDOMWindow">
                        <button type="button" class="alert-btn">关闭</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>-->
<!--更新信息弹出框-->
<!--<div class="alert-org-add" id="j_edit_win" style=" display:none1;">
    <div class="verup-alert-add">
        <form action="" method="post">
            <h3><span class="verup-alert-close">x</span></h3>
            <div class="verup-alert-con">
                <div class="verup-alert-query">
                    <label>区域</label>
                    <select class="channel-select-min">
                        <option>选择省份</option>
                    </select>
                    <select class="channel-select-min">
                        <option>选择城市</option>
                    </select>
                    <input name="" id="" value="" placeholder="渠道模糊查询" class="input-org-info"/>&nbsp;&nbsp;&nbsp;
                    <input name="" id="" value="" placeholder="网点模糊查询" class="input-org-info"/>
                    <button type="button" class="alert-btn3">查询</button>
                </div>
                <div class="verup-tree-tab gengxin-up">
                    <a href="" class="active">更新成功</a>
                    <a href="">更新失败</a>
                    <button type="button" class="alert-btn4">导出</button>
                </div>
                <div class="verup-alert-list">
                    <ul id="j-station-sh1" class="verup-list-con">
                        <li>
                            <span>省份</span>
                            <span>城市</span>
                            <span>渠道名称</span>
                            <span>所属网点</span>
                            <span>MAC</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>

                    </ul>
                    <ul id="j-station-sh2" class="verup-list-con">
                        <li>
                            <span>省份</span>
                            <span>城市</span>
                            <span>渠道名称</span>
                            <span>所属网点</span>
                            <span>MAC</span>
                        </li>
                        <li>
                            <span> ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>
                        <li>
                            <span>Lorem ipsum dolor.</span>
                            <span>Labore, officia quidem?</span>
                            <span>Aut, obcaecati reiciendis?</span>
                            <span>Cum, enim, nihil.</span>
                            <span>Nesciunt, optio quo!</span>
                        </li>

                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/jquery.bigautocomplete.css"/>
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script type="text/javascript">
    getAppRule();
    $(function(){
        $('.gengxin-up a:eq(0)').click(function () {
            $('#j-station-sh1').show();
            $('#j-station-sh2').hide();
            $(this).addClass('active');
            $('.gengxin-up a:eq(1)').removeClass();
            return false;
        });
        $('.gengxin-up a:eq(1)').click(function () {
            $('#j-station-sh1').hide();
            $('#j-station-sh2').show();
            $(this).addClass('active');
            $('.gengxin-up a:eq(0)').removeClass();
            return false;
        });
    })
</script>
</div>
</body>
</html>