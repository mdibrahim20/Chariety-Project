<!--===== MOBILE HEADER STARTS =======-->
<div class="mobile-header mobile-haeder1 d-block d-lg-none">
    <div class="container">
        <div class="col-12">
            <div class="mobile-header-elements">
                <div class="mobile-logo">
                    <a href={{ route('any', 'index') }}><img src="/img/logo/vl-logo-1.1.png" alt=""></a>
                </div>
                <div class="mobile-nav-icon dots-menu">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-sidebar mobile-sidebar1">
    <div class="logosicon-area">
        <div class="logos">
            <img src="/img/logo/vl-footer-logo-1.1.png" alt="">
        </div>
        <div class="menu-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="mobile-nav mobile-nav1">
        <ul class="mobile-nav-list nav-list1">
            <li><a href="#">Home </a>
                <ul class="sub-menu">
                    <li><a href={{ route('any', 'index') }}>Home One</a></li>
                    <li><a href={{ route('second', ['demo', 'index-2']) }}>Home Two</a></li>
                    <li><a href={{ route('second', ['demo', 'index-3']) }}>Home Three</a></li>
                    <li><a href={{ route('second', ['demo', 'index-4']) }}>Home Four</a></li>
                    <li><a href={{ route('second', ['demo', 'index-5']) }}>Home Five</a></li>
                </ul>
            </li>
            <li><a href={{ route('any', 'about') }}>About</a></li>
            <li><a href="#">Events</a>
                <ul class="sub-menu">
                    <li><a href={{ route('second', ['events', 'event']) }}>Events</a></li>
                    <li><a href={{ route('second', ['events', 'left']) }}>Events Left</a></li>
                    <li><a href={{ route('second', ['events', 'right']) }}>Events Right</a></li>
                    <li><a href={{ route('second', ['events', 'single']) }}>Events Single</a></li>
                </ul>
            </li>
            <li><a href="#">Blogs</a>
                <ul class="sub-menu">
                    <li><a href={{ route('second', ['blogs', 'blog']) }}>Blog</a></li>
                    <li><a href={{ route('second', ['blogs', 'left']) }}>Blog Left</a></li>
                    <li><a href={{ route('second', ['blogs', 'right']) }}>Blog Right</a></li>
                    <li><a href={{ route('second', ['blogs', 'single']) }}>Blog Single</a></li>
                </ul>
            </li>
            <li><a href="#">Pages</a>
                <ul class="sub-menu">
                    <li><a href={{ route('second', ['pages', 'service']) }}>Our Services</a></li>
                    <li><a href={{ route('second', ['pages', 'team']) }}>Our Volunteers</a></li>
                    <li><a href={{ route('second', ['pages', 'faq']) }}>FAQ</a></li>
                    <li><a href={{ route('second', ['pages', 'contact']) }}>Contact</a></li>
                    <li><a href={{ route('second', ['pages', '404']) }}>404</a></li>
                </ul>
            </li>
            <li><a href="#">Causes</a>
                <ul class="sub-menu">
                    <li><a href={{ route('second', ['causes', 'cause']) }}>Causes</a></li>
                    <li><a href={{ route('second', ['causes', 'left']) }}>Cause Left</a></li>
                    <li><a href={{ route('second', ['causes', 'right']) }}>Cause Right</a></li>
                    <li><a href={{ route('second', ['causes', 'single']) }}>Cause Single</a></li>
                </ul>
            </li>
        </ul>

        <div class="allmobilesection">
            <!-- btn -->
            <a href={{ route('second', ['pages', 'contact']) }} class="header-mobile-btn1">Get Started <span><i class="fa-solid fa-arrow-right"></i></span></a>

            <div class="vl-mobile-contact1">
                <h3 class="title">Contact Info</h3>
                <div class="footer1-contact-info">
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="tel:+3(924)4596512">+3(924)4596512</a>
                        </div>
                    </div>

                    <!-- single footer -->
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="mailto:info@example.com">info@example.com</a>
                        </div>
                    </div>

                    <!-- single footer -->
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="mailto:info@example.com">55 East Birchwood Ave.Brooklyn, <br> New York 11201,United States</a>
                        </div>
                    </div>


                    <div class="vl-mobile-contact1">
                        <h3 class="title">Social Links</h3>
                        <div class="social-links-mobile-menu">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== MOBILE HEADER STARTS =======-->
