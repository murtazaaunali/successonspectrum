@extends('admin.layout.main')

@section('content')

<div class="add-franchise-super-main">
    <div class="view-tab-control">
        <h6>{{$sub_title}}</h6>
        <p>Settings / <span id="change-bread-crumb">View</span></p>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="text-left">
    @if(Session::has('Success'))
        {!! session('Success') !!}
    @endif
    </div>

    <div class="clearfix"></div>
    <div class="add-franchise-data-main-1">
        <div class="tab-content">
            <div id="franchise-demography" class="tab-pane fade in active">
                <div class="view-tab-content-main">
                    <div class="view-tab-content-head-main">
                        <div class="view-tab-content-head">
                            <h3>Settings Details</h3>
                        </div>
                        <div class="view-tab-content-butn">
                            <a href="{{ url('admin/settings/edit') }}" class="btn add-franchise-data-butn-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Details</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="view-tab-content">
                        @if($Settings)
                            @foreach($Settings as $setting)
                                @if($setting->key)	
                                <figure>
                                	<h5>{{ ucfirst($setting->key) }}</h5>
                                    <h4>
                                        @if($setting->key == "State") 
                                        	@php
                                            	$state_name  = $setting->value;
                                                if(!empty($setting->get_state_by_code($state_name)))
                                                {
                                                	$state_name  = $setting->get_state_by_code($state_name)->state_name;
                                                }
                                            @endphp
                                            
                                            {{ $state_name }} 
                                        @else 
                                        	{{ $setting->value }} 
                                        @endif
                                    </h4>
                                </figure>
                                @endif
                            @endforeach
                        @endif
                        <div class="padd-view"></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
