@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.indexDB-helper')

    @include('component.HeroSlider', ['first' => $first])
    @include('component.TopCategories')
    @include('component.ExclusiveProducts')
    @include('component.TopBrands')
    @include('component.Footer')

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => Category());
        });
        // IIFE to optimize FCP by deferring non-critical JS
        (async () => {
            requestIdleCallback(() => {
                Hero(); // Load remaining HeroSlider functionality
            });
            requestIdleCallback(async () => {
                await TopCategory(); // Lazy load top categories
                await fetchProducts();
                loadFilters();
                await TopBrands(); // Then load top brands
            });
        })();
    </script>
@endsection
