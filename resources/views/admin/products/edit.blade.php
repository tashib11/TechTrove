@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
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
    <form action="{{ route("product.update", $product->id) }}" method="POST" name="productForm" id="productForm">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $product->title }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="short_des" id="description" cols="30" rows="10" class="summernote" placeholder="Description" > {{ $product->short_des }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image </label>
                                <input type="text" name="image" id="image" class="form-control" placeholder="image link"  value="{{ $product->image }}">
                                <p class="error"></p>
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
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price"  value="{{ $product->price }}">
                                    <p class="error"> </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="discount">Discount </label>
                                    <input type="boolean" name="discount" id="discount" class="form-control" placeholder="Discount available(0/1)"  value="{{ $product->discount }}">

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="discount_price">Discount Price</label>
                                    <input type="text" name="discount_price" id="discount_price" class="form-control" placeholder="Discount Price"  value="{{ $product->discount_price }}">

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
                                    <input type="boolean" name="stock" id="stock" class="form-control" placeholder="stock(1/0)"  value="{{ $product->stock }}">
                                    <p class="error" ></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="star">Star</label>
                                    <input type="float" name="star" id="star" class="form-control" placeholder="Star"  value="{{ $product->star }}">
                                    <p class="error"> </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product remark</h2>
                                <div class="mb-3">
                                    <select name="remark" id="remark" class="form-control">
                                        <option {{ ($product->remark=='popular') ? 'selected' : '' }} value="popular">popular</option>
                                        <option {{ ($product->remark=='new') ? 'selected' : '' }} value="new">new</option>
                                        <option {{ ($product->remark=='top') ? 'selected' : '' }} value="top">top</option>
                                        <option {{ ($product->remark=='specail') ? 'selected' : '' }} value="specail">specail</option>
                                        <option {{ ($product->remark=='trending') ? 'selected' : '' }} value="trending">trending</option>
                                        <option {{ ($product->remark=='regular') ? 'selected' : '' }} value="regular">regular</option>
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
                                      <option  {{ ($product->category_id== $category->id) ? 'selected' : '' }}  value="{{  $category->id}}">{{  $category->categoryName}}</option>
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
                                      <option  {{ ($product->brand_id== $brand->id) ? 'selected' : '' }}  value="{{  $brand->id}}">{{  $brand->brandName}}</option>
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
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ asset('/Dashboard/ProductList') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
</form>
    <!-- /.card -->
</section>
@endsection



@section('customJs')
<script>

$("#productForm").submit(function(event){
    event.preventDefault();
       var formArray = $(this).serializeArray();
    $.ajax({
        url:'{{ route("product.update", $product->id) }}',
        type:'post',
        data:formArray,
        dataType: 'json',
        success:function(response){
            if(response['status']== true){
            console.log(response);
            }else{

                var error = response['errors'];

            //  if(error['title']){
            //         $('#title').addClass('is-invalid').siblings('p').
            //         addClass('invalid-feedback').html(error['title']);
            //     }else{
            //         $('#title').removeClass('is-invalid').siblings('p').
            //         removeClass('invalid-feedback').html("");;
            //     }
            $(".error").removeClass('is-invalid').html("");
            $("input[type=text],select").removeClass('is-invalid');
            $.each(error,function(key,value){
                $('#'+key).addClass('is-invalid').siblings('p').
                addClass('invalid-feedback').html(value);
            });

            }
        },
        error:function(){
            console.log("something went wrong");
        }
    });
});


</script>
@endsection
