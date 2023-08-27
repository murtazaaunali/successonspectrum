@extends('femployee.layout.main')

@section('content')
    @if(Session::has('Success'))
        {!! session('Success') !!}
    @endif
    @php $franchise_id = Auth::guard()->user()->franchise_id;@endphp
<div class="bottom-main-super-admin">
	<div class="bottom-main-super-admin-1">
	    <div class="main-deck-head">
	        <h4>{{$sub_title}}</h4>
	    </div>
		<div class="main-deck-card-main">
			<div class="main-deck-card main-deck-card-1">
				<div class="main-deck-card-text">
					<p>Upcoming Performance Review</p>
                    @if($upcomming_performance)
					<b class="block-1">@if($upcomming_performance != "" && $upcomming_performance != '0000-00-00'){{ date('jS M Y',strtotime($upcomming_performance)) }} @else &nbsp; @endif</b>
                    <span>&nbsp;</span>
                    @else
                    <b class="block-1">&nbsp;</b>
					<span>&nbsp;</span>
                    @endif
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-1">
					<i class="fa fa-building" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="main-deck-card main-deck-card-2">
				<div class="main-deck-card-text">
					<p>Sick Leaves Left</p>
					<b class="block-1">0/@if($career_allowed_sick_leaves){{ $career_allowed_sick_leaves }}@else{{0}}@endif</b>
					<span>&nbsp;</span>
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-2">
					<i class="fa fa-frown-o" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="main-deck-card main-deck-card-3">
				<div class="main-deck-card-text">
					<p>Vocations Days Left</p>
					<b class="block-1">0/@if($career_paid_vacation){{ $career_paid_vacation }}@else{{0}}@endif</b>
					<span>&nbsp;</span>
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-3">
					<i class="fa fa-umbrella" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="main-deck-card main-deck-card-5">
				<div class="main-deck-card-text">
					<p>Certification Expiration</p>
                    @if($femployees_certification)
					<b class="block-1">@if($femployees_certification->expiration_date != "" && $femployees_certification->expiration_date != '0000-00-00'){{ date('jS M Y',strtotime($femployees_certification->expiration_date)) }} @else &nbsp; @endif</b>
					<span>Certification</span>
					<b>{{ $femployees_certification->certification_name }}</b>
                    @else
                    <b class="block-1">&nbsp;</b>
					<span>Certification</span>
					<!-- <b>&nbsp;</b> -->
                    @endif
				</div>
				<div class="main-deck-card-icon main-deck-card-icon-4">
					<i class="fa fa-graduation-cap" aria-hidden="true"></i>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
        <div class="row">
        	<div class="col-md-6">
            	<div class="super-admin-femployee-main">
                    <div class="super-admin-femployee-tabs-main">	
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#All-Notifications">All Notifications</a></li>
                            <li><a data-toggle="tab" href="#Announcement-Notifications">Announcement</a></li>
                            <li><a data-toggle="tab" href="#Updates-Notifications">Updates</a></li>
                            <li><a data-toggle="tab" href="#Activities-Notifications">Activities</a></li>
                            <li><a data-toggle="tab" href="#Message-Notifications">Message</a></li>
                        </ul>
                    </div>
                    <div class="super-admin-femployee-tab-content">
                        <div class="tab-content">
                            <div id="All-Notifications" class="tab-pane fade in active">
                                <div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
                                    <div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
                                        @if($notifications->count())
                                        	<small>Today | {{ date('h:mA, M j, Y') }}</small>
                                            @foreach($notifications as $notification)
                                                <div class="create-notification-main">
                                                        <span class="circle-super-admin"></span>
                                                        <div class="create-notification-main-main">
                                                            <h3 style="margin-top: 0;">{{ $notification->title }}</h3>
                                                            @php $count_notifications = 0; @endphp
                                                            @php $dropdown = FALSE; @endphp
                                                            {{--
                                                            @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                            @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
        													--}}
                                                            {{--@if(!$notification->franchises->isEmpty())
                                                            @foreach($notification->franchises as $franchise)
                                                                @if($count_notifications < 4)
                                                                    <h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</button></h5>
                                                                    @if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
                                                                    @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
                                                                    @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                                @else
                                                                    @if($dropdown == FALSE)
                                                                        @php $dropdown = TRUE; @endphp
                                                                        <h5>
                                                                            <div class="create-notification-main-dropdown">
                                                                                <button class="create-notifi-butn-dot">
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                </button>
                                                                                <div class="create-notification-dropdown-content">
                                                                        @endif
        
                                                                                    <a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</a>
                                                                                    @if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
                                                                                    @if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
                                                                                    @if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif
        
                                                                @endif
                                                            @endforeach
                                                            @endif--}}
        
                                                            @if($dropdown == TRUE)
                                                                                </div>
                                                                            </div>
                                                                        </h5>
                                                            @endif
                                                        </div>
                                                        {{--
                                                        <div class="create-notification-del-butn">
                                                            @if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                                            <a href="{{ route('franchise.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
                                                        </div>
                                                        --}}
                                                        <div class="clearfix"></div>
                                                        @if($notification->old_description)
                                                            <p>
                                                                <label><b class="inner-tabs-content-b">Update :</b>{{ $notification->description }}</label><br>
                                                                <span class="inner-para-span">{{ $notification->old_description }}</span>
                                                                <span class="clearfix"></span>
                                                            </p>
                                                        @else
                                                            <p>{{ $notification->description }}</p>
                                                        @endif
                                                    </div>
                                            @endforeach
                                        @else
                                            No Notification Found!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="Announcement-Notifications" class="tab-pane fade">
                                <div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
                                    <div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
                                        @if($notifications->count())
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Annoucement")
                                                <div class="create-notification-main">
                                                        <span class="circle-super-admin"></span>
                                                        <div class="create-notification-main-main">
                                                            <h3 style="margin-top: 0;">{{ $notification->title }}</h3>
                                                            @php $count_notifications = 0; @endphp
                                                            @php $dropdown = FALSE; @endphp
                                                            {{--
                                                            @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                            @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
        													--}}
                                                            {{--@if(!$notification->franchises->isEmpty())
                                                            @foreach($notification->franchises as $franchise)
                                                                @if($count_notifications < 4)
                                                                    <h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</button></h5>
                                                                    @if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
                                                                    @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
                                                                    @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                                @else
                                                                    @if($dropdown == FALSE)
                                                                        @php $dropdown = TRUE; @endphp
                                                                        <h5>
                                                                            <div class="create-notification-main-dropdown">
                                                                                <button class="create-notifi-butn-dot">
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                </button>
                                                                                <div class="create-notification-dropdown-content">
                                                                        @endif
        
                                                                                    <a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</a>
                                                                                    @if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
                                                                                    @if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
                                                                                    @if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif
        
                                                                @endif
                                                            @endforeach
                                                            @endif--}}
        
                                                            @if($dropdown == TRUE)
                                                                                </div>
                                                                            </div>
                                                                        </h5>
                                                            @endif
                                                        </div>
                                                        {{--
                                                        <div class="create-notification-del-butn">
                                                            @if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                                            <a href="{{ route('franchise.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
                                                        </div>
                                                        --}}
                                                        <div class="clearfix"></div>
                                                        @if($notification->old_description)
                                                            <p>
                                                                <label><b class="inner-tabs-content-b">Update :</b>{{ $notification->description }}</label><br>
                                                                <span class="inner-para-span">{{ $notification->old_description }}</span>
                                                                <span class="clearfix"></span>
                                                            </p>
                                                        @else
                                                            <p>{{ $notification->description }}</p>
                                                        @endif
                                                    </div>
                                            @endif        
                                            @endforeach
                                        @else
                                            No Notification Found!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="Updates-Notifications" class="tab-pane fade">
                                <div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
                                    <div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
                                        @if($notifications->count())
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Update")
                                                <div class="create-notification-main">
                                                        <span class="circle-super-admin"></span>
                                                        <div class="create-notification-main-main">
                                                            <h3 style="margin-top: 0;">{{ $notification->title }}</h3>
                                                            @php $count_notifications = 0; @endphp
                                                            @php $dropdown = FALSE; @endphp
                                                            {{--
                                                            @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                            @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
        													--}}
                                                            {{--@if(!$notification->franchises->isEmpty())
                                                            @foreach($notification->franchises as $franchise)
                                                                @if($count_notifications < 4)
                                                                    <h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</button></h5>
                                                                    @if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
                                                                    @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
                                                                    @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                                @else
                                                                    @if($dropdown == FALSE)
                                                                        @php $dropdown = TRUE; @endphp
                                                                        <h5>
                                                                            <div class="create-notification-main-dropdown">
                                                                                <button class="create-notifi-butn-dot">
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                </button>
                                                                                <div class="create-notification-dropdown-content">
                                                                        @endif
        
                                                                                    <a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</a>
                                                                                    @if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
                                                                                    @if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
                                                                                    @if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif
        
                                                                @endif
                                                            @endforeach
                                                            @endif--}}
        
                                                            @if($dropdown == TRUE)
                                                                                </div>
                                                                            </div>
                                                                        </h5>
                                                            @endif
                                                        </div>
                                                        {{--
                                                        <div class="create-notification-del-butn">
                                                            @if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                                            <a href="{{ route('franchise.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
                                                        </div>
                                                        --}}
                                                        <div class="clearfix"></div>
                                                        @if($notification->old_description)
                                                            <p>
                                                                <label><b class="inner-tabs-content-b">Update :</b>{{ $notification->description }}</label><br>
                                                                <span class="inner-para-span">{{ $notification->old_description }}</span>
                                                                <span class="clearfix"></span>
                                                            </p>
                                                        @else
                                                            <p>{{ $notification->description }}</p>
                                                        @endif
                                                    </div>
                                            @endif        
                                            @endforeach
                                        @else
                                            No Notification Found!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="Activities-Notifications" class="tab-pane fade">
                                <div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
                                    <div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
                                        @if($notifications->count())
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Activity")
                                                <div class="create-notification-main">
                                                        <span class="circle-super-admin"></span>
                                                        <div class="create-notification-main-main">
                                                            <h3 style="margin-top: 0;">{{ $notification->title }}</h3>
                                                            @php $count_notifications = 0; @endphp
                                                            @php $dropdown = FALSE; @endphp
                                                            {{--
                                                            @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                            @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
        													--}}
                                                            {{--@if(!$notification->franchises->isEmpty())
                                                            @foreach($notification->franchises as $franchise)
                                                                @if($count_notifications < 4)
                                                                    <h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</button></h5>
                                                                    @if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
                                                                    @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
                                                                    @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                                @else
                                                                    @if($dropdown == FALSE)
                                                                        @php $dropdown = TRUE; @endphp
                                                                        <h5>
                                                                            <div class="create-notification-main-dropdown">
                                                                                <button class="create-notifi-butn-dot">
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                </button>
                                                                                <div class="create-notification-dropdown-content">
                                                                        @endif
        
                                                                                    <a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</a>
                                                                                    @if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
                                                                                    @if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
                                                                                    @if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif
        
                                                                @endif
                                                            @endforeach
                                                            @endif--}}
        
                                                            @if($dropdown == TRUE)
                                                                                </div>
                                                                            </div>
                                                                        </h5>
                                                            @endif
                                                        </div>
                                                        {{--
                                                        <div class="create-notification-del-butn">
                                                            @if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                                            <a href="{{ route('franchise.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
                                                        </div>
                                                        --}}
                                                        <div class="clearfix"></div>
                                                        @if($notification->old_description)
                                                            <p>
                                                                <label><b class="inner-tabs-content-b">Update :</b>{{ $notification->description }}</label><br>
                                                                <span class="inner-para-span">{{ $notification->old_description }}</span>
                                                                <span class="clearfix"></span>
                                                            </p>
                                                        @else
                                                            <p>{{ $notification->description }}</p>
                                                        @endif
                                                    </div>
                                            @endif        
                                            @endforeach
                                        @else
                                            No Notification Found!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="Message-Notifications" class="tab-pane fade">
                                <div class="inner-tabs-content inner-tabs-content-parent-1 super-admin-inner-tabs">
                                    <div class="inner-tabs-content-1 inner-tabs-content-parent inner-tabs-content-admin">
                                        @if($notifications->count())
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Message")
                                                <div class="create-notification-main">
                                                        <span class="circle-super-admin"></span>
                                                        <div class="create-notification-main-main">
                                                            <h3 style="margin-top: 0;">{{ $notification->title }}</h3>
                                                            @php $count_notifications = 0; @endphp
                                                            @php $dropdown = FALSE; @endphp
                                                            {{--
                                                            @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                            @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
        													--}}
                                                            {{--@if(!$notification->franchises->isEmpty())
                                                            @foreach($notification->franchises as $franchise)
                                                                @if($count_notifications < 4)
                                                                    <h5><button> @php $count_notifications++; @endphp @if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</button></h5>
                                                                    @if($notification->send_to_franchise_admin) @php $count_notifications++; @endphp <h5><button> Administrator </button></h5>@endif
                                                                    @if($notification->send_to_clients) @php $count_notifications++; @endphp <h5><button> Clients </button></h5>@endif
                                                                    @if($notification->send_to_employees) @php $count_notifications++; @endphp <h5><button> Employees </button></h5>@endif
                                                                @else
                                                                    @if($dropdown == FALSE)
                                                                        @php $dropdown = TRUE; @endphp
                                                                        <h5>
                                                                            <div class="create-notification-main-dropdown">
                                                                                <button class="create-notifi-butn-dot">
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                                </button>
                                                                                <div class="create-notification-dropdown-content">
                                                                        @endif
        
                                                                                    <a href="javascript:void(0);">@if($franchise->notificaiton_franchise) {{ $franchise->notificaiton_franchise->location }} @endif</a>
                                                                                    @if($notification->send_to_franchise_admin) <a href="javascript:void(0);">Administrator</a> @endif
                                                                                    @if($notification->send_to_clients) <a href="javascript:void(0);">Clients</a> @endif
                                                                                    @if($notification->send_to_employees) <a href="javascript:void(0);">Employees</a> @endif
        
                                                                @endif
                                                            @endforeach
                                                            @endif--}}
        
                                                            @if($dropdown == TRUE)
                                                                                </div>
                                                                            </div>
                                                                        </h5>
                                                            @endif
                                                        </div>
                                                        {{--
                                                        <div class="create-notification-del-butn">
                                                            @if($notification->attachment)<a href="{{ asset($notification->attachment) }}" target="_blank" class="btn edit-noti-butn-1"><i class="fa fa-download" aria-hidden="true"></i></a>@endif
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#myModal{{ $notification->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <a href="javascript:voide(0);" class="btn edit-noti-butn-1" data-toggle="modal" data-target="#Archive{{ $notification->id }}"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                                            <a href="{{ route('franchise.edit_notification',['id'=>$notification->id]) }}" class="btn franchise-search-butn edit-noti-butn">Edit Notification</a>
                                                        </div>
                                                        --}}
                                                        <div class="clearfix"></div>
                                                        @if($notification->old_description)
                                                            <p>
                                                                <label><b class="inner-tabs-content-b">Update :</b>{{ $notification->description }}</label><br>
                                                                <span class="inner-para-span">{{ $notification->old_description }}</span>
                                                                <span class="clearfix"></span>
                                                            </p>
                                                        @else
                                                            <p>{{ $notification->description }}</p>
                                                        @endif
                                                    </div>
                                            @endif        
                                            @endforeach
                                        @else
                                            No Notification Found!
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            	<div class="super-admin-femployee-main">
                    <div class="super-admin-femployee-tabs-main">	
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab">Hours Log</a></li>
                        </ul>
                    </div>
                    <div class="super-admin-femployee-tab-content">
                        <div class="tab-content">
                            <div class="tab-pane fade in active">
                                <div class="row">
                                	<div class="col-md-12 super-admin-table-select">
                                    	<form action="" method="get" id="hourslog_filter">
                                            <select name="month" onchange="$('#hourslog_filter').submit();">
                                                <option value="">Select Month</option>
                                                @foreach($months as $key => $month)
                                                    <option @if($selected_month == $key) selected @endif value="{{ $key }}">{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>	
                                </div>
                                <div id="hours-log-chart-container" style="height: 370px; width: 100%; margin: 0px auto;"></div>
                                <div class="clearfix">&nbsp;</div>
                                <div id="graph-hours-count" style="text-align:center"><div class="hours_square"></div><b>Hours:</b> 0</div>
                				<div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

@if(Auth::guard('femployee')->check())
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endif

<script>
window.onload = function () {
	
//Creating Hours Log Json Object
var HoursLog = [];
//var HoursLog = new Array();
var hours_logs = @php echo $hours_logs; @endphp;	
$.each(hours_logs,function(key,val){
	console.log(key);
	HoursLog.push({'x':val.x, 'y':Number(val.y)});
});
console.log(HoursLog);
var options = {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: ""
	},
	subtitles: [{
		text: ""
	}],
	axisX: {
		title: "",
		interval: 1,
		includeZero: false,
	},
	axisY: {
		title: "",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC",
		includeZero: false,
	},
	/*axisY2: {
		title: "",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E",
		includeZero: false
	},*/
	toolTip: {
		shared: true
	},
	data: [
	{
		type: "column",
		name: "Hours",
		//axisYType: "secondary",
		//showInLegend: true,
		xValueFormatString: "Day : #",
		yValueFormatString: "#,##0.#",
		dataPoints: HoursLog
	}]
};
//$("#hours-log-chart-container").CanvasJSChart(options);
}
</script>

