@php
    use App\Helper\JWTToken;
    $token = Cookie::get('token');
    $user = JWTToken::ReadToken($token);
@endphp
<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>123-456-7890</span></li>
                            <li><i class="ti-email"></i><span>info@TechTrove.com</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">
                            <li><a href="/policy?type=about">About Us</a></li>

                            @if ($token !== null && $user !== null)
                                <li><a href="{{ url('/profile') }}"> <i class="linearicons-user"></i> Account</a></li>
                                <li><a class="btn btn-danger btn-sm" href="{{ url('/logout') }}"> Logout</a></li>
                                @if (isset($user->role) && $user->role === 'admin')
                                    <li><a class="btn btn-danger btn-sm" href="{{ url('/Dashboard') }}"> Dashboard</a></li>
                                @endif
                            @else
                                <li><a class="btn btn-danger btn-sm" href="{{ url('/login') }}">Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- <img class="logo_dark" src="assets/images/logo_dark.png" alt="logo" /> --}}
                    <h2>TechTrove</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a class="nav-link nav_item" href="{{ url('/') }}">Home</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Categories</a>
                            <div class="dropdown-menu">
                                <ul id="CategoryItem">
                                    <!-- Categories will be populated here -->
                                </ul>
                            </div>
                        </li>

                        <li><a class="nav-link nav_item" id="wishLink" href="#"><i class="ti-heart"></i> Wish</a></li>
                        <li><a class="nav-link nav_item" id="cartLink" href="#"><i class="linearicons-cart"></i> Cart</a></li>
                        <li><a class="nav-link nav_item" id="orderLink" href="#"><i class="ti-archive fs-7"></i> Orders</a></li>
                            <div class="search_wrap">
                                <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                                <form>
                                    <input type="text" placeholder="Search" class="form-control" id="search_input">
                                    <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div>
                            <div class="search_overlay"></div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Category();
    });

    async function Category() {
        let res = await axios.get("/CategoryList");
        $("#CategoryItem").empty();
        res.data['data'].forEach((item, i) => {
            let EachItem = `<li><a class="dropdown-item nav-link nav_item" href="/by-category?id=${item['id']}">${item['categoryName']}</a></li>`;
            $("#CategoryItem").append(EachItem);
        });
    }
</script>
<script>
    // Copy of existing category logic for mobile
    async function loadMobileCategories() {
        let res = await axios.get("/CategoryList");
        $("#MobileCategoryList").empty();
        res.data['data'].forEach((item) => {
            let listItem = `<li><a class="dropdown-item" href="/by-category?id=${item['id']}">${item['categoryName']}</a></li>`;
            $("#MobileCategoryList").append(listItem);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadMobileCategories();

        const isLoggedIn = @json($token !== null && $user !== null);

        document.getElementById('mobileWish').addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = isLoggedIn ? "/wish" : "/login";
        });
        document.getElementById('mobileCart').addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = isLoggedIn ? "/cart" : "/login";
        });
        document.getElementById('mobileOrders').addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = isLoggedIn ? "/track-order" : "/login";
        });
    });
</script>

<script>
    const isLoggedIn = @json($token !== null && $user !== null);

    document.getElementById('wishLink').addEventListener('click', function (e) {
        e.preventDefault();
        if (!isLoggedIn) {
            window.location.href = "/login";
        } else {
            window.location.href = "/wish";
        }
    });

    document.getElementById('cartLink').addEventListener('click', function (e) {
        e.preventDefault();
        if (!isLoggedIn) {
            window.location.href = "/login";
        } else {
            window.location.href = "/cart";
        }
    });

    document.getElementById('orderLink').addEventListener('click', function (e) {
        e.preventDefault();
        if (!isLoggedIn) {
            window.location.href = "/login";
        } else {
            window.location.href = "/track-order";
        }
    });
</script>



