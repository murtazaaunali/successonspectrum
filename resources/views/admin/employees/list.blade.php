@extends('admin.layout.main')

@section('content')
<div class="main-head-franchise">
    <div class="main-deck-head main-deck-head-franchise">
        <h4>{{$sub_title}}</h4>
    </div>
    <div class="add-franchise-butn-main">
        <a href="{{ url('admin/addemployee') }}" class="btn"><i class="fa fa-user" aria-hidden="true"></i>Add Employee</a>
    </div>
    <div class="clearfix"></div>

    <div class="text-left">
    @if(Session::has('Success'))
        {!! session('Success') !!}
    @endif
    </div>    	
</div>


<form action="{{ route('admin.employees') }}" method="get" id="search_employees">
    <div class="frnchise-select-main">
        <label>Search By Name</label>
        <input type="text" placeholder="Search By Name" name="employee_name" value="{{ Request::get('employee_name') }}">
        <label>Title</label>
        <select name="employee_type">
            <option value="">Search By Title</option>
            <option @if(Request::get('employee_type') == 'Director of Administration') selected @endif >Director of Administration</option>
            <option @if(Request::get('employee_type') == 'Human Resources') selected @endif>Human Resources</option>
            <option @if(Request::get('employee_type') == 'Director of Operations') selected @endif>Director of Operations</option>
            <option @if(Request::get('employee_type') == 'SOS Distribution') selected @endif>SOS Distribution</option>
        </select>
        <div class="fiter-butn-main">
            <button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
            <a href="{{ url('admin/employees') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
        </div>
    </div>
</form>

<div class="upcoming-contact-expiration">
    <h6>{{$page_title}}</h6>
    <!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
    <div class="super-admin-table-1 table-responsive">
        <table class="table-striped">
            <tr>
                <th>Employee Name</th>
                <th>Title</th>
                <th>Status</th>
                <th>Performance Review</th>
                <th class="EmployeActionBtn-1">Actions</th>
            </tr>

            @if(!$getEmployees->isEmpty())
                @foreach($getEmployees as $employee)
                    <tr>
                        <td>{{ substr($employee->fullname, 0, 20) .((strlen($employee->fullname) > 20) ? '...' : '') }}</td>
                        <td>{{ $employee->employee_title }}</td>
                        <td @if($employee->employee_status == '0') style="color: #fc6666 !important;" @endif>
                            @if($employee->employee_status == '1') 
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        <td>{{ date('m/d/Y', strtotime($employee->upcomming_performance)) }}</td>
                        <td class="EmployeActionBtn">
                            <a href="{{ url('admin/employee/view/'.$employee->id) }}" class="table-bin-butn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ url('admin/employee/edit/'.$employee->id) }}" class="table-bin-butn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="#" class="table-bin-butn-1 delete_employee" data-employee_id="{{ $employee->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="3">No Employees found.</td></tr>
            @endif
        
        </table>
    </div>
    <div class="super-admin-table-bottom">
        <div class="super-admin-table-bottom-para">
            @if($getEmployees->firstItem())
            <p>Showing {{ $getEmployees->firstItem() }} to {{ $getEmployees->lastItem() }} of {{ $getEmployees->total() }} entries</p>
            @else
            <p>Showing 0 Entries</p>
            @endif
        </div>
        <div class="super-admin-table-bottom-pagination">
            
            @if(Request::has('employee_name'))
                {!! $getEmployees->appends([ '_token'=>Request::get('_token'), 'employee_name'=>Request::get('employee_name'), 'employee_type'=>Request::get('employee_type')])->links() !!}
            @else
                {!! $getEmployees->links() !!}
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
      <div class="modal-content DeleteEmployeepopup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Employee?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this user permanently ? All data of the existing user will be lost. This action cannot be undone</p>
          <input class="btn popup-delete-butn" type="button" value="Delete Employee">
        </div>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	//code for delete Performance
	var employee_id = '';
	$('.delete_employee').click(function(){
		employee_id = $(this).data('employee_id');
		$('#myModal2').modal('show');
	});
	
	$('.popup-delete-butn').click(function(){
		window.location.href = '{{ url("admin/employee/delete") }}'+'/'+employee_id;
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
