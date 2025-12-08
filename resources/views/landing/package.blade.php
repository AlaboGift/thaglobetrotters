@extends('layouts.landing')
@section('content')

    <section class="py-5">
        <div class="container">
            <div class="row g-5">

                <!-- Left Column: Images + Details -->
                <div class="col-md-12">

                    <!-- Title + Rating -->
                    <h3 class="fw-bold mb-3">{{ $package->name }}</h3>
                    <div class="d-flex align-items-center mb-4">
                        <x-package-rating :package="$package" />&nbsp;Reviews
                    </div>

                    <!-- Hero Image + Small Thumbnails -->
                    <div class="row g-3 mb-5">
                        <div class="col-12 col-md-8">
                            <img src="{{ $package->getImageUrl() }}"
                                style="height: 389px; width: 100%; border-radius: 10px 0 0 10px;"
                                class="img-fluid shadow-sm hero-img rounded-left-3" alt="Zanzibar">
                        </div>
                        <div class="col-12 col-md-4">
                            <img src="{{ $package->getImageUrl() }}"
                                style="height: 186px; width: 100%; border-radius: 0 10px 0 0"
                                class="img-fluid small-img mb-3 shadow-sm" alt="Camel">
                            <img src="{{ $package->getImageUrl() }}"
                                style="height: 186px; width: 100%; border-radius: 0 0 10px 0;"
                                class="img-fluid small-img shadow-sm" alt="Desert">
                        </div>
                    </div>

                    <!-- Short Description -->
                    <p class="lead text-muted">
                        {!! $package->description !!}
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <hr />
                        <!-- Accordions -->
                        <div class="accordion accordion-flush" id="packageAccordion">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#included">
                                        What is included
                                    </a>
                                </h2>
                                <div id="included" class="accordion-collapse collapse" data-bs-parent="#packageAccordion">
                                    <div class="accordion-body">{!! $package->included !!}</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#excluded">
                                        What is not included
                                    </a>
                                </h2>
                                <div id="excluded" class="accordion-collapse collapse" data-bs-parent="#packageAccordion">
                                    <div class="accordion-body">{!! $package->excluded !!}</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#itinerary">
                                        Itinerary
                                    </a>
                                </h2>
                                <div id="itinerary" class="accordion-collapse collapse" data-bs-parent="#packageAccordion">
                                    <div class="accordion-body">
                                            <div class="itinerary-timeline">
                                                <ul class="list-unstyled">

                                                    <!-- Pickup Point -->
                                                    <li class="itinerary-item mb-4">
                                                        <div class="d-flex">
                                                            <div class="itinerary-icon bg-primary text-white">
                                                                <i class="bx bx-location-plus"></i>
                                                            </div>
                                                            <div class="itinerary-content ms-4">
                                                                <p class="mb-0 fw-semibold text-dark">You will get picked up
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- Dynamic Itinerary Items -->
                                                    @foreach ($package->itineraries as $index => $item)
                                                        <li class="itinerary-item mb-4">
                                                            <div class="d-flex">
                                                                <div class="itinerary-icon bg-success text-white">
                                                                    <span class="fw-bold">{{ $loop->iteration }}</span>
                                                                </div>
                                                                <div class="itinerary-content ms-4 flex-grow-1">
                                                                    <h6 class="mb-1 fw-bold text-primary">
                                                                        {{ $item->title }}</h6>
                                                                    <p class="mb-0 text-muted small lh-lg">
                                                                        {{ $item->description }}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                    <!-- Drop-off Point -->
                                                    <li class="itinerary-item">
                                                        <div class="d-flex">
                                                            <div class="itinerary-icon bg-danger text-white">
                                                                <i class="bx bx-home-smile"></i>
                                                            </div>
                                                            <div class="itinerary-content ms-4">
                                                                <p class="mb-0 fw-semibold text-dark">Return to starting
                                                                    point</p>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="price-box shadow-sm p-3">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h3 class="fw-bold">${{number_format($package->price)}}</h3>
                                    <small class="text-muted">per adult</small>
                                </div>
                            </div>

                            <div class="bg-light p-3 rounded mb-4">
                                <small class="text-muted">
                                    Start Date: <strong>{{\Carbon\Carbon::parse($package->start_date)->format('jS M, Y')}}</strong> 
                                        | End Date: <strong>{{\Carbon\Carbon::parse($package->end_date)->format('jS M, Y')}}</strong>
                                </small>
                            </div>

                            <div class="mb-4">
                                <select class="form-select form-select-lg rounded-pill" aria-label="Select travellers">
                                    <option selected>Select Travellers</option>
                                    <option value="1">1 Adult</option>
                                    <option value="2">2 Adults</option>
                                    <option value="3">3 Adults</option>
                                </select>
                            </div>

                            <button class="btn btn-primary text-white w-100 shadow-lg">
                                Pay Now
                            </button>
                        </div>
                    </div>

                </div>
                <!-- End Left Column -->

            </div>
        </div>
    </section>

    @if ($packages->count())
        <section class="padding-medium bg-primary-subtle">
            <div class="container">
                <h2>You might also like</h2>
                <div class="row align-items-center mt-xl-3">
                    @foreach ($packages as $package)
                        <x-package :package="$package" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonials Section -->
    <section class="padding-medium">
        <div class="container">
            <h2>Reviews</h2>
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
