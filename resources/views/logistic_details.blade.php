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
            <h2>Locations</h2>
        </div>
        <div class="row">
            @if($locations->count() >0)
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Country</th>
                                <th scope="col">State</th>
                                <th scope="col">City</th>
                                <th scope="col">Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($locations as $log)
                                    <tr>
                                        <td>{{$log->country}}</td>
                                        <td>{{$log->State}}</td>
                                        <td>{{$log->City}}</td>
                                        <td>{{$log->currency}} {{number_format($log->Charge,2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$locations->links()}}
                    </div>
                </div>
            @else
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="features-box">
                        <h3>No location for partner found.</h3>
                        <p>Please contact support for any suggestions</p>
                        <div class="back-icon">
                            <i class='bx bx-reset'></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</section>
<!-- End Logistics Area -->


@include('templates/footer')
