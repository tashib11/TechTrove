@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.ByCategoryList', ['initialProducts' => $initialProducts, 'categoryName'=> $categoryName ])
    @include('component.Footer')
    <script>
        requestIdleCallback(() => {
            Category(); // Load remaining HeroSlider functionality
        });

        (async () => {
            await loadFilters();
            if (id) {
                document.getElementById('filter-category').value = id;
            }
        })()
    </script>
@endsection
