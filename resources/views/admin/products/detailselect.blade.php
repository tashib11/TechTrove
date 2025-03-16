@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Modify Details of Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ secure_asset ('/') }}" class="btn btn-primary">Home</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<div class="col-md-4">

    <div class="card">
        <div class="card-body">
            <h2 class="h4  mb-3">Product category</h2>
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
<div class="pb-5 pt-3">
    <a href="{{ route('product.detail.edit', $product->id) }}" class="btn btn-primary">Update</a>
    <a href="{{ route('product.detail.select') }}" class="btn btn-outline-dark ml-3">Cancel</a>
</div>
@endsection

