@include('templates/headers')
<!-- Start Page Title Area -->
<div class="page-title-area bg-success">
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
            <div class="col-lg-6 col-md-6">
                <div class="about-content text-justify">
                    <h3 class="about-content text-left">We’re building a safety engine for modern businesses in Africa</h3>
                    <p>
                        At {{$web->siteName}}, we are passionate about each other. We are one big family and share together.
                        <br> We are looking for a talented fellow to join us build the <b>NEXTGEN</b> solution for the Africa
                        market.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="about-image">
                    <img src="{{ asset('home/img/payment/4966408.png')}}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->

@include('templates/footer')
