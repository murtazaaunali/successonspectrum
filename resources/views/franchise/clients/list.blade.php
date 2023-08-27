@extends('franchise.layout.main')

@section('content')
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise">
            <h4 class="margin-6">{{$sub_title}}</h4>
            <p>Clients / <span id="change-bread-crumb">Search</span></p>
        </div>
        <!--<div class="add-franchise-butn-main">
            <a href="{{ url('franchise/addclient') }}" class="btn"><i class="fa fa-user" aria-hidden="true"></i>Add Client</a>
        </div>-->
        <div class="clearfix"></div>
    
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>    	
    </div>
    
    <div class="white-three-box-main">
        <div class="white-box-view-employee" style="width:23.97%">
            <div class="white-box-view-employee-left">
                <p>Active Clients</p>
                <b>0</b><br />
                <span>Ocean Waiting List:&nbsp;<b>{{ $Total_Ocean_Clients }}</b></span>
                <br />
                <span>Voyager Waiting List:&nbsp;<b>{{ $Total_Voyager_Clients }}</b></span>
                <br />
                <span>Sailor Waiting List:&nbsp;<b>{{ $Total_Sailor_Clients }}</b></span>
            </div>
            <div class="white-box-view-employee-right">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="white-box-view-employee" style="width:23.97%">
            <div class="white-box-view-employee-left">
                <p>Ocean Scheduled Hours</p>
                <b>0</b><br /><br /><br /><br />
            </div>
            <div class="white-box-view-employee-right">
                <i class="fa fa-frown-o" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="white-box-view-employee" style="width:24%">
            <div class="white-box-view-employee-left">
                <p>Voyager Scheduled Hours</p>
                <b>0</b><br /><br /><br /><br />
            </div>
            <div class="white-box-view-employee-right">
                <i class="fa fa-umbrella" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="white-box-view-employee white-box-view-employee-mar" style="width:23.97%">
            <div class="white-box-view-employee-left">
                <p>Sailor Scheduled Hours</p>
                <b>0</b><br /><br /><br /><br />
            </div>
            <div class="white-box-view-employee-right">
                <i class="fa fa-umbrella" aria-hidden="true"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

	<form action="{{ route('franchise.clients') }}" method="get" id="search_clients">
	    <div class="frnchise-select-main">
	        <label>Search by Name</label>
            <input type="text" placeholder="Search By Name" name="client_name" value="{{ Request::get('client_name') }}">
	        <label>Status</label>
            <select name="client_status">
		        <option value="">Active Status</option>
		        <!--<option @if(Request::get('client_status') == 'Active') selected @endif >Active</option>
                <option @if(Request::get('client_status') == 'Terminated') selected @endif >Terminated</option>
		        <option @if(Request::get('client_status') == 'Applicant') selected @endif >Applicant</option>-->
                <option value="Active" @if(Request::get('client_status') == 'Active') selected @endif >Active</option>
                <option value="Terminated" @if(Request::get('client_status') == 'Terminated') selected @endif >Inactive</option>
		        <option value="Applicant" @if(Request::get('client_status') == 'Applicant') selected @endif >Waiting List</option>
	        </select>
            <label><!--Location-->Location of Services</label>
	        <select name="client_location">
		        <!--<option value="">Search by Location</option>-->
                <option value="">Search by Interest</option>
                <option @if( Request::get('client_location')== "SOS Center Full-me (Mon - Fri 8:00am-4:00pm)") selected="" @endif value="SOS Center Full-me (Mon - Fri 8:00am-4:00pm)">SOS Center Full-me</option>
                <option @if( Request::get('client_location')== "SOS Center Part-time") selected="" @endif value="SOS Center Part-time">SOS Center Part-time</option>
                <option @if( Request::get('client_location')== "School Shadowing 8:00am-4:00pm (with school approval)") selected="" @endif value="School Shadowing 8:00am-4:00pm (with school approval)">School Shadowing</option>
                <option @if( Request::get('client_location')== "In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)") selected="" @endif value="In-Home (Mon-Thurs 4:30pm-6:30pm) (Must live within 10 miles of the center and have no aggressive behaviors)">In-Home</option>
	        </select>
            <label>Crew</label>
            <select name="client_crew">
            		<option value="">Search by Crew</option>
            		<option @if(Request::get('client_crew') == 'Ocean') selected @endif>Ocean</option>
            		<option @if(Request::get('client_crew') == 'Voyager') selected @endif>Voyager</option>
                    <option @if(Request::get('client_crew') == 'Sailor') selected @endif>Sailor</option>
            </select>
	        <div class="fiter-butn-main">
	            <button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
	            <a href="{{ url('franchise/clients') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
	        </div>
	    </div>
    </form>

    <div class="upcoming-contact-expiration">
        <h6>{{$page_title}} List</h6>
        <!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
        <div class="super-admin-table-1 table-responsive">
            <table class="table-striped dataTable">
                <thead>
                    <tr>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'name') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="name" data-order="@if(empty($order)) both @else {{$order}} @endif">Client Name</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'status') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="status" data-order="@if(empty($order)) both @else {{$order}} @endif">Status</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'location') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="location" data-order="@if(empty($order)) both @else {{$order}} @endif">Location</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'crew') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="crew" data-order="@if(empty($order)) both @else {{$order}} @endif">Crew</th>
                        <th class="action-sorting @if(empty($sorting) || $sorting == 'auth_expiration') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="auth_expiration" data-order="@if(empty($order)) both @else {{$order}} @endif">Auth Expiration</th>
                        <th class="ClientActionBtn-1">Actions</th>
                    </tr>
				</thead>
                <tbody>
                @if(!$getClients->isEmpty())
                	@foreach($getClients as $client)
                        <tr>
		                    <td>{{ substr($client->client_childfullname, 0, 20) .((strlen($client->client_childfullname) > 20) ? '...' : '') }}</td>
		                    
		                    <td @if($client->client_status == 'Terminated') style="color: #fc6666 !important;" @endif>
                            <?php /*?>{{ $client->client_status }}<?php */?>
                            @if($client->client_status == 'Terminated')
                            Inactive
                            @elseif($client->client_status == 'Applicant')
                            Waiting List
                            @else
                            {{ $client->client_status }}
                            @endif
                            </td>
		                    <td>{{ $client->chooselocation_location }}</td>
                            <?php /*?><td>@if($client->client_crew) @if($client->ClientCrew) {{ $client->ClientCrew->crew_type }} @endif @else - @endif</td><?php */?>
                            <td>{{ $client->client_crew }}</td>
                            <td>@if($client->client_authorizationseenddate != '' && $client->client_authorizationseenddate != '0000-00-00'){{ date('m/d/Y',strtotime($client->client_authorizationseenddate)) }}@endif</td>
                            <td class="ClientActionBtn">
			                    <a href="{{ url('franchise/client/view/'.$client->id) }}" class="table-bin-butn"><i class="fa fa-eye" aria-hidden="true"></i></a>
			                    <a href="{{ url('franchise/client/edit/'.$client->id) }}" class="table-bin-butn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			                    <a href="#" class="table-bin-butn-1 delete_client" data-client_id="{{ $client->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
		                    </td>
		                </tr>
                	@endforeach
                @else
                	<tr><td colspan="3">No Clients found.</td></tr>
                @endif
            	</tbody>
            </table>
        </div>
        <div class="super-admin-table-bottom">
            <div class="super-admin-table-bottom-para">
            	@if($getClients->firstItem())
                <p>Showing {{ $getClients->firstItem() }} to {{ $getClients->lastItem() }} of {{ $getClients->total() }} entries</p>
                @else
                <p>Showing 0 Entries</p>
                @endif
            </div>
            <div class="super-admin-table-bottom-pagination">
				@if(Request::has('client_name'))
					{!! $getClients->appends([ '_token'=>Request::get('_token'), 'client_name'=>Request::get('client_name'), 'client_status'=>Request::get('client_status')])->links() !!}
				@else
					{!! $getClients->links() !!}
				@endif
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    
    <div class="delete-popup-main">
      <!-- Modal -->
      <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content Deleteclientpopup">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Delete Client?</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this client permanently ? All data of the existing client will be lost. This action cannot be undone</p>
              <input class="btn popup-delete-butn" type="button" value="Delete Client">
            </div>
          </div>
          
        </div>
      </div>
    </div>
   
