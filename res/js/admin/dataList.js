function url(module, action, method) {
    var url = '/' + module + '/' + action + '/';
    if(method){
	url += method + '/';
    }
    return url;
}
jQuery(function(jq) {
    jq(document)
	    .mousemove(
		    function(e) {
			var obj = e.target;
			if(jq(obj).attr('tagName').toLowerCase() == 'span'
				&& typeof (obj.onclick) == 'function'
				&& (obj.onclick.toString().indexOf('textEdit') != -1 || obj.onclick
					.toString().indexOf('numberEdit') != -1)){
			    obj.title = CLICK_EDIT_CONTENT;
			    jq(obj).addClass('select');
			    jq(obj).one('mouseout', function() {
				jq(obj).removeClass('select');
			    });
			}
		    });
});
function delcheck(id, checkboxClass) {
    if(!checkboxClass){
	checkboxClass = "ids"
    }
    var bol = false;
    jq("tbody tr:not([disabled]) input[class='" + checkboxClass + "']").each(
	    function() {
		if(this.checked){
		    bol = true;
		}
	    });
    if(bol){
	return true;
    }else{
	alert('请选择要删除的信息!');
	return false;
    }
}
function uncheckAll(id, checkboxClass) {
    if(!checkboxClass){
	checkboxClass = "ids"
    }
    jq("tbody tr:not([disabled]) input[class='" + checkboxClass + "']").each(
	    function() {
		if(this.checked)
		    this.checked = false;
		else
		    this.checked = true;
	    });
    if(jq("tbody tr:not([disabled]) input[class='" + checkboxClass
	    + "']:checked").length > 0){
	jq("#check_all_input").attr("checked", "checked");
    }else{
	jq("#check_all_input").attr("checked", "");
    }
}
function checkAll(checkbox, checkboxClass) {
    if(!checkboxClass){
	checkboxClass = "ids"
    }
    var check = ($(checkbox).attr('checked'));
    jq("input[class='" + checkboxClass + "']").each(
	    function() {
		this.checked = check;
	    });
}
function createInputEdit(obj, id, name, type) {
    var action = CURR_ACTION;
    var val = jq.trim(jq(obj).html());
    var input;
    if(jq("#" + action + "_" + name + "_" + id).length == 0){
	var txt = document.createElement("INPUT");
	txt.id = action + "_" + name + "_" + id;
	txt.className = 'textinput';
	jq(obj).parent().append(txt);
	input = jq(txt);
	input.keypress(function(e) {
	    if(e.keyCode == 13){
		this.blur();
		return false;
	    }
	    if(e.keyCode == 27){
		jq(obj).show();
		jq(this).hide();
	    }
	});
	input.blur(function() {
	    if(jq.trim(this.value).length > 0){
		var err = false;
		var value = jq.trim(this.value);
		val = jq.trim(jq(obj).html());
		if(type == 'number'){
		    val = parseFloat(val);
		    value = parseFloat(value);
		    if(isNaN(value))
			err = true;
		}
		if(val == value || err){
		    jq(obj).show();
		    jq(this).hide();
		    return false;
		}
		submitEdit(obj, id, value, name);
	    }else{
		jq(obj).show();
		jq(this).hide();
	    }
	});
    }else
	input = jq("#" + action + "_" + name + "_" + id);
    input.val(val);
    var width = jq(obj).width() + 12;
    if(width > jq(obj).parent().width() - 12)
	width = jq(obj).parent().width() - 12;
    input.show();
    moveEnd(input[0]);
//    input.width(width).focus();
    jq(obj).hide();
}
/**
 * 移动光标到最后
 * 
 * @param html
 *                input元素
 */
