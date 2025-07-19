@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.profile')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => ProfileDetails());
        });
        requestIdleCallback(() => {
            Category();
        });
    </script>
@endsection
