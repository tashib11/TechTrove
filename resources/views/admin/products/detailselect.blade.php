@extends('admin.layouts.app')

@section('content')

<style>
/* Add padding to search input to make room for icon */
.select2-container--default .select2-search--dropdown .select2-search__field {
    padding-left: 30px;
    background-image: url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/search.svg'); /* or any icon URL */
    background-repeat: no-repeat;
    background-position: 8px 50%;
    background-size: 16px;

}

/* Optional: Better visual appearance */
.select2-container--default .select2-selection--single {
    border-radius: 4px;
    height: 38px;
    padding: 5px 10px;
}
</style>

<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Modify Details of Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ asset ('/') }}" class="btn btn-primary">Home</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <h2 class="h4  mb-3">Products</h2>
            <div class="mb-3">
                <label for="product">Product</label>
                <select name="product_id" id="product" class="form-control select2">
             <option value="" disabled selected>Select a Product</option>

                    @if ($products->isnotEmpty())
                          @foreach ($products as $product )
                          <option value="{{  $product->id}}">{{  $product->title}}</option>
                          @endforeach
                    @endif

                </select>
                <p class="error"> </p>
            </div>

        </div>
    </div>

<div class="pb-5 pt-3">
   <a href="#" id="updateBtn" class="btn btn-primary">Update</a>
    <a href="{{ route('product.detail.select') }}" class="btn btn-outline-dark ml-3">Cancel</a>
</div>
</div>
        </div>
    </div>
@endsection


@section('script')
<script>
    // search
        $(document).ready(function () {
    $('#product').select2({
        placeholder: 'Select a Product',
        allowClear: true,
        width: '100%',
        dropdownCssClass: 'custom-select2-dropdown'
    });
});

// update button
    document.addEventListener('DOMContentLoaded', function () {
        const updateBtn = document.getElementById('updateBtn');
        const productSelect = document.getElementById('product');
        const errorText = document.querySelector('.error');

        if (updateBtn && productSelect) {
            updateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                let selectedId = productSelect.value;
                if (!selectedId) {
                    errorText.textContent = 'Please select a product.';
                    return;
                }
                let url = "{{ route('product.detail.edit', ['product' => '__id__']) }}";
                url = url.replace('__id__', selectedId);
                window.location.href = url;
            });
        }
    });
</script>

@endsection
