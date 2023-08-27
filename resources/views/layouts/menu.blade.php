<!-- side-bar-sec -->
@if(Auth::guard('admin')->check())
<div class="side-bar-res-main">
  <div class="side-bar-res">
    <a @if(Auth::guard('admin')->check()) href="{{ route('admin.home') }}" @else href="#" @endif>
      <div class="res-logo-main">
        <!--<img src="{{ asset('assets/images/logo-res.png') }}" />-->
        <img src="{{ asset('assets/images/logo-admin-white-res.png') }}" style="height:auto !important;"/>
      </div>
    </a>
  </div>
  <div class="res-bar-icon">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </div>
  <div class="clearfix"></div>
</div>
<div class="side-bar-main">
  <div class="logo-main">
    <a @if(Auth::guard('admin')->check()) href="{{ route('admin.home') }}" @else href="#" @endif>
    <!--<img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">-->
    <img class="side-bar-admin-image-1" src="{{ asset('assets/images/logo-admin-white.png') }}">
    <img class="side-bar-image-2" src="{{ asset('assets/images/side-bar-1.jpg') }}">
    </a>
  </div>
  <div class="tabs-main">
    <ul>
      <li @if($menu == 'main_deck') class="active" @endif>
        <a href="{{ route('admin.home') }}">
          <i class="fa fa-user" aria-hidden="true"></i>Main Deck
        </a>
      </li>
      <li @if($menu == 'franchise') class="active" @endif><a href="{{ route('admin.franchises') }}"><i class="fa fa-building" aria-hidden="true"></i>Franchisees</a></li>
      <li @if($menu == 'employees') class="active" @endif>
        <a href="{{ route('admin.employees') }}" class="pull-left"><i class="fa fa-users" aria-hidden="true"></i>Employees</a>
        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'employees' && $sub_menu == 'employees_payroll') act_open @endif">
          <li>
            <a @if($sub_menu == 'employees_payroll') class="act_white" @endif href="#">Run Payroll</a>
          </li>
        </ul>
      </li>
      <li @if($menu == 'cargo') class="active" @endif><a href="{{ route('admin.cargohold') }}"><i class="fa fa-file" aria-hidden="true"></i>Cargo Hold</a></li>
      <li @if($menu == 'message') class="active" @endif>
        <a class="pull-left" href="{{ route('admin.messages') }}"><i class="fa fa-comment" aria-hidden="true"></i>Msg In A Bottle</a>
        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'message' && $sub_menu == 'notification') act_open @endif">
          <li>
            <a href="{{ route('admin.notification_list') }}" @if($sub_menu == 'notification') class="act_white" @endif>Create Notification</a>
          </li>
        </ul>
      </li>
      <li @if($menu == 'trip_itinerary') class="active" @endif><a href="{{ route('admin.trip_itinerary') }}"><i class="fa fa-list" aria-hidden="true"></i>Trip Itinerary</a></li>
      <li @if($menu == 'catalogue') class="active" @endif>
        <a class="pull-left" href="{{ url('admin/catalogue') }}"><i class="fa fa-file-text" aria-hidden="true"></i>Catalog</a>
        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'catalogue' && ($sub_menu == 'catalogue_product' || $sub_menu == 'order' ) ) act_open @endif">
          <li>
            <a class="@if($sub_menu == 'catalogue_product') act_white @endif" href="{{ url('admin/catalogue/addproduct') }}">Add product</a>
          </li>
          <li>
            <a @if($sub_menu == 'order') class="act_white" @endif href="{{ route('admin.orders_list') }}">Order {{--<span>16</span>--}}</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>
@endif

<!-- ================ Franchise menus =================== -->
@if(Auth::guard('franchise')->check())
<div class="side-bar-res-main">
  <div class="side-bar-res">
    <a @if(Auth::guard('franchise')->check()) href="{{ route('franchise.home') }}" @else href="#" @endif>
      <div class="res-logo-main">
        <img src="{{ asset('assets/images/logo-res.png') }}" />
      </div>
    </a>
  </div>
  <div class="res-bar-icon">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </div>
  <div class="clearfix"></div>
