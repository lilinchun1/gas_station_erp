function log(url,option_id,option_name){
	$.getJSON(url,{"option_id":option_id,"option_name":option_name},
		function (data){
			$.each(data, function(i,item){
					$("#log_info").append("<li><span class='span-3'>" + item.user + "</span><span class='span-3'>" +
						item.time + "</span><span class='span-3' title='" + item.info + "'>" + item.info + "</span></li>");
			});
		}
		,'json'
	);

}