@extends('layouts.landing')
@section('content')
    <!-- Hero Section -->
    <section class="about-hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 pe-5 mt-5 mt-md-0">
                    <h1 class="text-white">Welcome to ThaGlobetrotters</h1>
                    <p class="fs-4 my-4 pb-2 sub-header">
                        Your Gateway to Unforgettable Adventures Around the Globe
                    </p>
                    <div>
                        <a href="{{url('/packages')}}" class="btn btn-primary-inverse">See Packages</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- About Text -->
            <div class="col-lg-8">
                <h2 class="mb-4">Our Story</h2>
                <p class="lead">Founded in 2015 by passionate travelers Kim and her team of adventure enthusiasts,
                    ThaGlobetrotters was born from a simple dream: to make the world more accessible, exciting, and
                    connected for everyone. What started as a small Michigan-based travel advisory has grown into a global
                    tour operator specializing in curated experiences that blend culture, nature, and thrill.</p>
                <p>With roots in the heart of the Great Lakes, we've taken our love for road trips and epic cruises to
                    destinations far and wide—from the savannas of East Africa to the beaches of Thailand. Over the years,
                    we've organized thousands of tours, creating memories that last a lifetime. Our commitment? Sustainable
                    travel that respects local communities and the planet we explore.</p>

                <div class="row mt-5">
                    <div class="col-md-4 text-center mb-4">
                        <h3 class="text-primary">10+</h3>
                        <p class="fw-bold">Years of Experience</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <h3 class="text-primary">50+</h3>
                        <p class="fw-bold">Destinations</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <h3 class="text-primary">10,000+</h3>
                        <p class="fw-bold">Happy Travelers</p>
                    </div>
                </div>

                <h2 class="mt-5 mb-4">Our Mission</h2>
                <p>At ThaGlobetrotters, we believe travel is more than just a trip—it's a transformation. We craft tours
                    that immerse you in authentic experiences, from wildlife safaris in Uganda's Queen Elizabeth National
                    Park to cultural immersions in Italy's historic villages. Our expert guides, many of whom are local
                    storytellers, ensure every journey is safe, enriching, and fun.</p>

                <blockquote class="blockquote border-start border-primary ps-4">
                    <p class="mb-0">"Travel far enough, you meet yourself." – Inspired by our founder Kim</p>
                </blockquote>
            </div>

            <!-- Image Placeholder (replace with real image) -->
            <div class="col-lg-4">
                <img src="{{asset('assets/img/about-img.png')}}" class="img-fluid rounded shadow"
                    alt="Our Team in Action" style="width: 100%; height: 400px;">
            </div>
        </div>


        <!-- Values Section -->
        <div class="row mt-5">
            <h2 class="text-center mb-5">Our Values</h2>
            <div class="col-12">
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bx bx-globe fs-5"></i>
                        </div>
                        <div>
                            <h5>Global Connection</h5>
                            <p>Bridging cultures through responsible tourism that supports local economies.</p>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bx bx-heart fs-5"></i>
                        </div>
                        <div>
                            <h5>Passion for Adventure</h5>
                            <p>Every tour is designed with heart, ensuring joy and discovery at every turn.</p>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bx bx-shield fs-5"></i>
                        </div>
                        <div>
                            <h5>Safety First</h5>
                            <p>Comprehensive insurance partnerships and expert guides keep you secure.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-3">Ready to Start Your Journey?</h2>
            <p class="mb-4">Join thousands of travelers who've discovered the world with us.</p>
            <a href="{{url('/packages')}}" class="btn btn-primary btn-lg me-3">Explore Tours</a>
            <a href="{{url('/contact')}}" class="btn btn-outline-primary btn-lg">Get in Touch</a>
        </div>
    </section>
@endsection
