@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.ProductDetails', ['product' => $product])
    @include('component.Footer')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => productDetails());
            // Defer  fetch until browser is idle
            requestIdleCallback(() => {
                productReview();
            });
            requestIdleCallback(() => {
                Category();
            });
        });
    </script>
@endsection
