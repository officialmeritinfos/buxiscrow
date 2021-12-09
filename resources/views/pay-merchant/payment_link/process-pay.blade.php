
<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
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
    <!-- Title -->
    <title>{{$pageName}} {{$slogan}}</title>

    <!--Favicon -->
    <link rel="icon" href="{{ asset('home/img/'.$web->favicon) }}" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="{{asset('dashboard/public/assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{asset('dashboard/public/assets/css/style.css')}}" rel="stylesheet" />

    <!-- Dark css -->
    <link href="{{asset('dashboard/public/assets/css/dark.css')}}" rel="stylesheet" />

    <!-- Skins css -->
    <link href="{{asset('dashboard/public/assets/css/skins.css')}}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{asset('dashboard/public/assets/css/animated.css')}}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{asset('dashboard/public/assets/plugins/web-fonts/icons.css')}}" rel="stylesheet" />
    <link href="{{asset('dashboard/public/assets/plugins/web-fonts/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/public/assets/plugins/web-fonts/plugin.css')}}" rel="stylesheet" />
    @include('dashboard.noti_css')
</head>

<body class="h-100vh  light-mode default-sidebar" style="background-color: #ff4f0f;">
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pt-4">
                            <div class="card card-group">
                                <div class="card p-4">
                                    <div class="card-body">
                                        <div class="text-center title-style mb-6">
                                            <a href="{{url('')}}">
                                                <img src="{{ asset('home/img/'.$web->logo) }}"
                                                     class="header-brand-img desktop-logo" alt=" logo">
                                            </a>
                                            <br>
                                            <hr>
                                        </div>
                                        <form method="post"
                                              id="send_money" action="{{url('send-money/doSend')}}">

                                            <div class="form-group ">
                                                <p id="trans_ref" style="display: none;">{{$payment->reference}}</p>
                                                <p class="font-40 text-center text-primary" style="font-size:20px;" id="checking"></p>
                                                <p class="font-40 text-center text-primary" style="font-size:20px;" id="checkings">
                                                    <i id="icons"></i></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jquery js-->
<script src="{{asset('dashboard/public/assets/js/vendors/jquery-3.5.1.min.js')}}"></script>

<!-- Bootstrap4 js-->
<script src="{{asset('dashboard/public/assets/plugins/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('dashboard/public/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!--Othercharts js-->
<script src="{{asset('dashboard/public/assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>

<script src="{{ asset('dashboard/pay_merchant.js')}}"></script>

<!-- Circle-progress js-->
<script src="{{asset('dashboard/public/assets/js/vendors/circle-progress.min.js')}}"></script>

<!-- Jquery-rating js-->
<script src="{{asset('dashboard/public/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
@include('dashboard.noti_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"
        integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    new Cleave('input[name="amount"]', {
        numeral: true,
        numeralDecimalMark: '.',
        delimiter: ',',
        numeralDecimalScale: 2
    });
</script>
</body>
</html>
