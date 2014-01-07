/**
 * 显示验证码
 * 
 * @param id
 */
function showVerificationCode(id) {
    document.getElementById(id).src = "/ajax/verify/image/?" + Math.random();
}
function createMobileVerifyCode(mobile) {
    if(mobile.isEmpty()){
	alert('请先填写手机号!');
	return;
    }
    if(!mobile.isMobile()){
	alert('请输入正确的手机号码');
	return;
    }
    $.ajax({
	url : '/ajax/verify/mobile/?mobile=' + mobile,
	type : "POST",
	dataType : "json",
	success : function(result) {
	    if(result.state == 0){
		alert(result.message);
	    }else{
		// TODO 重新获取计时
	    }
	}
    });
}
/**
 * 发送手机注册验证码
 */
function sendRegisterVerify() {
    var mobile = $('#mobile').val();
    createMobileVerifyCode(mobile);
}
function postFormHandle(formid) {
    $('#__' + formid).css('color', 'red');
}
function jumpHome(formid){
	var str = $('#__'+formid).text();
	if(str == '注册成功，正在跳转...')
		window.location.href='/';
}

// 保存KE的值
function saveEditorValue(id) {
    if(KE){
	// 如果是使用KE编辑器
	var message = KE.util.getData(id);
	jq('#' + id).val(message);
    }
}
function ajaxMenuDelete(id) {
    id = 'item_' + id;
    show(id, false, 0);
}
function bindAvatarUpload() {
    var sessionId = document.cookie.match(/PHPSESSID=([^;]+)/);
    sessionId = sessionId[1];
    var sUserAgent = window.navigator.userAgent;
    $('#file_upload').uploadify({
	'uploader' : '/res/js/uploadify/uploadify.swf',
	'script' : '/member/upload/avatar/',
	'scriptData' : {
	    'PHPSESSID' : sessionId,
	    'HTTP_USER_AGENT' : sUserAgent
	},
	'fileDataName' : 'avatar',
	'buttonImg' : '/res/images/upload.png',
	'cancelImg' : '/res/images/cancel.png',
	'fileExt' : '*.jpg;*.jpeg;*.gif;*.png',
	'sizeLimit' : 100 * 1024,
	'fileDesc' : '只允许上传jpg,jpeg,gif;png图片',
	'auto' : true,
	'width' : '54',
	'height' : '28',
	'onOpen' : function() {
	    $('#avatar_edit_waiting').show();
	    $('#file_uploadQueue').hide();
	},
	'onComplete' : function(event, ID, fileObj, response, data) {
	    $('#avatar_edit_waiting').hide();
	    response = response.toJson();
	    if(!response.state){
		alert(response.message);
		return;
	    }
	    $('#avatar').val(response.message);
	    $('#avatar_preview').attr('src', response.message);
	},
	'onError' : function(event, ID, fileObj, errorObj) {
	    $('#avatar_edit_waiting').hide();
	    alert("网络错误或图片大小超过100K限制，上传图标失败");
	}
    });
}
function openBindWindow(url) {
    var width = 600;
    var height = 400;
    var topOffset = 50;
    var params = "toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no";
    var centerX = $(window).width() / 2 + $(document).scrollLeft();
    var centerY = $(window).height() / 2 + $(document).scrollTop();
    var left = centerX - width / 2;
    var top = centerY - height / 2 + topOffset;
    params += ', width=' + width + ', height=' + height + ', top=' + top
	    + ', left=' + left;
    window.open(url, 'bindWindow', params)
}
function bindSuccess(){
    window.location.reload();
}

function unBindSuccess(){
    window.location.reload();
}

function selectsMark(){
    $('#cateid, #sub_cateid, #guess_point_id').attr('readonly', '');
    var selects = $('#selects');
    var selectsMark = $("<div id='selects_mark' style='display:block;'>&nbsp;</div>");
    selectsOffset = selects.offset();
    selectsMark.css('position', 'absolute');
    selectsMark.css('left', selectsOffset.left);
    selectsMark.css('top', selectsOffset.top);
    selectsMark.css('width', selects.width());
    selectsMark.css('height', selects.height());
    selectsMark.css('z-index', '45');
    selectsMark.css('opacity', '0');
    $('body').append(selectsMark);
}
/**
 * 竞猜二级分类
 * @param parentId
 * @param selectId
 */
