<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<link rel="icon" type="image/png" href="<?php echo e(asset('')); ?>">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SHOPO :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo e(asset('admin-assets/plugins/fontawesome-free/css/all.min.css')); ?>">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo e(asset('admin-assets/css/adminlte.min.css')); ?>">
		
		<link rel="stylesheet" href="<?php echo e(asset('admin-assets/plugins/dropzone/min/dropzone.min.css')); ?>">

		<link rel="stylesheet" href="<?php echo e(asset('admin-assets/plugins/summernote/summernote.min.css')); ?>">

		<link rel="stylesheet" href="<?php echo e(asset('admin-assets/plugins/select2/css/select2.min.css')); ?>">

		<!-- Ionicons -->
    	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

		

		<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo e(asset('admin-assets/css/custom.css')); ?>">
		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	</head>
	<body class="hold-transition sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Right navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
					  	<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>					
				</ul>
				<div class="navbar-nav pl-2">
					<!-- <ol class="breadcrumb p-0 m-0 bg-white">
						<li class="breadcrumb-item active">Dashboard</li>
					</ol> -->
				</div>
				
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" data-widget="fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
							<img src="<?php echo e(asset('admin-assets/img/avatar5.png')); ?>" class='img-circle elevation-2' width="40" height="40" alt="">
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
							<h4 class="h4 mb-0"><strong><?php echo e(Auth::user()->name); ?></strong></h4>
							<div class="mb-3"><?php echo e(Auth::user()->email); ?></div>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-user-cog mr-2"></i> Settings								
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-lock mr-2"></i> Change Password
							</a>
							<div class="dropdown-divider"></div>
							<a href="<?php echo e(route('admin.logout')); ?>" class="dropdown-item text-danger">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout							
							</a>							
						</div>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->

			<?php echo $__env->make('admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">

				<?php echo $__env->yieldContent('content'); ?>

			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				
				<strong>Copyright &copy; <?php echo e(date('Y')+1); ?>-<?php echo e(date('Y')); ?> SHOPO. All rights reserved.
			</footer>
			
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="<?php echo e(asset('admin-assets/plugins/jquery/jquery.min.js')); ?>"></script>
		
		
		<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
		
		<!-- Bootstrap 4 -->
		<script src="<?php echo e(asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo e(asset('admin-assets/js/adminlte.min.js')); ?>"></script>

		<script src="<?php echo e(asset('admin-assets/plugins/dropzone/min/dropzone.min.js')); ?>"></script>

		<script src="<?php echo e(asset('admin-assets/plugins/summernote/summernote.min.js')); ?>"></script>

		<script src="<?php echo e(asset('admin-assets/plugins/select2/js/select2.min.js')); ?>"></script>

		<!-- AdminLTE for demo purposes -->
		<script src="<?php echo e(asset('admin-assets/js/demo.js')); ?>"></script>

		<!-- ChartJS 1.0.1 -->
	    <script src="../../plugins/chartjs/Chart.min.js"></script>


		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(document).ready(function(){
				$(".summernote").summernote({
					height: 250
				});
			});
		</script>

        <?php echo $__env->yieldContent('customJs'); ?>
	</body>
</html><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>