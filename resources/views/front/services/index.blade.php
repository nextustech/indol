@extends('layouts.front')

@section('title','Services')

@section('content')



    <div class="page-wrapper">


        <div class="stricky-header stricked-menu main-menu main-menu-two">
            <div class="sticky-header__content"></div>
        </div><!-- /.stricky-header -->

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(front/assets/images/backgrounds/page-header-bg.jpg);">
            </div>
            <div class="container">
                <div class="page-header__inner">
                    <h2>Services 01</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="index.html">Home</a></li>
                            <li><span class="icon-andle-dabble"></span></li>
                            <li>Services 01</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Services Page One Start-->
        <section class="page-content-wrapper services-page-one">
            <div class="services-page-one__shape-1 float-bob-x">
                <img src="assets/images/shapes/services-page-one-shape-1.png" alt="">
            </div>
            <div class="services-page-one__shape-2 float-bob-y">
                <img src="assets/images/shapes/services-page-one-shape-2.png" alt="">
            </div>
            <div class="services-page-one__shape-3 float-bob-x">
                <img src="assets/images/shapes/services-page-one-shape-3.png" alt="">
            </div>
            <div class="services-page-one__shape-4 float-bob-y">
                <img src="assets/images/shapes/services-page-one-shape-4.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <!--Services Two Single Start -->
                    @foreach ($services as $service)


                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="services-two__single">
                            <div class="services-two__img">
                                <img src="{{ $service->extraImageA }}" alt="">
                            </div>
                            <div class="services-two__content">
                                <h3 class="services-two__title"><a href="{{ route('frontServiceSingle', $service->slug) }}">{{ $service->title }}</a></h3>
                                <p class="services-two__text">{{ Str::limit($service->short_description, 64) }}</p>
                                <div class="services-two__icon">
                                    <span class="icon-trusted"></span>
                                </div>
                                <div class="services-two__btn-box">
                                    <a href="{{ route('frontServiceSingle', $service->slug) }}" class="services-two__btn thm-btn">Read More<span class="icon-right-arrow"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Services Two Single End -->
                @endforeach


                    <div class="blog-list__pagination">
                        <ul class="pg-pagination list-unstyled">
                            <li class="prev">
                                <a href="#" aria-label="prev"><i class="icon-prev"></i></a>
                            </li>
                            <li class="count active"><a href="#">01</a></li>
                            <li class="count"><a href="#">02</a></li>
                            <li class="count"><a href="#">03</a></li>
                            <li class="next">
                                <a href="#" aria-label="Next"><i class="icon-next"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Services Page One End-->


    </div><!-- /.page-wrapper -->


    <!-- /.mobile-nav__wrapper -->

    <!-- search popup start-->
    <div class="td-search-popup" id="td-search-popup">
        <form action="https://figtheme.com/html/chirofind/index.html" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search....." />
            </div>
            <button type="submit" class="submit-btn">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
    <!-- search popup end-->
    <div class="body-overlay" id="body-overlay"></div>


@endsection
