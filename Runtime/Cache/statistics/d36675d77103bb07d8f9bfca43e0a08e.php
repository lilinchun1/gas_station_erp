<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>广告维护</title>
    <link rel="stylesheet" href="__PUBLIC__/css/configuration.css"/>
    <link rel="stylesheet" href="../../Public/css/configuration.css"/>
    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="__PUBLIC__/js/script_city.js"></script>
    <style>
        #head,.head-wrap,#footer{
            min-width: 990px;
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
<div id="nav" class="top_link">
    <ul class="main-nav" id="j-nav-active"></ul>
</div>
<SCRIPT type="text/javascript">
var getTopLink = "<?php echo U('configuration/User/getTopLink');?>";
$.ajax({
	url            : getTopLink,
	type           : "get",
	dataType       : "json",
	async          : false,
	success        : function(data, textStatus){
    	$(".top_link ul li").remove();
        $.each(data,function(i,n){
        	$(".top_link ul").append("<li class='url_link topLink' url=\"'"+n['url']+"'\"><a href='"+n['url']+"'>"+n['top_name']+"</a></li>");
        });
    }

});
</SCRIPT>
</div>

<div id="container" style="min-width: 990px">
    <div class="left">
        
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>运营分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('statistics/Index/index');?>'"><a href="<?php echo U('statistics/Index/index');?>"><input type="button" value="安装量分析"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/user_statistics');?>'"><a href="<?php echo U('statistics/Index/user_statistics');?>"><input type="button" value="app排名"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_analysis');?>'"><a href="<?php echo U('statistics/Index/ad_analysis');?>"><input type="button" value="广告分析"></a></li>
            <!--<li class="url_link" url="'<?php echo U('statistics/Index/ad_play');?>'"><a href="<?php echo U('statistics/Index/ad_play');?>"><input type="button" value="广告播放"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_maintain');?>'"><a href="<?php echo U('statistics/Index/ad_maintain');?>"><input type="button" value="广告维护"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/app_installed');?>'"><a href="<?php echo U('statistics/Index/app_installed');?>"><input type="button" value="App安装量"></a></li>-->
        </ul>
    </li>
</ul>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>客户报表<i class="j-show-list">-</i></a>
        <ul>
            <!--<li class="url_link" url="'<?php echo U('statistics/Index/index');?>'"><a href="<?php echo U('statistics/Index/index');?>"><input type="button" value="安装量分析"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/user_statistics');?>'"><a href="<?php echo U('statistics/Index/user_statistics');?>"><input type="button" value="app排名"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_analysis');?>'"><a href="<?php echo U('statistics/Index/ad_analysis');?>"><input type="button" value="广告分析"></a></li>-->
            <li class="url_link" url="'<?php echo U('statistics/Index/app_installed');?>'"><a href="<?php echo U('statistics/Index/app_installed');?>"><input type="button" value="安装量明细"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_play');?>'"><a href="<?php echo U('statistics/Index/ad_play');?>"><input type="button" value="广告播放明细"></a></li>
            <li class="url_link" url="'<?php echo U('statistics/Index/ad_maintain');?>'"><a href="<?php echo U('statistics/Index/ad_maintain');?>"><input type="button" value="广告维护"></a></li>
        </ul>
    </li>
</ul>
<!--
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>用户分析<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('statistics/Index/user_behavior');?>'"><a href="<?php echo U('statistics/Index/user_behavior');?>"><input type="button" value="用户行为分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>App分析<i class="j-show-list">-</i></a>
        <ul>

            <li class="url_link" url="'<?php echo U('statistics/Index/app_analysis');?>'"><a href="<?php echo U('statistics/Index/app_analysis');?>"><input type="button" value="App分析"></a></li>
        </ul>
    </li>
</ul>
<div class="bk10 bdb-das"></div>
<ul class="aside-nav">
    <li class="aside-nav-nth1"><a>报表数据<i class="j-show-list">-</i></a>
        <ul>
            <li class="url_link" url="'<?php echo U('statistics/Index/installed_daily');?>'"><a href="<?php echo U('statistics/Index/installed_daily');?>"><input type="button" value="安装量日报"></a></li>
        </ul>
    </li>
