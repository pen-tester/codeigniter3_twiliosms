<link href="/assets/styles/chat.css?2" rel="stylesheet"/>
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
</div>
    <div class="profile" id="profilemsg">
        <input type="hidden" id="sel_phone" >
        <div class="btnclose close" data-target="profilemsg">
            &times;
        </div>
       
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>PhoneNumber:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <span class="property_val showphone" data-target="phone"></span>
                </div>
            </div>           
        </div>  
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>Name:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <span class="property_val showname" data-target="firstname,lastname"></span>
                </div>
            </div>           
        </div>   
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>Contact & Emails:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <input class="property_val" data-target="contact"/>
                </div>
            </div>           
        </div>   
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>Property Address:</label> 
                </div>
                <div class="col-sm-8 col-md-8">
                    <div> 
                        <span data-target="address,city,state,zip"  class="showmap property_val showaddr" data-option="0"></span><span><img data-option="1" src="/assets/images/google.jpg" class="showmap" style="width:30px;height: 30px;" /></span>
                    </div>  
                </div>
            </div>           
        </div>                           
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>Lead Type:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <span class="property_val showtxt" data-target="leadtype"></span>
                </div>
            </div>           
        </div> 
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                     <label>Called:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <input type="checkbox" class="property_val checkbox"  data-target="called">
                </div>
            </div>           
        </div>         
        <div class="discovery_form">
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row">
                            <span><input class="smallitem property_val" type="text" data-target="bed" /> <label>Bed</label></span><span><input type="text"  class="smallitem property_val " data-target="bath" /> <label>Bath</label></span>                                        
                    </div>
                </div>
                <div class="col-sm-1 col-md-1"></div>
                <div class="col-sm-6 col-md-6">
                    <div class="row  text-right">
                        <label>Zillow estimate:</label>
                        <input type="text" class="mediumitem property_val" data-target="zillow_estimate" />
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row text-right" >
                        <label>Year Built:</label> <input type="text" class="mediumitem property_val" data-target="year_built" />
                    </div>
                </div>
                <div class="col-sm-7 col-md-7">
                    <div class="row text-right">
                        <span><label>Owe:</label><input type="text" class="mediumitem property_val"  data-target="owe"/> </span>
                        <span><label>Offer:</label><input type="text" class="mediumitem property_val" data-target="offer" /> </span>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row text-right">
                        <label>Sq Ft:</label> <input type="text" class="mediumitem property_val "  data-target="sqft"/>
                    </div>
                </div>
                <div class="col-sm-7 col-md-7">
                    <div class="row text-right">
                        <label>Lot size:</label>
                        <input type="text" class="property_val"   data-target="lot_size"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row">
                        <label>Central AC:</label> 
                        <a class="btn btn-default btn-select arrow_width property_val selectbox"  data-target="central_ac">
                            <input type="hidden" class="btn-select-input" id="number_entries_perpage" name="" value="-1" />
                            <span class="btn-select-value">Select an Item</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul>
                                <li data-value="1">YES</li>
                                <li data-value="0" class="selected">NO</li>
                            </ul>
                        </a>
                    </div>
                </div>
                <div class="col-sm-7 col-md-7">
                    <div class="row  text-right">
                        <label>A/C Notes:</label>
                        <input type="text" class="property_val" data-target="ac_note"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Roof:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input type="text" class="property_val" data-target="roof" />
                </div>                
            </div>    
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Garage:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input type="text" class="property_val" data-target="garage" />
                </div>                
            </div>  
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Pool:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input type="text" class="property_val" data-target="pool"/>
                </div>                
            </div>  
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Repairs:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input type="text" class="property_val" data-target="repairs" />
                </div>                
            </div>                                                       

            <div class="row">
                <div class="col-sm-7 col-md-7">
                    <div class="row">
                        <label>Occupancy:</label> 
                        <a class="btn btn-default btn-select large_select property_val selectbox" data-target="occupancy">
                            <input type="hidden" class="btn-select-input" id="number_entries_perpage" name="" value="-1" />
                            <span class="btn-select-value">Select an Item</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul>
                                <li data-value="1">Yes - Primary</li>
                                <li data-value="2">Yes - 2nd Home</li>
                                <li data-value="3" >Rented</li>
                                <li data-value="0" class="selected">No</li>
                            </ul>
                        </a>

                    </div>
                </div>
                <div class="col-sm-5 col-md-5">
                    <div>
                        <label>Rent:</label>
                        <input type="text" class="mediumitem property_val" data-target="rent" />
                    </div>
                </div>
            </div>    
            <div class="row">
                <div>
                    <label>Other Notes:</label> <textarea  class="property_val" data-target="note"></textarea> 
                </div>
            </div>   
            <div class="row">
                <div>
                    <label>Zillow link:</label> <input class="property_val" type="text" data-target="zillow_link" />
                </div>
            </div>                                           
    </div>
        <div class="modal_area" id="errorbox">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Errors</h3>
                    </div>
                    <div class="modal-body" id="errorcontent"> 
                    	
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btnclose" data-target="errorbox">Close</button>
                      </div>
                </div>
            </div>
        </div>

<!--<script defer src="https://www.gstatic.com/firebasejs/4.5.2/firebase.js"></script> -->
<script defer type="text/javascript" src="/assets/js/messenger/util.js?3"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/context.js?2"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/showprofile.js?3"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/chat.js?4"></script> 

