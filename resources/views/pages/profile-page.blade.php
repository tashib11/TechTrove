@extends('layout.app')
@section('content')
    @include('component.MenuBar')
   @include('component.profile')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            await ProfileDetails();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>


@endsection

