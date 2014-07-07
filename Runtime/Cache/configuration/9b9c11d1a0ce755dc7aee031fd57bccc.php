<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>默认页</title>
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
   <!--<div class="default-index">
       <div class="default-index-tt">

       </div>
       <div class="pic-dp">

       </div>
       <div class="default-index-wz">
           <h1></h1>
           <em>自由定制投放方案，个性高效，全城到达每个广告位都期待被您征服，色彩出众画面亮丽，高质的音频输出，保证每个视频、图片、文字的精彩播放。</em>
       </div>
   </div>-->
    <div class="default-index">
     
			<div id="demo2" class="jcSlider">
				<ul class="imgList">
					<li><a><img src="__PUBLIC__/image/pic/30f0184c74d88e5e4f6b2b0304a5a59c.png" alt="图片一" /></a></li>
					<li><a><img src="__PUBLIC__/image/pic/c4abb1b84dc468f3da68c37898e18f09.png" alt="图片二" /></a></li>
					<li><a><img src="__PUBLIC__/image/pic/5b387eab0c69dc3da4a51b6f4fb8576b.png" alt="图片三" /></a></li>
					<li><a><img src="__PUBLIC__/image/pic/a96bf5b093e42062f8d60357a3113ae2.png" alt="图片四" /></a></li>
				</ul>
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
	<script>
		$(document).ready(function(){
			$("#j-nav-active").find('li').attr("class","");
		})
	</script>
</body>
	<link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
	<link href="__PUBLIC__/css/pic/public.css" rel="stylesheet" type="text/css" media="all" />
	<script src="__PUBLIC__/js/pic/jQuery-easing.js" language="javascript" type="text/javascript"></script>
	<script src="__PUBLIC__/js/pic/jQuery-jcSlider.js" language="javascript" type="text/javascript"></script>
	<style>
	
	.jcSlider { width:956px; position:relative; height:300px; background:url(__PUBLIC__/image/pic/sliderbg.png) no-repeat; padding:9px;}
	.imgHide { width:956px; height:300px; overflow:hidden; position:relative; }
	.imgList { height:9999%; width:9999%; position:absolute; top:0; left:0; z-index:1;}
	.imgList li { position:absolute; left:0; top:0; height:300px; width:956px; list-style:none; display:none; overflow:hidden; }
	.imgNum { position:absolute; left:0; top:0; z-index:2; display:none; }
	.imgNum dd { width:14px; height:14px; float:left; list-style:none; cursor:pointer;  margin:0 3px; overflow:hidden; }
	.imgNum dd a { display:block; height:14px; width:14px; text-indent:-999em; overflow:hidden; text-align:center; line-height:14px; background:url(__PUBLIC__/image/pic/pagination.png) no-repeat 0 0; }
	.imgNum dd a:hover,.imgNum dd.select a { background-position:0 -14px; }
	.imgPrev,.imgNext { position:absolute; left:0; top:10px; z-index:3; display:block; cursor:pointer; height:300px; width:40px; }
	.imgPrev { background:url(__PUBLIC__/image/pic/navigation-previous.png) no-repeat left center;}
	.imgNext { background:url(__PUBLIC__/image/pic/navigation-next.png) no-repeat right center;}

	/* demo2 add css */
	#demo2 .imgNum dd { width:24px; height:24px; float:left; list-style:none; cursor:pointer;  margin:0 4px; overflow:hidden; }
	#demo2 .imgNum dd a { display:block; height:24px; width:24px; overflow:hidden; text-indent:0; text-align:center; line-height:24px; background:url(__PUBLIC__/image/pic/NumBtn.png) no-repeat 0 -27px; color:#000; font-size:13px; }
	#demo2 .imgNum dd a:hover,#demo2 .imgNum dd.select a {  background-position:0 0; color:#fff; }
	</style>

	<script language="javascript" type="text/javascript">
		$(function(){
			$("#demo2").jcSlider({
				speed:"easeInOutQuart",
				Default : 1,
				setMode:'x',
				loadPath:'img/loading.gif',
				setloadSize : {
					loadWidth : 32,
					loadHeight : 32 
				},
				autoPlay:true,
				autoTime:1500,
				arrow : false,
				numBtn:true,
				numBtnEvent:'mouseover', 
				numBtnPos:'right', 
				setNumBtn : {
					x : 0,
					y : 275
				},
				scaling:false
			});
		});
	</script>

</html>