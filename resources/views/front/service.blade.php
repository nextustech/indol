@extends('layouts.front')

@section('title','Home')

@section('content')

    <!-- Page Header Start -->
	<div class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-2" data-cursor="-opaque">Services</h1>

					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->

    <!-- Page Services Start -->
    <div class="page-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp">
                        <div class="icon-box">
                            <img src="images/icon-service-1.svg" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Spinal Cord Injury Rehabilitation</h3>
                            <p>Comprehensive rehabilitation program for patients with spinal cord injuries, focusing on restoring mobility, strength, and independence through advanced therapeutic techniques.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-2.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Occupational Therapy</h3>
                            <p>Helping patients regain skills for daily living activities through personalized interventions, adaptive techniques, and environmental modifications.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-3.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Neuro Rehabilitation</h3>
                            <p>Specialized treatment for neurological conditions including stroke, Parkinson's, and multiple sclerosis, aimed at restoring neural function and improving quality of life.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.6s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-4.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Pediatrics Rehabilitation</h3>
                            <p>Child-friendly rehabilitation programs designed for infants and children with developmental delays, congenital conditions, and injuries to ensure optimal growth.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="0.8s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-5.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Sports Rehabilitation</h3>
                            <p>Expert care for sports injuries with focus on safe return to play, injury prevention, and performance enhancement for athletes of all levels.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="1s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-6.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Uro Rehabilitation</h3>
                            <p>Specialized therapy for urinary incontinence and pelvic floor dysfunction through targeted exercises and behavioral modifications.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="1.2s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-7.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Rheumatic Rehabilitation</h3>
                            <p>Integrated treatment for rheumatic diseases including arthritis, focusing on pain management, joint mobility, and functional preservation.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="1.4s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-8.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Vestibular Rehabilitation</h3>
                            <p>Treatment for balance disorders, vertigo, and dizziness through specialized exercises that retrain the vestibular system.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="1.6s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-1.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Geriatric Rehabilitation</h3>
                            <p>Comprehensive care for elderly patients focusing on fall prevention, mobility improvement, and maintaining independence in daily activities.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="1.8s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-2.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Post-Surgical Rehabilitation</h3>
                            <p>Specialized post-operative care for orthopedic, neuro, and general surgeries to accelerate recovery and restore function.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="2s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-3.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Cancer Rehabilitation</h3>
                            <p>Supportive care for cancer patients addressing fatigue, lymphedema, pain management, and functional restoration during and after treatment.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="2.2s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-4.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Posture Studio</h3>
                            <p>Assessment and correction of postural imbalances through ergonomic advice, strengthening exercises, and lifestyle modifications.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="2.4s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-5.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Low Back Pain</h3>
                            <p>Effective treatment for chronic and acute low back pain through manual therapy, exercises, and postural correction techniques.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="2.6s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-6.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Neck Pain</h3>
                            <p>Comprehensive therapy for neck pain and stiffness including cervical spine mobilization, strengthening, and ergonomic interventions.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="2.8s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-7.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Frozen Shoulder</h3>
                            <p>Specialized treatment for adhesive capsulitis focusing on joint mobilization, stretching, and strengthening to restore shoulder function.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="3s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-8.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Tennis Elbow</h3>
                            <p>Effective treatment for lateral epicondylitis through targeted exercises, manual therapy, and modalities to reduce pain and restore strength.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="3.2s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-1.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Plantar Fascitis</h3>
                            <p>Specialized therapy for heel pain including stretching, strengthening, orthotic advice, and gait analysis to ensure proper recovery.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="3.4s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-2.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Osteoarthritis</h3>
                            <p>Management of degenerative joint disease through exercise, manual therapy, pain management, and education to improve joint function.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="service-item wow fadeInUp" data-wow-delay="3.6s">
                        <div class="icon-box">
                            <img src="{{ url('front/images/icon-service-3.svg') }}" alt="">
                        </div>
                        <div class="service-body">
                            <h3>Rheumatoid Arthritis</h3>
                            <p>Comprehensive care for rheumatoid arthritis patients focusing on joint protection, pain management, and maintaining functional abilities.</p>
                        </div>
                        <div class="service-footer">
                            <a href="{{ route('bookAppointment') }}" class="service-btn"><img src="{{ url('front/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cta Infobar Section Start -->
            <div class="cta-infobar wow fadeInUp" data-wow-delay="0.5s">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <!-- Cta Content Start -->
                        <div class="cta-info-content">
                            <div class="icon-box">
                                <img src="{{ url('front/images/icon-cta.svg') }}" alt="">
                            </div>

                            <div class="cta-content">
                                <h3>ready to start your journey to recovery?</h3>
                                <p>Contact us today to schedule your initial consultation and take the first step towards a pain-free life.</p>
                            </div>
                        </div>
                        <!-- Cta Content End -->
                    </div>

                    <div class="col-lg-6">
                        <!-- Cta Appointment Button Start -->
                        <div class="cta-appointment-btn">
                            <a href="{{ route('bookAppointment') }}" class="btn-default">book appointment</a>
                        </div>
                        <!-- Cta Appointment Button End -->
                    </div>
                </div>
            </div>
            <!-- Cta Infobar Section End -->
        </div>
    </div>
    <!-- Page Services End -->

    <!-- Client Testimonial Start -->
    <div class="our-testimonial parallaxie">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">review</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque"><span>What</span> Our Client Say</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Testimonial Slider Start -->
                    <div class="testimonial-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper" data-cursor-text="Drag">
                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-header">
                                            <div class="testimonial-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-content">
                                                <p>We understand that injuries and acute pain can happen unexpectedly. Our emergency physiotherapy services are designed to provide prompt.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-body">
                                            <div class="author-image">
                                                <figure class="image-anime">
                                                    <img src="images/author-1.jpg" alt="">
                                                </figure>
                                            </div>
                                            <div class="author-content">
                                                <h3>johan duo</h3>
                                                <p>professional athlete</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-header">
                                            <div class="testimonial-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-content">
                                                <p>We understand that injuries and acute pain can happen unexpectedly. Our emergency physiotherapy services are designed to provide prompt.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-body">
                                            <div class="author-image">
                                                <figure class="image-anime">
                                                    <img src="images/author-2.jpg" alt="">
                                                </figure>
                                            </div>
                                            <div class="author-content">
                                                <h3>jane smith</h3>
                                                <p>retired teacher</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-header">
                                            <div class="testimonial-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-content">
                                                <p>We understand that injuries and acute pain can happen unexpectedly. Our emergency physiotherapy services are designed to provide prompt.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-body">
                                            <div class="author-image">
                                                <figure class="image-anime">
                                                    <img src="images/author-3.jpg" alt="">
                                                </figure>
                                            </div>
                                            <div class="author-content">
                                                <h3>robert lee</h3>
                                                <p>construction worker</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-header">
                                            <div class="testimonial-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-content">
                                                <p>We understand that injuries and acute pain can happen unexpectedly. Our emergency physiotherapy services are designed to provide prompt.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-body">
                                            <div class="author-image">
                                                <figure class="image-anime">
                                                    <img src="images/author-4.jpg" alt="">
                                                </figure>
                                            </div>
                                            <div class="author-content">
                                                <h3>banson doe</h3>
                                                <p>marathon runner</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial Slide End -->
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- Testimonial Slider End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Client Testimonial End -->

    <!-- Why Choose Us Start -->
    <div class="why-choose-us">
        <div class="container">
            <div class="row section-row">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">why us</h3>
                    <h2 class="text-anime-style-2" data-cursor="-opaque"><span>Excellence In</span> Care And Rehabilitation</h2>
                    </div>
                <!-- Section Title End -->
            </div>

            <!-- Why Choose Us Box Start -->
            <div class="why-choose-us-box">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-6">
                        <!-- Why Choose Box Start -->
                        <div class="why-choose-box-1">
                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="images/icon-why-us-1.svg" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Content Start -->
                                <div class="why-choose-content">
                                    <h3>experienced team</h3>
                                    <p>We understand that injuries and acute pain can  unexpectedly.</p>
                                </div>
                                <!-- Why Choose Content End -->
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.25s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="images/icon-why-us-2.svg" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Content Start -->
                                <div class="why-choose-content">
                                    <h3>patient-centered approach</h3>
                                    <p>We understand that injuries and acute pain can  unexpectedly.</p>
                                </div>
                                <!-- Why Choose Content End -->
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.5s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="images/icon-why-us-3.svg" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Content Start -->
                                <div class="why-choose-content">
                                    <h3>expertise and experience</h3>
                                    <p>We understand that injuries and acute pain can  unexpectedly.</p>
                                </div>
                                <!-- Why Choose Content End -->
                            </div>
                            <!-- Why Choose Item End -->
                        </div>
                        <!-- Why Choose Box End -->
                    </div>

                    <div class="col-lg-6">
                        <!-- Why Choose Box Start -->
                        <div class="why-choose-box-2">
                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="images/icon-why-us-4.svg" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Content Start -->
                                <div class="why-choose-content">
                                    <h3>advanced technology</h3>
                                    <p>We understand that injuries and acute pain can  unexpectedly.</p>
                                </div>
                                <!-- Why Choose Content End -->
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.25s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="images/icon-why-us-5.svg" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Content Start -->
                                <div class="why-choose-content">
                                    <h3>convenient and accessible</h3>
                                    <p>We understand that injuries and acute pain can  unexpectedly.</p>
                                </div>
                                <!-- Why Choose Content End -->
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.5s">
                                <!-- Icon Box Start -->
                                <div class="icon-box">
                                    <img src="images/icon-why-us-6.svg" alt="">
                                </div>
                                <!-- Icon Box End -->

                                <!-- Why Choose Content Start -->
                                <div class="why-choose-content">
                                    <h3>community involvement</h3>
                                    <p>We understand that injuries and acute pain can  unexpectedly.</p>
                                </div>
                                <!-- Why Choose Content End -->
                            </div>
                            <!-- Why Choose Item End -->
                        </div>
                        <!-- Why Choose Box End -->
                    </div>

                    <div class="col-lg-12">
                        <!-- Why Choose Image Start -->
                        <div class="why-choose-image">
                            <img src="images/why-us-img.png" alt="">
                        </div>
                        <!-- Why Choose Image End -->
                    </div>
                </div>
            </div>
            <!-- Why Choose Us Box End -->
        </div>
        </div>
    <!-- Why Choose Us End -->

    <!-- Our Scrolling Ticker Section Start -->
    <div class="our-scrolling-ticker">
        <!-- Scrolling Ticker Start -->
        <div class="scrolling-ticker-box">
            <div class="scrolling-content">
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">Emergency No. : +91 9760799933</span>
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">For any additional inqueries : dr.indoliaphysio@gmail.com</span>
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">Book Appointment: +91 90121 07107</span>
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">Working Hourse : Mon to Fri : 10:00 To 6:00 </span>
            </div>

            <div class="scrolling-content">
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">Phone No. : +91 9760799933</span>
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">For any additional inqueries : dr.indoliaphysio@gmail.com</span>
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">Book Appointment: +91 90121 07107</span>
                <span><img src="{{ url('front/images/icon-sparkles.svg') }}" alt="">Working Hourse : Mon to Fri : 9:00 To 6:00 </span>
            </div>
        </div>
    </div>
	<!-- Scrolling Ticker Section End -->


@endsection
