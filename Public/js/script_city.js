/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: script_city.js 11751 2009-03-23 10:20:50Z zhengqingpeng $
*/

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function setcity(provinceid, cityid) {
	var province = document.getElementById(provinceid).value;
    switch (province) {
        case "安徽省" :
            var cityOptions = new Array(
            "合肥市", "合肥市",
            "宿州市", "宿州市",
            "淮北市", "淮北市",
            "亳州市", "亳州市",
            "阜阳市", "阜阳市",
            "蚌埠市", "蚌埠市",
            "淮南市", "淮南市",
            "滁州市", "滁州市",
            "马鞍山市", "马鞍山市",
            "芜湖市", "芜湖市",
            "铜陵市", "铜陵市",
            "安庆市", "安庆市",
            "黄山市", "黄山市",
            "六安市", "六安市",
            "巢湖市", "巢湖市",
            "池州市", "池州市",
            "宣城市", "宣城市");
             break;

        case "北京市" :
            var cityOptions = new Array(
        	"北京市", "北京市");
            break;
        case "重庆市" :
            var cityOptions = new Array(
        	"重庆市", "重庆市");
            break;
        case "福建省" :
            var cityOptions = new Array(
            "福州市", "福州市",
            "南平市", "南平市",
            "莆田市", "莆田市",
            "三明市", "三明市",
            "泉州市", "泉州市",
            "厦门市", "厦门市",
            "漳州市", "漳州市",
            "龙岩市", "龙岩市",
            "宁德市", "宁德市");
             break;
        case "甘肃省" :
            var cityOptions = new Array(
            "兰州市", "兰州市",
            "嘉峪关市", "嘉峪关市",
            "白银市", "白银市",
            "天水市", "天水市",
            "武威市", "武威市",
            "酒泉市", "酒泉市",
            "张掖市", "张掖市",
            "庆阳市", "庆阳市",
            "平凉市", "平凉市",
            "定西市", "定西市",
            "陇南市", "陇南市",
            "临夏州", "临夏州",
            "甘南州", "甘南州");
            break;
        case "广东省" :
            var cityOptions = new Array(
            "广州市", "广州市",
            "深圳市", "深圳市",
            "清远市", "清远市",
            "韶关市", "韶关市",
            "河源市", "河源市",
            "梅州市", "梅州市",
            "潮州市", "潮州市",
            "汕头市", "汕头市",
            "揭阳市", "揭阳市",
            "汕尾市", "汕尾市",
            "惠州市", "惠州市",
            "东莞市", "东莞市",
            "珠海市", "珠海市",
            "中山市", "中山市",
            "江门市", "江门市",
            "佛山市", "佛山市",
            "肇庆市", "肇庆市",
            "云浮市", "云浮市",
            "阳江市", "阳江市",
            "茂名市", "茂名市",
            "湛江市", "湛江市");
            break;
        case "广西省" :
            var cityOptions = new Array(
            "南宁市", "南宁市",
            "桂林市", "桂林市",
            "柳州市", "柳州市",
            "梧州市", "梧州市",
            "贵港市", "贵港市",
            "玉林市", "玉林市",
            "钦州市", "钦州市",
            "北海市", "北海市",
            "防城港市", "防城港市",
            "崇左市", "崇左市",
            "百色市", "百色市",
            "河池市", "河池市",
            "来宾市", "来宾市",
            "贺州市", "贺州市");
            break;
        case "贵州省" :
            var cityOptions = new Array(
            "贵阳市", "贵阳市",
            "六盘水市", "六盘水市",
            "遵义市", "遵义市",
            "安顺市", "安顺市",
            "毕节地区", "毕节地区",
            "铜仁地区", "铜仁地区",
            "黔东南州", "黔东南州",
            "黔南州", "黔南州",
            "黔西南州", "黔西南州");
            break;
        case "海南省" :
            var cityOptions = new Array(
            "海口市", "海口市",
            "三亚市", "三亚市");
            break;
        case "河北省" :
            var cityOptions = new Array(
            "石家庄市", "石家庄市",
            "张家口市", "张家口市",
            "承德市", "承德市",
            "秦皇岛市", "秦皇岛市",
            "唐山市", "唐山市",
            "廊坊市", "廊坊市",
            "保定市", "保定市",
            "衡水市", "衡水市",
            "沧州市", "沧州市",
            "邢台市", "邢台市",
            "邯郸市", "邯郸市");
            break;
        case "黑龙江省" :
            var cityOptions = new Array(
            "哈尔滨市", "哈尔滨市",
            "齐齐哈尔市", "齐齐哈尔市",
            "七台河市", "七台河市",
            "黑河市", "黑河市",
            "大庆市", "大庆市",
            "鹤岗市", "鹤岗市",
            "伊春市", "伊春市",
            "佳木斯市", "佳木斯市",
            "双鸭山市", "双鸭山市",
            "鸡西市", "鸡西市",
            "牡丹江市", "牡丹江市",
            "绥化市", "绥化市",
            "大兴安岭地区", "大兴安岭地区");
            break;
        case "河南省" :
            var cityOptions = new Array(
            "郑州市", "郑州市",
            "开封市", "开封市",
            "三门峡市", "三门峡市",
            "洛阳市", "洛阳市",
            "焦作市", "焦作市",
            "新乡市", "新乡市",
            "鹤壁市", "鹤壁市",
            "安阳市", "安阳市",
            "濮阳市", "濮阳市",
            "商丘市", "商丘市",
            "许昌市", "许昌市",
            "漯河市", "漯河市",
            "平顶山市", "平顶山市",
            "南阳市", "南阳市",
            "信阳市", "信阳市",
            "周口市", "周口市",
            "驻马店市", "驻马店市",
            "济源市", "济源市");
            break;
        case "香港" :
            var cityOptions = new Array(
            "香港特别行政区", "香港特别行政区");
            break;
        case "湖北省" :
            var cityOptions = new Array(
            "武汉市", "武汉市",
            "十堰市", "十堰市",
            "襄樊市", "襄樊市",
            "荆门市", "荆门市",
            "孝感市", "孝感市",
            "黄冈市", "黄冈市",
            "鄂州市", "鄂州市",
            "黄石市", "黄石市",
            "咸宁市", "咸宁市",
            "荆州市", "荆州市",
            "宜昌市", "宜昌市",
            "随州市", "随州市",
            "恩施州", "恩施州");
            break;
        case "湖南省" :
            var cityOptions = new Array(
            "长沙市", "长沙市",
            "张家界市", "张家界市",
            "常德市", "常德市",
            "益阳市", "益阳市",
            "岳阳市", "岳阳市",
            "株洲市", "株洲市",
            "湘潭市", "湘潭市",
            "衡阳市", "衡阳市",
            "郴州市", "郴州市",
            "永州市", "永州市",
            "邵阳市", "邵阳市",
            "怀化市", "怀化市",
            "娄底市", "娄底市",
            "湘西州", "湘西州");
            break;
        case "江苏省" :
            var cityOptions = new Array(
            "南京市", "南京市",
            "徐州市", "徐州市",
            "连云港市", "连云港市",
            "宿迁市", "宿迁市",
            "淮安市", "淮安市",
            "盐城市", "盐城市",
            "扬州市", "扬州市",
            "泰州市", "泰州市",
            "南通市", "南通市",
            "镇江市", "镇江市",
            "常州市", "常州市",
            "无锡市", "无锡市",
            "苏州市", "苏州市");
            break;
        case "江西省" :
            var cityOptions = new Array(
            "南昌市", "南昌市",
            "九江市", "九江市",
            "景德镇市", "景德镇市",
            "鹰潭市", "鹰潭市",
            "新余市", "新余市",
            "萍乡市", "萍乡市",
            "赣州市", "赣州市",
            "上饶市", "上饶市",
            "抚州市", "抚州市",
            "宜春市", "宜春市",
            "吉安市", "吉安市");
            break;
        case "吉林省" :
            var cityOptions = new Array(
            "长春市", "长春市",
            "白城市", "白城市",
            "松原市", "松原市",
            "吉林市", "吉林市",
            "四平市", "四平市",
            "辽源市", "辽源市",
            "通化市", "通化市",
            "白山市", "白山市",
            "延边州", "延边州");
            break;
        case "辽宁省" :
            var cityOptions = new Array(
            "沈阳市", "沈阳市",
            "朝阳市", "朝阳市",
            "阜新市", "阜新市",
            "铁岭市", "铁岭市",
            "抚顺市", "抚顺市",
            "本溪市", "本溪市",
            "辽阳市", "辽阳市",
            "鞍山市", "鞍山市",
            "丹东市", "丹东市",
            "大连市", "大连市",
            "营口市", "营口市",
            "盘锦市", "盘锦市",
            "锦州市", "锦州市",
            "葫芦岛市", "葫芦岛市");
            break;
        case "澳门" :
            var cityOptions = new Array(
            "澳门特别行政区", "澳门特别行政区");
            break;
        case "内蒙古" :
            var cityOptions = new Array(
            "呼和浩特市", "呼和浩特市",
            "包头市", "包头市",
            "乌海市", "乌海市",
            "赤峰市", "赤峰市",
            "通辽市", "通辽市",
            "呼伦贝尔市", "呼伦贝尔市",
            "鄂尔多斯市", "鄂尔多斯市",
            "乌兰察布市", "乌兰察布市",
            "巴彦淖尔市", "巴彦淖尔市",
            "兴安盟", "兴安盟",
            "锡林郭勒盟", "锡林郭勒盟",
            "阿拉善盟", "阿拉善盟");
            break;
        case "宁夏" :
            var cityOptions = new Array(
            "银川市", "银川市",
            "石嘴山市", "石嘴山市",
            "吴忠市", "吴忠市",
            "固原市", "固原市",
            "中卫市", "中卫市");
            break;
        case "青海省" :
            var cityOptions = new Array(
            "西宁市", "西宁市",
            "海东地区", "海东地区",
            "海北州", "海北州",
            "海南州", "海南州",
            "黄南州", "黄南州",
            "果洛州", "果洛州",
            "玉树州", "玉树州",
            "海西州", "海西州");
            break;
        case "山东省" :
            var cityOptions = new Array(
            "济南市", "济南市",
            "青岛市", "青岛市",
            "聊城市", "聊城市",
            "德州市", "德州市",
            "东营市", "东营市",
            "淄博市", "淄博市",
            "潍坊市", "潍坊市",
            "烟台市", "烟台市",
            "威海市", "威海市",
            "日照市", "日照市",
            "临沂市", "临沂市",
            "枣庄市", "枣庄市",
            "济宁市", "济宁市",
            "泰安市", "泰安市",
            "莱芜市", "莱芜市",
            "滨州市", "滨州市",
            "菏泽市", "菏泽市");
            break;
        case "上海市" :
            var cityOptions = new Array(
        	"上海市", "上海市");
            break;
        case "山西省" :
            var cityOptions = new Array(
            "太原市", "太原市",
            "朔州市", "朔州市",
            "大同市", "大同市",
            "阳泉市", "阳泉市",
            "长治市", "长治市",
            "晋城市", "晋城市",
            "忻州市", "忻州市",
            "晋中市", "晋中市",
            "临汾市", "临汾市",
            "吕梁市", "吕梁市",
            "运城市", "运城市");
            break;
        case "陕西省" :
            var cityOptions = new Array(
            "西安市", "西安市",
            "延安市", "延安市",
            "铜川市", "铜川市",
            "渭南市", "渭南市",
            "咸阳市", "咸阳市",
            "宝鸡市", "宝鸡市",
            "汉中市", "汉中市",
            "榆林市", "榆林市",
            "安康市", "安康市",
            "商洛市", "商洛市");
            break;
        case "四川省" :
            var cityOptions = new Array(
            "成都市", "成都市",
            "广元市", "广元市",
            "绵阳市", "绵阳市",
            "德阳市", "德阳市",
            "南充市", "南充市",
            "广安市", "广安市",
            "遂宁市", "遂宁市",
            "内江市", "内江市",
            "乐山市", "乐山市",
            "自贡市", "自贡市",
            "泸州市", "泸州市",
            "宜宾市", "宜宾市",
            "攀枝花市", "攀枝花市",
            "巴中市", "巴中市",
            "达州市", "达州市",
            "资阳市", "资阳市",
            "眉山市", "眉山市",
            "雅安市", "雅安市",
            "阿坝州", "阿坝州",
            "甘孜州", "甘孜州",
            "凉山州", "凉山州");
            break;
        case "台湾" :
            var cityOptions = new Array(
            "台北", "台北",
            "高雄", "高雄",
            "台中", "台中",
            "花莲", "花莲",
            "基隆", "基隆",
            "嘉义", "嘉义",
            "金门", "金门",
            "连江", "连江",
            "苗栗", "苗栗",
            "南投", "南投",
            "澎湖", "澎湖",
            "屏东", "屏东",
            "台东", "台东",
            "台南", "台南",
            "桃园", "桃园",
            "新竹", "新竹",
            "宜兰", "宜兰",
            "云林", "云林",
            "彰化", "彰化");
            break;
        case "天津市" :
            var cityOptions = new Array(
        	"天津市", "天津市");
            break;
        case "新疆" :
            var cityOptions = new Array(
            "乌鲁木齐市", "乌鲁木齐市",
            "克拉玛依市", "克拉玛依市",
            "喀什地区", "喀什地区",
            "阿克苏地区", "阿克苏地区",
            "和田地区", "和田地区",
            "吐鲁番地区", "吐鲁番地区",
            "哈密地区", "哈密地区",
            "克孜勒苏柯州", "克孜勒苏柯州",
            "博尔塔拉州", "博尔塔拉州",
            "昌吉州", "昌吉州",
            "巴音郭楞州", "巴音郭楞州",
            "伊犁州", "伊犁州",
            "塔城地区", "塔城地区",
            "阿勒泰地区", "阿勒泰地区");
            break;
        case "西藏" :
            var cityOptions = new Array(
            "拉萨市", "拉萨市",
            "那曲地区", "那曲地区",
            "昌都地区", "昌都地区",
            "林芝地区", "林芝地区",
            "山南地区", "山南地区",
            "日喀则地区", "日喀则地区",
            "阿里地区", "阿里地区");
            break;
        case "云南省" :
            var cityOptions = new Array(
            "昆明市", "昆明市",
            "曲靖市", "曲靖市",
            "玉溪市", "玉溪市",
            "保山市", "保山市",
            "昭通市", "昭通市",
            "丽江市", "丽江市",
            "思茅市", "思茅市",
            "临沧市", "临沧市",
            "德宏州", "德宏州",
            "怒江州", "怒江州",
            "迪庆州", "迪庆州",
            "大理州", "大理州",
            "楚雄州", "楚雄州",
            "红河州", "红河州",
            "文山州", "文山州",
            "西双版纳州", "西双版纳州");
            break;
        case "浙江省" :
            var cityOptions = new Array(
            "杭州市", "杭州市",
            "湖州市", "湖州市",
            "嘉兴市", "嘉兴市",
            "舟山市", "舟山市",
            "宁波市", "宁波市",
            "绍兴市", "绍兴市",
            "衢州市", "衢州市",
            "金华市", "金华市",
            "台州市", "台州市",
            "温州市", "温州市",
            "丽水市", "丽水市");
            break;
        case "海外" :
            var cityOptions = new Array(
            "美国", "美国",
            "英国", "英国", 
            "法国", "法国", 
            "瑞士", "瑞士", 
            "澳洲", "澳洲", 
            "新西兰", "新西兰", 
            "加拿大", "加拿大", 
            "奥地利", "奥地利", 
            "韩国", "韩国", 
            "日本", "日本", 
            "德国", "德国", 
			"意大利", "意大利", 
			"西班牙", "西班牙", 
			"俄罗斯", "俄罗斯", 
			"泰国", "泰国", 
			"印度", "印度", 
			"荷兰", "荷兰", 
			"新加坡", "新加坡",
            "欧洲", "欧洲",
            "北美", "北美",
            "南美", "南美",
            "亚洲", "亚洲",
            "非洲", "非洲",
            "大洋洲", "大洋洲");
            break;
        default:
            var cityOptions = new Array("地级市", "地级市");
            break;
    }
	
	var cityObject = document.getElementById(cityid);
	cityObject.options.length = 0;
	cityObject.options[0] = new Option("地级市", "地级市");
	var j = 0;
	for(var i = 0; i < cityOptions.length/2; i++) {
		j = i + 1;
	    cityObject.options[j] = new Option(cityOptions[i*2],cityOptions[i*2+1]);
	}
}

