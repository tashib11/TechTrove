@php
    use App\Helper\JWTToken;
    $token = Cookie::get('token');
    $user = JWTToken::ReadToken($token);
@endphp
<header class="header_wrap fixed-top "> {{--  header_with_topbar --}}
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="bi bi-phone"></i><span>123-456-7890</span></li>
                            <li><i class="bi bi-envelope"></i><span>info@TechTrove.com</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">

                            @if ($token !== null && $user !== null)
                                <li><a href="{{ url('/profile') }}"> <i class="bi bi-person fs-5"></i>Account</a></li>
                                <li><a class="btn  btn-fill-out btn-sm" href="{{ url('/logout') }}"> Logout</a></li>
                                @if (isset($user->role) && $user->role === 'admin')
                                    <li><a class="btn  btn-fill-out btn-sm" href="{{ url('/Dashboard') }}"> Dashboard</a>
                                    </li>
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
                    <span class="bi bi-list"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a class="nav-link nav_item" href="{{ url('/') }}">Home</a></li>
                        <li class="dropdown">
                            <a class="nav-link d-flex align-items-center gap-1" href="#"
                                data-bs-toggle="dropdown">
                                Categories
                                <i class="bi bi-caret-down-fill fs-7"></i>
                            </a>

                            <div class="dropdown-menu">
                                <ul id="CategoryItem">
                                    <!-- Categories will be populated here -->
                                </ul>
                            </div>
                        </li>

                        <li><button class="nav-link nav_item" id="wishLink" ><i class="bi bi-heart fs-7"></i>
                                Wish</button></li>
                        <li><button class="nav-link nav_item" id="cartLink" ><i class="bi bi-cart fs-7"></i>
                                Cart</button></li>
                        <li><button class="nav-link nav_item" id="orderLink"><i
                                    class="bi bi-box-seam fs-7"></i> Orders</button></li>
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
        let cached = localStorage.getItem("categories");
        let category_time = parseInt(localStorage.getItem("category_time"));
        let nowDate = Date.now();

        let expiryLimit = 1800000; //30minutes =1800000ms

        if (cached && nowDate - category_time < expiryLimit) {
            renderCategories(JSON.parse(cached));
        } else {
            try {
                let ress = await fetch("/CategoryList");
                let res = await ress.json();
                let data = res.data;
                renderCategories(data);
                localStorage.setItem("categories", JSON.stringify(data));
                localStorage.setItem("category_time",
                nowDate); // automatically numeric convert into string in localStorage
            } catch (err) {
                console.error("Category menu fetch failed", err);
            }
        }
    }

    const renderCategories = (data) => {
        const catDom = document.querySelector("#CategoryItem");
        catDom.innerHTML = ""; // Clear existing items
        const catFrag = document.createDocumentFragment(); // Create a document fragment for better performance
        data.forEach((item, i) => {
            let EachItem = document.createElement("li");
            EachItem.innerHTML =
                `<a class="dropdown-item nav-link nav_item" href="/by-category?id=${item['id']}">${item['categoryName']}</a>`;
            catFrag.appendChild(EachItem); // Append to fragment instead of directly to DOM
        });
        catDom.appendChild(catFrag); // Append the fragment to the DOM in one go
        // $("#CategoryItem").html(EachItem);// html function checks unnecessarily everything like empty() or not etc so time consuming
        // document.querySelector("#CategoryItem").insertAdjacentHTML('beforeend',
        // EachItem); // insertAdjacentHTML() is in native js not jquery, so
    };

    document.querySelector('#wishLink').addEventListener('click',(e)=>{
        e.preventDefault();
        fetch('/wish')// it expects json so in the controller return view is not triggered as html page
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

    document.querySelector('#cartLink').addEventListener('click',(e)=>{
        e.preventDefault();
        fetch('/cart')// it expects json so in the controller return view is not triggered as html page
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

    document.querySelector('#orderLink').addEventListener('click', async(e)=>{
        let res = await fetch('/track-order');
        if(res.status===401){
            sessionStorage.setItem("last_location",window.location.href);
            window.location.href="/login";
        }else{
            window.location.href="/track-order";
        }
    });
</script>



