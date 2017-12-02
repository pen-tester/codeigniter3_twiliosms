<link href="/assets/styles/admin/users.css" rel="stylesheet"/>
<div class="container">

    <div class="row">
        <h3>Users List</h3>
    </div>
  
	<div class="row" id="userarea">
        <input type="hidden" id="current_no" value="-1">
		<table class="table table-striped table-hover"> 
		    <thead>
		      <tr>  
                <th class="col-xs-2 col-sm-2 col-md-2">Date / Time</th> 
                <th class="col-xs-2 col-sm-2 col-md-2">User Name</th>	
		        <th class="col-xs-3 col-sm-3 col-md-3">Email</th>		        
		        <th class="col-xs-2 col-sm-2 col-md-2">SMS Edit</th>
                <th class="col-xs-2 col-sm-2 col-md-2">Status</th>
                <th class="col-xs-1 col-sm-1 col-md-1">Action</th>
		      </tr>
		    </thead>
		    <tbody>

		    </tbody>			
		</table>
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

<script defer="defer" type="text/javascript" src="/assets/js/admin/users.js?2"></script>