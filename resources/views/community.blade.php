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

<!-- Start Contact Area -->
<section class="contact-area ptb-100">
    <div class="container">
        <div class="contact-inner">
            <div class="contact-info">
                <div class="contact-info-content">
                    <h3>Join our Groups to Connect with our teeming community of traders</h3>

                    <ul class="social">
                        <li><a href="https://web.facebook.com/buxiscrow"
                               target="_blank"><i class="bx bxl-facebook"></i></a></li>
                        <li><a href="https://twitter.com/buxiscrow"
                               target="_blank"><i class="bx bxl-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/showcase/buxiscrow/"
                               target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                        <li><a href="https://instagram.com/buxiscrow"
                               target="_blank"><i class="bx bxl-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Area -->

@include('templates/footer')
