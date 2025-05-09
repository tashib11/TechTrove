@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Brand</h1>
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
    <form action="{{ route("brand.store") }}" method="POST" name="productForm" id="productForm">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">



                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="brandname">Brand Name </label>
                                <input type="text" name="brandName" id="brandName" class="form-control" placeholder="name">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image">Image </label>
                                <input type="text" name="brandImg" id="brandImg" class="form-control" placeholder="image link">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>






            </div>

        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{  asset('/Dashboard/brand') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        url:'{{ route("brand.store") }}',
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
