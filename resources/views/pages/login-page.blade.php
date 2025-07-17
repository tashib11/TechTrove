@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.Login')
    @include('component.Footer')
    <script>
          window.addEventListener('DOMContentLoaded', () => {
             requestIdleCallback(() => {
                // Defer menubar fetch until browser is idle
                Category();
            });
        });
    </script>
@endsection

