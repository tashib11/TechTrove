@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product Detail</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ asset('/') }}" class="btn btn-primary">Home</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('product.detail.update', $products->id) }}" method="POST" name="productForm" id="productForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Product Name -->
                         <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product Titles</h2>
                        <div class="mb-3">
                            <label for="product">Product</label>
                            <select name="product_id" id="product" class="form-control">
                                <option value="">Select a Product</option>

                                @if ($pods->isnotEmpty())
                                      @foreach ($pods as $product )

                                      <option  {{ ($products->product_id== $product->id) ? 'selected' : '' }}  value="{{  $product->id}}">{{  $product->title}}</option>
                                      @endforeach
                                @endif

                            </select>

                        </div>
                    </div>
                </div>
                    <!-- Description -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <label for="des">Description</label>
                            <textarea name="des" id="des" class="summernote">{{ $products->des }}</textarea>
                        </div>
                    </div>

                    <!-- Images -->
                    @for ($i = 1; $i <= 4; $i++)
                        @php
                            $imgField = "img{$i}";
                            $imgUrl = $products->$imgField;
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="img{{ $i }}">Image {{ $i }}</label>
                                <input type="file" name="img{{ $i }}" id="img{{ $i }}" class="form-control">
                                <p class="error"></p>

                                <div id="imagePreviewCard{{ $i }}" class="card mt-3 {{ $imgUrl ? '' : 'd-none' }}">
                                    <img id="imagePreview{{ $i }}" src="{{ $imgUrl }}" class="card-img-top" style="max-height: 200px; object-fit: contain;">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="alt{{ $i }}">Image Alt Text</label>
                                            <input type="text" class="form-control" name="img{{ $i }}_alt"  value="{{ $products->{'img'.$i.'_alt'} }}" placeholder="Describe the image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                    <!-- Color and Size -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <label for="color">Color</label>
                            <input type="text" name="color" id="color" class="form-control" value="{{ $products->color }}" placeholder="e.g., red, green">
                        </div>
                        <div class="card-body">
                            <label for="size">Size</label>
                            <input type="text" name="size" id="size" class="form-control" value="{{ $products->size }}" placeholder="e.g., 16, 17">
                        </div>
                    </div>
                </div>



            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ asset('/Dashboard/ProductCreate') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
</section>
@endsection

@section('script')
<script>
$(document).ready(function () {

        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//search bar
    $('#product').select2({
        placeholder: 'Select a Product',
        allowClear: true,
        width: '100%'
    });
// for textarea of description
    $('.summernote').summernote();

    // Set up all previews
    for (let i = 1; i <= 4; i++) {
        setupImagePreview(`img${i}`, `imagePreviewCard${i}`, `imagePreview${i}`);
    }

    $("#productForm").submit(function(event){
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                if (response.status == true || response.status === "true") {
                    window.location.href = "/Dashboard/DetailsSelect";
                } else {
                    alert("Update failed.");
                }
            },
            error: function(xhr){
                let res = xhr.responseJSON;
                if (res && res.errors) {
                    $(".error").removeClass('is-invalid').html("");
                    $("input, select").removeClass('is-invalid');
                    $.each(res.errors, function(key, value){
                        $('#' + key).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
                    });
                } else {
                    alert("Something went wrong. Please check your input.");
                }
            }
        });
    });
});


</script>
@endsection
