<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Shopo :: اللوحة الإدارية</title>
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
			<div class="card card-outline card-info">
			  	<div class="card-header text-center">
					<a href="#" class="h3">إعادة تعيين كلمة المرور</a>
			  	</div>
			  	<div class="card-body">
					<p class="login-box-msg">أدخل كلمة المرور الجديدة وقم بتأكيدها</p>
					{{-- @if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif --}}
					<form method="POST" id="resetForm" action="{{ route('admin.resetPassword') }}">
						@csrf

						<input type="hidden" name="token" value="{{ $token }}">
						<input type="hidden" name="email" value="{{ $email }}">

						<div class="input-group mb-3">
							{{-- <label>New Password</label> --}}
							<input type="password" name="password" id="password" class="form-control" placeholder="New Password" required>
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-unlock"></span>
					  			</div>
							</div>
						</div>

						<div class="input-group mb-3">
							{{-- <label>Confirm Password</label> --}}
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-lock"></span>
					  			</div>
							</div>
						</div>

						<button type="submit" class="btn btn-outline-info w-100">إعادة تعيين كلمة المرور</button>
					</form>
		  			<p class="mb-1 mt-3">
				  		<a href="{{ route('admin.login') }}">تسجيل الدخول</a>
					</p>					
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		{{-- <script src="{{ asset('admin-assets/js/demo.js') }}"></script> --}}
		<script>
			$(document).ready(function() {
				$("#resetForm").submit(function(event) {
					event.preventDefault();
					var formData = $(this).serialize();
					const button = $(this).find('button[type="submit"]');

					button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>إعادة الضبط...');

					$.ajax({
						url: "{{ route('admin.resetPassword') }}",
						type: "POST",
						data: formData,
						dataType: "json",
						success: function(response) {
							handleResponse(response);
						},
						error: function(xhr) {
							// Try to parse JSON even on error
							let response;
							try {
								response = JSON.parse(xhr.responseText);
							} catch (e) {
								showAlert('danger', 'Unexpected server error. Please try again.');
								return;
							}
							handleResponse(response);
						},
						complete: function() {
							button.prop('disabled', false).html('إعادة تعيين كلمة المرور');
						}
					});

					function handleResponse(response) {
						// ✅ Success
						if (response.status === true) {
							window.location.href = "{{ route('admin.login') }}?reset=success";
						}
						// ⚠️ Validation errors
						else if (response.errors) {
							showValidationErrors(response.errors);
						}
						// ⚠️ Single message (like invalid token or expired)
						else if (response.message) {
							showAlert('danger', response.message);
						}
						// ❌ Unexpected
						else {
							showAlert('danger', 'Something went wrong. Please try again.');
						}
					}

					function showValidationErrors(errors) {
						// Clear old errors
						$('.is-invalid').removeClass('is-invalid');
						$('.invalid-feedback').remove();

						// Loop and show each error
						for (const field in errors) {
							const input = $(`[name="${field}"]`);
							input.addClass('is-invalid');
							input.after(`<p class="invalid-feedback d-block">${errors[field][0]}</p>`);
						}
					}

					function showAlert(type, message) {
						// Remove old alert
						$('.alert').remove();

						const alertHtml = `
							<div class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
								<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'}"></i>
								${message}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						`;
						$('.card-body').prepend(alertHtml);

						// Auto close after 5 seconds
						setTimeout(() => $('.alert').alert('close'), 5000);
					}
				});
			});
		</script>

	</body>
</html>