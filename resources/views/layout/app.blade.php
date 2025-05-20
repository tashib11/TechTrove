<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website.">
    <meta name="keywords" content="ecommerce, electronics store, fashion store, furniture store, bootstrap, responsive, shopping">

    <title>TechTrove - eCommerce</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Icon Fonts and Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/axios.min.js')}}"></script>

    <!-- JS Dependencies (head) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- zoom feature script --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>

    {{-- <script src="{{ asset('assets/js/axios.min.js') }}"></script> --}}
    <!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    .mobile-bottom-nav i {
    line-height: 1;
}
.mobile-bottom-nav small {
    font-size: 12px;
}

</style>

</head>
<body>

<!-- Toast Container -->
<div id="toast-container" aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<!-- Preloader -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<!-- Page Content -->
<div>
    @yield('content')
</div>

<!-- Bottom Navigation for Mobile -->
<nav class="mobile-bottom-nav d-md-none bg-white shadow-lg border-top fixed-bottom">
    <div class="d-flex justify-content-around text-center py-2">
        <a href="/" class="nav-item text-dark">
            <i class="ti-home fs-5"></i><br><small>Home</small>
        </a>
        <a href="#" id="mobileWish" class="nav-item text-dark">
            <i class="ti-heart fs-5"></i><br><small>Wish</small>
        </a>
        <a href="#" id="mobileCart" class="nav-item text-dark">
            <i class="linearicons-cart fs-5"></i><br><small>Cart</small>
        </a>
        <a href="#" id="mobileOrders" class="nav-item text-dark">
            <i class="ti-archive fs-5"></i><br><small>Orders</small>
        </a>
        <div class="dropup">
            <a class="nav-item text-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti-menu fs-5"></i><br><small>Categories</small>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-start" id="MobileCategoryList">
                <!-- Dynamic categories -->
            </ul>
        </div>
    </div>
</nav>


<!-- JS Scripts -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93W8V3UElkoE3z+2xNyE+a7H2gAMbVdEv8d9cE2LfFhxH/Tjq7GV8t9FqJeI2y" crossorigin="anonymous"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
