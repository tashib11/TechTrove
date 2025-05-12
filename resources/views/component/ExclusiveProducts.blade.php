<style>
@media (max-width: 576px) {
  #filterOffcanvas {
    width: 85% !important; /* More space on small screen */
  }

  #filterOffcanvas .offcanvas-body {
    max-height: calc(100vh - 120px); /* Leaves space for header/close */
    overflow-y: auto;
    padding-bottom: 80px; /* Ensure space for buttons at bottom */
  }

  #filterOffcanvas .btn {
    position: sticky;
    bottom: 10px;
    z-index: 5;
  }
}

/* Unified styling for top bar (search/filter/sort) */
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

/* Fix iOS overscroll on offcanvas */
.offcanvas-body {
  -webkit-overflow-scrolling: touch;
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
        <div class="col-12">
            <div class="top-bar">
                <!-- Left Side: Search + Filter -->
              <div class="row mb-3">
  <div class="col-12">
    <div class="top-bar d-flex flex-column flex-md-row justify-content-between align-items-stretch gap-2">

      <!-- Left Side: Search + Filter in one input group -->
      <div class="input-group flex-grow-1">
        <input type="text" id="search-input" class="form-control" placeholder="Search by Title">
        <button class="btn btn-warning d-flex align-items-center gap-1 px-3" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
          <i class="bi bi-funnel-fill"></i> Filter
        </button>
      </div>

      <!-- Right Side: Sort -->
      <div class="flex-shrink-0">
       <select id="sort-price" class="form-select">

  <option value="latest">Latest</option>
  <option value="asc">Price: Low to High</option>
  <option value="desc">Price: High to Low</option>
  <option value="reset">Reset</option>
</select>

      </div>
    </div>
  </div>
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
