@extends('layouts.front')

@section('title','Services')

@section('content')



    <div class="page-wrapper">

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url({{ url('front/assets/images/backgrounds/page-header-bg.jpg') }});">
            </div>
            <div class="container">
                <div class="page-header__inner">
                    <h2>{{ $service->title }}</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="index.html">Home</a></li>
                            <li><span class="icon-andle-dabble"></span></li>
                            <li><a href="services1.html">Services</a></li>
                            <li><span class="icon-andle-dabble"></span></li>
                            <li>{{ $service->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Services Details Start-->
        <section class="services-details">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="sidebar">
                            <div class="sidebar__single services-details__services-box">
                                <h3 class="sidebar__title">All Services</h3>
                                <ul class="services-details__services-list list-unstyled">
                                    @foreach ($services as $serviceItem)
                                    <li class="{{ request()->route('slug') == $serviceItem->slug ? 'active' : '' }}">
                                        <a href="{{ route('frontServiceSingle', $serviceItem->slug) }}">{{ $serviceItem->title }}<span class="icon-right-arrow"></span></a>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                            <div class="sidebar__single services-details__opeaning-hour">
                                <h3 class="sidebar__title">Opening Hours</h3>
                                <ul class="services-details__opeaning-list list-unstyled">
                                    <li>
                                        <p><span class="icon-clock"></span>Mon - Sat: 10.00 AM - 4.00 PM</p>
                                    </li>
                                    <li>
                                        <p><span class="icon-clock"></span>Sun: 09.00 AM - 4.00 PM</p>
                                    </li>
                                    <li>
                                        <p><span class="icon-clock"></span>Friday: Closed</p>
                                    </li>
                                    <li>
                                        <p><span class="icon-clock"></span>Emergency: 24 hours</p>
                                    </li>
                                </ul>
                                <div class="services-details__opeaning-btn-box">
                                    <a href="#" class="services-details__opeaning-btn thm-btn">All Therapist<span
                                            class="icon-right-arrow"></span></a>
                                </div>
                            </div>
                            <div class="sidebar__single services-details__need-help">
                                <div class="services-details__need-help-bg"
                                    style="background-image: url({{ url('front/assets/images/backgrounds/services-details-need-help-bg.jpg') }});">
                                </div>
                                <div class="services-details__need-help-icon">
                                    <span class="icon-call-2"></span>
                                </div>
                                <h3 class="services-details__need-help-title">Need Help? Call Here</h3>
                                <p class="services-details__need-help-call-number"><a
                                        href="tel:2085550112">+208-555-0112</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="services-details__right">
                            <div class="services-details__img">
                                <img src="{{ $service->main_image }}" alt="">
                            </div>
                            <div class="services-details__content">
                                <p class="services-details__text-1">{!! $service->description !!}</p>
                                <div class="services-details__img-box">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="services-details__img-box-img">
                                                <img src="{{ $service->extraImageA }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="services-details__img-box-img">
                                                <img src="{{ $service->extraImageB }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Services Details End-->




    </div><!-- /.page-wrapper -->



@endsection
