@extends('admin.layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid my-2">
      <div class="row align-items-center mb-3">
    <div class="col-md-4">
        <h3 class="mb-0">Edit Products</h3>
    </div>
    <div class="col-md-4 text-md-center mt-2 mt-md-0">
        <div class="input-group">
            <input type="text" id="searchTitle" class="form-control" placeholder="Search by Title">
           <button class="btn btn-warning d-flex align-items-center gap-1 px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas">
    <i class="bi bi-funnel-fill"></i> Filter
</button>

        </div>
    </div>
    <div class="col-md-4 text-md-end mt-2 mt-md-0">
        <a href="{{ asset('/Dashboard/ProductCreate') }}" class="btn btn-primary">+ New Product</a>
    </div>
</div>

    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">


            <div class="card-body table-responsive p-0">

                           <div id="productTable">

               @include('admin.products.product-partial')

            </div>
                   </div>

        </div>
    </div>
    <!-- /.card -->
</section>

<!-- Offcanvas Filter Form -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filterCanvas">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Filter Products</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <form id="filterForm">
      @csrf

      <!-- Category -->
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-select" name="category_id">
          <option value="">All</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->categoryName }}</option>
          @endforeach
        </select>
      </div>

      <!-- Brand -->
      <div class="mb-3">
        <label class="form-label">Brand</label>
        <select class="form-select" name="brand_id">
          <option value="">All</option>
          @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->brandName }}</option>
          @endforeach
        </select>
      </div>

      <!-- Remark -->
      <div class="mb-3">
        <label class="form-label">Remark</label>
        <select class="form-select" name="remark">
          <option value="">All</option>
          <option value="new">New</option>
          <option value="popular">Popular</option>
          <option value="top">Top</option>
          <option value="trending">Trending</option>
        </select>
      </div>

      <!-- Price Range -->
      <div class="mb-3">
        <label class="form-label">Price Range</label>
        <div class="input-group">
          <input type="number" class="form-control" name="min_price" placeholder="Min">
          <input type="number" class="form-control" name="max_price" placeholder="Max">
        </div>
      </div>

      <!-- Stock -->
      <div class="mb-3">
        <label class="form-label">Stock</label>
        <select class="form-select" name="stock">
          <option value="">All</option>
          <option value="in">In Stock</option>
          <option value="out">Out of Stock</option>
        </select>
      </div>

      <!-- Star -->
      <div class="mb-3">
        <label class="form-label">Star Rating</label>
        <select class="form-select" name="star">
          <option value="">All</option>
          @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}">{{ $i }} Stars</option>
          @endfor
        </select>
      </div>
      <button type="button" id="resetFilterBtn" class="btn btn-outline-danger w-100 mt-2">Reset Filter</button>
      <button type="submit" class="btn btn-success w-100">Apply Filter</button>
    </form>
  </div>
</div>

<!-- Description Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="descriptionModalLabel">Full Product Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="fullDescriptionContent">
        <!-- Full description will be inserted here -->
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product? This action cannot be undone.
        <input type="hidden" id="deleteProductId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>


@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterCanvas = document.getElementById('filterCanvas');
    const productTable = document.querySelector('#productTable');
    const filterForm = document.getElementById('filterForm');
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const searchTitleInput = document.getElementById('searchTitle');

    // Helper to make GET requests with proper headers
    function fetchWithAjaxHeaders(url) {
        return axios.get(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
    }

    // Serialize form + searchTitle field together
    function getFilterParams() {
        const formData = new FormData(filterForm);
        if (searchTitleInput.value.trim() !== '') {
            formData.append('title', searchTitleInput.value.trim());
        }
        return new URLSearchParams(formData).toString();
    }

    // Submit filter form
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const params = getFilterParams();
        const url = `/Dashboard/ProductList?${params}`;

        fetchWithAjaxHeaders(url)
            .then(res => {
                productTable.innerHTML = res.data;
                bootstrap.Offcanvas.getInstance(filterCanvas)?.hide();
            })
            .catch(err => {
                console.error('Filtering failed:', err);
                alert('An error occurred while applying filters.');
            });
    });

    // Reset filter button
    resetFilterBtn.addEventListener('click', function () {
        filterForm.reset();
        searchTitleInput.value = ''; // also clear title search
        fetchWithAjaxHeaders(`/Dashboard/ProductList`)
            .then(res => {
                productTable.innerHTML = res.data;
                bootstrap.Offcanvas.getInstance(filterCanvas)?.hide();
            })
            .catch(err => {
                console.error('Reset failed:', err);
                alert('An error occurred while resetting filters.');
            });
    });

    // Live title search (debounced)
    let debounceTimer;
    searchTitleInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const params = getFilterParams();
            const url = `/Dashboard/ProductList?${params}`;

            fetchWithAjaxHeaders(url)
                .then(res => {
                    productTable.innerHTML = res.data;
                })
                .catch(err => {
                    console.error('Search failed:', err);
                });
        }, 300); // debounce delay
    });
});

// View full description modal handler
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('view-description-btn')) {
        const fullDescription = e.target.getAttribute('data-description');
        document.getElementById('fullDescriptionContent').innerHTML = fullDescription;
    }
});
</script>
<!-- SweetAlert2 CSS & JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteProductIdInput = document.getElementById('deleteProductId');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

    // Capture product ID when delete button clicked
    document.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            deleteProductIdInput.value = btn.dataset.id;
        }
    });

    // On confirm delete
    confirmDeleteBtn.addEventListener('click', function () {
        const productId = deleteProductIdInput.value;

        axios.get(`/Dashboard/ProductDelete/${productId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => {
            deleteModal.hide();

            // Refresh table
            axios.get(`/Dashboard/ProductList`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).then(res => {
                document.getElementById('productTable').innerHTML = res.data;
            });

            // Show SweetAlert success
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Product deleted successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(err => {
            deleteModal.hide();

            const message = err.response?.data?.message || 'An error occurred while deleting the product.';

            // Show SweetAlert error
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message,
                confirmButtonColor: '#d33'
            });
        });
    });
});
</script>
