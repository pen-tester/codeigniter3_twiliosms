$(document).ready(function(){
	var menuid = "#"+$('#menuid').val();
	var subid = $('#subid').val();
	$(menuid).addClass('active');
	var element= "."+$('#menuid').val()+" ."+subid;
	console.log(element);
	$("."+$('#menuid').val()+" ."+subid).addClass('active');
//For main content
    $(window).resize(function(){
 		resizewindow();
    });
    resizewindow();

});

function resizewindow(){
     if($(window).width()<768){
     	$(".maincontent").width($(window).width());
    }else{
    	$(".maincontent").width($(window).width()-300);
    }  	
}