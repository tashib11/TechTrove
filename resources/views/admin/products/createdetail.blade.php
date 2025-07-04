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
                <h1>Add Details of Product</h1>
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
    <form action="{{ route('product.detail.store') }}" method="POST" name="productForm" id="productForm" enctype="multipart/form-data">
     @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product titles</h2>
                        <div class="mb-3">
                            <label for="product">Product</label>
                            <select name="product_id" id="product" class="form-control select2">
                                <option value="" disabled selected>Select a Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                            <p class="error"> </p>
                        </div>
                    </div>
                </div>

                  <div class="card mb-3">
                        <div class="card-body">
                            <label for="des">Description</label>
                            <textarea name="des" id="des" class="summernote"></textarea>
                        </div>
                    </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image1 </label>
                                <input type="file" name="img1" id="img1" class="form-control" >
                                <p class="error"></p>
                            </div>
                        </div>
                           <!-- Image Preview Card -->
                         <div id="imagePreviewCard1" class="card mt-3 d-none">
                           <img id="imagePreview1" class="card-img-top" style="max-height: 200px; object-fit: contain;">
                          <div class="card-body">
                          <div class="form-group">
                          <label>Image Alt Text</label>
                         <input type="text" class="form-control" name="img1_alt" placeholder="Describe the image">
                        </div>
                    <div class="form-group">
                           <label>Image Width (px)</label>
                           <input type="number" class="form-control" name="img1_width" value="600" readonly>
                    </div>
                    <div class="form-group">
                          <label>Image Height (px)</label>
                          <input type="number" class="form-control" name="img1_height" value="600" readonly>
                    </div>

                  </div>
                         </div>
                       </div>
                      </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image2 </label>
                                <input type="file" name="img2" id="img2" class="form-control">
                                <p class="error"></p>
                            </div>
                        </div>
                         <!-- Image Preview Card -->
    <div id="imagePreviewCard2" class="card mt-3 d-none">
        <img id="imagePreview2" class="card-img-top" style="max-height: 200px; object-fit: contain;">
        <div class="card-body">
        <div class="form-group">
    <label>Image Alt Text</label>
    <input type="text" class="form-control" name="img2_alt" placeholder="Describe the image">
</div>
<div class="form-group">
    <label>Image Width (px)</label>
    <input type="number" class="form-control" name="img2_width" value="600" readonly>
</div>
<div class="form-group">
    <label>Image Height (px)</label>
    <input type="number" class="form-control" name="img2_height" value="600" readonly>
</div>

        </div>
    </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image3 </label>
                                <input type="file" name="img3" id="img3" class="form-control" >
                                <p class="error"></p>
                            </div>
                        </div>
                         <!-- Image Preview Card -->
    <div id="imagePreviewCard3" class="card mt-3 d-none">
        <img id="imagePreview3" class="card-img-top" style="max-height: 200px; object-fit: contain;">
        <div class="card-body">
       <div class="form-group">
    <label>Image Alt Text</label>
    <input type="text" class="form-control" name="img3_alt" placeholder="Describe the image">
</div>
<div class="form-group">
    <label>Image Width (px)</label>
    <input type="number" class="form-control" name="img3_width" value="600" readonly>
</div>
<div class="form-group">
    <label>Image Height (px)</label>
    <input type="number" class="form-control" name="img3_height" value="600" readonly>
</div>

        </div>
    </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image4 </label>
                                <input type="file" name="img4" id="img4" class="form-control" >
                                <p class="error"></p>
                            </div>
                        </div>
                         <!-- Image Preview Card -->
    <div id="imagePreviewCard4" class="card mt-3 d-none">
        <img id="imagePreview4" class="card-img-top" style="max-height: 200px; object-fit: contain;">
        <div class="card-body">
        <div class="form-group">
    <label>Image Alt Text</label>
    <input type="text" class="form-control" name="img4_alt" placeholder="Describe the image">
</div>
<div class="form-group">
    <label>Image Width (px)</label>
    <input type="number" class="form-control" name="img4_width" value="600" readonly>
</div>
<div class="form-group">
    <label>Image Height (px)</label>
    <input type="number" class="form-control" name="img4_height" value="600" readonly>
</div>
        </div>
    </div>
                    </div>
                </div>


                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="color">Color </label>
                                <input type="text" name="color" id="color" class="form-control" placeholder="color like(green,red,etc)">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="size">size </label>
                                <input type="text" name="size" id="size" class="form-control" placeholder="size like(16,17,etc)">
                                <p class="error"></p>
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
            <a href="{{ asset('/Dashboard/DetailsCreate') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
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
// search bar
    $('#product').select2({
        placeholder: 'Select a Product',
        allowClear: true,
        width: '100%',
        dropdownCssClass: 'custom-select2-dropdown'
    });
});

    $('.summernote').summernote();

setupImagePreview('img1', 'imagePreviewCard1', 'imagePreview1');
setupImagePreview('img2', 'imagePreviewCard2', 'imagePreview2');
setupImagePreview('img3', 'imagePreviewCard3', 'imagePreview3');
setupImagePreview('img4', 'imagePreviewCard4', 'imagePreview4');

$("#productForm").submit(function(event){
    event.preventDefault();

    var formData = new FormData(this);
     const submitBtn = $('#submitBtn');
        const spinner = $('#spinner');

        // Disable button and show spinner
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');


    $.ajax({
        url:'{{ route("product.detail.store") }}',
        type:'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
     success:function(response){
  if (response.status == true || response.status === "true") {
    window.location.href = "/Dashboard/ProductCreate";
}
else {
      submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
    if (response.errors && response.errors.general) {
        alert(response.errors.general);
    } else {
        alert("Product creation failed. Please check your inputs.");
    }
}

},
       error:function(xhr){
    let res = xhr.responseJSON;
    if (res && res.errors) {
        $(".error").removeClass('is-invalid').html("");
        $("input, select").removeClass('is-invalid');
        $.each(res.errors, function(key, value){
            $('#' + key).addClass('is-invalid').siblings('p')
                .addClass('invalid-feedback').html(value);
        });
    } else {
        alert("Fill up all fields. Please try again.");
    }
    
  // Re-enable submit
    $('#submitBtn').prop('disabled', false);
    $('#spinner').addClass('d-none');
}

    });
});



</script>
@endsection
