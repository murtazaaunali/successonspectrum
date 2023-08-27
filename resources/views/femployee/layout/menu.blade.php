<!-- side-bar-sec -->
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
    <!--<img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">-->
    <img class="side-bar-image-1" width="125" src="{{ asset('assets/images/SOS-Dashboard Logo.png') }}">
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
        <a class="pull-left w-100" href="{{ route('femployee.home') }}"> <i class="fa fa-user" aria-hidden="true"></i>Main Deck <span>{{ $unread_notifications->count() }}</span></a>
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

<!--<div class="footer-main">
  <div class="footer-content">
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>SW Houston,<br>9894 Bissonnet St #500<br>Houston TX 77036</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:(346) 217-8328">(346) 217-8328</a>
  </div>
</div>-->
@php
$franchise_id = Auth::guard()->user()->franchise_id;
$FranchiseSettings = App\Models\Franchise::find($franchise_id);
@endphp
<div class="footer-main">
  <div class="footer-content">
    @if(empty($FranchiseSettings))
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>SW Houston,<br>9894 Bissonnet St #500<br>Houston TX 77036</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:(346) 217-8328">(346) 217-8328</a>
    @else
    <span><i class="fa fa-map-marker" aria-hidden="true"></i></span><p>{{ $FranchiseSettings->address }}<br>{{ $FranchiseSettings->city }} {{ $FranchiseSettings->state}} {{ $FranchiseSettings->zipcode }}</p>
    <span><i class="fa fa-mobile" aria-hidden="true"></i></span><a href="tel:{{ $FranchiseSettings->phone }}">{{ $FranchiseSettings->phone }}</a>
    @endif
  </div>
</div>
<!-- side-bar-sec -->