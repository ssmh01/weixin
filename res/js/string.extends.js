//字符串原型扩展

//去除空格
String.prototype.trim = function(){ 
	return this.replace(/(^\s*)|(\s*$)/g, ""); 
};
// 判断是否为空
String.prototype.isEmpty = function(){ 
	var str = this;
	str = str.replace(/\r\n/g,"");
	str = str.replace(/\r/g,"");
	str = str.replace(/\n/g,"");
	str = str.replace(/\s/g,"");
	if(str=="")
		return true;
	else
		return false;
};
// 转换成jquery的class格式
String.prototype.toJQueryClass = function(){
	return '.' + this;
}
// 转换成jquery的ID格式
String.prototype.toJQueryId = function(){
	return '#' + this;
}
// 是否以某字符串开始
String.prototype.startWith=function(str){
	if(str==null||str==""||this.length==0||str.length>this.length)return false;
	if(this.substr(0,str.length)==str)return true;
	else return false;
	return true;
}
// 是否以某字符串结束
String.prototype.endWith=function(str){
	if(str==null||str==""||this.length==0||str.length>this.length)return false;
	if(this.substring(this.length-str.length)==str)return true;
	else return false;
	return true;
}
// 全部替换
String.prototype.replaceAll = function(reg, string){   
    return this.replace(new RegExp(reg,"gm"),string);   
}
// 去掉标签
String.prototype.stripTags = function(){   
    return this.replace(/<[^>].*?>/g,"");   
}
// 过滤script标签
String.prototype.stripScript = function(){
	return this.replace(/<script.*?>.*?<\/script>/ig, '');
}
// 验证是否是手机
String.prototype.isMobile = function(){
    if(/^13\d{9}$/g.test(this) || (/^15[0-35-9]\d{8}$/g.test(this)) || (/^18[05-9]\d{8}$/g.test(this))){
	return true;
    }
    return false;
}

//验证是否是手机
String.prototype.isMobile = function(){
    if(/^13\d{9}$/g.test(this) || (/^15[0-35-9]\d{8}$/g.test(this)) || (/^18[05-9]\d{8}$/g.test(this))){
	return true;
    }
    return false;
}

String.prototype.toJson = function(){
	 return eval('(' + this + ')');
}
