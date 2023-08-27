<!-- side-bar-sec -->
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
    <!--<img class="side-bar-image-1" src="{{ asset('assets/images/logo.jpg') }}">-->
    <img class="side-bar-image-1" width="125" src="{{ asset('assets/images/SOS-Dashboard Logo.png') }}">
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
        <a class="pull-left w-100" href="{{ route('parent.home') }}"> <i class="fa fa-user" aria-hidden="true"></i>Main Deck <span>{{ $unread_notifications->count() }}</span></a>
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