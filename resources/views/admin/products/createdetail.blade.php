@extends('admin.layouts.app')

@section('content')
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
    <form action="{{ route('product.detail.store') }}" method="POST" name="productForm" id="productForm">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="des" id="des" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image1 </label>
                                <input type="text" name="img1" id="img1" class="form-control" placeholder="image link">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image2 </label>
                                <input type="text" name="img2" id="img2" class="form-control" placeholder="image link">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image3 </label>
                                <input type="text" name="img3" id="img3" class="form-control" placeholder="image link">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image4 </label>
                                <input type="text" name="img4" id="img4" class="form-control" placeholder="image link">
                                <p class="error"></p>
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
            <div class="col-md-4">

                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product titles</h2>
                        <div class="mb-3">
                            <label for="product">Product</label>
                            <select name="product_id" id="product" class="form-control">
                                <option value="">Select a Product</option>

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


            </div>
        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ asset('/Dashboard/DetailsCreate') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        url:'{{ route("product.detail.store") }}',
        type:'post',
        data:formArray,
        dataType: 'json',
        success:function(response){
            if(response['status']== true){
            console.log(response);
            }else{

                var error = response['errors'];


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