</ul>-->

    </div>
    <div class="right">
        <div class="right-con">
            <div class="org-right-con">
                <div class="role-control" id="j-fixed-top">
                    <div class="role-inquire channel-index-btns">
                        <form id="formid" name="channelSelect" method="get" action="">
                            <p>
                                <label for="channel-class1" class="">组织机构</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select">
                                    <option value="">总公司</option>
                                </select>
                                <label for="channel-org-name" class="">广告商名称</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                                <label for="channel-org-name" class="">素材名称</label>
                                <input type="text" name="channel-org-name" id="channel-org-name"  class="input-org-info"
                                       value=""/>
                                <label for="channel-class1" class="">素材类型</label>
                                <select name="channel_first_type_sel" id="channel-class1" class="channel-select">
                                    <option value="">全部</option>
                                </select>
                                <input type="button" id="do_search_bt" class="role-control-btn" value="查询" />
                            </p>
                            <div class="org-right-btns">
                                <form action="">
                                    <button type="button" class="area-btn" id="b_add_place">添加</button>
                                    <button type="button" class="area-btn" id="b_change_place">编辑</button>
                                    <button type="button" id="j_del_button" class="area-btn">删除</button>
                                    <button type="button" id="j_repeal_button" class="area-btn">导出</button>
                                </form>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="role-table station-chart">
                    <div class="list-wrap-statistics">
                        <div class="role-table">
                            <ul class="statistics-list">
                                <li>
                                    <span class="span-haf1"></span>
                                    <span class='span-1'><b>素材ID</b></span>
                                    <span class='span-1'><b>组织机构名称</b></span>
                                    <span class='span-1'><b>广告商名称</b></span>
                                    <span class='span-1'><b>素材名称</b></span>
                                    <span class='span-1'><b>素菜类型</b></span>
                                    <span class='span-1'><b>单次指定播放时长</b></span>
                                    <span class='span-1'><b>md5</b></span>
                                    <span class='span-1'><b>上架日期</b></span>
                                    <span class='span-1'><b>下架日期</b></span>
                                </li>
                                <li>
                                    <span class="span-haf1">
                                        <input type="radio" name="chid" value="" class="role-table-radio"/>
                                    </span>
                                    <span class="span-1" title="">111111111</span>
                                    <span class="span-1" title="">222222222</span>
                                    <span class="span-1" title="">333333333</span>
                                    <span class="span-1" title="">444444444</span>
                                    <span class="span-1" title="">555555555</span>
                                    <span class="span-1" title="">666666666</span>
                                    <span class="span-1" title="">777777777</span>
                                    <span class="span-1" title="">888888888</span>
                                    <span class="span-1" title="">999999999</span>
                                </li>
                                <li>
                                    <span class="span-haf1">
                                        <input type="radio" name="chid" value="" class="role-table-radio"/>
                                    </span>
                                    <span class="span-1" title="">111111111</span>
                                    <span class="span-1" title="">222222222</span>
                                    <span class="span-1" title="">333333333</span>
                                    <span class="span-1" title="">444444444</span>
                                    <span class="span-1" title="">555555555</span>
                                    <span class="span-1" title="">666666666</span>
                                    <span class="span-1" title="">777777777</span>
                                    <span class="span-1" title="">888888888</span>
                                    <span class="span-1" title="">999999999</span>
                                </li>
                            </ul>
                            <div class="resultpage"><?php echo ($page); ?></div>
                        </div>
                    </div>
                </div>

                <div class="bk3">

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
        //headAct();

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
<div class="alert-org-add" id="j_add_win" style=" display:block;">
    <div class="org-right-info" id="add">
        <h3>组织机构信息</h3>
        <form action="">
            <div class="info-left cf">
                <label for="org">组织机构</label><input type="text" name="" id="j_add_org" class="input-org-info long-input"/><i class="red-color pdl10">*</i>
                <label for="linkman">素材名称</label><input type="text" name="" id="j_add_linkman" class="input-org-info"/><i class="red-color pdl10">*</i>
                <label for="address">md5</label><input type="text" name="" id="j_add_address" class="input-org-info"/><i class="red-color pdl10">*</i>
                <label for="contract-number">上架日期</label><input type="text" name="" id="j_add_contract-number" class="input-org-info"/>
            </div>
            <div class="info-right cf">
                <label for="org-s">广告商名称</label><input type="text" name="" id="j_add_org-s" class="input-org-info long-input" /><i class="red-color pdl10">*</i>
                <label for="phone">素材类型</label><input type="text" name="" id="j_add_phone" class="input-org-info"/>
                <label for="wenben">单次播放时长</label><input type="text" name="add_tel_txt" id="add_tel_txt" class="input-org-info" />&nbsp;&nbsp;&nbsp;秒<i class="red-color pdl10">*</i>
                <label for="yw-are">下架日期</label><input type="text" name="" id="restxts" class="input-org-info" readonly/>

            </div>
        </form>
        <div class="info-bottom">
            <button type="button" class="alert-btn" id="j_add_save">保存</button>

            <button type="button" class="alert-btn" id="j_close">关闭</button>

        </div>
    </div>
