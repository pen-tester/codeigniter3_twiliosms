$(document).ready(function(){
	trigger_notification();	
	init_recent_userarea()

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

	$("body").on("click", ".btninfo", function(){
		$(".btninfo").removeClass("active");
		$(this).addClass("active");
		var target = $(this).attr("data-target");
		$("#sel_phone").val(target);
		$.ajax({
			url:"/api/api_messenger/get_member_info",
			data:{phone:target},
			type:"POST"
		}).done(function(response, status){
			console.log("Info",response.result);
			show_profile(response.result);

		}).fail(function(response,status){

		});
	});

	$("body").on("click","ul.grade li", function(){
		var target = $(this).parent().attr("data-target");
		var grade = $(this).attr("data-value");
		console.log("target", target);
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{'leads[phone]':target,'leads[grade]':grade},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});		
	})

	$("#lcalled").change(function(){
		var status = 0;
		if(this.checked){status =1;}
		var target = $("#sel_phone").val();
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{'leads[phone]':target,'leads[called]':status},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});			
		
	});
	$("#lnote").change(function(){
		var status = 0;
		if(this.checked){status =1;}
		var target = $("#sel_phone").val();
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{'leads[phone]':target,'leads[note]':$("#lnote").val()},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});			
		
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

	/*For adding pagination to the recent chat and incoming text */
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
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

	$("#userpagination").on("click","li.page", function(){
		var target = $(this).attr("data-value");
		var new_page = parseInt(target);
		if(new_page!= current_userpage){
			current_userpage = new_page
			init_userarea();
		}
	});
	$("#userpagination").on("click","li.next", function(){
		if(current_userpage<total_userpage-1){
			current_userpage++;
			init_userarea();
		}		
	});	
	$("#userpagination").on("click","li.prev", function(){
		if(current_userpage>0){
			current_userpage--;
			init_userarea();
		}		
	});	
	$("#userpagination").on("click","li.first", function(){
			current_userpage=0;
			init_userarea();
	});	
	$("#userpagination").on("click","li.last", function(){
			current_userpage=total_userpage - 1;
			init_userarea();
	});					

	//For filtering
	$(".filter_item").change(function(){
		list_newsmslist();
	});



	//
	$("body").on("click", ".chat", function(){
		var target = $(this).attr("data-target");
		var sms_id = $(this).attr("data-id");
		$.ajax({
			url:"/api/api_messenger/update_message_readstatus",
			data:{id:sms_id, phone:target},
			type:"POST"
		})
		.done(function(){
			init_recent_userarea();
			reload_pageinfo();
		})
		.fail(function(){

		});
		init_chatwindow(target);
	});

	$("#smsarea").on("click",".delete", function(){
		var target = $(this).attr("data-target");
		removeMessage(target);	
	})

	reload_newsmslist();  //List the new sms first time;;;
	reload_users_numberinfo();

	setTimeout(get_listrecentsms,700);
});

var total_page=0;
var current_page=0;
var entries_page = 0;

function removeMessage(target){
	$.ajax({
		url:"/api/api_messenger/remove_message",
		data:{id:target},
		type:"POST"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			reload_pageinfo();				
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modal_content").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function reload_newsmslist()
{
	var old = parseInt($("#number_entries_perpage").val());
	if(entries_page!= old){
		entries_page=old;
		console.log("entries_page:", entries_page);	
		$("#current_no").val("-1");
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
				current_page = Math.max(0, total_page -1);
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
	var searchstring = $(".search-query").val();
	var grades=[];
	$(".filter_grade").each(function(){
		if($(this).prop("checked")==true) grades.push($(this).attr("data-target"));
	});
	$.ajax({
		url:"/api/api_messenger/get_list_newsms/"+current_page+"/"+entries_page,
		data:{search:searchstring, grades:grades},
		type:"POST"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			console.log(data.result);
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
		$("#current_no").val(Math.max(parseInt(data[0].No),parseInt($("#current_no").val())));
	}else{
		//$("#current_no").val("0");
	}
	refresh_selectbox();
}

function add_item(item, direction=0){  //0:add after last 1:add before the first
	var fromuser="";
	if(item.firstname==null || item.firstname==""){
		fromuser=item.FromNum;
	}else{
		fromuser=item.firstname+" "+((item.lastname==null || item.lastname=="")?"":item.lastname);
	}
	var readstatus = "";
	if(item.readstatus=='0'){
		readstatus = "<span style='padding:0 5px;color:#00ff00'>&#9679;</span>";
			//console.log(item,"ss", item.readstatus);
	}
	//Check grade
	var grade=0;
	if(item.grade == null){
		grade=-1;
	}else{
		grade =item.grade;
	}
   var itemstring=
   "<tr>\
	    <td>"+readstatus+item.RecTime+"</td>\
	    <td>"+fromuser+"</td>\
	    <td>"+item.Content+`</td>
	    <td>`+item.leadtype+`</td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' name='' value='`+grade+`' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='grade' data-target='`+item.FromNum+`'>
	                <li data-value='0'>Low</li>
	                <li data-value='1'>Medium</li>
	                <li data-value='2'>High</li>
	            </ul>
	        </a>
	    </td>		
	    <td>
	        <a class='btninfo btnpadding' data-target='`+item.FromNum+`'><i class="fa fa-info-circle" aria-hidden="true"></i></a>
	        <a class='chat btnpadding' data-target='`+item.FromNum+`' data-id='`+item.No+`'><i class='fa fa-weixin' aria-hidden='true'></i></a>
	        <a class='delete btnpadding' data-target='`+item.No+`'><i class="fa fa-trash" aria-hidden="true"></i></a>
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
		if(data.result.length>0)list_newsmslist();
		//console.log("success", data);
		setTimeout(get_listrecentsms,1500);
		
	})
	.fail(function(data,status){
		console.log("fail", data);
		setTimeout(get_listrecentsms,1500);
		
	});
}

function add_newdata_smsarea(data){
	var length = data.length;
	/*for(var i=0; i<length ;i++){
		var item = data[i];
		add_item(item,1);  //add item after last
		var count_elements = $('#smsarea tbody tr').length;
		if(count_elements>entries_page)$("#smsarea tbody tr").last().remove();
		trigger_notification(item);
	}*/
	if(length>0){
		$("#current_no").val(data[0].No);
		init_recent_userarea();
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
            var notification = new Notification("You've received the sms from "+item.FromNum, {"body":item.Content, "icon":"https://sms.probateproject.com/assets/images.jpg"});
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

function init_chatwindow(target)
{
	$("#chatbox .title").text("Chat with "+target);

	//$("#chatbox").fadeIn();
	window.open("/messenger/chat/"+encodeURI(target),"_blank");
}

function init_recent_userarea()
{
	$("#recentchatuser tbody").html("");
	$.ajax({
		url:"/api/api_messenger/get_recent_chatusers/"+current_userpage
	}).done(function(data,status){
		var length = data.result.length;
		console.log(data.result);
		for(var i=0;i<length;i++){
			var item = data.result[i];
			add_useritem(item);
		}
		refresh_selectbox();
	}).fail(function(data,status){

	});
}

function add_useritem(item,direction=0){
	var fromuser="";
	if(item.firstname==null || item.firstname==""){
		fromuser=item.FromNum;
	}else{
		fromuser=item.firstname+" "+((item.lastname==null || item.lastname=="")?"":item.lastname);
	}
	//Check grade
	var grade=0;
	if(item.grade == null){
		grade=-1;
	}else{
		grade =item.grade;
	}
   var itemstring=
   "<tr>\
	    <td>"+item.ChatTime+"</td>\
	    <td>"+fromuser+`</td>
	    <td>`+item.Content+`</td>
	    <td>`+item.leadtype+`</td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' name='' value='`+grade+`' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='grade' data-target='`+item.FromNum+`'>
	                <li data-value='0'>Low</li>
	                <li data-value='1'>Medium</li>
	                <li data-value='2'>High</li>
	            </ul>
	        </a>
	    </td>
	    <td>
	        <a class='chat btnpadding' data-target='`+item.FromNum+`' data-id='`+item.No+`'><i class='fa fa-weixin' aria-hidden='true'></i></a>
	    </td>
	  </tr>`;	
	 if(direction==0){
	 	$("#recentchatuser tbody").append(itemstring);
	 }
	 else{
		$("#recentchatuser tbody").prepend(itemstring);
	 }	
}

var total_userpage=1;
var entry_users_perpage=5;
var current_userpage=0;

function reload_users_numberinfo(){
	$.ajax({
		url:"/api/api_messenger/get_numbers_users"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			try{
				total_userpage = parseInt((parseInt(data.result["total"])+entry_users_perpage-1)/entry_users_perpage);
			}catch(e){
				total_userpage=1;
			}			
			console.log("total pages:", total_page);
			total_userpage = Math.min(10,total_userpage);
			init_userarea();
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});	
}

function init_userarea(){
	init_recent_userarea();
	init_userpage_area();
}

function show_profile(profile){
	$("#lphone").text($("#sel_phone").val());
	if(profile!=null){
		var name = profile.firstname;
		name = name + " " + ((profile.lastname!=null && profile.lastname!="")?profile.lastname:"");
		$("#lname").text(name);
		$("#laddr").text(profile.address+", "+profile.city+", "+profile.state+", "+profile.zip);
		$("#lleadtype").text(profile.leadtype);
		if(profile.called==1){
			console.log("profile show","called set");
			$("#lcalled").prop("checked",true);
		}else{
			console.log("profile show","called unset");
			$("#lcalled").prop("checked",false);
		}
		$("#lnote").val(profile.note);
	}else{
		console.log("profile show");
		$("#lname").text("");
		$("#laddr").text("");
		$("#lleadtype").text("");
		$("#lnote").val("");	
		$("#lcalled").prop("checked",false);	
	}
	$("#profilemsg").fadeIn();
}

function refresh_selectbox(){
	$(".btn-select").each(function(){
		var sel_val = $(this).find("input[type=hidden]").val();
		var parent = this;
		try{
			if(parseInt(sel_val)!=-1){

				$(this).find("ul li").each(function(){
					var val = $(this).attr("data-value");
					var text = $(this).text();
					if(val==sel_val) {
						$(this).addClass("selected");

						$(parent).find(".btn-select-value").text(text);
						return false;
					}
				});
			}
		}catch(e){

		}
	})
}