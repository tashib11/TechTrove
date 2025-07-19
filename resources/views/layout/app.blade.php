<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="TechTrove" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TechTrove is a modern Laravel-based eCommerce platform.">
    <meta name="keywords" content="ecommerce, laravel, electronics, fashion, store, bootstrap, shopping">

    <title>TechTrove - eCommerce</title>




    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Preload Critical Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet">
    </noscript>

    <!-- Minimal Inline Critical CSS (can expand if needed) -->


    <style>
        /* Inside <style> tag in layout.app */

        .mobile-bottom-nav small {
            font-size: 12px;
        }

        .mobile-bottom-nav .nav-item {
            width: 20%;
            font-size: 11px;
        }

        .mobile-bottom-nav i {
            font-size: 18px;
            line-height: 1;
        }
    </style>
    <!-- Inside <head> in layout.app -->
    @stack('hero')
    @stack('p_details')

    <!-- Full CSS Loaded Deferred (except Bootstrap) -->
    <!-- Bootstrap CSS -->
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    </noscript>

    <link rel="preload" as="style"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    </noscript>

    <!-- Always load -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    {{-- <link rel="preload" as="style" href="{{ asset('assets/css/style.css') }}" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"></noscript> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="print" onload="this.media='all'">
    <!-- Load extra CSS only if NOT home page -->
    {{-- @if (!request()->is('/'))
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}" media="print"
            onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}" media="print"
            onload="this.media='all'">
    @endif --}}
{{--
<script  src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script  src="{{ asset('assets/js/axios.min.js') }}"></script> --}}

</head>

<body>

    <!-- Toast Notification Container -->
    <div id="toast-container" aria-live="polite" aria-atomic="true"
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>




    <!-- Main Content with padding to offset fixed header -->
    <div>
        <!-- Main Content -->
        @yield('content')

    </div>
<script>
function showToast(message, type = 'success') {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.setAttribute('aria-live', 'polite');
            toastContainer.setAttribute('aria-atomic', 'true');
            toastContainer.style.position = 'fixed';
            toastContainer.style.top = '20px';
            toastContainer.style.right = '20px';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
        <div class="toast-header ${type === 'success' ? 'bg-success text-white' : 'bg-danger text-white'}">
            <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
            <small class="text-light">Just now</small>
            <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
     `;

        // Append and show
        toastContainer.appendChild(toast);

        // Initialize and show the toast using Bootstrap's native API
        const bsToast = new bootstrap.Toast(toast, {
            delay: 2000
        });
        bsToast.show();

        // Remove the toast from DOM after hidden
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
</script>

    <!-- Mobile Bottom Navigation (optional) -->
    {{--
    <nav class="mobile-bottom-nav d-md-none bg-white shadow-lg border-top fixed-bottom">
        <div class="d-flex justify-content-around text-center py-2">
            <a href="/" class="nav-item text-dark">
                <i class="ti-home fs-5"></i><br><small>Home</small>
            </a>
            <a href="/wish" id="mobileWish" class="nav-item text-dark">
                <i class="ti-heart fs-5"></i><br><small>Wish</small>
            </a>
            <a href="/cart" id="mobileCart" class="nav-item text-dark">
                <i class="linearicons-cart fs-5"></i><br><small>Cart</small>
            </a>
            <a href="/user-orders" id="mobileOrders" class="nav-item text-dark">
                <i class="ti-archive fs-5"></i><br><small>Orders</small>
            </a>
            <div class="dropup">
                <a class="nav-item text-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti-menu fs-5"></i><br><small>Categories</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-start" id="MobileCategoryList"></ul>
            </div>
        </div>
    </nav>
    --}}
    <!-- Scripts (All Deferred) -->

    <script defer src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/scripts.js') }}"></script>
    <script defer src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>
