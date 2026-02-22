<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thaglobetrotters</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('landing/icomoon/icomoon.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('landing/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>

<body>

    <div class="preloader-wrapper">
        <div class="preloader">
        </div>
    </div>

    <nav class="main-menu d-flex navbar navbar-expand-lg p-2 py-3 p-lg-4 py-lg-4 ">
        <div class="container-fluid">
            <div class="main-logo d-lg-none">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="img-fluid">
                </a>
            </div>

            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">

                <div class="offcanvas-header mt-3">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body justify-content-between">
                    <div class="main-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="img-fluid">
                        </a>
                    </div>

                    <ul class="navbar-nav menu-list list-unstyled align-items-lg-center d-flex gap-md-3 mb-0">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link mx-2 active">Home</a>
                        </li>

                        @foreach (App\Enums\CategoryType::selectables() as $categoryType)
                            <li class="nav-item dropdown">
                                <a class="nav-link mx-2 dropdown-toggle align-items-center" role="button"
                                    id="pages" data-bs-toggle="dropdown"
                                    aria-expanded="false">{{ ucwords(strtolower($categoryType)) }}</a>
                                <ul class="dropdown-menu" aria-labelledby="pages">
                                    @foreach (App\Models\General\Category::whereNotNull('parent_id')->where('category_type', $categoryType)->where('status', 'ACTIVE')->get() as $category)
                                        <li><a href="{{ '/packages?type=' . strtolower($categoryType) . '&category=' . $category->slug }}"
                                                class="dropdown-item">
                                                {{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach

                        {{-- <li class="nav-item">
                            <a href="{{'/packages?type=curated'}}" class="nav-link mx-2">Travel Packages</a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ '/package/custom' }}" class="nav-link mx-2">Custom Tour</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link mx-2">Become a Guide</a>
                        </li>
                    </ul>

                    <div class="d-none d-lg-flex align-items-center">
                        <ul class="d-flex  align-items-center list-unstyled m-0">
                            <li>
                                <a href="account.html" class="ms-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px">
                                        <use href="#user-circle" />
                                    </svg> </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
        <div class="container-fluid d-lg-none">
            <div class="d-flex  align-items-end mt-3">
                <ul class="d-flex  align-items-center list-unstyled m-0">
                    <li>
                        <a href="account.html" class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px">
                                <use href="#user-circle" />
                            </svg> </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container padding-medium ">
            <div class="row">
                <div class="col-sm-6 col-lg-4 my-3">
                    <div class="footer-menu">
                        <div>
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/logo-light.svg') }}" alt="logo"
                                    class="img-fluid">
                            </a>
                            <p class="sub-header">
                                Unforgettable international and domestic trips designed just for you
                            </p>
                        </div>
                        <div class="social-links mt-4">
                            <ul class="d-flex list-unstyled ">
                                <li class="me-4">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/fb-icon.svg') }}" alt="fb-logo"
                                            class="img-fluid">
                                    </a>
                                </li>
                                <li class="me-4">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/twitter-icon.svg') }}" alt="twitter-logo"
                                            class="img-fluid">
                                    </a>
                                </li>
                                <li class="me-4">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/instagram-icon.svg') }}" alt="instagram-logo"
                                            class="img-fluid">
                                    </a>
                                </li>
                                <li class="me-4">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/email-icon.svg') }}" alt="email-logo"
                                            class="img-fluid">
                                    </a>
                                </li>
                                {{-- <li class="me-4">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/youtube-icon.svg') }}" alt="youtube-logo" class="img-fluid">
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2 my-3">
                    <div class="footer-menu">
                        <h5 class=" fw-bold mb-4 text-light">Quick Links</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item mb-2">
                                <a href="{{ url('/') }}" class="footer-link">Home</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="{{ url('/about') }}" class="footer-link">About us</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="{{ url('/packages') }}" class="footer-link">Packages</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="{{ url('/contact') }}" class="footer-link">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2 my-3">
                    <div class="footer-menu">
                        <h5 class=" fw-bold mb-4 text-light">Help Center</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item mb-2">
                                <a href="{{ url('/faqs') }}" class="footer-link">FAQs</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="{{ url('/terms') }}" class="footer-link">Terms & Conditions</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="{{ url('/privacy') }}" class="footer-link">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2 my-3">
                    <div class="footer-menu">
                        <h5 class=" fw-bold mb-4 text-light">Contact Us</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item mb-2">
                                <a href="mailto:info@thaglobetrotters.com"
                                    class="footer-link">info@thaglobetrotters.com</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="tel:+11045872445" class="footer-link">+11045872445</a>
                            </li>
                            <li class="menu-item mb-2">
                                <a href="#" class="footer-link">New York, USA</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer-bottom">
            <hr class="text-black-50 footer-divider">
            <div class="container">
                <div class="row py-3 text-center">
                    <p>© {{ date('Y') }} Thaglobetrotters. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('landing/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="{{ asset('landing/js/plugins.js') }}"></script>
    <script src="{{ asset('landing/js/script.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>

</html>
