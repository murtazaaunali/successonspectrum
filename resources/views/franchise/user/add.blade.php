@extends('franchise.layout.main')

@section('content')
    <div class="main-deck-head">
        <h4>{{$sub_title}}</h4>
    </div>
    @if(Session::has('Success'))
        {!! session('Success') !!}
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="add-user-white-body-main">
        <form method="POST" action="{{ route('franchise.store_user')  }}" enctype="multipart/form-data">
            <div class="upload-display-head-main">
                <div class="upload-display-pic-head-main">
                    <h3>Upload Display Picture</h3>
                </div>
                <div class="upload-display-pic-head-main-main">
                    <div class="upload-display-pic-head-main Padd-Left-0">
                        <h3 class="Responsive-Text-None">Add Information</h3>
                    </div>
                    <div class="upload-display-pic-btn-main">
                        <button class="btn add-franchise-data-butn-1 pos-rel-sav-butn"><i class="fa fa-check" aria-hidden="true"></i>Add User</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row mar0">
                <div class="col-md-4 col-xs-12 col-sm-4 col-4">

                    <div class="upload-display-pic-main">

                        <div class="upload-display-icon-main">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>

                        <h5 class="upload_profile" title="Upload Display Picture">Upload Display Picture</h5>

                        <div class="hidden">
                            <input type="file" name="profile_picture" class="upload_picture" accept="image/*" />
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-8 col-5">
                    <div class="UpdateTextDextopNone">
                        <h3>Add Information</h3>
                    </div>
                    <div class="super-admin-add-relation-main border-bot-0 add-user-main-input">
                        <figure>
                            <label>Name</label>
                            <input type="text" name="fullname" @if(old('fullname')) value="{{ old('fullname') }}" @endif placeholder="Name" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </figure>
                        <figure>
                            <label>Email Address</label>
                            <input type="text" name="email" @if(old('email')) value="{{ old('email') }}" @endif placeholder="Email Address" />
                        </figure>
                        <figure>
                            <label>Role/Designation</label>
                            <select name="type">
                                <option value="">Select Role</option>
                                @if(!empty($designations))
                                    @foreach($designations as $destination)
                                        <option value="{{ $destination }}">{{ $destination }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </figure>
                        <figure>
                            <label>Password</label>
                            <input type="Password" name="password" value="" placeholder="Password" />
                        </figure>
                        <figure>
                            <label>Confirm Password</label>
                            <input type="Password" name="password_confirmation" value="" placeholder="Confirm Password" />
                        </figure>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
