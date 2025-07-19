@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.Payment')
    @include('component.Footer')
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            // Defer menubar fetch until browser is idle
            Category();
        });
    </script>
@endsection
