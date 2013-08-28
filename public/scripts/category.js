function loadContent(){
	path = location.pathname;
	path = path.replace(/\//g, "");
	$.post("/index_ajax",{page:page_num, category:path},function(result){
    		$("#LatestDeals").append(result);
  		});
  	page_num++;
}