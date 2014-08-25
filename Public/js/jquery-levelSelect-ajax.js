;(function($){


//弹出层
$.openLayer = function(p){
	var param = $.extend({
		maxItems : 999,					//最多选取项数字限制
		showLevel : 2,					//显示级别
		oneLevel : false,				//是否限制选择相同级别的数据，可以不为同一个父节点，
										//false为不限制，可以同时选择不同级别的数据，true为限制。
		onePLevel : false,				//是否限制选择相同级别,并且是同一个父节点的数据，
										//false为不限制，可以同时选择不同级别的数据，true为限制。
										//此参数只有在oneLevel:true时才有效
		splitChar : ",:",				//数据分隔符，第一个字符为各项之间的分隔符，第二个为每项中id和显示字符串的分隔符。
		returnValue : "",				//以，分隔的选取结果id存放的位置id，默认为一个input。
		returnText : "",				//以，分隔的选取结果文字存放的位置id，可以为span，div等容器。
		title : "选择业务范围,单击省份可以选择所属市",				//弹出窗口标题
		width : 650,					//弹出窗口宽度
		span_width : {d1:70,d3:150},	//可以自定义每一层级数据项显示宽度，用来对其排版。
		url : "",//"{:U('configuration/Org/show_org_area_tree')}"						//ajax请求url
		pid : "0",						//父id
		shared : true,					//如果页面中有多于1个的弹出选择,是否共享缓存数据
		index : 10005,						//如果页面中有多于1个的弹出选择,如果不共享之前的操作界面则必须设置不同的index值，否则不同的弹出选择共享相同的操作界面。
		cacheEnable : false,				//是否允许缓存
		dragEnable : true,				//是否允许鼠标拖动
		pText : "",
		id:""//id值
	},p||{});

	var fs = {
		init_Container : function(){	//初始化头部和内容容器
			//标题
			//var TITLE = param.title + ",最多能选择 " + param.maxItems + " 项！";

			var TITLE = param.title;
			var CLOSE = "<span id='_cancel' style='cursor:pointer;'>[取消]</span>&nbsp;&nbsp;<span id='_ok' style='cursor:pointer;'>[确定]</span>";
			//头部
			var htmlDiv = "<div id='heads'><div id='headdiv'><span id='title'>" + TITLE + "</span><span id='close'>" + CLOSE + "</span></div>";
			//内容容器创建部分
			htmlDiv += "<div id='container_td'></div></div>";
			return htmlDiv;
		},
		init_area : function(){			//初始化数据容器
			var _container = $("#container_td");
			//已选择项容器
			var selArea = $("<div id='selArea'><div>已选择项目：</div></div>");
			_container.append(selArea); 
			if (param.maxItems == 1){ selArea.hide(); }

			//初始化第一层级数据容器，以后各级容器都clone本容器
			var d1 = $("<div id='d1'></div>");
			var dc = $("<div id='dc'></div>");

			_container.append(dc).append(d1);//加入数据容器中
			dc.hide();
			fs.add_data(d1);//添加数据
		},
		add_data : function(targetid){					//添加数据到容器，添加事件，初始化下一层次容器
			targetid.nextAll().remove();				//删除目标容器之后的所有同级别容器

			var pid = param.pid;						//查询数据的参数，父id
			var id = param.id;
			var url = param.url;						//ajax查询url
			var data = "";								//返回数据变量

			if(param.cacheEnable){ data = _cache[pid];}	//如果cache开启则首先从cache中取得数据
			
			//如果cache中没有数据并且url和pid都设置了,发起ajax请求
			if ((data == null || data == "") &&  url != ""){
				//var org_id=$('#agent_pid_hid').val();
				//alert(id);
				//alert(url);
				$.ajax({
					type : "post",						//post方式
					url : url,							//ajax查询url
					data : {"org_id":id},					//参数
					async : false,						//同步方式，便于拿到返回数据做统一处理
					beforeSend : function (){ },		//ajax查询请求之前动作，比如提示信息……
					success : function (d) {			//ajax请求成功后返回数据
						data = "{"+d+"}";
						if(param.cacheEnable){ _cache=eval("(" + data + ")");}		//cache允许,保存数据到cache
					}
				});
			}

			//cache和ajax都没有数据或者错误,添加提示信息返回
			if(data == "" || data == null){
				targetid.empty().show().append($("<span style='color:red;'>没有下级数据！</span>"));
				return;
			}

			var span_width = eval("param.span_width."+targetid.attr("id"));			//每个数据显示项的宽度

			span_width = (span_width == undefined ? param.span_width.d1:span_width );//没有设置的话，就使用第一个数据容器的值
			var inspan_width = ($.browser.msie)?1:3;								//内部文字和checkbox之间的距离
						
			var dat=eval("(" + data + ")")[pid].split(param.splitChar.charAt(0));					//根据设定分隔符对数据做第一次分隔，获得数据项数组

			var html = [];															//格式化数据存放容器，为了提高效率，使用了数组
			var ss = [];
			//循环获得格式化的显示字符串
			for(var i = 0 ; i < dat.length ; i++){
				ss = dat[i].split(param.splitChar.charAt(1));		//第二次分隔，获得每个数据项中的数据值和显示字符串
				html.push("<span title='"+dat[i]+"' name='"+pid+"' style='width:"+span_width+"px;white-space:nowrap;float:left;'>");
				html.push("<input type='checkbox' value='" + ss[0] + "'>");
				html.push("<span name='"+targetid.attr("id")+"' style='margin-left:"+inspan_width+"px;'>" + ss[1] + "</span>");
				html.push("</span>");
			}
			targetid.empty().show().append($(html.join("")));		//格式化的html代码放入目标容器
			if(param.maxItems > 1){fs.change_status(targetid);}		//同步状态,单选状态无必要
				
			fs.add_input_event(targetid);							//加入input的事件绑定
			fs.add_span_event(targetid);							//加入span的事件绑定
		},
		init_event : function(){		//绑定已选择框中checkbox的事件，确定，取消事件响应
			$("#selArea").find(":input").live("click",function(){
				$(this).parent().remove();
				$("#container_td > div").find(":input[value="+this.value+"]").attr("checked",false);
			});
			$("#d1").find("input:checkbox").hide();
			$("#_cancel").click(function(){
				$("#bodybg").hide();
				$("#popupAddr").fadeOut();
			});
			$("#_ok").click(function(){
				var vals = "";
				var txts = "";
				$("#selArea").find(":input").each(function(i){
					vals += ("," + this.value);
					txts += ("," + $(this).next().text());
				});
				fs.set_returnVals(param.returnValue,vals);
				fs.set_returnVals(param.returnText,txts);
		
				$("#bodybg").hide();
				$("#popupAddr").fadeOut();
			});
		},
		change_status : function(targetid){ //切换不同元素，形成不同下级列表时候，同步已选择区的元素和新形成区元素的选中状态
			var selArea = $("#selArea");
			var selinputs = selArea.find(":input");
			var vals =[];

			if(selinputs.length > 0){
				selinputs.each(function(){ vals.push(this.value); });
			}
			targetid.find(":input").each(function(){
				if($.inArray(this.value,vals) != -1){ this.checked = true; }
			});
		},
		add_input_event : function(targetid){	//新生成的元素集合添加input的单击事件响应
			var selArea = $("#selArea");
			targetid.find(":input").click(function(){
				if (param.maxItems == 1){
					selArea.find("span").remove();
					$("#container_td > div").find(":checked:first").not($(this)).attr("checked",false);
					$(this).css("color","white");
					selArea.append($(this).parent().clone());
					$("#_ok").click();
				}else {
					if(this.checked && fs.check_level(this) && fs.check_num(this)){
						selArea.append($(this).parent().clone().css({"width":"","background":"","border":""}));
					}else{
						selArea.find(":input[value="+this.value+"]").parent().remove();
					}			
				}
			});
		},
		add_span_event : function(targetid){	//新生成的元素集合添加span的单击事件响应
			var maxlev = param.showLevel;
			var thislevel = parseInt(targetid.attr("id").substring(1));
	
			var spans = targetid.children("span");
			spans.children("span").click(function(e){
				if (maxlev > thislevel){
					var next=$("#dc").clone();
					next.attr("id","d"+(thislevel+1));
					targetid.after(next);
			
					spans.css({"background":"","border":"","margin":""});
					$(this).parent().css({"background":"orange","margin":"-1"});
					param.pid = $(this).prev().val();
					fs.add_data(next,param);
				}else{
					alert("当前设置只允许显示" +  maxlev + "层数据！");
				}
			});
		},
		check_num : function(obj){	//检测最多可选择数量
			if($("#selArea").find(":input").size() < param.maxItems){
				return true;
			}else{
				obj.checked = false;
				alert("最多只能选择"+param.maxItems+"个选项");
				return false;
			}
		},
		check_level : function(obj){	//检测是否允许选取同级别选项或者同父id选项
			var selobj = $("#selArea > span");
			if(selobj.length ==0) return true;

			var oneLevel = param.oneLevel;
			if(oneLevel == false){
				return true;
			}else{
				var selLevel = selobj.find("span:first").attr("name");		//已选择元素的级别
				var thislevel = $(obj).next().attr("name");					//当前元素级别
				if(selLevel != thislevel) {
					obj.checked = false;
					alert("当前设定只允许选择同一级别的元素！");
					return  false;
				}else{
					var onePLevel = param.onePLevel;		//是否设定只允许选择同一父id的同级元素
					if (onePLevel == false) {
						return true;
					}else{
						var parentId = selobj.attr("name");					//已选择元素的父id
						var thisParentId = $(obj).parent().attr("name");	//当前元素父id
						if (parentId != thisParentId){
							obj.checked = false;
							alert("当前设定只允许选择同一级别并且相同上级的元素！");
							return false;
						}
						return true;
					}
				}
			}
		},
		set_returnVals : function(id,vals) {	//按"确定"按钮时处理、设置返回值
			if(id != ""){
				var Container = $("#" + id);
				if(Container.length > 0){
					if(Container.is("input")){
						Container.val(vals.substring(1));
					}else{
						Container.text(vals.substring(1));
					}
				}
			}	
		},
		init_style : function() {	//初始化css
			var _margin = 4;
			var _width = param.width-_margin*5;

			var css = [];
			var aotu = "border:2px groove";
			css.push("#popupAddr {position:absolute;border:3px ridge;width:"+param.width+"px;height:auto;background-color:#e3e3e3;z-index:10005;-moz-box-shadow:5px 5px 5px rgba(0,0,0,0.5);box-shadow:5px 5px 5px rgba(0,0,0,0.5);filter:progid:DXImageTransform.Microsoft.dropshadow(OffX=5,OffY=5,Color=gray);-ms-filter:progid:DXImageTransform.Microsoft.dropshadow(OffX=5,OffY=5,Color='gray');}");
			css.push("#bodybg {width:100%;z-index:98;position:absolute;top:0;left:0;background-color:#fff;opacity:0.1;filter:alpha(opacity =10);}");
			css.push("#heads {width:100%;font-size:12px;margin:0 auto;}");
			css.push("#headdiv {color:white;background-color:green;font-size:13px;height:25px;margin:1px;" +aotu+"}");
			css.push("#title {line-height:30px;padding-left:20px;float:left;}");
			css.push("#close {float:right;padding-right:12px;line-height:30px;}");
			css.push("#container_td {width:100%;height:auto;}");
			css.push("#selArea {width:"+_width+"px;height:48px;margin:"+_margin+"px;padding:5px;background-color:#f4f4f4;float:left;"+aotu+"}");
			css.push("#pbar {width:"+_width+"px;height:12px;margin:4px;-moz-box-sizing: border-box;display:block;overflow: hidden;font-size:1px;border:1px solid red;background:#333333;float:left;}");
	
			var d_css = "{width:"+_width+"px;margin:"+_margin+"px;padding:5px;height:auto;background-color:khaki;float:left;"+aotu+"}";
			css.push("dc "+d_css);
			for (i = 1; i <=param.showLevel; i++) { css.push("#d" + i + " " + d_css); }
			$("head").append($("<style>"+css.join(" ")+"</style>"));
		}
	};

	if (window._cache == undefined || !param.shared ){ _cache = {}; }
	if (window._index == undefined) { _index = param.index; }

	fs.init_style();//初始化样式

	var popupDiv = $("#popupAddr");	//创建一个div元素
	if (popupDiv.length == 0 ) {
		popupDiv = $("<div id='popupAddr'></div>");
		$("body").append(popupDiv);
	}
	var yPos = ($(window).height()-popupDiv.height()) / 2;
	var xPos = ($(window).width()-popupDiv.width()) / 2;
	popupDiv.css({"top": yPos,"left": xPos}).show();
	
	var bodyBack = $("#bodybg");  //创建背景层
	if (bodyBack.length == 0 ) {
		bodyBack = $("<div id='bodybg'></div>");
		bodyBack.height($(window).height());
		$("body").append(bodyBack);
		popupDiv.html(fs.init_Container());	//弹出层内容
		fs.init_area();
		fs.init_event();
	}else {
		if (_index != param.index) {
			popupDiv.html(fs.init_Container(param));
			fs.init_area();
			fs.init_event();
			_index = param.index;
		}
	}

	if (param.dragEnable) {		//允许鼠标拖动
		var _move=false;		//移动标记
		var _x,_y;				//鼠标离控件左上角的相对位置
		popupDiv.mousedown(function(e){
			_move=true;
			_x=e.pageX-parseInt(popupDiv.css("left"));
			_y=e.pageY-parseInt(popupDiv.css("top"));
		}).mousemove(function(e){
			if(_move){
				var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置
				var y=e.pageY-_y;
				popupDiv.css({top:y,left:x});//控件新位置
		}}).mouseup(function(){ _move=false; });
	}
	bodyBack.show();
	popupDiv.fadeIn();
}

})(jQuery)

