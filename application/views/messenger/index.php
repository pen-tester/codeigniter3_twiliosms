<link href="/assets/styles/chat.css" rel="stylesheet"/>
<div class="container">

    <div class="row">
        <h3>Incoming Texts </h3>
    </div>
  
	<div class="row" id="searchbar">
        <div class="col-sm-4 form-group">
            <label>Show Entries Per Page</label>
            <a class="btn btn-default btn-select">
                <input type="hidden" class="btn-select-input" id="number_entries_perpage" name="" value="-1" />
                <span class="btn-select-value">Select an Item</span>
                <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                <ul>
                    <li data-value="10">10</li>
                    <li data-value="25">25</li>
                    <li data-value="50" class="selected">50</li>
                    <li data-value="100">100</li>
                </ul>
            </a>
        </div>	
        <div class="col-sm-4">
            <div>
                <label>Filter for Grade</label>
                <a class="btn btn-default btn-select filter_grade">
                    <input type="hidden" class="btn-select-input"  name="" value="-1" />
                    <span class="btn-select-value">Select an Item</span>
                    <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                    <ul>
                        <li data-value="-1" class="selected">Select All</li>
                        <li data-value="0">Low</li>
                        <li data-value="1">Medium</li>
                        <li data-value="2" >High</li>
                        <li data-value="2" >Nurture</li>
                    </ul>
                </a>                
            </div>
        </div>
        <div class="col-sm-4 form-group">
            <label>Search</label>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="search-query form-control filter_item" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger btn-search" type="button">
                            <span class=" glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
	</div>
	<div class="row" id="smsarea">
        <input type="hidden" id="current_no" value="-1">
		<table class="table table-striped table-hover"> 
		    <thead>
		      <tr>  
                <th class="col-xs-2 col-sm-2 col-md-2">Date / Time</th> 
                <th class="col-xs-2 col-sm-2 col-md-2">From</th>	
		        <th class="col-xs-4 col-sm-4 col-md-4">Message</th>		        
		        <th class="col-xs-1 col-sm-1 col-md-1">Lead Type</th>
		        <th class="col-xs-2 col-sm-2 col-md-2">Grade</th>
                <th class="col-xs-1 col-sm-1 col-md-1">Action</th>
		      </tr>
		    </thead>
		    <tbody>

		    </tbody>			
		</table>
	</div>
    <div class="row">
        <ul class="pagination" id="pagination">
        </ul>    
    </div>
</div>
<div class="modal_area" id="chatbox">
    <div class="modal_dialog">
        <div class="modal_title">
            <label class="title">Chat with</label>
            <span class="close btnclose" data-target="chatbox">&times;
            </span>
        </div>
        <div class="modal_content">
        </div>
        <div class="modal_footer">
            <input type="button" class="btn btn-primary btnclose"  data-target="chatbox" value="Close">
        </div>                
    </div>
</div>
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
    <div class="profile" id="moremessages">
        <input type="hidden" id="target_phone" >
        <input type="hidden" id="moreid">
        <div class="btnclose close" data-target="moremessages">
            &times;
        </div>
        <table>
            <thead>
                <tr>
                    <th class="col-xs-1 col-sm-1 col-md-1">Date / Time</th>
                    <th class="col-xs-4 col-sm-4 col-md-4">Message</th>
                </tr>               
            </thead>
            <tbody>
                
            </tbody>
        </table>                    
    </div>
    <div class="profile" id="profilemsg">
        <input type="hidden" id="sel_phone" >
        <div class="btnclose close" data-target="profilemsg">
            &times;
        </div>
        <div class="profileitem">
           <label>PhoneNumber:</label>
           <span id="lphone"></span>
        </div>  
        <div class="profileitem">
           <label>Name:</label>
           <span id="lname"></span>
        </div>  
        <div class="profileitem">
            <label>Property Address:</label>            
           <span id="laddr"></span>
        </div>
        <div class="profileitem">
            <label>Lead Type:</label>
           <span id="lleadtype"</span>
        </div>
        <div class="profileitem">
            <label>Called:</label>
            <input type="checkbox"  id="lcalled">
        </div>
        <div class="profileitem">
            <label>Notes: </label>         
           <span><input type="text"  id="lnote"></span>
        </div>                      
    </div>
<script defer="defer" type="text/javascript" src="/assets/js/messenger/pagination.js?3"></script>
<script defer="defer" type="text/javascript" src="/assets/js/messenger/main.js?5"></script>

