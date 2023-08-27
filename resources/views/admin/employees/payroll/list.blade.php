@extends('admin.layout.main')

@section('content')
    <div class="main-head-franchise">
        <div class="main-deck-head main-deck-head-franchise">
            <h4>{{$sub_title}}</h4>
        </div>
        <!--<div class="add-franchise-butn-main">
            <a href="{{ url('admin/addemployee') }}" class="btn"><i class="fa fa-user" aria-hidden="true"></i>Add Employee</a>
        </div>-->
        <div class="clearfix"></div>
    
		<div class="text-left">
		@if(Session::has('Success'))
			{!! session('Success') !!}
		@endif
		</div>    	
    </div>


	<form action="{{ route('admin.payroll') }}" method="get" id="search_employees">
	    <div class="frnchise-select-main">
	        <div class="admin-employees-payroll-fiter-field order-date">
                <label>Search Employee(s)</label>
                <select name="employee" class="select_employee">
                    @if(!empty($AllEmployees))
                        <option value="">Select</option>
                        @foreach($AllEmployees as $eachEmployee)
                            <option @if($employee == $eachEmployee->id) selected @endif value="{{ $eachEmployee->id }}">{{ $eachEmployee->fullname }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="admin-employees-payroll-fiter-field order-date">
                <label>For the Month of</label>
                <select name="month" class="select_month">
                    <option value="">Select</option>
                    @foreach($months as $key => $name)
                        <option @if($key == $month) selected @endif value="{{$key}}">{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-employees-payroll-fiter-field order-date">
                <label>Date Range From</label>
                <input type="text" placeholder="Date" id="datefrom" name="datefrom" class="datefrom daterange" autocomplete="off" value="{{$datefrom}}">
                <a><i class="fa fa-calendar datefrom" aria-hidden="true"></i></a>
            </div>
            <div class="admin-employees-payroll-fiter-field order-date">
                <label>Date Range To</label>
                <input type="text" placeholder="Date" id="dateto" name="dateto" class="dateto daterange" autocomplete="off" value="{{$dateto}}">
                <a><i class="fa fa-calendar dateto" aria-hidden="true"></i></a>
            </div>
	        <div class="fiter-butn-main">
	            <button type="submit" class="btn franchise-search-butn"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
	            <a href="{{ url('admin/employees/payroll') }}" class="btn francse-filter-butn butn-spacing-padd-1"><i class="fa fa-filter" aria-hidden="true"></i>Clear Filter</a>
	        </div>
	    </div>
    </form>

    <div class="upcoming-contact-expiration">
        <h6>{{$page_title}} <a href="javascript:viod(0);" onclick="printAllPayroll();" class="btn francse-filter-butn butn-spacing-padd-1 pull-right"><i class="fa fa-print" aria-hidden="true"></i>Print All</a></h6>
        <div class="clearfix">&nbsp;</div>
        <!--<label>Show</label><input type="number" placeholder="10" min="0"><label>Entries</label>-->
        <div class="super-admin-table-1 table-responsive" id="payroll-sheet-container">
            <table class="table-striped" border="0" id="payroll-sheet-table">
                <tr>
                    <th>Employee (s)</th>
                    <th>Hours</th>
                    <th>Short Hrs</th>
                    <th>Overtime</th>
                    <th>Hourly Rate</th>
                    <th>Total Amount</th>
                    <th class="EmployeActionBtn-1 no-print">Actions</th>
                </tr>

                @if(!$getEmployees->isEmpty())
                	@foreach($getEmployees as $employee)
		                <tr>
		                    <td>{{ substr($employee->fullname, 0, 20) .((strlen($employee->fullname) > 20) ? '...' : '') }}</td>
		                    <td>{{ $employee->total_hrs }}</td>
                            <td>{{ $employee->total_hrs-$employee->total_hrs }}</td>
                            <td>{{ $employee->overtime_hrs }}</td>
                            <td>$&nbsp;{{ $employee->starting_pay_rate  }}/hr</td>
		                    <td>$&nbsp;{{ $employee->starting_pay_rate*$employee->total_hrs  }}</td>
		                    <td class="EmployeActionBtn no-print">
			                    <a href="javascript:void(0);" onclick="window.open('{{ url('admin/employees/payroll/print/'.$employee->id) }}','Employee Payroll Sheet');" class="table-bin-butn"><i class="fa fa-print" aria-hidden="true"></i></a>
		                    </td>
		                </tr>
                	@endforeach
                @else
                	<tr><td colspan="3">No Employees payroll found.</td></tr>
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
    
 
   
<script type="text/javascript">
$(document).ready(function(){
	//$("#datefrom").datetimepicker({
	$(".datefrom").datetimepicker({	
		month: 5,
		//today:  1,
		autoclose: true,
		format: 'dd/mm/yyyy',
		maxView: 4,
		minView: 2,
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#dateto').datetimepicker('setStartDate', minDate);
	});
	
	//$("#dateto").datetimepicker({
	$(".dateto").datetimepicker({	
		autoclose: true,
		format: 'dd/mm/yyyy',
		maxView: 4,
		minView: 2,  	
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#datefrom').datetimepicker('setEndDate', minDate);
	});
	
	$('.select_month').change(function(){
		month = $(this).val();//alert(month);
		var startDate = new Date();
		startDate.setDate(1)
		startDate.setMonth(month-1);
		$('.daterange').datetimepicker('setStartDate', startDate);
	});
	
	
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

    var month        = $('select[name=\'month\']').val();
    var employee       = $('select[name=\'employee\']').val();
	var datefrom       = $('input[name=\'datefrom\']').val();
	var dateto       = $('input[name=\'dateto\']').val();

    if(month == "" && employee == "")
    {
		alert("Please Select Filter Options");
        return false;
    }
    else
    {
        if(month != "")
		{
			if(datefrom == "" || dateto == "")
			{
				alert("Please Enter Date Ranges");
				return false;
			}
		}
		url += '?';
    }

    if(employee != "")
    {
        url += 'employee=' + encodeURIComponent(employee);
    }

    if(month != "")
    {
        if(month != "")
            url += '&';
        url += 'month=' + encodeURIComponent(month);
    }
	
	if(datefrom != "")
    {
        if(datefrom != "")
            url += '&';
        url += 'datefrom=' + encodeURIComponent(datefrom);
    }
	
	if(dateto != "")
    {
        if(dateto != "")
            url += '&';
        url += 'dateto=' + encodeURIComponent(dateto);
    }

    window.location = url;
});

function printAllPayroll(){
	var divToPrint=document.getElementById('payroll-sheet-container');
	var newWin=window.open('','Payroll-Sheet');
	newWin.document.open();
	newWin.document.write('<html>');
	//newWin.document.write('<style>');
	//newWin.document.write('@media print {.no-print {display:none;}}');
	//newWin.document.write('</style>');
	newWin.document.write('<body onload="window.print()">');
	newWin.document.write(divToPrint.innerHTML);
	newWin.document.write('</body>');
	newWin.document.write('</html>');
	newWin.document.getElementById('payroll-sheet-table').border = 1;
	newWin.document.getElementById('payroll-sheet-table').width = '100%';
	var actions = newWin.document.getElementsByClassName('no-print');
	for (var i = 0; i < actions.length; i ++) {
		actions[i].style.display = 'none';
	}
	newWin.document.close();
	setTimeout(function(){newWin.close();},10);
}
</script>
@endsection
