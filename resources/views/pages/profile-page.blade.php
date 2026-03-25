@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.profile')
    @include('component.Footer')
    <script>
        requestIdleCallback(() => {
            Category();
        });
    </script>
@endsection
