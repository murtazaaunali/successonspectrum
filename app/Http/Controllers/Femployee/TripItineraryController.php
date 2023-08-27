<?php

namespace App\Http\Controllers\Femployee;

use Session;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

//Modelss
use App\Models\State;
use App\Models\Franchise;
use App\Models\TripItinerary;
use App\Models\Franchise\Femployee;
use App\Models\Franchise\Femployees_schedules;
use App\Models\Franchise\Femployees_time_punch;

//Requests
use App\Http\Requests\Franchise\Tripitinerary\CreateEventRequest;

class TripItineraryController extends Controller
{

    function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
	}

    ////////////////
    // VIEW EVENT
    ///////////////	
    public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Trip Itinerary";
        $sub_title                      = "Trip Itinerary";
        $inner_title                    = "Events";
        $menu                           = "trip_itinerary";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $employee_id = Auth::guard('femployee')->user()->id;
		$Femployee = Femployee::find(Auth::guard('femployee')->user()->id);
		$franchise = Franchise::find(Auth::guard('femployee')->user()->franchise_id);
        $getEvents = TripItinerary::where('franchise_id',$franchise->id)
        			->where('event_of','Franchise')
        			->when($request->year, function($query, $year){
        				return $query->whereYear('date', $year);
        			})
        			->when($request->monthh, function($query, $month){
        				return $query->whereMonth('date', $month);
        			})->get();

        $events = array();
        if(!$getEvents->isEmpty()){
			foreach($getEvents as $event){
				$start = $event->date;
				$end = $event->date;
				$eventDuration = ' <br><br> '.date('h:i a',strtotime($event->start_time)).' to '.date('h:i a',strtotime($event->end_time)); 
				$events[] = [
					'id' 			=> $event->id.'_'.$franchise->id,
					'start' 		=> $start,
					'end' 			=> $end,
					'title' 		=> $event->event_name.$eventDuration,
				];	
			}
		}

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
			"franchise"                             => $franchise,
            "events"                            	=> json_encode($events),
        );
		
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
		
		$date = date('Y-m-d');
		if($request->has('year') && $request->has('monthh')){
			$date = date('Y-m-d', strtotime($request->year.'-'.$request->monthh.'-'.date('d')) );
			//echo $date;
		}
		$data['date'] = $date;
		
		$days = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        $femployee_schedules_data    = array();
        $employee_schedules         = $Femployee->employee_schedules;
        $complete_hours             = 0;

        foreach($days as $day)
        {

            $time_in        = isset($employee_schedules->{$day.'_time_in'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_in'}) ) : "-";
            $time_out       = isset($employee_schedules->{$day.'_time_out'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_out'}) ) : "-";
            $total_hours    = "-";


            if($time_in != "" && $time_out != "")
            {
                $time1          = strtotime($time_in);
                $time2          = strtotime($time_out);
                $difference     = round(abs($time2 - $time1) / 3600,2);
                $total_hours    = ($difference) ? $difference : "-";
            }

            $femployee_schedules_data[] = array(
                "day"           =>  ucfirst($day),
                "time_in"       =>  $time_in,
                "time_out"      =>  $time_out,
                "total_hours"   =>  $total_hours
            );

            if($total_hours != "-") $complete_hours = $complete_hours + $total_hours;
        }
		
		//CODE FOR TIME PUNCHES WEEK FILTERS
		$current_date = Carbon::now();
		$current_year = $current_date->year;
		$current_month = $current_date->month;
		$this->date = Carbon::createFromDate(date('Y'),$current_month,date('d'));
		$current_week = $this->date->weekOfMonth;
		//$week = $request->week; //It comes from filter search
		if(!empty($request->week))
		$week = $request->week; //It comes from filter search
		else
		$week = $current_week;
		
		if(!empty($request->month))
		$month = $request->month; //It comes from filter search
		else
		$month = $current_month;
		if($week){
			$weekCount = 0; $startDate = ''; $endDate = ''; $count = 1;
			//$date = date('Y').'-'.$request->month.'-01';
			$date = date('Y').'-'.$month.'-01';
			for($i = 1; $i <= $week;  ){

				//$MondayDayCount = date("w", mktime(0, 0, 0, $request->month, $count, date('Y')));
				$MondayDayCount = date("w", mktime(0, 0, 0, $month, $count, date('Y')));
				//Counting monday for checking how many monday passed
				if($MondayDayCount == 1){
					$weekCount++;
				}
				//Check if filter week equals to passed week
				if($week == $weekCount){
					if($MondayDayCount == 1){
						$startDate = $date;
					}
					if($startDate != '' && $MondayDayCount == 0){
						$endDate = $date;
						$i++;
						break;
					}
				}
				$date = date('Y-m-d',strtotime($date.'+1 day'));
				$count++;
			}
			
			//$dates = array('startdate'=>$startDate, 'enddate'=>$endDate);
			$weeks_in_month = $this->weeks_in_month($month, $current_year);
			$startDate = current($weeks_in_month[$week]);
			$endDate = end($weeks_in_month[$week]);
			$dates = array('startdate'=>$startDate, 'enddate'=>$endDate);			
		}else{
			$dates = array();
		}
		//CODE FOR TIME PUNCHES WEEK FILTERS
		
		$data['month'] = '';
		$data['week'] = '';

        $Employee_timepunches = array();
		//IF HAS MONTH
        if($request->month)
        {
            $Employee_timepunches = Femployees_time_punch::where('admin_employee_id',$employee_id)
                ->when($dates, function ($query, $dates) {
                    return $query->whereBetween('date', [$dates['startdate'], $dates['enddate']]);
                })->get();
        }

		$data['month'] = $month;
        $data['week'] = $week;
        
		$data['Femployee'] = $Femployee;
		$data['Femployee_schedule']      = $femployee_schedules_data;
		$data['Femployee_timepunches']   = $Employee_timepunches;
		$data['Femployee_schedule_hours']= $complete_hours;
		
		$hours_logs = [];
		foreach($Employee_timepunches as $key=>$Employee_timepunch)
		{
			$hours_logs[$key]['x'] = $Employee_timepunch->date;
			$femployee_time_punch_total_hrs = $Employee_timepunch->total_hrs;
			$hours_logs[$key]['y'] = !empty($femployee_time_punch_total_hrs)?$femployee_time_punch_total_hrs:0;
		}
		$data['hours_logs']= json_encode($hours_logs);//print_r($data['hours_logs']);
		
		return view('femployee.trip_itinerary.view',$data);
    }
	

	/////////////
	// ADD Event
	/////////////
    public function add(CreateEventRequest $request)
    {
        $addEvent = new TripItinerary();
        $addEvent->franchise_id 	= Auth::guard('femployee')->user()->franchise_id;
        $addEvent->date 			= date('Y-m-d',strtotime($request->eventdate));
        $addEvent->start_time 		= date('H:i:s',strtotime($request->starttime));
        $addEvent->end_time 		= date('H:i:s',strtotime($request->endtime));
        $addEvent->event_name 		= $request->eventname;
        $addEvent->event_of 		= 'Franchise';
        $addEvent->save();
        
        Session::flash('Success','<div class="alert alert-success">Event added successfully.</div>');
        return redirect('femployee/trip_itinerary');
        
        return view('femployee.trip_itinerary.list',$data);
    }
    
    ////////////
    //Edit Event
    ////////////
    public function edit(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Trip Itinerary";
        $sub_title                      = "Trip Itinerary";
        $inner_title                    = "Edit Events";
        $menu                           = "trip_itinerary";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $franchise = Franchise::find(Auth::guard('femployee')->user()->franchise_id);
        $getEvents = TripItinerary::where('franchise_id',$franchise->id)
        			->where('event_of','Franchise')
        			->when($request->year, function($query, $year){
        				return $query->whereYear('date', $year);
        			})
        			->when($request->month, function($query, $month){
        				return $query->whereMonth('date', $month);
        			})->get();
        
        $events = array();
        if(!$getEvents->isEmpty()){
			foreach($getEvents as $event){
				$start = $event->date;
				$end = $event->date;
				$eventDuration = ' <br><br> '.date('h:i a',strtotime($event->start_time)).' to '.date('h:i a',strtotime($event->end_time)); 
				$events[] = [
					'id' 			=> $event->id.'_'.$franchise->id,
					'start' 		=> $start.' '.date('H:i:s',strtotime($event->start_time)),
					'end' 			=> $end.' '.date('H:i:s',strtotime($event->end_time)),
					'groupId' 		=> $event->event_name,
					'title' 		=> '<br>'.$event->event_name.$eventDuration,
				];	
			}
		}
		//print_r($events);exit;
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "franchise"                            	=> $franchise,
            "events"                            	=> json_encode($events),
        );

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
		
		$date = date('Y-m-d');
		if($request->has('year') && $request->has('monthh')){
			$date = date('Y-m-d', strtotime($request->year.'-'.$request->monthh.'-'.date('d')) );
		}
		$data['date'] = $date;
        
        return view('femployee.trip_itinerary.edit',$data);
    }
    
    //////////////
    //Update Event
    //////////////
    public function update(Request $request)
    {
        $editEvent = 				TripItinerary::find($request->event_id);
        $editEvent->franchise_id 	= Auth::guard('femployee')->user()->franchise_id;
        $editEvent->date 			= date('Y-m-d',strtotime($request->eventdate));
        $editEvent->start_time 		= date('H:i:s',strtotime($request->starttime));
        $editEvent->end_time 		= date('H:i:s',strtotime($request->endtime));
        $editEvent->event_name 		= $request->eventname;
        $editEvent->save();
        
        Session::flash('Success','<div class="alert alert-success">Event updated successfully.</div>');
        return redirect('femployee/trip_itinerary/edit');
        
        return view('femployee.trip_itinerary.list',$data);    	
    }
	
	///////////////////////
	//TRIP ITINERARY UPDATE
	///////////////////////
    public function tripitenaryupdate(Request $request, $id)
    {
        $days = array(
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday",
            "sunday",
        );

        $tripitenary = Femployees_schedules::findOrNew($id);
        if(!$tripitenary->exists) $tripitenary->admin_employee_id = Auth::guard('femployee')->user()->id;
        foreach($days as $day)
        {
            if( $request->{$day.'_time_in'})  $tripitenary->{$day.'_time_in'} = date("H:i:s",strtotime( $request->{$day.'_time_in'}));
            else $tripitenary->{$day.'_time_in'} = NULL;

            if( $request->{$day.'_time_out'})  $tripitenary->{$day.'_time_out'} = date("H:i:s",strtotime( $request->{$day.'_time_out'}));
            else $tripitenary->{$day.'_time_out'} = NULL;
        }
        $tripitenary->save();

        Session::flash('Success','<div class="alert alert-success">Trip Itenary updated successfully.</div>');
        return redirect('femployee/viewtripitinerary/'.$request->admin_employee_id);

    }
	
	///////////////////////////
	// Add Forgotin time punch
	///////////////////////////
	public function addTimepunch(Request $request, $employee_id){
        $Employee           = Femployee::find($employee_id);
        $employee_schedules = $Employee->employee_schedules;

		$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$time1 = new DateTime($request->time_in);
		$time2 = new DateTime($request->time_out);
		$dteDiff = $time1->diff($time2);
		$hours = $dteDiff->format("%h.%I");
		
		$fullNameday = date('w',strtotime($request->date));

        if($employee_schedules){
	        $schedule_time1          = strtotime( $employee_schedules->{strtolower($days[$fullNameday]) . '_time_in'} );
	        $schedule_time2          = strtotime( $employee_schedules->{strtolower($days[$fullNameday]) . '_time_out'} );
	        $schedule_difference     = round(abs($schedule_time2 - $schedule_time1) / 3600,2);
	        $schedule_total_hours    = ($schedule_difference) ? $schedule_difference : 0;
	        $extra_hours             = $hours - $schedule_total_hours;
		}
		
		$time = new Femployees_time_punch();
		$time->date					= date('Y-m-d',strtotime($request->date));
		$time->admin_employee_id	= $employee_id;
		$time->day					= $days[$fullNameday];
		$time->time_in				= date('H:i',strtotime($request->time_in));
		$time->time_out				= date('H:i',strtotime($request->time_out));
		$time->total_hrs			= $hours;

		if($employee_schedules){
			if($extra_hours > 0) $time->overtime_hrs = $extra_hours;
		}	

		$time->save();
		
		Session::flash('Success','<div class="alert alert-success">Time Punch Added.</div>');
		return redirect('femployee/viewtripitinerary/'.$employee_id.'?tab=timepunches');
	}  
	
	public function printReport(Request $request, $employee_id){
		$starDate = date('Y-m-d',strtotime($request->startReport));
		$endDate = date('Y-m-d',strtotime($request->endReport));
		$report = Femployees_time_punch::whereBetween('date', [$starDate, $endDate])->where('admin_employee_id',$employee_id)->orderby('date','asc')->get();
		
		$data['report'] = $report;
		$data['employee_id'] = $employee_id;
		
		return view('femployee.employee.report',$data);
	} 
	
	function weeks($month, $year){
        /*$firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
        $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
		if ($firstday!=0) $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
		else $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
	  	return $count_weeks;*/
		$weeks_in_month = $this->weeks_in_month($month, $year);
		//echo "<pre>";print_r($weeks_in_month);
		return sizeof($weeks_in_month);
	}
	
	public function getWeeks(Request $request){
		return $this->weeks($request->month, date('Y'));
	}
	
	public function weeks_in_month($month, $year)
	{
		$day_count = 1;$week = 1;$dates = [];
		$days = Carbon::createFromDate($year,$month,1)->daysInMonth;
		for ($day = 1; $day <= $days; $day++) {
			
			$dates[$week][]= Carbon::createFromDate($year,$month,$day)->format('Y-m-d');
			
			/*$dayOfWeek = Carbon::createFromDate($year,$month,$day)->format('l');
			if ($dayOfWeek === 'Sunday') {
				$week++;
			}*/
			
			if ($day_count <= 7) {
				$day_count++;
			}
			
			if ($day_count > 7) {
				$week++;
				$day_count = 1;
			}
		}
		return $dates;
	}
}