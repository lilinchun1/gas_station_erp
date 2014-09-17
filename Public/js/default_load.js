$(function() {
	// 可查看url集合str
	var urlStr = $(".urlStr").val();
	//alert(urlStr);
	// 当前页面url
	var nowUrl = $(".nowUrl").val();
	// 当前页面菜单
	var dom = $(".url_link");
	for (key = 0; key < dom.length; key++) {
		//本次沥遍到的url
		thisUrl = dom.eq(key).attr("url");
		// 控制可查看页面显示
		if (urlStr.indexOf(thisUrl) >= 0) {
			dom.eq(key).show();
		}
		// 控制当前页面菜单样式
		if (nowUrl&&(thisUrl.indexOf(nowUrl) >= 0)) {
			//子菜单上样式
			dom.eq(key).addClass("active");
			//查找当前子菜单的父菜单url，赋样式
			//getTopLink是在pb-head.html中定义的全局js变量
			$.ajax({
				url            : getTopLink,
				type           : "get",
				dataType       : "json",
				data           : { userUrl : nowUrl },
				async          : true,
				success        : function(data, textStatus){
					var nowTopLink = data[0]['url'];
					//获取所有顶级菜单url数组
			    	var topLinkDom = $(".topLink");
			    	for (i = 0; i < topLinkDom.length; i++) {
			    		var thisTopLink = topLinkDom.eq(i).attr("url");
			    		if (thisTopLink.indexOf(nowTopLink) >= 0) {
			    			topLinkDom.eq(i).addClass("active");
			    		}
			    	}
			    }

			});
		}
	}
});

//显示窗口
function showWindow(loader,loaderHeight,loaderWidth,id){
	$.openDOMWindow({
		loader : loader,
		loaderHeight : loaderHeight,
		loaderWidth : loaderWidth,
		windowSourceID : id
	});
}

// ==================================== role_index.html ====================================================
//==========树形开始
var code;
function onCheck(e, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("treeDemo"), 
	nodes = zTree.getCheckedNodes(true), v = "";
	for ( var i = 0, l = nodes.length; i < l; i++) {
		v += nodes[i].id + ",";
	}
	if (v.length > 0)
		v = v.substring(0, v.length - 1);
	var cityObj = $("#add_quanxian_id");
	cityObj.attr("value", v);
}

function showCode(str) {
	if (!code)
		code = $("#code");
	code.empty();
	code.append("<li>" + str + "</li>");
}
function getTreeSetting(check, simpleData, view, beforeClick, onCheck) {
	var setting = {
		check : {
			enable : check
		},
		data : {
			simpleData : {
				enable : simpleData
			}
		},
		view : {
			dblClickExpand : view
		},
		callback : {
			beforeClick : beforeClick,
			onCheck : onCheck
		}
	};
	return setting;
}

function setCheck(Obj) {
	var zTree = $.fn.zTree.getZTreeObj(Obj),
	py = $("#py").attr("checked")? "p":"",
	sy = $("#sy").attr("checked")? "s":"",
	pn = $("#pn").attr("checked")? "p":"",
	sn = $("#sn").attr("checked")? "s":"",
	type = { "Y" : "ps", "N" : "ps" };
	zTree.setting.check.chkboxType = type;
	showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
}
//==========树形结束
// ==================================== role_index.html end====================================================
// ==================================== station_index.html begin====================================================
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
// ==================================== station_index.html end====================================================
//------------------------------------------------------渠道管理-----------------------------------------------------------------------------------------
// =====================================device_index.html  begin ===================================================================
$("#deviceDala").bind("click",function(){
	//alert($("#sswd").val());
	$(".select_province").eq(0).val("0");
	$(".select_city").eq(0).val("0");
	$("#device_no_txt").val("");
	$("#select_device_status").eq(0).val("");
	$("#firstopentime1").val("");
	$("#firstopentime2").val("");
	$("#mac_txt").val("");
	$("#sswd").val("");	
	$("#sim_text").val("");
	$("#channel_name_txt").val("");

});
//======================================device_index.html end==========================================================================

//======================================channel_index.html begin=======================================================================
$("#channelDala").bind("click",function(){
	//alert($("#channel_name_txt").val());										
	$("#channel_name_txt").val("");		
	$("#channel_first_type_sel").eq(0).val("");
	$("#channel_second_type_sel").eq(0).val("");
	$("#agent_name_txt").val("");
	$(".select_province").eq(0).val("0");
	$(".select_city").eq(0).val("0");
	$("#contract_begin_time_1").val("");
	$("#contract_begin_time_2").val("");
	$("#contract_end_time_1").val("");
	$("#contract_end_time_2").val("");
	
});		
//======================================channel_index.html end=========================================================================

//======================================place_index.html begin=========================================================================
$("#placeDala").bind("click",function(){
	$("#place_name_txt").val("");
    $(".select_province").eq(0).val("0");
    $(".select_city").eq(0).val("0");
	$("#channel_name_txt").val("");		
	$("#place_state_sel").eq(0).val("");
	$("#select_test_end_time_1").val("");
	$("#select_test_end_time_2").val("");
});
//======================================place_index.html end===========================================================================
//-------------------------------------------------------------运营管理--------------------------------------------------------------------------------------
//======================================addRuleTarget.html begin=======================================================================
$("#addRuleDele").bind("click",function(){
	//alert($("#channel-org-name").val());										
	$("#channel-org-name").val("");
	$("#maintain-create-people").val("");
	$("#maintain-create-date").val("");										
});
//======================================addRuleTarget.html end=========================================================================

//======================================运营管理index.html begin========================================================================
$("#yunindexDele").bind("click",function(){
	//alert($("#channel-org-name").val());
	$("#channel-org-name").val("");
	$("#maintain-create-people").val("");
	$("#maintain-create-date").val("");							 
});
//======================================运营管理index.html end==========================================================================

//===========================================verup.html begin==========================================================================
$("#verupDele").bind("click",function(){
	//alert($("#channel-org-name").val());
	$("#channel-org-name").val("");
	$("#maintain-create-people").val("");
	$("#maintain-create-date").eq(0).val("");
	$("#maintain-create-date").eq(0).val("");
});

//===========================================verup.html end============================================================================
//------------------------------------------------------------系统设置--------------------------------------------------------------------------------------------------
//=============================================role_index.html begin===================================================================
$("#roleDala").bind("click",function(){
	$("#org_name_txt").val("");
	$("#role_name_txt").val("");			
});
//=============================================role_index.html end=====================================================================

//=============================================user_index.html begin===================================================================
$("#userDele").bind("click",function(){
	$("#realname_txt").val("");
 	$("#org_name_txt").val("");
	$("#username_txt").val("");
});

//=============================================user_index.html end===================================================================

//------------------------------------------------------加油站管理管理-----------------------------------------------------------------------------------------

//=============================================station.html begin===================================================================
$("#stationDele").bind("click",function(){
	$("#channelName").val("");
 	$("#place_name").val("");
	$("#device_no").val("");
});


//=============================================station.html end=====================================================================