<script type="text/javascript">
$(document).ready(function(){
	//code for delete Performance
	var client_id = '';
	$('.delete_client').click(function(){
		client_id = $(this).data('client_id');
		$('#myModal2').modal('show');
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("franchise/client/delete") }}'+'/'+client_id;
	});	
});

//Filters
$("#search_clients").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var client_name = $('input[name=\'client_name\']').val();
    var client_status = $('select[name=\'client_status\']').val();
	var client_location = $('select[name=\'client_location\']').val();
    var client_crew = $('select[name=\'client_crew\']').val();

    if(client_name == "" && client_status == "" && client_location == "" && client_crew == "")
    {
        alert("Please Select Filter Options");
        return false;
    }
    else
    {
        url += '?';
    }

    if(client_name != "")
    {
        url += 'client_name=' + encodeURIComponent(client_name);
    }

    if(client_status != "")
    {
        if(client_name != "")
            url += '&';
        url += 'client_status=' + encodeURIComponent(client_status);
    }

    if(client_location != "")
    {
        if(client_name != "" || client_status != "")
            url += '&';
        url += 'client_location=' + encodeURIComponent(client_location);
    }
	
	if(client_crew != "")
    {
        if(client_name != "" || client_status != "" || client_location != "")
            url += '&';
        url += 'client_crew=' + encodeURIComponent(client_crew);
    }

    window.location = url;
});

$(".action-sorting").on("click",function(e){
    var url = "{{ route('franchise.clients') }}";
	var column = $(this).data('column');
	var order_check = $.trim($(this).data('order'));

    if(order == "" && column == "")
    {
        alert("Please Select Column");
        return false;
    }
    else
    {
        if(order_check == "desc")
		{
			var order = "asc";
		}
		else if(order_check == "asc")
		{
			var order = "desc";
		}
		else
		{
			var order = "asc";
		}
		
		url += '?sorting='+column+"&order="+order;
    }
    window.location = url;
})
</script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
table.dataTable thead .sorting {
    background-image: url("https://cdn.datatables.net/1.10.20/images/sort_both.png");
}
table.dataTable thead .sorting_asc {
    background-image: url("https://cdn.datatables.net/1.10.20/images/sort_asc.png");
}
table.dataTable thead .sorting_desc {
    background-image: url("https://cdn.datatables.net/1.10.20/images/sort_desc.png");
}
thead .sorting,thead .sorting_asc,thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
    cursor: pointer;
    *cursor: hand;
    background-repeat: no-repeat;
    background-position: center right;
}
</style>
@endsection
