@extends('layouts.landing')
@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 pe-5 mt-5 mt-md-0">
                    <h1 class="text-white">Explore the World with ThaGlobetrotters</h1>
                    <p class="fs-4 my-4 pb-2 sub-header">
                        Unforgettable international and domestic trips designed just for you
                    </p>
                    <div>
                        <x-search-form/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container">
            <h2>Explore the World</h2>
            <div class="row align-items-center mt-xl-3">
                @foreach ($worldPackages as $package)
                    <x-package :package="$package" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="padding-medium bg-primary-subtle">
        <div class="container">
            <h2>Explore Nigeria</h2>
            <div class="row align-items-center mt-xl-3">
                @foreach ($nigerianPackages as $package)
                    <x-package :package="$package" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="padding-medium">
        <div class="container">
            <h2>Top Destinations</h2>
            <div class="row align-items-center mt-xl-3">
                @foreach ($topDestinations as $top)
                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-5">
                        <a href="#" class="text-decoration-none">
                            <div class="card destination-card border-0 shadow-sm overflow-hidden">
                                <img src="{{ $top->image_url }}" class="card-img img-fluid" alt="Paris, France"
                                    style="height: 272px; width: 100%;">
                                <div class="card-img-overlay d-flex align-items-start p-4">
                                    <h5 class="text-white fw-bold fs-4 mb-0 shadow-text">
                                        {{ $top->name }}
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="padding-medium bg-primary-subtle">
        <div class="container">
            <h2>Popular Trips</h2>
            <div class="row align-items-center mt-xl-3">
                @foreach ($popularPackages as $package)
                    <x-package :package="$package" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="padding-medium">
        <div class="container">
            <h2>What Our Travelers Say</h2>
            <!-- Bootstrap Carousel -->
            <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <!-- Testimonial 1 -->
                    <div class="carousel-item active">
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-4 mb-4">
                                <div
                                    class="card border-0 shadow-sm h-100 p-4 p-md-5 text-center text-md-start bg-white rounded-4">
                                    <p class="card-text text-muted">
                                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                        veniam."
                                    </p>
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Daniella"
                                            class="rounded-circle me-3" width="60" height="60">
                                        <div>
                                            <h6 class="mb-0 fw-bold">Daniella</h6>
                                            <small class="text-muted">Traveller from Portland, USA</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div
                                    class="card border-0 shadow-sm h-100 p-4 p-md-5 text-center text-md-start bg-white rounded-4">
                                    <p class="card-text text-muted">
                                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua."
                                    </p>
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Idris"
                                            class="rounded-circle me-3" width="60" height="60">
                                        <div>
                                            <h6 class="mb-0 fw-bold">Idris</h6>
                                            <small class="text-muted">Traveller from Doha, Qatar</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div
                                    class="card border-0 shadow-sm h-100 p-4 p-md-5 text-center text-md-start bg-white rounded-4">
                                    <p class="card-text text-muted">
                                        "Incredible experience! The team planned everything perfectly. Highly
                                        recommend ThaGlobetrotters!"
                                    </p>
                                    <div class="d-flex align-items-center mt-4">
                                        <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="Sean"
                                            class="rounded-circle me-3" width="60" height="60">
                                        <div>
                                            <h6 class="mb-0 fw-bold">Sean</h6>
                                            <small class="text-muted">Traveller from London, UK</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Slide 1 -->

                    <!-- Add more carousel-item slides here if you want auto-rotation -->
                </div>

                <!-- Optional: Navigation arrows -->
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
@endsection
