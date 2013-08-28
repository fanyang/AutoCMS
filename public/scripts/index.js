function loadContent(){
	$.post("/index_ajax",{page:page_num},function(result){
    		$("#LatestDeals").append(result);
  		});
  	page_num++;
}