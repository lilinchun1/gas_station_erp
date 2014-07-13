$(function() {
	// 可查看url集合str
	var urlStr = $(".urlStr").val();
	//alert(urlStr);
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
	//固定标题
	/*if($("#j-fixed-top")){
		window.onscroll=function(){
			var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
			var fixDiv=document.getElementById('j-fixed-top');
			if(scrollTop>=280){
				fixDiv.style.position='fixed';
				fixDiv.style.top='0px';
			}else if(scrollTop<1){
				fixDiv.style.position='relative';
			}
		};
	}*/
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