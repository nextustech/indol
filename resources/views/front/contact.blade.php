@extends('layouts.front')

@section('content')


    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Contact Us</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">contact us</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Contact Start -->
    <div class="page-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp">
                        <!-- Icon Box Start -->
                         <div class="icon-box">
                            <img src="{{ url('front/images/icon-green-location.svg') }}" alt="">
                         </div>
                        <!-- Icon Box End -->

                        <!-- Contact Info Content Start -->
                        <div class="contact-info-content">
                            <h3>location</h3>
                            <p>24/11 Robert Road , New York , USA</p>
                        </div>
                        <!-- Contact Info Content End -->
                    </div>
                    <!-- Contact Info Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.25s">
                        <!-- Icon Box Start -->
                         <div class="icon-box">
                            <img src="{{ url('front/images/icon-green-mail.svg') }}" alt="">
                         </div>
                        <!-- Icon Box End -->

                        <!-- Contact Info Content Start -->
                        <div class="contact-info-content">
                            <h3>email</h3>
                            <p>info@indolia.com</p>
                            <p>contact@indolia.com</p>
                        </div>
                        <!-- Contact Info Content End -->
                    </div>
                    <!-- Contact Info Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.5s">
                        <!-- Icon Box Start -->
                         <div class="icon-box">
                            <img src="{{ url('front/images/icon-green-phone.svg') }}" alt="">
                         </div>
                        <!-- Icon Box End -->

                        <!-- Contact Info Content Start -->
                        <div class="contact-info-content">
                            <h3>phone</h3>
                            <p>(+01) 789 854 856</p>
                            <p>(+02) 895 867 781</p>
                        </div>
                        <!-- Contact Info Content End -->
                    </div>
                    <!-- Contact Info Item End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.75s">
                        <!-- Icon Box Start -->
                         <div class="icon-box">
                            <img src="{{ url('front/images/icon-green-hour.svg') }}" alt="">
                         </div>
                        <!-- Icon Box End -->

                        <!-- Contact Info Content Start -->
                        <div class="contact-info-content">
                            <h3>working hours</h3>
                            <p>Mon to Fri : 10:00 To 6:00</p>
                            <p>Sat : 10:00AM To 3:00PM</p>
                        </div>
                        <!-- Contact Info Content End -->
                    </div>
                    <!-- Contact Info Item End -->
                </div>
            </div>
        </div>
     </div>
    <!-- Page Contact End -->

    <!-- Contact Form Start -->
    <div class="contact-us-form">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Contact Us Image Start -->
                     <div class="contact-us-img">
                        <figure class="reveal image-anime">
                            <img src="{{ url('front/images/contact-us-img.jpg') }}" alt="">
                        </figure>
                     </div>
                    <!-- Contact Us Image End -->
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">contact us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque"><span>Get</span> In Touch With Us</h2>
                        </div>
                        <!-- Section Title End -->

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.submit') }}" class="wow fadeInUp" data-wow-delay="0.25s">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="name" class="form-control" id="fullname" placeholder="Enter Name" value="{{ old('name') }}" required="">
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email') }}" required="">
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="{{ old('phone') }}" required="">
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" value="{{ old('subject') }}" required="">
                                    @error('subject')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-5">
                                    <textarea name="message" class="form-control" id="msg" rows="5" placeholder="Your Message" required="">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn-default">send message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Form End -->

    <!-- Google Map Start -->
    <div class="google-map">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Google Map Iframe Start -->
                    <div class="google-map-iframe">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96737.10562045308!2d-74.08535042841811!3d40.739265258395164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1703158537552!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- Google Map Iframe End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map End -->


@endsection
