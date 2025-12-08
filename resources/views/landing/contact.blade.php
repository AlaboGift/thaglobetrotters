@extends('layouts.landing')
@section('content')
    <section class="padding-medium">
        <div class="container">
            <div class="text-center">
                <h2>{{ $title }}</h2>
            </div>

            <div class="row align-items-center mt-xl-3">
                <p class="text-center text-muted mb-5">
                    Have a question about a tour or need help with your booking?<br>
                    Fill out the form below and we’ll get back to you within 24 hours (usually much faster!).
                </p>

                <!-- Success Message (hidden by default) -->
                <div class="alert alert-success d-none" id="successMessage" role="alert">
                    <strong>Thank you!</strong> Your message has been sent successfully. We'll reply soon!
                </div>

                <!-- Contact Form -->
                <form id="contactForm" action="" method="POST" novalidate>
                    @csrf <!-- Remove this line if not using Laravel -->

                    <div class="row g-4">

                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="John Doe">
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="john@example.com">
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>

                        <!-- Phone (optional) -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="+1 234 567 8900">
                        </div>

                        <!-- Tour / Subject -->
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Tour or Subject <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="" selected disabled>Choose one...</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Booking Question">Booking Question</option>
                                <option value="Group / Private Tour">Group or Private Tour</option>
                                <option value="Customization Request">Customization Request</option>
                                <option value="Payment Issue">Payment Issue</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="invalid-feedback">Please select a subject.</div>
                        </div>

                        <!-- Message -->
                        <div class="col-12">
                            <label for="message" class="form-label">Your Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="6" required
                                placeholder="Tell us how we can help you..."></textarea>
                            <div class="invalid-feedback">Please write your message.</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                Send Message
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
