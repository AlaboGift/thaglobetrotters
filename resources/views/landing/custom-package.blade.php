@extends('layouts.landing')
@section('content')
    <section class="padding-medium bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Design Your Dream Custom Tour</h2>
                <p class="lead text-muted">
                    Want a fully personalized itinerary? Private guide? Luxury lodges or budget stays?<br>
                    Tell us your vision and our expert team will craft the perfect trip just for you!
                </p>
            </div>

            <!-- Success Message -->
            <div class="alert alert-success d-none text-center" id="successMessage" role="alert">
                <strong>Thank you!</strong> Your custom tour request has been sent.
                We’ll reply with a tailored proposal within 24–48 hours.
            </div>

            <!-- Custom Package Form -->
            <form id="customPackageForm" action="" method="POST" novalidate>
                @csrf

                <div class="row g-4">

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required placeholder="John Doe">
                        <div class="invalid-feedback">Please enter your full name.</div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required placeholder="john@example.com">
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <!-- Passport Nationality -->
                    <div class="col-md-6">
                        <label for="nationality" class="form-label">Passport Nationality <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nationality" name="nationality"
                            value="{{ old('nationality') }}" required placeholder="e.g. United States, India, Germany">
                        <div class="invalid-feedback">Please enter your passport nationality.</div>
                    </div>

                    <!-- WhatsApp Number (with country code) -->
                    <div class="col-md-6">
                        <label for="whatsapp" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+ </span>
                            <input type="tel" class="form-control" id="whatsapp" name="whatsapp"
                                value="{{ old('whatsapp') }}" required placeholder="1 234 567 8900">
                        </div>
                        <div class="form-text">Include country code (we often reply faster on WhatsApp)</div>
                        <div class="invalid-feedback">Please enter your WhatsApp number.</div>
                    </div>

                    <!-- Travel Date (flexible or fixed) -->
                    <div class="col-md-6">
                        <label for="travel_date" class="form-label">Preferred Travel Dates <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="travel_date" name="travel_date"
                            value="{{ old('travel_date') }}" required
                            placeholder="e.g. June 2026, 10–20 Dec 2025, Flexible in 2026">
                        <div class="form-text">Exact dates or a month/year range is fine</div>
                    </div>

                    <!-- Number of Travelers -->
                    <div class="col-md-6">
                        <label for="travelers" class="form-label">Number of Travelers <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="travelers" name="travelers" min="1"
                            value="{{ old('travelers') ?: 2 }}" required>
                        <div class="invalid-feedback">Please enter the number of people.</div>
                    </div>

                    <!-- Tentative Budget -->
                    <div class="col-md-12">
                        <label for="budget" class="form-label">Tentative Budget (per person or total) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="budget" name="budget"
                                value="{{ old('budget') }}" required
                                placeholder="e.g. $2,500 per person, $10,000 total, Flexible">
                        </div>
                        <div class="form-text">This helps us suggest the best accommodations and experiences</div>
                    </div>

                    <!-- Additional Comments / Preferences -->
                    <div class="col-12">
                        <label for="comments" class="form-label">Travel Style, Preferences & Special Requests</label>
                        <textarea class="form-control" id="comments" name="comments" rows="8"
                            placeholder="travel style, type of accommodation, highlights or preferences or anything you think it’s important to mention)"></textarea>
                        <div class="form-text">The more details, the better we can tailor your dream trip!</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            Submit Custom Tour Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
