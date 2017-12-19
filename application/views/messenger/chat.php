<link href="/assets/styles/chat.css?3" rel="stylesheet"/>
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
<form id="discovery_form"> 
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
                    <span class="property_val showname" id='pname' data-target="firstname,lastname"></span>
                </div>
            </div>           
        </div>   
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>Contact:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <input class="property_val fullwidth"  id='pcontact'  data-target="contact"/>
                </div>              
            </div>           
        </div>
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <label>Email:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <input class="property_val fullwidth"  id='pemail' data-target="email"/>
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
                        <input type="hidden" name= "leads[property-address-map]" class="property_val showaddr">  
                        <span data-target="address,city,state,zip"  class="showmap property_val showaddr zillow" data-option="0" data-url="" data-id=""></span><span><img data-option="1" src="/assets/images/google.jpg" class="showmap" style="width:30px;height: 30px;" /></span>
                        <img data-option="1" src="/assets/images/zillow.jpeg" class="update_from_zillow" style="width:30px;height: 30px;" />
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
        <div class="profileitem">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                     <label>Owner State:</label>
                </div>
                <div class="col-sm-8 col-md-8">
                    <span class="property_val showtxt" data-target="owner_state"></span>
                </div>
            </div>           
        </div>  
                
        <div class="discovery_form">
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row">
                            <span><input name="leads[bedrooms]" class="smallitem property_val zilloworigin" type="text" data-target="bed" data-zillow="bedrooms"/> <label>Bed</label></span><span><input type="text"  name="leads[bathrooms]" class="smallitem property_val zilloworigin" data-target="bath"  data-zillow="bathrooms"/> <label>Bath</label></span>                                        
                    </div>
                </div>
                <div class="col-sm-1 col-md-1"></div>
                <div class="col-sm-6 col-md-6">
                    <div class="row  text-right">
                        <label>Zillow estimate:</label>
                        <input type="text"   name="leads[zestimate-2]" class="mediumitem property_val zillowval_search" data-target="zillow_estimate" data-zillow="zestimate" />
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row text-right" >
                        <label>Year Built:</label> <input  name="leads[year-built]" type="text" class="mediumitem property_val zilloworigin" data-target="year_built"  data-zillow="yearBuilt"/>
                    </div>
                </div>
                <div class="col-sm-7 col-md-7">
                    <div class="row text-right">
                        <span><label>Owes:</label><input  name="leads[mortgage-amount-2]" type="text" class="mediumitem property_val"  data-target="owe"/> </span>
                        <span><label>Offer:</label><input  name="leads[our-offer]" type="text" class="mediumitem property_val" data-target="offer" /> </span>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row text-right">
                        <label>Sq Ft:</label> <input  name="leads[size-of-the-house-sf]" type="text" class="mediumitem property_val  zilloworigin"  data-target="sqft" data-zillow="finishedSqFt"/>
                    </div>
                </div>
                <div class="col-sm-7 col-md-7">
                    <div class="row text-right">
                        <label>Lot size:</label>
                        <input type="text"  name="leads[lot-size]" class="property_val zilloworigin"   data-target="lot_size" data-zillow="lotSizeSqFt"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="row">
                        <label>Central AC:</label> 
                        <a class="btn btn-default btn-select arrow_width property_val selectbox"  data-target="central_ac">
                            <input type="hidden"  name="leads[listed]" class="btn-select-input" id="number_entries_perpage" name="" value="-1" />
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
                        <input  name="leads[ac-notes]" type="text" class="property_val" data-target="ac_note"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Roof:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input  name="leads[roof]" type="text" class="property_val" data-target="roof" />
                </div>                
            </div>    
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Garage:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input  name="leads[garage-2]" type="text" class="property_val zillowval" data-target="garage" data-zillow="parkingType"/>
                </div>                
            </div>  
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Pool:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input  name="leads[pool-notes]" type="text" class="property_val" data-target="pool"/>
                </div>                
            </div>  
            <div class="row">
                <div class="col-sm-3 col-md-3 text-right">
                    <label>Repairs:</label> 
                </div>
                <div class="col-sm-9 col-md-9">
                    <input  name="leads[repairs]" type="text" class="property_val" data-target="repairs" />
                </div>                
            </div>                                                       

            <div class="row">
                <div class="col-sm-7 col-md-7">
                    <div class="row">
                        <label>Occupancy:</label> 
                        <a class="btn btn-default btn-select large_select property_val selectbox" data-target="occupancy">
                            <input  name="leads[vacant2]" type="hidden" class="btn-select-input" id="number_entries_perpage" name="" value="-1" />
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
                        <input  name="leads[rent]" type="text" class="mediumitem property_val" data-target="rent" />
                    </div>
                </div>
            </div>    
            <div class="row">
                <div>
                    <label>Other Notes:</label> 
                </div>
                <div>
                    <textarea  name="leads[notes-2]"  class="property_val fullwidth" data-target="note"></textarea> 
                </div>
            </div>   
            <div class="row">
                <div class="text-center">
                    <button class="uploadPodio btn btn-primary" type="button">Upload To podio</button>
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
    </div>
</form>
<div class="modal_area" id="msgbox">
    <div class="modal_dialog">
        <div class="modal_title">
            <label>Message</label>
            <span class="close btnclose" data-target="msgbox">&times;
            </span>
        </div>
        <div class="modal_content">
        </div>
        <div class="modal_footer">
            <input type="button" class="btn btn-primary btnclose"  data-target="msgbox" value="Close">
        </div>                
    </div>
</div>
<!--<script defer src="https://www.gstatic.com/firebasejs/4.5.2/firebase.js"></script> -->
<script defer type="text/javascript" src="/assets/js/messenger/util.js?3"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/context.js?2"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/showprofile.js?8"></script> 
<script defer type="text/javascript" src="/assets/js/messenger/chat.js?17"></script> 

