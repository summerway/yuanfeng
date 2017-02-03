//redefined alert
function alert(msg){
    layer.alert(msg,{title:'提示',icon:0})
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


$(function(){
    getNavmenu();

    $("#global_search").click(function(){
        var key = $("#global_key").val();
        if(key.length > 0){
            console.info(APP_PATH +'/Home/Product/search?key='+ key)
            window.location.href= APP_PATH +'/Home/Product/search?key='+ key;
        }
    })
})


function getNavmenu(){
    $.ajax({
        type: "POST",
        url: APP_PATH +"/Home/Index/ajaxNavMenu",
        dataType: "json",
        success: function(rtn) {
            if(rtn.status){
                var html ='<ul class="nav nav-justified">';
                var index = 0
                $.each(rtn.list,function(key,value){
                    html += '<li><a href="'+APP_PATH+'/Home/Product/index?category='+ key +'&nav='+ index++ +'" >'+ value +'</a></li>';
                })
                html+='</ul>';
                $("#nav_menu").append(html);
                var nav_index = getUrlParameter('nav');
                if(nav_index != undefined){
                    $("#nav_menu li").eq(nav_index).addClass('active');
                }
            }
        }
    })
}
