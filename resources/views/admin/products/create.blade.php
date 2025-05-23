@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ asset ('/') }}" class="btn btn-primary">Home</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="{{ route('product.store') }}" method="POST" name="productForm" id="productForm" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <div class="card mb-3">
                        <div class="card-body">
                            <label for="des">Description</label>
                            <textarea name="short_des" id="short_des" class="summernote"></textarea>
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                  <div class="card mb-3">
                    <div class="card-body">
            <div class="col-md-12">
    <div class="mb-3">
        <label for="image">Upload Product Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <p class="error"></p>
    </div>
            </div>
      <!-- Image Preview Card -->
    <div id="imagePreviewCard" class="card mt-3 d-none">
        <img id="imagePreview" class="card-img-top" style="max-height: 200px; object-fit: contain;">
        <div class="card-body">
            <div class="form-group">
                <label for="img_alt">Image Alt Text</label>
                <input type="text" class="form-control" name="img_alt" id="img_alt" placeholder="Describe the image">
            </div>

        </div>
    </div>
            </div>
</div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Pricing</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                    <p class="error"> </p>
                                </div>
                            </div>

                     <div class="col-md-12">
    <div class="mb-3">
        <label for="discount">Discount</label>
        <select name="discount" id="discount" class="form-control">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
        <p class="error"></p>
    </div>
</div>


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="discount_price">Final Price(if Discount available)</label>
                                    <input type="text" name="discount_price" id="discount_price" class="form-control" placeholder="Discount Price">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Info</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock">Stock </label>
                                    <input type="text" name="stock" id="stock" class="form-control" placeholder="Number of stock">
                                    <p class="error" ></p>
                                </div>
                            </div>

                            <div class="card-body">
                                <h2 class="h4 mb-3">Product remark</h2>
                                <div class="mb-3">
                                    <select name="remark" id="remark" class="form-control">
                                        <option value="popular">popular</option>
                                        <option value="new">new</option>
                                        <option value="top">top</option>
                                        <option value="trending">trending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product category</h2>
                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-control">
                                <option value="">Select a Category</option>

                                @if ($categories->isnotEmpty())
                                      @foreach ($categories as $category )
                                      <option value="{{  $category->id}}">{{  $category->categoryName}}</option>
                                      @endforeach
                                @endif

                            </select>
                            <p class="error"> </p>
                        </div>

                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product brand</h2>
                        <div class="mb-3">
                            <select name="brand_id" id="brand" class="form-control">
                                <option value="">Select a Brand</option>

                                @if ($brands->isnotEmpty())
                                      @foreach ($brands as $brand )
                                      <option value="{{  $brand->id}}">{{  $brand->brandName}}</option>
                                      @endforeach
                                @endif

                            </select>
                            <p class="error" ></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="pb-5 pt-3">
        <button type="submit" id="submitBtn" class="btn btn-primary">
    Create
    <span id="spinner" class="spinner-border spinner-border-sm d-none ml-2" role="status" aria-hidden="true"></span>
</button>

            <a href="{{ asset('/Dashboard/ProductList') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
</form>
    <!-- /.card -->
</section>
@endsection

@section('script')
<script>
    // CSRF Token Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.summernote').summernote();
    setupImagePreview('image', 'imagePreviewCard', 'imagePreview');

    $("#productForm").submit(function(event){
        event.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const submitBtn = $('#submitBtn');
        const spinner = $('#spinner');

        // Disable button and show spinner
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');

        $.ajax({
            url: '{{ route("product.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.msg === 'success') {
                    // alert(response.data.message || "Product created successfully.");
                    // setTimeout(() => {
                        window.location.href = "/Dashboard/DetailsCreate";
                    // }, 100); // give browser a short pause
                } else {
                    alert(response.data?.message || "Product creation failed. Try again.");
                    submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                }
            },
           error: function (xhr) {
    const res = xhr.responseJSON;
    let firstErrorField = null;

    // Clear previous errors
    $(".error").html("").removeClass('invalid-feedback');
    $("input, select, textarea").removeClass('is-invalid');

    if (res?.errors) {
        $.each(res.errors, function (key, messages) {
            const message = messages[0];

            // Try to get the field by name or ID
            const field = $(`[name="${key}"], #${key}`);

            if (field.length > 0) {
                field.addClass('is-invalid');

                // If <p class="error"> exists next to this field, fill it
                const errorElement = field.closest('.mb-3, .form-group').find('p.error');

                if (errorElement.length > 0) {
                    errorElement.addClass('invalid-feedback').html(message);
                } else {
                    field.after(`<p class="error invalid-feedback">${message}</p>`);
                }

                if (!firstErrorField) {
                    firstErrorField = field;
                }
            }
        });

        // Scroll to first error
        if (firstErrorField) {
            $('html, body').animate({
                scrollTop: firstErrorField.offset().top - 100
            }, 600);
            firstErrorField.focus();
        }
    } else {
        alert(res?.data?.message || "An unexpected error occurred.");
    }

    // Re-enable submit
    $('#submitBtn').prop('disabled', false);
    $('#spinner').addClass('d-none');
}

        });
    });
</script>
@endsection
