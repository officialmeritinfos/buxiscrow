@include('templates/headers')
<!-- Start Page Title Area -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2>{{$pageName}}</h2>
            <p>{{$slogan}}</p>
        </div>
    </div>
</div>
<!-- End Page Title Area -->

<!-- Start Logistics Area -->
<section class="features-area pt-100 pb-70">
    <div class="container">
        <div class="section-title">
            <h2>Logistics Partners</h2>
            <p class="text-primary">Click on any of them to view their locations and prices</p>
        </div>
        <div class="row">
            @if($businesses->count() >0)
                @foreach($businesses as $log)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="features-box" data-clickable="true"
                        data-href="{{url('logistics/'.$log->id.'/details')}}">
                            <div class="icon">
                                @empty($log->logo)
                                    <img src="https://ui-avatars.com/api/?name={{$log->name}} "
                                            alt="image">
                                @else
                                    <img src="{{asset('merchant/photos/'.$log->logo )}}"
                                        alt="image" style="width:150px;">
                                @endempty
                            </div>
                            <h3>{{$log->name}}</h3>
                            <p>
                                {{$log->phone}}
                            </p>

                            <div class="back-icon">
                                @empty($log->logo)
                                    <img src="https://ui-avatars.com/api/?name={{$log->name}} "
                                            alt="image">
                                @else
                                    <img src="{{asset('merchant/photos/'.$log->logo )}}"
                                        alt="image" style="width:150px;">
                                @endempty
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="features-box">
                        <h3>No logistics partner found.</h3>
                        <p>Please contact support for any suggestions</p>
                        <div class="back-icon">
                            <i class='bx bx-reset'></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{$businesses->links()}}
    </div>
</section>
<!-- End Logistics Area -->


@include('templates/footer')
