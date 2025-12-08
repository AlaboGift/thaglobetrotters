@extends('layouts.landing')
@section('content')
    <section class="padding-medium">
        <div class="container">
            <h2>{{ $title }}</h2>
            <div class="row align-items-center mt-xl-3">
                <h4>1. Information We Collect</h4>
                <p>We collect the following types of information:</p>
                <ul>
                    <li><strong>Personal identification information:</strong> Full name, date of birth, nationality,
                        passport/ID number, phone number, email address, postal address.</li>
                    <li><strong>Booking & travel details:</strong> Tour dates, chosen services, special requests, dietary
                        requirements, medical conditions or mobility needs you voluntarily disclose.</li>
                    <li><strong>Payment information:</strong> Credit/debit card details or other payment method data
                        (processed securely via trusted third-party payment processors – we do not store full card numbers).
                    </li>
                    <li><strong>Technical data:</strong> IP address, browser type, device information, cookies, and usage
                        data when you visit our website.</li>
                    <li><strong>Communication data:</strong> Records of emails, chat messages, or phone calls with our team.
                    </li>
                    <li><strong>Photos & videos:</strong> Images taken during tours (only with your consent or opportunity
                        to opt out).</li>
                </ul>

                <h4>2. How We Collect Your Information</h4>
                <ul>
                    <li>Directly from you when you fill out booking forms, contact forms, or communicate with us.</li>
                    <li>Automatically through cookies and similar technologies when you browse our website.</li>
                    <li>From third parties such as booking platforms, travel agents, or payment providers.</li>
                </ul>

                <h4>3. How We Use Your Information</h4>
                <p>We use your personal data for the following purposes:</p>
                <ul>
                    <li>To process and confirm your booking and provide the requested travel services.</li>
                    <li>To communicate with you about your booking, itinerary changes, or important travel updates.</li>
                    <li>To comply with legal requirements (e.g., immigration, health & safety regulations, or visa support
                        letters).</li>
                    <li>To process payments and issue invoices or refunds.</li>
                    <li>To improve our website, services, and customer experience.</li>
                    <li>To send you marketing communications (only if you have opted in).</li>
                    <li>To create marketing and promotional materials (photos/videos – only if you have not opted out).</li>
                    <li>To prevent fraud and ensure security.</li>
                </ul>

                <h4>4. Legal Basis for Processing (GDPR & similar laws)</h4>
                <ul>
                    <li>Performance of a contract (your booking).</li>
                    <li>Legal obligation (e.g., passenger name records, tax reporting).</li>
                    <li>Legitimate interests (fraud prevention, service improvement, direct marketing where permitted).</li>
                    <li>Consent (for optional marketing emails, photos, or special category data such as health
                        information).</li>
                </ul>

                <h4>5. Who We Share Your Data With</h4>
                <ul>
                    <li>Our trusted local guides, drivers, and partner suppliers who help deliver your tour.</li>
                    <li>Payment processors and IT service providers (all under strict confidentiality agreements).</li>
                    <li>Government authorities when required by law (e.g., immigration, tourism boards).</li>
                    <li>Insurance companies (only if you make a claim through us).</li>
                    <li>Analytics and marketing tools (anonymized data only).</li>
                </ul>
                <p>We never sell your personal data to third parties.</p>

                <h4>6. International Data Transfers</h4>
                <p>Your data may be transferred to and processed in countries outside your country of residence (including
                    countries outside the EEA). We ensure appropriate safeguards are in place (e.g., Standard Contractual
                    Clauses) when transferring data to countries without adequate data protection laws.</p>

                <h4>7. Data Retention</h4>
                <ul>
                    <li>Booking and financial records: 7 years (for tax and accounting purposes).</li>
                    <li>Marketing preferences: Until you unsubscribe.</li>
                    <li>Website logs and cookies: Up to 12 months.</li>
                    <li>Photos/videos: Indefinitely for marketing (unless you withdraw consent).</li>
                </ul>
                <p>After these periods, data is securely deleted or anonymized.</p>

                <h4>8. Your Rights</h4>
                <p>Depending on your location, you may have the right to:</p>
                <ul>
                    <li>Access your personal data</li>
                    <li>Correct inaccurate data</li>
                    <li>Delete your data ("right to be forgotten")</li>
                    <li>Restrict or object to processing</li>
                    <li>Data portability</li>
                    <li>Withdraw consent at any time</li>
                    <li>Lodge a complaint with a supervisory authority</li>
                </ul>
                <p>To exercise any of these rights, please contact us at <a
                        href="mailto:privacy@yourcompany.com">privacy@yourcompany.com</a>.</p>

                <h4>9. Cookies & Tracking</h4>
                <p>Our website uses cookies to improve your experience. You can manage cookie preferences through your
                    browser settings or via the cookie banner on our site. See our separate <strong>Cookie Policy</strong>
                    for details.</p>

                <h4>10. Security</h4>
                <p>We use industry-standard security measures (SSL encryption, secure servers, access controls) to protect
                    your data. However, no online transmission is 100% secure, and we cannot guarantee absolute security.
                </p>

                <h4>11. Children</h4>
                <p>We do not knowingly collect personal information from children under 16 without parental consent. If you
                    are a parent and believe we have collected such information, please contact us immediately.</p>

                <h4>12. Changes to This Policy</h4>
                <p>We may update this Privacy Policy from time to time. The latest version will always be posted on this
                    page with the updated date.</p>

            </div>
        </div>
    </section>
@endsection
