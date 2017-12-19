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
	init_profilewindow();

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

	//Change event in the profile event
	$(".property_val").change(function(){
		var field = $(this).attr("data-target");
		var target = $("#sel_phone").val();
		var value = $(this).val();
		if($(this).hasClass("checkbox")){
			value = (this.checked)?1:0;
		}
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target, field:field, value:value },
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});				
	});

	$(".property_val.selectbox ul li").click(function(){
		var target = $("#sel_phone").val();
		var field = $(this).parent().parent().attr("data-target");
		var value = $(this).attr("data-value");

		console.log("target", target);
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target,field:field,value:value},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});	

	});

	//when clicking the address, display the zillow property and google
	//option:0 => zillow property displaying from backend (search api)
	//option:1 => google map search api
	$(".showmap").click(function(){
		var addr = $(this).attr("data-addr");
		var zip=$(this).attr("data-zip");
		var option= $(this).attr("data-option");
		if(option=='0'){
			var win = window.open($(this).attr("data-url"), '_blank');					
		}else{
			var url= "https://www.google.com/maps/search/?api=1&query="+addr+", "+zip;
			var win = window.open(url, '_blank');
		}

	});

	//When clicking the zillow icon, update the profile window
	$(".update_from_zillow").attr("data-id","");
	$(".update_from_zillow").click(function(){
		var target = $(this).attr("data-id");
		if(target==""){
			$("#msgbox .modal_content").text("Please retry later .. now checking for the zillow status");
			$("#msgbox").fadeIn();			
			return;
		}
		$.ajax({
			url:"/api/api_messenger/get_zillow_detailresult",
			type:"POST",
			data:{zpid:target}
		}).done(function(response, status){
			//console.log(response.result);
			var result = response.result;
			process_zillow_info(result);
		}).fail(function(response, status){

		});
	});

	//Upload discovery form to podio
	$(".uploadPodio").click(function(){
		$.ajax({
			url:"/api/api_messenger/upload_podio",
			type:"POST",
			data:$("#discovery_form").serialize()
		}).done(function(response, status){
			console.log("podio result:",response.result);
			try{
				if(response.result.item_id !=null && response.result.item_id!=""){
					$.ajax({
						url:"/api/api_messenger/upload_seller_podio",
						type:"POST",
						data:{
							'leads[seller-name]':$("#pname").text(),
							'leads[email]':$("pemail").val(),
							'leads[seller-phone-cell]':[{'type':'mobile','value':$("#sel_phone").val()}],
							'leads[property]':response.result.item_id,
							'leads[email]':$("#pemail").val()
						}
					}).done(function(response, status){	
						$("#msgbox .modal_content").text("Successfully uploaded to podio");
						$("#msgbox").fadeIn();						
						console.log("Podio Seller", response);
					}).fail(function(response, status){
						$("#msgbox .modal_content").text("Please check your internet connection or contact with admin.");
						$("#msgbox").fadeIn();
					});			
				}
			}catch(ex){
				$("#msgbox .modal_content").text("Please check your internet connection or contact with admin."+ex);
				$("#msgbox").fadeIn();
			}
			
		}).fail(function(response, status){
			$("#msgbox .modal_content").text("Please check your internet connection or contact with admin.");
			$("#msgbox").fadeIn();
		});
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

	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})	
	setTimeout(get_newchatsms, 1500);

});

function init_profilewindow(){
		var target = $("#phonenumber").val();
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
}

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
		var time = formatDate(item.RecTime, "MM/dd/yy hh:mm a");
		if(item.FromNum == phone){ //Algign left
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeleft'>
					   <input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-left'>"
					   +time+
					   "</span></div>\
					</div>";
		}else{  //Aligin right
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeright'>
					   	<input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   `</div>
					   <div><span class='rectime text-right'>`
					   +time+
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
	var time = formatDate(item.RecTime, "MM/dd/yy hh:mm a");
		if(direction== 0){ //Algign left
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeleft'>
					   <input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-left'>"
					   +time+
					   "</span></div>\
					</div>";
		}else{  //Aligin right
			htmlitem=`<div class='row'> 
					   <div class='chatbox  placeright'>
					   	<input type="hidden" value="`+item.No+`">`+
					     item.Content+
					   `</div>
					   <div><span class='rectime text-right'>`
					   +time+
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
/*
	Update profile info from the zillow

*/

function process_zillow_info(result){
	console.log("zillow info",result , last_zillow_result);
	if(last_zillow_result != null){
		$(".zillowval_search").val(last_zillow_result[$(".zillowval_search").attr("data-zillow")]["amount"]);
		$(".zilloworigin").each(function(){
			var prop = $(this).attr("data-zillow");
			$(this).val(last_zillow_result[prop]);
		});

		$(".zillowval_search").trigger("change");
		$(".zilloworigin").trigger("change");
	}

	if(result.message.code !='0'){
		$("#msgbox .modal_content").text("Zillow response: "+result.message.text);
		$("#msgbox").fadeIn();		
		return;
	}
	var response = result.response;

	//For getting and updating the zillow info from "editedFacts"

	$(".zillowval").each(function(){
		var prop = $(this).attr("data-zillow");
		$(this).val(response.editedFacts[prop]);
	});
	$(".zillowval").trigger("change");

}