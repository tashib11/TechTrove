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
            padding-top: 120%;
            /* Better aspect on mobile */
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

    .rating {
        position: relative;
        display: inline-block;
        line-height: 1;
        color: #e0e0e0;
        font-family: Arial, sans-serif;
    }

    .rating .star-bg,
    .rating .star-fill {
        font-size: 20px;

        display: inline;
        padding: 0;
        margin: 0;
        border: none;
        background: none;
        box-shadow: none;
        line-height: 1;
        vertical-align: middle;
        outline: none;
    }

    .rating .star-fill {
        color: #F6BC3E;
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        width: 0;
        pointer-events: none;
        outline: none;
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
        aspect-ratio: 1 / 1;
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

    .prod-img {
        width: 100%;
        height: 130px;
        object-fit: cover;
        filter: blur(10px);
        transition: filter 0.4s ease, transform 0.3s ease, opacity 0.3s ease;
        opacity: 0.7;
    }

    .prod-img.loaded {
        filter: blur(0);
        opacity: 1;

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
        font-size: 1rem;
        /* Default size */
        font-weight: 600;
        line-height: 1.3;
        min-height: 2.6em;
        /* enough space for 2 lines */
        overflow: hidden;
    }

    /* Price styling */
    .product_price {
        font-size: 1.1rem;
        margin-top: 0;
        font-weight: bold;
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
        font-weight: bold;
    }

    .stock-status.out {
        color: #28a745;
    }

    @media (max-width: 576px) {


        .rating_wrap {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }

        .product_img {
            /* padding-top: 100%; */
            aspect-ratio: 1 / 1;
            /* Make image area much taller */
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


    /* Remove up/down arrows for number inputs in all browsers */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    a.product-link {
        text-decoration: none;
        /* color: inherit; */
        display: block; //By default, <a> is inline, so display: block ensures the link stretches over the entire card
    }
</style>


<div class="container">

    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <h1 class="h4 mb-0">Category: <span id="categoryName"> {{ $categoryName }} </span></h1>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <nav>
                        <ol class="breadcrumb justify-content-center justify-content-md-end mb-0">
                            <li class=""><a href="{{ url('/') }}">Home</a></li>/
                            <li class=" active">This Page</li>
                        </ol>
                    </nav>
                </div>
            </div>
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
                    <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas">
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
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="row" id="product-content">
            @if ($initialProducts->isEmpty())
                <div class="col-12 text-center mb-4 mt-2">
                    <h4 style="color: #007bff">No Product found, Look into other section</h4>
                </div>
            @else
                @foreach ($initialProducts as $product)
                    @include('component.product-list', ['product' => $product])
                @endforeach
            @endif
        </div>


        <div class="text-center">
            <button id="load-more-btn" class="btn btn-outline-primary">Load More</button>
        </div>

    </div>

    <script>
        // Get the category ID from the URL
        let searchParams = new URLSearchParams(window.location.search);
        let id = searchParams.get('id');
        // document.getElementById('categoryName').textContent = id ? id : 'Popular';
        //  document.getElementById('filter-category').value=id;
        let currentCategory = 'Popular';
        let currentPage = 2;
        const itemsPerPage = 4;
        let isLoading = false;

        // Handle category tab clicks
        document.querySelectorAll('#productTab .nav-link').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedCategory = this.getAttribute('data-category');
                if (currentCategory !== selectedCategory) {
                    document.querySelector('#productTab .active').classList.remove('active');
                    this.classList.add('active');
                    currentCategory = selectedCategory;
                    currentPage = 1;

                    setTimeout(() => {
                        fetchProducts(false);
                    }, 50);
                }
            });
        });

        // Filter and search handlers
        document.getElementById('search-input').addEventListener('input', () => {
            currentPage = 1;
            fetchProducts(false);
        });

        document.getElementById('apply-filters').addEventListener('click', function() {
            currentPage = 1;
            fetchProducts(false);
            let filterOffcanvasEl = document.getElementById('filterOffcanvas');
            let filterOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvasEl) || new bootstrap.Offcanvas(
                filterOffcanvasEl);
            filterOffcanvas.hide();
        });

        document.getElementById('reset-filters').addEventListener('click', function() {
            document.getElementById('filter-price-min').value = '';
            document.getElementById('filter-price-max').value = '';
            document.getElementById('filter-brand').value = '';
            document.getElementById('filter-category').value = '';
            document.getElementById('filter-star').value = '';
            currentPage = 1;
            fetchProducts(false);
            let filterOffcanvasEl = document.getElementById('filterOffcanvas');
            let filterOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvasEl) || new bootstrap.Offcanvas(
                filterOffcanvasEl);
            filterOffcanvas.hide();
        });

        // Load More Button
        const loadMoreBtn = document.getElementById('load-more-btn');
        loadMoreBtn.addEventListener('click', () => {
            fetchProducts(true);
        });

        // Sort change handler
        document.getElementById('sort-price').addEventListener('change', () => {
            currentPage = 1;
            fetchProducts(false);
        });

        async function fetchProducts(append = false) {
            if (isLoading)
                return; // out of the function if already loading//  prevents (clicks Load More multiple times very fast or triggers filtering quickly)
            isLoading = true;

            const loading = document.getElementById('loading-spinner');
            loading.classList.remove('d-none');

            const sortValue = document.getElementById('sort-price').value;
            const search = document.getElementById('search-input').value;
            const priceMin = document.getElementById('filter-price-min').value;
            const priceMax = document.getElementById('filter-price-max').value;
            const brand = document.getElementById('filter-brand').value;
            const category = document.getElementById('filter-category').value;
            const star = document.getElementById('filter-star').value;

            let array;
            try {
                const params = new URLSearchParams({
                    remark: currentCategory.toLowerCase(),
                    search: search || '',
                    price_min: priceMin || '',
                    price_max: priceMax || '',
                    brand: brand || '',
                    star: star || '',
                    dynamic_category: category || '',
                    sort: sortValue || '',
                    page: currentPage, //Laravel automatically reads ?page=X from the query string when using ->paginate() — you don't have to fetch it manually.
                    limit: itemsPerPage
                });

                loadMoreBtn.disabled = true;

                const res = await fetch(`/product-filter?${params.toString()}`);
                if (!res.ok) // res.status !== 200
                    throw new Error("Failed to fetch products");

                const result = await res.json();
                const data = result.data.products;
                const hasMore = result.data.hasMorePages;

                const productDom = document.getElementById('product-content');
                const productFragment = document.createDocumentFragment();

                array=data;
                if (data.length == 0) {
                    const EachItem = document.createElement('div');
                    EachItem.className = 'col-12 text-center mb-4 mt-2';
                    EachItem.innerHTML = `   <h4 style="color: #007bff"> Find into another section</h4>`;
                    productFragment.appendChild(EachItem);
                } else {
                    data.forEach(product => {
                        const EachItem = document.createElement('div');
                        EachItem.className = 'p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex';
                        EachItem.innerHTML = `
<a href="/details?id=${product.id}" class="product-link w-100">
  <div class="product w-100">
    <div class="product_img">
      <img class="prod-img"
        width="250" height="250"
        src="data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoKAAoAAUAmJaQAA3AA/vshgAA="
        loading="lazy"
        data-src="${product.image}"
        alt="${product.img_alt}">
      <div class="product_action_box">
        <ul class="list_none pr_action_btn">
          <li><i class="bi-eye"></i></li>
        </ul>
      </div>
    </div>
    <div class="product_info">
      <h6 class="product_title">${product.title}</h6>
      <div class="product_price">
        ${product.discount ? `
                          <span class="discount_price text-primary fw-bold">${product.discount_price}</span>
                          <del class="ms-2">${product.price}</del>
                        ` : `
                          <span class="price">${product.price}</span>
                        `}
      </div>
      <div class="rating_wrap d-flex justify-content-between align-items-center mt-2">
        <div class="rating">
          <div class="star-bg">★★★★★</div>
          <div class="star-fill" style="width:${product.star}%">★★★★★</div>
        </div>
        <span class="stock-status small ${product.stock == '0' ? 'out' : ''}">
          ${product.stock == '0' ? 'Out of Stock' : `${product.stock} In Stock`}
        </span>
      </div>
    </div>
  </div>
</a>
`;

                        productFragment.appendChild(EachItem);
                    });
                }
                if (!append) {
                    productDom.innerHTML = '';
                }
                productDom.appendChild(productFragment);

                if (hasMore) {
                    loadMoreBtn.classList.remove('d-none');
                } else {
                    loadMoreBtn.classList.add('d-none');
                }

                currentPage++;

            } catch (err) {
                console.error("Product fetch failed:", err);
            } finally {
                loading.classList.add('d-none');
                if(array.length>0) lazyLoadImages();
                loadMoreBtn.disabled = false;
                isLoading = false;
            }
        }


        function lazyLoadImages() {
            const images = document.querySelectorAll('img.prod-img');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            const src = img.dataset.src;
                            const realImg = new Image();
                            realImg.src = src;
                            realImg.onload = () => {
                                img.src = src;
                                img.classList.add('loaded');
                                obs.unobserve(img);
                            };
                        }
                    });
                }, {
                    threshold: 0.1
                });
                images.forEach(img => observer.observe(img));
            } else {
                images.forEach((img) => {
                    const src = img.dataset.src;
                    const realImg = new Image();
                    realImg.src = src;
                    realImg.onload = () => {
                        img.src = src;
                        img.classList.add('loaded');
                    };
                });
            }
        }

        async function loadFilters() {
            try {
                const res = await fetch('/api/product-filters');
                if (!res.ok) throw new Error("Network response was not ok");
                const result = await res.json();
                const {
                    brands,
                    categories
                } = result.data;

                const brandSelect = document.getElementById('filter-brand');
                const categorySelect = document.getElementById('filter-category');

                const brandFragment = document.createDocumentFragment();
                brands.forEach(brand => {
                    const option = document.createElement('option');
                    option.value = brand.id;
                    option.textContent = brand.brandName;
                    brandFragment.appendChild(option);
                });
                brandSelect.appendChild(brandFragment);

                const categoryFragment = document.createDocumentFragment();
                categories.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.categoryName;
                    categoryFragment.appendChild(option);
                });
                categorySelect.appendChild(categoryFragment);
            } catch (err) {
                console.error("Filter loading failed:", err);
            }
        }
    </script>
