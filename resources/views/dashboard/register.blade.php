
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

	<body class="h-100vh  light-mode default-sidebar" style="background-color: #031226; ">
		<div class="page">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-5 col-lg-5 pt-4">
									<div class="card card-group">
										<div class="card p-4">
											<div class="card-body">
												<div class="text-center title-style mb-6">
													<h1 class="mb-2">Onboarding</h1>
													<hr>
												</div>
                                                <form method="post" class="needs-validation was-validated"
                                                      id="create_account" action="{{url('api/register')}}">
                                                    <label class="form-label">Account Type</label>
                                                    <div class="input-group mb-3 selectgroup selectgroup-pills">
														<label class="selectgroup-item">
															<input type="radio" name="account_type" value="1" class="selectgroup-input" >
															<span class="selectgroup-button">Business</span>
														</label>
														<label class="selectgroup-item">
															<input type="radio" name="account_type" checked value="2" class="selectgroup-input">
															<span class="selectgroup-button">Individual</span>
														</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Name</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg is-valid state-valid "
                                                                   placeholder="Full Name" name="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Username</label>
                                                        <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg is-valid state-valid"
                                                               placeholder="Username" name="username" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg is-valid state-valid"
                                                               placeholder="Enter Email" name="email" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Phone</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control form-control-lg is-valid state-valid"
                                                                   placeholder="Enter mobile Phone" name="phone" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Account Currency</label>
                                                        <div class="input-group">
                                                            <select class="form-control form-control-lg is-valid state-valid"
                                                                   name="currency" required>
                                                                <option value="">Select Account Currency</option>
                                                                @foreach($currencies as $currency)
                                                                    <option value="{{$currency->code}}">{{$currency->currency}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Password</label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control form-control-lg is-valid state-valid"
                                                                   placeholder="Password" name="password" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Password Confirmation</label>
                                                            <div class="input-group">
                                                            <input type="password" class="form-control form-control-lg is-valid state-valid"
                                                                   placeholder="Confirm Password" name="confirm_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Referral (optional)</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg is-valid state-valid"
                                                                   placeholder="Referral" name="referral" value="{{$ref}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input is-valid state-valid" required />
                                                            <span class="custom-control-label ">Agree to the <a href="{{url('terms')}}" class="btn-link">
                                                                    Terms and privacy policy</a></span>
                                                        </label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-lg btn-primary btn-block px-4" id="submit">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Create a new account
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
											</div>
										</div>
									</div>
									<div class="text-center pt-4">
										<div class="font-weight-normal fs-16 text-white">You Already have an account
                                            <a class="btn-link font-weight-bolder text-red" href="{{url('login')}}">Login Here</a>
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

		<!-- Circle-progress js-->
		<script src="{{asset('dashboard/public/assets/js/vendors/circle-progress.min.js')}}"></script>

		<!-- Jquery-rating js-->
		<script src="{{asset('dashboard/public/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
        @include('dashboard.noti_js')
        <script src="{{asset('dashboard/authentication.js')}}"></script>
	</body>
</html>
