<link href="/assets/styles/chat.css" rel="stylesheet"/>
<ul class="contextmenu">
 	<li><i class="fa fa-trash" aria-hidden="true"></i>Remove Message</li>
</ul>
<div class="container">
    <div class="chatwindow">
		<input type="hidden" value="<?php echo $phone; ?>" id="phonenumber"/>
		<input type="hidden" value="<?php echo $username; ?>" id="fromuser"/>
		<div class="row chatarea">		
			Chat with <label id="current_phone"><?php echo $username; ?></label>
		</div>
		<input type="hidden" id="topid" value="-1"/>
		<div class="row">
			<div class="col-sm-8 col-md-8">
				<textarea class="sms_content" id="sms" placeholder="Your message here"></textarea>
			</div>
			<div class="col-sm-4 col-md-4">
				<button type="button" id="btnsendsms" class="btn">
				   <i class="fa fa-paper-plane" aria-hidden="true"></i>
				</button>
			</div>		
		</div>
		<div class="row" id="msgcontent">				
		</div>
	</div>
	<div class="profile">
		<div class="profileitem">
		   <label>PhoneNumber:</label>
		   <span><?php echo $phone;?></span>
		</div>	
		<div class="profileitem">
			<label>Property Address:</label>		    
		   <span><?php if(isset($user) && $user!=null){
		   		echo( sprintf("%s %s %s %s",$user['address'],$user['city'],$user['state'],$user['zip']));
		   	}?></span>
		</div>
		<div class="profileitem">
			<label>Lead Type:</label>
		   <span></span>
		</div>
		<div class="profileitem">
			<label>Called:</label>
		   <span><?php if(isset($user) && $user!=null){
			   		if((int)$user['called']==1) echo "&#x2714";
			   		else echo "&#x2715";
		   		}?>
		 	</span>
		</div>
		<div class="profileitem">
			<label>Notes: </label>		   
		   <span><?php echo $phone;?></span>
		</div>						
	</div>
</div>
        <div class="modal" id="errorbox">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Errors</h3>
                    </div>
                    <div class="modal-body" id="errorcontent"> 
                    	The Phone Number is incorrect.
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btnclose">Close</button>
                      </div>
                </div>
            </div>
        </div>
<!--<script defer src="https://www.gstatic.com/firebasejs/4.5.2/firebase.js"></script> -->
<script defer type="text/javascript" src="/assets/js/messenger/context.js"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/chat.js"></script> 

