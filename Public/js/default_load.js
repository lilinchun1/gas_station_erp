$(function() {
	// 可查看url集合str
	var urlStr = $(".urlStr").val();
	// alert(urlStr);
	// 当前页面url
	var nowUrl = $(".nowUrl").val();
	// 当前页面菜单
	var dom = $(".url_link");
	for (key = 0; key < dom.length; key++) {
		thisUrl = dom.eq(key).attr("url") + ",";
		// alert(thisUrl);
		// 控制可查看页面显示
		if (urlStr.indexOf(thisUrl) >= 0) {
			dom.eq(key).show();
		}
		// 控制当前页面菜单样式
		if (thisUrl.indexOf(nowUrl) >= 0) {
			dom.eq(key).addClass("active");
		}
	}
});

// ==================================== role_index.html ====================================================
//==========树形开始
var code;
function onCheck(e, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("treeDemo"), nodes = zTree
			.getCheckedNodes(true), v = "";
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
	type = { "Y":py + sy, "N":pn + sn};
	zTree.setting.check.chkboxType = type;
	showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
}
//==========树形结束
//显示窗口
function showWindow(loader,loaderHeight,loaderWidth,id){
	$.openDOMWindow({
		loader : 1,
		loaderHeight : 16,
		loaderWidth : 17,
		windowSourceID : id
	});
}
// ==================================== role_index.html end====================================================
