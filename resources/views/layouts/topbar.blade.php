<!-- header-sec -->
<div class="head-top-main">
  <div class="head-top">
    <div class="head-1">
      @if(Auth::guard('admin')->check())
        <h1> SUPER ADMIN PORTHOLE</h1>
      
      @elseif(Auth::guard('franchise')->check())  
      	<h1>@php echo \App\Models\Franchise::find(Auth::guard('franchise')->user()->franchise_id)->location @endphp</h1>
      
      @elseif(Auth::guard('femployee')->check())  
      	<h1> @php echo \App\Models\Franchise::find(Auth::guard('femployee')->user()->franchise_id)->location @endphp</h1>
      
      @elseif(Auth::guard('parent')->check())  
      	<h1> @php echo \App\Models\Franchise::find(Auth::guard('parent')->user()->franchise_id)->location @endphp</h1>  
      @endif

    </div>

    @php
    $message_title  = "";
    $unread_messages  = array();
    $total_unread     = 0;
    $messages         = \App\Models\Messages::orderBy("created_at","DESC")->get();
    $user_type        = "";
    $user_id          = Auth::guard()->user()->id;

    if(Auth::guard('admin')->check())
    {
      $user_type = "Admin";
    }

    if($messages->count())
    {
      foreach($messages as $message)
      {
        $where = array(
          "message_id"  =>  $message->id,
          "user_type"   =>  $user_type,
          "user_id"     =>  $user_id,
        );

        $message_read_by = \App\Models\Messages_read_by::where($where)->get();

        if($message_read_by->count() == 0)
        {

          //if($total_unread <= 4)
          //{

            $id           = $message->reciever_id;
            $name         = "";
            $sender_type  = $message->sender_type;
            $sender_id    = $message->sender_id;
            $type         = $message->message_to;
            
            $sender_image = asset('assets/images/super-mess-icon.jpg');

            if($sender_type == "Franchise Administration" || $sender_type == "Franchise BCBA")
            {
              $get_franchise = \App\Models\Franchise::find($sender_id);
              if($get_franchise){
	              if($get_franchise->profile_picture)
	              {
	                $sender_image = asset($get_franchise->profile_picture);
	              }
	              $name = $get_franchise->location;
			  }
              
            }

            if($sender_type == "Administration")
            {
              $get_franchise = \App\Models\Admin::find($sender_id);
              if($get_franchise->profile_picture)
              {
                $sender_image = asset($get_franchise->profile_picture);
              }
              $name = $get_franchise->fullname;
            }

            if($sender_type == "Admin Employee")
            {
              $get_franchise = \App\Models\Admin::find($sender_id);
              $name = $get_franchise->fullname;
            }

            if($sender_type == "Admin BCBA"){
                $message_title  = "BCBA";
            }

            if($sender_type == "Administration"){
                $message_title  = $name;
            }

            if($sender_type == "Franchise Administration"){
                $message_title  = $name;
            }

            if($sender_type == "Franchise BCBA"){
                $message_title  = $name;
            }

            if($sender_type == "Admin Employee"){
                $message_title  = $name;
            }

            if($sender_type == "Franchise Employee"){
                $message_title  = $name;
            }
            
            if($sender_type == "SOS Distributor"){
                $message_title  = $sender_type;
            }

            if($type == "Admin BCBA"){
                $url = route('admin.messages', ['name' => "Admin_BCBA"]);
            }

            if($type == "Administration"){
                $url = route('admin.messages', ['name' => $type]);
            }

            if($type == "Franchise Administration"){
                $url = route("admin.messages", ["name" => "Franchise_Administration"]);
            }

            if($type == "Franchise BCBA"){
                $url = route("admin.messages", ["name" => "Franchise_BCBA", "id" => $id]);
            }

            if($type == "Admin Employee"){
                $url = route("admin.messages", ["name" => "Admin_Employee", "id" => $id]);
            }

            if($type == "Franchise Employee"){
                $url = route("admin.messages", ["name" => "Franchise_Employee", "id" => $id]);
            }
            
            if($type == "Employee"){
                $url = route("admin.messages", ["name" => "Employee", "id" => $id]);
            }

            if($type == "Parent"){
                $url = route("admin.messages", ["name" => "Parent", "id" => $id]);
            }
                        
            if($type == "SOS Distributor"){
                $url = route("admin.messages", ["name" => "SOS_Distributor"]);
            }

            $unread_messages[] = array(
              "title"         =>  $message_title,
              "url"           =>  $url,
              "message_time"  =>  date("h:i a | M d Y",strtotime($message->created_at)),
              "message"       =>  $message->message,
              "image"         =>  $sender_image,
            );
          //}

          $total_unread++;
        }
      }
    }

    $unread_notifications = \App\Models\Notifications::where("send_to_admin","1")->get();
    
    if(Auth::guard('femployee')->check())
    {
    	$franchise_id          = Auth::guard()->user()->franchise_id;
    	$unread_notifications = \App\Models\Notifications::where("send_to_employees","1")->where("franchise_id",$franchise_id)->get();
    }
    
    if(Auth::guard('parent')->check())
    {
    	$franchise_id          = Auth::guard()->user()->franchise_id;
    	$unread_notifications = \App\Models\Notifications::where("send_to_clients","1")->where("franchise_id",$franchise_id)->get();
    }
    
    @endphp

    <div class="head-2">
      <div class="HeadNotfication dropdown noitfication-drop-down noitfication-drop-down-2">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="noti-img" src="{{ asset('assets/images/bell.jpg') }}"><span>{{ $unread_notifications->count() }}</span></a>
        <div class="drop-down-main notnone dropdown-menu" aria-labelledby="dropdownMenuButton">
          <h5>Notification</h5>
          @if($unread_notifications->count())
            @foreach($unread_notifications as $notification)
              <div class="drop-down-1">
                <figure>
                  <div class="drop-down-1-para">
                    <b>{{ $notification->title  }}</b><span>{{ date("h:i a | M d Y",strtotime($notification->created_at)) }}<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                    <div class="clearfix"></div>
                    <p>{{ $notification->description }}</p>
                  </div>
                  <div class="clearfix"></div>
                </figure>
              </div>
            @endforeach
          @else
            <p class="NotifiationsFound">No Notifications Found!</p>
          @endif
          {{--
          <h6>Monday, January 5th</h6>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <figure>
              <div class="drop-down-1-para">
                <b>Notification Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p>Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          --}}
        </div>
      </div>

      <div class="HeadNotfication dropdown noitfication-drop-down-1 noitfication-drop-down-2">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="noti-img" src="{{ asset('assets/images/bell-1.jpg') }}" /><span>{{ $total_unread }}</span></a>
        <div class="drop-down-main-1 notnone-1 dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <h5>Unread Messages</h5>

          @if(!empty($unread_messages))
            @foreach($unread_messages as $unread_message)

                  <div class="drop-down-1">
                    <a href="{{ $unread_message["url"] }}">
                      <h1><img src="{{ $unread_message["image"] }}" /></h1>
                    </a>
                    <figure>
                      <div class="drop-down-2-para">
                        <a href="{{ $unread_message["url"] }}"><b>{{ $unread_message["title"] }}</b></a>
                          <span>{{ $unread_message["message_time"] }}<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                        <div class="clearfix"></div>
                        <a href="{{ $unread_message["url"] }}">
                          <p class="notification-para5">{{ $unread_message["message"] }}</p>
                        </a>
                      </div>
                      <div class="clearfix"></div>
                    </figure>
                  </div>
            @endforeach
          @else
            <p class="NotifiationsFound">No Notifications Found!</p>
          @endif

          {{--
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          <div class="drop-down-1">
            <h1><img src="{{ asset('assets/images/Messages-icon.jpg') }}" /></h1>
            <figure>
              <div class="drop-down-2-para">
                <b>Message Title</b><span>8:40 PM<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                <div class="clearfix"></div>
                <p class="notification-para5">Sed ut persp iciatis unde omnis iste natus error sit volu ptat em accu sant ium.</p>
              </div>
              <div class="clearfix"></div>
            </figure>
          </div>
          --}}
        </div>
      </div>

      <div class="HeadNotfication dropdown">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          
            @if(Auth::guard()->user()->profile_picture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard()->user()->profile_picture) }}" />
            @elseif(Auth::guard()->user()->personal_picture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard()->user()->personal_picture) }}" />
            @elseif(Auth::guard()->user()->client_profilepicture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard()->user()->client_profilepicture) }}" />    
            @else
              <!--<img class="cntct-img" src="{{ asset('assets/images/bell-4.jpg') }}" />-->
              <i class="fa fa-user cntct-img profile-image-display-icon" aria-hidden="true"></i>
            @endif

          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        <div class="logout-box-main notnone-5 dropdown-menu" aria-labelledby="dropdownMenuButton2">
          <a href="#" class="head-active">
          @if(Auth::guard('admin')->check())	
          	{{Auth::guard('admin')->user()->fullname}}
          @endif	
          @if(Auth::guard('franchise')->check())	
          	{{Auth::guard('franchise')->user()->fullname}}
          @endif
          @if(Auth::guard('femployee')->check())	
          	{{Auth::guard('femployee')->user()->personal_name}}
          @endif
          @if(Auth::guard('parent')->check())	
          	{{Auth::guard('parent')->user()->client_childfullname}}
          @endif
          </a>
          
          @if(Auth::guard('admin')->check())
	          <a href="{{ route('admin.edit_profile')  }}">Edit Profile</a>
	          <a href="{{ route('admin.add_user')  }}">Add User</a>
          @elseif(Auth::guard('franchise')->check())
	          <a href="{{ url('franchise/edit_profile')  }}">Edit Profile</a>
              @php $rules = array('Owner','Manager'); @endphp
      		  @if(in_array(Auth::guard('franchise')->user()->type,$rules))
	          <a href="{{ url('franchise/adduser')  }}">Add User</a>
              @endif
          @elseif(Auth::guard('femployee')->check())
	          <a href="{{ url('femployee/edit_profile')  }}">Edit Profile</a>
          @elseif(Auth::guard('parent')->check())
	          <a href="{{ url('parent/edit_profile')  }}">Edit Profile</a>    
          @endif
          
          
          <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
          
          @if(Auth::guard('admin')->check())
			<form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
		  @elseif(Auth::guard('franchise')->check())
			<form id="logout-form" action="{{ url('franchise/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
          @elseif(Auth::guard('femployee')->check())
			<form id="logout-form" action="{{ url('femployee/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form> 
          @elseif(Auth::guard('parent')->check())
			<form id="logout-form" action="{{ url('parent/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>      
		  @endif
          
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- header-sec -->