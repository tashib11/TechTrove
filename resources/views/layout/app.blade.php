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
        .mobile-bottom-nav {
            height: 60px;
            font-size: 13px;
        }

        .mobile-bottom-nav .nav-item {
            padding: 4px 0;
            flex: 1;
            text-align: center;
        }

        .mobile-bottom-nav i {
            font-size: 18px;
            display: block;
        }

        .mobile-bottom-nav small {
            display: block;
            font-size: 11px;
            line-height: 1.2;
            margin-top: 2px;
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

    <!-- Load style.css: deferred on homepage, normal on other pages -->
@if (request()->is('/'))
    <!-- Homepage: defer for faster FCP -->
    <link rel="preload" as="style" href="{{ asset('assets/css/style.css') }}" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"></noscript>
@else
    <!-- Other pages: load normally -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endif

{{-- <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="print" onload="this.media='all'"> --}}
    <!-- Always load -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
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

        <!-- Mobile Bottom Navigation (optional) -->

        <nav class="mobile-bottom-nav d-md-none bg-white shadow-lg border-top fixed-bottom">
            <div class="d-flex justify-content-around text-center py-1">
                <a href="/" class="nav-item flex-fill text-dark">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-house fs-5"></i>
                        <small>Home</small>
                    </div>
                </a>
                <button id="wishLink" class="nav-item flex-fill text-dark bg-transparent border-0">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-heart fs-5"></i>
                        <small>Wish</small>
                    </div>
                </button>
                <button id="cartLink" class="nav-item flex-fill text-dark bg-transparent border-0">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-cart fs-5"></i>
                        <small>Cart</small>
                    </div>
                </button>
                <button id="orderLink" class="nav-item flex-fill text-dark bg-transparent border-0">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-box-seam fs-5"></i>
                        <small>Orders</small>
                    </div>
                </button>
            </div>
        </nav>

    </div>
    <script>
        document.querySelector('#wishLink').addEventListener('click', (e) => {
            console.log("Wish link clicked");

            e.preventDefault();
            fetch('/wish') // it expects json so in the controller return view is not triggered as html page
                .then(res => {
                    if (res.status === 401) {
                        sessionStorage.setItem("last_location", window.location.href);
                        window.location.href = "/login";
                    } else {
                        window.location.href = "/wish";
                    }
                })
                .catch(err => {
                    console.error("Wish fetch failed", err);
                });
        });

        document.querySelector('#cartLink').addEventListener('click', (e) => {
            e.preventDefault();
            fetch('/cart') // it expects json so in the controller return view is not triggered as html page
                .then(res => {
                    if (res.status === 401) {
                        sessionStorage.setItem("last_location", window.location.href);
                        window.location.href = "/login";
                    } else {
                        window.location.href = "/cart";
                    }
                })
                .catch(err => {
                    console.error("Cart fetch failed", err);
                });
        });

        document.querySelector('#orderLink').addEventListener('click', async (e) => {
            let res = await fetch('/track-order');
            if (res.status === 401) {
                sessionStorage.setItem("last_location", window.location.href);
                window.location.href = "/login";
            } else {
                window.location.href = "/track-order";
            }
        });

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
