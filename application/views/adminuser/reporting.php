<link href="/assets/styles/admin/reporting.css" rel="stylesheet"/>
<link href="/assets/js/libs/daterangepicker/daterangepicker.css" rel="stylesheet"/>
<script defer="defer" type="text/javascript" src="/assets/js/libs/angular/angular.min.js"></script>
<script defer="defer" type="text/javascript" src="/assets/js/libs/angular/angular-route.min.js"></script>
<script defer="defer" type="text/javascript" src="/assets/js/libs/angular/angapp.js"></script>
<script defer="defer" type="text/javascript" src="/assets/js/admin/reportingController.js?2"></script>
<script defer type="text/javascript" src="/assets/js/libs/daterangepicker/moment.min.js?5"></script> 
<script defer type="text/javascript" src="/assets/js/libs/daterangepicker/daterangepicker.js?5"></script> 
<script defer type="text/javascript" src="/assets/js/admin/reporting.js?5"></script> 
<div ng-app="mainApp" ng-controller="reportingController" id="reportingController">
    <div class="searchbarcontainer" >
        <div class="searchbar">
            <div>
                <label>&nbsp;</label>
                <div class="datetimewrapper">
                    <input type="text" id="daterange" />
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                </div>
            </div>                
            <div>
                <label>Podio</label>
                <a class="btn btn-default btn-select selentry">
                    <input type="hidden" class="btn-select-input" id="number_entries_perpage" name="" value="{{podio.value}}" />
                    <span class="btn-select-value">{{podio_con.name}}</span>
                    <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                    <ul>
                        <li data-value="item.value" ng-repeat="item in drop_yesno" ng-click="select_podio_con(item)">{{item.name}}</li>
                    </ul>
                </a>
            </div>	
            <div>
                <div>
                    <label>&nbsp;</label>
                    <div class="filter_group_without_label">
                        <span>
                            <input type="checkbox" checked="checked" ng-model="search_conditions.cashbuyer" value="1">Cash Buyer
                        <span>
                        <span>
                            <input type="checkbox" checked="checked" ng-model="search_conditions.realtor">Realtor
                        <span>
                    </div>              
                </div>
            </div>            
            <div >
                <div>
                    <label>Star</label>
                    <a class="btn btn-default btn-select filter_star">
                        <input type="hidden" class="btn-select-input"  name="" value="{{star_con.value}}" />
                        <span class="btn-select-value">{{star_con.name}}</span>
                        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                        <ul>
                            <li data-value="item.value" ng-repeat="item in drop_yesno" ng-click="select_star_con(item)">{{item.name}}</li>
                         </ul>
                    </a>                
                </div>
            
            </div>    
            <div>
                <div>
                    <label>Filter for Grade</label>
                    <div class="filter_grade">
                        <span>
                            <input type="checkbox" checked="checked" value="Low">Low
                        <span>
                        <span>
                            <input type="checkbox" checked="checked"  value="Medium" >Medium
                        <span>
                        <span>
                            <input type="checkbox" checked="checked"  value="High">High
                        <span>
                        <span>
                            <input type="checkbox" checked="checked"  value="Nurture">Nurture
                        <span>
                    </div>              
                </div>
            </div>
            <div>
                <div>
                    <label>Users</label>
                    <a class="btn btn-default btn-select mediumwidth dropusers">
                        <input type="hidden" class="btn-select-input" id="dropusers" value="{{user_con.No}}" />
                        <span class="btn-select-value">{{user_con.Name}}</span>
                        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                        <ul>
                            <li data-value="item.No" ng-repeat="item in allusers" ng-click="select_user_con(item)">{{item.Name}}</li>
                        </ul>
                    </a>                
                </div>
            </div> 
            <div>
                <div>
                    <label>Lead Type</label>
                    <a class="btn btn-default btn-select mediumwidth dropleadtype">
                        <input type="hidden" class="btn-select-input" id="dropleadtype" value="{{leadtype_con.leadtype}}" />
                        <span class="btn-select-value">{{leadtype_con.leadtype}}</span>
                        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                        <ul>
                            <li data-value="item.leadtype" ng-repeat="item in allleadtyps" ng-click="select_leadtype_con(item)">{{item.leadtype}}</li>
                        </ul>
                    </a>                
                </div>
            
            </div>                
            <div>
                <label>Search</label>
                <div>
                    <div class="formgroup">
                        <input type="text" class="search-query form-control filter_item" placeholder="Search" ng-model="search_conditions.keyword" />
                            <button class="btn btn-danger btn-search abs_loaction" type="button">
                                <span class=" glyphicon glyphicon-search"></span>
                            </button>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <div class="container">
        {{search_conditions}}
        <div class="row resultwrapper">
            <div class="col-md-4">
                <div class="row">
                    <h3>Results:</h3>
                </div>
                <div class="row">
                    Total sms sent:
                </div>
                <div class="row">
                    Total sms batch sent:
                </div>
                <div class="row">
                    Total called:
                </div>   
                <div class="row">
                    Total starred:
                </div>     
                <div class="row">
                    Total high:
                </div>     
                <div class="row">
                    Total medium:
                </div>     
                <div class="row">
                    Total low:
                </div>      
                <div class="row">
                    Total sent to podio:
                    <label>Realtors #</label>
                    <label>Cash Buyers #</label>
                </div>   
                <div class="row">
                    Occupancy:
                    <label>Yes Primary #</label>
                    <label>Yes Second #</label>
                    <label>Rented #</label>
                    <label>No #</label>
                </div>                                                                                                                                            
            </div>
            <div class="col-md-8">
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
</div>