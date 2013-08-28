function TitleMouseOver(event)
    {
    	obj = event.srcElement ? event.srcElement : event.target;
    	if (obj.nodeName!="span"){
    		obj=obj.parentNode;
    	}
    	var x=obj.getElementsByTagName("span");
		for (var i=0;i<x.length;i++)
		{
  			x[i].style.color="#FF5B5B";
  		}
}

function TitleMouseOut(event)
    {
    	obj = event.srcElement ? event.srcElement : event.target;
    	if (obj.nodeName!="span"){
    		obj=obj.parentNode;
    	}
    	var x=obj.getElementsByTagName("span");
		for (var i=0;i<x.length;i++)
  		{
  			x[i].style.color="#FF0000";
  		}
}

var page_num=2;
window.onscroll = function(){
	if (document.documentElement.scrollTop+document.body.scrollTop+document.documentElement.clientHeight+100 >= document.documentElement.scrollHeight){
		loadContent();
	}
}