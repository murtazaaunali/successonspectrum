@extends('femployee.layout.main')

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
        <form method="POST" action="{{ url('/femployee/store_profile')  }}" enctype="multipart/form-data">
            <div class="upload-display-head-main">
                <div class="upload-display-pic-head-main">
                    <h3>Upload Display Picture</h3>
                </div>
                <div class="upload-display-pic-head-main-main">
                    <div class="upload-display-pic-head-main Padd-Left-0">
                        <h3 class="Responsive-Text-None">Update Information</h3>
                    </div>
                    <div class="upload-display-pic-btn-main">
                        <button class="btn add-franchise-data-butn-1 pos-rel-sav-butn"><i class="fa fa-check" aria-hidden="true"></i>Save Changes</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row mar0">
                <div class="col-md-4 col-xs-12 col-sm-4 col-4">

                    <div class="upload-display-pic-main">
                        @if($femployee->personal_picture != "" && $femployee->personal_picture != NULL)
                            <div class="upload-display-icon-main no-border">
                                <img src="{{ asset($femployee->personal_picture)  }}" class="img-responsive img-circle" />
                            </div>
                        @else
                            <div class="upload-display-icon-main">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        @endif
                        <h5 class="upload_profile" title="Upload Display Picture">Upload Display Picture</h5>

                        <div class="hidden">
                            <input type="file" name="profile_picture" class="upload_picture" accept="image/*" />
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-8 col-5">
                    <div class="UpdateTextDextopNone">
                        <h3>Update Information</h3>
                    </div>
                    <div class="super-admin-add-relation-main border-bot-0 add-user-main-input">
                        <figure>
                            <label>Name</label>
                            <input type="text" name="personal_name" @if(old('personal_name')) value="{{ old('personal_name') }}" @else value="{{ $femployee->personal_name }}" @endif placeholder="Name" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </figure>
                        <figure>
                            <label>Email Address</label>
                            <input type="text" name="personal_email" @if(old('personal_email')) value="{{ old('personal_email') }}" @else value="{{ $femployee->personal_email }}" @endif placeholder="Email Address" />
                        </figure>
                        <?php /*?><figure>
                            <label>Role/Designation</label>
                            <select name="type">
                                <option value="">Select Role</option>
                                @if(!empty($designations))
                                    @foreach($designations as $destination)
                                        <option value="{{ $destination }}" @if($user->type == $destination) selected="selected" @endif >{{ $destination }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </figure><?php */?>
                        <figure>
                            <label>Password</label>
                            <input type="Password" name="password" value="" placeholder="Password" />
                        </figure>
                        <figure>
                            <label>Confirm Password</label>
                            <input type="Password" name="password_confirmation" value="" placeholder="Confirm Password" />
                        </figure>
                        <input type="hidden" name="id" value="{{ $femployee->id }}"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
