<?php
namespace App\Http\Controllers\Femployee;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Profile\UpdateProfile;

//Models
use App\Models\State;
use App\Models\Franchise;
use App\Models\Franchise\Femployee;
use App\Models\Franchise\Femployees_performance_log;

class PerformanceController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('femployee')->user();
		$users[] = Auth::guard('admin')->user();
	}

	public function index(Request $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Performance Record";
        $sub_title                      = "Performance Record";
        $menu                           = "performance";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );
		
		$employee_id = Auth::guard('femployee')->user()->id;
        if(!$employee_id) return redirect('femployee/dashbaord');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('femployee/dashbaord');
		}

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
		
        $PerformanceLogEvents = array(
            'Tardy',
            'Planned Time Off',
            'Unplanned Call In',
            'Performance Review',
            'Pay Change',
            'Policy Violation',
            'FMLA',
            'Bereavement Leave',
            'Human Resources'
        );

		//FILTERS FOR PERFORMANCE LOG

		$Employee_performance = Femployees_performance_log::where('admin_employee_id',$employee_id)
		->when($request->month, function ($query, $month) {
                return $query->whereMonth('date', $month);
        })->when($request->event, function ($query, $event) {
                return $query->where('event', $event);
        })->orderby('date','desc')->get();
        
        $data['PerformanceLogEvents'] = $PerformanceLogEvents;
		$data['Employee'] = $Employee;
		$data['Employee_performance']   = $Employee_performance;
		
		return view('femployee.employee.performance.listPerformancelog',$data);
	}
}
