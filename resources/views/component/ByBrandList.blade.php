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



    @media (max-width: 576px) {
        .breadcrumb_section h1 {
            font-size: 1.25rem;
        }

        .offcanvas-body form .form-label {
            font-size: 0.9rem;
        }
    }

/* Product Card Layout */
.product {
  height: 100%;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
  transition: box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  background: #fff;
}

.product:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product_img {
  width: 100%;
  padding-top: 100%;
  position: relative;
  overflow: hidden;
  background: #f9f9f9;
}

.product_img img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Product content section */
.product_info {
  padding: 10px 15px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

/* Product title */
.product_title {
  font-size: 1rem; /* Default size */
  font-weight: 600;
  line-height: 1.3;
  min-height: 2.6em; /* enough space for 2 lines */
  overflow: hidden;
}

/* Price styling */
.product_price {
  font-size: 1rem;
  margin-top: 0;
}

.discount_price {
  color: #007bff;
  font-weight: bold;
}

del {
  color: #888;
  font-size: 0.9rem;
}



/* Stock status */
.stock-status {
  font-size: 0.8rem;
  color: #28a745;
}

.stock-status.out {
  color: #dc3545;
}
@media (max-width: 576px) {


  .rating_wrap {
    flex-direction: row;
    flex-wrap: wrap;
    gap: 4px;
    align-items: center;
  }

   .product_img {
    padding-top: 100%; /* Make image area much taller */
  }

  .product_info {
    padding: 8px 10px;
  }

  .product_title {
    font-size: 1.1rem;
    min-height: 2.1em;
  }

  .product_price {
    font-size: 0.95rem;
  }

  .stock-status {
    font-size: 0.75rem;
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
    let stock = parseInt(item['stock'] || '0');
    let stockStatus = stock > 0
        ? `<span class="text-success small">In Stock (${stock} available)</span>`
        : `<span class="text-danger small">Out of Stock</span>`;

    let EachItem = `
 <div class="col-lg-3 col-md-4 col-12">
        <div class="product">
            <div class="product_img">
                <a href="/details?id=${item['id']}">
                    <img src="${item['image']}" alt="product_img">
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
                <div class="rating_wrap mb-1">
                    <div class="rating">
                        <div class="product_rate" style="width:${item['star']}%"></div>
                    </div>
                </div>
                <div class="stock_status">${stockStatus}</div>
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




