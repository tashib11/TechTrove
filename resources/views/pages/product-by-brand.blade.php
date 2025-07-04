@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.ByBrandList', ['initialProducts' => $initialProducts, 'brandName'=> $brandName ])
    @include('component.Footer')
    <script>
        requestIdleCallback(() => {
            Category(); // Load remaining HeroSlider functionality
        });

        (async () => {
            await loadFilters();
            if (id) {
                document.getElementById('filter-brand').value = id;
            }
        })()
    </script>
@endsection
