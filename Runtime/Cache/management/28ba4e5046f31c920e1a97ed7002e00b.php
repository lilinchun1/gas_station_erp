<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>网点信息</title>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>

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
            <a href="<?php echo U('configuration/Login/logout');?>">退出系统</a>
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
		$('#change_password_id').show();
	}
</script>
<div id="container">
    <div class="left">
        <ul class="aside-nav">
            <li class="aside-nav-nth1"><a href="">APP刊例管理</a></li>
            <li><a href="<?php echo U('management/Index/importingApp');?>"><input type="button" value="刊例维护"></a></li>
            <li class="active"><a href="<?php echo U('management/Index/addRuleTarget');?>"><input type="button" class="" value="刊例发布"></a></li>

        </ul>
    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire channel-index-btns">
                        <form action="" method="post">
                            <p>
                                <label for="channel-org-name" class="">刊例名称</label>
                                <input type="text" name="rule_no_sel" id="channel-org-name" class="input-org-info"/>
                                <label for="maintain-create-people" class="">创建人</label>
                                <input type="text" name="createuserid_sel" id="maintain-create-people"
                                       class="input-org-info"/>
                                <label for="maintain-create-date" class="">发布日期</label>
                                <input type="date" name="release_time_sel" id="maintain-create-date"
                                       class="input-org-info"/>
                                <button type="submit" class="role-control-btn">查询</button>
                            </p>
                        </form>
                    </div>
                    <div class="org-right-btns">
                        <form action="">
                            <button type="button" class="area-btn">添加</button>
                            <button type="button" class="area-btn">编辑</button>
                            <button type="button" class="area-btn">删除</button>
                            <button type="button" class="area-btn">发布</button>
                            <button type="button" class="area-btn">作废</button>
                        </form>
                    </div>
                </div>
                <div class="role-table">
                    <div class="bd over-h-y">
                        <ul class="role-table-list">
                            <li>
                                <span class="span-1"></span>
                                <span class="span-2"><b>刊例名称</b></span>
                                <span class="span-2"><b>投放日期</b></span>
                                <span class="span-2"><b>发布渠道</b></span>
                                <span class="span-2"><b>发布状态</b></span>
                                <span class="span-2"><b>发布日期</b></span>
                            </li>
                            <?php if(is_array($issueArr)): foreach($issueArr as $key=>$issue): ?><li>
                                    <span class="span-1"><input type="radio" name="role-info" id=""
                                                                class="role-table-radio"/></span>
                                    <span class="span-2" title="#"><?php echo ($issue["rule_no"]); ?></span>
                                    <span class="span-2" title="#"><?php echo ($issue["start_time"]); ?></span>
                                    <span class="span-2" title="#">发布渠道</span>
	                                <span class="span-2" title="#">
	                                	<?php if($issue['rule_status'] == 1): ?>发布<?php endif; ?>
										<?php if($issue['rule_status'] == 2): ?>作废<?php endif; ?>
	                                </span>
                                    <span class="span-2" title="#"><?php echo ($issue["release_time"]); ?></span>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
1111
</div>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<div id="change_password_id" class="alert-role-add" style="display:none;">
    <h3>修改密码</h3>
    <div class="alert-role-add-con">
        <p>
            <label for="old-pass" class="role-lab">旧密码&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="old_password_txt" id="old_password_txt" class="input-role-name"/>
        </p>
        <p>
            <label for="new-pass" class="role-lab">新密码&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="new_password_txt" id="new_password_txt" class="input-role-name"/>
        </p>
        <p>
            <label for="rnew-pass" class="role-lab">确认密码</label>
            <input type="password" name="re_new_password_txt" id="re_new_password_txt" class="input-role-name"/>
        </p>
        <p>
            <button type="button" class="alert-btn2" onclick="change_password()">修改密码</button>

        </p>
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

    function headAct(){
        var Ourl = window.location.href;
        if(!document.getElementById('j-nav-active')){return;};
        var Onav = document.getElementById('j-nav-active');
        var nbLi = Onav.getElementsByTagName('li');
        for(var i=0; i<nbLi.length;i++){
            if(Ourl=="/gas_station_erp/index.php/Org/index"||Ourl.indexOf("/gas_station_erp/index.php/Org/index")>=0||Ourl=="/gas_station_erp/index.php/Role/index"||Ourl.indexOf("/gas_station_erp/index.php/Role/index")>=0||Ourl=="/gas_station_erp/index.php/User/index"||Ourl.indexOf("/gas_station_erp/index.php/User/index")>=0){
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


<div class="alert-role-add">
    <h3>刊例信息</h3>

    <div class="alert-role-add-con">
        <p>
            <label for="issue-name" class="role-lab">*刊例名称</label>
            <input type="text" name="addname" id="issue-name" class="input-role-name"/>
        </p>

        <p>
            <label for="issue-date" class="role-lab">*投放日期</label>
            <input type="date" name="addname" id="issue-date" class="input-role-name"/>
        </p>

        <p>
            <label for="issue-channel" class="role-lab">*发布渠道</label>
            <input type="text" name="addname" id="issue-channel" class="input-role-name"/>
        </p>

        <p>
            <button type="button" class="alert-btn2">保存</button>
            <button type="button" class="alert-btn2">关闭</button>
        </p>
    </div>
</div>
<script type="text/javascript" src="../../Public/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="../../Public/js/jquery.SuperSlide.2.1.1.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script>
    window.onscroll = function () {
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        var fixDiv = document.getElementById('j-fixed-top');
        if (scrollTop >= 300) {
            fixDiv.style.position = 'fixed';
            fixDiv.style.top = '0px';
        } else if (scrollTop <= 299) {
            fixDiv.style.position = 'static';
        }
    }
</script>
<script type="text/javascript">jQuery(".role-table").slide({trigger: "click"});</script>
</body>
</html>