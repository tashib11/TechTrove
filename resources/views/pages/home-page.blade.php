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
            requestAnimationFrame(async () => {
                await Hero() //after DOM is ready, load HeroSlider immediately
                await TopCategory(); // then top categories
            });
            requestIdleCallback(() => {
                Category();
            });
            requestIdleCallback(async () => {
                await fetchProducts(); // Lazy  products
                loadFilters();
                await TopBrands(); // Then load top brands
            });
        });
    </script>
@endsection
