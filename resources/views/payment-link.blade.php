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
                                <h1>Receive payments with ease without a website or integration.</h1>
                                <p>Stay safe, transparent & secure with {{$web->siteName}}. Protect yourself from fraud
                                    over anonymous transactions.<br> </p>

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
                <div class="banner-image bg-2">
                    <div class="chat-wrapper">
                        <div class="chat">
                            <div class="chat-container">
                                <div class="chat-listcontainer">
                                    <ul class="chat-message-list"></ul>
                                </div>
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

<!-- Start Partner Area -->
<section class="partner-area pt-100 pb-70 bg-f8fbfa">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-12">
                <div class="partner-title">
                    <h3>Trusted by:</h3>
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="partner-slides owl-carousel owl-theme">
                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/1.png') }}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/2.png') }}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/3.png') }}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/4.png') }}" alt="image">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Partner Area -->

<!-- Start Subscribe Content -->
<div class="subscribe-content border-radius-0" style="color: #1c7430;">
    <div class="text-center text-blue">
        <h2>Building a business is already hard.</h2>
        <h2>Why should getting paid be?</h2>
    </div>

    <div class="shape14"><img src="{{ asset('home/img/shape/13.png') }}" alt="image"></div>
    <div class="shape15"><img src="{{ asset('home/img/shape/14.png') }}" alt="image"></div>
    <div class="shape16"><img src="{{ asset('home/img/shape/15.png') }}" alt="image"></div>
    <div class="shape17"><img src="{{ asset('home/img/shape/16.png') }}" alt="image"></div>
    <div class="shape18"><img src="{{ asset('home/img/shape/17.png') }}" alt="image"></div>
</div>
<!-- End Subscribe Content -->
<!-- Start Services Area -->
<section class="services-area bg-right-shape ptb-100">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="services-image  wow fadeInRight" data-wow-delay=".3s">
                <div class="image">
                    <img src="{{ asset('home/img/payment/Online-transactions-pana.png')}}" alt="image">
                </div>
            </div>
            <div class="services-content it-service-content">
                <div class="content left-content">
                    <div class="icon">
                        <img src="{{ asset('home/img/icon1.png')}}" alt="image">
                    </div>
                    <h2 class="font-weight-bolder">Why Choose {{config('app.name')}}</h2>
                    <p>You don’t joke with your money, right? Relax. We don’t either. Everything here is secure. And
                        security doesn’t mean that it must be complex. We've made this very easy for everyone to use.
                        On top of that, we can accommodate your business, no matter how big it grows.
                    </p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <i class='bx bxs-badge-check'></i>
                                Secure transactions with 99.9% guarantee
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <i class='bx bxs-badge-check'></i>
                                Easily make payments
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <i class='bx bxs-badge-check'></i>
                                Almost free — with very little cost
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Services Area -->

<!-- Start Services Area -->
<section class="services-area bg-right-color ptb-100">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="services-content">
                <div class="content left-content">
                    <div class="icon">
                        <img src="{{ asset('home/img/icon1.png') }}" alt="image">
                    </div>
                    <h2 class="font-weight-bolder">A Fully Integrated Suite For Large Enterprise</h2>
                    <p>{{$web->siteName}} is suitable for large scale businesses with advanced business management tools
                        to allow for proper accounting of payments, and features to accommodate its scaling.</p>

                    <a href="{{url('payment-processing')}}" class="default-btn"><i class="bx bxs-spreadsheet"></i> Learn More<span></span></a>
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

<!-- Start Services Area -->
<section class="services-area bg-left-color bg-f4f6fc ptb-100">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="services-image wow fadeInLeft" data-wow-delay=".3s">
                <div class="image">
                    <img src="{{ asset('home/img/payment/payment2.png') }}" alt="image">
                </div>
            </div>

            <div class="services-content">
                <div class="content">
                    <div class="icon">
                        <img src="{{ asset('home/img/icon1.png') }}" alt="image">
                    </div>
                    <h3 class="font-weight-bolder">Awesome Experience for Customers</h3>
                    <p>{{config('app.name')}} gives you the power you need to build a risk-free payment structure that
                        your customers can trust. Suitable for online marketplaces, e-commerce shops, and much more.
                    </p>

                    <a href="#" class="default-btn">
                        <i class="bx bxs-spreadsheet"></i>
                        Learn More
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Services Area -->

