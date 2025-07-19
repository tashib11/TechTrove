
@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.PolicyList')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
         window.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => Policy());
            // Defer  fetch until browser is idle
            requestIdleCallback(() => {
                Category();
            });
        });
        // (async () => {
            // // await Category();
            // await Policy();
            //  await TopBrands();
        // })()
    </script>
@endsection


