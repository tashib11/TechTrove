@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.Orders')
    @include('component.Footer')
    <script>
        (async () => {
            await fetchOrders();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection





