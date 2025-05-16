@extends('layout.app')
@section('content')
    @include('component.MenuBar')

                        @include('component.profile')


    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            // await OrderListRequest();
            await ProfileDetails();
            // await productReview();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>


@endsection

