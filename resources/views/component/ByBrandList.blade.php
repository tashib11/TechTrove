<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center text-md-start">
                <h1 class="h4 mb-0">Brand: <span id="BrandName"></span></h1>
            </div>
            <div class="col-12 col-md-6 text-center text-md-end mt-2 mt-md-0">
                <nav>
                    <ol class="breadcrumb justify-content-center justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a></li>
                        <li class="breadcrumb-item active">This Page</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Search + Filter Controls -->
<div class="container my-4">
  <div class="row g-2">
    <div class="col-12 col-md-6 col-lg-4">
        <input type="text" id="search" class="form-control" placeholder="Search product...">
    </div>
    <div class="col-6 col-md-3 col-lg-2">
        <select id="sort" class="form-select w-100">
            <option value="">Sort: Latest</option>
            <option value="asc">Price: Low → High</option>
            <option value="desc">Price: High → Low</option>
        </select>
    </div>
    <div class="col-6 col-md-3 col-lg-2">
        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas">
            <i class="fas fa-filter me-1"></i> Filters
        </button>
    </div>
</div>

</div>

<!-- Filter Canvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filter Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="filterForm">
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select id="category" class="form-select">
                    <option value="">All</option>
                    <!-- Dynamic options -->
                </select>
            </div>

            <div class="mb-3">
                <label for="remark" class="form-label">Remark</label>
                <select id="remark" class="form-select">
                    <option value="">All</option>
                    <option value="popular">Popular</option>
                    <option value="new">New</option>
                    <option value="top">Top</option>
                    <option value="trending">Trending</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="star" class="form-label">Minimum Rating</label>
                <select id="star" class="form-select">
                    <option value="">All</option>
                    <option value="20">1+</option>
                    <option value="40">2+</option>
                    <option value="60">3+</option>
                    <option value="80">4+</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Price Range</label>
                <div class="d-flex gap-2">
                    <input type="number" id="price_min" class="form-control" placeholder="Min">
                    <input type="number" id="price_max" class="form-control" placeholder="Max">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Apply Filter</button>
            <button type="button" id="resetFilters" class="btn btn-secondary w-100">Reset Filters</button>
        </form>
    </div>
</div>

<!-- Product Grid -->
<div class="container my-5">
    <div id="byBrandList" class="row g-4">
        <!-- Products injected here -->
    </div>
</div>

<style>

    @media (max-width: 576px) {
  .offcanvas-start {
    width: 60% !important;
  }
   .btn[data-bs-toggle="offcanvas"] {
    font-size: 0.9rem;
    padding: 0.5rem;
   }
}

    .product {
        border: 1px solid #eaeaea;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
        transition: box-shadow 0.3s ease;
    }

    .product:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .product_img img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 4px;
    }

    .product_title {
        font-size: 0.9rem;
        margin-top: 10px;
    }

    @media (max-width: 576px) {
        .breadcrumb_section h1 {
            font-size: 1.25rem;
        }

        .offcanvas-body form .form-label {
            font-size: 0.9rem;
        }
    }
</style>


<script>


   async function ByBrand() {
    let searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id');

    let res = await axios.get(`/ListProductByBrand/${id}`);
    $("#byBrandList").empty();

    const products = res.data['data'];

    // Set brand name even if there are no products
    if (products.length > 0) {
        $("#BrandName").text(products[0]['brand']['brandName']);
    } else {
   let brandRes = await axios.get(`/GetBrandById/${id}`);
$("#BrandName").text(brandRes.data.data.brandName); // ✅ Correct


    }

    if (products.length === 0) {
        $("#byBrandList").html(`
            <div class="col-12 text-center py-5">
                <h5>No products available of this brand.</h5>
            </div>
        `);
        return;
    }

    products.forEach((item) => {
        let EachItem = `
        <div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="#">
                        <img src="${item['image']}" alt="product_img9">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a href="/details?id=${item['id']}">${item['title']}</a></h6>
                    <div class="product_price">
                        <span class="price">$ ${item['price']}</span>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        $("#byBrandList").append(EachItem);
    });
}


</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    loadFilterDropdowns();
    ByBrand(); // Call initially
});

async function loadFilterDropdowns() {
    let res = await axios.get("/api/product-filters");
    let categories = res.data.categories;

    categories.forEach((cat) => {
        $("#category").append(`<option value="${cat.id}">${cat.categoryName}</option>`);
    });
}

$("#filterForm").on("submit", async function (e) {
    e.preventDefault();
    let searchParams = new URLSearchParams(window.location.search);
    let brandId = searchParams.get("id");

    let params = {
        brand: brandId,
        search: $("#search").val(),
        dynamic_category: $("#category").val(),
        star: $("#star").val(),
        price_min: $("#price_min").val(),
        price_max: $("#price_max").val(),
        remark: $("#remark").val(),
    };

    try {
        let res = await axios.get("/product-filter", { params });
        $("#byBrandList").html(res.data);
        $('#filterCanvas').offcanvas('hide'); // Hide filter drawer (Bootstrap 5)
    } catch (err) {
        console.error("Filter load error", err);
    }
});

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    loadFilterDropdowns();
    ByBrand(); // Load initial products

    // Attach dynamic search input handler
    $("#search").on("input", debounce(applyFilters, 500));
});

// Debounce to limit API calls
function debounce(func, delay) {
    let timeout;
    return function () {
        clearTimeout(timeout);
        timeout = setTimeout(func, delay);
    };
}

function applyFilters() {
    let searchParams = new URLSearchParams(window.location.search);
    let brandId = searchParams.get("id");

    let params = {
        brand: brandId,
        search: $("#search").val(),
        dynamic_category: $("#category").val(),
        star: $("#star").val(),
        price_min: $("#price_min").val(),
        price_max: $("#price_max").val(),
        sort: $("#sort").val(),
        remark: $("#remark").val(),
    };

    axios.get("/product-filter", { params })
        .then((res) => {
            $("#byBrandList").html(res.data);
        })
        .catch((err) => {
            console.error("Filter load error", err);
        });
}
$("#sort").on("change", applyFilters);
$("#resetFilters").on("click", function () {
    $("#search").val('');
    $("#category").val('');
    $("#star").val('');
    $("#price_min").val('');
    $("#price_max").val('');
    $("#sort").val('');
    $("#remark").val(''); // ✅ Add this
    applyFilters();
});


// On filter form submit
$("#filterForm").on("submit", function (e) {
    e.preventDefault();
    applyFilters();


    // Automatically close the filter drawer
    const canvasElement = document.getElementById('filterCanvas');
    const bsOffcanvas = bootstrap.Offcanvas.getInstance(canvasElement);
    bsOffcanvas.hide();
});
$("#resetFilters").on("click", function () {
  const canvasElement = document.getElementById('filterCanvas');
    const bsOffcanvas = bootstrap.Offcanvas.getInstance(canvasElement);
    bsOffcanvas.hide();
});
</script>




