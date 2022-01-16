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

<!-- Start About Area -->
<section class="about-area ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="about-content text-justify">
                    <h2 class="about-content text-left">A growth engine for modern businesses in Africa</h2>
                    <p>
                        According to the <b>Nigeria Bureau of Statistics</b>  small and medium scale enterprises <b>(SMEs)</b> in
                        Nigeria have contributed about <b>48%</b> of the national GDP,account for <b>96%</b> of businesses and
                        <b>84%</b> of employment in the last five years. While in South Africa, <b>SMEs</b> account for
                        <b>91%</b> of businesses, <b>60%</b> of employment and contribute <b>52%</b> of total GDP.
                        <br> Despite this high number, a lot of losses and fraud take place especially during online transactions
                        which inlcude clients/customers being unwilling to pay for goods/services that was delivered/rendered to them;
                        merchants not delivering the supposed product purchased, even freelancers not executing the services which they were
                        paid for.<br>
                    </p>

                    <p>{{$web->siteName}}, a payments solutions platform built on
                        escrow technology, help Africa’s businesses grow - from new startups, to market leaders
                        in the commerce industry and beyond.
                    </p>
                    <p>
                        We take pride in interfacing between buyers and sellers, ensuring safety and increasing trust,
                        thereby contributing to commerce growth in Africa.
                        We make transactions safe and flexible, offering several options and tools for businesses to
                        boost customer acquisition and maintain customer retainership.
                    </p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="about-image">
                    <img src="{{ asset('home/img/about-img.jpg')}}" alt="image">
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="about-content">
                    <br>
                    <p>
                        As business owners, and as Africans ourselves, we are driven by the passion and vision of
                        businesses across Africa, and we want to contribute to the growth of online businesses across
                        the continent.
                    </p>
                    <p>
                        Not just that, {{$web->siteName}} is building the perfect and nextGen marketplace that is all inclusive,
                        ensuring a safer transaction as well as eliminating the scenario of <b>What I ordered for </b> vs
                        <b>What I Got.</b>
                    </p>
                    <p>
                        {{$web->siteName}} empowers over thousands of sellers and buyers transact safely, even making accessible
                        the awesome features of both a marketplace and payment solution available to merchants and sellers of all
                        type of commodity.
                    </p>
                    <p>
                        As our <b>CEO</b> will always say, <q>Na merchants wey sabi dey sell with {{$web->siteName}}; and na customer/client
                            wey sabi dey buy with {{$web->siteName}}.</q> We are all inclusive and expanding gradually to other
                        countries within the continent. <br> Our firm belief is that with a healthy and wholesome payment system
                        that respects both the buyers and sellers privacy while maintaining a total credibility in transaction,
                        the <b>commerce</b> sector of the Africa Economy will continue to flourish.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->

<!-- Start Partner Area -->
<section class="partner-area pt-70 pb-70 bg-f8fbfa">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-12">
                <div class="partner-title">
                    <h3>Featured by:</h3>
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="partner-slides owl-carousel owl-theme">
                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/1.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/2.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/3.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#">
                            <img src="{{ asset('home/img/partner-image/4.png')}}" alt="image">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Partner Area -->

<!-- Start Video Presentation Area -->
<section class="video-presentation-area ptb-100">
    <div class="container">
        <div class="section-title">
            <h2>Watch this video presentation to know more</h2>
        </div>

        <div class="video-box">
            <img src="{{ asset('home/img/video-bg.jpg')}}" class="main-image" alt="image">

            <a href="https://www.youtube.com/watch?v=0gv7OC9L2s8" class="video-btn popup-youtube"><i class="bx bx-play"></i></a>

            <div class="shape1"><img src="{{ asset('home/img/shape/1.png')}}" alt="image"></div>
            <div class="shape2"><img src="{{ asset('home/img/shape/2.png')}}" alt="image"></div>
            <div class="shape3"><img src="{{ asset('home/img/shape/3.png')}}" alt="image"></div>
            <div class="shape4"><img src="{{ asset('home/img/shape/4.png')}}" alt="image"></div>
            <div class="shape5"><img src="{{ asset('home/img/shape/5.png')}}" alt="image"></div>
            <div class="shape6"><img src="{{ asset('home/img/shape/6.png')}}" alt="image"></div>
        </div>

        <div class="funfacts-inner">
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
        </div>

        <div class="contact-cta-box">
            <h3>Have any question about us?</h3>
            <p>Don't hesitate to contact us.</p>

            <a href="#" class="default-btn"><i class="bx bxs-edit-alt"></i>Contact Us<span></span></a>
        </div>
    </div>

    <div class="shape-map1"><img src="{{ asset('home/img/map1.png')}}" alt="image"></div>
    <div class="shape7"><img src="{{ asset('home/img/shape/7.png')}}" alt="image"></div>
    <div class="shape8"><img src="{{ asset('home/img/shape/8.png')}}" alt="image"></div>
    <div class="shape9"><img src="{{ asset('home/img/shape/9.png')}}" alt="image"></div>
</section>
<!-- End Video Presentation Area -->

<!-- Start Team Area -->
<section class="team-area pb-70">
    <div class="container">
        <div class="section-title">
            <h2>Meet Our Team of experts always ready to help you</h2>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/michaelerastus.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Michael Erastus</h3>
                        <span>CEO & Founder</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/chikezieemmanuel.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Chikezie Emmanuel</h3>
                        <span>UX/UI Designer & Co-founder</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/chijiokeemmanuel.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Chijioke Emmanuel</h3>
                        <span>Web Developer & co-founder</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/aniprecious.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Ani Precious</h3>
                        <span>Backend Developer & CTO</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/ohaerililian.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Ohaeri Lilian</h3>
                        <span>CFO</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/ugonnabarr.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Bar. Ugonna</h3>
                        <span>Legal Advisor & Founder of Barrister Street</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/stanleyibe.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Stanley Ibe</h3>
                        <span>Project Manager & Mobile App Dev.</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image">
                        <img src="{{ asset('home/img/team-image/rabbiu.jpg')}}"
                             alt="image" style="height:230px;">

                        <ul class="social">
                            <li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                        </ul>
                    </div>

                    <div class="content">
                        <h3>Abubakar Rabbiu</h3>
                        <span>CIO</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Team Area -->

@if(!empty($web->androidLink))
<!-- Start App Download Area -->
<section class="app-download-area ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-12">
                <div class="app-download-image">
                    <img src="{{ asset('home/img/mobile.png')}}" alt="image">
                </div>
            </div>

            <div class="col-lg-7 col-md-12">
                <div class="app-download-content">
                    <span class="sub-title">Download App</span>
                    <h2>Supporting your customers on the go with our mobile app</h2>

                    <div class="btn-box">
                        @if(!empty($web->iphoneLink))
                        <a href="{{$web->iphoneLink}}" class="apple-store-btn" target="_blank">
                            <img src="{{ asset('home/img/applestore.png')}}" alt="image">
                            Download on the
                            <span>Apple Store</span>
                        </a>
                        @endif
                        <a href="{{$web->androidLink}}" class="play-store-btn">
                            <img src="{{ asset('home/img/playstore.png')}}" alt="image">
                            Get it on
                            <span>Google Play</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End App Download Area -->
@endif

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
@include('templates/footer')
