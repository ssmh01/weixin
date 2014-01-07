function notNanParseInt(string){
    var intValue = parseInt(string);
    if(isNaN(intValue)){
	intValue = 0;
    }
    return intValue;
}
function notNanParseFloat(string){
    var floatValue = parseFloat(string);
    if(isNaN(floatValue)){
	floatValue = 0.0;
    }
    return floatValue;
}

function opConfirm() {
    return confirm("此操作不可恢复，您确定要进行吗?");
}

function getFormValue(form, inputName){
    var input = $("[name='" + inputName + "']", form);
    if(!input[0]) return null;
    var tagName = input[0].tagName.toLowerCase();
    if(tagName == 'input'){
	var type = input.attr('type').toLowerCase();
	if(type == 'text'){
	    var value = input.val();
	}else if(type == 'radio'){
	  var value = $("input[name='" + inputName + "']:checked").val();
	}else{
	    var value = input.val();
	}
    }else if(tagName == "select"){
	var value = $("select[name='" + inputName + "'] option:selected").val(); 
    }else if(tagName = 'textarea'){
	var value = input.val();
    }else{
	var value = input.val();
    }
    return value;
}

function show_tip(str) {
    jq(".KK_Manage_loginTips_txt").html(str);
    jq(".KK_Manage_loginTips").slideDown("slow");
    jq(".KK_Manage_loginTips").animate({
	opacity : 0.9
    }, "fast");
    clearInterval(time_id);
    time_id = setInterval(hide_tip, 2000);
}
function hide_tip() {
    jq(".KK_Manage_loginTips").slideUp("slow");
    clearInterval(time_id);
}
function showMessage() {
    var message = $.cookie('message');
    if(!message)
	return;
    show_tip(message);
    var options = {
	path : '/',
	expires : 0
    };
    $.cookie('message', null, options);
}
function changeTwoDecimal_f(x) {
    var f_x = parseFloat(x);
    if(isNaN(f_x)){
	alert('function:changeTwoDecimal->parameter error');
	return false;
    }
    var f_x = Math.round(x * 100) / 100;
    var s_x = f_x.toString();
    var pos_decimal = s_x.indexOf('.');
    if(pos_decimal < 0){
	pos_decimal = s_x.length;
	s_x += '.';
    }
    while(s_x.length <= pos_decimal + 2){
	s_x += '0';
    }
    return s_x;
}
/**
 * 显示验证码
 * 
 * @param {String}
 *                id 验证码容器id
 */
function captcha(id) {
    document.getElementById(id).src = "/common/captcha/show/?" + Math.random();
}
/**
 * 取消全选(基于jq)
 * 
 * @param {String}
 *                id 当前元素id
 * @param {String}
 *                allId全选框id
 */
function cancelAllSel(id, allId) {
    if(jq("#" + id).attr("checked") == false)
	jq("#" + allId).attr("checked", false);
}
/**
 * 全选(基于jq)
 * 
 * @param {String}
 *                id 全选框id
 * @param {String}
 *                itempreid 各项的元素id前缀
 */
function selectAll(id, itempreid) {
    jq(":checkbox[id^='" + itempreid + "']").attr("checked",
	    jq("#" + id).attr("checked"));
}
/**
 * 合并两个json
 * 
 * @param {Object}
 *                json
 * @param {Object}
 *                addJson
 * @return {Object}
 */
function mergerJson(json, addJson) {
    for( var o in addJson){
	json[o] = addJson[o];
    }
    return json;
}
/**
 * 创建编辑器
 * 
 * @param {String}
 *                con 容器id
 * @param {Object}
 *                config 配置信息，json格式
 */
function createEditor(con, config) {
    var defConfig = {
	"uploadJson" : "/upload/index/"
    };
    config = mergerJson(defConfig, config);
    KindEditor.ready(function(K) {
	editor = K.create(con, config);
    });
}
/**
 * 获取表单数据构造jquery进行post提交的数据格式(基于jq)
 * 
 * @param {String}
 *                formid 表单id
 * @return {Object} json格式
 */
function getPostDataForJquery(formid) {
    var data = {};
    var add;
    jq("#" + formid + " input").each(function() {
	var _type = jq(this).attr("type");
	add = true;
	if((_type == "radio") || (_type == "checkbox")){
	    if(jq(this).attr("checked") != true)
		add = false;
	}
	if(add)
	    data[jq(this).attr("name")] = jq(this).val();
    });
    jq("#" + formid + " select").each(function() {
	data[jq(this).attr("name")] = jq(this).val();
    });
    return data;
}
/**
 * 构造从conid容器中由id组成的json(基于jq)
 * 
 * @param {String}
 *                conid 容器id
 */
function getJsonOfId(conid) {
    var json = {};
    var _this;
    var con = (conid == "") ? "*" : "#" + conid + " *";
    jq(con + "[id!='']").each(function() {
	_this = jq(this);
	json[_this.attr("id")] = _this.val();
    });
    return json;
}
/**
 * 获取下拉框选择的文本
 * 
 * @param {String}
 *                conid 下拉框id
 * @param {Boolean}
 *                empty 是否值为空或0时也获取文本
 */
function getSelectText(conid, empty) {
    if((typeof (empty) == "undefined") || (empty == ""))
	empty = false;
    var sel = jq("#" + conid).find("option:selected");
    return (!empty && ((sel.val() == "") || (sel.val() == 0))) ? "" : sel
	    .text();
}
/**
 * 倒计时
 * 
 * @param {Number}
 *                overtime 结束时间戳
 * @param {Number}
 *                curtime 当前时间戳
 * @return {Object} {day:天, hour:小时, minute:分钟, second:秒}
 */
function countdown(overtime, curtime) {
    var diff = overtime - curtime;
    var day = parseInt(diff / 86400);
    diff = diff % 86400;
    var hour = parseInt(diff / 3600);
    if(hour < 10)
	hour = "0" + hour;
    diff = diff % 3600;
    var minute = parseInt(diff / 60);
    if(minute < 10)
	minute = "0" + minute;
    var second = diff % 60;
    if(second < 10)
	second = "0" + second;
    return {
	"day" : day,
	"hour" : hour,
	"minute" : minute,
	"second" : second
    };
}
function checkForm() {
    return true;
}

function getSelectValue(selid)
{
	var myid = document.getElementById(selid);  
    return myid.options[myid.selectedIndex].value;   	
}
