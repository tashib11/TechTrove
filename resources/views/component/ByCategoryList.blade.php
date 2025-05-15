<style>
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
  }

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

  .offcanvas-body {
    -webkit-overflow-scrolling: touch;
  }
</style>
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center text-md-start">
                <h3 class="h4 mb-0">Category</h3>
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

  <!-- Offcanvas Filter Panel -->
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

    <div class="row mb-3">
  <div class="col-md-4">
    <select id="filter-category" class="form-control">
      <option value="">All Categories</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
          {{ $cat->categoryName }}
        </option>

      @endforeach
    </select>
  </div>

  {{-- Add other filters like brand, price etc. here as needed --}}
</div>



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

  <!-- Loading Spinner -->
  <div id="loading-spinner" class="text-center my-4 d-none">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <!-- Product Display Area -->


<div class="row" id="product-content">
    @include('component.product-list', ['products' => $products])
</div>
</div>

<script>
  let currentCategory = 'Popular';

  // Tab switching
  document.querySelectorAll('#productTab .nav-link').forEach(tab => {
    tab.addEventListener('click', function (e) {
      e.preventDefault();
      const selectedCategory = this.getAttribute('data-category');
      if (currentCategory !== selectedCategory) {
        document.querySelector('#productTab .active').classList.remove('active');
        this.classList.add('active');
        currentCategory = selectedCategory;

        setTimeout(() => {
          document.getElementById('loading-spinner').classList.remove('d-none');
          fetchProducts();
        }, 50);
      }
    });
  });

  // Search input listener
  document.getElementById('search-input').addEventListener('input', fetchProducts);

  // Apply filters
  document.getElementById('apply-filters').addEventListener('click', function () {
    fetchProducts();
    let filterOffcanvasEl = document.getElementById('filterOffcanvas');
    let filterOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvasEl) || new bootstrap.Offcanvas(filterOffcanvasEl);
    filterOffcanvas.hide();
  });

  // Reset filters
  document.getElementById('reset-filters').addEventListener('click', function () {
    document.getElementById('filter-price-min').value = '';
    document.getElementById('filter-price-max').value = '';
    document.getElementById('filter-brand').value = '';
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-star').value = '';
    document.getElementById('search-input').value = '';
    document.getElementById('sort-price').value = '';

    fetchProducts();
    let filterOffcanvasEl = document.getElementById('filterOffcanvas');
    let filterOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvasEl) || new bootstrap.Offcanvas(filterOffcanvasEl);
    filterOffcanvas.hide();
  });

  // Sort change
  document.getElementById('sort-price').addEventListener('change', fetchProducts);

  // Product fetch logic
  function fetchProducts() {
    const loading = document.getElementById('loading-spinner');
    loading.classList.remove('d-none');

    const sortValue = document.getElementById('sort-price').value;

    if (sortValue === 'reset') {
      document.getElementById('filter-price-min').value = '';
      document.getElementById('filter-price-max').value = '';
      document.getElementById('filter-brand').value = '';
      document.getElementById('filter-category').value = '';
      document.getElementById('filter-star').value = '';
      document.getElementById('search-input').value = '';
      document.getElementById('sort-price').value = '';
      fetchProducts(); return;
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

  // Load filter dropdowns
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

  // Initial run
  loadFilters();
//   fetchProducts();
</script>
