<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Home Two || Chirofind || Chirofind HTML5 Template </title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('front/assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('front/assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('front/assets/images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ url('front/assets/images/favicons/site.webmanifest') }}" />
    <meta name="description" content="Chirofind HTML5 Template" />
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
</head>

<body>
<!-- preloader -->
<div id="preloader">
    <div class="preloader">
        <span></span>
        <span></span>
    </div>
</div>
<!-- preloader end  -->

<div class="page-wrapper">
    <header class="main-header">
        <div class="main-menu__top">
            <div class="main-menu__top-inner">
                <ul class="list-unstyled main-menu__contact-list">
                    <li>
                        <div class="icon">
                            <i class="icon-envolop"></i>
                        </div>
                        <div class="text">
                            <p><a href="mailto:info@example.com">info@gauriphysiotherapy.com</a>
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="icon">
                            <i class="icon-pin"></i>
                        </div>
                        <div class="text">
                            <p>Bharatpur, Rajasthan</p>
                        </div>
                    </li>
                </ul>
                <div class="main-menu__top-right">
                    <div class="main-menu__social-box">
                        <div class="main-menu__social-box-inner">
                            <h4 class="main-menu__social-box-title">Follow Us:</h4>
                            <div class="main-menu__social">
                                <a href="#"><i class="icon-facebook"></i></a>
                                <a href="#"><i class="icon-twitter"></i></a>
                                <a href="#"><i class="icon-link-in"></i></a>
                                <a href="#"><i class="icon-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-menu">
            <div class="main-menu__wrapper">
                <div class="main-menu__wrapper-inner">
                    <div class="main-menu__left">
                        <div class="main-menu__logo">
                            <a href="index.html"><img src="{{ url('front/assets/images/resources/logo-1.svg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="main-menu__right">
                        <div class="main-menu__menu-box-and-btn-box">
                            <div class="main-menu__menu-box">
                                <div class="main-menu__main-menu-box">
                                    <ul class="main-menu__list">
                                        <li>
                                            <a href="#">Home </a>
                                        </li>
                                        <li>
                                            <a href="contact.html">Contact</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/login') }}">Login</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="menu-icons-button">
                                <div class="main-menu__search-cart-box">
                                    <a href="#" class="main-menu__search search-bar-btn icon-search"></a>
                                    <a href="cart.html" class="main-menu__cart  icon-cart"></a>
                                    <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                                </div>
                                <div class="main-menu__btn-box-outer">
                                    <div class="main-menu__btn-box">
                                        <a href="appointment.html" class="main-menu__btn thm-btn">
                                            Appointment Now
                                            <span class="icon-right-arrow"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="stricky-header stricked-menu main-menu">
        <div class="sticky-header__content"></div>
    </div><!-- /.stricky-header -->

    <!--Main Slider Start-->
    <section class="main-slider">
        <div class="swiper-container banner-slider-one">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="main-slider__shape-1"></div>
                    <div class="main-slider__shape-2"></div>
                    <div class="main-slider__shape-3"></div>
                    <div class="main-slider__shape-4"></div>
                    <div class="main-slider__shape-5 float-bob-y">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-5.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-6 float-bob-y">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-6.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-7 float-bob-x">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-7.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-8">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-8.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-9">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-9.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-10">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-10.png') }}" alt="">
                    </div>
                    <div class="main-slider__img">
                        <img src="{{ url('front/assets/images/resources/main-slider-img-1.webp') }}" alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <div class="main-slider__sub-title-box">
                                        <div class="main-slider__sub-title-shape"></div>
                                        <p class="main-slider__sub-title">Developing Strong Pain Free People</p>
                                    </div>
                                    <h2 class="main-slider__title">Welcome to Best <br> <span>Health</span> Life</h2>
                                    <p class="main-slider__text"> We are a leading Chiropractic Practice providing fast and effective pain <br> relief for patients across the hole world.</p>
                                    <div class="main-slider__btn-box">
                                        <a href="services1.html" class="main-slider__btn thm-btn">View Services<span class="icon-right-arrow"></span></a>
                                    </div>
                                    <div class="main-slider__rounded-text">
                                        <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ"
                                           class="video-popup main-slider__curved-circle-box">
                                            <div class="curved-circle-2">
                                                    <span class="curved-circle--item">
                                                        - play intro video - play intro video
                                                    </span>
                                            </div><!-- /.curved-circle -->
                                            <div class="main-slider__icon">
                                                <span class="icon-play"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="main-slider__shape-1"></div>
                    <div class="main-slider__shape-2"></div>
                    <div class="main-slider__shape-3"></div>
                    <div class="main-slider__shape-4"></div>
                    <div class="main-slider__shape-5 float-bob-y">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-5.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-6 float-bob-y">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-6.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-7 float-bob-x">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-7.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-8">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-8.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-9">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-9.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-10">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-10.png') }}" alt="">
                    </div>
                    <div class="main-slider__img">
                        <img src="{{ url('front/assets/images/resources/main-slider-img-2.webp') }}" alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <div class="main-slider__sub-title-box">
                                        <div class="main-slider__sub-title-shape"></div>
                                        <p class="main-slider__sub-title">Developing Strong Pain Free People</p>
                                    </div>
                                    <h2 class="main-slider__title">Farewell to Pain <br> <span>Welcome</span> Freedom</h2>
                                    <p class="main-slider__text"> We are a leading Chiropractic Practice providing fast and effective pain <br> relief for patients across the hole world.</p>
                                    <div class="main-slider__btn-box">
                                        <a href="services1.html" class="main-slider__btn thm-btn">View Services<span
                                                class="icon-right-arrow"></span></a>
                                    </div>
                                    <div class="main-slider__rounded-text">
                                        <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ"
                                           class="video-popup main-slider__curved-circle-box">
                                            <div class="curved-circle-2">
                                                    <span class="curved-circle--item">
                                                        - play intro video - play intro video
                                                    </span>
                                            </div><!-- /.curved-circle -->
                                            <div class="main-slider__icon">
                                                <span class="icon-play"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="main-slider__shape-1"></div>
                    <div class="main-slider__shape-2"></div>
                    <div class="main-slider__shape-3"></div>
                    <div class="main-slider__shape-4"></div>
                    <div class="main-slider__shape-5 float-bob-y">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-5.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-6 float-bob-y">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-6.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-7 float-bob-x">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-7.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-8">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-8.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-9">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-9.png') }}" alt="">
                    </div>
                    <div class="main-slider__shape-10">
                        <img src="{{ url('front/assets/images/shapes/main-slider-shape-10.png') }}" alt="">
                    </div>
                    <div class="main-slider__img">
                        <img src="{{ url('front/assets/images/resources/main-slider-img-3.webp') }}" alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <div class="main-slider__sub-title-box">
                                        <div class="main-slider__sub-title-shape"></div>
                                        <p class="main-slider__sub-title">Developing Strong Pain Free People</p>
                                    </div>

                                    <h2 class="main-slider__title">Welcome Best <br> <span>Chiropractic</span> Care</h2>

                                    <p class="main-slider__text"> We are a leading Chiropractic Practice providing fast and effective pain <br> relief for patients across the hole world.</p>

                                    <div class="main-slider__btn-box">
                                        <a href="services1.html" class="main-slider__btn thm-btn">View Services<span class="icon-right-arrow"></span></a>
                                    </div>
                                    <div class="main-slider__rounded-text">
                                        <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ"
                                           class="video-popup main-slider__curved-circle-box">
                                            <div class="curved-circle-2">
                                                    <span class="curved-circle--item">
                                                        - play intro video - play intro video
                                                    </span>
                                            </div><!-- /.curved-circle -->
                                            <div class="main-slider__icon">
                                                <span class="icon-play"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!--Main Slider End-->

    <!--Services One  Start -->
    <section class="services-one">
        <div class="services-one__shape-2 float-bob-x">
            <img src="{{ url('front/assets/images/shapes/services-one-shape-2.png') }}" alt="">
        </div>
        <div class="services-one__shape-3 float-bob-y">
            <img src="{{ url('front/assets/images/shapes/services-one-shape-3.png') }}" alt="">
        </div>
        <div class="container">
            <div class="services-one__top">
                <div class="section-title text-left">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape-1"></div>
                        <span class="section-title__tagline">Our Services</span>
                    </div>
                    <h2 class="section-title__title">Chiropractic Care May Help</h2>
                </div>
                <div class="services-carousel-nav">
                    <div class="swiper-button-prev">
                        <i class="icon-angle-right"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="icon-angle-left"></i>
                    </div>
                </div>
            </div>
            <div class="services-one__bottom">
                <div class="service-carousel-one swiper-container">
                    <div class="swiper-wrapper">
                        <!--Services One Single Start-->
                        <div class="swiper-slide">
                            <div class="services-one__single">
                                <div class="services-one__shape-1">
                                    <img src="{{ url('front/assets/images/shapes/services-one-shape-1.png') }}" alt="">
                                </div>
                                <div class="services-one__img-box">
                                    <div class="services-one__img">
                                        <img src="{{ url('front/assets/images/services/services1-1.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="services-one__content">
                                    <h3 class="services-one__title"><a href="physical-rehab.html">Physical
                                            Rehab</a>
                                    </h3>
                                    <p class="services-one__text">Leedable is content of page when looking at layout
                                        the
                                        point using lorem the Ipsum less</p>
                                    <div class="services-one__btn-box">
                                        <a href="physical-rehab.html" class="services-one__btn thm-btn">Read
                                            More<span class="icon-right-arrow"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                        <!--Services One Single Start-->
                        <div class="swiper-slide">
                            <div class="services-one__single">
                                <div class="services-one__shape-1">
                                    <img src="{{ url('front/assets/images/shapes/services-one-shape-1.png') }}" alt="">
                                </div>
                                <div class="services-one__img-box">
                                    <div class="services-one__img">
                                        <img src="{{ url('front/assets/images/services/services1-2.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="services-one__content">
                                    <h3 class="services-one__title"><a href="laser-therapy.html">Sports
                                            Injury</a>
                                    </h3>
                                    <p class="services-one__text">Leedable is content of page when looking at layout
                                        the
                                        point using lorem the Ipsum less</p>
                                    <div class="services-one__btn-box">
                                        <a href="laser-therapy.html" class="services-one__btn thm-btn">Read
                                            More<span class="icon-right-arrow"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                        <!--Services One Single Start-->
                        <div class="swiper-slide">
                            <div class="services-one__single">
                                <div class="services-one__shape-1">
                                    <img src="{{ url('front/assets/images/shapes/services-one-shape-1.png') }}" alt="">
                                </div>
                                <div class="services-one__img-box">
                                    <div class="services-one__img">
                                        <img src="{{ url('front/assets/images/services/services1-3.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="services-one__content">
                                    <h3 class="services-one__title"><a href="physical-rehab.html">Physical Rehab</a></h3>
                                    <p class="services-one__text">Leedable is content of page when looking at layout the point using lorem the Ipsum less</p>
                                    <div class="services-one__btn-box">
                                        <a href="physical-rehab.html" class="services-one__btn thm-btn">Read More<span class="icon-right-arrow"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Services One Single End-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Services One End -->

    <!--About One Start -->
    <section class="about-one">
        <div class="about-one__shape-2 float-bob-x">
            <img src="{{ url('front/assets/images/shapes/about-one-shape-2.png') }}" alt="">
        </div>
        <div class="about-one__shape-3 float-bob-y">
            <img src="{{ url('front/assets/images/shapes/about-one-shape-3.png') }}" alt="">
        </div>
        <div class="about-one__shape-4 float-bob-x">
            <img src="{{ url('front/assets/images/shapes/about-one-shape-4.png') }}" alt="">
        </div>
        <div class="about-one__shape-5" style="background-image: url(front/assets/images/shapes/about-one-shape-5.png);">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-one__left wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                        <div class="about-one__img-box">
                            <div class="about-one__img">
                                <img src="{{ url('front/assets/images/resources/about-one-img-1.jpg') }}" alt="">
                            </div>
                            <div class="about-one__shape-1">
                                <img src="{{ url('front/assets/images/shapes/about-one-shape-1.png') }}" alt="">
                            </div>
                            <div class="about-one__img-2">
                                <img src="{{ url('front/assets/images/resources/about-one-img-2.jpg') }}" alt="">
                                <div class="about-one__video-link">
                                    <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                        <div class="about-one__video-icon">
                                            <span class="icon-play"></span>
                                            <i class="ripple"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-one__right">
                        <div class="section-title text-left">
                            <div class="section-title__tagline-box">
                                <div class="section-title__tagline-shape-1"></div>
                                <span class="section-title__tagline">About Us</span>
                            </div>
                            <h2 class="section-title__title">Explore Our Physiotherapy<br> and Chiropractic Clinic
                            </h2>
                        </div>
                        <p class="about-one__text">It is a long established fact that a reader will be distracted
                            the readable content of a page when looking at layout the point of using lorem the Ipsum
                            less normal distribution of letters.</p>
                        <div class="about-one__points-box">
                            <ul class="about-one__points list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="icon-check"></span>
                                    </div>
                                    <p>Chiropractic Therapy</p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-check"></span>
                                    </div>
                                    <p>Medicine & Instrument</p>
                                </li>
                            </ul>
                            <ul class="about-one__points about-one__points-2 list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="icon-check"></span>
                                    </div>
                                    <p>High Quality Care</p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-check"></span>
                                    </div>
                                    <p>Expert Therapist</p>
                                </li>
                            </ul>
                        </div>
                        <div class="about-one__client-and-call-box">
                            <div class="about-one__client-box">
                                <div class="about-one__client-img">
                                    <img src="{{ url('front/assets/images/resources/about-one-client-img.jpg') }}" alt="">
                                </div>
                                <div class="about-one__client-content">
                                    <h3>Leslie Alexander</h3>
                                    <p>CEO, Chirofind</p>
                                </div>
                            </div>
                            <div class="about-one__call-box">
                                <div class="icon">
                                    <span class="icon-phone"></span>
                                </div>
                                <div class="content">
                                    <p>Call Us Now</p>
                                    <h3><a href="tel:+2085550112">+208-555-0112</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About One End -->

    <!--Our Offering Start -->
    <section class="our-offering">
        <div class="our-offering__bg" style="background-image: url(front/assets/images/backgrounds/our-offering-bg.jpg);">
        </div>
        <div class="our-offering__bg-box-2"></div>
        <div class="our-offering__bg-box">
            <div class="our-offering__bg-shape" style="background-image: url(front/assets/images/shapes/our-offering-bg-shape.jpg);"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="our-offering__left">
                        <div class="section-title text-left">
                            <div class="section-title__tagline-box">
                                <div class="section-title__tagline-shape-1"></div>
                                <span class="section-title__tagline">Our Offering</span>
                            </div>
                            <h2 class="section-title__title">The Ailments Addressed by <br>Chiropractors.</h2>
                        </div>
                        <p class="our-offering__text">We denounce with righteous indignation and dislike men who
                            <br> beguiled and demoralized by the charms of pleasure.</p>
                        <div class="our-offering__timer-box">
                            <div class="timer-box">
                                <div class="countdown-timer">
                                    <div class="default-coundown">
                                        <div class="box">
                                            <div class="countdown time-countdown" data-countdown-time="2025/05/09">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="our-offering__btn-box">
                            <a href="appointment.html" class="our-offering__btn thm-btn">Appointment Now<span
                                    class="icon-right-arrow"></span></a>
                        </div>
                        <div class="our-offering__video-link">
                            <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                <div class="our-offering__video-icon">
                                    <span class="icon-play"></span>
                                    <i class="ripple"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Our Offering End -->

    <!--Team One Start -->
    <section class="team-one">
        <div class="team-one__shape-1 float-bob-x">
            <img src="front/assets/images/shapes/team-one-shape-1.png" alt="">
        </div>
        <div class="team-one__shape-2 float-bob-y">
            <img src="front/assets/images/shapes/team-one-shape-2.png" alt="">
        </div>
        <div class="team-one__shape-3 float-bob-x">
            <img src="front/assets/images/shapes/team-one-shape-3.png" alt="">
        </div>
        <div class="team-one__shape-4 float-bob-y">
            <img src="front/assets/images/shapes/team-one-shape-4.png" alt="">
        </div>
        <div class="team-one__shape-5 zoominout">
            <img src="front/assets/images/shapes/team-one-shape-5.png" alt="">
        </div>
        <div class="container">
            <div class="team-one__top">
                <div class="team-one__left">
                    <div class="section-title text-left">
                        <div class="section-title__tagline-box">
                            <div class="section-title__tagline-shape-1"></div>
                            <span class="section-title__tagline">Our Therapists</span>
                        </div>
                        <h2 class="section-title__title">High Qualified Therapist</h2>
                    </div>
                </div>
                <div class="team-one__btn-box">
                    <a href="team1.html" class="team-one__btn thm-btn">All Therapist<span class="icon-right-arrow"></span></a>
                </div>
            </div>
            <div class="row">
                <!--Team one Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="team-one__single">
                        <div class="team-one__img-box">
                            <div class="team-one__img">
                                <img src="front/assets/images/team/team-1-1.jpg" alt="">
                            </div>
                        </div>
                        <div class="team-one__content">
                            <h3 class="team-one__title"><a href="team-details.html">Marvin McKinney</a></h3>
                            <p class="team-one__sub-title">Senior Therapist</p>
                            <div class="team-one__social">
                                <a href="team-details.html"><span class="icon-facebook"></span></a>
                                <a href="team-details.html"><span class="icon-instagram"></span></a>
                                <a href="team-details.html"><span class="icon-twitter"></span></a>
                                <a href="team-details.html"><span class="icon-pinterest"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Team one Single End-->
                <!--Team one Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__single">
                        <div class="team-one__img-box">
                            <div class="team-one__img">
                                <img src="front/assets/images/team/team-1-2.jpg" alt="">
                            </div>
                        </div>
                        <div class="team-one__content">
                            <h3 class="team-one__title"><a href="team-details.html">Leslie Alexander</a></h3>
                            <p class="team-one__sub-title">Physical Therapist</p>
                            <div class="team-one__social">
                                <a href="team-details.html"><span class="icon-facebook"></span></a>
                                <a href="team-details.html"><span class="icon-instagram"></span></a>
                                <a href="team-details.html"><span class="icon-twitter"></span></a>
                                <a href="team-details.html"><span class="icon-pinterest"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Team one Single End-->
                <!--Team one Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInRight" data-wow-delay="300ms">
                    <div class="team-one__single">
                        <div class="team-one__img-box">
                            <div class="team-one__img">
                                <img src="front/assets/images/team/team-1-3.jpg" alt="">
                            </div>
                        </div>
                        <div class="team-one__content">
                            <h3 class="team-one__title"><a href="team-details.html">Leslie Alexander</a></h3>
                            <p class="team-one__sub-title">Acupuncture Therapist</p>
                            <div class="team-one__social">
                                <a href="team-details.html"><span class="icon-facebook"></span></a>
                                <a href="team-details.html"><span class="icon-instagram"></span></a>
                                <a href="team-details.html"><span class="icon-twitter"></span></a>
                                <a href="team-details.html"><span class="icon-pinterest"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Team one Single End-->
            </div>
        </div>
    </section>
    <!--Team One End -->

    <!--Testimonial One Start -->
    <section class="testimonial-one">
        <div class="testimonial-one__bg-img" style="background-image: url(front/assets/images/backgrounds/testimonial-one-bg-img.jpg);"></div>
        <div class="testimonial-one__shape-1" style="background-image: url(front/assets/images/shapes/testimonial-one-shape-1.png);"></div>
        <div class="testimonial-one__shape-2 float-bob-x">
            <img src="front/assets/images/shapes/testimonial-one-shape-2.png" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="testimonial-one__left">
                        <div class="testimonial-one__form-inner">
                            <div class="section-title text-left">
                                <div class="section-title__tagline-box">
                                    <div class="section-title__tagline-shape-1"></div>
                                    <span class="section-title__tagline">Book Appointment</span>
                                </div>
                                <h2 class="section-title__title">Book Now An Appointment</h2>
                            </div>
                            <form class="contact-form-validated testimonial-one__form"
                                  action="https://figtheme.com/html/chirofind/assets/inc/sendemail.php" method="post" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="testimonial-one__input-box">
                                            <h4 class="testimonial-one__input-box-title">Full name*</h4>
                                            <input type="text" name="name" placeholder="Robot fox" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="testimonial-one__input-box">
                                            <h4 class="testimonial-one__input-box-title">Email Address*</h4>
                                            <input type="email" name="email" placeholder="info@example.com"
                                                   required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="testimonial-one__input-box">
                                            <h4 class="testimonial-one__input-box-title">Type Of Service*</h4>
                                            <div class="select-box">
                                                <select class="selectmenu wide">
                                                    <option selected="selected">Select</option>
                                                    <option>Type Of Service 01</option>
                                                    <option>Type Of Service 02</option>
                                                    <option>Type Of Service 03</option>
                                                    <option>Type Of Service 04</option>
                                                    <option>Type Of Service 05</option>
                                                    <option>Type Of Service 06</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="testimonial-one__input-box">
                                            <h4 class="testimonial-one__input-box-title">Select Date*</h4>
                                            <div class="testimonial-one__input-box-icon">
                                                <span class="icon-calender"></span>
                                            </div>
                                            <input type="text" name="date" placeholder="Select Date"
                                                   id="datepicker">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="testimonial-one__input-box text-message-box">
                                            <h4 class="testimonial-one__input-box-title">Message*</h4>
                                            <textarea name="message" placeholder="Type here..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="testimonial-one__btn-box">
                                            <button type="submit" class="thm-btn testimonial-one__btn">Request a
                                                quote<span class="icon-right-arrow"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="result"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="testimonial-one__right">
                        <div class="section-title text-left">
                            <div class="section-title__tagline-box">
                                <div class="section-title__tagline-shape-1"></div>
                                <span class="section-title__tagline">Testimonials</span>
                            </div>
                            <h2 class="section-title__title">See Our Clients Feedback</h2>
                        </div>
                        <p class="testimonial-one__text">Nulla blandit semper convallis. Integer vitae erat at neque
                            dapibus viverra eget vestibulum metus. Cras gravida sapien lectus, eu ultrices dolor
                            egestas vitae. Morbi lorem lacus, porttitor nec.</p>
                        <div class="testimonial-one__carrosel-box">
                            <div class="testimonial-carousel-one swiper-container">
                                <div class="swiper-wrapper">
                                    <!--Testimonial One Single Start-->
                                    <div class="swiper-slide">
                                        <div class="testimonial-one__single">
                                            <div class="testimonial-one__quote-icon">
                                                <img src="front/assets/images/icon/quote-icon.png" alt="">
                                            </div>
                                            <div class="testimonial-one__client-info">
                                                <div class="testimonial-one__client-img">
                                                    <img src="front/assets/images/testimonial/testimonial-1-1.jpg" alt="">
                                                </div>
                                                <div class="testimonial-one__client-content">
                                                    <h3><a href="#">Albert Flores</a></h3>
                                                    <p>Web Designer</p>
                                                    <div class="testimonial-one__ratting">
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star icon-star-last"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="testimonial-one__single-text">Penatibus et magnis dis
                                                parturient montes, nascetur ridiculus mus. Ut id lorem ac enim
                                                vestibulum blandit nec sit amet felis. Fusce quis diam odio. Cras
                                                mattis mi quis tincidunt</p>
                                        </div>
                                    </div>
                                    <!--Testimonial One Single End-->
                                    <!--Testimonial One Single Start-->
                                    <div class="swiper-slide">
                                        <div class="testimonial-one__single">
                                            <div class="testimonial-one__quote-icon">
                                                <img src="front/assets/images/icon/quote-icon.png" alt="">
                                            </div>
                                            <div class="testimonial-one__client-info">
                                                <div class="testimonial-one__client-img">
                                                    <img src="front/assets/images/testimonial/testimonial-1-2.jpg" alt="">
                                                </div>
                                                <div class="testimonial-one__client-content">
                                                    <h3><a href="#">Kathryn Murphy</a></h3>
                                                    <p>Scrum Master</p>
                                                    <div class="testimonial-one__ratting">
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star icon-star-last"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="testimonial-one__single-text">Penatibus et magnis dis
                                                parturient montes, nascetur ridiculus mus. Ut id lorem ac enim
                                                vestibulum blandit nec sit amet felis. Fusce quis diam odio. Cras
                                                mattis mi quis tincidunt</p>
                                        </div>
                                    </div>
                                    <!--Testimonial One Single End-->
                                </div>
                            </div>
                        </div>
                        <!-- If we need navigation buttons -->
                        <div class="testimonial-one__nav">
                            <div class="swiper-button-prev">
                                <i class="icon-angle-right"></i>
                            </div>
                            <div class="swiper-button-next">
                                <i class="icon-angle-left"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Testimonial One End -->

    <!--Blog One Start -->
    <section class="blog-one">
        <div class="blog-one__shape-1 float-bob-x">
            <img src="front/assets/images/shapes/blog-one-shape-1.png" alt="">
        </div>
        <div class="blog-one__shape-2 float-bob-y">
            <img src="front/assets/images/shapes/blog-one-shape-2.png" alt="">
        </div>
        <div class="blog-one__shape-3 float-bob-y">
            <img src="front/assets/images/shapes/blog-one-shape-3.png" alt="">
        </div>
        <div class="blog-one__shape-4 float-bob-x">
            <img src="front/assets/images/shapes/blog-one-shape-4.png" alt="">
        </div>
        <div class="container">
            <div class="blog-one__top">
                <div class="section-title text-left">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape-1"></div>
                        <span class="section-title__tagline">Blog & News</span>
                    </div>
                    <h2 class="section-title__title">Our Latest News</h2>
                </div>
                <div class="blog-one__btn-box">
                    <a href="blog.html" class="blog-one__btn thm-btn">View More<span
                            class="icon-right-arrow"></span></a>
                </div>
            </div>
            <div class="row">
                <!--Blog One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-duration=".9s" data-wow-delay="100ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img-box">
                            <div class="blog-one__img">
                                <img src="front/assets/images/blog/blog-1-1.jpg" alt="@@title">
                                <img src="front/assets/images/blog/blog-1-1.jpg" alt="@@title">
                                <a href="blog-details.html" class="blog-one__link"><span class="sr-only"></span></a>
                            </div>
                            <div class="blog-one__date">
                                <p>12<br>
                                    <span>Dec</span></p>
                            </div>
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="far fa-user fa-fw"></span>
                                    </div>
                                    <a href="blog-details.html">By Admin</a>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-comments"></span>
                                    </div>
                                    <a href="blog-details.html">0 Comments</a>
                                </li>
                            </ul>
                            <h3 class="blog-one__title"><a href="blog-details.html">Fixing Tailbone Back Problems
                                    Possible</a></h3>
                            <a href="blog-details.html" class="blog-one__read-more">read More<span
                                    class="icon-right-arrow"></span></a>
                        </div>
                    </div>
                </div>
                <!--Blog One Single End-->
                <!--Blog One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-duration=".9s" data-wow-delay="300ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img-box">
                            <div class="blog-one__img">
                                <img src="front/assets/images/blog/blog-1-2.jpg" alt="@@title">
                                <img src="front/assets/images/blog/blog-1-2.jpg" alt="@@title">
                                <a href="blog-details.html" class="blog-one__link"><span class="sr-only"></span></a>
                            </div>
                            <div class="blog-one__date">
                                <p>15<br><span>Dec</span></p>
                            </div>
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="far fa-user fa-fw"></span>
                                    </div>
                                    <a href="blog-details.html">By Admin</a>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-comments"></span>
                                    </div>
                                    <a href="blog-details.html">0 Comments</a>
                                </li>
                            </ul>
                            <h3 class="blog-one__title"><a href="blog-details.html">How to Remedy Tailbone Back Problems</a></h3>
                            <a href="blog-details.html" class="blog-one__read-more">read More<span class="icon-right-arrow"></span></a>
                        </div>
                    </div>
                </div>
                <!--Blog One Single End-->
                <!--Blog One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-duration=".9s" data-wow-delay="600ms">
                    <div class="blog-one__single">
                        <div class="blog-one__img-box">
                            <div class="blog-one__img">
                                <img src="front/assets/images/blog/blog-1-3.jpg" alt="@@title">
                                <img src="front/assets/images/blog/blog-1-3.jpg" alt="@@title">
                                <a href="blog-details.html" class="blog-one__link"><span class="sr-only"></span></a>
                            </div>
                            <div class="blog-one__date">
                                <p>17<br><span>Dec</span></p>
                            </div>
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="far fa-user fa-fw"></span>
                                    </div>
                                    <a href="blog-details.html">By Admin</a>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-comments"></span>
                                    </div>
                                    <a href="blog-details.html">0 Comments</a>
                                </li>
                            </ul>
                            <h3 class="blog-one__title"><a href="blog-details.html">How to Address Tailbone Back Problems</a></h3>
                            <a href="blog-details.html" class="blog-one__read-more">read More<span class="icon-right-arrow"></span></a>
                        </div>
                    </div>
                </div>
                <!--Blog One Single End-->
            </div>
        </div>
    </section>
    <!--Blog One End -->

    <!--Brand One Start-->
    <section class="brand-one">
        <div class="container">
            <div class="brand-carousel-one swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-1.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-2.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-2.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-3.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-3.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-4.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-4.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-5.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-5.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-1.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-1.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-2.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-2.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-3.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-3.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-4.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-4.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="swiper-slide__img">
                            <img src="front/assets/images/brand/brand-1-5.png" alt="">
                        </div>
                        <div class="swiper-slide__hover-img">
                            <img src="front/assets/images/brand/brand-hover-1-5.png" alt="">
                        </div><!-- /.swiper-slide -->
                    </div><!-- /.swiper-slide -->
                </div>
            </div>
        </div>
    </section>
    <!--Brand One End-->

    <!--CTA One Start-->
    <section class="cta-one">
        <div class="container">
            <div class="cta-one__inner wow fadeInUp" data-wow-duration=".9s" data-wow-delay="300ms">
                <div class="cta-one__shape-1 float-bob-x">
                    <img src="front/assets/images/shapes/cta-one-shape-1.png" alt="">
                </div>
                <div class="cta-one__shape-2">
                    <img src="front/assets/images/shapes/cta-one-shape-2.png" alt="">
                </div>
                <div class="cta-one__shape-3">
                    <img src="front/assets/images/shapes/cta-one-shape-3.png" alt="">
                </div>
                <h3 class="cta-one__title">Subscribe for Any Update
                    <br> Information</h3>
                <div class="cta-one__from-box">
                    <form class="cta-one__form">
                        <div class="cta-one__input-box">
                            <input type="email" placeholder="Enter Email Address" name="email">
                            <button type="submit" class="cta-one__btn thm-btn">Subscribe Us</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--CTA One End-->

    <!--Site Footer Start-->
    <footer class="site-footer">
        <div class="site-footer__shape-1">
            <img src="front/assets/images/shapes/site-footer-shape-1.png" alt="">
        </div>
        <div class="site-footer__shape-2">
            <img src="front/assets/images/shapes/site-footer-shape-2.png" alt="">
        </div>
        <div class="site-footer__top">
            <div class="container">
                <div class="site-footer__top-inner">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                            <div class="footer-widget__column footer-widget__about">
                                <div class="site-logo footer-widget__logo">
                                    <a href="index.html"><img src="front/assets/images/resources/logo-1.svg" alt=""></a>
                                </div>
                                <p class="footer-widget__about-text">Phasellus ultricies aliquam volutpat
                                    ullamcorper laoreet neque, a lacinia
                                    curabitur lacinia mollis</p>
                                <div class="site-footer__social">
                                    <a href="#"><i class="icon-facebook"></i></a>
                                    <a href="#"><i class="icon-twitter"></i></a>
                                    <a href="#"><i class="icon-link-in"></i></a>
                                    <a href="#"><i class="icon-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                            <div class="footer-widget__column footer-widget__quick-link">
                                <div class="footer-widget__title-box">
                                    <h3 class="footer-widget__title">Quick Links</h3>
                                </div>
                                <ul class="footer-widget__quick-link-list list-unstyled">
                                    <li><a href="about.html"><span class="icon-andle-dabble"></span>About Us</a></li>
                                    <li><a href="team1.html"><span class="icon-andle-dabble"></span>Our Team</a></li>
                                    <li><a href="pricing.html"><span class="icon-andle-dabble"></span>Our Pricing</a></li>
                                    <li><a href="appointment.html"><span class="icon-andle-dabble"></span>Appointment</a></li>
                                    <li><a href="contact.html"><span class="icon-andle-dabble"></span>Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                            <div class="footer-widget__column footer-widget__services">
                                <div class="footer-widget__title-box">
                                    <h3 class="footer-widget__title">Our Services</h3>
                                </div>
                                <ul class="footer-widget__quick-link-list list-unstyled">
                                    <li><a href="chiropractic-care.html"><span class="icon-andle-dabble"></span>Chiropractic Therapy</a></li>
                                    <li><a href="massages-therapy.html"><span class="icon-andle-dabble"></span>Massage Therapy</a></li>
                                    <li><a href="trained-therapists.html"><span class="icon-andle-dabble"></span>Trained Therapists</a></li>
                                    <li><a href="laser-therapy.html"><span class="icon-andle-dabble"></span>Low Level Laser</a></li>
                                    <li><a href="laser-therapy.html"><span class="icon-andle-dabble"></span>Acupuncture</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                            <div class="footer-widget__column footer-widget__contact">
                                <div class="footer-widget__title-box">
                                    <h3 class="footer-widget__title">Contact Info</h3>
                                </div>
                                <ul class="footer-widget__contact-list list-unstyled">
                                    <li>
                                        <div class="icon">
                                            <span class="icon-pin"></span>
                                        </div>
                                        <div class="content">
                                            <span>Location:</span>
                                            <p>4517 Washington. mg Manchester,<br> Kentucky 39495</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-clock"></span>
                                        </div>
                                        <div class="content">
                                            <span>Opening Hours:</span>
                                            <p>Mon - Sat: 10.00 AM - 4.00 PM</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-phone"></span>
                                        </div>
                                        <div class="content">
                                            <span>Phone Call:</span>
                                            <p>
                                                <a href="tel:20866660112">208-6666-0112, </a>
                                                <a href="tel:30855550113">308-5555-0113</a>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="container">
                <div class="site-footer__bottom-inner">
                    <p class="site-footer__bottom-text">© All Copyright 2024 by Chirofind</p>
                    <ul class="list-unstyled site-footer__bottom-menu">
                        <li><a href="about.html">Trams & Condition</a></li>
                        <li><a href="about.html">Privacy Policy</a></li>
                    </ul>
                    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fas fa-arrow-up"></i></a>
                </div>
            </div>
        </div>
    </footer>
</div><!-- /.page-wrapper -->

<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

        <div class="logo-box">
            <a href="index.html" aria-label="logo image"><img src="front/assets/images/resources/logo-1.html" width="150" alt="" /></a>
        </div>
        <!-- /.logo-box -->
        <div class="mobile-nav__container"></div>
        <!-- /.mobile-nav__container -->

        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:needhelp@chirofind.com">needhelp@chirofind.com</a>
            </li>
            <li>
                <i class="fa fa-phone-alt"></i>
                <a href="tel:+208-555-0112">+208-555-0112</a>
            </li>
        </ul><!-- /.mobile-nav__contact -->
        <div class="mobile-nav__top">
            <div class="mobile-nav__social">
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-facebook-square"></a>
                <a href="#" class="fab fa-pinterest-p"></a>
                <a href="#" class="fab fa-instagram"></a>
            </div>
        </div><!-- /.mobile-nav__top -->
        <div class="main-menu__btn-box-outer">
            <div class="main-menu__btn-box">
                <a href="appointment.html" class="main-menu__btn thm-btn">
                    Appointment Now
                    <span class="icon-right-arrow"></span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /.mobile-nav__wrapper -->

<!-- search popup start-->
<div class="td-search-popup" id="td-search-popup">
    <form action="#" class="search-form">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search....." />
        </div>
        <button type="submit" class="submit-btn">
            <i class="icon-search"></i>
        </button>
    </form>
</div>
<!-- search popup end-->
<div class="body-overlay" id="body-overlay"></div>

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
<script src="{{ url('front/assets/vendors/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/sidebar-content/jquery-sidebar-content.js') }}"></script>
<script src="{{ url('front/assets/vendors/countdown/countdown.min.js') }}"></script>
<script src="{{ url('front/assets/vendors/twenty-twenty/twentytwenty.js') }}"></script>
<script src="{{ url('front/assets/vendors/twenty-twenty/jquery.event.move.js') }}"></script>
<!-- template js -->
<script src="{{ url('front/assets/js/chirofind.js') }}"></script>
</body>

</html>
