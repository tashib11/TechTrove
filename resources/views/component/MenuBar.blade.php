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
                            {{-- <div class="search_wrap">
                                <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                                <form>
                                    <input type="text" placeholder="Search" class="form-control" id="search_input">
                                    <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div>
                            <div class="search_overlay"></div> --}}
                        {{-- </li> --}}
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<script>


    async function Category() {
        let cached= localStorage.getItem("categories");
        let category_time=parseInt(localStorage.getItem("category_time"));
        let nowDate= Date.now();

        let expiryLimit=1800000;//30minutes =1800000ms

        if(cached && nowDate-category_time<expiryLimit){
            renderCategories(JSON.parse(cached));
        }
        else{
            try{
                 let res = await axios.get("/CategoryList");
                let data= res.data['data'];
                localStorage.setItem("categories", JSON.stringify(data));
                localStorage.setItem("category_time", nowDate);// automatically numeric convert into string in localStorage
                renderCategories(data);
            }catch(err){
                 console.error("Category menu fetch failed", err);
             }
        }
    }

     const renderCategories=(data)=>{
         $("#CategoryItem").empty();
               let EachItem="";
         data.forEach((item, i) => {
                  EachItem += `<li><a class="dropdown-item nav-link nav_item" href="/by-category?id=${item['id']}">${item['categoryName']}</a></li>`;
                 });
        // $("#CategoryItem").html(EachItem);// html function checks unnecessarily everything like empty() or not etc so time consuming
        document.querySelector("#CategoryItem").insertAdjacentHTML( 'beforeend', EachItem);// insertAdjacentHTML() is in native js not jquery, so
       };
</script>
<script>


    document.addEventListener('DOMContentLoaded', function () {
        // loadMobileCategories();

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



