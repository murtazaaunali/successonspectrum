<!-- header-sec -->
<div class="head-top-main">
  <div class="head-top">
    <div class="head-1">
        <h1> SUPER ADMIN PORTHOLE</h1>
    </div>

    @php
    $message_title  = "";
    $unread_messages  = array();
    $total_unread     = 0;
    $user_type        = "";
    $user_id          = Auth::guard('admin')->user()->id;
    
    $messages = \App\Models\Messages::where("is_private",1)
    			->where(function ($query) use ($user_id) {
    				$query->where(array('reciever_id'=> $user_id, 'message_to'=> 'Admin Employee'));	
    			})
    			->orderBy("created_at","DESC")->limit(5)->get();
    			
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

            //$id           = $message->reciever_id;
            $id           = $message->sender_id;
            $name         = "";
            $sender_type  = $message->sender_type;
            $sender_id    = $message->sender_id;
            //$type       = $message->message_to;
            $type         = $message->sender_type;
            
            $sender_image = asset('assets/images/super-mess-icon.jpg');

            if($sender_type == "Franchise Administration" || $sender_type == "Franchise BCBA" || $sender_type == "Franchise Employee")
            {
              $get_franchise = \App\Models\Franchise::find(\App\Models\Franchise\Fuser::find($sender_id)->franchise_id);
              $sender = \App\Models\Franchise\Fuser::find($sender_id);
              if($get_franchise){
	              if($get_franchise->profile_picture)
	              {
	                $sender_image = asset($get_franchise->profile_picture);
	              }
	              //$name = $get_franchise->location;
	              $name = $sender->fullname . "<br/><small>(".$sender->type.') | '.$get_franchise->location.'</small>';
			  }
              
            }

            if($sender_type == "Administration"){
              $get_franchise = \App\Models\Admin::find($sender_id);
              
              if($get_franchise->profile_picture){
                $sender_image = asset($get_franchise->profile_picture);
              }
              $name = $get_franchise->fullname;
            }

            if($sender_type == "Admin Employee"){
              $get_franchise = \App\Models\Admin::find($sender_id);
              $name = $get_franchise->fullname."<br/><small>(Admin Employee)</small>";
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
              //"message_time"  =>  date("h:i a | M d Y",strtotime($message->created_at)),
              "message_time"  =>  date("h:i a | m/d/Y",strtotime($message->created_at)),
              "message"       =>  $message->message,
              "image"         =>  $sender_image,
            );
          //}

          $total_unread++;
        }
      }
    }


	/*$unread_notifications = \App\Models\Notifications::where(array("send_to_admin"=>"1", 'notification_type'=>'System Notification'))->whereIn('send_to_type',array('Director of Administration', 'Administration'))->orderby('created_at','desc')->get();*/
    $unread_notifications = \App\Models\Notifications::where(array("send_to_admin"=>"1", 'notification_type'=>'System Notification'))->whereIn('send_to_type',array('Director of Administration', 'Administration'))->where('notification_groups','!=','tasklist')->orderby('created_at','desc')->get();
    $unRead_Noti = array();
    if(!$unread_notifications->isEmpty())
    {
	    foreach($unread_notifications as $getNoti)
	    {
			$getUnread = \App\Models\Notifications_read_by::where('notification_id',$getNoti->id)->first();
			if(!$getUnread)
			{
				$unRead_Noti[] = $getNoti->id;
			}
		}
	}
	
    @endphp

<script type="text/javascript">
	//$('#dropdownMenuButton').
	$(document).ready(function(){
		var Count = 1;
		console.log(Count);
		$('#myNotification').on('shown.bs.dropdown', function () {
		  	// do something…
			if(Count == 1){

			  Count = Count + 1;
			  var UnRead = @php echo json_encode($unRead_Noti); @endphp;
			  console.log(UnRead);
			  $.ajax({
			  	method:'POST',
			  	url:'{{ route("admin.notification_read") }}',
			  	dataType:'json',
			  	data:{ids: UnRead, '_token':'{{ csrf_token() }}'},
			  	beforeSend: function( xhr ) {

					$('#myNotification').find('.myNotCount').html('0');
					$('#myNotification').find('.drop-down-1-para .fa-circle').remove();

			  	}
			  })
			  .done(function(response){
				
				if(response == 'Success')
				{
					$('#myNotification').find('.myNotCount').html('0');
					$('#myNotification').find('.drop-down-1-para .fa-circle').remove();
				}
			  });

			}

		});
	})