</div>
<div class="side-bar-main">
  <div class="logo-main">
    <a @if(Auth::guard('franchise')->check()) href="{{ route('franchise.home') }}" @else href="#" @endif>
    <img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">
    <img class="side-bar-image-2" src="{{ asset('assets/images/side-bar-1.jpg') }}">
    </a>
  </div>
  <div class="tabs-main">
    <ul>

      @php $rules = array('Owner','Manager'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      <li @if($menu == 'main_deck') class="active" @endif>
        <a class="pull-left" href="{{ route('franchise.home') }}"> <i class="fa fa-user" aria-hidden="true"></i>Main Deck </a>
        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
        <div class="clearfix"></div>
        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'main_deck' && ($sub_menu == 'notification' || $sub_menu == 'main_notification')) act_open @endif">
          <li><a href="{{ route('franchise.notification_list_main') }}" @if($sub_menu == 'main_notification') class="act_white" @endif>Client's Main Deck</a></li>
          <li><a href="{{ route('franchise.notification_list') }}" @if($sub_menu == 'notification') class="act_white" @endif>Create Notification</a></li>
        </ul>
      </li>
      @endif

	  @php $rules = array('Owner','Manager','BCBA','Intern','Receptionist'); @endphp
	  @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      <li @if($menu == 'clients') class="active" @endif><a href="{{ route('franchise.clients') }}" @if($menu == 'clients') class="act_white" @endif><i class="fa fa-group" aria-hidden="true"></i>Clients</a></li>
      @endif
      
      @php $rules = array('Owner','Manager'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      
	      <li @if($menu == 'staff') class="active" @endif>
	        <a  class="pull-left" href="{{ route('franchise.staff') }}"><i class="fa fa-user" aria-hidden="true"></i>Staff</a>
	        <a class="tar_set pull-right" href="javascript:void(0);"> <label class="caret"></label> </a>
	        <div class="clearfix"></div>
	        <ul class="dropdown-menu dropdown-menu-1 @if($menu == 'staff' && $sub_menu == 'add_user' ) act_open @endif">
	          <li><a class="@if($sub_menu == 'add_user') act_white @endif" href="{{ url('franchise/adduser') }}">Add User</a></li>
	        </ul>
	      </li>

      @endif

	  @php $rules = array('Owner','Manager','BCBA','Intern'); @endphp
	  @if(in_array(Auth::guard('franchise')->user()->type,$rules))
	      <li @if($menu == 'employees') class="active" @endif>
	        <a href="{{ route('franchise.employees') }}"><i class="fa fa-user" aria-hidden="true"></i>Employees</a>
	      </li>
	  @endif    

      @php $rules = array('Owner','Manager','BCBA'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
      	<li @if($menu == 'message') class="active" @endif><a href="{{ route('franchise.messages') }}"><i class="fa fa-comment" aria-hidden="true"></i>Msg In A Bottle</a></li>
      @endif


      @php $rules = array('Owner','Manager'); @endphp
      @if(in_array(Auth::guard('franchise')->user()->type,$rules))
	      <li @if($menu == 'cargo') class="active" @endif><a href="{{ route('franchise.cargohold') }}"><i class="fa fa-file" aria-hidden="true"></i>Cargo Hold</a></li>
	      <li @if($menu == 'trip_itinerary') class="active" @endif><a href="{{ route('franchise.trip_itinerary') }}"><i class="fa fa-list" aria-hidden="true"></i>Trip Itinerary</a></li>
	      <li @if($menu == 'catalog') class="active" @endif><a href="{{ route('franchise.catalog') }}"><i class="fa fa-file-text" aria-hidden="true"></i>Catalog</a></li>
	  @endif
     
    </ul>
  </div>
</div>
@endif

<!-- ================ Femployee menus =================== -->
@if(Auth::guard('femployee')->check())
<div class="side-bar-res-main">
  <div class="side-bar-res">
    <a @if(Auth::guard('femployee')->check()) href="{{ route('femployee.home') }}" @else href="#" @endif>
      <div class="res-logo-main">
        <img src="{{ asset('assets/images/logo-res.png') }}" />
      </div>
    </a>
  </div>
  <div class="res-bar-icon">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </div>
  <div class="clearfix"></div>
</div>
<div class="side-bar-main">
  <div class="logo-main">
    <a @if(Auth::guard('femployee')->check()) href="{{ route('femployee.home') }}" @else href="#" @endif>
    <img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">
    <img class="side-bar-image-2" src="{{ asset('assets/images/side-bar-1.jpg') }}">
    </a>
  </div>
  <div class="tabs-main">
    <ul>
	  @php
      $franchise_id          = Auth::guard()->user()->franchise_id;
      $unread_notifications = \App\Models\Notifications::where("send_to_employees","1")->where("franchise_id",$franchise_id)->get();
      @endphp
      <li @if($menu == 'main_deck' || $menu == 'profile') class="active" @endif>
        <a class="pull-left w-100" href="{{ route('femployee.home') }}"> <i class="fa fa-user" aria-hidden="true"></i>Main Deck <span style="margin-top:3px;" class="badge pull-right">{{ $unread_notifications->count() }}</span></a>
        <div class="clearfix"></div>
      </li>

      <li @if($menu == 'employee') class="active" @endif><a href="{{ route('femployee.view') }}" @if($menu == 'view') class="act_white" @endif><i class="fa fa-group" aria-hidden="true"></i>Employee</a></li>
      
      <li @if($menu == 'performance') class="active" @endif><a href="{{ route('femployee.performance') }}" @if($menu == 'performance') class="act_white" @endif><i class="fa fa-line-chart" aria-hidden="true"></i>Performance Record</a></li>
      
      <li @if($menu == 'cargo') class="active" @endif><a href="{{ route('femployee.cargohold') }}"><i class="fa fa-file" aria-hidden="true"></i>Cargo Hold</a></li>
      <li @if($menu == 'message') class="active" @endif><a href="{{ route('femployee.messages') }}"><i class="fa fa-comment" aria-hidden="true"></i>Msg In A Bottle</a></li>
      <li @if($menu == 'trip_itinerary') class="active" @endif><a href="{{ route('femployee.trip_itinerary') }}"><i class="fa fa-list" aria-hidden="true"></i>Trip Itinerary</a></li>
     
    </ul>
  </div>
</div>
@endif

<!-- ================ Parent menus =================== -->
@if(Auth::guard('parent')->check())
<div class="side-bar-res-main">
  <div class="side-bar-res">
    <a @if(Auth::guard('parent')->check()) href="{{ route('parent.home') }}" @else href="#" @endif>
      <div class="res-logo-main">
        <img src="{{ asset('assets/images/logo-res.png') }}" />
      </div>
    </a>
  </div>
  <div class="res-bar-icon">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </div>
  <div class="clearfix"></div>
</div>
<div class="side-bar-main">
  <div class="logo-main">
    <a @if(Auth::guard('parent')->check()) href="{{ route('parent.home') }}" @else href="#" @endif>
    <img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">
    <img class="side-bar-image-2" src="{{ asset('assets/images/side-bar-1.jpg') }}">
    </a>
  </div>
  <div class="tabs-main">
    <ul>
	  @php
      $router_name = Request::route()->getName();
      $franchise_id          = Auth::guard()->user()->franchise_id;
      $unread_notifications = \App\Models\Notifications::where("send_to_clients","1")->where("franchise_id",$franchise_id)->get();
      @endphp
      <li @if($menu == 'main_deck' || $menu == 'profile') class="active" @endif>
        <a class="pull-left w-100" href="{{ route('parent.home') }}"> <i class="fa fa-user" aria-hidden="true"></i>Main Deck <span style="margin-top:3px;" class="badge pull-right">{{ $unread_notifications->count() }}</span></a>
        <div class="clearfix"></div>
      </li>

      <li @if($menu == 'client' && $router_name !="parent.insurance" && $router_name !="parent.editinsurance" ) class="active" @endif><a href="{{ route('parent.view') }}" @if($menu == 'view') class="act_white" @endif><i class="fa fa-group" aria-hidden="true"></i>Client</a></li>
      
      <li @if($menu == 'client' && ($router_name =="parent.insurance" || $router_name =="parent.editinsurance")) class="active" @endif><a href="{{ route('parent.insurance') }}" @if($menu == 'insurance') class="act_white" @endif><i class="fa fa-line-chart" aria-hidden="true"></i>Insurance</a></li>
      
      <li @if($menu == 'cargo') class="active" @endif><a href="{{ route('parent.cargohold') }}"><i class="fa fa-file" aria-hidden="true"></i>Cargo Hold</a></li>
      <li @if($menu == 'message') class="active" @endif><a href="{{ route('parent.messages') }}"><i class="fa fa-comment" aria-hidden="true"></i>Msg In A Bottle</a></li>
      <li @if($menu == 'trip_itinerary') class="active" @endif><a href="{{ route('parent.trip_itinerary') }}"><i class="fa fa-list" aria-hidden="true"></i>Trip Itinerary</a></li>
     
    </ul>
  </div>
</div>
@endif

<div class="footer-main">
  <div class="footer-content">
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>SW Houston,<br>9894 Bissonnet St #500<br>Houston TX 77036</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:(346) 217-8328">(346) 217-8328</a>
  </div>
</div>
<!-- side-bar-sec -->