@extends('layouts.landing')
@section('content')
    <section class="padding-medium">
        <div class="container">
            <h2>{{ $title }}</h2>
            <div class="row align-items-center mt-xl-3">
                <p>By booking a tour, purchasing any travel service, or using this website ("the Site"), you agree to be
                    bound by these Terms and Conditions. If you do not agree, please do not use the Site or book any
                    services.</p>

                <h4>1. Definitions</h4>
                <ul>
                    <li><strong>“We”, “Us”, “Our”, “Company”</strong> – [Your Company Name], the tour operator and owner of
                        this Site.</li>
                    <li><strong>“You”, “Customer”, “Guest”</strong> – the person making the booking or any person on whose
                        behalf the booking is made.</li>
                    <li><strong>“Tour”</strong> – any guided tour, day trip, multi-day package, transfer, activity, or other
                        travel service offered on the Site.</li>
                    <li><strong>“Booking”</strong> – a confirmed reservation for a Tour or service.</li>
                </ul>

                <h4>2. Booking & Contract</h4>
                <ul>
                    <li>2.1 A contract is formed only when we send you a written Booking Confirmation (by email or through
                        the Site).</li>
                    <li>2.2 You must be at least 18 years old to make a booking.</li>
                    <li>2.3 You are responsible for providing accurate personal information (names as in passport, contact
                        details, dietary/medical requirements, etc.). Any costs arising from incorrect information will be
                        borne by you.</li>
                </ul>

                <h4>3. Prices & Payment</h4>
                <ul>
                    <li>3.1 Prices are quoted in [currency, e.g., USD/EUR] and are per person unless stated otherwise.</li>
                    <li>3.2 Prices include only what is explicitly listed in the tour description.</li>
                    <li>3.3 Full payment or a deposit (as indicated at checkout) is required at the time of booking. The
                        remaining balance (if any) is due no later than the date specified in the Booking Confirmation.</li>
                    <li>3.4 We reserve the right to correct pricing errors at any time before confirmation. After
                        confirmation, prices are fixed except for the circumstances in clause 4.</li>
                </ul>

                <h4>4. Price Changes & Surcharges</h4>
                <p>We reserve the right to increase the price after booking only in the following cases (with proof provided
                    upon request):</p>
                <ul>
                    <li>Government-imposed taxes, fees, or VAT increases</li>
                    <li>Currency exchange rate fluctuations exceeding 5%</li>
                    <li>Significant fuel price increases</li>
                </ul>
                <p>In such cases, you may either pay the surcharge or cancel with a full refund if the increase exceeds 8%
                    of the total price.</p>

                <h4>5. Cancellation by You</h4>
                <p>Cancellation must be made in writing (email is sufficient). The following charges apply:</p>
                <table border="1" style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th>Period before tour start date</th>
                        <th>Cancellation fee (% of total price)</th>
                    </tr>
                    <tr>
                        <td>More than 60 days</td>
                        <td>Deposit only (non-refundable)</td>
                    </tr>
                    <tr>
                        <td>59–30 days</td>
                        <td>50%</td>
                    </tr>
                    <tr>
                        <td>29–15 days</td>
                        <td>75%</td>
                    </tr>
                    <tr>
                        <td>14 days or less / No-show</td>
                        <td>100%</td>
                    </tr>
                </table>
                <p>Special conditions apply for certain tours (e.g., private charters, peak-season tours, or third-party
                    tickets); these will be stated on the tour page and in your confirmation.</p>

                <h4>6. Cancellation or Changes by Us</h4>
                <ul>
                    <li>6.1 We reserve the right to cancel or significantly modify a tour due to:<br>
                        - Force majeure (war, terrorism, natural disaster, pandemic, etc.)<br>
                        - Insufficient participants (minimum numbers are stated on each tour page)<br>
                        - Any event beyond our reasonable control
                    </li>
                    <li>6.2 In case of cancellation by us before departure, you will receive a full refund or an alternative
                        tour of equal or higher value (if available and accepted by you).</li>
                    <li>6.3 We are not liable for any additional costs you may have incurred (flights, hotels, visas,
                        insurance, etc.).</li>
                </ul>

                <h4>7. Travel Insurance</h4>
                <p>Comprehensive travel insurance (including trip cancellation, medical emergencies, and evacuation) is
                    <strong>mandatory</strong> for all tours. You may be asked to show proof of insurance before the tour
                    starts. We strongly recommend insurance that covers adventure activities if your tour includes them.</p>

                <h4>8. Health, Fitness & Responsibility</h4>
                <ul>
                    <li>8.1 You must inform us of any medical conditions, disabilities, or allergies that may affect your
                        participation.</li>
                    <li>8.2 Some tours require a moderate to high level of fitness. You are responsible for choosing a tour
                        suitable for your abilities.</li>
                    <li>8.3 You participate at your own risk. We are not liable for personal injury or death unless caused
                        by our gross negligence.</li>
                </ul>

                <h4>9. Passports, Visas & Vaccinations</h4>
                <p>You are solely responsible for ensuring you have a valid passport (usually 6 months validity remaining),
                    necessary visas, and required vaccinations/health documents. We can provide general guidance but accept
                    no liability if you are denied entry.</p>

                <h4>10. Behavior & Compliance</h4>
                <ul>
                    <li>10.1 You must follow the instructions of the tour leader/guide at all times.</li>
                    <li>10.2 We may exclude you from the tour (without refund) if your behavior endangers the safety or
                        enjoyment of others, or if you commit an illegal act.</li>
                </ul>

                <h4>11. Liability & Limitation</h4>
                <ul>
                    <li>11.1 Our liability is limited to the price you paid for the tour.</li>
                    <li>11.2 We are not responsible for loss, damage, or delay caused by third-party suppliers (airlines,
                        hotels, local operators) or events outside our control.</li>
                    <li>11.3 We act only as an agent when selling third-party services (e.g., flights, ferries, entrance
                        tickets) and accept no liability for their performance.</li>
                </ul>

                <h4>12. Complaints</h4>
                <p>Any complaint must be reported immediately to the tour leader/guide so we have a chance to remedy it.
                    Formal written complaints must reach us no later than 28 days after the tour ends.</p>

                <h4>13. Images & Marketing</h4>
                <p>We may take photographs or videos during the tour for marketing purposes. By participating, you consent
                    to the use of your image unless you explicitly opt out in writing before the tour starts.</p>

                <h4>14. Privacy</h4>
                <p>Your personal data will be processed in accordance with our Privacy Policy (link at the footer of the
                    Site).</p>

                <h4>15. Governing Law & Jurisdiction</h4>
                <p>These Terms are governed by the laws of [Your Country/Jurisdiction]. Any dispute shall be subject to the
                    exclusive jurisdiction of the courts of [City/Country].</p>

                <h4>16. Changes to Terms</h4>
                <p>We may update these Terms at any time. The version applicable to your booking is the one in force at the
                    time of booking.</p>

            </div>
        </div>
    </section>
@endsection
