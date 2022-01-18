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
<div class="card col-md-8 mx-auto text-center" id="tabs-style3">
    <div class="card-header">
        <div class="card-title">
            {{$pageName}}
        </div>
    </div>
    <div class="card-body">
        @if($users->isVerified ==1)
            <p class="text-success">
                Document has been verified
                <br>
            </p>
            <div class="row w-100">
                <div class="col-md-8 col-lg-8 mx-auto">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Doument Type: <b>{{$document->documentType}}</b></h5>
                        </div>
                        <img  src="{{asset('user/photos/'.$document->document)}}"
                              alt="image" class="img-height" style="height: 400px;">
                    </div>
                </div>
            </div>
        @elseif($users->isVerified == 4)
            <p class="text-info">
                Document is pending verification
            </p>
            <div class="row w-100">
                <div class="col-md-8 col-lg-8 mx-auto">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Doument Type: <b>{{$document->documentType}}</b></h5>
                        </div>
                        <img  src="{{asset('user/photos/'.$document->document)}}"
                              alt="image" class="img-height" style="height: 400px;">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>



<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.admin.templates.footer')