</div>

<script type="text/javascript" src="__PUBLIC__/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.DOMwindow.js" type="text/javascript"></script><!--模框JS插件-->
<link rel="stylesheet" href="__PUBLIC__/css/jquery.bigautocomplete.css" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery.bigautocomplete.js"></script>
<script language="javascript">
$("#all_export_execl_bt").click(function (){
    var url = "<?php echo U('statistics/export/all_export');?>";
    $("#formid").attr("action",url);
    $("#formid").submit();
});

$("#do_search_bt").click(function (){
    var url = "<?php echo U('statistics/Index/installed_daily_doseach');?>";
    $("#formid").attr("action",url);
    $("#formid").submit();
});
function succ_num_click(which){
    var select_id=$(which).parent().find(".select_id").val();
    ajax_post(select_id,0);

    $("#succ_export_bt").attr("onclick","downexelc('"+select_id+"','succ')");

}
function fail_num_click(which){
    var select_id=$(which).parent().find(".select_id").val();
    ajax_post(select_id,1);
    $("#fail_export_bt").attr("onclick","downexelc('"+select_id+"','fail')");
}
function unfind_num_click(which){
    var select_id=$(which).parent().find(".select_id").val();
    ajax_post(select_id,2);

    $("#undefine_export_bt").attr("onclick","downexelc('"+select_id+"','unfind')");
}
var p=1;
function ajax_post(select_id,showModel){
    $(".select_li").remove();//初始化
    $(".resultpage").remove();//初始化
    var url="<?php echo U('statistics/Index/ajax_report');?>";
    $.ajax({
        type : "post",						//post方式
        url : url,							//ajax查询url
        data : {"select_id":select_id,"showModel":showModel,"pageNum":p},	//参数
        async : false,						//同步方式，便于拿到返回数据做统一处理
        dataType: "json",
        beforeSend : function (){ },		//ajax查询请求之前动作，比如提示信息……
        success : function (data) {			//ajax请求成功后返回数据
            p = Number(data['pageNum']);//接收当前页
            var countPageNum = data['countPageNum'];//接收总页数
            var showDevPageArr=data['showDevPageArr'];
            if(showDevPageArr==null){
                alert("未查到数据!");
                window.location=window.location;
            }
            switch(showModel)
            {
                case 0:
                    $.each(showDevPageArr, function(i,item){
                        $("#succ_num_list").append("<li class='select_li'><span class='span-1'>"+item['point_address']+"</span><span class='span-1'>"+
                                item['point_info']+"</span><span class='span-1'>"+
                                item['mac']+"</span><span class='span-1'>"+
                                item['all_num']+"</span><span class='span-1'>"+
                                item['ios_num']+"</span><span class='span-1'>"+
                                item['android_num']+"</span></li>");
                    });
                    $("#succ_num_table").append("<div class='resultpage' style=''>"+"<a id='yichang_up_page' style='cursor:pointer'>«</a>"+"<span id='up_pages'></span>"+"<span class='current'>"+p+"</span>"+"<span id='down_pages'></span>"+"<a id='yichang_down_page' style='cursor:pointer'>»</a>"+"<span class='pages-number'>共"+countPageNum+"页</span>"+"<span>到第<select id='select_page_yichang'></select>页</span>"+"</div>");
                    $.openDOMWindow({
                        loader:1,
                        width:1000,
                        loaderHeight:16,
                        loaderWidth:17,
                        windowSourceID:'#succ_num_win'
                    });
                    break;
                case 1:
                    $.each(showDevPageArr, function(i,item){
                        $("#fail_num_list").append("<li class='select_li'><span class='span-1'>"+item['point_address']+"</span><span class='span-1'>"+
                                item['point_info']+"</span><span class='span-1'>"+
                                item['mac']+"</span><span class='span-1'><a class='statistics_button' style='color:##5095fc;text-decoration:underline;cursor: pointer;'>统计</a></span><input type='hidden' class='id' value='"+item['id']+"'/>"+"</li>");
                    });
                    $(".statistics_button").click(function(){
                        if(confirm("确定要统计吗?")){
                            statistics_button(this,select_id,showModel);
                        }
                    })
                    $("#fail_num_table").append("<div class='resultpage' style=''>"+"<a id='yichang_up_page' style='cursor:pointer'>«</a>"+"<span id='up_pages'></span>"+"<span class='current'>"+p+"</span>"+"<span id='down_pages'></span>"+"<a id='yichang_down_page' style='cursor:pointer'>»</a>"+"<span class='pages-number'>共"+countPageNum+"页</span>"+"<span>到第<select id='select_page_yichang'></select>页</span>"+"</div>");
                    $.openDOMWindow({
                        loader:1,
                        loaderHeight:16,
                        loaderWidth:17,
                        windowSourceID:'#fail_num_win'
                    });
                    break;
                case 2:
                    $.each(showDevPageArr, function(i,item){
                        $("#unfind_num_list").append("<li class='select_li'><span class='span-1'>"+item['reg_date']+"</span><span class='span-1'>"+
                                item['mac']+"</span><span class='span-1'>"+
                                item['all_num']+"</span><span class='span-1'>"+
                                item['ios_num']+"</span><span class='span-1'>"+
                                item['android_num']+"</span></li>");
                    });
                    $("#unfind_num_table").append("<div class='resultpage' style=''>"+"<a id='yichang_up_page' style='cursor:pointer'>«</a>"+"<span id='up_pages'></span>"+"<span class='current'>"+p+"</span>"+"<span id='down_pages'></span>"+"<a id='yichang_down_page' style='cursor:pointer'>»</a>"+"<span class='pages-number'>共"+countPageNum+"页</span>"+"<span>到第<select id='select_page_yichang'></select>页</span>"+"</div>");
                    $.openDOMWindow({
                        loader:1,
                        loaderHeight:16,
                        loaderWidth:17,
                        windowSourceID:'#unfind_num_win'
                    });
                    break;
                default:
                    alert("请求错误");
            }


            if(p=="1"){
                $("#yichang_up_page").hide();
            }
            if(p==countPageNum){
                $("#yichang_down_page").hide();
            }
            //前面的页码
            for (var i=p-3;i<=p-1 ; i++)
            {
                if(i<=1){
                    break;
                }
                if(i>1){
                    $("#up_pages").append("<a class='page_pp' value='"+i+"' style='cursor:pointer'>"+i+"</a>");
                }
            }
            //后面的页码
            for (var i=p+1;i<=p+3; i++)
            {
                if(i<=countPageNum){
                    $("#down_pages").append("<a class='page_pp' value='"+i+"' style='cursor:pointer'>"+i+"</a>");
                }
            }
            //页码select
            for(var i=1;i<=countPageNum;i++){
                if(i==p){
                    $("#select_page_yichang").append("<option value='"+i+"' selected='selected'>"+i+"</option>");
                }else{
                    $("#select_page_yichang").append("<option value='"+i+"'>"+i+"</option>");
                }
            }
            $("#select_page_yichang").change(function(){
                p=$(this).val();//页数
                up_yichang(select_id,showModel);
            });
            $(".page_pp").click(function(){
                p=$(this).text();
                up_yichang(select_id,showModel);
            });
            $("#yichang_up_page").click(function(){
                p--;
                up_yichang(select_id,showModel);
            });
            $("#yichang_down_page").click(function(){
                p++;
                down_yichang(select_id,showModel);
            });


        }
    });

}
function up_yichang(select_id,showModel){
    ajax_post(select_id,showModel);
}
function down_yichang(select_id,showModel){
    ajax_post(select_id,showModel);
}

