
@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.PolicyList')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            // await Category();
            await Policy();
            $(".preloader").fadeOut(800).addClass('loaded');
             await TopBrands();
        })()
    </script>
@endsection


