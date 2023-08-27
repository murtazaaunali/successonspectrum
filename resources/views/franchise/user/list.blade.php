@extends('franchise.layout.main')

@section('content')
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise">
            <h4 class="margin-6">{{$sub_title}}</h4>
            <p>Staff / <span id="change-bread-crumb">List</span></p>
        </div>
        <div class="add-franchise-butn-main">
            <a href="{{ url('franchise/adduser') }}" class="btn"><i class="fa fa-user" aria-hidden="true"></i>Add User</a>
        </div>
        <div class="clearfix"></div>
    
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>    	
    </div>

    <div class="upcoming-contact-expiration">
        <h6>{{$page_title}}</h6>
        
        <div class="super-admin-table-1 table-responsive">
            <table class="table-striped">
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="EmployeActionBtn-1">Actions</th>
                </tr>

                @if(!$users->isEmpty())
                	@foreach($users as $user)
		                <tr>
		                    <td>{{ substr($user->fullname, 0, 20) .((strlen($user->fullname) > 20) ? '...' : '') }}</td>
		                    <td>{{ $user->email }}</td>
		                    <td>{{ $user->type }}</td>
		                    <td class="EmployeActionBtn">
			                    <!--<a href="{{ url('franchise/edit_user/'.$user->id) }}" class="table-bin-butn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>-->
                                <a href="{{ url('franchise/edituser/'.$user->id) }}" class="table-bin-butn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			                    <a href="#" class="table-bin-butn-1 delete_employee" data-user_id="{{ $user->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
		                    </td>
		                </tr>
                	@endforeach
                @else
                	<tr><td colspan="3">No Users found.</td></tr>
                @endif
            
            </table>
        </div>
        {{--<div class="super-admin-table-bottom">
            <div class="super-admin-table-bottom-para">
            	@if($users->firstItem())
                <p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</p>
                @else
                <p>Showing 0 Entries</p>
                @endif
            </div>
            <div class="super-admin-table-bottom-pagination">
            	

				@if(Request::has('employee_name'))
					{!! $users->appends([ '_token'=>Request::get('_token'), 'employee_name'=>Request::get('employee_name'), 'employee_type'=>Request::get('employee_type')])->links() !!}
				@else
					{!! $users->links() !!}
				@endif


            </div>
            <div class="clearfix"></div>
        </div>--}}
    </div>
    
 <div class="delete-popup-main">
  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete User?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this user permanently ? This action cannot be undone</p>
          <input class="btn popup-delete-butn" type="button" value="Delete User">
        </div>
      </div>
      
    </div>
  </div>
</div>
   
<script type="text/javascript">
$(document).ready(function(){
	//code for delete Performance
	var user_id = '';
	$('.delete_employee').click(function(){
		user_id = $(this).data('user_id');
		$('#myModal2').modal('show');
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("franchise/userdelete") }}'+'/'+user_id;
	});	
});

//Filters
$("#search_employees").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr("action");

    var employee_name        = $('input[name=\'employee_name\']').val();
    var employee_type       = $('select[name=\'employee_type\']').val();

    if(employee_name == "" && employee_type == "")
    {
        alert("Please Select Filter Options");
        return false;
    }
    else
    {
        url += '?';
    }

    if(employee_name != "")
    {
        url += 'employee_name=' + encodeURIComponent(employee_name);
    }

    if(employee_type != "")
    {
        if(employee_name != "")
            url += '&';
        url += 'employee_type=' + encodeURIComponent(employee_type);
    }

    window.location = url;
});
</script>
@endsection
