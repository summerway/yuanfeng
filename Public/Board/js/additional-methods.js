//validator.js addition method
jQuery.validator.addMethod("isMobile", function(value, element) {
    var phone = /^1[3458]\d{9}$/;
    return this.optional(element) || (phone.test(value));
}, "Please enter a valid mobile number");

function alert(msg){
    layer.alert(msg,{title:'提示',icon:0})
}