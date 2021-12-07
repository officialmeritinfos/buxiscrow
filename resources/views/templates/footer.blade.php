<!-- Start Free Trial Area -->
<section class="free-trial-area pb-100 bg-f4f5fe">
    <div class="container">
        <div class="subscribe-content">
            <h2 class="font-weight-bolder text-blue">Start transacting safely</h2>
            <p class="text-white">
                Join thousands of other vendors and buyers using {{config('app.name')}} today, and
                earn awesome bonuses.
            </p>

            <a href="{{url('register')}}" class="btn btn-outline-primary"><i class="bx bxs-hot"></i> Try It for Free Now <span></span></a>
        </div>
    </div>

    <div class="shape10"><img src="{{ asset('home/img/shape/10.png') }}" alt="image"></div>
    <div class="shape11"><img src="{{ asset('home/img/shape/7.png') }}" alt="image"></div>
    <div class="shape12"><img src="{{ asset('home/img/shape/11.png') }}" alt="image"></div>
    <div class="shape13"><img src="{{ asset('home/img/shape/12.png') }}" alt="image"></div>
</section>
<!-- End Free Trial Area -->

<!-- Start Footer Area -->
<footer class="footer-area">
    <div class="divider"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <div class="logo">
                        <a href="index"><img src="{{ asset('home/img/'.$web->logo)}}" alt="image" style="width: 120px;"></a>
                    </div>
                    <p>{{$web->siteDescription}}</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h3>Company</h3>

                    <ul class="services-list">
                        <li><a href="{{url('about')}}">About Us</a></li>
                        <li><a href="{{url('career')}}">Career</a></li>
                        <li><a href="{{url('pricing')}}">Our Pricing</a></li>
                        <li><a href="{{$web->blogLink}}">News</a></li>
                        <li><a href="{{url('supported-escrows')}}">Supported Escrows</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h3>Support</h3>

                    <ul class="support-list">
                        <li><a href="{{url('faq')}}">FAQ's</a></li>
                        <li><a href="{{url('privacy')}}">Privacy Policy</a></li>
                        <li><a href="{{url('terms')}}">Terms & Conditions</a></li>
                        <li><a href="{{url('developers')}}">Developers</a></li>
                        <li><a href="{{url('contact')}}">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h3>Contact Info</h3>

                    <ul class="footer-contact-info">
                        <li>Location: <a href="https://goo.gl/maps/tzfXsbDyRmrCcqa3A" target="_blank">{{$web->siteAddress}}</a></li>
                        <li>Support: <a href="mailto:{{$web->siteEmail}}">{{$web->siteEmail}}</a></li>
                        <li>Whatsapp: <a href="https://api.whatsapp.com/send?phone=2348147298815&text=Give%20me%20further%20information%20about%20Buxiscrow">{{$web->phone}}</a></li>
                    </ul>
                    <ul class="social">
                        <li><a href="https://web.facebook.com/buxiscrow" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                        <li><a href="https://twitter.com/buxiscrow" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/showcase/buxiscrow/" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
                        <li><a href="https://instagram.com/buxiscrow" target="_blank"><i class="bx bxl-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="copyright-area">
            <p class="text-bold text-uppercase">Copyright {{ date('Y') }} <b>{{config('app.name')}}.</b></p>
        </div>
    </div>
</footer>
<!-- End Footer Area -->

<div class="go-top"><i class='bx bx-chevron-up'></i></div>

<!-- jQuery Min JS -->
<script src="{{ asset('home/js/jquery.min.js') }}"></script>
<!-- Popper Min JS -->
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<!-- Bootstrap Min JS -->
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<!-- Magnific Popup Min JS -->
<script src="{{ asset('home/js/jquery.magnific-popup.min.js') }}"></script>
<!-- Appear Min JS -->
<script src="{{ asset('home/js/jquery.appear.min.js') }}"></script>
<!-- Odometer Min JS -->
<script src="{{ asset('home/js/odometer.min.js') }}"></script>
<!-- Owl Carousel Min JS -->
<script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
<!-- MeanMenu JS -->
<script src="{{ asset('home/js/jquery.meanmenu.js') }}"></script>
<!-- WOW Min JS -->
<script src="{{ asset('home/js/wow.min.js') }}"></script>
<!-- Message Conversation JS -->
<script src="{{ asset('home/js/conversation.js') }}"></script>
<!-- AjaxChimp Min JS -->
<script src="{{ asset('home/js/jquery.ajaxchimp.min.js') }}"></script>
<!-- Form Validator Min JS -->
<script src="{{ asset('home/js/form-validator.min.js') }}"></script>
<!-- Contact Form Min JS -->
<script src="{{ asset('home/js/contact-form-script.js') }}"></script>
<!-- Particles Min JS -->
<script src="{{ asset('home/js/particles.min.js') }}"></script>
<script src="{{ asset('home/js/coustom-particles.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('home/js/main.js') }}"></script>
<script>
    window.fwSettings={
        'widget_id':72000000274
    };
    !function(){if("function"!=typeof window.FreshworksWidget){var n=function(){n.q.push(arguments)};n.q=[],window.FreshworksWidget=n}}()
</script>
<script type='text/javascript' src='https://widget.freshworks.com/widgets/72000000274.js' async defer></script>
<script>
    $(document).ready(() => {
        $(document.body).on('click', '.features-box[data-clickable=true]', (e) => {
            window.location = $(e.currentTarget).data('href');
        });
    });
</script>
</body>
</html>