<!-- Start Video Presentation Area -->
<section class="video-presentation-area ptb-100">
    <div class="container">
        <div class="section-title">
            <h2>Vendor and Buyers Wey Sabi</h2>
        </div>

        <div class="video-box">
            <img src="{{ asset('home/img/video-bg.jpg') }}" class="main-image" alt="image">

            <a href="https://www.youtube.com/watch?v=0gv7OC9L2s8" class="video-btn popup-youtube">
                <i class="bx bx-play"></i>
            </a>

            <div class="shape1"><img src="{{ asset('home/img/shape/1.png') }}" alt="image"></div>
            <div class="shape2"><img src="{{ asset('home/img/shape/2.png') }}" alt="image"></div>
            <div class="shape3"><img src="{{ asset('home/img/shape/3.png') }}" alt="image"></div>
            <div class="shape4"><img src="{{ asset('home/img/shape/4.png') }}" alt="image"></div>
            <div class="shape5"><img src="{{ asset('home/img/shape/5.png') }}" alt="image"></div>
            <div class="shape6"><img src="{{ asset('home/img/shape/6.png') }}" alt="image"></div>
        </div>

        <!--<div class="funfacts-inner">
            <div class="row">
                <div class="col-lg-3 col-6 col-sm-3 col-md-3">
                    <div class="single-funfacts">
                        <h3><span class="odometer" data-count="180">00</span><span class="sign-icon">k</span></h3>
                        <p>Downloaded</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6 col-sm-3 col-md-3">
                    <div class="single-funfacts">
                        <h3><span class="odometer" data-count="20">00</span><span class="sign-icon">k</span></h3>
                        <p>Feedback</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6 col-sm-3 col-md-3">
                    <div class="single-funfacts">
                        <h3><span class="odometer" data-count="500">00</span><span class="sign-icon">+</span></h3>
                        <p>Workers</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6 col-sm-3 col-md-3">
                    <div class="single-funfacts">
                        <h3><span class="odometer" data-count="70">00</span><span class="sign-icon">+</span></h3>
                        <p>Contributors</p>
                    </div>
                </div>
            </div>
        </div>-

        <div class="contact-cta-box">
            <h3>Have any question about us?</h3>
            <p>Don't hesitate to contact us.</p>

            <a href="#" class="default-btn"><i class="bx bxs-edit-alt"></i>Contact Us<span></span></a>
        </div>-->
    </div>

    <div class="shape-map1"><img src="{{ asset('home/img/map1.png') }}" alt="image"></div>
    <div class="shape7"><img src="{{ asset('home/img/shape/7.png') }}" alt="image"></div>
    <div class="shape8"><img src="{{ asset('home/img/shape/8.png') }}" alt="image"></div>
    <div class="shape9"><img src="{{ asset('home/img/shape/9.png') }}" alt="image"></div>
</section>
<!-- End Video Presentation Area -->

<!-- Start Features Area -->
<section class="features-area pt-100 pb-70 bg-f4f6fc">
    <div class="container">
        <div class="section-title">
            <h2 class="font-weight-bolder">Why <span class="text-orange">{{config('app.name')}}</span> ?</h2>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-features-box wow zoomIn" data-wow-delay=".1s">
                    <div class="icon">
                        <i class='bx bx-lock'></i>
                    </div>
                    <h3>Security First</h3>
                    <p>We provide you bank-grade security with secure PIN, activity logs & notifications.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-features-box wow zoomIn" data-wow-delay=".2s">
                    <div class="icon">
                        <i class='bx bx-chat'></i>
                    </div>
                    <h3>World class support</h3>
                    <p>Access 24/7 support. Chat or Call? We are only 1-click away.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-features-box wow zoomIn" data-wow-delay=".3s">
                    <div class="icon">
                        <i class='bx bx-certification'></i>
                    </div>
                    <h3>Regulatory Compliance</h3>
                    <p>We are fully compliant with all applicable laws and regulations, including GDPR while using
                        certified payment processors to process your payments.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-features-box wow zoomIn" data-wow-delay=".4s">
                    <div class="icon">
                        <i class='bx bx-user-check'></i>
                    </div>
                    <h3>KYC/AML Verification</h3>
                    <p>In a bid to keep you safe, we verify all users to ensure authenticity of your client.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-features-box wow zoomIn" data-wow-delay=".5s">
                    <div class="icon">
                        <i class='bx bx-bell'></i>
                    </div>
                    <h3>Real Time Notification</h3>
                    <p>Get SMS/Email notifications about your ongoing transactions in real time.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-features-box wow zoomIn" data-wow-delay=".6s">
                    <div class="icon">
                        <i class='bx bx-rocket'></i>
                    </div>
                    <h3>Instant Disbursement</h3>
                    <p>Get your money, when you want and where you want it speedily. No delays.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Features Area -->

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
