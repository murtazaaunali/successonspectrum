@extends('parent.layout.main')

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
        <div class="row">
        	<div class="col-md-12">
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
                                            @php $check_notification_date = ""; @endphp
                                            @foreach($notifications as $key=>$notification)
                                            	@if($notification->created_at != "" && $notification->created_at != '0000-00-00 00:00:00')
                                                    @if($check_notification_date != date("Y-m-d",strtotime($notification->created_at)))
                                                        <div class="clearfix">@if($key>0)&nbsp;@endif</div>
                                                        <!--<small>Today | {{ date('h:mA, M j, Y') }}</small>-->
                                                        <small>
                                                            @if(date("d",strtotime($notification->created_at)) == date("d"))
                                                            Today | 
                                                            @endif
                                                            
                                                            @if(date("d",strtotime($notification->created_at)) == (date("d")-1))
                                                            Yesterday | 
                                                            @endif
                                                            {{ date("h:mA, M j, Y",strtotime($notification->created_at)) }}
                                                        </small>
                                                        <div class="clearfix">&nbsp;</div>
                                                        @php
                                                        $check_notification_date = date("Y-m-d",strtotime($notification->created_at)); 
                                                        @endphp
                                                    @endif
                                                @endif
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
                                            @php $check_notification_date = ""; @endphp
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Annoucement")
                                                @if($notification->created_at != "" && $notification->created_at != '0000-00-00 00:00:00')
                                                    @if($check_notification_date != date("Y-m-d",strtotime($notification->created_at)))
                                                        <div class="clearfix">@if($key>0)&nbsp;@endif</div>
                                                        <!--<small>Today | {{ date('h:mA, M j, Y') }}</small>-->
                                                        <small>
                                                            @if(date("d",strtotime($notification->created_at)) == date("d"))
                                                            Today | 
                                                            @endif
                                                            
                                                            @if(date("d",strtotime($notification->created_at)) == (date("d")-1))
                                                            Yesterday | 
                                                            @endif
                                                            {{ date("h:mA, M j, Y",strtotime($notification->created_at)) }}
                                                        </small>
                                                        <div class="clearfix">&nbsp;</div>
                                                        @php
                                                        $check_notification_date = date("Y-m-d",strtotime($notification->created_at)); 
                                                        @endphp
                                                    @endif
                                                @endif
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
                                            @php $check_notification_date = ""; @endphp
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Update")
                                                @if($notification->created_at != "" && $notification->created_at != '0000-00-00 00:00:00')
                                                    @if($check_notification_date != date("Y-m-d",strtotime($notification->created_at)))
                                                        <div class="clearfix">@if($key>0)&nbsp;@endif</div>
                                                        <!--<small>Today | {{ date('h:mA, M j, Y') }}</small>-->
                                                        <small>
                                                            @if(date("d",strtotime($notification->created_at)) == date("d"))
                                                            Today | 
                                                            @endif
                                                            
                                                            @if(date("d",strtotime($notification->created_at)) == (date("d")-1))
                                                            Yesterday | 
                                                            @endif
                                                            {{ date("h:mA, M j, Y",strtotime($notification->created_at)) }}
                                                        </small>
                                                        <div class="clearfix">&nbsp;</div>
                                                        @php
                                                        $check_notification_date = date("Y-m-d",strtotime($notification->created_at)); 
                                                        @endphp
                                                    @endif
                                                @endif
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
                                            @php $check_notification_date = ""; @endphp
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Activity")
                                                @if($notification->created_at != "" && $notification->created_at != '0000-00-00 00:00:00')
                                                    @if($check_notification_date != date("Y-m-d",strtotime($notification->created_at)))
                                                        <div class="clearfix">@if($key>0)&nbsp;@endif</div>
                                                        <!--<small>Today | {{ date('h:mA, M j, Y') }}</small>-->
                                                        <small>
                                                            @if(date("d",strtotime($notification->created_at)) == date("d"))
                                                            Today | 
                                                            @endif
                                                            
                                                            @if(date("d",strtotime($notification->created_at)) == (date("d")-1))
                                                            Yesterday | 
                                                            @endif
                                                            {{ date("h:mA, M j, Y",strtotime($notification->created_at)) }}
                                                        </small>
                                                        <div class="clearfix">&nbsp;</div>
                                                        @php
                                                        $check_notification_date = date("Y-m-d",strtotime($notification->created_at)); 
                                                        @endphp
                                                    @endif
                                                @endif
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
                                            @php $check_notification_date = ""; @endphp
                                            @foreach($notifications as $notification)
                                            @if($notification->type == "Message")
                                                @if($notification->created_at != "" && $notification->created_at != '0000-00-00 00:00:00')
                                                    @if($check_notification_date != date("Y-m-d",strtotime($notification->created_at)))
                                                        <div class="clearfix">@if($key>0)&nbsp;@endif</div>
                                                        <!--<small>Today | {{ date('h:mA, M j, Y') }}</small>-->
                                                        <small>
                                                            @if(date("d",strtotime($notification->created_at)) == date("d"))
                                                            Today | 
                                                            @endif
                                                            
                                                            @if(date("d",strtotime($notification->created_at)) == (date("d")-1))
                                                            Yesterday | 
                                                            @endif
                                                            {{ date("h:mA, M j, Y",strtotime($notification->created_at)) }}
                                                        </small>
                                                        <div class="clearfix">&nbsp;</div>
                                                        @php
                                                        $check_notification_date = date("Y-m-d",strtotime($notification->created_at)); 
                                                        @endphp
                                                    @endif
                                                @endif
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
        </div>
	</div>
</div>

@if(Auth::guard('parent')->check())
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endif

<script>
window.onload = function () {
	
//Creating Hours Log Json Object
<?php /*?>var hours_logs = @php echo $hours_logs; @endphp;<?php */?>	
var HoursLog = new Array();
//$.each(hours_logs,function(key,val){
var days;for (days = 1; days <= 20; days++) { 
	if(days<10)days="0"+days;
	HoursLog.push({'x':days});
	//HoursLog.push({'x':days, 'y':12});
//});
}

var hours;for (hours = 1; hours <= 11; hours++) { 
	HoursLog.push({'y':hours});
}

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
		title: ""
	},
	axisY: {
		title: "",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC",
		includeZero: false
	},
	axisY2: {
		title: "",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E",
		includeZero: false
	},
	toolTip: {
		shared: true
	},
	data: [
	{
		type: "column",
		//name: "Hours Log",
		//axisYType: "secondary",
		//showInLegend: true,
		//xValueFormatString: "MMM YYYY",
		//yValueFormatString: "$#,##0.#",
		dataPoints: HoursLog
	}]
};
$("#hours-log-chart-container").CanvasJSChart(options);
}
</script>
@endsection
