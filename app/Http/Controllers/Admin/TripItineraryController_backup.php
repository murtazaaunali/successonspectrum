<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

//Modelss
use App\Models\State;
use App\Models\Franchise;
use App\Models\TripItinerary;

//Requests
use App\Http\Requests\Admin\Tripitinerary\CreateEventRequest;

class TripItineraryController extends Controller
{

    function __construct()
    {
        $users[] = Auth::user();
        $users[] = Auth::guard('admin')->user();
        $users[] = Auth::guard('admin')->user();
    }


    public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Trip Itinerary";
        $sub_title                      = "Trip Itinerary";
        $inner_title                    = "Franchises List";
        $menu                           = "trip_itinerary";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $franchises = Franchise::when($request->franchise, function ($query, $id) {
            return $query->where('id', $id);
        })
        ->when($request->state, function ($query, $state) {
            return $query->where('state',$state);
        })->paginate($this->pagelimit);

        $all_franchises = Franchise::get();
        $all_states     = State::get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "franchises"                            => $franchises,
            "all_franchises"                        => $all_franchises,
            "all_states"                            => $all_states
        );

        return view('admin.trip_itinerary.list',$data);
    }

    ////////////////
    // VIEW EVENT
    ///////////////	
    public function view($id, Request $request)
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

        $franchise = Franchise::find($id);
        $data['franchise'] = $franchise;
        $getEvents = TripItinerary::where('franchise_id',$franchise->id)
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
			//echo $date;
		}
		$data['date'] = $date;
		
		return view('admin.trip_itinerary.view',$data);
    }

	/////////////
	// ADD Event
	/////////////
    public function add(CreateEventRequest $request)
    {
        $addEvent = new TripItinerary();
        $addEvent->franchise_id 	= $request->selectfranchise;
        $addEvent->date 			= date('Y-m-d',strtotime($request->eventdate));
        $addEvent->start_time 		= date('H:i:s',strtotime($request->starttime));
        $addEvent->end_time 		= date('H:i:s',strtotime($request->endtime));
        $addEvent->event_name 		= $request->eventname;
        //$addEvent->event_of 		= 'Super Admin';
		$addEvent->event_of 		= 'Franchise';
        $addEvent->save();
        
        Session::flash('Success','<div class="alert alert-success">Event added successfully.</div>');
        //return redirect('admin/trip_itinerary');
		if($request->action && $request->action == "franchise_calendar")
		return redirect('admin/trip_itinerary/view/'.$request->selectfranchise);
		else
		return redirect('admin/trip_itinerary');
        
        return view('admin.trip_itinerary.list',$data);
    }
    
    ////////////
    //Edit Event
    ////////////
    public function edit($id, Request $request)
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

        $franchise = Franchise::find($id);
        $data['franchise'] = $franchise;
        $getEvents = TripItinerary::where('franchise_id',$franchise->id)
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
        
        return view('admin.trip_itinerary.edit',$data);
    }
    
    //////////////
    //Update Event
    //////////////
    public function update(Request $request)
    {
        $editEvent = TripItinerary::find($request->event_id);
        $editEvent->franchise_id 	= $request->franchise_id;
        $editEvent->date 			= date('Y-m-d',strtotime($request->eventdate));
        $editEvent->start_time 		= date('H:i:s',strtotime($request->starttime));
        $editEvent->end_time 		= date('H:i:s',strtotime($request->endtime));
        $editEvent->event_name 		= $request->eventname;
        $editEvent->save();
        
        Session::flash('Success','<div class="alert alert-success">Event updated successfully.</div>');
        return redirect('admin/trip_itinerary/edit/'.$request->franchise_id);
        
        return view('admin.trip_itinerary.list',$data);    	
    }    
}