<!-- JQPlot plugin files -->
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/jquery.jqplot.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="{{ asset('assets/chartplugin') }}/jquery.jqplot.min.css" />
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/plugins/jqplot.barRenderer.min.js"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/chartplugin') }}/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<!-- JQPlot plugin files -->

<script class="code" type="text/javascript">
$(document).ready(function(e) {
	$.jqplot.config.enablePlugins = true;
	var GraphData = @php echo $hours_logs; @endphp;
	//GETTING DATES
	var Dates = new Array();
	$.each(GraphData,function(key,val){
		var date = new Date(val.x);
		var date = date.getDay()+"/"+date.getMonth()+"/"+date.getFullYear();Dates.push(parseInt(key));
	});
	console.log(Dates);

	//GETTING HOURS
	var Hours = new Array();
	$.each(GraphData,function(key,val){
		Hours.push(Number(val.y));
	});
	console.log(Hours);
	
	var hours = Hours;
	var ticks = Dates;
	 
	plot1 = $.jqplot('hours-log-chart-container', [hours], {
		// Only animate if we're not using excanvas (not in IE 7 or IE 8)..
		animate: !$.jqplot.use_excanvas,
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		//highlighter: { show: false }
	});
 
	$('#hours-log-chart-container').bind('jqplotDataHighlight', 
		function (ev, seriesIndex, pointIndex, data) {
			var value = data.toString().split(',');
			$('#graph-hours-count').html('<div class="hours_square"></div><b>Hours:</b> '+value[1]);
		}
	);

	$('#hours-log-chart-container').bind('jqplotDataUnhighlight', 
		function (ev) {
			$('#graph-hours-count').html('<div class="hours_square"></div><b>Hours:</b> '+0);
		}
	);
});
</script>
@endsection
