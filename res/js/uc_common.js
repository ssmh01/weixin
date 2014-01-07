var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko')
	&& userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera)
	&& userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent
	.indexOf('safari') != -1);
var note_step = 0;
var note_oldtitle = document.title;
var note_timer;
// iframe包含
if(top.location != location){
    top.location.href = location.href;
}
function $get(id) {
    return document.getElementById(id);
}
function doane(event) {
    e = event ? event : window.event;
    if(is_ie){
	e.returnValue = false;
	e.cancelBubble = true;
    }else if(e){
	e.stopPropagation();
	e.preventDefault();
    }
}
function isUndefined(variable) {
    return typeof variable == 'undefined' ? true : false;
}
// Ctrl+Enter 发布
function ctrlEnter(event, btnId, onlyEnter) {
    if(isUndefined(onlyEnter))
	onlyEnter = 0;
    if((event.ctrlKey || onlyEnter) && event.keyCode == 13){
	$get(btnId).click();
	return false;
    }
    return true;
}
function in_array(needle, haystack) {
    if(typeof needle == 'string' || typeof needle == 'number'){
	for( var i in haystack){
	    if(haystack[i] == needle){
		return true;
	    }
	}
    }
    return false;
}
function strlen(str) {
    return (is_ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length
	    : str.length;
}
// 刷新页面
function refreshPage(time) {
    if(!time){
	$time = 1000;
    }
    setTimeout(function() {
	window.parent.location.reload()
    }, time);
}
// 字符串是否为空
function isEmpty(str) {
    if(str == null)
	return true;
    str = str.replace(/\r\n/g, "");
    str = str.replace(/\r/g, "");
    str = str.replace(/\n/g, "");
    str = str.replace(/\s/g, "");
    if(str == ""){
	return true;
    }
    return false;
}
function ajaxPostForm(formid, beforefunc, afterfunc, timeout, waiting) {
    var img = "<img src='/res/images/loading.gif' />";
    var str = "正在提交……";
    var id = "#" + waiting;
    $(id).html(img + str);
    beforefunc;
    ajaxpost(formid, afterfunc, timeout);
    return false;
}
function postFormHandle(formid) {
    $('#__' + formid).css('color', 'red');
}
// 保存KE的值
function saveEditorValue(id) {
    if(KE){
	// 如果是使用KE编辑器
	var message = KE.util.getData(id);
	$('#' + id).val(message);
    }
}
function show(id, show, showtime) {
    var toShow = $('#' + id);
    if(showtime == null){
	showtime = 1000;
    }
    if(toShow){
	if(show){
	    toShow.show(showtime);
	}else{
	    toShow.hide(showtime);
	}
    }
}
function clearForm(formid) {
    $(':input', '#' + formid).not(':button, :submit, :reset').val('')
	    .removeAttr('checked').removeAttr('selected');
}
function comfirmAjaxMenu(e, ctrlid, isbox, timeout, func) {
    comfirm = confirm('此操作不可恢复,要继续操作吗?');
    if(!comfirm){
	return comfirm;
    }
    ajaxmenu(e, ctrlid, isbox, timeout, func);
    return false;
}
function ajaxMenuDelete(id) {
    id = 'item_' + id;
    show(id, false, 0);
}
function ajaxMenuDeleteV2(id){
    show(id, false, 0);
}

function opComfirm(message) {
    if(!message){
	message = '此操作不可恢复,要继续操作吗?';
    }
    return confirm(message);
}
function afterCancelFriend(linkId){
    var link = $('#'+linkId);
    var uid = linkId.split('_').pop();

	var href = "/member/friend/add/?uid=" + uid;
	var label = "加好友";
	link.toggleClass('btn-primary');
    link.attr('href', href);
    link.text(label);

    setTimeout(function(){
	link.toggleClass('btn-primary');
    },2000);
}
function afterApplyFriend(f,itemid){
	var appspan = $('#applyspan_'+itemid);
	
	if (f == 1) {
	    appspan.css("color","green");
	    appspan.css("font-size","14px");
	    appspan.css("margin-right","5px");
		appspan.html('已通过');
	}
	else{
	    appspan.css("color","#ff6600");
	    appspan.css("font-size","14px");
	    appspan.css("margin-right","5px");
		appspan.html('已拒绝');
	}
}
