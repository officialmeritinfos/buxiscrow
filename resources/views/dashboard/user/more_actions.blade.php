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
<div class="card" id="tabs-style3">
    <div class="card-header">
        <div class="card-title">

        </div>
    </div>
    <div class="card-body">
        <div class="btn-list text-center">
            <a href="{{url('account/documents/verify')}}" class="btn btn-dark"><i class="mdi mdi-account-check mr-2"></i> Verify Account</a>
            <!--<a href="{{url('account/documents/documents')}}" class="btn btn-primary"><i class="mdi mdi-file-document mr-2"></i> View Submitted Documents</a>
            @if($user->isVerified ==3)
                <a href="{{url('account/documents/error')}}" class="btn btn-dark"><i class="mdi mdi-account-check mr-2"></i> View Documents with Error</a>
            @endif-->
        </div>
    </div>
</div>



<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.user.templates.footer')
