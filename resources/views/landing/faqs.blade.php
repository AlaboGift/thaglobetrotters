@extends('layouts.landing')
@section('content')
    <section class="padding-medium">
        <div class="container">
            <h2>{{ $title }}</h2>
            <div class="row align-items-center mt-xl-3">
                <div class="accordion" id="faqAccordion">

                    <!-- 1. What is included in the tour price? -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                What is included in the tour price?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                The tour price includes everything listed under “What’s Included” on the tour page
                                (transportation, English-speaking guide, entrance fees, meals when specified, etc.).
                                Items listed under “Not Included” (international flights, travel insurance, personal
                                expenses,
                                gratuities, optional activities) are your responsibility.
                            </div>
                        </div>
                    </div>

                    <!-- 2. Do I need travel insurance? -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                Do I need travel insurance?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes — <strong>comprehensive travel insurance is mandatory</strong> for all our tours.
                                It must cover trip cancellation/interruption, medical expenses, and emergency evacuation.
                                You may be asked to show proof before the tour starts.
                            </div>
                        </div>
                    </div>

                    <!-- 3. Cancellation policy -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                What is your cancellation policy?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>More than 60 days before departure → Deposit only (non-refundable)</li>
                                    <li>59–30 days → 50% of total price</li>
                                    <li>29–15 days → 75% of total price</li>
                                    <li>14 days or less / no-show → 100% of total price</li>
                                </ul>
                                Some private or peak-season tours have stricter rules — always check your confirmation
                                email.
                            </div>
                        </div>
                    </div>

                    <!-- 4. Can I change my booking dates? -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq4">
                                Can I change my booking dates?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Date changes are treated as a cancellation + new booking, so standard cancellation fees
                                apply.
                                Contact us as early as possible — we’ll do our best to accommodate you with minimal or no
                                charge
                                when availability allows.
                            </div>
                        </div>
                    </div>

                    <!-- 5. What if you cancel the tour? -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq5">
                                What happens if the tour is cancelled by you?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                In case of cancellation by us (low participation, force majeure, etc.), you will receive a
                                <strong>full refund</strong> or an alternative tour of equal or higher value.
                                We are not responsible for any non-refundable flights or other arrangements you made.
                            </div>
                        </div>
                    </div>

                    <!-- 6. Visa & vaccinations -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq6">
                                Do I need a visa or specific vaccinations?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You are responsible for obtaining the correct visa and any required vaccinations.
                                We provide up-to-date information on each tour page, but requirements can change —
                                always verify with your embassy or a travel clinic.
                            </div>
                        </div>
                    </div>

                    <!-- 7. Children -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq7">
                                Are the tours suitable for children?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Most tours are family-friendly. Minimum age (if any) and child discounts are shown on the
                                tour page.
                                Just select the correct age when booking.
                            </div>
                        </div>
                    </div>

                    <!-- 8. Dietary / mobility needs -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq8">
                                Can you accommodate dietary requirements or disabilities?
                            </button>
                        </h2>
                        <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely! Please mention any dietary restrictions, allergies, or mobility needs when
                                booking.
                                We’ll do our best to accommodate (some remote areas have limitations).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
