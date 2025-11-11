<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
		<link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<!-- /.login-logo -->
			{{-- @include('admin.message') --}}
			<div class="card card-outline card-warning">
			  	<div class="card-header text-center">
					<a  class="h3 on-hover text-warning">Forgot Password ?</a>
			  	</div>
			  	<div class="card-body">
					<p class="login-box-msg">enter your email to reset new password</p>
					{{-- @if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif --}}
					<form action="{{ route('admin.forgotPassword') }}" method="post">
						@csrf
				  		<div class="input-group mb-3">
							<input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-envelope"></span>
					  			</div>
							</div>
							@error('email')
								<p class="invalid-feedback" >{{ $message }}</p>
							@enderror
				  		</div>
				  		<div class="row">
							<div class="col-12">
					  			<button type="submit" class="btn btn-outline-warning btn-block">send Password reset link to email</button>
							</div>
				  		</div>
					</form>
		  			<p class="mb-1 mt-3">
				  		<a href="{{ route('admin.login') }}">Login</a>
					</p>					
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const form = document.querySelector('form');
		const button = form.querySelector('button[type="submit"]');
		const input = form.querySelector('input[name="email"]');

		form.addEventListener('submit', function(e) {
			e.preventDefault();

			// Remove old alerts
			document.querySelectorAll('.alert').forEach(el => el.remove());

			// Disable button and input during submission
			input.readOnly = true;
			button.disabled = true;
			button.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Sending...`;

			fetch(form.action, {
				method: 'POST',
				body: new FormData(form),
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				}
			})
			.then(res => res.json())
			.then(data => {
				
				if (data.status) {
					button.innerHTML = `Reset Link already sent to your Email, click the button in your email message to reset password`;
					// ✅ SUCCESS ALERT
					showAlert('success', `<i class="icon fas fa-check"></i> ${data.message}`);
					form.reset();
				} else if (data.errors) {
					// Inable button and input during submission
					input.readOnly = false;
					button.disabled = false;
					button.innerHTML = `Send Password Reset Link to Email`;
					// ⚠️ VALIDATION ERRORS
					let messages = '';
					for (const key in data.errors) {
						messages += `<li>${data.errors[key][0]}</li>`;
					}
					showAlert('danger', `<i class="icon fas fa-exclamation-triangle"></i> Please fix the following errors:<ul>${messages}</ul>`);
				} else {
					// ❌ GENERIC ERROR
					showAlert('danger', `<i class="icon fas fa-times"></i> Something went wrong. Please try again.`);
				}
			})
			.catch(() => {
				button.disabled = false;
				button.innerHTML = `Send Password Reset Link to Email`;
				showAlert('danger', `<i class="icon fas fa-wifi"></i> Network error. Please try again later.`);
			});

			function showAlert(type, message) {
				const alert = document.createElement('div');
				alert.className = `alert alert-${type} alert-dismissible fade show mt-3`;
				alert.innerHTML = `
					${message}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				`;
				form.insertAdjacentElement('beforebegin', alert);

				// Auto remove after 5 seconds
				setTimeout(() => {
					$(alert).alert('close');
				}, 5000);
			}
		});
	});
</script>


		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		{{-- <script src="{{ asset('admin-assets/js/demo.js') }}"></script> --}}
	</body>
</html>