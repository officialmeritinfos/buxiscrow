
<!doctype html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="copyright" content="{{$web->siteName}} is a registered trademark of Meritinfos LLC">
    <meta name="title" content="{{$web->siteName}} - Preventing Fraud in transactions">
    <meta name="description" content="{{$web->siteName}} - Preventing Fraud in transactions">
    <meta name="robots" content="index,follow">
    <meta name="author" content="Meritinfos LLC">
    <meta name="keywords" content="{{$web->siteTag}}"/>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{$web->url}}">
    <meta property="og:title" content="{{$web->siteName}} - Preventing Fraud in transactions">
    <meta property="og:description" content="{{$web->siteDescription}}">
    <meta property="og:image" content="{{ asset('home/img/'.$web->favicon) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{$web->url}}">
    <meta property="twitter:title" content="{{$web->siteName}} - Preventing Fraud in transactions">
    <meta property="twitter:description" content="{{$web->siteDescription}}">
    <meta property="twitter:image" content="{{ asset('home/img/'.$web->favicon) }}">
    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}">
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/animate.min.css') }}">
    <!-- BoxIcons Min CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/boxicons.min.css') }}">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/owl.carousel.min.css') }}">
    <!-- Odometer Min CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/odometer.min.css') }}">
    <!-- MeanMenu CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/meanmenu.css') }}">
    <!-- Magnific Popup Min CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/magnific-popup.min.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/responsive.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('home/img/'.$web->favicon) }}">
    <title>{{$pageName}} || {{$slogan}}</title>
    <!-- TrustBox script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End TrustBox script -->
</head>

<body>

<!-- Start Preloader Area -->
<div class="preloader-area">
    <div class="spinner">
        <div class="inner">
            <div class="disc"></div>
            <div class="disc"></div>
            <div class="disc"></div>
        </div>
    </div>
</div>
<!-- End Preloader Area -->

<!-- Start Navbar Area -->
<div class="navbar-area">
    <div class="spacle-responsive-nav">
        <div class="container">
            <div class="spacle-responsive-menu">
                <div class="logo">
                    <a href="{{url('index')}}">
                        <img src="{{ asset('home/img/'.$web->logo) }}" alt="logo" style="width:120px;">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="spacle-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{url('index')}}">
                    <img src="{{ asset('home/img/'.$web->logo) }}" alt="logo" style="width:120px;">
                </a>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{url('index')}}" class="nav-link">Home</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Company <i class='bx bx-chevron-down'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{url('about')}}" class="nav-link">About</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{url('team')}}" class="nav-link">Team</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{url('career')}}" class="nav-link">Career</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('logistics')}}" class="nav-link">Available Logistics Partners</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Support <i class='bx bx-chevron-down'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{url('faq')}}" class="nav-link">Faq</a>
                                </li>

                                <li class="nav-item">
                                    <a href="https://buxiscrow-solutions.gitbook.io/buxiscrow-knowledge-base/" target="_blank" class="nav-link">Help Desk</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{url('community')}}" class="nav-link">Community</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Solutions <i class='bx bx-chevron-down'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{url('stores')}}" class="nav-link">Stores <small class="badge badge-success">coming soon</small></a>
                                </li>

                                <!--<li class="nav-item">
                                    <a href="{{url('payment-processing')}}" class="nav-link">Payment Processing</a>
                                </li>-->

                                <li class="nav-item">
                                    <a href="{{url('payment-link')}}" class="nav-link">Payment link </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Developers <i class='bx bx-chevron-down'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="https://buxiscrow-solutions.gitbook.io/api-docs/" target="_blank" class="nav-link">Documentation</a>
                                </li>

                                <li class="nav-item">
                                    <a href="https://buxiscrow-solutions.gitbook.io/api-reference/" target="_blank" class="nav-link">Api Reference</a>
                                </li>

                                <!--<li class="nav-item">
                                    <a href="{{url('plugin')}}" class="nav-link">Plugins </a>
                                </li>-->
                            </ul>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a href="#" class="nav-link">
                                Account <i class='bx bx-chevron-down'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{url('login')}}" class="nav-link">Login </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('register')}}" class="nav-link">Register </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('contact')}}" class="nav-link">Contact</a>
                        </li>
                    </ul>

                    <div class="others-options">
                        <a href="{{url('register')}}" class="default-btn">
                            <i class="bx bxs-hot"></i>Register For Free<span></span>
                        </a>
                        <a href="{{url('login')}}" class="optional-btn">
                            <i class="bx bx-log-in"></i>Log In<span></span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->