function moveEnd(obj) {
    obj.focus();
    var len = obj.value.length;
    if(document.selection){
	var sel = obj.createTextRange();
	sel.moveStart('character', len);
	sel.collapse();
	sel.select();
    }else if(typeof obj.selectionStart == 'number'
	    && typeof obj.selectionEnd == 'number'){
	obj.selectionStart = obj.selectionEnd = len;
    }
}
function textEdit(obj, id, name) {
    createInputEdit(obj, id, name, 'text')
}
function numberEdit(obj, id, name) {
    createInputEdit(obj, id, name, 'number')
}
/**
 * 修改单字段
 * 
 * @param obj
 * @param id
 * @param value
 * @param field
 */
function submitEdit(obj, id, value, field) {
    var query = new Object();
    query.field = field;
    query.value = value;
    query.id = id;
    var action = CURR_ACTION;
    jq.ajax({
	url : url(CURR_MODULE, CURR_ACTION, FILED_EDIT_METHOD),
	type : "POST",
	cache : false,
	data : query,
	dataType : "json",
	error : function() {
	    jq(obj).show();
	    jq("#" + action + "_" + field + "_" + id).hide();
	},
	success : function(result) {
	    if(result.code == 0)
		alert(result.message);
	    else
		jq(obj).html(result.content);
	    jq(obj).show();
	    jq("#" + action + "_" + field + "_" + id).hide();
	}
    });
}
/**
 * 排序
 * 
 * @param field
 *                排序字段
 * @param sort
 *                排序顺序
 * @param method
 *                排序方法
 */
function sortBy(field, sort, method) {
    var url = location.href;
    url = url.replace(/(p=\d+?&)|(p=\d+?$)/g, '');
    var len = url.length;
    if(url.substr(len - 1) == '&')
	url = url.substr(0, len - 1);
    if(method){
	// 如果指定排序方法
	if(url.search(/met=.+?&/g) > -1)
	    url = url.replace(/met=.+?&/g, 'met=' + method + '&');
	else if(url.search(/met=.+?$/g) > -1)
	    url = url.replace(/met=.+?$/g, 'met=' + method);
	else
	    url += '&met=' + method;
    }
    if(url.search(/order=.+?&/g) > -1){
	url = url.replace(/order=.+?&/g, 'order=' + field + '&');
    }else if(url.search(/order=.+?$/g) > -1){
	url = url.replace(/order=.+?$/g, 'order=' + field);
    }
    else{
	if(url.indexOf('?') > -1){
	    url += '&order=' + field;
	}else{
	    url += '?order=' + field;
	}
    }
    if(url.search(/sort=.+?&/g) > -1)
	url = url.replace(/sort=.+?&/g, 'sort=' + sort + '&');
    else if(url.search(/sort=.+?$/g) > -1)
	url = url.replace(/sort=.+?$/g, 'sort=' + sort);
    else
	url += '&sort=' + sort;
    var fun = function() {
	location.href = url;
    };
    setTimeout(fun, 1);
}
function toggleStatus(obj, id, name) {
    if(jq('img', obj).length == 0)
	return false;
    var action = CURR_ACTION;
    var value = parseInt(jq('img', obj).get(0).getAttribute('status'));
    var query = new Object();
    query.field = name;
    if(value){
	// 如果当前的状态存在则修改为0
	query.value = 0;
    }else{
	query.value = 1;
    }
    query.id = id;
    jq.ajax({
	url : url(CURR_MODULE, CURR_ACTION, FILED_EDIT_METHOD),
	type : "POST",
	cache : false,
	data : query,
	dataType : "json",
	success : function(result) {
	    if(result.code == 0){
		alert(result.message);
	    }else{
		var img = jq('img', obj).get(0);
		var src = img.src.replace(value + '.gif', result.content
			+ '.gif');
		if(result.code){
		    img.setAttribute('status', query.value);
		    img.src = src;
		}else{
		    alert('修改失败');
		}
	    }
	}
    });
}
/**
 * 检测有没选择操作类型
 */
function checkOpType() {
    var isOp = false;
    jq(":radio[name='optype']").each(function() {
	if(jq(this).attr("checked") == true){
	    isOp = true;
	    return;
	}
    });
    return isOp;
}