function downexelc(id,model){
    window.location.href="<?php echo U('statistics/export/smart_export');?>?id="+id+"&model="+model;
}

function statistics_button(wei_id,select_id,showModel){
    var id = $(wei_id).parent().parent().find(".id").val();
    var handleUrl="<?php echo U('statistics/Index/change_count');?>";
    $.ajax({
        type: "POST",
        url: handleUrl,
        async: false,
        dataType: "json",
        data:{"id":id},
        success: function(data){
            alert("统计成功!");
            ajax_post(select_id,showModel);
        },

        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("请求失败!");
        }
    });
}
//渠道自动补全
function channel_name_blurry()
{
    var handleUrl = "<?php echo U('channel/Channel/channelnameBlurrySelect');?>";
    var channel_name = '';
    $.getJSON(handleUrl,{},
            function (data){
                var str = data;
                $("#channel_name").bigAutocomplete({width:150,data:data,callback:function(data){}});
            }
            ,'json'
    );
}
//网点自动补全
function place_name_blurry()
{
    var handleUrl = "<?php echo U('channel/Place/placenameBlurrySelect');?>";
    var place_name = '';
    $.getJSON(handleUrl,{},
            function (data){
                var str = data;
                $("#place_name").bigAutocomplete({width:150,data:data,callback:function(data){}});
            }
            ,'json'
    );
};
$(document).ready(function () {
    channel_name_blurry();
    place_name_blurry();
});
</script>


</body>
</html>