function subCategorySelect(parentId, selectId, defaultTitle){
    var defaultTitle = (typeof(defaultTitle)=='undefined' || !defaultTitle)? '全部':defaultTitle;
    if(parentId == ""){
	$('#'+selectId).hide();
	$('#load_template_button').hide();
	return;
    }
    $.ajax({
	url : '/guess/category/childrens/',
	type : "POST",
	cache : false,
	data : {'parentId':parentId},
	dataType : "json",
	success : function(result) {
	    if(result.state == 0){
		alert(result.message);
	    }else if(result.message){
		var category = null;
		var html = "<option value=''>" + defaultTitle + "</option>";
		var count =result.message.length;
		for (var i=0;i<=count-1;i++) {
		    category = result.message[i];
		    html += "<option value='" + category.id + "'>" + category.name + "</option>";
		}
		$('#'+selectId).html(html);
		$('#'+selectId).show();
	    }
	}
    });
}

/**
 * 选择竞猜点
 * @param cateId
 * @param selectId
 */
function guessPointSelect(cateId, selectId, defaultTitle){
    var defaultTitle = (typeof(defaultTitle)=='undefined' || !defaultTitle)? '请选择竞猜点':defaultTitle;
    if(cateId == ""){
	$('#'+selectId).hide();
	$('#load_template_button').hide();
	return;
    }
    $.ajax({
	url : '/guess/guessPoint/ajaxgets/',
	type : "POST",
	cache : false,
	data : {'cateId':cateId},
	dataType : "json",
	success : function(result) {
	    if(result.state == 0){
		alert(result.message);
	    }else if(result.message){
		var point = null;
		var html = "<option value=''>" + defaultTitle + "</option>";
		var count =result.message.length;
		for (var i=0;i<=count-1;i++) {
		    point = result.message[i];
		    html += "<option value='" + point.id + "'>" + point.title + "</option>";
		}
		$('#'+selectId).html(html);
		$('#'+selectId).show();
	    }
	}
    });
}

function guessPointSelected(guessPointId){
    if(guessPointId){
	$('#load_template_button').show();
    }else{
	$('#load_template_button').hide();
	$('#guess_add_template').empty();
    }
}

/**
 * 加载竞猜添加模板
 */
function loadGuessAddTemplate(){
    var guessPointId=$('#guess_point_id').val();
    if(guessPointId.isEmpty()){
	 $('#guess_add_template').html('');
	return ;
    }
    var loading = "<dd><img src='/res/images/loading.gif'/><span>正在加载模板，请稍后...</span></dd>"
    $('#guess_add_template').html(loading);
    $.ajax({
	url : '/guess/add/template/',
	type : "POST",
	cache : false,
	data : {'guessPointId':guessPointId, 'inajax':'1'},
	success : function(html) {
	    $('#guess_add_template').html(html);
	    //锁定分类和竞猜点，不能再修改
	    selectsMark();
	}
    });
    
}

function closePlacard(){
    $.cookie('hide_placard', '1', {'expires':7});
    $('#notice').slideUp();
}

function deleteMenu(id){
    $('#'+id).remove();
}

/**
 * 首页通知－我知道了
 */
function noticeIdKnow(){
    $.ajax({
	url : '/member/notice/ignore/',
	type : "POST",
	cache : false,
	success : function(html) {
	    $('#notices').slideUp();
	}
    });
    
}

/**
 * 获取城市列表
 * @param provinceName
 * @param selectId
 */
function getCitySelect(provinceName, selectId, allitem){
    $.ajax({
	url : '/member/setting/citys/',
	type : "POST",
	cache : false,
	data : {'provinceName':provinceName},
	dataType : "json",
	success : function(result) {
	    if(result.state == 0){
			alert(result.message);
	    }else if(result.message){
			var city = null;
			var html = "";
			if(allitem == 1) html = "<option value='all'>全部</option>";
			
			var count =result.message.length;
			for (var i=0;i<=count-1;i++) {
			    city = result.message[i];
			    html += "<option value='" + city.name + "'>" + city.name + "</option>";
			}
			
			if (count <= 0) {
				$('#' + selectId).hide();
			}
			else {
				$('#' + selectId).html(html);
				$('#' + selectId).show();
			}
	    }
	}
    });
}
