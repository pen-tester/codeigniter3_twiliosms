
//show profile when displaying the main window
function show_profile(profile){
	$("#sel_phone").val(profile.phone);
	if(profile !=null){
		$(".property_val").each(function(){
			var target = $(this).attr("data-target");
			if($(this).hasClass("showphone")){
				$(this).text(phone_format(profile.phone));
			}else if($(this).hasClass("showname")){
				var name = profile.firstname;
				name = name + " " + ((profile.lastname!=null && profile.lastname!="")?profile.lastname:"");
				$(this).text(name);
			}else if($(this).hasClass("showaddr")){
				$(this).text(profile.address+", "+profile.city+", "+profile.state+", "+profile.zip);
			}else if($(this).hasClass("checkbox")){
				if(profile[target] == '0') $(this).prop("checked", false);
				else $(this).prop("checked", true);				
			}else if($(this).hasClass("selectbox")){
				$(this).find(".btn-select-input").val(profile[target]);
			}else{
				
				if($(this).hasClass("showtxt")){
					$(this).text(profile[target]);
				}else{
					$(this).val(profile[target]);
				}
			}

		});		
	}
	else{
		$(".property_val").each(function(){
			var target= $(this).attr("data-target");;
			if($(this).hasClass("showphone")){

			}else if($(this).hasClass("showname")){

			}else if($(this).hasClass("showaddr")){
				
			}else if($(this).hasClass("checkbox")){

			}else if($(this).hasClass("selectbox")){
				
			}else{			
				if($(this).hasClass("showtxt")){
					$(this).text("");
				}else{
					$(this).val("");
				}
			}

		});			
	}


	$(".showmap").attr({"data-addr":profile.address, "data-zip":profile.city+", "+profile.state});

	refresh_selectbox();

	$("#profilemsg").fadeIn();	
}
