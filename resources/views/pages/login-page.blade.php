@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.Login')
    @include('component.Footer')
    <script>
          window.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => Category());
        });
    </script>
@endsection

