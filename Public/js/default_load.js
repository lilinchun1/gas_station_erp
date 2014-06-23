$(function(){
    //可查看url集合str
    var urlStr = $(".urlStr").val();
    //当前页面url
    var nowUrl = $(".nowUrl").val();
    //当前页面菜单
    var dom = $(".url_link");
    for(key = 0;key < dom.length;key++){
        thisUrl = dom.eq(key).attr("url")+",";
        //控制可查看页面显示
        if(urlStr.indexOf(thisUrl) >= 0){
            dom.eq(key).show();
        }
        //控制当前页面菜单样式
        if(thisUrl.indexOf(nowUrl) >= 0){
            dom.eq(key).addClass("active");
        }
    }
});