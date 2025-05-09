<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>TechTrove - eCommerce</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            .chart-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .chart-container canvas {
                max-width: 70%;
                max-height: 70%;
            }
            .additional-info {
            font-size: 1.2em; /* Increase the font size */
            padding-bottom: 20px; /* Add some space below the info */
            text-align: center; /* Center the text */
        }
        </style>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset ('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote.min.css') }}">
		<link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}">
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
							<img src="{{  asset('admin-assets/img/avatar5.png')}}" class='img-circle elevation-2' width="40" height="40" alt="">
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
							<h4 class="h4 mb-0"><strong>Admin</strong></h4>
							<div class="mb-3">tashib02c@gmail.com</div>

							<div class="dropdown-divider"></div>

							<div class="dropdown-divider"></div>
							<a href="{{url("/logout")}}" class="dropdown-item text-danger">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout
							</a>
						</div>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->
            <div class="preloader">
                <div class="lds-ellipsis">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

			<!-- Main Sidebar Container -->
		  @include('admin.layouts.sidebar')
			<!-- Content Wrapper. Contains page content -->

			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				{{-- <section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Dashboard</h1>
							</div>
							<div class="col-sm-6">

							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4 col-6">
								<div class="small-box card">
									<div class="inner">
										<h3>150</h3>
										<p>Total Orders</p>
									</div>
									<div class="icon">
										<i class="ion ion-bag"></i>
									</div>
									<a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<div class="col-lg-4 col-6">
								<div class="small-box card">
									<div class="inner">
										<h3>50</h3>
										<p>Total Customers</p>
									</div>
									<div class="icon">
										<i class="ion ion-stats-bars"></i>
									</div>
									<a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<div class="col-lg-4 col-6">
								<div class="small-box card">
									<div class="inner">
										<h3>$1000</h3>
										<p>Total Sale</p>
									</div>
									<div class="icon">
										<i class="ion ion-person-add"></i>
									</div>
									<a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card -->
				</section> --}}
				<!-- /.content -->

                @yield('content')
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">

				<strong>Copyright &copy; 2024 TechTrove All rights reserved.
			</footer>

		</div>

		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>

        <script src="{{ asset('admin-assets/plugins/summernote/summernote.min.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{  asset('admin-assets/js/demo.js') }}"></script>


        @yield('pie')



	</body>

</html>

