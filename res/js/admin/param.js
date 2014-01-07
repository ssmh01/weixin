var ParamUtil = {

    paramContainerId : 'params',
    
    paramTemplate : "<li><input name='params[]' class='txt' value=''/><a href='javascript:;' onclick=\"ParamUtil.deleteParam(this)\">删除</a></li>",
   
    
    //添加一个参数
    addParam:function(){
	$('#' + this.paramContainerId).append(this.paramTemplate);
    },
    
    //删除一个参数
    deleteParam : function(element){
	$(element).parent().remove();
    }
}