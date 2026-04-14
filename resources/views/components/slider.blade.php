<section class="main-slider">
    <div class="swiper-container banner-slider-one">
        <div class="swiper-wrapper">

            @foreach($sliders as $slider)

            <div class="swiper-slide">

                <div class="main-slider__img">
                    <img src="{{ $slider->image }}" alt="">
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="main-slider__content">

                                <div class="main-slider__sub-title-box">
                                    <div class="main-slider__sub-title-shape"></div>
                                    <p class="main-slider__sub-title">
                                        {{ $slider->sub_title }}
                                    </p>
                                </div>

                                <h2 class="main-slider__title">
                                    {{ $slider->title }} <br>
                                    <span>{{ $slider->highlight_word }}</span>
                                </h2>

                                <p class="main-slider__text">
                                    {{ $slider->description }}
                                </p>

                                @if($slider->button_text)
                                <div class="main-slider__btn-box">
                                    <a href="{{ $slider->button_link }}" class="main-slider__btn thm-btn">
                                        {{ $slider->button_text }}
                                        <span class="icon-right-arrow"></span>
                                    </a>
                                </div>
                                @endif

                                @if($slider->video_url)
                                <div class="main-slider__rounded-text">
                                    <a href="{{ $slider->video_url }}" class="video-popup main-slider__curved-circle-box">
                                        <div class="curved-circle-2">
                                            <span class="curved-circle--item">
                                                - play intro video - play intro video
                                            </span>
                                        </div>
                                        <div class="main-slider__icon">
                                            <span class="icon-play"></span>
                                        </div>
                                    </a>
                                </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>

            </div>

            @endforeach

        </div>

        <div class="swiper-pagination"></div>
    </div>
</section>
