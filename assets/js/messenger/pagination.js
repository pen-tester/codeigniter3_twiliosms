$(document).ready(function(){

});

function init_page_area() {
	$("#pagination").html("");
	$("#pagination").append("<li class='first'><a>|&lt;</a></li>\
            <li class='prev'><a>&lt;&lt;</a></li>");

	var temp = Math.max(10,current_page+4);
	var maxpage = Math.min(total_page, temp);
	temp= Math.min(total_page-10, current_page -6);
	var minpage = Math.max(0, temp);
	for(var i=minpage; i<maxpage; i++){
		$("#pagination").append("<li class='page' data-value='"+i+"'><a>"+(i+1)+"</a></li>");
	}		
	$("#pagination li").each(function(){
		try{
			if(parseInt($(this).attr("data-value"))==current_page){
				$(this).addClass("active");
				return false;
			}
		}
		catch(e){
		}
	})
	$("#pagination").append("<li class='next'><a>&gt;&gt;</a></li>\
        <li class='last'><a>&gt;|</a></li>");
}