</script>

    <div class="head-2">
      <div class="HeadNotfication dropdown noitfication-drop-down noitfication-drop-down-2 hidden" id="myNotification">
        <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="noti-img" src="{{ asset('assets/images/bell.jpg') }}"><span class="myNotCount">{{ count($unRead_Noti) }}</span></a>
        <div class="drop-down-main notnone dropdown-menu" aria-labelledby="dropdownMenuButton">
          <h5 class="noti_heading">Notification</h5>
          <div class="notiScroll">
          @if($unread_notifications->count())
            @foreach($unread_notifications as $notification)
              <div class="drop-down-1">
                <figure>
                  <div class="drop-down-1-para">
                    <!--<b>{{ $notification->title  }}</b><span>{{ date("h:i a | M d Y",strtotime($notification->created_at)) }}<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>-->
                    
                    <b class="topNotiTitle">{!! $notification->title !!}</b>
                    
                    <span>{{ date("h:i a | m/d/Y",strtotime($notification->created_at)) }}
                    @if(in_array($notification->id, $unRead_Noti))
                    	<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i>
                    @endif
                    </span>
                    
                    <div class="clearfix"></div>
                    <p>{!! $notification->description !!}</p>
                  </div>
                  <div class="clearfix"></div>
                </figure>
              </div>
            @endforeach
          @else
            <p class="NotifiationsFound">No Notifications Found!</p>
          @endif
          </div>
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

      <div class="HeadNotfication dropdown noitfication-drop-down-1 noitfication-drop-down-2 hidden">
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
                        <a href="{{ $unread_message["url"] }}"><b>{!! $unread_message["title"] !!}</b></a>
                          <span>{{ $unread_message["message_time"] }}<i class="fa fa-circle pos-rel-red-clr" aria-hidden="true"></i></span>
                        <div class="clearfix"></div>
                        <a href="{{ $unread_message["url"] }}">
                          <p class="notification-para5">
							@if($unread_message["message"] != "") 
								@if(strlen($unread_message["message"]) >= 20)
									{{ substr($unread_message["message"],0,20).'...'  }} 
								@else
									{{ $unread_message["message"]  }} 
								@endif		
							@else 
								&nbsp; 
							@endif &nbsp;
						  </p>
                        </a>
                      </div>
                      <div class="clearfix"></div>
                    </figure>
                  </div>
            @endforeach
          @else
            <p class="NotifiationsFound">You curently have no message.</p>
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
          
            @if(Auth::guard('admin')->user()->profile_picture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard('admin')->user()->profile_picture) }}" />
            @elseif(Auth::guard('admin')->user()->personal_picture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard('admin')->user()->personal_picture) }}" />
            @elseif(Auth::guard('admin')->user()->client_profilepicture)
              <img class="cntct-img img-circle" src="{{ asset(Auth::guard('admin')->user()->client_profilepicture) }}" />    
            @else
              <!--<img class="cntct-img" src="{{ asset('assets/images/bell-4.jpg') }}" />-->
              <i class="fa fa-user cntct-img profile-image-display-icon" aria-hidden="true"></i>
            @endif

          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        <div class="logout-box-main notnone-5 dropdown-menu" aria-labelledby="dropdownMenuButton2">
          <a href="#" class="head-active">{{Auth::guard('admin')->user()->fullname}}</a>
          
          <a href="{{ route('admin.edit_profile')  }}">Edit Profile</a>
          <a href="{{ route('admin.add_user')  }}">Add User</a>
          
          <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
		  <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
          
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- header-sec -->