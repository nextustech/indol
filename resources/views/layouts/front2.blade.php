<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Dr. Indolia Physiotherapy Clinic</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('front/assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('front/assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('front/assets/images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ url('front/assets/images/favicons/site.webmanifest') }}" />
    <meta name="description" content="Dr. Indolia Physiotherapy Clinic" />
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&amp;family=Nunito:ital,wght@0,200..1000;1,200..1000&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('front/assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/animate/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/odometer/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/chirofind-icons/style.css') }}">
    <link rel="stylesheet" href="{{ url('front/assets/vendors/bootstrap-select/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/nice-select/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/vendors/twenty-twenty/twentytwenty.css') }}" />
    <!-- template styles -->
    <link rel="stylesheet" href="{{ url('front/assets/css/chirofind.css') }}" />
    <link rel="stylesheet" href="{{ url('front/assets/css/chirofind-responsive.css') }}" />
    @stack('styles')

</head>

<body>

<x-preloader />

<div class="page-wrapper">

    <x-header />

    @yield('content')

    <x-footer />

</div>

<x-mobile-nav />

<!-- JS -->
<script src="{{ url('front/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jarallax/jarallax.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/odometer/odometer.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/swiper/swiper.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/wnumb/wNumb.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/wow/wow.js') }}"></script>
<script src="{{ url('front/assets/vendors/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery.circle-type/jquery.circleType.js') }}"></script>
<script src="{{ url('front/assets/vendors/jquery.circle-type/jquery.lettering.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/sidebar-content/jquery-sidebar-content.js') }}"></script>
<script src="{{ url('front/assets/vendors/countdown/countdown.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/twenty-twenty/twentytwenty.js') }}"></script>
<script src="{{ url('front/assets/vendors/twenty-twenty/jquery.event.move.js') }}"></script>
<script src="{{ url('front/assets/vendors/nice-select/jquery.nice-select.min.js') }}"></script>
<!-- template js -->
<script src="{{ url('front/assets/js/chirofind.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@stack('scripts')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</body>
</html>