_cache ={
};		
//缓存


//0:1:北京,2:上海,3:黑龙江,4:吉林,5:辽宁,6:天津,7:安徽,8:江苏,9:浙江,10:陕西,11:湖北,12:广东,13:湖南,14:甘肃,15:四川,16:山东,17:福建,18:河南,19:重庆,20:云南,21:河北,22:江西,23:山西,24:贵州,25:广西,26:内蒙古,27:宁夏,28:青海,29:新疆,30:海南,31:西藏,32:香港,33:澳门,34:台湾,3:109:哈尔滨,110:齐齐哈尔,111:鸡西,112:鹤岗,113:双鸭山,114:大庆,115:伊春,116:佳木斯,117:七台河,118:牡丹江,119:黑河,120:绥化,121:大兴安岭,4:101:长春,102:四平,103:辽源,104:通化,105:白山,106:松原,107:白城,108:延边,5:87:沈阳,88:大连,89:鞍山,90:抚顺,91:本溪,92:丹东,93:锦州,94:营口,95:阜新,96:辽阳,97:盘锦,98:铁岭,99:朝阳,100:葫芦岛,7:146:合肥,147:芜湖,148:蚌埠,149:淮南,150:马鞍山,151:淮北,152:铜陵,153:安庆,154:黄山,155:滁州,156:阜阳,157:宿州,158:巢湖,159:六安,160:亳州,161:池州,162:宣城,8:122:南京,123:无锡,124:徐州,125:常州,126:苏州,127:南通,128:连云港,129:淮安,130:盐城,131:扬州,132:镇江,133:泰州,134:宿迁,9:135:杭州,136:宁波,137:温州,138:嘉兴,139:湖州,140:绍兴,141:金华,142:衢州,143:舟山,144:台州,145:丽水,10:317:西安,318:铜川,319:宝鸡,320:咸阳,321:渭南,322:延安,323:汉中,324:榆林,325:安康,326:商洛,11:200:武汉,201:黄石,202:襄樊,207:十堰,208:荆州,209:鄂州,210:宜昌,211:荆门,212:孝感,213:黄冈,214:咸宁,215:随州,216:恩施,12:227:广州,228:深圳,229:珠海,230:汕头,231:韶关,232:佛山,233:江门,234:湛江,235:茂名,236:肇庆,237:惠州,238:梅州,239:汕尾,240:河源,241:阳江,242:清远,243:东莞,244:中山,245:潮州,246:揭阳,247:云浮,13:203:衡阳,204:邵阳,205:岳阳,206:常德,217:长沙,218:株洲,219:湘潭,220:张家界,221:益阳,222:郴州,223:永州,224:怀化,225:娄底,226:湘西,14:327:兰州,328:嘉峪关,329:金昌,330:白银,331:天水,332:武威,333:张掖,334:平凉,335:酒泉,336:庆阳,337:定西,338:陇南,339:临夏,340:甘南,15:264:成都,265:自贡,266:攀枝花,267:泸州,268:德阳,269:绵阳,270:广元,271:遂宁,272:内江,273:乐山,274:南充,275:宜宾,276:广安,277:达州,278:眉山,279:雅安,280:巴中,281:资阳,282:阿坝,283:甘孜,284:凉山,16:183:济南,184:青岛,185:淄博,186:枣庄,187:东营,188:烟台,189:潍坊,190:威海,191:济宁,192:泰安,193:日照,194:莱芜,195:临沂,196:德州,197:聊城,198:滨州,199:菏泽,17:163:福州,164:厦门,165:莆田,166:三明,167:泉州,168:漳州,169:南平,170:龙岩,171:宁德,18:35:郑州,36:平顶山,37:开封,38:洛阳,39:焦作,40:许昌,41:三门峡,42:禹州,43:新乡,44:安阳,45:南阳,46:信阳,47:商丘,48:鹤壁,60:周口,61:驻马店,62:濮阳,63:漯河,20:294:昆明,295:曲靖,296:玉溪,297:保山,298:昭通,299:丽江,300:普洱,301:临沧,302:文山,303:红河,304:西双版纳,305:楚雄,306:大理,307:德宏,308:怒江,309:迪庆,21:49:石家庄,50:唐山,51:秦皇岛,52:邯郸,53:邢台,54:保定,55:张家口,56:承德,57:沧州,58:衡水,59:廊坊,22:172:南昌,173:景德镇,174:萍乡,175:九江,176:新余,177:鹰潭,178:赣州,179:吉安,180:宜春,181:抚州,182:上饶,23:64:太原,65:大同,66:阳泉,67:长治,68:晋城,69:朔州,70:晋中,71:运城,72: 忻州,73:临汾,74:吕梁,24:285:贵阳,286:六盘水,287:遵义,288:安顺,289:铜仁,290:毕节,291:黔西南,292:黔东南,293:黔南,25:248:南宁,249:柳州,250:桂林,251:梧州,252:北海,253:防城港,254:钦州,255:贵港,256:玉林,257:百色,258:贺州,259:河池,260:来宾,261:崇左,26:75:呼和浩特,76:包头,77:乌海,78:赤峰,79:通辽,80:鄂尔多斯,81:呼伦贝尔,82:巴彦淖尔,83:乌兰察布,84:兴安,85:锡林郭勒,86:阿拉善,27:348:银川,349:石嘴山,350:吴忠,351:固原,352:中卫,28:341:西宁,342:海东,343:海北,344:黄南,345:果洛,346:玉树,347:海西,29:353:乌鲁木齐,354:克拉玛依,355:吐鲁番,356:哈密,357:和田,358:阿克苏,359:巴音郭楞蒙古,360:喀什,361:克孜勒苏柯尔克孜,362:昌吉,363:博尔塔拉蒙古,364:伊犁哈萨克,365:塔城,366:阿勒泰,30:262:海口,263:三亚,31:310:拉萨,311:昌都,312:山南,313:日喀则,314:那曲,315:阿里,316:林芝,34:367:台北,368:高雄,369:基隆,370:台中,371:台南,372:新竹,373:嘉义
