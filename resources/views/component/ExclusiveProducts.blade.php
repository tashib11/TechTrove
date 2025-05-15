<style>
/* Offcanvas adjustments for mobile */
@media (max-width: 576px) {
  #filterOffcanvas {
    width: 60% !important;
  }

  #filterOffcanvas .offcanvas-body {
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    padding-bottom: 80px;
  }

  #filterOffcanvas .btn {
    position: sticky;
    bottom: 10px;
    z-index: 5;
  }

  .product_img {
    padding-top: 120%; /* Better aspect on mobile */
  }
}

/* Unified top bar layout */
.top-bar {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

@media (min-width: 576px) {
  .top-bar {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
}

/* Offcanvas iOS fix */
.offcanvas-body {
  -webkit-overflow-scrolling: touch;
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


<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 text-center">
            <h2>Exclusive Products</h2>
        </div>
    </div>

    <!-- Search + Filter + Sort Row -->
    <div class="row mb-3">
      <div class="container my-4">
  <div class="row g-2">
    <div class="col-12 col-md-6 col-lg-4">
        <input type="text" id="search-input" class="form-control" placeholder="Search product...">
    </div>
    <div class="col-6 col-md-3 col-lg-2">
        <select id="sort-price" class="form-select w-100">
           <option value="latest">Latest</option>
            <option value="asc">Price: Low to High</option>
            <option value="desc">Price: High to Low</option>
            <option value="reset">Reset</option>
        </select>
    </div>
    <div class="col-6 col-md-3 col-lg-2">
        <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
            <i class="fas fa-filter me-1"></i> Filters
        </button>
    </div>
</div>
</div>

    <!-- Filter Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
    <div class="offcanvas-header">
        <h5>Filter Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body overflow-auto">
        <label>Price Range</label>
        <div class="input-group mb-2">
            <input type="number" id="filter-price-min" class="form-control" placeholder="Min">
            <input type="number" id="filter-price-max" class="form-control" placeholder="Max">
        </div>

        <label>Brand</label>
        <select id="filter-brand" class="form-control mb-3">
            <option value="">All</option>
        </select>

        <label>Category</label>
        <select id="filter-category" class="form-control mb-3">
            <option value="">All</option>
        </select>

        <label>Minimum Star Rating</label>
        <select id="filter-star" class="form-control mb-3">
            <option value="">Any</option>
            <option value="20">1★ & up</option>
            <option value="40">2★ & up</option>
            <option value="60">3★ & up</option>
            <option value="80">4★ & up</option>
            <option value="100">5★</option>
        </select>

        <button class="btn btn-primary w-100" id="apply-filters">Apply Filters</button>
        <button class="btn btn-secondary w-100 mt-2" id="reset-filters">Reset Filters</button>
    </div>
</div>


    <!-- Tab Navigation -->
    <ul class="nav nav-tabs justify-content-center mb-3" id="productTab" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-category="Popular">Popular</button></li>
        <li class="nav-item"><button class="nav-link" data-category="New">New</button></li>
        <li class="nav-item"><button class="nav-link" data-category="Top">Top</button></li>
        <li class="nav-item"><button class="nav-link" data-category="Trending">Trending</button></li>
    </ul>

    <!-- Product Results -->
    <div id="loading-spinner" class="text-center my-4 d-none">
        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>

    <div class="row" id="product-content"></div>
</div>
<!-- Bootstrap JS -->

<script>
    let currentCategory = 'Popular';

    // Handle category tab clicks
  document.querySelectorAll('#productTab .nav-link').forEach(tab => {
   tab.addEventListener('click', function (e) {
    e.preventDefault();
    const selectedCategory = this.getAttribute('data-category');
    if (currentCategory !== selectedCategory) {
        document.querySelector('#productTab .active').classList.remove('active');
        this.classList.add('active');
        currentCategory = selectedCategory;

        //  ADD small delay here to ensure UI fully updates
      setTimeout(() => {
    document.getElementById('loading-spinner').classList.remove('d-none');
    fetchProducts();
}, 50);

    }
});
    });



    // Handle search input and apply filter button
    document.getElementById('search-input').addEventListener('input', fetchProducts);
  document.getElementById('apply-filters').addEventListener('click', function () {
    fetchProducts();

    // Close the offcanvas
   let filterOffcanvasEl = document.getElementById('filterOffcanvas');
let filterOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvasEl) || new bootstrap.Offcanvas(filterOffcanvasEl);
filterOffcanvas.hide();

});


    // Handle reset filters button
  document.getElementById('reset-filters').addEventListener('click', function () {
    // Clear all filter inputs
    document.getElementById('filter-price-min').value = '';
    document.getElementById('filter-price-max').value = '';
    document.getElementById('filter-brand').value = '';
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-star').value = '';
    document.getElementById('search-input').value = '';
    document.getElementById('sort-price').value = '';

    fetchProducts();

    // Close the offcanvas
   let filterOffcanvasEl = document.getElementById('filterOffcanvas');
let filterOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvasEl) || new bootstrap.Offcanvas(filterOffcanvasEl);
filterOffcanvas.hide();

});


    // Fetch products with current filters
function fetchProducts() {
    const loading = document.getElementById('loading-spinner');
    loading.classList.remove('d-none');

    const sortValue = document.getElementById('sort-price').value;

    // Reset filters if sort is 'reset'
    if (sortValue === 'reset') {
        document.getElementById('filter-price-min').value = '';
        document.getElementById('filter-price-max').value = '';
        document.getElementById('filter-brand').value = '';
        document.getElementById('filter-category').value = '';
        document.getElementById('filter-star').value = '';
        document.getElementById('search-input').value = '';
        document.getElementById('sort-price').value = '';

        // After reset, re-fetch with default settings
        fetchProducts();
        return;
    }

    const search = document.getElementById('search-input').value;
    const priceMin = document.getElementById('filter-price-min').value;
    const priceMax = document.getElementById('filter-price-max').value;
    const brand = document.getElementById('filter-brand').value;
    const category = document.getElementById('filter-category').value;
    const star = document.getElementById('filter-star').value;

    axios.get('/product-filter', {
        params: {
            remark: currentCategory.toLowerCase(),
            search,
            price_min: priceMin,
            price_max: priceMax,
            brand,
            star,
            dynamic_category: category,
            sort: sortValue
        }
    }).then(res => {
        document.getElementById('product-content').innerHTML = res.data;
    }).finally(() => {
        loading.classList.add('d-none');
    });
}


// Trigger on sort change
document.getElementById('sort-price').addEventListener('change', fetchProducts);


    // Load brand/category filter options
    function loadFilters() {
        axios.get('/api/product-filters').then(res => {
            const { brands, categories } = res.data;
            const brandSelect = document.getElementById('filter-brand');
            const categorySelect = document.getElementById('filter-category');

            brands.forEach(brand => {
                brandSelect.innerHTML += `<option value="${brand.id}">${brand.brandName}</option>`;
            });

            categories.forEach(cat => {
                categorySelect.innerHTML += `<option value="${cat.id}">${cat.categoryName}</option>`;
            });
        });
    }

    // Initial loading
    loadFilters();
    fetchProducts();
</script>
