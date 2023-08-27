<div class="main-deck-head main-deck-head-franchise">
    <h4>{{$sub_title}}</h4>
    <p>{{ $sub_title }} / <span id="change-bread-crumb">Events </span></p>
</div>
<!--<div class="add-franchise-butn-main">
    <a href="javascript:void(0);" class="btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar" aria-hidden="true"></i>Add New Event</a>
</div>-->
<div class="clearfix"></div>

@if(Session::has('Success'))
    {!! session('Success') !!}
@endif