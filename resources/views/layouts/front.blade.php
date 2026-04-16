<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Awaiken">
	<!-- Page Title -->
	<title>Physiocare - Physiotherapy HTML Template</title>
	<!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
	<!-- Google Fonts Css-->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&amp;family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;display=swap" rel="stylesheet">
	<!-- Bootstrap Css -->
	<link href="{{ url('front/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<!-- SlickNav Css -->
	<link href="{{ url('front/css/slicknav.min.css') }}" rel="stylesheet">
	<!-- Swiper Css -->
	<link rel="stylesheet" href="{{ url('front/css/swiper-bundle.min.css') }}   ">
	<!-- Font Awesome Icon Css-->
	<link href="{{ url('front/css/all.css') }}" rel="stylesheet" media="screen">
	<!-- Animated Css -->
	<link href="{{ url('front/css/animate.css') }}" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
	<link rel="stylesheet" href="{{ url('front/css/magnific-popup.css') }}">
	<!-- Mouse Cursor Css File -->
	<link rel="stylesheet" href="{{ url('front/css/mousecursor.css') }}">
	<!-- Main Custom Css -->
	<link href="{{ url('front/css/custom.css') }}" rel="stylesheet" media="screen">
    @stack('styles')
</head>
<body>

<x-preloader />

    <x-header />

    @yield('content')

    <x-footer />




    <!-- Jquery Library File -->
    <script src="{{ url('front/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js file -->
    <script src="{{ url('front/js/bootstrap.min.js') }}"></script>
    <!-- Validator js file -->
    <script src="{{ url('front/js/validator.min.js') }}"></script>
    <!-- SlickNav js file -->
    <script src="{{ url('front/js/jquery.slicknav.js') }}"></script>
    <!-- Swiper js file -->
    <script src="{{ url('front/js/swiper-bundle.min.js') }}"></script>
    <!-- Counter js file -->
    <script src="{{ url('front/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('front/js/jquery.counterup.min.js') }}"></script>
    <!-- Magnific js file -->
    <script src="{{ url('front/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- SmoothScroll -->
    <script src="{{ url('front/js/SmoothScroll.js') }}"></script>
    <!-- Parallax js -->
    <script src="{{ url('front/js/parallaxie.js') }}"></script>
    <!-- MagicCursor js file -->
    <script src="{{ url('front/js/gsap.min.js') }}"></script>
    <script src="{{ url('front/js/magiccursor.js') }}"></script>
    <!-- Text Effect js file -->
    <script src="{{ url('front/js/SplitText.js') }}"></script>
    <script src="{{ url('front/js/ScrollTrigger.min.js') }}"></script>
    <!-- YTPlayer js File -->
    <script src="{{ url('front/js/jquery.mb.YTPlayer.min.js') }}"></script>
    <!-- Wow js file -->
    <script src="{{ url('front/js/wow.js') }}"></script>
    <!-- Main Custom js file -->
    <script src="{{ url('front/js/function.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@stack('scripts')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</body>

</html>
