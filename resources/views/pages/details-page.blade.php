@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.ProductDetails')
    {{-- @include('component.ProductSpecification') --}}
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            await productDetails();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            await productReview();

        })()
    </script>
@endsection

