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
                                        <a href="{{ route('bookAppointment') }}" class="main-menu__btn thm-btn">
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
