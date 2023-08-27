@extends('admin.layout.main')

@section('content')
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise">
            <h4>{{$sub_title}}</h4>
        </div>
        <div class="add-franchise-butn-main">
            <a href="{{ url('admin/addfranchise') }}" class="btn"><i class="fa fa-building" aria-hidden="true"></i>Add Franchise </a>
        </div>
        <div class="clearfix"></div>
    </div>

    <form action="{{ route('admin.franchises') }}" method="get" id="search_franchise">
	    <div class="frnchise-select-main FrnchiseFields">
	        <label>Search By State</label>
            <select name="state" class="select_state">
				@if(!empty($states))
		        	<option value="">Search By State</option>
		        	@foreach($states as $getState)
			            <option @if($state == $getState->id) selected @endif value="{{ $getState->id }}">{{ $getState->state_name }}</option>
		            @endforeach
		        @endif
	        </select>

	        <label>Franchise Location</label>
            <input type="text" name="franchise_name" placeholder="Search By Franchise Location " value="{{ $franchise_name }}">
			
            <label>Status</label>
	        <select name="status">
	            <option value="" selected="">Search By Status</option>
	            <option @if($status == 'Active') selected @endif >Active</option>
	            <option @if($status === 'Terminated') selected @endif >Terminated</option>
	            <option @if($status === 'Expired') selected @endif >Expired</option>
                <option @if($status === 'Potential') selected @endif >Potential</option>
	        </select>
            
            <label>Contract Expiration (Month)</label>
	        <select name="month">
	            <option value="">Search By Contract Expiration <!--(Month)--></option>
	            @foreach($months as $key => $name)
	            	<option @if($key == $month) selected @endif value="{{$key}}">{{$name}}</option>
	            @endforeach
	        </select>
	        <div class="fiter-butn-main">
	            <button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
	            <a href="{{ url('admin/franchises') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
	        </div>
	    </div>
    </form>

	@if($franchises->isEmpty() && Request::has('state'))
	<div class="franchise-search-main">
    	@if($state_registered == 1)
        <p>No Franchises founds!</p>
        @else
		<p>Not registered to sell franchises here!</p>
        @endif
	</div>
	@endif

    <div class="upcoming-contact-expiration">
        <h6>Franchisees List</h6>
        <!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
        <!--<div class="super-admin-table-2 table-responsive">-->
        <div class="super-admin-table-1 table-responsive">
            <table class="table-striped FranchiseesListTableWidth dataTable " id="franchises_list">
                <thead>
                    <tr>
                        <th class="action-sorting @if(empty($sorting) || $sorting == 'state') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="state" data-order="@if(empty($order)) both @else {{$order}} @endif">Franchise State</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'location') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="location" data-order="@if(empty($order)) both @else {{$order}} @endif">Franchise Location</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'status') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="status" data-order="@if(empty($order)) both @else {{$order}} @endif">Status</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'fdd_expiration_date') @if($order == 'desc') sorting_desc @else sorting_asc @endif  @else sorting @endif" data-column="fdd_expiration_date" data-order="@if(empty($order)) both @else {{$order}} @endif">Contract Expiration</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'incomplete_tasks') @if($order == 'desc') sorting_desc @else sorting_asc @endif @else sorting @endif" data-column="incomplete_tasks" data-order="@if(empty($order)) both @else {{$order}} @endif">Incomplete Tasks</th>
                        <th class="action-sorting @if(!empty($sorting) && $sorting == 'upcoming_audit_date') @if($order == 'desc') sorting_desc @else sorting_asc @endif @else sorting @endif" data-column="upcoming_audit_date" data-order="@if(empty($order)) both @else {{$order}} @endif">Audit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
				@if(!$franchises->isEmpty())
                	@foreach($franchises as $franchise)
	                <tr>
	                    <td>
							@if($franchise->state != "")
							{{ $franchise->getState->state_name }}
							@else
							 - 
							@endif
						</td>
	                    <td>{{ substr($franchise->location, 0, 20) .((strlen($franchise->location) > 20) ? '...' : '') }}</td>
	                    <td @if($franchise->status == 'Terminated' || $franchise->status == 'Expired') style="color: #fc6666" @endif>{{ $franchise->status }}</td>
	                    <td @if(date('Y-m-d') > $franchise->fdd_expiration_date) style="color: #fc6666" @endif>
	                    	<?php /*?>{{ date('dS M Y',strtotime($franchise->fdd_expiration_date)) }}<?php */?>
                            @if($franchise->fdd_expiration_date != "" && $franchise->fdd_expiration_date != '0000-00-00'){{ date('m/d/Y',strtotime($franchise->fdd_expiration_date)) }}@endif
	                    </td>
                        <td>
                            @if($franchise->franchise_incomplete_tasklists()->count()) {{ $franchise->franchise_incomplete_tasklists()->count() }} @endif
	                    </td>
                        <td>
                            @if($franchise->upcoming_audit_date != '' && $franchise->upcoming_audit_date != '0000-00-00'){{ date('m/d/Y',strtotime($franchise->upcoming_audit_date)) }}@endif
	                    </td>
	                    <td class="FranchiseesListActionBtn"><a href="{{ url('admin/franchise/view/'.$franchise->id) }}" class="btn snd-mes-butn-1 eye-butn"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>
	                </tr>
                    @endforeach
                @else
                	<tr><td colspan="7">No Franchises founds</td></tr>
                @endif
                </tbody>
            </table>
            
        </div>
        <div class="super-admin-table-bottom">
            <div class="super-admin-table-bottom-para">
                @if($franchises->firstItem())
                	<p>Showing {{ $franchises->firstItem() }} to {{ $franchises->lastItem() }} of {{ $franchises->total() }} entries</p>
                @else
                	<p>Showing 0 Entries</p>
                @endif
            </div>
            <div class="super-admin-table-bottom-pagination">
            	{!!$franchises->render()!!}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<script>
//Filters
$("#search_franchise").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var filter_state        = $('select[name=\'state\']').val();
    var filter_franchise    = $('input[name=\'franchise_name\']').val();
    var filter_status       = $('select[name=\'status\']').val();
    var filter_month        = $('select[name=\'month\']').val();

    if(filter_state == "" && filter_franchise == "" && filter_status == "" && filter_month == "")
    {
        alert("Please Select Filter Options");
        return false;
    }
    else
    {
        url += '?';
    }

    if(filter_state != "")
    {
        url += 'state=' + encodeURIComponent(filter_state);
    }

    if(filter_franchise != "")
    {
        if(filter_state != "")
            url += '&';
        url += 'franchise_name=' + encodeURIComponent(filter_franchise);
    }

    if(filter_status != "")
    {
        if(filter_franchise != "" || filter_state != "")
            url += '&';
        url += 'status=' + encodeURIComponent(filter_status);
    }

    if(filter_month != "")
    {
        if(filter_franchise != "" || filter_state != "" || filter_status != "")
            url += '&';
        url += 'month=' + encodeURIComponent(filter_month);
    }

    window.location = url;
})	

$(".action-sorting").on("click",function(e){
    var url = "{{ route('admin.franchises') }}";
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
<?php /*?><script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script><?php */?>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!--<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">-->
<script>
$(document).ready(function() {
    /*$('#franchises_list').DataTable({
		"bPaginate": true,
    	"bLengthChange": false,
    	"bFilter": false,
    	"bInfo": true,
    	"bAutoWidth": false,
        "order": [[ 0, "desc" ]],
		"aoColumnDefs" : [ {'bSortable' : false,'aTargets' : [ 4 ]} ]
    });*/
});
</script>
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