function initprovcity(provinceid, province) {
	var provObject = document.getElementById(provinceid);
    for(var i = 0; i < provObject.options.length; i++) {
        if (provObject.options[i].value == province) {
        	provObject.selectedIndex = i;
			break;
        }
    }
    //setcity(provinceid, cityid);
}

function showprovince(provinceid, cityid, province, boxid) {
	var provinces = new Array(
		"北京市", "上海市", "天津市", "重庆市", "安徽省", "福建省", "甘肃省", "广东省", "广西省", "贵州省", "海南省", "河北省", "黑龙江省", "河南省",
		"香港", "湖北省", "湖南省", "江苏省", "江西省", "吉林省", "辽宁省", "澳门", "内蒙古", "宁夏", "青海省", "山东省",
		"山西省", "陕西省", "四川省", "台湾",  "新疆", "西藏", "云南省", "浙江省", "海外"
	);
	
	var selObj = document.createElement("select");
	selObj.name = provinceid;
	selObj.id = provinceid;
    selObj.className ='channel-select-min';
	selObj.style.width = '80px'; 
	selObj.onchange = function() {
		setcity(provinceid, cityid);
	};
	document.getElementById(boxid).appendChild(selObj);
	
	selObj.options[0] = new Option("省份", "省份");
	var j = 0;
	for(var i = 0; i < provinces.length; i++) {
		j = i + 1;
		selObj.options[j] = new Option(provinces[i], provinces[i]);
	}
	
	initprovcity(provinceid, province);

}

function showcity(cityid, city, provinceid, boxid) {
	if(isUndefined(provinceid)) provinceid = '';
	
	var selObj = document.createElement("select");
	selObj.name = cityid;
	selObj.id = cityid;
    selObj.className ='channel-select-min';
	selObj.style.width = '100px'; 
	document.getElementById(boxid).appendChild(selObj);
	if(city == "") {
		selObj.options[0] = new Option("地级市", "地级市");
	} else {
		selObj.options[0] = new Option(city, city);
	}

	if(provinceid != '') {
		setcity(provinceid, cityid);
		initprovcity(cityid, city);
	}
}
