$(document).ready(function(){
	trigger_notification();	
	$("body").on("click",".btn-select",function(){
		$(this).find("ul").toggle();
	});
	$("body").on("click",".btn-select ul li",function(){
		$(this).parent().find(".selected").removeClass("selected");
		$(this).addClass("selected");
		var current = $(this).parent().find("li.selected").attr("data-value");
		var text = $(this).parent().find("li.selected").text();
		$(this).parent().parent().find("input[type=hidden]").val(current);
		$(this).parent().parent().find(".btn-select-value").text(text);		

		reload_newsmslist();
	});
	$(".btn-select").each(function(){
		var current = $(this).find("ul li.selected").attr("data-value");
		var text = $(this).find("ul li.selected").text();
		if(current!=null){
			console.log(current);
			$(this).find("input[type=hidden]").val(current);
			$(this).find(".btn-select-value").text(text);			
		}
	});
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$("#"+target).fadeOut();
	})
	$("#pagination").on("click","li.page", function(){
		var target = $(this).attr("data-value");
		var new_page = parseInt(target);
		if(new_page!= current_page){
			current_page = new_page
			init_smsarea();
		}
	});
	$("#pagination").on("click","li.next", function(){
		if(current_page<total_page-1){
			current_page++;
			init_smsarea();
		}		
	});	
	$("#pagination").on("click","li.prev", function(){
		if(current_page>0){
			current_page--;
			init_smsarea();
		}		
	});	
	$("#pagination").on("click","li.first", function(){
			current_page=0;
			init_smsarea();
	});	
	$("#pagination").on("click","li.last", function(){
			current_page=total_page - 1;
			init_smsarea();
	});				
	reload_newsmslist();  //List the new sms first time;;;
	setTimeout(get_listrecentsms,700);
});

var total_page=0;
var current_page=0;
var entries_page = 0;

function reload_newsmslist()
{
	var old = parseInt($("#number_entries_perpage").val());
	if(entries_page!= old){
		entries_page=old;
		console.log("entries_page:", entries_page);	
		reload_pageinfo();		
	}

}

function reload_pageinfo(){
	$.ajax({
		url:"/api/api_messenger/get_numbers_newsms"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			try{
				total_page = parseInt((parseInt(data.result["total"])+entries_page-1)/entries_page);
			}catch(e){
				total_page=1;
			}			
			console.log("total pages:", total_page);
			if(total_page<=current_page){
				current_page = total_page -1;
			}
			init_smsarea();
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});	
}

function init_smsarea(){
		init_page_area();
		list_newsmslist();	
}

function list_newsmslist()
{
	$.ajax({
		url:"/api/api_messenger/get_list_newsms/"+current_page+"/"+entries_page
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			add_data_smsarea(data.result);
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function add_data_smsarea(data){
	$("#smsarea tbody").html("");
	var length = data.length;
	for(var i=0; i<length ;i++){
		var item = data[i];
		add_item(item);  //add item after last
	}
	if(length>0){
		$("#current_no").val(data[0].No);
	}else{
		$("#current_no").val("-1");
	}
}

function add_item(item, direction=0){  //0:add after last 1:add before the first
   var itemstring=
   "<tr>\
	    <td>"+item.FromNum+"</td>\
	    <td>"+item.Content+"</td>\
	    <td>"+item.RecTime+`</td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' id='number_entries_perpage' name='' value='-1' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='leadtype'>
	                <li data-value='0'>Probate</li>
	                <li data-value='1'>Absentee Owner</li>
	                <li data-value='2'>Auction</li>
	            </ul>
	        </a>
	    </td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' id='number_entries_perpage' name='' value='-1' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='grade'>
	                <li data-value='0'>1</li>
	                <li data-value='1'>2</li>
	                <li data-value='2'>3</li>
	                <li data-value='3'>4</li>
	                <li data-value='4'>5</li>
	            </ul>
	        </a>
	    </td>		
	    <td>
	        <a><i class='fa fa-paper-plane' aria-hidden='true'></i></a>
	        &nbsp;
	        <a><i class='fa fa-weixin' aria-hidden='true'></i></a>
	    </td>
	  </tr>`;	
	 if(direction==0){
	 	$("#smsarea tbody").append(itemstring);
	 }
	 else{
		$("#smsarea tbody").prepend(itemstring);
	 }
}

function get_listrecentsms(){
	//$curno='0',$page='0',$entries='10'
	var current_no = $("#current_no").val();
	if(current_no == "-1") {
		setTimeout(get_listrecentsms,1500);
		return;
	}
	$.ajax({
		url:"/api/api_messenger/get_list_recentnewsms",
		type:"POST",
		data:{
			curno:current_no,
			page:current_page,
			entry:entries_page
		}
	})
	.done(function(data,status){
		add_newdata_smsarea(data.result);
		console.log("success", data);
		setTimeout(get_listrecentsms,1500);
		
	})
	.fail(function(data,status){
		console.log("fail", data);
		setTimeout(get_listrecentsms,1500);
		
	});
}

function add_newdata_smsarea(data){
	var length = data.length;
	for(var i=0; i<length ;i++){
		var item = data[i];
		add_item(item,1);  //add item after last
		$("#smsarea tbody tr").last().remove();
		trigger_notification(item);
	}
	if(length>0){
		$("#current_no").val(data[0].No);
	}else{
		
	}	
}

function trigger_notification(item=null)
{
    //check if browser supports notification API
    if("Notification" in window)
    {
        if(Notification.permission == "granted" && item!=null)
        {
            var notification = new Notification("You've received the sms from "+item.FromNum, {"body":item.Content, "icon":"http://qnimate.com/wp-content/uploads/2014/07/web-notification-api-300x150.jpg"});
            /* Remove the notification from Notification Center when clicked.*/
			notification.onclick = function () {
					//window.open(url); 
				console.log("clicked");
			};

			/* Callback function when the notification is closed. */
			notification.onclose = function () {
				console.log('Notification closed');
			};
 			setTimeout(notification.close.bind(notification), 3000);
        }
        else
        {
            Notification.requestPermission(function (permission) {
                if (permission === "granted") 
                {
                    var notification = new Notification("Notification", {"body":"You will receive the new sms.", "icon":"http://qnimate.com/wp-content/uploads/2014/07/web-notification-api-300x150.jpg"});
					notification.onclick = function () {
							//window.open(url); 
						console.log("clicked");
					};

					/* Callback function when the notification is closed. */
					notification.onclose = function () {
						console.log('Notification closed');
					};                    
					setTimeout(notification.close.bind(notification), 3000);
                }

            });
        }
    }   
    else
    {
        alert("Your browser doesn't support notfication API");
    }       
}