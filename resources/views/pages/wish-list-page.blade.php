@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.WishList')
    @include('component.Footer')
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            requestAnimationFrame(() => WishList());
        });
         requestIdleCallback(() => {
            Category();
        });
    </script>
@endsection
