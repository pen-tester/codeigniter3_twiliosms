<div class="container">
    <div class="row">
        <h3>Your incoming text messages</h3>
    </div>
	<div class="row" id="searchbar">
        <div class="col-sm-4 form-group">
            <label>Show Entries Per Page</label>
            <a class="btn btn-default btn-select">
                <input type="hidden" class="btn-select-input" id="number_entries_perpage" name="" value="-1" />
                <span class="btn-select-value">Select an Item</span>
                <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                <ul>
                    <li data-value="10" class="selected">10</li>
                    <li data-value="25">25</li>
                    <li data-value="50">50</li>
                </ul>
            </a>
        </div>	
        <div class="col-sm-4"></div>
        <div class="col-sm-4 form-group">
            <label>Search</label>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="  search-query form-control" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
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
                <th class="col-xs-1 col-sm-1 col-md-1">Date / Time</th>         <th class="col-xs-2 col-sm-2 col-md-2">From</th>	
		        <th class="col-xs-4 col-sm-4 col-md-4">Message</th>		        
		        <th class="col-xs-2 col-sm-2 col-md-2">Lead Type</th>
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
<script defer="defer" type="text/javascript" src="/assets/js/messenger/pagination.js"></script>
<script defer="defer" type="text/javascript" src="/assets/js/messenger/main.js"></script>

