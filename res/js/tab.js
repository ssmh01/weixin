function setTab(name,cursel,n){	
	for(i=1;i<=n;i++){
		var zx=document.getElementById(name+i);
		var con=document.getElementById("con_"+name+"_"+i);
		zx.className=i==cursel?"hover":"";
		con.style.display=i==cursel?"block":"none";
	}
}

function SetTab(objId,objContentId,hoverCss,type)
{
    var event="click";
    if(type==1)
    {
        event="mouseover";
    }
    $("#"+objId).children().each(function(i){
        $(this).bind(event,function(){
            $("#"+objId+" ."+hoverCss).removeClass(hoverCss);
            $(this).addClass(hoverCss);
            $("#"+objContentId).children().css("display","none");
            $("#"+objContentId).children().eq(i).css("display","");
        });
    });
}