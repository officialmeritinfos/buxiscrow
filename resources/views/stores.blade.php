@include('templates/header')
<!-- Start Main Banner Area -->
<div class="main-banner chatbot-main-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="main-banner-content">
                    <div class="d-table">
                        <div class="d-table-cell">
                            <div class="content">
                                <h1>Receive payments with ease with just a link</h1>
                                <p>
                                    Let your clients easily pay for their services by using your unique url.<br>
                                    {{$web->siteName}} advanced invoice tracking allows you to track each invoice as unique
                                    even though created by using same url. Very convenient and safe.<br>
                                    Receive instant notification about the transaction just as it is being created while
                                    you take care of other things.
                                </p>

                                <a href="{{url('register')}}" class="default-btn">
                                    <i class="bx bxs-hot"></i>
                                    Try It for Free Now
                                    <span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="banner-image mbanner-bg-one">
                    <div class="d-table">
                        <div class="d-table-cell">
                            <div class="animate-banner-image">
                                <img src="{{ asset('home/img/banner-img2.jpg') }}" alt="image">
                            </div>
                        </div>
                    </div>

                    <img src="{{ asset('home/img/banner-img2.jpg') }}" alt="image">
                </div>
            </div>
        </div>
    </div>

    <div class="shape20"><img src="{{ asset('home/img/shape/19.png') }}" alt="image"></div>
    <div class="shape21"><img src="{{ asset('home/img/shape/20.png') }}" alt="image"></div>
    <div class="shape19"><img src="{{ asset('home/img/shape/18.png') }}" alt="image"></div>
    <div class="shape22"><img src="{{ asset('home/img/shape/21.png') }}" alt="image"></div>
    <div class="shape23"><img src="{{ asset('home/img/shape/22.svg') }}" alt="image"></div>
    <div class="shape24"><img src="{{ asset('home/img/shape/23.png') }}" alt="image"></div>
    <div class="shape26"><img src="{{ asset('home/img/shape/25.png') }}" alt="image"></div>
</div>
<!-- End Main Banner Area -->

<!-- Start Subscribe Content -->
<div class="subscribe-content border-radius-0" style="color: #1c7430;">
    <div class="text-center text-blue">
        <h2>Tweak it as you want.</h2>
        <h4 class="text-white font-weight-lighter">Create seamless payment experiences for your customers through payment links.</h4>
    </div>

    <div class="shape14"><img src="{{ asset('home/img/shape/13.png') }}" alt="image"></div>
    <div class="shape15"><img src="{{ asset('home/img/shape/14.png') }}" alt="image"></div>
    <div class="shape16"><img src="{{ asset('home/img/shape/15.png') }}" alt="image"></div>
    <div class="shape17"><img src="{{ asset('home/img/shape/16.png') }}" alt="image"></div>
    <div class="shape18"><img src="{{ asset('home/img/shape/17.png') }}" alt="image"></div>
</div>
<!-- End Subscribe Content -->

<!-- Start Services Area -->
<section class="services-area bg-right-color ptb-100">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="services-content">
                <div class="content left-content">
                    <div class="icon">
                        <img src="{{ asset('home/img/icon1.png') }}" alt="image">
                    </div>
                    <h2 class="font-weight-bolder">Built for Freelancers</h2>
                    <p>
                        While we care to make every transaction safe, we also had you in mind and has built in this stress-free,
                        hassle-free payment link just to fit into your need.
                        <br>
                        With the {{config('app.name')}} payment link feature, you only need to set the transactions details you need
                        and tweak it t\just as you want. You have no need for any developer whatsoever. As a matter of fact, we
                        provide free support to help you out in this; yes, you read that right. No need for a web developer, we have made it
                        easier for you.
                    </p>
                </div>
            </div>

            <div class="services-image wow fadeInRight" data-wow-delay=".3s">
                <div class="image">
                    <img src="{{ asset('home/img/payment/Revenue-pana.png') }}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Services Area -->

@if(count($testimonials)>0)
    <!-- Start Feedback Area -->
    <section class="feedback-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2 class="font-weight-bolder">Customers' <span>Testimonies </span></h2>
            </div>

            <div class="feedback-slides owl-carousel owl-theme">
                @foreach($testimonials as $testimonial)
                    <div class="single-feedback-item d-flex align-items-stretch">
                        @empty($testimonial->photo)
                            <img src="https://ui-avatars.com/api/?name={{$testimonial->name}}&rounded=true&background=random"
                                 alt="image">
                        @else
                            <img src="{{asset('home/img/'.$testimonial->photo )}}"
                                 alt="image">
                        @endempty

                        <div class="feedback-desc">
                            <p>
                                {{$testimonial->comment}}
                            </p>
                            <div class="rating">
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                            </div>
                            <div class="client-info">
                                <h3>{{$testimonial->name}}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Start Feedback Area -->
@endif

@if(count($businesses)>0)
    <!-- Start Our Loving Clients Area -->
    <section class="our-loving-clients ptb-100 bg-f4f5fe">
        <div class="container">
            <div class="section-title">
                <h2>Top Verified Businesses</h2>
            </div>

            <div class="clients-logo-list align-items-center">
                @foreach($businesses as $business)
                    <div class="single-clients-logo">
                        @empty($business->logo)
                            <img src="https://ui-avatars.com/api/?name={{$business->name}} "
                                 alt="image">
                        @else
                            <img src="{{asset('merchant/photos/'.$business->logo )}}"
                                 alt="image" style="width:150px;">
                        @endempty
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- End Our Loving Clients Area -->
@endif

@include('templates/footer')
