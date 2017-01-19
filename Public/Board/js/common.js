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
    var perpend_html = '<div class="pointer"> <div class="arrow"></div> <div class="arrow_border"></div> </div>';
    $('#dashboard-menu li').eq(0).addClass('active').prepend(perpend_html);

    $('#dashboard-menu li ').click(function(){
        $('#dashboard-menu li').removeClass('active');
        $('#dashboard-menu .pointer').remove();
        $(this).addClass('active').prepend(perpend_html);
    })

})