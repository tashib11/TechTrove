@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.CartList')
    @include('component.Footer')
    <script>
  window.addEventListener('DOMContentLoaded', () => {
            // Run critical fetchOrders right after DOM ready, before paint
            requestAnimationFrame(() => {
                CartList();
            });

            // Defer menubar fetch until browser is idle
            if ('requestIdleCallback' in window) {
                requestIdleCallback(() => {
                    Category();
                });
            } else {
                // Fallback for browsers without requestIdleCallback
                setTimeout(() => {
                    Category();
                }, 1000);
            }
        });
    </script>
@endsection





