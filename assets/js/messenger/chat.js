$(document).ready(function(){	
	//initFCM();
	trigger_notification();

    $(window).focus(function() {
        console.log('Window Focus');
        setTimeout(function(){
        	$("title").text($("#fromuser").val() );
        },2000); 
    });

    $(window).blur(function() {
        console.log('Window Blur');
    });

	init_chatwindow();

	$('#sms').keydown(function (e) {

	  if (e.ctrlKey && e.keyCode == 13) {
	    // Ctrl-Enter pressed
	    send_sms();
	  }
	});

	$("#btnsendsms").click(function(){
		send_sms();
	});
	$(".btnclose").click(function(){
		$("#errorbox").fadeOut();
	});

	$("#msgcontent").on("mousedown",".chatbox",function(event){
		if(event.which==3){
			console.log("right button click");
			console.log("x:", event.pageX, "y:", event.pageY);
			$(".contextmenu").css({"top":event.pageY, "left":event.pageX});
			right_clicked_target=this;
			$(".contextmenu").fadeIn();
		}
	});
	setTimeout(get_newchatsms, 1500);

});

function send_sms(){
	if(check_phone()==true){
		//$("#current_phone").text($("#phonenumber").val());
		//Calling the sned sms api.......
		console.log($("#sms").val());
		$.ajax({
		      type: 'POST',
		      url: "/api/send_singlesms",
		      data: {phone:$("#phonenumber").val(),content:$("#sms").val()}
		  })
		       //dataType: "none"})
		.done(function(data,status) 
		{ 
			console.log("success");
	      	console.log(data);
	      	$("#sms").val("");
	    }
		).fail(function(data,status){
			console.log("fail");
			console.log(data);
			$("#errorcontent").text("Send sms error");
			$("#errorbox").fadeIn();
			$("#sms").val("");
		});	

	}
	else{
		$("#errorcontent").text("Phone number is incorrect or Sms content is empty");
		$("#errorbox").fadeIn();	
	}	
}

function removechat(target){
	$.ajax({
		url:"/api/api_messenger/remove_message",
		data:{id:target},
		type:"POST"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			init_chatwindow();				
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modal_content").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function check_phone(){
	var phone = $("#phonenumber").val();
	if($("#sms").val()=="") return false;
	if(phone == "") return false;
	var reg = new RegExp("^\\+1[0-9]{10}$");
	if(reg.test(phone)) return true;
	return false;
}

function init_chatwindow(){
	$("#topid").val("-1");
	//$("#current_phone").text($("#phonenumber").val());
	//Calling the chat history....
	$("title").text($("#fromuser").val());
	$.ajax({
	      type: 'POST',
	      url: "/api/list_chat",
	      data: {phone:$("#phonenumber").val()}
	  })
	       //dataType: "none"})
	.done(function(data,status) 
	{ 
		console.log("success");
      	console.log(data);
      	initchat(data);
    }
	).fail(function(data,status){
		console.log("fail");
		console.log(data);
	});
}

function get_newchatsms(){

	if($("#topid").val()=="-1"){
		setTimeout(get_newchatsms, 1500);
		return;
	}
		var sphone = $("#phonenumber").val();
		var id = $("#topid").val();
		
		//Calling the chat history....
		$.ajax({
		      type: 'POST',
		      url: "/api/list_chat_new",
		      data: {phone:sphone,id:id}
		  })
		       //dataType: "none"})
		.done(function(data,status) 
		{ 
			console.log("success");
	      	console.log(data);
	      	addchat(data);
	      	setTimeout(get_newchatsms, 1500);
	    }
		).fail(function(data,status){
			console.log("fail");
			console.log(data);
			setTimeout(get_newchatsms, 1500);
		});			
}


function addchat(data){
	var length = data.length;
	var phone = $("#phonenumber").val(); 

	var counts=0;
	for(var i=0;i<length; i++){
		var item = data[i];
		var htmlitem;
		if(item.FromNum == phone){ //Algign left
			counts++;
			addchatitem(item,0);
		}else{  //Aligin right
			addchatitem(item,1);
		}
	}
	if(length>0){
		$("#topid").val(data[0].No);
		if(counts>0)$("title").text("("+counts+") "+$("#fromuser").val() );
	}
}

function initchat(data){
	var length = data.length;
	var phone = $("#phonenumber").val(); 
	$("#msgcontent").html("");

	for(var i=0;i<length; i++){
		var item = data[i];
		var htmlitem;
		if(item.FromNum == phone){ //Algign left
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeleft'>
					   <input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-left'>"
					   +item.RecTime+
					   "</span></div>\
					</div>";
		}else{  //Aligin right
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeright'>
					   	<input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   `</div>
					   <div><span class='rectime text-right'>`
					   +item.RecTime+
					   `</span></div>
					</div>`;
		}

		$("#msgcontent").append(htmlitem);
	}
	if(length>0){
		$("#topid").val(data[0].No);
	}
}

function addchatitem(item,direction=0){
	var htmlitem;
		if(direction== 0){ //Algign left
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeleft'>
					   <input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-left'>"
					   +item.RecTime+
					   "</span></div>\
					</div>";
		}else{  //Aligin right
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeright'>
					   	<input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   `</div>
					   <div><span class='rectime text-right'>`
					   +item.RecTime+
					   `</span></div>
					</div>`;
		}

		$("#msgcontent").prepend(htmlitem);
}

function trigger_notification()
{
    //check if browser supports notification API
    if("Notification" in window)
    {
        if(Notification.permission == "granted")
        {
            var notification = new Notification("Notification", {"body":"You will receive the new sms.", "icon":"http://qnimate.com/wp-content/uploads/2014/07/web-notification-api-300x150.jpg"});
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

