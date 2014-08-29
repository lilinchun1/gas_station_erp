/*
[闫继鹏]2014年8月25日   自动补全
*/
//json
function blurry(data_type,url,b_this){
	var b_data=$(b_this).val();
	//alert(b_data);
	//alert(url);
	$.getJSON(url,{"likeType":data_type,"typeKey":b_data},
		function (data){
			var str = data;
			//alert(123);
			//alert(data);
			$(b_this).bigAutocomplete({width:150,data:data,callback:function(data){}});
		}
		,'json'
	);
	a_this=b_this;
}
$(function(){
	var a_this='';
})


