/*
[闫继鹏]2014年8月18日   城市联动
*/
//获取all省份
function getProvince(handleUrl,cs_Province_id,cs_City_url,cs_City_id){
	$(".select_province").empty();
	$(".select_province").append("<option class='0' value='0'>省份</option>");
	$.ajax({
		type: "POST",
		url: handleUrl,
		async: false,
		dataType: "json",
		data:{},	
		success: function(data){
			$.each(data, function (key, val) {
				if(cs_Province_id==val['area_id']){
					$(".select_province").append("<option class='"+val['area_id']+"' value='"+val['area_id']+"' selected='selected'>"+val['area_name']+"</option>");
				}else{
					$(".select_province").append("<option class='"+val['area_id']+"' value='"+val['area_id']+"'>"+val['area_name']+"</option>");
				}
			});
			if(cs_Province_id!="0"){
				cs_getCity(cs_Province_id,cs_City_url,cs_City_id);
			}
		},

		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("请求失败!");
		}
	});
}
//根据省份获取城市
function getCity(City_handleUrl,xy){
	$(xy).parent().find(".select_city").empty();
	$(xy).parent().find(".select_city").append("<option class='0' value='0'>地级市</option>");
	var Province_id=$(xy).val();
	if(Province_id=="0"){
		return false;
	}
	var url=City_handleUrl+"?province_id="+Province_id;
	$.ajax({
		type: "POST",
		url: url,
		async: false,
		dataType: "json",
		data:{},	
		success: function(data){
			$.each(data, function (key, val) {
				$(xy).parent().find(".select_city").append("<option class='"+val['area_id']+"' value='"+val['area_id']+"'>"+val['area_name']+"</option>");
			});
		},

		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("请求失败!");
		}
	});
}
//初始化城市
function cs_getCity(cs_Province_id,cs_City_url,cs_City_id){
	//alert(cs_Province_id);
	//alert(cs_City_url);
	$(".select_city").empty();
	$(".select_city").append("<option class='0' value='0'>地级市</option>");
	if(cs_Province_id==""){
		return false;
	}
	var url=cs_City_url+"?province_id="+cs_Province_id;
	$.ajax({
		type: "POST",
		url: url,
		async: false,
		dataType: "json",
		data:{},	
		success: function(data){
			$.each(data, function (key, val) {
				if(cs_City_id==val['area_id']){
					$(".select_city").append("<option class='"+val['area_id']+"' value='"+val['area_id']+"' selected='selected' >"+val['area_name']+"</option>");
				}else{
					$(".select_city").append("<option class='"+val['area_id']+"' value='"+val['area_id']+"'>"+val['area_name']+"</option>");

				}
			});
		},

		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("请求失败!");
		}
	});
}

