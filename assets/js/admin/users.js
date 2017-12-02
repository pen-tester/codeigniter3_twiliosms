$(document).ready(function(){



	//Custom select box
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


	$(window).click(function(e){
	    $(".btn-select").each(function(){
		    // if the target of the click isn't the container nor a descendant of the container
		    if (!$(this).is(e.target) && $(this).has(e.target).length === 0) 
		    {
		        $(this).find("ul").fadeOut();
		    }

	    });
	})	

	//Action for edit sms permission
	$("body").on("click","ul.editsms li", function(){
		var target = $(this).parent().attr("data-target");
		var value = $(this).attr("data-value");
		console.log("target", target);
		$.ajax({
			url:"/adminhelper/update_member_info",
			data:{'leads[UsrId]':target,'leads[editsms]':value},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});		
	})

	//Action for edit sms permission
	$("body").on("click","ul.editactive li", function(){
		var target = $(this).parent().attr("data-target");
		var value = $(this).attr("data-value");
		console.log("target", target);
		$.ajax({
			url:"/adminhelper/update_member_info",
			data:{'leads[UsrId]':target,'leads[active]':value},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});		
	})


	//For message box
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})

	//delete the usre action
	$("body").on("click",".delete", function(){
		var target = $(this).attr("data-target");
		$.ajax({
			url:"/adminhelper/deleteuser",
			data:{userid:target},
			type:"POST"
		}).done(function(response, status){
			list_users();
		}).fail(function(response,status){

		});				
	});


	list_users();

});

function list_users()
{
	$.ajax({
		url:"/adminhelper/listusers",
		type:"POST"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			console.log(data.result);
			add_users_tolist(data.result);
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function add_users_tolist($users){
	$("#userarea tbody").html("");
	var length = $users.length;
	for(var i=0; i<length; i++){
		$item = $users[i];
		add_item($item);
	}
	refresh_selectbox();
}

function add_item(item, direction=0){  //0:add after last 1:add before the first
	var active ="Inactive";
	if(item.active != '0') 
		active="Active";

   var itemstring=
   "<tr>\
	    <td>"+item.created+"</td>\
	    <td>"+item.Name+"</td>\
	    <td>"+item.UsrId+`</td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' name='' value='`+item.editsms+`' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='editsms' data-target='`+item.UsrId+`'>
	                <li data-value='0'>No</li>
	                <li data-value='1'>Yes</li>
	            </ul>
	        </a>
	    </td>`+`<td>	            
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' name='' value='`+item.active+`' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='editactive' data-target='`+item.UsrId+`'>
	                <li data-value='0'>Inactive</li>
	                <li data-value='1'>Active</li>
	            </ul>
	        </a>
	    </td>		
	    <td>
	        <a class='delete btnpadding' data-target='`+item.UsrId+`'><i class="fa fa-trash" aria-hidden="true"></i></a>
	    </td>
	  </tr>`;	
	 if(direction==0){
	 	$("#userarea tbody").append(itemstring);
	 }
	 else{
		$("#userarea tbody").prepend(itemstring);
	 }
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
