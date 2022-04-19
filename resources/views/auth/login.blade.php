<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | {{ env('APP_NAME') }}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href=" {{ asset ('vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset ('vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset ('vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset ('css/main.css') }}">
<!--===============================================================================================-->
<style>
	.btn-login100-form-btn {
		background-color: #2c5364 !important;
		border: #2c5364 solid 1px !important;
	}

</style>
</head>
<body style="background-color: #666666;">



	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
          <form action="{{ url('/login') }}" method="post" class="login100-form validate-form" autocomplete="off">
            @csrf
					<span class="login100-form-title p-b-43">
						Login | {{ env('APP_NAME') }}
					</span>
				
	
					<div class="validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" autocomplete="off" type="email" name="email">
						@error('email')
						<span class="error invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<br />
					
					<div class="validate-input" data-validate="Password is required">
						<input class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password" type="password" name="password">
						@error('password')
						<span class="error invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<br />

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="{{ route('password.request') }}" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					
					<div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or <a href="{{ route('register') }}" class="btn btn-seconday btn-lg btn-block"  href="#!" role="button">Register new user</a>

						</span>
					</div>

				</form>

				<div class="login100-more" style="background-image: url('images/nrf_train.jpg');">
				</div>
			</div>
		</div>
	</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"
        integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>
