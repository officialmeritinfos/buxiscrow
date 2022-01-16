@include('dashboard.user.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('account/dashboard')}}" class="d-flex">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                        <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                    </svg>
                    <span class="breadcrumb-icon"> Home</span></a>
            </li>
            <li class="breadcrumb-item active"><a href="#">{{$pageName}}</a></li>
        </ol>
    </div>
</div>
<!--End Page header-->
<!-- Row -->
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card box-widget widget-user">
            <div class="widget-user-image mx-auto mt-5 text-center">
                @if($user->isUploaded==1)
                    <img alt="User Avatar" class="rounded-circle" src="{{asset('user/photos/'.$user->photo)}}" style="width:100px; height: 100px;">
                @else
                    <img alt="User Avatar" class="rounded-circle" src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random">
                @endif
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    <h3 class="pro-user-username text-dark mb-1">{{$user->name}}</h3>
                    <h6 class="pro-user-desc text-muted">{{$user->occupation}}</h6>
                    <form method="post" action="{{url('account/settings/profile_change')}}" id="update_profile_pic"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4 ml-0 ml-sm-auto ">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="profile_pic"
                                       accept="image/*" id="ImageBrowse">
                                <label class="custom-file-label">Change profile</label>
                            </div>
                        </div>
                    </form><br><br>
                    @if($user->isVerified ==2)
                        <p class="text-danger" style="font-size:15px;">Your account is unverified.
                            Verify Now to enjoy premium and unlimited features.<a href="{{url('account/documents/verify')}}">
                                Start Now
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold">Lv. {{$user->userLevel}}</h5>
                            <span class="text-muted">Level</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="description-block text-center p-4">
                            <h5 class="description-header mb-1 font-weight-bold">{{$user->creation_ip}}</h5>
                            <span class="text-muted">Ip Address</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Password</div>
            </div>
            <div class="card-body">
                <div class="text-center mb-5">
                    @if($user->isUploaded==1)
                        <img alt="User Avatar" class="rounded-circle  mr-3" src="{{asset('user/photos/'.$user->photo)}}"
                             style="width:100px; height: 100px;">
                    @else
                        <img alt="User Avatar" class="rounded-circle  mr-3" src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random">
                    @endif
                </div>
                <form method="post" action="{{url('account/settings/change_password')}}" id="change_password">
                    <div class="form-group">
                        <label class="form-label">Old Password</label>
                        <input type="password" class="form-control" name="old_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password">
                    </div>
                    @if($user->setPin ==1)
                        <div class="form-group">
                            <label class="form-label">Account Pin</label>
                            <input type="password" class="form-control" name="pin" minlength="6" max="6">
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" id="update_password">Update</button>
                            @else
                                <div class="card-footer text-center">
                                    <p class="text-danger">You need to set your account Pin First to proceed</p>
                                    <p><button class="btn btn-primary" type="button" data-toggle="modal" data-target="#set_pin">Set Pin</button> </p>
                                    @endif
                                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Profile</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('account/settings/update_profile')}}"
                      id="updateProfile">
                    @csrf
                    <div class="card-title font-weight-bold">Basic info:</div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                @if($user->hasBvn==1)
                                    <input type="text" class="form-control" placeholder="Full Name" readonly
                                           value="{{$user->name}}" name="name">
                                @else
                                    <input type="text" class="form-control"
                                           placeholder="Full Name"  name="name" value="{{$user->name}}">
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" placeholder="Email"
                                       value="{{$user->email}}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="email" class="form-control" placeholder="Username"
                                       value="{{$user->username}}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control" placeholder="Number" name="phone"
                                       value="{{$user->phone}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-title font-weight-bold">Contact info:</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea type="text" class="form-control" placeholder="Home Address" name="address">
                                                    {{$user->address}}
                                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <select class="form-control nice-select" id="country" name="country">
                                    <option value="">Select Country</option>
                                    <option value="{{$country->iso2}}" selected>{{$country->name}}</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->iso2}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select class="form-control nice-select" id="states" name="state">
                                    @if($user->state !=null)
                                        <option value="{{$state->id}}" selected>{{$state->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <select class="form-control nice-select" id="city" name="city">
                                    <option value="{{$user->city}}" selected>{{$user->city}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Postal Code</label>
                                <input type="number" class="form-control" placeholder="ZIP Code" name="zip_code" value="{{$user->zipCode}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control" placeholder="Date of Birth" name="dob" value="{{$user->DOB}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Occupation (Optional)</label>
                                <input type="text" class="form-control" placeholder="Are you a student, an Entrepreneur etc"
                                       name="occupation" value="{{$user->occupation}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Account Currency</label>
                                <select class="form-control nice-select" id="country" name="currency">
                                    <option value="">Select Currency</option>
                                    <option value="{{$user->majorCurrency}}" selected>{{$user->majorCurrency}}</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->code}}">{{$currency->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-title font-weight-bold mt-5">About:</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">About Me (Optional)</label>
                                <textarea rows="5" class="form-control" placeholder="Tell us a little about yourself"
                                          name="about">{{$user->about}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-lg btn-success" id="update_profile">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Security Details</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('account/settings/update_security')}}"
                      id="updateSecurity">
                    @csrf
                    <div class="card-title font-weight-bold">Security And Account Notification:</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Two Factor Authentication</label>
                                <select class="form-control nice-select" name="twoWay">
                                    <option value="">Select Option</option>
                                    @if($user->twoWay == 1)
                                        <option value="1" selected>ON[Selected] </option>
                                        <option value="2">OFF</option>
                                    @else
                                        <option value="1" >ON </option>
                                        <option value="2" selected>OFF [Selected]</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Receive Notifications</label>
                                <select class="form-control nice-select"  name="notification">
                                    <option value="">Select Option</option>
                                    @if($security->account_activity == 1)
                                        <option value="1" selected>ON[Selected] </option>
                                        <option value="2">OFF</option>
                                    @else
                                        <option value="1" >ON </option>
                                        <option value="2" selected>OFF[Selected]</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        @if($user->setPin ==1)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Account Pin</label>
                                    <input type="password" class="form-control" name="pin" minlength="6" max="6">
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary" id="update_security">Update</button>
                                @else
                                    <div class="card-footer text-center">
                                        <p class="text-danger">You need to set your account Pin First to proceed</p>
                                        <p><button class="btn btn-primary" type="button" data-toggle="modal" data-target="#set_pin">Set Pin</button> </p>
                                        @endif
                                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Theme & Account</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <li class="list-group-item">
                            Change Theme
                            <div class="material-switch pull-right">
                                <input id="someSwitchOptionPrimary" name="dark" type="checkbox"/>
                                <label for="someSwitchOptionPrimary" class="label-primary"></label>
                            </div>
                        </li>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <li class="list-group-item">
                            Switch to Merchant
                            <div class="material-switch pull-right">
                                <input id="someSwitchOptionInfo" class="accountSwitch" name="merchant" type="checkbox"/>
                                <label for="someSwitchOptionInfo" class="label-success"></label>
                            </div>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row-->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.user.templates.footer')
