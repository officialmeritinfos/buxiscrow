@include('dashboard.admin.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="d-flex">
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

@inject('option','App\Custom\CustomChecks')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$pageName}}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/general_settings/edit')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Name</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="name" value="{{$web->siteName}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Email</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="email" value="{{$web->siteEmail}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Support Email</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="support" value="{{$web->siteSupportMail}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Dev Email</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="dev" value="{{$web->siteDevMail}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Career Email</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="career" value="{{$web->siteCareerMail}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Legal Email</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="legal" value="{{$web->legalMail}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Tag</label>
                                <textarea class="form-control form-control-lg" id="exampleInputEmail1"
                                name="tag">{{$web->siteTag}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Description</label>
                                <textarea class="form-control form-control-lg" id="exampleInputEmail1"
                                name="description">{{$web->siteDescription}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Address</label>
                                <textarea class="form-control form-control-lg" id="exampleInputEmail1"
                                name="address">{{$web->siteAddress}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">User Code</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="user_code" value="{{$web->userCode}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Site Abbr.</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="site_abbr" value="{{$web->siteAbbr}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Referral Bonus</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="ref_bonus" value="{{$web->referralBonus}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Url Link</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="url_link" value="{{$web->url}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Time To Reset Code</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="code_expires" value="{{$web->codeExpires}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Blog Link</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="blog" value="{{$web->blogLink}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Phone</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="phone" value="{{$web->phone}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Celebrate Referral</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="celebrate_ref" value="{{$web->referral_celebrate}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Celebrate Transaction</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="celebrate_trans" value="{{$web->trans_celebrate}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Android Link</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="android_link" value="{{$web->androidLink}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Ios Link</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="ios_link" value="{{$web->iphoneLink}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Merchant Code</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="merchant_code" value="{{$web->merchantCode}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md- text-center">
                            <div class="form-group">
                                <label class="form-label">2FA <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="twoway">
                                    <option value="">Select Status</option>
                                    @if ($web->twoWay == 1)
                                        <option value="1" selected>Active</option>
                                        <option value="2">Inactive</option>
                                    @else
                                        <option value="1">Active</option>
                                        <option value="2" selected>Inactive</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md- text-center">
                            <div class="form-group">
                                <label class="form-label">Email Verification <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="emailverification">
                                    <option value="">Select Status</option>
                                    @if ($web->emailVerification == 1)
                                        <option value="2">Active</option>
                                        <option value="1" selected>Inactive</option>
                                    @else
                                        <option value="2" selected>Active</option>
                                        <option value="1" >Inactive</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md- text-center">
                            <div class="form-group">
                                <label class="form-label">Notification <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="notification">
                                    <option value="">Select Status</option>
                                    @if ($web->notification == 1)
                                        <option value="1" selected>Active</option>
                                        <option value="2">Inactive</option>
                                    @else
                                        <option value="1">Active</option>
                                        <option value="2" selected>Inactive</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md- text-center">
                            <div class="form-group">
                                <label class="form-label">Site Registration <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="site_reg">
                                    <option value="">Select Status</option>
                                    @if ($web->siteRegistration == 1)
                                        <option value="1" selected>Active</option>
                                        <option value="2">Inactive</option>
                                    @else
                                        <option value="1">Active</option>
                                        <option value="2" selected>Inactive</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div><!-- end app-content-->
</div>


@include('dashboard.admin.templates.footer')
