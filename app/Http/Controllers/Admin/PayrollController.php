<?php

namespace App\Http\Controllers\Admin;

use Session;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\State;
use App\Models\Admin;
use App\Models\Admins_employees;
use App\Models\Employee_tasklist;
use App\Models\Admins_employees_schedules;
use App\Models\Admin_employees_time_punch;
use App\Models\Admin_employees_performance_log;
use App\Models\Admins_employees_emergency_contacts;

class PayrollController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
	}

    public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees Payroll Sheet";
        $sub_title                      = "Run Payroll";
        $menu                           = "employees";
        $sub_menu                       = "employees_payroll";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu
        );
 
		$getEmployees = Admin::where('type','Employee')
		->leftJoin('admin_employees_time_punch', function ($join) {
			$join->on('admins.id', '=', 'admin_employees_time_punch.admin_employee_id');
			//->selectRaw('admin_employees_time_punch.*,sum(admin_employees_time_punch.tottal_hrs) as tottal_hrs,sum(admin_employees_time_punch.overtime_hrs) as overtime_hrs')
			//->selectRaw('sos_admin_employees_time_punch.*,sum(sos_admin_employees_time_punch.total_hrs) as total_hrs,sum(sos_admin_employees_time_punch.overtime_hrs) as overtime_hrs')
  			//->groupBy('admin_employees_time_punch.admin_employee_id');
  			//->get();
		})
		->when($request->employee, function ($query, $employee) {
            return $query->where('admins.id', $employee);  
        })
		->when($request->datefrom, function ($query, $datefrom) {
            $datefrom = str_replace('/','-',$datefrom);
            return $query->where('date','>=',date("Y-m-d",strtotime($datefrom)));
        })
        ->when($request->dateto, function ($query, $dateto) {
            $dateto = str_replace('/','-',$dateto);
            return $query->where('date','<=',date("Y-m-d",strtotime($dateto)));
        })
		->selectRaw('sos_admins.*,sum(sos_admin_employees_time_punch.total_hrs) as total_hrs,sum(sos_admin_employees_time_punch.overtime_hrs) as overtime_hrs')
		->groupBy('admin_employees_time_punch.admin_employee_id')
		->orderby('admins.created_at','desc')->paginate($this->pagelimit);
		
		$AllEmployees = Admin::where('type','Employee')->orderby('created_at','desc')->get();
            
		$data['month'] = $request->month;
		$data['employee'] = $request->employee;
		$data['datefrom'] = $request->datefrom;
		$data['dateto'] = $request->dateto;
		$data['AllEmployees'] = $AllEmployees;
		$data['getEmployees'] = $getEmployees;
		
		$data['months'] = array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);

	    return view('admin.employees.payroll.list',$data);
	}
	
	public function printEmployeePayroll($employee_id)
    {
		//If ID IS NULL THEN REDIRECT
        if(!$employee_id) 
		return redirect('admin/employees/payroll');
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees/payroll');
		}

        $data['Employee'] = $Employee;
		$data['Employee_time_punches'] = $Employee->employees_time_punch;
		
	    return view('admin.employees.payroll.print',$data);
	}
}